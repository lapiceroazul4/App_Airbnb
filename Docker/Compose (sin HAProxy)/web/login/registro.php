<?php
    // Recoger los datos del formulario
    $user_id = $_POST["user_id"];
    $name = $_POST["name"];
    $role = $_POST["role"];
    $password = $_POST["password"];
    $email = $_POST["email"];

    // Validar los datos aquí (por ejemplo, comprobar que no estén vacíos)

    $data = array(
        'user_id' => $user_id,
        'name' => $name,
        'role' => $role,
        'password' => $password,
        'email' => $email
    );
    $data_string = json_encode($data);

    $ch = curl_init('http://usuarios:3001/usuarios/crearusuario');

    // Configurar las opciones de cURL
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_string))
    );

    // Enviar la solicitud
    $result = curl_exec($ch);

    if ($result === false) {
        $error_message = curl_error($ch);
        header("Location: registro.html?error=" . urlencode($error_message));
    } else {
        // Redirigir al usuario a una página de éxito
        header("Location: ../index.html");
    }

    // Cerrar la sesión cURL
    curl_close($ch);
?>