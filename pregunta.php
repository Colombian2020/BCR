<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head><title>Pregunta</title></head>
</head>
<body>
  <h2><?php echo $_SESSION['pregunta']; ?></h2>
  <form action="procesar_pregunta.php" method="POST">
    <input type="text" name="respuesta" placeholder="Tu respuesta" required>
    <br><br>
    <button type="submit">Enviar</button>
  </form>
</body>
</html>
