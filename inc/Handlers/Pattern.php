<?php
/**
 * Deprecated: WP Blueprint Theme Core Handler: Element.
 *
 * This class is deprecated and replaced by BlockPatterns and BlockPatternCategories class. It was used for registering
 * elements within the theme.
 *
 * @deprecated 2.0.0 Use \WPBlueprint\Core\Registration\BlockPatterns and \WPBlueprint\Core\Registration\BlockPatternCategories instead.
 * @see \WPBlueprint\Core\Registration\BlockPatterns
 * @since   1.0
 * @package wp-blueprint/theme-core
 * @link    https://wp-blueprint.dev/documentation/themes/core/handlers/elements/
 * @license https://www.gnu.org/licenses/gpl-3.0 GPL-3.0
 */

namespace WPBlueprint\Theme\Core\Handlers;

use WPBlueprint\Core\Registration\BlockPatterns;
use WPBlueprint\Core\Registration\BlockPatternCategories;


/**
 * @deprecated since version 2.0.0; use \WPBlueprint\Core\Registration\BlockPatterns instead.
 */
class Pattern {

	/**
	 * @deprecated since version 2.0.0; use \WPBlueprint\Core\Registration\BlockPatterns::set() instead.
	 *
	 * Set the block patterns to be registered.
	 *
	 * @param array $elements Array of block patterns to be registered.
	 */
	public static function set_patterns( array $elements = [] ): void {
		wp_trigger_error(
			'Method set_patterns from class WPBlueprint\Theme\Core\Handlers\Pattern is deprecated. Use WPBlueprint\Theme\Core\Handlers\BlockPatterns::set instead.',
			E_USER_DEPRECATED
		);

		// Backwards compatibility.
		BlockPatterns::set( $elements );
	}

	/**
	 * @deprecated since version 2.0.0; use \WPBlueprint\Core\Registration\BlockPatternCategories::set() instead.
	 *
	 * Set the block pattern categories to be registered.
	 *
	 * @param array $elements Array of block pattern categories to be registered.
	 */
	public static function set_categories( array $elements = [] ): void {
		wp_trigger_error(
			'Method set_categories from class WPBlueprint\Theme\Core\Handlers\Gutenberg is deprecated. Use WPBlueprint\Theme\Core\Handlers\BlockPatternCategories::set instead.',
			E_USER_DEPRECATED
		);

		// Backwards compatibility.
		BlockPatternCategories::set( $elements );
	}
}
