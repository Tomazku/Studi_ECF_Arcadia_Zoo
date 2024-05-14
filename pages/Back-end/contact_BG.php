<?php
include('header.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des messages - Arcadia Zoo</title>
    <link rel="stylesheet" href="interfaces.css">
</head>
<body>
    
    <h1>Gestion des messages - Arcadia Zoo</h1>

<?php
// Connexion à la base de données
try {
    $pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Vérifiez si la requête est de type POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_SPECIAL_CHARS);
    $prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($nom && $prenom && $email && $message) {
        try {
            // Préparez et exécutez l'insertion SQL
            $sql = "INSERT INTO messages (nom, prenom, email, messages) VALUES (:nom, :prenom, :email, :messages)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':messages', $message);
            $stmt->execute();
            echo "<h2>Merci ! Votre message a été envoyé.</h2>";
        } catch (PDOException $e) {
            http_response_code(500);
            echo "Erreur lors de l'envoi du message : " . $e->getMessage();
        }
    } else {
        http_response_code(400);
        echo "Veuillez vérifier les champs du formulaire.";
    }
}

// Affichage des messages sous forme de tableau
try {
    $sql = "SELECT nom, prenom, email, date_time, messages FROM messages ORDER BY date_time DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $messages = $stmt->fetchAll();

    echo "<table border='1'>";
    echo "<thead>";
    echo "<tr><th>Nom</th><th>Prénom</th><th>Email</th><th>Date d'envoi</th><th>Message</th></tr>";
    echo "</thead>";
    echo "<tbody>";
    foreach ($messages as $msg) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($msg['nom']) . "</td>";
        echo "<td>" . htmlspecialchars($msg['prenom']) . "</td>";
        echo "<td>" . htmlspecialchars($msg['email']) . "</td>";
        echo "<td>" . htmlspecialchars($msg['date_time']) . "</td>";
        echo "<td>" . htmlspecialchars($msg['messages']) . "</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
include('footer.php');
?>

</body>
</html>
