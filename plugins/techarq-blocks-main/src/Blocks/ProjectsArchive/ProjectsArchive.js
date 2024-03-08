import ACFBlock from '../../../assets/js/blocks';
import AdvancedPagination from "../../../assets/js/utilities/advanced-pagination";

/**
 * Custom ProjectsArchive Block, describe your block here.
 */
class ProjectsArchive{

    /**
     * Constructor method
     * 
     * @param {HTMLElement} block 
     */
    constructor(block){
        this.block = block;

        this.setPagination()
    }

    /**
     * The name of your block, don't modify this static method!!
     * 
     * @return {string}
     */
    static getName() {
        return 'ProjectsArchive';
    }

    /**
	 * This method enables Advanced Pagination
	 */
	setPagination() {
        const blockStatus = this.block.getAttribute("aria-status");
        
        if ( blockStatus === 'not-init' ) {
            new AdvancedPagination(this.block);
        }
	}
}

new ACFBlock(ProjectsArchive);
    