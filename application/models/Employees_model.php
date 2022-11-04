<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Employees_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function getMaxemployeeID() {
		$sql="SHOW TABLE STATUS LIKE 'tbl_employees'";
		return $this->db->query($sql)->row_array();
     // $this->db->select('Max(fld_id) as maxid');
     // return $this->db->get('tbl_suppliers')->row_array();
    }
    
    // Update record
    function updateAttendance($id,$field,$value){
   // Update
      $data=array($field => $value);
      $this->db->where('attendance_id',$id);
      $this->db->update('tbl_attendance',$data);
    }
    function employee_filter() {
		$conditions="";
		$filter=$this->input->post('filter');
 		$group_by='tbl_employees.plants';
 		$select="tbl_locations.fld_location as filter_text,tbl_employees.plants as filter_value";
		switch ($filter) {
    		case "Plant_Wise":
    			$group_by = "tbl_employees.plants";
    			$select="tbl_locations.fld_location as filter_text,tbl_employees.plants as filter_value";
    			break;
    		case "employee_code_wise":
    			$group_by = "tbl_employees.employee_code";
    			$select="tbl_employees.employee_code as filter_text,tbl_employees.employee_code as filter_value";
    			break;
    			case "employee_name_wise":
    			$group_by = "tbl_employees.full_name";
    			$select="tbl_employees.full_name as filter_text,tbl_employees.full_name as filter_value";
    			break;
    		case "designation_Wise":
    			$group_by = "tbl_employees.designation";
    			$select="tbl_designation.designation_name as filter_text,tbl_employees.designation as filter_value";
    			break;
    		case "department_Wise":
            	$group_by = "tbl_employees.department";
            	$select="tbl_departments.department_name as filter_text,tbl_employees.department as filter_value";
            	break;
		}
		
		
		
		$this->db->select('tbl_employees.id,'.$select.'');
		
		$this->db->from('tbl_employees');
		
		$this->db->join('tbl_departments','tbl_departments.id=tbl_employees.department');
		
		$this->db->join('tbl_designation','tbl_designation.id=tbl_employees.designation');
		
		$this->db->join('tbl_locations','tbl_locations.fld_id=tbl_employees.plants');
		
		$emp_code=$this->input->post('emp_code');
		$emp_name=$this->input->post('emp_name');
		$plants=$this->input->post('plants');
		$designation=$this->input->post('designation');
		$department=$this->input->post('department');
		
		if(!empty($plants)){
			$this->db->where("tbl_employees.plants",$plants);
		}
		if(!empty($emp_code)){
			$this->db->where("tbl_employees.employee_code",$emp_code);
		}
		if(!empty($emp_name)){
			$this->db->where("tbl_employees.full_name",$emp_name);
		}
		if(!empty($designation)){
			$this->db->where("tbl_employees.designation",$designation);
		}
		if(!empty($department)){
			$this->db->where("tbl_employees.department",$department);
		}
		
		
		
		$this->db->group_by($group_by);
		
		$employees=$this->db->get()->result_array();
		if($employees){
			foreach($employees as $key => $Emp){
				$employeesdet=$this->getEmployeeDetail($Emp['filter_value'], $group_by);
				$employees[$key]['detail']=$employeesdet;
			}
		}
		return $employees;
        
    }
     function employee_filter_pdf() {
		$conditions="";
		$filter=$this->input->get('filter');
// 		$group_by='tbl_purchase.fld_voucher_no';
// 		$select="tbl_purchase.fld_voucher_no as filter_text,tbl_purchase.fld_voucher_no as filter_value";
		switch ($filter) {
    		case "Plant_Wise":
    			$group_by = "tbl_employees.plants";
    			$select="tbl_locations.fld_location as filter_text,tbl_employees.plants as filter_value";
    			break;
    		case "employee_code_wise":
    			$group_by = "tbl_employees.employee_code";
    			$select="tbl_employees.employee_code as filter_text,tbl_employees.employee_code as filter_value";
    			break;
    			case "employee_name_wise":
    			$group_by = "tbl_employees.full_name";
    			$select="tbl_employees.full_name as filter_text,tbl_employees.full_name as filter_value";
    			break;
    		case "designation_Wise":
    			$group_by = "tbl_employees.designation";
    			$select="tbl_designation.designation_name as filter_text,tbl_employees.designation as filter_value";
    			break;
    		case "department_Wise":
            	$group_by = "tbl_employees.department";
            	$select="tbl_departments.department_name as filter_text,tbl_employees.department as filter_value";
            	break;
		}
		
		
		
		$this->db->select('tbl_employees.id,'.$select.'');
		
		$this->db->from('tbl_employees');
		
		$this->db->join('tbl_departments','tbl_departments.id=tbl_employees.department');
		
		$this->db->join('tbl_designation','tbl_designation.id=tbl_employees.designation');
		
		$this->db->join('tbl_locations','tbl_locations.fld_id=tbl_employees.plants');
		
		$emp_code=$this->input->post('emp_code');
		$emp_name=$this->input->post('emp_name');
		$plants=$this->input->post('plants');
		$designation=$this->input->post('designation');
		$department=$this->input->post('department');
		
		if(!empty($plants)){
			$this->db->where("tbl_employees.plants",$plants);
		}
		if(!empty($emp_code)){
			$this->db->where("tbl_employees.employee_code",$emp_code);
		}
		if(!empty($emp_name)){
			$this->db->where("tbl_employees.full_name",$emp_name);
		}
		if(!empty($designation)){
			$this->db->where("tbl_employees.designation",$designation);
		}
		if(!empty($department)){
			$this->db->where("tbl_employees.department",$department);
		}
		
		
		
		$this->db->group_by($group_by);
		
		$employees=$this->db->get()->result_array();
		if($employees){
			foreach($employees as $key => $Emp){
				$employeesdet=$this->getEmployeeDetail($Emp['filter_value'], $group_by);
				$employees[$key]['detail']=$employeesdet;
			}
		}
		return $employees;
        
    }
    
    function getEmployeeDetail($id,$group_by){
        
    	$this->db->select('tbl_employees.*, tbl_locations.fld_location, tbl_designation.designation_name, tbl_departments.department_name');
		
		$this->db->from('tbl_employees');
		
		$this->db->join('tbl_departments','tbl_departments.id=tbl_employees.department');
		
		$this->db->join('tbl_designation','tbl_designation.id=tbl_employees.designation');
		
		$this->db->join('tbl_locations','tbl_locations.fld_id=tbl_employees.plants');
		
		$emp_code=$this->input->post('emp_code');
		$emp_name=$this->input->post('emp_name');
		$plants=$this->input->post('plants');
		$designation=$this->input->post('designation');
		$department=$this->input->post('department');
		
		if(!empty($plants)){
			$this->db->where("tbl_employees.plants",$plants);
		}
		if(!empty($emp_code)){
			$this->db->where("tbl_employees.employee_code",$emp_code);
		}
		if(!empty($emp_name)){
			$this->db->where("tbl_employees.full_name",$emp_name);
		}
		if(!empty($designation)){
			$this->db->where("tbl_employees.designation",$designation);
		}
		if(!empty($department)){
			$this->db->where("tbl_employees.department",$department);
		}
		
        $this->db->where($group_by,$id);
        return $this->db->get()->result_array();
    }
    
    function attendence_filter() {
		$conditions="";
		$filter=$this->input->post('filter');
		switch ($filter) {
		  case "Plant_Wise":
			$group_by = "tbl_attendance.plants";
			$select="tbl_locations.fld_location as filter_text,tbl_attendance.plants as filter_value";
			break;
		  case "Employee_wise":
			$group_by = "tbl_attendance.user_id";
			$select="tbl_employees.full_name as filter_text,tbl_attendance.user_id as filter_value";
			break;	
		  case "Date_Wise":
			$group_by = "tbl_attendance.attendance_date";
			$select="tbl_attendance.attendance_date as filter_text,tbl_attendance.attendance_date as filter_value";
			break;
		  case "Designation_Wise":
			$group_by = "tbl_attendance.designation";
			$select="tbl_designation.designation_name as filter_text,tbl_attendance.designation as filter_value";
			break;
		  case "Status_Wise":
			$group_by = "tbl_attendance.attendance_status";
			$select="tbl_attendance.attendance_status as filter_text,tbl_attendance.attendance_status as filter_value";
			break;
		}
		$plants=$this->input->post('plants');
		$employee=$this->input->post('employee');
		$designation=$this->input->post('designation');
		$status=$this->input->post('status');
		
		$start=str_replace('/', '-', $this->input->post('from_date'));
		$end=str_replace('/', '-', $this->input->post('to_date'));
		
		$date="tbl_attendance.attendance_date between '".date("Y-m-d",strtotime($start))." 00:00:00' AND '".date("Y-m-d",strtotime($end))." 23:59:00'";
		$this->db->select('tbl_attendance.attendance_id,'.$select.'');
		
		$this->db->from('tbl_attendance');
		
		$this->db->join('tbl_designation','tbl_designation.id=tbl_attendance.designation');
		
		$this->db->join('tbl_employees','tbl_employees.id=tbl_attendance.user_id');
		
		$this->db->join('tbl_locations','tbl_locations.fld_id=tbl_attendance.plants');
		
		$this->db->where($date);
		
		if(!empty($plants)){
			$this->db->where("tbl_attendance.plants",$plants);
		}
		if(!empty($employee)){
			$this->db->where("tbl_attendance.user_id",$employee);
		}
		if(!empty($designation)){
			$this->db->where("tbl_attendance.designation",$designation);
		}
		if(!empty($status)){
			$this->db->where("tbl_attendance.attendance_status",$status);
		}
		
		
		
		$this->db->group_by($group_by);
		
		$attendance=$this->db->get()->result_array();
		if($attendance){
			foreach($attendance as $key => $purch){
				$purchdet=$this->getAttDetail($purch['filter_value'],$group_by);
				$attendance[$key]['detail']=$purchdet;
			}
		}
		return $attendance;
        
    }
    
	function getAttDetail($id,$group_by){
	    $plants=$this->input->post('plants');
	    $employee=$this->input->post('employee');
		$designation=$this->input->post('designation');
		$status=$this->input->post('status');
	    
	    if(!empty($plants)){
			$this->db->where("tbl_attendance.plants",$plants);
		}
		if(!empty($employee)){
			$this->db->where("tbl_attendance.user_id",$employee);
		}
		if(!empty($designation)){
			$this->db->where("tbl_attendance.designation",$designation);
		}
		if(!empty($status)){
			$this->db->where("tbl_attendance.attendance_status",$status);
		}
	
// 	return $this->db->query("SELECT `tbl_attendance`.*, `tbl_designation`.`designation_name`, `tbl_locations`.`fld_location`
//     FROM `tbl_purchase`
//     JOIN `tbl_designation` ON tbl_designation.id=tbl_attendance.designation
//     JOIN `tbl_locations` ON tbl_locations.fld_id=tbl_attendance.plants
//     AND $group_by = '$id'")->result_array();
    
    	$start=str_replace('/', '-', $this->input->post('from_date'));
		$end=str_replace('/', '-', $this->input->post('to_date'));
		
		$date="tbl_attendance.attendance_date between '".date("Y-m-d",strtotime($start))." 00:00:00' AND '".date("Y-m-d",strtotime($end))." 23:59:00'";
		
			
			
		$this->db->select('tbl_attendance.*, tbl_locations.fld_location, tbl_designation.designation_name');
		
		$this->db->from('tbl_attendance');
		
		$this->db->join('tbl_designation','tbl_designation.id=tbl_attendance.designation');
		$this->db->join('tbl_employees','tbl_employees.id=tbl_attendance.user_id');
		
		
		$this->db->join('tbl_locations','tbl_locations.fld_id=tbl_attendance.plants');
		
		$this->db->where($date);
		
		if(!empty($plants)){
			$this->db->where("tbl_attendance.plants",$plants);
		}
		if(!empty($employee)){
			$this->db->where("tbl_attendance.user_id",$employee);
		}
		if(!empty($designation)){
			$this->db->where("tbl_attendance.designation",$designation);
		}
		if(!empty($status)){
			$this->db->where("tbl_attendance.attendance_status",$status);
		}
		
		$this->db->where($group_by,$id);
		
		
		return $this->db->get()->result_array();

	}
   
}
