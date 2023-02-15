<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('cek_aktif')){
	function cek_aktif(){
		$CI =& get_instance();
		$user = $CI->session->userdata('userid');
		if($user == '')
			redirect('login', 'refresh');    
		
		$cek = md5('#@+setneg'.$CI->session->userdata('username'));
		if($cek != $user)
		    redirect('login', 'refresh');
	}
}
if (!function_exists('enkripsi_id_url')){
    function enkripsi_id_url($id){
    	$b64 = base64_encode($id);
    	$url = strtr($b64, '+/', '-_');
    	return rtrim($url, '=');

    	/*
        $CI = get_instance();
        $CI->load->library('encryption');
        $config = array(
            'cipher' => 'aes-128',
            'mode' => 'cfb',
            'key' => 'Q23$+89CagFBbnbCs?<,x',
            'hmac_digest' => 'sha256',
            'hmac_key' => 'Rack345',
        );
        $CI->encryption->initialize($config);
        $id = $CI->encryption->encrypt($id);
        return bin2hex($id);
        */
    }
}
if (!function_exists('dekripsi_id_url')){
    function dekripsi_id_url($id){
    	$b64 = strtr($id, '-_', '+/');
    	$b64 = base64_decode($b64);
    	if($b64 == false)
    		return '';
    	else
    		return $b64;

    	/*
    	if($id == '')
    		return '';
        if(!ctype_xdigit($id))
            return '';
        if(strlen($id) % 2 == 1)
            return '';
        
        $CI = get_instance();
        $CI->load->library('encryption');
        $config = array(
            'cipher' => 'aes-128',
            'mode' => 'cfb',
            'key' => 'Q23$+89CagFBbnbCs?<,x',
            'hmac_digest' => 'sha256',
            'hmac_key' => 'Rack345',
        );
        $CI->encryption->initialize($config);
        $id = hex2bin($id);
        return $CI->encryption->decrypt($id);
        */
    }
}
if (!function_exists('enkripsi_id_detail')){
    function enkripsi_id_detail($id){
       	return strtr(base64_encode($id), '+/=', '._-');
    }
}
if (!function_exists('dekripsi_id_detail')){
    function dekripsi_id_detail($id){
    	return base64_decode(strtr($id, '._-', '+/='));
    }
}
if (!function_exists('cek_admin')){
	function cek_admin(){
		$CI = get_instance();
		if(!in_array($CI->session->userdata['groupid'], array(1,11,12))){
			redirect('dashboard', 'refresh');
		}
	}
}
if (!function_exists('cek_administrator')){
	function cek_administrator(){
		$CI = get_instance();
		if(!in_array($CI->session->userdata['groupid'], array(1,11))){
			redirect('dashboard', 'refresh');
		}
	}
}
	if(!function_exists('set_date_input')){
		function set_date_input($date){
			if($date == '')
				return '';
			else
				return date('Y-m-d', strtotime($date));
		}
	}
	if(!function_exists('set_date_value')){
		function set_date_value($date){
			if($date == '0000-00-00')
				return '';
			else
				return date('d-m-Y', strtotime($date));
		}
	}
	
?>