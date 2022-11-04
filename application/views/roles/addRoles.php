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
	<div class="col-sm-12" style="margin-bottom:2%;">
		<div class="page-title-box">
			<div class="float-right">
			    <div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Roles/addRole" type="button" class="btn btn-primary btn-large"><i class="fa fa-user-circle"></i>&nbsp;New Roles</a>
                  <a href="<?= base_url();?>Roles/manage_Roles" type="button" class="btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;View Roles</a>
                  <a href="<?= base_url();?>Roles/assign_roles" type="button" class="btn btn-outline-primary"><i class="fa fa-user-circle"></i>&nbsp;New Permanent Users</a>
                  <a href="<?= base_url();?>Roles/assigned_roles" type="button" class="btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;View Permanent Users</a>
                </div>	
			</div>
			<!--<h4 class="page-title">Add Role</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Role Management</a></li>-->
			<!--	<li class="breadcrumb-item active">Add Role</li>-->
			<!--</ol>-->
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<form method="post" action="<?=base_url('Roles/add');?>">
				<div class="row">
    				<div class="col-lg-12">
    					<label class="mb-2">Add Role <span class="danger">*</span></label>
    					<input type="text" class="form-control"  name="role_name" id="role_name" required placeholder="Manager">
    				</div> 
    				<div class="col-lg-12">
    					<label class="mb-2">Add Description</label>
    					<textarea type="text" class="form-control"  name="description" id="description"  cols="70" placeholder="Role description here ....."></textarea>
    				</div>
    			</div>
    			    <hr>
    			<div class="row">
    				<div class="col-lg-12">
					<?
					  $mainpart = $this->db->query("SELECT * FROM tbl_admin_menu_group ORDER BY display_priority ASC")->result_array();
					  foreach($mainpart as $mpart){
					?>
    				    <div class="checkbox checkbox-success form-check-inline">
                            <input class="menu_group_name checkAll<?=$mpart['menu_group_id'];?>" id="menu_group_name_<?=$mpart['menu_group_id'];?>" name="menu_group_name[]" type="checkbox" value="<?=$mpart['menu_group_id'];?>">
                            <label for="menu_group_name">
                                <strong><?=$mpart['menu_group_name'];?> (Main Level)</strong>
                            </label>
                        </div><br>
					<?
						$subpart = $this->db->query("SELECT * FROM tbl_admin_menu_subgroup WHERE menu_group_parent = '".$mpart['menu_group_id']."' ORDER BY display_priority ASC")->result_array();
					    foreach($subpart as $spart){
					?>	
						<div class="checkbox checkbox-success form-check-inline">
                            <input type="checkbox" name="menu_subgroup_name[]" class="menu_subgroup_name menu_subgroup_name_<?=$spart['menu_subgroup_id'];?>" id="menu_subgroup_name_<?=$spart['menu_subgroup_id'];?>" value="<?=$spart['menu_subgroup_id'];?>">
                            <label for="menu_subgroup_name"> 
							  <strong><?=$spart['menu_subgroup_name'];?> (Sub Level)</strong>
							</label>
                        </div>
						<br>
					<?
						$subpartslinks = $this->db->query("SELECT * FROM tbl_admin_menu WHERE menu_subgroup_id = '".$spart['menu_subgroup_id']."' ORDER BY menu_id ASC")->result_array();
					    foreach($subpartslinks as $link){
					?>
						<div class="checkbox checkbox-success form-check-inline">
                            <input type="checkbox" name="admin_menu[]" class="admin_menu admin_menu_<?=$link['menu_id'];?>" id="admin_menu_<?=$link['menu_id'];?>" data-mgid="<?=$mpart['menu_group_id'];?>" data-msgid="<?=$spart['menu_subgroup_id'];?>" value="<?=$link['menu_id'];?>">
                            <label for="admin_menu_<?=$link['menu_id'];?>"> 
							  <?=$link['menu_description'];?>
							</label>
                        </div>	
					<? } ?>
					<br>
					<h5>Permissions:</h5>
					<?
						$permissions = $this->db->query("SELECT * FROM tbl_role_permissions WHERE menu_subgroup_id = '".$spart['menu_subgroup_id']."' ORDER BY id ASC")->result_array();
					    foreach($permissions as $perm){
					?>
						<div class="checkbox checkbox-success form-check-inline">
                            <input type="checkbox" name="permission[]"  class="permission permission_<?=$perm['id'];?>" id="permission_<?=$perm['id'];?>" data-mgid="<?=$mpart['menu_group_id'];?>" data-msgid="<?=$spart['menu_subgroup_id'];?>" data-menuid="<?=$perm['menu_id'];?>" value="<?=$perm['id'];?>" <? if($this->session->userdata('user_role') != 1 && $perm['id'] == 147){ ?> disabled <? } ?>>
                            <label for="permission_<?=$perm['id'];?>"> 
							  <?=$perm['title'];?>
							</label>
                        </div>	
                        <script>
                            $('.checkAll<?=$mpart['menu_group_id'];?>').click(function(){
                                $('input[data-mgid="<?=$mpart['menu_group_id'];?>"]').each(function(){
                                    $(this).prop('checked',true);
                               })               
                            });
                        </script>
					<? } ?>
					<br>
					<? } ?>	
					
						<hr>
					<? } ?>
					<?/*?><h2>All Permissions:</h2>
					<hr>
					<?
						$permissions = $this->db->query("SELECT * FROM tbl_role_permissions ORDER BY id ASC")->result_array();
					    foreach($permissions as $perm){
					?>
						<div class="checkbox checkbox-success form-check-inline">
                            <input type="checkbox" name="permission[]" id="permission" value="<?=$perm['id'];?>">
                            <label for="permission"> 
							  <?=$perm['title'];?>
							</label>
                        </div>	
					<? } ?>
                    <hr><?*/?>
						
    				</div>
    			</div>			
				<div class="col-lg-12">
					<div class="mt-3">
						<label class="mb-2"></label>
						<button type="submit" class="btn btn-successs">Proceed</button>
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
