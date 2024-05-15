<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION // Activer le mode d'erreur exception pour mieux gérer les erreurs
    ]);

    // Section avis
    $avis_submit = isset($_GET['avis_submit']) && $_GET['avis_submit'] == true;
    $query = "SELECT * FROM avis WHERE isVisible = 1";
    $statement = $pdo->query($query);
    $avis_visibles = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Section habitat
    $habitats = $pdo->query("SELECT habitat_id, nom, description, image FROM habitat")->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Découvrez le zoo Arcadia</title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="header_footer.css">
    <link rel="shortcut icon" href="assets/images/fav_icon.png" type="image/x-icon">
</head>
<body>
    <?php include 'assets/includes/header.php'; ?>
    <!-- Section Héro -->
    <div class="welcome-section">
        <div class="welcome-text">
            <h1>Bienvenue au zoo <br><span class="orange-text">ARCADIA</span></h1>
            <p>Découvrez l'émerveillement de la nature au Zoo Arcadia, situé au cœur de la majestueuse forêt de Brocéliande en Bretagne. Depuis 1960, notre zoo offre une expérience immersive avec une diversité d'animaux fascinants, répartis dans des habitats soigneusement conçus, tels que la savane, la jungle et les marais. Notre engagement envers le bien-être animal se reflète dans les contrôles quotidiens assurés par nos vétérinaires dévoués, garantissant une attention minutieuse à la santé de nos pensionnaires. Rejoignez-nous pour une aventure inoubliable et laissez-vous transporter par la magie de la nature à Arcadia.</p>
        </div>
    </div>

    <!-- Section Habitat -->
    <div class="container-habitat">
        <div class="title-habitat">
            <h1>Découvrez nos <span class="orange-text">habitats</span></h1>
            <p>Explorez une variété d'habitats captivants, de la jungle exotique à la vaste savane et aux mystérieux marais, lors de votre visite au Zoo Arcadia.</p>
            <button class='button'><a href="habitats.php">Découvrez nos habitats</a></button>
        </div>
    </div>

    <div class="card-container">
        <?php foreach ($habitats as $habitat): ?>
        <div class="card">
            <img src="http://arcadia-zoo/Studi_ECF_Arcadia_Zoo/pages/Back-end/animals/<?= htmlspecialchars($habitat['image']) ?>" alt="Habitat de <?= htmlspecialchars($habitat['nom']) ?>" style="width:200px;">
            <div class="card-content">
                <p class="text-carte"><?= htmlspecialchars($habitat['description']); ?></p>
                <button class="button">Découvrez <?= htmlspecialchars($habitat['nom']); ?></button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- section animaux -->
    <section class="container-animaux">
        <h1 class="title">Découvrez nos <span class="orange-text">animaux</span></h1>
        <div class="animals">
            <div class="animal autruche">
                <img src="assets/images/Autruche.webp" alt="Autruche">
                <p>Autruches</p>
            </div>
            <div class="animal">
                <img src="assets/images/Elephant.webp" alt="Éléphant">
                <p>Éléphants</p>
            </div>
            <div class="animal">
                <img src="assets/images/Tigre.webp" alt="Tigre">
                <p>Tigres</p>
            </div>
        </div>
        <div class="lower-animals">
            <div class="animal">
                <img src="assets/images/Singe.webp" alt="Singe">
                <p>Singes</p>
            </div>
            <div class="animals-footer">
                <p>Et bien d’autres encore vous attendent !</p>
                <button class="button"><a href="animaux.php">Découvrez nos animaux</a></button>
            </div>
            <div class="animal crocodile">
                <img src="assets/images/Crocodile.webp" alt="Crocodile">
                <p>Crocodiles</p>
            </div>
        </div>
    </section>

    <!-- Section services -->
    <section class="services">
        <div class="container-services">
            <h1 class="title">Découvez nos <span class="orange-text">services</span></h1>
            <p>Profitez d'une expérience inoubliable au Zoo Arcadia avec nos services exclusifs, conçus pour rendre votre visite aussi agréable et confortable que possible.</p>
            <div class="service-card">
                <div class="service-content">
                    <img class="service_content_img" src="assets/images/Restaurant.webp" alt="">
                    <p class="text-content">
                        Plongez dans une expérience culinaire exceptionnelle au restaurant de qualité d'Arcadia. Avec une cuisine mettant en avant des produits locaux frais, notre restaurant offre une vue panoramique sur les paysages enchanteurs du zoo, vous promettant une expérience gastronomique mémorable. 
                        <br>       
                        <button class="button">Découvrez nos restaurants</button>
                    </p>
                </div>
                <div class="service-content">
                    <p class="text-content">
                        Explorez les splendeurs de la faune aux côtés de nos guides experts lors de visites guidées gratuites au Zoo Arcadia. Laissez-vous guider à travers une aventure captivante où vous découvrirez les habitats naturels de nos résidents, en apprendrez davantage sur la vie sauvage et aurez l'opportunité d'observer de près certains des animaux les plus fascinants de la planète.
                        <br>
                        <button class="button">Découvrez nos services</button>
                      </p>
                      <img class="service_content_img" src="assets/images/petit_train.webp" alt="">
                </div>
            </div>      
        </div>
    </section>

    <!-- Section avis -->
    <section class="avis_confirmed">
        <div class="container_avis">
            <h1 class="title">Ce qu'ils <span class="orange-text">disent de nous</span></h1>
            <p>Les visiteurs du Zoo Arcadia partagent leur expérience inoubliable et leurs moments magiques passés au zoo.</p>
            <ul class="avis_container">
                <?php foreach ($avis_visibles as $avis) : ?>
                    <li class="avis"><strong><?= htmlspecialchars($avis['pseudo']) ?>:</strong> <?= htmlspecialchars($avis['commentaire']) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>

    <?php include 'assets/includes/footer.php'; ?>
    <script src="/assets/scripts/script.js"></script>
</body>
</html>
