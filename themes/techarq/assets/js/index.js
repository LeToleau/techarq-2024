import Navbar from "./base/base-navbar";
import PhotoSlider from "./single/photo-slider";

document.addEventListener('DOMContentLoaded', () => {
    // Función para ajustar el fondo de la sección del proyecto según el desplazamiento
    function adjustBackgroundPosition(selector, percentage) {
        const element = document.querySelector(selector);
        if (element) {
            document.addEventListener("scroll", function() {
                const offset = window.scrollY;
                element.style.backgroundPositionY = `calc(${percentage}% + ${offset * -0.3}px)`;
            });
        }
    }

    // Inicializar la barra de navegación
    const header = document.querySelector('.js-navbar');
    if (header) {
        new Navbar(header);
    }

    // Inicializar el slider de fotos del proyecto
    const projectSlider = document.querySelector('.js-photo-slider');
    if (projectSlider) {
        new PhotoSlider(projectSlider);
    }

    // Ajustar el fondo de las secciones específicas
    adjustBackgroundPosition(".techarq-single-project__hero-bgd", 100);
    adjustBackgroundPosition(".techarq-about__hero-bgd", 35);
    adjustBackgroundPosition(".techarq-contact__hero-bgd", 109);

    // Función para manejar la apertura y cierre de detalles de características del proyecto
    function handleFeatureDetails(feature) {
        const title = feature.querySelector('.techarq-single-project__feature-text');
        const details = feature.querySelector('.techarq-single-project__feature-detail-wrapper');
        const detailsHeight = details.querySelector('.techarq-single-project__feature-details').getBoundingClientRect().height;

        title.addEventListener('click', () => {
            const currentlyOpen = featuresWrapper.querySelector('.open');
            if (!details.classList.contains('open')) {
                if (currentlyOpen) {
                    currentlyOpen.classList.remove('open');
                    currentlyOpen.style.height = `0`;
                }
                details.classList.add('open');
                details.style.height = `${detailsHeight}px`;
            } else {
                details.classList.remove('open');
                details.style.height = `0px`;
            }
        });
    }

    // Manejar la apertura y cierre de detalles de características del proyecto para cada elemento
    const featuresWrapper = document.querySelector('.techarq-single-project__features');
    if (featuresWrapper) {
        const projectFeatures = featuresWrapper.querySelectorAll('.techarq-single-project__feature-text-wrapper');
        if (projectFeatures) {
            projectFeatures.forEach(feature => {
                handleFeatureDetails(feature);
            });
        }
    }
});