<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?php echo $this->title; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
       <? $settings=$this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row_array();?>
        <link rel="shortcut icon" href="<?=base_url()?>/assets/uploads/logo/<?=$settings['system_logo'];?>">
        <!-- App css -->
        <link href="<?= base_url()?>/assets/theme_elements/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url()?>/assets/theme_elements/css/jquery-ui.min.css" rel="stylesheet">
        <link href="<?= base_url()?>/assets/theme_elements/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url()?>/assets/theme_elements/css/app.min.css" rel="stylesheet" type="text/css" />
    </head>
<style>
.accountbg{
    background: linear-gradient( 
90deg, rgba(35,93,74,1) 0%, rgba(74,111,130,0.9976365546218487) 100%)!important;
}
.align-self-center{
padding-top: 50px;
}
/*new css*/
.account-body.accountbg {
    background: #edf0f5;
    width: 100%;
    height: 100vh;
}
.card {
    background-color: #fff;
    color:#000;
    /*border: 1px solid #4a65d3;*/
    box-shadow: 0px 2px 4px rgb(31 30 47 / 10%);
}
.account-body .auth-card .auth-logo-text h4 {
    font-weight: 600;
    color: #000;
    font-size: 22px;
}
.text-muted {
    color: #000 !important;
}
label {
    font-weight: 400;
    color: #000;
    font-size: 13px;
}
.auth-form .auth-form-icon {
    width: 32px;
    height: 32px;
    background-color: #edf0f5;
    text-align: center;
    line-height: 34px;
    border-radius: 50%;
    position: absolute;
    right: 3px;
    z-index: 100;
    top: 3px;
    color: #000;
}
.btn {
    -webkit-transition: .3s ease-out;
    transition: .3s ease-out;
     -webkit-box-shadow: none !important; 
     box-shadow: none !important;
}
.account-body .auth-card .auth-logo-box .auth-logo {
    border-radius: 1rem;
    background-color: #fff;
    padding: 4px;
    height: 50px;
     box-shadow: 0px 2px 4px rgb(31 30 47 / 10%);
}
p a:hover{
    color: #4d69db !important;
}
.card-body {
    padding-bottom: 0;
}
.form-control {
    color: #d6d7e5;
    
}


/*popup css*/
.box {
  width: 40%;
  margin: 0 auto;
  background: rgba(255,255,255,0.2);
  padding: 35px;
  border: 2px solid #fff;
  border-radius: 20px/50px;
  background-clip: padding-box;
  text-align: center;
}



.overlay {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background: rgba(0, 0, 0, 0.7);
  transition: opacity 500ms;
  visibility: hidden;
  opacity: 0;
}
.overlay:target {
  visibility: visible;
  opacity: 1;
      z-index: 100;
}

.popup {
  margin: 72px auto;
  padding: 20px;
  background: #fff;
  border-radius: 5px;
  width: 30%;
  position: relative;
  transition: all 5s ease-in-out;
}

.popup h2 {
  margin-top: 0;
  color: #333;
  font-family: Tahoma, Arial, sans-serif;
}
.close {
  position: absolute;
  top: 10px;
  right: 30px;
  transition: all 200ms;
  font-size: 30px;
  font-weight: bold;
  text-decoration: none;
  color: #fff;
}
.close:hover {
  color: #06D85F;
}
.popup .content {
  max-height: 30%;
  overflow: auto;
}

@media screen and (max-width: 700px){
  .box{
    width: 70%;
  }
  .popup{
    width: 70%;
  }
}
#wrapper {
  font-family: Lato;
  font-size: 1rem;
  text-align: center;
  box-sizing: border-box;
  color: #fff;
}
#wrapper #dialog {
  /*border: solid 1px #ccc;*/
  margin: 10px auto;
  padding: 20px 30px;
  display: inline-block;
  /*box-shadow: 0 0 4px #ccc;*/
  /*background-color: #FAF8F8;*/
  overflow: hidden;
  position: relative;
  max-width: 450px;
}
#wrapper h3 {
  margin: 0 0 10px;
  padding: 0;
  line-height: 1.25;
  font-size:1.3rem;
  color:#fff;
}

