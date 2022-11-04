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
.table-responsive {
    overflow:hidden;
}
.addbtn{
   position: relative;
   right: 20px; 
}
@media only screen and (max-width: 600px) {
.addbtn{
	right:0;
	top:5px;
}
.table-responsive {
    overflow:scroll;
}
#add_sale, #add_sale_another, #add_sale_draft, #Reset{
    margin-bottom:5px;
}
/*.btn-group, .btn-group-vertical {*/
/*    display:flow-root;*/
/*}*/
.form-control {
    min-width: 100px;
}
.page-title-box{
    display:none;
}
}
</style>
<? $role_permissions  = explode(",",$this->session->userdata('permissions')); ?>
<div class="container-fluid">
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right" style="margin-bottom:15px;">
    			<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Sales" type="button" class="btn btn-primary btn-large"><i class="fa fa-shopping-cart"></i>&nbsp;New Sale</a>
                  <a href="<?= base_url();?>Sales/manage_sales" type="button" class="btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;View Sales</a>
                  <a href="<?= base_url();?>Sales/manage_trash" type="button" class="btn btn-outline-primary"><i class="fa fa-trash"></i>&nbsp;Trashed Invoices</a>
                  <a href="<?= base_url();?>Sales/salesReport" type="button" class="btn btn-outline-primary"><i class="fa fa-bar-chart"></i>&nbsp;Sales Report</a>
                </div>
			</div>
			<!--<h4 class="page-title">+ Sale Invoice</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Sales</a></li>-->
			<!--	<li class="breadcrumb-item active">New Sale Invoice</li>-->
			<!--</ol>-->
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<div class="row" id="saleDiv">
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
				<div class="panel-body">
                    <form id="addSale" action="<?= base_url('Sales/add');?>" class="form-vertical"  method="post">
						<div class="col-sm-12">
							<h4 class="form-section"><i class="icon-eye6"></i>Invoice Details <div></div> <div class="ml3" style="float:right;color:#1ad1bc;display:none; font-size:11px;">Saved in Draft Automatically.</div></h4>
						</div>
						<hr>
						<!--<div class="row">-->
						<!--<div class="col-md-8">-->
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="supplier_sss" class="col-form-label">Customer <i class="text-danger">*</i></label>
                                    <div class="row">
                                    <div class="col-sm-10">
                                        <select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="fld_customer_id" tabindex="1" id="fld_customer_id" onchange="getBalanceVal();" required>
                                            <option selected="selected" value="">Select Customer</option>
										    <?php
											    if($customer){
												foreach($customer as $cus){
											?>
											<option value="<?= $cus['fld_id'];?>" accounts_id="<?= $cus['accounts_id'];?>" phone="<?= $cus['fld_mobile_num'];?>" email="<?= $cus['fld_email'];?>" ><?= $cus['fld_customer_name'];?><?php if($cus['fld_company_name']!=''){ echo ' - '.$cus['fld_company_name'];}?></option>
											<?php }} ?>
                                        </select>
                                        <i class="text-danger" id="f_balance">(Balance: 0)</i>
                                    </div>
                                    <? if(!empty($role_permissions) && in_array(62,$role_permissions)) { ?>
                                    <div class="col-sm-2">
                                        <a class="btn btn-success addbtn" onclick="sale_function('customerDiv')" title="Add New Customer" href="javascript:;"><i class="fa fa-user-plus"></i></a>
                                    </div>
                                    <? } ?>
                                </div> 
                            </div>
                            </div>

                             <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="date" class="col-form-label">Invoice Date <i class="text-danger">*</i></label>
                                    <!--<div class="">-->
									<input type="text" required="" tabindex="2" class="form-control datepicker" onkeyup="getDetailView();" onchange="getDetailView();" name="fld_sale_date" value="" id="fld_sale_date" >
                                    <!--</div>-->
                                </div>
                            </div>
                        <!--</div>-->
                        <!--<div class="row">-->
                            <div class="col-sm-4">
                                <div class="form-group ">
                                    <label for="invoice_no" class="col-form-label">Invoice No <i class="text-danger"></i></label>
                                    <!--<div class="col-sm-6">-->
                                        <input type="text" tabindex="3" class="form-control" placeholder="Invoice No" id="fld_invoice_no" name="fld_invoice_no">
                                    <!--</div>-->
                                </div>
                            </div>

                            <div class="col-sm-4">
                               <div class="form-group ">
                                    <label for="adress" class="col-form-label">Invoice ID</label>
                                    <!--<div class="col-sm-8">-->
										<input type="text" readonly tabindex="4" class="form-control" name="fld_voucher_no" placeholder="Voucher Number" id="fld_voucher_no" value="<?php echo $autoVoucherID;?>">
                                    <!--</div>-->
                                </div> 
                            </div>
      <!--                  </div>-->
						<!--<div class="row">-->
						    <div class="col-sm-4">
                                <div class="form-group ">
                                    <label for="invoice_no" class="col-form-label">Plant <i class="text-danger">*</i></label>
                                    <!--<div class="col-sm-6">-->
                                        <select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" onchange="getDetailView();" name="fld_location" tabindex="5" id="fld_location" required>
                                                <option value="">Select Plant</option>
												<?php
											        if($locations){
													foreach($locations as $loc){
												?>
												<option value="<?= $loc['fld_id'];?>"><?= $loc['fld_location'];?></option>
												<?php }} ?>
                                        </select>
                                    <!--</div>-->
                                </div> 
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group ">
                                    <label for="invoice_no" class="col-form-label">Product <i class="text-danger">*</i>
                                    </label>
                                    <!--<div class="col-sm-6">-->
                                        <select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="fld_category" onchange="getDetailView();" tabindex="6" id="fld_category" required>
                                                <option value="">Select Product</option>
												<?php
											        if($category){
													foreach($category as $cat){
												?>
												<option value="<?= $cat['fld_id'];?>" <?php if($cat['fld_id']==1){echo 'selected'; } ?>><?= $cat['fld_category'];?></option>
												<?php }} ?>
                                        </select>
                                    <!--</div>-->
                                </div> 
                            </div>
							
                        <!--</div>-->
                        <!--<div class="row">-->
                           <!-- <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="invoice_no" class="col-sm-4 col-form-label">Shipment <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-6">
                                        <div class="input-group">
											<input type="text" tabindex="5" class="form-control" name="fld_shipment" value="" id="fld_shipment" readonly required>
											<span class="input-group-prepend">
												<button type="button" id="location_shipments" class="btn btn-gradient-primary"><i class="fas fa-search"></i></button>
											</span>
										</div>
                                    </div>
                                </div>
                            </div> -->
						    
                            <div class="col-sm-4">
                                <div class="form-group ">
                                    <label for="invoice_no" class="col-form-label">Vehicle #</label>
                                    <!--<div class="col-sm-6">-->
                                        <input type="text" tabindex="7" class="form-control" name="fld_vehicle_no" id="fld_vehicle_no">
                                        <!--<input type="text" tabindex="5" class="form-control" name="fld_vehicle_no" required placeholder="ABC-123" id="fld_vehicle_no">-->
                                    <!--</div>-->
                                </div>
                            </div>
                            </div>
                            <!--</div>-->
                            <div style="display:none" id="stock_avail">
                                <h4 class="form-section"><i class="icon-eye6"></i>Stock Availability</h4>
                            <hr>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group ">
                                        <label for="Shipment" class="col-form-label">Shipment</label>
                                        <input type="text" tabindex="" class="form-control" name="shipment" id="shipment_view" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group ">
                                        <label for="Shipment" class="col-form-label">Qty(MT)</label>
                                        <input type="hidden" tabindex="" class="form-control" name="hqty" id="hqty_view" readonly>
                                        <!--<input type="text" tabindex="" class="form-control" name="qty" id="qty_view" readonly>-->
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group ">
                                        <label for="Shipment" class="col-form-label">Weight(KG)</label>
                                        <input type="hidden" tabindex="" class="form-control" name="hweight" id="hweight_view" readonly>
                                        <!--<input type="text" tabindex="" class="form-control" name="weight" id="weight_view" readonly>-->
                                    </div>
                                </div>
                                <!--<table id="datatable_tb" class="table table-bordered dt-responsive nowrap" style="border-collapse:collapse;border-spacing: 0;width: 70%;text-align:center;margin-left: 45px;">-->
                                <!--<tbody>-->
                                <!--<tr>-->
                                <!--<td style="width:25%;">Shipment</td>-->
                                <!--<td>N/A</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--<td style="width:25%;">Qty(MT)</td>-->
                                <!--<td>N/A</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--<td style="width:25%;">Weight(KG)</td>-->
                                <!--<td>N/A</td>-->
                                <!--</tr>-->
                                <!--</tbody>-->
                                <!--</table>-->
                            </div>
                            </div>
