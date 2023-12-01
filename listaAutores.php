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

    <style>
        .card {
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
    </style>


    <header>
        <img src="" alt="">
    </header>

    <?php
    include("./db/bd.php");

    $terminoBusqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';
    $sentenciaSQL = $conexion->prepare("SELECT * FROM autores WHERE nombre LIKE :termino OR nacionalidad LIKE :termino ORDER BY id DESC ");
    $terminoBusqueda = '%' . $terminoBusqueda . '%';
    $sentenciaSQL->bindParam(':termino', $terminoBusqueda, PDO::PARAM_STR);
    $sentenciaSQL->execute();
    $listaAutores = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="search">
                    <i class="fa fa-search"></i>
                    <form action="listaAutores.php" method="GET">
                        <label for="busqueda" class="visually-hidden">Buscar autores</label>
                        <input type="text" class="form-control" id="busqueda" name="busqueda"
                            placeholder="¿Qué estás buscando?">
                        <button type="submit" class="btn btn-primary">Buscar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <div class="row">
            <?php if (!empty($listaAutores)) { ?>
                <?php foreach ($listaAutores as $autor) { ?>
                    <div class="col-4 col-md-2 mb-4 mt-4 libro-card">
                        <div class="card">
                            <img src="./img/Autores/<?php echo $autor['imagen']; ?>" class="card-img-top" alt=""
                                style="object-fit: cover; height: 150px;">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <?php echo mb_substr($autor['nombre'], 0, 20, 'UTF-8'); ?>
                                </h5>
                                <h6>
                                    <?php echo mb_substr($autor['nacionalidad'], 0, 20, 'UTF-8'); ?>
                                </h6>
                            </div>
                            <div class="card-footer p-0 px-2 text-center">
                                <span>
                                    <?php echo ($autor['fecha_nacimiento']); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div class="col-md-12 mt-4">
                    <p class="text-center">No se encontraron resultados.</p>
                </div>
            <?php } ?>
        </div>
    </div>




    <div class="futter">
        <footer class="py-3 my-4">
            <p class="text-center text-center ">© 2023 Company, Inc</p>
        </footer>
    </div>

</body>

</html>