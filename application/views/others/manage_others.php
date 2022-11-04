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
.dataTables_filter {
    float: right;
}
</style>
<? $role_permissions  = explode(",",$this->session->userdata('permissions')); ?>
<div class="container-fluid">
<div class="row">
	<div class="col-sm-12" style="margin-bottom:1%;">
		<div class="page-title-box">
			<div class="float-right">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Others/add_partner" type="button" class="btn btn-outline-primary"><i class="fa fa-shopping-cart"></i>&nbsp;New Partner</a>
                  <a href="<?= base_url();?>Others/manage_partners" type="button" class="btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;View Partners</a>
                  <a href="<?= base_url();?>Others" type="button" class="btn btn-outline-primary"><i class="fa fa-shopping-cart"></i>&nbsp;New Others Parties</a>
                  <a href="<?= base_url();?>Others/manage_others" type="button" class="btn btn-primary btn-large"><i class="fa fa-eye"></i>&nbsp;View Other Parties</a>
                </div>
			</div>
			<!--<h4 class="page-title">Manage Others</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Others</a></li>-->
			<!--	<li class="breadcrumb-item active">Manage Other</li>-->
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
										}
										?>
										<?php 
										  $success_message = $this->session->userdata('success_message');
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
						<?/*?><form action="<?= base_url('Expenses/addExpenseshistoryfilter');?>" method="post" id="attendanceFilterForm">
                        <div class="row">
						<div id="filter_global" class="col-md-3">
						    <label>Global search</label>
							<input type="text" class="global_filter form-control" id="global_filter">
						</div>

						<div id="filter_col1" data-column="0" class="col-md-3">
						   <label>Date</label>
						   <input type="text" name="date" class="column_filter form-control datepicker" id="col0_filter_d" <? if(isset($_GET['date'])) { ?> value="<?=date("m-d-Y",strtotime($_GET['date']));?>" <? } ?> >
						</div>
						
						<div id="filter_col3" data-column="2" class="col-md-3">
							<label>Search By Plants</label>
							<!--<input type="text" class="column_filter form-control" id="col2_filter">-->
							<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" id="col2_filter" name="plant_for" >
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
						 <div class="col-md-3">
							<label>Search By items</label>
							<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" id="col3_filter" name="expense_item" >
                                <option value="">--Select Item--</option>
                                <?php 
								    $tbl_items	=	$this->Common_model->select_where_ASC_DESC('id,name','tbl_stationary',array('status'=>1),'name','ASC');
                                    if($tbl_items->num_rows() > 0) {
                                    foreach($tbl_items->result() as $itmm){
                                ?>
                                    <option value="<?php echo $itmm->id;?>" <? if (!empty($_GET['name']) && $_GET['name'] == $itmm->id){ echo "selected"; } ?>><?php echo $itmm->name;?></option>
                                <?php } } ?>
                            </select>
						 </div>
						 <div class="col-md-6" style="margin-top:25px;">
						        <button type="submit" class="btn btn-primary waves-effect waves-light"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Search</button>&nbsp;&nbsp;
						        <button class="btn btn-danger" type="button" aria-controls="step-2" onclick="resetFilters();" aria-expanded="false"><i class="fa fa-refresh" aria-hidden="true"></i>&nbsp;RESET FILTERS</button>
						 </div>
						 
						</div>
						</form>
	                <hr><?*/?>	
                                    <table id="datatable_tb" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead class="tabletop">
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Name</th>
                                            <th>Contact</th>
                                            <th>Address</th>
                                            <th>Head Account</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
										<?php if($coa){
										    $i = 1;
											foreach($coa as $account){
											     $updateby =	$this->Common_model->select_single_field('fld_username','tbl_users',array('fld_id'=>$account['fld_updated_by']));
											?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            
                                            <td><?=$account['head_name'];?></td>
                                            <td><?=$account['contact']."<br>";
                                    		    if($account['fld_updated_by'] != 0){
                                    				echo '<span style="width: 170px; display: inline-block;color:#506ee4; font-size:10px;">Updated On: '.date("d-m-Y,h:i A",strtotime(@$account['fld_updated_date'])).'</span>'."<br>";
                                    				echo '<span style="width: 170px; display: inline-block;color:#21d0c0; font-size:10px;">By: '.$updateby.'</span>';
                                    		    }?>
                                            </td>
                                            <td><?=$account['address'];?></td>
                                            <td><?=$account['parent_head_name'];?></td>
                                            <td>
   
											<? if(!empty($role_permissions) && in_array(172,$role_permissions)) { ?>
											<a href="<?= base_url('Others/edit/'.$account['head_code'].'')?>">
											<i style="font-size:20px;cursor:pointer;" class="mdi mdi-square-edit-outline" title="Edit"></i></a>
											
											<? } ?>
											<!--<a href="<?//=base_url();?>Others/deleteO/<?//=$account['head_code'];?>" onclick="return confirm('Are you sure you want to delete this record.')">-->
							                <!--<i style="font-size:15px;cursor:pointer;" class="mdi mdi-delete-forever" title="Delete"></i>-->
							                <!--</a>-->
							                    <a data-toggle="modal" class="exampleModal" data-target="#exampleModal" data-content="<?php echo $account['head_code']; ?>" data-uri="<?=base_url();?>Others/deleteO/<?=$account['head_code'];?>"><i style="font-size:20px;cursor:pointer;" class="mdi mdi-delete-forever" title="Delete"></i></a>
											
											<!--<? //if(!empty($role_permissions) && in_array(173,$role_permissions)) { ?>-->
											<!--<a href="<?//= base_url('Others/delete/'.$account['head_code'].'')?>" onclick="return confirm('Are you sure you want to delete this record.')">-->
											<!--<i style="font-size:20px;cursor:pointer;" class="mdi mdi-delete-forever" title="Delete"></i>-->
											<!--</a>-->
											<!--<? //} ?>-->
											</td>
                                        </tr>
										<?php }  } else{?>
										<tr>
										    <td colspan="6" style="text-align:center;color:red;">
										        Sorry no record found
										    </td>
										    <td style="display:none;"></td>
										    <td style="display:none;"></td>
										    <td style="display:none;"></td>
										    <td style="display:none;"></td>
										    <td style="display:none;"></td>
										</tr>
										<?}?>
										
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->
</div>
<div class="modal fade bs-example-modal-center" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="box-shadow: 0 7px 14px 0 rgb(65 203 216 / 50%) !important;">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="exampleModalLabel">Delete Other Party</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="modal-form" method="post">
                <div class="modal-body">
                    <p>Are you sure you want to delete this record.</p>
                </div>
                <div class="modal-footer">
                    
                    <input type="hidden" id="partner_id" name="partner_id" />
                    <button type="button" class="btn btn-gradient-danger waves-effect waves-light" data-dismiss="modal">Cancel</button>
                    <button type="Submit" class="btn btn-gradient-purple waves-effect waves-light">Proceed to Delete</button>
                    
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function resetFilters(){
        $("#global_filter").val("").change();
        $("#col0_filter_d").val("");
        $("#col2_filter").val("").change();
        $("#col3_filter").val("").change();
    }
</script>