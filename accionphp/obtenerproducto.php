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
    die(json_encode(['error' => 'Error de conexión: ' . $conn->connect_error]));
}

if (isset($_GET['idProducto'])) {
    $idProducto = $_GET['idProducto'];
    $sql = "SELECT IdProducto, NombreProducto, DescripcionProducto, PrecioProducto, CategoriaProducto, ImagenProducto FROM producto WHERE IdProducto = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo json_encode(['error' => 'Error en la preparación de la consulta']);
        exit();
    }

    $stmt->bind_param("i", $idProducto);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $producto = $result->fetch_assoc();

        if (!empty($producto['ImagenProducto'])) {
            $producto['ImagenProducto'] = base64_encode($producto['ImagenProducto']);
        }

        echo json_encode($producto);
    } else {
        echo json_encode(['error' => 'Producto no encontrado']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'ID de producto no proporcionado']);
}

$conn->close();
?>
