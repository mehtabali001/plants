<div class="container-fluid">
<div class="row">
	<div class="col-sm-12" style="margin-bottom:1%;">
		<div class="page-title-box">
			<div class="float-right">
			    <div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Common/addStationary" type="button" class="btn btn-primary btn-large"><i class="fa fa-money"></i>&nbsp;New Expense Item</a>
                  <a href="<?= base_url();?>Common/manage_stationary" type="button" class="btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;view Items</a>
                  <a href="<?= base_url();?>Expenses/manage_trash" type="button" class="btn btn-outline-primary"><i class="fa fa-trash"></i>&nbsp;Trashed Expenses</a>
                  <a href="<?= base_url();?>Expenses/manage_drafts" type="button" class="btn btn-outline-primary"><i class="fa fa-files-o"></i>&nbsp;Drafts</a>
                </div>	
			</div>
			<!--<h4 class="page-title">Add Item</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Items</a></li>-->
			<!--	<li class="breadcrumb-item active">Add Item</li>-->
			<!--</ol>-->
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<form method="post" action="<?= base_url('Common/addStationary');?>">
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
				} ?>
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
				<div class="col-lg-6">
					<div class="mt-3">
						<label class="mb-2">Name <i class="text-danger">*</i></label>
						<input type="text" class="form-control"  name="name" placeholder="e.g Groceries for kitchen" id="name" required>
					</div> 
				</div>
				<div class="col-lg-6">
					<div class="mt-3">
						<label class="mb-2">Unit <i class="text-danger">*</i></label>
						<select class="select2 form-control mb-3 custom-select" id="fld_unit" name="fld_unit" required="required">
							<option value="">Select Unit</option>
							<?php
								if($units){
								foreach($units as $unit){
							?>
								<option value="<?= $unit['fld_id'];?>"><?= $unit['fld_unit'];?></option>
							<?php }} ?>
						</select>
					</div>
				</div>
				<div class="col-lg-12">
					<div class="mt-3">
						<label class="mb-2"></label>
						<button type="submit" class="btn btn-gradient-primary">Submit</button>
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

                