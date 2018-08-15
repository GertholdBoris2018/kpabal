<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * EMTS General Class
 *
 * We made common functions which are use general different part of the project
 *
 */
class General {

    protected $ci;

    private $tableMEMBERS = 'member';
    private $tableSETTING = 'site_setting';

    function __construct($config = array()) {
        $this->ci = & get_instance();

        $query = $this->ci->db->get($this->tableSETTING);
        $result = $query->result();
        foreach ($result as $setting_info) {
            $setting_code = $setting_info->setting_code;
            $setting_value = $setting_info->setting_value;
            defined($setting_code)  OR define($setting_code, $setting_value);
        }
    }

    public function admin_controlpanel_logged_in() {

        if ($this->ci->session->userdata(SESSION_DOMAIN . ADMIN_LOGIN_SESSION) && $this->ci->session->userdata(SESSION_DOMAIN . ADMIN_LOGIN_SESSION . 'username')) {
            $admin_id = $this->ci->session->userdata(SESSION_DOMAIN . ADMIN_LOGIN_SESSION);
            $username = $this->ci->session->userdata(SESSION_DOMAIN . ADMIN_LOGIN_SESSION . 'username');            
        } else {
            return FALSE;
        }

        $query = $this->ci->db->get_where($this->tableMEMBERS, array('memberIdx' => $admin_id, 'user_id' => $username, 'is_admin' => 1, 'member_status' => 1), 1);        
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return FALSE;
        }
    }

	public function user_logged_in() {
		return $this->frontend_controlpanel_logged_in();
	}

    public function frontend_controlpanel_logged_in() {

        if ($this->ci->session->userdata(SESSION_DOMAIN . USER_LOGIN_SESSION) && $this->ci->session->userdata(SESSION_DOMAIN . USER_LOGIN_SESSION . 'username')) {
            $customer_id = $this->ci->session->userdata(SESSION_DOMAIN . USER_LOGIN_SESSION);
            $username = $this->ci->session->userdata(SESSION_DOMAIN . USER_LOGIN_SESSION . 'username');            
        } else {
            return FALSE;
        }

        $query = $this->ci->db->get_where($this->tableMEMBERS, array('memberIdx' => $customer_id, 'user_id' => $username, 'is_admin' => 0, 'member_status' => 1), 1);        
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return FALSE;
        }
    }
}

// END Template class

