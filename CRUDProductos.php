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

// Obtener categorías
$sqlCategorias = "SELECT idcategoria, descripcioncategoria FROM categorias";
$resultCategorias = $conn->query($sqlCategorias);

$categorias = [];
if ($resultCategorias->num_rows > 0) {
    while ($row = $resultCategorias->fetch_assoc()) {
        $categorias[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/CRUDProductos.css">
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
                    if ($rol == "1") {
                        echo '<li class="nav-item"><a class="nav-link" href="CRUDSucursales.php" id="M2">Administrar Sucursales</a></li>';
                    }
                    if ($rol == "1" || $rol == "2") {
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
        <h2>Lista de Productos</h2>
        <div class="d-flex justify-content-between align-items-center">
            <div class="input-group">
                <span class="input-group-text" id="searchIcon">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" id="searchInput" onkeyup="searchTable()" class="form-control" placeholder="Buscar..." style="flex: 1;">
            </div>
            <button type="button" class="btn btn-primary m-2" id="btnAgregar" data-bs-toggle="modal" data-bs-target="#agregarProductoModal">Agregar</button>
        </div>
        <!-- Modal para editar -->
        <div class="modal fade" id="editarProductoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar Producto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formEditarProducto" action="accionphp/editarproducto.php" method="post" enctype="multipart/form-data">
                            <input type="text" id="editIdProducto" name="id">
                            <div class="mb-3">
                                <label for="editNombreProducto" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="editNombreProducto" name="nombreProducto" required>
                            </div>
                            <div class="mb-3">
                                <label for="editDescripcionProducto" class="form-label">Descripción</label>
                                <input type="text" class="form-control" id="editDescripcionProducto" name="descripcionProducto" required>
                            </div>
                            <div class="mb-3">
                                <label for="editPrecioProducto" class="form-label">Precio</label>
                                <input type="number" class="form-control" id="editPrecioProducto" name="precioProducto" required>
                            </div>
                            <div class="mb-3">
                                <label for="editCategoriaProducto" class="form-label">Categoría</label>
                                <select class="form-control" id="editCategoriaProducto" name="categoriaProducto" required>
                                    <option value="">Selecciona una categoría</option>
                                    <?php foreach ($categorias as $categoria) : ?>
                                        <option value="<?php echo $categoria['idcategoria']; ?>"><?php echo $categoria['descripcioncategoria']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editImagenProducto" class="form-label">Imagen del Producto</label>
                                <input type="file" class="form-control" id="editImagenProducto" name="imagenProducto">
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

        <!-- Modal para agregar -->
        <div class="modal fade" id="agregarProductoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Producto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formAgregarProducto" action="accionphp/agregarproducto.php" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="idProducto" class="form-label">ID Producto</label>
                                <input type="number" class="form-control" id="idProducto" name="idProducto" required>
                            </div>
                            <div class="mb-3">
                                <label for="nombreProducto" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombreProducto" name="nombreProducto" required>
                            </div>
                            <div class="mb-3">
                                <label for="descripcionProducto" class="form-label">Descripción</label>
                                <input type="text" class="form-control" id="descripcionProducto" name="descripcionProducto" required>
                            </div>
                            <div class="mb-3">
                                <label for="precioProducto" class="form-label">Precio</label>
                                <input type="number" class="form-control" id="precioProducto" name="precioProducto" required>
                            </div>
                            <div class="mb-3">
                                <label for="categoriaProducto" class="form-label">Categoría</label>
                                <select class="form-control" id="categoriaProducto" name="categoriaProducto" required>
                                    <option value="">Selecciona una categoría</option>
                                    <?php foreach ($categorias as $categoria) : ?>
                                        <option value="<?php echo $categoria['idcategoria']; ?>"><?php echo $categoria['descripcioncategoria']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="imagenProducto" class="form-label">Imagen del Producto</label>
                                <input type="file" class="form-control" id="imagenProducto" name="imagenProducto" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" form="formAgregarProducto">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

        <table class="table" id="dataTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Categoría</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <?php
            $sql = "SELECT IdProducto, NombreProducto, DescripcionProducto, PrecioProducto, DescripcionCategoria, ImagenProducto FROM producto JOIN categorias WHERE CategoriaProducto=IdCategoria";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["IdProducto"] . "</td>";
                    echo "<td>" . $row["NombreProducto"] . "</td>";
                    echo "<td>" . $row["DescripcionProducto"] . "</td>";
                    echo "<td>" . $row["PrecioProducto"] . "</td>";
                    echo "<td>" . $row["DescripcionCategoria"] . "</td>";
                    echo "<td><img class='col-6' src='data:image/jpeg;base64," . base64_encode($row["ImagenProducto"]) . "' width='50' height='50'></td>";
                    echo '<td><a href="#" class="btn btn-primary editar-btn" data-bs-toggle="modal" data-bs-target="#editarProductoModal" data-id="' . $row["IdProducto"] . '"><i class="bi bi-pencil"></i></a>';
                    echo '<button data-id="' . $row["IdProducto"] . '" class="btn btn-danger eliminar-btn"><i class="bi bi-trash"></i></button></td>';
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
    <script src="js/CRUDProducto.js"></script>
</body>

</html>