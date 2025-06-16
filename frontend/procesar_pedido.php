<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    // Redirige a login si no está logueado
    header("Location: login.php");
    exit;
}

$carrito = json_decode($_POST["carrito"] ?? "[]", true);

// Prepara los datos para el backend
$productos = array_map(function($p) {
    return [
        "product_id" => $p["id"],
        "quantity" => $p["cantidad"]
    ];
}, $carrito);

$data = ["products" => $productos];

// Llama al backend Flask
$options = [
    "http" => [
        "header"  => "Content-Type: application/json\r\n",
        "method"  => "POST",
        "content" => json_encode($data),
        "ignore_errors" => true
    ]
];
$context  = stream_context_create($options);
$result = file_get_contents("http://backend:5000/api/v1/carts", false, $context);

$response = json_decode($result, true);

if (isset($response["id"])) {
    // Pedido guardado con éxito
    echo "<div class='alert alert-success text-center'>¡Pago realizado con éxito!<br>Gracias por tu compra.</div>";
    echo "<script>localStorage.removeItem('carrito'); setTimeout(()=>{window.location='index.php';},2000);</script>";
} else {
    echo "<div class='alert alert-danger text-center'>Error al guardar el pedido:<br>";
    echo "<pre>".htmlspecialchars($result)."</pre></div>";
}
?>