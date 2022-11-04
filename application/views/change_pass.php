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
<h4>Change Your Password</h4>
                    <form class="form-login" action="<?=base_url();?>Change_pass/pwdreset" method="post">
                        <fieldset>

                            <?php if($this->session->userdata('msg') != "") { ?>
                                        
                                    <p style="color:#900;" ><?php echo $this->session->userdata('msg'); ?></p>
                    
                            <?php 
                                $this->session->unset_userdata('msg');
                            } else { ?>
                                <p style="color:#fff;" >
                                    
                                </p>
                            <? } ?>
                            
                            <?php if($this->session->userdata('pass_changed') == 1){ ?>
                                <script>
                                setTimeout(function() {
                                 window.location.href="<?php echo base_url(); ?>Adminlogin/logout";     
                                }, 3000);
                                   
                                </script>
                            <?php } ?>
                            <div class="form-group">
                                <span class="input-icon">
                                    <input type="password" class="form-control" value="" id="new_password" name="new_password"  placeholder="New Password">
                                </span>
                            </div>
                            <!--<div class="form-group form-actions">-->
                            <!--    <span class="input-icon">-->
                            <!--        <input type="password" value="" class="form-control" id="password_again" name="password_again" placeholder="New Password">-->
                            <!--    </span>-->
                            <!--</div>-->
                             <input type="hidden" name="fld_id" id="fld_id" value="<?=$this->session->userdata('user_id');?>" >
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">
                                    Submit <i class="fa fa-arrow-circle-right"></i>
                                </button>
                                
                            </div>
                            
                        </fieldset>
                    </form>