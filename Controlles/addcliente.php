<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Cliente</title>
    <!-- Enlace a los archivos CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Enlace al archivo CSS personalizado -->
    <link rel="stylesheet" href="addclient.css">
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
          <input class="form-control me-2" type="search" name="query" placeholder="Buscar cliente" aria-label="Buscar">
          <button class="btn btn-outline-success" type="submit">Buscar</button>
        </form>
            <!-- Contenido colapsable -->
            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <!-- Lista de enlaces -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <!-- Agrega más elementos según necesites -->
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
                            <img src="../Imagenes/cliente.png" alt="Image" class="img-fluid">
                        </div>
                        <div class="col-md-6">
                            <div class="card-body">
                                <h2 class="card-title text-center mb-4">Agregar Cliente</h2>
                                <form class="row g-3" action="" method="POST">
                                    <div class="col-md-6">
                                        <label for="nombrecliente" class="form-label">Nombre</label>
                                        <input type="text" class="form-control" id="nombrecliente" name="nombrecliente" value="<?php echo isset($_POST['nombrecliente']) ? $_POST['nombrecliente'] : ''; ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="apellidopa" class="form-label">Apellido Paterno</label>
                                        <input type="text" class="form-control" id="apellidopa" name="apellidopa" value="<?php echo isset($_POST['apellidopa']) ? $_POST['apellidopa'] : ''; ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="apellidomat" class="form-label">Apellido Materno</label>
                                        <input type="text" class="form-control" id="apellidomat" name="apellidomat" value="<?php echo isset($_POST['apellidomat']) ? $_POST['apellidomat'] : ''; ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="correo" class="form-label">Correo</label>
                                        <input type="email" class="form-control" id="correo" name="correo" value="<?php echo isset($_POST['correo']) ? $_POST['correo'] : ''; ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="numero" class="form-label">Número</label>
                                        <input type="number" class="form-control" id="numero" name="numero" value="<?php echo isset($_POST['numero']) ? $_POST['numero'] : ''; ?>" required>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary btn-block" name="submit">Agregar Cliente</button>
                                    </div>
                                </form>
                                <?php
                                // Incluir el archivo de conexión a la base de datos
                                include '../Model/conexion.php';

                                // Verificar si se han enviado datos del formulario
                                if (isset($_POST['submit'])) {
                                    // Recuperar los datos del formulario
                                    $nombrecliente = $_POST['nombrecliente'];
                                    $apellidopa = $_POST['apellidopa'];
                                    $apellidomat = $_POST['apellidomat'];
                                    $correo = $_POST['correo'];
                                    $numero = $_POST['numero'];

                                    // Preparar la consulta SQL
                                    $sql = "INSERT INTO cliente (nombrecliente, apellidopa, apellidomat, correo, numero) 
                                            VALUES ('$nombrecliente', '$apellidopa', '$apellidomat', '$correo', '$numero')";

                                    // Ejecutar la consulta
                                    if ($mysqli_conexion->query($sql) === TRUE) {
                                        //echo '<div class="alert alert-success mt-3" role="alert">Cliente agregado correctamente</div>';
                                        echo '<script>window.location.replace("indexAdmi.php");</script>';
                                        exit();
                                    } else {
                                        echo '<div class="alert alert-danger mt-3" role="alert">Error al agregar el cliente: ' . $mysqli_conexion->error . '</div>';
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
    <h2>Clientes</h2>
   
    <!-- Fin del formulario de búsqueda -->
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <!-- PHP para mostrar clientes como tarjetas -->
        <?php
        // Incluir archivo de conexión a la base de datos
        include "../Model/conexion.php";

        // Obtener el término de búsqueda si existe
        $query_cliente = isset($_GET['query']) ? $_GET['query'] : '';

        // Consulta SQL para obtener los clientes, filtrando si se ha enviado una búsqueda
        $sql_clientes = "SELECT * FROM cliente";
        if ($query_cliente != '') {
            $sql_clientes .= " WHERE nombrecliente LIKE '%" . $mysqli_conexion->real_escape_string($query_cliente) . "%' OR apellidopa LIKE '%" . $mysqli_conexion->real_escape_string($query_cliente) . "%' OR apellidomat LIKE '%" . $mysqli_conexion->real_escape_string($query_cliente) . "%' OR correo LIKE '%" . $mysqli_conexion->real_escape_string($query_cliente) . "%'";
        }
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

<!-- Botón flotante para volver arriba -->
<button id="back-to-top" class="btn btn-primary position-fixed bottom-0 end-0 mb-4 me-4" style="display: none;">↑</button>


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


    function goBack() {
      window.history.back();
    }

    <script>
        // Mostrar/ocultar el botón de volver arriba
        window.onscroll = function() {
            var backToTopButton = document.getElementById('back-to-top');
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                backToTopButton.style.display = 'block';
            } else {
                backToTopButton.style.display = 'none';
            }
        };

        // Funcionalidad para volver arriba
        document.getElementById('back-to-top').addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

</script>





    <!-- Enlace a los archivos JavaScript de Bootstrap (opcional, solo si necesitas componentes que requieren JavaScript) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
