let BlockClassUse;

/**
 * Class to instantiate all JS blocks
 */
export default class ACFBlock {
    /**
     * ACFBlock constructor method
     * @param {function} blockClass to instantiate
     */
    constructor(blockClass) {
        BlockClassUse = blockClass;
        this.admin();
        this.frontend();
    }
    /**
     * Initialize dynamic block preview (editor)
     */
    admin() {
        if (window.acf) {
            window.acf.addAction(`render_block_preview/type=${BlockClassUse.getName().replace(/([a-z])([A-Z])/g, "$1-$2").toLowerCase()}`, this.initializeBlock);
        }
    }
    /**
     * Initialize each block on page load (front end)
     */
    frontend() {
        const self = this;
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(`.js-${BlockClassUse.getName().replace(/([a-z])([A-Z])/g, "$1-$2").toLowerCase()}`).forEach(block => {
                self.initializeBlock(block)
            })
        });
    }

    /**
     * Initialize Block js
     * @param {HTMLElement} block 
     */
    initializeBlock(block) {
        if(window.location.href.indexOf('wp-admin') != -1){
            new BlockClassUse(block[0].querySelector(`.js-${BlockClassUse.getName().replace(/([a-z])([A-Z])/g, "$1-$2").toLowerCase()}`));
        }else{
            new BlockClassUse(block);
        }
    }
}