<?php
// Variables base de datos
$host = "localhost";
$usuario = "root";
$contra = "12345678";
$bd = "farmacia";

// Conexión
$conn = new mysqli($host, $usuario, $contra, $bd);

// Verificar conexión
if ($conn->connect_error) {
    die(json_encode(['error' => 'Error de conexión: ' . $conn->connect_error]));
}

if (isset($_GET['idSucursal'])) {
    $idSucursal = $_GET['idSucursal'];
    $sql = "SELECT NombreSucursal, DireccionSucursal, TelefonoSucursal, IdUsuario, FechaAlta FROM sucursal WHERE IdSucursal = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo json_encode(['error' => 'Error en la preparación de la consulta']);
        exit();
    }

    $stmt->bind_param("i", $idSucursal);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $sucursal = $result->fetch_assoc();
        echo json_encode($sucursal);
    } else {
        echo json_encode(['error' => 'Sucursal no encontrada']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'ID de sucursal no proporcionado']);
}

$conn->close();
