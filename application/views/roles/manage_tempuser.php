<style>
    .dataTables_filter{
        float:right;
    }
    #datatable_paginate{
         float:right;
    }
</style>
<? $role_permissions  = explode(",",$this->session->userdata('permissions')); ?>
<div class="row">
	<div class="col-sm-12" style="margin-bottom: 2%;">
		<div class="page-title-box">
			<div class="float-right">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <!--<a href="<?//= base_url();?>Roles/assign_roles" type="button" class="btn btn-outline-primary"><i class="fa fa-user-circle"></i>&nbsp;New Permanent User</a>-->
                  <!--<a href="<?//= base_url();?>Roles/assigned_roles" type="button" class="btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;View Permanent Users</a>-->
                  <a href="<?= base_url();?>Roles/add_tempuser" type="button" class="btn  btn-outline-primary "><i class="fa fa-user-circle"></i>&nbsp;New Temp. User</a>
                  <a href="<?= base_url();?>Roles/manage_tempuser" type="button" class="btn btn-primary btn-large"><i class="fa fa-eye"></i>&nbsp;View Temp. Users</a>
                </div>
			</div>
			<!--<h4 class="page-title">Manage Temporary Users</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Role Management</a></li>-->
			<!--	<li class="breadcrumb-item active">Assigned Roles</li>-->
			<!--</ol>-->
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>

<div class="row">
    <div class="col-lg-12" style="padding: 0px;">
				<?php 
    				$error_message = $this->session->userdata('error_message');
    				if (isset($error_message)) {
				?>
					<div class="alert alert-danger">
						<?php echo $error_message; ?>                    
					</div>
				<?php $this->session->unset_userdata('error_message'); } ?>
				<?php 
    				$success_message = $this->session->userdata('success_message');
    				if (isset($success_message)) {
				?>
					<div class="alert alert-success">
						<?php echo $success_message ?>                    
					</div>
			    <?php $this->session->unset_userdata('success_message'); } ?>
				</div>
    <div class="col-12">
        <div class="card" style="overflow:auto;">
            <div class="card-body">
	            <div class="col-lg-12">    
                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <!--<th>S.No</th>-->
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Assigned Role</th>
                            <th>Assigned Plant</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody id="employee_data1">
                        <?php 
                            if($users){
                            $i = 1;    
                            foreach($users as $usr){ 
                            $role =	$this->Common_model->select_single_field('role_name','tbl_roles',array('role_id'=>$usr['fld_role']));
                            $plant =	$this->Common_model->select_single_field('fld_location','tbl_locations',array('fld_id'=>$usr['plant_id']));
                            //$designation =	$this->Common_model->select_single_field('designation_name','tbl_designation',array('id'=>$emp['designation']));       
                            //$department  =	$this->Common_model->select_single_field('department_name','tbl_departments',array('id'=>$emp['department']));
                            //$plant  =	 $this->Common_model->select_single_field('fld_location','tbl_locations',array('fld_id'=>$emp['plants']));
                        ?>
                        <tr>
                            <!--<td><?//= $i++;?></td>-->
                            <td><?= $usr['fld_username'];?></td>
                            <td><?= $usr['fld_email'];?></td>
                            <td><?=$role;?></td>
                            <td><?=$plant;?></td>
                            <td>
                                <?
                                 if($usr['fld_status'] == 1){
                                     echo "Active";
                                 }else{
                                     echo "In Active";
                                 }
                                ?>
                            </td>
                            <td>
                                <? if(!empty($role_permissions) && in_array(184,$role_permissions)) { ?>
								<a href="<?= base_url('Roles/edittempuser/'.$usr['fld_id'].'')?>">
								 <i style="font-size:20px;cursor:pointer;" class="mdi mdi-square-edit-outline" title="Edit"></i>
								</a>
								<?}?>
								<? if(!empty($role_permissions) && in_array(185,$role_permissions)) { ?>
								<a href="<?=base_url('Roles/deleteTempuser/'.$usr['fld_id']);?>" onclick="return confirm('Are you sure you want to delete this record.')">
								 <i style="font-size:20px;cursor:pointer;" class="mdi mdi-delete-forever" title="Delete"></i>
								</a>
								<?}?>
								<? if(!empty($role_permissions) && in_array(267,$role_permissions)) { ?>
								<a href="<?= base_url('Roles/changePassword/'.$usr['fld_id'].'')?>" >
    								<i class="fa fa-key" aria-hidden="true" title="Change Pass"></i>
    							</a>
    							<?}?>
							</td>
                        </tr>
                         <?php } } ?>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>    