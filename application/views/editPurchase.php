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
<? $role_permissions  = explode(",",$this->session->userdata('permissions')); ?>
<div class="container-fluid">
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right" style="margin-bottom:15px;">
			    <div class="btn-group" role="group" aria-label="Basic outlined example">
			      <a href="<?= base_url();?>Purchase" type="button" class="btn btn-primary btn-large"><i class="fa fa-shopping-cart"></i>&nbsp;New Purchase Bill</a>
                  <a href="<?= base_url();?>Purchase/manage_purchase" type="button" class="btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;View Bills</a>
                  <a href="<?= base_url();?>Purchase/manage_drafts" type="button" class="btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;View Orders</a>
                  <a href="<?= base_url();?>Purchase/purchReport" type="button" class="btn btn-outline-primary"><i class="fa fa-bar-chart"></i>&nbsp;Purchase Report</a>
                </div>  
				<!--<ol class="breadcrumb">-->
				<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Edit Purchase Bill</a></li>-->
				<!--	<li class="breadcrumb-item active">Edit Purchase Bill</li>-->
				<!--</ol>-->
			</div>
			<!--<h4 class="page-title">Edit Purchase</h4>-->
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
				} ?>
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
				<div class="panel-body">
                    <form id="editpurchase" action="<?= base_url('Purchase/update');?>" class="form-vertical" method="post">
						<div class="col-sm-12">
							<h4 class="form-section"><i class="icon-eye6"></i>Billing Details</h4>
						</div>
						<hr>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group row">
                                    <label for="supplier_sss" class="col-sm-4 col-form-label">Supplier <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-6">
                                        <select tabindex="1" class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="fld_supplier_id" id="fld_supplier_id" onchange="updateValue()" required>
                                                <option selected="selected" value="">Select Supplier</option>
												<?php
												if($supplier){
													foreach($supplier as $sup){
												?>
												<option value="<?= $sup['fld_id'];?>" data_set="<?= $sup['fld_supplier_name'];?>" <?php if($purchase['fld_supplier_id'] == $sup['fld_id']){ echo 'selected'; };?>><?= $sup['fld_supplier_name'];?></option>
												<?php } } ?>
                                        </select>
                                    </div>
                                    <? if(!empty($role_permissions) && in_array(57,$role_permissions)) { ?>
                                    <div class="col-sm-2">
                                        <a class="btn btn-success addbtn" onclick="purchase_function('supplierdiv')"  title="Add New Supplier" href="javascript:;"><i class="fa fa-user-plus"></i></a>
                                    </div>
                                    <? } ?>
                                </div> 
                            </div>
                            
                            <div class="col-sm-4">
                                <div class="form-group row">
                                    <label for="refinery" class="col-sm-4 col-form-label">Refinery <i class="text-danger">*</i></label>
                                    <div class="col-sm-6">
										<select class="select2 form-control mb-3 custom-select" tabindex="2" style="width: 100%; height:36px;" name="refinery" id="refinery" onchange="updateValue()" required>
                                            <option selected="selected" value="">Select Refinery</option>
											<?php
											if($refinery){
											foreach($refinery as $ref){
											    $mystring = $purchase['fld_shipment'];
											    $findme   = $ref['fld_name'];
											    $pos = strpos($mystring, $findme);
											?>
											<option value="<?= $ref['fld_id'];?>" data_set="<?= $ref['fld_name'];?>" <? if ($pos !== false) { echo "selected"; } ?>><?= $ref['fld_name'];?></option>
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
										<select class="select2 form-control mb-3 custom-select" tabindex="3" style="width: 100%; height:36px;" name="vehicle_no" onchange="updateValue()" id="vehicle_no" required>
                                            <option selected="selected" value="">Select Vehicle</option>
											<?php
											if($transporter){
											foreach($transporter as $trans){
											    $mystring = $purchase['fld_shipment'];
											    $findme   = $trans['fld_vehicle_number'];
											    $pos = strpos($mystring, $findme);
											?>
											<option value="<?=$trans['fld_id'];?>" data_set="<?=$trans['fld_vehicle_number'];?>" <? if ($pos !== false) { echo "selected"; } ?>><?=$trans['fld_vehicle_number'];?></option>
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
									    <input type="text" required="" tabindex="4" class="form-control" name="fld_purchase_date" value="<?= date('d/m/Y',strtotime(@$purchase['fld_purchase_date']))?>" onchange="updateValue()" id="fld_purchase_date" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                               <div class="form-group row">
                                    <label for="adress" class="col-sm-4 col-form-label">Bill ID</label>
                                    <div class="col-sm-8">
                                        
										<input type="text" readonly tabindex="5" class="form-control" name="fld_voucher_no" placeholder="Voucher Number" id="fld_voucher_no" value="<?= @$purchase['fld_voucher_no']?>">
										
                                    </div>
                                </div> 
                            </div>
                            
                            <div class="col-sm-4">
                                <div class="form-group row">
                                    <label for="invoice_no" class="col-sm-4 col-form-label">Invoice No <i class="text-danger"></i>
                                    </label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" placeholder="e.g 156925" id="fld_invoice_no" name="fld_invoice_no" tabindex="6" value="<?= @$purchase['fld_invoice_no']?>">
										
                                    </div>
                                </div>
                            </div>
                        </div>

						<div class="row">
                            <div class="col-sm-8">
                                <div class="form-group row">
                                    <label for="invoice_no" class="col-sm-2 col-form-label">Shipment <i class="text-danger">*</i></label>
                                    <div class="col-sm-10">
                                        <input type="text" tabindex="7" class="form-control" name="fld_shipment" required placeholder="OGDCL/Nashpa/RIK-6158/5-4-2021" id="fld_shipment" value="<?= @$purchase['fld_shipment']?>">
                                        <input type="hidden" name="fld_shipment_old" required value="<?= @$purchase['fld_shipment']?>">
                                    </div>
                                </div>
                            </div>
							<div class="col-sm-4">
                                <div class="form-group row">
                                    <label for="supplier_sss" class="col-sm-4 col-form-label">Location</label>
                                    <div class="col-sm-6">
                                	<?php
										if($locations){
										foreach($locations as $loc){
										if($purchase['fld_location'] == $loc['fld_location']){
									?>
										<input type="hidden" class="form-control" placeholder="e.g 156925" id="fld_location" name="fld_location" value="<?= $loc['fld_id'];?>">
                                        <input type="text" class="form-control" placeholder="e.g 156925" id="fld_location_name" name="fld_location_name" value="<?= $loc['fld_location'];?>" tabindex="8" readonly>
									<?php }}} ?>
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
                                        <th class="text-center">Product SubCategory	</th>
                                        <th class="text-center">Unit Code</th>
                                        <th class="text-center">Qty <i class="text-danger">*</i></th>
                                        <th class="text-center">Unit Price <i class="text-danger">*</i></th>
                                        <th class="text-center">Sub Total</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="addPurchaseItem">
								<?php if($purchase){
									$unit_code='';
									foreach($purchase['products'] as $key => $purch){
										$key =$key +1;
										$subcat = $this->db->query("select * from tbl_subcategory where fld_cid = '{$purch['fld_product_id']}'")->result_array();
									?>
                                    <tr>
                                        <td class="span3 supplier">
											<?php
											if($category){
											foreach($category as $cat){
											if($cat['fld_id'] == $purch['fld_product_id']){
											$unit_code=$cat['fld_unit'];
											?>
												<input type="hidden" class="form-control"  id="product_id_<?= $key?>" name="fld_product_id[]" value="<?= $cat['fld_id'];?>">
                                                <input type="text"  class="form-control"  id="fld_product_id_name" name="fld_product_id_name[]" value="<?= $cat['fld_category'];?>" readonly>
											<?php }}} ?>
                                        </td>
                                        <td class="span3">
                                             <?php 
                                             if($purch['fld_subproduct_id'] != 0){
                                             foreach($subcat as $scat){
                                             if($scat['fld_subcid'] == $purch['fld_subproduct_id']){
                                            ?>
                                                <input type="hidden" class="form-control" id="sub_category_<?= $key?>" name="sub_category[]" value="<?= $purch['fld_subproduct_id'];?>">
                                                <input type="text" class="form-control" id="sub_category_name[]" name="sub_category_name[]" value="<?= $scat['fld_subcategory'];?>" readonly>
											<?php }}} else{ ?>
												<input type="hidden" class="form-control" id="sub_category_<?= $key?>" name="sub_category[]" value=0>
                                                <input type="text" class="form-control" id="sub_category_name[]" name="sub_category_name[]" value="" readonly>
											<? } ?>
                                        </td>
                                        <td class="wt">
                                            <input type="text" id="unit_code_<?= $key?>" class="form-control text-center " placeholder="Unit Code" readonly value="<?= $unit_code;?>">
                                        </td>
                                        <td class="text-right">
                                            <input type="number" step="0.001" required name="fld_quantity[]" id="cartoon_<?= $key?>" required min="0" class="form-control text-right" onkeyup="calculate_store(<?= $key?>);" onchange="calculate_store(<?= $key?>);" placeholder="0.00" value="<?= $purch['fld_quantity']?>" tabindex="9" aria-required="true" onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false" oninput="validity.valid||(value='');">
                                        </td>
                                        <td class="test">
                                            <input type="number" step="0.01" name="fld_unit_price[]" required="" onkeyup="calculate_store(<?= $key?>);" onchange="calculate_store(<?= $key?>);" id="product_rate_<?= $key?>" class="form-control product_rate_<?= $key?> text-right" placeholder="0.00" value="<?= $purch['fld_unit_price']?>" min="0" tabindex="10" aria-required="true" onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false" oninput="validity.valid||(value='');" pattern="[0-9]" onkeypress="return !(event.charCode == 46)">
                                        </td>
                                        <td class="text-right">
                                            <input class="form-control total_price text-right" type="text" name="fld_total_amount[]"  id="total_price_<?= $key?>" value="<?= $purch['fld_total_amount']?>" readonly="readonly">
                                        </td>
                                        <td>
                                            <button class="btn btn-danger text-right red" type="button" value="Delete" onclick="deleteRow(this)" disabled><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
									<?php }}?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-right" colspan="5"><b>Total:</b></td>
                                        <td class="text-right">
                                            <input type="text" id="fld_grand_total_amount" class="text-right form-control" name="fld_grand_total_amount" value="<?= $purchase['fld_grand_total_amount']?>" readonly="readonly">
                                        </td>
                                        <td> <button type="button" id="add_invoice_item" class="btn btn-info" name="add-invoice-item" onclick="addPurchaseOrderField1('addPurchaseItem')" disabled><i class="fa fa-plus"></i></button>
                                        <input type="hidden" name="baseUrl" class="baseUrl" value="<?=base_url();?>"></td>
                                    </tr>
                                   
                                </tfoot>
                            </table>
                        </div>
						<!--<div class="col-sm-12">-->
						<!--		<h4 class="form-section"><i class="icon-eye6"></i>Payment Details</h4>-->
						<!--</div>-->
						<!--<hr>-->
						<div class="row" style="display:none;">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="invoice_no" class="col-sm-4 col-form-label">Payment Status <i class="text-danger"></i>  </label>
                                    <div class="col-sm-6">
										<select  class="form-control" tabindex="12" onchange="paymet_status(this.value)" id="fld_payment_status" name="fld_payment_status">
											<option value="">Select Payment Status</option>
											<option value="1" <?= (@$purchase['fld_payment_status'] == 1)?'selected':'';?>>Paid</option>
											<option value="2" <?= (@$purchase['fld_payment_status'] == 2)?'selected':'';?>>Partial Paid</option>
											<option value="3" <?= (@$purchase['fld_payment_status'] == 3)?'selected':'';?>>UnPaid</option>
											<option value="4" <?= (@$purchase['fld_payment_status'] == 4)?'selected':'';?>>Advance Payment</option>
										</select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                               <div class="form-group row" id="payment_type" <?= (@$purchase['fld_payment_status'] == 3 || @$purchase['fld_payment_status'] == 4)?'style="display:none;"':'';?>>
                                    <label for="invoice_no" class="col-sm-4 col-form-label">Payment Type <i class="text-danger"></i> </label>
                                    <div class="col-sm-6">
										<select tabindex="13" class="form-control" onchange="bank_paymet(this.value)" id="fld_payment_type" name="fld_payment_type" <?//= (@$purchase['fld_payment_status'] == 3 || @$purchase['fld_payment_status'] == 4)?'':'required="required"';?>>
										<option value="">Select Payment Type</option>
										<option value="1" <?= (@$purchase['fld_payment_type'] == 1)?'selected':'';?>>Cash</option>
										<option value="2" <?= (@$purchase['fld_payment_type'] == 2)?'selected':'';?>>Bank</option>
										<option value="3" <?= (@$purchase['fld_payment_type'] == 3)?'selected':'';?>>Cheque</option>
										</select>
                                    </div>
                                </div>
                            </div>
      <!--                  </div>-->
						<!--<div class="row">-->
                            <div class="col-sm-6">
                                <div class="form-group row" id="bank_account" <?= (@$purchase['fld_payment_type'] == 1 || @$purchase['fld_payment_status'] == 4 || @$purchase['fld_payment_status'] == 3)?'style="display:none;"':'';?> >
                                    <label for="invoice_no" class="col-sm-4 col-form-label">Bank Account <i class="text-danger"></i> </label>
                                    <div class="col-sm-6">
										<select tabindex="14" class="form-control" id="fld_bank" name="fld_bank" <?= (@$purchase['fld_payment_type'] != 1 && @$purchase['fld_payment_type'] != 0)?'required':'';?>>
											<option value="">Select Bank Account</option>
											<?php
												if($banks){
													foreach($banks as $bnk){
													?>
												<option value="<?= $bnk['fld_id'];?>" <?= (@$purchase['fld_bank'] == $bnk['fld_id'])?'selected':'';?>><?= $bnk['fld_bank'];?></option>
												<?php } } ?>
										</select>
                                    </div>
                                </div>
                            </div>
          <!--                  <div class="col-sm-6">-->
          <!--                     <div class="form-group row" id="account_no" style="display:none;">-->
          <!--                          <label for="" class="col-sm-4 col-form-label">Enter Account No.<i class="text-danger"></i></label>-->
          <!--                          <div class="col-sm-6">-->
										<!--<input type="text" tabindex="13" class="form-control" name="fld_account_number" placeholder="Cheque Number" id="fld_account_number" value="">-->
          <!--                          </div>-->
          <!--                      </div>-->
          <!--                  </div>-->
                            <div class="col-sm-6">
                               <div class="form-group row" id="cheque_number" <?= (@$purchase['fld_payment_type'] != 3 || @$purchase['fld_payment_status'] == 4)?'style="display:none;"':'';?>>
                                    <label for="invoice_no" class="col-sm-4 col-form-label">Cheque Number<i class="text-danger"></i></label>
                                    <div class="col-sm-6">
										<input type="text" tabindex="15" class="form-control" name="fld_cheque_number" placeholder="Cheque Number" id="fld_cheque_number" value="<?= @$purchase['fld_cheque_number']?>">
                                    </div>
                                </div>
                            </div>
      <!--                  </div>-->
						<!--<div class="row">-->
                            <div class="col-sm-6">
                               <div class="form-group row" id="cheque_date" <?= (@$purchase['fld_payment_type'] != 3 || @$purchase['fld_payment_status'] == 4)?'style="display:none;"':'';?>>
                                    <label for="invoice_no" class="col-sm-4 col-form-label">Cheque Date <i class="text-danger"></i> </label>
                                    <div class="col-sm-6">
										<input type="text" tabindex="16" class="form-control datepicker" name="fld_cheque_date" placeholder="" id="fld_cheque_date" value="<?= date('m/d/Y',strtotime(@$purchase['fld_cheque_date']))?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <p style="color:red;">Note: If location is In Transit then please check Inventory (A/C) else check concerns Ware House/ Plant Inventory A/C. <br>To trace stock , If In Transit is chosen as Location then Please check InTransit Navigation to Navigate it Further else Stock can be traced in concerns Plants/Ware House. <br>To Add Freight details, please choose In-Transit as location.</p>
                                <input type="submit" id="add_purchase" class="btn btn-primary btn-large" name="edit-purchase" tabindex="17" value="Proceed F10" disabled>
                               <!-- <input type="submit" value="Submit And Add Another One" name="add-purchase-another" class="btn btn-large btn-info" id="add_purchase_another">-->
								<input type="hidden" name="purchase_id" value="<?= $purchase['fld_id']?>"/>
                            </div>
                        </div>
                    </form>
                </div>
				
				</div>
				<!----------------------------------------Add Refinery ------------------------------->
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
						<input type="text" class="form-control" placeholder="e.g NASHPA.." name="fld_name" id="fld_name" required>
					</div>
				</div>	
				<div class="col-lg-6">	
					<div class="mt-3">
						<label class="mb-2">Address</label>
						<input type="text" class="form-control" placeholder="e.g Karachi" name="fld_address" id="fld_address">
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
						<button type="button" onclick="purchase_function('vehiclediv')" class="btn btn-gradient-danger">Cancel</button>
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
				
				
				<form method="post" action="<?= base_url('Supplier/add');?>" style="width: 100%;">
				<div class="row">
				
				<div class="col-lg-6">
					<div class="mt-3">
						<label class="mb-2">Supplier Code  <i class="text-danger">*</i></label>
						<input type="text" class="form-control" name="fld_supplier_code" readonly  value="<?= $maxid;?>" required tabindex="1">            
					</div> 

					<div class="mt-3">
						<label class="mb-2">Supplier Name  <i class="text-danger">*</i></label>
						<input type="text" class="form-control"  name="fld_supplier_name" id="fld_supplier_name" placeholder="e.g OGDCL" required>
					</div>                                    
					
					<div class="mt-3">
						<label class="mb-2">Mobile #</label>
						<input type="text" class="form-control"  name="fld_landline_num" data-inputmask="'mask': '0399-99999999'"  type = "text" maxlength = "12"   placeholder="03XX-XXXXXXX" id="fld_landline_num">
					</div>
					
					<div class="mt-3">
						<label class="mb-2">Opening Balance (Pkr)</label>
						
						<input type="text" class="form-control"  name="fld_opening_bal" id="fld_opening_bal" placeholder="e.g 3500.00">
					</div>
					<div class="mt-3">
						<label class="mb-2">Email</label>
						
						<input type="text" class="form-control" placeholder="test@gmail.com" name="fld_email" id="fld_email">
					</div>
				    <div class="mt-3">
						<label class="mb-2">City</label>
						
						<input type="text" class="form-control" placeholder="e.g Peshawer" name="fld_city" id="fld_city">
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
						<label class="mb-2">Supplier Name  <i class="text-danger">*</i></label>
						
						<input type="text"  name="fld_company_name"  placeholder="e.g OGDCL" class="form-control" id="fld_company_name" required tabindex="2">
					</div>
					<div class="mt-3">
						<label class="mb-2">Mobile #  <i class="text-danger">*</i></label>
						
						<input type="text" class="form-control" data-inputmask="'mask': '0399-99999999'"  type = "text" maxlength = "12" name="fld_mobile_num" id="fld_mobile_num" required>
					</div>
					
					<div class="mt-3">
						<label class="mb-2">Supplier Type  <i class="text-danger">*</i></label>
						<select class="select2 form-control mb-3 custom-select" name="fld_supplier_type" id="fld_supplier_type" required>
							<option value="">Select type</option>
							<option value="1">Local</option>
							<option value="2">Importer</option>
						</select>
					</div>
					<div class="mt-3">
						<label class="mb-2">CNIC</label>
						
						<input type="text" data-inputmask="'mask': '99999-9999999-9'" class="form-control" placeholder="XXXXX-XXXXXXX-X"  class="form-control"  name="fld_cnic" id="fld_cnic">
					</div>
					<div class="mt-3">
						<label class="mb-2">NTN</label>
						
						<input type="text" class="form-control" placeholder="e.g 0622438" name="fld_ntn" id="fld_ntn">
					</div>
					<div class="mt-3">
						<label class="mb-2">City Area</label>
						
						<input type="text" class="form-control" placeholder="e.g Karachi" name="fld_city_area" id="fld_city_area">
					</div> 
				</div>
				<div class="col-lg-6">
					<div class="mt-3">
						<label class="mb-2"></label>
						<button type="submit" class="btn btn-gradient-primary">Submit</button>
						<button type="button" onclick="purchase_function('purchasediv')" class="btn btn-gradient-danger">Cancel</button>
					</div>
				</div>
				
				</div>
				</form>
				
				</div>
		<!----------------------------------------End Supplier ------------------------------->
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

                