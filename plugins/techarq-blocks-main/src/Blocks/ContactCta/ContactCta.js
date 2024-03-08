import ACFBlock from '../../../assets/js/blocks';
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
gsap.registerPlugin(ScrollTrigger);

/**
 * Custom ContactCta Block, describe your block here.
 */
class ContactCta{

    /**
     * Constructor method
     * 
     * @param {HTMLElement} block 
     */
    constructor(block){
        this.block = block;
        this.title = block.querySelector('.contact-cta__title');
        this.cta = block.querySelector('.contact-cta__cta-wrapper');
        this.modal = block.querySelector('.contact-cta__modal');
        this.closeIcon = block.querySelector('.contact-cta__modal-close');

        this.animateItems();
        this.modalController();
    }

    /**
     * The name of your block, don't modify this static method!!
     * 
     * @return {string}
     */
    static getName() {
        return 'ContactCta';
    }

    animateItems() {
        const titleWidth = this.title ? this.title.getBoundingClientRect().width : 0;
        const wrapper = this.block.querySelector('.contact-cta__title-wrapper');

        ScrollTrigger.create({
            trigger: this.block,
            start: "top+=100px bottom-=100px",
            end: "bottom 10%",
            onEnter: () => {
                wrapper.style.width = `${titleWidth}px`;
                this.cta.style.opacity = `1`;
                this.cta.style.transform = `translateX(0)`;
            },
            // markers: true,
        });
    }

    modalController() {
        const blockStatus = this.block.getAttribute("aria-status");
        
        if ( blockStatus === 'not-init' ) {
            this.cta.addEventListener('click', (e) => {
                e.preventDefault();
                console.debug('la concha de la lora');
                this.modal.classList.add('open');
            });

            this.closeIcon.addEventListener('click', (e) =>  {
                e.preventDefault();
                this.modal.classList.remove('open');
            })
        }
    }
}

new ACFBlock(ContactCta);
    