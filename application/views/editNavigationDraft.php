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
@media only screen and (max-width: 600px) {

#update_draft_Navigation, #add_navigationdraft{
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
</style>
<div class="container-fluid">
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right" style="margin-bottom:15px;">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Navigations" type="button" class="btn btn-outline-primary"><i class='fas fa-route'></i>&nbsp;Intransit Navigations</a>
                  <a href="<?= base_url();?>Navigations/manage" type="button" class="btn btn-outline-primary"><i class='fa fa-eye'></i>&nbsp;View Navigations</a>
                  <a href="<?= base_url();?>Navigations/createIntNav" type="button" class="btn btn-outline-primary"><i class='fas fa-rocket'></i>&nbsp;New Navigation</a>
                   <a href="<?= base_url();?>Navigations/navigationReport" type="button" class="btn btn-outline-primary"><i class='fa fa-bar-chart'></i>&nbsp;Navigations Report</a>
                </div>
			</div>
			<!--<h4 class="page-title">Edit Navigation Draft</h4>-->
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
				<div class="panel-body" style="width: 100%;">
                    <form id="updateDraftNavigation" action="<?= base_url('Navigations/create');?>" class="form-vertical" method="post">
                        <input type="hidden" name="createInt" value="1" />
						<div class="col-sm-12">
							<h4 class="form-section"><i class="icon-eye6"></i>Navigation Details <div class="ml3" style="float:right;color:#1ad1bc;display:none; font-size:11px;">Saved in Draft Automatically.</div></h4>
						</div>
						<hr>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="supplier_sss" class="col-sm-4 col-form-label">Navigation Invoice ID <i class="text-danger"></i>
                                    </label>
                                    <div class="col-sm-8">
                                       <input type="text" required="" tabindex="2" class="form-control" readonly name="fld_navigation_id" value="NI-<?= sprintf('%04d', @$navigation['fld_id']);?>" id="fld_navigation_id" >
                                    </div>
                                </div> 
                            </div>

        <!--                     <div class="col-sm-6">-->
								<!--<div class="form-group row">-->
        <!--                            <label for="invoice_no" class="col-sm-4 col-form-label">Received By <i class="text-danger"></i>-->
        <!--                            </label>-->
        <!--                            <div class="col-sm-8">-->
        <!--                                <textarea rows="2"  tabindex="3" class="form-control" placeholder="" id="fld_received_by" name="fld_received_by" ><?//= @$navigation['fld_received_by'];?></textarea>-->
        <!--                            </div>-->
        <!--                        </div>-->
        <!--                    </div>-->
        
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="date" class="col-sm-4 col-form-label"> Navigation Date <i class="text-danger"></i>
                                    </label>
                                    <div class="col-sm-8">
									<input type="text" required="" tabindex="2" class="form-control datepicker" name="fld_navigation_date" value="<?= date('d/m/Y',strtotime(@$navigation['fld_date']));?>" id="fld_navigation_date" >
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            

                            <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="adress" class="col-sm-4 col-form-label">Remarks</label>
                                    <div class="col-sm-8">
										<textarea tabindex="3" rows="2" class="form-control" name="fld_remarks" placeholder="Remarks" id="fld_remarks" value=""><?= @$navigation['fld_remarks'];?></textarea>
                                    </div>
                                </div> 
                            </div>
                        </div>
                        <hr>
						<div class="row">
							<div class="col-sm-4">
                                <div class="form-group row">
                                    <div class="col-sm-12">
									<label for="date"> Location From<i class="text-danger"></i></label>
									<select required class="select2 form-control mb-3 custom-select" name="fld_location_from"  tabindex="4" id="fld_location_from">
										<option value="">Select Location</option>
										<?php
										    if($locations){
											foreach($locations as $loc){
										?>
										<option value="<?= $loc['fld_id'];?>" <?= (@$navigation['fld_location_from'] == $loc['fld_id'])?'selected':'';?>><?= $loc['fld_location'];?></option>
										<?php }} ?>
									</select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group row">
                                    <div class="col-sm-12">
									<label for="date" class=""> Location To<i class="text-danger"></i>
                                    </label>
									<select required class="select2 form-control mb-3 custom-select" name="fld_location_to" tabindex="5" id="fld_location_to">
										<option value="">Select Location</option>
										<?php
										    if($locations){
											foreach($locations as $loc){
										?>
										<option value="<?= $loc['fld_id'];?>" <?= (@$navigation['fld_location_to'] == $loc['fld_id'])?'selected':'';?>><?= $loc['fld_location'];?></option>
										<?php }} ?>
									</select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-sm-4">
                                <div class="form-group row">
                                    <div class="col-sm-12">
									 <label for="date">Item<i class="text-danger"></i>
                                    </label>
									<select class="select2 form-control mb-3 custom-select fld_product_id" name="fld_item" onchange="getDetailView();" required id="product_id" tabindex="6">
                                        <option value="">Select Product</option>
										<?php
											if($category){
											foreach($category as $cat){
										?>
										<option value="<?= $cat['fld_id'];?>" data-unit="<?= $cat['fld_unit'];?>" <?= (@$navigation['fld_product_id'] == $cat['fld_id'])?'selected':'';?>><?= $cat['fld_category'];?></option>
										<?php }} ?>
									</select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
						<div class="col-sm-12">
							<h4 class="form-section"><i class="icon-eye6"></i>Item Details</h4>
						</div>
						<hr>
						
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="purchaseTable">
                                <thead>
                                     <tr>
                                            <!--<th class="text-center" >Sr#</th> -->
                                            <!--<th class="text-center">Item Name</th>-->
                                            <!--<th class="text-center">Location(From)</th>-->
                                            <!--<th class="text-center">QTY(MT)</th>-->
                                            <!--<th class="text-center">Weight(KG)</th>-->
                                            <!--<th class="text-center">Location(To)</th>-->
                                            <!--<th class="text-center">Rate/MT</th>-->
                                            <!--<th class="text-center">Amount(PKR)</th>-->
                                            <th class="text-center" >#</th> 
                                            <th class="text-center">Item Name</th>
                                            <th class="text-center">Shipment</th>
                                            <th class="text-center">QTY</th>
                                            <th class="text-center">Weight(KG)</th>
                                            <th class="text-center">Rate</th>
                                            <th class="text-center">Amount(PKR)</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                </thead>
                                <tbody id="addPurchaseItem">
								<?php if(@$navigation){
									$unit_code='';
									$i=1;
									foreach($navigation['products'] as $navdet){
											//$total += $navdet['fld_amount'];
									?>
                                    <tr>
                                        <td class="text-center">
                                           <?php echo $i;?>
                                        </td>
                                        
                                       <td class="text-center">
                                         <?php 
                                         $product_id_selected = $navdet['fld_product_id'];
                                         if($product_id_selected==1){ ?>
                                    	    <select class="select2 form-control mb-3 custom-select fld_product_id" name="fld_sitem[]" tabindex="7" id="product_subcat_1">
                                                <option value="0" data-weight="1000">LPG</option>
                                    	    <?php }else{ ?>
                                    		 <select class="select2 form-control mb-3 custom-select fld_product_id" name="fld_sitem[]" tabindex="7" onchange="check_sub_product()" id="product_subcat_1">
                                                <option value="">Select Product</option>
                                    			<?php
                                    			if($subcategory){
                                    			foreach($subcategory as $cat){
                                    			?>
                                    			<option value="<?= $cat['fld_subcid'];?>" data-weight="<?= preg_replace('/[^0-9.]/', '', $cat['fld_subcategory']);?>"><?= $cat['fld_subcategory'];?></option>
                                    			<?php }}?>
                                    		</select>
                                    		<?php } ?>  
                                    </td>
                                        
                                    <td class="text-center">
                                        
                                    	    <div class="input-group">
                                    			<input type="text" tabindex="8" class="form-control" name="fld_shipment_from[]" value="<?=$navdet['fld_shipment_from'];?>" id="fld_shipment_1" readonly required>
                                    			<span class="input-group-prepend">
                                    				<button type="button" id="location_shipments_1" onclick="getShipments(1)" class="btn btn-gradient-primary"><i class="fas fa-search"></i></button>
                                    			</span>
                                    		</div>
                                    		<input type="hidden" id="stock_location_id_1" name="stock_location_id[]" value="<?=$navdet['fld_stock_loc_id'];?>"/>
                                    		<input type="hidden" id="fld_purchase_id_1" name="fld_purchase_id[]" value="" />
                                         </td>
                                            <td class="text-center">
											   <input type="text" name="fld_item_qty[]" id="cartoon_1" min="0" class="form-control text-right item_quantity" onkeyup="calculate_store(1);" onchange="calculate_store(1);" placeholder="0.00" value="<?=$navdet['fld_qty'];?>" tabindex="9"  onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false">
                                            </td>
                                            <td>
                                            <input type="number" name="fld_item_weight[]" id="fld_weight_1" class="form-control text-right" onkeyup="calculate_store(1);" onchange="calculate_store(1);" placeholder="0" value="<?php echo $navdet['fld_qty'] * 1000;?>" tabindex="10" aria-required="true" readonly>
                                            </td>
											<td>
                                                <input type="number" name="fld_rate[]" required="" onkeyup="calculate_store(1);" onchange="calculate_store(1);" id="product_rate_1" class="form-control product_rate_1 text-right" placeholder="0.00" value="<?php echo $navdet['fld_rate']?>" min="0" tabindex="11" aria-required="true" readonly>
                                            </td>
											<td>
                                            <input class="form-control fld_amount_row text-right" type="number" name="fld_amount[]" id="total_price_1" value="<?php echo $navdet['fld_amount']?>"  readonly="readonly">
                                            </td>
                                            <td>
                                                <button class="btn btn-danger text-right red" type="button" value="Delete" onclick="deleteRow(this)" ><i class="fas fa-times"></i></button>
                                            </td>
                                            </tr>
									<?php } } ?>
                                </tbody>
                                <tfoot>
                                    <tr> 
                                        <td class="text-right" colspan="6"><b>Total(PKR):</b></td>
                                        <td class="text-center">
											<input readonly type="text" id="fld_total_amount" class="text-right form-control" name="fld_total_amount" value="<?= @$navigation['fld_total_amount']; ?>" style="text-align: left !important;">
                                        </td>
                                        <td> 
                                        <button type="button" id="add_invoice_item" class="btn btn-info" name="add-invoice-item" onclick="addPurchaseOrderField1('addPurchaseItem')" style="display:none" ><i class="fa fa-plus"></i></button>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
						<div class="col-sm-12">
								<h4 class="form-section"><i class="icon-eye6"></i>Freight Details</h4>
						</div>
						<hr>
						<div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="invoice_no" class="col-sm-4 col-form-label">Freight/MT(PKR)  <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-6">
										<input type="text" required  class="form-control" name="fld_freight_rate" onchange="freight_rate();" onkeyup="freight_rate();" placeholder="1500" id="fld_freight_rate" value="<?= @$navigation['fld_freight_MT']?>"  tabindex="12">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                               <div class="form-group row" id="payment_type" >
                                    <label for="invoice_no" class="col-sm-4 col-form-label">Freight(PKR)<i class="text-danger"></i>
                                    </label>
                                    <div class="col-sm-6">
										<input type="text" class="form-control" name="fld_freight_amount" placeholder="0.00" id="fld_freight_amount" value="<?= @$navigation['fld_freight_amount']?>"  tabindex="13">
                                    </div>
                                </div>
                            </div>
                        </div>
						
						<div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row" id="bank_account"  >
                                    <label for="invoice_no" class="col-sm-4 col-form-label">Bowser <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-6">
										<!--<input type="text" tabindex="3" class="form-control" name="fld_bowser" placeholder="" id="fld_bowser" value="<?//= $navigation['fld_bowser']?>">-->
										<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="fld_bowser" id="fld_bowser" tabindex="14" required>
                                                <option selected="selected" value="">Select Vehicle</option>
												<?php
												if($transporter){
												foreach($transporter as $trans){
												?>
												<option value="<?=$trans['fld_id'];?>" data_set="<?=$trans['fld_vehicle_number'];?>" <? if(@$navigation['fld_bowser'] == $trans['fld_id']){ echo 'selected'; } ?>><?=$trans['fld_vehicle_number'];?></option>
												<?php }}?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

						<div class="col-sm-12">
								<h4 class="form-section"><i class="icon-eye6"></i></h4>
						</div>
						<hr>
						<div class="row">
                            <div class="col-sm-6">
                               
                            </div>
							<div class="col-sm-6">
                               <div class="form-group row" id="cheque_date" >
                                    <label for="invoice_no" class="col-sm-4 col-form-label">Net Amount(PKR) 
									<i class="text-danger"></i>
                                    </label>
                                    <div class="col-sm-6">
										<input type="text" tabindex="15" class="form-control" name="fld_grand_total" placeholder="0.00" id="fld_grand_total" value="<?= @$navigation['fld_total_amount']?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-8">
                                <p style="color:red;">Note: You can transfer total available quantity or less than available quantity.</p>
                                <input type="Button" id="update_draft_Navigation" class="col-sm-3 btn btn-warning btn-large" name="edit-navigation-draft" value="Update Draft"  tabindex="16">
                                <input type="submit" id="add_navigationdraft" class="col-sm-2 btn btn-successs btn-large" name="add_navigationdraft" value="Proceed"  tabindex="17">
                               <!-- <input type="submit" value="Submit And Add Another One" name="add-purchase-another" class="btn btn-large btn-info" id="add_purchase_another">-->
								<input type="hidden" name="navigation_id" id="navigation_id" value="<?= @$navigation['fld_id']?>"/>
								<input type="hidden" name="stock_location_id" value="<?= @$navigation['fld_stock_loc_id']?>"/>
								<input type="hidden" name="navigation_type" value="1"/>
                            </div>
                        </div>
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