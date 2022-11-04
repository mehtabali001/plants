<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employees extends My_controller {
	
	function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Karachi');
		$this->load->model('Employees_model');
		$this->load->model('Common_model');
		$this->load->helper('crop_resize_image');
    }
	
	public function index()
    {
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(36,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
        $this->title = "New Employee";
		
		$maxEmployeeID=$this->Employees_model->getMaxemployeeID();
		$data['maxid']='Emp-'.sprintf('%03d', $maxEmployeeID['Auto_increment']);
		
		//For Form Validation
		$data['view_scripts']=array(
			$this->Gen->get_script_url('','https://code.jquery.com/jquery-2.2.4.min.js'),
		  	$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		    $this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		  	$this->Gen->get_script_url('custom_js','hrm.js'),
			$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js'),
		  //	$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'),
		  	$this->Gen->get_script_url('','https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js'),
		  	$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
			$this->Gen->get_script_url('custom_js','script.js'),
		);
		
		$data['view_css']=array(
		   $this->Gen->get_script_url('theme_css','style.css'),
		   $this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
		   $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
        $this->load_template('','addEmployee',$data);
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
          //'date'              => date('Y-m-d', strtotime($this->input->post('date'))),
            'date'              => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('date')))),
            'employee_type'     => $this->input->post('employee_type',TRUE),
            'agreement_type'    => $this->input->post('agreement_type',TRUE),
            'department'        => $this->input->post('department',TRUE),
            'designation'       => $this->input->post('designation',TRUE),
            'plants'            => $this->input->post('plants',TRUE),
            'full_name'         => $this->input->post('full_name',TRUE),
            'email'             => $this->input->post('email',TRUE),
            'f_hus_name'        => $this->input->post('f_hus_name',TRUE),
            'marital_status'    => $this->input->post('marital_status',TRUE),
            'religion'          => $this->input->post('religion',TRUE),
            'cnic'              => $this->input->post('cnic',TRUE),
            //'dob'             => date('Y-m-d', strtotime($this->input->post('dob'))),
            'dob'               => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('dob')))),
			'joining_date'      => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('joining_date')))),
			'address'           => $this->input->post('address',TRUE),
			'phone_no'          => $this->input->post('phone_no',TRUE),
			'mobile_no'         => $this->input->post('mobile_no',TRUE),
			'emergency_contact' => $this->input->post('emergency_contact',TRUE),
			'bank_name'         => $this->input->post('bank_name',TRUE),
			'account_no'        => $this->input->post('account_no',TRUE),
// 			'salary'            => $this->input->post('salary',TRUE),
			'shift_group'       => $this->input->post('shift_group',TRUE),
			//'shift_date'       => date('Y-m-d', strtotime($this->input->post('shift_date'))),
			'degree_level'       => $this->input->post('degree_level',TRUE),
			'degree_start_date'  => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('degree_start_date')))),
			'degree_end_date'    => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('degree_end_date')))),
			'degree_name'       => $this->input->post('degree_name',TRUE),
			'major_subjects'       => $this->input->post('major_subjects',TRUE),
			'institute_name'       => $this->input->post('institute_name',TRUE),
			'obtained_gpa'       => $this->input->post('obtained_gpa',TRUE),
			'total_gpa'       => $this->input->post('total_gpa',TRUE),
			'job_held'       => $this->input->post('job_held',TRUE),
			'job_start_date'    => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('job_start_date')))),
			'job_end_date'    => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('job_end_date')))),
			'pay_draw'       => $this->input->post('pay_draw',TRUE),

