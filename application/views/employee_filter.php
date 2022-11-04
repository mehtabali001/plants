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
</style>
<? $role_permissions  = explode(",",$this->session->userdata('permissions')); ?>
<?php if($employees){ ?>
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right" style="margin-bottom: 15px;">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                    
                    <? if(!empty($role_permissions) && in_array(223,$role_permissions)) { ?>
                    <a type="button" id="print_report" class="btn btn-outline-primary print_report" name="" value="" disabled><i class="fa fa-print" aria-hidden="true"></i>&nbsp;Print</a>
                    <? } ?>
                    <? if(!empty($role_permissions) && in_array(224,$role_permissions)) { ?>
                    <a type="button" id="pdf_report" class="btn btn-outline-primary pdf_employee_report" name="" value="" disabled><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;PDF</a>
                    <? } ?>
                    <? if(!empty($role_permissions) && in_array(225,$role_permissions)) { ?>
                    <a type="button" id="employee_report_csv" class="btn btn-outline-primary pdf_employee_report" disabled  onclick="downloadcsv();"><i class="fa fa-file-csv" aria-hidden="true"></i>&nbsp;CSV</a>
                    <? } ?>
                </div>
			</div>
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<? } ?>
<table id="datatable_tb" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
	<thead class="dthead tabletop">
        <tr>
            <th>Employee ID</th>
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
                			<td colspan="6" style="padding-left: 24%; font-weight:bold;"><?php echo $emp['filter_text'];?></td>
                			<td style="display:none"></td>
                			<td style="display:none"></td>
                			<td style="display:none"></td>
                			<td style="display:none"></td>
                			<td style="display:none"></td>
                		</tr>
                		<?php 
                		foreach($emp['detail'] as $empdet){ ?>
                        <tr>
                            <td><?= $empdet['employee_code'];?></td>
                            <td><?= $empdet['full_name'];?></td>
                            <td><?= $empdet['designation_name'];?> at <?= $empdet['fld_location'];?> in <?= $empdet['department_name'];?></td>
                            <td><?= $empdet['cnic'];?></td>
                            <td><?= $empdet['mobile_no'];?></td>
                            <td><?= date('d/m/Y', strtotime($empdet['joining_date']));?></td>
                        </tr>
                        
                        <?php }}} else{?>
		<tr>
		<td colspan="6" style="text-align:center;color:red;">Sorry No Record Found</td>
		<td style="display:none"></td>
		<td style="display:none"></td>
		<td style="display:none"></td>
		<td style="display:none"></td>
		<td style="display:none"></td>
		</tr>
		<?php } ?>
                        
                        </tbody>
</table>
<script>
  
   function downloadcsv(){
        //  var form = $('#ledgerFilter').serialize();
        var formdata=$('#employeefilter').serialize();
       var url="<?php echo base_url(); ?>Employees/employee_report_csv?"+formdata;
       window.open(url);
   }
</script>
