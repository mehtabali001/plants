
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
<div class="container-fluid">
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right" style="margin-bottom:15px;">
    			<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Gain_loss" type="button" class="btn btn-primary btn-large"><i class="fa fa-shopping-cart"></i>&nbsp;New Gain-Loss</a>
                  <a href="<?= base_url();?>Gain_loss/manage" type="button" class="btn btn-outline-primary"><i class='fas fa-eye'></i>&nbsp;View Gain-Loss</a>
                  <a href="<?= base_url();?>Gain_loss/Gain_loss_report" type="button" class="btn btn-outline-primary"><i class="fa fa-bar-chart"></i>&nbsp;Gain-Loss Report</a>
                  <a href="<?= base_url();?>Gain_loss/manage_trash" type="button" class="btn btn-outline-primary"><i class='fa fa-trash'></i>&nbsp;Gain-Loss Trash</a>
                </div>
			</div>
			<!--<h4 class="page-title">+ Gain-Loss</h4>-->
			<!--	<ol class="breadcrumb">-->
			<!--		<li class="breadcrumb-item"><a href="javascript:void(0);">Gain-Loss</a></li>-->
			<!--		<li class="breadcrumb-item active">New Gain-Loss</li>-->
			<!--	</ol>-->
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
                    <form id="addPurchase" action="<?= base_url('Gain_loss/add');?>" class="form-vertical"  method="post" >
                                                                         
                        
						<div class="col-sm-12">
							<h4 class="form-section"><i class="icon-eye6"></i>Invoice Details</h4>
						</div>
						
						<hr>
                        <div class="row">
						
                            <div class="col-sm-4">
                               <div class="form-group row">
                                    <label for="adress" class="col-sm-4 col-form-label">Gain-Loss Invoice ID</label>
                                    <div class="col-sm-8">
										<input type="text" readonly tabindex="4" class="form-control" name="fld_voucher_no" placeholder="Voucher Number" id="fld_voucher_no" value="<?=$autoVoucherID;?>">
										
                                    </div>
                                </div> 
                            </div>

                             <div class="col-sm-4">
                                <div class="form-group row">
                                    <label for="date" class="col-sm-4 col-form-label">Invoice Date <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8">
									<input type="text" required="" tabindex="2" class="form-control datepicker" name="fld_date" value="" id="date" >
                                    </div>
                                </div>
                            </div>
                        
                            <div class="col-sm-4">
                                <div class="form-group row">
                                    <label for="invoice_no" class="col-sm-4 col-form-label">Remarks <i class="text-danger"></i>
                                    </label>
                                    <div class="col-sm-8">
                                        <input type="text" tabindex="3" class="form-control" placeholder="Remarks"  id="remarks" name="fld_remarks">
										
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
                                        <th class="text-center">Product Category<i class="text-danger">*</i></th>
                                        <th class="text-center">Location<i class="text-danger">*</i></th>
                                        <th class="text-center">Type</th>
                                        <th class="text-center">Shipment</th>
                                        <th class="text-center">Qty (KG)<i class="text-danger">*</i></th>
                                        <th class="text-center">Unit Price (PKR)<i class="text-danger">*</i></th>
                                        <th class="text-center">Sub Total(PKR)</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="addPurchaseItem">
                                    <tr>
                                        <input type="hidden" readonly id="fld_sale_price_1" value="0">
										<input type="hidden" readonly id="fld_purchase_price_1" value="0">
                                        <td class=" supplier">
                                           <select class="select2 form-control mb-3 custom-select fld_product_id" name="fld_product_id[]" onchange="product_category(1);" tabindex="7" id="product_id_1" required>
                                                <option value="">Select Product</option>
												<?php
												if($category){
												foreach($category as $cat){
												?>
												<option value="<?= $cat['fld_id'];?>" data-unit="<?= $cat['fld_unit'];?>"><?= $cat['fld_category'];?></option>
												<?php }}?>
											</select>
                                        </td>
                                        <td class=" location">
                                           <select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="fld_location_id[]" onchange="getShipments(1);" tabindex="6" id="fld_location_id_1" required>
                                            <option value="">Select Location</option>
											<?php
											if($locations){
											foreach($locations as $loc){
											?>
											<option value="<?= $loc['fld_id'];?>"><?= $loc['fld_location'];?></option>
											<?php }}?>
                                        </select>
                                        </td>
                                        
                                        <td class="type">
                                            <select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" onchange="shipmentCheck(1)" name="fld_type[]" tabindex="6" id="fld_type_1" required>
                                                <option value="">Select Type</option> 
												<option value="1">Gain</option> 
												<option value="2">Loss</option>   
												<option value="3">Difference</option>
                                            </select>
                                        </td>
                                        <td class="shipment">
                                            <div style="display:none" id="d_fld_shipment_1">
                                                <select class="select2 form-control mb-3 custom-select fld_shipment" style="width: 100%; height:36px;" onchange="getQty(1);" name="fld_shipment[]" tabindex="6" id="s_fld_shipment_1" disabled required>
                                                    <option value="">Select Shipment</option>
    										    </select>
                                            </div>
                                            
    										<input type="text" name="fld_shipment[]" id="i_fld_shipment_1" class="form-control" aria-required="true">
                                        </td>
                                         <td class="qTY">
                                             <input type="hidden" name="fld_stock_location_id[]" id="fld_stock_location_id_1" value="0" />
                                            <input type="text" name="fld_quantity[]" id="fld_quantity_1" required min="0" class="form-control text-right" onkeyup="calculate_store(1);" onchange="calculate_store(1);" placeholder="0.00" value="" tabindex="8" aria-required="true">
                                        </td>
                                        <td class="test">
                                            <input type="text" name="fld_unit_price[]" required onkeyup="calculate_store(1);" onchange="calculate_store(1);" id="product_rate_1" class="form-control product_rate_1 text-right" placeholder="0.00" value="" min="0" tabindex="9" readonly aria-required="true">
                                        </td>
                                        <td class="text-right">
                                            <input class="form-control total_price text-right" type="text" name="fld_total_amount[]" id="total_price_1" value="0.00"  readonly="readonly">
                                        </td>
                                        <td>
                                            <button class="btn btn-danger text-right red" type="button" value="Delete" onclick="deleteRow(this)" ><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-right" colspan="6"><b>Net Amount(Pkr):</b></td>
                                        <td class="text-right">
                                            <input type="text" id="fld_grand_total_amount" class="text-right form-control" name="fld_grand_total_amount" value="0.00" readonly="readonly">
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
                        <hr>
                        <div class="form-group row">
                            <div class="col-sm-8">
                                <input type="submit" id="add_gain_loss" class="btn btn-successs" name="add-gain-loss" value="Proceed F10">
                                <input type="submit" value="Submit And Add Another One F6" name="add-gain-loss-another" class="btn btn-success1" id="add_gain_loss_another">
								<input type="reset"  class="btn btn-danger btn-large" name="reset" id="Reset" value="Reset F5">
                            </div>
                        </div>
                        <br>
                    </form>
                </div>
				
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
	<div id="locationSelect" style="display:none;">
			<?php
				if($locations){
				foreach($locations as $loc){
				?>
				<option value="<?= $loc['fld_id'];?>"><?= $loc['fld_location'];?></option>
			<?php }}?>
			
	</div>

</div><!-- container -->
<script>
     var count = 2;
</script>
                