<!DOCTYPE html>
<html>
<head>
	<title>Purchase Detail</title>

	<link rel="stylesheet" href="http://localhost/erpkotal/assets/theme_elements/css/bootstrap.min.css">
	<link rel="stylesheet" href="http://localhost/erpkotal/assets/custom_elements/css/bootstrap-responsive.min.css">

	<style>
		body {
    background-color: #ffffff;
}
		 * { margin: 0; padding: 0; font-family: tahoma; }
		 body { font-size:12px; }
		 p { margin: 0; /* line-height: 17px; */ }
		table { width: 100%; border: 1px solid black; border-collapse:collapse; table-layout:fixed; border-collapse: collapse; }
		th { border: 1px solid black; padding: 5px; }
		td { /*text-align: center;*/ vertical-align: center; /*padding: 5px 10px;*/ border-left: 1px solid black;border-bottom: 1px solid;}
		@media print {
		 	.noprint, .noprint * { display: none; }
		 }
		 .centered { margin: auto; }
		 @page{margin:10px auto !important; }
		 .rcpt-header { margin: auto; display: block; }
		 td:first-child { text-align: left; }
	
		.subsum_tr td, .netsum_tr td { border-top:1px solid black !important; border-bottom:1px solid black; }

		.hightlight_tr td {border-top: 1px solid black; border-left:0 !important; border-right: 0 !important; border-bottom: 1px solid black; background: rgb(226, 226, 226); color: black; }
		.finalsum td {border-top: 1px solid black; border-left:0 !important; border-right: 0 !important; border-bottom: 1px solid black; background: rgb(250, 250, 250); color: black; }
		 .field {font-weight: bold; display: inline-block; width: 80px; } 
		 .voucher-table thead th {background: #ccc; padding:3px; text-align: center; font-size: 12px;} 
		 tfoot {border-top: 1px solid black; } 
		 .bold-td { font-weight: bold; border-bottom: 1px solid black;}
		 .nettotal { font-weight: bold; font-size: 14px; border-top: 1px solid black; }
		 .invoice-type { border-bottom: 1px solid black; }
		 .relative { position: relative; }
		 .signature-fields{ border: none; border-spacing: 20px; border-collapse: separate;} 
		 .signature-fields th {border: 0px; border-top: 1px solid black; border-spacing: 10px; }
		 .inv-leftblock { width: 280px; }
		 .text-left { text-align: left !important; }
		 .text-right { text-align: right !important; }
		 td {font-size: 10px; font-family: tahoma; line-height: 14px; padding: 4px;  text-transform: uppercase;} 
		 .rcpt-header { width: 450px; margin: auto; display: block; }
		 .inwords, .remBalInWords { text-transform: uppercase; }
		 .barcode { margin: auto; }
		 h3.invoice-type {font-size: 20px; width: 209px; line-height: 24px;}
		 .extra-detail span { background: #7F83E9; color: white; padding: 5px; margin-top: 17px; display: block; } 
		 .nettotal { color: red; }
		 .remainingBalance { font-weight: bold; color: blue;}
		 .centered { margin: auto; }
		 p { position: relative; }
		 .fieldvalue.cust-name {position: absolute; width: 497px; } 
		 .shadowhead { border-bottom: 0px solid black; padding-bottom: 5px; } 
		 .AccName { border-bottom: 0px solid black; padding-bottom: 5px; font-size: 16px; } 

		 .txtbold { font-weight: bolder; } 
		 .uomStock{ width: 70px !important; }
		 .srStock{ width : 30px !important;}
		 .descriptionStock{ width : 200px !important;}
		 .qtyStock{ width : 70px !important;}
		 .headingBold{ font-weight: bold; font-size: 11px !important;  }
	</style>
</head>
<body>
	
	 
	

	<div class="container-fluid" style="margin-top:10px;">
		 <div class="row-fluid">
			<div class="span12 centered">
				 
				</div>
				<div class="row-fluid">
					<div class="span12 centered">
						<div class="row-fluid">
							<div class="span12 text-center">
								<h3 class="text-center shadowhead" style="text-align:center">Invoice # <?= $purchase['fld_invoice_no'];?></h3>
								
							</div>
						</div> 
						<br>
						<div class="row-fluid">
							<div class="span12">
								
								<p class="text-center"><span class="from"><strong>Billing For: </strong><span class="fromDate"><?= $purchase['fld_supplier_name'];?></span></span></p>
								<p class="text-center"><span class="from"><strong>Billing Date: </strong><span class="fromDate"><?= date('d - M - Y',strtotime($purchase['fld_purchase_date']));?></span></span></p>
								<br>
								<br>
								<table class="voucher-table">
									<thead class="htmlRows1">
										<!--<col style="width:50px" />-->
										<!--<col style="width:100px;" />-->
										<!--<col style="width:50px;" />-->
										<!--<col style="width:65px;" />-->
										<!--<col style="width:100px;" />-->
										
										<tr>
											<th style="width:50px;">SL.</th>
									        <th style="width:100px;">Item </th>
									        <th style="width:50px;">Qty </th>
									        <th style="width:65px;">Rate </th>
									        <th style="width:100px;">Amount </th>
										</tr>
									</thead>
									<tbody id="htmlRows">
										<?php if($purchase){
													$i=1;
													foreach($purchase['products'] as $purch){
													?>						
												<tr>
													<td><?= $i;?></td>
													<td>
														<?= $purch['fld_category'];?>
													</td>
													<td class="text-center"><?= $purch['fld_quantity'];?></td>
													<td class="text-center"><?= $purch['fld_unit_price'];?></td>
													<td class="text-center"><?= $purch['fld_total_amount'];?></td>
												</tr>
													<?php $i++; }}?>
									</tbody>
									<tfoot>
												<tr>
													<td class="text-right" colspan="4"><b>Total:</b></td>
													<td class="text-center"><b><?= $purchase['fld_grand_total_amount'];?></b></td>
												</tr>
													
																																			</tfoot>
								</table>
								
							</div>
							<div class="span12 htmlCharts">
								
							</div>
						</div>
					</div>
				</div>
				<br>
				<!-- <p><strong>Note:</strong>  Here please find our acount statement and check it, if any discrepancy please let it be known within a week. Otherwise it would be assumed that our statement is correct. Thanks!</p> -->
				<br>
				<br>
				<br>
				<br>
				<div class="row-fluid">
					<div class="span12">
						<table class="signature-fields">
							<thead>
								<tr>
									<th style="border-top: 1px solid black; border-left: 1px solid white; border-right: 1px solid white; border-bottom: 1px solid white;">Prepared By</th>
									<th style="border:1px solid white;"></th>
									<th style="border-top: 1px solid black; border-left: 1px solid white; border-right: 1px solid white; border-bottom: 1px solid white;">Received By</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		<!-- </div>
	</div> -->
	<script type="text/javascript" src="<?= base_url();?>/assets/theme_elements/js/jquery.min.js"></script>
	<!--<script src="../../../assets/js/handlebars.js"></script>-->

	<script type="text/javascript">
		$(function(){

			window.print();
// 			window.close();
			
		});
	</script>
</body>
</html>