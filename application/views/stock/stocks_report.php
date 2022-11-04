<style>
#datatable100_filter{
    float:right;
}
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

#show_report, #print_report, #pdf_purchase_report, #purchase_report_csv, #advance_search, #reset_filters{
    margin-bottom:5px !important;
    margin-top: 0 !important;
    margin-left:0 !important;
    margin-right:0 !important;
}
#currentyear, #currentmonth, #currentweek, #currentday{
    margin-bottom:5px;
}
}
.btnprint a:hover{
    background:#6c85e4;
    color:#fff;
}
</style>
<? $role_permissions  = explode(",",$this->session->userdata('permissions')); ?>
<div class="container-fluid">
<div class="row">
	<div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right" style="margin-bottom:15px;">
                    <div class="btn-group" role="group" aria-label="Basic outlined example">
                      <a href="<?= base_url();?>Stocks" type="button" class="btn btn-outline-primary"><i class="fa fa-shopping-cart"></i>&nbsp;All Plants Stocks</a>
                      <a href="<?= base_url();?>Stocks/stocks_report" class="btn btn-primary btn-large"><i class="fa fa-bar-chart"></i>&nbsp;Stocks Report</a>
                      <a href="<?= base_url();?>Gain_loss" type="button" class="btn btn-outline-primary"><i class="fa fa-shopping-cart"></i>&nbsp;New Gain-Loss</a>
                      <a href="<?= base_url();?>Gain_loss/manage_trash" class="btn btn-outline-primary"><i class="fa fa-trash"></i>&nbsp;Trashed Gain-Loss</a>
                    </div>
                </div>
                <!--<h4 class="page-title">All Plants Stocks</h4>-->
                <!--<ol class="breadcrumb">-->
                <!--    <li class="breadcrumb-item"><a href="javascript:void(0);">Stocks</a></li>-->
                <!--    <li class="breadcrumb-item active">All Plants Stocks</li>-->
                <!--</ol>-->
            </div><!--end page-title-box
        </div><!--end col
    </div>
    <!-- end page title end breadcrumb -->
