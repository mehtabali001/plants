<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payroll extends My_controller {
	
	function __construct() {
        parent::__construct();
		$this->load->model('Employees_model');
		$this->load->model('Common_model');
    }
	
	public function index()
    {
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(45,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
        $this->title = "New Payroll";
		
	  //$maxEmployeeID=$this->Employees_model->getMaxemployeeID();
	  //$data['maxid']='KG-emp-'.sprintf('%03d', $maxEmployeeID['Auto_increment']);
		
		$data['view_scripts']=array(
		    $this->Gen->get_script_url('plugin_components','moment/moment.js'),
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
		$this->Gen->get_script_url('','https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js'),
		
// 		$this->Gen->get_script_url('plugin_components','timepicker/bootstrap-material-datetimepicker.js'),
        
// 		$this->Gen->get_script_url('','https://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js'),
// 		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap3-editable/js/bootstrap-editable.js'),
		$this->Gen->get_script_url('custom_js','hrm.js'),
		
		);
		$data['view_css']=array(
		$this->Gen->get_script_url('theme_css','bootstrap3.css'),
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap3-editable/css/bootstrap-editable.css'),
	  //$this->Gen->get_script_url('plugin_components','x-editable/css/bootstrap-editable.css'),
// 		$this->Gen->get_script_url('plugin_components','timepicker/bootstrap-material-datetimepicker.css'),
		//$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'),
		);
		$data['payroll']= $this->Base_model->getAll('tbl_payroll');
        $this->load_template('','add_payroll',$data);
    }
    
    public function addsalarysetup()
    {
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
// 		$role_permissions  = explode(",",$this->session->userdata('permissions'));
// 		if(!empty($role_permissions) && !in_array(45,$role_permissions)) {
// 			$this->session->set_userdata(array('error_message' => "Access Denied!"));
// 			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
// 		}
        $this->title = "New Salary Setup";
		
		$data['view_scripts']=array(
		  	$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'),
		  	$this->Gen->get_script_url('','https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js'),
		  	$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
		  	$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		  	$this->Gen->get_script_url('custom_js','hrm.js'),
		);
		$data['view_css']=array(
		   $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
        $this->load_template('','addsalarysetup',$data);
    }
    
    public function editsalarysetup($id)
    {
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(182,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
        $this->title = "Update Salary Setup";
		
		$data['view_scripts']=array(
		  	$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'),
		  	$this->Gen->get_script_url('','https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js'),
		  	$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
		  	$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		  	$this->Gen->get_script_url('custom_js','hrm.js'),
		);
		$data['view_css']=array(
		   $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
		$data['editsalary']=$this->Base_model->getRow('tbl_employees','','id ='.$id.'');
        $this->load_template('','editsalarysetup',$data);
    }
    
    public function updatesalarysetup(){

			$this->form_validation->set_rules('employee_code', 'Employee code', 'required');
		    $this->form_validation->set_message('designation', 'Designation', 'required');
		    $this->form_validation->set_message('plants', 'Plant Name', 'required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_userdata(array('error_message' => validation_errors()));
				$this->output->set_header("Location: " . base_url() . 'Payroll/addsalarysetup', TRUE, 302);
			} else {
			    //$date = date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('attendance_date'))));  new date formate
			$data = array(
			        'bank_name'         =>  $this->input->post('bank_name',TRUE),
			        'account_no'        =>  $this->input->post('account_no',TRUE),
    			    'basic_pay'         =>  $this->input->post('basic_pay',TRUE),
    			    'med_allow'         =>  $this->input->post('med_allow',TRUE),
    			    'other'             =>  $this->input->post('other',TRUE),
    			    'gross_pay'         =>  $this->input->post('gross_pay',TRUE),
    			    'eobi'              =>  $this->input->post('eobi',TRUE),
    			    'social_security'   =>  $this->input->post('social_security',TRUE),
                    'salary_tax'        =>  $this->input->post('salary_tax',TRUE),
    			    't_deductions'      =>  $this->input->post('t_deductions',TRUE),
    			    'net_payment'       =>  $this->input->post('net_payment',TRUE),
    			    'fld_updated_by'       =>  $this->session->userdata('user_id'),
    			    'update_salarysetup_date'   =>  date("Y-m-d H:i:s")
			);

			$emp_code = $this->input->post('employee_code',TRUE);
			$this->db->where('employee_code',$emp_code);
			//$this->db->set('update_salarysetup_date', 'NOW()', FALSE);
			$employees=$this->db->update('tbl_employees',$data);
			
			if($employees){
				$this->session->set_userdata(array('success_message' => "Employee Salary Setup added successfully"));
				$this->output->set_header("Location: " . base_url() . 'Payroll/manage_salarysetup', TRUE, 302);
			}else if($employees && $_POST['update-salarysetup']){
                $this->session->set_userdata(array('success_message' => "Employee Salary Setup updated successfully"));
				$this->output->set_header("Location: " . base_url() . 'Payroll/manage_salarysetup', TRUE, 302);
			}else{
				$this->session->set_userdata(array('error_message' => "Employee Salary Setup not added. Something went wrong"));
				$this->output->set_header("Location: " . base_url() . 'Payroll/addsalarysetup', TRUE, 302);
			}
				
			}
		
	}
    
    public function generatesalaries()
    {
        
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(44,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
        $this->title = "Generate Salary";
		
		$data['view_scripts']=array(
    		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
    		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
    		
    		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
    		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
    		$this->Gen->get_script_url('plugin_components','timepicker/bootstrap-material-datetimepicker.js'),
            $this->Gen->get_script_url('custom_js','hrm.js'),
    // 		$this->Gen->get_script_url('','https://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js'),
    // 		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap3-editable/js/bootstrap-editable.js'),
    		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
		);
		$data['view_css']=array(
    		$this->Gen->get_script_url('theme_css','bootstrap3.css'),
    		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap3-editable/css/bootstrap-editable.css'),
    	  //$this->Gen->get_script_url('plugin_components','x-editable/css/bootstrap-editable.css'),
    		$this->Gen->get_script_url('plugin_components','timepicker/bootstrap-material-datetimepicker.css'),
    		$this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
    		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'),
		);
		
// 		$data['payroll']= $this->Base_model->getAll('tbl_payroll');

		if(isset($_GET['month'])){
		    $data['payroll'] = $this->db->query("SELECT * FROM tbl_payroll WHERE month = '{$_GET['month']}' && year = '{$_GET['year']}'")->result_array();
		}else{
		    $data['payroll'] = $this->db->query("SELECT * FROM tbl_payroll LIMIT 0,0")->result_array();
		}
		
		$data['from_accounts'] = $this->db->select('*')->from('tbl_coa')->where('head_code!=', '101001')->like('head_code', '101001', 'both')->get()->result_array();
		$data['to_accounts'] = $this->db->select('*')->from('tbl_coa')->where('head_level', '3')->not_like('head_code', '101001', 'both')->get()->result_array();

		
        $this->load_template('','salary_generate', $data);
    }
    
    public function payablesalaries()
    {
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
// 		$role_permissions  = explode(",",$this->session->userdata('permissions'));
// 		if(!empty($role_permissions) && !in_array(44,$role_permissions)) {
// 			$this->session->set_userdata(array('error_message' => "Access Denied!"));
// 			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
// 		}
        $this->title = "Payable Salaries";
		
		
		$data['view_scripts']=array(
		    $this->Gen->get_script_url('plugin_components','moment/moment.js'),
    		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
    // 		$this->Gen->get_script_url('plugin_components','timepicker/bootstrap-material-datetimepicker.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
    		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
    		
    		
            $this->Gen->get_script_url('custom_js','hrm.js'),
    // 		$this->Gen->get_script_url('','https://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js'),
    // 		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap3-editable/js/bootstrap-editable.js'),
    		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
		);
		$data['view_css']=array(
    		$this->Gen->get_script_url('theme_css','bootstrap3.css'),
    		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap3-editable/css/bootstrap-editable.css'),
    		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
    	  //$this->Gen->get_script_url('plugin_components','x-editable/css/bootstrap-editable.css'),
    		//$this->Gen->get_script_url('plugin_components','timepicker/bootstrap-material-datetimepicker.css'),
    		$this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
    		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'),
		);
		
   //	$data['payroll']= $this->Base_model->getAll('tbl_payroll');
        
         $whereData = array();
	   if(!empty($_GET['month'])){
	       $whereData['month'] = $_GET['month'];
	   }
	   if(!empty($_GET['year'])){
	       $whereData['year'] = $_GET['year'];
	   }
	   if(!empty($_GET['name'])){
	       $whereData['user_id'] = $_GET['name'];
	   }
	   if(!empty($_GET['designation'])){
	       $whereData['designation'] = $_GET['designation'];
	   }
	   $whereData['salary_status'] = 0;
	   
	   
	   
	   //$data = array();
	   $data['payroll'] = $this->Base_model->getAll('tbl_payroll', '*', $whereData);
       
		/*if(!empty($_GET['month'])){
		    $data['payroll'] = $this->db->query("SELECT * FROM tbl_payroll WHERE month = '{$_GET['month']}' && salary_status = 0")->result_array();
		}elseif(!empty($_GET['name'])){
            $data['payroll'] = $this->db->query("SELECT * FROM tbl_payroll WHERE user_id = '{$_GET['name']}' && salary_status = 0")->result_array();
        }elseif(!empty($_GET['designation'])){
            $data['payroll'] = $this->db->query("SELECT * FROM tbl_payroll WHERE designation = '{$_GET['designation']}' && salary_status = 0")->result_array();
        }else{
		    $data['payroll'] = $this->db->query("SELECT * FROM tbl_payroll WHERE salary_status = 0")->result_array();
		}
		
		if($month != ''){
            $data['payroll'] = $this->db->query("SELECT * FROM tbl_payroll WHERE month = '{$month}' && salary_status = 0")->result_array(); 
        }elseif($fld_emp_name != ''){
            $data['payroll'] = $this->db->query("SELECT * FROM tbl_payroll WHERE user_id = '{$fld_emp_name}' && salary_status = 0")->result_array();
        }elseif($designation != ''){
            $data['payroll'] = $this->db->query("SELECT * FROM tbl_payroll WHERE designation = '{$designation}' && salary_status = 0")->result_array();
        }*/
		
		
// 		$data['from_accounts'] = $this->db->query("SELECT * FROM tbl_coa WHERE head_code!='101001' AND head_code!='101004' AND (head_code LIKE '101001%' || head_code LIKE '101004%')")->result_array();

		$data['cash_accounts'] = $this->db->select('*')->from('tbl_coa')->where('head_code!=', '101001')->like('head_code', '101001', 'both')->get()->result_array();
        $data['bank_accounts'] = $this->db->select('*')->from('tbl_coa')->where('head_code!=', '101014')->like('head_code', '101014', 'both')->get()->result_array();
		$data['to_accounts'] = $this->db->select('*')->from('tbl_coa')->where('head_level', '3')->not_like('head_code', '101001', 'both')->get()->result_array();
		
        $this->load_template('','payable_salaries', $data);
    }
    
    public function payablesalaryfilter(){
        
            
		
		    $user_id=$this->session->userdata('user_id');
    		$month = $this->input->post('month',TRUE);
            $year = $this->input->post('year',TRUE);
            $fld_emp_name = $this->input->post('fld_emp_name',TRUE);
            $designation = $this->input->post('designation',TRUE);
            
            $queryGet = '?name='.$fld_emp_name.'&designation='.$designation.'&month='.$month.'&year='.$year;
	        
	        $this->output->set_header("Location: " . base_url() . 'Payroll/payablesalaries'.$queryGet, TRUE, 302);
	        
		    /*if($employees){
				$this->session->set_userdata(array('success_message' => "Salary Generate successfully"));
				$this->output->set_header("Location: " . base_url() . 'Payroll/generatesalaries'.$queryGet, TRUE, 302);
			}else{
				$this->session->set_userdata(array('error_message' => "Payroll not added. Something went wrong"));
				$this->output->set_header("Location: " . base_url() . 'Payroll/generatesalaries'.$queryGet, TRUE, 302);
			}*/
		  
		
	}
    
    public function paidsalaries()
    {
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
// 		$role_permissions  = explode(",",$this->session->userdata('permissions'));
// 		if(!empty($role_permissions) && !in_array(44,$role_permissions)) {
// 			$this->session->set_userdata(array('error_message' => "Access Denied!"));
// 			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
// 		}
        $this->title = "Paid Salaries";
		
		
		$data['view_scripts']=array(
    		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
    		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
    		
    		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
    		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
    		$this->Gen->get_script_url('plugin_components','timepicker/bootstrap-material-datetimepicker.js'),
            $this->Gen->get_script_url('custom_js','hrm.js'),
    		$this->Gen->get_script_url('','https://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js'),
    		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap3-editable/js/bootstrap-editable.js'),
    		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
		);
		$data['view_css']=array(
    		$this->Gen->get_script_url('theme_css','bootstrap3.css'),
    		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap3-editable/css/bootstrap-editable.css'),
    	  //$this->Gen->get_script_url('plugin_components','x-editable/css/bootstrap-editable.css'),
    		$this->Gen->get_script_url('plugin_components','timepicker/bootstrap-material-datetimepicker.css'),
    		$this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
    		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'),
		);
		
// 		$data['payroll']= $this->Base_model->getAll('tbl_payroll');

		if(isset($_GET['month'])){
		    $data['payroll'] = $this->db->query("SELECT * FROM tbl_payroll WHERE month = '{$_GET['month']}' && year = '{$_GET['year']}' &&  WHERE salary_status = 1")->result_array();
		}else{
		    $data['payroll'] = $this->db->query("SELECT * FROM tbl_payroll WHERE salary_status = 1")->result_array();
		}
		
		$data['from_accounts'] = $this->db->select('*')->from('tbl_coa')->where('head_code!=', '101001')->like('head_code', '101001', 'both')->get()->result_array();
		$data['to_accounts'] = $this->db->select('*')->from('tbl_coa')->where('head_level', '3')->not_like('head_code', '101001', 'both')->get()->result_array();
		
        $this->load_template('','paid_salaries', $data);
    }
    
    public function viewpaidsalary($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(156,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
        $this->title = "Salary Details";
		$data['salary']=$this->Base_model->getRow('tbl_payroll','',array('id'=>$id,'salary_status'=>1));
		//$data['salary'] = $this->db->query("SELECT * FROM tbl_payroll WHERE id='.$id.' && salary_status = 1 ")->result_row();
		$data['previous']=$this->Base_model->getRow('tbl_payroll','id','id = (select max(id) from tbl_payroll where id < '.$id.' && salary_status = 1)');
		$data['next']=$this->Base_model->getRow('tbl_payroll','id','id = (select min(id) from tbl_payroll where id > '.$id.' && salary_status = 1)');
		$data['view_css']=array(
		   $this->Gen->get_script_url('theme_css','style.css'),
		);
        $this->load_template('','viewSalary',$data);
	}

	
	public function createPayroll(){
		$this->form_validation->set_rules('month', 'Month', 'required');
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Payroll', TRUE, 302);
		} else {
			$month	            =		$this->input->post('month');
			$selectplants		=		$this->input->post('selectplants');
			$plantID		    =		$this->input->post('plants');
			$selectdesignation	=		$this->input->post('selectdesignation');
			$designationID		=		$this->input->post('designation');
			$salary_status		=		$this->input->post('salary_status');
			
			/*echo "Month is: ".$month;
			echo "<br>";
			echo "Plant is: ".$selectplants;
			echo "<br>";
			echo "Plant ID is: ".$plantID;
			echo "<br>";
			echo "Desig is: ".$selectdesignation;
			echo "<br>";
			echo "Desig ID is: ".$designationID;
			echo "<br>";*/
			
			if($month && $selectplants == 'all' && $selectdesignation  == 'all'){
			   $qrry = $this->db->query("SELECT month FROM tbl_payroll WHERE month = '".$month."'");
			}elseif($month && $selectplants == 'plantwise' && $selectdesignation  == 'designationwise'){
               $qrry = $this->db->query("SELECT month FROM tbl_payroll WHERE month = '".$month."' AND plants = '".$plantID."' AND designation = '".$designationID."'");			 
			}elseif($month && $selectplants == 'all' && $selectdesignation  == 'designationwise'){
               $qrry = $this->db->query("SELECT month FROM tbl_payroll WHERE month = '".$month."' AND designation = '".$designationID."'");			 
			}elseif($month && $selectplants == 'plantwise' && $selectdesignation  == 'all'){
               $qrry = $this->db->query("SELECT month FROM tbl_payroll WHERE month = '".$month."' AND plants = '".$plantID."'");			 
			}
			 
			$count = $qrry->num_rows();
			//exit;
			if($count > 0) {
			   $this->session->set_userdata(array('error_message' => "Payroll Data Already Exists on this month."));
			   $this->output->set_header("Location: " . base_url() . 'Payroll', TRUE, 302);
			}else{
			
			if($month && $selectplants == 'all' && $selectdesignation  == 'all'){			  
			  $data['employees'] = $this->Common_model->getAllrows('tbl_employees','',"plants NOT IN (SELECT plants FROM tbl_payroll WHERE month = '".$month."') AND designation NOT IN (SELECT designation FROM tbl_payroll WHERE month = '".$month."')",'');
			}elseif($month && $selectplants == 'plantwise' && $selectdesignation  == 'designationwise'){
              $data['employees'] = $this->Common_model->getAllrows('tbl_employees','',array('plants'=>$plantID,'designation'=>$designationID),'');			  
			}elseif($month && $selectplants == 'all' && $selectdesignation  == 'designationwise'){
              $data['employees'] = $this->Common_model->getAllrows('tbl_employees','',array('designation'=>$designationID),'');			  
			}elseif($month && $selectplants == 'plantwise' && $selectdesignation  == 'all'){
              $data['employees'] = $this->Common_model->getAllrows('tbl_employees','',array('plants'=>$plantID),'');			  
			}
			
			/*elseif($month && $selectplants == 'plantwise' && $selectdesignation  == 'all'){
              $qrry1 = $this->Common_model->getAllrows('tbl_employees','',array('plants'=>$plantID),'');			  
			}elseif($month && $selectplants == 'plantwise' && $selectdesignation  == 'designationwise'){
              $qrry1 = $this->Common_model->getAllrows('tbl_employees','',array('plants'=>$plantID,'designation'=>$designationID),'');			  
			}*/
			//$count = $qrry1->num_rows();
			  
			  $employees = $data['employees'];
			  //echo "Total is: ". count($employees);exit;
			 
			  $data = array();
			  foreach ($employees as $row) {
			        $data[] = array(
						'user_id'           =>      $row['id'],
						'designation'       =>      $row['designation'],
						'plants'            =>      $row['plants'],
						'month'             =>      $month,
						'bonus'             =>      '',
						'basic_salary'      =>      $row['net_payment'],
						'deduction'         =>      $row['t_deductions'],
						'created_datetime'  =>      date('Y-m-d H:i:s'),
						'created_by'        =>      $this->session->userdata('user_id'),
						'salary_status'     =>      $salary_status,
					);
			}

			$employees = $this->db->insert_batch('tbl_payroll', $data);	
	
			if($employees){
				$this->session->set_userdata(array('success_message' => "Payroll added successfully"));
				$this->output->set_header("Location: " . base_url() . 'Payroll', TRUE, 302);
			}else{
				$this->session->set_userdata(array('error_message' => "Payroll not added. Something went wrong"));
				$this->output->set_header("Location: " . base_url() . 'Payroll', TRUE, 302);
			}
		  }
		}
	}
	
	
	public function createSalary(){
		$this->form_validation->set_rules('month', 'Month', 'required');
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Payroll', TRUE, 302);
		} else {
		    $user_id=$this->session->userdata('user_id');
			$month	            =		$this->input->post('month');
			$monthNumber = date('m', strtotime($month));
		
			$year	            =		$this->input->post('year');
			
			$monthyear = $year.'-'.$monthNumber.'-01';
			//$selectplants		=		$this->input->post('selectplants');
			//$plantID		    =		$this->input->post('plants');
			//$salary_status		=		$this->input->post('salary_status');
			//$queryGet = '?month='.$month.'&year='.$year.'&selectplants='.$selectplants.'&plants='.$plantID.'&salary_status='.$salary_status;
			$queryGet = '?month='.$month.'&year='.$year;
			/*echo "Month is: ".$month;
			echo "<br>";
			echo "Plant is: ".$selectplants;
			echo "<br>";
			echo "Plant ID is: ".$plantID;
			echo "<br>";
			echo "Desig is: ".$selectdesignation;
			echo "<br>";
			echo "Desig ID is: ".$designationID;
			echo "<br>";*/
			
			/*if($month && $selectplants == 'all'){
			   $qrry = $this->db->query("SELECT month FROM tbl_payroll WHERE month = '".$month."' AND year = '$year'");
			}elseif($month && $selectplants == 'plantwise'){
               $qrry = $this->db->query("SELECT month FROM tbl_payroll WHERE month = '".$month."' AND year = '$year' AND plants = '".$plantID."'");			 
			}*/
			
			$qrry = $this->db->query("SELECT month FROM tbl_payroll WHERE month = '".$month."' AND year = '$year'");
			
			$count = $qrry->num_rows();
		
			if($count > 0) {
			   $this->session->set_userdata(array('error_message' => "Salaries Data Already Exists on this month."));
			   redirect('Payroll/generatesalaries'.$queryGet);
			   exit;
			}else{
			
			/*if($month && $selectplants == 'all'){			  
			  $data['employees'] = $this->Common_model->getAllrows('tbl_employees','',"plants NOT IN (SELECT plants FROM tbl_payroll WHERE month = '".$month."' AND year = '$year')",'');
			}elseif($month && $selectplants == 'plantwise'){
              $data['employees'] = $this->Common_model->getAllrows('tbl_employees','',array('plants'=>$plantID),'');			  
			}*/
			
			$this->db->query("UPDATE tbl_payroll SET salary_status = '1' where monthyear < '$monthyear'");
			
			$data['employees'] = $this->Common_model->getAllrows('tbl_employees','',"plants NOT IN (SELECT plants FROM tbl_payroll WHERE month = '".$month."' AND year = '$year') AND is_active = 1 and deleted = 0",'');
			  
			$employees = $data['employees'];
			//echo "Total is: ". count($employees);exit;
			 
			  $data = array();
			  if($employees){
			      $now = date('Y-m-t H:i:s', strtotime($year.'-'.$monthNumber));
			      $date = date('Y-m-t', strtotime($year.'-'.$monthNumber));
			      $allowEntry = true;
			      $errorIds = '';
			      foreach ($employees as $row) {
			          if($row['net_payment'] < 1){
			              $allowEntry = false;
			              $errorIds .= 'Emp-'.sprintf('%03d', $row['id']).', ';
			          }
			      }
			      if($allowEntry){
		          $this->db->query("INSERT into tbl_transections_master SET type = 'MonthlySalary', date = '$date', user_id = '$user_id', created_date = '$now'");
			      $v_id = $this->db->insert_id();
			      foreach ($employees as $row) {
			        $absent_days = $this->db->query("SELECT * FROM `tbl_attendance` where attendance_status = 'Absent' && user_id = '{$row['id']}' && MONTHNAME(attendance_date) = '$month'")->num_rows();
			        $present_days = 30-$absent_days;
			        $salaryperday = $row['net_payment']/30;
			        $deduction = round($salaryperday * $absent_days);
			        $totalsalary = $row['net_payment'] - $deduction;
			        
			        if($totalsalary > 1){
			            $data[] = array(
    						'user_id'           =>      $row['id'],
    						'designation'       =>      $row['designation'],
    						'plants'            =>      $row['plants'],
    						'month'             =>      $month,
    						'year'              =>      $year,
    						'bonus'             =>      '',
    						'present_days'      =>      $present_days,
    						'absent_days'      =>       $absent_days,
    						'basic_salary'      =>      $totalsalary,
    						'deduction'         =>      $deduction,
    						'created_datetime'  =>      date('Y-m-t H:i:s', strtotime($year.'-'.$monthNumber)),
    						'monthyear'         =>      $monthyear,
    						'created_by'        =>      $this->session->userdata('user_id'),
    						'salary_status'     =>      0,
    					);
					
    					$narration = $month.' '.$year.' (Monthly Salary) - To be Paid.';
    					$this->db->query("INSERT INTO tbl_transections_details SET v_id = '$v_id', coa_id = '{$row['accounts_id']}', narration = '$narration', credit = '$totalsalary'");
    					$this->db->query("INSERT INTO tbl_transections_details SET v_id = '$v_id', coa_id = '301005001', narration = '$narration', debit = '$totalsalary'");
					
			        }
			        
			}
            
			        $employees = $this->db->insert_batch('tbl_payroll', $data);	
			         /****************** Activity Log *****************************/
		        $user_role=$this->session->userdata('user_role');
	        	$user_role_name=$this->session->userdata('user_role_name');
	        	$user_id=$this->session->userdata('user_id');
	        	$client_ip=$this->Gen->get_client_ip();
	        	$address=$this->Base_model->getLocation($client_ip);
                $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
                $date=date('Y-m-d H:i:s');
	        	$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'ADD',fld_detail='Salaries Generate $monthyear',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			      }else{
			          $this->session->set_userdata(array('error_message' => "Error occurred in salary generation. Please setup salaries of the following Employee or delete them ".$errorIds));
				    redirect('Payroll/generatesalaries'.$queryGet);
				    exit;
			      }
			}
			  
	        
			if($employees){
				$this->session->set_userdata(array('success_message' => "Salary Generate successfully"));
				$this->output->set_header("Location: " . base_url() . 'Payroll/generatesalaries'.$queryGet, TRUE, 302);
			}else{
				$this->session->set_userdata(array('error_message' => "Payroll not added. Something went wrong"));
				$this->output->set_header("Location: " . base_url() . 'Payroll/generatesalaries'.$queryGet, TRUE, 302);
			}
		  }
		}
	}
	
	public function delete_salary(){
	    $date = $this->input->get('date');
	    $month = date('F', strtotime($date));
	    $last_date = date('Y-m-t', strtotime($date));
	    $this->db->query("DELETE FROM tbl_payroll WHERE monthyear = '$date'");
	    $v_id = $this->db->query("SELECT * FROM tbl_transections_master WHERE type='MonthlySalary' && type_id = '0' && date='$last_date'")->row()->id;
	    $this->db->query("DELETE FROM tbl_transections_details WHERE v_id = '$v_id'");
	    $this->db->query("DELETE FROM tbl_transections_master WHERE id = '$v_id'");
	    $this->session->set_userdata(array('success_message' => "Salary Deleted successfully"));
		$this->output->set_header("Location: " . base_url() . 'Payroll/generatesalaries'.$queryGet, TRUE, 302);
	}
	
	
	public function add(){
		
		$this->form_validation->set_rules('employee_code', 'Employee code', 'required');
		$this->form_validation->set_message('full_name', 'Full name', 'required');
		$this->form_validation->set_message('f_hus_name', 'Father/Husband name', 'required');
		$this->form_validation->set_message('cnic', 'CNIC number', 'required');
		$this->form_validation->set_message('mobile_no', 'Mobile No', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Employees', TRUE, 302);
		} else {
			$data = array(
            'employee_code'     => $this->input->post('employee_code',TRUE),
            'is_active'         => $this->input->post('is_active',TRUE),
            'date'              => date('Y-m-d', strtotime($this->input->post('date'))),
            'employee_type'     => $this->input->post('employee_type',TRUE),
            'agreement_type'    => $this->input->post('agreement_type',TRUE),
            'department'        => $this->input->post('department',TRUE),
            'designation'       => $this->input->post('designation',TRUE),
			'plants'            => $this->input->post('plants',TRUE),
            'full_name'         => $this->input->post('full_name',TRUE),
            'f_hus_name'        => $this->input->post('f_hus_name',TRUE),
            'marital_status'    => $this->input->post('marital_status',TRUE),
            'religion'          => $this->input->post('religion',TRUE),
            'cnic'              => $this->input->post('cnic',TRUE),
            'dob'               => date('Y-m-d', strtotime($this->input->post('dob'))),
			'joining_date'      => date('Y-m-d', strtotime($this->input->post('joining_date'))),
			'salary'            => $this->input->post('salary',TRUE),
			'shift_group'       => $this->input->post('shift_group',TRUE),
			'shift_date'        => date('Y-m-d', strtotime($this->input->post('shift_date'))),
			'job_start_date'     => date('Y-m-d', strtotime($this->input->post('job_start_date'))),
			'job_end_date'       => date('Y-m-d', strtotime($this->input->post('job_end_date'))),
			'created_on'         => date('Y-m-d H:i:s'),
            'deleted'            => 0
        );
         
        $employees=$this->db->insert('tbl_employees',$data);
		if($employees){
			$this->session->set_userdata(array('success_message' => "Employee added successfully"));
            $this->output->set_header("Location: " . base_url() . 'Employees', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Employee not added. Something went wrong"));
            $this->output->set_header("Location: " . base_url() . 'Employees', TRUE, 302);
		}
			
		}
	}
	
	public function paySalary(){
	    
	    $payroll_id = $this->input->post('payroll_id');
	    $from_account = $this->input->post('from_account');
	    $from_account_name = $this->db->query("SELECT * FROM tbl_coa WHERE head_code = '$from_account'")->row()->head_name;
	    $type = $this->input->post('salary_type');
	    $narration = $this->input->post('narration');
	    $amount = $this->input->post('amount');
	    
	    $payrollData = $this->db->query("SELECT * FROM tbl_payroll WHERE id = '$payroll_id'")->row();
	    $emp_id = $payrollData->user_id;
	    $empData = $this->db->query("SELECT * FROM tbl_employees WHERE id = '$emp_id'")->row();
	    $empAccountsId = $empData->accounts_id;
	    $empName = $empData->full_name;
	    $monthSalary =  $payrollData->month.', '.$payrollData->year;
	    $date = date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('paydate',TRUE))));
	    $now = date('Y-m-d H:i:s');
	    $user_id = $this->session->userdata('user_id');
	    $this->db->query("update tbl_payroll set salary_status ='1', paid_from = '$from_account_name', paid_via = '$type', amount_paid = '$amount', paid_date = '$date' where id = '$payroll_id'");
        $this->db->query("INSERT into tbl_transections_master SET type = 'MonthlySalary', type_id='$payroll_id', date = '$date', user_id = '$user_id', created_date = '$now'");
        $v_id = $this->db->insert_id();
        
        $narration = 'Monthly Salary, '.$monthSalary.' has been debited in '.$empName.' account via '.$type.' and credited from '.$from_account_name.'. ('.$narration.')';
    	$this->db->query("INSERT INTO tbl_transections_details SET v_id = '$v_id', coa_id = '$from_account', narration = '$narration', credit = '$amount'");
    	$this->db->query("INSERT INTO tbl_transections_details SET v_id = '$v_id', coa_id = '$empAccountsId', narration = '$narration', debit = '$amount'");
    	echo 'Paid';
    	   /****************** Activity Log *****************************/
		        $user_role=$this->session->userdata('user_role');
	        	$user_role_name=$this->session->userdata('user_role_name');
	        	$user_id=$this->session->userdata('user_id');
	        	$client_ip=$this->Gen->get_client_ip();
	        	$address=$this->Base_model->getLocation($client_ip);
                $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
                $date=date('Y-m-d H:i:s');
	        	$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'ADD',fld_detail='Salarie Paid $empName',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
    	exit();
					
	    
	}
	
	
	public function update_payroll(){
	   // print_r($_POST);
	   // exit();
		 $data = array(
			$_POST["name"] => $_POST['value'],
		 );
		 if($_POST["name"]=='absent_days'){
		     $data['present_days'] = 30-$_POST['value'];
		 }
	     $this->db->update('tbl_payroll', $data, array('id' => $_POST['pk']));
	}
	
	public function filter(){
	    
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
// 		if(empty($_POST['year'])){
// 		    echo "all_required";
// 		    exit();
// 		}

		$conditions="";
		$filter=$_POST['filter'];
		$from_date=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('from_date',TRUE))));
		$to_date=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('to_date',TRUE))));
