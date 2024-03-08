<?php
/**
 * This file adds support for updates
 *
 * @package TecharqBlocks
 */

namespace TecharqBlocks\Admin;

require_once ABSPATH . 'wp-admin/includes/plugin.php';

/**
 * Updates class.
 */
class Updates {

	/**
	 * Endpoint to get the new version
	 *
	 * @var string $endpoint path to download plugin
	 */
	public $endpoint;

	/**
	 * Transient name
	 *
	 * @var string $transient_name transient name
	 */
	public $transient_name;

	/**
	 * Endpoint to get the new version
	 *
	 * @var int $transient_expiration transient time exp
	 */
	public $transient_expiration;

	/**
	 * Plugin info
	 *
	 * @var array $current_plugin_data plugin info array
	 */
	public $current_plugin_data = array();

	/**
	 * Cache allowed
	 *
	 * @var bool $cache_allowed cache allowed
	 */
	public $cache_allowed = false;

	/**
	 * Plugin Slug
	 *
	 * @var string $plugin_slug plugin slug
	 */
	public $plugin_slug;

	/**
	 * Constructor class
	 *
	 * @param array $current_plugin_data plugin array data.
	 */
	public function __construct( $current_plugin_data ) {
		$this->plugin_slug          = TECHARQBLOCKS_PLUGIN_SLUG;
		$this->transient_name       = 'wp_update_' . $this->plugin_slug;
		$this->transient_expiration = 165; // 2 minutes 45 seconds.
		$this->current_plugin_data  = $current_plugin_data;
		$this->cache_allowed        = false;
		$this->endpoint             = 'https://conicdev.com/wp-json/wcpu/v1/verify-plugin';
		add_action( 'admin_head', array( $this, 'print_inline_css' ) );
		add_action( 'admin_footer', array( $this, 'print_inline_js' ) );
		add_filter( 'site_transient_update_plugins', array( $this, 'update' ) );
		add_action( 'upgrader_process_complete', array( $this, 'purge' ), 10, 2 );
		if ( is_multisite() ) {
			add_action( 'network_admin_menu', array( $this, 'plugin_key_menu_multisite' ) ); // Add our custom submenu.
		} else {
			add_action( 'admin_menu', array( $this, 'plugin_key_menu' ) ); // Add our custom submenu.
		}
		add_action( 'admin_init', array( $this, 'settings_init' ) );
	}

	/**
	 * Settings_init
	 *
	 * @return void
	 */
	public function settings_init() {
		// Register the setting for our configuration array.
		register_setting( $this->plugin_slug, $this->plugin_slug );

		// Register a new section in the settings page.
		add_settings_section(
			$this->plugin_slug . '_section_developers',
			__( 'Setup key.', 'techarq-blocks' ),
			array( $this, 'wcpu_section_developers_callback' ),
			$this->plugin_slug
		);

		// Register a new field in the "wcpu_section_developers" section, inside the settings page.
		add_settings_field(
			$this->plugin_slug . '-field_pill', // As of WP 4.6 this value is used only internally.
			__( 'Key', 'techarq-blocks' ),
			array( $this, 'wcpu_field_pill_callback' ),
			$this->plugin_slug,
			$this->plugin_slug . '_section_developers',
			array(
				'label_for'                         => $this->plugin_slug . '-field_pill',
				'class'                             => $this->plugin_slug . '_row',
				$this->plugin_slug . '_custom_data' => 'custom',
			)
		);
	}

	/**
	 * Wcpu_section_developers_callback
	 *
	 * @param  mixed $args arguments.
	 * @return void
	 */
	public function wcpu_section_developers_callback( $args ) {
		echo '<p id="' . esc_attr( $args['id'] ) . ' "> ' . esc_html_e( 'Insert the key that we provided to allow plugin updates.', 'techarq-blocks' ) . '</p>';
	}

