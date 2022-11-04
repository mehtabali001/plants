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
                  <a href="<?= base_url();?>Navigations/createIntNav" type="button" class="btn btn-outline-primary"><i class='fas fa-rocket'></i>&nbsp;New Navigation</a>
                   <a href="<?= base_url();?>Navigations/navigationReport" type="button" class="btn btn-outline-primary"><i class='fa fa-bar-chart'></i>&nbsp;Navigations Report</a>
                </div>
			</div>
			<!--<h4 class="page-title">Edit Navigation</h4>-->
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
                    <form id="updatenavigation" action="<?= base_url('Navigations/update');?>" class="form-vertical"  method="post" >
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
                                       <input type="text" required="" tabindex="1" class="form-control" readonly name="fld_navigation_id" value="NI-<?= sprintf('%04d', $navigation['fld_id']);?>" id="fld_navigation_id" >
                                    </div>
                                    
                                </div> 
                            </div>

        <!--                     <div class="col-sm-6">-->
								<!--<div class="form-group row">-->
        <!--                            <label for="invoice_no" class="col-sm-4 col-form-label">Received By <i class="text-danger"></i>-->
        <!--                            </label>-->
        <!--                            <div class="col-sm-8">-->
        <!--                                <textarea rows="2" tabindex="2" class="form-control" placeholder="" id="fld_received_by" name="fld_received_by" ><?//= @$navigation['fld_received_by'];?></textarea>-->
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
                        
						<div class="col-sm-12">
								<h4 class="form-section"><i class="icon-eye6"></i>Item Details</h4>
						</div>
						<hr>
						
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="purchaseTable">
                                <thead class="tabletop">
                                     <tr>
                                            <th class="text-center" >#</th> 
                                            <th class="text-center">Item Name</th>
                                            <th class="text-center">From</th>
                                            <th class="text-center">Shipment </th>
                                            <th class="text-center">QTY(MT)</th>
                                            <th class="text-center">Weight(KG)</th>
                                            <th class="text-center">To</th>
                                            <!--<th class="text-center">Shipment To</th>-->
                                            <th class="text-center">Rate/MT</th>
                                            <th class="text-center">Amount(PKR)</th>
                                    </tr>
                                </thead>
                                <tbody id="addPurchaseItem">
								<?php if($navigation){
									$unit_code='';
									$i=1;
									$total = 0;
									foreach($navigation['products'] as $navdet){
									$total += $navdet['fld_amount'];
									?>
                                    <tr>
                                        <td class="text-center">
                                           <?php echo $i;?>
                                        </td>

                                       <td class="text-center">
                                         <?php 
												     $catname =	$this->Common_model->select_single_field('fld_category','tbl_category',array('fld_id'=>$navdet['fld_product_id'])); 
                    							      if($catname == 'LPG'){
                    							         echo $catname;
                    							      }else{
                    							      $subcatname =	$this->Common_model->select_single_field('fld_subcategory','tbl_subcategory',array('fld_subcid'=>$navdet['fld_subproduct_id'])); 
                    							         echo $subcatname;
                    							      }
												
												;?>
										 <input type="hidden" id="fld_product_id" class="text-right form-control" name="fld_product_id[]" value="<?php echo $navdet['fld_product_id'];?>" style="text-align: left !important;">
										 <input type="hidden" id="fld_subproduct_id" class="text-right form-control" name="fld_subproduct_id[]" value="<?php echo $navdet['fld_subproduct_id'];?>" style="text-align: left !important;">
                                        </td>
                                        
                                            <td class="text-center">
                                                <?
                                                $location =	$this->Common_model->select_single_field('fld_location','tbl_locations',array('fld_id'=>$navigation['fld_location_from'])); 
                                                ?>
                                                <input type="text" class="form-control fld_location_from" id="fld_location_from" name="fld_location_from_name" value="<?=$location;?>" readonly="">
                                                <input type="text" class="form-control fld_location_from" id="fld_location_from" name="fld_location_from" value="<?=$navigation['fld_location_from'];?>" readonly="" hidden>
											<? /* ?><select class="select2 form-control mb-3 custom-select fld_location_from" name="fld_location_from" id="fld_location_from" readonly>
                                                <option value=""></option>
												<?php
												if($locations){
													foreach($locations as $loc){
												?>
												<option value="<?= $loc['fld_id'];?>" <?= ($navigation['fld_location_from'] == $loc['fld_id'])?'selected':'';?>><?= $loc['fld_location'];?></option>
												<?php }} ?>
											</select><? */ ?>
                                                
                                            </td>
                                            <td class="text-center">
                                                
												<input type="text" id="fld_shipment_from" class="text-right form-control" name="fld_shipment_from" value="<?php echo $navdet['fld_shipment_from'];?>" style="text-align: left !important;" readonly>
                                            </td>
                                           

                                            <td class="text-center">
                                               
											   <!--<input type="hidden" name="orignal_qty" id="orignal_qty" value="<?php //echo $navdet['orrignal_qty']?>"/>-->
											   <input type="hidden" name="actual_qty" id="actual_qty" value="<?php echo $navdet['fld_qty']?>"/>
                                               <input type="text" id="fld_item_qty" class="text-right form-control item_quantity" data-rate="<?php echo $navdet['fld_rate']?>" name="fld_item_qty" onchangeno="calculate_sum('mt');" onkeyup="calculate_sum('mt');" value="<?php echo $navdet['fld_qty']?>" style="text-align: left !important;" readonly>
                                            </td>
                                            <td>
												
												<input type="text" id="fld_item_weight" class="text-right form-control item_weight" data-rate="<?php echo $navdet['fld_rate']?>" name="fld_item_weight" onchangeno="calculate_sum('kg');" onkeyup="calculate_sum('kg');" value="<?php echo $navdet['fld_qty'] * 1000;?>" style="text-align: left !important;" readonly>
                                            </td>
											<td>
											<select required class="select2 form-control mb-3 custom-select fld_location_to" name="fld_location_to"  id="fld_location_to" tabindex="5">
                                                <option value=""></option>

												<?php
													
												if($locations){
													
													foreach($locations as $loc){
													?>
												<option value="<?= $loc['fld_id'];?>" <?= ($navigation['fld_location_to'] == $loc['fld_id'])?'selected':'';?>><?= $loc['fld_location'];?></option>
												<?php }}?>
												
                                                
											</select>
                                            </td>
											<!--<td>-->
											<!--<input type="text" id="fld_shipment_to" class="text-right form-control" name="fld_shipment_to" value="<?php// echo $navigation['fld_shipment_to'];?>" required style="text-align: left !important;">-->
           <!--                                 </td>-->
											<td>
												<?php echo $navdet['fld_rate']?>
												<input  type="hidden" id="fld_rate" class="text-right form-control" name="fld_rate" value="<?php echo $navdet['fld_rate']?>" style="text-align: left !important;">
												
                                            </td>
											<td>
											<input readonly type="text" id="fld_amount" class="text-right form-control" name="fld_amount" value="<?php echo $navdet['fld_amount']?>" style="text-align: left !important;">
												
                                            </td>
                                    </tr>
									<?php }}?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        
                                        <td class="text-right" colspan="8"><b>Total(PKR):</b></td>
                                        <td class="text-center">
                                            
											<input readonly type="text" id="fld_total_amount" class="text-right form-control"  name="fld_total_amount" value="<?= $total?>" style="text-align: left !important;">
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
										<input type="text" required  class="form-control" step="0.01" tabindex="6" name="fld_freight_rate" onchange="freight_rate();" onkeyup="freight_rate();" placeholder="15000" id="fld_freight_rate" value="<?= $navigation['fld_freight_MT']?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                               <div class="form-group row" id="payment_type" >
                                    <label for="invoice_no" class="col-sm-4 col-form-label">Total Freight(PKR)<i class="text-danger"></i>
                                    </label>
                                    <div class="col-sm-6">
										<input type="text" class="form-control"  readonly name="fld_freight_amount" tabindex="7" placeholder="0.00" id="fld_freight_amount" value="<?= $navigation['fld_freight_amount']?>">
                                    </div>
                                </div>
                            </div>
                        </div>
						<? if(@$navigation['fld_location_from'] != 4){ ?>
						<div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row" id="bank_account"  >
                                    <label for="invoice_no" class="col-sm-4 col-form-label">Bowser <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-6">
										<!--<input type="text" class="form-control" name="fld_bowser" placeholder="" id="fld_bowser" value="<?= $navigation['fld_bowser']?>">-->
										<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="fld_bowser"  onchange="updateValue()" id="fld_bowser"  value="<?= $navigation['fld_bowser']?>" required>
                                                <option selected="selected" value="">Select Vehicle</option>
												<?php
												if($transporter){
												foreach($transporter as $trans){
												?>
												<option value="<?=$trans['fld_id'];?>" data_set="<?=$trans['fld_vehicle_number'];?>"><?=$trans['fld_vehicle_number'];?></option>
												<?php }}?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <? } ?>
						
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
										<input type="text"  class="form-control" readonly name="fld_grand_total" tabindex="8" placeholder="0.00" id="fld_grand_total" value="<?= $navigation['fld_total_amount']?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-8">
                                <p style="color:red;">Note: You can transfer total available quantity or less than available quantity.</p>
                                <input type="submit" id="add_navigation" class="col-sm-3 btn btn-successs btn-large" name="edit-navigation" tabindex="9" value="Proceed F10" disabled>
                                <!--<input type="submit" value="Submit And Add Another One" name="add-purchase-another" class="btn btn-large btn-info" id="add_purchase_another">-->
								<input type="hidden" name="navigation_id" value="<?= $navigation['fld_id']?>"/>
								<input type="hidden" name="stock_location_id" value="<?= $navigation['fld_stock_loc_id']?>"/>
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

                