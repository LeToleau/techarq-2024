<?php
/**
 * Plugin Name: Techarq Blocks
 * Description: This plugin adds new layouts and custom blocks for your Post Types. Attention: This plugin requires ACF Pro Plugin activated in your website.
 * Version: 0.5.5
 * Author: Conic Dev
 * Author URI: https://conicdev.com
 * Text Domain: techarq-blocks
 * Domain Path: /languages
 *
 * @package TecharqBlocks
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

require_once dirname( __FILE__ ) . '/vendor/autoload.php';

define( 'TECHARQBLOCKS_PLUGIN_SLUG', dirname( plugin_basename( __FILE__ ) ) );
define( 'TECHARQBLOCKS_MENU_TITLE', 'Techarq Blocks' );

/**
 * Updates
 */
// new TecharqBlocks\Admin\Updates( get_plugin_data( __FILE__ ) );

/**
 * Setup
 */
new  TecharqBlocks\Helpers\AdvancedPagination();
new TecharqBlocks\Setup\GeneralAssets( __FILE__ );
new TecharqBlocks\Setup\AcfBlocks( __FILE__ );
new TecharqBlocks\Setup\PluginDefaultTemplate();