#wrapper #form {
  max-width: 270px;
  margin: 25px auto 0;
}
#wrapper  #form input {
  margin: 0 5px;
  text-align: center;
  line-height: 80px;
  font-size: 50px;
  border: solid 1px #ccc;
  box-shadow: 0 0 5px #ccc inset;
  outline: none;
  width: 20%;
  transition: all 0.2s ease-in-out;
  border-radius: 3px;
}
#wrapper  #form input:focus {
  /*border-color: purple;*/
  /*box-shadow: 0 0 5px purple inset;*/
}
#wrapper #form input::-moz-selection {
  background: transparent;
}
#wrapper #form input::selection {
  background: transparent;
}
#wrapper #form button {
  margin: 30px 0 50px;
  width: 100%;
  padding: 6px;
  background-color: #B85FC6;
  border: none;
  text-transform: uppercase;
}
#wrapper button.close {
  border: solid 2px;
  border-radius: 30px;
  line-height: 19px;
  font-size: 120%;
  width: 22px;
  position: absolute;
  right: 5px;
  top: 5px;
}
#wrapper div {
  position: relative;
  z-index: 10000000;
}

</style>
    <body class="account-body accountbg">

        <!-- Log In page -->
        <div class="container">
            <div class="row vh-100 ">
                <div class="col-12 align-self-center">
                    <div class="auth-page">
                        <div class="card auth-card shadow-lg">
                            <div class="card-body">
                                <div class="px-3">
                                    <div class="auth-logo-box">
                                        <a href="javascript:;" class="logo logo-admin"><img src="<?=base_url()?>/assets/uploads/logo/<?=$settings['system_logo'];?>" height="70" alt="logo" class="auth-logo"></a>
                                    </div><!--end auth-logo-box-->
                                    
                                    <div class="text-center auth-logo-text">
                                        <h4 class="mt-0 mb-3 mt-5">Let's Get Started ERP</h4>
                                        <h4 class="mt-0 mb-3">FY 21-22</h4>
                                        <p class="text-muted mb-0">Sign in to continue to ERP.</p>  
										<?php $error_message = $this->session->userdata('error_message');
										if (isset($error_message)) {
											?>
											<div class="alert alert-danger alert-dismissable">
												
												<?php echo $error_message ?>                    
											</div>
											<?php
											$this->session->unset_userdata('error_message');
										}?>
										<?php
										if (isset($err)) {
										?>
										<div class="alert alert-danger alert-dismissable">
										<?php echo $err; ?>                    
										</div>
										<?php } ?>
                                    </div> <!--end auth-logo-text-->  
    
                                    
                                    <!--<form class="form-horizontal auth-form my-4" action="index.html">-->
									 <?php echo form_open('Adminlogin/do_login', array('id' => 'login','class'=>'form-horizontal auth-form my-4')) ?>
                                        <div class="form-group">
                                            <label for="username">Email / Username</label>
                                            <div class="input-group mb-3">
                                                <span class="auth-form-icon">
                                                    <i class="dripicons-user"></i> 
                                                </span>                                                                                                              
                                                <input type="text" name="username" class="form-control" id="username" placeholder="Enter email / username" >
                                            </div>                                    
                                        </div><!--end form-group--> 
            
                                        <div class="form-group">
                                            <label for="userpassword">Password</label>                                            
                                            <div class="input-group mb-3"> 
                                                <span class="auth-form-icon">
                                                    <i class="dripicons-lock"></i> 
                                                </span>                                                       
                                                <input type="password" name="password" class="form-control" id="userpassword" placeholder="Enter password">
                                            </div>                               
                                        </div><!--end form-group--> 
            
                                        <div class="form-group row mt-4">
                                            <div class="col-sm-6">
                                                <!--<div class="custom-control custom-switch switch-success">
                                                    <input type="checkbox" class="custom-control-input" id="customSwitchSuccess">
                                                    <label class="custom-control-label text-muted" for="customSwitchSuccess">Remember me</label>
                                                </div>
                                                <a class="text-muted font-13" href="#popup1">Send OTP</a>-->
                                            </div><!--end col-->
                                            
                                            <div class="col-sm-6 text-right">
                                                
                                                <a href="<?= base_url('Adminlogin/forgotpass');?>" class="text-muted font-13"><i class="dripicons-lock"></i> Forgot password?</a>                                    
                                            </div><!--end col--> 
                                        </div><!--end form-group--> 
            
                                        <div class="form-group mb-0 row">
                                            <div class="col-12 mt-2">
                                                <button class="btn btn-gradient-primary btn-round btn-block waves-effect waves-light" >Log In <i class="fas fa-sign-in-alt ml-1"></i></button>
                                            </div><!--end col--> 
                                        </div> <!--end form-group--> 
										<?php echo form_close() ?>										
                                    <!--</form>--><!--end form-->
                                    <p style="text-align:center; margin-bottom:0px !important;">&copy; <script>document.write(new Date().getFullYear())</script> <a href="https://fast-techsolution.com/" target="_blank" style="color:#000;">MK Technology Private Limited </a>. All rights reserved.</p>
                                </div><!--end /div-->
                                
                                
                            </div><!--end card-body-->
                        </div><!--end card-->
                       
                    </div><!--end auth-page-->
                </div><!--end col-->           
            </div><!--end row-->
        </div><!--end container-->
        <!-- End Log In page -->

