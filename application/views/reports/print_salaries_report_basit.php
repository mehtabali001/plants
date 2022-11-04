<!DOCTYPE html>
<html>
<head>
	<title>Salaries Report</title>

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
	

	<div class="container-fluid" style="margin-top:10px;">
		 <div class="row-fluid">
			<div class="span12 centered">
				 
				</div>
				<div class="row-fluid">
					<div class="span12 centered">
						<div class="row-fluid">
							<div class="span12">
								
								<p class="text-center"><span class="from"><strong>Filter : </strong><span class="fromDate"><?=$filter; ?></span></span></p>
								<p class="text-center"><span class="from"><strong>Month: </strong><span class="fromDate"><?php echo implode(",", $_GET['month']); ?></span></span></p>
								<p class="text-center"><span class="from"><strong>Year: </strong><span class="fromDate"><?=$_GET['year']; ?></span></span></p>
								<br>
								<br>
								
								<table  class="table table-bordered dt-responsive nowrap" class="voucher-table" >
	<thead class="dthead" id="htmlRows1">
	<tr>
		<th>Sr#</th>
		<th>Month</th>
		<th>Year</th>
		<th>Full Name</th>
		<th>Designation</th>
		<th>Location</th>
		<th>Present Days</th>
		<th>Absent Days</th>
		<th>Basic Salary</th>
		<th>Bonus</th>
		<th>Deduction</th>
		<th>Total</th>
	</tr>
	</thead>

    <?php if($_GET['filter'] == 'employeewise'){ ?>
    <tbody class="salaryRow" id="htmlRows">
		 <?php if($salary){
			 $i=1;
			 $b=1;
			foreach($salary as $seler){
			?>
		
				<?php
				$mtqty=0;
				$kgqty=0;
				$total_amount=0;
				foreach($seler['detail'] as $selerdet){
					
					?>
					<tr>
						<td ><?php echo $i;?></td>
						<td ><?php echo $selerdet['month']?></td>
						<td ><?php echo date('Y', strtotime($selerdet['dateCreated']));?></td>
						<td ><?php echo $selerdet['full_name']?></td>
						<td ><?php echo $selerdet['designation_name'];?></td>
						<td ><?php echo $selerdet['fld_location'];?></td>
						<td ><?php echo $selerdet['present_days'];?></td>
						<td ><?php echo $selerdet['absent_days'];?></td>
						<td ><?php echo $selerdet['basic_salary'];?></td>
						<td ><?php echo $selerdet['bonus'];?></td>
						<td ><?php echo $selerdet['deduction'];?></td>
						<td ><?php 
						    $perdaysalary = (int) $selerdet['basic_salary'] / 30;
						    $basic_salary = $perdaysalary * $selerdet['present_days'];
							echo (int) $basic_salary + (int) $selerdet['bonus']- (int) $selerdet['deduction'];?></td>
					
					</tr>
					<?php $i++; }?>
		
		
		<?php
		$b++;
		}}else{?>
		<tr><td colspan="10" style="text-align:center;">No Record Found</td></tr>
		<?php }
		?>
	
	
    <?php }else{ ?>
		 <?php if($salary){
			 $i=1;
			 $b=1;
			foreach($salary as $seler){
			?>
		<tr class="search_filter">
			<!--<td style="display:none;"></td>-->
			<td colspan="12" style="padding-left: 24%;"><?php echo $seler['filter_text'];?></td>
			<!--<td style="display:none;"></td>-->
			<!--<td style="display:none;">Search</td>-->
			<!--<td style="display:none;"></td>-->
			<!--<td style="display:none;">New</td>-->
			<!--<td style="display:none;"></td>-->
			<!--<td style="display:none;"></td>-->
			<!--<td style="display:none;"></td>-->
			<!--<td style="display:none;">Test</td>-->

		</tr>
		
		<tr>

				<?php
				$mtqty=0;
				$kgqty=0;
				$total_amount=0;
				foreach($seler['detail'] as $selerdet){
					
					?>
					<tr>
						<td ><?php echo $i;?></td>
						<td ><?php echo $selerdet['month']?></td>
						<td ><?php echo date('Y', strtotime($selerdet['dateCreated']));?></td>
						<td ><?php echo $selerdet['full_name']?></td>
						<td ><?php echo $selerdet['designation_name'];?></td>
						<td ><?php echo $selerdet['fld_location'];?></td>
						<td ><?php echo $selerdet['present_days'];?></td>
						<td ><?php echo $selerdet['absent_days'];?></td>
						<td ><?php echo $selerdet['basic_salary'];?></td>
						<td ><?php echo $selerdet['bonus'];?></td>
						<td ><?php echo $selerdet['deduction'];?></td>
						<td ><?php 
						    $perdaysalary = (int) $selerdet['basic_salary'] / 30;
						    $basic_salary = $perdaysalary * $selerdet['present_days'];
							echo (int) $basic_salary + (int) $selerdet['bonus']- (int) $selerdet['deduction'];?></td>
					
					</tr>
					<?php $i++; }?>
				
		
		<?php
		$b++;
		}}else{?>
		<tr><td colspan="10" style="text-align:center;">No Record Found</td></tr>
		<?php }
		?>
	
	</tbody>
	<?php } ?>
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