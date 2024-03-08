<?php
/**
 * Custom About gutenberg block
 *
 * @package TecharqBlocks
 */

namespace TecharqBlocks\Blocks\About;

use TecharqBlocks\Setup\AcfBlocks;

/**
 * Block attributes
 */
class About {

	/**
	 * Block settings
	 */
	public function __construct() {
		acf_register_block_type(
			array_merge(
				AcfBlocks::block_definitions( get_class( $this ) ),
				array(
					'title'       => __( 'About', 'techarq-blocks' ),
					'description' => __( 'A custom About block.', 'techarq-blocks' ),
					'category'    => 'techarq-blocks',
					'icon'        => 'images-alt2',
					'keywords'    => array( 'about' ),
				)
			)
		);
	}
}
