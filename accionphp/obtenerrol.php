<?php
$host = "localhost";
$usuario = "root";
$contra = "12345678";
$bd = "farmacia";

$conn = new mysqli($host, $usuario, $contra, $bd);

if ($conn->connect_error) {
    die(json_encode(['error' => 'Error de conexión: ' . $conn->connect_error]));
}

if (isset($_GET['id'])) {
    $idRolUsuario = $_GET['id'];
    $sql = "SELECT IdRol, DescripcionRol FROM rol WHERE IdRol = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo json_encode(['error' => 'Error en la preparación de la consulta']);
        exit();
    }

    $stmt->bind_param("i", $idRolUsuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $rolUsuario = $result->fetch_assoc();
        echo json_encode($rolUsuario);
    } else {
        echo json_encode(['error' => 'Rol de Usuario no encontrado']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'ID de Rol de Usuario no proporcionado']);
}

$conn->close();
