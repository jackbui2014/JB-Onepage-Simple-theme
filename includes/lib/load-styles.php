<?php
/**
 * This file will render all css code from styles files
 *
 * @param void
 * @return void
 * @since 1.0
 * @packet WE
 * @category LOADSTYLE
 * @author: Tambh
 *
 */
global $wp_styles;
if(!class_exists('WP_Styles')) {
    $parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
    require_once( $parse_uri[0] . 'wp-load.php' );
}
$wp_styles = new JB_LoadStyles();
$wp_styles->jb_add_styles($wp_styles);
if( isset( $wp_styles->name ) && $wp_styles->name != '' ) {   
    $load = trim($wp_styles->name, ',');    
    if (is_array($load)){
        $load = implode('', $load);
    }
    $load = preg_replace('/[^a-z0-9,_-]+/i', '', $load);
    $load = array_unique(explode(',', $load));
    if ( empty($load) ) {
        exit;
    }
    /**
     * check and gzip style file
     *
     * @since 1.0
     *
     * @author Tambh
     */
    $compress = (isset($wp_styles->c) && $wp_styles->c);
    $force_gzip = ($compress && 'gzip' == $wp_styles->c);
    $rtl = (isset($wp_styles->dir) && 'rtl' == $wp_styles->dir);
    $expires_offset = 31536000; // 1 year
    $out = '';   
    foreach ($load as $handle) {
        if (!array_key_exists($handle, $wp_styles->registered))
            continue;

        $style = $wp_styles->registered[$handle];
        $path = $style->src;       
        if ($rtl && !empty($style->extra['rtl'])) {
            // All default styles have fully independent RTL files.
            $path = str_replace('.min.css', '-rtl.min.css', $path);
        }      
        $content = file_get_contents($path) . "\n";
        if (strpos($style->src, '/' . WPINC . '/css/') === 0) {
            $content = str_replace('../images/', '../' . WPINC . '/images/', $content);
            $content = str_replace('../fonts/', '../' . WPINC . '/fonts/', $content);
            $content = str_replace('font-', '../css/font-', $content);
            $content = str_replace('../../img/', '../js/img/', $content);
            $out .= $content;
        } else {
            $content = str_replace('font-awesome.min.css', '../css/font-awesome.min.css', $content);
            $content = str_replace('../../img/', '../js/img/', $content);
            $out .= str_replace('../images/', 'images/', $content);
        }
    }
    header('Content-Type: text/css; charset=UTF-8');
    header('Expires: ' . gmdate("D, d M Y H:i:s", time() + $expires_offset) . ' GMT');
    header("Cache-Control: public, max-age=$expires_offset");
    if ($compress && !ini_get('zlib.output_compression') && 'ob_gzhandler' != ini_get('output_handler') && isset($_SERVER['HTTP_ACCEPT_ENCODING'])) {
        header('Vary: Accept-Encoding'); // Handle proxies
        if (false !== stripos($_SERVER['HTTP_ACCEPT_ENCODING'], 'deflate') && function_exists('gzdeflate') && !$force_gzip) {
            header('Content-Encoding: deflate');
            $out = gzdeflate($out, 3);
        } elseif (false !== stripos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') && function_exists('gzencode')) {
            header('Content-Encoding: gzip');
            $out = gzencode($out, 3);
        }
    }
    echo $out;
    exit;
}