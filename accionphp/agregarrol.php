<?php
$host = "localhost";
$usuario = "root";
$contra = "12345678";
$bd = "farmacia";

$conn = new mysqli($host, $usuario, $contra, $bd);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$descripcionRol = $_POST['descripcion'];

$sql = "INSERT INTO rol (DescripcionRol) VALUES ('$descripcionRol')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true, 'message' => 'Rol guardado correctamente']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al guardar el rol']);
}

$conn->close();
