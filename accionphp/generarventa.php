<?php
session_start();

if (!isset($_SESSION['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Usuario no autenticado']);
    exit;
}

$idUsuarioLogueado = $_SESSION['id'];
$fechaVenta = date('Y-m-d H:i:s');
$estatusVenta = 'Completada';

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

$conn->begin_transaction();

try {
    $sqlVenta = "INSERT INTO venta (FechaVenta, EstatusVenta, TotalVenta, IdUsuario) VALUES (?, ?, ?, ?)";
    $stmtVenta = $conn->prepare($sqlVenta);
    if (!$stmtVenta) {
        throw new Exception("Error en prepare stmtVenta: " . $conn->error);
    }

    $totalVenta = 0;
    $sqlCarrito = "SELECT c.IdProducto, c.Cantidad, c.PrecioProducto, (c.Cantidad * c.PrecioProducto) AS SubtotalProducto 
                   FROM carrito c 
                   WHERE c.IdUsuario = ?";
    $stmtCarrito = $conn->prepare($sqlCarrito);
    if (!$stmtCarrito) {
        throw new Exception("Error en prepare stmtCarrito: " . $conn->error);
    }
    $stmtCarrito->bind_param("i", $idUsuarioLogueado);
    $stmtCarrito->execute();
    $resultCarrito = $stmtCarrito->get_result();

    $carritoItems = [];
    while ($row = $resultCarrito->fetch_assoc()) {
        $totalVenta += $row['SubtotalProducto'];
        $carritoItems[] = $row;
    }

    if (empty($carritoItems)) {
        throw new Exception('Carrito vacío');
    }

    // Mensaje de depuración: imprimir totalVenta y carritoItems
    error_log("Total Venta: $totalVenta");
    error_log("Carrito Items: " . json_encode($carritoItems));

    $stmtVenta->bind_param("ssdi", $fechaVenta, $estatusVenta, $totalVenta, $idUsuarioLogueado);
    if (!$stmtVenta->execute()) {
        throw new Exception("Error en execute stmtVenta: " . $stmtVenta->error);
    }
    $idVenta = $stmtVenta->insert_id;

    $sqlDetalleVenta = "INSERT INTO detalleventa (IdProducto, Cantidad, SubtotalVenta, PrecioProducto, IdVenta) VALUES (?, ?, ?, ?, ?)";
    $stmtDetalleVenta = $conn->prepare($sqlDetalleVenta);
    if (!$stmtDetalleVenta) {
        throw new Exception("Error en prepare stmtDetalleVenta: " . $conn->error);
    }

    foreach ($carritoItems as $item) {
        $stmtDetalleVenta->bind_param("iidii", $item['IdProducto'], $item['Cantidad'], $item['SubtotalProducto'], $item['PrecioProducto'], $idVenta);
        if (!$stmtDetalleVenta->execute()) {
            throw new Exception("Error en execute stmtDetalleVenta: " . $stmtDetalleVenta->error);
        }
    }

    $sqlLimpiarCarrito = "DELETE FROM carrito WHERE IdUsuario = ?";
    $stmtLimpiarCarrito = $conn->prepare($sqlLimpiarCarrito);
    if (!$stmtLimpiarCarrito) {
        throw new Exception("Error en prepare stmtLimpiarCarrito: " . $conn->error);
    }
    $stmtLimpiarCarrito->bind_param("i", $idUsuarioLogueado);
    if (!$stmtLimpiarCarrito->execute()) {
        throw new Exception("Error en execute stmtLimpiarCarrito: " . $stmtLimpiarCarrito->error);
    }

    $conn->commit();

    echo json_encode(['status' => 'success', 'message' => 'Venta generada correctamente']);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['status' => 'error', 'message' => 'Error al generar la venta: ' . $e->getMessage()]);
} finally {
    $stmtVenta->close();
    $stmtCarrito->close();
    $stmtDetalleVenta->close();
    $stmtLimpiarCarrito->close();
    $conn->close();
}
