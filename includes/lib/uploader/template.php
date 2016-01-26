<?php
/**
 * Generate upload photo button 
 *
 * @param Array $args button setting
 * @since 1.0
 * @author Tambh
 */
if( !function_exists('jb_uploader_button_html') ){
	function jb_uploader_button_html( $args = array() ){
		$default = array(
			'container_class' => 'jb_uploader',
			'echo'=> false
			); 
		$args = wp_parse_args( $args, $default );
		$html = '';			
		$html .= '<div class="'.$args['container_class'].'">';				
		$html .= '<a href=""  class="btn btn-default button jb_uploader_button" role="button">'.__('Browse', JB_DOMAIN).'</a>';
		$html .= '</div>';
		$html = apply_filters('jb_uploader_button_html', $html );
		if( $args['echo'] )	{
			echo $html;
		}
		return $html;
	}
}
/**
 * Generate upload photo button 
 *
 * @param Array $args button setting
 * @since 1.0
 * @author Tambh
 */
if( !function_exists('jb_uploader_button_thumb_html') ){
	function jb_uploader_button_thumb_html( $args = array() ){
		$default = array(
			'container_class' => 'jb_uploader',
			'echo'=> false
			); 
		$args = wp_parse_args( $args, $default );
		$html = '';			
		$html .= '<div class="'.$args['container_class'].'">';				
		$html .= '<a href="#"  class="btn btn-default button jb_uploader_button" role="button">'.__('Browse', JB_DOMAIN).'</a>';
		$html .= '<ul>';
		$html .= 
		$html .= '</ul>';
		$html .= '</div>';
		$html = apply_filters('jb_uploader_button_thumb_html', $html );
		if( $args['echo'] )	{
			echo $html;
		}
		return $html;
	}
}