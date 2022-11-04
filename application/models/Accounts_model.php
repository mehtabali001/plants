<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Accounts_model extends CI_Model { 

    public function __construct() { 
        parent::__construct();
    }
    
    function getMaxVoucherID() {
		$sql="SHOW TABLE STATUS LIKE 'tbl_transections_master'";
		return $this->db->query($sql)->row_array();
    }

   function dfs($HeadName,$HeadCode,$oResult,$visit,$d)
    {
        $coa = $this->db->query("SELECT * FROM tbl_coa WHERE head_code = '$HeadCode'")->row_array();
        $color = 'color:black';
        if($coa['type']=='EMPLOYEE'){
            $emp = $this->db->query("SELECT * FROM tbl_employees WHERE accounts_id = '$HeadCode'")->row_array();
            if($emp['is_active']==2){
                $color = 'color:grey';
            }
        }
        
        if($d==0) echo " <li class=\"jstree-open\" style=\"$color\"  data-jstree='{\"icon\":\"fas fa-stream text-success font-18\"}'><a href='javascript:'  onclick=\"loadCoaData('".$HeadCode."')\"><span style=\"$color\">$HeadName</span></a>";
        else if($d==1) echo " <li class=\"jstree-open\" style=\"$color\"  data-jstree='{\"icon\":\"fas fa-stream text-primary font-18\"}'><a href='javascript:' onclick=\"loadCoaData('".$HeadCode."')\"><span style=\"$color\">L".($d-1)." - $HeadName</span></a>";
        else echo " <li class=\"jstree-open\" style=\"$color\" data-jstree='{\"icon\":\"fas fa-stream text-success font-18\"}'><a href='javascript:'  onclick=\"loadCoaData('".$HeadCode."')\"><span style=\"$color\">L".($d-1)." - $HeadName</span></a>";
        $p=0;
        for($i=0;$i< count($oResult);$i++)
        {

            if (!$visit[$i])
            {
                if ($HeadName==$oResult[$i]['parent_head_name'])
                {
                    $visit[$i]=true;
                    if($p==0) echo "<ul>";
                    $p++;
                    $this->dfs($oResult[$i]['head_name'],$oResult[$i]['head_code'],$oResult,$visit,$d+1);
                }
            }
        }
        if($p==0)
            echo "</li>";
        else
            echo "</ul>";
    }
    function limit_text($text, $limit) {
        $length = strlen($text);
        if($length > $limit){
           $text= substr($text, 0, $limit).'...';
        }
        
        return $text;
    }
    function balancesheetdfs($HeadName,$HeadCode,$oResult,$visit,$d, $credit, $start_date, $end_date)
    {
        
        // $end_date = "2022-08-22";
        $balance = $this->getBalancafromHead($HeadCode, $credit, $start_date, $end_date);
        
        $income = $this->getIncomeReport($start_date, $end_date);
        
        // $incomeLPG = $this->getBalancafromHead('401002001',1, $start_date, $end_date);
        
        if($HeadCode=='205001'  || $HeadCode=='205' || $HeadCode=='2'){
            $balance += $income;
            // $balance += $incomeLPG;
        }
        
        
        if(substr($HeadCode, 0, 6) == '205001' && strlen($HeadCode) > 6){
            $incomep = $this->getIncomePlantReport($start_date, $end_date, $HeadCode);
            $balance += $incomep;
        }
        
        if($balance > 0){
            if($credit == 1){
                $showBalance = number_format($balance, 2). ' <span style="color:red;font-weight:600;">(CR)</span>';
            }else{
                $showBalance = number_format($balance, 2). ' <span style="color:green;font-weight:600;">(DR)</span>';
            }
            
        }else if($balance < 0){
            if($credit == 1){
               $showBalance = number_format(abs($balance), 2) . ' <span style="color:green;font-weight:600;">(DR)</span>';
            }else{
               $showBalance = number_format(abs($balance), 2) . ' <span style="color:red;font-weight:600;">(CR)</span>';
            }
             
        }else{
           
               $showBalance = number_format(abs($balance), 2);
        }
       
        $balance = number_format($balance, 2);
        $HeadNameO = $HeadName;
        $HeadName=$this->limit_text($HeadName,35);
        
        if($d==0){ echo "<li class=\"dd-item\" data-id=\"$HeadCode\"><div class=\"dd-handle\" style=\"color: #21d0c0;font-weight: bold;\"> L".($d)." - $HeadName <span style=\"float:right\">$showBalance</span></div>";
        }elseif($d==1){ if(isset($_POST['hide_zero']) && $balance == 0){}else{ echo " <li class=\"dd-item\" data-id=\"$HeadCode\"><div class=\"dd-handle\" style=\"color: #21d0c0;font-weight: bold;\">L".($d)." - $HeadName <span style=\"float:right\">$showBalance</span></div>";}
        }elseif($d==2){ if(isset($_POST['hide_zero']) && $balance == 0){}else{ echo " <li class=\"dd-item\" data-id=\"$HeadCode\"><div class=\"dd-handle\">L".($d)." - $HeadName <span style=\"float:right\">$showBalance</span></div>";}
        }else{ if(isset($_POST['hide_zero']) && $balance == 0){}else{ echo "<li class=\"dd-item\" data-id=\"$HeadCode\"><div class=\"dd-handle\" style=\"cursor: pointer;\" onclick=\"window.location.href='".base_url("Accounts/accounts_ledger?coa_id=$HeadCode")."'\">L".($d)." - $HeadName <span style=\"float:right\">$showBalance</span></div>";}}
        $p=0;
        if(isset($_POST['hide_zero']) && $balance == 0){}else{
        for($i=0;$i< count($oResult);$i++)
        {

            if (!$visit[$i])
            {
                if ($HeadNameO==$oResult[$i]['parent_head_name'])
                {
                    $visit[$i]=true;
                    if($p==0){ echo "<ol class=\"dd-list\">";}
                    $p++;
                    $this->balancesheetdfs($oResult[$i]['head_name'],$oResult[$i]['head_code'],$oResult,$visit,$d+1, $credit, $start_date, $end_date);
                }
            }
        }
        }
        if($p==0){
            if(isset($_POST['hide_zero']) && $balance == 0){}else{ echo "</li>"; }
        }else{
            echo "</ol>";
        }
    }
    
    function getBalancafromHead($id, $credit, $start_date, $end_date){
        
        if($credit==1){
            return  $this->db->query("SELECT IFNULL(SUM(a.credit), 0)-IFNULL(SUM(a.debit), 0) as balance FROM tbl_transections_details a, tbl_transections_master b WHERE b.id = a.v_id && a.coa_id LIKE '$id%' && b.date <= '$end_date' && b.deleted = 0")->row()->balance;
        }else{ 
            return  $this->db->query("SELECT IFNULL(SUM(a.debit), 0)-IFNULL(SUM(a.credit), 0) as balance FROM tbl_transections_details a, tbl_transections_master b WHERE b.id = a.v_id && a.coa_id LIKE '$id%' && b.date <= '$end_date' && b.deleted = 0")->row()->balance;
        }
        
    }
    
    
    function getIncomeReport($start, $end) {
			
		
		$saleofproducts = $this->db->query("SELECT IFNULL(SUM(fld_total_discount), 0) discount, IFNULL(SUM(fld_grand_total_amount), 0) amount FROM `tbl_sale` WHERE DATE(fld_sale_date) <= '$end' && fld_isdeleted = 0")->row()->amount;
		
		$cgsPurchase = $this->db->query("SELECT IFNULL(SUM(a.debit), 0) as debit FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id &&  b.date <= '$end' && a.coa_id LIKE '101003%' && b.type='Sale'  && b.deleted = 0")->row()->debit;
		
		$cgsClosingStock = $this->db->query("SELECT IFNULL(SUM(a.debit), 0)-IFNULL(SUM(a.credit), 0) as balance FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id && a.coa_id LIKE '101003%' && b.type='Sale' && b.date <= '$end'  && b.deleted = 0")->row()->balance;
		 
		$costOfGoodsSold = $cgsPurchase-$cgsClosingStock;
		$OtherIncome = $this->db->query("SELECT IFNULL(SUM(a.credit), 0)-IFNULL(SUM(a.debit), 0) as balance FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id && b.date <= '$end' && a.coa_id = '401002001'")->row()->balance;
		$OfficeExpenses = $this->db->query("SELECT IFNULL(SUM(a.unit_price), 0) amount FROM tbl_expense_detail a, tbl_expenses b WHERE b.id = a.fld_expense_id  && DATE(b.date_added) <= '$end' && a.expense_type = '1' && b.fld_isdeleted = 0")->row()->amount;
		$MessExpenses = $this->db->query("SELECT IFNULL(SUM(a.unit_price), 0) amount FROM tbl_expense_detail a, tbl_expenses b WHERE b.id = a.fld_expense_id  && DATE(b.date_added) <= '$end' && a.expense_type = '2'  && b.fld_isdeleted = 0")->row()->amount;
		$StaffSalaries = $this->db->query("SELECT IFNULL(SUM(a.credit), 0) as debit FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id  && b.date <= '$end' && a.coa_id LIKE '101006%' AND b.type='MonthlySalary' && b.deleted = 0")->row()->debit;
		
		return ($saleofproducts+$OtherIncome-$costOfGoodsSold)-($OfficeExpenses+$MessExpenses+$StaffSalaries);
    }
    
    function getIncomePlantReport($start, $end, $plant_plid) {
		
		$plant = $this->db->query("SELECT * FROM tbl_locations where profitloss_account = '$plant_plid'")->row_array();	
		
		$saleofproducts = $this->db->query("SELECT IFNULL(SUM(fld_total_discount), 0) discount, IFNULL(SUM(fld_grand_total_amount), 0) amount FROM `tbl_sale` WHERE DATE(fld_sale_date) <= '$end' && fld_location_id = '{$plant['fld_id']}' && fld_isdeleted = 0")->row()->amount;
		
		$cgsPurchase = $this->db->query("SELECT IFNULL(SUM(a.debit), 0) as debit FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id &&  b.date <= '$end' && (a.coa_id = '{$plant['inventory_account']}') && b.type='Sale'  && b.deleted = 0")->row()->debit;
		
		$cgsClosingStock = $this->db->query("SELECT IFNULL(SUM(a.debit), 0)-IFNULL(SUM(a.credit), 0) as balance FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id && (a.coa_id = '{$plant['inventory_account']}') && b.type='Sale' && b.date <= '$end'  && b.deleted = 0")->row()->balance;
 		$OtherIncome = $this->db->query("SELECT IFNULL(SUM(a.credit), 0)-IFNULL(SUM(a.debit), 0) as balance FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id && b.date <= '$end' && a.coa_id = '401002001' && b.type='GainLoss' && b.type_id IN (SELECT fld_gl_id FROM tbl_gainloss_details WHERE fld_location_id = '{$plant['fld_id']}')")->row()->balance;
		$costOfGoodsSold = $cgsPurchase-$cgsClosingStock;
		$OfficeExpenses = $this->db->query("SELECT IFNULL(SUM(a.unit_price), 0) amount FROM tbl_expense_detail a, tbl_expenses b WHERE b.id = a.fld_expense_id  && DATE(b.date_added) <= '$end' && a.expense_type = '1' && plant_for = '{$plant['fld_id']}' && b.fld_isdeleted = 0")->row()->amount;
		$MessExpenses = $this->db->query("SELECT IFNULL(SUM(a.unit_price), 0) amount FROM tbl_expense_detail a, tbl_expenses b WHERE b.id = a.fld_expense_id  && DATE(b.date_added) <= '$end' && a.expense_type = '2' && plant_for = '{$plant['fld_id']}'  && b.fld_isdeleted = 0")->row()->amount;
		$StaffSalaries = $this->db->query("SELECT IFNULL(SUM(a.credit), 0) as debit FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id  && b.date <= '$end' && a.coa_id IN (SELECT accounts_id FROM tbl_employees WHERE plants = '{$plant['fld_id']}') AND b.type='MonthlySalary' && b.deleted = 0")->row()->debit;
		
		return ($saleofproducts+$OtherIncome-$costOfGoodsSold)-($OfficeExpenses+$MessExpenses+$StaffSalaries);
    }
    
    public function treeview_selectform($id){
     $data = $this->db->select('*')
            ->from('tbl_coa')
            ->where('head_code',$id)
            ->get()
            ->row();
            return $data;
    }
    
    function profitandloss_filter() {
		$conditions="";
		$filter=$this->input->post('filter');
		$group_by='tbl_sale.fld_voucher_no';
		$select="tbl_sale.fld_voucher_no as filter_text,tbl_sale.fld_voucher_no as filter_value";
		switch ($filter) {
		  case "Voucher_Wise":
			$group_by = "tbl_sale.fld_voucher_no";
			$select="tbl_sale.fld_voucher_no as filter_text,tbl_sale.fld_voucher_no as filter_value";
			break;
		  case "User_Wise":
			$group_by = "tbl_sale.fld_userid";
			$select="tbl_users.fld_username as filter_text,tbl_sale.fld_userid as filter_value";
			break;
		case "Account_Wise":
			$group_by = "tbl_sale.fld_customer_id";
			$select="tbl_customers.fld_customer_name as filter_text,tbl_sale.fld_customer_id as filter_value";
			break;
		case "Item_Wise":
			$group_by = "sd.fld_product_id";
			$select="cat.fld_category as filter_text,sd.fld_product_id as filter_value";
			break;
		case "Plant_Wise":
			$group_by = "tbl_sale.fld_location_id";
			$select="tbl_locations.fld_location as filter_text,tbl_sale.fld_location_id as filter_value";
			break;
		case "Rate_Wise":
			$group_by = "sd.fld_unit_price";
			$select="sd.fld_unit_price as filter_text,sd.fld_unit_price as filter_value";
			break;
		case "Invoice_Wise":
			$group_by = "tbl_sale.fld_invoice_no";
			$select="tbl_sale.fld_invoice_no as filter_text,tbl_sale.fld_invoice_no as filter_value";
			break;
		case "Date_Wise":
			$group_by = "tbl_sale.fld_sale_date";
			$select="DATE_FORMAT(tbl_sale.fld_sale_date, '%d-%m-%Y') as filter_text,tbl_sale.fld_sale_date as filter_value";
			break;
		case "Shipment_Wise":
			$group_by = "sd.fld_shipment";
			$select="sd.fld_shipment as filter_text,sd.fld_shipment as filter_value";
			break;
		case "Year_Wise":
			$group_by = "YEAR(tbl_sale.fld_sale_date)";
			$select="DATE_FORMAT(tbl_sale.fld_sale_date, '%Y') as filter_text,YEAR(tbl_sale.fld_sale_date) as filter_value";
			break;
		case "Month_Wise":
			$group_by = "MONTH(tbl_sale.fld_sale_date)";
			$select="DATE_FORMAT(tbl_sale.fld_sale_date, '%m-%Y') as filter_text,MONTH(tbl_sale.fld_sale_date) as filter_value";
			break;
		case "WeekDay_Wise":
			$group_by = "DAYNAME(tbl_sale.fld_sale_date)";
			$select="DAYNAME(tbl_sale.fld_sale_date) as filter_text,DAYNAME(tbl_sale.fld_sale_date) as filter_value";
			break;
		}
		$shipment=$this->input->post('shipment');
		$location=$this->input->post('location');
		$user=$this->input->post('user');
		$item=$this->input->post('item');
		$category=$this->input->post('category');
		$subcategory=$this->input->post('subcategory');
		$customer=$this->input->post('customer');
		
		$start=str_replace('/', '-', $this->input->post('from_date'));
		$end=str_replace('/', '-', $this->input->post('to_date'));
		$date="DATE(tbl_sale.fld_sale_date) >= '".date("Y-m-d",strtotime($start))."' AND DATE(tbl_sale.fld_sale_date) <= '".date("Y-m-d",strtotime($end))."'";
		$this->db->select('tbl_sale.fld_id,'.$select.',tbl_sale.fld_voucher_no,sum(sd.fld_total_amount) as total_amount,sum(sd.fld_quantity) as total_quantity');
		
		$this->db->from('tbl_sale');
		
		$this->db->join('tbl_sale_detail as sd','sd.fld_sale_id=tbl_sale.fld_id');
		
		$this->db->join('tbl_category as cat','cat.fld_id=sd.fld_product_id');
		
		$this->db->join('tbl_customers','tbl_customers.fld_id=tbl_sale.fld_customer_id');
		
		$this->db->join('tbl_users','tbl_users.fld_id=tbl_sale.fld_userid');
		
		$this->db->join('tbl_locations','tbl_locations.fld_id=tbl_sale.fld_location_id');
		
		$this->db->where($date);
		
		if(!empty($location)){
			$this->db->where("tbl_sale.fld_location_id",$location);
		}
		if(!empty($customer)){
			$this->db->where("tbl_sale.fld_customer_id",$customer);
		}
		if(!empty($user)){
			$this->db->where("tbl_sale.fld_userid",$user);
		}
		if(!empty($shipment)){
			$this->db->where("sd.fld_shipment",$shipment);
		}
		if(!empty($item)){
			$this->db->where("sd.fld_product_id",$item);
		}
		if(!empty($category)){
			$this->db->where("sd.fld_product_id",$category);
		}
		if(!empty($subcategory)){
			$this->db->where("cat.fld_subcategory",$subcategory);
		}
		$this->db->where('tbl_sale.fld_isdeleted',0);
		
		$this->db->group_by($group_by);
		
		$sales=$this->db->get()->result_array();
		if($sales){
			foreach($sales as $key => $sel){
				$salesdet=$this->getSaleDetail($sel['filter_value'],$group_by);
				$sales[$key]['detail']=$salesdet;
			}
		}
		return $sales;
    }
    
    
    
	function getSaleDetail($id,$group_by){
	    $start=str_replace('/', '-', $this->input->post('from_date'));
		$end=str_replace('/', '-', $this->input->post('to_date'));
		$date="DATE(tbl_sale.fld_sale_date) >= '".date("Y-m-d",strtotime($start))."' AND DATE(tbl_sale.fld_sale_date) <= '".date("Y-m-d",strtotime($end))."'";
		//$date="tbl_purchase.fld_purchase_date between '".date("Y-m-d",strtotime($start))." 00:00:00' AND '".date("Y-m-d",strtotime($end))." 23:59:00'";
		$this->db->select('tbl_sale.*,tbl_customers.fld_customer_code,tbl_customers.fld_company_name,tbl_customers.fld_customer_name,sd.fld_product_id,sd.fld_subproduct_id,sd.fld_quantity,sd.fld_discount,sd.fld_weight,sd.fld_unit_price,sd.fld_total_amount,cat.fld_category,sd.fld_purchase_amount');
		
		$this->db->from('tbl_sale');
		
		$this->db->join('tbl_sale_detail as sd','sd.fld_sale_id=tbl_sale.fld_id');
		
		$this->db->join('tbl_category as cat','cat.fld_id=sd.fld_product_id');
		
		$this->db->join('tbl_customers','tbl_customers.fld_id=tbl_sale.fld_customer_id');
		
		$this->db->where($date);
		
		$this->db->where('tbl_sale.fld_isdeleted',0);
		
		$this->db->where($group_by,$id);
		
		return $this->db->get()->result_array();
	}
   
}
