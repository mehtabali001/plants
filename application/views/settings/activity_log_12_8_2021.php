<style>
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
</style>
<? $role_permissions  = explode(",",$this->session->userdata('permissions')); ?>
<div class="container-fluid">
<div class="row">
<div class="col-sm-12">
		<div class="page-title-box">
			
			<h4 class="page-title">User Activity Log</h4>
			
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<!-- end page title end breadcrumb -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
						<form id="activityLog" >
						<div class="row">
							<div class="col-sm-3">
								<div class="form-group input-group ">      
									<div class="input-group-append">
										<span class="input-group-text" style="    background-color: #506ee4;border: 1px solid #506ee4;">From</span>
									</div>                                     
									<input type="text" class="form-control datepicker" name="from_date" id="from_date" value="<?= date('d/m/Y',mktime(0, 0, 0, date('m'), 1, date('Y')))?>">	
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
							<!--<div class="col-sm-3">
								<select class="form-control mb-3" style="width: 100%; height:36px;" name="filter" id="filter" required>
										<option value="Voucher_Wise">Voucher Wise</option>
										<option value="Account_Wise">Account Wise</option>
										<option value="Plant_Wise">Plant Wise</option>
										<option value="Item_Wise">Item Wise</option>
										<option value="User_Wise">User Wise</option>
										<option value="Year_Wise">Year Wise</option>
										<option value="Month_Wise">Month Wise</option>
										<option value="WeekDay_Wise">WeekDay Wise</option>
										<option value="Date_Wise">Date Wise</option>
										<option value="Rate_Wise">Rate Wise</option>
										<option value="Invoice_Wise">Invoice Wise</option>
										<option value="Shipment_Wise">Shipment Wise</option>
										<option value="Supplier_Wise">Supplier Wise</option>
								</select>
							</div>-->
							<div class="col-sm-3">
										
							</div>
                        </div>
                        <button type="button" id="show_report" class="btn btn-primary btn-large show_report" name="show-report" value=""><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Show Report F10</button>
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
                                    <table id="datatable_tb" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
											foreach($activity_logs as $logs){
										?>
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
										<?php $i++;}}?>
                                        </tbody>
                                    </table>
    
                                </div>
                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->
</div>

                