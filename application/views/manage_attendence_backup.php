<style>
.modalLoader {
    display:    none;
    position:   fixed;
    z-index:    1000;
    top:        0;
    left:       0;
    height:     100%;
    width:      100%;
    background: rgba( 255, 255, 255, .8 ) 
                url('http://i.stack.imgur.com/FhHRx.gif') 
                50% 50% 
                no-repeat;
}
#datatable_filter .form-control-sm {
    display:none;
}
#datatable_filter label {
    display:none;
}
.sorting_1 p{
    text-align:center;
}

/* When the body has the loading class, we turn
   the scrollbar off with overflow:hidden */
body.loading .modalLoader {
    overflow: hidden;   
}

/* Anytime the body has the loading class, our
   modal element will be visible */
body.loading .modalLoader {
    display: block;
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
  color: #99a5c6;
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
			<div class="float-right">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Employees/Addattendance" type="button" class="btn btn-outline-primary"><i class='fas fa-user-plus'></i>&nbsp;Add Attendence</a>
                  <a href="<?= base_url();?>Employees/attendance" type="button" class="btn btn-primary btn-large"><i class='fas fa-user-cog'></i>&nbsp;Attendence History</a>
                  <!--<a href="<?//= base_url();?>Employees/attendance" type="button" class="btn btn-primary btn-large"><i class="fa fa-clock-o"></i>&nbsp;Attendence</a>-->
                </div>
			</div>
			<h4 class="page-title">Staff Attendance</h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="javascript:void(0);">Attendence</a></li>
				<li class="breadcrumb-item active">Attendence History</li>
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
                        }?>
                        </div>
                    
                        <form action="" method="post" id="attendanceFilterForm">
                            <div class="row">  
						
						<div id="filter_global" class="col-md-3">
						    <label>Global search</label>
							<input type="text" class="global_filter form-control" id="global_filter">
						</div>

						<div id="filter_col1" data-column="0" class="col-md-3">
						   <label>Date</label>
						   <input type="text" name="date" class="column_filter form-control datepicker" id="col0_filter_d">
						</div>
						
						<div id="filter_col2" data-column="1" class="col-md-3">
							<label>Name</label>
							<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="fld_emp_id" tabindex="1" id="col1_filter" onchange="getFilterAttendence(1);" required>
                                    <option selected="selected" value="">Showing All Employees</option>
										<?php
												if($employees){
												foreach($employees as $emp){
										?>
									<option value="<?= $emp['id'];?>"><?= $emp['full_name'];?></option>
									<?php }}?>
                            </select>
						</div>
						<div id="filter_col3" data-column="2" class="col-md-3">
							<label>Search By Plants</label>
							<!--<input type="text" class="column_filter form-control" id="col2_filter">-->
							<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" id="col2_filter" onchange="getFilterAttendence(2);" name="plants" >
                                <option value="">Showing All Plants</option>
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
                        
						 <!--<hr>-->
						<div class="row" style="margin-top: 30px;">
						 
						 <div id="filter_col4" data-column="3" class="col-md-3">
							<label>Search By Designation</label>
							<!--<input type="text" class="column_filter form-control" id="col3_filter">-->
							<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" id="col3_filter" onchange="getFilterAttendence(3);" name="designation" required >
                                <option value="">Showing All Designations</option>
                                <?php $tbl_designation	=	$this->Common_model->select_where_ASC_DESC('id,designation_name','tbl_designation',array('deleted'=>0),'designation_name','ASC');
                                    if($tbl_designation->num_rows() > 0) {
                                    foreach($tbl_designation->result() as $desig) {
                                ?>
                                    <option value="<?php echo $desig->id;?>" ><?php echo $desig->designation_name;?></option>
                                <?php } } ?>
                            </select>
						 </div>
						 <!--<div id="filter_col5" data-column="4" class="col-md-3">-->
							<!--<label>Check In</label>-->
							<!--<input type="text" class="column_filter 13:45:00 form-control" id="col4_filter">-->
							<!--<input class="form-control timepicker" type="time" name="check_in" value="13:45:00" id="col4_filter" >-->
						 <!--</div>-->
						 <!--<div id="filter_col6" data-column="5" class="col-md-3">-->
							<!--<label>Check Out</label>-->
							<!--<input type="text" class="column_filter 17:45:00 form-control" id="col5_filter">-->
							<!--<input class="form-control timepicker" type="time" name="check_out" min="09:00" value="17:45:00" id="col5_filter" >-->
						 <!--</div>-->
						 <div id="filter_col7" data-column="6" class="col-md-3">
							<label>Status</label>
							<!--<input type="text" class="column_filter form-control" id="col6_filter">-->
							<select type="select"  name="status" class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" id="col6_filter" >
							        <option value="">Showing All Status</option>
									<option value='Present'>Present</option>
									<option value='Absent'>Absent</option>
									<option value='Sick Leave'>Sick Leave</option>
									<option value='Short Leave'>Short Leave</option>
						  </select>
						 </div>
						 <div class="col-md-6" style="margin-top:25px;">
						        <button class="btn btn-primary btn-large " type="button" aria-controls="step-2" onclick="getFilterAttendence();" aria-expanded="false" id="add_attendance_btn"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Search F10</button>&nbsp;&nbsp;
						        <button class="btn btn-danger" type="button" aria-controls="step-2" onclick="resetFilters();" aria-expanded="false"><i class="fa fa-refresh" aria-hidden="true"></i>&nbsp;RESET FILTERS F5</button>
						    </div>
						</div>
						<br>
						<div class="row">
						    <!--<div class="col-md-3">-->
						    <!--    <button class="btn btn-gradient-primary btn-next" type="button" aria-controls="step-2" onclick="getFilterAttendence();" aria-expanded="false">FILTER DATA</button>-->
						    <!--    <button class="btn btn-gradient-primary btn-next" type="button" aria-controls="step-2" onclick="resetFilters();" aria-expanded="false">RESET FILTERS</button>-->
						    <!--</div>-->
						    
						    
						</div>
						</form>
	                <hr>
                    <table id="datatable" class="display table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Name</th>
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
					
					if($emp['attendance_status'] == 'Present'){
					    $color = "color:green";
					}elseif($emp['attendance_status'] == 'Absent'){
					    $color = "color:red";
					}elseif($emp['attendance_status'] == 'Sick Leave'){
					    $color = "color:#506ee4";
					}elseif($emp['attendance_status'] == 'Short Leave'){
					    $color = "color:#506ee4";
					}
					
                ?>
                        <tr>
                            <td><?php echo date("d-M-Y",strtotime($emp['attendance_date']));?></td>
                            <td><?=$name;?></td>
							<td><?=$plant;?></td>
                            <td><?=$designation;?></td>
							<td data-name="check_in" class="check_in" data-type="text" data-pk="<?=$emp['attendance_id'];?>"> 
							  <?=$emp['check_in'];?>
							</td>
							<td data-name="check_out" class="check_out" data-type="text" data-pk="<?=$emp['attendance_id'];?>">
							  <?=$emp['check_out'];?>
							</td>
                            <td data-name="attendance_status" class="attendance_status" data-type="select" data-pk="<?=$emp['attendance_id'];?>" style="<?=$color?>">
							  <?=$emp['attendance_status'];?>
							</td>
                            <!--<td>
							<a type="button" name="edit_student" class=" edit_student" id="<?//=$emp['attendance_id'];?>"><i style="font-size:20px;cursor:pointer;" class="mdi mdi-square-edit-outline" title="Edit"></i></button>
                           </td>-->
        </tr>
	<?php }}else {?>
<tr>
    <td colspan="12"><br><p style="color:red; text-align: center;" >Sorry No Record Found!</p></td>
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
     
  	<form method="post" id="student_form" action="<?=base_url();?>/Employees/editattendancerecords">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" id="modal_title"></h4>
          <button type="button" class="close" data-dismiss="modal" style="margin:0;padding:0;">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">Check In <span class="text-danger">*</span></label>
              <div class="col-md-8">
                <input type="text" name="check_in" id="timepicker1" class="form-control check_in" />
                <span id="error_check_in" class="text-danger"></span>
              </div>
            </div>
          </div>
          
          <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">Check Out <span class="text-danger">*</span></label>
              <div class="col-md-8">
                <input type="text" name="check_out" id="timepicker2" class="form-control check_out" />
                <span id="error_check_out" class="text-danger"></span>
              </div>
            </div>
          </div>
		  <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">Attendance Status <span class="text-danger">*</span></label>
              <div class="col-md-8">
                <select name="attendance_status" id="attendance_status" class="form-control">
                  <option value="">All Status</option>
                  <option>Present</option>
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
<div class="modalLoader"><!-- Place at bottom of page --></div>
<script>

</script>
  