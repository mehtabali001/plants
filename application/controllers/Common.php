<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common extends My_controller {
	
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
		if(!empty($role_permissions) && !in_array(67,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		
        $this->title = "New Product Category ";
		$data['units']=$this->Base_model->getAll('tbl_units');
		$data['supplier']=$this->Base_model->getAll('tbl_suppliers');
		$data['subcategory']=$this->Base_model->getAll('tbl_subcategory');
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
// 		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'),
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
        $this->load_template('','addCategory',$data);
    }
	public function add(){
	    
	    $role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(67,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}

		$this->form_validation->set_rules('fld_category', 'Category', 'required|is_unique[tbl_category.fld_category]');
		$this->form_validation->set_rules('fld_unit', 'Unit', 'required');
		if ($this->form_validation->run() == FALSE) {
		
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Common', TRUE, 302);
		} else {
			$user_id= $this->session->userdata('user_id');
			$data = array(
            'fld_userid' => $user_id,
            'fld_category'=> $this->input->post('fld_category',TRUE),
            'fld_unit'=> $this->input->post('fld_unit',TRUE),
            //'fld_subcategory'=> $this->input->post('fld_sub_category',TRUE),
            'fld_status' => $this->input->post('fld_status',TRUE),
            'fld_date' => date('Y-m-d',strtotime($this->input->post('fld_item_date',TRUE))),
            'fld_description' => $this->input->post('fld_description',TRUE),
            'fld_created_date'   =>  date("Y-m-d H:i:s"),
        );
        
        $supplier=$this->db->insert('tbl_category',$data);
		if($supplier){
		    	/****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=$this->input->post('fld_category',TRUE);
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'ADD',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Category added successfully"));
            $this->output->set_header("Location: " . base_url() . 'Common/manage_Category', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Category not added.Something went wrong"));
            $this->output->set_header("Location: " . base_url() . 'Common', TRUE, 302);
		}
			
		}
	}
	
	
	public function edit($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(69,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
        $this->title = "Update Category ";
		$data['category']=$this->Base_model->getRow('tbl_category','','fld_id ='.$id.'');
		
		$data['units']=$this->Base_model->getAll('tbl_units');
		$data['supplier']=$this->Base_model->getAll('tbl_suppliers');
		//$data['subcategory']=$this->Base_model->getAll('tbl_subcategory');
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		$this->Gen->get_script_url('custom_js','jquery.validate.js'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
		$this->Gen->get_script_url('custom_js','supplier.js'),
		);
		$data['view_css']=array(
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'),
        $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
		// echo '<pre>';
		// print_r($data['category']);
		// exit;
        $this->load_template('','editCategory',$data);
	}
	public function editProcess(){
		
			if($this->input->post('fld_category') != $this->input->post('orignal_category')) {
			   $is_unique =  '|is_unique[tbl_category.fld_category]';
			} else {
			   $is_unique =  '';
			}
		
		$this->form_validation->set_rules('fld_category', 'Category', 'required'.$is_unique);
		$this->form_validation->set_rules('fld_unit', 'Unit', 'required');
		//$this->form_validation->set_rules('fld_supplier_id', 'Supplier', 'required');
		$cat_id=$this->input->post('fld_category_id');
		if ($this->form_validation->run() == FALSE) {
		
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Common/edit/'.$cat_id.'', TRUE, 302);
		} else {
			$data = array(
            'fld_category'=> $this->input->post('fld_category',TRUE),
            'fld_unit'=> $this->input->post('fld_unit',TRUE),
            //'fld_subcategory'=> $this->input->post('fld_sub_category',TRUE),
            'fld_status' => $this->input->post('fld_status',TRUE),
            'fld_date' => date('Y-m-d',strtotime($this->input->post('fld_item_date',TRUE))),
            'fld_description' => $this->input->post('fld_description',TRUE),
              'fld_updated_by'       =>  $this->session->userdata('user_id'),
				'fld_updated_date'   =>  date("Y-m-d H:i:s"),
			);
			
			$this->db->where('fld_id',$cat_id);
			$category=$this->db->update('tbl_category',$data);
		if($category){
		    	/****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=$this->input->post('fld_category',TRUE);
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'UPDATE',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Category updated successfully"));
            $this->output->set_header("Location: " . base_url() . 'Common/manage_Category', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Category not updated.Something went wrong"));
            $this->output->set_header("Location: " . base_url() . 'Common/edit/'.$cat_id.'', TRUE, 302);
		}
			
		}
		
	}
	public function manage_Category()
    {
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(68,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$this->title = "View Categories";
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
		$this->Gen->get_script_url('custom_js','deletemodal.js'),
		
		);
		$data['view_css']=array(
		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'),
		);
       
		$data['categories']=$this->Base_model->getAll('tbl_category');
        $this->load_template('','manage_category',$data);
    }
	public function delete($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(70,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$category=$this->Base_model->getRow('tbl_category','fld_id ='.$id.'');
		$responce=$this->Base_model->delete('tbl_category','fld_id ='.$id.'');
        if($responce){
            	/****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=@$category['fld_category'];
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'DELETED',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Category deleted successfully"));
			$this->output->set_header("Location: " . base_url() . 'Common/manage_Category', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Category not deleted.Something went wrong"));
			$this->output->set_header("Location: " . base_url() . 'Common/manage_Category', TRUE, 302);
		}
	}
	public function manage_subCategory()
    {
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(72,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$this->title = "View Categories";
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
		$this->Gen->get_script_url('custom_js','deletemodal.js'),
		);
		$data['view_css']=array(
		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'),
		);
       
		$data['subcategories']=$this->Base_model->getAll('tbl_subcategory');
        $this->load_template('','manage_subcategory',$data);
    }
	public function addsubcategory(){

		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(71,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		if($this->input->post()){
			$this->form_validation->set_rules('fld_category', 'Category', 'required');
			$this->form_validation->set_rules('fld_subcategory', 'Sub-Category', 'required');
			if ($this->form_validation->run() == FALSE) {
			
				$this->session->set_userdata(array('error_message' => validation_errors()));
				$this->output->set_header("Location: " . base_url() . 'Common', TRUE, 302);
			} else {
				$user_id= $this->session->userdata('user_id');
				$data = array(
				'fld_userid' => $user_id,
				'fld_cid'=> $this->input->post('fld_category',TRUE),
				'fld_subcategory'=> $this->input->post('fld_subcategory',TRUE),
				'weight'=> $this->input->post('weight',TRUE),
				'fld_created_date'   =>  date("Y-m-d H:i:s"),
			);
			
			$subcat=$this->db->insert('tbl_subcategory',$data);
			if($subcat){
			    /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=$this->input->post('fld_subcategory',TRUE);
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'ADD',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
				$this->session->set_userdata(array('success_message' => "Sub-Category added successfully"));
				$this->output->set_header("Location: " . base_url() . 'Common/manage_subCategory', TRUE, 302);
			}else{
				$this->session->set_userdata(array('error_message' => "Sub-Category not added.Something went wrong"));
				$this->output->set_header("Location: " . base_url() . 'Common/addsubcategory', TRUE, 302);
			}
				
			}
		}else{
			
			$this->title = "New Sub-Category ";
			$data['units']=$this->Base_model->getAll('tbl_units');
			$data['category']=$this->Base_model->getAll('tbl_category');
			$data['view_scripts']=array(
			$this->Gen->get_script_url('plugin_components','moment/moment.js'),
			$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
			$this->Gen->get_script_url('custom_js','jquery.validate.js'),
			$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
			);
			$data['view_css']=array(
			$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
			$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'),
			$this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
			);
			$this->load_template('','addSubCategory',$data);
		}
	}
	
	// get sub category by category_id
    function get_sub_category(){
        $category_id = $this->input->post('id',TRUE);
        $data = $this->db->query("SELECT * FROM tbl_subcategory WHERE fld_cid = '".$category_id."'")->result();
        echo json_encode($data);
    }
    
    // get sub category by category_id
    function get_sub_values(){
        $category_id = $this->input->post('id',TRUE);
        $data = $this->db->query("SELECT * FROM tbl_expense_type WHERE expense_type = '".$category_id."'")->result();
        echo json_encode($data);
    }
	
	
	public function editsubcategory($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(73,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
        $this->title = "Update Sub Category ";
        $data['category']=$this->Base_model->getAll('tbl_category');
		$data['subcategory']=$this->Base_model->getRow('tbl_subcategory','','fld_subcid ='.$id.'');
		
		//$data['units']=$this->Base_model->getAll('tbl_units');
		//$data['supplier']=$this->Base_model->getAll('tbl_suppliers');

		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		$this->Gen->get_script_url('custom_js','jquery.validate.js'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
		$this->Gen->get_script_url('custom_js','supplier.js'),
		);
		$data['view_css']=array(
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'),
        $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
		// echo '<pre>';
		// print_r($data['category']);
		// exit;
        $this->load_template('','editsubCategory',$data);
	}
	public function editsubcategoryProcess(){
		
			if($this->input->post('fld_subcategory') != $this->input->post('orignal_subcategory')) {
			   $is_unique =  '|is_unique[tbl_subcategory.fld_subcategory]';
			} else {
			   $is_unique =  '';
			}
		
		$this->form_validation->set_rules('fld_subcategory', 'Sub Category', 'required'.$is_unique);
		//$this->form_validation->set_rules('fld_unit', 'Unit', 'required');
		
		$subcat_id=$this->input->post('fld_subcategory_id');
		
		if ($this->form_validation->run() == FALSE) {
		
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Common/editsubcategory/'.$subcat_id.'', TRUE, 302);
		} else {
			$data = array(
			'fld_cid'=> $this->input->post('fld_category',TRUE),    
            'fld_subcategory'=> $this->input->post('fld_subcategory',TRUE),
            'weight'=> $this->input->post('weight',TRUE),
            'fld_updated_by'       =>  $this->session->userdata('user_id'),
				'fld_updated_date'   =>  date("Y-m-d H:i:s"),
			);
			
			$this->db->where('fld_subcid',$subcat_id);
			$subcategory=$this->db->update('tbl_subcategory',$data);
		if($subcategory){
		      /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=$this->input->post('fld_subcategory',TRUE);
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'UPDATE',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Sub Category updated successfully"));
            $this->output->set_header("Location: " . base_url() . 'Common/manage_subCategory', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Sub Category not updated.Something went wrong"));
            $this->output->set_header("Location: " . base_url() . 'Common/editsubcategory/'.$subcat_id.'', TRUE, 302);
		}
			
		}
		
	}
	
	
	public function deletesubcat($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(74,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$subcat=$this->Base_model->getRow('tbl_subcategory','fld_subcid='.$id.'');
		$responce=$this->Base_model->delete('tbl_subcategory','fld_subcid='.$id.'');
        if($responce){
            /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=@$subcat['fld_subcategory'];
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'DELETED',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Sub-Category deleted successfully"));
			$this->output->set_header("Location: " . base_url() . 'Common/manage_subCategory', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Sub-Category not deleted.Something went wrong"));
			$this->output->set_header("Location: " . base_url() . 'Common/manage_subCategory', TRUE, 302);
		}
	}
	public function addUnit()
    {
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(79,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		if($this->input->post()){
			
			$this->form_validation->set_rules('fld_unit', 'Unit', 'required|is_unique[tbl_units.fld_unit]');

		if ($this->form_validation->run() == FALSE) {
		
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Common/addUnit', TRUE, 302);
		} else {
			$user_id= $this->session->userdata('user_id');
			$data = array(
            'fld_userid' => $user_id,
            'fld_unit'=> $this->input->post('fld_unit',TRUE),
            'fld_created_date'   =>  date("Y-m-d H:i:s"),
            'fld_status' => 1
        );
        
        $unit=$this->db->insert('tbl_units',$data);
		if($unit){
		      /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=$this->input->post('fld_unit',TRUE);
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'ADD',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Product Unit added successfully"));
            $this->output->set_header("Location: " . base_url() . 'Common/manage_Unit', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Product Unit not added.Something went wrong"));
            $this->output->set_header("Location: " . base_url() . 'Common/addUnit', TRUE, 302);
		}
			
		}
		}else{
			$this->title = "New Unit";

			$this->load_template('','addUnit');
		}
        
    }
	public function manage_Unit()
    {
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(80,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$this->title = "View Units";
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
		$this->Gen->get_script_url('custom_js','deletemodal.js'),
		);
		$data['view_css']=array(
		
		);
       
		$data['units']=$this->Base_model->getAll('tbl_units');
        $this->load_template('','manage_units',$data);
    }
	public function editUnit($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(81,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$data['view_scripts']=array(
		$this->Gen->get_script_url('custom_js','supplier.js'),
		);
		$data['view_css']=array(
		);
        $this->title = "Update Unit";
		$data['unit']=$this->Base_model->getRow('tbl_units','','fld_id ='.$id.'');
        $this->load_template('','editUnit',$data);
	}
	public function editUnitProcess(){
		
			if($this->input->post('fld_unit') != $this->input->post('orignal_unit')) {
			   $is_unique =  '|is_unique[tbl_units.fld_unit]';
			} else {
			   $is_unique =  '';
			}
		
		$this->form_validation->set_rules('fld_unit', 'Unit', 'required'.$is_unique);
		$unit_id=$this->input->post('fld_unit_id');
		if ($this->form_validation->run() == FALSE) {
		
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Common/editUnit/'.$unit_id.'', TRUE, 302);
		} else {
			$data = array(
            'fld_unit'=> $this->input->post('fld_unit',TRUE),
            'fld_updated_by'       =>  $this->session->userdata('user_id'),
			'fld_updated_date'   =>  date("Y-m-d H:i:s"),
			);
        
			
			$this->db->where('fld_id',$unit_id);
			$unit=$this->db->update('tbl_units',$data);
		if($unit){
		     /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=$this->input->post('fld_unit',TRUE);
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'UPDATE',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Product Unit updated successfully"));
            $this->output->set_header("Location: " . base_url() . 'Common/manage_Unit', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Product Unit not updated.Something went wrong"));
            $this->output->set_header("Location: " . base_url() . 'Common/editUnit/'.$unit_id.'', TRUE, 302);
		}
			
		}
		
	}
	public function deleteUnit($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(82,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$unit=$this->Base_model->getRow('tbl_units','fld_id ='.$id.'');
		$responce=$this->Base_model->delete('tbl_units','fld_id ='.$id.'');
        if($responce){
             /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=@$unit['fld_unit'];
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'DELETED',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Product unit deleted successfully"));
			$this->output->set_header("Location: " . base_url() . 'Common/manage_Unit', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Product unit not deleted.Something went wrong"));
			$this->output->set_header("Location: " . base_url() . 'Common/manage_Unit', TRUE, 302);
		}
	}
	
	public function addLocation()
    {
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(83,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		if($this->input->post()){
			
			$this->form_validation->set_rules('fld_location', 'Location', 'required|is_unique[tbl_locations.fld_location]');
			$this->form_validation->set_rules('fld_address', 'Location address', 'required');

		if ($this->form_validation->run() == FALSE) {
		
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Common/addLocation', TRUE, 302);
		} else {
			
			$user_id= $this->session->userdata('user_id');
			$data = array(
            'fld_userid' => $user_id,
            'fld_location'=> $this->input->post('fld_location',TRUE),
            'fld_address'=> $this->input->post('fld_address',TRUE),
            'fld_created_date'   =>  date("Y-m-d H:i:s"),
            'fld_status' => 1
        );
        
        $unit=$this->db->insert('tbl_locations',$data);
		if($unit){
		    $location_id = $this->db->insert_id();
		    ///// START INSERT CASH IN HAND IN COA /////
		    $account_id = 101001;
		    
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
              'head_name'       =>  $data['fld_location'].' (Cash In Hand)',
              'parent_head_name'      =>  $getHeadCodeData->head_name,
              'head_level'      =>  $newlevel,
              'type'            => '',
              'type_id'         => 0
            ); 
           
            
            $this->db->insert('tbl_coa',$acc_data);
            $cash_in_hand = $HeadCode;
            
            ///// END INSERT CASH IN HAND IN COA /////
            
            ///// START INSERT PETTY CASH IN COA /////
            $account_id = 101009;
		    
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
              'head_name'       =>  $data['fld_location'].' (Petty Cash)',
              'parent_head_name'      =>  $getHeadCodeData->head_name,
              'head_level'      =>  $newlevel,
              'type'            => '',
              'type_id'         => 0
            ); 
           
            
            $this->db->insert('tbl_coa',$acc_data);
            $petty_cash = $HeadCode;
            
            ///// END INSERT PETTY CASH IN COA /////
            
            ///// START INSERT EXPENSE IN COA /////
            $account_id = 301009;
		    
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
              'head_name'       =>  $data['fld_location'].' (Office & Mess Expense)',
              'parent_head_name'      =>  $getHeadCodeData->head_name,
              'head_level'      =>  $newlevel,
              'type'            => '',
              'type_id'         => 0
            ); 
           
            
            $this->db->insert('tbl_coa',$acc_data);
            $expense_acc = $HeadCode;
            
            ///// END INSERT EXPENSE IN COA /////
            
            ///// START INSERT INVENTORY IN COA /////
            $account_id = 101003;
		    
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
              'head_name'       =>  'INVENTORY A/C ('.$data['fld_location'].')',
              'parent_head_name'      =>  $getHeadCodeData->head_name,
              'head_level'      =>  $newlevel,
              'type'            => '',
              'type_id'         => 0
            ); 
           
            
            $this->db->insert('tbl_coa',$acc_data);
            $inventory_acc = $HeadCode;
            
            ///// END INSERT INVENTORY IN COA /////
            
            ///// START INSERT PL IN COA /////
            $account_id = 205001;
		    
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
              'head_name'       =>  $data['fld_location'].'(Profit & Loss Division)',
              'parent_head_name'      =>  $getHeadCodeData->head_name,
              'head_level'      =>  $newlevel,
              'type'            => '',
              'type_id'         => 0
            ); 
           
            
            $this->db->insert('tbl_coa',$acc_data);
            $pl_acc = $HeadCode;
            
            ///// END INSERT PL IN COA /////
            
            ////UPDATE ACCOUNTS IDS IN LOCATIONS TABLE////
            
            $this->db->query("UPDATE tbl_locations SET cash_in_hand = '$cash_in_hand', petty_cash = '$petty_cash', office_mess_expense = '$expense_acc', inventory_account = '$inventory_acc', profitloss_account = '$pl_acc' WHERE fld_id = '$location_id'");
		     /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=$this->input->post('fld_location',TRUE);
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'ADD',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Location added successfully"));
            $this->output->set_header("Location: " . base_url() . 'Common/manage_Location', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Location not added.Something went wrong"));
            $this->output->set_header("Location: " . base_url() . 'Common/addLocation', TRUE, 302);
		}
			
		}
		}else{
			$this->title = "New Location";

			$this->load_template('','addLocation');
		}
        
    }
	public function manage_Location()
    {
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(84,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$this->title = "View Locations";
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
		$this->Gen->get_script_url('custom_js','deletemodal.js'),
		);
		$data['view_css']=array(
		
		);
       
		$data['locations']=$this->Base_model->getAll('tbl_locations');
        $this->load_template('','manage_locations',$data);
    }
	public function editLocation($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(85,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$data['view_scripts']=array(
		$this->Gen->get_script_url('custom_js','supplier.js'),
		);
		$data['view_css']=array(
		);
        $this->title = "Update Location";
		$data['location']=$this->Base_model->getRow('tbl_locations','','fld_id ='.$id.'');
        $this->load_template('','editlocation',$data);
	}
	public function editLocationProcess(){
		
			if($this->input->post('fld_location') != $this->input->post('orignal_location')) {
			   $is_unique =  '|is_unique[tbl_locations.fld_location]';
			} else {
			   $is_unique =  '';
			}
		
		$this->form_validation->set_rules('fld_location', 'Location name', 'required'.$is_unique);
		$this->form_validation->set_rules('fld_address', 'Address', 'required'.$is_unique);
		$location_id=$this->input->post('fld_location_id');
		if ($this->form_validation->run() == FALSE) {
		
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Common/editLocation/'.$location_id.'', TRUE, 302);
		} else {
			$data = array(
            'fld_location'=> $this->input->post('fld_location',TRUE),
			'fld_address'=> $this->input->post('fld_address',TRUE),
			'fld_updated_by'       =>  $this->session->userdata('user_id'),
			'fld_updated_date'   =>  date("Y-m-d H:i:s"),
			);
        
			
			$this->db->where('fld_id',$location_id);
			$unit=$this->db->update('tbl_locations',$data);
		if($unit){
		    /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=$this->input->post('fld_location',TRUE);
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'UPDATE',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Location updated successfully"));
            $this->output->set_header("Location: " . base_url() . 'Common/manage_Location', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Location not updated.Something went wrong"));
            $this->output->set_header("Location: " . base_url() . 'Common/editLocation/'.$location_id.'', TRUE, 302);
		}
			
		}
		
	}
	public function deleteLocation($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(86,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$location=$this->Base_model->getRow('tbl_locations','fld_id ='.$id.'');
		$responce=$this->Base_model->delete('tbl_locations','fld_id ='.$id.'');
        if($responce){
             /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=@$location['fld_location'];
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'DELETED',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Location deleted successfully"));
			$this->output->set_header("Location: " . base_url() . 'Common/manage_Location', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Location not deleted.Something went wrong"));
			$this->output->set_header("Location: " . base_url() . 'Common/manage_Location', TRUE, 302);
		}
	}
	public function addBank()
    {
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(87,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		if($this->input->post()){
			
			$this->form_validation->set_rules('fld_bank', 'Bank', 'required');
			$this->form_validation->set_rules('fld_address', 'Bank address', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Common/addBank', TRUE, 302);
		} else {
			
			$user_id= $this->session->userdata('user_id');
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
            /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=$this->input->post('fld_bank',TRUE);
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'ADD',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Bank added successfully"));
            $this->output->set_header("Location: " . base_url() . 'Common/manage_Bank', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Bank not added.Something went wrong"));
            $this->output->set_header("Location: " . base_url() . 'Common/addBank', TRUE, 302);
		}
			
		}
		}else{
			$this->title = "New Bank ";

			$this->load_template('','addBank');
		}
        
    }
	public function manage_Bank()
    {
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(88,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$this->title = "View Banks";
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
		$this->Gen->get_script_url('custom_js','deletemodal.js'),
		);
		$data['view_css']=array(
		
		);
       
		$data['banks']=$this->Base_model->getAll('tbl_banks');
        $this->load_template('','manage_bank',$data);
    }
	public function editBank($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(89,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$data['view_scripts']=array(
		$this->Gen->get_script_url('custom_js','supplier.js'),
		);
		$data['view_css']=array(
		);
        $this->title = "Update Bank";
		$data['bank']=$this->Base_model->getRow('tbl_banks','','fld_id ='.$id.'');
        $this->load_template('','editBank',$data);
	}
	
	public function editBankProcess(){
		
		if($this->input->post('fld_bank') != $this->input->post('orignal_bank')) {
			$is_unique =  '|is_unique[tbl_banks.fld_bank]';
		} else {
			$is_unique =  '';
		}
		
		$this->form_validation->set_rules('fld_bank', 'Bank name', 'required');
		$this->form_validation->set_rules('fld_address', 'Address', 'required');
		$bank_id=$this->input->post('fld_bank_id');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Common/editBank/'.$bank_id.'', TRUE, 302);
		} else {
			$data = array(
            'fld_bank'=> $this->input->post('fld_bank',TRUE),
            'fld_account_title'=> $this->input->post('fld_account_title',TRUE),
            'fld_accountnumber'=> $this->input->post('fld_accountnumber',TRUE),
			'fld_address'=> $this->input->post('fld_address',TRUE),
			'fld_updated_by'       =>  $this->session->userdata('user_id'),
			'fld_updated_date'   =>  date("Y-m-d H:i:s"),
			);
			$this->db->where('fld_id',$bank_id);
			$unit=$this->db->update('tbl_banks',$data);
			
			$acc_data = array(
              'head_name'       =>  $data['fld_bank'].' - '. $data['fld_account_title'].'. '. '('.$data['fld_accountnumber'].')',
             ); 
             
            $this->db->update('tbl_coa', $acc_data, array('type'=>'BANK', 'type_id' => $bank_id));
            
		if($unit){
		     /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=$this->input->post('fld_bank',TRUE);
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'UPDATE',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Bank updated successfully"));
            $this->output->set_header("Location: " . base_url() . 'Common/manage_Bank', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Bank not updated.Something went wrong"));
            $this->output->set_header("Location: " . base_url() . 'Common/editBank/'.$bank_id.'', TRUE, 302);
		}
		}
	}
	
	public function deleteBank($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(90,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$bank=$this->Base_model->getRow('tbl_banks','fld_id ='.$id.'');
		$responce=$this->Base_model->delete('tbl_banks','fld_id ='.$id.'');
        if($responce){
            /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=@$bank['fld_bank'];
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'DELETED',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Bank deleted successfully"));
			$this->output->set_header("Location: " . base_url() . 'Common/manage_Bank', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Bank not deleted.Something went wrong"));
			$this->output->set_header("Location: " . base_url() . 'Common/manage_Bank', TRUE, 302);
		}
	}
	
	public function addTransporter()
    {
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(91,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
// 		$data1['view_scripts']=array(
		    
// 		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
// 		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'),
// 		$this->Gen->get_script_url('','https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js'),
// 		);
// 		$data1['view_css']=array(
// 		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
// 		);
        $data1['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
// 		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'),
// 		$this->Gen->get_script_url('','https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
		$this->Gen->get_script_url('custom_js','jquery.validate.js'),
		);
		$data1['view_css']=array(
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
// 		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'),
		
        $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(91,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		if($this->input->post()){
		
			$user_id= $this->session->userdata('user_id');
			$data = array(
				'fld_userid' => $user_id,
				'fld_vehicle_number'=> $this->input->post('fld_vehicle_number',TRUE),
				'fld_owner_name'=> $this->input->post('fld_owner_name',TRUE),
				'fld_dname1'=> $this->input->post('fld_dname1'),
				'fld_dcnic1'=> $this->input->post('fld_dcnic1'),
				'fld_daddress1'=> $this->input->post('fld_daddress1'),
				'fld_dmobile1'=> $this->input->post('fld_dmobile1'),
				'fld_dlicense1'=> $this->input->post('fld_dlicense1'),
				'fld_dname2'=> $this->input->post('fld_dname2'),
				'fld_dcnic2'=> $this->input->post('fld_dcnic2'),
				'fld_daddress2'=> $this->input->post('fld_daddress2'),
				'fld_dmobile2'=> $this->input->post('fld_dmobile2'),
				'fld_dlicense2'=> $this->input->post('fld_dlicense2'),
				
				'fld_dlicense_issue1' => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('fld_dlicense_issue1',TRUE)))),
				'fld_dlicense_expire1' => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('fld_dlicense_expire1',TRUE)))),
				
				'fld_dlicense_issue2' => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('fld_dlicense_issue2',TRUE)))),
				'fld_dlicense_expire2' => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('fld_dlicense_expire2',TRUE)))),
				
				'fld_type'=> $this->input->post('fld_vehicle_type',TRUE),
				'fld_area' => $this->input->post('fld_area',TRUE),
			);
			
			
			$unit=$this->db->insert('tbl_transporter',$data);
			
			$trans_id=$this->db->insert_id();
            
           
            $account_id = 401007;
            
            
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
              'head_name'       =>  $data['fld_vehicle_number'].'('.$data['fld_owner_name'].')',
              'parent_head_name'      =>  $getHeadCodeData->head_name,
              'head_level'      =>  $newlevel,
              'type'            => 'VEHICLE',
              'type_id'         => $trans_id
            ); 
           
            
            $this->db->insert('tbl_coa',$acc_data);
            
            
            
            $this->db->query("UPDATE tbl_transporter SET accounts_id='$HeadCode' WHERE fld_id = '$trans_id'");
			if($unit){
			     /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=$this->input->post('fld_vehicle_number',TRUE);
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'ADD',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
				$this->session->set_userdata(array('success_message' => "Transporter added successfully"));
				$this->output->set_header("Location: " . base_url() . 'Common/manage_Transporter', TRUE, 302);
			}else{
				$this->session->set_userdata(array('error_message' => "Transporter not added.Something went wrong"));
				$this->output->set_header("Location: " . base_url() . 'Common/addTransporter', TRUE, 302);
			}
		
		}else{
			$this->title = "New Transporter";
			$this->load_template('','addTransporter',$data1);
		}
    }
    
	public function manage_Transporter()
    {
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(92,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$this->title = "View Transporters/Bowsers";
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','moment/moment.js'),    
		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
		$this->Gen->get_script_url('custom_js','settings.js'),
		);
		$data['view_css']=array(
		
		);
		$data['transporter']=$this->Base_model->getAll('tbl_transporter','','fld_isdeleted=0');
        $this->load_template('','manageTransporter',$data);
    }
	public function deleteTransporter($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(94,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$upd=array("fld_isdeleted"=>1);
		$transport=$this->Base_model->getRow('tbl_transporter',$upd,'fld_id ='.$id.'');
		$responce=$this->Base_model->update('tbl_transporter',$upd,'fld_id ='.$id.'');
        if($responce){
            /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=@$transport['fld_vehicle_number'];
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'DELETED',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Transporter deleted successfully"));
			$this->output->set_header("Location: " . base_url() . 'Common/manage_Transporter', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Transporter not deleted.Something went wrong"));
			$this->output->set_header("Location: " . base_url() . 'Common/manage_Transporter', TRUE, 302);
		}
	}
	public function editTransporter($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
// 		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'),
// 		$this->Gen->get_script_url('','https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
		$this->Gen->get_script_url('custom_js','jquery.validate.js'),
		);
		$data['view_css']=array(
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
// 		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'),
		
        $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(93,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
        $this->title = "Update Bowser";
		$data['transporter']=$this->Base_model->getRow('tbl_transporter','','fld_id ='.$id.'');
        $this->load_template('','editTransporter',$data);
	}
	public function editTransprocess(){
		
		$transporter_id=$this->input->post('transporter_id');
		
			$data = array(
			    'fld_vehicle_number'=> $this->input->post('fld_vehicle_number',TRUE),
				'fld_owner_name'=> $this->input->post('fld_owner_name',TRUE),
				'fld_dname1'=> $this->input->post('fld_dname1'),
				'fld_dcnic1'=> $this->input->post('fld_dcnic1'),
				'fld_daddress1'=> $this->input->post('fld_daddress1'),
				'fld_dmobile1'=> $this->input->post('fld_dmobile1'),
				'fld_dlicense1'=> $this->input->post('fld_dlicense1'),
				'fld_dname2'=> $this->input->post('fld_dname2'),
				'fld_dcnic2'=> $this->input->post('fld_dcnic2'),
				'fld_daddress2'=> $this->input->post('fld_daddress2'),
				'fld_dmobile2'=> $this->input->post('fld_dmobile2'),
				'fld_dlicense2'=> $this->input->post('fld_dlicense2'),
				
				'fld_dlicense_issue1' => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('fld_dlicense_issue1',TRUE)))),
				'fld_dlicense_expire1' => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('fld_dlicense_expire1',TRUE)))),
				
				'fld_dlicense_issue2' => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('fld_dlicense_issue2',TRUE)))),
				'fld_dlicense_expire2' => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('fld_dlicense_expire2',TRUE)))),
				
				'fld_type'=> $this->input->post('fld_vehicle_type',TRUE),
				'fld_area' => $this->input->post('fld_area',TRUE),
				'fld_updated_by'       =>  $this->session->userdata('user_id'),
			'fld_updated_date'   =>  date("Y-m-d H:i:s"),
			);
			$this->db->where('fld_id',$transporter_id);
			$unit=$this->db->update('tbl_transporter',$data);
		if($unit){
		    /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=$this->input->post('fld_vehicle_number',TRUE);
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'UPDATE',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Transporter updated successfully"));
            $this->output->set_header("Location: " . base_url() . 'Common/manage_Transporter', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Transporter not updated.Something went wrong"));
            $this->output->set_header("Location: " . base_url() . 'Common/editTransporter/'.$transporter_id.'', TRUE, 302);
		}
		
	}
	
	// Department Management
	public function addDepartment()
    {
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(95,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		if($this->input->post()){
			$this->form_validation->set_rules('department_name', 'Name', 'required|is_unique[tbl_departments.department_name]');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Common/addDepartment', TRUE, 302);
		} else {
			$user_id= $this->session->userdata('user_id');
			$data = array(
            'department_name'=> $this->input->post('department_name',TRUE),
            'department_detail'=> $this->input->post('department_detail',TRUE),
            'deleted' => 0
        );
        $unit=$this->db->insert('tbl_departments',$data);
		if($unit){
		    /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=$this->input->post('department_name',TRUE);
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'ADD',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Department added successfully"));
            $this->output->set_header("Location: " . base_url() . 'Common/manage_departments', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Location not added.Something went wrong"));
            $this->output->set_header("Location: " . base_url() . 'Common/addDepartment', TRUE, 302);
		}
			
		}
		}else{
			$this->title = "New Department ";
			$this->load_template('','add_department');
		}
        
    }
	public function manage_departments()
    {
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(96,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$this->title = "View Departments";
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
		$this->Gen->get_script_url('custom_js','deletemodal.js'),
		);
		$data['view_css']=array(
		
		);
       
		$data['departments']=$this->Base_model->getAll('tbl_departments');
        $this->load_template('','manage_departments',$data);
    }
	public function editDepartment($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(97,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$data['view_scripts']=array(
		$this->Gen->get_script_url('custom_js','supplier.js'),
		);
		$data['view_css']=array(
		
		);
        $this->title = "Update Department";
		$data['depart']=$this->Base_model->getRow('tbl_departments','','id ='.$id.'');
        $this->load_template('','edit_department',$data);
	}
	public function editDepartmentProcess(){
		
// 		if($this->input->post('fld_location') != $this->input->post('orignal_location')) {
// 			$is_unique =  '|is_unique[tbl_locations.fld_location]';
// 		} else {
// 			$is_unique =  '';
// 		}
		
		$this->form_validation->set_rules('department_name', 'Department name', 'required');
		$depart_id = $this->input->post('id');
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Common/editDepartment/'.$depart_id.'', TRUE, 302);
		} else {
			$data = array(
            'department_name'=> $this->input->post('department_name',TRUE),
			'department_detail'=> $this->input->post('department_detail',TRUE),
			'fld_updated_by'       =>  $this->session->userdata('user_id'),
			'fld_updated_date'   =>  date("Y-m-d H:i:s"),
		);
			$this->db->where('id',$depart_id);
			$unit=$this->db->update('tbl_departments',$data);
		if($unit){
		    /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=$this->input->post('department_name',TRUE);
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'UPDATE',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Department updated successfully"));
            $this->output->set_header("Location: " . base_url() . 'Common/manage_departments', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Department not updated.Something went wrong"));
            $this->output->set_header("Location: " . base_url() . 'Common/editDepartment/'.$depart_id.'', TRUE, 302);
		}
		}
		
	}
	public function deleteDepartment($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(98,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$dep=$this->Base_model->getRow('tbl_departments','id ='.$id.'');
		$responce=$this->Base_model->delete('tbl_departments','id ='.$id.'');
        if($responce){
            /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=$dep['department_name'];
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'DELETED',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Department deleted successfully"));
			$this->output->set_header("Location: " . base_url() . 'Common/manage_departments', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Department not deleted.Something went wrong"));
			$this->output->set_header("Location: " . base_url() . 'Common/manage_departments', TRUE, 302);
		}
	}
	
	
	// Designations Management
	public function addDesignation()
    {
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(99,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		if($this->input->post()){
			$this->form_validation->set_rules('designation_name', 'Name', 'required|is_unique[tbl_designation.designation_name]');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Common/addDesignation', TRUE, 302);
		} else {
			$user_id= $this->session->userdata('user_id');
			$data = array(
            'designation_name'=> $this->input->post('designation_name',TRUE),
            'designation_detail'=> $this->input->post('designation_detail',TRUE),
            'deleted' => 0
        );
        $unit=$this->db->insert('tbl_designation',$data);
		if($unit){
		    /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=$this->input->post('designation_name',TRUE);
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'ADD',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Designation added successfully"));
            $this->output->set_header("Location: " . base_url() . 'Common/manage_designations', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Designation not added.Something went wrong"));
            $this->output->set_header("Location: " . base_url() . 'Common/addDesignation', TRUE, 302);
		}
		}
		}else{
			$this->title = "New Designation";
			$this->load_template('','add_designation');
		}
        
    }
	public function manage_designations()
    {
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(100,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$this->title = "View Designations";
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
		$this->Gen->get_script_url('custom_js','deletemodal.js'),
		);
		$data['view_css']=array(
		
		);
		$data['designations']=$this->Base_model->getAll('tbl_designation');
        $this->load_template('','manage_designations',$data);
    }
	public function editDesignation($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(101,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$data['view_scripts']=array(
		$this->Gen->get_script_url('custom_js','supplier.js'),
		);
		$data['view_css']=array(
		
		);
        $this->title = "Update Designation";
		$data['desig']=$this->Base_model->getRow('tbl_designation','','id ='.$id.'');
        $this->load_template('','edit_designation',$data);
	}
	
	public function editDesignationProcess(){
		
// 			if($this->input->post('fld_location') != $this->input->post('orignal_location')) {
// 			   $is_unique =  '|is_unique[tbl_locations.fld_location]';
// 			} else {
// 			   $is_unique =  '';
// 			}
		
		$this->form_validation->set_rules('designation_name', 'Designation name', 'required');
		$desig_id = $this->input->post('id');
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Common/editDesignation/'.$desig_id.'', TRUE, 302);
		} else {
			$data = array(
            'designation_name'=> $this->input->post('designation_name',TRUE),
			'designation_detail'=> $this->input->post('designation_detail',TRUE),
			'fld_updated_by'       =>  $this->session->userdata('user_id'),
			'fld_updated_date'   =>  date("Y-m-d H:i:s"),
		);
			$this->db->where('id',$desig_id);
			$unit=$this->db->update('tbl_designation',$data);
		if($unit){
		      /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=$this->input->post('designation_name',TRUE);
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'UPDATE',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Designation updated successfully"));
            $this->output->set_header("Location: " . base_url() . 'Common/manage_designations', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Designation not updated.Something went wrong"));
            $this->output->set_header("Location: " . base_url() . 'Common/editDesignation/'.$desig_id.'', TRUE, 302);
		}
			
		}
		
	}
	public function deleteDesignation($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(102,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$designation=$this->Base_model->getRow('tbl_designation','id ='.$id.'');
		$responce=$this->Base_model->delete('tbl_designation','id ='.$id.'');
        if($responce){
              /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=$designation['designation_name'];
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'DELETED',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Designation deleted successfully"));
			$this->output->set_header("Location: " . base_url() . 'Common/manage_designations', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Designation not deleted.Something went wrong"));
			$this->output->set_header("Location: " . base_url() . 'Common/manage_designations', TRUE, 302);
		}
	}
	
	
	// Shifts Management
	public function addShift()
    {
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(103,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		if($this->input->post()){
			$this->form_validation->set_rules('shift_name', 'Name', 'required|is_unique[tbl_shifts.shift_name]');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Common/addShift', TRUE, 302);
		} else {
			
			$user_id= $this->session->userdata('user_id');
			$data = array(
            'shift_name'=> $this->input->post('shift_name',TRUE),
            'shift_detail'=> $this->input->post('shift_detail',TRUE),
            'fld_created_date'   =>  date("Y-m-d H:i:s"),
            'deleted' => 0
        );
        
        $unit=$this->db->insert('tbl_shifts',$data);
		if($unit){
		      /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=$this->input->post('shift_name',TRUE);
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'ADD',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Shift added successfully"));
            $this->output->set_header("Location: " . base_url() . 'Common/manage_shifts', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Shift not added.Something went wrong"));
            $this->output->set_header("Location: " . base_url() . 'Common/addShift', TRUE, 302);
		}
		}
		}else{
			$this->title = "New Shift";
			$this->load_template('','add_shift');
		}
        
    }
	public function manage_shifts()
    {
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(104,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$this->title = "View Shifts ";
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
		$this->Gen->get_script_url('custom_js','supplier.js'),
		$this->Gen->get_script_url('custom_js','deletemodal.js'),
		);
		$data['view_css']=array(
		
		);
		$data['shifts']=$this->Base_model->getAll('tbl_shifts');
        $this->load_template('','manage_shifts',$data);
    }
	public function editShift($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(105,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$data['view_scripts']=array(
		$this->Gen->get_script_url('custom_js','supplier.js'),
		);
		$data['view_css']=array(
		
		);
        $this->title = "Update Shift";
		$data['shift']=$this->Base_model->getRow('tbl_shifts','','id ='.$id.'');
        $this->load_template('','edit_shift',$data);
	}
	public function editshiftProcess(){
		
		$this->form_validation->set_rules('shift_name', 'Shift name', 'required');
		$shift_id = $this->input->post('id');
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Common/editShift/'.$shift_id.'', TRUE, 302);
		} else {
			$data = array(
            'shift_name'=> $this->input->post('shift_name',TRUE),
			'shift_detail'=> $this->input->post('shift_detail',TRUE),
			'fld_updated_by'       =>  $this->session->userdata('user_id'),
			'fld_updated_date'   =>  date("Y-m-d H:i:s"),
		);
			
			$this->db->where('id',$shift_id);
			$unit=$this->db->update('tbl_shifts',$data);
		if($unit){
		     /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=$this->input->post('shift_name',TRUE);
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'UPDATE',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Shift updated successfully"));
            $this->output->set_header("Location: " . base_url() . 'Common/manage_shifts', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Shift not updated.Something went wrong"));
            $this->output->set_header("Location: " . base_url() . 'Common/editShift/'.$shift_id.'', TRUE, 302);
		}
		}
	}
	
	public function deleteShift($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(106,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$shift=$this->Base_model->getRow('tbl_shifts','id ='.$id.'');
		$responce=$this->Base_model->delete('tbl_shifts','id ='.$id.'');
        if($responce){
             /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=$shift['shift_name'];
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'DELETED',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Shift deleted successfully"));
			$this->output->set_header("Location: " . base_url() . 'Common/manage_shifts', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Shift not deleted.Something went wrong"));
			$this->output->set_header("Location: " . base_url() . 'Common/manage_shifts', TRUE, 302);
		}
	}
	
	
	// Stationary management
	public function addStationary()
    {
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(132,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		if($this->input->post()){
		   $this->form_validation->set_rules('name', 'Name', 'required');
		   $this->form_validation->set_rules('fld_unit', 'Unit', 'required');
		if ($this->form_validation->run() == FALSE) {
		
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Common/addStationary', TRUE, 302);
		} else {
			//$user_id= $this->session->userdata('user_id');
			$data = array(
            //'fld_userid' => $user_id,
            'name'=> $this->input->post('name',TRUE),
            'fld_unit'=> $this->input->post('fld_unit',TRUE),
            'status' => 1
        );
        
        $stationary = $this->db->insert('tbl_stationary',$data);
		if($stationary){
		     /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=$this->input->post('name',TRUE);
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'ADD',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Stationary added successfully"));
            $this->output->set_header("Location: " . base_url() . 'Common/manage_stationary', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Stationary not added.Something went wrong"));
            $this->output->set_header("Location: " . base_url() . 'Common/addStationary', TRUE, 302);
		}
			
		}
		}else{
			$this->title = "New Expense Item";
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
            $data['units']=$this->Base_model->getAll('tbl_units');
			$this->load_template('','addStationary',$data);
		}
        
    }
	public function manage_stationary()
    {
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(133,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$this->title = "View Expense Items ";
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
		$this->Gen->get_script_url('custom_js','stationary.js'),
		);
		$data['view_css']=array(
		
		);
       
		$data['stationary']=$this->Base_model->getAll('tbl_stationary');
        $this->load_template('','manage_stationary',$data);
    }
	public function editStationary($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(168,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
			$data['view_scripts']=array(
		$this->Gen->get_script_url('custom_js','supplier.js'),
		);
		$data['view_css']=array(
		
		);
        $this->title = "Update Expense Item ";
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
		$data['stationary']=$this->Base_model->getRow('tbl_stationary','','id ='.$id.'');
		$data['units']=$this->Base_model->getAll('tbl_units');
        $this->load_template('','editStationary',$data);
	}
	public function editStationaryProcess(){
		
		if($this->input->post('name') != $this->input->post('orignal_name')) {
		   $is_unique =  '|is_unique[tbl_stationary.name]';
		} else {
		   $is_unique =  '';
		}
		
		$this->form_validation->set_rules('name', 'Name', 'required'.$is_unique);
		$stationary_id=$this->input->post('id');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Common/editStationary/'.$stationary_id.'', TRUE, 302);
		} else {
			$data = array(
              'name'=> $this->input->post('name',TRUE),
              'fld_unit'=> $this->input->post('fld_unit',TRUE),
              'fld_updated_by'       =>  $this->session->userdata('user_id'),
			  'fld_updated_date'   =>  date("Y-m-d H:i:s"),
			);
			$this->db->where('id',$stationary_id);
			$unit=$this->db->update('tbl_stationary',$data);
		if($unit){
		     /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=$this->input->post('name',TRUE);
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'UPDATE',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Stationary updated successfully"));
            $this->output->set_header("Location: " . base_url() . 'Common/manage_stationary', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Stationary not updated.Something went wrong"));
            $this->output->set_header("Location: " . base_url() . 'Common/editStationary/'.$stationary_id.'', TRUE, 302);
		}
		}
	}
	
	public function deleteStationary($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(169,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$Stationary=$this->Base_model->getRow('tbl_stationary','id ='.$id.'');
		$responce=$this->Base_model->delete('tbl_stationary','id ='.$id.'');
        if($responce){
             /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=$Stationary['name'];
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'DELETED',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Stationary deleted successfully"));
			$this->output->set_header("Location: " . base_url() . 'Common/manage_stationary', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Stationary not deleted.Something went wrong"));
			$this->output->set_header("Location: " . base_url() . 'Common/manage_stationary', TRUE, 302);
		}
	}
	
	
	// add refinery
	
	public function addRefinery()
    {
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(122,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		if($this->input->post()){
			$this->form_validation->set_rules('fld_name', 'Refinery Name', 'required|is_unique[tbl_refinery.fld_name]');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Common/addRefinery', TRUE, 302);
		} else {
			$user_id= $this->session->userdata('user_id');
			$data = array(
                'fld_userid' => $user_id,
                'fld_name'=> $this->input->post('fld_name',TRUE),
                'fld_address'=> $this->input->post('fld_address',TRUE),
                'fld_status' => 1
        );
        $refinery = $this->db->insert('tbl_refinery',$data);
		if($refinery){
		     /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=$this->input->post('fld_name',TRUE);
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'ADD',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Refinery added successfully"));
            $this->output->set_header("Location: " . base_url() . 'Common/manage_Refinery', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Refinery not added.Something went wrong"));
            $this->output->set_header("Location: " . base_url() . 'Common/addRefinery', TRUE, 302);
		}
		}
		}else{
			$this->title = "New Refinery ";
			$this->load_template('','addRefinery');
		}
    }
    
	public function manage_Refinery()
    {
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(123,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$this->title = "View Refinery ";
		$data['view_scripts']=array(
		    $this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		    $this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		    $this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
		    $this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		    $this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
		    $this->Gen->get_script_url('custom_js','deletemodal.js'),
		);
		$data['view_css']=array(
		
		);
		$data['refinery']=$this->Base_model->getAll('tbl_refinery');
        $this->load_template('','manage_refinery',$data);
    }
    
	public function editRefinery($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(124,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
			$data['view_scripts']=array(
		$this->Gen->get_script_url('custom_js','supplier.js'),
		);
		$data['view_css']=array(
		
		);
        $this->title = "Update Refinery";
		$data['refinery']=$this->Base_model->getRow('tbl_refinery','','fld_id ='.$id.'');
        $this->load_template('','editRefinery',$data);
	}
	
	public function editRefineryProcess(){
		
		if($this->input->post('fld_name') != $this->input->post('orignal_name')) {
			$is_unique =  '|is_unique[tbl_refinery.fld_name]';
		} else {
		    $is_unique =  '';
		}
		$this->form_validation->set_rules('fld_name', 'Refinery Name', 'required'.$is_unique);
		$fld_refinery_id = $this->input->post('fld_refinery_id');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Common/editRefinery/'.$fld_refinery_id.'', TRUE, 302);
		} else {
			$data = array(
            'fld_name'=> $this->input->post('fld_name',TRUE),
            'fld_address'=> $this->input->post('fld_address',TRUE),
             'fld_updated_by'       =>  $this->session->userdata('user_id'),
			'fld_updated_date'   =>  date("Y-m-d H:i:s"),
			);
			$this->db->where('fld_id',$fld_refinery_id);
			$refinery = $this->db->update('tbl_refinery',$data);
		if($refinery){
		    /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=$this->input->post('fld_name',TRUE);
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'UPDATE',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Refinery updated successfully"));
            $this->output->set_header("Location: " . base_url() . 'Common/manage_Refinery', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Refinery not updated.Something went wrong"));
            $this->output->set_header("Location: " . base_url() . 'Common/editRefinery/'.$fld_refinery_id.'', TRUE, 302);
		}
		}
	}
	
	public function deleteRefinery($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(125,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$refinery = $this->Base_model->getRow('tbl_refinery','fld_id ='.$id.'');
		$responce = $this->Base_model->delete('tbl_refinery','fld_id ='.$id.'');
        if($responce){
            /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=$refinery['fld_name'];
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'DELETED',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Refinery deleted successfully"));
			$this->output->set_header("Location: " . base_url() . 'Common/manage_Refinery', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Refinery not deleted. Something went wrong"));
			$this->output->set_header("Location: " . base_url() . 'Common/manage_Refinery', TRUE, 302);
		}
	}
	
	
	
	//Expense group Start
	public function addexpensegroup()
    {
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
// 		$role_permissions  = explode(",",$this->session->userdata('permissions'));
// 		if(!empty($role_permissions) && !in_array(103,$role_permissions)) {
// 			$this->session->set_userdata(array('error_message' => "Access Denied!"));
// 			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
// 		}
		if($this->input->post()){
			$this->form_validation->set_rules('expense_group_name', 'Name', 'required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Common/addexpensegroup', TRUE, 302);
		} else {
			
			$user_id= $this->session->userdata('user_id');
			$data = array(
            'expense_group_name'=> $this->input->post('expense_group_name',TRUE),
            'added_date'   =>  date("Y-m-d H:i:s"),
            'fld_isdeleted' => 0
        );
        
        $unit=$this->db->insert('tbl_expense_group',$data);
		if($unit){
		      /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=$this->input->post('shift_name',TRUE);
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'ADD',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Expense group added successfully"));
            $this->output->set_header("Location: " . base_url() . 'Common/view_expensegroup', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Expense group  not added.Something went wrong"));
            $this->output->set_header("Location: " . base_url() . 'Common/addexpensegroup', TRUE, 302);
		}
		}
		}else{
			$this->title = "New Expense Group";
			$this->load_template('','expenses/addexpensegroup');
		}
        
    }
	public function view_expensegroup()
    {
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
// 		$role_permissions  = explode(",",$this->session->userdata('permissions'));
// 		if(!empty($role_permissions) && !in_array(104,$role_permissions)) {
// 			$this->session->set_userdata(array('error_message' => "Access Denied!"));
// 			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
// 		}
		$this->title = "View Expense Group ";
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
 		$this->Gen->get_script_url('custom_js','expensegroup.js'),
		);
		$data['view_css']=array(
		
		);
		$data['shifts']=$this->Base_model->getAll('tbl_expense_group');
        $this->load_template('','expenses/view_expensegroup',$data);
    }
	public function edit_expensegroup($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
// 		$role_permissions  = explode(",",$this->session->userdata('permissions'));
// 		if(!empty($role_permissions) && !in_array(105,$role_permissions)) {
// 			$this->session->set_userdata(array('error_message' => "Access Denied!"));
// 			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
// 		}
		$data['view_scripts']=array(
// 		$this->Gen->get_script_url('custom_js','supplier.js'),
		);
		$data['view_css']=array(
		
		);
        $this->title = "Update Expense Group";
		$data['shift']=$this->Base_model->getRow('tbl_expense_group','','id ='.$id.'');
        $this->load_template('','expenses/edit_expensegroup',$data);
	}
	public function edit_expensegroupProcess(){
		
		$this->form_validation->set_rules('expense_group_name', 'Name', 'required');
		$expensegroup = $this->input->post('id');
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Common/edit_expensegroup/'.$expensegroup.'', TRUE, 302);
		} else {
			$data = array(
            'expense_group_name'=> $this->input->post('expense_group_name',TRUE),
			'fld_updated_by'       =>  $this->session->userdata('user_id'),
			'fld_updated_date'   =>  date("Y-m-d H:i:s"),
		);
			
			$this->db->where('id',$expensegroup);
			$unit=$this->db->update('tbl_expense_group',$data);
		if($unit){
		     /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=$this->input->post('shift_name',TRUE);
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'UPDATE',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Expense group updated successfully"));
            $this->output->set_header("Location: " . base_url() . 'Common/view_expensegroup', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Expense group not updated.Something went wrong"));
            $this->output->set_header("Location: " . base_url() . 'Common/edit_expensegroup/'.$expensegroup.'', TRUE, 302);
		}
		}
	}
	
	public function deleteexpensegroup($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
// 		$role_permissions  = explode(",",$this->session->userdata('permissions'));
// 		if(!empty($role_permissions) && !in_array(106,$role_permissions)) {
// 			$this->session->set_userdata(array('error_message' => "Access Denied!"));
// 			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
// 		}
		$expensegroup=$this->Base_model->getRow('tbl_expense_group','id ='.$id.'');
		$responce=$this->Base_model->delete('tbl_expense_group','id ='.$id.'');
        if($responce){
             /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=$shift['shift_name'];
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'DELETED',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Expense group deleted successfully"));
			$this->output->set_header("Location: " . base_url() . 'Common/view_expensegroup', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Expense group not deleted.Something went wrong"));
			$this->output->set_header("Location: " . base_url() . 'Common/view_expensegroup', TRUE, 302);
		}
	}
	//Expense group End
	
	// Expense Types

public function expense_type()
    {
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
        $role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(166,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
        $this->title = "Add Expense Type | ".$this->title;
		$data['view_scripts'] = array(
		  $this->Gen->get_script_url('plugin_components','moment/moment.js'),
		  $this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		  $this->Gen->get_script_url('custom_js','jquery.validate.js'),
		  $this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
		  $this->Gen->get_script_url('custom_js','expenses.js'),
		);
		
		$data['view_css']=array(
		  $this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
		  $this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'),
		  $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
		
        $this->load_template('','expenses/expensetype',$data);
    }
    
public function addexpenseType(){
	    
	    if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}

		//$this->form_validation->set_rules('fld_category', 'Category', 'required|is_unique[tbl_category.fld_category]');
		$this->form_validation->set_rules('expense_type', 'Expense Type', 'required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Common/expense_type', TRUE, 302);
		} else {
			//$user_id= $this->session->userdata('user_id');
			$expValue1 = $this->input->post('expense_value1');
			$expValue2 = $this->input->post('expense_value2');
			if(!empty($expValue1)){
			    $value = $expValue1;
			}else{
			    $value = $expValue2; 
			}
			//echo $value;exit;
			$data = array(
            //'fld_userid' => $user_id,
            'expense_type'=> $this->input->post('expense_type',TRUE),
            'expense_value'=> $value,
            'fld_isdeleted' => 0,
        );
        $this->db->set('added_date', 'NOW()', FALSE);
        $exptype=$this->db->insert('tbl_expense_type',$data);
		if($exptype){
		     /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=$value;
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'ADD',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Expense Type added successfully"));
            $this->output->set_header("Location: " . base_url() . 'Common/manage_Expensetypes', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Expense Type not added.Something went wrong"));
            $this->output->set_header("Location: " . base_url() . 'Common/expense_type', TRUE, 302);
		}
			
		}
	} 
	
	public function manage_Expensetypes()
    {

		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(167,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$this->title = "Manage Expense Types | ".$this->title;
		$data['view_scripts']=array(
    		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
    		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
    		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		    $this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		    $this->Gen->get_script_url('plugin_components','timepicker/bootstrap-material-datetimepicker.js'),
		);
		
		$data['view_css']=array(
		    $this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'),
		    $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		    $this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
		    $this->Gen->get_script_url('plugin_components','timepicker/bootstrap-material-datetimepicker.css'),
		);
		
		$data['expensetypes']= $this->Base_model->getAll('tbl_expense_type', '', array('fld_isdeleted'=>0), '');
        $this->load_template('','expenses/manage_expensetypes',$data);
    }
    
    public function deletetype($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(169,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$expence=$this->Base_model->getRow('tbl_expense_type','id ='.$id.'');
		$responce=$this->Base_model->delete('tbl_expense_type','id ='.$id.'');
        if($responce){
              /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=$expence['expense_value'];
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'DELETED',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Expense Type deleted successfully"));
			$this->output->set_header("Location: " . base_url() . 'Common/manage_Expensetypes', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Expense Type not deleted.Something went wrong"));
			$this->output->set_header("Location: " . base_url() . 'Common/manage_Expensetypes', TRUE, 302);
		}
	}
	
	public function edittype($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(168,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		
        $this->title = "Update Expense Type | ".$this->title;
		$data['exptype']=$this->Base_model->getRow('tbl_expense_type','','id ='.$id.'');

		$data['view_scripts']=array(
		    $this->Gen->get_script_url('custom_js','supplier.js'),
// 		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
// 		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
// 		$this->Gen->get_script_url('custom_js','jquery.validate.js'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
		
		);
		$data['view_css']=array(
// 		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
// 		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'),
        $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);

        $this->load_template('','expenses/edittype',$data);
	}
	
	public function edittypeProcess(){
		
		if($this->input->post('expense_value') != $this->input->post('orignal_value')) {
		    $is_unique =  '|is_unique[tbl_expense_type.expense_value]';
		} else {
			$is_unique =  '';
		}
		
		$this->form_validation->set_rules('expense_value', 'Expense Value', 'required'.$is_unique);
		$this->form_validation->set_rules('expense_type', 'Expense Type', 'required');

		$id=$this->input->post('id');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Common/edittype/'.$id.'', TRUE, 302);
		} else {
			$data = array(
                'expense_type'=> $this->input->post('expense_type',TRUE),
                'expense_value'=> $this->input->post('expense_value',TRUE),
                'fld_updated_by'       =>  $this->session->userdata('user_id'),
			'fld_updated_date'   =>  date("Y-m-d H:i:s"),
			);
			
			$this->db->where('id',$id);
			$exptype=$this->db->update('tbl_expense_type',$data);
		if($exptype){
		     /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
    	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata('user_id');
		$partner=$this->input->post('expense_value',TRUE);
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'UPDATE',fld_detail='$partner',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Expense type updated successfully"));
            $this->output->set_header("Location: " . base_url() . 'Common/manage_Expensetypes', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Expense type not updated.Something went wrong"));
            $this->output->set_header("Location: " . base_url() . 'Common/edittype/'.$id.'', TRUE, 302);
		}
			
		}
		
	}

}
