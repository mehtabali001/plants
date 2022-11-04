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
  color: #d1d6e8;
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
			<?/*?><div class="float-right">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Employees" type="button" class="btn btn-outline-primary"><i class='fas fa-user-plus'></i>&nbsp;Add Employee</a>
                  <a href="<?= base_url();?>Employees/manage_Employees" type="button" class="btn btn-outline-primary"><i class='fas fa-user-cog'></i>&nbsp;Manage Employee</a>
                  <a href="<?= base_url();?>Employees/attendance" type="button" class="btn btn-primary btn-large"><i class="fa fa-clock-o"></i>&nbsp;Attendence</a>
                </div>&nbsp;&nbsp;
				<a type="button" class="btn btn-secondary btn-round waves-effect waves-light" href="#openModal"><i class="ti-plus"></i>Add Attendence</a>
			</div><?*/?>
			<h4 class="page-title">Payroll</h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="javascript:void(0);">Payroll</a></li>
				<li class="breadcrumb-item active">Salaries Report</li>
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
						<form id="addPayroll" action="<?= base_url('Payroll/createPayroll');?>" class="form-vertical"  method="post" >
						<div class="row">  
						
						<div class="col-md-3">
						    <label>Month</label>
							<select class="form-control mb-3" name="month" id="month" required>
                                <option value="">Select Month</option>
								<option value='Janaury'>Janaury</option>
								<option value='February'>February</option>
								<option value='March'>March</option>
								<option value='April'>April</option>
								<option value='May'>May</option>
								<option value='June'>June</option>
								<option value='July'>July</option>
								<option value='August'>August</option>
								<option value='September'>September</option>
								<option value='October'>October</option>
								<option value='November'>November</option>
								<option value='December'>December</option>  
                            </select>
						</div>

						<div class="col-md-3">
						    <label class="col-md-12">Plants</label>
						    <select class="form-control mb-3" name="selectplants" id="selectplants" onchange='checkvalue(this.value)' required>
                                <option value="">Select</option>
								<option value='all'>All</option>
								<option value='plantwise'>Plantwise</option> 
                            </select>
						    <!--<div class="radio radio-info form-check-inline" style="margin-top: 10px;">
								<input type="radio" id="inlineRadio1" value="all" name="radioInline" onclick="show1();" required>
								<label for="inlineRadio1"> All </label>
							</div>
							<div class="radio radio-info form-check-inline" style="margin-top: 10px;">
								<input type="radio" id="inlineRadio2" value="plantwise" name="radioInline" onclick="show2();" required>
								<label for="inlineRadio2"> Plantwise Employees </label>
							</div>-->
							
							<div class="hide" id="div1">
								<div class="form-group row">
									<div class="col-sm-12">
										<select class="form-control" id="plants" name="plants">
											<option value="">--Select Plant--</option>
											<?php 
												$tbl_plants	 =	$this->Common_model->select_where_ASC_DESC('fld_id,fld_location','tbl_locations',array('fld_status'=>1),'fld_location','ASC');
												if($tbl_plants->num_rows() > 0) {
												foreach($tbl_plants->result() as $plant){
											?>
												<option value="<?php echo $plant->fld_id;?>"><?php echo $plant->fld_location;?></option>
											<?php } } ?>
										</select>
									</div>
								</div>
							</div>
						</div>
						
						<div class="col-md-3">
						   <label class="col-md-12">Designation</label>
						   <select class="form-control mb-3" name="selectdesignation" id="selectdesignation" onchange='checkvalue2(this.value)' required>
                                <option value="">Select</option>
								<option value='all'>All</option>
								<option value='designationwise'>Designation Wise</option> 
                            </select>
						   <!--<div class="radio radio-info form-check-inline" style="margin-top: 10px;">
								<input type="radio" id="inlineRadio3" value="all" name="radioInline" onclick="show3();" required>
								<label for="inlineRadio3"> All </label>
							</div>
							<div class="radio radio-info form-check-inline" style="margin-top: 10px;">
								<input type="radio" id="inlineRadio4" value="designationwise" name="radioInline" onclick="show4();" required>
								<label for="inlineRadio4"> Designation wise </label>
							</div>-->
							<div class="hide" id="div2">
								<div class="form-group row ">
									<div class="col-sm-12">
										<select class="form-control" id="designation" name="designation">
											<option value="">--Select Designation--</option>
											<?php 
												$tbl_designation	=	$this->Common_model->select_where_ASC_DESC('id,designation_name','tbl_designation',array('deleted'=>0),'designation_name','ASC');
												if($tbl_designation->num_rows() > 0) {
												foreach($tbl_designation->result() as $desig){
											?>
												<option value="<?php echo $desig->id;?>"><?php echo $desig->designation_name;?></option>
											<?php } } ?>
										</select>
									</div>
								</div>
							</div>
						</div>
                        <div class="col-md-3">
                        <label class="col-md-12">&nbsp;</label> 						
						<input type="submit" id="create_payroll" class="btn btn-primary btn-large" name="create_payroll" value="Submit">   
						</div>
						 
						</div>
						</form>
						 <hr>

                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>Month</th>
                            <th>Full Name</th>
							<th>Plant</th>
                            <th>Designation</th>
							<th>Basic Salary</th>
							<th>Bonus</th>
							<th>Deduction</th>
                            <th>Total</th>
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
                            <td><?=$emp['month'];?></td>
                            <td><?=$name;?></td>
							<td><?=$plant;?></td>
                            <td><?=$designation;?></td>
							<td class="basic_salary">
							    <input type="number" style="width: 100%;height: 100%;background: #12183e;border: none;color: white;padding: 10px;" value="<?=$emp['basic_salary'];?>" onkeyup="updateValue('salary', <?=$emp['id'];?>)" onblur="updateValue('salary', <?=$emp['id'];?>)" id="basic_salary_<?=$emp['id'];?>">
    						</td>
							<td class="bonus">
							  <input type="number" style="width: 100%;height: 100%;background: #12183e;border: none;color: white;padding: 10px;" value="<?=$emp['bonus'];?>" onkeyup="updateValue('bonus', <?=$emp['id'];?>)" onblur="updateValue('bonus', <?=$emp['id'];?>)"  id="bonus_<?=$emp['id'];?>">
							</td>
                            <td class="deduction">
							  <input type="number" style="width: 100%;height: 100%;background: #12183e;border: none;color: white;padding: 10px;" value="<?=$emp['deduction'];?>" onkeyup="updateValue('deduction', <?=$emp['id'];?>)" onblur="updateValue('deduction', <?=$emp['id'];?>)"  id="deduction_<?=$emp['id'];?>">
							</td>
                            <td id="todal_<?=$emp['id'];?>">
							<?php echo (int) $emp['basic_salary']+ (int) $emp['bonus']- (int) $emp['deduction'];?>
                            </td>
						</tr>
						<?php }}else{ ?>
						<tr>
							<td colspan="8"><br><p style="color:#900;">Sorry No Record Found!</p></td>
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
        var total = 0;
        total = parseInt(salary)+parseInt(bonus)-parseInt(deduction);
        // console.log("TOTAL", total, parseInt(salary), parseInt(bonus), parseInt(deduction));
        $("#todal_"+id).html(total);
        var postData;
        if(key == 'salary'){
            postData = 'name=basic_salary&value='+parseInt(salary)+'&pk='+id;
        }else if(key == 'bonus'){
            postData = 'name=bonus&value='+parseInt(bonus)+'&pk='+id;
        }else if(key == 'deduction'){
            postData = 'name=deduction&value='+parseInt(deduction)+'&pk='+id;
        }
        
        jQuery.ajax({
				url  	: base_url+"Employees/update_salary",
				type 	: 'POST',
				data 	: postData,
				success : function(data){
				    
				}
			});	
    
}

</script>
    
</script>