<?php
/**
 * Plugin Default Template
 *
 * @package TecharqBlocks
 */

namespace TecharqBlocks\Setup;

/**
 * Class Plugin Techarq Template
 *
 * This class provides methods to manage and control
 * the display of archive templates.
 *
 * @package TecharqBlocks
 */
class PluginDefaultTemplate {

	/**
	 * ArchiveTemplate constructor.
	 *
	 * Add a new selectable template to the page template dropdown.
	 */
	public function __construct() {
		add_filter( 'theme_page_templates', array( $this, 'add_archive_template_to_dropdown' ) );
		add_filter( 'template_include', array( $this, 'load_custom_archive_template' ) );
		add_filter( 'use_block_editor_for_post', array( $this, 'force_gutenberg_editor' ), 10, 2 );
	}

	/**
	 * Add a new selectable template to the page template dropdown.
	 *
	 * @param array $templates The list of page templates.
	 * @return array The modified list of page templates.
	 */
	public function add_archive_template_to_dropdown( $templates ) {
		$templates['TecharqTemplate.php'] = __( 'Techarq Main Template', 'techarq-blocks' );

		return $templates;
	}

	/**
	 * Load custom archive template.
	 *
	 * @param string $template The path of the template to include.
	 *
	 * @return string
	 */
	public function load_custom_archive_template( $template ) {
		$selected_template = get_page_template_slug();

		if ( 'TecharqTemplate.php' === $selected_template ) {
			// Path to your custom template.
			$custom_template = plugin_dir_path( __FILE__ ) . '../../templates/TecharqTemplate.php';

			// Check if the custom template file exists.
			if ( file_exists( $custom_template ) ) {
				$template = $custom_template;
			}
		}

		return $template;
	}

	/**
	 * Force Gutenberg editor.
	 *
	 * @param boolean $can_edit   Whether the post type can be edited or not.
	 * @param object  $post       The post object being edited.
	 * @return boolean
	 */
	public function force_gutenberg_editor( $can_edit, $post ) {
		if ( 'TecharqTemplate.php' === get_page_template_slug( $post ) ) {
			return true;
		}

		return $can_edit;
	}
}

new PluginDefaultTemplate();
