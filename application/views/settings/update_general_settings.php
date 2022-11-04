<? $role_permissions  = explode(",",$this->session->userdata('permissions')); ?>
<div class="container-fluid">
<div class="row">
 <div class="col-sm-12" style="margin-bottom:2%;">
		<div class="page-title-box">
			<div class="float-right">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Settings/add" type="button" class="btn btn-outline-primary"><i class="fa fa-envelope"></i>&nbsp;+ Email Template</a>
                  <a href="<?= base_url();?>Settings/listing" type="button" class="btn  btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;View Templates</a>
                  <a href="<?= base_url();?>Settings/log_system" type="button" class="btn btn-outline-primary"><i class="fa fa fa-history"></i>&nbsp;System Logs</a>
                  <a href="<?= base_url();?>Settings/general_settings" type="button" class="btn btn-primary btn-large"><i class="fa fa-sliders"></i>&nbsp;General Settings</a>
                </div>
			</div>
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<form method="post" action="<?= base_url('Settings/update_general_settings');?>" enctype="multipart/form-data" >
				<div class="row">
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
				<?php $success_message = $this->session->userdata('success_message');
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
				<div class="col-lg-12">
				    <div class="row">
				        <div class="col-lg-6">
        					<div class="mt-3">
        						<label class="mb-2">System Name <i class="text-danger">*</i><i style="font-size:10px;">&nbsp;(It will be displayed on login page.)</i></label>
        						<input type="text" class="form-control" name="system_name" placeholder="e.g ERP System" id="system_name" required value="<?=$settings['system_name'];?>">
        					</div>
        				</div>
        				<div class="col-lg-6">
        					<div class="mt-3">
        						<label class="mb-2">System Version <i class="text-danger">*</i><i style="font-size:10px;">&nbsp;(It will be displayed on Dashboard page.)</i></label>
        						<input type="text" class="form-control" name="system_version" placeholder="e.g Current Beta Version is 0.0.7 (Last Updated 17/12/21) " id="system_version" required value="<?=$settings['system_version'];?>">
        					</div>
        				</div>
        				 <div class="col-lg-6">
        					<div class="mt-3">
        						<label class="mb-2">System Email <i class="text-danger">*</i><i style="font-size:10px;">&nbsp;(It will be used for all the emails sent by this ERP.)</i></label>
        						<input type="text" class="form-control" name="system_email" placeholder="noreply@mktechsol.com" id="system_email" required value="<?=$settings['system_email'];?>">
        					</div>
        				</div>
        				<div class="col-lg-6">
        					<div class="mt-3">
        						<label class="mb-2">Email Sender Name <i class="text-danger">*</i><i style="font-size:10px;">&nbsp;(It will be used for all the emails sent by this ERP.)</i></label>
        						<input type="text" class="form-control" name="email_sender_name" placeholder="ERP Kotal" id="system_email" required value="<?=$settings['email_sender_name'];?>">
        					</div>
        				</div>
        				<div class="col-lg-6">
        					<div class="mt-3">
        						<label class="mb-2">Bill From <i class="text-danger">*</i><i style="font-size:10px;">&nbsp;(It will be used for view purchase bill.)</i></label>
        						<input type="text" class="form-control" name="bill_from" placeholder="ERP Kotal" id="bill_from" required value="<?=$settings['bill_from'];?>">
        					</div>
        				</div>
        					<div class="col-lg-6">
        					<div class="mt-3">
        						<label class="mb-2">Financial Year<i class="text-danger">*</i><i style="font-size:10px;">&nbsp;(It will be displayed on login page.)</i></label>
        						<input type="text" class="form-control" name="financial_year" placeholder="20-21" id="system_email" required value="<?=$settings['financial_year'];?>">
        					</div>
        				</div>
        				<div class="col-lg-6">
        					<div class="mt-3">
        						<label class="mb-2">Logo <i class="text-danger">*</i><i style="font-size:10px;">&nbsp;(It will be displayed as a system logo.)</i></label>
        						<input type="file" name="system_logo" class="form-control" id="" >
									<? if(!empty($settings['system_logo'])) { ?>
									<br>	
									<img width="100" src="<?=base_url()?>/assets/uploads/logo/<?=$settings['system_logo'];?>" alt="N/A" >
									<? } ?>
        					</div>
        				</div>
        				<div class="col-lg-6">
        					<div class="mt-3">
        						<label class="mb-2">Favicon <i class="text-danger">*</i><i style="font-size:10px;">&nbsp;(It will be displayed before tab name.)</i></label>
        						<input type="file" name="favicon" class="form-control" id="" >
									<? if(!empty($settings['favicon'])) { ?>
									<br>	
									<img width="100" src="<?=base_url()?>/assets/uploads/logo/<?=$settings['favicon'];?>" alt="N/A" >
									<? } ?>
        					</div>
        				</div>
        			</div>
				</div> 
				<!--<input type="hidden" name="fld_refinery_id" value="<?= $refinery['fld_id'];?>" />-->
				<!--<input type="hidden" name="orignal_name" value="<?= $refinery['fld_name'];?>" />-->
				<div class="col-lg-12">
				    <? if(!empty($role_permissions) && in_array(269,$role_permissions)) { ?>
					<div class="mt-3">
						<label class="mb-2"></label>
						<button type="submit" class="btn btn-successs">Proceed</button>
					</div>
					<?}?>
				</div>
				</div>
				</form>
			</div>
			</div> <!-- end card-body -->
		</div> <!-- end card -->                                       
	</div> <!-- end col -->
</div>
</div><!-- container -->