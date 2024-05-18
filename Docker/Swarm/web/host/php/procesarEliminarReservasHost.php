<?php
$id = $_POST['reservation_id'];

$url = "http://reservas:3003/reservas/reservationID/$id";

$curl = curl_init();

curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($curl);


curl_close($curl);

if ($response === false) {
    header("Location: ../reservasHost.php?origin=delete&error=true&id=$id");
} else {
    header("Location: ../reservasHost.php?origin=delete&success=true&id=$id");
}
?>
