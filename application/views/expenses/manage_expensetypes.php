<style>
.pagination, .dataTables_filter {
    float: right;
}
</style>
<? $role_permissions  = explode(",",$this->session->userdata('permissions')); ?>
<div class="container-fluid">
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Common/expense_type" type="button" class="btn btn-outline-primary"><i class="fa fa-shopping-cart"></i>&nbsp;Add Expense Type</a>
                  <a href="<?= base_url();?>Common/manage_Expenses" type="button" class="btn btn-primary btn-large"><i class="fa fa-vcard"></i>&nbsp;Manage Expense Types</a>
                </div>
			</div>
			<h4 class="page-title">Manage Expense Type</h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="javascript:void(0);">Expenses</a></li>
				<li class="breadcrumb-item active">Expense Types</li>
			</ol>
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<div class="row">
	<div class="col-lg-12">
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
	}
	?>
	<?php 
	  $success_message = $this->session->userdata('success_message');
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
	<table id="datatable_tb" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead  class="tabletop">
    <tr>
        <th>Sr#</th>
        <th>Date</th>
        <th>Expense Type</th>
        <th>Value</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
	<?php if($expensetypes){
	    $i = 1;
		foreach($expensetypes as $exp){
		     $updateby =	$this->Common_model->select_single_field('fld_username','tbl_users',array('fld_id'=>$exp['fld_updated_by']));
		    //$plantfor =	$this->Common_model->select_single_field('fld_location','tbl_locations',array('fld_id'=>$exp['plant_for']));
		    //$plantfrom =	$this->Common_model->select_single_field('fld_location','tbl_locations',array('fld_id'=>$exp['plant_from']));
		    //$name =	$this->Common_model->select_single_field('name','tbl_stationary',array('id'=>$exp['expense_item']));
		
		?>
    <tr>
        <td><?=$i++;?></td>
        <td><?= date('d-M-Y',strtotime($exp['added_date']))."<br>";
                                    		    if($exp['fld_updated_by'] != 0){
                                    				echo '<span style="width: 150px; display: inline-block;color:#506ee4; font-size:10px;">Edited On: '.date("d-m-Y,H:i",strtotime(@$exp['fld_updated_date'])).'</span>'."<br>";
                                    				echo '<span style="width: 150px; display: inline-block;color:#21d0c0; font-size:10px;">By: '.$updateby.'</span>';
                                    		    }?></td>
        <td>
        <?
            if($exp['expense_type'] == 1){
                echo "Office Expense";
            }else{
                echo "Mess Expense";
            }
        ?>
        </td>
        <td><?=$exp['expense_value'];?></td>
        
        <td>
            
		<? if(!empty($role_permissions) && in_array(168,$role_permissions)) { ?>
		<a href="<?= base_url('Common/edittype/'.$exp['id'].'')?>">
		<i style="font-size:20px;cursor:pointer;" class="mdi mdi-square-edit-outline" title="Edit"></i></a>
		<? } ?>
		
		<? if(!empty($role_permissions) && in_array(169,$role_permissions)) { ?>
		<a href="<?= base_url('Common/deletetype/'.$exp['id'].'')?>" onclick="return confirm('Are you sure you want to delete this record.')">
		<i style="font-size:20px;cursor:pointer;" class="mdi mdi-delete-forever" title="Delete"></i>
		</a>
		<? } ?>
		</td>
    </tr>
	<?php } }else{ ?>
	<td colspan="5" style="text-align:center;color:red;">
        Sorry no record found
    </td>
    <td style="display:none;"></td>
    <td style="display:none;"></td>
    <td style="display:none;"></td>
    <td style="display:none;"></td>
    <?}?>
    </tbody>
</table>
	</div>
	</div> <!-- end card-body -->
	</div> <!-- end card -->                                       
	</div> <!-- end col -->
</div><!-- container -->