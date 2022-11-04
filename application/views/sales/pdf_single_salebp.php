<!DOCTYPE html>
<html>
<head>
<style>
	body {
    background-color: #ffffff;
    padding: 50px;
}
		 * { margin: 5px; padding: 5px; font-family: serif; }
		 body { font-size:12px; }
		 p { margin: 0; /* line-height: 17px; */ }
		table { width: 100%; border: 1px solid black; border-collapse:collapse; table-layout:fixed; border-collapse: collapse; }
		@media print {
		th { border: 1px solid #fff; padding: 5px; font-size:9px;color:#fff; background:#000;transition: none !important; -webkit-print-color-adjust: exact; text-align:left; }
		
		}
		th { border: 1px solid #fff; padding: 5px; font-size:9px;color:#fff; background:#000;text-align:left;}
		td { /*text-align: center;*/ vertical-align: center; /*padding: 5px 10px;*/ border-left: 1px solid black;border-bottom: 1px solid; font-size:9px;}
		@media print {
		 	td { /*text-align: center;*/ vertical-align: center; /*padding: 5px 10px;*/ border-left: 1px solid black;border-bottom: 1px solid; font-size:9px;}
		 	
		 @media print {
		 	.noprint, .noprint * { display: none; }
		 }
		 
		
		 @page{margin:10px auto !important; }
		 .rcpt-header { margin: auto; display: block; }
		 td:first-child { text-align: left; }
	
		.subsum_tr td, .netsum_tr td { border-top:1px solid black !important; border-bottom:1px solid black; }

		.hightlight_tr td {border-top: 1px solid black; border-left:0 !important; border-right: 0 !important; border-bottom: 1px solid black; background: rgb(226, 226, 226); color: black; }
		.finalsum td {border-top: 1px solid black; border-left:0 !important; border-right: 0 !important; border-bottom: 1px solid black; background: rgb(250, 250, 250); color: black; }
		 .field {font-weight: bold; display: inline-block; width: 80px; } 
		 .voucher-table thead th {background: black; padding:3px; text-align: center; font-size: 12px;} 
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
		 td {font-size: 9px; font-family: tahoma; line-height: 14px; padding: 4px;  } 
		 .rcpt-header { width: 450px; margin: auto; display: block; }
		 .inwords, .remBalInWords { text-transform: uppercase; }
		 .barcode { margin: auto; }
		 /*h3.invoice-type {font-size: 20px; width: 209px; line-height: 24px;}*/
		 .extra-detail span { background: #7F83E9; color: white; padding: 5px; margin-top: 17px; display: block; } 
		 .nettotal { color: red; }
		 .remainingBalance { font-weight: bold; color: blue;}
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
		 /*new css*/
		 .search_filter td {
    /*border: 1px solid black;*/
    color: white;
    font-weight: 600;
    
}
.search_filter td {
    /*border: 1px solid;*/
    /*background: #6c85e5 !important;*/
    color: black;
    /*font-weight: bold;*/
}
.search_finalsum td {
    /*border: 1px solid;*/
    /*background: #f5deb3 !important;*/
    color: black;
    /*/font-weight: bold;*/
    text-align:center;
}

.txtbold { font-weight: bolder; } 
.shadowhead { border-bottom: 0px solid black; padding-bottom: 5px; } 
.dthead th{
    font-weight: 600;
    /*color:black;*/
}

.table {
    width: 100%;
    margin-bottom: 1rem;
    color: #7286a2;
}
/*.table-bordered {*/
/*    border: 1px solid ;*/
/*}*/
.search_filter td {
    /*border: 1px solid black;*/
    color: white;
    font-weight: 600;
    
}
.pdf-header img{
  position: absolute;
}

.invoice-number {
  padding-top: .17in;
  margin-left:50px;
}
.for {
  /*position: absolute;*/
  top: 1.5in;
  left: .5in;
  width: 2.5in;
}
.for p{
    padding-top:0 !important;
    padding-bottom:0 !important;
    font-size:10px;
}
p span{
    font-size:12px;
}
.from {
  /*position: absolute;*/
  top: 1.5in;
  right: .5in;
  width: 2.5in;
  
}
.from p{
    font-size:10px;
    padding-top:0 !important;
    padding-bottom:0 !important;
    border: 1px solid;
}
/*.printRemove{*/
/*    border 1px ;*/
/*}*/
th {
  /*border: 1px solid black;*/
  width:10% !important;
  color:white !important;
  background:black;
}
td {
  border: 1px solid black;
  /*width:10% !important;*/
}
/*table {*/
/*  width: 100%;*/
/*  border-collapse: collapse;*/
/*}*/
#list td{
    border-collapse: collapse;
    border-top:0;
    border-bottom:0;
    color:black;
    width:10% !important;
    text-align:center;
    font-size: 12px;
}
#list{
    color:black;
}
@media print{
    .centered{
        border:1px solid;
        width:35%;
    }

.bel{
position:fixed;
                bottom: 0;
                font-size:12px;
                padding-top:5px;
                
}
th {
    border: 1px solid #fff;
  /*border: 1px solid black;*/
  width:10% !important;
  color:white !important;
  background:black !important;
}
td {
  border: 1px solid black;
  /*width:10% !important;*/
}
td{
    color:black;
}
.signature-fields th{
    background:#fff;
    color:#000;
}
*{
    margin:5px;
}
}
@media print {
	.for p{
	    border 1px solid !important;
	}
		
		}
</style>
<div class="container" style="padding:5px;">
    <div class="row">
        <div class="pdf-header">
          <img class="company-logo" src="https://erp.mktechsol.com//assets/theme_elements/images/logo-sm.png" style="height:80px;margin-left:40%;">
         <h3 style="text-align:center">A product of Fast-Tech solutions</h3>
      </div>
      <hr>
      
       <span class="for"><br>
            <p style="font-weight:bold;font-size:16px;">Sales Report</p>
            
             <div class="span12 centered">
				 <p style="padding:3px;"><span style="font-weight:bold;">Sale Location </span><span class="fromDate"><?php echo $sale['fld_location']; ?></span><br>
                                         <span style="font-weight:bold;">Shipment # </span><span class="fromDate"><?= $sale['fld_shipment'];?></span><br>
                                         <span style="font-weight:bold;">Voucher # </span><span class="fromDate"><?php echo $sale['fld_voucher_no']; ?></span><br>
                                         <span style="font-weight:bold;">Invoice </span><span class="fromDate"><?php echo $sale['fld_invoice_no']; ?></span><br>
                                        <span style="font-weight:bold;">Vehicle no #</span>&nbsp;<span class="fromDate"><?php echo $sale['fld_vehicle_no']; ?></span><br>
                                        </p>
								<br>
				</div>
        </span>

      <div class="from" style="float:right; margin-top:-17%;">
        
        <h3 style="padding-left:0; margin-bottom:0 !important;">Generated Report Details</h3>
         <p><span style="font-weight:bold;padding-left:0; margin-bottom:0 !important;">&nbsp;Billing For :</span>&nbsp; <?= $sale['fld_customer_name'];?><br>
                                    <span style="font-weight:bold;">&nbsp;Billing Date :</span>&nbsp;  <?= date('d-m-y',strtotime($sale['fld_sale_date']));?><br>
                                    <span style="font-weight:bold;">&nbsp;Generated on:</span>&nbsp;<?= date('d - M - Y'); ?>, <?= date('h:i A'); ?><br>
                                    <span style="font-weight:bold;">&nbsp;Login:</span>&nbsp; <?= $this->session->userdata('user_name'); ?></p><br>
           <br>
      </div>

      
    </div>
    
</div>
<hr>
<div class="span12" style="text-align:center">
<!--<h3 class="text-center shadowhead txtbold">Purchase Report</h3>-->
<!--<h3 class="text-center AccName txtbold">.</h3>-->


<!--<p class="text-center"><span class="from"><strong>From:-</strong><span class="fromDate"><?//= date('d/m/Y',strtotime($get['form']))?></span></span> To <span class="to"><strong>To:-</strong><span class="toDate"><?//= date('d/m/Y',strtotime($get['to']))?></span></span></p>-->
</div>
<div class="container-fluid" style="padding:5px;">
		 <div class="row-fluid">
<table id="datatable" class="table " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
	<thead class="dthead">
	<tr>
		<th>SL.</th>
		<th>Product Name</th>
		<th class="text-center">Qty</th>
		<th class="text-center">Weight</th>
		<th class="text-center">Rate</th>
		<th class="text-center">Discount</th>
		<th class="text-center">Total Amount</th>
	</tr>
	</thead>


	<tbody class="purchaseRows" id="purchaseRows">
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
													<?php $i++; }?>
													</tbody>
		<tfoot>
											    	<tr>
													<td class="text-right" colspan="6"><b>Total Discount:</b></td>
													<td class="text-center"><b><?= $sale['fld_total_discount'];?></b></td>
												</tr>
												<tr>
													<td class="text-right" colspan="6"><b>Total:</b></td>
													<td class="text-center"><b><?= $sale['fld_grand_total_amount'];?></b></td>
												</tr>
													
																																			</tfoot>
		
		
		<?php }else{?>
		<tr><td colspan="10" style="text-align:center;">Sorry No Record Found</td></tr>
		<?php }
		?>
	
	</tbody>
</table>
</div>
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
									<th id="sign" style="    background-color : white !important;border-top: 1px solid black; border-left: 1px solid white; border-right: 1px solid white; border-bottom: 1px solid white;">Prepared By</th>
									<th id="sign1" style="    background-color : white !important;    border-top: 1px solid white;"></th>
									<!--<th id="sign2"style="    background-color: white !important;border-top: 1px solid black; border-left: 1px solid white; border-right: 1px solid white; border-bottom: 1px solid white;">Received By</th>-->
									<th id="sign" style="    background-color : white !important;border-top: 1px solid black; border-left: 1px solid white; border-right: 1px solid white; border-bottom: 1px solid white;">Received By</th>

								</tr>
							</thead>
						</table>
					</div>
				</div>
						</div>
						 <p class="bel" style="font-style: italic;"><span style="font-weight:bold">Note:</span> This is auto generated report and requires signature from the approval authority.</p>
	<!--</div> -->
	<script type="text/javascript" src="<?= base_url();?>/assets/theme_elements/js/jquery.min.js"></script>
	<!--<script src="../../../assets/js/handlebars.js"></script>-->


</body>
</html>
