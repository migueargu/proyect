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

    // Verificar si el usuario está autenticado como administrador
    if (!isset($_SESSION["admin_id"])) {
        // Si no está autenticado, redirigir al inicio de sesión
        header("Location: login.php");
        exit();
    }

    // Obtener el nombre del administrador de la base de datos
    $admin_id = $_SESSION["admin_id"];
    $query = "SELECT username FROM administrador WHERE admin_id = ?";
    if ($stmt = $mysqli_conexion->prepare($query)) {
        $stmt->bind_param("i", $admin_id);
        $stmt->execute();
        $stmt->bind_result($username);
        $stmt->fetch();
        $stmt->close();
    } else {
        $username = "Administrador";
    }

?>
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
          ¡Bienvenido, <?php echo htmlspecialchars($username); ?>!
        </span>
        <!-- Formulario de búsqueda centrado -->
        <form class="d-flex mx-auto" method="GET" action="">
          <input class="form-control me-2" type="search" name="query" placeholder="Buscar usuario" aria-label="Buscar">
          <button class="btn btn-outline-success" type="submit">Buscar</button>
        </form>
        <!-- Botones para usuario y propiedades -->
        <ul class="navbar-nav ms-auto">
          <li class="nav-item me-2">
            <a class="nav-link btn btn-primary text-white" href="adduser.php">Usuarios</a>
          </li>
          <li class="nav-item me-2">
            <a class="nav-link btn btn-primary text-white" href="addcliente.php">Clientes</a>
          </li>
          <li class="nav-item me-2">
            <a class="nav-link btn btn-primary text-white" href="addpropiedad.php">Propiedades</a>
          </li>
          <li class="nav-item me-2">
            <button type="button" class="nav-link btn btn-primary text-white" onclick="miFuncion()">Descargar PDF</button>
          </li>
          <li class="nav-item">
            <a class="nav-link btn btn-primary text-white" href="cerrar_sesion.php">Cerrar Sesión</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container mt-4">
    <h2>Vendedor</h2>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <!-- PHP para mostrar usuarios como tarjetas -->
        <?php
        // Incluir archivo de conexión a la base de datos
        include "../Model/conexion.php";

        // Consulta SQL para obtener los últimos 6 usuarios
        $sql = "SELECT * FROM usuario ORDER BY user_id DESC LIMIT 6";
        $resultado = $mysqli_conexion->query($sql);

        // Comprobar si hay resultados y mostrar los datos en las tarjetas
        if ($resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                echo '
                <div class="col">
                    <div class="card mb-3">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="../Imagenes/vendedor.jpg" class="img-fluid rounded-start" alt="Imagen de Usuario">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">' . $row["nombre"] . ' ' . $row["apellidoPat"] . ' ' . $row["apellidoMat"] . '</h5>
                                    <p class="card-text">Teléfono: ' . $row["telefono"] . '</p>
                                    <p class="card-text">Correo electrónico: ' . $row["email"] . '</p>
                                    <!-- Botón desplegable -->
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                            Opciones
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editUserModal" data-id="' . $row['user_id'] . '" data-nombre="' . $row['nombre'] . '" data-apellidopat="' . $row['apellidoPat'] . '" data-apellidomat="' . $row['apellidoMat'] . '" data-telefono="' . $row['telefono'] . '" data-email="' . $row['email'] . '">Editar</a></li>
                                            <li><a class="dropdown-item" href="deleteuser.php?id=' . $row['user_id'] . '">Eliminar</a></li>
                                        </ul>
                                    </div>
                                    <!-- Fin del botón desplegable -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
            }
        } else {
            echo '<div class="no-results"><p>No se encontraron usuarios.</p></div>';
        }

        // Cerrar conexión
        $mysqli_conexion->close();
        ?>
        <!-- Fin del PHP para mostrar usuarios -->
    </div>
