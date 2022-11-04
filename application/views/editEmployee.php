<style>
/* do not group these rules */
*::-webkit-input-placeholder {
    color: grey !important;
}
*:-moz-placeholder {
    /* FF 4-18 */
    color: grey !important;
    opacity: 1;
}
*::-moz-placeholder {
    /* FF 19+ */
    color: grey !important;
    opacity: 1;
}
*:-ms-input-placeholder {
    /* IE 10+ */
    color: grey !important;
}
*::-ms-input-placeholder {
    /* Microsoft Edge */
    color: grey !important;
}
*::placeholder {
    /* modern browser */
    color: grey !important;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #bac1dc;
    line-height: 28px;
    padding-top: 2px;
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
	min-height: 36px;
}
.select2-container--default .select2-selection--multiple {
    background-color: #212744;
    border: 1px solid #575252;
    border-radius: 4px;
	min-height: 36px;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #bac1dc;
    line-height: 28px;
    padding-top: 2px;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #212744;
    font-size: 10px;
}
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
    #target7{
        display:flex;
    }
    .stepss{
        background-color: rgba(80,110,228,0.1);
        color: #506ee4;
        padding: 0 20px 0 0;
        -webkit-box-shadow: 0px 0px 0px 2.25px rgb(80 110 228 / 50%);
        box-shadow: 0px 0px 0px 2.25px rgb(80 110 228 / 50%);
    }
    .stepss:active{
        background: linear-gradient(14deg, #506ee4 0%, rgba(80,110,228,0.6));
        color: #fff;
        padding: 2px 20px 2px 2px;
        -webkit-box-shadow: 0px 3px 10px 0 rgb(80 110 228 / 40%);
        box-shadow: 0px 3px 10px 0 rgb(80 110 228 / 40%);
    }
    #agree_type, #emp_type, #date_record, #image, #cv, #marital, #reli, #e_contact, #p_no, #adres, #start_date, #end_date, #maj_sub, #obt_gpa, #t_gpa ,#inst_name {
    display:none;
}
.btn-success {
    border: 1px solid #575252;
    background-color: #212744;
    box-shadow:none !important;
}
.btn-success:hover {
    border: 1px solid #575252;
    background-color: #212744;
    box-shadow: none !important;
}
.btn-success:focus, .btn-success.focus {
    color: #fff;
    background-color: #575252 !important;
    border-color: #212744  !important;
    -webkit-box-shadow: 0 0 0 0.2rem rgb(16 22 58);
    box-shadow: 0 0 0 0.2rem rgb(16 22 58);
}
.btn-success:not(:disabled):not(.disabled):active, .btn-success:not(:disabled):not(.disabled).active, .show>.btn-success.dropdown-toggle {
    background-color: #575252 !important;
    border-color: #575252  !important;
}
.ti-arrow-circle-down , .ti-arrow-circle-up{
    font-size: 30px !important;
    display: block;
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
                  <a href="<?= base_url();?>Employees/manage_Employees" type="button" class="btn btn-outline-primary"><i class='fa fa-eye'></i>&nbsp;View Employees</a>
                  <a href="<?= base_url();?>Employees/employee_report" type="button" class="btn btn-outline-primary"><i class="fa fa-bar-chart"></i>&nbsp;Employees Report</a>
                  <a href="<?= base_url();?>Employees/manage_trash" type="button" class="btn btn-outline-primary"><i class="fa fa-trash"></i>&nbsp;Trashed Employees</a>
                </div>
			</div>
			<!--<h4 class="page-title">Edit Employee</h4>-->
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
    		<button class="stepss" type="button" disabled><i class="fa fa-tasks" aria-hidden="true"></i> &nbsp;Job info</button>
    		<!--<button class="stepss" type="button" disabled><i class="fa fa-money"></i> &nbsp;Payment Info</button> -->
    	</div>
	
	<form action="<?= base_url('Employees/editProcess');?>" method="post" enctype="multipart/form-data">
		<fieldset aria-label="Step One" id="step-1">
			<hr>
            <h4>Record</h4>
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtFirstNameBilling" class="col-sm-3 col-form-label">Employee ID <i class="text-danger">*</i></label>
                                <div class="col-sm-9">
                                    <input id="employee_code" name="employee_code" type="text" class="form-control" readonly value="<?= $employee['employee_code'];?>" required tabindex="1">
                                </div>
                        </div><!--end form-group-->
                    </div><!--end col-->
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Acc. Status</label>
                            <div class="col-sm-9">
                                <select class="select2 form-control mb-3 custom-select" name="is_active" tabindex="2">
                                    <option value="1" <? if($employee['is_active'] == 1){ ?> selected <? } ?>>Active</option>
                                    <option value="2" <? if($employee['is_active'] == 2){ ?> selected <? } ?>>In Active</option>
                                </select>
                            </div>
                        </div>
                    </div><!--end col-->
                <!--</div><!--end row-->
                <!--<div class="row">-->
                    <div class="col-md-6" id="date_record">
                        <div class="form-group row">
                            <label for="example-date-input" class="col-sm-3 col-form-label">Date</label>
                            <div class="col-sm-9">
                                <input class="form-control datepicker" type="text" name="date" value="<?=date("d-m-Y",strtotime($employee['date']));?>" id="example-date-input">
                            </div>
                        </div><!--end form-group-->
                    </div><!--end col-->
                    <div class="col-md-6" id="emp_type">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Type</label>
                            <div class="col-sm-7" id="type_div">
                                <select class="select2 form-control mb-3 custom-select" id="employee_type" name="employee_type">
                                    <option value="">--Employee Type--</option>
                                    <?php $employee_type	=	$this->Common_model->select_where_ASC_DESC('id,type_name','tbl_employeestype',array('deleted'=>0),'type_name','ASC');
                                        if($employee_type->num_rows() > 0) {
                                        foreach($employee_type->result() as $emp_type) {
                                    ?>
                                        <option value="<?php echo $emp_type->id;?>" <? if($emp_type->id == $employee['employee_type']){ ?> selected <? } ?>><?php echo $emp_type->type_name;?></option>
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
                                <input type="text" id="new_type" name="new_type" class="form-control" placeholder="Add">
                            </div>
                            <div id="new_type_btn" class="col-sm-2">
                                    <button type="button" class="btn  btn-gradient-primary" onClick="submitEmployeetype();">Add</button>
                            </div>       
                        </div>
                        <input type="hidden" name="save_or_draft" id="save_or_draft" value="">
                    </div><!--end col-->
                <!--</div><!--end row-->
                <!--<div class="row">-->
                    <div class="col-md-6" id="agree_type">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Agreement Type  <i class="text-danger">*</i></label>
                            <div class="col-sm-7" id="agreementtype_div">
                                <select class="select2 form-control mb-3 custom-select" id="agreement_type" name="agreement_type">
                                    <option value="">--Agreement Type--</option>
                                    <?php $agreement_type	=	$this->Common_model->select_where_ASC_DESC('id,agreement_type','tbl_agreementtype',array('deleted'=>0),'agreement_type','ASC');
                                        if($agreement_type->num_rows() > 0) {
                                        foreach($agreement_type->result() as $agree_type) {
                                    ?>
                                        <option value="<?php echo $agree_type->id;?>" <? if($agree_type->id == $employee['agreement_type']){ ?> selected <? } ?>><?php echo $agree_type->agreement_type;?></option>
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
                            <label class="col-sm-3 col-form-label">Department <i class="text-danger">*</i></label>
                            <div class="col-sm-7" id="department_div">
                                <select class="select2 form-control mb-3 custom-select" id="department" name="department" tabindex="3">
                                    <option value="">--Select Department--</option>
                                    <?php $department	=	$this->Common_model->select_where_ASC_DESC('id,department_name','tbl_departments',array('deleted'=>0),'department_name','ASC');
                                        if($department->num_rows() > 0) {
                                        foreach($department->result() as $dept) {
                                    ?>
                                        <option value="<?php echo $dept->id;?>" <? if($dept->id == $employee['department']){ ?> selected <? } ?> ><?php echo $dept->department_name;?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                            <? if(!empty($role_permissions) && in_array(95,$role_permissions)) { ?>
                            <div class="col-sm-2">
                                <a class="btn btn-success toggle3"><i class="fa fa-plus"></i></a>
                            </div>
                            <? } ?>
                        </div>
                        <div class="form-group row" id="target3">
                            <label class="col-sm-3 col-form-label">New Department</label>
                            <div class="col-sm-7">
                                <input type="text" id="new_department" name="new_department" class="form-control" placeholder="New Department">
                            </div>
                            <div id="new_department_btn" class="col-sm-2">
                                <button type="button" class="btn btn-gradient-primary" onClick="submitDepartment();">Add</button>
                            </div>       
                        </div>
                    </div><!--end col-->
                <!--</div><!--end row-->
                <!--<div class="row">-->
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Designation <i class="text-danger">*</i></label>
                            <div class="col-sm-7" id="designation_div">
                                <select class="select2 form-control mb-3 custom-select" id="designation" name="designation" tabindex="4">
                                    <option value="">--Select Designation--</option>
                                    <?php $tbl_designation	=	$this->Common_model->select_where_ASC_DESC('id,designation_name','tbl_designation',array('deleted'=>0),'designation_name','ASC');
                                        if($tbl_designation->num_rows() > 0) {
                                        foreach($tbl_designation->result() as $desig) {
                                    ?>
                                        <option value="<?php echo $desig->id;?>" <? if($desig->id == $employee['designation']){ ?> selected <? } ?>><?php echo $desig->designation_name;?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                            <? if(!empty($role_permissions) && in_array(99,$role_permissions)) { ?>
                            <div class="col-sm-2">
                                <a class="btn btn-success toggle4"><i class="fa fa-plus"></i></a>
                            </div>
                            <? } ?>
                        </div>
                        <div class="form-group row" id="target4">
                            <label class="col-sm-3 col-form-label">New Department</label>
                            <div class="col-sm-7">
                                <input type="text" id="new_designation" name="new_designation" class="form-control" placeholder="New Designation">
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
                                <select class="select2 form-control mb-3 custom-select" id="plants" name="plants" tabindex="5">
                                    <option value="">--Select Plant--</option>
                                    <?php 
									    $tbl_plants	=	$this->Common_model->select_where_ASC_DESC('fld_id,fld_location','tbl_locations',array('fld_status'=>1),'fld_location','ASC');
                                        if($tbl_plants->num_rows() > 0) {
                                        foreach($tbl_plants->result() as $plant){
                                    ?>
                                        <option value="<?php echo $plant->fld_id;?>" <? if($plant->fld_id == $employee['plants']){ ?> selected <? } ?>><?php echo $plant->fld_location;?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div><span id="dots"></span>
                <div class="row">
                    <button class="btn btn-success" type="button" onclick="myFunction()" id="record" style="margin-left: auto;"><i class="ti-arrow-circle-down" style="font-size:24px"></i></button>
                </div>
                </div><hr>
                <h4>Personal Information</h4>
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="txtFirstNameBilling" class="col-sm-3 col-form-label">Full Name <i class="text-danger">*</i></label>
                                <div class="col-sm-9">
                                    <input id="full_name" name="full_name" type="text" class="form-control" value="<?=$employee['full_name'];?>" required="required" placeholder="Afzal" tabindex="6">
                                </div>
                            </div><!--end form-group-->
                        </div><!--end col-->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="txtLastNameBilling" class="col-sm-3 col-form-label">Father/Husband Name <i class="text-danger">*</i></label>
                                <div class="col-sm-9">
                                    <input id="f_hus_name" name="f_hus_name" type="text" value="<?=$employee['f_hus_name'];?>" class="form-control" placeholder="Ahmed" tabindex="7">
                                </div>
                            </div><!--end form-group-->
                        </div><!--end col-->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="txtLastNameBilling" class="col-sm-3 col-form-label">Email <i class="text-danger">*</i></label>
                                <div class="col-sm-9">
                                    <input id="email" name="email" type="email" class="form-control" value="<?=$employee['email'];?>" required placeholder="abc@mail.com" tabindex="8">
                                </div>
                            </div><!--end form-group-->
                        </div>
                    <!--</div><!--end row-->
                    <!--<div class="row">-->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Gender</label>
                                <div class="col-sm-9">
                                    <select class="select2 form-control mb-3 custom-select" name="gender" tabindex="9">
                                        <option value="">--Select Gender--</option>
                                        <option value="1" <? if($employee['gender'] == 1){ ?> selected <? } ?>>Male</option>
                                        <option value="2" <? if($employee['gender'] == 2){ ?> selected <? } ?>>Female</option>
                                    </select>
                                </div>
                            </div>
                        </div><!--end col-->
                        <div class="col-md-6" id="marital">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Marital Status</label>
                                <div class="col-sm-9">
                                    <select class="select2 form-control mb-3 custom-select" name="marital_status">
                                        <option value="">--Select Status--</option>
                                        <option value="1" <? if($employee['marital_status'] == 1){ ?> selected <? } ?>>Married</option>
                                        <option value="2" <? if($employee['marital_status'] == 2){ ?> selected <? } ?>>Unmarried</option>
                                    </select>
                                </div>
                            </div>
                        </div><!--end col-->
                    <!--</div><!--end row-->
                    <!--<div class="row">-->
                        <div class="col-md-6" id="reli">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Religion</label>
                                <div class="col-sm-7" id="religion_div">
                                    <select class="select2 form-control mb-3 custom-select" id="religion" name="religion">
                                        <option value="">--Select Religion--</option>
                                    <?php $tbl_religion	=	$this->Common_model->select_where_ASC_DESC('id,religion_name','tbl_religion',array('deleted'=>0),'religion_name','ASC');
                                        if($tbl_religion->num_rows() > 0) {
                                        foreach($tbl_religion->result() as $religion) {
                                    ?>
                                        <option value="<?php echo $religion->id;?>" <? if($religion->id == $employee['religion']){ ?> selected <? } ?>><?php echo $religion->religion_name;?></option>
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
                                    <input id="cnic" name="cnic" data-inputmask="'mask': '99999-9999999-9'" class="form-control" placeholder="XXXXX-XXXXXXX-X"  type="text" value="<?=$employee['cnic'];?>" tabindex="10">
                                </div>                                                            
                            </div><!--end form-group-->
                        </div><!--end col-->
                    <!--</div><!--end row-->
                    <!--<div class="row">-->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label  class="col-sm-3 col-form-label">Date of Birth</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control datepicker" name="dob" value="<?=date("d-m-Y",strtotime($employee['dob']));?>" placeholder="Date of Birth" id="date-start"tabindex="11">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Date of Joining</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control datepicker" name="joining_date" value="<?=date("d-m-Y",strtotime($employee['joining_date']));?>" placeholder="Date of Joining" id="date-end" tabindex="12">
                                </div>
                            </div>
                        </div><!--end col-->
                    <!--</div><!--end row-->

                    <!--<div class="row">-->
                        <div class="col-md-6" id="cv">
                            <div class="form-group row">
                                <label for="txtTelephoneBilling" class="col-sm-3 col-form-label">Upload CV</label>
                                <div class="col-sm-9 custom-file mb-3">
                                    <input type="file" name="resume" class="form-control" id="resumee" accept=".pdf,.docx,doc">
								    <? if(!empty($employee['resume'])) { ?>
									<br>	
									<a href="<?=base_url()?>/assets/uploads/resumes/<?=$employee['resume'];?>" target="_blank">Show Resume</a>
									<? } ?>
								</div>
                            </div><!--end form-group-->
                        </div><!--end col-->
                        <div class="col-md-6" id="image">
                            <div class="form-group row">
                                <label for="txtTelephoneBilling" class="col-sm-3 col-form-label">Profile image</label>
                                <div class="col-sm-9 mb-3">
									<input type="file" name="picture" class="form-control" id="">
									<? if(!empty($employee['picture'])) { ?>
									<br>	
									<img width="100" src="<?=base_url()?>/assets/uploads/profile_pictures/thumbs/s_<?=$employee['picture'];?>" alt="N/A" >
									<? } ?>
                                </div>
							</div><!--end form-group-->
							
                        </div><!--end col-->
                    </div><!--end row--><span id="dots2"></span>
                    <div class="row">
                        <button class="btn btn-success" type="button" onclick="myFunction1()" id="personal" style="margin-left: auto;"><i class="ti-arrow-circle-down"style="font-size:24px"></i></button>
                    </div>
                </div><hr>
                <h4>Contact Details</h4>
                <div class="container">
                    <div class="row">
                        <div class="col-md-6"  id="adres">
                            <div class="form-group row">
                                <label for="txtFirstNameBilling" class="col-sm-3 col-form-label"> Address</label>
                                <div class="col-sm-9">
                                    <input id="address" name="address" type="text" value="<?=$employee['address'];?>" class="form-control">
                                </div>
                            </div><!--end form-group-->
                        </div><!--end col-->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="txtLastNameBilling" class="col-sm-3 col-form-label">Mobile No.</label>
                                <div class="col-sm-9">
                                    <input id="mobile_no" name="mobile_no" value="<?=$employee['mobile_no'];?>" data-inputmask="'mask': '0399-99999999'"  type = "text" maxlength = "12"  class="form-control" placeholder="03XX-XXXXXXX" tabindex="13">
                                </div>
                            </div><!--end form-group-->
                        </div><!--end col-->
                    <!--</div><!--end row-->
                    <!--<div class="row">-->
                        <div class="col-md-6"  id="p_no">
                            <div class="form-group row">
                                <label for="txtCompanyBilling" class="col-sm-3 col-form-label">Phone No.</label>
                                <div class="col-sm-9">
                                    <input id="phone_no" name="phone_no" value="<?=$employee['phone_no'];?>" type="text" class="form-control" required>
                                </div>
                            </div><!--end form-group-->
                        </div><!--end col-->
                        <div class="col-md-6" id="e_contact">
                            <div class="form-group row">
                                <label for="txtEmailAddressBilling" class="col-sm-3 col-form-label">Emergency Contact</label>
                                <div class="col-sm-9">
                                    <input id="emergency_contact" name="emergency_contact" value="<?=$employee['emergency_contact'];?>" type="text" class="form-control">
                                </div>
                            </div><!--end form-group-->
                        </div><!--end col-->
                    </div><!--end row--><span id="dots3"></span>
                    <div class="row">
                    <button class="btn btn-success" type="button" onclick="myFunction2()" id="contact" style="margin-left: auto;"><i class="ti-arrow-circle-down"style="font-size:24px"></i></button>
                </div>
                </div><hr>
                <h4>Bank Details</h4>
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="txtFirstNameBilling" class="col-sm-3 col-form-label"> Account No.</label>
                                <div class="col-sm-9">
                                    <input id="account_no" name="account_no" value="<?=$employee['account_no'];?>" type="text" class="form-control" placeholder="1234567890123" tabindex="14">
                                </div>
                            </div><!--end form-group-->
                        </div><!--end col-->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="txtLastNameBilling" class="col-sm-3 col-form-label">Bank Name</label>
                                <div class="col-sm-7" id="bank_div">
                                    <!--<input id="bank_name" name="bank_name" type="text" class="form-control">-->
                                    <select class="select2 form-control mb-3 custom-select" id="bank_name" name="bank_name" placeholder="NBP" tabindex="15">
                                       <option value="">--Select Bank--</option>
                                    <?php $tbl_bank	=	$this->Common_model->select_where_ASC_DESC('fld_id,fld_bank','tbl_banks_employees',array('fld_status'=>1),'fld_bank','ASC');
                                        if($tbl_bank->num_rows() > 0) {
                                        foreach($tbl_bank->result() as $bank) {
                                    ?>
                                        <option value="<?php echo $bank->fld_id;?>" <? if($bank->fld_id == $employee['bank_name']){ ?> selected <? } ?>><?php echo $bank->fld_bank;?></option>
                                    <?php } } ?>
                                   </select>
                                </div>
                                <? if(!empty($role_permissions) && in_array(87,$role_permissions)) { ?>
                                <div class="col-sm-2">
                                    <a class="btn btn-success toggle7"><i class="fa fa-plus"></i></a>
                                </div>
                                <? } ?>
                            </div><!--end form-group-->
                            
                            <div class="form-group row" id="target7">
                                <label class="col-sm-3 col-form-label">New Bank</label>
                                <div class="col-sm-7">
                                    <input type="text" id="new_bank" name="new_bank" class="form-control" placeholder="New Bank Name" placeholder="NBP">
                                </div>
                                <div id="new_bank_btn" class="col-sm-2">
                                    <button type="button" class="btn  btn-gradient-primary" onClick="submitBank();">Add</button>
                                </div>       
                            </div>
                            
                        </div><!--end col-->
                    <!--</div><!--end row-->
                    <!--<div class="row">-->

                    </div><!--end row-->
                </div><hr>
                <h4>Shift Information</h4>
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Shift Group</label>
                                <div class="col-sm-7" id="shifts_div">
                                    <select class="select2 form-control mb-3 custom-select" id="shift_group" name="shift_group" tabindex="16">
                                        <option value="">--Select Shift--</option>
                                    <?php $shifts	=	$this->Common_model->select_where_ASC_DESC('id,shift_name','tbl_shifts',array('deleted'=>0),'shift_name','ASC');
                                        if($shifts->num_rows() > 0) {
                                        foreach($shifts->result() as $shif) {
                                    ?>
                                        <option value="<?php echo $shif->id;?>" <? if($shif->id == $employee['shift_group']){ ?> selected <? } ?>><?php echo $shif->shift_name;?></option>
                                    <?php } } ?>
                                    </select>
                                </div>
                                <? if(!empty($role_permissions) && in_array(103,$role_permissions)) { ?>
                                <div class="col-sm-2">
                                    <a class="btn btn-success toggle6"><i class="fa fa-plus"></i></a>
                                </div>
                                <? } ?>
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
                    </div>
                </div> 
                <hr>
			<p>
				<button class="btn btn-success btn-default btn-next" type="button" aria-controls="step-2" tabindex="17">Next</button>
			</p>
		</fieldset>
		
		<fieldset aria-label="Step Two" id="step-2"><hr>
            <h4>Recent Educational Qualification</h4>
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Level</label>
                            <div class="col-sm-9">
                                <select class="select2 form-control mb-3 custom-select" name="degree_level" tabindex="18">
                                    <option value="Master" id="masters" <? if($employee['degree_level'] == "Master"){ ?> selected <? } ?>>Masters</option>
                                    <option value="Graduate" id="graduate" <? if($employee['degree_level'] == "Graduate"){ ?> selected <? } ?>>Graduate</option>
                                    <option value="Intermediate" id="intermediate" <? if($employee['degree_level'] == "Intermediate"){ ?> selected <? } ?>>Intermediate</option>
                                    <option value="Matric" id="matric" <? if($employee['degree_level'] == "Matric"){ ?> selected <? } ?>>Matric</option>
                                    <option value="Under matric" id="under_matric" <? if($employee['degree_level'] == "Under matric"){ ?> selected <? } ?>>Under Matric</option>
                                </select>
                            </div>
                        </div>
                    </div><!--end col-->
                    <div class="col-md-6" id="start_date">
                        <div class="form-group row">
                            <label for="example-date-input" class="col-sm-3 col-form-label" name="start">Start Date</label>
                            <div class="col-sm-9">
                                <input class="form-control datepicker" type="text" name="degree_start_date" value="<?=date("d-M-Y",strtotime($employee['degree_start_date']));?>" id="start">
                            </div>
                        </div><!--end form-group-->
                    </div><!--end col-->
                <!--</div><!--end row-->
                <!--<div class="row">-->
                    <div class="col-md-6" id="end_date">
                        <div class="form-group row">
                            <label for="example-date-input" class="col-sm-3 col-form-label" name="end">End Date</label>
                            <div class="col-sm-9">
                                <input class="form-control datepicker" type="text" name="degree_end_date" value="<?=date("d-M-Y",strtotime($employee['degree_end_date']));?>" id="end">
                            </div>
                        </div><!--end form-group-->
                    </div><!--end col-->
                    <div class="col-md-6" >
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Degree Name</label>
                            <div class="col-sm-9">
                            <input class="form-control" type="text" name="degree_name" value="<?=$employee['degree_name'];?>" placeholder="BS-IT"  tabindex="19">
                            </div>
                        </div>
                    </div><!--end col-->
                <!--</div><!--end row-->
                <!--<div class="row">-->
                    <div class="col-md-6" id="maj_sub">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Major Subjects</label>
                            <div class="col-sm-9">
                                <input name="major_subjects" type="text" class="form-control" value="<?=$employee['major_subjects'];?>" Placeholder="Software Engineering">
                            </div>                                                            
                        </div><!--end form-group-->
                    </div>
                    <div class="col-md-6" id="inst_name">
                        <div class="form-group row">
                            <label for="txtAddress2Billing" class="col-sm-3 col-form-label">Institute Name</label>
                            <div class="col-sm-9">
                                <input id="txtLastNameBilling" name="institute_name"type="text" class="form-control" value="<?=$employee['institute_name'];?>" Placeholder="Comsats University">
                            </div>                                                            
                        </div><!--end form-group-->
                    </div><!--end col-->
                <!--</div><!--end row-->
                <!--<div class="row">-->
                    <div class="col-md-6" id="obt_gpa">
                        <div class="form-group row">
                            <label for="txtAddress2Billing" class="col-sm-3 col-form-label">Obtained GPA/Marks</label>
                            <div class="col-sm-9">
                                <input id="txtLastNameBilling" name="obtained_gpa" type="text" class="form-control" value="<?=$employee['obtained_gpa'];?>">
                            </div>                                                            
                        </div><!--end form-group-->
                    </div>
                    <div class="col-md-6" id="t_gpa">
                        <div class="form-group row">
                            <label for="txtAddress2Billing" class="col-sm-3 col-form-label">Total GPA/Marks</label>
                            <div class="col-sm-9">
                                <input id="txtLastNameBilling" name="total_gpa" type="text" class="form-control" value="<?=$employee['total_gpa'];?>">
                            </div>                                                            
                        </div><!--end form-group-->
                    </div><!--end col-->
                </div><!--end row--><span id="span3"></span>
                <div class="row">
                    <button class="btn btn-success" type="button" onclick="myFunction3()" id="education" style="margin-left: auto;"><i class="ti-arrow-circle-down" style="font-size:24px"></i></button>
                </div>
            </div><hr>
            <p>
                <button class="btn btn-gradient-primary btn-prev" type="button" aria-controls="step-1" tabindex="20">Previous</button>
                <button class="btn btn-gradient-primary btn-next" type="button" aria-controls="step-3" tabindex="21">Next</button>
            </p>
        </fieldset>
		
		<fieldset aria-label="Step Three" id="step-3">
        <hr>
            <h4>Previous Job Information</h4>
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtAddress2Billing" class="col-sm-3 col-form-label">Organisation Name</label>
                            <div class="col-sm-9">
                                <input id="job_held" name="job_held" type="text" class="form-control" Placeholder="Pakistan State oil" value="<?=$employee['job_held'];?>" tabindex="22">
                            </div>                                                            
                        </div><!--end form-group-->
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtAddress2Billing" class="col-sm-3 col-form-label">Designation</label>
                            <div class="col-sm-9">
                                <input id="pay_draw" name="pay_draw" type="text" class="form-control" Placeholder="Manager" value="<?=$employee['pay_draw'];?>" tabindex="23">
                            </div>                                                            
                        </div><!--end form-group-->
                    </div> 
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="example-date-input" class="col-sm-3 col-form-label" name="start">Start Date</label>
                            <div class="col-sm-9">
                                <input class="form-control datepicker" type="text" name="job_start_date" value="<?=date("m/d/Y",strtotime($employee['job_start_date']));?>"  tabindex="24">

                                
                            </div>
                        </div><!--end form-group-->
                    </div><!--end col-->
                <!--</div>-->
                <!--<div class="row">                -->
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="example-date-input" class="col-sm-3 col-form-label" name="start">End Date</label>
                            <div class="col-sm-9">
                                <input class="form-control datepicker" type="text" name="job_end_date" value="<?=date("m/d/Y",strtotime($employee['job_end_date']));?>" tabindex="25" >
                            </div>
                        </div><!--end form-group-->
                    </div><!--end col-->
                    
                </div>     
            </div>
            <hr>
            <!--<p>-->
            <!--    <button class="btn btn-gradient-primary btn-prev" type="button" aria-controls="step-2">Previous</button>-->
            <!--    <button class="btn btn-gradient-primary btn-next" type="button" aria-controls="step-4">Next</button>-->
            <!--</p>-->
            <p>
                <input type="hidden" name="employee_id" value="<?php echo $employee['id']; ?>"
                <button class="btn btn-default btn-prev" type="button" aria-controls="step-2" tabindex="26">Previous</button>&nbsp;
                <button class="btn btn-success" type="submit" id="add_employee" tabindex="27">Submit F10</button> &nbsp;
                <button class="btn btn-default btn-edit" type="button" id="edit" tabindex="28">Edit F6</button> &nbsp;
                <button class="btn btn-danger" type="reset" tabindex="29">Start Over F5</button>
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
<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js'></script>
<script>
$(document).ready(function(){
    $("#gross_pay, #basic_pay, #medical_allowence, #conv_allow, #other, #t_deductions, #eobi, #social_security, #salary_tax , #net_payment").on("keydown keyup", sum);
	function sum() {
	   // console.log($("#basic_pay").val(), $("#medical_allowence").val(), $("#conv_allow").val(),  $("#other").val());
	$("#gross_pay").val(Number($("#basic_pay").val()) + Number($("#medical_allowence").val())+ Number($("#conv_allow").val())+ Number($("#other").val()));
	$("#t_deductions").val(Number($("#eobi").val()) + Number($("#social_security").val())+ Number($("#salary_tax").val()));
	$("#net_payment").val(Number($("#gross_pay").val()) - Number($("#t_deductions").val()));
	}
});

/*$(document).ready(function(){
    
var gross_pay = document.getElementById('gross_pay');
var basic_pay = document.getElementById('basic_pay');
var medical_allowence = document.getElementById('medical_allowence');
var conv_allow = document.getElementById('conv_allow');
var other = document.getElementById('other');
var t_deductions = document.getElementById('t_deductions');
var eobi = document.getElementById('eobi');
var social_security = document.getElementById('social_security');
var salary_tax = document.getElementById('salary_tax');
var net_payment = document.getElementById('net_payment');


basic_pay.addEventListener("input", sum);
medical_allowence.addEventListener("input", sum);
conv_allow.addEventListener("input", sum);
other.addEventListener("input", sum);

function sum() {
  
var one = parseFloat(basic_pay.value) || 0;
var two = parseFloat(medical_allowence.value) || 0;
var three = parseFloat(conv_allow.value) || 0;
var four = parseFloat(other.value) || 0;
  
var add = one+two+three+four;

gross_pay.val(add);

}

});*/

</script>
<script>
function myFunction() {
  var dots = document.getElementById("dots");
  var date_record = document.getElementById("date_record");
  var emp_type = document.getElementById("emp_type");
  var agree_type = document.getElementById("agree_type");
  //var uparrow=document.getElementByClass("ti-arrow-circle-up");
  
  var btnText = document.getElementById("record");

  if (dots.style.display === "none") {
    dots.style.display = "inline";
    btnText.innerHTML = "<i class='ti-arrow-circle-down' style='font-size:24px'></i>"; 
    $( date_record ).hide( "slow" );
    $( emp_type ).hide( "slow" );
    $( agree_type ).hide( "slow" );
    // date_record.style.display = "none";
    // emp_type.style.display = "none";
    // agree_type.style.display = "none";
  } else {
    dots.style.display = "none";
    btnText.innerHTML = "<i class='ti-arrow-circle-up' style='font-size:24px'></i>"; 
    // moreText.style.display = "inline";
    // date_record.style.display = "inline";
    // emp_type.style.display = "inline";
    // agree_type.style.display = "inline";
    $( date_record ).show( "slow" );
    $( emp_type ).show( "slow" );
    $( agree_type ).show( "slow" );
  }
}

function myFunction1() {
  var dots = document.getElementById("dots2");
  var marital = document.getElementById("marital");
  var reli = document.getElementById("reli");
  var cv = document.getElementById("cv");
  var image = document.getElementById("image");
  
  var btnText1 = document.getElementById("personal");

  if (dots.style.display === "none") {
    dots.style.display = "inline";
    btnText1.innerHTML = "<i class='ti-arrow-circle-down' style='font-size:24px'></i>"; 
    // marital.style.display = "none";
    // reli.style.display = "none";
    // cv.style.display = "none";
    // image.style.display = "none";
    $( marital ).hide( "slow" );
    $( reli ).hide( "slow" );
    $( cv ).hide( "slow" );
    $( image ).hide( "slow" );
  } else {
    dots.style.display = "none";
    btnText1.innerHTML = "<i class='ti-arrow-circle-up' style='font-size:24px'></i>"; 
    // marital.style.display = "inline";
    // reli.style.display = "inline";
    // cv.style.display = "inline";
    // image.style.display = "inline";
    $( marital ).show( "slow" );
    $( reli ).show( "slow" );
    $( cv ).show( "slow" );
    $( image ).show( "slow" );
  }
}

function myFunction2() {
  var dots2 = document.getElementById("dots2");
  var e_contact = document.getElementById("e_contact");
  var p_no = document.getElementById("p_no");
  var adres = document.getElementById("adres");
  
  var btnText2 = document.getElementById("contact");

  if (dots2.style.display === "none") {
    dots2.style.display = "inline";
    btnText2.innerHTML = "<i class='ti-arrow-circle-down' style='font-size:24px'></i>"; 
    // e_contact.style.display = "none";
    // p_no.style.display = "none";
    // adres.style.display = "none";
    $( e_contact ).hide( "slow" );
    $( p_no ).hide( "slow" );
    $( adres ).hide( "slow" );
  } else {
    dots2.style.display = "none";
    btnText2.innerHTML = "<i class='ti-arrow-circle-up' style='font-size:24px'></i>"; 
    // e_contact.style.display = "inline";
    //p_no.style.display = "inline";
    //adres.style.display = "inline";
    $( e_contact ).show( "slow" );
    $( p_no ).show( "slow" );
    $( adres ).show( "slow" );
  }
}

function myFunction3() {
  var dots3 = document.getElementById("dots2");
  var inst_name = document.getElementById("inst_name")
  var start_date = document.getElementById("start_date");
  var end_date = document.getElementById("end_date");
  var maj_sub = document.getElementById("cv");
  var obt_gpa = document.getElementById("obt_gpa");
  var t_gpa = document.getElementById("t_gpa");
  
  var btnText3 = document.getElementById("education");

  if (dots3.style.display === "none") {
    dots3.style.display = "inline";
    btnText3.innerHTML = "<i class='ti-arrow-circle-down' style='font-size:24px'></i>";
    // inst_name.style.display = "none";
    // start_date.style.display = "none";
    // end_date.style.display = "none";
    // maj_sub.style.display = "none";
    // obt_gpa.style.display = "none";
    // t_gpa.style.display = "none";
    $( inst_name ).hide( "slow" );
    $( start_date ).hide( "slow" );
    $( end_date ).hide( "slow" );
    $( maj_sub ).hide( "slow" );
    $( obt_gpa ).hide( "slow" );
    $( t_gpa ).hide( "slow" );
  } else {
    dots3.style.display = "none";
    btnText3.innerHTML = "<i class='ti-arrow-circle-up' style='font-size:24px'></i>";
    // inst_name.style.display = "inline";
    // start_date.style.display = "inline";
    // end_date.style.display = "inline";
    // maj_sub.style.display = "inline";
    // obt_gpa.style.display = "inline";
    // t_gpa.style.display = "inline";
    $( inst_name ).show( "slow" );
    $( start_date ).show( "slow" );
    $( end_date ).show( "slow" );
    $( maj_sub ).show( "slow" );
    $( obt_gpa ).show( "slow" );
    $( t_gpa ).show( "slow" );
  }
}
</script>
<script>
$(document).ready(function(){
    $(":input").inputmask();
});
   </script>