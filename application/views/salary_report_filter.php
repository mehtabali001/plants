<style>

.search_filter td {
    border: none !important;
     background: #f1f5fa !important;
     text-align:center;
    color: #000;
    font-weight: bold;
}
.search_finalsum td {
    border: none !important;
    background: rgb(245 222 179) !important;
    color: black;
    font-weight: bold;
}
</style>
<? $role_permissions  = explode(",",$this->session->userdata('permissions')); ?>

<?php if($salary){ ?>
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                    <? if(!empty($role_permissions) && in_array(46,$role_permissions)) { ?>
                    <a type="button" id="print_salaries_report" class="btn btn-outline-primary print_report" disabled><i class="fa fa-print" aria-hidden="true"></i>&nbsp;Print F6</a>
                    <? } ?>
                    <? if(!empty($role_permissions) && in_array(47,$role_permissions)) { ?>
                    <a type="button" id="pdf_salaries_report" class="btn btn-outline-primary pdf_purchase_report" disabled><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;PDF F7</a>
                    <? } ?>
                    <? if(!empty($role_permissions) && in_array(226,$role_permissions)) { ?>
                    <a type="button" id="purchase_report_csv" class="btn btn-outline-primary pdf_purchase_report" disabled  onclick="downloadcsv();"><i class="fa fa-file-csv" aria-hidden="true"></i>&nbsp;CSV</a>
                    <? } ?>
                </div>
			</div>
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<? } ?>
<?php //if($filter_type == 1){?>
<table id="datatable_tb"  class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
	<thead class="dthead tabletop">
	<tr>
		<th>#</th>
		<th>MmYy</th>
		<th>Emp ID</th>
		<th>Name</th>
		<th>Salary</th>
		<th>Paid Via</th>
		<th>Paid From</th>
		<th>Paid Salary</th>
	</tr>
	</thead>

    <?php if($filter == 'employeewise'){ ?>
    <tbody class="salaryRow" id="salaryRow">
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
					$total_amount += (int) $selerdet['amount_paid'];
					?>
					<tr>
						<td ><?php echo $i;?></td>
						<td ><?php echo date('M', strtotime($selerdet['month']));?>-<?php echo date('y', strtotime($selerdet['year']));?><br><?php if($selerdet['salary_status']==1){ ?><span style="color: green;font-size: 10px;font-style: italic;">Paid on <?=date('d/m/y', strtotime($selerdet['paid_date'])); ?></span><?php } ?></td>
						<td ><?php echo $selerdet['employee_code']?></td>
						<td ><?php echo $selerdet['full_name']?><br><?php echo $selerdet['designation_name'];?> at <?php echo $selerdet['fld_location'];?></td>
						<td ><?php echo $selerdet['basic_salary'];?></td>
						<td ><?php echo $selerdet['paid_via'];?></td>
						<td ><?php echo $selerdet['paid_from'];?></td>
						<td ><?php echo $selerdet['amount_paid'];?></td>
					</tr>
					<?php $i++;}?>
		
		
		<?php
		$b++;
		} ?>
		<tr>
    		<td colspan="7" style="text-align:right;color: black;font-weight: 500;">Net Amount (Pkr): </td>
    		<td style="color: black;font-weight: 500;"><?php echo $total_amount; ?></td>
    		<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
		</tr>
		<?php 
		
		}else{?>
		<tr>
		    <td colspan="8" style="text-align:center;color:red;">Sorry No Record Found</td>
		    <td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
		</tr>
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
			<td colspan="8" style=""><?php echo $seler['filter_text'];?></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>

		</tr>
		

				<?php
				$mtqty=0;
				$kgqty=0;
				
					foreach($seler['detail'] as $selerdet){
					$total_amount += (int) $selerdet['amount_paid'];
					?>
					<tr>
						<td ><?php echo $i;?></td>
						<td ><?php echo date('M', strtotime($selerdet['month']));?>-<?php echo date('y', strtotime($selerdet['year']));?></td>
						<td ><?php echo $selerdet['employee_code']?></td>
						<td ><?php echo $selerdet['full_name']?><br><?php echo $selerdet['designation_name'];?> at <?php echo $selerdet['fld_location'];?></td>
						<td ><?php echo $selerdet['basic_salary'];?></td>
						<td ><?php echo $selerdet['paid_via'];?></td>
						<td ><?php echo $selerdet['paid_from'];?></td>
						<td ><?php echo $selerdet['amount_paid'];?></td>
					
					
					</tr>
					<?php $i++;}?>
				
		
		<?php
		$b++;
		} ?>
		
		<tr>
    		<td colspan="7" style="text-align:right;color: black;font-weight: 500;">Net Amount (Pkr): </td>
    		<td style="color: black;font-weight: 500;"><?php echo $total_amount; ?></td>
    		<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
		</tr>
		<?php 
		}else{?>
		<tr>
		    <td colspan="8" style="text-align:center;color:red;">Sorry No Record Found</td>
		    <td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
		</tr>
		<?php }
		?>
	
	</tbody>
	<?php } ?>
</table>
<script>
  
   function downloadcsv(){
        //  var form = $('#ledgerFilter').serialize();
        var formdata=$('#salaryfilter').serialize();
       var url="<?php echo base_url(); ?>Payroll/filter_csv?"+formdata;
       window.open(url);
   }
</script>