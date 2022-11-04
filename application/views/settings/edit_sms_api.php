<style>
    .danger{
        color:red;
    }
</style>
<div class="container-fluid">
<div class="row">
		<div class="col-sm-12" style="margin-bottom:2%;">
		<div class="page-title-box">
			<div class="float-right">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Settings/sms_api_settings" type="button" class="btn  btn-outline-primary"><i class="fa fa-commenting"></i>&nbsp;+ SMS Api Template</a>
                  <a href="<?= base_url();?>Settings/view_sms_api_settings" type="button" class="btn btn-primary btn-large"><i class="fa fa-eye"></i>&nbsp;View SMS Templates</a>
                  <a href="<?= base_url();?>Settings/add" type="button" class="btn btn-outline-primary"><i class="fas fa-envelope"></i>&nbsp;+ Email Template</a>
                  <a href="<?= base_url();?>Settings/listing" type="button" class="btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;View Templates</a>
                </div>
			</div>
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<form method="post" action="<?= base_url('Settings/edit_sms_apiProcess');?>">
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
							<label class="mb-2">Title <span class="danger">*</span><i style="font-size:10px;">(It will be displayed as template name)</i></label>
						
						<input type="text" class="form-control"  name="fld_login_id" id="fld_login_id" value="<?= $sms_api['fld_login_id'];?>" required>
					</div>                                    
					                            
				</div>
				<!--<div class="col-lg-6">-->
					

				<!--	<div class="mt-3">-->
				<!--		<label class="mb-2">Login Password *</label>-->
						
				<!--		<input type="password" class="form-control"  name="fld_login_pass" id="fld_login_pass" value="<?//= $sms_api['fld_login_pass'];?>" required>-->
				<!--	</div>                                    -->
					                            
				<!--</div> -->
				<!--<div class="col-lg-6">-->
					

				<!--	<div class="mt-3">-->
				<!--		<label class="mb-2">Mask (Title) *</label>-->
						
				<!--		<input type="text" class="form-control"  name="fld_mask" id="fld_mask" value="<?//= $sms_api['fld_mask'];?>" required>-->
				<!--	</div>                                    -->
					                            
				<!--</div> -->
				<div class="col-lg-6">
					

					<div class="mt-3">
						<label class="mb-2">Status <span class="danger">*</span></label>
						
						<select class="select2 form-control mb-3 custom-select" name="fld_status">
                            <option value="1" <? if($sms_api['fld_status'] == 1){ ?> selected <? } ?>>Active</option>
                            <option value="2" <? if($sms_api['fld_status'] == 2){ ?> selected <? } ?>>In Active</option>
                        </select>
					</div>                                    
					                            
				</div> 
				<div class="col-lg-12" style="margin-top:3vh;">
				    <textarea id="elm1" name="fld_message_body"><?= $sms_api['fld_message_body'];?></textarea>
				</div>
				<input type="hidden" name="fld_unit_id" value="<?= $sms_api['fld_id'];?>"/>
				
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


</div>
                    

</div><!-- container -->

                