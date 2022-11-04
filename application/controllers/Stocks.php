<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Stocks extends My_controller {
    
    function __construct() {
        parent::__construct(); 
        $CI =& get_instance();
        $this->load->model('Common_model');
        $this->load->model('Stocks_model');
        $this->load->model('Suplier_model');
        $this->load->model('Navigations_model');
    }

	public function index()
	{
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(28,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
        $this->title = "Plants Stocks";
		//For Form Validation
		$data['view_scripts']=array(
			$this->Gen->get_script_url('','https://code.jquery.com/jquery-2.2.4.min.js'),
			$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js'),
			$this->Gen->get_script_url('custom_js','script.js'),
		  	$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		  	$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		  	$this->Gen->get_script_url('plugin_components','timepicker/bootstrap-material-datetimepicker.js'),
		  	$this->Gen->get_script_url('custom_js','data_management.js'),
		);
		
		$data['view_css']=array(
		   $this->Gen->get_script_url('theme_css','style.css'),
		);
		$data['locations']= $this->Base_model->getAll('tbl_locations', '', "fld_id <> 8", '');
        $this->load_template('','stock/plants_management',$data);
	}
	public function empty_cylinders()
	{
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
// 		$role_permissions  = explode(",",$this->session->userdata('permissions'));
// 		if(!empty($role_permissions) && !in_array(28,$role_permissions)) {
// 			$this->session->set_userdata(array('error_message' => "Access Denied!"));
// 			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
// 		}
        $this->title = "Empty Cylinder Stocks";
		//For Form Validation
		$data['view_scripts']=array(
			$this->Gen->get_script_url('','https://code.jquery.com/jquery-2.2.4.min.js'),
			$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js'),
			$this->Gen->get_script_url('custom_js','script.js'),
		  	$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		  	$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		  	$this->Gen->get_script_url('plugin_components','timepicker/bootstrap-material-datetimepicker.js'),
		  	$this->Gen->get_script_url('custom_js','data_management.js'),
		);
		
		$data['view_css']=array(
		   $this->Gen->get_script_url('theme_css','style.css'),
		);
		$data['locations']= $this->Base_model->getAll('tbl_locations', '', "fld_id <> 8", '');
        $this->load_template('','stock/empty_cylinders',$data);
	}
	
	public function tableviewlpg()
	{
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(28,$role_permissions)) {
// 			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
        $this->title = "Table View Cylinder Stocks";
		//For Form Validation
		$data['view_scripts']=array(
			$this->Gen->get_script_url('','https://code.jquery.com/jquery-2.2.4.min.js'),
			$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js'),
			$this->Gen->get_script_url('custom_js','script.js'),
		  	$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		  	$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		  	$this->Gen->get_script_url('plugin_components','timepicker/bootstrap-material-datetimepicker.js'),
		  	$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
		  //	$this->Gen->get_script_url('custom_js','data_management.js'),
		  	$this->Gen->get_script_url('custom_js','stock.js'),
		);
		
		$data['view_css']=array( 
		   $this->Gen->get_script_url('theme_css','style.css'),
		);
		$data['locations']= $this->Base_model->getAll('tbl_locations', '', "fld_id <> 8", '');
        $this->load_template('','stock/table_view_lpg',$data);
	}
	
	public function tableview_lpgempty()
	{
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
// 		$role_permissions  = explode(",",$this->session->userdata('permissions'));
// 		if(!empty($role_permissions) && !in_array(28,$role_permissions)) {
// 			$this->session->set_userdata(array('error_message' => "Access Denied!"));
// 			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
// 		}
        $this->title = "Table View Empty Cylinder Stocks";
		//For Form Validation
		$data['view_scripts']=array(
			$this->Gen->get_script_url('','https://code.jquery.com/jquery-2.2.4.min.js'),
			$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js'),
			$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
			$this->Gen->get_script_url('custom_js','script.js'),
		  	$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		  	$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		  	$this->Gen->get_script_url('plugin_components','timepicker/bootstrap-material-datetimepicker.js'),
		  	
		  //	$this->Gen->get_script_url('custom_js','data_management.js'),
		  $this->Gen->get_script_url('custom_js','stock.js'),
		);
		
		$data['view_css']=array(
		   $this->Gen->get_script_url('theme_css','style.css'),
		);
		$data['locations']= $this->Base_model->getAll('tbl_locations', '', "fld_id <> 8", '');
		$data['controller'] = $this; 
        $this->load_template('','stock/table_view_lpgempty',$data);
	}
	
	
	public function parts()
	{
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
// 		$role_permissions  = explode(",",$this->session->userdata('permissions'));
// 		if(!empty($role_permissions) && !in_array(28,$role_permissions)) {
// 			$this->session->set_userdata(array('error_message' => "Access Denied!"));
// 			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
// 		}
        $this->title = "Spare Parts Stocks";
		//For Form Validation
		$data['view_scripts']=array(
			$this->Gen->get_script_url('','https://code.jquery.com/jquery-2.2.4.min.js'),
			$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js'),
			$this->Gen->get_script_url('custom_js','script.js'),
		  	$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		  	$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		  	$this->Gen->get_script_url('plugin_components','timepicker/bootstrap-material-datetimepicker.js'),
		  	$this->Gen->get_script_url('custom_js','data_management.js'),
		);
		$data['view_css']=array(
		   $this->Gen->get_script_url('theme_css','style.css'),
		);
		$data['locations']= $this->Base_model->getAll('tbl_locations', '', "fld_id <> 8", '');
        $this->load_template('','stock/spare_parts',$data);
	}
	public function tableview_parts()
	{
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
// 		$role_permissions  = explode(",",$this->session->userdata('permissions'));
// 		if(!empty($role_permissions) && !in_array(28,$role_permissions)) {
// 			$this->session->set_userdata(array('error_message' => "Access Denied!"));
// 			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
// 		}
        $this->title = "Spare Parts Stocks";
		//For Form Validation
		$data['view_scripts']=array(
// 			$this->Gen->get_script_url('','https://code.jquery.com/jquery-2.2.4.min.js'),
// 			$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js'),
// 			$this->Gen->get_script_url('custom_js','script.js'),
		  	$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		  	$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		  	$this->Gen->get_script_url('plugin_components','timepicker/bootstrap-material-datetimepicker.js'),
		  	$this->Gen->get_script_url('plugin_components','RWD-Table-Patterns/dist/js/rwd-table.min.js'),
		  	$this->Gen->get_script_url('bower_components','jquery.responsive-table.init.js'),
		  	$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
		);
		$data['view_css']=array(
		   $this->Gen->get_script_url('theme_css','style.css'),
		   $this->Gen->get_script_url('plugin_components','RWD-Table-Patterns/dist/css/rwd-table.min.css'),
		);
		$data['locations']= $this->Base_model->getAll('tbl_locations', '', "fld_id <> 8", '');
		$data['controller'] = $this; 
        $this->load_template('','stock/tableview_parts',$data);
	}
	
	public function stocks_report(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(29,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$this->title = "Stocks Report";
			$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
		$this->Gen->get_script_url('custom_js','stock.js'),
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
		//$data['product_items']=$this->Purchase_model->getAllProducts('tbl_category');
		// echo '<pre>';
		// print_r($data['supplier']);
		// exit;
		$this->load_template('','stock/stocks_report',$data);
	}
	
	public function stock_report_filter(){
	    $frmDate = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['frmdate'])));
	    $toDate = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['todate'])));
	    $plant_for = $_POST['plant_for'];
	    $item_type = $_POST['item_type'];
	    $sitem_type = $_POST['sitem_type'];
	    $data = '';
	    $sn = 0;
        while (strtotime($frmDate) <= strtotime($toDate)) {
            if($plant_for == 'all'){
                $locations = $this->db->query("select * from tbl_locations where fld_id <> 8")->result_array();
            }else{
                $locations = $this->db->query("select * from tbl_locations where fld_id = '$plant_for'")->result_array();
            }
            foreach($locations as $loc){
                $sn++;
                $date = $frmDate;
                
                if($item_type==1){
                    
                
                $todaypurchase1= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_purchase as a, tbl_purchase_detail as b WHERE DATE(a.fld_purchase_date) = '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_purchase_id = a.fld_id AND b.fld_product_id = '1'")->row()->fld_quantity+0; 
                $pastpurchase1= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_purchase as a, tbl_purchase_detail as b WHERE DATE(a.fld_purchase_date) < '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_purchase_id = a.fld_id AND b.fld_product_id = '1'")->row()->fld_quantity+0;
                $todaysale1= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_date) = '$date' AND a.fld_location_from = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '1'")->row()->fld_quantity+0;
                $pastsale1= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_date) < '$date' AND a.fld_location_from = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '1'")->row()->fld_quantity+0;
              
       
                $tsale = 0;
                $psale = 0;
                $todaypurchase2= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_date) = '$date' AND a.fld_location_to = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '1'")->row()->fld_quantity+0; 
                $pastpurchase2= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_date) < '$date' AND a.fld_location_to = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '1'")->row()->fld_quantity+0;
                $todaysale2= $this->db->query("SELECT sc.fld_subcategory, sc.weight, b.fld_quantity as fld_quantity FROM tbl_sale as a, tbl_sale_detail as b, tbl_subcategory as sc WHERE DATE(a.fld_sale_date) = '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_sale_id = a.fld_id AND sc.fld_subcid = b.fld_subproduct_id AND b.fld_product_id = '1'")->result_array();
                $pastsale2= $this->db->query("SELECT sc.fld_subcategory, sc.weight, b.fld_quantity as fld_quantity FROM tbl_sale as a, tbl_sale_detail as b, tbl_subcategory as sc WHERE DATE(a.fld_sale_date) < '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_sale_id = a.fld_id AND sc.fld_subcid = b.fld_subproduct_id AND b.fld_product_id = '1'")->result_array();
                
                $todaypurchase3= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_gain_loss as a, tbl_gainloss_details as b WHERE DATE(a.fld_date) = '$date' AND b.fld_location_id = '{$loc['fld_id']}' AND b.fld_gl_id = a.fld_id AND b.fld_product_id = '1' and b.fld_type=1")->row()->fld_quantity+0; 
                $pastpurchase3= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_gain_loss as a, tbl_gainloss_details as b WHERE DATE(a.fld_date) < '$date' AND b.fld_location_id = '{$loc['fld_id']}' AND b.fld_gl_id = a.fld_id AND b.fld_product_id = '1' and b.fld_type=1")->row()->fld_quantity+0;
                
                
                foreach($todaysale2 as $tdsale){
                    $tsale += $tdsale['weight']*$tdsale['fld_quantity'];
                }
                foreach($pastsale2 as $ptsale){
                    $psale += $ptsale['weight']*$ptsale['fld_quantity'];
                }
                $todaysale2 = $tsale;
                $pastsale2 = $psale;
                
           
               $pastpurchase = $pastpurchase1+$pastpurchase2+($pastpurchase3/1000);
               $todaypurchase = $todaypurchase1+$todaypurchase2+($todaypurchase3/1000);  
              
              $pastpurchasekg = $pastpurchase * 1000;
              $todaypurchasekg = $todaypurchase * 1000;
              $todaysale = ($todaysale1*1000)+$todaysale2;
              $pastsale = ($pastsale1*1000)+$pastsale2;
              
              $gl_diff = $this->db->query("SELECT IFNULL(SUM(fld_quantity), 0) as qty FROM tbl_gainloss_details WHERE fld_type = 3 && fld_location_id = '{$loc['fld_id']}'")->row_array();
                // $totalDiff = round($gl_diff['qty']/1000, 3); 
                $totalDiff = $gl_diff['qty']; 
              
              $openingstock = $pastpurchasekg - $pastsale;
              $closingstock = ($openingstock + $todaypurchasekg - $todaysale)+$totalDiff;
                $openingstockShow = $openingstock/1000;
                $todaysaleShow = $todaysale/1000;
                $closingstockShow = $closingstock/1000;
                
                }else{
                    if($sitem_type != 'all'){
                    $todaypurchase1= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_purchase as a, tbl_purchase_detail as b WHERE DATE(a.fld_purchase_date) = '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_purchase_id = a.fld_id AND b.fld_product_id = '$item_type' AND b.fld_subproduct_id = '$sitem_type'")->row()->fld_quantity+0; 
                    $pastpurchase1= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_purchase as a, tbl_purchase_detail as b WHERE DATE(a.fld_purchase_date) < '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_purchase_id = a.fld_id AND b.fld_product_id = '$item_type' AND b.fld_subproduct_id = '$sitem_type'")->row()->fld_quantity+0;
                    $todaysale1= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) = '$date' AND a.fld_location_from = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '$item_type' AND b.fld_subproduct_id = '$sitem_type'")->row()->fld_quantity+0;
                    $pastsale1= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) < '$date' AND a.fld_location_from = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '$item_type' AND b.fld_subproduct_id = '$sitem_type'")->row()->fld_quantity+0;
                  
                    $tsale = 0;
                    $psale = 0;
                    $todaypurchase2= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) = '$date' AND a.fld_location_to = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '$item_type' AND b.fld_subproduct_id = '$sitem_type'")->row()->fld_quantity+0; 
                    $pastpurchase2= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) < '$date' AND a.fld_location_to = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '$item_type' AND b.fld_subproduct_id = '$sitem_type'")->row()->fld_quantity+0;
                    $todaysale2= $this->db->query("SELECT sc.fld_subcategory, b.fld_quantity as fld_quantity FROM tbl_sale as a, tbl_sale_detail as b, tbl_subcategory as sc WHERE DATE(a.fld_sale_date) = '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_sale_id = a.fld_id AND sc.fld_subcid = b.fld_subproduct_id AND b.fld_product_id = '$item_type' AND b.fld_subproduct_id = '$sitem_type'")->result_array();
                    $pastsale2= $this->db->query("SELECT sc.fld_subcategory, b.fld_quantity as fld_quantity FROM tbl_sale as a, tbl_sale_detail as b, tbl_subcategory as sc WHERE DATE(a.fld_sale_date) < '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_sale_id = a.fld_id AND sc.fld_subcid = b.fld_subproduct_id AND b.fld_product_id = '$item_type' AND b.fld_subproduct_id = '$sitem_type'")->result_array();
                }else{
                    $todaypurchase1= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_purchase as a, tbl_purchase_detail as b WHERE DATE(a.fld_purchase_date) = '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_purchase_id = a.fld_id AND b.fld_product_id = '$item_type'")->row()->fld_quantity+0; 
                    $pastpurchase1= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_purchase as a, tbl_purchase_detail as b WHERE DATE(a.fld_purchase_date) < '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_purchase_id = a.fld_id AND b.fld_product_id = '$item_type'")->row()->fld_quantity+0;
                    $todaysale1= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) = '$date' AND a.fld_location_from = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '$item_type'")->row()->fld_quantity+0;
                    $pastsale1= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) < '$date' AND a.fld_location_from = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '$item_type'")->row()->fld_quantity+0;
                  
                    $tsale = 0;
                    $psale = 0;
                    $todaypurchase2= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) = '$date' AND a.fld_location_to = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '$item_type'")->row()->fld_quantity+0; 
                    $pastpurchase2= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) < '$date' AND a.fld_location_to = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '$item_type'")->row()->fld_quantity+0;
                    $todaysale2= $this->db->query("SELECT sc.fld_subcategory, b.fld_quantity as fld_quantity FROM tbl_sale as a, tbl_sale_detail as b, tbl_subcategory as sc WHERE DATE(a.fld_sale_date) = '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_sale_id = a.fld_id AND sc.fld_subcid = b.fld_subproduct_id AND b.fld_product_id = '$item_type'")->result_array();
                    $pastsale2= $this->db->query("SELECT sc.fld_subcategory, b.fld_quantity as fld_quantity FROM tbl_sale as a, tbl_sale_detail as b, tbl_subcategory as sc WHERE DATE(a.fld_sale_date) < '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_sale_id = a.fld_id AND sc.fld_subcid = b.fld_subproduct_id AND b.fld_product_id = '$item_type'")->result_array();
                }
                
                
                
                foreach($todaysale2 as $tdsale){
                    $tsale += $tdsale['fld_quantity'];
                }
                foreach($pastsale2 as $ptsale){
                    $psale += $ptsale['fld_quantity'];
                }
                $todaysale2 = $tsale;
                $pastsale2 = $psale;
                
              $pastpurchase = $pastpurchase1+$pastpurchase2;
              $todaypurchase = $todaypurchase1+$todaypurchase2;  
              
              $todaysale = $todaysale1+$todaysale2;
              $pastsale = $pastsale1+$pastsale2;
              
              $openingstock = $pastpurchase - $pastsale;
              $closingstock = $openingstock + $todaypurchase - $todaysale;
              
              $openingstockShow = $openingstock;
                $todaysaleShow = $todaysale;
                $closingstockShow = $closingstock;
                }
                
                $data .= '<tr>
                <td>'.$sn.'</td>
                <td>'.date('d/m/Y', strtotime($frmDate)).'</td>
                <td>'.$loc['fld_location'].'</td>
                <td>'.round($openingstockShow, 3).'</td>
                <td>'.$todaypurchase.'</td>
                <td>'.round($todaysaleShow, 3).'</td>
                <td>'.round($closingstockShow, 3).'</td>
                </tr>';
            }
            
            $frmDate = date ("Y-m-d", strtotime("+1 day", strtotime($frmDate)));
	    }
	    echo $data;

	}
	

	
	public function print_report(){
	    
		$this->load->view('stock/print_stock_report');
	}
	
	public function print_stock_report(){
		include_once APPPATH.'/third_party/autoload.php';
		$mpdf = new \Mpdf\Mpdf();
		$data['get']=$_GET;
		$frmDate = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['frmdate'])));
	    $toDate = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['todate'])));
	    $plant_for = $_GET['plant_for'];
	    $item_type = $_GET['item_type'];
	    $sitem_type = $_GET['sitem_type'];
	    $datatr = '';
	    $sn = 0;
        while (strtotime($frmDate) <= strtotime($toDate)) {
            if($plant_for == 'all'){
                $locations = $this->db->query("select * from tbl_locations where fld_id <> 8")->result_array();
            }else{
                $locations = $this->db->query("select * from tbl_locations where fld_id = '$plant_for'")->result_array();
            }
            foreach($locations as $loc){
                $sn++;
                $date = $frmDate;
                
                if($item_type==1){
                    
                
                $todaypurchase1= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_purchase as a, tbl_purchase_detail as b WHERE DATE(a.fld_purchase_date) = '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_purchase_id = a.fld_id AND b.fld_product_id = '1'")->row()->fld_quantity+0; 
                $pastpurchase1= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_purchase as a, tbl_purchase_detail as b WHERE DATE(a.fld_purchase_date) < '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_purchase_id = a.fld_id AND b.fld_product_id = '1'")->row()->fld_quantity+0;
                $todaysale1= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) = '$date' AND a.fld_location_from = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '1'")->row()->fld_quantity+0;
                $pastsale1= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) < '$date' AND a.fld_location_from = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '1'")->row()->fld_quantity+0;
              
       
                $tsale = 0;
                $psale = 0;
                $todaypurchase2= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) = '$date' AND a.fld_location_to = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '1'")->row()->fld_quantity+0; 
                $pastpurchase2= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) < '$date' AND a.fld_location_to = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '1'")->row()->fld_quantity+0;
                $todaysale2= $this->db->query("SELECT sc.fld_subcategory, sc.weight, b.fld_quantity as fld_quantity FROM tbl_sale as a, tbl_sale_detail as b, tbl_subcategory as sc WHERE DATE(a.fld_sale_date) = '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_sale_id = a.fld_id AND sc.fld_subcid = b.fld_subproduct_id AND b.fld_product_id = '1'")->result_array();
                $pastsale2= $this->db->query("SELECT sc.fld_subcategory, sc.weight, b.fld_quantity as fld_quantity FROM tbl_sale as a, tbl_sale_detail as b, tbl_subcategory as sc WHERE DATE(a.fld_sale_date) < '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_sale_id = a.fld_id AND sc.fld_subcid = b.fld_subproduct_id AND b.fld_product_id = '1'")->result_array();
                
                $todaypurchase3= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_gain_loss as a, tbl_gainloss_details as b WHERE DATE(a.fld_date) = '$date' AND b.fld_location_id = '{$loc['fld_id']}' AND b.fld_gl_id = a.fld_id AND b.fld_product_id = '1' and b.fld_type=1")->row()->fld_quantity+0; 
                $pastpurchase3= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_gain_loss as a, tbl_gainloss_details as b WHERE DATE(a.fld_date) < '$date' AND b.fld_location_id = '{$loc['fld_id']}' AND b.fld_gl_id = a.fld_id AND b.fld_product_id = '1' and b.fld_type=1")->row()->fld_quantity+0;
                
                
                foreach($todaysale2 as $tdsale){
                    $tsale += $tdsale['weight']*$tdsale['fld_quantity'];
                }
                foreach($pastsale2 as $ptsale){
                    $psale += $ptsale['weight']*$ptsale['fld_quantity'];
                }
                $todaysale2 = $tsale;
                $pastsale2 = $psale;
                
           
               $pastpurchase = $pastpurchase1+$pastpurchase2+($pastpurchase3/1000);
              $todaypurchase = $todaypurchase1+$todaypurchase2+($todaypurchase3/1000);  
              
              $pastpurchasekg = $pastpurchase * 1000;
              $todaypurchasekg = $todaypurchase * 1000;
              $todaysale = ($todaysale1*1000)+$todaysale2;
              $pastsale = ($pastsale1*1000)+$pastsale2;
              
              $gl_diff = $this->db->query("SELECT IFNULL(SUM(fld_quantity), 0) as qty FROM tbl_gainloss_details WHERE fld_type = 3 && fld_location_id = '{$loc['fld_id']}'")->row_array();
                // $totalDiff = round($gl_diff['qty']/1000, 3); 
                $totalDiff = $gl_diff['qty']; 
              
              $openingstock = $pastpurchasekg - $pastsale;
              $closingstock = ($openingstock + $todaypurchasekg - $todaysale)+$totalDiff;
                $openingstockShow = $openingstock/1000;
                $todaysaleShow = $todaysale/1000;
                $closingstockShow = $closingstock/1000;
                
                }else{
                    if($sitem_type != 'all'){
                    $todaypurchase1= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_purchase as a, tbl_purchase_detail as b WHERE DATE(a.fld_purchase_date) = '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_purchase_id = a.fld_id AND b.fld_product_id = '$item_type' AND b.fld_subproduct_id = '$sitem_type'")->row()->fld_quantity+0; 
                    $pastpurchase1= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_purchase as a, tbl_purchase_detail as b WHERE DATE(a.fld_purchase_date) < '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_purchase_id = a.fld_id AND b.fld_product_id = '$item_type' AND b.fld_subproduct_id = '$sitem_type'")->row()->fld_quantity+0;
                    $todaysale1= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) = '$date' AND a.fld_location_from = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '$item_type' AND b.fld_subproduct_id = '$sitem_type'")->row()->fld_quantity+0;
                    $pastsale1= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) < '$date' AND a.fld_location_from = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '$item_type' AND b.fld_subproduct_id = '$sitem_type'")->row()->fld_quantity+0;
                  
                    $tsale = 0;
                    $psale = 0;
                    $todaypurchase2= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) = '$date' AND a.fld_location_to = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '$item_type' AND b.fld_subproduct_id = '$sitem_type'")->row()->fld_quantity+0; 
                    $pastpurchase2= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) < '$date' AND a.fld_location_to = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '$item_type' AND b.fld_subproduct_id = '$sitem_type'")->row()->fld_quantity+0;
                    $todaysale2= $this->db->query("SELECT sc.fld_subcategory, b.fld_quantity as fld_quantity FROM tbl_sale as a, tbl_sale_detail as b, tbl_subcategory as sc WHERE DATE(a.fld_sale_date) = '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_sale_id = a.fld_id AND sc.fld_subcid = b.fld_subproduct_id AND b.fld_product_id = '$item_type' AND b.fld_subproduct_id = '$sitem_type'")->result_array();
                    $pastsale2= $this->db->query("SELECT sc.fld_subcategory, b.fld_quantity as fld_quantity FROM tbl_sale as a, tbl_sale_detail as b, tbl_subcategory as sc WHERE DATE(a.fld_sale_date) < '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_sale_id = a.fld_id AND sc.fld_subcid = b.fld_subproduct_id AND b.fld_product_id = '$item_type' AND b.fld_subproduct_id = '$sitem_type'")->result_array();
                }else{
                    $todaypurchase1= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_purchase as a, tbl_purchase_detail as b WHERE DATE(a.fld_purchase_date) = '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_purchase_id = a.fld_id AND b.fld_product_id = '$item_type'")->row()->fld_quantity+0; 
                    $pastpurchase1= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_purchase as a, tbl_purchase_detail as b WHERE DATE(a.fld_purchase_date) < '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_purchase_id = a.fld_id AND b.fld_product_id = '$item_type'")->row()->fld_quantity+0;
                    $todaysale1= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) = '$date' AND a.fld_location_from = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '$item_type'")->row()->fld_quantity+0;
                    $pastsale1= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) < '$date' AND a.fld_location_from = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '$item_type'")->row()->fld_quantity+0;
                  
                    $tsale = 0;
                    $psale = 0;
                    $todaypurchase2= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) = '$date' AND a.fld_location_to = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '$item_type'")->row()->fld_quantity+0; 
                    $pastpurchase2= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) < '$date' AND a.fld_location_to = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '$item_type'")->row()->fld_quantity+0;
                    $todaysale2= $this->db->query("SELECT sc.fld_subcategory, b.fld_quantity as fld_quantity FROM tbl_sale as a, tbl_sale_detail as b, tbl_subcategory as sc WHERE DATE(a.fld_sale_date) = '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_sale_id = a.fld_id AND sc.fld_subcid = b.fld_subproduct_id AND b.fld_product_id = '$item_type'")->result_array();
                    $pastsale2= $this->db->query("SELECT sc.fld_subcategory, b.fld_quantity as fld_quantity FROM tbl_sale as a, tbl_sale_detail as b, tbl_subcategory as sc WHERE DATE(a.fld_sale_date) < '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_sale_id = a.fld_id AND sc.fld_subcid = b.fld_subproduct_id AND b.fld_product_id = '$item_type'")->result_array();
                }
                
                
                
                foreach($todaysale2 as $tdsale){
                    $tsale += $tdsale['fld_quantity'];
                }
                foreach($pastsale2 as $ptsale){
                    $psale += $ptsale['fld_quantity'];
                }
                $todaysale2 = $tsale;
                $pastsale2 = $psale;
                
              $pastpurchase = $pastpurchase1+$pastpurchase2;
              $todaypurchase = $todaypurchase1+$todaypurchase2;  
              
              $todaysale = $todaysale1+$todaysale2;
              $pastsale = $pastsale1+$pastsale2;
              
              $openingstock = $pastpurchase - $pastsale;
              $closingstock = $openingstock + $todaypurchase - $todaysale;
              
              $openingstockShow = $openingstock;
                $todaysaleShow = $todaysale;
                $closingstockShow = $closingstock;
                }
                
                $datatr .= '<tr>
                <td>'.$sn.'</td>
                <td>'.date('d/m/Y', strtotime($frmDate)).'</td>
                <td>'.$loc['fld_location'].'</td>
                <td>'.round($openingstockShow, 3).'</td>
                <td>'.$todaypurchase.'</td>
                <td>'.round($todaysaleShow, 3).'</td>
                <td>'.round($closingstockShow, 3).'</td>
                </tr>';
            }
            
            $frmDate = date ("Y-m-d", strtotime("+1 day", strtotime($frmDate)));
	    }
	    $data['datatr'] = $datatr;
		$html = $this->load->view('stock/stock_report_pdf',$data,true);
		$mpdf->WriteHTML($html);
		$mpdf->Output('Stock Report.pdf','D');
	  //$mpdf->Output();
		
	}
	
	
	public function stocks_report_csv(){
		include_once APPPATH.'/third_party/autoload.php';
		$mpdf = new \Mpdf\Mpdf();
		$data['get']=$_GET;
		$frmDate = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['frmdate'])));
	    $toDate = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['todate'])));
	    $plant_for = $_GET['plant_for'];
	    $item_type = $_GET['item_type'];
	    $sitem_type = $_GET['sitem_type'];
	    $datatr = '';
	    $sn = 0;
	    $header_row = array(" #", "Date", "Plant Name" , " Opening Stocks", "Purchase", "Sale" , "Closing Stock");
            $csvName = 'Stock Report'.'.csv';
            header('Content-Type: application/csv');
            header('Content-Disposition: attachment; filename="'.$csvName.'";');
            $output = fopen('php://output', 'w');
            
            fputcsv($output,$header_row);
        while (strtotime($frmDate) <= strtotime($toDate)) {
            if($plant_for == 'all'){
                $locations = $this->db->query("select * from tbl_locations where fld_id <> 8")->result_array();
            }else{
                $locations = $this->db->query("select * from tbl_locations where fld_id = '$plant_for'")->result_array();
            }
            foreach($locations as $loc){
                $sn++;
                $date = $frmDate;
                
                if($item_type==1){
                    
                
                $todaypurchase1= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_purchase as a, tbl_purchase_detail as b WHERE DATE(a.fld_purchase_date) = '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_purchase_id = a.fld_id AND b.fld_product_id = '1'")->row()->fld_quantity+0; 
                $pastpurchase1= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_purchase as a, tbl_purchase_detail as b WHERE DATE(a.fld_purchase_date) < '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_purchase_id = a.fld_id AND b.fld_product_id = '1'")->row()->fld_quantity+0;
                $todaysale1= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) = '$date' AND a.fld_location_from = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '1'")->row()->fld_quantity+0;
                $pastsale1= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) < '$date' AND a.fld_location_from = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '1'")->row()->fld_quantity+0;
              
       
                $tsale = 0;
                $psale = 0;
                $todaypurchase2= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) = '$date' AND a.fld_location_to = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '1'")->row()->fld_quantity+0; 
                $pastpurchase2= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) < '$date' AND a.fld_location_to = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '1'")->row()->fld_quantity+0;
                $todaysale2= $this->db->query("SELECT sc.fld_subcategory, sc.weight, b.fld_quantity as fld_quantity FROM tbl_sale as a, tbl_sale_detail as b, tbl_subcategory as sc WHERE DATE(a.fld_sale_date) = '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_sale_id = a.fld_id AND sc.fld_subcid = b.fld_subproduct_id AND b.fld_product_id = '1'")->result_array();
                $pastsale2= $this->db->query("SELECT sc.fld_subcategory, sc.weight, b.fld_quantity as fld_quantity FROM tbl_sale as a, tbl_sale_detail as b, tbl_subcategory as sc WHERE DATE(a.fld_sale_date) < '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_sale_id = a.fld_id AND sc.fld_subcid = b.fld_subproduct_id AND b.fld_product_id = '1'")->result_array();
                
                $todaypurchase3= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_gain_loss as a, tbl_gainloss_details as b WHERE DATE(a.fld_date) = '$date' AND b.fld_location_id = '{$loc['fld_id']}' AND b.fld_gl_id = a.fld_id AND b.fld_product_id = '1' and b.fld_type=1")->row()->fld_quantity+0; 
                $pastpurchase3= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_gain_loss as a, tbl_gainloss_details as b WHERE DATE(a.fld_date) < '$date' AND b.fld_location_id = '{$loc['fld_id']}' AND b.fld_gl_id = a.fld_id AND b.fld_product_id = '1' and b.fld_type=1")->row()->fld_quantity+0;
                
                
                foreach($todaysale2 as $tdsale){
                    $tsale += $tdsale['weight']*$tdsale['fld_quantity'];
                }
                foreach($pastsale2 as $ptsale){
                    $psale += $ptsale['weight']*$ptsale['fld_quantity'];
                }
                $todaysale2 = $tsale;
                $pastsale2 = $psale;
                
           
               $pastpurchase = $pastpurchase1+$pastpurchase2+($pastpurchase3/1000);
              $todaypurchase = $todaypurchase1+$todaypurchase2+($todaypurchase3/1000);  
              
              $pastpurchasekg = $pastpurchase * 1000;
              $todaypurchasekg = $todaypurchase * 1000;
              $todaysale = ($todaysale1*1000)+$todaysale2;
              $pastsale = ($pastsale1*1000)+$pastsale2;
              
              $gl_diff = $this->db->query("SELECT IFNULL(SUM(fld_quantity), 0) as qty FROM tbl_gainloss_details WHERE fld_type = 3 && fld_location_id = '{$loc['fld_id']}'")->row_array();
                // $totalDiff = round($gl_diff['qty']/1000, 3); 
                $totalDiff = $gl_diff['qty']; 
              
              $openingstock = $pastpurchasekg - $pastsale;
              $closingstock = ($openingstock + $todaypurchasekg - $todaysale)+$totalDiff;
                $openingstockShow = $openingstock/1000;
                $todaysaleShow = $todaysale/1000;
                $closingstockShow = $closingstock/1000;
                
                }else{
                    if($sitem_type != 'all'){
                    $todaypurchase1= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_purchase as a, tbl_purchase_detail as b WHERE DATE(a.fld_purchase_date) = '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_purchase_id = a.fld_id AND b.fld_product_id = '$item_type' AND b.fld_subproduct_id = '$sitem_type'")->row()->fld_quantity+0; 
                    $pastpurchase1= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_purchase as a, tbl_purchase_detail as b WHERE DATE(a.fld_purchase_date) < '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_purchase_id = a.fld_id AND b.fld_product_id = '$item_type' AND b.fld_subproduct_id = '$sitem_type'")->row()->fld_quantity+0;
                    $todaysale1= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) = '$date' AND a.fld_location_from = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '$item_type' AND b.fld_subproduct_id = '$sitem_type'")->row()->fld_quantity+0;
                    $pastsale1= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) < '$date' AND a.fld_location_from = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '$item_type' AND b.fld_subproduct_id = '$sitem_type'")->row()->fld_quantity+0;
                  
                    $tsale = 0;
                    $psale = 0;
                    $todaypurchase2= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) = '$date' AND a.fld_location_to = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '$item_type' AND b.fld_subproduct_id = '$sitem_type'")->row()->fld_quantity+0; 
                    $pastpurchase2= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) < '$date' AND a.fld_location_to = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '$item_type' AND b.fld_subproduct_id = '$sitem_type'")->row()->fld_quantity+0;
                    $todaysale2= $this->db->query("SELECT sc.fld_subcategory, b.fld_quantity as fld_quantity FROM tbl_sale as a, tbl_sale_detail as b, tbl_subcategory as sc WHERE DATE(a.fld_sale_date) = '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_sale_id = a.fld_id AND sc.fld_subcid = b.fld_subproduct_id AND b.fld_product_id = '$item_type' AND b.fld_subproduct_id = '$sitem_type'")->result_array();
                    $pastsale2= $this->db->query("SELECT sc.fld_subcategory, b.fld_quantity as fld_quantity FROM tbl_sale as a, tbl_sale_detail as b, tbl_subcategory as sc WHERE DATE(a.fld_sale_date) < '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_sale_id = a.fld_id AND sc.fld_subcid = b.fld_subproduct_id AND b.fld_product_id = '$item_type' AND b.fld_subproduct_id = '$sitem_type'")->result_array();
                }else{
                    $todaypurchase1= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_purchase as a, tbl_purchase_detail as b WHERE DATE(a.fld_purchase_date) = '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_purchase_id = a.fld_id AND b.fld_product_id = '$item_type'")->row()->fld_quantity+0; 
                    $pastpurchase1= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_purchase as a, tbl_purchase_detail as b WHERE DATE(a.fld_purchase_date) < '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_purchase_id = a.fld_id AND b.fld_product_id = '$item_type'")->row()->fld_quantity+0;
                    $todaysale1= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) = '$date' AND a.fld_location_from = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '$item_type'")->row()->fld_quantity+0;
                    $pastsale1= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) < '$date' AND a.fld_location_from = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '$item_type'")->row()->fld_quantity+0;
                  
                    $tsale = 0;
                    $psale = 0;
                    $todaypurchase2= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) = '$date' AND a.fld_location_to = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '$item_type'")->row()->fld_quantity+0; 
                    $pastpurchase2= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) < '$date' AND a.fld_location_to = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '$item_type'")->row()->fld_quantity+0;
                    $todaysale2= $this->db->query("SELECT sc.fld_subcategory, b.fld_quantity as fld_quantity FROM tbl_sale as a, tbl_sale_detail as b, tbl_subcategory as sc WHERE DATE(a.fld_sale_date) = '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_sale_id = a.fld_id AND sc.fld_subcid = b.fld_subproduct_id AND b.fld_product_id = '$item_type'")->result_array();
                    $pastsale2= $this->db->query("SELECT sc.fld_subcategory, b.fld_quantity as fld_quantity FROM tbl_sale as a, tbl_sale_detail as b, tbl_subcategory as sc WHERE DATE(a.fld_sale_date) < '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_sale_id = a.fld_id AND sc.fld_subcid = b.fld_subproduct_id AND b.fld_product_id = '$item_type'")->result_array();
                }
                
                
                
                foreach($todaysale2 as $tdsale){
                    $tsale += $tdsale['fld_quantity'];
                }
                foreach($pastsale2 as $ptsale){
                    $psale += $ptsale['fld_quantity'];
                }
                $todaysale2 = $tsale;
                $pastsale2 = $psale;
                
              $pastpurchase = $pastpurchase1+$pastpurchase2;
              $todaypurchase = $todaypurchase1+$todaypurchase2;  
              
              $todaysale = $todaysale1+$todaysale2;
              $pastsale = $pastsale1+$pastsale2;
              
              $openingstock = $pastpurchase - $pastsale;
              $closingstock = $openingstock + $todaypurchase - $todaysale;
              
              $openingstockShow = $openingstock;
                $todaysaleShow = $todaysale;
                $closingstockShow = $closingstock;
                }
                
                // $datatr .= '<tr>
                // <td>'.$sn.'</td>
                // <td>'.date('d/m/Y', strtotime($frmDate)).'</td>
                // <td>'.$loc['fld_location'].'</td>
                // <td>'.round($openingstockShow, 3).'</td>
                // <td>'.$todaypurchase.'</td>
                // <td>'.round($todaysaleShow, 3).'</td>
                // <td>'.round($closingstockShow, 3).'</td>
                // </tr>';
                $dataValus=array( $sn, date('d/m/Y', strtotime($frmDate)), $loc['fld_location'],round($openingstockShow, 3),$todaypurchase,round($todaysaleShow, 3), round($closingstockShow, 3));
                    fputcsv($output,$dataValus);
            }
            
            $frmDate = date ("Y-m-d", strtotime("+1 day", strtotime($frmDate)));
	    }

            fclose($output);
            exit();
		
	}
	
	
	
	function getStockPlantWise($plant_id, $product_id, $sub_product_id){
	    $date = date('Y-m-d');
	    
	    $shipments = $this->Navigations_model->getShipments($plant_id, $product_id, $sub_product_id);
                $prices = array();
                $total_amount = 0;
                foreach($shipments as $ship){
                    $fright = 0;
            		if($ship['fld_nav_id'] != 0){
            		    $fright = $this->db->query("SELECT * FROM `tbl_navigations` WHERE fld_id = '{$ship['fld_nav_id']}'")->row()->fld_freight_MT;
            		}
            		$price = 0;
            		
                    if($ship['fld_purchase_id'] != 0){
        		        $purchasePrice = $this->db->query("SELECT a.fld_unit_price, a.fld_quantity, b.fld_grand_total_amount FROM tbl_purchase_detail a, tbl_purchase b WHERE b.fld_id = a.fld_purchase_id && a.fld_product_id = '$product_id' && a.fld_subproduct_id = '$sub_product_id' && b.fld_id = '{$ship['fld_purchase_id']}'")->row_array();
            		    $price = $purchasePrice['fld_unit_price'];
            		    $total_amount = ($purchasePrice['fld_unit_price']*$purchasePrice['fld_quantity']);
        		    }
        		    if($price > 0){
        		        array_push($prices, $price);
        		    }
        		    
                }
	    $todaypurchase1= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_purchase as a, tbl_purchase_detail as b WHERE DATE(a.fld_purchase_date) = '$date' AND a.fld_location_id = '$plant_id' AND b.fld_purchase_id = a.fld_id AND b.fld_product_id = '$product_id' AND b.fld_subproduct_id = '$sub_product_id'")->row()->fld_quantity+0; 
        $pastpurchase1= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_purchase as a, tbl_purchase_detail as b WHERE DATE(a.fld_purchase_date) < '$date' AND a.fld_location_id = '$plant_id' AND b.fld_purchase_id = a.fld_id AND b.fld_product_id = '$product_id' AND b.fld_subproduct_id = '$sub_product_id'")->row()->fld_quantity+0;
        $todaysale1= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) = '$date' AND a.fld_location_from = '$plant_id' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '$product_id' AND b.fld_subproduct_id = '$sub_product_id'")->row()->fld_quantity+0;
        $pastsale1= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) < '$date' AND a.fld_location_from = '$plant_id' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '$product_id' AND b.fld_subproduct_id = '$sub_product_id'")->row()->fld_quantity+0;
      
        $tsale = 0;
        $psale = 0;
        $todaypurchase2= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) = '$date' AND a.fld_location_to = '$plant_id' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '$product_id' AND b.fld_subproduct_id = '$sub_product_id'")->row()->fld_quantity+0; 
        $pastpurchase2= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) < '$date' AND a.fld_location_to = '$plant_id' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '$product_id' AND b.fld_subproduct_id = '$sub_product_id'")->row()->fld_quantity+0;
        $todaysale2= $this->db->query("SELECT sc.fld_subcategory, b.fld_quantity as fld_quantity FROM tbl_sale as a, tbl_sale_detail as b, tbl_subcategory as sc WHERE DATE(a.fld_sale_date) = '$date' AND a.fld_location_id = '$plant_id' AND b.fld_sale_id = a.fld_id AND sc.fld_subcid = b.fld_subproduct_id AND b.fld_product_id = '$product_id' AND b.fld_subproduct_id = '$sub_product_id'")->result_array();
        $pastsale2= $this->db->query("SELECT sc.fld_subcategory, b.fld_quantity as fld_quantity FROM tbl_sale as a, tbl_sale_detail as b, tbl_subcategory as sc WHERE DATE(a.fld_sale_date) < '$date' AND a.fld_location_id = '$plant_id' AND b.fld_sale_id = a.fld_id AND sc.fld_subcid = b.fld_subproduct_id AND b.fld_product_id = '$product_id' AND b.fld_subproduct_id = '$sub_product_id'")->result_array();
	
	    
	    foreach($todaysale2 as $tdsale){
            $tsale += $tdsale['fld_quantity'];
        }
        foreach($pastsale2 as $ptsale){
            $psale += $ptsale['fld_quantity'];
        }
        $todaysale2 = $tsale;
        $pastsale2 = $psale;
        
          $pastpurchase = $pastpurchase1+$pastpurchase2;
          $todaypurchase = $todaypurchase1+$todaypurchase2;  
          
          $todaysale = $todaysale1+$todaysale2;
          $pastsale = $pastsale1+$pastsale2;
          
          $openingstock = $pastpurchase - $pastsale;
          $closingstock = $openingstock + $todaypurchase - $todaysale;
          if(count($prices)>0){ 
			    
			        $avgPrice =  round(array_sum($prices)/count($prices), 2);
			
			    }else{ $avgPrice = 0; }
		$dataarrayreturn['closingstock'] = $closingstock;
		$dataarrayreturn['price'] = $avgPrice;
		$dataarrayreturn['total_amount'] = $total_amount;
		
		return $dataarrayreturn;
	}
	
	
	
	/*public function print_single_purchase($id){
	    $data['purchase']=$this->Purchase_model->getPurchaseByID($id);
	    $this->load->view('reports/print_single_purchase', $data);
	}
	public function pdf_single_purchase($id){
	    include_once APPPATH.'/third_party/autoload.php';
	    $mpdf = new \Mpdf\Mpdf();
	    $data['purchase'] = $this->Purchase_model->getPurchaseByID($id);
	    $html = $this->load->view('reports/pdf_single_purchase',$data,true);
	    $mpdf->WriteHTML($html);
		$mpdf->Output('Purchase Report.pdf','D');
	}
	public function print_report(){
		$this->load->view('print_purchase_report');
	}
	public function print_purchase_report(){
		include_once APPPATH.'/third_party/autoload.php';
		//$this->load->view('print_purchase_report');
		$mpdf = new \Mpdf\Mpdf();
		$data['purchase']=$purchase=$this->Purchase_model->purchase_filter_pdf($_GET);
		$data['filter_type']=1;
		$data['get']=$_GET;
		$html = $this->load->view('purchase_report_pdf',$data,true);
// 		echo '<pre>';
// 		print_r($html);
// 		exit;
		$mpdf->WriteHTML($html);
		$mpdf->Output('Purchase Report.pdf','D');
	  //$mpdf->Output();
		
	}*/
	public function print_report_lpg(){
	    $data['locations']= $this->Base_model->getAll('tbl_locations', '', "fld_id <> 8", '');
		$this->load->view('stock/print_stock_report_lpg', $data);
	}
	
	public function pdf_stock_report_lpg(){
		include_once APPPATH.'/third_party/autoload.php';
		$mpdf = new \Mpdf\Mpdf();
	    $data['locations']= $this->Base_model->getAll('tbl_locations', '', "fld_id <> 8", '');
		$html = $this->load->view('stock/stock_report_pdf_lpg',$data,true);
		$mpdf->WriteHTML($html);
		$mpdf->Output('Stock Report.pdf','D');
	  //$mpdf->Output();
	}
	
	public function print_report_lpgempty(){
	    $data['locations']= $this->Base_model->getAll('tbl_locations', '', "fld_id <> 8", '');
	    $data['controller'] = $this; 
		$this->load->view('stock/print_stock_report_lpgempty', $data);
	}
	
	public function pdf_stock_report_lpgempty(){
		include_once APPPATH.'/third_party/autoload.php';
		$mpdf = new \Mpdf\Mpdf();
	    $data['locations']= $this->Base_model->getAll('tbl_locations', '', "fld_id <> 8", '');
	    $data['controller'] = $this; 
		$html = $this->load->view('stock/stock_report_pdf_lpgempty',$data,true);
		$mpdf->WriteHTML($html);
		$mpdf->Output('Stock Report.pdf','D');
	  //$mpdf->Output();
		
	}
	
}
