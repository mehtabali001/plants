<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vouchers extends My_controller {
	
	function __construct() {
        parent::__construct();
        $this->CI = & get_instance(); 
        $CI =& get_instance();
        $this->load->model('Common_model');
        $this->load->model('Accounts_model');
    }
    
 // Start Journal Voucher Part    
	
   public function journalvoucher($type = '', $id = 0)  
    {
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(194,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		
        $this->title = "Journal Voucher";
        
        
        if($type == 'delete'){
            $voucher = $this->db->select('*')->from('tbl_transections_master')->where(array('id'=>$id, 'type'=>'JV'))->get();
            
            if($voucher->num_rows() < 1){
                redirect(base_url() . 'Vouchers/manage_voucher');
                exit();
            }
            $this->db->delete('tbl_transections_master', array('id' => $id));
            $this->db->delete('tbl_transections_details', array('v_id' => $id));
            
            $this->session->set_userdata(array('error_message' => "Journal voucher deleted successfully"));
            redirect(base_url() . 'Vouchers/manage_voucher');
            exit;
        }
        
        
         if (isset($_POST['add-vourcher'])) {
            $data = array(
                'type'          => $this->input->post('fld_type'),
                'date'          => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('date',TRUE)))),
                'user_id'       => $this->session->userdata('user_id'),
                'created_date'  => date('Y-m-d H:i:s')
            );
            
            $this->db->insert('tbl_transections_master', $data);
            
		    $v_id = $this->db->insert_id();
		    $account_id = $this->input->post('account_id',TRUE);
		    $coa_id     =  $this->input->post('coa_id',TRUE);
    		$narration = $this->input->post('narration',TRUE);
    		$debit = $this->input->post('debit',TRUE);
    		$credit = $this->input->post('credit',TRUE);
    		
    		for ($i = 0, $n = count($coa_id); $i < $n; $i++) {
    		  $data1=array(
    		      'v_id'        => $v_id,
    		      'coa_id'      => $coa_id[$i],
    		      'narration'   => $narration[$i],
    		      'debit'       => $debit[$i],
    		      'credit'      => $credit[$i]
    		  );
    		  if($debit[$i] > 0 || $credit[$i]>0){
    		       $this->db->insert('tbl_transections_details', $data1);
    		  }
    		 
            
    		}
    		
            /****************** Activity Log *****************************/
        		$user_role=$this->session->userdata('user_role');
        		$user_role_name=$this->session->userdata('user_role_name');
        		$user_id=$this->session->userdata('user_id');
        		$voucher_no=$this->input->post('fld_voucher_no',TRUE);
        		$client_ip=$this->Gen->get_client_ip();
        		$address=$this->Base_model->getLocation($client_ip);
                $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
                $date=date('Y-m-d H:i:s');
        		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'ADD',fld_detail='$voucher_no',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
            $this->session->set_userdata(array('success_message' => "Journal voucher added successfully"));
            redirect(base_url() . 'Vouchers/journalvoucher');
            exit;
        }
        
         if (isset($_POST['edit-vourcher'])) {
            $v_id = $this->input->post('editId');
             
            $data = array(
                'type'          => $this->input->post('fld_type'),
                'date'          => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('date',TRUE)))),
                'user_id'       => $this->session->userdata('user_id'),
                'created_date'  => date('Y-m-d H:i:s')
            );
            
            
            
            $this->db->where('id', $v_id);
            $this->db->update('tbl_transections_master', $data);
            
            $this->db->delete('tbl_transections_details', array('v_id' => $v_id));
            
		  //  $v_id = $this->db->insert_id();
		    $account_id = $this->input->post('account_id',TRUE);
		    $coa_id     =  $this->input->post('coa_id',TRUE);
    		$narration = $this->input->post('narration',TRUE);
    		$debit = $this->input->post('debit',TRUE);
    		$credit = $this->input->post('credit',TRUE);
    		
    		for ($i = 0, $n = count($coa_id); $i < $n; $i++) {
    		  $data1=array(
    		      'v_id'        => $v_id,
    		      'coa_id'      => $coa_id[$i],
    		      'narration'   => $narration[$i],
    		      'debit'       => $debit[$i],
    		      'credit'      => $credit[$i]
    		  );
    		  if($debit[$i] > 0 || $credit[$i]>0){
    		       $this->db->insert('tbl_transections_details', $data1);
    		  }
    		 
            
    		}
    		/****************** Activity Log *****************************/
        		$user_role=$this->session->userdata('user_role');
        		$user_role_name=$this->session->userdata('user_role_name');
        		$user_id=$this->session->userdata('user_id');
        		$voucher_no=$this->input->post('fld_voucher_no',TRUE);
        		$client_ip=$this->Gen->get_client_ip();
        		$address=$this->Base_model->getLocation($client_ip);
                $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
                $date=date('Y-m-d H:i:s');
        		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'UPDATE',fld_detail='$voucher_no',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
            
            $this->session->set_userdata(array('success_message' => "Journal voucher edited successfully"));
            redirect(base_url() . 'Vouchers/manage_voucher');
            exit;
        }
        
		$data['view_scripts']=array(
    		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
    		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
    		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
    		$this->Gen->get_script_url('custom_js','jquery.validate.js'),
    		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		    $this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		    $this->Gen->get_script_url('custom_js','vouchers.js'),
		);
		
		$data['view_css']=array(
            $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
            $this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
	    );

	    $getMaxVoucherID=$this->Accounts_model->getMaxVoucherID();
		$data['maxid']= $getMaxVoucherID['Auto_increment'];
		
		$data['accounts'] = $this->db->select('*')->from('tbl_coa')->where('head_level', '3')->get()->result_array();
		
		if($type == 'edit'){
            $voucher = $this->db->select('*')->from('tbl_transections_master')->where(array('id'=>$id, 'type'=>'JV'))->get();
            
            if($voucher->num_rows() < 1){
                redirect(base_url() . 'Vouchers/manage_voucher');
                exit();
            }
            $data['edit'] = $id; 
            $data['maxid'] = $id;
            $data['editData'] = $voucher->row_array();
            $data['editDataDetails']  = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id))->get()->result_array();
            
        }
        if($type == 'duplicate'){
            $voucher = $this->db->select('*')->from('tbl_transections_master')->where(array('id'=>$id, 'type'=>'JV'))->get();
            
            if($voucher->num_rows() < 1){
                redirect(base_url() . 'Vouchers/manage_voucher');
                exit();
            }
            $data['edit'] = "";
            $data['duplicate'] = "";
            $data['maxid'] = $getMaxVoucherID['Auto_increment'];
            $data['editData'] = $voucher->row_array();
            $data['editDataDetails']  = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id))->get()->result_array();
            
        }
		$data['journal_voucher']  = $this->db->select('*')->from('tbl_transections_master')->where(array('type'=>'JV'))->get()->result_array();
        $this->load_template('','accounts/journal_voucher',$data);
    }
 
 // Start Cash Payment Voucher

    public function cashpayementvoucher($type = '', $id = 0)
    {
       
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(193,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		
        $this->title = "Cash Payment Voucher";
        
        if($type == 'delete'){
            $voucher = $this->db->select('*')->from('tbl_transections_master')->where(array('id'=>$id, 'type'=>'CPV'))->get();
            
            if($voucher->num_rows() < 1){
                redirect(base_url() . 'Vouchers/manage_voucher');
                exit();
            }
            $this->db->delete('tbl_transections_master', array('id' => $id));
            $this->db->delete('tbl_transections_details', array('v_id' => $id));
            
            $this->session->set_userdata(array('error_message' => "Cash Payment Voucher deleted successfully"));
            redirect(base_url() . 'Vouchers/manage_voucher');
            exit;
        }
        
        if (isset($_POST['add-vourcher'])) {
            $data = array(
                'type'          => $this->input->post('fld_type'),
                'date'          => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('date',TRUE)))),
                'user_id'       => $this->session->userdata('user_id'),
                'created_date'  => date('Y-m-d H:i:s')
            );
            
            $this->db->insert('tbl_transections_master', $data);
		    $v_id = $this->db->insert_id();
		    $account_id = $this->input->post('account_id',TRUE);
		    $coa_id     =  $this->input->post('coa_id',TRUE);
    		$narration = $this->input->post('narration',TRUE);
    		$amount = $this->input->post('amount',TRUE);
    		$fromNarration = 'Dr Acc. ';
    		$coa_fname = $this->db->select('head_name')->from('tbl_coa')->where('head_code', $this->input->post('from_account'))->get()->row()->head_name;
    		for ($i = 0, $n = count($coa_id); $i < $n; $i++) {
    		  $coa_name = $this->db->select('head_name')->from('tbl_coa')->where('head_code', $coa_id[$i])->get()->row()->head_name;
    		  $fromNarration .= $coa_name.', ';
    		  $data1=array(
    		      'v_id'        => $v_id,
    		      'coa_id'      => $coa_id[$i],
    		      'narration'   => 'Cr Acc. '.$coa_fname.' ('.$narration[$i].')',
    		      'debit'       => $amount[$i]
    		  );
    		  $this->db->insert('tbl_transections_details', $data1);
            
    		}
    		$fromNarration = rtrim($fromNarration, ', ');
    		
    		$fromData = array(
    		    'v_id'        => $v_id,
    		    'coa_id'      => $this->input->post('from_account'),
    		    'narration'   => $fromNarration.' ('.$this->input->post('from_narration').')',
    		    'credit'      => $this->input->post('total_amount')
    		);
    		$this->db->insert('tbl_transections_details', $fromData);
            /****************** Activity Log *****************************/
        		$user_role=$this->session->userdata('user_role');
        		$user_role_name=$this->session->userdata('user_role_name');
        		$user_id=$this->session->userdata('user_id');
        		$voucher_no=$this->input->post('fld_voucher_no',TRUE);
        		$client_ip=$this->Gen->get_client_ip();
        		$address=$this->Base_model->getLocation($client_ip);
                $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
                $date=date('Y-m-d H:i:s');
        		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'ADD',fld_detail='$voucher_no',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
            $this->session->set_userdata(array('success_message' => "Cash Payment added successfully"));
            redirect(base_url() . 'Vouchers/cashpayementvoucher');
            exit;
        }
        
        if (isset($_POST['edit-vourcher'])) {
            $v_id = $this->input->post('editId');
             
            $data = array(
                'type'          => $this->input->post('fld_type'),
                'date'          => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('date',TRUE)))),
                'user_id'       => $this->session->userdata('user_id'),
                'created_date'  => date('Y-m-d H:i:s')
            );
            
            
            
            $this->db->where('id', $v_id);
            $this->db->update('tbl_transections_master', $data);
            
            $this->db->delete('tbl_transections_details', array('v_id' => $v_id));
            
		    $account_id = $this->input->post('account_id',TRUE);
		    $coa_id     =  $this->input->post('coa_id',TRUE);
    		$narration = $this->input->post('narration',TRUE);
    		$amount = $this->input->post('amount',TRUE);
    		$fromNarration = 'Dr Acc. ';
    		$coa_fname = $this->db->select('head_name')->from('tbl_coa')->where('head_code', $this->input->post('from_account'))->get()->row()->head_name;
    		for ($i = 0, $n = count($coa_id); $i < $n; $i++) {
    		  $coa_name = $this->db->select('head_name')->from('tbl_coa')->where('head_code', $coa_id[$i])->get()->row()->head_name;
    		  $fromNarration .= $coa_name.', ';
    		  $data1=array(
    		      'v_id'        => $v_id,
    		      'coa_id'      => $coa_id[$i],
    		      'narration'   => 'Cr Acc. '.$coa_fname.' ('.$narration[$i].')',
    		      'debit'       => $amount[$i]
    		  );
    		  $this->db->insert('tbl_transections_details', $data1);
            
    		}
    		$fromNarration = rtrim($fromNarration, ', ');
    		
    		$fromData = array(
    		    'v_id'        => $v_id,
    		    'coa_id'      => $this->input->post('from_account'),
    		    'narration'   => $fromNarration.' ('.$this->input->post('from_narration').')',
    		    'credit'      => $this->input->post('total_amount')
    		);
    		$this->db->insert('tbl_transections_details', $fromData);
    		
            /****************** Activity Log *****************************/
        		$user_role=$this->session->userdata('user_role');
        		$user_role_name=$this->session->userdata('user_role_name');
        		$user_id=$this->session->userdata('user_id');
        		$voucher_no=$this->input->post('fld_voucher_no',TRUE);
        		$client_ip=$this->Gen->get_client_ip();
        		$address=$this->Base_model->getLocation($client_ip);
                $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
                $date=date('Y-m-d H:i:s');
        		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'UPDATE',fld_detail='$voucher_no',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
                $this->session->set_userdata(array('success_message' => "Cash Payment Voucher edited successfully"));
                redirect(base_url() . 'Vouchers/manage_voucher');
                exit;
        }
        
        
        
		$data['view_scripts']=array(
    		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
    		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
    		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
    		$this->Gen->get_script_url('custom_js','jquery.validate.js'),
    		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		    $this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		    $this->Gen->get_script_url('custom_js','vouchers.js'),
		  //  $this->Gen->get_script_url('plugin_components','clipboard/clipboard.min.js'),
		  //  $this->Gen->get_script_url('bower_components','jquery.clipboard.init.js'),
		);
		
		$data['view_css']=array(
            $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
            $this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
	    );
	    
	    $getMaxVoucherID=$this->Accounts_model->getMaxVoucherID();
		$data['maxid']= $getMaxVoucherID['Auto_increment'];
		
		$data['from_accounts'] = $this->db->select('*')->from('tbl_coa')->where('head_code!=', '101001')->like('head_code', '101001', 'both')->get()->result_array();
		$data['to_accounts'] = $this->db->select('*')->from('tbl_coa')->where('head_level', '3')->not_like('head_code', '101001', 'both')->get()->result_array();
	
	    if($type == 'edit'){
            $voucher = $this->db->select('*')->from('tbl_transections_master')->where(array('id'=>$id, 'type'=>'CPV'))->get();
            
            if($voucher->num_rows() < 1){
                redirect(base_url() . 'Vouchers/manage_voucher');
                exit();
            }
            $data['edit'] = $id; 
            $data['maxid'] = $id;
            $data['editData'] = $voucher->row_array();
            $data['editDataV'] = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id, 'credit>'=>0))->get()->row_array();
            $data['editDataDetails']  = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id, 'debit>'=>0))->get()->result_array();
            
        }
         if($type == 'duplicate'){
            $voucher = $this->db->select('*')->from('tbl_transections_master')->where(array('id'=>$id, 'type'=>'CPV'))->get();
            
            if($voucher->num_rows() < 1){
                redirect(base_url() . 'Vouchers/manage_voucher');
                exit();
            }
            $data['edit'] = "";
            $data['duplicate'] = "";
            $data['maxid'] = $getMaxVoucherID['Auto_increment'];
            $data['editData'] = $voucher->row_array();
            $data['editDataV'] = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id, 'credit>'=>0))->get()->row_array();
            $data['editDataDetails']  = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id, 'debit>'=>0))->get()->result_array();
            
        }
	    
	     $data['cpv_voucher']  = $this->db->select('*')->from('tbl_transections_master')->where(array('type'=>'CPV'))->get()->result_array();
	   
        $this->load_template('','accounts/cashpayment_voucher',$data);
    }
    
    
    public function cashreceivevoucher($type = '', $id = 0)
    {
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(195,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		
        $this->title = "Cash Receive Voucher";
        
        if($type == 'delete'){
            $voucher = $this->db->select('*')->from('tbl_transections_master')->where(array('id'=>$id, 'type'=>'CRV'))->get();
            
            if($voucher->num_rows() < 1){
                redirect(base_url() . 'Vouchers/manage_voucher');
                exit();
            }
            $this->db->delete('tbl_transections_master', array('id' => $id));
            $this->db->delete('tbl_transections_details', array('v_id' => $id));
            
            $this->session->set_userdata(array('error_message' => "Cash Receive Voucher deleted successfully"));
            redirect(base_url() . 'Vouchers/manage_voucher');
            exit;
        }
        
        if (isset($_POST['add-vourcher'])) {
            $data = array(
                'type'          => $this->input->post('fld_type'),
                'date'          => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('date',TRUE)))),
                'user_id'       => $this->session->userdata('user_id'),
                'created_date'  => date('Y-m-d H:i:s')
            );
            
            $this->db->insert('tbl_transections_master', $data);
		    $v_id = $this->db->insert_id();
		    $account_id = $this->input->post('account_id',TRUE);
		    $coa_id     =  $this->input->post('coa_id',TRUE);
    		$narration = $this->input->post('narration',TRUE);
    		$amount = $this->input->post('amount',TRUE);
    		
    		$fromNarration = 'Cr Acc. ';
    		$coa_fname = $this->db->select('head_name')->from('tbl_coa')->where('head_code', $this->input->post('from_account'))->get()->row()->head_name;
    		for ($i = 0, $n = count($coa_id); $i < $n; $i++) {
    		  $coa_name = $this->db->select('head_name')->from('tbl_coa')->where('head_code', $coa_id[$i])->get()->row()->head_name;
    		  $fromNarration .= $coa_name.', ';
    		  $data1=array(
    		      'v_id'        => $v_id,
    		      'coa_id'      => $coa_id[$i],
    		      'narration'   => 'Dr Acc. '.$coa_fname.' ('.$narration[$i].')',
    		      'credit'       => $amount[$i]
    		  );
    		  $this->db->insert('tbl_transections_details', $data1);
            
    		}
    		$fromNarration = rtrim($fromNarration, ', ');
    		
    		$fromData = array(
    		    'v_id'        => $v_id,
    		    'coa_id'      => $this->input->post('from_account'),
    		    'narration'   => $fromNarration.' ('.$this->input->post('from_narration').')',
    		    'debit'      => $this->input->post('total_amount')
    		);
    		
    		$this->db->insert('tbl_transections_details', $fromData);
            /****************** Activity Log *****************************/
        		$user_role=$this->session->userdata('user_role');
        		$user_role_name=$this->session->userdata('user_role_name');
        		$user_id=$this->session->userdata('user_id');
        		$voucher_no=$this->input->post('fld_voucher_no',TRUE);
        		$client_ip=$this->Gen->get_client_ip();
        		$address=$this->Base_model->getLocation($client_ip);
                $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
                $date=date('Y-m-d H:i:s');
        		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'ADD',fld_detail='$voucher_no',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
            $this->session->set_userdata(array('success_message' => "Cash Receive added successfully"));
            redirect(base_url() . 'Vouchers/cashreceivevoucher');
            exit;
        }
        
        if (isset($_POST['edit-vourcher'])) {
            $v_id = $this->input->post('editId');
             
            $data = array(
                'type'          => $this->input->post('fld_type'),
                'date'          => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('date',TRUE)))),
                'user_id'       => $this->session->userdata('user_id'),
                'created_date'  => date('Y-m-d H:i:s')
            );
            
            
            
            $this->db->where('id', $v_id);
            $this->db->update('tbl_transections_master', $data);
            
            $this->db->delete('tbl_transections_details', array('v_id' => $v_id));
            
		    $account_id = $this->input->post('account_id',TRUE);
		    $coa_id     =  $this->input->post('coa_id',TRUE);
    		$narration = $this->input->post('narration',TRUE);
    		$amount = $this->input->post('amount',TRUE);
    	    $fromNarration = 'Cr Acc. ';
    		$coa_fname = $this->db->select('head_name')->from('tbl_coa')->where('head_code', $this->input->post('from_account'))->get()->row()->head_name;
    		for ($i = 0, $n = count($coa_id); $i < $n; $i++) {
    		  $coa_name = $this->db->select('head_name')->from('tbl_coa')->where('head_code', $coa_id[$i])->get()->row()->head_name;
    		  $fromNarration .= $coa_name.', ';
    		  $data1=array(
    		      'v_id'        => $v_id,
    		      'coa_id'      => $coa_id[$i],
    		      'narration'   => 'Dr Acc. '.$coa_fname.' ('.$narration[$i].')',
    		      'credit'       => $amount[$i]
    		  );
    		  $this->db->insert('tbl_transections_details', $data1);
            
    		}
    		
    		$fromNarration = rtrim($fromNarration, ', ');
    		
    		$fromData = array(
    		    'v_id'        => $v_id,
    		    'coa_id'      => $this->input->post('from_account'),
    		    'narration'   => $fromNarration.' ('.$this->input->post('from_narration').')',
    		    'debit'      => $this->input->post('total_amount')
    		);
    		$this->db->insert('tbl_transections_details', $fromData);
    		/****************** Activity Log *****************************/
        		$user_role=$this->session->userdata('user_role');
        		$user_role_name=$this->session->userdata('user_role_name');
        		$user_id=$this->session->userdata('user_id');
        		$voucher_no=$this->input->post('fld_voucher_no',TRUE);
        		$client_ip=$this->Gen->get_client_ip();
        		$address=$this->Base_model->getLocation($client_ip);
                $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
                $date=date('Y-m-d H:i:s');
        		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'UPDATE',fld_detail='$voucher_no',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
            
            $this->session->set_userdata(array('success_message' => "Cash Receive Voucher edited successfully"));
            redirect(base_url() . 'Vouchers/manage_voucher');
            exit;
        }
        
        
        
        
		$data['view_scripts']=array(
    		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
    		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
    		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
    		$this->Gen->get_script_url('custom_js','jquery.validate.js'),
    		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		    $this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		    $this->Gen->get_script_url('custom_js','vouchers.js'),
		);
		
		$data['view_css']=array(
            $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
            $this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
	    );
	    
	    $getMaxVoucherID=$this->Accounts_model->getMaxVoucherID();
		$data['maxid']= $getMaxVoucherID['Auto_increment'];
		
		$data['from_accounts'] = $this->db->select('*')->from('tbl_coa')->where('head_code!=', '101001')->like('head_code', '101001', 'both')->get()->result_array();
		$data['to_accounts'] = $this->db->select('*')->from('tbl_coa')->where('head_level', '3')->not_like('head_code', '101001', 'both')->get()->result_array();
	
	
	    if($type == 'edit'){
            $voucher = $this->db->select('*')->from('tbl_transections_master')->where(array('id'=>$id, 'type'=>'CRV'))->get();
            
            if($voucher->num_rows() < 1){
                redirect(base_url() . 'Vouchers/manage_voucher');
                exit();
            }
            $data['edit'] = $id; 
            $data['maxid'] = $id;
            $data['editData'] = $voucher->row_array();
            $data['editDataV'] = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id, 'debit>'=>0))->get()->row_array();
            $data['editDataDetails']  = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id, 'credit>'=>0))->get()->result_array();
            
        }
        if($type == 'duplicate'){
            $voucher = $this->db->select('*')->from('tbl_transections_master')->where(array('id'=>$id, 'type'=>'CRV'))->get();
            
            if($voucher->num_rows() < 1){
                redirect(base_url() . 'Vouchers/manage_voucher');
                exit();
            }
            $data['edit'] = "";
            $data['duplicate'] = "";
            $data['maxid'] = $getMaxVoucherID['Auto_increment'];
            $data['editData'] = $voucher->row_array();
            $data['editDataV'] = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id, 'debit>'=>0))->get()->row_array();
            $data['editDataDetails']  = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id, 'credit>'=>0))->get()->result_array();
            
        }
	    
	   // echo '<pre>';
	   // print_r($data);
	   //exit;
	   $data['crv_voucher']  = $this->db->select('*')->from('tbl_transections_master')->where(array('type'=>'CRV'))->get()->result_array();
        $this->load_template('','accounts/cashreceive_voucher',$data);
    }
    
    public function chequepayementvoucher($type = '', $id = 0)
    {
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(196,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		
        $this->title = "Cheque Payment Voucher";
        
        
        if($type == 'delete'){
            $voucher = $this->db->select('*')->from('tbl_transections_master')->where(array('id'=>$id, 'type'=>'CHPV'))->get();
            
            if($voucher->num_rows() < 1){
                redirect(base_url() . 'Vouchers/manage_voucher');
                exit();
            }
            $this->db->delete('tbl_transections_master', array('id' => $id));
            $this->db->delete('tbl_transections_details', array('v_id' => $id));
            
            $this->session->set_userdata(array('error_message' => "Cheque Payment Voucher deleted successfully"));
            redirect(base_url() . 'Vouchers/manage_voucher');
            exit;
        }
        
        if (isset($_POST['add-vourcher'])) {
            $data = array(
                'type'          => $this->input->post('fld_type'),
                'date'          => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('date',TRUE)))),
                'user_id'       => $this->session->userdata('user_id'),
                'created_date'  => date('Y-m-d H:i:s')
            );
            
            $this->db->insert('tbl_transections_master', $data);
		    $v_id = $this->db->insert_id();
		    $account_id = $this->input->post('account_id',TRUE);
		    $coa_id     =  $this->input->post('coa_id',TRUE);
    		$narration = $this->input->post('narration',TRUE);
    		$amount = $this->input->post('amount',TRUE);
    		$fromNarration = 'Dr Acc. ';
    		$coa_fname = $this->db->select('head_name')->from('tbl_coa')->where('head_code', $this->input->post('from_account'))->get()->row()->head_name;
    		for ($i = 0, $n = count($coa_id); $i < $n; $i++) {
    		  $coa_name = $this->db->select('head_name')->from('tbl_coa')->where('head_code', $coa_id[$i])->get()->row()->head_name;
    		  $fromNarration .= $coa_name.', ';
    		  $data1=array(
    		      'v_id'        => $v_id,
    		      'coa_id'      => $coa_id[$i],
    		      'narration'   => 'Cr Acc. '.$coa_fname.' ('.$narration[$i].')',
    		      'debit'       => $amount[$i]
    		  );
    		  $this->db->insert('tbl_transections_details', $data1);
            
    		}
    		
    		$fromNarration = rtrim($fromNarration, ', ');
    		
    		$fromData = array(
    		    'v_id'        => $v_id,
    		    'coa_id'      => $this->input->post('from_account'),
    		    'narration'   => $fromNarration.' ('.$this->input->post('from_narration').')',
    		    'credit'      => $this->input->post('total_amount')
    		);
    		
    		$this->db->insert('tbl_transections_details', $fromData);
            /****************** Activity Log *****************************/
        		$user_role=$this->session->userdata('user_role');
        		$user_role_name=$this->session->userdata('user_role_name');
        		$user_id=$this->session->userdata('user_id');
        		$voucher_no=$this->input->post('fld_voucher_no',TRUE);
        		$client_ip=$this->Gen->get_client_ip();
        		$address=$this->Base_model->getLocation($client_ip);
                $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
                $date=date('Y-m-d H:i:s');
        		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'ADD',fld_detail='$voucher_no',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
            $this->session->set_userdata(array('success_message' => "Cheque Payment added successfully"));
            redirect(base_url() . 'Vouchers/chequepayementvoucher');
            exit;
        }
        
        if (isset($_POST['edit-vourcher'])) {
            $v_id = $this->input->post('editId');
             
            $data = array(
                'type'          => $this->input->post('fld_type'),
                'date'          => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('date',TRUE)))),
                'user_id'       => $this->session->userdata('user_id'),
                'created_date'  => date('Y-m-d H:i:s')
            );
            
            
            
            $this->db->where('id', $v_id);
            $this->db->update('tbl_transections_master', $data);
            
            $this->db->delete('tbl_transections_details', array('v_id' => $v_id));
            
		    $account_id = $this->input->post('account_id',TRUE);
		    $coa_id     =  $this->input->post('coa_id',TRUE);
    		$narration = $this->input->post('narration',TRUE);
    		$amount = $this->input->post('amount',TRUE);
    		
    		$fromNarration = 'Dr Acc. ';
    		$coa_fname = $this->db->select('head_name')->from('tbl_coa')->where('head_code', $this->input->post('from_account'))->get()->row()->head_name;
    		for ($i = 0, $n = count($coa_id); $i < $n; $i++) {
    		  $coa_name = $this->db->select('head_name')->from('tbl_coa')->where('head_code', $coa_id[$i])->get()->row()->head_name;
    		  $fromNarration .= $coa_name.', ';
    		  $data1=array(
    		      'v_id'        => $v_id,
    		      'coa_id'      => $coa_id[$i],
    		      'narration'   => 'Cr Acc. '.$coa_fname.' ('.$narration[$i].')',
    		      'debit'       => $amount[$i]
    		  );
    		  $this->db->insert('tbl_transections_details', $data1);
            
    		}
    		
    	    $fromNarration = rtrim($fromNarration, ', ');
    		
    		$fromData = array(
    		    'v_id'        => $v_id,
    		    'coa_id'      => $this->input->post('from_account'),
    		    'narration'   => $fromNarration.' ('.$this->input->post('from_narration').')',
    		    'credit'      => $this->input->post('total_amount')
    		);
    		$this->db->insert('tbl_transections_details', $fromData);
    		
            /****************** Activity Log *****************************/
        		$user_role=$this->session->userdata('user_role');
        		$user_role_name=$this->session->userdata('user_role_name');
        		$user_id=$this->session->userdata('user_id');
        		$voucher_no=$this->input->post('fld_voucher_no',TRUE);
        		$client_ip=$this->Gen->get_client_ip();
        		$address=$this->Base_model->getLocation($client_ip);
                $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
                $date=date('Y-m-d H:i:s');
        		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'UPDATE',fld_detail='$voucher_no',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
            $this->session->set_userdata(array('success_message' => "Cheque Payment Voucher edited successfully"));
            redirect(base_url() . 'Vouchers/manage_voucher');
            exit;
        }
        
        
        
        
		$data['view_scripts']=array(
    		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
    		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
    		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
    		$this->Gen->get_script_url('custom_js','jquery.validate.js'),
    		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		    $this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		    $this->Gen->get_script_url('custom_js','vouchers.js'),
		);
		
		$data['view_css']=array(
            $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
            $this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
	    );
	    
	    $getMaxVoucherID=$this->Accounts_model->getMaxVoucherID();
		$data['maxid']= $getMaxVoucherID['Auto_increment'];
		
		$data['from_accounts'] = $this->db->select('*')->from('tbl_coa')->where('head_code!=', '101014')->like('head_code', '101014', 'both')->get()->result_array();
		$data['to_accounts'] = $this->db->select('*')->from('tbl_coa')->where('head_level', '3')->not_like('head_code', '101014', 'both')->get()->result_array();
	
	    if($type == 'edit'){
            $voucher = $this->db->select('*')->from('tbl_transections_master')->where(array('id'=>$id, 'type'=>'CHPV'))->get();
            
            if($voucher->num_rows() < 1){
                redirect(base_url() . 'Vouchers/manage_voucher');
                exit();
            }
            $data['edit'] = $id; 
            $data['maxid'] = $id;
            $data['editData'] = $voucher->row_array();
            $data['editDataV'] = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id, 'credit>'=>0))->get()->row_array();
            $data['editDataDetails']  = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id, 'debit>'=>0))->get()->result_array();
            
        }
	    if($type == 'duplicate'){
            $voucher = $this->db->select('*')->from('tbl_transections_master')->where(array('id'=>$id, 'type'=>'CHPV'))->get();
            
            if($voucher->num_rows() < 1){
                redirect(base_url() . 'Vouchers/manage_voucher');
                exit();
            }
            $data['edit'] = "";
            $data['duplicate'] = "";
            $data['maxid'] = $getMaxVoucherID['Auto_increment'];
            $data['editData'] = $voucher->row_array();
            $data['editDataV'] = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id, 'credit>'=>0))->get()->row_array();
            $data['editDataDetails']  = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id, 'debit>'=>0))->get()->result_array();
            
        }
	    $data['chpv_voucher']  = $this->db->select('*')->from('tbl_transections_master')->where(array('type'=>'CHPV'))->get()->result_array();
	   
        $this->load_template('','accounts/chequepayment_voucher',$data);
    }
    
    public function chequereceivevoucher($type = '', $id = 0)
    {
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(197,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		
        $this->title = "Cheque Receive Voucher";
        
        if($type == 'delete'){
            $voucher = $this->db->select('*')->from('tbl_transections_master')->where(array('id'=>$id, 'type'=>'CHRV'))->get();
            
            if($voucher->num_rows() < 1){
                redirect(base_url() . 'Vouchers/manage_voucher');
                exit();
            }
            $this->db->delete('tbl_transections_master', array('id' => $id));
            $this->db->delete('tbl_transections_details', array('v_id' => $id));
            
            $this->session->set_userdata(array('error_message' => "Cheque Receive Voucher deleted successfully"));
            redirect(base_url() . 'Vouchers/manage_voucher');
            exit;
        }
        
        if (isset($_POST['add-vourcher'])) {
            $data = array(
                'type'          => $this->input->post('fld_type'),
                'date'          => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('date',TRUE)))),
                'post_status'          => $this->input->post('post_status'),
                'user_id'       => $this->session->userdata('user_id'),
                'created_date'  => date('Y-m-d H:i:s')
            );
            
            $this->db->insert('tbl_transections_master', $data);
		    $v_id = $this->db->insert_id();
		    $account_id = $this->input->post('account_id',TRUE);
		    $coa_id     =  $this->input->post('coa_id',TRUE);
    		$narration = $this->input->post('narration',TRUE);
    		$amount = $this->input->post('amount',TRUE);
    		
    		$fromNarration = 'Cr Acc. ';
    		$coa_fname = $this->db->select('head_name')->from('tbl_coa')->where('head_code', $this->input->post('from_account'))->get()->row()->head_name;
    		for ($i = 0, $n = count($coa_id); $i < $n; $i++) {
    		  $coa_name = $this->db->select('head_name')->from('tbl_coa')->where('head_code', $coa_id[$i])->get()->row()->head_name;
    		  $fromNarration .= $coa_name.', ';
    		  $data1=array(
    		      'v_id'        => $v_id,
    		      'coa_id'      => $coa_id[$i],
    		      'narration'   => 'Dr Acc. '.$coa_fname.' ('.$narration[$i].')',
    		      'credit'       => $amount[$i]
    		  );
    		  $this->db->insert('tbl_transections_details', $data1);
            
    		}
    		
    	    $fromNarration = rtrim($fromNarration, ', ');
    		
    		$fromData = array(
    		    'v_id'        => $v_id,
    		    'coa_id'      => $this->input->post('from_account'),
    		    'narration'   => $fromNarration.' ('.$this->input->post('from_narration').')',
    		    'debit'      => $this->input->post('total_amount')
    		);
    		$this->db->insert('tbl_transections_details', $fromData);
            /****************** Activity Log *****************************/
        		$user_role=$this->session->userdata('user_role');
        		$user_role_name=$this->session->userdata('user_role_name');
        		$user_id=$this->session->userdata('user_id');
        		$voucher_no=$this->input->post('fld_voucher_no',TRUE);
        		$client_ip=$this->Gen->get_client_ip();
        		$address=$this->Base_model->getLocation($client_ip);
                $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
                $date=date('Y-m-d H:i:s');
        		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'ADD',fld_detail='$voucher_no',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
            $this->session->set_userdata(array('success_message' => "Cheque Receive added successfully"));
            redirect(base_url() . 'Vouchers/chequereceivevoucher');
            exit;
        }
        
        if (isset($_POST['edit-vourcher'])) {
            $v_id = $this->input->post('editId');
             
            $data = array(
                'type'          => $this->input->post('fld_type'),
                'date'          => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('date',TRUE)))),
                'post_status'          => $this->input->post('post_status'),
                'user_id'       => $this->session->userdata('user_id'),
                'created_date'  => date('Y-m-d H:i:s')
            );
            
            
            
            $this->db->where('id', $v_id);
            $this->db->update('tbl_transections_master', $data);
            
            $this->db->delete('tbl_transections_details', array('v_id' => $v_id));
            
		    $account_id = $this->input->post('account_id',TRUE);
		    $coa_id     =  $this->input->post('coa_id',TRUE);
    		$narration = $this->input->post('narration',TRUE);
    		$amount = $this->input->post('amount',TRUE);
    		
    		$fromNarration = 'Cr Acc. ';
    		$coa_fname = $this->db->select('head_name')->from('tbl_coa')->where('head_code', $this->input->post('from_account'))->get()->row()->head_name;
    		for ($i = 0, $n = count($coa_id); $i < $n; $i++) {
    		  $coa_name = $this->db->select('head_name')->from('tbl_coa')->where('head_code', $coa_id[$i])->get()->row()->head_name;
    		  $fromNarration .= $coa_name.', ';
    		  $data1=array(
    		      'v_id'        => $v_id,
    		      'coa_id'      => $coa_id[$i],
    		      'narration'   => 'Dr Acc. '.$coa_fname.' ('.$narration[$i].')',
    		      'credit'       => $amount[$i]
    		  );
    		  $this->db->insert('tbl_transections_details', $data1);
            
    		}
    		
    		$fromNarration = rtrim($fromNarration, ', ');
    		
    		$fromData = array(
    		    'v_id'        => $v_id,
    		    'coa_id'      => $this->input->post('from_account'),
    		    'narration'   => $fromNarration.' ('.$this->input->post('from_narration').')',
    		    'debit'      => $this->input->post('total_amount')
    		);
    		$this->db->insert('tbl_transections_details', $fromData);
    		
            /****************** Activity Log *****************************/
        		$user_role=$this->session->userdata('user_role');
        		$user_role_name=$this->session->userdata('user_role_name');
        		$user_id=$this->session->userdata('user_id');
        		$voucher_no=$this->input->post('fld_voucher_no',TRUE);
        		$client_ip=$this->Gen->get_client_ip();
        		$address=$this->Base_model->getLocation($client_ip);
                $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
                $date=date('Y-m-d H:i:s');
        		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'UPDATE',fld_detail='$voucher_no',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
            $this->session->set_userdata(array('success_message' => "Cheque Receive Voucher edited successfully"));
            redirect(base_url() . 'Vouchers/manage_voucher');
            exit;
        }
        
        
        
        
		$data['view_scripts']=array(
    		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
    		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
    		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
    		$this->Gen->get_script_url('custom_js','jquery.validate.js'),
    		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		    $this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		    $this->Gen->get_script_url('custom_js','vouchers.js'),
		);
		
		$data['view_css']=array(
            $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
            $this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
	    );
	    
	    $getMaxVoucherID=$this->Accounts_model->getMaxVoucherID();
		$data['maxid']= $getMaxVoucherID['Auto_increment'];
		
		$data['from_accounts'] = $this->db->select('*')->from('tbl_coa')->where('head_code!=', '101014')->like('head_code', '101014', 'both')->get()->result_array();
		$data['to_accounts'] = $this->db->select('*')->from('tbl_coa')->where('head_level', '3')->not_like('head_code', '101014', 'both')->get()->result_array();
	
	    if($type == 'edit'){
            $voucher = $this->db->select('*')->from('tbl_transections_master')->where(array('id'=>$id, 'type'=>'CHRV'))->get();
            
            if($voucher->num_rows() < 1){
                redirect(base_url() . 'Vouchers/manage_voucher');
                exit();
            }
            $data['edit'] = $id; 
            $data['maxid'] = $id;
            $data['editData'] = $voucher->row_array();
            $data['editDataV'] = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id, 'debit>'=>0))->get()->row_array();
            $data['editDataDetails']  = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id, 'credit>'=>0))->get()->result_array();
            
        }
        if($type == 'duplicate'){
             $voucher = $this->db->select('*')->from('tbl_transections_master')->where(array('id'=>$id, 'type'=>'CHRV'))->get();
            
            if($voucher->num_rows() < 1){
                redirect(base_url() . 'Vouchers/manage_voucher');
                exit();
            }
            $data['edit'] = "";
            $data['duplicate'] = "";
            $data['maxid'] = $getMaxVoucherID['Auto_increment'];
            $data['editData'] = $voucher->row_array();
            $data['editDataV'] = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id, 'debit>'=>0))->get()->row_array();
            $data['editDataDetails']  = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id, 'credit>'=>0))->get()->result_array();
            
        }
	    
	    $data['chrv_voucher']  = $this->db->select('*')->from('tbl_transections_master')->where(array('type'=>'CHRV'))->get()->result_array();
        $this->load_template('','accounts/chequereceive_voucher',$data);
    }
    
    public function pldvoucher($type = '', $id = 0)
    {
       
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(263,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		
        $this->title = "ProfitLoss Division Voucher";
        
        if($type == 'delete'){
            $voucher = $this->db->select('*')->from('tbl_transections_master')->where(array('id'=>$id, 'type'=>'PLD'))->get();
            
            if($voucher->num_rows() < 1){
                redirect(base_url() . 'Vouchers/manage_voucher');
                exit();
            }
            $this->db->delete('tbl_transections_master', array('id' => $id));
            $this->db->delete('tbl_transections_details', array('v_id' => $id));
            
            $this->session->set_userdata(array('error_message' => "ProfitLoss Division deleted successfully"));
            redirect(base_url() . 'Vouchers/manage_voucher');
            exit;
        }
        
        if (isset($_POST['add-vourcher'])) {
            $data = array(
                'type'          => $this->input->post('fld_type'),
                'date'          => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('date',TRUE)))),
                'user_id'       => $this->session->userdata('user_id'),
                'created_date'  => date('Y-m-d H:i:s')
            );
            
            $this->db->insert('tbl_transections_master', $data);
		    $v_id = $this->db->insert_id();
		    $pld_account = $this->input->post('from_account');
		    
		    if($this->input->post('pld') == 1){
		        $fromData = array(
        		    'v_id'        => $v_id,
        		    'coa_id'      => $this->input->post('from_account'),
        		    'narration'   => $this->input->post('from_narration'),
        		    'debit'      => $this->input->post('amount')
        		);
        		$this->db->insert('tbl_transections_details', $fromData);
        		
        		$toData = array(
        		    'v_id'        => $v_id,
        		    'coa_id'      => '201008001',
        		    'narration'   => $this->input->post('from_narration'),
        		    'credit'      => $this->input->post('amount')
        		);
        		$this->db->insert('tbl_transections_details', $toData);
		    }else{
		        $fromData = array(
        		    'v_id'        => $v_id,
        		    'coa_id'      => $this->input->post('from_account'),
        		    'narration'   => $this->input->post('from_narration'),
        		    'credit'      => $this->input->post('amount')
        		);
        		$this->db->insert('tbl_transections_details', $fromData);
        		
        		$toData = array(
        		    'v_id'        => $v_id,
        		    'coa_id'      => '201008001',
        		    'narration'   => $this->input->post('from_narration'),
        		    'debit'      => $this->input->post('amount')
        		);
        		$this->db->insert('tbl_transections_details', $toData);
		    }
		    
		    
		    
    		
    		
            /****************** Activity Log *****************************/
        		$user_role=$this->session->userdata('user_role');
        		$user_role_name=$this->session->userdata('user_role_name');
        		$user_id=$this->session->userdata('user_id');
        		$voucher_no=$this->input->post('fld_voucher_no',TRUE);
        		$client_ip=$this->Gen->get_client_ip();
        		$address=$this->Base_model->getLocation($client_ip);
                $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
                $date=date('Y-m-d H:i:s');
        		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'ADD',fld_detail='$voucher_no',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
            $this->session->set_userdata(array('success_message' => "Profit Loss Division added successfully"));
            redirect(base_url() . 'Vouchers/pldvoucher');
            exit;
        }
        
    //     if (isset($_POST['edit-vourcher'])) {
    //         $v_id = $this->input->post('editId');
             
    //         $data = array(
    //             'type'          => $this->input->post('fld_type'),
    //             'date'          => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('date',TRUE)))),
    //             'user_id'       => $this->session->userdata('user_id'),
    //             'created_date'  => date('Y-m-d H:i:s')
    //         );
            
            
            
    //         $this->db->where('id', $v_id);
    //         $this->db->update('tbl_transections_master', $data);
            
    //         $this->db->delete('tbl_transections_details', array('v_id' => $v_id));
            
		  //  $account_id = $this->input->post('account_id',TRUE);
		  //  $coa_id     =  $this->input->post('coa_id',TRUE);
    // 		$narration = $this->input->post('narration',TRUE);
    // 		$amount = $this->input->post('amount',TRUE);
    // 		$fromNarration = 'Dr Acc. ';
    // 		$coa_fname = $this->db->select('head_name')->from('tbl_coa')->where('head_code', $this->input->post('from_account'))->get()->row()->head_name;
    // 		for ($i = 0, $n = count($coa_id); $i < $n; $i++) {
    // 		  $coa_name = $this->db->select('head_name')->from('tbl_coa')->where('head_code', $coa_id[$i])->get()->row()->head_name;
    // 		  $fromNarration .= $coa_name.', ';
    // 		  $data1=array(
    // 		      'v_id'        => $v_id,
    // 		      'coa_id'      => $coa_id[$i],
    // 		      'narration'   => 'Cr Acc. '.$coa_fname.' ('.$narration[$i].')',
    // 		      'debit'       => $amount[$i]
    // 		  );
    // 		  $this->db->insert('tbl_transections_details', $data1);
            
    // 		}
    // 		$fromNarration = rtrim($fromNarration, ', ');
    		
    // 		$fromData = array(
    // 		    'v_id'        => $v_id,
    // 		    'coa_id'      => $this->input->post('from_account'),
    // 		    'narration'   => $fromNarration.' ('.$this->input->post('from_narration').')',
    // 		    'credit'      => $this->input->post('total_amount')
    // 		);
    // 		$this->db->insert('tbl_transections_details', $fromData);
    		
    //         /****************** Activity Log *****************************/
    //     		$user_role=$this->session->userdata('user_role');
    //     		$user_role_name=$this->session->userdata('user_role_name');
    //     		$user_id=$this->session->userdata('user_id');
    //     		$voucher_no=$this->input->post('fld_voucher_no',TRUE);
    //     		$client_ip=$this->Gen->get_client_ip();
    //     		$address=$this->Base_model->getLocation($client_ip);
    //             $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
    //             $date=date('Y-m-d H:i:s');
    //     		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'UPDATE',fld_detail='$voucher_no',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
    //         $this->session->set_userdata(array('success_message' => "Cash Payment Voucher edited successfully"));
    //         redirect(base_url() . 'Vouchers/manage_voucher');
    //         exit;
    //     }
        
        
        
		$data['view_scripts']=array(
    		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
    		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
    		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
    		$this->Gen->get_script_url('custom_js','jquery.validate.js'),
    		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		    $this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		    $this->Gen->get_script_url('custom_js','vouchers.js'),
		  //  $this->Gen->get_script_url('plugin_components','clipboard/clipboard.min.js'),
		  //  $this->Gen->get_script_url('bower_components','jquery.clipboard.init.js'),
		);
		
		$data['view_css']=array(
            $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
            $this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
	    );
	    
	    $getMaxVoucherID=$this->Accounts_model->getMaxVoucherID();
		$data['maxid']= $getMaxVoucherID['Auto_increment'];
		
		$data['from_accounts'] = $this->db->select('*')->from('tbl_coa')->where('head_code!=', '205001')->like('head_code', '205001', 'both')->get()->result_array();
	
	    
	     $data['pld_voucher']  = $this->db->select('*')->from('tbl_transections_master')->where(array('type'=>'PLD'))->get()->result_array();
	   
	   
        $this->load_template('','accounts/pld_voucher',$data);
    }
    
    public function manage_voucher()
    {
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
	    $role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(181,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
        $this->title = "Views Vouchers";
        
		$data['view_scripts']=array(
    		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
    		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
    		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
    		$this->Gen->get_script_url('custom_js','jquery.validate.js'),
    		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		    $this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		    $this->Gen->get_script_url('custom_js','vouchers.js'),
		);
		
		$data['view_css']=array(
            $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
            $this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
	    );
	    
	    $query = "SELECT * FROM tbl_transections_master ORDER by id desc LIMIT 0,100";
	    
	    if(isset($_GET['filter_type'])){
	        $query = "SELECT * FROM tbl_transections_master WHERE id > 0";
	        if($_GET['voucher_type'] != 'all'){
	            $query .= " && type = '{$_GET['voucher_type']}'";
	        }
	        if(!empty($_GET['voucher_code'])){
	            $code = (int) abs(filter_var($_GET['voucher_code'], FILTER_SANITIZE_NUMBER_INT));
	            $query .= " && id = '$code'";
	        }
	        
	        $query .= " ORDER by id desc";
	       
	    }
	    
	    $data['vouchers'] = $this->db->query($query)->result_array();
		
		
        $this->load_template('','accounts/manage_vouchers',$data);
    }
    
    public function getBalance(){
        if($this->input->post("id")){
            
        
        $id = $this->input->post("id");
        
        $debit = $this->db->query("SELECT IFNULL(SUM(td.debit), 0) as debit FROM tbl_transections_details as td, tbl_transections_master as tm WHERE coa_id = '$id' && tm.id = td.v_id && tm.post_status = 0")->row()->debit;
        $credit = $this->db->query("SELECT IFNULL(SUM(td.credit), 0) as credit FROM tbl_transections_details as td, tbl_transections_master as tm WHERE coa_id = '$id' && tm.id = td.v_id && tm.post_status = 0")->row()->credit;
            
        if(substr($id, 0, 6) == '205001' && strlen($id) > 6){
            $incomep = $this->Accounts_model->getIncomePlantReport("", date('Y-m-d'), $id);
            $balance = number_format(($credit-$debit+$incomep), 2, '.', ',');
        }else{
            
            $balance = number_format(($debit-$credit), 2, '.', ',');
        }
        
       
        
        }else{
            $balance = 0.00;
        }
        
        
        echo $balance;
    }
    
    public function getBalanceInner($id, $plus_amount = 0){
        
        $debit = $this->db->query("SELECT IFNULL(SUM(td.debit), 0) as debit FROM tbl_transections_details as td, tbl_transections_master as tm WHERE coa_id = '$id' && tm.id = td.v_id && tm.post_status = 0")->row()->debit;
        $credit = $this->db->query("SELECT IFNULL(SUM(td.credit), 0) as credit FROM tbl_transections_details as td, tbl_transections_master as tm WHERE coa_id = '$id' && tm.id = td.v_id && tm.post_status = 0")->row()->credit;
        $balance = number_format(($debit-$credit+$plus_amount), 2, '.', ',');
        return $balance;
        
    }
    
     function getStringBetween($str)
    {
        $str = explode('(', $str);
        return str_replace(')', '', array_values(array_slice($str, -1))[0]);
    }
    public function view_jv_voucher($id){
        $voucher = $this->db->select('*')->from('tbl_transections_master')->where(array('id'=>$id, 'type'=>'JV'))->get();
            
            if($voucher->num_rows() < 1){
                redirect(base_url() . 'Vouchers/manage_voucher');
                exit();
            }
            $data['edit'] = $id; 
            $data['maxid'] = $id;
            $data['editData'] = $voucher->row_array();
            $data['editDataDetails']  = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id))->get()->result_array();
            $voucher = $this->db->select('*')->from('tbl_transections_master')->where(array('id'=>$id, 'type'=>'JV'))->get();
		$this->load_template('','accounts/view_jv_voucher',$data);
		
	}
    public function print_jv_voucher($id){
        $voucher = $this->db->select('*')->from('tbl_transections_master')->where(array('id'=>$id, 'type'=>'JV'))->get();
            
            if($voucher->num_rows() < 1){
                redirect(base_url() . 'Vouchers/manage_voucher');
                exit();
            }
            $data['edit'] = $id; 
            $data['maxid'] = $id;
            $data['editData'] = $voucher->row_array();
            $data['editDataDetails']  = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id))->get()->result_array();
		$this->load->view('accounts/print_jv_voucher',$data);
		
	}
	public function pdf_jv_voucher($id){
	     $voucher = $this->db->select('*')->from('tbl_transections_master')->where(array('id'=>$id, 'type'=>'JV'))->get();
            
            if($voucher->num_rows() < 1){
                redirect(base_url() . 'Vouchers/manage_voucher');
                exit();
            }
            $data['edit'] = $id; 
            $data['maxid'] = $id;
            $data['editData'] = $voucher->row_array();
            $data['editDataDetails']  = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id))->get()->result_array();
		include_once APPPATH.'/third_party/autoload.php';
		//$this->load->view('print_purchase_report');
		$mpdf = new \Mpdf\Mpdf();
