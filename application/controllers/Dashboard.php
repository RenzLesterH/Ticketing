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
        $this->load->view('dashboards/dashboard');     		
	}

    public function load_partial_pages($page)
	{   
        // 1 = As list of Appointment
        // 2 = As add client transaction form 
        if($page == "1"){
            $data["client_transactions"] = $this->Transaction->get_all_transaction();
            $this->load->view("dashboards/partial_pages/transaction_table", $data);
        }elseif ($page == "2") {
            $this->load->view("dashboards/partial_pages/add_form"); 
        }
          		
	}

    /* This function handles the validation and adding new product in database.  */
    public function add_transaction_process() 
    {
        $result = $this->Transaction->add_transaction_validation($this->input->post());

        if($result !== null)
        {
            $this->session->set_flashdata('input_errors', $result);
            $this->load->view("dashboards/partial_pages/add_form");
        }
        else
        {
            $form_data = $this->input->post();
            $this->Transaction->add_transaction($form_data); 
            $this->session->set_flashdata('added_success', 'Client transaction added successfully!');
            $this->load->view("dashboards/partial_pages/add_form");
        }
    }

    /* This function handles the viewing of client transaction.  */
    public function view_client_transaction($client_transaction_id) 
    {
        $data["client_transaction"] = $this->Transaction->get_client_transaction_by_id($client_transaction_id);
        $this->load->view("dashboards/partial_pages/view_client_transaction", $data);
    }

    /* This function handles the validation and adding new product in database.  */
    public function update_transaction_process()
    {
        $form_data = $this->input->post();
        $response = $this->Transaction->update_client_transaction_by_id($form_data);
        $this->session->set_flashdata('success', $response);
        $this->load_partial_pages(1); 
    }

     /* This function handles the validation and adding new product in database.  */
     public function prepare_client_transaction_process()
     {
         $form_data = $this->input->post();
         $response = $this->Transaction->update_client_transaction_progress_by_id($form_data);
         $this->session->set_flashdata('success', $response);
         $this->load_partial_pages(1); 
     }

     public function view_action_form($client_transaction_id) 
     {
         $this->load->view("dashboards/partial_pages/action_form", array("client_id" => $client_transaction_id));
     }

}
