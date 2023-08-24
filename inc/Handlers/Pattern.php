<?php
/**
 * WPBlueprint Theme Core Handler: Pattern
 *
 * @since   1.0
 * @package wp-blueprint/theme-core
 * @link    https://wp-blueprint.dev/documentation/themes/core/handlers/patterns/
 * @license https://www.gnu.org/licenses/gpl-3.0 GPL-3.0
 */

namespace WPBlueprint\Theme\Core\Handlers;

/**
 * This class handles the registration of patterns.
 */
class Pattern {
	/**
	 * The patterns to be registered.
	 *
	 * @var array
	 */
	protected $patterns;

	/**
	 * The categories to be registered.
	 *
	 * @var array
	 */
	protected $categories;

	/**
	 * Registers the Patterns actions.
	 *
	 * @return void
	 */
	public function register(): void {
		$this->add_pattern_action();
	}

	/**
	 * Function to set patterns.
	 *
	 * @param array $patterns Array of patterns.
	 *
	 * @return void
	 */
	public function set_patterns( array $patterns = array() ): void {
		$this->patterns = $patterns;
	}

	/**
	 * Function to set categories.
	 *
	 * @param array $categories Array of categories.
	 *
	 * @return void
	 */
	public function set_categories( array $categories = array() ): void {
		$this->categories = $categories;
	}

	/**
	 * Function to add pattern action.
	 *
	 * @return void
	 */
	protected function add_pattern_action(): void {
		if ( isset( $this->patterns ) && ! empty( $this->patterns ) ) {
			add_action( 'init', array( $this, 'register_custom_patterns' ) );
		}
		if ( isset( $this->categories ) && ! empty( $this->categories ) ) {
			add_action( 'init', array( $this, 'register_custom_categories' ) );
		}
	}

	/**
	 * Register custom patterns.
	 *
	 * @return void
	 */
	public function register_custom_patterns(): void {
		foreach ( $this->patterns as $pattern ) {
			// Register the pattern with the provided properties.
			register_block_pattern(
				...$pattern,
			);
		}
	}

	/**
	 * Register custom categories.
	 *
	 * @return void
	 */
	public function register_custom_categories(): void {
		foreach ( $this->categories as $category ) {
			register_block_pattern_category(
				...$category,
			);
		}
	}
}
