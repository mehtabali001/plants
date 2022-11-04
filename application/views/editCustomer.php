<div class="container-fluid">
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right" style="margin-bottom:15px;">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Customers" type="button" class="btn btn-outline-primar"><i class="fa fa-shopping-cart"></i>&nbsp;New Customer</a>
                  <a href="<?= base_url();?>Customers/manage_Customers" type="button" class="btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;View Customers</a>
                  <!--<a href="<?//= base_url();?>Customers/customer_ledger" type="button" class="btn btn-outline-primary"><i class="fa fa-vcard"></i>&nbsp;Customer Ledger</a>-->
                  <a href="<?= base_url();?>Customers/manage_CustomersList" type="button" class="btn btn-outline-primary"><i class="fa fa-vcard"></i>&nbsp;Customer List</a>
                  <a href="<?= base_url();?>Sales/salesReport" type="button" class="btn btn-outline-primary"><i class="fa fa-bar-chart"></i>&nbsp;Sales Report</a>
                </div>
			</div>
			<!--<h4 class="page-title">Edit Customer</h4>-->
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<form method="post" action="<?= base_url('Customers/editProcess');?>" id="edit_supplier">
				<div class="row">
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
				
				<div class="col-lg-6">
					<div class="mt-3">
						<label class="mb-2">Customer Code <i class="text-danger">*</i></label>
						<input type="text" class="form-control" name="fld_customer_code" readonly  value="<?= $customer['fld_customer_code'];?>" required tabindex="1">            
					</div>
				</div>
				
					
				<div class="col-lg-6">
					<div class="mt-3">
						<label class="mb-2">Company Name</label>
						<input type="text" name="fld_company_name" class="form-control" id="fld_company_name" tabindex="2" value="<?= $customer['fld_company_name'];?>" placeholder="e.g OGDCL">
					</div>
				</div>	
				
				<div class="col-lg-6">	
					<div class="mt-3">
						<label class="mb-2">Mobile # <i class="text-danger">*</i></label>
						<input type="text" class="form-control" name="fld_mobile_num" data-inputmask="'mask': '0399-99999999'" type="text" maxlength="12" id="fld_mobile_num" required value="<?= $customer['fld_mobile_num'];?>" tabindex="3"  placeholder="03XX-XXXXXXX" >
					</div>
				</div>	
				
				<div class="col-lg-6">	
					<div class="mt-3">
						<label class="mb-2">Customer Type <i class="text-danger">*</i></label>
						<select class="select2 form-control mb-3 custom-select" name="fld_customer_type" id="fld_customer_type" required tabindex="4">
							<option value="">Select type</option>
							<option value="1" <?= ($customer['fld_customer_type'] == 1)? 'selected':'';?>>Local</option>
							<option value="2" <?= ($customer['fld_customer_type'] == 2)? 'selected':'';?>>Importer</option>
						</select>
					</div>
				</div>
				
				<div class="col-lg-6">
					<div class="mt-5" id="" style="margin-left: 30px;">
                        <div class="custom-control custom-switch switch-secondary ">
                        <input type="checkbox" class="custom-control-input" id="customSwitchSecondary" name="moreinfo">
                        <label class="custom-control-label" for="customSwitchSecondary">Additional Info</label>
                    </div>
                    <i class="text-danger" id="phone"></i>
                    </div>
				</div>
				 
				</div>
				
				<div id="moreInfo" class="row" style="display: none;">
				
				<div class="col-lg-6">
					<div class="mt-3">
						<label class="mb-2">Customer Name <i class="text-danger">*</i></label>
						<input type="text" class="form-control" name="fld_customer_name" id="fld_customer_name" required value="<?= $customer['fld_customer_name'];?>" tabindex="5" placeholder="e.g Abdul Malik">
					</div>
				</div>
				
				<div class="col-lg-6">	
					<div class="mt-3">
						<label class="mb-2">Landline #</label>
						<input type="text" class="form-control" name="fld_landline_num" id="fld_landline_num" value="<?= $customer['fld_landline_num'];?>" tabindex="6" placeholder="e.g 051-1234567">
					</div>
				</div>	
				
				<div class="col-lg-6">	
					<div class="mt-3">
						<label class="mb-2">Opening Balance(PKR)</label>
						<input type="text" class="form-control" name="fld_opening_bal" id="fld_opening_bal" value="<?= $customer['fld_opening_bal'];?>" tabindex="7" placeholder="e.g 2500000">
					</div>
				</div>
				
				<div class="col-lg-6">
					<div class="mt-3">
						<label class="mb-2">Email</label>
						<input type="text" class="form-control" name="fld_email" id="fld_email" value="<?= $customer['fld_email'];?>" tabindex="8" placeholder="e.g abc@mail.com">
					</div>
				</div>
				
				<div class="col-lg-6">
				    <div class="mt-3">
						<label class="mb-2">City</label>
						<input type="text" class="form-control" name="fld_city" id="fld_city" value="<?= $customer['fld_city'];?>" tabindex="9" placeholder="e.g Karachi">
					</div>
				</div>
				
				<div class="col-lg-6">
					<div class="mt-3">
						<label class="mb-2">Country</label>
						<input type="text" class="form-control" name="fld_country" id="fld_country" value="<?= $customer['fld_country'];?>" tabindex="10"  placeholder="e.g Pakistan">
					</div>
				</div>	
				
				<div class="col-lg-6">	
					<div class="mt-3">
						<label class="mb-2">CNIC</label>
						<input type="text" data-inputmask="'mask': '99999-9999999-9'" placeholder="XXXXX-XXXXXXX-X" class="form-control" name="fld_cnic" id="fld_cnic" value="<?= $customer['fld_cnic'];?>" tabindex="11">
					</div>
				</div>
				
				<div class="col-lg-6">
					<div class="mt-3">
						<label class="mb-2">NTN</label>
						<input type="text" class="form-control" name="fld_ntn" id="fld_ntn" value="<?= $customer['fld_ntn'];?>" tabindex="12" placeholder="e.g 06251">
					</div>
				</div>
				
				<div class="col-lg-6">
					<div class="mt-3">
						<label class="mb-2">City Area</label>
						<input type="text" class="form-control" name="fld_city_area" id="fld_city_area" value="<?= $customer['fld_city_area'];?>" tabindex="13" placeholder="e.g Islamabad">
					</div>
				</div>
				<div class="col-lg-6">
					<div class="mt-3">
						<label class="mb-2">COA</label>
						<input type="text" class="form-control" id="fld_coa" value="COA->Assets->Current Assets->Customers" tabindex="14" readonly>
					</div> 
				</div>
				</div>
				<input type="hidden" name="fld_customer_id" value="<?= $customer['fld_id'];?>"/>
				<div class="col-lg-6">
					<div class="mt-3">
						<label class="mb-2"></label>
						<button type="submit" class="btn btn-successs" tabindex="15" disabled>Proceed</button>
					</div>
				</div>
				</form>
			</div>
			</div> <!-- end card-body -->
		</div> <!-- end card -->                                       
	</div> <!-- end col -->
</div>
</div><!-- container -->