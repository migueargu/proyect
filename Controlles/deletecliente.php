<?php
// Incluir archivo de conexión a la base de datos
include "../Model/conexion.php";

// Verificar si se proporcionó un ID de propiedad válido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $cliente_id = $_GET['id'];

    // Consulta SQL para eliminar el cliente
    $sql = "DELETE FROM cliente WHERE cliente_id = $cliente_id";

    if ($mysqli_conexion->query($sql) === TRUE) {
        header("Location: indexAdmi.php");
        exit();
    } else {
        echo "Error al eliminar: " . $mysqli_conexion->error;
    }
} else {
    echo "ID de propiedad no válido.";
}

// Cerrar conexión
$mysqli_conexion->close();