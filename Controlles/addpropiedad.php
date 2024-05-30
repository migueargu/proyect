<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Propiedad</title>
    <!-- Enlace a los archivos CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Enlace a Animate.css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <!-- Enlace a la fuente de Google Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    
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
          <input class="form-control me-2" type="search" name="query" placeholder="Buscar propiedad" aria-label="Buscar">
          <button class="btn btn-outline-success" type="submit">Buscar</button>
        </form>
            <!-- Contenido colapsable -->
            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            </div>
        </div>
    </nav>
    <div class="container-fluid custom-bg-blue p-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg">
                    <div class="row no-gutters">
                        <div class="col-md-6 d-none d-md-block">
                            <img src="../Imagenes/hogar.jpg" alt="Image" class="img-fluid">
                        </div>
                        <div class="col-md-6">
                            <div class="card-body">
                                <h2 class="card-title text-center mb-4">Agregar Propiedad</h2>
                                <form class="row g-3" action="" method="POST">
                                    <div class="col-md-6">
                                        <label for="monto" class="form-label">Monto</label>
                                        <input type="number" class="form-control" id="monto" name="monto" step="0.01" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="ubicacion" class="form-label">Ubicación</label>
                                        <input type="text" class="form-control" id="ubicacion" name="ubicacion" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="inmueble_id" class="form-label">Inmueble</label>
                                        <select class="form-select" id="inmueble_id" name="inmueble_id" required>
                                            <option value="">Selecciona un inmueble</option>
                                            <?php
                                            // Incluir el archivo de conexión a la base de datos
                                            include '../Model/conexion.php';

                                            // Consulta SQL para obtener los datos de la tabla inmueble
                                            $sql = "SELECT inmueble_id, inmueble FROM inmueble";
                                            $result = $mysqli_conexion->query($sql);

                                            // Verificar si hay resultados
                                            if ($result->num_rows > 0) {
                                                // Iterar sobre los resultados y mostrar cada inmueble como opción en el combobox
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<option value='" . $row["inmueble_id"] . "'>" . $row["inmueble"] . "</option>";
                                                }
                                            } else {
                                                echo "<option value=''>No hay inmuebles disponibles</option>";
                                            }

                                            // Liberar resultado
                                            $result->free_result();
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary btn-block" name="submit">Guardar Propiedad</button>
                                    </div>
                                </form>
                                <hr>
                                <?php
                                // Verificar si se han enviado datos del formulario
                                if (isset($_POST['submit'])) {
                                    // Recuperar los datos del formulario
                                    $monto = $_POST['monto'];
                                    $ubicacion = $_POST['ubicacion'];
                                    $inmueble_id = $_POST['inmueble_id'];

                                    // Preparar la consulta SQL
                                    $sql = "INSERT INTO propiedad (monto, ubicacion, inmueble_id) 
                                            VALUES ('$monto', '$ubicacion', '$inmueble_id')";

                                    // Ejecutar la consulta
                                    if ($mysqli_conexion->query($sql) === TRUE) {
                                        // Redirigir al usuario a indexAdmi.php
                                        echo '<script>window.location.replace("indexAdmi.php");</script>';
                                        exit();
                                    } else {
                                        echo '<div class="alert alert-danger mt-3" role="alert">Error al guardar la propiedad: ' . $mysqli_conexion->error . '</div>';
                                    }
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
    <h2>Propiedades</h2>
    <!-- Fin del formulario de búsqueda -->
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <!-- PHP para mostrar propiedades como tarjetas -->
        <?php
        // Incluir archivo de conexión a la base de datos
        include "../Model/conexion.php";

        // Obtener el término de búsqueda si existe
        $query = isset($_GET['query']) ? $_GET['query'] : '';

        // Consulta SQL para obtener las propiedades con información del inmueble
        $sql_propiedades = "SELECT p.home_id, p.monto, p.ubicacion, i.inmueble
                            FROM propiedad p
                            INNER JOIN inmueble i ON p.inmueble_id = i.inmueble_id";
        if ($query != '') {
            $sql_propiedades .= " WHERE p.ubicacion LIKE '%" . $mysqli_conexion->real_escape_string($query) . "%' OR p.monto LIKE '%" . $mysqli_conexion->real_escape_string($query) . "%' OR i.inmueble LIKE '%" . $mysqli_conexion->real_escape_string($query) . "%'";
        }
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

<button id="back-to-top">↑</button>

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

    function goBack() {
      window.history.back();
    }
</script>



    <!-- Enlace a los archivos JavaScript de Bootstrap (opcional, solo si necesitas componentes que requieren JavaScript) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
  <script src="../javascript/index.js"></script> <!-- Nuevo enlace para el JavaScript del botón -->
</body>
</html>
