<?php
/**
 * WPBlueprint Theme Core Handler: Post Type
 *
 * @since   1.0
 * @package wp-blueprint/theme-core
 * @link    https://github.com/WP-Blueprint/wp-blueprint-core
 * @license https://www.gnu.org/licenses/gpl-3.0 GPL-3.0
 */

namespace WPBlueprint\Theme\Core\Handlers;

/**
 * This class handles the registration of post types.
 */
class PostType {

	/**
	 * Stores the custom posttypes to be registered.
	 *
	 * @var array
	 */
	protected $posttypes;

	/**
	 * Registers the Posttype actions.
	 *
	 * @return void
	 */
	public function register() {
		$this->add_posttype_action();
	}

	/**
	 * Function to set custom posttypes.
	 *
	 * @param array $posttypes Array of custom posttypes.
	 *
	 * @return void
	 */
	public function set_posttypes( array $posttypes = array() ): void {
		$this->posttypes = $posttypes;
	}

	/**
	 * Function to add posttypes action.
	 *
	 * @return void
	 */
	protected function add_posttype_action() {
		if ( isset( $this->posttypes ) && ! empty( $this->posttypes ) ) {
			// Register custom widget areas.
			add_action( 'init', array( $this, 'register_custom_posttypes' ) );
		}
	}

	/**
	 * Register custom posttypes.
	 *
	 * @return void
	 */
	public function register_custom_posttypes() {

		// Register the new posttype.
		foreach ( $this->posttypes as $posttype ) {
			// Register the Posttype.
			register_post_type( ...$posttype );
		}
	}
}
