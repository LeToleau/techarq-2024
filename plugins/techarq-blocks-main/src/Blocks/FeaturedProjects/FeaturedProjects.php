<?php
/**
 * Custom Featured Projects gutenberg block
 *
 * @package TecharqBlocks
 */

namespace TecharqBlocks\Blocks\FeaturedProjects;

use TecharqBlocks\Setup\AcfBlocks;

/**
 * Block attributes
 */
class FeaturedProjects {

	/**
	 * Block settings
	 */
	public function __construct() {
		acf_register_block_type(
			array_merge(
				AcfBlocks::block_definitions( get_class( $this ) ),
				array(
					'title'       => __( 'Featured Projects', 'techarq-blocks' ),
					'description' => __( 'A custom Featured Projects block.', 'techarq-blocks' ),
					'category'    => 'techarq-blocks',
					'icon'        => 'images-alt2',
					'keywords'    => array( 'featured projects' ),
				)
			)
		);
	}
}
