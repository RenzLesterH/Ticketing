<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    /* This constructor function load the model Dashboard, Transaction
    */
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Transaction");
    }

    /* This function redirect user to the dashboard. */  
	public function index()
	{   
        $user_level = $this->session->userdata('user_level');	
        if($user_level === "1"){ // This is for Staff 1
            $this->load->view('dashboards/staff1_dashboard');
        }elseif ($user_level === "2") { // This is for Staff 2
            $this->load->view('dashboards/staff2_dashboard');
        }elseif ($user_level === "3") { // This is for Staff 3
            $this->load->view('dashboards/staff3_dashboard');
        }elseif ($user_level === "4") { // This is for Head
            $this->load->view('dashboards/head_assessors_dashboard');
        }      		
	}

    /* This function handles the validation and adding new product in database.  */
    public function add_transaction_process() 
    {
        $result = $this->Transaction->add_transaction_validation($this->input->post());

        if($result !== null)
        {
            $this->session->set_flashdata('input_errors', $result);
            redirect('dashboard');
        }
        else
        {
            $form_data = $this->input->post();
            $this->Transaction->add_transaction($form_data);
            $this->session->set_flashdata('success', 'Product added successfully!');
            redirect('dashboard');
        }
    }

}