</div>

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
                                    <!-- Botón desplegable -->
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                            Opciones
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editClientModal" data-id="' . $row_cliente['cliente_id'] . '" data-nombre="' . $row_cliente['nombrecliente'] . '" data-apellidopa="' . $row_cliente['apellidopa'] . '" data-apellidomat="' . $row_cliente['apellidomat'] . '" data-correo="' . $row_cliente['correo'] . '" data-numero="' . $row_cliente['numero'] . '">Editar</a></li>
                                            <li><a class="dropdown-item" href="deletecliente.php?id=' . $row_cliente['cliente_id'] . '">Eliminar</a></li>
                                        </ul>
                                    </div>
                                    <!-- Fin del botón desplegable -->
                                </div>
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
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                            Opciones
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editPropertyModal" data-id="' . $row_propiedad["home_id"] . '" data-monto="' . $row_propiedad["monto"] . '" data-ubicacion="' . $row_propiedad["ubicacion"] . '">Editar</a></li>
                                            <li><a class="dropdown-item" href="deletehome.php?id=' . $row_propiedad["home_id"] . '">Eliminar</a></li>
                                        </ul>
                                    </div>
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


    <!-- Modal para editar usuario -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Editar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm" method="POST" action="editaruser.php">
                        <input type="hidden" name="user_id" id="editUserId">
                        <div class="mb-3">
                            <label for="editUserName" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="editUserName" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="editUserApellidoPat" class="form-label">Apellido Paterno</label>
                            <input type="text" class="form-control" id="editUserApellidoPat" name="apellidoPat" required>
                        </div>
                        <div class="mb-3">
                            <label for="editUserApellidoMat" class="form-label">Apellido Materno</label>
                            <input type="text" class="form-control" id="editUserApellidoMat" name="apellidoMat" required>
                        </div>
                        <div class="mb-3">
                            <label for="editUserTelefono" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="editUserTelefono" name="telefono" required>
                        </div>
                        <div class="mb-3">
                            <label for="editUserEmail" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="editUserEmail" name="email" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar cliente -->
<div class="modal fade" id="editClientModal" tabindex="-1" aria-labelledby="editClientModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editClientModalLabel">Editar Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editClientForm" method="POST" action="editarcliente.php">
                    <input type="hidden" name="cliente_id" id="editClientId">
                    <div class="mb-3">
                        <label for="editClientName" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="editClientName" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="editClientApellidoPat" class="form-label">Apellido Paterno</label>
                        <input type="text" class="form-control" id="editClientApellidoPat" name="apellidopa" required>
                    </div>
                    <div class="mb-3">
                        <label for="editClientApellidoMat" class="form-label">Apellido Materno</label>
                        <input type="text" class="form-control" id="editClientApellidoMat" name="apellidomat" required>
                    </div>
                    <div class="mb-3">
                        <label for="editClientEmail" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="editClientEmail" name="correo" required>
                    </div>
                    <div class="mb-3">
                        <label for="editClientNumero" class="form-label">Número</label>
                        <input type="text" class="form-control" id="editClientNumero" name="numero" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal para editar propiedad -->
