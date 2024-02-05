<?php
/**
 * Deprecated: WP Blueprint Theme Core Handler: Navigation.
 *
 * This class is deprecated and replaced by Navigations class. It was used for registering
 * navigations within the theme.
 *
 * @deprecated 2.0.0 Use \WPBlueprint\Theme\Core\Handlers\Navigations instead.
 * @see \WPBlueprint\Theme\Core\Handlers\Navigations
 * @since   1.0
 * @package wp-blueprint/theme-core
 * @link    https://wp-blueprint.dev/documentation/themes/core/handlers/navigations/
 * @license https://www.gnu.org/licenses/gpl-3.0 GPL-3.0
 */

namespace WPBlueprint\Theme\Core\Handlers;

use WPBlueprint\Core\Registration\Navigations;

/**
 * @deprecated since version 2.0.0; use \WPBlueprint\Theme\Core\Handlers\Navigations instead.
 */
class Navigation {

	/**
	 * @deprecated since version 2.0.0; use \WPBlueprint\Theme\Core\Handlers\Navigations::set instead.
	 *
	 * Set the navigations to be registered.
	 *
	 * @param array $navigations Array of navigations to be registered.
	 */
	public static function set_navigations( array $navigations = [] ): void {
		wp_trigger_error(
			'Method set_navigations from class WPBlueprint\Theme\Core\Handlers\Navigation is deprecated. Use WPBlueprint\Theme\Core\Handlers\Navigations::setNavigations instead.',
			E_USER_DEPRECATED
		);

		// Backwards compatibility.
		Navigations::set( $navigations );
	}
}
