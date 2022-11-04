<!-- <div id="main">
<div id="login">
<?php echo @$error; ?>
<h2>Change Password</h2>
<br>
<form method="post" action='<?=base_url();?>/Change_pass/change_pass'>
		<label>Old Password :</label>
		<input type="password" name="old_pass" id="name" placeholder="Old Pass"/><br /><br />
		<label>New Password :</label>
		<input type="password" name="new_pass" id="password" placeholder="New Password"/><br/><br />

		<label>Confirm Password :</label>
		<input type="password" name="confirm_pass" id="password" placeholder="Confirm Password"/><br/><br />
		<input type="submit" value="login" name="change_pass"/><br />
</form>
</div>
</div> -->
<h4>Change Password</h4>
                    <form class="form-login form-horizontal auth-form my-4" action="<?=base_url();?>Roles/changePasswordProcess" method="post">
                        <!--<fieldset>-->

                           <div class="col-lg-12" style="padding: 0px;">
            				<?php 
                				$error_message = $this->session->userdata('error_message');
                				if (isset($error_message)) {
            				?>
            					<div class="alert alert-danger">
            						<?php echo $error_message ?>                    
            					</div>
            				<?php
            					$this->session->unset_userdata('error_message');
            				}?>
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
                            <?php /*?><div class="form-group">
                                <label >Employees <i class="text-danger">*</i></label>
                                <!--<input id="full_name" name="full_name" type="text" class="form-control" value="" required="required" placeholder="Afzal">-->
                                <select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="emp_id" tabindex="1" id="employee"  required>
                                    <option selected="selected" value="">Showing All Employees</option>
        							<?php
        								if($employees){
        								foreach($employees as $emp){
        							?>
        							<option value="<?= $emp['fld_id'];?>" ><?= $emp['fld_username'];?></option>
        							<?php }} ?>
                                </select>
                            </div><?php */?><!--end form-group-->
                            <input type="hidden" name="emp_id" value="<?php echo $emp_id;?>"/>
                            <!--<div class="form-group">-->
                            <!--    <span toggle="#password-field" class="auth-form-icon fa fa-fw fa-eye fa-eye-slash field_icon toggle-password" title="Show Password"> </span>-->
                            <!--    <input type="password" class="form-control" value="" id="new_password" required name="new_password"  placeholder="New Password">-->
                            <!--</div>-->
                            <div class="form-group">
                                <label for="userpassword">Password</label>                                            
                                <div class="input-group mb-3"> 
                                    <span toggle="#password-field" class="auth-form-icon fa fa-fw fa-eye icon toggle-password" title="Show Password"> 
                                    </span>                                                       
                                    <input type="password" class="form-control" name="new_password" id="new_password" placeholder="Enter password" required>
                                </div>                               
                            </div><!--end form-group--> 
                            <!--<div class="form-group form-actions">-->
                            <!--    <span class="input-icon">-->
                            <!--        <input type="password" value="" class="form-control" id="password_again" required name="password_again" placeholder="New Password">-->
                            <!--    </span>-->
                            <!--</div>-->
                             <input type="hidden" name="fld_id" id="fld_id" value="<?=$this->session->userdata('user_id');?>" >
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">
                                    Submit <i class="fa fa-arrow-circle-right"></i>
                                </button>
                                
                            </div>
                            
                        <!--</fieldset>-->
                    </form>
                     