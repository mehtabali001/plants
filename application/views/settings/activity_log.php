<style>
.btn {
    font-size: .645rem;
}
#datatable_filter > label
{
	float: right;
}
.pagination
{
	float: right;
}
.dataTables_empty
{
	text-align: center;
}

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
    /*font-size: 10px !important;*/
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
<? $role_permissions  = explode(",",$this->session->userdata('permissions')); ?>
<div class="container-fluid">
<div class="row">
<div class="col-sm-12" style="margin-bottom:2%;">
		<div class="page-title-box">
			<div class="float-right">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
				    <a href="<?= base_url();?>Settings/add" type="button" class="btn btn-outline-primary"><i class="fa fa-envelope"></i>&nbsp;+ Email Template</a>
                  <a href="<?= base_url();?>Settings/listing" type="button" class="btn  btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;View Templates</a>
                  <a href="<?= base_url();?>Settings/log_system" type="button" class="btn btn-primary btn-large"><i class="fa fa fa-history"></i>&nbsp;System Logs</a>
                  <a href="<?= base_url();?>Settings/general_settings" type="button" class="btn btn-outline-primary"><i class="fa fa-sliders"></i>&nbsp;General Settings</a>
                </div>
			</div>
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<!-- end page title end breadcrumb -->
<div class="row">
                        <div class="col-12">
                            <div class="card" style="overflow:auto;">
                                <div class="card-body">
						<form id="activityLog" >
						<div class="row">
							<div class="col-sm-3">
								<div class="form-group input-group ">      
									<div class="input-group-append">
										<span class="input-group-text" style="    background-color: #506ee4;border: 1px solid #506ee4;">From</span>
									</div>                                     
									<input type="text" class="form-control datepicker" name="from_date" id="from_date" value="<?= date('d/m/Y')?>">	
								</div>   
                            </div>
							<div class="col-sm-3">
								<div class="form-group input-group ">      
									<div class="input-group-append">
										<span class="input-group-text" style="background-color: #506ee4;border: 1px solid #506ee4;">To</span>
									</div>                                     
									<input type="text" class="form-control datepicker" name="to_date" id="to_date" value="">	
								</div>   
                            </div>
							<div class="col-sm-3">
								<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="filter" id="filter">
										<option value="Date_Wise">Date Wise</option>
										<option value="User_Wise">User Wise</option>
										<option value="Action_Wise">Action Wise</option>
										<option value="Login_Wise">Login/Logout Wise</option>
									<!--	<option value="Logout_Wise">Logout Wise</option>-->
								</select>
							</div>
							<div class="col-sm-3">
							    <? if(!empty($role_permissions) && in_array(268,$role_permissions)) { ?>
								<button type="button" id="show_report" class="btn btn-successs show_report" name="show-report" value=""><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Proceed F10</button>
								<?}?>
							</div>
                        </div>
                        
                        <!--<button type="button" style="margin: 0px 10px;" id="" class="btn btn-secondary" name="" value=""><i class="fa fa-bar-chart" aria-hidden="true"></i>&nbsp;Show Charts</button>-->
						</form>
                        <hr>
									<div class="col-lg-12">
										<?php $error_message = $this->session->userdata('error_message');
										if (isset($error_message)) {
											?>
											<div class="alert alert-danger">
												
												<?php echo $error_message ?>                    
											</div>
											<?php
											$this->session->unset_userdata('error_message');
										}?>
										<?php $success_message = $this->session->userdata('success_message');
										if (isset($success_message)) {
											?>
											<div class="alert alert-success">
												
												<?php echo $success_message ?>                    
											</div>
											<?php
											$this->session->unset_userdata('success_message');
										}?>
										</div>
								
									<div id="filterhtml">
                                    <?/*<table id="datatable_tb" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
											<td colspan="9" style="text-align:center;"><?php echo $act_logs['filter_text'];?></td>
											<td style="display:none;"></td>
											<td style="display:none;"></td>
											<td style="display:none;"></td>
											<td style="display:none;"></td>
											<td style="display:none;"></td>
											<td style="display:none;"></td>
											<td style="display:none;"></td>
											<td style="display:none;"></td>
									   </tr>
									   <?php foreach($act_logs['detail'] as $logs){?>
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
										<?php $i++;}}}?>
                                        </tbody>
                                    </table>*/?>
    
                                </div>
                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->
</div>
<script>
     function downloadpdf(){
        //  var form = $('#ledgerFilter').serialize();
        var formdata=$('#activityLog').serialize();
       var url="<?php echo base_url(); ?>Settings/print_setting_report?"+formdata;
       window.open(url);
   }
   function downloadcsv(){
        //  var form = $('#ledgerFilter').serialize();
        var formdata=$('#activityLog').serialize();
       var url="<?php echo base_url(); ?>Settings/logs_setting_csv?"+formdata;
       window.open(url);
   }
   function print_report(){
        //  var form = $('#ledgerFilter').serialize();
        //var formdata=$('#activityLog').serialize();
       //var url="<?php echo base_url(); ?>Settings/logs_setting_csv?"+formdata;
       //window.open(url);
      // window.open(<?php echo base_url(); ?>'Settings/print_log_report?'+formdata, "System Log Report", 'width=1210, height=842');
   }
</script>
                