<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase extends My_controller {
	
	function __construct() {
        parent::__construct();
        $this->load->model('Purchase_model');
        $this->load->model('Suplier_model');
        $this->load->model('Common_model');
    }
	
	public function index()
    {
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(1,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
        $this->title = "New Bill";
		$data['supplier']=$this->Base_model->getAll('tbl_suppliers');
		$data['banks']=$this->Base_model->getAll('tbl_banks');
		$data['category']=$this->Purchase_model->getAllProducts('tbl_category');
		$data['locations']=$this->Base_model->getAll('tbl_locations', '', "fld_id <> 8", '');
		$data['units']=$this->Base_model->getAll('tbl_units');
		$data['refinery']=$this->Base_model->getAll('tbl_refinery');
		$data['transporter']=$this->Base_model->getAll('tbl_transporter');
		$autoVoucherID=$this->Purchase_model->getMaxsuplierID();
		$data['autoVoucherID']='PB-'.sprintf('%04d', $autoVoucherID['Auto_increment']);
		$maxSuplierID=$this->Suplier_model->getMaxsuplierID();
		$data['maxid']='S-'.sprintf('%03d', $maxSuplierID['Auto_increment']);
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js'),
		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js'),
	  	$this->Gen->get_script_url('','https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
		$this->Gen->get_script_url('custom_js','purchase.js'),
		$this->Gen->get_script_url('custom_js','jquery.validate.js'),
		);
		$data['view_css']=array(
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
		// echo '<pre>';
		// print_r($data['supplier']);
		// exit;
        $this->load_template('','addPurchase',$data);
    }
	public function add(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$this->title = "New Bill | ".$this->title;	$sid = $this->input->post('fld_supplier_id',TRUE);
		$purchase=$this->Purchase_model->purchase_entry();
		if (isset($_POST['add-purchase'])) {
            redirect(base_url('Purchase/manage_purchase'));
        }
		if (isset($_POST['add-purchase-another'])) {
            redirect(base_url('Purchase'));
        }
	}
	
	public function createPurchaseFromOrder(){
	    if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$this->title = "Create Purchase | ".$this->title;
		$purchase=$this->Purchase_model->purchase_entry_from_order();
		if (isset($_POST['add-purchase'])) {
            redirect(base_url('Purchase/manage_purchase'));
        }
	}
	
	public function add_ajax(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$data=array();
		$supplier=$this->Purchase_model->supplier_entry();
		if($supplier){
			$insert_id = $this->db->insert_id();
			$data['supplier_id']=$insert_id;
			$data['suppliers']=$this->Base_model->getAll('tbl_suppliers');
			$res=array('responce'=>'success',"message"=>"Supplier added successfully.","data"=>$data);
			echo json_encode($res);
		}else{
			$res=array('responce'=>'error',"message"=>"Supplier not added.something went wrong.");
			echo json_encode($res);
		}
	}
	
	public function add_ajax_refinery(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$data=array();
		$refinery=$this->Purchase_model->refinery_entry();
		if($refinery){
			$insert_id = $this->db->insert_id();
			$data['refinery_id']=$insert_id;
			$data['refinery']=$this->Base_model->getAll('tbl_refinery');
			$res=array('responce'=>'success',"message"=>"Refinery added successfully.","data"=>$data);
			echo json_encode($res);
		}else{
			$res=array('responce'=>'error',"message"=>"Refinery not added.something went wrong.");
			echo json_encode($res);
		}
	}
	
	public function add_ajax_vehicle(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$data=array();
		$vehicle=$this->Purchase_model->vehicle_entry();
			$insert_id = $vehicle;
			$data['vehicle_id']=$insert_id;
			$data['transporter']=$this->Base_model->getAll('tbl_transporter');
			$res=array('responce'=>'success',"message"=>"Vehicle added successfully.","data"=>$data);
			echo json_encode($res);
	}
	
	public function addPurchaseDraftAutosave(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$purchase=$this->Purchase_model->purchase_draft_entry_autosave();
		echo json_encode($purchase);
	}
	
	public function addPurchaseDraft(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$purchase=$this->Purchase_model->purchase_draft_entry();
		echo json_encode($purchase);
	}
	 
	public function manage_purchase(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(2,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		//$this->title = "Manage Purchase | ".$this->title;
		$this->title = "View Bills";
		$data['purchases']=$this->Purchase_model->getAllPurchases();
		$data['view_scripts']=array(
    		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
    		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
    		$this->Gen->get_script_url('custom_js','purchase.js'),
		);
		$this->load_template('','manage_purchase',$data);
	}
	
	public function manage_trash(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(202,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$this->title = "Trashed Bills";
		$data['purchases'] = $this->Purchase_model->getAllTrashPurchases();
	  //$data['currentAssets'] = $this->Common_model->getAllrows('tbl_sublevels','',array('type'=>$type),'');
		$data['view_scripts']=array(
    		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
    		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
    		$this->Gen->get_script_url('custom_js','purchase.js'),
		);
		$this->load_template('','manage_trash',$data);
	}
	
	public function create_order()
    {
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(130,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		//$this->title = "Add Order | ".$this->title;
        $this->title = "New Order";
		$data['supplier']=$this->Base_model->getAll('tbl_suppliers');
		$data['banks']=$this->Base_model->getAll('tbl_banks');
		$data['category']=$this->Purchase_model->getAllProducts('tbl_category');
		$data['locations']=$this->Base_model->getAll('tbl_locations', '', "fld_id <> 8", '');
		$data['units']=$this->Base_model->getAll('tbl_units');
		$data['refinery']=$this->Base_model->getAll('tbl_refinery');
		$data['transporter']=$this->Base_model->getAll('tbl_transporter');
		$autoVoucherID=$this->Purchase_model->getMaxOrderID();
		$data['autoVoucherID']='PO-'.sprintf('%04d', $autoVoucherID['Auto_increment']);
		$maxSuplierID=$this->Suplier_model->getMaxsuplierID();
		$data['maxid']='KG-S-'.sprintf('%03d', $maxSuplierID['Auto_increment']);
		$data['view_scripts']=array(
    		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
    		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
    		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js'),
    	  	$this->Gen->get_script_url('','https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js'),
    		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
    		$this->Gen->get_script_url('custom_js','purchase.js'),
    		$this->Gen->get_script_url('custom_js','jquery.validate.js'),
		);
		$data['view_css']=array(
    		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
    		$this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
		// echo '<pre>';
		// print_r($data['supplier']);
		// exit;
        $this->load_template('','addOrder',$data);
    }
    
    public function addOrder(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$this->title = "Add Order | ".$this->title;
		$purchase=$this->Purchase_model->order_entry();
		if (isset($_POST['add-order'])) {
            redirect(base_url('Purchase/manage_orders'));
        }
		if (isset($_POST['add-order-another'])) {
            redirect(base_url('Purchase/create_order'));
        }
	}
    
	public function manage_orders(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(131,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		
		//$this->title = "Manage Orders | ".$this->title;
		$this->title = "View Orders";
		$data['purchases']=$this->Purchase_model->getAllOrderPurchases();
		
		// echo '<pre>';
		// print_r($data['purchases']);exit;
		
		$data['view_scripts']=array(
    		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
    		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
    		$this->Gen->get_script_url('custom_js','purchase.js'),
		);
		$this->load_template('','manage_purchase_orders',$data);
	}
	
	public function deleteOrder($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(133,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$responce = $this->Purchase_model->deleteOrder($id);
		
        if($responce){
            $user_role=$this->session->userdata('user_role');
			$user_role_name=$this->session->userdata('user_role_name');
			$user_id=$this->session->userdata('user_id');
			$order_no='PO-'.sprintf('%04d', $id);
			$client_ip=$this->Gen->get_client_ip();
			$address=$this->Base_model->getLocation($client_ip);
            $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
            $date=date('Y-m-d H:i:s');
			$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'DELETE',fld_detail='$order_no',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Purchase Order delete successfully"));
			$this->output->set_header("Location: " . base_url() . 'Purchase/manage_orders', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Purchase Order not delete.Something went wrong"));
			$this->output->set_header("Location: " . base_url() . 'Purchase/manage_orders', TRUE, 302);
		}
	}
	
	public function manage_drafts(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(203,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$this->title = "Bill Drafts";
		$data['purchases']=$this->Purchase_model->getAllDraftPurchases();
		
		// echo '<pre>';
		// print_r($data['purchases']);exit;
		
		$data['view_scripts']=array(
    		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
    		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
    		$this->Gen->get_script_url('custom_js','purchase.js'),
		);
		$this->load_template('','manage_purchase_draft',$data);
	}
	
	public function delete($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(5,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$code = $_GET['code'];
		//echo $code;exit;
		$countss_n = $this->db->query("select * from tbl_navigations_details where fld_shipment_from = '".$code."'")->num_rows();
		$countss = $this->db->query("select * from tbl_sale_detail where fld_shipment = '".$code."'")->num_rows();
		//echo $countss;exit;
		if($countss > 0 || $countss_n > 0){
		    $this->session->set_userdata(array('error_message' => "Navigation/Sale voucher(s) is created from this purchase. You may delete Navigation and Sale entries first."));
			$this->output->set_header("Location: " . base_url() . 'Purchase/manage_purchase', TRUE, 302);
		}else{
		
		$responce=$this->Purchase_model->delete($id);
        if($responce){
			$this->session->set_userdata(array('success_message' => "Purchase voucher is trashed, you need to delete it permanently from trash."));
			$user_role=$this->session->userdata('user_role');
			$user_role_name=$this->session->userdata('user_role_name');
			$user_id=$this->session->userdata('user_id');
			$client_ip=$this->Gen->get_client_ip();
			$address=$this->Base_model->getLocation($client_ip);
            $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
            $date=date('Y-m-d H:i:s');
			//$purchase_id='PB-'.sprintf('%04d', $id);
			$purchase_id='<a href="'.base_url('Purchase/detail/'.$id.'').'">PB-'.sprintf('%04d', $id).'</a>';
			$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'TRASHED',fld_detail='$purchase_id',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->output->set_header("Location: " . base_url() . 'Purchase/manage_trash', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Purchase not deleted.Something went wrong"));
			$this->output->set_header("Location: " . base_url() . 'Purchase/manage_purchase', TRUE, 302);
		}
	}
	}
	
	public function restore($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(128,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$responce=$this->Purchase_model->restore($id);
        if($responce){
			$this->session->set_userdata(array('success_message' => "Purchase voucher is restored successfully, please check in manage purchase."));
			$this->output->set_header("Location: " . base_url() . 'Purchase/manage_trash', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Purchase not Restore.Something went wrong"));
			$this->output->set_header("Location: " . base_url() . 'Purchase/manage_trash', TRUE, 302);
		}
	}
	
	public function deletepermanent($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(129,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$responce = $this->Purchase_model->permanentdelete($id);
		$responce = $this->Purchase_model->permanentdeletedetail($id);
		
        if($responce){
			$this->session->set_userdata(array('success_message' => "Purchase voucher is permanently deleted."));
			$user_role=$this->session->userdata('user_role');
			$user_role_name=$this->session->userdata('user_role_name');
			$user_id=$this->session->userdata('user_id');
			$purchase_id='PB-'.sprintf('%04d', $id);
			$client_ip=$this->Gen->get_client_ip();
			$address=$this->Base_model->getLocation($client_ip);
            $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
            $date=date('Y-m-d H:i:s');
			$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'DELETED',fld_detail='$purchase_id',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->output->set_header("Location: " . base_url() . 'Purchase/manage_trash', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Purchase not delete.Something went wrong"));
			$this->output->set_header("Location: " . base_url() . 'Purchase/manage_trash', TRUE, 302);
		}
	}
	
	public function deleteDraft($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(118,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(118,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$responce=$this->Purchase_model->deleteDraft($id);
        if($responce){
			$this->session->set_userdata(array('success_message' => "Purchase Draft deleted successfully"));
			$this->output->set_header("Location: " . base_url() . 'Purchase/manage_drafts', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Purchase Draft not deleted.Something went wrong"));
			$this->output->set_header("Location: " . base_url() . 'Purchase/manage_drafts', TRUE, 302);
		}
	}
	
	public function edit($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(3,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		
		$code = $this->db->query("SELECT * FROM tbl_purchase WHERE fld_id = '$id'")->row()->fld_shipment;
		//echo $code;exit;
		$countss_n = $this->db->query("select * from tbl_navigations_details where fld_shipment_from = '".$code."'")->num_rows();
		$countss = $this->db->query("select * from tbl_sale_detail where fld_shipment = '".$code."'")->num_rows();
		//echo $countss;exit;
		if($countss > 0 || $countss_n > 0){
		    $this->session->set_userdata(array('error_message' => "Navigation/Sale is created from this purchase, so you can't edit this purchase. You need to delete navigation and sale entries first."));
		    redirect('Purchase/manage_purchase');
			exit;
		}
        //$this->title = "Edit Purchase | ".$this->title;
        $this->title = "Update Bill";
		$data['supplier']=$this->Base_model->getAll('tbl_suppliers');
		$data['banks']=$this->Base_model->getAll('tbl_banks');
		$data['category']=$this->Purchase_model->getAllProducts('tbl_category');
		$data['locations']=$this->Base_model->getAll('tbl_locations', '', "fld_id <> 8", '');
		$data['units']=$this->Base_model->getAll('tbl_units');
		$data['refinery']=$this->Base_model->getAll('tbl_refinery');
		$data['transporter']=$this->Base_model->getAll('tbl_transporter');
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js'),
	  	$this->Gen->get_script_url('','https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
		$this->Gen->get_script_url('custom_js','purchase.js'),
		$this->Gen->get_script_url('custom_js','jquery.validate.js'),
		);
		$data['view_css']=array(
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
		$data['purchase']=$this->Purchase_model->getPurchaseByID($id);
		$maxSuplierID=$this->Suplier_model->getMaxsuplierID();
		$data['maxid']='S-'.sprintf('%03d', $maxSuplierID['Auto_increment']);
		
        $this->load_template('','editPurchase',$data);
	}
	public function editOrder($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(132,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
        $this->title = "Update Order Details";
		$data['supplier']=$this->Base_model->getAll('tbl_suppliers');
		$data['banks']=$this->Base_model->getAll('tbl_banks');
		$data['category']=$this->Purchase_model->getAllProducts('tbl_category');
	
		$data['subcategory']=$this->Base_model->getAll('tbl_subcategory');
		$data['locations']=$this->Base_model->getAll('tbl_locations', '', "fld_id <> 8", '');
		$data['units']=$this->Base_model->getAll('tbl_units');
		$data['refinery']=$this->Base_model->getAll('tbl_refinery');
		$data['transporter']=$this->Base_model->getAll('tbl_transporter');
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
		$this->Gen->get_script_url('custom_js','purchase.js'),
		$this->Gen->get_script_url('custom_js','jquery.validate.js'),
		);
		$data['view_css']=array(
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
		$data['purchase']=$this->Purchase_model->getPurchaseOrderByID($id);
		$maxSuplierID=$this->Purchase_model->getMaxsuplierID();
		$data['maxid']='PB-'.sprintf('%04d', $maxSuplierID['Auto_increment']);
		
        $this->load_template('','editPurchaseOrder',$data);
	}
	public function editDraft($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(117,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
        $this->title = "Update Bill Draft";
		$data['supplier']=$this->Base_model->getAll('tbl_suppliers');
		$data['banks']=$this->Base_model->getAll('tbl_banks');
		$data['category']=$this->Purchase_model->getAllProducts('tbl_category');
		$data['subcategory']=$this->Base_model->getAll('tbl_subcategory');
		$data['locations']=$this->Base_model->getAll('tbl_locations');
		$data['units']=$this->Base_model->getAll('tbl_units');
		$data['refinery']=$this->Base_model->getAll('tbl_refinery');
		$data['transporter']=$this->Base_model->getAll('tbl_transporter');
		$data['view_scripts']=array(
    		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
    		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
    		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
    		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js'),
    		$this->Gen->get_script_url('custom_js','purchase.js'),
    		$this->Gen->get_script_url('custom_js','jquery.validate.js'),
		);
		$data['view_css']=array(
    		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
    		$this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
		$data['purchase']=$this->Purchase_model->getPurchaseDraftByID($id);
		$maxSuplierID=$this->Suplier_model->getMaxsuplierID();
		$data['maxid']='S-'.sprintf('%03d', $maxSuplierID['Auto_increment']);
		$autoVoucherID=$this->Purchase_model->getMaxsuplierID();
		$data['autoVoucherID']='PB-'.sprintf('%04d', $autoVoucherID['Auto_increment']);
		
        $this->load_template('','editPurchaseDraft',$data);
	}
	
	public function update(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$purchase=$this->Purchase_model->purchase_update_entry();
		if (isset($_POST['edit-purchase'])) {
            redirect(base_url('Purchase/manage_purchase'));
        }
		if (isset($_POST['add-purchase-another'])) {
            redirect(base_url('Purchase'));
        }
	}
	
	public function updatePurchaseDraftAutosave(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$purchase=$this->Purchase_model->purchase_draft_update_autosaveentry();
		echo json_encode($purchase);
	}
	
	public function updatePurchaseDraft(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		
		$purchase=$this->Purchase_model->purchase_draft_update_entry();
		echo json_encode($purchase);
		
	}
	public function detail($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(4,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
        $this->title = "Bill Details";
		$data['purchase']=$this->Purchase_model->getPurchaseByID($id);
		$data['previous']=$this->Base_model->getRow('tbl_purchase','fld_id','fld_id = (select max(fld_id) from tbl_purchase where fld_id < '.$id.')');
		$data['next']=$this->Base_model->getRow('tbl_purchase','fld_id','fld_id = (select min(fld_id) from tbl_purchase where fld_id > '.$id.')');
		if(empty($data['purchase'])){
		    $this->session->set_userdata(array('error_message' => "This record does not exist."));
			$this->output->set_header("Location: " . base_url() . 'Settings/log_system', TRUE, 302);
		}
        $this->load_template('','ViewPurchase',$data);
	}
	
	
	public function purchReport(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(8,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$this->title = "Purchase Report";
		$data['view_scripts']=array(
    		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
    		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
    		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
    		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
    		$this->Gen->get_script_url('custom_js','purchase.js'),
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
		$data['product_items']=$this->Purchase_model->getAllProducts('tbl_category');
		$data['shipments'] = $this->db->query("select * from tbl_purchase GROUP by fld_shipment")->result_array();
		// echo '<pre>';
		// print_r($data['supplier']);
		// exit;
		$this->load_template('','purchase_report',$data);
	}
	
	
	
	public function filter(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
// 		print_r($_POST);
// 		exit();
// 		print_r($this->Purchase_model->purchase_filter());
// 		exit();
		$data['purchase']=$purchase=$this->Purchase_model->purchase_filter();
		$data['filter_type']=$this->input->post('filter_type');
		$count=count($purchase);
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','moment/moment.js'),    
		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
		);
		$html=$this->load->view('purchase_filter',$data,true);
		echo json_encode(array("html"=>$html,'count'=>$count));
	}
	
	/*public function filterByCurrentMonth(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}

		$data['purchase']=$purchase=$this->Purchase_model->purchase_filterByCurrentMonth();
		$data['filter_type']=$this->input->post('filter_type');
		$count=count($purchase);
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','moment/moment.js'),    
		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
		);
		$html=$this->load->view('purchase_filter',$data,true);
		echo json_encode(array("html"=>$html,'count'=>$count));
	}
	
	public function filterByCurrentDay(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}

		$data['purchase']=$purchase=$this->Purchase_model->purchase_filterByCurrentDay();
		$data['filter_type']=$this->input->post('filter_type');
		$count=count($purchase);
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','moment/moment.js'),    
		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
		);
		$html=$this->load->view('purchase_filter',$data,true);
		echo json_encode(array("html"=>$html,'count'=>$count));
	}
	
	public function filterByCurrentWeek(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}

		$data['purchase']=$purchase=$this->Purchase_model->purchase_filterByCurrentWeek();
		$data['filter_type']=$this->input->post('filter_type');
		$count=count($purchase);
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','moment/moment.js'),    
		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
		);
		$html=$this->load->view('purchase_filter',$data,true);
		echo json_encode(array("html"=>$html,'count'=>$count));
	}
	
	public function filterByCurrentYear(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}

		$data['purchase']=$purchase=$this->Purchase_model->purchase_filterByCurrentYear();
		$data['filter_type']=$this->input->post('filter_type');
		$count=count($purchase);
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','moment/moment.js'),    
		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
		);
		$html=$this->load->view('purchase_filter',$data,true);
		echo json_encode(array("html"=>$html,'count'=>$count));
	}*/
	
	
	public function print_single_purchase($id){
	    $data['purchase'] = $this->Purchase_model->getPurchaseByID($id);
	    $this->load->view('reports/print_single_purchase', $data);
	}
	public function pdf_single_purchase($id){
	    include_once APPPATH.'/third_party/autoload.php';
	    $mpdf = new \Mpdf\Mpdf();
	    $data['purchase']=$this->Purchase_model->getPurchaseByID($id);
	    $html = $this->load->view('reports/pdf_single_purchase',$data,true);
	    $mpdf->WriteHTML($html);
		$mpdf->Output('Purchase Report.pdf','D');
	}
	public function print_report(){
		$this->load->view('print_purchase_report');
		
	}
	public function print_purchase_report(){
	    $filter=$this->input->get('filter');
	   // exit;
		include_once APPPATH.'/third_party/autoload.php';
		//$this->load->view('print_purchase_report');
		$mpdf = new \Mpdf\Mpdf();
		$data['purchase']=$purchase=$this->Purchase_model->purchase_filter_pdf($_GET);
		
		$data['filter_type']=1;
		$data['get']=$_GET;
		$html = $this->load->view('purchase_report_pdf',$data,true);
		$mpdf->WriteHTML($html);
		$mpdf->Output('Purchase Report.pdf','D');
		//$mpdf->Output();
	}
	public function purchase_report_csv(){
	    $filter=$this->input->get('filter');
	   // exit;
		include_once APPPATH.'/third_party/autoload.php';
		//$this->load->view('print_purchase_report');
// 		$mpdf = new \Mpdf\Mpdf();
		$data['purchase']=$purchase=$this->Purchase_model->purchase_filter_pdf($_GET);
		
		$filter_type =1;
// 		$data['get']=$_GET;
// 		$html = $this->load->view('purchase_report_pdf',$data,true);
// 		$mpdf->WriteHTML($html);
// 		$mpdf->Output('Purchase Report.pdf','D');
		//$mpdf->Output();
		
		$header_row = array("#", "Billing Date", "Bill ID", "Account" , " Item", "Shipment", "Qty" , "Weight", "Rate" , "Amount(PKR)");
            $csvName = 'purchasereport'.'.csv';
            header('Content-Type: application/csv');
            header('Content-Disposition: attachment; filename="'.$csvName.'";');
            $output = fopen('php://output', 'w');
            
            fputcsv($output,$header_row);
            
			 $i=1;
			 $b=1;
			 $amtqty=0;
			 $akgqty=0;
			 $total_all_amount=0;
			foreach($purchase as $purch){
			 $mtqty=0;
				$kgqty=0;
				$total_amount=0;
				$filter_row = $purch['filter_text'];
					$dataValus=array('', '',$filter_row,'','','','','','','');
					 fputcsv($output,$dataValus);
				foreach($purch['detail'] as $purdet){
				    
				    
 			
					$mtqty=$mtqty + $purdet['fld_quantity'];
					$total_amount=$total_amount + $purdet['fld_total_amount'];
					if($purdet['fld_product_id']==1){
				    	$kgqty=$kgqty + ($purdet['fld_quantity'] * 1000);
					}else{
					   //	$kgqty=$kgqty + ($purdet['fld_quantity']);
					   	$kgqty=0; 
					}
					if($filter_type == 1){
					    $subcat = '';
					    if($purdet['fld_subproduct_id'] != '0'){
					        $subcat = ' - '.$this->db->query("select * from tbl_subcategory where fld_subcid = '{$purdet['fld_subproduct_id']}'")->row()->fld_subcategory;
					    }
					    
					    if($purdet['fld_product_id']==1){ $res= round($purdet['fld_quantity']*1000,2); }else{$res= '-';}
					$dataValus=array($i, date('d-m-Y',strtotime($purdet['fld_purchase_date'])), $purdet['fld_voucher_no'], $purdet['fld_supplier_name'],$purdet['fld_category'].$subcat,$purdet['fld_shipment'],$purdet['fld_quantity'],$res,$purdet['fld_unit_price'],$purdet['fld_total_amount']);
                    fputcsv($output,$dataValus);
				
					$i++; }
		$b++;
		}

			 
			 
			 
			 
//             foreach($ledger as $ledge){
			
// 				$filter_row = $ledge['filter_text'] .' - '. $ledge['detail'][0]['fld_shipment'];
// 				$dataValus=array('', '',$filter_row,'','','','','','','','','');
//                     fputcsv($output,$dataValus);
// 				$total_qty_in=0;
// 				$total_qty_out=0;
// 				$total_weight_in=0;
// 				$total_weight_out=0;
// 				$balance1=0;
// 				$balance2=0;
// 				foreach($ledge['detail'] as $ledgedet){
// 				    $total_qty_in +=$ledgedet['qty_in'];
// 				    $total_qty_out +=$ledgedet['qty_out'];
// 				    $total_weight_in +=$ledgedet['weight_in'];
// 				    $total_weight_out +=$ledgedet['weight_out'];
// 				    $balance1 = $balance1+$ledgedet['qty_in']-$ledgedet['qty_out'];
// 				    $balance2 = $balance2+$ledgedet['weight_in']-$ledgedet['weight_out'];
					
// 					$dataValus=array($i, date('d-m-Y',strtotime($ledgedet['date'])), $ledgedet['vr_no'], $ledgedet['account'], $ledgedet['remarks'],$ledgedet['location'],$ledgedet['qty_in'],$ledgedet['qty_out'],$balance1,$ledgedet['weight_in'],$ledgedet['weight_out'],number_format($balance2,2));
//                     fputcsv($output,$dataValus);
				
// 					$i++; }
// 		$b++;
		}
            

            
            fclose($output);
            exit();
            
		
		
		
	}
	public function cleardrafts(){
	    $user_id=$this->session->userdata('user_id');
	    $data=$this->db->query("Select * from tbl_purchase_draft where fld_userid ='$user_id'")->result_array();
	    foreach($data as $row){
	        $this->db->query("delete from tbl_purchase_detail_draft where fld_purchase_id ='{$row['fld_id']}'");
	    }
	    $this->db->query("delete from tbl_purchase_draft where fld_userid ='$user_id'");
	    $this->session->set_userdata('success_message', "Drafts cleared successfully.");
	     redirect(base_url('Purchase/manage_drafts'));
	}
	
}
