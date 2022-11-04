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
                  <a href="<?= base_url();?>Payroll/advanceloan" type="button" class="btn btn-primary btn-large"><i class="fas fa-money-check-alt"></i></i>&nbsp;Advance Loan</a>
                  <a href="<?= base_url();?>Payroll/manage_salarysetup" type="button" class="btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;View Salary Setup</a>
                  <a href="<?= base_url();?>Payroll/generatesalaries" type="button" class="btn btn-outline-primary"><i class="fas fa-money-bill-alt"></i></i>&nbsp;Generate Salaries</a>
                  <a href="<?= base_url();?>Payroll" type="button" class="btn btn-outline-primary"><i class="fa fa-bar-chart"></i>&nbsp;Salaries Report</a>
                </div>
			</div>
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
			<form method="post" action="<?= base_url('Payroll/updateloansetup');?>">
			<div class="row">
			<!--<h4>Previous Salary Information</h4>-->
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Employee</label>
                                <div class="col-lg-9 col-lg-offset-3">
                                    <select class="select2 form-control mb-3 custom-select" id="employee2" name="employee" required>
                                        <option value="">--Select Employee--</option>
                                    <?php $employees  =	$this->Common_model->select_where_ASC_DESC('id,employee_code,designation,plants,full_name,total_advance_amount,return_advance_amount,loanpaid_type,pay_per_month,account_no,bank_name','tbl_employees',array('deleted'=>0,'is_active'=>1),'full_name','ASC');
                                        if($employees->num_rows() > 0) {
                                        foreach($employees->result() as $emp) {
                                        $designation =	$this->Common_model->select_single_field('designation_name','tbl_designation',array('id'=>$emp->designation));
                                        $plant =	$this->Common_model->select_single_field('fld_location','tbl_locations',array('fld_id'=>$emp->plants));
                                        //$bankname =	$this->Common_model->select_single_field('fld_bank','tbl_banks_employees',array('fld_id'=>$emp->bank_name));
                                    ?>
                                        <option value="<?php echo $emp->id;?>" data_set="<?=$emp->employee_code;?>" data_designation="<?=$designation;?>" data_plant="<?=$plant;?>" data_total_advance_amount="<?=$emp->total_advance_amount;?>" data_return_advance_amount="<?=$emp->return_advance_amount;?>" data_loanpaid_type="<?=$emp->loanpaid_type;?>" data_pay_per_month="<?=$emp->pay_per_month;?>" data_bank_name="<?=$emp->bank_name;?>" data_account_no="<?=$emp->account_no;?>"><?php echo $emp->full_name;?></option>
                                    <?php } } ?>
                                    </select>
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
                                    <input id="employee_code" name="employee_code" type="text" class="form-control" readonly>
                                </div>
                            </div><!--end form-group-->
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="plant" class="col-lg-3 col-form-label">Plant</label>
                                <div class="col-lg-9">
                                    <input id="plant" name="plant" type="text" class="form-control" readonly>
                                </div>
                            </div><!--end form-group-->
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="designation" class="col-lg-3 col-form-label">Designation</label>
                                <div class="col-lg-9">
                                    <input id="designation" name="designation" type="text" class="form-control" readonly>
                                </div>
                            </div><!--end form-group-->
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="bank_name" class="col-lg-3 col-form-label">Bank Name</label>
                                <div class="col-lg-9">
                                    <!--<input id="bank_name" name="bank_name" type="text" class="form-control">-->
                                    <select class="select2 form-control mb-3 custom-select" id="bank_name" name="bank_name" required>
                                       <option value="">--Select Bank--</option>
                                    <?php $tbl_bank	=	$this->Common_model->select_where_ASC_DESC('fld_id,fld_bank','tbl_banks_employees',array('fld_status'=>1),'fld_bank','ASC');
                                        if($tbl_bank->num_rows() > 0) {
                                        foreach($tbl_bank->result() as $bank) {
                                    ?>
                                        <option value="<?php echo $bank->fld_id;?>" ><?php echo $bank->fld_bank;?></option>
                                    <?php } } ?>
                                   </select>
                                </div>
                            </div><!--end form-group-->
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="account_no" class="col-lg-3 col-form-label">Account No.</label>
                                <div class="col-lg-9">
                                    <input id="account_no" name="account_no" type="text" class="form-control">
                                </div>
                            </div><!--end form-group-->
                        </div>
                       
                        <div class="col-md-12">
                        <div class="benifts" style="border: 1px solid #d5d7e5;padding: 10px;">
                            <h4 style="text-align: center;margin: 0;">Advance / Loan</h4>
                            <hr>
                            <div class="form-group row">
                                <label for="loan_amount" class="col-lg-5 col-form-label">Advance/Loan Amount (PKR)</label>
                                <div class="col-lg-7">
                                    <input id="total_advance_amount" name="total_advance_amount" type="number" class="form-control">
                                    <span style="width: 130px; display: inline-block;color:#ef4d56; font-size:12px;"><i id="return_advance_amount">(Return Loan: 0.00)</i></span>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="Type" class="col-lg-5 col-form-label">Pay Type</label>
                                <div class="col-lg-7">
                                    <select class="select2 form-control mb-3 custom-select" id="loanpaid_type" name="loanpaid_type" required>
                                       <option value="">--Select --</option>
                                       <option value="Once" >Once</option>
                                       <option value="monthly" >Monthly</option>
                                   </select>
                                </div>
                            </div>
                            
                            <div class="form-group row" id="row_dim">
                                <label for="pay_per_month" class="col-lg-5 col-form-label">Pay Per Month (PKR)</label>
                                <div class="col-lg-7">
                                    <input id="pay_per_month" name="pay_per_month" type="number" class="form-control">
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
				<div class="col-lg-6" style="margin-top: 5px;">
					<div class="mt-3">
						<label class="mb-2"></label>
						<button type="submit" class="btn btn-successs">Proceed F10</button>
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
   document.getElementById("employee2").onchange = function(event) {
//event.target.selectedOptions[0] have that option. as this is single selection by dropdown. this will always be 0th index :)
let get_val = event.target.selectedOptions[0].getAttribute("data_set");
let des_val = event.target.selectedOptions[0].getAttribute("data_designation");
let plant_val = event.target.selectedOptions[0].getAttribute("data_plant");
let total_advance_amount = event.target.selectedOptions[0].getAttribute("data_total_advance_amount");
let return_advance_amount = event.target.selectedOptions[0].getAttribute("data_return_advance_amount");
let loanpaid_type = event.target.selectedOptions[0].getAttribute("data_loanpaid_type");
let pay_per_month = event.target.selectedOptions[0].getAttribute("data_pay_per_month");
let bank_name = event.target.selectedOptions[0].getAttribute("data_bank_name");
let account_no = event.target.selectedOptions[0].getAttribute("data_account_no");

//document.getElementById("demo").innerHTML = "You selected: " + get_val;
document.getElementById("employee_code").value = get_val;
document.getElementById("designation").value = des_val;
document.getElementById("plant").value = plant_val;
document.getElementById("total_advance_amount").value = total_advance_amount;
document.getElementById("return_advance_amount").innerHTML = ("(Return Loan: "+return_advance_amount+")");
//document.getElementById("loanpaid_type").value = loanpaid_type;
document.getElementById("pay_per_month").value = pay_per_month;
//document.getElementById("bank_name").value = bank_name;
document.getElementById("account_no").value = account_no;

}

$(document).ready(function(){
// Initialize Select2
  $('#bank_name').select2();
  $('#loanpaid_type').select2();
  // Set option selected onchange
   $('#employee2').change(function(event){
//     var value = $(this).val();
       var value = event.target.selectedOptions[0].getAttribute("data_bank_name");
       var value2 = event.target.selectedOptions[0].getAttribute("data_loanpaid_type");
       console.log(value);
//     // Set selected 
     $('#bank_name').val(value);
     $('#loanpaid_type').val(value2);
     $('#bank_name').select2().trigger('change');
     $('#loanpaid_type').select2().trigger('change');
   });
});

$(function() {
    $('#row_dim').hide(); 
    $('#loanpaid_type').change(function(){
        if($('#loanpaid_type').val() == 'monthly') {
            $('#row_dim').show(); 
        } else {
            $('#row_dim').hide();
            $('#pay_per_month').val("");
        } 
    });
});

});
</script>