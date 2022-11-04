<style>
@import url("https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css");
    select {
  font-family: 'FontAwesome', 'sans-serif';
}
</style>
<? $role_permissions  = explode(",",$this->session->userdata('permissions')); ?>
<link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css'>
<div class="container-fluid">
<div class="row">
 <div class="col-sm-12" style="margin-bottom:2%;">
		<div class="page-title-box">
			<div class="float-right">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Settings/add" type="button" class="btn btn-outline-primary"><i class="fa fa-envelope"></i>&nbsp;+ Email Template</a>
                  <a href="<?= base_url();?>Settings/listing" type="button" class="btn  btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;View Templates</a>
                  <a href="<?= base_url();?>Settings/general_settings" type="button" class="btn btn-outline-primary"><i class="fa fa fa-history"></i>&nbsp;General Settings</a>
                  <a href="<?= base_url();?>Settings/dashboard_quicklinks" type="button" class="btn btn-primary btn-large"><i class="fa fa-sliders"></i>&nbsp;Quick Links</a>
                </div>
			</div>
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<form method="post" action="<?= base_url('Settings/update_dashboard_quicklinks');?>" enctype="multipart/form-data" >
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
				        <div class="col-lg-4">
        					<div class="mt-3">
        						<label class="mb-2">Link Name # 1 <i class="text-danger">*</i></label>
        						<input type="text" class="form-control" name="name_1" placeholder="Journal Voucher"  id="name_1" required value="<?=$settings['name_1'];?>">
        					</div>
        				</div>
        				<div class="col-lg-4">
        					<div class="mt-3">
        						<label class="mb-2">Link Url # 1 <i class="text-danger">*</i></label>
        						<input type="text" class="form-control" name="url_1" placeholder="e.g ERP System" id="url_1" required value="<?=$settings['url_1'];?>">
        					</div>
        				</div>
        				<div class="col-lg-4">
        					<div class="mt-3">
        						<label class="mb-2">Link Icon # 1 <i class="text-danger">*</i></label>
        						<select class="select2 form-control mb-3 custom-select" name="icon_1"  required tabindex="">
        						     <!--<option value="">Select Icon</option>-->
                                   <option value="add" <? if($settings['icon_1']=='add'){?> selected <?}?> >Add icon</option>
                                   <option value="eye" <? if($settings['icon_1']=='eye'){?> selected <?}?> >Eye icon</option>
                                </select>
        					</div>
        				</div>
        				<div class="col-lg-4">
        					<div class="mt-3">
        						<label class="mb-2">Link Name # 2 <i class="text-danger">*</i></label>
        						<input type="text" class="form-control" name="name_2" placeholder="Journal Voucher"  id="name_2" required value="<?=$settings['name_2'];?>">
        					</div>
        				</div>
        				<div class="col-lg-4">
        					<div class="mt-3">
        						<label class="mb-2">Link Url # 2 <i class="text-danger">*</i></label>
        						<input type="text" class="form-control" name="url_2" placeholder="https://dev-zstar.mktechsol.com/home" id="url_2" required value="<?=$settings['url_2'];?>">
        					</div>
        				</div>
        				<div class="col-lg-4">
        					<div class="mt-3">
        						<label class="mb-2">Link Icon # 2 <i class="text-danger">*</i></label>
        						<select class="select2 form-control mb-3 custom-select" name="icon_2"  required tabindex="">
        						     <!--<option value="">Select Icon</option>-->
                                   <option  value="add" <? if($settings['icon_2']=='add'){?> selected <?}?> >Add icon</option>
                                   <option value="eye" <? if($settings['icon_2']=='eye'){?> selected <?}?> if>Eye icon</option>
                                </select>
        					</div>
        				</div>
        				<div class="col-lg-4">
        					<div class="mt-3">
        						<label class="mb-2">Link Name # 3 <i class="text-danger">*</i></label>
        						<input type="text" class="form-control" name="name_3" placeholder="Journal Voucher" id="name_3" required value="<?=$settings['name_3'];?>">
        					</div>
        				</div>
        				<div class="col-lg-4">
        					<div class="mt-3">
        						<label class="mb-2">Link Url # 3 <i class="text-danger">*</i></label>
        						<input type="text" class="form-control" name="url_3" placeholder="https://dev-zstar.mktechsol.com/home" id="url_3" required value="<?=$settings['url_3'];?>">
        					</div>
        				</div>
        				<div class="col-lg-4">
        					<div class="mt-3">
        						<label class="mb-2">Link Icon # 3 <i class="text-danger">*</i></label>
        						<select class="select2 form-control mb-3 custom-select" name="icon_3"  required tabindex="">
        						    <!--<option value="">Select Icon</option>-->
                                   <option value="add" <? if($settings['icon_3']=='add'){?> selected <?}?> >Add icon</option>
                                   <option value="eye" <? if($settings['icon_3']=='eye'){?> selected <?}?> if>Eye icon</option>
                                </select>
        					</div>
        				</div>
        				<div class="col-lg-4">
        					<div class="mt-3">
        						<label class="mb-2">Link Name # 4 <i class="text-danger">*</i></label>
        						<input type="text" class="form-control" name="name_4" placeholder="Journal Voucher"  id="name_4" required value="<?=$settings['name_4'];?>">
        					</div>
        				</div>
        				<div class="col-lg-4">
        					<div class="mt-3">
        						<label class="mb-2">Link Url # 4 <i class="text-danger">*</i></label>
        						<input type="text" class="form-control" name="url_4" placeholder="https://dev-zstar.mktechsol.com/home" id="url_4" required value="<?=$settings['url_4'];?>">
        					</div>
        				</div>
        				<div class="col-lg-4">
        					<div class="mt-3">
        						<label class="mb-2">Link Icon # 4 <i class="text-danger">*</i></label>
        						<select class="select2 form-control mb-3 custom-select" name="icon_4"  required tabindex="">
        						     <!--<option value="">Select Icon</option>-->
                                   <option value="add" <? if($settings['icon_4']=='add'){?> selected <?}?> >Add icon</option>
                                   <option value="eye" <? if($settings['icon_4']=='eye'){?> selected <?}?> if>Eye icon</option>
                                </select>
        					</div>
        				</div>
        				<div class="col-lg-4">
        					<div class="mt-3">
        						<label class="mb-2">Link Name # 5 <i class="text-danger">*</i></label>
        						<input type="text" class="form-control" name="name_5" placeholder="Journal Voucher" id="name_5" required value="<?=$settings['name_5'];?>">
        					</div>
        				</div>
        				<div class="col-lg-4">
        					<div class="mt-3">
        						<label class="mb-2">Link Url # 5 <i class="text-danger">*</i></label>
        						<input type="text" class="form-control" name="url_5" placeholder="https://dev-zstar.mktechsol.com/home" id="url_5" required value="<?=$settings['url_5'];?>">
        					</div>
        				</div>
        				<div class="col-lg-4">
        					<div class="mt-3">
        						<label class="mb-2">Link Icon # 5 <i class="text-danger">*</i></label>
        						<select class="select2 form-control mb-3 custom-select" name="icon_5"  required tabindex="">
        						     <!--<option value="">Select Icon</option>-->
                                   <option value="add" <? if($settings['icon_5']=='add'){?> selected <?}?> >Add icon</option>
                                   <option value="eye" <? if($settings['icon_5']=='eye'){?> selected <?}?> if>Eye icon</option>
                                </select>
        					</div>
        				</div>
        				<div class="col-lg-4">
        					<div class="mt-3">
        						<label class="mb-2">Link Name # 6 <i class="text-danger">*</i></label>
        						<input type="text" class="form-control" name="name_6" placeholder="Journal Voucher"  id="name_6" required value="<?=$settings['name_6'];?>">
        					</div>
        				</div>
        				<div class="col-lg-4">
        					<div class="mt-3">
        						<label class="mb-2">Link Url # 6 <i class="text-danger">*</i></label>
        						<input type="text" class="form-control" name="url_6" placeholder="https://dev-zstar.mktechsol.com/home" id="url_6" required value="<?=$settings['url_6'];?>">
        					</div>
        				</div>
        				<div class="col-lg-4">
        					<div class="mt-3">
        						<label class="mb-2">Link Icon # 6 <i class="text-danger">*</i></label>
        						<select class="select2 form-control mb-3 custom-select" name="icon_6"  required tabindex="">
        						     <!--<option value="">Select Icon</option>-->
                                   <option value="add" <? if($settings['icon_6']=='add'){?> selected <?}?> >Add icon</option>
                                   <option value="eye" <? if($settings['icon_6']=='eye'){?> selected <?}?> if>Eye icon</option>
                                </select>
        					</div>
        				</div>
        				<div class="col-lg-4">
        					<div class="mt-3">
        						<label class="mb-2">Link Name # 7 <i class="text-danger">*</i></label>
        						<input type="text" class="form-control" name="name_7" placeholder="Journal Voucher"  id="name_7" required value="<?=$settings['name_7'];?>">
        					</div>
        				</div>
        				<div class="col-lg-4">
        					<div class="mt-3">
        						<label class="mb-2">Link Url # 7 <i class="text-danger">*</i></label>
        						<input type="text" class="form-control" name="url_7" placeholder="https://dev-zstar.mktechsol.com/home" id="url_7" required value="<?=$settings['url_7'];?>">
        					</div>
        				</div>
        				<div class="col-lg-4">
        					<div class="mt-3">
        						<label class="mb-2">Link Icon # 7 <i class="text-danger">*</i></label>
        						<select class="select2 form-control mb-3 custom-select" name="icon_7"  required tabindex="">
        						    <!--<option value="">Select Icon</option>-->
                                   <option value="add" <? if($settings['icon_7']=='add'){?> selected <?}?> >Add icon</option>
                                   <option value="eye" <? if($settings['icon_7']=='eye'){?> selected <?}?> if>Eye icon</option>
                                </select>
        					</div>
        				</div>
        				<div class="col-lg-4">
        					<div class="mt-3">
        						<label class="mb-2">Link Name # 8 <i class="text-danger">*</i></label>
        						<input type="text" class="form-control" name="name_8" placeholder="Journal Voucher"  id="name_8" required value="<?=$settings['name_8'];?>">
        					</div>
        				</div>
        				<div class="col-lg-4">
        					<div class="mt-3">
        						<label class="mb-2">Link Url # 8 <i class="text-danger">*</i></label>
        						<input type="text" class="form-control" name="url_8" placeholder="https://dev-zstar.mktechsol.com/home" id="url_8" required value="<?=$settings['url_8'];?>">
        					</div>
        				</div>
        				<div class="col-lg-4">
        					<div class="mt-3">
        						<label class="mb-2">Link Icon # 8 <i class="text-danger">*</i></label>
        						<select class="select2 form-control mb-3 custom-select" name="icon_8"  required tabindex="">
        						    <!--<option value="">Select Icon</option>-->
                                   <option  value="add" <? if($settings['icon_8']=='add'){?> selected <?}?> >Add icon</option>
                                   <option value="eye" <? if($settings['icon_8']=='eye'){?> selected <?}?> if>Eye icon</option>
                                </select>
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
