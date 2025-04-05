Recibí tu mensaje: <?php
// Leer el contenido enviado por Telegram
$content = file_get_contents("php://input");
file_put_contents("debug.txt", $content . PHP_EOL, FILE_APPEND); // Para depuración
$update = json_decode($content, true);

// Token del bot
$token = "7490119561:AAGJmnLToplJQ3FamNGMU6RKVSnSqsQ5g9c";

// Extraer el chat_id desde el mensaje o callback
$chat_id = $update["message"]["chat"]["id"] ?? ($update["callback_query"]["from"]["id"] ?? null);

// Si llegó un mensaje normal (texto)
if (isset($update["message"])) {
    $texto = trim($update["message"]["text"]);

    // Respuesta básica de bienvenida
    if ($texto === "/start" || strtolower($texto) === "hola") {
        file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query([
            "chat_id" => $chat_id,
            "text" => "👋 ¡Hola! Bienvenido al bot. ¿En qué te puedo ayudar?"
        ]));
    } else {
        file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query([
            "chat_id" => $chat_id,
            "text" => "Recibí tu mensaje: $texto"
        ]));
    }
}
?>
