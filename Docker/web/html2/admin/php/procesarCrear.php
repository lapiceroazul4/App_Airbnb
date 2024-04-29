<?php
$id = $_POST["id"];
$name = $_POST["name"];
$idHost = $_POST["idHost"];
$nameHost = $_POST["nameHost"];
$distrito = $_POST["distrito"];
$neighbourhood = $_POST["neighbourhood"];
$latitude = $_POST["Latitude"];
$longitude = $_POST["Longitude"];
$roomType = $_POST["roomType"];
$minimumNights = $_POST["MinimumNights"];
$price = $_POST["price"];
$reviews = $_POST["Reviews"];
$rating = $_POST["Rating"];
$rooms = $_POST["rooms"];
$beds = $_POST["beds"];
$bathrooms = $_POST["bathrooms"];

// URL de la solicitud POST
$url = 'http://airbnbs:3002/airbnbs';

// Datos que se enviarán en la solicitud POST
$data = array(
    'id' => $id,
    'name' => $name,
    'idHost' => $idHost,
    'nameHost' => $nameHost,
    'distrito' => $distrito,
    'neighbourhood' => $neighbourhood,
    'latitude' => $latitude,
    'longitude' => $longitude,
    'roomType' => $roomType,
    'minimumNights' => $minimumNights,
    'price' => $price,
    'reviews' => $reviews,
    'rating' => $rating,
    'rooms' => $rooms,
    'beds' => $beds,
    'bathrooms' => $bathrooms
);
$json_data = json_encode($data);

// Inicializar cURL
$ch = curl_init();

// Configurar opciones de cURL
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Ejecutar la solicitud POST
$response = curl_exec($ch);

// Manejar la respuesta
if ($response === false) {
    header("Location:../crearAirbnbs.php?error=true&id=$id");
}
// Cerrar la conexión cURL
curl_close($ch);
header("Location:../mostrarAirbnbs.php?origin=post&success=true&id=$id&hostID=$idHost&hostName=$nameHost");
?>