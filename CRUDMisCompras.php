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
    <title>Mis compras</title>
    <link rel="stylesheet" href="css/CRUDMisCompras.css">
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


        <h2>Mis compras</h2>
        <section class="row mb-3">
            <div class="col-md-12">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="product-search" placeholder="Buscar producto"><br>
                    <input type="date" class="form-control form-control-sm" id="fecha-inicio" name="fecha-inicio">
                    <input type="date" class="form-control form-control-sm" id="fecha-fin" name="fecha-fin">
                    <button class="btn btn-primary" type="button" id="search-button">Buscar</button>
                </div>
            </div>
        </section>

        <table class="table">
            <tr>
                <th>N° de pedido</th>
                <th>Fecha</th>
                <th>Productos</th>
                <th>Dirección de envío</th>
                <th>Estatus</th>
                <th>Precio total del pedido</th>
            </tr>
            <?php
            // Si se hace clic en el botón Buscar, obtener los pedidos con los filtros
            if (isset($_GET['product-search']) && isset($_GET['fecha-inicio']) && isset($_GET['fecha-fin'])) {
                $productoBusqueda = $_GET['product-search'];
                $fechaInicio = $_GET['fecha-inicio'];
                $fechaFin = $_GET['fecha-fin'];

                // Consultar SQL para obtener pedidos con los filtros
                $sql = "SELECT * FROM venta 
                        JOIN usuario ON venta.IdUsuario = usuario.IdUsuario
                        JOIN sucursal ON venta.IdSucursal = sucursal.IdSucursal
                        JOIN estatusventa ON venta.IdEstatusVenta = estatusventa.IdEstatus
                        WHERE venta.FechaVenta";

                $sql = "SELECT * FROM venta 
            JOIN usuario ON venta.IdUsuario = usuario.IdUsuario
            JOIN sucursal ON venta.IdSucursal = sucursal.IdSucursal
            JOIN estatusventa ON venta.IdEstatusVenta = estatusventa.IdEstatus
            WHERE venta.FechaVenta BETWEEN '$fechaInicio' AND '$fechaFin'";
            } else {
                $sql = "SELECT * FROM venta 
            JOIN usuario ON venta.IdUsuario = usuario.IdUsuario
            JOIN sucursal ON venta.IdSucursal = sucursal.IdSucursal
            JOIN estatusventa ON venta.IdEstatusVenta = estatusventa.IdEstatus";
            }

            $result = $db->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $idVenta = $row['IdVenta'];
                    $fechaVenta = $row['FechaVenta'];
                    $subtotalVenta = $row['#SubtotalVenta'];
                    $totalVenta = $row['#TotalVenta'];
                    $idUsuario = $row['IdUsuario'];
                    $nombreUsuario = $row['NombreUsuario'];
                    $idSucursal = $row['IdSucursal'];
                    $nombreSucursal = $row['Nombre Sucursal'];
                    $descripcionEstatus = $row['Descripcion Estatus'];

                    echo "<tr>";
                    echo "<td>$idVenta</td>";
                    echo "<td>$fechaVenta</td>";
                    echo "<td>$$subtotalVenta</td>";
                    echo "<td>$$totalVenta</td>";
                    echo "<td>$idUsuario</td>";
                    echo "<td>$nombreUsuario</td>";
                    echo "<td>$idSucursal</td>";
                    echo "<td>$nombreSucursal</td>";
                    echo "<td>$descripcionEstatus</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9'>No se encontraron pedidos</td></tr>";
            }

            $db->close();
            ?>
        </table>



    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>

</html>