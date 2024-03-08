<?php
/**
 * Custom Brands Banner gutenberg block
 *
 * @package TecharqBlocks
 */

namespace TecharqBlocks\Blocks\BrandsBanner;

use TecharqBlocks\Setup\AcfBlocks;

/**
 * Block attributes
 */
class BrandsBanner {

	/**
	 * Block settings
	 */
	public function __construct() {
		acf_register_block_type(
			array_merge(
				AcfBlocks::block_definitions( get_class( $this ) ),
				array(
					'title'       => __( 'Brands Banner', 'techarq-blocks' ),
					'description' => __( 'A custom Brands Banner block.', 'techarq-blocks' ),
					'category'    => 'techarq-blocks',
					'icon'        => 'images-alt2',
					'keywords'    => array( 'brands banner' ),
				)
			)
		);
	}
}
