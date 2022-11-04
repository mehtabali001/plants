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
/*popup*/
.modalbg {
  position: fixed;
  font-family: Arial, Helvetica, sans-serif;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  background: rgba(0, 0, 0, 0);
  z-index: 99999;
  -moz-transition: all 2s ease-out;
  -webkit-transition: all 2s ease-out;
  -o-transition: all 2s ease-out;
  transition: all 2s ease-out;
  -webkit-transition-delay: 0.2s;
  -moz-transition-delay: 0.2s;
  -o-transition-delay: 0.2s;
  -transition-delay: 0.2s;
  display: block;
  pointer-events: none;
}
.modalbg .dialog {
  width: 400px;
  position: relative;
  top: -1000px;
  margin: 10% auto;
  padding: 5px 20px 13px 20px;
  -moz-border-radius: 10px;
  -webkit-border-radius: 10px;
  border-radius: 10px;
  background: #060c24;
  background: -moz-linear-gradient(#fff, #ccc);
  background: -webkit-linear-gradient(#060c24, #060c24);
  background: -o-linear-gradient(#fff, #ccc);
  box-shadow: 0 0 10px #000;
  -moz-box-shadow: 0 0 10px #000;
  -webkit-box-shadow: 0 0 10px #000;
  
}
.modalbg .dialog .ie7 {
  filter: progid:DXImageTransform.Microsoft.Shadow(color='#000', Direction=135, Strength=3);
}
.modalbg:target {
  display: block;
  pointer-events: auto;
  background: rgba(4, 10, 30, 0.8);
  -moz-transition: all 0.5s ease-out;
  -webkit-transition: all 0.5s ease-out;
  -o-transition: all 0.5s ease-out;
  transition: all 0.5s ease-out;
}
.modalbg:target .dialog {
  top: -20px;
  -moz-transition: all 0.8s ease-out;
  -webkit-transition: all 0.8s ease-out;
  -o-transition: all 0.8s ease-out;
  transition: all 0.8s ease-out;
  -webkit-transition-delay: 0.4s;
  -moz-transition-delay: 0.4s;
  -o-transition-delay: 0.4s;
  -transition-delay: 0.4s;
}
.close {
  background: #606061;
  color: #FFFFFF;
  line-height: 25px;
  position: absolute;
  right: -12px;
  text-align: center;
  top: -10px;
  width: 24px;
  text-decoration: none;
  font-weight: bold;
  -webkit-border-radius: 12px;
  -moz-border-radius: 12px;
  border-radius: 12px;
  box-shadow: 0 0 10px #000;
  -moz-box-shadow: 0 0 10px #000;
  -webkit-box-shadow: 0 0 10px #000;
  -moz-transition: all 0.5s ease-out;
  -webkit-transition: all 0.5s ease-out;
  -o-transition: all 0.5s ease-out;
  transition: all 0.5s ease-out;
  -webkit-transition-delay: 0.2s;
  -moz-transition-delay: 0.2s;
  -o-transition-delay: 0.2s;
  -transition-delay: 0.2s;
}
.close .ie7 {
  filter: progid:DXImageTransform.Microsoft.Shadow(color='#000', Direction=135, Strength=3);
}
.close:hover {
  background: #00d9ff;
  -moz-transition: all 0.5s ease-out;
  -webkit-transition: all 0.5s ease-out;
  -o-transition: all 0.5s ease-out;
  transition: all 0.5s ease-out;
}
.fineprint {
  font-style: italic;
  font-size: 10px;
  color: #646;
}
a {
    color: #babfd3;
    text-decoration: none;
}
.hide {
  display: none;
}

</style>
<style type="text/css">
   .txtedit{
      display: none;
      width: 98%;
   }
</style>
<!--<link href="https://netdna.bootstrapcdn.com/bootstrap/2.3.2/css/bootstrap.min.css" rel="stylesheet">-->
<!--<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet">-->
<script>
function checkvalue(val)
{
    if(val==="plantwise"){
       document.getElementById('div1').style.display='block';
       document.getElementById("plants").required = true;
    }else{
       document.getElementById('div1').style.display='none';
       document.getElementById("plants").required = false;
	}	   
} 

function checkvalue2(val)
{
    if(val==="designationwise"){
       document.getElementById('div2').style.display='block';
       document.getElementById("designation").required = true;
    }else{
       document.getElementById('div2').style.display='none'; 
       document.getElementById("designation").required = false;
	}	   
}

/*function show1(){
  document.getElementById('div1').style.display ='none';
}
function show2(){
  document.getElementById('div1').style.display = 'block';
}
 function show3(){
  document.getElementById('div2').style.display ='none';
}
function show4(){
  document.getElementById('div2').style.display = 'block';
}*/
</script>

<div class="container-fluid">
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right" style="margin-bottom:15px;">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Payroll/payablesalaries" type="button" class="btn btn-primary btn-large"><i class="fa fa-file-text-o"></i>&nbsp;Payable Salaries</a>
                  <a href="<?= base_url();?>Payroll/manage_salarysetup" type="button" class="btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;View Salary Setup</a>
                  <a href="<?= base_url();?>Payroll/generatesalaries" type="button" class="btn btn-outline-primary"><i class="fas fa-money-bill-alt"></i></i>&nbsp;Generate Salaries</a>
                  <a href="<?= base_url();?>Payroll" type="button" class="btn btn-outline-primary"><i class="fa fa-bar-chart"></i>&nbsp;Salaries Report</a>
                </div>
			</div>
			<!--<h4 class="page-title">Payroll</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Payroll</a></li>-->
			<!--	<li class="breadcrumb-item active">Payable Salaries</li>-->
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
                        <?php 
						$error_message = $this->session->userdata('error_message');
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
                        <!--<label for="myDate">Date :</label>-->
                        <!--<input type="text" class="form-control" name="datepicker" id="datepicker" />-->
						<?/*?><form id="addPayroll" action="<?= base_url('Payroll/createSalary');?>" class="form-vertical"  method="post" >
						<div class="row">  
						<div class="col-md-3">
						    <label>Month</label>
							<select class="select2 form-control mb-3 custom-select" name="month" id="month" required>
                                <option value="">Select Month</option>
								<option value='Janaury' <?php if(isset($_GET['month']) && $_GET['month'] == 'Janaury'){ echo 'selected'; }else if(date('F') == 'Janaury'){ echo 'selected'; } ?>>Janaury</option>
								<option value='February' <?php if(isset($_GET['month']) && $_GET['month'] == 'February'){ echo 'selected'; }else if(date('F') == 'February'){ echo 'selected'; } ?>>February</option>
								<option value='March' <?php if(isset($_GET['month']) && $_GET['month'] == 'March'){ echo 'selected'; }else if(date('F') == 'March'){ echo 'selected'; } ?>>March</option>
								<option value='April' <?php if(isset($_GET['month']) && $_GET['month'] == 'April'){ echo 'selected'; }else if(date('F') == 'April'){ echo 'selected'; } ?>>April</option>
								<option value='May' <?php if(isset($_GET['month']) && $_GET['month'] == 'May'){ echo 'selected'; }else if(date('F') == 'May'){ echo 'selected'; } ?>>May</option>
								<option value='June' <?php if(isset($_GET['month']) && $_GET['month'] == 'June'){ echo 'selected'; }else if(date('F') == 'June'){ echo 'selected'; } ?>>June</option>
								<option value='July' <?php if(isset($_GET['month']) && $_GET['month'] == 'July'){ echo 'selected'; }else if(date('F') == 'July'){ echo 'selected'; } ?>>July</option>
								<option value='August' <?php if(isset($_GET['month']) && $_GET['month'] == 'August'){ echo 'selected'; }else if(date('F') == 'August'){ echo 'selected'; } ?>>August</option>
								<option value='September' <?php if(isset($_GET['month']) && $_GET['month'] == 'September'){ echo 'selected'; }else if(date('F') == 'September'){ echo 'selected'; } ?>>September</option>
								<option value='October' <?php if(isset($_GET['month']) && $_GET['month'] == 'October'){ echo 'selected'; }else if(date('F') == 'October'){ echo 'selected'; } ?>>October</option>
								<option value='November' <?php if(isset($_GET['month']) && $_GET['month'] == 'November'){ echo 'selected'; }else if(date('F') == 'November'){ echo 'selected'; } ?>>November</option>
								<option value='December' <?php if(isset($_GET['month']) && $_GET['month'] == 'December'){ echo 'selected'; }else if(date('F') == 'December'){ echo 'selected'; } ?>>December</option>  
                            </select>
						</div>
						<div class="col-md-3">
					    <label>Year</label>
						<select class="select2 form-control mb-3 custom-select" name="year" id="year" required>
                            <?php 
                            $firstYear = 2000;
                            $lastYear = (int)date('Y')+1;
                            for($i=$lastYear;$i>=$firstYear;$i--)
                            {
                                if(isset($_GET['year']) && $_GET['year'] == $i){
                                    echo '<option value='.$i.' selected>'.$i.'</option>';
                                }elseif(date('Y') == $i){
                                    echo '<option value='.$i.' selected>'.$i.'</option>';
                                }else{
                                    echo '<option value='.$i.'>'.$i.'</option>';
                                }
                            }
                            ?>
                        </select>
					</div>
                    <div class="col-md-3">
                        <label class="col-md-12">&nbsp;</label> 						
						<input type="submit" id="generate_salary" class="btn btn-primary btn-large" name="generate_salary" value="Generate">   
						</div>
						</div>
						</form>
					<hr><?*/?>
                    <!--<form action="" method="post" id="search-emp-form">-->
                    <form action="<?= base_url('Payroll/payablesalaryfilter');?>" method="post">    
                        <div class="row">
						<div class="col-md-4">
							<label>Name</label>
							<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="fld_emp_name" id="fld_emp_id">
                                    <option selected="selected" value="">All Employees</option>
									<?php
									    $employees	=	$this->Common_model->select_where_ASC_DESC('id,full_name','tbl_employees',array('deleted'=>0,'is_active'=>1),'full_name','ASC');
										if($employees->num_rows() > 0){
										foreach($employees->result() as $emp){
									?>
									<option value="<?= $emp->id;?>" <?php if(isset($_GET['name']) && $_GET['name'] == $emp->id){ echo 'selected'; } ?>><?= $emp->full_name;?></option>
									<?php }} ?>
                            </select>
						</div>
						 
						 <div class="col-md-4">
							<label>Search By Designation</label>
							<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" id="designation" name="designation">
                                <option value="">Showing All Designations</option>
                                <?php $tbl_designation	=	$this->Common_model->select_where_ASC_DESC('id,designation_name','tbl_designation',array('deleted'=>0),'designation_name','ASC');
                                    if($tbl_designation->num_rows() > 0) {
                                    foreach($tbl_designation->result() as $desig) {
                                ?>
                                    <option value="<?php echo $desig->id;?>" <?php if(isset($_GET['designation']) && $_GET['designation'] == $desig->id){ echo 'selected'; } ?>><?php echo $desig->designation_name;?></option>
                                <?php } } ?>
                            </select>
						 </div>
						 <div class="col-md-4">
						    <label>Month</label>
							<select class="select2 form-control mb-3 custom-select" name="month" id="month">
                                <option value="">Select Month</option>
								<option value='Janaury' <?php if(isset($_GET['month']) && $_GET['month'] == 'Janaury'){ echo 'selected'; } ?>>Janaury</option>
								<option value='February' <?php if(isset($_GET['month']) && $_GET['month'] == 'February'){ echo 'selected'; } ?>>February</option>
								<option value='March' <?php if(isset($_GET['month']) && $_GET['month'] == 'March'){ echo 'selected'; } ?>>March</option>
								<option value='April' <?php if(isset($_GET['month']) && $_GET['month'] == 'April'){ echo 'selected'; } ?>>April</option>
								<option value='May' <?php if(isset($_GET['month']) && $_GET['month'] == 'May'){ echo 'selected'; } ?>>May</option>
								<option value='June' <?php if(isset($_GET['month']) && $_GET['month'] == 'June'){ echo 'selected'; } ?>>June</option>
								<option value='July' <?php if(isset($_GET['month']) && $_GET['month'] == 'July'){ echo 'selected'; } ?>>July</option>
								<option value='August' <?php if(isset($_GET['month']) && $_GET['month'] == 'August'){ echo 'selected'; } ?>>August</option>
								<option value='September' <?php if(isset($_GET['month']) && $_GET['month'] == 'September'){ echo 'selected'; } ?>>September</option>
								<option value='October' <?php if(isset($_GET['month']) && $_GET['month'] == 'October'){ echo 'selected'; } ?>>October</option>
								<option value='November' <?php if(isset($_GET['month']) && $_GET['month'] == 'November'){ echo 'selected'; } ?>>November</option>
								<option value='December' <?php if(isset($_GET['month']) && $_GET['month'] == 'December'){ echo 'selected'; } ?>>December</option>  
                            </select>
						</div>
						 </div>
                        
						<div class="row" style="margin-top: 30px;">
						 <div class="col-md-3">
					    <label>Year</label>
						<select class="select2 form-control mb-3 custom-select" name="year" id="year">
						    <option value="">Select Year</option>
                            <?php 
                            $firstYear = 2000;
                            $lastYear = (int)date('Y')+1;
                            for($i=$lastYear;$i>=$firstYear;$i--)
                            {
                            ?>
                                   <option value="<?=$i;?>" <?php if(isset($_GET['year']) && $_GET['year'] == $i){ echo 'selected'; } ?>><?=$i;?></option>
                            <? } ?>
                        </select>
					</div>   
						 <div class="col-md-6" style="margin-top:30px;">
						        <!--<button class="btn btn-primary btn-large" type="button" aria-controls="step-2" onclick="getFilterEmployee();" aria-expanded="false" id="show_report_1"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Search F10</button>&nbsp;&nbsp;-->
						        <!--<button class="btn btn-primary btn-large" type="button"><i class="fa fa-search"></i>&nbsp;Search F10</button>&nbsp;&nbsp;-->
						        <input type="submit" class="btn btn-successs btn-large" name="submit" value="Proceed F10" />&nbsp;
						        <button class="btn btn-danger" type="button" aria-controls="step-2" onclick="window.location.href='<?=base_url().'Payroll/payablesalaries';?>'" aria-expanded="false"><i class="fa fa-refresh" aria-hidden="true"></i>&nbsp;Reset F5</button>
						    </div>
						</div>
						<br>
						</form>
	                <hr>
                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>Month</th>
                            <th>Name/Designation</th>
							<th>Salary to be paid</th>
                            <th>Account</th>
                            <th>Via</th>
                            <!--<th>Narration</th>-->
                            <th>Amount Paid</th>
                            <th>Pay Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody id="employee_data">
						<?php 
							if($payroll){
							$sn=1;
							foreach($payroll as $emp){ 
							$sn++;
							$designation =	$this->Common_model->select_single_field('designation_name','tbl_designation',array('id'=>$emp['designation']));       
						  //$department  =	$this->Common_model->select_single_field('department_name','tbl_departments',array('id'=>$emp['department']));
							$plant       =	$this->Common_model->select_single_field('fld_location','tbl_locations',array('fld_id'=>$emp['plants']));
							$emoloyee        =	$this->Common_model->select_where('*','tbl_employees',array('id'=>$emp['user_id']))->row_array();
							$debit = $this->db->query("SELECT IFNULL(SUM(debit), 0) as debit FROM tbl_transections_details WHERE coa_id = '{$emoloyee['accounts_id']}'")->row()->debit;
                            $credit = $this->db->query("SELECT IFNULL(SUM(credit), 0) as credit FROM tbl_transections_details WHERE coa_id = '{$emoloyee['accounts_id']}'")->row()->credit;
                            $balance = number_format(($debit-$credit), 2, '.', ',');
						?>
                        <tr>
                            <td><input type="hidden" id="payroll_id_<?php echo $sn; ?>" value="<?=$emp['id']; ?>" /><?=$emp['month'].', '.$emp['year'];?></td>
                            <td>
                            <?=$emoloyee['full_name'].'<br>';
                             echo '<span style="width: 130px; display: inline-block;color:#21d0c0; font-size:10px;">'.$designation.'</span>'.'<br>';
                             echo '<span style="width: 130px; display: inline-block;color:#ef4d56; font-size:12px;"><i>(Balance: '.$balance.')</i></span>';
                            ?></td>
							
							<td>
							    <?=$emp['basic_salary'];?>
							    <!--<input type="text" name="amounttobepaid[]" class="form-control" placeholder="0.00" value="" min="0" required>-->
							</td>
							<td>
							    <span style="width: 130px; display: inline-block;color:#21d0c0; font-size:10px;">From</span>
							<select class="select2 form-control mb-3 custom-select" onchange="getBalance(<?php echo $sn; ?>, this.value);" name="from_account_<?php echo $sn; ?>" id="from_account_<?php echo $sn; ?>" required style="width:100%;">
                                <option value="">Select Account</option>
                                <?php
        							if($cash_accounts){
        							foreach($cash_accounts as $account){
        						?>
        						<option value="<?=$account['head_code'];?>"><?= $account['head_name'];?></option>
        						<?php } } ?>
        						<?php
        							if($bank_accounts){
        							foreach($bank_accounts as $account){
        						?>
        						<option value="<?=$account['head_code'];?>"><?= $account['head_name'];?></option>
        						<?php } } ?>
							</select>
							<i class="text-danger" id="f_balance_<?php echo $sn; ?>">(Balance: 0)</i>
							<input type="hidden" id="f_InputBalance_<?php echo $sn; ?>" value="0"/><br><br>
							
							<input type="text" id="narration_<?php echo $sn; ?>" name="narration[]" onchange="validVal(<?php echo $sn; ?>);" onkeyup="validVal(<?php echo $sn; ?>);" class="form-control text-center" placeholder="Paymet's nature and description">
							<!--<span style="width: 130px; display: inline-block;color:#21d0c0; font-size:10px;">Via</span>-->
							</td>
							<td>
							<select class="select2 form-control mb-3 custom-select" onchange="validVal(<?php echo $sn; ?>);"  name="salary_type_<?php echo $sn; ?>" id="salary_type_<?php echo $sn; ?>" required style="width:100%;">
                                <option value="">Select Type</option>
                                <option value="Cash">Cash</option>
                                <?php 
                                    if($emoloyee['account_no']!=''){
                                    $emoloyee['bank_name'] = $this->db->query("SELECT * FROM tbl_banks_employees WHERE fld_id = '{$emoloyee['bank_name']}'")->row()->fld_bank;
                                ?>
                                <option value="<?php echo $emoloyee['bank_name']; ?> (<?php echo $emoloyee['account_no']; ?>)"><?php echo $emoloyee['bank_name']; ?> (<?php echo $emoloyee['account_no']; ?>)</option>
                                <?php } ?>
							</select>
							</td>
							<!--<td width="20%"></td>-->
							<td><input type="number" name="amount[]" required="" id="amount_<?php echo $sn; ?>" onchange="validVal(<?php echo $sn; ?>);" onkeyup="validVal(<?php echo $sn; ?>);" class="form-control amount text-right" placeholder="0.00" value="" min="0" required></td>
							<td width="15%"><input type="text" class="form-control datepicker" name="paydate[]" id="pay_date_<?php echo $sn; ?>" value="<?= date('d/m/Y')?>">	</td>
							<td><input type="button" name="submit" onclick="paySalary(this, <?php echo $sn; ?>);" value="Submit" id="submit_button_<?php echo $sn; ?>" class="btn btn-primary" disabled></td>
						</tr>
						<?php }}else{ ?>
						<tr>
							<td colspan="9"><br><p style="color:#900;text-align:center">Sorry No Record Found!</p></td>
						</tr>
						<? } ?>
						</tbody>
                    </table>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
</div>
<script>

function validVal(sn){
    var from_account = $("#from_account_"+sn).val();
    var salary_type = $("#salary_type_"+sn).val();
    var narration = $("#narration_"+sn).val();
    var amount = $("#amount_"+sn).val();
    var availableamount = $("#f_InputBalance_"+sn).val();
    
    if(from_account=='' || salary_type=='' || amount=='' || parseFloat(amount) > parseFloat((availableamount.replace(/,/g, '')))){
        $("#submit_button_"+sn).attr( "disabled", "disabled" );
    }else{
        $('#submit_button_'+sn).removeAttr('disabled');
    }
}

function paySalary(e, sn){
    var payroll_id = $("#payroll_id_"+sn).val();
    console.log(payroll_id);
    var from_account = $("#from_account_"+sn).val();
    var salary_type = $("#salary_type_"+sn).val();
    var narration = $("#narration_"+sn).val();
    var amount = $("#amount_"+sn).val();
    var paydate = $("#pay_date_"+sn).val();
    
    var dataVal = {payroll_id:payroll_id, from_account:from_account, salary_type:salary_type, narration:narration, amount:amount, paydate:paydate};
    
    $.ajax({
			url:"<?php echo base_url(); ?>Payroll/paySalary",
			dataType: "text",
			type: "POST",
			data: dataVal,
			success: function(res) {
			    console.log(res);
			    $.notify("Salary has been paid","success");	
			    if(res=='Paid'){
			        var a = e.parentNode.parentNode;
                    a.parentNode.removeChild(a)
			    }
			}
		})
}

function updateValue(key, id){
        
        var salary = $("#basic_salary_"+id).val() || 0;
        var bonus = $("#bonus_"+id).val() || 0;
        var deduction = $("#deduction_"+id).val() || 0;
        var presentdays = $("#present_days_"+id).val() || 0;
        var absentdays = $("#absent_days_"+id).val() || 0;
        var perdaysalary = salary / 30;
        var basicsalary = perdaysalary * presentdays;
        var total = 0;
        total = parseInt(basicsalary)+parseInt(bonus)-parseInt(deduction);
        console.log("TOTAL", total, "Salary", parseInt(salary), "Bonus", parseInt(bonus), "Deduction", parseInt(deduction), "Present", presentdays, "Absent", absentdays , "Per Day", perdaysalary , "Basic Sel", basicsalary);
        $("#todal_"+id).html(total);
        var postData;
        if(key == 'salary'){
            postData = 'name=basic_salary&value='+parseInt(salary)+'&pk='+id;
        }else if(key == 'bonus'){
            postData = 'name=bonus&value='+parseInt(bonus)+'&pk='+id;
        }else if(key == 'deduction'){
            postData = 'name=deduction&value='+parseInt(deduction)+'&pk='+id;
        }else if(key == 'presentdays'){
            postData = 'name=present_days&value='+parseInt(presentdays)+'&pk='+id;
        }else if(key == 'absentdays'){
            var newpday = 30-absentdays;
            $("#present_days_"+id).val(newpday).change();
            postData = 'name=absent_days&value='+parseInt(absentdays)+'&pk='+id;
        }
        
        jQuery.ajax({
				url  	: base_url+"Payroll/update_payroll",
				type 	: 'POST',
				data 	: postData,
				success : function(data){
				    
				}
		});	
}

</script>

<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
<!--<script src="https://netdna.bootstrapcdn.com/bootstrap/2.3.2/js/bootstrap.min.js"></script>-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>-->
<!--<script>-->
 <!--$(document).ready(function() {-->
 <!--  $("#datepicker").datepicker( {-->
 <!--    format: "mm-yyyy",-->
 <!--  startView: "months", -->
 <!--    minViewMode: "months"-->
 <!--});-->
 <!--});-->
<!--</script>-->