<div class="container-fluid">
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Common/addRefinery" type="button" class="btn btn-outline-primary"><i class="fa fa-shopping-cart"></i>&nbsp;New Refinery</a>
                  <a href="<?= base_url();?>Common/manage_Refinery" type="button" class="btn btn-primary btn-large"><i class="fa fa-eye"></i>&nbsp;View Refinery</a>
                  <a href="<?= base_url();?>Common/addLocation" type="button" class="btn btn-outline-primary"><i class="fa fa-shopping-cart"></i>&nbsp;New Warehouse/Location</a>
                  <a href="<?= base_url();?>Common/manage_Location" type="button" class="btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;View Warehouse/Location</a>
                </div>
			</div>
			<h4 class="page-title">Edit Refinery</h4>
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<form method="post" action="<?= base_url('Common/editRefineryProcess');?>" id="edit_supplier">
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
				}
				?>
				<?php $success_message = $this->session->userdata('success_message');
				   if (isset($success_message)) {
			    ?>
					<div class="alert alert-success">
						<?php echo $success_message ?>                    
					</div>
				<?php
					$this->session->unset_userdata('success_message');
				}
				?>
				</div>
				</div>
				<div class="col-lg-12">
				    <div class="row">
				        <div class="col-lg-6">
        					<div class="mt-3">
        						<label class="mb-2">Refinery Name <i class="text-danger">*</i></label>
        						<input type="text" class="form-control" name="fld_name" placeholder="e.g Adhi" id="fld_name" required value="<?=$refinery['fld_name'];?>" pattern=".*\S+.*">
        					</div>
        				</div>
        				<div class="col-lg-6">
        					<div class="mt-3">
        						<label class="mb-2">Address</label>
        						<input type="text" class="form-control" name="fld_address" placeholder="e.g Rwalpindi" id="fld_address" value="<?=$refinery['fld_address'];?>">
        					</div>
        				</div>
        			</div>
				</div> 
				<input type="hidden" name="fld_refinery_id" value="<?= $refinery['fld_id'];?>" />
				<input type="hidden" name="orignal_name" value="<?= $refinery['fld_name'];?>" />
				<div class="col-lg-12">
					<div class="mt-3">
						<label class="mb-2"></label>
						<button type="submit" class="btn btn-successs" disabled>Update</button>
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