	/**
	 * Wcpu_field_pill_callback
	 *
	 * @param  mixed $args arguments.
	 * @return void
	 */
	public function wcpu_field_pill_callback( $args ) { // phpcs:ignore
		// Check if it's a multisite and retrieve the setting accordingly.
		$options  = is_multisite() ? get_site_option( $this->plugin_slug ) : get_option( $this->plugin_slug );

		$value = ( $options && isset( $options['key'] ) ) ? esc_attr( $options['key'] ) : '';
		$html  = "<div class='wcpu__license js-$this->plugin_slug-plugin-key-wrapper'>
                  <input class='js-$this->plugin_slug-plugin-key' type='password' id='$this->plugin_slug-field_pill' name='$this->plugin_slug[key]' value='$value'>
                  <span class='js-$this->plugin_slug-plugin-key-status'></span>
                </div>";

		echo wp_kses(
			$html,
			array(
				'div'   => array(
					'class' => array(),
				),
				'input' => array(
					'class' => array(),
					'type'  => array(),
					'id'    => array(),
					'name'  => array(),
					'value' => array(),
				),
				'span'  => array(
					'class' => array(),
				),
			)
		);
	}

	/**
	 * Add menu
	 *
	 * @return void
	 */
	public function plugin_key_menu() {
		global $submenu;

		if ( isset( $submenu[ $this->plugin_slug ] ) ) {
			// The plugin's menu exists, add a new submenu to it.
			add_submenu_page( $this->plugin_slug, 'License', 'License', 'manage_options', $this->plugin_slug . '-user-key', array( $this, 'wcpu_menu_page' ) );
		} else {
			// The plugin's menu doesn't exist, create a new menu and submenu.
			// Add the main menu.
			add_menu_page( TECHARQBLOCKS_MENU_TITLE, TECHARQBLOCKS_MENU_TITLE, 'manage_options', $this->plugin_slug, array( $this, 'wcpu_menu_page' ) );

			// Add the "License" submenu.
			add_submenu_page( $this->plugin_slug, 'License', 'License', 'manage_options', $this->plugin_slug . '-user-key', array( $this, 'wcpu_menu_page' ) );

			// Remove the default submenu that WordPress creates.
			remove_submenu_page( $this->plugin_slug, $this->plugin_slug );
		}
	}

	/**
	 * Add menu to multisite network.
	 *
	 * @return void
	 */
	public function plugin_key_menu_multisite() {
		// Add the main menu.
		add_menu_page( TECHARQBLOCKS_MENU_TITLE, TECHARQBLOCKS_MENU_TITLE, 'manage_options', $this->plugin_slug, array( $this, 'wcpu_menu_page' ) );

		// Add the "License" submenu.
		add_submenu_page( $this->plugin_slug, 'License', 'License', 'manage_options', $this->plugin_slug . '-user-key', array( $this, 'wcpu_menu_page' ) );

		// Remove the default submenu that WordPress creates.
		remove_submenu_page( $this->plugin_slug, $this->plugin_slug );
	}

	/**
	 * Display menu page
	 *
	 * @return void
	 */
	/**
	 * Display menu page
	 *
	 * @return void
	 */
	public function wcpu_menu_page() {
		$option       = $this->plugin_slug;
		$button_class = "js-$option-save-license";
    $action_url = '';

		if ( is_multisite() ) {
			// Check for form submission in multisite.
			if ( isset( $_SERVER['REQUEST_METHOD'] ) && 'POST' === $_SERVER['REQUEST_METHOD'] ) {
				check_admin_referer( $option . '-options' );

				if ( isset( $_POST[ $option ] ) ) {
					$sanitized_data = array_map( 'sanitize_text_field', wp_unslash( $_POST[ $option ] ) );

					update_site_option( $option, $sanitized_data );
					add_settings_error( $option . '-notices', '', __( 'Settings Saved', 'techarq-blocks' ), 'updated' );
				}
				$action_url = 'admin.php?page=' . $this->plugin_slug . '-user-key';
			}
		} else {
			$action_url = 'options.php';
		}
		?>
	<div class="wrap">
		<?php settings_errors(); ?>
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form action="<?php echo esc_url( $action_url ); ?>" method="post">
			<?php
			if ( is_multisite() ) {
				wp_nonce_field( $option . '-options' );
			} else {
				// Output security fields for the registered setting.
				settings_fields( $option );
			}
			// Output setting sections and their fields.
			do_settings_sections( $option );
			// Output save settings button.
			echo '<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary ' . esc_attr( $button_class ) . '" value="' . esc_attr__( 'Save Settings', 'techarq-blocks' ) . '"></p>';
			?>
		</form>
	</div>
		<?php
	}


