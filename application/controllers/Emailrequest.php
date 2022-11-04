<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emailrequest extends My_controller {
	 
	function __construct(){
		parent::__construct();
		$CI =& get_instance();
		$this->load->model('Common_model');
		$this->load->library('phpmailer');
        $this->load->model('Stocks_model');
        $this->load->model('Suplier_model');
        $this->load->model('Navigations_model');
        $this->load->model('Accounts_model');
	}
	 
	public function index()
    {
        
// 		if ($this->auth->is_logged()) {
// 			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
// 		}
		
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(212,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}

        $this->title = "Balance Sheet Cron";
        //For Form Validation
		$data['view_scripts']=array(
			//$this->Gen->get_script_url('','https://code.jquery.com/jquery-2.2.4.min.js'),
		  	//$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		    //$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		  	//$this->Gen->get_script_url('custom_js','hrm.js'),
			//$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js'),
		    //$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'),
		    //$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.1/jquery.min.js'),
		  	$this->Gen->get_script_url('','https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js'),
		  	//$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
			//$this->Gen->get_script_url('custom_js','script.js'),
		);
		
		$data['view_css']=array(
		   //$this->Gen->get_script_url('theme_css','style.css'),
		   //$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css'),
		   $this->Gen->get_script_url('','https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css'),
		   //$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
		   //$this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
        
        $this->load_template('','settings/balancesheetRequest',$data);
    }
    
    public function cashflowrequest(){
        
// 		if ($this->auth->is_logged()) {
// 			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
// 		}
		
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(213,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}

        $this->title = "Cash Flow Cron";
        //For Form Validation
		$data['view_scripts']=array(
		  	$this->Gen->get_script_url('','https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js'),
		);
		$data['view_css']=array(
		   $this->Gen->get_script_url('','https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css'),
		);
        $this->load_template('','settings/cashflowrequest',$data);
    }
    
    public function stocks(){
        
// 		if ($this->auth->is_logged()) {
// 			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
// 		}
		
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(214,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}

        $this->title = "Stocks Cron";
        //For Form Validation
		$data['view_scripts']=array(
		  	$this->Gen->get_script_url('','https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js'),
		);
		$data['view_css']=array(
		   $this->Gen->get_script_url('','https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css'),
		);
        //$data['getstocks']=$this->Base_model->getAll('tbl_stocks_emailrequest');
        $this->load_template('','settings/stocksrequest',$data);
    }
    
    public function trialbalance(){
        
// 		if ($this->auth->is_logged()) {
// 			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
// 		}
		
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(255,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}

        $this->title = "Trial Balance Cron ";
        //For Form Validation
		$data['view_scripts']=array(
		  	$this->Gen->get_script_url('','https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js'),
		);
		$data['view_css']=array(
		   $this->Gen->get_script_url('','https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css'),
		);
        //$data['getstocks']=$this->Base_model->getAll('tbl_stocks_emailrequest');
        $this->load_template('','settings/trialbalancerequest',$data);
    }
    
    public function income_statement(){
        
// 		if ($this->auth->is_logged()) {
// 			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
// 		}
		
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(256,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}

        $this->title = "Income Statement Cron ";
        //For Form Validation
		$data['view_scripts']=array(
		  	$this->Gen->get_script_url('','https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js'),
		);
		$data['view_css']=array(
		   $this->Gen->get_script_url('','https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css'),
		);
        //$data['getstocks']=$this->Base_model->getAll('tbl_stocks_emailrequest');
        $this->load_template('','settings/incomestatement',$data);
    }
    
	public function getview(){
	    $assets = $this->db->query("SELECT * FROM tbl_coa WHERE head_level='1' && (head_code LIKE '101%' || head_code LIKE '102%') ORDER BY head_code asc")->result_array();
		$liabilitiesequity = $this->db->query("SELECT * FROM tbl_coa WHERE head_level='1' && ( head_code LIKE '201%' || head_code LIKE '202%' || head_code LIKE '203%' || head_code LIKE '204%' || head_code LIKE '205%') ORDER BY head_code asc")->result_array();
        $data['assets'] = $assets;
        $data['liabilitiesequity'] = $liabilitiesequity;
        $this->load->view('settings/balancesheet_request',$data);
	}
	public function sendbalancesheetrequest() {
		$this->form_validation->set_rules('send_to', 'Email Address', 'required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Emailrequest', TRUE, 302);
		} else {
			$email = $this->input->post('send_to',TRUE);
			//echo count($email);exit;
            
			if(!empty($email)){
		    
		    $time   = $this->input->post('sending_time',TRUE);
			$status = $this->input->post('status',TRUE);
			
			$getqry = $this->db->query("SELECT * FROM tbl_balencesheet_emailrequest");
           
            if($getqry->num_rows() == 0){
			$data = array(
                'send_to'=> $this->input->post('send_to',TRUE),
                'sending_time'=> $this->input->post('sending_time',TRUE),
                'status' => $this->input->post('status',TRUE),
              //'date_created' => date('Y-m-d',strtotime($this->input->post('fld_item_date',TRUE))),
                'date_created'   =>  date("Y-m-d H:i:s"),
            );
            $this->db->insert('tbl_balencesheet_emailrequest',$data);
            
            $user_role=$this->session->userdata('user_role');
			$user_role_name=$this->session->userdata('user_role_name');
			$user_id=$this->session->userdata('user_id');
			$client_ip=$this->Gen->get_client_ip();
			$address=$this->Base_model->getLocation($client_ip);
            $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
            $date=date('Y-m-d H:i:s');
			$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'ADD',fld_detail='Email request (Balance Sheet) ADD',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
            }else{
             $data = array(
                'send_to'=> $this->input->post('send_to',TRUE),
                'sending_time'=> $this->input->post('sending_time',TRUE),
                'status' => $this->input->post('status',TRUE),
              //'date_created' => date('Y-m-d',strtotime($this->input->post('fld_item_date',TRUE))),
                'modified_date'  =>  date("Y-m-d H:i:s"),
            );
            $this->db->where('id',1);
            $this->db->update('tbl_balencesheet_emailrequest',$data);  
            $user_role=$this->session->userdata('user_role');
			$user_role_name=$this->session->userdata('user_role_name');
			$user_id=$this->session->userdata('user_id');
			$client_ip=$this->Gen->get_client_ip();
			$address=$this->Base_model->getLocation($client_ip);
            $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
            $date=date('Y-m-d H:i:s');
			$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'UPDATE',fld_detail='Email request (Balance Sheet) UPDATE',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
            }
			
    	  //$filename = 'Stocks '.$time.'.pdf';
    	  /*$filename = 'Balancesheet.pdf';
    		include_once APPPATH.'/third_party/autoload.php';
		    $mpdf = new \Mpdf\Mpdf();
	        $data['locations']= $this->Base_model->getAll('tbl_locations', '', "fld_id <> 8", '');
		    $html = $this->load->view('stock/stock_report_pdf_lpg',$data,true);
		    $mpdf->WriteHTML($html);
		    $mpdf->Output(APPPATH.'/stocksrequests/'.$filename,'F');
		    if (!function_exists('set_magic_quotes_runtime')) {
                function set_magic_quotes_runtime($new_setting) {
                    return true;
                }
            }*/
    		
            //@unlink(base_url().'assets/uploads/stocksrequests/'.$filename);
            
        if (isset($_POST['add-email-now'])) {
             $settings=$this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row();    
             $getqry = $this->db->query("SELECT * FROM tbl_balencesheet_emailrequest where id = 1")->row();
             
        $assets = $this->db->query("SELECT * FROM tbl_coa WHERE head_level='1' && (head_code LIKE '101%' || head_code LIKE '102%') ORDER BY head_code asc")->result_array();
		$liabilitiesequity = $this->db->query("SELECT * FROM tbl_coa WHERE head_level='1' && ( head_code LIKE '201%' || head_code LIKE '202%' || head_code LIKE '203%' || head_code LIKE '204%' || head_code LIKE '205%') ORDER BY head_code asc")->result_array();
        $data['assets'] = $assets;
        $data['liabilitiesequity'] = $liabilitiesequity;
        $messageview = $this->load->view('settings/balancesheet_request',$data, true);
        $gettemp = $this->db->query("SELECT * FROM tbl_email where fld_id = 9")->row(); 
        $message  =    $gettemp->fld_email_body;
        $message = str_replace('{MESSAGE}', $messageview, $message);
        
             foreach(explode(',', $getqry->send_to) as $email){
			   $this->phpmailer->IsMail();  
    		  //$mail->AddAttachment($_SERVER['DOCUMENT_ROOT']."/beta/uploads/file.pdf");
    			//$this->phpmailer->AddAttachment(APPPATH.'/stocksrequests/'.$filename);
    			$this->phpmailer->From = $settings->system_email;
    			$this->phpmailer->FromName = $gettemp->fld_email;
    			$this->phpmailer->IsHTML(true);
    			$this->phpmailer->AddAddress($email); 
    			$this->phpmailer->Subject = $gettemp->fld_subject;
    			$this->phpmailer->Body = $message;
    			$this->phpmailer->Send();
    			$this->phpmailer->ClearAddresses(); 
			}
			$user_role=$this->session->userdata('user_role');
			$user_role_name=$this->session->userdata('user_role_name');
			$user_id=$this->session->userdata('user_id');
			$client_ip=$this->Gen->get_client_ip();
			$address=$this->Base_model->getLocation($client_ip);
            $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
            $date=date('Y-m-d H:i:s');
			$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'SEND',fld_detail='Email request (Balance Sheet) Emailed',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
            }
            
    		$this->session->set_userdata(array('success_message' => "Email Request added successfully."));
            $this->output->set_header("Location: " . base_url() . 'Emailrequest', TRUE, 302);
    			
			}else{
			    $this->session->set_userdata(array('error_message' => "OOPs! There is something wrong."));
                $this->output->set_header("Location: " . base_url() . 'Emailrequest', TRUE, 302);
			}
		}
	}
	
	public function sendbalancesheet_cronjob() {

    		$start_time = '12:01 AM';
            $start = date('Y-m-d H:i:s', strtotime($start_time));
            
            $data['start_time'] = $start_time;
            //echo $start;exit;
			$getqry = $this->db->query("SELECT * FROM tbl_balencesheet_emailrequest where id = 1 AND status = 1")->row();
            //$now = date('Y-m-d H:i:s');
            //$last_send = $getqry->last_send;
            $sending_time = date('Y-m-d H:i:s', strtotime($getqry->sending_time));
            $data['sending_time'] = $getqry->sending_time;

            if(!empty($getqry->send_to)){
                $settings=$this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row();
                $now = date('Y-m-d H:i:s');
                $last_send = $getqry->last_send;
                $sending_time = date('Y-m-d H:i:s', strtotime($getqry->sending_time));
                
                $gettemp = $this->db->query("SELECT * FROM tbl_email where fld_id = 9")->row(); 
                $message  =    $gettemp->fld_email_body;
                if($now > $last_send && $sending_time < $now && date('Y-m-d', strtotime($last_send)) != date('Y-m-d', strtotime($now))){
                    echo 'SEND TIME '.$now.' '.$last_send.' '.$sending_time;
                    $assets = $this->db->query("SELECT * FROM tbl_coa WHERE head_level='1' && (head_code LIKE '101%' || head_code LIKE '102%') ORDER BY head_code asc")->result_array();
            		$liabilitiesequity = $this->db->query("SELECT * FROM tbl_coa WHERE head_level='1' && ( head_code LIKE '201%' || head_code LIKE '202%' || head_code LIKE '203%' || head_code LIKE '204%' || head_code LIKE '205%') ORDER BY head_code asc")->result_array();
                    $data['assets'] = $assets;
                    $data['liabilitiesequity'] = $liabilitiesequity;
                    $messageview = $this->load->view('settings/balancesheet_request',$data, true);
                    $gettemp = $this->db->query("SELECT * FROM tbl_email where fld_id = 9")->row(); 
                    $message  =    $gettemp->fld_email_body;
                    $message = str_replace('{MESSAGE}', $messageview, $message);    
                   foreach(explode(',', $getqry->send_to) as $email){
                        $this->phpmailer->IsMail();  
            		  //$mail->AddAttachment($_SERVER['DOCUMENT_ROOT']."/beta/uploads/file.pdf");
            		  //$this->phpmailer->AddAttachment(APPPATH.'/stocksrequests/Cash Flow Report.pdf');
            			$this->phpmailer->From = $settings->system_email;
            			$this->phpmailer->FromName = $gettemp->fld_email;
            			$this->phpmailer->IsHTML(true);
            			$this->phpmailer->AddAddress($email); 
            			$this->phpmailer->Subject = $gettemp->fld_subject;
            			$this->phpmailer->Body = $message;
            			$this->phpmailer->Send();
            			$this->phpmailer->ClearAddresses();
                    }
                    $this->db->where('id', 1);
                    $this->db->update('tbl_balencesheet_emailrequest', array('last_send'=>$now));
                }
			}
	}
	
	public function sendcashflowrequest() {
	    
		$this->form_validation->set_rules('send_to', 'Email Address', 'required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Emailrequest/cashflowrequest', TRUE, 302);
		} else {
		    
			$email = $this->input->post('send_to',TRUE);
			//echo count($email);exit;
			if(!empty($email)){
		    $time   = $this->input->post('sending_time',TRUE);
			$status = $this->input->post('status',TRUE);
			$getqry = $this->db->query("SELECT * FROM tbl_cashflow_emailrequest");
            if($getqry->num_rows() == 0){
			$data = array(
                'send_to'=> $this->input->post('send_to',TRUE),
                'sending_time'=> $this->input->post('sending_time',TRUE),
                'status' => $this->input->post('status',TRUE),
              //'date_created' => date('Y-m-d',strtotime($this->input->post('fld_item_date',TRUE))),
                'date_created'   =>  date("Y-m-d H:i:s"),
            );
            $this->db->insert('tbl_cashflow_emailrequest',$data);
            $user_role=$this->session->userdata('user_role');
			$user_role_name=$this->session->userdata('user_role_name');
			$user_id=$this->session->userdata('user_id');
			$client_ip=$this->Gen->get_client_ip();
			$address=$this->Base_model->getLocation($client_ip);
            $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
            $date=date('Y-m-d H:i:s');
			$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'ADD',fld_detail='Email request (Cash Flow) ADD',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
            }else{
             $data = array(
                'send_to'=> $this->input->post('send_to',TRUE),
                'sending_time'=> $this->input->post('sending_time',TRUE),
                'status' => $this->input->post('status',TRUE),
              //'date_created' => date('Y-m-d',strtotime($this->input->post('fld_item_date',TRUE))),
                'modified_date'  =>  date("Y-m-d H:i:s"),
            );
            $this->db->where('id',1);
            $this->db->update('tbl_cashflow_emailrequest',$data);  
            $user_role=$this->session->userdata('user_role');
			$user_role_name=$this->session->userdata('user_role_name');
			$user_id=$this->session->userdata('user_id');
			$client_ip=$this->Gen->get_client_ip();
			$address=$this->Base_model->getLocation($client_ip);
            $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
            $date=date('Y-m-d H:i:s');
			$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'UPDATE',fld_detail='Email request (Cash Flow) UPDATE',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
            }
			
			$start_time = '12:01 AM';
            $start = date('Y-m-d H:i:s', strtotime($start_time));
            //$start = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', '04/12/2021')));
            
            $data['start_time'] = $start;
            //echo $start;exit;
			$getqry = $this->db->query("SELECT * FROM tbl_cashflow_emailrequest where id = 1")->row();
            //$now = date('Y-m-d H:i:s');
            //$last_send = $getqry->last_send;
            $sending_time = date('Y-m-d H:i:s', strtotime($getqry->sending_time));
            $data['sending_time'] = $sending_time;
			$type = "all";
    		$filter = "Date_Wise";
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
    		
    	$date="tm.date >= '".date("Y-m-d",strtotime($start))."' AND tm.date <= '".date("Y-m-d",strtotime($sending_time))."'";
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
		$data['ledger'] = $ledger;
		ini_set('pcre.backtrack_limit', 1000000000000);
		include_once APPPATH.'/third_party/autoload.php';
	    $mpdf = new \Mpdf\Mpdf();
		$count=count($ledger);
		$html = $this->load->view('accounts/cashflow_pdf_emailrequest',$data,true);
	    $mpdf->WriteHTML($html);
		$mpdf->Output(APPPATH.'/stocksrequests/Cash Flow Report.pdf','F');
		if (!function_exists('set_magic_quotes_runtime')) {
            function set_magic_quotes_runtime($new_setting) {
                return true;
            }
        }	
    		
            //@unlink(base_url().'assets/uploads/stocksrequests/'.$filename);
            
            if (isset($_POST['add-email-now'])) {
             $settings=$this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row();
                //echo  $settings->system_email;exit;   
             $getqry = $this->db->query("SELECT * FROM tbl_cashflow_emailrequest where id = 1")->row(); 
             $gettemp = $this->db->query("SELECT * FROM tbl_email where fld_id = 7")->row(); 
             $message  =    $gettemp->fld_email_body;
   
             foreach(explode(',', $getqry->send_to) as $email){
			   $this->phpmailer->IsMail();  
    		  //$mail->AddAttachment($_SERVER['DOCUMENT_ROOT']."/beta/uploads/file.pdf");
    			$this->phpmailer->AddAttachment(APPPATH.'/stocksrequests/Cash Flow Report.pdf');
    			$this->phpmailer->From = $settings->system_email;
    			$this->phpmailer->FromName = $gettemp->fld_email;
    			$this->phpmailer->IsHTML(true);
    			$this->phpmailer->AddAddress($email); 
    			$this->phpmailer->Subject = $gettemp->fld_subject;
    			$this->phpmailer->Body = nl2br($message);
    			$this->phpmailer->Send();
    			$this->phpmailer->ClearAddresses(); 
			}
			$user_role=$this->session->userdata('user_role');
			$user_role_name=$this->session->userdata('user_role_name');
			$user_id=$this->session->userdata('user_id');
			$client_ip=$this->Gen->get_client_ip();
			$address=$this->Base_model->getLocation($client_ip);
            $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
            $date=date('Y-m-d H:i:s');
			$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'SEND',fld_detail='Email request (Cash Flow) Emailed',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
            }
            
    		$this->session->set_userdata(array('success_message' => "Email Request added successfully."));
            $this->output->set_header("Location: " . base_url() . 'Emailrequest/cashflowrequest', TRUE, 302);
    			
			}else{
			    $this->session->set_userdata(array('error_message' => "OOPs! There is something wrong."));
                $this->output->set_header("Location: " . base_url() . 'Emailrequest/cashflowrequest', TRUE, 302);
			}
		}
	}
	
	public function sendcashflowrequest_cronjob() {

    		$start_time = '12:01 AM';
            $start = date('Y-m-d H:i:s', strtotime($start_time));
            //$start = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', '04/12/2021')));
            
            $data['start_time'] = $start;
            //echo $start;exit;
			$getqry = $this->db->query("SELECT * FROM tbl_cashflow_emailrequest where id = 1 AND status = 1")->row();
            //$now = date('Y-m-d H:i:s');
            //$last_send = $getqry->last_send;
            $sending_time = date('Y-m-d H:i:s', strtotime($getqry->sending_time));
            $data['sending_time'] = $sending_time;
			$type = "all";
    		$filter = "Date_Wise";
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
    		
    	$date="tm.date >= '".date("Y-m-d",strtotime($start))."' AND tm.date <= '".date("Y-m-d",strtotime($sending_time))."'";
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
		$data['ledger'] = $ledger;
		ini_set('pcre.backtrack_limit', 1000000000000);
		include_once APPPATH.'/third_party/autoload.php';
	    $mpdf = new \Mpdf\Mpdf();
		$count=count($ledger);
		$html = $this->load->view('accounts/cashflow_pdf_emailrequest',$data,true);
	    $mpdf->WriteHTML($html);
		$mpdf->Output(APPPATH.'/stocksrequests/Cash Flow Report.pdf','F');
		if (!function_exists('set_magic_quotes_runtime')) {
            function set_magic_quotes_runtime($new_setting) {
                return true;
            }
        }
            
         // @unlink(base_url().'assets/uploads/stocksrequests/'.$filename);
         
            $getqry = $this->db->query("SELECT * FROM tbl_cashflow_emailrequest where id = 1 and status=1")->row();
            
            if(!empty($getqry->send_to)){
                $settings=$this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row();
                $now = date('Y-m-d H:i:s');
                $last_send = $getqry->last_send;
                $sending_time = date('Y-m-d H:i:s', strtotime($getqry->sending_time));
                
                $gettemp = $this->db->query("SELECT * FROM tbl_email where fld_id = 7")->row(); 
                $message  =    $gettemp->fld_email_body;
                if($now > $last_send && $sending_time < $now && date('Y-m-d', strtotime($last_send)) != date('Y-m-d', strtotime($now))){
                    echo 'SEND TIME '.$now.' '.$last_send.' '.$sending_time;
                   foreach(explode(',', $getqry->send_to) as $email){
                        $this->phpmailer->IsMail();  
            		  //$mail->AddAttachment($_SERVER['DOCUMENT_ROOT']."/beta/uploads/file.pdf");
            			$this->phpmailer->AddAttachment(APPPATH.'/stocksrequests/Cash Flow Report.pdf');
            			$this->phpmailer->From = $settings->system_email;
            			$this->phpmailer->FromName = $gettemp->fld_email;
            			$this->phpmailer->IsHTML(true);
            			$this->phpmailer->AddAddress($email); 
            			$this->phpmailer->Subject = $gettemp->fld_subject;
            			$this->phpmailer->Body = nl2br($message);
            			$this->phpmailer->Send();
            			$this->phpmailer->ClearAddresses();
                    }
                    $this->db->where('id', 1);
                    $this->db->update('tbl_cashflow_emailrequest', array('last_send'=>$now));
                }
    			
			}
	}
	
	function getLedgDetail($id,$group_by){

        //$start = str_replace('/', '-', $this->input->post('from_date'));
		//$end = str_replace('/', '-', $this->input->post('to_date'));
		
		$start_time = '12:01 AM';
        $start = date('Y-m-d H:i:s', strtotime($start_time));
        //$start = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', '04/12/2021')));
        //echo $start;exit;
		$getqry = $this->db->query("SELECT * FROM tbl_cashflow_emailrequest where id = 1 and status=1")->row();
        $sending_time = date('Y-m-d H:i:s', strtotime($getqry->sending_time));
		
		$date="&& tm.date between '".date("Y-m-d H:i:s",strtotime($start))."' AND '".date("Y-m-d H:i:s",strtotime($sending_time))."'";
	    return $this->db->query("SELECT td.*, tm.type, tm.type_id, tm.date FROM tbl_transections_details AS td JOIN tbl_transections_master AS tm ON tm.id=td.v_id AND $group_by = '$id' AND tm.post_status = 0 $date ORDER BY tm.date, td.id")->result_array();
    }
    
    
	
	public function sendstocksrequest() {
		$this->form_validation->set_rules('send_to', 'Email Address', 'required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Emailrequest/stocks', TRUE, 302);
		} else {
			$email = $this->input->post('send_to',TRUE);
			//echo count($email);exit;
            
			if(!empty($email)){
		    
		    $time   = $this->input->post('sending_time',TRUE);
			$status = $this->input->post('status',TRUE);
			
			$getqry = $this->db->query("SELECT * FROM tbl_stocks_emailrequest");
           
            if($getqry->num_rows() == 0){
			$data = array(
                'send_to'=> $this->input->post('send_to',TRUE),
                'sending_time'=> $this->input->post('sending_time',TRUE),
                'status' => $this->input->post('status',TRUE),
              //'date_created' => date('Y-m-d',strtotime($this->input->post('fld_item_date',TRUE))),
                'date_created'   =>  date("Y-m-d H:i:s"),
            );
            $this->db->insert('tbl_stocks_emailrequest',$data);
            $user_role=$this->session->userdata('user_role');
			$user_role_name=$this->session->userdata('user_role_name');
			$user_id=$this->session->userdata('user_id');
			$client_ip=$this->Gen->get_client_ip();
			$address=$this->Base_model->getLocation($client_ip);
            $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
            $date=date('Y-m-d H:i:s');
			$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'ADD',fld_detail='Email request (Stocks Request) ADD',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
            }else{
             $data = array(
                'send_to'=> $this->input->post('send_to',TRUE),
                'sending_time'=> $this->input->post('sending_time',TRUE),
                'status' => $this->input->post('status',TRUE),
              //'date_created' => date('Y-m-d',strtotime($this->input->post('fld_item_date',TRUE))),
                'modified_date'  =>  date("Y-m-d H:i:s"),
            );
            $this->db->where('id',1);
            $this->db->update('tbl_stocks_emailrequest',$data); 
            $user_role=$this->session->userdata('user_role');
			$user_role_name=$this->session->userdata('user_role_name');
			$user_id=$this->session->userdata('user_id');
			$client_ip=$this->Gen->get_client_ip();
			$address=$this->Base_model->getLocation($client_ip);
            $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
            $date=date('Y-m-d H:i:s');
			$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'UPDATE',fld_detail='Email request (Stocks Request) UPDATE',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
            }
			
    	  //$filename = 'Stocks '.$time.'.pdf';
    		$filename = 'Stocks.pdf';
    		
    		include_once APPPATH.'/third_party/autoload.php';
		    $mpdf = new \Mpdf\Mpdf();
	        $data['locations']= $this->Base_model->getAll('tbl_locations', '', "fld_id <> 8", '');
		    $html = $this->load->view('stock/stock_report_pdf_lpg',$data,true);
		    $mpdf->WriteHTML($html);
		    $mpdf->Output(APPPATH.'/stocksrequests/'.$filename,'F');
		    
		    if (!function_exists('set_magic_quotes_runtime')) {
                function set_magic_quotes_runtime($new_setting) {
                    return true;
                }
            }
    		
            //@unlink(base_url().'assets/uploads/stocksrequests/'.$filename);
            
            if (isset($_POST['add-email-now'])) {
             $settings=$this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row();    
             $getqry = $this->db->query("SELECT * FROM tbl_stocks_emailrequest where id = 1")->row(); 
             $gettemp = $this->db->query("SELECT * FROM tbl_email where fld_id = 8")->row(); 
             $message  =    $gettemp->fld_email_body;
  
             foreach(explode(',', $getqry->send_to) as $email){
			   $this->phpmailer->IsMail();  
    		  //$mail->AddAttachment($_SERVER['DOCUMENT_ROOT']."/beta/uploads/file.pdf");
    			$this->phpmailer->AddAttachment(APPPATH.'/stocksrequests/'.$filename);
    			$this->phpmailer->From = $settings->system_email;
    			$this->phpmailer->FromName = $gettemp->fld_email;
    			$this->phpmailer->IsHTML(true);
    			$this->phpmailer->AddAddress($email); 
    			$this->phpmailer->Subject = $gettemp->fld_subject;
    			$this->phpmailer->Body = nl2br($message);
    			$this->phpmailer->Send();
    			$this->phpmailer->ClearAddresses(); 
			}
			$user_role=$this->session->userdata('user_role');
			$user_role_name=$this->session->userdata('user_role_name');
			$user_id=$this->session->userdata('user_id');
			$client_ip=$this->Gen->get_client_ip();
			$address=$this->Base_model->getLocation($client_ip);
            $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
            $date=date('Y-m-d H:i:s');
			$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'SEND',fld_detail='Email request (Stocks Request) Emailed',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
            }
            
    		$this->session->set_userdata(array('success_message' => "Email Request added successfully."));
            $this->output->set_header("Location: " . base_url() . 'Emailrequest/stocks', TRUE, 302);
    			
			}else{
			    $this->session->set_userdata(array('error_message' => "OOPs! There is something wrong."));
                $this->output->set_header("Location: " . base_url() . 'Emailrequest/stocks', TRUE, 302);
			}
		}
	}
	
	
	
	public function sendstocksrequest_cronjob() {

    		$filename = 'Stocks.pdf';
    		include_once APPPATH.'/third_party/autoload.php';
		    $mpdf = new \Mpdf\Mpdf();
	        $data['locations']= $this->Base_model->getAll('tbl_locations', '', "fld_id <> 8", '');
		    $html = $this->load->view('stock/stock_report_pdf_lpg',$data,true);
		    $mpdf->WriteHTML($html);
		    $mpdf->Output(APPPATH.'/stocksrequests/'.$filename,'F');
		    if (!function_exists('set_magic_quotes_runtime')) {
                function set_magic_quotes_runtime($new_setting) {
                    return true;
                }
            }
         // @unlink(base_url().'assets/uploads/stocksrequests/'.$filename);
            $getqry = $this->db->query("SELECT * FROM tbl_stocks_emailrequest where id = 1 AND status = 1")->row();
            
            if(!empty($getqry->send_to)){
                $settings=$this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row();
                $now = date('Y-m-d H:i:s');
                $last_send = $getqry->last_send;
                $sending_time = date('Y-m-d H:i:s', strtotime($getqry->sending_time));
                $gettemp  = $this->db->query("SELECT * FROM tbl_email where fld_id = 8")->row(); 
                $message  =    $gettemp->fld_email_body;

                if($now > $last_send && $sending_time < $now && date('Y-m-d', strtotime($last_send)) != date('Y-m-d', strtotime($now))){
                    echo 'SEND TIME '.$now.' '.$last_send.' '.$sending_time;
                   foreach(explode(',', $getqry->send_to) as $email){
                        $this->phpmailer->IsMail();  
            		  //$mail->AddAttachment($_SERVER['DOCUMENT_ROOT']."/beta/uploads/file.pdf");
            			$this->phpmailer->AddAttachment(APPPATH.'/stocksrequests/'.$filename);
            			$this->phpmailer->From = $settings->system_email;
            			$this->phpmailer->FromName = $gettemp->fld_email;
            			$this->phpmailer->IsHTML(true);
            			$this->phpmailer->AddAddress($email); 
            			$this->phpmailer->Subject = $gettemp->fld_subject;
            			$this->phpmailer->Body = nl2br($message);
            			$this->phpmailer->Send();
            			$this->phpmailer->ClearAddresses();
                    }
                    $this->db->where('id', 1);
                    $this->db->update('tbl_stocks_emailrequest', array('last_send'=>$now));
                }
			}
	}
	
	public function sendtrialbalancerequest() {
		$this->form_validation->set_rules('send_to', 'Email Address', 'required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Emailrequest/trialbalance', TRUE, 302);
		} else {
			$email = $this->input->post('send_to',TRUE);
			//echo count($email);exit;
            
			if(!empty($email)){
		    
		    $time   = $this->input->post('sending_time',TRUE);
			$status = $this->input->post('status',TRUE);
			
			$getqry = $this->db->query("SELECT * FROM tbl_trialbalance_emailrequest");
           
            if($getqry->num_rows() == 0){
			$data = array(
                'send_to'=> $this->input->post('send_to',TRUE),
                'sending_time'=> $this->input->post('sending_time',TRUE),
                'status' => $this->input->post('status',TRUE),
              //'date_created' => date('Y-m-d',strtotime($this->input->post('fld_item_date',TRUE))),
                'date_created'   =>  date("Y-m-d H:i:s"),
            );
            $this->db->insert('tbl_trialbalance_emailrequest',$data);
            $user_role=$this->session->userdata('user_role');
			$user_role_name=$this->session->userdata('user_role_name');
			$user_id=$this->session->userdata('user_id');
			$client_ip=$this->Gen->get_client_ip();
			$address=$this->Base_model->getLocation($client_ip);
            $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
            $date=date('Y-m-d H:i:s');
			$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'ADD',fld_detail='Email request (Trial Balance Request) ADD',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
            }else{
             $data = array(
                'send_to'=> $this->input->post('send_to',TRUE),
                'sending_time'=> $this->input->post('sending_time',TRUE),
                'status' => $this->input->post('status',TRUE),
              //'date_created' => date('Y-m-d',strtotime($this->input->post('fld_item_date',TRUE))),
                'modified_date'  =>  date("Y-m-d H:i:s"),
            );
            $this->db->where('id',1);
            $this->db->update('tbl_trialbalance_emailrequest',$data);  
            $user_role=$this->session->userdata('user_role');
			$user_role_name=$this->session->userdata('user_role_name');
			$user_id=$this->session->userdata('user_id');
			$client_ip=$this->Gen->get_client_ip();
			$address=$this->Base_model->getLocation($client_ip);
            $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
            $date=date('Y-m-d H:i:s');
			$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'UPDATE',fld_detail='Email request (Trial Balance Request) UPDATE',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
            }
			
    	  //$filename = 'Stocks '.$time.'.pdf';
    		$filename = 'Trialbalance.pdf';
    		
    		include_once APPPATH.'/third_party/autoload.php';
		    $mpdf = new \Mpdf\Mpdf();
		    $level = 3;
		    $start_time = '12:01 AM';
            $start = date('Y-m-d H:i:s', strtotime($start_time));
            //$start = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', '04/12/2021')));
            
            $data['start_time'] = $start;
            //echo $start;exit;
			$getqry = $this->db->query("SELECT * FROM tbl_trialbalance_emailrequest where id = 1")->row();
            //$now = date('Y-m-d H:i:s');
            //$last_send = $getqry->last_send;
            $sending_time = date('Y-m-d H:i:s', strtotime($getqry->sending_time));
            $data['sending_time'] = $sending_time;
		    
		    $data['accounts'] = $this->db->query("SELECT * FROM tbl_coa WHERE head_level = '$level' order by head_code")->result_array();
		
    		$html = $this->load->view('accounts/trialbalance_pdf_emailrequest',$data,true);
    		$mpdf->WriteHTML($html);
    		$mpdf->Output(APPPATH.'/stocksrequests/'.$filename,'F');
		    
		    if (!function_exists('set_magic_quotes_runtime')) {
                function set_magic_quotes_runtime($new_setting) {
                    return true;
                }
            }
    		
            //@unlink(base_url().'assets/uploads/stocksrequests/'.$filename);
            
            if (isset($_POST['add-email-now'])) {
             $settings=$this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row();    
             $getqry = $this->db->query("SELECT * FROM tbl_trialbalance_emailrequest where id = 1")->row(); 
             $gettemp = $this->db->query("SELECT * FROM tbl_email where fld_id = 10")->row(); 
             $message  =    $gettemp->fld_email_body;
  
             foreach(explode(',', $getqry->send_to) as $email){
			   $this->phpmailer->IsMail();  
    		  //$mail->AddAttachment($_SERVER['DOCUMENT_ROOT']."/beta/uploads/file.pdf");
    			$this->phpmailer->AddAttachment(APPPATH.'/stocksrequests/'.$filename);
    			$this->phpmailer->From = $settings->system_email;
    			$this->phpmailer->FromName = $gettemp->fld_email;
    			$this->phpmailer->IsHTML(true);
    			$this->phpmailer->AddAddress($email); 
    			$this->phpmailer->Subject = $gettemp->fld_subject;
    			$this->phpmailer->Body = nl2br($message);
    			$this->phpmailer->Send();
    			$this->phpmailer->ClearAddresses(); 
			}
			$user_role=$this->session->userdata('user_role');
			$user_role_name=$this->session->userdata('user_role_name');
			$user_id=$this->session->userdata('user_id');
			$client_ip=$this->Gen->get_client_ip();
			$address=$this->Base_model->getLocation($client_ip);
            $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
            $date=date('Y-m-d H:i:s');
			$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'SEND',fld_detail='Email request (Trial Balance Request) Emailed',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
            }
            
    		$this->session->set_userdata(array('success_message' => "Email Request added successfully."));
            $this->output->set_header("Location: " . base_url() . 'Emailrequest/trialbalance', TRUE, 302);
    			
			}else{
			    $this->session->set_userdata(array('error_message' => "OOPs! There is something wrong."));
                $this->output->set_header("Location: " . base_url() . 'Emailrequest/trialbalance', TRUE, 302);
			}
		}
	}
	
	public function sendtrialbalancerequest_cronjob() {

    		//$filename = 'Stocks '.$time.'.pdf';
    		$filename = 'Trialbalance.pdf';
    		
    		include_once APPPATH.'/third_party/autoload.php';
		    $mpdf = new \Mpdf\Mpdf();
		    $level = 3;
		    $start_time = '12:01 AM';
		    //$now = date('Y-m-d H:i:s');
            $start = date('Y-m-d H:i:s', strtotime($start_time));
            //$start = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', '04/12/2021')));
            
            $data['start_time'] = $start;
            //echo $start;exit;
			$getqry = $this->db->query("SELECT * FROM tbl_trialbalance_emailrequest where id = 1 and status=1")->row();
            //$now = date('Y-m-d H:i:s');
            //$last_send = $getqry->last_send;
            $sending_time = date('Y-m-d H:i:s', strtotime($getqry->sending_time));
            $data['sending_time'] = $sending_time;
		    
		    $data['accounts'] = $this->db->query("SELECT * FROM tbl_coa WHERE head_level = '$level' order by head_code")->result_array();
		
    		$html = $this->load->view('accounts/trialbalance_pdf_emailrequest',$data,true);
    		$mpdf->WriteHTML($html);
    		$mpdf->Output(APPPATH.'/stocksrequests/'.$filename,'F');
		    
		    if (!function_exists('set_magic_quotes_runtime')) {
                function set_magic_quotes_runtime($new_setting) {
                    return true;
                }
            }
            
            $getqry = $this->db->query("SELECT * FROM tbl_trialbalance_emailrequest where id = 1 AND status = 1")->row();
            
            if(!empty($getqry->send_to)){
                $settings=$this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row();
                $now = date('Y-m-d H:i:s');
                $last_send = $getqry->last_send;
                $sending_time = date('Y-m-d H:i:s', strtotime($getqry->sending_time));
                $gettemp  = $this->db->query("SELECT * FROM tbl_email where fld_id = 10")->row(); 
                $message  = $gettemp->fld_email_body;

                if($now > $last_send && $sending_time < $now && date('Y-m-d', strtotime($last_send)) != date('Y-m-d', strtotime($now))){
                    echo 'SEND TIME '.$now.' '.$last_send.' '.$sending_time;
                   foreach(explode(',', $getqry->send_to) as $email){
                        $this->phpmailer->IsMail();  
            		  //$mail->AddAttachment($_SERVER['DOCUMENT_ROOT']."/beta/uploads/file.pdf");
            			$this->phpmailer->AddAttachment(APPPATH.'/stocksrequests/'.$filename);
            			$this->phpmailer->From = $settings->system_email;
            			$this->phpmailer->FromName = $gettemp->fld_email;
            			$this->phpmailer->IsHTML(true);
            			$this->phpmailer->AddAddress($email); 
            			$this->phpmailer->Subject = $gettemp->fld_subject;
            			$this->phpmailer->Body = nl2br($message);
            			$this->phpmailer->Send();
            			$this->phpmailer->ClearAddresses();
                    }
                    $this->db->where('id', 1);
                    $this->db->update('tbl_trialbalance_emailrequest', array('last_send'=>$now));
                }
			}
	}
	
	public function sendincomestatementrequest() {
	    
		$this->form_validation->set_rules('send_to', 'Email Address', 'required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Emailrequest/income_statement', TRUE, 302);
		} else {
			$email = $this->input->post('send_to',TRUE);
			//echo count($email);exit;
            
			if(!empty($email)){
		    
		    $time   = $this->input->post('sending_time',TRUE);
			$status = $this->input->post('status',TRUE);
			
			$getqry = $this->db->query("SELECT * FROM tbl_incomestatement_emailrequest");
           
            if($getqry->num_rows() == 0){
			$data = array(
                'send_to'=> $this->input->post('send_to',TRUE),
                'sending_time'=> $this->input->post('sending_time',TRUE),
                'status' => $this->input->post('status',TRUE),
              //'date_created' => date('Y-m-d',strtotime($this->input->post('fld_item_date',TRUE))),
                'date_created'   =>  date("Y-m-d H:i:s"),
            );
            $this->db->insert('tbl_incomestatement_emailrequest',$data);
             $user_role=$this->session->userdata('user_role');
			$user_role_name=$this->session->userdata('user_role_name');
			$user_id=$this->session->userdata('user_id');
			$client_ip=$this->Gen->get_client_ip();
			$address=$this->Base_model->getLocation($client_ip);
            $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
            $date=date('Y-m-d H:i:s');
			$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'ADD',fld_detail='Email request (Income Statement Request) ADD',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
            }else{
             $data = array(
                'send_to'=> $this->input->post('send_to',TRUE),
                'sending_time'=> $this->input->post('sending_time',TRUE),
                'status' => $this->input->post('status',TRUE),
              //'date_created' => date('Y-m-d',strtotime($this->input->post('fld_item_date',TRUE))),
                'modified_date'  =>  date("Y-m-d H:i:s"),
            );
            $this->db->where('id',1);
            $this->db->update('tbl_incomestatement_emailrequest',$data); 
             $user_role=$this->session->userdata('user_role');
			$user_role_name=$this->session->userdata('user_role_name');
			$user_id=$this->session->userdata('user_id');
			$client_ip=$this->Gen->get_client_ip();
			$address=$this->Base_model->getLocation($client_ip);
            $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
            $date=date('Y-m-d H:i:s');
			$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'UPDATE',fld_detail='Email request (Income Statement Request) UPDATE',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
            }
			
    	  //$filename = 'Stocks '.$time.'.pdf';
    		$filename = 'Incomestatement.pdf';
    		
    		include_once APPPATH.'/third_party/autoload.php';
		    $mpdf = new \Mpdf\Mpdf();
		    
		$datestart = date('d/m/Y',mktime(0, 0, 0, date('m'), 1, date('Y')));
	    $startdate = date('Y-m-d', strtotime(str_replace('/', '-', $datestart)));
	    $lastDateOfMonth = date("Y-m-t", strtotime(str_replace('/', '-', $datestart)));
	    //echo $datestart."<br>";
	    //echo $start."<br>";
	    //echo $lastDateOfMonth;
	    //exit;    
		    
		$start = $startdate;
		$end = $lastDateOfMonth;
		$data['start_date'] = $start;
		$data['end_date'] = $end;
		$data['saleofproducts'] = $this->db->query("SELECT IFNULL(SUM(fld_total_discount), 0) discount, IFNULL(SUM(fld_grand_total_amount), 0) amount FROM `tbl_sale` WHERE DATE(fld_sale_date) >= '$start' && DATE(fld_sale_date) <= '$end'")->row();
		
		$cgsOpeningStock = $this->db->query("SELECT IFNULL(SUM(a.debit), 0)-IFNULL(SUM(a.credit), 0) as balance FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id && b.date < '$start' && a.coa_id LIKE '101003%'")->row()->balance;
		
		$cgsPurchase = $this->db->query("SELECT IFNULL(SUM(a.debit), 0) as debit FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id && b.date >= '$start' && b.date <= '$end' && a.coa_id LIKE '101003%'")->row()->debit;
		
		$cgsClosingStock = $this->db->query("SELECT IFNULL(SUM(a.debit), 0)-IFNULL(SUM(a.credit), 0) as balance FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id && a.coa_id LIKE '101003%' and b.date <= '$end'")->row()->balance;
		
// 		echo $cgsOpeningStock.'-'.$cgsPurchase.'-'.$cgsClosingStock;
// 		exit;
		
		$data['costOfGoodsSold'] = $cgsOpeningStock+$cgsPurchase-$cgsClosingStock;
		
		$data['OfficeExpenses'] = $this->db->query("SELECT IFNULL(SUM(a.unit_price), 0) amount FROM tbl_expense_detail a, tbl_expenses b WHERE b.id = a.fld_expense_id && DATE(b.date_added) >= '$start' && DATE(b.date_added) <= '$end' && a.expense_type = '1'")->row()->amount;
		$data['MessExpenses'] = $this->db->query("SELECT IFNULL(SUM(a.unit_price), 0) amount FROM tbl_expense_detail a, tbl_expenses b WHERE b.id = a.fld_expense_id && DATE(b.date_added) >= '$start' && DATE(b.date_added) <= '$end' && a.expense_type = '2'")->row()->amount;
		$data['StaffSalaries'] = $this->db->query("SELECT IFNULL(SUM(a.debit), 0) as debit FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id && b.date >= '$start' && b.date <= '$end' && a.coa_id LIKE '%101006%'")->row()->debit;
		$data['Dividend'] = $this->db->query("SELECT IFNULL(SUM(a.credit), 0) as credit FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id && b.date >= '$start' && b.date <= '$end' && a.coa_id LIKE '201008001%'")->row()->credit;
		$data['OtherIncome'] = $this->db->query("SELECT IFNULL(SUM(a.credit), 0)-IFNULL(SUM(a.debit), 0) as balance FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id && b.date >= '$start' && b.date <= '$end' && (a.coa_id = '204001001' || a.coa_id = '401002001')")->row()->balance;
	    
	    
	    $html = $this->load->view('accounts/income_report_pdf',$data,true);
	    $mpdf->WriteHTML($html);
		$mpdf->Output(APPPATH.'/stocksrequests/'.$filename,'F');
		    
	    if (!function_exists('set_magic_quotes_runtime')) {
            function set_magic_quotes_runtime($new_setting) {
                return true;
            }
        }
    		
            //@unlink(base_url().'assets/uploads/stocksrequests/'.$filename);
            
            if (isset($_POST['add-email-now'])) {
             $settings=$this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row();    
             $getqry = $this->db->query("SELECT * FROM tbl_incomestatement_emailrequest where id = 1")->row(); 
             $gettemp = $this->db->query("SELECT * FROM tbl_email where fld_id = 11")->row(); 
             $message  =    $gettemp->fld_email_body;
  
             foreach(explode(',', $getqry->send_to) as $email){
			   $this->phpmailer->IsMail();  
    		  //$mail->AddAttachment($_SERVER['DOCUMENT_ROOT']."/beta/uploads/file.pdf");
    			$this->phpmailer->AddAttachment(APPPATH.'/stocksrequests/'.$filename);
    			$this->phpmailer->From = $settings->system_email;
    			$this->phpmailer->FromName = $gettemp->fld_email;
    			$this->phpmailer->IsHTML(true);
    			$this->phpmailer->AddAddress($email); 
    			$this->phpmailer->Subject = $gettemp->fld_subject;
    			$this->phpmailer->Body = nl2br($message);
    			$this->phpmailer->Send();
    			$this->phpmailer->ClearAddresses(); 
			}
			 $user_role=$this->session->userdata('user_role');
			$user_role_name=$this->session->userdata('user_role_name');
			$user_id=$this->session->userdata('user_id');
			$client_ip=$this->Gen->get_client_ip();
			$address=$this->Base_model->getLocation($client_ip);
            $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
            $date=date('Y-m-d H:i:s');
			$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'SEND',fld_detail='Email request (Income Statement Request) Emailed',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
            }
    		$this->session->set_userdata(array('success_message' => "Email Request added successfully."));
            $this->output->set_header("Location: " . base_url() . 'Emailrequest/income_statement', TRUE, 302);
			}else{
			    $this->session->set_userdata(array('error_message' => "OOPs! There is something wrong."));
                $this->output->set_header("Location: " . base_url() . 'Emailrequest/income_statement', TRUE, 302);
			}
		}
	}
	
	public function sendincomestatementrequest_cronjob() {
			
    		$filename = 'Incomestatement.pdf';
    		
    		include_once APPPATH.'/third_party/autoload.php';
		    $mpdf = new \Mpdf\Mpdf();
		    
		    $datestart = date('d/m/Y',mktime(0, 0, 0, date('m'), 1, date('Y')));
	    $startdate = date('Y-m-d', strtotime(str_replace('/', '-', $datestart)));
	    $lastDateOfMonth = date("Y-m-t", strtotime(str_replace('/', '-', $datestart)));
	    //echo $datestart."<br>";
	    //echo $start."<br>";
	    //echo $lastDateOfMonth;
	    //exit;    
		    
		$start = $startdate;
		$end = $lastDateOfMonth;
		$data['start_date'] = $start;
		$data['end_date'] = $end;
		$data['saleofproducts'] = $this->db->query("SELECT IFNULL(SUM(fld_total_discount), 0) discount, IFNULL(SUM(fld_grand_total_amount), 0) amount FROM `tbl_sale` WHERE DATE(fld_sale_date) >= '$start' && DATE(fld_sale_date) <= '$end'")->row();
		
		$cgsOpeningStock = $this->db->query("SELECT IFNULL(SUM(a.debit), 0)-IFNULL(SUM(a.credit), 0) as balance FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id && b.date < '$start' && a.coa_id LIKE '101003%'")->row()->balance;
		
		$cgsPurchase = $this->db->query("SELECT IFNULL(SUM(a.debit), 0) as debit FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id && b.date >= '$start' && b.date <= '$end' && a.coa_id LIKE '101003%'")->row()->debit;
		
		$cgsClosingStock = $this->db->query("SELECT IFNULL(SUM(a.debit), 0)-IFNULL(SUM(a.credit), 0) as balance FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id && a.coa_id LIKE '101003%' and b.date <= '$end'")->row()->balance;
		
// 		echo $cgsOpeningStock.'-'.$cgsPurchase.'-'.$cgsClosingStock;
// 		exit;
		
		$data['costOfGoodsSold'] = $cgsOpeningStock+$cgsPurchase-$cgsClosingStock;
		
		$data['OfficeExpenses'] = $this->db->query("SELECT IFNULL(SUM(a.unit_price), 0) amount FROM tbl_expense_detail a, tbl_expenses b WHERE b.id = a.fld_expense_id && DATE(b.date_added) >= '$start' && DATE(b.date_added) <= '$end' && a.expense_type = '1'")->row()->amount;
		$data['MessExpenses'] = $this->db->query("SELECT IFNULL(SUM(a.unit_price), 0) amount FROM tbl_expense_detail a, tbl_expenses b WHERE b.id = a.fld_expense_id && DATE(b.date_added) >= '$start' && DATE(b.date_added) <= '$end' && a.expense_type = '2'")->row()->amount;
		$data['StaffSalaries'] = $this->db->query("SELECT IFNULL(SUM(a.debit), 0) as debit FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id && b.date >= '$start' && b.date <= '$end' && a.coa_id LIKE '%101006%'")->row()->debit;
		$data['Dividend'] = $this->db->query("SELECT IFNULL(SUM(a.credit), 0) as credit FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id && b.date >= '$start' && b.date <= '$end' && a.coa_id LIKE '201008001%'")->row()->credit;
		$data['OtherIncome'] = $this->db->query("SELECT IFNULL(SUM(a.credit), 0)-IFNULL(SUM(a.debit), 0) as balance FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id && b.date >= '$start' && b.date <= '$end' && (a.coa_id = '204001001' || a.coa_id = '401002001')")->row()->balance;
	    
		    $html = $this->load->view('accounts/income_report_pdf',$data,true);
    		$mpdf->WriteHTML($html);
    		$mpdf->Output(APPPATH.'/stocksrequests/'.$filename,'F');
		    
		    if (!function_exists('set_magic_quotes_runtime')) {
                function set_magic_quotes_runtime($new_setting) {
                    return true;
                }
            }
            
            $getqry = $this->db->query("SELECT * FROM tbl_incomestatement_emailrequest where id = 1 AND status = 1")->row();
            
            if(!empty($getqry->send_to)){
                $settings=$this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row();
                $now = date('Y-m-d H:i:s');
                $last_send = $getqry->last_send;
                $sending_time = date('Y-m-d H:i:s', strtotime($getqry->sending_time));
                $gettemp  = $this->db->query("SELECT * FROM tbl_email where fld_id = 11")->row(); 
                $message  = $gettemp->fld_email_body;

                if($now > $last_send && $sending_time < $now && date('Y-m-d', strtotime($last_send)) != date('Y-m-d', strtotime($now))){
                    echo 'SEND TIME '.$now.' '.$last_send.' '.$sending_time;
                   foreach(explode(',', $getqry->send_to) as $email){
                        $this->phpmailer->IsMail();  
            		  //$mail->AddAttachment($_SERVER['DOCUMENT_ROOT']."/beta/uploads/file.pdf");
            			$this->phpmailer->AddAttachment(APPPATH.'/stocksrequests/'.$filename);
            			$this->phpmailer->From = $settings->system_email;
            			$this->phpmailer->FromName = $gettemp->fld_email;
            			$this->phpmailer->IsHTML(true);
            			$this->phpmailer->AddAddress($email); 
            			$this->phpmailer->Subject = $gettemp->fld_subject;
            			$this->phpmailer->Body = nl2br($message);
            			$this->phpmailer->Send();
            			$this->phpmailer->ClearAddresses();
                    }
                    $this->db->where('id', 1);
                    $this->db->update('tbl_incomestatement_emailrequest', array('last_send'=>$now));
                }
			}
	}
}
