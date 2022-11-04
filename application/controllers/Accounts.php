<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accounts extends My_controller { 
	    
	function __construct() {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->model('Accounts_model');  
        $this->load->model('Sales_model');  
    } 
	
    
    public function balancesheet()
    { 
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		
        $role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(144,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		
        $this->title = "Chart Of Accounts";
		
		$data['view_scripts']=array(
		    
    		 
    		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
    		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
    		$this->Gen->get_script_url('plugin_components','treeview/jstree.min.js'),
    		$this->Gen->get_script_url('bower_components','jquery.treeview.init.js'),
    // 		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'),
    		$this->Gen->get_script_url('','https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js'),
    		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
    		$this->Gen->get_script_url('custom_js','jquery.validate.js'),
    		$this->Gen->get_script_url('custom_js','accounts.js'),
		);
		$data['view_css']=array(
            $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
            $this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
            $this->Gen->get_script_url('plugin_components','treeview/themes/default/style.css'),
            $this->Gen->get_script_url('plugin_components','treeview/file-explore.css'),
		);
		
		$data['coa_list'] = $this->db->query("select * from tbl_coa ORDER by head_code asc")->result_array();
        
		//$data['currentAssets'] = $this->Base_model->getAll('tbl_currentAssets');
        $this->load_template('','accounts/balancesheet',$data);
        
    }
    
    public function newform($id){

      $newdata = $this->db->select('*')
                ->from('tbl_coa')
                ->where('head_code',$id)
                ->get()
                ->row();
    
               
      $newidsinfo = $this->db->select('*,MAX(head_code) as hc')
                ->from('tbl_coa')
                ->where('parent_head_name',$newdata->head_name)
                ->get()
                ->row();
    
        $nid  = (int) substr($newidsinfo->hc, -3);
        $n =$nid + 1;
        $newlevel = $newdata->head_level+1;
        
        if($newlevel > 1){
            $n = sprintf('%03d', $n); 
        }else{
            $n = sprintf('%02d', $n);
        }
        
        // if ($n / 10 < 1)
        //   $HeadCode = $id . "0" . $n;
        // else
        
          $HeadCode = $id . $n;
        
          
          $info['headcode'] =  $HeadCode;
          $info['rowdata'] =  $newdata;
          $info['headlabel'] =  $newlevel;
          echo json_encode($info);
      }
    
    public function selectedform($id){
        $CI = & get_instance();
        $CI->load->model('Accounts_model');
		$coa_result = $CI->Accounts_model->treeview_selectform($id);
					

        $html  = '';
        $role_permissions  = explode(",",$this->session->userdata('permissions'));
		if ($coa_result){
			$html = '<form action="'.base_url().'Accounts/insert_coa" method="post" id="form">
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-4 col-form-label text-right">Level ID</label>
                                <div class="col-sm-6">
                                    <input class="form-control" name="txtHeadCode" id="txtHeadCode"  type="text" id="example-text-input" value="'.$coa_result->head_code.'" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-4 col-form-label text-right">Parent Level</label>
                                <div class="col-sm-6">
                                    <input class="form-control" name="txtPHead" id="txtPHead" type="text" id="example-text-input" value="'.$coa_result->parent_head_name.'" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-4 col-form-label text-right">Level</label>
                                <div class="col-sm-6">
                                    <input class="form-control" name="txtHeadLevel" id="txtHeadLevel" type="text" id="example-text-input" value="'.$coa_result->head_level.'" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-4 col-form-label text-right">Level Name</label>
                                <div class="col-sm-6">';
                                if($coa_result->head_code == 0){
                                    $html .= '<input class="form-control" type="text" name="txtHeadName" id="txtHeadName" id="example-text-input" value="'.$coa_result->head_name.'" readonly>';
                                }else{
                                    $html .= '<input class="form-control" type="text" name="txtHeadName" id="txtHeadName" id="example-text-input" value="'.$coa_result->head_name.'">';
                                }
                                $html .= '<input type="hidden" name="HeadName" id="HeadName" class="form-control" value="'.$coa_result->head_name.'"/>
                                </div>
                            </div>
                             <div class="form-group row">
                                <div class="col-sm-4 "></div>
                                <div class="col-sm-8">
                                    <input type="submit" name="btnSave" id="btnSave" value="Save" disabled="disabled" class="btn btn-successs">';
                                    if(!empty($role_permissions) && in_array(146,$role_permissions)) {
                                     $html .= '<input type="submit" name="btnUpdate" id="btnUpdate" value="Update" class="btn btn-successs">';
                                    }else{
                                     $html .= '<input type="submit" name="btnUpdate" id="btnUpdate" value="Update" class="btn btn-successs" disabled style="cursor: not-allowed;">';   
                                    }
                                    if(!empty($role_permissions) && in_array(145,$role_permissions)) {
                                      $html .= '<input type="button" name="btnNew" id="btnNew" value="New" onclick="newHeaddata('.$coa_result->head_code.')" class="btn btn-success1">';
                                    }else{
                                      $html .= '<input type="button" name="btnNew" id="btnNew" value="New" disabled style="cursor: not-allowed;" class="btn btn-success1">';  
                                    }
                                    
            //                         if(!empty($role_permissions) && in_array(147,$role_permissions)) {
    								//   $html .= '<input type="button" onclick="window.location.href=\''.base_url().'Accounts/delete_coa/'.$coa_result->head_code.'\'" class="btn btn-warning btn-large" name="btnDelete" id="btnDelete" value="Delete">';
            //                         }else{
                                      $html .= '<input type="button" disabled style="cursor: not-allowed;" class="btn btn-warning btn-large" name="btnDelete" id="btnDelete" value="Delete">';   
                                    // }
                                    
                                $html .= '</div>
                            </div>
                        </form>';
		}

		echo json_encode($html);
	}
	
	public function insert_coa(){
    $headcode    = $this->input->post('txtHeadCode',TRUE);
    $HeadName    = $this->input->post('txtHeadName',TRUE);
    $PHeadName   = $this->input->post('txtPHead',TRUE);
    $HeadLevel   = $this->input->post('txtHeadLevel',TRUE);
    $txtHeadType = $this->input->post('txtHeadType',TRUE);
    $createdate=date('Y-m-d H:i:s');
       $postData = array(
      'head_code'       =>  $headcode,
      'head_name'       =>  $HeadName,
      'parent_head_name'      =>  $PHeadName,
      'head_level'      =>  $HeadLevel,
    ); 
 $upinfo = $this->db->select('*')
            ->from('tbl_coa')
            ->where('head_code',$headcode)
            ->get()
            ->row();
if(empty($upinfo)){
  $this->db->insert('tbl_coa',$postData);
  /****************** Activity Log *****************************/
        		$user_role=$this->session->userdata('user_role');
        		$user_role_name=$this->session->userdata('user_role_name');
        		$user_id=$this->session->userdata('user_id');
        		$Head=$HeadName;
        		$client_ip=$this->Gen->get_client_ip();
        		$address=$this->Base_model->getLocation($client_ip);
                $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
                $date=date('Y-m-d H:i:s');
        		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'ADD',fld_detail='COA $Head',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
}else{
$hname =$this->input->post('HeadName',TRUE);
$updata = array(
'parent_head_name'      =>  $HeadName,
);

            
  $this->db->where('head_code',$headcode)
      ->update('tbl_coa',$postData);
  $this->db->where('parent_head_name',$hname)
      ->update('tbl_coa',$updata);
      /****************** Activity Log *****************************/
        		$user_role=$this->session->userdata('user_role');
        		$user_role_name=$this->session->userdata('user_role_name');
        		$user_id=$this->session->userdata('user_id');
        		$Head=$hname;
        		$client_ip=$this->Gen->get_client_ip();
        		$address=$this->Base_model->getLocation($client_ip);
                $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
                $date=date('Y-m-d H:i:s');
        		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'UPDATE',fld_detail='COA $Head',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
}
    redirect($_SERVER['HTTP_REFERER']);
  }
  
    function delete_coa($id){
      $this->db->where('head_code', $id);
      $this->db->delete('tbl_coa');
      /****************** Activity Log *****************************/
        		$user_role=$this->session->userdata('user_role');
        		$user_role_name=$this->session->userdata('user_role_name');
        		$user_id=$this->session->userdata('user_id');
        		$Head= $this->db->where('head_name', $id);
        		$client_ip=$this->Gen->get_client_ip();
        		$address=$this->Base_model->getLocation($client_ip);
                $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
                $date=date('Y-m-d H:i:s');
        		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'DELETED',fld_detail='COA $Head',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
      redirect('Accounts/balancesheet');
  }
  
    public function supplier_ledger()
    {
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(198,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
        $this->title = "Supplier Ledger";
		$data['view_scripts']=array(
    		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
    		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
    		$this->Gen->get_script_url('plugin_components','treeview/jstree.min.js'),
    		$this->Gen->get_script_url('bower_components','jquery.treeview.init.js'),
    // 		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'),
    		$this->Gen->get_script_url('','https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
    		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
    		$this->Gen->get_script_url('custom_js','jquery.validate.js'),
    		$this->Gen->get_script_url('custom_js','accounts.js'),
		);
		$data['view_css']=array(
            $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
            $this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
            $this->Gen->get_script_url('plugin_components','treeview/themes/default/style.css'),
            $this->Gen->get_script_url('plugin_components','treeview/file-explore.css'),
            $this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
		);
		$data['supplier_list'] = $this->db->query("SELECT * FROM `tbl_coa` WHERE head_code LIKE '%101005%' and head_code != '101005' order by head_name")->result_array();
	  //$data['currentAssets'] = $this->Base_model->getAll('tbl_currentAssets');
        $this->load_template('','accounts/supplier_ledger',$data);
    }
    
    public function customer_ledger()
    {
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(199,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
       
		
        $this->title = "Customer Ledger";
		
		$data['view_scripts']=array(
		    
    		
    		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
    		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
    		$this->Gen->get_script_url('plugin_components','treeview/jstree.min.js'),
    		$this->Gen->get_script_url('bower_components','jquery.treeview.init.js'),
    // 		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'),
            $this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
    		$this->Gen->get_script_url('','https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js'),
    		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
    		$this->Gen->get_script_url('custom_js','jquery.validate.js'),
    		$this->Gen->get_script_url('custom_js','accounts.js'),
		);
		$data['view_css']=array(
            $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
            $this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
            $this->Gen->get_script_url('plugin_components','treeview/themes/default/style.css'),
            $this->Gen->get_script_url('plugin_components','treeview/file-explore.css'),
            $this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
		);
		
		$data['customer_list'] = $this->db->query("SELECT * FROM `tbl_coa` WHERE head_code LIKE '%101007%' and head_code != '101007' order by head_name")->result_array();
        
		//$data['currentAssets'] = $this->Base_model->getAll('tbl_currentAssets');
        $this->load_template('','accounts/customer_ledger',$data);
        
    }
    
    public function accounts_ledger()
    {
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(200,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
       
		
        $this->title = "Accounts Ledger";
		
		$data['view_scripts']=array(
		    
    		
    		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
    		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
    		$this->Gen->get_script_url('plugin_components','treeview/jstree.min.js'),
    		$this->Gen->get_script_url('bower_components','jquery.treeview.init.js'),
    // 		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'),
    		$this->Gen->get_script_url('','https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
    		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
    		$this->Gen->get_script_url('custom_js','jquery.validate.js'),
    		$this->Gen->get_script_url('custom_js','accounts.js'),
		);
		$data['view_css']=array(
            $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
            $this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
            $this->Gen->get_script_url('plugin_components','treeview/themes/default/style.css'),
            $this->Gen->get_script_url('plugin_components','treeview/file-explore.css'),
            $this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
		);
		
		$data['accounts_list'] = $this->db->query("SELECT * FROM `tbl_coa` WHERE head_level = '3' AND head_code NOT LIKE '%401007%'")->result_array();
        
		//$data['currentAssets'] = $this->Base_model->getAll('tbl_currentAssets');
        $this->load_template('','accounts/accounts_ledger',$data);
        
    }
    
    public function item_ledger()
    {
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(201,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
       
		
        $this->title = "Items Ledger";
		
		$data['view_scripts']=array(
		    
    		
    		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
    		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
    		$this->Gen->get_script_url('plugin_components','treeview/jstree.min.js'),
    		$this->Gen->get_script_url('bower_components','jquery.treeview.init.js'),
    // 		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'),
            $this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
    		$this->Gen->get_script_url('','https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js'),
    		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
    		$this->Gen->get_script_url('custom_js','jquery.validate.js'),
    		$this->Gen->get_script_url('custom_js','accounts.js'),
		);
		$data['view_css']=array(
            $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
            $this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
            $this->Gen->get_script_url('plugin_components','treeview/themes/default/style.css'),
            $this->Gen->get_script_url('plugin_components','treeview/file-explore.css'),
            $this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
		);
        
		//$data['currentAssets'] = $this->Base_model->getAll('tbl_currentAssets');
        $this->load_template('','accounts/items_ledger',$data);
        
    }
    
   
    public function customer_ledger_filter() {
		$conditions="";
		$account_id=$this->input->post('account_id');
		$group_by='td.coa_id';
		$select="coa.head_name as filter_text,td.coa_id as filter_value";
		
		$start=str_replace('/', '-', $this->input->post('from_date'));
		$end=str_replace('/', '-', $this->input->post('to_date'));
		$date="tm.date between '".date("Y-m-d",strtotime($start))."' AND '".date("Y-m-d",strtotime($end))."'";
		$this->db->select('tm.id,'.$select);
		
		$this->db->from('tbl_transections_details as td');
		
		$this->db->join('tbl_transections_master as tm','tm.id=td.v_id');
		
		$this->db->join('tbl_coa as coa','coa.head_code=td.coa_id');
		
		$this->db->where($date);
		$from = date("Y-m-d",strtotime($start));
		if($account_id!='all'){
		    $this->db->where("td.coa_id",$account_id);
		    $op = $this->db->query("SELECT IFNULL(SUM(b.debit), 0)-IFNULL(SUM(b.credit), 0) as balance from tbl_transections_details as b, tbl_transections_master as a where b.coa_id = '$account_id' AND a.date < '$from' AND a.id = b.v_id")->row()->balance;
		}else{
		    $this->db->like('td.coa_id', '101007', 'both');
		    $op = $this->db->query("SELECT IFNULL(SUM(b.debit), 0)-IFNULL(SUM(b.credit), 0) as balance from tbl_transections_details as b, tbl_transections_master as a where b.coa_id LIKE '%101007%' AND a.date < '$from' AND a.id = b.v_id")->row()->balance;
		}
		
		$this->db->group_by($group_by);
		
	    $ledger=$this->db->get()->result_array();
		
	    
	    if($ledger){
			foreach($ledger as $key => $ledg){
				$ledgdet=$this->getLedgDetail($ledg['filter_value'],$group_by);
				$ledger[$key]['detail']=$ledgdet;
				$ledger[$key]['opening']=$op;
			}
		}
		
		$data['ledger'] = $ledger;
		$data['from'] = $from;
		$count=count($ledger);
		$html=$this->load->view('accounts/customer_ledger_filter',$data,true);
		echo json_encode(array("html"=>$html,'count'=>$count));
        
    }
    public function customer_ledger_filter_csv() {
        $_POST=$_GET;
		$conditions="";
		$account_id=$this->input->post('account_id');
		$group_by='td.coa_id';
		$select="coa.head_name as filter_text,td.coa_id as filter_value";
		
		$start=str_replace('/', '-', $this->input->post('from_date'));
		$end=str_replace('/', '-', $this->input->post('to_date'));
		$date="tm.date between '".date("Y-m-d",strtotime($start))."' AND '".date("Y-m-d",strtotime($end))."'";
		$this->db->select('tm.id,'.$select);
		
		$this->db->from('tbl_transections_details as td');
		
		$this->db->join('tbl_transections_master as tm','tm.id=td.v_id');
		
		$this->db->join('tbl_coa as coa','coa.head_code=td.coa_id');
		
		$this->db->where($date);
		$from = date("Y-m-d",strtotime($start));
		if($account_id!='all'){
		    $this->db->where("td.coa_id",$account_id);
		    $op = $this->db->query("SELECT IFNULL(SUM(b.debit), 0)-IFNULL(SUM(b.credit), 0) as balance from tbl_transections_details as b, tbl_transections_master as a where b.coa_id = '$account_id' AND a.date < '$from' AND a.id = b.v_id")->row()->balance;
		}else{
		    $this->db->like('td.coa_id', '101007', 'both');
		    $op = $this->db->query("SELECT IFNULL(SUM(b.debit), 0)-IFNULL(SUM(b.credit), 0) as balance from tbl_transections_details as b, tbl_transections_master as a where b.coa_id LIKE '%101007%' AND a.date < '$from' AND a.id = b.v_id")->row()->balance;
		}
		
		$this->db->group_by($group_by);
		
	    $ledger=$this->db->get()->result_array();
		
	    
	    if($ledger){
			foreach($ledger as $key => $ledg){
				$ledgdet=$this->getLedgDetail($ledg['filter_value'],$group_by);
				$ledger[$key]['detail']=$ledgdet;
				$ledger[$key]['opening']=$op;
			}
		}
		
		$data['ledger'] = $ledger;
	
		$data['from'] = $from;
		include_once APPPATH.'/third_party/autoload.php';
		$header_row = array("#", "Voucher Date", "Voucher Number", "Narration" , "Debit", "Credit", "Balance","Dr/Cr");
        $csvName = 'customerLedger'.'.csv';
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="'.$csvName.'";');
        $output = fopen('php://output', 'w');
        
        fputcsv($output,$header_row);
        $i=1;
        $type="";
        $voucher="";
        $naration="";
        
       
        $drcr="";
        foreach($ledger as $ledge){
            
            $balance=$ledge['opening'];
            foreach($ledge['detail'] as $ledgedet){
                $debit=0;
                $credit=0;
                $balance += $ledgedet['debit']-$ledgedet['credit'];
                $type= $ledgedet['type'].'-'.$ledgedet['v_id'];
                if($ledgedet['type']=='Purchase'){
				$voucher='(PV-'.sprintf('%04d', $ledgedet['type_id']).') ';
				}else if($ledgedet['type']=='Sale'){
				$voucher= '(SV-'.sprintf('%04d', $ledgedet['type_id']).') ';
				}else if($ledgedet['type']=='Navigation'){
				$voucher= '(NV-'.sprintf('%04d', $ledgedet['type_id']).') ';
				}
				$str = $ledgedet['narration'];
				if (strpos($str, 'Q') !== false || strpos($str, 'Disc.Rs') !== false || strpos($str, 'Rs') !== false || strpos($str, 'Dr Acc.') !== false || strpos($str, 'Cr Acc.') !== false) {
				   $str=str_replace("Q","Q",$str); 
				   $str=str_replace("Disc.Rs","Disc.Rs",$str); 
				   $str=str_replace("Rs","Rs",$str);
				   $str=str_replace("Dr Acc.","Dr Acc.",$str);
				   $str=str_replace("Cr Acc.","Cr Acc.",$str);
				  $naration= $str;
				}else{
				    $naration= $ledgedet['narration'];
				}
				if($ledgedet['debit'] > 0){ 
				   $debit= number_format($ledgedet['debit'],2);
				    
				}
				if($ledgedet['credit'] > 0){ 
				   $credit= number_format($ledgedet['credit'],2);
				    
				}
				if($balance > 0){ 
				    $drcr= 'Dr';
				    
				}else{ 
				    $drcr= 'Cr'; 
				    
				}
                $dataValus=array($i,date('d-m-Y',strtotime($ledgedet['date'])),  $type,$voucher.' '.$naration,$debit,$credit,number_format($balance,2),$drcr);
                fputcsv($output,$dataValus);
                $i++;
            }
        }
        fclose($output);
        
    }
    
    public function supplier_ledger_filter() {
		$conditions="";
		$account_id=$this->input->post('account_id');
		$group_by='td.coa_id';
		$select="coa.head_name as filter_text,td.coa_id as filter_value";
		
		$start=str_replace('/', '-', $this->input->post('from_date'));
		$end=str_replace('/', '-', $this->input->post('to_date'));
		$date="tm.date between '".date("Y-m-d",strtotime($start))."' AND '".date("Y-m-d",strtotime($end))."'";
		$this->db->select('tm.id,'.$select);
		
		$this->db->from('tbl_transections_details as td');
		
		$this->db->join('tbl_transections_master as tm','tm.id=td.v_id');
		
		$this->db->join('tbl_coa as coa','coa.head_code=td.coa_id');
		
		$this->db->where($date);
		$from = date("Y-m-d",strtotime($start));
		if($account_id!='all'){
		    $this->db->where("td.coa_id",$account_id);
		    $op = $this->db->query("SELECT IFNULL(SUM(b.debit), 0)-IFNULL(SUM(b.credit), 0) as balance from tbl_transections_details as b, tbl_transections_master as a where b.coa_id = '$account_id' AND a.date < '$from' AND a.id = b.v_id")->row()->balance;
		}else{
		    $this->db->like('td.coa_id', '101005', 'both');
		    $op = $this->db->query("SELECT IFNULL(SUM(b.debit), 0)-IFNULL(SUM(b.credit), 0) as balance from tbl_transections_details as b, tbl_transections_master as a where b.coa_id LIKE '%101005%' AND a.date < '$from' AND a.id = b.v_id")->row()->balance;
		}
		
		$this->db->group_by($group_by);
		
	    $ledger=$this->db->get()->result_array();
		
	
		if($ledger){
			foreach($ledger as $key => $ledg){
				$ledgdet=$this->getLedgDetail($ledg['filter_value'],$group_by);
				$ledger[$key]['detail']=$ledgdet;
				$ledger[$key]['opening']=$op;
			}
		}
		
		$data['ledger'] = $ledger;
		$data['from'] = $from;
		$count=count($ledger);
		$html=$this->load->view('accounts/supplier_ledger_filter',$data,true);
		echo json_encode(array("html"=>$html,'count'=>$count));
        
    }
    public function supplier_ledger_filter_csv() {
        $_POST=$_GET;
		$conditions="";
		$account_id=$this->input->post('account_id');
		$group_by='td.coa_id';
		$select="coa.head_name as filter_text,td.coa_id as filter_value";
		
		$start=str_replace('/', '-', $this->input->post('from_date'));
		$end=str_replace('/', '-', $this->input->post('to_date'));
		$date="tm.date between '".date("Y-m-d",strtotime($start))."' AND '".date("Y-m-d",strtotime($end))."'";
		$this->db->select('tm.id,'.$select);
		
		$this->db->from('tbl_transections_details as td');
		
		$this->db->join('tbl_transections_master as tm','tm.id=td.v_id');
		
		$this->db->join('tbl_coa as coa','coa.head_code=td.coa_id');
		
		$this->db->where($date);
		$from = date("Y-m-d",strtotime($start));
		if($account_id!='all'){
		    $this->db->where("td.coa_id",$account_id);
		    $op = $this->db->query("SELECT IFNULL(SUM(b.debit), 0)-IFNULL(SUM(b.credit), 0) as balance from tbl_transections_details as b, tbl_transections_master as a where b.coa_id = '$account_id' AND a.date < '$from' AND a.id = b.v_id")->row()->balance;
		}else{
		    $this->db->like('td.coa_id', '101005', 'both');
		    $op = $this->db->query("SELECT IFNULL(SUM(b.debit), 0)-IFNULL(SUM(b.credit), 0) as balance from tbl_transections_details as b, tbl_transections_master as a where b.coa_id LIKE '%101005%' AND a.date < '$from' AND a.id = b.v_id")->row()->balance;
		}
		
		$this->db->group_by($group_by);
		
	    $ledger=$this->db->get()->result_array();
		
	
		if($ledger){
			foreach($ledger as $key => $ledg){
				$ledgdet=$this->getLedgDetail($ledg['filter_value'],$group_by);
				$ledger[$key]['detail']=$ledgdet;
				$ledger[$key]['opening']=$op;
			}
		}
		
		$data['ledger'] = $ledger;
		$data['from'] = $from;
		
		include_once APPPATH.'/third_party/autoload.php';
		$header_row = array("#", "Voucher Date", "Voucher Number", "Narration" , "Debit", "Credit", "Balance","Dr/Cr");
        $csvName = 'supplierLedger'.'.csv';
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="'.$csvName.'";');
        $output = fopen('php://output', 'w');
        
        fputcsv($output,$header_row);
        $i=1;
        $type="";
        $voucher="";
        $naration="";
        
       
        $drcr="";
        foreach($ledger as $ledge){
            
            $balance=$ledge['opening'];
            foreach($ledge['detail'] as $ledgedet){
                $debit=0;
                $credit=0;
                $balance += $ledgedet['debit']-$ledgedet['credit'];
                $type= $ledgedet['type'].'-'.$ledgedet['v_id'];
                if($ledgedet['type']=='Purchase'){
				$voucher='(PV-'.sprintf('%04d', $ledgedet['type_id']).') ';
				}else if($ledgedet['type']=='Sale'){
				$voucher= '(SV-'.sprintf('%04d', $ledgedet['type_id']).') ';
				}else if($ledgedet['type']=='Navigation'){
				$voucher= '(NV-'.sprintf('%04d', $ledgedet['type_id']).') ';
				}
				$str = $ledgedet['narration'];
				if (strpos($str, 'Q') !== false || strpos($str, 'Disc.Rs') !== false || strpos($str, 'Rs') !== false || strpos($str, 'Dr Acc.') !== false || strpos($str, 'Cr Acc.') !== false) {
				   $str=str_replace("Q","Q",$str); 
				   $str=str_replace("Disc.Rs","Disc.Rs",$str); 
				   $str=str_replace("Rs","Rs",$str);
				   $str=str_replace("Dr Acc.","Dr Acc.",$str);
				   $str=str_replace("Cr Acc.","Cr Acc.",$str);
				  $naration= $str;
				}else{
				    $naration= $ledgedet['narration'];
				}
				if($ledgedet['debit'] > 0){ 
				   $debit= number_format($ledgedet['debit'],2);
				    
				}
				if($ledgedet['credit'] > 0){ 
				   $credit= number_format($ledgedet['credit'],2);
				    
				}
				if($balance > 0){ 
				    $drcr= 'Dr';
				    
				}else{ 
				    $drcr= 'Cr'; 
				    
				}
                $dataValus=array($i,date('d-m-Y',strtotime($ledgedet['date'])),  $type,$voucher.' '.$naration,$debit,$credit,number_format($balance,2),$drcr);
                fputcsv($output,$dataValus);
                $i++;
            }
        }
        fclose($output);
	
        
    }
    
    public function accounts_ledger_filter() {
		$conditions="";
		$account_id=$this->input->post('account_id');
// 		$searchtxt=$this->input->post('searchtxt');
		$group_by='td.coa_id';
		$select="coa.head_name as filter_text,td.coa_id as filter_value";
		
		$start=str_replace('/', '-', $this->input->post('from_date'));
		$end=str_replace('/', '-', $this->input->post('to_date'));
		$date="tm.date between '".date("Y-m-d",strtotime($start))."' AND '".date("Y-m-d",strtotime($end))."'";
		$this->db->select('tm.id,'.$select);
		
		$this->db->from('tbl_transections_details as td');
		
		$this->db->join('tbl_transections_master as tm','tm.id=td.v_id');
		
		$this->db->join('tbl_coa as coa','coa.head_code=td.coa_id');
		
		$this->db->where($date);
		$this->db->where("td.coa_id",$account_id);
		$this->db->where("tm.post_status",0);
// 		if(isset($searchtxt) && !empty($searchtxt)){
// 		    $this->db->group_start();
// 		    $this->db->like('td.narration', $searchtxt);
// 		    $this->db->or_like('td.credit', $searchtxt);
// 		    $this->db->or_like('td.debit', $searchtxt);
// 		    $this->db->or_like("DATE_FORMAT(tm.date,'%d-%m-%Y')", $searchtxt);
// 		    $this->db->or_like("CONCAT(tm.type, ' - ', tm.id)", $searchtxt);
// 		    $this->db->group_end();
// 		}
		
		$this->db->group_by($group_by);
		
	    $ledger=$this->db->get()->result_array();
	
	    $from = date("Y-m-d",strtotime($start));
	    $op = $this->db->query("SELECT IFNULL(SUM(b.debit), 0)-IFNULL(SUM(b.credit), 0) as balance from tbl_transections_details as b, tbl_transections_master as a where b.coa_id = '$account_id' AND a.date < '$from' AND a.id = b.v_id")->row()->balance;
		
		if($ledger){
			foreach($ledger as $key => $ledg){
				$ledgdet=$this->getLedgDetail($ledg['filter_value'],$group_by);
				$ledger[$key]['detail']=$ledgdet;
				$ledger[$key]['opening']=$op;
			}
		}
		
		$data['ledger'] = $ledger;
		$data['from'] = $from;
		$count=count($ledger);
		$html=$this->load->view('accounts/accounts_ledger_filter',$data,true);
		echo json_encode(array("html"=>$html,'count'=>$count));
        
    }
    public function accounts_ledger_filter_csv() {
         $_POST=$_GET;
		$conditions="";
		$account_id=$this->input->post('account_id');
// 		$searchtxt=$this->input->post('searchtxt');
		$group_by='td.coa_id';
		$select="coa.head_name as filter_text,td.coa_id as filter_value";
		
		$start=str_replace('/', '-', $this->input->post('from_date'));
		$end=str_replace('/', '-', $this->input->post('to_date'));
		$date="tm.date between '".date("Y-m-d",strtotime($start))."' AND '".date("Y-m-d",strtotime($end))."'";
		$this->db->select('tm.id,'.$select);
		
		$this->db->from('tbl_transections_details as td');
		
		$this->db->join('tbl_transections_master as tm','tm.id=td.v_id');
		
		$this->db->join('tbl_coa as coa','coa.head_code=td.coa_id');
		
		$this->db->where($date);
		$this->db->where("td.coa_id",$account_id);
		$this->db->where("tm.post_status",0);

		
		
		
		$this->db->group_by($group_by);
		
	    $ledger=$this->db->get()->result_array();
	
	    $from = date("Y-m-d",strtotime($start));
	    $op = $this->db->query("SELECT IFNULL(SUM(b.debit), 0)-IFNULL(SUM(b.credit), 0) as balance from tbl_transections_details as b, tbl_transections_master as a where b.coa_id = '$account_id' AND a.date < '$from' AND a.id = b.v_id")->row()->balance;
		
		if($ledger){
			foreach($ledger as $key => $ledg){
				$ledgdet=$this->getLedgDetail($ledg['filter_value'],$group_by);
				$ledger[$key]['detail']=$ledgdet;
				$ledger[$key]['opening']=$op;
			}
		}
		
		$data['ledger'] = $ledger;
		$data['from'] = $from;
		include_once APPPATH.'/third_party/autoload.php';
		$header_row = array("#", "Voucher Date", "Voucher Number", "Narration" , "Debit", "Credit", "Balance","Dr/Cr");
        $csvName = 'accountLedger'.'.csv';
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="'.$csvName.'";');
        $output = fopen('php://output', 'w');
        
        fputcsv($output,$header_row);
        $i=1;
        $type="";
        $voucher="";
        $naration="";
        
       
        $drcr="";
        foreach($ledger as $ledge){
            
            $balance=$ledge['opening'];
            foreach($ledge['detail'] as $ledgedet){
                $debit=0;
                $credit=0;
                $balance += $ledgedet['debit']-$ledgedet['credit'];
                $type= $ledgedet['type'].'-'.$ledgedet['v_id'];
                if($ledgedet['type']=='Purchase'){
				$voucher='(PV-'.sprintf('%04d', $ledgedet['type_id']).') ';
				}else if($ledgedet['type']=='Sale'){
				$voucher= '(SV-'.sprintf('%04d', $ledgedet['type_id']).') ';
				}else if($ledgedet['type']=='Navigation'){
				$voucher= '(NV-'.sprintf('%04d', $ledgedet['type_id']).') ';
				}
				$str = $ledgedet['narration'];
				if (strpos($str, 'Q') !== false || strpos($str, 'Disc.Rs') !== false || strpos($str, 'Rs') !== false || strpos($str, 'Dr Acc.') !== false || strpos($str, 'Cr Acc.') !== false) {
				   $str=str_replace("Q","Q",$str); 
				   $str=str_replace("Disc.Rs","Disc.Rs",$str); 
				   $str=str_replace("Rs","Rs",$str);
				   $str=str_replace("Dr Acc.","Dr Acc.",$str);
				   $str=str_replace("Cr Acc.","Cr Acc.",$str);
				  $naration= $str;
				}else{
				    $naration= $ledgedet['narration'];
				}
				if($ledgedet['debit'] > 0){ 
				   $debit= number_format($ledgedet['debit'],2);
				    
				}
				if($ledgedet['credit'] > 0){ 
				   $credit= number_format($ledgedet['credit'],2);
				    
				}
				if($balance > 0){ 
				    $drcr= 'Dr';
				    
				}else{ 
				    $drcr= 'Cr'; 
				    
				}
                $dataValus=array($i,date('d-m-Y',strtotime($ledgedet['date'])),  $type,$voucher.' '.$naration,$debit,$credit,number_format($balance,2),$drcr);
                fputcsv($output,$dataValus);
                $i++;
            }
        }
        fclose($output);
        
    }
    public function items_ledger_filter() {
		$conditions="";
		$item_type=$this->input->post('item_type');
		$sitem_type=$this->input->post('sitem_type');
		$shipment_id=$this->input->post('shipment_id');
		
		if($item_type==1){
		    $group_by='pd.fld_product_id';
		    $select="cat.fld_category as filter_text,pd.fld_product_id as filter_value";
		}else{
		    $group_by='pd.fld_subproduct_id';
		    $select="subcat.fld_subcategory as filter_text,pd.fld_subproduct_id as filter_value";
		}
		
		
		$this->db->select($select);
		
		$this->db->from('tbl_purchase_detail as pd');
		
		$this->db->join('tbl_purchase','tbl_purchase.fld_id=pd.fld_purchase_id');
		
		if($item_type==1){
		    $this->db->join('tbl_category as cat','cat.fld_id=pd.fld_product_id');
		}else{
		    $this->db->join('tbl_subcategory as subcat','subcat.fld_subcid=pd.fld_subproduct_id');
		}
		
		
		if($item_type==1){
		    $this->db->where("pd.fld_product_id",$item_type);
		}else{
		    if($sitem_type=='all'){
		        $this->db->where("pd.fld_product_id",$item_type);
		    }else{
		         $this->db->where("pd.fld_subproduct_id",$sitem_type);
		    }
		   
		}
		$this->db->where("tbl_purchase.fld_shipment",$shipment_id);
	
		
		
		
		$this->db->group_by($group_by);
		
	    $ledger=$this->db->get()->result_array();
	    
	    
		
	
		if($ledger){
			foreach($ledger as $key => $ledg){
			    $ledgerDetailArray = array();
				$purchase = $this->getPurchseLedgDetail($ledg['filter_value'], $group_by, $shipment_id);
				$navigation = $this->getNavLedgDetail($ledg['filter_value'], $group_by, $shipment_id);
				$sale = $this->getSaleLedgDetail($ledg['filter_value'], $group_by, $shipment_id);
				foreach($purchase as $purchsedet){
				    $ledgerDetail = array();
				    $ledgerDetail['vr_no'] = $purchsedet['fld_voucher_no'];
				    $ledgerDetail['date'] =  $purchsedet['fld_purchase_date'];
				    $ledgerDetail['account'] =  explode('/', $purchsedet['fld_shipment'])[0].'/'. explode('/', $purchsedet['fld_shipment'])[1];
				    $ledgerDetail['remarks'] =  '-';
				    $ledgerDetail['fld_shipment'] =  $purchsedet['fld_shipment'];
				    $ledgerDetail['location'] =  $purchsedet['fld_location'];
				    $ledgerDetail['qty_in'] =  0;
				    
				    if($purchsedet['fld_product_id']==1){
				        $ledgerDetail['weight_in'] =  $purchsedet['fld_quantity']*1000;
				    }else{
				        $ledgerDetail['weight_in'] =  0;
				    }
				    
				    $ledgerDetail['qty_out'] =  0;
				    $ledgerDetail['weight_out'] =  0;
				    
				    
				    $ledgerDetail['created'] = $purchsedet['fld_created_date'];
				    $ledgerDetailArray[]=$ledgerDetail;
				    
				    
				}
				
			    foreach($navigation as $navdet){
				    $ledgerDetail = array();
				    $ledgerDetail['vr_no'] = sprintf(' NV-%04d ', $navdet['fld_id']);
				    $ledgerDetail['date'] =  $navdet['fld_date'];
				    $ledgerDetail['account'] =  '-';
				    $ledgerDetail['remarks'] =  $navdet['fld_remarks'];
				    $ledgerDetail['location'] =  $this->db->query("select * from tbl_locations where fld_id = '{$navdet['fld_location_from']}'")->row()->fld_location;
				    $ledgerDetail['qty_in'] =  0;
				    $ledgerDetail['qty_out'] =  0;
				    
				    if($navdet['fld_product_id']==1){
				        $ledgerDetail['weight_out'] =  $navdet['fld_qty']*1000;
				    }else{
				        $ledgerDetail['weight_out'] =  0;
				    }
				    
				    
				    $ledgerDetail['weight_in'] =  0;
				    
				    
				    $ledgerDetail['created'] = $navdet['fld_created_date'];
				    $ledgerDetailArray[]=$ledgerDetail;
				    
				    
				}
				
				foreach($navigation as $navdet){
				    $ledgerDetail = array();
				    $ledgerDetail['vr_no'] = sprintf(' NV-%04d ', $navdet['fld_id']);
				    $ledgerDetail['date'] =  $navdet['fld_date'];
				    $ledgerDetail['account'] =  '-';
				    $ledgerDetail['remarks'] =  $navdet['fld_remarks'];
				    $ledgerDetail['location'] =  $this->db->query("select * from tbl_locations where fld_id = '{$navdet['fld_location_to']}'")->row()->fld_location;
				    $ledgerDetail['qty_out'] =  0;
				    $ledgerDetail['qty_in'] =  0;
				    
				    if($navdet['fld_product_id']==1){
				        $ledgerDetail['weight_in'] =  $navdet['fld_qty']*1000;
				    }else{
				        $ledgerDetail['weight_in'] =  0;
				    }
				    
				    
				    $ledgerDetail['weight_out'] =  0;
				    
				    
				    $ledgerDetail['created'] = $navdet['fld_created_date'];
				    $ledgerDetailArray[]=$ledgerDetail;
				    
				    
				}
				
				foreach($sale as $saledet){
				    $ledgerDetail = array();
				    $ledgerDetail['vr_no'] = $saledet['fld_voucher_no'];
				    $ledgerDetail['date'] =  $saledet['fld_sale_date'];
				    $ledgerDetail['account'] =  $saledet['fld_company_name'];
				    $ledgerDetail['remarks'] =  $this->db->select('*')->from('tbl_subcategory')->where('fld_subcid', $saledet['fld_subproduct_id'])->get()->row()->fld_subcategory;
				    $ledgerDetail['location'] =  $saledet['fld_location'];
				    $ledgerDetail['qty_in'] =  0;
				    
				    if($saledet['fld_product_id']==1){
				        $ledgerDetail['weight_out'] =  $saledet['fld_weight'];
				        $ledgerDetail['qty_out'] =  $saledet['fld_quantity'];
				    }else{
				        $ledgerDetail['weight_out'] =  0;
				        $ledgerDetail['qty_out'] =  $saledet['fld_quantity'];
				    }
				    
				    
				    $ledgerDetail['weight_in'] =  0;
				    
				    
				    $ledgerDetail['created'] = $saledet['fld_created_date'];
				    $ledgerDetailArray[]=$ledgerDetail;
				    
				    
				}
				array_multisort(array_map('strtotime',array_column($ledgerDetailArray,'created')),
                SORT_ASC,
                array_column($ledgerDetailArray,'weight_in'), SORT_ASC,
                $ledgerDetailArray);
                
                
				$ledger[$key]['detail']=$ledgerDetailArray;
			}
		}
		
// 		print_r($ledger);
// 	    exit();
		
		$data['ledger'] = $ledger;
		$count=count($ledger);
		$html=$this->load->view('accounts/items_ledger_filter',$data,true);
		echo json_encode(array("html"=>$html,'count'=>$count));
        
    }
    
    public function items_ledger_print() {
		$conditions="";
		$item_type=$this->input->get('item_type');
		$sitem_type=$this->input->get('sitem_type');
		$shipment_id=$this->input->get('shipment_id');
		
		if($item_type==1){
		    $group_by='pd.fld_product_id';
		    $select="cat.fld_category as filter_text,pd.fld_product_id as filter_value";
		}else{
		    $group_by='pd.fld_subproduct_id';
		    $select="subcat.fld_subcategory as filter_text,pd.fld_subproduct_id as filter_value";
		}
		
		
		$this->db->select($select);
		
		$this->db->from('tbl_purchase_detail as pd');
		
		$this->db->join('tbl_purchase','tbl_purchase.fld_id=pd.fld_purchase_id');
		
		if($item_type==1){
		    $this->db->join('tbl_category as cat','cat.fld_id=pd.fld_product_id');
		}else{
		    $this->db->join('tbl_subcategory as subcat','subcat.fld_subcid=pd.fld_subproduct_id');
		}
		
		
		if($item_type==1){
		    $this->db->where("pd.fld_product_id",$item_type);
		}else{
		    if($sitem_type=='all'){
		        $this->db->where("pd.fld_product_id",$item_type);
		    }else{
		         $this->db->where("pd.fld_subproduct_id",$sitem_type);
		    }
		   
		}
		$this->db->where("tbl_purchase.fld_shipment",$shipment_id);
		$this->db->group_by($group_by);
		
	    $ledger=$this->db->get()->result_array();
	    
	    
		
	
		if($ledger){
			foreach($ledger as $key => $ledg){
			    $ledgerDetailArray = array();
				$purchase = $this->getPurchseLedgDetail($ledg['filter_value'], $group_by, $shipment_id);
				$navigation = $this->getNavLedgDetail($ledg['filter_value'], $group_by, $shipment_id);
				$sale = $this->getSaleLedgDetail($ledg['filter_value'], $group_by, $shipment_id);
				foreach($purchase as $purchsedet){
				    $ledgerDetail = array();
				    $ledgerDetail['vr_no'] = $purchsedet['fld_voucher_no'];
				    $ledgerDetail['date'] =  $purchsedet['fld_purchase_date'];
				    $ledgerDetail['account'] =  explode('/', $purchsedet['fld_shipment'])[0].'/'. explode('/', $purchsedet['fld_shipment'])[1];
				    $ledgerDetail['remarks'] =  '-';
				    $ledgerDetail['fld_shipment'] =  $purchsedet['fld_shipment'];
				    $ledgerDetail['location'] =  $purchsedet['fld_location'];
				    $ledgerDetail['qty_in'] =  0;
				    
				    if($purchsedet['fld_product_id']==1){
				        $ledgerDetail['weight_in'] =  $purchsedet['fld_quantity']*1000;
				    }else{
				        $ledgerDetail['weight_in'] =  0;
				    }
				    
				    $ledgerDetail['qty_out'] =  0;
				    $ledgerDetail['weight_out'] =  0;
				    
				    
				    $ledgerDetail['created'] = $purchsedet['fld_created_date'];
				    $ledgerDetailArray[]=$ledgerDetail;
				    
				    
				}
				
			    foreach($navigation as $navdet){
				    $ledgerDetail = array();
				    $ledgerDetail['vr_no'] = sprintf(' NV-%04d ', $navdet['fld_id']);
				    $ledgerDetail['date'] =  $navdet['fld_date'];
				    $ledgerDetail['account'] =  '-';
				    $ledgerDetail['remarks'] =  $navdet['fld_remarks'];
				    $ledgerDetail['location'] =  $this->db->query("select * from tbl_locations where fld_id = '{$navdet['fld_location_from']}'")->row()->fld_location;
				    $ledgerDetail['qty_in'] =  0;
				    $ledgerDetail['qty_out'] =  0;
				    
				    if($navdet['fld_product_id']==1){
				        $ledgerDetail['weight_out'] =  $navdet['fld_qty']*1000;
				    }else{
				        $ledgerDetail['weight_out'] =  0;
				    }
				    
				    
				    $ledgerDetail['weight_in'] =  0;
				    
				    
				    $ledgerDetail['created'] = $navdet['fld_created_date'];
				    $ledgerDetailArray[]=$ledgerDetail;
				    
				    
				}
				
				foreach($navigation as $navdet){
				    $ledgerDetail = array();
				    $ledgerDetail['vr_no'] = sprintf(' NV-%04d ', $navdet['fld_id']);
				    $ledgerDetail['date'] =  $navdet['fld_date'];
				    $ledgerDetail['account'] =  '-';
				    $ledgerDetail['remarks'] =  $navdet['fld_remarks'];
				    $ledgerDetail['location'] =  $this->db->query("select * from tbl_locations where fld_id = '{$navdet['fld_location_to']}'")->row()->fld_location;
				    $ledgerDetail['qty_out'] =  0;
				    $ledgerDetail['qty_in'] =  0;
				    
				    if($navdet['fld_product_id']==1){
				        $ledgerDetail['weight_in'] =  $navdet['fld_qty']*1000;
				    }else{
				        $ledgerDetail['weight_in'] =  0;
				    }
				    
				    
				    $ledgerDetail['weight_out'] =  0;
				    
				    
				    $ledgerDetail['created'] = $navdet['fld_created_date'];
				    $ledgerDetailArray[]=$ledgerDetail;
				    
				    
				}
				
				foreach($sale as $saledet){
				    $ledgerDetail = array();
				    $ledgerDetail['vr_no'] = $saledet['fld_voucher_no'];
				    $ledgerDetail['date'] =  $saledet['fld_sale_date'];
				    $ledgerDetail['account'] =  $saledet['fld_company_name'];
				    $ledgerDetail['remarks'] =  $this->db->select('*')->from('tbl_subcategory')->where('fld_subcid', $saledet['fld_subproduct_id'])->get()->row()->fld_subcategory;
				    $ledgerDetail['location'] =  $saledet['fld_location'];
				    $ledgerDetail['qty_in'] =  0;
				    
				    if($saledet['fld_product_id']==1){
				        $ledgerDetail['weight_out'] =  $saledet['fld_weight'];
				        $ledgerDetail['qty_out'] =  $saledet['fld_quantity'];
				    }else{
				        $ledgerDetail['weight_out'] =  0;
				        $ledgerDetail['qty_out'] =  $saledet['fld_quantity'];
				    }
				    
				    
				    $ledgerDetail['weight_in'] =  0;
				    
				    
				    $ledgerDetail['created'] = $saledet['fld_created_date'];
				    $ledgerDetailArray[]=$ledgerDetail;
				    
				    
				}
				array_multisort(array_map('strtotime',array_column($ledgerDetailArray,'created')),
                SORT_ASC,
                array_column($ledgerDetailArray,'weight_in'), SORT_ASC,
                $ledgerDetailArray);
                
                
				$ledger[$key]['detail']=$ledgerDetailArray;
			}
		}
		
// 		print_r($ledger);
// 	    exit();
		
		$data['ledger'] = $ledger;
		$count=count($ledger);
		$this->load->view('accounts/items_ledger_print', $data);
        
    }
    public function items_ledger_pdf() {
		$conditions="";
		$item_type=$this->input->get('item_type');
		$sitem_type=$this->input->get('sitem_type');
		$shipment_id=$this->input->get('shipment_id');
		
		if($item_type==1){
		    $group_by='pd.fld_product_id';
		    $select="cat.fld_category as filter_text,pd.fld_product_id as filter_value";
		}else{
		    $group_by='pd.fld_subproduct_id';
		    $select="subcat.fld_subcategory as filter_text,pd.fld_subproduct_id as filter_value";
		}
		
		
		$this->db->select($select);
		
		$this->db->from('tbl_purchase_detail as pd');
		
		$this->db->join('tbl_purchase','tbl_purchase.fld_id=pd.fld_purchase_id');
		
		if($item_type==1){
		    $this->db->join('tbl_category as cat','cat.fld_id=pd.fld_product_id');
		}else{
		    $this->db->join('tbl_subcategory as subcat','subcat.fld_subcid=pd.fld_subproduct_id');
		}
		
		
		if($item_type==1){
		    $this->db->where("pd.fld_product_id",$item_type);
		}else{
		    if($sitem_type=='all'){
		        $this->db->where("pd.fld_product_id",$item_type);
		    }else{
		         $this->db->where("pd.fld_subproduct_id",$sitem_type);
		    }
		   
		}
		$this->db->where("tbl_purchase.fld_shipment",$shipment_id);
	
		
		
		
		$this->db->group_by($group_by);
		
	    $ledger=$this->db->get()->result_array();
	    
	    
		
	
		if($ledger){
			foreach($ledger as $key => $ledg){
			    $ledgerDetailArray = array();
				$purchase = $this->getPurchseLedgDetail($ledg['filter_value'], $group_by, $shipment_id);
				$navigation = $this->getNavLedgDetail($ledg['filter_value'], $group_by, $shipment_id);
				$sale = $this->getSaleLedgDetail($ledg['filter_value'], $group_by, $shipment_id);
				foreach($purchase as $purchsedet){
				    $ledgerDetail = array();
				    $ledgerDetail['vr_no'] = $purchsedet['fld_voucher_no'];
				    $ledgerDetail['date'] =  $purchsedet['fld_purchase_date'];
				    $ledgerDetail['account'] =  explode('/', $purchsedet['fld_shipment'])[0].'/'. explode('/', $purchsedet['fld_shipment'])[1];
				    $ledgerDetail['remarks'] =  '-';
				    $ledgerDetail['fld_shipment'] =  $purchsedet['fld_shipment'];
				    $ledgerDetail['location'] =  $purchsedet['fld_location'];
				    $ledgerDetail['qty_in'] =  0;
				    
				    if($purchsedet['fld_product_id']==1){
				        $ledgerDetail['weight_in'] =  $purchsedet['fld_quantity']*1000;
				    }else{
				        $ledgerDetail['weight_in'] =  0;
				    }
				    
				    $ledgerDetail['qty_out'] =  0;
				    $ledgerDetail['weight_out'] =  0;
				    
				    
				    $ledgerDetail['created'] = $purchsedet['fld_created_date'];
				    $ledgerDetailArray[]=$ledgerDetail;
				    
				    
				}
				
			    foreach($navigation as $navdet){
				    $ledgerDetail = array();
				    $ledgerDetail['vr_no'] = sprintf(' NV-%04d ', $navdet['fld_id']);
				    $ledgerDetail['date'] =  $navdet['fld_date'];
				    $ledgerDetail['account'] =  '-';
				    $ledgerDetail['remarks'] =  $navdet['fld_remarks'];
				    $ledgerDetail['location'] =  $this->db->query("select * from tbl_locations where fld_id = '{$navdet['fld_location_from']}'")->row()->fld_location;
				    $ledgerDetail['qty_in'] =  0;
				    $ledgerDetail['qty_out'] =  0;
				    
				    if($navdet['fld_product_id']==1){
				        $ledgerDetail['weight_out'] =  $navdet['fld_qty']*1000;
				    }else{
				        $ledgerDetail['weight_out'] =  0;
				    }
				    
				    
				    $ledgerDetail['weight_in'] =  0;
				    
				    
				    $ledgerDetail['created'] = $navdet['fld_created_date'];
				    $ledgerDetailArray[]=$ledgerDetail;
				    
				    
				}
				
				foreach($navigation as $navdet){
				    $ledgerDetail = array();
				    $ledgerDetail['vr_no'] = sprintf(' NV-%04d ', $navdet['fld_id']);
				    $ledgerDetail['date'] =  $navdet['fld_date'];
				    $ledgerDetail['account'] =  '-';
				    $ledgerDetail['remarks'] =  $navdet['fld_remarks'];
				    $ledgerDetail['location'] =  $this->db->query("select * from tbl_locations where fld_id = '{$navdet['fld_location_to']}'")->row()->fld_location;
				    $ledgerDetail['qty_out'] =  0;
				    $ledgerDetail['qty_in'] =  0;
				    
				    if($navdet['fld_product_id']==1){
				        $ledgerDetail['weight_in'] =  $navdet['fld_qty']*1000;
				    }else{
				        $ledgerDetail['weight_in'] =  0;
				    }
				    
				    
				    $ledgerDetail['weight_out'] =  0;
				    
				    
				    $ledgerDetail['created'] = $navdet['fld_created_date'];
				    $ledgerDetailArray[]=$ledgerDetail;
				    
				    
				}
				
				foreach($sale as $saledet){
				    $ledgerDetail = array();
				    $ledgerDetail['vr_no'] = $saledet['fld_voucher_no'];
				    $ledgerDetail['date'] =  $saledet['fld_sale_date'];
				    $ledgerDetail['account'] =  $saledet['fld_company_name'];
				    $ledgerDetail['remarks'] =  $this->db->select('*')->from('tbl_subcategory')->where('fld_subcid', $saledet['fld_subproduct_id'])->get()->row()->fld_subcategory;
				    $ledgerDetail['location'] =  $saledet['fld_location'];
				    $ledgerDetail['qty_in'] =  0;
				    
				    if($saledet['fld_product_id']==1){
				        $ledgerDetail['weight_out'] =  $saledet['fld_weight'];
				        $ledgerDetail['qty_out'] =  $saledet['fld_quantity'];
				    }else{
				        $ledgerDetail['weight_out'] =  0;
				        $ledgerDetail['qty_out'] =  $saledet['fld_quantity'];
				    }
				    
				    
				    $ledgerDetail['weight_in'] =  0;
				    
				    
				    $ledgerDetail['created'] = $saledet['fld_created_date'];
				    $ledgerDetailArray[]=$ledgerDetail;
				    
				    
				}
				array_multisort(array_map('strtotime',array_column($ledgerDetailArray,'created')),
                SORT_ASC,
                array_column($ledgerDetailArray,'weight_in'), SORT_ASC,
                $ledgerDetailArray);
                
                
				$ledger[$key]['detail']=$ledgerDetailArray;
			}
		}
		
// 		print_r($ledger);
// 	    exit();
		
		$data['ledger'] = $ledger;
		include_once APPPATH.'/third_party/autoload.php';
	    $mpdf = new \Mpdf\Mpdf();
		$count=count($ledger);
		 $html = $this->load->view('accounts/items_ledger_pdf',$data,true);
	    $mpdf->WriteHTML($html);
		$mpdf->Output('Items Report.pdf','D');
        
    }
    
    
    
    public function customer_ledger_print(){
        $_POST = $_GET;
	    $conditions="";
		$account_id=$this->input->get('account_id');
		$group_by='td.coa_id';
		$select="coa.head_name as filter_text,td.coa_id as filter_value";
		
		$start=str_replace('/', '-', $this->input->get('from_date'));
		$end=str_replace('/', '-', $this->input->get('to_date'));
		$date="tm.date between '".date("Y-m-d",strtotime($start))."' AND '".date("Y-m-d",strtotime($end))."'";
		$this->db->select('tm.id,'.$select);
		
		$this->db->from('tbl_transections_details as td');
		
		$this->db->join('tbl_transections_master as tm','tm.id=td.v_id');
		
		$this->db->join('tbl_coa as coa','coa.head_code=td.coa_id');
		
		$this->db->where($date);
		$from = date("Y-m-d",strtotime($start));
		if($account_id!='all'){
		    $this->db->where("td.coa_id",$account_id);
		    $op = $this->db->query("SELECT IFNULL(SUM(b.debit), 0)-IFNULL(SUM(b.credit), 0) as balance from tbl_transections_details as b, tbl_transections_master as a where b.coa_id = '$account_id' AND a.date < '$from' AND a.id = b.v_id")->row()->balance;
		}else{
		    $this->db->like('td.coa_id', '101007', 'both');
		    $op = $this->db->query("SELECT IFNULL(SUM(b.debit), 0)-IFNULL(SUM(b.credit), 0) as balance from tbl_transections_details as b, tbl_transections_master as a where b.coa_id LIKE '%101007%' AND a.date < '$from' AND a.id = b.v_id")->row()->balance;
		}
		
		$this->db->group_by($group_by);
		
	    $ledger=$this->db->get()->result_array();
		
	
		if($ledger){
			foreach($ledger as $key => $ledg){
				$ledgdet=$this->getLedgDetail($ledg['filter_value'],$group_by);
				$ledger[$key]['detail']=$ledgdet;
				$ledger[$key]['opening']=$op;
			}
		}
		
		$data['ledger'] = $ledger;
		$data['from'] = $from;
	    $this->load->view('accounts/customer_ledger_print', $data);
	}
	public function customer_ledger_pdf(){
	    $_POST = $_GET;
	    include_once APPPATH.'/third_party/autoload.php';
	    $mpdf = new \Mpdf\Mpdf();
	    $conditions="";
		$account_id=$this->input->get('account_id');
		$group_by='td.coa_id';
		$select="coa.head_name as filter_text,td.coa_id as filter_value";
		
		$start=str_replace('/', '-', $this->input->get('from_date'));
		$end=str_replace('/', '-', $this->input->get('to_date'));
		$date="tm.date between '".date("Y-m-d",strtotime($start))."' AND '".date("Y-m-d",strtotime($end))."'";
		$this->db->select('tm.id,'.$select);
		
		$this->db->from('tbl_transections_details as td');
		
		$this->db->join('tbl_transections_master as tm','tm.id=td.v_id');
		
		$this->db->join('tbl_coa as coa','coa.head_code=td.coa_id');
		
		$this->db->where($date);
		$from = date("Y-m-d",strtotime($start));
		$to = date("Y-m-d",strtotime($end));
		if($account_id!='all'){
		    $account_name = $this->db->query("select * from tbl_coa where head_code ='$account_id'")->row()->head_name;
		    $this->db->where("td.coa_id",$account_id);
		    $op = $this->db->query("SELECT IFNULL(SUM(b.debit), 0)-IFNULL(SUM(b.credit), 0) as balance from tbl_transections_details as b, tbl_transections_master as a where b.coa_id = '$account_id' AND a.date < '$from' AND a.id = b.v_id")->row()->balance;
		}else{
		    $account_name='All';
		    $this->db->like('td.coa_id', '101007', 'both');
		    $op = $this->db->query("SELECT IFNULL(SUM(b.debit), 0)-IFNULL(SUM(b.credit), 0) as balance from tbl_transections_details as b, tbl_transections_master as a where b.coa_id LIKE '%101007%' AND a.date < '$from' AND a.id = b.v_id")->row()->balance;
		}
		
		$this->db->group_by($group_by);
		
	    $ledger=$this->db->get()->result_array();
		
	
		if($ledger){
			foreach($ledger as $key => $ledg){
				$ledgdet=$this->getLedgDetail($ledg['filter_value'],$group_by);
				$ledger[$key]['detail']=$ledgdet;
				$ledger[$key]['opening']=$op;
			}
		}
		
		$data['ledger'] = $ledger;
		$data['from'] = $from;
		$data['to'] = $to;
	    $html = $this->load->view('accounts/customer_ledger_pdf',$data,true);
	    $mpdf->WriteHTML($html);
			$mpdf->Output('Customer ledger.'.$account_name.'-'.$from.'to'.$to.'.pdf','D');
	}
	
	public function supplier_ledger_print(){
	    $_POST = $_GET;
	    $conditions="";
		$account_id=$this->input->get('account_id');
		$group_by='td.coa_id';
		$select="coa.head_name as filter_text,td.coa_id as filter_value";
		
		$start=str_replace('/', '-', $this->input->get('from_date'));
		$end=str_replace('/', '-', $this->input->get('to_date'));
		$date="tm.date between '".date("Y-m-d",strtotime($start))."' AND '".date("Y-m-d",strtotime($end))."'";
		$this->db->select('tm.id,'.$select);
		
		$this->db->from('tbl_transections_details as td');
		
		$this->db->join('tbl_transections_master as tm','tm.id=td.v_id');
		
		$this->db->join('tbl_coa as coa','coa.head_code=td.coa_id');
		
		$this->db->where($date);
		
		$from = date("Y-m-d",strtotime($start));
		if($account_id!='all'){
		    $this->db->where("td.coa_id",$account_id);
		    $op = $this->db->query("SELECT IFNULL(SUM(b.debit), 0)-IFNULL(SUM(b.credit), 0) as balance from tbl_transections_details as b, tbl_transections_master as a where b.coa_id = '$account_id' AND a.date < '$from' AND a.id = b.v_id")->row()->balance;
		}else{
		    $this->db->like('td.coa_id', '101005', 'both');
		    $op = $this->db->query("SELECT IFNULL(SUM(b.debit), 0)-IFNULL(SUM(b.credit), 0) as balance from tbl_transections_details as b, tbl_transections_master as a where b.coa_id LIKE '%101005%' AND a.date < '$from' AND a.id = b.v_id")->row()->balance;
		}
		
		$this->db->group_by($group_by);
		
	    $ledger=$this->db->get()->result_array();
		
	
		if($ledger){
			foreach($ledger as $key => $ledg){
				$ledgdet=$this->getLedgDetail($ledg['filter_value'],$group_by);
				$ledger[$key]['detail']=$ledgdet;
				$ledger[$key]['opening']=$op;
			}
		}
		
		$data['ledger'] = $ledger;
		$data['from'] = $from;
	    $this->load->view('accounts/supplier_ledger_print', $data);
	}
	public function supplier_ledger_pdf(){
	    $_POST = $_GET;
	    include_once APPPATH.'/third_party/autoload.php';
	    $mpdf = new \Mpdf\Mpdf();
	    $conditions="";
		$account_id=$this->input->get('account_id');
		$group_by='td.coa_id';
		$select="coa.head_name as filter_text,td.coa_id as filter_value";
		
		$start=str_replace('/', '-', $this->input->get('from_date'));
		$end=str_replace('/', '-', $this->input->get('to_date'));
		$date="tm.date between '".date("Y-m-d",strtotime($start))."' AND '".date("Y-m-d",strtotime($end))."'";
		$this->db->select('tm.id,'.$select);
		
		$this->db->from('tbl_transections_details as td');
		
		$this->db->join('tbl_transections_master as tm','tm.id=td.v_id');
		
		$this->db->join('tbl_coa as coa','coa.head_code=td.coa_id');
		
		$this->db->where($date);
		
		$from = date("Y-m-d",strtotime($start));
		$to = date("Y-m-d",strtotime($end));
		if($account_id!='all'){
		    $account_name = $this->db->query("select * from tbl_coa where head_code ='$account_id'")->row()->head_name;
		    $this->db->where("td.coa_id",$account_id);
		    $op = $this->db->query("SELECT IFNULL(SUM(b.debit), 0)-IFNULL(SUM(b.credit), 0) as balance from tbl_transections_details as b, tbl_transections_master as a where b.coa_id = '$account_id' AND a.date < '$from' AND a.id = b.v_id")->row()->balance;
		}else{
		    $account_name='All';
		    $this->db->like('td.coa_id', '101005', 'both');
		    $op = $this->db->query("SELECT IFNULL(SUM(b.debit), 0)-IFNULL(SUM(b.credit), 0) as balance from tbl_transections_details as b, tbl_transections_master as a where b.coa_id LIKE '%101005%' AND a.date < '$from' AND a.id = b.v_id")->row()->balance;
		}
		
		$this->db->group_by($group_by);
		
	    $ledger=$this->db->get()->result_array();
		
	
		if($ledger){
			foreach($ledger as $key => $ledg){
				$ledgdet=$this->getLedgDetail($ledg['filter_value'],$group_by);
				$ledger[$key]['detail']=$ledgdet;
				$ledger[$key]['opening']=$op;
			}
		}
		
		$data['ledger'] = $ledger;
		$data['from'] = $from;
		$data['to'] = $to;
	    $html = $this->load->view('accounts/supplier_ledger_pdf',$data,true);
	    $mpdf->WriteHTML($html);
		$mpdf->Output('Supplier ledger.'.$account_name.'-'.$from.'to'.$to.'.pdf','D');
	}
    
    public function accounts_ledger_print(){
        $_POST = $_GET;
	    $conditions="";
		$account_id=$this->input->get('account_id');
		$group_by='td.coa_id';
		$select="coa.head_name as filter_text,td.coa_id as filter_value";
		
		$start=str_replace('/', '-', $this->input->get('from_date'));
		$end=str_replace('/', '-', $this->input->get('to_date'));
		$date="tm.date between '".date("Y-m-d",strtotime($start))."' AND '".date("Y-m-d",strtotime($end))."'";
		$this->db->select('tm.id,'.$select);
		
		$this->db->from('tbl_transections_details as td');
		
		$this->db->join('tbl_transections_master as tm','tm.id=td.v_id');
		
		$this->db->join('tbl_coa as coa','coa.head_code=td.coa_id');
		
		$this->db->where($date);
		
	
		$this->db->where("td.coa_id",$account_id);
		
		$this->db->group_by($group_by);
		
	    $ledger=$this->db->get()->result_array();
		
	
		$from = date("Y-m-d",strtotime($start));
	    $op = $this->db->query("SELECT IFNULL(SUM(b.debit), 0)-IFNULL(SUM(b.credit), 0) as balance from tbl_transections_details as b, tbl_transections_master as a where b.coa_id = '$account_id' AND a.date < '$from' AND a.id = b.v_id")->row()->balance;
		if($ledger){
			foreach($ledger as $key => $ledg){
				$ledgdet=$this->getLedgDetail($ledg['filter_value'],$group_by);
				$ledger[$key]['detail']=$ledgdet;
				$ledger[$key]['opening']=$op;
			}
		}
		
		$data['ledger'] = $ledger;
		$data['from']   =   $from;
	    $this->load->view('accounts/accounts_ledger_print', $data);
	}
	public function accounts_ledger_pdf(){
	    $_POST = $_GET;
	    include_once APPPATH.'/third_party/autoload.php';
	    $mpdf = new \Mpdf\Mpdf();
	    $conditions="";
		$account_id=$this->input->get('account_id');
		$group_by='td.coa_id';
		$select="coa.head_name as filter_text,td.coa_id as filter_value";
		
		$start=str_replace('/', '-', $this->input->get('from_date'));
		$end=str_replace('/', '-', $this->input->get('to_date'));
		$date="tm.date between '".date("Y-m-d",strtotime($start))."' AND '".date("Y-m-d",strtotime($end))."'";
		$this->db->select('tm.id,'.$select);
		
		$this->db->from('tbl_transections_details as td');
		
		$this->db->join('tbl_transections_master as tm','tm.id=td.v_id');
		
		$this->db->join('tbl_coa as coa','coa.head_code=td.coa_id');
		
		$this->db->where($date);
		
		
		$this->db->where("td.coa_id",$account_id);
	
		
		$this->db->group_by($group_by);
		
	    $ledger=$this->db->get()->result_array();
		$from = date("Y-m-d",strtotime($start));
	    $op = $this->db->query("SELECT IFNULL(SUM(b.debit), 0)-IFNULL(SUM(b.credit), 0) as balance from tbl_transections_details as b, tbl_transections_master as a where b.coa_id = '$account_id' AND a.date < '$from' AND a.id = b.v_id")->row()->balance;
		if($ledger){
			foreach($ledger as $key => $ledg){
				$ledgdet=$this->getLedgDetail($ledg['filter_value'],$group_by);
				$ledger[$key]['detail']=$ledgdet;
				$ledger[$key]['opening']=$op;
			}
		}
		
		
		
		$data['ledger'] = $ledger;
		$data['from']   =   $from;
	    $html = $this->load->view('accounts/accounts_ledger_pdf',$data,true);
	    $mpdf->WriteHTML($html);
		$mpdf->Output('Accounts Report.pdf','D');
	}
	
    function getLedgDetail($id,$group_by){
        
        // $searchtxt = $this->input->post('searchtxt');
        $start=str_replace('/', '-', $this->input->post('from_date'));
		$end=str_replace('/', '-', $this->input->post('to_date'));
// 		$likeQuery = '';
// 		if(isset($searchtxt) && !empty($searchtxt)){
// 		    $likeQuery .= "&& (td.narration LIKE '%$searchtxt%' || td.credit LIKE '%$searchtxt%' || td.debit LIKE '%$searchtxt%' || DATE_FORMAT(tm.date,'%d-%m-%Y') LIKE '%$searchtxt%' || CONCAT(tm.type, ' - ', tm.id) LIKE '%$searchtxt%')";
// 		}
		
		$date="&& tm.date between '".date("Y-m-d",strtotime($start))."' AND '".date("Y-m-d",strtotime($end))."'";
	    return $this->db->query("SELECT td.*, tm.type, tm.type_id, tm.date FROM tbl_transections_details AS td JOIN tbl_transections_master AS tm ON tm.id=td.v_id AND $group_by = '$id' AND tm.post_status = 0 $date ORDER BY tm.date, td.id")->result_array();
    
        
    }
    
    function getPurchseLedgDetail($id, $group_by, $shipment_id){
	    $this->db->select('tbl_purchase.*,tbl_suppliers.fld_supplier_code,tbl_suppliers.fld_company_name,tbl_suppliers.fld_supplier_name,tbl_locations.fld_location,pd.fld_product_id,pd.fld_subproduct_id,pd.fld_quantity');
        $this->db->from('tbl_purchase');
        $this->db->join('tbl_purchase_detail as pd','pd.fld_purchase_id=tbl_purchase.fld_id');
        $this->db->join('tbl_suppliers','tbl_suppliers.fld_id=tbl_purchase.fld_supplier_id');
        $this->db->join('tbl_locations','tbl_locations.fld_id=tbl_purchase.fld_location_id');
        $this->db->where('tbl_purchase.fld_isdeleted',0);
        $this->db->where($group_by,$id);
		$this->db->where("tbl_purchase.fld_shipment",$shipment_id);
        return $this->db->get()->result_array();
    }
    
    function getNavLedgDetail($id, $group_by, $shipment_id){
	    $this->db->select('nd.*, tbl_navigations.fld_remarks, tbl_navigations.fld_date, tbl_navigations.fld_location_from, tbl_navigations.fld_location_to, tbl_navigations.fld_created_date, tbl_navigations.fld_id');
        $this->db->from('tbl_navigations_details as nd');
        $this->db->join('tbl_navigations','tbl_navigations.fld_id=nd.fld_navigation_id');
        $this->db->where('tbl_navigations.fld_isdeleted',0);
        if($group_by == 'pd.fld_product_id'){
            $group_by = 'nd.fld_product_id';
        }else if($group_by == 'pd.fld_subproduct_id'){
            $group_by = 'nd.fld_subproduct_id';
        }
        $this->db->where($group_by,$id);
		$this->db->where("nd.fld_shipment_from",$shipment_id);
        return $this->db->get()->result_array();
    }
    
    function getSaleLedgDetail($id, $group_by, $shipment_id){
	    $this->db->select('sd.*, tbl_sale.fld_voucher_no, tbl_sale.fld_sale_date, tbl_sale.fld_location_id, tbl_sale.fld_customer_id, tbl_sale.fld_created_date,tbl_customers.fld_company_name,tbl_locations.fld_location');
        $this->db->from('tbl_sale_detail as sd');
        $this->db->join('tbl_sale','tbl_sale.fld_id=sd.fld_sale_id');
        $this->db->join('tbl_customers','tbl_customers.fld_id=tbl_sale.fld_customer_id');
        $this->db->join('tbl_locations','tbl_locations.fld_id=tbl_sale.fld_location_id');
        $this->db->where('tbl_sale.fld_isdeleted',0);
        if($group_by == 'pd.fld_product_id'){
            $group_by = 'sd.fld_product_id';
        }else if($group_by == 'pd.fld_subproduct_id'){
            $group_by = 'sd.fld_subproduct_id';
        }
        $this->db->where($group_by,$id);
		$this->db->where("sd.fld_shipment",$shipment_id);
        return $this->db->get()->result_array();
        
    }
    
    
    public function getShipmentsLedger(){
        $item_id = $this->input->post('item_id');
        $sitem_id = $this->input->post('sub_item_id');
        
        if($item_id == 1){
            $shipments = $this->db->query("SELECT * FROM (SELECT b.fld_shipment FROM tbl_purchase_detail as a, tbl_purchase as b WHERE b.fld_id = a.fld_purchase_id && a.fld_product_id = '1' GROUP by fld_shipment UNION SELECT CONCAT('LPG Gain/', fld_shipment) FROM `tbl_gainloss_details` WHERE fld_type = '1') A order by fld_shipment ASC")->result_array();
            
        }else{
            if($sitem_id =='all'){
                $shipments =  $this->db->query("SELECT b.fld_shipment FROM tbl_purchase_detail as a, tbl_purchase as b WHERE b.fld_id = a.fld_purchase_id && a.fld_product_id = '$item_id' GROUP by fld_shipment")->result_array();
            }else{
                $shipments =  $this->db->query("SELECT b.fld_shipment FROM tbl_purchase_detail as a, tbl_purchase as b WHERE b.fld_id = a.fld_purchase_id && a.fld_product_id = '$item_id' && a.fld_subproduct_id = '$sitem_id' GROUP by fld_shipment")->result_array();
            }
        }
        $shipmentHtml = '<option value="">Select Shipment</option>';
        foreach($shipments as $shipment){
            $shipmentHtml .= '<option value="'.$shipment['fld_shipment'].'">'.$shipment['fld_shipment'].'</option>';
        }
        
        echo $shipmentHtml;
        
    }
    
    public function incomereport()
    {
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		
        $role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(190,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		
        $this->title = "Income Report";
		
		$data['view_scripts']=array(
		    
    		
    		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
    		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
    		$this->Gen->get_script_url('plugin_components','treeview/jstree.min.js'),
    		$this->Gen->get_script_url('bower_components','jquery.treeview.init.js'),
    // 		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'),
    		$this->Gen->get_script_url('','https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js'),
    		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
    		$this->Gen->get_script_url('custom_js','jquery.validate.js'),
    		$this->Gen->get_script_url('custom_js','accounts.js'),
		);
		$data['view_css']=array(
            $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
            $this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
            $this->Gen->get_script_url('plugin_components','treeview/themes/default/style.css'),
            $this->Gen->get_script_url('plugin_components','treeview/file-explore.css'),
            $this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
		); 
		
		//$data['currentAssets'] = $this->Base_model->getAll('tbl_currentAssets'); 
        $this->load_template('','accounts/incomereport',$data);
        
    }
    
     public function getIncomeReport() {
			
    
		$start=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('from_date'))));
		$end=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('to_date'))));
		$data['start_date'] = $start;
		$data['end_date'] = $end;
	
		
		$data['saleofproducts'] = $this->db->query("SELECT IFNULL(SUM(fld_total_discount), 0) discount, IFNULL(SUM(fld_grand_total_amount), 0) amount FROM `tbl_sale` WHERE DATE(fld_sale_date) >= '$start' && DATE(fld_sale_date) <= '$end'  && fld_isdeleted = 0")->row();
		
		
		$cgsOpeningStock = $this->db->query("SELECT IFNULL(SUM(a.debit), 0)-IFNULL(SUM(a.credit), 0) as balance FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id && b.date < '$start' && a.coa_id LIKE '101003%' && b.type='Sale'  && b.deleted = 0")->row()->balance;
		$cgsPurchase = $this->db->query("SELECT IFNULL(SUM(a.debit), 0) as debit FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id &&  b.date >= '$start' && b.date <= '$end' && a.coa_id LIKE '101003%' && b.type='Sale'  && b.deleted = 0")->row()->debit;
		$cgsClosingStock = $this->db->query("SELECT IFNULL(SUM(a.debit), 0)-IFNULL(SUM(a.credit), 0) as balance FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id && a.coa_id LIKE '101003%' && b.type='Sale' && b.date <= '$end'  && b.deleted = 0")->row()->balance;
		
// 		echo $cgsOpeningStock.'-'.$cgsPurchase.'-'.$cgsClosingStock;
// 		exit;
		
		$data['costOfGoodsSold'] = $cgsOpeningStock+$cgsPurchase-$cgsClosingStock;
		
	
		$data['OfficeExpenses'] = $this->db->query("SELECT IFNULL(SUM(a.unit_price), 0) amount FROM tbl_expense_detail a, tbl_expenses b WHERE b.id = a.fld_expense_id  && DATE(b.date_added) >= '$start' && DATE(b.date_added) <= '$end' && a.expense_type = '1' && b.fld_isdeleted = 0")->row()->amount;
		$data['MessExpenses'] = $this->db->query("SELECT IFNULL(SUM(a.unit_price), 0) amount FROM tbl_expense_detail a, tbl_expenses b WHERE b.id = a.fld_expense_id  && DATE(b.date_added) >= '$start' && DATE(b.date_added) <= '$end' && a.expense_type = '2'  && b.fld_isdeleted = 0")->row()->amount;
		$data['StaffSalaries'] = $this->db->query("SELECT IFNULL(SUM(a.credit), 0) as debit FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id  && b.date >= '$start' && b.date <= '$end' && a.coa_id LIKE '101006%' AND b.type='MonthlySalary' && b.deleted = 0")->row()->debit;
		$data['Dividend'] = $this->db->query("SELECT IFNULL(SUM(a.debit), 0)-IFNULL(SUM(a.credit), 0) as credit FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.type='PLD' && b.id = a.v_id && b.date >= '$start' && b.date <= '$end' && a.coa_id LIKE '205001%' && b.deleted = 0")->row()->credit;
		$data['OtherIncome'] = $this->db->query("SELECT IFNULL(SUM(a.credit), 0)-IFNULL(SUM(a.debit), 0) as balance FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id && b.date >= '$start' && b.date <= '$end' && a.coa_id = '401002001'")->row()->balance;
		$html=$this->load->view('accounts/incomereport_filter',$data,true);
		echo json_encode(array("html"=>$html));
        
    }
    
     public function incomereport_csv() {
        include_once APPPATH.'/third_party/autoload.php';
        $header_row = array("Particulars", "PKR");
        $csvName = 'incomereport'.'.csv';
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="'.$csvName.'";');
        $output = fopen('php://output', 'w');
        fputcsv($output,$header_row);
        $start=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->get('from_date'))));
		$end=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->get('to_date'))));
		$data['start_date'] = $start;
		$data['end_date'] = $end;
	
		
		$data['saleofproducts'] = $this->db->query("SELECT IFNULL(SUM(fld_total_discount), 0) discount, IFNULL(SUM(fld_grand_total_amount), 0) amount FROM `tbl_sale` WHERE DATE(fld_sale_date) >= '$start' && DATE(fld_sale_date) <= '$end'  && fld_isdeleted = 0")->row();
		
		
		$cgsOpeningStock = $this->db->query("SELECT IFNULL(SUM(a.debit), 0)-IFNULL(SUM(a.credit), 0) as balance FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id && b.date < '$start' && a.coa_id LIKE '101003%' && b.type='Sale'  && b.deleted = 0")->row()->balance;
		$cgsPurchase = $this->db->query("SELECT IFNULL(SUM(a.debit), 0) as debit FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id &&  b.date >= '$start' && b.date <= '$end' && a.coa_id LIKE '101003%' && b.type='Sale'  && b.deleted = 0")->row()->debit;
		$cgsClosingStock = $this->db->query("SELECT IFNULL(SUM(a.debit), 0)-IFNULL(SUM(a.credit), 0) as balance FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id && a.coa_id LIKE '101003%' && b.type='Sale' && b.date <= '$end'  && b.deleted = 0")->row()->balance;
		
