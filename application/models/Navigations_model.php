<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Navigations_model extends CI_Model {
  
    public function __construct() { 
        parent::__construct();
    } 

    function getMaxID() {
		$sql="SHOW TABLE STATUS LIKE 'tbl_navigations'";
		return $this->db->query($sql)->row_array();
        
    }
    function getMaxDraftID() {
		$sql="SHOW TABLE STATUS LIKE 'tbl_navigations_draft'";
		return $this->db->query($sql)->row_array();
        
    }
	function getAllProducts() {
		
		$this->db->select('tbl_category.*,tbl_units.fld_unit');
		$this->db->from('tbl_category');
		$this->db->join('tbl_units','tbl_units.fld_id=tbl_category.fld_unit','left');
		return $this->db->get()->result_array();
    }
	
   function navigation_entry(){
       
        $navigationid = $this->input->post('navigation_id');
		if(!empty($navigationid)){
		    $this->db->where('fld_id', $navigationid);
			$this->db->delete('tbl_navigations_draft');
		    $this->db->where('fld_navigation_id', $navigationid);
			$this->db->delete('tbl_navigations_draft_details'); 
		}
        
		$user_id=$this->session->userdata('user_id');
		if($this->input->post('fld_location_from',TRUE) == 4){
		    $nav_type = 1;
		}else{
		    $nav_type = 2;
		}
		
		if($this->input->post('fld_bowser',TRUE) == ''){
		    $bowser = 0;
		}else{
		    $bowser = $this->input->post('fld_bowser',TRUE);
		}
		
		$data = array(
            'fld_userid'        => $user_id,
            'fld_stock_loc_id'        => 0,
            'fld_nav_type'  =>      $nav_type,
            'fld_received_by'          => $this->input->post('fld_received_by',TRUE),
            'fld_remarks'        => $this->input->post('fld_remarks',TRUE),
            'fld_date' => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('fld_navigation_date',TRUE)))),
            'fld_freight_MT'     => $this->input->post('fld_freight_rate',TRUE),
            'fld_freight_amount' => $this->input->post('fld_freight_amount',TRUE),
            'fld_bowser'      => $bowser,
            //'fld_quantity'   => $this->input->post('fld_quantity',TRUE),
            //'fld_weight'        => $this->input->post('fld_weight',TRUE),
            'fld_total_amount'         => $this->input->post('fld_grand_total',TRUE),
            'fld_location_from'         => $this->input->post('fld_location_from',TRUE),
            'fld_location_to'         => $this->input->post('fld_location_to',TRUE),
            'fld_created_date'   =>  date("Y-m-d H:i:s")
        );
       
        $responce=$this->db->insert('tbl_navigations', $data);
        
		$navigation_id = $this->db->insert_id();
		$item_id = $this->input->post('fld_item',TRUE);
		$sitem_id = $this->input->post('fld_sitem',TRUE);
        $item_qty = $this->input->post('fld_item_qty',TRUE);
        $item_weight = $this->input->post('fld_item_weight',TRUE);
        $rate = $this->input->post('fld_rate',TRUE);
        $amount = $this->input->post('fld_amount',TRUE);
        $stock_location_id = $this->input->post('stock_location_id',TRUE);
        $fld_shipment_from  = $this->input->post('fld_shipment_from',TRUE);
        
        for ($i = 0, $n = count($sitem_id); $i < $n; $i++) {
            
            if(isset($_POST['createInt'])){
                
                $shipment_from = $fld_shipment_from[$i];
                $fitem_id = $item_id;
            }else{
                $shipment_from = $fld_shipment_from;
                $fitem_id = $item_id[$i];
            }
            $data1 = array(
                'fld_navigation_id'     => $navigation_id,
                'fld_stock_loc_id'      => $stock_location_id[$i],
                'fld_shipment_from'     => $shipment_from,
                'fld_product_id'        => $fitem_id,
                'fld_subproduct_id'     => $sitem_id[$i],
                'fld_qty'               => $item_qty[$i],
                'fld_weight'            => $item_weight[$i],
                'fld_rate'              => $rate[$i],
                'fld_amount'            => $amount[$i]
            );
            
            if($item_qty[$i] > 0){
            $this->db->insert('tbl_navigations_details', $data1);
            $navigation_detail_id = $this->db->insert_id();
            if(isset($_POST['createInt'])){
                $purchase_id = $this->input->post('fld_purchase_id',TRUE)[$i];
            }else{
                $purchase_id = $this->input->post('purchase_id',TRUE);
            }
            $old_freight = 0;
            $getOldNavigations = $this->db->query("SELECT * FROM tbl_stock_locations WHERE  fld_purchase_id = '$purchase_id' && fld_nav_id != 0");
            foreach($getOldNavigations->result_array() as $rownav){
                $old_freight += $this->db->query("SELECT a.credit from tbl_transections_details a, tbl_transections_master b WHERE b.id = a.v_id && b.type = 'Navigation' && b.type_id = '{$rownav['fld_nav_id']}' && a.coa_id LIKE '101024%'")->row()->credit;
            }
            
			 $stock_loc = array(
                'fld_purchase_location_id' => $this->input->post('fld_location_to',TRUE),
                'fld_parent_id'     => $stock_location_id[$i],
                'fld_purch_type'    => 2,
                'fld_purchase_id'   => $purchase_id,
                'fld_nav_id'   =>   $navigation_id, 
                'fld_product_id'    => $fitem_id,
        		'fld_subproduct_id' => $sitem_id[$i],
            );
			
           $this->db->insert('tbl_stock_locations', $stock_loc); 
		   $stock_loc_id = $this->db->insert_id();
		   
		   $stock = array(
                'fld_stock_loc_id'  => $stock_loc_id,
                'fld_stock_qty'     => $item_qty[$i],
            );

           $this->db->insert('tbl_stocks', $stock);
		   
		   $this->db->where('fld_id',$navigation_detail_id);
		   $this->db->update('tbl_navigations_details', array("fld_stock_loc_id"=>$stock_loc_id));
            }
        }
        
        $now = date('Y-m-d H:i:s');
        $location_from = $this->db->select('*')->from('tbl_locations')->where('fld_id',$data['fld_location_from'])->get()->row()->fld_location;
        $location_to = $this->db->select('*')->from('tbl_locations')->where('fld_id',$data['fld_location_to'])->get()->row()->fld_location;
        
        $getfInvetory_id = $this->db->query("SELECT * FROM tbl_locations WHERE fld_id = '{$data['fld_location_from']}'")->row()->inventory_account;
        $gettInvetory_id = $this->db->query("SELECT * FROM tbl_locations WHERE fld_id = '{$data['fld_location_to']}'")->row()->inventory_account;
         
       
        $this->db->query("INSERT into tbl_transections_master SET type = 'Navigation', type_id = '$navigation_id', date = '{$data['fld_date']}', user_id = '$user_id', created_date = '$now'");
		$v_id = $this->db->insert_id();
		$narration = $location_from.'-'.$location_to.', '.$data1['fld_shipment_from'];
		
		$amount_move = $this->input->post('fld_total_amount',TRUE);
		
		$this->db->query("INSERT INTO tbl_transections_details SET v_id = '$v_id', coa_id = '$getfInvetory_id', narration = '$narration', credit = '$amount_move'");
		$this->db->query("INSERT INTO tbl_transections_details SET v_id = '$v_id', coa_id = '$gettInvetory_id', narration = '$narration', debit = '$amount_move'");
		if($old_freight>0){
		    $this->db->query("INSERT INTO tbl_transections_details SET v_id = '$v_id', coa_id = '$getfInvetory_id', narration = '$narration', credit = '$old_freight'");
		}
		
		$this->db->query("INSERT INTO tbl_transections_details SET v_id = '$v_id', coa_id = '101024001', narration = '$narration', credit = '{$data['fld_freight_amount']}'");
		$freight_amount = $old_freight+$data['fld_freight_amount'];
		$this->db->query("INSERT INTO tbl_transections_details SET v_id = '$v_id', coa_id = '$gettInvetory_id', narration = '$narration', debit = '$freight_amount'");
        
        /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$user_id=$this->session->userdata('user_id');
		//$navigation_id=sprintf(' NI-%04d ', $navigation_id);
		$navigation_id='<a href="'.base_url('Navigations/detail/'.$navigation_id.'').'">NI-'.sprintf('%04d', $navigation_id).'</a>';
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
        $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
        $date=date('Y-m-d H:i:s');
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'ADD',fld_detail=' $navigation_id',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
       
		 
// 		 if($responce){
			 
		 /* $move_stock_loc_id = $this->input->post('stock_location_id',TRUE);
		  $move_stock_loc_qty = $this->input->post('fld_item_qty',TRUE);
		  $query="update tbl_stocks set fld_stock_qty=fld_stock_qty-".$move_stock_loc_qty." where fld_stock_loc_id=".$move_stock_loc_id."";
		  $this->db->where('fld_stock_loc_id',$move_stock_loc_id);
		  $this->db->update('tbl_stocks',array('fld_stock_qty'=>"fld_stock_qty" - $move_stock_loc_qty));
		  $this->db->query($query);*/
		$this->session->set_userdata('success_message', "Navigation added successfully.");
		return true;
