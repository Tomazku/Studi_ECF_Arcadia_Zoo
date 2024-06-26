<?php
include('./pdo.php');

// Vérification si le formulaire de connexion a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Préparation de la requête SQL pour vérifier les identifiants de connexion
    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    // Vérification si l'utilisateur existe et si le mot de passe est correct
    if ($user && password_verify($password, $user['password'])) {
        // Génére un jeton unique pour la confirmation de connexion
        $token = bin2hex(random_bytes(16));

        // Mise à jour la table des utilisateurs avec le jeton de confirmation
        $sql = "UPDATE users SET token = :token WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['token' => $token, 'id' => $user['id']]);

        // Envoyer un e-mail de confirmation
        // $to = $email;
        // $subject = 'Confirmation de Connexion';
        // $message = 'Veuillez confirmer votre connexion en cliquant sur ce lien : http://votre_site.com/confirm.php?token=' . $token;
        // $headers = 'From: votre_email@example.com' . "\r\n" .
        //     'Reply-To: votre_email@example.com' . "\r\n" .
        //     'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);

        // Démarre la session et stocker l'ID de l'utilisateur
        session_start();
        $_SESSION['user_id'] = $user['id'];

        // Redirection de l'utilisateur en fonction de son rôle
        if ($user['role'] == 'employee') {
            header('Location: employee_home.php');
        } elseif ($user['role'] == 'veterinarian') {
            header('Location: veterinarian_home.php');
        }
        exit();
    } else {
        // Redirection vers la page de connexion avec un message d'erreur
        header('Location: login.php?error=1');
        exit();
    }
}
?>
