<!DOCTYPE html>
<html>
<head>
	<title>Sale Report </title>


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

/*.bel{*/
/*    position:fixed;*/
/*    bottom: 3px;*/
/*    font-size:10px;*/
/*    padding-top:4px;*/
                
/*}*/
/*.fromDate{*/
/*    font-size:8px;*/
/*}*/
.toDate{
    font-size:8px;
}

}
@media print{
table{
        width: 100%;
    border: 1px solid black;
    border-collapse: collapse;
    /* table-layout: fixed; */
    border-collapse: collapse;
    position: relative;
    /* top: 83px; */
    margin-top: 0%;
}
.bel p{
    margin-top:2px;
    font-size:8px;
    font-family: serif;
}
.fromDate{
    font-size:8px;
    font-family: serif;
}
/*.voucher-table{*/
/*   margin-bottom:14cm !importent;*/
/*}*/

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
                                        <h3 class="">Billing From : Fast-Tech Solutions</h3><br>
        
                                         <p><span style="font-weight:bold;">Sale Location </span><span class="fromDate"><?php echo $sale['fld_location']; ?></span><br>
                                         <span style="font-weight:bold;">Shipment # </span><span class="fromDate"><?= $sale['fld_shipment'];?></span><br>
                                         <span style="font-weight:bold;">Voucher # </span><span class="fromDate"><?php echo $sale['fld_voucher_no']; ?></span><br>
                                         <span style="font-weight:bold;">Invoice </span><span class="fromDate"><?php echo $sale['fld_invoice_no']; ?></span><br>
                                        <span style="font-weight:bold;">Vehicle no </span>&nbsp;<span class="fromDate"><?php echo $sale['fld_vehicle_no']; ?></span><br>
                                        </p>
                                  </span>
                            
                                  <div class="from" style="float:right; margin-top:0%;">
                                    <h3 style="padding-left:0; margin-bottom:0 !important;">Generated Report Details</h3><br>
                                    <p><span style="font-weight:bold;padding-left:0; margin-bottom:0 !important;">&nbsp;Billing For :</span>&nbsp; <?= $sale['fld_customer_name'];?><br>
                                    <span style="font-weight:bold;">&nbsp;Billing Date :</span>&nbsp;  <?= date('d-m-y',strtotime($sale['fld_sale_date']));?><br>
                                    <span style="font-weight:bold;">&nbsp;Generated on:</span>&nbsp;<?= date('d - M - Y'); ?>, <?= date('h:i A'); ?><br>
                                    <span style="font-weight:bold;">&nbsp;Login:</span>&nbsp; <?= $this->session->userdata('user_name'); ?></p><br>
                                  </div>
                                  
								<!--<h3 class="text-center shadowhead txtbold"></h3>
								<h3 class="text-center AccName txtbold">.</h3>
								<p class="text-center"><span class="from"><strong>From:-</strong><span class="fromDate">[0000/00/00]</span></span> To <span class="to"><strong>To:-</strong><span class="toDate">[0000/00/00]</span></span></p>-->
								<table class="voucher-table" style="margin-top:3%;">
									<thead class="htmlRows1">
										<tr>
											<th>SL.</th>
											<th>Product Name</th>
											<th class="text-center">Qty</th>
											<th class="text-center">Weight(KG)</th>
											<th class="text-center">Rate(PKR)</th>
											<th class="text-center">Discount(PKR)</th>
											<th class="text-center">Total(PKR)</th>
										</tr>
									</thead>
									<tbody id="htmlRows">
										<?php if($sale){
													$i=1;
													foreach($sale['products'] as $saledet){
													?>						
												<tr>
													<td><?= $i;?></td>
													<td>
														<?= $saledet['fld_category'];?> - <?= $saledet['fld_subcategory']; ?>
													</td>
													<td class="text-center"><?= $saledet['fld_quantity'];?></td>
													<td class="text-center"><?= $saledet['fld_weight'];?></td>
													<td class="text-center"><?= $saledet['fld_unit_price'];?></td>
													<td class="text-center"><?= $saledet['fld_discount'];?></td>
													<td class="text-center"><?= $saledet['fld_total_amount'];?></td>
												</tr>
													<?php $i++; }}?>
									</tbody>
										<tfoot>
											    	<tr>
													<td class="text-right" colspan="6"><b>Total Discount(PKR):</b></td>
													<td class="text-center"><b><?= $sale['fld_total_discount'];?></b></td>
												</tr>
												<tr>
													<td class="text-right" colspan="6"><b>Total(PKR):</b></td>
													<td class="text-center"><b><?= $sale['fld_grand_total_amount'];?></b></td>
												</tr>
													
										</tfoot>																									</tfoot>
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
						<table class="signature-fields" style="top:0">
							<thead>
								<tr>
									<th style="color:black;background-color : white !important;border-top: 1px solid black; border-left: 1px solid white; border-right: 1px solid white; border-bottom: 1px solid white;">Prepared By</th>
									<th style="    background-color : white !important;    border-top: 1px solid white;"></th>
									<th style="color:black;background-color: white !important;border-top: 1px solid black; border-left: 1px solid white; border-right: 1px solid white; border-bottom: 1px solid white;">Received By</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
			<div class="bel" style="margin-top:2px;"><p style="font-style: italic;"><span style="font-weight:bold;font-style: italic;">Note:</span> This is auto generated report and requires signature from the approval authority.</p></div>
		<!-- </div>
	</div> -->
	<script type="text/javascript" src="<?= base_url();?>/assets/theme_elements/js/jquery.min.js"></script>
	<!--<script src="../../../assets/js/handlebars.js"></script>-->

	<script type="text/javascript">
		$(function(){

			var opener = window.opener;
			
			var fromDate = opener.$('#from_date').val();
			var toDate = opener.$('#to_date').val();			
			var etype = opener.$('.form-section').text();
			if (opener.$('#datatable_tb').is(':visible')) {
				// var parentRows = opener.$(".purchaseRows tr");
				// var rowsHtml = '';

				// var parentRows1 = '';
				var parentRows1 = opener.$(".dthead tr").clone();
				$('.htmlRows1').append(parentRows1);
				// $(".htmlRows1").find('.printRemove').remove();
				
				// var netBalance = 0;
				 var parentCopy = opener.$('.purchaseRows tr').clone();
				 console.log(parentCopy);
				parentCopy.find('.printRemove').remove();
								

				$('#htmlRows').append(parentCopy);
				$("a").removeAttr("href");
				
		    }
		   // var what =opener.$('#filter').val().toLowerCase();
		    var what =opener.$("#filter option:selected").text().toLowerCase();

			// Charts 
			
			// End Charts
			$('.fromDate').html(fromDate);
			$('.toDate').html(toDate);
			$('.reporttype').html(what);
			
			
			// alert(parentCopy);
			$('.shadowhead').html(etype);
			// $('.netBalance').html(netBal);
			window.print();
			
		});
	</script>
</body>
</html>