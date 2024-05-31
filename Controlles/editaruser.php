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
if (isset($_POST["user_id"]) && isset($_POST["nombre"]) && isset($_POST["apellidoPat"]) && isset($_POST["apellidoMat"]) && isset($_POST["telefono"]) && isset($_POST["email"])) {
    // Obtener los datos del formulario
    $user_id = $_POST["user_id"];
    $nombre = $_POST["nombre"];
    $apellidoPat = $_POST["apellidoPat"];
    $apellidoMat = $_POST["apellidoMat"];
    $telefono = $_POST["telefono"];
    $email = $_POST["email"];

    // Consulta SQL para actualizar el usuario
    $sql = "UPDATE usuario SET nombre = ?, apellidoPat = ?, apellidoMat = ?, telefono = ?, email = ? WHERE user_id = ?";

    // Preparar la consulta
    $stmt = $mysqli_conexion->prepare($sql);
    $stmt->bind_param("sssssi", $nombre, $apellidoPat, $apellidoMat, $telefono, $email, $user_id);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Redirigir a la página de administración con un mensaje de éxito
        header("Location: indexadmi.php?success=1");
    } else {
        // Redirigir a la página de administración con un mensaje de error
        header("Location: indexadmi.php?error=1");
    }

    // Cerrar la conexión
    $stmt->close();
    $mysqli_conexion->close();
} else {
    // Redirigir a la página de administración con un mensaje de error
    header("Location: indexadmi.php?error=1");
}
?>
