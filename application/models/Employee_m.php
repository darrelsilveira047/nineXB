<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_m extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	public function getEmployee($id = NULL) {
		if (empty($id)) {
			$query = $this->db->get('employee');
		} else {
			$this->db->where('id', $id);
			$query = $this->db->get('employee');
		}
		$data = $query->result_array();
		return $data;
	}

	public function insertEmployee($data) {
		$this->db->insert('employee',$data);
		return $this->db->insert_id();
	}

	public function remEmployee($id) {
		$this->db->delete('employee', array('emp_id' => $id));
		return $this->db->affected_rows();
	}

	public function updEmployee($id, $data) {
		$this->db->where('emp_id', $id);
		$this->db->update('employee', $data);
		return $this->db->affected_rows();
	}
	public function getEmployeeJR($job_role) {
		$this->db->where('emp_job_role', $job_role);
		$query = $this->db->get('employee');
		$data = $query->result_array();
		return $data;
	}
}
