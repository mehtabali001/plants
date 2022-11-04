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
							      
                                  <table class="table table-borderless" style="width: -webkit-fill-available;">
                                    <tbody>
                                        <tr>
                                            <td style="width:60%;text-align:left">
                                                <? $settings=$this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row_array();?>
                                                <img class="company-logo" src="<?=base_url()?>/assets/uploads/logo/<?=$settings['system_logo'];?>" style="height:70px;float:left;">
                                            </td>
                                            <td>
                                                <div class="detail text-left" >
                                                    <span style="font-weight:bold;font-size:10px;">Type : </span><span class="" style="font-size:10px;">Salary Report</span></span><br>
                                                    <span style="font-weight:bold;font-size:10px;">Showing Report As : </span><span class="fromDate"  style="font-size:10px"><?=$filter; ?>, <?php if($type==1){ echo 'Detailed';}else{echo 'Summary';} ?></span></span><br>
							                    	<span style="font-weight:bold;font-size:10px;">Date: </span><span class="fromDate" style="font-size:10px" ><?php echo date("d/m/Y", strtotime($_GET['from_date'])); ?> to <?php echo date("d/m/Y", strtotime($_GET['to_date'])); ?></span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

<hr style="width:100%;">
								
								<table id="datatable_tb" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;margin-top: 5%;">
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