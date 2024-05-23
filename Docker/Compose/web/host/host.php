<?php
    session_start();
    $user_id = $_SESSION['user_id'];
    $name = $_SESSION['name'];
    $role = $_SESSION['role'];
    if ($role !== "Host") {
        header("Location: ../index.html");
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Airbnb Platform</title>
</head>

<body>
    <header class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <div class="container">
            <div class="navbar-brand">
                <h1>Airbnb Platform</h1>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <nav class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link active" href="host.php" aria-current="page">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="misAirbnbs.php">Mis Airbnbs</a></li>
                    <li class="nav-item"><a class="nav-link" href="crearAirbnbsHost.php">Crear Airbnbs</a></li>
                    <li class="nav-item"><a class="nav-link" href="actualizarAirbnbsHost.php">Actualizar Airbnbs</a></li>
		    <li class="nav-item"><a class="nav-link" href="eliminarAirbnbsHost.php">Eliminar Airbnbs</a></li>
                    <li class="nav-item"><a class="nav-link" href="reservasHost.php">Reservas Airbnbs</a></li>
                    <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                          <?php echo $name; ?>
                      </a>
                      <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                          <li><a class="dropdown-item" href="../logout/logout.php">Cerrar sesión</a></li>
                      </ul>
                  </li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container text-center mt-5">
        <h2>Welcome <?php echo $name; ?>!</h2>
        <p class="lead">This is your <?php echo $role; ?> page</p>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
    
</body>
</html>
