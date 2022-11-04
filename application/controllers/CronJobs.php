<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CronJobs extends My_controller {
	 
	function __construct() {
        parent::__construct();
        $this->load->model('Accounts_model');  
        $this->load->library('phpmailer');
    }
    
	public function index()
	{
	    $date = date('Y-m-d');
	   // $date = date('Y-m-d', strtotime('2022-07-01'));
	    $monthint = date('n', strtotime($date));
	    if($monthint > 6){
	        $year = date('Y', strtotime($date));
	    }else{
	        $year = date('Y', strtotime($date))-1;
	    }
	    $nextyear = $year+1;
	    $year_id = $year.$nextyear;
	    $year_name = $year.'-'.$nextyear;
	    $date_start = date('Y-m-d', strtotime($year.'-07-01'));
	    $date_end = date('Y-m-d', strtotime($nextyear.'-06-30'));
	    
	    $check_year = $this->db->query("SELECT * FROM app_years where year_id = '$year_id'");
	    if($check_year->num_rows()==0){
	        $this->db->query("INSERT INTO app_years set year_id = '$year_id', year_name = '$year_name', date_start = '$date_start', date_end = '$date_end'");
	    }
	}
	
	
	public function checkBlalanceSheet(){
	    $assets = $this->Accounts_model->getBalancafromHead(1, 0, "", date('Y-m-d'));
	    $libilities = $this->Accounts_model->getBalancafromHead(2, 1, "", date('Y-m-d'));
	    
        $income = $this->Accounts_model->getIncomeReport("", date('Y-m-d'));
        $libilities += $income;
        
        if(round($assets) != round($libilities)){
            $emailSent = $this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row()->balancesheet_email;
            if($emailSent == 0){
                $this->phpmailer->IsMail();
        	$this->phpmailer->From = "noreply@mktechsol.com";
			$this->phpmailer->FromName = "MKTechSol";
			$this->phpmailer->IsHTML(true);
			$this->phpmailer->AddAddress("attaullahkhan.comsats@gmail.com,afzaalsatti21@gmail.com,jawad1231@gmail.com,enquiries@mktechsol.com,alisoftware66@gmail.com"); 
			$this->phpmailer->Subject = "Z Star Balance sheet Warning";
			$this->phpmailer->Body = "Warning ⚠️<br>
Z Star Balance sheet is unequal due to last entered entries,️<br>
Assets : ".number_format($assets, 2)." (PKR)️<br>
Liabilities & Owners Equity : ".number_format($libilities, 2)." (PKR)️<br>
️<br>
Please contact IT department or concern manager.️<br>
From MK TechSol,️<br>
www.mktechsol.com";
			if($this->phpmailer->Send()){
			    	$this->db->query("UPDATE tbl_general_settings SET balancesheet_email = '1' WHERE setting_id = 1");
			}
			$this->phpmailer->ClearAddresses(); 
            }
            
		
        }else{
            $this->db->query("UPDATE tbl_general_settings SET balancesheet_email = '0' WHERE setting_id = 1");
        }
        
        
	}
}
