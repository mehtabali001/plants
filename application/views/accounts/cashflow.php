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
</style>
<? $role_permissions  = explode(",",$this->session->userdata('permissions')); ?>
<div class="container-fluid">
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right" style="margin-bottom:15px;">
    			<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Accounts/incomereport" type="button" class="btn btn-outline-primary"><i class="fa fa-bar-chart"></i>&nbsp;Income Statment</a>
                  <a href="<?= base_url();?>Accounts/cashflow" type="button" class="btn btn-primary btn-large"><i class="fa fa-shopping-cart"></i>&nbsp; Cash Flow Report</a>
                  <a href="<?= base_url();?>Accounts/profitandlossReport" type="button" class="btn btn-outline-primary "><i class="fa fa-vcard"></i>&nbsp;Profit & Loss report</a>
                  <a href="<?= base_url();?>Accounts/trailbalance" type="button" class="btn btn-outline-primary"><i class="fa fa-files-o"></i>&nbsp;Trial Balance</a>
                </div>
			</div>
			<!--<h4 class="page-title">Cash Flow Report</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Accounts</a></li>-->
			<!--	<li class="breadcrumb-item active">Cash Flow Report</li>-->
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
                        <? if(!empty($role_permissions) && in_array(277,$role_permissions)) { ?>
                        <div class="row">
						<div class="col-sm-12">
						  <div class="float-right" style="margin-bottom: 15px;">
                            <button type="button" id="currentday" class="btn btn-success waves-effect waves-light" style="box-shadow: 0 7px 14px 0 rgb(45 218 181 / 50%);" name="show-current-day" onclick="getCashFlowByDate('daily');"><i class="fa fa-line-chart" aria-hidden="true"></i>&nbsp;This Day</button>
                            <button type="button" id="currentweek" class="btn btn-purple waves-effect waves-light" style="box-shadow: 0 7px 14px 0 rgb(109 129 245 / 50%);" name="show-current-week" onclick="getCashFlowByDate('weekly');"><i class="fa fa-line-chart" aria-hidden="true"></i>&nbsp;This Week</button>
                            <button type="button" id="currentmonth" class="btn btn-secondary waves-effect waves-light" style="box-shadow: 0 7px 14px 0 rgb(65 203 216 / 50%) !important;" name="show-current-month" onclick="getCashFlowByDate('monthly');"><i class="fa fa-bar-chart" aria-hidden="true"></i>&nbsp;This Month</button>
                            <button type="button" id="currentyear" class="btn btn-info waves-effect waves-light" style="box-shadow: 0 7px 14px 0 rgb(155 167 202 / 50%);" name="show-current-year" onclick="getCashFlowByDate('yearly');"><i class="fa fa-line-chart" aria-hidden="true"></i>&nbsp;This Year</button>
						   </div>
						</div>
						</div>
						<? } ?>
						<!--<div class="col-sm-12">-->
						<!--	<h4 class="form-section"><i class="icon-eye6"></i>Cash Flow Report</h4>-->
						<!--</div>-->
						<!--<hr>-->
                        <div class="row" style="">
                            
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
    							<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;"  name="type" id="type" required>
    							        <option value="all">All</option>
    							        <?php
    							        
    							        $types = $this->db->query("SELECT * FROM tbl_transections_master GROUP by type ORDER by type")->result_array(); 
    							        foreach($types  as $type){ ?>
    							        <option value="<?=$type['type'];?>"><?=$type['type'];?></option>
    							        <?php } ?>
    							 
    							</select>
    						</div>
    						<div class="col-sm-3">
    							<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;"  name="group" id="group" required>
        							     <option value="Date_Wise">Date Wise</option>
        							     <option value="Voucher_Wise">Voucher Wise</option>
        							     <option value="Account_Wise">Party Wise</option>
        							     <option value="User_Wise">User Wise</option>
    							</select>
    						</div>
							
						
                        <div class="col-sm-12">
                        <button type="button" class="btn btn-successs btn-large show_report" name="show-report" value="" onclick="getCashFlowReport();"><i class="fa fa-search" aria-hidden="true" ></i>&nbsp;Proceed</button>
                        
                        <button type="button" id="reset_filters" class="btn btn-danger" name="" value="" disabled onclick="window.location.href='<?= base_url(); ?>Accounts/cashflow'"><i class="fa fa-refresh" aria-hidden="true" ></i>&nbsp;Reset</button>
                        
                    </form> 
                    	</div>
                        </div>
				</div>
				
				</div>
				<div id="filterhtml">
				    
				
				</div>
				
				
			</div>
			</div> <!-- end card-body -->
		</div> <!-- end card -->                                       
	</div> <!-- end col -->


</div>

</div><!-- container -->
<input type="hidden"  id="dfrom_date" value="<?= date('m/d/Y',strtotime('-30 days'))?>" />
<input type="hidden"  id="dto_date" value="<?= date('m/d/Y')?>" />
 <script>
    // table.on( 'search.dt', function () {
    //     // alert(table.search());
    //     if (table.search() != '') {
    //         $('#pdf_purchase_report').prop('disabled', true);
    //         $('.tablebottom').hide();
    //     } else {
    //         $('#pdf_purchase_report').prop('disabled', false);
    //         $('.tablebottom').show();
    //     }
    // } );
    
//   function btnActive(val){
       
//       if(val!=''){
//           $('#show_report').removeAttr("disabled");
//       }else{
//           $("#show_report").attr( "disabled", "disabled" );
//       }
//   }
</script>
<script>
     function downloadcsv(){
         var form = $('#ledgerFilter').serialize();
       window.location.href="<?php echo base_url(); ?>Accounts/cashflow_csv?"+form;
   }
</script>
                