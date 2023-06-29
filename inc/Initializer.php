<?php
/**
 * Class Initializer for OOP logic
 *
 * @since   1.0
 * @package wp-blueprint/theme-core
 * @link    https://github.com/WP-Blueprint/wp-blueprint-core
 * @license https://www.gnu.org/licenses/gpl-3.0 GPL-3.0
 */

namespace WPBlueprint\Theme\Core;

/**
 * This class initializes all the classes used by the core.
 */
final class Initializer {

	/**
	 * Store all the classes inside an array
	 *
	 * @return array Full list of classes
	 */
	public static function get_services() {
		$stylesheet_directory = get_stylesheet_directory();
		$template_directory   = get_template_directory();

		return array(
			Base\Settings::class,
			Base\Foundation::class,
			Base\Security::class,

			Handlers\Enqueue::class,
			Handlers\Gutenberg::class,
			Handlers\Navigation::class,
			Handlers\ThemeStyle::class,
			Handlers\PostType::class,
			Handlers\Taxonomy::class,
			Handlers\WidgetArea::class,
			Handlers\Pattern::class,
			Handlers\Shortcode::class,
			Handlers\PostMeta::class,
		);
	}

	/**
	 * Loop through the classes, initialize them, and call the register() method if it exists
	 *
	 * @return void
	 */
	public static function register_services() {
		foreach ( self::get_services() as $key => $value ) {
			if ( is_array( $value ) ) {
				$service = new $key( ...$value );
			} else {
				$service = new $value();
			}
			if ( method_exists( $service, 'register' ) ) {
				$service->register();
			}
		}
	}

	/**
	 * Initialize the class
	 *
	 * @param  string $class class from the services array.
	 * @return object instance new instance of the class
	 */
	private static function instantiate( $class ) {
		return new $class();
	}
}