<!--</div>-->
<br>
<div class="form-group row">
    <div class="col-sm-12">
        <h4 class="form-section"><i class="icon-eye6"></i>Sale's History</h4><hr>
    </div>
<div class="col-sm-12" >
<style>
.search_filter td {
    border: none !important;
    background: #f1f5fa !important;
    text-align:center;
    color: #000;
    font-weight: bold;
}
.search_finalsum td {
    background: #fff !important;
    color: #000;
    font-weight: bold;
}
.table{
    font-size:12px !important;
}
.table th, .table td {
    padding-top:.75rem;
    /*padding: .25rem !important;*/
    padding-bottom:.75rem;
}
.tablebottom td {
    border: 1px;
    /*padding-top: 10px;*/
    /*padding-bottom: 10px;*/
}
.tabletop th{
    border: 1px;
    /*padding-top: 10px;*/
    /*padding-bottom: 10px;*/
    font-weight:500;
}
.table-bordered thead th {
    font-weight: 500;
    /*font-size: 10px;*/
}
</style>
<?php //if($filter_type == 1){?>
<div class="table-responsive">
<table id="datatable_tb" class="table table-bordered table-hover" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
	<thead style="background: #f1f5fa;">
	<tr>
		<th>#</th>
		<th>Invoice Date</th>
		<th>Item</th>
		<th>Qty<br>(KG)</th>
		<th>Weight<br>(KG)</th>
		<th>Rate<br>(PKR)</th>
		<th>Amount<br>(PKR)</th>
	</tr>
	</thead>
	<tbody class="purchaseRows" id="latest_sales">
	    <tr><td colspan="8" style="text-align:center;color:red;padding-top: 10px;padding-bottom: 10px;">Sorry No Record Found</td></tr>
	</tbody>
    </table>
    </div>
        </div>
    </div>
    <br>
	<div class="col-sm-12">
		<h4 class="form-section"><i class="icon-eye6"></i>Product Details</h4>
	</div>
	<hr>
						
    <div class="table-responsive">
        <table class="table table-bordered table-hover" id="purchaseTable">
            <thead>
                 <tr>
                        <th class="text-center">#</th> 
                        <th class="text-center">Item</th>
                        <th class="text-center">Shipment <br><span id="qty_view" style="display:none;font-size: 11px;color: red;font-style: italic;">0.00 (MT)</span> <span id="weight_view" style="display:none;font-size: 11px;color: red;font-style: italic;">0.00(KG)</span></th>
                        <th class="text-center">Qty <i class="text-danger">*</i></th>
                        <th class="text-center">Total Weight</th>
                        <th class="text-center">Unit Price(PKR) <i class="text-danger">*</i></th>
                        <th class="text-center">Sub Total(PKR)</th>
                        <th class="text-center">Action</th>
                    </tr>
            </thead>
            <tbody id="addPurchaseItem">
                
            </tbody>
            <tfoot id="t_total" style="display:none">
                <tr>
                    <td class="text-right" colspan="6"><b>Discount(PKR):</b></td>
                    <td class="text-right">
                        <input type="number" step="0.01" id="fld_discount" class="text-right form-control" name="fld_discount" onkeyup="calculateSum();" value="0.00" tabindex="12" oncopy="return false" ondrag="return false" ondrop="return false" onpaste="return false" oninput="validity.valid||(value='');">
                    </td>
                    
                </tr>
                <tr>
                    <td class="text-right" colspan="6"><b>Total Discount(PKR):</b></td>
                    <td class="text-right">
                        <input type="number" step="0.01" id="fld_total_discount" class="text-right form-control" name="fld_total_discount" value="0.00" readonly="readonly">
                    </td>
                    
                </tr>
                <tr>
                    <td class="text-right" colspan="6"><b>Total Weight:</b></td>
                    <td class="text-right">
                        <input type="number" step="0.01" id="fld_total_weight" class="text-right form-control" name="fld_total_weight" value="0.00" readonly="readonly">
                    </td>
                    
                </tr>
                <tr>
                    <td class="text-right" colspan="6"><b>Total:</b></td>
                    <td class="text-right">
                        <input type="number" id="fld_grand_total_amount" class="text-right form-control" name="fld_grand_total_amount" value="0.00" readonly="readonly">
                    </td>
                    <td> 
                     <button type="button" id="add_invoice_item" class="btn btn-info" name="add-invoice-item" onclick="addPurchaseOrderField1('addPurchaseItem')" ><i class="fa fa-plus"></i></button>
                    </td>
                </tr>
                
            </tfoot>
        </table>
    </div>
	<div class="col-sm-12">
			<h4 class="form-section"><i class="icon-eye6"></i>Payment Details</h4>
	</div>
	<hr>
	<div class="row">
        
        <div class="col-sm-6">
           <div class="form-group row" id="payment_type">
                <label for="invoice_no" class="col-sm-4 col-form-label">Payment Type <i class="text-danger">*</i>
                </label>
                <div class="col-sm-6">
					<select class="select2 form-control mb-3 custom-select" onchange="cpayment_type(this.value)" tabindex="13" id="fld_payment_type" name="fld_payment_type" required>
					<option value="">Select Payment Type</option>
					<option value="0">Unpaid</option>
					<option value="1">Cash</option>
					<option value="2">Bank</option>
					
					</select>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
           <div class="form-group row" id="amount_paid" style="display:none;">
                <label for="invoice_no" class="col-sm-4 col-form-label">Amount Paid <i class="text-danger"></i>
                </label>
                <div class="col-sm-6">
					<input type="text" tabindex="14" class="form-control" name="fld_paid_amount" placeholder="Amount Paid" id="fld_paid_amount">
                </div>
            </div>
        </div>
    </div>
	
	<div class="row">
        <div class="col-sm-6">
            <div class="form-group row" id="bank_account" style="display:none;">
                <label for="invoice_no" class="col-sm-4 col-form-label">Bank Account <i class="text-danger"></i></label>
                <div class="col-sm-6">
					<select tabindex="15" class="select2 form-control" id="fld_bank" name="fld_bank" >
						<option value="">Select Bank Account</option>
						<?php
							if($banks){
							foreach($banks as $bnk){
						?>
						<option value="<?= $bnk['fld_id'];?>"><?= $bnk['fld_bank'];?> - <?= $bnk['fld_account_title'];?> (<?= $bnk['fld_accountnumber'];?>)</option>
						<?php }} ?>
					</select>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
           <div class="form-group row" id="cheque_number" style="display:none;">
                <label for="invoice_no" class="col-sm-4 col-form-label">Cheque Number <i class="text-danger"></i>
                </label>
                <div class="col-sm-6">
					<input type="text" tabindex="16" class="form-control" name="fld_cheque_number" placeholder="Cheque Number" id="fld_cheque_number">
                </div>
            </div>
        </div>
    </div>
	<div class="row">
        <div class="col-sm-6">
           <div class="form-group row" id="cheque_date" style="display:none;">
                <label for="invoice_no" class="col-sm-4 col-form-label">Cheque Date </label>
                <div class="col-sm-6">
					<input type="text" tabindex="17" class="form-control datepicker" name="fld_cheque_date" placeholder="" id="fld_cheque_date">
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="form-group row">
        <div class="col-sm-12">
           <div class="form-group row" id="" style="margin-left: 30px;">
                <div class="custom-control custom-switch switch-secondary ">
                <input type="checkbox" class="custom-control-input" id="customSwitchSecondary" name="sms" checked>
                <label class="custom-control-label" for="customSwitchSecondary">Send SMS</label>
            </div>
            <i class="text-danger" id="phone"></i>
            </div>
        </div>
        <div class="col-sm-12">
           <div class="form-group row" id="" style="margin-left: 30px;">
                    <div class="custom-control custom-switch switch-secondary">
                    <input type="checkbox" class="custom-control-input" id="customSwitchemail" name="email_send" checked>
                    <label class="custom-control-label" for="customSwitchemail">Send Email</label>
                </div>
                <i class="text-danger" id="email"></i>
            </div>
        </div>
        <!--<div class="col-sm-6">
            <div class="custom-control custom-switch switch-secondary">
                <input type="checkbox" class="custom-control-input" id="customSwitchSecondary">
                <label class="custom-control-label" for="customSwitchSecondary">Send SMS</label>
            </div>
        </div>-->
    </div>
    <div class="form-group row">
        <div class="col-sm-8">
            <input type="submit" id="add_sale" class="col-sm-2 btn btn-successs" name="add-sale" value="Proceed F10" tabindex="18">
            <input type="submit" value="Submit And Add Another One F6" name="add-sale-another" class="col-sm-4 btn btn-success1" id="add_sale_another" tabindex="19">
			<input type="button" id="add_sale_draft" class="col-sm-3 btn btn-warning btn-large" name="add-sale-draft" value="Sale Draft F7" tabindex="20">
			<input type="reset"  class="col-sm-2 btn btn-danger btn-large" name="reset" id="Reset" value="Reset F5" tabindex="21">
			<input type="hidden" name="stock_location_id" id="stock_location_id" value="0"/>
			<input type="hidden" name="sale_id" id="sale_id"/>
        </div>
    </div>
    <br>
