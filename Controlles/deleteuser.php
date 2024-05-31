<?php
// Incluir archivo de conexión a la base de datos
include "../Model/conexion.php";

// Verificar si se proporcionó un ID de usuario válido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $user_id = $_GET['id'];

    // Consulta SQL para eliminar el usuario
    $sql = "DELETE FROM usuario WHERE user_id = $user_id";

    if ($mysqli_conexion->query($sql) === TRUE) {
        header("Location: indexAdmi.php");
        exit();
    } else {
        echo "Error al eliminar el usuario: " . $mysqli_conexion->error;
    }
} else {
    echo "ID de usuario no válido.";
}

// Cerrar conexión
$mysqli_conexion->close();
?>