// 		}else{
// 		$this->session->set_userdata('success_message', "Navigation not added.");
// 			return false; 
// 		}
	}
	
	function navigation_draft_entry_autosave(){
		$user_id=$this->session->userdata('user_id');
		
		if($this->input->post('fld_location_from',TRUE) == 4){
		    $nav_type = 1;
		}else{
		    $nav_type = 2;
		}
		
		$data = array(
            'fld_userid'        => $user_id,
            'fld_stock_loc_id'        => 0,
            'fld_nav_type'  =>      $nav_type,
            'fld_received_by'          => $this->input->post('fld_received_by',TRUE),
            'fld_remarks'        => $this->input->post('fld_remarks',TRUE),
            'fld_date' => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('fld_navigation_date',TRUE)))),
            'fld_freight_MT'     => $this->input->post('fld_freight_rate',TRUE),
            'fld_freight_amount'      => $this->input->post('fld_freight_amount',TRUE),
            'fld_bowser'      => $this->input->post('fld_bowser',TRUE),
            //'fld_quantity'   => $this->input->post('fld_quantity',TRUE),
            //'fld_weight'        => $this->input->post('fld_weight',TRUE),
            'fld_total_amount'      => $this->input->post('fld_grand_total',TRUE), 
            'fld_location_from'     => $this->input->post('fld_location_from',TRUE),
          //'fld_shipment_from'    => $this->input->post('fld_shipment_from',TRUE),
          //'fld_shipment_to'         => $this->input->post('fld_shipment_to',TRUE),
            'fld_location_to'         => $this->input->post('fld_location_to',TRUE),
            'fld_created_date'   =>  date("Y-m-d H:i:s")
        );
        $responce = $this->db->insert('tbl_navigations_draft', $data);
        $navigation_id = $this->db->insert_id();
		$item_id = $this->input->post('fld_item',TRUE);
		$sitem_id = $this->input->post('fld_sitem',TRUE);
        $item_qty = $this->input->post('fld_item_qty',TRUE);
        $item_weight = $this->input->post('fld_item_weight',TRUE);
        $rate = $this->input->post('fld_rate',TRUE);
        $amount = $this->input->post('fld_amount',TRUE);
        $stock_location_id = $this->input->post('stock_location_id',TRUE);
        $fld_shipment_from  = $this->input->post('fld_shipment_from',TRUE);

         for ($i = 0, $n = count($sitem_id); $i < $n; $i++) {
             
            if(isset($_POST['createInt'])){
                $shipment_from = $fld_shipment_from[$i];
                $fitem_id = $item_id;
            }else{
                $shipment_from = $fld_shipment_from;
                $fitem_id = $item_id[$i];
            }
            
            $data1 = array(
                'fld_navigation_id'     => $navigation_id,
                'fld_stock_loc_id'      => $stock_location_id[$i],
                'fld_shipment_from'     => $shipment_from,
                'fld_product_id'        => $fitem_id,
                'fld_subproduct_id'     => $sitem_id[$i],
                'fld_qty'               => $item_qty[$i],
                'fld_weight'            => $item_weight[$i],
                'fld_rate'              => $rate[$i],
                'fld_amount'            => $amount[$i]
            );
            //print_r($data1);
            
            //if($sitem_id[$i] > 0){
             $this->db->insert('tbl_navigations_draft_details', $data1);
            //}
        }
        if($responce){
		    $res = array('responce'=>'success',"message"=>"Saved in Drafts Automatically. ","navigation_id"=>$navigation_id);
		    return $res;
 		}else{
            $res=array('responce'=>'error',"message"=>"Navigation not added in draft.Something went wrong.");
			return $res;
 		}
	}
	
	function navigation_update_draft_entry_autosave(){
		$user_id=$this->session->userdata('user_id');
		$navigation_id=$this->input->post('navigation_id',TRUE);
		$stock_location_id=$this->input->post('stock_location_id',TRUE);
		$data = array(

            'fld_received_by'          => $this->input->post('fld_received_by',TRUE),
            'fld_remarks'        => $this->input->post('fld_remarks',TRUE),
            'fld_date' => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('fld_navigation_date',TRUE)))),
            'fld_freight_MT'     => $this->input->post('fld_freight_rate',TRUE),
            'fld_freight_amount'      => $this->input->post('fld_freight_amount',TRUE),
            'fld_bowser'      => $this->input->post('fld_bowser',TRUE),
            //'fld_quantity'   => $this->input->post('fld_quantity',TRUE),
            //'fld_weight'        => $this->input->post('fld_weight',TRUE),
            'fld_total_amount'         => $this->input->post('fld_total_amount',TRUE),
            'fld_location_from'         => $this->input->post('fld_location_from',TRUE),
            'fld_location_to'         => $this->input->post('fld_location_to',TRUE),
            
        );
		 $this->db->where('fld_id',$navigation_id);
		 $responce=$this->db->update('tbl_navigations_draft', $data);
		if($responce){
		//$navigation_id = $this->db->insert_id();
		$item_id = $this->input->post('fld_item',TRUE);
		$sitem_id = $this->input->post('fld_sitem',TRUE);
        $item_qty = $this->input->post('fld_item_qty',TRUE);
        $item_weight = $this->input->post('fld_item_weight',TRUE);
        $rate = $this->input->post('fld_rate',TRUE); 
        $amount = $this->input->post('fld_amount',TRUE);
        $stock_location_id = $this->input->post('stock_location_id',TRUE);
        $fld_shipment_from  = $this->input->post('fld_shipment_from',TRUE);
         
        $this->db->where('fld_navigation_id',$navigation_id);
        $this->db->delete('tbl_navigations_draft_details');
        
         for ($i = 0, $n = count($sitem_id); $i < $n; $i++) {
           if(isset($_POST['createInt'])){
                $shipment_from = $fld_shipment_from[$i];
                $fitem_id = $item_id;
            }else{
                $shipment_from = $fld_shipment_from;
                $fitem_id = $item_id[$i];
            }
            
            $data1 = array(
                'fld_navigation_id'     => $navigation_id,
                'fld_stock_loc_id'      => $stock_location_id[$i],
                'fld_shipment_from'     => $fld_shipment_from[$i],
                'fld_product_id'        => $fitem_id,
                'fld_subproduct_id'     => $sitem_id[$i],
                'fld_qty'               => $item_qty[$i],
                'fld_weight'            => $item_weight[$i],
                'fld_rate'              => $rate[$i],
                'fld_amount'            => $amount[$i]
            );
            
            if(empty($stock_location_id[$i] )){
              $data1['fld_stock_loc_id'] = 0;
            }
            
            // var_dump($data1);
            // exit;
            
           //if($item_qty[$i] > 0){
             //$this->db->where('fld_navigation_id',$navigation_id);
             $this->db->insert('tbl_navigations_draft_details', $data1);
            //}
            
        }
		
		$res = array('responce'=>'success',"message"=>"Saved in Drafts Automatically. ");
		return $res;
		}else{
		$res = array('responce'=>'success',"message"=>"Navigation draft not updated.");
			return $res; 
		}
	}
	
	function navigation_draft_entry(){
		$user_id=$this->session->userdata('user_id');
		
		if($this->input->post('fld_location_from',TRUE) == 4){
		    $nav_type = 1;
		}else{
		    $nav_type = 2;
		}
		
		$data = array(
            'fld_userid'        => $user_id,
            'fld_stock_loc_id'        => 0,
            'fld_nav_type'  =>      $nav_type,
            'fld_received_by'          => $this->input->post('fld_received_by',TRUE),
            'fld_remarks'        => $this->input->post('fld_remarks',TRUE),
            'fld_date' => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('fld_navigation_date',TRUE)))),
            'fld_freight_MT'     => $this->input->post('fld_freight_rate',TRUE),
            'fld_freight_amount'      => $this->input->post('fld_freight_amount',TRUE),
            'fld_bowser'      => $this->input->post('fld_bowser',TRUE),
            //'fld_quantity'   => $this->input->post('fld_quantity',TRUE),
            //'fld_weight'        => $this->input->post('fld_weight',TRUE),
            'fld_total_amount'         => $this->input->post('fld_grand_total',TRUE),
            'fld_location_from'         => $this->input->post('fld_location_from',TRUE),
          //'fld_shipment_from'         => $this->input->post('fld_shipment_from',TRUE),
          //'fld_shipment_to'         => $this->input->post('fld_shipment_to',TRUE),
            'fld_location_to'         => $this->input->post('fld_location_to',TRUE),
            'fld_created_date'   =>  date("Y-m-d H:i:s")
        );
        $responce=$this->db->insert('tbl_navigations_draft', $data);

        $navigation_id = $this->db->insert_id();
		$item_id = $this->input->post('fld_item',TRUE);
		$sitem_id = $this->input->post('fld_sitem',TRUE);
        $item_qty = $this->input->post('fld_item_qty',TRUE);
        $item_weight = $this->input->post('fld_item_weight',TRUE);
        $rate = $this->input->post('fld_rate',TRUE);
        $amount = $this->input->post('fld_amount',TRUE);
        $stock_location_id = $this->input->post('stock_location_id',TRUE);
        $fld_shipment_from  = $this->input->post('fld_shipment_from',TRUE);

