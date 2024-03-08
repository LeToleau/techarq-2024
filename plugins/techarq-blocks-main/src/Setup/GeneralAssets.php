<?php
/**
 * Register block templates
 *
 * @package TecharqBlocks
 */

namespace TecharqBlocks\Setup;

/**
 * Register block templates
 */
class GeneralAssets {

	/**
	 * A variable
	 *
	 * @var $file
	 */
	private $file;

	/**
	 * Construct method
	 *
	 * @param string $file is for the file url.
	 */
	public function __construct( $file ) {
		$this->file = $file;
		add_action('current_screen', array( $this, 'detecting_current_screen') );
		add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'setup_axios_vars' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'dependencies' ) );
		add_action( 'enqueue_block_editor_assets', array( $this, 'dependencies' ), 10 );
    }

	/**
	 * Get screen to validate editor and avoid unnecessary assets load.
	 */
    public function detecting_current_screen() {
        global $current_screen;
		$this->screen = $current_screen; 
    }
	
	/**
	 * Scripts method
	 */
	public function scripts() {
		if ( !is_admin() || $this->screen->is_block_editor ) { 
			wp_enqueue_style(
				'techarq-blocks-styles',
				plugins_url( '/assets/build/index_techarq_posts.min.css', $this->file ),
				null,
				filemtime( plugin_dir_path( $this->file ) . '/assets/build/index_techarq_posts.min.css' )
			);

			wp_enqueue_script(
				'techarq-blocks-scripts',
				plugins_url( '/assets/build/index_techarq_posts.min.js', $this->file ),
				null,
				filemtime( plugin_dir_path( $this->file ) . 'assets/build/index_techarq_posts.min.js' )
			);

			wp_enqueue_script(
				'techarq-blocks-scroll-control',
				plugins_url( '/assets/js/utilities/scrollControl.js', $this->file ),
				null,
				filemtime( plugin_dir_path( $this->file ) . 'assets/js/utilities/scrollControl.js' )
			);
		}
	}

	public function dependencies() {

		wp_register_style(
			'techarq-dependencies',
			plugins_url( '/assets/build/techarq_dependencies.min.css', $this->file ),
			null,
			filemtime( plugin_dir_path( $this->file ) . 'assets/build/techarq_dependencies.min.css' )
		);

		wp_enqueue_style(
			'techarq-dependencies',
			plugins_url( '/assets/build/techarq_dependencies.min.css', $this->file ),
			null,
			filemtime( plugin_dir_path( $this->file ) . '/assets/build/techarq_dependencies.min.css' )
		);

		wp_register_script('lottie', 'https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.5.0/lottie.js', array('jquery'), null, true);

	}

	public function setup_axios_vars() {

		wp_localize_script(
			'techarq-blocks-scripts',
			'techarqBoilerplate',
			array(
				'rootapiurl' => esc_url_raw( rest_url() ),
				'nonce'      => wp_create_nonce( 'wp_rest' ),
			)
		);
	
		wp_localize_script(
			'techarq-blocks-scripts',
			'ajax',
			array(
				'url' => admin_url( 'admin-ajax.php' ),
			)
		);
	}
}
