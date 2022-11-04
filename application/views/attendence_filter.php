<style>

.search_filter td {
    border: none !important;
    background: #f1f5fa;
    color: #000;
    font-weight: bold;
}
.search_finalsum td {
    border: none !important;
    /*background: rgb(245 222 179) !important;*/
    color: white;
    font-weight: bold;
}
@media only screen and (max-width: 600px) {
.page-title-box{
    display:none;
}
#datatable_tb_length label{
    width:100%;
}
#datatable_tb_filter{
   width:100%; 
}
#datatable_tb_filter label{
   width:100%; 
}
}
</style>
<? $role_permissions  = explode(",",$this->session->userdata('permissions')); ?>
<?php if($attendence){ ?>
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right" style="margin-bottom: 15px;">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                    <? if(!empty($role_permissions) && in_array(283,$role_permissions)) { ?>
                    <a type="button" id="print_report" class="btn btn-outline-primary print_report" name="" value="" disabled ><i class="fa fa-print" aria-hidden="true"></i>&nbsp;Print</a>
					<? } ?>	
					<? if(!empty($role_permissions) && in_array(284,$role_permissions)) { ?>
                    <a type="button" id="pdf_report" class="btn btn-outline-primary pdf_report" name="" value="" disabled><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;PDF</a>
					<? } ?>	
					<? if(!empty($role_permissions) && in_array(285,$role_permissions)) { ?>
					 <a type="button" id="employee_report_csv" class="btn btn-outline-primary pdf_employee_report" disabled onclick="downloadcsv();"><i class="fa fa-file-csv" aria-hidden="true"></i>&nbsp;CSV</a>
                    <? } ?>
                </div>
			</div>
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<? } ?>
<?php //if($filter_type == 1){?>
<table id="datatable_tb" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
	<thead class="dthead tabletop">
	<tr>
		 <th>Date</th>
        <th>Name</th>
		<th>Plant</th>
        <th>Designation</th>
		<th>In Time</th>
		<th>Out Time</th>
		<th>Status</th>
	</tr>
	</thead>


	<tbody class="purchaseRows" id="purchaseRows">
		 <?php if($attendence){
			 $i=1;
			 $b=1;
			foreach($attendence as $purch){
			?>
		<tr class="search_filter">
			<td colspan="7" style="padding-left: 24%;"><?php echo $purch['filter_text'];?></td>
			<td style="display:none"></td>
			<td style="display:none"></td>
			<td style="display:none"></td>
			<td style="display:none"></td>
			<td style="display:none"></td>
			<td style="display:none"></td>

		</tr>
				<?php
				foreach($purch['detail'] as $purdet){
					$designation =	$this->Common_model->select_single_field('designation_name','tbl_designation',array('id'=>$purdet['designation']));
					$plant       =	$this->Common_model->select_single_field('fld_location','tbl_locations',array('fld_id'=>$purdet['plants']));
					$name        =	$this->Common_model->select_single_field('full_name','tbl_employees',array('id'=>$purdet['user_id']));
					
					if($purdet['attendance_status'] == 'Present'){
					    $color = "color:green";
					}elseif($purdet['attendance_status'] == 'Absent'){
					    $color = "color:red";
					}elseif($purdet['attendance_status'] == 'Sick Leave'){
					    $color = "color:#506ee4";
					}elseif($purdet['attendance_status'] == 'Short Leave'){
					    $color = "color:#506ee4";
					}else{
					    $color = "color:green";
					}
					
					?>
					<tr>
						<td ><?php echo date('d-m-Y',strtotime($purdet['attendance_date']));?></td>
						<td><?=$name;?></td>
						<td><?=$plant;?></td>
                        <td><?=$designation;?></td>
                        <td data-name="check_in" class="check_in" data-type="text" data-pk="<?=$purdet['attendance_id'];?>"> 
						  <?php if($purdet['attendance_status'] == 'Present'){
						      echo $purdet['check_in'];
    					    }elseif($purdet['attendance_status'] == 'Short Leave'){
    					        echo $purdet['check_in'];
    					    } ?>
						</td>
							<td data-name="check_out" class="check_out" data-type="text" data-pk="<?=$purdet['attendance_id'];?>">
							 <?php if($purdet['attendance_status'] == 'Present'){
						      echo $purdet['check_out'];
    					    }elseif($purdet['attendance_status'] == 'Short Leave'){
    					        echo $purdet['check_out'];
    					    } ?>
							</td>
                            <td data-name="attendance_status" class="attendance_status" data-type="select" data-pk="<?=$purdet['attendance_id'];?>" style="<?=$color?>">
							  <?=$purdet['attendance_status'];?>
							</td>
						
					</tr>
					<?php $i++; }?>
		
	
		<?php
		$b++;
		}}else{?>
		<tr>
		    <td colspan="7" style="text-align:center;color:red;">Sorry No Record Found</td>
		    <td style="display:none"></td>
		    <td style="display:none"></td>
		    <td style="display:none"></td>
		    <td style="display:none"></td>
		    <td style="display:none"></td>
		    <td style="display:none"></td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<?php //}?>
<script>
  
   function downloadcsv(){
        //  var form = $('#ledgerFilter').serialize();
        var formdata=$('#attendanceFilterForm').serialize();
       var url="<?php echo base_url(); ?>Employees/filterattendence_report_csv?"+formdata;
       window.open(url);
   }
</script>
