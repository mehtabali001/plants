<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Stocks_model extends CI_Model {

    public function __construct() {
        parent::__construct();
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

   
	function stock_filter() {
		$frmDate = date('Y-m-d', strtotime($_POST['frmdate']));
	    $toDate = date('Y-m-d', strtotime($_POST['todate']));
	    $plant_for = $_POST['plant_for'];
	    $item_type = $_POST['item_type'];
	    $data = '';
	    $sn = 0;
        while (strtotime($frmDate) <= strtotime($toDate)) {
            if($plant_for == 'all'){
                $locations = $this->db->query("select * from tbl_locations")->result_array();
            }else{
                $locations = $this->db->query("select * from tbl_locations where fld_id = '$plant_for'")->result_array();
            }
            foreach($locations as $loc){
                $sn++;
                $date = date('Y-m-d');
                if($loc['fld_id'] == 4){
                    $todaypurchase= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_purchase as a, tbl_purchase_detail as b WHERE DATE(a.fld_purchase_date) = '$frmDate' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_purchase_id = a.fld_id")->row()->fld_quantity+0; 
                    $pastpurchase= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_purchase as a, tbl_purchase_detail as b WHERE DATE(a.fld_purchase_date) < '$frmDate' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_purchase_id = a.fld_id")->row()->fld_quantity+0;
                    $todaysale= $this->db->query("SELECT SUM(fld_qty) as fld_quantity FROM tbl_navigations WHERE DATE(fld_created_date) = '$frmDate' AND fld_location_from = '{$loc['fld_id']}'")->row()->fld_quantity+0;
                    $pastsale= $this->db->query("SELECT SUM(fld_qty) as fld_quantity FROM tbl_navigations WHERE DATE(fld_created_date) < '$frmDate' AND fld_location_from = '{$loc['fld_id']}'")->row()->fld_quantity+0;
                }else{
                    $todaypurchase= $this->db->query("SELECT SUM(fld_qty) as fld_quantity FROM tbl_navigations WHERE DATE(fld_created_date) = '$frmDate' AND fld_location_to = '{$loc['fld_id']}'")->row()->fld_quantity+0; 
                    $pastpurchase= $this->db->query("SELECT SUM(fld_qty) as fld_quantity FROM tbl_navigations WHERE DATE(fld_created_date) < '$frmDate' AND fld_location_to = '{$loc['fld_id']}'")->row()->fld_quantity+0;
                    $todaysale= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_sale as a, tbl_sale_detail as b WHERE DATE(a.fld_sale_date) = '$frmDate' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_sale_id = a.fld_id")->row()->fld_quantity+0;
                    $pastsale= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_sale as a, tbl_sale_detail as b WHERE DATE(a.fld_sale_date) < '$frmDate' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_sale_id = a.fld_id")->row()->fld_quantity+0;
                }
            
                $pastpurchasekg = $pastpurchase * 1000;
                $todaypurchasekg = $todaypurchase * 1000;
                
                $openingstock = $pastpurchasekg - $pastsale;
                $closingstock = $openingstock + $todaypurchasekg - $todaysale;
                
                $data .= '<tr>
                <td>'.$sn.'</td>
                <td>'.$frmDate.'</td>
                <td>'.$loc['fld_location'].'</td>
                <td>'.$openingstock.'</td>
                <td>'.$todaypurchase.'</td>
                <td>'.$todaysale.'</td>
                <td></td>
                <td>'.$closingstock.'</td>
                </tr>';
            }
            
            $frmDate = date ("Y-m-d", strtotime("+1 day", strtotime($frmDate)));
	    }
	    return $data;
    }
    

}
