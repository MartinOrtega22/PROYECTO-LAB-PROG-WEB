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
    die(json_encode(['success' => false, 'message' => 'Error de conexión: ' . $conn->connect_error]));
}

// Verificar que los datos del formulario estén presentes
if (isset($_POST['id']) && isset($_POST['nombreSucursal']) && isset($_POST['direccionSucursal']) && isset($_POST['telefonoSucursal']) && isset($_POST['idUsuario']) && isset($_POST['fechaAlta'])) {
    $idSucursal = $_POST['id'];
    $nombreSucursal = $_POST['nombreSucursal'];
    $direccionSucursal = $_POST['direccionSucursal'];
    $telefonoSucursal = $_POST['telefonoSucursal'];
    $idUsuario = $_POST['idUsuario'];
    $fechaAlta = $_POST['fechaAlta'];

    $sql = "UPDATE sucursal SET NombreSucursal = ?, DireccionSucursal = ?, TelefonoSucursal = ?, IdUsuario = ?, FechaAlta = ? WHERE IdSucursal = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssissi", $nombreSucursal, $direccionSucursal, $telefonoSucursal, $idUsuario, $fechaAlta);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Sucursal actualizada correctamente']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar la sucursal: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
}

$conn->close();
