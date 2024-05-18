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
        <input type="text">
        <button type="button" class="btn btn-primary">Buscar</button>

        <!-- Botón para abrir el modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarSucursalModal">
            Agregar
        </button>

        <!-- Modal -->
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
                                <input type="text" class="form-control" id="direccionSucursal"
                                    name="direccionSucursal" required>
                            </div>
                            <div class="mb-3">
                                <label for="telefonoSucursal" class="form-label">Teléfono</label>
                                <input type="number" class="form-control" id="telefonoSucursal" name="telefonoSucursal"
                                    required>
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
                <th>Acciones</th>
            </tr>
            <?php
            $sql = "SELECT IdSucursal, NombreSucursal, DireccionSucursal, TelefonoSucursal FROM sucursal";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["IdSucursal"] . "</td>";
                    echo "<td>" . $row["NombreSucursal"] . "</td>";
                    echo "<td>" . $row["DireccionSucursal"] . "</td>";
                    echo "<td>" . $row["TelefonoSucursal"] . "</td>";
                    echo '<td><a href="editar.php?id=' . $row["IdSucursal"] . '" id="btnEditar"><img src="img/editar.png"></a>  <a href="eliminar.php?id=' . $row["IdSucursal"] . '" id="btnEliminar"><img src="img/eliminar.png"></a></td>';
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No se encontraron resultados</td></tr>";

            }
            $conn->close();
            ?>
        </table>
    </div>


    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success text-center" role="alert"
            style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1050;">
            Sucursal agregada correctamente.
        </div>
        <script>
            setTimeout(() => {
                document.querySelector('.alert').remove();
            }, 3000);
        </script>
    <?php endif; ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script>
        // Limpiar el formulario cuando se cierra el modal
        document.getElementById('agregarSucursalModal').addEventListener('hidden.bs.modal', function () {
            document.getElementById('formAgregarSucursal').reset();
        });
    </script>
</body>

</html>