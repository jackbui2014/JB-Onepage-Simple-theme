<?php
if ( !class_exists( 'ReduxFramework' ) ) {
	return;
}

if ( !class_exists( "JB_Theme_Options" ) ) {

	class JB_Theme_Options {
		
		public function __construct( ) {
			// Base Config for Media Center
			//add_action( 'after_setup_theme', array($this, 'load_config') );
			$this->load_config();
		}

		public function load_config() {

			$entranceAnimations = array(
				'none'				=> __( 'No Animation', JB_DOMAIN ),
		        'bounceIn'			=> __( 'BounceIn', JB_DOMAIN ),
		        'bounceInDown'		=> __( 'BounceInDown', JB_DOMAIN ),
		        'bounceInLeft'		=> __( 'BounceInLeft', JB_DOMAIN ),
		        'bounceInRight'		=> __( 'BounceInRight', JB_DOMAIN ),
		        'bounceInUp'		=> __( 'BounceInUp', JB_DOMAIN ),
				'fadeIn'			=> __( 'FadeIn', JB_DOMAIN ),
				'fadeInDown'		=> __( 'FadeInDown', JB_DOMAIN ),
				'fadeInDownBig'		=> __( 'FadeInDown Big', JB_DOMAIN ),
				'fadeInLeft'		=> __( 'FadeInLeft', JB_DOMAIN ),
				'fadeInLeftBig'		=> __( 'FadeInLeft Big', JB_DOMAIN ),
				'fadeInRight'		=> __( 'FadeInRight', JB_DOMAIN ),
				'fadeInRightBig'	=> __( 'FadeInRight Big', JB_DOMAIN ),
				'fadeInUp'			=> __( 'FadeInUp', JB_DOMAIN ),
				'fadeInUpBig'		=> __( 'FadeInUp Big', JB_DOMAIN ),
				'flipInX'			=> __( 'FlipInX', JB_DOMAIN ),
				'flipInY'			=> __( 'FlipInY', JB_DOMAIN ),
				'lightSpeedIn'		=> __( 'LightSpeedIn', JB_DOMAIN ),
				'rotateIn' 			=> __( 'RotateIn', JB_DOMAIN ),
				'rotateInDownLeft' 	=> __( 'RotateInDown Left', JB_DOMAIN ),
				'rotateInDownRight' => __( 'RotateInDown Right', JB_DOMAIN ),
				'rotateInUpLeft' 	=> __( 'RotateInUp Left', JB_DOMAIN ),
				'rotateInUpRight' 	=> __( 'RotateInUp Right', JB_DOMAIN ),
				'roleIn'			=> __( 'RoleIn', JB_DOMAIN ),
		        'zoomIn'			=> __( 'ZoomIn', JB_DOMAIN ),
				'zoomInDown'		=> __( 'ZoomInDown', JB_DOMAIN ),
				'zoomInLeft'		=> __( 'ZoomInLeft', JB_DOMAIN ),
				'zoomInRight'		=> __( 'ZoomInRight', JB_DOMAIN ),
				'zoomInUp'			=> __( 'ZoomInUp', JB_DOMAIN ),
			);

			$sections = apply_filters('jb_admin_seting', array(

				array(
					'title' => __('General', JB_DOMAIN),
					'icon' 	=> 'fa fa-dot-circle-o',
					'fields' => array(
						array(
							'title' => __('Favicon', JB_DOMAIN),
							'subtitle' => __('<em>Upload your custom Favicon image. <br>.ico or .png file required.</em>', JB_DOMAIN),
							'id' => 'favicon',
							'type' => 'media',
							'default' => array(
								'url' => get_template_directory_uri() . '/favicon.ico',
							),
						),
						
						array(
							'title' => __('Your Logo', JB_DOMAIN),
							'subtitle' => __('<em>Upload your logo image. Recommended dimension : 233x54 pixels</em>', JB_DOMAIN),
							'id' => 'site_logo',
							'type' => 'media',
						),
						
						array(
							'title' => __('Use text instead of logo ?', JB_DOMAIN),
							'id' => 'use_text_logo',
							'type' => 'checkbox',
							'default' => '0',
						),
						
						array(
							'title' => __('Logo Text', JB_DOMAIN),
							'subtitle' => __('<em>Will be displayed only if use text logo is checked.</em>', JB_DOMAIN),
							'id' => 'logo_text',
							'type' => 'text',
							'default' => 'Media Center',
							'required' => array(
								0 => 'use_text_logo',
								1 => '=',
								2 => 1,
							),
						),

						array(
							'title' => __('Scroll to Top', JB_DOMAIN),
							'id' => 'scroll_to_top',
							'on' => __('Enabled', JB_DOMAIN),
							'off' => __('Disabled', JB_DOMAIN),
							'type' => 'switch',
							'default' => 1,
						),
					),
				),
				array(
					'title' => __('Contact information', JB_DOMAIN),
					'icon' => 'fa fa-envelope-o',
					'fields' => array(
						array(
							'title' => __('Address', JB_DOMAIN),
							'subtitle' => __('<em>Type address here.</em>', JB_DOMAIN),
							'id' => 'jb_address',
							'type' => 'text',
							'default' => 'District 9, HCM City',
						),
						array(
							'title' => __('Phone number', JB_DOMAIN),
							'subtitle' => __('<em>Type your phone number here.</em>', JB_DOMAIN),
							'id' => 'phone_number',
							'type' => 'text',
							'default' => '090834334',
						),
						array(
							'title' => __('Business email', JB_DOMAIN),
							'subtitle' => __('<em>Type your business email here.</em>', JB_DOMAIN),
							'id' => 'business_email',
							'type' => 'text',
							'default' => 'abc@example.com',
						)
					)
				),
				array(
					'title' => __('Social Media', JB_DOMAIN),
					'icon' => 'fa fa-share-square-o',
					'fields' => array(
						array(
							'title' => __('Facebook', JB_DOMAIN),
							'subtitle' => __('<em>Type your Facebook profile URL here.</em>', JB_DOMAIN),
							'id' => 'facebook_link',
							'type' => 'text',
							'default' => 'https://www.facebook.com/jbprovider',
						),
						array(
							'title' => __('Twitter', JB_DOMAIN),
							'subtitle' => __('<em>Type your Twitter profile URL here.</em>', JB_DOMAIN),
							'id' => 'twitter_link',
							'type' => 'text',
							'default' => 'http://twitter.com/jbprovider',
						),
						array(
							'title' => __('Google+', JB_DOMAIN),
							'subtitle' => __('<em>Type your Google+ profile URL here.</em>', JB_DOMAIN),
							'id' => 'googleplus_link',
							'type' => 'text',
						),
						array(
							'title' => __('Website', JB_DOMAIN),
							'subtitle' => __('<em>Type your website URL here.</em>', JB_DOMAIN),
							'id' => 'website_link',
							'type' => 'text',
						),
						array(
							'title' => __('RSS', JB_DOMAIN),
							'subtitle' => __('<em>Type your RSS Feed URL here.</em>', JB_DOMAIN),
							'id' => 'rss_link',
							'type' => 'text',
						)
					),
				),
				array(
					'title' => __('Custom Code', JB_DOMAIN),
					'icon' => 'fa fa-code',
					'fields' => array(

						array(
							'title' => __('Custom CSS', JB_DOMAIN),
							'subtitle' => __('<em>Paste your custom CSS code here.</em>', JB_DOMAIN),
							'id' => 'custom_css',
							'type' => 'ace_editor',
							'mode' => 'css',
						),

						array(
							'title' => __('Header JavaScript Code', JB_DOMAIN),
							'subtitle' => __('<em>Paste your custom JS code here. The code will be added to the header of your site.</em>', JB_DOMAIN),
							'id' => 'header_js',
							'type' => 'ace_editor',
							'mode' => 'javascript',
						),

						array(
							'title' => __('Footer JavaScript Code', JB_DOMAIN),
							'subtitle' => __('<em>Here is the place to paste your Google Analytics code or any other JS code you might want to add to be loaded in the footer of your website.</em>', JB_DOMAIN),
							'id' => 'footer_js',
							'type' => 'ace_editor',
							'mode' => 'javascript',
						),
					),
				)
			) );

			// Change your opt_name to match where you want the data saved.
			$args = array(
				'opt_name' => 'jb_theme_options',
				'menu_title' => __( 'JB Options', JB_DOMAIN ),
				'page_priority' => 3,
				'allow_sub_menu' => false,
				'intro_text' => '',
				'footer_credit' => '&nbsp;',
				'page_slug' => 'theme_options',
				'google_api_key' => '',
			);

			// Use this section if this is for a theme. Replace with plugin specific data if it is for a plugin.
			$theme = wp_get_theme();
			$args['display_name'] = $theme->get('Name');
			$args['display_version'] = $theme->get('Version');
			global $ReduxFramework;
			$ReduxFramework = new ReduxFramework($sections, $args);
		}	
	}
	new JB_Theme_Options();
}