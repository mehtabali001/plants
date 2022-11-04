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
<? $role_permissions  = explode(",",$this->session->userdata('permissions')); ?>
<div class="container-fluid">
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right" style="margin-bottom:15px;">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Payroll/paidsalaries" type="button" class="btn btn-primary btn-large"><i class="fa fa-file-text-o"></i>&nbsp;Paid Salaries</a>
                  <a href="<?= base_url();?>Payroll/manage_salarysetup" type="button" class="btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;View Salary Setup</a>
                  <a href="<?= base_url();?>Payroll/generatesalaries" type="button" class="btn btn-outline-primary"><i class="fas fa-money-bill-alt"></i></i>&nbsp;Generate Salaries</a>
                  <a href="<?= base_url();?>Payroll" type="button" class="btn btn-outline-primary"><i class="fa fa-bar-chart"></i>&nbsp;Salaries Report</a>
                </div>
			</div>
			<!--<h4 class="page-title">Payroll</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Salaries</a></li>-->
			<!--	<li class="breadcrumb-item active">Paid Salaries</li>-->
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
                        }
                        ?>
                        </div>
						<form action="" method="post" id="search-paidsalaries-form">
						<div class="row">  
						<div class="col-md-3">
						    <label>Month</label>
							<select class="select2 form-control mb-3 custom-select" name="month" id="month">
                                <option value="">Select Month</option>
								<option value='Janaury' <?php //if(isset($_GET['month']) && $_GET['month'] == 'Janaury'){ echo 'selected'; }else if(date('F') == 'Janaury'){ echo 'selected'; } ?>>Janaury</option>
								<option value='February' <?php //if(isset($_GET['month']) && $_GET['month'] == 'February'){ echo 'selected'; }else if(date('F') == 'February'){ echo 'selected'; } ?>>February</option>
								<option value='March' <?php //if(isset($_GET['month']) && $_GET['month'] == 'March'){ echo 'selected'; }else if(date('F') == 'March'){ echo 'selected'; } ?>>March</option>
								<option value='April' <?php //if(isset($_GET['month']) && $_GET['month'] == 'April'){ echo 'selected'; }else if(date('F') == 'April'){ echo 'selected'; } ?>>April</option>
								<option value='May' <?php //if(isset($_GET['month']) && $_GET['month'] == 'May'){ echo 'selected'; }else if(date('F') == 'May'){ echo 'selected'; } ?>>May</option>
								<option value='June' <?php //if(isset($_GET['month']) && $_GET['month'] == 'June'){ echo 'selected'; }else if(date('F') == 'June'){ echo 'selected'; } ?>>June</option>
								<option value='July' <?php //if(isset($_GET['month']) && $_GET['month'] == 'July'){ echo 'selected'; }else if(date('F') == 'July'){ echo 'selected'; } ?>>July</option>
								<option value='August' <?php //if(isset($_GET['month']) && $_GET['month'] == 'August'){ echo 'selected'; }else if(date('F') == 'August'){ echo 'selected'; } ?>>August</option>
								<option value='September' <?php //if(isset($_GET['month']) && $_GET['month'] == 'September'){ echo 'selected'; }else if(date('F') == 'September'){ echo 'selected'; } ?>>September</option>
								<option value='October' <?php //if(isset($_GET['month']) && $_GET['month'] == 'October'){ echo 'selected'; }else if(date('F') == 'October'){ echo 'selected'; } ?>>October</option>
								<option value='November' <?php //if(isset($_GET['month']) && $_GET['month'] == 'November'){ echo 'selected'; }else if(date('F') == 'November'){ echo 'selected'; } ?>>November</option>
								<option value='December' <?php //if(isset($_GET['month']) && $_GET['month'] == 'December'){ echo 'selected'; }else if(date('F') == 'December'){ echo 'selected'; } ?>>December</option>  
                            </select>
						</div>
						<div class="col-md-3">
					    <label>Year</label>
						<select class="select2 form-control mb-3 custom-select" name="year" id="year">
						    <option value="">Select Year</option>
                            <?php 
                            $firstYear = 2000;
                            $lastYear = (int)date('Y')+1;
                            for($i=$lastYear;$i>=$firstYear;$i--)
                            {
                                // if(isset($_GET['year']) && $_GET['year'] == $i){
                                //     echo '<option value='.$i.' selected>'.$i.'</option>';
                                // }elseif(date('Y') == $i){
                                //     echo '<option value='.$i.' selected>'.$i.'</option>';
                                // }else{
                                    echo '<option value='.$i.'>'.$i.'</option>';
                                //}
                            }
                            ?>
                        </select>
					</div>
					<div id="filter_col2" data-column="1" class="col-md-3">
						<label>Name</label>
						<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="fld_emp_name" id="fld_emp_id">
                                <option selected="selected" value="">All Employees</option>
								<?php
								    $employees	=	$this->Common_model->select_where_ASC_DESC('id,full_name','tbl_employees',array('deleted'=>0,'is_active'=>1),'full_name','ASC');
									if($employees->num_rows() > 0){
									foreach($employees->result() as $emp){
								?>
								<option value="<?= $emp->id;?>"><?= $emp->full_name;?></option>
								<?php }} ?>
                        </select>
					</div>
					<div id="filter_col4" data-column="3" class="col-md-3">
							<label>Search By Designation</label>
							<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" id="designation" name="designation" >
                                <option value="">Showing All Designations</option>
                                <?php $tbl_designation	=	$this->Common_model->select_where_ASC_DESC('id,designation_name','tbl_designation',array('deleted'=>0),'designation_name','ASC');
                                    if($tbl_designation->num_rows() > 0) {
                                    foreach($tbl_designation->result() as $desig) {
                                ?>
                                    <option value="<?php echo $desig->id;?>" ><?php echo $desig->designation_name;?></option>
                                <?php } } ?>
                            </select>
					</div>
					<div id="filter_col4" data-column="3" class="col-md-3">
							<label>Paid From</label>
							<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" id="from_account" name="from_account" >
                                <option value="">Select Account</option>
                                <?php 
                                    $from_accounts = $this->db->select('*')->from('tbl_coa')->where('head_code!=', '101001')->like('head_code', '101001', 'both')->get()->result_array();
                                    if($from_accounts){
        							foreach($from_accounts as $account){
        						?>
        						<option value="<?=$account['head_name'];?>"><?= $account['head_name'];?></option>
        						<?php } } ?>
                            </select>
					</div>
                    <div class="col-md-6">
                        <label class="col-md-12">&nbsp;</label> 						
						<button class="btn btn-successs btn-large" type="button" aria-controls="step-2" onclick="getFilterPaidsalaries();" aria-expanded="false"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Proceed</button>&nbsp;
						<button class="btn btn-danger" type="button" aria-controls="step-2" onclick="window.location.href='<?=base_url().'Payroll/paidsalaries';?>'" aria-expanded="false"><i class="fa fa-refresh" aria-hidden="true"></i>&nbsp;Reset</button>
					</div>
						</div>
						</form>
					<hr>

                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>MM/YY</th>
                            <th>Name/Designation</th>
							<th>Amount to be paid</th>
							<th>Amount paid</th>
                            <th>Via</th>
                            <th>Paid From</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody id="employee_data">
						<?php
							if($payroll){
							foreach($payroll as $emp){ 
							$designation =	$this->Common_model->select_single_field('designation_name','tbl_designation',array('id'=>$emp['designation']));       
						  //$department  =	$this->Common_model->select_single_field('department_name','tbl_departments',array('id'=>$emp['department']));
							$plant       =	$this->Common_model->select_single_field('fld_location','tbl_locations',array('fld_id'=>$emp['plants']));
							$name        =	$this->Common_model->select_single_field('full_name','tbl_employees',array('id'=>$emp['user_id']));
						?>
                        <tr>
                            <td><?=$emp['month'].', '.$emp['year'];?><br><?php if($emp['salary_status']==1){ ?><span style="color: green;font-size: 10px;font-style: italic;">Paid on <?=date('d/m/y', strtotime($emp['paid_date'])); ?></span><?php } ?></td>
                            <td>
                            <?=$name.'<br>';
                             echo '<span style="width: 130px; display: inline-block;color:#21d0c0; font-size:10px;">'.$designation.'</span>';
                            ?></td>
							<td>
							    <?=$emp['basic_salary'];?>
							</td>
							<td>
							    <?=$emp['amount_paid'];?>
							</td>
							<td>
							    <?=$emp['paid_via'];?>
							</td>
							<td>
							    <?=$emp['paid_from'];?>
							</td>
							<td>
							<? if(!empty($role_permissions) && in_array(154,$role_permissions)) { ?>    
							<a href="#" onclick="window.open('<?= base_url();?>Payroll/print_single_salary/<?=$emp['id'];?>', 'Salary Report', 'width=1210, height=842');">
							<i style="font-size:15px;cursor:pointer;" class="mdi mdi-printer" title="Print"></i></a>
							<? } ?>
                            
                            <? if(!empty($role_permissions) && in_array(155,$role_permissions)) { ?>
							<a href="#" onclick="window.open('<?= base_url();?>Payroll/pdf_single_salary/<?=$emp['id'];?>', 'Salary Report');">
							<i style="font-size:15px;cursor:pointer;" class="mdi mdi-file-pdf" title="Pdf"></i></a>
							<? } ?>
							
							<? if(!empty($role_permissions) && in_array(156,$role_permissions)) { ?>
							<a href="<?= base_url('Payroll/viewpaidsalary/'.$emp['id'].'')?>"><i style="font-size:15px;cursor:pointer;" class="mdi mdi-eye-circle-outline" title="View"></i></a>
							<? } ?>

							</td>
						</tr>
						<?php }}else{ ?>
						<tr>
							<td colspan="7"><p style="color:red;text-align:center;">Sorry No Record Found!</p></td>
						</tr>
						<?php } ?>
						</tbody>
                    </table>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
</div>
<script>

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