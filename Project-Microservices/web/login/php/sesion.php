<?php
$email = $_POST["email"];
$password = $_POST["password"];

$servurl = "http://localhost:3001/user/validation";

$servurl .= "?email=" . urlencode($email) . "&password=" . urlencode($password);

$curl = curl_init($servurl);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($curl);
curl_close($curl);

if ($response===false){
    header("Location:login.html");
}

$resp = json_decode($response);

$user_id = $resp[0]->user_id;
$name = $resp[0]->name;
$role = $resp[0]->role;

if (count($resp) != 0){
    session_start();

    $_SESSION['user_id'] = $user_id;
    $_SESSION['name'] = $name;
    $_SESSION['role'] = $role;

    if ($rol == "Admin"){
        header("Location:admin.php");
    } else if ($rol == "Host"){
        header("Location:admin.php");
    } else {
        header("Location:cliente.php");
    }
} else {
    header("Location:login.html");
}
?>