</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<div class="row" id="purchasediv">
				<div class="col-lg-12">
				<?php 
				    $error_message = $this->session->userdata('error_message');
				    if (isset($error_message)) {
				?>
					<div class="alert alert-danger">
						<?php echo $error_message ?>                    
					</div>
				<?php
					$this->session->unset_userdata('error_message');
				}
				?>
				<?php 
				   $success_message = $this->session->userdata('success_message');
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
				<form id="stockfilter">
					<? if(!empty($role_permissions) && in_array(274,$role_permissions)){ ?>
                        <div class="row">
						<div class="col-sm-12">
						  <div class="float-right" style="margin-bottom: 15px;">
                            <button type="button" id="currentday" class="btn btn-success waves-effect waves-light" style="box-shadow: 0 7px 14px 0 rgb(45 218 181 / 50%);" name="show-current-day" onclick="getStockFilterDataByDate('daily');"><i class="fa fa-line-chart" aria-hidden="true"></i>&nbsp;This Day</button>
                            <button type="button" id="currentweek" class="btn btn-purple waves-effect waves-light" style="box-shadow: 0 7px 14px 0 rgb(109 129 245 / 50%);" name="show-current-week" onclick="getStockFilterDataByDate('weekly');"><i class="fa fa-line-chart" aria-hidden="true"></i>&nbsp;This Week</button>
                            <button type="button" id="currentmonth" class="btn btn-secondary waves-effect waves-light" style="box-shadow: 0 7px 14px 0 rgb(65 203 216 / 50%) !important;" name="show-current-month" onclick="getStockFilterDataByDate('monthly');"><i class="fa fa-bar-chart" aria-hidden="true"></i>&nbsp;This Month</button>
                            <button type="button" id="currentyear" class="btn btn-info waves-effect waves-light" style="box-shadow: 0 7px 14px 0 rgb(155 167 202 / 50%);" name="show-current-year" onclick="getStockFilterDataByDate('yearly');"><i class="fa fa-line-chart" aria-hidden="true"></i>&nbsp;This Year</button>
						   </div>
						</div>
						</div>
						<? } ?>
                        <div class="row" style="margin-bottom: 10px;">
							<div class="col-sm-3">
								<div class="form-group input-group ">      
									<div class="input-group-append">
										<span class="input-group-text" style="background-color: #506ee4;border: 1px solid #506ee4;color:#FFF;">From Date</span>
									</div>                                     
									<input type="text" class="form-control datepicker" name="frmdate" id="from_date" value="<?= date('d/m/Y',mktime(0, 0, 0, date('m'), 1, date('Y')))?>">	
								</div>   
                            </div>
                            <div class="col-sm-3">
								<div class="form-group input-group ">      
									<div class="input-group-append">
										<span class="input-group-text" style="background-color: #506ee4;border: 1px solid #506ee4;color:#FFF;">To Date</span>
									</div>                                     
									<input type="text" class="form-control datepicker" name="todate" id="to_date">	
								</div>   
                            </div>
                            <div class="col-sm-3">
							<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" id="col2_filter" name="plant_for" >
                                <option value="all">All Plants</option>
                                <?php 
								    $tbl_plants	=	$this->Common_model->select_where_ASC_DESC('fld_id,fld_location','tbl_locations',array('fld_status'=>1, 'fld_id<>'=>8),'fld_location','ASC');
                                    if($tbl_plants->num_rows() > 0) {
                                    foreach($tbl_plants->result() as $plant){
                                ?>
                                    <option value="<?php echo $plant->fld_id;?>" ><?php echo $plant->fld_location;?></option>
                                <?php } } ?>
                            </select>
						 </div>
						<div class="col-sm-3">
							<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="item_type" id="item_type" onchange="showSubItem(this.value)" required>
							 <?php 
								    $tbl_category	=	$this->Common_model->select_where_ASC_DESC('fld_id,fld_category','tbl_category',array('fld_status'=>1),'fld_id','ASC');
                                    if($tbl_category->num_rows() > 0) {
                                    foreach($tbl_category->result() as $cat){
                                ?>
                                    <option value="<?php echo $cat->fld_id;?>" ><?php echo $cat->fld_category;?></option>
                                <?php } } ?>
							</select>
						</div>
						<div class="col-sm-3" style="display:none;" id="subitem_tab">
							<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="sitem_type" id="sitem_type" required>
							    <option value="all">All</option>
							 <?php 
								    $tbl_category	=	$this->Common_model->select_where_ASC_DESC('*','tbl_subcategory',array('fld_cid>'=>1),'fld_subcid','ASC');
                                    if($tbl_category->num_rows() > 0) {
                                    foreach($tbl_category->result() as $cat){
                                ?>
                                    <option value="<?php echo $cat->fld_subcid;?>" ><?php echo $cat->fld_subcategory;?></option>
                                <?php } } ?>
							</select>
						</div>
                        </div>
                        <button type="button" id="show_report_stock" onclick="getFilterStock();" class="btn btn-successs btn-large show_report" name="show-report" value=""><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Proceed F10</button>
                        <!--<button type="button" style="margin: 0px 10px;" id="" class="btn btn-secondary" name="" value=""><i class="fa fa-bar-chart" aria-hidden="true"></i>&nbsp;Show Charts</button>-->
                        
                        <!--<button type="button" class="btn btn-warning waves-effect" id="advance_search" id="hide" disabled>Advance Search</button>-->
                        <button type="button" id="reset_filters" class="btn btn-danger" name="" value="" disabled onclick="window.location.href='<?= base_url(); ?>Stocks/stocks_report'"><i class="fa fa-refresh" aria-hidden="true" ></i>&nbsp;Reset F5</button>
                    </form>
				</div>
				</div>
				<hr>

                <? /* ?><?php if($navigation){ ?>
                <div class="row">
                	<div class="col-sm-12">
                		<div class="page-title-box">
                			<div class="float-right" style="margin-bottom: 15px;">
                				<div class="btn-group" role="group" aria-label="Basic outlined example">
                				  <? if(!empty($role_permissions) && in_array(19,$role_permissions)) { ?>
                                    <!--<button type="button" style="background-color: DodgerBlue;" id="print_report" class="btn print_report" name="" value="" disabled><i class="fa fa-print" aria-hidden="true"></i>&nbsp;Print Report F6</button>-->
                                    <a type="button" id="print_report" class="btn btn-outline-primary print_report" disabled><i class="fa fa-print" aria-hidden="true"></i>&nbsp;Print</a>
                                    <? } ?>
                                    <? if(!empty($role_permissions) && in_array(20,$role_permissions)) { ?>
                                    <!--<button type="button" id="pdf_purchase_report" class="btn btn-gradient-pink pdf_purchase_report" name="" value="" disabled><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;PDF F7</button>-->
                                     <a type="button"  id="pdf_purchase_report" class="btn btn-outline-primary pdf_purchase_report" disabled><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;PDF</a>
                                    <? } ?>
                                    <? if(!empty($role_permissions) && in_array(216,$role_permissions)) { ?>
                                    <!--<button type="button" id="purchase_report_csv" class="btn btn-csv pdf_purchase_report" disabled onclick="downloadcsv();"  name="" value=""><i class="fas fa-file-csv"></i>&nbsp;CSV</button>-->
                                    <a type="button" id="navigation_report_csv" class="btn btn-outline-primary pdf_purchase_report" disabled  onclick="downloadcsv();"><i class="fa fa-file-csv" aria-hidden="true"></i>&nbsp;CSV</a>
                                    <? } ?>
                                </div>
                			</div>
                		</div><!--end page-title-box-->
                	</div><!--end col-->
                </div>
                <? } ?><? */ ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="btn-group btnprint" style="float:right; margin-bottom:10px;display:none;">
                            <? if(!empty($role_permissions) && in_array(30,$role_permissions)) { ?>
                        <a type="button" style=" border:1px solid;" id="print_report" class="btn  print_report" name="" value="" disabled><i class="fa fa-print" aria-hidden="true"></i>&nbsp;Print F6</a>
						<? } ?>
						<? if(!empty($role_permissions) && in_array(31,$role_permissions)) { ?>
                        <a type="button" style="border:1px solid;" class="btn pdf_stock_report" name="" value="" disabled><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;PDF F7</a>
						<? } ?>
						<? if(!empty($role_permissions) && in_array(222,$role_permissions)) { ?>
						<a type="button" style="border:1px solid;" id="stocks_report_csv" class="btn  " onclick="downloadcsv();" disabled name="" value=""><i class="fas fa-file-csv"></i>&nbsp; CSV</a>
						<? } ?>
                        </div>
                    </div>
                    
                </div>
                
                
				<table id="datatable100" class="table-bordered table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                	<thead class="dthead tabletop">
                	<tr>
                		<th>#</th>
                		<th>Date</th>
                		<th>Plant Name</th>
                		<th>Opening Stocks</th>
                		<th>Purchase QTY</th>
                		<th>Sale QTY</th>
                		<th>Closing Stock</th>
                	</tr>
                	</thead>
                	<tbody id="stock_data" class="stockRows">
                	    <tr>
                	        <td colspan="7" style="color:red;text-align:center;">Sorry No Record Found</td>
                	        <td style="display:none;"></td>
                	        <td style="display:none;"></td>
                	        <td style="display:none;"></td>
                	        <td style="display:none;"></td>
                	        <td style="display:none;"></td>
                	        <td style="display:none;"></td>
                	    </tr>
                	</tbody>
                </table>
			</div>
			</div> <!-- end card-body -->
		</div> <!-- end card -->                                       
	</div> <!-- end col -->