<!--        <div id="popup1" class="overlay">-->

<!--		<div class="auth-page" style="margin-top: 7%;">-->
<!--                        <div class="card auth-card shadow-lg">-->
<!--                            <div class="card-body" id="wrapper" style="height:490px;">-->
<!--                                <a  class="close" href="#">&times;</a>-->
<!--                                <div class="px-3" style="margin: 5%;">-->
<!--                                    <div class="auth-logo-box" style="top: -63px;">-->
<!--                                        <a href="javascript:;" class="logo logo-admin"><img src="<?= base_url();?>/assets/theme_elements/images/logo-sm.png" height="55" alt="logo" class="auth-logo"></a>-->
<!--                                    </div><!--end auth-logo-box-->-->
<!--                                    <h3>We've sent 4 digits verification code to the email <span style="font-weight: bold;font-size:1.5rem;"> "atta@gmail.com".</span> Please enter code below</h3>-->
<!--                                    <div id="form">-->
<!--                                        <input type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" />-->
<!--                                        <input type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" />-->
<!--                                        <input type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" />-->
<!--                                        <input type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" />-->
<!--                                        <button class="btn btn-gradient-primary btn-round btn-block waves-effect waves-light" style="margin: 45px 0 50px;">Verify</button-->
<!--                                    </div>-->
<!--                                    <p style="text-align:center; margin-bottom:0px !important; color:#fff;">&copy; <script>document.write(new Date().getFullYear())</script> <a href="https://fast-techsolution.com/" target="_blank" style="color:white;">Fast Tech Solution</a>. All rights reserved.</p>-->
<!--                                </div><!--end /div-->-->
                                
                                
<!--                            </div><!--end card-body-->-->
<!--                        </div><!--end card-->-->
                       
<!--                    </div><!--end auth-page-->-->
<!--</div>-->


        <!-- jQuery  -->
         <!--<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>-->
//         <script>
//   	$(function() {
//   'use strict';

//   var body = $('body');

//   function goToNextInput(e) {
//     var key = e.which,
//       t = $(e.target),
//       sib = t.next('input');

//     if (key != 9 && (key < 48 || key > 57)) {
//       e.preventDefault();
//       return false;
//     }

//     if (key === 9) {
//       return true;
//     }

//     if (!sib || !sib.length) {
//       sib = body.find('input').eq(0);
//     }
//     sib.select().focus();
//   }

//   function onKeyDown(e) {
//     var key = e.which;

//     if (key === 9 || (key >= 48 && key <= 57)) {
//       return true;
//     }

//     e.preventDefault();
//     return false;
//   }
  
//   function onFocus(e) {
//     $(e.target).select();
//   }

//   body.on('keyup', 'input', goToNextInput);
//   body.on('keydown', 'input', onKeyDown);
//   body.on('click', 'input', onFocus);

// })
//   </script>
    </body>

</html>