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
.select2-dropdown {
    background-color: #212744;
    border: 1px solid #575252;
	border-bottom: 1px solid #2a2f4e;
}
.select2-container--default .select2-results__option[aria-selected=true] {
    background-color: #5897FB;
}
.select2-container--default .select2-selection--single {
    background-color: #212744;
    border: 1px solid #575252;
    border-radius: 4px;
	height: 36px;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #bac1dc;
    line-height: 28px;
    padding-top: 2px;
}
.sorting_1 p{
    text-align:center;
}
.dataTables_empty{
    color:red;
}

</style>
<? $role_permissions  = explode(",",$this->session->userdata('permissions')); ?>
<div class="row">
	<div class="col-sm-12"  style="margin-bottom: 2%;">
		<div class="page-title-box">
			<div class="float-right">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Roles/assign_roles" type="button" class="btn btn-outline-primary"><i class="fa fa-user-circle"></i>&nbsp;New Permanent User</a>
                  <a href="<?= base_url();?>Roles/assigned_roles" type="button" class="btn btn-primary btn-large"><i class="fa fa-eye"></i>&nbsp;View Permanent Users</a>
                  <a href="<?= base_url();?>Roles/add_tempuser" type="button" class="btn btn-outline-primary"><i class="fa fa-user-circle"></i>&nbsp;New Temp. User</a>
                  <a href="<?= base_url();?>Roles/manage_tempuser" type="button" class="btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;View Temp. Users</a>
                </div>
			</div>
			<!--<h4 class="page-title">Manage Permanent Users</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Role Management</a></li>-->
			<!--	<li class="breadcrumb-item active">Assigned Roles</li>-->
			<!--</ol>-->
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<!-- end page title end breadcrumb -->
<div class="row">
                        <div class="col-12">
                            <div class="card" style="overflow:auto;">
                               
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
					<? /* ?><form action="" method="post" id="search-emp-form">
                            <div class="row">
                                <div id="filter_global" class="col-md-3">
        						    <label>Global Search</label>
        							<input type="text" class="global_filter form-control" id="global_filter">
        						</div>
                                <div id="filter_global" class="col-md-3">
        						    <label>Employee Code</label>
        							<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="search_by_id" tabindex="1" id="emp_code" >
                                    <option selected="selected" value="">Select by Filter</option>
										<?php
												if($employees){
												foreach($employees as $emp){
										?>
									<option value="<?= $emp['employee_code'];?>"><?= $emp['employee_code'];?></option>
									<?php }}?>
                            </select>
        						</div>
						
						<div id="filter_col2" data-column="1" class="col-md-3">
							<label>Name</label>
							<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="fld_emp_name" tabindex="1" id="fld_emp_id" >
                                    <option selected="selected" value="">All Employees</option>
										<?php
												if($employees){
												foreach($employees as $emp){
										?>
									<option value="<?= $emp['full_name'];?>"><?= $emp['full_name'];?></option>
									<?php }}?>
                            </select>
						</div>
						<div id="filter_col3" data-column="2" class="col-md-3">
							<label>Search By Plants</label>
							<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" id="plants" name="plants" >
                                <option value="">Showing All Plants</option>
                                <?php 
								    $tbl_plants	=	$this->Common_model->select_where_ASC_DESC('fld_id,fld_location','tbl_locations',array('fld_status'=>1),'fld_location','ASC');
                                    if($tbl_plants->num_rows() > 0) {
                                    foreach($tbl_plants->result() as $plant){
                                ?>
                                    <option value="<?php echo $plant->fld_id;?>"><?php echo $plant->fld_location;?></option>
                                <?php } } ?>
                            </select>
						 </div>
						</div>
                        
						<div class="row" style="margin-top: 30px;">
						    <div id="filter_col4" data-column="3" class="col-md-3">
    							<label>Search By Designation</label>
    							<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" id="designation" name="designation" required >
                                    <option value="">Showing All Designations</option>
                                    <?php $tbl_designation	=	$this->Common_model->select_where_ASC_DESC('id,designation_name','tbl_designation',array('deleted'=>0),'designation_name','ASC');
                                        if($tbl_designation->num_rows() > 0) {
                                        foreach($tbl_designation->result() as $desig) {
                                    ?>
                                        <option value="<?php echo $desig->id;?>" ><?php echo $desig->designation_name;?></option>
                                    <?php } } ?>
                                </select>
    						 </div>
    						 <div id="" data-column="3" class="col-md-3">
    							<label>Search By Department</label>
    							<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" id="department"  name="department" required >
                                    <option value="">Showing All Depatments</option>
                                    <?php $tbl_departments	=	$this->Common_model->select_where_ASC_DESC('id,department_name','tbl_departments',array('deleted'=>0),'department_name','ASC');
                                        if($tbl_departments->num_rows() > 0) {
                                        foreach($tbl_departments->result() as $depart) {
                                    ?>
                                        <option value="<?php echo $depart->id;?>" ><?php echo $depart->department_name;?></option>
                                    <?php } } ?>
                                </select>
    						 </div>
						 
    						<div id="" data-column="3" class="col-md-3" style="display:none;">
    							<label>Search By Role</label>
    							<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" id="role"  name="role" required >
                                    <option value="1">Showing All Employee</option>
                                    <option value="2" selected>Employees with assigned roles</option>
                                </select>
    						 </div>
						</div>
						<br>
						<div class="row">
						    <div class="col-md-4">
						        <button class="btn btn-primary btn-large " type="button" aria-controls="step-2" onclick="getFilterEmployee_Role();" aria-expanded="false"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Search</button>&nbsp;&nbsp;
						        <button class="btn btn-danger" type="button" aria-controls="step-2" onclick="window.location.href='<?=base_url().'Roles/assigned_roles';?>'" aria-expanded="false"><i class="fa fa-refresh" aria-hidden="true"></i>&nbsp;RESET FILTERS</button>
						    </div>
						</div>
						</form>
	                <hr><? */ ?>
									</div>
										
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                        <tr>
                                            <th>Emp. Code</th>
                                            <th>Name</th>
                                            <th>Plant</th>
                                            <th>Designation</th>
                                            <th>Assigned Role</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody id="employee_data1">
                                            <?php 
                                                if($employees){
                                                foreach($employees as $emp){ 
                                                $designation =	$this->Common_model->select_single_field('designation_name','tbl_designation',array('id'=>$emp['designation']));       
                                                $department =	$this->Common_model->select_single_field('department_name','tbl_departments',array('id'=>$emp['department']));
                                                $plant =	$this->Common_model->select_single_field('fld_location','tbl_locations',array('fld_id'=>$emp['plants']));
                                                 $role = $roleId ='';
                                                $user_d =	$this->db->query("SELECT * from tbl_users where emp_id = '{$emp['id']}'");
                                                if($user_d->num_rows() > 0){
                                                    $user = $user_d->row();
                                                    $roleId = $user->fld_role;
                                                    $role =	$this->Common_model->select_single_field('role_name','tbl_roles',array('role_id'=>$roleId)); 
                                                }
                                                
                                                if($roleId != ''){
                                            ?>
                                        <tr>
                                            <td><?= $emp['employee_code'];?></td>
                                            <td><?= $emp['full_name'];?></td>
                                            <td><?= $plant;?></td>
                                            <td><?= $designation;?></td>
                                            <td><?=$role;?></td>
                                            <td><? if($user->fld_status == 1){ echo "Active" ;}else{echo "Inactive";} ?></td>
                                            <td>
                                                <? if(!empty($role_permissions) && in_array(264,$role_permissions)) { ?>
    											<a href="<?= base_url('Roles/assignUserRole/'.$emp['id'].'')?>">
    											<i style="font-size:20px;cursor:pointer;" class="mdi mdi-square-edit-outline" title="Edit"></i>
    											</a>
    											<? } ?>
    											<?/* if(!empty($role_permissions) && in_array(265,$role_permissions)) { ?>
    											<?php if($user->fld_status==1){?>
    											   <a href="<?= base_url('Roles/delete_user/'.$user->fld_id.'')?>" onclick="return confirm('Are you sure you want to disable this user.')">
    											<i style="font-size:20px;cursor:pointer;" class="mdi mdi-shield" title="Inactive"></i>
    											</a> 
    										<?php	} else{?>
    										<!--<a href="<?//= base_url('Roles/active_user/'.$user->fld_id.'')?>" onclick="return confirm('Are you sure you want to retrieve this user.')">-->
    											<!--<i style="font-size:20px;cursor:pointer;" class="mdi mdi-shield-outline" title="Active"></i>-->
    											</a> 
    										<? }}*/?>
    										<? if(!empty($role_permissions) && in_array(266,$role_permissions)) { ?>
    											<a href="<?= base_url('Roles/changePassword/'.$user->fld_id.'')?>" >
    										<i class="fa fa-key" aria-hidden="true" title="Change Pass"></i>
    											</a> 
    											<? } ?>
    											<!--<a href="<?//= base_url('Roles/restrict_user/'.$emp['id'].'')?>" onclick="return confirm('Are you sure you restrict this user login.')">-->
    											<!--<i style="font-size:20px;cursor:pointer;" class="mdi mdi-shield-off-outline" title="Restrict Login"></i>-->
    											<!--</a>-->
											</td>
                                        </tr>
                                         <?php }}} ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->
