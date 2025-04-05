<?php
session_start();
include("backend.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta http-equiv="refresh" content="3">
  <title>Esperando...</title>
  <style>
    body {
      background: white;
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
    p {
      color: #444;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
  <p>Estamos validando tu información...</p>
  <div class="loader"></div>
</body>
</html>
