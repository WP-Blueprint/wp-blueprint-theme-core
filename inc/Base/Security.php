<?php
/**
 * WPBlueprint Theme Core Base: Security
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
class Security {

	/**
	 * Registers various hooks and functionalities for the security class.
	 *
	 * @return void
	 */
	public function register() {
		// Check various options and add appropriate filters and actions.
		if ( get_option( 'security_static_error', 1 ) ) {
			add_filter( 'login_errors', array( $this, 'static_wordpress_errors' ) );
		}

		if ( get_option( 'security_hide_wp_version', 1 ) ) {
			add_filter( 'the_generator', array( $this, 'hide_wp_version' ) );
		}

		if ( get_option( 'security_disable_xmlrpc', 1 ) ) {
			add_filter( 'xmlrpc_enabled', '__return_false' );
		}

		if ( get_option( 'security_disable_rest_api', 1 ) ) {
			add_filter( 'rest_authentication_errors', array( $this, 'disable_rest_api' ) );
		}

		if ( get_option( 'security_limit_login', 1 ) ) {
			add_filter( 'wp_authenticate_user', array( $this, 'limit_login_attempts_by_ip' ), 10, 2 );
			add_action( 'wp_login_failed', array( $this, 'track_failed_login_attempts_by_ip' ) );
			add_action( 'wp_login', array( $this, 'reset_failed_login_attempts_by_ip' ), 10, 2 );
		}
	}

	/**
	 * Return a static error message for login errors.
	 *
	 * @param string $error_message The original error message.
	 * @return string The static error message.
	 */
	public function static_wordpress_errors( $error_message ) {
		return __( 'Something went wrong!', 'wpblueprint' );
	}

	/**
	 * Hide WordPress version number from RSS feeds.
	 *
	 * @return string An empty string.
	 */
	public function hide_wp_version() {
		return '';
	}

	/**
	 * Disable the REST API for unauthorized users.
	 *
	 * @param \WP_Error|null|bool $result The authentication result.
	 * @return \WP_Error|null|bool Return the original result if authenticated, otherwise a WP_Error.
	 */
	public function disable_rest_api( $result ) {
		if ( ! is_user_logged_in() ) {
			return new \WP_Error( 'rest_not_logged_in', 'You are not currently logged in.', array( 'status' => 401 ) );
		}
		return $result;
	}

	/**
	 * Limit login attempts by IP address.
	 *
	 * @param \WP_User|\WP_Error $user     The user object or WP_Error on failed authentication.
	 * @param string             $password The password provided for authentication.
	 * @return \WP_User|\WP_Error The original user object if authenticated, otherwise a WP_Error.
	 */
	public function limit_login_attempts_by_ip( $user, $password ) {
		if ( is_wp_error( $user ) ) {
			return $user;
		}

		$max_attempts = (int) get_option( 'security_limit_login_attempts', 10 );

		if ( $max_attempts <= 0 ) {
			return $user;
		}

		$ip_address           = $_SERVER['REMOTE_ADDR'];
		$reset_interval_hours = get_option( 'security_limit_login_attempts_interval', 24 );
		$reset_interval       = $reset_interval_hours * 60 * 60; // Set the interval to 1 hour (60 minutes * 60 seconds).

		if ( $this->should_reset_attempts_by_ip( $ip_address, $reset_interval ) ) {
			delete_transient( 'login_attempts_' . $ip_address );
		}

		$attempts = (int) get_transient( 'login_attempts_' . $ip_address );

		if ( $attempts >= $max_attempts ) {
			return new \WP_Error( 'too_many_attempts', __( 'Too many failed login attempts.', 'wpblueprint' ) );
		}

		return $user;
	}

	/**
	 * Track failed login attempts by IP address.
	 *
	 * @param string $username The username of the failed login attempt.
	 */
	public function track_failed_login_attempts_by_ip( $username ) {
		$ip_address = $_SERVER['REMOTE_ADDR'];
		$attempts   = (int) get_transient( 'login_attempts_' . $ip_address );
		set_transient( 'login_attempts_' . $ip_address, $attempts + 1, 24 * 60 * 60 ); // Store the count for 24 hours.
	}

	/**
	 * Reset failed login attempts by IP address on successful login.
	 *
	 * @param string   $user_login The username of the logged-in user.
	 * @param \WP_User $user The user object of the logged-in user.
	 */
	public function reset_failed_login_attempts_by_ip( $user_login, $user ) {
		$ip_address = $_SERVER['REMOTE_ADDR'];
		delete_transient( 'login_attempts_' . $ip_address );
	}

	/**
	 * Determine whether to reset the login attempts for the IP address.
	 *
	 * @param string $ip_address    The IP address to check.
	 * @param int    $reset_interval The reset interval in seconds.
	 * @return bool True if the attempts should be reset, false otherwise.
	 */
	public function should_reset_attempts_by_ip( $ip_address, $reset_interval ) {
		$last_failed_attempt = (int) get_transient( '_last_failed_attempt_' . $ip_address );

		if ( $last_failed_attempt > 0 && ( time() - $last_failed_attempt ) > $reset_interval ) {
			return true;
		}
		return false;
	}
}
