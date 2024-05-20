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

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Inicio</title>
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
    <div class="container mt-5">
        <h1>Bienvenido <?php echo $_SESSION['usuario'];   ?></h1>
    </div>
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="./img/farmaCarrusel1.jpg" class="d-block w-100" alt="Imagen 1">
                </div>
                <div class="carousel-item">
                    <img src="./img/farmaCarrusel2.jpg" class="d-block w-100" alt="Imagen 2">
                </div>
                <div class="carousel-item">
                    <img src="./img/farmaCarrusel3.jpg" class="d-block w-100" alt="Imagen 3">
                </div>
                <div class="carousel-item">
                    <img src="./img/farmaCarrusel4.jpg" class="d-block w-100" alt="Imagen 3">
                </div>
                <div class="carousel-item">
                    <img src="./img/farmaCarrusel5.jpg" class="d-block w-100" alt="Imagen 3">
                </div>
                <div class="carousel-item">
                    <img src="./img/far1.jpg" class="d-block w-100" alt="Imagen 3">
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Anterior</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Siguiente</span>
            </a>
        </div>

        <div class="container my-5">
            <h1>Buena Medicina para la Buena Salud</h1>
            <p>Farmacia Mi Salud está comprometida con tu bienestar. Encuentra aquí todo lo que necesitas para cuidar tu salud y la de tu familia.</p>
            <a href="CatalogoProductos.html" class="btn btn-primary">Ver productos</a>
        </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>