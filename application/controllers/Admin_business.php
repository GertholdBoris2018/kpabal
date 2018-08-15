<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_business extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->model('login_model');
        $this->load->model('category_model');
        $this->load->model('basis_model');
        $this->load->model('member_model');
        $this->load->model('business_model');
    }
    
    public function __generate_header_data($open_title = "Management")
    {
        $header_data['memberIdx'] = $this->session->userdata(SESSION_DOMAIN . ADMIN_LOGIN_SESSION);
        $header_data['first_name'] = $this->session->userdata(SESSION_DOMAIN . ADMIN_LOGIN_SESSION . 'firstname');
        $header_data['last_name'] = $this->session->userdata(SESSION_DOMAIN . ADMIN_LOGIN_SESSION . 'lastname');
        $header_data['open'] = $open_title;
        $header_data['categories'] = $this->category_model->get_tree_rows("admin_menu", true);

        return $header_data;
    }

    public function index($category = "")
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/business";
        $header_data['additional_css'] = [
                "assets/vendors/custom/datatables/datatables.bundle.css",
            ];
        $footer_data['additional_js'] = [
                "assets/vendors/custom/datatables/datatables.bundle.js",
            ];

        $data['categories'] = $this->category_model->get_tree_rows("business_category");
        $data['businesses'] = $this->business_model->get_items($this->category_model->list_data("business_category"), $this->category_model->get_tree_rows("address_state"), $this->member_model->list_data(), $category);
        $data['categoryIdx'] = $category;

        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/business/index", $data);
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/business/index_js");
    }

    public function edit($id = 0)
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/business";
        $header_data['additional_css'] = [
            ];
        $footer_data['additional_js'] = [
            ];

        $data['id'] = $id;
        $data['business'] = $this->business_model->get_item($id);
        $data['states'] = $this->category_model->get_tree_rows("address_state");
        $data['categories'] = $this->category_model->get_tree_rows("business_category");

        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/business/edit_index", $data);
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/business/edit_index_js", $data);
    }

    public function edit_option($id = 0)
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/business";
        $header_data['additional_css'] = [
            ];
        $footer_data['additional_js'] = [
            ];

        $data['id'] = $id;
        $business = $this->business_model->get_item($id);
        $data['business'] = $business;
        $categoryIdx = $business->categoryIdx;
        $options = $this->basis_model->get_categories("business_option", $categoryIdx);
        $options_detail = $this->business_model->get_options($id);
        foreach ($options as $key => $option) {
            $option_id = $option->id;
            if(isset($options_detail[$option_id]))
                $options[$key]->option_value = $options_detail[$option_id];
        }
        $data['options'] = $options;

        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/business/edit_option_index", $data);
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/business/edit_option_index_js", $data);
    }

    public function option_update()
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            echo $this->business_model->save_option_data($_POST);
        }
    }

    public function update()
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            echo $this->business_model->save_data($_POST, $this->session->userdata(SESSION_DOMAIN . ADMIN_LOGIN_SESSION));
        }        
    }

}
