
<style>
    .danger{
        color:red;
    }
    @media only screen and (max-width: 600px) {
      .btn-group {
        display:none;
      }
    }
</style>
<div class="container-fluid">
<div class="row">
	<div class="col-sm-12" style="margin-bottom:2%;">
		<div class="page-title-box">
			<div class="float-right">
			    <div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Settings/add" type="button" class="btn btn-outline-primary"><i class="fa fa-envelope"></i>&nbsp;+ Email Template</a>
                  <a href="<?= base_url();?>Settings/listing" type="button" class="btn  btn-primary btn-large"><i class="fa fa-eye"></i>&nbsp;View Templates</a>
                  <a href="<?= base_url();?>Settings/log_system" type="button" class="btn btn-outline-primary"><i class="fa fa fa-history"></i>&nbsp;System Logs</a>
                  <a href="<?= base_url();?>Settings/general_settings" type="button" class="btn btn-outline-primary"><i class="fa fa-sliders"></i>&nbsp;General Settings</a>
                </div>
		</div>
	</div><!--end col-->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<form method="post" action="<?= base_url('Settings/editEmailProcess');?>">
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
				<div class="col-lg-6">

					<div class="mt-3">
						<label class="mb-2">Template Name <span class="danger">*</span><i style="font-size:10px;">(It will be displayed as template name)</i></label>
						<input type="text" class="form-control"  name="fld_email" id="fld_email" value="<?= $email['fld_email'];?>" required placeholder="Welcome Email">
					</div>                                    
					                            
				</div>
				<div class="col-lg-6">
					

					<div class="mt-3">
                        <label class="mb-2">Subject <span class="danger">*</span><i style="font-size:10px;">(It will be displayed as Email Subject)</i></label>
						<input type="text" class="form-control"  name="fld_subject" id="fld_subject" value="<?= $email['fld_subject'];?>" required placeholder="Welcome to MK Techsol">
					</div>                                    
					                            
				</div> 
				<div class="col-lg-12" style="margin-top:10vh;">
				    <textarea id="elm1" name="fld_email_body"><?= $email['fld_email_body'];?></textarea>
				</div>
				<input type="hidden" name="fld_unit_id" value="<?= $email['fld_id'];?>"/>
				<input type="hidden" name="orignal_unit" value="<?= $email['fld_email'];?>"/>
				<input type="hidden" name="orignal_unit_1" value="<?= $email['fld_subject'];?>"/>
				
				<div class="col-lg-12">
					<div class="mt-3">
						<label class="mb-2"></label>
						<button type="submit" class="btn btn-successs">Proceed</button>
					</div>
				</div>
				
				</div>
				</form>
			</div>
			</div> <!-- end card-body -->
		</div> <!-- end card -->                                       
	</div> <!-- end col -->


                    

</div><!-- container -->

                