<?php
/**
 * Custom Contact Cta gutenberg block
 *
 * @package TecharqBlocks
 */

namespace TecharqBlocks\Blocks\ContactCta;

use TecharqBlocks\Setup\AcfBlocks;

/**
 * Block attributes
 */
class ContactCta {

	/**
	 * Block settings
	 */
	public function __construct() {
		acf_register_block_type(
			array_merge(
				AcfBlocks::block_definitions( get_class( $this ) ),
				array(
					'title'       => __( 'Contact Cta', 'techarq-blocks' ),
					'description' => __( 'A custom Contact Cta block.', 'techarq-blocks' ),
					'category'    => 'techarq-blocks',
					'icon'        => 'images-alt2',
					'keywords'    => array( 'contact cta' ),
				)
			)
		);
	}
}
