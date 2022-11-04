<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends My_controller {
	 
	function __construct() {
        parent::__construct();
        $this->load->model('Navigations_model');
        $this->load->model('Suplier_model');
        $this->load->model('Purchase_model');
        $this->load->model('Employees_model');
        $this->load->model('Customer_model');
        $this->load->model('Users');
    }
    
    // public function dolist(){
    //     $list = $this->db->query("SELECT * FROM `tbl_purchase`")->result_array();
    //     foreach($list as $row){
    //         $vno = 'PB-'.sprintf('%04d', $row['fld_id']);
    //         $this->db->query("UPDATE tbl_purchase SET fld_voucher_no = '$vno' WHERE fld_id = '{$row['fld_id']}'");
    //     }
    // }
    
    public function getLocation(){
          $geolocation = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR']));
          echo $geolocation['geoplugin_city'];
          echo $geolocation['geoplugin_countryName'];
    }
    
    // public function csvImportStock(){
    //     $csvFile = fopen(FCPATH.'uploads/stock.csv', 'r');
        
    //     // Skip the first line
    //     fgetcsv($csvFile);
       
        
    //     while(($line = fgetcsv($csvFile)) !== FALSE){
    //             // Get row data
    //             $user_id = $this->session->userdata('user_id');
    //             $cat   = trim($line[0]);
    //             $subcat   = trim($line[1]);
    //             $suplier   = trim($line[2]);
    //             $refinry   = trim($line[3]);
    //             $vehicle   = trim($line[4]);
    //             $plant   = trim($line[5]);
    //             $qty   = trim($line[6]);
    //             $amount   = trim($line[8]);
    //             $rate   = round(($amount/$qty), 2);
    //             $shipment   = trim($line[9]);
                
    //             $check_veh = $this->db->query("SELECT * FROM tbl_transporter WHERE fld_vehicle_number = '$vehicle'");
		  //      if($check_veh->num_rows() > 0){
		  //          $trans_id = $check_veh->row()->fld_id;
		  //      }else{
		  //          $this->db->query("INSERT INTO tbl_transporter SET fld_vehicle_number = '$vehicle'");
		  //          $trans_id = $this->db->insert_id();
		  //      }
                
    //             $data = array(
    //     			'fld_userid'        => $user_id,
    //                 'fld_supplier_id'   => $suplier,
    //                 'fld_invoice_no'    => '',
    //                 'fld_voucher_no'    => 'PV-'.sprintf('%04d', $this->Purchase_model->getMaxsuplierID()['Auto_increment']),
    //                 'fld_purchase_date' => date('2021-07-01'),
    //                 'fld_shipment'      => $shipment,
    //                 'fld_location_id'   => $plant,
    //                 'fld_grand_total_amount'  => $amount,
    //                 'fld_payment_status'      => 0,
    //                 'fld_payment_type'        => 0,
    //                 'fld_bank'             =>  '',
    //                 'fld_cheque_number' =>  '',
    //                 'fld_cheque_date'   =>  '',
    //                 'fld_created_date'   =>  date("2021-07-01 00:00:00")
    //             );
    //              //$this->db->set('fld_created_date', 'NOW()', FALSE);
    //     		 $responce=$this->db->insert('tbl_purchase', $data);
    //     		  if($responce){
    //         		   $narration = '';
    //         		   $insert_id = $this->db->insert_id();
            		  
            		      
    //         			$totalquantity=$qty;
    //                     $product_quantity = $qty;
    //                     $product_rate = $rate;
    //                     $product_id = $cat;
    //                     $fld_subproduct_id = $subcat;
    //                     $total_price = $amount;
    //                     // $disc = $discount[$i];
    //                     $disc=0;
    //                     if($product_id==1){
    //                         $item = $this->db->select('*')->from('tbl_category')->where('fld_id', $product_id)->get()->row()->fld_category;
    //                     }else{
    //                         $item = $this->db->select('*')->from('tbl_subcategory')->where('fld_subcid',$fld_subproduct_id)->get()->row()->fld_subcategory;
    //                     }
    //                     $narration .= $item.', (Q)'.$product_quantity.'(Rs)'.$product_rate.', ';
    //                     $data1 = array(
    //                         'fld_purchase_id'   => $insert_id,
    //                         'fld_product_id'    => $product_id,
    //                         'fld_subproduct_id' => $fld_subproduct_id,
    //                         'fld_quantity'      => $product_quantity,
    //                         'fld_unit_price'    => $product_rate,
    //                         'fld_total_amount'  => $total_price
    //                     );
            
    //                     if ($product_quantity > 0) {
    //                         $this->db->insert('tbl_purchase_detail', $data1);
    //                         	$locinsert=array(
    //                 		    "fld_purchase_location_id"=>$plant,
    //                 		    "fld_parent_id"=>0,
    //                 		    "fld_purch_type"=>1,
    //                 		    "fld_purchase_id"=>$insert_id,
    //                 		    "fld_product_id"=>$product_id,
    //                 		    "fld_subproduct_id"=>$fld_subproduct_id,
    //                     		);
    //             		    $this->db->insert('tbl_stock_locations', $locinsert);
    //                 		$locinsert_id = $this->db->insert_id();
    //                 		$stockinsert=array(
    //                 		    "fld_stock_qty"=>$product_quantity,
    //                 		    "fld_stock_loc_id"=>$locinsert_id,
    //                 		);
    //             		    $this->db->insert('tbl_stocks', $stockinsert);
    //                     }
                    
            	 
            	
            		
    //         		$coa_id = $this->db->select('*')->from('tbl_suppliers')->where('fld_id',$data['fld_supplier_id'])->get()->row()->accounts_id;
    //         		$now = date("2021-07-01 00:00:00");
    //         		$this->db->query("INSERT into tbl_transections_master SET type = 'Purchase', type_id = '$insert_id', date = '{$data['fld_purchase_date']}', user_id = '$user_id', created_date = '$now'");
    //         		$v_id = $this->db->insert_id();
    //         		$narration = rtrim($narration, ', ');
    //                 $narration .= ' - '.$data['fld_shipment'];
            		
    //         // 		$this->db->query("INSERT INTO tbl_transections_details SET v_id = '$v_id', coa_id = '$coa_id', narration = '$narration', credit = '{$data['fld_grand_total_amount']}'");
    //         		$this->db->query("INSERT INTO tbl_transections_details SET v_id = '$v_id', coa_id = '101003001', narration = '$narration', debit = '{$data['fld_grand_total_amount']}'");
            		
    //         		}
                
                
        	
    //     }
    //     fclose($csvFile);
    // }
    
    // public function csvImportSuppliers(){
    //     $csvFile = fopen(FCPATH.'uploads/suppliers.csv', 'r');
        
    //     // Skip the first line
    //     fgetcsv($csvFile);
    //     $data = array(
    //         'type'          => 'OB',
    //         'date'          => date('2021-07-01'),
    //         'user_id'       => $this->session->userdata('user_id'),
    //         'created_date'  => date('2021-07-01 00:00:00')
    //     );
        
    //     $this->db->insert('tbl_transections_master', $data);
        
	   // $v_id = $this->db->insert_id();
        
    //     while(($line = fgetcsv($csvFile)) !== FALSE){
    //             // Get row data
    //             $user_id = $this->session->userdata('user_id');
    //             $name   = trim($line[0]);
    //             $balance   = str_replace(',', '', $line[1]);
    //             $maxSuplierID=$this->Suplier_model->getMaxsuplierID();
		  //      $scode='S-'.sprintf('%03d', $maxSuplierID['Auto_increment']);
                
    //             $data = array(
    //                 'fld_supplier_code' => $scode,
    //                 'fld_company_name'       => '',
    //                 'fld_supplier_name'      => $name,
    //                 'fld_mobile_num'        => '',
    //                 'fld_landline_num'         => '',
    //                 'fld_opening_bal'       => '0',
    //                 'fld_supplier_type'   => 1,
    //                 'fld_email' => '',
    //                 'fld_cnic'           => '',
    //                 'fld_city'          => '',
    //                 'fld_ntn'         => '',
    //                 'fld_city_area'           => '',
    //                 'fld_country'       => 'PK',
    //                 'fld_created_date'   =>  date("2021-07-01 00:00:00"),
    //                 'fld_status'        => 1
    //             );
                 
    //             $supplier=$this->db->insert('tbl_suppliers',$data);
                
                
                
    //     		if($supplier){
        		    
    //         		$supplier_id=$this->db->insert_id();
                    
                   
    //                 $account_id = 101005;
                    
                    
    //                 $getHeadCodeData = $this->db->select('*')->from('tbl_coa')->where('head_code',$account_id)->get()->row();
                
    //                 $getHeadCodeForNew = $this->db->select('*,MAX(head_code) as hc')->from('tbl_coa')->where('parent_head_name',$getHeadCodeData->head_name)->get()->row();
                    
    //                 $nid  = (int) substr($getHeadCodeForNew->hc, -3);
    //                 $n =$nid + 1;
    //                 $newlevel = $getHeadCodeData->head_level+1;
                    
    //                 if($newlevel > 1){
    //                     $n = sprintf('%03d', $n); 
    //                 }else{
    //                     $n = sprintf('%02d', $n);
    //                 }
                    
    //                 $HeadCode = $account_id . $n;
    //                 $acc_data = array(
    //                   'head_code'       =>  $HeadCode,
    //                   'head_name'       =>  $data['fld_supplier_name'].' ('.$data['fld_supplier_code'].')',
    //                   'parent_head_name'      =>  $getHeadCodeData->head_name,
    //                   'head_level'      =>  $newlevel,
    //                   'type'            => 'SUPPLIER',
    //                   'type_id'         => $supplier_id
    //                 ); 
                   
                    
    //                 $this->db->insert('tbl_coa',$acc_data);
                    
                    
                    
    //                 $this->db->query("UPDATE tbl_suppliers SET accounts_id='$HeadCode' WHERE fld_id = '$supplier_id'");
                    
                    
        		   
        		    
    //     		    if($balance > 0){
    //     		        $debit = $balance;
    //     		        $credit = 0;
    //     		    }elseif($balance < 0){
    //     		        $credit = abs($balance);
    //     		        $debit = 0;
    //     		    }else{
    //     		        $debit = 0;
    //     		        $credit = 0;
    //     		    }
            		
    //         		  $data1=array(
    //         		      'v_id'        => $v_id,
    //         		      'coa_id'      => $HeadCode,
    //         		      'narration'   => 'Opening Balance',
    //         		      'debit'       => $debit,
    //         		      'credit'      => $credit
    //         		  );
    //         		  if($debit > 0 || $credit>0){
    //         		       $this->db->insert('tbl_transections_details', $data1);
    //         		  }
               
    //     		}
        	
    //     }
    //     fclose($csvFile);
    // }
    
    // public function csvImportCustomers(){
    //     $csvFile = fopen(FCPATH.'uploads/customers.csv', 'r');
        
    //     // Skip the first line
    //     fgetcsv($csvFile);
    //     $data = array(
    //         'type'          => 'OB',
    //         'date'          => date('2021-07-01'),
    //         'user_id'       => $this->session->userdata('user_id'),
    //         'created_date'  => date('2021-07-01 00:00:00')
    //     );
        
    //     $this->db->insert('tbl_transections_master', $data);
        
	   // $v_id = $this->db->insert_id();
        
    //     while(($line = fgetcsv($csvFile)) !== FALSE){
    //             // Get row data
    //             $user_id = $this->session->userdata('user_id');
    //             $name   = trim($line[0]);
    //             $balance   = str_replace(',', '', $line[1]);
    //             $maxSuplierID=$this->Customer_model->getMaxsuplierID();
		  //      $ccode='C-'.sprintf('%04d', $maxSuplierID['Auto_increment']);
		        
                
    //             $data = array(
    //                 'fld_customer_code' => $ccode,
    //                 'fld_company_name'       => '',
    //                 'fld_customer_name'      => $name,
    //                 'fld_mobile_num'        => '',
    //                 'fld_landline_num'         => '',
    //                 'fld_opening_bal'       => '0',
    //                 'fld_customer_type'   => '1',
    //                 'fld_email' => '',
    //                 'fld_cnic'           => '',
    //                 'fld_city'          => '',
    //                 'fld_ntn'         => '',
    //                 'fld_city_area'           => '',
    //                 'fld_country'       => '',
    //                 'fld_created_date'   =>  date("2021-07-01 00:00:00"),
    //                 'fld_status'        => 1
    //             );
                 
    //             $customer=$this->db->insert('tbl_customers',$data);
    //     		if($customer){
    //     		    $customer_id=$this->db->insert_id();
                    
                   
    //                 $account_id = 101007;
                    
                    
    //                 $getHeadCodeData = $this->db->select('*')->from('tbl_coa')->where('head_code',$account_id)->get()->row();
                
    //                 $getHeadCodeForNew = $this->db->select('*,MAX(head_code) as hc')->from('tbl_coa')->where('parent_head_name',$getHeadCodeData->head_name)->get()->row();
                    
    //                 $nid  = (int) substr($getHeadCodeForNew->hc, -4);
    //                 $n =$nid + 1;
    //                 $newlevel = $getHeadCodeData->head_level+1;
                    
    //                 if($newlevel > 1){
    //                     $n = sprintf('%04d', $n); 
    //                 }else{
    //                     $n = sprintf('%02d', $n);
    //                 }
                    
    //                 $HeadCode = $account_id . $n;
    //                 $acc_data = array(
    //                   'head_code'       =>  $HeadCode,
    //                   'head_name'       =>  $data['fld_customer_name'].' ('.$data['fld_customer_code'].')',
    //                   'parent_head_name'      =>  $getHeadCodeData->head_name,
    //                   'head_level'      =>  $newlevel,
    //                   'type'            => 'CUSTOMER',
    //                   'type_id'         => $customer_id
    //                 ); 
                   
                    
    //                 $this->db->insert('tbl_coa',$acc_data);
                    
                    
                    
    //                 $this->db->query("UPDATE tbl_customers SET accounts_id='$HeadCode' WHERE fld_id = '$customer_id'");
                    
                    
        		   
        		    
    //     		    if($balance > 0){
    //     		        $debit = $balance;
    //     		        $credit = 0;
    //     		    }elseif($balance < 0){
    //     		        $credit = abs($balance);
    //     		        $debit = 0;
    //     		    }else{
    //     		        $debit = 0;
    //     		        $credit = 0;
    //     		    }
            		
    //         		  $data1=array(
    //         		      'v_id'        => $v_id,
    //         		      'coa_id'      => $HeadCode,
    //         		      'narration'   => 'Opening Balance',
    //         		      'debit'       => $debit,
    //         		      'credit'      => $credit
    //         		  );
    //         		  if($debit > 0 || $credit>0){
    //         		       $this->db->insert('tbl_transections_details', $data1);
    //         		  }
               
    //     		}
        	
    //     }
    //     fclose($csvFile);
    // }
    
    // public function csvImportBanks(){
    //     $csvFile = fopen(FCPATH.'uploads/banks.csv', 'r');
        
    //     // Skip the first line
    //     fgetcsv($csvFile);
    //     $data = array(
    //         'type'          => 'OB',
    //         'date'          => date('2021-07-01'),
    //         'user_id'       => $this->session->userdata('user_id'),
    //         'created_date'  => date('2021-07-01 00:00:00')
    //     );
        
    //     $this->db->insert('tbl_transections_master', $data);
        
	   // $v_id = $this->db->insert_id();
        
    //     while(($line = fgetcsv($csvFile)) !== FALSE){
    //             // Get row data
    //             $user_id = $this->session->userdata('user_id');
    //             $name   = trim($line[0]);
    //             $title   = trim($line[1]);
    //             $account   = trim($line[2]);
    //             $balance   = str_replace(',', '', $line[3]);
                
    //             $data = array(
    //                 'fld_userid' => $user_id,
    //                 'fld_bank'=> $name,
    //                 'fld_account_title'=> $title,
    //                 'fld_accountnumber'=> $account,
    //                 'fld_address'=> '',
    //                 'fld_created_date'   =>  date("2021-07-01 00:00:00"),
    //                 'fld_status' => 1
    //             );
                
    //             $unit=$this->db->insert('tbl_banks',$data);
    //     		if($unit){
    //     		    $bank_id=$this->db->insert_id();
                    
                   
    //                 $account_id = 101014;
                    
                    
    //                 $getHeadCodeData = $this->db->select('*')->from('tbl_coa')->where('head_code',$account_id)->get()->row();
                
    //                 $getHeadCodeForNew = $this->db->select('*,MAX(head_code) as hc')->from('tbl_coa')->where('parent_head_name',$getHeadCodeData->head_name)->get()->row();
                    
    //                 $nid  = (int) substr($getHeadCodeForNew->hc, -3);
    //                 $n =$nid + 1;
    //                 $newlevel = $getHeadCodeData->head_level+1;
                    
    //                 if($newlevel > 1){
    //                     $n = sprintf('%03d', $n); 
    //                 }else{
    //                     $n = sprintf('%02d', $n);
    //                 }
                    
    //                 $HeadCode = $account_id . $n;
    //                 $acc_data = array(
    //                   'head_code'       =>  $HeadCode,
    //                   'head_name'       =>  $data['fld_bank'].' - '.$data['fld_account_title'].' ('.$data['fld_accountnumber'].')',
    //                   'parent_head_name'      =>  $getHeadCodeData->head_name,
    //                   'head_level'      =>  $newlevel,
    //                   'type'            => 'BANK',
    //                   'type_id'         => $bank_id
    //                 ); 
                   
                    
    //                 $this->db->insert('tbl_coa',$acc_data);
                    
                    
                    
    //                 $this->db->query("UPDATE tbl_banks SET accounts_id='$HeadCode' WHERE fld_id = '$bank_id'");
                    
        		   
        		    
    //     		    if($balance > 0){
    //     		        $debit = $balance;
    //     		        $credit = 0;
    //     		    }elseif($balance < 0){
    //     		        $credit = abs($balance);
    //     		        $debit = 0;
    //     		    }else{
    //     		        $debit = 0;
    //     		        $credit = 0;
    //     		    }
            		
    //         		  $data1=array(
    //         		      'v_id'        => $v_id,
    //         		      'coa_id'      => $HeadCode,
    //         		      'narration'   => 'Opening Balance',
    //         		      'debit'       => $debit,
    //         		      'credit'      => $credit
    //         		  );
    //         		  if($debit > 0 || $credit>0){
    //         		       $this->db->insert('tbl_transections_details', $data1);
    //         		  }
               
    //     		}
        	
    //     }
    //     fclose($csvFile);
    // }
    
    // public function csvImportAccounts(){
    //     $csvFile = fopen(FCPATH.'uploads/allaccounts.csv', 'r');
        
    //     // Skip the first line
    //     fgetcsv($csvFile);
    //     $data = array(
    //                     'type'          => 'JV',
    //                     'date'          => date('2021-07-01'),
    //                     'user_id'       => $this->session->userdata('user_id'),
    //                     'created_date'  => date('2021-07-01 00:00:00')
    //                 );
                    
    //                 $this->db->insert('tbl_transections_master', $data);
                    
    //     		    $v_id = $this->db->insert_id();
        
    //     while(($line = fgetcsv($csvFile)) !== FALSE){
    //             // Get row data
    //             $user_id = $this->session->userdata('user_id');
    //             $head_name   = trim($line[0]);
    //             $balance   = str_replace(',', '', $line[1]);
    //             $head_code   = $line[3];
    //             $parent_head_code   = $line[4];
                
    //             if($head_code != ''){
                    
        		   
        		    
    //     		    if($balance > 0){
    //     		        $debit = $balance;
    //     		        $credit = 0;
    //     		    }else if($balance < 0){
    //     		        $credit = abs($balance);
    //     		        $debit = 0;
    //     		    }else{
    //     		        $debit = 0;
    //     		        $credit = 0;
    //     		    }
            		
    //         		  $data1=array(
    //         		      'v_id'        => $v_id,
    //         		      'coa_id'      => $head_code,
    //         		      'narration'   => 'Opening Balance',
    //         		      'debit'       => $debit,
    //         		      'credit'      => $credit
    //         		  );
    //         		  if($debit > 0 || $credit>0){
    //         		       $this->db->insert('tbl_transections_details', $data1);
    //         		  }
    //             }else{
                    
    //                 $account_id = $parent_head_code;
                    
                    
    //                 $getHeadCodeData = $this->db->select('*')->from('tbl_coa')->where('head_code',$account_id)->get()->row();
                
    //                 $getHeadCodeForNew = $this->db->select('*,MAX(head_code) as hc')->from('tbl_coa')->where('parent_head_name',$getHeadCodeData->head_name)->get()->row();
                    
    //                 $nid  = (int) substr($getHeadCodeForNew->hc, -3);
    //                 $n =$nid + 1;
    //                 $newlevel = $getHeadCodeData->head_level+1;
                    
    //                 if($newlevel > 1){
    //                     $n = sprintf('%03d', $n); 
    //                 }else{
    //                     $n = sprintf('%02d', $n);
    //                 }
                    
    //                 $HeadCode = $account_id . $n;
    //                 $acc_data = array(
    //                   'head_code'       =>  $HeadCode,
    //                   'head_name'       =>  $head_name,
    //                   'parent_head_name'      =>  $getHeadCodeData->head_name,
    //                   'head_level'      =>  $newlevel,
    //                   'type'            => 'OTHER',
    //                   'type_id'         => 0
    //                 ); 
                   
                    
    //                 $this->db->insert('tbl_coa',$acc_data);
                    
    //                 $type = substr($HeadCode, 0 ,1);
        		   
    //     		   if($type == 1){
    //     		       if($balance > 0){
    //         		        $debit = $balance;
    //         		        $credit = 0;
    //         		    }else if($balance < 0){
    //         		        $credit = abs($balance);
    //         		        $debit = 0;
    //         		    }else{
    //         		        $debit = 0;
    //         		        $credit = 0;
    //         		    }
    //     		   }else{
    //     		       if($balance > 0){
    //         		        $debit = 0;
    //         		        $credit = $balance;
    //         		    }else if($balance < 0){
    //         		        $credit = 0;
    //         		        $debit = abs($balance);
    //         		    }else{
    //         		        $debit = 0;
    //         		        $credit = 0;
    //         		    }
    //     		   } 
        		    
            		
    //         		  $data1=array(
    //         		      'v_id'        => $v_id,
    //         		      'coa_id'      => $HeadCode,
    //         		      'narration'   => 'Opening Balance',
    //         		      'debit'       => $debit,
    //         		      'credit'      => $credit
    //         		  );
    //         		  if($debit > 0 || $credit>0){
    //         		       $this->db->insert('tbl_transections_details', $data1);
    //         		  }
                    
    //             }
               
           
        	
    //     }
    //     fclose($csvFile);
    // }
    
//     public function csvImportEmployees(){
//         $csvFile = fopen(FCPATH.'uploads/employee1.csv', 'r');
        
//         // Skip the first line
//         fgetcsv($csvFile);
//         $data = array(
//             'type'          => 'OB',
//             'date'          => date('2021-07-01'),
//             'user_id'       => $this->session->userdata('user_id'),
//             'created_date'  => date('2021-07-01 00:00:00')
//         );
        
//         $this->db->insert('tbl_transections_master', $data);
        
// 	    $v_id = $this->db->insert_id();
        
//         while(($line = fgetcsv($csvFile)) !== FALSE){
//                 // Get row data
//                 $user_id = $this->session->userdata('user_id');
//                 $department   = trim($line[0]);
//                 $designation   = trim($line[1]);
//                 $plant   = trim($line[2]);
//                 $fullname   = trim($line[3]);
//                 $fathername   = trim($line[4]);
//                 $cnic   = trim($line[5]);
//                 $dob   = trim($line[6]);
//                 $joindate   = trim($line[7]);
//                 $address   = trim($line[8]);
//                 $phone_no   = trim($line[9]);
//                 $mobile_no   = trim($line[10]);
//                 $balance   = str_replace(',', '', $line[11]);
                
//                 if($fullname!=''){
                
//                 $maxEmployeeID=$this->Employees_model->getMaxemployeeID();
// 		        $emp_id= 'Emp-'.sprintf('%03d', $maxEmployeeID['Auto_increment']);
		        
// 		        $check_department = $this->db->query("SELECT * FROM tbl_departments WHERE department_name = '$department'");
// 		        if($check_department->num_rows() > 0){
// 		            $dep_id = $check_department->row()->id;
// 		        }else{
// 		            $this->db->query("INSERT INTO tbl_departments SET department_name = '$department'");
// 		            $dep_id = $this->db->insert_id();
// 		        }
		        
// 		        $check_designation = $this->db->query("SELECT * FROM tbl_designation WHERE designation_name = '$designation'");
// 		        if($check_designation->num_rows() > 0){
// 		            $des_id = $check_designation->row()->id;
// 		        }else{
// 		            $this->db->query("INSERT INTO tbl_designation SET designation_name = '$designation'");
// 		            $des_id = $this->db->insert_id();
// 		        }
		        
                
//                 $data = array(
//             'employee_code'     => $emp_id,
//             'is_active'         => 1,
//           //'date'              => date('Y-m-d', strtotime($this->input->post('date'))),
//             'date'              => date('2021-07-01'),
//             'employee_type'     => 1,
//             'agreement_type'    => 1,
//             'department'        => $dep_id,
//             'designation'       => $des_id,
//             'plants'            => $plant,
//             'full_name'         => $fullname,
//             'email'             => '',
//             'f_hus_name'        => $fathername,
//             'marital_status'    => 1,
//             'religion'          => 1,
//             'cnic'              => $cnic,
//             //'dob'             => date('Y-m-d', strtotime($this->input->post('dob'))),
//             'dob'               => date('Y-m-d', strtotime($dob)),
// 			'joining_date'      => date('Y-m-d', strtotime($joindate)),
// 			'address'           => $address,
// 			'phone_no'          => $phone_no,
// 			'mobile_no'         => $mobile_no,
// 			'emergency_contact' => '',
// 			'bank_name'         => '',
// 			'account_no'        => '',
// // 			'salary'            => $this->input->post('salary',TRUE),
// 			'shift_group'       => 1,
// 			//'shift_date'       => date('Y-m-d', strtotime($this->input->post('shift_date'))),
// 			'degree_level'       => '',
// 			'degree_start_date'  => '',
// 			'degree_end_date'    => '',
// 			'degree_name'       => '',
// 			'major_subjects'       => '',
// 			'institute_name'       => '',
// 			'obtained_gpa'       => '',
// 			'total_gpa'       => '',
// 			'job_held'       => '',
// 			'job_start_date'    => '',
// 			'job_end_date'    => '',
// 			'pay_draw'       => '',

// // 			'basic_pay'       => $this->input->post('basic_pay',TRUE),
// //  		'conv_allow'       => $this->input->post('conv_allow',TRUE),
// //  		'med_allow'       => $this->input->post('med_allow',TRUE),
// //  		'other'       => $this->input->post('other',TRUE),
// // 			'gross_pay'       => $this->input->post('gross_pay',TRUE),
// // 			'eobi'       => $this->input->post('eobi',TRUE),
// // 			'social_security'       => $this->input->post('social_security',TRUE),
// // 			'salary_tax'       => $this->input->post('salary_tax',TRUE),
// // 			't_deductions'       => $this->input->post('t_deductions',TRUE),
// // 			'net_payment'       => $this->input->post('net_payment',TRUE),

// 			'created_on'        => date('2021-07-01 00:00:00'),
//             'deleted'           => 0
//         );
                 
//                 $employees=$this->db->insert('tbl_employees',$data);
        
        
//         		if($employees){
        		    
//         		    $emp_id=$this->db->insert_id();
        		    
//         		    $designation = $this->db->select('*')->from('tbl_designation')->where('id',$data['designation'])->get()->row()->designation_name;
//         		    $plant = $this->db->select('*')->from('tbl_locations')->where('fld_id',$data['plants'])->get()->row()->fld_location;
                   
//                     $account_id = 101006;
                    
//                     $getHeadCodeData = $this->db->select('*')->from('tbl_coa')->where('head_code',$account_id)->get()->row();
//                     $getHeadCodeForNew = $this->db->select('*,MAX(head_code) as hc')->from('tbl_coa')->where('parent_head_name',$getHeadCodeData->head_name)->get()->row();
                    
//                     $nid  = (int) substr($getHeadCodeForNew->hc, -3);
//                     $n =$nid + 1;
//                     $newlevel = $getHeadCodeData->head_level+1;
                    
//                     if($newlevel > 1){
//                         $n = sprintf('%03d', $n); 
//                     }else{
//                         $n = sprintf('%02d', $n);
//                     }
                    
//                     $HeadCode = $account_id . $n;
//                     $acc_data = array(
//                       'head_code'       =>  $HeadCode,
//                       'head_name'       =>  $data['full_name'].', '.$designation.' at '.$plant.' ('.$data['employee_code'].')',
//                       'parent_head_name'=>  $getHeadCodeData->head_name,
//                       'head_level'      =>  $newlevel,
//                       'type'            => 'EMPLOYEE',
//                       'type_id'         => $emp_id
//                     ); 
                    
//                     $this->db->insert('tbl_coa',$acc_data);
                    
//                     $this->db->query("UPDATE tbl_employees SET accounts_id='$HeadCode' WHERE id = '$emp_id'");
                    
                    
        		   
        		    
//         		    if($balance > 0){
//         		        $debit = $balance;
//         		        $credit = 0;
//         		    }elseif($balance < 0){
//         		        $credit = abs($balance);
//         		        $debit = 0;
//         		    }else{
//         		        $debit = 0;
//         		        $credit = 0;
//         		    }
            		
//             		  $data1=array(
//             		      'v_id'        => $v_id,
//             		      'coa_id'      => $HeadCode,
//             		      'narration'   => 'Opening Balance',
//             		      'debit'       => $debit,
//             		      'credit'      => $credit
//             		  );
//             		  if($debit > 0 || $credit>0){
//             		       $this->db->insert('tbl_transections_details', $data1);
//             		  }
               
//         		}
        	
//         }
//         }
//         fclose($csvFile);
//     }
    
	public function index()
	{
	    
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		$this->title = "Dashboard";
		$data['view_scripts']=array(
			$this->Gen->get_script_url('','https://code.jquery.com/jquery-2.2.4.min.js'),
			$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js'),
			$this->Gen->get_script_url('custom_js','script.js'),
		  	$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		  	$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		  	$this->Gen->get_script_url('plugin_components','timepicker/bootstrap-material-datetimepicker.js'),
		  //	$this->Gen->get_script_url('plugin_components','apexcharts/irregular-data-series.js'),
		  //	$this->Gen->get_script_url('plugin_components','apexcharts/ohlc.js'),
		  //	$this->Gen->get_script_url('plugin_components','apexcharts/apexcharts.min.js'),
		  //	$this->Gen->get_script_url('bower_components','jquery.apexcharts.init.js'),
		    $this->Gen->get_script_url('plugin_components','chartjs/chart.min.js'),
		  	$this->Gen->get_script_url('custom_js','home.js'),
		  		$this->Gen->get_script_url('custom_js','stock.js'),
		  		$this->Gen->get_script_url('custom_js','settings.js'),
		);
		
		$data['view_css']=array(
		   $this->Gen->get_script_url('theme_css','style.css'), 
		   
		);
		$data['locations']= $this->Base_model->getAll('tbl_locations', '', "fld_id <> 8", '');
// 		$data['activity_logs']=$this->Users->user_activity_log_letest();
		$data['activity_logs']=$this->db->query('select * from tbl_activity_log ORDER BY fld_id DESC  limit 0,6')->result_array();
		$locations = $this->Base_model->getAll('tbl_locations', '', "fld_id <> 8", '');
		$location_stocks = array();
		$total_stocks_all = 0;
		$total_stock_amount = 0;
		foreach($locations as $loc){
		      $shipments=$this->Navigations_model->getShipments($loc['fld_id'], 1, 0);
		      $total_amount = 0;
		      $tqty = 0;
		      foreach($shipments as $spmnt){
		          $fright = 0;
            		if($spmnt['fld_nav_id'] != 0){
            		    $fright = $this->db->query("SELECT * FROM `tbl_navigations` WHERE fld_id = '{$spmnt['fld_nav_id']}'")->row()->fld_freight_MT;
            		}
            		$price = 0;
            		
                    if($spmnt['fld_purchase_id'] != 0){
        		        $purchasePrice = $this->db->query("SELECT a.fld_unit_price, b.fld_grand_total_amount FROM tbl_purchase_detail a, tbl_purchase b WHERE b.fld_id = a.fld_purchase_id && a.fld_product_id = '1' && b.fld_id = '{$spmnt['fld_purchase_id']}'")->row_array();
            		    $price = $purchasePrice['fld_unit_price'];
            		    $total_amount += ($purchasePrice['fld_grand_total_amount']+$fright);
            		    
        		    }
		           $totalSale = 0;
    			    $totalsale = $this->db->query("SELECT sc.fld_subcategory, sc.weight, b.fld_quantity as fld_quantity FROM tbl_sale as a, tbl_sale_detail as b, tbl_subcategory as sc WHERE b.fld_stock_location_id = '{$spmnt['fld_id']}' AND b.fld_sale_id = a.fld_id AND sc.fld_subcid = b.fld_subproduct_id")->result_array();
    			    foreach($totalsale as $tsale){
                        $totalSale += $tsale['weight']*$tsale['fld_quantity'];
                    }
                    $totalSale = round($totalSale/1000, 3);
		          $tqty += $spmnt['fld_stock_qty']-$totalSale;
		      }
		      $dataObject = array();
              $dataObject['name'] = $loc['fld_location'];
              $dataObject['stock'] = $tqty;
              $location_stocks[] = $dataObject;
              $total_stocks_all += $tqty;
              $total_stock_amount += $total_amount;
              
		}
        $data['stock_data'] = $location_stocks;
        $data['total_stocks_all'] = round($total_stocks_all,2);
        $data['total_stocks_amount'] = round($total_stock_amount,2);
        $today = date('Y-m-d');
        $data['accounts_ledger_count']  =  $this->db->query("SELECT * FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id and b.date = '$today'")->num_rows();
        $data['supplier_ledger_count']  =  $this->db->query("SELECT * FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id and b.date = '$today' AND a.coa_id LIKE '%101005%'")->num_rows();
        $data['customer_ledger_count']  =  $this->db->query("SELECT * FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id and b.date = '$today' AND a.coa_id LIKE '%101007%'")->num_rows();
        
        $purchase_count = $this->db->query("SELECT * FROM `tbl_purchase` WHERE fld_purchase_date = '$today'")->num_rows();  
        $navigation_count = $this->db->query("SELECT * FROM tbl_navigations_details as a, tbl_navigations as b WHERE b.fld_id = a.fld_navigation_id and DATE(b.fld_date) = '$today'")->num_rows(); 
        $sale_count = $this->db->query("SELECT * FROM tbl_sale_detail as a, tbl_sale as b WHERE b.fld_id = a.fld_sale_id and DATE(b.fld_sale_date) = '$today'")->num_rows(); 
        $data['item_ledger_count'] = $purchase_count+$navigation_count+$sale_count;
        
        $data['jv_count']  =  $this->db->query("SELECT * FROM tbl_transections_master WHERE type = 'JV' && date = '$today'")->num_rows();
        $data['cpv_count']  =  $this->db->query("SELECT * FROM tbl_transections_master WHERE type = 'CPV' && date = '$today'")->num_rows();
        $data['crv_count']  =  $this->db->query("SELECT * FROM tbl_transections_master WHERE type = 'CRV' && date = '$today'")->num_rows();       
        $data['chpv_count']  =  $this->db->query("SELECT * FROM tbl_transections_master WHERE type = 'CHPV' && date = '$today'")->num_rows();      
        
        
        $today = date('Y-m-d');
        $data['today_purchase'] = $this->db->query("SELECT IFNULL(SUM(a.fld_quantity), 0) as qty, IFNULL(SUM(a.fld_total_amount), 0) as amount FROM tbl_purchase_detail as a, tbl_purchase as b WHERE b.fld_id = a.fld_purchase_id && a.fld_product_id='1' && b.fld_purchase_date = '$today';")->row_array();
        $data['today_sale'] = $this->db->query("SELECT IFNULL(SUM(a.fld_weight/1000), 0) as qty, IFNULL(SUM(a.fld_total_amount), 0) as amount FROM tbl_sale_detail as a, tbl_sale as b WHERE b.fld_id = a.fld_sale_id && a.fld_product_id='1' && DATE(b.fld_sale_date) = '$today'")->row_array();
        
        $data['bank_opening'] = $this->db->query("SELECT IFNULL(SUM(b.debit), 0)-IFNULL(SUM(b.credit), 0) as balance from tbl_transections_details as b, tbl_transections_master as a where b.coa_id LIKE '101014%' AND a.date < '$today' AND a.id = b.v_id")->row()->balance;
        $data['bank_debit'] = $this->db->query("SELECT IFNULL(SUM(b.debit), 0) as balance from tbl_transections_details as b, tbl_transections_master as a where b.coa_id LIKE '101014%' AND a.date = '$today' AND a.id = b.v_id")->row()->balance;
        $data['bank_credit'] = $this->db->query("SELECT IFNULL(SUM(b.credit), 0) as balance from tbl_transections_details as b, tbl_transections_master as a where b.coa_id LIKE '101014%' AND a.date = '$today' AND a.id = b.v_id")->row()->balance;
        
        $data['bank_closing'] = $data['bank_opening']+$data['bank_debit']+$data['bank_credit'];
        
        
        $data['cash_opening'] = $this->db->query("SELECT IFNULL(SUM(b.debit), 0)-IFNULL(SUM(b.credit), 0) as balance from tbl_transections_details as b, tbl_transections_master as a where b.coa_id LIKE '101001%' AND a.date < '$today' AND a.id = b.v_id")->row()->balance;
        $data['cash_debit'] = $this->db->query("SELECT IFNULL(SUM(b.debit), 0) as balance from tbl_transections_details as b, tbl_transections_master as a where b.coa_id LIKE '101001%' AND a.date = '$today' AND a.id = b.v_id")->row()->balance;
        $data['cash_credit'] = $this->db->query("SELECT IFNULL(SUM(b.credit), 0) as balance from tbl_transections_details as b, tbl_transections_master as a where b.coa_id LIKE '101001%' AND a.date = '$today' AND a.id = b.v_id")->row()->balance;
        
        $data['cash_closing'] = $data['cash_opening']+$data['cash_debit']+$data['cash_credit'];
        
        $customer_balance = $this->db->query("SELECT IFNULL(SUM(b.debit), 0)-IFNULL(SUM(b.credit), 0) as balance from tbl_transections_details as b, tbl_transections_master as a where b.coa_id LIKE '101007%' AND a.date <= '$today' AND a.id = b.v_id")->row()->balance;
        
        if($customer_balance > 0){
            $data['ac_receivedable'] = $customer_balance;
        }else{
            $data['ac_receivedable'] = 0;
        }
        
        $data['expenses'] = $this->db->query("SELECT IFNULL(SUM(b.debit), 0) as balance from tbl_transections_details as b, tbl_transections_master as a where b.coa_id LIKE '301009%' AND a.date = '$today' AND a.id = b.v_id")->row()->balance;
        
        
        $this->load_template('','index',$data);
	}
	
	public function data_management()
	{
		
		if (!$this->auth->is_logged()) {
			$this->output->set_header("Location: " . base_url('Adminlogin'), TRUE, 302);
		}
		
        $this->title = "Data Management | ".$this->title;
		
	//  For Form Validation
		$data['view_scripts']=array(
			$this->Gen->get_script_url('','https://code.jquery.com/jquery-2.2.4.min.js'),
			$this->Gen->get_script_url('','https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js'),
			$this->Gen->get_script_url('custom_js','script.js'),
		  	$this->Gen->get_script_url('plugin_components','moment/moment.js'),
		  	$this->Gen->get_script_url('plugin_components','daterangepicker/daterangepicker.js'),
		  	$this->Gen->get_script_url('plugin_components','timepicker/bootstrap-material-datetimepicker.js'),
		  	$this->Gen->get_script_url('custom_js','data_management.js'),
		);
		$data['view_css']=array(
		   $this->Gen->get_script_url('theme_css','style.css'),
		);
        $this->load_template('','data_management',$data);
	}
}
