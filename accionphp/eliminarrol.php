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
    $idRol = $_POST['id'];

    $sql = "DELETE FROM rol WHERE IdRol = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idRol);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Rol eliminado correctamente']);
    } else {
        echo json_encode(['error' => 'Error al eliminar el rol: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'ID de rol no proporcionado']);
}

$conn->close();
