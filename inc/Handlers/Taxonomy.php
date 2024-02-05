<?php
/**
 * Deprecated: WP Blueprint Theme Core Handler: Taxonomy.
 *
 * This class is deprecated and replaced by Taxonomies class. It was used for registering
 * taxonomies within the theme.
 *
 * @deprecated 2.0.0 Use \WPBlueprint\Core\Registration\Taxonomies instead.
 * @see \WPBlueprint\Core\Registration\Taxonomies
 * @since   1.0
 * @package wp-blueprint/theme-core
 * @link    https://wp-blueprint.dev/documentation/themes/core/handlers/elements/
 * @license https://www.gnu.org/licenses/gpl-3.0 GPL-3.0
 */

namespace WPBlueprint\Theme\Core\Handlers;

use WPBlueprint\Core\Registration\Taxonomies;

/**
 * @deprecated since version 2.0.0; use \WPBlueprint\Core\Registration\Taxonomies instead.
 */
class Taxonomy {

	/**
	 * @deprecated since version 2.0.0; use \WPBlueprint\Core\Registration\Taxonomies::set() instead.
	 *
	 * Set the taxonomies to be registered.
	 *
	 * @param array $taxonomies Array of taxonomies to be registered.
	 */
	public static function set_taxonomies( array $taxonomies = [] ): void {
		wp_trigger_error(
			'Method set_taxonomies from class WPBlueprint\Theme\Core\Handlers\Taxonomy is deprecated. Use WPBlueprint\Core\Registration\Taxonomies::set instead.',
			E_USER_DEPRECATED
		);

		// Backwards compatibility.
		Taxonomies::set( $taxonomies );
	}
}
