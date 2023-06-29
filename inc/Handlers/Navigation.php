<?php
/**
 * WPBlueprint Theme Core Handler: Navigation
 *
 * @since   1.0
 * @package wp-blueprint/theme-core
 * @link    https://github.com/WP-Blueprint/wp-blueprint-core
 * @license https://www.gnu.org/licenses/gpl-3.0 GPL-3.0
 */

namespace WPBlueprint\Theme\Core\Handlers;

/**
 * This class handles the registration of navigations.
 */
class Navigation {

	/**
	 * Stores the custom navigation menus to be registered.
	 *
	 * @var array
	 */
	protected $navigations;

	/**
	 * Registers the Navigation actions.
	 *
	 * @return void
	 */
	public function register(): void {
		$this->add_navigation_action();
	}

	/**
	 * Sets the custom navigations.
	 *
	 * @param array $navigations Array of custom navigations.
	 * @return void
	 */
	public function set_navigations( array $navigations = array() ): void {
		$this->navigations = $navigations;
	}

	/**
	 * Adds actions for Navigation.
	 *
	 * @return void
	 */
	protected function add_navigation_action(): void {
		if ( isset( $this->navigations ) && ! empty( $this->navigations ) ) {
			add_action( 'init', array( $this, 'register_custom_navigations' ) );
		}
	}

	/**
	 * Registers custom navigations.
	 *
	 * @return void
	 */
	public function register_custom_navigations(): void {
		register_nav_menus( $this->navigations );
	}

	/**
	 * Fetches the navigation options for a given location.
	 *
	 * @param string $location The navigation menu location.
	 * @return array The navigation menu options for the given location.
	 */
	public function get_navigation_options( string $location ): array {
		$options = array();
		foreach ( $this->navigations as $nav ) {
			if ( $nav['location'] === $location ) {
				$options = $nav['options'];
				break;
			}
		}
		return $options;
	}

	/**
	*  Now, when you want to render a navigation menu, you can use the get_navigation_options() method to get the options for a specific navigation location:
	*
	* $nav_options = $navigation_handler->get_navigation_options('primary');
	* wp_nav_menu(array_merge(array('theme_location' => 'primary'), $nav_options));
	*
	* Replace $navigation_handler with your instance of the NavigationHandler class. This example assumes you have already registered your custom Nav Walker class with WordPress. If you haven't done so, you should require/include the Nav Walker class file and register it before using it.
	*/

}
