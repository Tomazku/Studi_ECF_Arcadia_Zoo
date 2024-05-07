<?php
require 'vendor/autoload.php'; // Inclure le gestionnaire de dépendances Composer
require 'db.php';
require 'animal.php';

// Route pour incrémenter les consultations d'un animal
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['animalId'])) {
    $animalId = $_POST['animalId'];
    $modifiedCount = incrementConsultations($animalId);
    if ($modifiedCount) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
    exit;
}

?>
