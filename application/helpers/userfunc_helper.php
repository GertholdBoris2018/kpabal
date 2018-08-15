<?php
/**
 * Created by PhpStorm.
 * User: Aimon.M
 * Date: 4/3/2015
 * Time: 11:33 AM
 */

if ( ! function_exists('__get_user_session'))
{
    function __get_user_session(){
		$CI =& get_instance();
		$data = array();
		$data['memberIdx'] = $CI->session->userdata(SESSION_DOMAIN . USER_LOGIN_SESSION);
    	$data['username'] = $CI->session->userdata(SESSION_DOMAIN . USER_LOGIN_SESSION . 'username');
        $data['firstname'] = $CI->session->userdata(SESSION_DOMAIN . USER_LOGIN_SESSION . 'firstname');
		$data['lastname'] = $CI->session->userdata(SESSION_DOMAIN . USER_LOGIN_SESSION . 'lastname');
		$data['regdate'] = $CI->session->userdata(SESSION_DOMAIN . USER_LOGIN_SESSION . 'regdate');
		$data['image'] = $CI->session->userdata(SESSION_DOMAIN . USER_LOGIN_SESSION . 'image');

        return $data;
	}
}


