<div class="container-fluid">
<div class="row">
	<div class="col-sm-12" style="margin-bottom:1%;">
		<div class="page-title-box">
			<div class="float-right">
			    <div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Common/addDesignation" type="button" class="btn btn-outline-primary"><i class="fa fa-shopping-cart"></i>&nbsp;New Designation</a>
                  <a href="<?= base_url();?>Common/manage_designations" type="button" class="btn btn-primary btn-large"><i class="fa fa-vcard"></i>&nbsp;View Designations</a>
                  <a href="<?= base_url();?>Common/addUnit" type="button" class="btn btn-outline-primary"><i class="fa fa-shopping-cart"></i>&nbsp;New Unit</a>
                  <a href="<?= base_url();?>Common/manage_Category" type="button" class="btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;View Unit</a>
                </div>	
			</div>
			
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<form method="post" action="<?= base_url('Common/editDesignationProcess');?>" id="edit_supplier">
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
					<div class="mt-3">
						<label class="mb-2">Designation Name <i class="text-danger">*</i></label>
						<input type="text" class="form-control"  name="designation_name" placeholder="e.g General Manager/Deputy Manager.." id="designation_name" required value="<?= $desig['designation_name'];?>" pattern=".*\S+.*">
					</div> 
					<div class="mt-3">
						<label class="mb-2">Designation Detail</label>
						<textarea type="textarea" class="form-control"  name="designation_detail" placeholder="Add Designation Responsibilities.." id="designation_detail" ><?= $desig['designation_detail'];?></textarea>
					</div>                                    
				</div> 
				<input type="hidden" name="id" value="<?= $desig['id'];?>"/>
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