// 		echo $cgsOpeningStock.'-'.$cgsPurchase.'-'.$cgsClosingStock;
// 		exit;
		
		$data['costOfGoodsSold'] = $cgsOpeningStock+$cgsPurchase-$cgsClosingStock;
		
	
		$data['OfficeExpenses'] = $this->db->query("SELECT IFNULL(SUM(a.unit_price), 0) amount FROM tbl_expense_detail a, tbl_expenses b WHERE b.id = a.fld_expense_id  && DATE(b.date_added) >= '$start' && DATE(b.date_added) <= '$end' && a.expense_type = '1' && b.fld_isdeleted = 0")->row()->amount;
		$data['MessExpenses'] = $this->db->query("SELECT IFNULL(SUM(a.unit_price), 0) amount FROM tbl_expense_detail a, tbl_expenses b WHERE b.id = a.fld_expense_id  && DATE(b.date_added) >= '$start' && DATE(b.date_added) <= '$end' && a.expense_type = '2'  && b.fld_isdeleted = 0")->row()->amount;
		$data['StaffSalaries'] = $this->db->query("SELECT IFNULL(SUM(a.credit), 0) as debit FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id  && b.date >= '$start' && b.date <= '$end' && a.coa_id LIKE '101006%' AND b.type='MonthlySalary' && b.deleted = 0")->row()->debit;
		$data['Dividend'] = $this->db->query("SELECT IFNULL(SUM(a.debit), 0)-IFNULL(SUM(a.credit), 0) as credit FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.type='PLD' && b.id = a.v_id && b.date >= '$start' && b.date <= '$end' && a.coa_id LIKE '205001%' && b.deleted = 0")->row()->credit;
		$data['OtherIncome'] = $this->db->query("SELECT IFNULL(SUM(a.credit), 0)-IFNULL(SUM(a.debit), 0) as balance FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id && b.date >= '$start' && b.date <= '$end' && a.coa_id = '401002001'")->row()->balance;
	   $revenue = $data['saleofproducts']->amount+$data['OtherIncome']-$data['costOfGoodsSold'];
	   $totalExpenses = $data['OfficeExpenses']+$data['MessExpenses']+$data['StaffSalaries'];
	    $income=array(
	    "Total Sale"=> number_format(($data['saleofproducts']->amount+$data['saleofproducts']->discount), 2), 
	    "Other Income"=> number_format($data['OtherIncome'], 2), 
	    "Sale Discount"=> number_format($data['saleofproducts']->discount, 2), 
	    "Net Sale"=> number_format($data['saleofproducts']->amount, 2), 
	    "Cost of Good Sold"=>number_format($data['costOfGoodsSold'],2),
	    "Gross Profit/Loss"=> number_format($revenue, 2), 
	    "Office Expenses"=> number_format($data['OfficeExpenses'], 2),
	    "Mess Expenses"=> number_format($data['MessExpenses'], 2), 
	    "Staff Salaries"=> number_format($data['StaffSalaries'], 2), 
	    "Total Expenses"=> number_format($totalExpenses, 2), 
	    "Net Income"=> number_format(($revenue-$totalExpenses), 2), 
	    "Dividend"=> number_format($data['Dividend'], 2), 
	    );
	    foreach($income as $key => $val){
	      $dataValus=array($key,$val);
		
        fputcsv($output,$dataValus);
	    }
        fclose($output);
     }
    public function print_income_report() {
			
		$start=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->get('from_date'))));
		$end=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->get('to_date'))));
		$data['start_date'] = $start;
		$data['end_date'] = $end;
	
		
		$data['saleofproducts'] = $this->db->query("SELECT IFNULL(SUM(fld_total_discount), 0) discount, IFNULL(SUM(fld_grand_total_amount), 0) amount FROM `tbl_sale` WHERE DATE(fld_sale_date) >= '$start' && DATE(fld_sale_date) <= '$end'  && fld_isdeleted = 0")->row();
		
		
		$cgsOpeningStock = $this->db->query("SELECT IFNULL(SUM(a.debit), 0)-IFNULL(SUM(a.credit), 0) as balance FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id && b.date < '$start' && a.coa_id LIKE '101003%' && b.type='Sale'  && b.deleted = 0")->row()->balance;
		$cgsPurchase = $this->db->query("SELECT IFNULL(SUM(a.debit), 0) as debit FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id &&  b.date >= '$start' && b.date <= '$end' && a.coa_id LIKE '101003%' && b.type='Sale'  && b.deleted = 0")->row()->debit;
		$cgsClosingStock = $this->db->query("SELECT IFNULL(SUM(a.debit), 0)-IFNULL(SUM(a.credit), 0) as balance FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id && a.coa_id LIKE '101003%' && b.type='Sale' && b.date <= '$end'  && b.deleted = 0")->row()->balance;
		
