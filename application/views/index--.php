<style>
.iconof {
    position: absolute;
    top: -8px;
    right: -8px; 
}
.icon-lg {
    height: 22px;
    width: 22px;
}
.chart-report-card .report-main-icon, .report-card .report-main-icon {
    width: 35px;
    height: 35px;
}
.font-11{
    font-size:11px;
}
.card-body {
    padding: 1rem;
}
.text-truncate {
    white-space: break-spaces;
}
.new-boxe{
    border-left: 1px solid #ffffff;
}
.boxe{
    text-align:center;
}

.text-mute {
    color: #ffffff !important;
    font-size: 13px;
}
.btc-price h3 {
    font-size: 18px;
    color: #ffffff;
    font-weight: 600;
}
.bold{
    font-weight:bold;
}
.tablex td{
    border-color: #000000;
    color:#000;
}
.tablex th{
    border-color: #000000;
    color:#000;
}
.tablex thead th {
    border-bottom: 1px solid #000 !important;
}
.log th{
    border-color: #fff;
    color:#fff;
}
.log thead th {
    border-bottom: 1px solid #fff !important;
}
.log td{
    padding: 0.25rem;
    color: #fff !important;
    border-color: #fff;
}
.chart-report-card .report-main-icon, .report-card .report-main-icon {
    width: 20px;
    height: 20px;
}
body.enlarge-menu .page-wrapper {
    min-height: auto !important;
}
/*modal*/
#modalOverlay {
			position: fixed;
			top: 0;
			left: 0;
			background: rgba(0, 0, 0, 0.5);
			z-index: 99999;
			height: 100%;
			width: 100%;
	}
.modalPopup {
			position: absolute;
			top: 45%;
			left: 50%;
			transform: translate(-50%, -50%);
			background: #fff;
			width: 50%;
			padding: 0 0 30px;
			-webkit-box-shadow: 0 2px 10px 3px rgba(0,0,0,.2);
			-moz-box-shadow: 0 2px 10px 3px rgba(0,0,0,.2);
			box-shadow: 0 2px 10px 3px rgba(0,0,0,.2);
	}
.modalContent {padding: 0 2em;}
.headerBar {
		width: 100%;
		background: #355e67 ;
		margin: 0;
	  text-align: center;
	}
.headerBar img {
		margin: 1em .7em;
	}
