<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idVenta = $_POST['id'];
    $estatusVenta = $_POST['estatusVenta'];

    // Variables de base de datos
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

    // Actualizar estatus de la venta
    $sql = "UPDATE venta SET EstatusVenta = ? WHERE IdVenta = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $estatusVenta, $idVenta);

    if ($stmt->execute()) {
        echo "Estatus actualizado correctamente";
    } else {
        echo "Error al actualizar el estatus: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
