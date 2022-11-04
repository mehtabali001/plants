<!DOCTYPE html>
<html>
<head>
	<title>Sale Report</title>

	<style>
		body {
    background-color: #ffffff;
}
		 * { margin: 0; padding: 0; font-family: serif; }
		 body { font-size:12px; }
		 p { margin: 0; /* line-height: 17px; */ }
		table { width: 100%; border: 1px solid black; border-collapse:collapse; table-layout:fixed; border-collapse: collapse;position: relative;
    top: 1.2in; }
		th {background:#000 !important; border: 1px solid black; padding: 5px;width:10%; }
		td { text-align: center; vertical-align: center; /*padding: 5px 10px;*/ border-left: 1px solid black;border-bottom: 1px solid;width:10%;}
		@media print {
		 	.noprint, .noprint * { display: none; }
		 }
		 .centered { margin: auto; }
		 @page{margin:10px auto !important;}
		 .rcpt-header { margin: auto; display: block; }
		 td:first-child { text-align: center; }
		 td:nth-child(6){overflow-wrap: break-word;}
		.subsum_tr td, .netsum_tr td { border-top:1px solid black !important; border-bottom:1px solid black; }
		.hightlight_tr td {border-top: 1px solid black; border-left:0 !important; border-right: 0 !important; border-bottom: 1px solid black; background: rgb(226, 226, 226); color: black; }
		.finalsum td {border-top: 1px solid black; border-left:0 !important; border-right: 0 !important; border-bottom: 1px solid black; background: rgb(250, 250, 250); color: black; }
		 .field {font-weight: bold; display: inline-block; width: 80px; } 
		 .voucher-table thead th {background:#000 !important; padding:3px; text-align: center; font-size: 12px;color:white !important;border: 1px solid #FFF;} 
		 tfoot {border-top: 1px solid black;} 
		 .bold-td { font-weight: bold; border-bottom: 1px solid black;}
		 .nettotal { font-weight: bold; font-size: 14px; border-top: 1px solid black; }
		 .invoice-type { border-bottom: 1px solid black;}
		 .relative { position: relative;}
		 .signature-fields{ border: none; border-spacing: 20px; border-collapse: separate;} 
		 .signature-fields th {border: 0px; border-top: 1px solid black; border-spacing: 10px;}
		 .inv-leftblock { width: 280px;}
		 .text-left { text-align: left !important;}
		 .text-right { text-align: right !important;}
		 td {font-size: 10px; font-family: tahoma; line-height: 14px; padding: 4px;  text-transform: uppercase;} 
		 .rcpt-header { width: 450px; margin: auto; display: block;}
		 .inwords, .remBalInWords { text-transform: uppercase;}
		 .barcode { margin: auto;}
		 h3.invoice-type {font-size: 20px; width: 209px; line-height: 24px;}
		 .extra-detail span { background: #7F83E9; color: white; padding: 5px; margin-top: 17px; display: block;} 
		 .nettotal { color: red; }
		 .remainingBalance { font-weight: bold; color: blue;}
		 .centered { margin: auto;}
		 p { position: relative;}
		 .fieldvalue.cust-name {position: absolute; width: 497px;} 
		 .shadowhead { border-bottom: 0px solid black; padding-bottom: 5px;} 
		 .AccName { border-bottom: 0px solid black; padding-bottom: 5px; font-size: 16px;} 

		 .txtbold { font-weight: bolder;} 
		 .uomStock{ width: 70px !important;}
		 .srStock{ width : 30px !important;}
		 .descriptionStock{ width : 200px !important;}
		 .qtyStock{ width : 70px !important;}
		 .headingBold{ font-weight: bold; font-size: 11px !important;}
		 
         .for {position: absolute;top: 1.5in;left: .5in;width: 2.9in;}
         .for p{padding-top:0 !important;padding-bottom:0 !important;font-size:10px; border: 1px solid;}
		 .from {position: absolute;top: 1.5in;right: .5in; width: 2.5in;}
         .from p{font-size:10px; padding-top:0 !important;padding-bottom:0 !important;border: 1px solid;}
        @media print {
		th { border: 1px solid black; padding: 5px; font-size:9px;color:#fff; background:#000;transition: none !important; -webkit-print-color-adjust: exact; text-align:left; }
		
		}
		.pdf-header img{
  position: relative;
}


.for {
  /*position: absolute;*/
  top: 1.5in;
  left: 0in;
  width: 2.9in;
}
.for p{
    padding-top:0 !important;
    padding-bottom:0 !important;
    font-size:8px;
    width:260px !importent;
}
p span{
    font-size:12px;
}
.from {
  /*position: absolute;*/
  top: 1.5in;
  right: 0in;
  width: 2.5in;
  
}
.span12 p {
    font-size:8px;
    padding-top:2px !important;
    padding-left:2px !important;
    padding-bottom:2px !important;
    border: 1px solid;
    /*width:230px;*/
}
span12 p span{
    font-size:8px;
}
.from p{
    font-size:8px;
    padding-top:2px !important;
    padding-bottom:2px !important;
    border: 1px solid;
}
@media print{

.bel{
    position:fixed;
    bottom: 3px;
    font-size:10px;
    padding-top:4px;
                
}
.fromDate{
    font-size:8px;
}
.toDate{
    font-size:8px;
}

}

	</style>

</head>
<body>
	
	 
	

	<div class="container-fluid" style="margin-top:10px;">
		<!-- <div class="row-fluid">
			<div class="span12 centered"> -->
				<!-- <div class="row-fluid"> -->
					<!-- <div class="span2"></div> -->
					<!-- <div class="span12"><img class="rcpt-header" src="../../assets/img/rcpt-header.png" alt=""></div> -->
					<!-- <div class="spn2"></div> -->
				<!-- </div> -->
				<!-- <div class="row-fluid relative">
					<div class="span12">
							<div class="block pull-left inv-leftblock">
								<p><span class="field">A/C Title</span><span class="fieldvalue accountTitle">[A/C Title]</span></p>
								<p><span class="field">A/C Code</span><span class="fieldvalue accountCode">[A/C Code]</span></p>
								<p><span class="field">Address</span><span class="fieldvalue address">[Address]</span></p>
								<p><span class="field">Contact #</span><span class="fieldvalue contactNum">[Contact #]</span></p>
							</div>
							<div class="block pull-right">
								<h3 class="invoice-type text-right" style="border:none !important; margin: 0px !important;"></h3>
							</div>
					</div>
				</div> -->
				<div class="row-fluid">
					<div class="span12 centered">
<!-- 						<div class="row-fluid">
							<div class="span12 text-center">
								<h3 class="text-center shadowhead">[Payable/Receivable]</h3>
								<p class="text-center"><span class="from"><strong>From:-</strong><span class="fromDate">[0000/00/00]</span></span> To <span class="to"><strong>To:-</strong><span class="toDate">[0000/00/00]</span></span></p>
							</div>
						</div> -->
						<br>
						<div class="row-fluid">
							<div class="span12">
							      <div class="pdf-header" style="margin-bottom:10px;">
                                      <img class="company-logo" src="https://erp.mktechsol.com//assets/theme_elements/images/logo-sm.png" style="height:80px;margin-left:40%;">
                                     <h3 style="text-align:center">A product of Fast-Tech solutions</h3>
                                  </div>
                                  <hr>
                                  
                                  <span class="for" style="float:left;">
                                        <h3 class="text-center shadowhead txtbold">Sales Report</h3>
                                         <p><span style="font-weight:bold;">From:</span>&nbsp;<span class="fromDate"><?=$_GET['from_date'];?></span><br>
                                        <span style="font-weight:bold;">To:</span>&nbsp;<span class="toDate"><?=$_GET['to_date'];?></span><br>
                                        </p>
                                  </span>
                            
                                  <div class="from" style="float:right; margin-top:0%;">
                                    <h3>Generated Report Details</h3>
                                    <p><span style="font-weight:bold;">&nbsp;Showing Report As:&nbsp; <?php echo str_replace('_', ' ', $_GET['filter']); ?>, <?php if($_GET['filter_type']==1){echo 'Detailed';}else{echo 'Summary';} ?> </span><br><span style="font-weight:bold;">&nbsp;Generated on:</span>&nbsp; <?= date('d - M - Y'); ?>, <?= date('h:i A'); ?><br>
                                    <?/*?><span style="font-weight:bold;">&nbsp;Time:</span>&nbsp; <?= date('h:i A'); ?><br><?*/?>
                                    <span style="font-weight:bold;display: inline-block;">&nbsp;Login:</span>&nbsp; <?= $this->session->userdata('user_name'); ?></p><br>
                                  </div>
                                  
								<!--<h3 class="text-center shadowhead txtbold"></h3>
								<h3 class="text-center AccName txtbold">.</h3>
								<p class="text-center"><span class="from"><strong>From:-</strong><span class="fromDate">[0000/00/00]</span></span> To <span class="to"><strong>To:-</strong><span class="toDate">[0000/00/00]</span></span></p>-->
								<table class="voucher-table">
									<thead class="htmlRows1">
    									<tr>
                                    		<th>Sr#</th>
                                    		<th>Date</th>
                                    		<th>Vr#</th>
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
			<td colspan="6" style="text-align:right;font-weight:bold;">TOTAL</td>
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
								
							</div>
							<div class="span12 htmlCharts">
								
							</div>
						</div>
					</div>
				</div>
				<br>
				<!-- <p><strong>Note:</strong>  Here please find our acount statement and check it, if any discrepancy please let it be known within a week. Otherwise it would be assumed that our statement is correct. Thanks!</p> -->
				<!--<br>
				<br>-->
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
						<table class="signature-fields">
							<thead>
								<tr>
									<th style="    background-color : white !important;border-top: 1px solid black; border-left: 1px solid white; border-right: 1px solid white; border-bottom: 1px solid white;">Prepared By</th>
									<th style="    background-color : white !important;    border-top: 1px solid white;"></th>
									<th style="    background-color: white !important;border-top: 1px solid black; border-left: 1px solid white; border-right: 1px solid white; border-bottom: 1px solid white;">Received By</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
			<p class="bel" style="position:absolute;bottom:0;font-style: italic;"><span style="font-weight:bold">Note:</span> This is auto generated report and requires signature from the approval authority.</p>
		<!-- </div>
	</div> -->
	<script type="text/javascript" src="<?= base_url();?>/assets/theme_elements/js/jquery.min.js"></script>
	<!--<script src="../../../assets/js/handlebars.js"></script>-->

	<script type="text/javascript">
		$(function(){

			window.print();
			
		});
	</script>
</body>
</html>