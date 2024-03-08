import ACFBlock from '../../../assets/js/blocks';

/**
 * Custom LeftRight Block, describe your block here.
 */
class LeftRight{

    /**
     * Constructor method
     * 
     * @param {HTMLElement} block 
     */
    constructor(block){
        // Your methods init and porps
        console.warn(block)
    }

    /**
     * The name of your block, don't modify this static method!!
     * 
     * @return {string}
     */
    static getName() {
        return 'LeftRight';
    }

    // Your methods
}

new ACFBlock(LeftRight);
    