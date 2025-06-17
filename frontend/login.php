<?php
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (session_status() === PHP_SESSION_NONE) session_start();
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    $username = $data["username"] ?? "";
    $password = $data["password"] ?? "";

    $apiUrl = "http://backend:5000/api/v1/users/login";

    // Crear los datos para enviar al backend
    $postData = json_encode([
        "username" => $username,
        "password" => $password
    ]);

    // Configurar cURL
    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HEADER, true); // Incluir las cabeceras en la respuesta
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

    // Ejecutar la solicitud
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    curl_close($ch);

    // Separar las cabeceras del cuerpo de la respuesta
    $headers = substr($response, 0, $headerSize);
    $body = substr($response, $headerSize);

    // Procesar las cabeceras línea por línea
    $headersArray = explode("\r\n", $headers);
    $cookie = null;
    foreach ($headersArray as $header) {
        if (stripos($header, 'Set-Cookie: session=') === 0) {
            // Extraer el valor de la cookie
            $cookie = substr($header, strlen('Set-Cookie: session='));
            $cookie = strtok($cookie, ';'); // Tomar solo el valor antes del primer ';'
            break;
        }
    }

    // Procesar el cuerpo de la respuesta
    $responseData = json_decode($body, true);

    if ($httpCode === 200 && isset($responseData["message"]) && stripos($responseData["message"], "success") !== false) {
        if ($cookie) {
            // Guardar la cookie en el cliente
            setcookie("session", $cookie, time() + 3600, "/", "", false, true); // HttpOnly
        }
        $_SESSION["usuario"] = $username;
        echo json_encode(["success" => true, "message" => "Login correcto"]);
    } else {
        http_response_code(401);
        echo json_encode(["error" => $responseData["message"] ?? "Usuario o contraseña incorrectos."]);
    }
    exit;
}

http_response_code(405);
echo json_encode(["error" => "Método no permitido"]);