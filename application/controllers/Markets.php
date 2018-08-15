<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Markets extends CI_Controller {

	function __construct() {
		parent::__construct();

        $this->load->helper(array('form', 'url', 'userfunc'));
        $this->load->library('form_validation');
        $this->load->model('category_model');
        $this->load->model('product_model');
	}
	
	public function index()
	{
        $data['selected'] = 'market';
        //get category
        $category = $this->input->post('category');
        $keyword = $this->input->post('keyword');
        $data['loggedinuser'] = __get_user_session();
        $data['selected_cat'] = $category;
        $data['selected_key'] = $keyword;
        $data['categories'] = $this->category_model->get_tree_rows("products_category");
        $data['products'] = $this->product_model->get_items($this->category_model->list_data("products_category"), $category, $keyword);
        $this->load->view('frontend/common/header',$data);
        $this->load->view('frontend/markets/index',$data);
        $this->load->view('frontend/common/footer');
        $this->load->view('frontend/markets/index_js');
    }
    
}