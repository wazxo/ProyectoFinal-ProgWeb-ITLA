<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Enlace a la hoja de estilos -->
    <link rel="stylesheet" href="./css/stylebiblio.css">

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

    $txtNombre = (isset($_POST['txtNombre'])) ? $_POST['txtNombre'] : "";
    $txtAsunto = (isset($_POST['txtAsunto'])) ? $_POST['txtAsunto'] : "";
    $txtCorreo = (isset($_POST['txtCorreo'])) ? $_POST['txtCorreo'] : "";
    $txtComentario = (isset($_POST["txtComentario"])) ? $_POST["txtComentario"] : "";
    $accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

    include("./db/bd.php");

    switch ($accion) {
        case "Agregar":
            $sentenciaSQL = $conexion->prepare("INSERT INTO contacto (fecha, correo, nombre, asunto, comentario) VALUES (NOW(), :correo, :nombre, :asunto, :comentario)");
            $sentenciaSQL->bindParam(':correo', $txtCorreo);
            $sentenciaSQL->bindParam(':nombre', $txtNombre);
            $sentenciaSQL->bindParam(':asunto', $txtAsunto);
            $sentenciaSQL->bindParam(':comentario', $txtComentario);
            $sentenciaSQL->execute();
            header("Location:agregar.php");
            break;

        case "Cancelar":
            header("Location:agregar.php");
            break;
    }

    $sentenciaSQL = $conexion->prepare("SELECT * FROM contacto");
    $sentenciaSQL->execute();
    $listaContactos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
    ?>



    <div class="col-md-7 mx-auto text-center">
        <div class="card">
            <div class="card-header ">
                Libros
            </div>

            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group text-start">
                                <label for="txtNombre">Nombre</label>
                                <input type="text" required class="form-control" value="<?php echo $txtNombre; ?>"
                                    name="txtNombre" id="txtNombre" placeholder="Nombre">
                            </div>
                        </div>
                        <br>
                        <div class="col-md-4">
                            <div class="form-group text-start">
                                <label for="txtAsunto">Asunto</label>
                                <input type="text" required class="form-control" value="<?php echo $txtAsunto; ?>"
                                    name="txtAsunto" id="txtAsunto" placeholder="Asunto">
                            </div>
                        </div>
                        <br>
                        <div class="col-md-4">
                            <div class="form-group text-start">
                                <label for="txtCorreo">Correo</label>
                                <input type="text" required class="form-control" value="<?php echo $txtCorreo; ?>"
                                    name="txtCorreo" id="txtCorreo" placeholder="Correo">
                            </div>
                        </div>
                    </div>

                    <br>
                    <div class="mb-3 text-start">
                        <label for="txtComentario" class="form-label ">Comentario</label>
                        <textarea class="form-control" id="txtComentario" name="txtComentario"
                            rows="3"><?php echo $txtComentario; ?></textarea>
                    </div>

                    <br>


                    <div class="btn-group" role="group" aria-label="">
                        <button type="submit" class="btn btn-success" name="accion" value="Agregar">Enviar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <br>

    <div class="col-md-11 mx-auto text-center">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Asunto</th>
                    <th>Comentario</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listaContactos as $contacto) { ?>
                    <tr>
                        <td>
                            <?php echo $contacto['id']; ?>
                        </td>
                        <td>
                            <?php echo $contacto['nombre']; ?>
                        </td>
                        <td>
                            <?php echo $contacto['correo']; ?>
                        </td>
                        <td>
                            <?php echo $contacto['asunto']; ?>
                        </td>
                        <td>
                            <?php echo $contacto['comentario']; ?>
                        </td>
                        <td>
                            <?php echo $contacto['fecha']; ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="futter">
        <footer class="py-3 my-4">
            <p class="text-center text-center ">© 2023 Company, Inc</p>
        </footer>
    </div>

</body>

</html>