<style>
.select2-container--default.select2-container--disabled .select2-selection--single {
    background-color: #212744;
    cursor: default;
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
    color: #5a5c61;
    line-height: 28px;
	padding-top: 2px;
}
.col-form-label {
    text-align: left;
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
.btn {
    line-height: 1.6;
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
#add_purchase, #add_purchase_another, #add_purchase_draft, #Reset{
    margin-bottom:5px;
}
#Reset span{
    display:none;
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

select[readonly].select2-hidden-accessible + .select2-container {
    pointer-events: none;
    touch-action: none;
}

select[readonly].select2-hidden-accessible + .select2-container .select2-selection {
    background: #eee;
    box-shadow: none;
}

select[readonly].select2-hidden-accessible + .select2-container .select2-selection__arrow, select[readonly].select2-hidden-accessible + .select2-container .select2-selection__clear {
    display: none;
}
</style>
<? $role_permissions  =  explode(",",$this->session->userdata('permissions')); ?>
<div class="container-fluid">
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right">
    			<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Purchase" type="button" class="btn btn-primary btn-large"><i class="fa fa-shopping-cart"></i>&nbsp;New Purchase Bill</a>
                  <a href="<?= base_url();?>Purchase/manage_purchase" type="button" class="btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;View Bills</a>
                  <a href="<?= base_url();?>Purchase/manage_drafts" type="button" class="btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;View Orders</a>
                  <a href="<?= base_url();?>Purchase/purchReport" type="button" class="btn btn-outline-primary"><i class="fa fa-bar-chart"></i>&nbsp;Purchase Report</a>
                </div>
			</div>
			<!--<h4 class="page-title">+ Purchase Bill</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--<li class="breadcrumb-item"><a href="javascript:void(0);">Purchase</a></li>-->
			<!--<li class="breadcrumb-item active">New Purchase Bill</li>-->
			<!--</ol>-->
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="card" style="margin-top:20px;">
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
				<div class="panel-body">
                    <form id="addPurchase" action="<?= base_url('Purchase/add');?>" class="form-vertical"  method="post" >
						<div class="col-sm-12">
							<h4 class="form-section"><i class="icon-eye6"></i>Billing Details <div class="ml3" style="float:right;color:#1ad1bc;display:none; font-size:11px;">Saved in Draft Automatically.</div></h4>
						</div>
						<hr>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group row">
                                    <label for="supplier_sss" class="col-sm-4 col-form-label">Supplier <i class="text-danger">*</i></label>
                                    <div class="col-sm-6">
                                        <select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="fld_supplier_id" tabindex="1" id="fld_supplier_id" onchange="updateValue()" required>
                                            <option selected="selected" value="">Select Supplier</option>
											<?php
    											if($supplier){
    											foreach($supplier as $sup){
											?>
											<option value="<?= $sup['fld_id'];?>" data_set="<?= $sup['fld_supplier_name'];?>"><?= $sup['fld_supplier_name'];?></option>
											<?php }} ?>
                                        </select>
                                    </div>
                                    <? if(!empty($role_permissions) && in_array(57,$role_permissions)){ ?>
                                    <div class="col-sm-2">
                                        <a class="btn btn-success addbtn" onclick="purchase_function('supplierdiv')" title="Add New Supplier" href="javascript:;"><i class="fa fa-user-plus"></i></a>
                                    </div>
                                    <? } ?>
                                </div> 
                            </div>
                            
                            <div class="col-sm-4">
                                <div class="form-group row">
                                    <label for="refinery" class="col-sm-4 col-form-label">Refinery <i class="text-danger">*</i></label>
                                    <div class="col-sm-6">
										<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="refinery" id="refinery" onchange="updateValue()" required tabindex="2" role="menu">
                                            <option selected="selected" value="">Select Refinery</option>
											<?php
											 if($refinery){
											 foreach($refinery as $ref){
											?>
											<option value="<?= $ref['fld_id'];?>" data_set="<?= $ref['fld_name'];?>"><?= $ref['fld_name'];?></option>
											<?php }} ?>
                                        </select>
                                    </div>
                                    <? if(!empty($role_permissions) && in_array(122,$role_permissions)) { ?>
                                    <div class="col-sm-2">
                                        <a class="btn btn-success addbtn" onclick="refinery_function('refinerydiv')" title="Add New Refinery" href="javascript:;"><i class="fa fa-plus"></i></a>
                                    </div>
                                    <? } ?>
                                </div>
                            </div>
                             
                            <div class="col-sm-4">
                               <div class="form-group row">
                                    <label for="adress" class="col-sm-4 col-form-label">Vehicle <i class="text-danger">*</i></label>
                                    <div class="col-sm-6">
										<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="vehicle_no" onchange="updateValue()" id="vehicle_no" tabindex="3" required>
                                            <option selected="selected" value="">Select Vehicle</option>
											<?php
												if($transporter){
												foreach($transporter as $trans){
											?>
											<option value="<?=$trans['fld_id'];?>" data_set="<?=$trans['fld_vehicle_number'];?>"><?=$trans['fld_vehicle_number'];?></option>
											<?php } } ?>
                                        </select>
                                    </div>
                                    <? if(!empty($role_permissions) && in_array(91,$role_permissions)) { ?>
                                    <div class="col-sm-2">
                                        <a class="btn btn-success addbtn" onclick="vehicle_function('vehiclediv')" title="Add New Vehicle" href="javascript:;"><i class="fa fa-plus"></i></a>
                                    </div>
                                    <? } ?>
                                </div> 
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group row">
                                    <label for="date" class="col-sm-4 col-form-label">Billing Date <i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
									<input type="text" required="" tabindex="4" class="form-control datepicker" name="fld_purchase_date" id="fld_purchase_date" onchange="updateValue()">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                               <div class="form-group row">
                                    <label for="adress" class="col-sm-4 col-form-label">Bill ID</label>
                                    <div class="col-sm-8">
										<input type="text" readonly tabindex="5" class="form-control" name="fld_voucher_no" placeholder="Voucher Number" id="fld_voucher_no" value="<?php echo $autoVoucherID;?>">
                                    </div>
                                </div> 
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group row">
                                    <label for="invoice_no" class="col-sm-4 col-form-label">Invoice No <i class="text-danger"></i></label>
                                    <div class="col-sm-6">
                                        <input type="text" tabindex="6" class="form-control" placeholder="e.g 156925" id="fld_invoice_no" name="fld_invoice_no" >
                                    </div>
                                </div>
                            </div>
                        </div>
                        
						<div class="row">
                            <div class="col-sm-8">
                                <div class="form-group row">
                                    <label for="invoice_no" class="col-sm-2 col-form-label">Shipment <i class="text-danger">*</i></label>
                                    <div class="col-sm-10">
                                        <input type="text" tabindex="7" class="form-control" name="fld_shipment" required placeholder="OGDCL/Nashpa/RIK-6158/5-4-2021" readonly id="fld_shipment">
                                    </div>
                                </div>
                            </div>
							<div class="col-sm-4">
                                <div class="form-group row">
                                    <label for="supplier_sss" class="col-sm-4 col-form-label">Location</label>
                                    <div class="col-sm-6">
                                        <select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="fld_location" tabindex="8" id="fld_location" >
                                                <option value="">Select Location</option>
												<?php
												if($locations){
												foreach($locations as $loc){
												?>
												<option value="<?= $loc['fld_id'];?>" <?= ($loc['fld_location'] == "In Transit" || $loc['fld_location'] == "in transit") ? 'selected':'';?>><?= $loc['fld_location'];?></option>
												<?php }} ?>
                                        </select>
                                    </div>
                                </div> 
                            </div>
                        </div>
						<div class="col-sm-12">
							<h4 class="form-section"><i class="icon-eye6"></i>Product Details</h4>
						</div>
						<hr>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="purchaseTable">
                                <thead>
                                     <tr>
                                        <th class="text-center" width="20%">Product Category<i class="text-danger">*</i></th> 
                                        <th class="text-center">Product SubCategory</th>
                                        <th class="text-center">Unit Code</th>
                                        <th class="text-center">Qty <i class="text-danger">*</i></th>
                                        <th class="text-center">Unit Price <i class="text-danger">*</i></th>
                                        <th class="text-center">Sub Total (PKR)</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="addPurchaseItem">
                                    <tr>
                                        <td class="span3 supplier">
                                           <select class="select2 form-control mb-3 custom-select fld_product_id" name="fld_product_id[]" onchange="product_category(1);" tabindex="9" id="product_id_1" required>
                                                <option value="">Select Product</option>
												<?php
												if($category){
												foreach($category as $cat){
												?>
												<option value="<?= $cat['fld_id'];?>" data-unit="<?= $cat['fld_unit'];?>"><?= $cat['fld_category'];?></option>
												<?php }} ?>
											</select>
                                        </td>
                                        <td class="span3">
                                           <select class="select2 form-control mb-3 custom-select sub_category" onchange="check_sub_product()" name="sub_category[]" id="sub_category_1" tabindex="10" required>
                                                <option value="0">Select Sub Category</option>
											</select>
                                        </td>
                                        <td class="wt">
                                            <input type="text" id="unit_code_1" class="form-control text-center" placeholder="Unit Code" readonly>
                                        </td>
                                        <td class="text-right">
                                            <input type="number" step="0.001" required name="fld_quantity[]" id="cartoon_1" required min="0" class="form-control text-right" onkeyup="calculate_store(1);" onchange="calculate_store(1);" placeholder="0.00" value="" tabindex="11" aria-required="true" onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false" oninput="validity.valid||(value='');">
                                        </td>
                                        <td class="test">
                                            <input type="number" name="fld_unit_price[]" required="" onkeyup="calculate_store(1);" onchange="calculate_store(1);" id="product_rate_1" class="form-control product_rate_1 text-right" placeholder="0.00" value="" min="0.01" step="0.01" tabindex="12" aria-required="true" onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false" oninput="validity.valid||(value='');">
                                        </td>
                                        <td class="text-right">
                                            <input class="form-control total_price text-right" type="text" name="fld_total_amount[]" id="total_price_1" value="0.00" min="1" step="any" readonly="readonly">
                                        </td>
                                        <td>
                                            <button class="btn btn-danger text-right red" type="button" value="Delete" onclick="deleteRow(this)" ><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-right" colspan="5"><b>Total (PKR):</b></td>
                                        <td class="text-right">
                                            <input type="text" id="fld_grand_total_amount" class="text-right form-control" name="fld_grand_total_amount" value="0.00" readonly="readonly">
                                        </td>
                                        <td> 
                                        <button type="button" id="add_invoice_item" class="btn btn-success" name="add-invoice-item" onclick="addPurchaseOrderField1('addPurchaseItem')" ><i class="fa fa-plus"></i></button>
                                        <input type="hidden" name="baseUrl" class="baseUrl" value="http://localhost/erp/"></td>
                                    </tr>
                                    <?php /*?><tr>
                                        <td class="text-right" colspan="4"><b>Discount:</b></td>
                                        <td class="text-right">
                                            <input type="text" id="discount" class="text-right form-control discount" onkeyup="calculate_store(1)" name="discount" placeholder="0.00" value="">
                                        </td>
                                        <td> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-right" colspan="4"><b>Grand Total:</b></td>
                                        <td class="text-right">
                                            <input type="text" id="grandTotal" class="text-right form-control" name="grand_total_price" value="0.00" readonly="readonly">
                                        </td>
                                        <td> </td>
                                    </tr>
                                     <tr>
                                        <td class="text-right" colspan="4"><b>Paid Amount:</b></td>
                                        <td class="text-right">
                                            <input type="text" id="paidAmount" class="text-right form-control" onkeyup="invoice_paidamount()" name="paid_amount" value="">
                                        </td>
                                        <td> </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="text-right">
                                             <!--<input type="button" id="full_paid_tab" class="btn btn-warning" value="Full Paid" tabindex="16" onclick="full_paid()">-->
                                        </td>
                                        <td class="text-right" colspan="2"><b>Due Amount:</b></td>
                                        <td class="text-right">
                                            <input type="text" id="dueAmmount" class="text-right form-control" name="due_amount" value="0.00" readonly="readonly">
                                        </td>
                                        <td></td>
                                    </tr><?php */?>
                                </tfoot>
                            </table>
                        </div>
						<!--<div class="col-sm-12">-->
						<!--	<h4 class="form-section"><i class="icon-eye6"></i>Payment Details</h4>-->
						<!--</div>-->
						<!--<hr>-->
						<div class="row" style="display:none">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="invoice_no" class="col-sm-4 col-form-label">Payment Status <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-6">
										<select tabindex="13" class="select2 form-control mb-3 custom-select" onchange="paymet_status(this.value)" id="fld_payment_status" name="fld_payment_status" required="required">
											<option value="">Select Payment Status</option>
											<option value="1" selected>Paid</option>
											<option value="2">Partial Paid</option>
											<option value="3" >UnPaid</option>
											<option value="4" >Advance Payment</option>
										</select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                               <div class="form-group row" id="payment_type" style="display:none;">
                                    <label for="invoice_no" class="col-sm-4 col-form-label">Payment Type <i class="text-danger"></i>
                                    </label>
                                    <div class="col-sm-6">
										<select class="select2 form-control mb-3 custom-select" onchange="bank_paymet(this.value)" tabindex="14" id="fld_payment_type" name="fld_payment_type">
										<option value="">Select Payment Type</option>
										<option value="1">Cash</option>
										<option value="2">Bank</option>
										<option value="3">Cheque</option>
										</select>
                                    </div>
                                </div>
                            </div>
      <!--                  </div>-->
						
						<!--<div class="row">-->
                            <div class="col-sm-6">
                                <div class="form-group row" id="bank_account" style="display:none;">
                                    <label for="invoice_no" class="col-sm-4 col-form-label">Bank Account <i class="text-danger"></i>
                                    </label>
                                    <div class="col-sm-6">
										<select tabindex="15" class="select2 form-control mb-3 custom-select" id="fld_bank" name="fld_bank" >
											<option value="">Select Bank Account</option>
											<?php
												if($banks){
												foreach($banks as $bnk){
											?>
											<option value="<?= $bnk['fld_id'];?>"><?= $bnk['fld_bank'];?></option>
											<?php }}?>
										</select>
                                    </div>
                                </div>
                            </div>
          <!--                  <div class="col-sm-6">-->
          <!--                     <div class="form-group row" id="account_no" style="display:none;">-->
          <!--                          <label for="invoice_no" class="col-sm-4 col-form-label">Enter Accout Number <i class="text-danger"></i>-->
          <!--                          </label>-->
          <!--                          <div class="col-sm-6">-->
										<!--<input type="text" tabindex="16" class="form-control" name="fld_account_number" placeholder="Enter Accout Number " id="fld_account_number">-->
          <!--                          </div>-->
          <!--                      </div>-->
          <!--                  </div>-->
                            <div class="col-sm-6">
                               <div class="form-group row" id="cheque_number" style="display:none;">
                                    <label for="invoice_no" class="col-sm-4 col-form-label">Cheque Number <i class="text-danger"></i></label>
                                    <div class="col-sm-6">
										<input type="text" tabindex="16" class="form-control" name="fld_cheque_number" placeholder="Cheque Number" id="fld_cheque_number">
                                    </div>
                                </div>
                            </div>
      <!--                  </div>-->
						<!--<div class="row">-->
                            <div class="col-sm-6">
                               <div class="form-group row" id="cheque_date" style="display:none;">
                                    <label for="invoice_no" class="col-sm-4 col-form-label">Cheque Date 
									<i class="text-danger"></i>
                                    </label>
                                    <div class="col-sm-6">
										<input type="text" tabindex="17" class="form-control datepicker" name="fld_cheque_date" placeholder="" id="fld_cheque_date">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <p style="color:red;">Note: If location is In Transit then please check Inventory (A/C) else check concerns Ware House/ Plant Inventory A/C. <br>To trace stock , If In Transit is chosen as Location then Please check InTransit Navigation to Navigate it Further else Stock can be traced in concerns Plants/Ware House. <br>To Add Freight details, please choose In-Transit as location.</p>
                                <input type='hidden' id='purchase_id' name="purchase_id">
                                <input type="submit" tabindex="18" id="add_purchase" class="col-sm-2 btn btn-successs" name="add-purchase" value="Proceed F10">
                                <!--<button type="submit" tabindex="18" id="add_purchase" class="col-sm-2 btn btn-successs" name="add-purchase">Proceed <span>F10</span></button>-->
                                <input type="submit" tabindex="19" value="Proceed And Add Another One F6" name="add-purchase-another" class="col-sm-3 btn btn-success1" id="add_purchase_another">
                                <!--<button type="submit" tabindex="19" id="add_purchase_another" class="col-sm-3 btn btn-success1" name="add-purchase-another">Proceed And Add Another One <span>F6</span></button>-->
								<input type="button" tabindex="20" id="add_purchase_draft" class="col-sm-2 btn btn-warning btn-large" name="add-purchase-draft" value="Save as Draft F7">
								<!--<button type="submit" tabindex="20" id="add_purchase_draft" class="col-sm-2 btn btn-warning btn-large" name="add-purchase-draft">Save as Draft <span>F7</span></button>-->
								<input type="reset" tabindex="21" class="col-sm-2 btn btn-danger btn-large" name="reset" id="Reset" value="Reset F5">
								<!--<button type="reset" tabindex="21" id="Reset" class="col-sm-2 btn btn-danger btn-large" name="reset">Reset <span>F5</span></button>-->
                            </div>
                        </div>
                        <br>
                    </form>
                </div>
				</div>
				
				<!-----------------------------Add Refinery ------------------------------->
				<div class="row" id="refinerydiv" style="display:none;">
				<div class="col-lg-12">
					<h4 class="form-section"><i class="icon-eye6"></i>Add Refinery</h4>
				</div>
				<div class="col-lg-12" style="padding:0px;">
					<hr>
				</div>
				<form method="post" id="addRefinery" style="width: 100%;">
				<div class="row">
				<div class="col-lg-6">
					<div class="mt-3">
						<label class="mb-2">Refinery Name <i class="text-danger">*</i></label>
						<input type="text" class="form-control" placeholder="e.g NASHPA.." name="fld_name" tabindex="1" id="fld_name" required>
					</div>
				</div>	
				<div class="col-lg-6">	
					<div class="mt-3">
						<label class="mb-2">Address</label>
						<input type="text" class="form-control" placeholder="e.g Karachi" name="fld_address" tabindex="2" id="fld_address">
					</div>
				</div> 
				<div class="col-lg-6">
					<div class="mt-3">
						<label class="mb-2"></label>
						<button type="submit" name="submit" class="btn btn-gradient-primary">Submit</button>
						<button type="button" onclick="purchase_function('purchasediv')" class="btn btn-gradient-danger">Cancel</button>
					</div>
				</div>
				
				</div>
				</form>
				</div>
		<!----------------------------------------End Refinery ------------------------------->
		
		<!----------------------------------------Add Vehicle No ------------------------------->
				<div class="row" id="vehiclediv" style="display:none;">
				<div class="col-lg-12">
					<h4 class="form-section"><i class="icon-eye6"></i>Add Transport/Bowser</h4>
				</div>
				<div class="col-lg-12" style="padding:0px;">
					<hr>
				</div>
				<form method="post" id="addVehicle" style="width: 100%;">
				<div class="row">
				<div class="col-lg-6">
					
                    <div class="mt-3">
						<label class="mb-2">Vehicle No. <i class="text-danger">*</i></label>
						
						<input type="text" class="form-control"  name="fld_vehicle_number" placeholder="e.g V-001" id="fld_vehicle_number" required>
					</div>
					<div class="mt-3">
						<label class="mb-2">Driver one Name <i class="text-danger">*</i></label>
						
						<input type="text" class="form-control"  name="fld_dname1" placeholder="e.g Aslam khan" id="fld_dname1" required>
					</div>
					<div class="mt-3">
						<label class="mb-2">Driver one CNIC</label>
						
						<input type="text" class="form-control"  name="fld_dcnic1" placeholder="e.g 00000-0000000-0" id="fld_dcnic1">
					</div> 
					<div class="mt-3">
						<label class="mb-2">Driver one Mobile <i class="text-danger">*</i></label>
						
						<input type="text" class="form-control"  name="fld_dmobile1" placeholder="e.g 0000-0000000" id="fld_dmobile1" required>
					</div> 
					<div class="mt-3">
						<label class="mb-2">Driver one Address</label>
						
						<input type="text" class="form-control"  name="fld_daddress1" placeholder="e.g Rawalpindi, Pakistan" id="fld_daddress1">
					</div> 
					<div class="mt-3">
						<label class="mb-2">Driver one License</label>
						
						<input type="text" class="form-control"  name="fld_dlicense1" placeholder="e.g ZP001234" id="fld_dlicense1">
					</div> 
					<div class="mt-3">
						<label class="mb-2">Driver one License Issue</label>
						
						<input type="text" class="form-control datepicker"  name="fld_dlicense_issue1" id="fld_dlicense_issue1">
					</div> 
					<div class="mt-3">
						<label class="mb-2">Driver one License Expire</label>
						
						<input type="text" class="form-control datepicker"  name="fld_dlicense_expire1"  id="fld_dlicense_expire1">
					</div> 
				
					<div class="mt-3">
						<label class="mb-2">Vehicle (Owned By) <i class="text-danger">*</i></label>
						<select class="select2 form-control custom-select" name="fld_vehicle_type" id="fld_vehicle_type" required>
							<option value="1" selected>Self</option>
							<option value="2">Other</option>
						</select>
					</div>
				    <div class="mt-3">
						<label class="mb-2">COA</label>
						
						<input type="text" class="form-control" id="fld_coa" value="COA->Income->Other Income->Bowzer Income" readonly>
					</div>       
					                                  
					                            
				</div> 
				
				<div class="col-lg-6">
				    <div class="mt-3">
						<label class="mb-2">Owner Name</label>
						
						<input type="text" class="form-control" placeholder="e.g Aslam khan"  name="fld_owner_name"  id="fld_owner_name">
					</div>
					
				    <div class="mt-3">
						<label class="mb-2">Driver two Name </label>
						
						<input type="text" class="form-control"  name="fld_dname2" placeholder="e.g Aslam khan" id="fld_dname2" >
					</div>
					<div class="mt-3">
						<label class="mb-2">Driver two CNIC </label>
						
						<input type="text" class="form-control"  name="fld_dcnic2" placeholder="e.g 00000-0000000-0" id="fld_dcnic2" >
					</div> 
					<div class="mt-3">
						<label class="mb-2">Driver two Mobile </label>
						
						<input type="text" class="form-control"  name="fld_dmobile2" placeholder="e.g 0000-0000000" id="fld_dmobile2" >
					</div> 
					<div class="mt-3">
						<label class="mb-2">Driver two Address </label>
						
						<input type="text" class="form-control"  name="fld_daddress2" placeholder="e.g Rawalpindi, Pakistan" id="fld_daddress2" >
					</div> 
					<div class="mt-3">
						<label class="mb-2">Driver two License </label>
						
						<input type="text" class="form-control"  name="fld_dlicense2" placeholder="e.g ZP001234" id="fld_dlicense2" >
					</div> 
					<div class="mt-3">
						<label class="mb-2">Driver two License Issue </label>
						
						<input type="text" class="form-control datepicker"  name="fld_dlicense_issue2" id="fld_dlicense_issue2" >
					</div> 
					<div class="mt-3">
						<label class="mb-2">Driver two License Expire </label>
						
						<input type="text" class="form-control datepicker"  name="fld_dlicense_expire2"  id="fld_dlicense_expire2" >
					</div> 
					<div class="mt-3">
						<label class="mb-2">Area Cover</label>
						
						<input type="text" class="form-control"  name="fld_area" placeholder="e.g 116 square miles.." id="fld_area" >
					</div>
					                         
					                            
				</div> 
				<div class="col-lg-6">
					<div class="mt-3">
						<label class="mb-2"></label>
						<button type="submit" name="submit" class="btn btn-gradient-primary">Submit</button>
						<button type="button" onclick="purchase_function('purchasediv')" class="btn btn-gradient-danger">Cancel</button>
					</div>
				</div>
				</div>
				</form>
				
				</div>
		<!----------------------------------------End Vehicle No ------------------------------->
	<!----------------------------------------Add Supplier ------------------------------->
				<div class="row" id="supplierdiv" style="display:none;">
				<div class="col-lg-12">
					<h4 class="form-section"><i class="icon-eye6"></i>Add Supplier</h4>
				</div>
				<div class="col-lg-12" style="padding:0px;">
					<hr>
				</div>
				
				<form method="post" id="addSupplier" style="width: 100%;">
				<div class="row">
				<div class="col-lg-6">
					<div class="mt-3">
						<label class="mb-2">Supplier Code <i class="text-danger">*</i></label>
						<input type="text" class="form-control" name="fld_supplier_code" readonly value="<?= $maxid;?>" required tabindex="1">            
					</div> 
					<div class="mt-3">
						<label class="mb-2">Company Name <i class="text-danger">*</i></label>
						<input type="text"  name="fld_company_name" class="form-control" id="fld_company_name" placeholder="e.g OGDCL" required tabindex="3">
					</div>
					
					<div class="mt-3">
						<label class="mb-2">Landline #</label>
						<input type="text" class="form-control" name="fld_landline_num" placeholder="e.g 0515556666" id="fld_landline_num" tabindex="5">
					</div>
					
					<div class="mt-3">
						<label class="mb-2">Opening Balance (Pkr)</label>
						<input type="text" class="form-control" name="fld_opening_bal" placeholder="e.g 3500.00" id="fld_opening_bal" tabindex="7">
					</div>
					<div class="mt-3">
						<label class="mb-2">Email</label>
						<input type="text" class="form-control" name="fld_email" placeholder="test@gmail.com" id="fld_email" tabindex="9">
					</div>
				    <div class="mt-3">
						<label class="mb-2">City</label>
						<input type="text" class="form-control" name="fld_city" placeholder="e.g Peshawer" id="fld_city" tabindex="11">
					</div>
					<div class="mt-3">
						<label class="mb-2">Country</label>
						<?php 
						  $countries = array("PK" => "Pakistan",
						        "AF" => "Afghanistan",
                                "AX" => "Åland Islands",
                                "AL" => "Albania",
                                "DZ" => "Algeria",
                                "AS" => "American Samoa",
                                "AD" => "Andorra",
                                "AO" => "Angola",
                                "AI" => "Anguilla",
                                "AQ" => "Antarctica",
                                "AG" => "Antigua and Barbuda",
                                "AR" => "Argentina",
                                "AM" => "Armenia",
                                "AW" => "Aruba",
                                "AU" => "Australia",
                                "AT" => "Austria",
                                "AZ" => "Azerbaijan",
                                "BS" => "Bahamas",
                                "BH" => "Bahrain",
                                "BD" => "Bangladesh",
                                "BB" => "Barbados",
                                "BY" => "Belarus",
                                "BE" => "Belgium",
                                "BZ" => "Belize",
                                "BJ" => "Benin",
                                "BM" => "Bermuda",
                                "BT" => "Bhutan",
                                "BO" => "Bolivia",
                                "BA" => "Bosnia and Herzegovina",
                                "BW" => "Botswana",
                                "BV" => "Bouvet Island",
                                "BR" => "Brazil",
                                "IO" => "British Indian Ocean Territory",
                                "BN" => "Brunei Darussalam",
                                "BG" => "Bulgaria",
                                "BF" => "Burkina Faso",
                                "BI" => "Burundi",
                                "KH" => "Cambodia",
                                "CM" => "Cameroon",
                                "CA" => "Canada",
                                "CV" => "Cape Verde",
                                "KY" => "Cayman Islands",
                                "CF" => "Central African Republic",
                                "TD" => "Chad",
                                "CL" => "Chile",
                                "CN" => "China",
                                "CX" => "Christmas Island",
                                "CC" => "Cocos (Keeling) Islands",
                                "CO" => "Colombia",
                                "KM" => "Comoros",
                                "CG" => "Congo",
                                "CD" => "Congo, The Democratic Republic of The",
                                "CK" => "Cook Islands",
                                "CR" => "Costa Rica",
                                "CI" => "Cote D'ivoire",
                                "HR" => "Croatia",
                                "CU" => "Cuba",
                                "CY" => "Cyprus",
                                "CZ" => "Czech Republic",
                                "DK" => "Denmark",
                                "DJ" => "Djibouti",
                                "DM" => "Dominica",
                                "DO" => "Dominican Republic",
                                "EC" => "Ecuador",
                                "EG" => "Egypt",
                                "SV" => "El Salvador",
                                "GQ" => "Equatorial Guinea",
                                "ER" => "Eritrea",
                                "EE" => "Estonia",
                                "ET" => "Ethiopia",
                                "FK" => "Falkland Islands (Malvinas)",
                                "FO" => "Faroe Islands",
                                "FJ" => "Fiji",
                                "FI" => "Finland",
                                "FR" => "France",
                                "GF" => "French Guiana",
                                "PF" => "French Polynesia",
                                "TF" => "French Southern Territories",
                                "GA" => "Gabon",
                                "GM" => "Gambia",
                                "GE" => "Georgia",
                                "DE" => "Germany",
                                "GH" => "Ghana",
                                "GI" => "Gibraltar",
                                "GR" => "Greece",
                                "GL" => "Greenland",
                                "GD" => "Grenada",
                                "GP" => "Guadeloupe",
                                "GU" => "Guam",
                                "GT" => "Guatemala",
                                "GG" => "Guernsey",
                                "GN" => "Guinea",
                                "GW" => "Guinea-bissau",
                                "GY" => "Guyana",
                                "HT" => "Haiti",
                                "HM" => "Heard Island and Mcdonald Islands",
                                "VA" => "Holy See (Vatican City State)",
                                "HN" => "Honduras",
                                "HK" => "Hong Kong",
                                "HU" => "Hungary",
                                "IS" => "Iceland",
                                "IN" => "India",
                                "ID" => "Indonesia",
                                "IR" => "Iran, Islamic Republic of",
                                "IQ" => "Iraq",
                                "IE" => "Ireland",
                                "IM" => "Isle of Man",
                                "IL" => "Israel",
                                "IT" => "Italy",
                                "JM" => "Jamaica",
                                "JP" => "Japan",
                                "JE" => "Jersey",
                                "JO" => "Jordan",
                                "KZ" => "Kazakhstan",
                                "KE" => "Kenya",
                                "KI" => "Kiribati",
                                "KP" => "Korea, Democratic People's Republic of",
                                "KR" => "Korea, Republic of",
                                "KW" => "Kuwait",
                                "KG" => "Kyrgyzstan",
                                "LA" => "Lao People's Democratic Republic",
                                "LV" => "Latvia",
                                "LB" => "Lebanon",
                                "LS" => "Lesotho",
                                "LR" => "Liberia",
                                "LY" => "Libyan Arab Jamahiriya",
                                "LI" => "Liechtenstein",
                                "LT" => "Lithuania",
                                "LU" => "Luxembourg",
                                "MO" => "Macao",
                                "MK" => "Macedonia, The Former Yugoslav Republic of",
                                "MG" => "Madagascar",
                                "MW" => "Malawi",
                                "MY" => "Malaysia",
                                "MV" => "Maldives",
                                "ML" => "Mali",
                                "MT" => "Malta",
                                "MH" => "Marshall Islands",
                                "MQ" => "Martinique",
                                "MR" => "Mauritania",
                                "MU" => "Mauritius",
                                "YT" => "Mayotte",
                                "MX" => "Mexico",
                                "FM" => "Micronesia, Federated States of",
                                "MD" => "Moldova, Republic of",
                                "MC" => "Monaco",
                                "MN" => "Mongolia",
                                "ME" => "Montenegro",
                                "MS" => "Montserrat",
                                "MA" => "Morocco",
                                "MZ" => "Mozambique",
                                "MM" => "Myanmar",
                                "NA" => "Namibia",
                                "NR" => "Nauru",
                                "NP" => "Nepal",
                                "NL" => "Netherlands",
                                "AN" => "Netherlands Antilles",
                                "NC" => "New Caledonia",
                                "NZ" => "New Zealand",
                                "NI" => "Nicaragua",
                                "NE" => "Niger",
                                "NG" => "Nigeria",
                                "NU" => "Niue",
                                "NF" => "Norfolk Island",
                                "MP" => "Northern Mariana Islands",
                                "NO" => "Norway",
                                "OM" => "Oman",
                                "PW" => "Palau",
                                "PS" => "Palestinian Territory, Occupied",
                                "PA" => "Panama",
                                "PG" => "Papua New Guinea",
                                "PY" => "Paraguay",
                                "PE" => "Peru",
                                "PH" => "Philippines",
                                "PN" => "Pitcairn",
                                "PL" => "Poland",
                                "PT" => "Portugal",
                                "PR" => "Puerto Rico",
                                "QA" => "Qatar",
                                "RE" => "Reunion",
                                "RO" => "Romania",
                                "RU" => "Russian Federation",
                                "RW" => "Rwanda",
                                "SH" => "Saint Helena",
                                "KN" => "Saint Kitts and Nevis",
                                "LC" => "Saint Lucia",
                                "PM" => "Saint Pierre and Miquelon",
                                "VC" => "Saint Vincent and The Grenadines",
                                "WS" => "Samoa",
                                "SM" => "San Marino",
                                "ST" => "Sao Tome and Principe",
                                "SA" => "Saudi Arabia",
                                "SN" => "Senegal",
                                "RS" => "Serbia",
                                "SC" => "Seychelles",
                                "SL" => "Sierra Leone",
                                "SG" => "Singapore",
                                "SK" => "Slovakia",
                                "SI" => "Slovenia",
                                "SB" => "Solomon Islands",
                                "SO" => "Somalia",
                                "ZA" => "South Africa",
                                "GS" => "South Georgia and The South Sandwich Islands",
                                "ES" => "Spain",
                                "LK" => "Sri Lanka",
                                "SD" => "Sudan",
                                "SR" => "Suriname",
                                "SJ" => "Svalbard and Jan Mayen",
                                "SZ" => "Swaziland",
                                "SE" => "Sweden",
                                "CH" => "Switzerland",
                                "SY" => "Syrian Arab Republic",
                                "TW" => "Taiwan, Province of China",
                                "TJ" => "Tajikistan",
                                "TZ" => "Tanzania, United Republic of",
                                "TH" => "Thailand",
                                "TL" => "Timor-leste",
                                "TG" => "Togo",
                                "TK" => "Tokelau",
                                "TO" => "Tonga",
                                "TT" => "Trinidad and Tobago",
                                "TN" => "Tunisia",
                                "TR" => "Turkey",
                                "TM" => "Turkmenistan",
                                "TC" => "Turks and Caicos Islands",
                                "TV" => "Tuvalu",
                                "UG" => "Uganda",
                                "UA" => "Ukraine",
                                "AE" => "United Arab Emirates",
                                "GB" => "United Kingdom",
                                "US" => "United States",
                                "UM" => "United States Minor Outlying Islands",
                                "UY" => "Uruguay",
                                "UZ" => "Uzbekistan",
                                "VU" => "Vanuatu",
                                "VE" => "Venezuela",
                                "VN" => "Viet Nam",
                                "VG" => "Virgin Islands, British",
                                "VI" => "Virgin Islands, U.S.",
                                "WF" => "Wallis and Futuna",
                                "EH" => "Western Sahara",
                                "YE" => "Yemen",
                                "ZM" => "Zambia",
                                "ZW" => "Zimbabwe");
                               // ksort($countries);
						?>
						
						<select class="select2 form-control mb-3 custom-select" name="fld_country" id="fld_country" tabindex="13">
                            <?php
                            foreach($countries as $key => $value) {
                            ?>
                            <option value="<?= $key ?>" title="<?= htmlspecialchars($value) ?>" ><?= htmlspecialchars($value) ?></option>
                            <?php } ?>
                        </select>
					</div>
					                            
				</div> 
				<div class="col-lg-6">
					<div class="mt-3">
						<label class="mb-2">Supplier Name <i class="text-danger">*</i></label>
						<input type="text" class="form-control" name="fld_supplier_name" placeholder="e.g OGDCL" id="fld_supplier_name" required tabindex="2">
					</div>
					<div class="mt-3">
						<label class="mb-2">Mobile # <i class="text-danger">*</i></label>
						<input type="text" class="form-control" name="fld_mobile_num" data-inputmask="'mask': '0399-99999999'"  type = "text" maxlength = "12"   placeholder="03XX-XXXXXXX" id="fld_mobile_num" required tabindex="4">
					</div>
					
					<div class="mt-3">
						<label class="mb-2">Supplier Type <i class="text-danger">*</i></label>
						<select class="select2 form-control mb-3 custom-select" name="fld_supplier_type" id="fld_supplier_type" required tabindex="6" placeholder="Select type">
							<option value="" style="color:grey;">Select type</option>
							<option value="1">Local</option>
							<option value="2">Importer</option>
						</select>
					</div>
					<div class="mt-3">
						<label class="mb-2">CNIC</label>
						<input type="text" data-inputmask="'mask': '99999-9999999-9'" class="form-control" placeholder="XXXXX-XXXXXXX-X" name="fld_cnic"  id="fld_cnic" tabindex="8">
					</div>
					<div class="mt-3">
						<label class="mb-2">NTN</label>
						<input type="text" class="form-control" name="fld_ntn" placeholder="e.g 0622438" id="fld_ntn" tabindex="10">
					</div>
					<div class="mt-3">
						<label class="mb-2">City Area</label>
						<input type="text" class="form-control" name="fld_city_area" placeholder="e.g Karachi" id="fld_city_area" tabindex="12">
					</div> 
				</div>
				<div class="col-lg-6">
					<div class="mt-3">
						<label class="mb-2"></label>
						<button type="submit" name="submit" class="btn btn-gradient-primary">Submit</button>
						<button type="button" onclick="purchase_function('purchasediv')" class="btn btn-gradient-danger">Cancel</button>
					</div>
				</div>
				</div>
				</form>
				
				</div>
<!---------------------------------------- End Supplier ------------------------------->
			</div>
			</div><!-- end card-body -->
		</div><!-- end card -->                                       
	</div><!-- end col -->


</div>
	<div id="productSelect" style="display:none;">
		<?php if($category){
		    foreach($category as $cat){
		?>
		<option value="<?= $cat['fld_id'];?>" data-unit="<?= $cat['fld_unit'];?>"><?= $cat['fld_category'];?></option>
		<?php }} ?>
	</div>             

</div><!-- container -->
<script>

</script>