// 		echo $cgsOpeningStock.'-'.$cgsPurchase.'-'.$cgsClosingStock;
// 		exit;
		
		$data['costOfGoodsSold'] = $cgsOpeningStock+$cgsPurchase-$cgsClosingStock;
		
	
		$data['OfficeExpenses'] = $this->db->query("SELECT IFNULL(SUM(a.unit_price), 0) amount FROM tbl_expense_detail a, tbl_expenses b WHERE b.id = a.fld_expense_id  && DATE(b.date_added) >= '$start' && DATE(b.date_added) <= '$end' && a.expense_type = '1' && b.fld_isdeleted = 0")->row()->amount;
		$data['MessExpenses'] = $this->db->query("SELECT IFNULL(SUM(a.unit_price), 0) amount FROM tbl_expense_detail a, tbl_expenses b WHERE b.id = a.fld_expense_id  && DATE(b.date_added) >= '$start' && DATE(b.date_added) <= '$end' && a.expense_type = '2'  && b.fld_isdeleted = 0")->row()->amount;
		$data['StaffSalaries'] = $this->db->query("SELECT IFNULL(SUM(a.credit), 0) as debit FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id  && b.date >= '$start' && b.date <= '$end' && a.coa_id LIKE '101006%' AND b.type='MonthlySalary' && b.deleted = 0")->row()->debit;
		$data['Dividend'] = $this->db->query("SELECT IFNULL(SUM(a.debit), 0)-IFNULL(SUM(a.credit), 0) as credit FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.type='PLD' && b.id = a.v_id && b.date >= '$start' && b.date <= '$end' && a.coa_id LIKE '205001%' && b.deleted = 0")->row()->credit;
		$data['OtherIncome'] = $this->db->query("SELECT IFNULL(SUM(a.credit), 0)-IFNULL(SUM(a.debit), 0) as balance FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id && b.date >= '$start' && b.date <= '$end' && a.coa_id = '401002001'")->row()->balance;
		$this->load->view('accounts/income_report_print', $data);
        
    }
    
    public function pdf_income_report() {
			
		include_once APPPATH.'/third_party/autoload.php';
	    $mpdf = new \Mpdf\Mpdf();
		$start=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->get('from_date'))));
		$end=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->get('to_date'))));
		$data['start_date'] = $start;
		$data['end_date'] = $end;
	
		
		$data['saleofproducts'] = $this->db->query("SELECT IFNULL(SUM(fld_total_discount), 0) discount, IFNULL(SUM(fld_grand_total_amount), 0) amount FROM `tbl_sale` WHERE DATE(fld_sale_date) >= '$start' && DATE(fld_sale_date) <= '$end'  && fld_isdeleted = 0")->row();
		
		
		$cgsOpeningStock = $this->db->query("SELECT IFNULL(SUM(a.debit), 0)-IFNULL(SUM(a.credit), 0) as balance FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id && b.date < '$start' && a.coa_id LIKE '101003%' && b.type='Sale'  && b.deleted = 0")->row()->balance;
		$cgsPurchase = $this->db->query("SELECT IFNULL(SUM(a.debit), 0) as debit FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id &&  b.date >= '$start' && b.date <= '$end' && a.coa_id LIKE '101003%' && b.type='Sale'  && b.deleted = 0")->row()->debit;
		$cgsClosingStock = $this->db->query("SELECT IFNULL(SUM(a.debit), 0)-IFNULL(SUM(a.credit), 0) as balance FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id && a.coa_id LIKE '101003%' && b.type='Sale' && b.date <= '$end'  && b.deleted = 0")->row()->balance;
		
