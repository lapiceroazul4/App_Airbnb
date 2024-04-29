<?php
    session_start();
    $name = $_SESSION["name"];
    $role = $_SESSION["role"];
    if ($rol !== "Admin" || $role !== "Host") {
        header("Location: login.html");
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Dashboard Airbnbs</title>
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
                    <li class="nav-item"><a class="nav-link" href="/admin">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="/admin/mostrarAirbnbs">Mostrar Airbnbs</a></li>
                    <li class="nav-item"><a class="nav-link" href="/admin/crearAirbnbs">Crear Airbnbs</a></li>
                    <li class="nav-item"><a class="nav-link" href="/admin/actualizarAirbnbs">Actualizar Airbnbs</a></li>
                    <li class="nav-item"><a class="nav-link" href="/admin/eliminarAirbnbs">Eliminar Airbnbs</a></li>
                    <li class="nav-item"><a class="nav-link" href="/admin/reservarAirbnbs">Reservar Airbnbs</a></li>
                    <li class="nav-item"><a class="nav-link" href="/admin/dashboard">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="/">Cerrar sesión</a></li>
                </ul>
        </div>
    </header>

    <div class="container text-center my-3">
        <iframe title="Dashboard - Proyecto Redes" width="1040" height="640"
            src="https://app.powerbi.com/view?r=eyJrIjoiMjY5YTlhZTMtNDk0Yi00MzI3LTk3ZTgtYjc2ZWY1ZTdmN2ExIiwidCI6IjY5M2NiZWEwLTRlZjktNDI1NC04OTc3LTc2ZTA1Y2I1ZjU1NiIsImMiOjR9"
            frameborder="0" allowFullScreen="true"></iframe>
    </div>
</body>

</html>