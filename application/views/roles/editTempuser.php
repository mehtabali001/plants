<style>
    .select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #bac1dc;
    line-height: 28px;
    padding-top: 2px;
}
.select2-dropdown {
    background-color: #212744;
    border: 1px solid #575252;
	border-bottom: 1px solid #2a2f4e;
}
.select2-container--default .select2-results__option[aria-selected=true] {
    background-color: #5897FB;
}
.select2-container--default .select2-selection--single {
    background-color: #212744;
    border: 1px solid #575252;
    border-radius: 4px;
	min-height: 36px;
}
.select2-container--default .select2-selection--multiple {
    background-color: #212744;
    border: 1px solid #575252;
    border-radius: 4px;
	min-height: 36px;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #bac1dc;
    line-height: 28px;
    padding-top: 2px;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #212744;
    font-size: 10px;
}
.select2-container--default.select2-container--disabled .select2-selection--single {
    background-color: #171c40;
    cursor: default;
}
</style>
<div class="container-fluid">
<div class="row">
	<div class="col-sm-12" style="margin-bottom: 2%;">
		<div class="page-title-box">
			<div class="float-right">
				<!--<ol class="breadcrumb">-->
				<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">ERP</a></li>-->
				<!--	<li class="breadcrumb-item active">Edit Roles</li>-->
				<!--</ol>-->
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <!--<a href="<?//= base_url();?>Roles/assign_roles" type="button" class="btn btn-outline-primary"><i class="fa fa-user-circle"></i>&nbsp;New Permanent User</a>-->
                  <!--<a href="<?//= base_url();?>Roles/assigned_roles" type="button" class="btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;View Permanent Users</a>-->
                  <a href="<?= base_url();?>Roles/add_tempuser" type="button" class="btn  btn-outline-primary "><i class="fa fa-user-circle"></i>&nbsp;New Temp. User</a>
                  <a href="<?= base_url();?>Roles/manage_tempuser" type="button" class="btn btn-primary btn-large"><i class="fa fa-eye"></i>&nbsp;View Temp. Users</a>
                </div>
			</div>
			<h4 class="page-title">Edit Roles</h4>
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<form method="post" action="<?= base_url('Roles/edittempuserProcess');?>">
				<div class="row">
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
				<div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="txtFirstNameBilling" >Full Name <i class="text-danger">*</i></label>
                        <input id="full_name" name="full_name" type="text" class="form-control" value="<?=$user['fld_username'];?>" required="required" placeholder="Afzal">
                    </div><!--end form-group-->
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Email <i class="text-danger">*</i></label>
                        <input id="email" name="email" type="email" class="form-control" value="<?=$user['fld_email'];?>" required>
                    </div>
                </div><!--end col-->                                 

                <div class="col-md-4">
                    <div class="form-group ">
                        <label>Assigned Role <i class="text-danger">*</i></label>
                        <select class="select2 form-control mb-3 custom-select" id="role" name="role" required>
                            <option value="" selected>--Select Roles--</option>
                            <?php $role	=	$this->Common_model->select_where_ASC_DESC('role_id,role_name','tbl_roles',array('deleted'=>0),'role_name','ASC');
                                if($role->num_rows() > 0) {
                                foreach($role->result() as $dept) {
                            ?>
                                <option value="<?php echo $dept->role_id;?>" <? if($dept->role_id == $user['fld_role']){ ?> selected <? } ?> ><?php echo $dept->role_name;?></option>
                            <?php } } ?>
                        </select>
                        <input type="hidden" name="old_role" value="<?= $user['fld_role']?>"/>
                    </div>
                </div>
                
                <div class="col-md-4">
                        <div class="form-group">
                            <label>Assigned Plant <i class="text-danger">*</i></label>
                            <select class="select2 form-control mb-3 custom-select" id="plant" name="plant" required>
                                <option value="" selected>--Select Plant--</option>
                                <?php $plants	=	$this->Common_model->select_where_ASC_DESC('fld_id,fld_location,fld_status','tbl_locations',array('fld_status'=>1),'fld_location','ASC');
                                    if($plants->num_rows() > 0) {
                                    foreach($plants->result() as $plant) {
                                ?>
                                    <option value="<?php echo $plant->fld_id;?>" <? if($plant->fld_id == $user['plant_id']){ ?> selected <? } ?> ><?php echo $plant->fld_location;?></option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>

                <!--<div class="col-md-6">
                    <div class="form-group row">
                        <label for="txtFirstNameBilling" class="col-sm-3 col-form-label">Password</label>
                        <div class="col-sm-9">
                            <input name="password" type="password" class="form-control" value="" placeholder="Enter Password" autocomplete="new-password">
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group row">
                        <label for="txtFirstNameBilling" class="col-sm-3 col-form-label">C. Pass</label>
                        <div class="col-sm-9">
                            <input id="Cpassword" name="Cpassword" type="password" class="form-control" value="" placeholder="Confirm New Password">
                        </div>
                    </div>
                </div>-->
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Mobile Number <i class="text-danger">*</i></label>
                        <input id="mobilenumber" name="mobilenumber" type="text" class="form-control" value="<?=$user['fld_mobile_number'];?>" placeholder="Your Mobile Number" required>
                    </div>
                </div>
                
                    
                <div class="col-md-4">
                    <div class="form-group ">
                    <label>Acc. Status</label>
                    <select class="select2 form-control mb-3 custom-select" name="fld_status">
                        <option value="1" <? if($user['fld_status'] == 1){ ?> selected <? } ?>>Active</option>
                        <option value="2" <? if($user['fld_status'] == 2){ ?> selected <? } ?>>In Active</option>
                    </select>
                    </div>
                    <input type="hidden" name="old_status" value="<?= $user['fld_status']?>"/>
                </div>
                
                <div class="col-md-4">
                        <div class="row">
           <!--                 <div class="col-sm-4">-->
           <!--                     <div class="checkbox checkbox-success form-check-inline" id="otpp_check"  style="margin-top: 40%;">-->
           <!--                     <input type="checkbox" name="sendotp" class="admin_menu" value="1" <?//= ($user['fld_send_otp'] ==  1)? 'checked':'';?>>-->
           <!--                     <label for="admin_menu"> -->
    							<!--  Send OTP-->
    							<!--</label>-->
    							<!--</div>-->
           <!--                 </div>-->
                            <div class="col-sm-8">
                                <input type="hidden" name="fld_id" value="<?= $user['fld_id'];?>"/>
                                <input type="hidden" name="old_pass" value="<?= $user['fld_password'];?>"/>
                                <button type="submit" id="bttnn_proceed" class="btn btn-successs" style="margin-top: 12%;">Proceed</button>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-md-12">-->
                    <!--    <p style="color:red;">Note : If Send OTP is checked then this login will need OTP (One Time Password) after login.</p>-->
                    <!--</div>-->
				</div> 
			   </form>
			</div>
			</div><!-- end card-body -->
		</div><!-- end card -->                                       
	</div><!-- end col -->
</div>