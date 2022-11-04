<style>
   .col-form-label {
    text-align: left;
} 
</style>
<div class="container-fluid">
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right" style="margin-bottom:15px;">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Customers" type="button" class="btn btn-outline-primary"><i class="fa fa-shopping-cart"></i>&nbsp;New Customer</a>
                  <a href="<?= base_url();?>Customers/manage_Customers" type="button" class="btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;View Customers</a>
                  <a href="<?= base_url();?>Customers/manage_CustomersList" type="button" class="btn btn-outline-primary"><i class="fa fa-vcard"></i>&nbsp;Customer List</a>
                  <a href="<?= base_url();?>Sales/salesReport" type="button" class="btn btn-outline-primary"><i class="fa fa-bar-chart"></i>&nbsp;Sales Report</a>
                </div>
			</div>
			<!--<h4 class="page-title">View Customer</h4>-->
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<form method="post" action="<?= base_url('Customers/editProcess');?>">
				<div class="row">
				<? if(!empty(@$customer['fld_customer_code'])){?>    
				<div class="col-lg-6">
					<div class="form-group row">
						<label for="example-text-input" class="col-sm-4 col-form-label">Customer Code:</label>
						<div class="col-form-label col-sm-8">
						    <?= @$customer['fld_customer_code'];?>
							<!--<input class="form-control" readonly type="text" value="<?//= @$customer['fld_customer_code'];?>" id="example-text-input">-->
						</div>
					</div>
				</div>
				<? } ?>
				
				<? if(!empty(@$customer['fld_customer_name'])){?>
				<div class="col-lg-6">
					<div class="form-group row">
						<label for="example-text-input" readonly class="col-sm-4 col-form-label">Customer Name:</label>
						<div class="col-form-label col-sm-8">
						    <?= @$customer['fld_customer_name'];?>
							<!--<input class="form-control" readonly type="text" value="<?//= (@$customer['fld_customer_name'] != "")?$customer['fld_customer_name']:'NA';?>" id="example-text-input">-->
						</div>
					</div>
				</div>
				<? } ?>
				
				<? if(!empty(@$customer['fld_company_name'])){?>
				<div class="col-lg-6">
					<div class="form-group row">
						<label for="example-text-input" class="col-sm-4 col-form-label">Company Name:</label>
						<div class="col-form-label col-sm-8">
						    <?= @$customer['fld_company_name'];?>
							<!--<input class="form-control" readonly type="text" value="<?//= (@$customer['fld_company_name'] != "")?@$customer['fld_company_name']:'NA';?>" id="example-text-input">-->
						</div>
					</div>
				</div>
				<? } ?>
				
				<? if(!empty(@$customer['fld_customer_type'])){?>
				<div class="col-lg-6">
					<div class="form-group row">
						<label for="example-text-input" class="col-sm-4 col-form-label">Customer Type:</label>
						<div class="col-form-label col-sm-8">
						    <?= (@$customer['fld_customer_type'] == 1)? 'Local':'Importer';?>
							<!--<input class="form-control" readonly type="text" value="<?//= (@$customer['fld_customer_type'] == 1)? 'Local':'Importer';?>" id="example-text-input">-->
						</div>
					</div>
				</div>
				<? } ?>
				
				<? if(!empty(@$customer['fld_opening_bal'])){?>
				<div class="col-lg-6">
					<div class="form-group row">
						<label for="example-text-input" class="col-sm-4 col-form-label">Opening Balance:</label>
						<div class="col-form-label col-sm-8">
						    <?= @$customer['fld_opening_bal'];?>
							<!--<input class="form-control" readonly type="text" value="<?//= (@$customer['fld_opening_bal'] != "")?@$customer['fld_opening_bal']:'NA';?>" id="example-text-input">-->
						</div>
					</div>
				</div>
				<? } ?>
				
				<? if(!empty(@$customer['fld_mobile_num'])){?>
				<div class="col-lg-6">
					<div class="form-group row">
						<label for="example-text-input" class="col-sm-4 col-form-label">Mobile:</label>
						<div class="col-form-label col-sm-8">
						    <?= @$customer['fld_mobile_num'];?>
							<!--<input class="form-control" readonly type="text" value="<?//= (@$customer['fld_mobile_num'] != "")?@$customer['fld_mobile_num']:'NA';?>" id="example-text-input">-->
						</div>
					</div>
				</div>
				<? } ?>
				
				<? if(!empty(@$customer['fld_landline_num'])){?>
				<div class="col-lg-6">
					<div class="form-group row">
						<label for="example-text-input" class="col-sm-4 col-form-label">Landline:</label>
						<div class="col-form-label col-sm-8">
						    <?= @$customer['fld_landline_num']; ?>
							<!--<input class="form-control" readonly type="text" value="<?//= (@$customer['fld_landline_num'] != "")?@$customer['fld_landline_num']:'NA';?>" id="example-text-input">-->
						</div>
					</div>
				</div>
				<? } ?>
				
				<? if(!empty(@$customer['fld_email'])){?>
				<div class="col-lg-6">
					<div class="form-group row">
						<label for="example-text-input" class="col-sm-4 col-form-label">Email:</label>
						<div class="col-form-label col-sm-8">
						    <?= @$customer['fld_email']; ?>
							<!--<input class="form-control" readonly type="text" value="<?//= (@$customer['fld_email'] != "")?@$customer['fld_email']:'NA';?>" id="example-text-input">-->
						</div>
					</div>
				</div>
				<? } ?>
				
				<? if(!empty(@$customer['fld_cnic'])){?>
				<div class="col-lg-6">
					<div class="form-group row">
						<label for="example-text-input" class="col-sm-4 col-form-label">CNIC:</label>
						<div class="col-form-label col-sm-8">
						    <?= @$customer['fld_cnic']; ?>
							<!--<input class="form-control" readonly type="text" value="<?//= (@$customer['fld_cnic'] != "")?@$customer['fld_cnic']:'NA';?>" id="example-text-input">-->
						</div>
					</div>
				</div>
				<? } ?>
				
				<? if(!empty(@$customer['fld_ntn'])){?>
				<div class="col-lg-6">
					<div class="form-group row">
						<label for="example-text-input" class="col-sm-4 col-form-label">NTN:</label>
						<div class="col-form-label col-sm-8">
						    <?= @$customer['fld_ntn']; ?>
							<!--<input class="form-control" readonly type="text" value="<?//= (@$customer['fld_ntn'] != "")?@$customer['fld_ntn']:'NA';?>" id="example-text-input">-->
						</div>
					</div>
				</div>
				<? } ?>
				
				<? if(!empty(@$customer['fld_city'])){?>
				<div class="col-lg-6">
					<div class="form-group row">
						<label for="example-text-input" class="col-sm-4 col-form-label">City:</label>
						<div class="col-form-label col-sm-8">
						    <?= @$customer['fld_city']; ?>
							<!--<input class="form-control" readonly type="text" value="<?//= (@$customer['fld_city'] != "")?@$customer['fld_city']:'NA';?>" id="example-text-input">-->
						</div>
					</div>
				</div>
				<? } ?>
				
				<? if(!empty(@$customer['fld_city_area'])){?>
				<div class="col-lg-6">
					<div class="form-group row">
						<label for="example-text-input" class="col-sm-4 col-form-label">City Area:</label>
						<div class="col-form-label col-sm-8">
						    <?= @$customer['fld_city_area']; ?>
							<!--<input class="form-control" readonly type="text" value="<?= (@$customer['fld_city_area'] != "")?@$customer['fld_city_area']:'NA';?>" id="example-text-input">-->
						</div>
					</div>
				</div>
				<? } ?>
				<? if(!empty(@$customer['fld_country'])){?>
				<div class="col-lg-6">
					<div class="form-group row">
						<label for="example-text-input" class="col-sm-4 col-form-label">Country:</label>
						<div class="col-form-label col-sm-8">
						    <?= @$customer['fld_country']; ?>
							<!--<input class="form-control" readonly type="text" value="<?//= (@$customer['fld_country'] != "")?@$customer['fld_country']:'NA';?>" id="example-text-input">-->
						</div>
					</div>
				</div>
				<? } ?>
				
				<? //if(!empty(@$customer['fld_country'])){?>
				<div class="col-lg-6">
					<div class="form-group row">
						<label for="example-text-input" class="col-sm-4 col-form-label">COA:</label>
						<div class="col-form-label col-sm-8">
						    <?= "COA->Assets->Current Assets->Customers"; ?>
							<!--<input type="text" class="form-control" id="fld_coa" value="COA->Assets->Current Assets->Customers" readonly>-->
						</div>
					</div>
				</div>
				<? //} ?>
				
				</div>
			</div>
			</div> <!-- end card-body -->
		</div> <!-- end card -->                                       
	</div> <!-- end col -->
</div>
</div><!-- container -->