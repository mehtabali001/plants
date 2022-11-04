<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends My_controller {

   function __construct() {
        parent::__construct();
        $this->load->model('Common_model');
         $this->load->model('Users');
    }
	
	public function add()
    {
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(113,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$data['view_scripts']=array(
    		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
    		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
    		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
    		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
    		$this->Gen->get_script_url('plugin_components','timepicker/bootstrap-material-datetimepicker.js'),
    		$this->Gen->get_script_url('bower_components','jquery.form-editor.init.js'),
    		$this->Gen->get_script_url('plugin_components','tinymce/tinymce.min.js'),
		);
		$data['view_css']=array(
		
		);
	
		if($this->input->post()){
			
			$this->form_validation->set_rules('fld_email', 'Template Name', 'required|is_unique[tbl_email.fld_email]');
			$this->form_validation->set_rules('fld_subject', 'Subject ', 'required|is_unique[tbl_email.fld_subject]');
			$this->form_validation->set_rules('fld_email_body', 'Template Body', 'required|is_unique[tbl_email.fld_email_body]');

		if ($this->form_validation->run() == FALSE) {
		
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Settings/add', TRUE, 302);
		} else {
			$user_id= $this->session->userdata('user_id');
			$data = array(
            'fld_userid' => $user_id,
            'fld_email'=> $this->input->post('fld_email',TRUE),
            'fld_subject'=> $this->input->post('fld_subject',TRUE),
            'fld_email_body'=> $this->input->post('fld_email_body',TRUE),
            'fld_status' => 1
        );
        
        $email=$this->db->insert('tbl_email',$data);
		if($email){
		     /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=$this->input->post('fld_email',TRUE);
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'ADD',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Email template added successfully"));
            $this->output->set_header("Location: " . base_url() . 'Settings/listing', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Email template not added.Something went wrong"));
            $this->output->set_header("Location: " . base_url() . 'Settings/add', TRUE, 302);
		}
			
		}
		}else{
			$this->title = "New Email Template";

			$this->load_template('','email/addemail',$data);
		}
        
    }
	public function listing()
    {
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(114,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$this->title = "View Templates";
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
		$this->Gen->get_script_url('bower_components','jquery.form-editor.init.js'),
		$this->Gen->get_script_url('plugin_components','tinymce/tinymce.min.js'),
		);
		$data['view_css']=array(
		
		);
       
		$data['emails']=$this->Base_model->getAll('tbl_email');
        $this->load_template('','email/listings',$data);
    }
	public function editemail($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(115,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$this->title = "Manage Emails | ".$this->title;
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
		$this->Gen->get_script_url('bower_components','jquery.form-editor.init.js'),
		$this->Gen->get_script_url('plugin_components','tinymce/tinymce.min.js'),
		);
		$data['view_css']=array(
		
		);
        $this->title = "Edit Email Template";
		$data['email']=$this->Base_model->getRow('tbl_email','','fld_id ='.$id.'');
        $this->load_template('','email/editemail',$data);
	}
	public function editEmailProcess(){
		
			if($this->input->post('fld_email') != $this->input->post('orignal_unit')){
			   $is_unique =  '|is_unique[tbl_email.fld_email]';
			} else {
			   $is_unique =  '';
			}
		
		$this->form_validation->set_rules('fld_email', 'email', 'required'.$is_unique);
		$unit_id=$this->input->post('fld_unit_id');
		if ($this->form_validation->run() == FALSE) {
		
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Settings/editemail/'.$unit_id.'', TRUE, 302);
		} else {
			$data = array(
            'fld_email'=> $this->input->post('fld_email',TRUE),
            'fld_subject'=> $this->input->post('fld_subject',TRUE),
            'fld_email_body'=> $this->input->post('fld_email_body',TRUE),
			);
        
			
			$this->db->where('fld_id',$unit_id);
			$unit=$this->db->update('tbl_email',$data);
		if($unit){
		    /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=$this->input->post('fld_email',TRUE);
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'UPDATE',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Template updated successfully"));
            $this->output->set_header("Location: " . base_url() . 'Settings/editemail/'.$unit_id.'', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Template not updated.Something went wrong"));
            $this->output->set_header("Location: " . base_url() . 'Settings/editemail/'.$unit_id.'', TRUE, 302);
		}
			
		}
		
	}
	
// 	System Settings
public function general_settings(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		
		$data['view_scripts']=array(
		$this->Gen->get_script_url('custom_js','supplier.js'),
		);
		$data['view_css']=array(
		
		);
        $this->title = "General Settings ";
		$data['settings']=$this->Base_model->getRow('tbl_general_settings');
        $this->load_template('','settings/update_general_settings',$data);
	}
	
	public function update_general_settings(){
		
// 			if($this->input->post('fld_location') != $this->input->post('orignal_location')) {
// 			   $is_unique =  '|is_unique[tbl_locations.fld_location]';
// 			} else {
// 			   $is_unique =  '';
// 			}
		
		$this->form_validation->set_rules('system_name', 'System Name', 'required');
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Settings/general_settings', TRUE, 302);
		} else {
			$data = array(
            'system_name'=> $this->input->post('system_name',TRUE),
            'system_version'=> $this->input->post('system_version',TRUE),
            'system_email'=> $this->input->post('system_email',TRUE),
			'email_sender_name'=> $this->input->post('email_sender_name',TRUE),
			'bill_from'=> $this->input->post('bill_from',TRUE),
			'financial_year'=> $this->input->post('financial_year',TRUE),
			'fld_updated_by'       =>  $this->session->userdata('user_id'),
			'fld_updated_date'   =>  date("Y-m-d H:i:s"),
			
		);
		 if(!empty($_FILES['system_logo']['name']))
			 {
				$image 		   = $_FILES['system_logo']['name'];
				$image 		   = time().'_'.$image;
				$name_ext_one  = explode(".", basename($_FILES['system_logo']['name']));
				$name_ext      = end($name_ext_one);
				$original_path = PATH_DIR.'assets/uploads/logo/';
				$path	       =	$original_path.$image;
				 if(move_uploaded_file($_FILES['system_logo']['tmp_name'],$path))
				 {
					$source_image_path = $original_path;
					$source_image_name = $image;
				// 	resize_crop_image_new(150,150,$source_image_path,$source_image_name,'thumbs/s_',$name_ext,300,300,true);
				
					$data['system_logo']	=	$image;
				// 	$this->unlink_file_image($emp_id);
				 }
			 }
			 if(!empty($_FILES['favicon']['name']))
			 {
				$image 		   = $_FILES['favicon']['name'];
				$image 		   = time().'_'.$image;
				$name_ext_one  = explode(".", basename($_FILES['favicon']['name']));
				$name_ext      = end($name_ext_one);
				$original_path = PATH_DIR.'assets/uploads/logo/';
				$path	       =	$original_path.$image;
				 if(move_uploaded_file($_FILES['favicon']['tmp_name'],$path))
				 {
					$source_image_path = $original_path;
					$source_image_name = $image;
				// 	resize_crop_image_new(150,150,$source_image_path,$source_image_name,'thumbs/s_',$name_ext,300,300,true);
				
					$data['favicon']	=	$image;
				// 	$this->unlink_file_image($emp_id);
				 }
			 }
			$this->db->where('setting_id',1);
			$unit=$this->db->update('tbl_general_settings',$data);
		if($unit){
		    /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'UPDATE',fld_detail='General Settings',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "General Settings updated successfully"));
            $this->output->set_header("Location: " . base_url() . 'Settings/general_settings', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "General Settings not updated.Something went wrong"));
            $this->output->set_header("Location: " . base_url() . 'Settings/general_settings', TRUE, 302);
		}
			
		}
		
	}
	
