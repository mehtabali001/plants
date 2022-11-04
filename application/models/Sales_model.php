<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sales_model extends CI_Model {
 
    public function __construct() {
        parent::__construct();
    }

    function getMaxsuplierID() {
		$sql="SHOW TABLE STATUS LIKE 'tbl_sale'";
		return $this->db->query($sql)->row_array();
        
    }
	function getAllProducts() {
		
		$this->db->select('tbl_category.*,tbl_units.fld_unit');
		
		$this->db->from('tbl_category');
		
		$this->db->join('tbl_units','tbl_units.fld_id=tbl_category.fld_unit','left');
		
		return $this->db->get()->result_array();
        
    }
	function getAllSales() {
		
		$this->db->select('tbl_sale.*,tbl_customers.fld_customer_code,tbl_customers.fld_company_name,tbl_customers.fld_customer_name');
		$this->db->from('tbl_sale');
		$this->db->join('tbl_customers','tbl_customers.fld_id=tbl_sale.fld_customer_id');
		$this->db->where('tbl_sale.fld_isdeleted',0);
		$this->db->order_by('fld_id', 'DESC');
		return $this->db->get()->result_array();
    }
    
	function getAllDraftSales() {
		$this->db->select('tbl_sale_drafts.*,tbl_customers.fld_customer_code,tbl_customers.fld_company_name,tbl_customers.fld_customer_name');
		$this->db->from('tbl_sale_drafts');
		$this->db->where('tbl_sale_drafts.fld_userid',$this->session->userdata('user_id'));
		$this->db->join('tbl_customers','tbl_customers.fld_id=tbl_sale_drafts.fld_customer_id');
		return $this->db->get()->result_array();
    }
    
	function getSaleByID($id) {
		
		$this->db->select('tbl_sale.*,tbl_customers.fld_customer_name,tbl_locations.fld_location,tbl_locations.fld_address');
		$this->db->from('tbl_sale');
		$this->db->join('tbl_customers','tbl_customers.fld_id=tbl_sale.fld_customer_id');
		$this->db->join('tbl_locations','tbl_locations.fld_id=tbl_sale.fld_location_id','left');
		$this->db->where('tbl_sale.fld_id',$id);
		$record=$this->db->get()->row_array();
		if($record){
			foreach($record as $key => $rec){
				$record['products']=$pp=$this->getSaleProducts($id);
				foreach($pp as $pro){
				    $record['fld_product_id'] = $pro['fld_product_id'];
				}
			}
		}
		return $record;
    }
    
	function getSaleDraftByID($id) {
		
		$this->db->select('tbl_sale_drafts.*,tbl_customers.fld_customer_name');
		$this->db->from('tbl_sale_drafts');
		$this->db->join('tbl_customers','tbl_customers.fld_id=tbl_sale_drafts.fld_customer_id');
		$this->db->join('tbl_locations','tbl_locations.fld_id=tbl_sale_drafts.fld_location_id','left');
		$this->db->where('tbl_sale_drafts.fld_id',$id);
		$record=$this->db->get()->row_array();
		if($record){
			foreach($record as $key => $rec){
				$record['products']=$this->getSaleDraftProducts($id);
			}
		}
		return $record;
    }
    
	function getSaleProducts($id){
		$this->db->select('tbl_sale_detail.*,tbl_category.*,tbl_subcategory.fld_subcategory');
		$this->db->from('tbl_sale_detail');
		$this->db->join('tbl_category','tbl_category.fld_id=tbl_sale_detail.fld_product_id');
		$this->db->join('tbl_subcategory','tbl_subcategory.fld_subcid=tbl_sale_detail.fld_subproduct_id');
		$this->db->where('tbl_sale_detail.fld_sale_id',$id);
		return $this->db->get()->result_array();
	}
	
	function getSaleDraftProducts($id){
		$this->db->select('tbl_sale_detail_drafts.*,tbl_category.*,tbl_subcategory.fld_subcategory');
		$this->db->from('tbl_sale_detail_drafts');
		$this->db->join('tbl_category','tbl_category.fld_id=tbl_sale_detail_drafts.fld_product_id');
		$this->db->join('tbl_subcategory','tbl_subcategory.fld_subcid=tbl_sale_detail_drafts.fld_subproduct_id');
		$this->db->where('tbl_sale_detail_drafts.fld_sale_id',$id);
		return $this->db->get()->result_array();
	}
	
	function delete($id){
	    $user_id = $this->session->userdata('user_id');
		$this->db->where('fld_id',$id);
		//$this->db->set('fld_trash_date', 'NOW()', FALSE);
		//date("Y-m-d H:i:s")
		return $this->db->update('tbl_sale',array('fld_trash_date'=>date("Y-m-d H:i:s"),'fld_isdeleted'=>1, 'fld_trash_by' => $user_id));
		// if($purchase){
		// $this->db->where('fld_purchase_id',$id);
		// return $this->db->delete('tbl_purchase_detail');
		// }
	}
	
	function restore($id){
		$this->db->where('fld_id',$id);
		return $this->db->update('tbl_sale',array('fld_isdeleted'=>0));
	}
	
	function permanentdelete($id){
	    
	    $v_id = $this->db->query("SELECT id FROM tbl_transections_master WHERE type='Sale' AND type_id = '$id'")->row()->id;
	    
	    $this->db->where('v_id',$v_id);
	    $this->db->delete('tbl_transections_details');
	    
	    $this->db->where('id',$v_id);
	    $this->db->delete('tbl_transections_master');
	    
		$this->db->where('fld_id',$id);
		return $this->db->delete('tbl_sale');
	}
	
	function permanentdeletedetail($id){
		$this->db->where('fld_sale_id',$id);
		return $this->db->delete('tbl_sale_detail');
	}
	
	function deleteDraft($id){
		$this->db->where('fld_id',$id);
		$purchase=$this->db->delete('tbl_sale_drafts');
		if($purchase){
			$this->db->where('fld_sale_id',$id);
			return $this->db->delete('tbl_sale_detail_drafts');
		}
	}
	
	function sale_entry(){

		$sale_id = $this->input->post('fld_payment_type');
		if(!empty($sale_id)){
		    $this->db->where('fld_sale_id', $sale_id);
			$this->db->delete('tbl_sale_detail_drafts'); 
			$this->db->where('fld_id', $sale_id);
			$this->db->delete('tbl_sale_drafts');
		}
		
		if(!$this->check_available_qty()){
		    $this->session->set_userdata('error_message', "Selected Quantity is exceeded from the available quantity.");
		    return;
		    exit;
		}
		
		$payment_type=$this->input->post('fld_payment_type');
		$paid_amount=$this->input->post('fld_paid_amount');
		$user_id=$this->session->userdata('user_id');
		$discount = $this->input->post('fld_discount',TRUE);
		$discount_per_kg = $discount/11.8;
		$data = array(
			'fld_userid'             =>     $user_id,
 			'fld_stock_location_id'  =>     $this->input->post('stock_location_id',TRUE),
            'fld_customer_id'        =>     $this->input->post('fld_customer_id',TRUE),
            'fld_invoice_no'         =>     $this->input->post('fld_invoice_no',TRUE),
            'fld_voucher_no'         =>     'SI-'.sprintf('%04d', $this->getMaxsuplierID()['Auto_increment']),
            'fld_sale_date'          =>     date('Y-m-d',strtotime(str_replace('/', '-', $this->input->post('fld_sale_date',TRUE)))),
            //'fld_shipment'         =>     $this->input->post('fld_shipment',TRUE),
            'fld_location_id'        =>     $this->input->post('fld_location',TRUE),
            'fld_vehicle_no'         =>     $this->input->post('fld_vehicle_no',TRUE),
            'fld_discount'           =>     $this->input->post('fld_discount',TRUE),
            'fld_total_discount'     =>     $this->input->post('fld_total_discount',TRUE),
            'fld_grand_total_amount' =>     $this->input->post('fld_grand_total_amount',TRUE),
            'fld_payment_status'     =>     1,
            'fld_payment_type'       =>     $payment_type,
            'fld_bank'               =>     $this->input->post('fld_bank',TRUE),
            'fld_cheque_number'      =>     $this->input->post('fld_cheque_number',TRUE),
            'fld_cheque_date'        =>     $this->input->post('fld_cheque_date',TRUE),
            'fld_created_date'       =>  date("Y-m-d H:i:s")
        );
		 $responce = $this->db->insert('tbl_sale', $data);
		 if($responce){
		    $insert_id = $this->db->insert_id();
		    $this->session->set_userdata('sale_inserted_id',$insert_id);
		      $customer = $this->db->select('*')->from('tbl_customers')->where('fld_id',$data['fld_customer_id'])->get()->row();
		      $narration = $customer->fld_company_name.'('.$customer->fld_customer_name.'), ';
		  $totalquantity = 0;
		 
		  $p_id = $this->input->post('fld_category',TRUE);
		  $stock_location = $this->input->post('stock_location',TRUE);
		  $shipment = $this->input->post('fld_shipment',TRUE);
		  $sp_id = $this->input->post('fld_subcat_id',TRUE);
		  $rate = $this->input->post('fld_unit_price',TRUE);
		  $quantity = $this->input->post('fld_quantity',TRUE);
		  $weight = $this->input->post('fld_weight', TRUE);
		  $t_price = $this->input->post('fld_total_amount',TRUE);
		  $fld_row_discount = $this->input->post('fld_row_discount', TRUE);
		  
		  $total_inventory_amount = 0;
		  $total_inventory_amount_gl = 0;
		  for ($i = 0, $n = count($sp_id); $i < $n; $i++) {
    // 	    	$totalquantity=$totalquantity + $quantity;
                $product_quantity = $quantity[$i];
                $product_rate = $rate[$i];
                $product_weight = $weight[$i];
                $product_id = $p_id;
                $subproduct_id = $sp_id[$i];
                $total_price = $t_price[$i];
                $fld_discount = round($fld_row_discount[$i],2);
                $fld_shipment = $shipment[$i];
                $stock_location_id = $stock_location[$i];
                // $disc = $discount[$i];
                $disc=0;
            $item = $this->db->select('*')->from('tbl_subcategory')->where('fld_subcid',$subproduct_id)->get()->row()->fld_subcategory;
            $narration .= $item.' (Q)'.$product_quantity.' (Rs)'.$product_rate.' (Disc.Rs)'.$fld_discount.', ';
            $data1 = array(
                'fld_sale_id'        => $insert_id,
                'fld_stock_location_id' => $stock_location_id,
                'fld_shipment'        => $fld_shipment,
                'fld_product_id'         => $product_id,
                'fld_subproduct_id'      => $subproduct_id,
                'fld_quantity'           => $product_quantity,
                'fld_weight'             => $product_weight,
                'fld_discount'             => $fld_discount,
                'fld_unit_price'         => $product_rate,
                'fld_total_amount'       => $total_price
            );
            
            $stock_location_data = $this->db->query("SELECT * FROM `tbl_stock_locations` WHERE fld_id = '$stock_location_id'")->row_array();
    		$fright = 0;
    		if($stock_location_data['fld_nav_id'] != 0){
    		    $fright = $this->db->query("SELECT * FROM `tbl_navigations` WHERE fld_id = '{$stock_location_data['fld_nav_id']}'")->row()->fld_freight_MT;
    		}
    		if($data1['fld_product_id']==1){
    		    if($stock_location_data['fld_purchase_id'] != 0){
    		        $purchasePrice = $this->db->query("SELECT a.fld_unit_price FROM tbl_purchase_detail a, tbl_purchase b WHERE b.fld_id = a.fld_purchase_id && a.fld_product_id = '1' && b.fld_id = '{$stock_location_data['fld_purchase_id']}'")->row_array();
        		    $price = $purchasePrice['fld_unit_price']/1000;
        		    $total_amount = $data1['fld_weight']*$price;
        		    $total_amount += ($data1['fld_weight']*($fright/1000));
    		    }else{
    		        $purchasePrice = $this->db->query("SELECT a.fld_unit_price FROM tbl_gainloss_details a WHERE  a.fld_id = '{$stock_location_data['fld_gl_id']}'")->row_array();
        		    $price = $purchasePrice['fld_unit_price'];
        		    $total_amount = $data1['fld_weight']*$price;
    		    }
    		    
    		}else{
    		    $purchasePrice = $this->db->query("SELECT a.fld_unit_price FROM tbl_purchase_detail a, tbl_purchase b WHERE b.fld_id = a.fld_purchase_id && a.fld_product_id = '{$data1['fld_product_id']}' && a.fld_subproduct_id = '{$data1['fld_subproduct_id']}' && b.fld_id = '{$stock_location_data['fld_purchase_id']}'")->row_array();
    		    $price = $purchasePrice['fld_unit_price'];
    		    $total_amount = $price;
    		    $total_amount += ($fright);
    		}
    		$data1['fld_purchase_amount'] = $total_amount;
    		 if (!empty($quantity)) {
                $this->db->insert('tbl_sale_detail', $data1);
            }
    		
    		if($stock_location_data['fld_purchase_id'] != 0){
    		    $total_inventory_amount += $total_amount;
    		}else{
    		    $total_inventory_amount_gl += $total_amount;
    		}
    		
    		
		  }
        
// 		if($this->input->post('purchase_draft') != FALSE && $this->input->post('purchase_draft') == 1){
// 			$purchase_id =$this->input->post('purchase_id');
// 			$this->db->where('fld_id', $purchase_id);
// 			 $this->db->delete('tbl_purchase_draft');
// 			 $this->db->where('fld_purchase_id', $purchase_id);
// 			 $this->db->delete('tbl_purchase_detail_draft');
// 		}

	    $coa_id = $this->db->query("select accounts_id from tbl_customers where fld_id = '{$data['fld_customer_id']}'")->row()->accounts_id;
		$now = date('Y-m-d H:i:s');
		$this->db->query("INSERT into tbl_transections_master SET type = 'Sale', type_id = '$insert_id', date = '{$data['fld_sale_date']}', user_id = '$user_id', created_date = '$now'");
		$v_id = $this->db->insert_id();
		$narration = rtrim($narration, ', ');
		
		if($payment_type==1){
		    $payment_r_account = $this->db->query("select * from tbl_locations where fld_id = '{$data['fld_location_id']}'")->row()->cash_in_hand;
		}elseif($payment_type==2){
		    $payment_r_account = $this->db->query("select * from tbl_banks where fld_id = '{$data['fld_bank']}'")->row()->accounts_id;
		}
		
    	$total_inventory_amount =	$total_inventory_amount + $total_inventory_amount_gl;
		if($total_inventory_amount > 0){
		    $getfInvetory_id = $this->db->query("SELECT * FROM tbl_locations WHERE fld_id = '{$data['fld_location_id']}'")->row()->inventory_account;
		    $this->db->query("INSERT INTO tbl_transections_details SET v_id = '$v_id', coa_id = '$getfInvetory_id', narration = '$narration', credit = '$total_inventory_amount'");
		}
		
// 		if($total_inventory_amount_gl > 0){
// 		    $this->db->query("INSERT INTO tbl_transections_details SET v_id = '$v_id', coa_id = '101003001', narration = '$narration', credit = '$total_inventory_amount_gl'");
// 		}
		
		$this->db->query("INSERT INTO tbl_transections_details SET v_id = '$v_id', coa_id = '$coa_id', narration = '$narration', debit = '{$data['fld_grand_total_amount']}'");
		if(!empty($paid_amount) && $payment_type != 0){
		    $this->db->query("INSERT INTO tbl_transections_details SET v_id = '$v_id', coa_id = '$coa_id', narration = '$narration', credit = '$paid_amount'");
		    $this->db->query("INSERT INTO tbl_transections_details SET v_id = '$v_id', coa_id = '$payment_r_account', narration = '$narration', debit = '$paid_amount'");
		}
		/****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$user_id=$this->session->userdata('user_id');
		$sale_no='SI-'.sprintf('%04d', $insert_id);
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
        $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
        $date=date('Y-m-d H:i:s');
		$sale_no='<a href="'.base_url('Sales/detail/'.$insert_id.'').'">'.$sale_no.'</a>';
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'ADD',fld_detail='$sale_no',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
    		$this->session->set_userdata('success_message', "Sale order added successfully.");
    		return true;
		}else{
			$this->session->set_userdata('success_message', "Sale order not added.");
			return false; 
		}
	}
	
	function sale_update_entry(){
		$sale_id =$this->input->post('sale_id');
		$payment_type=0;
		
		$payment_type=$this->input->post('fld_payment_type');
		$paid_amount=$this->input->post('fld_paid_amount');
		
		$data = array(
            'fld_customer_id'          => $this->input->post('fld_customer_id',TRUE),
            'fld_invoice_no'        => $this->input->post('fld_invoice_no',TRUE),
            'fld_voucher_no' => $this->input->post('fld_voucher_no',TRUE),
            'fld_sale_date'     => date('Y-m-d',strtotime(str_replace('/', '-', $this->input->post('fld_sale_date',TRUE)))),
            //'fld_shipment'      => $this->input->post('fld_shipment',TRUE),
			'fld_location_id'      => $this->input->post('fld_location',TRUE),
			'fld_vehicle_no'      => $this->input->post('fld_vehicle_no',TRUE),
			'fld_discount' => $this->input->post('fld_discount',TRUE),
            'fld_total_discount' => $this->input->post('fld_total_discount',TRUE),
            'fld_grand_total_amount'   => $this->input->post('fld_grand_total_amount',TRUE),
            'fld_payment_type'         => $payment_type,
            'fld_bank'             =>  $this->input->post('fld_bank',TRUE),
            'fld_cheque_number'            =>  $this->input->post('fld_cheque_number',TRUE),
            'fld_cheque_date'       =>  $this->input->post('fld_cheque_date',TRUE),
            'fld_updated_by'       =>  $this->session->userdata('user_id'),
            'fld_updated_date'   =>  date("Y-m-d H:i:s")
        );
		// echo '<pre>';
		// print_r($_POST);
		// print_r($data);
		// exit;
		 $this->db->where('fld_id', $sale_id);
		// $this->db->set('fld_updated_date', 'NOW()', FALSE);
		$responce= $this->db->update('tbl_sale', $data);
		if($responce){
			$customer = $this->db->select('*')->from('tbl_customers')->where('fld_id',$data['fld_customer_id'])->get()->row();
		      $narration = $customer->fld_company_name.'('.$customer->fld_customer_name.'), ';
		  $sdid = $this->input->post('sdid',TRUE);
		  $p_id = $this->input->post('fld_category',TRUE);
		  $sp_id = $this->input->post('fld_subcat_id',TRUE);
		  $rate = $this->input->post('fld_unit_price',TRUE);
		  $shipment = $this->input->post('fld_shipment',TRUE);
		  $quantity = $this->input->post('fld_quantity',TRUE);
		  $t_price = $this->input->post('fld_total_amount',TRUE);
		  $fld_row_discount = $this->input->post('fld_row_discount', TRUE);
		  $stock_location = $this->input->post('stock_location',TRUE);
		  $weight = $this->input->post('fld_weight', TRUE);
		  
		  $total_inventory_amount = 0;
		  for ($i = 0, $n = count($sdid); $i < $n; $i++) {
		      $sd_id = $sdid[$i];
		    $shipmentss = $shipment[$i];    
            $product_quantity = $quantity[$i];
            $total_price = $t_price[$i];
            $product_rate = $rate[$i];
            $fld_discount = $fld_row_discount[$i];
            $subproduct_id = $sp_id[$i];
            $product_id = $p_id[$i];
            $product_weight = $weight[$i];
            
            $stock_location_id = $stock_location[$i];
            $item = $this->db->select('*')->from('tbl_subcategory')->where('fld_subcid',$subproduct_id)->get()->row()->fld_subcategory;
            $narration .= $item.' (Q)'.$product_quantity.' (Rs)'.$product_rate.' (Disc.Rs)'.$fld_discount.', ';
            $data1 = array(
                'fld_shipment'        => $shipmentss,
                'fld_quantity'           => $product_quantity,
                'fld_total_amount'       => $total_price,
                'fld_discount'           => $fld_discount
            );
            
            $stock_location_data = $this->db->query("SELECT * FROM `tbl_stock_locations` WHERE fld_id = '$stock_location_id'")->row_array();
    		$fright = 0;
    		if($stock_location_data['fld_nav_id'] != 0){
    		    $fright = $this->db->query("SELECT * FROM `tbl_navigations` WHERE fld_id = '{$stock_location_data['fld_nav_id']}'")->row()->fld_freight_MT;
    		} 
    		if($product_id==1){
    		    $purchasePrice = $this->db->query("SELECT a.fld_unit_price FROM tbl_purchase_detail a, tbl_purchase b WHERE b.fld_id = a.fld_purchase_id && a.fld_product_id = '1' && b.fld_id = '{$stock_location_data['fld_purchase_id']}'")->row_array();
    		    $price = $purchasePrice['fld_unit_price']/1000;
    		    $total_amount = $product_weight*$price;
    		    $total_amount += ($product_weight*($fright/1000));
    		}else{
    		    $purchasePrice = $this->db->query("SELECT a.fld_unit_price FROM tbl_purchase_detail a, tbl_purchase b WHERE b.fld_id = a.fld_purchase_id && a.fld_product_id = '$product_id' && a.fld_subproduct_id = '$subproduct_id' && b.fld_id = '{$stock_location_data['fld_purchase_id']}'")->row_array();
    		    $price = $purchasePrice['fld_unit_price'];
    		    $total_amount = $price;
    		    $total_amount += ($fright);
    		}
    		$data1['fld_purchase_amount'] = $total_amount;

            if (!empty($quantity)) {
                $this->db->where('fld_id', $sd_id);
		        $responce= $this->db->update('tbl_sale_detail', $data1);
            }
            if($stock_location_data['fld_purchase_id'] != 0){
    		    $total_inventory_amount += $total_amount;
    		}else{
    		    $total_inventory_amount_gl += $total_amount;
    		}
        }
        
        $coa_id = $this->db->query("select accounts_id from tbl_customers where fld_id = '{$data['fld_customer_id']}'")->row()->accounts_id;
		$v_id = $this->db->query("SELECT id FROM tbl_transections_master WHERE type='Sale' AND type_id = '$sale_id'")->row()->id;
		$narration = rtrim($narration, ', ');
		
		if($payment_type==1){
		    $payment_r_account = $this->db->query("select * from tbl_locations where fld_id = '{$data['fld_location_id']}'")->row()->cash_in_hand;
		}elseif($payment_type==2){
		    $payment_r_account = $this->db->query("select * from tbl_banks where fld_id = '{$data['fld_bank']}'")->row()->accounts_id;
		}
		
		$this->db->where('v_id',$v_id);
	    $this->db->delete('tbl_transections_details');
		
    	$total_inventory_amount =	$total_inventory_amount + $total_inventory_amount_gl;
		if($total_inventory_amount > 0){
		    $getfInvetory_id = $this->db->query("SELECT * FROM tbl_locations WHERE fld_id = '{$data['fld_location_id']}'")->row()->inventory_account;
		    $this->db->query("INSERT INTO tbl_transections_details SET v_id = '$v_id', coa_id = '$getfInvetory_id', narration = '$narration', credit = '$total_inventory_amount'");
		}
		
		$this->db->query("INSERT INTO tbl_transections_details SET v_id = '$v_id', coa_id = '$coa_id', narration = '$narration', debit = '{$data['fld_grand_total_amount']}'");
		if(!empty($paid_amount) && $payment_type != 0){
		    $this->db->query("INSERT INTO tbl_transections_details SET v_id = '$v_id', coa_id = '$coa_id', narration = '$narration', credit = '$paid_amount'");
		    $this->db->query("INSERT INTO tbl_transections_details SET v_id = '$v_id', coa_id = '$payment_r_account', narration = '$narration', debit = '$paid_amount'");
		}
		
		/****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$user_id=$this->session->userdata('user_id');
		$sale_no='SI-'.sprintf('%04d', $sale_id);
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
        $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
        $date=date('Y-m-d H:i:s');
		$sale_no='<a href="'.base_url('Sales/detail/'.$sale_id.'').'">'.$sale_no.'</a>';
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'UPDATE',fld_detail='$sale_no',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
		$this->session->set_userdata('success_message', "Sale order updated successfully.");
		return true;
		}else{
			$this->session->set_userdata('error_message', "Sale order not updated.Something went wrong.");
			return true;
		}
		  
	}
	
	function check_available_qty(){
	    $isLimitedExeeded = true;
		$product_id = $this->input->post('fld_category',TRUE);
		$arraydata = array();
		
		foreach($_POST['stock_location'] as $key=>$value){
		    $arrayvalues = array();
		    $arrayvalues['id'] = $value;
		    if($product_id==1){
		        $arrayvalues['qty'] = $_POST['fld_weight'][$key];
		    }else{
		        $arrayvalues['qty'] = $_POST['fld_quantity'][$key];
		    }
		    
		    $arraydata[] = $arrayvalues;
		}
		
		$result = array();
        foreach($arraydata as $v) {
            $id = $v['id'];
            $result[$id][] = $v['qty'];
        }
        
        $new = array();
        foreach($result as $key => $value) {
            $new[] = array('id' => $key, 'qty' => array_sum($value));
        }
        
        foreach($new as $row){
            $stock = $this->ShipmentByID($row['id']);
            $totalSale = 0;
            $totalsaleq = $this->db->query("SELECT sc.fld_subcategory, sc.weight, b.fld_quantity as fld_quantity FROM tbl_sale as a, tbl_sale_detail as b, tbl_subcategory as sc WHERE b.fld_stock_location_id = '{$row['id']}' AND b.fld_sale_id = a.fld_id AND sc.fld_subcid = b.fld_subproduct_id && a.fld_isdeleted = 0")->result_array();
			    foreach($totalsaleq as $tsale){
			        if($product_id==1){
			            $totalSale += $tsale['weight']*$tsale['fld_quantity'];
			        }else{
			            $totalSale += $tsale['fld_quantity'];
			        }
                    
                }
                 
                if($product_id==1){
                    
                    $totalSale = round($totalSale/1000, 3);
                }
                    
                
            
                $gl_diff = $this->db->query("SELECT IFNULL(SUM(fld_quantity), 0) as qty FROM tbl_gainloss_details WHERE fld_type = 3 && fld_stock_location_id = '{$row['id']}'")->row_array();
                $totalDiff = round($gl_diff['qty']/1000, 3); 
                
                $showqty = round((($stock['fld_stock_qty']-$totalSale)+$totalDiff), 3);
                
                if($product_id==1){
                    if(($row['qty']/1000) > $showqty){
                        $isLimitedExeeded = false;
                    }
                }else{
                    if($row['qty'] > $showqty){
                        $isLimitedExeeded = false;
                    }
                }
                
            // echo $stock['fld_shipment'].'-'.$showqty.'<br>';
            // echo $row['id'];
        }
        return $isLimitedExeeded;
	}
	
	function sale_draft_entry_autosave(){
		$sale_id = date('YmdHis');
		$payment_type=0;
		if($this->input->post('fld_payment_status')  == 3){
			$payment_type=0;
		}else{
			$payment_type=$this->input->post('fld_payment_type');
		}

		$user_id=$this->session->userdata('user_id');
		$discount = $this->input->post('fld_discount',TRUE);
		$discount_per_kg = $discount/11.8;
		$data = array(
            'fld_userid'        => $user_id,
// 			'fld_stock_location_id'          => $this->input->post('stock_location_id',TRUE),
            'fld_customer_id'          => $this->input->post('fld_customer_id',TRUE),
            'fld_invoice_no'        => $this->input->post('fld_invoice_no',TRUE),
            'fld_voucher_no' => $this->input->post('fld_voucher_no',TRUE),
            'fld_sale_date'     => date('Y-m-d',strtotime(str_replace('/', '-', $this->input->post('fld_sale_date',TRUE)))),
            // 'fld_shipment'      => $this->input->post('fld_shipment',TRUE),
            'fld_location_id'      => $this->input->post('fld_location',TRUE),
            'fld_vehicle_no'       => $this->input->post('fld_vehicle_no',TRUE),
            'fld_discount' => $this->input->post('fld_discount',TRUE),
            'fld_total_discount' => $this->input->post('fld_total_discount',TRUE),
            'fld_grand_total_amount'   => $this->input->post('fld_grand_total_amount',TRUE),
            'fld_payment_status'        => $this->input->post('fld_payment_status',TRUE),
            'fld_payment_type'         => $payment_type,
            'fld_bank'             =>  $this->input->post('fld_bank',TRUE),
            'fld_cheque_number'            =>  $this->input->post('fld_cheque_number',TRUE),
            'fld_cheque_date'       =>  $this->input->post('fld_cheque_date',TRUE),
            'fld_created_date'   =>  date("Y-m-d H:i:s")
        );
		  $responce=$this->db->insert('tbl_sale_drafts', $data);
		  if($responce){
		  $totalquantity=0;
		  $insert_id = $this->db->insert_id();
		  $p_id = $this->input->post('fld_category',TRUE);
		  $shipment = $this->input->post('fld_shipment',TRUE);
		  $sp_id = $this->input->post('fld_subcat_id',TRUE);
		  $rate = $this->input->post('fld_unit_price',TRUE);
		  $quantity = $this->input->post('fld_quantity',TRUE);
		  $weight = $this->input->post('fld_weight', TRUE);
		  $t_price = $this->input->post('fld_total_amount',TRUE);
		  $fld_row_discount = $this->input->post('fld_row_discount', TRUE);
		  for ($i = 0, $n = count($sp_id); $i < $n; $i++) {
// 			$totalquantity=$totalquantity + $quantity;
            $product_quantity = $quantity[$i];
            $product_rate = $rate[$i];
            $product_weight = $weight[$i];
            $product_id = $p_id;
            $fld_shipment = $shipment[$i];
            $subproduct_id = $sp_id[$i];
            $total_price = $t_price[$i];
            $fld_discount = $fld_row_discount[$i];
         // $disc = $discount[$i];
            $disc=0;

            $data1 = array(
                'fld_sale_id'        => $insert_id,
                'fld_shipment'        => $fld_shipment,
                'fld_product_id'         => $product_id,
                'fld_subproduct_id'      => $subproduct_id,
                'fld_quantity'           => $product_quantity,
                'fld_weight'             => $product_weight,
                'fld_discount'             => $fld_discount,
                'fld_unit_price'         => $product_rate,
                'fld_total_amount'       => $total_price
            );
            

            //if (!empty($quantity)) {
                $this->db->insert('tbl_sale_detail_drafts', $data1);
            //}
        }
		
			$res=array('responce'=>'success',"message"=>"Saved in Drafts Automatically.","sale_id"=>$insert_id);
			return $res;
		}else{
			$res=array('responce'=>'error',"message"=>"Sale order not added in draft.Something went wrong.");
			return $res;
		}
	}
	
	function sale_draft_update_entry_autosave(){
		$sale_id =$this->input->post('sale_id',TRUE);
		$payment_type=0;
		if($this->input->post('fld_payment_status')  == 3){
			$payment_type=0;
		}else{
			$payment_type=$this->input->post('fld_payment_type');
		}
		$data = array(
            'fld_customer_id'          => $this->input->post('fld_customer_id',TRUE),
            'fld_invoice_no'        => $this->input->post('fld_invoice_no',TRUE),
            'fld_voucher_no' => $this->input->post('fld_voucher_no',TRUE),
            'fld_sale_date'     => date('Y-m-d',strtotime(str_replace('/', '-', $this->input->post('fld_sale_date',TRUE)))),
            //'fld_shipment'      => $this->input->post('fld_shipment',TRUE),
			'fld_location_id'      => $this->input->post('fld_location',TRUE),
			'fld_vehicle_no'      => $this->input->post('fld_vehicle_no',TRUE),
			'fld_discount' => $this->input->post('fld_discount',TRUE),
            'fld_total_discount' => $this->input->post('fld_total_discount',TRUE),
            'fld_grand_total_amount'   => $this->input->post('fld_grand_total_amount',TRUE),
            'fld_payment_status'        => $this->input->post('fld_payment_status',TRUE),
            'fld_payment_type'         => $payment_type,
            'fld_bank'             =>  $this->input->post('fld_bank',TRUE),
            'fld_cheque_number'            =>  $this->input->post('fld_cheque_number',TRUE),
            'fld_cheque_date'       =>  $this->input->post('fld_cheque_date',TRUE),
        );
		// echo '<pre>';
		// print_r($_POST);
		// print_r($data);
		// exit;
		$this->db->where('fld_id', $sale_id);
		$responce= $this->db->update('tbl_sale_drafts', $data);
		if($responce){
			$this->db->where('fld_sale_id', $sale_id);
			$responce= $this->db->delete('tbl_sale_detail_drafts');
		    $totalquantity=0;
		  
		  $p_id = $this->input->post('fld_category',TRUE);
		  $shipment = $this->input->post('fld_shipment',TRUE);
		  $sp_id = $this->input->post('fld_subcat_id',TRUE);
		  $rate = $this->input->post('fld_unit_price',TRUE);
		  $quantity = $this->input->post('fld_quantity',TRUE);
		  $weight = $this->input->post('fld_weight', TRUE);
		  $t_price = $this->input->post('fld_total_amount',TRUE);
		  $fld_row_discount = $this->input->post('fld_row_discount', TRUE);
		  for ($i = 0, $n = count($sp_id); $i < $n; $i++) {
// 			$totalquantity=$totalquantity + $quantity;
            $product_quantity = $quantity[$i];
            $product_rate = $rate[$i];
            $product_weight = $weight[$i];
            $product_id = $p_id;
            $fld_shipment = $shipment[$i];
            $subproduct_id = $sp_id[$i];
            $total_price = $t_price[$i];
            $fld_discount = $fld_row_discount[$i];
         // $disc = $discount[$i];
            $disc=0;

            $data1 = array(
                'fld_sale_id'        => $sale_id,
                'fld_shipment'        => $fld_shipment,
                'fld_product_id'         => $product_id,
                'fld_subproduct_id'      => $subproduct_id,
                'fld_quantity'           => $product_quantity,
                'fld_weight'             => $product_weight,
                'fld_discount'             => $fld_discount,
                'fld_unit_price'         => $product_rate,
                'fld_total_amount'       => $total_price
            );

            //if (!empty($quantity)) {
                $this->db->insert('tbl_sale_detail_drafts', $data1);
            //}
        
        }
		
		$res = array('responce'=>'success',"message"=>"Saved in Drafts Automatically. ");
		return $res;
		}else{
		$res = array('responce'=>'success',"message"=>"Sale draft not updated.");
			return $res; 
		}
	}
	
	function sale_draft_entry(){
		$sale_id = date('YmdHis');
		$payment_type=0;
		if($this->input->post('fld_payment_status')  == 3){
			$payment_type=0;
		}else{
			$payment_type=$this->input->post('fld_payment_type');
		}

		$user_id=$this->session->userdata('user_id');
		$discount = $this->input->post('fld_discount',TRUE);
		$discount_per_kg = $discount/11.8;
		$data = array(
            'fld_userid'        => $user_id,
// 			'fld_stock_location_id'          => $this->input->post('stock_location_id',TRUE),
            'fld_customer_id'          => $this->input->post('fld_customer_id',TRUE),
            'fld_invoice_no'        => $this->input->post('fld_invoice_no',TRUE),
            'fld_voucher_no' => $this->input->post('fld_voucher_no',TRUE),
            'fld_sale_date'     => date('Y-m-d',strtotime(str_replace('/', '-', $this->input->post('fld_sale_date',TRUE)))),
            // 'fld_shipment'      => $this->input->post('fld_shipment',TRUE),
            'fld_location_id'      => $this->input->post('fld_location',TRUE),
            'fld_vehicle_no'       => $this->input->post('fld_vehicle_no',TRUE),
            'fld_discount' => $this->input->post('fld_discount',TRUE),
            'fld_total_discount' => $this->input->post('fld_total_discount',TRUE),
            'fld_grand_total_amount'   => $this->input->post('fld_grand_total_amount',TRUE),
            'fld_payment_status'        => $this->input->post('fld_payment_status',TRUE),
            'fld_payment_type'         => $payment_type,
            'fld_bank'             =>  $this->input->post('fld_bank',TRUE),
            'fld_cheque_number'            =>  $this->input->post('fld_cheque_number',TRUE),
            'fld_cheque_date'       =>  $this->input->post('fld_cheque_date',TRUE),
            'fld_created_date'   =>  date("Y-m-d H:i:s")
        );
		  $responce=$this->db->insert('tbl_sale_drafts', $data);
		  if($responce){
		  $totalquantity=0;
		  $insert_id = $this->db->insert_id();
		  $p_id = $this->input->post('fld_category',TRUE);
		  $shipment = $this->input->post('fld_shipment',TRUE);
		  $sp_id = $this->input->post('fld_subcat_id',TRUE);
		  $rate = $this->input->post('fld_unit_price',TRUE);
		  $quantity = $this->input->post('fld_quantity',TRUE);
		  $weight = $this->input->post('fld_weight', TRUE);
		  $t_price = $this->input->post('fld_total_amount',TRUE);
		  $fld_row_discount = $this->input->post('fld_row_discount', TRUE);
		  for ($i = 0, $n = count($sp_id); $i < $n; $i++) {
// 			$totalquantity=$totalquantity + $quantity;
            $product_quantity = $quantity[$i];
            $product_rate = $rate[$i];
            $product_weight = $weight[$i];
            $product_id = $p_id;
            $subproduct_id = $sp_id[$i];
            $total_price = $t_price[$i];
            $fld_discount = $fld_row_discount[$i];
         // $disc = $discount[$i];
            $disc=0;

            $data1 = array(
                'fld_sale_id'        => $insert_id,
                'fld_shipment'        => $shipment,
                'fld_product_id'         => $product_id,
                'fld_subproduct_id'      => $subproduct_id,
                'fld_quantity'           => $product_quantity,
                'fld_weight'             => $product_weight,
                'fld_discount'             => $fld_discount,
                'fld_unit_price'         => $product_rate,
                'fld_total_amount'       => $total_price
            );
            

            //if (!empty($quantity)) {
                $this->db->insert('tbl_sale_detail_drafts', $data1);
            //}
        }
		
			$res=array('responce'=>'success',"message"=>"Sale order added in draft successfully.");
			return $res;
		}else{
			$res=array('responce'=>'error',"message"=>"Sale order not added in draft.Something went wrong.");
			return $res;
		}
	}
	
	
	function customer_entry(){
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
            'fld_status'        => 1
        );
        $customer = $this->db->insert('tbl_customers',$data);
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
        
       return $customer;
		
	}
	
	
	
	function sale_draft_update_entry(){
		$sale_id =$this->input->post('sale_id',TRUE);
		$payment_type=0;
		if($this->input->post('fld_payment_status')  == 3){
			$payment_type=0;
		}else{
			$payment_type=$this->input->post('fld_payment_type');
		}
		$data = array(
            'fld_customer_id'          => $this->input->post('fld_customer_id',TRUE),
            'fld_invoice_no'        => $this->input->post('fld_invoice_no',TRUE),
            'fld_voucher_no' => $this->input->post('fld_voucher_no',TRUE),
            'fld_sale_date'     => date('Y-m-d',strtotime(str_replace('/', '-', $this->input->post('fld_sale_date',TRUE)))),
            //'fld_shipment'      => $this->input->post('fld_shipment',TRUE),
			'fld_location_id'      => $this->input->post('fld_location',TRUE),
			'fld_vehicle_no'      => $this->input->post('fld_vehicle_no',TRUE),
			'fld_discount' => $this->input->post('fld_discount',TRUE),
            'fld_total_discount' => $this->input->post('fld_total_discount',TRUE),
            'fld_grand_total_amount'   => $this->input->post('fld_grand_total_amount',TRUE),
            'fld_payment_status'        => $this->input->post('fld_payment_status',TRUE),
            'fld_payment_type'         => $payment_type,
            'fld_bank'             =>  $this->input->post('fld_bank',TRUE),
            'fld_cheque_number'            =>  $this->input->post('fld_cheque_number',TRUE),
            'fld_cheque_date'       =>  $this->input->post('fld_cheque_date',TRUE),
        );
		// echo '<pre>';
		// print_r($_POST);
		// print_r($data);
		// exit;
		$this->db->where('fld_id', $sale_id);
		$responce= $this->db->update('tbl_sale_drafts', $data);
		if($responce){
			$this->db->where('fld_sale_id', $sale_id);
			$responce= $this->db->delete('tbl_sale_detail_drafts');
		$totalquantity=0;
		  
		  $p_id = $this->input->post('fld_category',TRUE);
		  $shipment = $this->input->post('fld_shipment',TRUE);
		  $sp_id = $this->input->post('fld_subcat_id',TRUE);
		  $rate = $this->input->post('fld_unit_price',TRUE);
		  $quantity = $this->input->post('fld_quantity',TRUE);
		  $weight = $this->input->post('fld_weight', TRUE);
		  $t_price = $this->input->post('fld_total_amount',TRUE);
		  $fld_row_discount = $this->input->post('fld_row_discount', TRUE);
		  for ($i = 0, $n = count($sp_id); $i < $n; $i++) {
// 			$totalquantity=$totalquantity + $quantity;
            $product_quantity = $quantity[$i];
            $product_rate = $rate[$i];
            $product_weight = $weight[$i];
            $product_id = $p_id;
            $fld_shipment = $shipment[$i];
            $subproduct_id = $sp_id[$i];
            $total_price = $t_price[$i];
            $fld_discount = $fld_row_discount[$i];
         // $disc = $discount[$i];
            $disc=0;

            $data1 = array(
                'fld_sale_id'        => $sale_id,
                'fld_shipment'        => $fld_shipment,
                'fld_product_id'         => $product_id,
                'fld_subproduct_id'      => $subproduct_id,
                'fld_quantity'           => $product_quantity,
                'fld_weight'             => $product_weight,
                'fld_discount'             => $fld_discount,
                'fld_unit_price'         => $product_rate,
                'fld_total_amount'       => $total_price
            );

            //if (!empty($quantity)) {
                $this->db->insert('tbl_sale_detail_drafts', $data1);
            //}
        
        }
		
		$res = array('responce'=>'success',"message"=>"Sale Draft updated successfully.");
		return $res;
		}else{
			$res = array('responce'=>'error',"message"=>"Sale Draft not updated.Something went wrong.");
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
    
	function sale_filter() {
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
		$this->db->select('tbl_sale.*,tbl_customers.fld_customer_code,tbl_customers.fld_company_name,tbl_customers.fld_customer_name,sd.fld_product_id,sd.fld_subproduct_id,sd.fld_quantity,sd.fld_discount,sd.fld_weight,sd.fld_unit_price,sd.fld_total_amount,cat.fld_category, sd.fld_shipment');
		
		$this->db->from('tbl_sale');
		
		$this->db->join('tbl_sale_detail as sd','sd.fld_sale_id=tbl_sale.fld_id');
		
		$this->db->join('tbl_category as cat','cat.fld_id=sd.fld_product_id');
		
		$this->db->join('tbl_customers','tbl_customers.fld_id=tbl_sale.fld_customer_id');
		
		$this->db->where($date);
		
		$this->db->where('tbl_sale.fld_isdeleted',0);
		
		$this->db->where($group_by,$id);
		
		return $this->db->get()->result_array();
	}
	
	function ShipmentByID($ship_id) {
		$sl = $this->db->query("SELECT * FROM tbl_stock_locations WHERE fld_id = '$ship_id'")->row_array();
		if($sl['fld_purchase_id']!=0){
		    $this->db->select('tbl_stock_locations.*,tbl_stocks.fld_stock_qty,tbl_suppliers.fld_supplier_name,pd.fld_product_id,pd.fld_quantity,pd.fld_unit_price,pd.fld_total_amount,tbl_category.fld_category,tbl_purchase.fld_shipment');
    		$this->db->from('tbl_stock_locations');
    		$this->db->join('tbl_purchase','tbl_purchase.fld_id=tbl_stock_locations.fld_purchase_id');
    		$this->db->join('tbl_stocks','tbl_stocks.fld_stock_loc_id=tbl_stock_locations.fld_id');
    		$this->db->join('tbl_suppliers','tbl_suppliers.fld_id=tbl_purchase.fld_supplier_id');
    		$this->db->join('tbl_purchase_detail as pd','pd.fld_purchase_id=tbl_purchase.fld_id');
    		$this->db->join('tbl_category','tbl_category.fld_id=pd.fld_product_id');
    		$this->db->where('pd.fld_product_id=tbl_stock_locations.fld_product_id');
    		$this->db->where('pd.fld_subproduct_id=tbl_stock_locations.fld_subproduct_id');
    		$this->db->where('tbl_stock_locations.fld_id',$ship_id);
    		$navigation=$this->db->get()->row_array();
		}else{
		    $this->db->select('tbl_stock_locations.*,tbl_stocks.fld_stock_qty,gld.fld_product_id,gld.fld_quantity,gld.fld_unit_price,gld.fld_total_amount,tbl_category.fld_category,CONCAT("LPG Gain/", gld.fld_shipment) as fld_shipment');
    		$this->db->from('tbl_stock_locations');
    		$this->db->join('tbl_stocks','tbl_stocks.fld_stock_loc_id=tbl_stock_locations.fld_id');
    		$this->db->join('tbl_gainloss_details as gld','gld.fld_id=tbl_stock_locations.fld_gl_id');
    		$this->db->join('tbl_category','tbl_category.fld_id=gld.fld_product_id');
    		$this->db->where('gld.fld_product_id=tbl_stock_locations.fld_product_id');
    		$this->db->where('tbl_stock_locations.fld_id',$ship_id);
    		$navigation=$this->db->get()->row_array();
		}
		
		if($navigation){
			//foreach($navigation as $key => $nav){
			$qty=$this->getPurchaseNavigation($navigation['fld_id']);
			$navigation['fld_stock_qty']=$navigation['fld_stock_qty'] - $qty;
			//}
		}
		return $navigation;
    }
    function getPurchaseNavigation($id){
		$qty=0;
		$this->db->select('sum(tbl_navigations_details.fld_qty) as qty');
		$this->db->from('tbl_navigations_details');
		//$this->db->where_in('tbl_navigations.fld_stock_loc_id',(''));
		$this->db->where('tbl_navigations_details.fld_stock_loc_id IN (SELECT `fld_id` FROM `tbl_stock_locations` where fld_parent_id ='.$id.')', NULL, FALSE);
		//$this->db->where('tbl_navigations.fld_nav_type',1);
		$res=$this->db->get()->row_array();
		if($res['qty']){
			$qty=$res['qty'];
			return $qty;
		}else{
			return $qty;
		}
	}
	function getLatestSales() {
		$conditions="";
		
		$customer_id=$this->input->post('customer_id');
		
		$this->db->select('tbl_sale.*');
		
		$this->db->from('tbl_sale');
		
// 		$this->db->join('tbl_sale_detail as sd','sd.fld_sale_id=tbl_sale.fld_id');
		
// 		$this->db->join('tbl_category as cat','cat.fld_id=sd.fld_product_id');
		
// 		$this->db->join('tbl_subcategory as subcat','subcat.fld_subcid=sd.fld_subproduct_id','left');
		
// 		$this->db->join('tbl_customers','tbl_customers.fld_id=tbl_sale.fld_customer_id');
		
		if(!empty($customer_id)){
			$this->db->where("tbl_sale.fld_customer_id",$customer_id);
		}
		
		$this->db->where('tbl_sale.fld_isdeleted',0);
		$this->db->order_by('tbl_sale.fld_id','DESC');
		$this->db->limit(3);
		return $this->db->get()->result_array();
    }
   
}