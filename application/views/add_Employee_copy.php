<style>
    #target{
        display:flex;
    }
    #target2{
        display:flex;
    }
    #target3{
        display:flex;
    }
    #target4{
        display:flex;
    }
    #target5{
        display:flex;
    }
    #target6{
        display:flex;
    }
   
    .stepss{
        background-color: rgba(80,110,228,0.1);
        color: #506ee4;
        padding: 0 20px 0 0;
        /*-webkit-box-shadow: 0px 0px 0px 2.25px rgb(80 110 228 / 50%);*/
        /*box-shadow: 0px 0px 0px 2.25px rgb(80 110 228 / 50%);*/
    }
    .stepss:active{
        background: linear-gradient(14deg, #506ee4 0%, rgba(80,110,228,0.6));
        color: #fff;
        padding: 2px 20px 2px 2px;
        /*-webkit-box-shadow: 0px 3px 10px 0 rgb(80 110 228 / 40%);*/
        /*box-shadow: 0px 3px 10px 0 rgb(80 110 228 / 40%);*/
    }
    .btn-success {
    border: 1px solid #575252;
    background-color: #212744;
    box-shadow:none !important;
}
</style>
<div class="container-fluid">
<div class="row">
    <div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Employees" type="button" class="btn btn-primary btn-large"><i class='fas fa-user-plus'></i>&nbsp;Add Employee</a>
                  <a href="<?= base_url();?>Employees/manage_Employees" type="button" class="btn btn-outline-primary"><i class='fas fa-user-cog'></i>&nbsp;Manage Employee</a>
                  <a href="<?= base_url();?>Employees/attendance" type="button" class="btn btn-outline-primary"><i class="fa fa-clock-o"></i>&nbsp;Attendence</a>
                </div>
			</div>
			<h4 class="page-title">Add Employee</h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="javascript:void(0);">Employees</a></li>
				<li class="breadcrumb-item active">Add Employee</li>
			</ol>
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
				<div class="col-lg-12">
					<?php $error_message = $this->session->userdata('error_message');
						if(isset($error_message)){
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
		<section class="multi-step-form">	
		<div class="steps">
    		<button class="stepss active" type="button" disabled><i class="fa fa-info-circle" aria-hidden="true"></i> &nbsp;Basic Info</button> &nbsp;<i class="fas fa-arrow-right"></i>&nbsp;
    		<button class="stepss" type="button" disabled><i class='fas fa-graduation-cap'></i> &nbsp;Educaional Info</button> &nbsp;<i class="fas fa-arrow-right"></i>&nbsp;
    		<button class="stepss" type="button" disabled><i class="fa fa-tasks" aria-hidden="true"></i> &nbsp;Job info</button> &nbsp;<i class="fas fa-arrow-right"></i> &nbsp;
    		<button class="stepss" type="button" disabled><i class="fa fa-money"></i> &nbsp;Payment Info</button> 
    	</div>
	
	<form action="<?= base_url('Employees/add');?>" method="post" enctype="multipart/form-data">
		<fieldset aria-label="Step One" id="step-1">
			<hr>
            <h4>Record</h4>
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtFirstNameBilling" class="col-sm-3 col-form-label">Staff ID</label>
                                <div class="col-sm-9">
                                    <input id="employee_code" name="employee_code" type="text" class="form-control" readonly value="<?= $maxid;?>" required tabindex="1">
                                </div>
                        </div><!--end form-group-->
                    </div><!--end col-->
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Acc. Status</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="is_active" required>
                                    <option value="1">Active</option>
                                    <option value="2">In Active</option>
                                </select>
                            </div>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="example-date-input" class="col-sm-3 col-form-label">Date</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="date" name="date" value="" id="example-date-input" required>
                            </div>
                        </div><!--end form-group-->
                    </div><!--end col-->
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Type</label>
                            <div class="col-sm-7" id="type_div">
                                <select class="form-control" id="employee_type" name="employee_type" required>
                                    <option value="">--Employee Type--</option>
                                    <?php $employee_type	=	$this->Common_model->select_where_ASC_DESC('id,type_name','tbl_employeestype',array('deleted'=>0),'type_name','ASC');
                                        if($employee_type->num_rows() > 0) {
                                        foreach($employee_type->result() as $emp_type) {
                                    ?>
                                        <option value="<?php echo $emp_type->id;?>" ><?php echo $emp_type->type_name;?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <a class="btn btn-success toggle"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                        <div class="form-group row" id="target">
                            <label class="col-sm-3 col-form-label">Add Type</label>
                            <div class="col-sm-7">
                                <input type="text" id="new_type" name="new_type" class="form-control" placeholder="Add" required>
                            </div>
                            <div id="new_type_btn" class="col-sm-2">
                                <button type="button" class="btn  btn-gradient-primary" onClick="submitEmployeetype();">Add</button>
                            </div>       
                        </div>
                        <input type="hidden" name="save_or_draft" id="save_or_draft" value="">
                    </div><!--end col-->
                </div><!--end row-->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Agreement Type</label>
                            <div class="col-sm-7" id="agreementtype_div">
                                <select class="form-control" id="agreement_type" name="agreement_type" required>
                                    <option value="">--Agreement Type--</option>
                                    <?php $agreement_type	=	$this->Common_model->select_where_ASC_DESC('id,agreement_type','tbl_agreementtype',array('deleted'=>0),'agreement_type','ASC');
                                        if($agreement_type->num_rows() > 0) {
                                        foreach($agreement_type->result() as $agree_type) {
                                    ?>
                                        <option value="<?php echo $agree_type->id;?>" ><?php echo $agree_type->agreement_type;?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <a class="btn btn-success toggle2"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                        <div class="form-group row" id="target2">
                            <label class="col-sm-3 col-form-label">New Agreement Type</label>
                            <div class="col-sm-7">
                                <input type="text" id="new_agreement_type" name="new_agreement_type" class="form-control" placeholder="New Agreement Type">
                            </div>
                            <div id="new_agreementtype_btn" class="col-sm-2">
                                    <button type="button" class="btn btn-gradient-primary" onClick="submitAgreementtype();">Add</button>
                            </div>       
                        </div>
                    </div><!--end col-->
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Department</label>
                            <div class="col-sm-7" id="department_div">
                                <select class="form-control" id="department" name="department"  required>
                                    <option value="">--Select Department--</option>
                                    <?php $department	=	$this->Common_model->select_where_ASC_DESC('id,department_name','tbl_departments',array('deleted'=>0),'department_name','ASC');
                                        if($department->num_rows() > 0) {
                                        foreach($department->result() as $dept) {
                                    ?>
                                        <option value="<?php echo $dept->id;?>" ><?php echo $dept->department_name;?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <a class="btn btn-success toggle3"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                        <div class="form-group row" id="target3">
                            <label class="col-sm-3 col-form-label">New Department</label>
                            <div class="col-sm-7">
                                <input type="text" id="new_department" name="new_department" class="form-control" placeholder="New Department" >
                            </div>
                            <div id="new_department_btn" class="col-sm-2">
                                <button type="button" class="btn btn-gradient-primary" onClick="submitDepartment();">Add</button>
                            </div>       
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Designation</label>
                            <div class="col-sm-7" id="designation_div">
                                <select class="form-control" id="designation" name="designation" required>
                                    <option value="">--Select Designation--</option>
                                    <?php $tbl_designation	=	$this->Common_model->select_where_ASC_DESC('id,designation_name','tbl_designation',array('deleted'=>0),'designation_name','ASC');
                                        if($tbl_designation->num_rows() > 0) {
                                        foreach($tbl_designation->result() as $desig) {
                                    ?>
                                        <option value="<?php echo $desig->id;?>" ><?php echo $desig->designation_name;?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <a class="btn btn-success toggle4"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                        <div class="form-group row" id="target4">
                            <label class="col-sm-3 col-form-label">New Department</label>
                            <div class="col-sm-7">
                                <input type="text" id="new_designation" name="new_designation" class="form-control" placeholder="New Designation" >
                            </div>
                            <div id="new_designation_btn" class="col-sm-2">
                                <button type="button" class="btn btn-gradient-primary" onClick="submitDesignation();">Add</button>
                            </div>       
                        </div>
                    </div><!--end col-->
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Plants</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="plants" name="plants">
                                    <option value="">--Select Plant--</option>
                                    <?php 
									    $tbl_plants	=	$this->Common_model->select_where_ASC_DESC('id,name','tbl_plants',array('deleted'=>0),'name','ASC');
                                        if($tbl_plants->num_rows() > 0) {
                                        foreach($tbl_plants->result() as $plant){
                                    ?>
                                        <option value="<?php echo $plant->id;?>"><?php echo $plant->name;?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                </div><hr>
                <h4>Personal Information</h4>
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="txtFirstNameBilling" class="col-sm-3 col-form-label">Full Name</label>
                                <div class="col-sm-9">
                                    <input id="full_name" name="full_name" type="text" class="form-control" required="required">
                                </div>
                            </div><!--end form-group-->
                        </div><!--end col-->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="txtLastNameBilling" class="col-sm-3 col-form-label">Father/Husband Name</label>
                                <div class="col-sm-9">
                                    <input id="f_hus_name" name="f_hus_name" type="text" class="form-control"  required>
                                </div>
                            </div><!--end form-group-->
                        </div><!--end col-->
                    </div><!--end row-->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Gender</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="gender"  required>
                                        <option value="">--Select Gender--</option>
                                        <option value="1">Male</option>
                                        <option value="2">Female</option>
                                    </select>
                                </div>
                            </div>
                        </div><!--end col-->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Marital Status</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="marital_status"  required>
                                        <option value="">--Select Status--</option>
                                        <option value="1">Married</option>
                                        <option value="2">Unmarried</option>
                                    </select>
                                </div>
                            </div>
                        </div><!--end col-->
                    </div><!--end row-->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Religion</label>
                                <div class="col-sm-7" id="religion_div">
                                    <select class="form-control" id="religion" name="religion" required>
                                        <option value="">--Select Religion--</option>
                                    <?php $tbl_religion	=	$this->Common_model->select_where_ASC_DESC('id,religion_name','tbl_religion',array('deleted'=>0),'religion_name','ASC');
                                        if($tbl_religion->num_rows() > 0) {
                                        foreach($tbl_religion->result() as $religion) {
                                    ?>
                                        <option value="<?php echo $religion->id;?>" ><?php echo $religion->religion_name;?></option>
                                    <?php } } ?>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <a class="btn btn-success toggle5"><i class="fa fa-plus"></i></a>
                                </div>
                            </div>
                        <div class="form-group row" id="target5">
                            <label class="col-sm-3 col-form-label">New Religion</label>
                            <div class="col-sm-7">
                                <input type="text" id="new_religion" name="new_religion" class="form-control" placeholder="New Religion">
                            </div>
                            <div id="new_religion_btn" class="col-sm-2">
                                <button type="button" class="btn btn-gradient-primary" onClick="submitReligion();">Add</button>
                            </div>       
                        </div>
                        </div><!--end col-->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="txtAddress2Billing" class="col-sm-3 col-form-label">Cnic</label>
                                <div class="col-sm-9">
                                    <input id="cnic" name="cnic" type="text" class="form-control" required>
                                </div>                                                            
                            </div><!--end form-group-->
                        </div><!--end col-->
                    </div><!--end row-->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label  class="col-sm-3 col-form-label">Date of Birth</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control" name="dob" placeholder="Date of Birth" id="date-start" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Date of Joining</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control" name="doj" placeholder="Date of Joining" id="date-end" required>
                                </div>
                            </div>
                        </div><!--end col-->
                    </div><!--end row-->

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="txtTelephoneBilling" class="col-sm-3 col-form-label">Upload CV</label>
                                <div class="col-sm-9 custom-file mb-3">
                                    <input type="file" name="resume" class="form-control" id="">
                                </div>
                            </div><!--end form-group-->
                        </div><!--end col-->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="txtTelephoneBilling" class="col-sm-3 col-form-label">Profile image</label>
                                <div class="col-sm-9 custom-file mb-3">
                                    <input type="file" name="picture" class="form-control" id="" required>
                                </div>
                            </div><!--end form-group-->
                        </div><!--end col-->
                    </div><!--end row-->
                </div><hr>
                <h4>Contact Details</h4>
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="txtFirstNameBilling" class="col-sm-3 col-form-label"> Address</label>
                                <div class="col-sm-9">
                                    <input id="address" name="address" type="text" class="form-control" required>
                                </div>
                            </div><!--end form-group-->
                        </div><!--end col-->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="txtLastNameBilling" class="col-sm-3 col-form-label">Mobile No.</label>
                                <div class="col-sm-9">
                                    <input id="mobile_no" name="mobile_no" type="text" class="form-control" required>
                                </div>
                            </div><!--end form-group-->
                        </div><!--end col-->
                    </div><!--end row-->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="txtCompanyBilling" class="col-sm-3 col-form-label">Phone No.</label>
                                <div class="col-sm-9">
                                    <input id="phone_no" name="phone_no" type="text" class="form-control">
                                </div>
                            </div><!--end form-group-->
                        </div><!--end col-->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="txtEmailAddressBilling" class="col-sm-3 col-form-label">Emergency Contact</label>
                                <div class="col-sm-9">
                                    <input id="emergency_contact" name="emergency_contact" type="text" class="form-control">
                                </div>
                            </div><!--end form-group-->
                        </div><!--end col-->
                    </div><!--end row-->
                </div><hr>
                <h4>Bank Details</h4>
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="txtFirstNameBilling" class="col-sm-3 col-form-label"> Account No.</label>
                                <div class="col-sm-9">
                                    <input id="account_no" name="account_no" type="text" class="form-control">
                                </div>
                            </div><!--end form-group-->
                        </div><!--end col-->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="txtLastNameBilling" class="col-sm-3 col-form-label">Bank Name</label>
                                <div class="col-sm-9">
                                    <input id="bank_name" name="bank_name" type="text" class="form-control">
                                </div>
                            </div><!--end form-group-->
                        </div><!--end col-->
                    </div><!--end row-->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="txtCompanyBilling" class="col-sm-3 col-form-label">Salary</label>
                                <div class="col-sm-9">
                                    <input id="salary" name="salary" type="text" class="form-control">
                                </div>
                            </div><!--end form-group-->
                        </div><!--end col-->
                    </div><!--end row-->
                </div><hr>
                <h4>Shift Information</h4>
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Shift Group</label>
                                <div class="col-sm-7" id="shifts_div">
                                    <select class="form-control" id="shift_group" name="shift_group">
                                        <option value="">--Select Shift--</option>
                                    <?php $shifts	=	$this->Common_model->select_where_ASC_DESC('id,shift_name','tbl_shifts',array('deleted'=>0),'shift_name','ASC');
                                        if($shifts->num_rows() > 0) {
                                        foreach($shifts->result() as $shif) {
                                    ?>
                                        <option value="<?php echo $shif->id;?>" ><?php echo $shif->shift_name;?></option>
                                    <?php } } ?>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <a class="btn btn-success toggle6"><i class="fa fa-plus"></i></a>
                                </div>
                            </div>
                            <div class="form-group row" id="target6">
                            <label class="col-sm-3 col-form-label">New Shift</label>
                            <div class="col-sm-7">
                                <input type="text" id="new_shift_group" name="new_shift_group" class="form-control" placeholder="New Shift">
                            </div>
                            <div id="new_shift_btn" class="col-sm-2">
                                <button type="button" class="btn btn-gradient-primary" onClick="submitShifts();">Add</button>
                            </div>       
                        </div>
                        </div><!--end col-->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="example-date-input" class="col-sm-3 col-form-label">Date</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="date" name="shift_date" value="2011-08-19" id="mdate">
                                </div>
                            </div><!--end form-group-->
                        </div><!--end col-->
                    </div>
                </div> 
                <hr>
			<p>
				<button class="btn btn-gradient-primary btn-next" type="button" aria-controls="step-2">Next</button>
			</p>
		</fieldset>
		
		<fieldset aria-label="Step Two" id="step-2"><hr>
            <h4>Educational Information</h4>
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Level</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="degree_level">
                                    <option value="Master" id="masters">Masters</option>
                                    <option value="Graduate" id="graduate">Graduate</option>
                                    <option value="Intermediate" id="intermediate">Intermediate</option>
                                    <option value="Matric" id="matric">Matric</option>
                                    <option value="Under matric" id="under_matric">Under Matric</option>
                                </select>
                            </div>
                        </div>
                    </div><!--end col-->
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="example-date-input" class="col-sm-3 col-form-label" name="start">Start Date</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="date" name="degree_start_date" id="start">
                            </div>
                        </div><!--end form-group-->
                    </div><!--end col-->
                </div><!--end row-->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="example-date-input" class="col-sm-3 col-form-label" name="end">End Date</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="date" name="degree_end_date" id="end">
                            </div>
                        </div><!--end form-group-->
                    </div><!--end col-->
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Degree Name</label>
                            <div class="col-sm-9">
                            <input class="form-control" type="text" name="degree_name">
                            </div>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Major Subjects</label>
                            <div class="col-sm-9">
                                <input name="major_subjects" type="text" class="form-control">
                            </div>                                                            
                        </div><!--end form-group-->
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtAddress2Billing" class="col-sm-3 col-form-label">Institute Name</label>
                            <div class="col-sm-9">
                                <input id="txtLastNameBilling" name="institute_name"type="text" class="form-control">
                            </div>                                                            
                        </div><!--end form-group-->
                    </div><!--end col-->
                </div><!--end row-->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtAddress2Billing" class="col-sm-3 col-form-label">Obtained GPA/Marks</label>
                            <div class="col-sm-9">
                                <input id="txtLastNameBilling" name="obtained_gpa" type="text" class="form-control">
                            </div>                                                            
                        </div><!--end form-group-->
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtAddress2Billing" class="col-sm-3 col-form-label">Total GPA/Marks</label>
                            <div class="col-sm-9">
                                <input id="txtLastNameBilling" name="total_gpa" type="text" class="form-control">
                            </div>                                                            
                        </div><!--end form-group-->
                    </div><!--end col-->
                </div><!--end row-->
                
            </div><hr>
            <p>
                <button class="btn btn-gradient-primary btn-prev" type="button" aria-controls="step-1">Previous</button>
                <button class="btn btn-gradient-primary btn-next" type="button" aria-controls="step-3">Next</button>
            </p>
        </fieldset>
		
		<fieldset aria-label="Step Three" id="step-3">
        <hr>
            <h4>Previous Job Information</h4>
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtAddress2Billing" class="col-sm-3 col-form-label">Job Held</label>
                            <div class="col-sm-9">
                                <input id="job_held" name="job_held" type="text" class="form-control">
                            </div>                                                            
                        </div><!--end form-group-->
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="example-date-input" class="col-sm-3 col-form-label" name="start">Start Date</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="date" name="job_start_date" id="start_job">
                            </div>
                        </div><!--end form-group-->
                    </div><!--end col-->
                </div>
                <div class="row">                
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="example-date-input" class="col-sm-3 col-form-label" name="start">End Date</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="date" name="job_end_date" id="End_job">
                            </div>
                        </div><!--end form-group-->
                    </div><!--end col-->
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtAddress2Billing" class="col-sm-3 col-form-label">Pay Draws</label>
                            <div class="col-sm-9">
                                <input id="pay_draw" name="pay_draw" type="text" class="form-control">
                            </div>                                                            
                        </div><!--end form-group-->
                    </div> 
                </div>     
            </div>
            <hr>
            <p>
                <button class="btn btn-gradient-primary btn-prev" type="button" aria-controls="step-2">Previous</button>
                <button class="btn btn-gradient-primary btn-next" type="button" aria-controls="step-4">Next</button>
            </p>
        </fieldset>
		
		<fieldset aria-label="Step 4?" id="step-4">
        <hr>
            <h4>Previous Salary Information</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="txtNameCard" class="col-lg-3 col-form-label">Previous Salary</label>
                                <div class="col-lg-9">
                                    <input id="txtNameCard" name="previous_salary" type="text" class="form-control">
                                </div>
                            </div><!--end form-group-->
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="basic_pay" class="col-lg-3 col-form-label">Basic Pay</label>
                                <div class="col-lg-9">
                                    <input id="basic_pay" name="basic_pay" type="text" class="form-control">
                                </div>
                            </div><!--end form-group-->
                        </div>
                        <!--<div class="col-md-6">-->
                        <!--    <div class="form-group row">-->
                        <!--        <label for="conv_allow" class="col-lg-3 col-form-label">Conv. Allow.</label>-->
                        <!--        <div class="col-lg-9">-->
                        <!--            <input id="conv_allow" name="conv_allow" type="text" class="form-control">-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--</div>-->
                        <!--<div class="col-md-6">-->
                        <!--    <div class="form-group row">-->
                        <!--        <label for="house_rent" class="col-lg-3 col-form-label">House Rent</label>-->
                        <!--        <div class="col-lg-9">-->
                        <!--            <input id="house_rent" name="house_rent" type="text" class="form-control">-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--</div>-->
                        <!--<div class="col-md-6">-->
                        <!--    <div class="form-group row">-->
                        <!--        <label for="entertainment" class="col-lg-3 col-form-label">Entertainment</label>-->
                        <!--        <div class="col-lg-9">-->
                        <!--            <input id="entertainment" name="entertainment" type="text" class="form-control">-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--</div>-->
                        <!--<div class="col-md-6">-->
                        <!--    <div class="form-group row">-->
                        <!--        <label for="med_allow" class="col-lg-3 col-form-label">Med. Allow.</label>-->
                        <!--        <div class="col-lg-9">-->
                        <!--            <input id="med_allow" name="med_allow" type="text" class="form-control">-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--</div>-->
                        <!--<div class="col-md-6">-->
                        <!--    <div class="form-group row">-->
                        <!--        <label for="other" class="col-lg-3 col-form-label">Other</label>-->
                        <!--        <div class="col-lg-9">-->
                        <!--            <input id="other" name="other" type="text" class="form-control">-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--</div>-->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="gross_pay" class="col-lg-3 col-form-label">Gross Pay</label>
                                <div class="col-lg-9">
                                    <input id="gross_pay" name="gross_pay" type="text" class="form-control">
                                </div>
                            </div><!--end form-group-->
                        </div>
                    </div>
                    <!--<hr>-->
                    <!--<div class="row">-->
                    <!--    <div class="col-md-12">-->
                    <!--        <h4>Allowed Leaves</h4>-->
                    <!--        <div class="row">-->
                    <!--            <div class="col-md-6">-->
                    <!--                <div class="form-group row">-->
                    <!--                    <label for="paid" class="col-lg-3 col-form-label">Paid Leaves</label>-->
                    <!--                    <div class="col-lg-9">-->
                    <!--                        <input id="paid" name="paid_leaves" type="text" class="form-control">-->
                    <!--                    </div>-->
                    <!--                </div>-->
                    <!--            </div>-->
                    <!--            <div class="col-md-6">-->
                    <!--                <div class="form-group row">-->
                    <!--                    <label for="unpaid" class="col-lg-3 col-form-label">Unpaid Leaves</label>-->
                    <!--                    <div class="col-lg-9">-->
                    <!--                        <input id="unpaid" name="unpaid_leaves" type="text" class="form-control">-->
                    <!--                    </div>-->
                    <!--                </div>-->
                    <!--            </div>-->
                    <!--        </div>-->
                    <!--    </div>-->
                    <!--</div><hr>-->
                    <!--<div class="row">                            -->
                    <!--    <div class="col-md-12">-->
                    <!--        <h4>Over Time</h4>-->
                    <!--        <div class="row">-->
                    <!--            <div class="radio radio-info form-check-inline">-->
                    <!--                <input type="radio" id="inlineRadio1" value="1" name="overtime" checked="">-->
                    <!--                <label for="inlineRadio1"> Allowed </label>-->
                    <!--            </div>-->
                    <!--            <div class="radio form-check-inline">-->
                    <!--                <input type="radio" id="inlineRadio2" value="0" name="overtime">-->
                    <!--                <label for="inlineRadio2"> Not Allowed </label>-->
                    <!--            </div>-->
                    <!--        </div>-->
                    <!--    </div>-->
                    <!--</div>-->
                </div><!--end col-->
            </div><hr>
            <div class="row">                    
                <div class="col-md-12">
                    <h4>Deductions</h4>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="eobi" class="col-lg-3 col-form-label">EOBI</label>
                                <div class="col-lg-9">
                                    <input id="eobi" name="eobi" type="text" class="form-control">
                                </div>
                            </div><!--end form-group-->
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="social_security" class="col-lg-3 col-form-label">Social Security</label>
                                <div class="col-lg-9">
                                    <input id="social_security" name="social_security" type="text" class="form-control">
                                </div>
                            </div><!--end form-group-->
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="insurance" class="col-lg-3 col-form-label">Insurance</label>
                                <div class="col-lg-9">
                                    <input id="insurance" name="insurance" type="text" class="form-control">
                                </div>
                            </div><!--end form-group-->
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="t_deductions" class="col-lg-3 col-form-label">Total Deductions</label>
                                <div class="col-lg-9">
                                    <input id="t_deductions" name="t_deductions" type="text" class="form-control">
                                </div>
                            </div><!--end form-group-->
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="net_payment" class="col-lg-3 col-form-label">Net Payment</label>
                                <div class="col-lg-9">
                                    <input id="net_payment" name="net_payment" type="text" class="form-control">
                                </div>
                            </div><!--end form-group-->
                        </div>
                    </div><!--end form-group-->
                </div><!--end col-->
            </div><!--end row-->
            <hr>
            <p>
                <button class="btn btn-default btn-prev" type="button" aria-controls="step-2">Previous</button>&nbsp;
                <button class="btn btn-success" type="submit">Submit</button> &nbsp;
                <button class="btn btn-default btn-edit" type="button">Edit</button> &nbsp;
                <button class="btn btn-danger" type="reset">Start Over</button>
            </p>
        </fieldset>
	</form>		
	</section>								
    </div><!--end card-body-->
    </div><!--end card-->
</div><!--end col-->
</div><!--end row--> 
</div>
</div><!-- container -->                