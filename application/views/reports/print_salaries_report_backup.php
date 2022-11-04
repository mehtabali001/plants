<!DOCTYPE html>
<html>
<head>
	<title>Salaries Report <?php echo date('d - M - y H:i'); ?></title>

	<link rel="stylesheet" href="http://localhost/erpkotal/assets/theme_elements/css/bootstrap.min.css">
	<link rel="stylesheet" href="http://localhost/erpkotal/assets/custom_elements/css/bootstrap-responsive.min.css">

	<style>
		body {
    background-color: #ffffff;
}
		 * { margin: 0; padding: 0; font-family: serif; }
		 /*body { font-size:12px; }*/
		 p { margin: 0; /* line-height: 17px; */ }
		table { width: 100%; border: 1px solid black; border-collapse:collapse; table-layout:fixed; border-collapse: collapse;height:95%; }
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
		 
		 .centered { margin: auto; }
		 @page{margin:10px auto !important; }
		 .rcpt-header { margin: auto; display: block; }
		 td:first-child { text-align: left; }
	
		.subsum_tr td, .netsum_tr td { border-top:1px solid black !important; border-bottom:1px solid black;    font-family: serif; }

		.hightlight_tr td {border-top: 1px solid black; border-left:0 !important; border-right: 0 !important; border-bottom: 1px solid black; background: rgb(226, 226, 226); color: black; font-family: serif;}
		.finalsum td {border-top: 1px solid black; border-left:0 !important; border-right: 0 !important; border-bottom: 1px solid black; background: rgb(250, 250, 250); color: black;font-family: serif; }
		 .field {font-weight: bold; display: inline-block; width: 80px;font-family: serif; } 
		 .voucher-table thead th {background: #ccc; padding:3px; text-align: center; font-size: 12px;font-family: serif;} 
		 tfoot {border-top: 1px solid black;font-family: serif; } 
		 .bold-td { font-weight: bold; border-bottom: 1px solid black;font-family: serif;}
		 .nettotal { font-weight: bold; font-size: 14px; border-top: 1px solid black;font-family: serif; }
		 .invoice-type { border-bottom: 1px solid black;font-family: serif; }
		 .relative { position: relative;font-family: serif; }
		 .signature-fields{ border: none; border-spacing: 20px; border-collapse: separate;font-family: serif;} 
		 .signature-fields th {border: 0px; border-top: 1px solid black; border-spacing: 10px;font-family: serif; }
		 .inv-leftblock { width: 280px;font-family: serif; }
		 .text-left { text-align: left !important; font-family: serif;}
		 .text-right { text-align: right !important;font-family: serif; }
		 td {font-size: 9px; font-family: tahoma; line-height: 14px; padding: 4px; font-family: serif; } 
		 .rcpt-header { width: 450px; margin: auto; display: block; font-family: serif;}
		 .inwords, .remBalInWords { text-transform: uppercase;font-family: serif; }
		 .barcode { margin: auto;font-family: serif; }
		 h3.invoice-type {font-size: 20px; width: 209px; line-height: 24px;font-family: serif;}
		 .extra-detail span { background: #7F83E9; color: white; padding: 5px; margin-top: 17px; display: block; font-family: serif;} 
		 .nettotal { color: red; font-family: serif;}
		 .remainingBalance { font-weight: bold; color: blue;font-family: serif;}
		 .centered { margin: auto; font-family: serif;}
		 p { position: relative;font-family: serif; }
		 .fieldvalue.cust-name {position: absolute; width: 497px;font-family: serif; } 
		 .shadowhead { border-bottom: 0px solid black; padding-bottom: 5px;font-family: serif; } 
		 .AccName { border-bottom: 0px solid black; padding-bottom: 5px; font-size: 16px;font-family: serif; } 

		 .txtbold { font-weight: bolder;font-family: serif; } 
		 .uomStock{ width: 70px !important;font-family: serif; }
		 .srStock{ width : 30px !important;font-family: serif;}
		 .descriptionStock{ width : 200px !important;font-family: serif;}
		 .qtyStock{ width : 70px !important;}
		 .headingBold{ font-weight: bold; font-size: 11px !important; font-family: serif; }
		 /*new css*/
		 .search_filter td {
    /*border: 1px solid black;*/
    color: white;
    font-weight: 600;
    font-family: serif;
    
}
.pdf-header img{
  position: relative;
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
    font-size:8px;
    font-family: serif;
}
p span{
    font-size:12px;
    font-family: serif;
}
.from {
  /*position: absolute;*/
  top: 1.5in;
  right: .5in;
  width: 2.5in;
  
}
.span12 p {
    font-size:8px;
    padding-top:2px !important;
    padding-left:2px !important;
    padding-bottom:2px !important;
    border: 1px solid;
    width:230px;
    font-family: serif;
}
span12 p span{
    font-size:8px;
    font-family: serif;
}
.from p{
    font-size:8px;
    padding-top:2px !important;
    padding-bottom:2px !important;
    border: 1px solid;
    font-family: serif;
}
@media print{
/*.bel{*/
/*    position:fixed;*/
/*    bottom: 5px;*/
/*    font-size:10px;*/
/*    margin-top:20px;*/
    /*padding-top:4px;*/
    /*margin-top: 5px;*/
                
/*}*/
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
/*@media print*/
/*{*/
/*  table { page-break-after:auto }*/
/*  tr    { page-break-inside:avoid; page-break-after:auto }*/
/*  td    { page-break-inside:avoid; page-break-after:auto }*/
/*  thead { display:table-header-group }*/
/*  tfoot { display:table-footer-group }*/
/*}*/

	</style>
</head>
<body>
    <div class="container">
    <div class="row">
        <div class="pdf-header">
          <img class="company-logo" src="http://erp.techamore.us//assets/theme_elements/images/logo-sm.png" style="height:80px;margin-left:40%;">
         <h3 style="text-align:center">A product of Fast-Tech solutions</h3>
      </div>
      <hr>
        <span class="for"><br>
            <p style="font-weight:bold;font-size:14px;">Salary Report</p>
            <?php
                $filter = '';
                if($_GET['filter']=='employeewise'){
                   $filter = 'Employee Wise'; 
                }elseif($_GET['filter']=='designationwise'){
                    $filter = 'Designation Wise';
                }elseif($_GET['filter']=='plantwise'){
                    $filter = 'Plant Wise';
                }
            ?>
             <p>
        </span>

      <div class="from" style="float:right; margin-top:-2.8%;">
        
         <line style="font-weight:bold;font-size:14px; padding-left:0">Generated Report Details</line>
        <p><span style="font-weight:bold; font-size:10px">&nbsp;Generated on:</span>&nbsp; <?= date('d - M - Y'); ?>, <?= date('h:i A'); ?><br>
        <span style="font-weight:bold; font-size:10px">&nbsp;Login:</span>&nbsp; <?= $this->session->userdata('user_name'); ?></p>
           
      </div>
    </div>
    
</div>
<div class="container tale data-print-table" style="">
		 
				<div class="row-fluid ">
					<div class="span12 centered">
						<div class="row-fluid">
							<div class="span12">
								
								<p class="text-center"><span style="font-weight:bold; font-size:10px">Showing Report As : </span><span class="fromDate" ><?=$filter; ?>, <?php if($type==1){ echo 'Detailed';}else{echo 'Summary';} ?></span></span><br>
								<span style="font-weight:bold; font-size:10px">Month: </span><span class="fromDate" ><?php echo implode(",", $_GET['month']); ?>,<?=$_GET['year']; ?></span></p>
								<!--<p class="text-center"><span class="from"><strong>Year: </strong><span class="fromDate"></span></span></p>-->
								<br>
								
								
								<table  class="table table-responsive" class="voucher-table" style="margin-top:px">
                                	<thead class="dthead" id="htmlRows1">
                                	<tr>
                                	    <?php if($type==1){ ?>
                                	    
                                		<th style="width: 4%;">#</th>
                                		<th style="width: 7%;">MmYy</th>
                                		<th>Emp ID</th>
                                		<th>Name</th>
                                		<th>Designation</th>
                                		<th>Plant</th>
                                		<th style="width: 7%;">Present Days</th>
                                		<th style="width: 7%;">Absent Days</th>
                                		<th style="width: 7%;">Basic Salary (Pkr)</th>
                                		<th style="width: 7%;">Bonus (Pkr)</th>
                                		<th style="width: 8%;">Deduction (Pkr)</th>
                                		<th style="width: 7%;">Total (Pkr)</th>
                                		
                                		<?php }else{ ?>
                                		
                                		<th style="width: 4%;">Sr#</th>
                                		<th style="width: 24%;">Month</th>
                                		<th style="width: 24%;">Emp ID</th>
                                		<th>Name</th>
                                		<th style="width: 24%;">Total (Pkr)</th>
                                		
                                		
                                		<?php } ?>
                                	</tr>
  </thead>

                                    <?php if($_GET['filter'] == 'employeewise'){ ?>
                                    <tbody class="salaryRow" id="htmlRows">
                                		 <?php if($salary){
                                			 $i=1;
                                			 $b=1;
                                			 $total_amount=0;
                                			foreach($salary as $seler){
                                			?>
                                		
                                				<?php
                                				$mtqty=0;
                                				$kgqty=0;
                                				
                                				foreach($seler['detail'] as $selerdet){
                                					
                                					?>
                                					<tr>
                                					    
                                						<td ><?php echo $i;?></td>
                                						<td ><?php echo date('M', strtotime($selerdet['month']));?> - <?php echo date('y', strtotime($selerdet['year']));?></td>
                                						<td ><?php echo $selerdet['employee_code']?></td>
                                						<td ><?php echo $selerdet['full_name']?></td>
                                						<?php if($type==1){ ?>
                                						<td ><?php echo $selerdet['designation_name'];?></td>
                                						<td ><?php echo $selerdet['fld_location'];?></td>
                                						<td ><?php echo $selerdet['present_days'];?></td>
                                						<td ><?php echo $selerdet['absent_days'];?></td>
                                						<td ><?php echo $selerdet['basic_salary'];?></td>
                                						<td ><?php echo $selerdet['bonus'];?></td>
                                						<td ><?php echo $selerdet['deduction'];?></td>
                                						<?php } ?>
                                						<td ><?php 
                                						    $perdaysalary = (int) $selerdet['basic_salary'] / 30;
                                						    $basic_salary = $perdaysalary * $selerdet['present_days'];
                                							echo $totalSel = (int) $basic_salary + (int) $selerdet['bonus']- (int) $selerdet['deduction'];?></td>
					
                                					</tr>
                                					<?php $i++; $total_amount += $totalSel;}?>
                                		
                                		
                                		<?php
                                		$b++;
                                		} ?>
                                			<tr>
                                        		<td colspan="<?php if($type==1){ echo '11'; }else{ echo '4'; } ?>" style="text-align:right;font-weight:bold">Net Amount (Pkr): </td>
                                        		<td style="font-weight:bold"><?php echo $total_amount; ?></td>
                                    		</tr>
		                                <?php
                                		
                                		}else{?>
                                		<tr><td colspan="10" style="text-align:center;">No Record Found</td></tr>
                                		<?php }
                                		?>
                                	
                                	
                                    <?php }else{ ?>
                                    
                                		 <?php if($salary){
                                			 $i=1;
                                			 $b=1;
                                			 $total_amount=0;
                                			foreach($salary as $seler){
                                			?>
                                		<tr class="search_filter">
                                			<!--<td style="display:none;"></td>-->
                                			<td class="des" colspan="<?php if($type==1){ echo '12'; }else{ echo '5'; } ?>" style="padding-left: 24%;color: #000; font-weight:bold;"><?php echo $seler['filter_text'];?></td>
                                			<!--<td style="display:none;"></td>-->
                                			<!--<td style="display:none;">Search</td>-->
                                			<!--<td style="display:none;"></td>-->
                                			<!--<td style="display:none;">New</td>-->
                                			<!--<td style="display:none;"></td>-->
                                			<!--<td style="display:none;"></td>-->
                                			<!--<td style="display:none;"></td>-->
                                			<!--<td style="display:none;">Test</td>-->
                                
                                		</tr>
                                		
                                
                                				<?php
                                				$mtqty=0;
                                				$kgqty=0;
                                				foreach($seler['detail'] as $selerdet){
                                					
                                					?>
                                					<tr>
                                						<td ><?php echo $i;?></td>
                                						<td ><?php echo date('M', strtotime($selerdet['month']));?>-<?php echo date('y', strtotime($selerdet['year']));?></td>
                                						<td ><?php echo $selerdet['employee_code']?></td>
                                						<td ><?php echo $selerdet['full_name']?></td>
                                						<?php if($type==1){ ?>
                                						<td ><?php echo $selerdet['designation_name'];?></td>
                                						<td ><?php echo $selerdet['fld_location'];?></td>
                                						<td ><?php echo $selerdet['present_days'];?></td>
                                						<td ><?php echo $selerdet['absent_days'];?></td>
                                						<td ><?php echo $selerdet['basic_salary'];?></td>
                                						<td ><?php echo $selerdet['bonus'];?></td>
                                						<td ><?php echo $selerdet['deduction'];?></td>
                                						<?php } ?>
                                						<td ><?php 
                                						    $perdaysalary = (int) $selerdet['basic_salary'] / 30;
                                						    $basic_salary = $perdaysalary * $selerdet['present_days'];
                                							echo $totalSel = (int) $basic_salary + (int) $selerdet['bonus']- (int) $selerdet['deduction'];?></td>
					
                                					</tr>
                                					<?php $i++; $total_amount += $totalSel;}?>
                                				
                                		
                                		<?php
                                		$b++;
                                		}
                                		
                                		?>
                                			<tr>
                                        		<td colspan="<?php if($type==1){ echo '11'; }else{ echo '4'; } ?>" style="text-align:right;font-weight:bold">Net Amount (Pkr): </td>
                                        		<td style="font-weight:bold;"><?php echo $total_amount; ?></td>
                                    		</tr>
                                		
                                		<?php }else{?>
                                		<tr><td colspan="10" style="text-align:center;">No Record Found</td></tr>
                                		<?php }
                                		?>
                                	
                                	</tbody>
                                	<?php } ?>
                                </table>
								
							</div>
						</div>
					</div>
				</div>
	
		 </div>
    <div class="bel" style="margin-top:2px;"><p style="font-style: italic;"><span style="font-weight:bold;font-style: italic;">Note:</span> This is auto generated report and requires signature from the approval authority.</p></div>
	<!--</div> -->
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