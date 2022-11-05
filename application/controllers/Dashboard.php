<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    /* This constructor function load the model Dashboard, Message, Comment and Profile
    */
    public function __construct()
    {
        parent::__construct();
    }

    /* This function redirect user to the dashboard. */  
	public function index()
	{   
        $user_level = $this->session->userdata('user_level');
        $name = $this->session->userdata('firstname');	
        if($user_level === "1"){ // This is for Staff 1
            $this->load->view('dashboards/staff1_dashboard', array('name' => $name));
        }elseif ($user_level === "2") { // This is for Staff 2
            $this->load->view('dashboards/staff2_dashboard', array('name' => $name));
        }elseif ($user_level === "3") { // This is for Staff 3
            $this->load->view('dashboards/staff3_dashboard', array('name' => $name));
        }elseif ($user_level === "4") { // This is for Head
            $this->load->view('dashboards/head_assessors_dashboard', array('name' => $name));
        }      		
	}

}
