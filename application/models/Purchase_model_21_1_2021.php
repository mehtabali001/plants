<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Purchase_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function getMaxsuplierID() {
		$sql="SHOW TABLE STATUS LIKE 'tbl_purchase'";
		return $this->db->query($sql)->row_array();
        
    }
	function getAllProducts() {
		
		$this->db->select('tbl_category.*,tbl_units.fld_unit');
		
		$this->db->from('tbl_category');
		
		$this->db->join('tbl_units','tbl_units.fld_id=tbl_category.fld_unit','left');
		
		return $this->db->get()->result_array();
        
    }
	function getAllPurchases() {
		
		$this->db->select('tbl_purchase.*,tbl_suppliers.fld_supplier_code,tbl_suppliers.fld_company_name,tbl_suppliers.fld_supplier_name');
		
		$this->db->from('tbl_purchase');
		
		$this->db->join('tbl_suppliers','tbl_suppliers.fld_id=tbl_purchase.fld_supplier_id');
		
		$this->db->where('tbl_purchase.fld_isdeleted',0);
		
		return $this->db->get()->result_array();
        
    }
	function getAllDraftPurchases() {
		
		$this->db->select('tbl_purchase_draft.*,tbl_suppliers.fld_supplier_code,tbl_suppliers.fld_company_name,tbl_suppliers.fld_supplier_name');
		
		$this->db->from('tbl_purchase_draft');
		
		$this->db->join('tbl_suppliers','tbl_suppliers.fld_id=tbl_purchase_draft.fld_supplier_id');
		
		return $this->db->get()->result_array();
        
    }
	function getPurchaseByID($id) {
		
		$this->db->select('tbl_purchase.*,tbl_suppliers.fld_supplier_name,tbl_locations.fld_location,tbl_locations.fld_address');
		
		$this->db->from('tbl_purchase');
		
		$this->db->join('tbl_suppliers','tbl_suppliers.fld_id=tbl_purchase.fld_supplier_id');
		
		$this->db->join('tbl_locations','tbl_locations.fld_id=tbl_purchase.fld_location_id','left');
		
		$this->db->where('tbl_purchase.fld_purchase_id',$id);
		
		$record=$this->db->get()->row_array();
		if($record){
			foreach($record as $key => $rec){
				
				$record['products']=$this->getPurchaseProducts($id);
			}
		}
		return $record;
        
    }
	function getPurchaseDraftByID($id) {
		
		$this->db->select('tbl_purchase_draft.*,tbl_suppliers.fld_supplier_name');
		
		$this->db->from('tbl_purchase_draft');
		
		$this->db->join('tbl_suppliers','tbl_suppliers.fld_id=tbl_purchase_draft.fld_supplier_id','left');
		
		
		$this->db->where('tbl_purchase_draft.fld_id',$id);
		
		$record=$this->db->get()->row_array();
		if($record){
			foreach($record as $key => $rec){
				
				$record['products']=$this->getPurchaseDraftProducts($id);
			}
		}
		return $record;
        
    }
	function getPurchaseProducts($id){
		
		$this->db->select('tbl_purchase_detail.*,tbl_category.*');
		
		$this->db->from('tbl_purchase_detail');
		
		$this->db->join('tbl_category','tbl_category.fld_id=tbl_purchase_detail.fld_product_id');
		
		$this->db->where('tbl_purchase_detail.fld_purchase_id',$id);
		
		return $this->db->get()->result_array();
	}
	function getPurchaseDraftProducts($id){
		
		$this->db->select('tbl_purchase_detail_draft.*,tbl_category.*');
		
		$this->db->from('tbl_purchase_detail_draft');
		
		$this->db->join('tbl_category','tbl_category.fld_id=tbl_purchase_detail_draft.fld_product_id','left');
		
		$this->db->where('tbl_purchase_detail_draft.fld_purchase_id',$id);
		
		return $this->db->get()->result_array();
	}
	function delete($id){
		$this->db->where('fld_id',$id);
		return $this->db->update('tbl_purchase',array('fld_isdeleted'=>1));
		// if($purchase){
			// $this->db->where('fld_purchase_id',$id);
			// return $this->db->delete('tbl_purchase_detail');
		// }
	}
	function deleteDraft($id){
		$this->db->where('fld_id',$id);
		$purchase=$this->db->delete('tbl_purchase_draft');
		if($purchase){
			$this->db->where('fld_purchase_id',$id);
			return $this->db->delete('tbl_purchase_detail_draft');
		}
	}
	function purchase_entry(){
		$purchase_id = date('YmdHis');
		$payment_type=0;
		if($this->input->post('fld_payment_status')  == 3){
			$payment_type=0;
		}else{
			$payment_type=$this->input->post('fld_payment_type');
		}
		$data = array(
            'fld_supplier_id'          => $this->input->post('fld_supplier_id',TRUE),
            'fld_invoice_no'        => $this->input->post('fld_invoice_no',TRUE),
            'fld_voucher_no' => $this->input->post('fld_voucher_no',TRUE),
            'fld_purchase_date'     => $this->input->post('fld_purchase_date',TRUE),
            'fld_shipment'      => $this->input->post('fld_shipment',TRUE),
            'fld_location_id'      => $this->input->post('fld_location',TRUE),
            'fld_grand_total_amount'   => $this->input->post('fld_grand_total_amount',TRUE),
            'fld_payment_status'        => $this->input->post('fld_payment_status',TRUE),
            'fld_payment_type'         => $payment_type,
            'fld_bank'             =>  $this->input->post('fld_bank',TRUE),
            'fld_cheque_number'            =>  $this->input->post('fld_cheque_number',TRUE),
            'fld_cheque_date'       =>  $this->input->post('fld_cheque_date',TRUE),
        );
		 $responce=$this->db->insert('tbl_purchase', $data);
		 if($responce){
			 $totalquantity=0;
		  $insert_id = $this->db->insert_id();
		  $p_id = $this->input->post('fld_product_id',TRUE);
		  $rate = $this->input->post('fld_unit_price',TRUE);
		  $quantity = $this->input->post('fld_quantity',TRUE);
		  $t_price = $this->input->post('fld_total_amount',TRUE);
		  for ($i = 0, $n = count($p_id); $i < $n; $i++) {
			$totalquantity=$totalquantity + $quantity[$i];
            $product_quantity = $quantity[$i];
            $product_rate = $rate[$i];
            $product_id = $p_id[$i];
            $total_price = $t_price[$i];
            // $disc = $discount[$i];
            $disc=0;

            $data1 = array(
                'fld_purchase_id'        => $insert_id,
                'fld_product_id'         => $product_id,
                'fld_quantity'           => $product_quantity,
                'fld_unit_price'               => $product_rate,
                'fld_total_amount'       => $total_price
            );

            if (!empty($quantity)) {
                $this->db->insert('tbl_purchase_detail', $data1);
            }
        }
		$locinsert=array(
		"fld_purchase_location_id"=>$this->input->post('fld_location',TRUE),
		"fld_parent_id"=>0,
		"fld_purch_type"=>1,
		"fld_purchase_id"=>$insert_id,
		);
		$this->db->insert('tbl_stock_locations', $locinsert);
		$locinsert_id = $this->db->insert_id();
		$stockinsert=array(
		"fld_stock_qty"=>$totalquantity,
		"fld_stock_loc_id"=>$locinsert_id,
		);
		$this->db->insert('tbl_stocks', $stockinsert);
		if($this->input->post('purchase_draft') != FALSE && $this->input->post('purchase_draft') == 1){
			$purchase_id =$this->input->post('purchase_id');
			$this->db->where('fld_id', $purchase_id);
			 $this->db->delete('tbl_purchase_draft');
			 $this->db->where('fld_purchase_id', $purchase_id);
			 $this->db->delete('tbl_purchase_detail_draft');
		}
		$this->session->set_userdata('success_message', "Purchase order added successfully.");
		return true;
		}else{
			$this->session->set_userdata('success_message', "Purchase order not added.");
			return false; 
		}
	}
	function purchase_draft_entry(){
		$purchase_id = date('YmdHis');
		$payment_type=0;
		if($this->input->post('fld_payment_status')  == 3){
			$payment_type=0;
		}else{
			$payment_type=$this->input->post('fld_payment_type');
		}
		$data = array(
            'fld_supplier_id'          => $this->input->post('fld_supplier_id',TRUE),
            'fld_invoice_no'        => $this->input->post('fld_invoice_no',TRUE),
            'fld_voucher_no' => $this->input->post('fld_voucher_no',TRUE),
            'fld_purchase_date'     => $this->input->post('fld_purchase_date',TRUE),
            'fld_shipment'      => $this->input->post('fld_shipment',TRUE),
            'fld_location'      => $this->input->post('fld_location',TRUE),
            'fld_grand_total_amount'   => $this->input->post('fld_grand_total_amount',TRUE),
            'fld_payment_status'        => $this->input->post('fld_payment_status',TRUE),
            'fld_payment_type'         => $payment_type,
            'fld_bank'             =>  $this->input->post('fld_bank',TRUE),
            'fld_cheque_number'            =>  $this->input->post('fld_cheque_number',TRUE),
            'fld_cheque_date'       =>  $this->input->post('fld_cheque_date',TRUE),
        );
		  $responce=$this->db->insert('tbl_purchase_draft', $data);
		  if($responce){
		  $insert_id = $this->db->insert_id();
		  $p_id = $this->input->post('fld_product_id',TRUE);
		  $rate = $this->input->post('fld_unit_price',TRUE);
		  $quantity = $this->input->post('fld_quantity',TRUE);
		  $t_price = $this->input->post('fld_total_amount',TRUE);
		  for ($i = 0, $n = count($p_id); $i < $n; $i++) {
            $product_quantity = $quantity[$i];
            $product_rate = $rate[$i];
            $product_id = $p_id[$i];
            $total_price = $t_price[$i];
            // $disc = $discount[$i];
            $disc=0;

            $data1 = array(
                'fld_purchase_id'        => $insert_id,
                'fld_product_id'         => $product_id,
                'fld_quantity'           => $product_quantity,
                'fld_unit_price'               => $product_rate,
                'fld_total_amount'       => $total_price
            );

            if (!empty($quantity)) {
                $this->db->insert('tbl_purchase_detail_draft', $data1);
            }
        }
		
			$res=array('responce'=>'success',"message"=>"Purchase order added in draft successfully.");
			return $res;
		}else{
			$res=array('responce'=>'error',"message"=>"Purchase order not added in draft.Something went wrong.");
			return $res;
		}
	}
	function supplier_entry(){
		$data = array(
            'fld_supplier_code' => $this->input->post('fld_supplier_code',TRUE),
            'fld_company_name'       => $this->input->post('fld_company_name',TRUE),
            'fld_supplier_name'      => $this->input->post('fld_supplier_name',TRUE),
            'fld_mobile_num'        => $this->input->post('fld_mobile_num',TRUE),
            'fld_landline_num'         => $this->input->post('fld_landline_num',TRUE),
            'fld_opening_bal'       => $this->input->post('fld_opening_bal',TRUE),
            'fld_supplier_type'   => $this->input->post('fld_supplier_type',TRUE),
            'fld_email' => $this->input->post('fld_email',TRUE),
            'fld_cnic'           => $this->input->post('fld_cnic',TRUE),
            'fld_city'          => $this->input->post('fld_city',TRUE),
            'fld_ntn'         => $this->input->post('fld_ntn',TRUE),
            'fld_city_area'           => $this->input->post('fld_city_area',TRUE),
            'fld_country'       => $this->input->post('fld_country',TRUE),
            'fld_status'        => 1
        );
         
       return $this->db->insert('tbl_suppliers',$data);
		
	}
	function purchase_update_entry(){
		$purchase_id =$this->input->post('purchase_id');
		$payment_type=0;
		if($this->input->post('fld_payment_status')  == 3){
			$payment_type=0;
		}else{
			$payment_type=$this->input->post('fld_payment_type');
		}
		$data = array(
            'fld_supplier_id'          => $this->input->post('fld_supplier_id',TRUE),
            'fld_invoice_no'        => $this->input->post('fld_invoice_no',TRUE),
            'fld_voucher_no' => $this->input->post('fld_voucher_no',TRUE),
            'fld_purchase_date'     => $this->input->post('fld_purchase_date',TRUE),
            'fld_shipment'      => $this->input->post('fld_shipment',TRUE),
			'fld_location_id'      => $this->input->post('fld_location',TRUE),
            'fld_grand_total_amount'   => $this->input->post('fld_grand_total_amount',TRUE),
            'fld_payment_status'        => $this->input->post('fld_payment_status',TRUE),
            'fld_payment_type'         => $payment_type,
            'fld_bank'             =>  $this->input->post('fld_bank',TRUE),
            'fld_cheque_number'            =>  $this->input->post('fld_cheque_number',TRUE),
            'fld_cheque_date'       =>  $this->input->post('fld_cheque_date',TRUE),
        );
		 $this->db->where('fld_purchase_id', $purchase_id);
		$responce= $this->db->update('tbl_purchase', $data);
		if($responce){
			 $this->db->where('fld_purchase_id', $purchase_id);
			 $this->db->delete('tbl_purchase_detail');
		  $p_id = $this->input->post('fld_product_id',TRUE);
		  $rate = $this->input->post('fld_unit_price',TRUE);
		  $quantity = $this->input->post('fld_quantity',TRUE);
		  $t_price = $this->input->post('fld_total_amount',TRUE);
		  for ($i = 0, $n = count($p_id); $i < $n; $i++) {
            $product_quantity = $quantity[$i];
            $product_rate = $rate[$i];
            $product_id = $p_id[$i];
            $total_price = $t_price[$i];
            // $disc = $discount[$i];
            $disc=0;

            $data1 = array(
                'fld_purchase_id'        => $purchase_id,
                'fld_product_id'         => $product_id,
                'fld_quantity'           => $product_quantity,
                'fld_unit_price'               => $product_rate,
                'fld_total_amount'       => $total_price
            );

            if (!empty($quantity)) {
                $this->db->insert('tbl_purchase_detail', $data1);
            }
        }
		
		$this->session->set_userdata('success_message', "Purchase order updated successfully.");
		return true;
		}else{
			$this->session->set_userdata('error_message', "Purchase order not updated.Something went wrong.");
			return true;
		}
		  
	}
	
	function purchase_draft_update_entry(){
		$purchase_id =$this->input->post('purchase_id');
		$payment_type=0;
		if($this->input->post('fld_payment_status')  == 3){
			$payment_type=0;
		}else{
			$payment_type=$this->input->post('fld_payment_type');
		}
		$data = array(
            'fld_supplier_id'          => $this->input->post('fld_supplier_id',TRUE),
            'fld_invoice_no'        => $this->input->post('fld_invoice_no',TRUE),
            'fld_voucher_no' => $this->input->post('fld_voucher_no',TRUE),
            'fld_purchase_date'     => $this->input->post('fld_purchase_date',TRUE),
            'fld_shipment'      => $this->input->post('fld_shipment',TRUE),
			'fld_location'      => $this->input->post('fld_location',TRUE),
            'fld_grand_total_amount'   => $this->input->post('fld_grand_total_amount',TRUE),
            'fld_payment_status'        => $this->input->post('fld_payment_status',TRUE),
            'fld_payment_type'         => $payment_type,
            'fld_bank'             =>  $this->input->post('fld_bank',TRUE),
            'fld_cheque_number'            =>  $this->input->post('fld_cheque_number',TRUE),
            'fld_cheque_date'       =>  $this->input->post('fld_cheque_date',TRUE),
        );
		 $this->db->where('fld_id', $purchase_id);
		$responce= $this->db->update('tbl_purchase_draft', $data);
		if($responce){
		  $this->db->where('fld_purchase_id', $purchase_id);
		  $this->db->delete('tbl_purchase_detail_draft');
		  $p_id = $this->input->post('fld_product_id',TRUE);
		  $rate = $this->input->post('fld_unit_price',TRUE);
		  $quantity = $this->input->post('fld_quantity',TRUE);
		  $t_price = $this->input->post('fld_total_amount',TRUE);
		  for ($i = 0, $n = count($p_id); $i < $n; $i++) {
            $product_quantity = $quantity[$i];
            $product_rate = $rate[$i];
            $product_id = $p_id[$i];
            $total_price = $t_price[$i];
            // $disc = $discount[$i];
            $disc=0;

            $data1 = array(
                'fld_purchase_id'        => $purchase_id,
                'fld_product_id'         => $product_id,
                'fld_quantity'           => $product_quantity,
                'fld_unit_price'               => $product_rate,
                'fld_total_amount'       => $total_price
            );

            if (!empty($quantity)) {
                $this->db->insert('tbl_purchase_detail_draft', $data1);
            }
        }
			$res=array('responce'=>'success',"message"=>"Purchase order updated in draft successfully.");
			return $res;
		}else{
			$res=array('responce'=>'error',"message"=>"Purchase order not updated in draft.Something went wrong.");
			return $res;
		}
		  
	}
    public function generator($lenth) {
        $number = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "N", "M", "O", "P", "Q", "R", "S", "U", "V", "T", "W", "X", "Y", "Z", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "1", "2", "3", "4", "5", "6", "7", "8", "9", "0");

        for ($i = 0; $i < $lenth; $i++) {
            $rand_value = rand(0, 61);
            $rand_number = $number["$rand_value"];

            if (empty($con)) {
                $con = $rand_number;
            } else {
                $con = "$con" . "$rand_number";
            }
        }
        return $con;
    }
   
}
