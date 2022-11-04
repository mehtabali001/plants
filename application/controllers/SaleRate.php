<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SaleRate extends My_controller {
	
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
		if(!empty($role_permissions) && !in_array(75,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
        $this->title = "New Daily Sale Rate";
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		$this->Gen->get_script_url('plugin_components','timepicker/bootstrap-material-datetimepicker.js'),
        $this->Gen->get_script_url('custom_js','hrm.js'),
		$this->Gen->get_script_url('','https://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js'),
		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap3-editable/js/bootstrap-editable.js'),
		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js'),
		
		);
		$data['view_css']=array(
		$this->Gen->get_script_url('theme_css','bootstrap3.css'),
		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap3-editable/css/bootstrap-editable.css'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
		$this->Gen->get_script_url('plugin_components','timepicker/bootstrap-material-datetimepicker.css'),
		);
		
		date_default_timezone_set("Asia/Karachi");
		$today = date('Y-m-d');
		//echo $today;exit;
		
		if(isset($_GET['date'])){
		    $date = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date'])));
		    $data['history'] = $this->db->query("SELECT * FROM tbl_sales_rate WHERE date = '$date' && plants = '{$_GET['plants']}'")->result_array();
		}else{
		    $data['history']= $this->Base_model->getAll('tbl_sales_rate','',"date = '".$today."'",'');
		}
		
        $this->load_template('','salesrates/addSalerate',$data);
    }
    
	
	public function manage_salerateHistory(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(77,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
        $this->title = "View Sale Rate History";
		$data['view_scripts']=array(
		    $this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		    $this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		    $this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
		    $this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		    $this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
		    $this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
    		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
    		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
    		$this->Gen->get_script_url('plugin_components','timepicker/bootstrap-material-datetimepicker.js'),
            $this->Gen->get_script_url('custom_js','hrm.js'),
		
		);
		$data['view_css']=array(
		$this->Gen->get_script_url('theme_css','bootstrap3.css'),
		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap3-editable/css/bootstrap-editable.css'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
		$this->Gen->get_script_url('plugin_components','timepicker/bootstrap-material-datetimepicker.css'),
		);
		
		if(isset($_GET['date'])){
		    $date = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date'])));
		    $data['history'] = $this->db->query("SELECT * FROM tbl_sales_rate WHERE date = '$date' && plants = '{$_GET['plants']}'&& sub_category = '4'  ORDER BY date DESC")->result_array();
		}else{
		  //  $data['history']= $this->Base_model->getAll('tbl_sales_rate');
		  $data['history'] = $this->db->query("SELECT * FROM tbl_sales_rate WHERE sub_category = '4'  ORDER BY date DESC")->result_array();
		}
		
        $this->load_template('','salesrates/manage_salesrateHistory',$data);
	}
	
		public function edit(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(78,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
 $this->title = "Update Sale Rate History";
        $data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		
		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		$this->Gen->get_script_url('plugin_components','timepicker/bootstrap-material-datetimepicker.js'),
        $this->Gen->get_script_url('custom_js','hrm.js'),
		$this->Gen->get_script_url('','https://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js'),
		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap3-editable/js/bootstrap-editable.js'),
		
		);
		$data['view_css']=array(
		$this->Gen->get_script_url('theme_css','bootstrap3.css'),
		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap3-editable/css/bootstrap-editable.css'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
		$this->Gen->get_script_url('plugin_components','timepicker/bootstrap-material-datetimepicker.css'),
		);
		
// 		if(isset($_GET['date'])){
		    $date = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date'])));
		    $plant=$_GET['plant'];
		    $data['history'] = $this->db->query("SELECT * FROM tbl_sales_rate WHERE date = '$date' && plants = '$plant'")->result_array();
// 		}else{
// 		    $data['history']= $this->Base_model->getAll('tbl_sales_rate');
// 		}
		
        $this->load_template('','salesrates/edit_salesrateHistory',$data);
	}
	
	public function changeSalerate(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		if($this->input->post()){
		    $rate_id=$this->input->post('rate_id');
		    $sale_rate=$this->input->post('sale_rate');
		    foreach($rate_id as $n=>$rate){
		      //  echo $rate.' '.$sale_rate[$n];
		      //  echo "<br>";
		        $price = round($sale_rate[$n], 2);
        	    $intVal = intval($price);
                if ($price - $intVal < .50){
                    $amount = $intVal;
                }else{
                    $amount = $intVal+1;
                } 
        		 $data = array(
        			"sale" => $amount,
        		 );
        		 /*if($_POST["name"] == 'absent_days'){
        		     $data['present_days'] = 30-$_POST['value'];
        		 }*/
        	     $this->db->update('tbl_sales_rate', $data, array('id' => $rate));
		    }
		   	$this->session->set_userdata(array('success_message' => "Sale rate updated successfully"));
		   	//$this->output->set_header("Location: " . base_url() . 'SaleRate'.$queryGet, TRUE, 302);
			$this->output->set_header("Location: " . base_url() . 'SaleRate/manage_salerateHistory', TRUE, 302);
		}
		
// 		$role_permissions  = explode(",",$this->session->userdata('permissions'));
// 		if(!empty($role_permissions) && !in_array(77,$role_permissions)) {
// 			$this->session->set_userdata(array('error_message' => "Access Denied!"));
// 			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
// 		}
       
		
        
	}
	
	public function delete(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(78,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
 
		    $date = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date'])));
		    $plant=$_GET['plant'];
		    $this->db->query("DELETE FROM tbl_sales_rate WHERE date = '$date' && plants = '$plant'");
        $this->session->set_userdata(array('success_message' => "Sale rate deleted successfully"));
		redirect('SaleRate/manage_salerateHistory');
		exit;
	}
	
	
	public function addSalerate(){
	    
	    $role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(75,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$this->form_validation->set_rules('date', 'Date', 'required');
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'SaleRate', TRUE, 302);
		} else {
			$date	            =		date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('date'))));
			$plantID		    =		$this->input->post('plants');
			//$category		    =		$this->input->post('category');
			//echo var_dump($category);exit;
			
			$queryGet = '?date='.$date.'&plants='.$plantID;
			
			if(!empty($plantID)){
			   //$qrry = $this->db->query("SELECT date, plants FROM tbl_sales_rate WHERE date = '".$date."' AND plants = '".$plantID."' AND category IN ('" .implode("','", $category  ) . "')");
			   $qrry = $this->db->query("SELECT date, plants FROM tbl_sales_rate WHERE date = '".$date."' AND plants = '".$plantID."'");
			}
			 $count = $qrry->num_rows();
			if($count > 0) {
			   $this->session->set_userdata(array('error_message' => "Sale Rate Already Exists on this date. If you want some modification plese visit sale rate history"));
			   $this->output->set_header("Location: " . base_url() . 'SaleRate'.$queryGet, TRUE, 302);
			}else{
			// $data['categories'] = $this->Base_model->getAll('tbl_category','',"fld_category NOT IN (SELECT category FROM tbl_sales_rate WHERE date = '".$date."') AND fld_id IN ('" .implode("','", $category  ) . "')",'');
			 $data['categories'] = $this->Base_model->getAll('tbl_category','',"fld_category NOT IN (SELECT category FROM tbl_sales_rate WHERE date = '".$date."')",'');
		      $categories = $data['categories'];
		      
		      $queryGet = '?date='.$date.'&plants='.$plantID;
		      
			  //$data = array();
			  foreach ($categories as $row) {
			        
				// 	$data = array(
				// 		'date'              =>      date('Y-m-d', strtotime($date)),
				// 		'plants'            =>      $plantID,
				// 		'category'          =>      $row['fld_id'],
				// 		'sub_category'      =>      '',
				// 		'purchase'          =>      0,
				// 		'sale'              =>      0,
				// 		'created_by'        =>      $this->session->userdata('user_id'),
				// 	);
					
			 //   $categories = $this->db->insert('tbl_sales_rate', $data);
			
			//$subcategories = $this->Base_model->getAll('tbl_subcategory','',"fld_cid IN ('" .implode("','", $category  ) . "')",'');
			$subcategories = $this->Base_model->getAll('tbl_subcategory','',array('fld_cid'=>$row['fld_id']),'');
		    $data2 = array();
			        foreach ($subcategories as $row2) {
			        $data = array(
						'date'              =>      date('Y-m-d', strtotime($date)),
						'plants'            =>      $plantID,
						'category'          =>      $row2['fld_cid'],
						'sub_category'      =>      $row2['fld_subcid'],
						'purchase'          =>      0,
						'sale'              =>      0,
						'created_by'        =>      $this->session->userdata('user_id'),
					);
					$subcategoriess = $this->db->insert('tbl_sales_rate', $data);
			        }
			       
			       //var_dump($data2);exit; 
			       //$subcategoriess = $this->db->insert_batch('tbl_sales_rate', $data2);  
			       
			}
	
			if($subcategoriess){
			    /****************** Activity Log *****************************/
				$user_role=$this->session->userdata('user_role');
				$user_role_name=$this->session->userdata('user_role_name');
				$user_id=$this->session->userdata('user_id');
				$sale_rate_date=date('Y-m-d', strtotime($date));
				$client_ip=$this->Gen->get_client_ip();
				$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'ADD',fld_detail='Sale rate date $sale_rate_date',fld_ip_address='$client_ip'");
				$this->session->set_userdata(array('success_message' => "Sale rate added successfully"));
				$this->output->set_header("Location: " . base_url() . 'SaleRate'.$queryGet, TRUE, 302);
			}else{
				$this->session->set_userdata(array('error_message' => "Sale rate not added. Something went wrong"));
				$this->output->set_header("Location: " . base_url() . 'SaleRate'.$queryGet, TRUE, 302);
			}
		  }
		}
	}
	public function salerate_report(){
	    	if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(271,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
        $this->title = "Sale Rate Report";
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),    
		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		$this->Gen->get_script_url('plugin_components','timepicker/bootstrap-material-datetimepicker.js'),
        $this->Gen->get_script_url('custom_js','hrm.js'),
		
		);
		$data['view_css']=array(
		$this->Gen->get_script_url('theme_css','bootstrap3.css'),
		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap3-editable/css/bootstrap-editable.css'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
		$this->Gen->get_script_url('plugin_components','timepicker/bootstrap-material-datetimepicker.css'),
		);
		
		
		if(isset($_GET['date_from'])){
		    $datefrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_from'])));
		    $dateto = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_to'])));
		    $filter = $_GET['filter'];
		    $plant=$_GET['plants'];
		    if($filter != ""){
		        $filter=$filter;
		    }else{
		        $filter="Date_Wise";
		    }
		    if($plant != ""){
		    $plant ="&& plants = '{$_GET['plants']}'";
		    }else{
		     $plant="";   
		    }
		    $group_by = "tbl_sales_rate.date";
			$select="tbl_sales_rate.date as filter_text,tbl_sales_rate.date as filter_value";
		switch ($filter) {
		  case "Date_Wise":
			$group_by = "tbl_sales_rate.date";
			$select="tbl_sales_rate.date as filter_text,tbl_sales_rate.date as filter_value";
			break;
		  case "Rate_Wise":
			$group_by = "tbl_sales_rate.sale";
			$select="tbl_sales_rate.sale as filter_text,tbl_sales_rate.sale as filter_value";
			break;
		case "Plant_Wise":
			$group_by = "tbl_sales_rate.plants";
			$select="tbl_locations.fld_location as filter_text,tbl_sales_rate.plants as filter_value";
			break;
		
		}
		    $sale_rate_history = $this->db->query("SELECT $select FROM tbl_sales_rate JOIN tbl_locations ON tbl_locations.fld_id=tbl_sales_rate.plants WHERE tbl_sales_rate.date between '$datefrom' and '$dateto' $plant && tbl_sales_rate.sub_category = '4' &&  tbl_sales_rate.sale > 0  group by $group_by")->result_array();
		    //echo '<pre>';
		    //print_r($this->db->last_query());
		    //exit;
		    if($sale_rate_history){
		        foreach($sale_rate_history as $key => $rate){
		            
		            $column=$rate['filter_value'];
		            $sale_rate_history_detail = $this->db->query("SELECT * FROM tbl_sales_rate JOIN tbl_locations ON tbl_locations.fld_id=tbl_sales_rate.plants WHERE tbl_sales_rate.date between '$datefrom' and '$dateto' $plant && tbl_sales_rate.sub_category = '4' && tbl_sales_rate.sale > 0 && '$column' = $group_by")->result_array();
		            /*echo '<pre>';
		            print_r($sale_rate_history_detail);
		            print_r($rate);
		            print_r($this->db->last_query());
		            exit;*/
		            $sale_rate_history[$key]['detail']= $sale_rate_history_detail;
		        }
		    }
		    $data['sale_rate_history']=$sale_rate_history;
		}
		
	   
        $this->load_template('','salesrates/salerate_report',$data);
	}
	public function Saleratereportfilter(){

			$datefrom	            =		date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('date_from'))));
			$dateto	            =		date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('date_to'))));
			
			$plantID		    =		$this->input->post('plants');
			$filter		    =		$this->input->post('filter');
			//$category		    =		$this->input->post('category');
			//echo var_dump($category);exit;
			
			$queryGet = '?date_from='.$datefrom.'&date_to='.$dateto.'&plants='.$plantID.'&filter='.$filter;
			
			$this->output->set_header("Location: " . base_url() . 'SaleRate/salerate_report'.$queryGet, TRUE, 302);
	}
	
	public function SaleratereportfilterByDay(){
            
        $datestart = date('d/m/Y');
		$dateend = date('d/m/Y');
		$datefrom = str_replace('/', '-', $datestart);
		$dateto = str_replace('/', '-', $dateend);
            
			//$datefrom	        =		date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('date_from'))));
			//$dateto	            =		date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('date_to'))));
			$plantID		    =		$this->input->post('plants');
			$filter		        =		$this->input->post('filter');
			//$category		    =		$this->input->post('category');
			//echo var_dump($category);exit;
			$queryGet = '?date_from='.$datefrom.'&date_to='.$dateto.'&plants='.$plantID.'&filter='.$filter;
			$this->output->set_header("Location: " . base_url() . 'SaleRate/salerate_report'.$queryGet, TRUE, 302);
	}
	
	public function SaleratereportfilterByWeek(){
            
        $datestart = date('d/m/Y', strtotime("this week"));
		$dateend = date('d/m/Y', strtotime("+6 day, this week"));
		$datefrom = str_replace('/', '-', $datestart);
		$dateto = str_replace('/', '-', $dateend);
            
			//$datefrom	        =		date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('date_from'))));
			//$dateto	            =		date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('date_to'))));
			$plantID		    =		$this->input->post('plants');
			$filter		        =		$this->input->post('filter');
			//$category		    =		$this->input->post('category');
			//echo var_dump($category);exit;
			$queryGet = '?date_from='.$datefrom.'&date_to='.$dateto.'&plants='.$plantID.'&filter='.$filter;
			$this->output->set_header("Location: " . base_url() . 'SaleRate/salerate_report'.$queryGet, TRUE, 302);
	}
	
	public function SaleratereportfilterByMonth(){
            
        $dateend = date('d/m/Y');
		$datefrom = date('d/m/Y',mktime(0, 0, 0, date('m'), 1, date('Y')));
		$dateto = str_replace('/', '-', $dateend);
            
			//$datefrom	        =		date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('date_from'))));
			//$dateto	            =		date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('date_to'))));
			$plantID		    =		$this->input->post('plants');
			$filter		        =		$this->input->post('filter');
			//$category		    =		$this->input->post('category');
			//echo var_dump($category);exit;
			$queryGet = '?date_from='.$datefrom.'&date_to='.$dateto.'&plants='.$plantID.'&filter='.$filter;
			$this->output->set_header("Location: " . base_url() . 'SaleRate/salerate_report'.$queryGet, TRUE, 302);
	}
	
	public function SaleratereportfilterByYear(){
            
        $datestart = date('d/m/Y',strtotime('first day of January '.date('Y')));
		$dateend   = date('d/m/Y');
		$datefrom  = str_replace('/', '-', $datestart);
		$dateto    = str_replace('/', '-', $dateend);
            
			//$datefrom	        =		date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('date_from'))));
			//$dateto	        =		date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('date_to'))));
			$plantID		    =		$this->input->post('plants');
			$filter		        =		$this->input->post('filter');
			//$category		    =		$this->input->post('category');
			//echo var_dump($category);exit;
			$queryGet = '?date_from='.$datefrom.'&date_to='.$dateto.'&plants='.$plantID.'&filter='.$filter;
			$this->output->set_header("Location: " . base_url() . 'SaleRate/salerate_report'.$queryGet, TRUE, 302);
	}
	
	public function addSaleratehistoryfilter(){

			$date	            =		date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('date'))));
			$plantID		    =		$this->input->post('plants');
			//$category		    =		$this->input->post('category');
			//echo var_dump($category);exit;
			
			$queryGet = '?date='.$date.'&plants='.$plantID;
			$this->output->set_header("Location: " . base_url() . 'SaleRate/manage_salerateHistory'.$queryGet, TRUE, 302);
	}
	
	public function update_salerate(){
	   // print_r($_POST);
	   // exit();
	   if($this->input->post()){
		    $rate_id=$this->input->post('rate_id');
		    $sale_rate=$this->input->post('sale_rate');
		    foreach($rate_id as $n=>$rate){
		      //  echo $rate.' '.$sale_rate[$n];
		      //  echo "<br>";
		      $price = round($sale_rate[$n], 2);
        	    $intVal = intval($price);
                if ($price - $intVal < .50){
                    $amount = $intVal;
                }else{
                    $amount = $intVal+1;
                } 
        		 $data = array(
        			"sale" => $amount,
        		 );
        		 /*if($_POST["name"] == 'absent_days'){
        		     $data['present_days'] = 30-$_POST['value'];
        		 }*/
        	     $this->db->update('tbl_sales_rate', $data, array('id' => $rate));
		    }
		    $date=$_POST['date'];
		    $plant=$_POST['plant'];
		    
		   	$this->session->set_userdata(array('success_message' => "Sale rate updated successfully"));
				$this->output->set_header("Location: " . base_url() . 'SaleRate/edit?date='.$date.'&plant='.$plant, TRUE, 302);
		}
	   
	}
	
    
}
