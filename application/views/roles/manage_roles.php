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
	<div class="col-sm-12" style="margin-bottom:2%;">
		<div class="page-title-box">
			<div class="float-right">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Roles/addRole" type="button" class="btn btn-outline-primary"><i class="fa fa-user-circle"></i>&nbsp;New Roles</a>
                  <a href="<?= base_url();?>Roles/manage_Roles" type="button" class="btn btn-primary btn-large"><i class="fa fa-eye"></i>&nbsp;View Roles</a>
                  <a href="<?= base_url();?>Roles/assign_roles" type="button" class="btn btn-outline-primary"><i class="fa fa-user-circle"></i>&nbsp;New Permanent Users</a>
                  <a href="<?= base_url();?>Roles/assigned_roles" type="button" class="btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;View Permanent Users</a>
                </div>
			</div>
			<!--<h4 class="page-title">Manage Locations</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Role Management</a></li>-->
			<!--	<li class="breadcrumb-item active">Manage Roles</li>-->
			<!--</ol>-->
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
                                            <th>Role Name</th>
                                            <th>Role Description</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
										<?
										  foreach($roles as $role){
										?>
                                        <tr>
                                            <td><?=$role['role_name'];?></td>
                                            <td><?=$role['description'];?></td>
                                            <td>
											<? if(!empty($role_permissions) && in_array(50,$role_permissions)) { ?>
											<a href="<?=base_url('Roles/editRolespermission/'.$role['role_id']);?>">
											<i style="font-size:20px;cursor:pointer;" class="mdi mdi-square-edit-outline" title="Edit"></i></a>
											<? } ?>
											
											<? if ($role['role_id'] != 1){ ?>
											<? if(!empty($role_permissions) && in_array(51,$role_permissions)) { ?>
											<a href="<?=base_url('Roles/deleteRoles/'.$role['role_id']);?>" onclick="return confirm('Are you sure you want to delete this record.')">
											<i style="font-size:20px;cursor:pointer;" class="mdi mdi-delete-forever" title="Delete"></i>
											</a>
											<? } ?>
											<? } ?>
											</td>
                                        </tr>
										  <? } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->
</div>