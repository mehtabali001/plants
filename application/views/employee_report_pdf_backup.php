<style>
		body {
    background-color: #ffffff;
}
		 * { margin: 5px; padding: 5px; font-family: serif; }
		 body { font-size:12px; }
		 p { margin: 0; /* line-height: 17px; */ }
		table { width: 100%; border: 1px solid black; border-collapse:collapse; table-layout:fixed; border-collapse: collapse; }
		@media print {
		th { border: 1px solid #fff; padding: 5px; font-size:9px;color:#fff; transition: none !important; -webkit-print-color-adjust: exact; text-align:left; }
		
		}
		th { border: 1px solid #fff; padding: 5px; font-size:9px;color:#fff;text-align:left;}
		td { /*text-align: center;*/ vertical-align: center; /*padding: 5px 10px;*/ border-left: 1px solid black;border-bottom: 1px solid; font-size:9px;}
		@media print {
		 	td { /*text-align: center;*/ vertical-align: center; /*padding: 5px 10px;*/ border-left: 1px solid black;border-bottom: 1px solid; font-size:9px;}
		 	
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
		 /*new css*/
		 .search_filter td {
    /*border: 1px solid black;*/
    color: white;
    font-weight: 600;
    
}
.pdf-header img{
  position: relative;
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
  width: 2.9in;
  
}
.span12 p{
    font-size:10px;
    padding-top:2px !important;
    padding-left:2px !important;
    padding-bottom:2px !important;
    border: 1px solid;
    width:270px;
}
.from p{
    font-size:10px;
    padding-top:2px !important;
    padding-bottom:2px !important;
    border: 1px solid;
}
@media print{

.bel{
position:fixed;
                bottom: 0;
                font-size:12px;
                padding-top:5px;
                
}
.dthead th{
    border: 1px solid #fff;
}
th {
  border: 1px solid black;
  width:10% !important;
  color:white !important;
  background:black ;
}
#sign{
    background-color : white !important;color:black;border-top: 1px solid black; border-left: 1px solid white; border-right: 1px solid white; border-bottom: 1px solid white;
}
#sign1{
    background-color : white !important;    border-top: 1px solid white; display:none;
}
#sign2 th{
    background-color : white !important; color:#fff; border-top: 1px solid #fff; 
}
td {
  border: 1px solid black;
  /*width:10% !important;*/
}
*{
    padding:5px;
}
}

	</style>

<div class="container" style="padding:5px;">
    <div class="row">
        
        <span class="for"><br>
            <img class="company-logo" src="https://erp.mktechsol.com//assets/custom_elements/images/logo.png" style="height:80px;">
								<br>
				</div>
        </span>

      <div class="from" style="float:right; margin-top:-11%;">
        
        <h3 style="padding-left:0; margin-bottom:0 !important;">Generated Report Details</h3>
        <p><span style="font-weight:bold;">&nbsp;Report Type:&nbsp; Employee Report </span><br><span style="font-weight:bold;">&nbsp;Showing Report As:&nbsp; <?php echo str_replace('_', ' ', $_GET['filter']); ?></span><br><span style="font-weight:bold;">&nbsp;Generated on:</span>&nbsp; <?= date('d - M - Y'); ?>, <?= date('h:i A'); ?><br>
        <?/*?><span style="font-weight:bold;">&nbsp;Time:</span>&nbsp; <?= date('h:i A'); ?><br><?*/?>
        <span style="font-weight:bold;display: inline-block;">&nbsp;Login:</span>&nbsp; <?= $this->session->userdata('user_name'); ?></p>
           <br>
      </div>
      
    </div>
    
</div>
<div class="container-fluid" style="padding:5px;">
		 <div class="row-fluid">

<table class="table " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
	<thead class="dthead">
	    <tr>
            <th>Employee Code</th>
            <th>Name</th>
            <th>Role</th>
            <th>Cnic No.</th>
            <th>Contact No.</th>
            <th>Joining Date</th>
        </tr>
	</thead>
	<tbody id="employee_data" class="employee_data">
                        <?php 
                            if($employees){
                            foreach($employees as $emp){ 
                            
                        ?>
                        <tr class="search_filter">
                			<td colspan="6" style="padding-left: 24%; font-weight:bold;color:black;"><?php echo $emp['filter_text'];?></td>
                		</tr>
                		<?php 
                		foreach($emp['detail'] as $empdet){ ?>
                        <tr>
                            <td><?= $empdet['employee_code'];?></td>
                            <td><?= $empdet['full_name'];?></td>
                            <td><?= $empdet['designation_name'];?> at <?= $empdet['fld_location'];?> in <?= $empdet['department_name'];?></td>
                            <td><?= $empdet['cnic'];?></td>
                            <td><?= $empdet['mobile_no'];?></td>
                            <td><?= $empdet['joining_date'];?></td>
                        </tr>
                        
                        <?php }}} else{?>
		<tr><td colspan="6" style="text-align:center;color:red;">Sorry No Record Found</td></tr>
		<?php } ?>
                        
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
				<br>
				<div class="row-fluid">
					<div class="span12">
						<table class="signature-fields">
							<thead>
								<tr>
									<th id="sign" style="background-color : white !important;border-top: 1px solid black; border-left: 1px solid white; border-right: 1px solid white; border-bottom: 1px solid white;">Prepared By</th>
									<!--<th id="sign1" style="background-color : white !important;border-top: 1px solid white;"></th>-->
									<!--<th id="sign2"style="background-color: white !important;border-top: 1px solid black; border-left: 1px solid white; border-right: 1px solid white; border-bottom: 1px solid white;">Received By</th>-->
									<th id="sign" style="background-color:white !important;border-top: 1px solid black; border-left: 1px solid white; border-right: 1px solid white; border-bottom: 1px solid white;">Received By</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
</div>
		 <p class="bel" style="font-style: italic;"><span style="font-weight:bold">Note:</span> This is auto generated report and requires signature from the approval authority.</p>

