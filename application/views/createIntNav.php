
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
                  <a href="<?= base_url();?>Navigations/createIntNav" type="button" class="btn btn-primary btn-large"><i class='fas fa-rocket'></i>&nbsp;New Navigation</a>
                  <a href="<?= base_url();?>Navigations/navigationReport" type="button" class="btn btn-outline-primary"><i class='fa fa-bar-chart'></i>&nbsp;Navigations Report</a>
                </div>
			</div>
			<!--<h4 class="page-title">Create Navigation</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Navigations</a></li>-->
			<!--	<li class="breadcrumb-item active">Create Navigation</li>-->
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
				<div class="panel-body" style="width: 100%;">
                    <form id="addNavigation" action="<?= base_url('Navigations/create');?>" class="form-vertical" method="post" >
                        <input type="hidden" name="createInt" value="1" />
						<div class="col-sm-12">
							<h4 class="form-section"><i class="icon-eye6"></i>Navigation Details <div class="ml3" style="float:right;color:#1ad1bc;display:none; font-size:11px;">Saved in Draft Automatically.</div></h4>
						</div>
						<hr>
                        <div class="row">
						
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="supplier_sss" class="col-sm-4 col-form-label">Voucher Number <i class="text-danger"></i>
                                    </label>
                                    <div class="col-sm-8">
                                       <input type="text" required="" tabindex="1" class="form-control" readonly name="fld_navigation_id" value="NI-<?= $maxid;?>" id="fld_navigation_id" >
                                    </div>
                                    
                                </div> 
                            </div>

        <!--                     <div class="col-sm-6">-->
								<!--<div class="form-group row">-->
        <!--                            <label for="invoice_no" class="col-sm-4 col-form-label">Received By <i class="text-danger"></i>-->
        <!--                            </label>-->
        <!--                            <div class="col-sm-8">-->
        <!--                                <textarea rows="2"  tabindex="2" class="form-control" placeholder="" id="fld_received_by" name="fld_received_by" ></textarea>-->
        <!--                            </div>-->
        <!--                        </div>-->
                                
        <!--                    </div>-->
        
                                <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="date" class="col-sm-4 col-form-label"> Date <i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
									<input type="text" required tabindex="2" class="form-control datepicker" name="fld_navigation_date" value="<?= date('d/m/Y');?>" id="fld_navigation_date" >
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
						<hr>
						<div class="row">
                            
							<div class="col-sm-4">
                                <div class="form-group row">
                                    
                                    <div class="col-sm-12">
									<label for="date" class=""> Location From<i class="text-danger">*</i>
                                    </label>
									<select required class="select2 form-control mb-3 custom-select fld_location_from" tabindex="4" name="fld_location_from"  id="fld_location_from">
										<option value="">Select Location</option>
										<?php
										$locationsget = $this->db->query("SELECT * FROM tbl_locations WHERE fld_id != 4")->result_array();	
										if($locationsget){
											foreach($locationsget as $loc){
										?>
										<option value="<?= $loc['fld_id'];?>" ><?= $loc['fld_location'];?></option>
										<?php }} ?>
									</select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group row">
                                    <div class="col-sm-12">
									<label for="date" class=""> Location To<i class="text-danger">*</i>
                                    </label>
									<select required class="select2 form-control mb-3 custom-select fld_location_from" tabindex="5" name="fld_location_to"  id="fld_location_to">
										<option value="">Select Location</option>
										<?php
										$locationsget = $this->db->query("SELECT * FROM tbl_locations WHERE fld_id != 0")->result_array();	
										if($locationsget){
										foreach($locationsget as $loc){
										?>
										<option value="<?= $loc['fld_id'];?>" ><?= $loc['fld_location'];?></option>
										<?php }}?>
									</select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-sm-4">
                                <div class="form-group row">
                                    <div class="col-sm-12">
									<label for="date">Item<i class="text-danger">*</i></label>
									<select class="select2 form-control mb-3 custom-select fld_product_id" tabindex="6" name="fld_item" onchange="getDetailView();" required id="product_id">
                                        <option value="">Select Product</option>
										<?php
											if($category){
											foreach($category as $cat){
										?>
										<option value="<?= $cat['fld_id'];?>" data-unit="<?= $cat['fld_unit'];?>"><?= $cat['fld_category'];?></option>
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
                                <thead class="tabletop">
                                     <tr>
                                        <!--<th class="text-center">Sr#</th> -->
                                        <th class="text-center">Item Name</th>
                                        <th class="text-center">Shipment</th>
                                        <th class="text-center">QTY</th>
                                        <th class="text-center">Weight(KG)</th>
                                        <th class="text-center">Rate</th>
                                        <th class="text-center">Amount(PKR)</th>
                                        <!--<th class="text-center">Action</th>-->
                                    </tr>
                                </thead>
                                <tbody id="addPurchaseItem">
									
                                </tbody>
                                <tfoot id="t_total" style="display:none">
                                    <tr>
                                        <td class="text-right" colspan="5"><b>Total(PKR):</b></td>
                                        <td class="text-center">
											<input readonly type="text" id="fld_total_amount" class="text-right form-control" name="fld_total_amount" value="" style="text-align: left !important;">
                                        </td>
                                        <!--<td> -->
                                        <!--<button type="button" id="add_invoice_item" class="btn btn-info" name="add-invoice-item" onclick="addPurchaseOrderField1('addPurchaseItem')" ><i class="fa fa-plus"></i></button>-->
                                        <!--</td>-->
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
                                    <label for="invoice_no" class="col-sm-4 col-form-label">Freight/MT(PKR) <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-6">
										<input type="text" required step="0.01" class="form-control" name="fld_freight_rate" onchange="freight_rate();" onkeyup="freight_rate();" placeholder="15000" id="fld_freight_rate" value="" tabindex="10">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                               <div class="form-group row" id="payment_type" >
                                    <label for="invoice_no" class="col-sm-4 col-form-label">Total Freight(PKR)<i class="text-danger"></i>
                                    </label>
                                    <div class="col-sm-6">
										<input type="text" class="form-control"readonly name="fld_freight_amount" placeholder="0.00" id="fld_freight_amount" value="" tabindex="11">
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
										<!--<input type="text" tabindex="3" class="form-control" name="fld_bowser" placeholder="" id="fld_bowser" value="">-->
										<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="fld_bowser" id="fld_vehicle_no" tabindex="12" required>
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

          <!--                  <div class="col-sm-6">-->
          <!--                     <div class="form-group row" id="cheque_number" >-->
          <!--                          <label for="invoice_no" class="col-sm-4 col-form-label">Quantity <i class="text-danger"></i>-->
          <!--                          </label>-->
          <!--                          <div class="col-sm-6">-->
										<!--<input type="text" tabindex="3" class="form-control" name="fld_quantity" placeholder="" id="fld_quantity" value="">-->
          <!--                          </div>-->
          <!--                      </div>-->
          <!--                  </div>-->
                        </div>
						<!--<div class="row">-->
      <!--                      <div class="col-sm-6">-->
      <!--                         <div class="form-group row" id="cheque_date" >-->
      <!--                              <label for="invoice_no" class="col-sm-4 col-form-label">Weight -->
						<!--			<i class="text-danger"></i>-->
      <!--                              </label>-->
      <!--                              <div class="col-sm-6">-->
						<!--				<input type="text" tabindex="3" class="form-control" name="fld_weight" placeholder="" id="fld_weight" value="">-->
      <!--                              </div>-->
      <!--                          </div>-->
      <!--                      </div>-->
      <!--                  </div>-->
						<div class="col-sm-12">
								<h4 class="form-section"><i class="icon-eye6"></i></h4>
						</div>
						<hr>
						<div class="row">
                            <div class="col-sm-6">
                               
                            </div>
							<div class="col-sm-6">
                               <div class="form-group row" id="cheque_date" >
                                    <label for="invoice_no" class="col-sm-4 col-form-label">Total Amount(PKR)
									<i class="text-danger"></i>
                                    </label>
                                    <div class="col-sm-6">
										<input type="text" class="form-control" name="fld_grand_total" placeholder="0.00" id="fld_grand_total" value="0.00" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
        <!--                <div class="form-group row">-->
        <!--                    <div class="col-sm-6">-->
        <!--                        <input type="submit" id="add_navigation" class="btn btn-primary btn-large" name="add-navigation" value="Submit">-->
        <!--                        <input type="submit" value="Submit And Add Another One" name="add-purchase-another" class="btn btn-large btn-info" id="add_purchase_another">-->
								
								<!--<input type="hidden" name="navigation_type" value="2"/>-->
        <!--                    </div>-->
        <!--                </div>-->
                        <div class="form-group row">
                            <div class="col-sm-8">
                                <p style="color:red;">Note: You can transfer total available quantity or less than available quantity.</p>
                                <input type="submit" id="add_navigation" class="col-sm-2 btn btn-successs" name="add-navigation" value="Proceed F10" tabindex="13">
                                <input type="submit" value="Proceed And Add Another One F6" name="add-navigation-another" class="col-sm-4 btn btn-success1" id="add_navigation_another" tabindex="14">
								<input type="button" id="add_navigation_draft" class="col-sm-3 btn btn-warning btn-large" name="add-navigation-draft" value="Navigation Draft F7" tabindex="15">
								<input type="reset"  class="col-sm-2 btn btn-danger btn-large" name="reset" id="Reset" value="Reset F5" tabindex="16">
								<input type="hidden" name="navigation_type" value="1"/>
								<input type='hidden' id='navigation_id' name="navigation_id">
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
			if($cat['fld_id']==1){
			    echo '<option value="0" data-weight="1000">LPG</option>';
			}else{
			    if($subcat){
			        echo '<option value="">Select Product</option>';
				foreach($subcat as $scat){
			?>
			<option value="<?= $scat['fld_subcid'];?>" data-weight="<?= preg_replace('/[^0-9.]/', '', $scat['fld_subcategory']);?>"><?= $scat['fld_subcategory'];?></option>
			<?php }}}?>
	</div> 
	<?php } ?>  
	
	<div id="locationSelect" style="display:none;">
	<?php
	if($locations){
	foreach($locations as $loc){
	?>
	<option value="<?= $loc['fld_id'];?>" ><?= $loc['fld_location'];?></option>
	<?php }} ?>
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
                