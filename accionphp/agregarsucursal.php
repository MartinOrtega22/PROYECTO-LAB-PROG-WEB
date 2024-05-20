<?php
// Variables base de datos
$host = "localhost";
$usuario = "root";
$contra = "12345678";
$bd = "farmacia";

// Conexión
$conn = new mysqli($host, $usuario, $contra, $bd);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener datos del formulario
$nombreSucursal = $_POST['nombreSucursal'];
$direccionSucursal = $_POST['direccionSucursal'];
$telefonoSucursal = $_POST['telefonoSucursal'];
$idUsuario = $_POST['Usuario'];
$fechaAlta = $_POST['fechaAlta'];

// Insertar nueva sucursal
$sql = "INSERT INTO sucursal (nombreSucursal, direccionSucursal, telefonoSucursal, idUsuario, fechaAlta)
        VALUES ('$nombreSucursal', '$direccionSucursal', '$telefonoSucursal', '$idUsuario', '$fechaAlta')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true, 'message' => 'Sucursal guardada correctamente']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al guardar la sucursal']);
}

$conn->close();
