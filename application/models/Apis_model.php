<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Apis_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    function getMaxVoucherID() {
		$sql="SHOW TABLE STATUS LIKE 'tbl_transections_master'";
		return $this->db->query($sql)->row_array();
    }
    function purchase_filter($offset_check) {
		$conditions="";
		$filter=$this->input->post('filter');
		$offset=$this->input->post('offset');
		$limit=$this->input->post('limit');
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
		$date="date(tbl_purchase.fld_purchase_date) between '".date("Y-m-d",strtotime($start))."' AND '".date("Y-m-d",strtotime($end))."'";
		$this->db->select('tbl_purchase.fld_id,'.$select.',tbl_purchase.fld_voucher_no,sum(pd.fld_total_amount) as total_amount,sum(pd.fld_quantity) as total_quantity,pd.fld_product_id,tbl_purchase.fld_purchase_date');
		
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
		
		
		$this->db->group_by($group_by);
		
		//$this->db->order_by("fld_id",'DESC');
		
		if($offset_check == 1){
		
		$this->db->limit($limit, $offset);
		
		}
		
		$purchase=$this->db->get()->result_array();
		
		if($purchase){
			foreach($purchase as $key => $purch){
				$purchdet=$this->getPurchDetail($purch['filter_value'],$group_by, $date);
			  
				$purchase[$key]['detail']=$purchdet;
			}
		}
		return $purchase;
        
    }
	function getPurchDetail($id,$group_by,$date){
	
	return $this->db->query("SELECT `tbl_purchase`.*, `tbl_suppliers`.`fld_supplier_code`, `tbl_suppliers`.`fld_company_name`, SUBSTRING_INDEX(tbl_purchase.fld_shipment, '/', 2) as fld_supplier_name, `pd`.`fld_product_id`, `pd`.`fld_subproduct_id`, `pd`.`fld_quantity`,(`pd`.`fld_quantity` * 1000) as fld_matric_quantity, `pd`.`fld_unit_price`, `pd`.`fld_total_amount`, `cat`.`fld_category`
    FROM `tbl_purchase`
    JOIN `tbl_purchase_detail` as `pd` ON `pd`.`fld_purchase_id`=`tbl_purchase`.`fld_id`
    JOIN `tbl_category` as `cat` ON `cat`.`fld_id`=`pd`.`fld_product_id`
    JOIN `tbl_suppliers` ON `tbl_suppliers`.`fld_id`=`tbl_purchase`.`fld_supplier_id`
    AND $group_by = '$id' AND $date")->result_array();
    
    
	}
	function purchaseItemReport($condition){
	
	return $this->db->query("SELECT sum(`pd`.`fld_quantity`) as fld_quantity,(sum(`pd`.`fld_quantity`) * 1000) as fld_matric_quantity,tbl_purchase.fld_grand_total_amount, `cat`.`fld_category`,tbl_purchase.fld_purchase_date
    FROM `tbl_purchase`
    JOIN `tbl_purchase_detail` as `pd` ON `pd`.`fld_purchase_id`=`tbl_purchase`.`fld_id`
    JOIN `tbl_category` as `cat` ON `cat`.`fld_id`=`pd`.`fld_product_id` where ".$condition." group by date(tbl_purchase.fld_purchase_date) ORDER BY tbl_purchase.fld_id DESC LIMIT 10")->result_array();
    
    
	}
	function saleItemReport($condition){
	
	return $this->db->query("SELECT sum(`sd`.`fld_quantity`) as fld_quantity,(sum(`sd`.`fld_quantity`) * 1000) as fld_matric_quantity, `cat`.`fld_category`,subcat.fld_subcategory,tbl_sale.fld_grand_total_amount,date(tbl_sale.fld_sale_date) as sale_date
    FROM `tbl_sale`
    JOIN `tbl_sale_detail` as `sd` ON `sd`.`fld_sale_id`=`tbl_sale`.`fld_id`
    JOIN `tbl_category` as `cat` ON `cat`.`fld_id`=`sd`.`fld_product_id`
    JOIN `tbl_subcategory` as `subcat` ON `subcat`.`fld_subcid`=`sd`.`fld_subproduct_id`
	where ".$condition." group by date(tbl_sale.fld_sale_date) ORDER BY tbl_sale.fld_id DESC LIMIT 10")->result_array();
       
	}
	function navigation_report($condition){
	
	return $this->db->query("SELECT sum(`nd`.`fld_qty`) as fld_quantity,(sum(`nd`.`fld_qty`) * 1000) as fld_matric_quantity, `cat`.`fld_category`,tbl_navigations.fld_total_amount,date(tbl_navigations.fld_date) as navigation_date
    FROM `tbl_navigations`
    JOIN `tbl_navigations_details` as `nd` ON `nd`.`fld_navigation_id`=`tbl_navigations`.`fld_id`
    JOIN `tbl_category` as `cat` ON `cat`.`fld_id`=`nd`.`fld_product_id`
	where ".$condition." group by date(tbl_navigations.fld_date) ORDER BY tbl_navigations.fld_id DESC LIMIT 10")->result_array();
       
	}
	function navigation_filter($offset_check) {
		$conditions="";
		$filter=$this->input->post('filter');
		$offset=$this->input->post('offset');
		$limit=$this->input->post('limit');
		$group_by = "tbl_navigations.fld_id";
		$select='CONCAT("NI-", tbl_navigations.fld_id) as filter_text,tbl_navigations.fld_id as filter_value';
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
		$this->db->select('tbl_navigations.fld_id,'.$select.',sum(nd.fld_amount) as total_amount,sum(nd.fld_qty) as total_quantity,tbl_navigations.fld_date');
		
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
		
	//	$this->db->order_by("fld_id",'DESC');
		
		if($offset_check == 1){
		    
		    $this->db->limit($limit, $offset);
		    
		}
		$navigations=$this->db->get()->result_array();
		
		if($navigations){
			foreach($navigations as $key => $nav){
				$navdet=$this->getNavDetail($nav['filter_value'],$group_by,$date);
				$navigations[$key]['detail']=$navdet;
			}
		}
		return $navigations;
    }
	function getNavDetail($id,$group_by,$date){
			return $this->db->query("SELECT `tbl_navigations`.*, `nd`.`fld_shipment_from`, `nd`.`fld_product_id`, `nd`.`fld_subproduct_id`, `nd`.`fld_qty`, `nd`.`fld_weight`, `nd`.`fld_rate`, `nd`.`fld_amount`, `cat`.`fld_category`,loc.fld_location as location_name
            FROM `tbl_navigations`
            JOIN `tbl_navigations_details` as `nd` ON `nd`.`fld_navigation_id`=`tbl_navigations`.`fld_id`
            JOIN `tbl_category` as `cat` ON `cat`.`fld_id`=`nd`.`fld_product_id`
            JOIN `tbl_locations` as `loc` ON `loc`.`fld_id`=tbl_navigations.fld_location_from
            AND $group_by = '$id' AND $date")->result_array();
	}
	function sale_filter() {
		$conditions="";
		$filter=$this->input->post('filter');
		$offset=$this->input->post('offset');
		$limit=$this->input->post('limit');
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
		$this->db->select('tbl_sale.fld_id,'.$select.',tbl_sale.fld_voucher_no,sum(sd.fld_total_amount) as total_amount,sum(sd.fld_quantity) as total_quantity,tbl_sale.fld_sale_date');
		
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
		
		//$this->db->order_by("fld_id",'DESC');
		
		$this->db->limit($limit, $offset);
		
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
		$this->db->select('tbl_sale.*,tbl_customers.fld_customer_code,tbl_customers.fld_company_name,tbl_customers.fld_customer_name,sd.fld_product_id,sd.fld_subproduct_id,sd.fld_quantity,sd.fld_discount,sd.fld_weight,sd.fld_unit_price,sd.fld_total_amount,cat.fld_category,sd.fld_purchase_amount,scat.fld_subcategory,sd.fld_shipment');
		
		$this->db->from('tbl_sale');
		
		$this->db->join('tbl_sale_detail as sd','sd.fld_sale_id=tbl_sale.fld_id');
		
		$this->db->join('tbl_category as cat','cat.fld_id=sd.fld_product_id');
		
		$this->db->join('tbl_subcategory as scat','scat.fld_subcid =sd.fld_subproduct_id');
		
		$this->db->join('tbl_customers','tbl_customers.fld_id=tbl_sale.fld_customer_id');
		
		$this->db->where($date);
		
		$this->db->where('tbl_sale.fld_isdeleted',0);
		
		$this->db->where($group_by,$id);
		
		return $this->db->get()->result_array();
	}
    function gain_loss_filter() {
		$conditions="";
		$filter=$this->input->post('filter');
		$offset=$this->input->post('offset');
		$limit=$this->input->post('limit');
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
		
		$this->db->limit($limit, $offset);
		
		$gain_loss=$this->db->get()->result_array();
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
		
		
		//$this->db->where($date);
		
		$this->db->where('tbl_gain_loss.fld_isdeleted',0);
		
		$this->db->where($group_by,$id);
		
		return $this->db->get()->result_array();
	}
	function employee_filter() {
		$conditions="";
		$select="";
		$group_by="";
		$filter=$this->input->post('filter');
		$offset=$this->input->post('offset');
		$limit=$this->input->post('limit');
		switch ($filter) {
    		case "Plant_Wise":
    			$group_by = "tbl_employees.plants";
    			$select="tbl_locations.fld_location as filter_text,tbl_employees.plants as filter_value";
    			break;
    		case "employee_code_wise":
    			$group_by = "tbl_employees.employee_code";
    			$select="tbl_employees.employee_code as filter_text,tbl_employees.employee_code as filter_value";
    			break;
    			case "employee_name_wise":
    			$group_by = "tbl_employees.full_name";
    			$select="tbl_employees.full_name as filter_text,tbl_employees.full_name as filter_value";
    			break;
    		case "designation_Wise":
    			$group_by = "tbl_employees.designation";
    			$select="tbl_designation.designation_name as filter_text,tbl_employees.designation as filter_value";
    			break;
    		case "department_Wise":
            	$group_by = "tbl_employees.department";
            	$select="tbl_departments.department_name as filter_text,tbl_employees.department as filter_value";
            	break;
		}
		
		
		
		$this->db->select('tbl_employees.id,'.$select.'');
		
		$this->db->from('tbl_employees');
		
		$this->db->join('tbl_departments','tbl_departments.id=tbl_employees.department');
		
		$this->db->join('tbl_designation','tbl_designation.id=tbl_employees.designation');
		
		$this->db->join('tbl_locations','tbl_locations.fld_id=tbl_employees.plants');
		
		$emp_code=$this->input->post('emp_code');
		$emp_name=$this->input->post('emp_name');
		$plants=$this->input->post('plants');
		$designation=$this->input->post('designation');
		$department=$this->input->post('department');
		
		if(!empty($plants)){
			$this->db->where("tbl_employees.plants",$plants);
		}
		if(!empty($emp_code)){
			$this->db->where("tbl_employees.employee_code",$emp_code);
		}
		if(!empty($emp_name)){
			$this->db->where("tbl_employees.full_name",$emp_name);
		}
		if(!empty($designation)){
			$this->db->where("tbl_employees.designation",$designation);
		}
		if(!empty($department)){
			$this->db->where("tbl_employees.department",$department);
		}
		
		
		
		$this->db->group_by($group_by);
		
		$this->db->limit($limit, $offset);
		
		$employees=$this->db->get()->result_array();
		
		if($employees){
			foreach($employees as $key => $Emp){
				$employeesdet=$this->getEmployeeDetail($Emp['filter_value'], $group_by);
				$employees[$key]['detail']=$employeesdet;
			}
		}
		return $employees;
        
    }
	function getEmployeeDetail($id,$group_by){
        
    	$this->db->select('tbl_employees.*, tbl_locations.fld_location, tbl_designation.designation_name, tbl_departments.department_name');
		
		$this->db->from('tbl_employees');
		
		$this->db->join('tbl_departments','tbl_departments.id=tbl_employees.department');
		
		$this->db->join('tbl_designation','tbl_designation.id=tbl_employees.designation');
		
		$this->db->join('tbl_locations','tbl_locations.fld_id=tbl_employees.plants');
		
		$emp_code=$this->input->post('emp_code');
		$emp_name=$this->input->post('emp_name');
		$plants=$this->input->post('plants');
		$designation=$this->input->post('designation');
		$department=$this->input->post('department');
		
		if(!empty($plants)){
			$this->db->where("tbl_employees.plants",$plants);
		}
		if(!empty($emp_code)){
			$this->db->where("tbl_employees.employee_code",$emp_code);
		}
		if(!empty($emp_name)){
			$this->db->where("tbl_employees.full_name",$emp_name);
		}
		if(!empty($designation)){
			$this->db->where("tbl_employees.designation",$designation);
		}
		if(!empty($department)){
			$this->db->where("tbl_employees.department",$department);
		}
		
        $this->db->where($group_by,$id);
        return $this->db->get()->result_array();
    }
	function expense_filter() {
		$conditions="";
		$filter=$this->input->post('filter');
		$offset=$this->input->post('offset');
		$limit=$this->input->post('limit');
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
		$this->db->limit($limit, $offset);
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
	
	return $this->db->query("SELECT `tbl_expenses`.*, `ed`.`stationary`, `ed`.`quantity`, `ed`.`expense_type`, `ed`.`expense_value`, `ed`.`unit`, `ed`.`sub_total`, `ed`.`unit_price`, ed.remarks, `st`.`name` as st_name, tbl_locations.fld_location
    FROM `tbl_expenses`
    JOIN `tbl_expense_detail` as `ed` ON `ed`.`fld_expense_id`=`tbl_expenses`.`id`
    JOIN `tbl_stationary` as `st` ON `st`.`id`=`ed`.`stationary`
    JOIN  tbl_locations ON tbl_locations.fld_id=tbl_expenses.plant_for
    AND $group_by = '$id'")->result_array();

	}
	function profitandloss_filter() {
		$conditions="";
		$filter=$this->input->post('filter');
		$offset=$this->input->post('offset');
		$limit=$this->input->post('limit');
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
		
		$this->db->limit($limit, $offset);
		
		$sales=$this->db->get()->result_array();
		if($sales){
			foreach($sales as $key => $sel){
				$salesdet=$this->getSaleDetail($sel['filter_value'],$group_by);
				$sales[$key]['detail']=$salesdet;
			}
		}
		return $sales;
		
		
        
    }
	function getAllProducts() {
		
		$this->db->select('tbl_category.*,tbl_units.fld_unit');
		
		$this->db->from('tbl_category');
		
		$this->db->join('tbl_units','tbl_units.fld_id=tbl_category.fld_unit','left');
		
		return $this->db->get()->result_array();
        
    }
    function balancesheetdfs($HeadName,$HeadCode,$oResult,$visit,$d, $credit, $start_date, $end_date)
    {
		//echo '<pre>';
		//print_r($HeadName.'=='.$HeadCode.'=='.$d.'=='. $credit.'=='. $start_date.'=='. $end_date);
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
        $balance=abs($balance);
        $balance = number_format($balance, 2);
        $HeadNameO = $HeadName;
        $HeadName=$this->limit_text($HeadName,35);
		$balance_sheet=array();
		
        if($d==0){ 
		$balance_sheet['head_name']="L".($d)." - ".$HeadName;
		$balance_sheet['balance']=$balance;
		}else if($d==1){ 
		$balance_sheet['head_name']="L".($d)." - ".$HeadName;
		$balance_sheet['balance']=$balance;
		}else{
		$balance_sheet['head_name']="L".($d)." - ".$HeadName;
		$balance_sheet['balance']=$balance;
		}
        
		return $balance_sheet;
		
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
	function get_balancesheetdfs($HeadName,$HeadCode,$oResult,$visit,$d, $credit, $start_date, $end_date){
		
		
		$HeadNameO = $HeadName;
        $HeadName=$this->limit_text($HeadName,35);
		$p=0;
		$assets[]=$this->balancesheetdfs($HeadName,$HeadCode,$oResult,$visit,$d, $credit, $start_date, $end_date);
		$respoce=array();
        for($i=0;$i< count($oResult);$i++)
        {
		
            if (!$visit[$i])
            {
                if ($HeadNameO==$oResult[$i]['parent_head_name'])
                {
					if($d < 1){
					
                    $visit[$i]=true;
                    if($p==0)
                    $p++;
                   $result=$this->balancesheetdfs($oResult[$i]['head_name'],$oResult[$i]['head_code'],$oResult,$visit,$d+1, $credit, $start_date, $end_date);
				   $respoce[$i]=$result;
				  
					}
                }
            }
        }
       
		$respoce=array_merge($assets,$respoce);
		
		return $respoce;
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
	function limit_text($text, $limit) {
        $length = strlen($text);
        if($length > $limit){
           $text= substr($text, 0, $limit).'...';
        }
        
        return $text;
    }
    function check_login($tableName, $condition) {
        $response = array();
        $this->db->select($tableName . '.*');
        $this->db->from($tableName);
        $this->db->where($condition);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $response = $query->row_array();
        }
        return $response;
    }
    function insert($tableName, $data, $toString = '') {
        foreach ($data as $key => $val) {
            $this->db->set($key, $val);
        }

        $this->db->insert($tableName);

        if ($toString) {
            $this->getQuery();
        }

        return $this->db->insert_id();
    }
    function getAll($tableName, $columnName = '', $condition = '', $toString = '') {
		$response = array();
        if (!$columnName) {
            $this->db->select('*');
        } else {
            $this->db->select($columnName);
        }

        $this->db->from($tableName);

        if ($condition) {
            $this->db->where($condition);
        }

        $query = $this->db->get();
		if ($query->num_rows() > 0) {
			$response = $query->result_array();
		}
        if ($toString) {
            $this->getQuery();
        }

        return $response;
    }
    function update($tableName, $data, $condition, $excludedField = '', $toString = '') {
        foreach ($data as $key => $val) {
            if ($key != $excludedField) {
                $this->db->set($key, $val);
            }
        }

        $this->db->where($condition);

        $this->db->update($tableName);

        if ($toString) {
            $this->getQuery();
        }
    }
}
