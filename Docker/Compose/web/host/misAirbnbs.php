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
  <title>Mostrar Airbnbs</title>
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
                    <li class="nav-item"><a class="nav-link" href="host.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="misAirbnbs.php">Mis Airbnbs</a></li>
                    <li class="nav-item"><a class="nav-link" href="crearAirbnbsHost.php">Crear Airbnbs</a></li>
                    <li class="nav-item"><a class="nav-link" href="actualizarAirbnbsHost.php">Actualizar Airbnbs</a></li>
                    <li class="nav-item"><a class="nav-link" href="eliminarAirbnbsHost.php">Eliminar Airbnbs</a></li>
                    <li class="nav-item"><a class="nav-link" href="reservasHost.php">Reservar Airbnbs</a></li>
                    <li class="nav-item dropdown">
                      <a class="nav-link active dropdown-toggle" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false" aria-current="page">
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
    <div class="row mb-4">
      <div class="col-md-6">
        <input type="text" class="form-control" id="idInput" placeholder="Ingrese un ID">
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
          <tbody id="airbnbsTableBody">
            <?php
            $jsonData = file_get_contents("http://airbnbs:3002/airbnbs/hostId/$user_id");
            $airbnbs = json_decode($jsonData, true);

            foreach ($airbnbs as $airbnb):
            ?>
              <tr>
                <td><?php echo $airbnb['id']; ?></td>
                <td><?php echo $airbnb['name']; ?></td>
                <td><?php echo $airbnb['host_name']; ?></td>
                <td><?php echo $airbnb['host_id']; ?></td>
                <td><?php echo $airbnb['neighbourhood_group']; ?></td>
                <td><?php echo $airbnb['neighbourhood']; ?></td>
                <td><?php echo $airbnb['room_type']; ?></td>
                <td><?php echo $airbnb['price']; ?></td>
                <td><?php echo $airbnb['rating']; ?></td>
                <td><?php echo $airbnb['number_of_reviews']; ?></td>
                <td><?php echo $airbnb['rooms']; ?></td>
                <td><?php echo $airbnb['beds']; ?></td>
                <td><?php echo $airbnb['bathrooms']; ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
    
    <nav aria-label="Page navigation">
      <ul id="paginationContainer" class="pagination justify-content-center"></ul>
    </nav>
    
  </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
  crossorigin="anonymous"></script>

<script>
window.onload = function() {
    const urlParams = new URLSearchParams(window.location.search);
    const success = urlParams.get('success');
    const origin = urlParams.get('origin');

    const id = urlParams.get('id');
    const hostID = urlParams.get('hostID');
    const hostName = urlParams.get('hostName');

    if (success && origin === 'post') {
        alert(`¡El airbnb de ${hostName} ha sido creado exitosamente!\nID del airbnb: ${id}\nID del host: ${hostID}`);
    } else if (success && origin === 'put') {
        alert(`¡El airbnb de ${hostName} ha sido actualizado exitosamente!\nID del airbnb: ${id}\nID del host: ${hostID}`);
    }
}
</script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const idInput = document.getElementById('idInput');
    const roomTypeSelect = document.getElementById('roomTypeSelect');
    const rowsPerPage = 10; // Número de registros por página
    let currentPage = 1; // Página actual
    let lastPageBeforeFilter = 1; // Almacena la última página antes de aplicar el filtro
    let filteredRows = []; // Almacenará las filas filtradas

    // Eventos para filtrar y paginar al escribir o cambiar selección
    idInput.addEventListener('keyup', function() {
      applyFilter();
    });

    roomTypeSelect.addEventListener('change', function() {
      applyFilter();
    });

    function applyFilter() {
      const idFilterApplied = idInput.value !== '';
      const roomTypeFilterApplied = roomTypeSelect.value !== '';

      // Si se aplica un filtro, guarda la página actual y reinicia a la primera página.
      // Si todos los filtros están vacíos, vuelve a la última página antes del filtro.
      if (idFilterApplied || roomTypeFilterApplied) {
        lastPageBeforeFilter = currentPage;
        currentPage = 1;
      } else {
        currentPage = lastPageBeforeFilter;
      }
      filterTable();
      setupPagination();
      displayPage(currentPage);
    }

    // Función para filtrar la tabla
    function filterTable() {
      const id = idInput.value;
      const roomType = roomTypeSelect.value;
      const rows = document.querySelectorAll('#airbnbsTableBody tr');
      filteredRows = []; // Reinicia el array de filas filtradas

      rows.forEach(row => {
        const idCell = row.cells[0].textContent;
        const roomTypeCell = row.cells[6].textContent;

        if ((id === '' || idCell.includes(id)) &&
            (roomType === '' || roomTypeCell === roomType)) {
          filteredRows.push(row); // Agrega la fila al array de filas filtradas
          row.classList.remove('d-none');
        } else {
          row.classList.add('d-none');
        }
      });

      updateActivePageInPagination(currentPage); // Actualiza la paginación activa
    }

    // Función para configurar la paginación
    function setupPagination() {
      const numPages = Math.ceil(filteredRows.length / rowsPerPage);
      const paginationContainer = document.getElementById('paginationContainer');
      paginationContainer.innerHTML = '';

      for (let i = 1; i <= numPages; i++) {
        const li = document.createElement('li');
        li.className = `page-item ${currentPage === i ? 'active' : ''}`;
        const a = document.createElement('a');
        a.href = '#';
        a.className = 'page-link';
        a.innerText = i;
        a.addEventListener('click', function (e) {
          e.preventDefault();
          currentPage = i;
          displayPage(currentPage);
          updateActivePageInPagination(currentPage); // Actualiza la paginación activa al hacer clic
        });
        li.appendChild(a);
        paginationContainer.appendChild(li);
      }
    }

    // Función para mostrar la página actual
    function displayPage(page) {
      const start = (page - 1) * rowsPerPage;
      const end = start + rowsPerPage;
      const rowsToShow = filteredRows.slice(start, end); // Obtiene las filas a mostrar

      // Oculta todas las filas
      document.querySelectorAll('#airbnbsTableBody tr').forEach(row => {
        row.style.display = 'none';
      });

      // Muestra solo las filas del array filtrado que corresponden a la página actual
      rowsToShow.forEach(row => {
        row.style.display = '';
      });

      lastPageBeforeFilter = page; // Actualiza la última página antes del filtro
    }

    // Función para actualizar la página activa en la paginación
    function updateActivePageInPagination(page) {
      const paginationLinks = document.querySelectorAll('#paginationContainer .page-link');
      const paginationItems = document.querySelectorAll('#paginationContainer .page-item');

      // Elimina la clase 'active' de todos los elementos de paginación
      paginationItems.forEach(item => {
        item.classList.remove('active');
      });

      // Agrega la clase 'active' solo al elemento de paginación correspondiente a la página actual
      paginationLinks.forEach(link => {
        if (parseInt(link.textContent) === page) {
          link.parentElement.classList.add('active');
        }
      });
    }

    // Inicializar la tabla y la paginación
    filterTable();
    setupPagination();
    displayPage(currentPage);
  });
</script>
</body>
</html>
