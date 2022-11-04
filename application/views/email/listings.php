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
@media only screen and (max-width: 600px) {
      .btn-group {
        display:none;
      }
    }
</style>
<? $role_permissions  = explode(",",$this->session->userdata('permissions')); ?>
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
		</div>
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
                        <th>Template Name</th>
                        <th>Template Subject</th>
                        <!--<th>Status</th>-->
                        <th>Action</th>
                    </tr>
                    </thead>


                    <tbody>
					<?php if($emails){
						foreach($emails as $email){
						?>
                    <tr>
                        <td><?= ucfirst($email['fld_email']);?></td>
                        <td><?= ucfirst($email['fld_subject']);?></td>
                     <td>
                        <? if(!empty($role_permissions) && in_array(115,$role_permissions)) { ?>    
						<a href="<?= base_url('Settings/editemail/'.$email['fld_id'].'')?>">
						<i style="font-size:20px;cursor:pointer;" class="mdi mdi-square-edit-outline" title="Edit"></i></a>
						<? } ?>
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

                