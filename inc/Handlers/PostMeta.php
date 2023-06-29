<?php
/**
 * WPBlueprint Theme Core Handler: Post Meta
 *
 * @since   1.0
 * @package wp-blueprint/theme-core
 * @link    https://github.com/WP-Blueprint/wp-blueprint-core
 * @license https://www.gnu.org/licenses/gpl-3.0 GPL-3.0
 */

namespace WPBlueprint\Theme\Core\Handlers;

/**
 * This class handles the registration of post metas.
 */
class PostMeta {

	/**
	 * Stores the custom post meta fields to be registered.
	 *
	 * @var array
	 */
	protected $post_meta_fields;

	/**
	 * Registers the post meta actions.
	 *
	 * @return void
	 */
	public function register() {
		$this->add_post_meta_action();
	}

	/**
	 * Sets the custom post meta fields.
	 *
	 * @param array $post_meta_fields Array of custom post meta fields.
	 * @return void
	 */
	public function set_post_meta_fields( array $post_meta_fields = array() ): void {
		$this->post_meta_fields = $post_meta_fields;
	}

	/**
	 * Adds actions for post meta fields.
	 *
	 * @return void
	 */
	protected function add_post_meta_action() {
		if ( isset( $this->post_meta_fields ) && ! empty( $this->post_meta_fields ) ) {
			// Register custom post meta fields.
			add_action( 'add_meta_boxes', array( $this, 'register_custom_post_meta_boxes' ) );
			add_action( 'save_post', array( $this, 'save_custom_post_meta_fields' ) );
		}
	}

	/**
	 * Registers custom post meta boxes.
	 *
	 * @return void
	 */
	public function register_custom_post_meta_boxes() {
		foreach ( $this->post_meta_fields as $post_meta_field ) {
			add_meta_box(
				$post_meta_field['id'],
				$post_meta_field['title'],
				array( $this, 'render_custom_post_meta_box' ),
				$post_meta_field['post_type'],
				$post_meta_field['context'],
				$post_meta_field['priority'],
				$post_meta_field
			);
		}
	}

	/**
	 * Renders custom post meta box.
	 *
	 * @param \WP_Post $post Current post object.
	 * @param array    $args Box arguments.
	 * @return void
	 */
	public function render_custom_post_meta_box( $post, $args ) {
		$field_id    = $args['args']['id'];
		$field_value = get_post_meta( $post->ID, $field_id, true );
		$field_type  = $args['args']['field_type'];

		// Add the nonce field to the form.
		wp_nonce_field( 'custom_post_meta_nonce_action', 'custom_post_meta_nonce' );

		switch ( $field_type ) {
			case 'text':
				echo '<input type="text" id="' . esc_attr( $field_id ) . '" name="' . esc_attr( $field_id ) . '" value="' . esc_attr( $field_value ) . '">';
				break;
			case 'textarea':
				echo '<textarea id="' . esc_attr( $field_id ) . '" name="' . esc_attr( $field_id ) . '">' . esc_textarea( $field_value ) . '</textarea>';
				break;
			case 'url':
				echo '<input type="url" id="' . esc_attr( $field_id ) . '" name="' . esc_attr( $field_id ) . '" value="' . esc_attr( $field_value ) . '">';
				break;
			// Add more field types as needed.
		}
	}

	/**
	 * Save custom post meta fields.
	 *
	 * @param int $post_id The ID of the post being saved.
	 * @return void
	 */
	public function save_custom_post_meta_fields( $post_id ) {
		// Verify nonce.
		if ( ! isset( $_POST['custom_post_meta_nonce'] ) || ! wp_verify_nonce( $_POST['custom_post_meta_nonce'], 'custom_post_meta_nonce_action' ) ) {
			return;
		}

		// Check if the current user has permission to save post meta.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Save custom post meta fields.
		foreach ( $this->post_meta_fields as $post_meta_field ) {
			$field_id = $post_meta_field['id'];

			if ( isset( $_POST[ $field_id ] ) ) {
				$field_value = sanitize_text_field( $_POST[ $field_id ] );
				update_post_meta( $post_id, $field_id, $field_value );
			}
		}
	}
}
