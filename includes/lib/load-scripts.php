<?php
/**
 * This file will render all script code from .js files
 *
 * @param void
 * @return void
 * @since 1.0
 * @packet
 * @category
 * @author: Tambh
 *
 */
global $wp_scripts;
if(!class_exists('WP_Scripts')) {
    $parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
    require_once( $parse_uri[0] . 'wp-load.php' );
}
$wp_scripts = new JB_LoadScripts();
$wp_scripts->jb_add_script($wp_scripts);
if( isset( $wp_scripts->name ) && $wp_scripts != '' ) {
    $load = trim( $wp_scripts->name, ',' );
    if (is_array($load)) {
        $load = implode('', $load);
    }
    $load = preg_replace('/[^a-z0-9,_-]+/i', '', $load);
    $load = array_unique(explode(',', $load));
    if (empty($load)) {
        exit;
    }
    $compress = ( isset($wp_scripts->c) && $wp_scripts->c );
    $force_gzip = ($compress && 'gzip' == $wp_scripts->c);
    $expires_offset = 31536000; // 1 year
    $out = '';
    foreach ($load as $handle) {
        if (!array_key_exists($handle, $wp_scripts->registered)) {
            continue;
        }
        $path =  $wp_scripts->registered[$handle]->src;
        $out .= file_get_contents($path) . "\n";
    }
    header('Content-Type: application/x-javascript; charset=UTF-8');
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