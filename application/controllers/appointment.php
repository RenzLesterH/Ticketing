<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Appointment extends CI_Controller {

	public function index()
	{
		$this->load->view('index');
	}

	public function dashboard()
	{
		$this->load->view('dashboard');
	}
}
