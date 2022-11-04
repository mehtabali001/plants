<style>
.dataTables_filter{
    display:block;
}
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
@media only screen and (max-width: 600px) {
.page-title-box{
    display:none;
}
#datatable_tb_length label{
    width:100%;
}
#datatable_tb_filter{
   width:100%; 
}
#datatable_tb_filter label{
   width:100%; 
}
}
</style>
<? $role_permissions  = explode(",",$this->session->userdata('permissions')); ?>
<div class="container-fluid">
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right" style="margin-bottom:15px;">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Employees" type="button" class="btn btn-outline-primary"><i class='fas fa-user-plus'></i>&nbsp;New Employee</a>
                  <a href="<?= base_url();?>Employees/manage_Employees" type="button" class="btn btn-primary btn-large"><i class='fa fa-eye'></i>&nbsp;View Employee</a>
                  <a href="<?= base_url();?>Employees/employee_report" type="button" class="btn btn-outline-primary"><i class="fa fa-bar-chart"></i>&nbsp;Employees Report</a>
                  <a href="<?= base_url();?>Employees/manage_trash" type="button" class="btn btn-outline-primary"><i class="fa fa-trash"></i>&nbsp;Trashed Employees</a>
                </div>
			</div>
			<!--<h4 class="page-title">View Employees</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--<li class="breadcrumb-item"><a href="javascript:void(0);">Employee</a></li>-->
			<!--<li class="breadcrumb-item active">View Employees</li>-->
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
                    <table id="datatable_tb" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead class="tabletop">
                        <tr>
                            <th>Employee ID</th>
                            <th>Name</th>
                            <th>Plant</th>
                            <th>Designation</th>
                            <th>Department</th>
                            <th>Salary Setup</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody id="employee_data">
                        <?php 
                            if($employees){
                            foreach($employees as $emp){ 
                            $designation =	$this->Common_model->select_single_field('designation_name','tbl_designation',array('id'=>$emp['designation']));       
                            $department =	$this->Common_model->select_single_field('department_name','tbl_departments',array('id'=>$emp['department']));
                            $plant =	$this->Common_model->select_single_field('fld_location','tbl_locations',array('fld_id'=>$emp['plants']));
                        ?>
                        <tr>
                            <td><?= $emp['employee_code'];?></td>
                            <td><?= $emp['full_name'];?></td>
                            <td><?= $plant;?></td>
                            <td><?= $designation;?></td>
                            <td><?= $department;?></td>
                            <td><? if($emp['net_payment'] > 0){ ?> Yes <? }else{ ?><a href="<?= base_url('Payroll/editsalarysetup/'.$emp['id'])?>" style="color:red;">No</a><? } ?></td>
                            <td><? if($emp['is_active'] == 1){ ?> Active <? }else{ ?><p style="color:red;">In Active</p><? } ?></td>
                            <td>
							<? if(!empty($role_permissions) && in_array(38,$role_permissions)) { ?>
                            <a href="<?= base_url('Employees/edit/'.$emp['id'].'')?>">
                            <i style="font-size:20px;cursor:pointer;" class="mdi mdi-square-edit-outline" title="Edit"></i></a>
							<? } ?>
							<? if(!empty($role_permissions) && in_array(40,$role_permissions)) { ?>
                            <a href="<?= base_url('Employees/viewEmployee/'.$emp['id'].'')?>"><i style="font-size:20px;cursor:pointer;" class="mdi mdi-eye-circle-outline" title="View"></i></a>
							<? } ?>
							<? if(!empty($role_permissions) && in_array(39,$role_permissions)) { ?>
							<a data-toggle="modal" class="exampleModal" data-target="#exampleModal" data-content="<?php echo $emp['id']; ?>" data-uri="<?= base_url('Employees/delete/'.$emp['id'].'')?>">
		<i style="font-size:20px;cursor:pointer;" class="mdi mdi-delete-forever" title="Delete"></i></a>
                            <!--<a href="<?//= base_url('Employees/delete/'.$emp['id'].'')?>" onclick="return confirm('Are you sure you want to delete this record.')">-->
                            <!--<i style="font-size:20px;cursor:pointer;" class="mdi mdi-delete-forever" title="Delete"></i>-->
                            <!--</a>-->
                            <? } ?>
                            </td>
                        </tr>
                        <?php } } ?>
                        </tbody>
                    </table>
                </div>
                
<div class="modal fade bs-example-modal-center" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="box-shadow: 0 7px 14px 0 rgb(65 203 216 / 50%) !important;">
    <div class="modal-header">
        <h5 class="modal-title mt-0" id="exampleModalLabel">Employee Entry</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form id="modal-form" method="post">
    <div class="modal-body">
        <p>Are you sure you want to trash this record.</p>
    </div>
    <div class="modal-footer">
        
        <input type="hidden" id="employee_id" name="employee_id" />
        <button type="button" class="btn btn-gradient-danger waves-effect waves-light" data-dismiss="modal">Cancel</button>
        <button type="Submit" class="btn btn-gradient-purple waves-effect waves-light">Proceed to Delete</button>
        
    </div>
    </form>
    </div>
</div>
</div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
</div>

                