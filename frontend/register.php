<?php
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Lee el cuerpo JSON si existe
    $input = file_get_contents('php://input');
    $postData = json_decode($input, true);

    // Si no hay datos JSON, usa $_POST (por compatibilidad)
    $data = $postData ?: $_POST;

    // Validar campos obligatorios
    $required = ["username", "email", "password", "phone", "address", "birthdate"];
    $missing = [];
    foreach ($required as $field) {
        if (empty($data[$field])) {
            $missing[] = $field;
        }
    }
    if ($missing) {
        http_response_code(400);
        echo json_encode(["error" => "Faltan campos: " . implode(", ", $missing)]);
        exit;
    }

    $opts = [
        "http" => [
            "method" => "POST",
            "header" => "Content-Type: application/json",
            "content" => json_encode($data),
            "ignore_errors" => true
        ]
    ];
    $context = stream_context_create($opts);
    $result = @file_get_contents("http://backend:5000/api/v1/users/register", false, $context);

    if ($result === FALSE) {
        http_response_code(500);
        $err = error_get_last();
        echo json_encode(["error" => "No se pudo conectar con el backend. Error: " . ($err['message'] ?? 'Desconocido')]);
        exit;
    }

    $response = json_decode($result, true);

    if (isset($response["message"]) && stripos($response["message"], "success") !== false) {
        echo json_encode(["success" => true, "message" => "¡Registro exitoso! Ahora puedes iniciar sesión."]);
    } else {
        http_response_code(400);
        echo json_encode(["error" => $response["message"] ?? "Error en el registro."]);
    }
} else {
    http_response_code(405);
    echo json_encode(["error" => "Método no permitido"]);
}
?>
