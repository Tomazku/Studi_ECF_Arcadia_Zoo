<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/pdo.php';

// Activation de l'affichage des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Fonction pour logger les messages de débogage
function debug_log($message) {
    error_log($message);
}

debug_log("Début du processus de connexion");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    debug_log("Méthode POST détectée");

    // Vérification du jeton CSRF
    debug_log("POST CSRF Token: " . (isset($_POST['csrf_token']) ? $_POST['csrf_token'] : 'not set'));
    debug_log("COOKIE CSRF Token: " . (isset($_COOKIE['csrf_token']) ? $_COOKIE['csrf_token'] : 'not set'));

    if (!isset($_POST['csrf_token']) || !isset($_COOKIE['csrf_token']) || $_POST['csrf_token'] !== $_COOKIE['csrf_token']) {
        debug_log("Erreur CSRF : jeton invalide");
        die("Erreur CSRF : jeton invalide");
    }
    debug_log("Vérification CSRF réussie");

    $email = $_POST['email'] ?? '';
    $password = $_POST['motDePasse'] ?? '';

    debug_log("Email reçu : " . $email);
    debug_log("Mot de passe reçu (longueur) : " . strlen($password));

    $sql = "SELECT * FROM utilisateurs WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    debug_log("Requête SQL exécutée");
    debug_log("Utilisateur trouvé : " . ($user ? "Oui" : "Non"));

    if ($user) {
        debug_log("Vérification du mot de passe");
        if (password_verify($password, $user['motDePasse'])) {
            debug_log("Mot de passe correct");
            $_SESSION['utilisateur_id'] = $user['utilisateur_id'];
            debug_log("Session créée. ID utilisateur : " . $_SESSION['utilisateur_id']);
            debug_log("Redirection vers dashboard.php");
            header("Location: dashboard.php");
            exit();
        } else {
            debug_log("Mot de passe incorrect");
        }
    }

    debug_log("Échec de l'authentification");
    header("Location: login.php?error=1");
    exit();
} else {
    debug_log("Méthode non autorisée");
}

debug_log("Fin du processus de connexion");
?>
