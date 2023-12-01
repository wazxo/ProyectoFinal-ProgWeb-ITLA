<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Enlace a la hoja de estilos -->
    <link rel="stylesheet" href="./css/style.css">

    <script src="./script.js"></script>

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
    <div id="mainNavigation" class="fixed-top navbar-sm">
        <nav role="navigation">
            <!-- Sección superior de la barra de navegación -->
            <div class="py-2 text-center border-bottom">
                <img src="./img/Logo ANTRA.png" alt="Logo ANTRA" href="index.php">
            </div>
        </nav>
        <!-- Sección inferior de la barra de navegación -->
        <div class="navbar-expand-sm">
            <!-- Botón de menú para dispositivos móviles -->
            <div class="navbar-dark text-center my-1">
                <button class="navbar-toggler w-10" type="button" data-bs-toggle="collapse"
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
        <!-- Capa superpuesta que permite oscurecer el video para que el texto sea legible -->
        <div class="overlay"></div>
        <!-- Etiqueta de video que muestra un archivo .mp4 como fondo -->
        <video playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop">
            <source src="img/Libreria.mp4" type="video/mp4">
        </video>
    </header>
    <!-- me canse de comentar xd -->


    <style>
        .card {
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
    </style>


    <?php
    include("./db/bd.php");

    $sentenciaSQL = $conexion->prepare("SELECT * FROM libros ORDER BY id DESC LIMIT 12");
    $sentenciaSQL->execute();
    $listaLibros = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div class="container-sm mt-5">
        <h2 class="text-center mb-4">Ultimos Agregados</h2>
        <div class="row">
            <?php foreach ($listaLibros as $libro) { ?>
                <div class="col-4 col-md-2 mb-1 mt-4 libro-card" data-link="<?php echo $libro['link']; ?>">
                    <div class="card">
                        <img src="./img/Libros/<?php echo $libro['imagen']; ?>" class="card-img-top" alt=""
                            style="object-fit: cover; aspect-ratio: 2/3;">
                        <div class="card-body">
                            <h5 class="card-title"
                                style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100%; font-size: calc(1.2vw + 0.5em);">
                                <?php echo mb_substr($libro['nombre'], 0, 20, 'UTF-8'); ?>
                            </h5>
                            <h6
                                style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100%; font-size: calc(1.2vw + 0.3em);">
                                Autor:
                                <?php echo mb_substr($libro['Autor'], 0, 20, 'UTF-8'); ?>
                            </h6>
                        </div>
                        <div class="card-footer p-0 px-2 text-center">
                            <span style="font-size: 0.8rem;">
                                <?php echo ($libro['tipo']); ?>
                            </span>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <br>
    <br>


    <?php
    include("./db/bd.php");

    $sentenciaSQL = $conexion->prepare("SELECT * FROM contacto ORDER BY fecha DESC LIMIT 12");
    $sentenciaSQL->execute();
    $listaContactos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Comentarios</h2>
        <br>
        <div class="row">
            <?php foreach ($listaContactos as $contacto) { ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php echo ($contacto['nombre']); ?>
                            </h5>
                            <h6 class="card-subtitle mb-2 text-muted">
                                Asunto:
                                <?php echo ($contacto['asunto']); ?>
                            </h6>
                            <p class="card-text">
                                <?php echo ($contacto['comentario']); ?>
                            </p>
                        </div>
                        <div class="card-footer text-start">
                            <p>
                                <?php echo ($contacto['fecha']); ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

















    <div class="futter">
        <footer class="py-3 my-4">
            <ul class="nav justify-content-center text-center border-bottom pb-3 mb-3 fw-bold">
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Inicio</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Servicios</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Productos</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Nosotros</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Contacto</a></li>
            </ul>
            <p class="text-center text-center ">© 2023 Company, Inc</p>
        </footer>
    </div>

</body>

</html>