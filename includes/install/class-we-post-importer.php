<?php
/**
 * Summary
 *
 * Description.
 *
 * @since 0.9.0
 *
 * @package
 * @subpackage 
 *
 * @author nguyenvanduocit
 */

class WE_Post_Importter extends ET_Import_XML{
	function __construct () {
		$this->file = TEMPLATEPATH . '/sampledata/sample_post.xml';
	}
}