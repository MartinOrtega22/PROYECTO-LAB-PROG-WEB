<?php
session_start();

// Variables de la base de datos
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    // Consultar usuario
    $sql = "SELECT * FROM usuario WHERE CorreoUsuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();
    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
        // Verificar contraseña
        if (password_verify($contrasena, $usuario['contrasena'])) {
            // Autenticación exitosa
            $_SESSION['suario'] = $usuario['nombre'];
            $_SESSION['correo'] = $usuario['correo'];
            $_SESSION['rol'] = $usuario['rol'];
            header("Location: index.php");
            exit();
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "El usuario no existe.";
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5 bg-white p-4 mx-1 rounded border">
                <div class="w-100">
                    <h1>Iniciar sesión</h1>
                    <?php if (isset($error)) {
                        echo '<div class="alert alert-danger">' . $error . '</div>';
                    } ?>
                    <form method="post" action="autenticar.php">
                        <div class="mb-3">
                            <input type="email" class="form-control" name="correo" placeholder="Correo" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" name="contrasena" placeholder="Contraseña" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Iniciar sesión</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>