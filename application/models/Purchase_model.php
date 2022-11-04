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
    
    function getMaxOrderID() {
		$sql="SHOW TABLE STATUS LIKE 'tbl_purchase_orders'";
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
		$this->db->order_by("tbl_purchase.fld_id", "DESC");
		return $this->db->get()->result_array();
    }
    
    function getAllDraftPurchases() {
		
		$this->db->select('tbl_purchase_draft.*,tbl_suppliers.fld_supplier_code,tbl_suppliers.fld_company_name,tbl_suppliers.fld_supplier_name');
		$this->db->from('tbl_purchase_draft');
		$this->db->where('tbl_purchase_draft.fld_userid',$this->session->userdata('user_id'));
		$this->db->join('tbl_suppliers','tbl_suppliers.fld_id=tbl_purchase_draft.fld_supplier_id');
		return $this->db->get()->result_array();
    }
    
    function getAllTrashPurchases() {
		$this->db->select('tbl_purchase.*,tbl_suppliers.fld_supplier_code,tbl_suppliers.fld_company_name,tbl_suppliers.fld_supplier_name');
		$this->db->from('tbl_purchase');
		$this->db->join('tbl_suppliers','tbl_suppliers.fld_id=tbl_purchase.fld_supplier_id');
		$this->db->where('tbl_purchase.fld_isdeleted',1);
		return $this->db->get()->result_array();
    }
    
	function getAllOrderPurchases() {
		$this->db->select('tbl_purchase_orders.*,tbl_suppliers.fld_supplier_code,tbl_suppliers.fld_company_name,tbl_suppliers.fld_supplier_name');
		$this->db->from('tbl_purchase_orders');
		$this->db->join('tbl_suppliers','tbl_suppliers.fld_id=tbl_purchase_orders.fld_supplier_id');
		return $this->db->get()->result_array();
    }
    
	function getPurchaseByID($id) {
		$this->db->select('tbl_purchase.*,tbl_suppliers.fld_supplier_name,tbl_locations.fld_location,tbl_locations.fld_address');
		$this->db->from('tbl_purchase');
		$this->db->join('tbl_suppliers','tbl_suppliers.fld_id=tbl_purchase.fld_supplier_id');
		$this->db->join('tbl_locations','tbl_locations.fld_id=tbl_purchase.fld_location_id','left');
		$this->db->where('tbl_purchase.fld_id',$id);
		$record=$this->db->get()->row_array();
		if($record){
			foreach($record as $key => $rec){
				$record['products']=$this->getPurchaseProducts($id);
			}
		}
		return $record;
    }
    
    
	function getPurchaseOrderByID($id) {
		
		$this->db->select('tbl_purchase_orders.*,tbl_suppliers.fld_supplier_name');
		$this->db->from('tbl_purchase_orders');
		$this->db->join('tbl_suppliers','tbl_suppliers.fld_id=tbl_purchase_orders.fld_supplier_id','left');
		$this->db->where('tbl_purchase_orders.fld_id',$id);
		$record=$this->db->get()->row_array();
		if($record){
			foreach($record as $key => $rec){
				$record['products']=$this->getPurchaseOrderProducts($id);
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
    
    function getPurchaseDraftProducts($id){
		
		$this->db->select('tbl_purchase_detail_draft.*,tbl_category.*');
		
		$this->db->from('tbl_purchase_detail_draft');
		
		$this->db->join('tbl_category','tbl_category.fld_id=tbl_purchase_detail_draft.fld_product_id','left');
		
		$this->db->where('tbl_purchase_detail_draft.fld_purchase_id',$id);
		
		return $this->db->get()->result_array();
	}
    
	function getPurchaseProducts($id){
		
		$this->db->select('tbl_purchase_detail.*,tbl_category.*');
		$this->db->from('tbl_purchase_detail');
		$this->db->join('tbl_category','tbl_category.fld_id=tbl_purchase_detail.fld_product_id');
		$this->db->where('tbl_purchase_detail.fld_purchase_id',$id);
		return $this->db->get()->result_array();
	}
	
	function getPurchaseOrderProducts($id){
		
		$this->db->select('tbl_purchase_order_detail.*,tbl_category.fld_category');
		$this->db->from('tbl_purchase_order_detail');
		$this->db->join('tbl_category','tbl_category.fld_id=tbl_purchase_order_detail.fld_product_id','left');
		$this->db->where('tbl_purchase_order_detail.fld_order_id',$id);
		return $this->db->get()->result_array();
	}
	
	function delete($id){
	    $user_id = $this->session->userdata('user_id');
		$this->db->where('fld_id',$id);
		//$this->db->set('fld_trash_date', 'NOW()', FALSE);
		
		return $this->db->update('tbl_purchase',array('fld_trash_date'=>date("Y-m-d H:i:s"),'fld_isdeleted'=>1, 'fld_trash_by' => $user_id));
		// if($purchase){
			// $this->db->where('fld_purchase_id',$id);
			// return $this->db->delete('tbl_purchase_detail');
		// }
	}
	
	function deleteOrder($id){
		$this->db->where('fld_id',$id);
		$orders = $this->db->delete('tbl_purchase_orders');
		if($orders){
			$this->db->where('fld_order_id',$id);
			return $this->db->delete('tbl_purchase_order_detail');
		}
	}
	
	function restore($id){
		$this->db->where('fld_id',$id);
		return $this->db->update('tbl_purchase',array('fld_isdeleted'=>0));
	}
	
	function permanentdelete($id){
	    $v_id = $this->db->query("SELECT id FROM tbl_transections_master WHERE type='Purchase' AND type_id = '$id'")->row()->id;
	    
	    $this->db->where('v_id',$v_id);
	    $this->db->delete('tbl_transections_details');
	    
	    $this->db->where('id',$v_id);
	    $this->db->delete('tbl_transections_master');
	    
	    $get_fld_stock_loc_id = $this->db->query("SELECT * FROM tbl_stock_locations WHERE fld_purchase_id = '$id'")->result_array();
	    foreach($get_fld_stock_loc_id as $row){
	        $this->db->query("DELETE FROM tbl_stocks WHERE fld_stock_loc_id = '{$row['fld_id']}'");
	    }
        
	    
	     
		$this->db->where('fld_id',$id);
		return $this->db->delete('tbl_purchase');
	}
	
	function permanentdeletedetail($id){
		$this->db->where('fld_purchase_id',$id);
		return $this->db->delete('tbl_purchase_detail');
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
	    
		$purchase_id =$this->input->post('purchase_id');
		if(!empty($purchase_id)){
			 $this->db->where('fld_id', $purchase_id);
			 $this->db->delete('tbl_purchase_draft');
			 $this->db->where('fld_purchase_id', $purchase_id);
			 $this->db->delete('tbl_purchase_detail_draft');
		}
		$payment_type=0;
		if($this->input->post('fld_payment_status')  == 3){
			$payment_type=0;
		}else{
			$payment_type=$this->input->post('fld_payment_type');
		}
		$user_id=$this->session->userdata('user_id');
	
		$data = array(
			'fld_userid'        => $user_id,
            'fld_supplier_id'   => $this->input->post('fld_supplier_id',TRUE),
            'fld_invoice_no'    => $this->input->post('fld_invoice_no',TRUE),
            'fld_voucher_no'    => 'PB-'.sprintf('%04d', $this->getMaxsuplierID()['Auto_increment']),
            'fld_purchase_date' => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('fld_purchase_date',TRUE)))),
            'fld_shipment'      => $this->input->post('fld_shipment',TRUE),
            'fld_location_id'   => $this->input->post('fld_location',TRUE),
            'fld_grand_total_amount'  => $this->input->post('fld_grand_total_amount',TRUE),
            'fld_payment_status'      => $this->input->post('fld_payment_status',TRUE),
            'fld_payment_type'        => $payment_type,
            'fld_bank'             =>  $this->input->post('fld_bank',TRUE),
            'fld_cheque_number' =>  $this->input->post('fld_cheque_number',TRUE),
            'fld_cheque_date'   =>  $this->input->post('fld_cheque_date',TRUE),
            'fld_created_date'   =>  date("Y-m-d H:i:s")
        );
         //$this->db->set('fld_created_date', 'NOW()', FALSE);
		 $responce=$this->db->insert('tbl_purchase', $data);
		 if($responce){
		     $narration = '';
		  $totalquantity=0;
		  $insert_id = $this->db->insert_id();
		  $p_id = $this->input->post('fld_product_id',TRUE);
		  $sub_category = $this->input->post('sub_category');
		  $rate = $this->input->post('fld_unit_price',TRUE);
		  $quantity = $this->input->post('fld_quantity',TRUE);
		  $t_price = $this->input->post('fld_total_amount',TRUE);
		  for ($i = 0, $n = count($p_id); $i < $n; $i++) {
		      
			$totalquantity=$totalquantity + $quantity[$i];
            $product_quantity = $quantity[$i];
            $product_rate = $rate[$i];
            $product_id = $p_id[$i];
            $fld_subproduct_id = $sub_category[$i];
            
            if(is_null($fld_subproduct_id)){
                $fld_subproduct_id = 0;
            }
            $total_price = $t_price[$i];
            // $disc = $discount[$i];
            $disc=0;
            if($product_id==1){
                $item = $this->db->select('*')->from('tbl_category')->where('fld_id', $product_id)->get()->row()->fld_category;
            }else{
                $item = $this->db->select('*')->from('tbl_subcategory')->where('fld_subcid',$fld_subproduct_id)->get()->row()->fld_subcategory;
            }
            $narration .= $item.', (Q)'.$product_quantity.'(Rs)'.$product_rate.', ';
            $data1 = array(
                'fld_purchase_id'   => $insert_id,
                'fld_product_id'    => $product_id,
                'fld_subproduct_id' => $fld_subproduct_id,
                'fld_quantity'      => $product_quantity,
                'fld_unit_price'    => $product_rate,
                'fld_total_amount'  => $total_price
            );

            if (!empty($quantity)) {
                $this->db->insert('tbl_purchase_detail', $data1);
                	$locinsert=array(
        		    "fld_purchase_location_id"=>$this->input->post('fld_location',TRUE),
        		    "fld_parent_id"=>0,
        		    "fld_purch_type"=>1,
        		    "fld_purchase_id"=>$insert_id,
        		    "fld_product_id"=>$product_id,
        		    "fld_subproduct_id"=>$fld_subproduct_id,
            		);
    		    $this->db->insert('tbl_stock_locations', $locinsert);
        		$locinsert_id = $this->db->insert_id();
        		$stockinsert=array(
        		    "fld_stock_qty"=>$product_quantity,
        		    "fld_stock_loc_id"=>$locinsert_id,
        		);
    		    $this->db->insert('tbl_stocks', $stockinsert);
            }
        }
	 
	
		
		$coa_id = $this->db->select('*')->from('tbl_suppliers')->where('fld_id',$data['fld_supplier_id'])->get()->row()->accounts_id;
		$now = date('Y-m-d H:i:s');
		$this->db->query("INSERT into tbl_transections_master SET type = 'Purchase', type_id = '$insert_id', date = '{$data['fld_purchase_date']}', user_id = '$user_id', created_date = '$now'");
		$v_id = $this->db->insert_id();
		$narration = rtrim($narration, ', ');
        $narration .= ' - '.$data['fld_shipment'];
        
        $getfInvetory_id = $this->db->query("SELECT * FROM tbl_locations WHERE fld_id = '{$data['fld_location_id']}'")->row()->inventory_account;
		
		$this->db->query("INSERT INTO tbl_transections_details SET v_id = '$v_id', coa_id = '$coa_id', narration = '$narration', credit = '{$data['fld_grand_total_amount']}'");
		$this->db->query("INSERT INTO tbl_transections_details SET v_id = '$v_id', coa_id = '$getfInvetory_id', narration = '$narration', debit = '{$data['fld_grand_total_amount']}'");
		/****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
        $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
        $date=date('Y-m-d H:i:s');
		$purchase_id='<a href="'.base_url('Purchase/detail/'.$insert_id.'').'">PB-'.sprintf('%04d', $insert_id).'</a>';
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'ADD',fld_detail='$purchase_id',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
		$this->session->set_userdata('success_message', "Purchase order added successfully.");
		    return true;
		}else{
			$this->session->set_userdata('success_message', "Purchase order not added.");
			return false; 
		}
	}
	
	function purchase_entry_from_order(){
	    
	$purchase_id = date('YmdHis');
		$user_id=$this->session->userdata('user_id');
	    $poid = $this->input->post('purchase_id', TRUE);
		$data = array(
			'fld_userid'            => $user_id,
            'fld_supplier_id'       => $this->input->post('fld_supplier_id',TRUE),
            'fld_invoice_no'        => $this->input->post('fld_invoice_no',TRUE),
            'fld_voucher_no'        => 'PV-'.sprintf('%04d', $this->getMaxOrderID()['Auto_increment']),
            'fld_purchase_date'     => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('fld_purchase_date',TRUE)))),
            'fld_shipment'          => $this->input->post('fld_shipment',TRUE),
            'fld_location_id'       => $this->input->post('fld_location',TRUE),
            'fld_grand_total_amount'=> $this->input->post('fld_grand_total_amount',TRUE),
            'fld_payment_status'    => 0,
            'fld_payment_type'      => 0,
            'fld_bank'              =>  $this->input->post('fld_bank',TRUE),
            'fld_cheque_number'     =>  '',
            'fld_cheque_date'       =>  '',
        );
		 $responce=$this->db->insert('tbl_purchase', $data);
		 if($responce){
		  
		  $totalquantity=0;
		  $insert_id = $this->db->insert_id();
		  $p_id = $this->input->post('fld_product_id',TRUE);
		  $pdo_id = $this->input->post('fld_detail_id',TRUE);
		  $sub_category = $this->input->post('fld_subproduct_id',TRUE);
		  $rate = $this->input->post('fld_unit_price',TRUE);
		  $old_quantity = $this->input->post('fld_old_quantity',TRUE);
		  $quantity = $this->input->post('fld_quantity',TRUE);
		  $t_price = $this->input->post('fld_total_amount',TRUE);
		  $totalOrderAmount = 0;
		  $totalQty = 0;
		  $narration = '';
		  for ($i = 0, $n = count($p_id); $i < $n; $i++) {
			$totalquantity=$totalquantity + $quantity[$i];
            $product_quantity = $quantity[$i];
            $product_rate = $rate[$i];
            $product_id = $p_id[$i];
            $fld_subproduct_id = $sub_category[$i];
            $pd_order_id = $pdo_id[$i];
            $fld_old_quantity = $old_quantity[$i];
            
            $total_price = $t_price[$i];
            // $disc = $discount[$i];
            $disc=0;
            if($product_id==1){
                $item = $this->db->select('*')->from('tbl_category')->where('fld_id', $product_id)->get()->row()->fld_category;
            }else{
                $item = $this->db->select('*')->from('tbl_subcategory')->where('fld_subcid',$fld_subproduct_id)->get()->row()->fld_subcategory;
            }
            $narration .= $item.', (Q)'.$product_quantity.'(Rs)'.$product_rate.', ';
            $data1 = array(
                'fld_purchase_id'        => $insert_id,
                'fld_product_id'         => $product_id,
                'fld_subproduct_id'      => $fld_subproduct_id,
                'fld_quantity'           => $product_quantity,
                'fld_unit_price'         => $product_rate,
                'fld_total_amount'       => $total_price
            );

            if (!empty($quantity)) {
                $this->db->insert('tbl_purchase_detail', $data1);
                $locinsert=array(
        		    "fld_purchase_location_id"=>$this->input->post('fld_location',TRUE),
        		    "fld_parent_id"=>0,
        		    "fld_purch_type"=>1,
        		    "fld_purchase_id"=>$insert_id,
        		    "fld_product_id"=>$product_id,
        		    "fld_subproduct_id"=>$fld_subproduct_id,
        		);
        		$this->db->insert('tbl_stock_locations', $locinsert);
        		$locinsert_id = $this->db->insert_id();
        		$stockinsert=array(
        		    "fld_stock_qty"=>$product_quantity,
        		    "fld_stock_loc_id"=>$locinsert_id,
        		);
        		$this->db->insert('tbl_stocks', $stockinsert);
            }
            
            if($product_quantity != $fld_old_quantity){
                $remain_qty = $fld_old_quantity-$product_quantity;
              
                if($remain_qty == 0){
                    $this->db->query("delete from tbl_purchase_order_detail where fld_id = '$pd_order_id'");
                }else{
                    $t_amont = $remain_qty * $product_rate;
                    $this->db->query("update tbl_purchase_order_detail set fld_quantity = '$remain_qty', fld_unit_price = '$product_rate', fld_total_amount = '$t_amont' where fld_id = '$pd_order_id'");
                }
                $totalQty += $remain_qty;
                $totalOrderAmount += $remain_qty * $product_rate;
            }else{
                 $this->db->query("delete from tbl_purchase_order_detail where fld_id = '$pd_order_id'");
            }
        }
       
        if($totalQty == 0){
            $this->db->query("delete from tbl_purchase_orders where fld_id = '$poid'");
        }else{
            $this->db->query("update tbl_purchase_orders set fld_grand_total_amount = '$totalOrderAmount' where fld_id = '$poid'");
        }
        
        
		 
		
		$coa_id = $this->db->select('*')->from('tbl_suppliers')->where('fld_id',$data['fld_supplier_id'])->get()->row()->accounts_id;
		$now = date('Y-m-d H:i:s');
		$this->db->query("INSERT into tbl_transections_master SET type = 'Purchase', type_id = '$insert_id', date = '{$data['fld_purchase_date']}', user_id = '$user_id', created_date = '$now'");
		$v_id = $this->db->insert_id();
		$narration = rtrim($narration, ', ');
        $narration .= ' - '.$data['fld_shipment'];
		
		$this->db->query("INSERT INTO tbl_transections_details SET v_id = '$v_id', coa_id = '$coa_id', narration = '$narration', credit = '{$data['fld_grand_total_amount']}'");
		$this->db->query("INSERT INTO tbl_transections_details SET v_id = '$v_id', coa_id = '101003001', narration = '$narration', debit = '{$data['fld_grand_total_amount']}'");
		$this->session->set_userdata('success_message', "Purchase order added successfully.");
		return true;
		}else{
			$this->session->set_userdata('success_message', "Purchase order not added.");
			return false; 
		}
	}
	
	function purchase_draft_entry_autosave(){
		$purchase_id = date('YmdHis');
		$payment_type=0;
		if($this->input->post('fld_payment_status')  == 3){
			$payment_type=0;
		}else{
			$payment_type=$this->input->post('fld_payment_type');
		}
		$data = array( 
            'fld_supplier_id'          => $this->input->post('fld_supplier_id',TRUE),
            'fld_userid'          => $this->session->userdata('user_id'),
            'fld_refinery_id'          => $this->input->post('refinery',TRUE),
            'fld_vehicle_no'          => $this->input->post('vehicle_no',TRUE),
            'fld_invoice_no'        => $this->input->post('fld_invoice_no',TRUE),
            'fld_voucher_no' => $this->input->post('fld_voucher_no',TRUE),
            'fld_purchase_date'     => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('fld_purchase_date',TRUE)))),
            'fld_shipment'      => $this->input->post('fld_shipment',TRUE),
            'fld_location'      => $this->input->post('fld_location',TRUE),
            'fld_grand_total_amount'   => $this->input->post('fld_grand_total_amount',TRUE),
            'fld_payment_status'        => $this->input->post('fld_payment_status',TRUE),
            'fld_payment_type'         => $payment_type,
            'fld_bank'              =>  $this->input->post('fld_bank',TRUE),
            'fld_cheque_number'            =>  $this->input->post('fld_cheque_number',TRUE),
            'fld_cheque_date'       =>  $this->input->post('fld_cheque_date',TRUE),
        );
		  $responce=$this->db->insert('tbl_purchase_draft', $data);
		  if($responce){
		  $insert_id = $this->db->insert_id();
		  $p_id = $this->input->post('fld_product_id',TRUE);
		  $sub_category = $this->input->post('sub_category',TRUE);
		  $rate = $this->input->post('fld_unit_price',TRUE);
		  $quantity = $this->input->post('fld_quantity',TRUE);
		  $t_price = $this->input->post('fld_total_amount',TRUE);
		  for ($i = 0, $n = count($p_id); $i < $n; $i++) {
            $product_quantity = $quantity[$i];
            $product_rate = $rate[$i];
            $product_id = $p_id[$i];
            $fld_subproduct_id = $sub_category[$i];
            $total_price = $t_price[$i];
            // $disc = $discount[$i];
            $disc=0;
            
            $data1 = array(
                'fld_purchase_id'        => $insert_id,
                'fld_product_id'         => $product_id,
                'fld_subproduct_id'      => $fld_subproduct_id,
                'fld_quantity'           => $product_quantity,
                'fld_unit_price'         => $product_rate,
                'fld_total_amount'       => $total_price
            );
            if (!empty($quantity)) {
                $this->db->insert('tbl_purchase_detail_draft', $data1);
            }
        }
			$res=array('responce'=>'success',"message"=>"Saved in Drafts Automatically.","purchase_id"=>$insert_id);
			return $res;
		}else{
			$res=array('responce'=>'error',"message"=>"Purchase not added in draft.Something went wrong.");
			return $res;
		}
	}
	
	function purchase_draft_entry(){
		$purchase_id = date('YmdHis');
		$purchaseid = $this->input->post('purchaseid');
		$payment_type=0;
		if($this->input->post('fld_payment_status')  == 3){
			$payment_type=0;
		}else{
			$payment_type=$this->input->post('fld_payment_type');
		}
		$data = array(
            'fld_supplier_id'          => $this->input->post('fld_supplier_id',TRUE),
            'fld_userid'          => $this->session->userdata('user_id'),
            'fld_refinery_id'          => $this->input->post('refinery',TRUE),
            'fld_vehicle_no'          => $this->input->post('vehicle_no',TRUE),
            'fld_invoice_no'        => $this->input->post('fld_invoice_no',TRUE),
            'fld_voucher_no' => $this->input->post('fld_voucher_no',TRUE),
            'fld_purchase_date'     => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('fld_purchase_date',TRUE)))),
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
		  $sub_category = $this->input->post('sub_category',TRUE);
		  $rate = $this->input->post('fld_unit_price',TRUE);
		  $quantity = $this->input->post('fld_quantity',TRUE);
		  $t_price = $this->input->post('fld_total_amount',TRUE);
		  for ($i = 0, $n = count($p_id); $i < $n; $i++) {
            $product_quantity = $quantity[$i];
            $product_rate = $rate[$i];
            $product_id = $p_id[$i];
            $fld_subproduct_id = $sub_category[$i];
            $total_price = $t_price[$i];
            // $disc = $discount[$i];
            $disc=0;
            
            $data1 = array(
                'fld_purchase_id'        => $insert_id,
                'fld_product_id'         => $product_id,
                'fld_subproduct_id'      => $fld_subproduct_id,
                'fld_quantity'           => $product_quantity,
                'fld_unit_price'         => $product_rate,
                'fld_total_amount'       => $total_price
            );
            if (!empty($quantity)) {
                $this->db->insert('tbl_purchase_detail_draft', $data1);
            }
        }
			$res=array('responce'=>'success',"message"=>"Purchase added in draft successfully.");
			return $res;
		}else{
			$res=array('responce'=>'error',"message"=>"Purchase not added in draft.Something went wrong.");
			return $res;
		}
	}
	
	function order_entry(){
	    
		$order_id = date('YmdHis');
		$user_id=$this->session->userdata('user_id');
	
		$data = array(
			'fld_userid'        => $user_id,
			'fld_refinery_id'   => $this->input->post('refinery',TRUE),
            'fld_supplier_id'   => $this->input->post('fld_supplier_id',TRUE),
            'fld_invoice_no'    => $this->input->post('fld_invoice_no',TRUE),
            'fld_order_no'      => $this->input->post('fld_order_no',TRUE),
            'fld_order_date'    => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('fld_order_date',TRUE)))),
            'fld_grand_total_amount'=> $this->input->post('fld_grand_total_amount',TRUE),
            'fld_payment_status'    => 0,
            'fld_payment_type'      => 0,
            'fld_bank'              =>  0,
            'fld_cheque_number'     =>  '',
            'fld_cheque_date'       =>  '',
        );
		 $responce=$this->db->insert('tbl_purchase_orders', $data);
		 if($responce){
		     
		  $totalquantity=0;
		  $insert_id = $this->db->insert_id();
		  $p_id = $this->input->post('fld_product_id',TRUE);
		  $sub_category = $this->input->post('sub_category',TRUE);
		  $rate = $this->input->post('fld_unit_price',TRUE);
		  $quantity = $this->input->post('fld_quantity',TRUE);
		  $t_price = $this->input->post('fld_total_amount',TRUE);
		  for ($i = 0, $n = count($p_id); $i < $n; $i++) {
    			$totalquantity=$totalquantity + $quantity[$i];
                $product_quantity = $quantity[$i];
                $product_rate = $rate[$i];
                $product_id = $p_id[$i];
                $fld_subproduct_id = $sub_category[$i];
                $total_price = $t_price[$i];
                // $disc = $discount[$i];
                $disc=0;
            $data1 = array(
                'fld_order_id'        => $insert_id,
                'fld_product_id'         => $product_id,
                'fld_subproduct_id'      => $fld_subproduct_id,
                'fld_quantity'           => $product_quantity,
                'fld_unit_price'         => $product_rate,
                'fld_total_amount'       => $total_price
            );

            if (!empty($quantity)) {
                $this->db->insert('tbl_purchase_order_detail', $data1);
            }
        }
        $user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$user_id=$this->session->userdata('user_id');
		$order_no=$this->input->post('fld_order_no',TRUE);
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
        $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
        $date=date('Y-m-d H:i:s');
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'ADD',fld_detail='$order_no',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
		$this->session->set_userdata('success_message', "Purchase order added successfully.");
		return true;
		}else{
			$this->session->set_userdata('success_message', "Purchase order not added.");
			return false; 
		}
	}
	
	function supplier_entry(){
		$data = array(
            'fld_supplier_code' => $this->input->post('fld_supplier_code',TRUE),
            'fld_company_name'  => $this->input->post('fld_company_name',TRUE),
            'fld_supplier_name' => $this->input->post('fld_supplier_name',TRUE),
            'fld_mobile_num'    => $this->input->post('fld_mobile_num',TRUE),
            'fld_landline_num'  => $this->input->post('fld_landline_num',TRUE),
            'fld_opening_bal'   => $this->input->post('fld_opening_bal',TRUE),
            'fld_supplier_type' => $this->input->post('fld_supplier_type',TRUE),
            'fld_email' => $this->input->post('fld_email',TRUE),
            'fld_cnic'  => $this->input->post('fld_cnic',TRUE),
            'fld_city'  => $this->input->post('fld_city',TRUE),
            'fld_ntn'   => $this->input->post('fld_ntn',TRUE),
            'fld_city_area' => $this->input->post('fld_city_area',TRUE),
            'fld_country'   => $this->input->post('fld_country',TRUE),
            'fld_status'    => 1
        );
       $supplier =  $this->db->insert('tbl_suppliers',$data);
       
       $supplier_id=$this->db->insert_id();
            
            
            $account_id = 101005;
            
            
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
              'head_name'       =>  $data['fld_company_name'].' ('.$data['fld_supplier_code'].')',
              'parent_head_name'      =>  $getHeadCodeData->head_name,
              'head_level'      =>  $newlevel,
              'type'            => 'SUPPLIER',
              'type_id'         => $supplier_id
            ); 
            
            $this->db->insert('tbl_coa',$acc_data);
            $this->db->query("UPDATE tbl_suppliers SET accounts_id='$HeadCode' WHERE fld_id = '$supplier_id'");
            
            return $supplier;
	}
	
	function refinery_entry(){
		$user_id= $this->session->userdata('user_id');
			$data = array(
                'fld_userid' => $user_id,
                'fld_name'=> $this->input->post('fld_name',TRUE),
                'fld_address'=> $this->input->post('fld_address',TRUE),
                'fld_status' => 1
        );
       return $this->db->insert('tbl_refinery',$data);
	}
	
	function vehicle_entry(){
		$user_id= $this->session->userdata('user_id');
			$data = array(
				'fld_userid' => $user_id,
				'fld_vehicle_number'=> $this->input->post('fld_vehicle_number',TRUE),
				'fld_owner_name'=> $this->input->post('fld_owner_name',TRUE),
				'fld_dname1'=> $this->input->post('fld_dname1'),
				'fld_dcnic1'=> $this->input->post('fld_dcnic1'),
				'fld_daddress1'=> $this->input->post('fld_daddress1'),
				'fld_dmobile1'=> $this->input->post('fld_dmobile1'),
				'fld_dlicense1'=> $this->input->post('fld_dlicense1'),
				'fld_dname2'=> $this->input->post('fld_dname2'),
				'fld_dcnic2'=> $this->input->post('fld_dcnic2'),
				'fld_daddress2'=> $this->input->post('fld_daddress2'),
				'fld_dmobile2'=> $this->input->post('fld_dmobile2'),
				'fld_dlicense2'=> $this->input->post('fld_dlicense2'),
				
				'fld_dlicense_issue1' => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('fld_dlicense_issue1',TRUE)))),
				'fld_dlicense_expire1' => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('fld_dlicense_expire1',TRUE)))),
				
				'fld_dlicense_issue2' => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('fld_dlicense_issue2',TRUE)))),
				'fld_dlicense_expire2' => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('fld_dlicense_expire2',TRUE)))),
				
				'fld_type'=> $this->input->post('fld_vehicle_type',TRUE),
				'fld_area' => $this->input->post('fld_area',TRUE),
			);
			$transporter=$this->db->insert('tbl_transporter',$data);
			
			$trans_id=$this->db->insert_id();
            
           
            $account_id = 401007;
            
            
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
              'head_name'       =>  $data['fld_vehicle_number'].'('.$data['fld_owner_name'].')',
              'parent_head_name'      =>  $getHeadCodeData->head_name,
              'head_level'      =>  $newlevel,
              'type'            => 'VEHICLE',
              'type_id'         => $trans_id
            ); 
           
            
            $this->db->insert('tbl_coa',$acc_data);
            $this->db->query("UPDATE tbl_transporter SET accounts_id='$HeadCode' WHERE fld_id = '$trans_id'");
            return $trans_id;
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
            'fld_purchase_date'     => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('fld_purchase_date',TRUE)))),
            'fld_shipment'      => $this->input->post('fld_shipment',TRUE),
			'fld_location_id'      => $this->input->post('fld_location',TRUE),
            'fld_grand_total_amount'   => $this->input->post('fld_grand_total_amount',TRUE),
            'fld_payment_status'        => $this->input->post('fld_payment_status',TRUE),
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
		 //$this->db->where('fld_purchase_id', $purchase_id);
		$this->db->where('fld_id', $purchase_id);
        //$this->db->set('fld_updated_date', 'NOW()', FALSE);
		$responce= $this->db->update('tbl_purchase', $data);
		if($responce){
		    $narration = '';
		    	$old_shipment=$this->input->post('fld_shipment_old',TRUE);
		        $new_shipment=$this->input->post('fld_shipment',TRUE);
		    if($old_shipment!=$new_shipment){
		         $this->db->query("update tbl_sale set fld_shipment = '$new_shipment' where fld_shipment = '$old_shipment'");
		         //$this->db->query("update tbl_navigations set fld_shipment_from = '$new_shipment' where fld_shipment_from = '$old_shipment'");
		         //$this->db->query("update tbl_navigations set fld_shipment_to = '$new_shipment' where fld_shipment_to = '$old_shipment'");
		         $this->db->query("update tbl_navigations_details set fld_shipment_from = '$new_shipment' where fld_shipment_from = '$old_shipment'");

		     }
			 $this->db->where('fld_purchase_id', $purchase_id);
			 $this->db->delete('tbl_purchase_detail');
		  $p_id = $this->input->post('fld_product_id',TRUE);
		  $sub_category = $this->input->post('sub_category',TRUE);
		  $rate = $this->input->post('fld_unit_price',TRUE);
		  $quantity = $this->input->post('fld_quantity',TRUE);
		  $t_price = $this->input->post('fld_total_amount',TRUE);
		  for ($i = 0, $n = count($p_id); $i < $n; $i++) {
            $product_quantity = $quantity[$i];
            $product_rate = $rate[$i];
            $product_id = $p_id[$i];
            $total_price = $t_price[$i];
            $fld_subproduct_id = $sub_category[$i];
            // $disc = $discount[$i];
            $disc=0;
            
            if($product_id==1){
                $item = $this->db->select('*')->from('tbl_category')->where('fld_id', $product_id)->get()->row()->fld_category;
            }else{
                $item = $this->db->select('*')->from('tbl_subcategory')->where('fld_subcid',$fld_subproduct_id)->get()->row()->fld_subcategory;
            }
            $narration .= $item.', (Q)'.$product_quantity.'(Rs)'.$product_rate.', ';

            $data1 = array(
                'fld_purchase_id'        => $purchase_id,
                'fld_product_id'         => $product_id,
                'fld_subproduct_id'      => $fld_subproduct_id,
                'fld_quantity'           => $product_quantity,
                'fld_unit_price'         => $product_rate,
                'fld_total_amount'       => $total_price,
            );

            if (!empty($quantity)) {
                $this->db->insert('tbl_purchase_detail', $data1);
                $plid = $this->input->post('fld_location',TRUE);
                $get_fld_stock_loc_id = $this->db->query("SELECT * FROM tbl_stock_locations WHERE fld_purchase_location_id = '$plid' AND fld_purch_type = '1' AND fld_purchase_id = '$purchase_id' AND fld_product_id = '$product_id' AND fld_subproduct_id = '$fld_subproduct_id'")->row()->fld_id;
                $this->db->query("UPDATE tbl_stocks SET fld_stock_qty = '$product_quantity' WHERE fld_stock_loc_id = '$get_fld_stock_loc_id'");
            }
        }
        
        $coa_id = $this->db->select('*')->from('tbl_suppliers')->where('fld_id',$data['fld_supplier_id'])->get()->row()->accounts_id;
		
		$v_id = $this->db->query("SELECT id FROM tbl_transections_master WHERE type='Purchase' AND type_id = '$purchase_id'")->row()->id;
		$narration = rtrim($narration, ', ');
        $narration .= ' - '.$data['fld_shipment'];
		$this->db->query("DELETE FROM tbl_transections_details where v_id = '$v_id'");
		$this->db->query("INSERT INTO tbl_transections_details SET v_id = '$v_id', coa_id = '$coa_id', narration = '$narration', credit = '{$data['fld_grand_total_amount']}'");
		$this->db->query("INSERT INTO tbl_transections_details SET v_id = '$v_id', coa_id = '101003001', narration = '$narration', debit = '{$data['fld_grand_total_amount']}'");
    	/****************** Activity Log *****************************/
		
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$user_id=$this->session->userdata('user_id');
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
        $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
        $date=date('Y-m-d H:i:s');
		//$purchase_id='PB-'.sprintf('%04d', $purchase_id);
		$purchase_id='<a href="'.base_url('Purchase/detail/'.$purchase_id.'').'">PB-'.sprintf('%04d', $purchase_id).'</a>';
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'UPDATE',fld_detail='$purchase_id',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
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
            'fld_refinery_id'          => $this->input->post('refinery',TRUE),
            'fld_vehicle_no'          => $this->input->post('vehicle_no',TRUE),
            'fld_invoice_no'        => $this->input->post('fld_invoice_no',TRUE),
            'fld_voucher_no' => $this->input->post('fld_voucher_no',TRUE),
            'fld_purchase_date'     => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('fld_purchase_date',TRUE)))),
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
		  $sub_category = $this->input->post('sub_category',TRUE);
		  $rate = $this->input->post('fld_unit_price',TRUE);
		  $quantity = $this->input->post('fld_quantity',TRUE);
		  $t_price = $this->input->post('fld_total_amount',TRUE);
		  for ($i = 0, $n = count($p_id); $i < $n; $i++) {
            $product_quantity = $quantity[$i];
            $product_rate = $rate[$i];
            $product_id = $p_id[$i];
            $fld_subproduct_id = $sub_category[$i];
            $total_price = $t_price[$i];
            
            // $disc = $discount[$i];
            $disc=0;

            $data1 = array(
                'fld_purchase_id'        => $purchase_id,
                'fld_product_id'         => $product_id,
                'fld_subproduct_id'      => $fld_subproduct_id,
                'fld_quantity'           => $product_quantity,
                'fld_unit_price'               => $product_rate,
                'fld_total_amount'       => $total_price
            );

            if (!empty($quantity)) {
                $this->db->insert('tbl_purchase_detail_draft', $data1);
            }
        }
			$res=array('responce'=>'success',"message"=>"Purchase updated in draft successfully.");
			return $res;
		}else{
			$res=array('responce'=>'error',"message"=>"Purchase not updated in draft.Something went wrong.");
			return $res;
		}
		  
	}
	
	function purchase_draft_update_autosaveentry(){
		$purchase_id =$this->input->post('purchase_id');
		$payment_type=0;
		if($this->input->post('fld_payment_status')  == 3){
			$payment_type=0;
		}else{
			$payment_type=$this->input->post('fld_payment_type');
		}
		$data = array(
            'fld_supplier_id'          => $this->input->post('fld_supplier_id',TRUE),
            'fld_refinery_id'          => $this->input->post('refinery',TRUE),
            'fld_vehicle_no'          => $this->input->post('vehicle_no',TRUE),
            'fld_invoice_no'        => $this->input->post('fld_invoice_no',TRUE),
            'fld_voucher_no' => $this->input->post('fld_voucher_no',TRUE),
            'fld_purchase_date'     => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('fld_purchase_date',TRUE)))),
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
		  $sub_category = $this->input->post('sub_category',TRUE);
		  $rate = $this->input->post('fld_unit_price',TRUE);
		  $quantity = $this->input->post('fld_quantity',TRUE);
		  $t_price = $this->input->post('fld_total_amount',TRUE);
		  for ($i = 0, $n = count($p_id); $i < $n; $i++) {
            $product_quantity = $quantity[$i];
            $product_rate = $rate[$i];
            $product_id = $p_id[$i];
            $fld_subproduct_id = $sub_category[$i];
            $total_price = $t_price[$i];
            
            // $disc = $discount[$i];
            $disc=0;

            $data1 = array(
                'fld_purchase_id'        => $purchase_id,
                'fld_product_id'         => $product_id,
                'fld_subproduct_id'      => $fld_subproduct_id,
                'fld_quantity'           => $product_quantity,
                'fld_unit_price'               => $product_rate,
                'fld_total_amount'       => $total_price
            );

            if (!empty($quantity)) {
                $this->db->insert('tbl_purchase_detail_draft', $data1);
            }
        }
			$res=array('responce'=>'success',"message"=>"Saved in Drafts Automatically.");
			return $res;
		}else{
			$res=array('responce'=>'error',"message"=>"Purchase not updated in draft.Something went wrong.");
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
    
    
    
	function purchase_filter() {
		$conditions="";
		$filter=$this->input->post('filter');
		$group_by='tbl_purchase.fld_voucher_no';
		$select="tbl_purchase.fld_voucher_no as filter_text,tbl_purchase.fld_voucher_no as filter_value";
		switch ($filter) {
		  case "Voucher_Wise":
			$group_by = "tbl_purchase.fld_voucher_no";
			$select="tbl_purchase.fld_voucher_no as filter_text,tbl_purchase.fld_voucher_no as filter_value";
			break;
		  case "User_Wise":
			$group_by = "tbl_purchase.fld_userid";
			$select="tbl_users.fld_username as filter_text,tbl_purchase.fld_userid as filter_value";
			break;
		case "Account_Wise":
			$group_by = "SUBSTRING_INDEX(tbl_purchase.fld_shipment, '/', 2)";
			$select="SUBSTRING_INDEX(tbl_purchase.fld_shipment, '/', 2) as filter_text,SUBSTRING_INDEX(tbl_purchase.fld_shipment, '/', 2) as filter_value";
			break;
		case "Supplier_Wise":
		    $group_by = "SUBSTRING_INDEX(tbl_purchase.fld_shipment, '/', 2)";
			$select="SUBSTRING_INDEX(tbl_purchase.fld_shipment, '/', 2) as filter_text,SUBSTRING_INDEX(tbl_purchase.fld_shipment, '/', 2) as filter_value";
			break;
		case "Item_Wise":
			$group_by = "pd.fld_product_id";
			$select="cat.fld_category as filter_text,pd.fld_product_id as filter_value";
			break;
		case "Plant_Wise":
			$group_by = "tbl_purchase.fld_location_id";
			$select="tbl_locations.fld_location as filter_text,tbl_purchase.fld_location_id as filter_value";
			break;
		case "Rate_Wise":
			$group_by = "pd.fld_unit_price";
			$select="pd.fld_unit_price as filter_text,pd.fld_unit_price as filter_value";
			break;
		case "Invoice_Wise":
			$group_by = "tbl_purchase.fld_invoice_no";
			$select="tbl_purchase.fld_invoice_no as filter_text,tbl_purchase.fld_invoice_no as filter_value";
			break;
		case "Date_Wise":
			$group_by = "tbl_purchase.fld_purchase_date";
			$select="DATE_FORMAT(tbl_purchase.fld_purchase_date, '%d-%m-%Y') as filter_text,tbl_purchase.fld_purchase_date as filter_value";
			break;
		case "Shipment_Wise":
			$group_by = "tbl_purchase.fld_shipment";
			$select="tbl_purchase.fld_shipment as filter_text,tbl_purchase.fld_shipment as filter_value";
			break;
		case "Year_Wise":
			$group_by = "YEAR(tbl_purchase.fld_purchase_date)";
			$select="DATE_FORMAT(tbl_purchase.fld_purchase_date, '%Y') as filter_text,YEAR(tbl_purchase.fld_purchase_date) as filter_value";
			break;
		case "Month_Wise":
			$group_by = "MONTH(tbl_purchase.fld_purchase_date)";
			$select="DATE_FORMAT(tbl_purchase.fld_purchase_date, '%m-%Y') as filter_text,MONTH(tbl_purchase.fld_purchase_date) as filter_value";
			break;
		case "WeekDay_Wise":
			$group_by = "DAYNAME(tbl_purchase.fld_purchase_date)";
			$select="DAYNAME(tbl_purchase.fld_purchase_date) as filter_text,DAYNAME(tbl_purchase.fld_purchase_date) as filter_value";
			break;
		}
		$shipment=$this->input->post('shipment');
		$location=$this->input->post('location');
		$user=$this->input->post('user');
		$item=$this->input->post('item');
		$supplier=$this->input->post('supplier');
		
		$start=str_replace('/', '-', $this->input->post('from_date'));
		$end=str_replace('/', '-', $this->input->post('to_date'));
		
		$date="tbl_purchase.fld_purchase_date between '".date("Y-m-d",strtotime($start))." 00:00:00' AND '".date("Y-m-d",strtotime($end))." 23:59:00'";
		$this->db->select('tbl_purchase.fld_id,'.$select.',tbl_purchase.fld_voucher_no,sum(pd.fld_total_amount) as total_amount,sum(pd.fld_quantity) as total_quantity');
		$this->db->from('tbl_purchase');
		$this->db->join('tbl_purchase_detail as pd','pd.fld_purchase_id=tbl_purchase.fld_id');
		$this->db->join('tbl_category as cat','cat.fld_id=pd.fld_product_id');
		$this->db->join('tbl_suppliers','tbl_suppliers.fld_id=tbl_purchase.fld_supplier_id');
		$this->db->join('tbl_users','tbl_users.fld_id=tbl_purchase.fld_userid');
		$this->db->join('tbl_locations','tbl_locations.fld_id=tbl_purchase.fld_location_id');
		$this->db->where($date);
		if(!empty($location)){
			$this->db->where("tbl_purchase.fld_location_id",$location);
		}
		if(!empty($supplier)){
			$this->db->where("tbl_purchase.fld_supplier_id",$supplier);
		}
		if(!empty($user)){
			$this->db->where("tbl_purchase.fld_userid",$user);
		}
		if(!empty($shipment)){
			$this->db->where("tbl_purchase.fld_shipment",$shipment);
		}
		if(!empty($item)){
			$this->db->where("pd.fld_product_id",$item);
		}
		$this->db->where('tbl_purchase.fld_isdeleted',0);
		$this->db->or_where('tbl_purchase.fld_isdeleted',1);
		if($filter == 'WeekDay_Wise'){
		    $this->db->order_by('DAYOFWEEK(tbl_purchase.fld_purchase_date)', 'ASC');
		}else{
		    $this->db->order_by('tbl_purchase.fld_purchase_date', 'ASC');
		}
		$this->db->group_by($group_by);
		$purchase=$this->db->get()->result_array();
		if($purchase){
			foreach($purchase as $key => $purch){
				$purchdet=$this->getPurchDetail($purch['filter_value'],$group_by);
				$purchase[$key]['detail']=$purchdet;
			}
		}
		return $purchase;
    }
    
	function getPurchDetail($id,$group_by){
	    
	    $start=str_replace('/', '-', $this->input->post('from_date'));
		$end=str_replace('/', '-', $this->input->post('to_date'));
		$date="DATE(tbl_purchase.fld_purchase_date) >= '".date("Y-m-d",strtotime($start))."' AND DATE(tbl_purchase.fld_purchase_date) <= '".date("Y-m-d",strtotime($end))."'";
	return $this->db->query("SELECT `tbl_purchase`.*, `tbl_suppliers`.`fld_supplier_code`, `tbl_suppliers`.`fld_company_name`, SUBSTRING_INDEX(tbl_purchase.fld_shipment, '/', 2) as fld_supplier_name, `pd`.`fld_product_id`, `pd`.`fld_subproduct_id`, `pd`.`fld_quantity`, `pd`.`fld_unit_price`, `pd`.`fld_total_amount`, `cat`.`fld_category`
    FROM `tbl_purchase`
    JOIN `tbl_purchase_detail` as `pd` ON `pd`.`fld_purchase_id`=`tbl_purchase`.`fld_id`
    JOIN `tbl_category` as `cat` ON `cat`.`fld_id`=`pd`.`fld_product_id`
    JOIN `tbl_suppliers` ON `tbl_suppliers`.`fld_id`=`tbl_purchase`.`fld_supplier_id`
    AND $group_by = '$id' && $date")->result_array();
    
    // return $this->db->query("SELECT `tbl_purchase`.*, `tbl_suppliers`.`fld_supplier_code`, `tbl_suppliers`.`fld_company_name`, SUBSTRING_INDEX(tbl_purchase.fld_shipment, '/', 2) as fld_supplier_name, `pd`.`fld_product_id`, `pd`.`fld_subproduct_id`, `pd`.`fld_quantity`, `pd`.`fld_unit_price`, `pd`.`fld_total_amount`, `cat`.`fld_category`
    // FROM `tbl_purchase`
    // JOIN `tbl_purchase_detail` as `pd` ON `pd`.`fld_purchase_id`=`tbl_purchase`.`fld_id`
    // JOIN `tbl_category` as `cat` ON `cat`.`fld_id`=`pd`.`fld_product_id`
    // JOIN `tbl_suppliers` ON `tbl_suppliers`.`fld_id`=`tbl_purchase`.`fld_supplier_id`
    // WHERE `tbl_purchase`.`fld_isdeleted` = 0
    // OR `tbl_purchase`.`fld_isdeleted` = 1
    // AND $group_by = '$id'")->result_array();
    
    // $date="tbl_purchas	
    // $date="tbl_purchase.fld_purchase_date between '".date("Y-m-d",strtotime($start))." 00:00:00' AND '".date("Y-m-d",strtotime($end))." 23:59:00'";
    // this->db->select('tbl_purchase.*,tbl_suppliers.fld_supplier_code,tbl_suppliers.fld_company_name,tbl_suppliers.fld_supplier_name,pd.fld_product_id,pd.fld_subproduct_id,pd.fld_quantity,pd.fld_unit_price,pd.fld_total_amount,cat.fld_category');
    // this->db->from('tbl_purchase');
    // this->db->join('tbl_purchase_detail as pd','pd.fld_purchase_id=tbl_purchase.fld_id');
    // this->db->join('tbl_category as cat','cat.fld_id=pd.fld_product_id');
    // this->db->join('tbl_suppliers','tbl_suppliers.fld_id=tbl_purchase.fld_supplier_id');
    // $this->db->where($date);
    // this->db->where('tbl_purchase.fld_isdeleted',0);
    // $this->db->where($group_by,$id);
    // return $this->db->get()->result_array();

	}
	function purchase_filter_pdf($get) {
	    $_POST = $_GET;
		$conditions="";
		$filter=$this->input->get('filter');
		$group_by='tbl_purchase.fld_voucher_no';
		$select="tbl_purchase.fld_voucher_no as filter_text,tbl_purchase.fld_voucher_no as filter_value";
		switch ($filter) {
		  case "Voucher_Wise":
			$group_by = "tbl_purchase.fld_voucher_no";
			$select="tbl_purchase.fld_voucher_no as filter_text,tbl_purchase.fld_voucher_no as filter_value";
			break;
		  case "User_Wise":
			$group_by = "tbl_purchase.fld_userid";
			$select="tbl_users.fld_username as filter_text,tbl_purchase.fld_userid as filter_value";
			break;
		case "Account_Wise":
			$group_by = "SUBSTRING_INDEX(tbl_purchase.fld_shipment, '/', 2)";
			$select="SUBSTRING_INDEX(tbl_purchase.fld_shipment, '/', 2) as filter_text,SUBSTRING_INDEX(tbl_purchase.fld_shipment, '/', 2) as filter_value";
			break;
		case "Supplier_Wise":
		    $group_by = "SUBSTRING_INDEX(tbl_purchase.fld_shipment, '/', 2)";
			$select="SUBSTRING_INDEX(tbl_purchase.fld_shipment, '/', 2) as filter_text,SUBSTRING_INDEX(tbl_purchase.fld_shipment, '/', 2) as filter_value";
			break;
		case "Item_Wise":
			$group_by = "pd.fld_product_id";
			$select="cat.fld_category as filter_text,pd.fld_product_id as filter_value";
			break;
		case "Plant_Wise":
			$group_by = "tbl_purchase.fld_location_id";
			$select="tbl_locations.fld_location as filter_text,tbl_purchase.fld_location_id as filter_value";
			break;
		case "Rate_Wise":
			$group_by = "pd.fld_unit_price";
			$select="pd.fld_unit_price as filter_text,pd.fld_unit_price as filter_value";
			break;
		case "Invoice_Wise":
			$group_by = "tbl_purchase.fld_invoice_no";
			$select="tbl_purchase.fld_invoice_no as filter_text,tbl_purchase.fld_invoice_no as filter_value";
			break;
		case "Date_Wise":
			$group_by = "tbl_purchase.fld_purchase_date";
			$select="DATE_FORMAT(tbl_purchase.fld_purchase_date, '%d-%m-%Y') as filter_text,tbl_purchase.fld_purchase_date as filter_value";
			break;
		case "Shipment_Wise":
			$group_by = "tbl_purchase.fld_shipment";
			$select="tbl_purchase.fld_shipment as filter_text,tbl_purchase.fld_shipment as filter_value";
			break;
		case "Year_Wise":
			$group_by = "YEAR(tbl_purchase.fld_purchase_date)";
			$select="DATE_FORMAT(tbl_purchase.fld_purchase_date, '%Y') as filter_text,YEAR(tbl_purchase.fld_purchase_date) as filter_value";
			break;
		case "Month_Wise":
			$group_by = "MONTH(tbl_purchase.fld_purchase_date)";
			$select="DATE_FORMAT(tbl_purchase.fld_purchase_date, '%m-%Y') as filter_text,MONTH(tbl_purchase.fld_purchase_date) as filter_value";
			break;
		case "WeekDay_Wise":
			$group_by = "DAYNAME(tbl_purchase.fld_purchase_date)";
			$select="DAYNAME(tbl_purchase.fld_purchase_date) as filter_text,DAYNAME(tbl_purchase.fld_purchase_date) as filter_value";
			break;
		}
		$shipment=$this->input->get('shipment');
		$location=$this->input->get('location');
		$user=$this->input->get('user');
		$item=$this->input->get('item');
		$supplier=$this->input->get('supplier');
		
		$start=str_replace('/', '-', $this->input->get('from_date'));
		$end=str_replace('/', '-', $this->input->get('to_date'));
		$date="tbl_purchase.fld_purchase_date between '".date("Y-m-d",strtotime($start))." 00:00:00' AND '".date("Y-m-d",strtotime($end))." 23:59:00'";
		$this->db->select('tbl_purchase.fld_id,'.$select.',tbl_purchase.fld_voucher_no,sum(pd.fld_total_amount) as total_amount,sum(pd.fld_quantity) as total_quantity');
		
		$this->db->from('tbl_purchase');
		
		$this->db->join('tbl_purchase_detail as pd','pd.fld_purchase_id=tbl_purchase.fld_id');
		
		$this->db->join('tbl_category as cat','cat.fld_id=pd.fld_product_id');
		
		$this->db->join('tbl_suppliers','tbl_suppliers.fld_id=tbl_purchase.fld_supplier_id');
		
		$this->db->join('tbl_users','tbl_users.fld_id=tbl_purchase.fld_userid');
		
		$this->db->join('tbl_locations','tbl_locations.fld_id=tbl_purchase.fld_location_id');
		
		$this->db->where($date);
		
		if(!empty($location)){
			$this->db->where("tbl_purchase.fld_location_id",$location);
		}
		if(!empty($supplier)){
			$this->db->where("tbl_purchase.fld_supplier_id",$supplier);
		}
		if(!empty($user)){
			$this->db->where("tbl_purchase.fld_userid",$user);
		}
		if(!empty($shipment)){
			$this->db->where("tbl_purchase.fld_shipment",$shipment);
		}
		if(!empty($item)){
			$this->db->where("pd.fld_product_id",$item);
		}
		$this->db->where('tbl_purchase.fld_isdeleted',0);
		
		$this->db->group_by($group_by);
		
		$purchase=$this->db->get()->result_array();
		if($purchase){
			foreach($purchase as $key => $purch){
				$purchdet=$this->getPurchDetail($purch['filter_value'],$group_by);
				$purchase[$key]['detail']=$purchdet;
			}
		}
		return $purchase;
		
		
		
        
    }
   
}
