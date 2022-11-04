<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Expenses_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function getMaxexpenseID() {
		$sql="SHOW TABLE STATUS LIKE 'tbl_expenses'";
		return $this->db->query($sql)->row_array();
    }
    
    
    function expense_filter() {
		$conditions="";
		$filter=$this->input->post('filter');
		$group_by='tbl_expenses.expense_voucher';
		$select="tbl_expenses.expense_voucher as filter_text,tbl_expenses.expense_voucher as filter_value";
		switch ($filter) {
		  case "Voucher_Wise":
			$group_by = "tbl_expenses.expense_voucher";
			$select="tbl_expenses.expense_voucher as filter_text,tbl_expenses.expense_voucher as filter_value";
			break;
		case "Plant_Wise":
			$group_by = "tbl_expenses.plant_for";
			$select="tbl_locations.fld_location as filter_text,tbl_expenses.plant_for as filter_value";
			break;
		case "User_Wise":
			$group_by = "tbl_expenses.fld_userid";
			$select="tbl_users.fld_username as filter_text,tbl_expenses.fld_userid as filter_value";
			break;
		case "Item_Wise":
			$group_by = "ed.stationary";
			$select="tbl_stationary.name as filter_text,ed.stationary as filter_value";
			break;	
		case "Date_Wise":
			$group_by = "tbl_expenses.date_added";
			$select="DATE_FORMAT(tbl_expenses.date_added, '%d-%m-%Y') as filter_text,tbl_expenses.date_added as filter_value";
			break;
		case "Year_Wise":
			$group_by = "YEAR(tbl_expenses.date_added)";
			$select="DATE_FORMAT(tbl_expenses.date_added, '%Y') as filter_text,YEAR(tbl_expenses.date_added) as filter_value";
			break;
		case "Month_Wise":
			$group_by = "MONTH(tbl_expenses.date_added)";
			$select="DATE_FORMAT(tbl_expenses.date_added, '%m-%Y') as filter_text,MONTH(tbl_expenses.date_added) as filter_value";
			break;
		case "WeekDay_Wise":
			$group_by = "DAYNAME(tbl_expenses.date_added)";
			$select="DAYNAME(tbl_expenses.date_added) as filter_text,DAYNAME(tbl_expenses.date_added) as filter_value";
			break;
		}
		$location=$this->input->post('location');
		$voucher=$this->input->post('expense_voucher');
		$user=$this->input->post('user');
		$stationary=$this->input->post('stationary');
		
		$start=str_replace('/', '-', $this->input->post('from_date'));
		$end=str_replace('/', '-', $this->input->post('to_date'));
		$date="tbl_expenses.date_added between '".date("Y-m-d",strtotime($start))." 00:00:00' AND '".date("Y-m-d",strtotime($end))." 23:59:00'";
		//$this->db->select('tbl_expenses.id,'.$select.',tbl_expenses.expense_voucher,sum(ed.sub_total) as total_amount,sum(ed.quantity) as total_quantity');
		$this->db->select('tbl_expenses.id,'.$select.',tbl_expenses.expense_voucher,sum(ed.unit_price) as total_amount,sum(ed.quantity) as total_quantity');
		
		$this->db->from('tbl_expenses');
		$this->db->join('tbl_expense_detail as ed','ed.fld_expense_id=tbl_expenses.id');
		$this->db->join('tbl_locations','tbl_locations.fld_id=tbl_expenses.plant_for');
		$this->db->join('tbl_users','tbl_users.fld_id=tbl_expenses.fld_userid');
		$this->db->join('tbl_stationary','tbl_stationary.id=ed.stationary');
		
		$this->db->where($date);
		
		if(!empty($location)){
			$this->db->where("tbl_expenses.plant_for",$location);
		}
		
		if(!empty($voucher)){
			$this->db->where("tbl_expenses.expense_voucher",$voucher);
		}
		if(!empty($user)){
			$this->db->where("tbl_expenses.fld_userid",$user);
		}
		if(!empty($stationary)){
			$this->db->where("ed.stationary",$stationary);
		}
		$this->db->where('tbl_expenses.fld_isdeleted',0);
		$this->db->group_by($group_by);
		
		$expense=$this->db->get()->result_array();
		
		if($expense){
			foreach($expense as $key => $purch){
				$purchdet=$this->getExpenseDetail($purch['filter_value'],$group_by);
				$expense[$key]['detail']=$purchdet;
			}
		}
		return $expense;
        
    }
    
    function getExpenseDetail($id,$group_by){
	
	return $this->db->query("SELECT `tbl_expenses`.*, `ed`.`stationary`, `ed`.`quantity`, `ed`.`expense_type`, `ed`.`expense_value`, `ed`.`unit`, `ed`.`sub_total`, `ed`.`unit_price`, ed.remarks, `st`.`name` as st_name, `st`.`fld_unit` as st_unit, tbl_locations.fld_location
    FROM `tbl_expenses`
    JOIN `tbl_expense_detail` as `ed` ON `ed`.`fld_expense_id`=`tbl_expenses`.`id`
    JOIN `tbl_stationary` as `st` ON `st`.`id`=`ed`.`stationary`
    JOIN  tbl_locations ON tbl_locations.fld_id=tbl_expenses.plant_for
    AND $group_by = '$id'")->result_array();

	}
    
    function expense_filter_pdf($get) {
		$conditions="";
		$filter=$this->input->get('filter');
		$group_by='tbl_expenses.expense_voucher';
		$select="tbl_expenses.expense_voucher as filter_text,tbl_expenses.expense_voucher as filter_value";
		switch ($filter) {
		  case "Voucher_Wise":
			$group_by = "tbl_expenses.expense_voucher";
			$select="tbl_expenses.expense_voucher as filter_text,tbl_expenses.expense_voucher as filter_value";
			break;
		case "Plant_Wise":
			$group_by = "tbl_expenses.plant_for";
			$select="tbl_locations.fld_location as filter_text,tbl_expenses.plant_for as filter_value";
			break;
		case "User_Wise":
			$group_by = "tbl_expenses.fld_userid";
			$select="tbl_users.fld_username as filter_text,tbl_expenses.fld_userid as filter_value";
			break;
		case "Item_Wise":
			$group_by = "ed.stationary";
			$select="tbl_stationary.name as filter_text,ed.stationary as filter_value";
			break;	
		case "Date_Wise":
			$group_by = "tbl_expenses.date_added";
			$select="DATE_FORMAT(tbl_expenses.date_added, '%d-%m-%Y') as filter_text,tbl_expenses.date_added as filter_value";
			break;
		case "Year_Wise":
			$group_by = "YEAR(tbl_expenses.date_added)";
			$select="DATE_FORMAT(tbl_expenses.date_added, '%Y') as filter_text,YEAR(tbl_expenses.date_added) as filter_value";
			break;
		case "Month_Wise":
			$group_by = "MONTH(tbl_expenses.date_added)";
			$select="DATE_FORMAT(tbl_expenses.date_added, '%m-%Y') as filter_text,MONTH(tbl_expenses.date_added) as filter_value";
			break;
		case "WeekDay_Wise":
			$group_by = "DAYNAME(tbl_expenses.date_added)";
			$select="DAYNAME(tbl_expenses.date_added) as filter_text,DAYNAME(tbl_expenses.date_added) as filter_value";
			break;
		}
		$location=$this->input->get('location');
		$voucher=$this->input->get('voucher');
		$user=$this->input->get('user');
		$stationary=$this->input->get('stationary');
		
		$start=str_replace('/', '-', $this->input->get('from'));
		$end=str_replace('/', '-', $this->input->get('to'));
		$date="tbl_expenses.date_added between '".date("Y-m-d",strtotime($start))." 00:00:00' AND '".date("Y-m-d",strtotime($end))." 23:59:00'";
		//$this->db->select('tbl_expenses.id,'.$select.',tbl_expenses.expense_voucher,sum(ed.sub_total) as total_amount,sum(ed.quantity) as total_quantity');
		$this->db->select('tbl_expenses.id,'.$select.',tbl_expenses.expense_voucher,sum(ed.unit_price) as total_amount,sum(ed.quantity) as total_quantity');
		
		$this->db->from('tbl_expenses');
		
		$this->db->join('tbl_expense_detail as ed','ed.fld_expense_id=tbl_expenses.id');
		$this->db->join('tbl_locations','tbl_locations.fld_id=tbl_expenses.plant_for');
		$this->db->join('tbl_users','tbl_users.fld_id=tbl_expenses.fld_userid');
		$this->db->join('tbl_stationary','tbl_stationary.id=ed.stationary');
		
		
		$this->db->where($date);
		
		if(!empty($location)){
			$this->db->where("tbl_expenses.plant_for",$location);
		}
		if(!empty($voucher)){
			$this->db->where("tbl_expenses.expense_voucher",$voucher);
		}
		if(!empty($user)){
			$this->db->where("tbl_expenses.fld_userid",$user);
		}
		if(!empty($stationary)){
			$this->db->where("ed.stationary",$stationary);
		}
		$this->db->where('tbl_expenses.fld_isdeleted',0);
		$this->db->group_by($group_by);
		
		$expense=$this->db->get()->result_array();
		
		if($expense){
			foreach($expense as $key => $purch){
				$purchdet=$this->getExpenseDetail($purch['filter_value'],$group_by);
				$expense[$key]['detail']=$purchdet;
			}
		}
		return $expense;
    }
    
	
//     function expense_entry(){
	    
// 		$purchase_id = date('YmdHis');
// 		$payment_type=0;
// 		if($this->input->post('fld_payment_status')  == 3){
// 			$payment_type=0;
// 		}else{
// 			$payment_type=$this->input->post('fld_payment_type');
// 		}
		
// 		$user_id=$this->session->userdata('user_id');
	
// 		$data = array(
// 			'fld_userid'        => $user_id,
//             'fld_supplier_id'   => $this->input->post('fld_supplier_id',TRUE),
//             'fld_invoice_no'    => $this->input->post('fld_invoice_no',TRUE),
//             'fld_voucher_no'    => $this->input->post('fld_voucher_no',TRUE),
//             'fld_purchase_date' => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('fld_purchase_date',TRUE)))),
//             'fld_shipment'      => $this->input->post('fld_shipment',TRUE),
//             'fld_location_id'   => $this->input->post('fld_location',TRUE),
//             'fld_grand_total_amount'  => $this->input->post('fld_grand_total_amount',TRUE),
//             'fld_payment_status'      => $this->input->post('fld_payment_status',TRUE),
//             'fld_payment_type'        => $payment_type,
//             'fld_bank'             =>  $this->input->post('fld_bank',TRUE),
//             'fld_cheque_number' =>  $this->input->post('fld_cheque_number',TRUE),
//             'fld_cheque_date'   =>  $this->input->post('fld_cheque_date',TRUE),
//         );
// 		 $responce=$this->db->insert('tbl_purchase', $data);
// 		 if($responce){
		     
// 		  $totalquantity=0;
// 		  $insert_id = $this->db->insert_id();
// 		  $p_id = $this->input->post('fld_product_id',TRUE);
// 		  $sub_category = $this->input->post('sub_category',TRUE);
// 		  $rate = $this->input->post('fld_unit_price',TRUE);
// 		  $quantity = $this->input->post('fld_quantity',TRUE);
// 		  $t_price = $this->input->post('fld_total_amount',TRUE);
// 		  for ($i = 0, $n = count($p_id); $i < $n; $i++) {
// 			$totalquantity=$totalquantity + $quantity[$i];
//             $product_quantity = $quantity[$i];
//             $product_rate = $rate[$i];
//             $product_id = $p_id[$i];
//             $fld_subproduct_id = $sub_category[$i];
//             $total_price = $t_price[$i];
//             // $disc = $discount[$i];
//             $disc=0;

//             $data1 = array(
//                 'fld_purchase_id'   => $insert_id,
//                 'fld_product_id'    => $product_id,
//                 'fld_subproduct_id' => $fld_subproduct_id,
//                 'fld_quantity'      => $product_quantity,
//                 'fld_unit_price'    => $product_rate,
//                 'fld_total_amount'  => $total_price
//             );

//             if (!empty($quantity)) {
//                 $this->db->insert('tbl_purchase_detail', $data1);
//                 	$locinsert=array(
//         		    "fld_purchase_location_id"=>$this->input->post('fld_location',TRUE),
//         		    "fld_parent_id"=>0,
//         		    "fld_purch_type"=>1,
//         		    "fld_purchase_id"=>$insert_id,
//         		    "fld_product_id"=>$product_id,
//         		    "fld_subproduct_id"=>$fld_subproduct_id,
//             		);
//     		    $this->db->insert('tbl_stock_locations', $locinsert);
//         		$locinsert_id = $this->db->insert_id();
//         		$stockinsert=array(
//         		    "fld_stock_qty"=>$product_quantity,
//         		    "fld_stock_loc_id"=>$locinsert_id,
//         		);
//     		    $this->db->insert('tbl_stocks', $stockinsert);
//             }
//         }
	
// 		if($this->input->post('purchase_draft') != FALSE && $this->input->post('purchase_draft') == 1){
// 			 $purchase_id =$this->input->post('purchase_id');
// 			 $this->db->where('fld_id', $purchase_id);
// 			 $this->db->delete('tbl_purchase_draft');
// 			 $this->db->where('fld_purchase_id', $purchase_id);
// 			 $this->db->delete('tbl_purchase_detail_draft');
// 		}
// 		$this->session->set_userdata('success_message', "Purchase order added successfully.");
// 		    return true;
// 		}else{
// 			$this->session->set_userdata('success_message', "Purchase order not added.");
// 			return false; 
// 		}
// 	}

    function delete($id){
	    $user_id = $this->session->userdata('user_id');
		$this->db->where('id',$id);
		$this->db->set('fld_trash_date', 'NOW()', FALSE);
		return $this->db->update('tbl_expenses',array('fld_isdeleted'=>1, 'fld_trash_by' => $user_id));
	}
	
	function restore($id){
		$this->db->where('id',$id);
		return $this->db->update('tbl_expenses',array('fld_isdeleted'=>0));
	}
	
	function permanentdelete($id){
	    
	    $v_id = $this->db->query("SELECT id FROM tbl_transections_master WHERE type='Expense' AND type_id = '$id'")->row()->id;
	    
	    $this->db->where('v_id',$v_id);
	    $this->db->delete('tbl_transections_details');
	    
	    $this->db->where('id',$v_id);
	    $this->db->delete('tbl_transections_master');
	    
		$this->db->where('id',$id);
		return $this->db->delete('tbl_expenses');
	}
	
	function permanentdeletedetail($id){
		$this->db->where('fld_expense_id',$id);
		return $this->db->delete('tbl_expense_detail');
	}
	
	function deleteDraft($id){
		$this->db->where('id',$id);
		return $this->db->delete('tbl_expenses_draft');
	}
	
	function deleteDraftdetail($id){
		$this->db->where('fld_expense_id',$id);
		return $this->db->delete('tbl_expense_draft_detail');
	}
	
	function getAllStationary() {
		$this->db->select('tbl_stationary.*,tbl_units.fld_unit');
		$this->db->from('tbl_stationary');
		$this->db->join('tbl_units','tbl_units.fld_id=tbl_stationary.fld_unit','left');
		return $this->db->get()->result_array();
    }

}
