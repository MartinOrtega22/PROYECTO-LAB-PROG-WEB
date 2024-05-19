<?php
$host = "localhost";
$usuario = "root";
$contra = "12345678";
$bd = "farmacia";

$conn = new mysqli($host, $usuario, $contra, $bd);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if (isset($_POST['id'])) {
    $idCategoria = $_POST['id'];

    $sql = "DELETE FROM categorias WHERE IdCategoria = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idCategoria);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Categoría eliminada correctamente']);
    } else {
        echo json_encode(['error' => 'Error al eliminar la categoría: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'ID de categoría no proporcionado']);
}

$conn->close();
