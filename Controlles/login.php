<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../css/login.css" rel="stylesheet">
</head>
<body>

    <div class="login-container">
        <div class="login-image">
        </div>
        <div class="login-form">
            <h3 class="text-center">Iniciar Sesión</h3>
            <form action="login.php" method="post">
                <div class="form-group">
                    <label for="username">Usuario o Correo Electrónico</label>
                    <input type="text" name="username" id="username" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
                
            </form>
            <?php if (isset($_GET['error'])) : ?>
                <div class="alert alert-danger mt-3" role="alert">
                    Usuario o contraseña incorrectos. Por favor, inténtalo de nuevo o contacte con soporte.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php
    // Iniciar sesión
    session_start();

    // Incluir el archivo de conexión a la base de datos
    include '../Model/conexion.php';

    // Verificar si se envió el formulario de inicio de sesión
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Verificar que se hayan enviado datos de usuario y contraseña
        if (isset($_POST["username"]) && isset($_POST["password"])) {
            // Obtener datos del formulario
            $username = $_POST["username"];
            $password = $_POST["password"];

            // Consulta SQL para verificar las credenciales de inicio de sesión del administrador
            $sql_admin = "SELECT admin_id, username, password FROM administrador WHERE username = ?";

            // Preparar la consulta para el administrador
            $stmt_admin = $mysqli_conexion->prepare($sql_admin);

            // Verificar si la preparación de la consulta fue exitosa
            if ($stmt_admin === false) {
                echo "Error en la preparación de la consulta para administrador: " . $mysqli_conexion->error;
                exit();
            }

            // Vincular parámetros para la consulta del administrador
            $stmt_admin->bind_param("s", $username);

            // Ejecutar la consulta para el administrador
            $stmt_admin->execute();

            // Obtener resultados para el administrador
            $result_admin = $stmt_admin->get_result();

            // Verificar si se encontró un registro para el administrador
            if ($result_admin->num_rows == 1) {
                // Obtener el registro del administrador como un array asociativo
                $row_admin = $result_admin->fetch_assoc();
                // Verificar la contraseña del administrador
                if ($password === $row_admin["password"]) {
                    // Iniciar sesión para el administrador
                    $_SESSION["admin_id"] = $row_admin["admin_id"];
                    $_SESSION["username"] = $row_admin["username"];
                    // Redireccionar al área de administrador
                    header("Location: indexAdmi.php");
                    exit();
                }
            }

            // Cerrar la statement del administrador
            $stmt_admin->close();

            // Consulta SQL para verificar las credenciales de inicio de sesión del usuario
            $sql_user = "SELECT user_id, email, password FROM usuario WHERE email = ?";

            // Preparar la consulta para el usuario
            $stmt_user = $mysqli_conexion->prepare($sql_user);

            // Verificar si la preparación de la consulta fue exitosa
            if ($stmt_user === false) {
                echo "Error en la preparación de la consulta para usuario: " . $mysqli_conexion->error;
                exit();
            }

            // Vincular parámetros para la consulta del usuario
            $stmt_user->bind_param("s", $username);

            // Ejecutar la consulta para el usuario
            $stmt_user->execute();

            // Obtener resultados para el usuario
            $result_user = $stmt_user->get_result();

            // Verificar si se encontró un registro para el usuario
            if ($result_user->num_rows == 1) {
                // Obtener el registro del usuario como un array asociativo
                $row_user = $result_user->fetch_assoc();
                // Verificar la contraseña del usuario
                if ($password === $row_user["password"]) {
                    // Iniciar sesión para el usuario
                    $_SESSION["user_id"] = $row_user["user_id"];
                    $_SESSION["email"] = $row_user["email"];
                    // Redireccionar al área de usuario
                    header("Location: indexUser.php");
                    exit();
                }
            }

            // Usuario o contraseña incorrectos, redirigir de nuevo al formulario de inicio de sesión con un mensaje de error
            header("Location: login.php?error=true");
            exit();
        }
    }

    // Cerrar la conexión a la base de datos
    $mysqli_conexion->close();
    ?>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
