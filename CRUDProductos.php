<?php
// Variables base de datos
$host = "localhost";
$usuario = "root";
$contra = "12345678";
$bd = "farmacia";

// Conexión
$conn = new mysqli($host, $usuario, $contra, $bd);

// VerificA conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Productos</title>
    <link rel="stylesheet" href="css/CRUDProductos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.0/font/bootstrap-icons.css">

</head>

<body>
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

    <div class="container">


        <h2>Lista de Productos</h2>
        <input type="text">
        <button type="button" class="btn btn-primary">Buscar</button>

        <a href="agregar.php" class="btnAgregar">Agregar productos</a>
        <table class="table">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Categoría</th>
                <th>Acciones</th>
            </tr>
            <?php
            $sql = "SELECT IdProducto, NombreProducto, DescripcionProducto, PrecioProducto, CategoriaProducto FROM producto";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["IdProducto"] . "</td>";
                    echo "<td>" . $row["NombreProducto"] . "</td>";
                    echo "<td>" . $row["DescripcionProducto"] . "</td>";
                    echo "<td>" . $row["PrecioProducto"] . "</td>";
                    echo "<td>" . $row["CategoriaProducto"] . "</td>";
                    echo '<td><a href="editar.php?id=' . $row["IdProducto"] . '" id="btnEditar"><img src="img/editar.png"></a>  <a href="eliminar.php?id=' . $row["IdProducto"] . '" id="btnEliminar"><img src="img/eliminar.png"></a></td>';
                    echo "</tr>";
                }
            } else {
                echo "0 resultados";
            }
            $conn->close();
            ?>
        </table>



    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>

</html>