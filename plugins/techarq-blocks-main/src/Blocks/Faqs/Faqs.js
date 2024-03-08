import ACFBlock from '../../../assets/js/blocks';

/**
 * Custom Faqs Block, describe your block here.
 */
class Faqs{

    /**
     * Constructor method
     * 
     * @param {HTMLElement} block 
     */
    constructor(block){
        // Your methods init and porps
        this.initAccordion();
    }

    /**
     * The name of your block, don't modify this static method!!
     * 
     * @return {string}
     */
    static getName() {
        return 'Faqs';
    }

    // Your methods
    initAccordion() {
        jQuery(function ($) {
            var allPanels = $('.accordion > li > .accordion-content').hide();
            $('.accordion > li > .question > span').on('click', function () {
                if (jQuery(this).hasClass("acc-current")) {
                    $('.accordion > li > .question > span').removeClass("acc-current");
                    allPanels.slideUp();
                } else {
                    $('.accordion > li > .question > span').removeClass("acc-current");
                    allPanels.slideUp();
                    $(this).parent().next().slideDown();
                    $(this).addClass("acc-current");
                }
                return false;
            });
        });
    }
}

new ACFBlock(Faqs);
    