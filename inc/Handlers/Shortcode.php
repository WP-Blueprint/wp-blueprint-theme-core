<?php
/**
 * WPBlueprint Theme Core Handler: Shortcode
 *
 * @since   1.0
 * @package wp-blueprint/theme-core
 * @link    https://wp-blueprint.dev/documentation/themes/core/handlers/shortcodes/
 * @license https://www.gnu.org/licenses/gpl-3.0 GPL-3.0
 */

namespace WPBlueprint\Theme\Core\Handlers;

/**
 * This class handles the registration of shortcodes.
 */
class Shortcode {

	/**
	 * Stores the custom shortcodes to be registered.
	 *
	 * @var array
	 */
	protected $shortcodes;

	/**
	 * Registers the Shortcode actions.
	 *
	 * @return void
	 */
	public function register(): void {
		$this->add_shortcode_action();
	}

	/**
	 * Sets the shortcodes.
	 *
	 * @param array $shortcodes Array of shortcodes.
	 * @return void
	 */
	public function set_shortcodes( array $shortcodes = array() ): void {
		$this->shortcodes = $shortcodes;
	}

	/**
	 * Adds actions for Shortcodes.
	 *
	 * @return void
	 */
	protected function add_shortcode_action(): void {
		if ( isset( $this->shortcodes ) && ! empty( $this->shortcodes ) ) {
			foreach ( $this->shortcodes as $shortcode ) {
				add_shortcode( ...$shortcode );
			}
		}
	}
}