// 		echo $cgsOpeningStock.'-'.$cgsPurchase.'-'.$cgsClosingStock;
// 		exit;
		
		$data['costOfGoodsSold'] = $cgsOpeningStock+$cgsPurchase-$cgsClosingStock;
		
	
		$data['OfficeExpenses'] = $this->db->query("SELECT IFNULL(SUM(a.unit_price), 0) amount FROM tbl_expense_detail a, tbl_expenses b WHERE b.id = a.fld_expense_id  && DATE(b.date_added) >= '$start' && DATE(b.date_added) <= '$end' && a.expense_type = '1' && b.fld_isdeleted = 0")->row()->amount;
		$data['MessExpenses'] = $this->db->query("SELECT IFNULL(SUM(a.unit_price), 0) amount FROM tbl_expense_detail a, tbl_expenses b WHERE b.id = a.fld_expense_id  && DATE(b.date_added) >= '$start' && DATE(b.date_added) <= '$end' && a.expense_type = '2'  && b.fld_isdeleted = 0")->row()->amount;
		$data['StaffSalaries'] = $this->db->query("SELECT IFNULL(SUM(a.credit), 0) as debit FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id  && b.date >= '$start' && b.date <= '$end' && a.coa_id LIKE '101006%' AND b.type='MonthlySalary' && b.deleted = 0")->row()->debit;
		$data['Dividend'] = $this->db->query("SELECT IFNULL(SUM(a.debit), 0)-IFNULL(SUM(a.credit), 0) as credit FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.type='PLD' && b.id = a.v_id && b.date >= '$start' && b.date <= '$end' && a.coa_id LIKE '205001%' && b.deleted = 0")->row()->credit;
		$data['OtherIncome'] = $this->db->query("SELECT IFNULL(SUM(a.credit), 0)-IFNULL(SUM(a.debit), 0) as balance FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id && b.date >= '$start' && b.date <= '$end' && a.coa_id = '401002001'")->row()->balance;
	   // $this->load->view('accounts/income_report_pdf',$data);
	    
	    $html = $this->load->view('accounts/income_report_pdf',$data,true);
	    $mpdf->WriteHTML($html);
		$mpdf->Output('Income Report.pdf','D');
        
    }
    
    public function cashflow()
    {
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		
        $role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(192,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		
        $this->title = "Cash Flow Report";
		
		$data['view_scripts']=array(
		    
    		
    		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
    		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
    		$this->Gen->get_script_url('plugin_components','treeview/jstree.min.js'),
    		$this->Gen->get_script_url('bower_components','jquery.treeview.init.js'),
    // 		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'),
    		$this->Gen->get_script_url('','https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js'),
    			$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
    		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
    		$this->Gen->get_script_url('custom_js','jquery.validate.js'),
    		$this->Gen->get_script_url('custom_js','accounts.js'),
		);
		$data['view_css']=array(
            $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
            $this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
            $this->Gen->get_script_url('plugin_components','treeview/themes/default/style.css'),
            $this->Gen->get_script_url('plugin_components','treeview/file-explore.css'),
            $this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
		); 
		
		//$data['currentAssets'] = $this->Base_model->getAll('tbl_currentAssets'); 
        $this->load_template('','accounts/cashflow',$data);
        
    }
    
     public function cashflow_filter() {
			
		$start=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('from_date'))));
		$end=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('to_date'))));
		$type = $this->input->post('type');
		$filter = $this->input->post('group');
		switch ($filter) {
		  case "Voucher_Wise":
			$group_by = "tm.type";
			$select="tm.type as filter_text,tm.type as filter_value";
			break;
		  case "User_Wise":
			$group_by = "tm.user_id";
			$select="tbl_users.fld_username as filter_text,tm.user_id as filter_value";
			break;
		case "Account_Wise":
			$group_by = "td.coa_id";
			$select="tbl_coa.head_name as filter_text,td.coa_id as filter_value";
			break;
		case "Date_Wise":
			$group_by = "tm.date";
			$select="DATE_FORMAT(tm.date, '%d-%m-%Y') as filter_text,tm.date as filter_value";
			break;
		}
		
		$date="tm.date between '".date("Y-m-d",strtotime($start))."' AND '".date("Y-m-d",strtotime($end))."'";
		$this->db->select($select);
		
		$this->db->from('tbl_transections_details as td');
		
		$this->db->join('tbl_transections_master as tm','tm.id=td.v_id');
		
		$this->db->join('tbl_coa','tbl_coa.head_code=td.coa_id');
		
		
		$this->db->join('tbl_users','tbl_users.fld_id=tm.user_id');
		
		$this->db->where($date);
		
		if($type != 'all'){
			$this->db->where("tm.type",$type);
		}
		
		$this->db->group_by($group_by);
		
	    $ledger=$this->db->get()->result_array();
	   // print_r($ledger);
	   // exit;
	    
	    
		if($ledger){
			foreach($ledger as $key => $ledg){
				 if($type != 'all'){
				    $ledgdet=$this->db->query("SELECT td.*, tm.type, tm.type_id, tm.date FROM tbl_transections_details AS td JOIN tbl_transections_master AS tm ON tm.id=td.v_id AND $group_by = '{$ledg['filter_value']}' AND tm.post_status = 0 and $date and tm.type='$type' ORDER BY tm.date, td.id")->result_array();
			    }else{
			        $ledgdet=$this->db->query("SELECT td.*, tm.type, tm.type_id, tm.date FROM tbl_transections_details AS td JOIN tbl_transections_master AS tm ON tm.id=td.v_id AND $group_by = '{$ledg['filter_value']}' AND tm.post_status = 0 and $date  ORDER BY tm.date, td.id")->result_array();
			    }
				$ledger[$key]['detail']=$ledgdet;
			}
		}
		
		$data['ledger'] = $ledger;
		$count=count($ledger);
		$html=$this->load->view('accounts/cashflow_filter',$data,true);
		echo json_encode(array("html"=>$html,'count'=>$count));
    }
    
    
    
    public function print_cash_flow_report() {
			$_POST = $_GET;
		$start=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('from_date'))));
		$end=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('to_date'))));
		$type = $this->input->post('type');
		$filter = $this->input->post('group');
		switch ($filter) {
		  case "Voucher_Wise":
			$group_by = "tm.type";
			$select="tm.type as filter_text,tm.type as filter_value";
			break;
		  case "User_Wise":
			$group_by = "tm.user_id";
			$select="tbl_users.fld_username as filter_text,tm.user_id as filter_value";
			break;
		case "Account_Wise":
			$group_by = "td.coa_id";
			$select="tbl_coa.head_name as filter_text,td.coa_id as filter_value";
			break;
		case "Date_Wise":
			$group_by = "tm.date";
			$select="DATE_FORMAT(tm.date, '%d-%m-%Y') as filter_text,tm.date as filter_value";
			break;
		}
		
		$date="tm.date between '".date("Y-m-d",strtotime($start))."' AND '".date("Y-m-d",strtotime($end))."'";
		$this->db->select($select);
		
		$this->db->from('tbl_transections_details as td');
		
		$this->db->join('tbl_transections_master as tm','tm.id=td.v_id');
		
		$this->db->join('tbl_coa','tbl_coa.head_code=td.coa_id');
		
		
		$this->db->join('tbl_users','tbl_users.fld_id=tm.user_id');
		
		$this->db->where($date);
		
		if($type != 'all'){
			$this->db->where("tm.type",$type);
		}
		
		$this->db->group_by($group_by);
		
	    $ledger=$this->db->get()->result_array();
	   // print_r($ledger);
	   // exit;
	    
	    
	if($ledger){
			foreach($ledger as $key => $ledg){
				 if($type != 'all'){
				    $ledgdet=$this->db->query("SELECT td.*, tm.type, tm.type_id, tm.date FROM tbl_transections_details AS td JOIN tbl_transections_master AS tm ON tm.id=td.v_id AND $group_by = '{$ledg['filter_value']}' AND tm.post_status = 0 and $date and tm.type='$type' ORDER BY tm.date, td.id")->result_array();
			    }else{
			        $ledgdet=$this->db->query("SELECT td.*, tm.type, tm.type_id, tm.date FROM tbl_transections_details AS td JOIN tbl_transections_master AS tm ON tm.id=td.v_id AND $group_by = '{$ledg['filter_value']}' AND tm.post_status = 0 and $date  ORDER BY tm.date, td.id")->result_array();
			    }
				$ledger[$key]['detail']=$ledgdet;
			}
		}
		
		$data['ledger'] = $ledger;
		$count=count($ledger);
		$html=$this->load->view('accounts/cashflow_print',$data);
