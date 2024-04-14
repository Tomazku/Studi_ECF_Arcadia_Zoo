
// Gestion du sous menu en js
document.addEventListener("DOMContentLoaded", function() {
    // Sélection de tous les éléments li contenant un sous-menu
    const menuItemsWithSubmenu = document.querySelectorAll('.menu ul li');

    // Ajout d'un gestionnaire d'événement pour chaque élément li
    menuItemsWithSubmenu.forEach(function(menuItem) {
        // Sélection du sous-menu correspondant
        const submenu = menuItem.querySelector('ul');

        // Gestion de l'événement au survol de l'élément li
        menuItem.addEventListener('mouseenter', function() {
            // Affichage du sous-menu
            submenu.style.display = 'block';
        });

        // Gestion de l'événement lorsque la souris quitte l'élément li
        menuItem.addEventListener('mouseleave', function() {
            // Ajout d'un délai avant de masquer le sous-menu
            setTimeout(function() {
                submenu.style.display = 'none';
            }, 500); // Délai en millisecondes (500 ms ici)
        });
    });
});
