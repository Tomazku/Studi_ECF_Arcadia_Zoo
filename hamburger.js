    document.addEventListener('DOMContentLoaded', function() {
            const hamburger = document.querySelector('.hamburger');
            const menu = document.querySelector('.menu');

            hamburger.addEventListener('click', function() {
                menu.classList.toggle('active');
            });
        });


