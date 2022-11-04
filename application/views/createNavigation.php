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

#add_navigation, #add_navigation_another, #add_navigation_draft, #Reset{
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
                  <a href="<?= base_url();?>Navigations" type="button" class="btn btn-outline-primary"><i class='fas fa-route'></i>>&nbsp;Intransit Navigation</a>
                  <a href="<?= base_url();?>Navigations/manage" type="button" class="btn btn-outline-primary"><i class='fa fa-eye'></i>&nbsp;View Navigations</a>
                  <a href="#" type="button" class="btn btn-primary btn-large"><i class='fas fa-rocket'></i>&nbsp;New Navigation</a>
                  <a href="<?= base_url();?>Navigations/navigationReport" type="button" class="btn btn-outline-primary"><i class='fa fa-bar-chart'></i>&nbsp;Navigations Report</a>
                </div>
			</div>
			<!--<h4 class="page-title">+ Intransit Navigation</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Navigations</a></li>-->
			<!--	<li class="breadcrumb-item active">New Intransit Navigation</li>-->
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
				} ?>
				<?php 
				$success_message = $this->session->userdata('success_message');
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
                    <form action="<?= base_url('Navigations/create');?>" class="form-vertical"  method="post" >
						<div class="col-sm-12">
							<h4 class="form-section"><i class="icon-eye6"></i>Navigation Details</h4>
						</div>
						
						<hr>
                        <div class="row">
						
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="supplier_sss" class="col-sm-4 col-form-label">Invoice ID <i class="text-danger"></i>
                                    </label>
                                    <div class="col-sm-8">
                                       <input type="text" required=""  class="form-control" tabindex="1" readonly name="fld_navigation_id" value="NI-<?= $maxid;?>" id="fld_navigation_id" >
                                    </div>
                                    
                                </div> 
                            </div>

        <!--                     <div class="col-sm-6">-->
								<!--<div class="form-group row">-->
        <!--                            <label for="invoice_no" class="col-sm-4 col-form-label">Received By <i class="text-danger"></i>-->
        <!--                            </label>-->
        <!--                            <div class="col-sm-8">-->
        <!--                                <textarea rows="2"  tabindex="2" class="form-control"  placeholder="" id="fld_received_by" name="fld_received_by" ></textarea>-->
        <!--                            </div>-->
        <!--                        </div>-->
        <!--                    </div>-->
        
                          <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="date" class="col-sm-4 col-form-label"> Navigation Date <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8">
									<input type="text" required="" tabindex="2" class="form-control datepicker" name="fld_navigation_date" value="<?= date('d/m/Y');?>" id="fld_navigation_date" >
                                    </div>
                                </div>
                            </div>
                            
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="adress" class="col-sm-4 col-form-label">Remarks</label>
                                    <div class="col-sm-8">
										<textarea tabindex="3" rows="2" class="form-control" name="fld_remarks" placeholder="Remarks" id="fld_remarks" value=""></textarea>
                                    </div>
                                </div> 
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="date" class="col-sm-4 col-form-label"> Location From<i class="text-danger"></i>
                                    </label>
                                    <div class="col-sm-6">
									<select class="select2 form-control mb-3 custom-select fld_location_from" name="fld_location_from"  id="fld_location_from" tabindex="4">
                                        <!--<option value=""></option>-->
										<?php
    										if($locations){
    										foreach($locations as $loc){
    										if(4 == $loc['fld_id']){
										?>
										<option value="<?= $loc['fld_id'];?>" <?= (4 == $loc['fld_id'])?'selected':'';?>><?= $loc['fld_location'];?></option>
										<?php }}} ?>
									</select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="adress" class="col-sm-4 col-form-label">Location To <i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
										<select required class="select2 form-control mb-3 custom-select fld_location_to" onchange="updateShipmentValue()" name="fld_location_to"  id="fld_location_to" tabindex="5" important>
                                            <option value="" selected>Select Location</option>
											<?php
											if($locations){
											    foreach($locations as $loc){
											        if($loc['fld_id']!=4){
												?>
											<option value="<?= $loc['fld_id'];?>" data-name="<?= $loc['fld_location'];?>"><?= $loc['fld_location'];?></option>
											<?php }}}?>
										</select>
										<input type="hidden" name="fld_shipment_to" id="fld_shipment_to" value="" />
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
                                <thead class="tabletop">
                                     <tr>
                                            <!--<th class="text-center" >#</th> -->
                                            <th class="text-center">Item Name</th>
                                            <th class="text-center">Shipment</th>
                                            <th class="text-center">QTY(MT)</th>
                                            <th class="text-center">Weight(KG)</th>
                                            <!--<th class="text-center">Shipment To</th>-->
                                            <th class="text-center">Rate/MT</th>
                                            <th class="text-center">Amount(PKR)</th>
                                        </tr>
                                </thead>
                                <tbody id="addPurchaseItem">
                                    
								<?php 
								$fld_total_amount=0;
								if($purchase){
									$unit_code='';
									$i=0;
									
									foreach($purchase as $key => $purchase){
									    $i++;
										//$key =$key +1;
										$fld_total_amount =$fld_total_amount + ($purchase['fld_stock_qty'] * $purchase['fld_unit_price']);
										$subcat='';
                					    if($purchase['fld_subproduct_id'] != '0'){
                					        $subcat = ' - '.$this->db->query("select * from tbl_subcategory where fld_subcid = '{$purchase['fld_subproduct_id']}'")->row()->fld_subcategory;
                					    }
									?>
                                    <tr>
                                        <!--<td class="text-center">-->
                                        <!--   <?php //echo $i;?>-->
                                           
                                        <!--</td>-->

                                       <td class="text-center">
                                         <?php echo $purchase['fld_category'].$subcat;?>
										 <input type="hidden" id="fld_item_<?=$i;?>" class="text-right form-control" name="fld_item[]" value="<?php echo $purchase['fld_product_id'];?>" style="text-align: left !important;">
										 <input type="hidden" id="fld_sitem_<?=$i;?>" class="text-right form-control" name="fld_sitem[]" value="<?php echo $purchase['fld_subproduct_id'];?>" style="text-align: left !important;">
                                         <input type="hidden" name="stock_location_id[]" value="<?= $purchase['fld_id']?>"/>
                                        </td>
                                        
                                            <td class="text-center">
                                                
												<input type="text" id="fld_shipment_from_<?=$i;?>" class="text-right form-control" name="fld_shipment_from" value="<?php echo $purchase['fld_shipment'];?>" style="text-align: left !important;" readonly>
                                            </td>
                                           

                                            <td class="text-center">
                                               
											   <input type="hidden" name="orignal_qty[]" id="orignal_qty_<?=$i;?>" value="<?php echo $purchase['fld_stock_qty']?>"/>
                                               <input type="number" step="0.001" id="fld_item_qty_<?=$i;?>" class="text-right form-control item_quantity" data-rate="<?php echo $purchase['fld_unit_price']?>" name="fld_item_qty[]" onchangeno="calculate_sum('mt', <?=$i;?>);" onkeyup="calculate_sum('mt', <?=$i;?>);" tabindex="7" value="<?php echo $purchase['fld_stock_qty']?>" style="text-align: left !important;" onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false" oninput="validity.valid||(value='');">
                                            </td>
                                            <td>
												
												<input type="number" id="fld_item_weight_<?=$i;?>" class="text-right form-control item_weight" data-rate="<?php echo $purchase['fld_unit_price']?>" name="fld_item_weight[]" onchangeno="calculate_sum('kg', <?=$i;?>);" onkeyup="calculate_sum('kg', <?=$i;?>);" value="<?php echo $purchase['fld_stock_qty'] * 1000;?>" style="text-align: left !important;" readonly>
                                            </td>
    										<td>
												<?php echo $purchase['fld_unit_price']?>
												<input  type="hidden" id="fld_rate_<?=$i;?>" class="text-right form-control" name="fld_rate[]" value="<?php echo $purchase['fld_unit_price']?>" style="text-align: left !important;">
												
                                            </td>
											<td>
											<input readonly type="text" id="fld_amount_<?=$i;?>" class="text-right form-control fld_amount_row" name="fld_amount[]" value="<?php echo number_format($purchase['fld_stock_qty'] * $purchase['fld_unit_price'], 2, '.', '');?>" style="text-align: left !important;">
												
                                            </td>
                                    </tr>
									<?php
									}
									}?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        
                                        <td class="text-right" colspan="5"><b>Total(PKR):</b></td>
                                        <td class="text-center">
                                            
											<input readonly type="text" id="fld_total_amount" class="text-right form-control" name="fld_total_amount" value="<?php echo number_format($fld_total_amount, 2, '.', '');?>" style="text-align: left !important;">
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
										<input type="number" required  class="form-control"tabindex="8" name="fld_freight_rate"  placeholder="15000" id="fld_freight_rate" value="" step="0.01" onchange="freight_rate();" onkeyup="freight_rate();" >
										<!---->
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                               <div class="form-group row" id="payment_type" >
                                    <label for="invoice_no" class="col-sm-4 col-form-label">Total Freight(PKR)<i class="text-danger"></i>
                                    </label>
                                    <div class="col-sm-6">
										<input type="number" class="form-control" name="fld_freight_amount" tabindex="9" placeholder="0.00" id="fld_freight_amount" value="" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
						
						<div class="row">
                            
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
										<input type="text"  class="form-control" name="fld_grand_total"  placeholder="" id="fld_grand_total" value="0.00" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-8">
                                <p style="color:red;">Note: You can transfer total available quantity or less than available quantity.</p>
                                <input type="submit" id="add_navigation" class="col-sm-2 btn btn-successs btn-large" name="add-navigation" value="Proceed" tabindex="10">
                               <!-- <input type="submit" value="Submit And Add Another One" name="add-purchase-another" class="btn btn-large btn-info" id="add_purchase_another">-->
								
								<input type="hidden" name="purchase_id" value="<?= $purchase['fld_purchase_id']?>"/>
								<input type="hidden" name="navigation_type" value="1"/>
                            </div>
                        </div>
                    </form>                    </div>
				
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
						
						<input type="text" class="form-control" name="fld_supplier_code" readonly  value="<?= $maxid;?>" required >            
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
						
						<input type="text"  name="fld_company_name" class="form-control" id="fld_company_name" required >
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

                