// 		$data['purchase']=$purchase=$this->Purchase_model->purchase_filter_pdf($_GET);
// 		$this->load->view('accounts/pdf_voucher',$data);
		$html = $this->load->view('accounts/pdf_jv_voucher',$data,true);
		$mpdf->WriteHTML($html);
		$mpdf->Output('JV Report.pdf','D');
	}
	public function view_voucher($id){
	      $voucher = $this->db->select('*')->from('tbl_transections_master')->where(array('id'=>$id))->get();
            
            if($voucher->num_rows() < 1){
                redirect(base_url() . 'Vouchers/manage_voucher');
                exit();
            }
            $data['edit'] = $id; 
            $data['maxid'] = $id;
            $data['editData'] = $voucher->row_array();
            // $data['editDataDetails']  = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id))->get()->result_array();
            if($data['editData']['type'] == 'CRV' || $data['editData']['type'] == 'CHRV'){

                $data['editDataV'] = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id, 'debit>'=>0))->get()->row_array();
            $data['editDataDetails']  = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id, 'credit>'=>0))->get()->result_array();
            }else{
                $data['editDataV'] = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id, 'credit>'=>0))->get()->row_array();
            $data['editDataDetails']  = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id, 'debit>'=>0))->get()->result_array();
            }
            
            $voucher = $this->db->select('*')->from('tbl_transections_master')->where(array('id'=>$id))->get();
           // echo '<pre>';
            //print_r($data);
            //exit;
