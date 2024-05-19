<?php
$host = "localhost";
$usuario = "root";
$contra = "12345678";
$bd = "farmacia";

$conn = new mysqli($host, $usuario, $contra, $bd);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if (isset($_POST['idUsuario'])) {
    $idProducto = $_POST['idUsuario'];

    $sql = "DELETE FROM usuario WHERE idUsuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idProducto);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Error al eliminar el usuario: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'ID de usuario no proporcionado']);
}

$conn->close();
