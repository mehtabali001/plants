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
<table id="datatable_tb" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
	<thead class="tabletop">
	<tr>
		<th>#</th>
		<th>Complaint ID</th>
		<!--<th>Name</th>-->
		<th>Date</th>
		<th>Subject</th>
		<th>Category</th>
		<!--<th>Description</th>-->
		<th>Status</th>
		<th>Action</th>
	</tr>
	</thead>


	<tbody>
	<?php if($my_complaints){
		$i=1;
		foreach($my_complaints as $comp){
			
		?>
	<tr>
		<td><?= $i;?></td>
		<td><?= $comp['fld_complain_id'];?></td>
		<td><?= date('d-m-Y',strtotime($comp['fld_created_date']));?></td>
		<td><?= $comp['fld_complain_subject'];?></td>
		<td><?= $comp['category_name'];?></td>
		<!--<td><?//= $comp['fld_description'];?></td>-->
		<td>
		
		<?php if($comp['fld_status'] == 0){?>
		Pending
		<?php }elseif($comp['fld_status'] == 1){?>
		Resolved
		<?php }else{?>
		Not resolved
		<?php }?>
		
		
		</td>
		<td>
		<?php if($comp['fld_status'] == 0){?>
		<? if(!empty($role_permissions) && in_array(73,$role_permissions)) { ?>
		
		<a href="<?= base_url('Complaints/edit_complaint/'.$comp['fld_id'].'')?>">
		<i style="font-size:20px;cursor:pointer;" class="mdi mdi-square-edit-outline" title="Edit"></i></a>
		<? } ?>
		<? if(!empty($role_permissions) && in_array(74,$role_permissions)) { ?>
		<!--<a href="" onclick="return confirm('Are you sure you want to delete this record.')">-->
		<!--<i style="font-size:20px;cursor:pointer;" class="mdi mdi-delete-forever" title="Delete"></i>-->
		<!--</a>-->
		<a data-toggle="modal" class="exampleModal" data-target="#exampleModal" data-content="<?php echo $comp['fld_id']; ?>" data-uri="<?= base_url('Complaints/deleteComplaint/'.$comp['fld_id'].'')?>">
		                                    <i style="font-size:20px;cursor:pointer;" class="mdi mdi-delete-forever" title="Delete"></i></a>
		
		<? }} ?>
		
		<a href="<?= base_url('Complaints/view_complaint/'.$comp['fld_id'].'')?>">
		<i style="font-size:20px;cursor:pointer;" class="mdi mdi-eye-circle-outline" title="View"></i></a>
		</td>
	</tr>
	<?php  $i++;}} else {?>
	<td></td>
	<td></td>
	<td></td>
	<td style="text-align:center;color:red;">
			Sorry no record found
	</td>
	<td></td>
	<td></td>
	<td></td>
	<?}?>
	</tbody>
</table>
