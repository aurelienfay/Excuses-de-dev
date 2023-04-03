<?php

// Gestion des erreurs //
const ERROR_REQUIRED = 'Veuillez renseigner une nouvelle excuse';
const ERROR_LENGTH = 'Veuillez entrer au moins 5 caractères';

$error = '';
$filename = __DIR__ . "/data/apologizes.json";
$apologizes = [];
$apologize = '';
$random_apologize = '';

if (file_exists($filename)) {
  $data = file_get_contents($filename);
  $apologizes = json_decode($data, true) ?? [];
}

// Vérification de la méthode POST et assainissement des champs //
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $apologize = $_POST['apologize'] ?? '';

  // On vérifie les excuses et on les attribue aux erreurs si nécessaire //
  if (!$apologize) {
    $error = ERROR_REQUIRED;
  } elseif (mb_strlen($apologize) < 5) {
    $error = ERROR_LENGTH;
  }

  // S'il n'y a pas d'erreur, on assigne les valeurs au tableau qui contient les excuses //
  if (!$error) {
    $apologizes = [...$apologizes, [
      'name' => $apologize,
      'id' => time()
    ]];
    file_put_contents($filename, json_encode($apologizes));

    // Redirection vers l'index si l'ajout a fonctionné //
    header('Location: /');
  }
}

if (isset($apologizes)) {

  // On récupère alétoirement l'index d'une excuse //
  $random_index = array_rand($apologizes);
  $selected_apologize = $apologizes[$random_index];

  // Puis on l'injecte dans la variable de l'excuse alétoire, pour l'utilser plus tard //
  $random_apologize = $selected_apologize['name'];
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once 'includes/head.php' ?>
  <title>Excuses de Dev - Projet PHP</title>
</head>

<body>
  <div class="container">
    <?php require_once 'includes/header.php' ?>
    <div class="content">
      <div class="apologize-container">
        <h1>Votre Dev a une excuse pour vous</h1>
        <div class="random-apologize">« <?= $random_apologize ?> »</div>
        <button class="btn btn-apologize" onclick="location.reload()">Nouvelle Excuse</button>

        <!-- Bouton pour ouvrir la modale -->
        <button type="button" class="btn btn-modal" onclick="openModal()">Ajouter une excuse</button>

        <!-- Modale -->
        <div id="modalApologize" class="modal">
          <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <!-- Contenu de la modale -->
            <form action="/" method="POST" class="apologize-form">
              <input value="<?= $apologize ?>" name="apologize" type="text">
              <button class="btn btn-primary">Ajouter</button>
            </form>
            <?php if ($error) : ?>
              <p class="text-danger">
                <?= $error ?>
              </p>
            <?php endif; ?>
            <ul class="apologize-list">
              <?php foreach ($apologizes as $a) : ?>
                <li class="apologize-item">
                  <span class="apologize-name"><?= $a['name'] ?></span>
                  <a href="/delete.php?id=<?= $a['id'] ?>">
                    <button class="btn btn-danger btn-small">Supprimer</button>
                  </a>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>

        <script>
          function openModal() {
            var modal = document.getElementById("modalApologize");
            modal.style.display = "block";
          }

          function closeModal() {
            var modal = document.getElementById("modalApologize");
            modal.style.display = "none";
          }
        </script>

      </div>
    </div>
    <?php require_once 'includes/footer.php' ?>
  </div>
</body>

</html>