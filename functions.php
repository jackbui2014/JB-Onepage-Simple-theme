<?php

define('TEMPLATEURL', get_template_directory_uri() );

$theme_name = 'JBThemes';

define('THEME_NAME', $theme_name);
define('JB_DOMAIN', 'jb_provider');
define('THEME_VERSION', '1.0');
function load_text_domain(){
    load_theme_textdomain(JB_DOMAIN, get_template_directory() . '/lang');
}	
require_once dirname(__FILE__) . '/includes/index.php';
// Init everything
JB_Theme::get_instance()->init();