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
if (isset($_POST['id']) && isset($_POST['nombreProducto']) && isset($_POST['descripcionProducto']) && isset($_POST['precioProducto']) && isset($_POST['categoriaProducto'])) {
    $idProducto = $_POST['id'];
    $nombreProducto = $_POST['nombreProducto'];
    $descripcionProducto = $_POST['descripcionProducto'];
    $precioProducto = $_POST['precioProducto'];
    $categoriaProducto = $_POST['categoriaProducto'];

    // Manejar la imagen del producto si se ha subido
    if (isset($_FILES['imagenProducto']) && $_FILES['imagenProducto']['size'] > 0) {
        $imagenProducto = file_get_contents($_FILES['imagenProducto']['tmp_name']);
        $sql = "UPDATE producto SET NombreProducto = ?, DescripcionProducto = ?, PrecioProducto = ?, CategoriaProducto = ?, ImagenProducto = ? WHERE IdProducto = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdisi", $nombreProducto, $descripcionProducto, $precioProducto, $categoriaProducto, $imagenProducto, $idProducto);
    } else {
        $sql = "UPDATE producto SET NombreProducto = ?, DescripcionProducto = ?, PrecioProducto = ?, CategoriaProducto = ? WHERE IdProducto = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssdi", $nombreProducto, $descripcionProducto, $precioProducto, $categoriaProducto, $idProducto);
    }

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Producto actualizado correctamente']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar el producto: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
}

$conn->close();
