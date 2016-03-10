<?php
// Require the classloader
require_once TEMPLATEPATH . '/includes/lib/classloader.php';
require_once TEMPLATEPATH . '/includes/lib/class-base.php';
require_once TEMPLATEPATH . '/includes/lib/settings/index.php';
require_once TEMPLATEPATH . '/includes/lib/functions.php';
require_once TEMPLATEPATH . '/includes/lib/template.php';
require_once TEMPLATEPATH . '/includes/lib/uploader/index.php';
require_once TEMPLATEPATH . '/includes/lib/customizer/index.php';
/**
 * The map of class.
 *
 * @since 1.0
 * @var array $classMap
 */
$classMap = array(	
	'JB_LoadScripts'          => TEMPLATEPATH . '/includes/lib/class-load-scripts.php',
	'JB_LoadStyles'           => TEMPLATEPATH . '/includes/lib/class-load-styles.php',
	'JB_Validator'			  => TEMPLATEPATH . '/includes/lib/class-validator.php',
	'JB_Posts'                => TEMPLATEPATH . '/includes/lib/class-post.php',
    'JB_PostAction'           => TEMPLATEPATH . '/includes/lib/class-post-action.php',
	'JB_Options'			  => TEMPLATEPATH . '/includes/lib/class-option.php',
	'JB_Color'				  => TEMPLATEPATH . '/includes/lib/customizer/class-jb-color.php',
	'JB_Menu'				  => TEMPLATEPATH . '/includes/lib/class-jb-menu.php',
	'JB_Section'			  => TEMPLATEPATH . '/includes/lib/class-section.php',
	'JB_Section_Manager'	  => TEMPLATEPATH . '/includes/lib/class-section-manager.php',
	'JB_Lib'                  => TEMPLATEPATH . '/includes/lib/class-jb-lib.php'
);
$classMap = apply_filters( 'jb_class_list', $classMap );
/*
 * Do not mind the bottom of this section , use it for peace
 */
$loader = new MapClassLoader( $classMap );
$loader->register();
new JB_Lib();
$jb_uploader = JB_Uploader::get_instance();
$jb_uploader->init();
$job_postAction = JB_PostAction::getInstance();
$job_postAction->init();