<style>
th {
  position: sticky !important;
  border: 1px solid #f1f5fa;
  /*top: 50px;*/
  /*background: white;*/
}
.search_filter td {
    /*border: none !important;*/
    background: #f1f5fa !important;
    color: #000;
    font-weight: bold;
}
.search_finalsum td {
    /*border: none !important;*/
    /*background: rgb(245 222 179) !important;*/
    color: white;
    font-weight: bold;
}
.table td {
    vertical-align: middle;
}
.dataTables_filter{
    float:right;
}
@media only screen and (max-width: 600px) {
      .btn-group {
        display:none;
      }
      #show_report{
          margin-top:10px;
      }
      .dataTables_length label{
    width:100%;
}
.dataTables_filter{
   width:100%; 
}
.dataTables_filter label{
   width:100%; 
}
.pagination{
    width: 100%;
}
    }
</style>
<?php if(!empty($activity_logs)){?>
	<div class="row">
    	<div class="col-sm-12">
    		<div class="page-title-box">
    			<div class="float-right" style="margin-bottom: 15px;">
    				<div class="btn-group" role="group" aria-label="Basic outlined example">
                    <? //if(!empty($role_permissions) && in_array(120,$role_permissions)) { ?>
                    <a type="button" id="print_report" class="btn btn-outline-primary print_report" onclick="print_report();" style=""><i class="fa fa-print" aria-hidden="true"></i>&nbsp;Print F6</a>
                    <? //} ?>
                    <? //if(!empty($role_permissions) && in_array(121,$role_permissions)) { ?>
                    <a type="button" id="pdf_customer_report" class="btn btn-outline-primary pdf_customer_report" name="" value="" onclick="downloadpdf();" ><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;PDF F7</a>
                    <? //} ?>
                    <? //if(!empty($role_permissions) && in_array(220,$role_permissions)) { ?>
                    <a type="button" id="sale_report_csv" class="btn btn-outline-primary pdf_purchase_report" onclick="downloadcsv();" style="" name="" value=""><i class="fas fa-file-csv"></i>&nbsp; CSV</a>
                    <? //} ?>
                    </div>
    			</div>
    		</div><!--end page-title-box-->
    	</div><!--end col-->
    </div>
    <?}?>
<table id="datatable_tb" class="table table_report table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                        <tr>
											<th>#</th>
											<th>Date</th>
                                            <th>User ID</th>
                                            <th>Role</th>
                                            <th>Action</th>
                                            <th>Details</th>
                                            <th>IP</th>
                                            <th>Address</th>
                                            <th>Device</th>
                                            
                                        </tr>
                                        </thead>
    
    
                                        <tbody>
										<?php if($activity_logs){
											$i=1;
											foreach($activity_logs as $act_logs){
										?>
										<tr class="search_filter">
											<td colspan="9" style="text-align:center;"><?php if($_POST['filter'] == "Date_Wise"){ echo date('d-m-Y',strtotime($act_logs['filter_text']));}else{echo $act_logs['filter_text'];}?></td>
											<td style="display:none;"></td>
											<td style="display:none;"></td>
											<td style="display:none;"></td>
											<td style="display:none;"></td>
											<td style="display:none;"></td>
											<td style="display:none;"></td>
											<td style="display:none;"></td>
											<td style="display:none;"></td>
									   </tr>
									   <?php if(!empty($act_logs['detail'])){ foreach(@$act_logs['detail'] as $logs){?>
											<tr>
												<td><?= $i;?></td>
												<td><?= date('d-m-Y H:i',strtotime($logs['fld_added_date']));?></td>
												<td><?= $logs['fld_username'];?></td>
												<td><?= $logs['fld_role_name'];?></td>
												<td><?= $logs['fld_action'];?></td>
												<td><?= $logs['fld_detail'];?></td>
												<td><?= $logs['fld_ip_address'];?></td>
												<td><?= $logs['fld_address'];?></td>
												<td><?= $logs['fld_device'];?></td>
												
											</tr>
										<?php $i++;}}}}else{?>
										<tr>
										    <td colspan="9" style="text-align:center;color:red;">Sorry No Record Found</td>
										    <td style="display:none;"></td>
											<td style="display:none;"></td>
											<td style="display:none;"></td>
											<td style="display:none;"></td>
											<td style="display:none;"></td>
											<td style="display:none;"></td>
											<td style="display:none;"></td>
											<td style="display:none;"></td>
										</tr>
										<?}?>
                                        </tbody>
                                    </table>
   