	/**
	 * Check if it's a new version available
	 *
	 * @return bool/object
	 * @throws \Exception If the response is not valid.
	 */
	public function fetch_remote_data() {
		$options  = is_multisite() ? get_site_option( $this->plugin_slug ) : get_option( $this->plugin_slug );
		$user_key = isset( $options['key'] ) ? $options['key'] : '';

		$remote = get_transient( $this->transient_name );

		if ( false === $remote || ! $this->cache_allowed ) {

			try {
				$response = wp_remote_get(
					add_query_arg(
						array(
							'plugin' => $this->plugin_slug,
							'latest' => defined( 'WC_PLUGIN_FACTORY_DEVELOPMENT' ) && ! empty( WC_PLUGIN_FACTORY_DEVELOPMENT ) ? WC_PLUGIN_FACTORY_DEVELOPMENT : false,
							'key'    => $user_key,
						),
						$this->endpoint
					),
					array(
						'sslverify' => false, // for dev purposes only. Remove in prod.
					)
				);

				if ( is_wp_error( $response ) ) {
						throw new \Exception( $response->get_error_message() );
				}

				$remote_data = json_decode( wp_remote_retrieve_body( $response ), true );

				return (object) array(
					'id'            => $this->plugin_slug . '/' . $this->plugin_slug . '.php',
					'slug'          => $this->plugin_slug,
					'plugin'        => $this->plugin_slug . '/' . $this->plugin_slug . '.php',
					'new_version'   => isset( $remote_data['version'] ) ? $remote_data['version'] : '',  // <-- Important!
					'url'           => 'https://conicdev.com',
					'package'       => isset( $remote_data['package'] ) ? $remote_data['package'] : '',  // <-- Important!
					'icons'         => array(),
					'banners'       => array(),
					'banners_rtl'   => array(),
					'tested'        => '',
					'requires_php'  => '',
					'compatibility' => new \stdClass(),
				);

			} catch ( \Exception $e ) {
				return false;
			}
		}

		return false;
	}

	/**
	 * Check if the transient exists to run an update
	 *
	 * @param  bool/object $transient transient data.
	 * @return bool/object
	 */
	public function update( $transient ) {

		if ( empty( $transient->checked ) ) {
			return $transient;
		}

		$check_plugin_transient = get_transient( $this->transient_name );
		$plugin_data            = $check_plugin_transient ? $check_plugin_transient : $this->fetch_remote_data();
		$current_plugin_data    = $this->current_plugin_data;

		if ( ! $check_plugin_transient ) {
			set_transient(
				$this->transient_name,
				$plugin_data,
				$this->transient_expiration
			);
		}

		if ( is_object( $plugin_data ) ) {
			if ( version_compare( $plugin_data->new_version, $current_plugin_data['Version'], '>' ) ) {
				$transient->response[ $this->plugin_slug . '/' . $this->plugin_slug . '.php' ] = $plugin_data;
			} else {
				$transient->no_update[ $this->plugin_slug . '/' . $this->plugin_slug . '.php' ] = $plugin_data;
			}
		}

		return $transient;
	}

