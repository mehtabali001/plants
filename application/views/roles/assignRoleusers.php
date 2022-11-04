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
	<div class="col-sm-12"  style="margin-bottom: 2%;">
		<div class="page-title-box">
		    <div class="float-right">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Roles/assign_roles" type="button" class="btn btn-outline-primary"><i class="fa fa-user-circle"></i>&nbsp;New Permanent User</a>
                  <a href="<?= base_url();?>Roles/assigned_roles" type="button" class="btn btn-primary btn-large"><i class="fa fa-eye"></i>&nbsp;View Permanent Users</a>
                  <a href="<?= base_url();?>Roles/add_tempuser" type="button" class="btn btn-outline-primary"><i class="fa fa-user-circle"></i>&nbsp;New Temp. User</a>
                  <a href="<?= base_url();?>Roles/manage_tempuser" type="button" class="btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;View Temp. Users</a>
                </div>
			</div>
			<!--<div class="float-right">-->
				<!--<ol class="breadcrumb">-->
				<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">ERP</a></li>-->
				<!--	<li class="breadcrumb-item active">Edit Roles</li>-->
				<!--</ol>-->
			<!--</div>-->
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<form method="post" action="<?= base_url('Roles/editRolespermissionProcess');?>">
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
				</div>
				<div class="row">
				    <div class="col-md-12">
				    <!--<h3>New User</h3>-->
				    <hr>
				    </div>
				    <div class="col-md-4">
                        <div class="form-group ">
                            <label for="txtFirstNameBilling" class="col-form-label" >Full Name <i class="text-danger">*</i></label>
                            <input id="full_name" name="full_name" type="text" class="form-control" value="<?=$employee['full_name'];?>" required="required" placeholder="Afzal" readonly>
                        </div><!--end form-group-->
                    </div>
				    <div class="col-md-4">
                        <div class="form-group ">
                            <label for="txtFirstNameBilling" class="col-form-label">Employee ID <i class="text-danger">*</i></label>
                            <input id="employee_code" name="employee_code" type="text" class="form-control" readonly value="<?= $employee['employee_code'];?>" required>
                        </div><!--end form-group-->
                    </div>
                    <div class="col-md-4">
                        <div class="form-group ">
                            <label class="col-form-label">Email</label>
                            <input id="email" name="email" type="email" class="form-control"  value="<?= $employee['email'];?>" readonly >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group ">
                        <label class=" col-form-label">Acc. Status</label>
                        <select class="select2 form-control mb-3 custom-select" name="fld_status">
                            <option value="1" <? if($user['fld_status'] == 1){ ?> selected <? } ?>>Active</option>
                            <option value="2" <? if($user['fld_status'] == 2){ ?> selected <? } ?>>In Active</option>
                        </select>
                        </div>
                        <input type="hidden" name="old_status" value="<?= $user['fld_status']?>"/>
                    </div>
					<!--<div class="col-md-4">-->
     <!--                   <div class="form-group ">-->
     <!--                       <label class="col-form-label">Plants</label>-->
     <!--                       <select class="select2 form-control mb-3 custom-select" id="plants" name="plants" disabled>-->
     <!--                           <option value="" >--Select Plant--</option>-->
   <!--                           <?
				//			    $tbl_plants	=	$this->Common_model->select_where_ASC_DESC('fld_id,fld_location','tbl_locations',array('fld_status'=>1),'fld_location','ASC');-->
    //  <!--                               if($tbl_plants->num_rows() > 0) {-->
    //  <!--                               foreach($tbl_plants->result() as $plant){-->
    //  <!--                           ?>-->
    <!--                               <option value="<?//php echo $plant->fld_id;?>"  <? //if($plant->fld_id == $employee['plants']){ ?> selected <?// } ?>><?//php echo $plant->fld_location;?></option>-->
                             <?// } } ?>
     <!--                       </select>-->
     <!--                   </div>-->
     <!--               </div>-->
                    <?php $old_role = 0;
                        $user_d =	$this->db->query("SELECT * from tbl_users where emp_id = '{$employee['id']}' AND fld_email = '{$employee['email']}'");
                        if($user_d->num_rows() > 0){
                            $user = $user_d->row();
                            $old_role = $user->fld_role;
                            $fld_send_otp = $user->fld_send_otp;
                            
                        } ?>
                    <div class="col-md-4">
                        <div class="form-group ">
                            <label class=" col-form-label">Assigned Role</label>
                            <select class="select2 form-control mb-3 custom-select" id="role" name="role">
                                <option value="" selected>--Select Roles--</option>
                                <?php $role	=	$this->Common_model->select_where_ASC_DESC('role_id,role_name','tbl_roles',array('deleted'=>0),'role_name','ASC');
                                    if($role->num_rows() > 0) {
                                    foreach($role->result() as $dept) {
                                ?>
                                    <option value="<?php echo $dept->role_id;?>" <? if($dept->role_id == $old_role){ ?> selected <? } ?> ><?php echo $dept->role_name;?></option>
                                <?php } } ?>
                            </select>
                            <input type="hidden" name="old_role" value="<?= $old_role?>"/>
                        </div>
                    </div>
                    
                    <!--<div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtFirstNameBilling" class="col-sm-3 col-form-label">Password<i class="text-danger">*</i></label>
                            <div class="col-sm-9">
                                <input id="password" name="password" type="text" class="form-control"  value=""  placeholder="Enter Password">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtFirstNameBilling" class="col-sm-3 col-form-label">C. Pass <i class="text-danger">*</i></label>
                            <div class="col-sm-9">
                                <input id="Cpassword" name="Cpassword" type="text" class="form-control"  value="" placeholder="Confirm New Password">
                            </div>
                        </div>
                    </div>-->
                    <div class="col-md-4">
                         <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="checkbox checkbox-success form-check-inline" id="otpp_check"  style="margin-top: 40%;">
                                        <input type="checkbox" name="sendotp" class="admin_menu" value="1" <?= ($fld_send_otp ==  1)? 'checked':'';?>>
                                        <label class="">Send OTP</label>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="id" value="<?= $employee['id'];?>"/>
            				<div class="col-lg-8">
            					<button type="submit" class="btn btn-successs" id="bttnn_proceed" style="margin-top: 17%;">Proceed</button>
                        </div>
                    </div>
                    
				</div> 
				<div class="col-md-12">
                        <p style="color:red;">Note:You need to add employee first to assign Permanent user login.To add Employee , please click on <a href="https://zstar.mktechsol.com/Employees">https://zstar.mktechsol.com/Employees.</a><br>If Send OTP is checked then this login will need OTP (One Time Password) after login.</p>
                    </div>
				
				
				</div>
				</form>
				<hr>
			</div>
			</div> <!-- end card-body -->
		</div> <!-- end card -->                                       
	</div> <!-- end col -->


</div>
                    

                