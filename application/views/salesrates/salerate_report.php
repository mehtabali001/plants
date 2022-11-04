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
<style>
th {
  position: sticky !important;
  border: 1px solid #f1f5fa;
  /*top: 50px;*/
  /*background: white;*/
}
.search_filter td {
    /*border: none !important;*/
    background: #f1f5fa !important;
    color: #000;
    font-weight: bold;
}
.search_finalsum td {
    /*border: none !important;*/
    /*background: rgb(245 222 179) !important;*/
    color: white;
    font-weight: bold;
}
.table td {
    vertical-align: middle;
}
.dataTables_filter{
    float:right;
}
@media only screen and (max-width: 600px) {
#currentday,#currentweek,#currentmonth,#currentyear{
    margin-bottom:5px;
}
}
</style>
<? $role_permissions  = explode(",",$this->session->userdata('permissions')); ?>
<div class="container-fluid">
<div class="row">
    <div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right" style="margin-bottom:15px;">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
				  <a href="<?= base_url();?>Sales" type="button" class="btn btn-outline-primary"><i class="fa fa-shopping-cart"></i>&nbsp;New Sale</a>     
                  <a href="<?= base_url();?>SaleRate" type="button" class="btn btn-outline-primary"><i class="fas fa-sort-amount-up-alt"></i>&nbsp;New Daily Sale Rate</a>
                  <a href="<?= base_url();?>SaleRate/salerate_report" type="button" class="btn btn-primary btn-large"><i class='fa fa-bar-chart'></i>&nbsp;Sales Rate Report</a>
                  <a href="<?= base_url();?>Sales/salesReport" type="button" class="btn btn-outline-primary"><i class="fa fa-bar-chart"></i>&nbsp;Sales Report</a>
                </div>
			</div>
			<!--<h4 class="page-title">Sales Rate History</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Sale Rate</a></li>-->
			<!--	<li class="breadcrumb-item active">Sales Rate History</li>-->
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
                        <form action="<?= base_url('SaleRate/Saleratereportfilter');?>" method="post" id="attendanceFilterForm">
                        <? if(!empty($role_permissions) && in_array(272,$role_permissions)) { ?>    
                        <div class="row">
						<div class="col-sm-12">
						  <div class="float-right" style="margin-bottom: 15px;">
                            <a href="<?= base_url('SaleRate/SaleratereportfilterByDay');?>" id="currentday" class="btn btn-success waves-effect waves-light" style="box-shadow: 0 7px 14px 0 rgb(45 218 181 / 50%);" name="show-current-day" value=""><i class="fa fa-line-chart" aria-hidden="true"></i>&nbsp;This Day</a>
                            <a href="<?= base_url('SaleRate/SaleratereportfilterByWeek');?>" id="currentweek" class="btn btn-purple waves-effect waves-light" style="box-shadow: 0 7px 14px 0 rgb(109 129 245 / 50%);" name="show-current-week" value=""><i class="fa fa-line-chart" aria-hidden="true"></i>&nbsp;This Week</a>
                            <a href="<?= base_url('SaleRate/SaleratereportfilterByMonth');?>" id="currentmonth" class="btn btn-secondary waves-effect waves-light" style="box-shadow: 0 7px 14px 0 rgb(65 203 216 / 50%) !important;" name="show-current-month" value=""><i class="fa fa-bar-chart" aria-hidden="true"></i>&nbsp;This Month</a>
                            <a href="<?= base_url('SaleRate/SaleratereportfilterByYear');?>" id="currentyear" class="btn btn-info waves-effect waves-light" style="box-shadow: 0 7px 14px 0 rgb(155 167 202 / 50%);" name="show-current-year" value=""><i class="fa fa-line-chart" aria-hidden="true"></i>&nbsp;This Year</a>
						   </div>
						</div>
						</div> 
						<? } ?>
                        <div class="row">
						<!--<div id="filter_global" class="col-md-3">-->
						<!--    <label>Global search</label>-->
						<!--	<input type="text" class="global_filter form-control" id="global_filter">-->
						<!--</div>-->
						<div id="filter_col1" data-column="0" class="col-sm-3">
								<div class="form-group input-group ">      
									<div class="input-group-append">
										<span class="input-group-text" style="background-color: #506ee4;border: 1px solid #506ee4;color:#FFF;">From</span>
									</div>                                     
									<input type="text" class="form-control datepicker" name="date_from" id="col0_filter_d" <? if(isset($_GET['date_from'])) { ?> value="<?=date("d/m/Y",strtotime($_GET['date_from']));?>" <? }else{ ?> value="<?=date("01/m/Y");?>" <?php }?>>	
								</div>   
                        </div>
                        <div class="col-sm-3">
							<div class="form-group input-group ">      
								<div class="input-group-append">
									<span class="input-group-text" style="background-color: #506ee4;border:1px solid #506ee4;color:#FFF;">To</span>
								</div>                                     
								<input type="text" class="form-control datepicker" name="date_to" id="col0_filter_d" <? if(isset($_GET['date_to'])) { ?> value="<?=date("d/m/Y",strtotime($_GET['date_to']));?>" <? } ?>>	
							</div>   
                        </div>
                        
						
						 <div id="filter_col3" data-column="2" class="col-md-3">
							<!--<label>Filter Types</label>-->
							<!--<input type="text" class="column_filter form-control" id="col2_filter">-->
							<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" id="filter_type" name="filter" >
                                <!--<option value="">--Select filter type--</option>-->
                                   <option value="Date_Wise" <? if (!empty($_GET['filter']) && $_GET['filter'] == "Date_Wise"){ echo "selected"; }else{ echo "selected"; } ?>>Date Wise</option>
                                   <option value="Rate_Wise" <? if (!empty($_GET['filter']) && $_GET['filter'] == "Rate_Wise"){ echo "selected"; } ?>>Rate Wise</option>
                                   <option value="Plant_Wise" <? if (!empty($_GET['filter']) && $_GET['filter'] == "Plant_Wise"){ echo "selected"; } ?>>Plant Wise</option>
                            </select>
						 </div>
						 <div class="col-md-6" style="margin-top:25px;">
						        <button type="submit" class="btn btn-successs waves-effect waves-light" id="search_button" disabled><i class="fa fa-search" aria-hidden="true" ></i>&nbsp;Proceed</button>
						        <a href="<?= base_url('SaleRate/manage_salerateHistory');?>"><button class="btn btn-danger" type="button" aria-controls="step-2" onclick="resetFilters();" aria-expanded="false"><i class="fa fa-refresh" aria-hidden="true"></i>&nbsp;RESET</button></a>
						        <button type="button" class="btn btn-warning waves-effect" id="advance_search" <?= (!empty($sale_rate_history))?'':'disabled';?>>Advance Search</button>
						 </div>
						 <div class="col-md-12 col-lg-12 col-xl-12 hide" id="show_filters_tab" style="padding-left: 0px;margin-top:20px;">
                            <div class="card">
                                <div class="card-body">
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#general" role="tab">General</a>
                                        </li>
                                    </ul>
                                    <!-- Tab panes -->
                                    <form action="" method="post" id="advance-search-form">
                                        <div class="tab-content">
                                            <div class="tab-pane active p-3" id="general" role="tabpanel">
                                                <div class="row">
                    								<div class="col-md-6">
                    								    <div class="form-group row">
                    										<label class="col-sm-4 col-form-label text-right">Search By Plants</label>
                    										<div class="col-sm-8">
                            									<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" id="col2_filter" onchange="getFilterAttendence(2);" name="plants" >
                                                                    <option value="">--Select Plant--</option>
                                                                    <?php 
                                    								    $tbl_plants	=	$this->Common_model->select_where_ASC_DESC('fld_id,fld_location','tbl_locations',array('fld_status'=>1),'fld_location','ASC');
                                                                        if($tbl_plants->num_rows() > 0) {
                                                                        foreach($tbl_plants->result() as $plant){
                                                                    ?>
                                                                        <option value="<?php echo $plant->fld_id;?>" <? if (!empty($_GET['plants']) && $_GET['plants'] == $plant->fld_id){ echo "selected"; } ?>><?php echo $plant->fld_location;?></option>
                                                                    <?php } } ?>
                                                                </select>
                    										</div>
                    									</div>
                    								</div>
                    							</div>
                                            </div>
                                        </div>
                                    </form>
                                </div><!--end card-body-->
                            </div><!--end card-->
                        </div>
						
						</div>
						</form>
	                <hr>
	                <? if(isset($sale_rate_history)){?>
	                <div id="loader_img" style='background-color: #FFF;text-align: center;'><div colspan='10' class='text-center' style='text-align: center;' ><img src='<?php echo base_url()?>assets/uploads/ajax_loading.gif' ></div></div>
                    <div class="table-responsive">
                    <table id="datatable_tb" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead class="tabletop">
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Plant</th>
                            <th>Category</th>
							<th>Sub Category</th>
							<th>Sale</th>
                        </tr>
                        </thead>
                        <tbody id="employee_data">
                            
        				<?php 
        				     if(isset($sale_rate_history)){
                             foreach($sale_rate_history as $history){ 
                        ?>
                        <tr class="search_filter">
                			<td colspan="7" style="text-align:center;"><?php echo $history['filter_text'];?></td>
                            <td style="display:none;"></td>
                            <td style="display:none;"></td>
                            <td style="display:none;"></td>
                            <td style="display:none;"></td>
                            <td style="display:none;"></td>
                            <td style="display:none;"></td>
                		</tr>
                        <?php $i = 1;    
                         
                        foreach($history['detail'] as $hist){ 
        					 $plant        =	 $this->Common_model->select_single_field('fld_location','tbl_locations',array('fld_id'=>$hist['plants']));
        					 $category     =	 $this->Common_model->select_where_return_row('fld_category,fld_unit','tbl_category',array('fld_id'=>$hist['category']));
        					 $subcategory  =	 $this->Common_model->select_single_field('fld_subcategory','tbl_subcategory',array('fld_subcid'=>$hist['sub_category']));
        					 $unit         =	 $this->Common_model->select_single_field('fld_unit','tbl_units',array('fld_id'=>$category->fld_unit));
        					 $date         =     date("d/m/Y",strtotime($hist['date']));
                        ?>
                        <tr>
                            <td><?=$i++;?></td>
                            <td><?=$date;?></td>
							<td><?=$plant;?></td>
                            <td><?=$category->fld_category;?></td>
                            <td><?=$subcategory;?>&nbsp;<?=$unit;?></td>
							
							<td class="sale">
							  <input type="number" style="width: 80px;height: 100%;border: none;padding: 10px;" min=0 max=30 value="<?=$hist['sale'];?>" onkeyup="updateValue('sale', <?=$hist['id'];?>)" onblur="updateValue('sale', <?=$hist['id'];?>)" id="sale_<?=$hist['id'];?>">
							</td>
							
                        </tr>
                	    <?php }}}else{ ?>
                	     <tr>
                            <td colspan="6"><p style="color:#900; text-align: center;" >Sorry No Record Found!</p></td>
                            <td style="display:none;"></td>
                            <td style="display:none;"></td>
                            <td style="display:none;"></td>
                            <td style="display:none;"></td>
                            <td style="display:none;"></td>
                        </tr>
                	    <?php } ?>
						</tbody>
                    </table>
                    </div>
                    <? } ?>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
</div> 