// 			'basic_pay'       => $this->input->post('basic_pay',TRUE),
//  		'conv_allow'       => $this->input->post('conv_allow',TRUE),
//  		'med_allow'       => $this->input->post('med_allow',TRUE),
//  		'other'       => $this->input->post('other',TRUE),
// 			'gross_pay'       => $this->input->post('gross_pay',TRUE),
// 			'eobi'       => $this->input->post('eobi',TRUE),
// 			'social_security'       => $this->input->post('social_security',TRUE),
// 			'salary_tax'       => $this->input->post('salary_tax',TRUE),
// 			't_deductions'       => $this->input->post('t_deductions',TRUE),
// 			'net_payment'       => $this->input->post('net_payment',TRUE),

			'created_on'        => date('Y-m-d H:i:s'),
            'deleted'           => 0
        );
		  
		  if(isset($_FILES['picture']['name']) != '')
			 {
				$image 		   = $_FILES['picture']['name'];
				$image 		   = time().'_'.$image;
				$name_ext_one  = explode(".", basename($_FILES['picture']['name']));
				$name_ext      = end($name_ext_one);
				$original_path = PATH_DIR.'assets/uploads/profile_pictures/';
				$path	       =	$original_path.$image;
				 if(move_uploaded_file($_FILES['picture']['tmp_name'],$path))
				 {
					$source_image_path = $original_path;
					$source_image_name = $image;
					resize_crop_image_new(150,150,$source_image_path,$source_image_name,'thumbs/s_',$name_ext,300,300,true);
					$data['picture']	=	$image;
				 }
			 }

		  if($_FILES['resume']['name']!='')
		  {
			  $image   	   		= 	$_FILES['resume']['name'];
			  $image 		   	= 	time().'_'.$image;
			//$name_ext      	= 	end(explode(".", basename($_FILES['picture']['name'])));
			  $name_ext      	= 	$_FILES['resume']['name'];
			  $original_path 	=   PATH_DIR.'assets/uploads/resumes/';
			//echo $original_path;exit;
			  $path	       		=   $original_path.$image;
			  if(move_uploaded_file($_FILES['resume']['tmp_name'],$path))
			  {
						$source_image_path = $original_path;
						$source_image_name = $image;
						$data['resume']   =	$image;
			  }
		  }
         
        $employees=$this->db->insert('tbl_employees',$data);
        
        
		if($employees){
		    
		    $emp_id=$this->db->insert_id();
		    
		    $designation = $this->db->select('*')->from('tbl_designation')->where('id',$data['designation'])->get()->row()->designation_name;
		    $plant = $this->db->select('*')->from('tbl_locations')->where('fld_id',$data['plants'])->get()->row()->fld_location;
           
            $account_id = 101006;
            
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
              'head_name'       =>  $data['full_name'].', '.$designation.' at '.$plant.' ('.$data['employee_code'].')',
              'parent_head_name'=>  $getHeadCodeData->head_name,
              'head_level'      =>  $newlevel,
              'type'            => 'EMPLOYEE',
              'type_id'         => $emp_id
            ); 
            
            $this->db->insert('tbl_coa',$acc_data);
            
            $this->db->query("UPDATE tbl_employees SET accounts_id='$HeadCode' WHERE id = '$emp_id'");
            
             /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$user_id=$this->session->userdata('user_id');
		$employee_code=$this->input->post('employee_code',TRUE);
		$employee_code='<a href="'.base_url('Employees/viewEmployee/'.$emp_id.'').'">'.$employee_code.'</a>';
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
        $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	$date=date('Y-m-d H:i:s');
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'ADD',fld_detail='$employee_code',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Employee added successfully"));
            $this->output->set_header("Location: " . base_url() . 'Employees', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Employee not added. Something went wrong"));
            $this->output->set_header("Location: " . base_url() . 'Employees', TRUE, 302);
		}
			
		}
	}
	public function edit($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(38,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
        $this->title = "Update Employee";
		$data['employee']=$this->Base_model->getRow('tbl_employees','','id ='.$id.'');
		
		//For Form Validation
		$data['view_scripts']=array(
			$this->Gen->get_script_url('','https://code.jquery.com/jquery-2.2.4.min.js'),
			$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js'),
			$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		  	$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		  	$this->Gen->get_script_url('plugin_components','timepicker/bootstrap-material-datetimepicker.js'),
			$this->Gen->get_script_url('custom_js','script.js'),
		  	$this->Gen->get_script_url('custom_js','hrm.js'),
		  	$this->Gen->get_script_url('','https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js'),
		  	$this->Gen->get_script_url('plugin_components','select2/select2.min.js')
		);
		
		$data['view_css']=array(
		    $this->Gen->get_script_url('theme_css','style.css'),
		    $this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
		    $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		    $this->Gen->get_script_url('plugin_components','timepicker/bootstrap-material-datetimepicker.css'),
		);
		
        $this->load_template('','editEmployee',$data);
	}
	
	
public function editProcess(){

			$this->form_validation->set_rules('employee_code', 'Employee code', 'required');
		    $this->form_validation->set_message('full_name', 'Full name', 'required');
		    $this->form_validation->set_message('f_hus_name', 'Father/Husband name', 'required');
		    $this->form_validation->set_message('cnic', 'CNIC number', 'required');
		    $this->form_validation->set_message('mobile_no', 'Mobile No', 'required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_userdata(array('error_message' => validation_errors()));
				$this->output->set_header("Location: " . base_url() . 'Supplier', TRUE, 302);
			} else {
				$data = array(
				'employee_code'   => $this->input->post('employee_code',TRUE),
				'is_active'       => $this->input->post('is_active',TRUE),
				'date'            => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('date')))),
				'employee_type'   => $this->input->post('employee_type',TRUE),
				'agreement_type'  => $this->input->post('agreement_type',TRUE),
				'department'      => $this->input->post('department',TRUE),
				'designation'     => $this->input->post('designation',TRUE),
				'plants'            => $this->input->post('plants',TRUE),
				'full_name'       => $this->input->post('full_name',TRUE),
				'email'         => $this->input->post('email',TRUE),
				'f_hus_name'      => $this->input->post('f_hus_name',TRUE),
				'gender'          => $this->input->post('gender',TRUE),
				'marital_status'  => $this->input->post('marital_status',TRUE),
				'religion'        => $this->input->post('religion',TRUE),
				'cnic'            => $this->input->post('cnic',TRUE),
				'dob'             => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('dob')))),
				'joining_date'    => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('joining_date')))),
				'address'         => $this->input->post('address',TRUE),
				'phone_no'         => $this->input->post('phone_no',TRUE),
				'mobile_no'         => $this->input->post('mobile_no',TRUE),
				'emergency_contact' => $this->input->post('emergency_contact',TRUE),
				'bank_name'         => $this->input->post('bank_name',TRUE),
				'account_no'         => $this->input->post('account_no',TRUE),
				'shift_group'         => $this->input->post('shift_group',TRUE),
				'degree_level'       => $this->input->post('degree_level',TRUE),
			    'degree_start_date'  => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('degree_start_date')))),
			    'degree_end_date'    => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('degree_end_date')))),
			    'degree_name'       => $this->input->post('degree_name',TRUE),
			    'major_subjects'       => $this->input->post('major_subjects',TRUE),
			    'institute_name'       => $this->input->post('institute_name',TRUE),
			    'obtained_gpa'       => $this->input->post('obtained_gpa',TRUE),
			    'total_gpa'       => $this->input->post('total_gpa',TRUE),
			    'job_held'       => $this->input->post('job_held',TRUE),
			    'job_start_date'    => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('job_start_date')))),
			    'job_end_date'    => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('job_end_date')))),
			    'pay_draw'       => $this->input->post('pay_draw',TRUE),

			 //   'basic_pay'       => $this->input->post('basic_pay',TRUE),
			 //   'conv_allow'       => $this->input->post('conv_allow',TRUE),
			 //   'med_allow'       => $this->input->post('med_allow',TRUE),
			 //   'other'       => $this->input->post('other',TRUE),
			 //   'gross_pay'       => $this->input->post('gross_pay',TRUE),
			 //   'eobi'       => $this->input->post('eobi',TRUE),
			 //   'social_security'       => $this->input->post('social_security',TRUE),
    //             'salary_tax'       => $this->input->post('salary_tax',TRUE),
			 //   't_deductions'       => $this->input->post('t_deductions',TRUE),
			 //   'net_payment'       => $this->input->post('net_payment',TRUE),
			    
				'created_on'         => date('Y-m-d H:i:s'),
				'deleted'          => 0
			);

			$emp_id = $this->input->post('employee_id',TRUE);

		  
		  if(!empty($_FILES['picture']['name']))
			 {
				$image 		   = $_FILES['picture']['name'];
				$image 		   = time().'_'.$image;
				$name_ext_one  = explode(".", basename($_FILES['picture']['name']));
				$name_ext      = end($name_ext_one);
				$original_path = PATH_DIR.'assets/uploads/profile_pictures/';
				$path	       =	$original_path.$image;
				 if(move_uploaded_file($_FILES['picture']['tmp_name'],$path))
				 {
					$source_image_path = $original_path;
					$source_image_name = $image;
					resize_crop_image_new(150,150,$source_image_path,$source_image_name,'thumbs/s_',$name_ext,300,300,true);
				
					$data['picture']	=	$image;
					$this->unlink_file_image($emp_id);
				 }
			 }

		  if(!empty($_FILES['resume']['name']))
		  {
			  $resume   	   	= 	$_FILES['resume']['name'];
			  $resume 		   	= 	time().'_'.$resume;
			//$name_ext      	= 	end(explode(".", basename($_FILES['picture']['name'])));
			  $name_ext      	= 	$_FILES['resume']['name'];
			  $original_path 	=   PATH_DIR.'assets/uploads/resumes/';
			//echo $original_path;exit;
			  $path	       		=   $original_path.$resume;
			  if(move_uploaded_file($_FILES['resume']['tmp_name'], $path)) {
				// echo "Uploaded";
			  } else {
				// echo "File was not uploaded";
			  }
			  $data['resume']	=	$resume;
			  $this->unlink_resume($emp_id);
		  }

		    //$employees = $this->Common_model->update_array(array('id'=>$emp_id),'tbl_employees',$data);
			 $this->db->where('id',$emp_id);
			 $employees=$this->db->update('tbl_employees',$data);
			 
			 $designation = $this->db->select('*')->from('tbl_designation')->where('id',$data['designation'])->get()->row()->designation_name;
		     $plant = $this->db->select('*')->from('tbl_locations')->where('fld_id',$data['plants'])->get()->row()->fld_location;
			 
			 $acc_data = array(
              'head_name'       =>  $data['full_name'].', '.$designation.' at '.$plant.' ('.$data['employee_code'].')',
             ); 
             
            $this->db->update('tbl_coa', $acc_data, array('type'=>'EMPLOYEE', 'type_id' => $emp_id));
			if($employees){
			     /****************** Activity Log *****************************/
        		$user_role=$this->session->userdata('user_role');
        		$user_role_name=$this->session->userdata('user_role_name');
        		$user_id=$this->session->userdata('user_id');
        		$employee_code=$this->input->post('employee_code',TRUE);
        		$employee_code='<a href="'.base_url('Employees/viewEmployee/'.$emp_id.'').'">'.$employee_code.'</a>';
        		$client_ip=$this->Gen->get_client_ip();
        		$address=$this->Base_model->getLocation($client_ip);
                $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
            	$date=date('Y-m-d H:i:s');
        		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'UPDATE',fld_detail='$employee_code',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
				$this->session->set_userdata(array('success_message' => "Employee updated successfully"));
				$this->output->set_header("Location: " . base_url() . 'Employees/manage_Employees', TRUE, 302);
			}else{
				$this->session->set_userdata(array('error_message' => "Employee not updated. Something went wrong"));
				$this->output->set_header("Location: " . base_url() . 'Employees/edit/'.$emp_id.'', TRUE, 302);
			}
				
			}
		
	}
	
	public function editattendancerecords(){

			$this->form_validation->set_rules('check_in', 'Check In', 'required');
		    $this->form_validation->set_message('check_out', 'Check Out', 'required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_userdata(array('error_message' => validation_errors()));
				$this->output->set_header("Location: " . base_url() . 'Employees/attendance', TRUE, 302);
			} else {
				$data = array(
				'check_in'        =>   $this->input->post('check_in',TRUE),
				'check_out'       => $this->input->post('check_out',TRUE),
                'attendance_status'       => $this->input->post('attendance_status',TRUE),
			);

			$att_id = $this->input->post('attendance_id',TRUE);

			 $this->db->where('attendance_id',$att_id);
			 $attendance=$this->db->update('tbl_attendance',$data);
			if($attendance){
				$this->session->set_userdata(array('success_message' => "Attendance updated successfully"));
				$this->output->set_header("Location: " . base_url() . 'Employees/manage_attendance', TRUE, 302);
			}else{
				$this->session->set_userdata(array('error_message' => "Attendance not updated. Something went wrong"));
				$this->output->set_header("Location: " . base_url() . 'Employees/manage_attendance', TRUE, 302);
			}
				
			}
		
	}

    function unlink_file_image($emp_id)
	{
		$query	=	$this->Common_model->select_where('picture','tbl_employees',array('id'=>$emp_id));
		if($query->num_rows() > 0){
			$row	=	$query->row_array();
			$img	=	$row['picture'];
			@unlink(PATH_DIR."assets/uploads/profile_pictures/".$img);
			@unlink(PATH_DIR."assets/uploads/profile_pictures/thumbs/s_".$img);
		}
	}

	function unlink_resume($emp_id)
	{
		$query	=	$this->Common_model->select_where('resume','tbl_employees',array('id'=>$emp_id));
		if($query->num_rows() > 0){
			$row	=	$query->row_array();
			$img	=	$row['picture'];
			@unlink(PATH_DIR."assets/uploads/resumes/".$img);
		}
	}
	public function viewEmployee($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$user_id = $this->session->userdata('user_id');
        $user_data=$this->db->query("select * from tbl_users where fld_id = '$user_id' ")->row();
        $emp_username = $user_data->fld_username;
        $emp_id = $user_data->emp_id;
		if($emp_id != $id){
		    $role_permissions  = explode(",",$this->session->userdata('permissions'));
		    if(!empty($role_permissions) && !in_array(40,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		}
		
        $this->title = "Employee Details";
		$data['employees']=$this->Base_model->getRow('tbl_employees','','id ='.$id.'');
//      For Form Validation
// 		$data['view_scripts']=array(
// 			$this->Gen->get_script_url('','https://code.jquery.com/jquery-2.2.4.min.js'),
// 			$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js'),
// 			$this->Gen->get_script_url('custom_js','script.js'),
// 		  	$this->Gen->get_script_url('custom_js','hrm.js'),
// 		);
		
		$data['view_css']=array(
		   $this->Gen->get_script_url('theme_css','style.css'),
		);
		if(empty($data['employees'])){
	      $this->session->set_userdata(array('error_message' => "This record does not exist."));
		  $this->output->set_header("Location: " . base_url() . 'Settings/log_system', TRUE, 302);
		}
        $this->load_template('','viewEmployee',$data);
	}
	
	public function delete($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(39,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		
	  //$responce = $this->Base_model->delete('tbl_employees','id ='.$id.'');
		
		$user_id = $this->session->userdata('user_id');
	  //$this->db->set('fld_trash_date', 'NOW()', FALSE);
		$timedate = date('Y-m-d H:i:s');
		$responce = $this->db->update('tbl_employees', array('deleted'=>1, 'fld_trash_by' => $user_id, 'fld_trash_date' => $timedate), 'id ='.$id.'');
	  
        if($responce){
            
             /****************** Activity Log *****************************/
    		$user_role=$this->session->userdata('user_role');
    		$user_role_name=$this->session->userdata('user_role_name');
    		$user_id=$this->session->userdata('user_id');
    		$employee_code='Emp-'.sprintf('%03d', $id);
    		$employee_code='<a href="'.base_url('Employees/viewEmployee/'.$id.'').'">'.$employee_code.'</a>';
    		$client_ip=$this->Gen->get_client_ip();
    		$address=$this->Base_model->getLocation($client_ip);
            $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
        	$date=date('Y-m-d H:i:s');
    		
    		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'TRASHED',fld_detail='$employee_code',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Employee is trashed, you need to delete it permanently from trash."));
			$this->output->set_header("Location: " . base_url() . 'Employees/manage_trash', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Employee not trashed. Something went wrong"));
			$this->output->set_header("Location: " . base_url() . 'Employees/manage_Employees', TRUE, 302);
		}
	}
	
	public function restore($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(142,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}

		$responce = $this->db->update('tbl_employees', array('deleted'=>0),'id ='.$id.'');
        if($responce){
			$this->session->set_userdata(array('success_message' => "Employee is restored successfully, please check in manage employees."));
			$this->output->set_header("Location: " . base_url() . 'Employees/manage_trash', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Employee not restored. Something went wrong"));
			$this->output->set_header("Location: " . base_url() . 'Employees/manage_trash', TRUE, 302);
		}
	}
	
	
	public function deletepermanent($id){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(143,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		
	    $responce = $this->Base_model->delete('tbl_employees','id ='.$id.'');
		
        if($responce){
             /****************** Activity Log *****************************/
    		$user_role=$this->session->userdata('user_role');
    		$user_role_name=$this->session->userdata('user_role_name');
    		$user_id=$this->session->userdata('user_id');
    		$employee_code='Emp-'.sprintf('%03d', $id);
    		$employee_code='<a href="'.base_url('Employees/viewEmployee/'.$id.'').'">'.$employee_code.'</a>';
    		$client_ip=$this->Gen->get_client_ip();
    	    $address=$this->Base_model->getLocation($client_ip);
            $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    	    $date=date('Y-m-d H:i:s');
    		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'DELETED',fld_detail='$employee_code',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
			$this->session->set_userdata(array('success_message' => "Employee is permanently deleted."));
			$this->output->set_header("Location: " . base_url() . 'Employees/manage_trash', TRUE, 302);
		}else{
			$this->session->set_userdata(array('error_message' => "Employee not deleted.Something went wrong"));
			$this->output->set_header("Location: " . base_url() . 'Employees/manage_trash', TRUE, 302);
		}
	}
	
	
	public function manage_Employees()
    {
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(37,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$this->title = "View Employees";
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
       
		$data['employees']=$this->Common_model->getAllrows('tbl_employees','',array('deleted'=>0),'');
        $this->load_template('','manage_employees',$data);
	}
	
	public function manage_trash()
    {
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(208,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		$this->title = "Trashed Employees";
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
      
		$data['employees'] = $this->Common_model->getAllrows('tbl_employees','',array('deleted'=>1),'');
        $this->load_template('','manage_employees_trash',$data);
	}
	
	function add_employeeType()
	{
	    $this->form_validation->set_rules('new_type', 'Type Name', 'required');
		if ($this->form_validation->run() == FALSE) {
            echo "required_type_name";
		}else{
		    $new_type		=	$this->input->post('new_type');
		    $count = $this->db->query("select * from tbl_employeestype where type_name = '$new_type'")->num_rows();
		if($count > 0){
		    echo "type_already_found";
		    exit();
		}
		
		$data_ins['type_name']		= 	$new_type;
		$data_ins['deleted']		= 	0;
		$last_type_id			=	$this->Common_model->insert_array('tbl_employeestype',$data_ins);
		
		$data['employeetype']	 	=	$this->Common_model->select_where_ASC_DESC('id,type_name','tbl_employeestype',array('deleted'=>0),'type_name','ASC');
		$data['last_type_id']	 	=	$last_type_id;
		$this->load->view('addemployeeType',$data); 
	}
	}

	function add_agreementType()
	{
	    $this->form_validation->set_rules('new_agreement_type', 'Agreement Type Name', 'required');
		if ($this->form_validation->run() == FALSE) {
            echo "required_agreementtype_name";
		}else{
		    $new_agreement_type		=	$this->input->post('new_agreement_type');
		    $count = $this->db->query("select * from tbl_agreementtype where agreement_type = '$new_agreement_type'")->num_rows();
		if($count > 0){
		    echo "agreementtype_already_found";
		    exit();
		}
		
		$data_ins['agreement_type']		= 	$new_agreement_type;
		$data_ins['deleted']		= 	0;
		$last_agreementtype_id			=	$this->Common_model->insert_array('tbl_agreementtype',$data_ins);
		
		$data['agreementtype']	 	=	$this->Common_model->select_where_ASC_DESC('id,agreement_type','tbl_agreementtype',array('deleted'=>0),'agreement_type','ASC');
		$data['last_agreementtype_id']	 	=	$last_agreementtype_id;
		$this->load->view('addagreementType',$data); 
	}
	}

	function add_department()
	{
	    $this->form_validation->set_rules('new_department', 'Department Name', 'required');
		if ($this->form_validation->run() == FALSE) {
            echo "required_department_name";
		}else{
		    $new_department		=	$this->input->post('new_department');
		    $count = $this->db->query("select * from tbl_departments where department_name = '$new_department'")->num_rows();
		    if($count > 0){
		        echo "department_already_found";
		        exit();
		    }
		
		$data_ins['department_name']   = 	$new_department;
		$data_ins['deleted']		= 	0;
		$last_department_id			=	$this->Common_model->insert_array('tbl_departments',$data_ins);
		
		$data['departments']	 	=	$this->Common_model->select_where_ASC_DESC('id,department_name','tbl_departments',array('deleted'=>0),'department_name','ASC');
		$data['last_department_id']	 	=	$last_department_id;
		$this->load->view('addDepartment',$data); 
	}
	}

	function add_designation()
	{
	    $this->form_validation->set_rules('new_designation', 'Designation Name', 'required');
		if ($this->form_validation->run() == FALSE) {
            echo "required_designation_name";
		}else{
		    $new_designation		=	$this->input->post('new_designation');
		    $count = $this->db->query("select * from tbl_designation where designation_name = '$new_designation'")->num_rows();
		    if($count > 0){
		        echo "designation_already_found";
		        exit();
		    }
		
		$data_ins['designation_name']   = 	$new_designation;
		$data_ins['deleted']		= 	0;
		$last_designation_id			=	$this->Common_model->insert_array('tbl_designation',$data_ins);
		
		$data['designation']	 	=	$this->Common_model->select_where_ASC_DESC('id,designation_name','tbl_designation',array('deleted'=>0),'designation_name','ASC');
		$data['last_designation_id']	 	=	$last_designation_id;
		$this->load->view('addDesignation',$data); 
	}
	}

	function add_religion()
	{
	    $this->form_validation->set_rules('new_religion', 'Religion Name', 'required');
		if ($this->form_validation->run() == FALSE) {
            echo "required_religion_name";
		}else{
		    $new_religion		=	$this->input->post('new_religion');
		    $count = $this->db->query("select * from tbl_religion where religion_name = '$new_religion'")->num_rows();
		    if($count > 0){
		        echo "religion_already_found";
		        exit();
		    }
		
		$data_ins['religion_name']   = 	$new_religion;
		$data_ins['deleted']		 = 	0;
		$last_religion_id			 =	$this->Common_model->insert_array('tbl_religion',$data_ins);
		$data['religion']	 	     =	$this->Common_model->select_where_ASC_DESC('id,religion_name','tbl_religion',array('deleted'=>0),'religion_name','ASC');
		$data['last_religion_id']	 =	$last_religion_id;
		$this->load->view('addReligion',$data); 
	}
	}

	function add_shiftgroup()
	{
	    $this->form_validation->set_rules('new_shift_group', 'Shift Name', 'required');
		if ($this->form_validation->run() == FALSE) {
            echo "required_shift_name";
		}else{
		    $new_shift_group		  =		$this->input->post('new_shift_group');
		    $count = $this->db->query("select * from tbl_shifts where shift_name = '$new_shift_group'")->num_rows();
		    if($count > 0){
		        echo "shift_already_found";
		        exit();
		    }
		
		$data_ins['shift_name']   = 	$new_shift_group;
		$data_ins['deleted']	  = 	0;
		$last_shift_id			  =		$this->Common_model->insert_array('tbl_shifts',$data_ins);
		$data['shift_group']	  =		$this->Common_model->select_where_ASC_DESC('id,shift_name','tbl_shifts',array('deleted'=>0),'shift_name','ASC');
		$data['last_shift_id']	  =		$last_shift_id;
		$this->load->view('addShiftsgroup',$data); 
	}
	}
	
	function add_bank()
	{
	    $this->form_validation->set_rules('new_bank', 'Bank Name', 'required');
		if ($this->form_validation->run() == FALSE) {
            echo "required_bank_name";
		}else{
		    $new_bank	=	$this->input->post('new_bank');
		    $count_bank = $this->db->query("select * from tbl_banks_employees where fld_bank = '$new_bank'")->num_rows();
		if($count_bank > 0){
		    echo "bank_already_found";
		    exit();
		}
		
		$data_ins['fld_bank']       = 	$new_bank;
		//$data_ins['fld_userid']		= 	$this->session->userdata('user_id');
		$data_ins['fld_status']		= 	1;
		$last_bank_id			    =	$this->Common_model->insert_array('tbl_banks_employees',$data_ins);
		
		$data['banks']	 	=	$this->Common_model->select_where_ASC_DESC('fld_id,fld_bank','tbl_banks_employees',array('fld_status'=>1),'fld_bank','ASC');
		$data['last_bank_id']	 	=	$last_bank_id;
		$this->load->view('add_emp_bank',$data); 
	}
	}
	// Attendance Part
	
	public function createAttendance(){
		$this->form_validation->set_rules('attendance_date', 'Attendance Date', 'required');
        $this->form_validation->set_rules('radioInline', 'Check Box', 'required');
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata(array('error_message' => validation_errors()));
            $this->output->set_header("Location: " . base_url() . 'Employees/Addattendance', TRUE, 302);
		} else {
			//$attendance_date	=		date('Y-m-d', strtotime($this->input->post('attendance_date')));
			$attendance_date	=       date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('attendance_date'))));
			$radioInline		=		$this->input->post('radioInline');
			$plantID		    =		$this->input->post('plants');
			$status		        =		$this->input->post('status');
			
			//echo $attendance_date;exit;
		
			
			if(!empty($plantID)){
			$qrry = $this->db->query("SELECT attendance_date, plants FROM tbl_attendance WHERE attendance_date = '".$attendance_date."' AND plants = '".$plantID."'");
			}elseif(!empty($radioInline)){
			 //$qrry = $this->db->query("SELECT attendance_date FROM tbl_attendance WHERE NOT EXISTS (SELECT attendance_date, plants From tbl_attendance WHERE attendance_date = '".$attendance_date."')");	
             $qrry = $this->db->query("SELECT attendance_date FROM tbl_attendance WHERE attendance_date = '".$attendance_date."'");			 
			}
			 
			 $count = $qrry->num_rows();
			if($count > 0) {
			   $this->session->set_userdata(array('error_message' => "Attendance Data Already Exists on this date"));
			   $this->output->set_header("Location: " . base_url() . 'Employees/Addattendance?date='.$attendance_date, TRUE, 302);
			}else{
			if($radioInline == 'all'){			  
			  $data['employees'] = $this->Base_model->getAll('tbl_employees','',"plants NOT IN (SELECT plants FROM tbl_attendance WHERE attendance_date = '".$attendance_date."') AND is_active = 1",'');
			  //$data['employees'] = $this->db->query("SELECT * FROM tbl_employees WHERE plants NOT IN (SELECT plants FROM tbl_attendance WHERE attendance_date = '".$attendance_date."')");
			  
			  //echo $qrry1->num_rows();exit;
			}elseif($radioInline == 'plantwise'){
			  //$data['employees'] =	$this->Common_model->select_where_ASC_DESC('*','tbl_employees',array('plants'=>$plantID),'id','ASC');
              $data['employees'] = $this->Common_model->getAllrows('tbl_employees','',array('plants'=>$plantID,'is_active'=>1),'');			  
			}
			
		      $employees = $data['employees'];
			  $data = array();
			  foreach ($employees as $row) {
					$data[] = array(
						'user_id'           =>      $row['id'],
						'department'        =>      $row['department'],
						'designation'       =>      $row['designation'],
						'plants'            =>      $row['plants'],
						'attendance_status' =>      $status,
						'attendance_date'   =>      $attendance_date,
						'created_datetime'  =>      date('Y-m-d H:i:s'),
						'created_by'        =>      $this->session->userdata('user_id'),
						'check_in'          =>      '09:00:00',
						'check_out'         =>      '17:00:00',
					  //'check_out'         =>      date('Y-m-d H:i:s'),
					);
			}

			$employees=$this->db->insert_batch('tbl_attendance', $data);	
	
			if($employees){
			    /****************** Activity Log *****************************/
        		$user_role=$this->session->userdata('user_role');
        		$user_role_name=$this->session->userdata('user_role_name');
        		$user_id=$this->session->userdata('user_id');
        	//	$employee_code=$this->input->post('employee_code',TRUE);
        		//$employee_code='<a href="'.base_url('Employees/viewEmployee/'.$emp_id.'').'">'.$employee_code.'</a>';
        		$client_ip=$this->Gen->get_client_ip();
        		$address=$this->Base_model->getLocation($client_ip);
                $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
            	$date=date('Y-m-d H:i:s');
        		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'ADD',fld_detail='Attendance added $attendance_date',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
				$this->session->set_userdata(array('success_message' => "Attendance added successfully"));
				$this->output->set_header("Location: " . base_url() . 'Employees/Addattendance?date='.$attendance_date, TRUE, 302);
			}else{
				$this->session->set_userdata(array('error_message' => "Attendance not added. Something went wrong"));
				$this->output->set_header("Location: " . base_url() . 'Employees/Addattendance', TRUE, 302);
			}
		  }
		}
	}
	
	public function Addattendance(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(41,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
        $this->title = "Staff Attendance";
		$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
// 		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
		
		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		$this->Gen->get_script_url('plugin_components','timepicker/bootstrap-material-datetimepicker.js'),
	  //$this->Gen->get_script_url('bower_components','jquery.forms-advanced.js'),
        // $this->Gen->get_script_url('custom_js','attendence.js'),
        $this->Gen->get_script_url('custom_js','hrm.js'),
// 		$this->Gen->get_script_url('','https://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js'),
// 		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap3-editable/js/bootstrap-editable.js'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),

	  //$this->Gen->get_script_url('theme_js','jquery-ui.min.js'),
        // $this->Gen->get_script_url('plugin_components','x-editable/js/bootstrap-editable.min.js'),
		 //$this->Gen->get_script_url('bower_components','jquery.form-xeditable.init.js'),
		
		);
		$data['view_css']=array(
		$this->Gen->get_script_url('theme_css','bootstrap3.css'),
		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap3-editable/css/bootstrap-editable.css'),
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
		$this->Gen->get_script_url('plugin_components','timepicker/bootstrap-material-datetimepicker.css'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
		date_default_timezone_set("Asia/Karachi");
		//echo "The time is " . date("h:i:sa");
		if($this->input->get('date')){
		    $date = $this->input->get('date');
		}else{
		    $date = date('Y-m-d');
		}
		
		//echo $today;exit;
		$data['attendance']= $this->Base_model->getAll('tbl_attendance','',"attendance_date = '".$date."'",'');		
        $this->load_template('','add_attendance',$data);
	}
	
	
	
	public function attendance(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(19,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
        $this->title = "Staff Attendance";
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
		//$this->Gen->get_script_url('bower_components','jquery.forms-advanced.js'),
        $this->Gen->get_script_url('custom_js','attendance.js'),
// 		$this->Gen->get_script_url('','https://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js'),
// 		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap3-editable/js/bootstrap-editable.js'),

		//$this->Gen->get_script_url('theme_js','jquery-ui.min.js'),
         //$this->Gen->get_script_url('plugin_components','x-editable/js/bootstrap-editable.min.js'),
		 //$this->Gen->get_script_url('bower_components','jquery.form-xeditable.init.js'),
		
		);
		$data['view_css']=array(
		$this->Gen->get_script_url('theme_css','bootstrap3.css'),
		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap3-editable/css/bootstrap-editable.css'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
		//$this->Gen->get_script_url('theme_css','bootstrap.min.css'),
		//$this->Gen->get_script_url('theme_css','jquery-ui.min.css'),
		//$this->Gen->get_script_url('plugin_components','x-editable/css/bootstrap-editable.css'),
		$this->Gen->get_script_url('plugin_components','timepicker/bootstrap-material-datetimepicker.css'),
		);
		$data['attendance']= $this->Base_model->getAll('tbl_attendance');
		$data['employees']= $this->Base_model->getAll('tbl_employees');
        $this->load_template('','manage_attendance',$data);
	}
	public function filterattendence_report(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
// 		print_r($_POST);
// 		exit();
        
// 		print_r($this->Employees_model->attendence_filter());
// 		exit();
		$data['attendence']=$attendence=$this->Employees_model->attendence_filter();
		$data['filter_type']=$this->input->post('filter_type');
		$count=count($attendence);
		$html=$this->load->view('attendence_filter',$data,true);
		echo json_encode(array("html"=>$html,'count'=>$count));
		
	}
	public function filterattendence_report_csv(){
	    $_POST=$_GET;
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$data['attendence']=$attendence=$this->Employees_model->attendence_filter();
		
		$data['filter_type']=$this->input->post('filter_type');
		include_once APPPATH.'/third_party/autoload.php';
        $header_row = array("#", "Date", "Name", "Plant" , "Designation", "In Time", "Out Time","Status");
        $csvName = 'attendancereport'.'.csv';
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="'.$csvName.'";');
        $output = fopen('php://output', 'w');
        
        fputcsv($output,$header_row);
        $i=1;
        foreach($attendence as $purch){
            
            foreach($purch['detail'] as $purdet){
               if($purdet['attendance_status'] == 'Present'){
    		      $check_in= $purdet['check_in'];
    		    }elseif($purdet['attendance_status'] == 'Short Leave'){
    		        $check_in= $purdet['check_in'];
    		    }
    		    if($purdet['attendance_status'] == 'Present'){
			      $check_out= $purdet['check_out'];
			    }elseif($purdet['attendance_status'] == 'Short Leave'){
			        $check_out= $purdet['check_out'];
			    } 
                
            $designation =	$this->Common_model->select_single_field('designation_name','tbl_designation',array('id'=>$purdet['designation']));
			$plant       =	$this->Common_model->select_single_field('fld_location','tbl_locations',array('fld_id'=>$purdet['plants']));
			$name        =	$this->Common_model->select_single_field('full_name','tbl_employees',array('id'=>$purdet['user_id']));
            $dataValus=array($i,date('d-m-Y',strtotime($purdet['attendance_date'])), $name,$plant,$designation,$check_in,$check_out,$purdet['attendance_status']);
            fputcsv($output,$dataValus);
            $i++;
            }
        }
            
        fclose($output);
		
	}
	public function print_attendance_report(){
	    $_POST= $_GET;
	    $data['attendence']=$attendence=$this->Employees_model->attendence_filter();
		$data['filter_type']=$this->input->post('filter_type');
		$this->load->view('print_attendence_report', $data);
		
	}
	public function pdf_attendence_report(){
	    $_POST= $_GET;
	    $filter=$this->input->get('filter');
	    
		include_once APPPATH.'/third_party/autoload.php';
		//$this->load->view('print_purchase_report');
		$mpdf = new \Mpdf\Mpdf();
		$data['attendence']=$attendence=$this->Employees_model->attendence_filter();
		
		$data['filter_type']=1;
		$data['get']=$_GET;
		$html = $this->load->view('attendence_report_pdf',$data,true);
// 		echo '<pre>';
// 		print_r($html);
// 		exit;
		$mpdf->WriteHTML($html);
		$mpdf->Output('Attendence Report_'.$_GET['filter'].'.pdf','D');
		//$mpdf->Output();
	}
	
	public function filterAttendence($reset){
	   
	  if($reset == 1){
	      $_POST['plants'] = '';
	      $_POST['designation'] = '';
	      $_POST['status'] = '';
	  }elseif($reset == 2){
	      $_POST['designation'] = '';
	      $_POST['status'] = '';
	  }elseif($reset == 3){
	      $_POST['status'] = '';
	  }
	  
	   $whereData = array();
	   if(!empty($_POST['date'])){
	       //$whereData['attendance_date'] = date('Y-m-d', strtotime($_POST['date']));
	       $whereData['attendance_date'] = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['date'])));
	   }
	   if(!empty($_POST['fld_emp_id'])){
	       $whereData['user_id'] = $_POST['fld_emp_id'];
	   }
	   if(!empty($_POST['plants'])){
	       $whereData['plants'] = $_POST['plants'];
	   }
	   if(!empty($_POST['designation'])){
	       $whereData['designation'] = $_POST['designation'];
	   }
	   if(!empty($_POST['status'])){
	       $whereData['attendance_status'] = $_POST['status'];
	   }
	   $data = array();
	   $filteredAttendence = $this->Base_model->getAll('tbl_attendance', '*', $whereData);
	   
	        $des_sel = '<option value="">--Select Designation--</option>';
	        $plant_sel = '<option value="">--Select Plant--</option>';
	        $status_sel = '<option value="">--Select Status--</option>';
	        $des_values=array();
	        $plant_values=array();
	        $status_values=array();
	    if($filteredAttendence){
	        $table = '';
	        
            foreach($filteredAttendence as $emp){ 
            $designation = 	$this->Common_model->select_single_field('designation_name','tbl_designation',array('id'=>$emp['designation']));       
            //$department  =	$this->Common_model->select_single_field('department_name','tbl_departments',array('id'=>$emp['department']));
			$plant       =	$this->Common_model->select_single_field('fld_location','tbl_locations',array('fld_id'=>$emp['plants']));
			$name        =	$this->Common_model->select_single_field('full_name','tbl_employees',array('id'=>$emp['user_id']));
			array_push($des_values,$emp['designation']);
			array_push($plant_values,$emp['plants']);
			array_push($status_values,$emp['attendance_status']);
			
             $table .= '<tr>
                            <td>'.date("d-M-Y",strtotime($emp['attendance_date'])).'</td>
                            <td>'.$name.'</td>
							<td>'.$plant.'</td>
                            <td>'.$designation.'</td>
							<td data-name="check_in" class="check_in" data-type="text" data-pk="'.$emp['attendance_id'].'"> 
							  '.$emp['check_in'].'
							</td>
							<td data-name="check_out" class="check_out" data-type="text" data-pk="'.$emp['attendance_id'].'">
							  '.$emp['check_out'].'
							</td>
                            <td data-name="attendance_status" class="attendance_status" data-type="select" data-pk="'.$emp['attendance_id'].'">
							  '.$emp['attendance_status'].'
							</td>
                        </tr>';
	        }
	  
	    }else {
	    
	$table = '
<tr>
    <td colspan="9"><br><p style="color:#900;" >Sorry No Record Found!</p></td>
    <td style="display: none;"></td>
    <td style="display: none;"></td>
    <td style="display: none;"></td>
    <td style="display: none;"></td>
    <td style="display: none;"></td>
    <td style="display: none;"></td>
</tr>';
 } 
 $des_values = array_unique($des_values);
 $plant_values = array_unique($plant_values);
 $status_values = array_unique($status_values);
 
 
 if(count($des_values)>0){
     $getDesignations = $this->db->query("SELECT * FROM tbl_designation WHERE id IN  (".implode(',',$des_values).")")->result();
     foreach($getDesignations as $des){
         if($_POST['designation'] == $des->id){
             $des_sel .= '<option value="'.$des->id.'" selected>'.$des->designation_name.'</option>';
         }else{
             $des_sel .= '<option value="'.$des->id.'">'.$des->designation_name.'</option>';
         }
     }
 }
 if(count($plant_values)>0){
     $getPlants = $this->db->query("SELECT * FROM tbl_locations WHERE fld_id IN  (".implode(',',$plant_values).")")->result();
     foreach($getPlants as $plant){
         if($_POST['plants'] == $plant->fld_id){
             $plant_sel .= '<option value="'.$plant->fld_id.'" selected>'.$plant->fld_location.'</option>';
         }else{
             $plant_sel .= '<option value="'.$plant->fld_id.'">'.$plant->fld_location.'</option>';
         }
     }
 }
 
 foreach($status_values as $status){
     if($_POST['status'] == $status){
         $status_sel .= '<option value="'.$status.'" selected>'.$status.'</option>';
     }else{
         $status_sel .= '<option value="'.$status.'">'.$status.'</option>';
     }
 }
     $data['table'] = $table;
     $data['des_sel'] = $des_sel;
     $data['plant_sel'] = $plant_sel;
     $data['status_sel'] = $status_sel;
     echo json_encode($data, true);
}
	
	public function update_attendance1(){
	   // print_r($_POST);
	   // exit();
	 $data = array(
	    $_POST["name"] => $_POST['value'] ,
	);
	    $this->db->update('tbl_attendance', $data, array('attendance_id' => $_POST['pk']));
	}
	
	
	public function getFilterEmployee(){
	   // print_r($_POST);
	   // exit();
	    $whereData = array();
	   if(!empty($_POST['search_by_id'])){
	       $whereData['employee_code'] = $_POST['search_by_id'];
	   }
	   if(!empty($_POST['fld_emp_name'])){
	       $whereData['full_name'] = $_POST['fld_emp_name'];
	   }
	   if(!empty($_POST['plants'])){
	       $whereData['plants'] = $_POST['plants'];
	   }
	   if(!empty($_POST['designation'])){
	       $whereData['designation'] = $_POST['designation'];
	   }
	   if(!empty($_POST['department'])){
	       $whereData['department'] = $_POST['department'];
	   }
	   
	   $data = array();
	   $filteredEmployee = $this->Base_model->getAll('tbl_employees', '*', $whereData);
	   
	   if($filteredEmployee){
	        $table = '';
	        
            foreach($filteredEmployee as $emp){
                
            $designation = 	$this->Common_model->select_single_field('designation_name','tbl_designation',array('id'=>$emp['designation']));       
            $department  =	$this->Common_model->select_single_field('department_name','tbl_departments',array('id'=>$emp['department']));
			$plant       =	$this->Common_model->select_single_field('fld_location','tbl_locations',array('fld_id'=>$emp['plants']));
	
            $table .= '<tr>
                            <td>'.$emp['employee_code'].'</td>
                            <td>'.$emp['full_name'].'</td>
							<td>'.$plant.'</td>
                            <td>'.$designation.'</td>
                            <td>'.$department.'</td>
                            <td>
                            <a href="'.base_url('Employees/edit/'.$emp['id'].'').'">
                            <i style="font-size:20px;cursor:pointer;" class="mdi mdi-square-edit-outline" title="Edit"></i></a>
                            <a href="'.base_url('Employees/viewEmployee/'.$emp['id'].'').'"><i style="font-size:20px;cursor:pointer;" class="mdi mdi-eye-circle-outline" title="View"></i></a>
                            <a href="'.base_url('Employees/delete/'.$emp['id'].'').'" onclick="return confirm(\'Are you sure you want to delete this record.\')">
                            <i style="font-size:20px;cursor:pointer;" class="mdi mdi-delete-forever" title="Delete"></i>
                            </a>
                        </tr>';
                	}
	        
        	    }else {
        	    
        	$table = '
        <tr>
            <td colspan="9"><br><p style="color:#900;" >Sorry No Record Found!</p></td>
            <td style="display: none;"></td>
            <td style="display: none;"></td>
            <td style="display: none;"></td>
            <td style="display: none;"></td>
            <td style="display: none;"></td>
        </tr>';
         }
         
         echo $table;
	}
	
	public function employee_report(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$this->title = "Employees Report";
			$data['view_scripts']=array(
			    $this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
// 		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		
		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
		$this->Gen->get_script_url('custom_js','hrm.js'),
// 		$this->Gen->get_script_url('custom_js','jquery.validate.js'),
		);
		$data['view_css']=array(
// 		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
		$this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
		);
		$data['employees']=$this->Base_model->getAll('tbl_employees');
		$data['employees_names']=$this->db->query("SELECT * FROM tbl_employees GROUP by full_name  Order by full_name asc ")->result_array();
		$this->load_template('','employee_report',$data);
	}
	public function filter(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$data['employees']=$employees=$this->Employees_model->employee_filter();
		$data['filter_type']=$this->input->post('filter_type');
		$count=count($employees);
		$html=$this->load->view('employee_filter',$data,true);
		echo json_encode(array("html"=>$html,'count'=>$count));
	}
	public function employee_report_csv(){
	    $_POST=$_GET;
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$data['employees']=$employees=$this->Employees_model->employee_filter();
		$data['filter_type']=$this->input->post('filter_type');
		include_once APPPATH.'/third_party/autoload.php';
        $header_row = array("#", "Employee ID", "Name", "Role" , "Cnic No", "Contact No", "Joining Date");
        $csvName = 'employeereport'.'.csv';
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="'.$csvName.'";');
        $output = fopen('php://output', 'w');
        
        fputcsv($output,$header_row);
        $i=1;
        foreach($employees as $emp){ 
            foreach($emp['detail'] as $empdet){
            
            $dataValus=array($i,$empdet['employee_code'], $empdet['full_name'],$empdet['designation_name'].' at '.$empdet['fld_location'].' in '. $empdet['department_name'],$empdet['cnic'],$empdet['mobile_no'],date('d/m/Y', strtotime($empdet['joining_date'])));
            fputcsv($output,$dataValus);
            $i++;
            }
        }
            
        fclose($output);
	
	}
	public function print_report(){
		$this->load->view('print_employee_report');
	}
	
	public function print_employee_report(){
	    $filter=$this->input->get('filter');
	    $_POST = $_GET;
		include_once APPPATH.'/third_party/autoload.php';
		$mpdf = new \Mpdf\Mpdf();
		$data['employees']=$employees=$this->Employees_model->employee_filter_pdf();
		$data['filter_type']=1;
		$data['get']=$_GET;
		$html = $this->load->view('employee_report_pdf',$data,true);
		$mpdf->WriteHTML($html);
		$mpdf->Output('Employee Report.pdf','D');
	}
}
