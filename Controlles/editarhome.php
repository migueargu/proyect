<?php
// Iniciar sesión
session_start();

// Verificar si el usuario está autenticado como administrador
if (!isset($_SESSION["admin_id"])) {
    // Si no está autenticado, redirigir al inicio de sesión
    header("Location: login.php");
    exit();
}

// Incluir archivo de conexión a la base de datos
include "../Model/conexion.php";

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $home_id = $_POST["home_id"];
    $monto = $_POST["monto"];
    $ubicacion = $_POST["ubicacion"];

    // Validar y limpiar los datos
    $home_id = $mysqli_conexion->real_escape_string($home_id);
    $monto = $mysqli_conexion->real_escape_string($monto);
    $ubicacion = $mysqli_conexion->real_escape_string($ubicacion);

    // Actualizar la propiedad en la base de datos
    $sql = "UPDATE propiedad SET monto='$monto', ubicacion='$ubicacion' WHERE home_id='$home_id'";

    if ($mysqli_conexion->query($sql) === TRUE) {
        // Redirigir de vuelta a la página principal con un mensaje de éxito
        $_SESSION['mensaje'] = "Propiedad actualizada exitosamente.";
        header("Location: indexadmi.php");
        exit();
    } else {
        // Redirigir de vuelta a la página principal con un mensaje de error
        $_SESSION['error'] = "Error al actualizar la propiedad: " . $mysqli_conexion->error;
        header("Location: indexadmi.php");
        exit();
    }

    // Cerrar conexión
    $mysqli_conexion->close();
} else {
    // Si el formulario no fue enviado correctamente, redirigir a la página principal
    header("Location: indexadmi.php");
    exit();
}
?>
