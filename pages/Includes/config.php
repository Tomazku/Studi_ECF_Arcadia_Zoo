<?php
// Informations de connexion à la base de données
$db_host = 'localhost'; 
$db_name = 'arcadia_zoo'; 
$db_user = 'root'; 
$db_password = ''; 

// Options de connexion à la base de données
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Activer le mode d'affichage des erreurs
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Récupérer les résultats sous forme de tableau associatif
];

// Connexion à la base de données avec PDO
try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password, $options);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
