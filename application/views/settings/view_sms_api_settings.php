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
</style>
<? $role_permissions  = explode(",",$this->session->userdata('permissions')); ?>
<div class="container-fluid">
<div class="row">
<div class="col-sm-12"  style="margin-bottom:2%;">
		<div class="page-title-box">
			<div class="float-right">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Settings/sms_api_settings" type="button" class="btn btn-outline-primary"><i class="fas fa-envelope"></i>&nbsp;+ SMS Api Template</a>
                  <a href="<?= base_url();?>Settings/view_sms_api_settings" type="button" class="btn btn-primary btn-large"><i class="fa fa-eye"></i>&nbsp;View SMS Templates</a>
                  <a href="<?= base_url();?>Settings/add" type="button" class="btn btn-outline-primary"><i class="fa fa-shopping-cart"></i>&nbsp;+ Email Template</a>
                  <a href="<?= base_url();?>Settings/listing" type="button" class="btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;View Templates</a>
                </div>
			</div>
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<!-- end page title end breadcrumb -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
									<div class="col-lg-12">
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
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
    
    
                                        <tbody>
										<?php if($sms_api){
											foreach($sms_api as $sms){
											?>
                                        <tr>
                                            <td><?= ucfirst($sms['fld_login_id']);?></td>
                                            <td><?php if($sms['fld_status'] == 1){
												echo 'Active';
											}elseif($sms['fld_status'] == 2){
												echo 'In Active';
											}else{
												echo '';
											} ?></td>
                                            <td>
                                            <? if(!empty($role_permissions) && in_array(253,$role_permissions)) { ?>    
											<a href="<?= base_url('Settings/edit_sms_api/'.$sms['fld_id'].'')?>">
											<i style="font-size:20px;cursor:pointer;" class="mdi mdi-square-edit-outline" title="Edit"></i></a>
											<?} ?>
											<!--<a href="<?//= base_url('Settings/deleteemail/'.$email['fld_id'].'')?>" onclick="return confirm('Are you sure you want to delete this record.')">-->
											<!--<i style="font-size:20px;cursor:pointer;" class="mdi mdi-delete-forever" title="Delete"></i>-->
											</a>
											
											</td>
                                        </tr>
										<?php }}?>
										
                                        </tbody>
                                    </table>
    
                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->
</div>

                