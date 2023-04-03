<?php

// Chemin vers la Todo-List en JSON //
$filename = __DIR__ . "/data/apologizes.json";

// On protège et on assainit l'URL
$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

// On récupère l'ID de l'item à supprimer, puis on l'onlève du fichier JSON
$id = $_GET['id'] ?? '';
if ($id) {
  $apologizes = json_decode(file_get_contents($filename), true);
  $apologizeIndex = array_search($id, array_column($apologizes, 'id'));
  array_splice($apologizes, $apologizeIndex, 1);
  file_put_contents($filename, json_encode($apologizes));
}

// Redirection vers l'index //
header('Location: /');
