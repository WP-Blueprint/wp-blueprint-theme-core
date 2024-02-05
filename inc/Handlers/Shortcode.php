<?php
/**
 * Deprecated: WP Blueprint Theme Core Handler: Shortcode.
 *
 * This class is deprecated and replaced by Shortcodes class. It was used for registering
 * shortcodes within the theme.
 *
 * @deprecated 2.0.0 Use \WPBlueprint\Core\Registration\Shortcodes instead.
 * @see \WPBlueprint\Core\Registration\Shortcodes
 * @since   1.0
 * @package wp-blueprint/theme-core
 * @link    https://wp-blueprint.dev/documentation/themes/core/handlers/shortcodes/
 * @license https://www.gnu.org/licenses/gpl-3.0 GPL-3.0
 */

namespace WPBlueprint\Theme\Core\Handlers;

use WPBlueprint\Core\Registration\Shortcodes;

/**
 * @deprecated since version 2.0.0; use \WPBlueprint\Core\Registration\Shortcodes instead.
 */
class Shortcode {

	/**
	 * @deprecated since version 2.0.0; use \WPBlueprint\Core\Registration\Shortcodes::set() instead.
	 *
	 * Set the shortcodes to be registered.
	 *
	 * @param array $shortcodes Array of shortcodes to be registered.
	 */
	public static function set_shortcodes( array $shortcodes = [] ): void {

		wp_trigger_error(
			'Method set_shortcodes from class WPBlueprint\Theme\Core\Handlers\Shortcode is deprecated. Use WPBlueprint\Core\Registration\Shortcodes::set instead.',
			E_USER_DEPRECATED
		);

		// Backwards compatibility.
		Shortcodes::set( $shortcodes );
	}
}