// 	echo "tbl_payroll.monthyear >= '$from_date' && tbl_payroll.monthyear <= '$to_date'";
// 	exit;
		$type = $_POST['type'];
		switch ($filter) {
		  case "employeewise":
			$group_by = "tbl_payroll.user_id";
			$select="tbl_employees.full_name as filter_text,tbl_payroll.user_id as filter_value";
			break;
		  case "designationwise":
			$group_by = "tbl_payroll.designation";
			$select="tbl_designation.designation_name as filter_text,tbl_payroll.designation as filter_value";
			break;
			case "plantwise":
			$group_by = "tbl_payroll.plants";
			$select="tbl_locations.fld_location as filter_text,tbl_payroll.plants as filter_value";
			break;
		}
		$date="tbl_payroll.monthyear >= '$from_date' && tbl_payroll.monthyear <= '$to_date'";
		$this->db->select('tbl_payroll.id,'.$select.'');
		$this->db->from('tbl_payroll');
		
// 		switch ($filter) {
// 		  case "employeewise":
// 			break;
// 		  case "designationwise":
// 			break;
// 			case "plantwise":
// 			break;
// 		}
		$this->db->join('tbl_employees','	tbl_employees.id=tbl_payroll.user_id');
		$this->db->join('tbl_designation','tbl_designation.id=tbl_payroll.designation');
		$this->db->join('tbl_locations','tbl_locations.fld_id=tbl_payroll.plants');
		$this->db->where("tbl_payroll.salary_status", 1);
		$this->db->where($date);
		$this->db->group_by($group_by);
		$salary=$this->db->get()->result_array();
