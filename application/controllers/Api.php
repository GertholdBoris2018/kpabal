<?php
use Restserver\Libraries\REST_Controller;

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Api extends REST_Controller {

	function __construct() {
		parent::__construct();

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('google');
        $this->load->model('login_model');
        $this->load->model('category_model');
        $this->load->model('basis_model');
        $this->load->model('member_model');
        $this->load->model('business_model');
        $this->load->model('board_model');
        $this->load->model('product_model');
        $this->load->model('subscriber_model');
	}
	
	public function index_get()
	{
        $google_login_url = $this->google->get_login_url();
        echo $google_login_url;
        exit();
	}

    // Address State List
    public function address_state_get()
    {
        $states = $this->category_model->get_tree_rows("address_state", true);
        $this->response([
            "status" => true,
            "result" => $states
        ]);
    }

    // Business Category List
    public function business_category_get()
    {
        $categories = $this->category_model->get_tree_rows("business_category", true);
        $this->response([
            "status" => true,
            "result" => $categories
        ]);
    }

    // Business Options for Category List
    public function business_options_get($categoryIdx="")
    {
        $options = $this->basis_model->get_categories("business_option", $categoryIdx, true);

        $this->response([
            "status" => true,
            "result" => $options
        ]);
    }

    // Business Information
    public function business_info_get($id="")
    {
        $member = $this->general->user_logged_in();
        $memberIdx = $member->memberIdx;

        $business = $this->business_model->get_item($id);
        $options = $this->basis_model->get_categories("business_option", $business->categoryIdx, true);
        $options_detail = $this->business_model->get_options($id);
        foreach ($options as $key => $option) {
            $option_id = $option->id;
            if(isset($options_detail[$option_id]))
                $options[$key]->option_value = $options_detail[$option_id];
        }
        $business->favorite = $this->business_model->is_favorite($id, $memberIdx);
        $business->options = $options;

        $this->response([
            "status" => true,
            "result" => $business
        ]);
    }

    // Board Category List
    public function board_category_get()
    {
        $categories = $this->category_model->get_tree_rows("board_category", true);
        $this->response([
            "status" => true,
            "result" => $categories
        ]);
    }

    // Help List
    public function help_list_get()
    {
        $help = $this->basis_model->get_integrated_list("site_help_category", "site_help", true);
        $this->response([
            "status" => true,
            "result" => $help
        ]);
    }

    // User Login
    public function user_login_post()
    {
        $user_id = $this->post("user_id");
        $user_password = $this->post("user_password");

        $config = array(
                array(
                        'field' => 'user_id',
                        'label' => 'User ID',
                        'rules' => 'required'
                ),
                array(
                        'field' => 'user_password',
                        'label' => 'Password',
                        'rules' => 'required',
                        'errors' => array(
                                'required' => 'You must provide a %s.',
                        ),
                ),
        );
        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() == FALSE)
            return $this->response([
                "status" => false,
                "result" => validation_errors(),
            ]);

        $member = $this->member_model->get_record(["user_id" => $user_id]);
        if(!($member))
            return $this->response([
                "status" => false,
                "result" => "The user id doesn't exists",
            ]);

        $secure_code = USER_LOGIN_SECURE_CODE;
        $pwd_hash = hash('sha512', $user_password . $secure_code . $member->user_salt);

        if (strcmp($member->user_password, $pwd_hash))
            return $this->response([
                "status" => false,
                "result" => "The user id and password are not matched",
            ]);

        if($member->member_status == 0)
            return $this->response([
                "status" => false,
                "result" => "You are still pending, please confirm your email inbox and activate your account.",
            ]);

        if($member->member_status == 2)
            return $this->response([
                "status" => false,
                "result" => "Your account was deactivated. Please contact to support.",
            ]);

        if($member->member_status == 3)
            return $this->response([
                "status" => false,
                "result" => "Your account was restricted. Please contact to support.",
            ]);

        if($member->member_status == 4)
            return $this->response([
                "status" => false,
                "result" => "Your account was blocked. Please contact to support.",
            ]);

        $this->login_model->store_customer_login( $member );
        $this->member_model->update_record(["last_login_date" => date("Y-m-d H:i:s"), "last_login_ip" => $_SERVER["REMOTE_ADDR"]], ["user_id" => $user_id]);
        $subscriber = $this->subscriber_model->get_record(["email" => $member->user_email]);
        $ret = ["email" => $member->user_email, "subscriber" => ( $subscriber ) ];
        $this->response([
            "status" => true,
            "result" => $ret,
        ]);
    }

    // User Logout
    public function user_logout_get()
    {
        $this->login_model->user_logout();
        redirect("/", 'refresh');
    }

    // User Register
    public function user_register_post()
    {
        $user_id = $this->post("user_id");
        $user_password = $this->post("user_password");
        $user_email = $this->post("user_email");

        $config = array(
                array(
                        'field' => 'user_id',
                        'label' => 'User ID',
                        'rules' => array(
                            'required',
                            array('username_callable', array($this->member_model, 'valid_user_id')),
                        ),
                        'errors' => array(
                                'username_callable' => '%s was already used',
                        ),
                ),
                array(
                        'field' => 'user_password',
                        'label' => 'Password',
                        'rules' => 'required|min_length[8]',
                        'errors' => array(
                                'required' => 'You must provide a %s.',
                        ),
                ),
                array(
                        'field' => 'confirm_password',
                        'label' => 'Confirm Password',
                        'rules' => 'required|matches[user_password]',
                        'errors' => array(
                                'required' => 'You must provide a %s.',
                        ),
                ),
                array(
                        'field' => 'user_email',
                        'label' => 'Email Address',
                        'rules' => array(
                            'required',
                            'valid_email',
                            array('usermail_callable', array($this->member_model, 'valid_user_email')),
                        ),
                        'errors' => array(
                                'usermail_callable' => '%s was already used',
                        ),
                ),
        );

        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() == FALSE)
            return $this->response([
                "status" => false,
                "result" => validation_errors(),
            ]);

        $activation_code = md5($user_id." ".time());

        $member = [
                "user_id" => $user_id,
                "user_password" => $user_password,
                "user_email" => $user_email,
                "activation_code" => $activation_code,
                "member_status" => 0,
            ];

        $this->member_model->save_record($member);

        $mail_template = $this->basis_model->get_record("site_email_template", ["mail_code" => "user_activate"]);
        if($mail_template) {

            $this->email->from('support@kapbal.com', 'Support');
            $this->email->to($user_email);
            $this->email->cc('');
            $this->email->bcc('');        

            $this->email->subject($mail_template->mail_title);
            $this->email->message(str_replace("{activation_code}", $this->config->item('base_url')."api/user_activate/".$activation_code, $mail_template->mail_content) );
            $this->email->set_mailtype("html");
            
            if ( ! $this->email->send())
            {
                return $this->response([
                    "status" => false,
                    "result" => "Email sender issue.",
                ]);
            }
        }

        $this->response([
            "status" => true,
            "result" => "User registration success. Please confirm your email inbox",
        ]);
    }

    // User Activation Mail Send
    public function user_activate_post()
    {
        $user_email = $this->post("user_email");

        $config = array(
                array(
                        'field' => 'user_email',
                        'label' => 'Email Address',
                        'rules' => array(
                            'required',
                            'valid_email',
                            array('usermail_callable', array($this->member_model, 'invalid_user_email')),
                        ),
                        'errors' => array(
                                'usermail_callable' => '%s is not in our database',
                        ),
                ),
        );

        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() == FALSE)
            return $this->response([
                "status" => false,
                "result" => validation_errors(),
            ]);


        $member = $this->member_model->get_record(["user_email" => $user_email]);
        $user_id = $member->user_id;
        $activation_code = md5($user_id." ".time());

        $this->member_model->update_record(["activation_code" => $activation_code], ["user_id" => $user_id]);

        $mail_template = $this->basis_model->get_record("site_email_template", ["mail_code" => "user_activate"]);
        if($mail_template) {

            $this->email->from('support@kapbal.com', 'Support');
            $this->email->to($user_email);
            $this->email->cc('');
            $this->email->bcc('');        

            $this->email->subject($mail_template->mail_title);
            $this->email->message(str_replace("{activation_code}", $this->config->item('base_url')."api/user_activate/".$activation_code, $mail_template->mail_content) );
            $this->email->set_mailtype("html");
            
            if ( ! $this->email->send())
            {
                return $this->response([
                    "status" => false,
                    "result" => "Email sender issue.",
                ]);
            }
        }

        $this->response([
            "status" => true,
            "result" => "User Activation Mail send success. Please confirm your email inbox",
        ]);
    }

    // User Activation
    public function user_activate_get($activation_code = "")
    {
        if($activation_code == "")
            return $this->response([
                "status" => false,
                "result" => "Activation Code can't be empty",
            ]);

        $member = $this->member_model->get_record(["activation_code" => $activation_code]);
        if(!($member)) 
            return $this->response([
                "status" => false,
                "result" => "Activation Code is incorrect",
            ]);

        $this->member_model->update_record(["activation_code" => "", "member_status" => 1, "activate_date" => date("Y-m-d H:i:s")], ["memberIdx" => $member->memberIdx]);

        redirect("/", 'refresh');
    }

    // User Forgotten Password Mail Send
    public function user_forgotten_post()
    {
        $user_email = $this->post("user_email");

        $config = array(
                array(
                        'field' => 'user_email',
                        'label' => 'Email Address',
                        'rules' => array(
                            'required',
                            'valid_email',
                            array('usermail_callable', array($this->member_model, 'invalid_user_email')),
                        ),
                        'errors' => array(
                                'usermail_callable' => '%s is not in our database',
                        ),
                ),
        );

        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() == FALSE)
            return $this->response([
                "status" => false,
                "result" => validation_errors(),
            ]);


        $member = $this->member_model->get_record(["user_email" => $user_email]);
        $user_id = $member->user_id;
        $forgot_password_code = md5($user_id." ".time());

        $this->member_model->update_record(["forgot_password_code" => $forgot_password_code], ["user_id" => $user_id]);

        $mail_template = $this->basis_model->get_record("site_email_template", ["mail_code" => "user_forgotten"]);
        if($mail_template) {

            $this->email->from('support@kapbal.com', 'Support');
            $this->email->to($user_email);
            $this->email->cc('');
            $this->email->bcc('');        

            $this->email->subject($mail_template->mail_title);
            $this->email->message(str_replace("{forgot_password_code}", $this->config->item('base_url')."api/user_forgotten/".$forgot_password_code, $mail_template->mail_content) );
            $this->email->set_mailtype("html");
            
            if ( ! $this->email->send())
            {
                return $this->response([
                    "status" => false,
                    "result" => "Email sender issue.",
                ]);
            }
        }

        $this->response([
            "status" => true,
            "result" => "User Password Recovery Mail send success. Please confirm your email inbox",
        ]);
    }

    // User Forgotten Password Check
    public function user_forgotten_get($forgot_password_code = "")
    {
        if($forgot_password_code == "")
            return $this->response([
                "status" => false,
                "result" => "Recovery Code can't be empty",
            ]);

        $member = $this->member_model->get_record(["forgot_password_code" => $forgot_password_code]);
        if(!($member)) 
            return $this->response([
                "status" => false,
                "result" => "Recovery Code is incorrect",
            ]);

        // Password Recovery Page View
        // redirect("/", 'refresh');
        $data['selected'] = 'resetpass';
		$data['code'] = $forgot_password_code;
		$this->load->view('frontend/common/header',$data);
        $this->load->view('frontend/user/resetpassword',$data);
		$this->load->view('frontend/common/footer');
		$this->load->view("frontend/user/resetpassword_js", $data);
    }

    // User Password Reset
    public function user_forgotten_reset_post()
    {
        $forgot_password_code = $this->post("forgot_password_code");
        $user_password = $this->post("user_password");

        $config = array(
                array(
                        'field' => 'forgot_password_code',
                        'label' => 'Recovery Code',
                        'rules' => 'required',
                ),
                array(
                        'field' => 'user_password',
                        'label' => 'Password',
                        'rules' => 'required|min_length[8]',
                        'errors' => array(
                                'required' => 'You must provide a %s.',
                        ),
                ),
        );

        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() == FALSE)
            return $this->response([
                "status" => false,
                "result" => validation_errors(),
            ]);

        if($forgot_password_code == "")
            return $this->response([
                "status" => false,
                "result" => "Recovery Code can't be empty",
            ]);

        $member = $this->member_model->get_record(["forgot_password_code" => $forgot_password_code]);
        if(!($member)) 
            return $this->response([
                "status" => false,
                "result" => "Recovery Code is incorrect",
            ]);


        $this->member_model->update_record(["forgot_password_code" => "", "forgot_password_date" => date("Y-m-d H:i:s")], ["memberIdx" => $member->memberIdx]);
        $this->member_model->reset_password($member->memberIdx, $user_password);
        
        return $this->response([
            "status" => true,
            "result" => "User password changed",
        ]);
    }

    // User Email Change Mail Send
    public function user_email_post()
    {
        $user_email = $this->post("user_email");

        $config = array(
                array(
                        'field' => 'user_email',
                        'label' => 'Email Address',
                        'rules' => array(
                            'required',
                            'valid_email',
                            array('usermail_callable', array($this->member_model, 'valid_user_email')),
                        ),
                        'errors' => array(
                                'usermail_callable' => '%s was already used',
                        ),
                ),
        );

        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() == FALSE)
            return $this->response([
                "status" => false,
                "result" => validation_errors(),
            ]);

        $member = $this->general->user_logged_in();

        $email_change_code = md5($member->user_id." ".time());

        $this->member_model->update_record(["email_change_code" => $email_change_code, "new_user_email" => $user_email], ["user_id" => $member->user_id]);

        $mail_template = $this->basis_model->get_record("site_email_template", ["mail_code" => "email_change"]);
        if($mail_template) {

            $this->email->from('support@kapbal.com', 'Support');
            $this->email->to($user_email);
            $this->email->cc('');
            $this->email->bcc('');        

            $this->email->subject($mail_template->mail_title);
            $this->email->message(str_replace("{email_change_code}", $this->config->item('base_url')."api/user_email/".$email_change_code, $mail_template->mail_content) );
            $this->email->set_mailtype("html");
            
            if ( ! $this->email->send())
            {
                return $this->response([
                    "status" => false,
                    "result" => "Email sender issue.",
                ]);
            }
        }

        $this->response([
            "status" => true,
            "result" => "User Activation Mail send success. Please confirm your email inbox",
        ]);
    }

    // User Email Change Check
    public function user_email_get($email_code = "")
    {

        if($email_code == "")
            return $this->response([
                "status" => false,
                "result" => "Activation Code can't be empty",
            ]);

        $member = $this->member_model->get_record(["email_change_code" => $email_code]);
        if(!($member)) 
            return $this->response([
                "status" => false,
                "result" => "Activation Code is incorrect",
            ]);

        $this->member_model->update_record(["email_change_code" => "", "email_change_date" => date("Y-m-d H:i:s"), 'user_email' => $member->new_user_email, "new_user_email" => ""], ["memberIdx" => $member->memberIdx]);

        return $this->response([
            "status" => true,
            "result" => "User Email address changed",
        ]);
    }

    // User Deactivate
    public function user_deactivate_get()
    {
        $member = $this->general->user_logged_in();

        $this->subscriber_model->remove_record(["email" => $member->user_email]);
        $this->member_model->update_record(["member_status" => 2], ["user_id" => $member->user_id]);

        $this->login_model->user_logout();

        redirect("/", 'refresh');
    }

    // User Information Update
    public function user_information_post()
    {
        $member = $this->general->user_logged_in();

        $config = array(
                array(
                        'field' => 'first_name',
                        'label' => 'First Name',
                        'rules' => 'required',
                ),
                array(
                        'field' => 'last_name',
                        'label' => 'Last Name',
                        'rules' => 'required',
                ),
                array(
                        'field' => 'gender',
                        'label' => 'Gender',
                        'rules' => 'required|integer|greater_than_equal_to[0]|less_than_equal_to[1]',
                ),
                array(
                        'field' => 'dob',
                        'label' => 'Day Of Birthday',
                        'rules' => 'required',
                ),
                array(
                        'field' => 'city',
                        'label' => 'City Name',
                        'rules' => 'required',
                ),
                array(
                        'field' => 'stateIdx',
                        'label' => 'State',
                        'rules' => 'required',
                ),
                array(
                        'field' => 'postal_code',
                        'label' => 'Postal Code',
                        'rules' => 'required',
                ),
                array(
                        'field' => 'phone',
                        'label' => 'Phone Number',
                        'rules' => 'required',
                ),
        );

        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() == FALSE)
            return $this->response([
                "status" => false,
                "result" => validation_errors(),
            ]);

        $this->member_model->update_data($_POST, ["memberIdx" => $member->memberIdx]);

        return $this->response([
            "status" => true,
            "result" => "User Information Updated",
        ]);
    }

    // User Password Change
    public function user_password_post()
    {
        $old_password = $this->post("old_password");
        $user_password = $this->post("user_password");

        $config = array(
                array(
                        'field' => 'old_password',
                        'label' => 'Old Password',
                        'rules' => 'required|min_length[8]',
                ),
                array(
                        'field' => 'user_password',
                        'label' => 'New Password',
                        'rules' => 'required|min_length[8]',
                ),
        );

        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() == FALSE)
            return $this->response([
                "status" => false,
                "result" => validation_errors(),
            ]);

        $member = $this->general->user_logged_in();

        $secure_code = USER_LOGIN_SECURE_CODE;
        $pwd_hash = hash('sha512', $old_password . $secure_code . $member->user_salt);

        if (strcmp($member->user_password, $pwd_hash))
            return $this->response([
                "status" => false,
                "result" => "Old password is incorrect",
            ]);
        
        $this->member_model->reset_password($member->memberIdx, $user_password);

        return $this->response([
            "status" => true,
            "result" => "Password changed",
        ]);
    }

    // User Avatar Update
    public function user_avatar_post()
    {
        $member = $this->general->user_logged_in();
        $memberIdx = $member->memberIdx;
        
        $target_file = FCPATH.PROJECT_AVATAR_DIR."/user_";
        move_uploaded_file($_FILES["uploadedFile"]["tmp_name"], $target_file.$memberIdx."_1.jpg");
    }

    // User Subscriber Register
    public function user_subscriber_post()
    {
        $email = $this->post("email");

        $config = array(
                array(
                        'field' => 'email',
                        'label' => 'Email Address',
                        'rules' => array(
                            'required',
                            'valid_email',
                            array('usermail_callable', array($this->subscriber_model, 'valid_user_email')),
                        ),
                        'errors' => array(
                                'usermail_callable' => '%s was already subscribed',
                        ),
                ),
        );

        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() == FALSE)
            return $this->response([
                "status" => false,
                "result" => validation_errors(),
            ]);

        $this->subscriber_model->save_record(["email" => $email, "subscribe_date" => date("Y-m-d H:i:s")]);

        return $this->response([
            "status" => true,
            "result" => "Subscriber registered successfully.",
        ]);
    }

    // Suggested Article List
    public function article_suggested_get($categoryIdx = "")
    {
        $arr_categories = $this->category_model->list_data("board_category", true);
        $articles = $this->board_model->get_suggest_articles($arr_categories, $this->member_model->list_data(), $categoryIdx);

        return $this->response([
            "status" => true,
            "result" => $articles,
        ]);
    }

    // Article Search & List
    public function article_list_post($categoryIdx = "", $page_number = 0, $offset = 10)
    {
        $search_key = $this->post("keyword");
        $arr_categories = $this->category_model->list_data("board_category", true);
        $total_count = $this->board_model->search_articles_count($arr_categories, $categoryIdx, $search_key);
        $total_page = 0;
        if($total_count) $total_page = ($total_count - 1 - (($total_count - 1) % $offset)) / $offset + 1;
        $current_page = $page_number;
        $articles = $this->board_model->search_articles($arr_categories, $this->member_model->list_data(), $categoryIdx, $search_key, $page_number, $offset);

        return $this->response([
            "status" => true,
            "total_count" => $total_count,
            "total_page" => $total_page,
            "current_page" => $current_page,
            "result" => $articles,
        ]);
    }

    // My Article List
    public function article_my_list_post($page_number = 0, $offset = 10)
    {
        $member = $this->general->user_logged_in();
        $memberIdx = $member->memberIdx;

        $search_key = $this->post("keyword");
        $arr_categories = $this->category_model->list_data("board_category", true);
        $total_count = $this->board_model->search_my_articles_count($arr_categories, $memberIdx, $search_key);
        $total_page = 0;
        if($total_count) $total_page = ($total_count - 1 - (($total_count - 1) % $offset)) / $offset + 1;
        $current_page = $page_number;
        $articles = $this->board_model->search_my_articles($arr_categories, $this->member_model->list_data(), $memberIdx, $search_key, $page_number, $offset);

        return $this->response([
            "status" => true,
            "total_count" => $total_count,
            "total_page" => $total_page,
            "current_page" => $current_page,
            "result" => $articles,
        ]);
    }

    // Article Info
    public function article_info_get($articleIdx = 0)
    {
        $member = $this->general->user_logged_in();
        $memberIdx = $member->memberIdx;

        $arr_members = $this->member_model->list_data();
        $arr_categories = $this->category_model->list_data("board_category", true);
        $article = $this->board_model->get_article_info($arr_categories, $arr_members, $memberIdx, $articleIdx);
        $article->replies = $this->board_model->get_replies($arr_members, $articleIdx);

        return $this->response([
            "status" => true,
            "result" => $article,
        ]);
    }

    // Article Review
    public function article_review_post($articleIdx = 0)
    {
        $member = $this->general->user_logged_in();
        $memberIdx = $member->memberIdx;

        $good_bad = $this->post("good_bad");
        $status = $this->board_model->register_review($articleIdx, $memberIdx, $good_bad);

        return $this->response([
            "status" => $status,
        ]);
    }

    // Favorite Article Register
    public function article_favorite_post($articleIdx = 0)
    {
        $member = $this->general->user_logged_in();
        $memberIdx = $member->memberIdx;

        $on_off = $this->post("on_off");
        $status = $this->board_model->register_favorite($articleIdx, $memberIdx, $on_off);

        return $this->response([
            "status" => $status,
        ]);
    }

    // Favorite Article List
    public function article_favorite_list_post($page_number = 0, $offset = 10)
    {
        $member = $this->general->user_logged_in();
        $memberIdx = $member->memberIdx;

        $search_key = $this->post("keyword");
        $arr_categories = $this->category_model->list_data("board_category", true);
        $total_count = $this->board_model->search_favorite_articles_count($arr_categories, $memberIdx, $search_key);
        $total_page = 0;
        if($total_count) $total_page = ($total_count - 1 - (($total_count - 1) % $offset)) / $offset + 1;
        $current_page = $page_number;
        $articles = $this->board_model->search_favorite_articles($arr_categories, $this->member_model->list_data(), $memberIdx, $search_key, $page_number, $offset);

        return $this->response([
            "status" => true,
            "total_count" => $total_count,
            "total_page" => $total_page,
            "current_page" => $current_page,
            "result" => $articles,
        ]);
    }

    // Suggested Article List
    public function business_suggested_get($categoryIdx = "")
    {
        $arr_categories = $this->category_model->list_data("business_category", true);
        $businesses = $this->business_model->get_suggest_businesses($arr_categories, $this->category_model->get_tree_rows("address_state"), $this->member_model->list_data(), $categoryIdx);

        return $this->response([
            "status" => true,
            "result" => $businesses,
        ]);
    }

    // Business List
    public function business_list_post($categoryIdx = "", $page_number = 0, $offset = 10)
    {
        $search_key = $this->post("keyword");
        $arr_categories = $this->category_model->list_data("business_category", true);
        $total_count = $this->business_model->search_business_count($arr_categories, $categoryIdx, $search_key);
        $total_page = 0;
        if($total_count) $total_page = ($total_count - 1 - (($total_count - 1) % $offset)) / $offset + 1;
        $current_page = $page_number;
        $businesses = $this->business_model->search_business($arr_categories, $this->category_model->get_tree_rows("address_state"), $this->member_model->list_data(), $categoryIdx, $search_key, $page_number, $offset);

        return $this->response([
            "status" => true,
            "total_count" => $total_count,
            "total_page" => $total_page,
            "current_page" => $current_page,
            "result" => $businesses,
        ]);
    }

    // My Business List
    public function business_my_list_post($page_number = 0, $offset = 10)
    {
        $member = $this->general->user_logged_in();
        $memberIdx = $member->memberIdx;

        $search_key = $this->post("keyword");
        $arr_categories = $this->category_model->list_data("business_category", true);
        $total_count = $this->business_model->search_my_business_count($arr_categories, $memberIdx, $search_key);
        $total_page = 0;
        if($total_count) $total_page = ($total_count - 1 - (($total_count - 1) % $offset)) / $offset + 1;
        $current_page = $page_number;
        $businesses = $this->business_model->search_my_business($arr_categories, $this->category_model->get_tree_rows("address_state"), $this->member_model->list_data(), $memberIdx, $search_key, $page_number, $offset);

        return $this->response([
            "status" => true,
            "total_count" => $total_count,
            "total_page" => $total_page,
            "current_page" => $current_page,
            "result" => $businesses,
        ]);
    }

    // Favorite Business Register
    public function business_favorite_post($business_id = 0)
    {
        $member = $this->general->user_logged_in();
        $memberIdx = $member->memberIdx;

        $on_off = $this->post("on_off");
        $status = $this->business_model->register_favorite($business_id, $memberIdx, $on_off);

        return $this->response([
            "status" => $status,
        ]);
    }

    // Favorite Business List
    public function business_favorite_list_post($page_number = 0, $offset = 10)
    {
        $member = $this->general->user_logged_in();
        $memberIdx = $member->memberIdx;

        $search_key = $this->post("keyword");
        $arr_categories = $this->category_model->list_data("business_category", true);
        $total_count = $this->business_model->search_favorite_business_count($arr_categories, $memberIdx, $search_key);
        $total_page = 0;
        if($total_count) $total_page = ($total_count - 1 - (($total_count - 1) % $offset)) / $offset + 1;
        $current_page = $page_number;
        $businesses = $this->business_model->search_favorite_business($arr_categories, $this->category_model->get_tree_rows("address_state"), $this->member_model->list_data(), $memberIdx, $search_key, $page_number, $offset);

        return $this->response([
            "status" => true,
            "total_count" => $total_count,
            "total_page" => $total_page,
            "current_page" => $current_page,
            "result" => $businesses,
        ]);
    }

    // Article Post
    public function article_post_post($articleIdx = 0)
    {
        $config = array(
                array(
                        'field' => 'article_title',
                        'label' => 'title',
                        'rules' => 'required',
                ),
                array(
                        'field' => 'article_content',
                        'label' => 'Content',
                        'rules' => 'required',
                ),
                array(
                        'field' => 'categoryIdx',
                        'label' => 'Category',
                        'rules' => 'required',
                ),
        );

        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() == FALSE)
            return $this->response([
                "status" => false,
                "result" => validation_errors(),
            ]);

        $member = $this->general->user_logged_in();
        $memberIdx = $member->memberIdx;

        $this->board_model->register_article($memberIdx, $articleIdx, $this->post("categoryIdx"), $this->post("article_title"), $this->post("article_content"));

        return $this->response([
            "status" => true,
        ]);
    }

    // Article Reply
    public function article_reply_post($articleIdx = 0, $parent_id = "")
    {
        $config = array(
                array(
                        'field' => 'reply_content',
                        'label' => 'Content',
                        'rules' => 'required',
                ),
        );

        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() == FALSE)
            return $this->response([
                "status" => false,
                "result" => validation_errors(),
            ]);

        $member = $this->general->user_logged_in();
        $memberIdx = $member->memberIdx;

        $this->board_model->register_reply($memberIdx, $articleIdx, $parent_id, $this->post("reply_content"));

        return $this->response([
            "status" => true,
        ]);
    }

    // Business Information Update
    public function business_info_post($business_id = 0)
    {
        $config = array(
                array(
                        'field' => 'categoryIdx',
                        'label' => 'Category',
                        'rules' => 'required',
                        'errors' => array(
                                'required' => 'You must select %s.',
                        ),
                ),
                array(
                        'field' => 'business_name_en',
                        'label' => 'Business Name',
                        'rules' => 'required',
                ),
                array(
                        'field' => 'business_name_ko',
                        'label' => 'Business Name',
                        'rules' => 'required',
                ),
                array(
                        'field' => 'city',
                        'label' => 'City',
                        'rules' => 'required',
                ),
                array(
                        'field' => 'stateIdx',
                        'label' => 'State',
                        'rules' => 'required',
                        'errors' => array(
                                'required' => 'You must select %s.',
                        ),
                ),
                array(
                        'field' => 'phone1',
                        'label' => 'Phone Number',
                        'rules' => 'required',
                ),
                array(
                        'field' => 'email',
                        'label' => 'Email Address',
                        'rules' => 'required',
                ),
        );

        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() == FALSE)
            return $this->response([
                "status" => false,
                "result" => validation_errors(),
            ]);

        $member = $this->general->user_logged_in();
        $memberIdx = $member->memberIdx;

        $business_id = $this->business_model->register_business($memberIdx, $business_id, $_POST);

        return $this->response([
            "status" => true,
            "result" => $business_id,
        ]);
    }

    // Business Detail Update
    public function business_detail_info_post($business_id = 0)
    {
        $member = $this->general->user_logged_in();
        $memberIdx = $member->memberIdx;

        $status = $this->business_model->save_option_datas($memberIdx, $business_id, $_POST);

        return $this->response([
            "status" => $status,
        ]);
    }

    public function google_auth_callback_get()
    {
        $google_data = $this->google->validate();

        print_r($google_data);
        exit();
    }

    public function get_fb_contents($url) {
        $curl = curl_init();
        curl_setopt( $curl, CURLOPT_URL, $url );
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false );
        $response = curl_exec( $curl );
        curl_close( $curl );
        return $response;
    }

    public function facebook_login_callback_get()
    {
        // https://graph.facebook.com/oauth/authorize?client_id=227098387948744&redirect_uri=https://www.dragonstar.xyz/topstar/fb/check_login.php&scope=email,user_birthday

        if (isset($_GET['code']) AND !empty($_GET['code'])) {
            $code = $_GET['code'];
            parse_str($this->get_fb_contents("https://graph.facebook.com/oauth/access_token?client_id=227098387948744&redirect_uri=" . urlencode(base_url('/api/facebook_login_callback')) ."&client_secret=ffcbe1d78c389c273086785f37d03ff1&code=" . urlencode($code)));
            redirect('/api/facebook_login_callback?access_token='.$access_token);
        }
        if(!empty($_GET['access_token'])) {
            $fbuser_info = json_decode($this->get_fb_contents("https://graph.facebook.com/me?access_token=".$_GET['access_token']), true);
            if(!empty($fbuser_info['email'])) {
                print_r($fbuser_info);
                exit();
            }
        }
    }

