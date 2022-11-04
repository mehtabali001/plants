<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Entries extends My_controller {
	
	function __construct() {
        parent::__construct();
        $this->load->model('Common_model');
    }
	
	public function index()
    {
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		
// 		$role_permissions  = explode(",",$this->session->userdata('permissions'));
// 		if(!empty($role_permissions) && !in_array(67,$role_permissions)) {
// 			$this->session->set_userdata(array('error_message' => "Access Denied!"));
// 			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
// 		}
		
        $this->title = "New Entry";
        
		// $data['units']=$this->Base_model->getAll('tbl_units');
		// $data['supplier']=$this->Base_model->getAll('tbl_suppliers');
		// $data['subcategory']=$this->Base_model->getAll('tbl_subcategory');
		
		$data['vehicles']=$this->Base_model->getAll('tbl_transporter');
		$data['view_scripts']=array(
		    $this->Gen->get_script_url('plugin_components','moment/moment.js'),
    		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
    		$this->Gen->get_script_url('custom_js','jquery.validate.js'),
    		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
    		//$this->Gen->get_script_url('','https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js'),
    		$this->Gen->get_script_url('custom_js','entries.js'),
		);
		$data['view_css']=array(
    		//$this->Gen->get_script_url('','https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css'),
    		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
    		//$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'),
    		$this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
        $this->load_template('','security/addEntry',$data);
    }
    
    public function manage_entries()
    {
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		
// 		$role_permissions  = explode(",",$this->session->userdata('permissions'));
// 		if(!empty($role_permissions) && !in_array(68,$role_permissions)) {
// 			$this->session->set_userdata(array('error_message' => "Access Denied!"));
// 			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
// 		}

		$this->title = "View Entries";
		$data['view_scripts']=array(
    		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
    		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
     		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
     		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
    		$this->Gen->get_script_url('custom_js','jquery.validate.js'),
    		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
    		$this->Gen->get_script_url('custom_js','entries.js'),
		);
		$data['view_css']=array(
		    $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		    $this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
		);
       
		$data['entries']=$this->Base_model->getAll('tbl_entries');
        $this->load_template('','security/manage_entries',$data);
    }
    
    
	public function add(){
	    
	    $role_permissions  = explode(",",$this->session->userdata('permissions'));
// 		if(!empty($role_permissions) && !in_array(67,$role_permissions)) {
// 			$this->session->set_userdata(array('error_message' => "Access Denied!"));
// 			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
// 		}

		$this->form_validation->set_rules('fld_vehicle', 'Vehicle', 'required');
		$this->form_validation->set_rules('driver', 'Driver', 'required');
		$this->form_validation->set_rules('in_time', 'In time', 'required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Entries', TRUE, 302);
		} else {
			$user_id= $this->session->userdata('user_id');
			$data = array(
                'add_by' => $user_id,
                'entry_date' => date('Y-m-d',strtotime($this->input->post('entry_date',TRUE))),
                'fld_vehicle'=> $this->input->post('fld_vehicle',TRUE),
                'driver'=> $this->input->post('driver',TRUE),
                'in_time' => $this->input->post('in_time',TRUE),
                'out_time' => $this->input->post('out_time',TRUE),
                'created_date'   =>  date("Y-m-d H:i:s"),
            );
        
        $entries = $this->db->insert('tbl_entries',$data);
		if($entries){
		/****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=$this->input->post('fld_vehicle',TRUE);
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'ADD',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Entry added successfully"));
            $this->output->set_header("Location: " . base_url() . 'Entries/manage_entries', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Entry not added.Something went wrong"));
            $this->output->set_header("Location: " . base_url() . 'Entries', TRUE, 302);
		}
			
		}
	}
	
	
	public function edit($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		
// 		$role_permissions  = explode(",",$this->session->userdata('permissions'));
// 		if(!empty($role_permissions) && !in_array(69,$role_permissions)) {
// 			$this->session->set_userdata(array('error_message' => "Access Denied!"));
// 			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
// 		}

        $this->title = "Update Entry";
        $data['vehicles']=$this->Base_model->getAll('tbl_transporter');
		$data['entry']=$this->Base_model->getRow('tbl_entries','','fld_id ='.$id.'');
		
		$data['view_scripts']=array(
    		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
    		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
    		$this->Gen->get_script_url('custom_js','jquery.validate.js'),
    		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
    		$this->Gen->get_script_url('custom_js','entries.js'),
		);
		$data['view_css']=array(
    		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
    		$this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
		// echo '<pre>';
		// print_r($data['category']);
		// exit;
        $this->load_template('','security/editEntry',$data);
	}
	
	
	public function editProcess(){
		
// 			if($this->input->post('fld_category') != $this->input->post('orignal_category')) {
// 			   $is_unique =  '|is_unique[tbl_category.fld_category]';
// 			} else {
// 			   $is_unique =  '';
// 			}
		
		$this->form_validation->set_rules('fld_vehicle', 'Vehicle', 'required');
		$this->form_validation->set_rules('driver', 'Driver', 'required');
		$this->form_validation->set_rules('in_time', 'In time', 'required');
		$id=$this->input->post('fld_id');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Entries/edit/'.$id.'', TRUE, 302);
		} else {
		    $user_id= $this->session->userdata('user_id');
			$data = array(
                'update_by' => $user_id,
                'entry_date' => date('Y-m-d',strtotime($this->input->post('entry_date',TRUE))),
                'fld_vehicle'=> $this->input->post('fld_vehicle',TRUE),
                'driver'=> $this->input->post('driver',TRUE),
                'in_time' => $this->input->post('in_time',TRUE),
                'out_time' => $this->input->post('out_time',TRUE),
                'modified_date'   =>  date("Y-m-d H:i:s"),
			);
			
			$this->db->where('fld_id',$id);
			$category=$this->db->update('tbl_entries',$data);
		if($category){
		/****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=$this->input->post('fld_vehicle',TRUE);
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'UPDATE',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Entry updated successfully"));
            $this->output->set_header("Location: " . base_url() . 'Entries/manage_entries', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Entry not updated.Something went wrong"));
            $this->output->set_header("Location: " . base_url() . 'Entries/edit/'.$id.'', TRUE, 302);
		}
		}
		
	}
	
	public function delete($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
// 		$role_permissions  = explode(",",$this->session->userdata('permissions'));
// 		if(!empty($role_permissions) && !in_array(169,$role_permissions)) {
// 			$this->session->set_userdata(array('error_message' => "Access Denied!"));
// 			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
// 		}
		$expence=$this->Base_model->getRow('tbl_entries','fld_id ='.$id.'');
		$responce=$this->Base_model->delete('tbl_entries','fld_id ='.$id.'');
        if($responce){
              /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=$expence['fld_vehicle'];
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'DELETED',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Entry deleted successfully"));
			$this->output->set_header("Location: " . base_url() . 'Entries/manage_entries', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Entry not deleted.Something went wrong"));
			$this->output->set_header("Location: " . base_url() . 'Entries/manage_entries', TRUE, 302);
		}
	}

}
