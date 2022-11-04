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
/*.dataTables_filter{*/
/*    display:none;*/
/*}*/
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
/*.btn{*/
/*    font-size: .8rem !important;*/
/*}*/
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
                  <a href="<?= base_url();?>Employees/manage_Employees" type="button" class="btn btn-outline-primary"><i class='fa fa-eye'></i>&nbsp;View Employee</a>
                  <a href="<?= base_url();?>Employees/employee_report" type="button" class="btn btn-primary btn-large"><i class="fa fa-bar-chart"></i>&nbsp;Employees Report</a>
                  <a href="<?= base_url();?>Employees/manage_trash" type="button" class="btn btn-outline-primary"><i class="fa fa-trash"></i>&nbsp;Trashed Employees</a>
                </div>
			</div>
			<!--<h4 class="page-title">Employees Report</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Employees</a></li>-->
			<!--	<li class="breadcrumb-item active">Employees Report</li>-->
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
                        <form action="" method="post" id="employeefilter">
                            <div class="row">
      <!--                          <div id="filter_global" class="col-md-3">-->
						<!--    <label>Global Search</label>-->
						<!--	<input type="text" class="global_filter form-control" id="global_filter">-->
						<!--</div>-->
						<div class="col-sm-3">
						    <label>Search Type</label>
							<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="filter" id="filter" required>
									<option value="Plant_Wise">Plant Wise</option>
									<option value="employee_name_wise">Employee Name Wise</option>
									<option value="employee_code_wise">Employee Id Wise</option>
									<option value="designation_Wise">Designation Wise</option>
									<option value="department_Wise">Department Wise</option>
							</select>
						<!--</div>-->
						
						
						
						 
						<!--</div>-->
                        
						 <!--<hr>-->
						<!--<div class="row">-->
						 
						 
						
						 
						
						</div>
                        
						 <!--<hr>-->
						<!--<div class="row">-->
						
						 <div class="col-md-9" style="margin-top:30px;">
					        <button class="btn btn-successs btn-large " type="button" aria-controls="step-2"  aria-expanded="false" id="show_report_1"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Proceed F10</button>
					        <button class="btn btn-danger" type="button" aria-controls="step-2" onclick="window.location.href='<?=base_url().'Employees/employee_report';?>'" aria-expanded="false"><i class="fa fa-refresh" aria-hidden="true"></i>&nbsp;Reset</button>
                            <button type="button" class="btn btn-warning waves-effect" id="advance_search" id="hide" disabled>Advance Search F8</button>
						    </div>
						</div>
						<div class="col-md-12 col-lg-12 col-xl-12 hide" id="show_filters_tab" style="padding-left: 0px;margin-top:20px;display:none">
                            <div class="card">
                                <div class="card-body">
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs" role="tablist">
                                         <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#plant" role="tab">Plant Wise</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#employee_filter" role="tab">Employee Wise</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#designation" role="tab">Designation Wise</a>
                                        </li>                                                
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#department" role="tab">Department Wise</a>
                                        </li>
                                    </ul>
    
                                    <!-- Tab panes -->
                                        <div class="tab-content">
                                            <div class="tab-pane p-3" id="plant" role="tabpanel">
                                                <div class="row">
                    								<div id="filter_col6" data-column="1" class="col-md-4">
                            							<label>Search By Plants</label>
                            							<!--<input type="text" class="column_filter form-control" id="col2_filter">-->
                            							<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" onchange="advanceSearch();" id="plants_filter" name="plants" >
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
                                            </div>
                                            <div class="tab-pane active p-3" id="employee_filter" role="tabpanel">
                                                <div class="row">
                    								<div id="filter_col1" data-column="1" class="col-md-4">
                            							<label>ID</label>
                            							<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="emp_code" tabindex="1" onchange="advanceSearch();" required>
                                                                <option selected="selected" value="">All Employees ids</option>
                            										<?php
                            												if($employees){
                            												foreach($employees as $emp){
                            										?>
                            									<option value="<?= $emp['employee_code'];?>"><?= $emp['employee_code'];?></option>
                            									<?php }}?>
                                                        </select>
                            						</div>
                    								<div id="filter_col2" data-column="1" class="col-md-4">
                            							<label>Name</label>
                            							<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="emp_name" tabindex="1" onchange="advanceSearch();" required>
                                                                <option selected="selected" value="">All Employees</option>
                            										<?php
                            												if($employees_names){
                            												foreach($employees_names as $emp){
                            										?>
                            									<option value="<?= $emp['full_name'];?>"><?= $emp['full_name'];?></option>
                            									<?php }}?>
                                                        </select>
                            						</div>
                    							</div>
                                            </div>
                                            <div class="tab-pane p-3" id="designation" role="tabpanel">
                                                <div class="row">
                    								<div id="filter_col4" data-column="3" class="col-md-3">
                            							<label>Search By Designation</label>
                            							<!--<input type="text" class="column_filter form-control" id="col3_filter">-->
                            							<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" id="designation_filter" name="designation" onchange="advanceSearch();" required >
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
                                            </div>                                                
                                            <div class="tab-pane p-3" id="department" role="tabpanel">
                                                <div class="row">
                    								 <div id="" data-column="3" class="col-md-3">
                            							<label>Search By Department</label>
                            							<!--<input type="text" class="column_filter form-control" id="col3_filter">-->
                            							<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" id="department_filter"  name="department" onchange="advanceSearch();" required >
                                                            <option value="">Showing All Depatments</option>
                                                            <?php $tbl_departments	=	$this->Common_model->select_where_ASC_DESC('id,department_name','tbl_departments',array('deleted'=>0),'department_name','ASC');
                                                                if($tbl_departments->num_rows() > 0) {
                                                                foreach($tbl_departments->result() as $depart) {
                                                            ?>
                                                                <option value="<?php echo $depart->id;?>" ><?php echo $depart->department_name;?></option>
                                                            <?php } } ?>
                                                        </select>
                            						 </div>
                    							</div>
                                            </div>
                                        </div>
                                </div><!--end card-body-->
                            </div><!--end card-->
                        </div>	
						</form>
						
	                <hr>
                    <div id="filterhtml">
				    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
</div>

                