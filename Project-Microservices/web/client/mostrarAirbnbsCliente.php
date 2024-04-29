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
    <div class="row mb-4">
      <div class="col-md-6">
        <input type="text" class="form-control" id="searchInput" placeholder="Ingrese un ID">
      </div>
      <div class="col-md-6">
        <input type="text" class="form-control" id="hostIdInput" placeholder="Ingrese un Host ID">
      </div>
      <div class="col-md-6 mt-3 mt-md-0">
        <select id="roomTypeSelect" class="form-select">
          <option value="">Todos</option>
          <option value="Entire home/apt">Entire home/apt</option>
          <option value="Private room">Private room</option>
          <option value="Shared room">Shared room</option>
          <option value="Hotel room">Hotel room</option>
        </select>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Nombre del Host</th>
            <th>Host ID</th>
            <th>Distrito</th>
            <th>Barrio</th>
            <th>Tipo de Habitación</th>
            <th>Precio</th>
            <th>Rating</th>
            <th>Número de Reviews</th>
            <th>Habitaciones</th>
            <th>Camas</th>
            <th>Baños</th>
          </tr>
        </thead>
        <tbody id="airbnbsTableBody"></tbody>
      </table>
    </div>
  </div>
  </div>

  <script>
    async function fetchAirbnbs() {
      try {
        const response = await fetch('/airbnbs');
        const airbnbs = await response.json();
        return airbnbs;
      } catch (error) {
        alert('Error al obtener los Airbnbs:', error);
      }
    }

    fetchAirbnbs().then(airbnbs => {
      const tableBody = document.getElementById('airbnbsTableBody');

      airbnbs.forEach(airbnb => {
        const row = document.createElement('tr');
        row.innerHTML = `
          <td>${airbnb.id}</td>
          <td>${airbnb.name}</td>
          <td>${airbnb.host_name}</td>
          <td>${airbnb.host_id}</td>
          <td>${airbnb.neighbourhood_group}</td>
          <td>${airbnb.neighbourhood}</td>
          <td>${airbnb.room_type}</td>
          <td>${airbnb.price}</td>
          <td>${airbnb.rating}</td>
          <td>${airbnb.number_of_reviews}</td>
          <td>${airbnb.rooms}</td>
          <td>${airbnb.beds}</td>
          <td>${airbnb.bathrooms}</td>
        `;
        tableBody.appendChild(row);
      });
    });

    const searchInput = document.getElementById('searchInput');
    const tableBody = document.getElementById('airbnbsTableBody');

    searchInput.addEventListener('input', async () => {

      const response = await fetch(`/airbnbs/id/${searchInput.value}`);
      const airbnb = await response.json();
      if (airbnb) {
        tableBody.innerHTML = '';
        const row = document.createElement('tr');
        row.innerHTML = `
          <td>${airbnb.id}</td>
          <td>${airbnb.name}</td>
          <td>${airbnb.host_name}</td>
          <td>${airbnb.host_id}</td>
          <td>${airbnb.neighbourhood_group}</td>
          <td>${airbnb.neighbourhood}</td>
          <td>${airbnb.room_type}</td>
          <td>${airbnb.price}</td>
          <td>${airbnb.rating}</td>
          <td>${airbnb.number_of_reviews}</td>
          <td>${airbnb.rooms}</td>
          <td>${airbnb.beds}</td>
          <td>${airbnb.bathrooms}</td>
        `;
        tableBody.appendChild(row);
      } else {
        tableBody.innerHTML = '<tr><td colspan="13">No se encontró ningún Airbnb con ese Host ID</td></tr>';
      }
    });

    const hostIdInput = document.getElementById('hostIdInput');

    hostIdInput.addEventListener('input', async () => {
      const response = await fetch(`/airbnbs/hostId/${hostIdInput.value}`);
      const airbnbs = await response.json();

      if (airbnbs.length > 0) {
        tableBody.innerHTML = '';
        airbnbs.forEach(airbnb => {
          const row = document.createElement('tr');
          row.innerHTML = `
            <td>${airbnb.id}</td>
            <td>${airbnb.name}</td>
            <td>${airbnb.host_name}</td>
            <td>${airbnb.host_id}</td>
            <td>${airbnb.neighbourhood_group}</td>
            <td>${airbnb.neighbourhood}</td>
            <td>${airbnb.room_type}</td>
            <td>${airbnb.price}</td>
            <td>${airbnb.rating}</td>
            <td>${airbnb.number_of_reviews}</td>
            <td>${airbnb.rooms}</td>
            <td>${airbnb.beds}</td>
            <td>${airbnb.bathrooms}</td>
          `;
          tableBody.appendChild(row);
        });
      } else {
        tableBody.innerHTML = '<tr><td colspan="13">No se encontraron Airbnbs con ese Host ID</td></tr>';
      }
    });

    const roomTypeSelect = document.getElementById('roomTypeSelect');

    roomTypeSelect.addEventListener('change', async () => {
      let response;
      if (roomTypeSelect.value == "") {
        response = await fetch("/airbnbs");
      } else if (roomTypeSelect.value == "Entire home/apt") {
        response = await fetch(`/airbnbs/roomType/Entire%20home%2Fapt`);
      } else {
        response = await fetch(`/airbnbs/roomType/${roomTypeSelect.value}`);
      }

      const airbnbs = await response.json();

      if (airbnbs.length > 0) {
        tableBody.innerHTML = '';
        airbnbs.forEach(airbnb => {
          const row = document.createElement('tr');
          row.innerHTML = `
            <td>${airbnb.id}</td>
            <td>${airbnb.name}</td>
            <td>${airbnb.host_name}</td>
            <td>${airbnb.host_id}</td>
            <td>${airbnb.neighbourhood_group}</td>
            <td>${airbnb.neighbourhood}</td>
            <td>${airbnb.room_type}</td>
            <td>${airbnb.price}</td>
            <td>${airbnb.rating}</td>
            <td>${airbnb.number_of_reviews}</td>
            <td>${airbnb.rooms}</td>
            <td>${airbnb.beds}</td>
            <td>${airbnb.bathrooms}</td>
          `;
          tableBody.appendChild(row);
        });
      } else {
        tableBody.innerHTML = '<tr><td colspan="13">No se encontraron Airbnbs con ese Tipo de Habitación</td></tr>';
      }
    });

  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>