<?php
/**
 * Deprecated: WP Blueprint Theme Core Handler: Gutenberg.
 *
 * This class is deprecated and replaced by BlockTypes class. It was used for registering
 * blocktypes within the theme.
 *
 * @deprecated 2.0.0 Use \WPBlueprint\Core\Registration\BlockTypes instead.
 * @see \WPBlueprint\Core\Registration\BlockTypes
 * @since   1.0
 * @package wp-blueprint/theme-core
 * @link    https://wp-blueprint.dev/documentation/themes/core/handlers/blocktypes/
 * @license https://www.gnu.org/licenses/gpl-3.0 GPL-3.0
 */

namespace WPBlueprint\Theme\Core\Handlers;

use WPBlueprint\Core\Registration\BlockTypes;

/**
 * @deprecated since version 2.0.0; use \WPBlueprint\Core\Registration\BlockTypes instead.
 */
class Gutenberg {

	/**
	 * @deprecated since version 2.0.0; use \WPBlueprint\Core\Registration\BlockTypes::set() instead.
	 *
	 * Set the block types to be registered.
	 *
	 * @param array $blocktypes Array of block types to be registered.
	 */
	public static function set_blocks( array $blocktypes = [] ): void {
		wp_trigger_error(
			'Method set_blocks from class WPBlueprint\Theme\Core\Handlers\Gutenberg is deprecated. Use WPBlueprint\Core\Registration\BlockTypes::set instead.',
			E_USER_DEPRECATED
		);

		// Backwards compatibility.
		BlockTypes::set( $blocktypes );
	}
}
