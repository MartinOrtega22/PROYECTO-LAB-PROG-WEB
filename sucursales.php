<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sucursales</title>
    <link rel="stylesheet" href="css/sucursales.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.0/font/bootstrap-icons.css">

</head>

<body>
    <div class="container">
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

        <?php
        // Configuración de la conexión a la base de datos
        $host = "localhost";
        $usuario = "root";
        $contra = "megustaelcereal";
        $bd = "farmacia";

        // Conexión
        $conn = new mysqli($host, $usuario, $contra, $bd);

        // VerificA conexión
        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }
        ?>

        <?php
        // consulta
        $sql = "SELECT NombreSucursal, DireccionSucursal, TelefonoSucursal FROM sucursal";
        $resultado = $conn->query($sql);


        if ($resultado->num_rows > 0) {
            // Por cada resulatado te muestra una card
            while ($fila = $resultado->fetch_assoc()) {
                echo '<div class="sucursal">';
                echo '<h2>' . $fila['NombreSucursal'] . '</h2>';
                echo '<p><strong>Dirección:</strong> ' . $fila['DireccionSucursal'] . '</p>';
                echo '<p><strong>Teléfono:</strong> ' . $fila['TelefonoSucursal'] . '</p>';
                echo '</div>';
            }
        } else {
            echo "No se encontraron sucursales.";
        }

        $conexion->close();
        ?>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>

</html>