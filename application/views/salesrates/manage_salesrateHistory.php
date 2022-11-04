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
  /*color: #99a5c6;*/
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
			<div class="float-right" style="margin-bottom:15px;">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
				  <a href="<?= base_url();?>Sales" type="button" class="btn btn-outline-primary"><i class="fa fa-shopping-cart"></i>&nbsp;New Sale</a>    
                  <a href="<?= base_url();?>SaleRate" type="button" class="btn btn-outline-primary"><i class="fas fa-sort-amount-up-alt"></i>&nbsp;New Daily Sale Rate</a>
                  <a href="<?= base_url();?>SaleRate/manage_salerateHistory" type="button" class="btn btn-primary btn-large"><i class='fas fa-user-cog'></i>&nbsp;Sales Rate History</a>
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
                        } ?>
                        </div>
                    
                       <?/* <form action="<?= base_url('SaleRate/addSaleratehistoryfilter');?>" method="post" id="attendanceFilterForm">
                        <div class="row">
						<!--<div id="filter_global" class="col-md-3">-->
						<!--    <label>Global search</label>-->
						<!--	<input type="text" class="global_filter form-control" id="global_filter">-->
						<!--</div>-->

						<div id="filter_col1" data-column="0" class="col-md-3">
						   <label>Date</label>
						   <input type="text" name="date" class="column_filter form-control datepicker" id="col0_filter_d" <? if(isset($_GET['date'])) { ?> value="<?=date("d/m/Y",strtotime($_GET['date']));?>" <? } ?> >
						</div>
						
						<div id="filter_col3" data-column="2" class="col-md-3">
							<label>Search By Plants</label>
							<!--<input type="text" class="column_filter form-control" id="col2_filter">-->
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
						 <div class="col-md-6" style="margin-top:25px;">
						        <button type="submit" class="btn btn-primary waves-effect waves-light"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Search</button>&nbsp;&nbsp;
						        <a href="<?= base_url('SaleRate/manage_salerateHistory');?>"><button class="btn btn-danger" type="button" aria-controls="step-2" onclick="resetFilters();" aria-expanded="false"><i class="fa fa-refresh" aria-hidden="true"></i>&nbsp;RESET FILTERS</button></a>
						 </div>
						 
						<?/*?> <div id="filter_col4" data-column="3" class="col-md-3">
							<label>Search By Category</label>
							<!--<input type="text" class="column_filter form-control" id="col2_filter">-->
							<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" id="col3_filter" onchange="getFilterAttendence(3);" name="category" >
                                <option value="">--Select Category--</option>
                                <?php 
								    $tbl_category	=	$this->Common_model->select_where_ASC_DESC('fld_id,fld_category','tbl_category',array('fld_status'=>1),'fld_category','ASC');
                                    if($tbl_category->num_rows() > 0) {
                                    foreach($tbl_category->result() as $cat){
                                ?>
                                    <option value="<?php echo $cat->fld_id;?>"><?php echo $cat->fld_category;?></option>
                                <?php } } ?>
                            </select>
						 </div><??>
						</div>
						 
						
						</form> */?>
	                <!--<hr>-->
                    <table id="datatable_tb" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead class="tabletop">
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Plant</th>
                            <th>Category</th>
							<th>Sub Category</th>
                            <!--<th>Purchase</th>-->
							<th>Sale</th>
							<!--<th>Difference</th>-->
							<th>Action</th>
                        </tr>
                        </thead>
                        <tbody id="employee_data">
        				<?php 
                        if($history){
                        $i = 1;    
                        foreach($history as $hist){ 
        					 $plant        =	 $this->Common_model->select_single_field('fld_location','tbl_locations',array('fld_id'=>$hist['plants']));
        					 $category     =	 $this->Common_model->select_where_return_row('fld_category,fld_unit','tbl_category',array('fld_id'=>$hist['category']));
        					 $subcategory  =	 $this->Common_model->select_single_field('fld_subcategory','tbl_subcategory',array('fld_subcid'=>$hist['sub_category']));
        					 $unit         =	 $this->Common_model->select_single_field('fld_unit','tbl_units',array('fld_id'=>$category->fld_unit));
        					 $date = date("d/m/Y",strtotime($hist['date']));
                        ?>
                        <tr>
                            <td><?=$i++;?></td>
                            <td><?=$date;?></td>
							<td><?=$plant;?></td>
                            <td><?=$category->fld_category;?></td>
                            <td><?=$subcategory;?>&nbsp;<?=$unit;?></td>
							<!--<td class="purchase"> -->
							<!--  <input type="number" style="width: 100%;height: 100%;border: none;padding: 10px;" min=0 max=30 value="<?//=$hist['purchase'];?>" onkeyup="updateValue('purchase', <?//=$hist['id'];?>)" onblur="updateValue('purchase', <?//=$hist['id'];?>)" id="purchase_<//?=$hist['id'];?>">-->
							<!--</td>-->
							<td class="sale">
							  <input type="number" style="width: 100%;height: 100%;border: none;padding: 10px;" min=0 max=30 value="<?=$hist['sale'];?>" onkeyup="updateValue('sale', <?=$hist['id'];?>)" onblur="updateValue('sale', <?=$hist['id'];?>)" id="sale_<?=$hist['id'];?>">
							</td>
							<!--<td>&nbsp;</td>-->
							<td>
							    <!--<?// if(!empty($role_permissions) && in_array(3,$role_permissions)) { ?>-->
							<a href="<?= base_url('SaleRate/edit?date='.$date.'&plant='.$hist['plants']);?>">
							<i style="font-size:15px;cursor:pointer;" class="mdi mdi-square-edit-outline" title="Edit"></i></a>
							
							<a href="<?= base_url('SaleRate/delete?date='.$date.'&plant='.$hist['plants']);?>" onclick="return confirm('This action will delete sale rate permanently. Continue?');">
							<i style="font-size:15px;cursor:pointer;" class="mdi mdi-delete-forever" title="Delete"></i></a>
							<!--<? //} ?>-->
							
							<!--<?// if(!empty($role_permissions) && in_array(4,$role_permissions)) { ?>-->
							<!--<a href="<?//= base_url('SaleRate/view?date='.$date.'&plant='.$hist['plants']);?>"><i style="font-size:15px;cursor:pointer;" class="mdi mdi-eye-circle-outline" title="View"></i></a>-->
							<!--<? //} ?>-->
							</td>
                        </tr>
                	    <?php }}else {?>
                        <tr>
                            <td colspan="7"><br><p style="color:#900; text-align: center;" >Sorry No Record Found!</p></td>
                            <td style="display:none;"></td>
                            <td style="display:none;"></td>
                            <td style="display:none;"></td>
                            <td style="display:none;"></td>
                            <td style="display:none;"></td>
                            <td style="display:none;"></td>
                        </tr>
                        <? } ?>
						</tbody>
                    </table>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
</div> 
<div class="modalLoader"><!-- Place at bottom of page --></div>
<script>
    function updateValue(key, id){
        
        var purchase = $("#purchase_"+id).val();
        var sale = $("#sale_"+id).val();
        var postData;
        if(key == 'purchase'){
            postData = 'name=purchase&value='+purchase+'&pk='+id;
        }else if(key == 'sale'){
            postData = 'name=sale&value='+sale+'&pk='+id;
        }
    
        jQuery.ajax({
				url  	: base_url+"SaleRate/update_salerate",
				type 	: 'POST',
				data 	: postData,
				success : function(data){
				    console.log(data);
				}
		});	
}
</script>
  