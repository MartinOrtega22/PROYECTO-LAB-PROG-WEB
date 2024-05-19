<?php
$host = "localhost";
$usuario = "root";
$contra = "12345678";
$bd = "farmacia";

$conn = new mysqli($host, $usuario, $contra, $bd);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_POST['contrasenaUsuario'] != $_POST['contrasenaUsuarioValidar']) {
    echo json_encode(['success' => true, 'message' => 'Las contraseñas no coinciden, intentelo nuevamente']);
    return;
}


$idUsuario = $_POST['idUsuario'];
$nombreUsuario = $_POST['nombreUsuario'];
$direccionUsuario = $_POST['direccionUsuario'];
$correoUsuario = $_POST['correoUsuario'];
$telefonoUsuario = $_POST['telefonoUsuario'];
$rolUsuario = $_POST['rolUsuario'];
$contrasenaUsuario = $_POST['contrasenaUsuario'];

$sql = "INSERT INTO Usuario (NombreUsuario, DireccionUsuario, CorreoUsuario, TelefonoUsuario, RolUsuario, ContrasenaUsuario)
        VALUES ('$nombreUsuario', '$direccionUsuario', '$correoUsuario', '$telefonoUsuario', '$rolUsuario', '$contrasenaUsuario')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true, 'message' => 'Usuario guardado correctamente']);
} else {
    echo json_encode(['success' => false, 'message' => 'El ID del usuario ya existe']);
}


$conn->close();
