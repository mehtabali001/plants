<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends My_controller {
	
	function __construct() {
        parent::__construct();
		$this->load->model('Profile_model');
		$this->load->model('Common_model');
    }
	
	public function index()
    {
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
        $this->title = "Add Profile | ".$this->title;
		
		$maxProfileID=$this->Profile_model->getMaxprofileID();
		$data['maxid']='KG-emp-'.sprintf('%03d', $maxProfileID['Auto_increment']);
		
		
		//For Form Validation
		$data['view_scripts']=array(
			$this->Gen->get_script_url('','https://code.jquery.com/jquery-2.2.4.min.js'),
			$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js'),
			$this->Gen->get_script_url('custom_js','script.js'),
		  	$this->Gen->get_script_url('custom_js','hrm.js'),
		  	
		);
		
		$data['view_css']=array(
		   $this->Gen->get_script_url('theme_css','style.css'),
		);
		
        $this->load_template('','profile',$data);
    }
    
    
	
	
	
	public function viewProfile(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
        $this->title = "View Profile | ".$this->title;
		$data['users']=$this->Base_model->getRow('tbl_users','','fld_id ='.$this->session->userdata('user_id').'');
		//For Form Validation
// 		$data['view_scripts']=array(
// 			$this->Gen->get_script_url('','https://code.jquery.com/jquery-2.2.4.min.js'),
// 			$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js'),
// 			$this->Gen->get_script_url('custom_js','script.js'),
// 		  	$this->Gen->get_script_url('custom_js','hrm.js'),
// 		);
		
		$data['view_css']=array(
		   $this->Gen->get_script_url('theme_css','style.css'),
		);
        $this->load_template('','profile',$data);
	}
}
	
	
	