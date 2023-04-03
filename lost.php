<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once 'includes/head.php' ?>
  <title>Excuses de Dev - Erreur 404</title>
</head>

<body>
  <div class="container">
    <div class="lost-gif">
      <img src="public/img/giflost.gif">
    </div>
    <div class="lost-content">
      <h1>I'M LOST</h1>
    </div>
  </div>
  </div>
</body>

</html>

<?php
// On redirige vers l'accueil au bout de 7sec //
header("refresh:5;url=/");
?>