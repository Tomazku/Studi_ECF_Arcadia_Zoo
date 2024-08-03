<?php
// Configuration des paramètres de session
ini_set('session.cookie_secure', '1');
ini_set('session.cookie_httponly', '1');

// Démarrer la session uniquement si elle n'est pas déjà démarrée
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Inclure le fichier de fonctions
require_once __DIR__ . '/functions.php';
?>
