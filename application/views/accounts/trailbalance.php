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
.btnnnn .btn{
    font-size:.645rem;
}
</style>
<? $role_permissions  = explode(",",$this->session->userdata('permissions')); ?>
<div class="container-fluid">
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right" style="margin-bottom: 15px;">
    			<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Accounts/incomereport" type="button" class="btn btn-outline-primary"><i class="fa fa-bar-chart"></i>&nbsp;Income Statment</a>
                  <a href="<?= base_url();?>Accounts/cashflow" type="button" class="btn btn-outline-primary"><i class="fa fa-shopping-cart"></i>&nbsp; Cash Flow Report</a>
                  <a href="<?= base_url();?>Accounts/profitandlossReport" type="button" class="btn btn-outline-primary "><i class="fa fa-vcard"></i>&nbsp;Profit & Loss report</a>
                  <a href="<?= base_url();?>Accounts/trailbalance" type="button" class="btn btn-primary btn-large"><i class="fa fa-files-o"></i>&nbsp;Trial Balance</a>
                </div>
			</div>	
			<!--<h4 class="page-title">Trial Balance</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Accounts</a></li>-->
			<!--	<li class="breadcrumb-item active">Trial Balance</li>-->
			<!--</ol>-->
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				
				<div class="row" id="purchasediv" style="justify-content:center;">
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
				<form id="ledgerFilter" >
                        <input type="hidden" name="filter_type" id="filter_type" value="1" />
                        <? if(!empty($role_permissions) && in_array(276,$role_permissions)) { ?>
                        <div class="row">
						<div class="col-sm-12">
						  <div class="float-right" style="margin-bottom: 15px;">
                            <button type="button" id="currentday" class="btn btn-success waves-effect waves-light" style="box-shadow: 0 7px 14px 0 rgb(45 218 181 / 50%);" name="show-current-day" onclick="getTrailBalanceByDate('daily');"><i class="fa fa-line-chart" aria-hidden="true"></i>&nbsp;This Day</button>
                            <button type="button" id="currentweek" class="btn btn-purple waves-effect waves-light" style="box-shadow: 0 7px 14px 0 rgb(109 129 245 / 50%);" name="show-current-week" onclick="getTrailBalanceByDate('weekly');"><i class="fa fa-line-chart" aria-hidden="true"></i>&nbsp;This Week</button>
                            <button type="button" id="currentmonth" class="btn btn-secondary waves-effect waves-light" style="box-shadow: 0 7px 14px 0 rgb(65 203 216 / 50%) !important;" name="show-current-month" onclick="getTrailBalanceByDate('monthly');"><i class="fa fa-bar-chart" aria-hidden="true"></i>&nbsp;This Month</button>
                            <button type="button" id="currentyear" class="btn btn-info waves-effect waves-light" style="box-shadow: 0 7px 14px 0 rgb(155 167 202 / 50%);" name="show-current-year" onclick="getTrailBalanceByDate('yearly');"><i class="fa fa-line-chart" aria-hidden="true"></i>&nbsp;This Year</button>
						   </div>
						</div>
						</div>
                        <? } ?>
                        <div class="row">
    						<div class="col-sm-6">
    							<h4 class="form-section"><i class="icon-eye6"></i>&nbsp;</h4>
    						</div>
    						<div class="col-sm-6">
    							 <div class="custom-control custom-switch switch-secondary " id="zero" style="display:none;float: right;margin-top: 15px;">
                                        <label style="margin-right: 42px;">Show Zero</label>
                                    <input type="checkbox" class="custom-control-input" onclick="getTrailBalance($('#level').val())" id="customSwitchSecondary" value="1" name="hide_zero">
                                    <label class="custom-control-label" for="customSwitchSecondary">Hide Zero</label>
    						</div>
						</div>
						</div>
						<!--<hr>-->
                        <div class="row">
							<div class="col-sm-2">
								<div class="form-group input-group ">      
									<div class="input-group-append">
										<span class="input-group-text" style="background-color: #506ee4;border: 1px solid #506ee4;color:#FFF;">From</span>
									</div>                                     
									<input type="text" class="form-control datepicker" name="from_date" id="from_date" value="<?= date('d/m/Y',mktime(0, 0, 0, date('m'), 1, date('Y')))?>">	
								</div>   
                            </div>
							<div class="col-sm-2">
								<div class="form-group input-group ">      
									<div class="input-group-append">
										<span class="input-group-text" style="background-color: #506ee4;border: 1px solid #506ee4;color:#FFF;">To</span>
									</div>                                     
									<input type="text" class="form-control datepicker" name="to_date" id="to_date" value="">	
								</div>   
                            </div>
       <!--                     <div class="col-sm-3">-->
							<!--	<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="level" id="level" required>-->
							<!--			<option value="1">Summarized View</option>-->
							<!--			<option value="2">Med-Detailed View</option>-->
							<!--			<option value="3">Detailed View</option>-->
							<!--	</select>-->
							<!--</div>-->
							<input type="hidden" name="level" id="level" value="1">
							
							<div class="col-sm-8 btnnnn">
                        <button type="button" id="show_report" class="btn btn-successs btn-large show_report" name="show-report" value="" onclick="getTrailBalance(1);"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Proceed</button>

                        <button type="button" id="reset_filters" class="btn btn-danger" name="" value="" disabled onclick="window.location.href='<?= base_url(); ?>Accounts/trailbalance'"><i class="fa fa-refresh" aria-hidden="true" ></i>&nbsp;Reset</button>
                        
                        </div>
                        </div>
                        <!--<div class="row">-->
                        <!--    <div class="col-sm-12" style="display:flex;justify-content:center;">-->
                        <!--       <div class="form-group row"  >-->
                                   
                                   
                                    
                        <!--        </div>-->
                        <!--        </div>-->
                                
                        <!--    </div>-->
                        </div>
                    </form> 
				</div>
				
				</div>
				<div id="filterhtml" style="margin-top: 0px;">
				    
				
				</div>
				
				
			</div>
			</div> <!-- end card-body -->
		</div> <!-- end card -->                                       
	</div> <!-- end col -->


</div>
<input type="hidden"  id="dfrom_date" value="<?= date('m/d/Y',strtotime('-30 days'))?>" />
<input type="hidden"  id="dto_date" value="<?= date('m/d/Y')?>" />
<script>
   function btnActive(val){
       
       if(val!=''){
           $('#show_report').removeAttr("disabled");
       }else{
           $("#show_report").attr( "disabled", "disabled" );
       }
   }
   </script>
   <script>
     function downloadcsv(){
         var form = $('#ledgerFilter').serialize();
       window.location.href="<?php echo base_url(); ?>Accounts/trail_balance_csv?"+form;
   }
</script>
   


                