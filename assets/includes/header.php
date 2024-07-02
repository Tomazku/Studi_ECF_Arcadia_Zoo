<header class='container-header'>
    <!-- Logo -->
    <div class="header">
        <div class='logo'>
            <a href="index.php">
                <img src="assets/images/logo.png" alt="Logo du zoo Arcadia">
            </a>
        </div>
        <div class="hamburger">&#9776;</div> <!-- Hamburger icon -->
        <div class='menu'>
            <nav>
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="services.php">Services</a></li>
                    <li><a href="habitats.php">Habitats</a></li>
                    <li><a href="horaires.php">Horaires</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </nav>
        </div>
        <div class="connexion">
            <button class="button-link" onclick="window.open('./pages/Back-end/login.php', '_blank')">Connexion</button>
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const hamburger = document.querySelector('.hamburger');
        const menu = document.querySelector('.menu');

        hamburger.addEventListener('click', function() {
            menu.classList.toggle('active');
        });
    });
</script>

