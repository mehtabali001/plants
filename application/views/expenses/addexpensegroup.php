<div class="container-fluid">
<div class="row">
	<div class="col-sm-12" style="margin-bottom:2%;">
		<div class="page-title-box">
			<div class="float-right">
			    <div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Common/addexpensegroup" type="button" class="btn btn-primary btn-large"><i class="fa fa-money"></i>&nbsp;New Expense Group</a>
                  <a href="<?= base_url();?>Common/view_expensegroup" type="button" class="btn btn-outline-primary"><i class="fa fa-vcard"></i>&nbsp;View Expense Groups</a>
                  <a href="<?= base_url();?>Expenses/manage_trash" type="button" class="btn btn-outline-primary"><i class="fa fa-trash"></i>&nbsp;Trashed Expenses</a>
                  <a href="<?= base_url();?>Expenses/manage_drafts" type="button" class="btn btn-outline-primary"><i class="fa fa-files-o"></i>&nbsp;Drafts</a>
                </div>	
			</div>
			<!--<h4 class="page-title">Add Shift</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Shifts</a></li>-->
			<!--	<li class="breadcrumb-item active">Add Shift</li>-->
			<!--</ol>-->
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<form method="post" action="<?= base_url('Common/addexpensegroup');?>">
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
						<label class="mb-2">Expense Group Name <i class="text-danger">*</i></label>
						<input type="text" class="form-control"  name="expense_group_name" placeholder="e.g Morning/Night.." id="shift_name" required>
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