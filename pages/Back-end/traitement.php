<?php
include('header.php');
include('./pdo.php');

// Vérifiez si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérez les données du formulaire
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Faites quelque chose avec les données, comme les enregistrer dans une base de données ou les envoyer par e-mail
    
    // Exemple : enregistrer dans un fichier texte
    $contenu = "Nom: $nom\nEmail: $email\nMessage: $message\n";
    file_put_contents('messages.txt', $contenu, FILE_APPEND);

    // Envoyer une réponse JSON pour indiquer que l'envoi a réussi
    echo json_encode(["success" => true, "message" => "Votre message a été envoyé avec succès!"]);
    exit; // Assurez-vous d'utiliser exit() après avoir envoyé la réponse
}
include('footer.php');
?>
