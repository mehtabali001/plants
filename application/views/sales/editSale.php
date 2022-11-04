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
.daterangepicker td.available:hover, .daterangepicker th.available:hover{
    background-color: #8a8787;
}
.table-responsive {
    overflow:hidden;
}
.addbtn{
   position: relative;
   right: 20px; 
}
@media only screen and (max-width: 600px){
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
/*.btn-group, .btn-group-vertical{*/
/*    display:flow-root;*/
/*}*/
.form-control{
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
			<!--<h4 class="page-title">Edit Sale Invoice</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--<li class="breadcrumb-item"><a href="javascript:void(0);">Sales</a></li>-->
			<!--<li class="breadcrumb-item active">Edit Sale Invoice</li>-->
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
				<?php echo $error_message; ?>                    
			</div>
		<?php
			$this->session->unset_userdata('error_message');
		}?>
		<?php $success_message = $this->session->userdata('success_message');
		      if (isset($success_message)) {
		 ?>
			<div class="alert alert-success">
				<?php echo $success_message; ?>                    
			</div>
		<?php
			$this->session->unset_userdata('success_message');
		}
		?>
		</div>
<div class="panel-body">
<form id="addPurchase" action="<?= base_url('Sales/update');?>" class="form-vertical" method="post">
<div class="col-sm-12">
<h4 class="form-section"><i class="icon-eye6"></i>Invoice Details</h4>
</div>
<hr>
<div class="row">
<div class="col-sm-4">
    <div class="form-group">
        <label for="supplier_sss" class=" col-form-label">Customer <i class="text-danger">*</i></label>
        <div class="row">
            <div class="col-sm-10">
                <select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="fld_customer_id" tabindex="1" id="fld_customer_id" required>
                    <option selected="selected" value="">Select Customer</option>
				    <?php
					    if($customer){
						foreach($customer as $cus){
					?>
					<option value="<?= $cus['fld_id'];?>" <?= ($sale['fld_customer_id'] == $cus['fld_id']) ? 'selected':'';?> ><?= $cus['fld_customer_name'];?><?php if($cus['fld_company_name']!=''){ echo ' - '.$cus['fld_company_name'];}?></option>
					<?php }} ?>
                </select>
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
        <!--<div class="col-sm-8">-->
		<input type="text" required="" tabindex="2" class="form-control " name="fld_sale_date" value="<?= date('d/m/Y',strtotime(@$sale['fld_sale_date']))?>" id="fld_sale_date" readonly>
        <!--</div>-->
    </div>
</div>
<!--</div>-->

<!--<div class="row">-->
<div class="col-sm-4">
    <div class="form-group">
        <label for="invoice_no" class=" col-form-label">Invoice No <i class="text-danger"></i></label>
        <!--<div class="col-sm-6">-->
        <input type="text" tabindex="3" class="form-control" placeholder="Invoice No" value="<?= @$sale['fld_invoice_no']?>" id="fld_invoice_no" name="fld_invoice_no">
        <!--</div>-->
    </div>
</div>

<div class="col-sm-4">
   <div class="form-group">
        <label for="adress" class="col-form-label">Invoice ID</label>
        <!--<div class="col-sm-8">-->
			<input type="text" readonly tabindex="4" class="form-control" name="fld_voucher_no" placeholder="Voucher Number" id="fld_voucher_no" value="<?= @$sale['fld_voucher_no']?>">
        <!--</div>-->
    </div> 
</div>
<!--</div>-->
<!--<div class="row">-->
<div class="col-sm-4">
    <div class="form-group">
        <label for="invoice_no" class=" col-form-label">Plant <i class="text-danger">*</i></label>
        <!--<div class="col-sm-6">-->
            <select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="fld_location" tabindex="5" id="fld_location">
					<?php
				        if($locations){
						foreach($locations as $loc){
						    if($sale['fld_location_id'] == $loc['fld_id']){
					?>
					<option value="<?= $loc['fld_id'];?>"><?= $loc['fld_location'];?></option>
					<?php }}}?>
            </select>
        <!--</div>-->
    </div> 
</div>
<div class="col-sm-4">
    <div class="form-group">
        <label for="invoice_no" class="col-form-label">Product <i class="text-danger">*</i></label>
        <!--<div class="col-sm-6">-->
            <select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="fld_category" tabindex="6" id="fld_category">
					<?php
				        if($category){
						foreach($category as $cat){
						    if($sale['fld_product_id'] == $cat['fld_id']){
					?>
					<option value="<?= $cat['fld_id'];?>"><?= $cat['fld_category'];?></option>
					<?php }}} ?>
            </select>
        <!--</div>-->
    </div> 
</div>

<!--</div>-->
<!--<div class="row">-->
<div class="col-sm-4">
    <div class="form-group">
        <label for="invoice_no" class="col-form-label">Vehicle #</label>
        <!--<div class="col-sm-6">-->
            <input type="text" tabindex="7" class="form-control" name="fld_vehicle_no" value="<?= @$sale['fld_vehicle_no']?>" placeholder="ABC-123" id="fld_vehicle_no">
        <!--</div>-->
    </div>
</div>

</div>
<div style="display:none" id="stock_avail">
<h4 class="form-section"><i class="icon-eye6"></i>Stock Availability</h4>
<hr>
<div class="row">
    <div class="col-sm-4">
        <div class="form-group ">
            <label for="Shipment" class="col-form-label">Shipment</label>
            <input type="text" tabindex="8" class="form-control" name="shipment" id="shipment_view" readonly>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group ">
            <label for="Shipment" class="col-form-label">Qty(MT)</label>
            <input type="text" tabindex="9" class="form-control" name="qty" id="qty_view" readonly>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group ">
            <label for="Shipment" class="col-form-label">Weight(KG)</label>
            <input type="text" tabindex="10" class="form-control" name="weight" id="weight_view" readonly>
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
            <th class="text-center">#</th> 
            <th class="text-center">Item</th>
            <th class="text-center">Shipment</th>
            <th class="text-center">Qty <i class="text-danger">*</i></th>
            <th class="text-center"> Total Weight</th>
            <th class="text-center">Unit Price(PKR) <i class="text-danger">*</i></th>
            <th class="text-center">Sub Total(PKR)</th>
        </tr>
    </thead>
<tbody id="addPurchaseItem">
<?php if($sale['products']){
	$unit_code='';
	$i=0;
	$fld_total_amount=0;
	foreach($sale['products'] as $key => $salesd){
	    $subcategory = $this->db->query("select * from tbl_subcategory where fld_cid = '{$salesd['fld_product_id']}'")->result_array();
		$i++;
	?>
	<tr>
		<td class="text-center">
		    <input type="hidden" name="sdid[]" value="<?php echo $salesd['fld_id']; ?>" />
		    <input type="hidden" name="stock_location[]" value="<?php echo $salesd['fld_stock_location_id']; ?>" />
		   <?php echo $i;?>
		</td>
	    <td class="text-center">
		 <input type="text" name="" required=""  class="form-control" value="<?php echo $salesd['fld_subcategory']; ?>" aria-required="true" readonly>
		 <select class="fld_product_id" name="fld_subcat_id[]" onchange="product_category(<?php echo $i; ?>);" tabindex="8" id="product_subcat_<?php echo $i; ?>" style="display:none;">
            <option value="">Select Product</option>
			<?php
			if($subcategory){
			foreach($subcategory as $cat){
			?>
			<option value="<?= $cat['fld_subcid'];?>" data-weight="<?= preg_replace('/[^0-9.]/', '', $cat['fld_subcategory']);?>" <?php if($salesd['fld_subproduct_id'] == $cat['fld_subcid']){echo 'selected';} ?>><?= $cat['fld_subcategory'];?></option>
			<?php }} ?>
		</select>
		</td>
	<td class="text-right">
        <input type="text" name="fld_shipment[]" id="fld_shipment_<?php echo $i; ?>" class="form-control" value="<?php echo $salesd['fld_shipment']; ?>" readonly>
    </td>	
	<td class="text-right">
        <input type="number" readonly required name="fld_quantity[]" id="cartoon_<?php echo $i; ?>" required min="0" class="form-control text-right" onkeyup="calculate_store(<?php echo $i; ?>);" onchange="calculate_store(<?php echo $i; ?>);" placeholder="0.00" value="<?php echo $salesd['fld_quantity']; ?>" tabindex="9" aria-required="true" onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false" oninput="validity.valid||(value='');">
    </td>
    <td><input type="number" required name="fld_weight[]" id="weight_<?php echo $i; ?>" required min="0" class="form-control text-right" onkeyup="calculate_store(<?php echo $i; ?>);" onchange="calculate_store(<?php echo $i; ?>);" placeholder="0" value="<?php echo $salesd['fld_weight']; ?>" readonly tabindex="10" aria-required="true">
    <input type="hidden" name="fld_row_discount[]" id="fld_row_discount_<?php echo $i; ?>" class="form-control text-right"  readonly></td>
    <td class="test">
        <input type="number" name="fld_unit_price[]" required="" onkeyup="calculate_store(<?php echo $i; ?>);" onchange="calculate_store(<?php echo $i; ?>);" id="product_rate_<?php echo $i; ?>" class="form-control product_rate_<?php echo $i; ?> text-right" placeholder="0.00" value="<?php echo $salesd['fld_unit_price']; ?>" min="0" tabindex="11" aria-required="true" readonly="readonly">
    </td>
    <td class="text-right">
        <input class="form-control total_price text-right" type="number" name="fld_total_amount[]" id="total_price_<?php echo $i; ?>" value="<?php echo $salesd['fld_total_amount']; ?>"  readonly="readonly">
    </td>
	</tr>
	<?php
	}
	}?>
        </tbody>
        <tfoot id="t_total">
            <tr>
                <td class="text-right" colspan="6"><b>Discount(PKR):</b></td>
                <td class="text-right">
                    <input type="number" step="0.01" id="fld_discount" class="text-right form-control" onkeyup="calculateSum();" name="fld_discount" value="<?= @$sale['fld_discount']?>" tabindex="12" oncopy="return false" ondrag="return false" ondrop="return false" onpaste="return false" oninput="validity.valid||(value='');">
                </td>
            </tr>
            <tr>
                <td class="text-right" colspan="6"><b>Total Discount(PKR):</b></td>
                <td class="text-right">
                    <input type="number" id="fld_total_discount" class="text-right form-control" name="fld_total_discount" value="<?= @$sale['fld_total_discount']?>" readonly="readonly">
                </td>
            </tr>
            <tr>
                <td class="text-right" colspan="6"><b>Net Amount(PKR):</b></td>
                <td class="text-right">
                    <input type="number" id="fld_grand_total_amount" class="text-right form-control" name="fld_grand_total_amount" value="<?= @$sale['fld_grand_total_amount']?>" readonly="readonly">
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
                <td></td>
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
<!--		<h4 class="form-section"><i class="icon-eye6"></i>Payment Details</h4>-->
<!--</div>-->
<!--<hr>-->
<div class="row">
    <? /* ?><div class="col-sm-6">
        <div class="form-group row">
            <label for="invoice_no" class="col-sm-4 col-form-label">Payment Status <i class="text-danger">*</i>
            </label>
            <div class="col-sm-6">
				<select tabindex="10" class="form-control" onchange="paymet_status(this.value)" id="fld_payment_status" name="fld_payment_status" required="required">
					<option value="">Select Payment Status</option>
					<option value="1" <?php if($sale['fld_payment_status'] == '1'){echo 'selected'; } ?>>Paid</option>
					<option value="2" <?php if($sale['fld_payment_status'] == '2'){echo 'selected'; } ?>>Partial Paid</option>
					<option value="3" <?php if($sale['fld_payment_status'] == '3'){echo 'selected'; } ?>>UnPaid</option>
					<option value="4" <?php if($sale['fld_payment_status'] == '4'){echo 'selected'; } ?>>Advance Payment</option>
				</select>
            </div>
        </div>
    </div><? */?>

    <div class="col-sm-6">
       <div class="form-group row" id="payment_type" style="">
            <label for="invoice_no" class="col-sm-4 col-form-label">Payment Type <i class="text-danger"></i>
            </label>
            <div class="col-sm-6">
				<select class="select2 form-control mb-3 custom-select" onchange="cpayment_type(this.value)" tabindex="13" id="fld_payment_type" name="fld_payment_type">
				<option value="">Select Payment Type</option>
				<option value="0" <?php if($sale['fld_payment_type'] == '0'){echo 'selected'; } ?>>Unpaid</option>
				<option value="1" <?php if($sale['fld_payment_type'] == '1'){echo 'selected'; } ?>>Cash</option>
				<option value="2" <?php if($sale['fld_payment_type'] == '2'){echo 'selected'; } ?>>Bank</option>
				</select>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php $amount = ''; ?>
       <div class="form-group row" id="amount_paid" style="<?php if(($sale['fld_payment_type'] == '1' || $sale['fld_payment_type'] == '2')){
        $v_id = $this->db->query("SELECT id FROM tbl_transections_master WHERE type='Sale' AND type_id = '{$sale['fld_id']}'")->row()->id;
        $amount = $this->db->query("SELECT debit FROM tbl_transections_details WHERE v_id='$v_id' AND debit > 0 ORDER BY id DESC")->row()->debit;
       }else{echo'display:none';}?>">
            <label for="invoice_no" class="col-sm-4 col-form-label">Amount Paid <i class="text-danger"></i>
            </label>
            <div class="col-sm-6">
				<input type="text" tabindex="14" class="form-control" name="fld_paid_amount" placeholder="Amount Paid" value="<?=$amount;?>" id="fld_paid_amount">
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group row" id="bank_account" style="<?php if(($sale['fld_payment_type'] == '2')){}else{echo'display:none';}?>">
            <label for="invoice_no" class="col-sm-4 col-form-label">Bank Account <i class="text-danger"></i>
            </label>
            <div class="col-sm-6">
				<select tabindex="15" class="form-control" id="fld_bank" name="fld_bank" >
					<option value="">Select Bank Account</option>
					<?php
						if($banks){
						foreach($banks as $bnk){
					?>
					<option value="<?= $bnk['fld_id'];?>" <?php if($sale['fld_bank'] == $bnk['fld_id']){echo 'selected'; } ?>><?= $bnk['fld_bank'];?> - <?= $bnk['fld_account_title'];?> (<?= $bnk['fld_accountnumber'];?>)</option>
					<?php }}?>
				</select>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
       <div class="form-group row" id="cheque_number" style="<?php if(($sale['fld_payment_status'] == '1' || $sale['fld_payment_status'] == '2') && $sale['fld_payment_type'] == '3'){}else{echo'display:none';}?>">
            <label for="invoice_no" class="col-sm-4 col-form-label">Cheque Number <i class="text-danger"></i>
            </label>
            <div class="col-sm-6">
				<input type="text" tabindex="16" class="form-control" value="<?= @$sale['fld_cheque_number']?>" name="fld_cheque_number" placeholder="Cheque Number" id="fld_cheque_number">
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
       <div class="form-group row" id="cheque_date" style="<?php if(($sale['fld_payment_status'] == '1' || $sale['fld_payment_status'] == '2') && $sale['fld_payment_type'] == '3'){}else{echo'display:none';}?>">
            <label for="invoice_no" class="col-sm-4 col-form-label">Cheque Date 
			<i class="text-danger"></i>
            </label>
            <div class="col-sm-6">
				<input type="text" tabindex="17" class="form-control datepicker" value="<?= date('m/d/Y',strtotime(@$sale['fld_cheque_date']))?>" name="fld_cheque_date" placeholder="" id="fld_cheque_date">
            </div>
        </div>
    </div>