</form>
</div>
</div>
	<!----------------------------------------Add Customer ------------------------------->
	<div class="row" id="customerDiv" style="display:none;">
	<div class="col-lg-12">
		<h4 class="form-section"><i class="icon-eye6"></i>Add Customer</h4>
	</div>
	<div class="col-lg-12" style="padding:0px;">
		<hr>
	</div>
	<div class="col-lg-12" style="padding:0px;">
		<form method="post" id="addCustomer" >
		<div class="row">
		
		<div class="col-lg-6">
			<div class="mt-3">
				<label class="mb-2">Customer Code <i class="text-danger">*</i></label>
				<input type="text" class="form-control" name="fld_customer_code" readonly value="<?= $maxid;?>" required tabindex="1">            
			</div> 
			<div class="mt-3">
				<label class="mb-2">Company Name <i class="text-danger">*</i></label>
				<input type="text"  name="fld_company_name" class="form-control" id="fld_company_name" placeholder="e.g OGDCL" required tabindex="3">
			</div>
			<div class="mt-3">
				<label class="mb-2">Landline #</label>
				<input type="text" class="form-control" name="fld_landline_num" id="fld_landline_num" placeholder="e.g 0515556666" tabindex="5">
			</div>
			<div class="mt-3">
				<label class="mb-2">Opening Balance(Pkr)</label>
				<input type="text" class="form-control" name="fld_opening_bal" id="fld_opening_bal" placeholder="e.g 3500.00" tabindex="7">
			</div>
			<div class="mt-3">
				<label class="mb-2">Email</label>
				<input type="text" class="form-control" name="fld_email" id="fld_email" placeholder="test@gmail.com" tabindex="9">
			</div>
		    <div class="mt-3">
				<label class="mb-2">City</label>
				<input type="text" class="form-control" name="fld_city" id="fld_city" placeholder="e.g Peshawer" tabindex="11">
			</div>
			<div class="mt-3">
				<label class="mb-2">Country</label>
				<input type="text" class="form-control" name="fld_country" id="fld_country" placeholder="e.g Pakistan" tabindex="13">
			</div>
		</div> 
		<div class="col-lg-6">
			<div class="mt-3">
				<label class="mb-2">Customer Name <i class="text-danger">*</i></label>
				<input type="text" class="form-control" name="fld_customer_name" id="fld_customer_name" placeholder="e.g AB Agency" required tabindex="2">
			</div>
			<div class="mt-3">
				<label class="mb-2">Mobile # <i class="text-danger">*</i></label>
				<input type="text" class="form-control" name="fld_mobile_num" id="fld_mobile_num" data-inputmask="'mask': '0399-99999999'" type="text" maxlength="12" placeholder="03XX-XXXXXXX" required tabindex="4">
			</div>
			
			<div class="mt-3">
				<label class="mb-2">Customer Type <i class="text-danger">*</i></label>
				<select class="select2 form-control mb-3 custom-select" name="fld_customer_type" id="fld_customer_type" required>
					<option value="">Select type</option>
					<option value="1">Local</option>
					<option value="2">Importer</option>
				</select>
			</div>
			<div class="mt-3">
				<label class="mb-2">CNIC</label>
				<input type="text" class="form-control" data-inputmask="'mask': '99999-9999999-9'" class="form-control" placeholder="XXXXX-XXXXXXX-X" name="fld_cnic" id="fld_cnic" tabindex="8">
			</div>
			<div class="mt-3">
				<label class="mb-2">NTN</label>
				<input type="text" class="form-control" name="fld_ntn" placeholder="e.g 0622438" id="fld_ntn" tabindex="10">
			</div>
			<div class="mt-3">
				<label class="mb-2">City Area</label>
				<input type="text" class="form-control" name="fld_city_area" id="fld_city_area" placeholder="e.g Karachi" tabindex="12">
			</div> 
		</div>
		<div class="col-lg-6">
			<div class="mt-3">
				<label class="mb-2"></label>
				<button type="submit" name="submit" class="btn btn-successs">Proceed</button>
				<button type="button" onclick="sale_function('saleDiv')" class="btn btn-gradient-danger">Cancel</button>
			</div>
		</div>
		</div>
		</form>
	</div>
	</div>
		<!----------------------------------------End Supplier ------------------------------->
		</div>
		</div> <!-- end card-body -->
	</div> <!-- end card -->                                       
