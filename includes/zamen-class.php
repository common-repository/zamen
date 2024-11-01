<?php
require_once ZAMEN_PLUGIN_PATH . '/includes/zamen-response-class.php';

/**
 * Class Zamen
 */
class Zamen {
	/**
	 * Zamen constructor.
	 */
	public function __construct() {
		register_activation_hook( ZAMEN_PLUGIN_MAIN_FILE, array( $this, 'activation_check' ) );
		add_action( 'admin_init', array( $this, 'check_version' ) );
		// Don't run anything else in the plugin, if we're on an incompatible env
		if ( self::not_compatible_version() ) {
			return;
		}

		// admin
		// Load languages
		add_action( 'plugins_loaded', array( $this, 'register_plugin_languages' ), 0 );
		add_action( 'admin_menu', array( $this, 'register_admin_menu' ) );
		add_action( 'add_meta_boxes', array( $this, 'post_push_text_add_meta_box' ) );
		add_action( 'save_post', array( $this, 'post_push_text_save_meta_box_data' ) );
		// frontend
		add_action( 'template_redirect', array( $this, 'url_handler' ) );
	}

	/**
	 * load text domain
	 */
	public function register_plugin_languages() {
		load_plugin_textdomain( 'zamen', false, ZAMEN_PLUGIN_FOLDER . '/languages/' );
	}

	// The primary check, automatically disable the plugin on activation if it doesn't meet minimum requirements.
	static function activation_check() {
		$not_compatible_version = self::not_compatible_version();
		if ( $not_compatible_version ) {
			deactivate_plugins( ZAMEN_PLUGIN_NAME );
			wp_die( $not_compatible_version, ZAMEN_PLUGIN_NAME );
		}
	}

	// The backup check, in case the plugin is activated in a weird way,
	// or the versions change after activation.
	function check_version() {
		if ( self::not_compatible_version() ) {
			if ( is_plugin_active( ZAMEN_PLUGIN_NAME ) ) {
				deactivate_plugins( ZAMEN_PLUGIN_NAME );
				add_action( 'admin_notices', array( $this, 'disabled_notice' ) );
				if ( isset( $_GET['activate'] ) ) {
					unset( $_GET['activate'] );
				}
			}
		}
	}

	function disabled_notice() {
		echo '<strong>Zamen requires PHP ' . MINIMUM_PHP_VERSION . ' or higher!', ZAMEN_PLUGIN_NAME . '</strong>';
	}

	static function not_compatible_version() {
		if ( version_compare( PHP_VERSION, MINIMUM_PHP_VERSION, '<' ) ) {
			return '<strong>Zamen requires PHP ' . MINIMUM_PHP_VERSION . ' or higher! current version is ' . PHP_VERSION . '</strong>';
		}

		return false;
	}

	/**
	 * add plugin links to admin menu
	 */
	public function register_admin_menu() {
		add_utility_page( 'زامن - Zamen', 'زامن - Zamen', 'edit_posts', 'zamen', array( $this, 'zamen_about_page_callback' ), ZAMEN_PLUGIN_URL . '/img/zamen-16.png' );
	}

	/**
	 * render admin about zamen page
	 */
	function zamen_about_page_callback() {
		if ( $_POST ) {
			$zamenOptions = array(
				'namespace'  => (string) @$_POST['zamen_namespace'],
				'access_key' => (string) @$_POST['zamen_access_key'],
			);
			update_option( 'zamen', $zamenOptions );

		}
		$defaultOptions = array(
			'namespace'  => '',
			'access_key' => '',
		);

		$zamenOptions = get_option( 'zamen', $defaultOptions );

		if ( ! empty( $zamenOptions['namespace'] ) && ! empty( $zamenOptions['access_key'] ) ) {
			$onClick = '';
		} else {
			$onClick = "alert('" . __( 'Please save namespace and access key first', 'zamen' ) . "'); return false;";
		}

		require_once ZAMEN_PLUGIN_PATH . '/includes/about.page.php';
	}

	/**
	 *
	 */
	function post_push_text_add_meta_box() {
		$post_type = 'post';
		$context   = 'side';
		$priority  = 'high';
		add_meta_box( 'zamen_post_push_text_content', __( 'Zamen app notification text', 'zamen' ), array( $this, 'post_push_text_content_meta_box' ), $post_type, $context, $priority );
	}

	/**
	 * Render push message text box
	 *
	 * @param $post
	 */
	function post_push_text_content_meta_box( $post ) {
		$value = get_post_meta( $post->ID, '_zamen_post_push_text_content', true );
		echo '<div><textarea name="zamen_post_push_text_content" class="large-text">' . trim( $value ) . '</textarea></div>';
	}

	/**
	 * When the post is saved, saves our custom data.
	 *
	 * @param int $post_id The ID of the post being saved.
	 */
	function post_push_text_save_meta_box_data( $post_id ) {
		// If this is just a revision, don't contain.
		if ( wp_is_post_revision( $post_id ) ) {
			return;
		}

		// Check the user's permissions.
		if ( isset( $_POST['post_type'] ) && 'post' == $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		}

		if ( ! isset( $_POST['zamen_post_push_text_content'] ) ) {
			return;
		}

		$my_data = strip_tags( $_POST['zamen_post_push_text_content'] );

		// Update the meta field in the database.
		update_post_meta( $post_id, '_zamen_post_push_text_content', $my_data );
	}

	/**
	 * Handle Zamen requests
	 */
	function url_handler() {
		$allowedActions       = array(
			'list_posts',
			'list_post_comments',
			'list_post_user_comments',
			'post_comment',
			'list_short_codes',
			'list_filters',
			'list_categories',
		);
		$zamenAction          = (string) @$_GET["zamen_action"];
		$jsonUnescapedUnicode = (boolean) @$_GET["json_unescaped_unicode"];
		$page                 = @$_GET["page"] ? (int) $_GET["page"] : 1;
		$limit                = @$_GET["limit"] ? (int) $_GET["limit"] : 1;
		$postId               = (int) @$_GET["post_id"];
		$userEmail            = (string) @$_GET["user_email"];

		if ( $limit > 30 ) {
			$limit = 30;
		}
		// If coming zamen request
		if ( in_array( $zamenAction, $allowedActions ) ) {
			$response                       = new ZamenResponse;
			$response->jsonUnescapedUnicode = $jsonUnescapedUnicode;
			$response->page                 = $page;
			$response->limit                = $limit;
			$response->postId               = $postId;
			$response->userEmail            = $userEmail;

//			// return response ans exit
			@header( 'Content-Type: application/json; charset=' . get_option( 'blog_charset' ), true );
			echo $response->$zamenAction();
			die;
		}
	}
}