// 		echo $this->db->last_query();
//         exit();
		if($salary){
			foreach($salary as $key => $seler){
				$selerdet=$this->getSalaryDetail($seler['filter_value'],$group_by, $date);
				$salary[$key]['detail']=$selerdet;
			}
		}
		$data['salary'] = $salary;
		$data['filter'] = $filter;
		$data['type'] = $type;
		$count=count($salary);
		$html=$this->load->view('salary_report_filter',$data,true);
		echo json_encode(array("html"=>$html,'count'=>$count));
	}
	public function filter_csv(){
	    $_POST=$_GET;
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}


		$conditions="";
		$filter=$_POST['filter'];
		$from_date=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('from_date',TRUE))));
		$to_date=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('to_date',TRUE))));

		$type = $_POST['type'];
		switch ($filter) {
		  case "employeewise":
			$group_by = "tbl_payroll.user_id";
			$select="tbl_employees.full_name as filter_text,tbl_payroll.user_id as filter_value";
			break;
		  case "designationwise":
			$group_by = "tbl_payroll.designation";
			$select="tbl_designation.designation_name as filter_text,tbl_payroll.designation as filter_value";
			break;
			case "plantwise":
			$group_by = "tbl_payroll.plants";
			$select="tbl_locations.fld_location as filter_text,tbl_payroll.plants as filter_value";
			break;
		}
		$date="tbl_payroll.monthyear >= '$from_date' && tbl_payroll.monthyear <= '$to_date'";
		$this->db->select('tbl_payroll.id,'.$select.'');
		$this->db->from('tbl_payroll');

		$this->db->join('tbl_employees','	tbl_employees.id=tbl_payroll.user_id');
		$this->db->join('tbl_designation','tbl_designation.id=tbl_payroll.designation');
		$this->db->join('tbl_locations','tbl_locations.fld_id=tbl_payroll.plants');
		$this->db->where("tbl_payroll.salary_status", 1);
		$this->db->where($date);
		$this->db->group_by($group_by);
		$salary=$this->db->get()->result_array();

		if($salary){
			foreach($salary as $key => $seler){
				$selerdet=$this->getSalaryDetail($seler['filter_value'],$group_by, $date);
				$salary[$key]['detail']=$selerdet;
			}
		}
		$data['salary'] = $salary;
		$data['filter'] = $filter;
		$data['type'] = $type;
		include_once APPPATH.'/third_party/autoload.php';
		$header_row = array("#", "MmYy", "Emp ID", "Name" , "Salary", "Paid Via", "Paid From","Paid Salary");
        $csvName = 'salariesreport'.'.csv';
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="'.$csvName.'";');
        $output = fopen('php://output', 'w');
        
        fputcsv($output,$header_row);
        $i=1;
       foreach($salary as $seler){
            foreach($seler['detail'] as $selerdet){
            
            $dataValus=array($i,date('M', strtotime($selerdet['month'])).' - '.date('y', strtotime($selerdet['year'])), $selerdet['employee_code'],$selerdet['full_name'].' '.$selerdet['designation_name']. ' at '. $selerdet['fld_location'],$selerdet['basic_salary'],$selerdet['paid_via'],$selerdet['paid_from'],$selerdet['amount_paid']);
            fputcsv($output,$dataValus);
            $i++;
            }
        }
            
        fclose($output);

	}
	function getSalaryDetail($id,$group_by, $date){
      //$date="tbl_purchase.fld_purchase_date between '".date("Y-m-d",strtotime($start))." 00:00:00' AND '".date("Y-m-d",strtotime($end))." 23:59:00'";
		$this->db->select('tbl_payroll.*,tbl_employees.full_name,tbl_employees.employee_code,tbl_designation.designation_name,tbl_locations.fld_location');
		$this->db->from('tbl_payroll');
		$this->db->join('tbl_employees','	tbl_employees.id=tbl_payroll.user_id');
		$this->db->join('tbl_designation','tbl_designation.id=tbl_payroll.designation');
		$this->db->join('tbl_locations','tbl_locations.fld_id=tbl_payroll.plants');
		$this->db->where("tbl_payroll.salary_status", 1);
		$this->db->where($date);
		$this->db->where($group_by,$id);
		return $this->db->get()->result_array();
// 		$this->db->last_query();
	}
	
	public function print_salaries_report(){
	    $conditions="";
		$filter = $_GET['filter'];
		$from_date=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->get('from_date',TRUE))));
		$to_date=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->get('to_date',TRUE))));
		$type = $_GET['type'];
		switch ($filter) {
		  case "employeewise":
			$group_by = "tbl_payroll.user_id";
			$select="tbl_employees.full_name as filter_text,tbl_payroll.user_id as filter_value";
			break;
		  case "designationwise":
			$group_by = "tbl_payroll.designation";
			$select="tbl_designation.designation_name as filter_text,tbl_payroll.designation as filter_value";
			break;
		  case "plantwise":
			$group_by = "tbl_payroll.plants";
			$select="tbl_locations.fld_location as filter_text,tbl_payroll.plants as filter_value";
			break;
		}
		
		$date="tbl_payroll.monthyear >= '$from_date' && tbl_payroll.monthyear <= '$to_date'";
		$this->db->select('tbl_payroll.id,'.$select.'');
		$this->db->from('tbl_payroll');
		
