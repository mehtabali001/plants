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
.boxshadow{
	box-shadow: none !important;
}
.btn-secondary{
	box-shadow: none !important;
}
#datatable_filter > label
{
	float: right;
}
#footable-2_filter > label
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
.btn-success, .btn-info, .btn-primary, .btn-warning,.btn-danger,.btn-gradient-primary,.btn-gradient-danger{
	box-shadow: 0 0 black;
}
.hide {display: none; }
.form-group label{
	font-size: 12px;
}
.nav-tabs {
    border-bottom: 2px solid #506ee4;
}
#filterhtml{
    margin-top:20px;
}
@media only screen and (max-width: 600px) {


#currentyear, #currentmonth, #currentweek, #currentday{
    margin-bottom:5px;
}
}
</style>
<? $role_permissions  = explode(",",$this->session->userdata('permissions')); ?>
<div class="container-fluid">
<div class="row">
	<div class="col-sm-12" style="margin-bottom:1%;">
		<div class="page-title-box">
			<div class="float-right">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Expenses/expenseReport" type="button" class="btn btn-primary btn-large"><i class="fa fa-files-o"></i>&nbsp;Expense Report</a>
                  <a href="<?= base_url();?>Expenses/manage_Expenses" type="button" class="btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;View Expenses</a>
                  <a href="<?= base_url();?>Expenses/manage_trash" type="button" class="btn btn-outline-primary"><i class="fa fa-trash"></i>&nbsp;Trashed Expenses</a>
                  <a href="<?= base_url();?>Expenses/manage_drafts" type="button" class="btn btn-outline-primary"><i class="fa fa-files-o"></i>&nbsp;Drafts</a>
                </div>
			</div>
			<!--<h4 class="page-title">Expense Report</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Expenses</a></li>-->
			<!--	<li class="breadcrumb-item active">Expense Report</li>-->
			<!--</ol>-->
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="card" style="overflow:auto;">
			<div class="card-body">
				<div class="row" id="purchasediv">
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
				<div class="panel-body" style="width:100%;padding: 0px 13px;">
				<form id="expensefilter">
                        <input type="hidden" name="filter_type" id="filter_type" value="1" />
                        <? if(!empty($role_permissions) && in_array(282,$role_permissions)){ ?>
                        <div class="row">
						<div class="col-sm-12">
						  <div class="float-right" style="margin-bottom: 15px;">
                            <button type="button" id="currentday" class="btn btn-success waves-effect waves-light" style="box-shadow: 0 7px 14px 0 rgb(45 218 181 / 50%);" name="show-current-day" onclick="getExpensesFilterDataByDate('daily');"><i class="fa fa-line-chart" aria-hidden="true"></i>&nbsp;This Day</button>
                            <button type="button" id="currentweek" class="btn btn-purple waves-effect waves-light" style="box-shadow: 0 7px 14px 0 rgb(109 129 245 / 50%);" name="show-current-week" onclick="getExpensesFilterDataByDate('weekly');"><i class="fa fa-line-chart" aria-hidden="true"></i>&nbsp;This Week</button>
                            <button type="button" id="currentmonth" class="btn btn-secondary waves-effect waves-light" style="box-shadow: 0 7px 14px 0 rgb(65 203 216 / 50%) !important;" name="show-current-month" onclick="getExpensesFilterDataByDate('monthly');"><i class="fa fa-bar-chart" aria-hidden="true"></i>&nbsp;This Month</button>
                            <button type="button" id="currentyear" class="btn btn-info waves-effect waves-light" style="box-shadow: 0 7px 14px 0 rgb(155 167 202 / 50%);" name="show-current-year" onclick="getExpensesFilterDataByDate('yearly');"><i class="fa fa-line-chart" aria-hidden="true"></i>&nbsp;This Year</button>
						   </div>
						</div>
						</div>
						<? } ?>
						<!--<div class="col-sm-12">-->
						<!--	<h4 class="form-section"><i class="icon-eye6"></i>Expense Report</h4>-->
						<!--<br>-->
						<!--</div>-->
						<!--<hr>-->
                        <div class="row">
							<div class="col-sm-3">
								<div class="form-group input-group ">      
									<div class="input-group-append">
										<span class="input-group-text" style="background-color: #506ee4;border: 1px solid #506ee4;color:#FFF;">From</span>
									</div>                                     
									<input type="text" class="form-control datepicker" name="from_date" id="from_date" value="<?= date('d/m/Y',mktime(0, 0, 0, date('m'), 1, date('Y')))?>">	
								</div>   
                            </div>
							<div class="col-sm-3">
								<div class="form-group input-group ">      
									<div class="input-group-append">
										<span class="input-group-text" style="background-color: #506ee4;border: 1px solid #506ee4;color:#FFF;">To</span>
									</div>                                     
									<input type="text" class="form-control datepicker" name="to_date" id="to_date" value="">	
								</div>   
                            </div>
							<div class="col-sm-3">
								<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="filter" id="filter" required>
										<option value="Voucher_Wise">Voucher Wise</option>
										<option value="Plant_Wise">Plant Wise</option>
										<option value="Item_Wise">Item Wise</option>
										<option value="User_Wise">User Wise</option>
										<option value="Year_Wise">Year Wise</option>
										<option value="Month_Wise">Month Wise</option>
										<option value="WeekDay_Wise">WeekDay Wise</option>
										<option value="Date_Wise">Date Wise</option>
								</select>
							</div>
							<div class="col-sm-3">
								<div class="form-group row">
								    <div class="col-sm-12" style="padding-top:10px;">
								        <div class="radio radio-info form-check-inline">
                                            <input type="radio" id="inlineRadio1" value="option1" name="radioInline" onclick="setreportfilter(1);"  href="javascript:;" checked="">
                                            <label for="inlineRadio1"> Detailed </label>
                                        </div>
                                        <div class="radio form-check-inline">
                                            <input type="radio" id="inlineRadio2" value="option2" onclick="setreportfilter(2);"  href="javascript:;" name="radioInline">
                                            <label for="inlineRadio2"> Summary </label>
                                        </div>
								    </div>
								</div>		
							</div>
                        </div>
                        <!--<div class="row">-->
                            <button type="button" id="show_report" class="btn btn-successs btn-large show_report" name="show-report" onclick="getExpenses();"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Proceed F10</button>
                        <!--<input type="button" id="show_report" class="btn btn-primary btn-large show_report col-sm-2" name="show-report" value="Show Report F10" style="margin: 0px 10px;background-color: DodgerBlue;margin-bottom: 2%;" >-->
                        <!--<button type="button" style="margin: 0px 10px;" id="" class="btn btn-secondary" name="" value=""><i class="fa fa-bar-chart" aria-hidden="true"></i>&nbsp;Show Charts</button>-->
                        <button type="button" class="btn btn-warning waves-effect" id="advance_search"  disabled>Advance Search</button>
                        <!--<input type="button" class="btn btn-warning waves-effect col-sm-2" id="advance_search" disabled value="Advance Search F8" style="margin-bottom: 2% !important;margin: 0px 10px;">-->
                        <button type="button" style=" " id="reset_filters" class="btn btn-danger" name="" value="" disabled onclick="window.location.href='<?= base_url(); ?>Expanses/expenseReport'"><i class="fa fa-refresh" aria-hidden="true" ></i>&nbsp;Reset F5</button>
                        <!--</div>-->
                        <div class="col-md-12 col-lg-12 col-xl-12 hide" id="show_filters_tab" style="padding-left: 0px;margin-top:20px;">
                            <div class="card">
                                <div class="card-body">
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#general" role="tab">General</a>
                                        </li>
                                    </ul>
                                    <!-- Tab panes -->
                                    <form action="" method="post" id="advance-search-form">
                                        <div class="tab-content">
                                            <div class="tab-pane active p-3" id="general" role="tabpanel">
                                                <div class="row">
                    								<div class="col-md-6">
                    								    <div class="form-group row">
                    										<label class="col-sm-4 col-form-label text-right">Voucher #</label>
                    										<div class="col-sm-8">
                            									<select class="select2 form-control mb-3 custom-select" id="expense_voucher" name="expense_voucher" onchange="advanceSearch();">
                    												<option value="">Select</option>
                    												<?php 
                    												$vouchers = $this->db->query("SELECT distinct expense_voucher FROM tbl_expenses WHERE fld_isdeleted = 0 ORDER BY id ASC")->result_array();
                    												foreach($vouchers as $vouch){?>
                    												<option value="<?= $vouch['expense_voucher'];?>"><?= $vouch['expense_voucher'];?></option>
                    												<?php }?>
                    											</select>
                    										</div>
                    									</div>
                    								</div>
                    								<div class="col-md-6">
                    									<div class="form-group row">
                    										<label class="col-sm-4 col-form-label text-right">Warehouse</label>
                    										<div class="col-sm-8">
                    											<select class="select2 form-control mb-3 custom-select" name="location" id="fld_location" onchange="advanceSearch();">
                    												<option value="">Select</option>
                    												<?php foreach($locations as $loc){?>
                    												<option value="<?= $loc['fld_id'];?>"><?= $loc['fld_location'];?></option>
                    												<?php }?>
                    											</select>
                    										</div>
                    									</div>
                    								</div>
                    								<div class="col-md-6">
                    									<div class="form-group row">
                    										<label class="col-sm-4 col-form-label text-right">User</label>
                    										<div class="col-sm-8">
                    											<select class="select2 form-control mb-3 custom-select" name="user" id="fld_user" onchange="advanceSearch();">
                    												<option value="">Select</option>
                    												<?php foreach($users as $usr){?>
                    												<option value="<?= $usr['fld_id'];?>"><?= $usr['fld_username'];?></option>
                    												<?php }?>
                    											</select>
                    										</div>
                    									</div>
                    								</div>
                    								<div class="col-md-6">
                    									<div class="form-group row">
                    										<label class="col-sm-4 col-form-label text-right">Expense Items</label>
                    										<div class="col-sm-8">
                    											<select class="select2 form-control mb-3 custom-select" name="stationary" id="stationary" onchange="advanceSearch();">
                    												<option value="">Select</option>
                    												<?php $items	=	$this->Common_model->select_where_ASC_DESC('id,name','tbl_stationary',array('status'=>1),'name','ASC');
                                                                            if($items->num_rows() > 0) {
                                                                            foreach($items->result() as $itm) {
                                                                    ?>
                    												<option value="<?php echo $itm->id;?>"><?php echo $itm->name;?></option>
                    												<?php } } ?>
                    											</select>
                    										</div>
                    									</div>
                    								</div>
                    							</div>
                                            </div>
                                        </div>
                                    </form>
                                </div><!--end card-body-->
                            </div><!--end card-->
                        </div>
                    </form>
				</div>
				</div>
				<div id="filterhtml">
				
				</div>
			</div>
			</div> <!-- end card-body -->
		</div> <!-- end card -->                                       
	</div> <!-- end col -->
</div>
<div id="productSelect" style="display:none;">
	<?php
		if($category){
		foreach($category as $cat){
	?>
		<option value="<?= $cat['fld_id'];?>" data-unit="<?= $cat['fld_unit'];?>"><?= $cat['fld_category'];?></option>
	<?php }}?>
</div>
</div><!-- container -->
<input type="hidden"  id="dfrom_date" value="<?= date('m/d/Y',strtotime('-30 days'))?>" />
<input type="hidden"  id="dto_date" value="<?= date('m/d/Y')?>" />