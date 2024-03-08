<?php
/**
 * Custom Projects Archive gutenberg block
 *
 * @package TecharqBlocks
 */

namespace TecharqBlocks\Blocks\ProjectsArchive;

use TecharqBlocks\Setup\AcfBlocks;

/**
 * Block attributes
 */
class ProjectsArchive {

	/**
	 * Block settings
	 */
	public function __construct() {
		acf_register_block_type(
			array_merge(
				AcfBlocks::block_definitions( get_class( $this ) ),
				array(
					'title'       => __( 'Projects Archive', 'techarq-blocks' ),
					'description' => __( 'A custom Projects Archive block.', 'techarq-blocks' ),
					'category'    => 'techarq-blocks',
					'icon'        => 'images-alt2',
					'keywords'    => array( 'projects archive' ),
				)
			)
		);
	}
}
