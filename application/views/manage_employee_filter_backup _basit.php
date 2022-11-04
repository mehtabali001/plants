<form action="" method="post" id="search-emp-form">
                            <div class="row">
                                <div id="filter_global" class="col-md-3">
						    <label>Global Search</label>
							<input type="text" class="global_filter form-control" id="global_filter">
						</div>
						
						<div id="filter_col2" data-column="1" class="col-md-3">
							<label>Name</label>
							<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="fld_emp_name" tabindex="1" id="fld_emp_id" required>
                                    <option selected="selected" value="">All Employees</option>
										<?php
												if($employees){
												foreach($employees as $emp){
										?>
									<option value="<?= $emp['full_name'];?>"><?= $emp['full_name'];?></option>
									<?php }}?>
                            </select>
						</div>
						<div id="filter_col3" data-column="2" class="col-md-3">
							<label>Search By Plants</label>
							<!--<input type="text" class="column_filter form-control" id="col2_filter">-->
							<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" id="plants" name="plants" >
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
						 
						<!--</div>-->
                        
						 <!--<hr>-->
						<!--<div class="row">-->
						 
						 <div id="filter_col4" data-column="3" class="col-md-3">
							<label>Search By Designation</label>
							<!--<input type="text" class="column_filter form-control" id="col3_filter">-->
							<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" id="designation" name="designation" required >
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
                        
						<!-- <hr>-->
						<div class="row" style="margin-top: 30px;">
						 
						 <div id="" data-column="3" class="col-md-3">
							<label>Search By Department</label>
							<!--<input type="text" class="column_filter form-control" id="col3_filter">-->
							<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" id="department"  name="department" required >
                                <option value="">Showing All Depatments</option>
                                <?php $tbl_departments	=	$this->Common_model->select_where_ASC_DESC('id,department_name','tbl_departments',array('deleted'=>0),'department_name','ASC');
                                    if($tbl_departments->num_rows() > 0) {
                                    foreach($tbl_departments->result() as $depart) {
                                ?>
                                    <option value="<?php echo $depart->id;?>" ><?php echo $depart->department_name;?></option>
                                <?php } } ?>
                            </select>
						 </div>
						<!--</div>-->
                        
						<!-- <hr>-->
						<!--<div class="row">-->
						
						 
						 <div class="col-md-6" style="margin-top:25px;">
						        <button class="btn btn-primary btn-large " type="button" aria-controls="step-2" onclick="getFilterEmployee();" aria-expanded="false"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Search</button>&nbsp;&nbsp;
						        <button class="btn btn-danger" type="button" aria-controls="step-2" onclick="window.location.href='<?=base_url().'Employees/manage_Employees';?>'" aria-expanded="false"><i class="fa fa-refresh" aria-hidden="true"></i>&nbsp;RESET FILTERS</button>
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