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

// Obtener lista de usuarios
$sqlUsuario = "SELECT IdUsuario, NombreUsuario FROM Usuario";
$resultUsuario = $conn->query($sqlUsuario);
$Usuario = [];
if ($resultUsuario->num_rows > 0) {
    while ($row = $resultUsuario->fetch_assoc()) {
        $Usuario[] = $row;
    }
}

// Obtener lista de estatus de ventas
$sqlEstatus = "SELECT IdEstatus, DescripcionEstatus FROM EstatusVenta";
$resultEstatus = $conn->query($sqlEstatus);
$Estatus = [];
if ($resultEstatus->num_rows > 0) {
    while ($row = $resultEstatus->fetch_assoc()) {
        $Estatus[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/login.css">

    <link rel="stylesheet" href="css/CRUDSucursales.css">
</head>

<body>
    <!-- MENU -->
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
                        echo '<li class="nav-item"><a class="nav-link" href="#" id="M9">Nosotros</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="Sucursales.php" id="M10"><i class="bi bi-geo-alt"></i></a></li>';
                    }
                    if ($rol == "3") {
                        echo '<li class="nav-item"><a class="nav-link" href="#" id="M11"><i class="bi bi-cart4"></i></a></li>';
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
        <h2>Reporte de Ventas</h2>
        <section class="row mb-6">
            <div class="col-md-6">
                <div class="input-group mb-6">
                    <span class="input-group-text mb-2" id="searchIcon">
                        <i class="bi bi-search"></i>
                    </span>
                    <!-- <input type="text" id="searchInput" onkeyup="searchTable()" class="form-control" placeholder="Buscar..." style="flex: 1;"> -->
                    <input type="date" class="form-control form-control-sm mb-2" id="fecha-inicio" name="fecha-inicio">
                    <input type="date" class="form-control form-control-sm mb-2" id="fecha-fin" name="fecha-fin">
                    <button class="btn btn-primary m-2" type="button" id="search-button">Buscar</button>
                </div>
            </div>
        </section>

        <!-- Modal Editar -->
        <div class="modal fade" id="editarVentaModal" tabindex="-1" aria-labelledby="editarVentaModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editarVentaModalLabel">Editar Venta</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formEditarVenta" action="accionphp/editarventa.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" id="editIdVenta" name="id">
                            <div class="mb-3">
                                <label for="editFechaVenta" class="form-label">Fecha</label>
                                <input type="datetime-local" class="form-control" id="editFechaVenta" name="fechaVenta" required>
                            </div>
                            <div class="mb-3">
                                <label for="editEstatusVenta" class="form-label">Estatus</label>
                                <select class="form-control" id="editEstatusVenta" name="estatusVenta" required>
                                    <option value="">Selecciona el Estatus</option>
                                    <?php foreach ($Estatus as $e) : ?>
                                        <option value="<?php echo $e['IdEstatus']; ?>"><?php echo $e['NombreEstatus']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editTotalVenta" class="form-label">Total</label>
                                <input type="number" class="form-control" id="editTotalVenta" name="totalVenta" required>
                            </div>
                            <div class="mb-3">
                                <label for="editUsuario" class="form-label">Usuario</label>
                                <select class="form-control" id="editUsuario" name="Usuario" required>
                                    <option value="">Selecciona el Usuario</option>
                                    <?php foreach ($Usuario as $r) : ?>
                                        <option value="<?php echo $r['IdUsuario']; ?>"><?php echo $r['NombreUsuario']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" form="formEditarVenta">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Agregar -->
        <div class="modal fade" id="agregarVentaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Venta</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formAgregarVenta" action="accionphp/agregarventa.php" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="fechaVenta" class="form-label">Fecha</label>
                                <input type="datetime-local" class="form-control" id="fechaVenta" name="fechaVenta" required>
                            </div>
                            <div class="mb-3">
                                <label for="estatusVenta" class="form-label">Estatus</label>
                                <select class="form-control" id="estatusVenta" name="estatusVenta" required>
                                    <option value="">Selecciona el Estatus</option>
                                    <?php foreach ($Estatus as $e) : ?>
                                        <option value="<?php echo $e['IdEstatus']; ?>"><?php echo $e['NombreEstatus']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="totalVenta" class="form-label">Total</label>
                                <input type="number" class="form-control" id="totalVenta" name="totalVenta" required>
                            </div>
                            <div class="mb-3">
                                <label for="Usuario" class="form-label">Usuario</label>
                                <select class="form-control" id="Usuario" name="Usuario" required>
                                    <option value="">Selecciona el Usuario</option>
                                    <?php foreach ($Usuario as $r) : ?>
                                        <option value="<?php echo $r['IdUsuario']; ?>"><?php echo $r['NombreUsuario']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" form="formAgregarVenta">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

        <table class="table" id="dataTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Estatus</th>
                    <th>Total</th>
                    <th>Usuario</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT v.IdVenta, v.FechaVenta, e.DescripcionEstatus, v.TotalVenta, u.NombreUsuario 
                        FROM venta v 
                        JOIN usuario u ON v.IdUsuario = u.IdUsuario 
                        JOIN EstatusVenta e ON v.EstatusVenta = e.IdEstatus";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["IdVenta"] . "</td>";
                        echo "<td>" . $row["FechaVenta"] . "</td>";
                        echo "<td>" . $row["DescripcionEstatus"] . "</td>";
                        echo "<td>" . $row["TotalVenta"] . "</td>";
                        echo "<td>" . $row["NombreUsuario"] . "</td>";
                        echo '<td><a href="#" class="btn btn-primary editar-btn" data-bs-toggle="modal" data-bs-target="#editarVentaModal" data-id="' . $row["IdVenta"] . '"><i class="bi bi-pencil"></i></a>';
                        echo '</td>';
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No se encontraron resultados</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
        <div class="text-end">
            <strong>Total:</strong> <span id="totalSuma">0</span>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="js/CRUDVentas.js"></script>
    <script>
        $(document).ready(function() {
            calcularSumaTotal();
        });

        // Función para calcular la suma de la columna "Total"
        function calcularSumaTotal() {
            var suma = 0;
            $('#dataTable tbody tr').each(function() {
                var total = parseFloat($(this).find('td:eq(3)').text());
                if (!isNaN(total)) {
                    suma += total;
                }
            });
            $('#totalSuma').text(suma.toFixed(2)); // Mostrar la suma con dos decimales
        }
    </script>
</body>

</html>