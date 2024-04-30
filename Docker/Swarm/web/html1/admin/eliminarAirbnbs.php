<?php
    session_start();
    $user_id = $_SESSION['user_id'];
    $name = $_SESSION['name'];
    $role = $_SESSION['role'];
    if ($role !== "Admin") {
        header("Location: ../index.html");
    }
?>
<!DOCTYPE html>
<html>

<head>
    <title>Eliminar Airbnbs</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
                    <li class="nav-item"><a class="nav-link" href="admin.php">Inicio</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Dashboard
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="#">PySpark</a></li>
                            <li><a class="dropdown-item" href="powerBI.php">PowerBI</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="mostrarAirbnbs.php">Mostrar Airbnbs</a></li>
                    <li class="nav-item"><a class="nav-link" href="crearAirbnbs.php">Crear Airbnbs</a></li>
                    <li class="nav-item"><a class="nav-link" href="actualizarAirbnbs.php">Actualizar Airbnbs</a></li>
                    <li class="nav-item"><a class="nav-link active" href="eliminarAirbnbs.php" aria-current="page">Eliminar Airbnbs</a></li>
                    <li class="nav-item"><a class="nav-link" href="reservas.php">Reservar Airbnbs</a></li>
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
    
    <div class="container mt-5">
        <form id="deleteForm" action="./php/procesarEliminar.php" method="post" class="form-group">
            <label for="id" class="form-label">ID del Airbnb:</label>
            <input type="text" id="id" name="id" class="form-control" required>
            <button type="submit" class="btn btn-danger mt-3">Eliminar Airbnb</button>
        </form>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

<script>
    window.onload = function() {
        const urlParams = new URLSearchParams(window.location.search);
        const success = urlParams.get('success');
        const error = urlParams.get('error');

        const id = urlParams.get('id');
        const hostID = urlParams.get('hostID');
        const hostName = urlParams.get('hostName');

        if (success && !error) {
            alert(`¡El airbnb de ${hostName} ha sido eliminado exitosamente!\nID del airbnb: ${id}\nID del host: ${hostID}`);
        } else if (error && !success) {
            alert(`El airbnb con ID ${id} no pudo ser eliminado.`);
        }
    }
</script>
</body>
</html>