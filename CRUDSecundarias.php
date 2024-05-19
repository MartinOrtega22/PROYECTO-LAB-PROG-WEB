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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Tablas Secundarias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/CRUDProductos.css">
</head>

<body>
    <ul class="nav justify-content-end mb-4">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Inicio</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" aria-current="page" href="CRUDSucursales.php">Administrar Sucursales</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="CRUDProductos.php">Administrar Productos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="CRUDUsuarios.php">Administrar Usuarios</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="CRUDSecundarias.php">Administrar Secundarias</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="ReporteVenta.php">Reporte de Ventas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="CRUDMisCompras.php">Mis Compras</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="CatalogoProductos.php">Catalogo Productos</a>
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
            <a class="nav-link" href="#"><i class="bi bi-person-circle"></i></a>
        </li>
    </ul>



    <div class="container">

        <div class="row">
            <p class="h5 text-muted">Seleccione la tabla secundaria que desea modificar:</p>
            <ul class="list-group list-group-horizontal shadow-sm text-center">
                <li class="col-4 d-block ">
                    <a class="list-group-item " href="#" onclick="showSection('categoriasSeccion')">Categorias</a>
                </li>
                <li class="col-4 d-block">
                    <a class="list-group-item " href="#" onclick="showSection('estatusventaSeccion')">Estatus de las Ventas</a>
                </li>
                <li class="col-4 d-block">
                    <a class="list-group-item " href="#" onclick="showSection('rolUsuarioSeccion')">Rol de los Usuarios</a>
                </li>
            </ul>
        </div>


        <div id="categoriasSeccion" class="seccion">
            <h2>Categorías</h2>
            <div class="d-flex justify-content-between align-items-center">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" id="searchInputCategorias" class="form-control" placeholder="Buscar..." onkeyup="searchTable('dataTableCategorias', 'searchInputCategorias')">
                </div>
                <button class="btn btn-primary m-2 btnAgregar" data-bs-toggle="modal" data-bs-target="#agregarCategoriaModal">Agregar</button>
            </div>
            <table class="table" id="dataTableCategorias">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT IdCategoria, DescripcionCategoria FROM categorias";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["IdCategoria"] . "</td>";
                            echo "<td>" . $row["DescripcionCategoria"] . "</td>";
                            echo '<td><button class="btn btn-primary editar-btn" data-bs-toggle="modal" data-bs-target="#editarCategoriaModal" data-id="' . $row["IdCategoria"] . '"><i class="bi bi-pencil"></i></button>';
                            echo '<button class="btn btn-danger eliminar-btn" data-id="' . $row["IdCategoria"] . '"><i class="bi bi-trash"></i></button></td>';
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No se encontraron resultados</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div id="estatusventaSeccion" class="seccion">
            <h2>Estatus de las Ventas</h2>
            <div class="d-flex justify-content-between align-items-center">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" id="searchInputEstatus" class="form-control" placeholder="Buscar..." onkeyup="searchTable('dataTableEstatus', 'searchInputEstatus')">
                </div>
                <button class="btn btn-primary m-2 btnAgregar" data-bs-toggle="modal" data-bs-target="#agregarEstatusModal">Agregar</button>
            </div>
            <table class="table" id="dataTableEstatus">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT IdEstatus, DescripcionEstatus FROM estatusventa";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["IdEstatus"] . "</td>";
                            echo "<td>" . $row["DescripcionEstatus"] . "</td>";
                            echo '<td><button class="btn btn-primary editar-btn" data-bs-toggle="modal" data-bs-target="#editarEstatusModal" data-id="' . $row["IdEstatus"] . '"><i class="bi bi-pencil"></i></button>';
                            echo '<button class="btn btn-danger eliminar-btn" data-id="' . $row["IdEstatus"] . '"><i class="bi bi-trash"></i></button></td>';
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No se encontraron resultados</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div id="rolUsuarioSeccion" class="seccion">
            <h2>Rol de los Usuarios</h2>
            <div class="d-flex justify-content-between align-items-center">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" id="searchInputRol" class="form-control" placeholder="Buscar..." onkeyup="searchTable('dataTableRol', 'searchInputRol')">
                </div>
                <button class="btn btn-primary m-2 btnAgregar" data-bs-toggle="modal" data-bs-target="#agregarRolModal">Agregar</button>
            </div>
            <table class="table" id="dataTableRol">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT IdRol, DescripcionRol FROM rol";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["IdRol"] . "</td>";
                            echo "<td>" . $row["DescripcionRol"] . "</td>";
                            echo '<td><button class="btn btn-primary editar-btn" data-bs-toggle="modal" data-bs-target="#editarRolModal" data-id="' . $row["IdRol"] . '"><i class="bi bi-pencil"></i></button>';
                            echo '<button class="btn btn-danger eliminar-btn" data-id="' . $row["IdRol"] . '"><i class="bi bi-trash"></i></button></td>';
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No se encontraron resultados</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Editar Categoria -->
    <div class="modal fade" id="editarCategoriaModal" tabindex="-1" aria-labelledby="editarCategoriaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarCategoriaModalLabel">Editar Categoría</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditarCategoria" action="accionphp/editarcategoria.php" method="post">
                        <input type="hidden" id="editIdCategoria" name="id">
                        <div class="mb-3">
                            <label for="editDescripcionCategoria" class="form-label">Descripción</label>
                            <input type="text" class="form-control" id="editDescripcionCategoria" name="descripcion" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Agregar Categoria -->
    <div class="modal fade" id="agregarCategoriaModal" tabindex="-1" aria-labelledby="agregarCategoriaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agregarCategoriaModalLabel">Agregar Categoría</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formAgregarCategoria" action="accionphp/agregarcategoria.php" method="post">
                        <div class="mb-3">
                            <label for="DescripcionCategoria" class="form-label">Descripción</label>
                            <input type="text" class="form-control" id="DescripcionCategoria" name="descripcion" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Editar Estatus -->
    <div class="modal fade" id="editarEstatusModal" tabindex="-1" aria-labelledby="editarEstatusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarEstatusModalLabel">Editar Estatus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditarEstatus" action="accionphp/editarestatu.php" method="post">
                        <input type="hidden" id="editIdEstatus" name="id">
                        <div class="mb-3">
                            <label for="editDescripcionEstatus" class="form-label">Descripción</label>
                            <input type="text" class="form-control" id="editDescripcionEstatus" name="descripcion" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Agregar Estatus -->
    <div class="modal fade" id="agregarEstatusModal" tabindex="-1" aria-labelledby="agregarEstatusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agregarEstatusModalLabel">Agregar Estatus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formAgregarEstatus" action="accionphp/agregarestatu.php" method="post">
                        <div class="mb-3">
                            <label for="DescripcionEstatus" class="form-label">Descripción</label>
                            <input type="text" class="form-control" id="DescripcionEstatus" name="descripcion" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Editar Rol -->
    <div class="modal fade" id="editarRolModal" tabindex="-1" aria-labelledby="editarRolModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarRolModalLabel">Editar Rol</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditarRol" action="accionphp/editarrol.php" method="post">
                        <input type="hidden" id="editIdRol" name="id">
                        <div class="mb-3">
                            <label for="editDescripcionRol" class="form-label">Descripción</label>
                            <input type="text" class="form-control" id="editDescripcionRol" name="descripcion" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Agregar Rol -->
    <div class="modal fade" id="agregarRolModal" tabindex="-1" aria-labelledby="agregarRolModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agregarRolModalLabel">Agregar Rol</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formAgregarRol" action="accionphp/agregarrol.php" method="post">
                        <div class="mb-3">
                            <label for="DescripcionRol" class="form-label">Descripción</label>
                            <input type="text" class="form-control" id="DescripcionRol" name="descripcion" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/CRUDSecundarias.js"></script>
</body>

</html>