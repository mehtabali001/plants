<div class="container-fluid">
<div class="row">
	<div class="col-sm-12" style="margin-bottom:1%;">
		<div class="page-title-box">
			<div class="float-right">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Common/addBank" type="button" class="btn btn-primary btn-large"><i class="fa fa-shopping-cart"></i>&nbsp;New Bank</a>
                  <a href="<?= base_url();?>Common/manage_Bank" type="button" class="btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;View Banks</a>
                  <a href="<?= base_url();?>Common/addUnit" type="button" class="btn btn-outline-primary"><i class="fa fa-shopping-cart"></i>&nbsp;New Unit</a>
                  <a href="<?= base_url();?>Common/manage_Category" type="button" class="btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;view Unit</a>
                </div>
			</div>
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<form method="post" action="<?= base_url('Common/addBank');?>">
				<div class="row">
				<div class="col-lg-12">
				<div class="col-lg-6" style="padding: 0px;">
				<?php 
				  $error_message = $this->session->userdata('error_message');
				  if (isset($error_message)) {
				?>
					<div class="alert alert-danger">
						<?php echo $error_message ?>                    
					</div>
				<?php
					$this->session->unset_userdata('error_message');
				}
				?>
				<?php 
				$success_message = $this->session->userdata('success_message');
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
        						<label class="mb-2">Bank Name <i class="text-danger">*</i></label>
        						<input type="text" class="form-control"  name="fld_bank" id="fld_bank" required placeholder="e.g HBL" pattern=".*\S+.*">
        					</div> 
        				</div>
        				<div class="col-lg-6">
                            <div class="mt-3">
        						<label class="mb-2">Bank Account Title <i class="text-danger">*</i></label>
        						<input type="text" class="form-control" name="fld_account_title" id="fld_account_title" required placeholder="e.g Mk TechSol Pvt. Ltd." pattern=".*\S+.*">
        					</div> 
        				</div>
        				<div class="col-lg-6">
                            <div class="mt-3">
        						<label class="mb-2">Bank Account Number <i class="text-danger">*</i></label>
        						<input type="text" class="form-control" name="fld_accountnumber" id="fld_accountnumber" required placeholder="e.g 01014518461456" pattern=".*\S+.*">
        					</div> 
        				</div>
        				<div class="col-lg-6">
        					<div class="mt-3">
        						<label class="mb-2">Bank Address <i class="text-danger">*</i></label>
        						<input type="text" class="form-control" name="fld_address" id="fld_address" required placeholder="e.g Range Road Branch" pattern=".*\S+.*">
        					</div>
        				</div>
        				<div class="col-lg-6">
        				    <div class="mt-3">
        						<label class="mb-2">COA</label>
        						<input type="text" class="form-control" id="fld_coa" value="COA->Assets->Current Assets->Banks" readonly>
        					</div> 
        				</div>
        			</div>
				</div> 
				<div class="col-lg-12">
					<div class="mt-3">
						<label class="mb-2"></label>
						<button type="submit" class="btn btn-successs">Proceed</button>
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