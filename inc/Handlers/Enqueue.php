<?php
/**
 * WPBlueprint Theme Core Handler: Enqueue
 *
 * @since   1.0
 * @package wp-blueprint/theme-core
 * @link    https://github.com/WP-Blueprint/wp-blueprint-core
 * @license https://www.gnu.org/licenses/gpl-3.0 GPL-3.0
 */

namespace WPBlueprint\Theme\Core\Handlers;

/**
 * This class handles the registration of styles and scripts.
 */
class Enqueue {

	/**
	 * Stores the styles and scripts that need to be enqueued.
	 *
	 * @var array
	 */
	protected $styles_and_scripts;

	/**
	 * Registers the Enqueue actions.
	 *
	 * @return void
	 */
	public function register(): void {
		$this->add_enqueue_action();
	}

	/**
	 * Sets the custom styles and scripts.
	 *
	 * @param array $styles_and_scripts Array of custom styles and scripts.
	 * @return void
	 */
	public function set_styles_and_scripts( array $styles_and_scripts = array() ): void {
		$this->styles_and_scripts = $styles_and_scripts;
	}

	/**
	 * Adds the enqueue actions.
	 *
	 * @return void
	 */
	protected function add_enqueue_action(): void {
		if ( isset( $this->styles_and_scripts ) && ! empty( $this->styles_and_scripts ) ) {
			$added_hooks = [];
			foreach ( $this->styles_and_scripts as $item ) {
				$hook = $item['hook'] ?? 'wp_enqueue_scripts'; // Default to 'front' if 'hook' is not set.
				if ( ! isset( $added_hooks[ $hook ] ) ) {
					switch ( $hook ) {
						case 'wp_enqueue_scripts':
							add_action(
								'wp_enqueue_scripts',
								function() use ( $hook ) {
									$this->register_scripts();
								}
							);
							break;
						case 'admin_enqueue_scripts':
							add_action(
								'admin_enqueue_scripts',
								function() use ( $hook ) {
									$this->register_scripts();
								}
							);
							break;
						case 'enqueue_block_editor_assets':
							add_action(
								'enqueue_block_editor_assets',
								function() use ( $hook ) {
									$this->register_scripts();
								}
							);
							break;
						case 'init':
							add_action(
								'init',
								function() use ( $hook ) {
									$this->register_scripts();
								}
							);
							break;
					}

					// Save the hook to our added_hooks array.
					$added_hooks[ $hook ] = true;
				}
			}
		}
	}

	/**
	 * Registers scripts and styles based on the given hook.
	 *
	 * @return void
	 */
	public function register_scripts(): void {
		if ( isset( $this->styles_and_scripts ) && ! empty( $this->styles_and_scripts ) ) {
			foreach ( $this->styles_and_scripts as $item ) {
				if ( isset( $item['register_only'] ) && $item['register_only'] ) {
					$this->register_item( $item );
				} else {
					$this->enqueue_item( $item );
				}
			}
		}
	}

	/**
	 * Helper method to enqueue a single item
	 *
	 * @param  array $item The item to enqueue.
	 * @return void
	 */
	protected function enqueue_item( array $item ): void {
		if ( isset( $this->styles_and_scripts ) && ! empty( $this->styles_and_scripts ) ) {

			if ( isset( $item['src'] ) && isset( $item['handle'] ) ) {
				$deps      = isset( $item['deps'] ) && is_array( $item['deps'] ) ? $item['deps'] : array();
				$version   = isset( $item['version'] ) ? $item['version'] : false;
				$media     = isset( $item['media'] ) ? $item['media'] : 'all';
				$in_footer = isset( $item['in_footer'] ) && $item['in_footer'];

				if ( preg_match( '/\.css$/', $item['src'] ) ) {
					wp_enqueue_style( $item['handle'], $item['src'], $deps, $version, $media );
				} elseif ( preg_match( '/\.js$/', $item['src'] ) ) {
					wp_enqueue_script( $item['handle'], $item['src'], $deps, $version, $in_footer );
				}
			}
		}
	}

	/**
	 * Helper method to register a single item
	 *
	 * @param  array $item The item to register.
	 * @return void
	 */
	protected function register_item( array $item ): void {
		if ( isset( $item['src'] ) && isset( $item['handle'] ) ) {
			$deps      = isset( $item['deps'] ) && is_array( $item['deps'] ) ? $item['deps'] : array();
			$version   = isset( $item['version'] ) ? $item['version'] : false;
			$in_footer = isset( $item['in_footer'] ) && $item['in_footer'];

			if ( preg_match( '/\.css$/', $item['src'] ) ) {
				wp_register_style( $item['handle'], $item['src'], $deps, $version, $in_footer );
			} elseif ( preg_match( '/\.js$/', $item['src'] ) ) {
				wp_register_script( $item['handle'], $item['src'], $deps, $version, $in_footer );
			}
		}
	}
}