// 		echo json_encode(array("html"=>$html,'count'=>$count));
		
		


    }
    
    
    
    public function pdf_cash_flow_report() {
			
			$_POST = $_GET;
		$start=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('from_date'))));
		$end=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('to_date'))));
		$type = $this->input->post('type');
		$filter = $this->input->post('group');
		switch ($filter) {
		  case "Voucher_Wise":
			$group_by = "tm.type";
			$select="tm.type as filter_text,tm.type as filter_value";
			break;
		  case "User_Wise":
			$group_by = "tm.user_id";
			$select="tbl_users.fld_username as filter_text,tm.user_id as filter_value";
			break;
		case "Account_Wise":
			$group_by = "td.coa_id";
			$select="tbl_coa.head_name as filter_text,td.coa_id as filter_value";
			break;
		case "Date_Wise":
			$group_by = "tm.date";
			$select="DATE_FORMAT(tm.date, '%d-%m-%Y') as filter_text,tm.date as filter_value";
			break;
		}
		
		$date="tm.date between '".date("Y-m-d",strtotime($start))."' AND '".date("Y-m-d",strtotime($end))."'";
		$this->db->select($select);
		
		$this->db->from('tbl_transections_details as td');
		
		$this->db->join('tbl_transections_master as tm','tm.id=td.v_id');
		
		$this->db->join('tbl_coa','tbl_coa.head_code=td.coa_id');
		
		
		$this->db->join('tbl_users','tbl_users.fld_id=tm.user_id');
		
		$this->db->where($date);
		
		if($type != 'all'){
			$this->db->where("tm.type",$type);
		}
		
		$this->db->group_by($group_by);
		
	    $ledger=$this->db->get()->result_array();
	   // print_r($ledger);
	   // exit;
	    
	    
		if($ledger){
			foreach($ledger as $key => $ledg){
				 if($type != 'all'){
				    $ledgdet=$this->db->query("SELECT td.*, tm.type, tm.type_id, tm.date FROM tbl_transections_details AS td JOIN tbl_transections_master AS tm ON tm.id=td.v_id AND $group_by = '{$ledg['filter_value']}' AND tm.post_status = 0 and $date and tm.type='$type' ORDER BY tm.date, td.id")->result_array();
			    }else{
			        $ledgdet=$this->db->query("SELECT td.*, tm.type, tm.type_id, tm.date FROM tbl_transections_details AS td JOIN tbl_transections_master AS tm ON tm.id=td.v_id AND $group_by = '{$ledg['filter_value']}' AND tm.post_status = 0 and $date  ORDER BY tm.date, td.id")->result_array();
			    }
				$ledger[$key]['detail']=$ledgdet;
			}
		}
		
		$data['ledger'] = $ledger;
		ini_set('pcre.backtrack_limit', 1000000000000);
		include_once APPPATH.'/third_party/autoload.php';
	    $mpdf = new \Mpdf\Mpdf();
		$count=count($ledger);
		 $html = $this->load->view('accounts/cashflow_pdf',$data,true);
	    $mpdf->WriteHTML($html);
		$mpdf->Output('Cash Flow Report.pdf','D');
        
    
        
    }
    
    public function cashflow_csv(){
       $_POST = $_GET;
		$start=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('from_date'))));
		$end=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('to_date'))));
		$type = $this->input->get('type');
		$filter = $this->input->get('group');
		switch ($filter) {
		  case "Voucher_Wise":
			$group_by = "tm.type";
			$select="tm.type as filter_text,tm.type as filter_value";
			break;
		  case "User_Wise":
			$group_by = "tm.user_id";
			$select="tbl_users.fld_username as filter_text,tm.user_id as filter_value";
			break;
		case "Account_Wise":
			$group_by = "td.coa_id";
			$select="tbl_coa.head_name as filter_text,td.coa_id as filter_value";
			break;
		case "Date_Wise":
			$group_by = "tm.date";
			$select="DATE_FORMAT(tm.date, '%d-%m-%Y') as filter_text,tm.date as filter_value";
			break;
		}
		
		$date="tm.date between '".date("Y-m-d",strtotime($start))."' AND '".date("Y-m-d",strtotime($end))."'";
		$this->db->select($select);
		
		$this->db->from('tbl_transections_details as td');
		
		$this->db->join('tbl_transections_master as tm','tm.id=td.v_id');
		
		$this->db->join('tbl_coa','tbl_coa.head_code=td.coa_id');
		
		
		$this->db->join('tbl_users','tbl_users.fld_id=tm.user_id');
		
		$this->db->where($date);
		
		if($type != 'all'){
			$this->db->where("tm.type",$type);
		}
		
		$this->db->group_by($group_by);
		
	    $ledger=$this->db->get()->result_array();
	   // print_r($ledger);
	   // exit;
	    
	    
		if($ledger){
			foreach($ledger as $key => $ledg){
				 if($type != 'all'){
				    $ledgdet=$this->db->query("SELECT td.*, tm.type, tm.type_id, tm.date FROM tbl_transections_details AS td JOIN tbl_transections_master AS tm ON tm.id=td.v_id AND $group_by = '{$ledg['filter_value']}' AND tm.post_status = 0 and $date and tm.type='$type' ORDER BY tm.date, td.id")->result_array();
			    }else{
			        $ledgdet=$this->db->query("SELECT td.*, tm.type, tm.type_id, tm.date FROM tbl_transections_details AS td JOIN tbl_transections_master AS tm ON tm.id=td.v_id AND $group_by = '{$ledg['filter_value']}' AND tm.post_status = 0 and $date  ORDER BY tm.date, td.id")->result_array();
			    }
				$ledger[$key]['detail']=$ledgdet;
			}
		}
		
		$header_row = array("#", "Voucher Date", "Vocuher Number", "Account" , " Narration", "Debit", "Credit" , "Balance", "Dr/Cr" );
            $csvName = 'Cashflow'.'.csv';
            header('Content-Type: application/csv');
            header('Content-Disposition: attachment; filename="'.$csvName.'";');
            $output = fopen('php://output', 'w');
            
            fputcsv($output,$header_row);
            
			 $i=1;
			 $b=1;
			foreach($ledger as $ledge){
			    
			    	$dataValus=array('', '',$ledge['filter_text'],'','','','','','');
					 fputcsv($output,$dataValus);
			    
			    	$total_credit=0;
				$total_debit=0;
				$balance=0;
				$i+=1;
				foreach($ledge['detail'] as $ledgedet){
				    $total_credit +=$ledgedet['credit'];
				    $total_debit +=$ledgedet['debit'];
				    $balance += $ledgedet['debit']-$ledgedet['credit'];
			 
				    $header = $this->db->query("SELECT * FROM tbl_coa WHERE head_code = '{$ledgedet['coa_id']}'")->row()->head_name;
				    if($ledgedet['type']=='Purchase'){
						$type= '(PV-'.sprintf('%04d', $ledgedet['type_id']).') ';
						}else if($ledgedet['type']=='Navigation'){
							$type= '(NV-'.sprintf('%04d', $ledgedet['type_id']).') ';
						}else if($ledgedet['type']=='Sale'){
							$type= '(SV-'.sprintf('%04d', $ledgedet['type_id']).')';
						}else if($ledgedet['type']=='Expense'){
							$type= '(EV-'.sprintf('%04d', $ledgedet['type_id']).') ';
						}else if($ledgedet['type']=='MonthlySalary' && $ledgedet['type_id'] > 0){
							$type= '(MS-'.sprintf('%04d', $ledgedet['type_id']).')';
						}
						else{
						    $type='';
						}
					
 			
 			            $str = $ledgedet['narration'];
						if (strpos($str, 'Q') !== false || strpos($str, 'Disc.Rs') !== false || strpos($str, 'Rs') !== false || strpos($str, 'Dr Acc.') !== false || strpos($str, 'Cr Acc.') !== false) {
						   $str=str_replace("Q","Q",$str); 
						   $str=str_replace("Disc.Rs","Disc.Rs",$str); 
						   $str=str_replace("Rs","Rs",$str);
						   $str=str_replace("Dr Acc","Dr Acc",$str);
						   $str=str_replace("Cr Acc","Cr Acc",$str);
						   $str1= $str;
						}else{
						    $str1= $ledgedet['narration'];
						}
						$debitt=0;
						$creditt=0;
					if($ledgedet['debit'] > 0){ $debitt = number_format($ledgedet['debit'],2);}
					if($ledgedet['credit'] > 0){ $creditt = number_format($ledgedet['credit'],2);}
					if(number_format($balance,2) > 0 || number_format($balance,2) < 0){ $bal = number_format($balance,2);}
					if($ledgedet['debit'] > 0){ $nat = 'Dr';}else{ $nat = 'Cr'; }
					$dataValus=array($i, date('d-m-Y',strtotime($ledgedet['date'])),  $ledgedet['type'].' - '.$ledgedet['v_id'],$header,$type.' '.$str1,$debitt,$creditt,$bal,$nat);
                    fputcsv($output,$dataValus);
                    
				
					$i++; }
		$b++;
		}

		
            

            
            fclose($output);
            exit();
            
		
		
       
    }
    
    
    
    
    public function print_item_income_report() {
			
		$start=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->get('from_date'))));
		$end=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->get('to_date'))));
		
		$item_id = $this->input->get('item_type');
		
		
		$data['start_date'] = $start;
		$data['end_date'] = $end;
		$data['itemReport'] = $this->db->query("SELECT IFNULL(SUM(a.fld_discount), 0) discount, IFNULL(SUM(a.fld_total_amount), 0) amount, IFNULL(SUM(a.fld_purchase_amount), 0) cgs  FROM tbl_sale_detail a, tbl_sale b WHERE a.fld_product_id = '$item_id' && DATE(b.fld_sale_date) >= '$start' && DATE(b.fld_sale_date) <= '$end' && b.fld_id = a.fld_sale_id")->row();
		
		$this->load->view('accounts/income_report_items_print', $data);
        
    }
    
    public function pdf_item_income_report() {
			
		include_once APPPATH.'/third_party/autoload.php';
	    $mpdf = new \Mpdf\Mpdf();
		$start=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->get('from_date'))));
		$end=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->get('to_date'))));
		
		$item_id = $this->input->get('item_type');
		
		$data['start_date'] = $start;
		$data['end_date'] = $end;
		$data['itemReport'] = $this->db->query("SELECT IFNULL(SUM(a.fld_discount), 0) discount, IFNULL(SUM(a.fld_total_amount), 0) amount, IFNULL(SUM(a.fld_purchase_amount), 0) cgs  FROM tbl_sale_detail a, tbl_sale b WHERE a.fld_product_id = '$item_id' && DATE(b.fld_sale_date) >= '$start' && DATE(b.fld_sale_date) <= '$end' && b.fld_id = a.fld_sale_id")->row();
		
	    $html = $this->load->view('accounts/income_report_items_pdf',$data,true);
	    $mpdf->WriteHTML($html);
		$mpdf->Output('Item Income Report.pdf','D');
        
    }
    
    public function trailbalance()
    {
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		
        $role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(191,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		
        $this->title = "Trial Balance";
		
		$data['view_scripts']=array(
    		
    		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
    		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
    		$this->Gen->get_script_url('plugin_components','treeview/jstree.min.js'),
    		$this->Gen->get_script_url('bower_components','jquery.treeview.init.js'),
    // 		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'),
    		$this->Gen->get_script_url('','https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
    		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
    		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
    		$this->Gen->get_script_url('custom_js','jquery.validate.js'),
    		$this->Gen->get_script_url('custom_js','accounts.js'),
		);
		$data['view_css']=array(
            $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
            $this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
            $this->Gen->get_script_url('plugin_components','treeview/themes/default/style.css'),
            $this->Gen->get_script_url('plugin_components','treeview/file-explore.css'),
            $this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
		); 
		
		//$data['currentAssets'] = $this->Base_model->getAll('tbl_currentAssets'); 
        $this->load_template('','accounts/trailbalance',$data);
        
    }
     
    public function balancesheet_report()
    {
		 
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		
        $role_permissions  = explode(",",$this->session->userdata('permissions'));
		if(!empty($role_permissions) && !in_array(188,$role_permissions)) {
			$this->session->set_userdata(array('error_message' => "Access Denied!"));
			$this->output->set_header("Location: " . base_url('home'), TRUE, 302);
		}
		
        $this->title = "Balance Sheet";
		
		$data['view_scripts']=array(
    		
    		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
    		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
    // 		$this->Gen->get_script_url('plugin_components','nestable/jquery.nestable.min.js'),
    // 		$this->Gen->get_script_url('bower_components','jquery.nastable.init.js'),
    // 		$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'),
    		$this->Gen->get_script_url('','https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js'),
    		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
    		$this->Gen->get_script_url('custom_js','jquery.validate.js'),
    		$this->Gen->get_script_url('custom_js','accounts.js'),
		);
		$data['view_css']=array(
            $this->Gen->get_script_url('plugin_components','select2/select2.min.css'),
            $this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
            // $this->Gen->get_script_url('plugin_components','treeview/themes/default/style.css'),
            $this->Gen->get_script_url('plugin_components','nestable/jquery.nestable.min.css'),
            // $this->Gen->get_script_url('plugin_components','treeview/file-explore.css'),
            $this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.css'),
		); 
		if(isset($_POST['level'])){
		    if($_POST['level'] == 1){
		       
		        $data['assets'] = $this->db->query("SELECT * FROM tbl_coa WHERE head_level='{$_POST['level']}' && (head_code LIKE '101%' || head_code LIKE '102%') ORDER BY head_code asc")->result_array();
		$data['liabilitiesequity'] = $this->db->query("SELECT * FROM tbl_coa WHERE head_level='{$_POST['level']}' && ( head_code LIKE '201%' || head_code LIKE '202%' || head_code LIKE '203%' || head_code LIKE '204%' || head_code LIKE '205%') ORDER BY head_code asc")->result_array();
		    
		    } 
		    else if($_POST['level'] == 2){
		        $data['assets'] = $this->db->query("SELECT * FROM tbl_coa WHERE (head_level='1' || head_level='2' ) && (head_code LIKE '101%' || head_code LIKE '102%') ORDER BY head_code asc")->result_array();
		$data['liabilitiesequity'] = $this->db->query("SELECT * FROM tbl_coa WHERE (head_level='1' || head_level='2' ) && ( head_code LIKE '201%' || head_code LIKE '202%' || head_code LIKE '203%' || head_code LIKE '204%' || head_code LIKE '205%') ORDER BY head_code asc")->result_array();
		    }
		    else{
		         $data['assets'] = $this->db->query("SELECT * FROM tbl_coa WHERE head_code LIKE '101%' || head_code LIKE '102%' ORDER BY head_code asc")->result_array();
		$data['liabilitiesequity'] = $this->db->query("SELECT * FROM tbl_coa WHERE head_code LIKE '201%' || head_code LIKE '202%' || head_code LIKE '203%' || head_code LIKE '204%' || head_code LIKE '205%' ORDER BY head_code asc")->result_array();
		    }
		    
		}else{
		    $data['assets'] = $this->db->query("SELECT * FROM tbl_coa WHERE head_code LIKE '101%' || head_code LIKE '102%' ORDER BY head_code asc")->result_array();
		$data['liabilitiesequity'] = $this->db->query("SELECT * FROM tbl_coa WHERE head_code LIKE '201%' || head_code LIKE '202%' || head_code LIKE '203%' || head_code LIKE '204%' || head_code LIKE '205%' ORDER BY head_code asc")->result_array();
		}
// 		$data['assets'] = $this->db->query("SELECT * FROM tbl_coa WHERE head_code LIKE '101%' || head_code LIKE '102%' ORDER BY head_code asc")->result_array();
// 		$data['liabilitiesequity'] = $this->db->query("SELECT * FROM tbl_coa WHERE head_code LIKE '201%' || head_code LIKE '202%' || head_code LIKE '203%' || head_code LIKE '204%' || head_code LIKE '205%' ORDER BY head_code asc")->result_array();
		//$data['currentAssets'] = $this->Base_model->getAll('tbl_currentAssets'); 
        $this->load_template('','accounts/balancesheet_report',$data);
        
    }
    
    public function getTrailBalance() {
			
		$start=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('from_date'))));
		$end=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('to_date'))));
		
		$level = $this->input->post('level');
		
		$data['start_date'] = $start;
		$data['end_date'] = $end;
		
		$data['accounts'] = $this->db->query("SELECT * FROM tbl_coa WHERE head_level = '$level' order by head_code")->result_array();
		
		$html=$this->load->view('accounts/trailbalance_filter',$data,true);
		echo json_encode(array("html"=>$html));
        
    }
    
   
    
    public function trailbalance_print() {
			
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$_POST = $_GET;
	    $start=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('from_date'))));
		$end=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('to_date'))));
		
		$level = $this->input->post('level');
		
		$data['start_date'] = $start;
		$data['end_date'] = $end;
		
		$data['accounts'] = $this->db->query("SELECT * FROM tbl_coa WHERE head_level = '$level' order by head_code")->result_array();
		$this->load->view('accounts/trailbalance_print', $data);
        
    }
    
    
    public function trailbalance_pdf(){
        $data['view_scripts']=array(
    		
    		
    		$this->Gen->get_script_url('custom_js','accounts.js'),
		);
		$data['view_css']=array(
		); 
        include_once APPPATH.'/third_party/autoload.php';
		$_POST = $_GET;
		$mpdf = new \Mpdf\Mpdf();
        
        $start=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('from_date'))));
		$end=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('to_date'))));
		
		$level = $this->input->post('level');
		
		$data['start_date'] = $start;
		$data['end_date'] = $end;
		
		$data['accounts'] = $this->db->query("SELECT * FROM tbl_coa WHERE head_level = '$level' order by head_code")->result_array();
		
		$html = $this->load->view('accounts/trailbalance_pdf',$data,true);
		$mpdf->WriteHTML($html);
		$mpdf->Output('Trial Balance Report.pdf','D');
		
