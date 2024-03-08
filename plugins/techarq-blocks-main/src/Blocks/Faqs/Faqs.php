<?php
/**
 * Custom Faqs gutenberg block
 *
 * @package TecharqBlocks
 */

namespace TecharqBlocks\Blocks\Faqs;

use TecharqBlocks\Setup\AcfBlocks;

/**
 * Block attributes
 */
class Faqs {

	/**
	 * Block settings
	 */
	public function __construct() {
		acf_register_block_type(
			array_merge(
				AcfBlocks::block_definitions( get_class( $this ), array('techarq-dependencies') ),
				array(
					'title'       => __( 'Faqs', 'techarq-blocks' ),
					'description' => __( 'A custom block to show Frequently Asked Questions.', 'techarq-blocks' ),
					'category'    => 'techarq-blocks',
					'icon'        => 'info-outline',
					'keywords'    => array( 'faqs' ),
				)
			)
		);
	}
}
