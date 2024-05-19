<?php
$host = "localhost";
$usuario = "root";
$contra = "12345678";
$bd = "farmacia";

$conn = new mysqli($host, $usuario, $contra, $bd);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Error de conexión: ' . $conn->connect_error]));
}

if (isset($_POST['id']) && isset($_POST['descripcion'])) {
    $idEstatus = $_POST['id'];
    $descripcionEstatus = $_POST['descripcion'];

    $sql = "UPDATE estatusventa SET DescripcionEstatus = ? WHERE IdEstatus = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $descripcionEstatus, $idEstatus);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Estatus actualizado correctamente']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar el estatus: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
}

$conn->close();
