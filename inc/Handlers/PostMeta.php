<?php
/**
 * Deprecated: WP Blueprint Theme Core Handler: PostMeta.
 *
 * This class is deprecated and replaced by PostTypes class. It was used for registering
 * elements within the theme.
 *
 * @deprecated 2.0.0 Use \WPBlueprint\Core\Registration\MetaBoxes;
 * @see \WPBlueprint\Core\Registration\MetaBoxes
 * @since   1.0
 * @package wp-blueprint/theme-core
 * @link    https://wp-blueprint.dev/documentation/themes/core/handlers/elements/
 * @license https://www.gnu.org/licenses/gpl-3.0 GPL-3.0
 */

namespace WPBlueprint\Theme\Core\Handlers;

use WPBlueprint\Core\Registration\MetaBoxes;

/**
 * @deprecated since version 2.0.0; use \WPBlueprint\Core\Registration\MetaBoxes instead.
 */
class PostMeta {

	/**
	 * @deprecated since version 2.0.0; use \WPBlueprint\Core\Registration\MetaBoxes::set() instead.
	 *
	 * Set the post meta fields to be registered.
	 *
	 * @param array $meta_boxes Array of post meta fields to be registered.
	 */
	public static function set_post_meta_fields( array $meta_boxes = [] ): void {
		wp_trigger_error(
			'Method set_post_meta_fields from class WPBlueprint\Theme\Core\Handlers\PostMeta is deprecated. Use WPBlueprint\Core\Registration\MetaBoxes::set instead.',
			E_USER_DEPRECATED
		);

		// Backwards compatibility.
		MetaBoxes::set( $meta_boxes );
	}
}
