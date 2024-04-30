<?php
$id = $_POST['id'];

$airbnbs_get="http://airbnbs:3002/airbnbs/id/$id";
$curl_get=curl_init();

curl_setopt($curl_get, CURLOPT_URL, $airbnbs_get);
curl_setopt($curl_get, CURLOPT_RETURNTRANSFER, true);
$response_get=curl_exec($curl_get);

if ($response_get===false){
    curl_close($curl_get);
    die("Error en la conexion");
}

curl_close($curl_get);

$airbnb=json_decode($response_get, true);
$hostName = $airbnb[0]['host_name'];
$hostID = $airbnb[0]['host_id'];

// -------------

$airbnbs_delete = "http://airbnbs:3002/airbnbs/$id";

$curl_delete = curl_init();

curl_setopt($curl_delete, CURLOPT_URL, $airbnbs_delete);
curl_setopt($curl_delete, CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($curl_delete, CURLOPT_RETURNTRANSFER, true);

$response_delete = curl_exec($curl_delete);


if ($response_delete === false) {
    header("Location:../eliminarAirbnbsHost.php?error=true?id=$id");
} else {
    header("Location:../eliminarAirbnbsHost.php?success=true&id=$id&hostID=$hostID&hostName=$hostName");
}
?>