</div>
<hr>
<div class="form-group row">
    <div class="col-sm-8">
        <input type="submit" id="add_sale" class="col-sm-2 btn btn-successs" name="edit-sale" value="Proceed F10" tabindex="18" disabled>
        <input type="submit" value="Submit And Add Another One F6" name="edit-sale-another" class="col-sm-4 btn btn-success1" tabindex="19" id="add_sale_another">
        <input type="hidden" name="sale_id" value="<?= $sale['fld_id']?>"/>
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
<div class="col-lg-12" style="padding:0px;">
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
		<input type="text" class="form-control"  name="fld_landline_num" id="fld_landline_num" tabindex="5">
	</div>
	<div class="mt-3">
		<label class="mb-2">Opening Balance</label>
		<input type="text" class="form-control"  name="fld_opening_bal" id="fld_opening_bal" tabindex="7">
	</div>
	<div class="mt-3">
		<label class="mb-2">Email</label>
		<input type="text" class="form-control"  name="fld_email" id="fld_email" tabindex="9">
	</div>
    <div class="mt-3">
		<label class="mb-2">City</label>
		<input type="text" class="form-control"  name="fld_city" id="fld_city" tabindex="11">
	</div>
	<div class="mt-3">
		<label class="mb-2">Country</label>
		<input type="text" class="form-control" name="fld_country" id="fld_country" tabindex="13">
	</div>
</div> 
<div class="col-lg-6">
	<div class="mt-3">
		<label class="mb-2">Customer Name *</label>
		<input type="text" class="form-control"  name="fld_customer_name" id="fld_customer_name" required tabindex="2">
	</div>
	<div class="mt-3">
		<label class="mb-2">Mobile # *</label>
		<input type="text" class="form-control"  name="fld_mobile_num" id="fld_mobile_num" required tabindex="4">
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
		<input type="text" class="form-control"  name="fld_cnic" id="fld_cnic" tabindex="8">
	</div>
	<div class="mt-3">
		<label class="mb-2">NTN</label>
		<input type="text" class="form-control"  name="fld_ntn" id="fld_ntn" tabindex="10">
	</div>
	<div class="mt-3">
		<label class="mb-2">City Area</label>
		<input type="text" class="form-control"  name="fld_city_area" id="fld_city_area" tabindex="12">
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
			<option value="<?= $scat['fld_subcid'];?>" ><?= $scat['fld_subcategory'];?></option>
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