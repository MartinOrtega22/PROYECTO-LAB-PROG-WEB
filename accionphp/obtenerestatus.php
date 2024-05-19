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
    $idEstatus = $_GET['id'];
    $sql = "SELECT IdEstatus, DescripcionEstatus FROM estatusventa WHERE IdEstatus = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo json_encode(['error' => 'Error en la preparación de la consulta']);
        exit();
    }

    $stmt->bind_param("i", $idEstatus);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $estatus = $result->fetch_assoc();
        echo json_encode($estatus);
    } else {
        echo json_encode(['error' => 'Estatus no encontrado']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'ID de Estatus no proporcionado']);
}

$conn->close();