// 	quick links
	public function dashboard_quicklinks(){
	    	if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		
		
		$data['view_scripts']=array(
		    $this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
		$this->Gen->get_script_url('custom_js','supplier.js'),
		);
		$data['view_css']=array(
		$this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
        $this->title = "Dashboard Quick Links ";
		$data['settings']=$this->Base_model->getRow('tbl_quicklinks');
        $this->load_template('','settings/update_quicklinks',$data);
	}
	
	public function update_dashboard_quicklinks(){
	    	$this->form_validation->set_rules('name_1', 'Link Name', 'required');
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Settings/dashboard_quicklinks', TRUE, 302);
		} else {
			$data = array(
            'name_1'=> $this->input->post('name_1',TRUE),
            'url_1'=> $this->input->post('url_1',TRUE),
            'icon_1'=> $this->input->post('icon_1',TRUE),
            'name_2'=> $this->input->post('name_2',TRUE),
            'url_2'=> $this->input->post('url_2',TRUE),
            'icon_2'=> $this->input->post('icon_2',TRUE),
            'name_3'=> $this->input->post('name_3',TRUE),
            'url_3'=> $this->input->post('url_3',TRUE),
            'icon_3'=> $this->input->post('icon_3',TRUE),
            'name_4'=> $this->input->post('name_4',TRUE),
            'url_4'=> $this->input->post('url_4',TRUE),
            'icon_4'=> $this->input->post('icon_4',TRUE),
            'name_5'=> $this->input->post('name_5',TRUE),
            'url_5'=> $this->input->post('url_5',TRUE),
            'icon_5'=> $this->input->post('icon_5',TRUE),
            'name_6'=> $this->input->post('name_6',TRUE),
            'url_6'=> $this->input->post('url_6',TRUE),
            'icon_6'=> $this->input->post('icon_6',TRUE),
            'name_7'=> $this->input->post('name_7',TRUE),
            'url_7'=> $this->input->post('url_7',TRUE),
            'icon_7'=> $this->input->post('icon_7',TRUE),
            'name_8'=> $this->input->post('name_8',TRUE),
            'url_8'=> $this->input->post('url_8',TRUE),
            'icon_8'=> $this->input->post('icon_8',TRUE),
			
			'fld_updated_by'       =>  $this->session->userdata('user_id'),
			'fld_updated_date'   =>  date("Y-m-d H:i:s"),
			
		);
		 
			$this->db->where('id',1);
			$unit=$this->db->update('tbl_quicklinks',$data);
		if($unit){
		    /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'UPDATE',fld_detail='General Settings',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Links updated successfully"));
            $this->output->set_header("Location: " . base_url() . 'Settings/dashboard_quicklinks', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Links not updated.Something went wrong"));
            $this->output->set_header("Location: " . base_url() . 'Settings/dashboard_quicklinks', TRUE, 302);
		}
			
		}
	}
// 	end quick links
	public function sms_api_settings()
    {
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(252,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
			$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		$this->Gen->get_script_url('plugin_components','timepicker/bootstrap-material-datetimepicker.js'),
		$this->Gen->get_script_url('bower_components','jquery.form-editor.init.js'),
		$this->Gen->get_script_url('plugin_components','tinymce/tinymce.min.js'),
		);
		$data['view_css']=array(
		
		);
	
		if($this->input->post()){
			
			$this->form_validation->set_rules('fld_message_body', 'Message Body', 'required');

		if ($this->form_validation->run() == FALSE) {
		
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Settings/sms_api_settings', TRUE, 302);
		} else {
// 			$user_id= $this->session->userdata('user_id');
			$data = array(
            // 'fld_userid' => $user_id,
            'fld_login_id'=> $this->input->post('fld_login_id',TRUE),
            // 'fld_login_pass'=> $this->input->post('fld_login_pass',TRUE),
            // 'fld_mask'=> $this->input->post('fld_mask',TRUE),
            'fld_message_body'=> $this->input->post('fld_message_body',TRUE),
            'fld_status' => 1
        );
        
        $email=$this->db->insert('tbl_sms_api',$data);
		if($email){
		    /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=$this->input->post('fld_login_id',TRUE);
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'ADD',fld_detail='Sms Api $partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Sms Setup added successfully"));
            $this->output->set_header("Location: " . base_url() . 'Settings/view_sms_api_settings', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Sms Setup not added.Something went wrong"));
            $this->output->set_header("Location: " . base_url() . 'Settings/sms_api_settings', TRUE, 302);
		}
			
		}
		}else{
			$this->title = "New Sms Template";

			$this->load_template('','settings/sms_api_setup',$data);
		}
        
    }
    
    
    public function view_sms_api_settings()
    {
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(254,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$this->title = "View Sms Templates";
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
		$this->Gen->get_script_url('bower_components','jquery.form-editor.init.js'),
		$this->Gen->get_script_url('plugin_components','tinymce/tinymce.min.js'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
		);
		$data['view_css']=array(
		$this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
       
		$data['sms_api']=$this->Base_model->getAll('tbl_sms_api');
        $this->load_template('','settings/view_sms_api_settings',$data);
    }
    
    public function edit_sms_api($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(253,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$this->title = "Edit Sms Template";
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
		$this->Gen->get_script_url('bower_components','jquery.form-editor.init.js'),
		$this->Gen->get_script_url('plugin_components','tinymce/tinymce.min.js'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
		);
		$data['view_css']=array(
		$this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
        $data['sms_api']=$this->Base_model->getRow('tbl_sms_api','','fld_id ='.$id.'');
        $this->load_template('','settings/edit_sms_api',$data);
	}
	public function edit_sms_apiProcess(){
		
		$this->form_validation->set_rules('fld_login_id', 'Login Id', 'required');
		$unit_id=$this->input->post('fld_unit_id');
		if ($this->form_validation->run() == FALSE) {
		
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Settings/edit_sms_api/'.$unit_id.'', TRUE, 302);
		} else {
			$data = array(
            'fld_login_id'=> $this->input->post('fld_login_id',TRUE),
            // 'fld_login_pass'=> $this->input->post('fld_login_pass',TRUE),
            // 'fld_mask'=> $this->input->post('fld_mask',TRUE),
            'fld_message_body'=> $this->input->post('fld_message_body',TRUE),
            'fld_status' => $this->input->post('fld_status',TRUE),
			);
        
			
			$this->db->where('fld_id',$unit_id);
			$unit=$this->db->update('tbl_sms_api',$data);
		if($unit){
		    /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=$this->input->post('fld_login_id',TRUE);
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'UPDATE',fld_detail='Sms Api $partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Sms Setup added successfully"));
            $this->output->set_header("Location: " . base_url() . 'Settings/view_sms_api_settings', TRUE, 302);
		}else{
		    $this->session->set_userdata(array('error_message' => "Sms Setup not added.Something went wrong"));
            $this->output->set_header("Location: " . base_url() . 'Settings/sms_api_settings', TRUE, 302);
		}
			
		}
		
	}
	public function log_system(){
	   
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(118,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
		$this->Gen->get_script_url('bower_components','jquery.form-editor.init.js'),
		$this->Gen->get_script_url('plugin_components','tinymce/tinymce.min.js'),
		$this->Gen->get_script_url('custom_js','settings.js'),
		);
		$data['view_css']=array(
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
        $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
		$this->title = "System Logs";
		$data['activity_logs']=$this->Users->user_activity_log();
		
		$this->load_template('','settings/activity_log',$data);
	}
	public function filter(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}

		$data['activity_logs']=$this->Users->user_activity_log();

		$html=$this->load->view('settings/activity_log_filter',$data,true);
		echo json_encode(array("html"=>$html));
		
	}
	public function change_profile_picture(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		
		$data['view_scripts']=array(
		$this->Gen->get_script_url('custom_js','supplier.js'),
		);
		
		$user_id=$this->session->userdata('user_id');
		
        $this->title = "Edit Profile | ".$this->title;
		$data['user_profile']=$this->Base_model->getRow('tbl_users','','fld_id='.$user_id.'');
		
        $this->load_template('','settings/update_profile_picture',$data);
	}
	public function update_profile_picture(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$user_id=$this->session->userdata('user_id');
		 if($_FILES['user_logo']['size'] > 0){
		  $responce=$this->upload_user_pic();
		  $this->unlink_file_image($user_id);
		if($responce['upload'] == 1){
			$this->db->where('fld_id',$user_id);
			$this->db->update('tbl_users',array("fld_user_pic" => $responce['filename']));
			$this->session->set_userdata(array('success_message' => "Profile picture upload successfully."));
            $this->output->set_header("Location: " . base_url() . 'Settings/change_profile_picture', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Profile picture not uploaded.Something went wrong"));
            $this->output->set_header("Location: " . base_url() . 'Settings/change_profile_picture', TRUE, 302);
		}
				
		 }else{
			 $this->session->set_userdata(array('error_message' => "Profile picture not selected."));
            $this->output->set_header("Location: " . base_url() . 'Settings/change_profile_picture', TRUE, 302);
		 }
	}
	public function upload_user_pic() {

        $config['upload_path'] = 'assets/uploads/user_dp/';
        $config['allowed_types'] = '*';

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('user_logo')) {
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

    function unlink_file_image($user_id)
	{
		$query	=	$this->Common_model->select_where('fld_user_pic','tbl_users',array('fld_id'=>$user_id));
		if($query->num_rows() > 0){
			$row	=	$query->row_array();
			$img	=	$row['fld_user_pic'];
			@unlink(PATH_DIR."assets/uploads/user_dp/".$img);
		}
	}
	public function print_setting_report(){
        
		include_once APPPATH.'/third_party/autoload.php';
		
		$mpdf = new \Mpdf\Mpdf();
		$data['activity_logs']=$this->Users->user_activity_log_get();
		
		$data['filter_type']=1;
		$data['get']=$_GET;
		
		$html = $this->load->view('settings/avtivitylog_report_pdf',$data,true);
	
		$mpdf->WriteHTML($html);
		$mpdf->Output('System Logs Report.pdf','D');
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$user_id=$this->session->userdata('user_id');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
        $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
        $date=date('Y-m-d H:i:s');
	//	$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'Genrate',fld_detail='Customer Report PDF',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
       
    }
    public function logs_setting_csv(){
	    $filter=$this->input->get('filter');
		include_once APPPATH.'/third_party/autoload.php';

		$data['activity_logs']=$activity_logs=$this->Users->user_activity_log_get();
		
        $header_row = array("#", "Date", "User ID", "Role" , "Action", "Details", "IP","Address","Device");
        $csvName = 'systemlogsreport'.'.csv';
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="'.$csvName.'";');
        $output = fopen('php://output', 'w');
        
        fputcsv($output,$header_row);
        $i=1;
        foreach($activity_logs as $logs){
            foreach($logs['detail'] as $row){
            
            $dataValus=array($i,date('d-m-Y H:i',strtotime($row['fld_added_date'])), $row['fld_username'],$row['fld_role_name'],$row['fld_action'],$row['fld_detail'],$row['fld_ip_address'],$row['fld_address'],$row['fld_device']);
            fputcsv($output,$dataValus);
            $i++;
            }
        }
            
        fclose($output);
        $user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$user_id=$this->session->userdata('user_id');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
        $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
        $date=date('Y-m-d H:i:s');
		//$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'Genrate',fld_detail='Customer Report CSV',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
        exit();
            
		
		
		
	}
	
}