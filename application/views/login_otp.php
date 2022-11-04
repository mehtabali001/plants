<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title><?php echo $this->title; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta content="MK TechSol Offers ERP, With the help of our business high-tech solution you can connect all departments and functions with a future-proof ERP system for resilience and operational excellence." name="description" />
        <meta content="" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <? $settings=$this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row_array();?>
        <link rel="shortcut icon" href="<?=base_url()?>/assets/uploads/logo/<?=$settings['favicon'];?>">
        <link href="<?= base_url()?>/assets/theme_elements/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url()?>/assets/theme_elements/css/jquery-ui.min.css" rel="stylesheet">
        <link href="<?= base_url()?>/assets/theme_elements/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url()?>/assets/theme_elements/css/app.min.css" rel="stylesheet" type="text/css" />
        <!-- App css -->
       
        <style>
         body {
    background-color: black;
  }
        
            .cta-btn {
                font-family: "Poppins", sans-serif;
                text-transform: uppercase;
                font-weight: 500;
                font-size: 16px;
                letter-spacing: 1px;
                display: inline-block;
                padding: 8px 30px;
                border-radius: 50px;
                transition: 0.5s;
                margin: 10px;
                border: 2px solid #fff;
                color: #fff;
            }
            .cta-btn:hover {
                    background: linear-gradient(
                90deg, rgba(35,93,74,1) 0%, rgba(74,111,130,0.9976365546218487) 100%);
                    border: 2px solid #2dc997;
                }
                
                .vh-1000 {
                    /*background-image: https://mktechsol.com/assets/img/banner-2.jpg;*/
                    background: url(https://mktechsol.com/assets/img/getaquote.jpg) top center;
                    background-repeat: no-repeat;
                    background-size: 100% 100%;
                    color:#fff;
                    min-height: 100vh;
                }
                .vh-1000:before {
                    content: "";
                    background: rgba(0, 0, 0, 0.8);
                    position: absolute;
                    bottom: 0;
                    top: 0;
                    left: 0;
                    right: 0;
                }
                @media only screen and (max-width: 600px) {
 
  .vh-1000{
      background-image:none;
  }
  .textcopyright{
                      display:none;
                  }
}

input[type="text"] {
	width: 1.4em;
	line-height: 1;
	margin: .1em;
	padding: 8px 0 4px;
	font-size: 2.65em;
	text-align: center;
	-moz-appearance: textfield;
	     appearance: textfield;
	-webkit-appearance: textfield;
	border: 2px solid #BBBBFF;
	color: purple;
	border-radius: 4px;
}

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

                    </style>

    </head>

    <body class="" style="font-size:.695rem;">
        <div class="container-fluid">
            <!-- Log In page -->
            <div class="row vh-1000">
                
                <div class="col-lg-9 col-sm-6 col-md-6 p-0  d-flex justify-content-center ">
                    <div class="accountbg d-flex align-items-center"> 
                        <div class="account-title text-center text-white" style="z-index: 10;">
                            <img src="<?= base_url()?>/assets/custom_elements/images/mklogo.png" alt="" class="" style="height:120px;">
                            <h4 class="mt-3 text-white">Welcome To <span class="" style="color: #1ecfd3 !important;">MK Techsol ERP</span> </h4>
                            <div class="border w-25 mx-auto border-warning" style="border-color: #1fcfc9 !important;"></div>
                            <h1 class="text-white">Are you looking for Perfect business solution?</h1>
                            <p class=" mt-3" style="font-size: 15px !important; padding-left: 4%;padding-right: 4%;">Our ERP can resolve it, By the help of our business high tech solution you can connect all departments and functions with a future-proof ERP system for resilience and operational excellence.</p>
                            <a class="cta-btn align-middle" href="https://mktechsol.com/main/contact_us" target="_blank">Get a Quote</a>
                        </div>
                        
                    </div>
                      <div class="mt-3 text-center textcopyright" style="position: absolute;bottom: 0px; color:#fff;">
                        &copy;<script>document.write(new Date().getFullYear())</script>&nbsp;<a href="https://mktechsol.com/" target="_blank" style="color:#fff;"><?=$settings['system_name'];?> </a>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-md-6 pr-0"style="background:#fff1;">
                    <div class="auth-page">
                        <div class="card mb-0 shadow-none h-100" style="background:#fff0;box-shadow: 5px 5px  5px 10px;">
                            <div class="card-body" style="z-index:20;">
            
                                <div class="">
                                        <span><img src="<?=base_url()?>/assets/uploads/logo/<?=$settings['system_logo'];?>" height="120" alt="logo" class="auth-logo"></span>
                                    </a>
            
                                <div class="px-3">
                                    <!--<h2 class="font-weight-semibold font-22 mb-2">Lets <span class="text-primary">Get Started</span>.</h2>-->
                                    <h4 class="text-muted">Session <?=$settings['financial_year'];?></h4>
                                     <p class="text-muted mb-0">Let's Get Started</p>  
                                     <?php 
                                        $success_message = $this->session->userdata('success_message');
                                        if (isset($success_message)) {
                                        ?>
                                            <div class="alert alert-success">
                                                <?php echo $success_message ?>                    
                                            </div>
                                        <?php
                                            $this->session->unset_userdata('success_message');
                                        }?>
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
										<p style="color:red;"><br>We've sent 4 digits verification code on<span> <?=$email;?> <?= (!empty($fld_mobile_number))? 'and on '.$fld_mobile_number.'':'';?></span></p>
                                    <ul class="nav-border nav nav-pills" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active font-weight-semibold" data-toggle="tab" href="#LogIn_Tab" role="tab">Please enter code below</a>
                                        </li>
                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div class="tab-pane active p-3" id="LogIn_Tab" role="tabpanel">                                        
                                            <!--<form class="form-horizontal auth-form my-4" action="index.html">-->
                                            <?php echo form_open('Adminlogin/do_verifylogin'); ?>
                                    <div id="form" style="text-align:center;">
                                        <input name="code[]" type="text" id="first" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}"  />
                                        <input name="code[]" type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" />
                                        <input name="code[]" type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" />
                                        <input name="code[]" type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" />
                                        <div class="form-group row mt-4">
                                                    <div class="col-sm-4">
                                                        <span id="countdown" style="color:red;display:none">0:00</span>
                                                    </div><!--end col--> 
                                                    <div class="col-sm-8 text-right">
                                                        <a href="<?= base_url();?>/Adminlogin/resendOTP?email=<?=$email;?>" id="btn" >Resend OTP ?</a>                                    
                                                    </div><!--end col--> 
                                                </div><!--end form-group--> 
                                        <button class="btn btn-gradient-primary btn-round btn-block waves-effect waves-light">Verify</button>
                                    </div>
									<?php echo form_close() ?>
                                            <!--end form-->
                                            
                                            
                                        </div>
                                       
                                    </div> 
                                </div>
                                
                                
                            </div>
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>

        


        <!-- jQuery  -->
        
        <script src="<?= base_url()?>/assets/theme_elements/js/jquery-ui.min.js"></script>
        <script src="<?= base_url()?>/assets/theme_elements/js/bootstrap.bundle.min.js"></script>
        <script src="<?= base_url()?>/assets/theme_elements/js/metismenu.min.js"></script>
        <script src="<?= base_url()?>/assets/theme_elements/js/waves.js"></script>
        <script src="<?= base_url()?>/assets/theme_elements/js/feather.min.js"></script>
        <script src="<?= base_url()?>/assets/theme_elements/js/jquery.slimscroll.min.js"></script>
        <script src="<?= base_url()?>/assets/theme_elements/plugins/apexcharts/apexcharts.min.js"></script> 
        <!-- App js -->
        <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>-->
        <script src="<?= base_url()?>/assets/theme_elements/js/jquery.min.js"></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.2.0/js/bootstrap.min.js'></script>
        <script src="<?= base_url()?>/assets/theme_elements/js/app.js"></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <script>
  	$(function() {
  'use strict';
  var body = $('body');
  function goToNextInput(e) {
    var key = e.which,
      t = $(e.target),
      sib = t.next('input');
    if (key != 9 && (key < 48 || key > 57) && (key < 96 || key > 105) || event.key === "Backspace") {
      e.preventDefault();
      return false;
    }
    if (key === 9) {
      return true;
    }
    if (!sib || !sib.length) {
      sib = body.find('input').eq(0);
    }
    sib.select().focus();
  }

  function onKeyDown(e) {
    var key = e.which;
    if (key === 9 || (key >= 48 && key <= 57) || (key >= 96 && key <= 105) || event.key === "Backspace") {
      return true;
    }
    e.preventDefault();
    return false;
  }
  function onFocus(e) {
    $(e.target).select();
  }
  body.on('keyup', 'input', goToNextInput);
  body.on('keydown', 'input', onKeyDown);
  body.on('click', 'input', onFocus);
})
var input = document.getElementById('first');
input.focus();
input.select();

 $(".alert").fadeTo(2000, 3000).slideUp(3000, function(){
    $(".alert").slideUp(3000);
});
  
  
//   counter
$( document ).ready(function() {
    $("#btn").css("pointer-events", "none");
    $("#btn").css("color", "#eeeeee1c ");
    $("#countdown").css("display", "block");
    
  startCountDown();
});

function startCountDown() {
  var minutes = 0,
    seconds = 60;
  $("#countdown").html(minutes + ":" + seconds);
  var count = setInterval(function() {
    if (parseInt(minutes) < 0 || parseInt(seconds) <=0 ) {
      $("#countdown").html(minutes + ":" + seconds);
      clearInterval(count);
       $("#btn").css("pointer-events", "auto");
    $("#btn").css("color", "#fff");
    } else {
      $("#countdown").html(minutes + ":" + seconds);
      seconds--;
      if (seconds < 10) seconds = "0" + seconds;
    }
  }, 1000);
}
</script>
    </body>

</html>