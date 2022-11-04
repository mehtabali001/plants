<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Change_pass extends My_controller {
	
	function __construct() {
        parent::__construct();
		$this->load->model('Change_pass_model');
		$this->load->model('Common_model');
    }
	
	public function index()
    {
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
        $this->title = "Change Password | ".$this->title;
		
		// $maxProfileID=$this->Change_pass_model->fetch_pass();
		// $data['maxid']='KG-emp-'.sprintf('%03d', $maxProfileID['Auto_increment']);
		
		
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
		
        $this->load_template('','change_pass',$data);
    }
	  
	
	// public function change_pass()
	// {
	// 	if($this->input->post('change_pass'))
	// 	{
	// 		$old_pass=$this->input->post('old_pass');
	// 		$new_pass=$this->input->post('new_pass');
	// 		$confirm_pass=$this->input->post('confirm_pass');
	// 		$session_id=$this->session->userdata('fld_id');
	// 		$que=$this->db->query("select * from tbl_users where fld_id='$session_id'");
	// 		$row=$que->row();
	// 		if((!strcmp($old_pass, $new_pass))&& (!strcmp($new_pass, $confirm_pass))){
	// 			$this->Change_pass_model->change_pass($session_id,$new_pass);
	// 			echo "Password changed successfully !";
	// 			}
	// 		    else{
	// 				echo "Invalid";
	// 			}
	// 	}
	// 	 //$this->load_template('change_pass');	
	// 	$this->session->set_userdata(array('success_message' => "Supplier added successfully"));
 //        $this->output->set_header("Location: " . base_url() . 'Change_pass', TRUE, 302);
	// }
	/***************** Change Password ********************/
	
	function pwdreset()
	{
		$this->form_validation->set_rules('new_password','New Password','trim|required');
		
		if($this->form_validation->run() === FALSE) {
			$this->load_template('','change_pass');
		} else {
			$fld_id = $this->input->post('fld_id');
			$query = $this->Common_model->select_where('fld_id','tbl_users',array('fld_id'=>$fld_id));
			if($query->num_rows() > 0) {
				$data['fld_password']		= 	md5("kotal" . $this->input->post('new_password'));
				//$reset_hash					= 	$this->input->post('reset_hash');
				//$data['reset_hash']			= 	"";
				
				$this->Common_model->update_array(array('fld_id'=>$fld_id),'tbl_users',$data);
				
				$this->session->set_userdata('msg','<p style="color:#06b84a;" >Password has updated successfully</p>');
				$this->session->set_userdata('pass_changed',1);
				
				
			} else{
				$this->session->set_userdata('msg','<p style="color:#eb4646;" >OPPS! Invalid link</p>');
			}
			redirect(base_url().'Change_pass');

		}
	}

	

}
?>