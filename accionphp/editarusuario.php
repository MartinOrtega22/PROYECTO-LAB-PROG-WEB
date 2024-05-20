<?php
$host = "localhost";
$usuario = "root";
$contra = "12345678";
$bd = "farmacia";

$conn = new mysqli($host, $usuario, $contra, $bd);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Error de conexión: ' . $conn->connect_error]));
}

if (isset($_POST['id']) && isset($_POST['nombreUsuario']) && isset($_POST['direccionUsuario']) && isset($_POST['correoUsuario']) && isset($_POST['telefonoUsuario']) && isset($_POST['rolUsuario'])) {
    $idUsuario = $_POST['id'];
    $nombreUsuario = $_POST['nombreUsuario'];
    $direccionUsuario = $_POST['direccionUsuario'];
    $correoUsuario = $_POST['correoUsuario'];
    $telefonoUsuario = $_POST['telefonoUsuario'];
    $rolUsuario = $_POST['rolUsuario'];


    if (isset($_POST['contrasenaUsuario']) && !empty($_POST['contrasenaUsuario'])) {
        $contrasenaUsuario = password_hash($_POST['contrasenaUsuario'], PASSWORD_DEFAULT);
        $sql = "UPDATE usuario SET NombreUsuario = ?, DireccionUsuario = ?, CorreoUsuario = ?, TelefonoUsuario = ?, RolUsuario = ?, ContrasenaUsuario = ? WHERE IdUsuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssissi", $nombreUsuario, $direccionUsuario, $correoUsuario, $telefonoUsuario, $rolUsuario, $contrasenaUsuario, $idUsuario);
    } else {
        $sql = "UPDATE usuario SET NombreUsuario = ?, DireccionUsuario = ?, CorreoUsuario = ?, TelefonoUsuario = ?, RolUsuario = ? WHERE IdUsuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssii", $nombreUsuario, $direccionUsuario, $correoUsuario, $telefonoUsuario, $rolUsuario, $idUsuario);
    }

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Usuario actualizado correctamente']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar el usuario: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
}

$conn->close();
