document.addEventListener('DOMContentLoaded', function() {
    const hamburger = document.querySelector('.hamburger');
    const menu = document.querySelector('.menu');
    const header = document.querySelector('.container-header');
    let lastScrollTop = 0;
    let initialTop = getComputedStyle(header).top;

    hamburger.addEventListener('click', function() {
        menu.classList.toggle('active');
        hamburger.classList.toggle('active'); 
    });

    window.addEventListener('scroll', function() {
        let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

        if (scrollTop > lastScrollTop) {
            // Scroll vers le bas
            header.style.top = `-${header.offsetHeight}px`; // Cache le header
        } else {
            // Scroll vers le haut
            header.style.top = initialTop; // Remet le header à sa position initiale
        }
        
        lastScrollTop = scrollTop;
    });
});
