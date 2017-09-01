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
		$countEMPS = count($this->employee_m->getEmployee());
		$countJR = count($this->employee_m->getEmployeeJR($this->input->post('jobrole')));
		/*$data['error'] = '';
		if ($countjr >= 0) {
			$data['error'] = 'Maximum 4 records assigned per Job Role.';
		}
		if ($countdb >= 10) {
			$data['error'] = 'Data cannot exceed more then 10 rows.';
		}*/
		$data['error'] = ($countJR >= 4 ? 'Maximum 4 records assigned per Job Role.' : ($countEMPS >= 10 ? 'Data cannot exceed more then 10 rows.' : '') ) ;
		if ($data['error'] == '') {
			$data = array(
				"emp_fname" => $this->input->post('fname'),
				"emp_lname" => $this->input->post('lname'),
				"emp_email" => $this->input->post('email'),
				"emp_job_role" => $this->input->post('jobrole')
			);
			$inserted_id = $this->employee_m->insertEmployee($data);
			$data['emp_id'] = $inserted_id;
		}
		echo json_encode($data);
	}

	public function deleteEmployee() {
		$check = $this->employee_m->remEmployee($this->input->post('id'));
		echo $check;
	}

	public function updateEmployee() {
		$countJR = count($this->employee_m->getEmployeeJR($this->input->post('jobrole')));
		$data['error'] = $countJR >= 4 ? 'Maximum 4 records assigned per Job Role.' : '';
		if ($data['error'] == '') {
			$data = array(
				"emp_fname" => $this->input->post('fname'),
				"emp_lname" => $this->input->post('lname'),
				"emp_email" => $this->input->post('email'),
				"emp_job_role" => $this->input->post('jobrole')
			);
			$id = $this->input->post('id');
			$data['affected_rows'] = $this->employee_m->updEmployee($id, $data);
		}
		
		echo json_encode($data);
	}
}
