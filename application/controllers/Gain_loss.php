<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gain_loss extends My_controller { 
	 
	function __construct() {  
        parent::__construct();  
        $this->CI = & get_instance();
        $this->load->model('Gain_loss_model');  
        $this->load->model('Navigations_model');   
        $this->load->model('Common_model');
    } 
	 
	public function index() 
    {
		  
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(32,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
        $this->title = "Create Gain/Loss";
        
		$data['category']=$this->Base_model->getAll('tbl_category', '', "fld_id = 1", ''); 
		$data['locations']=$this->Base_model->getAll('tbl_locations', '', "fld_id <> 8", ''); 
		$autoVoucherID=$this->Gain_loss_model->getMaxGlID();
		$data['autoVoucherID']='GL-'.sprintf('%04d', $autoVoucherID['Auto_increment']);
		
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
		$this->Gen->get_script_url('custom_js','gain_loss.js'),
		$this->Gen->get_script_url('custom_js','jquery.validate.js'), 
		);
		$data['view_css']=array(
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
		// echo '<pre>'; 
		// print_r($data['supplier']); 
		// exit;
        $this->load_template('','gainloss/Create_gain_loss',$data); 
    }
	public function add(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		
		$this->title = "Add Gain Loss";
		$gain_loss=$this->Gain_loss_model->gain_loss_entry();

		if (isset($_POST['add-gain-loss'])) {
            redirect(base_url('Gain_loss/manage'));
            
        }
		if (isset($_POST['add-gain-loss-another'])) {
            redirect(base_url('Gain_loss'));
            
        }
		
	}
	
	public function editProccess(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		
		$this->title = "Update Gain Loss";
		$gain_loss=$this->Gain_loss_model->gain_loss_update_entry();

		if (isset($_POST['update-gain-loss'])) {
            redirect(base_url('Gain_loss/manage'));
        }
		
	}
	// 	trash
	
	
		public function manage_trash()
    {
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(211,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		
		$this->title = "View Gain Loss";
		$data['gainloss']=$this->Gain_loss_model->getAllTrashGL();
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
		$this->Gen->get_script_url('custom_js','gain_loss.js'),
		);
		// echo '<pre>';
		// print_r($data['navigations']);
		// exit;
		$this->load_template('','gainloss/GL_trash',$data);
    }
	
	public function delete($id){
	    if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(150,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		
		$gld = $this->db->query("SELECT * FROM tbl_gain_loss WHERE fld_id = '$id'")->row_array();
		$deleteAllow = 1;
		$gld_details = $this->db->query("SELECT * FROM tbl_gainloss_details WHERE fld_gl_id = '{$gld['fld_id']}'")->result_array();
		
		foreach($gld_details as $row){
		    if($row['fld_type']==1){
		        $slid = $this->db->query("SELECT * FROM `tbl_stock_locations` WHERE fld_gl_id = '{$row['fld_id']}'")->row_array();
		        $check_sale = $this->db->query("SELECT * FROM `tbl_sale_detail` where fld_stock_location_id = '{$slid['fld_id']}'");
		        if($check_sale->num_rows() > 0){
		            $deleteAllow = 0;
		        }
		    }
		}
		
		if($deleteAllow==0){
		    $this->session->set_userdata('error_message', "Sale is created from this GainLoss, so you can't edit this GainLoss. You need to delete sale entries first..");
		    redirect(base_url('Gain_loss/manage'));
		    exit;
		}
		
		$user_id = $this->session->userdata('user_id');
	  //$this->db->set('fld_trash_date', 'NOW()', FALSE);
		$timedate = date('Y-m-d H:i:s');
// 		$responce = $this->db->
		
		$this->title = "Trashed Gain Loss";
	   // $this->db->where('fld_gl_id', $id);
// 		$this->db->delete('tbl_gainloss_details');
		$this->db->where('fld_id', $id);
// 		$this->db->delete('tbl_gain_loss');
        $this->db->update('tbl_gain_loss', array('fld_isdeleted'=>1, 'fld_trash_by' => $user_id, 'fld_trash_date' => $timedate), 'fld_id ='.$id.'');
         /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$user_id=$this->session->userdata('user_id');
		$voucher_no=$this->input->post('fld_voucher_no',TRUE);
		$voucher_no='GL-'.sprintf('%04d', $id);
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
        $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
        $date=date('Y-m-d H:i:s');
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'TRASHED',fld_detail='$voucher_no',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
		$this->session->set_userdata('success_message', "Gain Loss moved to trash successfully.");
		redirect(base_url('Gain_loss/manage_trash'));
	}
	
	
	public function restore($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(148,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		
		$this->title = "Restore Gain Loss";
	   // $this->db->where('fld_gl_id', $id);
// 		$this->db->delete('tbl_gainloss_details');
		$this->db->where('fld_id', $id);
// 		$this->db->delete('tbl_gain_loss');
        $this->db->update('tbl_gain_loss' ,array('fld_isdeleted'=>0));
		$this->session->set_userdata('success_message', "Gain Loss Restored successfully.");
		redirect(base_url('Gain_loss/manage_trash'));
	}
	
	
	public function deletepermanent($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(149,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		
		$this->title = "Delete Gain Loss";
	    $this->db->where('fld_gl_id', $id);
		$this->db->delete('tbl_gainloss_details');
		$this->db->where('fld_id', $id);
		$this->db->delete('tbl_gain_loss');
		
		$this->db->query("DELETE FROM `tbl_stock_locations` WHERE fld_gl_id NOT IN (SELECT fld_id FROM tbl_gainloss_details) and fld_gl_id != 0");
		$this->db->query("DELETE FROM `tbl_stocks` WHERE fld_stock_loc_id NOT IN (SELECT fld_id from tbl_stock_locations)");
		    
		 $v_id = $this->db->query("SELECT id FROM tbl_transections_master WHERE type='GainLoss' AND type_id = '$id'")->row()->id;
		 $this->db->query("DELETE FROM tbl_transections_details where v_id = '$v_id'");
		 $this->db->query("DELETE FROM tbl_transections_master WHERE type='GainLoss' AND type_id = '$id'");
        // $this->db->update('tbl_gain_loss' ,array('fld_isdeleted'=>0));
         /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$user_id=$this->session->userdata('user_id');
		$voucher_no=$this->input->post('fld_voucher_no',TRUE);
		$voucher_no='GL-'.sprintf('%04d', $id);
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
        $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
        $date=date('Y-m-d H:i:s');
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'DELETED',fld_detail='$voucher_no',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
		$this->session->set_userdata('success_message', "Gain Loss deleted successfully.");
		redirect(base_url('Gain_loss/manage_trash'));
	}
	
	
	
	public function manage()
    {
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
// 		$role_permissions  = explode(",",$this->session->userdata('permissions'));
// 		if(!empty($role_permissions) && !in_array(14,$role_permissions)) {
// 			$this->session->set_userdata(array('error_message' => "Access Denied!"));
// 			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
// 		}
		$this->title = "View Gain Loss";
		$data['gainloss']=$this->Gain_loss_model->getAllGL();
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
		$this->Gen->get_script_url('custom_js','gain_loss.js'),
		);
		// echo '<pre>';
		// print_r($data['navigations']);
		// exit;
		$this->load_template('','gainloss/manage_gainloss',$data);
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
		
		$gld = $this->db->query("SELECT * FROM tbl_gain_loss WHERE fld_id = '$id'")->row_array();
		$deleteAllow = 1;
		$gld_details = $this->db->query("SELECT * FROM tbl_gainloss_details WHERE fld_gl_id = '{$gld['fld_id']}'")->result_array();
		
		foreach($gld_details as $row){
		    if($row['fld_type']==1){
		        $slid = $this->db->query("SELECT * FROM `tbl_stock_locations` WHERE fld_gl_id = '{$row['fld_id']}'")->row_array();
		        $check_sale = $this->db->query("SELECT * FROM `tbl_sale_detail` where fld_stock_location_id = '{$slid['fld_id']}'");
		        if($check_sale->num_rows() > 0){
		            $deleteAllow = 0;
		        }
		    }
		}
		
		if($deleteAllow==0){
		    $this->session->set_userdata('error_message', "Sale is created from this GainLoss, so you can't edit this GainLoss. You need to delete sale entries first..");
		    redirect(base_url('Gain_loss/manage'));
		    exit;
		}
		
        $this->title = "Update Gain Loss";
		$data['category']=$this->Base_model->getAll('tbl_category');
		$data['locations']=$this->Base_model->getAll('tbl_locations', '', "fld_id <> 8", '');
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js'),
	  	$this->Gen->get_script_url('','https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
		$this->Gen->get_script_url('custom_js','gain_loss.js'),
		$this->Gen->get_script_url('custom_js','jquery.validate.js'),
		);
		$data['view_css']=array(
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
		$data['gainloss']=$this->Gain_loss_model->getGLByID($id);
		
        $this->load_template('','gainloss/edit_gain_loss',$data);
	}
	
	
	public function Gain_loss_report(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(33,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$this->title = "Gain Loss Report";
			$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
		$this->Gen->get_script_url('custom_js','gain_loss.js'),
		$this->Gen->get_script_url('custom_js','jquery.validate.js'),
		);
		$data['view_css']=array(
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
		$data['locations']=$this->Base_model->getAll('tbl_locations', '', "fld_id <> 8", '');
		$data['users']=$this->Base_model->getAll('tbl_users');
		$data['category']=$this->Base_model->getAll('tbl_category');
		$data['shipments'] = $this->db->query("select * from tbl_gainloss_details GROUP by fld_shipment")->result_array();
		
		// echo '<pre>';
		// print_r($data['supplier']);
		// exit;
		$this->load_template('','gainloss/gain_loss_report',$data);
	}
	
	function getShipments(){
	    
        $product_id = $this->input->post('product_id',TRUE);
        $location_id = $this->input->post('location_id',TRUE);
        $shipments=$this->Navigations_model->getShipments($location_id, $product_id, 0);
        $data=array();
        $data['shipments'] = array();
        	
        	foreach($shipments as $spmnt){
        	    $shipm= array();
        	    $shipm = $spmnt;
		           $totalSale = 0;
    			    
                
                $totalsale = $this->db->query("SELECT sc.fld_subcategory, sc.weight, b.fld_quantity as fld_quantity FROM tbl_sale as a, tbl_sale_detail as b, tbl_subcategory as sc WHERE b.fld_stock_location_id = '{$spmnt['fld_id']}' AND b.fld_sale_id = a.fld_id AND sc.fld_subcid = b.fld_subproduct_id")->result_array();
    			    foreach($totalsale as $tsale){
                        $totalSale += $tsale['weight']*$tsale['fld_quantity'];
                    }
                    $totalSale = round($totalSale/1000, 3);
    		          $shipm['fld_stock_qty'] = $spmnt['fld_stock_qty']-$totalSale;
		        $fright = 0;
        		if($spmnt['fld_nav_id'] != 0){
        		    $fright = $this->db->query("SELECT * FROM `tbl_navigations` WHERE fld_id = '{$spmnt['fld_nav_id']}'")->row()->fld_freight_MT;
        		}
            		
    		    $purchasePrice = $this->db->query("SELECT a.fld_unit_price FROM tbl_purchase_detail a, tbl_purchase b WHERE b.fld_id = a.fld_purchase_id && a.fld_product_id = '1' && b.fld_id = '{$spmnt['fld_purchase_id']}'")->row_array();
    		    $price = ($purchasePrice['fld_unit_price']/1000)+($fright/1000);
    		    
		          $shipm['fld_purchase_price'] = $price;
		          $data['shipments'][] = $shipm;
		      }
        
        
		
		$rate = $this->db->query("SELECT sale FROM `tbl_sales_rate` WHERE plants = '$location_id' and category = '1' && sub_category = 4 && date = (SELECT MAX(date) FROM tbl_sales_rate)");
		if($rate->num_rows() > 0){
		    $rate =  $rate->row()->sale+0;
		}else{
		    $rate =  0;
		}
		$data['rate'] = round($rate/11.8,2);
        echo json_encode($data);
    }
    
    public function getShipmentsInView($product_id, $location_id){
        $shipments=$this->Navigations_model->getShipments($location_id, $product_id, 0);
        $data=array();
        $data['shipments'] = array();
        	
        	foreach($shipments as $spmnt){
        	    $shipm= array();
        	    $shipm = $spmnt;
		           $totalSale = 0;
    			    
                
                $totalsale = $this->db->query("SELECT sc.fld_subcategory, sc.weight, b.fld_quantity as fld_quantity FROM tbl_sale as a, tbl_sale_detail as b, tbl_subcategory as sc WHERE b.fld_stock_location_id = '{$spmnt['fld_id']}' AND b.fld_sale_id = a.fld_id AND sc.fld_subcid = b.fld_subproduct_id")->result_array();
    			    foreach($totalsale as $tsale){
                        $totalSale += $tsale['weight']*$tsale['fld_quantity'];
                    }
                    $totalSale = round($totalSale/1000, 3);
		          $shipm['fld_stock_qty'] = $spmnt['fld_stock_qty']-$totalSale;
		          $data['shipments'][] = $shipm;
		      }
        
        
		
		$rate = $this->db->query("SELECT MIN(sale) as sale,MAX(date) FROM `tbl_sales_rate` WHERE plants = '$location_id' and category = '$product_id'");
		if($rate->num_rows() > 0){
		    $rate =  $rate->row()->sale+0;
		}else{
		    $rate =  0;
		}
		$data['rate'] = $rate/11.8;
        return $data;
    }
    
    public function filter(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$data['gain_loss']=$gain_loss=$this->Gain_loss_model->gain_loss_filter();
		$data['filter_type']=$this->input->post('filter_type');
		$count=count($gain_loss);
		$html=$this->load->view('gainloss/gain_loss_filter',$data,true);
		echo json_encode(array("html"=>$html,'count'=>$count));
		
	}
	public function filter_csv(){
	    $_POST=$_GET;
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$data['gain_loss']=$gain_loss=$this->Gain_loss_model->gain_loss_filter();
		$data['filter_type']=$this->input->post('filter_type');
		include_once APPPATH.'/third_party/autoload.php';
		$header_row = array("#", "Invoice Date", "Invoice ID", "Item" , "Plant", "Type", "Shipment","Qty(KG)","Rate/KG (PKR)","Amount(PKR)");
        $csvName = 'gainlossreport'.'.csv';
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="'.$csvName.'";');
        $output = fopen('php://output', 'w');
        
        fputcsv($output,$header_row);
        $i=1;
       	foreach($gain_loss as $gainloss){
            foreach($gainloss['detail'] as $gainlossdet){
            if($gainlossdet['fld_type']==1){
                $type='Gain';
                
            }elseif($gainlossdet['fld_type']==2){
                $type='Loss';
                
            }elseif($gainlossdet['fld_type']==3){
                $type='Difference';
                
            }
            $dataValus=array($i,date('d-m-Y',strtotime($gainlossdet['fld_date'])),$gainlossdet['fld_voucher_no'],$gainlossdet['fld_category'],
            $gainlossdet['fld_location'],$type,$gainlossdet['fld_shipment'],$gainlossdet['fld_quantity'],$gainlossdet['fld_unit_price'],$gainlossdet['fld_total_amount']);
            fputcsv($output,$dataValus);
            $i++;
            }
        }
            
        fclose($output);
		
	}
	public function print_report(){
	    if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$_POST = $_GET;
	    $data['gain_loss']=$gain_loss=$this->Gain_loss_model->gain_loss_filter();
		$data['filter_type']=$this->input->post('filter_type');
		$this->load->view('gainloss/print_gl_report', $data);
	}
	
	public function pdf_report(){
		include_once APPPATH.'/third_party/autoload.php';
		$_POST = $_GET;
		$mpdf = new \Mpdf\Mpdf();
	    $data['gain_loss']=$gain_loss=$this->Gain_loss_model->gain_loss_filter();
		$data['filter_type']=$this->input->post('filter_type');
		$data['get']=$_GET;
		$html = $this->load->view('gainloss/pdf_gl_report',$data,true);
		$mpdf->WriteHTML($html);
		$mpdf->Output('Gain Loss Report.pdf','D');
	}
	
}