<?php
/**
 * WPBlueprint Theme Core Handler: Theme Style
 *
 * @since   1.0
 * @package wp-blueprint/theme-core
 * @link    https://github.com/WP-Blueprint/wp-blueprint-core
 * @license https://www.gnu.org/licenses/gpl-3.0 GPL-3.0
 */

namespace WPBlueprint\Theme\Core\Handlers;

/**
 * This class handles the registration of Theme Styles.
 */
class ThemeStyle {

	/**
	 * Stores the custom colors to be registered.
	 *
	 * @var array
	 */
	protected $colors;

	/**
	 * Stores the custom font sizes to be registered.
	 *
	 * @var array
	 */
	protected $font_sizes;

	/**
	 * Stores the custom gradient to be registered.
	 *
	 * @var array
	 */
	protected $gradients;

	/**
	 * Function to register options.
	 *
	 * @return void
	 */
	public function register(): void {
		$this->add_colors();
		$this->add_font_sizes();
		$this->add_gradients();
		add_action( 'wp_head', array( $this, 'output_css_frontend' ) );
		add_action( 'admin_head', array( $this, 'output_css_backend' ) );
	}

	/**
	 * Function to set colors.
	 *
	 * @param array $colors Array of colors.
	 *
	 * @return void
	 */
	public function set_colors( array $colors = array() ): void {
		$this->colors = $colors;
	}

	/**
	 * Function to set font sizes.
	 *
	 * @param array $font_sizes Array of font sizes.
	 *
	 * @return void
	 */
	public function set_font_sizes( array $font_sizes = array() ): void {
		$this->font_sizes = $font_sizes;
	}

	/**
	 * Function to set gradients.
	 *
	 * @param array $gradients Array of gradients.
	 *
	 * @return void
	 */
	public function set_gradients( array $gradients = array() ): void {
		$this->gradients = $gradients;
	}

	/**
	 * Add defined colors to the editor color palette.
	 *
	 * @return void
	 */
	protected function add_colors(): void {
		if ( isset( $this->colors ) && ! empty( $this->colors ) ) {
			$color_palette = array();
			foreach ( $this->colors as $name => $color ) {
				if ( $color['allow_in_backend'] ) {

					$capitalized_name = ucfirst( $name );

					$color_palette[] = array(
						'name'  => $capitalized_name,
						'slug'  => $name,
						'color' => $color['value'],
					);
				}
			}

			add_theme_support( 'editor-color-palette', $color_palette );
		}
	}

	/**
	 * Add defined font sizes to the editor font sizes.
	 *
	 * @return void
	 */
	protected function add_font_sizes(): void {
		if ( isset( $this->font_sizes ) && ! empty( $this->font_sizes ) ) {
			$font_sizes = array();
			foreach ( $this->font_sizes as $name => $size ) {
				if ( $size['allow_in_backend'] ) {
					$capitalized_name = ucfirst( $name );

					$font_sizes[] = array(
						'name' => $capitalized_name,
						'wpblueprint',
						'size' => str_replace( array( 'px', 'em', 'rem' ), '', $size['value'] ),
						'slug' => $name,
					);
				}
			}

			add_theme_support( 'editor-font-sizes', $font_sizes );
		}
	}

	/**
	 * Add defined gradients to the editor gradient presets.
	 *
	 * @return void
	 */
	protected function add_gradients(): void {
		if ( isset( $this->gradients ) && ! empty( $this->gradients ) ) {
			$gradient_presets = array();
			foreach ( $this->gradients as $name => $gradient ) {
				if ( $gradient['allow_in_backend'] ) {
					$capitalized_name = ucfirst( $name );

					$gradient_presets[] = array(
						'name'     => $capitalized_name,
						'slug'     => $name,
						'gradient' => $gradient['value'],
					);
				}
			}

			add_theme_support( 'editor-gradient-presets', $gradient_presets );
		}
	}

	/**
	 * Generate CSS
	 *
	 * @param string $prefix The prefix to be added for each CSS class.
	 * @return string
	 */
	public function generate_css( $prefix = '' ) {
		$css = '';

		if ( isset( $this->colors ) && ! empty( $this->colors ) ) {
			// Color CSS generation.
			foreach ( $this->colors as $name => $props ) {
				$css .= "
				{$prefix} .has-{$name}-color {
					color: {$props['value']};
				}
				{$prefix} .has-{$name}-background-color {
					background-color: {$props['value']};
				}";
			}
		}

		if ( isset( $this->gradients ) && ! empty( $this->gradients ) ) {
			// Gradient CSS generation.
			foreach ( $this->gradients as $name => $props ) {
				$css .= "
				{$prefix} .has-gradient-{$name}-background {
					background: {$props['value']};
				}";
			}
		}

		if ( isset( $this->font_sizes ) && ! empty( $this->font_sizes ) ) {
			// Font Size CSS generation.
			foreach ( $this->font_sizes as $name => $props ) {
				if ( isset( $props['elements'] ) ) {
					$css .= "
					{$prefix} {$props['elements']} {
						font-size: {$props['value']};
					}
					@media (max-width: 600px) {
						{$prefix} {$props['elements']} {
							font-size: {$props['value_mobile']};
						}
					}";
				}

				$css .= "
				{$prefix} .has-{$name}-font-size {
					font-size: {$props['value']};
				}
				@media (max-width: 600px) {
					{$prefix} .has-{$name}-font-size {
						font-size: {$props['value_mobile']};
					}
				}";
			}
		}

		// CSS Variables for Body.
		$body_vars = '';

		if ( isset( $this->colors ) && ! empty( $this->colors ) ) {
			// Color CSS variables.
			foreach ( $this->colors as $name => $props ) {
				$body_vars .= "--wp--preset--color--{$name}: {$props['value']};";
			}
		}

		if ( isset( $this->gradients ) && ! empty( $this->gradients ) ) {
			// Gradient CSS variables.
			foreach ( $this->gradients as $name => $props ) {
				$body_vars .= "--wp--preset--color--{$name}: {$props['value']};";
			}
		}

		if ( isset( $this->font_sizes ) && ! empty( $this->font_sizes ) ) {
			// Font Size CSS variables.
			foreach ( $this->font_sizes as $name => $props ) {
				$body_vars .= "
				--wp--preset--font-size--{$name}: {$props['value']};
				--wp--preset--font-size--{$name}-mobile: {$props['value_mobile']};
				";
			}
		}

		$css .= "body {$prefix} {{$body_vars}}";

		// Remove comments.
		$css = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css );

		// Remove space after colons.
		$css = str_replace( ': ', ':', $css );

		// Remove whitespace.
		$css = str_replace( array( "\r\n", "\r", "\n", "\t", '  ', '    ', '    ' ), '', $css );

		// Output CSS.
		return $css;
	}

	/**
	 * Output CSS for frontend
	 *
	 * @return void
	 */
	public function output_css_frontend() {
		$css = $this->generate_css();
		echo "<style type='text/css'>" . esc_html( $css ) . '</style>';
	}

	/**
	 * Output CSS for backend
	 *
	 * @return void
	 */
	public function output_css_backend() {
		$css = $this->generate_css( '.wp-block-post-content' );
		echo "<style type='text/css'>" . esc_html( $css ) . '</style>';
	}
}
