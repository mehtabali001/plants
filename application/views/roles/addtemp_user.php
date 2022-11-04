<style>
#datatable_filter > label
{
	float: right;
}
.pagination
{
	float: right;
}
.dataTables_empty
{
	text-align: center;
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
	height: 36px;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #bac1dc;
    line-height: 28px;
    padding-top: 2px;
}
.sorting_1 p{
    text-align:center;
}
.dataTables_empty{
    color:red;
}
.dataTables_filter{
    display:none;
}
.auth-form .form-control {
    border-radius: 4px;
}
.auth-form .auth-form-icon {
    background-color: #ffffff;
    text-align: center;
    line-height: 34px;
    position: absolute;
    right: 16px;
    z-index: 100;
    top: 30px;
    color: #9ba7ca;
}
</style>
<? $role_permissions  = explode(",",$this->session->userdata('permissions')); ?>
<div class="container-fluid">
<div class="row">
	<div class="col-sm-12" style="margin-bottom: 2%;">
		<div class="page-title-box">
				<div class="float-right">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <!--<a href="<?//= base_url();?>Roles/assign_roles" type="button" class="btn btn-outline-primary"><i class="fa fa-user-circle"></i>&nbsp;New Permanent User</a>-->
                  <!--<a href="<?//= base_url();?>Roles/assigned_roles" type="button" class="btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;View Permanent Users</a>-->
                  <a href="<?= base_url();?>Roles/add_tempuser" type="button" class="btn  btn-primary btn-large"><i class="fa fa-user-circle"></i>&nbsp;New Temp. User</a>
                  <a href="<?= base_url();?>Roles/manage_tempuser" type="button" class="btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;View Temp. Users</a>
                </div>
			</div>
			<!--<h4 class="page-title">Add Temporary User</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Role Management</a></li>-->
			<!--	<li class="breadcrumb-item active">Assigned Roles</li>-->
			<!--</ol>-->
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<!-- end page title end breadcrumb -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
				<form class="form-horizontal auth-form " method="post" action="<?= base_url('Roles/addTempUser');?>">
				<div class="row">
				<div class="col-lg-12" style="padding: 0px;">
				<?php 
    				$error_message = $this->session->userdata('error_message');
    				if (isset($error_message)) {
				?>
					<div class="alert alert-danger">
						<?php echo $error_message; ?>                    
					</div>
				<?php $this->session->unset_userdata('error_message'); } ?>
				<?php 
    				$success_message = $this->session->userdata('success_message');
    				if (isset($success_message)) {
				?>
					<div class="alert alert-success">
						<?php echo $success_message ?>                    
					</div>
			    <?php $this->session->unset_userdata('success_message'); } ?>
				</div>
				</div>
				<div class="row">
				    <div class="col-md-12">
				    <!--<h3>New Temporary User</h3>-->
				    <hr>
				    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label >Full Name <i class="text-danger">*</i></label>
                            <input id="full_name" name="full_name" type="text" class="form-control" value="" required="required" placeholder="Afzal">
                        </div><!--end form-group-->
                    </div>
					<div class="col-md-4">
                        <div class="form-group">
                            <label>Email <i class="text-danger">*</i></label>
                            <input id="email" name="email" type="email" class="form-control" value="" required>
                        </div>
                    </div>
                    <?php 
                        /*
                            $old_role = 0;
                            $user_d =	$this->db->query("SELECT * from tbl_users where emp_id = '{$employee['id']}'");
                            if($user_d->num_rows() > 0){
                                $user = $user_d->row();
                                $old_role = $user->fld_role;
                            } 
                        */ 
                    ?>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Assigned Role <i class="text-danger">*</i></label>
                            <select class="select2 form-control mb-3 custom-select" id="role" name="role" required>
                                <option value="" selected>--Select Roles--</option>
                                <?php $role	=	$this->Common_model->select_where_ASC_DESC('role_id,role_name','tbl_roles',array('deleted'=>0),'role_name','ASC');
                                    if($role->num_rows() > 0) {
                                    foreach($role->result() as $dept) {
                                ?>
                                    <option value="<?php echo $dept->role_id;?>"><?php echo $dept->role_name;?></option>
                                <?php } } ?>
                            </select>
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
                                    <option value="<?php echo $plant->fld_id;?>"><?php echo $plant->fld_location;?></option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Password<i class="text-danger">*</i></label>
                             <span toggle="#password-field" class="auth-form-icon fa fa-fw fa-eye icon toggle-password" title="Show Password"></span>                                                       
                            <input  name="password" type="password" id="new_password"  class="form-control" value="" placeholder="Enter Password" autocomplete="new-password" minlength="4" oninvalid="this.setCustomValidity('Password should be at-least 4 characters. ')" required>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Mobile Number <i class="text-danger">*</i></label>
                            <input id="mobilenumber" name="mobilenumber" type="text" class="form-control" value="" placeholder="Your Mobile Number" required>
                        </div>
                    </div>
                   
                    <div class="col-md-4">
                        <div class="row">
               <!--             <div class="col-md-4">-->
               <!--                 <div class="checkbox checkbox-success form-check-inline" id="otpp_check" style="margin-top: 40%;">-->
               <!--                     <input type="checkbox" name="sendotp" class="admin_menu" value="1">-->
               <!--                     <label for="admin_menu"> -->
        							<!--  Send OTP-->
        							<!--</label>-->
               <!--                 </div>-->
               <!--             </div>-->
                            <div class="col-md-6">
        						<button type="submit" id="bttnn_proceed" class="btn btn-successs" style="margin-top: 17%;">Proceed</button>
        				    </div>
        				</div>
        		    </div>
        		    <!--<div class="col-md-12">-->
              <!--          <p style="color:red;">Note : If Send OTP is checked then this login will need OTP (One Time Password) after login.</p>-->
              <!--      </div>-->
				</div> 
				<hr>
				</div>
				</form>	
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
</div>