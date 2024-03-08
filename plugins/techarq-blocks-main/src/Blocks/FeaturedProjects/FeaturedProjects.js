import ACFBlock from '../../../assets/js/blocks';
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
gsap.registerPlugin(ScrollTrigger);

/**
 * Custom FeaturedProjects Block, describe your block here.
 */
class FeaturedProjects{

    /**
     * Constructor method
     * 
     * @param {HTMLElement} block 
     */
    constructor(block){
        this.block = block;
        this.options = block.querySelectorAll(".featured-projects__project");
        this.title = block.querySelector(".featured-projects__title");
        this.copy = block.querySelector(".featured-projects__copy");

        const blockStatus = this.block.getAttribute("aria-status");
        
        if ( blockStatus === 'not-init' ) {
            this.addListeners();
            this.animateItems();
        }
    }

    /**
     * The name of your block, don't modify this static method!!
     * 
     * @return {string}
     */
    static getName() {
        return 'FeaturedProjects';
    }

    // Your methods
    addListeners() {
        const self = this;
        if (window.innerWidth < 768) {
            this.options.forEach((option) => {
                const height = option.getBoundingClientRect().height;
                option.style.height = `${height}px`;

                option.addEventListener('click', (e) => {                    
                    option.classList.add("active");
                    option.style.height = `${height + 60}px`
                })

                option.addEventListener('mouseleave', (e) => {
                    option.classList.remove("active");
                    option.style.height = `${height}px`
                })
            })
        }
    }

    animateItems() {
        const items = [this.title, this.copy];

        ScrollTrigger.create({
            trigger: this.block,
            start: "top+=100px bottom-=100px",
            end: "bottom 10%",
            onEnter: () => {
                let i = 0;
                let i2 = 0;
    
                items.forEach((item) => {
                    item.style.transition = `opacity .5s, transform .5s`;
                    item.style.transitionDelay = `.${i}s`
                    item.style.opacity = `1`;
                    item.style.transform = `translateY(0)`;
                    i = i + 4;
                });

                this.options.forEach((item) => {
                    item.style.opacity = `1`;
                    item.style.transform = `translateY(0)`;
                    i2 = i2 + 20;
                });
            },
            // markers: true,
        });
    }
}

new ACFBlock(FeaturedProjects);
    