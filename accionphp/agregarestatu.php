<?php
$host = "localhost";
$usuario = "root";
$contra = "12345678";
$bd = "farmacia";

$conn = new mysqli($host, $usuario, $contra, $bd);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$descripcionEstatus = $_POST['descripcion'];

$sql = "INSERT INTO estatusventa (DescripcionEstatus) VALUES ('$descripcionEstatus')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true, 'message' => 'Estatus guardado correctamente']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al guardar el estatus']);
}

$conn->close();
