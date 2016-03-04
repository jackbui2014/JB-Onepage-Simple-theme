<?php

/**
 * WE installer
 *
 * Insert the sample data.
 *
 * @since  0.9.0
 *
 * @package
 * @subpackage
 *
 * @author nguyenvanduocit
 */
class WE_Install extends AE_Base {
	protected $title;
	protected $slug;

	protected $install_steps;
	protected $repair_steps;
	protected $uninstall_steps;

	protected static $instance;

	public function __construct() {
		$this->title           = 'WE Installer';
		$this->slug            = 'we-installer';
		$this->install_steps   = array(
			array(
				'step' => 0,
				'name' => __('Import option', ET_DOMAIN)
			),
			array(
				'step' => 1,
				'name' => __('Import thanks', ET_DOMAIN)
			),
			array(
				'step' => 2,
				'name' => __('Import events', ET_DOMAIN)
			),
			array(
				'step' => 3,
				'name' => __('Import blogs', ET_DOMAIN)
			),
			array(
				'step' => 4,
				'name' => __('Import fun fact', ET_DOMAIN)
			),
			array(
				'step' => 5,
				'name' => __('Import RSVP', ET_DOMAIN)
			),
			array(
				'step' => 6,
				'name' => __('Import timeline', ET_DOMAIN)
			),
			array(
				'step' => 7,
				'name' => __('Import wishs', ET_DOMAIN)
			),
			array(
				'step' => 8,
				'name' => __('Install home page', ET_DOMAIN)
			),
			array(
				'step' => 9,
				'name' => __('Install attachment', ET_DOMAIN)
			),
			array(
				'step' => 10,
				'name' => __('Create theme\'s directorys and files', ET_DOMAIN)
			),
			array(
				'step' => 11,
				'name' => __('Create cron job', ET_DOMAIN)
			),
			array(
				'step' => 12,
				'name' => __('Enter license key and tracking', ET_DOMAIN)
			),
			array(
				'step' => 13,
				'name' => __('Checking and redirect', ET_DOMAIN)
			)
		);
		$this->uninstall_steps = array(
			array(
				'step' => 0,
				'name' => __('Uninstall option', ET_DOMAIN)
			),
			array(
				'step' => 1,
				'name' => __('Uninstall thanks', ET_DOMAIN)
			),
			array(
				'step' => 2,
				'name' => __('Uninstall event', ET_DOMAIN)
			),
			array(
				'step' => 3,
				'name' => __('Uninstall blog', ET_DOMAIN)
			),
			array(
				'step' => 4,
				'name' => __('Uninstall fun fact', ET_DOMAIN)
			),
			array(
				'step' => 5,
				'name' => __('Uninstall RSVP', ET_DOMAIN)
			),
			array(
				'step' => 6,
				'name' => __('Uninstall timeline', ET_DOMAIN)
			),
			array(
				'step' => 7,
				'name' => __('Uninstall wish', ET_DOMAIN)
			),
			array(
				'step' => 8,
				'name' => __('Uninstall home page', ET_DOMAIN)
			),
			array(
				'step' => 9,
				'name' => __('Clear schedules', ET_DOMAIN)
			),
			array(
				'step' => 10,
				'name' => __('Checking and redirect', ET_DOMAIN)
			)
		);
		$this->repair_steps = array(
			array(
				'step'=>0,
				'name'=>__('Repair home page', ET_DOMAIN),
			),
			array(
				'step'=>1,
				'name'=>__('Repair cron', ET_DOMAIN)
			)
		);
	}

