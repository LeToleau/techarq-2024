<?php 

add_theme_support('post-thumbnails', array('post', 'page', 'proyecto') ); 

// functions.php
function cargar_estilos_y_scripts() {
    // Estilos
    wp_enqueue_style('general-styles', get_template_directory_uri() . '/assets/dist/general.min.css');    
    wp_enqueue_style('bundle-styles', get_template_directory_uri() . '/assets/dist/bundle.min.css');
  
    // Scripts
    wp_enqueue_script('general-scripts', get_template_directory_uri() . '/assets/dist/main.min.js', [], '1.0', true);
}

add_action('wp_enqueue_scripts', 'cargar_estilos_y_scripts');

// functions.php

function register_custom_menus() {
    register_nav_menus(
        array(
            'main-menu' => esc_html__('Main Menu', 'techarq'),
        )
    );
}

add_action('init', 'register_custom_menus');

// Register Custom Post Type
function create_posttype() {
  
    register_post_type( 'proyecto',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Proyectos' ),
                'singular_name' => __( 'Proyecto' )
            ),
            'public' => true,
            'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
            'has_archive' => true,
            'rewrite' => array('slug' => 'projects'),
            'show_in_rest' => true,
        )
    );

	register_post_type( 'lote',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Lotes' ),
                'singular_name' => __( 'Lote' )
            ),
            'public' => true,
            'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
            'has_archive' => true,
            'rewrite' => array('slug' => 'proyectos'),
            'show_in_rest' => true,
        )
    );
}
// Hooking up our function to theme setup
add_action( 'init', 'create_posttype' );



	/**
	 * Add ACF page options
	 */
	function optionsPage()
	{
		if (function_exists('acf_add_options_page')) {
			acf_add_options_page(array(
				'page_title' 	=> 'Opciones del Tema',
				'menu_title'	=> 'Opciones Techarq Web',
				'menu_slug' 	=> 'theme-general-settings',
				'capability'	=> 'edit_posts',
				'redirect'		=> false,
				'show_in_graphql' => true,
			));
		}
	}

    add_action('acf/init', 'optionsPage');
    
	/**
     * Add Options Sub Pages ACF
	 */
    function addOptionsSubPages()
	{
        if (function_exists('acf_add_options_page')) {
            
            //Theme Settings Header Sub Page
			acf_add_options_sub_page(array(
                'page_title' 	=> 'Header',
				'menu_title'	=> 'Header',
				'parent_slug' 	=> 'theme-general-settings',
			));
            
			//Theme Settings Footer Sub Page
			acf_add_options_sub_page(array(
                'page_title' 	=> 'Footer',
				'menu_title'	=> 'Footer',
				'parent_slug' 	=> 'theme-general-settings',
			));
            
			//Theme Settings 404 Sub Page
			acf_add_options_sub_page(array(
                'page_title' 	=> '404',
				'menu_title'	=> '404',
				'parent_slug' 	=> 'theme-general-settings',
			));
            
			//Resources CPT Archive Page
			acf_add_options_sub_page(array(
                'page_title'     => 'Resources Archive',
				'menu_title'    => 'Resources Archive',
				'parent_slug'    => 'edit.php?post_type=resources',
			));
		}
	}
    add_action('acf/init','addOptionsSubPages');

    /*
// Función para mostrar la ruta del template
function mostrar_ruta_template() {
    // Obtiene la ruta del archivo de la plantilla actual
    $template = get_page_template();
    // Muestra la ruta del archivo de la plantilla actual
    echo '<p>La plantilla actual es: ' . $template . '</p>';
}

// Añade la función al hook wp_body_open para que se muestre al principio de cada página
add_action('wp_body_open', 'mostrar_ruta_template');
?>
*/