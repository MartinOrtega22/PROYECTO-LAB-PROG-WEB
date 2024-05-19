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
$idProducto = $_POST['idProducto'];
$nombreProducto = $_POST['nombreProducto'];
$descripcionProducto = $_POST['descripcionProducto'];
$precioProducto = $_POST['precioProducto'];
$categoriaProducto = $_POST['categoriaProducto'];
$imagenProducto = addslashes(file_get_contents($_FILES['imagenProducto']['tmp_name']));

// Insertar nuevo producto
$sql = "INSERT INTO producto (IdProducto, NombreProducto, DescripcionProducto, PrecioProducto, CategoriaProducto, ImagenProducto)
        VALUES ('$idProducto', '$nombreProducto', '$descripcionProducto', '$precioProducto', '$categoriaProducto', '$imagenProducto')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true, 'message' => 'Producto guardado correctamente']);
} else {
    echo json_encode(['success' => false, 'message' => 'El ID del producto ya existe']);
}

$conn->close();
