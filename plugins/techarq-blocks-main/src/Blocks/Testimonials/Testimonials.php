<?php
/**
 * Custom Testimonials gutenberg block
 *
 * @package TecharqBlocks
 */

namespace TecharqBlocks\Blocks\Testimonials;

use TecharqBlocks\Setup\AcfBlocks;

/**
 * Block attributes
 */
class Testimonials {

	/**
	 * Block settings
	 */
	public function __construct() {
		acf_register_block_type(
			array_merge(
				AcfBlocks::block_definitions( get_class( $this ), array('techarq-dependencies')),
				array(
					'title'       => __( 'Testimonials', 'techarq-blocks' ),
					'description' => __( 'A custom slider for showing Testimonials from clients.', 'techarq-blocks' ),
					'category'    => 'techarq-blocks',
					'icon'        => 'star-filled',
					'keywords'    => array( 'testimonials' ),
				)
			)
		);
	}
}
