<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>New Password</title>
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
        <link href="<?= base_url()?>/assets/theme_elements/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url()?>/assets/theme_elements/css/jquery-ui.min.css" rel="stylesheet">
        <link href="<?= base_url()?>/assets/theme_elements/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!--<link href="<?= base_url()?>/assets/theme_elements/css/metisMenu.min.css" rel="stylesheet" type="text/css" />-->
        <link href="<?= base_url()?>/assets/theme_elements/css/app.min.css" rel="stylesheet" type="text/css" />
        <style>
         :root {
	--color-default: grey;
	--color-invalid: red;
	--color-valid: green;
}

input {
	border: 2px solid var(--color-default);
	/*text-align: center;*/
}

.error {
	display: none;
	font-weight: bold;
	font-size:12px;
	color: var(--color-invalid);
}

/* To demonstrate that the validations only happen on blur, we apply this malpractice */
input:focus {
	outline: none;
}

/* Only show invalid ring while not focused */
input:not(:focus):invalid {
	border-color: var(--color-invalid);
}
input:not(:focus):invalid ~ .error {
	display: block;	
}
/* Non demo-related styles */
* {
	box-sizing: border-box;
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
  body {
    background-color: black;
  }
  .vh-1000{
      background-image:none;
  }
}
.textcopyright{
      display:none;
  }
                    </style>

    </head>

    <body class="" style="font-size:.695rem;">
        <div class="container-fluid">
            <!-- Log In page -->
            <div class="row vh-1000">
                
                <div class="col-lg-9 col-sm-6 col-md-6 p-0 h-100vh d-flex justify-content-center ">
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
                                        }?>

                                    <ul class="nav-border nav nav-pills" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active font-weight-semibold" data-toggle="tab" href="#LogIn_Tab" role="tab" >Change Password</a>
                                        </li>
                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div class="tab-pane active p-3" id="LogIn_Tab" role="tabpanel">                                        
                                            <!--<form class="form-horizontal auth-form my-4" action="index.html">-->
                                            <?php echo form_open('Adminlogin/update_pass', array('id' => 'update_pass','class'=>'form-horizontal auth-form my-4')) ?>
                                                <div class="form-group">
                                                    <label for="username">New Password</label>
                                                    <div class="input-group mb-3">
                                                        <span toggle="#password-field_new" class="auth-form-icon fa fa-fw fa-eye fa-eye-slash field_icon toggle-password-new" title="Show Password"> 
                                                        </span>                                                                                                              
                                                        <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Enter new Password" required minlength="4" autofocus>
                                                        <span class="error">Password should be at-least 4 characters.</span>
                                                    </div>                                    
                                                </div><!--end form-group--> 
                                                
                    
                                                <!--<div class="form-group">-->
                                                <!--    <label for="userpassword">Confirm Password</label>                                            -->
                                                <!--    <div class="input-group mb-3"> -->
                                                <!--        <span toggle="#password-field_confirm" class="auth-form-icon fa fa-fw fa-eye fa-eye-slash field_icon toggle-password-again" title="Show Password"> -->
                                                <!--        </span>                                                       -->
                                                <!--        <input type="password" value="" class="form-control" id="password_again" name="password_again" placeholder="Re-enter Password" required>-->
                                                <!--    </div>                               -->
                                                <!--</div>-->
                                                <!--end form-group--> 
                                                <input type="hidden" name="fld_id" id="fld_id" value="<?=$this->uri->segment(3)?>" >
                                                <div class="form-group row mt-4">
                                                    <div class="col-sm-4">
                                                    </div><!--end col--> 
                                                    <div class="col-sm-8 text-right">
                                                        <a href="<?= base_url('Adminlogin');?>" class="text-muted font-13">Remember It ? Sign in here.</a>                                    
                                                    </div><!--end col--> 
                                                </div><!--end form-group--> 
                    
                                                <div class="form-group mb-0 row">
                                                    <div class="col-12 mt-2">
                                                        <button class="btn btn-primary btn-round btn-block waves-effect waves-light login_in" disabled style="box-shadow: none;" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Please Wait..." >Proceed <i class="fas fa-sign-in-alt ml-1" ></i></button>
                                                    </div><!--end col--> 
                                                </div> <!--end form-group-->                           
                                            <!--</form>-->
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
        <script>
            $(document).on('click', '.toggle-password-new', function() {

    $(this).toggleClass("fa-eye ");
    
    var input = $("#new_password");
    input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
});
//       $(document).on('click', '.toggle-password-again', function() {

//     $(this).toggleClass("fa-eye ");
    
//     var input = $("#password_again");
//     input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
// });
    $(".alert").fadeTo(2000, 3000).slideUp(3000, function(){
    $(".alert").slideUp(3000);
});
</script>
<script>
    $(document).ready(function() {
        var minLength = 4;
     $('.login_in').prop('disabled', true);
     $('#new_password').keyup(function() {
        if($(this).val() != '' && $(this).val().length >= minLength) {
            
          $('.login_in').prop('disabled', false);
        }else if($(this).val() == '' || $(this).val().length < minLength) {
          $('.login_in').prop('disabled', true);
        }
     });
 });
</script>
<script>
$('.login_in').on('click', function() {
    var $this = $(this);
  $this.button('loading');
    setTimeout(function() {
       $this.button('reset');
   }, 8000);
});
</script>

    </body>

</html>