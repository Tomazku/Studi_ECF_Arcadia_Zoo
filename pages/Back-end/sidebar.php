<nav class="sidebar">
    <ul>
        <li <?php if ($page == 'dashboard') echo 'class="active"'; ?>><a href="dashboard.php">Tableau de bord</a></li>
        <li <?php if ($page == 'user_management') echo 'class="active"'; ?>><a href="user_management.php">Gestion des utilisateurs</a></li>
        <li <?php if ($page == 'animal_management') echo 'class="active"'; ?>><a href="animal_management.php">Gestion des animaux</a></li>
        <!-- Ajoutez d'autres liens de navigation ici -->
    </ul>
</nav>
