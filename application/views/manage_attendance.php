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
/*#datatable_filter .form-control-sm {*/
/*    display:none;*/
/*}*/
/*#datatable_filter label {*/
/*    display:none;*/
/*}*/
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
<? $role_permissions  = explode(",",$this->session->userdata('permissions')); ?>
<div class="container-fluid">
<div class="row">
    <div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right" style="margin-bottom:15px;">
            	<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Employees/Addattendance" type="button" class="btn btn-outline-primary"><i class='fas fa-user-plus'></i>&nbsp;New Attendence</a>
                  <a href="<?= base_url();?>Employees/attendance" type="button" class="btn btn-primary btn-large"><i class='fa fa-bar-chart'></i>&nbsp;Attendence Report</a>
                  <a href="<?= base_url();?>Employees/employee_report" type="button" class="btn btn-outline-primary"><i class="fa fa-bar-chart"></i>&nbsp;Employees Report</a>
                  <a href="<?= base_url();?>Employees/manage_trash" type="button" class="btn btn-outline-primary"><i class="fa fa-trash"></i>&nbsp;Trashed Employees</a>
                </div>
            </div>
			<!--<h4 class="page-title">Attendence Report</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Attendence</a></li>-->
			<!--	<li class="breadcrumb-item active">Attendence Report</li>-->
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
                    
                        <form id="attendanceFilterForm" >
                                                                         
                        <input type="hidden" name="filter_type" id="filter_type" value="1" />
                        
                        <? if(!empty($role_permissions) && in_array(286,$role_permissions)){ ?>
                        <div class="row">
						<div class="col-sm-12">
						  <div class="float-right" style="margin-bottom: 15px;">
                            <button type="button" id="currentday" class="btn btn-success waves-effect waves-light" style="box-shadow: 0 7px 14px 0 rgb(45 218 181 / 50%);" name="show-current-day" onclick="getattendanceDataByDate('daily');"><i class="fa fa-line-chart" aria-hidden="true"></i>&nbsp;This Day</button>
                            <button type="button" id="currentweek" class="btn btn-purple waves-effect waves-light" style="box-shadow: 0 7px 14px 0 rgb(109 129 245 / 50%);" name="show-current-week" onclick="getattendanceDataByDate('weekly');"><i class="fa fa-line-chart" aria-hidden="true"></i>&nbsp;This Week</button>
                            <button type="button" id="currentmonth" class="btn btn-secondary waves-effect waves-light" style="box-shadow: 0 7px 14px 0 rgb(65 203 216 / 50%) !important;" name="show-current-month" onclick="getattendanceDataByDate('monthly');"><i class="fa fa-bar-chart" aria-hidden="true"></i>&nbsp;This Month</button>
                            <button type="button" id="currentyear" class="btn btn-info waves-effect waves-light" style="box-shadow: 0 7px 14px 0 rgb(155 167 202 / 50%);" name="show-current-year" onclick="getattendanceDataByDate('yearly');"><i class="fa fa-line-chart" aria-hidden="true"></i>&nbsp;This Year</button>
						   </div>
						</div>
						</div>
						<? } ?>
                        <div class="row">
							<div class="col-sm-3">
								<div class="form-group input-group ">      
									<div class="input-group-append">
										<span class="input-group-text" style="background-color: #506ee4;border: 1px solid #506ee4;color:#FFF;">From</span>
									</div>                                     
									<input type="text" class="form-control datepicker" name="from_date" id="from_date" value="<?= date('d/m/Y',mktime(0, 0, 0, date('m'), 1, date('Y')))?>">	
								</div>   
                            </div>
							<div class="col-sm-3">
								<div class="form-group input-group ">      
									<div class="input-group-append">
										<span class="input-group-text" style="background-color: #506ee4;border: 1px solid #506ee4;color:#FFF;">To</span>
									</div>                                     
									<input type="text" class="form-control datepicker" name="to_date" id="to_date" value="">	
								</div>   
                            </div>
							<div class="col-sm-3">
								<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="filter" id="filter" required>
										<option value="Plant_Wise">Plant Wise</option>
										<option value="Employee_wise">Employee Wise</option>
										<option value="Date_Wise">Date Wise</option>
										<option value="Designation_Wise">designation Wise</option>
										<option value="Status_Wise">Status Wise</option>
								</select>
							</div>
                        </div>
                        <button type="button" id="show_report" class="btn btn-successs btn-large show_report" name="show-report" onclick="getattendance();"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Proceed F10</button>
                        <!--<button type="button" style="margin: 0px 10px;" id="" class="btn btn-secondary" name="" value=""><i class="fa fa-bar-chart" aria-hidden="true"></i>&nbsp;Show Charts</button>-->
                        
                        
                        <button type="button" class="btn btn-warning waves-effect" id="advance_search" id="hide" disabled>Advance Search</button>
                        <button type="button" id="reset_filters" disabled class="btn btn-danger" name="" value=""  onclick="window.location.href='<?= base_url(); ?>Employees/attendance'"><i class="fa fa-refresh" aria-hidden="true" ></i>&nbsp;Reset</button>
                        <div class="col-md-12 col-lg-12 col-xl-12 hide" id="show_filters_tab" style="padding-left: 0px;margin-top:20px;">
                            <div class="card">
                                <div class="card-body">
    
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#plants" role="tab">Plants</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#employee" role="tab">Employee</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#designation" role="tab">Designation</a>
                                        </li>                                                
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#Status" role="tab">Status</a>
                                        </li>
                                    </ul>
    
                                    <!-- Tab panes -->
                                   
                                        <div class="tab-content">
                                            <div class="tab-pane active p-3" id="plants" role="tabpanel">
                                                <div class="row">
                    								
                    								<div id="filter_col3" data-column="2" class="col-md-4">
                            							<label>Search By Plants</label>
                            							<!--<input type="text" class="column_filter form-control" id="col2_filter">-->
                            							<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" id="col2_filter" onchange="advanceSearch();" name="plants" >
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
                                            </div>
                                            <div class="tab-pane  p-3" id="employee" role="tabpanel">
                                                <div class="row">
                    								
                    								<div id="filter_col4" data-column="4" class="col-md-4">
                            							<label>Search By Employee</label>
                            							<!--<input type="text" class="column_filter form-control" id="col2_filter">-->
                            							<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" id="col2_filter" onchange="advanceSearch();" name="employee" >
                                                            <option value="">Showing All Employees</option>
                                                            <?php 
                            								    $tbl_employees	=	$this->Common_model->select_where_ASC_DESC('id,full_name','tbl_employees',array('employee_type'==2),'full_name','ASC');
                                                                if($tbl_employees->num_rows() > 0) {
                                                                foreach($tbl_employees->result() as $employee){
                                                            ?>
                                                                <option value="<?php echo $employee->id;?>"><?php echo $employee->full_name;?></option>
                                                            <?php } } ?>
                                                        </select>
                            						 </div>
                    								
                    							</div>
                                            </div>
                                            <div class="tab-pane p-3" id="designation" role="tabpanel">
                                                <div class="row">
                                        			<div id="filter_col4" data-column="3" class="col-md-4">
                        							<label>Search By Designation</label>
                        							<!--<input type="text" class="column_filter form-control" id="col3_filter">-->
                        							<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" id="col3_filter" onchange="advanceSearch();" name="designation" required >
                                                        <option value="">Showing All Designations</option>
                                                        <?php $tbl_designation	=	$this->Common_model->select_where_ASC_DESC('id,designation_name','tbl_designation',array('deleted'=>0),'designation_name','ASC');
                                                            if($tbl_designation->num_rows() > 0) {
                                                            foreach($tbl_designation->result() as $desig) {
                                                        ?>
                                                            <option value="<?php echo $desig->id;?>" ><?php echo $desig->designation_name;?></option>
                                                        <?php } } ?>
                                                    </select>
                        						 </div>
    								
    							                </div>
                                            </div>                                                
                                            <div class="tab-pane p-3" id="Status" role="tabpanel">
                                                <div class="row">
                                                    <div id="filter_col7" data-column="6" class="col-md-4">
                            							<label>Status</label>
                            							<!--<input type="text" class="column_filter form-control" id="col6_filter">-->
                            							<select type="select"  name="status" class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" id="col6_filter" onchange="advanceSearch();" >
                            							        <option value="">Showing All Status</option>
                            									<option value='Present'>Present</option>
                            									<option value='Absent'>Absent</option>
                            									<option value='Sick Leave'>Sick Leave</option>
                            									<option value='Short Leave'>Short Leave</option>
                            						  </select>
                            						 </div>
                            					</div>
                                            </div>
                                        </div>
                                </div><!--end card-body-->
                            </div><!--end card-->
                        </div>						
						<!--<div class="row" style="margin-top:20px;">-->
						<!--	<div class="col-sm-3">-->
						<!--		<ul class="nav nav-pills mb-3 nav-justified" id="pills-tab" role="tablist">-->
      <!--                              <li class="nav-item">-->
      <!--                                  <a class="nav-link active boxshadow" id="general_chat_tab" data-toggle="pill" onclick="setreportfilter(1);"  href="javascript:;">Detailed</a>-->
      <!--                              </li>-->
      <!--                              <li class="nav-item">-->
      <!--                                  <a class="nav-link boxshadow" id="group_chat_tab" data-toggle="pill" onclick="setreportfilter(2);"  href="#javascript:;">Summary</a>-->
      <!--                              </li>-->
                                    
      <!--                          </ul>   -->
      <!--                      </div>-->
							
							
      <!--                  </div>-->
                    </form>
	                <hr>
                    <div id="filterhtml">
                        
                    </div>
					
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
  