<?php
include('./pdo.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['motDePasse'];

    $sql = "SELECT * FROM utilisateurs WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    var_dump($user); // Debug: Afficher les informations de l'utilisateur

    if ($user && $password === $user['motDePasse']) {
        session_start();
        $_SESSION['utilisateur_id'] = $user['utilisateur_id'];

        var_dump($_SESSION); // Debug: Afficher les informations de la session

        if ($user['role'] == 'employe') {
            header('Location: employee_dashboard.php');
        } elseif ($user['role'] == 'veterinaire') {
            header('Location: veterinarian_dashboard.php');
        } else {
            header('Location: admin_dashboard.php');
        }
        exit();
    } else {
        var_dump($password, $user['motDePasse']); // Debug: Afficher les mots de passe pour comparaison
        header('Location: login.php?error=1');
        exit();
    }
}
?>