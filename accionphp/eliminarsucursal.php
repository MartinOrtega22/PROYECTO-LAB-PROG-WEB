<?php
$host = "localhost";
$usuario = "root";
$contra = "12345678";
$bd = "farmacia";

$conn = new mysqli($host, $usuario, $contra, $bd);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if (isset($_POST['idSucursal'])) {
    $idSucursal = $_POST['idSucursal'];

    $sql = "DELETE FROM sucursal WHERE idSucursal = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idSucursal);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Error al eliminar la sucursal: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'ID de sucursal no proporcionado']);
}

$conn->close();
