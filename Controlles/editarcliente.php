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

// Verificar si se recibieron los datos necesarios
if (isset($_POST["cliente_id"]) && isset($_POST["nombre"]) && isset($_POST["apellidopa"]) && isset($_POST["apellidomat"]) && isset($_POST["numero"]) && isset($_POST["correo"])) {
    // Obtener los datos del formulario
    $cliente_id = $_POST["cliente_id"];
    $nombre = $_POST["nombre"];
    $apellidopa = $_POST["apellidopa"];
    $apellidomat = $_POST["apellidomat"];
    $numero = $_POST["numero"];
    $correo = $_POST["correo"];

    // Consulta SQL para actualizar el cliente
    $sql = "UPDATE cliente SET nombrecliente = ?, apellidopa = ?, apellidomat = ?, numero = ?, correo = ? WHERE cliente_id = ?";

    // Preparar la consulta
    $stmt = $mysqli_conexion->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("sssssi", $nombre, $apellidopa, $apellidomat, $numero, $correo, $cliente_id);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Redirigir a la página de administración con un mensaje de éxito
            header("Location: indexadmi.php?success=1");
        } else {
            // Redirigir a la página de administración con un mensaje de error
            header("Location: indexadmi.php?error=1");
        }

        // Cerrar la declaración
        $stmt->close();
    } else {
        // Redirigir a la página de administración con un mensaje de error si la preparación de la consulta falla
        header("Location: indexadmi.php?error=1");
    }

    // Cerrar la conexión
    $mysqli_conexion->close();
} else {
    // Redirigir a la página de administración con un mensaje de error si no se recibieron los datos necesarios
    header("Location: indexadmi.php?error=1");
}
?>
