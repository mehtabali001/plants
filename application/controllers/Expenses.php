<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expenses extends My_controller {
	
	function __construct() {
        parent::__construct();
        $this->CI = & get_instance();
        $CI =& get_instance();
        $this->load->model('Common_model');
        $this->load->model('Expenses_model');
        $this->load->model('Purchase_model');
    }
	
	public function index()
    {
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(53,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
        $this->title = "New Expense ";
        
        $autoVoucherID=$this->Expenses_model->getMaxexpenseID();
		$data['autoVoucherID']='EI-'.sprintf('%03d', $autoVoucherID['Auto_increment']);
// 		$data['units']=$this->Base_model->getAll('tbl_units');
        $data['stationary']=$this->Expenses_model->getAllStationary('tbl_stationary');
	  $data['units']=$this->Base_model->getAll('tbl_units');
	  $data['supplier']=$this->Base_model->getAll('tbl_suppliers');
	  $data['expense_group']=$this->Base_model->getAll('tbl_expense_group');
	  $data['subcategory']=$this->Base_model->getAll('tbl_subcategory');
		
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
		
        $this->load_template('','expenses/addExpense',$data);
    }
    
	public function add(){

		$this->form_validation->set_rules('plant_for', 'Plant For', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Expenses', TRUE, 302);
		} 
		else{
		    //$date	            =		date('Y-m-d', strtotime($this->input->post('date_added')));
		     $date	            =       date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('date_added',TRUE))));
		     //$expense_item		=		$this->input->post('expense_item');
		 	 $plantID		    =		$this->input->post('plant_for');
		//	 $queryGet = '?date='.$date.'&plants='.$plantID;
			
			/*if(!empty($plantID)){
			   $qrry = $this->db->query("SELECT date_added, plant_for FROM tbl_expenses WHERE date_added = '".$date."' AND plant_for = '".$plantID."'");
			}
			 $count = $qrry->num_rows();
			if($count > 0) {
			   $this->session->set_userdata(array('error_message' => "Expense Item Already Exists on this date."));
			   $this->output->set_header("Location: " . base_url() . 'Expenses', TRUE, 302);
			}else{*/

			$data = array(
                'date_added' => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('date_added',TRUE)))),
                'expense_voucher'=> $this->input->post('expense_voucher',TRUE),
                'plant_for'=> $this->input->post('plant_for',TRUE),
                'plant_from'=> $this->input->post('plant_from',TRUE),
                //'payment_type' => $this->input->post('payment_type',TRUE),
                'fld_grand_total_amount' => $this->input->post('fld_grand_total_amount',TRUE),
                //'detail' => $this->input->post('detail',TRUE),
                'fld_userid' => $this->session->userdata('user_id'),
                'fld_created_date'   =>  date("Y-m-d H:i:s"),
                'status' => 1,
        );
        
        $expenses = $this->db->insert('tbl_expenses',$data);
        $id = $this->db->insert_id();
        $now = date('Y-m-d H:i:s');
        if($expenses){
            $this->db->query("INSERT into tbl_transections_master SET type = 'Expense', type_id='$id', date = '{$data['date_added']}', user_id = '{$data['fld_userid']}', created_date = '$now'");
            $v_id = $this->db->insert_id();
            $expense_coa_id = $this->db->query("SELECT * FROM tbl_locations WHERE petty_cash = '{$data['plant_from']}'")->row()->office_mess_expense;
		     $narrationhead = '';
		     
		  $totalquantity=0;
		  $insert_id = $id;
		  $exp_type = $this->input->post('expense_type',TRUE);
		  $exp_value = $this->input->post('expense_value',TRUE);
		  $e_id = $this->input->post('fld_expense_id',TRUE);
		  $quantity = $this->input->post('quantity',TRUE);
		  //echo $quantity;exit;
		  $unit = $this->input->post('unit',TRUE);
		 // $payment_type = $this->input->post('payment_type',TRUE);
		  $remarks = $this->input->post('remarks',TRUE);
		  $unit_price = $this->input->post('unit_price',TRUE);
		  //$sub_total = $this->input->post('sub_total',TRUE);
		  $total_coa_amount = 0;
		  for ($i = 0, $n = count($e_id); $i < $n; $i++) {
		    $narration = $narrationhead;
			
			$exptype = $exp_type[$i];
			if($exptype == 1){
			    $totalquantity=$totalquantity + 0;
			    $unitid = '';
			}else{
			    $totalquantity=$totalquantity + $quantity[$i];
			    $unitid = $unit[$i];
			}
			
			$expvalue = $exp_value[$i];
			$expense_id = $e_id[$i];
            $exp_quantity = $quantity[$i];
            
            //$paytype = $payment_type[$i];
            $detail = $remarks[$i];
            $un_price = $unit_price[$i];
            $total_coa_amount += $un_price;
           // $total = $sub_total[$i];
            // $disc = $discount[$i];
            $disc=0;
            // if(!$unitid){
            //     $unitid = 0;
            // }
            $expense_value = $this->db->select('*')->from('tbl_expense_type')->where('expense_type', $exptype)->get()->row()->expense_value;
            $sname = $this->db->select('*')->from('tbl_stationary')->where('id', $expense_id)->get()->row()->name;
            
            $account_name = $this->db->select('*')->from('tbl_coa')->where('head_code', $data['plant_from'])->get()->row()->head_name;
            
            

            $data1 = array(
                'expense_type'      => $exptype,
                'expense_value'     => $expvalue,
                'fld_expense_id'    => $insert_id,
                'stationary'        => $expense_id,
                'quantity'          => $exp_quantity,
                'unit'              => $unitid,
                //'payment_type'      => $paytype,
                'remarks'           => $detail,
                'unit_price'        => $un_price,
                //'sub_total'         => $total
            );

                $this->db->insert('tbl_expense_detail', $data1);
        }
        
        
        $this->db->query("INSERT INTO tbl_transections_details SET v_id = '$v_id', coa_id = '$expense_coa_id', narration = 'Mess Expense', debit = '{$data['fld_grand_total_amount']}'");
        
        $this->db->query("INSERT INTO tbl_transections_details SET v_id = '$v_id', coa_id = '{$data['plant_from']}', narration = 'Mess Expense', credit = '{$data['fld_grand_total_amount']}'");
            
        }
        
        if(isset($_POST['expense_draft'])){
            $did = $_POST['id'];
            $this->db->where('id', $did);
            $this->db->delete('tbl_expenses_draft');
            $this->db->where('fld_expense_id', $did);
            $this->db->delete('tbl_expense_draft_detail');
        }
        
        $q = $this->db->get_where('tbl_expenses', array('id' => $id));
        $qq = $q->row();
        $plantid = '?plants='.$qq->plant_for;
        //$data['plantid'] = $qq->plants;
        
        if (isset($_POST['add_expense']) && $expenses) {
            
            /****************** Activity Log *****************************/
			$user_role=$this->session->userdata('user_role');
			$user_role_name=$this->session->userdata('user_role_name');
			$user_id=$this->session->userdata('user_id');
			$expense_voucher=$this->input->post('expense_voucher',TRUE);
			$client_ip=$this->Gen->get_client_ip();
			$address=$this->Base_model->getLocation($client_ip);
            $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
            $date=date('Y-m-d H:i:s');
			$expense_voucher='<a href="'.base_url('Expenses/detail/'.$insert_id.'').'">'.$expense_voucher.'</a>';
			$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'ADD',fld_detail='$expense_voucher',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
            $this->session->set_userdata(array('success_message' => "Expense added successfully"));
            $this->output->set_header("Location: " . base_url() . 'Expenses/manage_Expenses', TRUE, 302);
        }
		else if (isset($_POST['add-expense-another']) && $expenses) {
		    /****************** Activity Log *****************************/
			$user_role=$this->session->userdata('user_role');
			$user_role_name=$this->session->userdata('user_role_name');
			$user_id=$this->session->userdata('user_id');
			$expense_voucher=$this->input->post('expense_voucher',TRUE);
			$client_ip=$this->Gen->get_client_ip();
			$address=$this->Base_model->getLocation($client_ip);
            $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
            $date=date('Y-m-d H:i:s');
			$expense_voucher='<a href="'.base_url('Expenses/detail/'.$insert_id.'').'">'.$expense_voucher.'</a>';
			$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'ADD',fld_detail='$expense_voucher',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
            $this->session->set_userdata(array('success_message' => "Expense added successfully"));
            $this->output->set_header("Location: " . base_url() . 'Expenses'.$plantid, TRUE, 302);
            //$this->load_template('','expenses/addanotherExpense',$data);
        }else{
            $this->session->set_userdata(array('error_message' => "Expense not added.Something went wrong"));
            $this->output->set_header("Location: " . base_url() . 'Expenses', TRUE, 302);
        }
		//}
		}
	}
	
	
	public function edit($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(55,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
        $this->title = "Edit Expense ";
        $data['units']=$this->Base_model->getAll('tbl_units');
        $data['stationary']=$this->Expenses_model->getAllStationary('tbl_stationary');
		$data['expense']=$this->Base_model->getRow('tbl_expenses','','id ='.$id.'');
		 $data['expense_group']=$this->Base_model->getAll('tbl_expense_group');
		$data['view_scripts']=array(
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
		// echo '<pre>';
		// print_r($data['category']);
		// exit;
        $this->load_template('','expenses/editExpense',$data);
	}
	
	public function editProcess(){

		$this->form_validation->set_rules('expense_voucher', 'Expense voucher', 'required');
		$expense_id = $this->input->post('expense_id');
		//echo $id;exit;
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Expenses/edit/'.$id.'', TRUE, 302);
		} else {
			
		     $date	            =       date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('date_added',TRUE))));
		 	 $plantID		    =		$this->input->post('plant_for');
			
		

			$data = array(
                //'date_added' => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('date_added',TRUE)))),
                'plant_for'=> $this->input->post('plant_for',TRUE),
                'plant_from'=> $this->input->post('plant_from',TRUE),
                'fld_grand_total_amount' => $this->input->post('fld_grand_total_amount',TRUE),
                'fld_userid' => $this->session->userdata('user_id'),
                'status' => 1,
                'fld_updated_by'       =>  $this->session->userdata('user_id'),
                'fld_updated_date'   =>  date("Y-m-d H:i:s")
        );
        
        $this->db->where('id', $expense_id);
        $this->db->update('tbl_expenses', $data);
        $now = date('Y-m-d H:i:s');
            $v_id = $this->db->query("SELECT id FROM tbl_transections_master WHERE type='Expense' AND type_id = '$expense_id'")->row()->id;
	    
    	    $this->db->where('v_id',$v_id);
    	    $this->db->delete('tbl_transections_details');
    	    
    	    $this->db->where('fld_expense_id',$expense_id);
    	    $this->db->delete('tbl_expense_detail');
    	    
            $expense_coa_id = $this->db->query("SELECT * FROM tbl_locations WHERE petty_cash = '{$data['plant_from']}'")->row()->office_mess_expense;
		     $narrationhead = '';
		     
		  $totalquantity=0;
		  $exp_type = $this->input->post('expense_type',TRUE);
		  $exp_value = $this->input->post('expense_value',TRUE);
		  $e_id = $this->input->post('fld_expense_id',TRUE);
		  $quantity = $this->input->post('quantity',TRUE);
		  //echo $quantity;exit;
		  $unit = $this->input->post('unit',TRUE);
		 // $payment_type = $this->input->post('payment_type',TRUE);
		  $remarks = $this->input->post('remarks',TRUE);
		  $unit_price = $this->input->post('unit_price',TRUE);
		  //$sub_total = $this->input->post('sub_total',TRUE);
		  $total_coa_amount = 0;
		  for ($i = 0, $n = count($e_id); $i < $n; $i++) {
		    $narration = $narrationhead;
			
			$exptype = $exp_type[$i];
			if($exptype == 1){
			    $totalquantity=$totalquantity + 0;
			    $unitid = '';
			}else{
			    $totalquantity=$totalquantity + $quantity[$i];
			    $unitid = $unit[$i];
			}
			
			$expvalue = $exp_value[$i];
			$expense_id_c = $e_id[$i];
            $exp_quantity = $quantity[$i];
            
            //$paytype = $payment_type[$i];
            $detail = $remarks[$i];
            $un_price = $unit_price[$i];
            $total_coa_amount += $un_price;
           // $total = $sub_total[$i];
            // $disc = $discount[$i];
            $disc=0;
            // if(!$unitid){
            //     $unitid = 0;
            // }
            $expense_value = $this->db->select('*')->from('tbl_expense_type')->where('expense_type', $exptype)->get()->row()->expense_value;
            $sname = $this->db->select('*')->from('tbl_stationary')->where('id', $expense_id_c)->get()->row()->name;
            
            $account_name = $this->db->select('*')->from('tbl_coa')->where('head_code', $data['plant_from'])->get()->row()->head_name;
            
            

            $data1 = array(
                'expense_type'      => $exptype,
                'expense_value'     => $expvalue,
                'fld_expense_id'    => $expense_id,
                'stationary'        => $expense_id_c,
                'quantity'          => $exp_quantity,
                'unit'              => $unitid,
                //'payment_type'      => $paytype,
                'remarks'           => $detail,
                'unit_price'        => $un_price,
                //'sub_total'         => $total
            );
            
            

                $this->db->insert('tbl_expense_detail', $data1);
        }
        $this->db->query("INSERT INTO tbl_transections_details SET v_id = '$v_id', coa_id = '$expense_coa_id', narration = 'Mess Expense', debit = '{$data['fld_grand_total_amount']}'");
        
        $this->db->query("INSERT INTO tbl_transections_details SET v_id = '$v_id', coa_id = '{$data['plant_from']}', narration = 'Mess Expense', credit = '{$data['fld_grand_total_amount']}'");
        /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$user_id=$this->session->userdata('user_id');
		$expense_voucher=$this->input->post('expense_voucher',TRUE);
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
        $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
        $date=date('Y-m-d H:i:s');
		$expense_voucher='<a href="'.base_url('Expenses/detail/'.$expense_id.'').'">'.$expense_voucher.'</a>';
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'UPDATE',fld_detail='$expense_voucher',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
        
         $this->session->set_userdata(array('success_message' => "Expense updated successfully"));
        $this->output->set_header("Location: " . base_url() . 'Expenses/manage_Expenses', TRUE, 302);
			
		}
	}
	
	
	public function detail($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(161,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
        $this->title = "Expense Details";
        $data['units']=$this->Base_model->getAll('tbl_units');
		$data['expense']=$this->Base_model->getRow('tbl_expenses','','id ='.$id.'');
		$data['previous']=$this->Base_model->getRow('tbl_expenses','id','id = (select max(id) from tbl_expenses where id < '.$id.')');
		$data['next']=$this->Base_model->getRow('tbl_expenses','id','id = (select min(id) from tbl_expenses where id > '.$id.')');

		$data['view_scripts']=array(
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
		if(empty($data['expense'])){
	      $this->session->set_userdata(array('error_message' => "This record does not exist."));
		  $this->output->set_header("Location: " . base_url() . 'Settings/log_system', TRUE, 302);
		}
        $this->load_template('','expenses/viewExpense',$data);
	}
	
	
	public function manage_Expenses()
    {

		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(54,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$this->title = "View Expenses ";
		$data['view_scripts']=array(
    		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
    		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
    		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		    $this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		    $this->Gen->get_script_url('plugin_components','timepicker/bootstrap-material-datetimepicker.js'),
		    $this->Gen->get_script_url('custom_js','expenses.js'),
		);
		$data['view_css']=array(
		    $this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'),
		    $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		    $this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
		    $this->Gen->get_script_url('plugin_components','timepicker/bootstrap-material-datetimepicker.css'),
		);
		
		if(isset($_GET['date']) && $_GET['plants'] && $_GET['name']){
		    $data['expenses'] = $this->db->query("SELECT * FROM tbl_expenses WHERE fld_isdeleted = 0 And date_added = '{$_GET['date']}' && plant_for = '{$_GET['plants']}' && expense_item = '{$_GET['name']}'")->result_array();
		}else if(isset($_GET['date']) && $_GET['plants']){
		    $data['expenses'] = $this->db->query("SELECT * FROM tbl_expenses WHERE fld_isdeleted = 0 And date_added = '{$_GET['date']}' && plant_for = '{$_GET['plants']}'")->result_array();
		}else{
		    $data['expenses']= $this->Base_model->getAll('tbl_expenses', '', array('fld_isdeleted'=>0), '');
		}
       
		//$data['expenses']=$this->Base_model->getAll('tbl_expenses');
        $this->load_template('','expenses/manage_Expenses',$data);
    }
    
    public function manage_trash()
    {
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(209,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$this->title = "View Trash ";
		$data['view_scripts']=array(
    		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
    		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
    		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		    $this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		    $this->Gen->get_script_url('plugin_components','timepicker/bootstrap-material-datetimepicker.js'),
		    $this->Gen->get_script_url('custom_js','expenses.js'),
		    //$this->Gen->get_script_url('custom_js','hrm.js'),
		);
		$data['view_css']=array(
		    $this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'),
		    $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		    $this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
		    $this->Gen->get_script_url('plugin_components','timepicker/bootstrap-material-datetimepicker.css'),
		);
		
		if(isset($_GET['date']) && $_GET['plants'] && $_GET['name']){
		    $data['expenses'] = $this->db->query("SELECT * FROM tbl_expenses WHERE fld_isdeleted = 1 And date_added = '{$_GET['date']}' && plant_for = '{$_GET['plants']}' && expense_item = '{$_GET['name']}'")->result_array();
		}else if(isset($_GET['date']) && $_GET['plants']){
		    $data['expenses'] = $this->db->query("SELECT * FROM tbl_expenses WHERE fld_isdeleted = 1 And date_added = '{$_GET['date']}' && plant_for = '{$_GET['plants']}'")->result_array();
		}else{
		    $data['expenses']= $this->Base_model->getAll('tbl_expenses', '', array('fld_isdeleted'=>1), '');
		}
       
		//$data['expenses']=$this->Base_model->getAll('tbl_expenses');
        $this->load_template('','expenses/manage_trash',$data);
    }
    
	public function delete($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(56,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$responce = $this->Expenses_model->delete($id);
        if($responce){
            /****************** Activity Log *****************************/
			$user_role=$this->session->userdata('user_role');
			$user_role_name=$this->session->userdata('user_role_name');
			$user_id=$this->session->userdata('user_id');
			$expense_voucher='EI-'.sprintf('%03d', $id);
			$client_ip=$this->Gen->get_client_ip();
			$address=$this->Base_model->getLocation($client_ip);
            $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
            $date=date('Y-m-d H:i:s');
			$expense_voucher='<a href="'.base_url('Expenses/detail/'.$id.'').'">'.$expense_voucher.'</a>';
			$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'TRASHED',fld_detail='$expense_voucher',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Expense is trashed, you need to delete it permanently from trash."));
			$this->output->set_header("Location: " . base_url() . 'Expenses/manage_Expenses', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Expense not trash.Something went wrong"));
			$this->output->set_header("Location: " . base_url() . 'Expenses/manage_Expenses', TRUE, 302);
		}
	}
	
	public function restore($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(157,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		
		$responce=$this->Expenses_model->restore($id);
        if($responce){
			$this->session->set_userdata(array('success_message' => "Expense is restored successfully, please check in manage expense."));
			$this->output->set_header("Location: " . base_url() . 'Expenses/manage_trash', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Expense not Restore.Something went wrong"));
			$this->output->set_header("Location: " . base_url() . 'Expenses/manage_trash', TRUE, 302);
		}
	}
	
	public function deletepermanent($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		
	    $role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(158,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		
		$responce = $this->Expenses_model->permanentdelete($id);
		$responce = $this->Expenses_model->permanentdeletedetail($id);
		
        if($responce){
            /****************** Activity Log *****************************/
			$user_role=$this->session->userdata('user_role');
			$user_role_name=$this->session->userdata('user_role_name');
			$user_id=$this->session->userdata('user_id');
			$expense_voucher='EI-'.sprintf('%03d', $id);
			$client_ip=$this->Gen->get_client_ip();
			$address=$this->Base_model->getLocation($client_ip);
            $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
            $date=date('Y-m-d H:i:s');
			$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'DELETED',fld_detail='$expense_voucher',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Expense is permanently deleted."));
			$this->output->set_header("Location: " . base_url() . 'Expenses/manage_trash', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Expense not delete.Something went wrong"));
			$this->output->set_header("Location: " . base_url() . 'Expenses/manage_trash', TRUE, 302);
		}
	}
	
	function add_item()
	{
	    $this->form_validation->set_rules('new_item', 'Item Name', 'required');
	    $this->form_validation->set_rules('fld_unit', 'Unit', 'required');
		if ($this->form_validation->run() == FALSE) {
            echo "required_item_name";
		}else{
		    $new_item	=	$this->input->post('new_item');
		    $fld_unit	=	$this->input->post('fld_unit');
		    $count_item = $this->db->query("select * from tbl_stationary where name = '$new_item'")->num_rows();
	    if($count_item > 0){
	        echo "item_already_found";
	        exit();
	    }
		
		$data_ins['name']   = 	$new_item;
		$data_ins['fld_unit']   = 	$fld_unit;
		$data_ins['status']		= 	1;
		$last_item_id			=	$this->Common_model->insert_array('tbl_stationary',$data_ins);
		//$data['items']	 	=	$this->Common_model->select_where_ASC_DESC('id,name,fld_unit','tbl_stationary',array('status'=>1),'name','ASC');
		$data['items']   =    $this->Expenses_model->getAllStationary('tbl_stationary');
		$data['last_item_id']	 	=	$last_item_id;
		$data['row_id']	 	=	$this->input->post('row_id');
		$this->load->view('expenses/add_item',$data); 
	}
	}
		
	
// 	draft section

public function manage_drafts()
    {
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(210,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$this->title = "View Expenses Drafts";
		$data['view_scripts']=array(
    		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
    		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
    		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		    $this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		    $this->Gen->get_script_url('plugin_components','timepicker/bootstrap-material-datetimepicker.js'),
		    $this->Gen->get_script_url('custom_js','expenses.js'),
		    //$this->Gen->get_script_url('custom_js','hrm.js'),
		);
		$data['view_css']=array(
		    $this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'),
		    $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		    $this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
		    $this->Gen->get_script_url('plugin_components','timepicker/bootstrap-material-datetimepicker.css'),
		);
		$user_id=$this->session->userdata('user_id');
		if(isset($_GET['date']) && $_GET['plants'] && $_GET['name']){
		    $data['expenses'] = $this->db->query("SELECT * FROM tbl_expenses_draft WHERE fld_userid='$user_id' && fld_isdeleted = 0 And date_added = '{$_GET['date']}' && plant_for = '{$_GET['plants']}' && expense_item = '{$_GET['name']}'")->result_array();
		}else if(isset($_GET['date']) && $_GET['plants']){
		    $data['expenses'] = $this->db->query("SELECT * FROM tbl_expenses_draft WHERE fld_userid='$user_id' && fld_isdeleted = 0 And date_added = '{$_GET['date']}' && plant_for = '{$_GET['plants']}'")->result_array();
		}else{
		  //  $data['expenses']= $this->Base_model->getAll('tbl_expenses_draft', '', array('fld_isdeleted'=>0), '');
		   $data['expenses'] = $this->db->query("SELECT * FROM tbl_expenses_draft WHERE fld_userid='$user_id' && fld_isdeleted = 0")->result_array();
		}
		//$data['expenses']=$this->Base_model->getAll('tbl_expenses_draft');
        $this->load_template('','expenses/manage_draft',$data);
    }
    
    
    public function addExpensedrafts(){

	$this->form_validation->set_rules('plant_for', 'Plant For', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Expenses', TRUE, 302);
		} 
		else{
		    //$date	            =		date('Y-m-d', strtotime($this->input->post('date_added')));
		     $date	            =       date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('date_added',TRUE))));
		     //$expense_item		=		$this->input->post('expense_item');
		 	 $plantID		    =		$this->input->post('plant_for');
		//	 $queryGet = '?date='.$date.'&plants='.$plantID;
			
			/*if(!empty($plantID)){
			   $qrry = $this->db->query("SELECT date_added, plant_for FROM tbl_expenses WHERE date_added = '".$date."' AND plant_for = '".$plantID."'");
			}
			 $count = $qrry->num_rows();
			if($count > 0) {
			   $this->session->set_userdata(array('error_message' => "Expense Item Already Exists on this date."));
			   $this->output->set_header("Location: " . base_url() . 'Expenses', TRUE, 302);
			}else{*/

			$data = array(
                'date_added' => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('date_added',TRUE)))),
                'expense_voucher'=> $this->input->post('expense_voucher',TRUE),
                'plant_for'=> $this->input->post('plant_for',TRUE),
                'plant_from'=> $this->input->post('plant_from',TRUE),
                //'payment_type' => $this->input->post('payment_type',TRUE),
                'fld_grand_total_amount' => $this->input->post('fld_grand_total_amount',TRUE),
                //'detail' => $this->input->post('detail',TRUE),
                'fld_userid'=>$this->session->userdata('user_id'),
                'status' => 1,
        );
        
        $expenses = $this->db->insert('tbl_expenses_draft',$data);
        $id = $this->db->insert_id();
        
        if($expenses){
		     
		  $totalquantity=0;
		  $insert_id = $id;
		  $e_id = $this->input->post('fld_expense_id',TRUE);
		  $quantity = $this->input->post('quantity',TRUE);
		  $unit = $this->input->post('unit',TRUE);
		 // $payment_type = $this->input->post('payment_type',TRUE);
		  $remarks = $this->input->post('remarks',TRUE);
		  $unit_price = $this->input->post('unit_price',TRUE);
		  //$sub_total = $this->input->post('sub_total',TRUE);
		  for ($i = 0, $n = count($e_id); $i < $n; $i++) {
// 			$totalquantity=$totalquantity + $quantity[$i];
			$expense_id = $e_id[$i];
            $exp_quantity = $quantity[$i];
            $unitid = $unit[$i];
            //$paytype = $payment_type[$i];
            $detail = $remarks[$i];
            $un_price = $unit_price[$i];
           // $total = $sub_total[$i];
            // $disc = $discount[$i];
            $disc=0;

            $data1 = array(
                'fld_expense_id'    => $insert_id,
                'stationary'        => $expense_id,
                'quantity'          => $exp_quantity,
                'unit'              => $unitid,
                //'payment_type'      => $paytype,
                'remarks'           => $detail,
                'unit_price'        => $un_price,
                //'sub_total'         => $total
            );

                $this->db->insert('tbl_expense_draft_detail', $data1);
        }
        }
        
        
        $q = $this->db->get_where('tbl_expenses_draft', array('id' => $id));
        $qq = $q->row();
        $plantid = '?plants='.$qq->plant_for;
        //$data['plantid'] = $qq->plants;
        $res=array('responce'=>'success',"message"=>"Purchase added in draft successfully.");
        echo json_encode($res);
		}

	}
	public function editdraft($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(159,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
        $this->title = "Edit Expense Draft";
        $data['units']=$this->Base_model->getAll('tbl_units');
		$data['expense']=$this->Base_model->getRow('tbl_expenses_draft','','id ='.$id.'');
        $data['stationary']=$this->Expenses_model->getAllStationary('tbl_stationary');
		 $data['expense_group']=$this->Base_model->getAll('tbl_expense_group');
		$data['view_scripts']=array(
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
		// echo '<pre>';
		// print_r($data['category']);
		// exit;
        $this->load_template('','expenses/editdraft',$data);
	}
	
	public function editdraftProcess(){

		$this->form_validation->set_rules('expense_voucher', 'Expense voucher', 'required');
		$id = $this->input->post('id');
		//echo $id;exit;
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Expenses/editdraft/'.$id.'', TRUE, 302);
		} else {
			$data = array(
                'date_added' => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('date_added',TRUE)))),
                'expense_voucher'=> $this->input->post('expense_voucher',TRUE),
                'plant_for'=> $this->input->post('plant_for',TRUE),
                'plant_from'=> $this->input->post('plant_from',TRUE),
                //'payment_type' => $this->input->post('payment_type',TRUE),
                'fld_grand_total_amount' => $this->input->post('fld_grand_total_amount',TRUE),
                //'detail' => $this->input->post('detail',TRUE),
                'status' => 1,
			);
			
			$this->db->where('id',$id);
			$expense = $this->db->update('tbl_expenses_draft',$data);
			
		if($expense){
		    
		    $this->db->where('fld_expense_id', $id);
			$this->db->delete('tbl_expense_draft_detail');
		     
		  $totalquantity=0;
		  $insert_id = $id;
		  $e_id = $this->input->post('fld_expense_id',TRUE);
		  $exp_type = $this->input->post('expense_type',TRUE);
		  $exp_value = $this->input->post('expense_value',TRUE);
		  $quantity = $this->input->post('quantity',TRUE);
		  $unit = $this->input->post('unit',TRUE);
		  //$payment_type = $this->input->post('payment_type',TRUE);
		  $remarks = $this->input->post('remarks',TRUE);
		  $unit_price = $this->input->post('unit_price',TRUE);
		  //$sub_total = $this->input->post('sub_total',TRUE);
		  for ($i = 0, $n = count($e_id); $i < $n; $i++) {
			$totalquantity=$totalquantity + $quantity[$i];
			$exptype = $exp_type[$i];
			$expvalue = $exp_value[$i];
			$expense_id = $e_id[$i];
            $exp_quantity = $quantity[$i];
            $unitid = $unit[$i];
            //$paytype = $payment_type[$i];
            $detail = $remarks[$i];
            $un_price = $unit_price[$i];
           // $total = $sub_total[$i];
            // $disc = $discount[$i];
            $disc=0;

            $data1 = array(
                'fld_expense_id'    => $insert_id,
                'expense_type'    => $exptype,
                'expense_value'    => $expvalue,
                'stationary'        => $expense_id,
                'quantity'          => $exp_quantity,
                'unit'              => $unitid,
                //'payment_type'      => $paytype,
                'remarks'           => $detail,
                'unit_price'        => $un_price,
                //'sub_total'         => $total
            );

                $this->db->insert('tbl_expense_draft_detail', $data1);
        }
            $res=array('responce'=>'success',"message"=>"Expense added in draft successfully.");
        }else{
		   $res=array('responce'=>'error',"message"=>"Expense not added in draft successfully.");
		}
		echo json_encode($res);
			
 		}
	}
	
	
	
	
	public function updateExpenseDraft($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
        $this->title = "Edit Expense | ".$this->title;
        $data['units']=$this->Base_model->getAll('tbl_units');
		$data['expense']=$this->Base_model->getRow('tbl_expenses','','id ='.$id.'');

		$data['view_scripts']=array(
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
		// echo '<pre>';
		// print_r($data['category']);
		// exit;
        $this->load_template('','expenses/updateExpenseDraft',$data);
	}
	
	public function deletedraft($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		
	    $role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(160,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		
		$responce = $this->Expenses_model->deleteDraft($id);
		$responce = $this->Expenses_model->deleteDraftdetail($id);
		
        if($responce){
			$this->session->set_userdata(array('success_message' => "Expense Draft delete successfully"));
			$this->output->set_header("Location: " . base_url() . 'Expenses/manage_drafts', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Expense Draft not delete.Something went wrong"));
			$this->output->set_header("Location: " . base_url() . 'Expenses/manage_drafts', TRUE, 302);
		}
	}
	
	// report 
	
	public function filter(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$data['expense'] = $expense=$this->Expenses_model->expense_filter();
		$data['filter_type']=$this->input->post('filter_type');
		$count=count($expense);

		$html=$this->load->view('expenses/expense_filter',$data,true);
		echo json_encode(array("html"=>$html,'count'=>$count));
	}
	public function filter_csv(){
	    $_POST=$_GET;
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$data['expense'] = $expense=$this->Expenses_model->expense_filter();
		$data['filter_type']=$this->input->post('filter_type');
		$count=count($expense);
        include_once APPPATH.'/third_party/autoload.php';
        $header_row = array("#", "Expense Date", "Invoice ID", "Type" , "Item - Qty", "Remarks", "Paid From","Amount(PKR)");
        $csvName = 'expencereport'.'.csv';
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="'.$csvName.'";');
        $output = fopen('php://output', 'w');
        
        fputcsv($output,$header_row);
        $i=1;
        foreach($expense as $expens){
            foreach($expens['detail'] as $expensdet){
            $plantfrom =	$this->Common_model->select_single_field('head_name','tbl_coa',array('head_code'=>$expensdet['plant_from']));
            if($expensdet['expense_type'] == 1){
				$exptype = "Office Expense";
			}else{
				$exptype = "Mess Expense";
			}
            $dataValus=array($i,date('d-m-Y',strtotime($expensdet['date_added'])), $expensdet['expense_voucher'],$exptype,$expensdet['st_name'].' '.'('.$expensdet['quantity'].')',$expensdet['remarks'],$plantfrom,$expensdet['unit_price']);
            fputcsv($output,$dataValus);
            $i++;
            }
        }
            
        fclose($output);
	
	}
	
	
	public function addExpenseshistoryfilter(){

			$date	            =		date('Y-m-d', strtotime($this->input->post('date')));
			$plantID		    =		$this->input->post('plant_for');
			$itemname		    =		$this->input->post('expense_item');
		  //echo var_dump($category);exit;
			
			$queryGet = '?date='.$date.'&plants='.$plantID.'&name='.$itemname;
			$this->output->set_header("Location: " . base_url() . 'Expenses/manage_Expenses'.$queryGet, TRUE, 302);
	}
	
	public function expenseReport(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(81,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$this->title = "Expense Report";
			$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
		$this->Gen->get_script_url('custom_js','expenses.js'),
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
		
		$this->load_template('','expenses/expense_report',$data);
	}
	
	public function print_single_expense($id){
	   // $data['purchase'] = $this->Purchase_model->getPurchaseByID($id);
	   $data['expense']=$this->Base_model->getRow('tbl_expenses','','id ='.$id.'');
	    $this->load->view('reports/print_single_expense', $data);
	}
	public function pdf_single_expense($id){
	    include_once APPPATH.'/third_party/autoload.php';
	    $mpdf = new \Mpdf\Mpdf();
	   // $data['purchase']=$this->Purchase_model->getPurchaseByID($id);
	   $data['expense']=$this->Base_model->getRow('tbl_expenses','','id ='.$id.'');
	    $html = $this->load->view('reports/pdf_single_expense',$data,true);
// 		echo '<pre>';
// 		print_r($html);
// 		exit;
	    $mpdf->WriteHTML($html);
		$mpdf->Output('expense Report.pdf','D');
	}
	
	public function print_report(){
		$this->load->view('expenses/print_expenses_report');
	  //$this->load_template('','expenses/print_expanses_report');
	}
	
	public function print_expense_report(){
		include_once APPPATH.'/third_party/autoload.php';
		$mpdf = new \Mpdf\Mpdf();
		$data['expense']=$expense=$this->Expenses_model->expense_filter_pdf($_GET);
		$data['filter_type'] = $_GET['type'];
		$data['get'] = $_GET;
		$html = $this->load->view('expenses/pdf_expenses_report',$data,true);
// 		echo '<pre>';
// 		print_r($html);
// 		exit;
		$mpdf->WriteHTML($html);
		$mpdf->Output('Expense Report.pdf','D');
	  //$mpdf->Output();
	}
	
	public function getBalanceInner($id, $plus_amount = 0){
        
        $debit = $this->db->query("SELECT IFNULL(SUM(td.debit), 0) as debit FROM tbl_transections_details as td, tbl_transections_master as tm WHERE coa_id = '$id' && tm.id = td.v_id && tm.post_status = 0")->row()->debit;
        $credit = $this->db->query("SELECT IFNULL(SUM(td.credit), 0) as credit FROM tbl_transections_details as td, tbl_transections_master as tm WHERE coa_id = '$id' && tm.id = td.v_id && tm.post_status = 0")->row()->credit;
        $balance = number_format(($debit-$credit+$plus_amount), 2, '.', '');
        return $balance;
        
    }
    public function cleardrafts(){
	    $user_id=$this->session->userdata('user_id');
	    $data=$this->db->query("Select * from tbl_expenses_draft where fld_userid ='$user_id'")->result_array();
	    foreach($data as $row){
	        $this->db->query("delete from tbl_expense_draft_detail where fld_expense_id ='{$row['id']}'");
	    }
	    $this->db->query("delete from tbl_expenses_draft where fld_userid ='$user_id'");
	    $this->session->set_userdata('success_message', "Drafts cleared successfully.");
	     redirect(base_url('Expenses/manage_drafts'));
	}
	
}
