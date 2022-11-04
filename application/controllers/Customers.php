<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends My_controller {
	
	function __construct() {
        parent::__construct();
        $this->load->model('Customer_model');
        $this->load->model('Common_model');
    }
	
	public function index()
    {
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(62,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
        $this->title = "New Customer";
		
		$maxSuplierID=$this->Customer_model->getMaxsuplierID();
		$data['maxid']='C-'.sprintf('%03d', $maxSuplierID['Auto_increment']);
		$data['view_scripts']=array(
		  	$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'),
		  	$this->Gen->get_script_url('','https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js'),
		  	$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
		  	$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		);
		$data['view_css']=array(
		   $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
        $this->load_template('','addCustomer',$data);
    }
	public function add(){
		$this->form_validation->set_rules('fld_customer_code', 'Customer code', 'required');
		$this->form_validation->set_message('fld_customer_name', 'Customer name', 'required');
		$this->form_validation->set_message('fld_company_name', 'Company name', 'required');
		$this->form_validation->set_message('fld_mobile_num', 'Mobile number', 'required');
		$this->form_validation->set_message('fld_customer_type', 'Customer type', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Customers', TRUE, 302);
		} else {
			$data = array(
            'fld_customer_code' => $this->input->post('fld_customer_code',TRUE),
            'fld_company_name'  => $this->input->post('fld_company_name',TRUE),
            'fld_customer_name' => $this->input->post('fld_customer_name',TRUE),
            'fld_mobile_num'    => $this->input->post('fld_mobile_num',TRUE),
            'fld_landline_num'  => $this->input->post('fld_landline_num',TRUE),
            'fld_opening_bal'   => $this->input->post('fld_opening_bal',TRUE),
            'fld_customer_type' => $this->input->post('fld_customer_type',TRUE),
            'fld_email'         => $this->input->post('fld_email',TRUE),
            'fld_cnic'          => $this->input->post('fld_cnic',TRUE),
            'fld_city'          => $this->input->post('fld_city',TRUE),
            'fld_ntn'           => $this->input->post('fld_ntn',TRUE),
            'fld_city_area'     => $this->input->post('fld_city_area',TRUE),
            'fld_country'       => $this->input->post('fld_country',TRUE),
            'fld_created_date'  =>  date("Y-m-d H:i:s"),
            'fld_status'        => 1
        );
         
        $customer=$this->db->insert('tbl_customers',$data);
		if($customer){
		    $customer_id=$this->db->insert_id();
            $account_id = 101007;
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
              'head_name'       =>  $data['fld_customer_name'].' ('.$data['fld_customer_code'].')',
              'parent_head_name'      =>  $getHeadCodeData->head_name,
              'head_level'      =>  $newlevel,
              'type'            => 'CUSTOMER',
              'type_id'         => $customer_id
            ); 
            $this->db->insert('tbl_coa',$acc_data);
            $this->db->query("UPDATE tbl_customers SET accounts_id='$HeadCode' WHERE fld_id = '$customer_id'");
            /****************** Activity Log *****************************/
				$user_role=$this->session->userdata('user_role');
				$user_role_name=$this->session->userdata('user_role_name');
				$user_id=$this->session->userdata('user_id');
				$customer_no=$this->input->post('fld_customer_code',TRUE);
				$customer_no='<a href="'.base_url('Customers/viewCustomer/'.$customer_id.'').'">'.$customer_no.'</a>';
				$client_ip=$this->Gen->get_client_ip();
				$address=$this->Base_model->getLocation($client_ip);
    	        $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	        $date=date('Y-m-d H:i:s');
				$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'ADD',fld_detail='$customer_no',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Customer added successfully"));
            $this->output->set_header("Location: " . base_url() . 'Customers', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Customer not added.Something went wrong"));
            $this->output->set_header("Location: " . base_url() . 'Customers', TRUE, 302);
		}
			
		}
	}
	public function edit($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(64,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
        $this->title = "Update Customer";
		$data['customer']=$this->Base_model->getRow('tbl_customers','','fld_id ='.$id.'');
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
        $this->load_template('','editCustomer',$data);
	}
	public function editProcess(){
		
			$this->form_validation->set_rules('fld_customer_code', 'Customer code', 'required');
			$this->form_validation->set_message('fld_customer_name', 'Customer name', 'required');
			$this->form_validation->set_message('fld_company_name', 'Company name', 'required');
			$this->form_validation->set_message('fld_mobile_num', 'Mobile number', 'required');
			$this->form_validation->set_message('fld_customer_type', 'Customer type', 'required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_userdata(array('error_message' => validation_errors()));
				$this->output->set_header("Location: " . base_url() . 'Customers', TRUE, 302);
			} else {
				$data = array(
				'fld_customer_code' => $this->input->post('fld_customer_code',TRUE),
				'fld_company_name'       => $this->input->post('fld_company_name',TRUE),
				'fld_customer_name'      => $this->input->post('fld_customer_name',TRUE),
				'fld_mobile_num'        => $this->input->post('fld_mobile_num',TRUE),
				'fld_landline_num'         => $this->input->post('fld_landline_num',TRUE),
				'fld_opening_bal'       => $this->input->post('fld_opening_bal',TRUE),
				'fld_customer_type'   => $this->input->post('fld_customer_type',TRUE),
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
			
			 $cus_id=$this->input->post('fld_customer_id');
			 $this->db->where('fld_id',$cus_id);
			//$this->db->set('fld_updated_date', 'NOW()', FALSE);
			$customer=$this->db->update('tbl_customers',$data);
			
			$acc_data = array(
              'head_name'       =>  $data['fld_customer_name'].' '. '('.$data['fld_customer_code'].')',
             ); 
             
            $this->db->update('tbl_coa', $acc_data, array('type'=>'CUSTOMER', 'type_id' => $cus_id));
			
			if($customer){
			    /****************** Activity Log *****************************/
				$user_role=$this->session->userdata('user_role');
				$user_role_name=$this->session->userdata('user_role_name');
				$user_id=$this->session->userdata('user_id');
				$customer_no=$this->input->post('fld_customer_code',TRUE);
				$customer_no='<a href="'.base_url('Customers/viewCustomer/'.$cus_id.'').'">'.$customer_no.'</a>';
				$client_ip=$this->Gen->get_client_ip();
				$address=$this->Base_model->getLocation($client_ip);
    	        $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	        $date=date('Y-m-d H:i:s');
				$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'UPDATE',fld_detail='$customer_no',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
				$this->session->set_userdata(array('success_message' => "Customer updated successfully"));
				$this->output->set_header("Location: " . base_url() . 'Customers/manage_Customers', TRUE, 302);
			}else{
				$this->session->set_userdata(array('error_message' => "Customer not updated.Something went wrong"));
				$this->output->set_header("Location: " . base_url() . 'Customers/edit/'.$sup_id.'', TRUE, 302);
			}
				
			}
		
	}
	public function viewCustomer($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(65,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
        $this->title = "Customer Details";
		$data['customer']=$this->Base_model->getRow('tbl_customers','','fld_id ='.$id.'');
		if(empty($data['customer'])){
	      $this->session->set_userdata(array('error_message' => "This record does not exist."));
		  $this->output->set_header("Location: " . base_url() . 'Settings/log_system', TRUE, 302);
		}
        $this->load_template('','viewCustomer',$data);
	}
	public function delete($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$id=$this->input->post('customer_id');
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(66,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$responce=$this->Base_model->delete('tbl_customers','fld_id ='.$id.'');
        if($responce){
            /****************** Activity Log *****************************/
			$user_role=$this->session->userdata('user_role');
			$user_role_name=$this->session->userdata('user_role_name');
			$user_id=$this->session->userdata('user_id');
			$customer_no='C-'.sprintf('%03d', $id);
			$client_ip=$this->Gen->get_client_ip();
			$address=$this->Base_model->getLocation($client_ip);
        	$device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	    $date=date('Y-m-d H:i:s');
			$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'DELETED',fld_detail='$customer_no',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Customer deleted successfully"));
			$this->output->set_header("Location: " . base_url() . 'Customers/manage_Customers', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Customer not deleted.Something went wrong"));
			$this->output->set_header("Location: " . base_url() . 'Customers/manage_Customers', TRUE, 302);
		}
	}
	
	public function manage_Customers()
    {
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(63,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$this->title = "View Customers";
		$data['view_scripts']=array(
    		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
    		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
    		$this->Gen->get_script_url('custom_js','customer.js'),
		);
		$data['view_css']=array(
		
		);
       
		$data['customer']=$this->Base_model->getAll('tbl_customers');
        $this->load_template('','manage_customers',$data);
    }
    
     public function manage_CustomersList()
    {
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(178,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$this->title = "View Customers";
		$data['view_scripts'] = array(
    		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
    		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
    		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
    		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
        	$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
        	$this->Gen->get_script_url('custom_js','customer.js'),
        	
		);
		$data['view_css'] = array(
		    $this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
    	    $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
		$data['locations']=$this->Base_model->getAll('tbl_locations');
// 		$data['customer']=$this->Base_model->getAll('tbl_customers');
    //     if ($this->input->post()){
    //         $start=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('from_date'))));
		  //  $end=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('to_date'))));
		  ////  echo "select * from tbl_customers where fld_id in (select fld_customer_id from tbl_sale where fld_sale_date >= '$start' && fld_sale_date <= '$end')";
    //         // print_r($_POST);
    //         // exit;
    //         // $location=$this->input->post('fld_location');
    //         $where='';
    //         // if(!empty($location)){
    //         //     $where .= " && fld_location_id='$location' ";
    //         // }
    //         // if($this->input->post("saletype")==1){
    //             //echo "select * from tbl_customers where fld_id in (select fld_customer_id from tbl_sale where fld_sale_date >= '$from' && fld_sale_date <= '$to' $where)";
    //             $data['customer']=$this->db->query("select * from tbl_customers where fld_id in (select fld_customer_id from tbl_sale where fld_sale_date >= '$start' && fld_sale_date <= '$end' $where)")->result_array();
    //         // }else{
    //             //echo "select * from tbl_customers where fld_id not in (select fld_customer_id from tbl_sale where fld_sale_date >= '$from' && fld_sale_date <= '$to' $where)";
    //             // $data['customer']=$this->db->query("select * from tbl_customers where fld_id not in (select fld_customer_id from tbl_sale where fld_sale_date >= '$from' && fld_sale_date <= '$to' $where)")->result_array();
    //         // }
    //         //exit;
            
    //     }else{
    //         $data['customer']=$this->Base_model->getAll('tbl_customers');
    //     }
        $data['customer']=$this->Base_model->getAll('tbl_customers');
        $this->load_template('','customerslist',$data);
    }
    public function print_customers_report(){
        
        $filter=$this->input->get('filter');
	   // exit;
		include_once APPPATH.'/third_party/autoload.php';
		//$this->load->view('print_purchase_report');
		$mpdf = new \Mpdf\Mpdf();
		$from=date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $this->input->get('from_date',TRUE))));
        $to=date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $this->input->get('to_date',TRUE))));
		$data['customer']=$this->db->query("select * from tbl_customers where fld_id in (select fld_customer_id from tbl_sale where fld_sale_date >= '$from' && fld_sale_date <= '$to')")->result_array();
		
		$data['filter_type']=1;
		$data['get']=$_GET;
		//echo '<pre>';
		//print_r($data['customer']);
		//exit;
		$html = $this->load->view('customer_report_pdf',$data,true);
	
		$mpdf->WriteHTML($html);
		$mpdf->Output('Customer Report.pdf','D');
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$user_id=$this->session->userdata('user_id');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
        $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
        $date=date('Y-m-d H:i:s');
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'Genrate',fld_detail='Customer Report PDF',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
       
    }
    public function customers_report_csv(){
	    $filter=$this->input->get('filter');
		include_once APPPATH.'/third_party/autoload.php';

		$from=date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $this->input->get('from_date',TRUE))));
        $to=date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $this->input->get('to_date',TRUE))));
		$data['customer']=$customer=$this->db->query("select * from tbl_customers where fld_id in (select fld_customer_id from tbl_sale where fld_sale_date >= '$from' && fld_sale_date <= '$to')")->result_array();
        $header_row = array("#", "Customer Code", "Customer Name", "Last plant(Sale)" , " Mobile", "Last Sale Date", "Last Sale Amount");
        $csvName = 'customerreport'.'.csv';
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="'.$csvName.'";');
        $output = fopen('php://output', 'w');
        
        fputcsv($output,$header_row);
        $i=1;
        foreach($customer as $row){
            $saledate=$this->db->select("*")->from("tbl_sale")->where('fld_customer_id' , $row['fld_id'] )->get()->row_array();
		   
		    $location=$this->db->select("*")->from("tbl_locations")->where('fld_id' , $saledate['fld_location_id'] )->get()->row_array();
            $dataValus=array($i,$row['fld_customer_code'], $row['fld_customer_name'],$location['fld_location'],$row['fld_mobile_num'],date("d-m-Y",strtotime($saledate['fld_sale_date'])),number_format($saledate['fld_grand_total_amount'],2));
            fputcsv($output,$dataValus);
            $i++;
        }
            
        fclose($output);
        $user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$user_id=$this->session->userdata('user_id');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
        $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
        $date=date('Y-m-d H:i:s');
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'Genrate',fld_detail='Customer Report CSV',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
        exit();
            
		
		
		
	}
    public function customer_ledger()
    {
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(127,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$this->title = "Customer Ledger";
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
       
		$data['customers']=$this->Base_model->getAll('tbl_customers');
		$data['getshipments']=$this->Base_model->getAll('tbl_purchase');
        $this->load_template('','customer_ledger',$data);
    }
	
}
