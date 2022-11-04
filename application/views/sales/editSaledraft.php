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
.select2-container--default.select2-container--disabled .select2-selection--single {
    background-color: #212744;
    cursor: default;
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
.addbtn{
   position: relative;
   right: 20px; 
}
@media only screen and (max-width: 600px) {
.addbtn{
	right:0;
	top:5px;
}
#add-sale, #update_sale_draft{
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
<div class="container-fluid">
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right" style="margin-bottom:15px;">
    			<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Sales" type="button" class="btn btn-outline-primary"><i class="fa fa-shopping-cart"></i>&nbsp;New Sale</a>
                  <a href="<?= base_url();?>Sales/manage_sales" type="button" class="btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;View Sales</a>
                  <a href="<?= base_url();?>Sales/manage_drafts" type="button" class="btn btn-primary btn-large"><i class="fa fa-vcard"></i>&nbsp;Drafts</a>
                  <a href="<?= base_url();?>Sales/salesReport" type="button" class="btn btn-outline-primary"><i class="fa fa-bar-chart"></i>&nbsp;Sales Report</a>
                </div>
			</div>
			<!--<h4 class="page-title">Edit Sale Draft</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--<li class="breadcrumb-item"><a href="javascript:void(0);">Sales</a></li>-->
			<!--<li class="breadcrumb-item active">Edit Sale Draft</li>-->
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
                    <form id="updateDraftSale" action="<?= base_url('Sales/add');?>" class="form-vertical" method="post" >
						<div class="col-sm-12">
							<h4 class="form-section"><i class="icon-eye6"></i>Invoice Details  <div class="ml3" style="float:right;color:#1ad1bc;display:none; font-size:11px;">Saved in Draft Automatically.</div></h4>
						</div>
						<hr>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="supplier_sss" class="col-form-label">Customer <i class="text-danger">*</i></label>
                                    <!--<div class="col-sm-6">-->
                                        <select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="fld_customer_id" tabindex="1" id="fld_customer_id" required>
                                                <option selected="selected" value="">Select Customer</option>
											    <?php
												    if($customer){
													foreach($customer as $cus){
												?>
												<option value="<?= $cus['fld_id'];?>" <?= ($sale['fld_customer_id'] == $cus['fld_id']) ? 'selected':'';?>><?= $cus['fld_customer_name'];?><?php if($cus['fld_company_name']!=''){ echo ' - '.$cus['fld_company_name'];}?></option>
												<?php }}?>
                                        </select>
                                    <!--</div>-->
            
                                </div> 
                            </div>

                             <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="date" class=" col-form-label">Invoice Date <i class="text-danger">*</i>
                                    </label>
                                    <!--<div class="col-sm-8">-->
									<input type="text" required="" tabindex="2" class="form-control datepicker" name="fld_sale_date" value="<?= date('d/m/Y',strtotime(@$sale['fld_sale_date']))?>" id="fld_sale_date" >
                                    <!--</div>-->
                                </div>
                            </div>
                        <!--</div>-->

                        <!--<div class="row">-->
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="invoice_no" class="col-form-label">Invoice No <i class="text-danger"></i>
                                    </label>
                                    <!--<div class="col-sm-4">-->
                                        <input type="text" tabindex="3" class="form-control"  placeholder="Invoice No" value="<?= @$sale['fld_invoice_no']?>"  id="fld_invoice_no" name="fld_invoice_no">
										
                                    <!--</div>-->
                                </div>
                            </div>

                            <div class="col-sm-4">
                               <div class="form-group">
                                    <label for="adress" class=" col-form-label">Invoice ID</label>
                                    <!--<div class="col-sm-8">-->
										<input type="text" readonly tabindex="4" class="form-control" name="fld_voucher_no" placeholder="Voucher Number" id="fld_voucher_no" value="<?= @$sale['fld_voucher_no']?>">
                                    <!--</div>-->
                                </div> 
                            </div>
      <!--                  </div>-->
						<!--<div class="row">-->
						    <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="invoice_no" class=" col-form-label">Plant <i class="text-danger">*</i>
                                    </label>
                                    <!--<div class="col-sm-6">-->
                                        <select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="fld_location" tabindex="5" id="fld_location">
                                                <option value="">Select Plant</option>
												<?php
											        if($locations){
													foreach($locations as $loc){
												?>
												<option value="<?= $loc['fld_id'];?>" <?= ($sale['fld_location_id'] == $loc['fld_id']) ? 'selected':'';?>><?= $loc['fld_location'];?></option>
												<?php }}?>
                                        </select>
                                    </div>
                                </div> 
                            <!--</div>-->
                            <div class="col-sm-4">
                                <div class="form-group ">
                                    <label for="invoice_no" class="col-form-label">Product <i class="text-danger">*</i></label>
                                    <!--<div class="col-sm-6">-->
                                        <select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="fld_category" onchange="getDetailView();" tabindex="6" id="fld_category">
											<?php
											    if($category){
												foreach($category as $cat){
											?>
												<option value="<?= $cat['fld_id'];?>" <? if(!empty($sale['fld_product_id']) && $sale['fld_product_id'] == $cat['fld_id']) { echo 'selected'; } ?>><?= $cat['fld_category'];?></option>
											<?php }} ?>
                                        </select>
                                    <!--</div>-->
                                </div> 
                            </div>
                        <!--</div>-->
                        <!--<div class="row">-->
						    
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="invoice_no" class=" col-form-label">Vehicle No <i class="text-danger">*</i></label>
                                    <!--<div class="col-sm-6">-->
                                        <input type="text" tabindex="7" class="form-control" name="fld_vehicle_no" value="<?= @$sale['fld_vehicle_no']?>" required placeholder="ABC-123" id="fld_vehicle_no">
                                    <!--</div>-->
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
                                            <th class="text-center">#</th> 
                                            <th class="text-center">Item</th>
                                            <th class="text-center">Shipment</th>
                                            <th class="text-center">Qty <i class="text-danger">*</i></th>
                                            <th class="text-center"> Total Weight</th>
                                            <th class="text-center">Unit Price(PKR) <i class="text-danger">*</i></th>
                                            <th class="text-center">Sub Total(PKR)</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                </thead>
    <tbody id="addPurchaseItem">
        <?php if($sale['products']){
        	$unit_code='';
        	$i=0;
        	$fld_total_amount=0;
        // 	$subcategory = $this->db->query("select * from tbl_subcategory where fld_cid = '{$sale['fld_product_id']}'")->result_array();
        	foreach($sale['products'] as $key => $salesd){
        		$i++;
        		$subcategory = $this->db->query("select * from tbl_subcategory where fld_cid = '{$salesd['fld_product_id']}'")->result_array();
        ?>
	<tr>
		<td class="text-center">
		    <input type="hidden" name="sdid[]" value="<?php echo $salesd['fld_id']; ?>" />
		    <input type="hidden" name="stock_location[]" value="<?php echo $salesd['fld_stock_location_id']; ?>" />
		   <?php echo $i;?>
		</td>

	   <td class="text-center">
		<select class="select2 form-control mb-3 custom-select fld_product_id" name="fld_subcat_id[]" onchange="product_category(<?php echo $i; ?>);" tabindex="8" id="product_subcat_<?php echo $i; ?>">
            <option value="">Select Product</option>
			<?php
    			if($subcategory){
    			foreach($subcategory as $cat){
			?>
			<option value="<?= $cat['fld_subcid'];?>" data-weight="<?= preg_replace('/[^0-9.]/', '', $cat['fld_subcategory']);?>" <?php if($salesd['fld_subproduct_id'] == $cat['fld_subcid']){echo 'selected';} ?>><?= $cat['fld_subcategory'];?></option>
			<?php } } ?>
		</select>
		</td>
	<td class="text-right">
	    <div class="input-group">
			<input type="text" class="form-control fld_shipment" name="fld_shipment[]" value="<?php echo $salesd['fld_shipment']; ?>" id="fld_shipment_<?php echo $i; ?>" readonly required>
			<span class="input-group-prepend">
				<button type="button" id="location_shipments_<?php echo $i; ?>" onclick="getShipments(<?php echo $i; ?>)" tabindex="9" class="btn btn-gradient-primary"><i class="fas fa-search"></i></button>
			</span>
		</div>
	</td>	
	<td class="text-right">
        <input type="text" required name="fld_quantity[]" id="cartoon_<?php echo $i; ?>" required min="0" class="form-control text-right" onkeyup="calculate_store(<?php echo $i; ?>);" onchange="calculate_store(<?php echo $i; ?>);" placeholder="0.00" value="<?php echo $salesd['fld_quantity']; ?>" tabindex="10" aria-required="true">
    </td>
    <td><input type="text" name="fld_weight[]" value="<?php echo $salesd['fld_weight']; ?>" id="fld_weight_<?php echo $i; ?>" class="form-control text-right" onkeyup="calculate_store(<?php echo $i; ?>);" onchange="calculate_store(<?php echo $i; ?>);" placeholder="0" value="0" aria-required="true" readonly>
        <input type="hidden" name="fld_row_discount[]" id="fld_row_discount_<?php echo $i; ?>" class="form-control text-right"  readonly></td>
    <td class="test">
        <input type="text" name="fld_unit_price[]" required onkeyup="calculate_store(<?php echo $i; ?>);" onchange="calculate_store(<?php echo $i; ?>);" id="product_rate_<?php echo $i; ?>" class="form-control product_rate_<?php echo $i; ?> text-right" placeholder="0.00" value="<?php echo $salesd['fld_unit_price']; ?>" min="0"  aria-required="true" readonly="readonly">
    </td>
    <td class="text-right">
        <input class="form-control total_price text-right" type="text" name="fld_total_amount[]" id="total_price_<?php echo $i; ?>" value="<?php echo $salesd['fld_total_amount']; ?>"  readonly="readonly">
    </td>
    <td>
        <button class="btn btn-danger text-right red" type="button" value="Delete" onclick="deleteRow(this)" ><i class="fas fa-times"></i></button>
    </td>
	</tr>
	<?php
	}
	}?>
                </tbody>
                <tfoot id="t_total" <?php if(!$sale['products']){ echo 'style="display:none"';} ?>>
                    <tr>
                        <td class="text-right" colspan="6"><b>Discount(PKR):</b></td>
                        <td class="text-right">
                            <input type="text" id="fld_discount" class="text-right form-control" onkeyup="calculateSum();" tabindex="11"name="fld_discount" value="<?= @$sale['fld_discount']?>">
                        </td>
                    </tr>
                    <tr>
                        <td class="text-right" colspan="6"><b>Total Discount(PKR):</b></td>
                        <td class="text-right">
                            <input type="text" id="fld_total_discount" class="text-right form-control" name="fld_total_discount" value="<?= @$sale['fld_total_discount']?>" readonly="readonly">
                        </td>
                    </tr>
                    
                    <tr>
                        <td class="text-right" colspan="6"><b>Total(PKR):</b></td>
                        <td class="text-right">
                            <input type="text" id="fld_grand_total_amount" class="text-right form-control" name="fld_grand_total_amount" value="<?= @$sale['fld_grand_total_amount']?>" readonly="readonly">
                        </td>
                        <td> 
                        <button type="button" id="add_invoice_item" class="btn btn-info" name="add-invoice-item" onclick="addPurchaseOrderField1('addPurchaseItem')" ><i class="fa fa-plus"></i></button>
                        </td>
                    </tr>
                    <?php /*?><tr>
                        <td class="text-right" colspan="4"><b>Discount:</b></td>
                        <td class="text-right">
                            <input type="text" id="discount" class="text-right form-control discount" onkeyup="calculate_store(1)" name="discount" placeholder="0.00" value="">
                        </td>
                        <td></td>
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
                        <td></td>
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
		<!--<h4 class="form-section"><i class="icon-eye6"></i>Payment Details</h4>-->
		<!--</div>-->
		<!--<hr>-->
		<div class="col-sm-12">
				<h4 class="form-section"><i class="icon-eye6"></i>Payment Details</h4>
		</div>
		<hr>
		<div class="row">
            <div class="col-sm-6">
               <div class="form-group row" id="payment_type">
                    <label for="invoice_no" class="col-sm-4 col-form-label">Payment Type <i class="text-danger"></i></label>
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
                    <label for="invoice_no" class="col-sm-4 col-form-label">Amount Paid <i class="text-danger"></i></label>
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
							<?php }}?>
						</select>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
               <div class="form-group row" id="cheque_number" style="display:none;">
                    <label for="invoice_no" class="col-sm-4 col-form-label">Cheque Number <i class="text-danger"></i></label>
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
            <div class="col-sm-8">
                <!--<input type="submit" id="add_sale" class="btn btn-successs" name="edit-sale" value="Submit">-->
                <!--<input type="submit" value="Submit And Add Another One" name="edit-sale-another" class="btn btn-success1" id="add_sale_another">-->
                <input type="Button" tabindex="17" id="update_sale_draft" class="col-sm-2 btn btn-warning btn-large" name="edit-purchase" value="Update Draft">
                <input type="submit" tabindex="18" id="add-sale" class="col-sm-2 btn btn-successs btn-large" name="add-sale" value="Create Sale">
                <input type="hidden" name="sale_id" id="sale_id" value="<?= $sale['fld_id'];?>"/>
            </div>
        </div>
        <br>
    </form>
</div>
</div>
	<!----------------------------------------Add Supplier ------------------------------->
	<div class="row" id="customerDiv" style="display:none;">
	<div class="col-lg-12">
		<h4 class="form-section"><i class="icon-eye6"></i>Add Customer</h4>
	</div>
	<div class="col-lg-12" style="padding:0px;">
	<hr>
	</div>
	<form method="post" id="addCustomer" >
	<div class="row">
	<div class="col-lg-6">
		<div class="mt-3">
			<label class="mb-2">Customer Code *</label>
			<input type="text" class="form-control" name="fld_customer_code" readonly  value="<?= $maxid;?>" required tabindex="1">            
		</div> 
		<div class="mt-3">
			<label class="mb-2">Company Name *</label>
			<input type="text"  name="fld_company_name" class="form-control" id="fld_company_name" required tabindex="3">
		</div>
		<div class="mt-3">
			<label class="mb-2">Landline #</label>
			<input type="text" class="form-control" name="fld_landline_num" id="fld_landline_num" tabindex="5">
		</div>
		<div class="mt-3">
			<label class="mb-2">Opening Balance</label>
			<input type="text" class="form-control" name="fld_opening_bal" id="fld_opening_bal" tabindex="7">
		</div>
		<div class="mt-3">
			<label class="mb-2">Email</label>
			<input type="text" class="form-control" name="fld_email" id="fld_email" tabindex="9">
		</div>
	    <div class="mt-3">
			<label class="mb-2">City</label>
			<input type="text" class="form-control" name="fld_city" id="fld_city" tabindex="11">
		</div>
		<div class="mt-3">
			<label class="mb-2">Country</label>
			<input type="text" class="form-control" name="fld_country" id="fld_country" tabindex="13">
		</div>
	</div> 
	<div class="col-lg-6">
		<div class="mt-3">
			<label class="mb-2">Customer Name *</label>
			<input type="text" class="form-control" name="fld_customer_name" id="fld_customer_name" required tabindex="2">
		</div>
		<div class="mt-3">
			<label class="mb-2">Mobile # *</label>
			<input type="text" class="form-control" name="fld_mobile_num" id="fld_mobile_num" required tabindex="4">
		</div>
		<div class="mt-3">
			<label class="mb-2">Customer Type *</label>
			<select class="form-control" name="fld_customer_type" id="fld_customer_type" required>
				<option value="">Select type</option>
				<option value="1">Local</option>
				<option value="2">Importer</option>
			</select>
		</div>
		<div class="mt-3">
			<label class="mb-2">CNIC</label>
			<input type="text" class="form-control" name="fld_cnic" id="fld_cnic" tabindex="8">
		</div>
		<div class="mt-3">
			<label class="mb-2">NTN</label>
			<input type="text" class="form-control" name="fld_ntn" id="fld_ntn" tabindex="10">
		</div>
		<div class="mt-3">
			<label class="mb-2">City Area</label>
			<input type="text" class="form-control" name="fld_city_area" id="fld_city_area" tabindex="12">
		</div> 
	</div>
	<div class="col-lg-6">
		<div class="mt-3">
			<label class="mb-2"></label>
			<button type="submit" name="submit" class="btn btn-gradient-primary">Submit</button>
			<button type="button" onclick="sale_function('saleDiv')" class="btn btn-gradient-danger">Cancel</button>
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
		<?php }} ?>
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
		</div><!-- /.modal-content-->
	</div><!-- /.modal-dialog -->
</div><!--/.modal-->
<script>
     var count = <?php echo $i+1;?>;
</script>
<script>
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