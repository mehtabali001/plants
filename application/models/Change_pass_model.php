<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class change_pass_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
	// function fetch_pass()
	// {
	// $fetch_pass=$this->db->query("select * from tbl_users where fld_id='".$this->session->userdata('user_id')."'");
	// $res=$fetch_pass->result();
	// 	// $sql="SHOW TABLE STATUS LIKE 'tbl_users'";
	// 	// return $this->db->query($sql)->row_array();
	// }
	// function change_pass()
	// {
	//  $update_pass=$this->db->query("UPDATE tbl_users set pass='fld_password'");
	// }
	/**************************** Change Password *********************************/
	
   function change_pass($table,$data,$data1){
	 
		$this->db->where('fld_password',$data1['fld_password']);
		$this->db->where('fld_id',$this->session->userdata('user_id'));
		$this->db->update($table,$data);
		return $this->db->affected_rows();
    }
}