//         for ($i = 0, $n = count($item_id); $i < $n; $i++) {
//             $data1 = array(
//                 'fld_navigation_id'     => $navigation_id,
//                 'fld_product_id'        => $item_id[$i],
//                 'fld_subproduct_id'     => $sitem_id[$i],
//                 'fld_qty'               => $item_qty[$i],
//                 'fld_weight'            => $item_weight[$i],
//                 'fld_rate'              => $rate[$i],
//                 'fld_amount'            => $amount[$i]
//             );
            
//             if($item_qty[$i] > 0){
//              $this->db->insert('tbl_navigations_draft_details', $data1);
//              $navigation_detail_id = $this->db->insert_id();
            
//             }
//         }

         for ($i = 0, $n = count($sitem_id); $i < $n; $i++) {
            
            if(isset($_POST['createInt'])){
                $shipment_from = $fld_shipment_from[$i];
                $fitem_id = $item_id;
            }else{
                $shipment_from = $fld_shipment_from;
                $fitem_id = $item_id[$i];
            }
            $data1 = array(
                'fld_navigation_id'     => $navigation_id,
                'fld_stock_loc_id'      => $stock_location_id[$i],
                'fld_shipment_from'     => $shipment_from,
                'fld_product_id'        => $fitem_id,
                'fld_subproduct_id'     => $sitem_id[$i],
                'fld_qty'               => $item_qty[$i],
                'fld_weight'            => $item_weight[$i],
                'fld_rate'              => $rate[$i],
                'fld_amount'            => $amount[$i]
            );
            
            if($item_qty[$i] > 0){
             $this->db->insert('tbl_navigations_draft_details', $data1);
            }
        }
        
		 
 		if($responce){
 		    
		    $res = array('responce'=>'success',"message"=>"Navigation added in draft successfully.");
		    return $res;
 		}else{
            $res=array('responce'=>'error',"message"=>"Navigation not added in draft.Something went wrong.");
			return $res;
 		}
	}
	
	
	function navigation_update_entry(){
		$user_id=$this->session->userdata('user_id');
		$navigation_id=$this->input->post('navigation_id',TRUE);
		$stock_location_id=$this->input->post('stock_location_id',TRUE);
		$data = array(
            'fld_received_by'          => $this->input->post('fld_received_by',TRUE),
            'fld_remarks'        => $this->input->post('fld_remarks',TRUE),
            'fld_date' => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('fld_navigation_date',TRUE)))),
            'fld_freight_MT'     => $this->input->post('fld_freight_rate',TRUE),
            'fld_freight_amount'      => $this->input->post('fld_freight_amount',TRUE),
            'fld_bowser'      => $this->input->post('fld_bowser',TRUE),
            //'fld_quantity'   => $this->input->post('fld_quantity',TRUE),
            //'fld_weight'        => $this->input->post('fld_weight',TRUE),
            'fld_location_from'         => $this->input->post('fld_location_from',TRUE),
            'fld_location_to'         => $this->input->post('fld_location_to',TRUE),
            'fld_updated_by'       =>  $this->session->userdata('user_id'),
            'fld_updated_date'   =>  date("Y-m-d H:i:s")
        );
		 $this->db->where('fld_id',$navigation_id);
		 //$this->db->set('fld_updated_date', 'NOW()', FALSE);
		 $responce=$this->db->update('tbl_navigations', $data);
		 if($responce){
		  //$stock_loc = array(
    //             'fld_purchase_location_id'=> $this->input->post('fld_location_to',TRUE)
    //         );
		  // $this->db->where('fld_id',$stock_location_id);
    //       $this->db->update('tbl_stock_locations', $stock_loc);  
		  // $stock = array(
    //             'fld_stock_qty'        => $this->input->post('fld_item_qty',TRUE),
    //         );
			
		  // $this->db->where('fld_stock_loc_id',$stock_location_id);
    //       $this->db->update('tbl_stocks', $stock);
             
           
            
    		$v_id = $this->db->query("SELECT id FROM tbl_transections_master WHERE type='Navigation' AND type_id = '$navigation_id'")->row()->id;
	    
	    
    		
    		$this->db->query("UPDATE tbl_transections_details SET credit = '{$data['fld_freight_amount']}' WHERE v_id = '$v_id' && coa_id = '101024001'");
    		$this->db->query("UPDATE tbl_transections_details SET debit = '{$data['fld_freight_amount']}' WHERE v_id = '$v_id' && coa_id = '101003001'");
        /****************** Activity Log *****************************/
		$user_role=$this->session->userdata('user_role');
		$user_role_name=$this->session->userdata('user_role_name');
		$user_id=$this->session->userdata('user_id');
	//	$navigation_id=sprintf(' NI-%04d ', $navigation_id);
	$navigation_id='<a href="'.base_url('Navigations/detail/'.$navigation_id.'').'">NI-'.sprintf('%04d', $navigation_id).'</a>';
		$client_ip=$this->Gen->get_client_ip();
		$address=$this->Base_model->getLocation($client_ip);
        $device = $this->Base_model->systemInfo().' - '.$this->Base_model->browser();
        $date=date('Y-m-d H:i:s');
		$this->db->query("INSERT INTO tbl_activity_log SET fld_user_id = '$user_id', fld_role = '$user_role', fld_role_name = '$user_role_name', fld_action = 'UPDATE',fld_detail='$navigation_id',fld_ip_address='$client_ip', fld_address='$address', fld_device = '$device',fld_added_date='$date'");
		
		$this->session->set_userdata('success_message', "Navigation updated successfully.");
		return true;
		}else{
		$this->session->set_userdata('success_message', "Navigation not updated.");
			return false; 
		}
	}
	
	
	
	function navigation_update_draft_entry(){
		$user_id=$this->session->userdata('user_id');
		$navigation_id=$this->input->post('navigation_id',TRUE);
		$stock_location_id=$this->input->post('stock_location_id',TRUE);
		$data = array(

            'fld_received_by'          => $this->input->post('fld_received_by',TRUE),
            'fld_remarks'        => $this->input->post('fld_remarks',TRUE),
            'fld_date' => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('fld_navigation_date',TRUE)))),
            'fld_freight_MT'     => $this->input->post('fld_freight_rate',TRUE),
            'fld_freight_amount'      => $this->input->post('fld_freight_amount',TRUE),
            'fld_bowser'      => $this->input->post('fld_bowser',TRUE),
            //'fld_quantity'   => $this->input->post('fld_quantity',TRUE),
            //'fld_weight'        => $this->input->post('fld_weight',TRUE),
            'fld_total_amount'         => $this->input->post('fld_total_amount',TRUE),
            'fld_location_from'         => $this->input->post('fld_location_from',TRUE),
            'fld_location_to'         => $this->input->post('fld_location_to',TRUE),
            
        );
		 $this->db->where('fld_id',$navigation_id);
		 $responce=$this->db->update('tbl_navigations_draft', $data);
		 
		// $navigation_id = $this->db->insert_id();
		$item_id = $this->input->post('fld_item',TRUE);
		$sitem_id = $this->input->post('fld_sitem',TRUE);
        $item_qty = $this->input->post('fld_item_qty',TRUE);
        $item_weight = $this->input->post('fld_item_weight',TRUE);
        $rate = $this->input->post('fld_rate',TRUE);
        $amount = $this->input->post('fld_amount',TRUE);
        $stock_location_id = $this->input->post('stock_location_id',TRUE);
        $fld_shipment_from  = $this->input->post('fld_shipment_from',TRUE);

         for ($i = 0, $n = count($sitem_id); $i < $n; $i++) {
            if(isset($_POST['createInt'])){
                //$shipment_from = $fld_shipment_from[$i];
                $shipment_from = $fld_shipment_from;
                $fitem_id = $item_id;
            }else{
                $shipment_from = $fld_shipment_from;
                $fitem_id = $item_id[$i];
            }
            
            $data1 = array(
                'fld_navigation_id'     => $navigation_id,
                'fld_stock_loc_id'      => $stock_location_id[$i],
                'fld_shipment_from'     => $fld_shipment_from[$i],
                'fld_product_id'        => $item_id,
                'fld_subproduct_id'     => $sitem_id[$i],
                'fld_qty'               => $item_qty[$i],
                'fld_weight'            => $item_weight[$i],
                'fld_rate'              => $rate[$i],
                'fld_amount'            => $amount[$i]
            );
            
           // var_dump($data1);
           // exit;
            
           //if($item_qty[$i] > 0){
             $this->db->where('fld_navigation_id',$navigation_id);
             $this->db->update('tbl_navigations_draft_details', $data1);
            //}
        }
		 
		 
		if($responce){
		$res1 = array('responce'=>'success',"message"=>"Navigation draft updated successfully.");
		    return $res1;
		}else{
		$res1 = array('responce'=>'success',"message"=>"Navigation draft not updated.");
			return $res1; 
		}
	}
	
	function getAllNavigations(){
		$this->db->select('tbl_navigations.*,nd.fld_shipment_from as fld_shipment_from, from.fld_location as location_from,to.fld_location as location_to');
		$this->db->from('tbl_navigations');
 		$this->db->join('tbl_navigations_details as nd','nd.fld_navigation_id=tbl_navigations.fld_id');
// 		$this->db->join('tbl_category','tbl_category.fld_id=nd.fld_product_id','left');
		$this->db->join('tbl_locations as from','from.fld_id=tbl_navigations.fld_location_from','left');
		$this->db->join('tbl_locations as to','to.fld_id=tbl_navigations.fld_location_to','left');
		$this->db->where('tbl_navigations.fld_isdeleted',0);
		$nevigation=$this->db->get()->result_array();
		return $nevigation;
	}
	
	function getAllTrashNavigations(){
		$this->db->select('tbl_navigations.*,nd.fld_shipment_from as fld_shipment_from,from.fld_location as location_from,to.fld_location as location_to');
		$this->db->from('tbl_navigations');
		$this->db->join('tbl_navigations_details as nd','nd.fld_navigation_id=tbl_navigations.fld_id');
// 		$this->db->join('tbl_category','tbl_category.fld_id=tbl_navigations.fld_item_id','left');
		$this->db->join('tbl_locations as from','from.fld_id=tbl_navigations.fld_location_from','left');
		$this->db->join('tbl_locations as to','to.fld_id=tbl_navigations.fld_location_to','left');
		$this->db->where('tbl_navigations.fld_isdeleted',1);
		$nevigation=$this->db->get()->result_array();
		return $nevigation;
	}
	
	function getNavigationByID($id){
		$this->db->select('tbl_navigations.*,from.fld_location as location_from,to.fld_location as location_to');
// 		,tbl_stock_locations.fld_parent_id
		$this->db->from('tbl_navigations');
// 		$this->db->join('tbl_stock_locations','tbl_stock_locations.fld_id=tbl_navigations.fld_stock_loc_id');
		$this->db->join('tbl_locations as from','from.fld_id=tbl_navigations.fld_location_from','left');
		$this->db->join('tbl_locations as to','to.fld_id=tbl_navigations.fld_location_to','left');
		$this->db->where('tbl_navigations.fld_id',$id);
		$nevigation=$this->db->get()->row_array();
		// echo '<pre>';
		// print_r($nevigation);
		
		if($nevigation){
				$nevigation['products']=$this->getNavigationProducts($id);
				// $nav_qty=$this->getNavigateQty($nevigation['fld_parent_id'],$id);
				// //echo $this->db->last_query();
				// $orignal_qty=$this->getOrignalQty($nevigation['fld_parent_id']);
				// // echo $nav_qty;
				// // echo '<br>';
				// // echo $orignal_qty;
				// // exit;
				// $nevigation['orignal_qty']=$orignal_qty - $nav_qty;		
		}
		return $nevigation;
	}
	
	function getNavigationDraftByID($id){
		$this->db->select('tbl_navigations_draft.*,tbl_navigations_draft_details.fld_product_id,from.fld_location as location_from,to.fld_location as location_to');
// 		,tbl_stock_locations.fld_parent_id
		$this->db->from('tbl_navigations_draft');
// 		$this->db->join('tbl_stock_locations','tbl_stock_locations.fld_id=tbl_navigations.fld_stock_loc_id');
		$this->db->join('tbl_locations as from','from.fld_id=tbl_navigations_draft.fld_location_from','left');
		$this->db->join('tbl_locations as to','to.fld_id=tbl_navigations_draft.fld_location_to','left');
		$this->db->join('tbl_navigations_draft_details','tbl_navigations_draft_details.fld_navigation_id=tbl_navigations_draft.fld_id','left');
		$this->db->where('tbl_navigations_draft.fld_id',$id);
		$nevigation=$this->db->get()->row_array();
		// echo '<pre>';
		// print_r($nevigation);
		//exit;
		if($nevigation){
			$nevigation['products']=$this->getNavigationProductsdetails($id);
		}
		return $nevigation;
	}
	
	function getNavigationProductsdetails($id){
		
		$this->db->select('tbl_navigations_draft_details.*');
		$this->db->from('tbl_navigations_draft_details');
		$this->db->where('tbl_navigations_draft_details.fld_navigation_id',$id);
		return $this->db->get()->result_array();
	}
	
	function getNavigationProducts($id){
		$this->db->select('tbl_navigations_details.*,tbl_category.*');
		$this->db->from('tbl_navigations_details');
		$this->db->join('tbl_category','tbl_category.fld_id=tbl_navigations_details.fld_product_id');
		$this->db->where('tbl_navigations_details.fld_navigation_id',$id);
		return $this->db->get()->result_array();
	}
	
	function getAllNavigationsDraft(){
	    $this->db->select('tbl_navigations_draft.*,from.fld_location as location_from,to.fld_location as location_to');
		$this->db->from('tbl_navigations_draft');
// 		$this->db->join('tbl_navigations_details as nd','nd.fld_navigation_id=tbl_navigations_draft.fld_id');
// 		$this->db->join('tbl_category','tbl_category.fld_id=nd.fld_product_id','left');
		$this->db->join('tbl_locations as from','from.fld_id=tbl_navigations_draft.fld_location_from','left');
		$this->db->join('tbl_locations as to','to.fld_id=tbl_navigations_draft.fld_location_to','left');
		$this->db->where('tbl_navigations_draft.fld_userid',$this->session->userdata('user_id'));
		$this->db->where('tbl_navigations_draft.fld_isdeleted',0);
		$nevigation=$this->db->get()->result_array();
		return $nevigation;
	}
	
	function getNavigateQty($id,$nav_id=""){
		$qty=0;
		$this->db->select('sum(tbl_navigations_details.fld_qty) as qty');
		$this->db->from('tbl_navigations_details');
		//$this->db->where('tbl_navigations.fld_stock_loc_id',$id);
		$this->db->where('tbl_navigations_details.fld_stock_loc_id IN (SELECT `fld_id` FROM `tbl_stock_locations` where fld_parent_id ='.$id.')', NULL, FALSE);
		if($nav_id != ""){
		$this->db->where('tbl_navigations_details.fld_id !=',$nav_id);
		}
		$res=$this->db->get()->row_array();
		if($res['qty']){
			$qty=$res['qty'];
			return $qty;
		}else{
			return $qty;
		}
	}
	
	function getOrignalQty($id){
		$qty=0;
		$this->db->select('sum(tbl_stocks.fld_stock_qty) as qty');
		$this->db->from('tbl_stock_locations');
		$this->db->join('tbl_stocks','tbl_stocks.fld_stock_loc_id=tbl_stock_locations.fld_id');
		$this->db->where('tbl_stock_locations.fld_id',$id);
		$res=$this->db->get()->row_array();
		if($res['qty']){
			$qty=$res['qty'];
			return $qty;
		}else{
			return $qty;
		}
	}
	
	
	function delete($id){
	    $user_id = $this->session->userdata('user_id');
		$this->db->where('fld_id',$id);
		$this->db->set('fld_trash_date', 'NOW()', FALSE);
		return $this->db->update('tbl_navigations',array('fld_isdeleted'=>1, 'fld_trash_by' => $user_id));
		
//      $navigation=$this->db->delete('tbl_navigations');
// 		if($navigation){
// 			$this->db->where('fld_navigation_id',$id);
// 			return $this->db->delete('tbl_navigations_items');
// 		}
	}
	
	function restore($id){
		$this->db->where('fld_id',$id);
		return $this->db->update('tbl_navigations',array('fld_isdeleted'=>0));
	}
	
