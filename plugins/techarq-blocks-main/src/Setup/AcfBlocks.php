<?php
/**
 * Acf Blocks Factory
 *
 * @package TecharqBlocks
 */

namespace TecharqBlocks\Setup;

/**
 * This class performs a Block factory using ACF Blocks Framework
 */
class AcfBlocks {

	/**
	 * A variable
	 *
	 * @var $file
	 */
	private $file;

	/**
	 * Blocks actions and filters
	 *
	 * @param string $file is used for a file.
	 */
	public function __construct( $file ) {
		$this->file = $file;
		add_action( 'acf/init', array( $this, 'register_blocks' ) );
		add_action( 'block_categories_all', array( $this, 'register_block_categories' ), 10, 2 );
		add_filter( 'acf/settings/load_json', array( $this, 'load_acf_jsons_from_plugin' ) );
		add_filter( 'acf/fields/wysiwyg/toolbars', array( $this, 'wysiwyg_tool_bars' ) );
	}

	/**
	 * Hide default blocks and show only ACF blocks
	 * https://rudrastyh.com/gutenberg/remove-default-blocks.html#block_slugs
	 */
	public function allowed_blocks_types() {
		return $this->allowed_blocks;
	}

	/**
	 * Register Blocks
	 */
	public function register_blocks() {
		// Check function exists.
		if ( function_exists( 'acf_register_block_type' ) ) {
			$blocks = array_diff( scandir( plugin_dir_path( $this->file ) . 'src/Blocks', 1 ), array( '..', '.' ) );

			foreach ( $blocks as $block ) {
				if($block != '.DS_Store'){
					$class = "TecharqBlocks\Blocks\\$block\\$block";
					new $class();
					$sanitized_name = strtolower( preg_replace( '/([a-z])([A-Z])/', '$1-$2', $block ) );
				}
			}
		}
	}
	/**
	 * Custom Wysiwyg ToolBars
	 *
	 * @param array $toolbars array of wysiwyg toolbars.
	 */
	public function wysiwyg_tool_bars( $toolbars ) {
		// Example only bold toolbar.
		$toolbars['Partial'][1]        = array( 'bold', 'italic', 'bullist', 'numlist', 'blockquote' ,'alignleft', 'aligncenter', 'alignright', 'link');
		$toolbars['Tracking'][1]        = array( 'bold', 'italic', 'bullist', 'numlist', 'blockquote' ,'alignleft', 'aligncenter', 'alignright', 'link', 'EnlighterInsert', 'EnlighterEdit');

		return $toolbars;

		
	}

	/**
	 * Block Auto Definitions
	 * - Scripts
	 * - Backend Name
	 * - Render Template
	 * - Block Preview
	 *
	 * @param string $class block class name.
	 * @param array  $dependencies style/scripts dependencies used by your block.
	 * @param bool   $disable_preview disable the preview mode.
	 * @param bool   $turn_on_edit_mode switch gutenberg mode for acf mode.
	 */
	public static function block_definitions( $class, $dependencies = null, $disable_preview = false, $turn_on_edit_mode = false ) {
		$class            = ( new \ReflectionClass( $class ) )->getShortName();
		$plugin_main_file = explode( '\\src\\', __FILE__ )[0] . '/techarq-blocks.php';

		$sanitized_name = strtolower( preg_replace( '/([a-z])([A-Z])/', '$1-$2', $class ) );

		return array(
			'name'            => strtolower( $sanitized_name ),
			'render_callback' => function () use ( $sanitized_name, $class, $disable_preview, $plugin_main_file ) {
				// Disable Interactive Preview.
				if ( ! is_admin() ) {
					// Allow interactive mode on frontend.
					$disable_preview = false;
				}
				$disable_preview_class = $disable_preview ? 'block--disable-preview' : '';
				$is_preview_bar_example = get_field( 'is_example' );
				$preview_bar_example_class = $is_preview_bar_example ? 'block--clear-preview' : '';

				// Block ID.
				$anchor = get_sub_field( 'anchor' );

				// get spacing values.
				$padding_top = get_field( 'padding_top' );
				$padding_bottom = get_field( 'padding_bottom' );

				// set css classes for spacing
				$classes = array();
				if ( $padding_top ) {
					$classes[] = "padding-top--{$padding_top}";
				}
				if ( $padding_bottom ) {
					$classes[] = "padding-bottom--{$padding_bottom}";
				}
				$classes = implode( ' ', $classes );

				// set class for background color
				if ( $sanitized_name === 'about-us' || $sanitized_name === 'about-services' || $sanitized_name === 'api' || $sanitized_name === 'features' ) {
					$use_bgd_color = 'bgd-color';
				} else {
					$use_bgd_color = '';
				}

				echo wp_kses_post( "<section id='$anchor' class='block js-$sanitized_name $disable_preview_class $preview_bar_example_class $classes $use_bgd_color'>" );
				if ( $is_preview_bar_example || $disable_preview ) :
					echo wp_kses_post( '<img style="max-width: 100%; margin: 0 auto; display: block;" src="' . plugin_dir_url( __FILE__ ) . "../Blocks/$class/$class.png" . '" alt="preview image">' );
				else :
					include plugin_dir_path( $plugin_main_file ) . "/src/Blocks/$class/Template.php";
				endif;
				echo '</section>';
			},
			'enqueue_assets'  => function () use ( $class, $dependencies, $plugin_main_file ) {
				// Block Styles.
				$style_deps = array();
				if ( $dependencies ) {
					foreach ( $dependencies as $dependency ) {
						if ( wp_style_is( $dependency, 'registered' ) ) {
							array_push( $style_deps, $dependency );
						}
					}
				} else {
					$style_deps = null;
				}

				$build_files_path = '/assets/build/';

				$absolute_path = array(
					'js'  => plugin_dir_path( $plugin_main_file ) . $build_files_path . $class . '.min.js',
					'css' => plugin_dir_path( $plugin_main_file ) . $build_files_path . $class . '.min.css',
				);

				// Block Styles.
				wp_register_style( 'block-' . strtolower( $class ), plugins_url( 'assets/build/' . $class . '.min.css', $plugin_main_file ), $style_deps, filemtime( $absolute_path['css'] ) );
				wp_enqueue_style( 'block-' . strtolower( $class ) );

				// Block Scripts.
				wp_register_script( 'block-' . strtolower( $class ), plugins_url( 'assets/build/' . $class . '.min.js', $plugin_main_file ), '', filemtime( $absolute_path['js'] ), true );
				wp_enqueue_script( 'block-' . strtolower( $class ) );
			},
			'example'         => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'is_example' => true,
					),
				),
			),
			'supports'        => array(
				'jsx' => true,
			),
			'mode'            => $turn_on_edit_mode ? 'edit' : 'preview',
		);
	}

	/**
	 * Register custom blocks categories
	 * https://developer.wordpress.org/block-editor/reference-guides/filters/block-filters/#managing-block-categories
	 *
	 * @param array $categories array of categories.
	 */
	public function register_block_categories( $categories ) {
		return array_merge(
			$categories,
			array(
				array(
					'slug'  => 'techarq-blocks',
					'title' => __( 'Techarq Custom Blocks', 'techarq-blocks' ),
				),

			)
		);
	}

	/**
	 * Load jsons from plugin directory
	 *
	 *  @param string $paths is for the path.
	 */
	public function load_acf_jsons_from_plugin( $paths ) {
		$paths[] = plugin_dir_path( $this->file ) . 'acf-json';

		return $paths;

	}
}
