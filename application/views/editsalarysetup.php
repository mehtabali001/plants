<style>
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
.col-form-label {
    text-align: left;
    
}
.form-group {
    margin-bottom: 10px;
}
[data-from-dependent] {
  display: none;
}

[data-from-dependent].display {
  display: initial;
}
</style>
<div class="container-fluid">
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right" style="margin-bottom:15px;">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
				  <a href="<?= base_url();?>Payroll/addsalarysetup" type="button" class="btn btn-outline-primary"><i class="fas fa-money-check-alt"></i></i>&nbsp;New Salary Setup</a>    
                  <a href="<?= base_url();?>Payroll/generatesalaries" type="button" class="btn btn-outline-primary"><i class="fas fa-money-bill-alt"></i></i>&nbsp;Generate Salaries</a>
                  <a href="<?= base_url();?>Payroll/manage_salarysetup" type="button" class="btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;View Salary Setup</a>
                  <a href="<?= base_url();?>Payroll" type="button" class="btn btn-outline-primary"><i class="fa fa-bar-chart"></i>&nbsp;Salaries Report</a>
                </div>
			</div>
			<!--<h4 class="page-title">Payroll</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Payroll</a></li>-->
			<!--	<li class="breadcrumb-item active">Salary Setup</li>-->
			<!--</ol>-->
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
				}?>
				<?php $success_message = $this->session->userdata('success_message');
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
			<?
			$designation1 =	$this->Common_model->select_single_field('designation_name','tbl_designation',array('id'=>$editsalary['designation']));
            $plant1 =	$this->Common_model->select_single_field('fld_location','tbl_locations',array('fld_id'=>$editsalary['plants']));
            $employee =	$this->Common_model->select_single_field('full_name','tbl_employees',array('id'=>$editsalary['id']));
			?>
			<form id="updatesalarysetup" method="post" action="<?= base_url('Payroll/updatesalarysetup');?>">
			<div class="row">
			<!--<h4>Previous Salary Information</h4>-->
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Employee</label>
                                <div class="col-lg-9 col-lg-offset-3">
                                    <input name="employee" type="text" class="form-control" value="<?=$employee;?>" readonly>
                                    <?/*?><select class="select2 form-control mb-3 custom-select" id="employee" name="employee" required>
                                        <option value="">--Select Employee--</option>
                                    <?php $employees  =	$this->Common_model->select_where_ASC_DESC('id,email,employee_code,designation,plants,full_name,account_no,bank_name,basic_pay,med_allow,other,total_advance_amount,return_advance_amount,loanpaid_type,pay_per_month,gross_pay,eobi,social_security,salary_tax,t_deductions,net_payment,bank_name,account_no','tbl_employees',array('deleted'=>0),'full_name','ASC');
                                        if($employees->num_rows() > 0) {
                                        foreach($employees->result() as $emp) {
                                        $designation =	$this->Common_model->select_single_field('designation_name','tbl_designation',array('id'=>$emp->designation));
                                        $plant =	$this->Common_model->select_single_field('fld_location','tbl_locations',array('fld_id'=>$emp->plants));
                                      //$bankname =	$this->Common_model->select_single_field('fld_bank','tbl_banks_employees',array('fld_id'=>$emp->bank_name));
                                    ?>
                                        <option value="<?php echo $emp->id;?>" <? if($emp->id == $editsalary['id']){ echo "selected"; } ?> data_set="<?=$emp->employee_code;?>" data_designation="<?=$designation;?>" data_plant="<?=$plant;?>" data_basicpay="<?=$emp->basic_pay;?>" data_medallow="<?=$emp->med_allow;?>" data_other="<?=$emp->other;?>" data_grosspay="<?=$emp->gross_pay;?>" data_eobi="<?=$emp->eobi;?>" data_social="<?=$emp->social_security;?>" data_tax="<?=$emp->salary_tax;?>" data_deduction="<?=$emp->t_deductions;?>" data_netpay="<?=$emp->net_payment;?>" data_bank_name="<?=$emp->bank_name;?>" data_account_no="<?=$emp->account_no;?>" data_total_advance_amount="<?=$emp->total_advance_amount;?>" data_return_advance_amount="<?=$emp->return_advance_amount;?>" data_loanpaid_type="<?=$emp->loanpaid_type;?>" data_pay_per_month="<?=$emp->pay_per_month;?>"><?php echo $emp->full_name;?></option>
                                    <?php } } ?>
                                    </select><?*/?>
                                </div>
                                <!-- <p id="demo"></p>-->
								<!--<input type="text" class="form-control" id="demo2" name="assign_user_email" value="" >-->
								<!--<input type="text" class="form-control" id="demo3" name="assign_useremail" value="" >-->
                            </div>
                        </div><!--end col-->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="email" class="col-lg-3 col-form-label">Emp. Code</label>
                                <div class="col-lg-9">
                                    <input id="employee_code" name="employee_code" type="text" class="form-control" value="<?=$editsalary['employee_code'];?>" readonly>
                                </div>
                            </div><!--end form-group-->
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="plant" class="col-lg-3 col-form-label">Plant</label>
                                <div class="col-lg-9">
                                    <input id="plant" name="plant" type="text" class="form-control" value="<?=$plant1;?>" readonly>
                                </div>
                            </div><!--end form-group-->
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="designation" class="col-lg-3 col-form-label">Designation</label>
                                <div class="col-lg-9">
                                    <input id="designation" name="designation" type="text" value="<?=$designation1;?>" class="form-control" readonly>
                                </div>
                            </div><!--end form-group-->
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="bank_name" class="col-lg-3 col-form-label">Bank Name</label>
                                <div class="col-lg-9">
                                    <!--<input id="bank_name" name="bank_name" type="text" class="form-control">-->
                                    <select class="select2 form-control mb-3 custom-select" id="bank_name" name="bank_name">
                                       <option value="">--Select Bank--</option>
                                    <?php $tbl_bank	=	$this->Common_model->select_where_ASC_DESC('fld_id,fld_bank','tbl_banks_employees',array('fld_status'=>1),'fld_bank','ASC');
                                        if($tbl_bank->num_rows() > 0) {
                                        foreach($tbl_bank->result() as $bank) {
                                    ?>
                                        <option value="<?php echo $bank->fld_id;?>" <? if($bank->fld_id == $editsalary['bank_name']){ echo "selected"; } ?>><?php echo $bank->fld_bank;?></option>
                                    <?php } } ?>
                                   </select>
                                </div>
                            </div><!--end form-group-->
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="account_no" class="col-lg-3 col-form-label">Account No.</label>
                                <div class="col-lg-9">
                                    <input id="account_no" name="account_no" type="text" value="<?=$editsalary['account_no'];?>" class="form-control">
                                </div>
                            </div><!--end form-group-->
                        </div>
                       
                        <div class="col-md-6">
                        <div class="benifts" style="border: 1px solid #d5d7e5;padding: 10px;">
                            <h4 style="text-align: center;margin: 0;">Benefits</h4>
                            <hr>
                            <div class="form-group row">
                                <label for="basic_pay" class="col-lg-5 col-form-label">Basic Pay</label>
                                <div class="col-lg-7">
                                    <input id="basic_pay" name="basic_pay" type="number" value="<?=$editsalary['basic_pay'];?>" class="form-control">
                                </div>
                            </div><!--end form-group-->
                            
                            <div class="form-group row">
                                <label for="Medical_Allowence" class="col-lg-5 col-form-label">Med. Allow.</label>
                                <div class="col-lg-7">
                                    <input id="medical_allowence" name="med_allow" type="number" value="<?=$editsalary['med_allow'];?>" class="form-control">
                                </div>
                            </div><!--end form-group-->
                            
                            <!--<div class="form-group row">-->
                            <!--    <label for="conv_allow" class="col-lg-5 col-form-label">Conv. Allow.</label>-->
                            <!--    <div class="col-lg-7">-->
                            <!--        <input id="conv_allow" name="conv_allow" type="number" class="form-control">-->
                            <!--    </div>-->
                            <!--</div>-->
                            
                            <div class="form-group row">
                                <label for="other" class="col-lg-5 col-form-label">Other</label>
                                <div class="col-lg-7">
                                    <input id="other" name="other" type="number" value="<?=$editsalary['other'];?>" class="form-control">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="gross_pay" class="col-lg-5 col-form-label">Gross Pay</label>
                                <div class="col-lg-7">
                                    <input id="gross_pay" name="gross_pay" type="number" value="<?=$editsalary['gross_pay'];?>" class="form-control" readonly>
                                </div>
                            </div><!--end form-group-->
                            
                            <div class="form-group row">
                                <label for="loan_amount" class="col-lg-5 col-form-label">&nbsp;</label>
                                <div class="col-lg-7">
                                    &nbsp;
                                </div>
                            </div>
                            
                            <div class="form-group row" id="row_dim">
                                <label for="pay_per_month" class="col-lg-5 col-form-label">&nbsp;</label>
                                <div class="col-lg-7">
                                    &nbsp;
                                </div>
                            </div><br>
                            
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="benifts" style="border: 1px solid #d5d7e5;padding: 10px;">
                            <h4 style="text-align: center;margin: 0;">Deductions</h4>
                            <hr>
                            <div class="form-group row">
                                <label for="eobi" class="col-lg-5 col-form-label">EOBI</label>
                                <div class="col-lg-7">
                                    <input id="eobi" name="eobi" type="number" value="<?=$editsalary['eobi'];?>" class="form-control">
                                </div>
                            </div><!--end form-group-->
                            
                            <div class="form-group row">
                                <label for="social_security" class="col-lg-5 col-form-label">Social Security</label>
                                <div class="col-lg-7">
                                    <input id="social_security" name="social_security" type="number" value="<?=$editsalary['social_security'];?>" class="form-control">
                                </div>
                            </div><!--end form-group-->
                            
                            <div class="form-group row">
                                <label for="salary_tax" class="col-lg-5 col-form-label">Salary Tax</label>
                                <div class="col-lg-7">
                                    <input id="salary_tax" name="salary_tax" type="number" value="<?=$editsalary['salary_tax'];?>" class="form-control">
                                </div>
                            </div><!--end form-group-->
                            
                            <div class="form-group row">
                                <label for="loan_amount" class="col-lg-5 col-form-label">Advance/Loan Amount (PKR)</label>
                                <div class="col-lg-7">
                                    <input id="total_advance_amount" name="total_advance_amount" type="number" value="<?=$editsalary['total_advance_amount'];?>" class="form-control" readonly>
                                    <span style="width: 130px; display: inline-block;color:#ef4d56; font-size:12px;"><i id="return_advance_amount">(Return Loan: 0.00)</i></span>
                                </div>
                            </div>
                            
                            <div class="form-group row" id="row_dim">
                                <label for="pay_per_month" class="col-lg-5 col-form-label">Pay Per Month (PKR)</label>
                                <div class="col-lg-7">
                                    <input id="pay_per_month" name="pay_per_month" type="number" value="<?=$editsalary['pay_per_month'];?>" class="form-control">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="t_deductions" class="col-lg-5 col-form-label">Total Deductions</label>
                                <div class="col-lg-7">
                                    <input id="t_deductions" name="t_deductions" type="number" value="<?=$editsalary['t_deductions'];?>" class="form-control" readonly>
                                </div>
                            </div><!--end form-group-->
                        
                        </div>    
                        </div>
                        </div>
                </div><!--end col-->
            </div>
                <div class="col-lg-6">
                    <br>
                    <div class="form-group row">
                        <label for="net_payment" class="col-lg-5 col-form-label">Net Payment</label>
                        <div class="col-lg-7 col-lg-offset-3">
                            <input id="net_payment" name="net_payment" type="number" value="<?=$editsalary['net_payment'];?>" class="form-control" readonly>
                        </div>
                    </div>
                </div>    
				<div class="col-lg-6" style="margin-top: 5px;">
					<div class="mt-3">
						<label class="mb-2"></label>
						<input type="submit" id="update-salarysetup" class="btn btn-successs" name="update-salarysetup" value="Proceed F10" disabled>
					</div>
				</div>
				</div>
				</form>
			</div>
			</div><!-- end card-body -->
		</div><!-- end card -->                                       
	</div><!-- end col -->
</div>
</div><!-- container -->
<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js'></script>
<script>
$(document).ready(function(){
    $("#gross_pay, #basic_pay, #medical_allowence, #other, #t_deductions, #eobi, #social_security, #salary_tax, #pay_per_month , #net_payment").on("keydown keyup", sum);
	function sum() {
	// console.log($("#basic_pay").val(), $("#medical_allowence").val(), $("#conv_allow").val(),  $("#other").val());
	$("#gross_pay").val(Number($("#basic_pay").val()) + Number($("#medical_allowence").val())+ Number($("#other").val()));
	$("#t_deductions").val(Number($("#eobi").val()) + Number($("#social_security").val())+ Number($("#salary_tax").val())+ Number($("#pay_per_month").val()));
	$("#net_payment").val(Number($("#gross_pay").val()) - Number($("#t_deductions").val()));
	}
	
$('#updatesalarysetup')
		.each(function(){
			$(this).data('serialized', $(this).serialize())
		})
        .on('change input', function(){
            $(this)				
                .find('input:submit, button:submit')
                    .attr('disabled', $(this).serialize() == $(this).data('serialized'));
         })
		.find('input:submit, button:submit').attr('disabled', true);
});


</script>