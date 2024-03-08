import ACFBlock from '../../../assets/js/blocks';
import { gsap } from "gsap";
import Swiper from 'swiper/bundle'
    
import { ScrollTrigger } from "gsap/ScrollTrigger";


gsap.registerPlugin(ScrollTrigger);

/**
 * Custom OurServices Block, describe your block here.
 */
class OurServices{

    /**
     * Constructor method
     * 
     * @param {HTMLElement} block 
     */
    constructor(block){
        this.block = block;
        this.services = block.querySelectorAll('.our-services__service');
        this.animation();
    }

    /**
     * The name of your block, don't modify this static method!!
     * 
     * @return {string}
     */
    static getName() {
        return 'OurServices';
    }

    animation() {

        const blockStatus = this.block.getAttribute("aria-status");
        
        if ( blockStatus === 'not-init' ) {
            const swipers = [];
            const delay = 2000;
            this.services.forEach((service) => {
    
                const swiper = new Swiper(service.querySelector('.swiper'), {
                    speed: 750,
                    slidesPerView: 1,
                    autoplay: {
                        delay: delay,
                        disableOnInteraction: false,
                    },
                    loop: true,
                    effect: 'coverflow',
                });
    
                swipers.push(swiper);
            })

            const startNextSwiper = (index) => {
                setTimeout(() => {
                    swipers[index].autoplay.start();
                }, 500);
            };
            
            swipers.forEach((swiper, index) => {
                swiper.on('slideChange', () => {
                    swipers.forEach((s) => s.autoplay.stop());
                    index < swipers.length - 1 ? startNextSwiper(index + 1) : startNextSwiper(0);
                });
            });

            const animateImages = () => {
                this.services.forEach((service) => {
                    const imagesContainer = service.querySelector('.our-services__service-images');
                    service.style.opacity = `1`;
                });
                swipers[0].autoplay.start();
            }
            
            ScrollTrigger.create({
                trigger: this.block,
                start: "top+=100px bottom",
                end: "bottom 10%",
                onEnter: animateImages,
                // markers: true,
            });
        }
    }

    // Your methods
    
}

new ACFBlock(OurServices);
    