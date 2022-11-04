<style>
h3{
    text-align:center;
}
/*p{*/
/*    text-align:center;*/
/*}*/
.search_filter td {
    /*border: none !important;*/
    color: #000;
    font-weight: bold;
}
td {
    border: 1px solid #aba9a9fa !important;
    color: #000;
    /*font-weight: bold;*/
    padding: 7px;
}

.table thead th{
    border:1px solid #aba9a9fa;
}
.table-borderless td{
    border:0px !important;
}
.text-center{
    text-align:center;
}
.text-right{
    text-align:right;
}
.detail span{
    text-align:left;
}
.text-left{
    text-align:left;
}
.detail span{
    font-size:12px;
}
@media print {
    /*th {  padding: 5px; color:#000; font-weight:bold;}*/
.detail span{
    text-align:left;
    font-size:10px !important;
}
.desc{
    font-size:10px;
    font-weight:100;
}
}
</style>
<table class="table table-borderless" style="width:100%;">
    <tbody>
        <tr>
            <td style="width:61%;text-align:left">
                <? $settings=$this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row_array();?>
                <img class="company-logo" src="<?=base_url()?>/assets/uploads/logo/<?=$settings['system_logo'];?>" style="height:70px;float:left;">
                <!--<img class="company-logo" src="<?= base_url()?>assets/custom_elements/images/logoreport.png" style="height:70px;float:left;">-->
            </td>
            <td>
                <div class="detail text-left" >
                    <span style="font-weight:bold;">Type :</span>&nbsp;<span class="">Stocks Report(LPG)</span><br>
                    <span style="font-weight:bold;">Stock's Date :</span>&nbsp;<span class=""><?= date('d - M - Y'); ?></span><br>
                </div>
            </td>
        </tr>
    </tbody>
</table>

<hr style="width:100%;">
<table class="table " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
<thead class="dthead">
    	<tr>
    		<th>#</th>
    		<th>Plant Name</th>
    		<th>Qty (MT)</th>
    		<th>Rate/MT (Avg)</th>
    		<th>Purchase(Purchase+Freight Amount)</th>
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
              
                $openingstock = $pastpurchasekg - $pastsale;
                $closingstock = ($openingstock + $todaypurchasekg - $todaysale)+$totalDiff;
                
                $total_purchase_amount += $total_amount;
                $total_qty += round($closingstock/1000, 3); 
        ?>
        
    
        <? /* /><div class="col-md-4">
            <div class="category-card">
                <div class="video-icon">
                <i class="fa fa-houzz" style="font-size:36px;">&nbsp;<span class="heead"><?=$loc['fld_location'];?></span></i>
                </div>
                <div class="content">
                    <ul>
                       <li><a href="#">Date: <?=date('d/m/Y')?></a></li>    
                       <li><a href="#">Opening Stock (MT): <?=round($openingstock/1000, 3);?></a></li>
                       <li><a href="#">Stock Receive (MT): <?=$todaypurchase;?></a></li>
                       <? if($loc['fld_location'] == 'In Transit'){ ?>
                       <li><a href="#">Today Transfer (MT): <?=round($todaysale/1000, 3);?></a></li>
                       <? }else{ ?>
                       <li><a href="#">Today Sale (MT): <?=round($todaysale/1000, 3);?></a></li>
                       <? } ?>
                       <li><a href="#">Closing Stock (MT): <?=round($closingstock/1000, 3);?></a></li>
                    </ul>
                </div>
             </div>
        </div>
        <? } ?><? */ ?>
    

		<tr>
			<td ><?php echo $i;?></td>
			<td ><?=$loc['fld_location'];?></td>
			<td ><?=round($closingstock/1000, 3);?></td>
			<td ><?php if(count($prices)>0){ 
			    
			        echo round(array_sum($prices)/count($prices), 2);
			
			    }else{ echo 0; } ?></td>
			<td ><?=$total_amount;?></td>
		</tr>
		<?php $i++; } ?>		
		<tr class="search_finalsum">
			<td colspan="2" style="text-align:center;font-weight:bold;">NET TOTAL</td>
			<td style="text-align:left;font-weight:bold;"><?=$total_qty;?></td>
			<td style="text-align:center;font-weight:bold;"></td>
			<td style="text-align:left;font-weight:bold;"><?=$total_purchase_amount;?></td>
		</tr>
		<?php }else{?>
		<tr><td colspan="5" style="text-align:center;color:red;">Sorry No Record Found</td></tr>
		<?php } ?>
	</tbody>
</table>
<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				<div class="row-fluid">
					<div class="span12">
						<table class="signature-fields" style="width:100%;">
							<thead>
								<tr>
									<th style="color:black;background-color: white !important;border-top: 1px solid black; border-left: 1px solid white; border-right: 1px solid white; border-bottom: 1px solid white;width:33%;">Prepared By</th>
									<th style="background-color : white !important;    border-top: 1px solid white;width:33%;"></th>
									<th style="color:black;background-color: white !important;border-top: 1px solid black; border-left: 1px solid white; border-right: 1px solid white; border-bottom: 1px solid white;width:33%;">Received By</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
				<div class="bel" style="position:absolute;bottom:2px;font-size:10px;"><p style="position:absolute;bottom:2px;font-style: italic;color:#5d5d5d;"><span style="font-weight:bold;font-style: italic;">Note:</span> This is auto generated report , on <?= date('d - M - Y'); ?> <?= date('h:i A'); ?> by <?= $this->session->userdata('user_name'); ?> login and requires signature from the approval authority.</p></div>

<script>
    	window.print();
</script>
