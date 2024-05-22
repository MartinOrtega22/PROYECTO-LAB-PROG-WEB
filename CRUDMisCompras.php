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

$sqlUsuario = "SELECT IdUsuario, NombreUsuario FROM Usuario";
$resultUsuario = $conn->query($sqlUsuario);

$Usuario = [];
if ($resultUsuario->num_rows > 0) {
    while ($row = $resultUsuario->fetch_assoc()) {
        $Usuario[] = $row;
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle Venta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/CRUDSucursales.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
                        echo '<li class="nav-item"><a class="nav-link" href="Nosotros.php" id="M9">Nosotros</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="Sucursales.php" id="M10"><i class="bi bi-geo-alt"></i></a></li>';
                    }
                    if ($rol == "3") {
                        echo '<li class="nav-item"><a class="nav-link" href="CarritoCompras.php" id="M11"><i class="bi bi-cart4"></i></a></li>';
                    }
                    ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <?php
                            if ($rolNombre == "Usuario sin cuenta") {
                                echo '<li><a class="dropdown-item" href="Login.php" id="M12">Iniciar Sesion</a></li>';
                            }
                            if ($rol == "3" || $rol == "2" || $rol == "1") {
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
        <h2>Lista de Detalle Venta</h2>
        <div class="d-flex justify-content-between align-items-center">
            <div class="input-group">
                <span class="input-group-text" id="searchIcon">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" id="searchInput" onkeyup="searchTable()" class="form-control" placeholder="Buscar..." style="flex: 1;">
            </div>
            <button type="button" class="btn btn-primary m-2" id="btnAgregar" data-bs-toggle="modal" data-bs-target="#agregarDetalleVentaModal">Agregar</button>
        </div>

        <!-- Modal Editar -->
        <div class="modal fade" id="editarDetalleVentaModal" tabindex="-1" aria-labelledby="editarDetalleVentaModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editarDetalleVentaModalLabel">Editar Detalle Venta</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formEditarDetalleVenta" action="accionphp/editardetalleventa.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" id="editIdDetalleVenta" name="id">
                            <div class="mb-3">
                                <label for="editIdProducto" class="form-label">ID Producto</label>
                                <input type="text" class="form-control" id="editIdProducto" name="idProducto" required>
                            </div>
                            <div class="mb-3">
                                <label for="editCantidad" class="form-label">Cantidad</label>
                                <input type="number" class="form-control" id="editCantidad" name="cantidad" required>
                            </div>
                            <div class="mb-3">
                                <label for="editSubtotalVenta" class="form-label">Subtotal Venta</label>
                                <input type="number" class="form-control" id="editSubtotalVenta" name="subtotalVenta" required>
                            </div>
                            <div class="mb-3">
                                <label for="editPrecioProducto" class="form-label">Precio Producto</label>
                                <input type="number" class="form-control" id="editPrecioProducto" name="precioProducto" required>
                            </div>
                            <div class="mb-3">
                                <label for="editIdVenta" class="form-label">ID Venta</label>
                                <input type="text" class="form-control" id="editIdVenta" name="idVenta" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" form="formEditarDetalleVenta">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Agregar -->
        <div class="modal fade" id="agregarDetalleVentaModal" tabindex="-1" aria-labelledby="agregarDetalleVentaModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="agregarDetalleVentaModalLabel">Agregar Detalle Venta</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formAgregarDetalleVenta" action="accionphp/agregardetalleventa.php" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="idProducto" class="form-label">ID Producto</label>
                                <input type="text" class="form-control" id="idProducto" name="idProducto" required>
                            </div>
                            <div class="mb-3">
                                <label for="cantidad" class="form-label">Cantidad</label>
                                <input type="number" class="form-control" id="cantidad" name="cantidad" required>
                            </div>
                            <div class="mb-3">
                                <label for="subtotalVenta" class="form-label">Subtotal Venta</label>
                                <input type="number" class="form-control" id="subtotalVenta" name="subtotalVenta" required>
                            </div>
                            <div class="mb-3">
                                <label for="precioProducto" class="form-label">Precio Producto</label>
                                <input type="number" class="form-control" id="precioProducto" name="precioProducto" required>
                            </div>
                            <div class="mb-3">
                                <label for="idVenta" class="form-label">ID Venta</label>
                                <input type="text" class="form-control" id="idVenta" name="idVenta" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" form="formAgregarDetalleVenta">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

        <table class="table" id="dataTable">
            <thead>
                <tr>
                    <th>ID Venta</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Subtotal Venta</th>
                    <th>Precio Producto</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT p.NombreProducto, dv.Cantidad, dv.SubtotalVenta, dv.PrecioProducto, dv.IdVenta, dv.IdProducto
        FROM detalleventa dv
        JOIN producto p ON dv.IdProducto = p.IdProducto";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["IdVenta"] . "</td>";
                        echo "<td>" . $row["NombreProducto"] . "</td>";
                        echo "<td>" . $row["Cantidad"] . "</td>";
                        echo "<td>" . $row["SubtotalVenta"] . "</td>";
                        echo "<td>" . $row["PrecioProducto"] . "</td>";
                        echo '<td><a href="#" class="btn btn-primary editar-btn" data-bs-toggle="modal" data-bs-target="#editarDetalleVentaModal" data-id="' . $row["IdProducto"] . '"><i class="bi bi-pencil"></i></a>';
                        echo '<button data-id="' . $row["IdProducto"] . '" class="btn btn-danger eliminar-btn"><i class="bi bi-trash"></i></button></td>';
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No se encontraron resultados</td></tr>";
                }
                $conn->close();
                ?>

            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="js/CRUDDetalleVenta.js"></script>
</body>

</html>