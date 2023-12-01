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
    $txtAutor = (isset($_POST['txtAutor'])) ? $_POST['txtAutor'] : "";
    $txtImagen = (isset($_FILES['txtImagen']['name'])) ? $_FILES['txtImagen']['name'] : "";
    $accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";
    $txtTipo = (isset($_POST['txtTipo'])) ? $_POST['txtTipo'] : "";
    $txtdescripcion = (isset($_POST["txtdescripcion"])) ? $_POST["txtdescripcion"] : "";
    $txtlink = (isset($_POST["txtlink"])) ? $_POST["txtlink"] : "";

    include("./db/bd.php");

    switch ($accion) {
        case "Agregar":
            $sentenciaSQL = $conexion->prepare("INSERT INTO libros (nombre, Autor, descripcion, tipo, imagen, link ) VALUES (:nombre,:autor,:descripcion,:tipo,:imagen,:link)");
            $sentenciaSQL->bindParam(':nombre', $txtNombre);

            $fecha = new DateTime();
            $nombreArchivo = ($txtImagen != "") ? $fecha->getTimestamp() . "" . $_FILES["txtImagen"]["name"] : "imagen.jpg";

            $tmpImagen = $_FILES["txtImagen"]["tmp_name"];

            if ($tmpImagen != "") {

                move_uploaded_file($tmpImagen, "./img/Libros/" . $nombreArchivo);
            }

            $sentenciaSQL->bindParam(':autor', $txtAutor);
            $sentenciaSQL->bindParam(':imagen', $nombreArchivo);
            $sentenciaSQL->bindParam(':descripcion', $txtdescripcion);
            $sentenciaSQL->bindParam(':tipo', $txtTipo);
            $sentenciaSQL->bindParam(':link', $txtlink);
            $sentenciaSQL->execute();
            header("Location:agregar.php");
            break;

        case "Modificar":
            $sentenciaSQL = $conexion->prepare("UPDATE libros SET nombre=:nombre, Autor=:autor, tipo=:tipo, descripcion=:descripcion, link=:link  WHERE id=:id");
            $sentenciaSQL->bindParam(':id', $txtID);
            $sentenciaSQL->bindParam(':nombre', $txtNombre);
            $sentenciaSQL->bindParam(':autor', $txtAutor);
            $sentenciaSQL->bindParam(':descripcion', $txtdescripcion);
            $sentenciaSQL->bindParam(':tipo', $txtTipo);
            $sentenciaSQL->bindParam(':link', $txtlink);
            $sentenciaSQL->execute();

            if ($txtImagen != "") {

                $fecha = new DateTime();
                $nombreArchivo = ($txtImagen != "") ? $fecha->getTimestamp() . "" . $_FILES["txtImagen"]["name"] : "imagen.jpg";
                $tmpImagen = $_FILES["txtImagen"]["tmp_name"];

                move_uploaded_file($tmpImagen, "./img/Libros/" . $nombreArchivo);

                $sentenciaSQL = $conexion->prepare("SELECT imagen FROM libros WHERE id=:id");
                $sentenciaSQL->bindParam(':id', $txtID);
                $sentenciaSQL->execute();
                $libro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

                if (isset($libro["imagen"]) && ($libro["imagen"] != "imagen.jpg")) {

                    if (file_exists("./img/Libros/" . $libro["imagen"])) {

                        unlink("./img/Libros/" . $libro["imagen"]);

                    }

                }


                $sentenciaSQL = $conexion->prepare("UPDATE libros SET imagen=:imagen WHERE id=:id");
                $sentenciaSQL->bindParam(':id', $txtID);
                $sentenciaSQL->bindParam(':imagen', $nombreArchivo);
                $sentenciaSQL->execute();
            }
            header("Location:agregar.php");
            break;

        case "Cancelar":
            header("Location:agregar.php");
            break;

        case "Borrar":
            $sentenciaSQL = $conexion->prepare("SELECT imagen FROM libros WHERE id=:id");
            $sentenciaSQL->bindParam(':id', $txtID);
            $sentenciaSQL->execute();
            $libro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

            if (isset($libro["imagen"]) && ($libro["imagen"] != "imagen.jpg")) {

                if (file_exists("./img/Libros/" . $libro["imagen"])) {

                    unlink("./img/Libros/" . $libro["imagen"]);

                }

            }


            $sentenciaSQL = $conexion->prepare("DELETE FROM libros WHERE id=:id");
            $sentenciaSQL->bindParam(':id', $txtID);
            $sentenciaSQL->execute();
            header("Location:agregar.php");
            break;

        case "Seleccionar":
            $sentenciaSQL = $conexion->prepare("SELECT * FROM libros WHERE id=:id");
            $sentenciaSQL->bindParam(':id', $txtID);
            $sentenciaSQL->execute();
            $libro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);
            $txtNombre = $libro['nombre'];
            $txtAutor = $libro['Autor'];
            $txtTipo = $libro['tipo'];
            $txtdescripcion = $libro['descripcion'];
            $txtImagen = $libro['imagen'];
            $txtlink = $libro['link'];
            break;
    }

    $sentenciaSQL = $conexion->prepare("SELECT * FROM libros");
    $sentenciaSQL->execute();
    $listaLibros = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);


    ?>

    <div class="col-md-7 mx-auto text-center">
        <div class="card">
            <div class="card-header ">
                Libros
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
                                <label for="txtAutor">Autor</label>
                                <select class="form-select" name="txtAutor" id="txtAutor" required>
                                    <option value="">Autor</option>
                                    <?php
                                    $sentenciaAutores = $conexion->prepare("SELECT id, nombre FROM autores");
                                    $sentenciaAutores->execute();
                                    $autores = $sentenciaAutores->fetchAll(PDO::FETCH_ASSOC);

                                    foreach ($autores as $autor) {
                                        $selected = ($txtAutor == $autor['nombre']) ? 'selected' : '';
                                        echo "<option value='{$autor['nombre']}' {$selected}>{$autor['nombre']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>


                        <div class="col-md-4 mt-2">
                            <div class="form-group text-start">
                                <label for="txtlink">Link</label>
                                <input type="text" required class="form-control" value="<?php echo $txtlink; ?>"
                                    name="txtlink" id="txtlink" placeholder="Link">
                            </div>
                        </div>

                        <br>
                        <div class="col-md-4 mt-2">
                            <div class="form-group text-start">
                                <label for="txtTipo">Tipo</label>
                                <select id="txtTipo" class="form-select" name="txtTipo" required>
                                    <option <?php if ($txtTipo === 'Manga')
                                        echo 'selected'; ?>>Manga</option>
                                    <option <?php if ($txtTipo === 'Manhua')
                                        echo 'selected'; ?>>Manhua</option>
                                    <option <?php if ($txtTipo === 'Manhwa')
                                        echo 'selected'; ?>>Manhwa</option>
                                    <option <?php if ($txtTipo === 'Novela')
                                        echo 'selected'; ?>>Novela</option>
                                    <option <?php if ($txtTipo === 'Cuento')
                                        echo 'selected'; ?>>Cuento</option>
                                    <option <?php if ($txtTipo === 'One Shot')
                                        echo 'selected'; ?>>One Shot</option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <br>
                    <div class="mb-3 text-start">
                        <label for="txtdescripcion" class="form-label ">Descripcion</label>
                        <textarea class="form-control" id="txtdescripcion" name="txtdescripcion"
                            rows="3"><?php echo $txtdescripcion; ?></textarea>
                    </div>


                    <br>

                    <div class="form-group text-start">
                        <label for="txtImagen">Imagen</label>

                        <?php echo $txtImagen; ?>

                        <?php if ($txtImagen != "") { ?>
                        <?php } ?>

                        <input type="file" class="form-control" name="txtImagen" id="txtImagen">
                    </div>

                    <br>


                    <div class="btn-group" role="group" aria-label="">
                        <button type="submit" class="btn btn-success" name="accion" <?php echo ($accion == "Seleccionar") ? "disabled" : ""; ?> value="Agregar">Agregar</button>
                        <button type="submit" class="btn btn-warning" name="accion" <?php echo ($accion != "Seleccionar") ? "disabled" : ""; ?> value="Modificar">Modificar</button>
                        <button type="submit" class="btn btn-info" name="accion" <?php echo ($accion != "Seleccionar") ? "disabled" : ""; ?> value="Cancelar">Cancelar</button>
                        <br>
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
                        <th>Autor</th>
                        <th>Tipo</th>
                        <th>Descripción</th>
                        <th>Link</th>
                        <th>Imagen</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($listaLibros as $libro) { ?>
                        <tr>
                            <td>
                                <?php echo ($libro['id']); ?>
                            </td>
                            <td>
                                <?php echo ($libro['nombre']); ?>
                            </td>
                            <td>
                                <?php echo $libro['Autor']; ?>
                            </td>
                            <td>
                                <?php echo $libro['tipo']; ?>
                            </td>
                            <td>
                                <?php echo ($libro['descripcion']); ?>
                            </td>
                            <td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100%;">
                                <?php echo mb_substr($libro['link'], 0, 20, 'UTF-8'); ?>
                            </td>
                            <td>
                                <img class="img-thumbnail rounded mx-auto" src="./img/Libros/<?php echo $libro['imagen']; ?>"
                                    width="100" alt="">
                            </td>
                            <td>
                                <form method="post">
                                    <input type="hidden" name="txtID" id="txtID" value="<?php echo $libro['id']; ?>" />
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