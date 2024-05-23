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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Airbnbs</title>
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
                            <li><a class="dropdown-item" href="pySpark.php">PySpark</a></li>
                            <li><a class="dropdown-item" href="powerBI.php">PowerBI</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="mostrarAirbnbs.php">Mostrar Airbnbs</a></li>
                    <li class="nav-item"><a class="nav-link" href="crearAirbnbs.php">Crear Airbnbs</a></li>
                    <li class="nav-item"><a class="nav-link active" href="actualizarAirbnbs.php" aria-current="page">Actualizar Airbnbs</a></li>
                    <li class="nav-item"><a class="nav-link" href="eliminarAirbnbs.php">Eliminar Airbnbs</a></li>
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

    <div class="container my-5">
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="./php/procesarActualizar.php">
                    <div class="mb-3">
                        <label for="updateId" class="form-label">ID</label>
                        <input type="number" class="form-control" id="updateId" name="id" required>
                    </div>
                    <div class="mb-3">
                        <label for="updateName" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="updateName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="updateRoomType" class="form-label">Tipo de Habitación</label>
                        <input type="text" class="form-control" id="updateRoomType" name="room_type" required>
                    </div>
                    <div class="mb-3">
                        <label for="updatePrice" class="form-label">Precio</label>
                        <input type="number" class="form-control" id="updatePrice" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="updateRooms" class="form-label">Número de habitaciones</label>
                        <input type="number" class="form-control" id="updateRooms" name="rooms" required>
                    </div>
                    <div class="mb-3">
                        <label for="updateBeds" class="form-label">Camas</label>
                        <input type="number" class="form-control" id="updateBeds" name="beds" required>
                    </div>
                    <div class="mb-3">
                        <label for="updateBathrooms" class="form-label">Número de baños</label>
                        <input type="number" class="form-control" id="updateBathrooms" name="bathrooms" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </form>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

<script>
    window.onload = function() {
        const urlParams = new URLSearchParams(window.location.search);
        const error = urlParams.get('error');
        const id = urlParams.get('id');
        if (error) {
            alert(`El airbnb con ID ${id} no pudo ser actualizado.`);
        }
    }
</script>
</body>
</html>