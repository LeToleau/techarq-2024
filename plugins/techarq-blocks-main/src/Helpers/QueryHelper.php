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
class QueryHelper {

	/**
	 * This functions gets the value of a Taxonomy ACF and returns a 'tax_query' array to use in a query
	 *
	 * @param number $id The post ID.
     * @param array $taxonomy The taxonomy ACF related to the module.
	 */
    public static function techarqblocks_create_tax_query( $id, $taxonomy = array() ) {
        $techarqblocks_query_terms = array(
            'relation' => 'AND',
        );

        foreach ( $taxonomy as $techarqblocks_taxonomy ) {
            $techarqblocks_post_terms  = wp_get_post_terms( $id, $techarqblocks_taxonomy );
            $techarqblocks_terms_query = array();

            foreach ( $techarqblocks_post_terms as $techarqblocks_query_term ) {
                null !== $techarqblocks_query_term->slug ? array_push( $techarqblocks_terms_query, $techarqblocks_query_term->slug ) : '';
            }

            if ( $techarqblocks_terms_query ) {
                $techarqblocks_tax = array(
                    'taxonomy' => $techarqblocks_taxonomy,
                    'terms'    => $techarqblocks_terms_query,
                    'field'    => 'slug',
                );
            } else {
                $techarqblocks_tax = false;
            }

            $techarqblocks_tax ? array_push( $techarqblocks_query_terms, $techarqblocks_tax ) : '';
        }
        return $techarqblocks_query_terms;
    }
}
