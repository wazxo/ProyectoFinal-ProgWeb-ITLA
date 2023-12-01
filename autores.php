<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Enlace a la hoja de estilos -->
    <link rel="stylesheet" href="./css/styleAgregar.css">

    <!-- Icono de la página web -->
    <link rel="shortcut icon" href="./img/Icono web.png" style="object-fit: cover" type="img/x-icon">

    <!-- Enlaces a las fuentes de Google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;1,100;1,900&family=Noto+Sans:ital,wght@1,100&family=Roboto&display=swap"
        rel="stylesheet">

    <!-- Enlace al framework Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

    <!-- Título de la página -->
    <title>ANTRA</title>
</head>


<body>

    <div id="mainNavigation" class="fixed-top">
        <nav role="navigation">
            <!-- Sección superior de la barra de navegación -->
            <div class="py-2 text-center border-bottom">
                <img src="./img/Logo ANTRA.png" alt="Logo ANTRA" href="#">
            </div>
        </nav>
        <!-- Sección inferior de la barra de navegación -->
        <div class="navbar-expand-sm">
            <!-- Botón de menú para dispositivos móviles -->
            <div class="navbar-dark text-center my-2">
                <button class="navbar-toggler w-25" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    <span class="align-middle"></span>
                </button>
            </div>
            <!-- Lista de enlaces de navegación -->
            <div class="text-center mt-2 collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav mx-auto ">
                    <li class="nav-item">
                        <a class="nav-link active fw-bold" aria-current="page" href="index.php">INICIO</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="agregar.php">AGREGAR</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="biblioteca.php">BIBLIOTECA</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="contacto.php">CONTACTO</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link fw-bold dropdown-toggle" href="#" id="autoresDropdown" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            AUTORES
                        </a>
                        <div class="dropdown-menu" aria-labelledby="autoresDropdown">
                            <a class="dropdown-item" href="listaAutores.php">Ver Todos</a>
                            <a class="dropdown-item" href="autores.php">Agregar</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <header>

    </header>

    <?php
    $txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
    $txtNombre = (isset($_POST['txtNombre'])) ? $_POST['txtNombre'] : "";
    $txtNacionalidad = (isset($_POST['txtNacionalidad'])) ? $_POST['txtNacionalidad'] : "";
    $txtFechaNacimiento = (isset($_POST['txtFechaNacimiento'])) ? $_POST['txtFechaNacimiento'] : "";
    $txtFechaDefuncion = (isset($_POST['txtFechaDefuncion'])) ? $_POST['txtFechaDefuncion'] : "";
    $txtBiografia = (isset($_POST['txtBiografia'])) ? $_POST['txtBiografia'] : "";
    $txtImagen = (isset($_FILES['txtImagen']['name'])) ? $_FILES['txtImagen']['name'] : "";
    $accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

    include("./db/bd.php");

    switch ($accion) {
        case "Agregar":
            $sentenciaSQL = $conexion->prepare("INSERT INTO autores (nombre, nacionalidad, fecha_nacimiento, fecha_defuncion, biografia, imagen) VALUES (:nombre, :nacionalidad, :fecha_nacimiento, :fecha_defuncion, :biografia, :imagen)");
            $sentenciaSQL->bindParam(':nombre', $txtNombre);

            $fecha = new DateTime();
            $nombreArchivo = ($txtImagen != "") ? $fecha->getTimestamp() . "" . $_FILES["txtImagen"]["name"] : "imagen.jpg";

            $tmpImagen = $_FILES["txtImagen"]["tmp_name"];

            if ($tmpImagen != "") {

                move_uploaded_file($tmpImagen, "./img/Autores/" . $nombreArchivo);
            }


            $sentenciaSQL->bindParam(':imagen', $nombreArchivo);
            $sentenciaSQL->bindParam(':nacionalidad', $txtNacionalidad);
            $sentenciaSQL->bindParam(':fecha_nacimiento', $txtFechaNacimiento);
            $sentenciaSQL->bindParam(':fecha_defuncion', $txtFechaDefuncion);
            $sentenciaSQL->bindParam(':biografia', $txtBiografia);
            $sentenciaSQL->execute();
            header("Location: autores.php");
            break;

        case "Modificar":
            $sentenciaSQL = $conexion->prepare("UPDATE autores SET nombre=:nombre, nacionalidad=:nacionalidad, fecha_nacimiento=:fecha_nacimiento, fecha_defuncion=:fecha_defuncion, biografia=:biografia WHERE id=:id");
            $sentenciaSQL->bindParam(':id', $txtID);
            $sentenciaSQL->bindParam(':nombre', $txtNombre);
            $sentenciaSQL->bindParam(':nacionalidad', $txtNacionalidad);
            $sentenciaSQL->bindParam(':fecha_nacimiento', $txtFechaNacimiento);
            $sentenciaSQL->bindParam(':fecha_defuncion', $txtFechaDefuncion);
            $sentenciaSQL->bindParam(':biografia', $txtBiografia);
            $sentenciaSQL->execute();

            if ($txtImagen != "") {

                $fecha = new DateTime();
                $nombreArchivo = ($txtImagen != "") ? $fecha->getTimestamp() . "" . $_FILES["txtImagen"]["name"] : "imagen.jpg";
                $tmpImagen = $_FILES["txtImagen"]["tmp_name"];

                move_uploaded_file($tmpImagen, "./img/Autores/" . $nombreArchivo);

                $sentenciaSQL = $conexion->prepare("SELECT imagen FROM libros WHERE id=:id");
                $sentenciaSQL->bindParam(':id', $txtID);
                $sentenciaSQL->execute();
                $libro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

                if (isset($libro["imagen"]) && ($libro["imagen"] != "imagen.jpg")) {

                    if (file_exists("./img/Autores/" . $libro["imagen"])) {

                        unlink("./img/Autores/" . $libro["imagen"]);

                    }

                }


                $sentenciaSQL = $conexion->prepare("UPDATE autores SET imagen=:imagen WHERE id=:id");
                $sentenciaSQL->bindParam(':id', $txtID);
                $sentenciaSQL->bindParam(':imagen', $nombreArchivo);
                $sentenciaSQL->execute();
            }

            header("Location: autores.php");
            break;

        case "Cancelar":
            header("Location: autores.php");
            break;

        case "Borrar":
            $sentenciaSQL = $conexion->prepare("DELETE FROM autores WHERE id=:id");
            $sentenciaSQL->bindParam(':id', $txtID);
            $sentenciaSQL->execute();
            header("Location: autores.php");
            break;

        case "Seleccionar":
            $sentenciaSQL = $conexion->prepare("SELECT * FROM autores WHERE id=:id");
            $sentenciaSQL->bindParam(':id', $txtID);
            $sentenciaSQL->execute();
            $autor = $sentenciaSQL->fetch(PDO::FETCH_LAZY);
            $txtNombre = $autor['nombre'];
            $txtNacionalidad = $autor['nacionalidad'];
            $txtFechaNacimiento = $autor['fecha_nacimiento'];
            $txtFechaDefuncion = $autor['fecha_defuncion'];
            $txtBiografia = $autor['biografia'];
            $txtImagen = $autor['imagen'];
            break;
    }

    $sentenciaSQL = $conexion->prepare("SELECT * FROM autores");
    $sentenciaSQL->execute();
    $listaAutores = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
    ?>


    <div class="col-md-7 mx-auto text-center">
        <div class="card">
            <div class="card-header">
                Autores
            </div>

            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-4 mt-2">
                            <div class="form-group text-start">
                                <label for="txtID">ID</label>
                                <input type="text" required readonly class="form-control" value="<?php echo $txtID; ?>"
                                    name="txtID" id="txtID" placeholder="ID">
                            </div>
                        </div>

                        <div class="col-md-4 mt-2">
                            <div class="form-group text-start">
                                <label for="txtNombre">Nombre</label>
                                <input type="text" required class="form-control" value="<?php echo $txtNombre; ?>"
                                    name="txtNombre" id="txtNombre" placeholder="Nombre">
                            </div>
                        </div>

                        <div class="col-md-4 mt-2">
                            <div class="form-group text-start">
                                <label for="txtNacionalidad">Nacionalidad</label>
                                <input type="text" required class="form-control" value="<?php echo $txtNacionalidad; ?>"
                                    name="txtNacionalidad" id="txtNacionalidad" placeholder="Nacionalidad">
                            </div>
                        </div>

                        <div class="col-md-4 mt-2">
                            <div class="form-group text-start">
                                <label for="txtFechaNacimiento">Fecha de Nacimiento</label>
                                <input type="date" required class="form-control"
                                    value="<?php echo $txtFechaNacimiento; ?>" name="txtFechaNacimiento"
                                    id="txtFechaNacimiento">
                            </div>
                        </div>

                        <div class="col-md-4 mt-2">
                            <div class="form-group text-start">
                                <label for="txtFechaDefuncion">Fecha de Defunción</label>
                                <input type="date" class="form-control" value="<?php echo $txtFechaDefuncion; ?>"
                                    name="txtFechaDefuncion" id="txtFechaDefuncion">
                            </div>
                        </div>

                        <br>
                        <div class="col-md-4 mt-2">
                            <div class="form-group text-start">
                                <label for="txtBiografia">Biografía</label>
                                <textarea class="form-control" id="txtBiografia" name="txtBiografia"
                                    rows="3"><?php echo $txtBiografia; ?></textarea>
                            </div>
                        </div>
                        <br>
                        <div class="form-group text-start">
                            <label for="txtImagen">Imagen</label>

                            <?php echo $txtImagen; ?>

                            <?php if ($txtImagen != "") { ?>
                            <?php } ?>

                            <input type="file" class="form-control" name="txtImagen" id="txtImagen">
                        </div>

                    </div>

                    <br>

                    <div class="btn-group" role="group" aria-label="">
                        <button type="submit" class="btn btn-success" name="accion" <?php echo ($accion == "Seleccionar") ? "disabled" : ""; ?> value="Agregar">Agregar</button>
                        <button type="submit" class="btn btn-warning" name="accion" <?php echo ($accion != "Seleccionar") ? "disabled" : ""; ?> value="Modificar">Modificar</button>
                        <button type="submit" class="btn btn-info" name="accion" <?php echo ($accion != "Seleccionar") ? "disabled" : ""; ?> value="Cancelar">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <br>


    <div class="col-md-11 mx-auto text-center">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Nacionalidad</th>
                    <th>Fecha Nacimiento</th>
                    <th>Fecha Defuncion</th>
                    <th>Biografía</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listaAutores as $autor) { ?>
                    <tr>
                        <td><?php echo $autor['id']; ?></td>
                        <td><?php echo $autor['nombre']; ?></td>
                        <td><?php echo $autor['nacionalidad']; ?></td>
                        <td><?php echo $autor['fecha_nacimiento']; ?></td>
                        <td>
                            <?php echo $autor['fecha_defuncion']; ?>
                        </td>
                        <td>
                            <?php echo $autor['biografia']; ?>
                        </td>
                        <td>
                            <img class="img-thumbnail rounded mx-auto" src="./img/Autores/<?php echo $autor['imagen']; ?>"
                                width="100" alt="">
                        </td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="txtID" id="txtID" value="<?php echo $autor['id']; ?>" />
                                <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary" />
                                <input type="submit" name="accion" value="Borrar" class="btn btn-danger" />
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>





    <div class="futter">
        <footer class="py-3 my-4">
            <p class="text-center text-center ">© 2023 Company, Inc</p>
        </footer>
    </div>

</body>

</html>