/*
- Member Talk
- Board & Business reference file attach
*/

    public function image_get($image_case = "board", $id = 1, $width = 400, $height = 300)
    {
        $this->load->library('image_lib');

        $check_process = false;
        $thumb_marker = '_thumb_'.$width.'_'.$height;

        if($image_case == "board") {
            $image_src = PROJECT_BOARD_DIR."/default.jpg";
            $image_result = PROJECT_BOARD_DIR."/default.jpg";
            if(file_exists(PROJECT_BOARD_DIR."/article_".$id.".jpg")) {
                $image_src = PROJECT_BOARD_DIR."/article_".$id.".jpg";
                $image_result = PROJECT_BOARD_DIR."/article_".$id.$thumb_marker.".jpg";
                $check_process = true;
                if(file_exists($image_result)) $check_process = false;
            }
        } else if($image_case == "product") {
            $image_src = PROJECT_PRODUCT_DIR."/default.jpg";
            $image_result = PROJECT_PRODUCT_DIR."/default.jpg";
            if(file_exists(PROJECT_PRODUCT_DIR."/product_".$id.".jpg")) {
                $image_src = PROJECT_PRODUCT_DIR."/product_".$id.".jpg";
                $image_result = PROJECT_PRODUCT_DIR."/product_".$id.$thumb_marker.".jpg";
                $check_process = true;
                if(file_exists($image_result)) $check_process = false;
            }
        }
        
        $imageSize = $this->image_lib->get_image_properties($image_src, TRUE);

        if($check_process) {
            $real_width = $imageSize['width'];
            $real_height = $imageSize['height'];

            $ratio = $height / $width;
            $real_ratio = $real_height / $real_width;

            if($ratio > $real_ratio) {
                $calc_height = $real_height;
                $calc_width = $real_height * $width / $height;
                $config['x_axis'] = ($real_width - $calc_width) / 2;
            } else {
                $calc_width = $real_width;
                $calc_height = $real_width * $height / $width;
                $config['y_axis'] = ($real_height - $calc_height) / 2;
            }

            $config['image_library'] = 'gd2';
            $config['source_image'] = $image_src;
            $config['create_thumb'] = TRUE;
            $config['maintain_ratio'] = FALSE;
            $config['thumb_marker'] = $thumb_marker;
            $config['width']         = intval($calc_width);
            $config['height']        = intval($calc_height);

            $this->image_lib->clear();
            $this->image_lib->initialize($config);
            $this->image_lib->crop();

            $config2['image_library'] = 'gd2';
            $config2['source_image'] = $image_result;
            $config2['maintain_ratio'] = TRUE;
            $config2['width']         = $width;
            $config2['height']        = $height;

            $this->image_lib->clear();
            $this->image_lib->initialize($config2);
            $this->image_lib->resize();
        }

        header('Content-Type:'.$imageSize["mime_type"]);
        header('Content-Length: ' . filesize($image_result));
        readfile($image_result);
    }

    public function search_keywords_get()
    {
        $search_key = $_GET["term"];
        $keywords = [];
        $arr_categories = $this->category_model->list_data("business_category", true);        
        $businesses = $this->business_model->search_business($arr_categories, $this->category_model->get_tree_rows("address_state"), $this->member_model->list_data(), "", $search_key, 0, 10);
        foreach ($businesses as $business) {
            $keyword = new \stdClass;
            $keyword->id = $business->business_name_ko;
            $keyword->value = $business->business_name_ko;
            $keywords[] = $keyword;
        }

        return $this->response($keywords);
    }

    // UPLOAD Test
    public function sap_upload_post()
    {
        $target_file = FCPATH.PROJECT_AVATAR_DIR."/sap_";
        move_uploaded_file($_FILES["uploadedFile"]["tmp_name"], $target_file.date("YmdHis"));
    }
}
