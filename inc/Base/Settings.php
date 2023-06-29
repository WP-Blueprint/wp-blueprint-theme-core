<?php
/**
 * WPBlueprint Theme Core Base: Settings
 *
 * @since   1.0
 * @package wp-blueprint/theme-core
 * @link    https://github.com/WP-Blueprint/wp-blueprint-core
 * @license https://www.gnu.org/licenses/gpl-3.0 GPL-3.0
 */

namespace WPBlueprint\Theme\Core\Base;

/**
 * This class provides a set of methods to manage WPBlueprint Theme Core settings.
 */
class Settings {

	/**
	 * Registers various hooks and functionalities for the settings class.
	 *
	 * @return void
	 */
	public function register() {
		// Hook into the admin_menu action to create the settings page.
		add_action( 'admin_menu', array( $this, 'create_settings_page' ) );

		// Register settings and sections for Foundation and Security.
		add_action( 'admin_init', array( $this, 'register_settings' ) );
	}

	/**
	 * Create the settings page and menu items.
	 *
	 * @return void
	 */
	public function create_settings_page() {
		// Create the main settings page and submenu pages for Foundation and Security.
		add_menu_page( 'My Theme Settings', 'WPBlueprint', 'manage_options', 'wpblueprint_base_settings', array( $this, 'render_settings_page' ) );

		add_submenu_page( 'my_theme_settings', 'Foundation Settings', 'Foundation', 'manage_options', 'my_theme_foundation', array( $this, 'render_foundation_settings' ) );

		add_submenu_page( 'my_theme_settings', 'Security Settings', 'Security', 'manage_options', 'my_theme_security', array( $this, 'render_security_settings' ) );
	}

	/**
	 * Register settings, sections, and fields.
	 *
	 * @return void
	 */
	public function register_settings() {
		// Register settings for Foundation.
		register_setting( 'wpblueprint_foundation_settings', 'foundation_login_logo_url' );
		register_setting( 'wpblueprint_foundation_settings', 'foundation_enable_admin_bar' );
		register_setting( 'wpblueprint_foundation_settings', 'foundation_custom_wp_head' );
		register_setting( 'wpblueprint_foundation_settings', 'foundation_rss_thumbnail_size' );
		register_setting( 'wpblueprint_foundation_settings', 'foundation_remove_gallery_css' );
		register_setting( 'wpblueprint_foundation_settings', 'foundation_allow_svg_upload' );

		add_settings_section( 'foundation_general', 'Foundation', null, 'wpblueprint_foundation_settings' );

		add_settings_field( 'foundation_login_logo_url', 'Login Logo URL', array( $this, 'render_login_logo_url_field' ), 'wpblueprint_foundation_settings', 'foundation_general' );
		add_settings_field( 'foundation_enable_admin_bar', 'Enable Admin Bar', array( $this, 'render_enable_admin_bar_field' ), 'wpblueprint_foundation_settings', 'foundation_general' );
		add_settings_field( 'foundation_custom_wp_head', 'Custom WP Head', array( $this, 'render_custom_wp_head_field' ), 'wpblueprint_foundation_settings', 'foundation_general' );
		add_settings_field( 'foundation_rss_thumbnail_size', 'Post Thumbnail Size for RSS Feed', array( $this, 'render_rss_thumbnail_size_field' ), 'wpblueprint_foundation_settings', 'foundation_general' );
		add_settings_field( 'foundation_remove_gallery_css', 'Remove Gallery CSS', array( $this, 'render_remove_gallery_css_field' ), 'wpblueprint_foundation_settings', 'foundation_general' );
		add_settings_field( 'foundation_allow_svg_upload', 'Allow SVG Upload', array( $this, 'render_allow_svg_upload_field' ), 'wpblueprint_foundation_settings', 'foundation_general' );

		// Register settings for Security.
		register_setting( 'wpblueprint_security_settings', 'security_limit_login' );
		register_setting( 'wpblueprint_security_settings', 'security_limit_login_attempts' );
		register_setting( 'wpblueprint_security_settings', 'security_limit_login_attempts_interval' );
		register_setting( 'wpblueprint_security_settings', 'security_hide_wp_version' );
		register_setting( 'wpblueprint_security_settings', 'security_static_error' );
		register_setting( 'wpblueprint_security_settings', 'security_disable_xmlrpc' );
		register_setting( 'wpblueprint_security_settings', 'security_disable_rest_api' );

		add_settings_section( 'security_general', 'Security', null, 'wpblueprint_security_settings' );

		add_settings_field( 'security_limit_login', 'Limit Login Attempts', array( $this, 'render_limit_login_field' ), 'wpblueprint_security_settings', 'security_general' );
		add_settings_field( 'security_limit_login_attempts', 'Limit Login Attempts - Attempts', array( $this, 'render_limit_login_attempts_field' ), 'wpblueprint_security_settings', 'security_general' );
		add_settings_field( 'security_limit_login_attempts_interval', 'Limit Login Attempts - Intervals (Hours)', array( $this, 'render_limit_login_attempts_interval_field' ), 'wpblueprint_security_settings', 'security_general' );
		add_settings_field( 'security_hide_wp_version', 'Hide WordPress Version', array( $this, 'render_hide_wp_version_field' ), 'wpblueprint_security_settings', 'security_general' );
		add_settings_field( 'security_static_error', 'Static Error Message', array( $this, 'render_static_error_field' ), 'wpblueprint_security_settings', 'security_general' );
		add_settings_field( 'security_disable_xmlrpc', 'Disable XMLRPC', array( $this, 'render_disable_xmlrpc_field' ), 'wpblueprint_security_settings', 'security_general' );
		add_settings_field( 'security_disable_rest_api', 'Disable REST API for users that are not logged in', array( $this, 'render_disable_rest_api_field' ), 'wpblueprint_security_settings', 'security_general' );
	}