	/**
	 * Summary.
	 *
	 * @since  0.9.0
	 *
	 * @see
	 * @return WE_Install
	 *
	 * @author nguyenvanduocit
	 */
	public static function get_instance() {
		if ( NULL == static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	public function init() {

		add_action( 'after_switch_theme', array( $this, 'after_theme_active' ), 10, 1 );
		add_action( 'admin_menu', array( $this, 'admin_menus' ) );
		add_action( 'admin_init', array( $this, 'may_redirect' ) );

		$this->add_action( 'wp_ajax_installer-request', 'request_handler' );
	}

	public function may_redirect() {
		// Bail if activating from network, or bulk, or within an iFrame
		if ( is_network_admin() || isset( $_GET[ 'activate-multi' ] ) || defined( 'IFRAME_REQUEST' ) ) {
			return;
		}
		if ( isset( $_REQUEST[ 'action' ] ) ) {
			return;
		}
		// Bail if no activation redirect transient is set
		if ( ! get_site_transient( 'we_activation_redirect' ) ) {
			return;
		}

		// Delete the redirect transient
		delete_site_transient( 'we_activation_redirect' );
		wp_redirect( admin_url('index.php?page=' . $this->slug ) . '&action=install' );
		exit;
	}

	/**
	 * Detect theme active to import sample data.
	 *
	 * @since  0.9.0
	 *
	 * @param $newTheme
	 * @param $oldTheme
	 *
	 * @return void
	 *
	 * @author nguyenvanduocit
	 */
	public function after_theme_active( $newTheme) {
		$is_installed = get_site_option( 'we_install_step' );
		if(!$is_installed)
		{
			set_site_transient( 'we_activation_redirect', 'true', 60 * 60 );
		}
	}

	/**
	 * Summary.
	 *
	 * @since  0.9.0
	 *
	 * @see
	 * @return void
	 *
	 * @author nguyenvanduocit
	 */
	public function admin_menus() {

		if ( empty( $_GET[ 'page' ] ) || empty($_GET[ 'action' ]) || ( $_GET[ 'page' ] !== $this->slug ) || ( !in_array($_GET[ 'action' ], array('install', 'refresh', 'uninstall','repair'), true) ) ) {
			return;
		}

		$page = add_dashboard_page( $this->title, $this->title, 'manage_options', $this->slug, array(
			$this,
			'page_content'
		) );
		remove_all_actions('admin_notices');
		add_action( 'admin_print_styles-' . $page, array( $this, 'admin_style' ) );
		add_action( 'admin_print_scripts-' . $page, array( $this, 'admin_script' ) );
	}

	public function admin_style() {
		$this->add_style( 'we-styleshet', get_template_directory_uri() . '/css/stylesheet.css' );
		$this->add_style( 'we-installer', get_template_directory_uri() . '/includes/install/css/installer.css' );
	}

	public function admin_script() {

		$this->add_script( 'we-installer', get_template_directory_uri() . '/includes/install/js/installer.js', array(
			'jquery',
			'backbone',
			'appengine'
		), ET_VERSION, TRUE );
	}

	/**
	 * Get the page content.
	 *
	 * @since  0.9.0
	 *
	 * @return void
	 *
	 * @author nguyenvanduocit
	 */
	public function page_content() {
		$ajax_action = '';
		if ( ! isset( $_REQUEST[ 'action' ] ) ) {
			return;
		}
		//If refresh, just delete the step tracking option, then run install
		if ( 'refresh' === $_REQUEST[ 'action' ] ) {
			$last_step = get_site_option( 'we_install_step' );
			if ( ! $last_step ) {
				$first_step = $this->install_steps[ 0 ];
			} else {
				$first_step = $this->uninstall_steps[ 0 ];
			}
			$ajax_action = 'refresh';
		} elseif ( 'install' === $_REQUEST[ 'action' ] ) {
			$ajax_action = 'install';
			/** If user install when the uninstall is not finish, we abort this process by delete the uninstall step key.
			 * TODO The uninstall step is not end, if we abort it, may cause an error.
			*/
			$uninstall_step = get_site_option( 'we_uninstall_step' );
			if ( ! $uninstall_step ) {
				delete_site_option('we_uninstall_step');
			}
			//Get the last step
			$last_step = get_site_option( 'we_install_step' );
			if ( ! $last_step ) {
				$last_step = 0;
			}
			//The first step for current section
			$first_step = $this->install_steps[ $last_step ];
		} elseif ( 'uninstall' === $_REQUEST[ 'action' ] ) {
			$ajax_action = 'uninstall';
			//Get the last step, if last step is a number, that mean uninstall process is not success
			$last_step = get_site_option( 'we_uninstall_step' );
			if ( ! $last_step ) {
				$last_step = 0;
			}
			//The first step for current section
			$first_step = $this->uninstall_steps[ $last_step ];
		}elseif('repair' === $_REQUEST[ 'action' ]){
			$ajax_action = 'repair';
			$first_step = $this->repair_steps[0];
		}
		else {
			return;
		}
		//Get the content
		get_template_part( 'includes/install/template/installer' );
		//use handle name jquery because is is all way load
		wp_localize_script( 'appengine', 'installer_action', $ajax_action );
		echo '<script type="json/data" id="we_install_first_step"> ' . json_encode( $first_step ) . '</script>';
	}

	/**
	 * handle the request from user.
	 *
	 * @since  0.9.0
	 *
	 * @return void
	 *
	 * @author nguyenvanduocit
	 */
	public function request_handler() {
		$response = array(
			'success' => FALSE,
			'msg'     => __( 'Unknown error', ET_DOMAIN )
		);
		if ( isset( $_REQUEST[ 'installer_action' ] ) ) {
			switch ( $_REQUEST[ 'installer_action' ] ) {
				case 'install':
					$response = $this->insert_sample_data();
					break;
				case 'uninstall':
					$response = $this->delete_sample_data();
					break;
				case 'refresh':
					$response = $this->refresh_sample_data();
					break;
				case 'repair':
					$response = $this->repair_site();
					break;
			}
		}
		wp_send_json( $response );
	}
	public function repair_site(){
		$response = array(
			'success'       => FALSE,
			'is_final_step' => FALSE
		);
		$final_step = count( $this->repair_steps ) - 1; //The final step, -1 because array is start at 0
		if ( isset( $_REQUEST[ 'step' ] ) && is_numeric( $_REQUEST[ 'step' ] ) && ( $_REQUEST[ 'step' ] <= $final_step ) ) {
			$step = $_REQUEST[ 'step' ];
			if ( $step < $final_step ) {
				//If have next step
				$response[ 'next_step' ] = $this->repair_steps[ $step + 1 ];
			} else {
				// If is the final
				$response[ 'is_final_step' ] = TRUE;
			}

			$response[ 'percent' ] = ( ( $step + 1 ) / ( $final_step + 1 ) ) * 100; //+1 to advoid first step is 0/n = 0
			switch ( $step ) {
				case 0:
					$this->remove_home_page();
					$this->insert_home_page();
					$response[ 'success' ] = TRUE;
					$response[ 'msg' ]     = __( 'Repair home page', ET_DOMAIN );
					break;
				case 1:
					//No need to call clear, because it was called in create_cron_jobs
					//$this->clear_cron_jobs();
					$this->create_cron_jobs();
					$response[ 'success' ] = TRUE;
					$response[ 'msg' ]     = __( 'Repair cron success. redirecting ... ', ET_DOMAIN );
					//todo implement the checking method

					$response[ 'redirect' ] = get_home_url();
					break;
			}
		}
		return $response;
	}
	/**
	 * install sample data.
	 *
	 * @since  0.9.0
	 *
	 * @return array
	 *
	 * @author nguyenvanduocit
	 */
	public function insert_sample_data() {
		$response = array(
			'success'       => FALSE,
			'is_final_step' => FALSE
		);
		/**
		 * only run the install if
		 *      step is provide
		 *      step is numeric
		 *      step is < total install step
		 */
		$final_step = count( $this->install_steps ) - 1; //The final step, -1 because array is start at 0
		if ( isset( $_REQUEST[ 'step' ] ) && is_numeric( $_REQUEST[ 'step' ] ) && ( $_REQUEST[ 'step' ] <= $final_step ) ) {
			$step = $_REQUEST[ 'step' ];
			if ( $step < $final_step ) {
				//If have next step
				$response[ 'next_step' ] = $this->install_steps[ $step + 1 ];
			} else {
				// If is the final
				$response[ 'is_final_step' ] = TRUE;
			}

			$response[ 'percent' ] = ( ( $step + 1 ) / ( $final_step + 1 ) ) * 100; //+1 to advoid first step is 0/n = 0
			update_site_option( 'we_install_step', $step );
			switch ( $step ) {
				case 0:
					$this->insert_sample_option();
					$response[ 'success' ] = TRUE;
					$response[ 'msg' ]     = __( 'Import option success !', ET_DOMAIN );
					break;
				case 1:

					$this->insert_sample_post( 'sample_thanks.xml' );

					$response[ 'success' ] = TRUE;
					$response[ 'msg' ]     = __( 'import thanks success', ET_DOMAIN );
					break;
				case 2:
					$this->insert_sample_post( 'sample_event.xml' );
					$response[ 'success' ] = TRUE;
					$response[ 'msg' ]     = __( 'import events success', ET_DOMAIN );
					break;
				case 3:
					$this->insert_sample_post( 'sample_blogs.xml' );
					$response[ 'success' ] = TRUE;
					$response[ 'msg' ]     = __( 'import blogs success', ET_DOMAIN );
					break;
				case 4:
					$this->insert_sample_post( 'sample_fun_fact.xml' );
					$response[ 'success' ] = TRUE;
					$response[ 'msg' ]     = __( 'import fun fact success', ET_DOMAIN );
					break;
				case 5:
					$this->insert_sample_post( 'sample_rsvp.xml' );
					$response[ 'success' ] = TRUE;
					$response[ 'msg' ]     = __( 'import RSVP success', ET_DOMAIN );
					break;
				case 6:
					$this->insert_sample_post( 'sample_timeline.xml' );
					$response[ 'success' ] = TRUE;
					$response[ 'msg' ]     = __( 'import timeline success', ET_DOMAIN );
					break;
				case 7:
					$this->insert_sample_post( 'sample_wish.xml' );
					$response[ 'success' ] = TRUE;
					$response[ 'msg' ]     = __( 'import wish success', ET_DOMAIN );
					break;
				case 8:
					$this->insert_home_page();
					$response[ 'success' ] = TRUE;
					$response[ 'msg' ]     = __( 'Insert home page success', ET_DOMAIN );
					break;
				case 9:
					$this->insert_sample_post( 'sample_attachment.xml' );
					$response[ 'success' ] = TRUE;
					$response[ 'msg' ]     = __( 'Insert home page success', ET_DOMAIN );
					break;
				case 10:
					$this->create_files();
					$response[ 'success' ] = TRUE;
					$response[ 'msg' ]     = __( 'Create file success', ET_DOMAIN );
					break;
				case 11:
					$this->create_cron_jobs();
					$response[ 'success' ] = TRUE;
					$response[ 'msg' ]     = __( 'Create Crone success', ET_DOMAIN );
					break;
				case 12:
					$response[ 'success' ] = TRUE;
					$response[ 'msg' ]     = __( 'Example works', ET_DOMAIN );
					break;
				case 13:
					setcookie( 'et-customizer', '1', 0, '/' );
					setcookie( 'et-open_panel', '1', 0, '/' );
					$response[ 'success' ] = TRUE;
					$response[ 'msg' ]     = __( 'Finish and redirecting ... ', ET_DOMAIN );
					$response[ 'redirect' ] = get_home_url();
					break;
			}
		}

		return $response;
	}

	public function delete_sample_data() {
		$response = array(
			'success'       => FALSE,
			'is_final_step' => FALSE
		);
		/**
		 * only run the install if
		 *      step is provide
		 *      step is numeric
		 *      step is < total install step
		 */
		$final_step = count( $this->uninstall_steps ) - 1; //The final step, -1 because array is start at 0
		if ( isset( $_REQUEST[ 'step' ] ) && is_numeric( $_REQUEST[ 'step' ] ) && ( $_REQUEST[ 'step' ] <= $final_step ) ) {
			$step = $_REQUEST[ 'step' ];
			if ( $step < $final_step ) {
				//If have next step
				$response[ 'next_step' ] = $this->uninstall_steps[ $step + 1 ];
			} else {
				// If is the final
				$response[ 'is_final_step' ] = TRUE;
			}

			$response[ 'percent' ] = ( ( $step + 1 ) / ( $final_step + 1 ) ) * 100; //+1 to advoid first step is 0/n = 0
			update_site_option( 'we_uninstall_step', $step );
			switch ( $step ) {
				case 0:
					WE_Option()->destroy();
					$response[ 'success' ] = TRUE;
					$response[ 'msg' ]     = __( 'remove option success', ET_DOMAIN );
					break;
				case 1:

					$this->delete_sample_post( 'sample_thanks.xml' );

					$response[ 'success' ] = TRUE;
					$response[ 'msg' ]     = __( 'remove thanks success', ET_DOMAIN );
					break;
				case 2:
					$this->delete_sample_post( 'sample_event.xml' );
					$response[ 'success' ] = TRUE;
					$response[ 'msg' ]     = __( 'remove events success', ET_DOMAIN );
					break;
				case 3:
					$this->delete_sample_post( 'sample_blogs.xml' );
					$response[ 'success' ] = TRUE;
					$response[ 'msg' ]     = __( 'remove blog success', ET_DOMAIN );
					break;
				case 4:
					$this->delete_sample_post( 'sample_fun_fact.xml' );
					$response[ 'success' ] = TRUE;
					$response[ 'msg' ]     = __( 'remove fun fact success', ET_DOMAIN );
					break;
				case 5:
					$this->delete_sample_post( 'sample_rsvp.xml' );
					$response[ 'success' ] = TRUE;
					$response[ 'msg' ]     = __( 'remove RSVP success', ET_DOMAIN );
					break;
				case 6:
					$this->delete_sample_post( 'sample_timeline.xml' );
					$response[ 'success' ] = TRUE;
					$response[ 'msg' ]     = __( 'remove timeline success', ET_DOMAIN );
					break;
				case 7:
					$this->delete_sample_post( 'sample_wish.xml' );
					$response[ 'success' ] = TRUE;
					$response[ 'msg' ]     = __( 'remove wish success', ET_DOMAIN );
					break;
				case 8:
					$this->remove_home_page();
					$response[ 'success' ] = TRUE;
					$response[ 'msg' ]     = __( 'Insert home page success', ET_DOMAIN );
					break;
				case 9:
					$this->clear_cron_jobs();
					$response[ 'success' ] = TRUE;
					$response[ 'msg' ]     = __( 'Clear schedule success', ET_DOMAIN );
					break;
				case 10:
					$response[ 'success' ] = TRUE;
					$response[ 'msg' ]     = __( 'Finish and redirecting ... ', ET_DOMAIN );
					//todo implement the checking method
					$response[ 'redirect' ] = get_home_url();
					//Delete tracking option
					delete_site_option( 'we_uninstall_step' );
					delete_site_option( 'we_install_step' );
					break;
			}
		}

		return $response;
	}

	public function refresh_sample_data() {
		$uninstalled_key = 'we_refresh_uninstall_finished';
		//Uninstall first
		if ( isset( $_REQUEST[ 'step' ] ) && is_numeric( $_REQUEST[ 'step' ] ) ) {
			$is_installed = get_site_option( 'we_install_step' );
			if ( ! $is_installed ) {
				//If site is clean, no need to uninstall, just install now
				set_site_transient( $uninstalled_key, TRUE, 3600 );
			}
			$is_uninstall_finished = get_site_transient( $uninstalled_key );
			if ( $is_uninstall_finished ) {

				// If uninstall is finshed, we run insert sample data
				$result = $this->insert_sample_data();
				if ( $result[ 'is_final_step' ] ) {
					delete_site_transient( $uninstalled_key );
				}

				return $result;
			} else {
				//if uninstall is not finished, run it untill the final step
				$result = $this->delete_sample_data();
				if ( $result[ 'is_final_step' ] ) {
					set_site_transient( $uninstalled_key, TRUE, 3600 );
					//at the final step of uninstall, we not redirect, we goto install new sampledata
					$result[ 'next_step' ]     = $this->install_steps[ 0 ];
					$result[ 'is_final_step' ] = FALSE;
					unset( $result[ 'redirect' ] );
				}

				return $result;
			}
		}

	}

	public function insert_home_page() {
		// find post template
		$pages = get_pages( array(
			'meta_key'    => '_wp_page_template',
			'meta_value'  => 'page-template/home.php',
			'numberposts' => 1
		) );
		if ( empty( $pages ) || ! is_array( $pages ) ) {
			$page_args = array(
				'post_title'   => __( 'Home page', ET_DOMAIN ),
				'post_content' => __( 'This is default page for home page, if you see this content, your site is broken down.', ET_DOMAIN ),
				'post_type'    => 'page',
				'post_status'  => 'publish'
			);
			$id        = wp_insert_post( $page_args );
		}
		else{
			$id = $pages[0]->ID;
		}
		if ( $id ) {
			// update page template option
			update_post_meta( $id, '_wp_page_template', 'page-template/home.php' );
			update_site_option( 'show_on_front', 'page' );
			update_site_option( 'page_on_front', $id );
		}
	}

	/**
	 * Insert the sample option from file options.json
	 *
	 * @since  0.9.0
	 *
	 * @return void
	 *
	 * @author nguyenvanduocit
	 */
	public function insert_sample_option() {
		$file_path       = TEMPLATEPATH . '/sampledata/sample_options.json';
		$option_content  = @file_get_contents( $file_path );
		$option_object   = json_decode( $option_content, TRUE );
		$option_instance = WE_Option();
		foreach ( $option_object as $key => $value ) {
			$option_instance->$key = $value;
		}
		$option_instance->save();

	}

	/**
	 * import post from $file_name file.
	 *
	 * @since  0.9.0
	 *
	 * @param $file_name
	 *
	 * @return void
	 *
	 * @author nguyenvanduocit
	 */
	public function insert_sample_post( $file_name ) {
		$import_xml = new WE_Post_Importter();
		$import_xml->set_file_path( TEMPLATEPATH . '/sampledata/' . $file_name );
		$import_xml->dispatch();
	}
	public function create_cron_jobs(){
		$this->clear_cron_jobs();
		wp_schedule_event( time(), 'daily', 'we_cron_send-track' );
		wp_schedule_event( time(), 'hourly', 'we_cron_send-rsvp-remind' );
	}
	public function clear_cron_jobs(){
		wp_clear_scheduled_hook( 'we_cron_send-track' );
		wp_clear_scheduled_hook( 'we_cron_send-rsvp-remind' );
	}
	/**
	 * Create theme files.
	 *
	 * @since  0.9.0
	 *
	 * @return void
	 *
	 * @author Woocomerce
	 */
	public function create_files() {
		// Install files and folders for uploading files and prevent hotlinking
		$files = array(
			array(
				'base'    => THEME_LANGUAGE_PATH,
				'file'    => 'index.html',
				'content' => ''
			),
			array(
				'base'    => THEME_CONTENT_DIR,
				'file'    => 'index.html',
				'content' => ''
			),
			array(
				'base'    => THEME_LOG_DIR,
				'file'    => '.htaccess',
				'content' => 'deny from all'
			),
		);

		foreach ( $files as $file ) {
			if ( wp_mkdir_p( $file[ 'base' ] ) && ! file_exists( trailingslashit( $file[ 'base' ] ) . $file[ 'file' ] ) ) {
				if ( $file_handle = @fopen( trailingslashit( $file[ 'base' ] ) . $file[ 'file' ], 'w' ) ) {
					fwrite( $file_handle, $file[ 'content' ] );
					fclose( $file_handle );
				}
			}
		}
	}

	public function remove_home_page() {
		$page_id = get_site_option( 'page_on_front' );
		// find post template
		$pages = get_pages( array(
			'meta_key'    => '_wp_page_template',
			'meta_value'  => 'page-template/home.php',
			'numberposts' => 1
		) );
		if (is_array( $pages)) {
			foreach($pages as $page)
			wp_delete_post( $page->ID, TRUE );
		}
		if(in_array($page_id, $pages)){
			update_site_option( 'show_on_front', 'posts' );
		}
	}

	/**
	 * Deelte the sample post from $file_name file.
	 *
	 * @since  0.9.0
	 *
	 * @param $file_name
	 *
	 * @return void
	 *
	 * @author nguyenvanduocit
	 */
	public function delete_sample_post( $file_name ) {
		$import_xml = new WE_Post_Importter();
		$import_xml->set_file_path( TEMPLATEPATH . '/sampledata/' . $file_name );
		$import_xml->depatch();
	}
}