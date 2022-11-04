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
@media only screen and (max-width: 600px) {
.page-title-box{
    display:none;
}
.dataTables_length label{
    width:100%;
}
.dataTables_filter{
   width:100%; 
}
.dataTables_filter label{
   width:100%; 
}
.pagination{
    width: 100%;
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
                  <a href="<?= base_url();?>Payroll/addsalarysetup" type="button" class="btn btn-outline-primary"><i class="fas fa-money-check-alt"></i></i>&nbsp;New Salary Setup</a>    
                  <a href="<?= base_url();?>Payroll/generatesalaries" type="button" class="btn btn-outline-primary"><i class="fas fa-money-bill-alt"></i></i>&nbsp;Generate Salaries</a>
                  <a href="<?= base_url();?>Payroll/manage_salarysetup" type="button" class="btn btn-primary btn-large"><i class="fa fa-eye"></i>&nbsp;View Salary Setup</a>
                  <a href="<?= base_url();?>Payroll" type="button" class="btn btn-outline-primary"><i class="fa fa-bar-chart"></i>&nbsp;Salaries Report</a>
                </div>
			</div>
			<!--<h4 class="page-title">View Salaries Setup</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Salary Setup</a></li>-->
			<!--	<li class="breadcrumb-item active">View Salaries Setup</li>-->
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
                        <?php 
                        $success_message = $this->session->userdata('success_message');
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
                            <th>Salary(PKR)</th>
                            <th>Deduction(PKR)</th>
                            <th>Total(PKR)</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody id="employee_data">
                        <?php 
                            if($employees){
                            foreach($employees as $emp){ 
                            $designation =	$this->Common_model->select_single_field('designation_name','tbl_designation',array('id'=>$emp['designation']));       
                            //$department  =	$this->Common_model->select_single_field('department_name','tbl_departments',array('id'=>$emp['department']));
                            $plant       =	$this->Common_model->select_single_field('fld_location','tbl_locations',array('fld_id'=>$emp['plants']));
                            $updateby =	$this->Common_model->select_single_field('fld_username','tbl_users',array('fld_id'=>$emp['fld_updated_by']));
                        ?>
                        <tr>
                            <td><?= $emp['employee_code'];?></td>
                            <td>
                                <?
                                echo $emp['full_name']."<br>";
                                if($emp['fld_updated_by'] != 0){
                                echo '<span style="color:#506ee4; font-size:10px;">Updated On: '.date("d-m-Y,h:i A",strtotime(@$emp['update_salarysetup_date'])).'</span>'."<br>";
                                echo '<span style="color:#21d0c0; font-size:10px;">By: '.$updateby.'</span>';
                                }
                                ?>
                            </td>
                            <td><?= $plant;?></td>
                            <td><?= $designation;?></td>
                            <td><?= $emp['gross_pay'];?></td>
                            <td><?= $emp['t_deductions'];?></td>
                            <td><?= $emp['net_payment'];?></td>
                            <td>
							<? if(!empty($role_permissions) && in_array(182,$role_permissions)) { ?>
                            <a href="<?= base_url('Payroll/editsalarysetup/'.$emp['id'].'')?>">
                            <i style="font-size:20px;cursor:pointer;" class="mdi mdi-square-edit-outline" title="Edit"></i></a>
							<? } ?>
                            </td>
                        </tr>
                        <?php }} ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
</div>