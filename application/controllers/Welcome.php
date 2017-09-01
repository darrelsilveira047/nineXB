<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url','form');
		$this->load->model('employee_m');
	}
	public function index() {
		$data['title'] = 'CRUD NINEXB';
		$data['employees'] = $this->employee_m->getEmployee();
		$this->load->view('welcome_message', $data);
	}

	public function insertOperation() {
		$data = array(
			"emp_fname" => $this->input->post('fname'),
			"emp_lname" => $this->input->post('lname'),
			"emp_email" => $this->input->post('email'),
			"emp_job_role" => $this->input->post('jobrole')
		);
		$inserted_id = $this->employee_m->insertEmployee($data);
		$data['emp_id'] = $inserted_id;
		echo json_encode($data);
	}

	public function deleteEmployee() {
		$check = $this->employee_m->remEmployee($this->input->post('id'));
		echo $check;
	}

	public function updateEmployee() {
		$data = array(
			"emp_fname" => $this->input->post('fname'),
			"emp_lname" => $this->input->post('lname'),
			"emp_email" => $this->input->post('email'),
			"emp_job_role" => $this->input->post('jobrole')
		);
		$id = $this->input->post('id');
		$affctd_rows = $this->employee_m->updEmployee($id, $data);
		echo json_encode($data);
	}
}
