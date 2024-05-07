<?php
require 'db.php';

// Fonction pour incrémenter les consultations d'un animal
function incrementConsultations($animalId) {
    global $db;
    $animalsCollection = $db->animaux; // Remplacez 'animaux' par le nom de votre collection d'animaux
    $filter = ['_id' => new MongoDB\BSON\ObjectID($animalId)];
    $update = ['$inc' => ['consultations' => 1]];
    $result = $animalsCollection->updateOne($filter, $update);
    return $result->getModifiedCount();
}
?>
