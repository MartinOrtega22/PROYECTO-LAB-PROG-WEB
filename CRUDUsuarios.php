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

$sqlRol = "SELECT IdRol, DescripcionRol FROM Rol";
$resultRol = $conn->query($sqlRol);

$rols = [];
if ($resultRol->num_rows > 0) {
    while ($row = $resultRol->fetch_assoc()) {
        $rols[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/CRUDUsuarios.css">
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
        <h2>Lista de Usuarios</h2>
        <div class="d-flex justify-content-between align-items-center">
            <div class="input-group">
                <span class="input-group-text" id="searchIcon">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" id="searchInput" onkeyup="searchTable()" class="form-control" placeholder="Buscar..." style="flex: 1;">
            </div>
            <button type="button" class="btn btn-primary m-2" id="btnAgregar" data-bs-toggle="modal" data-bs-target="#agregarUsuarioModal">Agregar</button>
        </div>

        <!-- Modal para editar -->
        <div class="modal fade" id="editarUsuarioModal" tabindex="-1" aria-labelledby="editarUsuarioModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editarUsuarioModalLabel">Editar Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formEditarUsuario" action="accionphp/editarusuario.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" id="editIdUsuario" name="id">
                            <div class="mb-3">
                                <label for="editNombreUsuario" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="editNombreUsuario" name="nombreUsuario" required>
                            </div>
                            <div class="mb-3">
                                <label for="editDireccionUsuario" class="form-label">Direccion</label>
                                <input type="text" class="form-control" id="editDireccionUsuario" name="direccionUsuario" required>
                            </div>
                            <div class="mb-3">
                                <label for="editCorreoUsuario" class="form-label">Correo</label>
                                <input type="email" class="form-control" id="editCorreoUsuario" name="correoUsuario" required>
                            </div>
                            <div class="mb-3">
                                <label for="editTelefonoUsuario" class="form-label">Telefono</label>
                                <input type="number" class="form-control" id="editTelefonoUsuario" name="telefonoUsuario" required>
                            </div>
                            <div class="mb-3">
                                <label for="editRolUsuario" class="form-label">Rol</label>
                                <select class="form-control" id="editRolUsuario" name="rolUsuario" required>
                                    <option value="">Selecciona el rol</option>
                                    <?php foreach ($rols as $r) : ?>
                                        <option value="<?php echo $r['IdRol']; ?>"><?php echo $r['DescripcionRol']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editContrasenaUsuario" class="form-label">Contrasena</label>
                                <input type="text" class="form-control" id="editContrasenaUsuario" name="contrasenaUsuario" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" form="formEditarUsuario">Guardar Cambios</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para agregar -->
        <div class="modal fade" id="agregarUsuarioModal" tabindex="-1" aria-labelledby="agregarUsuarioModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="agregarUsuarioModalLabel">Agregar Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formAgregarUsuario" action="accionphp/agregarusuario.php" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="nombreUsuario" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombreUsuario" name="nombreUsuario" required>
                            </div>
                            <div class="mb-3">
                                <label for="direccionUsuario" class="form-label">Direccion</label>
                                <input type="text" class="form-control" id="direccionUsuario" name="direccionUsuario" required>
                            </div>
                            <div class="mb-3">
                                <label for="correoUsuario" class="form-label">Correo</label>
                                <input type="email" class="form-control" id="correoUsuario" name="correoUsuario" required>
                            </div>
                            <div class="mb-3">
                                <label for="telefonoUsuario" class="form-label">Telefono</label>
                                <input type="number" class="form-control" id="telefonoUsuario" name="telefonoUsuario" required>
                            </div>
                            <div class="mb-3">
                                <label for="rolUsuario" class="form-label">Rol</label>
                                <select class="form-control" id="rolUsuario" name="rolUsuario" required>
                                    <option value="">Selecciona el rol</option>
                                    <?php foreach ($rols as $r) : ?>
                                        <option value="<?php echo $r['IdRol']; ?>"><?php echo $r['DescripcionRol']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="ContrasenaUsuario" class="form-label">Contrasena</label>
                                <input type="password" class="form-control" id="ContrasenaUsuario" name="contrasenaUsuario" required>
                            </div>
                            <div class="mb-3">
                                <label for="ContrasenaUsuarioValidar" class="form-label">Validar Contraseña</label>
                                <input type="password" class="form-control" id="ContrasenaUsuarioValidar" name="contrasenaUsuarioValidar" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" form="formAgregarUsuario">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

        <table class="table" id="dataTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT IdUsuario, NombreUsuario, DireccionUsuario, CorreoUsuario, TelefonoUsuario, DescripcionRol FROM usuario JOIN rol ON RolUsuario=IdRol";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["IdUsuario"] . "</td>";
                        echo "<td>" . $row["NombreUsuario"] . "</td>";
                        echo "<td>" . $row["DireccionUsuario"] . "</td>";
                        echo "<td>" . $row["CorreoUsuario"] . "</td>";
                        echo "<td>" . $row["TelefonoUsuario"] . "</td>";
                        echo "<td>" . $row["DescripcionRol"] . "</td>";
                        echo '<td><a href="#" class="btn btn-primary editar-btn" data-bs-toggle="modal" data-bs-target="#editarUsuarioModal" data-id="' . $row["IdUsuario"] . '"><i class="bi bi-pencil"></i></a>';
                        echo '<button data-id="' . $row["IdUsuario"] . '" class="btn btn-danger eliminar-btn"><i class="bi bi-trash"></i></button></td>';
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No se encontraron resultados</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="js/CRUDUsuario.js"></script>
</body>

</html>