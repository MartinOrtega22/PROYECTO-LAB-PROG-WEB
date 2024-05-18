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

// Obtener datos del formulario
$idSucursal = $_POST['idSucursal'];
$nombreSucursal = $_POST['nombreSucursal'];
$direccionSucursal = $_POST['direccionSucursal'];
$telefonoSucursal = $_POST['telefonoSucursal'];

// Insertar nueva sucursal
$sql = "INSERT INTO sucursal (idSucursal, nombreSucursal, direccionSucursal, telefonoSucursal)
        VALUES ('$idSucursal', '$nombreSucursal', '$direccionSucursal', '$telefonoSucursal')";

if ($conn->query($sql) === TRUE) {
    header("Location: ../CRUDSucursales.php?success=1");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
