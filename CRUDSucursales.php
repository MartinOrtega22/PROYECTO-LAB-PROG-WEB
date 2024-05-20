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
    die("Error de conexión: " . $conexion->connect_error);
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
    <title>Sucursales</title>
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
        <h2>Lista de Sucursales</h2>
        <div class="d-flex justify-content-between align-items-center">
            <div class="input-group">
                <span class="input-group-text" id="searchIcon">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" id="searchInput" onkeyup="searchTable()" class="form-control" placeholder="Buscar..." style="flex: 1;">
            </div>
            <button type="button" class="btn btn-primary m-2" id="btnAgregar" data-bs-toggle="modal" data-bs-target="#agregarSucursalModal">Agregar</button>
        </div>

        <!-- Modal Editar -->
        <div class="modal fade" id="editarSucursalModal" tabindex="-1" aria-labelledby="editarSucursalModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editarSucursalModalLabel">Editar Sucursal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formEditarSucursal" action="accionphp/editarsucursal.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" id="editIdSucursal" name="id">
                            <div class="mb-3">
                                <label for="editnombreSucursal" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="editnombreSucursal" name="nombreSucursal" required>
                            </div>
                            <div class="mb-3">
                                <label for="editdireccionSucursal" class="form-label">Dirección</label>
                                <input type="text" class="form-control" id="editdireccionSucursal" name="direccionSucursal" required>
                            </div>
                            <div class="mb-3">
                                <label for="edittelefonoSucursal" class="form-label">Teléfono</label>
                                <input type="number" class="form-control" id="edittelefonoSucursal" name="telefonoSucursal" required>
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
                            <div class="mb-3">
                                <label for="editfechaAlta" class="form-label">Fecha</label>
                                <input type="datetime-local" class="form-control" id="editfechaAlta" name="fechaAlta" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" form="formEditarSucursal">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal agregar -->
        <div class="modal fade" id="agregarSucursalModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Sucursal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formAgregarSucursal" action="accionphp/agregarsucursal.php" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="nombreSucursal" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombreSucursal" name="nombreSucursal" required>
                            </div>
                            <div class="mb-3">
                                <label for="direccionSucursal" class="form-label">Dirección</label>
                                <input type="text" class="form-control" id="direccionSucursal" name="direccionSucursal" required>
                            </div>
                            <div class="mb-3">
                                <label for="telefonoSucursal" class="form-label">Teléfono</label>
                                <input type="number" class="form-control" id="telefonoSucursal" name="telefonoSucursal" required>
                            </div>
                            <div class="mb-3">
                                <label for="Usuario" class="form-label">Usuario</label>
                                <select class="form-control" id="Usuario" name="Usuario" required>
                                    <option value="<?php echo $_SESSION['id']; ?>"><?php echo $_SESSION['usuario']; ?></option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="fechaAlta" class="form-label">Fecha</label>
                                <input type="datetime-local" class="form-control" id="fechaAlta" name="fechaAlta" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" form="formAgregarSucursal">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
        <table class="table">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Usuario</th>
                <th>Fecha de Alta</th>
                <th>Acciones</th>
            </tr>
            <?php
            $sql = "SELECT IdSucursal, NombreSucursal, DireccionSucursal, TelefonoSucursal, NombreUsuario, FechaAlta FROM sucursal s join usuario u where s.IdUsuario=u.IdUsuario";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["IdSucursal"] . "</td>";
                    echo "<td>" . $row["NombreSucursal"] . "</td>";
                    echo "<td>" . $row["DireccionSucursal"] . "</td>";
                    echo "<td>" . $row["TelefonoSucursal"] . "</td>";
                    echo "<td>" . $row["NombreUsuario"] . "</td>";
                    echo "<td>" . $row["FechaAlta"] . "</td>";
                    echo '<td><a href="#" class="btn btn-primary editar-btn" data-bs-toggle="modal" data-bs-target="#editarSucursalModal" data-id="' . $row["IdSucursal"] . '"><i class="bi bi-pencil"></i></a>';
                    echo '<button data-id="' . $row["IdSucursal"] . '" class="btn btn-danger eliminar-btn"><i class="bi bi-trash"></i></button></td>';
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No se encontraron resultados</td></tr>";
            }
            $conn->close();
            ?>
        </table>
    </div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="js/CRUDSucursal.js"></script>
</body>

</html>