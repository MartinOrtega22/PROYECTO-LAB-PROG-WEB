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
    <link rel="stylesheet" href="css/CRUDProductos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.0/font/bootstrap-icons.css">
</head>

<body>
    <ul class="nav justify-content-end">
        <li class="nav-item">
            <a class="nav-link" aria-current="page" href="#">Sucursales</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Productos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Nosotros</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#"><i class="bi bi-geo-alt"></i></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#"><i class="bi bi-cart4"></i></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#"><i class="bi bi-person-circle"></i></a>
        </li>
    </ul>

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
                            <input type="hidden" id="editIdProducto" name="id">
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