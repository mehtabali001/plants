<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales extends My_controller {
	
	function __construct() {
    parent::__construct();
        $this->load->model('Sales_model');
        $this->load->model('Customer_model'); 
        $this->load->model('Navigations_model');
        $this->load->model('Suplier_model');
        $this->load->model('Purchase_model');
        $this->load->model('Common_model');
         $this->load->helper('sms');
    }
	 
	public function index()
    {
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
        $this->title = "New Sale";
		$data['customer']=$this->Base_model->getAll('tbl_customers');
		$data['banks']=$this->Base_model->getAll('tbl_banks');
		$data['category']=$this->Sales_model->getAllProducts('tbl_category');
		$data['locations']=$this->Base_model->getAll('tbl_locations', '', "fld_id <> 8 and fld_id <> 4", '');
		$data['transporter']=$this->Base_model->getAll('tbl_transporter');
		$data['units']=$this->Base_model->getAll('tbl_units');
		$autoVoucherID=$this->Sales_model->getMaxsuplierID();
		$data['autoVoucherID']='SI-'.sprintf('%04d', $autoVoucherID['Auto_increment']);
		
		$maxSuplierID=$this->Customer_model->getMaxsuplierID();
		$data['maxid']='C-'.sprintf('%03d', $maxSuplierID['Auto_increment']);
		
		$data['view_scripts']=array(
    		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
    		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
    		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
    		$this->Gen->get_script_url('custom_js','sale.js'),
    		$this->Gen->get_script_url('custom_js','jquery.validate.js'),
    		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js'),
    	  	$this->Gen->get_script_url('','https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js'),
    	  	$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
    		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
    		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js'),
		);
		$data['view_css']=array(
    		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
    		$this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
		// echo '<pre>';
		// print_r($data['supplier']);
		// exit;
        $this->load_template('','sales/addSale',$data);
    }
    
    public function manage_sales(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$this->title = "View Sales";
		$data['sales']=$this->Sales_model->getAllSales();
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		$this->Gen->get_script_url('custom_js','sale.js'),
		);
		$this->load_template('','sales/manage_sales',$data);
	}
    
	public function add(){
	    
	    
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		
		$this->title = "Add Sale";

		$purchase=$this->Sales_model->sale_entry();

		if (isset($_POST['add-sale'])) {
		    if(!$purchase){
		        
		        redirect(base_url('Sales'));
		    }else{
		        if(isset($_POST['sms'])){
	               $this->sendSMS(); 
	              // exit;
	             }
		        if(isset($_POST['email_send'])){
		            
		            $customerid=$this->input->post('fld_customer_id');
		            $customer=$this->db->query("select * from tbl_customers where fld_id = '$customerid'")->row();
		            if($customer->fld_email !=''){
		              //  exit;
		                $this->email_send($customer->fld_customer_name,$customer->fld_email);
		            }
	              // exit;
	             }
	             $this->session->unset_userdata('sale_inserted_id');
		        redirect(base_url('Sales/manage_sales'));
		    }
            
        }
        
		if (isset($_POST['add-sale-another'])) {
            redirect(base_url('Sales'));
        }
	}
	public function email_send($full_name,$email){
		
		$sale_id=$this->session->userdata('sale_inserted_id');
		$sale=$this->Sales_model->getSaleByID($sale_id);
		$sale_html="";
		$message="";
		if(!empty($sale)){
			foreach($sale['products'] as $sale_items){
				$sale_html.=''.$sale_items['fld_category'].' - '.$sale_items['fld_subcategory'].' - '.(int)$sale_items['fld_quantity'].' , Rate '.$sale_items['fld_unit_price'].' <br>';
			}
			$sale_html.='Total amount is : '.$sale['fld_grand_total_amount'].' (PKR)';
		}
		
	
		$email_template=$this->Common_model->select_where_return_row('*','tbl_email',array('fld_id'=>7));
		$this->load->library('phpmailer');
// 		echo $full_name.'-'.$email;
// 		exit();
		
		 $subject = $email_template->fld_subject;
                $htmlMSG = $email_template->fld_email_body;
                
                $htmlMSG = str_replace('{user_name}', $full_name, $htmlMSG);
                $htmlMSG = str_replace('{sale_details}', $sale_html, $htmlMSG);
                
    			$support_email = $email;
    	
    			$this->phpmailer->IsMail();     
     			$this->phpmailer->From   =   'noreply@mail.com';
     			$this->phpmailer->FromName  =  "H.Q. OFFICE";
    			$this->phpmailer->IsHTML(true);
     			$this->phpmailer->AddAddress($support_email); 
     			$this->phpmailer->Subject  =   $subject;
     			$this->phpmailer->Body  =   $htmlMSG;
     			$this->phpmailer->Send();
     			$this->phpmailer->ClearAddresses();
		
		
	}
	public function sendSMS(){
		
		$sale_id=$this->session->userdata('sale_inserted_id');
		$sale=$this->Sales_model->getSaleByID($sale_id);
		$sale_html="";
		$message="";
		if(!empty($sale)){
			foreach($sale['products'] as $sale_items){
				$sale_html.=''.$sale_items['fld_category'].' - '.$sale_items['fld_subcategory'].' - '.(int)$sale_items['fld_quantity'].' , Rate '.$sale_items['fld_unit_price'].' <br>';
			}
			$sale_html.='Total amount is : '.$sale['fld_grand_total_amount'].' (PKR)';
		}
		
		
		$sms_api_data=$this->Common_model->select_where_return_row('*','tbl_sms_api',array('fld_id'=>3));
		
		$fld_customer_id=$this->input->post('fld_customer_id',TRUE);
		
		$customer_data=$this->Base_model->getRow('tbl_customers', '', "fld_id = ".$fld_customer_id."");
		$customer_firstL=substr($customer_data['fld_mobile_num'], 0, 1);
		$customer_number="";
		$number="";
		
		if(!empty($customer_data) && @$customer_data['fld_mobile_num'] != ""){
			if($customer_firstL == 0){
			
			$number=ltrim(  str_replace('-', '', $customer_data['fld_mobile_num']), "0");
			$customer_number='92'.$number;
			}else{
			    
			$customer_number=$customer_data['fld_mobile_num'];
			}
		}

		if(!empty($sms_api_data) && $customer_number != ""){
		    $message = str_replace('{sales}', $sale_html, strip_tags($sms_api_data->fld_message_body));
		    
			send_sms($customer_number ,$sms_api_data,$message);
		}
		
		
	}
	public function add_ajax(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$data=array();
		$customer=$this->Sales_model->customer_entry();
		if($customer){
			$insert_id = $this->db->insert_id();
			$data['customer_id']=$insert_id;
			$data['customers']=$this->Base_model->getAll('tbl_customers');
			$res=array('responce'=>'success',"message"=>"Customer added successfully.","data"=>$data);
			echo json_encode($res);
		}else{
			$res=array('responce'=>'error',"message"=>"Customer not added.something went wrong.");
			echo json_encode($res);
		}
	}

	
	public function manage_trash(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(206,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}

		$this->title = "Trashed Sales";
	  //$data['sales'] = $this->Sales_model->getAllTrashSales();
		$data['sales'] = $this->Common_model->getAllrows('tbl_sale','',array('fld_isdeleted'=>1),'');
		$data['view_scripts'] = array(
	  $this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
		$this->Gen->get_script_url('custom_js','sale.js'),
		);
		$this->load_template('','sales/manage_trash',$data);
	}
	
	public function delete($id){
    
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(25,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		
		$id = $this->input->post('sale_id',TRUE);
		$responce=$this->Sales_model->delete($id);
        if($responce){
            /****************** Activity Log *****************************/
			$user_role=$this->session->userdata('user_role');
			$user_role_name=$this->session->userdata('user_role_name');
			$user_id=$this->session->userdata('user_id');
			$sale_no='SI-'.sprintf('%04d', $id);
			$client_ip=$this->Gen->get_client_ip();
			$address=$this->Base_model->getLocation($client_ip);
            $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
            $date=date('Y-m-d H:i:s');
			$sale_no='<a href="'.base_url('Sales/detail/'.$id.'').'">'.$sale_no.'</a>';
			$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'TRASHED',fld_detail='$sale_no',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Sale voucher is trashed, you need to delete it permanently from trash."));
			$this->output->set_header("Location: " . base_url() . 'Sales/manage_trash', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Sale not deleted.Something went wrong"));
			$this->output->set_header("Location: " . base_url() . 'Sales/manage_sales', TRUE, 302);
		}
	}
	
	public function restore($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		
		$id = $this->input->post('sale_id');
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(138,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		
		$responce=$this->Sales_model->restore($id);
        if($responce){
			$this->session->set_userdata(array('success_message' => "Sale voucher is restored successfully, please check in manage sale."));
			$this->output->set_header("Location: " . base_url() . 'Sales/manage_trash', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Sale not Restore.Something went wrong"));
			$this->output->set_header("Location: " . base_url() . 'Sales/manage_trash', TRUE, 302);
		}
	}
	
	public function deletepermanent($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		
	    $role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(139,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		
		$responce = $this->Sales_model->permanentdelete($id);
		$responce = $this->Sales_model->permanentdeletedetail($id);
		
        if($responce){
            /****************** Activity Log *****************************/
			$user_role=$this->session->userdata('user_role');
			$user_role_name=$this->session->userdata('user_role_name');
			$user_id=$this->session->userdata('user_id');
			$sale_no='SI-'.sprintf('%04d', $id);
			$client_ip=$this->Gen->get_client_ip();
			$address=$this->Base_model->getLocation($client_ip);
            $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
            $date=date('Y-m-d H:i:s');
			$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'DELETED',fld_detail='$sale_no',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Sale voucher is permanently deleted."));
			$this->output->set_header("Location: " . base_url() . 'Sales/manage_trash', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Sale not delete.Something went wrong"));
			$this->output->set_header("Location: " . base_url() . 'Sales/manage_trash', TRUE, 302);
		}
	}
	
	public function edit($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
        $this->title = "Update Sale";
		$data['customer']=$this->Base_model->getAll('tbl_customers');
		$data['banks']=$this->Base_model->getAll('tbl_banks');
		$data['category']=$this->Sales_model->getAllProducts('tbl_category');
		$data['locations']=$this->Base_model->getAll('tbl_locations', '', "fld_id <> 8", '');
		$data['units']=$this->Base_model->getAll('tbl_units');
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js'),
	  	$this->Gen->get_script_url('','https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
		$this->Gen->get_script_url('custom_js','sale.js'),
		$this->Gen->get_script_url('custom_js','jquery.validate.js'),
		);
		$data['view_css']=array(
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
		$data['sale']=$this->Sales_model->getSaleByID($id);
		$maxSuplierID=$this->Suplier_model->getMaxsuplierID();
		$data['maxid']='SV-'.sprintf('%03d', $maxSuplierID['Auto_increment']);
		
        $this->load_template('','sales/editSale',$data);
	}
	
	public function update(){
	    echo '<pre>';
	    print_r($_POST);
	    exit;
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$purchase=$this->Sales_model->sale_update_entry();
		if (isset($_POST['edit-sale'])) {
            redirect(base_url('Sales/manage_sales'));
        }
		if (isset($_POST['edit-sale-another'])) {
            redirect(base_url('Sales'));
        }
	}
	
	
	public function detail($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
        $this->title = "Sale Details";
		$data['sale']=$this->Sales_model->getSaleByID($id);
		$data['previous']=$this->Base_model->getRow('tbl_sale','fld_id','fld_id = (select max(fld_id) from tbl_sale where fld_id < '.$id.')');
		$data['next']=$this->Base_model->getRow('tbl_sale','fld_id','fld_id = (select min(fld_id) from tbl_sale where fld_id > '.$id.')');
		if(empty($data['sale'])){
	      $this->session->set_userdata(array('error_message' => "This record does not exist."));
		  $this->output->set_header("Location: " . base_url() . 'Settings/log_system', TRUE, 302);
		}
        $this->load_template('','sales/viewSale',$data);
	}
	
	public function salesReport(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$this->title = "Sales Report";
		
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
		$this->Gen->get_script_url('custom_js','sale.js'),
		$this->Gen->get_script_url('custom_js','jquery.validate.js'),
		);
		$data['view_css']=array(
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
		
		$data['locations']=$this->Base_model->getAll('tbl_locations', '', "fld_id <> 8", '');
		$data['users']=$this->Base_model->getAll('tbl_users');
		$data['subcategory']=$this->Base_model->getAll('tbl_subcategory');
		$data['customer']=$this->Base_model->getAll('tbl_customers');
		$data['product_items']=$this->Sales_model->getAllProducts('tbl_category');
		$data['shipments'] = $this->db->query("select * from tbl_sale_detail GROUP by fld_shipment")->result_array();
		// echo '<pre>';
		// print_r($data['supplier']);
		// exit;
		$this->load_template('','sales/sales_report',$data);
	}
	
	public function filter(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$data['sales']=$sales=$this->Sales_model->sale_filter();
		$data['filter_type']=$this->input->post('filter_type');
		$count=count($sales);
		$data['view_scripts']=array(
    		$this->Gen->get_script_url('plugin_components','moment/moment.js'),    
    		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
    		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
		);
		$html=$this->load->view('sales/sale_filter',$data,true);
		echo json_encode(array("html"=>$html,'count'=>$count));
	}
	
	
	public function getLatestSales(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$data['sales']=$sales=$this->Sales_model->getLatestSales();
		
		$html=$this->load->view('sales/customer_latest_sale',$data,true);
		echo json_encode(array("html"=>$html));
	}
	public function print_single_sale($id){
	    $data['sale']=$this->Sales_model->getSaleByID($id);
	    $this->load->view('sales/print_single_sale', $data);
	}
	
	public function pdf_single_sale($id){
	    include_once APPPATH.'/third_party/autoload.php';
	    $mpdf = new \Mpdf\Mpdf();
	    $data['sale']=$this->Sales_model->getSaleByID($id);
	    $html = $this->load->view('sales/pdf_single_sale',$data,true);
	    $mpdf->WriteHTML($html);
		$mpdf->Output('Sale Report.pdf','D');
	}
	
	public function print_report(){
	    if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$_POST = $_GET;
	    $data['sales']=$sales=$this->Sales_model->sale_filter();
		$data['filter_type']=$this->input->post('filter_type');
		$this->load->view('sales/print_sale_report', $data);
	}
	
	public function pdf_report(){
		include_once APPPATH.'/third_party/autoload.php';
		$_POST = $_GET;
		$mpdf = new \Mpdf\Mpdf();
	    $data['sales']=$sales=$this->Sales_model->sale_filter();
		$data['filter_type']=$this->input->post('filter_type');
		$data['get']=$_GET;
		$html = $this->load->view('sales/pdf_sale_report',$data,true);
		$mpdf->WriteHTML($html);
		$mpdf->Output('Sale Report.pdf','D');
	}
	public function salesReport_csv(){
		include_once APPPATH.'/third_party/autoload.php';
		$_POST = $_GET;
	    $data['sales']=$sales=$this->Sales_model->sale_filter();
		$filter_type=$this->input->post('filter_type');
		
		
		
			$header_row = array(" Invoice Date", "Invoice ID", "Account" , " Item", "Shipment", "Qty" , "Weight", "Rate","Discount" , "Amount(PKR)");
            $csvName = 'Sale Report'.'.csv';
            header('Content-Type: application/csv');
            header('Content-Disposition: attachment; filename="'.$csvName.'";');
            $output = fopen('php://output', 'w');
            
            fputcsv($output,$header_row);
            
			$i=1;
			 $b=1;
			 $total_all_amount=0;
			 $amtqty=0;
			 $akgqty=0;
			 $atdiscount=0;
			 $tdiscount=0;
			foreach($sales as $sale){
			
			 $mtqty=0;
				$kgqty=0;
				$total_amount=0;
				$filter_row = $sale['filter_text'];
					$dataValus=array('', '',$filter_row,'','','','','','','');
					 fputcsv($output,$dataValus);
				foreach($sale['detail'] as $saledet){
					$mtqty=$mtqty + $saledet['fld_quantity'];
					$total_amount=$total_amount + $saledet['fld_total_amount']-$saledet['fld_discount'];
					$kgqty=$kgqty + ($saledet['fld_quantity'] * 1000);
					if($filter_type == 1){
					    $subcat = '';
					    if($saledet['fld_subproduct_id'] != '0'){
					        $subcat = ' - '.$this->db->query("select * from tbl_subcategory where fld_subcid = '{$saledet['fld_subproduct_id']}'")->row()->fld_subcategory;
					    }
					$dataValus=array( date('d-m-Y',strtotime($saledet['fld_sale_date'])), $saledet['fld_voucher_no'], $saledet['fld_customer_name'],$saledet['fld_category'].$subcat,$saledet['fld_shipment'],$saledet['fld_quantity'], $saledet['fld_weight'],$saledet['fld_unit_price'],round($saledet['fld_discount'],2),round($saledet['fld_total_amount'].'-'.$saledet['fld_discount'],2));
                    fputcsv($output,$dataValus);
				
					$i++; }
		}
				}
            
            fclose($output);
            exit();
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
		$data['locations']=$this->Base_model->getAll('tbl_locations', '', "fld_id <> 8", '');
		$data['subcategory'] = $this->db->query("select * from tbl_subcategory where fld_cid = '$product'")->result_array();
		$html=$this->load->view('selectSaleShipment',$data,true);
		echo json_encode(array('html'=>$html,'total_amount'=>$total_amount));
	}
	
	public function getShipments(){
		$location=$this->input->post('location');
		$product=$this->input->post('product');
		$sub_cat_id=$this->input->post('sub_cat_id');
		$data['shipments']=$shipments=$this->Navigations_model->getShipments($location, $product, $sub_cat_id);
// 		$data['shipments']=$shipments=$this->Navigations_model->getGlShipments($location);
// 		print_r($data['shipments']);
// 		echo $shipments;
// 		exit;
		$data['location_id'] = $location;
		$data['product_id'] = $product;
		$data['sub_cat_id'] = $sub_cat_id;
		$html=$this->load->view('stockShipments',$data,true);
		echo json_encode(array('html'=>$html));
	}
	
	public function getRate(){
	    $location=$this->input->post('location');
		$product=$this->input->post('product');
		$subproduct=$this->input->post('subproduct');
		$date = date('Y-m-d',strtotime(str_replace('/', '-', $this->input->post('date',TRUE))));
		$rate = $this->db->query("SELECT sale FROM `tbl_sales_rate` WHERE plants = '$location' and category = '$product' and sub_category = '$subproduct' and date = '$date' ORDER BY date DESC LIMIT 0,1");
		if($rate->num_rows() > 0){
		    echo $rate->row()->sale;
		}else{
		    echo 0;
		}
	}
	
	// Drafts Section
	
	public function manage_drafts(){
	    
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		//echo $this->session->userdata('permissions');exit;
		if(!empty($role_permissions) && !in_array(207,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		
		$this->title = "View Sales Drafts";
		$data['sales']=$this->Sales_model->getAllDraftSales();

		$data['view_scripts']=array(
    		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
    		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
    		$this->Gen->get_script_url('custom_js','sale.js'),
		);
		$this->load_template('','sales/manage_drafts',$data);
	}
	
	
	public function addSalesDraftAutosave(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}

		
		$sales=$this->Sales_model->sale_draft_entry_autosave();
		echo json_encode($sales);
	}
	
	public function addSalesDraft(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		
		$sales=$this->Sales_model->sale_draft_entry();
		echo json_encode($sales);
	}
	
	public function editDraft($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(140,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		
        $this->title = "Update Sale Draft";
		$data['customer']=$this->Base_model->getAll('tbl_customers');
		$data['banks']=$this->Base_model->getAll('tbl_banks');
		$data['category']=$this->Sales_model->getAllProducts('tbl_category');
		$data['locations']=$this->Base_model->getAll('tbl_locations', '', "fld_id <> 8 and fld_id <> 4", '');
		$data['units']=$this->Base_model->getAll('tbl_units');
		$data['transporter']=$this->Base_model->getAll('tbl_transporter');
		
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
		$this->Gen->get_script_url('custom_js','sale.js'),
		$this->Gen->get_script_url('custom_js','jquery.validate.js'),
		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js'),
	  	$this->Gen->get_script_url('','https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js'),
	  	$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js'),
		);
		$data['view_css']=array(
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
		
		$maxSuplierID=$this->Customer_model->getMaxsuplierID();
		$data['maxid']='C-'.sprintf('%03d', $maxSuplierID['Auto_increment']);
		
		$data['sale']=$this->Sales_model->getSaleDraftByID($id);
		$maxSuplierID=$this->Suplier_model->getMaxsuplierID();
		$data['maxid']='S-'.sprintf('%03d', $maxSuplierID['Auto_increment']);
        $this->load_template('','sales/editSaledraft',$data);
	}
	
	
	
	public function updateSaleDraftAutosave(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		
		$sale=$this->Sales_model->sale_draft_update_entry_autosave();
		echo json_encode($sale);
	}
	
	public function updateSaleDraft(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		
		$sale=$this->Sales_model->sale_draft_update_entry();
		echo json_encode($sale);
	}
	
	public function deleteDraft($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$id= $this->input->post('sale_id');
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(141,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		
		$responce=$this->Sales_model->deleteDraft($id);
        if($responce){
			$this->session->set_userdata(array('success_message' => "Sale Draft deleted successfully"));
			$this->output->set_header("Location: " . base_url() . 'Sales/manage_drafts', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Sale Draft not deleted.Something went wrong"));
			$this->output->set_header("Location: " . base_url() . 'Sales/manage_drafts', TRUE, 302);
		}
	}
	
	public function cleardrafts(){
	    $user_id=$this->session->userdata('user_id');
	    $data=$this->db->query("Select * from tbl_sale_drafts where fld_userid ='$user_id'")->result_array();
	    foreach($data as $row){
	        $this->db->query("delete from tbl_sale_detail_drafts where fld_sale_detail_id ='{$row['fld_id']}'");
	    }
	    $this->db->query("delete from tbl_sale_drafts where fld_userid ='$user_id'");
	    $this->session->set_userdata('success_message', "Drafts cleared successfully.");
	     redirect(base_url('Sales/manage_drafts'));
	}
	
}
