<div class="container-fluid">
<div class="row">
	<div class="col-sm-12" style="margin-bottom:1%;">
		<div class="page-title-box">
			<div class="float-right">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Common/addUnit" type="button" class="btn btn-outline-primary"><i class="fa fa-shopping-cart"></i>&nbsp;New Unit</a>
                  <a href="<?= base_url();?>Common/manage_Category" type="button" class="btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;View Unit</a>
                  <a href="<?= base_url();?>Common/addLocation" type="button" class="btn btn-outline-primary"><i class="fa fa-shopping-cart"></i>&nbsp;New Warehouse/Location</a>
                  <a href="<?= base_url();?>Common/manage_Location" type="button" class="btn btn-primary btn-large"><i class="fa fa-eye"></i>&nbsp;View Warehouse/Location</a>
                </div>
			</div>
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<form method="post" action="<?= base_url('Common/editLocationProcess');?>"  id="edit_supplier">
				<div class="row">
				<div class="col-lg-12">
				<div class="col-lg-6" style="padding: 0px;">
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
				</div>
				<div class="col-lg-12">
				    <div class="row">
				        <div class="col-lg-6">
        					<div class="mt-3">
        						<label class="mb-2">Plant Name <i class="text-danger">*</i></label>
        						
        						<input type="text" class="form-control"  name="fld_location" id="fld_location" required value="<?= $location['fld_location'];?>" placeholder="e.g Durnal Plant" pattern=".*\S+.*">
        					</div>
        				</div>
        				<div class="col-lg-6">
        					<div class="mt-3">
        						<label class="mb-2">Plant Address <i class="text-danger">*</i></label>
        						
        						<input type="text" class="form-control"  name="fld_address" id="fld_address" required value="<?= $location['fld_address'];?>" placeholder="e.g Chakwal Road Durnal" pattern=".*\S+.*">
        					</div>
        				</div>
        			</div><br>
        			<span style="color:red;">Note: By Adding new Plant/WareHouse , the system will create/add Cash in Hand, Petty Cash, Inventory Account, Profit and Loss Division and Expense Account automatically , also system assigns ID's to each account. Please avoid to add those accounts manually.</span>
        			
				</div> 
				<input type="hidden" name="fld_location_id" value="<?= $location['fld_id'];?>"/>
				<input type="hidden" name="orignal_location" value="<?= $location['fld_location'];?>"/>
				<div class="col-lg-12">
					<div class="mt-3">
						<label class="mb-2"></label>
						<button type="submit" class="btn btn-successs"disabled>Update</button>
					</div>
				</div>
				
				</div>
				</form>
			</div>
			</div> <!-- end card-body -->
		</div> <!-- end card -->                                       
	</div> <!-- end col -->


</div>
                    

</div><!-- container -->

                