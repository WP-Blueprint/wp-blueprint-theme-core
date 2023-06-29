<?php
/**
 * WPBlueprint Theme Core Handler: Widget Area
 *
 * @since   1.0
 * @package wp-blueprint/theme-core
 * @link    https://github.com/WP-Blueprint/wp-blueprint-core
 * @license https://www.gnu.org/licenses/gpl-3.0 GPL-3.0
 */

namespace WPBlueprint\Theme\Core\Handlers;

/**
 * This class handles the registration of widget areas.
 */
class WidgetArea {

	/**
	 * Stores the custom widget areas to be registered.
	 *
	 * @var array
	 */
	protected $widget_areas;

	/**
	 * Registers the widget area actions.
	 *
	 * @return void
	 */
	public function register() {
		$this->add_widget_area_action();
	}

	/**
	 * Sets the custom widget areas.
	 *
	 * @param array $widget_areas Array of custom widget areas.
	 * @return void
	 */
	public function set_widget_areas( array $widget_areas = array() ): void {
		$this->widget_areas = $widget_areas;
	}

	/**
	 * Adds actions for widget areas.
	 *
	 * @return void
	 */
	protected function add_widget_area_action() {
		if ( isset( $this->widget_areas ) && ! empty( $this->widget_areas ) ) {
			// Register custom widget areas.
			add_action( 'widgets_init', array( $this, 'register_custom_widget_areas' ) );
		}
	}

	/**
	 * Registers custom widget areas.
	 *
	 * @return void
	 */
	public function register_custom_widget_areas() {
		foreach ( $this->widget_areas as $widget_area ) {
			register_sidebar( $widget_area );
		}
	}
}