// 	    $data['sales']=$sales=$this->Accounts_model->profitandloss_filter();
// 		$data['filter_type']=$this->input->post('filter_type');
// 		$data['get']=$_GET;
		
    }
    public function trail_balance_csv(){
        	if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$_POST = $_GET;
	    $start=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('from_date'))));
		$end=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('to_date'))));
		
		$level = $this->input->post('level');
		
		$start_date = $start;
		$end_date = $end;
		$noomb=0;
		$noomb2=0;
		
		$accounts = $this->db->query("SELECT * FROM tbl_coa WHERE head_level = '$level' order by head_code")->result_array();
		
		
		
		$header_row = array("Code", "Account", "Debit", "Credit");
            $csvName = 'Trial Balance '.'.csv';
            header('Content-Type: application/csv');
            header('Content-Disposition: attachment; filename="'.$csvName.'";');
            $output = fopen('php://output', 'w');
            
            fputcsv($output,$header_row);
            
            
            
            $totalCredit = 0;
			$totalDebit = 0;
			foreach($accounts as $account){
			$balance = $this->db->query("SELECT IFNULL(SUM(a.debit), 0)-IFNULL(SUM(a.credit), 0) as balance FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id && b.date >= '$start_date' && b.date <= '$end_date' && a.coa_id LIKE '{$account['head_code']}%'")->row()->balance;
			
			
			if($balance > 0){
			    $totalDebit += $balance;
			}else{
			    $totalCredit += abs($balance);
			}
			
			
			if(isset($_POST['hide_zero']) && !empty($_POST['hide_zero']) && $balance == 0){}else{
			    if($balance>0){$noomb= number_format($balance,2);}else {$noomb='';}
            if($balance<0){$noomb2= number_format(abs($balance), 2);}else {$noomb2='';}
            
            $dataValus=array($account['head_code'], $account['head_name'], $noomb, $noomb2);
                fputcsv($output,$dataValus);
            
			}}
			
			$start=$start_date;
		$end=$end_date;
		
		
		$saleofproducts = $this->db->query("SELECT IFNULL(SUM(fld_total_discount), 0) discount, IFNULL(SUM(fld_grand_total_amount), 0) amount FROM `tbl_sale` WHERE DATE(fld_sale_date) >= '$start' && DATE(fld_sale_date) <= '$end'")->row();
		
		$cgsOpeningStock = $this->db->query("SELECT IFNULL(SUM(a.debit), 0)-IFNULL(SUM(a.credit), 0) as balance FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id && b.date < '$start' && (a.coa_id LIKE '101003003' || a.coa_id LIKE '101003004')")->row()->balance;
		
		$cgsPurchase = $this->db->query("SELECT IFNULL(SUM(a.debit), 0) as debit FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id && b.date >= '$start' && b.date <= '$end' && (a.coa_id LIKE '101003003' || a.coa_id LIKE '101003004')")->row()->debit;
		
		$cgsClosingStock = $this->db->query("SELECT IFNULL(SUM(a.debit), 0)-IFNULL(SUM(a.credit), 0) as balance FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id && (a.coa_id LIKE '101003003' || a.coa_id LIKE '101003004') and b.date <= '$end'")->row()->balance;
		
