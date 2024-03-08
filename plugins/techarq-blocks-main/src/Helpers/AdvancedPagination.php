<?php
/**
 * Advanced Pagination
 *
 * @package Techarq
 */

namespace TecharqBlocks\Helpers;

/**
 * This class add a brand new paginator with extra features
 */
class AdvancedPagination {
	/**
	 * Registers an endpoint
	 */
	public function __construct() {
		add_action( 'rest_api_init', array( $this, 'register_endpoint' ) );
	}
	/**
	 * Creates an endpoint
	 */
	public function register_endpoint() {
		register_rest_route(
			'post-powers/v1',
			'paged-posts',
			array(
				'methods'             => \WP_REST_SERVER::READABLE,
				'callback'            => array( $this, 'response_endpoint' ),
				'permission_callback' => '__return_true',
			)
		);
	}
	/**
	 * Gets triggered when a get request is made to 'post-powers/v1'
	 *
	 * @param array $data The data sent by the client.
	 * @return array $responseArray containing posts, status, etc.
	 */
	public function response_endpoint( $data ) {
		// Get parameters.
		$post_type                = $data['post_type']; // Post type.
		$page                     = $data['page'];
		$posts_per_page           = intval( $data['posts_per_page'] );
		$component                = $data['component'];
		$component_parent         = $data['component_parent'];
		$paged                    = get_query_var( 'paged', $page );
		$filters_settings         = $data['filters'];
		$search                   = $data['search'];
		$controller_next          = $data['next_controller_button'];
		$controller_prev          = $data['prev_controller_button'];
		$controller_limit_numbers = $data['controller_limit_button'];
		$no_results_message       = $data['no_results_message'];

		// Filters.
		$filters = array( 'relation' => 'AND' );
		foreach ( $filters_settings as $filter ) {
			$decoded_filter = json_decode( $filter, true );
			if ( 'all' !== $decoded_filter['term'] ) {
				$taxonomy = array(
					'taxonomy' => $decoded_filter['taxonomy'],
					'field'    => 'slug',
					'terms'    => array( $decoded_filter['term'] ),
				);
				array_push( $filters, $taxonomy );
			}
		}

		// WP Query.
		$args       = array(
			'post_type'      => $post_type,
			'posts_per_page' => $posts_per_page,
			'post_status'    => 'publish',
			'paged'          => $paged,
			'order'          => 'DESC',
			'tax_query'      => $filters,
			's'              => $search,
		);
		$full_posts = new \WP_Query( $args );

		// Pagination controllers changes on filter or search.
		$pages = $full_posts->max_num_pages;
		if ( $pages > 1 ) {
			$buttons_pages = '';
			for ( $i = 1; $i <= $pages; $i++ ) {
				if ( intval( $page ) === $i ) {
					$buttons_pages .= "<button class='js-page page active' page='$i'>$i</button>";
				} else {
					$buttons_pages .= "<button class='js-page page' page='$i'>$i</button>";
				}
			}

			$controller = $full_posts->max_num_pages <= 1 ? '' : "<button class='js-back prev-page disabled'>$controller_prev</button>
                <div class='c-pagination__pages js-pages' limit='$controller_limit_numbers'>$buttons_pages</div>
                <button class='js-next next-page'>$controller_next</button>";
		} else {
			$controller = false;
		}

		// Parse php posts into txt.
		$posts_txt = array();
		$post_data = '';
		while ( $full_posts->have_posts() ) {
			$full_posts->the_post();
			ob_start();
			set_query_var( 'newpost', get_post() );
            // var_dump(get_template_part( 'src/blocks/' . $component_parent . '/' . $component_parent, $component ));
			require( WP_PLUGIN_DIR . '/techarq-blocks-main/src/Blocks/' . $component_parent . '/' . $component_parent . '-' . $component . '.php');
			$post_data .= ob_get_contents();
			ob_end_clean();
		}
		wp_reset_postdata();
		array_push( $posts_txt, $post_data );

		if ( '' !== $posts_txt[0] ) {
			return array(
				'status'       => true,
				'posts'        => $posts_txt[0],
				'pages'        => $full_posts->max_num_pages,
				'current_page' => intval( $page ),
				'filters'      => $filters,
				'controllers'  => $controller,
				'total_posts'  => $full_posts->found_post,
			);
		} else {
			return array(
				'status'      => false,
				'message'     => $no_results_message,
				'total_posts' => $full_posts->found_post,
			);
		}
	}

