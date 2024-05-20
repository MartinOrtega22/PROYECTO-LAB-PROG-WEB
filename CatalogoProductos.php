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

$sqlCategorias = "SELECT IdCategoria, DescripcionCategoria FROM categorias";
$rcat = $conexion->query($sqlCategorias);

$categorias = [];
if ($rcat->num_rows > 0) {
    while ($row = $rcat->fetch_assoc()) {
        $categorias[] = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/login.css">

    <link rel="stylesheet" href="css/CatalogoProductos.css">
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

        <br>
        <h2 style="text-align: center">Catálogo de productos</h2>
        <input type="text">
        <button type="button" class="btn btn-primary">Buscar</button>

        <!-- MODAL DETALLE -->
        <div class="modal fade" id="detalleProductoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Producto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formEditarProducto" action="accionphp/editarproducto.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" id="editIdProducto" name="id">
                            <div class="mb-3">
                                <label for="editNombreProducto" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="editNombreProducto" name="nombreProducto" required disabled>
                            </div>
                            <div class="mb-3">
                                <label for="editDescripcionProducto" class="form-label">Descripción</label>
                                <input type="text" class="form-control" id="editDescripcionProducto" name="descripcionProducto" required disabled>
                            </div>
                            <div class="mb-3">
                                <label for="editPrecioProducto" class="form-label">Precio</label>
                                <input type="number" class="form-control" id="editPrecioProducto" name="precioProducto" required disabled>
                            </div>
                            <div class="mb-3">
                                <label for="editCategoriaProducto" class="form-label">Categoría</label>
                                <select class="form-control" id="editCategoriaProducto" name="categoriaProducto" required disabled>
                                    <option value="">Selecciona una categoría</option>
                                    <?php foreach ($categorias as $categoria) : ?>
                                        <option value="<?php echo $categoria['IdCategoria']; ?>"><?php echo $categoria['DescripcionCategoria']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <!-- <label for="editImagenProducto" class="form-label">Imagen del Producto</label>
                                <input type="file" class="form-control" id="editImagenProducto" name="imagenProducto"> -->
                                <img id="editImagenPreview" class="col-12" src="" alt="Imagen del Producto" style="display: none;">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" form="formEditarProducto">Guardar Cambios</button>
                    </div>
                </div>
            </div>
        </div>

        <?php


        // Consulta para obtener los productos
        $consulta = "SELECT IdProducto, NombreProducto, DescripcionProducto, PrecioProducto, DescripcionCategoria, ImagenProducto FROM producto JOIN categorias WHERE CategoriaProducto=IdCategoria";

        $resultado = $conexion->query($consulta);

        // Mostrar los productos
        if ($resultado->num_rows > 0) {
            echo '<div class="row row-cols-3">';
            while ($row = $resultado->fetch_assoc()) {
                echo '<div class="col mb-4 mt-4">';
                echo '<div class="card">';
                echo '<img src="data:image/jpeg;base64,' . base64_encode($row['ImagenProducto']) . '" class="card-img-top" alt="' . $row['NombreProducto'] . '">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $row['NombreProducto'] . '</h5>';
                echo '<p class="card-text">Codigo: ' . $row['IdProducto'] . '</p>';
                echo '<p class="card-text">' . $row['DescripcionProducto'] . '</p>';
                echo '<p class="card-text">Categoría: ' . $row['DescripcionCategoria'] . '</p>';
                echo '<td><a href="#" class="btn btn-primary editar-btn" data-bs-toggle="modal" data-bs-target="#detalleProductoModal" data-id="' . $row["IdProducto"] . '">Ver detalle</i></a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo '<p>No hay productos disponibles.</p>';
        }

        $conexion->close();
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {

            $('.editar-btn').click(function() {
                var idProducto = $(this).data('id');

                if (!idProducto) {
                    console.error('ID de producto no proporcionado');
                    return;
                }

                $.ajax({
                    url: 'accionphp/obtenerproducto.php',
                    type: 'GET',
                    data: {
                        idProducto: idProducto
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.error) {
                            console.error('Error:', data.error);
                        } else {
                            $('#editIdProducto').val(data.IdProducto);
                            $('#editNombreProducto').val(data.NombreProducto);
                            $('#editDescripcionProducto').val(data.DescripcionProducto);
                            $('#editPrecioProducto').val(data.PrecioProducto);
                            $('#editCategoriaProducto').val(data.CategoriaProducto);

                            if (data.ImagenProducto) {
                                $('#editImagenPreview').attr('src', 'data:image/jpeg;base64,' + data.ImagenProducto).show();
                            } else {
                                $('#editImagenPreview').hide();
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error en la solicitud AJAX:', status, error);
                        console.error('Respuesta del servidor:', xhr.responseText);
                    }
                });
            });
        });
    </script>
</body>

</html>