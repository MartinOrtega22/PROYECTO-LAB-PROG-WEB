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
    $idEstatus = $_POST['id'];

    $sql = "DELETE FROM estatusventa WHERE IdEstatus = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idEstatus);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Estatus eliminado correctamente']);
    } else {
        echo json_encode(['error' => 'Error al eliminar el estatus: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'ID de estatus no proporcionado']);
}

$conn->close();
