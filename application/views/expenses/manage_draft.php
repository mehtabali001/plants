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
@media only screen and (max-width: 600px){
    
#datatable2_length label{
    width: 100%;
}
#datatable2_filter{
    width: 100%;
}
#datatable2_filter label{
    width: 100%;
}
}
</style>
<? $role_permissions  = explode(",",$this->session->userdata('permissions')); ?>
<div class="container-fluid">
<div class="row">
	<div class="col-sm-12" style="margin-bottom:1%;">
		<div class="page-title-box">
			<div class="float-right">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Expenses/manage_Expenses" type="button" class="btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;View Expenses</a>
                  <a href="<?= base_url();?>Expenses/expenseReport" type="button" class="btn btn-outline-primary"><i class="fa fa-files-o"></i>&nbsp;Expense Report</a>
                  <a href="<?= base_url();?>Sales/manage_trash" type="button" class="btn btn-outline-primary"><i class="fa fa-trash"></i>&nbsp;Trashed Expenses</a>
                  <a href="<?= base_url();?>Expenses/manage_drafts" type="button" class="btn btn-primary btn-large"><i class="fa fa-files-o"></i>&nbsp;Drafts</a>
                </div>
			</div>
			<!--<h4 class="page-title">View Drafts</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Others</a></li>-->
			<!--	<li class="breadcrumb-item active">View Drafts</li>-->
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
	                
	                <div class="row">
                        <div class="col-12">
                             <?
                                $user_id=$this->session->userdata('user_id');
                                $record=$this->db->query("SELECT * FROM `tbl_expenses_draft` WHERE fld_userid='$user_id'")->num_rows();
                                ?>
                                            <? if($record>0){?>
					        <a href="<?php echo base_url();?>Expenses/cleardrafts" onclick="return confirm('Are you sure to clear all drafts?')" style="float: right;color:red;">Clear Drafts</a>
					    <?}?>
					    </div>
					</div>
                                    <table id="datatable2" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead class="tabletop">
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Invoice ID</th>
                                            <th>Paid From</th>
                                            <th>Item(s)</th>
                                            <th>Items Amount (PKR)</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
										<?php if($expenses){
										    $i = 1;
											foreach($expenses as $exp){
											    $plantfor =	$this->Common_model->select_single_field('fld_location','tbl_locations',array('fld_id'=>$exp['plant_for']));
											    $plantfrom =	$this->Common_model->select_single_field('head_name','tbl_coa',array('head_code'=>$exp['plant_from']));
											    //$name =	$this->Common_model->select_single_field('name','tbl_stationary',array('id'=>$exp['expense_item']));
											
											?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><?= date('d-M-Y',strtotime($exp['date_added']));?></td>
                                            <td>
                                            <?//=$plantfor; 
                                            echo $exp['expense_voucher'] 
                                            ?>
                                            </td>
                                            <td><?=$plantfrom;?></td>
                                            <td>
                                                <?//=$name;?>
                                                <?php 
                    							  $products = $this->db->query("select * from tbl_expense_draft_detail where fld_expense_id = '".$exp['id']."'")->result_array();
                    							  foreach($products as $prod){
                    							      $name =	$this->Common_model->select_single_field('name','tbl_stationary',array('id'=>$prod['stationary'])); 
                    							       echo $name .','.'<br>';
                    							  }
                    							?>
                                            
                                            </td>
                                            <td><?=$exp['fld_grand_total_amount'];?></td>
                                            <td> 
                                                
											<? if(!empty($role_permissions) && in_array(159,$role_permissions)) { ?>
											<a href="<?= base_url('Expenses/editdraft/'.$exp['id'].'')?>">
											<i style="font-size:20px;cursor:pointer;" class="mdi mdi-square-edit-outline" title="Edit"></i></a>
											<? } ?>
                							
											<? if(!empty($role_permissions) && in_array(160,$role_permissions)) { ?>
											<!--<a href="" onclick="return confirm('Are you sure you want to delete this record.')">-->
											<!--<i style="font-size:20px;cursor:pointer;" class="mdi mdi-delete-forever" title="Delete"></i>-->
											<!--</a>-->
											<a data-toggle="modal" class="exampleModal" data-target="#exampleModal" data-content="<?php echo $exp['id']; ?>" data-uri="<?= base_url('Expenses/deletedraft/'.$exp['id'].'')?>">
		                                    <i style="font-size:20px;cursor:pointer;" class="mdi mdi-delete-forever" title="Delete"></i></a>
											<? } ?>
											
											</td>
                                        </tr>
										<?php }  } ?>
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
            <h5 class="modal-title mt-0" id="exampleModalLabel">Delete Trash Record</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form id="modal-form" method="post">
        <div class="modal-body">
            <p>Are you sure you want to delete this record ?</p>
        </div>
        <div class="modal-footer">
            
            <input type="hidden" id="expense_id" name="expense_id" />
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