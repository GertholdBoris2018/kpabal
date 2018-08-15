<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper(array('form', 'url', 'userfunc'));
        $this->load->library('form_validation');
		$this->load->model('login_model');
		$this->load->model('member_model');
		$this->load->model('basis_model');
		$this->load->model('board_model');
		$this->load->model('category_model');
		$this->load->model('business_model');
		$this->load->model('product_model');
	}

	public function __generate_header_data($caption = "") {
		$header_data = [];

		$header_data['loggedinuser'] = __get_user_session();
		$header_data['caption'] = $caption;
		$header_data['categories'] = $this->category_model->get_tree_rows("site_menu", true);
		$header_data['blog_categories'] = $this->category_model->get_tree_rows("board_category", true);
		$header_data['cart'] = new \stdClass();
		$header_data['cart']->items = [];

		return $header_data;
	}

	public function __generate_footer_data() {
		$footer_data = [];
		$footer_data['blog_categories'] = $this->category_model->get_rows("board_category");
		$footer_data['recent_business'] = $this->business_model->recent_business();
		$footer_data['total_business'] = $this->business_model->total_count();
		$footer_data['total_client'] = $footer_data['total_business'] + $this->member_model->total_count();

		return $footer_data;
	}
	
	public function index()
	{
		$header_data = $this->__generate_header_data($caption);
		$footer_data = $this->__generate_footer_data();
		$data['sliders'] = $this->basis_model->get_categories("site_contents", "01", true);

		$data['products'] = $this->product_model->get_recent_items($this->category_model->list_data("products_category"));
        $arr_categories = $this->category_model->list_data("board_category", true);
        $data['articles'] = $this->board_model->get_suggest_articles($arr_categories, $this->member_model->list_data(), "");

        $jobs = [];
        $job = new \stdClass();
        $job->title = "Parallax Support";
        $job->description = "Display your Content attractively using Parallax Sections that have unlimited customizable areas.";
        for($i=0; $i<9; $i++)
        	$jobs[] = $job;

        $data['jobs'] = $jobs;
		

        $footer_data['additional_js'] = [
                "https://code.jquery.com/ui/1.12.1/jquery-ui.js",
        	];
        	
		$this->load->view('kpabal/common/header',$header_data);
        $this->load->view('kpabal/index', $data);
        $this->load->view('kpabal/common/footer', $footer_data);
	}	
	
	public function index_2()
	{
		$data['selected'] = 'home';
		$data['loggedinuser'] = __get_user_session();
		$this->load->view('frontend/common/header',$data);
        $this->load->view('frontend/home');
        $this->load->view('frontend/common/footer');
	}	

	public function login(){
		if ($this->general->frontend_controlpanel_logged_in()) {
            redirect('/');
        }
		$header_data = array('selected' => 'login');
		$this->load->view('frontend/common/header',$header_data);
        $this->load->view('frontend/user/login',$data);
		$this->load->view('frontend/common/footer');
	}

	public function register(){
		if ($this->general->frontend_controlpanel_logged_in()) {
            redirect('/');
        }
		// if ($this->input->server('REQUEST_METHOD') === 'POST') {
			
		// 	$rlt = $this->member_model->save_cdata($_POST);
			
		// 	if($rlt == -1){
		// 		$this->session->set_flashdata('register_message', 'User already exist');
		// 		$data['result'] = 0;
		// 	}
		// 	else{
		// 		$this->session->set_flashdata('register_message', 'You successfully registered!');
		// 		$data['result'] = 1;
		// 	}
		// }
		$header_data = array('selected' => 'register');
		//$data['message'] = $this->session->flashdata('register_message');
		$this->load->view('frontend/common/header',$header_data);
        $this->load->view('frontend/user/register',$data);
		$this->load->view('frontend/common/footer');
		$this->load->view("frontend/user/register_js", $data);
	}
	
	public function logout() {
        $this->session->unset_userdata(SESSION_DOMAIN . USER_LOGIN_SESSION);
        $this->session->unset_userdata(SESSION_DOMAIN . USER_LOGIN_SESSION . 'username');
        $this->session->unset_userdata(SESSION_DOMAIN . USER_LOGIN_SESSION . 'firstname');
        $this->session->unset_userdata(SESSION_DOMAIN . USER_LOGIN_SESSION . 'lastname');
        $this->session->unset_userdata(SESSION_DOMAIN . USER_LOGIN_SESSION . 'regdate');

        $this->session->set_flashdata('login_message', '');
        $this->_clean_cookie_();
        redirect('/');
        exit;
	}

	public function _clean_cookie_() {
        $this->load->helper('cookie');
        delete_cookie(SESSION_DOMAIN . USER_LOGIN_SESSION);
        delete_cookie(SESSION_DOMAIN . USER_LOGIN_SESSION . 'email');
	}
	
	public function profile(){
		if (!$this->general->frontend_controlpanel_logged_in()) {
            redirect(FRONTEND_LOGIN_PUBLIC_DIR);
		}
		$data['selected'] = 'home';
		$data['loggedinuser'] = __get_user_session();
		$this->load->view('frontend/common/header',$data);
        $this->load->view('frontend/user/profile',$data);
		$this->load->view('frontend/common/footer');
		$this->load->view("frontend/user/profile_js", $data);
	}

	public function forgot_password(){
		
		$data['selected'] = 'forgotpass';
		$this->load->view('frontend/common/header',$data);
        $this->load->view('frontend/user/forgotpassword',$data);
		$this->load->view('frontend/common/footer');
		$this->load->view("frontend/user/forgotpassword_js", $data);
	}

}
