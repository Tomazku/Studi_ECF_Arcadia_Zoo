let currentSlide = 0;
const slides = document.querySelectorAll('.avis_slide');
const totalSlides = slides.length;

function updateSlidePosition() {
    const container = document.querySelector('.avis_container');
    container.style.transform = `translateX(-${currentSlide * 100}%)`;
}

function changeSlide(direction) {
    currentSlide += direction;

    if (currentSlide < 0) {
        currentSlide = totalSlides - 1;
    } else if (currentSlide >= totalSlides) {
        currentSlide = 0;
    }

    updateSlidePosition();
}

// Initialisation
updateSlidePosition();