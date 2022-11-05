<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Appointment extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model("User");      
    }

	public function index()
	{
		$current_user_id = $this->session->userdata('user_id');	
        
        if(!$current_user_id) { 
            $this->load->view('index');
        } 
        else {
            redirect("dashboard");
        }
	}

	public function process_login() 
    {
        $result = $this->User->validate_login();
        if($result != 'success') {
            $this->session->set_flashdata('input_errors', $result);
            redirect("/");
        } 
        else 
        {
            $email = $this->input->post('email');
            $user = $this->User->get_user_by_email($email);
            
            $result = $this->User->validate_login_match($user, $this->input->post('password'));
            
            if($result == "success") 
            {
                $this->session->set_userdata(array('user_id'=>$user['id'], 'first_name'=>$user['first_name'], 'user_level'=>$user['user_level']));
                redirect("dashboard");
            }
            else 
            {
                $this->session->set_flashdata('input_errors', $result);
                redirect("/");
            }
        }

    }
}