</div>
</div><!-- container -->
<script>

function showSubItem(val){
    if(val > 1){
        document.getElementById("subitem_tab").style.display = "";
    }else{
        document.getElementById("subitem_tab").style.display = "none";
    }
}


function getStockFilterDataByDate(type){
    if(type=='daily'){
        var currentdate = new Date();
        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', currentdate));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', currentdate));
        getFilterStock();
    }else if(type=='weekly'){
        var currentdate = new Date();
        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', new Date(currentdate.setDate(currentdate.getDate() - currentdate.getDay()))));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', new Date(currentdate.setDate(currentdate.getDate() - currentdate.getDay()+6))));
        getFilterStock();
    }else if(type=='monthly'){
        var date = new Date();
        var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
        var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', firstDay));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', lastDay));
        getFilterStock();
    }else if(type=='yearly'){
        var date = new Date();
        var firstDay = new Date(date.getFullYear(), 0, 1);
        var lastDay = new Date(date.getFullYear(), 11 + 1, 0);

        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', firstDay));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', lastDay));
        getFilterStock();
    }
}

    function getFilterStock(){
   
     //var table = $('#datatable_tb').DataTable();
    
     $('#datatable100').DataTable().clear().destroy();   
 	$('#stock_data').html("<tr style='background-color: #fff;' ><td colspan='9' class='center' style='text-align: center;width: 100px;' ><img src='<?php echo base_url(); ?>assets/uploads/ajax_loading.gif' ></td></tr>");
    
   var data = $("#stockfilter").serialize();
   
     jQuery.ajax({
				url  	: "<?php echo base_url(); ?>Stocks/stock_report_filter",
				type 	: 'POST',
				data 	: data,
				success : function(data){
				    console.log(data);
				    $('.btnprint').show();
						   // table.destroy();
						    $('#stock_data').html(data);
						    	var table = $('#datatable100').DataTable({
                                    "ordering": false,
                                    "pageLength": 100
                                });
						   // $('#datatable_tb').DataTable();
    						$('#print_report').removeAttr('disabled');
				            $('#pdf_stock_report').removeAttr('disabled');
				            $('#reset_filters').removeAttr('disabled');
				            $('#stocks_report_csv').removeAttr('disabled');

				}
			});	
 }
</script>
<script>
     function downloadcsv(){
        //  var form = $('#ledgerFilter').serialize();
        var formdata=$('#stockfilter').serialize();
       window.location.href="<?php echo base_url(); ?>Stocks/stocks_report_csv?"+formdata;
   }
</script>