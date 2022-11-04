<style>
#datatable_filter > label
{
	float: right;
}
.label-success-outline {
    color: #506ee4;
/*background-color: transparent;*/
/*border: 2px solid #45c203;*/
}
.btn{
    box-shadow: none !important;
}
.bttn:hover{
    color: #fff;
    background-color: #506ee4 !important;
    border-color: #506ee4 !important;
}
.col-form-label {
    text-align: left;
}
.form-group {
    margin-bottom: 10px;
}
@media only screen and (max-width: 600px) {
.page-title-box{
    display:none;
}
.btn-group a{
font-size: 10px;
}
.btn-group a i {
    display: block;
}
}
</style>
<div class="container-fluid">
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                 <a href="<?= base_url();?>Payroll/paidsalaries" type="button" class="btn btn-outline-primary"><i class="fa fa-file-text-o"></i>&nbsp;Paid Salaries</a>
                  <a href="<?= base_url();?>Payroll/manage_salarysetup" type="button" class="btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;View Salary Setup</a>
                  <a href="<?= base_url();?>Payroll/generatesalaries" type="button" class="btn btn-outline-primary"><i class="fas fa-money-bill-alt"></i></i>&nbsp;Generate Salaries</a>
                  <a href="<?= base_url();?>Payroll" type="button" class="btn btn-outline-primary"><i class="fa fa-bar-chart"></i>&nbsp;Salaries Report</a>
                </div>
			</div>
		</div><!--end page-title-box-->
	</div>
	
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="btn-group float-right" role="group">
                <a type="button"onclick="window.open('<?= base_url();?>Payroll/print_single_salary/<?= $salary['id'];?>', 'Salary Report', 'width=1210, height=842');" id="print_report" style="border:1px solid #506ee4;background-color: DodgerBlue;" class="btn bttn print_report" name="" value=""><i class="fa fa-print" aria-hidden="true"></i>&nbsp;&nbsp;Print Current Report</a>
                <a type="button " style="border:1px solid #506ee4;background: #fd3c97" onclick="window.open('<?= base_url();?>Payroll/pdf_single_salary/<?= $salary['id'];?>', 'Salary Report');" class="btn  bttn pdf_salary_report" name="" value=""><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;&nbsp;Download PDF</a>
                <a href="<?= (!empty($previous)) ? base_url('Payroll/viewpaidsalary/'.$previous['id'].''):'0';?>" type="button" class="btn btn-outline-primary"><i class="mdi mdi-arrow-left"></i>&nbsp;Previous Salary</a>
                <a href="<?= (!empty($next)) ? base_url('Payroll/viewpaidsalary/'.$next['id'].''):'0';?>" type="button" class="btn btn-outline-primary">Next Salary&nbsp;<i class="mdi mdi-arrow-right"></i></a>
            </div>
		</div><!--end page-title-box-->
	</div>
