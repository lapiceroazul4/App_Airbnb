<?php
$id = $_POST["id"];
$name = $_POST["name"];
$room_type = $_POST["room_type"];
$price = $_POST["price"];
$rooms = $_POST["rooms"];
$beds = $_POST["beds"];
$bathrooms = $_POST["bathrooms"];

$url = "http://airbnbs:3002/airbnbs/$id";

$data = array(
    'name' => $name,
    'room_type' => $room_type,
    'price' => $price,
    'rooms' => $rooms,
    'beds' => $beds,
    'bathrooms' => $bathrooms
);
$json_data = json_encode($data);

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

// -------------

$servurl="http://airbnbs:3002/airbnbs/id/$id";
$curl=curl_init($servurl);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response_airbnbs=curl_exec($curl);

if ($response_airbnbs===false){
    curl_close($curl);
    die("Error en la conexion");
}

curl_close($curl);

$resp=json_decode($response_airbnbs, true);
$hostName = $resp[0]['host_name'];
$hostID = $resp[0]['host_id'];

// Manejar la respuesta
if ($response === false) {
    header("Location:../actualizarAirbnbsHost.php?error=true&id=$id");
} else {
    header("Location:../misAirbnbs.php?origin=put&success=true&id=$id&hostID=$hostID&hostName=$hostName");
}

// Cerrar la conexión cURL
curl_close($ch);
?>