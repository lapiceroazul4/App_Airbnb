<?php
$client_id = $_POST['client_id'] ?? '';
$airbnb_id = $_POST['airbnb_id'] ?? '';

$url = "http://reservas:3003/reservas";

$data = array(
    'client_id' => $client_id,
    'airbnb_id' => $airbnb_id
);

$json_data = json_encode($data);

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$id = trim($response);

if ($response === false) {
    curl_close($ch);
    die("Error en la petición cURL");
}

curl_close($ch);

// ----------------------------------------

$url = "http://reservas:3003/reservas/reservationID/$id";
$curl = curl_init($url);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response_reservas = curl_exec($curl);

if ($response_reservas === false) {
    curl_close($curl);
    die("Error en la conexión o la URL es incorrecta");
}

curl_close($curl);

$resp = json_decode($response_reservas, true);

$airbnb_id = $resp['airbnb_id'];
$airbnb_name = $resp['airbnb_name'];
$client_name = $resp['client_name'];


if ($response === false) {
    header("Location:../reservasHost.php?origin=post&error=true&id=$id");
} else {
    header("Location:../reservasHost.php?origin=post&success=true&id=$id&airbnb_name=$airbnb_name&airbnb_id=$airbnb_id&client_name=$client_name");
}
?>