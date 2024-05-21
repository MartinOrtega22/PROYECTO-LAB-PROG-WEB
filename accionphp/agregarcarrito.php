<?php
session_start();

// Configuración de la conexión a la base de datos
$host = "localhost";
$usuario = "root";
$contra = "12345678";
$bd = "farmacia";

// Conexión
$conn = new mysqli($host, $usuario, $contra, $bd);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener datos del formulario y validar
$idus = isset($_POST['idUsuario']) ? intval($_POST['idUsuario']) : null;
$idprod = isset($_POST['id']) ? intval($_POST['id']) : null;
$cantidad = isset($_POST['cantidadProducto']) ? intval($_POST['cantidadProducto']) : null;
$fecha = isset($_POST['fechaAlta']) ? $_POST['fechaAlta'] : null;
$precio = isset($_POST['precioProducto']) ? floatval($_POST['precioProducto']) : null;

if ($idus === null || $idprod === null || $cantidad === null || $fecha === null || $precio === null) {
    echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios']);
    $conn->close();
    exit();
}

// Convertir fecha al formato correcto
$dateTime = DateTime::createFromFormat('Y-m-d\TH:i', $fecha);
if ($dateTime) {
    $fecha = $dateTime->format('Y-m-d H:i:s');
} else {
    echo json_encode(['success' => false, 'message' => 'Formato de fecha incorrecto']);
    $conn->close();
    exit();
}

// Preparar la consulta
$sql = "INSERT INTO carrito (IdUsuario, IdProducto, Cantidad, Fecha, PrecioProducto) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Error al preparar la declaración: ' . $conn->error]);
    $conn->close();
    exit();
}

// Enlazar parámetros
$stmt->bind_param("iiisd", $idus, $idprod, $cantidad, $fecha, $precio);

// Ejecutar la consulta
if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Producto añadido al carrito correctamente']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al guardar el producto en el carrito: ' . $stmt->error]);
}

// Cerrar la declaración y la conexión
$stmt->close();
$conn->close();
