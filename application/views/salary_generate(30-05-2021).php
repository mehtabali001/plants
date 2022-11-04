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
			<div class="float-right">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Payroll/generatesalaries" type="button" class="btn btn-primary btn-large"><i class="fa fa-file-text-o"></i>&nbsp;Generate Salaries</a>
                  <a href="<?= base_url();?>Payroll" type="button" class="btn btn-outline-primary"><i class="fa fa-address-card-o"></i>&nbsp;Salary Reports</a>
                </div>
			</div>
			<h4 class="page-title">Payroll</h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="javascript:void(0);">Payroll</a></li>
				<li class="breadcrumb-item active">Generate Salaries</li>
			</ol>
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
						<form id="addPayroll" action="<?= base_url('Payroll/createSalary');?>" class="form-vertical"  method="post" >
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
						    <label class="col-md-12">Plants</label>
						    <select class="select2 form-control mb-3 custom-select" name="selectplants" id="selectplants" onchange='checkvalue(this.value)' required>
								<option value='all' <?php if(isset($_GET['selectplants']) && $_GET['selectplants'] == 'all'){ echo 'selected'; } ?>>All</option>
								<option value='plantwise' <?php if(isset($_GET['selectplants']) && $_GET['selectplants'] == 'plantwise'){ echo 'selected'; } ?>>Plantwise</option> 
                            </select>
						    <!--<div class="radio radio-info form-check-inline" style="margin-top: 10px;">
								<input type="radio" id="inlineRadio1" value="all" name="radioInline" onclick="show1();" required>
								<label for="inlineRadio1"> All </label>
							</div>
							<div class="radio radio-info form-check-inline" style="margin-top: 10px;">
								<input type="radio" id="inlineRadio2" value="plantwise" name="radioInline" onclick="show2();" required>
								<label for="inlineRadio2"> Plantwise Employees </label>
							</div>-->
							
							<div class="<?php if(isset($_GET['selectplants']) && $_GET['selectplants'] != 'all'){ echo 'show'; }else{ echo 'hide'; } ?>" id="div1">
								<div class="form-group row">
									<div class="col-sm-12">
										<select class="form-control" id="plants" name="plants">
											<?php 
												$tbl_plants	 =	$this->Common_model->select_where_ASC_DESC('fld_id,fld_location','tbl_locations',array('fld_status'=>1),'fld_location','ASC');
												if($tbl_plants->num_rows() > 0) {
												foreach($tbl_plants->result() as $plant){
											?>
												<option value="<?php echo $plant->fld_id;?>" <?php if(isset($_GET['plants']) && $_GET['plants'] == $plant->fld_id){ echo 'selected'; } ?>><?php echo $plant->fld_location;?></option>
											<?php } } ?>
										</select>
									</div>
								</div>
							</div>
						</div>
						
						<div class="col-md-3">
						   <label class="col-md-12">Status</label>
						   <select class="select2 form-control mb-3 custom-select" name="salary_status" id="salary_status" required>
								<option value='1' <?php if(isset($_GET['salary_status']) && $_GET['salary_status'] == '1'){ echo 'selected'; } ?>>Paid</option>
								<option value='2' <?php if(isset($_GET['salary_status']) && $_GET['salary_status'] == '2'){ echo 'selected'; } ?>>Unpaid</option> 
                            </select>
						</div>
                        <div class="col-md-3">
                        <label class="col-md-12">&nbsp;</label> 						
						<input type="submit" id="generate_salary" class="btn btn-primary btn-large" name="generate_salary" value="Generate">   
						</div>
						 
						</div>
						</form>
						 <hr>

                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>Sr#</th>
                            <th>Month</th>
                            <th>Name</th>
                            <th>Designation</th>
							<th>Salary(PKR)</th>
							<th>Present Days</th>
							<th>Absent Days</th>
							<th>Bonus(PKR)</th>
							<th>Deduction(PKR)</th>
                            <th>Total(PKR)</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody id="employee_data">
						<?php 
						    $i = 1;
							if($payroll){
							foreach($payroll as $emp){ 
							$designation =	$this->Common_model->select_single_field('designation_name','tbl_designation',array('id'=>$emp['designation']));       
						  //$department  =	$this->Common_model->select_single_field('department_name','tbl_departments',array('id'=>$emp['department']));
							$plant       =	$this->Common_model->select_single_field('fld_location','tbl_locations',array('fld_id'=>$emp['plants']));
							$name        =	$this->Common_model->select_single_field('full_name','tbl_employees',array('id'=>$emp['user_id']));
						?>
                        <tr>
                            <td><?=$i++;?></td>
                            <td><?=$emp['month'];?></td>
                            <td><?=$name;?></td>
                            <td><?=$designation;?></td>
							<td class="basic_salary"> 
							  <?=$emp['basic_salary'];?>
    						  <input type="hidden" style="width: 100%;height: 100%;background: #12183e;border: none;color: white;padding: 10px;" value="<?=$emp['basic_salary'];?>"  id="basic_salary_<?=$emp['id'];?>">
							</td>
							<td class="present_days">
							    <input type="text" style="width: 100%;height: 100%;background: #12183e;border: none;color: white;padding: 10px;" value="<?=$emp['present_days'];?>" onkeyup="updateValue('presentdays', <?=$emp['id'];?>)" onblur="updateValue('presentdays', <?=$emp['id'];?>)" id="present_days_<?=$emp['id'];?>" readonly>
							</td>
							<td class="absent_days">
							    <?
							        // Get Absent Days
			                        //$qrry = $this->db->query("SELECT * FROM tbl_attendance WHERE user_id = '".$emp['user_id']."' AND attendance_status = 'Absent'");
			                        
							    ?>
							    <input type="number" style="width: 100%;height: 100%;background: #12183e;border: none;color: white;padding: 10px;" min=0 max=30 value="<?=$emp['absent_days'];?>" onkeyup="updateValue('absentdays', <?=$emp['id'];?>)" onblur="updateValue('absentdays', <?=$emp['id'];?>)" id="absent_days_<?=$emp['id'];?>">
							</td>
							<td class="bonus">
							  <input type="number" style="width: 100%;height: 100%;background: #12183e;border: none;color: white;padding: 10px;" value="<?=$emp['bonus'];?>" onkeyup="updateValue('bonus', <?=$emp['id'];?>)" onblur="updateValue('bonus', <?=$emp['id'];?>)"  id="bonus_<?=$emp['id'];?>">
							</td>
                            <td class="deduction">
							  <input type="number" style="width: 100%;height: 100%;background: #12183e;border: none;color: white;padding: 10px;" value="<?=$emp['deduction'];?>" onkeyup="updateValue('deduction', <?=$emp['id'];?>)" onblur="updateValue('deduction', <?=$emp['id'];?>)"  id="deduction_<?=$emp['id'];?>">
							</td>
                            <td id="todal_<?=$emp['id'];?>">
							<?php 
						    $perdaysalary = (int) $emp['basic_salary'] / 30;
						    $basic_salary = $perdaysalary * $emp['present_days'];
							echo (int) $basic_salary + (int) $emp['bonus']- (int) $emp['deduction'];?>
                            </td>
                            <td>
                              <?
                               if($emp['salary_status'] == 1){
                                   echo "Paid";
                               }else{
                                   echo "Unpaid";
                               }
                              ?>
                            </td>
						</tr>
						<?php }}else{ ?>
						<tr>
							<td colspan="11"><br><p style="color:#900;text-align:center">Sorry No Record Found!</p></td>
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