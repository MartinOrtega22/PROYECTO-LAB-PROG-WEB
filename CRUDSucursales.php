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
    die("Error de conexión: " . $conexion->connect_error);
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sucursales</title>
    <link rel="stylesheet" href="css/CRUDSucursales.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
            <a class="nav-link" href="#"><i class="bi bi-person-circle"></i></i></a>
        </li>
    </ul>

    <div class="container">
        <h2>Lista de sucursales</h2>
        <div class="d-flex justify-content-between align-items-center">
            <div class="input-group">
                <span class="input-group-text" id="searchIcon">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" id="searchInput" onkeyup="searchTable()" class="form-control" placeholder="Buscar..."
                    style="flex: 1;">
            </div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                data-bs-target="#agregarSucursalModal">Agregar</button><!-- Botón para abrir el modal -->
        </div>


        <!-- Modal para editar -->
        <div class="modal fade" id="editarSucursalModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar Sucursal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form id="formEditarSucursal" action="accionphp/editarsucursal.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" id="editIdSucursal" name="id">
                            <div class="mb-3">
                                <label for="editNombreSucursal" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="editNombreSucursal" name="editNombreSucursal"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="editDireccionSucursal" class="form-label">Dirección</label>
                                <input type="text" class="form-control" id="editDireccionSucursal" name="editDireccionSucursal"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="editTelefonoSucursal" class="form-label">Teléfono</label>
                                <input type="number" class="form-control" id="editTelefonoSucursal" name="editTelefonoSucursal"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="editIdUsuario" class="form-label">Id Usuario</label>
                                <input type="number" class="form-control" id="editIdUsuario" name="editIdUsuario" required>
                            </div>
                            <div class="mb-3">
                                <label for="editFechaAlta" class="form-label">Fecha de alta</label>
                                <input type="number" class="form-control" id="editFechaAlta" name="editFechaAlta" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" form="formEditSucursal">Guardar</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal para agregar -->
        <div class="modal fade" id="agregarSucursalModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Sucursal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formAgregarSucursal" action="accionphp/agregarsucursal.php" method="post"
                            enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="idSucursal" class="form-label">ID Sucursal</label>
                                <input type="text" class="form-control" id="idSucursal" name="idSucursal" required>
                            </div>
                            <div class="mb-3">
                                <label for="nombreSucursal" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombreSucursal" name="nombreSucursal"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="direccionSucursal" class="form-label">Dirección</label>
                                <input type="text" class="form-control" id="direccionSucursal" name="direccionSucursal"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="telefonoSucursal" class="form-label">Teléfono</label>
                                <input type="number" class="form-control" id="telefonoSucursal" name="telefonoSucursal"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="idUsuario" class="form-label">Id Usuario</label>
                                <input type="number" class="form-control" id="idUsuario" name="idUsuario" required>
                            </div>
                            <div class="mb-3">
                                <label for="fechaAlta" class="form-label">Fecha de alta</label>
                                <input type="number" class="form-control" id="fechaAlta" name="fechaAlta" required>
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
                <th>Id Usuario</th>
                <th>Fecha de alta</th>
                <th>Acciones</th>
            </tr>
            <?php
            $sql = "SELECT IdSucursal, NombreSucursal, DireccionSucursal, TelefonoSucursal, IdUsuario, FechaAlta FROM sucursal";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["IdSucursal"] . "</td>";
                    echo "<td>" . $row["NombreSucursal"] . "</td>";
                    echo "<td>" . $row["DireccionSucursal"] . "</td>";
                    echo "<td>" . $row["TelefonoSucursal"] . "</td>";
                    echo "<td>" . $row["IdUsuario"] . "</td>";
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