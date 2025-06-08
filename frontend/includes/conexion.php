<?php

$host = "database";
$user = "backend_user";
$pass = "backend_password";
$db   = "petopia";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>