// 		switch ($filter) {
// 		  case "employeewise":
// 			break;
// 		  case "designationwise":
// 			break;
// 			case "plantwise":
// 			break;
// 		}

		$this->db->join('tbl_employees','	tbl_employees.id=tbl_payroll.user_id');
		$this->db->join('tbl_designation','tbl_designation.id=tbl_payroll.designation');
		$this->db->join('tbl_locations','tbl_locations.fld_id=tbl_payroll.plants');
		$this->db->where($date);
		$this->db->group_by($group_by);
		$salary=$this->db->get()->result_array();
		if($salary){
			foreach($salary as $key => $seler){
				$selerdet=$this->getSalaryDetail($seler['filter_value'],$group_by, $date);
				$salary[$key]['detail']=$selerdet;
			}
		}
		$data['salary'] = $salary;
		$data['type'] = $_GET['type'];
		$this->load->view('reports/print_salaries_report', $data);
		
	}
	public function pdf_salaries_report(){
		include_once APPPATH.'/third_party/autoload.php';
		//$this->load->view('print_purchase_report');
		$mpdf = new \Mpdf\Mpdf();
		
		$conditions="";
		$filter=$_GET['filter'];
		$from_date=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->get('from_date',TRUE))));
		$to_date=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->get('to_date',TRUE))));
		$type = $_GET['type'];
		switch ($filter) {
		  case "employeewise":
			$group_by = "tbl_payroll.user_id";
			$select="tbl_employees.full_name as filter_text,tbl_payroll.user_id as filter_value";
			break;
		  case "designationwise":
			$group_by = "tbl_payroll.designation";
			$select="tbl_designation.designation_name as filter_text,tbl_payroll.designation as filter_value";
			break;
			case "plantwise":
			$group_by = "tbl_payroll.plants";
			$select="tbl_locations.fld_location as filter_text,tbl_payroll.plants as filter_value";
			break;
		}
	
		$date="tbl_payroll.monthyear >= '$from_date' && tbl_payroll.monthyear <= '$to_date'";
		$this->db->select('tbl_payroll.id,'.$select.'');
		$this->db->from('tbl_payroll');
		
