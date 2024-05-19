    <?php
    $host = "localhost";
    $usuario = "root";
    $contra = "12345678";
    $bd = "farmacia";

    $conn = new mysqli($host, $usuario, $contra, $bd);

    if ($conn->connect_error) {
        die(json_encode(['error' => 'Error de conexión: ' . $conn->connect_error]));
    }

    if (isset($_GET['idUsuario'])) {
        $idUsuario = $_GET['idUsuario'];
        $sql = "SELECT IdUsuario, NombreUsuario, DireccionUsuario, CorreoUsuario, TelefonoUsuario, RolUsuario, ContrasenaUsuario FROM usuario WHERE IdUsuario = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            echo json_encode(['error' => 'Error en la preparación de la consulta']);
            exit();
        }

        $stmt->bind_param("i", $idUsuario);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $producto = $result->fetch_assoc();
            echo json_encode($producto);
        } else {
            echo json_encode(['error' => 'Usuario no encontrado']);
        }

        $stmt->close();
    } else {
        echo json_encode(['error' => 'ID de Usuario no proporcionado']);
    }

    $conn->close();
