<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Complaint_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
	function getMaxCompID() {
		$sql="SHOW TABLE STATUS LIKE 'tbl_complaints'";
		return $this->db->query($sql)->row_array();
    }
	function category_entry(){
		$user_id= $this->session->userdata('user_id');
			$data = array(
                'category_name'=> $this->input->post('category_name',TRUE)
        );
       return $this->db->insert('tbl_complaint_category',$data);
	}
	function myComplaints(){
		$user_id= $this->session->userdata('user_id');
		$this->db->select('c.*,u.fld_username,cc.category_name');
		$this->db->from('tbl_complaints as c');
		$this->db->join('tbl_users as u','u.fld_id=c.fld_complaint_to');
		$this->db->join('tbl_complaint_category as cc','cc.id=c.fld_category');
		$this->db->where('c.fld_user_id',$user_id);
       return $this->db->get()->result_array();
	}
	function assignedComplaints(){
		$user_id= $this->session->userdata('user_id');
		$this->db->select('c.*,u.fld_username,u.fld_email,u.fld_mobile_number,cc.category_name,role.role_name');
		$this->db->from('tbl_complaints as c');
		$this->db->join('tbl_users as u','u.fld_id=c.fld_user_id');
		$this->db->join('tbl_employees as emp','emp.id=u.emp_id','left');
		$this->db->join('tbl_roles as role','role.role_id=u.fld_role','left');
		$this->db->join('tbl_complaint_category as cc','cc.id=c.fld_category');
		$this->db->where('c.fld_complaint_to',$user_id);
       return $this->db->get()->result_array();
	}
	function viewComplaints($id){
		
		$this->db->select('c.*,u.fld_username,u.fld_email,u.fld_mobile_number,cc.category_name,role.role_name');
		$this->db->from('tbl_complaints as c');
		$this->db->join('tbl_users as u','u.fld_id=c.fld_user_id');
		$this->db->join('tbl_employees as emp','emp.id=u.emp_id','left');
		$this->db->join('tbl_roles as role','role.role_id=u.fld_role','left');
		$this->db->join('tbl_complaint_category as cc','cc.id=c.fld_category');
		$this->db->where('c.fld_id',$id);
       return $this->db->get()->row_array();
	}
	function complaint_entry(){
	    
	    
		$getMaxID=$this->getMaxCompID();
		$complain_id= 'CI-'.sprintf('%04d', $getMaxID['Auto_increment']);
		$data = array(
            'fld_complain_id' => $complain_id,
            'fld_complain_subject' => $this->input->post('complain_subject',TRUE),
            'fld_user_id'          => $this->session->userdata('user_id'),
            'fld_category'          => $this->input->post('comp_category',TRUE),
            'fld_complaint_to'          => $this->input->post('complain_to',TRUE),
            'fld_description'        => $this->input->post('complain_description',TRUE)
        );
		  $responce=$this->db->insert('tbl_complaints', $data);
		  if($responce){
		    $this->load->library('phpmailer');
		    $complain_to= $this->input->post('complain_to',TRUE);
		    $user_id= $this->session->userdata('user_id');
		    $email_temp = $this->db->query("SELECT * FROM tbl_email WHERE fld_id = '14'")->row();
		    $complainr_detail = $this->db->query("SELECT * FROM tbl_users WHERE fld_id = ".$complain_to."")->row_array();
		    $send_detail = $this->db->query("SELECT * FROM tbl_users WHERE fld_id = ".$user_id."")->row_array();
		    $message = $email_temp->fld_email_body;
			$message = str_replace('{Complaint_ID}', $complain_id, $message);
			$message = str_replace('{Complaint_Subject}', $this->input->post('complain_subject',TRUE), $message);
			$message = str_replace('{Complaint_Details}', $this->input->post('complain_description',TRUE), $message);
			$message = str_replace('{Complaint_Status}', 'Pending', $message);
			$message = str_replace('{Complainer_Name}', $complainr_detail['fld_username'], $message);
			$message = str_replace('{Complainer_Email}',  $complainr_detail['fld_email'], $message);
			$message = str_replace('{Complainer_Contact}',  $complainr_detail['fld_mobile_number'], $message);
			$email=$complainr_detail['fld_email'];
			$this->phpmailer->IsMail();     
 			$this->phpmailer->From   =   'noreply@mktechsol.com';
 			$this->phpmailer->FromName  =  "H.Q. OFFICE";
			$this->phpmailer->IsHTML(true);
 			$this->phpmailer->AddAddress($email); 
 			$this->phpmailer->Subject  =   $email_temp->fld_subject;
 			$this->phpmailer->Body  =   nl2br($message);
 			$this->phpmailer->Send();
 			$this->phpmailer->ClearAddresses();
 			
			$res=array('responce'=>'success',"message"=>"Complaint added successfully.");
			return $res;
		}else{
			$res=array('responce'=>'error',"message"=>"Complaint not added.Something went wrong.");
			return $res;
		}
	}
	function update_complaint_entry(){
		
		$data = array(
            'fld_complain_subject' => $this->input->post('complain_subject',TRUE),
            'fld_user_id'          => $this->session->userdata('user_id'),
            'fld_category'          => $this->input->post('comp_category',TRUE),
            'fld_complaint_to'          => $this->input->post('complain_to',TRUE),
            'fld_description'        => $this->input->post('complain_description',TRUE)
        );
		$this->db->where("fld_id",$_POST['edit_id']);
		  $responce=$this->db->update('tbl_complaints', $data);
		  if($responce){
		  
			$res=array('responce'=>'success',"message"=>"Complaint Updated successfully.");
			return $res;
		}else{
			$res=array('responce'=>'error',"message"=>"Complaint not Updated.Something went wrong.");
			return $res;
		}
	}
	function resolve_complaint_entry(){
		
		$data = array(
            'fld_reply' => $this->input->post('reply',TRUE),
            'fld_status' => $this->input->post('status',TRUE)
        );
		 $this->db->where("fld_id",$_POST['edit_id']);
		  $responce=$this->db->update('tbl_complaints', $data);
		  if($responce){
		    $status=$this->input->post('status',TRUE);
		    if($status == '0'){
		       $status ="Pending";
		    }else if($status == '1'){
		        $status ="Resolved";
		    }else if($status == '2'){
		        $status ="Not Resolved";
		    }
		    $this->load->library('phpmailer');
		    $complain_to= $this->input->post('complain_to',TRUE);
		    $user_id= $this->session->userdata('user_id');
		    $email_temp = $this->db->query("SELECT * FROM tbl_email WHERE fld_id = '15'")->row();
		    $assigner_detail = $this->db->query("SELECT * FROM tbl_users WHERE fld_id = ".$user_id."")->row_array();
		    $complain_detail = $this->db->query("SELECT * FROM tbl_complaints WHERE fld_id = ".$_POST['edit_id']."")->row_array();
		    $complainer_detail = $this->db->query("SELECT * FROM tbl_users WHERE fld_id = ".$complain_detail['fld_user_id']."")->row_array();
		    $message = $email_temp->fld_email_body;
			$message = str_replace('{Complaint_ID}', $complain_detail['fld_complain_id'], $message);
			$message = str_replace('{Complaint_Subject}', $complain_detail['fld_complain_subject'], $message);
			$message = str_replace('{Complaint_Details}', $complain_detail['fld_description'], $message);
			$message = str_replace('{Complaint_Status}', $status, $message);
			$message = str_replace('{Name}', $assigner_detail['fld_username'], $message);
			$message = str_replace('{Email}',  $assigner_detail['fld_email'], $message);
			$message = str_replace('{Contact}',  $assigner_detail['fld_mobile_number'], $message);
			$email=$complainer_detail['fld_email'];
		
			$this->phpmailer->IsMail();     
 			$this->phpmailer->From   =   'noreply@mktechsol.com';
 			$this->phpmailer->FromName  =  "H.Q. OFFICE";
			$this->phpmailer->IsHTML(true);
 			$this->phpmailer->AddAddress($email); 
 			$this->phpmailer->Subject  =   $email_temp->fld_subject;
 			$this->phpmailer->Body  =   nl2br($message);
 			$this->phpmailer->Send();
 			$this->phpmailer->ClearAddresses();
			$res=array('responce'=>'success',"message"=>"Complaint updated successfully.");
			return $res;
		}else{
			$res=array('responce'=>'error',"message"=>"Complaint not Updated.Something went wrong.");
			return $res;
		}
	}
	function filter(){
		$filter=$this->input->post('filter');
		$where='fld_status=1';
		switch ($filter) {
		  case "showall":
			$where='';
			break;
		case "resolved":
			$where='c.fld_status=1';
			break;
		case "pending":
			$where='c.fld_status=0';
			break;
		case "notresolved":
			$where='c.fld_status=2';
			break;
		}
		
		$user_id= $this->session->userdata('user_id');
		$this->db->select('c.*,u.fld_username,cc.category_name');
		$this->db->from('tbl_complaints as c');
		$this->db->join('tbl_users as u','u.fld_id=c.fld_complaint_to');
		$this->db->join('tbl_complaint_category as cc','cc.id=c.fld_category');
		$this->db->where('c.fld_user_id',$user_id);
		if($where != ""){
		$this->db->where($where);
		}
		return $this->db->get()->result_array();
        
	}
	function assignfilter(){
		$filter=$this->input->post('filter');
		$where='fld_status=1';
		switch ($filter) {
		  case "showall":
			$where='';
			break;
		case "resolved":
			$where='c.fld_status=1';
			break;
		case "pending":
			$where='c.fld_status=0';
			break;
		case "notresolved":
			$where='c.fld_status=2';
			break;
		}
		
		$user_id= $this->session->userdata('user_id');
		$this->db->select('c.*,u.fld_username,u.fld_email,u.fld_mobile_number,cc.category_name,role.role_name');
		$this->db->from('tbl_complaints as c');
		$this->db->join('tbl_users as u','u.fld_id=c.fld_user_id');
		$this->db->join('tbl_employees as emp','emp.id=u.emp_id','left');
		$this->db->join('tbl_roles as role','role.role_id=u.fld_role','left');
		$this->db->join('tbl_complaint_category as cc','cc.id=c.fld_category');
		$this->db->where('c.fld_complaint_to',$user_id);
		if($where != ""){
		$this->db->where($where);
		}
		return $this->db->get()->result_array();
        
	}
   
}
