<style>
#datatable_filter > label{ float: right; }
.pagination{ float: right;}
.dataTables_empty{text-align: center;}
.dataTables_filter{display:block;}
.select2-dropdown {background-color: #212744;border: 1px solid #575252;border-bottom: 1px solid #2a2f4e;}
.select2-container--default .select2-results__option[aria-selected=true] {background-color: #5897FB;}
.select2-container--default .select2-selection--single {background-color: #212744;border: 1px solid #575252;border-radius: 4px;height: 36px;}
.select2-container--default .select2-selection--single .select2-selection__rendered {color: #bac1dc;line-height: 28px;padding-top: 2px;}
.sorting_1 p{text-align:center;}
</style>
<? $role_permissions  =  explode(",",$this->session->userdata('permissions')); ?>
<div class="container-fluid">
<div class="row">
<div class="col-sm-12">
	<div class="page-title-box">
		<div class="float-right" style="margin-bottom:15px;">
			<div class="btn-group" role="group" aria-label="Basic outlined example">
              <a href="<?= base_url();?>Employees" type="button" class="btn btn-outline-primary"><i class='fas fa-user-plus'></i>&nbsp;New Employee</a>
              <a href="<?= base_url();?>Employees/manage_Employees" type="button" class="btn btn-outline-primary"><i class='fa fa-eye'></i>&nbsp;View Employee</a>
              <a href="<?= base_url();?>Employees/employee_report" type="button" class="btn btn-outline-primary"><i class="fa fa-bar-chart"></i>&nbsp;Employees Report</a>
              <a href="<?= base_url();?>Employees/manage_trash" type="button" class="btn btn-primary btn-large"><i class="fa fa-trash"></i>&nbsp;Trashed Employees</a>
            </div>
		</div>
		<!--<h4 class="page-title">Trashed Employees</h4>-->
		<!--<ol class="breadcrumb">-->
		<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Employee</a></li>-->
		<!--	<li class="breadcrumb-item active">Trashed Employees</li>-->
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
                                <?php echo $error_message; ?>                    
                            </div>
                        <?php
                            $this->session->unset_userdata('error_message');
                        }?>
                        <?php $success_message = $this->session->userdata('success_message');
                            if (isset($success_message)) {
                        ?>
                            <div class="alert alert-success">
                                <?php echo $success_message; ?>                    
                            </div>
                        <?php
                            $this->session->unset_userdata('success_message');
                        }?>
                        </div>
                        <?/*?><form action="" method="post" id="search-emp-form">
                            <div class="row">
                                <div id="filter_global" class="col-md-3">
						    <label>Global Search</label>
							<input type="text" class="global_filter form-control" id="global_filter">
						</div>
						
						<div id="filter_col2" data-column="1" class="col-md-3">
							<label>Name</label>
							<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="fld_emp_name" tabindex="1" id="fld_emp_id" required>
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
						 </div>
                        
						<!-- <hr>-->
						<div class="row" style="margin-top: 30px;">
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
						 <div class="col-md-6" style="margin-top:25px;">
						        <button class="btn btn-primary btn-large " type="button" aria-controls="step-2" onclick="getFilterEmployee();" aria-expanded="false"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Search</button>&nbsp;&nbsp;
						        <button class="btn btn-danger" type="button" aria-controls="step-2" onclick="window.location.href='<?=base_url().'Employees/manage_Employees';?>'" aria-expanded="false"><i class="fa fa-refresh" aria-hidden="true"></i>&nbsp;RESET FILTERS</button>
						    </div>
						</div>
						<br>
						</form>
	                <hr><?*/?>
                    <table id="datatable_tb" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead class="tabletop">
                        <tr>
                            <th>Employee ID</th>
                            <th>Name</th>
                            <th>Deleted By</th>
                            <th>Plant</th>
                            <th>Designation</th>
                            <th>Department</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody id="employee_data">
                        <?php 
                            if($employees){
                            foreach($employees as $emp){ 
                                $designation    =	$this->Common_model->select_single_field('designation_name','tbl_designation',array('id'=>$emp['designation']));       
                                $department     =	$this->Common_model->select_single_field('department_name','tbl_departments',array('id'=>$emp['department']));
                                $plant          =	$this->Common_model->select_single_field('fld_location','tbl_locations',array('fld_id'=>$emp['plants']));
                                $trashby        =	$this->Common_model->select_single_field('fld_username','tbl_users',array('fld_id'=>$emp['fld_trash_by']));
                        ?>
                        <tr>
                            <td><?= $emp['employee_code'];?></td>
                            <td><?= $emp['full_name'];?></td>
                            <td>
            				<?php 
            				   echo $trashby."<br>";
            				   echo '<span style="width: 130px; display: inline-block;color:#506ee4; font-size:11px;">Date: '.date("d-m-Y",strtotime(@$emp['fld_trash_date'])).'</span>'."<br>";
            				   echo '<span style="width: 130px; display: inline-block;color:#21d0c0; font-size:10px;">Time: '.date("H:i:s",strtotime(@$emp['fld_trash_date'])).'</span>';
            				?>
            				</td>
                            <td><?=$plant;?></td>
                            <td><?=$designation;?></td>
                            <td><?=$department;?></td>
                            <td>
							
							<? if(!empty($role_permissions) && in_array(142,$role_permissions)) { ?>
							<a data-toggle="modal" class="exampleModal" data-target="#exampleModal" data-content="<?php echo $emp['id']; ?>" data-uri="<?= base_url('Employees/restore/'.$emp['id'].'');?>">
		        <i style="font-size:16px;cursor:pointer;" class="fas fa-trash-restore" title="Restore"></i></a>
            				<!--<a href="<?//= base_url('Employees/restore/'.$emp['id'].'');?>" onclick="return confirm('Are you sure you want to Restore this record.')">-->
            				<!--<i style="font-size:16px;cursor:pointer;" class="fas fa-trash-restore" title="Restore"></i>-->
            				<!--</a>-->
            				<? } ?>
							
							<? if(!empty($role_permissions) && in_array(40,$role_permissions)) { ?>
                            <a href="<?= base_url('Employees/viewEmployee/'.$emp['id'].'')?>"><i style="font-size:20px;cursor:pointer;" class="mdi mdi-eye-circle-outline" title="View"></i></a>
							<? } ?>
							
							<? /* ?><? if(!empty($role_permissions) && in_array(143,$role_permissions)) { ?>
                            <a href="<?= base_url('Employees/deletepermanent/'.$emp['id'].'')?>" onclick="return confirm('Are you sure you want to delete this record.')">
                            <i style="font-size:20px;cursor:pointer;" class="mdi mdi-delete-forever" title="Delete"></i>
                            </a>
                            <? } ?><? */ ?>
                            
                            </td>
                        </tr>
                        <? } } ?>
                        </tbody>
                    </table>
                </div>
                
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content" style="box-shadow: 0 7px 14px 0 rgb(65 203 216 / 50%) !important;">
    <div class="modal-header">
        <h5 class="modal-title mt-0" id="exampleModalLabel">Employee Entry</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form id="modal-form" method="post">
    <div class="modal-body">
        <p>Are you sure you want to Restore this record.</p>
    </div>
    <div class="modal-footer">
        <input type="hidden" id="employee_id" name="employee_id" />
        <button type="button" class="btn btn-gradient-danger waves-effect waves-light" data-dismiss="modal">Cancel</button>
        <button type="Submit" class="btn btn-gradient-purple waves-effect waves-light">Proceed to Restore</button>
    </div>
    </form>
    </div>
</div>
</div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
</div>