	/**
	 * Render the main settings page.
	 *
	 * @return void
	 */
	public function render_settings_page() {
		?>

		<div class="wrap">
			<h1>Foundation and Security Settings</h1>
			<p>Configure the foundation and security settings for your theme.</p>

			<form method="post" action="options.php">
				<?php
				settings_fields( 'wpblueprint_foundation_settings' );
				do_settings_sections( 'wpblueprint_foundation_settings' );
				submit_button( 'Save Foundation Settings' );
				?>
			</form>

			<form method="post" action="options.php">
				<?php
				settings_fields( 'wpblueprint_security_settings' );
				do_settings_sections( 'wpblueprint_security_settings' );
				submit_button( 'Save Security Settings' );
				?>
			</form>
		</div>

		<script>
			document.addEventListener('DOMContentLoaded', function() {
				const limitLoginCheckbox = document.querySelector('input[name="security_limit_login"]');
				const limitLoginRelatedSettings = document.querySelectorAll('.limit_login_related_settings');

				function toggleRelatedSettings() {
					if (limitLoginCheckbox.checked) {
						limitLoginRelatedSettings.forEach(limitLoginRelatedSetting => {
							limitLoginRelatedSetting.closest('tr').style.display = 'table-row';
						});
					} else {
						limitLoginRelatedSettings.forEach(limitLoginRelatedSetting => {
							limitLoginRelatedSetting.closest('tr').style.display = 'none';
						});
					}
				}

				limitLoginCheckbox.addEventListener('change', toggleRelatedSettings);
				toggleRelatedSettings(); // Call once to initialize the display state
			});
		</script>
		<?php
	}

	/**
	 * Render the Foundation settings section.
	 *
	 * @return void
	 */
	public function render_foundation_settings() {
		?>
		<h2>Foundation Settings</h2>
		<?php
	}

	/**
	 * Render the Security settings section.
	 *
	 * @return void
	 */
	public function render_security_settings() {
		?>
		<h2>Security Settings</h2>
		<?php
	}

	/**
	 * Render the field for setting login logo URL.
	 *
	 * @return void
	 */
	public function render_login_logo_url_field() {
		$option = get_option( 'foundation_login_logo_url' );
		echo '<input type="url" id="foundation_login_logo_url" name="foundation_login_logo_url" value="' . esc_attr( $option ) . '" />';
	}

	/**
	 * Render the field for enabling/disabling the admin bar.
	 *
	 * @return void
	 */
	public function render_enable_admin_bar_field() {
		$option = get_option( 'foundation_enable_admin_bar' );
		echo '<input type="checkbox" id=foundation_enable_admin_bar" name="foundation_enable_admin_bar" value="1" ' . checked( 1, $option, false ) . ' />';
	}