// 	function permanentdelete($id){
// 		$this->db->where('fld_id',$id);
// 		return $this->db->delete('tbl_navigations');
// 	}
	
	function permanentdelete($id){
	    $navDetails = $this->db->query("SELECT * FROM `tbl_navigations_details` where fld_navigation_id = '$id'")->result_array();
		
		foreach($navDetails as $nav){
		    $this->db->query("delete from tbl_stock_locations where fld_id = '{$nav['fld_stock_loc_id']}'");
		    $this->db->query("delete from tbl_stocks where fld_stock_loc_id = '{$nav['fld_stock_loc_id']}'");
		}
		
		$v_id = $this->db->query("SELECT id FROM tbl_transections_master WHERE type='Navigation' AND type_id = '$id'")->row()->id;
	    
	    $this->db->where('v_id',$v_id);
	    $this->db->delete('tbl_transections_details');
	    
	    $this->db->where('id',$v_id);
	    $this->db->delete('tbl_transections_master');
		
		$this->db->where('fld_id',$id);
	    $this->db->delete('tbl_navigations');
	    	
		$this->db->where('fld_navigation_id',$id);
		return $this->db->delete('tbl_navigations_details');
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
				$quantity=$this->getPurchaseNavigation($record['fld_id']);
				$products=$this->getPurchaseProducts($record['fld_id']);
				foreach($products as $pkey => $prod){
					$products[$pkey]['fld_quantity']=$prod['fld_quantity'] - $quantity;
				}
				$record['products']=$products;
			}
		}
		// echo '<pre>';
		// print_r($record);
		// exit;
		return $record;
    }
    
	function getPurchaseProducts($id){
		$this->db->select('tbl_purchase_detail.*,tbl_category.*');
		$this->db->from('tbl_purchase_detail');
		$this->db->join('tbl_category','tbl_category.fld_id=tbl_purchase_detail.fld_product_id');
		$this->db->where('tbl_purchase_detail.fld_purchase_id',$id);
		return $this->db->get()->result_array();
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
	
	function getAllPurchases() {
		
		$this->db->select('tbl_purchase.*,tbl_suppliers.*,tbl_purchase_detail.*');
		$this->db->from('tbl_purchase');
		$this->db->join('tbl_suppliers','tbl_suppliers.fld_id=tbl_purchase.fld_supplier_id');
		$this->db->join('tbl_purchase_detail','tbl_purchase_detail.fld_purchase_id=tbl_purchase.fld_id');
		$purchases=$this->db->get()->result_array();
		foreach($purchases as $key => $purch){
			$qty=$this->getPurchaseNavigation($purch['fld_id']);
			if($qty >= $purch['fld_quantity']){
				unset($purchases[$key]);
			}
		}
		return array_values($purchases);
    }
	
	/*--------------------------Navigation Functions --------------------*/
	function getAllInTransitPurch() {
		
		$this->db->select('tbl_stock_locations.*,tbl_stocks.fld_stock_qty,tbl_purchase.fld_grand_total_amount,tbl_purchase.fld_invoice_no,tbl_purchase.fld_shipment,tbl_suppliers.fld_supplier_name');
		$this->db->from('tbl_stock_locations');
		$this->db->join('tbl_purchase','tbl_purchase.fld_id=tbl_stock_locations.fld_purchase_id');
		$this->db->join('tbl_stocks','tbl_stocks.fld_stock_loc_id=tbl_stock_locations.fld_id');
		$this->db->join('tbl_suppliers','tbl_suppliers.fld_id=tbl_purchase.fld_supplier_id');
		$this->db->where('tbl_stock_locations.fld_purchase_location_id',4);
		//$this->db->where('tbl_stock_locations.fld_purch_type',1);
		$this->db->where('tbl_stocks.fld_stock_qty >',0);
		$purchases=$this->db->get()->result_array();
				
		$array_vno = array();
		foreach($purchases as $key => $purch){
			$qty=$this->getPurchaseNavigation($purch['fld_id']);
			if($qty >= $purch['fld_stock_qty']){
				unset($purchases[$key]);
			}else{
			    if(!in_array($purch['fld_purchase_id'], $array_vno)){
			        array_push($array_vno,$purch['fld_purchase_id']);
    			}else{
    			    unset($purchases[$key]);
    			}
			}
		}
		return array_values($purchases); 
    }
    
	function getInTranPurchByID($id,$stock_id=0) {
		
		$this->db->select('tbl_stock_locations.*,tbl_stocks.fld_stock_qty,tbl_suppliers.fld_supplier_name,pd.fld_product_id,pd.fld_quantity,pd.fld_unit_price,pd.fld_total_amount,tbl_category.fld_category,tbl_purchase.fld_shipment');
		$this->db->from('tbl_stock_locations');
		$this->db->join('tbl_purchase','tbl_purchase.fld_id=tbl_stock_locations.fld_purchase_id');
		$this->db->join('tbl_stocks','tbl_stocks.fld_stock_loc_id=tbl_stock_locations.fld_id');
		$this->db->join('tbl_suppliers','tbl_suppliers.fld_id=tbl_purchase.fld_supplier_id');
		$this->db->join('tbl_purchase_detail as pd','pd.fld_purchase_id=tbl_purchase.fld_id');
		$this->db->join('tbl_category','tbl_category.fld_id=pd.fld_product_id');
		$this->db->where('pd.fld_product_id=tbl_stock_locations.fld_product_id');
		$this->db->where('pd.fld_subproduct_id=tbl_stock_locations.fld_subproduct_id');
		$this->db->where('tbl_stock_locations.fld_purchase_id',$id);
		
		if($stock_id != 0){
		$this->db->where('tbl_stock_locations.fld_id',$stock_id);
		}
		//$this->db->where('tbl_stock_locations.fld_purch_type', 1);
		$purchases=$this->db->get()->result_array();
		foreach($purchases as $key => $purch){
			$qty=$this->getPurchaseNavigation($purch['fld_id']);
			$purchases[$key]['fld_stock_qty']=$purch['fld_stock_qty'] - $qty;
		}
		return array_values($purchases); 
    }
    
    function getGlShipments($location){
         $this->db->select('tbl_stock_locations.*,tbl_stocks.fld_stock_qty,gld.fld_product_id,gld.fld_quantity,gld.fld_unit_price,gld.fld_total_amount,tbl_category.fld_category,CONCAT("LPG Gain/", gld.fld_shipment) as fld_shipment');
		$this->db->from('tbl_stock_locations');
		$this->db->join('tbl_stocks','tbl_stocks.fld_stock_loc_id=tbl_stock_locations.fld_id');
		$this->db->join('tbl_gainloss_details as gld','gld.fld_id=tbl_stock_locations.fld_gl_id');
		$this->db->join('tbl_category','tbl_category.fld_id=gld.fld_product_id');
		$this->db->where('gld.fld_product_id=tbl_stock_locations.fld_product_id');
		
		$this->db->where('tbl_stock_locations.fld_purchase_location_id',$location);
		
		
		$navigation=$this->db->get()->result_array();
		if($navigation){
			foreach($navigation as $key => $nav){
			$qty=$this->getPurchaseNavigation($nav['fld_id']);
			$navigation[$key]['fld_stock_qty']=$fld_stock_qty=$navigation[$key]['fld_stock_qty'] - $qty;
				if($fld_stock_qty <= 0){
					unset($navigation[$key]);
				}
			}
		}
		return $navigation;
    }
    
	function getShipments($location, $product, $sub_cat_id) {
		
		$this->db->select('tbl_stock_locations.*,tbl_stocks.fld_stock_qty,tbl_suppliers.fld_supplier_name,pd.fld_product_id,pd.fld_quantity,pd.fld_unit_price,pd.fld_total_amount,tbl_category.fld_category,tbl_purchase.fld_shipment');
		$this->db->from('tbl_stock_locations');
		$this->db->join('tbl_purchase','tbl_purchase.fld_id=tbl_stock_locations.fld_purchase_id');
		$this->db->join('tbl_stocks','tbl_stocks.fld_stock_loc_id=tbl_stock_locations.fld_id');
		$this->db->join('tbl_suppliers','tbl_suppliers.fld_id=tbl_purchase.fld_supplier_id');
		$this->db->join('tbl_purchase_detail as pd','pd.fld_purchase_id=tbl_purchase.fld_id');
		$this->db->join('tbl_category','tbl_category.fld_id=pd.fld_product_id');
		$this->db->where('pd.fld_product_id=tbl_stock_locations.fld_product_id');
		$this->db->where('pd.fld_subproduct_id=tbl_stock_locations.fld_subproduct_id');
		
		$this->db->where('tbl_stock_locations.fld_purchase_location_id',$location);
		if($product != 0){
		    $this->db->where('pd.fld_product_id',$product);
		    if($product != 1){
		        $this->db->where('pd.fld_subproduct_id', $sub_cat_id);
		    }
		}
		
		$navigation=$this->db->get()->result_array();
// 		echo $this->db->last_query();
// 		exit;
		if($navigation){
			foreach($navigation as $key => $nav){
			$qty=$this->getPurchaseNavigation($nav['fld_id']);
			$navigation[$key]['fld_stock_qty']=$fld_stock_qty=$navigation[$key]['fld_stock_qty'] - $qty;
				if($fld_stock_qty <= 0){
					unset($navigation[$key]);
				}
			}
		}
		
// 		print_r($navigation);
// 		exit;
		
		$glship = $this->getGlShipments($location);
		return array_merge($navigation,$glship);
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
    
    function navigation_filter() {
		$conditions="";
		$filter=$this->input->post('filter');
		switch ($filter) {
		case "Voucher_Wise":
			$group_by = "tbl_navigations.fld_id";
			$select='CONCAT("NI-", tbl_navigations.fld_id) as filter_text,tbl_navigations.fld_id as filter_value';
			break;
		 case "User_Wise":
			$group_by = "tbl_navigations.fld_userid";
			$select="tbl_users.fld_username as filter_text,tbl_navigations.fld_userid as filter_value";
			break;
		case "Item_Wise":
			$group_by = "nd.fld_product_id";
			$select="cat.fld_category as filter_text,nd.fld_product_id as filter_value";
			break;
		case "Plant_Wise":
			$group_by = "tbl_navigations.fld_location_to";
			$select="tbl_locations.fld_location as filter_text,tbl_navigations.fld_location_to as filter_value";
			break;
		case "Rate_Wise":
			$group_by = "nd.fld_rate";
			$select="nd.fld_rate as filter_text,nd.fld_rate as filter_value";
			break;
		case "Date_Wise":
			$group_by = "tbl_navigations.fld_date";
			$select="DATE_FORMAT(tbl_navigations.fld_date, '%d-%m-%Y') as filter_text,tbl_navigations.fld_date as filter_value";
			break;
		case "Shipment_Wise":
			$group_by = "nd.fld_shipment_from";
			$select="nd.fld_shipment_from as filter_text,nd.fld_shipment_from as filter_value";
			break;
		case "Year_Wise":
			$group_by = "YEAR(tbl_navigations.fld_date)";
			$select="DATE_FORMAT(tbl_navigations.fld_date, '%Y') as filter_text,YEAR(tbl_navigations.fld_date) as filter_value";
			break;
		case "Month_Wise":
			$group_by = "MONTH(tbl_navigations.fld_date)";
			$select="DATE_FORMAT(tbl_navigations.fld_date, '%m-%Y') as filter_text,MONTH(tbl_navigations.fld_date) as filter_value";
			break;
		case "WeekDay_Wise":
			$group_by = "DAYNAME(tbl_navigations.fld_date)";
			$select="DAYNAME(tbl_navigations.fld_date) as filter_text,DAYNAME(tbl_navigations.fld_date) as filter_value";
			break;
		}
		$shipment=$this->input->post('shipment');
		$location=$this->input->post('location');
		$user=$this->input->post('user');
		$item=$this->input->post('item');
		
		$start=str_replace('/', '-', $this->input->post('from_date'));
		$end=str_replace('/', '-', $this->input->post('to_date'));
		$date="tbl_navigations.fld_date between '".date("Y-m-d",strtotime($start))." 00:00:00' AND '".date("Y-m-d",strtotime($end))." 23:59:00'";
		$this->db->select('tbl_navigations.fld_id,'.$select.',sum(nd.fld_amount) as total_amount,sum(nd.fld_qty) as total_quantity');
		
		$this->db->from('tbl_navigations');
		$this->db->join('tbl_navigations_details as nd','nd.fld_navigation_id=tbl_navigations.fld_id');
		$this->db->join('tbl_category as cat','cat.fld_id=nd.fld_product_id');
		$this->db->join('tbl_users','tbl_users.fld_id=tbl_navigations.fld_userid');
		$this->db->join('tbl_locations','tbl_locations.fld_id=tbl_navigations.fld_location_to');
		$this->db->where($date); 
		
		if(!empty($location)){
			$this->db->where("tbl_navigations.fld_location_to",$location);
		}
		if(!empty($user)){
			$this->db->where("tbl_navigations.fld_userid",$user);
		}
		if(!empty($shipment)){
			$this->db->where("nd.fld_shipment_from",$shipment);
		}
		if(!empty($item)){
			$this->db->where("nd.fld_product_id",$item);
		}
		$this->db->where('tbl_navigations.fld_isdeleted',0);
		$this->db->group_by($group_by);
		$navigations=$this->db->get()->result_array();
		if($navigations){
			foreach($navigations as $key => $nav){
				$navdet=$this->getNavDetail($nav['filter_value'],$group_by);
				$navigations[$key]['detail']=$navdet;
			}
		}
		return $navigations;
    }
    
	function getNavDetail($id,$group_by){
			return $this->db->query("SELECT `tbl_navigations`.*, `nd`.`fld_shipment_from`, `nd`.`fld_product_id`, `nd`.`fld_subproduct_id`, `nd`.`fld_qty`, `nd`.`fld_weight`, `nd`.`fld_rate`, `nd`.`fld_amount`, `cat`.`fld_category`
            FROM `tbl_navigations`
            JOIN `tbl_navigations_details` as `nd` ON `nd`.`fld_navigation_id`=`tbl_navigations`.`fld_id`
            JOIN `tbl_category` as `cat` ON `cat`.`fld_id`=`nd`.`fld_product_id`
            AND $group_by = '$id'")->result_array();
	}
	
	function deleteDraft($id){
		$this->db->where('fld_id',$id);
		return $this->db->delete('tbl_navigations_draft');
	}
	
	function deleteDraftdetail($id){
		$this->db->where('fld_navigation_id',$id);
		return $this->db->delete('tbl_navigations_draft_details');
	}
   
}
