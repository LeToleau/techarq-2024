import ACFBlock from '../../../assets/js/blocks';
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
gsap.registerPlugin(ScrollTrigger);

/**
 * Custom About Block, describe your block here.
 */
class About{

    /**
     * Constructor method
     * 
     * @param {HTMLElement} block 
     */
    constructor(block){
        this.block = block;
        this.title = block.querySelector('.about__title');
        this.copy = block.querySelector('.about__copy');
        this.cta = block.querySelector('.about__cta-wrapper');

        this.animateItems();
    }

    /**
     * The name of your block, don't modify this static method!!
     * 
     * @return {string}
     */
    static getName() {
        return 'About';
    }

    animateItems() {
        const blockStatus = this.block.getAttribute("aria-status");
        
        if ( blockStatus === 'not-init' ) {
            const items = [this.title, this.copy, this.cta];
            const images = this.block.querySelectorAll('.about__img-wrapper');

            ScrollTrigger.create({
                trigger: this.block,
                start: "top+=100px bottom-=100px",
                end: "bottom 10%",
                onEnter:             () => {
                    let i = 0;
                    let i2 = 0;
        
                    items.forEach((item) => {
                        item.style.transition = `opacity .5s, transform .5s`;
                        item.style.transitionDelay = `.${i}s`
                        item.style.opacity = `1`;
                        item.style.transform = `translateY(0)`;
                        i = i + 4;
                    });

                    images.forEach((item) => {
                        item.style.transition = `opacity .5s, transform .5s`;
                        item.style.transitionDelay = `${i2}0ms`
                        item.style.opacity = `1`;
                        item.style.transform = `translateY(0)`;
                        i2 = i2 + 20;
                    });
                },
                // markers: true,
            });
        }
    }
}

new ACFBlock(About);
    