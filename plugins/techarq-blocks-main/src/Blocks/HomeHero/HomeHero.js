import ACFBlock from '../../../assets/js/blocks';

/**
 * Custom HomeHero Block, describe your block here.
 */
class HomeHero{

    /**
     * Constructor method
     * 
     * @param {HTMLElement} block 
     */
    constructor(block){
        // Your methods init and porps
        this.block = block;
        this.title = block.querySelector('.home-hero__title');
        this.copy = block.querySelector('.home-hero__copy');
        this.cta = block.querySelector('.home-hero__cta-wrapper');

        this.animateItems();
    }

    /**
     * The name of your block, don't modify this static method!!
     * 
     * @return {string}
     */
    static getName() {
        return 'HomeHero';
    }

    // Your methods
    animateItems() {
        const items = [this.title, this.copy, this.cta].filter(item => item !== null);
        const transitionDelayIncrement = 0.4;
    
        items.forEach((item, index) => {
            item.style.transition = `opacity .5s, transform .5s`;
            item.style.transitionDelay = `${transitionDelayIncrement * index}s`;
            item.style.opacity = `1`;
            item.style.transform = `translateY(0)`;
        });
    }
}

new ACFBlock(HomeHero);
    