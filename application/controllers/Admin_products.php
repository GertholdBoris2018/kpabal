<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_products extends CI_Controller {

	function __construct() {
		parent::__construct();

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->model('login_model');
        $this->load->model('category_model');
        $this->load->model('basis_model');
        $this->load->model('product_model');
	}
	
    public function __generate_header_data($open_title = "Management")
    {
        $header_data['productIdx'] = $this->session->userdata(SESSION_DOMAIN . ADMIN_LOGIN_SESSION);
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
        $header_data['menuURL'] = "/products";
        $header_data['additional_css'] = [
                "assets/vendors/custom/datatables/datatables.bundle.css",
            ];
        $footer_data['additional_js'] = [
                "assets/vendors/custom/datatables/datatables.bundle.js",
            ];

        $data['categories'] = $this->category_model->get_tree_rows("products_category");
        $data['products'] = $this->product_model->get_items($this->category_model->list_data("products_category"), $category, "");
        $data['categoryIdx'] = $category;

        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/product/index", $data);
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/product/index_js");
	}

    public function edit($id = 0)
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }

        $header_data = $this->__generate_header_data();
        $header_data['menuURL'] = "/products";
        $header_data['additional_css'] = [
            ];
        $footer_data['additional_js'] = [
            ];

        $data['id'] = $id;
        $data['product'] = $this->product_model->get_item($id);
        $data['categories'] = $this->category_model->get_tree_rows("products_category");

        $this->load->view("admin/common/header", $header_data);
        $this->load->view("admin/product/edit_index", $data);
        $this->load->view("admin/common/footer", $footer_data);
        $this->load->view("admin/product/edit_index_js", $data);
    }

    public function update()
    {
        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            echo $this->product_model->save_data($_POST);
        }        
    }

    public function upload_avatar($id = 0)
    {

        if (!$this->general->admin_controlpanel_logged_in()) {
            redirect(ADMIN_PUBLIC_DIR);
        }
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $target_file = FCPATH.PROJECT_PRODUCT_DIR."/product_";
            move_uploaded_file($_FILES["uploadedFile"]["tmp_name"], $target_file.$id."_1.jpg");
        }
    }

}
