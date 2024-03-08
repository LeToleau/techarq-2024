<?php
/**
 * Custom Our Services gutenberg block
 *
 * @package TecharqBlocks
 */

namespace TecharqBlocks\Blocks\OurServices;

use TecharqBlocks\Setup\AcfBlocks;

/**
 * Block attributes
 */
class OurServices {

	/**
	 * Block settings
	 */
	public function __construct() {
		acf_register_block_type(
			array_merge(
				AcfBlocks::block_definitions( get_class( $this ), array('swiper') ),
				array(
					'title'       => __( 'Our Services', 'techarq-blocks' ),
					'description' => __( 'A custom Our Services block.', 'techarq-blocks' ),
					'category'    => 'techarq-blocks',
					'icon'        => 'images-alt2',
					'keywords'    => array( 'our services' ),
				)
			)
		);
	}
}
