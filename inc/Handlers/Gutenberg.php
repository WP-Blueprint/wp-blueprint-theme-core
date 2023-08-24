<?php
/**
 * WPBlueprint Theme Core Handler: Gutenberg
 *
 * @since   1.0
 * @package wp-blueprint/theme-core
 * @link    https://wp-blueprint.dev/documentation/themes/core/handlers/gutenberg/
 * @license https://www.gnu.org/licenses/gpl-3.0 GPL-3.0
 */

namespace WPBlueprint\Theme\Core\Handlers;

/**
 * This class handles the registration of gutenberg block editor element.
 */
class Gutenberg {
	/**
	 * Stores the custom Gutenberg blocks to be registered.
	 *
	 * @var array
	 */
	protected $blocks;

	/**
	 * Registers the Gutenberg actions.
	 *
	 * @return void
	 */
	public function register(): void {
		$this->add_gutenberg_actions();
	}

	/**
	 * Sets the custom blocks.
	 *
	 * @param array $blocks Array of custom blocks.
	 * @return void
	 */
	public function set_blocks( array $blocks = array() ): void {
		$this->blocks = $blocks;
	}

	/**
	 * Adds actions for Gutenberg.
	 *
	 * @return void
	 */
	protected function add_gutenberg_actions(): void {

		if ( isset( $this->blocks ) && ! empty( $this->blocks ) ) {
			// Register custom blocks.
			add_action( 'init', array( $this, 'register_custom_blocks' ) );
		}
	}

	/**
	 * Registers custom blocks.
	 *
	 * @return void
	 */
	public function register_custom_blocks(): void {
		foreach ( $this->blocks as $block ) {
			register_block_type( ...$block );
		}
	}
}
