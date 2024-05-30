<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador - Página Principal</title>
    <!-- Enlace a los archivos CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Enlace al archivo CSS personalizado -->
    <link rel="stylesheet" href="../css/indexadmi.css">
</head>
<!-- PHP para verificar la autenticación del administrador -->
<?php
    // Iniciar sesión
    session_start();

    // Incluir el archivo de conexión
    include '../Model/conexion.php';

    // Verificar si el usuario está autenticado
    if (!isset($_SESSION["user_id"])) {
        // Si no está autenticado, redirigir al inicio de sesión
        header("Location: login.php");
        exit();
    }

    // Obtener el nombre del usuario de la base de datos
    $user_id = $_SESSION["user_id"];
    $query = "SELECT nombre FROM usuario WHERE user_id = ?";
    if ($stmt = $mysqli_conexion->prepare($query)) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($nombre);
        $stmt->fetch();
        $stmt->close();
    } else {
        $nombre = "Usuario";
    }
?>
<!-- Fin del PHP -->
<body>
    <!-- Barra de Navegación -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <!-- Botón para colapsar la barra de navegación en dispositivos móviles -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Logo -->
            <a class="navbar-brand" href="#">
                <img src="../Imagenes/logo.jpg" alt="Logo" height="100" class="me-2">
                Skynet
            </a>
            <!-- Contenido colapsable -->
            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <!-- Nombre de usuario -->
                <span class="navbar-text me-4 fs-5">
                    ¡Bienvenido, <?php echo htmlspecialchars($nombre); ?>!
                </span>
                <!-- Formulario de búsqueda centrado -->
                <form class="d-flex mx-auto" method="GET" action="">
                    <input class="form-control me-2" type="search" name="query" placeholder="Buscar usuario" aria-label="Buscar">
                    <button class="btn btn-outline-success" type="submit">Buscar</button>
                </form>
                <!-- Botones para usuario y propiedades -->
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item me-2">
                        <a class="nav-link btn btn-primary text-white" href="addcliente1.php">Clientes</a>
                    </li>
                    <li class="nav-item me-2">
                        <a class="nav-link btn btn-primary text-white" href="addpropiedad.php">Propiedades</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary text-white" href="sesion_user.php">Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
    <h2>Clientes</h2>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <!-- PHP para mostrar clientes como tarjetas -->
        <?php
        // Incluir archivo de conexión a la base de datos
        include "../Model/conexion.php";

        // Consulta SQL para obtener los últimos 6 clientes
        $sql_clientes = "SELECT * FROM cliente ORDER BY cliente_id DESC LIMIT 6";
        $resultado_clientes = $mysqli_conexion->query($sql_clientes);

        // Comprobar si hay resultados y mostrar los clientes en las tarjetas
        if ($resultado_clientes->num_rows > 0) {
            while ($row_cliente = $resultado_clientes->fetch_assoc()) {
                echo '
                <div class="col">
                    <div class="card mb-3">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="../Imagenes/cliente.png" class="img-fluid rounded-start" alt="Imagen de Cliente">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">' . $row_cliente["nombrecliente"] . ' ' . $row_cliente["apellidopa"] . ' ' . $row_cliente["apellidomat"] . '</h5>
                                    <p class="card-text">Correo electrónico: ' . $row_cliente["correo"] . '</p>
                                    <p class="card-text">Número: ' . $row_cliente["numero"] . '</p>
                            </div>
                        </div>
                    </div>
                </div>';
            }
        } else {
            echo '<div class="no-results"><p>No se encontraron clientes.</p></div>';
        }

        // Cerrar conexión
        $mysqli_conexion->close();
        ?>
        <!-- Fin del PHP para mostrar clientes -->
    </div>
</div>



<div class="container mt-4">
    <h2>Propiedades</h2>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <!-- PHP para mostrar propiedades como tarjetas -->
        <?php
        // Incluir archivo de conexión a la base de datos
        include "../Model/conexion.php";

        // Consulta SQL para obtener las últimas 6 propiedades con información del inmueble
        $sql_propiedades = "SELECT p.home_id, p.monto, p.ubicacion, i.inmueble
                            FROM propiedad p
                            INNER JOIN inmueble i ON p.inmueble_id = i.inmueble_id
                            ORDER BY p.home_id DESC
                            LIMIT 6";
        $resultado_propiedades = $mysqli_conexion->query($sql_propiedades);

        // Comprobar si hay resultados y mostrar las propiedades en las tarjetas
        if ($resultado_propiedades->num_rows > 0) {
            while ($row_propiedad = $resultado_propiedades->fetch_assoc()) {
                // Determinar la imagen basada en el tipo de inmueble
                $imagen = "";
                switch (strtolower($row_propiedad["inmueble"])) {
                    case "lotes":
                        $imagen = "../Imagenes/lotes.png";
                        break;
                    case "departamento":
                        $imagen = "../Imagenes/departamento.png";
                        break;
                    case "casa":
                        $imagen = "../Imagenes/home.jpeg";
                        break;
                    case "terreno":
                        $imagen = "../Imagenes/terrenos.png";
                        break;
                    default:
                        $imagen = "../Imagenes/default.jpeg";
                        break;
                }

                echo '
                <div class="col">
                    <div class="card mb-3">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <!-- Imagen específica del tipo de propiedad -->
                                <img src="' . $imagen . '" class="img-fluid rounded-start" alt="Imagen de ' . $row_propiedad["inmueble"] . '">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">' . $row_propiedad["ubicacion"] . '</h5>
                                    <p class="card-text">Monto $: ' . $row_propiedad["monto"] . '</p>
                                    <p class="card-text">Inmueble: ' . $row_propiedad["inmueble"] . '</p>
                                    <!-- Botón desplegable para opciones -->
                                    <!-- Fin del botón desplegable -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
            }
        } else {
            echo '<div class="no-results"><p>No se encontraron propiedades.</p></div>';
        }

        // Cerrar conexión
        $mysqli_conexion->close();
        ?>
        <!-- Fin del PHP para mostrar propiedades -->
    </div>
</div>



    <!-- Enlace a los archivos JavaScript de Bootstrap (opcional, solo si necesitas componentes que requieren JavaScript) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