	/**
	 * AdvancedPagination::print(array $args)
	 *
	 * Prints the skeleton tags of the advanced pagination module.
	 *
	 * @param array $opt args to use.
	 *
	 * $args:
	 * - post_type: Post type register name (post by default)[string].
	 * - posts_per_page: Number of posts on a page (4 by default)[integer].
	 * - component: Template Part to use located in template-parts/components (post by default)[string].
	 * - component_parent: Parent folder of the component (searchbar by default)[string].
	 * - no_results_message: If there is no matched posts a message will be shown ('Nothing Found...' by default)[string].
	 * - next_button: Content of a next page button ('Next >' by default)[img, svg or string].
	 * - prev_button: Content of a prev page button ('Prev >' by default)[img, svg or string].
	 * - loader_color: Hexadecimal color of a loader spinner ('#444' by default)[string].
	 * - numbers_limit: Limit of page buttons shown (3 by default)[integer].
	 * - search: Allow search feature (false by default)[boolean].
	 * - search_opt: Set search box content [array].
	 *      - placeholder: Input placeholder ('Search...' by default)[string].
	 *      - append: Add something at the end ('' by default)[img, svg or string].
	 * - filters: Taxonomies filters feature (false by default)[boolean or array].
	 *      - filters: false --> Disable filter by taxonomy feature.
	 *      - filters: true --> All taxonomies related to current Post Type.
	 *      - filters: array('category', 'post_tag') --> Set manual taxonomy filters related to the current post type.
	 * - filters_opt: Set filter box content [array]:
	 *      - prepend: Add content before selected filter ('Sort by ' by default)[string, img or svg]
	 *      - append: Add content before selected filter (' v' by default)[string, img or svg]
	 *      - title: Show taxonomy title (false by default)[boolean].
	 */
	public static function print( $opt = array() ) {
		$opt += array(
			'post_type'          => 'post',
			'posts_per_page'     => 4,
			'component'          => 'post',
			'component_parent'   => 'searchbar',
			'no_results_message' => __( 'Nothing Found...', 'techarq-blocks' ),
			'next_button'        => 'Next',
			'prev_button'        => 'Prev',
			'loader_color'       => '#444',
			'numbers_limit'      => 3,
			'search'             => false,
			'search_opt'         => array(
				'placeholder' => __( 'Search...', 'techarq-blocks' ),
				'append'      => '',
			),
			'filters'            => false,
			'filters_opt'        => array(
				'prepend' => 'Sort by ',
				'append'  => '  v',
				'title'   => false,
			),
		);

		$post_type          = $opt['post_type'];
		$component          = $opt['component']; // template part from template-parts/component/component-$component.
		$component_parent   = $opt['component_parent'];
		$next_btn           = $opt['next_button'];
		$prev_btn           = $opt['prev_button'];
		$current_page       = isset( $_GET['page'] ) ? intval( $_GET['page'] ) : 1;
		$loader_color       = $opt['loader_color'];
		$numbers_limit      = $opt['numbers_limit'];
		$posts_per_page     = $opt['posts_per_page'];
		$no_results_message = $opt['no_results_message'];

		// HTTP filters.
		$taxonomies  = get_object_taxonomies( $post_type, 'names' );
		$tax_filters = array( 'relation' => 'AND' );
		// Taxonomy term already sanitized.
		// @codingStandardsIgnoreStart
		foreach ( $taxonomies as $taxonomy ) {
			if ( isset( $_GET[ $taxonomy ] ) ) {
				if( 'all' !== $_GET[ $taxonomy ]){
					$taxonomy = array(
						'taxonomy' => $taxonomy,
						'field'    => 'slug',
						'terms'    => $_GET[ $taxonomy ],
					);
					array_push( $tax_filters, $taxonomy );
				}
			}
		}
		// @codingStandardsIgnoreEnd

		// Search.
		if ( isset( $_GET['search'] ) ) {
			$search_query = filter_input( INPUT_GET, 'search', FILTER_SANITIZE_URL );
		} elseif ( isset( $_GET['s'] ) ) {
			$search_query = filter_input( INPUT_GET, 's', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
		} else {
			$search_query = '';
		}

		// WP Query.
		$args  = array(
			'post_type'      => $post_type,
			'posts_per_page' => $posts_per_page,
			'post_status'    => 'publish',
			'paged'          => $current_page,
			'tax_query'      => $tax_filters,
			's'              => $search_query,
		);
		$posts = new \WP_Query( $args );

		// First posts.
		$posts_data = '';

		if ( $posts->have_posts() ) {
           // var_dump($component_parent . '/' . $component_parent);
            // var_dump(require( WP_PLUGIN_DIR . '/techarq-blocks-main/src/Blocks/' . $component_parent . '/' . $component_parent . '-' . $component . '.php'));
            //var_dump(require( WP_PLUGIN_DIR . '/techarq-blocks-main/src/Blocks/' . $component_parent . '/' . $component_parent . '-' . $component . '.php'));
            while ( $posts->have_posts() ) {
                $posts->the_post();
				ob_start();
				require( WP_PLUGIN_DIR . '/techarq-blocks-main/src/Blocks/' . $component_parent . '/' . $component_parent . '-' . $component . '.php');
				$posts_data .= ob_get_contents();
				ob_end_clean();
			}
			wp_reset_postdata();
		} else {
			$posts_data = $opt['no_results_message'];
		}

		// Buttons for pages.
		$pages         = $posts->max_num_pages;
		$buttons_pages = '';
		for ( $i = 1; $i <= $pages; $i++ ) {
			if ( $i === $current_page ) {
				$buttons_pages .= "<button class='js-page page active' page='$i'>$i</button>";
			} else {
				$buttons_pages .= "<button class='js-page page' page='$i'>$i</button>";
			}
		}

		// Search.
		$input_placeholder    = $opt['search_opt']['placeholder'];
		$input_append_element = $opt['search_opt']['append'];
		$search               = ! $opt['search'] ? '' : "<div class='c-pagination__search'>
        <input class='js-search-posts' type='text' placeholder='$input_placeholder' value='$search_query'>
        $input_append_element
        </div>";

		// Filters.
		if ( gettype( $opt['filters'] ) === 'boolean' && $opt['filters'] ) {
			$opt['filters'] = get_object_taxonomies( $post_type, 'names' );
		}
		$filters = "<div class='c-pagination__filters'>";
		if ( $opt['filters'] ) {
			foreach ( $opt['filters'] as $filter ) {
				if ( 'post_format' !== $filter ) {

					$terms = get_terms(
						array(
							'taxonomy'   => $filter,
							'hide_empty' => false,
						)
					);

					$filter_options = "<li class='c-pagination__filter-option js-taxonomy-option' taxonomy='$filter' term='all'>All</li>";
					foreach ( $terms as $term ) {
						$term_slug       = $term->slug;
						$term_name       = $term->name;
						$filter_options .= "<li class='c-pagination__filter-option js-taxonomy-option' taxonomy='$filter' term='$term_slug'>$term_name</li>";
					}

					$filter_prepend = $opt['filters_opt']['prepend'] ? "<span class='c-pagination__filter-prepend'>" . $opt['filters_opt']['prepend'] . '</span>' : '';
					$filter_append  = $opt['filters_opt']['append'] ? "<span class='c-pagination__filter-append'>" . $opt['filters_opt']['append'] . '</span>' : '';
					$filter_title   = $opt['filters_opt']['title'] ? "<span class='c-pagination__filter-title'>" . get_taxonomy( $filter )->label . '</span>' : '';

					if ( isset( $_GET[ $filter ] ) ) {
						$current_term = filter_input( INPUT_GET, $filter, FILTER_SANITIZE_URL );
					} else {
						$current_term = __( 'All', 'techarq-blocks' );
					}
					$filter_box = "<div class='c-pagination__filter js-posts-taxonomy' taxonomy='$filter'>
                    $filter_title
                    <div class='c-pagination__filter-current js-current-taxonomy'>$filter_prepend<span class='js-current-taxname'></span>$filter_append</div>
                    <ul class='c-pagination__filter-options hidden-filters js-taxonomies-options'>
                    $filter_options
                    </ul>
                    </div>";

					$filters .= $filter_box;
				}
			}
		}
		$filters .= '</div>';

		// Controllers.
		$controller = $posts->max_num_pages <= 1 ? '' : "<div class='c-pagination__controllers js-pagination-controllers'>
        <button class='js-back prev-page disabled'>" . $prev_btn . "</button>
        <div class='c-pagination__pages js-pages' limit='$numbers_limit'>$buttons_pages</div>
        <button class='js-next next-page'>" . $next_btn . '</button>
        </div>';

		// Print pagination ajax.
		// @codingStandardsIgnoreStart
		echo "<div class='c-pagination js-post-pagination' post_type='" . $post_type . "' prev='" . $prev_btn . "' next='" . $next_btn . "' limit='" . $numbers_limit . "' no_results_message='$no_results_message'>
        $filters
        $search
        <div class='c-pagination__container js-posts' posts_per_page=" . $posts_per_page . " page=" . $current_page . " pages=" . $pages . " component_parent=" . $component_parent . " component=" . $component . " loader_color=" . $loader_color . ">
            $posts_data
        </div>
        $controller
        </div>";
		// @codingStandardsIgnoreEnd
	}
}
