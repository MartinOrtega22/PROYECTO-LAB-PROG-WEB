<?php
session_start();

if (!isset($_SESSION['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Usuario no autenticado']);
    exit;
}

$idUsuarioLogueado = $_SESSION['id'];
$fechaVenta = date('Y-m-d H:i:s');
$estatusVenta = 'Completada'; // Puedes ajustar este valor según tus necesidades

// Variables base de datos
$host = "localhost";
$usuario = "root";
$contra = "12345678";
$bd = "farmacia";

// Conexión
$conn = new mysqli($host, $usuario, $contra, $bd);

// Verificar conexión
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Error de conexión: ' . $conn->connect_error]);
    exit;
}

// Iniciar transacción
$conn->begin_transaction();

try {
    // Insertar en tabla venta
    $sqlVenta = "INSERT INTO venta (FechaVenta, EstatusVenta, TotalVenta, IdUsuario) VALUES (?, ?, ?, ?)";
    $stmtVenta = $conn->prepare($sqlVenta);

    // Calcular total de la venta
    $totalVenta = 0;
    $sqlCarrito = "SELECT c.IdProducto, c.Cantidad, c.PrecioProducto, (c.Cantidad * c.PrecioProducto) AS SubtotalProducto 
                   FROM carrito c 
                   WHERE c.IdUsuario = ?";
    $stmtCarrito = $conn->prepare($sqlCarrito);
    $stmtCarrito->bind_param("i", $idUsuarioLogueado);
    $stmtCarrito->execute();
    $resultCarrito = $stmtCarrito->get_result();

    $carritoItems = [];
    while ($row = $resultCarrito->fetch_assoc()) {
        $totalVenta += $row['SubtotalProducto'];
        $carritoItems[] = $row;
    }

    // Insertar venta
    $stmtVenta->bind_param("ssdi", $fechaVenta, $estatusVenta, $totalVenta, $idUsuarioLogueado);
    $stmtVenta->execute();
    $idVenta = $stmtVenta->insert_id;

    // Insertar en tabla detalle_venta
    $sqlDetalleVenta = "INSERT INTO detalle_venta (IdProducto, Cantidad, SubtotalVenta, PrecioProducto, IdVenta) VALUES (?, ?, ?, ?, ?)";
    $stmtDetalleVenta = $conn->prepare($sqlDetalleVenta);

    foreach ($carritoItems as $item) {
        $stmtDetalleVenta->bind_param("iidii", $item['IdProducto'], $item['Cantidad'], $item['SubtotalProducto'], $item['PrecioProducto'], $idVenta);
        $stmtDetalleVenta->execute();
    }

    // Limpiar el carrito después de la venta
    $sqlLimpiarCarrito = "DELETE FROM carrito WHERE IdUsuario = ?";
    $stmtLimpiarCarrito = $conn->prepare($sqlLimpiarCarrito);
    $stmtLimpiarCarrito->bind_param("i", $idUsuarioLogueado);
    $stmtLimpiarCarrito->execute();

    // Confirmar transacción
    $conn->commit();

    echo json_encode(['status' => 'success', 'message' => 'Venta generada correctamente']);
} catch (Exception $e) {
    // Revertir transacción en caso de error
    $conn->rollback();
    echo json_encode(['status' => 'error', 'message' => 'Error al generar la venta: ' . $e->getMessage()]);
} finally {
    $stmtVenta->close();
    $stmtCarrito->close();
    $stmtDetalleVenta->close();
    $stmtLimpiarCarrito->close();
    $conn->close();
}
