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
                  <a href="<?= base_url();?>Accounts/supplier_ledger" type="button" class="btn btn-outline-primary"><i class="fa fa-shopping-cart"></i>&nbsp;Supplier Ledger</a>
                  <a href="<?= base_url();?>Accounts/customer_ledger" type="button" class="btn btn-outline-primary"><i class="fa fa-vcard"></i>&nbsp;Customer Ledger</a>
                  <a href="<?= base_url();?>Accounts/accounts_ledger" type="button" class="btn btn-outline-primary"><i class="fa fa-files-o"></i>&nbsp;Accounts Ledger</a>
                  <a href="<?= base_url();?>Accounts/item_ledger" type="button" class="btn btn-primary btn-large"><i class="fa fa-bar-chart"></i>&nbsp;Items Ledger</a>
                </div>
			</div>
			<!--<h4 class="page-title">Items Ledger</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Accounts</a></li>-->
			<!--	<li class="breadcrumb-item active">Items Ledger</li>-->
			<!--</ol>-->
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
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
				} ?>
				</div>
				<div class="panel-body" style="width:100%;padding: 0px 13px;">
				<form id="ledgerFilter" >
                                                                         
                        <input type="hidden" name="filter_type" id="filter_type" value="1" />
						<div class="col-sm-12">
							<h4 class="form-section"><i class="icon-eye6"></i>Items Ledger</h4>
						</div>
						<hr>
                        <div class="row" style=" margin-bottom: 10px;">
							<div class="col-sm-3">
    							<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="item_type" id="item_type" onchange="showSubItem(this.value)" required>
    							        <option value="">Select Item</option>
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
    							<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="sitem_type" onchange="getShipmentsLedger();" id="sitem_type" required>
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
							<div class="col-sm-3">
								<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" onchange="btnActive(this.value);" name="shipment_id" id="shipment_id" required>
										<option value="">Select Shipment</option>
								</select>
							</div>
                        </div>
                        <button type="button" id="show_report" class="btn btn-successs btn-large show_report" name="show-report" value="" onclick="getFilterData('items_ledger_filter');" disabled><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Proceed</button>
                        
                        <?// if(!empty($role_permissions) && in_array(249,$role_permissions)) { ?>
                        <!--<button type="button" style="background-color: DodgerBlue;" id="print_report" onclick="print_ledger('items_ledger_print');" class="btn  print_report" name="" value="" disabled><i class="fa fa-print" aria-hidden="true"></i>&nbsp;Print Report</button>-->
					<?// } ?>
					<?// if(!empty($role_permissions) && in_array(250,$role_permissions)) { ?>
                        <!--<button type="button" id="pdf_purchase_report" class="btn btn-gradient-pink pdf_purchase_report" onclick="pdf_ledger('items_ledger_pdf');" name="" value="" disabled><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;Download PDF</button>-->
						<?// } ?>
						
                        <button type="button" id="reset_filters" class="btn btn-danger" name="" value="" disabled onclick="window.location.href='<?= base_url(); ?>Accounts/items_ledger'"><i class="fa fa-refresh" aria-hidden="true" ></i>&nbsp;Reset Flters</button>
                        <?// if(!empty($role_permissions) && in_array(251,$role_permissions)) { ?>
    						<!--<button type="button" id="item_ledger_csv" class="btn btn-csv pdf_purchase_report" onclick="downloadcsv();" disabled name="" value=""><i class="fas fa-file-csv"></i>&nbsp;Download CSV</button>-->
    					<? //} ?>
                        
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

</div><!-- container -->
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
   
   function showSubItem(val){
       if(val==''){
           btnActive('');
           document.getElementById("subitem_tab").style.display = "none";
       }else if(val > 1){
            document.getElementById("subitem_tab").style.display = "";
            getShipmentsLedger();
        }else{
            document.getElementById("subitem_tab").style.display = "none";
            getShipmentsLedger();
        }
    }
    
    function getShipmentsLedger(){
   
        var item_id = $("#item_type").val();
        var sub_item_id = $("#sitem_type").val();
        
        var data = {item_id: item_id, sub_item_id: sub_item_id};
         jQuery.ajax({
				url  	: "<?php echo base_url(); ?>Accounts/getShipmentsLedger",
				type 	: 'POST',
				data 	: data,
				success : function(data){
				    console.log(data);
				    $("#shipment_id").html(data);
				}
			});	
    }
</script>
<script>
     function downloadcsv(){
         var form = $('#ledgerFilter').serialize();
       window.location.href="<?php echo base_url(); ?>Accounts/items_ledger_csv?"+form;
   }
</script>