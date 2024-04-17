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

<!--Section Habitat-->

<div class="container-habitat">
  <div class="title-habitat">
    <h1>Découvrez nos <span class="orange-text">habitats</span></h1>
    <p>Explorez une variété d'habitats captivants, de la jungle exotique à la vaste savane et aux mystérieux marais, lors de votre visite au Zoo Arcadia.</p>
    <button class='button'>Nos habitats</button>
  </div>
  </div>
  
<div class="card-container">
  <div class="card">
      <img src="assets/images/Jungle.jpg" alt="">
    <div class="card-content">
      <p class="text-carte">
      Plongez au cœur de la luxuriante jungle tropicale au Zoo Arcadia, où les arbres majestueux et la végétation dense abritent une multitude de créatures exotiques, des singes espiègles aux oiseaux aux couleurs vives.
      </p>
      <button class="button">Découvrez la jungle</button>
    </div>
  </div>

  <div class="card">
    <div class="card-content">
      <p class="text-carte">
      Dans la vaste savane, vous serez émerveillé par la vue des éléphants majestueux errant paisiblement parmi les hautes herbes, tandis que les lions paresseux se prélassent sous le soleil chaud.      </p>
      <button class="button">Découvrez la savane</button>
    </div>
      <img src="assets/images/Savane.jpg" alt="">
  </div>

  <div class="card">
      <img src="assets/images/Marais.jpg" alt="">
    <div class="card-content">
      <p class="text-carte">
      Plongez au cœur de la luxuriante jungle tropicale au Zoo Arcadia, où les arbres majestueux et la végétation dense abritent une multitude de créatures exotiques, des singes espiègles aux oiseaux aux couleurs vives.      </p>
      <button class="button">Découvrez les marais</button>
    </div>
  </div>
</div>    

<!-- section animaux -->
</section>

<section class="animaux">
  <div class="container-animaux">
  <H2>Découvrez nos <span class="orange-text">Animaux</span></H2>
        <div class="grid-autruche ">
          <img class="large-img" src="assets/images/Autruche.jpg" alt="">
          <h4 class="title-animaux">Autruche</h4>
        </div>
  </div>
    </section>

   

<?php include 'assets/includes/footer.php'; ?>
<script src="/assets/scripts/script.js"></script>
</body>
</html>