<div class="modal fade" id="editPropertyModal" tabindex="-1" aria-labelledby="editPropertyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPropertyModalLabel">Editar Propiedad</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editPropertyForm" method="POST" action="editarhome.php">
                    <input type="hidden" name="home_id" id="editPropertyId">
                    <div class="mb-3">
                        <label for="editPropertyMonto" class="form-label">Monto</label>
                        <input type="text" class="form-control" id="editPropertyMonto" name="monto" required>
                    </div>
                    <div class="mb-3">
                        <label for="editPropertyUbicacion" class="form-label">Ubicación</label>
                        <input type="text" class="form-control" id="editPropertyUbicacion" name="ubicacion" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>






    <!-- Enlace a los archivos JavaScript de Bootstrap (opcional, solo si necesitas componentes que requieren JavaScript) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Script para pasar datos al modal de edición
        var editUserModal = document.getElementById('editUserModal');
        editUserModal.addEventListener('show.bs.modal', function (event) {
            // Botón que activó el modal
            var button = event.relatedTarget;
            // Extraer la información de los atributos data-*
            var userId = button.getAttribute('data-id');
            var userName = button.getAttribute('data-nombre');
            var userApellidoPat = button.getAttribute('data-apellidopat');
            var userApellidoMat = button.getAttribute('data-apellidomat');
            var userTelefono = button.getAttribute('data-telefono');
            var userEmail = button.getAttribute('data-email');

            // Actualizar los valores del formulario en el modal
            var modalTitle = editUserModal.querySelector('.modal-title');
            var inputUserId = editUserModal.querySelector('#editUserId');
            var inputUserName = editUserModal.querySelector('#editUserName');
            var inputUserApellidoPat = editUserModal.querySelector('#editUserApellidoPat');
            var inputUserApellidoMat = editUserModal.querySelector('#editUserApellidoMat');
            var inputUserTelefono = editUserModal.querySelector('#editUserTelefono');
            var inputUserEmail = editUserModal.querySelector('#editUserEmail');

            modalTitle.textContent = 'Editar Usuario: ' + userName;
            inputUserId.value = userId;
            inputUserName.value = userName;
            inputUserApellidoPat.value = userApellidoPat;
            inputUserApellidoMat.value = userApellidoMat;
            inputUserTelefono.value = userTelefono;
            inputUserEmail.value = userEmail;
        });
    </script>

<script>
    // Script para pasar datos al modal de edición de cliente
    var editClientModal = document.getElementById('editClientModal');
    editClientModal.addEventListener('show.bs.modal', function (event) {
        // Botón que activó el modal
        var button = event.relatedTarget;
        // Extraer la información de los atributos data-*
        var clientId = button.getAttribute('data-id');
        var clientName = button.getAttribute('data-nombre');
        var clientApellidoPat = button.getAttribute('data-apellidopa');
        var clientApellidoMat = button.getAttribute('data-apellidomat');
        var clientCorreo = button.getAttribute('data-correo');
        var clientNumero = button.getAttribute('data-numero');

        // Actualizar los valores del formulario en el modal
        var modalTitle = editClientModal.querySelector('.modal-title');
        var inputClientId = editClientModal.querySelector('#editClientId');
        var inputClientName = editClientModal.querySelector('#editClientName');
        var inputClientApellidoPat = editClientModal.querySelector('#editClientApellidoPat');
        var inputClientApellidoMat = editClientModal.querySelector('#editClientApellidoMat');
        var inputClientCorreo = editClientModal.querySelector('#editClientEmail');
        var inputClientNumero = editClientModal.querySelector('#editClientNumero');

        modalTitle.textContent = 'Editar Cliente: ' + clientName;
        inputClientId.value = clientId;
        inputClientName.value = clientName;
        inputClientApellidoPat.value = clientApellidoPat;
        inputClientApellidoMat.value = clientApellidoMat;
        inputClientCorreo.value = clientCorreo;
        inputClientNumero.value = clientNumero;
    });
</script>


<script>
    // Script para pasar datos al modal de edición de propiedad
    var editPropertyModal = document.getElementById('editPropertyModal');
    editPropertyModal.addEventListener('show.bs.modal', function (event) {
        // Botón que activó el modal
        var button = event.relatedTarget;
        // Extraer la información de los atributos data-*
        var homeId = button.getAttribute('data-id');
        var monto = button.getAttribute('data-monto');
        var ubicacion = button.getAttribute('data-ubicacion');

        // Actualizar los valores del formulario en el modal
        var modalTitle = editPropertyModal.querySelector('.modal-title');
        var inputHomeId = editPropertyModal.querySelector('#editPropertyId');
        var inputMonto = editPropertyModal.querySelector('#editPropertyMonto');
        var inputUbicacion = editPropertyModal.querySelector('#editPropertyUbicacion');

        modalTitle.textContent = 'Editar Propiedad: ' + homeId;
        inputHomeId.value = homeId;
        inputMonto.value = monto;
        inputUbicacion.value = ubicacion;
    });
</script>

<script>
    function miFuncion() {
      window.location.href = 'http://192.168.1.87:5000';
    }
  </script>

</script>
</body>
</html>
