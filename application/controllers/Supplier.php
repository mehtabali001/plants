<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends My_controller {
	
	function __construct() {
        parent::__construct();
        $this->load->model('Suplier_model');
        $this->load->model('Common_model');
    }
	
	public function index()
    {
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(57,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
        $this->title = "New Supplier";
		
		$maxSuplierID=$this->Suplier_model->getMaxsuplierID();
		$data['maxid']='S-'.sprintf('%03d', $maxSuplierID['Auto_increment']);
			$data['view_scripts']=array(
		  	$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'),
		  	$this->Gen->get_script_url('','https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js'),
		  	$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
		  	$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		);
		$data['view_css']=array(
		   $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
        $this->load_template('','addSuplier',$data);
    }
	public function add(){
		$this->form_validation->set_rules('fld_supplier_code', 'Supplier code', 'required');
		$this->form_validation->set_message('fld_supplier_name', 'Supplier name', 'required');
		$this->form_validation->set_message('fld_company_name', 'Company name', 'required');
		$this->form_validation->set_message('fld_mobile_num', 'Mobile number', 'required');
		$this->form_validation->set_message('fld_supplier_type', 'Supplier type', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Supplier', TRUE, 302);
		} else {
			$data = array(
            'fld_supplier_code' => $this->input->post('fld_supplier_code',TRUE),
            'fld_company_name'       => $this->input->post('fld_company_name',TRUE),
            'fld_supplier_name'      => $this->input->post('fld_supplier_name',TRUE),
            'fld_mobile_num'        => $this->input->post('fld_mobile_num',TRUE),
            'fld_landline_num'         => $this->input->post('fld_landline_num',TRUE),
            'fld_opening_bal'       => $this->input->post('fld_opening_bal',TRUE),
            'fld_supplier_type'   => $this->input->post('fld_supplier_type',TRUE),
            'fld_email' => $this->input->post('fld_email',TRUE),
            'fld_cnic'           => $this->input->post('fld_cnic',TRUE),
            'fld_city'          => $this->input->post('fld_city',TRUE),
            'fld_ntn'         => $this->input->post('fld_ntn',TRUE),
            'fld_city_area'           => $this->input->post('fld_city_area',TRUE),
            'fld_country'       => $this->input->post('fld_country',TRUE),
            'fld_created_date'   =>  date("Y-m-d H:i:s"),
            'fld_status'        => 1
        );
        // print_r($data);exit;
         
        $supplier=$this->db->insert('tbl_suppliers',$data);
        
        
        
		if($supplier){
		    
    		$supplier_id=$this->db->insert_id();
            
           
            $account_id = 101005;
            
            
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
              'head_name'       =>  $data['fld_supplier_name'].' ('.$data['fld_supplier_code'].')',
              'parent_head_name'      =>  $getHeadCodeData->head_name,
              'head_level'      =>  $newlevel,
              'type'            => 'SUPPLIER',
              'type_id'         => $supplier_id
            ); 
           
            
            $this->db->insert('tbl_coa',$acc_data);
            
            
            
            $this->db->query("UPDATE tbl_suppliers SET accounts_id='$HeadCode' WHERE fld_id = '$supplier_id'");
            /****************** Activity Log *****************************/
            $user_role=$this->session->userdata('user_role');
			$user_role_name=$this->session->userdata('user_role_name');
			$user_id=$this->session->userdata('user_id');
			$supplier_code=$this->input->post('fld_supplier_code',TRUE);
			$supplier_code='<a href="'.base_url('Supplier/viewSuplier/'.$supplier_id.'').'">'.$supplier_code.'</a>';
			$client_ip=$this->Gen->get_client_ip();
			$address=$this->Base_model->getLocation($client_ip);
            $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
            $date=date('Y-m-d H:i:s');
			$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'ADD',fld_detail='$supplier_code',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Supplier added successfully"));
            $this->output->set_header("Location: " . base_url() . 'Supplier/manage_Supplier', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Supplier not added.Something went wrong"));
            $this->output->set_header("Location: " . base_url() . 'Supplier', TRUE, 302);
		}
			
		}
	}
	public function edit($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(59,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
        $this->title = "Update Supplier";
		$data['supplier']=$this->Base_model->getRow('tbl_suppliers','','fld_id ='.$id.'');
		$data['view_scripts']=array(
		  	$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'),
		  	$this->Gen->get_script_url('','https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js'),
		  	$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
		  	$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		  	$this->Gen->get_script_url('custom_js','supplier.js'),
		);
		$data['view_css']=array(
		   $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
        $this->load_template('','editSuplier',$data);
	}
	public function editProcess(){
		
			$this->form_validation->set_rules('fld_supplier_code', 'Supplier code', 'required');
			$this->form_validation->set_message('fld_supplier_name', 'Supplier name', 'required');
			$this->form_validation->set_message('fld_company_name', 'Company name', 'required');
			$this->form_validation->set_message('fld_mobile_num', 'Mobile number', 'required');
			$this->form_validation->set_message('fld_supplier_type', 'Supplier type', 'required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_userdata(array('error_message' => validation_errors()));
				$this->output->set_header("Location: " . base_url() . 'Supplier', TRUE, 302);
			} else {
				$data = array(
				'fld_supplier_code' => $this->input->post('fld_supplier_code',TRUE),
				'fld_company_name'       => $this->input->post('fld_company_name',TRUE),
				'fld_supplier_name'      => $this->input->post('fld_supplier_name',TRUE),
				'fld_mobile_num'        => $this->input->post('fld_mobile_num',TRUE),
				'fld_landline_num'         => $this->input->post('fld_landline_num',TRUE),
				'fld_opening_bal'       => $this->input->post('fld_opening_bal',TRUE),
				'fld_supplier_type'   => $this->input->post('fld_supplier_type',TRUE),
				'fld_email' => $this->input->post('fld_email',TRUE),
				'fld_cnic'           => $this->input->post('fld_cnic',TRUE),
				'fld_city'          => $this->input->post('fld_city',TRUE),
				'fld_ntn'         => $this->input->post('fld_ntn',TRUE),
				'fld_city_area'           => $this->input->post('fld_city_area',TRUE),
				'fld_country'       => $this->input->post('fld_country',TRUE),
				'fld_updated_by'       =>  $this->session->userdata('user_id'),
                'fld_updated_date'   =>  date("Y-m-d H:i:s"),
				'fld_status'        => 1
			);
			
			 $sup_id=$this->input->post('fld_supplier_id');
			 $this->db->where('fld_id',$sup_id);
			 //$this->db->set('fld_updated_date', 'NOW()', FALSE);
			$supplier=$this->db->update('tbl_suppliers',$data);
			
			 //$designation = $this->db->select('*')->from('tbl_designation')->where('id',$data['designation'])->get()->row()->designation_name;
		     //$plant = $this->db->select('*')->from('tbl_locations')->where('fld_id',$data['plants'])->get()->row()->fld_location;
			 
			 $acc_data = array(
              'head_name'       =>  $data['fld_supplier_name'].' '. '('.$data['fld_supplier_code'].')',
             ); 
             
            $this->db->update('tbl_coa', $acc_data, array('type'=>'SUPPLIER', 'type_id' => $sup_id));
			
			if($supplier){
			    /****************** Activity Log *****************************/
                $user_role=$this->session->userdata('user_role');
		    	$user_role_name=$this->session->userdata('user_role_name');
		    	$user_id=$this->session->userdata('user_id');
		    	$supplier_code=$this->input->post('fld_supplier_code',TRUE);
		    	$client_ip=$this->Gen->get_client_ip();
		    	$address=$this->Base_model->getLocation($client_ip);
                $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
                $date=date('Y-m-d H:i:s');
		    	$supplier_code='<a href="'.base_url('Supplier/viewSuplier/'.$sup_id.'').'">'.$supplier_code.'</a>';
			    $this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'UPDATE',fld_detail='$supplier_code',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
				$this->session->set_userdata(array('success_message' => "Supplier updated successfully"));
				$this->output->set_header("Location: " . base_url() . 'Supplier/manage_Supplier', TRUE, 302);
			}else{
				$this->session->set_userdata(array('error_message' => "Supplier not updated.Something went wrong"));
				$this->output->set_header("Location: " . base_url() . 'Supplier/edit/'.$sup_id.'', TRUE, 302);
			}
				
			}
		
	}
	public function viewSuplier($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(60,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
        $this->title = "View Supplier";
		$data['supplier']=$this->Base_model->getRow('tbl_suppliers','','fld_id ='.$id.'');
		if(empty($data['supplier'])){
		    $this->session->set_userdata(array('error_message' => "This record does not exist."));
			$this->output->set_header("Location: " . base_url() . 'Settings/log_system', TRUE, 302);
		}
        $this->load_template('','viewSuplier',$data);
	}
	public function delete($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(61,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$responce=$this->Base_model->delete('tbl_suppliers','fld_id ='.$id.'');
        if($responce){
            /****************** Activity Log *****************************/
            $user_role=$this->session->userdata('user_role');
			$user_role_name=$this->session->userdata('user_role_name');
			$user_id=$this->session->userdata('user_id');
			$supplier_code='S-'.sprintf('%03d', $id);
			$client_ip=$this->Gen->get_client_ip();
			$address=$this->Base_model->getLocation($client_ip);
            $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
            $date=date('Y-m-d H:i:s');
			$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'DELETED',fld_detail='$supplier_code',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Supplier deleted successfully"));
			$this->output->set_header("Location: " . base_url() . 'Supplier/manage_Supplier', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Supplier not deleted.Something went wrong"));
			$this->output->set_header("Location: " . base_url() . 'Supplier/manage_Supplier', TRUE, 302);
		}
	}
	
	public function manage_Supplier()
    {
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(58,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$this->title = "View Suppliers";
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
		$this->Gen->get_script_url('custom_js','supplier.js'),
		);
		$data['view_css']=array(
		
		);
       
		$data['suppliers']=$this->Base_model->getAll('tbl_suppliers');
        $this->load_template('','manage_supplier',$data);
    }
    
    public function Supplier_ledger()
    {
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(126,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$this->title = "Supplier Ledger";
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
    	$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		);
		$data['view_css']=array(
		 $this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
    	 $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
       
		$data['supplier']=$this->Base_model->getAll('tbl_suppliers');
		$data['getshipments']=$this->Base_model->getAll('tbl_purchase');
        $this->load_template('','supplier_ledger',$data);
    }
	
}
