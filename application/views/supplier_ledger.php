<style>
.select2-dropdown {
    background-color: #212744;
    border: 1px solid #575252;
	border-bottom: 1px solid #2a2f4e;
}
.select2-container--default .select2-results__option[aria-selected=true] {
    background-color: #5897FB;
}
.select2-container--default .select2-selection--single {
    background-color: #212744;
    border: 1px solid #575252;
    border-radius: 4px;
	height: 36px;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #bac1dc;
    line-height: 28px;
	padding-top: 2px;
}
.col-form-label {
    text-align: center;
}
.btn-success, .btn-info, .btn-primary, .btn-warning,.btn-danger,.btn-gradient-primary,.btn-gradient-danger{
	box-shadow: 0 0 black;
}
.btn-success{
	border: 1px solid #575252;
    background-color: #212744;
}
.btn-success:hover {
    background-color: #212744;
    border-color: #575252;
}
.daterangepicker .calendar-table {
    background-color: #10163B;
}
.daterangepicker {
    background-color: #10163B;
	border: 1px solid #506ee4;
}
.daterangepicker td.off, .daterangepicker td.off.in-range, .daterangepicker td.off.start-date, .daterangepicker td.off.end-date {
    background-color: #10163B;
}
.daterangepicker td.available:hover, .daterangepicker th.available:hover {
    background-color: #8a8787;
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
</style>
<? $role_permissions  = explode(",",$this->session->userdata('permissions')); ?>
<div class="container-fluid">
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Purchase" type="button" class="btn btn-outline-primary"><i class="fa fa-shopping-cart"></i>&nbsp;Add Supplier</a>
                  <a href="<?= base_url();?>Purchase/manage_purchase" type="button" class="btn btn-outline-primary"><i class="fa fa-vcard"></i>&nbsp;Manage Supplier</a>
                  <a href="<?= base_url();?>Purchase/supplier_ledger" type="button" class="btn btn-primary btn-large"><i class="fa fa-vcard"></i>&nbsp;Supplier Ledger</a>
                </div>
			</div>
			<h4 class="page-title">Supplier Ledger</h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="javascript:void(0);">Supplier</a></li>
				<li class="breadcrumb-item active">Supplier Ledger</li>
			</ol>
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<!-- end page title end breadcrumb -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
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
										}
										?>
										</div>
									<div class="panel-body" style="width:100%;padding: 0px 13px;">
                    				<form id="supplierLedgerfilter">
                                            <!--<input type="hidden" name="filter_type" id="filter_type" value="1" />-->
                    						<!--<div class="col-sm-12">-->
                    						<!--	<h4 class="form-section"><i class="icon-eye6"></i>Navigation Report</h4>-->
                    						<!--<br>-->
                    						<!--</div>-->
                    						<!--<hr>-->
                                            <div class="row">
                                                
                    							<div class="col-sm-3">
                    								<div class="form-group input-group">      
                    									<div class="input-group-append">
                    										<span class="input-group-text" style="background-color: #506ee4;border: 1px solid #506ee4;">From</span>
                    									</div>                                     
                    									<input type="text" class="form-control datepicker" name="from_date" id="from_date" value="<?= date('m-d-Y',strtotime('-30 days'))?>">	
                    								</div>   
                                                </div>
                    							<div class="col-sm-3">
                    								<div class="form-group input-group">      
                    									<div class="input-group-append">
                    										<span class="input-group-text" style="background-color: #506ee4;border: 1px solid #506ee4;">To</span>
                    									</div>                                     
                    									<input type="text" class="form-control datepicker" name="to_date" id="to_date" value="">	
                    								</div>   
                                                </div>
                                                <div class="col-sm-3">
                    								<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="supplier" id="supplier" required>
                    										<option selected="selected" value="0">Select Supplier</option>
            												<?php
                												if($supplier){
                												foreach($supplier as $sup){
                												?>
                												<option value="<?= $sup['fld_id'];?>"><?= $sup['fld_company_name'];?></option>
            												<?php }}?>
                    								</select>
                    							</div>
                    							<div class="col-sm-3">
                    								<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="shipment" id="shipment" required>
                    										<option selected="selected" value="0">Select Shipment</option>
            												<?php
                												if($getshipments){
                												foreach($getshipments as $ship){
                											?>
                												<option value="<?= $ship['fld_id'];?>"><?= $ship['fld_shipment'];?></option>
            												<?php } } ?>
                    								</select>
                    							</div>
                                            </div>
                                            <button type="button" id="show_report" class="btn btn-primary btn-large show_report" name="show-report" value=""><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Show Record</button>
                                            <button type="button" style="margin: 0px 10px;background-color: DodgerBlue;" id="print_ledger_report" class="btn  print_report" name="" value=""><i class="fa fa-print" aria-hidden="true"></i>&nbsp;Print Report</button>
                                            <button type="button" style="margin: 0px 10px;" id="pdf_purchase_report" class="btn btn-gradient-pink pdf_ledger_report" name="" value=""><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;Download PDF</button>
                                            <button type="button" style="margin: 0px 10px;" id="reset_filters" class="btn btn-danger" name="" value="" onclick="window.location.href='<?= base_url(); ?>Supplier/supplier_ledger'"><i class="fa fa-refresh" aria-hidden="true" ></i>&nbsp;Reset Flters</button>
                                        </form>
                    				</div>	
                    				<hr>
                    				<br>
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Shipment</th>
                                            <th>Voucher No.</th>
                                            <th>Debit</th>
                                            <th>Credit</th>
                                            <th>Balance</th>
                                        </tr>
                                        </thead>
    
                                        <tbody>
										<?/*?><?php if($suppliers){
											foreach($suppliers as $supl){
											?>
                                        <tr>
                                            <td><?= $supl['fld_supplier_code'];?></td>
                                            <td><?= $supl['fld_supplier_name'];?></td>
                                            <td><?= $supl['fld_company_name'];?></td>
                                            <td><?php if($supl['fld_supplier_type'] == 1){
												echo 'Local';
											}elseif($supl['fld_supplier_type'] == 2){
												echo 'Importer';
											}else{
												echo '';
											} ?></td>
                                            <td><?= $supl['fld_mobile_num'];?></td>
                                            <td>
											<? if(!empty($role_permissions) && in_array(59,$role_permissions)) { ?>
											<a href="<?= base_url('Supplier/edit/'.$supl['fld_id'].'')?>">
											<i style="font-size:20px;cursor:pointer;" class="mdi mdi-square-edit-outline" title="Edit"></i></a>
											<? } ?>
											<? if(!empty($role_permissions) && in_array(60,$role_permissions)) { ?>
											<a href="<?= base_url('Supplier/viewSuplier/'.$supl['fld_id'].'')?>"><i style="font-size:20px;cursor:pointer;" class="mdi mdi-eye-circle-outline" title="View"></i></a>
											<? } ?>
											<? if(!empty($role_permissions) && in_array(61,$role_permissions)) { ?>
											<a href="<?= base_url('Supplier/delete/'.$supl['fld_id'].'')?>" onclick="return confirm('Are you sure you want to delete this record.')">
											<i style="font-size:20px;cursor:pointer;" class="mdi mdi-delete-forever" title="Delete"></i>
											</a>
											<? } ?>
											</td>
                                        </tr>
										<?php }}?><?*/?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->
</div>