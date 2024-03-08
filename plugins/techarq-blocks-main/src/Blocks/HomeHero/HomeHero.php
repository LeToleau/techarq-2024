<?php
/**
 * Custom Home Hero gutenberg block
 *
 * @package TecharqBlocks
 */

namespace TecharqBlocks\Blocks\HomeHero;

use TecharqBlocks\Setup\AcfBlocks;

/**
 * Block attributes
 */
class HomeHero {

	/**
	 * Block settings
	 */
	public function __construct() {
		acf_register_block_type(
			array_merge(
				AcfBlocks::block_definitions( get_class( $this ) ),
				array(
					'title'       => __( 'Home Hero', 'techarq-blocks' ),
					'description' => __( 'A custom Home Hero block.', 'techarq-blocks' ),
					'category'    => 'techarq-blocks',
					'icon'        => 'images-alt2',
					'keywords'    => array( 'home hero' ),
				)
			)
		);
	}
}
