<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*

This is one of the free scripts from www.dhtmlgoodies.com
You are free to use this script as long as this copyright message is kept intact

(c) Alf Magne Kalleland, http://www.dhtmlgoodies.com - 2005

*/

class CI_Alias {
	
	function generate_alias($str){
		setlocale(LC_ALL, 'en_US.UTF8');
		$plink = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
		$plink = preg_replace("/[^a-zA-Z0-9\/_| -.,]/", '', $plink);
		$plink = strtolower(trim($plink, '-'));
		$plink = preg_replace("/[\/_| -]+/", '-', $plink);
		$plink = preg_replace("/[\/_| -]+/", '-', $plink);
		$plink = str_replace(",", '', $plink);
		$plink = str_replace("'", '', $plink);
		
		return $plink;	
	}
	
}//end class


?>