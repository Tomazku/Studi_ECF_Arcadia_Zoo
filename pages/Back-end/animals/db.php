<?php
$pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo', 'root', '');

require 'vendor/autoload.php'; // Inclure le gestionnaire de dépendances Composer

use MongoDB\Client as MongoDBClient;

// Connexion à MongoDB
$mongoClient = new MongoDBClient("mongodb://localhost:27017");
$db = $mongoClient->selectDatabase('nom_de_votre_base_de_données'); // Remplacez 'nom_de_votre_base_de_données' par le nom de votre base de données
?>