	/**
	 * Render the field for setting custom WP_Head code.
	 *
	 * @return void
	 */
	public function render_custom_wp_head_field() {
		$value = get_option( 'foundation_custom_wp_head', false );
		echo '<textarea name="foundation_custom_wp_head" id="foundation_custom_wp_head" rows="10" cols="50" style="width: 100%;">' . esc_textarea( $value ) . '</textarea>';
		echo '<p class="description">' . esc_html__( 'Add your custom code to be inserted into the wp_head section of your site. Be cautious and only add code from trusted sources.', 'wpblueprint' ) . '</p>';
	}

	/**
	 * Render the field for setting the RSS thumbnail size.
	 *
	 * @return void
	 */
	public function render_rss_thumbnail_size_field() {
		$option = get_option( 'foundation_rss_thumbnail_size', 'large' );
		$sizes  = array( 'thumbnail', 'medium', 'large', 'full' );
		echo '<select id="foundation_rss_thumbnail_size" name="foundation_rss_thumbnail_size">';
		foreach ( $sizes as $size ) {
			echo '<option value="' . esc_attr( $size ) . '"' . selected( $size, $option, false ) . '>' . esc_html( $size ) . '</option>';
		}
		echo '</select>';
	}

	/**
	 * Render the field for enabling/disabling the gallery css.
	 *
	 * @return void
	 */
	public function render_remove_gallery_css_field() {
		$option = get_option( 'foundation_remove_gallery_css', 1 );
		echo '<input type="checkbox"" name="foundation_remove_gallery_css" value="1" ' . checked( 1, $option, false ) . ' />';
	}

	/**
	 * Render the field for enabling/disabling svg upload.
	 *
	 * @return void
	 */
	public function render_allow_svg_upload_field() {
		$option = get_option( 'foundation_allow_svg_upload', 1 );
		echo '<input type="checkbox"" name="foundation_allow_svg_upload" value="1" ' . checked( 1, $option, false ) . ' />';
	}

	/**
	 * Render the field for enabling/disabling login limit.
	 *
	 * @return void
	 */
	public function render_limit_login_field() {
		$value = sanitize_text_field( get_option( 'security_limit_login', 1 ) );
		echo '<input type="checkbox" name="security_limit_login" value="1" ' . checked( 1, $value, false ) . ' />';
	}

	/**
	 * Render the field for setting the limit login attempts.
	 *
	 * @return void
	 */
	public function render_limit_login_attempts_field() {
		$value = esc_attr( get_option( 'security_limit_login_attempts', 10 ) );
		echo '<input type="number" min="1" default="10"name="security_limit_login_attempts" value="' . esc_attr( $value ) . '" class="limit_login_related_settings" />';
	}

	/**
	 * Render the field for setting the interval between login attempts.
	 *
	 * @return void
	 */
	public function render_limit_login_attempts_interval_field() {
		$value = esc_attr( get_option( 'security_limit_login_attempts_interval', 24 ) );
		echo '<input type="number" min="1" default="24" name="security_limit_login_attempts_interval" value="' . esc_attr( $value ) . '" class="limit_login_related_settings" />';
	}

	/**
	 *  Render the field for hiding the WordPress version.
	 *
	 * @return void
	 */
	public function render_hide_wp_version_field() {
		$value = esc_attr( get_option( 'security_hide_wp_version', 1 ) );
		echo '<input type="checkbox" default="checked" name="security_hide_wp_version" value="1" ' . checked( 1, $value, false ) . ' />';
	}

	/**
	 * Render the field for enabling/disabling static error messages.
	 *
	 * @return void
	 */
	public function render_static_error_field() {
		$value = sanitize_text_field( get_option( 'security_static_error', 1 ) );
		echo '<input type="checkbox" name="security_static_error" value="1" ' . checked( 1, $value, false ) . ' />';
	}

	/**
	 * Render the field for disabling XMLRPC.
	 *
	 * @return void
	 */
	public function render_disable_xmlrpc_field() {
		$value = esc_attr( get_option( 'security_disable_xmlrpc', 1 ) );
		echo '<input type="checkbox" name="security_disable_xmlrpc" value="1" ' . checked( 1, $value, false ) . ' />';
	}

	/**
	 * Render the field for disabling REST API for users that are not logged in.
	 *
	 * @return void
	 */
	public function render_disable_rest_api_field() {
		$value = sanitize_text_field( get_option( 'security_disable_rest_api', 1 ) );
		echo '<input type="checkbox" name="security_disable_rest_api" value="1" ' . checked( 1, $value, false ) . ' />';
	}
}
