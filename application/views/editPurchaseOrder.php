
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
</style>
<? $role_permissions  = explode(",",$this->session->userdata('permissions')); ?>
<div class="container-fluid">
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right" style="margin-bottom:15px;">
			    <div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Purchase/create_order" type="button" class="btn btn-outline-primary"><i class="fa fa-shopping-cart"></i>&nbsp;New Order</a>
                  <a href="<?= base_url();?>Purchase/manage_orders" type="button" class="btn btn-primary btn-large"><i class="fa fa-eye"></i>&nbsp;View Orders</a>
                  <a href="<?= base_url();?>Purchase/purchReport" type="button" class="btn btn-outline-primary"><i class="fa fa-bar-chart"></i>&nbsp;Purchase Report</a>
                  <a href="<?= base_url();?>Purchase/manage_trash" type="button" class="btn btn-outline-primary"><i class="fa fa-trash"></i>&nbsp;Trash</a>
                </div>
			</div>
			<!--<h4 class="page-title">Orders</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Order</a></li>-->
			<!--	<li class="breadcrumb-item active">Edit Purchase Draft</li>-->
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
				}?>
				</div>
				<div class="panel-body">
                    <form id="updateDraftPurchase" action="<?= base_url('Purchase/createPurchaseFromOrder');?>" class="form-vertical"  method="post" >
						<div class="col-sm-12">
							<h4 class="form-section"><i class="icon-eye6"></i>Purchase Details</h4>
						</div>
						<hr>
                        <div class="row">
						
                            <div class="col-sm-4">
                                <div class="form-group row">
                                    <label for="supplier_sss" class="col-sm-4 col-form-label">Supplier <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-6">
                                        <select tabindex="1" class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="fld_supplier_id" id="fld_supplier_id" required>
											<?php
											if($supplier){
												foreach($supplier as $sup){
												    if($purchase['fld_supplier_id'] == $sup['fld_id']){
												?>
											<option value="<?= $sup['fld_id'];?>" data_set="<?= $sup['fld_company_name'];?>" ><?= $sup['fld_company_name'];?></option>
											<?php }}} ?>
                                        </select>
                                    </div>
                                    <? if(!empty($role_permissions) && in_array(57,$role_permissions)) { ?>
                                    <div class="col-sm-2">
                                        <a class="btn btn-success" onclick="purchase_function('supplierdiv')"  title="Add New Supplier" href="javascript:;"><i class="fa fa-user-plus"></i></a>
                                    </div>
                                    <? } ?>
                                </div> 
                            </div>

                             <div class="col-sm-4">
                                <div class="form-group row">
                                    <label for="date" class="col-sm-4 col-form-label">Date <i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
									<input type="text" required="" tabindex="2" class="form-control datepicker" name="fld_purchase_date" value="<?= date('d/m/Y',strtotime(@$purchase['fld_order_date']))?>" id="fld_purchase_date" onchange="updateValue()" >
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-sm-4">
                                <div class="form-group row">
                                    <label for="refinery" class="col-sm-4 col-form-label">Refinery <i class="text-danger">*</i></label>
                                    <div class="col-sm-6">
										<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="refinery" id="refinery"  onchange="updateValue()" required tabindex="3">
                                               
												<?php
												if($refinery){
												foreach($refinery as $ref){
												    if($purchase['fld_refinery_id'] == $ref['fld_id']){
												?>
												<option value="<?= $ref['fld_id'];?>" data_set="<?= $ref['fld_name'];?>"><?= $ref['fld_name'];?></option>
												<?php }}}?>
                                        </select>
                                    </div>
                                    <? if(!empty($role_permissions) && in_array(122,$role_permissions)) { ?>
                                    <div class="col-sm-2">
                                        <a class="btn btn-success addbtn" onclick="refinery_function('refinerydiv')"  title="Add New Refinery" href="javascript:;"><i class="fa fa-plus"></i></a>
                                    </div>
                                    <? } ?>
                                </div>
                            </div>
                            
                        </div>

                        
					
                        
                        
                        <div class="row">
                            <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="adress" class="col-sm-4 col-form-label">Voucher Number</label>
                                    <div class="col-sm-8">
										<input type="text" readonly tabindex="4" class="form-control" name="fld_voucher_no" placeholder="Voucher Number" id="fld_voucher_no" value="<?php echo $maxid;?>">
                                    </div>
                                </div> 
                            </div>
                            <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="adress" class="col-sm-4 col-form-label">Vehicle Number <i class="text-danger">*</i></label>
                                    <div class="col-sm-6">
										<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="vehicle_no" onchange="updateValue()" id="vehicle_no" tabindex="5" required>
                                                <option selected="selected" value="">Select Vehicle</option>
												<?php
												if($transporter){
												foreach($transporter as $trans){
												?>
												<option value="<?=$trans['fld_id'];?>" data_set="<?=$trans['fld_vehicle_number'];?>"><?=$trans['fld_vehicle_number'];?></option>
												<?php }}?>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <a class="btn btn-success" onclick="vehicle_function('vehiclediv')"  title="Add New Vehicle" href="javascript:;"><i class="fa fa-plus"></i></a>
                                    </div>
                                </div> 
                            </div>
                            

                            
                            
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="invoice_no" class="col-sm-4 col-form-label">Invoice No <i class="text-danger"></i>
                                    </label>
                                    <div class="col-sm-6">
                                        <input type="text" tabindex="6" class="form-control" placeholder="e.g 156925"  id="fld_invoice_no" value="<?= @$purchase['fld_invoice_no']?>" name="fld_invoice_no" >
										
                                    </div>
                                </div>
                            </div>
                        </div>
						<div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="invoice_no" class="col-sm-4 col-form-label">Shipment <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-6">
                                        <input type="text" tabindex="7" class="form-control" name="fld_shipment" required placeholder="OGDCL/Nashpa/RIK-6158/5-4-2021" id="fld_shipment" >
                                    </div>
                                </div>
                            </div>
							<div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="supplier_sss" class="col-sm-4 col-form-label">Location                                        
                                    </label>
                                    <div class="col-sm-6">
                                        <select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="fld_location" tabindex="8" id="fld_location" >
                                                <option value="">Select Location</option>
												<?php
												if($locations){
												foreach($locations as $loc){
												?>
												<option value="<?= $loc['fld_id'];?>" <?= ($loc['fld_location'] == "In Transit" || $loc['fld_location'] == "in transit") ? 'selected':'';?>><?= $loc['fld_location'];?></option>
												<?php }}?>
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
                                            <th class="text-center">Sub Total(PKR)</th>
                                        </tr>
                                </thead>
                                <tbody id="addPurchaseItem">
								<?php if($purchase){
								    
									$unit_code='';
									foreach($purchase['products'] as $key => $purch){
										$key =$key +1;
									?>
                                    <tr>
                                        <td class="span3 supplier">
                                            <input type="hidden" name="fld_detail_id[]" value="<?php echo $purch['fld_id']; ?>" />
                                          <?php
												
												if($category){
													
													foreach($category as $cat){
														if($cat['fld_id'] == $purch['fld_product_id']){
														    $unit_code=$cat['fld_unit'];
															echo $cat['fld_category']; 
															?>
															<input type="hidden" name="fld_product_id[]" id="product_id_<?php echo $cat['fld_id']; ?>" value="<?php echo $cat['fld_id']; ?>" />
															<?php 
														}
													}
												}
													?>
													
											
                                        </td>
                                        <td class="span3 supplier">
                                            <input type="hidden" name="fld_subproduct_id[]" value="<?php echo $purch['fld_subproduct_id']; ?>" />
                                             <?php
													
												if($subcategory){
													//print_r($subcategory);
													foreach($subcategory as $scat){
														if($scat['fld_subcid'] == $purch['fld_subproduct_id']){
															echo $scat['fld_subcategory'];
															
														}
													}
												}
													?>
												
										</td>

                                       <td class="wt">
                                                <input type="text" id="unit_code_<?= $key?>" class="form-control text-center " placeholder="Unit Code" readonly value="<?= $unit_code;?>">
                                            </td>
                                        
                                            <td class="text-right">
                                                <input type="hidden" name="fld_old_quantity[]"  id="old_cartoon_<?= $key?>" value="<?= $purch['fld_quantity']?>" /> 
                                                <input type="number" required name="fld_quantity[]" id="cartoon_<?= $key?>" required min="0" class="form-control text-right" onkeyup="calculate_store_with_qty(<?= $key?>);" placeholder="0.00" value="<?= $purch['fld_quantity']?>" tabindex="8" aria-required="true"  onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false" oninput="validity.valid||(value='');" >
                                            </td>
                                            <td class="test">
                                                <input type="number" name="fld_unit_price[]" required="" onkeyup="calculate_store(<?= $key?>);" onchange="calculate_store(<?= $key?>);" id="product_rate_<?= $key?>" class="form-control product_rate_<?= $key?> text-right" placeholder="0.00" value="<?= $purch['fld_unit_price']?>" min="0" tabindex="9" aria-required="true"  onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false" oninput="validity.valid||(value='');" pattern="[0-9]" onkeypress="return !(event.charCode == 46)">
                                            </td>
                                          
                                            <td class="text-right">
                                                <input class="form-control total_price text-right" type="text" name="fld_total_amount[]"  id="total_price_<?= $key?>" value="<?= $purch['fld_total_amount']?>" readonly="readonly">
                                            </td>
                                    </tr>
									<?php }}?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        
                                        <td class="text-right" colspan="5"><b>Total(PKR):</b></td>
                                        <td class="text-right">
                                            <input type="text" id="fld_grand_total_amount" class="text-right form-control" name="fld_grand_total_amount" value="<?= $purchase['fld_grand_total_amount']?>" readonly="readonly">
                                        </td>
                                       
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
					
						
						
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <input type="submit" class="btn btn-successs btn-large" id="add_purchase" name="add-purchase" value="Proceed F10" tabindex="10">
                               <!-- <input type="submit" value="Submit And Add Another One" name="add-purchase-another" class="btn btn-large btn-info" id="add_purchase_another">-->
								<input type="hidden" name="purchase_id" value="<?= $purchase['fld_id']?>"/>
                            </div>
                        </div>
                    </form>                    
                    </div>
				</div>
	<!----------------------------------------Add Supplier ------------------------------->
				<div class="row" id="supplierdiv" style="display:none;">
				<div class="col-lg-12">
					<h4 class="form-section"><i class="icon-eye6"></i>Add Supplier</h4>
				</div>
				<div class="col-lg-12" style="padding:0px;">
					<hr>
				</div>
				
				
				<form method="post" action="<?= base_url('Supplier/add');?>">
				<div class="row">
				
				<div class="col-lg-6">
					<div class="mt-3">
						<label class="mb-2">Supplier Code *</label>
						
						<input type="text" class="form-control" name="fld_supplier_code" readonly  value="<?= $maxid;?>" required tabindex="1">            
					</div> 

					<div class="mt-3">
						<label class="mb-2">Supplier Name *</label>
						
						<input type="text" class="form-control"  name="fld_supplier_name" id="fld_supplier_name" required>
					</div>                                    
					
					<div class="mt-3">
						<label class="mb-2">Landline #</label>
						
						<input type="text" class="form-control"  name="fld_landline_num" id="fld_landline_num">
					</div>
					
					<div class="mt-3">
						<label class="mb-2">Opening Balance</label>
						
						<input type="text" class="form-control"  name="fld_opening_bal" id="fld_opening_bal">
					</div>
					<div class="mt-3">
						<label class="mb-2">Email</label>
						
						<input type="text" class="form-control"  name="fld_email" id="fld_email">
					</div>
				    <div class="mt-3">
						<label class="mb-2">City</label>
						
						<input type="text" class="form-control"  name="fld_city" id="fld_city">
					</div>
					<div class="mt-3">
						<label class="mb-2">Country</label>
						
						<input type="text" class="form-control" name="fld_country" id="fld_country">
					</div>
					                            
				</div> 
				<div class="col-lg-6">
					<div class="mt-3">
						<label class="mb-2">Company Name *</label>
						
						<input type="text"  name="fld_company_name" class="form-control" id="fld_company_name" required tabindex="2">
					</div>
					<div class="mt-3">
						<label class="mb-2">Mobile # *</label>
						
						<input type="text" class="form-control"  name="fld_mobile_num" id="fld_mobile_num" required>
					</div>
					
					<div class="mt-3">
						<label class="mb-2">Supplier Type *</label>
						<select class="form-control" name="fld_supplier_type" id="fld_supplier_type" required>
							<option value="">Select type</option>
							<option value="1">Local</option>
							<option value="2">Importer</option>
						</select>
					</div>
					<div class="mt-3">
						<label class="mb-2">CNIC</label>
						
						<input type="text" class="form-control"  name="fld_cnic" id="fld_cnic">
					</div>
					<div class="mt-3">
						<label class="mb-2">NTN</label>
						
						<input type="text" class="form-control"  name="fld_ntn" id="fld_ntn">
					</div>
					<div class="mt-3">
						<label class="mb-2">City Area</label>
						
						<input type="text" class="form-control"  name="fld_city_area" id="fld_city_area">
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
						<input type="text" class="form-control" name="fld_vehicle_number" placeholder="e.g V-001" id="fld_vehicle_number" tabindex="1" required>
					</div>
					<div class="mt-3">
						<label class="mb-2">Name <i class="text-danger">*</i></label>
						<input type="text" class="form-control" name="fld_name" placeholder="e.g Abdul Kalam" id="fld_name" tabindex="2" required>
					</div> 
					<div class="mt-3">
						<label class="mb-2">Contact Person <i class="text-danger">*</i></label>
						<input type="text" class="form-control" name="fld_contact_person" placeholder="e.g Ali Khan" tabindex="3" id="fld_contact_person" required>
					</div>
				</div> 
				<div class="col-lg-6">
                    
					<div class="mt-3">
						<label class="mb-2">Mobile No.</label>
						<input type="text" class="form-control" name="fld_contact_no" data-inputmask="'mask': '0399-99999999'"  type = "text" maxlength = "12"   placeholder="03XX-XXXXXXX" tabindex="4" id="fld_contact_no" >
					</div>
					<div class="mt-3">
						<label class="mb-2">Area Cover</label>
						<input type="text" class="form-control" placeholder="e.g KPK" name="fld_area" tabindex="5" id="fld_area" >
					</div>
					<div class="mt-3">
						<label class="mb-2">GL Account(Pkr)</label>
						<input type="text" class="form-control" name="fld_gl_account" placeholder="e.g 55000" tabindex="6" id="fld_gl_account" >
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

                