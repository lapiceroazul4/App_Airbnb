session_start();
    $name = $_SESSION['name'];
    $role = $_SESSION['role'];
    if ($role !== "Cliente") {
        header("Location: login.html");
    }
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
                    <li class="nav-item"><a class="nav-link" href="/cliente">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="/cliente/mostrarAirbnbs">Mostrar Airbnbs</a></li>
                    <li class="nav-item"><a class="nav-link" href="/cliente/reservarAirbnbs">Reservas</a></li>
                    <span class="navbar-text">
                    <?php echo "<a class='nav-link' href='logout.php'>Cerrar sesión en $rol</a>"; ?>
                    </span>
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
                            <th>Reservation ID</th>
                            <th>User ID</th>
                            <th>Airbnb ID</th>
                            <th>Reservation Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="reservationsTableBody"></tbody>
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
                    <form id="crearReservaForm">
                        <div class="mb-3">
                            <label for="userId" class="form-label">User ID</label>
                            <input type="text" class="form-control" id="userId" required>
                        </div>
                        <div class="mb-3">
                            <label for="airbnbId" class="form-label">Airbnb ID</label>
                            <input type="text" class="form-control" id="airbnbId" required>
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

    <script>

        async function fetchReservations() {
            try {
                const response = await fetch('/reservas');
                const reservations = await response.json();
                return reservations;
            } catch (error) {
                alert('Error fetching reservations:', error);
            }
        }

        fetchReservations().then(reservations => {
            const tableBody = document.getElementById('reservationsTableBody');

            reservations.forEach(reservation => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${reservation.reserva_id}</td>
                    <td>${reservation.user_id}</td>
                    <td>${reservation.airbnb_id}</td>
                    <td>${reservation.fecha_reserva}</td>
                    <td>
                        <button class="btn btn-danger" onclick="deleteReservation(${reservation.reserva_id})">Delete</button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        });

        const createReservaBtn = document.getElementById('crearReservaBtn');
        const crearReservaForm = document.getElementById('crearReservaForm');

        createReservaBtn.addEventListener('click', async () => {
            const userId = document.getElementById('userId').value;
            const airbnbId = document.getElementById('airbnbId').value;

            if (!userId || !airbnbId) {
                alert('Por favor, ingresa un User ID y un Airbnb ID válidos.');
                return;
            }

            try {
                const response = await fetch('/reservas', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ user_id: userId, airbnb_id: airbnbId })
                });

                if (response.ok) {
                    alert('Reserva creada exitosamente');
                    location.reload();
                } else {
                    alert(`Error al crear la reserva: no se encontro el usuario o el airbnb.`);
                }
            } catch (error) {
                alert('Error interno del servidor');
            }
        });

        async function deleteReservation(reservationId) {
            try {
                const response = await fetch(`/reservas/id/${reservationId}`, {
                    method: 'DELETE'
                });
                if (response.ok) {
                    alert(`La reserva con ID ${reservationId} fue eliminada.`);
                    location.reload();
                } else {
                    alert('Falla al eliminar la reserva.');
                }
            } catch (error) {
                alert('Error eliminando reserva:', error);
            }
        }

    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>