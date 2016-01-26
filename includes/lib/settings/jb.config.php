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
					'title' => __('Header', JB_DOMAIN),
					'icon' 	=> 'fa fa-arrow-circle-o-up',
					'fields' => array(
						array(
							'id'		=> 'header_style',
							'type' 		=> 'radio',
							'title'		=> __( 'Header Style', JB_DOMAIN ),
							'options' => array(
								'header-style-1' => __( 'Header 1', JB_DOMAIN ),
								'header-style-2' => __( 'Header 2', JB_DOMAIN )
							),
							'default' => 'header-style-1',
						),
						array(
							'id' => 'top_bar_info',
							'icon' => true,
							'type' => 'info',
							'raw' => __('<h3 style="margin: 0;">Top Bar</h3>', JB_DOMAIN),
						),
						array(
							'title' => __('Top Bar', JB_DOMAIN),
							'subtitle' => __('<em>Enable / Disable the Top Bar.</em>', JB_DOMAIN),
							'id' => 'top_bar_switch',
							'on' => __('Enabled', JB_DOMAIN),
							'off' => __('Disabled', JB_DOMAIN),
							'type' => 'switch',
							'default' => 1,
						),
						array(
							'title' => __('Top Bar Left', JB_DOMAIN),
							'subtitle' => __('<em>Enable / Disable the Top Bar Left Navigation.</em>', JB_DOMAIN),
							'id' => 'top_bar_left_switch',
							'on' => __('Enabled', JB_DOMAIN),
							'off' => __('Disabled', JB_DOMAIN),
							'type' => 'switch',
							'default' => 1,
						),
						array(
							'title' => __('Top Bar Right', JB_DOMAIN),
							'subtitle' => __('<em>Enable / Disable the Top Bar Right Navigation.</em>', JB_DOMAIN),
							'id' => 'top_bar_right_switch',
							'on' => __('Enabled', JB_DOMAIN),
							'off' => __('Disabled', JB_DOMAIN),
							'type' => 'switch',
							'default' => 1,
						),
						/*array(
							'title' => __('Top Bar Background Color', JB_DOMAIN),
							'subtitle' => __('<em>The Top Bar background color.</em>', JB_DOMAIN),
							'id' => 'top_bar_background_color',
							'type' => 'color',
							'default' => '#f9f9f9',
							'transparent' => false,
							'required' => array(
								0 => 'top_bar_switch',
								1 => '=',
								2 => 1,
							),
						),
						array(
							'title' => __('Top Bar Text Color', JB_DOMAIN),
							'subtitle' => __('<em>Specify the Top Bar Typography.</em>', JB_DOMAIN),
							'id' => 'top_bar_typography',
							'type' => 'color',
							'default' => '#3d3d3d',
							'transparent' => false,
							'required' => array(
								0 => 'top_bar_switch',
								1 => '=',
								2 => 1,
							),
						),*/

						array(
							'id' => 'main_header_info',
							'icon' => true,
							'type' => 'info',
							'raw' => '<h3 style="margin: 0;">Main Header</h3>',
						),

						array(
							'title' => __('Sticky Header', JB_DOMAIN),
							'subtitle' => __('<em>Enable / Disable the Sticky Header. Available only for Header Style 2</em>', JB_DOMAIN),
							'id' => 'sticky_header',
							'on' => __('Enabled', JB_DOMAIN),
							'off' => __('Disabled', JB_DOMAIN),
							'type' => 'switch',
							'default' => 0,
						),

						array(
							'title' => __('Support Phone Number', JB_DOMAIN),
							'id' => 'header_support_phone',
							'type' => 'text',
							'default' => '(+800) 123 456 7890',
						),

						array(
							'title' => __( 'Support Email Address', JB_DOMAIN ),
							'id' => 'header_support_email',
							'type' => 'text',
							'default' => 'contact@support.com',
						),

						array(
							'id' 	=> 'search_bar_info',
							'icon' 	=> true,
							'type' 	=> 'info',
							'raw' 	=> __('<h3 style="margin: 0;">Search Bar</h3>', JB_DOMAIN),
						),

						array(
							'title' 	=> __( 'Live Search', JB_DOMAIN ),
							'id'		=> 'live_search',
							'type'		=> 'switch',
							'default'	=> 1,
							'on'		=> __( 'Enabled', JB_DOMAIN ),
							'off'		=> __( 'Disabled', JB_DOMAIN )
						),

						array(
							'title' 	=> __( 'Search Result Template', JB_DOMAIN ),
							'id'		=> 'live_search_template',
							'type' 		=> 'ace_editor',
							'mode' 		=> 'html',
							'required' 	=> array( 'live_search', 'equals', 1 ),
							'default'	=> '<p>{{value}}</p>',
							'desc'		=> __( 'Available parameters : {{value}}, {{url}}, {{image}}, {{brand}} and {{{price}}}', JB_DOMAIN)
						),

						array(
							'title' 	=> __( 'Show Categories Filter', JB_DOMAIN ),
							'id'		=> 'display_search_categories_filter',
							'type'		=> 'switch',
							'default'	=> 1,
							'on'		=> __( 'Yes', JB_DOMAIN ),
							'off'		=> __( 'No', JB_DOMAIN )
						),

						array(
							'title' 	=> __( 'Search Category Dropdown', JB_DOMAIN ),
							'id' 		=> 'header_search_dropdown',
							'type' 		=> 'radio',
							'options' 	=> array(
								'hsd0' 	=> __( 'Include only top level categories', JB_DOMAIN ),
								'hsd1' 	=> __( 'Include all categories', JB_DOMAIN )
							),
							'default' 	=> 'hsd0',
							'required' 	=> array( 'display_search_categories_filter', 'equals', 1 )
						),
					),
				),

				array(
					'title'				=> __( 'Navigation', JB_DOMAIN ),
					'icon'				=> 'fa fa-navicon',
					'fields'			=> array(
						array(
							'id' 		=> 'top_bar_left_info',
							'icon' 		=> true,
							'type' 		=> 'info',
							'raw' 		=> '<h3 style="margin: 0;">Top Bar Left Menu</h3>',
						),
						array(
							'title'		=> __( 'Dropdown Trigger', JB_DOMAIN ),
							'id'		=> 'top_bar_left_menu_dropdown_trigger',
							'type'		=> 'select',
							'options'	=> array(
								'click'	=> __( 'Click', JB_DOMAIN ),
								'hover'	=> __( 'Hover', JB_DOMAIN ),
							),
							'default'	=> 'click',
						),
						array(
							'title'		=> __( 'Dropdown Animation', JB_DOMAIN ),
							'id'		=> 'top_bar_left_menu_dropdown_animation',
							'type'		=> 'select',
							'options'	=> $entranceAnimations,
							'default'	=> 'fadeInUp',
						),

						array(
							'id' 		=> 'top_bar_right_info',
							'icon' 		=> true,
							'type' 		=> 'info',
							'raw' 		=> '<h3 style="margin: 0;">Top Bar Right Menu</h3>',
						),
						array(
							'title'		=> __( 'Dropdown Trigger', JB_DOMAIN ),
							'id'		=> 'top_bar_right_menu_dropdown_trigger',
							'type'		=> 'select',
							'options'	=> array(
								'click'	=> __( 'Click', JB_DOMAIN ),
								'hover'	=> __( 'Hover', JB_DOMAIN ),
							),
							'default'	=> 'click',
						),
						array(
							'title'		=> __( 'Dropdown Animation', JB_DOMAIN ),
							'id'		=> 'top_bar_right_menu_dropdown_animation',
							'type'		=> 'select',
							'options'	=> $entranceAnimations,
							'default'	=> 'fadeInUp',
						),

						array(
							'id' 		=> 'main_navigation_info',
							'icon' 		=> true,
							'type' 		=> 'info',
							'raw' 		=> '<h3 style="margin: 0;">Main Navigation Menu</h3>',
						),
						array(
							'title'		=> __( 'Dropdown Trigger', JB_DOMAIN ),
							'id'		=> 'main_navigation_menu_dropdown_trigger',
							'type'		=> 'select',
							'options'	=> array(
								'click'	=> __( 'Click', JB_DOMAIN ),
								'hover'	=> __( 'Hover', JB_DOMAIN ),
							),
							'default'	=> 'click',
						),
						array(
							'title'		=> __( 'Dropdown Animation', JB_DOMAIN ),
							'id'		=> 'main_navigation_menu_dropdown_animation',
							'type'		=> 'select',
							'options'	=> $entranceAnimations,
							'default'	=> 'fadeInUp',
						),

						array(
							'id' 		=> 'shop_by_departments_info',
							'icon' 		=> true,
							'type' 		=> 'info',
							'raw' 		=> '<h3 style="margin: 0;">Shop By Departments Menu</h3>',
						),

						array(
							'title'		=> __( 'Dropdown Trigger', JB_DOMAIN ),
							'id'		=> 'shop_by_departments_menu_dropdown_trigger',
							'type'		=> 'select',
							'options'	=> array(
								'click'	=> __( 'Click', JB_DOMAIN ),
								'hover'	=> __( 'Hover', JB_DOMAIN ),
							),
							'default'	=> 'click',
						),
						array(
							'title'		=> __( 'Dropdown Animation', JB_DOMAIN ),
							'id'		=> 'shop_by_departments_menu_dropdown_animation',
							'type'		=> 'select',
							'options'	=> $entranceAnimations,
							'default'	=> 'fadeInUp',
						),

						array(
							'id' 		=> 'wpml_info',
							'icon' 		=> true,
							'type' 		=> 'info',
							'raw' 		=> '<h3 style="margin: 0;">Language and Currency Switcher</h3>',
						),

						array(
							'title'		=> __( 'Language Switcher', JB_DOMAIN ),
							'id'		=> 'enable_language_switcher',
							'type'		=> 'switch',
							'on'		=> __( 'Enabled', JB_DOMAIN ),
							'off'		=> __( 'Disabled', JB_DOMAIN ),
							'subtitle'	=> __( '<em>Available only if WPML Plugin is enabled</em>', JB_DOMAIN ),
							'default'	=> 1,
						),

						array(
							'title'		=> __( 'Language Switcher Position', JB_DOMAIN ),
							'id'		=> 'language_switcher_position',
							'type'		=> 'select',
							'options'	=>  array(
								'top_bar_left'	=> __( 'Top Bar Left Menu', JB_DOMAIN ),
								'top_bar_right'	=> __( 'Top Bar Right Menu', JB_DOMAIN ),
							),
							'default'	=> 'top_bar_right',
						),
						array(
							'title'		=> __( 'Currency Switcher', JB_DOMAIN ),
							'id'		=> 'enable_currency_switcher',
							'type'		=> 'switch',
							'on'		=> __( 'Enabled', JB_DOMAIN ),
							'off'		=> __( 'Disabled', JB_DOMAIN ),
							'subtitle'	=> __( '<em>Available only if WPML Plugin and WooCommerce Multilingual is enabled</em>', JB_DOMAIN ),
							'default'	=> 1,
						),
						array(
							'title'		=> __( 'Currency Switcher Position', JB_DOMAIN ),
							'id'		=> 'currency_switcher_position',
							'type'		=> 'select',
							'options'	=>  array(
								'top_bar_left'	=> __( 'Top Bar Left Menu', JB_DOMAIN ),
								'top_bar_right'	=> __( 'Top Bar Right Menu', JB_DOMAIN ),
							),
							'default'	=> 'top_bar_right',
						),
					)
				),

				array(
					'title' => __('Footer', JB_DOMAIN),
					'icon' 	=> 'fa fa-arrow-circle-o-down',
					'fields' => array(
						array(
							'title' => __('Footer Contact Info Text', JB_DOMAIN),
							'id' => 'footer_contact_info_text',
							'type' => 'textarea',
							'default' => __('Feel free to contact us via phone,email or just send us mail.', JB_DOMAIN),
						),

						array(
							'title' => __('Footer Contact Info Address', JB_DOMAIN),
							'id' => 'footer_contact_info_address',
							'type' => 'textarea',
							'default' => '17 Princess Road, London, Greater London NW1 8JR, UK 1-888-8MEDIA (1-888-892-9953)',
						),

						array(
							'title' => __('Footer Payment Images', JB_DOMAIN),
							'subtitle' => __('<em>Upload your payment images. Preferred dimension for each image 40x29 px.</em>', JB_DOMAIN),
							'id' => 'credit_card_icons_gallery',
							'type' => 'gallery',
						),

						array(
							'title' => __('Footer Copyright Text', JB_DOMAIN),
							'subtitle' => __('<em>Enter your copyright information here.</em>', JB_DOMAIN),
							'id' => 'footer_copyright_text',
							'type' => 'textarea',
							'default' => '&copy; <a href="#">Media Center</a> - All Rights Reserved',
						),
					),
				),

				array(

					'title' => __('Shop', JB_DOMAIN),
					'icon' 	=> 'fa fa-shopping-cart',
					'fields' => array(
						
						array(
							'id' => 'shop_general_info',
							'icon' => true,
							'type' => 'info',
							'raw' => '<h3 style="margin: 0;">General</h3>',
						),

						array(
							'title' => __('Catalog Mode', JB_DOMAIN),
							'subtitle' => __('<em>Enable / Disable the Catalog Mode.</em>', JB_DOMAIN),
							'desc' => __('<em>When enabled, the feature Turns Off the shopping functionality of WooCommerce.</em>', JB_DOMAIN),
							'id' => 'catalog_mode',
							'on' => __('Enabled', JB_DOMAIN),
							'off' => __('Disabled', JB_DOMAIN),
							'type' => 'switch',
						),

						array(
							'title' 	=> __('Default View', JB_DOMAIN),
							'subtitle' 	=> __('<em>Choose a default view between grid and list views.</em>', JB_DOMAIN),
							'id' 		=> 'shop_default_view',
							'type'		=> 'select',
							'options'	=> array(
								'grid-view'	=> __( 'Grid View', JB_DOMAIN ),
								'list-view' => __( 'List View', JB_DOMAIN ),
							),
							'default'	=> 'grid-view',
						),

						array(
							'title' 	=> __('Remember User View ?', JB_DOMAIN ),
							'desc'		=> __( 'When user switches a view, should we maintain the view in all pages ?', JB_DOMAIN ),
							'id' 		=> 'remember_user_view',
							'type'		=> 'switch',
							'on'		=> __( 'Yes', JB_DOMAIN ),
							'off'		=> __( 'No', JB_DOMAIN ),
							'default'	=> 0
						),

						array(
							'title' => __('Product Item Size', JB_DOMAIN),
							'subtitle' => __('Product item size determines the number of products per row.', JB_DOMAIN),
							'id' => 'product_item_size',
							'type' => 'select',
							'options' => array(
								'size-small' => __( 'Small', JB_DOMAIN),
								'size-medium' => __( 'Medium', JB_DOMAIN),
								'size-big' => __( 'Large', JB_DOMAIN),
							),
							'default' => 'size-medium',
						),

						array(
							'title' 		=> __('Number of Products per Page', JB_DOMAIN),
							'subtitle' 		=> __('<em>Drag the slider to set the number of products per page <br />to be listed on the shop page and catalog pages.</em>', JB_DOMAIN),
							'id' 			=> 'products_per_page',
							'min' 			=> '3',
							'step' 			=> '1',
							'max' 			=> '48',
							'type' 			=> 'slider',
							'default' 		=> '15',
							'display_value' => 'label'
						),

						array(
							'id' => 'shop_product_item',
							'icon' => true,
							'type' => 'info',
							'raw' => '<h3 style="margin: 0;">Product Item Settings</h3>',
						),

						array(
							'title' 	=> __('Product Item Animation', JB_DOMAIN),
							'subtitle' 	=> __('<em>A list of all the product animations.</em>', JB_DOMAIN),
							'id' 		=> 'products_animation',
							'type' 		=> 'select',
							'options' 	=> $entranceAnimations,
							'default' 	=> 'none',
						),

						array(
							'title' => __('Echo Lazy loading', JB_DOMAIN),
							'subtitle' => __( '<em>Lazy load product images. Product images will not be loaded until scrolled into view.</em>', JB_DOMAIN ),
							'id' => 'lazy_loading',
							'on' => __('Enabled', JB_DOMAIN),
							'off' => __('Disabled', JB_DOMAIN),
							'type' => 'switch',
							'default' => 1,
						),

						array(
							'title' 	=> __( 'Hard Crop Images ?', JB_DOMAIN ),
							'subtitle'	=> __( 'If you do not like your images to be cropped, please select "No"', JB_DOMAIN ),
							'type'		=> 'switch',
							'on'		=> __( 'Yes', JB_DOMAIN ),
							'off'		=> __( 'No', JB_DOMAIN ),
							'id'		=> 'hard_crop_images',
							'default'	=> 0,
							'desc'		=> __( 'You will have to regenerate thumbnails after changing this setting', JB_DOMAIN ),
						),

						array(
							'id' => 'shop_page_settings',
							'icon' => true,
							'type' => 'info',
							'raw' => '<h3 style="margin: 0;">Shop Page Settings</h3>',
						),

						array(
							'id'      => 'shop_page_layout',
							'title'   => __( 'Shop Page Layout', JB_DOMAIN ),
							'type'	  => 'select',
							'options' => array(
								'full-width' 	=> __( 'Full-width', JB_DOMAIN ),
								'sidebar-left'  => __( 'Left Sidebar', JB_DOMAIN ),
								'sidebar-right' => __( 'Right Sidebar', JB_DOMAIN ),
							),
							'default' => 'sidebar-left'
						),

						array(
							'id'      => 'single_product_layout',
							'title'   => __( 'Single Product Page Layout', JB_DOMAIN ),
							'type'	  => 'select',
							'options' => array(
								'full-width' 	=> __( 'Full-width', JB_DOMAIN ),
								'sidebar-left'  => __( 'Left Sidebar', JB_DOMAIN ),
								'sidebar-right' => __( 'Right Sidebar', JB_DOMAIN ),
							),
							'default' => 'full-width'
						),

						array(
							'title'		=> __( 'Product Comparision Page', JB_DOMAIN ),
							'subtitle'	=> __( 'This sets the product comparison page for your shop', JB_DOMAIN ),
							'type'		=> 'select',
							'data'		=> 'pages',
							'id'		=> 'product_comparison_page'
						),
					),
				),

				array(
					'title' => __('Blog', JB_DOMAIN),
					'icon' 	=> 'fa fa-list-alt',
					'fields' => array(
						array(
							'title' 	=> __('Blog Layout', JB_DOMAIN),
							'subtitle' 	=> __('<em>Select the layout for the Blog Listing. <br />The second option will enable the Blog Listing Sidebar.</em>', JB_DOMAIN),
							'id' 		=> 'blog_layout',
							'type' 		=> 'image_select',
							'options' 	=> array(
								'sidebar_right' 	=> get_template_directory_uri() . '/framework/images/theme_options/icons/blog_right_sidebar.png',
								'without_sidebar' 	=> get_template_directory_uri() . '/framework/images/theme_options/icons/blog_no_sidebar.png',
								'sidebar_left' 		=> get_template_directory_uri() . '/framework/images/theme_options/icons/blog_left_sidebar.png',
							),
							'default' 	=> 'sidebar_right',
						),
						array(
							'title' 	=> __('Blog Style', JB_DOMAIN),
							'subtitle' 	=> __('<em>Select the layout style for the Blog Listing.</em>', JB_DOMAIN),
							'id' 		=> 'blog_style',
							'type' 		=> 'select',
							'options' 	=> array(
								'normal' 		=> __( 'Normal', JB_DOMAIN ),
								'list-view' 	=> __( 'List View', JB_DOMAIN ),
								'grid-view'		=> __( 'Grid View', JB_DOMAIN )
							),
							'default' 	=> 'normal',
						),
						array(
							'title' 	=> __( 'Full width Density', JB_DOMAIN ),
							'subtitle'  => __( 'Applicable only if you choose <em>without sidebar</em> option for blog layout', JB_DOMAIN ),
							'id' 		=> 'full_width_density',
							'type' 		=> 'radio',
							'options'	=> array(
								'wide' 			=> __( 'Wide', JB_DOMAIN ),
								'narrow' => __( 'Narrow', JB_DOMAIN )
							),
							'default' 	=> 'narrow',
						),
						array(
							'title'		=> __( 'Force Excerpt', JB_DOMAIN ),
							'subtitle'  => __( 'Show only excerpt instead of blog content in archive pages', JB_DOMAIN ),
							'id'		=> 'force_excerpt',
							'on' 		=> __('Yes', JB_DOMAIN),
							'off' 		=> __('No', JB_DOMAIN),
							'type' 		=> 'switch',
							'default' 	=> 0,		
						),
						array(
							'title'		=> __( 'Excerpt Length', JB_DOMAIN ),
							'id'		=> 'excerpt_length',
							'type'		=> 'text',
							'default'	=> 75,
							'required'	=> array( 'force_excerpt', 'equals', 1 )		
						),
					),
				),

				array(
					'title' => __('Styling', JB_DOMAIN),
					'icon' 	=> 'fa fa-pencil-square-o',
					'fields' => array(
						array(
							'title' 	=> __( 'Use a predefined color scheme', JB_DOMAIN ),
							'on' 		=> __('Yes', JB_DOMAIN),
							'off' 		=> __('No', JB_DOMAIN),
							'type' 		=> 'switch',
							'default' 	=> 1,
							'id' 		=> 'use_predefined_color'
						),
						array(
							'title' 	=> __('Main Theme Color', JB_DOMAIN),
							'subtitle' 	=> __('<em>The main color of the site.</em>', JB_DOMAIN),
							'id' 		=> 'main_color',
							'type' 		=> 'select',
							'options' 	=> array(
								'green' 	 => __( 'Green', JB_DOMAIN ) ,
								'blue' 		 => __( 'Blue', JB_DOMAIN ) ,
								'red' 		 => __( 'Red', JB_DOMAIN ) ,
								'orange' 	 => __( 'Orange', JB_DOMAIN ) ,
								'navy' 		 => __( 'Navy', JB_DOMAIN ) ,
								'dark-green' => __( 'Dark-green', JB_DOMAIN ) ,
							),
							'default' 	=> 'green',
							'required' 	=> array( 'use_predefined_color', 'equals', 1 ),
						),
						array(
							'id' 		=> 'main_custom_color',
							'icon' 		=> true,
							'type' 		=> 'info',
							'raw'   	=> '<h3>'. __( 'Using a Custom theme Color', JB_DOMAIN ). '</h3>' .
										   '<p>' . __( 'Using a custom color is simple but it requires a few extra steps.', JB_DOMAIN ) . '</p>' .
										   '<p>' . __( 'Method 1 (Recommended) : Using LESS', JB_DOMAIN ) . '</p>' .
										   '<ol>' .
										   '<li>'. __( 'Navigate to <em>assets/less/custom-color.less</em> file.', JB_DOMAIN ) . '</li>'.
										   '<li>'. __( 'On line 7, set <mark>@primary-color</mark> to the color of your choice.', JB_DOMAIN ) . '</li>'.
										   '<li>'. __( 'Compile <em>assets/less/custom-color.less</em> file to <em>assets/css/custom-color.css</em>', JB_DOMAIN ) . '</li>'.
										   '<li>'. __( 'You can also use <a href="http://less2css.org" target="_blank">less2css.org</a> to compile the LESS file and copy the output to <em>assets/css/custom-color.css</em>', JB_DOMAIN ) . '</li>'.
										   '</ol>'.
										   '<p>' . __( 'Method 2 : Using CSS and Find and Replace', JB_DOMAIN ) . '</p>' .
										   '<ol>' .
										   '<li>'. __( 'Navigate to <em>assets/css/green.css</em> file.', JB_DOMAIN ) . '</li>'.
										   '<li>'. __( 'Copy the entire file content and paste it in <em>assets/css/custom-color.css</em>.', JB_DOMAIN ) . '</li>'.
										   '<li>'. __( 'Open <em>assets/css/custom-color.css</em> file using your favourite code editor.', JB_DOMAIN ) . '</li>'.
										   '<li>'. __( 'Do a find and replace of green color which is #59b210 with your choice of color.', JB_DOMAIN ) . '</li>'.
										   '<li>'. __( 'We have also used darken and lighten version of the primary color. Replace them as well.', JB_DOMAIN ) . '</li>'.
										   '</ol>'.
										   '</ol>',
							'required' 	=> array( 'use_predefined_color', 'equals', 0 )
						),
					),
				),

				array(
					'title' => __('Typography', JB_DOMAIN),
					'icon' => 'fa fa-font',
					'fields' => array(
						array(
							'title' 	=> __( 'Use default font settings ?', JB_DOMAIN ),
							'subtitle'	=> __( '<em>Toggle No if you want to override with your own fonts</em>', JB_DOMAIN ),
							'id'		=> 'use_default_font',
							'type'		=> 'switch',
							'on'		=> __( 'Yes', JB_DOMAIN ),
							'off'		=> __( 'No', JB_DOMAIN ),
							'default'   => 1
						),
						array(
							'title' 		=> __('Default Font Family', JB_DOMAIN),
							'subtitle' 		=> __('<em>Pick the default font family for your site.</em>', JB_DOMAIN),
							'id' 			=> 'default_font',
							'type' 			=> 'typography',
							'line-height' 	=> false,
							'text-align' 	=> false,
							'font-style' 	=> false,
							'font-weight' 	=> false,
							'font-size' 	=> false,
							'color' 		=> false,
							'required'		=> array( 'use_default_font', 'equals', 0 ),
							'default' 		=> array(
								'font-family' 	=> 'Open Sans',
								'subsets' 		=> '',
							),
						),

						array(
							'title' 		=> __('Title Font Family', JB_DOMAIN),
							'subtitle' 		=> __('<em>Pick the font family for titles for your site.</em>', JB_DOMAIN),
							'id' 			=> 'title_font',
							'type' 			=> 'typography',
							'line-height' 	=> false,
							'text-align' 	=> false,
							'font-style' 	=> false,
							'font-weight' 	=> false,
							'font-size' 	=> false,
							'color' 		=> false,
							'default' 		=> array(
								'font-family' 	=> 'Open Sans',
								'subsets' 		=> '',
							),
							'required'		=> array( 'use_default_font', 'equals', 0 ),
						),
					),
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
							'default' => 'https://www.facebook.com/transvelo',
						),
						array(
							'title' => __('Twitter', JB_DOMAIN),
							'subtitle' => __('<em>Type your Twitter profile URL here.</em>', JB_DOMAIN),
							'id' => 'twitter_link',
							'type' => 'text',
							'default' => 'http://twitter.com/transvelo',
						),
						array(
							'title' => __('Pinterest', JB_DOMAIN),
							'subtitle' => __('<em>Type your Pinterest profile URL here.</em>', JB_DOMAIN),
							'id' => 'pinterest_link',
							'type' => 'text',
							'default' => 'http://www.pinterest.com/',
						),
						array(
							'title' => __('LinkedIn', JB_DOMAIN),
							'subtitle' => __('<em>Type your LinkedIn profile URL here.</em>', JB_DOMAIN),
							'id' => 'linkedin_link',
							'type' => 'text',
						),
						array(
							'title' => __('Google+', JB_DOMAIN),
							'subtitle' => __('<em>Type your Google+ profile URL here.</em>', JB_DOMAIN),
							'id' => 'googleplus_link',
							'type' => 'text',
						),
						array(
							'title' => __('RSS', JB_DOMAIN),
							'subtitle' => __('<em>Type your RSS Feed URL here.</em>', JB_DOMAIN),
							'id' => 'rss_link',
							'type' => 'text',
						),

						array(
							'title' => __('Tumblr', JB_DOMAIN),
							'subtitle' => __('<em>Type your Tumblr URL here.</em>', JB_DOMAIN),
							'id' => 'tumblr_link',
							'type' => 'text',
						),

						array(
							'title' => __('Instagram', JB_DOMAIN),
							'subtitle' => __('<em>Type your Instagram profile URL here.</em>', JB_DOMAIN),
							'id' => 'instagram_link',
							'type' => 'text',
						),

						array(
							'title' => __('Youtube', JB_DOMAIN),
							'subtitle' => __('<em>Type your Youtube profile URL here.</em>', JB_DOMAIN),
							'id' => 'youtube_link',
							'type' => 'text',
						),

						array(
							'title' => __('Vimeo', JB_DOMAIN),
							'subtitle' => __('<em>Type your Vimeo profile URL here.</em>', JB_DOMAIN),
							'id' => 'vimeo_link',
							'type' => 'text',
						),

						array(
							'title' => __('Dribbble', JB_DOMAIN),
							'subtitle' => __('<em>Type your Dribble profile URL here.</em>', JB_DOMAIN),
							'id' => 'dribbble_link',
							'type' => 'text',
						),

						array(
							'title' => __('Stumble Upon', JB_DOMAIN),
							'subtitle' => __('<em>Type your Stumble Upon profile URL here.</em>', JB_DOMAIN),
							'id' => 'stumble_upon_link',
							'type' => 'text',
						),
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
				),
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