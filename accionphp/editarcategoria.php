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
    $idCategoria = $_POST['id'];
    $descripcionCategoria = $_POST['descripcion'];

    $sql = "UPDATE categorias SET DescripcionCategoria = ? WHERE IdCategoria = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $descripcionCategoria, $idCategoria);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Categoria actualizada correctamente']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar la categoria: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
}

$conn->close();
