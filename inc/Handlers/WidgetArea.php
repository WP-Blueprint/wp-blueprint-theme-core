<?php
/**
 * Deprecated: WP Blueprint Theme Core Handler: WidgetArea.
 *
 * This class is deprecated and replaced by Sidebars. It was used for registering
 * elements within the theme.
 *
 * @deprecated 2.0.0 Use \WPBlueprint\Core\Registration\Sidebars instead.
 * @see \WPBlueprint\Core\Registration\Sidebars
 * @since   1.0
 * @package wp-blueprint/theme-core
 * @link    https://wp-blueprint.dev/documentation/themes/core/handlers/elements/
 * @license https://www.gnu.org/licenses/gpl-3.0 GPL-3.0
 */

namespace WPBlueprint\Theme\Core\Handlers;

use WPBlueprint\Core\Registration\Sidebars;

/**
 * @deprecated since version 2.0.0; use \WPBlueprint\Core\Registration\Sidebars instead.
 */
class WidgetArea {

	/**
	 * @deprecated since version 2.0.0; use \WPBlueprint\Core\Registration\Sidebars::set() instead.
	 *
	 * Set the widget areas to be registered.
	 *
	 * @param array $sidebars Array of widget areas to be registered.
	 */
	public static function set_widget_areas( array $sidebars = [] ): void {
		wp_trigger_error(
			'Method set_widget_areas from class WPBlueprint\Theme\Core\Handlers\WidgetArea is deprecated. Use WPBlueprint\Core\Registration\Sidebars::set instead.',
			E_USER_DEPRECATED
		);

		// Backwards compatibility.
		Sidebars::set( $sidebars );
	}
}
