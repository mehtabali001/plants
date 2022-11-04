<style>
    .form-check-inline {
    padding-left: 4px;
}
.danger{
    color:red;
}
</style>
<div class="container-fluid">
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
			<!--<h4 class="page-title">Edit Role</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Role Management</a></li>-->
			<!--	<li class="breadcrumb-item active">Edit Role</li>-->
			<!--</ol>-->
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<form method="post" action="<?=base_url('Roles/edit');?>">
				<div class="row">
    				<div class="col-lg-12">
    					<label class="mb-2">Add Role <span class="danger">*</span></label>
    					<input type="text" class="form-control"  name="role_name" id="role_name" value="<?=$role_detail['role_name'];?>" required placeholder="Manager">
    				</div> 
    				<div class="col-lg-12">
    					<label class="mb-2">Add Description</label>
    					<textarea type="text" class="form-control"  name="description" id="description"  cols="70" placeholder="Role description here ....."><?=$role_detail['description'];?></textarea>
    				</div>
    			</div>
    			    <hr>
    			<div class="row">
    				<div class="col-lg-12">
					<?
					  $mainpart = $this->db->query("SELECT * FROM tbl_admin_menu_group ORDER BY display_priority ASC")->result_array();
					  $admin_main_level   	=   $role_detail['admin_menu'];
					  $check_mainlevel   	=   explode(",", $admin_main_level);
					  foreach($mainpart as $mpart){
					?>
    				    <div class="checkbox checkbox-success form-check-inline">
                            <input class="menu_group_name" name="menu_group_name[]" type="checkbox" <? if(!empty($check_mainlevel) && in_array($mpart['menu_group_id'],$check_mainlevel)) { ?> checked="checked" <? } ?> value="<?=$mpart['menu_group_id'];?>">
                            <label for="menu_group_name">
                                <strong><?=$mpart['menu_group_name'];?> (Main Level)</strong>
                            </label>
                        </div><br>
					<?
						$subpart = $this->db->query("SELECT * FROM tbl_admin_menu_subgroup WHERE menu_group_parent = '".$mpart['menu_group_id']."' ORDER BY display_priority ASC")->result_array();
						$admin_sub_level   	=   $role_detail['admin_menu_sublevel'];
					    $check_sublevel   	=   explode(",", $admin_sub_level);
					    foreach($subpart as $spart){
					?>	
						<div class="checkbox checkbox-success form-check-inline">
                            <input type="checkbox" name="menu_subgroup_name[]" class="menu_subgroup_name" <? if (!empty($check_sublevel) && in_array($spart['menu_subgroup_id'],$check_sublevel)) { ?> checked="checked" <? } ?> value="<?=$spart['menu_subgroup_id'];?>">
                            <label for="menu_subgroup_name"> 
							  <strong><?=$spart['menu_subgroup_name'];?> (Sub Level)</strong>
							</label>
                        </div>
						<br>
					<?
						$subpartslinks = $this->db->query("SELECT * FROM tbl_admin_menu WHERE menu_subgroup_id = '".$spart['menu_subgroup_id']."' ORDER BY menu_id ASC")->result_array();
						$admin_menu_group   	=   $role_detail['admin_menu_group'];
					    $check_admin_menu_group   	=   explode(",", $admin_menu_group);
					    foreach($subpartslinks as $link){
					?>
						<div class="checkbox checkbox-success form-check-inline">
                            <input type="checkbox" name="admin_menu[]" class="admin_menu" <? if (!empty($check_admin_menu_group) && in_array($link['menu_id'],$check_admin_menu_group)) { ?> checked="checked" <? } ?> value="<?=$link['menu_id'];?>">
                            <label for="admin_menu"> 
							  <?=$link['menu_description'];?>
							</label>
                        </div>	
					<? } ?>
					<br>
					<h5>Permissions:</h5>
					<?
						$permissions = $this->db->query("SELECT * FROM tbl_role_permissions WHERE menu_subgroup_id = '".$spart['menu_subgroup_id']."' ORDER BY id ASC")->result_array();
						$admin_permission   	=   $role_detail['perm_issions'];
					    $check_permission   	=   explode(",", $admin_permission);
					    foreach($permissions as $perm){
					?>
						<div class="checkbox checkbox-success form-check-inline">
                            <input type="checkbox" name="permission[]" <? if (!empty($check_permission) && in_array($perm['id'],$check_permission)) { ?> checked="checked" <? } ?> value="<?=$perm['id'];?>" <? if($this->session->userdata('user_role') != 1 && $perm['id'] == 147){ ?> disabled <? } ?>>
                            <label for="permission"> 
							  <?=$perm['title'];?>
							</label>
                        </div>	
					<? } ?>
					<br>
					<? } ?>	
					
					<hr>
					<? } ?>   
    				</div>
    			</div>			
				<div class="col-lg-12">
					<div class="mt-3">
						<label class="mb-2"></label>
						<input type="hidden" class="form-control" name="role_id" id="role_id" value="<?=$role_detail['role_id'];?>">
						<button type="submit" class="btn btn btn-successs">Proceed</button>
						<button type="button" class="btn btn-danger">Reset Flters</button>
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