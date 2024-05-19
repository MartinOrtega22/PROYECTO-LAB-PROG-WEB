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
    $idRol = $_POST['id'];
    $descripcionRol = $_POST['descripcion'];

    $sql = "UPDATE rol SET DescripcionRol = ? WHERE IdRol = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $descripcionRol, $idRol);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Rol actualizado correctamente']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar el rol: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
}

$conn->close();