</div> <!-- end col -->

</div>
<?php
$category = $this->db->query("select * from tbl_category")->result_array();
foreach($category as $cat){
    $subcat = $this->db->query("select * from tbl_subcategory where fld_cid = '{$cat['fld_id']}'")->result_array();?>
	<div id="productSelect_<?=$cat['fld_id'];?>" style="display:none;">
			<?php
			    if($subcat){
				foreach($subcat as $scat){
			?>
			<option value="<?= $scat['fld_subcid'];?>" data-weight="<?= preg_replace('/[^0-9.]/', '', $scat['fld_subcategory']);?>"><?= $scat['fld_subcategory'];?></option>
			<?php }}?>
	</div> 
	<?php } ?>
	
				
</div><!-- container -->

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content" style="background-color: #fff;">
			<div class="modal-header">
				<h5 class="modal-title mt-0" id="myLargeModalLabel">Shipments</h5>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<div class="modal-body" id="shimpmentdata">
				
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
     var count = 2;
     function cpayment_type(val){
         if(val==0 || val== ''){
             $("#amount_paid").hide();
             $("#bank_account").hide();
         }else{
             $("#amount_paid").show();
             if(val == 2){
                 $("#bank_account").show();
             }else{
                 $("#bank_account").hide();
             }
         }
     }
</script>

                