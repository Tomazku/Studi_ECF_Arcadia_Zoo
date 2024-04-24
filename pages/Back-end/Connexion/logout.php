<?php
// Déconnexion de l'utilisateur
session_start();
session_destroy();

// Redirection vers la page de connexion
header("Location: login.php");
exit();
?>
