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
  /*color: #333;*/
  text-decoration: none;
}
.hide {
  display: none;
}
.popover{
    left: 1106px !important;
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
   .txtedit{
      display: none;
      width: 98%;
   }
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
<script>
 function show1(){
  document.getElementById('div1').style.display ='none';
}
function show2(){
  document.getElementById('div1').style.display = 'block';
}
</script>
<div class="container-fluid">
<div class="row">
<div class="col-sm-12">
<div class="page-title-box">
<div class="float-right" style="margin-bottom:15px;">
	<div class="btn-group" role="group" aria-label="Basic outlined example">
      <a href="<?= base_url();?>Employees/Addattendance" type="button" class="btn btn-primary btn-large"><i class='fas fa-user-plus'></i>&nbsp;New Attendence</a>
      <a href="<?= base_url();?>Employees/attendance" type="button" class="btn btn-outline-primary"><i class='fa fa-bar-chart'></i>&nbsp;Attendence Report</a>
      <a href="<?= base_url();?>Employees/employee_report" type="button" class="btn btn-outline-primary"><i class="fa fa-bar-chart"></i>&nbsp;Employees Report</a>
      <a href="<?= base_url();?>Employees/manage_trash" type="button" class="btn btn-outline-primary"><i class="fa fa-trash"></i>&nbsp;Trashed Employees</a>
    </div>
</div>
<!--<h4 class="page-title">+ Attendance</h4>-->
<!--<ol class="breadcrumb">-->
<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Attendence</a></li>-->
<!--	<li class="breadcrumb-item active">New Attendance</li>-->
<!--</ol>-->
<!--<p>NOTE: The following displayed attendance is shown only today's attendance.</p>-->
</div><!--end page-title-box-->
</div><!--end col-->
</div>    

<div id="openModal" class="modalbg">
<div class="dialog">
<a href="#close" title="Close" class="close">X</a>
<!--  <form action="<?//= base_url('Employees/createAttendance');?>" method="post">-->
<!--      <h2>Add Attendence</h2>-->
<!--<hr>-->
<!--    	<div class="form-group row">-->
<!--          <div class="col-sm-12">-->
<!--	    <label for="example-date-input" class="col-form-label">Date</label>-->
<!--              <input class="form-control" type="date" name="attendance_date" id="example-date-input">-->
<!--          </div>-->
<!--      </div>-->
<!--      <div class="radio radio-info form-check-inline">-->
<!--          <input type="radio" id="inlineRadio1" value="all" name="radioInline" onclick="show1();" checked="">-->
<!--          <label for="inlineRadio1"> All Employees </label>-->
<!--      </div>-->
<!--      <div class="radio radio-info form-check-inline">-->
<!--          <input type="radio" id="inlineRadio2" value="plantwise" name="radioInline"  onclick="show2();">-->
<!--          <label for="inlineRadio2"> Plantwise Employees </label>-->
<!--      </div>-->
<!--      <div class="hide" id="div1">-->
<!--          <div class="form-group row ">-->
<!--              <div class="col-sm-12">-->
<!--		<label class="col-form-label">Select Plant</label>-->
<!--                  <select class="form-control" id="plants" name="plants">-->
<!--                      <option value="">--Select Plant--</option>-->
<!--                      <?php 
//   <!--  					    $tbl_plants	=	$this->Common_model->select_where_ASC_DESC('id,name','tbl_plants',array('deleted'=>0),'name','ASC');-->
//   <!--                          if($tbl_plants->num_rows() > 0) {-->
//   <!--                          foreach($tbl_plants->result() as $plant){-->
?>
<!--                          <option value="<?php //echo $plant->id;?>"><?php// echo $plant->name;?></option>-->
<!--                      <?php// } } ?>-->
<!--                  </select>-->
<!--              </div>-->
<!--          </div>-->
<!--      </div><br>-->
<!--<hr>-->
<!--      <button type="submit" class="btn btn-primary waves-effect waves-light">Add Attendence</button>-->
<!--  </form>-->
</div>
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
        <!--<h4>Add Attendence</h4>-->
<form action="<?= base_url('Employees/createAttendance');?>" method="post">
<div class="row">
	<div class="col-md-2">
      	<div class="form-group row">
            <div class="col-sm-12">
			    <label for="example-date-input" class="col-form-label">Date</label>
                <input class="form-control datepicker" type="text" name="attendance_date" value="<?php if(isset($_GET['date'])){ echo date('d/m/Y', strtotime($_GET['date'])); } ?>" id="example-date-input">
            </div>
        </div>
    </div>
    <div class="col-md-3" style="margin-top: 35px;">
        <div class="radio radio-info form-check-inline">
            <input type="radio" id="inlineRadio1" value="all" name="radioInline" onclick="show1();" checked="">
            <label for="inlineRadio1"> All Employees </label>
        </div>
        <div class="radio radio-info form-check-inline">
            <input type="radio" id="inlineRadio2" value="plantwise" name="radioInline"  onclick="show2();">
            <label for="inlineRadio2"> Plantwise Employees </label>
        </div>
    </div>
    <div class="hide col-md-3" id="div1">
        <div class="form-group row ">
            <div class="col-sm-12">
			<label class="col-form-label">Select Plant</label>
                <select class="select2 form-control mb-3 custom-select" id="plants" name="plants">
                    <option value="">Showing Select Plants</option>
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
    <div class="col-md-3">
      	<div class="form-group row">
            <div class="col-sm-12">
			    <label for="example-date-input" class="col-form-label">Mark Status</label>
                <select type="select" name="status" class="select2 form-control mb-3 custom-select"  id="status">
					<option value='Present'>Present</option>
					<option value='Public-holiday'>Public Holiday</option>
			    </select>
            </div>
        </div>
    </div>

<!-- <div class="col-md-3"> -->
<!-- <label>Status</label> -->
<!-- <select type="select"  name="status" class="form-control"  id="status"> -->
<!--      <option value="">--Select Status--</option> -->
<!--      <option value='Present'>Present</option> -->
<!--      <option value='Public-holiday'>Public Holiday</option> -->
<!-- </select> -->
<!-- </div> -->
<div class="col-md-3" style="margin-top: 38px;">
    <button type="submit" class="btn btn-successs waves-effect waves-light" id="add_attendance_btn">Proceed F10</button>
</div>
</div>
</form>
                        
<!--<div class="row">  -->

<!--				<div id="filter_global" class="col-md-3">-->
<!--				    <label>Global search</label>-->
<!--					<input type="text" class="global_filter form-control" id="global_filter">-->
<!--				</div>-->

<!--				<div id="filter_col1" data-column="0" class="col-md-3">-->
<!--				   <label>Date</label>-->
<!--				   <input type="text" class="column_filter form-control" id="col0_filter">-->
<!--				</div>-->

<!--				<div id="filter_col2" data-column="1" class="col-md-3">-->
<!--					<label>Full Name</label>-->
<!--					<input type="text" class="column_filter form-control" id="col1_filter">-->
<!--				</div>-->
<!--				<div id="filter_col3" data-column="2" class="col-md-3">-->
<!--					<label>Search By Plants</label>-->
<!--					<input type="text" class="column_filter form-control" id="col2_filter">-->
<!--				 </div>-->
<!--				</div>-->
<!--				 <hr>-->
<!--				<div class="row">-->

<!--				 <div id="filter_col4" data-column="3" class="col-md-3">-->
<!--					<label>Search By Designation</label>-->
<!--					<input type="text" class="column_filter form-control" id="col3_filter">-->
<!--				 </div>-->
<!--				 <div id="filter_col5" data-column="4" class="col-md-3">-->
<!--					<label>Check In</label>-->
<!--					<input type="text" class="column_filter form-control" id="col4_filter">-->
<!--				 </div>-->
<!--				 <div id="filter_col6" data-column="5" class="col-md-3">-->
<!--					<label>Check Out</label>-->
<!--					<input type="text" class="column_filter form-control" id="col5_filter">-->
<!--				 </div>-->
<!--				 <div id="filter_col7" data-column="6" class="col-md-3">-->
<!--					<label>Status</label>-->
<!--					<input type="text" class="column_filter form-control" id="col6_filter">-->
<!--<select type="select" class="column_filter" id="col6_filter">
<!--							<option value='Present'>Present</option>-->
<!--							<option value='Absent'>Absent</option>-->
<!--							<option value='Sick Leave'>Sick Leave</option>-->
<!--							<option value='Short Leave'>Short Leave</option>-->
<!--				  </select>-->
<!--				 </div>-->
<!--				</div>-->
    <hr>
    <table id="datatable_tb" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead class="tabletop">
        <tr>
            <th>Date</th>
            <th>Full Name</th>
			<th>Plant</th>
            <th>Designation</th>
			<th>In Time</th>
			<th>Out Time</th>
			<th>Status</th>
        </tr>
        </thead>
		<!--<tfoot>-->
<!--                  <tr>-->
<!--                      <th>Date</th>-->
<!--                      <th>Full Name</th>-->
		<!--	<th>Plant</th>-->
<!--                      <th>Designation</th>-->
		<!--	<th>In Time</th>-->
		<!--	<th>Out Time</th>-->
		<!--	<th>Status</th>-->
<!--                  </tr>-->
<!--                  </tfoot>-->
        <tbody id="employee_data">
<?php 
    if($attendance){
    foreach($attendance as $emp){ 
    $designation =	$this->Common_model->select_single_field('designation_name','tbl_designation',array('id'=>$emp['designation']));       
  //$department  =	$this->Common_model->select_single_field('department_name','tbl_departments',array('id'=>$emp['department']));
	$plant       =	$this->Common_model->select_single_field('fld_location','tbl_locations',array('fld_id'=>$emp['plants']));
	$name        =	$this->Common_model->select_single_field('full_name','tbl_employees',array('id'=>$emp['user_id']));
	
	$color = "color:green";
	if($emp['attendance_status'] == 'Present'){
	    $color = "color:green";
	}elseif($emp['attendance_status'] == 'Absent'){
	    $color = "color:red";
	}elseif($emp['attendance_status'] == 'Sick Leave'){
	    $color = "color:red";
	}elseif($emp['attendance_status'] == 'Short Leave'){
	    $color = "color:red";
	}elseif($emp['attendance_status'] == 'Public-holiday'){
	    $color = "color:red";
	}
?>
        <tr>
            <td><?php echo date("d-M-Y",strtotime($emp['attendance_date']));?></td>
            <td><?=$name;?></td>
			<td><?=$plant;?></td>
            <td><?=$designation;?></td>
			<td class="check_in"> 
			  <input type="time" style="width: 100%;height: 100%;border: none;padding: 10px;" value="<?=$emp['check_in'];?>" onkeyup="updateValue('check_in', <?=$emp['attendance_id'];?>)" onchange="updateValue('check_in', <?=$emp['attendance_id'];?>)" id="check_in_<?=$emp['attendance_id'];?>">
			</td>
			<td class="check_out">
			  <input type="time" style="width: 100%;height: 100%;border: none;padding: 10px;" value="<?=$emp['check_out'];?>" onkeyup="updateValue('check_out', <?=$emp['attendance_id'];?>)" onchange="updateValue('check_out', <?=$emp['attendance_id'];?>)" id="check_out_<?=$emp['attendance_id'];?>">
			</td>
            <td>
			  <select id="attendance_status_<?=$emp['attendance_id'];?>" style="width: 100%;height: 100%;border: none;padding: 10px;<?=$color;?>" onchange="updateValue('attendance_status', <?=$emp['attendance_id'];?>)">
			      <option value="Present" <?php if($emp['attendance_status'] == 'Present'){echo 'selected';} ?>>Present</option>
			      <option value="Absent" <?php if($emp['attendance_status'] == 'Absent'){echo 'selected';} ?>>Absent</option>
			      <option value="Sick Leave" <?php if($emp['attendance_status'] == 'Sick Leave'){echo 'selected';} ?>>Sick Leave</option>
			      <option value="Short Leave" <?php if($emp['attendance_status'] == 'Short Leave'){echo 'selected';} ?>>Short Leave</option>
			      <option value="Public-holiday" <?php if($emp['attendance_status'] == 'Public-holiday'){echo 'selected';} ?>>Public-holiday</option>
			  </select>
			</td>
            <!--<td>
			<a type="button" name="edit_student" class=" edit_student" id="<?//=$emp['attendance_id'];?>"><i style="font-size:20px;cursor:pointer;" class="mdi mdi-square-edit-outline" title="Edit"></i></button>
            </td>-->
			</tr>
    		<?php }}else {?>
    		<tr>
    			<td colspan="12"><br><p style="color:#900; text-align: center;" >Sorry No Record Found!</p></td>
    		</tr>
    		<? } ?>
		</tbody>
    </table>
</div>
</div>
</div> <!-- end col -->
</div> <!-- end row -->
</div>  

<div class="modal" id="formModal">
  <div class="modal-dialog">
  	<form method="post" id="student_form">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" id="modal_title"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">Check In <span class="text-danger">*</span></label>
              <div class="col-md-8">
                <input type="text" name="check_in" id="check_in" class="form-control" />
                <span id="error_check_in" class="text-danger"></span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">Roll No. <span class="text-danger">*</span></label>
              <div class="col-md-8">
                <input type="text" name="check_out" id="check_out" class="form-control" />
                <span id="error_check_out" class="text-danger"></span>
              </div>
            </div>
          </div>
		  <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">Attendance Status <span class="text-danger">*</span></label>
              <div class="col-md-8">
                <select name="attendance_status" id="attendance_status" class="form-control">
                  <option>Select</option>
                  <option >Present</option>
                  <option>Absent</option>
                  <option>Sick Leave</option>
                  <option>Short Leave</option>
                 </select>
              <span id="error_student_grade_id" class="text-danger"></span>
              </div>
            </div>
          </div>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
        	<input type="hidden" name="attendance_id" id="attendance_id" />
        	<input type="hidden" name="action" id="action" value="Add" />
        	<input type="submit" name="button_action" id="button_action" class="btn btn-success btn-sm" value="Add" />
          	<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        </div>

      </div>
  </form>
  </div>
</div>
<script>
    function updateValue(key, id){
        
        var check_in = $("#check_in_"+id).val();
        var check_out = $("#check_out_"+id).val();
        var attendance_status = $("#attendance_status_"+id).val();
        console.log(attendance_status)
        var postData;
        if(key == 'check_in'){
            postData = 'name=check_in&value='+check_in+'&pk='+id;
        }else if(key == 'check_out'){
            postData = 'name=check_out&value='+check_out+'&pk='+id;
        }else if(key == 'attendance_status'){
            postData = 'name=attendance_status&value='+attendance_status+'&pk='+id;
            if(attendance_status == 'Present'){
                $("#attendance_status_"+id).css("color", "green");
                $("#check_in_"+id).removeAttr("readonly");
			    $("#check_out_"+id).removeAttr("readonly");
			}else if(attendance_status == 'Absent'){
			    $("#attendance_status_"+id).css("color", "red");
			    $("#check_in_"+id).attr('readonly', 'readonly');
			    $("#check_out_"+id).attr('readonly', 'readonly');
			}else if(attendance_status == 'Sick Leave'){
			    $("#attendance_status_"+id).css("color", "#506ee4");
			     
			    $("#check_in_"+id).attr('readonly', 'readonly');
			    $("#check_out_"+id).attr('readonly', 'readonly');
			}else if(attendance_status == 'Short Leave'){
			    $("#attendance_status_"+id).css("color", "#506ee4");
			    $("#check_in_"+id).removeAttr("readonly");
			    $("#check_out_"+id).removeAttr("readonly");
			}else if(attendance_status == 'Public-holiday'){
			    $("#attendance_status_"+id).css("color", "#506ee4");
			    $("#check_in_"+id).attr('readonly', 'readonly');
			    $("#check_out_"+id).attr('readonly', 'readonly');
			}
            
        }
        
        jQuery.ajax({
				url  	: base_url+"Employees/update_attendance1",
				type 	: 'POST',
				data 	: postData,
				success : function(data){
				    console.log(data);
				}
			});	
    
}
</script>
