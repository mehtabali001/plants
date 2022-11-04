<?php

if (!defined('BASEPATH')) 
    exit('No direct script access allowed');
 
class Gain_loss_model extends CI_Model { 
 
    public function __construct() {   
        parent::__construct(); 
    } 

    function getMaxGlID() {
		$sql="SHOW TABLE STATUS LIKE 'tbl_gain_loss'";
		return $this->db->query($sql)->row_array();
        
    }
	function getAllProducts() { 
		  
		$this->db->select('tbl_category.*,tbl_units.fld_unit'); 
		
		$this->db->from('tbl_category');
		
		$this->db->join('tbl_units','tbl_units.fld_id=tbl_category.fld_unit','left');
		
		return $this->db->get()->result_array();
        
    }
	function getAllGL() {
		
		$this->db->select('tbl_gain_loss.*');
		
		$this->db->from('tbl_gain_loss');
		
		$this->db->where('tbl_gain_loss.fld_isdeleted',0);
		
		return $this->db->get()->result_array();
        
    }
    function getAllTrashGL() {
		
		$this->db->select('tbl_gain_loss.*');
		
		$this->db->from('tbl_gain_loss');
		
		$this->db->where('tbl_gain_loss.fld_isdeleted',1);
		
		return $this->db->get()->result_array();
        
    }
	function getAllDraftPurchases() {
		
		$this->db->select('tbl_purchase_draft.*,tbl_suppliers.fld_supplier_code,tbl_suppliers.fld_company_name,tbl_suppliers.fld_supplier_name');
		
		$this->db->from('tbl_purchase_draft');
		
		$this->db->join('tbl_suppliers','tbl_suppliers.fld_id=tbl_purchase_draft.fld_supplier_id');
		
		return $this->db->get()->result_array();
        
    }
	function getGLByID($id) {
		
		$this->db->select('tbl_gain_loss.*');
		
		$this->db->from('tbl_gain_loss');
		
		$this->db->where('tbl_gain_loss.fld_id',$id);
		
		$record=$this->db->get()->row_array();
		if($record){
			foreach($record as $key => $rec){
				
				$record['products']=$this->getGLProducts($id);
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
	function getGLProducts($id){
		
		$this->db->select('tbl_gainloss_details.*');
		
		$this->db->from('tbl_gainloss_details');
		
		$this->db->where('tbl_gainloss_details.fld_gl_id',$id);
		
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
	
	function gain_loss_entry(){
		$gl_id = date('YmdHis');
		$user_id=$this->session->userdata('user_id');
		$data = array(
			'fld_userid'        => $user_id,
            'fld_voucher_no' => $this->input->post('fld_voucher_no',TRUE),
            'fld_date'     => date('Y-m-d',strtotime(str_replace('/', '-', $this->input->post('fld_date',TRUE)))),
            'fld_remarks'      => $this->input->post('fld_remarks',TRUE),
            'fld_grand_total_amount'   => $this->input->post('fld_grand_total_amount',TRUE),
        );
		 $responce=$this->db->insert('tbl_gain_loss', $data);
		 if($responce){
		     $insert_id = $this->db->insert_id();
		  $now = date('Y-m-d H:i:s');
    	  $this->db->query("INSERT into tbl_transections_master SET type = 'GainLoss', type_id = '$insert_id', date = '{$data['fld_date']}', user_id = '$user_id', created_date = '$now'");
    	  $v_id = $this->db->insert_id();
		  $totalquantity=0;
		  $p_id = $this->input->post('fld_product_id',TRUE);
		  $l_id = $this->input->post('fld_location_id',TRUE);
		  $shipment = $this->input->post('fld_shipment',TRUE);
		  $type = $this->input->post('fld_type',TRUE);
		  $rate = $this->input->post('fld_unit_price',TRUE);
		  $quantity = $this->input->post('fld_quantity',TRUE);
		  $stock_location_id = $this->input->post('fld_stock_location_id',TRUE);
		  $t_price = $this->input->post('fld_total_amount',TRUE);
		  for ($i = 0, $n = count($p_id); $i < $n; $i++) {
			$totalquantity=$totalquantity + $quantity[$i]; 
            $product_quantity = $quantity[$i];
            $product_rate = $rate[$i];
            $product_id = $p_id[$i];
            $location_id = $l_id[$i];
            $fld_shipment = $shipment[$i];
            $fld_type = $type[$i];
            $total_price = $t_price[$i];
            $slid = $stock_location_id[$i];
            // $disc = $discount[$i];
            $disc=0;

            $data1 = array(
                'fld_gl_id'        => $insert_id,
                'fld_stock_location_id' => $slid,
                'fld_product_id'         => $product_id,
                'fld_location_id'       => $location_id,
                'fld_shipment' => $fld_shipment,
                'fld_type'          => $fld_type, 
                'fld_quantity'           => $product_quantity,
                'fld_unit_price'               => $product_rate,
                'fld_total_amount'       => $total_price
            ); 

            if (!empty($quantity)) {
                $this->db->insert('tbl_gainloss_details', $data1);
                $gld_id = $this->db->insert_id();
                $getfInvetory_id = $this->db->query("SELECT * FROM tbl_locations WHERE fld_id = '{$data1['fld_location_id']}'")->row()->inventory_account;
                if($fld_type == 3){
                    $amounta = abs($total_price);
                    $narration = 'Weight Diffrence / '.$fld_shipment;
                    if($data1['fld_quantity']>0){
                        $this->db->query("INSERT INTO tbl_transections_details SET v_id = '$v_id', coa_id = '401002001', narration = '$narration', credit = '$amounta'");
    		            $this->db->query("INSERT INTO tbl_transections_details SET v_id = '$v_id', coa_id = '$getfInvetory_id', narration = '$narration', debit = '$amounta'");
                    }else{
                        $this->db->query("INSERT INTO tbl_transections_details SET v_id = '$v_id', coa_id = '401002001', narration = '$narration', debit = '$amounta'");
    		            $this->db->query("INSERT INTO tbl_transections_details SET v_id = '$v_id', coa_id = '$getfInvetory_id', narration = '$narration', credit = '$amounta'");
                    }
                }else if($fld_type == 1){
                    $amounta = abs($total_price);
                    $narration = 'LPG Gain / '.$fld_shipment;
                    if($data1['fld_quantity']>0){
                        $this->db->query("INSERT INTO tbl_transections_details SET v_id = '$v_id', coa_id = '401002001', narration = '$narration', credit = '$amounta'");
    		            $this->db->query("INSERT INTO tbl_transections_details SET v_id = '$v_id', coa_id = '$getfInvetory_id', narration = '$narration', debit = '$amounta'");
                    }
                    
                    $locinsert=array(
        		    "fld_purchase_location_id"=>$data1['fld_location_id'],
        		    "fld_parent_id"=>0,
        		    "fld_purch_type"=>1,
        		    "fld_gl_id"=>$gld_id,
        		    "fld_product_id"=>1,
        		    "fld_subproduct_id"=>0,
            		);
        		    $this->db->insert('tbl_stock_locations', $locinsert);
            		$locinsert_id = $this->db->insert_id();
            		$stockinsert=array(
            		    "fld_stock_qty"=> round(($product_quantity/1000), 3),
            		    "fld_stock_loc_id"=>$locinsert_id,
            		);
        		    $this->db->insert('tbl_stocks', $stockinsert);
                }else if($fld_type == 2){
                    $amounta = abs($total_price);
                    $narration = 'LPG Loss / '.$fld_shipment;
                    if($data1['fld_quantity']>0){
                        $this->db->query("INSERT INTO tbl_transections_details SET v_id = '$v_id', coa_id = '401002001', narration = '$narration', debit = '$amounta'");
    		            $this->db->query("INSERT INTO tbl_transections_details SET v_id = '$v_id', coa_id = '$getfInvetory_id', narration = '$narration', credit = '$amounta'");
                    }
                }
                
            }
            
            
        }
        
       
		
		/****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$user_id=$this->session->userdata('user_id');
		$voucher_no=$this->input->post('fld_voucher_no',TRUE);
		$voucher_no='<a href="javascript:;">'.$voucher_no.'</a>';
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
        $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
        $date=date('Y-m-d H:i:s');
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'ADD',fld_detail='$voucher_no',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
		
		$this->session->set_userdata('success_message', "Gain Loss added successfully.");
		return true;
		}else{
			$this->session->set_userdata('success_message', "Gain Loss not added.");
			return false; 
		}
	}
	
	function gain_loss_update_entry(){
		$gl_id = $this->input->post('fld_id',TRUE);
		$user_id=$this->session->userdata('user_id');
		$data = array(
            'fld_voucher_no' => $this->input->post('fld_voucher_no',TRUE),
            'fld_date'     => date('Y-m-d',strtotime(str_replace('/', '-', $this->input->post('fld_date',TRUE)))),
            'fld_remarks'      => $this->input->post('fld_remarks',TRUE),
            'fld_grand_total_amount'   => $this->input->post('fld_grand_total_amount',TRUE),
        );
		$this->db->where('fld_id', $gl_id);
		$responce= $this->db->update('tbl_gain_loss', $data);
		if($responce){
		  $this->db->where('fld_gl_id', $gl_id);
		  $this->db->delete('tbl_gainloss_details');
		  
		  $this->db->query("DELETE FROM `tbl_stock_locations` WHERE fld_gl_id NOT IN (SELECT fld_id FROM tbl_gainloss_details) and fld_gl_id != 0");
		  $this->db->query("DELETE FROM `tbl_stocks` WHERE fld_stock_loc_id NOT IN (SELECT fld_id from tbl_stock_locations)");
		    
		  $insert_id = $gl_id;
		  $v_id = $this->db->query("SELECT id FROM tbl_transections_master WHERE type='GainLoss' AND type_id = '$gl_id'")->row()->id;
		  $this->db->query("DELETE FROM tbl_transections_details where v_id = '$v_id'");
		  $totalquantity=0;
		  $p_id = $this->input->post('fld_product_id',TRUE);
		  $l_id = $this->input->post('fld_location_id',TRUE);
		  $shipment = $this->input->post('fld_shipment',TRUE);
		  $type = $this->input->post('fld_type',TRUE);
		  $rate = $this->input->post('fld_unit_price',TRUE);
		  $quantity = $this->input->post('fld_quantity',TRUE);
		  $stock_location_id = $this->input->post('fld_stock_location_id',TRUE);
		  $t_price = $this->input->post('fld_total_amount',TRUE);
		  for ($i = 0, $n = count($p_id); $i < $n; $i++) {
			$totalquantity=$totalquantity + $quantity[$i]; 
            $product_quantity = $quantity[$i];
            $product_rate = $rate[$i];
            $product_id = $p_id[$i];
            $location_id = $l_id[$i];
            $fld_shipment = $shipment[$i];
            $fld_type = $type[$i];
            $total_price = $t_price[$i];
            $slid = $stock_location_id[$i];
            // $disc = $discount[$i];
            $disc=0;

            $data1 = array(
                'fld_gl_id'        => $insert_id,
                'fld_stock_location_id' => $slid,
                'fld_product_id'         => $product_id,
                'fld_location_id'       => $location_id,
                'fld_shipment' => $fld_shipment,
                'fld_type'          => $fld_type, 
                'fld_quantity'           => $product_quantity,
                'fld_unit_price'               => $product_rate,
                'fld_total_amount'       => $total_price
            ); 

            if (!empty($quantity)) {
                $this->db->insert('tbl_gainloss_details', $data1);
                $gld_id = $this->db->insert_id();
                if($fld_type == 3){
                    $amounta = abs($total_price);
                    $narration = 'Weight Diffrence / '.$fld_shipment;
                    if($data1['fld_quantity']>0){
                        $this->db->query("INSERT INTO tbl_transections_details SET v_id = '$v_id', coa_id = '401002001', narration = '$narration', credit = '$amounta'");
    		            $this->db->query("INSERT INTO tbl_transections_details SET v_id = '$v_id', coa_id = '101003001', narration = '$narration', debit = '$amounta'");
                    }else{
                        $this->db->query("INSERT INTO tbl_transections_details SET v_id = '$v_id', coa_id = '401002001', narration = '$narration', debit = '$amounta'");
    		            $this->db->query("INSERT INTO tbl_transections_details SET v_id = '$v_id', coa_id = '101003001', narration = '$narration', credit = '$amounta'");
                    }
                }else if($fld_type == 1){
                    $amounta = abs($total_price);
                    $narration = 'LPG Gain / '.$fld_shipment;
                    if($data1['fld_quantity']>0){
                        $this->db->query("INSERT INTO tbl_transections_details SET v_id = '$v_id', coa_id = '401002001', narration = '$narration', credit = '$amounta'");
    		            $this->db->query("INSERT INTO tbl_transections_details SET v_id = '$v_id', coa_id = '101003001', narration = '$narration', debit = '$amounta'");
                    }
                    
                    $locinsert=array(
        		    "fld_purchase_location_id"=>$data1['fld_location_id'],
        		    "fld_parent_id"=>0,
        		    "fld_purch_type"=>1,
        		    "fld_gl_id"=>$gld_id,
        		    "fld_product_id"=>1,
        		    "fld_subproduct_id"=>0,
            		);
        		    $this->db->insert('tbl_stock_locations', $locinsert);
            		$locinsert_id = $this->db->insert_id();
            		$stockinsert=array(
            		    "fld_stock_qty"=> round(($product_quantity/1000), 3),
            		    "fld_stock_loc_id"=>$locinsert_id,
            		);
        		    $this->db->insert('tbl_stocks', $stockinsert);
                }else if($fld_type == 2){
                    $amounta = abs($total_price);
                    $narration = 'LPG Loss / '.$fld_shipment;
                    if($data1['fld_quantity']>0){
                        $this->db->query("INSERT INTO tbl_transections_details SET v_id = '$v_id', coa_id = '401002001', narration = '$narration', debit = '$amounta'");
    		            $this->db->query("INSERT INTO tbl_transections_details SET v_id = '$v_id', coa_id = '101003001', narration = '$narration', credit = '$amounta'");
                    }
                }
                
            }
            
            
        }
        /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$user_id=$this->session->userdata('user_id');
		$voucher_no=$this->input->post('fld_voucher_no',TRUE);
		$voucher_no='<a href="javascript:;">'.$voucher_no.'</a>';
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
        $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
        $date=date('Y-m-d H:i:s');
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'UPDATE',fld_detail='$voucher_no',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
		$this->session->set_userdata('success_message', "Gain Loss Edited successfully.");
		return true;
		}else{
			$this->session->set_userdata('success_message', "Gain Loss not added.");
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
            'fld_purchase_date'     => date('Y-m-d',strtotime($this->input->post('fld_purchase_date',TRUE))),
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
    
	function gain_loss_filter() {
		$conditions="";
		$filter=$this->input->post('filter');
		$group_by='tbl_gain_loss.fld_voucher_no';
		$select="tbl_gain_loss.fld_voucher_no as filter_text,tbl_gain_loss.fld_voucher_no as filter_value";
		switch ($filter) {
		  case "Voucher_Wise":
			$group_by = "tbl_gain_loss.fld_voucher_no";
			$select="tbl_gain_loss.fld_voucher_no as filter_text,tbl_gain_loss.fld_voucher_no as filter_value";
			break;
		  case "User_Wise":
			$group_by = "tbl_gain_loss.fld_userid";
			$select="tbl_users.fld_username as filter_text,tbl_gain_loss.fld_userid as filter_value";
			break;
		case "Item_Wise":
			$group_by = "gld.fld_product_id";
			$select="cat.fld_category as filter_text,gld.fld_product_id as filter_value";
			break;
		case "Plant_Wise":
			$group_by = "gld.fld_location_id";
			$select="tbl_locations.fld_location as filter_text,gld.fld_location_id as filter_value";
			break;
		case "Rate_Wise":
			$group_by = "gld.fld_unit_price";
			$select="gld.fld_unit_price as filter_text,gld.fld_unit_price as filter_value";
			break;
		case "Date_Wise":
			$group_by = "tbl_gain_loss.fld_date";
			$select="DATE_FORMAT(tbl_gain_loss.fld_date, '%d-%m-%Y') as filter_text,tbl_gain_loss.fld_date as filter_value";
			break;
		case "Shipment_Wise":
			$group_by = "gld.fld_shipment";
			$select="gld.fld_shipment as filter_text,gld.fld_shipment as filter_value";
			break;
		case "Year_Wise":
			$group_by = "YEAR(tbl_gain_loss.fld_date)";
			$select="DATE_FORMAT(tbl_gain_loss.fld_date, '%Y') as filter_text,YEAR(tbl_gain_loss.fld_date) as filter_value";
			break;
		case "Month_Wise":
			$group_by = "MONTH(tbl_gain_loss.fld_date)";
			$select="DATE_FORMAT(tbl_gain_loss.fld_date, '%m-%Y') as filter_text,MONTH(tbl_gain_loss.fld_date) as filter_value";
			break;
		case "WeekDay_Wise":
			$group_by = "DAYNAME(tbl_gain_loss.fld_date)";
			$select="DAYNAME(tbl_gain_loss.fld_date) as filter_text,DAYNAME(tbl_gain_loss.fld_date) as filter_value";
			break;
		}
		$shipment=$this->input->post('shipment');
		$location=$this->input->post('location');
		$user=$this->input->post('user');
		$item=$this->input->post('item');
		
		$start=str_replace('/', '-', $this->input->post('from_date'));
		$end=str_replace('/', '-', $this->input->post('to_date'));
		$date="tbl_gain_loss.fld_date between '".date("Y-m-d",strtotime($start))." 00:00:00' AND '".date("Y-m-d",strtotime($end))." 23:59:00'";
		
		
		$this->db->select('tbl_gain_loss.fld_id,'.$select.',tbl_gain_loss.fld_voucher_no,sum(gld.fld_total_amount) as total_amount,sum(gld.fld_quantity) as total_quantity');
		
		$this->db->from('tbl_gain_loss');
		
		$this->db->join('tbl_gainloss_details as gld','gld.fld_gl_id=tbl_gain_loss.fld_id');
		
		$this->db->join('tbl_category as cat','cat.fld_id=gld.fld_product_id');
		
		$this->db->join('tbl_users','tbl_users.fld_id=tbl_gain_loss.fld_userid');
		
		$this->db->join('tbl_locations','tbl_locations.fld_id=gld.fld_location_id');
		
		$this->db->where($date);
		
		if(!empty($location)){
			$this->db->where("gld.fld_location_id",$location);
		}
		if(!empty($user)){
			$this->db->where("tbl_gain_loss.fld_userid",$user);
		}
	
		if(!empty($shipment)){
			$this->db->where("gld.fld_shipment",$shipment);
		}
		if(!empty($item)){
			$this->db->where("gld.fld_product_id",$item);
		}
		$this->db->where('tbl_gain_loss.fld_isdeleted',0);
		
		$this->db->group_by($group_by);
		
		$gain_loss=$this->db->get()->result_array();
		//echo $this->db->last_query();exit;
		if($gain_loss){
			foreach($gain_loss as $key => $gainloss){
				$gain_loss_det=$this->getGLDetail($gainloss['filter_value'],$group_by);
				$gain_loss[$key]['detail']=$gain_loss_det;
			}
		}
		return $gain_loss;
		
		
        
    }
	function getGLDetail($id,$group_by){
		//$date="tbl_purchase.fld_purchase_date between '".date("Y-m-d",strtotime($start))." 00:00:00' AND '".date("Y-m-d",strtotime($end))." 23:59:00'";
		$this->db->select('tbl_gain_loss.*,gld.fld_product_id,gld.fld_shipment,gld.fld_quantity,gld.fld_unit_price,gld.fld_total_amount, gld.fld_type, cat.fld_category, tbl_locations.fld_location');
		
		$this->db->from('tbl_gain_loss');
		
		$this->db->join('tbl_gainloss_details as gld','gld.fld_gl_id=tbl_gain_loss.fld_id');
		
		$this->db->join('tbl_category as cat','cat.fld_id=gld.fld_product_id');
		
		$this->db->join('tbl_locations','tbl_locations.fld_id=gld.fld_location_id');
		
		$start=str_replace('/', '-', $this->input->post('from_date'));
		$end=str_replace('/', '-', $this->input->post('to_date'));
		$date="tbl_gain_loss.fld_date between '".date("Y-m-d",strtotime($start))." 00:00:00' AND '".date("Y-m-d",strtotime($end))." 23:59:00'";
		$this->db->where($date);
		
		$this->db->where('tbl_gain_loss.fld_isdeleted',0);
		
		$this->db->where($group_by,$id);
		
		return $this->db->get()->result_array();
	}
	function purchase_filter_pdf($get) {
		$conditions="";
		$filter=$get['type'];
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
			$group_by = "tbl_purchase.fld_supplier_id";
			$select="tbl_suppliers.fld_supplier_name as filter_text,tbl_purchase.fld_supplier_id as filter_value";
			break;
		case "Supplier_Wise":
			$group_by = "tbl_purchase.fld_supplier_id";
			$select="tbl_suppliers.fld_supplier_name as filter_text,tbl_purchase.fld_supplier_id as filter_value";
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
		$category=$this->input->post('category');
		$subcategory=$this->input->post('subcategory');
		$supplier=$this->input->post('supplier');
		
		$start=str_replace('/', '-', $get['form']);
		$end=str_replace('/', '-', $get['to']);
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
		if(!empty($category)){
			$this->db->where("pd.fld_product_id",$category);
		}
		if(!empty($subcategory)){
			$this->db->where("cat.fld_subcategory",$subcategory);
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
