<!DOCTYPE html>
<html>
<head>
	<title>Daybook Report </title>

	<link rel="stylesheet" href="http://localhost/erpkotal/assets/theme_elements/css/bootstrap.min.css">
	<link rel="stylesheet" href="http://localhost/erpkotal/assets/custom_elements/css/bootstrap-responsive.min.css">

	<style>
		body {
    background-color: #ffffff;
}
		 * { margin: 0; padding: 0; font-family: serif; }
		 body { font-size:12px; }
		 p { margin: 0; /* line-height: 17px; */ }
		table { width: 100%; border: 1px solid black; border-collapse:collapse; table-layout:fixed; border-collapse: collapse;position: relative;
    top: 1.4in; }
		th {background:#000 !important; border: 1px solid #ffffff; padding: 5px;width:10%;color: #fff;}
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
  top: 0.5in;
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
  top: 0.5in;
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
<body>
	<div class="container-fluid" style="margin-top:10px;">
		
				<div class="row-fluid">
					<div class="span12 centered">
						<br>
						<div class="row-fluid">
							<div class="span12">
							      
                                  
                                  <span class="for" style="float:left;">
                                        <img class="company-logo" src="https://erp.mktechsol.com//assets/custom_elements/images/logo.png" style="height:80px;">
                                  </span>
                            
                                  <div class="from" style="float:right; margin-top:0%;">
                                    <h3>Generated Report Details</h3>
                                    <p><span style="font-weight:bold;">&nbsp;Report Type:&nbsp; Employee Report </span><br><span style="font-weight:bold;">&nbsp;Showing Report As:&nbsp; <?php echo str_replace('_', ' ', $_GET['filter']); ?> </span><br><span style="font-weight:bold;">&nbsp;Generated on:</span>&nbsp; <?= date('d - M - Y'); ?>, <?= date('h:i A'); ?><br>
                                    <?/*?><span style="font-weight:bold;">&nbsp;Time:</span>&nbsp; <?= date('h:i A'); ?><br><?*/?>
                                    <span style="font-weight:bold;display: inline-block;">&nbsp;Login:</span>&nbsp; <?= $this->session->userdata('user_name'); ?></p><br>
                                  </div>
                                  
								<!--<h3 class="text-center shadowhead txtbold"></h3>
								<h3 class="text-center AccName txtbold">.</h3>
								<p class="text-center"><span class="from"><strong>From:-</strong><span class="fromDate">[0000/00/00]</span></span> To <span class="to"><strong>To:-</strong><span class="toDate">[0000/00/00]</span></span></p>-->
								<table class="voucher-table">
									<thead class="htmlRows1">
									
									</thead>
									<tbody id="htmlRows">
										
									</tbody>
								</table>
								
							</div>
							<div class="span12 htmlCharts">
								
							</div>
						</div>
					</div>
				</div>
				
			<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				<div class="row-fluid" style="padding:5px;margin-top:20%;">
					<div class="span12">
						<table class="signature-fields" style="top:0 !important;">
							<thead>
								<tr>
									<th id="sign" style="  color: #000;  background-color : white !important;border-top: 1px solid black; border-left: 1px solid white; border-right: 1px solid white; border-bottom: 1px solid white;">Prepared By</th>
									<th id="sign1" style="    background-color : white !important;    border-top: 1px solid white;"></th>
									<!--<th id="sign2"style="    background-color: white !important;border-top: 1px solid black; border-left: 1px solid white; border-right: 1px solid white; border-bottom: 1px solid white;">Received By</th>-->
									<th id="sign" style="   color: #000; background-color : white !important;border-top: 1px solid black; border-left: 1px solid white; border-right: 1px solid white; border-bottom: 1px solid white;">Received By</th>

								</tr>
							</thead>
						</table>
					</div>
				</div>
				</div>
		<div class="bel" style="margin-top:2px;"><p style="font-style: italic;"><span style="font-weight:bold;font-style: italic;">Note:</span> This is auto generated report and requires signature from the approval authority.</p></div>
	<script type="text/javascript" src="<?= base_url();?>/assets/theme_elements/js/jquery.min.js"></script>

	<script type="text/javascript">
		$(function(){

			var opener = window.opener;
			
			var etype = opener.$('.form-section').text();
			if (opener.$('#datatable_tb').is(':visible')) {
				// var parentRows = opener.$(".purchaseRows tr");
				// var rowsHtml = '';

				// var parentRows1 = '';
				var parentRows1 = opener.$(".dthead tr").clone();
				$('.htmlRows1').append(parentRows1);
				// $(".htmlRows1").find('.printRemove').remove();
				
				// var netBalance = 0;
				 var parentCopy = opener.$('.employee_data tr').clone();
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
			
// 			window.print();
		});
	</script>
	<script>
	    window.print();
	</script>
</body>
</html>