// 		switch ($filter) {
// 		  case "employeewise":
// 			break;
// 		  case "designationwise":
// 			break;
// 			case "plantwise":
// 			break;
// 		}
		$this->db->join('tbl_employees','	tbl_employees.id=tbl_payroll.user_id');
		$this->db->join('tbl_designation','tbl_designation.id=tbl_payroll.designation');
		$this->db->join('tbl_locations','tbl_locations.fld_id=tbl_payroll.plants');
		$this->db->where($date);
		$this->db->group_by($group_by);
		$salary=$this->db->get()->result_array();
		if($salary){
			foreach($salary as $key => $seler){
				$selerdet=$this->getSalaryDetail($seler['filter_value'],$group_by, $date);
				$salary[$key]['detail']=$selerdet;
			}
		}
		$data['salary'] = $salary;
		$data['type'] = $_GET['type'];
		$html = $this->load->view('reports/pdf_salaries_report.php',$data,true);
// 		echo '<pre>';
// 		print_r($html);
// 		exit;
		$mpdf->WriteHTML($html);
		$mpdf->Output('Salaries Report '.date('d - M - Y H:i').'.pdf','D');
		//$mpdf->Output();
	}
	
	public function print_single_salary($id){
	   $data['salary']=$this->Base_model->getRow('tbl_payroll','','id ='.$id.'');
	    $this->load->view('reports/print_single_salary', $data);
	}
	
	public function pdf_single_salary($id){
	    include_once APPPATH.'/third_party/autoload.php';
	    $mpdf = new \Mpdf\Mpdf();
	    $data['salary']=$this->Base_model->getRow('tbl_payroll','','id ='.$id.'');
	    $html = $this->load->view('reports/pdf_single_salary',$data,true);
// 		echo '<pre>';
// 		print_r($html);
// 		exit;
	    $mpdf->WriteHTML($html);
		$mpdf->Output('Salary Report.pdf','D');
	}
	
	public function getFilterPaidsalaries(){
	   // print_r($_POST);
	   // exit();
	    $whereData = array();
	   if(!empty($_POST['month'])){
	       $whereData['month'] = $_POST['month'];
	   }
	   if(!empty($_POST['year'])){
	       $whereData['year'] = $_POST['year'];
	   }
	   if(!empty($_POST['fld_emp_name'])){
	       $whereData['user_id'] = $_POST['fld_emp_name'];
	   }
	   if(!empty($_POST['designation'])){
	       $whereData['designation'] = $_POST['designation'];
	   }
	   if(!empty($_POST['from_account'])){
	       $whereData['paid_from'] = $_POST['from_account'];
	   }
	   //if(!empty($_POST['department'])){
	   //    $whereData['department'] = $_POST['department'];
	   //}
	   $whereData['salary_status'] = 1;
	   
	   $data = array();
	   $filteredEmployee = $this->Base_model->getAll('tbl_payroll', '*', $whereData);
	   
	   if($filteredEmployee){
	        $table = '';
	        
            foreach($filteredEmployee as $emp){ 
                $designation =	$this->Common_model->select_single_field('designation_name','tbl_designation',array('id'=>$emp['designation']));       
				$plant       =	$this->Common_model->select_single_field('fld_location','tbl_locations',array('fld_id'=>$emp['plants']));
				$name        =	$this->Common_model->select_single_field('full_name','tbl_employees',array('id'=>$emp['user_id']));
			
            $table .= '<tr>
                            <td>'.$emp['month'].', '.$emp['year'].'</td>
                            <td>'.$name.'<br>'.'<span style="width: 130px; display: inline-block;color:#21d0c0; font-size:10px;">'.$designation.'</span>'.'</td>
							<td>'.$emp['basic_salary'].'</td>
                            <td>'.$emp['amount_paid'].'</td>
                            <td>'.$emp['paid_via'].'</td>
                            <td>'.$emp['paid_from'].'</td>
                            <td>
                            <a href="#" onclick="window.open("'.base_url('Payroll/print_single_salary/'.$emp['id']).', "Salary Report", "width=1210, height=842"");">
                            <i style="font-size:15px;cursor:pointer;" class="mdi mdi-printer" title="Print"></i></a>
                            
                            <a href="#" onclick="window.open("'.base_url('Payroll/pdf_single_salary/'.$emp['id']).', "Salary Report"");">
                            <i style="font-size:15px;cursor:pointer;" class="mdi mdi-file-pdf" title="Pdf"></i></a>
                            
                            <a href="'.base_url('Payroll/viewpaidsalary/'.$emp['id'].'').'"><i style="font-size:20px;cursor:pointer;" class="mdi mdi-eye-circle-outline" title="View"></i></a>
                        </tr>';
                	}
	        
        	    }else {
        	    
        	$table = '
        <tr>
            <td colspan="7"><p style="color:red;text-align:center;">Sorry No Record Found!</p></td>
        </tr>';
         }
         
         echo $table;
	}
	public function advanceloan()
    {
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		
        $this->title = "Add Loan Setup";
		
		$data['view_scripts']=array(
		  	$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'),
		  	$this->Gen->get_script_url('','https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js'),
		  	$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
		  	$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
		  	$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		  	$this->Gen->get_script_url('custom_js','hrm.js'),
		);
		$data['view_css']=array(
		   $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
        $this->load_template('','addloan',$data);
    }
    
    public function updateloansetup(){

			$this->form_validation->set_rules('employee_code', 'Employee code', 'required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_userdata(array('error_message' => validation_errors()));
				$this->output->set_header("Location: " . base_url() . 'Payroll/addsalarysetup', TRUE, 302);
			} else {
			    //$date = date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('attendance_date'))));  new date formate
			$data = array(
			        'total_advance_amount'         =>  $this->input->post('total_advance_amount',TRUE),
			        'loanpaid_type'         =>  $this->input->post('loanpaid_type',TRUE),
    			    'pay_per_month'         =>  $this->input->post('pay_per_month',TRUE)
			);

			$emp_code = $this->input->post('employee_code',TRUE);
			$this->db->where('employee_code',$emp_code);
			$employees=$this->db->update('tbl_employees',$data);
			
			if($employees){
			    /****************** Activity Log *****************************/
        		$user_role=$this->session->userdata('user_role');
        		$user_role_name=$this->session->userdata('user_role_name');
        		$user_id=$this->session->userdata('user_id');
        		$client_ip=$this->Gen->get_client_ip();
        		$address=$this->Base_model->getLocation($client_ip);
                $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
                $date=date('Y-m-d H:i:s');
        		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'ADD',fld_detail='Advance Loan added $emp_code',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
				$this->session->set_userdata(array('success_message' => "Employee Advance/Loan Setup added successfully"));
				$this->output->set_header("Location: " . base_url() . 'Payroll/advanceloan', TRUE, 302);
			}else{
				$this->session->set_userdata(array('error_message' => "Employee Advance/Loan Setup not added. Something went wrong"));
				$this->output->set_header("Location: " . base_url() . 'Payroll/advanceloan', TRUE, 302);
			}
				
			}
	}
	
	public function manage_salarysetup()
    {
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
// 		$role_permissions  = explode(",",$this->session->userdata('permissions'));
// 		if(!empty($role_permissions) && !in_array(37,$role_permissions)) {
// 			$this->session->set_userdata(array('error_message' => "Access Denied!"));
// 			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
// 		}
		$this->title = "View Salary Setup";
		$data['view_scripts']=array(
    		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
    		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
    		$this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
    		$this->Gen->get_script_url('custom_js','hrm.js'),
		);
		$data['view_css']=array(
		    $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);

		$data['employees'] = $this->db->query("SELECT * FROM tbl_employees WHERE basic_pay != '' AND is_active = 1")->result_array();
        $this->load_template('','manage_salarysetup',$data);
	}
	
}
