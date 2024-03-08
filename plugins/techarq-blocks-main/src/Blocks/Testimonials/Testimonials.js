import ACFBlock from '../../../assets/js/blocks';
import Swiper, { Navigation, Pagination } from 'swiper';
/**
 * Custom Testimonials Block, describe your block here.
 */
class Testimonials{

    /**
     * Constructor method
     * 
     * @param {HTMLElement} block 
     */
    constructor(block){
        this.block = block;
        this.sliderContainer = this.block.querySelector('.swiper');

        this.initSlider();
    }

    /**
     * The name of your block, don't modify this static method!!
     * 
     * @return {string}
     */
    static getName() {
        return 'Testimonials';
    }

    initSlider() {
        const slider = new Swiper(this.sliderContainer, {
            slidesPerView: 1,
            updateOnWindowResize: true,
            spaceBetween: 50,
            autoHeight: true,
            modules: [
                Pagination,
                Navigation
            ],
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    }
}

new ACFBlock(Testimonials);
    