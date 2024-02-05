<?php
/**
 * Deprecated: WP Blueprint Theme Core Handler: PostType.
 *
 * This class is deprecated and replaced by PostTypes class. It was used for registering
 * elements within the theme.
 *
 * @deprecated 2.0.0 Use \WPBlueprint\Core\Registration\PostTypes instead.
 * @see \WPBlueprint\Core\Registration\PostTypes
 * @since   1.0
 * @package wp-blueprint/theme-core
 * @link    https://wp-blueprint.dev/documentation/themes/core/handlers/elements/
 * @license https://www.gnu.org/licenses/gpl-3.0 GPL-3.0
 */

namespace WPBlueprint\Theme\Core\Handlers;

use WPBlueprint\Core\Registration\PostTypes;

/**
 * @deprecated since version 2.0.0; use \WPBlueprint\Core\Registration\PostTypes instead.
 */
class PostType {

	/**
	 * @deprecated since version 2.0.0; use \WPBlueprint\Core\Registration\PostTypes:set() instead.
	 *
	 * Set the post types to be registered.
	 *
	 * @param array $post_types Array of post types to be registered.
	 */
	public static function set_posttypes( array $post_types = [] ): void {

		wp_trigger_error(
			'Method set_posttypes from class WPBlueprint\Theme\Core\Handlers\PostType is deprecated. Use WPBlueprint\Core\Registration\PostTypes::set instead.',
			E_USER_DEPRECATED
		);

		// Backwards compatibility.
		PostTypes::set( $post_types );
	}
}
