<?php

include('header.php');
include('./pdo.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['heure_ouverture'] as $id => $heure_ouverture) {
        $heure_fermeture = $_POST['heure_fermeture'][$id];
        $ferme = isset($_POST['ferme'][$id]) ? 1 : 0;

        $stmt = $pdo->prepare("UPDATE horaires_ouverture SET heure_ouverture = ?, heure_fermeture = ?, ferme = ? WHERE horaires_id = ?");
        $stmt->execute([$heure_ouverture, $heure_fermeture, $ferme, $id]);
    }

    // Redirection pour éviter la resoumission du formulaire
    header('Location: ./gestion_horaires.php');
    exit;
}
include('footer.php');
?>
