<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apis extends My_controller {
	private $token_time_allowed = 720;
	function __construct() {
        parent::__construct();
		$this->load->model('Apis_model');
		$this->load->model('Common_model');
		$this->load->model('Navigations_model');
    }
	
	public function do_login() {
	
		//$this->form_validation->set_rules('emailadd', 'Email', 'required');
		$this->form_validation->set_rules('username', 'Email / Username', 'required');
		$this->form_validation->set_message('password', 'Password', 'required');
        $error="";
		$responce=array();
		if ($this->form_validation->run() == FALSE) {
			$this->send_response(500,'error',500, strip_tags(validation_errors()));
		} else {
			$email = $this->input->post('username',TRUE);
			//$email = $this->input->post('emailadd',TRUE);
            $password = $this->input->post('password',TRUE);
            $device_id= $this->input->post('device_id',TRUE);
			if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$isemail = $email;
				//return true;
                //echo $isemail;exit;				
			}else {
				$isUsename = $email;
				//echo $isUsename;exit;
			}
			
			if(isset($isemail)){
				$getqry = $this->db->query("SELECT * FROM tbl_users WHERE fld_email = '".$isemail."' AND fld_password = '".md5("kotal" . $password)."'")->row();
			
				if(empty ($getqry) || $getqry->fld_email != $isemail || $getqry->fld_password != md5("kotal" . $password)){
				//if ($email == '' || $password == '' || $this->auth->login($email, $password) === FALSE) {
					$error = "Email or password incorrect.";
					
				}
			}else{
				$getqry = $this->db->query("SELECT * FROM tbl_users WHERE fld_username = '".$isUsename."'  AND fld_password = '".md5("kotal" . $password)."'")->row();
				if(empty ($getqry) || $getqry->fld_username != $isUsename || $getqry->fld_password != md5("kotal" . $password)){
				//if ($email == '' || $password == '' || $this->auth->login($email, $password) === FALSE) {
					$error = "Email or password incorrect.";
				}
			}
			
			
			
			
            if ($error != '') {
				
				$this->send_response(500,'error',320, 'Email or password incorrect.');
            } else {
               
                $getqry = $this->db->query("SELECT * FROM tbl_users WHERE (fld_username = '$email' || fld_email = '$email')  AND fld_password = '".md5("kotal" . $password)."'")->row();
                $roleid= $getqry->fld_role;
                $getrole= $this->db->query("SELECT * FROM tbl_roles WHERE role_id = '$roleid' ")->num_rows();
              
                if($getrole == 0){
                    $this->send_response(200,'error',332,'Your role has been removed by administrator. Please contact your administrator for this inconvenience.');
        		}else if($getqry->fld_status == 2){
        		    $this->send_response(200,'error',332,'This account is In-Active. Please contact your administrator for this inconvenience.');
        		}else{
        		    
                if($getqry->fld_send_otp == 0){ 
                    $access_token = md5(uniqid($device_id, true));
                    $this->Apis_model->insert("tbl_access_token", array(
                        "token_key" => $access_token,
                        "device_id" => $device_id,
                        "token_valid" => 1
                    ));
                    
    			    $responce=$this->auth_login($email, $password);
    			    
					$responce['access_token']=$access_token;
					$responce['send_otp']=0;
					$user_role=@$responce['user_role'];
    				$user_role_name=@$responce['role_name'];
    				$user_id=$responce['user_id'];
    				$date=date('Y-m-d');
    				$date=date('Y-m-d H:i:s');
    				$client_ip= $this->input->post('client_ip');
    				$address=$this->Base_model->getLocation($client_ip);
	                $device_name= $this->input->post('device_name');
	                $device = $device_name;
    				$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'LOGIN' ,fld_detail='',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
					$this->send_response(200,'success',332,'Login successfully.',$responce);
					
    			}else{
				
				$user_data = array(
					'fld_email'        => $getqry->fld_email,
					'fld_username'        => $getqry->fld_username,
					'password' 		   => $password,
					'send_otp'         =>1,
                );
               // $this->session->set_userdata($user_data);
				$this->load->library('phpmailer');
				//$getcode = $this->db->query("SELECT fld_username FROM tbl_users WHERE fld_email = '".$this->session->userdata('fld_email')."'")->row();
				
    		    $display_name = $getqry->fld_username;
				//$data['emailaddress'] = $this->session->userdata('fld_email');
				$username =$user_data['fld_username'];
      			$email = $user_data['fld_email'];
				$password = $user_data['password'];
				
    //  		Generte OTP
	            $code = rand(1000,9999);
			    
			    $update = $this->db->query("UPDATE tbl_users SET fld_OTP = '".$code."' WHERE fld_email = '".$email."' OR fld_username = '".$username."'");
			    
			    if($update){
			    $email_temp = $this->db->query("SELECT * FROM tbl_email WHERE fld_id = '6'")->row();
			    
			    $message = $email_temp->fld_email_body;
			    $message = str_replace('{OTP}', $code, $message);
			    
			    $message = str_replace('{user_name}', $username, $message);
                	
    			$support_email = $email;
    	
    			$this->phpmailer->IsMail();     
     			$this->phpmailer->From   =   'noreply@mktechsol.com';
     			$this->phpmailer->FromName  =  "H.Q. OFFICE";
    			$this->phpmailer->IsHTML(true);
     			$this->phpmailer->AddAddress($email); 
     			$this->phpmailer->Subject  =   $email_temp->fld_subject;
     			$this->phpmailer->Body  =   nl2br($message);
     			$this->phpmailer->Send();
     			$this->phpmailer->ClearAddresses();
				
                //$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
				//$this->output->set_header("Location: " . base_url() . 'Adminlogin/login_otp', TRUE, 302);
				$this->send_response(200,'success',332,'OTP send to your email address.',$user_data);
				}
			}
        	}
            }
		}		
	}
	public function do_verifylogin(){
		$this->form_validation->set_rules('code[]', 'OTP Code', 'required');
		$fld_email=$this->input->post('fld_email',TRUE);
		$fld_username=$this->input->post('fld_username',TRUE);
		$password=$this->input->post('password',TRUE);
		$device_id= $this->input->post('device_id',TRUE);
		$error="";
		
		if ($this->form_validation->run() == FALSE) {
			$this->send_response(500,'error',500, strip_tags(validation_errors()));
		} else {
			$code = implode('',$this->input->post('code'));
			
			$getcode = $this->db->query("SELECT fld_OTP FROM tbl_users WHERE fld_email = '".$fld_email."' OR fld_username = '".$fld_username."'")->row();
			$otp = $getcode->fld_OTP;
			$email = $fld_email;
			$password = $password;
			//echo $email."<br>";
			//echo $password;exit;
			if($code == $otp ){
				$responce=$this->auth_login($email, $password);
				
				if(is_array($responce) && !empty($responce)){
				    $client_ip= $this->input->post('client_ip');
				    $device_name= $this->input->post('device_name');
				    $user_role=$responce['user_role'];
    				$user_role_name=$responce['role_name'];
    				$user_id=$responce['user_id'];
    				$date=date('Y-m-d H:i:s');
    				$address=$this->Base_model->getLocation($client_ip);
    			//	echo '<pre>';
    			//	print_r($address);
    			//	print_r($address);
    			//	exit;
    			    $access_token = md5(uniqid($device_id, true));
                    $this->Apis_model->insert("tbl_access_token", array(
                        "token_key" => $access_token,
                        "device_id" => $device_id,
                        "token_valid" => 1
                    ));
                    $responce['access_token']=$access_token;
    				$device = $device_name;
    				$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'LOGIN' ,fld_detail='',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
				    
					$this->send_response(200,'success',332,'Login successfully.',$responce);
				}else{
					$this->send_response(500,'error',320, 'Invalid OTP Code. Try Again');
				}
			}else{
				$this->send_response(500,'error',320, 'Invalid OTP Code. Try Again');
			}
		}
	}
	
	public function auth_login($email,$password)
    {
        
        $this->load->model('Users');
        $this->load->model('Common_model');
        $result = $this->Users->check_valid_user($email,$password);
		
       

        if ($result)
        {
            $key = md5(time());
            $key = str_replace("1", "z", $key);
            $key = str_replace("2", "J", $key);
            $key = str_replace("3", "y", $key);
            $key = str_replace("4", "R", $key);
            $key = str_replace("5", "Kd", $key);
            $key = str_replace("6", "jX", $key);
            $key = str_replace("7", "dH", $key);
            $key = str_replace("8", "p", $key);
            $key = str_replace("9", "Uf", $key);
            $key = str_replace("0", "eXnyiKFj", $key);
            $sid_web = substr($key, rand(0, 3), rand(28, 32));
            
            
			$getpermissions = $this->Common_model->select_where_return_row('*','tbl_roles',array('role_id'=>$result[0]['fld_role']));
			$getempid = $this->Common_model->select_where_return_row('*','tbl_users',array('emp_id'=>$result[0]['emp_id']));
			$empactivestatus = $getempid->emp_id;
		
			
			$permissions = $getpermissions->perm_issions;
        			$mainmenu = $getpermissions->admin_menu;
        			$sublevel = $getpermissions->admin_menu_sublevel;
        			$sublevellinks = $getpermissions->admin_menu_group;
                    
                            
                    $user_data = array(
                        'sid_web'           => $sid_web,
                        'isLogIn'           => true,
                        'isAdmin'           => (($result[0]['fld_user_type'] == 1)?true:false),
                        'user_id'           => $result[0]['fld_id'],
                        'user_type'         => $result[0]['fld_user_type'],
                        'user_name'        => $result[0]['fld_username'],
                        'fld_email'         => $result[0]['fld_email'],
                        'user_otp'          => $result[0]['fld_OTP'],
                        'user_role'         => $result[0]['fld_role'],
                        'role_name'         => $getpermissions->role_name,
                        'emp_id'            => $result[0]['emp_id'],
                        'user_pic'            => $result[0]['fld_user_pic'],
        				'mainmenu'          => $mainmenu,
        				'sublevel'          => $sublevel,
        				'sublevellinks'     => $sublevellinks,
        				'permissions'       => $permissions,
                    
                    );
			
			if($empactivestatus == 0){
				
                return  $user_data;
			}elseif($empactivestatus > 0){
			    
			    
                
                $getemployeestatus =	$this->Common_model->select_single_field('is_active','tbl_employees',array('email'=>$email));
 
                if($getemployeestatus == 1){
                   
                    return  $user_data;
			    }else{
			        
			        return FALSE;   
			    }
		}
        }else{
            return FALSE;
        }
    }
    public function logout()
    {
        $client_ip= $this->input->post('client_ip');
	    $device_name= $this->input->post('device_name');
	    $user_role=$this->input->post('user_role');
		$user_role_name=$this->input->post('role_name');
		$user_id=$this->input->post('user_id');
		$date=date('Y-m-d H:i:s');
		$address=$this->Base_model->getLocation($client_ip);
		$device = $device_name;
		
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'LOGOUT' ,fld_detail='',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
        
        $this->send_response(200,'success',332,'Logout successfully.');
    }
    public function submit_forgot() {
		$this->form_validation->set_rules('email', 'Email Address', 'required');
		if ($this->form_validation->run() == FALSE) {
			$this->send_response(500,'error',500, strip_tags(validation_errors()));
		} else {
		    
			$email = $this->input->post('email',TRUE);
			$qry = $this->db->query("SELECT * FROM tbl_users WHERE fld_email = '".$email."'")->row();
			if(!empty($qry->fld_email)){
			$string_length 		= 	substr((md5(uniqid(rand(), 1))), 0,30);
			$activation_link  	=	'<a href="'.base_url().'Adminlogin/Change_pass/'.$qry->fld_id.'">'.base_url().'Adminlogin/Change_pass/'.$qry->fld_id.'</a>';
                
    			$message   =   "Hi Please Click on the below link to reset your password"."\n";
    			$message  .=   "Link: ".$activation_link."\n";
			    $message  .=   "Thanks!";

    		 // $support_email = settings('support_email'); 
    			$support_email = $email;
				$this->load->library('phpmailer');
    			$this->phpmailer->IsMail();     
    			$this->phpmailer->From   =   $support_email;
    			$this->phpmailer->FromName  =  "Kotal ERP System";
    			$this->phpmailer->IsHTML(true);
    			$this->phpmailer->AddAddress($support_email); 
    			$this->phpmailer->Subject  =   "Kotal ERP System";
    			$this->phpmailer->Body  =   nl2br($message);
    			$this->phpmailer->Send();
    			$this->phpmailer->ClearAddresses();
    			
				$this->send_response(200,'success',332,'Please check your email inbox or spam/junk folder to choose your new password.');
    			
			}else{
			    
				$this->send_response(500,'error',500, 'Invalid Email!, Please enter your correct email address.');
			}
		}
	}
	function resetPassword()
	{
	     $device_id=$this->input->post('device_id');
	    $access_token=$this->input->post('access_token');
	    $token = $this->authenticate_token($device_id, $access_token);

        if ($token == '0') {
            $this->send_response(500, 'error', 310, 'Authentication token expired.');
        } elseif ($token == '2') {
            $this->send_response(500, 'error', 320, 'Invalid token / device id.');
        } elseif ($token == 'no token') {
            $this->send_response(500, 'error', 500, 'Please include authentication token & device id with each request.');
        } elseif ($token == '1') {
		$this->form_validation->set_rules('old_password','Old Password','trim|required');
		$this->form_validation->set_rules('new_password','New Password','trim|required');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[new_password]');
		
		if($this->form_validation->run() === FALSE) {
			$this->send_response(500,'error',500, strip_tags(validation_errors()));
		} else {
			$old_password = $this->input->post('old_password');
			$user_id = $this->input->post('user_id');
			$query = $this->Common_model->select_where('*','tbl_users',array('fld_id'=>$user_id,'fld_password'=>md5("kotal" . $old_password)));
		
			if($query->num_rows() > 0) {
				$data['fld_password']		= 	md5("kotal" . $this->input->post('new_password'));
				
				
				$this->Common_model->update_array(array('fld_id'=>$user_id),'tbl_users',$data);
				$user_role=$_POST['user_role'];
				$user_role_name=$_POST['role_name'];
				$user_id=$_POST['user_id'];
				$date=date('Y-m-d');
				$date=date('Y-m-d H:i:s');
				$client_ip= $this->input->post('client_ip');
				$address=$this->Base_model->getLocation($client_ip);
                $device_name= $this->input->post('device_name');
                $device = $device_name;
				$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'Reset Password' ,fld_detail='',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
				
				$this->send_response(200,'success',332,'Password has updated successfully');
				
				
			} else{
				$this->send_response(500,'error',500,'Old password is incorrect.');
			}

		}
        }
	}
	public function purchReport(){
		 $device_id=$this->input->post('device_id');
	    $access_token=$this->input->post('access_token');
	    $token = $this->authenticate_token($device_id, $access_token);

        if ($token == '0') {
            $this->send_response(500, 'error', 310, 'Authentication token expired.');
        } elseif ($token == '2') {
            $this->send_response(500, 'error', 320, 'Invalid token / device id.');
        } elseif ($token == 'no token') {
            $this->send_response(500, 'error', 500, 'Please include authentication token & device id with each request.');
        } elseif ($token == '1') {
		$this->form_validation->set_rules('filter','Filter Type','trim|required');
		$this->form_validation->set_rules('from_date','From Date','trim|required');
		$this->form_validation->set_rules('to_date', 'To Date', 'trim|required');
		
		if($this->form_validation->run() === FALSE) {
			$this->send_response(500,'error',500, strip_tags(validation_errors()));
			
		}else{
			$purchase=$purchase=$this->Apis_model->purchase_filter(1);
			$purchase_total=$this->Apis_model->purchase_filter(0);
			$amtqty=0;
				$akgqty=0;
				$total_all_amount=0;
			if($purchase_total){
				 
				foreach($purchase_total as $purch){
					$mtqty=0;
					$kgqty=0;
					$total_amount=0;
					foreach($purch['detail'] as $purdet){
						$mtqty=$mtqty + $purdet['fld_quantity'];
						$total_amount=$total_amount + $purdet['fld_total_amount'];
						if($purdet['fld_product_id']==1){
						$kgqty=$kgqty + ($purdet['fld_quantity'] * 1000);
						}else{
						  // $kgqty=$kgqty + ($purdet['fld_quantity']); 
						   $kgqty += 0; 
						}
					}
					$total_all_amount += $total_amount;
					$akgqty += $kgqty;
					$amtqty += $mtqty;
				}
			}
			
			$data['purchase']=$purchase;
			$data['net_amount']=$total_all_amount;
			$data['net_weight']=$akgqty;
			$data['net_qty']=$amtqty;
			if(!empty($purchase)){
				$this->send_response(200,'success',332,'Purchase order',$data);
			}else{
				$this->send_response(500,'error',500, 'No data found.');
			}
		}
        }
		
	}
	public function purchaseItemReport(){
	    
	    $device_id=$this->input->post('device_id');
	    $access_token=$this->input->post('access_token');
	    $token = $this->authenticate_token($device_id, $access_token);

        if ($token == '0') {
            $this->send_response(500, 'error', 310, 'Authentication token expired.');
        } elseif ($token == '2') {
            $this->send_response(500, 'error', 320, 'Invalid token / device id.');
        } elseif ($token == 'no token') {
            $this->send_response(500, 'error', 500, 'Please include authentication token & device id with each request.');
        } elseif ($token == '1') {
    		$product_id=$this->input->post('item_id');
    		$condition="";
    		if($product_id == 1){
    			$condition="pd.fld_product_id IN (1)";
    		}else if($product_id == 2){
    			$condition="pd.fld_product_id IN (2)";
    		}else{
    			$condition="pd.fld_product_id NOT IN ('1','2')";
    		}
    		$purchase=$this->Apis_model->purchaseItemReport($condition);
    		if(!empty($purchase)){
    			$this->send_response(200,'success',332,'Item Purchase Report',$purchase);
    		}else{
    			$this->send_response(500,'error',500, 'No data found.');
    		}
        }
		
	}
	public function getUserDetail(){
	     $device_id=$this->input->post('device_id');
	    $access_token=$this->input->post('access_token');
	    $token = $this->authenticate_token($device_id, $access_token);

        if ($token == '0') {
            $this->send_response(500, 'error', 310, 'Authentication token expired.');
        } elseif ($token == '2') {
            $this->send_response(500, 'error', 320, 'Invalid token / device id.');
        } elseif ($token == 'no token') {
            $this->send_response(500, 'error', 500, 'Please include authentication token & device id with each request.');
        } elseif ($token == '1') {
		$user_id=$this->input->post('user_id');
		$user_detail =$this->Base_model->getAll('tbl_users', '', "fld_id='$user_id'", '');
		if(!empty($user_detail)){
			$this->send_response(200,'success',332,'User Detail',$user_detail);
		}else{
			$this->send_response(500,'error',500, 'No data found.');
		}
        }
		
	}
	public function saleItemReport(){
	     $device_id=$this->input->post('device_id');
	    $access_token=$this->input->post('access_token');
	    $token = $this->authenticate_token($device_id, $access_token);

        if ($token == '0') {
            $this->send_response(500, 'error', 310, 'Authentication token expired.');
        } elseif ($token == '2') {
            $this->send_response(500, 'error', 320, 'Invalid token / device id.');
        } elseif ($token == 'no token') {
            $this->send_response(500, 'error', 500, 'Please include authentication token & device id with each request.');
        } elseif ($token == '1') {
		$product_id=$this->input->post('item_id');
		$condition="";
		if($product_id == 1){
			$condition="sd.fld_product_id IN (1)";
		}else if($product_id == 2){
			$condition="sd.fld_product_id IN (2)";
		}else{
			$condition="sd.fld_product_id NOT IN ('1','2')";
		}
		$sales=$this->Apis_model->saleItemReport($condition);
		
		if(!empty($sales)){
			$this->send_response(200,'success',332,'Item Sale Report',$sales);
		}else{
			$this->send_response(500,'error',500, 'No data found.');
		}
        }
		
	}
	public function navigation_report(){
		 $device_id=$this->input->post('device_id');
	    $access_token=$this->input->post('access_token');
	    $token = $this->authenticate_token($device_id, $access_token);

        if ($token == '0') {
            $this->send_response(500, 'error', 310, 'Authentication token expired.');
        } elseif ($token == '2') {
            $this->send_response(500, 'error', 320, 'Invalid token / device id.');
        } elseif ($token == 'no token') {
            $this->send_response(500, 'error', 500, 'Please include authentication token & device id with each request.');
        } elseif ($token == '1') {
		$product_id=$this->input->post('item_id');
		$condition="";
		if($product_id == 1){
			$condition="nd.fld_product_id IN (1)";
		}else if($product_id == 2){
			$condition="nd.fld_product_id IN (2)";
		}else{
			$condition="nd.fld_product_id NOT IN ('1','2')";
		}
		$navigation=$this->Apis_model->navigation_report($condition);
		
		if(!empty($navigation)){
			$this->send_response(200,'success',332,'Navigation Report',$navigation);
		}else{
			$this->send_response(500,'error',500, 'No data found.');
		}
        }

	}
	public function navigation_filter(){
		 $device_id=$this->input->post('device_id');
	    $access_token=$this->input->post('access_token');
	    $token = $this->authenticate_token($device_id, $access_token);

        if ($token == '0') {
            $this->send_response(500, 'error', 310, 'Authentication token expired.');
        } elseif ($token == '2') {
            $this->send_response(500, 'error', 320, 'Invalid token / device id.');
        } elseif ($token == 'no token') {
            $this->send_response(500, 'error', 500, 'Please include authentication token & device id with each request.');
        } elseif ($token == '1') {
		$this->form_validation->set_rules('filter','Filter Type','trim|required');
		$this->form_validation->set_rules('from_date','From Date','trim|required');
		$this->form_validation->set_rules('to_date', 'To Date', 'trim|required');
		
		if($this->form_validation->run() === FALSE) {
			$this->send_response(500,'error',500, strip_tags(validation_errors()));
			
		}else{
			$navigation=$this->Apis_model->navigation_filter(1);
			$navigation_net_total=$this->Apis_model->navigation_filter(0);
			$amtqty=0;
			 $akgqty=0;
			 $total_all_amount = 0;
			 $total_allf_amount = 0;
			 $total_allt_amount = 0;
			if($navigation_net_total){
			 
			foreach($navigation_net_total as $nav){
				$mtqty=0;
				$kgqty=0;
				$total_amount=0;
				$total_amount_fright = 0;
				$total_amount_total=0;
				foreach($nav['detail'] as $navdet){
					$mtqty=$mtqty + $navdet['fld_qty'];
					$total_amount=$total_amount + $navdet['fld_amount'];
					$total_amount_fright += $navdet['fld_freight_amount'];
					$total_amount_total += $navdet['fld_total_amount'];
					$kgqty=$kgqty + ($navdet['fld_qty'] * 1000);
				}
			$total_all_amount += $total_amount;
			$total_allf_amount += $total_amount_fright;
			$total_allt_amount += $total_amount_total;
			$akgqty += $kgqty;
			$amtqty += $mtqty;
			}
			
			}
			$data['navigation']=$navigation;
			$data['total_weight']=$amtqty;
			$data['total_amount']=$total_all_amount;
			$data['total_freight']=$total_allf_amount;
			$data['total_all_amount']=$total_allt_amount;
			if(!empty($navigation)){
				$this->send_response(200,'success',332,'Navigation Report',$data);
			}else{
				$this->send_response(500,'error',500, 'No data found.');
			}
		}
        }

	}
	public function sale_filter(){
		
		 $device_id=$this->input->post('device_id');
	    $access_token=$this->input->post('access_token');
	    $token = $this->authenticate_token($device_id, $access_token);

        if ($token == '0') {
            $this->send_response(500, 'error', 310, 'Authentication token expired.');
        } elseif ($token == '2') {
            $this->send_response(500, 'error', 320, 'Invalid token / device id.');
        } elseif ($token == 'no token') {
            $this->send_response(500, 'error', 500, 'Please include authentication token & device id with each request.');
        } elseif ($token == '1') {
		$this->form_validation->set_rules('filter','Filter Type','trim|required');
		$this->form_validation->set_rules('from_date','From Date','trim|required');
		$this->form_validation->set_rules('to_date', 'To Date', 'trim|required');
		
		if($this->form_validation->run() === FALSE) {
			$this->send_response(500,'error',500, strip_tags(validation_errors()));
			
		}else{
		    $sales=$this->Apis_model->sale_filter();
		    $amtqty=0;
				 $akgqty=0;
				 $atdiscount=0;
				 $total_all_amount = 0;
			if($sales){
				 
				foreach($sales as $sale){
					$mtqty=0;
					$kgqty=0;
					$tdiscount=0;
					$total_amount=0;
					foreach($sale['detail'] as $saledet){
						$mtqty=$mtqty + $saledet['fld_quantity'];
						$tdiscount+=$saledet['fld_discount'];
						$total_amount=$total_amount + $saledet['fld_total_amount']-$saledet['fld_discount'];
						$kgqty=$kgqty +$saledet['fld_weight'];
					}
					$total_all_amount += $total_amount;
					$atdiscount += $tdiscount;
					$akgqty += $kgqty;
					$amtqty += $mtqty;
				}
			}
			$data['sales']=$sales;
			$data['total_qty']=$amtqty;
			$data['total_weight']=$akgqty;
			$data['total_amount']=$total_all_amount;
			$data['total_discount']=$atdiscount;
			if(!empty($sales)){
				$this->send_response(200,'success',332,'Sales Report',$data);
			}else{
				$this->send_response(500,'error',500, 'No data found.');
			}
		}
        }
	}
	public function supplier_ledger_filter() {
		 $device_id=$this->input->post('device_id');
	    $access_token=$this->input->post('access_token');
	    $token = $this->authenticate_token($device_id, $access_token);

        if ($token == '0') {
            $this->send_response(500, 'error', 310, 'Authentication token expired.');
        } elseif ($token == '2') {
            $this->send_response(500, 'error', 320, 'Invalid token / device id.');
        } elseif ($token == 'no token') {
            $this->send_response(500, 'error', 500, 'Please include authentication token & device id with each request.');
        } elseif ($token == '1') {
		$this->form_validation->set_rules('from_date','From Date','trim|required');
		$this->form_validation->set_rules('to_date', 'To Date', 'trim|required');
		
		if($this->form_validation->run() === FALSE) {
			$this->send_response(500,'error',500, strip_tags(validation_errors()));
			
		}else{
			$conditions="";
			$account_id=$this->input->post('account_id');
			$offset=$this->input->post('offset');
		    $limit=$this->input->post('limit');
			$group_by='td.coa_id';
			$select="coa.head_name as filter_text,td.coa_id as filter_value";
			
			$start=str_replace('/', '-', $this->input->post('from_date'));
			$end=str_replace('/', '-', $this->input->post('to_date'));
			$date="tm.date between '".date("Y-m-d",strtotime($start))."' AND '".date("Y-m-d",strtotime($end))."'";
			$this->db->select('tm.id,'.$select);
			
			$this->db->from('tbl_transections_details as td');
			
			$this->db->join('tbl_transections_master as tm','tm.id=td.v_id');
			
			$this->db->join('tbl_coa as coa','coa.head_code=td.coa_id');
			
			$this->db->where($date);
			$from = date("Y-m-d",strtotime($start));
			if($account_id!='all'){
				$this->db->where("td.coa_id",$account_id);
				$op = $this->db->query("SELECT IFNULL(SUM(b.debit), 0)-IFNULL(SUM(b.credit), 0) as balance from tbl_transections_details as b, tbl_transections_master as a where b.coa_id = '$account_id' AND a.date < '$from' AND a.id = b.v_id")->row()->balance;
			}else{
				$this->db->like('td.coa_id', '101005', 'both');
				$op = $this->db->query("SELECT IFNULL(SUM(b.debit), 0)-IFNULL(SUM(b.credit), 0) as balance from tbl_transections_details as b, tbl_transections_master as a where b.coa_id LIKE '%101005%' AND a.date < '$from' AND a.id = b.v_id")->row()->balance;
			}
			
			$this->db->group_by($group_by);
			
			$this->db->limit($limit, $offset);
			
			$ledger=$this->db->get()->result_array();
			
		
			if($ledger){
				foreach($ledger as $key => $ledg){
					$ledgdet=$this->getLedgDetail($ledg['filter_value'],$group_by);
					$ledger[$key]['detail']=$ledgdet;
					$ledger[$key]['opening']=$op;
				}
			}
			
			if($ledger){
				foreach($ledger as $keys => $ledge){
					$total_credit=0;
					$total_debit=0;
					$balance=$ledge['opening'];
					foreach($ledge['detail'] as $key => $ledgedet){
						
						$total_credit +=$ledgedet['credit'];
						$total_debit +=$ledgedet['debit'];
						$balance += $ledgedet['debit']-$ledgedet['credit'];
						
					}
					
					$ledger[$keys]['total_credit'] =$total_credit;
					$ledger[$keys]['total_debit'] =$total_debit;
					$ledger[$keys]['balance'] = $balance;
					
				}
			}
			if(!empty($ledger)){
				$this->send_response(200,'success',332,'Ledger Report',$ledger);
			}else{
				$this->send_response(500,'error',500, 'No data found.');
			}
        }
        }
    }
	function getLedgDetail($id,$group_by){
        
        $device_id=$this->input->post('device_id');
	    $access_token=$this->input->post('access_token');
	    $token = $this->authenticate_token($device_id, $access_token);

        if ($token == '0') {
            $this->send_response(500, 'error', 310, 'Authentication token expired.');
        } elseif ($token == '2') {
            $this->send_response(500, 'error', 320, 'Invalid token / device id.');
        } elseif ($token == 'no token') {
            $this->send_response(500, 'error', 500, 'Please include authentication token & device id with each request.');
        } elseif ($token == '1') {
        $start=str_replace('/', '-', $this->input->post('from_date'));
		$end=str_replace('/', '-', $this->input->post('to_date'));
		
		$date="&& tm.date between '".date("Y-m-d",strtotime($start))."' AND '".date("Y-m-d",strtotime($end))."'";
	    return $this->db->query("SELECT td.*, tm.type, tm.type_id, tm.date FROM tbl_transections_details AS td JOIN tbl_transections_master AS tm ON tm.id=td.v_id AND $group_by = '$id' AND tm.post_status = 0 $date ORDER BY tm.date, td.id")->result_array();
    
        }
    }
	public function get_supplier_list()
	{
	     $device_id=$this->input->post('device_id');
	    $access_token=$this->input->post('access_token');
	    $token = $this->authenticate_token($device_id, $access_token);

        if ($token == '0') {
            $this->send_response(500, 'error', 310, 'Authentication token expired.');
        } elseif ($token == '2') {
            $this->send_response(500, 'error', 320, 'Invalid token / device id.');
        } elseif ($token == 'no token') {
            $this->send_response(500, 'error', 500, 'Please include authentication token & device id with each request.');
        } elseif ($token == '1') {
		$supplier_list = $this->db->query("SELECT * FROM `tbl_coa` WHERE head_code LIKE '%101005%' and head_code != '101005' order by head_name")->result_array();
		if(!empty($supplier_list)){
				$this->send_response(200,'success',332,'Supplier List',$supplier_list);
			}else{
				$this->send_response(500,'error',500, 'No data found.');
			}
        }
	}
	public function get_customer_list()
	{
	     $device_id=$this->input->post('device_id');
	    $access_token=$this->input->post('access_token');
	    $token = $this->authenticate_token($device_id, $access_token);

        if ($token == '0') {
            $this->send_response(500, 'error', 310, 'Authentication token expired.');
        } elseif ($token == '2') {
            $this->send_response(500, 'error', 320, 'Invalid token / device id.');
        } elseif ($token == 'no token') {
            $this->send_response(500, 'error', 500, 'Please include authentication token & device id with each request.');
        } elseif ($token == '1') {
		$customer_list = $this->db->query("SELECT * FROM `tbl_coa` WHERE head_code LIKE '%101007%' and head_code != '101007' order by head_name")->result_array();
		if(!empty($customer_list)){
			$this->send_response(200,'success',332,'Customer List',$customer_list);
		}else{
			$this->send_response(500,'error',500, 'No data found.');
		}
        }
	}
	public function customer_ledger_filter() {
		
		 $device_id=$this->input->post('device_id');
	    $access_token=$this->input->post('access_token');
	    $token = $this->authenticate_token($device_id, $access_token);

        if ($token == '0') {
            $this->send_response(500, 'error', 310, 'Authentication token expired.');
        } elseif ($token == '2') {
            $this->send_response(500, 'error', 320, 'Invalid token / device id.');
        } elseif ($token == 'no token') {
            $this->send_response(500, 'error', 500, 'Please include authentication token & device id with each request.');
        } elseif ($token == '1') {
		$this->form_validation->set_rules('from_date','From Date','trim|required');
		$this->form_validation->set_rules('to_date', 'To Date', 'trim|required');
		
		if($this->form_validation->run() === FALSE) {
			$this->send_response(500,'error',500, strip_tags(validation_errors()));
			
		}else{
		$conditions="";
		$account_id=$this->input->post('account_id');
		$offset=$this->input->post('offset');
		$limit=$this->input->post('limit');
		$group_by='td.coa_id';
		$select="coa.head_name as filter_text,td.coa_id as filter_value";
		
		$start=str_replace('/', '-', $this->input->post('from_date'));
		$end=str_replace('/', '-', $this->input->post('to_date'));
		$date="tm.date between '".date("Y-m-d",strtotime($start))."' AND '".date("Y-m-d",strtotime($end))."'";
		$this->db->select('tm.id,'.$select);
		
		$this->db->from('tbl_transections_details as td');
		
		$this->db->join('tbl_transections_master as tm','tm.id=td.v_id');
		
		$this->db->join('tbl_coa as coa','coa.head_code=td.coa_id');
		
		$this->db->where($date);
		$from = date("Y-m-d",strtotime($start));
		if($account_id!='all'){
		    $this->db->where("td.coa_id",$account_id);
		    $op = $this->db->query("SELECT IFNULL(SUM(b.debit), 0)-IFNULL(SUM(b.credit), 0) as balance from tbl_transections_details as b, tbl_transections_master as a where b.coa_id = '$account_id' AND a.date < '$from' AND a.id = b.v_id")->row()->balance;
		}else{
		    $this->db->like('td.coa_id', '101007', 'both');
		    $op = $this->db->query("SELECT IFNULL(SUM(b.debit), 0)-IFNULL(SUM(b.credit), 0) as balance from tbl_transections_details as b, tbl_transections_master as a where b.coa_id LIKE '%101007%' AND a.date < '$from' AND a.id = b.v_id")->row()->balance;
		}
		
		$this->db->group_by($group_by);
		
		$this->db->limit($limit, $offset);
		
	    $ledger=$this->db->get()->result_array();
		
	    
	    if($ledger){
			foreach($ledger as $key => $ledg){
				$ledgdet=$this->getLedgDetail($ledg['filter_value'],$group_by);
				$ledger[$key]['detail']=$ledgdet;
				$ledger[$key]['opening']=$op;
				
				$total_credit=0;
				$total_debit=0;
				$balance=$op;
				foreach($ledgdet as $ledgedet){
				    $total_credit +=$ledgedet['credit'];
				    $total_debit +=$ledgedet['debit'];
				    $balance += $ledgedet['debit']-$ledgedet['credit'];
				}
				$ledger[$key]['total_credit']=$total_credit;
				$ledger[$key]['total_debit']=$total_debit;
				$ledger[$key]['balance']=$balance;
			}
		}
		
		// $data['ledger'] = $ledger;
		// $data['from'] = $from;
		// $count=count($ledger);
		
		if(!empty($ledger)){
				$this->send_response(200,'success',332,'Customer Ledger Report',$ledger);
			}else{
				$this->send_response(500,'error',500, 'No data found.');
			}
		}
        }
    }
    public function accounts_ledger_filter() {
		
		 $device_id=$this->input->post('device_id');
	    $access_token=$this->input->post('access_token');
	    $token = $this->authenticate_token($device_id, $access_token);

        if ($token == '0') {
            $this->send_response(500, 'error', 310, 'Authentication token expired.');
        } elseif ($token == '2') {
            $this->send_response(500, 'error', 320, 'Invalid token / device id.');
        } elseif ($token == 'no token') {
            $this->send_response(500, 'error', 500, 'Please include authentication token & device id with each request.');
        } elseif ($token == '1') {
		$this->form_validation->set_rules('account_id','Account','trim|required');
		if($this->form_validation->run() === FALSE) {
			$this->send_response(500,'error',500, strip_tags(validation_errors()));
			
		}else{
			$conditions="";
			$account_id=$this->input->post('account_id');
			$offset=$this->input->post('offset');
		    $limit=$this->input->post('limit');
			$group_by='td.coa_id';
			$select="coa.head_name as filter_text,td.coa_id as filter_value";
			
			$start=str_replace('/', '-', $this->input->post('from_date'));
			$end=str_replace('/', '-', $this->input->post('to_date'));
			$date="tm.date between '".date("Y-m-d",strtotime($start))."' AND '".date("Y-m-d",strtotime($end))."'";
			$this->db->select('tm.id,'.$select);
			
			$this->db->from('tbl_transections_details as td');
			
			$this->db->join('tbl_transections_master as tm','tm.id=td.v_id');
			
			$this->db->join('tbl_coa as coa','coa.head_code=td.coa_id');
			
			$this->db->where($date);
			$this->db->where("td.coa_id",$account_id);
			$this->db->where("tm.post_status",0);

			$this->db->group_by($group_by);
			
			$this->db->limit($limit, $offset);
			
			$ledger=$this->db->get()->result_array();
		
			$from = date("Y-m-d",strtotime($start));
			$op = $this->db->query("SELECT IFNULL(SUM(b.debit), 0)-IFNULL(SUM(b.credit), 0) as balance from tbl_transections_details as b, tbl_transections_master as a where b.coa_id = '$account_id' AND a.date < '$from' AND a.id = b.v_id")->row()->balance;
			
			if($ledger){
				foreach($ledger as $key => $ledg){
					$ledgdet=$this->getLedgDetail($ledg['filter_value'],$group_by);
					$ledger[$key]['detail']=$ledgdet;
					$ledger[$key]['opening']=$op;
				}
			}
		    if($ledger){
				foreach($ledger as $keys => $ledge){
					$total_credit=0;
					$total_debit=0;
					$balance=$ledge['opening'];
					foreach($ledge['detail'] as $key => $ledgedet){
						
						$total_credit +=$ledgedet['credit'];
						$total_debit +=$ledgedet['debit'];
						$balance += $ledgedet['debit']-$ledgedet['credit'];
						
					}
					$ledger[$keys]['total_credit'] =$total_credit;
					$ledger[$keys]['total_debit'] =$total_debit;
					$ledger[$keys]['balance'] = $balance;
					
				}
			}
			if(!empty($ledger)){
				$this->send_response(200,'success',332,'Account Ledger Report',$ledger);
			}else{
				$this->send_response(500,'error',500, 'No data found.');
			}
		}
        }
	}
	public function items_ledger_filter() {
		 $device_id=$this->input->post('device_id');
	    $access_token=$this->input->post('access_token');
	    $token = $this->authenticate_token($device_id, $access_token);

        if ($token == '0') {
            $this->send_response(500, 'error', 310, 'Authentication token expired.');
        } elseif ($token == '2') {
            $this->send_response(500, 'error', 320, 'Invalid token / device id.');
        } elseif ($token == 'no token') {
            $this->send_response(500, 'error', 500, 'Please include authentication token & device id with each request.');
        } elseif ($token == '1') {
		$this->form_validation->set_rules('item_type','Item Type','trim|required');
		$this->form_validation->set_rules('shipment_id','Shipment','trim|required');
		if($this->form_validation->run() === FALSE) {
			$this->send_response(500,'error',500, strip_tags(validation_errors()));
			
		}else{
		$conditions="";
		$item_type=$this->input->post('item_type');
		$sitem_type=$this->input->post('sitem_type');
		$shipment_id=$this->input->post('shipment_id');
		$offset=$this->input->post('offset');
		$limit=$this->input->post('limit');
		
		if($item_type==1){
		    $group_by='pd.fld_product_id';
		    $select="cat.fld_category as filter_text,pd.fld_product_id as filter_value";
		}else{
		    $group_by='pd.fld_subproduct_id';
		    $select="subcat.fld_subcategory as filter_text,pd.fld_subproduct_id as filter_value";
		}
		
		
		$this->db->select($select);
		
		$this->db->from('tbl_purchase_detail as pd');
		
		$this->db->join('tbl_purchase','tbl_purchase.fld_id=pd.fld_purchase_id');
		
		if($item_type==1){
		    $this->db->join('tbl_category as cat','cat.fld_id=pd.fld_product_id');
		}else{
		    $this->db->join('tbl_subcategory as subcat','subcat.fld_subcid=pd.fld_subproduct_id');
		}
		
		
		if($item_type==1){
		    $this->db->where("pd.fld_product_id",$item_type);
		}else{
		    if($sitem_type=='all'){
		        $this->db->where("pd.fld_product_id",$item_type);
		    }else{
		         $this->db->where("pd.fld_subproduct_id",$sitem_type);
		    }
		   
		}
		$this->db->where("tbl_purchase.fld_shipment",$shipment_id);
	
		
		
		
		$this->db->group_by($group_by);
		
		$this->db->limit($limit, $offset);
		
	    $ledger=$this->db->get()->result_array();
	    
	    
		
	
		if($ledger){
			foreach($ledger as $key => $ledg){
			    $ledgerDetailArray = array();
				$purchase = $this->getPurchseLedgDetail($ledg['filter_value'], $group_by, $shipment_id);
				$navigation = $this->getNavLedgDetail($ledg['filter_value'], $group_by, $shipment_id);
				$sale = $this->getSaleLedgDetail($ledg['filter_value'], $group_by, $shipment_id);
				foreach($purchase as $purchsedet){
				    $ledgerDetail = array();
				    $ledgerDetail['vr_no'] = $purchsedet['fld_voucher_no'];
				    $ledgerDetail['date'] =  $purchsedet['fld_purchase_date'];
				    $ledgerDetail['account'] =  explode('/', $purchsedet['fld_shipment'])[0].'/'. explode('/', $purchsedet['fld_shipment'])[1];
				    $ledgerDetail['remarks'] =  '-';
				    $ledgerDetail['fld_shipment'] =  $purchsedet['fld_shipment'];
				    $ledgerDetail['location'] =  $purchsedet['fld_location'];
				    $ledgerDetail['qty_in'] =  0;
				    
				    if($purchsedet['fld_product_id']==1){
				        $ledgerDetail['weight_in'] =  $purchsedet['fld_quantity']*1000;
				    }else{
				        $ledgerDetail['weight_in'] =  0;
				    }
				    
				    $ledgerDetail['qty_out'] =  0;
				    $ledgerDetail['weight_out'] =  0;
				    
				    
				    $ledgerDetail['created'] = $purchsedet['fld_created_date'];
				    $ledgerDetailArray[]=$ledgerDetail;
				    
				    
				}
				
			    foreach($navigation as $navdet){
				    $ledgerDetail = array();
				    $ledgerDetail['vr_no'] = sprintf(' NV-%04d ', $navdet['fld_id']);
				    $ledgerDetail['date'] =  $navdet['fld_date'];
				    $ledgerDetail['account'] =  '-';
				    $ledgerDetail['remarks'] =  $navdet['fld_remarks'];
				    $ledgerDetail['location'] =  $this->db->query("select * from tbl_locations where fld_id = '{$navdet['fld_location_from']}'")->row()->fld_location;
				    $ledgerDetail['qty_in'] =  0;
				    $ledgerDetail['qty_out'] =  0;
				    
				    if($navdet['fld_product_id']==1){
				        $ledgerDetail['weight_out'] =  $navdet['fld_qty']*1000;
				    }else{
				        $ledgerDetail['weight_out'] =  0;
				    }
				    
				    
				    $ledgerDetail['weight_in'] =  0;
				    
				    
				    $ledgerDetail['created'] = $navdet['fld_created_date'];
				    $ledgerDetailArray[]=$ledgerDetail;
				    
				    
				}
				
				foreach($navigation as $navdet){
				    $ledgerDetail = array();
				    $ledgerDetail['vr_no'] = sprintf(' NV-%04d ', $navdet['fld_id']);
				    $ledgerDetail['date'] =  $navdet['fld_date'];
				    $ledgerDetail['account'] =  '-';
				    $ledgerDetail['remarks'] =  $navdet['fld_remarks'];
				    $ledgerDetail['location'] =  $this->db->query("select * from tbl_locations where fld_id = '{$navdet['fld_location_to']}'")->row()->fld_location;
				    $ledgerDetail['qty_out'] =  0;
				    $ledgerDetail['qty_in'] =  0;
				    
				    if($navdet['fld_product_id']==1){
				        $ledgerDetail['weight_in'] =  $navdet['fld_qty']*1000;
				    }else{
				        $ledgerDetail['weight_in'] =  0;
				    }
				    
				    
				    $ledgerDetail['weight_out'] =  0;
				    
				    
				    $ledgerDetail['created'] = $navdet['fld_created_date'];
				    $ledgerDetailArray[]=$ledgerDetail;
				    
				    
				}
				
				foreach($sale as $saledet){
				    $ledgerDetail = array();
				    $ledgerDetail['vr_no'] = $saledet['fld_voucher_no'];
				    $ledgerDetail['date'] =  $saledet['fld_sale_date'];
				    $ledgerDetail['account'] =  $saledet['fld_company_name'];
				    $ledgerDetail['remarks'] =  $this->db->select('*')->from('tbl_subcategory')->where('fld_subcid', $saledet['fld_subproduct_id'])->get()->row()->fld_subcategory;
				    $ledgerDetail['location'] =  $saledet['fld_location'];
				    $ledgerDetail['qty_in'] =  0;
				    
				    if($saledet['fld_product_id']==1){
				        $ledgerDetail['weight_out'] =  $saledet['fld_weight'];
				        $ledgerDetail['qty_out'] =  $saledet['fld_quantity'];
				    }else{
				        $ledgerDetail['weight_out'] =  0;
				        $ledgerDetail['qty_out'] =  $saledet['fld_quantity'];
				    }
				    
				    
				    $ledgerDetail['weight_in'] =  0;
				    
				    
				    $ledgerDetail['created'] = $saledet['fld_created_date'];
				    $ledgerDetailArray[]=$ledgerDetail;
				    
				    
				}
				array_multisort(array_map('strtotime',array_column($ledgerDetailArray,'created')),
                SORT_ASC,
                array_column($ledgerDetailArray,'weight_in'), SORT_ASC,
                $ledgerDetailArray);
                
                
				$ledger[$key]['detail']=$ledgerDetailArray;
			}
		}
		
		$total_qty_in=0;
		$total_qty_out=0;
		$total_weight_in=0;
		$total_weight_out=0;
		$balance1=0;
		$balance2=0;
		if($ledger){
			foreach($ledger as $keyj => $led){
				foreach($led['detail'] as $key => $ledgedet){
					$total_qty_in +=$ledgedet['qty_in'];
				    $total_qty_out +=$ledgedet['qty_out'];
				    $total_weight_in +=$ledgedet['weight_in'];
				    $total_weight_out +=$ledgedet['weight_out'];
				    $balance1 = $balance1+$ledgedet['qty_in']-$ledgedet['qty_out'];
				    $balance2 = $balance2+$ledgedet['weight_in']-$ledgedet['weight_out'];
					$ledger[$keyj]['detail'][$key]['qtyBalance']=$balance1;
					$ledger[$keyj]['detail'][$key]['weightBalance']=$balance2;
				
				}
				$ledger[$keyj]['total_quantity_in']=$total_qty_in;
				$ledger[$keyj]['total_quantity_out']=$total_qty_out;
				$ledger[$keyj]['balancetotal1']=$balance1;
				$ledger[$keyj]['total_weight_in']=$total_weight_in;
				$ledger[$keyj]['total_weight_out']=$total_weight_out;
				$ledger[$keyj]['balancetotal2']=$balance2;
			}
		}
		if(!empty($ledger)){
				$this->send_response(200,'success',332,'Item Ledger Report',$ledger);
			}else{
				$this->send_response(500,'error',500, 'No data found.');
			}
	}
        }
    }
	function getPurchseLedgDetail($id, $group_by, $shipment_id){
	    
	    $this->db->select('tbl_purchase.*,tbl_suppliers.fld_supplier_code,tbl_suppliers.fld_company_name,tbl_suppliers.fld_supplier_name,tbl_locations.fld_location,pd.fld_product_id,pd.fld_subproduct_id,pd.fld_quantity');
        $this->db->from('tbl_purchase');
        $this->db->join('tbl_purchase_detail as pd','pd.fld_purchase_id=tbl_purchase.fld_id');
        $this->db->join('tbl_suppliers','tbl_suppliers.fld_id=tbl_purchase.fld_supplier_id');
        $this->db->join('tbl_locations','tbl_locations.fld_id=tbl_purchase.fld_location_id');
        $this->db->where('tbl_purchase.fld_isdeleted',0);
        $this->db->where($group_by,$id);
		$this->db->where("tbl_purchase.fld_shipment",$shipment_id);
        return $this->db->get()->result_array();
    }
	function getNavLedgDetail($id, $group_by, $shipment_id){
	    $this->db->select('nd.*, tbl_navigations.fld_remarks, tbl_navigations.fld_date, tbl_navigations.fld_location_from, tbl_navigations.fld_location_to, tbl_navigations.fld_created_date, tbl_navigations.fld_id');
        $this->db->from('tbl_navigations_details as nd');
        $this->db->join('tbl_navigations','tbl_navigations.fld_id=nd.fld_navigation_id');
        $this->db->where('tbl_navigations.fld_isdeleted',0);
        if($group_by == 'pd.fld_product_id'){
            $group_by = 'nd.fld_product_id';
        }else if($group_by == 'pd.fld_subproduct_id'){
            $group_by = 'nd.fld_subproduct_id';
        }
        $this->db->where($group_by,$id);
		$this->db->where("nd.fld_shipment_from",$shipment_id);
        return $this->db->get()->result_array();
    }
	function getSaleLedgDetail($id, $group_by, $shipment_id){
	    $this->db->select('sd.*, tbl_sale.fld_voucher_no, tbl_sale.fld_sale_date, tbl_sale.fld_location_id, tbl_sale.fld_customer_id, tbl_sale.fld_created_date,tbl_customers.fld_company_name,tbl_locations.fld_location');
        $this->db->from('tbl_sale_detail as sd');
        $this->db->join('tbl_sale','tbl_sale.fld_id=sd.fld_sale_id');
        $this->db->join('tbl_customers','tbl_customers.fld_id=tbl_sale.fld_customer_id');
        $this->db->join('tbl_locations','tbl_locations.fld_id=tbl_sale.fld_location_id');
        $this->db->where('tbl_sale.fld_isdeleted',0);
        if($group_by == 'pd.fld_product_id'){
            $group_by = 'sd.fld_product_id';
        }else if($group_by == 'pd.fld_subproduct_id'){
            $group_by = 'sd.fld_subproduct_id';
        }
        $this->db->where($group_by,$id);
		$this->db->where("sd.fld_shipment",$shipment_id);
        return $this->db->get()->result_array();
    }
    
    public function getIncomeReport() {
			
		 $device_id=$this->input->post('device_id');
	    $access_token=$this->input->post('access_token');
	    $token = $this->authenticate_token($device_id, $access_token);

        if ($token == '0') {
            $this->send_response(500, 'error', 310, 'Authentication token expired.');
        } elseif ($token == '2') {
            $this->send_response(500, 'error', 320, 'Invalid token / device id.');
        } elseif ($token == 'no token') {
            $this->send_response(500, 'error', 500, 'Please include authentication token & device id with each request.');
        } elseif ($token == '1') {	
		$this->form_validation->set_rules('from_date','From Date','trim|required');
		$this->form_validation->set_rules('to_date','To Date','trim|required');
		if($this->form_validation->run() === FALSE) {
			$this->send_response(500,'error',500, strip_tags(validation_errors()));
			
		}else{
			$start=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('from_date'))));
			$end=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('to_date'))));
			$data['start_date'] = $start;
			$data['end_date'] = $end;
			
			$data['saleofproducts'] =$saleofproducts= $this->db->query("SELECT IFNULL(SUM(fld_total_discount), 0) discount, IFNULL(SUM(fld_grand_total_amount), 0) amount FROM `tbl_sale` WHERE DATE(fld_sale_date) >= '$start' && DATE(fld_sale_date) <= '$end'")->row();
			
			$cgsOpeningStock =$cgsOpeningStock= $this->db->query("SELECT IFNULL(SUM(a.debit), 0)-IFNULL(SUM(a.credit), 0) as balance FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id && b.date < '$start' && a.coa_id = '101003001'")->row()->balance;
			
			$cgsPurchase =$cgsPurchase= $this->db->query("SELECT IFNULL(SUM(a.debit), 0) as debit FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id && b.date >= '$start' && b.date <= '$end' && a.coa_id = '101003001'")->row()->debit;
			
			$cgsClosingStock =$cgsClosingStock= $this->db->query("SELECT IFNULL(SUM(a.debit), 0)-IFNULL(SUM(a.credit), 0) as balance FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id && a.coa_id = '101003001' and b.date <= '$end'")->row()->balance;
			
			
			$data['costOfGoodsSold'] =$costOfGoodsSold= $cgsOpeningStock+$cgsPurchase-$cgsClosingStock;
			
			$data['OfficeExpenses'] =$OfficeExpenses= $this->db->query("SELECT IFNULL(SUM(a.unit_price), 0) amount FROM tbl_expense_detail a, tbl_expenses b WHERE b.id = a.fld_expense_id && DATE(b.date_added) >= '$start' && DATE(b.date_added) <= '$end' && a.expense_type = '1'")->row()->amount;
			$data['MessExpenses'] =$MessExpenses= $this->db->query("SELECT IFNULL(SUM(a.unit_price), 0) amount FROM tbl_expense_detail a, tbl_expenses b WHERE b.id = a.fld_expense_id && DATE(b.date_added) >= '$start' && DATE(b.date_added) <= '$end' && a.expense_type = '2'")->row()->amount;
			$data['StaffSalaries'] =$StaffSalaries= $this->db->query("SELECT IFNULL(SUM(a.debit), 0) as debit FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id && b.date >= '$start' && b.date <= '$end' && a.coa_id LIKE '%101006%'")->row()->debit;
			$data['Dividend'] =$Dividend= $this->db->query("SELECT IFNULL(SUM(a.credit), 0) as credit FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id && b.date >= '$start' && b.date <= '$end' && a.coa_id LIKE '201008001%'")->row()->credit;
			$data['OtherIncome']=$OtherIncome = $this->db->query("SELECT IFNULL(SUM(a.credit), 0)-IFNULL(SUM(a.debit), 0) as balance FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id && b.date >= '$start' && b.date <= '$end' && (a.coa_id = '204001001' || a.coa_id = '401002001')")->row()->balance;
			$data['total_sale']=$saleofproducts->amount+$saleofproducts->discount;
			$data['discount']=$saleofproducts->discount;
			$data['net_sale']=$saleofproducts->amount;
			$data['revenue']=$revenue=$saleofproducts->amount + $OtherIncome - $costOfGoodsSold;
			$data['totalExpenses']=$totalExpenses=$OfficeExpenses+$MessExpenses+$StaffSalaries;
			$data['net_income']=$revenue-$totalExpenses;
			$data['dividend_profit_loss_acc']=$revenue - $totalExpenses - $Dividend;

			if(!empty($data)){
				$this->send_response(200,'success',332,'Income Report',$data);
			}else{
				$this->send_response(500,'error',500, 'No data found.');
			}
			
		}
        }
        
    }
	 public function getTrailBalance() {
		 $device_id=$this->input->post('device_id');
	    $access_token=$this->input->post('access_token');
	    $token = $this->authenticate_token($device_id, $access_token);

        if ($token == '0') {
            $this->send_response(500, 'error', 310, 'Authentication token expired.');
        } elseif ($token == '2') {
            $this->send_response(500, 'error', 320, 'Invalid token / device id.');
        } elseif ($token == 'no token') {
            $this->send_response(500, 'error', 500, 'Please include authentication token & device id with each request.');
        } elseif ($token == '1') {
		$this->form_validation->set_rules('from_date','From Date','trim|required');
		$this->form_validation->set_rules('to_date','To Date','trim|required');
		if($this->form_validation->run() === FALSE) {
			$this->send_response(500,'error',500, strip_tags(validation_errors()));
			
		}else{
			$start=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('from_date'))));
			$end=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('to_date'))));
			
			$level = $this->input->post('level');
			
			$data['start_date'] = $start;
			$data['end_date'] = $end;
			$offset=$this->input->post('offset');
	    	$limit=$this->input->post('limit');
			$data['accounts'] =$accounts= $this->db->query("SELECT * FROM tbl_coa WHERE head_level = '$level' order by head_code LIMIT $limit OFFSET $offset")->result_array();
			
			if($accounts){
			$totalCredit = 0;
			$totalDebit = 0;
				foreach($accounts as $key => $acc){
					$balance = $this->db->query("SELECT IFNULL(SUM(a.debit), 0)-IFNULL(SUM(a.credit), 0) as balance FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id && b.date >= '$start' && b.date <= '$end' && a.coa_id LIKE '{$acc['head_code']}%'")->row()->balance;
					if($balance > 0){
						$totalDebit += $balance;
					}else{
						$totalCredit += abs($balance);
					}
					$accounts[$key]['balance']=$balance;
					$accounts[$key]['totalDebit']=$totalDebit;
					$accounts[$key]['totalCredit']=$totalCredit;
				}
			}
			$data['accounts'] =$accounts;
			$saleofproducts = $this->db->query("SELECT IFNULL(SUM(fld_total_discount), 0) discount, IFNULL(SUM(fld_grand_total_amount), 0) amount FROM `tbl_sale` WHERE DATE(fld_sale_date) >= '$start' && DATE(fld_sale_date) <= '$end'")->row();
		
			$cgsOpeningStock = $this->db->query("SELECT IFNULL(SUM(a.debit), 0)-IFNULL(SUM(a.credit), 0) as balance FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id && b.date < '$start' && a.coa_id = '101003001'")->row()->balance;
			
			$cgsPurchase = $this->db->query("SELECT IFNULL(SUM(a.debit), 0) as debit FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id && b.date >= '$start' && b.date <= '$end' && a.coa_id = '101003001'")->row()->debit;
			
			$cgsClosingStock = $this->db->query("SELECT IFNULL(SUM(a.debit), 0)-IFNULL(SUM(a.credit), 0) as balance FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id && a.coa_id = '101003001' and b.date <= '$end'")->row()->balance;
			
			$costOfGoodsSold = $cgsOpeningStock+$cgsPurchase-$cgsClosingStock;
			$data['net_sale']=number_format(@$saleofproducts->amount, 2);
			$data['cost_of_good_sold']=number_format(@$costOfGoodsSold, 2);
			$data['total_debit']=number_format(($totalDebit+$costOfGoodsSold),2);
			$data['total_credit']=number_format(($totalCredit+$saleofproducts->amount),2);
			
			
			if(!empty($data)){
				$this->send_response(200,'success',332,'Trial Balance Report',$data);
			}else{
				$this->send_response(500,'error',500, 'No data found.');
			}
		}
        }
    }
	public function gain_lossfilter(){
	     $device_id=$this->input->post('device_id');
	    $access_token=$this->input->post('access_token');
	    $token = $this->authenticate_token($device_id, $access_token);

        if ($token == '0') {
            $this->send_response(500, 'error', 310, 'Authentication token expired.');
        } elseif ($token == '2') {
            $this->send_response(500, 'error', 320, 'Invalid token / device id.');
        } elseif ($token == 'no token') {
            $this->send_response(500, 'error', 500, 'Please include authentication token & device id with each request.');
        } elseif ($token == '1') {
		$this->form_validation->set_rules('filter','Filter','trim|required');
		$this->form_validation->set_rules('from_date','From Date','trim|required');
		$this->form_validation->set_rules('to_date','To Date','trim|required');
		if($this->form_validation->run() === FALSE) {
			$this->send_response(500,'error',500, strip_tags(validation_errors()));
			
		}else{
		$gain_loss=$this->Apis_model->gain_loss_filter();
			if($gain_loss){
				foreach($gain_loss as $key => $gainloss){
				$mtqty=0;
				$kgqty=0;
				$total_amount=0;
				foreach($gainloss['detail'] as $gainlossdet){
					$mtqty=$mtqty + $gainlossdet['fld_quantity'];
					$total_amount=$total_amount + $gainlossdet['fld_total_amount'];
					$kgqty=$kgqty + ($gainlossdet['fld_quantity'] * 1000);
				}
				$gain_loss[$key]['total_qty']=$mtqty;
				$gain_loss[$key]['total_rate']=$kgqty;
				$gain_loss[$key]['total_net_amount']=$total_amount;
				}
			}
		
		$data['gain_loss']=$gain_loss;
		if(!empty($data)){
				$this->send_response(200,'success',332,'Gain Loss',$data);
			}else{
				$this->send_response(500,'error',500, 'No data found.');
			}
		}
        }
	}
	public function employee_filter(){
	     $device_id=$this->input->post('device_id');
	    $access_token=$this->input->post('access_token');
	    $token = $this->authenticate_token($device_id, $access_token);

        if ($token == '0') {
            $this->send_response(500, 'error', 310, 'Authentication token expired.');
        } elseif ($token == '2') {
            $this->send_response(500, 'error', 320, 'Invalid token / device id.');
        } elseif ($token == 'no token') {
            $this->send_response(500, 'error', 500, 'Please include authentication token & device id with each request.');
        } elseif ($token == '1') {
		$this->form_validation->set_rules('filter','Filter','trim|required');
		if($this->form_validation->run() === FALSE) {
			$this->send_response(500,'error',500, strip_tags(validation_errors()));
			
		}else{
		$data['employees']=$employees=$this->Apis_model->employee_filter();
		if(!empty($data)){
				$this->send_response(200,'success',332,'Employee Report',$data);
			}else{
				$this->send_response(500,'error',500, 'No data found.');
			}
		}
        }
	}
	public function payrol_filter(){
	     $device_id=$this->input->post('device_id');
	    $access_token=$this->input->post('access_token');
	    $token = $this->authenticate_token($device_id, $access_token);

        if ($token == '0') {
            $this->send_response(500, 'error', 310, 'Authentication token expired.');
        } elseif ($token == '2') {
            $this->send_response(500, 'error', 320, 'Invalid token / device id.');
        } elseif ($token == 'no token') {
            $this->send_response(500, 'error', 500, 'Please include authentication token & device id with each request.');
        } elseif ($token == '1') {
		$this->form_validation->set_rules('filter','Filter','trim|required');
		if($this->form_validation->run() === FALSE) {
			$this->send_response(500,'error',500, strip_tags(validation_errors()));
			
		}else{
		$conditions="";
		$filter=$_POST['filter'];
		$offset=$this->input->post('offset');
		$limit=$this->input->post('limit');
		$from_date=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('from_date',TRUE))));
		$to_date=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('to_date',TRUE))));

		$type = @$_POST['type'];
		switch ($filter) {
		  case "employeewise":
			$group_by = "tbl_payroll.user_id";
			$select="tbl_employees.full_name as filter_text,tbl_payroll.user_id as filter_value";
			break;
		  case "designationwise":
			$group_by = "tbl_payroll.designation";
			$select="tbl_designation.designation_name as filter_text,tbl_payroll.designation as filter_value";
			break;
			case "plantwise":
			$group_by = "tbl_payroll.plants";
			$select="tbl_locations.fld_location as filter_text,tbl_payroll.plants as filter_value";
			break;
		}
		$date="tbl_payroll.monthyear >= '$from_date' && tbl_payroll.monthyear <= '$to_date'";
		$this->db->select('tbl_payroll.id,'.$select.'');
		$this->db->from('tbl_payroll');
		

		$this->db->join('tbl_employees','	tbl_employees.id=tbl_payroll.user_id');
		$this->db->join('tbl_designation','tbl_designation.id=tbl_payroll.designation');
		$this->db->join('tbl_locations','tbl_locations.fld_id=tbl_payroll.plants');
		$this->db->where("tbl_payroll.salary_status", 1);
		$this->db->where($date);
		$this->db->group_by($group_by);
		$this->db->limit($limit, $offset);
		$salary=$this->db->get()->result_array();

		if($salary){
			foreach($salary as $key => $seler){
				$selerdet=$this->getSalaryDetail($seler['filter_value'],$group_by, $date);
				$salary[$key]['detail']=$selerdet;
			}
		}

		$total_amount =0;
		if($salary){
			
			foreach($salary as $key => $seler){
				$selerdet=$this->getSalaryDetail($seler['filter_value'],$group_by, $date);
				$salary[$key]['detail']=$selerdet;
				foreach($selerdet as $saler){
				$total_amount += (int) $saler['amount_paid'];	
				}
				
				
			}
		}
		$data['salary'] = $salary;
		$data['total_amount'] = $total_amount;
		$data['filter'] = $filter;
		
		if(!empty($data)){
				$this->send_response(200,'success',332,'Payroll',$data);
			}else{
				$this->send_response(500,'error',500, 'No data found.');
			}
		}
        }	
	}
	function getSalaryDetail($id,$group_by, $date){
      //$date="tbl_purchase.fld_purchase_date between '".date("Y-m-d",strtotime($start))." 00:00:00' AND '".date("Y-m-d",strtotime($end))." 23:59:00'";
		$this->db->select('tbl_payroll.*,tbl_employees.full_name,tbl_employees.employee_code,tbl_designation.designation_name,tbl_locations.fld_location');
		$this->db->from('tbl_payroll');
		$this->db->join('tbl_employees','	tbl_employees.id=tbl_payroll.user_id');
		$this->db->join('tbl_designation','tbl_designation.id=tbl_payroll.designation');
		$this->db->join('tbl_locations','tbl_locations.fld_id=tbl_payroll.plants');
		$this->db->where("tbl_payroll.salary_status", 1);
		$this->db->where($date);
		$this->db->where($group_by,$id);
		return $this->db->get()->result_array();
// 		$this->db->last_query();
	}
	public function expence_filter(){
	     $device_id=$this->input->post('device_id');
	    $access_token=$this->input->post('access_token');
	    $token = $this->authenticate_token($device_id, $access_token);

        if ($token == '0') {
            $this->send_response(500, 'error', 310, 'Authentication token expired.');
        } elseif ($token == '2') {
            $this->send_response(500, 'error', 320, 'Invalid token / device id.');
        } elseif ($token == 'no token') {
            $this->send_response(500, 'error', 500, 'Please include authentication token & device id with each request.');
        } elseif ($token == '1') {
		$this->form_validation->set_rules('from_date','From date','trim|required');
		$this->form_validation->set_rules('to_date','To date','trim|required');
		$this->form_validation->set_rules('filter','Filter','trim|required');
		if($this->form_validation->run() === FALSE) {
			$this->send_response(500,'error',500, strip_tags(validation_errors()));
			
		}else{
		$expense=$this->Apis_model->expense_filter();
	    $nettotal_amount=0;
		if($expense){
			foreach($expense as $keys => $expens){
				foreach($expens['detail'] as $key => $exp){
					$plantfrom =	$this->Common_model->select_single_field('head_name','tbl_coa',array('head_code'=>$exp['plant_from']));
					$exptype="";
					 if($exp['expense_type'] == 1){
						$exptype = "Office Expense";
					}else{
						$exptype = "Mess Expense";
					}
					$expense[$keys]['detail'][$key]['paid_from']=$plantfrom;
					$expense[$keys]['detail'][$key]['type_for']=$exptype.' - '.$exp['expense_value'];
					$nettotal_amount = $nettotal_amount + $exp['unit_price'];
				}
			}
		}
		$data['expense'] = $expense;
		$data['nettotal_amount'] = $nettotal_amount;
		if(!empty($expense)){
			$this->send_response(200,'success',332,'Expence Report',$data);
		}else{
			$this->send_response(500,'error',500, 'No data found.');
		}
		}
        }
	}
	public function get_account_list()
	{
	     $device_id=$this->input->post('device_id');
	    $access_token=$this->input->post('access_token');
	    $token = $this->authenticate_token($device_id, $access_token);

        if ($token == '0') {
            $this->send_response(500, 'error', 310, 'Authentication token expired.');
        } elseif ($token == '2') {
            $this->send_response(500, 'error', 320, 'Invalid token / device id.');
        } elseif ($token == 'no token') {
            $this->send_response(500, 'error', 500, 'Please include authentication token & device id with each request.');
        } elseif ($token == '1') {
		$customer_list = $this->db->query("SELECT * FROM `tbl_coa` WHERE head_code LIKE '%101007%' and head_code != '101007' order by head_name")->result_array();
		$accounts_list = $this->db->query("SELECT * FROM `tbl_coa` WHERE head_level = '3' AND head_code NOT LIKE '%401007%'")->result_array();
		if(!empty($accounts_list)){
			$this->send_response(200,'success',332,'Account List',$accounts_list);
		}else{
			$this->send_response(500,'error',500, 'No data found.');
		}
        }
	}
	public function profitandlossfilter(){
	     $device_id=$this->input->post('device_id');
	    $access_token=$this->input->post('access_token');
	    $token = $this->authenticate_token($device_id, $access_token);

        if ($token == '0') {
            $this->send_response(500, 'error', 310, 'Authentication token expired.');
        } elseif ($token == '2') {
            $this->send_response(500, 'error', 320, 'Invalid token / device id.');
        } elseif ($token == 'no token') {
            $this->send_response(500, 'error', 500, 'Please include authentication token & device id with each request.');
        } elseif ($token == '1') {
		$this->form_validation->set_rules('from_date','From date','trim|required');
		$this->form_validation->set_rules('to_date','To date','trim|required');
		$this->form_validation->set_rules('filter','Filter','trim|required');
		if($this->form_validation->run() === FALSE) {
			$this->send_response(500,'error',500, strip_tags(validation_errors()));
			
		}else{
		$sales=$this->Apis_model->profitandloss_filter();
		
		$amtqty=0;
		 $akgqty=0;
		 $atdiscount=0;
		 $total_all_amount = 0;
		 $total_all_profit = 0;
		if($sales){
			
			foreach($sales as $key => $sale){
				$mtqty=0;
				$kgqty=0;
				$tdiscount=0;
				$total_amount=0;
				$total_profit = 0;
				foreach($sale['detail'] as $keys => $row){
					
					$mtqty=$mtqty + $row['fld_quantity'];
					$tdiscount+=$row['fld_discount'];
					$total_amount=$total_amount + $row['fld_total_amount']-$row['fld_discount'];
					$kgqty=$kgqty +$row['fld_weight'];
					$total_profit += round(($row['fld_total_amount']-$row['fld_discount'])-$row['fld_purchase_amount'],2);
					
					$sales[$key]['detail'][$keys]['cost']= round($row['fld_purchase_amount']/$row['fld_quantity']);
					$sales[$key]['detail'][$keys]['profit_unit']=round((($row['fld_total_amount']-$row['fld_discount'])-$row['fld_purchase_amount'])/$row['fld_quantity']);
					$sales[$key]['detail'][$keys]['profit']=round(($row['fld_total_amount']-$row['fld_discount'])-$row['fld_purchase_amount']);
						if($row['fld_purchase_amount'] > 0){
						$sales[$key]['detail'][$keys]['pnl']= round((((($row['fld_total_amount']-$row['fld_discount'])-	$row['fld_purchase_amount'])) * 100) / ($row['fld_total_amount']-$row['fld_discount']),2);
						}else{
							$sales[$key]['detail'][$keys]['pnl']=0;
						}
				}
				$sales[$key]['sal_quantity']=$mtqty;
				$sales[$key]['sal_weight']=$kgqty;
				$sales[$key]['sal_discount']=$tdiscount;
				$sales[$key]['sal_amount']=$total_amount;
				$sales[$key]['sal_profit']=$total_profit;
				
				$total_all_amount += $total_amount;
				$atdiscount += $tdiscount;
				$akgqty += $kgqty;
				$amtqty += $mtqty;
				$total_all_profit += $total_profit;
			}
		}
		$net_total['total_quantity']=$amtqty;
		$net_total['total_weight']=$akgqty;
		$net_total['total_discount']=$atdiscount;
		$net_total['total_amount']=$total_all_amount;
		$net_total['total_profit']=$total_all_profit;
		
		$data['sales']=$sales;
		$data['net_total']=$net_total;
		
		if(!empty($sales)){
			$this->send_response(200,'success',332,'Profit and Loss Report',$data);
		}else{
			$this->send_response(500,'error',500, 'No data found.');
		}
		}
        }
	}
	public function itemList(){
	     $device_id=$this->input->post('device_id');
	    $access_token=$this->input->post('access_token');
	    $token = $this->authenticate_token($device_id, $access_token);

        if ($token == '0') {
            $this->send_response(500, 'error', 310, 'Authentication token expired.');
        } elseif ($token == '2') {
            $this->send_response(500, 'error', 320, 'Invalid token / device id.');
        } elseif ($token == 'no token') {
            $this->send_response(500, 'error', 500, 'Please include authentication token & device id with each request.');
        } elseif ($token == '1') {
		$product_items=$this->Apis_model->getAllProducts('tbl_category');
		
		if(!empty($product_items)){
			$this->send_response(200,'success',332,'Product item list',$product_items);
		}else{
			$this->send_response(500,'error',500, 'No data found.');
		}
        }
	}
	public function getShipmentsLedger(){
	     $device_id=$this->input->post('device_id');
	    $access_token=$this->input->post('access_token');
	    $token = $this->authenticate_token($device_id, $access_token);

        if ($token == '0') {
            $this->send_response(500, 'error', 310, 'Authentication token expired.');
        } elseif ($token == '2') {
            $this->send_response(500, 'error', 320, 'Invalid token / device id.');
        } elseif ($token == 'no token') {
            $this->send_response(500, 'error', 500, 'Please include authentication token & device id with each request.');
        } elseif ($token == '1') {
        $item_id = $this->input->post('item_id');
        $sitem_id = $this->input->post('sub_item_id');
        
        if($item_id == 1){
            $shipments = $this->db->query("SELECT b.fld_shipment FROM tbl_purchase_detail as a, tbl_purchase as b WHERE b.fld_id = a.fld_purchase_id && a.fld_product_id = '1' GROUP by fld_shipment")->result_array();
        }else{
            if($sitem_id =='all'){
                $shipments =  $this->db->query("SELECT b.fld_shipment FROM tbl_purchase_detail as a, tbl_purchase as b WHERE b.fld_id = a.fld_purchase_id && a.fld_product_id = '$item_id' GROUP by fld_shipment")->result_array();
            }else{
                $shipments =  $this->db->query("SELECT b.fld_shipment FROM tbl_purchase_detail as a, tbl_purchase as b WHERE b.fld_id = a.fld_purchase_id && a.fld_product_id = '$item_id' && a.fld_subproduct_id = '$sitem_id' GROUP by fld_shipment")->result_array();
            }
        }
       
        if(!empty($shipments)){
			$this->send_response(200,'success',332,'Shipment ledger list',$shipments);
		}else{
			$this->send_response(500,'error',500, 'No data found.');
		}
        } 
    }
    public function tableviewlpg()
	{
	     $device_id=$this->input->post('device_id');
	    $access_token=$this->input->post('access_token');
	    $token = $this->authenticate_token($device_id, $access_token);

        if ($token == '0') {
            $this->send_response(500, 'error', 310, 'Authentication token expired.');
        } elseif ($token == '2') {
            $this->send_response(500, 'error', 320, 'Invalid token / device id.');
        } elseif ($token == 'no token') {
            $this->send_response(500, 'error', 500, 'Please include authentication token & device id with each request.');
        } elseif ($token == '1') {
		$this->load->model('Navigations_model');
		$locations =$this->Base_model->getAll('tbl_locations', '', "fld_id <> 8", '');
		 $total_qty = 0;
        $total_purchase_amount = 0;
		if($locations){
			foreach($locations as $key => $loc){
				$shipments = $this->Navigations_model->getShipments($loc['fld_id'], 1, 0);
				$prices = array();
                $total_amount = 0;
				$priceSum=0;
				foreach($shipments as $ship){
					$fright = 0;
            		if($ship['fld_nav_id'] != 0){
            		    $fright = $this->db->query("SELECT * FROM `tbl_navigations` WHERE fld_id = '{$ship['fld_nav_id']}'")->row()->fld_freight_MT;
            		}
            		$price = 0;
            		
                    if($ship['fld_purchase_id'] != 0){
        		        $purchasePrice = $this->db->query("SELECT a.fld_unit_price, b.fld_grand_total_amount FROM tbl_purchase_detail a, tbl_purchase b WHERE b.fld_id = a.fld_purchase_id && a.fld_product_id = '1' && b.fld_id = '{$ship['fld_purchase_id']}'")->row_array();
            		    $price = $purchasePrice['fld_unit_price'];
            		    $total_amount += ($purchasePrice['fld_grand_total_amount']+$fright);
            		    
        		    }
        		    if($price > 0){
        		        array_push($prices, $price);
        		    }
				}
				$date = date('Y-m-d');
                $todaypurchase1= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_purchase as a, tbl_purchase_detail as b WHERE DATE(a.fld_purchase_date) = '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_purchase_id = a.fld_id AND b.fld_product_id = '1'")->row()->fld_quantity+0; 
                $pastpurchase1= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_purchase as a, tbl_purchase_detail as b WHERE DATE(a.fld_purchase_date) < '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_purchase_id = a.fld_id AND b.fld_product_id = '1'")->row()->fld_quantity+0;
                $todaysale1= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) = '$date' AND a.fld_location_from = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '1'")->row()->fld_quantity+0;
                $pastsale1= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) < '$date' AND a.fld_location_from = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '1'")->row()->fld_quantity+0;
              
                $tsale = 0;
                $psale = 0;
                $todaypurchase2= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) = '$date' AND a.fld_location_to = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '1'")->row()->fld_quantity+0; 
                $pastpurchase2= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) < '$date' AND a.fld_location_to = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '1'")->row()->fld_quantity+0;
                $todaysale2= $this->db->query("SELECT sc.fld_subcategory, sc.weight, b.fld_quantity as fld_quantity FROM tbl_sale as a, tbl_sale_detail as b, tbl_subcategory as sc WHERE DATE(a.fld_sale_date) = '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_sale_id = a.fld_id AND sc.fld_subcid = b.fld_subproduct_id AND b.fld_product_id = '1'")->result_array();
                $pastsale2= $this->db->query("SELECT sc.fld_subcategory, sc.weight, b.fld_quantity as fld_quantity FROM tbl_sale as a, tbl_sale_detail as b, tbl_subcategory as sc WHERE DATE(a.fld_sale_date) < '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_sale_id = a.fld_id AND sc.fld_subcid = b.fld_subproduct_id AND b.fld_product_id = '1'")->result_array();
                
                $todaypurchase3= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_gain_loss as a, tbl_gainloss_details as b WHERE DATE(a.fld_date) = '$date' AND b.fld_location_id = '{$loc['fld_id']}' AND b.fld_gl_id = a.fld_id AND b.fld_product_id = '1' and b.fld_type=1")->row()->fld_quantity+0; 
                $pastpurchase3= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_gain_loss as a, tbl_gainloss_details as b WHERE DATE(a.fld_date) < '$date' AND b.fld_location_id = '{$loc['fld_id']}' AND b.fld_gl_id = a.fld_id AND b.fld_product_id = '1' and b.fld_type=1")->row()->fld_quantity+0;
                
                foreach($todaysale2 as $tdsale){
                    $tsale += $tdsale['weight']*$tdsale['fld_quantity'];
                }
                foreach($pastsale2 as $ptsale){
                    $psale += $ptsale['weight']*$ptsale['fld_quantity'];
                }
                $todaysale2 = $tsale;
                $pastsale2 = $psale;
                
                $gl_diff = $this->db->query("SELECT IFNULL(SUM(fld_quantity), 0) as qty FROM tbl_gainloss_details WHERE fld_type = 3 && fld_location_id = '{$loc['fld_id']}'")->row_array();
                $totalDiff = round($gl_diff['qty']/1000, 3); 
                $totalDiff = $gl_diff['qty']; 
                $pastpurchase = $pastpurchase1+$pastpurchase2+($pastpurchase3/1000);
                $todaypurchase = $todaypurchase1+$todaypurchase2+($todaypurchase3/1000);  
              
                $pastpurchasekg = $pastpurchase * 1000;
                $todaypurchasekg = $todaypurchase * 1000;
                $todaysale = ($todaysale1*1000)+$todaysale2;
                $pastsale = ($pastsale1*1000)+$pastsale2;
              
                $openingstock = $pastpurchasekg - $pastsale;
                $closingstock = ($openingstock + $todaypurchasekg - $todaysale)+$totalDiff;
                
                $total_purchase_amount += $total_amount;
                $total_qty += round($closingstock/1000, 3); 
				
				$locations[$key]['quantity']=round($closingstock/1000, 3);
				$locations[$key]['purchase']=$total_amount;
				if(count($prices)>0){ 
			    
			        $priceSum= round(array_sum($prices)/count($prices), 2);
			
			    }else{ 
					$priceSum=0;
				} 
				$locations[$key]['rate']=$priceSum;
			}
		}
		 if(!empty($locations)){
			$this->send_response(200,'success',332,'Daily Stock',$locations);
		}else{
			$this->send_response(500,'error',500, 'No data found.');
		}
        }
	}
	public function lpgempty()
	{
	     $device_id=$this->input->post('device_id');
	    $access_token=$this->input->post('access_token');
	    $token = $this->authenticate_token($device_id, $access_token);

        if ($token == '0') {
            $this->send_response(500, 'error', 310, 'Authentication token expired.');
        } elseif ($token == '2') {
            $this->send_response(500, 'error', 320, 'Invalid token / device id.');
        } elseif ($token == 'no token') {
            $this->send_response(500, 'error', 500, 'Please include authentication token & device id with each request.');
        } elseif ($token == '1') {
		$empty_cylender=array();
		$total=array();
		$locations= $this->Base_model->getAll('tbl_locations', '', "fld_id <> 8", '');
		$type1_total=0;
        $type2_total=0;
        $type3_total=0;
        $total_amount = 0;
          if($locations){
          $i=1;
          foreach($locations as $key => $loc){
               $type1=$this->getStockPlantWise($loc['fld_id'], 2, 5);
               $type2=$this->getStockPlantWise($loc['fld_id'], 2, 8);
               $type3=$this->getStockPlantWise($loc['fld_id'], 2, 9);
               $type1_total +=$type1['closingstock']; 
               $type2_total +=$type2['closingstock']; 
               $type3_total +=$type3['closingstock']; 
               $total_amount += ($type1['total_amount']+$type2['total_amount']+$type3['total_amount']);
			   $empty_cylender[$key]['fld_location']=$loc['fld_location'];
			   $empty_cylender[$key]['closingstock_11_8']=$type1['closingstock'];
			   $empty_cylender[$key]['rate_11_8']=$type1['price'];
			   $empty_cylender[$key]['closingstock_15']=$type2['closingstock'];
			   $empty_cylender[$key]['rate_15']=$type2['price'];
			   $empty_cylender[$key]['closingstock_45']=$type3['closingstock'];
			   $empty_cylender[$key]['rate_45']=$type3['price'];
			   $empty_cylender[$key]['total']=$type1['total_amount']+$type2['total_amount']+$type3['total_amount'];
			   
		  }
		 }
		
			 $total['type1_total']=$type1_total;
			 $total['type2_total']=$type2_total;
			 $total['type3_total']=$type3_total;
			 $total['total_amount']=$total_amount;
			 $data['empty_cylender']=$empty_cylender;
			 $data['total']=$total;
		  if(!empty($data)){
				$this->send_response(200,'success',332,'Empty Cylinders',$data);
			}else{
				$this->send_response(500,'error',500, 'No data found.');
			}
        }
	}
	function getStockPlantWise($plant_id, $product_id, $sub_product_id){
		 $device_id=$this->input->post('device_id');
	    $access_token=$this->input->post('access_token');
	    $token = $this->authenticate_token($device_id, $access_token);

        if ($token == '0') {
            $this->send_response(500, 'error', 310, 'Authentication token expired.');
        } elseif ($token == '2') {
            $this->send_response(500, 'error', 320, 'Invalid token / device id.');
        } elseif ($token == 'no token') {
            $this->send_response(500, 'error', 500, 'Please include authentication token & device id with each request.');
        } elseif ($token == '1') {
		$this->load->model('Navigations_model');
	    $date = date('Y-m-d');
	    
	    $shipments = $this->Navigations_model->getShipments($plant_id, $product_id, $sub_product_id);
                $prices = array();
                $total_amount = 0;
                foreach($shipments as $ship){
                    $fright = 0;
            		if($ship['fld_nav_id'] != 0){
            		    $fright = $this->db->query("SELECT * FROM `tbl_navigations` WHERE fld_id = '{$ship['fld_nav_id']}'")->row()->fld_freight_MT;
            		}
            		$price = 0;
            		
                    if($ship['fld_purchase_id'] != 0){
        		        $purchasePrice = $this->db->query("SELECT a.fld_unit_price, b.fld_grand_total_amount FROM tbl_purchase_detail a, tbl_purchase b WHERE b.fld_id = a.fld_purchase_id && a.fld_product_id = '$product_id' && a.fld_subproduct_id = '$sub_product_id' && b.fld_id = '{$ship['fld_purchase_id']}'")->row_array();
            		    $price = $purchasePrice['fld_unit_price'];
            		    $total_amount += ($purchasePrice['fld_grand_total_amount']+$fright);
            		    
        		    }
        		    if($price > 0){
        		        array_push($prices, $price);
        		    }
        		    
                }
	    $todaypurchase1= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_purchase as a, tbl_purchase_detail as b WHERE DATE(a.fld_purchase_date) = '$date' AND a.fld_location_id = '$plant_id' AND b.fld_purchase_id = a.fld_id AND b.fld_product_id = '$product_id' AND b.fld_subproduct_id = '$sub_product_id'")->row()->fld_quantity+0; 
        $pastpurchase1= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_purchase as a, tbl_purchase_detail as b WHERE DATE(a.fld_purchase_date) < '$date' AND a.fld_location_id = '$plant_id' AND b.fld_purchase_id = a.fld_id AND b.fld_product_id = '$product_id' AND b.fld_subproduct_id = '$sub_product_id'")->row()->fld_quantity+0;
        $todaysale1= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) = '$date' AND a.fld_location_from = '$plant_id' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '$product_id' AND b.fld_subproduct_id = '$sub_product_id'")->row()->fld_quantity+0;
        $pastsale1= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) < '$date' AND a.fld_location_from = '$plant_id' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '$product_id' AND b.fld_subproduct_id = '$sub_product_id'")->row()->fld_quantity+0;
      
        $tsale = 0;
        $psale = 0;
        $todaypurchase2= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) = '$date' AND a.fld_location_to = '$plant_id' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '$product_id' AND b.fld_subproduct_id = '$sub_product_id'")->row()->fld_quantity+0; 
        $pastpurchase2= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) < '$date' AND a.fld_location_to = '$plant_id' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '$product_id' AND b.fld_subproduct_id = '$sub_product_id'")->row()->fld_quantity+0;
        $todaysale2= $this->db->query("SELECT sc.fld_subcategory, b.fld_quantity as fld_quantity FROM tbl_sale as a, tbl_sale_detail as b, tbl_subcategory as sc WHERE DATE(a.fld_sale_date) = '$date' AND a.fld_location_id = '$plant_id' AND b.fld_sale_id = a.fld_id AND sc.fld_subcid = b.fld_subproduct_id AND b.fld_product_id = '$product_id' AND b.fld_subproduct_id = '$sub_product_id'")->result_array();
        $pastsale2= $this->db->query("SELECT sc.fld_subcategory, b.fld_quantity as fld_quantity FROM tbl_sale as a, tbl_sale_detail as b, tbl_subcategory as sc WHERE DATE(a.fld_sale_date) < '$date' AND a.fld_location_id = '$plant_id' AND b.fld_sale_id = a.fld_id AND sc.fld_subcid = b.fld_subproduct_id AND b.fld_product_id = '$product_id' AND b.fld_subproduct_id = '$sub_product_id'")->result_array();
	
	    
	    foreach($todaysale2 as $tdsale){
            $tsale += $tdsale['fld_quantity'];
        }
        foreach($pastsale2 as $ptsale){
            $psale += $ptsale['fld_quantity'];
        }
        $todaysale2 = $tsale;
        $pastsale2 = $psale;
        
          $pastpurchase = $pastpurchase1+$pastpurchase2;
          $todaypurchase = $todaypurchase1+$todaypurchase2;  
          
          $todaysale = $todaysale1+$todaysale2;
          $pastsale = $pastsale1+$pastsale2;
          
          $openingstock = $pastpurchase - $pastsale;
          $closingstock = $openingstock + $todaypurchase - $todaysale;
          if(count($prices)>0){ 
			    
			        $avgPrice =  round(array_sum($prices)/count($prices), 2);
			
			    }else{ $avgPrice = 0; }
		$dataarrayreturn['closingstock'] = $closingstock;
		$dataarrayreturn['price'] = $avgPrice;
		$dataarrayreturn['total_amount'] = $total_amount;
		return $dataarrayreturn;
	}
	}
	public function parts()
	{
	     $device_id=$this->input->post('device_id');
	    $access_token=$this->input->post('access_token');
	    $token = $this->authenticate_token($device_id, $access_token);

        if ($token == '0') {
            $this->send_response(500, 'error', 310, 'Authentication token expired.');
        } elseif ($token == '2') {
            $this->send_response(500, 'error', 320, 'Invalid token / device id.');
        } elseif ($token == 'no token') {
            $this->send_response(500, 'error', 500, 'Please include authentication token & device id with each request.');
        } elseif ($token == '1') {
		$data['categories']=$categories=$this->Base_model->getAll('tbl_subcategory', '', "fld_cid = 4", '');
		$locations=$this->Base_model->getAll('tbl_locations', '', "fld_id <> 8", '');
		$parts=array();
		if($locations){
		  $i=0;
		  foreach($locations as $key => $loc){
			  $parts[$key]['fld_location']=$loc['fld_location'];
			  
			  $total_amount = 0;
			  foreach($categories as $keys => $cat){
				$index=str_replace(' ','_',$cat['fld_subcategory']);
			    $stockdata = $this->getStockPlantWise($loc['fld_id'], 4, $cat['fld_subcid']);
			    $total_amount += $stockdata['total_amount'];
				$parts[$key]['category'][$keys][$index]=$cat['fld_subcategory'];
				$parts[$key]['category'][$keys]['Rate_'.$index]=$stockdata['price'];
				$parts[$key]['category'][$keys]['closingstock'.$index]=$stockdata['closingstock'];
				//$parts[$key]['category'][$keys]=$stockdata['price'];
			  }
			  
			  $parts[$key]['total_amount']=$total_amount;
			}
		}
		$data['parts']=$parts;
		if(!empty($data)){
			$this->send_response(200,'success',332,'Parts',$data);
		}else{
			$this->send_response(500,'error',500, 'No data found.');
		}
        }
	}
	public function stock_report_filter(){
		 $device_id=$this->input->post('device_id');
	    $access_token=$this->input->post('access_token');
	    $token = $this->authenticate_token($device_id, $access_token);

        if ($token == '0') {
            $this->send_response(500, 'error', 310, 'Authentication token expired.');
        } elseif ($token == '2') {
            $this->send_response(500, 'error', 320, 'Invalid token / device id.');
        } elseif ($token == 'no token') {
            $this->send_response(500, 'error', 500, 'Please include authentication token & device id with each request.');
        } elseif ($token == '1') {
		$this->form_validation->set_rules('frmdate','From date','trim|required');
		$this->form_validation->set_rules('todate','To date','trim|required');
		$this->form_validation->set_rules('plant_for','Plant Filter','trim|required');
		$this->form_validation->set_rules('item_type','Item Filter','trim|required');
		if($this->form_validation->run() === FALSE) {
			$this->send_response(500,'error',500, strip_tags(validation_errors()));
			
		}else{
	    $frmDate = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['frmdate'])));
	    $toDate = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['todate'])));
	    $plant_for = $_POST['plant_for'];
	    $item_type = $_POST['item_type'];
	    $sitem_type = $_POST['sitem_type'];
	    $data = '';
	    $sn = 0;
		$stock=array();
        while (strtotime($frmDate) <= strtotime($toDate)) {
            if($plant_for == 'all'){
                $locations = $this->db->query("select * from tbl_locations where fld_id <> 8")->result_array();
            }else{
                $locations = $this->db->query("select * from tbl_locations where fld_id = '$plant_for'")->result_array();
            }
            foreach($locations as $key => $loc){
                $sn++;
                $date = $frmDate;
                
                if($item_type==1){
                    
                
                $todaypurchase1= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_purchase as a, tbl_purchase_detail as b WHERE DATE(a.fld_purchase_date) = '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_purchase_id = a.fld_id AND b.fld_product_id = '1'")->row()->fld_quantity+0; 
                $pastpurchase1= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_purchase as a, tbl_purchase_detail as b WHERE DATE(a.fld_purchase_date) < '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_purchase_id = a.fld_id AND b.fld_product_id = '1'")->row()->fld_quantity+0;
                $todaysale1= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_date) = '$date' AND a.fld_location_from = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '1'")->row()->fld_quantity+0;
                $pastsale1= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_date) < '$date' AND a.fld_location_from = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '1'")->row()->fld_quantity+0;
              
       
                $tsale = 0;
                $psale = 0;
                $todaypurchase2= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_date) = '$date' AND a.fld_location_to = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '1'")->row()->fld_quantity+0; 
                $pastpurchase2= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_date) < '$date' AND a.fld_location_to = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '1'")->row()->fld_quantity+0;
                $todaysale2= $this->db->query("SELECT sc.fld_subcategory, sc.weight, b.fld_quantity as fld_quantity FROM tbl_sale as a, tbl_sale_detail as b, tbl_subcategory as sc WHERE DATE(a.fld_sale_date) = '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_sale_id = a.fld_id AND sc.fld_subcid = b.fld_subproduct_id AND b.fld_product_id = '1'")->result_array();
                $pastsale2= $this->db->query("SELECT sc.fld_subcategory, sc.weight, b.fld_quantity as fld_quantity FROM tbl_sale as a, tbl_sale_detail as b, tbl_subcategory as sc WHERE DATE(a.fld_sale_date) < '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_sale_id = a.fld_id AND sc.fld_subcid = b.fld_subproduct_id AND b.fld_product_id = '1'")->result_array();
                
                $todaypurchase3= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_gain_loss as a, tbl_gainloss_details as b WHERE DATE(a.fld_date) = '$date' AND b.fld_location_id = '{$loc['fld_id']}' AND b.fld_gl_id = a.fld_id AND b.fld_product_id = '1' and b.fld_type=1")->row()->fld_quantity+0; 
                $pastpurchase3= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_gain_loss as a, tbl_gainloss_details as b WHERE DATE(a.fld_date) < '$date' AND b.fld_location_id = '{$loc['fld_id']}' AND b.fld_gl_id = a.fld_id AND b.fld_product_id = '1' and b.fld_type=1")->row()->fld_quantity+0;
                
                
                foreach($todaysale2 as $tdsale){
                    $tsale += $tdsale['weight']*$tdsale['fld_quantity'];
                }
                foreach($pastsale2 as $ptsale){
                    $psale += $ptsale['weight']*$ptsale['fld_quantity'];
                }
                $todaysale2 = $tsale;
                $pastsale2 = $psale;
                
           
               $pastpurchase = $pastpurchase1+$pastpurchase2+($pastpurchase3/1000);
               $todaypurchase = $todaypurchase1+$todaypurchase2+($todaypurchase3/1000);  
              
              $pastpurchasekg = $pastpurchase * 1000;
              $todaypurchasekg = $todaypurchase * 1000;
              $todaysale = ($todaysale1*1000)+$todaysale2;
              $pastsale = ($pastsale1*1000)+$pastsale2;
              
              $gl_diff = $this->db->query("SELECT IFNULL(SUM(fld_quantity), 0) as qty FROM tbl_gainloss_details WHERE fld_type = 3 && fld_location_id = '{$loc['fld_id']}'")->row_array();
                // $totalDiff = round($gl_diff['qty']/1000, 3); 
                $totalDiff = $gl_diff['qty']; 
              
              $openingstock = $pastpurchasekg - $pastsale;
              $closingstock = ($openingstock + $todaypurchasekg - $todaysale)+$totalDiff;
                $openingstockShow = $openingstock/1000;
                $todaysaleShow = $todaysale/1000;
                $closingstockShow = $closingstock/1000;
                
                }else{
                    if($sitem_type != 'all'){
                    $todaypurchase1= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_purchase as a, tbl_purchase_detail as b WHERE DATE(a.fld_purchase_date) = '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_purchase_id = a.fld_id AND b.fld_product_id = '$item_type' AND b.fld_subproduct_id = '$sitem_type'")->row()->fld_quantity+0; 
                    $pastpurchase1= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_purchase as a, tbl_purchase_detail as b WHERE DATE(a.fld_purchase_date) < '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_purchase_id = a.fld_id AND b.fld_product_id = '$item_type' AND b.fld_subproduct_id = '$sitem_type'")->row()->fld_quantity+0;
                    $todaysale1= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) = '$date' AND a.fld_location_from = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '$item_type' AND b.fld_subproduct_id = '$sitem_type'")->row()->fld_quantity+0;
                    $pastsale1= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) < '$date' AND a.fld_location_from = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '$item_type' AND b.fld_subproduct_id = '$sitem_type'")->row()->fld_quantity+0;
                  
                    $tsale = 0;
                    $psale = 0;
                    $todaypurchase2= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) = '$date' AND a.fld_location_to = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '$item_type' AND b.fld_subproduct_id = '$sitem_type'")->row()->fld_quantity+0; 
                    $pastpurchase2= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) < '$date' AND a.fld_location_to = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '$item_type' AND b.fld_subproduct_id = '$sitem_type'")->row()->fld_quantity+0;
                    $todaysale2= $this->db->query("SELECT sc.fld_subcategory, b.fld_quantity as fld_quantity FROM tbl_sale as a, tbl_sale_detail as b, tbl_subcategory as sc WHERE DATE(a.fld_sale_date) = '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_sale_id = a.fld_id AND sc.fld_subcid = b.fld_subproduct_id AND b.fld_product_id = '$item_type' AND b.fld_subproduct_id = '$sitem_type'")->result_array();
                    $pastsale2= $this->db->query("SELECT sc.fld_subcategory, b.fld_quantity as fld_quantity FROM tbl_sale as a, tbl_sale_detail as b, tbl_subcategory as sc WHERE DATE(a.fld_sale_date) < '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_sale_id = a.fld_id AND sc.fld_subcid = b.fld_subproduct_id AND b.fld_product_id = '$item_type' AND b.fld_subproduct_id = '$sitem_type'")->result_array();
                }else{
                    $todaypurchase1= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_purchase as a, tbl_purchase_detail as b WHERE DATE(a.fld_purchase_date) = '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_purchase_id = a.fld_id AND b.fld_product_id = '$item_type'")->row()->fld_quantity+0; 
                    $pastpurchase1= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_purchase as a, tbl_purchase_detail as b WHERE DATE(a.fld_purchase_date) < '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_purchase_id = a.fld_id AND b.fld_product_id = '$item_type'")->row()->fld_quantity+0;
                    $todaysale1= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) = '$date' AND a.fld_location_from = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '$item_type'")->row()->fld_quantity+0;
                    $pastsale1= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) < '$date' AND a.fld_location_from = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '$item_type'")->row()->fld_quantity+0;
                  
                    $tsale = 0;
                    $psale = 0;
                    $todaypurchase2= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) = '$date' AND a.fld_location_to = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '$item_type'")->row()->fld_quantity+0; 
                    $pastpurchase2= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) < '$date' AND a.fld_location_to = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '$item_type'")->row()->fld_quantity+0;
                    $todaysale2= $this->db->query("SELECT sc.fld_subcategory, b.fld_quantity as fld_quantity FROM tbl_sale as a, tbl_sale_detail as b, tbl_subcategory as sc WHERE DATE(a.fld_sale_date) = '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_sale_id = a.fld_id AND sc.fld_subcid = b.fld_subproduct_id AND b.fld_product_id = '$item_type'")->result_array();
                    $pastsale2= $this->db->query("SELECT sc.fld_subcategory, b.fld_quantity as fld_quantity FROM tbl_sale as a, tbl_sale_detail as b, tbl_subcategory as sc WHERE DATE(a.fld_sale_date) < '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_sale_id = a.fld_id AND sc.fld_subcid = b.fld_subproduct_id AND b.fld_product_id = '$item_type'")->result_array();
                }
                
                
                
                foreach($todaysale2 as $tdsale){
                    $tsale += $tdsale['fld_quantity'];
                }
                foreach($pastsale2 as $ptsale){
                    $psale += $ptsale['fld_quantity'];
                }
                $todaysale2 = $tsale;
                $pastsale2 = $psale;
                
              $pastpurchase = $pastpurchase1+$pastpurchase2;
              $todaypurchase = $todaypurchase1+$todaypurchase2;  
              
              $todaysale = $todaysale1+$todaysale2;
              $pastsale = $pastsale1+$pastsale2;
              
              $openingstock = $pastpurchase - $pastsale;
              $closingstock = $openingstock + $todaypurchase - $todaysale;
              
              $openingstockShow = $openingstock;
                $todaysaleShow = $todaysale;
                $closingstockShow = $closingstock;
                }
                
	  
                $stock[$sn]['frmDate']=date('d/m/Y', strtotime($frmDate));
                $stock[$sn]['fld_location']=$loc['fld_location'];
                $stock[$sn]['openingstockShow']=round($openingstockShow, 3);
                $stock[$sn]['todaypurchase']=$todaypurchase;
                $stock[$sn]['todaysaleShow']=round($todaysaleShow, 3);
                $stock[$sn]['closingstockShow']=round($closingstockShow, 3);
                
            }
            
            $frmDate = date ("Y-m-d", strtotime("+1 day", strtotime($frmDate)));
	    }
	   $stock=array_values($stock);
		if(!empty($stock)){
			$this->send_response(200,'success',332,'Stock Report',$stock);
		}else{
			$this->send_response(500,'error',500, 'No data found.');
		}
	}
        }
	}
	public function balancesheet_report()
    {
		  $device_id=$this->input->post('device_id');
	    $access_token=$this->input->post('access_token');
	    $token = $this->authenticate_token($device_id, $access_token);

        if ($token == '0') {
            $this->send_response(500, 'error', 310, 'Authentication token expired.');
        } elseif ($token == '2') {
            $this->send_response(500, 'error', 320, 'Invalid token / device id.');
        } elseif ($token == 'no token') {
            $this->send_response(500, 'error', 500, 'Please include authentication token & device id with each request.');
        } elseif ($token == '1') {
		$assets= $this->db->query("SELECT * FROM tbl_coa WHERE head_level='1' && (head_code LIKE '101%' || head_code LIKE '102%') ORDER BY head_code asc")->result_array();
	    $liabilitiesequity= $this->db->query("SELECT * FROM tbl_coa WHERE head_level='1' && ( head_code LIKE '201%' || head_code LIKE '202%' || head_code LIKE '203%' || head_code LIKE '204%' || head_code LIKE '205%') ORDER BY head_code asc")->result_array();
		$year = $this->db->query("SELECT * FROM app_years ORDER BY id DESC LIMIT 0,1")->row_array();
		$start_date = date("Y-m-d",strtotime($year['date_start']));
		$end_date = date("Y-m-d",strtotime($year['date_end']));  
		
		 $visit=array();
		for ($i = 0; $i < count($assets); $i++)
		{
			$visit[$i] = false;
		}
		$responce=array();
		$assets=$this->Apis_model->get_balancesheetdfs("Assets","1",$assets,$visit,0, 0, $start_date, $end_date);
		
		$visit=array();
		for ($i = 0; $i < count($liabilitiesequity); $i++)
		{
			$visit[$i] = false;
		}
		$liabilities=$this->Apis_model->get_balancesheetdfs("Liabilities & Owners Equity","2",$liabilitiesequity,$visit,0, 1, $start_date, $end_date);
		
		$data['liabilities']=$liabilities;
		$data['assets']=$assets;
	
		if(!empty($data)){
			$this->send_response(200,'success',332,'Balance Sheet',$data);
		}else{
			$this->send_response(500,'error',500, 'No data found.');
		}
        } 
    }
    public function getAllPlants(){
         $device_id=$this->input->post('device_id');
	    $access_token=$this->input->post('access_token');
	    $token = $this->authenticate_token($device_id, $access_token);

        if ($token == '0') {
            $this->send_response(500, 'error', 310, 'Authentication token expired.');
        } elseif ($token == '2') {
            $this->send_response(500, 'error', 320, 'Invalid token / device id.');
        } elseif ($token == 'no token') {
            $this->send_response(500, 'error', 500, 'Please include authentication token & device id with each request.');
        } elseif ($token == '1') {
		$tbl_plants	=	$this->Common_model->select_where_ASC_DESC('fld_id,fld_location','tbl_locations',array('fld_status'=>1, 'fld_id<>'=>8),'fld_location','ASC')->result_array();
		if(!empty($tbl_plants)){
			$this->send_response(200,'success',332,'All Plants',$tbl_plants);
		}else{
			$this->send_response(500,'error',500, 'No data found.');
		}
        }
	}
	public function cashflow_filter() {
		 $device_id=$this->input->post('device_id');
	    $access_token=$this->input->post('access_token');
	    $token = $this->authenticate_token($device_id, $access_token);

        if ($token == '0') {
            $this->send_response(500, 'error', 310, 'Authentication token expired.');
        } elseif ($token == '2') {
            $this->send_response(500, 'error', 320, 'Invalid token / device id.');
        } elseif ($token == 'no token') {
            $this->send_response(500, 'error', 500, 'Please include authentication token & device id with each request.');
        } elseif ($token == '1') {	
		$start=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('from_date'))));
		$end=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('to_date'))));
		$type = $this->input->post('type');
		$filter = $this->input->post('group');
		$offset=$this->input->post('offset');
		$limit=$this->input->post('limit');
		switch ($filter) {
		  case "Voucher_Wise":
			$group_by = "tm.type";
			$select="tm.type as filter_text,tm.type as filter_value";
			break;
		  case "User_Wise":
			$group_by = "tm.user_id";
			$select="tbl_users.fld_username as filter_text,tm.user_id as filter_value";
			break;
		case "Account_Wise":
			$group_by = "td.coa_id";
			$select="tbl_coa.head_name as filter_text,td.coa_id as filter_value";
			break;
		case "Date_Wise":
			$group_by = "tm.date";
			$select="DATE_FORMAT(tm.date, '%d-%m-%Y') as filter_text,tm.date as filter_value";
			break;
		}
		
		$date="tm.date between '".date("Y-m-d",strtotime($start))."' AND '".date("Y-m-d",strtotime($end))."'";
		$this->db->select($select);
		
		$this->db->from('tbl_transections_details as td');
		
		$this->db->join('tbl_transections_master as tm','tm.id=td.v_id');
		
		$this->db->join('tbl_coa','tbl_coa.head_code=td.coa_id');
		
		
		$this->db->join('tbl_users','tbl_users.fld_id=tm.user_id');
		
		$this->db->where($date);
		
		if($type != 'all'){
			$this->db->where("tm.type",$type);
		}
		
		$this->db->group_by($group_by);
		
		$this->db->limit($limit, $offset);
		
	    $ledger=$this->db->get()->result_array();
	   // print_r($ledger);
	   // exit;
	    
	    
		if($ledger){
			foreach($ledger as $key => $ledg){
				 if($type != 'all'){
				    $ledgdet=$this->db->query("SELECT td.*, tm.type, tm.type_id, tm.date FROM tbl_transections_details AS td JOIN tbl_transections_master AS tm ON tm.id=td.v_id AND $group_by = '{$ledg['filter_value']}' AND tm.post_status = 0 and $date and tm.type='$type' ORDER BY tm.date, td.id")->result_array();
			    }else{
			        $ledgdet=$this->db->query("SELECT td.*, tm.type, tm.type_id, tm.date FROM tbl_transections_details AS td JOIN tbl_transections_master AS tm ON tm.id=td.v_id AND $group_by = '{$ledg['filter_value']}' AND tm.post_status = 0 and $date  ORDER BY tm.date, td.id")->result_array();
			    }
				$ledger[$key]['detail']=$ledgdet;
			}
		}
		
		if(!empty($ledger)){
		        $all_total_credit=0;
				$all_total_debit=0;
				$all_balance=0;
		    foreach($ledger as $key => $ledge){
		    	$total_credit=0;
				$total_debit=0;
				$balance=0;
				foreach($ledge['detail'] as $keys => $ledgedet){
				    $total_credit +=$ledgedet['credit'];
				    $total_debit +=$ledgedet['debit'];
				    $balance += $ledgedet['debit']-$ledgedet['credit'];
				    $ledger[$key]['detail'][$keys]['t_credit']=$total_credit;
				    $ledger[$key]['detail'][$keys]['t_debit']=$total_debit;
				    $ledger[$key]['detail'][$keys]['t_balance']=$balance;
				    
				    $ledger[$key]['detail'][$keys]['account']=$this->db->query("SELECT * FROM tbl_coa WHERE head_code = '{$ledgedet['coa_id']}'")->row()->head_name;
				}
				$ledger[$key]['total_credit']=$total_credit;
				$ledger[$key]['total_debit']=$total_debit;
				$ledger[$key]['balance']=$balance;
				$all_total_credit=$all_total_credit+$total_credit;
				$all_total_debit=$all_total_debit+$total_debit;
				$all_balance=$all_balance+$balance;
		    }
		    $data['ledger']=$ledger;
		    $data['all_total_credit']=$all_total_credit;
		    $data['all_total_debit']=$all_total_debit;
		    $data['all_balance']=$all_balance;
		   // echo '<pre>';
		    //print_r($data);
		   // exit;
			$this->send_response(200,'success',332,'Cash Flow',$data);
		}else{
			$this->send_response(500,'error',500, 'No data found.');
		}
        }	
        
    }
    
    public function getStatisticsData() {
		 $device_id=$this->input->post('device_id');
	    $access_token=$this->input->post('access_token');
	    $token = $this->authenticate_token($device_id, $access_token);

        if ($token == '0') {
            $this->send_response(500, 'error', 310, 'Authentication token expired.');
        } elseif ($token == '2') {
            $this->send_response(500, 'error', 320, 'Invalid token / device id.');
        } elseif ($token == 'no token') {
            $this->send_response(500, 'error', 500, 'Please include authentication token & device id with each request.');
        } elseif ($token == '1') {	
		$today = date('Y-m-d');
        $data['today_purchase'] = $this->db->query("SELECT IFNULL(SUM(a.fld_quantity), 0) as qty, IFNULL(SUM(a.fld_total_amount), 0) as amount FROM tbl_purchase_detail as a, tbl_purchase as b WHERE b.fld_id = a.fld_purchase_id && a.fld_product_id='1' && b.fld_purchase_date = '$today';")->row_array();
        $data['today_sale'] = $this->db->query("SELECT IFNULL(SUM(a.fld_weight/1000), 0) as qty, IFNULL(SUM(a.fld_total_amount), 0) as amount FROM tbl_sale_detail as a, tbl_sale as b WHERE b.fld_id = a.fld_sale_id && a.fld_product_id='1' && DATE(b.fld_sale_date) = '$today'")->row_array();
        
        $data['bank_opening'] = $this->db->query("SELECT IFNULL(SUM(b.debit), 0)-IFNULL(SUM(b.credit), 0) as balance from tbl_transections_details as b, tbl_transections_master as a where b.coa_id LIKE '101014%' AND a.date < '$today' AND a.id = b.v_id")->row()->balance;
        $data['bank_debit'] = $this->db->query("SELECT IFNULL(SUM(b.debit), 0) as balance from tbl_transections_details as b, tbl_transections_master as a where b.coa_id LIKE '101014%' AND a.date = '$today' AND a.id = b.v_id")->row()->balance;
        $data['bank_credit'] = $this->db->query("SELECT IFNULL(SUM(b.credit), 0) as balance from tbl_transections_details as b, tbl_transections_master as a where b.coa_id LIKE '101014%' AND a.date = '$today' AND a.id = b.v_id")->row()->balance;
        
        $data['bank_closing'] = $data['bank_opening']+$data['bank_debit']+$data['bank_credit'];
        
        
        $data['cash_opening'] = $this->db->query("SELECT IFNULL(SUM(b.debit), 0)-IFNULL(SUM(b.credit), 0) as balance from tbl_transections_details as b, tbl_transections_master as a where b.coa_id LIKE '101001%' AND a.date < '$today' AND a.id = b.v_id")->row()->balance;
        $data['cash_debit'] = $this->db->query("SELECT IFNULL(SUM(b.debit), 0) as balance from tbl_transections_details as b, tbl_transections_master as a where b.coa_id LIKE '101001%' AND a.date = '$today' AND a.id = b.v_id")->row()->balance;
        $data['cash_credit'] = $this->db->query("SELECT IFNULL(SUM(b.credit), 0) as balance from tbl_transections_details as b, tbl_transections_master as a where b.coa_id LIKE '101001%' AND a.date = '$today' AND a.id = b.v_id")->row()->balance;
        
        $data['cash_closing'] = $data['cash_opening']+$data['cash_debit']+$data['cash_credit'];
        
        $customer_balance = $this->db->query("SELECT IFNULL(SUM(b.debit), 0)-IFNULL(SUM(b.credit), 0) as balance from tbl_transections_details as b, tbl_transections_master as a where b.coa_id LIKE '101007%' AND a.date <= '$today' AND a.id = b.v_id")->row()->balance;
        
        if($customer_balance > 0){
            $data['ac_receivedable'] = $customer_balance;
        }else{
            $data['ac_receivedable'] = 0;
        }
        
        $data['expenses'] = $this->db->query("SELECT IFNULL(SUM(b.debit), 0) as balance from tbl_transections_details as b, tbl_transections_master as a where b.coa_id LIKE '301009%' AND a.date = '$today' AND a.id = b.v_id")->row()->balance;
        
        $locations = $this->Base_model->getAll('tbl_locations', '', "fld_id <> 8", '');
		$total_stocks_all = 0;
		$total_stock_amount = 0;
		foreach($locations as $loc){
		      $shipments=$this->Navigations_model->getShipments($loc['fld_id'], 1, 0);
		      $total_amount = 0;
		      $tqty = 0;
		      foreach($shipments as $spmnt){
		          $fright = 0;
            		if($spmnt['fld_nav_id'] != 0){
            		    $fright = $this->db->query("SELECT * FROM `tbl_navigations` WHERE fld_id = '{$spmnt['fld_nav_id']}'")->row()->fld_freight_MT;
            		}
            		$price = 0;
            		
                    if($spmnt['fld_purchase_id'] != 0){
        		        $purchasePrice = $this->db->query("SELECT a.fld_unit_price, b.fld_grand_total_amount FROM tbl_purchase_detail a, tbl_purchase b WHERE b.fld_id = a.fld_purchase_id && a.fld_product_id = '1' && b.fld_id = '{$spmnt['fld_purchase_id']}'")->row_array();
            		    $price = $purchasePrice['fld_unit_price'];
            		    $total_amount += ($purchasePrice['fld_grand_total_amount']+$fright);
            		    
        		    }
		           $totalSale = 0;
    			    $totalsale = $this->db->query("SELECT sc.fld_subcategory, sc.weight, b.fld_quantity as fld_quantity FROM tbl_sale as a, tbl_sale_detail as b, tbl_subcategory as sc WHERE b.fld_stock_location_id = '{$spmnt['fld_id']}' AND b.fld_sale_id = a.fld_id AND sc.fld_subcid = b.fld_subproduct_id")->result_array();
    			    foreach($totalsale as $tsale){
                        $totalSale += $tsale['weight']*$tsale['fld_quantity'];
                    }
                    $totalSale = round($totalSale/1000, 3);
		          $tqty += $spmnt['fld_stock_qty']-$totalSale;
		      }
              $total_stocks_all += $tqty;
              $total_stock_amount += $total_amount;
              
		}
        $data['total_stocks_all'] = round($total_stocks_all,2);
        $data['total_stocks_amount'] = round($total_stock_amount,2);
        
		$this->send_response(200,'success',332,'Statistics View',$data);
        } 
    }
    
    public function getStockDetail() {
        $device_id=$this->input->post('device_id');
	    $access_token=$this->input->post('access_token');
	    $token = $this->authenticate_token($device_id, $access_token);

        if ($token == '0') {
            $this->send_response(500, 'error', 310, 'Authentication token expired.');
        } elseif ($token == '2') {
            $this->send_response(500, 'error', 320, 'Invalid token / device id.');
        } elseif ($token == 'no token') {
            $this->send_response(500, 'error', 500, 'Please include authentication token & device id with each request.');
        } elseif ($token == '1') {
        $locations = $this->Base_model->getAll('tbl_locations', '', "fld_id <> 8", '');
        $dataStock = array();
        foreach($locations as $loc){
                $shipments = $this->Navigations_model->getShipments($loc['fld_id'], 1, 0);
                
                $prices = array();
                $total_amount = 0;
                $tq = 0;
                foreach($shipments as $ship){
                    $fright = 0;
            		if($ship['fld_nav_id'] != 0){
            		    $fright = $this->db->query("SELECT * FROM `tbl_navigations` WHERE fld_id = '{$ship['fld_nav_id']}'")->row()->fld_freight_MT;
            		}
            		$price = 0;
            		
                    if($ship['fld_purchase_id'] != 0){
        		        $purchasePrice = $this->db->query("SELECT a.fld_unit_price, b.fld_grand_total_amount FROM tbl_purchase_detail a, tbl_purchase b WHERE b.fld_id = a.fld_purchase_id && a.fld_product_id = '1' && b.fld_id = '{$ship['fld_purchase_id']}'")->row_array();
            		    $price = $purchasePrice['fld_unit_price'];
            		    $total_amount += ($purchasePrice['fld_grand_total_amount']+$fright);
            		    
        		    }
        		    if($price > 0){
        		        array_push($prices, $price);
        		    }
        		    
                }
                
                // print_r($prices);
                $date = date('Y-m-d');
                $todaypurchase1= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_purchase as a, tbl_purchase_detail as b WHERE DATE(a.fld_purchase_date) = '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_purchase_id = a.fld_id AND b.fld_product_id = '1'")->row()->fld_quantity+0; 
                $pastpurchase1= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_purchase as a, tbl_purchase_detail as b WHERE DATE(a.fld_purchase_date) < '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_purchase_id = a.fld_id AND b.fld_product_id = '1'")->row()->fld_quantity+0;
                $todaysale1= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) = '$date' AND a.fld_location_from = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '1'")->row()->fld_quantity+0;
                $pastsale1= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) < '$date' AND a.fld_location_from = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '1'")->row()->fld_quantity+0;
              
                $tsale = 0;
                $psale = 0;
                $todaypurchase2= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) = '$date' AND a.fld_location_to = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '1'")->row()->fld_quantity+0; 
                $pastpurchase2= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) < '$date' AND a.fld_location_to = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '1'")->row()->fld_quantity+0;
                $todaysale2= $this->db->query("SELECT sc.fld_subcategory, sc.weight, b.fld_quantity as fld_quantity FROM tbl_sale as a, tbl_sale_detail as b, tbl_subcategory as sc WHERE DATE(a.fld_sale_date) = '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_sale_id = a.fld_id AND sc.fld_subcid = b.fld_subproduct_id AND b.fld_product_id = '1'")->result_array();
                $pastsale2= $this->db->query("SELECT sc.fld_subcategory, sc.weight, b.fld_quantity as fld_quantity FROM tbl_sale as a, tbl_sale_detail as b, tbl_subcategory as sc WHERE DATE(a.fld_sale_date) < '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_sale_id = a.fld_id AND sc.fld_subcid = b.fld_subproduct_id AND b.fld_product_id = '1'")->result_array();
                
                $todaypurchase3= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_gain_loss as a, tbl_gainloss_details as b WHERE DATE(a.fld_date) = '$date' AND b.fld_location_id = '{$loc['fld_id']}' AND b.fld_gl_id = a.fld_id AND b.fld_product_id = '1' and b.fld_type=1")->row()->fld_quantity+0; 
                $pastpurchase3= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_gain_loss as a, tbl_gainloss_details as b WHERE DATE(a.fld_date) < '$date' AND b.fld_location_id = '{$loc['fld_id']}' AND b.fld_gl_id = a.fld_id AND b.fld_product_id = '1' and b.fld_type=1")->row()->fld_quantity+0;
                
                foreach($todaysale2 as $tdsale){
                    $tsale += $tdsale['weight']*$tdsale['fld_quantity'];
                }
                foreach($pastsale2 as $ptsale){
                    $psale += $ptsale['weight']*$ptsale['fld_quantity'];
                }
                $todaysale2 = $tsale;
                $pastsale2 = $psale;
                
                $gl_diff = $this->db->query("SELECT IFNULL(SUM(fld_quantity), 0) as qty FROM tbl_gainloss_details WHERE fld_type = 3 && fld_location_id = '{$loc['fld_id']}'")->row_array();
                $totalDiff = round($gl_diff['qty']/1000, 3); 
                $totalDiff = $gl_diff['qty']; 
                $pastpurchase = $pastpurchase1+$pastpurchase2+($pastpurchase3/1000);
                $todaypurchase = $todaypurchase1+$todaypurchase2+($todaypurchase3/1000);  
              
                $pastpurchasekg = $pastpurchase * 1000;
                $todaypurchasekg = $todaypurchase * 1000;
                $todaysale = ($todaysale1*1000)+$todaysale2;
                $pastsale = ($pastsale1*1000)+$pastsale2;
              
                $tq += $todaysale+$pastsale;
                $openingstock = $pastpurchasekg - $pastsale;
                $closingstock = ($openingstock + $todaypurchasekg - $todaysale)+$totalDiff;
                
                // $total_purchase_amount += $total_amount;
                // $total_qty += round($closingstock/1000, 3); 
                
                $stocks = array();
                
                $stocks['location'] = $loc['fld_location'];
                $stocks['openingstock'] = $openingstock;
                $stocks['todaypurchase'] = $todaypurchase;
                $stocks['todaysale'] = $todaysale;
                $stocks['closingstock'] = round($closingstock/1000, 3);
                if(count($prices)>0){ 
			        $stocks['price'] = round(array_sum($prices)/count($prices), 2);
			    }else{ 
			        $stocks['price'] = 0; 
			    }
			    
			    $stocks['total_amount'] = $total_amount;
                $dataStock[] = $stocks;
                
            }
            $this->send_response(200,'success',332,'Stocks Details',$dataStock);
        }
    }
    
    public function uploadUserPic(){
		
		$user_id=$this->input->post('user_id');
		 if($_FILES['file']['size'] > 0){
				$responce=$this->upload_user_pic();
				if($responce['upload'] == 1){
					$this->db->where('fld_id',$user_id);
					$this->db->update('tbl_users',array("fld_user_pic" => $responce['filename']));
					$user_role=$_POST['user_role'];
    				$user_role_name=$_POST['role_name'];
    				$user_id=$_POST['user_id'];
    				$date=date('Y-m-d');
    				$date=date('Y-m-d H:i:s');
    				$client_ip= $this->input->post('client_ip');
    				$address=$this->Base_model->getLocation($client_ip);
                    $device_name= $this->input->post('device_name');
                    $device = $device_name;
    				$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'Upload Profile Pic' ,fld_detail='',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
    				$this->send_response(500,'success',500, 'Profile picture upload successfully.');
				}else{
					$this->send_response(500,'error',500, $responce['error']);
				}
				
		 }else{
			 $this->send_response(500,'error',500, 'Profile picture not selected.');
		 }
		
	}
	public function upload_user_pic() {

        $config['upload_path'] = 'assets/uploads/user_dp/';
        $config['allowed_types'] = '*';

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('file')) {
            $img = $this->upload->data();
            $file_name = $img['file_name'];
            $responce = array(
                'upload' => true,
                'filename' => $file_name,
                'error' => '',
            );
            return $responce;
        } else {
            $responce = array(
                'upload' => false,
                'error' => $this->upload->display_errors(),
            );
            return $responce;
        }
    }
    
    /************************ Prime21 work *************************************/
    public function cashpay_accountsList(){
         $device_id=$this->input->post('device_id');
	    $access_token=$this->input->post('access_token');
	    $token = $this->authenticate_token($device_id, $access_token);

        if ($token == '0') {
            $this->send_response(500, 'error', 310, 'Authentication token expired.');
        } elseif ($token == '2') {
            $this->send_response(500, 'error', 320, 'Invalid token / device id.');
        } elseif ($token == 'no token') {
            $this->send_response(500, 'error', 500, 'Please include authentication token & device id with each request.');
        } elseif ($token == '1') {
	    $data['from_accounts'] = $this->db->select('*')->from('tbl_coa')->where('head_code!=', '101001')->like('head_code', '101001', 'both')->get()->result_array();
		$data['to_accounts'] = $this->db->select('*')->from('tbl_coa')->where('head_level', '3')->not_like('head_code', '101001', 'both')->get()->result_array();
		$getMaxVoucherID=$this->Apis_model->getMaxVoucherID();
		$data['maxid']= $getMaxVoucherID['Auto_increment'];
		 $this->send_response(200,'success',332,'Accounts List', $data);
        }
	}
	public function chequepay_accountsList(){
	     $device_id=$this->input->post('device_id');
	    $access_token=$this->input->post('access_token');
	    $token = $this->authenticate_token($device_id, $access_token);

        if ($token == '0') {
            $this->send_response(500, 'error', 310, 'Authentication token expired.');
        } elseif ($token == '2') {
            $this->send_response(500, 'error', 320, 'Invalid token / device id.');
        } elseif ($token == 'no token') {
            $this->send_response(500, 'error', 500, 'Please include authentication token & device id with each request.');
        } elseif ($token == '1') {
	    $data['from_accounts'] = $this->db->select('*')->from('tbl_coa')->where('head_code!=', '101014')->like('head_code', '101014', 'both')->get()->result_array();
		$data['to_accounts'] = $this->db->select('*')->from('tbl_coa')->where('head_level', '3')->not_like('head_code', '101014', 'both')->get()->result_array();
		$getMaxVoucherID=$this->Apis_model->getMaxVoucherID();
		$data['maxid']= $getMaxVoucherID['Auto_increment'];
		 $this->send_response(200,'success',332,'Accounts List', $data);
		 
		 $data['accounts'] = $this->db->select('*')->from('tbl_coa')->where('head_level', '3')->get()->result_array();
        }
	}
	public function jv_accountsList(){
	     $device_id=$this->input->post('device_id');
	    $access_token=$this->input->post('access_token');
	    $token = $this->authenticate_token($device_id, $access_token);

        if ($token == '0') {
            $this->send_response(500, 'error', 310, 'Authentication token expired.');
        } elseif ($token == '2') {
            $this->send_response(500, 'error', 320, 'Invalid token / device id.');
        } elseif ($token == 'no token') {
            $this->send_response(500, 'error', 500, 'Please include authentication token & device id with each request.');
        } elseif ($token == '1') {
		 $data['to_accounts'] = $this->db->select('*')->from('tbl_coa')->where('head_level', '3')->get()->result_array();
		$getMaxVoucherID=$this->Apis_model->getMaxVoucherID();
		$data['maxid']= $getMaxVoucherID['Auto_increment'];
		 $this->send_response(200,'success',332,'Accounts List', $data);
        }
		 
		
	}
	
	public function cashpayementvoucher()
    {
        $json = file_get_contents('php://input');
        $json = json_decode($json, true);
      
        $type=$json['type'];
        
        if (isset($json['add_vourcher'])) {
        
        
            $from_account=$json['from_account'];
            $balance=$this->getBalance($json['from_account']);
            $total_amount=$json['total_amount'];
          
            if((float)$total_amount < (float)$balance){
                
            
            $data = array(
                    'type'          => $json['fld_type'],
                    'date'          => date('Y-m-d', strtotime(str_replace('/', '-', $json['date']))),
                    'user_id'       => $json['user_id'],
                    'created_date'  => date('Y-m-d H:i:s')
                );
                
                $this->db->insert('tbl_transections_master', $data);
    		    $v_id = $this->db->insert_id();
    		    $account_id = $json['account_id'];
    		    $coa_id     = $json['coa_id'];
        		$narration = $json['narration'];
        		$amount = $json['amount'];
        		$fromNarration = 'Dr Acc. ';
        		$coa_fname = $this->db->select('head_name')->from('tbl_coa')->where('head_code', $json['from_account'])->get()->row()->head_name;
        		for ($i = 0, $n = count($coa_id); $i < $n; $i++) {
        		  $coa_name = $this->db->select('head_name')->from('tbl_coa')->where('head_code', $json['coa_id'][$i])->get()->row()->head_name;
        		  $fromNarration .= $coa_name.', ';
        		  $data1=array(
        		      'v_id'        => $v_id,
        		      'coa_id'      => $json['coa_id'][$i],
        		      'narration'   => 'Cr Acc. '.$coa_fname.' ('.$json['narration'][$i].')',
        		      'debit'       => $json['amount'][$i]
        		  );
        		  $this->db->insert('tbl_transections_details', $data1);
                
        		}
        		$fromNarration = rtrim($fromNarration, ', ');
        		
        		$fromData = array(
        		    'v_id'        => $v_id,
        		    'coa_id'      => $json['from_account'],
        		    'narration'   => $fromNarration.' ('.$json['from_narration'].')',
        		    'credit'      => $json['total_amount']
        		);
        		$this->db->insert('tbl_transections_details', $fromData);
                
                $this->send_response(200,'success',332,'Cash Payment added successfully');
           
            }else{
                $this->send_response(500,'error',500, 'Balance is less then total amount.');
            }
        }
        if (isset($json['edit_vourcher'])) {
            $v_id = $json['editId'];
             
            $data = array(
                'type'          => $json['fld_type'],
                'date'          => date('Y-m-d', strtotime(str_replace('/', '-', $json['date']))),
                'user_id'       => $json['user_id'],
                'created_date'  => date('Y-m-d H:i:s')
            );
            
            
            
            $this->db->where('id', $v_id);
            $this->db->update('tbl_transections_master', $data);
            
            $this->db->delete('tbl_transections_details', array('v_id' => $v_id));
            
		    $account_id = $json['account_id'];
		    $coa_id     = $json['coa_id'];
    		$narration = $json['narration'];
    		$amount = $json['amount'];
    		$fromNarration = 'Dr Acc. ';
    		$coa_fname = $this->db->select('head_name')->from('tbl_coa')->where('head_code', $json['from_account'])->get()->row()->head_name;
    		for ($i = 0, $n = count($coa_id); $i < $n; $i++) {
        		  $coa_name = $this->db->select('head_name')->from('tbl_coa')->where('head_code', $json['coa_id'][$i])->get()->row()->head_name;
        		  $fromNarration .= $coa_name.', ';
        		  $data1=array(
        		      'v_id'        => $v_id,
        		      'coa_id'      => $json['coa_id'][$i],
        		      'narration'   => 'Cr Acc. '.$coa_fname.' ('.$json['narration'][$i].')',
        		      'debit'       => $json['amount'][$i]
        		  );
        		  $this->db->insert('tbl_transections_details', $data1);
                
        		}
    		$fromNarration = rtrim($fromNarration, ', ');
    		
			$fromData = array(
    		    'v_id'        => $v_id,
    		    'coa_id'      => $json['from_account'],
    		    'narration'   => $fromNarration.' ('.$json['from_narration'].')',
    		    'credit'      => $json['total_amount']
    		);
    		$this->db->insert('tbl_transections_details', $fromData);
    		$this->send_response(200,'success',332,'Cash Payment updated successfully');

        }
        $getMaxVoucherID=$this->Apis_model->getMaxVoucherID();
		
        if($type == 'edit'){
            
            $id=$json['voucher_id'];
            $voucher = $this->db->select('*')->from('tbl_transections_master')->where(array('id'=>$id, 'type'=>'CPV'))->get();
            
            if($voucher->num_rows() < 1){
                $this->send_response(500,'error',500, 'Cash payment voucher not found.');
            }
            $data['edit'] = $id; 
            $data['maxid'] = $id;
            $data['editData'] = $voucher->row_array();
            $data['editDataV'] = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id, 'credit>'=>0))->get()->row_array();
            $data['editDataDetails']  = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id, 'debit>'=>0))->get()->result_array();
            $this->send_response(200,'success',332,'Cash payment voucher detail',$data);
            
        }
         if($type == 'duplicate'){
             $id=$json['voucher_id'];
            $voucher = $this->db->select('*')->from('tbl_transections_master')->where(array('id'=>$id, 'type'=>'CPV'))->get();
            
            if($voucher->num_rows() < 1){
                 $this->send_response(500,'error',500, 'Cash payment voucher not found.');
            }
            $data['edit'] = "";
            $data['duplicate'] = "";
            $data['maxid'] = $getMaxVoucherID['Auto_increment'];
            $data['editData'] = $voucher->row_array();
            $data['editDataV'] = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id, 'credit>'=>0))->get()->row_array();
            $data['editDataDetails']  = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id, 'debit>'=>0))->get()->result_array();
            $this->send_response(200,'success',332,'Duplicate cash payment voucher detail',$data);
            
        }
    }
    public function cashreceivevoucher()
    {
            $json = file_get_contents('php://input');
            $json = json_decode($json, true);
          
            if (isset($json['add_vourcher'])) {
           
            $data = array(
                'type'          => $json['fld_type'],
                'date'          => date('Y-m-d', strtotime(str_replace('/', '-',$json['date']))),
                'user_id'       => $json['user_id'],
                'created_date'  => date('Y-m-d H:i:s')
            );
            
            $this->db->insert('tbl_transections_master', $data);
		    $v_id = $this->db->insert_id();
		    $account_id =$json['account_id'];
		    $coa_id     = $json['coa_id'];
    		$narration = $json['narration'];
    		$amount = $json['amount'];
    		
    		$fromNarration = 'Cr Acc. ';
    		$coa_fname = $this->db->select('head_name')->from('tbl_coa')->where('head_code', $json['from_account'])->get()->row()->head_name;
    		for ($i = 0, $n = count($coa_id); $i < $n; $i++) {
    		  $coa_name = $this->db->select('head_name')->from('tbl_coa')->where('head_code', $json['coa_id'][$i])->get()->row()->head_name;
    		  $fromNarration .= $coa_name.', ';
    		  $data1=array(
    		      'v_id'        => $v_id,
    		      'coa_id'      => $json['coa_id'][$i],
    		      'narration'   => 'Dr Acc. '.$coa_fname.' ('.$narration[$i].')',
    		      'credit'       => $amount[$i]
    		  );
    		  $this->db->insert('tbl_transections_details', $data1);
            
    		}
    		$fromNarration = rtrim($fromNarration, ', ');
    		
    		$fromData = array(
    		    'v_id'        => $v_id,
    		    'coa_id'      => $json['from_account'],
    		    'narration'   => $fromNarration.' ('.$json['from_narration'].')',
    		    'debit'      => $json['total_amount']
    		);
    		
    		$this->db->insert('tbl_transections_details', $fromData);
            
            $this->send_response(200,'success',332,'Cash Receive added successfully');
            
        }
        
    }
    public function chequepayementvoucher(){
        
            
            $json = file_get_contents('php://input');
            $json = json_decode($json, true);
          
            $type=$json['type'];
            if (isset($json['add_vourcher'])) {
                
                $from_account=$json['from_account'];
                $balance=$this->getBalance($json['from_account']);
                $total_amount=$json['total_amount'];
              
                if((float)$total_amount < (float)$balance){
                    
                $data = array(
                    'type'          => $json['fld_type'],
                    'date'          => date('Y-m-d', strtotime(str_replace('/', '-', $json['date']))),
                    'user_id'       => $json['user_id'],
                    'created_date'  => date('Y-m-d H:i:s')
                );
                
                $this->db->insert('tbl_transections_master', $data);
    		    $v_id = $this->db->insert_id();
    		    $account_id = $json['account_id'];
    		    $coa_id     = $json['coa_id'];
        		$narration = $json['narration'];
        		$amount = $json['amount'];
        		$fromNarration = 'Dr Acc. ';
        		$coa_fname = $this->db->select('head_name')->from('tbl_coa')->where('head_code', $json['from_account'])->get()->row()->head_name;
        		for ($i = 0, $n = count($coa_id); $i < $n; $i++) {
        		  $coa_name = $this->db->select('head_name')->from('tbl_coa')->where('head_code', $json['coa_id'][$i])->get()->row()->head_name;
        		  $fromNarration .= $coa_name.', ';
        		  $data1=array(
        		      'v_id'        => $v_id,
        		      'coa_id'      => $json['coa_id'][$i],
        		      'narration'   => 'Cr Acc. '.$coa_fname.' ('.$json['narration'][$i].')',
        		      'debit'       => $json['amount'][$i]
        		  );
        		  $this->db->insert('tbl_transections_details', $data1);
                
        		}
        		$fromNarration = rtrim($fromNarration, ', ');
        		
        		$fromData = array(
        		    'v_id'        => $v_id,
        		    'coa_id'      => $json['from_account'],
        		    'narration'   => $fromNarration.' ('.$json['from_narration'].')',
        		    'credit'      => $json['total_amount']
        		);
                    
            		$this->db->insert('tbl_transections_details', $fromData);
                    
                    $this->send_response(200,'success',332,'Cheque Payment added successfully');
              
            }else{
                $this->send_response(500,'error',500, 'Balance is less then total amount.');
            }
        }
        if (isset($json['edit_vourcher'])) {
            $v_id = $json['editId'];
             
            $data = array(
                'type'          => $json['fld_type'],
                'date'          => date('Y-m-d', strtotime(str_replace('/', '-', $json['date']))),
                'user_id'       => $json['user_id'],
                'created_date'  => date('Y-m-d H:i:s')
            );
            
            
            
            $this->db->where('id', $v_id);
            $this->db->update('tbl_transections_master', $data);
            
            $this->db->delete('tbl_transections_details', array('v_id' => $v_id));
            
		    $account_id = $json['account_id'];
		    $coa_id     = $json['coa_id'];
    		$narration = $json['narration'];
    		$amount = $json['amount'];
    		
    		$fromNarration = 'Dr Acc. ';
    		$coa_fname = $this->db->select('head_name')->from('tbl_coa')->where('head_code', $json['from_account'])->get()->row()->head_name;
    		for ($i = 0, $n = count($coa_id); $i < $n; $i++) {
        		  $coa_name = $this->db->select('head_name')->from('tbl_coa')->where('head_code', $json['coa_id'][$i])->get()->row()->head_name;
        		  $fromNarration .= $coa_name.', ';
        		  $data1=array(
        		      'v_id'        => $v_id,
        		      'coa_id'      => $json['coa_id'][$i],
        		      'narration'   => 'Cr Acc. '.$coa_fname.' ('.$json['narration'][$i].')',
        		      'debit'       => $json['amount'][$i]
        		  );
        		  $this->db->insert('tbl_transections_details', $data1);
                
        	}
    		
    	    $fromNarration = rtrim($fromNarration, ', ');
    		
    		$fromData = array(
    		    'v_id'        => $v_id,
    		    'coa_id'      => $json['from_account'],
    		    'narration'   => $fromNarration.' ('.$json['from_narration'].')',
    		    'credit'      => $json['total_amount']
    		);
    		$this->db->insert('tbl_transections_details', $fromData);
    		$this->send_response(200,'success',332,'Cheque Payment updated successfully');
           
        }
        
        $getMaxVoucherID=$this->Apis_model->getMaxVoucherID();
        if($type == 'edit'){
            $id=$json['voucher_id'];
            $voucher = $this->db->select('*')->from('tbl_transections_master')->where(array('id'=>$id, 'type'=>'CHPV'))->get();
            
            if($voucher->num_rows() < 1){
                 $this->send_response(500,'error',500, 'Cheque payment voucher not found.');
            }
            $data['edit'] = $id; 
            $data['maxid'] = $id;
            $data['editData'] = $voucher->row_array();
            $data['editDataV'] = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id, 'credit>'=>0))->get()->row_array();
            $data['editDataDetails']  = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id, 'debit>'=>0))->get()->result_array();
            $this->send_response(200,'success',332,'Cheque payment voucher detail',$data);
            
        }
	    if($type == 'duplicate'){
	        $id=$json['voucher_id'];
            $voucher = $this->db->select('*')->from('tbl_transections_master')->where(array('id'=>$id, 'type'=>'CHPV'))->get();
            
            if($voucher->num_rows() < 1){
                $this->send_response(500,'error',500, 'Cheque payment voucher not found.');
            }
            $data['edit'] = "";
            $data['duplicate'] = "";
            $data['maxid'] = $getMaxVoucherID['Auto_increment'];
            $data['editData'] = $voucher->row_array();
            $data['editDataV'] = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id, 'credit>'=>0))->get()->row_array();
            $data['editDataDetails']  = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id, 'debit>'=>0))->get()->result_array();
            $this->send_response(200,'success',332,'Duplicate Cheque payment voucher detail',$data);
            
        }
    }
    
    public function chequereceivevoucher()
    {
        
        $json = file_get_contents('php://input');
        $json = json_decode($json, true);
         if (isset($json['add_vourcher'])) {
           
            $data = array(
                'type'          => $json['fld_type'],
                'date'          => date('Y-m-d', strtotime(str_replace('/', '-', $json['date']))),
                'user_id'       => $json['user_id'],
                'created_date'  => date('Y-m-d H:i:s')
            );
            
            $this->db->insert('tbl_transections_master', $data);
		    $v_id = $this->db->insert_id();
		    $account_id = $json['account_id'];
		    $coa_id     = $json['coa_id'];
    		$narration = $json['narration'];
    		$amount = $json['amount'];
    		
    		$fromNarration = 'Cr Acc. ';
    		$coa_fname = $this->db->select('head_name')->from('tbl_coa')->where('head_code', $json['from_account'])->get()->row()->head_name;
        	for ($i = 0, $n = count($coa_id); $i < $n; $i++) {
        	$coa_name = $this->db->select('head_name')->from('tbl_coa')->where('head_code', $json['coa_id'][$i])->get()->row()->head_name;
    		  $fromNarration .= $coa_name.', ';
    		  $data1=array(
    		      'v_id'        => $v_id,
    		      'coa_id'      =>$json['coa_id'][$i],
    		      'narration'   => 'Dr Acc. '.$coa_fname.' ('.$narration[$i].')',
    		      'credit'       => $amount[$i]
    		  );
    		  $this->db->insert('tbl_transections_details', $data1);
            
    		}
    		$fromNarration = rtrim($fromNarration, ', ');
    		
    		$fromData = array(
    		    'v_id'        => $v_id,
    		    'coa_id'      => $json['from_account'],
    		    'narration'   => $fromNarration.' ('.$json['from_narration'].')',
    		    'debit'      => $json['total_amount']
    		);
    		
    		$this->db->insert('tbl_transections_details', $fromData);
            
            $this->send_response(200,'success',332,'Cheque Receive added successfully');
            
        }
        
    }
    public function getBalance($from_account){
       
        $debit = $this->db->query("SELECT IFNULL(SUM(td.debit), 0) as debit FROM tbl_transections_details as td, tbl_transections_master as tm WHERE coa_id = '$from_account' && tm.id = td.v_id && tm.post_status = 0")->row()->debit;
        $credit = $this->db->query("SELECT IFNULL(SUM(td.credit), 0) as credit FROM tbl_transections_details as td, tbl_transections_master as tm WHERE coa_id = '$from_account' && tm.id = td.v_id && tm.post_status = 0")->row()->credit;
        $balance = $debit-$credit;
        return  $balance;
    }
    public function getaccountBalance(){
        $id=$this->input->post('id');
       
        $debit = $this->db->query("SELECT IFNULL(SUM(td.debit), 0) as debit FROM tbl_transections_details as td, tbl_transections_master as tm WHERE coa_id = '$id' && tm.id = td.v_id && tm.post_status = 0")->row()->debit;
        $credit = $this->db->query("SELECT IFNULL(SUM(td.credit), 0) as credit FROM tbl_transections_details as td, tbl_transections_master as tm WHERE coa_id = '$id' && tm.id = td.v_id && tm.post_status = 0")->row()->credit;
         $data['balance'] = $debit-$credit;
        $this->send_response(200,'success',332,'Account balance',$data);
    }
    public function getPBalance(){
        $id=$this->input->post('id');
       
        $debit = $this->db->query("SELECT IFNULL(SUM(td.debit), 0) as debit FROM tbl_transections_details as td, tbl_transections_master as tm WHERE coa_id = '$id' && tm.id = td.v_id && tm.post_status = 0")->row()->debit;
        $credit = $this->db->query("SELECT IFNULL(SUM(td.credit), 0) as credit FROM tbl_transections_details as td, tbl_transections_master as tm WHERE coa_id = '$id' && tm.id = td.v_id && tm.post_status = 0")->row()->credit;
        $data['pbalance'] = $debit-$credit;
        $this->send_response(200,'success',332,'Previous balance',$data);
    }
    public function journalvoucher()  
    {
         $device_id=$this->input->post('device_id');
	    $access_token=$this->input->post('access_token');
	    $token = $this->authenticate_token($device_id, $access_token);

        if ($token == '0') {
            $this->send_response(500, 'error', 310, 'Authentication token expired.');
        } elseif ($token == '2') {
            $this->send_response(500, 'error', 320, 'Invalid token / device id.');
        } elseif ($token == 'no token') {
            $this->send_response(500, 'error', 500, 'Please include authentication token & device id with each request.');
        } elseif ($token == '1') {
         if (isset($_POST['add_vourcher'])) {
            $data = array(
                'type'          => $this->input->post('fld_type'),
                'date'          => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('date',TRUE)))),
                'user_id'       => $this->input->post('user_id'),
                'created_date'  => date('Y-m-d H:i:s')
            );
            
            $this->db->insert('tbl_transections_master', $data);
            
		    $v_id = $this->db->insert_id();
		    $account_id = $this->input->post('account_id',TRUE);
		    $coa_id     =  $this->input->post('coa_id',TRUE);
    		$narration = $this->input->post('narration',TRUE);
    		$debit = $this->input->post('debit',TRUE);
    		$credit = $this->input->post('credit',TRUE);
    		
    		for ($i = 0, $n = count($coa_id); $i < $n; $i++) {
    		  $data1=array(
    		      'v_id'        => $v_id,
    		      'coa_id'      => $coa_id[$i],
    		      'narration'   => $narration[$i],
    		      'debit'       => $debit[$i],
    		      'credit'      => $credit[$i]
    		  );
    		  if($debit[$i] > 0 || $credit[$i]>0){
    		       $this->db->insert('tbl_transections_details', $data1);
    		  }
    		 
            
    		}
    		
            $this->send_response(200,'success',332,'Journal voucher added successfully');
        }
        }
    }
    public function manage_voucher()
    {
         $device_id=$this->input->post('device_id');
	    $access_token=$this->input->post('access_token');
	    $token = $this->authenticate_token($device_id, $access_token);

        if ($token == '0') {
            $this->send_response(500, 'error', 310, 'Authentication token expired.');
        } elseif ($token == '2') {
            $this->send_response(500, 'error', 320, 'Invalid token / device id.');
        } elseif ($token == 'no token') {
            $this->send_response(500, 'error', 500, 'Please include authentication token & device id with each request.');
        } elseif ($token == '1') {
       $limit= $this->input->post('limit');
       $offset= $this->input->post('offset');
	    $query = "SELECT * FROM tbl_transections_master ORDER by id desc LIMIT ".$offset.",".$limit."";
	    
	    if(isset($_POST['filter_type'])){
	        $query = "SELECT * FROM tbl_transections_master WHERE id > 0";
	        if($_POST['voucher_type'] != 'all'){
	            $query .= " && type = '{$_POST['voucher_type']}'";
	        }
	        if(!empty($_POST['voucher_code'])){
	            $code = (int) abs(filter_var($_POST['voucher_code'], FILTER_SANITIZE_NUMBER_INT));
	            $query .= " && id = '$code'";
	        }
	        
	        $query .= " ORDER by id desc";
	       
	    }
	    
	    $vouchers=$this->db->query($query)->result_array();
	    if($vouchers){
	      foreach($vouchers as $key => $voucher){
	          $type="";
	          $amount=0;
	           if($voucher['type']=='JV'){
			        $type = 'Journal Voucher'; 
			    }else if($voucher['type']=='CPV'){
			        $type = 'Cash Payment Voucher'; 
			    }else if($voucher['type']=='CHPV'){
			        $type = 'Cheque Payment Voucher'; 
			    }else if($voucher['type']=='CRV'){
			        $type = 'Cash Receive Voucher'; 
			    }else if($voucher['type']=='CHRV'){
			        $type = 'Cheque Receive Voucher'; 
			    }else{
			        $type = $voucher['type'];
			    }
			  $vouchers[$key]['voucher_type']=$type;
			  $editDataV = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$voucher['id'], 'debit>'=>0))->get();
			    if($editDataV->num_rows()){
                    $amount=$editDataV->row()->debit;
                }else{
                    $amount=0;
                }
                $vouchers[$key]['amount']=$amount;
	      }  
	    }
		$data['vouchers']=$vouchers;
		$this->send_response(200,'success',332,'Voucher List',$data);
        }
    }
    public function view_voucher(){
         $device_id=$this->input->post('device_id');
	    $access_token=$this->input->post('access_token');
	    $token = $this->authenticate_token($device_id, $access_token);

        if ($token == '0') {
            $this->send_response(500, 'error', 310, 'Authentication token expired.');
        } elseif ($token == '2') {
            $this->send_response(500, 'error', 320, 'Invalid token / device id.');
        } elseif ($token == 'no token') {
            $this->send_response(500, 'error', 500, 'Please include authentication token & device id with each request.');
        } elseif ($token == '1') {
          $id=$this->input->post('id');
	      $voucher = $this->db->select('*')->from('tbl_transections_master')->where(array('id'=>$id))->get();
            
            if($voucher->num_rows() < 1){
                $this->send_response(500,'error',500, 'No data found.');
            }
            $data['edit'] = $id; 
            $data['maxid'] = $id;
            $data['editData'] =$editData= $voucher->row_array();
            $totalAmount=0;
            // $data['editDataDetails']  = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id))->get()->result_array();
            if($data['editData']['type'] == 'CRV' || $data['editData']['type'] == 'CHRV'){

            $editDataV= $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id, 'debit>'=>0))->get()->row_array();
            $data['editDataDetails']  =$editDataDetails= $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id, 'credit>'=>0))->get()->result_array();
            if($editDataDetails){
               
                foreach($editDataV as $key => $detv){
                     $names=$this->db->query("select * from tbl_coa where head_code = '{$editDataV['coa_id']}'")->row()->head_name;
                     $editDataV['account_name']=$names;
                   
                }
                foreach($editDataDetails as $key => $det){
                     $name=$this->db->query("select * from tbl_coa where head_code = '{$det['coa_id']}'")->row()->head_name;
                     $editDataDetails[$key]['account_name']=$name;
                   if($editData['type'] == 'CRV' || $editData['type'] == 'CHRV'){
                            $amount=$det['credit'];
                    }else{
                            $amount=$det['debit'];
                    }
                    $totalAmount += $amount;
                    $editDataDetails[$key]['amount']=$amount;
                    $editDataDetails[$key]['p_balance']= $this->CI->getBalanceInner($det['coa_id']);
                }
                 $data['editDataDetails']  = $editDataDetails;
                 $data['editDataV'] =$editDataV;
                  $data['total_amount'] =$totalAmount;
            }
            
           
            }else{
            $editDataV= $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id, 'credit>'=>0))->get()->row_array();
            $editDataDetails=$this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id, 'debit>'=>0))->get()->result_array();
            
            if($editDataDetails){
                
                foreach($editDataV as $keys => $detv){
                     $names=$this->db->query("select * from tbl_coa where head_code = '{$editDataV['coa_id']}'")->row()->head_name;
                     $editDataV['account_name']=$names;
                     
                }
                foreach($editDataDetails as $key => $det){
                     $name=$this->db->query("select * from tbl_coa where head_code = '{$det['coa_id']}'")->row()->head_name;
                     $editDataDetails[$key]['account_name']=$name;
                    
                     if($editData['type'] == 'CRV' || $editData['type'] == 'CHRV'){
                            $amount=$det['credit'];
                    }else{
                            $amount=$det['debit'];
                    }
                    $totalAmount += $amount;
                    $editDataDetails[$key]['amount']=$amount;
                    $editDataDetails[$key]['p_balance']= $this->CI->getBalanceInner($det['coa_id']);
                   
                }
                 $data['editDataDetails']  = $editDataDetails;
                 $data['editDataV'] =$editDataV;
                 $data['total_amount'] =$totalAmount;
            }
            }
            
            $voucher = $this->db->select('*')->from('tbl_transections_master')->where(array('id'=>$id))->get();
            
            $this->send_response(200,'success',332,'View Voucher',$data);
        }
	}
	public function getBalanceInner($id, $plus_amount = 0){
        
        $debit = $this->db->query("SELECT IFNULL(SUM(td.debit), 0) as debit FROM tbl_transections_details as td, tbl_transections_master as tm WHERE coa_id = '$id' && tm.id = td.v_id && tm.post_status = 0")->row()->debit;
        $credit = $this->db->query("SELECT IFNULL(SUM(td.credit), 0) as credit FROM tbl_transections_details as td, tbl_transections_master as tm WHERE coa_id = '$id' && tm.id = td.v_id && tm.post_status = 0")->row()->credit;
        $balance = number_format(($debit-$credit+$plus_amount), 2, '.', ',');
        return $balance;
        
    }
	public function others(){
	     $device_id=$this->input->post('device_id');
	    $access_token=$this->input->post('access_token');
	    $token = $this->authenticate_token($device_id, $access_token);

        if ($token == '0') {
            $this->send_response(500, 'error', 310, 'Authentication token expired.');
        } elseif ($token == '2') {
            $this->send_response(500, 'error', 320, 'Invalid token / device id.');
        } elseif ($token == 'no token') {
            $this->send_response(500, 'error', 500, 'Please include authentication token & device id with each request.');
        } elseif ($token == '1') {
	    if(isset($_POST['addOther'])){
		    $account_id = $this->input->post("head_account");
            
            $getHeadCodeData = $this->db->select('*')->from('tbl_coa')->where('head_code',$account_id)->get()->row();
        
            $getHeadCodeForNew = $this->db->select('*,count(head_code) as hc')->from('tbl_coa')->where('parent_head_name',$getHeadCodeData->head_name)->get()->row();
            
            $nid  = $getHeadCodeForNew->hc;
            $n =$nid + 1;
            $newlevel = $getHeadCodeData->head_level+1;
            
            if($newlevel > 1){
                $n = sprintf('%03d', $n); 
            }else{
                $n = sprintf('%02d', $n);
            }
            
            $HeadCode = $account_id . $n;
            $acc_data = array(
              'head_code'       =>  $HeadCode,
              'head_name'       =>  $this->input->post("name"),
              'parent_head_name'      =>  $getHeadCodeData->head_name,
              'head_level'      =>  $newlevel,
              'contact'       =>  $this->input->post("contact"),
              'address'       =>  $this->input->post("address"),
              'fld_created_date'   =>  date("Y-m-d H:i:s"),
              'type'            => 'OTHER',
              'type_id'         => 0
            );
            
            $this->db->insert('tbl_coa',$acc_data);
            $this->send_response(200,'success',332,'New account has been added');
		}
		if(isset($_POST['manageOther'])){
		    $data['coa']=$this->db->query("SELECT * FROM tbl_coa WHERE type = 'OTHER' && deleted = 0")->result_array();
		    $this->send_response(200,'success',332,'Account List',$data);
		}
		if(isset($_POST['edit'])){
		    $editid=$this->input->post('editid');
		    $data['coa']=$this->db->query("SELECT * FROM tbl_coa WHERE head_level = 2 && head_code != '101001' && head_code != '101005' && head_code != '101006' && head_code != '101007' && head_code != '101009' && head_code != '101014' && head_code != '301009'")->result_array();
		    $data['edit_coa'] = $this->db->query("SELECT * FROM tbl_coa WHERE head_code = '$editid' && type = 'OTHER'")->row_array(); 
		    $this->send_response(200,'success',332,'Edit data',$data);
		}
		if(isset($_POST['editOther'])){
		    $editid=$this->input->post('editid');
            $acc_data = array(
              'head_name'       =>  $this->input->post("name"),
              'contact'       =>  $this->input->post("contact"),
              'address'       =>  $this->input->post("address"),
              'fld_updated_by'       =>  $this->input->post('user_id'),
			  'fld_updated_date'   =>  date("Y-m-d H:i:s"),
            ); 
           
            
            $this->db->where('head_code',$editid);
			$this->db->update('tbl_coa',$acc_data);
            $this->send_response(200,'success',332,'Party account has been updated.');
		}
		if(isset($_POST['deleteO'])){
		    $id=$this->input->post('id');
		    $responce = $this->db->update('tbl_coa', array('deleted'=>1), 'head_code ='.$id.'');
		    if($responce){
			    $this->send_response(200,'success',332,'Other Party account has been deleted.');
		    }else{

		    	$this->send_response(500,'error',320,'Party account not deleted. Something went wrong.');
	    	}
		}
        }
	}
	public function addBank()
    {
         $device_id=$this->input->post('device_id');
	    $access_token=$this->input->post('access_token');
	    $token = $this->authenticate_token($device_id, $access_token);

        if ($token == '0') {
            $this->send_response(500, 'error', 310, 'Authentication token expired.');
        } elseif ($token == '2') {
            $this->send_response(500, 'error', 320, 'Invalid token / device id.');
        } elseif ($token == 'no token') {
            $this->send_response(500, 'error', 500, 'Please include authentication token & device id with each request.');
        } elseif ($token == '1') {
        $this->form_validation->set_rules('fld_bank', 'Bank', 'required');
			$this->form_validation->set_rules('fld_address', 'Bank address', 'required');

		if ($this->form_validation->run() == FALSE) {
            $this->send_response(500,'error',320, validation_errors());
		} else {
			
			$user_id= $this->input->post('user_id');
			$data = array(
            'fld_userid' => $user_id,
            'fld_bank'=> $this->input->post('fld_bank',TRUE),
            'fld_account_title'=> $this->input->post('fld_account_title',TRUE),
            'fld_accountnumber'=> $this->input->post('fld_accountnumber',TRUE),
            'fld_address'=> $this->input->post('fld_address',TRUE),
            'fld_created_date'   =>  date("Y-m-d H:i:s"),
            'fld_status' => 1
        );
        
        $unit=$this->db->insert('tbl_banks',$data);
        if($unit){
		    $bank_id=$this->db->insert_id();
            
           
            $account_id = 101014;
            
            
            $getHeadCodeData = $this->db->select('*')->from('tbl_coa')->where('head_code',$account_id)->get()->row();
        
            $getHeadCodeForNew = $this->db->select('*,MAX(head_code) as hc')->from('tbl_coa')->where('parent_head_name',$getHeadCodeData->head_name)->get()->row();
            
            $nid  = (int) substr($getHeadCodeForNew->hc, -3);
            $n =$nid + 1;
            $newlevel = $getHeadCodeData->head_level+1;
            
            if($newlevel > 1){
                $n = sprintf('%03d', $n); 
            }else{
                $n = sprintf('%02d', $n);
            }
            
            $HeadCode = $account_id . $n;
            $acc_data = array(
              'head_code'       =>  $HeadCode,
              'head_name'       =>  $data['fld_bank'].' - '.$data['fld_account_title'].' ('.$data['fld_accountnumber'].')',
              'parent_head_name'      =>  $getHeadCodeData->head_name,
              'head_level'      =>  $newlevel,
              'type'            => 'BANK',
              'type_id'         => $bank_id
            ); 
           
            
            $this->db->insert('tbl_coa',$acc_data);
            
            
            
            $this->db->query("UPDATE tbl_banks SET accounts_id='$HeadCode' WHERE fld_id = '$bank_id'");
            $this->send_response(200,'success',332,'Bank added successfully.');
		}else{
		    
            $this->send_response(500,'error',320, "Bank not added.Something went wrong");
		}
		}
        }
    }
    public function manage_Bank()
    {
         $device_id=$this->input->post('device_id');
	    $access_token=$this->input->post('access_token');
	    $token = $this->authenticate_token($device_id, $access_token);

        if ($token == '0') {
            $this->send_response(500, 'error', 310, 'Authentication token expired.');
        } elseif ($token == '2') {
            $this->send_response(500, 'error', 320, 'Invalid token / device id.');
        } elseif ($token == 'no token') {
            $this->send_response(500, 'error', 500, 'Please include authentication token & device id with each request.');
        } elseif ($token == '1') {
		$data['banks']=$this->Base_model->getAll('tbl_banks');
        $this->send_response(200,'success',332,'Bank List.',$data);
        }
    }
    public function editBank(){
         $device_id=$this->input->post('device_id');
	    $access_token=$this->input->post('access_token');
	    $token = $this->authenticate_token($device_id, $access_token);

        if ($token == '0') {
            $this->send_response(500, 'error', 310, 'Authentication token expired.');
        } elseif ($token == '2') {
            $this->send_response(500, 'error', 320, 'Invalid token / device id.');
        } elseif ($token == 'no token') {
            $this->send_response(500, 'error', 500, 'Please include authentication token & device id with each request.');
        } elseif ($token == '1') {
        $id=$this->input->post('id');
		
		$data['bank']=$this->Base_model->getRow('tbl_banks','','fld_id ='.$id.'');
        $this->send_response(200,'success',332,'Bank detail.',$data);
        }
	}
	public function updateBank(){
		 $device_id=$this->input->post('device_id');
	    $access_token=$this->input->post('access_token');
	    $token = $this->authenticate_token($device_id, $access_token);

        if ($token == '0') {
            $this->send_response(500, 'error', 310, 'Authentication token expired.');
        } elseif ($token == '2') {
            $this->send_response(500, 'error', 320, 'Invalid token / device id.');
        } elseif ($token == 'no token') {
            $this->send_response(500, 'error', 500, 'Please include authentication token & device id with each request.');
        } elseif ($token == '1') {
		$this->form_validation->set_rules('fld_bank', 'Bank name', 'required');
		$this->form_validation->set_rules('fld_address', 'Address', 'required');
		$bank_id=$this->input->post('fld_bank_id');
		if ($this->form_validation->run() == FALSE) {
			$this->send_response(500,'error',320, validation_errors());
		} else {
			$data = array(
            'fld_bank'=> $this->input->post('fld_bank',TRUE),
            'fld_account_title'=> $this->input->post('fld_account_title',TRUE),
            'fld_accountnumber'=> $this->input->post('fld_accountnumber',TRUE),
			'fld_address'=> $this->input->post('fld_address',TRUE),
			'fld_updated_by'       =>  $this->input->post('user_id'),
			'fld_updated_date'   =>  date("Y-m-d H:i:s"),
			);
			$this->db->where('fld_id',$bank_id);
			$unit=$this->db->update('tbl_banks',$data);
			
			$acc_data = array(
              'head_name'       =>  $data['fld_bank'].' - '. $data['fld_account_title'].'. '. '('.$data['fld_accountnumber'].')',
             ); 
             
            $this->db->update('tbl_coa', $acc_data, array('type'=>'BANK', 'type_id' => $bank_id));
            
		if($unit){
		    
            $this->send_response(200,'success',332,'Bank updated successfully');
            
		}else{

            $this->send_response(500,'error',320, "Bank not updated.Something went wrong");
		}
		}
        }
	}
    public function deleteBank(){
         $device_id=$this->input->post('device_id');
	    $access_token=$this->input->post('access_token');
	    $token = $this->authenticate_token($device_id, $access_token);

        if ($token == '0') {
            $this->send_response(500, 'error', 310, 'Authentication token expired.');
        } elseif ($token == '2') {
            $this->send_response(500, 'error', 320, 'Invalid token / device id.');
        } elseif ($token == 'no token') {
            $this->send_response(500, 'error', 500, 'Please include authentication token & device id with each request.');
        } elseif ($token == '1') {
		$id=$this->input->post('id');
		$responce=$this->Base_model->delete('tbl_banks','fld_id ='.$id.'');
        if($responce){
			
			$this->send_response(200,'success',332,'Bank deleted successfully.');
		}else{

			$this->send_response(500,'error',320, "Bank not deleted.Something went wrong");
		}
        }
	}
    
    public function authenticate_token($device_id = '', $access_token = '') {
        $token_valid = 0;
       
        if ($device_id && $access_token) {
            $get_token = $this->Apis_model->getAll('tbl_access_token', '', 'device_id = "' . $device_id . '" AND token_key = "' . $access_token . '"');
            
        
            if (count($get_token)) {
                $current_time = new DateTime(date("Y-m-d H:i:s"));
                $token_time = new DateTime(date("Y-m-d H:i:s", strtotime($get_token[0]['token_time'])));
                 
                $diff = $current_time->diff($token_time);
                
                $token_time_duration = $diff->h + ($diff->days * 24); // 17550
               
                if ($token_time_duration >= $this->token_time_allowed) {
                    $this->Apis_model->update('tbl_access_token', array('token_valid' => 0), 'device_id = "' . $device_id . '" AND token_key = "' . $access_token . '"');
                } else {
                    $token_valid = 1;
                }
            } else {
                $token_valid = 2;
            }

            return $token_valid;
        } else {
            return "no token";
        }
    }
    /************************ Prime21 work END *************************************/
	public function send_response($header_status, $type, $status, $message, $data = array()) {
        return $this->output
        ->set_content_type('application/json')
        ->set_status_header($header_status)
        ->set_output(json_encode(array(
            'type' => $type,
            'status' => $status,
            'message' => $message,
            'data' => $data
        )));
    }
 
}
	
	
	