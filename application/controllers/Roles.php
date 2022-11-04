<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roles extends My_controller {
	
	function __construct() {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->helper('sms');
    }
    
    public function addRole(){
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(48,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
			$this->title = "New Role";
			$data['view_scripts']=array(
		    //$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		);
		$data['view_css']=array(
		);
		$this->load_template('','roles/addRoles');	 
    }
	
	############################# Add #############################
	
	function add()
	{
	    $role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(48,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		
		$this->form_validation->set_rules('role_name', 'Role Name', 'trim|required');
		
		
		
		if ( $this->form_validation->run() === FALSE )
		{
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Roles/addRole', TRUE, 302);
		} else {
						
			$data['role_name']			 = 	$this->input->post('role_name');
			$data['description']		 = 	$this->input->post('description');
			
			$menu_group_name 			 = 	$this->input->post('menu_group_name', TRUE);
			$menu_subgroup_name 		 = 	$this->input->post('menu_subgroup_name', TRUE);
			$admin_menu_group 		     = 	$this->input->post('admin_menu', TRUE);
			
		  //$menu_trd_lvl_ck 			 = 	$this->input->post('menu_trd_lvl_ck', TRUE);
		  //$menu_frth_lvl_ck 		 = 	$this->input->post('menu_frth_lvl_ck', TRUE);
						
			$menu_group_name	 		 =  implode(",", @$menu_group_name);	
			$menu_subgroup_name	 		 =  implode(",", @$menu_subgroup_name);
			$admin_menu_group	 		 =  implode(",", @$admin_menu_group);			
			
			$data['admin_menu_group']	 =  $admin_menu_group;
			
			//$menu_trd_lvl_ck_mn		 =	implode(",", @$menu_trd_lvl_ck);	
			//$menu_frth_lvl_ck_mn		 =	implode(",", @$menu_frth_lvl_ck);	
			
			//$data['admin_menu'] 		 =  $menu_trd_lvl_ck_mn.','.$menu_frth_lvl_ck_mn;	
			$data['admin_menu'] 		 =  $menu_group_name;
			$data['admin_menu_sublevel'] =  $menu_subgroup_name;
			
			$other_rights = array();
			if(isset($_POST['permission']) && !empty($_POST['permission'])){
			    $other_rights 			= 	$this->input->post('permission', TRUE);
			}
			
			$assign_other_rights		 =	implode(",", @$other_rights);	
			$data['perm_issions'] 		 =  $assign_other_rights;	
			
			//$role_permissions  			 = 	explode(",",$assign_other_rights);
			/*if(in_array(18,$role_permissions))
			{
				$data['login_destination']	=	'dashboard';
			} else {
				$data['login_destination']	=	'tasks/listing/3?by_user=';
			} */
			
			$this->db->insert('tbl_roles',$data);
			 /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=$this->input->post('role_name',TRUE);
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'ADD',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Role added successfully"));
            $this->output->set_header("Location: " . base_url() . 'Roles/manage_Roles', TRUE, 302);
		}	
	}
	
	function edit()
	{
	    $role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(50,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		
		$this->form_validation->set_rules('role_name', 'Role Name', 'trim|required');
		$id = $this->input->post('role_id');
		if ( $this->form_validation->run() === FALSE )
		{
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Roles/editRolespermission/'.$id, TRUE, 302);
		} else {
						
			$data['role_name']			 = 	$this->input->post('role_name');
			$data['description']		 = 	$this->input->post('description');
			
			$menu_group_name 			 = 	$this->input->post('menu_group_name', TRUE);
			$menu_subgroup_name 		 = 	$this->input->post('menu_subgroup_name', TRUE);
			$admin_menu_group 		     = 	$this->input->post('admin_menu', TRUE);
			
		  //$menu_trd_lvl_ck 			 = 	$this->input->post('menu_trd_lvl_ck', TRUE);
		  //$menu_frth_lvl_ck 		 = 	$this->input->post('menu_frth_lvl_ck', TRUE);
						
			$menu_group_name	 		 =  implode(",", @$menu_group_name);	
			$menu_subgroup_name	 		 =  implode(",", @$menu_subgroup_name);
			$admin_menu_group	 		 =  implode(",", @$admin_menu_group);			
			
			$data['admin_menu_group']	 =  $admin_menu_group;
	
			$data['admin_menu'] 		 =  $menu_group_name;
			$data['admin_menu_sublevel'] =  $menu_subgroup_name;
			
			$other_rights 				 = 	$this->input->post('permission', TRUE);
			$assign_other_rights		 =	implode(",", @$other_rights);	
			$data['perm_issions'] 		 =  $assign_other_rights; 
			
			$this->db->where('role_id',$id);
			$expense = $this->db->update('tbl_roles',$data);
			if($expense){
			     /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=$this->input->post('role_name',TRUE);
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'UPDATE',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
				$this->session->set_userdata(array('success_message' => "Role update successfully"));
				$this->output->set_header("Location: " . base_url() . 'Roles/manage_Roles', TRUE, 302);
			}else{
				$this->session->set_userdata(array('error_message' => "Expense not updated.Something went wrong"));
				$this->output->set_header("Location: " . base_url() . 'Expenses/edit/'.$id.'', TRUE, 302);
			}
		}	
	}
    
	public function manage_Roles(){
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(49,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$this->title = "View Roles";
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
		//$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		);
		$data['view_css']=array(
		
		);
       
		$data['roles']=$this->Base_model->getAll('tbl_roles');
        $this->load_template('','roles/manage_roles',$data);
    }
	
	public function assigned_roles(){
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(52,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$this->title = "Manage Locations | ".$this->title;
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
// 		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
		$this->Gen->get_script_url('custom_js','role.js'),
		);
		$data['view_css']=array(
		$this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
       
		$data['employees']=$this->Base_model->getAll('tbl_employees');
        $this->load_template('','roles/assigned_roles',$data);
    }
    
    
    
	public function editRolespermission($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(50,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$data['view_scripts']=array(
		    $this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
		    );
		$data['view_css']=array(
		    $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		    );
        $this->title = "Edit Roles";

		$data['role_detail']=$this->Base_model->getRow('tbl_roles','','role_id ='.$id.'');
        $this->load_template('','roles/editRolesPermissions',$data);
	}
	
	public function assignUserRole($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(52,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$data['view_scripts']=array(
		    $this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
		    );
		$data['view_css']=array(
		    $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		    );
        $this->title = "Edit Roles ";

 		$data['employee']=$this->Base_model->getRow('tbl_employees','','id ='.$id.'');
		$data['user']=$this->Base_model->getRow('tbl_users','','emp_id ='.$id.'');
        $this->load_template('','roles/assignRoleusers',$data);
	}
	
	

public function editRolespermissionProcess(){
        $this->form_validation->set_rules('full_name', 'full_name', 'required');
		$this->form_validation->set_rules('email', 'email', 'required');
		//$this->form_validation->set_message('password', 'password', 'required');
		$id = $this->input->post('id',TRUE);
        $error="";
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Roles/editRolespermission/'.$id, TRUE, 302);
		} else {
			$full_name = $this->input->post('full_name',TRUE);
			$email = $this->input->post('email',TRUE);
// 			$Role = $this->input->post('role',TRUE);
		//	$temppass = $this->input->post('password',TRUE);
            //$password = md5("kotal". $this->input->post('password',TRUE));
            $roles= $this->input->post('role',TRUE);
            $sendOtp=$this->input->post('sendotp');
            $fld_status = $this->input->post('fld_status',TRUE);
			$old_status= $this->input->post('old_status',TRUE);
            $role_name = $this->db->query("Select * from tbl_roles where role_id = '$roles'")->row()->role_name;
            $getqry = $this->db->query("SELECT * FROM tbl_users WHERE emp_id = '".$id."'");
            //$passchange = 1;
           
            if($getqry->num_rows() > 0){
                $old_data = $getqry->row();
               
                if($roles != $old_data->fld_role){
                   // $passchange = 0;
                  
                }
                $getqry = $this->db->query("UPDATE tbl_users SET fld_role = '".$roles."',fld_send_otp = '".$sendOtp."', fld_status='".$fld_status."' WHERE emp_id = '".$id."'" ); 
                
            }else{
                //$passchange = 0;
                $getqry = $this->db->query("INSERT INTO tbl_users (emp_id, fld_username, fld_email, fld_password, fld_role ,fld_status) VALUES ($id, '$full_name', '$email', '$password', '$roles', '$fld_status')"); 
            }
			
            if ($error != '') {
                $this->session->set_userdata(array('error_message' => $error));
                $this->output->set_header("Location: " . base_url() . 'Roles/editRolespermission/'.$id, TRUE, 302);
            } else {
				
				$this->load->library('phpmailer');
				//$getcode = $this->db->query("SELECT fld_username FROM tbl_users WHERE fld_email = '".$this->session->userdata('fld_email')."'")->row();
    		    //$display_name = $getqry->fld_username;
				//$data['emailaddress'] = $this->session->userdata('fld_email');
				$username = $this->session->userdata('fld_username');
      			//$email = $this->session->userdata('fld_email');
				//$password = $this->session->userdata('password');
    		    //Generte OTP
	            // $code = rand(1000,9999);
			    //$update = $this->db->query("UPDATE tbl_users SET fld_OTP = '".$code."' WHERE fld_email = '".$email."' OR fld_username = '".$username."'");
			    $settings=$this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row();
			    if($getqry){
			    /*if($passchange == 0){
			         $htmlMSG = $this->db->query("select * from tbl_email where fld_id = '3'")->row();
			    }else{
			         $htmlMSG = $this->db->query("select * from tbl_email where fld_id = '4'")->row();
			    }*/
			    $htmlMSG = $this->db->query("select * from tbl_email where fld_id = '3'")->row();
			    $subject = $htmlMSG->fld_subject;
                $htmlMSG = $htmlMSG->fld_email_body;
                
                $htmlMSG = str_replace('{user_name}', $full_name, $htmlMSG);
                $htmlMSG = str_replace('{email}', $email, $htmlMSG);
                $htmlMSG = str_replace('{pass_word}', $temppass, $htmlMSG);
                $htmlMSG = str_replace('{role}', $role_name, $htmlMSG);
                
    			$support_email = $email;
    	
    			$this->phpmailer->IsMail();
                $this->phpmailer->From   =   $settings->system_email;
     			$this->phpmailer->FromName  =  $settings->email_sender_name;
    			$this->phpmailer->IsHTML(true);
     			$this->phpmailer->AddAddress($support_email); 
     			$this->phpmailer->Subject  =   $subject;
     			$this->phpmailer->Body  =   $htmlMSG;
     			$this->phpmailer->Send();
     			$this->phpmailer->ClearAddresses();
     			
			if($old_status != $fld_status  ){
                  $success = "Account status has been changed.";
              }else{
                  $success = "We have assigned new role for you. please check your email and password.";
              }
              //$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
                // $success = "We have assigned new role for you. please check your email and password.";
                $this->session->set_userdata(array('success_message' => $success));
                 /****************** Activity Log *****************************/
        		$user_role=$this->session->userdata('user_role');
        		$user_role_name=$this->session->userdata('user_role_name');
        		$client_ip=$this->Gen->get_client_ip();
        		$address=$this->Base_model->getLocation($client_ip);
            	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
            	$date=date('Y-m-d H:i:s');
        		$user_id=$this->session->userdata('user_id');
        		$partner=$this->input->post('employee_code',TRUE);
        		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'UPDATE',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
				$this->output->set_header("Location: " . base_url() . 'Roles/assigned_roles/'.$id, TRUE, 302);
		   }
          }
		}
}

public function add_tempuser(){
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(183,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		
		$this->title = "New User";
		$data['view_scripts']=array(
    		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
    		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
    // 		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
    		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
    		$this->Gen->get_script_url('custom_js','role.js'),
		);
		
		$data['view_css']=array(
		    $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
       
		$data['users'] = $this->Common_model->getAllrows('tbl_users','',array('fld_user_type'=>3),'');
        $this->load_template('','roles/addtemp_user',$data);
    }

public function addTempUser(){
        $this->form_validation->set_rules('full_name', 'full_name', 'required');
		$this->form_validation->set_rules('email', 'email', 'required');
		$this->form_validation->set_rules('password','New Password','trim|required|min_length[4]');
// 		$this->form_validation->set_message('password', 'password', 'required');
		// $id = $this->input->post('id',TRUE);
        $error="";
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Roles/add_tempuser', TRUE, 302);
		} else {
		    
			$full_name = $this->input->post('full_name',TRUE);
			$email = $this->input->post('email',TRUE);
		//	$Role = $this->input->post('role',TRUE);
		    $mobile_number=$this->input->post('mobilenumber');
			$temppass = $this->input->post('password',TRUE);
// 			$conpass = $this->input->post('Cpassword',TRUE);
            $password = md5("kotal". $this->input->post('password',TRUE));
            $roles= $this->input->post('role',TRUE);
            $plant= $this->input->post('plant',TRUE);
            $sendOtp=$this->input->post('sendotp');
           
            $role_name = $this->db->query("Select * from tbl_roles where role_id = '$roles'")->row()->role_name;
            $plant_name = $this->db->query("Select * from tbl_locations where fld_id = '$plant'")->row()->fld_location;
            $fld_user_type = 3;
            
            $user_email = $this->db->query("Select * from tbl_users where fld_email = '$email'");
            
            
            // if($temppass != $conpass){
            //     $err = "Password Doesn't match. Please try again";
            //     $this->session->set_userdata(array('error_message' => $err));
            //     $this->output->set_header("Location: " . base_url() . 'Roles/add_tempuser', TRUE, 302);
            // }else
            if($user_email->num_rows() > 0){
                $err = "The email you enter is already exist";
                $this->session->set_userdata(array('error_message' => $err));
                $this->output->set_header("Location: " . base_url() . 'Roles/add_tempuser', TRUE, 302);
            }else{
            
          
            $getqry = $this->db->query("INSERT INTO tbl_users (emp_id, fld_username, fld_email, fld_password, fld_role,plant_id,fld_user_type,fld_mobile_number,fld_send_otp) VALUES (0, '$full_name', '$email', '$password', '$roles', '$plant', '$fld_user_type','$mobile_number','$sendOtp')"); 
			$insert_id = $this->db->insert_id();
			 
			$this->load->library('phpmailer');
			  //$getcode = $this->db->query("SELECT fld_username FROM tbl_users WHERE fld_email = '".$this->session->userdata('fld_email')."'")->row();
    		  //$display_name = $getqry->fld_username;
			  //$data['emailaddress'] = $this->session->userdata('fld_email');
				$username = $this->session->userdata('fld_username');
      		    //$email = $this->session->userdata('fld_email');
			    //$password = $this->session->userdata('password');
			    $settings=$this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row();
			    if($getqry){
			     $htmlMSG = $this->db->query("select * from tbl_email where fld_id = '3'")->row();        
			    /*if($passchange == 0){
			        $htmlMSG = $this->db->query("select * from tbl_email where fld_id = '3'")->row();  
			    }else{
			        $htmlMSG = $this->db->query("select * from tbl_email where fld_id = '4'")->row();
			    }*/
			    $sms_temp = $this->db->query("SELECT * FROM tbl_sms_api WHERE fld_id = '6'")->row();
			    $message = $sms_temp->fld_message_body;
			    $message = str_replace('{email}', $email, $message);
			    $message = str_replace('{user_name}', $full_name, $message);
			    $message = str_replace('{pass_word}', $temppass, $message);
			    $message = str_replace('{role}', $role_name, $message);
			    $message = str_replace('{plant}', $plant_name, $message);
			    $getdetail = $this->db->query("SELECT * FROM tbl_users WHERE (fld_id = '$insert_id' )")->row_array();
		        $this->sendSMS($getdetail,$message);
		       
			   
			    $subject = $htmlMSG->fld_subject;
                $htmlMSG = $htmlMSG->fld_email_body;
                
                $htmlMSG = str_replace('{user_name}', $full_name, $htmlMSG);
                $htmlMSG = str_replace('{email}', $email, $htmlMSG);
                $htmlMSG = str_replace('{pass_word}', $temppass, $htmlMSG);
                $htmlMSG = str_replace('{role}', $role_name, $htmlMSG);
                $htmlMSG = str_replace('{plant}', $plant_name, $htmlMSG);
                
    			$support_email = $email;
    	
    			$this->phpmailer->IsMail();
    			$this->phpmailer->From   =   $settings->system_email;
     			$this->phpmailer->FromName  =  $settings->email_sender_name;
    			$this->phpmailer->IsHTML(true);
     			$this->phpmailer->AddAddress($support_email); 
     			$this->phpmailer->Subject  =   $subject;
     			$this->phpmailer->Body  =   $htmlMSG;
     			$this->phpmailer->Send();
     			$this->phpmailer->ClearAddresses();
				
                //$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
                $success = "System assigned new role for email. please check the email for more details.";
                $this->session->set_userdata(array('success_message' => $success));
                /****************** Activity Log *****************************/
        		$user_role=$this->session->userdata('user_role');
        		$user_role_name=$this->session->userdata('user_role_name');
        		$client_ip=$this->Gen->get_client_ip();
        		$address=$this->Base_model->getLocation($client_ip);
            	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
            	$date=date('Y-m-d H:i:s');
        		$user_id=$this->session->userdata('user_id');
        		$partner=$this->input->post('full_name',TRUE);
        		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'ADD',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
				$this->output->set_header("Location: " . base_url() . 'Roles/manage_tempuser', TRUE, 302);
		        }
            }
		}
}
public function sendSMS($getdetail,$message){
		
		$sms_api_data=$this->Common_model->select_where_return_row('*','tbl_sms_api',array('fld_id'=>3));
		
		$customer_firstL=substr($getdetail['fld_mobile_number'], 0, 1);
		$customer_number="";
		$number="";
		
		if(!empty($getdetail) && @$getdetail['fld_mobile_number'] != ""){
			if($customer_firstL == 0){
		
			$number=ltrim(  str_replace('-', '', $getdetail['fld_mobile_number']), "0");
			$customer_number='92'.$number;
			}else{
			    
			$customer_number=$getdetail['fld_mobile_number'];
			}
		}


		if(!empty($sms_api_data) && $customer_number != ""){
		    
			send_sms($customer_number ,$sms_api_data,$message);
		}
		
		
	}

public function manage_tempuser(){
       
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		} 
		
		$this->title = "View Temporary users";
		$data['view_scripts']=array(
    		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
    		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
    // 		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
    		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
    		$this->Gen->get_script_url('custom_js','role.js'),
		);
		$data['view_css']=array(
		    $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
		$data['users']=$this->db->query("select * from tbl_users where fld_user_type='3'")->result_array();
        $this->load_template('','roles/manage_tempuser',$data);
    // 	$this->output->set_header("Location: " . base_url() . 'Roles/manage_tempuser', TRUE, 302);
		        
}

    public function deleteTempuser($id){
    		if (!$this->auth->is_logged()) {
    			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
    		}
    		$role_permissions  = explode(",",$this->session->userdata('permissions'));
    		if(!empty($role_permissions) && !in_array(185,$role_permissions)) {
    			$this->session->set_userdata(array('error_message' => "Access Denied!"));
    			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
    		}
    	    $delete_user=$this->Base_model->getRow('tbl_users','','fld_id='.$id.'');
    	    
    		$responce=$this->Base_model->delete('tbl_users','fld_id='.$id.'');
            if($responce){
                /****************** Activity Log *****************************/
        		$user_role=$this->session->userdata('user_role');
        		$user_role_name=$this->session->userdata('user_role_name');
        		$client_ip=$this->Gen->get_client_ip();
        		$address=$this->Base_model->getLocation($client_ip);
            	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
            	$date=date('Y-m-d H:i:s');
        		$user_id=$this->session->userdata('user_id');
        		$partner=$delete_user['fld_username'];
        		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'DELETED',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
    			$this->session->set_userdata(array('success_message' => "User deleted successfully"));
    			$this->output->set_header("Location: " . base_url() . 'Roles/manage_tempuser', TRUE, 302);
    		}else{
    			$this->session->set_userdata(array('error_message' => "Role not deleted.Something went wrong"));
    			$this->output->set_header("Location: " . base_url() . 'Roles/manage_tempuser', TRUE, 302);
    		}
    }
    
    public function edittempuser($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(184,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$data['view_scripts']=array(
		    $this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
		);
		$data['view_css']=array(
		    $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
        $this->title = "Edit Temporary User "; 
		$data['user']=$this->Base_model->getRow('tbl_users','','fld_id ='.$id.'');
        $this->load_template('','roles/editTempuser',$data);
	}
	
	public function edittempuserProcess(){
        $this->form_validation->set_rules('full_name', 'full_name', 'required');
		$this->form_validation->set_rules('email', 'email', 'required');
	//	$this->form_validation->set_message('password', 'password', 'required');
	//	$this->form_validation->set_message('Cpassword', 'Password Confirmation', 'required|matches[password]');
	    $id = $this->input->post('fld_id',TRUE);
        $error="";
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Roles/edittempuser/'.$id, TRUE, 302);
		} else {
		    
			$full_name = $this->input->post('full_name',TRUE);
			$email = $this->input->post('email',TRUE);
		//	$Role = $this->input->post('role',TRUE);
		//	$temppass = $this->input->post('password',TRUE);
		//	$conpass = $this->input->post('Cpassword',TRUE);
		//	$oldpass = $this->input->post('old_pass',TRUE);
			$fld_status = $this->input->post('fld_status',TRUE);
			$old_status= $this->input->post('old_status',TRUE);
// 			echo $old_status;
// 			exit;
           // $password = md5("kotal". $this->input->post('password',TRUE));
            $roles= $this->input->post('role',TRUE);
            $plant= $this->input->post('plant',TRUE);
            $old_role= $this->input->post('old_role',TRUE);
            
            
            $mobilenumber= $this->input->post('mobilenumber',TRUE);
            $role_name = $this->db->query("Select * from tbl_roles where role_id = '$roles'")->row()->role_name;
            $plant_name = $this->db->query("Select * from tbl_locations where fld_id = '$roles'")->row()->fld_location;
            $sendotp= $this->input->post('sendotp',TRUE);
            $fld_user_type = 3;
           
            
            //if($temppass == '' && $conpass == ''){
                $this->db->query("UPDATE tbl_users SET fld_role = '".$roles."', plant_id = '".$plant."', fld_email = '".$email."',fld_username = '".$full_name."', fld_user_type = '".$fld_user_type."', fld_status = '".$fld_status."',fld_send_otp = '".$sendotp."' WHERE fld_id = '".$id."'");
                $msg = "Record updated successfully.";
               
                $this->session->set_userdata(array('success_message' => $msg));
                $settings=$this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row();
            $getqry = $this->db->query("UPDATE tbl_users SET fld_role = '".$roles."', plant_id = '".$plant."', fld_email = '".$email."',fld_username = '".$full_name."', fld_user_type = '".$fld_user_type."', fld_status = '".$fld_status."',fld_mobile_number = '".$mobilenumber."',fld_send_otp = '".$sendotp."' WHERE fld_id = '".$id."'");
			$this->load->library('phpmailer');
			    
			if($getqry){
			    
			    if($old_role != $roles  ){
			    $sms_temp = $this->db->query("SELECT * FROM tbl_sms_api WHERE fld_id = '8'")->row();
			    $message = $sms_temp->fld_message_body;
			    $message = str_replace('{email}', $email, $message);
			    $message = str_replace('{user_name}', $full_name, $message);
			    $message = str_replace('{role}', $role_name, $message);
			    $message = str_replace('{plant}', $plant_name, $message);
			    $getdetail = $this->db->query("SELECT * FROM tbl_users WHERE (fld_id = '$id' )")->row_array();
		        $this->sendSMS($getdetail,$message);
		       
			    
			    $email = $this->input->post('email',TRUE);
			    $htmlMSG = $this->db->query("select * from tbl_email where fld_id = 5")->row();
			    $subject = $htmlMSG->fld_subject;
                $htmlMSG = $htmlMSG->fld_email_body;
                $htmlMSG = str_replace('{user_name}', $full_name, $htmlMSG);
                $htmlMSG = str_replace('{email}', $email, $htmlMSG);
                // $htmlMSG = str_replace('{pass_word}', $temppass, $htmlMSG);
                $htmlMSG = str_replace('{role}', $role_name, $htmlMSG);
                $htmlMSG = str_replace('{plant}', $plant_name, $htmlMSG);
    			$support_email = $email;
    			$this->phpmailer->IsMail();     
     			$this->phpmailer->From   =   $settings->system_email;
     			$this->phpmailer->FromName  =  $settings->email_sender_name;
    			$this->phpmailer->IsHTML(true);
     			$this->phpmailer->AddAddress($support_email); 
     			$this->phpmailer->Subject  =   $subject;
     			$this->phpmailer->Body  =   $htmlMSG;
     			$this->phpmailer->Send();
     			$this->phpmailer->ClearAddresses();
			    }
              //$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
              if($old_role != $roles  ){
                $success = "System assigned new role for email. please check the email for more details.";
              }else if($old_status != $fld_status  ){
                  $success = "Account status has been changed.";
              }
                $this->session->set_userdata(array('success_message' => $success));
                /****************** Activity Log *****************************/
        		$user_role=$this->session->userdata('user_role');
        		$user_role_name=$this->session->userdata('user_role_name');
        		$client_ip=$this->Gen->get_client_ip();
        		$address=$this->Base_model->getLocation($client_ip);
            	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
            	$date=date('Y-m-d H:i:s');
        		$user_id=$this->session->userdata('user_id');
        		$partner=$this->input->post('full_name',TRUE);
        		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'UPDATE',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
				$this->output->set_header("Location: " . base_url() . 'Roles/manage_tempuser', TRUE, 302);
		    }
                $this->output->set_header("Location: " . base_url() . 'Roles/manage_tempuser', TRUE, 302);
           /* }elseif($temppass != '' && $conpass != '' && $temppass != $conpass){
                $err = "Password Doesn't match. Please try again";
                $this->session->set_userdata(array('error_message' => $err));
                $this->output->set_header("Location: " . base_url() . 'Roles/add_tempuser', TRUE, 302);
            }else{
            
          $settings=$this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row();
            $getqry = $this->db->query("UPDATE tbl_users SET fld_password = '".$password."', fld_role = '".$roles."', fld_email = '".$email."',fld_username = '".$full_name."', fld_user_type = '".$fld_user_type."', fld_status = '".$fld_status."' WHERE fld_id = '".$id."'");
			$this->load->library('phpmailer');
			    
			if($getqry){
			    $sms_temp = $this->db->query("SELECT * FROM tbl_sms_api WHERE fld_id = '7'")->row();
			    $message = $sms_temp->fld_message_body;
			    $message = str_replace('{email}', $email, $message);
			    $message = str_replace('{user_name}', $full_name, $message);
			    $message = str_replace('{pass_word}', $temppass, $message);
			    $message = str_replace('{role}', $role_name, $message);
			    $getdetail = $this->db->query("SELECT * FROM tbl_users WHERE (fld_id = '$id' )")->row_array();
		        $this->sendSMS($getdetail,$message);
		        if($old_role != $roles){
			    $sms_temp = $this->db->query("SELECT * FROM tbl_sms_api WHERE fld_id = '8'")->row();
			    $message = $sms_temp->fld_message_body;
			    $message = str_replace('{email}', $email, $message);
			    $message = str_replace('{user_name}', $full_name, $message);
			    $message = str_replace('{role}', $role_name, $message);
			    $getdetail = $this->db->query("SELECT * FROM tbl_users WHERE (fld_id = '$id' )")->row_array();
		        $this->sendSMS($getdetail,$message);
			    }
			    
			    $email = $this->input->post('email',TRUE);
			    $htmlMSG = $this->db->query("select * from tbl_email where fld_id = 4")->row();
			    $subject = $htmlMSG->fld_subject;
                $htmlMSG = $htmlMSG->fld_email_body;
                $htmlMSG = str_replace('{user_name}', $full_name, $htmlMSG);
                $htmlMSG = str_replace('{email}', $email, $htmlMSG);
                $htmlMSG = str_replace('{pass_word}', $temppass, $htmlMSG);
                $htmlMSG = str_replace('{role}', $role_name, $htmlMSG);
    			$support_email = $email;
    			$this->phpmailer->IsMail();     
                $this->phpmailer->From   =   $settings->system_email;
     			$this->phpmailer->FromName  =  $settings->email_sender_name;
    			$this->phpmailer->IsHTML(true);
     			$this->phpmailer->AddAddress($support_email); 
     			$this->phpmailer->Subject  =   $subject;
     			$this->phpmailer->Body  =   $htmlMSG;
     			$this->phpmailer->Send();
     			$this->phpmailer->ClearAddresses();
              //$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
                $success = "System assigned new role for email. please check the email for more details.";
                $this->session->set_userdata(array('success_message' => $success));
               
        		$user_role=$this->session->userdata('user_role');
        		$user_role_name=$this->session->userdata('user_role_name');
        		$client_ip=$this->Gen->get_client_ip();
        		$address=$this->Base_model->getLocation($client_ip);
            	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
            	$date=date('Y-m-d H:i:s');
        		$user_id=$this->session->userdata('user_id');
        		$partner=$this->input->post('full_name',TRUE);
        		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'UPDATE',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
				$this->output->set_header("Location: " . base_url() . 'Roles/manage_tempuser', TRUE, 302);
		    }
            }*/
		}
}

	public function deleteRoles($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(51,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$role=$this->Base_model->getRow('tbl_roles','role_id ='.$id.'');
		$responce=$this->Base_model->delete('tbl_roles','role_id ='.$id.'');
        if($responce){
             /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=$role['role_name'];
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'DELETED',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Role deleted successfully"));
			$this->output->set_header("Location: " . base_url() . 'Roles/manage_Roles', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Role not deleted.Something went wrong"));
			$this->output->set_header("Location: " . base_url() . 'Roles/manage_Roles', TRUE, 302);
		}
	}
	
	public function delete_user($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
// 		$responce=$this->Base_model->delete('tbl_users','emp_id ='.$id.'');
// echo "update tbl_users set fld_status = '2' where fld_id ='$id'";
// exit;
        $deleted_user=$this->Base_model->getRow('tbl_users','fld_id ='.$id.'');
        $deleted_employee=$this->Base_model->getRow('tbl_employees','id ='.$deleted_user['emp_id'].'');
        $responce = $this->db->query("update tbl_users set fld_status = '2' where fld_id ='$id'");
        if($responce){
            /****************** Activity Log *****************************/
        		$user_role=$this->session->userdata('user_role');
        		$user_role_name=$this->session->userdata('user_role_name');
        		$client_ip=$this->Gen->get_client_ip();
        		$address=$this->Base_model->getLocation($client_ip);
            	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
            	$date=date('Y-m-d H:i:s');
        		$user_id=$this->session->userdata('user_id');
        		$partner=@$deleted_employee['employee_code'];
        		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'DELETED',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "User deleted successfully"));
			$this->output->set_header("Location: " . base_url() . 'Roles/assigned_roles', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "User not deleted.Something went wrong"));
			$this->output->set_header("Location: " . base_url() . 'Roles/assigned_roles', TRUE, 302);
		}
	}
	
		public function active_user($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
// 		$responce=$this->Base_model->delete('tbl_users','emp_id ='.$id.'');
// echo "update tbl_users set fld_status = '2' where fld_id ='$id'";
// exit;
        $responce = $this->db->query("update tbl_users set fld_status = '1' where fld_id ='$id'");
        if($responce){
			$this->session->set_userdata(array('success_message' => "User retrieved successfully"));
			$this->output->set_header("Location: " . base_url() . 'Roles/assigned_roles', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "User not retrieved.Something went wrong"));
			$this->output->set_header("Location: " . base_url() . 'Roles/assigned_roles', TRUE, 302);
		}
	}
	
    public function getFilterEmployee_Role(){
	   // print_r($_POST);
	   // exit();
	    $whereData = array();
	   if(!empty($_POST['search_by_id'])){
	       $whereData['employee_code'] = $_POST['search_by_id'];
	   }
	   if(!empty($_POST['fld_emp_name'])){
	       $whereData['full_name'] = $_POST['fld_emp_name'];
	   }
	   if(!empty($_POST['plants'])){
	       $whereData['plants'] = $_POST['plants'];
	   }
	   if(!empty($_POST['designation'])){
	       $whereData['designation'] = $_POST['designation'];
	   }
	   //if(!empty($_POST['department'])){
	   //    $whereData['department'] = $_POST['department'];
	   //}
	   
	   $role_filter = $_POST['role'];
	   $data = array();
	   $filteredEmployee = $this->Base_model->getAll('tbl_employees', '*', $whereData);
	   
	   if($filteredEmployee){
	        $table = '';
	        
            foreach($filteredEmployee as $emp){ 
            $designation = 	$this->Common_model->select_single_field('designation_name','tbl_designation',array('id'=>$emp['designation']));       
            $department  =	$this->Common_model->select_single_field('department_name','tbl_departments',array('id'=>$emp['department']));
			$plant       =	$this->Common_model->select_single_field('fld_location','tbl_locations',array('fld_id'=>$emp['plants']));
			$role ='';
			$roleId = 0;
            $user_d =	$this->db->query("SELECT * from tbl_users where emp_id = '{$emp['id']}'");
            if($user_d->num_rows() > 0){
                $user = $user_d->row();
                $roleId = $user->fld_role;
                $role =	$this->Common_model->select_single_field('role_name','tbl_roles',array('role_id'=>$roleId)); 
            }
			
			if($role_filter == 2){
			    if($roleId > 0){
			         $table .= '<tr>
                            <td>'.$emp['employee_code'].'</td>
                            <td>'.$emp['full_name'].'</td>
							<td>'.$plant.'</td>
                            <td>'.$designation.'</td>
                            <td>'.$role.'</td>
                            <td>
                            <a href="'.base_url('Roles/editRolespermission/'.$emp['id'].'').'">
                            <i style="font-size:20px;cursor:pointer;" class="mdi mdi-square-edit-outline" title="Edit"></i></a>
                            <a href="'.base_url('').'" onclick="return confirm(\'Are you sure you want to delete this record.\')">
                            <i style="font-size:20px;cursor:pointer;" class="mdi mdi-delete-forever" title="Delete"></i>
                            </a>
							</td>
							
                            
                        </tr>';
			    }
			}else{
			     $table .= '<tr>
                            <td>'.$emp['employee_code'].'</td>
                            <td>'.$emp['full_name'].'</td>
							<td>'.$plant.'</td>
                            <td>'.$designation.'</td>
                            <td>'.$role.'</td>
                            <td>
                            <a href="'.base_url('Roles/assignUserRole/'.$emp['id'].'').'">
                            <i style="font-size:20px;cursor:pointer;" class="mdi mdi-square-edit-outline" title="Edit"></i></a>
                            <a href="'.base_url('').'" onclick="return confirm(\'Are you sure you want to delete this record.\')">
                            <i style="font-size:20px;cursor:pointer;" class="mdi mdi-delete-forever" title="Delete"></i>
                            </a>
							</td>
							
                            
                        </tr>';
			}
			
		
            
                
            }
            
	       
	        
        	    }else {
        	    
        	$table = '
        <tr>
            <td colspan="9"><br><p style="color:#900;" >Sorry No Record Found!</p></td>
            <td style="display: none;"></td>
            <td style="display: none;"></td>
            <td style="display: none;"></td>
            <td style="display: none;"></td>
            <td style="display: none;"></td>
        </tr>';
         }
         
         echo $table;
	}
	
	
// 	assign new Roles
	public function assign_roles(){
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
// 		$role_permissions  = explode(",",$this->session->userdata('permissions'));
// 		if(!empty($role_permissions) && !in_array(183,$role_permissions)) {
// 			$this->session->set_userdata(array('error_message' => "Access Denied!"));
// 			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
// 		}
		$this->title = "New User ";
		$data['view_scripts']=array(
    		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
    		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
    // 		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
    		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
    		$this->Gen->get_script_url('custom_js','role.js'),
		);
		$data['view_css']=array(
		    $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
		$data['employees']= $this->db->query("SELECT * FROM `tbl_employees` WHERE id NOT IN (SELECT emp_id FROM tbl_users)")->result_array();
    //   $data['employees']= $this->Base_model->getAll('tbl_employees');
// 		$data['users'] = $this->Common_model->getAllrows('tbl_users','',array('fld_user_type'=>3),'');
		
        $this->load_template('','roles/assign_roles',$data);
    }
    public function assign_new_roles(){
        $this->form_validation->set_rules('full_name', 'full_name', 'required');
		$this->form_validation->set_rules('email', 'email', 'required');
// 		$this->form_validation->set_message('password', 'password', 'required');
		$this->form_validation->set_rules('password','New Password','trim|required|min_length[4]');
// 		$this->form_validation->set_message('Cpassword', 'Password Confirmation', 'required|matches[password]');
		// $id = $this->input->post('id',TRUE);
        $error="";
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Roles/add_tempuser', TRUE, 302);
		} else {
		    
			$full_name = $this->input->post('full_name',TRUE);
			$email = $this->input->post('email',TRUE);
			$id = $this->input->post('emp_id',TRUE);
			$temppass = $this->input->post('password',TRUE);
// 			$conpass = $this->input->post('Cpassword',TRUE);
            $password = md5("kotal". $this->input->post('password',TRUE));
            $roles= $this->input->post('role',TRUE);
            $sendOtp=$this->input->post('sendotp');
            $role_name = $this->db->query("Select * from tbl_roles where role_id = '$roles'")->row()->role_name;
            // $fld_user_type = 3;
            
            // if($temppass != $conpass){
            //     $err = "Password Doesn't match. Please try again";
            //     $this->session->set_userdata(array('error_message' => $err));
            //     $this->output->set_header("Location: " . base_url() . 'Roles/add_tempuser', TRUE, 302);
            // }else{
            
          
            $getqry = $this->db->query("INSERT INTO tbl_users (emp_id, fld_username, fld_email, fld_password, fld_role,fld_send_otp) VALUES ($id, '$full_name', '$email', '$password', '$roles','$sendOtp')"); 
			$this->load->library('phpmailer');
			  //$getcode = $this->db->query("SELECT fld_username FROM tbl_users WHERE fld_email = '".$this->session->userdata('fld_email')."'")->row();
    		  //$display_name = $getqry->fld_username;
			  //$data['emailaddress'] = $this->session->userdata('fld_email');
				$username = $this->session->userdata('fld_username');
      		  //$email = $this->session->userdata('fld_email');
			  //$password = $this->session->userdata('password');
			    $settings=$this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row();
			    if($getqry){
			     $htmlMSG = $this->db->query("select * from tbl_email where fld_id = '3'")->row();        
			    /*if($passchange == 0){
			        $htmlMSG = $this->db->query("select * from tbl_email where fld_id = '3'")->row();  
			    }else{
			        $htmlMSG = $this->db->query("select * from tbl_email where fld_id = '4'")->row();
			    }*/
			   
			    $subject = $htmlMSG->fld_subject;
                $htmlMSG = $htmlMSG->fld_email_body;
                
                $htmlMSG = str_replace('{user_name}', $full_name, $htmlMSG);
                $htmlMSG = str_replace('{email}', $email, $htmlMSG);
                $htmlMSG = str_replace('{pass_word}', $temppass, $htmlMSG);
                $htmlMSG = str_replace('{role}', $role_name, $htmlMSG);
                
    			$support_email = $email;
    	
    			$this->phpmailer->IsMail();     
     			
                $this->phpmailer->From   =   $settings->system_email;
     			$this->phpmailer->FromName  =  $settings->email_sender_name;
    			$this->phpmailer->IsHTML(true);
     			$this->phpmailer->AddAddress($support_email); 
     			$this->phpmailer->Subject  =   $subject;
     			$this->phpmailer->Body  =   $htmlMSG;
     			$this->phpmailer->Send();
     			$this->phpmailer->ClearAddresses();
				
                //$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
                $success = "System assigned new role for email. please check the email for more details.";
                $this->session->set_userdata(array('success_message' => $success));
                 /****************** Activity Log *****************************/
        		$user_role=$this->session->userdata('user_role');
        		$user_role_name=$this->session->userdata('user_role_name');
        		$client_ip=$this->Gen->get_client_ip();
        		$address=$this->Base_model->getLocation($client_ip);
            	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
            	$date=date('Y-m-d H:i:s');
        		$user_id=$this->session->userdata('user_id');
        		$partner=$this->input->post('emp_id',TRUE);
        		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'ADD',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
				$this->output->set_header("Location: " . base_url() . 'Roles/assigned_roles', TRUE, 302);
		      //  }
            }
		}
}
	public function changePassword($id)
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
		  	$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.2.0/js/bootstrap.min.js'),
		  	
		);
		
		$data['view_css']=array(
		   $this->Gen->get_script_url('theme_css','style.css'),
		);
		
		
		$data['employees']= $this->db->query("SELECT * FROM `tbl_users`")->result_array();
		$data['emp_id']=$id;
        $this->load_template('','roles/change_pass',$data);
    }
    public function changePasswordProcess()
    {
        $this->load->library('phpmailer');
        if($this->input->post()){
		    
    		$this->form_validation->set_rules('new_password','New Password','trim|required|min_length[4]');
		    $fld_id = $this->input->post('emp_id');
    		
    		if($this->form_validation->run() === FALSE) {
    			
    			$this->session->set_userdata(array('error_message' => validation_errors()));
                redirect(base_url().'Roles/changePassword/'.$fld_id.'');
    		} else {
    			$fld_id = $this->input->post('emp_id');
    			$query = $this->Common_model->select_where('fld_id','tbl_users',array('fld_id'=>$fld_id));
    			$user_det = $this->Common_model->select_where('*','tbl_users',array('fld_id'=>$fld_id));
    			$user_detail=$user_det->row_array();
    		
    			if($query->num_rows() > 0) {
    			    $roles=$user_detail['fld_role'];
    		        $role_name = $this->db->query("Select * from tbl_roles where role_id = '$roles'")->row()->role_name;
    				$datap['fld_password']		= 	md5("kotal" . $this->input->post('new_password'));
    				//$reset_hash					= 	$this->input->post('reset_hash');
    				//$data['reset_hash']			= 	"";
    				$new_password=$this->input->post('new_password');
    				$this->Common_model->update_array(array('fld_id'=>$fld_id),'tbl_users',$datap);
    				$sms_temp = $this->db->query("SELECT * FROM tbl_sms_api WHERE fld_id = '7'")->row();
    			    $message = $sms_temp->fld_message_body;
    			    $message = str_replace('{email}', $user_detail['fld_email'], $message);
    			    $message = str_replace('{user_name}', $user_detail['fld_username'], $message);
    			    $message = str_replace('{pass_word}', $new_password, $message);
    			    $message = str_replace('{role}', $role_name, $message);
    			   
    			    $getdetail = $this->db->query("SELECT * FROM tbl_users WHERE (fld_id = '$fld_id' )")->row_array();
    		        $this->sendSMS($getdetail,$message);
    		        $settings=$this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row();
    		        
    		        $email = $this->input->post('email',TRUE);
    			    $htmlMSG = $this->db->query("select * from tbl_email where fld_id = 12")->row();
    			    $subject = $htmlMSG->fld_subject;
                    $htmlMSG = $htmlMSG->fld_email_body;
                    $htmlMSG = str_replace('{user_name}', $user_detail['fld_username'], $htmlMSG);
                    $htmlMSG = str_replace('{email}', $user_detail['fld_email'], $htmlMSG);
                    $htmlMSG = str_replace('{pass_word}', $new_password, $htmlMSG);
                    $htmlMSG = str_replace('{role}', $role_name, $htmlMSG);
                     
        			$support_email = $user_detail['fld_email'];
        			$this->phpmailer->IsMail();     
                    $this->phpmailer->From   =   $settings->system_email;
         			$this->phpmailer->FromName  =  $settings->email_sender_name;
        			$this->phpmailer->IsHTML(true);
         			$this->phpmailer->AddAddress($support_email); 
         			$this->phpmailer->Subject  =   $subject;
         			$this->phpmailer->Body  =   $htmlMSG;
         			$this->phpmailer->Send();
         			
         			$this->phpmailer->ClearAddresses();
    				$this->session->set_userdata(array('success_message' => "Password updated successfully;"));
                     redirect(base_url().'Roles/changePassword/'.$fld_id.'');
    				
    				
    			} else{
    				$err = "User not exist";
                    $this->session->set_userdata(array('error_message' => $err));
                    redirect(base_url().'Roles/changePassword/'.$fld_id.'');
    			}
    			
    
    		}
		    
		}
        
    }
    
    
}

