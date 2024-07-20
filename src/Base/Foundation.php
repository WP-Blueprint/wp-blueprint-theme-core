<?php
/**
 * WPBlueprint Theme Core Base: Foundation
 *
 * @since   1.0
 * @package wp-blueprint/theme-core
 * @link    https://github.com/WP-Blueprint/wp-blueprint-core
 * @license https://www.gnu.org/licenses/gpl-3.0 GPL-3.0
 */

namespace WPBlueprint\Theme\Core\Base;

/**
 * This class handles various aspects related to the security of the theme.
 */
class Foundation {

	/**
	 * Registers various hooks and functionalities for the foundation class.
	 *
	 * @return void
	 */
	public function register() {
		if ( get_option( 'foundation_login_logo_url', 0 ) ) {
			add_action( 'login_enqueue_scripts', array( $this, 'change_login_logo' ) );
		}

		if ( ! get_option( 'foundation_enable_admin_bar', 0 ) ) {
			add_filter( 'show_admin_bar', '__return_false' );
		}

		if ( get_option( 'foundation_remove_gallery_css', 1 ) ) {
			add_filter( 'gallery_style', array( $this, 'remove_gallery_css' ) );
		}

		if ( get_option( 'foundation_allow_svg_upload', 1 ) ) {
			add_filter( 'upload_mimes', array( $this, 'cc_mime_types' ) );
			add_filter( 'wp_check_filetype_and_ext', array( $this, 'fix_svg_check' ), 10, 4 );
			add_action( 'admin_head', array( $this, 'fix_svg' ) );
		}

		add_action( 'wp_head', array( $this, 'custom_wp_head' ), 0 );
		add_filter( 'the_excerpt_rss', array( $this, 'featured_to_rss' ) );
		$this->are_image_libraries_installed();
	}

