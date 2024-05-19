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
    $idCategoria = $_GET['id'];
    $sql = "SELECT IdCategoria, DescripcionCategoria FROM categorias WHERE IdCategoria = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo json_encode(['error' => 'Error en la preparación de la consulta']);
        exit();
    }

    $stmt->bind_param("i", $idCategoria);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $categoria = $result->fetch_assoc();
        echo json_encode([
            'IdCategoria' => $categoria['IdCategoria'],
            'DescripcionCategoria' => $categoria['DescripcionCategoria']
        ]);
    } else {
        echo json_encode(['error' => 'Categoría no encontrada']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'ID de Categoría no proporcionado']);
}

$conn->close();
