<?php
/**
 * Deprecated: WP Blueprint Enqueue Handler:
 *
 * This class is deprecated and replaced by Assets class. It was used for registering
 * styles and scripts within the theme.
 *
 * @deprecated 2.0.0 Use \WPBlueprint\Core\Registration\Assets instead.
 * @see \WPBlueprint\Core\Registration\Assets
 * @since   1.0
 * @package wp-blueprint/theme-core
 * @link    https://wp-blueprint.dev/documentation/themes/core/handlers/blocktypes/
 * @license https://www.gnu.org/licenses/gpl-3.0 GPL-3.0
 */

namespace WPBlueprint\Theme\Core\Handlers;

use WPBlueprint\Core\Registration\Assets;

/**
 * @deprecated since version 2.0.0; use \WPBlueprint\Core\Registration\Assets instead.
 */
class Enqueue {

	/**
	 * @deprecated since version 2.0.0; use \WPBlueprint\Core\Registration\Assets::set instead.
	 *
	 * Set the styles and scripts to be registered.
	 *
	 * @param array $styles_and_scripts Array of styles and scripts to be registered.
	 */
	public function set_styles_and_scripts( array $styles_and_scripts = array() ): void {

		wp_trigger_error(
			'Method set_styles_and_scripts from class WPBlueprint\Theme\Core\Handlers\Enqueue is deprecated. Use WPBlueprint\Core\Registration\Assets::set instead.',
			E_USER_DEPRECATED
		);

		// Backwards compatibility.
		Assets::set( $styles_and_scripts );
	}
}
