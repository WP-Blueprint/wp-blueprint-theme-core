<?php
/**
 * WPBlueprint Theme Core Handler: Taxonomy
 *
 * @since   1.0
 * @package wp-blueprint/theme-core
 * @link    https://wp-blueprint.dev/documentation/themes/core/handlers/taxonomies/
 * @license https://www.gnu.org/licenses/gpl-3.0 GPL-3.0
 */

namespace WPBlueprint\Theme\Core\Handlers;

/**
 * This class handles the registration of taxonomies.
 */
class Taxonomy {

	/**
	 * Stores the custom taxonomies to be registered.
	 *
	 * @var array
	 */
	protected $taxonomies;

	/**
	 * Registers the Taxonomy actions.
	 *
	 * @return void
	 */
	public function register() {
		$this->add_taxonomy_action();
	}

	/**
	 * Function to set custom taxonomies.
	 *
	 * @param array $taxonomies Array of custom taxonomies.
	 *
	 * @return void
	 */
	public function set_taxonomies( array $taxonomies = array() ): void {
		$this->taxonomies = $taxonomies;
	}

	/**
	 * Function to add Taxonomy action.
	 *
	 * @return void
	 */
	protected function add_taxonomy_action() {
		if ( isset( $this->taxonomies ) && ! empty( $this->taxonomies ) ) {
			add_action( 'init', array( $this, 'register_custom_taxonomies' ) );
		}
	}

	/**
	 * Register custom taxonomies.
	 *
	 * @return void
	 */
	public function register_custom_taxonomies() {
		foreach ( $this->taxonomies as $taxonomy ) {
			register_taxonomy( ...$taxonomy );
		}
	}
}
