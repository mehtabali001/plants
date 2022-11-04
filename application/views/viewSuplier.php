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
                  <a href="<?= base_url();?>Supplier" type="button" class="btn btn-outline-primary"><i class="fa fa-shopping-cart"></i>&nbsp;New Supplier</a>
                  <a href="<?= base_url();?>Supplier/manage_Supplier" type="button" class="btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;View Suppliers</a>
                  <a href="<?= base_url();?>Purchase" type="button" class="btn btn-outline-primary"><i class="fa fa-shopping-cart"></i>&nbsp;New Purchase Bill</a>
                  <a href="<?= base_url();?>Purchase/purchReport" type="button" class="btn btn-outline-primary"><i class="fa fa-bar-chart"></i>&nbsp;Purchase Report</a>
                </div>
			</div>
			<!--<h4 class="page-title">View Supplier</h4>-->
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<form method="post" action="<?= base_url('Supplier/editProcess');?>">
				<div class="row">
				<!--<div class="col-lg-6">-->
				    <? if(!empty(@$supplier['fld_supplier_code'])){ ?>
				    <div class="col-lg-6">
					<div class="form-group row">
						<label for="example-text-input" class="col-sm-5 col-form-label">Supplier Code:</label>
						<div class="col-form-label col-sm-7">
						    <?= @$supplier['fld_supplier_code'];?>
							<!--<input class="form-control" readonly type="text" value="<?//= @$supplier['fld_supplier_code'];?>" id="example-text-input">-->
						</div>
					</div>
					</div>
					<? } ?>
					<?if (!empty($supplier['fld_supplier_name'])){?>
					<div class="col-lg-6">
					<div class="form-group row">
						<label for="example-text-input" readonly class="col-sm-5 col-form-label">Supplier Name:</label>
						<div class="col-form-label col-sm-7">
						    <?= $supplier['fld_supplier_name'];?>
							<!--<input class="form-control" readonly type="text" value="<?//= (@$supplier['fld_supplier_name'] != "")?$supplier['fld_supplier_name']:'NA';?>" id="example-text-input">-->
						</div>
					</div>
					</div>
					<? } ?>
					<? if(!empty(@$supplier['fld_company_name'])){ ?>
					<div class="col-lg-6">
					<div class="form-group row">
						<label for="example-text-input" class="col-sm-5 col-form-label">Company Name:</label>
						<div class="col-form-label col-sm-7">
						    <?= @$supplier['fld_company_name'];?>
							<!--<input class="form-control" readonly type="text" value="<?//= (@$supplier['fld_company_name'] != "")?@$supplier['fld_company_name']:'NA';?>" id="example-text-input">-->
						</div>
					</div>
					</div>
					<? } ?>
					<? if(!empty(@$supplier['fld_supplier_type'])){ ?>
					<div class="col-lg-6">
					<div class="form-group row">
						<label for="example-text-input" class="col-sm-5 col-form-label">Supplier Type:</label>
						<div class="col-form-label col-sm-7">
						    <?= (@$supplier['fld_supplier_type'] == 1)? 'Local':'Importer';?>
							<!--<input class="form-control" readonly type="text" value="<?//= (@$supplier['fld_supplier_type'] == 1)? 'Local':'Importer';?>" id="example-text-input">-->
						</div>
					</div>
					</div>
					<? } ?>
					<? if(!empty(@$supplier['fld_opening_bal'])){ ?>
					<div class="col-lg-6">
					<div class="form-group row">
						<label for="example-text-input" class="col-sm-5 col-form-label">Opening Balance:</label>
						<div class="col-sm-7 col-form-label">
						    <?= @$supplier['fld_opening_bal'];?>
							<!--<input class="form-control" readonly type="text" value="<?//= (@$supplier['fld_opening_bal'] != "")?@$supplier['fld_opening_bal']:'NA';?>" id="example-text-input">-->
						</div>
					</div>
					</div>
					<? } ?>
					<? if(!empty(@$supplier['fld_city'])){ ?>
					<div class="col-lg-6">
					<div class="form-group row">
						<label for="example-text-input" class="col-sm-5 col-form-label">City:</label>
						<div class="col-sm-7 col-form-label">
						    <?= @$supplier['fld_city'];?>
							<!--<input class="form-control" readonly type="text" value="<?//= (@$supplier['fld_city'] != "")?@$supplier['fld_city']:'NA';?>" id="example-text-input">-->
						</div>
					</div>
					</div>
					<? } ?>
					<? if(!empty(@$supplier['fld_city_area'])){ ?>
					<div class="col-lg-6">
					<div class="form-group row">
						<label for="example-text-input" class="col-sm-5 col-form-label">City Area:</label>
						<div class="col-sm-7 col-form-label">
						    <?= @$supplier['fld_city_area'];?>
							<!--<input class="form-control" readonly type="text" value="<?//= (@$supplier['fld_city_area'] != "")?@$supplier['fld_city_area']:'NA';?>" id="example-text-input">-->
						</div>
					</div>
					</div>
					<? } ?>
				<!--</div>-->
				<!--<div class="col-lg-6">-->
				    <? if(!empty(@$supplier['fld_mobile_num'])){ ?>
				    <div class="col-lg-6">
					<div class="form-group row">
						<label for="example-text-input" class="col-sm-5 col-form-label">Mobile:</label>
						<div class="col-sm-7 col-form-label">
						    <?= @$supplier['fld_mobile_num'];?>
							<!--<input class="form-control" readonly type="text" value="<?//= (@$supplier['fld_mobile_num'] != "")?@$supplier['fld_mobile_num']:'NA';?>" id="example-text-input">-->
						</div>
					</div>
					</div>
					<? } ?>
					<? if(!empty(@$supplier['fld_landline_num'])){ ?>
					<div class="col-lg-6">
					<div class="form-group row">
						<label for="example-text-input" class="col-sm-5 col-form-label">Landline:</label>
						<div class="col-sm-7 col-form-label">
						    <?= @$supplier['fld_landline_num'];?>
							<!--<input class="form-control" readonly type="text" value="<?//= (@$supplier['fld_landline_num'] != "")?@$supplier['fld_landline_num']:'NA';?>" id="example-text-input">-->
						</div>
					</div>
					</div>
					<?}?>
					<? if(!empty(@$supplier['fld_email'])){ ?>
					<div class="col-lg-6">
					<div class="form-group row">
						<label for="example-text-input" class="col-sm-5 col-form-label">Email:</label>
						<div class="col-sm-7 col-form-label">
						    <?= @$supplier['fld_email'];?>
							<!--<input class="form-control" readonly type="text" value="<?//= (@$supplier['fld_email'] != "")?@$supplier['fld_email']:'NA';?>" id="example-text-input">-->
						</div>
					</div>
					</div>
					<? }?>
					<? if(!empty(@$supplier['fld_cnic'])){ ?>
					<div class="col-lg-6">
					<div class="form-group row">
						<label for="example-text-input" class="col-sm-5 col-form-label">CNIC:</label>
						<div class="col-sm-7 col-form-label">
						    <?= @$supplier['fld_cnic'];?>
							<!--<input class="form-control" readonly type="text" value="<?//= (@$supplier['fld_cnic'] != "")?@$supplier['fld_cnic']:'NA';?>" id="example-text-input">-->
						</div>
					</div>
					</div>
					<?  }?>
					<? if(!empty(@$supplier['fld_ntn'])){ ?>
					<div class="col-lg-6">
					<div class="form-group row">
						<label for="example-text-input" class="col-sm-5 col-form-label">NTN:</label>
						<div class="col-sm-7 col-form-label">
						    <?= @$supplier['fld_ntn'];?>
							<!--<input class="form-control" readonly type="text" value="<?//= (@$supplier['fld_ntn'] != "")?@$supplier['fld_ntn']:'NA';?>" id="example-text-input">-->
						</div>
					</div>
					</div>
					<? }?>
					<? if(!empty(@$supplier['fld_country'])){ ?>
					<div class="col-lg-6">
					<div class="form-group row">
						<label for="example-text-input" class="col-sm-5 col-form-label">Country:</label>
						<div class="col-sm-7 col-form-label">
						    <?= @$supplier['fld_country'] ;?>
							<!--<input class="form-control" readonly type="text" value="<?= (@$supplier['fld_country'] != "")?@$supplier['fld_country']:'NA';?>" id="example-text-input">-->
						</div>
					</div>
					</div>
					<? }?>
					<div class="col-lg-6">
					<div class="form-group row">
						<label for="example-text-input" class="col-sm-5 col-form-label">COA:</label>
						<div class="col-sm-7 col-form-label">
						    <?="COA->Assets->Current Assets->Suppliers";?>
							<!--<input type="text" class="form-control" id="fld_coa" value="COA->Assets->Current Assets->Suppliers" readonly>-->
						</div>
					</div>
					</div>
				</div>
				</div>
			</div>
			</div> <!-- end card-body -->
		</div> <!-- end card -->                                       
	</div> <!-- end col -->
</div>
</div><!-- container -->