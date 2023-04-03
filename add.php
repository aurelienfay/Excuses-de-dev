<?php

// Chemin vers la liste des excuses en JSON //
$filename = __DIR__ . "/data/apologizes.json";

// On protège et on assainit l'URL
$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

// On récupère l'ID de l'item à ajouter, puis on la met dans le fichier JSON
$id = $_GET['id'] ?? '';
if ($id) {
  $data = file_get_contents($filename);
  $apologizes = json_decode($data, true) ?? [];
  if (count($apologizes)) {
    //  $apologizeIndex = (int)array_search($id, array_column($apologizes, 'id')); //
    //  $apologizes[$apologizeIndex] = !$apologizes[$apologizeIndex]; //
    file_put_contents($filename, json_encode($apologizes));
  }
}

// Redirection vers l'index //
header('Location: /');
