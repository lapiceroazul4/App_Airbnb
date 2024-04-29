<?php
    session_start();
    $user_id = $_SESSION['user_id'];
    $name = $_SESSION['name'];
    $role = $_SESSION['role'];
    if ($role !== "Cliente") {
        header("Location: ../index.html");
    }

    $api_url = "http://reservas:3003/reservas/userID/$user_id";
    $json_data = file_get_contents($api_url);
    $reservas = json_decode($json_data, true);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Airbnb Platform</title>
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
                    <li class="navbar-item"><a class="nav-link" href="cliente.php">Inicio</a></li>
                    <li class="navbar-item"><a class="nav-link" href="mostrarAirbnbsCliente.php">Mostrar Airbnbs</a></li>
                    <li class="navbar-item"><a class="nav-link active" href="reservasCliente.php" aria-current="page">Reservas</a></li>
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
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#crearReservaModal">
                    Crear Reserva
                </button>
            </div>
        </div>
    </div>

    <div class="container my-5">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID de la reserva</th>
                        <th>ID del Airbnb</th>
                        <th>Nombre del Airbnb</th>
                        <th>ID del cliente</th>
                        <th>Nombre del cliente</th>
                        <th>Fecha de la reservación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservas as $reserva): ?>
                    <tr>
                        <td><?php echo $reserva['reservation_id']; ?></td>
                        <td><?php echo $reserva['airbnb_id']; ?></td>
                        <td><?php echo $reserva['airbnb_name']; ?></td>
                        <td><?php echo $reserva['client_id']; ?></td>
                        <td><?php echo $reserva['client_name']; ?></td>
                        <td><?php echo $reserva['reservation_date']; ?></td>
                        <td>
                            <!-- Formulario para eliminar reserva -->
                            <form action="./php/procesarEliminarReservasCliente.php" method="post">
                                <input type="hidden" name="reservation_id" value="<?php echo $reserva['reservation_id']; ?>">
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="crearReservaModal" tabindex="-1" aria-labelledby="crearReservaModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="crearReservaModalLabel">Crear Reserva</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="crearReservaForm" action="./php/procesarCrearReservasCliente.php" method="post">
                    <div class="mb-3">
                        <label for="airbnbId" class="form-label">ID del airbnb</label>
                        <input type="text" class="form-control" name="airbnb_id" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="crearReservaBtn">Crear Reserva</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    var crearReservaBtn = document.getElementById('crearReservaBtn');
    crearReservaBtn.addEventListener('click', function() {
        var form = document.getElementById('crearReservaForm');
        form.submit();
    });
});
</script>

<script>
    window.onload = function() {
        const urlParams = new URLSearchParams(window.location.search);
        const origin = urlParams.get('origin');

        const success = urlParams.get('success');
        const error = urlParams.get('error');

        const id = urlParams.get('id');
        const airbnb_name = urlParams.get('airbnb_name');
        const airbnb_id = urlParams.get('airbnb_id');
        const client_name = urlParams.get('client_name');

        if (origin == 'post'){
            if (success) {
                alert(`¡La reserva de ${client_name} ha sido creada exitosamente!\nNombre del airbnb: ${airbnb_name}\nID del airbnb: ${airbnb_id}`);
            } else if (error) {
                alert(`La reserva con ID ${id} no pudo ser creada.`);
            }
        } else if (origin == 'delete') {
            if (success) {
                alert(`¡La reserva con ID ${id} ha sido eliminada exitosamente!`);
            } else if (error) {
                alert(`La reserva con ID ${id} no pudo ser eliminada.`);
            }
        }
    }
</script>
</body>