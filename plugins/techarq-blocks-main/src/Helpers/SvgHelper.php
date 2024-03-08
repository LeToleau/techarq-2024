<?php
/**
 * This class allows you to get svg's files
 *
 * @package TecharqBlocks
 */

namespace TecharqBlocks\Helpers;

/**
 * Helper Class for including SVG into modules
 */
class SvgHelper {

	/**
	 * This functions takes the path and inserts it at the end of plugin path
	 *
	 * @param string $path Use it only as a string.
	 */
	public static function get_svg( string $path ): string {
		return file_get_contents( plugin_dir_path( __FILE__ ) . '../../' . $path );
	}
}
