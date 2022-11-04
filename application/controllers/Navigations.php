<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Navigations extends My_controller {
	
	function __construct() { 
        parent::__construct(); 
        $this->load->model('Navigations_model'); 
        $this->load->model('Suplier_model'); 
        $this->load->model('Purchase_model');
        $this->load->model('Common_model');
    }
	
	public function index()
    {
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(12,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$this->title = "Intransit Navigations";
		//$data['purchases']=$this->Navigations_model->getAllPurchases();
		$data['category']=$this->Purchase_model->getAllProducts('tbl_category');
		$data['transporter']=$this->Base_model->getAll('tbl_transporter');
		$data['intransit_purch']=$this->Navigations_model->getAllInTransitPurch();
	
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'), 
		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
		);
		// echo '<pre>';
		// print_r($data['intransit_purch']);exit;
		$this->load_template('','manage_pending_navigation',$data);
    }
	public function create_navigation($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(15,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
        $this->title = "New Navigation";
        $sid=$this->uri->segment(4);
		$data['supplier']=$this->Base_model->getAll('tbl_suppliers');
		$data['transporter']=$this->Base_model->getAll('tbl_transporter');
		$data['banks']=$this->Base_model->getAll('tbl_banks');
		$data['category']=$this->Purchase_model->getAllProducts('tbl_category');
		$data['locations']=$this->Base_model->getAll('tbl_locations', '', "fld_id <> 8", '');
		$data['units']=$this->Base_model->getAll('tbl_units');
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
		$this->Gen->get_script_url('custom_js','purchase.js'),
		$this->Gen->get_script_url('custom_js','navigation.js'),
		$this->Gen->get_script_url('custom_js','jquery.validate.js'),
		);
		$data['view_css']=array(
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
		$data['purchase']=$this->Navigations_model->getInTranPurchByID($id,$sid);
// 		print_r($data['purchase']);
// 		exit();
		$maxID=$this->Navigations_model->getMaxID();
		$data['maxid']=sprintf('%04d', $maxID['Auto_increment']);
		$data['id']=$id;
		// echo '<pre>';
		// print_r($data['purchase']);
		// exit;
        $this->load_template('','createNavigation',$data);
	}
	public function create(){
	
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(17,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$navigation=$this->Navigations_model->navigation_entry();
		 if(isset($_POST['add_navigationdraft'])){
            $did = $_POST['navigation_id'];
            $this->db->where('fld_id', $did);
            $this->db->delete('tbl_navigations_draft');
            $this->db->where('fld_navigation_id', $did);
            $this->db->delete('tbl_navigations_draft_details');
            redirect(base_url('Navigations/manage_drafts'));
        }
		if (isset($_POST['add-navigation'])) {
            redirect(base_url('Navigations/manage'));
        }
	}
	
	
	public function manage()
    {
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(14,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		
		$this->title = "View Navigations";
		$data['navigations']=$this->Navigations_model->getAllNavigations();
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
		$this->Gen->get_script_url('custom_js','navigation.js'),
		);
		// echo '<pre>';
		// print_r($data['navigations']);
		// exit;
		$this->load_template('','manage_navigation',$data);
    }
    
    
    
	public function edit($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(15,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		
		$navDetails = $this->db->query("SELECT * FROM `tbl_navigations_details` where fld_navigation_id = '$id'")->result_array();
		$allowDelete = true;
		foreach($navDetails as $nav){
		    $saleCheck = $this->db->query("SELECT * FROM tbl_sale_detail WHERE fld_stock_location_id = '{$nav['fld_stock_loc_id']}'")->num_rows();
		    if($saleCheck > 0){
		        $allowDelete = false;
		    }
		    
		    $navCheck = $this->db->query("SELECT * FROM tbl_stock_locations WHERE fld_parent_id = '{$nav['fld_stock_loc_id']}'")->num_rows();
		    if($navCheck > 0){
		        $allowDelete = false;
		    }
		}
// 		$code = $_GET['code'];
		//echo $code;exit;
		
// 		$countss = $this->db->query("select * from tbl_sale_detail where fld_shipment = '".$code."'")->num_rows();
		//echo $countss;exit;
		if(!$allowDelete){
		    $this->session->set_userdata(array('error_message' => "Sale is created from this navigation, so you can't edit this navigation. You need to delete sale entries first."));
		    redirect('Navigations/manage');
			exit;
		}
        $this->title = "Update Navigation";
		$data['supplier']=$this->Base_model->getAll('tbl_suppliers');
		$data['transporter']=$this->Base_model->getAll('tbl_transporter');
		$data['banks']=$this->Base_model->getAll('tbl_banks');
		$data['category']=$this->Purchase_model->getAllProducts('tbl_category');
		$data['locations']=$this->Base_model->getAll('tbl_locations', '', "fld_id <> 8", '');
		$data['units']=$this->Base_model->getAll('tbl_units');
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
		$this->Gen->get_script_url('custom_js','purchase.js'),
		$this->Gen->get_script_url('custom_js','navigation.js'),
		$this->Gen->get_script_url('custom_js','jquery.validate.js'),
		);
		$data['view_css']=array(
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
		$data['navigation']=$this->Navigations_model->getNavigationByID($id);
		$maxID=$this->Navigations_model->getMaxID();
		$data['maxid']=sprintf('%04d', $maxID['Auto_increment']);
		$data['id']=$id;
        $this->load_template('','editNavigation',$data);
	}
	public function update(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		// echo '<pre>';
		// print_r($_POST);
		// exit;
		$navigation=$this->Navigations_model->navigation_update_entry();
		if (isset($_POST['edit-navigation'])) {
            redirect(base_url('Navigations/manage'));
            
        }
	}
	
	public function manage_trash()
    {
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(204,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		
		$this->title = "Trashed Navigations";
		$data['navigations']=$this->Navigations_model->getAllTrashNavigations();
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
		$this->Gen->get_script_url('custom_js','navigation.js'),
		);
		// echo '<pre>';
		// print_r($data['navigations']);
		// exit;
		$this->load_template('','navigation_trash',$data);
    }
	
	
	public function delete($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(16,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		
		$navDetails = $this->db->query("SELECT * FROM `tbl_navigations_details` where fld_navigation_id = '$id'")->result_array();
		$allowDelete = true;
		foreach($navDetails as $nav){
		    $saleCheck = $this->db->query("SELECT * FROM tbl_sale_detail WHERE fld_stock_location_id = '{$nav['fld_stock_loc_id']}'")->num_rows();
		    if($saleCheck > 0){
		        $allowDelete = false;
		    }
		    
		    $navCheck = $this->db->query("SELECT * FROM tbl_stock_locations WHERE fld_parent_id = '{$nav['fld_stock_loc_id']}'")->num_rows();
		    if($navCheck > 0){
		        $allowDelete = false;
		    }
		}
// 		$code = $_GET['code'];
		//echo $code;exit;
		
// 		$countss = $this->db->query("select * from tbl_sale_detail where fld_shipment = '".$code."'")->num_rows();
		//echo $countss;exit;
		if(!$allowDelete){
		    $this->session->set_userdata(array('error_message' => "Sale voucher(s) is created from this navigation. You may delete Sale entries first."));
			$this->output->set_header("Location: " . base_url() . 'Navigations/manage', TRUE, 302);
		}else{
		$responce=$this->Navigations_model->delete($id);
        if($responce){
            /****************** Activity Log *****************************/
			$user_role=$this->session->userdata('user_role');
			$user_role_name=$this->session->userdata('user_role_name');
			$user_id=$this->session->userdata('user_id');
		//	$navigation_id=sprintf(' NI-%04d ', $id);
			$navigation_id='<a href="'.base_url('Navigations/detail/'.$id.'').'">NI-'.sprintf('%04d', $id).'</a>';
			$client_ip=$this->Gen->get_client_ip();
			$address=$this->Base_model->getLocation($client_ip);
            $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
            $date=date('Y-m-d H:i:s');
			$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'TRASHED',fld_detail=' $navigation_id',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Navigation voucher is trashed, you need to delete it permanently from trash."));
			$this->output->set_header("Location: " . base_url() . 'Navigations/manage', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Navigation not deleted.Something went wrong"));
			$this->output->set_header("Location: " . base_url() . 'Navigations/manage', TRUE, 302);
		}
	}
	}
	
	public function restore($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(136,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$responce=$this->Navigations_model->restore($id);
        if($responce){
			$this->session->set_userdata(array('success_message' => "Navigation voucher is restored successfully, please check in manage navigation."));
			$this->output->set_header("Location: " . base_url() . 'Navigations/manage_trash', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Navigation not Restore.Something went wrong"));
			$this->output->set_header("Location: " . base_url() . 'Navigations/manage_trash', TRUE, 302);
		}
	}
	
	public function deletepermanent($id){
	    
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(137,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$responce = $this->Navigations_model->permanentdelete($id);
		//$responce = $this->Navigations_model->permanentdeletedetail($id);
		
        if($responce){
            /****************** Activity Log *****************************/
			$user_role=$this->session->userdata('user_role');
			$user_role_name=$this->session->userdata('user_role_name');
			$user_id=$this->session->userdata('user_id');
			$navigation_id=sprintf(' NI-%04d ', $id);
			$client_ip=$this->Gen->get_client_ip();
			$address=$this->Base_model->getLocation($client_ip);
            $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
            $date=date('Y-m-d H:i:s');
			$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'DELETED',fld_detail='$navigation_id',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Navigation voucher is permanently deleted."));
			$this->output->set_header("Location: " . base_url() . 'Navigations/manage_trash', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Navigation not delete.Something went wrong"));
			$this->output->set_header("Location: " . base_url() . 'Navigations/manage_trash', TRUE, 302);
		}
	}
	
	public function createIntNav(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(17,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
        $this->title = "New Navigation";
		$data['supplier']=$this->Base_model->getAll('tbl_suppliers');
		$data['transporter']=$this->Base_model->getAll('tbl_transporter');
		$data['banks']=$this->Base_model->getAll('tbl_banks');
		$data['category']=$this->Purchase_model->getAllProducts('tbl_category');
		$data['locations']=$this->Base_model->getAll('tbl_locations', '', "fld_id <> 8", '');
		$data['units']=$this->Base_model->getAll('tbl_units');
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js'),
		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js'),
	  	$this->Gen->get_script_url('','https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
// 		$this->Gen->get_script_url('custom_js','purchase.js'),
		$this->Gen->get_script_url('custom_js','navigation.js'),
		$this->Gen->get_script_url('custom_js','jquery.validate.js'),
		
		);
		$data['view_css']=array(
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
		$maxID=$this->Navigations_model->getMaxID();
		$data['maxid']=sprintf('%04d', $maxID['Auto_increment']);
        $this->load_template('','createIntNav',$data);
	}
	
	public function getShipments(){
		$location=$this->input->post('location');
		$product=$this->input->post('product');
		$sub_cat_id=$this->input->post('sub_cat_id');
		$data['shipments']=$shipments=$this->Navigations_model->getShipments($location, $product, $sub_cat_id);
// 		print_r($shipments);
// 		exit;
		$data['location_id'] = $location;
		$data['product_id'] = $product;
		$data['sub_cat_id'] = $sub_cat_id;
		$html=$this->load->view('stockShipments',$data,true);
		echo json_encode(array('html'=>$html));
	}
	
	public function selectShipment(){
		$location_id=$this->input->post('location');
		$data['shipments']=$shipments=$this->Navigations_model->ShipmentByID($location_id);
		echo json_encode(array('shipments'=>$shipments));
	}
	
    public function getDetailView(){
		$location_id=$this->input->post('location');
		$product=$this->input->post('product');
		$total_amount=0;
		$data['location_id_selected'] = $location_id;
		$data['product_id_selected'] = $product;
		$data['locations']=$this->Base_model->getAll('tbl_locations', '', "fld_id <> 8", '');
		$data['subcategory'] = $this->db->query("select * from tbl_subcategory where fld_cid = '$product'")->result_array();
		$html=$this->load->view('selectShipment',$data,true);
		echo json_encode(array('html'=>$html,'total_amount'=>$total_amount));
	}
	
    // 	Mehtab Added this below code
    
	public function navigationReport(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(18,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$this->title = "Navigations Report";
		$data['view_scripts']=array(
    		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
    		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
    		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
    		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
    		$this->Gen->get_script_url('custom_js','navigation_report.js'),
    		$this->Gen->get_script_url('custom_js','jquery.validate.js'),
		);
		$data['view_css']=array(
    		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
    		$this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
		$data['locations']=$this->Base_model->getAll('tbl_locations', '', "fld_id <> 8", '');
		$data['users']=$this->Base_model->getAll('tbl_users');
		$data['subcategory']=$this->Base_model->getAll('tbl_subcategory');
		$data['supplier']=$this->Base_model->getAll('tbl_suppliers');
		$data['product_items']=$this->Navigations_model->getAllProducts('tbl_category');
		$data['shipments'] = $this->db->query("select * from tbl_navigations_details GROUP by fld_shipment_from")->result_array();
	 // echo '<pre>';
	 // print_r($data['supplier']);
	 // exit;
		$this->load_template('','navigation_report',$data);
	}
	public function detail($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(153,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
        $this->title = "Navigation Details";
		$data['navigation']=$this->Navigations_model->getNavigationByID($id);
		$data['previous']=$this->Base_model->getRow('tbl_navigations','fld_id','fld_id = (select max(fld_id) from tbl_navigations where fld_id < '.$id.')');
		$data['next']=$this->Base_model->getRow('tbl_navigations','fld_id','fld_id = (select min(fld_id) from tbl_navigations where fld_id > '.$id.')');
		// echo '<pre>';
		// print_r($data);
		// exit;
		if(empty($data['navigation'])){
		    $this->session->set_userdata(array('error_message' => "This record does not exist."));
			$this->output->set_header("Location: " . base_url() . 'Settings/log_system', TRUE, 302);
		}
        $this->load_template('','ViewNavigation',$data);
	}
	
	public function filter(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
	
		$data['navigation']=$navigation=$this->Navigations_model->navigation_filter();
// 		echo $navigation;
// 		exit();
		$data['filter_type']=$this->input->post('filter_type');
		$count=count($navigation);
		$html = $this->load->view('navigation_filter',$data,true);
		echo json_encode(array("html"=>$html,'count'=>$count));
	}
	
    
	public function print_report(){
	    $_POST = $_GET;
	    $data['navigation']=$navigation=$this->Navigations_model->navigation_filter();
		$data['filter_type']=$this->input->post('filter_type');
		
		$count=count($navigation);
		$this->load->view('print_navigation_report.php', $data);
		
	}
	public function pdf_report(){
		include_once APPPATH.'/third_party/autoload.php';
		//$this->load->view('print_purchase_report');
		$mpdf = new \Mpdf\Mpdf();
	    $_POST = $_GET;
	    $data['navigation']=$navigation=$this->Navigations_model->navigation_filter();
		$data['filter_type']=$this->input->post('filter_type');
		$count=count($navigation);
		$html = $this->load->view('pdf_navigation_report',$data,true);

		$mpdf->WriteHTML($html);
		$mpdf->Output('Navigation Report.pdf','D');
		//$mpdf->Output();
		
	}
	public function navigationReport_csv(){
		include_once APPPATH.'/third_party/autoload.php';
		 $_POST = $_GET;
	    $data['navigation']=$navigation=$this->Navigations_model->navigation_filter();
		$filter_type=$this->input->post('filter_type');
		$count=count($navigation);
		
		$header_row = array( "Navigation Date", "From", "To" , " Item", "Shipment" , "Weight (MT)", "Rate (PKR)", "Amount (PKR)" ,"Freight (MT)","Total Freight", "Total Amount(PKR)");
            $csvName = 'Navigation Report'.'.csv';
            header('Content-Type: application/csv');
            header('Content-Disposition: attachment; filename="'.$csvName.'";');
            $output = fopen('php://output', 'w');
            
            fputcsv($output,$header_row);
            
			  $i=1;
			 $b=1;
			 $amtqty=0;
			 $akgqty=0;
			 $total_all_amount = 0;
			 
			foreach($navigation as $nav){
			    $mtqty=0;
				$kgqty=0;
				$total_amount=0;
				 $filter_row = $nav['filter_text'];
					$dataValus=array('', '',$filter_row,'','','','','','','','');
					 fputcsv($output,$dataValus);
				foreach($nav['detail'] as $navdet){
					$mtqty=$mtqty + $navdet['fld_qty'];
					$total_amount=$total_amount + $navdet['fld_total_amount'];
					$kgqty=$kgqty + ($navdet['fld_qty'] * 1000);
					if($filter_type == 1){
					    $loc_from = $this->db->query("select * from tbl_locations where fld_id = '{$navdet['fld_location_from']}'")->row()->fld_location;
					    $loc_to = $this->db->query("select * from tbl_locations where fld_id = '{$navdet['fld_location_to']}'")->row()->fld_location;
					    $subcat = '';
					    if($navdet['fld_subproduct_id'] != '0'){
					        $subcat = ' - '.$this->db->query("select * from tbl_subcategory where fld_subcid = '{$navdet['fld_subproduct_id']}'")->row()->fld_subcategory;
					    }
			    
			 //$mtqty=0;
				// $kgqty=0;
				// $total_amount=0;
				// $filter_row = $purch['filter_text'];
				// 	$dataValus=array('', '',$filter_row,'','','','','','','');
				// 	 fputcsv($output,$dataValus);
				// foreach($purch['detail'] as $purdet){
				    
				    
 			
				// 	$mtqty=$mtqty + $purdet['fld_quantity'];
				// 	$total_amount=$total_amount + $purdet['fld_total_amount'];
				// 	if($purdet['fld_product_id']==1){
				//     	$kgqty=$kgqty + ($purdet['fld_quantity'] * 1000);
				// 	}else{
				// 	   //	$kgqty=$kgqty + ($purdet['fld_quantity']);
				// 	   	$kgqty=0; 
				// 	}
				// 	if($filter_type == 1){
				// 	    $subcat = '';
				// 	    if($purdet['fld_subproduct_id'] != '0'){
				// 	        $subcat = ' - '.$this->db->query("select * from tbl_subcategory where fld_subcid = '{$purdet['fld_subproduct_id']}'")->row()->fld_subcategory;
				// 	    }
					    
				// 	    if($purdet['fld_product_id']==1){ $res= round($purdet['fld_quantity']*1000,2); }else{$res= '-';}
					$dataValus=array(date('d-m-Y',strtotime($navdet['fld_date'])), $loc_from,  $loc_to, $navdet['fld_category'].$subcat,$navdet['fld_shipment_from'],$navdet['fld_qty'], $navdet['fld_rate'],number_format($navdet['fld_amount'],2),number_format($navdet['fld_freight_MT'],2),number_format($navdet['fld_freight_amount'],2),number_format($navdet['fld_total_amount'],2));
                    fputcsv($output,$dataValus);
				
					$i++; }
		$b++;
		}

		}
            
            fclose($output);
            exit();
		
	}
	public function print_single_navigation($id){
	    $data['locations']=$this->Base_model->getAll('tbl_locations', '', "fld_id <> 8", '');
	    $data['navigation']=$this->Navigations_model->getNavigationByID($id);
	    
	    $this->load->view('reports/print_single_navigation', $data);
	}
	public function pdf_single_navigation($id){
	    include_once APPPATH.'/third_party/autoload.php';
	    $mpdf = new \Mpdf\Mpdf();
	    $data['navigation']=$this->Navigations_model->getNavigationByID($id);
	    $html = $this->load->view('reports/pdf_single_navigation',$data,true);
	    $mpdf->WriteHTML($html);
		$mpdf->Output('Navigation Report.pdf','D');
	}
	
	public function addNavigationDraftAutosave(){
		if (!$this->auth->is_logged()) {
			 $this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$navigation = $this->Navigations_model->navigation_draft_entry_autosave();
		echo json_encode($navigation);
	}
	
	public function addNavigationDraft(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$navigation=$this->Navigations_model->navigation_draft_entry();
		echo json_encode($navigation);
	}
	
	public function manage_drafts(){
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(205,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$this->title = "Navigation Drafts";
		$data['navigations']=$this->Navigations_model->getAllNavigationsDraft();
		$data['view_scripts']=array(
		    $this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
    		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
    		$this->Gen->get_script_url('custom_js','notify.js'),
    		$this->Gen->get_script_url('custom_js','navigation.js'),
		);
		$this->load_template('','navigation_draft',$data);
    }
    
    public function edit_drafts($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(134,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
        $this->title = "Update Navigation Draft";
        
		$data['supplier']=$this->Base_model->getAll('tbl_suppliers');
		$data['transporter']=$this->Base_model->getAll('tbl_transporter');
		$data['banks']=$this->Base_model->getAll('tbl_banks');
		$data['category']=$this->Purchase_model->getAllProducts('tbl_category');
		$data['locations']=$this->Base_model->getAll('tbl_locations', '', "fld_id <> 8", '');
		$data['units']=$this->Base_model->getAll('tbl_units');
		$data['view_scripts']=array(
    	    $this->Gen->get_script_url('plugin_components','moment/moment.js'),
    		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
    		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js'),
    		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js'),
    	  	$this->Gen->get_script_url('','https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js'),
    		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
    // 		$this->Gen->get_script_url('custom_js','purchase.js'),
    		$this->Gen->get_script_url('custom_js','navigation.js'),
    		$this->Gen->get_script_url('custom_js','jquery.validate.js'),
    		$this->Gen->get_script_url('custom_js','notify.js'),
		);
		$data['view_css']=array(
    		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
    		$this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
		
		$data['navigation'] = $this->Navigations_model->getNavigationDraftByID($id);
		//$data['navigation']=$this->Base_model->getRow('tbl_navigations_draft','','fld_id ='.$id.'');
		$maxID=$this->Navigations_model->getMaxDraftID();
		$data['maxid']=sprintf('%04d', $maxID['Auto_increment']);
		$data['id']=$id;
        $this->load_template('','editNavigationDraft',$data);
	}
	
	public function update_drafts_autosave(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
// 		echo '<pre>';
// 		print_r($_POST);
//  		exit;
		$navigation=$this->Navigations_model->navigation_update_draft_entry_autosave();
		echo json_encode($navigation);
	}
	
	public function update_drafts(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		// echo '<pre>';
		// print_r($_POST);
		// exit;
		$navigation=$this->Navigations_model->navigation_update_draft_entry();
		echo json_encode($navigation);
		if (isset($_POST['edit-navigation-draft'])) {
            redirect(base_url('Navigations/manage_drafts'));
            
        }
	}
	
	public function deleteDraft($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		
	    $role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(135,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		
		$responce = $this->Navigations_model->deleteDraft($id);
		$responce = $this->Navigations_model->deleteDraftdetail($id);
		
        if($responce){
			$this->session->set_userdata(array('success_message' => "Navigation Draft delete successfully"));
			$this->output->set_header("Location: " . base_url() . 'Navigations/manage_drafts', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Navigation not delete.Something went wrong"));
			$this->output->set_header("Location: " . base_url() . 'Navigations/manage_drafts', TRUE, 302);
		}
	}
	
		public function cleardrafts(){
	    $user_id=$this->session->userdata('user_id');
	    $data=$this->db->query("Select * from tbl_navigations_draft where fld_userid ='$user_id'")->result_array();
	    foreach($data as $row){
	        $this->db->query("delete from tbl_navigations_draft_details where fld_navigation_id ='{$row['fld_id']}'");
	    }
	    $this->db->query("delete from tbl_navigations_draft where fld_userid ='$user_id'");
	    $this->session->set_userdata('success_message', "Drafts cleared successfully.");
	     redirect(base_url('Navigations/manage_drafts'));
	}
	
}
