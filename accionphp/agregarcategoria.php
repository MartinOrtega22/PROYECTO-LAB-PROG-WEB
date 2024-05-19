<?php
$host = "localhost";
$usuario = "root";
$contra = "12345678";
$bd = "farmacia";

$conn = new mysqli($host, $usuario, $contra, $bd);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$descripcionCategoria = $_POST['descripcion'];

$sql = "INSERT INTO categorias (DescripcionCategoria) VALUES ('$descripcionCategoria')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true, 'message' => 'Categoría guardada correctamente']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al guardar la categoría']);
}

$conn->close();