	/**
	 * Change the login logo based on the foundation_login_logo_url option.
	 *
	 * @return void
	 */
	public function change_login_logo() {
		$url = get_option( 'foundation_login_logo_url', '' );
		if ( ! empty( $url ) ) {
			echo '<style type="text/css">
				#login h1 a, .login h1 a {
					background-image: url(' . esc_url( $url ) . ');
					width: 200px;
					height: 200px;
					background-size: 80% auto;
					background-repeat: no-repeat;
					padding-bottom: 20px;
					background-position: center center;
				}
			</style>';
		}
	}

	/**
	 * Adds custom meta data to the wp_head action.
	 *
	 * @return void
	 */
	public static function custom_wp_head() {
		$charset = get_bloginfo( 'charset' );

		$custom_wp_head = get_option( 'foundation_custom_wp_head', false );

		echo '<meta charset="' . esc_attr( $charset ) . '" />';
		echo '<meta name="viewport" content="width=device-width, initial-scale=1" />';
		echo '<link type="text/plain" rel="author" href="' . esc_url( get_template_directory_uri() ) . '/humans.txt" />';
		echo '<meta http-equiv="x-dns-prefetch-control" content="on">';

		if ( ! empty( $custom_wp_head ) ) {
			echo esc_html( $custom_wp_head );
		}
	}

	/**
	 * Adds featured image to RSS feeds, with a fallback if not set.
	 *
	 * @param string $content The existing RSS feed content.
	 * @return string Modified RSS feed content.
	 */
	public function featured_to_rss( $content ) {
		global $post;

		// Get the thumbnail size for the RSS feed.
		$thumbnail_size = get_option( 'foundation_rss_thumbnail_size', 'large' );

		// Check if the post has a thumbnail.
		if ( has_post_thumbnail( $post->ID ) ) {
			// Get the URL of the featured image in the specified size.
			$thumbnail_url = get_the_post_thumbnail_url( $post->ID, $thumbnail_size );

			// Add the featured image with a link to the post.
			$content = sprintf(
				'<div><a href="%s" rel="nofollow"><img src="%s" alt="%s" /></a></div>',
				get_permalink( $post->ID ),
				$thumbnail_url,
				the_title_attribute( 'echo=0' )
			) . $content;
		}

		return $content;
	}

	/**
	 * Removes gallery CSS from the given CSS string.
	 *
	 * @param string $css Existing CSS.
	 * @return string Modified CSS.
	 */
	public static function remove_gallery_css( $css ) {
		return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
	}

	/**
	 * Adds inline styles for SVG images in the admin panel.
	 *
	 * @return void
	 */
	public static function fix_svg() {
		echo '<style type="text/css">
				.attachment-266x266, .thumbnail img {
					width: 100% !important;
					height: auto !important;
				}
			</style>';
	}

	/**
	 * Fixes file type and ext for SVG uploads.
	 *
	 * @param array  $checked An array of mime type keys and values.
	 * @param string $file Full path to the file.
	 * @param string $filename The name of the file (may differ from $file due to
	 *                         $file being in a tmp directory).
	 * @param array  $mimes An array of allowed mime types.
	 * @return array Modified array of mime type keys and values.
	 */
	public static function fix_svg_check( $checked, $file, $filename, $mimes ) {
		if ( ! $checked['type'] ) {
			$wp_check_filetype = wp_check_filetype( $filename, $mimes );
			$ext               = $wp_check_filetype['ext'];
			$type              = $wp_check_filetype['type'];
			$proper_filename   = $filename;

			if ( $type && 0 === strpos( $type, 'image/' ) && 'svg' !== $ext ) {
				$ext  = false;
				$type = false;
			}

			$checked = compact( 'ext', 'type', 'proper_filename' );
		}

		return $checked;
	}

	/**
	 * Add SVG mime types to WordPress.
	 *
	 * @param array $mimes An array of allowed mime types.
	 * @return array Modified array of mime types.
	 */
	public static function cc_mime_types( $mimes ) {
		$mimes['svg']  = 'image/svg+xml';
		$mimes['svgz'] = 'image/svg+xml';
		return $mimes;
	}

	/**
	 * Checks if the required image libraries are installed.
	 *
	 * @return bool True if the required libraries are installed, false otherwise.
	 */
	public function are_image_libraries_installed() {
		// Check if GD library is installed.
		if ( ! function_exists( 'imagecreatetruecolor' ) || ! function_exists( 'imagecolorallocate' ) || ! function_exists( 'imagefill' ) || ! function_exists( 'imagettfbbox' ) || ! function_exists( 'imagettftext' ) || ! function_exists( 'imagepng' ) || ! function_exists( 'imagedestroy' ) ) {
			return false;
		}

		// Check if FreeType library is installed.
		if ( ! function_exists( 'imagettfbbox' ) ) {
			return false;
		}

		add_action( 'admin_init', array( $this, 'generate_theme_thumbnail' ) );
	}

	/**
	 * Generates a thumbnail for the theme.
	 *
	 * @return void
	 */
	public static function generate_theme_thumbnail() {
		$theme      = wp_get_theme();
		$theme_name = $theme->get( 'Name' );

		if ( is_child_theme() ) {
			$path = get_stylesheet_directory();
		} else {
			$path = get_template_directory();
		}

		$thumbnail_path = $path . '/screenshot.png';
		$font_path      = __DIR__ . '/../../assets/fonts/roboto.ttf';

		if ( ! file_exists( $thumbnail_path ) ) {
			// Define the desired dimensions for the thumbnail.
			$thumbnail_width  = 800;
			$thumbnail_height = 600;

			// Create a new blank image with the desired thumbnail dimensions.
			$thumbnail_image = imagecreatetruecolor( $thumbnail_width, $thumbnail_height );

			// Set the background color to white.
			$white = imagecolorallocate( $thumbnail_image, 255, 255, 255 );
			imagefill( $thumbnail_image, 0, 0, $white );

			// Set the text color to black.
			$black = imagecolorallocate( $thumbnail_image, 0, 0, 0 );

			// Set the font size.
			$font_size = 20;

			// Calculate the position to center the text.
			$text_box    = imagettfbbox( $font_size, 0, $font_path, $theme_name );
			$text_width  = $text_box[2] - $text_box[0];
			$text_height = $text_box[7] - $text_box[1];
			$x           = ( $thumbnail_width - $text_width ) / 2;
			$y           = ( $thumbnail_height - $text_height ) / 2 + $text_height;
			$x           = intval( $x );
			$y           = intval( $y );

			// Add the text to the image using the Roboto font.
			imagettftext( $thumbnail_image, $font_size, 0, $x, $y, $black, $font_path, $theme_name );

			// Save the thumbnail image as a PNG file.
			imagepng( $thumbnail_image, $thumbnail_path );

			// Free up memory by destroying the image.
			imagedestroy( $thumbnail_image );
		}
	}
}
