<?php
session_start();

if (!isset($_SESSION['correo'])) {

    $_SESSION['rol'] = "0";
}


$roles = [
    "0" => "Usuario sin cuenta",
    "1" => "Administrador",
    "2" => "Empleado",
    "3" => "Cliente"
];

$rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : "0"; // Asignar rol de "Usuario sin cuenta"


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
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php
                    // Obtener el rol actual del usuario
                    $rolNombre = $roles[$rol];

                    if ($rolNombre == "Usuario sin cuenta" || $rol == "3" || $rol == "2" || $rol == "1") {
                        echo '<li class="nav-item"><a class="nav-link active" aria-current="page" href="Index.php" id="M1">Inicio</a></li>';
                    }
                    if ($rol == "1" || $rol == "2") {
                        echo '<li class="nav-item"><a class="nav-link" href="CRUDSucursales.php" id="M2">Administrar Sucursales</a></li>';
                    }
                    if ($rol == "1") {
                        echo '<li class="nav-item"><a class="nav-link" href="CRUDProductos.php" id="M3">Administrar Productos</a></li>';
                    }
                    if ($rol == "1") {
                        echo '<li class="nav-item"><a class="nav-link" href="CRUDUsuarios.php" id="M4">Administrar Usuarios</a></li>';
                    }
                    if ($rol == "1") {
                        echo '<li class="nav-item"><a class="nav-link" href="CRUDSecundarias.php" id="M5">Administrar Secundarias</a></li>';
                    }
                    if ($rol == "1" || $rol == "2") {
                        echo '<li class="nav-item"><a class="nav-link" href="ReporteVenta.php" id="M6">Reporte de Ventas</a></li>';
                    }
                    if ($rol == "3") {
                        echo '<li class="nav-item"><a class="nav-link" href="CRUDMisCompras.php" id="M7">Mis Compras</a></li>';
                    }
                    if ($rolNombre == "Usuario sin cuenta" || $rol == "3" || $rol == "2" || $rol == "1") {
                        echo '<li class="nav-item"><a class="nav-link" href="CatalogoProductos.php" id="M8">Catálogo Productos</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="#" id="M9">Nosotros</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="Sucursales.php" id="M10"><i class="bi bi-geo-alt"></i></a></li>';
                    }
                    if ($rol == "3") {
                        echo '<li class="nav-item"><a class="nav-link" href="#" id="M11"><i class="bi bi-cart4"></i></a></li>';
                    }
                    ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="bi bi-person-circle"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <?php
                            if ($rolNombre == "Usuario sin cuenta") {
                                echo '<li><a class="dropdown-item" href="Login.php" id="M12">Iniciar Sesion</a></li>';
                            }
                            if ($rol == "3" || $rol == "2" || $rol == "1") {
                                echo '<li><a class="dropdown-item" href="#" id="M13">Cambiar Contraseña</a></li>';
                                echo '<li><hr class="dropdown-divider"></li>';
                                echo '<li><a class="dropdown-item" href="accionphp/logout.php" id="M14">Cerrar Sesion</a></li>';
                            }
                            ?>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <div class="container">


        <h2>Mis compras</h2>
        <section class="row mb-6">
            <div class="col-md-6">
                <div class="input-group mb-6">
                    <span class="input-group-text" id="searchIcon">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" id="searchInput" onkeyup="searchTable()" class="form-control"
                        placeholder="Buscar..." style="flex: 1;">
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