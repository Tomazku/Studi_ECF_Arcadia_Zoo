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
    <div class="message-management-container">
        <h1>Gestion des messages - Arcadia Zoo</h1>

        <?php
include('./pdo.php');


        // Vérifiez si la requête est de type POST
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['delete_message'])) {
                $id_message = $_POST['id_message'];
                try {
                    $sql = "DELETE FROM messages WHERE id_message = :id_message";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':id_message', $id_message);
                    $stmt->execute();
                    echo "<p class='success-message'>Message supprimé avec succès.</p>";
                } catch (PDOException $e) {
                    echo "<p class='error-message'>Erreur lors de la suppression du message : " . $e->getMessage() . "</p>";
                }
            } else {
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
                        echo "<h2 class='success-message'>Merci ! Votre message a été envoyé.</h2>";
                    } catch (PDOException $e) {
                        http_response_code(500);
                        echo "<p class='error-message'>Erreur lors de l'envoi du message : " . $e->getMessage() . "</p>";
                    }
                } else {
                    http_response_code(400);
                    echo "<p class='error-message'>Veuillez vérifier les champs du formulaire.</p>";
                }
            }
        }

        // Affichage des messages sous forme de tableau
        try {
            $sql = "SELECT id_message, nom, prenom, email, date_time, messages FROM messages ORDER BY date_time DESC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $messages = $stmt->fetchAll();

            echo "<table class='message-table'>";
            echo "<thead>";
            echo "<tr><th>Nom</th><th>Prénom</th><th>Email</th><th>Date d'envoi</th><th>Message</th><th>Action</th></tr>";
            echo "</thead>";
            echo "<tbody>";
            foreach ($messages as $msg) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($msg['nom']) . "</td>";
                echo "<td>" . htmlspecialchars($msg['prenom']) . "</td>";
                echo "<td>" . htmlspecialchars($msg['email']) . "</td>";
                echo "<td>" . htmlspecialchars($msg['date_time']) . "</td>";
                echo "<td>" . htmlspecialchars($msg['messages']) . "</td>";
                echo "<td>";
                echo "<form method='POST' class='delete-form' onsubmit='return confirm(\"Êtes-vous sûr de vouloir supprimer ce message ?\");'>";
                echo "<input type='hidden' name='id_message' value='" . $msg['id_message'] . "'>";
                echo "<button type='submit' name='delete_message' class='delete-btn'>Supprimer</button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";

        } catch (PDOException $e) {
            echo "<p class='error-message'>Erreur : " . $e->getMessage() . "</p>";
        }
        ?>
    </div>
    <?php include('footer.php'); ?>
</body>
</html>
