<?php
$host = "localhost";
$usuario = "root";
$contra = "12345678";
$bd = "farmacia";

$conn = new mysqli($host, $usuario, $contra, $bd);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombreUsuario'];
    $direccion = $_POST['direccionUsuario'];
    $correo = $_POST['correoUsuario'];
    $telefono = $_POST['telefonoUsuario'];
    $rol = $_POST['rolUsuario'];
    $contrasena = $_POST['contrasenaUsuario'];
    $contrasenaValidar = $_POST['contrasenaUsuarioValidar'];

    // Validar contraseñas
    if ($contrasena !== $contrasenaValidar) {
        echo json_encode(['success' => false, 'message' => 'Las contraseñas no coinciden.']);
        exit();
    }

    $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

    // Insertar usuario
    $sql = "INSERT INTO usuario (nombreUsuario, direccionUsuario, correoUsuario, telefonoUsuario, rolUsuario, contrasenaUsuario) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $nombre, $direccion, $correo, $telefono, $contrasena_hash, $rol);
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssis", $nombre, $direccion, $correo, $telefono, $rol, $contrasena_hash);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Usuario registrado exitosamente.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al registrar usuario: ' . $stmt->error]);
    }

    $stmt->close();
}

$conn->close();