// 		exit;
		$costOfGoodsSold = $cgsOpeningStock+$cgsPurchase-$cgsClosingStock;
		
            
            
            
            $dataValus=array('', 'Net Sale', '', number_format($saleofproducts->amount, 2));
                fputcsv($output,$dataValus);
                 $dataValus=array('', 'Cost of Good Sold', number_format($costOfGoodsSold,2), '');
                fputcsv($output,$dataValus);
            
           
            
            fclose($output);
            exit();
    
    }
    
    public function csvBalanceSheet(){
        if(isset($_GET['year'])){
            $year = $this->db->query("SELECT * FROM app_years where year_id = '{$_GET['year']}'")->row_array();
            $start_date = $year['date_start'];
            $end_date = $year['date_end'];
            $accounts = $this->db->query("SELECT * FROM tbl_coa WHERE (head_code LIKE '1%' || head_code LIKE '2%') and head_level = 3 order by head_code")->result_array();
            
            $header_row = array("AccountID", "AccountCode", "Balance", "Parent Head Name");
            $csvName = 'BalanceSheet'.'_'.date('Y-m-d', strtotime($start_date)).'_'.date('Y-m-d', strtotime($end_date)).'.csv';
            header('Content-Type: application/csv');
            header('Content-Disposition: attachment; filename="'.$csvName.'";');
            $output = fopen('php://output', 'w');
            
            fputcsv($output,$header_row);
            
            foreach($accounts as $row){
                
                if(substr($row['head_code'], 0, 1) == 2){
                    $credit = 1;
                }else{
                    $credit = 0;
                }
                $balance = $this->Accounts_model->getBalancafromHead($row['head_code'], $credit , $start_date, $end_date);
                $income = $this->Accounts_model->getIncomeReport($start_date, $end_date);
                $incomeLPG = $this->Accounts_model->getBalancafromHead('401002001',1, $start_date, $end_date);
                
                if($row['head_code']=='204001001'){
                    $balance += $income;
                }
                
                 if($row['head_code']=='204001001'){
                    $balance += $incomeLPG;
                }
                
                $balance = number_format($balance, 2);
                $dataValus=array($row['head_code'], $row['head_name'], $balance, $row['parent_head_name']);
                fputcsv($output,$dataValus);
            }
            
            fclose($output);
            exit();
            
            
            
            
        }
       
    }
  
	public function profitandlossReport()
	{
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$this->title = "Profit and Loss Report";
			$data['view_scripts']=array(
		$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		$this->Gen->get_script_url('plugin_components','datatables/jquery.dataTables.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.bootstrap4.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/dataTables.buttons.min.js'),
		$this->Gen->get_script_url('plugin_components','datatables/buttons.bootstrap4.min.js'),
		$this->Gen->get_script_url('bower_components','jquery.datatable.init.js'),
		$this->Gen->get_script_url('custom_js','accounts.js'),
		$this->Gen->get_script_url('custom_js','jquery.validate.js'),
		
		$this->Gen->get_script_url('plugin_components','select2/select2.min.js'),
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

		$this->load_template('','accounts/profitandlossReport',$data);
	}
	public function profitandlossfilter(){
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$data['sales']=$sales=$this->Accounts_model->profitandloss_filter();
		// echo '<pre>';
		// print_r($data['sales']);
		// exit;
		$data['filter_type']=$this->input->post('filter_type');
		$count=count($sales);
		$html=$this->load->view('accounts/profitandloss_filter',$data,true);
		echo json_encode(array("html"=>$html,'count'=>$count));
	}
	public function profitandloss_csv(){
	    include_once APPPATH.'/third_party/autoload.php';
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
	    $_POST = $_GET;
		$data['sales']=$sales=$this->Accounts_model->profitandloss_filter();
		$header_row = array("#", "Invoice Date", "Invoice ID", "Account" , "Item", "Qty(KG)", "Weight(KG)","Rate(PKR)","Discount(PKR)","Amount(PKR)","Cost(PKR)","Profit/Unit(PKR)","Profit(PKR)","P&L%");
        $csvName = 'profitLoss'.'.csv';
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="'.$csvName.'";');
        $output = fopen('php://output', 'w');
        
        fputcsv($output,$header_row);
        $i=1;
	    foreach($sales as $sale){
            foreach($sale['detail'] as $row){
            
            $dataValus=array($i,date('d-m-Y',strtotime($row['fld_sale_date'])), $row['fld_voucher_no'],$row['fld_customer_name'],$row['fld_category'],$row['fld_quantity'],$row['fld_weight'],
            round($row['fld_unit_price']),round($row['fld_discount']),round($row['fld_total_amount']-$row['fld_discount']),round($row['fld_purchase_amount']/$row['fld_quantity']),
            round((($row['fld_total_amount']-$row['fld_discount'])-$row['fld_purchase_amount'])/$row['fld_quantity']),
            round(($row['fld_total_amount']-$row['fld_discount'])-$row['fld_purchase_amount']),round((((($row['fld_total_amount']-$row['fld_discount'])-$row['fld_purchase_amount'])) * 100) / ($row['fld_total_amount']-$row['fld_discount']),2));
            fputcsv($output,$dataValus);
            $i++;
            }
        }
            
        fclose($output);
	}
	
	
	public function print_profitandloss_report() {
			
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$_POST = $_GET;
	    $data['sales']=$sales=$this->Accounts_model->profitandloss_filter();
		$data['filter_type']=$this->input->post('filter_type');
		$this->load->view('accounts/print_profitandloss_report', $data);
        
    }
	public function profitandloss_pdf_report(){
		include_once APPPATH.'/third_party/autoload.php';
		$_POST = $_GET;
		$mpdf = new \Mpdf\Mpdf();
	    $data['sales']=$sales=$this->Accounts_model->profitandloss_filter();
		$data['filter_type']=$this->input->post('filter_type');
		$data['get']=$_GET;
		$html = $this->load->view('accounts/pdf_profitandloss_report',$data,true);
		$mpdf->WriteHTML($html);
		$mpdf->Output('Sale Report.pdf','D');
	}


}
