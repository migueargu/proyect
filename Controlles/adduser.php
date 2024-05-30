<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Usuario</title>
    <!-- Enlace a los archivos CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Enlace al archivo CSS personalizado -->
    <link rel="stylesheet" href="adduser.css">
</head>
<body>
    <!-- Barra de Navegación -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <!-- Botón para colapsar la barra de navegación en dispositivos móviles -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- Logo -->
      <a class="navbar-brand" href="#" onclick="goBack()">
        <img src="../Imagenes/logo.jpg" alt="Logo" height="100" class="me-2">
        Skynet
      </a>
       <!-- Formulario de búsqueda centrado -->
       <form class="d-flex mx-auto" method="GET" action="">
          <input class="form-control me-2" type="search" name="query" placeholder="Buscar usuario" aria-label="Buscar">
          <button class="btn btn-outline-success" type="submit">Buscar</button>
        </form>
      <!-- Contenido colapsable -->
      <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
        </ul>
      </div>
    </div>
  </nav>
    <div class="container-fluid custom-bg-blue p-5"> <!-- Agrega padding para ver el color -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg">
                    <div class="row no-gutters">
                        <div class="col-md-6 d-none d-md-block">
                            <img src="../Imagenes/vendedor.jpg" alt="Image" class="img-fluid">
                        </div>
                        <div class="col-md-6">
                            <div class="card-body">
                                <h2 class="card-title text-center mb-4">Agregar Usuario</h2>
                                <form class="row g-3" action="" method="POST">
                                    <div class="col-md-6">
                                        <label for="nombre" class="form-label">Nombre</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="apellidoPat" class="form-label">Apellido Paterno</label>
                                        <input type="text" class="form-control" id="apellidoPat" name="apellidoPat" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="apellidoMat" class="form-label">Apellido Materno</label>
                                        <input type="text" class="form-control" id="apellidoMat" name="apellidoMat" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="telefono" class="form-label">Teléfono</label>
                                        <input type="number" class="form-control" id="telefono" name="telefono" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="password" class="form-label">Contraseña</label>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary btn-block" name="submit">Agregar Usuario</button>
                                    </div>
                                </form>
                                <hr>
                                <?php
                                // Incluir el archivo de conexión a la base de datos
                                include '../Model/conexion.php';

                                // Verificar si se han enviado datos del formulario
                                if (isset($_POST['submit'])) {
                                    // Recuperar los datos del formulario
                                    $nombre = $_POST['nombre'];
                                    $apellidoPat = $_POST['apellidoPat'];
                                    $apellidoMat = $_POST['apellidoMat'];
                                    $telefono = $_POST['telefono'];
                                    $email = $_POST['email'];
                                    $password = $_POST['password'];

                                    // Preparar la consulta SQL
                                    $sql = "INSERT INTO usuario (nombre, apellidoPat, apellidoMat, telefono, email, password) 
                                            VALUES ('$nombre', '$apellidoPat', '$apellidoMat', '$telefono', '$email', '$password')";

                                    // Ejecutar la consulta
                                    if ($mysqli_conexion->query($sql) === TRUE) {
                                        // Redirigir al usuario a indexAdmi.php
                                        echo '<script>window.location.replace("indexAdmi.php");</script>';
                                        exit();
                                    } else {
                                        echo '<div class="alert alert-danger mt-3" role="alert">Error al agregar el usuario: ' . $mysqli_conexion->error . '</div>';
                                    }

                                    // Cerrar la conexión
                                    $mysqli_conexion->close();
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <h2>Vendedor</h2>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <!-- PHP para mostrar usuarios como tarjetas -->
            <?php
            // Incluir archivo de conexión a la base de datos
            include "../Model/conexion.php";

            // Obtener el término de búsqueda si existe
            $query = isset($_GET['query']) ? $_GET['query'] : '';

            // Consulta SQL para obtener los usuarios, filtrando si se ha enviado una búsqueda
            $sql = "SELECT * FROM usuario";
            if ($query != '') {
                $sql .= " WHERE nombre LIKE '%" . $mysqli_conexion->real_escape_string($query) . "%' OR apellidoPat LIKE '%" . $mysqli_conexion->real_escape_string($query) . "%' OR apellidoMat LIKE '%" . $mysqli_conexion->real_escape_string($query) . "%' OR email LIKE '%" . $mysqli_conexion->real_escape_string($query) . "%'";
            }
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

        function goBack() {
      window.history.back();
    }
    </script>


    <!-- Enlace a los archivos JavaScript de Bootstrap (opcional, solo si necesitas componentes que requieren JavaScript) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
