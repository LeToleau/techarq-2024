<?php
/**
 * This class allows you to add placeholders to custom fields in the admin pages
 *
 * @package TecharqBlocks
 */

namespace TecharqBlocks\Helpers;

/**
 * Helper Class for including placeholders into modules
 */
class PlaceholderHelper {

	/**
	 * This functions takes the field name, the placeholder content 
     * and inserts it at the admin pages if the field is empty.
	 *
	 * @param string $field The field's name, usually used in a get_field function.
     * @param $placeholder The text to display if there is no value for the $field param.
     * @param bool $is_sub_field Set to true if the field is a sub field (Like an inner field from a repeater).
	 */
	public static function placeholder( string $field, $placeholder, bool $is_sub_field = false) {
        $content = $is_sub_field ? get_sub_field($field) : get_field($field);

        if (is_admin() && empty($content)) {
            return $placeholder;
        } else {
            return $content;
        }
	}
}