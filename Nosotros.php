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
    <title>Nosotros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/NosotrosS.css">
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

        <h1 class="encabezado-nosotros">Nosotros</h1>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 p-3 d-flex justify-content-center align-items-center">
                    <div class="info-left">
                        <h3 class="titulocards">Servicios que Ofrecemos</h3>
                        <p class="textcards">
                            <strong>Dispensación de Medicamentos:</strong> Proveemos una amplia gama de medicamentos
                            recetados y de venta libre.
                        </p>
                        <p class="textcards">
                            <strong>Productos de Salud y Bienestar: </strong> Ofrecemos una variedad de productos para el
                            cuidado personal, suplementos nutricionales, productos de bebés y equipos médicos.
                            Todos nuestros productos son seleccionados con cuidado para asegurar su calidad y eficacia.
                        </p>
                        <p class="textcards">
                            <strong>Entrega a Domicilio:</strong> Para tu comodidad, ofrecemos un servicio de entrega a
                            domicilio rápido y confiable.
                            Entendemos que en ocasiones no puedes salir de casa, por lo que llevamos tus medicamentos y
                            productos de salud directamente a tu puerta.
                        </p>
                        <p class="textcards">Email: farmaciamisalud@gmail.com</p>
                    </div>
                </div>

                <div class="col-md-6 info-center p-3 infomedio">
                    <br> <br> <br> <br>
                    <h3 class="titulocards">Nuestra Historia:</h3>
                    <p class="textcards">
                        En Farmacia Mi Salud, nos enorgullecemos de ser una farmacia local comprometida con la salud y el
                        bienestar de nuestra comunidad.
                        Fundada recién en el 2024, hemos estado contentos de servir a nuestros clientes con mucha dedicación
                        y profesionalismo.
                        <br> <br>
                    </p>
                    <p class="textcards">
                        Nuestra visión es aspirar a ser la farmacia líder en nuestra comunidad, reconocida por nuestro
                        compromiso con la excelencia,
                        la innovación y el servicio al cliente. Nos esforzamos por crear un entorno donde cada cliente se
                        sienta valorado y cuidado.
                        <br> <br>
                    </p>
                    <p class="textcards">
                        Nuestra misión es proporcionar medicamentos y productos de salud de la más alta calidad, ofreciendo
                        un servicio excepcional y personalizado a cada uno de nuestros clientes.
                        Nos esforzamos por ser el primer recurso de salud para nuestra comunidad, ofreciendo asesoramiento
                        experto y atención farmacéutica de confianza.
                        <br> <br>
                    </p>
                    <p class="textcards">
                        Nos mantenemos actualizados con las últimas tecnologías y avances en el campo de la farmacia para
                        ofrecerte los mejores servicios y productos.
                        Implementamos sistemas modernos de gestión de medicamentos y adopción de nuevas prácticas para
                        mejorar la eficiencia y seguridad de nuestro servicio.
                        <br> <br>
                    </p>
                </div>

                <div class="col-md-3 info-right p-3">
                    <img src="./img/imagenfarmacia.jpg" alt="Imagen de Producto 1">
                    <img src="img/imagenfarmacia2.jpg" alt="Imagen de Producto 2">
                    <img src="img/imagenfarmacia3.jpg" alt="Imagen de Producto 3">
                </div>

            </div>
        </div>
    </div>
    </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>