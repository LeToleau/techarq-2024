<?php
/**
 * Custom Left Right gutenberg block
 *
 * @package TecharqBlocks
 */

namespace TecharqBlocks\Blocks\LeftRight;

use TecharqBlocks\Setup\AcfBlocks;

/**
 * Block attributes
 */
class LeftRight {

	/**
	 * Block settings
	 */
	public function __construct() {
		acf_register_block_type(
			array_merge(
				AcfBlocks::block_definitions( get_class( $this ) ),
				array(
					'title'       => __( 'Left Right', 'techarq-blocks' ),
					'description' => __( 'A custom Left Right block.', 'techarq-blocks' ),
					'category'    => 'techarq-blocks',
					'icon'        => 'images-alt2',
					'keywords'    => array( 'left right' ),
				)
			)
		);
	}
}
