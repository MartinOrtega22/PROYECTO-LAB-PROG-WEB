<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de productos</title>
    <link rel="stylesheet" href="css/CatalogoProductos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.0/font/bootstrap-icons.css">
</head>

<body>
    <div class="container">
        <ul class="nav justify-content-end">
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="#">Sucursales</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Productos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Nosotros</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="bi bi-geo-alt"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="bi bi-cart4"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="bi bi-person-circle"></i></i></a>
            </li>
        </ul>

        <?php
        // Configuración de la conexión a la base de datos
        $host = "localhost";
        $usuario = "root";
        $contra = "12345678";
        $bd = "farmacia";

        // Conexión
        $conexion = new mysqli($host, $usuario, $contra, $bd);

        // VerificA conexión
        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        // Consulta para obtener los productos
        $consulta = "SELECT IdProducto, NombreProducto, DescripcionProducto, PrecioProducto, DescripcionCategoria AS CategoriaProducto, ImagenProducto
                     FROM producto
                     INNER JOIN categorias ON CategoriaProducto = IdCategoria";
        $resultado = mysqli_query($conexion, $consulta);

        // Mostrar los productos
        if (mysqli_num_rows($resultado) > 0) {
            echo '<div class="row row-cols-3">';
            while ($producto = mysqli_fetch_assoc($resultado)) {
                echo '<div class="col mb-4">';
                echo '<div class="card">';
                echo '<img src="' . $producto['ImagenProducto'] . '" class="card-img-top" alt="' . $producto['NombreProducto'] . '">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $producto['NombreProducto'] . '</h5>';
                echo '<p class="card-text">' . $producto['DescripcionProducto'] . '</p>';
                echo '<p class="card-text">Categoría: ' . $producto['CategoriaProducto'] . '</p>';
                echo '<a href="#" class="btn btn-primary">Ver detalle</a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo '<p>No hay productos disponibles.</p>';
        }

        $conexion->close();
        ?>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

</body>

</html>