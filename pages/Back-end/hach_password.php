<?php
include('./pdo.php');

$sql = "SELECT utilisateur_id, motDePasse FROM utilisateurs";
$stmt = $pdo->query($sql);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($users as $user) {
    $id = $user['utilisateur_id'];
    $password = $user['motDePasse'];
    
    // Vérifier si le mot de passe n'est pas déjà haché
    if (!password_get_info($password)['algo']) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $updateSql = "UPDATE utilisateurs SET motDePasse = :password WHERE utilisateur_id = :id";
        $updateStmt = $pdo->prepare($updateSql);
        $updateStmt->execute(['password' => $hashedPassword, 'id' => $id]);
        
        echo "Mot de passe mis à jour pour l'utilisateur ID: $id<br>";
    }
}

echo "Mise à jour terminée.";
?>