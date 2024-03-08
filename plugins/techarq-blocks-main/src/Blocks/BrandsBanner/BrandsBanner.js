import ACFBlock from '../../../assets/js/blocks';
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
gsap.registerPlugin(ScrollTrigger);

/**
 * Custom BrandsBanner Block, describe your block here.
 */
class BrandsBanner{

    /**
     * Constructor method
     * 
     * @param {HTMLElement} block 
     */
    constructor(block){
        this.block = block;
        this.title = block.querySelector('.brands-banner__title');
        this.logos = block.querySelectorAll('.brands-banner__image');

        this.animateItems();
    }

    /**
     * The name of your block, don't modify this static method!!
     * 
     * @return {string}
     */
    static getName() {
        return 'BrandsBanner';
    }

    animateItems() {
        ScrollTrigger.create({
            trigger: this.block,
            start: "top+=100px bottom-=100px",
            end: "bottom 10%",
            onEnter: () => {
                let i = 0;

                this.title.style.transition = `opacity .5s, transform .5s`;
                this.title.style.opacity = `1`;
                this.title.style.transform = `translateY(0)`;
    
                this.logos.forEach((item) => {
                    item.style.transition = `opacity .5s, transform .5s`;
                    item.style.transitionDelay = `${i}00ms`
                    item.style.opacity = `1`;
                    item.style.transform = `translateY(0)`;
                    i = i + 1;
                });
            },
            // markers: true,
        });
    }
}

new ACFBlock(BrandsBanner);
    