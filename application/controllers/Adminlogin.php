<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Adminlogin extends My_controller {
    
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 	http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 
	function __construct(){
		parent::__construct();
		$this->load->library('phpmailer');
		$this->load->model('Change_pass_model');
		$this->load->model('Common_model');
		$this->load->helper('sms');
	}
	 
	public function index()
    {
		if ($this->auth->is_logged()) {

			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
        $this->title = "Proceed Login";

        $data['settings']=$this->Base_model->getRow('tbl_general_settings');

        $this->load_template('login','login',$data);
    }
    
    public function forgotpass()
    {
		if ($this->auth->is_logged()) {

			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
        $this->title = "Forget Password | ".$this->title;

        $this->load->view('forget_password');
    }
    
    public function Change_pass()
    {
        $this->title = "Change Password | ".$this->title;
        $this->load->view('change_password');
    }
    
    
    public function submit_forgot() {
		$this->form_validation->set_rules('email', 'Email Address', 'required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata(array('error_message' => validation_errors()));
                    $this->output->set_header("Location: " . base_url() . 'Adminlogin/forgotpass', TRUE, 302);
		} else {
		    
			$email = $this->input->post('email',TRUE);
			$settings=$this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row();
			$qry = $this->db->query("SELECT * FROM tbl_users WHERE fld_email = '".$email."'")->row();
			if(!empty($qry->fld_email)){
			$string_length 		= 	substr((md5(uniqid(rand(), 1))), 0,30);
			$activation_link  	=	'<a href="'.base_url().'Adminlogin/Change_pass/'.$qry->fld_id.'">'.base_url().'Adminlogin/Change_pass/'.$qry->fld_id.'</a>';
                
    // 			$message   =   "Hi Please Click on the below link to reset your password"."\n";
    // 			$message  .=   "Link: ".$activation_link."\n";
			 //   $message  .=   "Thanks!";
			 $htmlMSG = $this->db->query("select * from tbl_email where fld_id = '4'")->row();
			    $subject = $htmlMSG->fld_subject;
                $htmlMSG = $htmlMSG->fld_email_body;
                
                $htmlMSG = str_replace('{activation_link}', $activation_link, $htmlMSG);

    		 // $support_email = settings('support_email'); 
    			$support_email = $email;
    	
    			$this->phpmailer->IsMail();
                $this->phpmailer->From   =   $settings->system_email;
     			$this->phpmailer->FromName  =  $settings->email_sender_name;
    // 			$this->phpmailer->From   =   $support_email;
    // 			$this->phpmailer->FromName  =  "Kotal ERP System";
    			$this->phpmailer->IsHTML(true);
    			$this->phpmailer->AddAddress($support_email); 
    // 			$this->phpmailer->Subject  =   "Kotal ERP System";
                $this->phpmailer->Subject  =   $subject;
    // 			$this->phpmailer->Body  =   nl2br($message);
    	        $this->phpmailer->Body  =   $htmlMSG;
    			$this->phpmailer->Send();
    			$this->phpmailer->ClearAddresses();
    			
    			$this->session->set_userdata(array('success_message' => "Please check your email inbox or spam/junk folder to choose your new password."));
                $this->output->set_header("Location: " . base_url() . 'Adminlogin', TRUE, 302);
    			
			}else{
			    $this->session->set_userdata(array('error_message' => "Invalid Email!, Please enter your correct email address."));
                $this->output->set_header("Location: " . base_url() . 'Adminlogin/forgotpass', TRUE, 302);
			}
		}
	}
	
	function update_pass()
	{
		$this->form_validation->set_rules('new_password','New Password','trim|required');
		
		if($this->form_validation->run() === FALSE) {
			$this->load->view('change_password');
		} else {
		    
			$fld_id = $this->input->post('fld_id');
// 			echo $fld_id;
// 			exit;
			$query = $this->Common_model->select_where('fld_id','tbl_users',array('fld_id'=>$fld_id));
			if($query->num_rows() > 0) {
			    $pass=$this->input->post('new_password');
				$data['fld_password']		= 	md5("kotal" .$pass );
				//$reset_hash					= 	$this->input->post('reset_hash');
				//$data['reset_hash']			= 	"";
				
				$this->Common_model->update_array(array('fld_id'=>$fld_id),'tbl_users',$data);
				
					$sms_temp = $this->db->query("SELECT * FROM tbl_sms_api WHERE fld_id = '8'")->row();
    			    $message = $sms_temp->fld_message_body;
    			    $gry = $this->db->query("SELECT * FROM tbl_users WHERE fld_id= '$fld_id'")->row();
    			    $message = str_replace('{email}', $gry->fld_email, $message);
    			    $message = str_replace('{pass_word}', $pass, $message);
    			   
    			    $getdetail = $this->db->query("SELECT * FROM tbl_users WHERE (fld_id = '$fld_id' )")->row_array();
    		        $this->sendSMS($getdetail,$message);
				
				
				
				$htmlMSG = $this->db->query("select * from tbl_email where fld_id = 12")->row();
				$settings=$this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row();
			    $subject = $htmlMSG->fld_subject;
                $htmlMSG = $htmlMSG->fld_email_body;
                // $gry = $this->db->query("SELECT * FROM tbl_users WHERE fld_id= '$fld_id'")->row();
                $htmlMSG = str_replace('{email}', $gry->fld_email, $htmlMSG);
                $htmlMSG = str_replace('{pass_word}', $pass, $htmlMSG);
    			$support_email = $gry->fld_email;
    // 			echo $support_email;
    // 			exit;
    			$this->phpmailer->IsMail();     
     			$this->phpmailer->From   =   $settings->system_email;
     			$this->phpmailer->FromName  =  $settings->email_sender_name;
    			$this->phpmailer->IsHTML(true);
     			$this->phpmailer->AddAddress($support_email); 
     			$this->phpmailer->Subject  =   $subject;
     			$this->phpmailer->Body  =   $htmlMSG;
     			$this->phpmailer->Send();
     			$this->phpmailer->ClearAddresses();
				
				$this->session->set_userdata(array('success_message' => "Password has updated successfully."));
                $this->output->set_header("Location: " . base_url() . 'Adminlogin', TRUE, 302);
				
			} else{
				$this->session->set_userdata(array('error_message' => "OPPS! Invalid link"));
                $this->output->set_header("Location: " . base_url() . 'Adminlogin/Change_pass', TRUE, 302);
			}

		}
	}
    
/*	public function do_login() {
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_message('password', 'Password', 'required');
        $error="";
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata(array('error_message' => validation_errors()));
                    $this->output->set_header("Location: " . base_url() . 'Adminlogin', TRUE, 302);
		} else {
		    
		    
			$email = $this->input->post('username',TRUE);
            $password = $this->input->post('password',TRUE);
            if ($email == '' || $password == '' || $this->auth->login($email, $password) === FALSE) {
                $error = "Username or password incorrect.";
            }
            $getemployeestatus =	$this->Common_model->select_single_field('is_active','tbl_employees',array('email'=>$email));
            $getemployeedeleted =	$this->Common_model->select_single_field('deleted','tbl_employees',array('email'=>$email));
            $getemployeestatus = $this->db->query("SELECT * FROM tbl_employees WHERE email = '$email'");
           
            if($getemployeestatus->num_rows() > 0){
                $getemployeestatusdata = $getemployeestatus->row_array();
                 
                if($getemployeestatusdata['is_active'] == 2 || $getemployeestatusdata['deleted']==1){
                    $error = "Your account is Disabled. Please contact your administrator.";
                }
            }
            
            if ($error != '') {
                $this->auth->logout();
                
                $this->session->set_userdata(array('error_message' => $error));
                redirect('Adminlogin');
                exit;
           
            } else {
                
            //  $empemail = $this->session->userdata('fld_email');
            //     $userrole = $this->session->userdata('user_role');
            //     $getemployeestatus = $this->Common_model->select_where_return_row('*','tbl_employees',array('email'=>$empemail));
            //     $getstatus = $getemployeestatus->is_active;
            //     if($userrole == 1){
            //           $this->output->set_header("Location: " . base_url('home'), TRUE, 302);
            //     }elseif($getstatus == 0){
                    
            //     }else{
            //              $err = "Sorry Your Account is disabled. Please contact your supervision.";
            //              $this->session->set_userdata(array('error_message' => $err));
            //              $this->output->set_header("Location: " . base_url() . 'Adminlogin', TRUE, 302);
            //     }
                
                $this->output->set_header("Location: " . base_url('home'), TRUE, 302);
            }
		}
		
		
	}*/
	
	
	
	public function login_otp(){
		
		$data['email'] =$email= $this->session->userdata('fld_email');
	    $getqry = $this->db->query("SELECT * FROM tbl_users WHERE (fld_username = '$email' || fld_email = '$email')")->row();
	    $data['fld_mobile_number']=@$getqry->fld_mobile_number;
	    
		$this->title = "Verify via OTP";
		$data['settings']=$this->Base_model->getRow('tbl_general_settings');
        $this->load->view('login_otp',$data);
		
	}
	
	public function do_login() {
		$this->form_validation->set_rules('username', 'Email / Username', 'required');
		$this->form_validation->set_message('password', 'Password', 'required');
        $error="";
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Adminlogin', TRUE, 302);
		} else {
		    
			$email = $this->input->post('username',TRUE);
			
            $password = $this->input->post('password',TRUE);
			if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$isemail = $email;
				//return true;
                //echo $isemail;exit;				
			}else {
				$isUsename = $email;
				//echo $isUsename;exit;
			}
			
			if(isset($isemail)){
			   
				$getqry = $this->db->query("SELECT * FROM tbl_users WHERE fld_email = '".$isemail."' AND fld_password = '".md5("kotal" . $password)."'")->num_rows();
				if($getqry == 0){
				    
				//if ($email == '' || $password == '' || $this->auth->login($email, $password) === FALSE) {
				//if ($email != $isemail || $password != md5("kotal" . $password)) {
					$error = "Email or password incorrect.";
				}
			}else{
				$getqry = $this->db->query("SELECT * FROM tbl_users WHERE fld_username = '".$isUsename."'  AND fld_password = '".md5("kotal" . $password)."'")->num_rows();
				if($getqry == 0){
				    
				//if ($email == '' || $password == '' || $this->auth->login($email, $password) === FALSE) {
					$error = "Email or password incorrect.";
				}
			}
			
		
			//echo '<pre>';
              // print_r($getqry);
              // exit;
			
            if ($error != '') {
                $this->session->set_userdata(array('error_message' => $error));
                $this->output->set_header("Location: " . base_url() . 'Adminlogin', TRUE, 302);
            } else {
                $getqry = $this->db->query("SELECT * FROM tbl_users WHERE (fld_username = '$email' || fld_email = '$email')  AND fld_password = '".md5("kotal" . $password)."'")->row();
                $roleid= $getqry->fld_role;
                $getrole= $this->db->query("SELECT * FROM tbl_roles WHERE role_id = '$roleid' ")->num_rows();
                // $getstatus = $this->db->query("SELECT * FROM tbl_users WHERE role_id = '$roleid'  ");
                
    			 if($getrole == 0){
    			     
    			     //$this->session->sess_destroy();
    			      $this->session->set_userdata(array('error_message' => "Your role has been removed by administrator. Please contact your administrator for this inconvenience "));
    			      redirect('Adminlogin');
                    //  $this->output->set_header("Location: " . base_url() . 'Adminlogin', TRUE, 302);
                    exit;
        			 }
        			  if($getqry->fld_status == 2){
        			      
    			     
    			     //$this->session->sess_destroy();
    			      $this->session->set_userdata(array('error_message' => "This account is In-Active. Please contact your administrator for this inconvenience."));
    			      redirect('Adminlogin');
                    //  $this->output->set_header("Location: " . base_url() . 'Adminlogin', TRUE, 302);
                    exit;
        			 }
        			 
                //if($email == 'Superadmin' || $email == 'superadmin@kotalgas.com' || $email == 'attaullahkhan.comsats@gmail.com' || $email == 'alisoftware66@gmail.com' || $email == 'snd.btk@gmail.com' ||  $email == 'abasit.tlg@gmail.com' ||  $email == 'jawad1231@gmail.com' || $email == 'mehtabali84024@gmail.com' || $email == 'hmhusnain4@gmail.com' || $email == 'waheed.qasim347@gmail.com' || $email = 'afzaalsatti21@gmail.com'){
    			if($getqry->fld_send_otp == 0){ 
    			    $this->auth->login($email, $password);
    			    $user_role=$this->session->userdata('user_role');
    			    
    				$user_role_name=$this->session->userdata('user_role_name');
    				$user_id=$this->session->userdata('user_id');
    				$date=date('Y-m-d');
    				$date=date('Y-m-d H:i:s');
    				$client_ip=$this->Gen->get_client_ip();
    				$address=$this->Base_model->getLocation($client_ip);
    				$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    				$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'LOGIN' ,fld_detail='',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
    			    redirect('home');
                    exit;
    			}
    			
				
				$user_data = array(
					'fld_email'        => $getqry->fld_email,
					'fld_username'     => $getqry->fld_username,
					'password' 		   => $password,
                );
                $this->session->set_userdata($user_data);
				$this->load->library('phpmailer');
				
    		    $display_name = $getqry->fld_username;
				//$data['emailaddress'] = $this->session->userdata('fld_email');
				$username = $this->session->userdata('fld_username');
      			$email = $this->session->userdata('fld_email');
				$password = $this->session->userdata('password');
    //  		Generte OTP
	            $code = rand(1000,9999);
			    
			    $update = $this->db->query("UPDATE tbl_users SET fld_OTP = '".$code."' WHERE fld_email = '".$email."' OR fld_username = '".$username."'");
			    
			    if($update){
			    $email_temp = $this->db->query("SELECT * FROM tbl_email WHERE fld_id = '6'")->row();
			    $sms_temp = $this->db->query("SELECT * FROM tbl_sms_api WHERE fld_id = '5'")->row();
			    $settings=$this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row();
			    $message = $email_temp->fld_email_body;
			    $message = str_replace('{OTP}', $code, $message);
			    $message = str_replace('{username}', $username, $message);
			    $sms_message=$sms_temp->fld_message_body;
			    $sms_message = str_replace('{OTP}', $code, $sms_message);
			    
			    if(($getqry->emp_id != "" || $getqry->fld_mobile_number != "") && $getqry->fld_send_otp == 1){
			        if($getqry->emp_id != "" && $getqry->emp_id > 0){
		            $getdetail = $this->db->query("SELECT *,phone_no as fld_mobile_number FROM tbl_employees WHERE (id = '$getqry->emp_id' )")->row_array();
			        }else{
			         $getdetail = $this->db->query("SELECT * FROM tbl_users WHERE (fld_id = '$getqry->fld_id' )")->row_array(); 
			        }
		           
		            $this->sendSMS($getdetail,$sms_message);
		           
		        }
		      
			 //   $message   =   "Hi '". $display_name."' Below is your verification OTP."."\n";
              //  $message  .=   "Code: ".$code."\n\n\n\n";
			 //   $message  .=   "Thanks!";
                
    //          //send_sms($mobilenumber,$message);
    // 		 // $support_email = settings('support_email'); 
    			$support_email = $email;
    	
    			$this->phpmailer->IsMail(); 
    			$this->phpmailer->From   =   $settings->system_email;
     			$this->phpmailer->FromName  =  $settings->email_sender_name;
     			// $this->phpmailer->From   =   'noreply@mktechsol.com';
     			// $this->phpmailer->FromName  =  "H.Q. OFFICE";
    			$this->phpmailer->IsHTML(true);
     			//$this->phpmailer->AddAddress("mktechsol.ltd@gmail.com"); 
     			$this->phpmailer->AddAddress($email); 
     			$this->phpmailer->Subject  =   $email_temp->fld_subject;
     			$this->phpmailer->Body  =   nl2br($message);
     			$this->phpmailer->Send();
     			$this->phpmailer->ClearAddresses();
				
                //$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
				$this->output->set_header("Location: " . base_url() . 'Adminlogin/login_otp', TRUE, 302);
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
	public function resendOTP() {
		
			$email = $_GET['email'];

			if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$isemail = $email;
				//return true;
                //echo $isemail;exit;				
			}else {
				$isUsename = $email;
				//echo $isUsename;exit;
			}
			
			if(isset($isemail)){
				$getqry = $this->db->query("SELECT * FROM tbl_users WHERE fld_email = '".$isemail."'")->num_rows();
				if($getqry == 0){
				//if ($email == '' || $password == '' || $this->auth->login($email, $password) === FALSE) {
				//if ($email != $isemail || $password != md5("kotal" . $password)) {
					$error = "Email Not Exist.";
				}
			}

				$getqry = $this->db->query("SELECT * FROM tbl_users WHERE fld_email = '$email'")->row();
				$user_data = array(
					'fld_email'        => $getqry->fld_email,
					'fld_username'     => $getqry->fld_username,
                );
                $this->session->set_userdata($user_data);
				$this->load->library('phpmailer');
    		    $display_name = $getqry->fld_username;
				$username = $this->session->userdata('fld_username');
      			$email = $this->session->userdata('fld_email');
				//$password = $this->session->userdata('password');
				
				
    //  		Generte OTP
	            $code = rand(1000,9999);
			    
			    $update = $this->db->query("UPDATE tbl_users SET fld_OTP = '".$code."' WHERE fld_email = '".$email."' OR fld_username = '".$username."'");
			    
			    if($update){
			    $email_temp = $this->db->query("SELECT * FROM tbl_email WHERE fld_id = '6'")->row();
			    $sms_temp = $this->db->query("SELECT * FROM tbl_sms_api WHERE fld_id = '5'")->row();
 
			    $settings=$this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row();
			    $message = $email_temp->fld_email_body;
			    $message = str_replace('{OTP}', $code, $message);
			    $message = str_replace('{username}', $username, $message);
			    $sms_message=$sms_temp->fld_message_body;
			    $sms_message = str_replace('{OTP}', $code, $sms_message);
			 // $message   =   "Hi '". $display_name."' Below is your verification OTP."."\n";
             //	$message  .=   "Code: ".$code."\n\n\n\n";
			 // $message  .=   "Thanks!";
             // send_sms($mobilenumber,$message);
     		 // $support_email = settings('support_email'); 
     		 if(($getqry->emp_id != "" || $getqry->fld_mobile_number != "") && $getqry->fld_send_otp == 1){
			        if($getqry->emp_id != "" && $getqry->emp_id > 0){
		            $getdetail = $this->db->query("SELECT *,phone_no as fld_mobile_number FROM tbl_employees WHERE (id = '$getqry->emp_id' )")->row_array();
			        }else{
			         $getdetail = $this->db->query("SELECT * FROM tbl_users WHERE (fld_id = '$getqry->fld_id' )")->row_array(); 
			        }
		           
		            $this->sendSMS($getdetail,$sms_message);
		           
		        }
     		 
    			$support_email = $email;
    	
    			$this->phpmailer->IsMail();
                $this->phpmailer->From   =   $settings->system_email;
     			$this->phpmailer->FromName  =  $settings->email_sender_name;
    			$this->phpmailer->IsHTML(true);
     		  //$this->phpmailer->AddAddress("mktechsol.ltd@gmail.com"); 
     			$this->phpmailer->AddAddress($email);
     			$this->phpmailer->Subject  =   $email_temp->fld_subject;
     			$this->phpmailer->Body  =   nl2br($message);
     			$this->phpmailer->Send();
     			$this->phpmailer->ClearAddresses();
             // $this->output->set_header("Location: " . base_url('home'), TRUE, 302);
                $this->session->set_userdata(array('success_message' => "We've sent 4 digits verification code to the email '".$email."' Please enter code below"));
				$this->output->set_header("Location: " . base_url() . 'Adminlogin/login_otp', TRUE, 302);
		}
	}
	
	public function do_verifylogin(){
		$this->form_validation->set_rules('code[]', 'OTP Code', 'required');
		$error="";
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Adminlogin/login_otp', TRUE, 302);
		} else {
			$code = implode('',$this->input->post('code'));
			$getcode = $this->db->query("SELECT fld_OTP FROM tbl_users WHERE fld_email = '".$this->session->userdata('fld_email')."' OR fld_username = '".$this->session->userdata('fld_username')."'")->row();
// 			echo $this->session->userdata('fld_email').$this->session->userdata('fld_username');
// 			exit;
			$otp = $getcode->fld_OTP;
// 			echo $otp;exit;
			$email = $this->session->userdata('fld_email');
			$password = $this->session->userdata('password');
			//echo $email."<br>";
			//echo $password;exit;
			if($code == $otp && $this->auth->login($email, $password) === TRUE){
			    $user_role=$this->session->userdata('user_role');
    				$user_role_name=$this->session->userdata('user_role_name');
    				$user_id=$this->session->userdata('user_id');
    				$date=date('Y-m-d H:i:s');
    				$client_ip=$this->Gen->get_client_ip();
    				$address=$this->Base_model->getLocation($client_ip);
    				$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    				$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'LOGIN' ,fld_detail='',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
				$this->output->set_header("Location: " . base_url() . 'Adminlogin', TRUE, 302);
			}else{
				// $data['err'] = "Invalid OTP Code. Try Again";
				// $this->load_template('login','login',$data);
				// $this->session->sess_destroy();
				$this->session->set_userdata(array('error_message' => "Invalid OTP Code. Try Again"));
				$this->output->set_header("Location: " . base_url() . 'Adminlogin/login_otp', TRUE, 302);
			}
		}
	}
	
	#===============Logout=======#

    public function logout() {
        $user_role=$this->session->userdata('user_role');
    				$user_role_name=$this->session->userdata('user_role_name');
    				$user_id=$this->session->userdata('user_id');
    				$date=date('Y-m-d H:i:s');
    				$client_ip=$this->Gen->get_client_ip();
    				$address=$this->Base_model->getLocation($client_ip);
    				$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    				$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'LOGOUT' ,fld_detail='',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
        if ($this->auth->logout())
            $this->output->set_header("Location: " . base_url() . 'Adminlogin', TRUE, 302);
    }
}