	/**
	 * Clean transient
	 *
	 * @param array $upgrader upgrader info.
	 * @param array $options  options of action.
	 */
	public function purge( $upgrader, $options ) { // phpcs:ignore

		if ( $this->cache_allowed
			&& 'update' === $options['action']
			&& 'plugin' === $options['type']
		) {
			// Just clean the cache when new plugin version is installed.
			delete_transient( $this->transient_name );
		}
	}

	/**
	 * Print_inline_js
	 *
	 * @return void
	 */
	public function print_inline_js() {
		// Print the wcpb object.
		echo '<script>
              var wcpb = {
                  rootapiurl: "' . esc_url_raw( rest_url() ) . '",
                  nonce: "' . esc_js( wp_create_nonce( 'wp_rest' ) ) . '",
                  plugin_slug: "' . esc_js( $this->plugin_slug ) . '"
              };
          </script>';

		// JS Code.
		echo '<script>
            (()=>{"use strict";new class{constructor(){this.pluginSlug=wcpb.plugin_slug,this.licenseStatus=document.querySelector(`.js-${this.pluginSlug}-plugin-key-status`),this.licenseStatus&&(this.inputFieldClass=`js-${this.pluginSlug}-plugin-key`,this.inputField=document.querySelector(`.${this.inputFieldClass}`),this.inputField&&(this.endpointURL="https://conicdev.com/wp-json/wcpu/v1/validate_key",this.successIconClass=["dashicons","dashicons-saved","success"],this.errorIconClass=["dashicons","dashicons-no","error"],this.inputField.value.length>0&&this.handleKeyUp(),this.inputField.addEventListener("keyup",this.debounce(this.handleKeyUp.bind(this),500))))}debounce(s,t){let e;return(...i)=>{clearTimeout(e),e=setTimeout((()=>s(...i)),t)}}async handleKeyUp(){this.licenseStatus.className=`js-${this.pluginSlug}-plugin-key-status loader`;try{(await fetch(`${this.endpointURL}?key=${encodeURIComponent(this.inputField.value)}&plugin=${encodeURIComponent(this.pluginSlug)}`)).ok?(this.licenseStatus.classList.remove("loader"),this.licenseStatus.classList.add(...this.successIconClass)):(this.licenseStatus.classList.remove("loader"),this.licenseStatus.classList.add(...this.errorIconClass))}catch(s){this.licenseStatus.classList.remove("loader"),this.licenseStatus.classList.add(...this.errorIconClass)}}}})();
        </script>';
	}

	/**
	 * Print_inline_js
	 *
	 * @return void
	 */
	public function print_inline_css() {
		// CSS Code.
		echo '<style>
              .wcpu__license{align-items:center;display:flex;gap:10px}.wcpu__license input{width:fit-content!important}.wcpu__license span{font-size:28px;height:28px;width:28px}.wcpu__license .loader{animation:rotate 1s linear infinite;border-radius:50%;height:28px;position:relative;width:28px}.wcpu__license .loader:before{animation:loader-animation 2s linear infinite;border:3px solid #198754;border-radius:50%;box-sizing:border-box;content:"";inset:0;position:absolute}.wcpu__license .success{color:#198754}.wcpu__license .error{color:#dc3545}@keyframes rotate{to{transform:rotate(1turn)}}@keyframes loader-animation{0%{clip-path:polygon(50% 50%,0 0,0 0,0 0,0 0,0 0)}25%{clip-path:polygon(50% 50%,0 0,100% 0,100% 0,100% 0,100% 0)}50%{clip-path:polygon(50% 50%,0 0,100% 0,100% 100%,100% 100%,100% 100%)}75%{clip-path:polygon(50% 50%,0 0,100% 0,100% 100%,0 100%,0 100%)}to{clip-path:polygon(50% 50%,0 0,100% 0,100% 100%,0 100%,0 0)}}
          </style>';
	}
}
