<div class="container-fluid">
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="javascript:void(0);">ERP</a></li>
					<li class="breadcrumb-item active">Update Profile Pic</li>
				</ol>
			</div>
			<h4 class="page-title">Update Profile Pic</h4>
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<form method="post" action="<?= base_url('Settings/update_profile_picture');?>" enctype="multipart/form-data" >
				<div class="row">
				<div class="col-lg-12">
				<div class="col-lg-12" style="padding: 0px;">
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
        						<label class="mb-2">Logo</label>
        						<input type="file" name="user_logo" class="form-control" id="">
									<? if(!empty($user_profile['fld_user_pic'])) { ?>
									<br>	
									<img width="100" src="<?=base_url()?>/assets/uploads/user_dp/<?=$user_profile['fld_user_pic'];?>" alt="N/A" >
									<input type="hidden" name="user_id" value="<?= $this->session->userdata('user_id');?>" />
									<? } ?>
        					</div>
        				</div>
        			</div>
				</div> 
				<div class="col-lg-12">
					<div class="mt-3">
						<label class="mb-2"></label>
						<button type="submit" class="btn btn-successs">proceed</button>
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