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
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/login.css">

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
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="Index.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="CRUDSucursales.php">Administrar Sucursales</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="CRUDProductos.php">Administrar Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="CRUDUsuarios.php">Administrar Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="CRUDSecundarias.php">Administrar Secundarias</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="ReporteVenta.php">Reporte de Ventas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="CRUDMisCompras.php">Mis Compras</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="CatalogoProductos.php">Catálogo Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Nosotros</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Sucursales.php"><i class="bi bi-geo-alt"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="bi bi-cart4"></i></a>
                    </li>
                    <li class="nav-item">

                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Iniciar Sesion</a></li>
                            <li><a class="dropdown-item" href="#">Cambiar Contraseña</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Cerrar Sesion</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5 bg-white p-4 mx-1 rounded border inicio full-height">
                <div class="w-100">
                    <h1>Iniciar sesión</h1>
                    <img src="img/login.jpg" class="col-4 m-3"><br>
                    <form id="formulario-login" method="post" action="autenticar.php">
                        <div class=" mb-3">
                            <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="Contraseña" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Iniciar sesión</button>
                    </form>
                    </form>
                </div>
            </div>
            <div class="separador d-none d-md-block"></div>
            <div class="col-md-5 bg-white p-4 mx-1 rounded border registro full-height">
                <div class="w-100">
                    <h2>BIENVENIDO</h2>
                    <h4>¿No tienes una cuenta? Regístrate</h4><br>
                    <button type="button" class="btn btn-primary m-2" id="btnAgregar" data-bs-toggle="modal" data-bs-target="#agregarUsuarioModal">Crea Una Cuenta</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para agregar -->
    <div class="modal fade" id="agregarUsuarioModal" tabindex="-1" aria-labelledby="agregarUsuarioModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agregarUsuarioModalLabel">Crear Cuenta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formAgregarUsuario" action="accionphp/agregarlogin.php" method="post" enctype="multipart/form-data">
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
                                <option value="3">Cliente</option>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        $('#formAgregarUsuario').submit(function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: 'accionphp/agregarlogin.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        location.reload();
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error en la solicitud AJAX:', status, error);
                    console.error('Respuesta del servidor:', xhr.responseText);
                }
            });
        });
    </script>
</body>

</html>