// 		$this->load->view('accounts/view_voucher',$data);
	$this->load_template('','accounts/view_voucher',$data);
		
	}
	public function view_pld_voucher($id){
	      $voucher = $this->db->select('*')->from('tbl_transections_master')->where(array('id'=>$id))->get();
            
            if($voucher->num_rows() < 1){
                redirect(base_url() . 'Vouchers/manage_voucher');
                exit();
            }
            $data['edit'] = $id; 
            $data['maxid'] = $id;
            $data['editData'] = $voucher->row_array();
            // $data['editDataDetails']  = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id))->get()->result_array();
            if($data['editData']['type'] == 'CRV' || $data['editData']['type'] == 'CHRV'){

                $data['editDataV'] = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id, 'debit>'=>0))->get()->row_array();
            $data['editDataDetails']  = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id, 'credit>'=>0))->get()->result_array();
            }else{
                $data['editDataV'] = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id, 'credit>'=>0))->get()->row_array();
            $data['editDataDetails']  = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id, 'debit>'=>0))->get()->result_array();
            }
            
            $voucher = $this->db->select('*')->from('tbl_transections_master')->where(array('id'=>$id))->get();
           // echo '<pre>';
            //print_r($data);
            //exit;
// 		$this->load->view('accounts/view_voucher',$data);
	$this->load_template('','accounts/view_pld_voucher',$data);
		
	}
	 public function print_voucher($id){
	      $voucher = $this->db->select('*')->from('tbl_transections_master')->where(array('id'=>$id))->get();
            
            if($voucher->num_rows() < 1){
                redirect(base_url() . 'Vouchers/manage_voucher');
                exit();
            }
            $data['edit'] = $id; 
            $data['maxid'] = $id;
            $data['editData'] = $voucher->row_array();
            // $data['editDataDetails']  = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id))->get()->result_array();
            if($data['editData']['type'] == 'CRV' || $data['editData']['type'] == 'CHRV'){
                $data['editDataV'] = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id, 'debit>'=>0))->get()->row_array();
            $data['editDataDetails']  = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id, 'credit>'=>0))->get()->result_array();
            }else{
                $data['editDataV'] = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id, 'credit>'=>0))->get()->row_array();
            $data['editDataDetails']  = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id, 'debit>'=>0))->get()->result_array();
            }
            
		$this->load->view('accounts/print_voucher',$data);
		
	}
	public function pdf_voucher($id){
	   // $filter=$this->input->get('filter');
	   $voucher = $this->db->select('*')->from('tbl_transections_master')->where(array('id'=>$id))->get();
            
            if($voucher->num_rows() < 1){
                redirect(base_url() . 'Vouchers/manage_voucher');
                exit();
            }
            $data['edit'] = $id; 
            $data['maxid'] = $id;
            
            $data['editData'] = $voucher->row_array();
            if($data['editData']['type'] == 'CRV' || $data['editData']['type'] == 'CHRV'){
                $data['editDataV'] = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id, 'debit>'=>0))->get()->row_array();
            $data['editDataDetails']  = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id, 'credit>'=>0))->get()->result_array();
            }else{
                $data['editDataV'] = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id, 'credit>'=>0))->get()->row_array();
            $data['editDataDetails']  = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$id, 'debit>'=>0))->get()->result_array();
            }
		include_once APPPATH.'/third_party/autoload.php';
		//$this->load->view('print_purchase_report');
		$mpdf = new \Mpdf\Mpdf();
// 		$data['purchase']=$purchase=$this->Purchase_model->purchase_filter_pdf($_GET);
// 		$this->load->view('accounts/pdf_voucher',$data);

		$html = $this->load->view('accounts/pdf_voucher',$data,true);
		$mpdf->WriteHTML($html);
		$mpdf->Output('Voucher Report.pdf','D');
	}
}