h1 {
  margin-bottom: .2em;
  font-size: 26px;
  text-transform: capitalize;
}
p {margin: .75em 0 1.5em;}
.buttonStyle {
		border: transparent;
		border-radius: 0;
		background: #6d6d6d;
		color: #eee !important;
		cursor: pointer;
		font-weight: bold;
		font-size: 14px;
		text-transform: uppercase;
		padding: 6px 25px;
		text-decoration: none;
		background: -moz-linear-gradient(top, #6d6d6d 0%, #1e1e1e 100%);
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#6d6d6d), color-stop(100%,#1e1e1e));
		background: -webkit-linear-gradient(top, #6d6d6d 0%,#1e1e1e 100%);
		background: -o-linear-gradient(top, #6d6d6d 0%,#1e1e1e 100%);
		background: -ms-linear-gradient(top, #6d6d6d 0%,#1e1e1e 100%);
		background: linear-gradient(to bottom, #6d6d6d 0%,#1e1e1e 100%);
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#6d6d6d', endColorstr='#1e1e1e',GradientType=0 );
	/*	-webkit-box-shadow: 0 2px 4px 0 #999;
		box-shadow: 0 2px 4px 0 #999; */
		-webkit-transition: all 1s ease;
		-moz-transition: all 1s ease;
		-ms-transition: all 1s ease;
		-o-transition: all 1s ease;
		transition: all 1s ease;
	}
	.buttonStyle:hover {
		background: #1e1e1e;
		color: #fff;
		background: -moz-linear-gradient(top, #1e1e1e 0%, #6d6d6d 100%, #6d6d6d 100%);
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#1e1e1e), color-stop(100%,#6d6d6d), color-stop(100%,#6d6d6d));
		background: -webkit-linear-gradient(top, #1e1e1e 0%,#6d6d6d 100%,#6d6d6d 100%);
		background: -o-linear-gradient(top, #1e1e1e 0%,#6d6d6d 100%,#6d6d6d 100%);
		background: -ms-linear-gradient(top, #1e1e1e 0%,#6d6d6d 100%,#6d6d6d 100%);
		background: linear-gradient(to bottom, #1e1e1e 0%,#6d6d6d 100%,#6d6d6d 100%);
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#1e1e1e', endColorstr='#6d6d6d',GradientType=0 );
	}
.returnToProfile {text-align: center; margin:3em;}
.returnToProfile a, .returnToProfile a:visited {color: #ddd;}
.returnToProfile a:hover {color: #fff;}
/*modal end*/
.new_box{
    padding: 0.4rem;
    height: 50px;
}
@media only screen and (max-width: 600px) {
  .logggin {
    display:none;
  }
}
.font-11{
    font-size:10px;
}
</style>
<? $role_permissions  = explode(",",$this->session->userdata('permissions')); ?>
<div id="modalOverlay"  data-keyboard="true">
	<div class="modalPopup"  data-keyboard="true">
	    <? $settings=$this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row_array();?>
		<div class="headerBar">
			<img src="https://btk.mktechsol.com//assets/uploads/logo/1639641198_Mk-TechSol-logo-123.png" alt="Logo" style="height:90px;">
		</div>
		<div class="modalContent">
				<h1>The system is currently under development for Production release, current release is Beta.</h1>
				 <p>If you face any issue while using current version- Please contact MK TechSol.</p>
				 <button class="buttonStyle" id="button">Close</button>
		</div>
	</div>
</div>
<div class="container-fluid">
                    <!-- Page-Title -->
                    <div class="row">
                        <div class="col-sm-12">
              <?php $error_message = $this->session->userdata('error_message');
				if (isset($error_message)) {
					?>
					<div class="alert alert-danger">
						
						<?php echo $error_message ?>                    
					</div>
					<?php
					$this->session->unset_userdata('error_message');
				}?>
				<?php $success_message = $this->session->userdata('success_message');
				if (isset($success_message)) {
					?>
					<div class="alert alert-success">
						
						<?php echo $success_message ?>                    
					</div>
					<?php
					$this->session->unset_userdata('success_message');
				}?>
                       <!--</div><!--end page-title-box-->
                        </div><!--end col-->
                        
                    </div>
                    <!-- end page title end breadcrumb -->
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-md-2">
                                <h4 class="form-section"><i class="icon-eye6"></i>Today's Summary</h4>
                            </div>
                            <div class="col-md-6" style="text-align:center;">
                                <?php $user_id = $this->session->userdata('user_id');
                                $user_data=$this->db->query("select * from tbl_users where fld_id = '$user_id' ")->row();
                                $user_log=$this->db->query("select * from tbl_activity_log where fld_user_id = '$user_id' ORDER BY `fld_added_date` DESC ")->row();
                     $emp_username= $user_data->fld_username;?>
                                <p class="logggin" style="margin:0 !important;font-family: monospace;text-align: center;font-size:.7rem;position: fixed;z-index: 100000;justify-content: center;left: 36%;top: 5px;margin: auto;">Welcome back! <?=$emp_username;?><br>
Last Login Details : <?=$user_log->fld_ip_address;?>, <?=$user_log->fld_address;?>.<br> <?= date('d-m-Y H:i',strtotime($user_log->fld_added_date));?> </p>
                            </div>
                            <div class="col-md-4 col-sm-6" style="text-align:center;">
                                <p style="margin-top: 2%;">  <?=$settings['system_version'];?> </span>
                            </div>
                        </div>
						<hr >
					</div>
                     
                    <div class="row">
                        <div class="col-lg-9">
                            <? if(!empty($role_permissions) && in_array(257,$role_permissions)) { ?>
                            <div class="card" style="border: 1px solid #6abdcf;background:#6abdcf;margin-bottom: 13px;box-shadow: 0 10px 16px 0 #30635c, 0 6px 20px 0 rgb(255 255 255) !important;">
                                <div class="card-body btc-price">
                                    <div class="row">
                                        <div class="col-md-2 boxe" style="margin-top:2%;">
                                            <span  class="text-mute">Banks (PKR)</span>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="row">
                                                <div class="col-lg-3 new-boxe boxe">
                                                    <span class="text-mute">Opening Balance</span>
                                                    <h3 class="mt-0"><?php echo $bank_opening; ?></h3>
                                                </div>
                                                <div class="col-lg-3 new-boxe boxe">
                                                    <span class="text-mute">Debit</span>
                                                    <h3 class="mt-0"><?php echo $bank_debit; ?></h3>
                                                </div>
                                                <div class="col-lg-3 new-boxe boxe">
                                                    <span class="text-mute">Credit</span>
                                                    <h3 class="mt-0"><?php echo $bank_credit; ?></h3>
                                                </div>
                                                <div class="col-lg-3 new-boxe boxe">
                                                    <span class="text-mute">Closing Balance</span>
                                                    <h3 class="mt-0"><?php echo $bank_closing; ?></h3>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    </div>
                                    </div>
                                    <?}?>
                                    <? if(!empty($role_permissions) && in_array(258,$role_permissions)) { ?>
                                    <div class="card" style="border: 1px solid #4893bb;background:#4893bb;margin-bottom: 13px;box-shadow: 0 10px 16px 0 #30635c, 0 6px 20px 0 rgb(255 255 255) !important;">
                                        <div class="card-body btc-price">
                                            <div class="row">
                                                <div class="col-md-2 boxe" style="margin-top:2%;">
                                                    <span class="text-mute">Cash (PKR)</span>
                                                </div>
                                                <div class="col-md-10">
                                                    <div class="row">
                                                        <div class="col-lg-3 new-boxe  boxe">
                                                            <span class="text-mute">Opening Balance</span>
                                                            <h3 class="mt-0"><?php echo $cash_opening; ?></h3>
                                                        </div>
                                                        <div class="col-lg-3 new-boxe boxe">
                                                            <span class="text-mute">Debit</span>
                                                            <h3 class="mt-0"><?php echo $cash_debit; ?></h3>
                                                        </div>
                                                        <div class="col-lg-3 new-boxe boxe">
                                                            <span class="text-mute">Credit</span>
                                                            <h3 class="mt-0"><?php echo $cash_credit; ?></h3>
                                                        </div>
                                                        <div class="col-lg-3 new-boxe boxe">
                                                            <span class="text-mute">Closing Balance</span>
                                                            <h3 class="mt-0"><?php echo $cash_closing; ?></h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?}?>
                                    <? if(!empty($role_permissions) && in_array(259,$role_permissions)) { ?>
                                    <div class="card" style="border: 1px solid #929cc5;background:#929cc5;margin-bottom: 13px;box-shadow: 0 10px 16px 0 #30635c, 0 6px 20px 0 rgb(255 255 255) !important;">
                                <div class="card-body btc-price">
                                    <div class="row">
                                        <div class="col-lg-6 boxe">
                                            <span class="text-mute">A/C Receiveable</span>
                                            <h3 class="mt-0"><?php echo $ac_receivedable; ?></h3>
                                        </div>
                                        <div class="col-lg-6 new-boxe boxe">
                                            <span class="text-mute">Total Expenses</span>
                                            <h3 class="mt-0"><?php echo $expenses; ?></h3>
                                        </div>
                                    </div>
                                    </div>
                                    </div>
                                    <?}?>
                                </div>
                        <div class="col-lg-3">
                                    <? if(!empty($role_permissions) && in_array(260,$role_permissions)) { ?>
                            <div class="card" style="border: 1px solid #679ea5;background:#679ea5;box-shadow: 0 10px 16px 0 #30635c, 0 6px 20px 0 rgb(255 255 255) !important;">                                
                                <div class="card-body">
                                    <h4 class=" mt-0" style="color:#fff;">Stocks</h4>
                                    <div class="coin-market-nav">
                                        <div class="tab-content slimscroll coin-market-h" id="pills-tabContent">
                                            <div class="tab-pane fade active show" id="pills-credit-card">
                                                        <div class="row" style="width:100%;">
                                                            <div class="col-md-5 text-mute" style="margin-top:3%;border-right:1px solid;">Purchase</div>
                                                            <div class="col-md-7 text-mute"><?php echo $today_purchase['qty']; ?><span class="bold"> MT</span> <br> <?php echo $today_purchase['amount']; ?> <span class="bold">PKR</span></div>
                                                        </div><br>
                                                        <div class="row" style="width:100%;">
                                                            <div class="col-md-5 text-mute" style="margin-top:3%;border-right:1px solid;">Sale</div>
                                                            <div class="col-md-7 text-mute"><?php echo $today_sale['qty']; ?> <span class="bold"> MT</span><br> <?php echo $today_sale['amount']; ?>  <span class="bold">PKR</span></div>
                                                        </div><br>
                                                        <div class="row" style="width:100%;">
                                                            <div class="col-md-5 text-mute" style="margin-top:3%;border-right:1px solid;">Closing</div>
                                                            <div class="col-md-7 text-mute"><?php echo $total_stocks_all; ?> <span class="bold"> MT</span><br> <?php echo $total_stocks_amount; ?>  <span class="bold">PKR</span></div>
                                                        </div><br>
                                                    <div class="more" style="text-align:center;">
                                                        <a href="<?= base_url('Stocks/stocks_report');?>"style="color:#fff;"><u>View More</u></a>
                                                    </div>
                                            </div><!--end tab-pane-->
                                        </div><!--end tab-content--> 
                                    </div> <!--end balence-nav-->                                       
                                </div><!--end card-body-->
                            </div><!--end card-->
                            <?}?>
                        </div><!--end col-->
                    </div><!--end row-->
                    <div class="row">
                                    <? if(!empty($role_permissions) && in_array(261,$role_permissions)) { ?>
                        <div class="col-lg-6">
                            <div class="card" style="background: #a1f39a;border: 1px solid #a1f39a;box-shadow: 0 10px 16px 0 #30635c, 0 6px 20px 0 rgb(255 255 255) !important;">
                                <div class="card-body">
                                    <h4 class="header-title mt-0 mb-3">LPG Stocks</h4>
                                    <div class="table-responsive browser_users">
                                        <table class="table mb-0 tablex">
                                            <thead class="">
                                            	<tr>
                                            		<!--<th>#</th>-->
                                            		<th>Plant Name</th>
                                            		<th>Qty</th>
                                            		<th>Rate/MT (Avg)</th>
                                            		<th>Amount</th>
                                            	</tr>
                                        	</thead>
                                        	<tbody>
                                                <?
                                                $total_qty = 0;
                                                
                                                $total_purchase_amount = 0;
                                                  if($locations){
                                                  $i=1;
                                                  foreach($locations as $loc){
                                                        $shipments = $this->Navigations_model->getShipments($loc['fld_id'], 1, 0);
                                                        $prices = array();
                                                        $total_amount = 0;
                                                        $tq = 0;
                                                        foreach($shipments as $ship){
                                                            $fright = 0;
                                                    		if($ship['fld_nav_id'] != 0){
                                                    		    $fright = $this->db->query("SELECT * FROM `tbl_navigations` WHERE fld_id = '{$ship['fld_nav_id']}'")->row()->fld_freight_MT;
                                                    		}
                                                    		$price = 0;
                                                    		
                                                            if($ship['fld_purchase_id'] != 0){
                                                		        $purchasePrice = $this->db->query("SELECT a.fld_unit_price, b.fld_grand_total_amount FROM tbl_purchase_detail a, tbl_purchase b WHERE b.fld_id = a.fld_purchase_id && a.fld_product_id = '1' && b.fld_id = '{$ship['fld_purchase_id']}'")->row_array();
                                                    		    $price = $purchasePrice['fld_unit_price'];
                                                    		    $total_amount += ($purchasePrice['fld_grand_total_amount']+$fright);
                                                    		    
                                                		    }
                                                		    if($price > 0){
                                                		        array_push($prices, $price);
                                                		    }
                                                		    
                                                        }
                                                        
                                                        // print_r($prices);
                                                        $date = date('Y-m-d');
                                                        $todaypurchase1= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_purchase as a, tbl_purchase_detail as b WHERE DATE(a.fld_purchase_date) = '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_purchase_id = a.fld_id AND b.fld_product_id = '1'")->row()->fld_quantity+0; 
                                                        $pastpurchase1= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_purchase as a, tbl_purchase_detail as b WHERE DATE(a.fld_purchase_date) < '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_purchase_id = a.fld_id AND b.fld_product_id = '1'")->row()->fld_quantity+0;
                                                        $todaysale1= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) = '$date' AND a.fld_location_from = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '1'")->row()->fld_quantity+0;
                                                        $pastsale1= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) < '$date' AND a.fld_location_from = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '1'")->row()->fld_quantity+0;
                                                      
                                                        $tsale = 0;
                                                        $psale = 0;
                                                        $todaypurchase2= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) = '$date' AND a.fld_location_to = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '1'")->row()->fld_quantity+0; 
                                                        $pastpurchase2= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) < '$date' AND a.fld_location_to = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '1'")->row()->fld_quantity+0;
                                                        $todaysale2= $this->db->query("SELECT sc.fld_subcategory, sc.weight, b.fld_quantity as fld_quantity FROM tbl_sale as a, tbl_sale_detail as b, tbl_subcategory as sc WHERE DATE(a.fld_sale_date) = '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_sale_id = a.fld_id AND sc.fld_subcid = b.fld_subproduct_id AND b.fld_product_id = '1'")->result_array();
                                                        $pastsale2= $this->db->query("SELECT sc.fld_subcategory, sc.weight, b.fld_quantity as fld_quantity FROM tbl_sale as a, tbl_sale_detail as b, tbl_subcategory as sc WHERE DATE(a.fld_sale_date) < '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_sale_id = a.fld_id AND sc.fld_subcid = b.fld_subproduct_id AND b.fld_product_id = '1'")->result_array();
                                                        
                                                        $todaypurchase3= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_gain_loss as a, tbl_gainloss_details as b WHERE DATE(a.fld_date) = '$date' AND b.fld_location_id = '{$loc['fld_id']}' AND b.fld_gl_id = a.fld_id AND b.fld_product_id = '1' and b.fld_type=1")->row()->fld_quantity+0; 
                                                        $pastpurchase3= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_gain_loss as a, tbl_gainloss_details as b WHERE DATE(a.fld_date) < '$date' AND b.fld_location_id = '{$loc['fld_id']}' AND b.fld_gl_id = a.fld_id AND b.fld_product_id = '1' and b.fld_type=1")->row()->fld_quantity+0;
                                                        
                                                        foreach($todaysale2 as $tdsale){
                                                            $tsale += $tdsale['weight']*$tdsale['fld_quantity'];
                                                        }
                                                        foreach($pastsale2 as $ptsale){
                                                            $psale += $ptsale['weight']*$ptsale['fld_quantity'];
                                                        }
                                                        $todaysale2 = $tsale;
                                                        $pastsale2 = $psale;
                                                        
                                                        $gl_diff = $this->db->query("SELECT IFNULL(SUM(fld_quantity), 0) as qty FROM tbl_gainloss_details WHERE fld_type = 3 && fld_location_id = '{$loc['fld_id']}'")->row_array();
                                                        $totalDiff = round($gl_diff['qty']/1000, 3); 
                                                        $totalDiff = $gl_diff['qty']; 
                                                        $pastpurchase = $pastpurchase1+$pastpurchase2+($pastpurchase3/1000);
                                                        $todaypurchase = $todaypurchase1+$todaypurchase2+($todaypurchase3/1000);  
                                                      
                                                        $pastpurchasekg = $pastpurchase * 1000;
                                                        $todaypurchasekg = $todaypurchase * 1000;
                                                        $todaysale = ($todaysale1*1000)+$todaysale2;
                                                        $pastsale = ($pastsale1*1000)+$pastsale2;
                                                      
                                                        $tq += $todaysale+$pastsale;
                                                        $openingstock = $pastpurchasekg - $pastsale;
                                                        $closingstock = ($openingstock + $todaypurchasekg - $todaysale)+$totalDiff;
                                                        
                                                        $total_purchase_amount += $total_amount;
                                                        $total_qty += round($closingstock/1000, 3); 
                                                ?>
                                                
                                            
                                        
                                        		<tr>
                                        			<!--<td ><?//php echo $i;?></td>-->
                                        			<td ><?=$loc['fld_location'];?></td>
                                        			<td ><?=round($closingstock, 3);?></td>
                                        			<td ><?php if(count($prices)>0){ 
                                        			    
                                        			        echo round(array_sum($prices)/count($prices), 2);
                                        			
                                        			    }else{ echo 0; } ?></td>
                                        			<td ><?=$total_amount;?></td>
                                        		</tr>
                                        		<?php $i++; } ?>		
                                        		<tr class="search_finalsum ">
                                        			<td colspan="2" style="text-align:center;font-weight:bold;">NET TOTAL</td>
                                        			<td style="text-align:left;font-weight:bold;"><?=$total_qty;?></td>
                                        			<td style="text-align:left;font-weight:bold;"><?=$total_purchase_amount;?></td>
                                        		</tr>
                                        		<?php }else{?>
                                        		<tr><td colspan="4" style="text-align:center;color:red;">Sorry No Record Found</td>
                                        		</tr>
                                        		<?php } ?>
                                        	</tbody>
                                        </table> <!--end table-->                                               
                                    </div><!--end /div-->
                                    <div class="more" style="text-align:center;">
                                        <a href="<?= base_url('Stocks/tableviewlpg');?>" class=""><u>View More</u></a>
                                    </div>
                                    
                                </div><!--end card-body-->
                            </div><!--end card-->
                        </div><!--end col-->
                        <?}?>
                                    <? if(!empty($role_permissions) && in_array(262,$role_permissions)) { ?>
                         <div class="col-lg-6">
                            <div class="card" style="background: #9e9e9e;border: 1px solid #9e9e9e;box-shadow: 0 10px 16px 0 #30635c, 0 6px 20px 0 rgb(255 255 255) !important;" >
                                <div class="card-body">
                                    <h4 class="header-title mt-0 mb-3" style="color: #ffffff;">Activity Logs</h4>
                                    <div class="table-responsive browser_users">
                                        <table class="table log">
                                            <thead>
                                                <tr>
        											<th>Date</th>
                                                    <th>Login</th>
                                                    <th>Action</th>
                                                    <th>IP</th>
                                                    <th>Address</th>
                                                    <th>Device</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
        										<?php if($activity_logs){
        											$i=1;
        											foreach($activity_logs as $logs){
        											    $user=$this->db->query("select * from tbl_users where fld_id='{$logs['fld_user_id']}'")->row_array();
        										?>
        											<tr>
        												<td><?= date('H:i',strtotime($logs['fld_added_date']));?></td>
        												<td><?= $user['fld_username'];?></td>
        												<td><?= $logs['fld_action'];?></td>
        												<td><?= $logs['fld_ip_address'];?></td>
        												<td style="font-size:9px !important;"><?= $logs['fld_address'];?></td>
        												<td style="font-size:9px !important;;"><?= $logs['fld_device'];?></td>
        												
        											</tr>
        										<?php $i++;}}?>
                                            </tbody>
                                        </table> <!--end table-->                                               
                                    </div><!--end /div-->
                                     <div class="more" style="text-align:center;">
                                        <a href="<?= base_url('Settings/log_system');?>" class=""><u>View More</u></a>
                                    </div>
                                </div><!--end card-body-->
                            </div><!--end card-->
                        </div><!--end col-->
                        <?}?>
                    </div>
                    <? $links=$this->db->query("SELECT * FROM tbl_quicklinks WHERE id = 1")->row_array();?>
                    <? if(!empty($role_permissions) && in_array(274,$role_permissions)) { ?>
<div class="col-lg-12">
<div class="card" style="background: #95adc1;border: 1px solid #95adc1;box-shadow: 0 10px 16px 0 #30635c, 0 6px 20px 0 rgb(255 255 255) !important;" >
<div class="card-body">
<h4 class="header-title mt-0 mb-3" style="color: #ffffff;">Quick Links:</h4><hr>
<div class="row">
<div class="col-lg-6">
<div class="row">    
<div class="col-md-6 col-lg-3">
<a href="<?=$links['url_1'];?>"><div class="card report-card" style="border: 1px solid #929cc5;background: #929cc5;margin-bottom: 13px;box-shadow: 0 10px 16px 0 #30635c, 0 6px 20px 0 rgb(255 255 255) !important;">
    <div class="card-body new_box">
        <div class="row d-flex">
            <div class="col-12">
                <p class="text-white font-weight-semibold font-11"><?= $links['name_1'];?></p>
                <!--<div class="content">-->
                <!--    <ul>-->
                <!--        <li>+ JV</li>-->
                <!--    </ul>-->
                <!--</div>-->
                </div>
            <div class="iconof">
                <div class="report-main-icon bg-light-alt" style="border: 2px solid #929cc5;">
                    <!--<span style="font-size: 16px;">+</span>-->
                    <?if ($links['icon_1']=='add'){?>
                    <i class="fas fa-plus-circle" style="font-size: 12px;"></i>
                    <?} else{?>
                    <i class="fa fa-eye" style="font-size: 12px;"></i>
                    <?}?>
                </div>
            </div>
        </div>
    </div><!--end card-body--> 
</div></a><!--end card--> 
</div> <!--end col-->

<div class="col-md-6 col-lg-3">
<a href="<?=$links['url_2'];?>"><div class="card report-card" style="border: 1px solid #6abdcf;background: #6abdcf;margin-bottom: 13px;box-shadow: 0 10px 16px 0 #30635c, 0 6px 20px 0 rgb(255 255 255) !important;">
    <div class="card-body new_box">
        <div class="row d-flex">
            <div class="col-12">
                <p class="text-white font-weight-semibold font-11"><?= $links['name_2'];?></p>
                <!--<div class="content">-->
                <!--    <ul>-->
                <!--        <li>+ CPV</li>-->
                <!--    </ul>-->
                <!--</div>-->
                </div>
            <div class="iconof">
                <div class="report-main-icon bg-light-alt" style="border: 2px solid #6abdcf;">
                    <!--<span style="font-size: 16px;">+</span>-->
                    <?if ($links['icon_2']=='add'){?>
                    <i class="fas fa-plus-circle" style="font-size: 12px;"></i>
                    <?} else{?>
                    <i class="fa fa-eye" style="font-size: 12px;"></i>
                    <?}?>
                </div>
            </div>
        </div>
    </div><!--end card-body--> 
</div></a><!--end card--> 
</div> <!--end col-->

<div class="col-md-6 col-lg-3">
<a href="<?=$links['url_3'];?>"><div class="card report-card" style="border: 1px solid #4893bb;background: #4893bb;margin-bottom: 13px;box-shadow: 0 10px 16px 0 #30635c, 0 6px 20px 0 rgb(255 255 255) !important;">
    <div class="card-body new_box">
        <div class="row d-flex">
            <div class="col-12">
                <p class="text-white font-weight-semibold font-11"><?= $links['name_3'];?>r</p>
                <!--<div class="content">-->
                <!--<ul>-->
                <!--    <li>+ CRV</li>-->
                <!--</ul>-->
                <!--</div>-->
                </div>
            <div class="iconof">
                <div class="report-main-icon bg-light-alt" style="border: 2px solid #4893bb;">
                    <!--<span style="font-size: 16px;">+</span>-->
                    <!--<i class="fas fa-plus-circle" style="font-size: 12px;"></i>-->
                    <?if ($links['icon_3']=='add'){?>
                    <i class="fas fa-plus-circle" style="font-size: 12px;"></i>
                    <?} else{?>
                    <i class="fa fa-eye" style="font-size: 12px;"></i>
                    <?}?>
                </div>
            </div>
        </div>
    </div><!--end card-body--> 
</div></a><!--end card--> 
</div> <!--end col-->

<div class="col-md-6 col-lg-3">
<a href="<?=$links['url_4'];?>">
<div class="card report-card" style="border: 1px solid #93b190;background: #93b190;margin-bottom: 13px;box-shadow: 0 10px 16px 0 #30635c, 0 6px 20px 0 rgb(255 255 255) !important;">
    <div class="card-body new_box">
        <div class="row d-flex">
            <div class="col-12">
                <p class="text-white font-weight-semibold font-11"><?= $links['name_4'];?></p>
                <!--<div class="content">-->
                <!--<ul>-->
                <!--    <li>+ CHPV</li>-->
                <!--</ul>-->
                <!--</div>-->
                </div>
            <div class="iconof">
                <div class="report-main-icon bg-light-alt" style="border: 2px solid #93b190;">
                    <!--<span style="font-size: 16px;">+</span>-->
                <!--<i class="fas fa-plus-circle" style="font-size: 12px;"></i>-->
                <?if ($links['icon_4']=='add'){?>
                    <i class="fas fa-plus-circle" style="font-size: 12px;"></i>
                    <?} else{?>
                    <i class="fa fa-eye" style="font-size: 12px;"></i>
                    <?}?>
                </div>
            </div>
        </div>
    </div><!--end card-body--> 
</div><!--end card-->
</a>
</div><!--end col-->
</div>  
</div>
<div class="col-lg-6">
    <div class="row">

<div class="col-md-6 col-lg-3">
<a href="<?=$links['url_5'];?>">
<div class="card report-card" style="border: 1px solid #929cc5;background: #929cc5;margin-bottom: 13px;box-shadow: 0 10px 16px 0 #30635c, 0 6px 20px 0 rgb(255 255 255) !important;">
    <div class="card-body new_box">
        <div class="row d-flex">
            <div class="col-12">
                <p class="text-white font-weight-semibold font-11"><?= $links['name_5'];?></p>
                <!--<div class="content">-->
                <!--    <ul>-->
                <!--        <li>+ CHRV</li>-->
                <!--    </ul>-->
                <!--</div>-->
                </div>
            <div class="iconof">
                <div class="report-main-icon bg-light-alt" style="border: 2px solid #929cc5;">
                    <!--<i class="fas fa-plus-circle" style="font-size: 12px;"></i>-->
                    <?if ($links['icon_5']=='add'){?>
                    <i class="fas fa-plus-circle" style="font-size: 12px;"></i>
                    <?} else{?>
                    <i class="fa fa-eye" style="font-size: 12px;"></i>
                    <?}?>
                    
                </div>
            </div>
        </div>
    </div><!--end card-body--> 
</div><!--end card-->
</a>
</div> <!--end col--> 


<div class="col-md-6 col-lg-3">
<a href="<?=$links['url_6'];?>"><div class="card report-card" style="border: 1px solid #6abdcf;background: #6abdcf;margin-bottom: 13px;box-shadow: 0 10px 16px 0 #30635c, 0 6px 20px 0 rgb(255 255 255) !important;">
    <div class="card-body new_box">
        <div class="row d-flex">
            <div class="col-12">
                <p class="text-white font-weight-semibold font-11"><?= $links['name_6'];?></p>
                <!--<div class="content">-->
                <!--    <ul>-->
                <!--        <li>+ B.S</li>-->
                <!--    </ul>-->
                <!--</div>-->
                </div>
            <div class="iconof">
                <div class="report-main-icon bg-light-alt" style="border: 2px solid #6abdcf;">
                    <!--<span style="font-size: 16px;">+</span>-->
                    <!--<i class="fa fa-eye" style="font-size: 12px;"></i>-->
                    <?if ($links['icon_6']=='add'){?>
                    <i class="fas fa-plus-circle" style="font-size: 12px;"></i>
                    <?} else{?>
                    <i class="fa fa-eye" style="font-size: 12px;"></i>
                    <?}?>
                </div>
            </div>
        </div>
    </div><!--end card-body--> 
</div></a><!--end card--> 
</div> <!--end col-->

<div class="col-md-6 col-lg-3">
<a href="<?=$links['url_7'];?>"><div class="card report-card" style="border: 1px solid #4893bb;background: #4893bb;margin-bottom: 13px;box-shadow: 0 10px 16px 0 #30635c, 0 6px 20px 0 rgb(255 255 255) !important;">
    <div class="card-body new_box">
        <div class="row d-flex">
            <div class="col-12">
                <p class="text-white font-weight-semibold font-11"><?= $links['name_7'];?></p>
                <!--<div class="content">-->
                <!--    <ul>-->
                <!--        <li>+ D.R</li>-->
                <!--    </ul>-->
                <!--</div>-->
                </div>
            <div class="iconof">
                <div class="report-main-icon bg-light-alt" style="border: 2px solid #4893bb;">
                    <!--<span style="font-size: 16px;">+</span>-->
                    <!--<i class="fa fa-eye" style="font-size: 12px;"></i>-->
                    <?if ($links['icon_7']=='add'){?>
                    <i class="fas fa-plus-circle" style="font-size: 12px;"></i>
                    <?} else{?>
                    <i class="fa fa-eye" style="font-size: 12px;"></i>
                    <?}?>
                </div>
            </div>
        </div>
    </div><!--end card-body--> 
</div></a><!--end card--> 
</div> <!--end col-->

<div class="col-md-6 col-lg-3">
<a href="<?=$links['url_8'];?>"><div class="card report-card" style="border: 1px solid #93b190;background: #93b190;margin-bottom: 13px;box-shadow: 0 10px 16px 0 #30635c, 0 6px 20px 0 rgb(255 255 255) !important;">
    <div class="card-body new_box">
        <div class="row d-flex">
            <div class="col-12">
                <p class="text-white font-weight-semibold font-11"><?= $links['name_8'];?></p>
                <!--<div class="content">-->
                <!--    <ul>-->
                <!--        <li>+ T.B</li>-->
                <!--    </ul>-->
                <!--</div>-->
                </div>
            <div class="iconof">
                <div class="report-main-icon bg-light-alt" style="border: 2px solid #93b190;">
                    <!--<span style="font-size: 16px;">+</span>-->
                    <!--<i class="fa fa-eye" style="font-size: 12px;"></i>-->
                    <?if ($links['icon_8']=='add'){?>
                    <i class="fas fa-plus-circle" style="font-size: 12px;"></i>
                    <?} else{?>
                    <i class="fa fa-eye" style="font-size: 12px;"></i>
                    <?}?>
                </div>
            </div>
        </div>
    </div><!--end card-body--> 
</div></a><!--end card--> 
</div> <!--end col-->
    
</div>
</div>
</div><!--end card-body-->
</div><!--end card-->
</div><!--end col-->
</div>
<? } ?>
</div>
<script>
window.onload = function() {
document.getElementById('button').onclick = function() {
document.getElementById('modalOverlay').style.display = 'none'
};
};
</script>
                