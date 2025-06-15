<?php
header('Content-Type: application/json');
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (session_status() === PHP_SESSION_NONE) session_start();
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    $username = $data["username"] ?? "";
    $password = $data["password"] ?? "";

    $apiData = [
        "username" => $username,
        "password" => $password
    ];

    $opts = [
        "http" => [
            "method" => "POST",
            "header" => "Content-Type: application/json",
            "content" => json_encode($apiData),
            "ignore_errors" => true
        ]
    ];
    $context = stream_context_create($opts);
    $result = @file_get_contents("http://backend:5000/api/v1/users/login", false, $context);
    $response = json_decode($result, true);

    if (isset($response["message"]) && stripos($response["message"], "success") !== false) {
        $_SESSION["usuario"] = $username;
        echo json_encode(["success" => true, "message" => "Login correcto"]);
    } else {
        http_response_code(401);
        echo json_encode(["error" => $response["message"] ?? "Usuario o contraseña incorrectos."]);
    }
    exit;
}
http_response_code(405);
echo json_encode(["error" => "Método no permitido"]);