</div><br>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
								<div class="panel panel-bd lobidrag">
								<div class="panel-body" id="printableArea">
						        <? 
						         $designation =	$this->Common_model->select_single_field('designation_name','tbl_designation',array('id'=>$salary['designation']));       
    						   //$department  =	$this->Common_model->select_single_field('department_name','tbl_departments',array('id'=>$emp['department']));
    							 $plant       =	$this->Common_model->select_single_field('fld_location','tbl_locations',array('fld_id'=>$salary['plants']));
    							 $name        =	$this->Common_model->select_single_field('full_name','tbl_employees',array('id'=>$salary['user_id']));
    							 $code        =	$this->Common_model->select_single_field('employee_code','tbl_employees',array('id'=>$salary['user_id']));
    							 if($this->uri->segment(3) != 0){
						        ?>
								<div class="row purchasedetails-header">
											
									<div class="col-sm-7 purchasedetails-address">
										<span class="label m-r-15 p-10 text-dark font-weight-semibold"><span class="label-success-outline">Employee Details :</span></span>
										<hr>
										<!--<p class="text-muted  mt-3"><span class="text-dark font-weight-semibold">FastTech Solutions</span></p>-->
										<ul class="list-unstyled mb-2">
											<li class=""><b>Emp.Code :</b> &nbsp;&nbsp;&nbsp;<?php echo $code; ?></li>
											<li class="mt-3"><b>Name :</b> &nbsp;&nbsp;&nbsp;<?php echo $name; ?></li>
											<li class="mt-3"><b>Designation :</b> &nbsp;&nbsp;&nbsp;<?php echo $designation; ?></li>
											<li class="mt-3"><b>Location :</b> &nbsp;&nbsp;&nbsp;<?php echo $plant; ?></li>                                        

										</ul>
									</div>
								
									<div class="col-sm-5 text-left invoice-details-billing">
										<!--<h2 class="m-t-0">Purchase</h2>-->
										<span class="label m-r-15 text-dark font-weight-semibold"><span class="label-success-outline">Payment Details :</span></span>
										<!--<p class="text-muted  mt-3"><span class="text-dark font-weight-semibold"><?//= $purchase['fld_supplier_name'];?></span></p>-->
										<hr>
										<ul class="list-unstyled mb-2">
										    <li class=""><b>Date :</b> &nbsp;&nbsp;&nbsp;<?= date('d - M - Y'); ?>, <?= date('h:i A'); ?></li>
											<li class="mt-3"><b>Salary Month :</b> &nbsp;&nbsp;&nbsp;<?= $salary['month'].', '.$salary['year'];?></li> 
											<li class="mt-3"><b>Paid From :</b> &nbsp;&nbsp;&nbsp;<?= $salary['paid_from'];?></li>
											<li class="mt-3"><b>Payment Type :</b> &nbsp;&nbsp;&nbsp;<?= $salary['paid_via'];?></li>
										</ul>
									</div>
								</div><hr>
								<br>
                        <div class="row">
						<div class="col-md-6">
                        <div class="benifts" style="border: 1px solid #d5d7e5;padding: 10px;">
                            <h4 style="text-align: center;margin: 0;">Benefits (PKR)</h4>
                            <hr>
                            <div class="form-group row">
                                <label for="basic_pay" class="col-lg-5 col-form-label">Basic Pay</label>
                                <div class="col-lg-7 col-form-label">
                                    <?= $salary['basic_salary'];?>
                                </div>
                            </div><!--end form-group-->
                            
                            <div class="form-group row">
                                <label for="Medical_Allowence" class="col-lg-5 col-form-label">Med. Allow.</label>
                                <div class="col-lg-7 col-form-label">
                                    <? 
    							        $med_allownce =	$this->Common_model->select_single_field('med_allow','tbl_employees',array('id'=>$salary['user_id']));
						            ?>
                                    <?=$med_allownce;?>
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
                                <div class="col-lg-7 col-form-label">
                                    <? 
    							        $otherfac  = $this->Common_model->select_single_field('other','tbl_employees',array('id'=>$salary['user_id']));
						            ?>
                                    <?=$otherfac;?>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="gross_pay" class="col-lg-5 col-form-label">Gross Pay</label>
                                <div class="col-lg-7 col-form-label">
                                    <? 
    							        $grosspay   =	$this->Common_model->select_single_field('gross_pay','tbl_employees',array('id'=>$salary['user_id']));
						            ?>
                                    <?=$grosspay;?>
                                </div>
                            </div><!--end form-group-->
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="benifts" style="border: 1px solid #d5d7e5;padding: 10px;">
                            <h4 style="text-align: center;margin: 0;">Deductions (PKR)</h4>
                            <hr>
                            <div class="form-group row">
                                <label for="eobi" class="col-lg-5 col-form-label">EOBI</label>
                                <div class="col-lg-7 col-form-label">
                                    <? 
    							        $eobi   =	$this->Common_model->select_single_field('eobi','tbl_employees',array('id'=>$salary['user_id']));
						            ?>
                                    <?=$eobi;?>
                                </div>
                            </div><!--end form-group-->
                            
                            <div class="form-group row">
                                <label for="social_security" class="col-lg-5 col-form-label">Social Security</label>
                                <div class="col-lg-7 col-form-label">
                                    <? 
    							        $social_security   =	$this->Common_model->select_single_field('social_security','tbl_employees',array('id'=>$salary['user_id']));
						            ?>
                                    <?=$social_security;?>
                                </div>
                            </div><!--end form-group-->
                            
                            <div class="form-group row">
                                <label for="salary_tax" class="col-lg-5 col-form-label">Salary Tax</label>
                                <div class="col-lg-7 col-form-label">
                                    <? 
    							        $salary_tax  =	$this->Common_model->select_single_field('salary_tax','tbl_employees',array('id'=>$salary['user_id']));
						            ?>
                                    <?=$salary_tax;?>
                                </div>
                            </div><!--end form-group-->
                            
                            <div class="form-group row">
                                <label for="salary_tax" class="col-lg-5 col-form-label">Return Loan</label>
                                <div class="col-lg-7 col-form-label">
                                    <? 
    							        $pay_per_month  =	$this->Common_model->select_single_field('pay_per_month','tbl_employees',array('id'=>$salary['user_id']));
						            ?>
                                    <?=$pay_per_month;?>
                                </div>
                            </div><!--end form-group-->
                            
                            <div class="form-group row">
                                <label for="t_deductions" class="col-lg-5 col-form-label">Total Deductions</label>
                                <div class="col-lg-7 col-form-label">
                                    <? 
    							        $t_deductions  = $this->Common_model->select_single_field('t_deductions','tbl_employees',array('id'=>$salary['user_id']));
						            ?>
                                    <?=$t_deductions;?>
                                </div>
                            </div><!--end form-group-->

                        </div>    
                        </div>
                        <div class="col-lg-6">
                            &nbsp;
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label for="net_payment" class="col-lg-5 col-form-label">Net Payment (PKR)</label>
                                <div class="col-lg-7 col-form-label">
                                    <?=$salary['amount_paid'];?>
                                </div>
                            </div>
                        </div>
                        </div>
                        <? }else{ ?>
							<h2 style="text-align:center;">No Record Found!</h2>
						<? } ?>
					</div>
					</div>	
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
</div>

                