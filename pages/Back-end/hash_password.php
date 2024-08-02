<?php
include('./pdo.php');

try {
    // Sélectionner tous les utilisateurs
    $stmt = $pdo->query('SELECT utilisateur_id, motDePasse FROM utilisateurs');
    $utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($utilisateurs as $utilisateur) {
        $utilisateur_id = $utilisateur['utilisateur_id'];
        $motDePasse = $utilisateur['motDePasse'];

        // Vérifiez si le mot de passe est déjà haché
        if (!password_get_info($motDePasse)['algo']) {
            // Hacher le mot de passe
            $hashedPassword = password_hash($motDePasse, PASSWORD_DEFAULT);

            // Mettre à jour le mot de passe haché dans la base de données
            $updateStmt = $pdo->prepare('UPDATE utilisateurs SET motDePasse = ? WHERE utilisateur_id = ?');
            $updateStmt->execute([$hashedPassword, $utilisateur_id]);
        }
    }

    echo "Les mots de passe ont été hachés avec succès.";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
