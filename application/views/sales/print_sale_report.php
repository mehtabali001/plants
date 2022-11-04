<!DOCTYPE html>
<html>
<head>
	<title>Daybook Report </title>
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
@media print {
    /*th {  padding: 5px; color:#000; font-weight:bold;}*/
.detail span{
    text-align:left;
}
.desc{
    font-size:10px;
    font-weight:100;
}
}
@media print { 
body {
  position: relative;
  }
.bel p{ {
  
  }
}
</style>
</head>
<body>
	<div class="container-fluid" style="margin-top:10px;">
							      
                                  <table class="table table-borderless" style="width: -webkit-fill-available;">
                                    <tbody>
                                        <tr>
                                            <td style="width:70%;text-align:left">
                                                <? $settings=$this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row_array();?>
                                                <img class="company-logo" src="<?=base_url()?>/assets/uploads/logo/<?=$settings['system_logo'];?>" style="height:70px;float:left;">
                                            </td>
                                            <td>
                                                <div class="detail text-left" >
                                                    <span style="font-weight:bold;font-size:10px;">Type:</span>&nbsp;<span class="" style="font-size:10px;">Sale Report</span><br>
                                                     <span style="font-weight:bold;font-size:10px;">Showing Report As :</span>&nbsp;<span class="" style="font-size:10px;"><?php echo str_replace('_', ' ', $_GET['filter']); ?>, <?php if($_GET['filter_type']==1){echo 'Detailed';}else{echo 'Summary';} ?> </span><br>
                                                     <span style="font-weight:bold;font-size:10px;">From :</span>&nbsp;<span class="fromDate" style="font-size:10px;"><?=$_GET['from_date'];?></span><br>
                                                     <span style="font-weight:bold;font-size:10px;">To :</span>&nbsp;<span class="toDate" style="font-size:10px;"><?=$_GET['to_date'];?></span><br>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

<hr style="width:100%;">
								
								<table id="datatable_tb" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;margin-top: 5%;">
									<thead class="htmlRows1">
    									<tr>
                                    		<th>#</th>
                                    		<th>Invoice Date</th>
                                    		<th>Invoice ID</th>
                                    		<th>Account</th>
                                    		<th>Item</th>
                                    		<th>Remarks</th>
                                    		<th>Qty</th>
                                    		<th>Weight(KG)</th>
                                    		<th>Rate(PKR)</th>
                                    		<th>Discount(PKR)</th>
                                    		<th>Amount(Pkr)</th>
                                    	</tr>
									</thead>
									<tbody id="htmlRows">
										 <?php if($sales){
			 $i=1;
			 $b=1;
			 $total_all_amount = 0;
			 $amtqty=0;
			 $akgqty=0;
			 $atdiscount=0;
			foreach($sales as $sale){
			?>
		<tr class="search_filter">
			<td colspan="11" style="padding-left: 24%;"><?php echo $sale['filter_text'];?></td>
		</tr>
				<?php
				$mtqty=0;
				$kgqty=0;
				$total_amount=0;
				$tdiscount=0;
				foreach($sale['detail'] as $saledet){
					$mtqty=$mtqty + $saledet['fld_quantity'];
					$total_amount=$total_amount + $saledet['fld_total_amount']-$saledet['fld_discount'];
					$kgqty=$kgqty + ($saledet['fld_quantity'] * 1000);
					if($filter_type == 1){
					    $subcat = '';
					    if($saledet['fld_subproduct_id'] != '0'){
					        $subcat = ' - '.$this->db->query("select * from tbl_subcategory where fld_subcid = '{$saledet['fld_subproduct_id']}'")->row()->fld_subcategory;
					    }
					?>
					<tr>
						<td ><?php echo $i;?></td>
						<td ><?php echo date('d-m-Y',strtotime($saledet['fld_sale_date']));?></td>
						<td ><?php echo $saledet['fld_voucher_no'];?></td>
						<td ><?php echo $saledet['fld_customer_name'];?></td>
						<td ><?php echo $saledet['fld_category'].$subcat;?></td>
						<td ><?php echo $saledet['fld_shipment'];?></td>
						<td ><?php echo $saledet['fld_quantity'];?></td>
						<td ><?php echo $saledet['fld_weight'];?></td>
						<td ><?php echo $saledet['fld_unit_price'];?></td>
						<td ><?php echo round($saledet['fld_discount'],2);?></td>
						<td ><?php echo round($saledet['fld_total_amount']-$saledet['fld_discount'], 2);?></td>
					</tr>
					<?php $i++; }}?>
		
			<tr class="search_finalsum">
			<td colspan="6" style="text-align:right;font-weight:bold;">TOTAL</td>
			<td ><?= number_format($mtqty,2);?></td>
			<td ><?= number_format($kgqty,2);?></td>
			<td>&nbsp;</td>
			<td><?= number_format($tdiscount,2);?></td>
			<td><?= number_format($total_amount,2);?></td>
		</tr>
		<?php
		$total_all_amount += $total_amount;
		$atdiscount += $tdiscount;
		$akgqty += $kgqty;
		$amtqty += $mtqty;
		$b++;
		} ?>
		<tr class="search_finalsum">
			<td colspan="6" style="text-align:right;font-weight:bold;"> NET TOTAL</td>
			<td ><?= number_format($amtqty,2);?></td>
			<td ><?= number_format($akgqty,2);?></td>
			<td>&nbsp;</td>
			<td><?= number_format($atdiscount,2);?></td>
			<td><?= number_format($total_all_amount,2);?></td>
		</tr>
		
		<?php }else{?>
		<tr><td colspan="9" style="text-align:center;">No Record Found</td></tr>
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
				<br>
			<div class="row-fluid">
					<div class="span12">
						<table class="signature-fields" style="width:100%;">
							<thead>
								<tr>
									<th style="color:black;background-color : white !important;border-top: 1px solid black; border-left: 1px solid white; border-right: 1px solid white; border-bottom: 1px solid white;width:33%;">Prepared By</th>
									<th style="    background-color : white !important;    border-top: 1px solid white;width:33%;"></th>
									<th style="color:black;background-color: white !important;border-top: 1px solid black; border-left: 1px solid white; border-right: 1px solid white; border-bottom: 1px solid white;width:33%;">Received By</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		<div class="bel">
		    <p style="position: sticky;font-style: italic; bottom: 0; color:#5d5d5d;"><span style="font-weight:bold;">Note:</span> This is auto generated report on <?= date('d - M - Y'); ?>, <?= date('h:i A'); ?> by <?= $this->session->userdata('user_name'); ?> account  and requires signature from the approval authority.</p>
		    </div>
	<script type="text/javascript" src="<?= base_url();?>/assets/theme_elements/js/jquery.min.js"></script>

<script type="text/javascript">
		$(function(){

			window.print();
			
		});
	</script>
</body>
</html>