<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Others extends My_controller {
	
	function __construct() {
        parent::__construct();
        $this->load->model('Common_model');
    }
	
	public function index()
    {
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(170,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		if(isset($_POST['addOther'])){
		    $account_id = $this->input->post("head_account");
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
        /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=$this->input->post("name");
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'ADD',fld_detail='OTHER $partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
            $this->session->set_userdata(array('success_message' => "New account has been added."));
            redirect('Others/manage_others');
            exit();
		}
		
		
        $this->title = "New Others";
		$data['units']=$this->Base_model->getAll('tbl_units');
		$data['supplier']=$this->Base_model->getAll('tbl_suppliers');
		$data['coa']=$this->db->query("SELECT * FROM tbl_coa WHERE head_level = 2 && head_code != '101001' && head_code != '101005' && head_code != '101006' && head_code != '101007' && head_code != '101009' && head_code != '101014' && head_code != '301009'")->result_array();
		$data['subcategory']=$this->Base_model->getAll('tbl_subcategory');
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'),
		$this->Gen->get_script_url('','https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
		$this->Gen->get_script_url('custom_js','jquery.validate.js'),
		);
		$data['view_css']=array(
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'),
		
        $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
		//$maxItemID=$this->Common_model->getMaxItemID();
		//$data['maxItemID']=$maxItemID;
        $this->load_template('','others/add_others',$data);
    }
    
    public function manage_others()
    {
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(171,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
        $this->title = "View Others";
		$data['coa']=$this->db->query("SELECT * FROM tbl_coa WHERE type = 'OTHER' && deleted = 0")->result_array();
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
		$this->Gen->get_script_url('custom_js','jquery.validate.js'),
		$this->Gen->get_script_url('custom_js','deletemodal.js'),
		);
		$data['view_css']=array(
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'),
		
        $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
		//$maxItemID=$this->Common_model->getMaxItemID();
		//$data['maxItemID']=$maxItemID;
        $this->load_template('','others/manage_others',$data);
    }
    
    public function edit($editid)
    {
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(172,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		if(isset($_POST['editOther'])){
		    
            $acc_data = array(
              'head_name'       =>  $this->input->post("name"),
              'contact'       =>  $this->input->post("contact"),
              'address'       =>  $this->input->post("address"),
              'fld_updated_by'       =>  $this->session->userdata('user_id'),
				'fld_updated_date'   =>  date("Y-m-d H:i:s"),
            ); 
           
            
            $this->db->where('head_code',$editid);
			$this->db->update('tbl_coa',$acc_data);
		/****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=$this->input->post("name");
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'UPDATE',fld_detail='OTHER $partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
            $this->session->set_userdata(array('success_message' => "Party account has been updated."));
            redirect('Others/manage_others');
            exit();
		}
		
		
        $this->title = "Edit Others";
		$data['coa']=$this->db->query("SELECT * FROM tbl_coa WHERE head_level = 2 && head_code != '101001' && head_code != '101005' && head_code != '101006' && head_code != '101007' && head_code != '101009' && head_code != '101014' && head_code != '301009'")->result_array();
		$data['edit_coa'] = $this->db->query("SELECT * FROM tbl_coa WHERE head_code = '$editid' && type = 'OTHER'")->row_array(); 
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'),
		$this->Gen->get_script_url('','https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
		$this->Gen->get_script_url('custom_js','jquery.validate.js'),
		$this->Gen->get_script_url('custom_js','supplier.js'),
		);
		$data['view_css']=array(
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'),
        $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
		//$maxItemID=$this->Common_model->getMaxItemID();
		//$data['maxItemID']=$maxItemID;
        $this->load_template('','others/edit_others',$data);
    }
    
    public function add_partner()
    {
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(174,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		if(isset($_POST['addPartner'])){
		    $account_id = $this->input->post("head_account");
            
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
              'head_name'       =>  $this->input->post("name"),
              'parent_head_name'      =>  $getHeadCodeData->head_name,
              'head_level'      =>  $newlevel,
              'contact'       =>  $this->input->post("contact"),
              'address'       =>  $this->input->post("address"),
              'fld_created_date'   =>  date("Y-m-d H:i:s"),
              'type'            => 'PARTNER',
              'type_id'         => 0
            ); 
           
            
            $this->db->insert('tbl_coa',$acc_data);
           
            /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=$HeadCode;
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'ADD',fld_detail='Partner $partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
            $this->session->set_userdata(array('success_message' => "New partner has been added."));
            redirect('Others/manage_partners');
            exit();
		}
		
		
        $this->title = "New Partner ";
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'),
		$this->Gen->get_script_url('','https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
		$this->Gen->get_script_url('custom_js','jquery.validate.js'),
		);
		$data['view_css']=array(
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'),
		
        $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
		//$maxItemID=$this->Common_model->getMaxItemID();
		//$data['maxItemID']=$maxItemID;
        $this->load_template('','others/add_partner',$data);
    }
    
    public function manage_partners()
    {
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(175,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
	
		
		
        $this->title = "View Partners";
		
		$data['coa']=$this->db->query("SELECT * FROM tbl_coa WHERE type = 'PARTNER'  && deleted = 0")->result_array();
		
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
		$this->Gen->get_script_url('custom_js','jquery.validate.js'),
		$this->Gen->get_script_url('custom_js','deletemodal.js'),
		);
		$data['view_css']=array(
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'),
        $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
		//$maxItemID=$this->Common_model->getMaxItemID();
		//$data['maxItemID']=$maxItemID;
        $this->load_template('','others/manage_partners',$data);
    }
    
     public function editPartner($editid)
    {
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(176,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		if(isset($_POST['editPartner'])){
		    
            $acc_data = array(
              'head_name'       =>  $this->input->post("name"),
              'contact'       =>  $this->input->post("contact"),
              'address'       =>  $this->input->post("address"),
              'fld_updated_by'       =>  $this->session->userdata('user_id'),
				'fld_updated_date'   =>  date("Y-m-d H:i:s"),
            ); 
           
            
            $this->db->where('head_code',$editid);
			$this->db->update('tbl_coa',$acc_data);
			/****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=$editid;
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'UPDATE',fld_detail='Partner $partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
            $this->session->set_userdata(array('success_message' => "Partner account has been updated."));
            redirect('Others/manage_partners');
            exit();
		}
		
		
        $this->title = "Edit Partner ";
		$data['edit_coa'] = $this->db->query("SELECT * FROM tbl_coa WHERE head_code = '$editid' && type = 'PARTNER'")->row_array(); 
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'),
		$this->Gen->get_script_url('','https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
		$this->Gen->get_script_url('custom_js','jquery.validate.js'),
		$this->Gen->get_script_url('custom_js','supplier.js'),
		);
		$data['view_css']=array(
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'),
		
        $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
		//$maxItemID=$this->Common_model->getMaxItemID();
		//$data['maxItemID']=$maxItemID;
        $this->load_template('','others/edit_partners',$data);
    }
    
    public function deleteO($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
	
		$responce = $this->db->update('tbl_coa', array('deleted'=>1), 'head_code ='.$id.'');
	  
        if($responce){
            	/****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=$id;
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'DELETED',fld_detail='OTHER $partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Other Party account has been deleted."));
			$this->output->set_header("Location: " . base_url() . 'Others/manage_others', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Party account not deleted. Something went wrong"));
			$this->output->set_header("Location: " . base_url() . 'Others/manage_others', TRUE, 302);
		}
	}
	
	public function deleteP($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$responce = $this->db->update('tbl_coa', array('deleted'=>1), 'head_code ='.$id.'');
	  
        if($responce){
            /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=$id;
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'DELETED',fld_detail='Partner $partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Partner account has been deleted."));
			$this->output->set_header("Location: " . base_url() . 'Others/manage_partners', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Partner account not deleted. Something went wrong"));
			$this->output->set_header("Location: " . base_url() . 'Others/manage_partners', TRUE, 302);
		}
	}
}
?>