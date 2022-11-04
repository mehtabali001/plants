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
/*.btn-success, .btn-info, .btn-primary, .btn-warning,.btn-danger,.btn-gradient-primary,.btn-gradient-danger{*/
  /*box-shadow: 0 0 black;*/
/*}*/
.sorting_1 p{
  text-align:center;
}
#datatable_wrapper .col-sm-12{
    overflow:auto;
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
                  <a href="<?= base_url();?>Sales/manage_trash" type="button" class="btn btn-primary btn-large"><i class="fa fa-trash"></i>&nbsp;Trashed Expenses</a>
                  <a href="<?= base_url();?>Expenses/manage_drafts" type="button" class="btn btn-outline-primary"><i class="fa fa-files-o"></i>&nbsp;Drafts</a>
                </div>
			</div>
			<!--<h4 class="page-title">Trash Expenses</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Others</a></li>-->
			<!--	<li class="breadcrumb-item active">Trashed Expenses</li>-->
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
					<?php 
					    $success_message = $this->session->userdata('success_message');
					    if (isset($success_message)) {
					?>
						<div class="alert alert-success">
							<?php echo $success_message ?>                    
						</div>
					<?php
						$this->session->unset_userdata('success_message');
					}?>
				</div>
                <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;  overflow:auto;">
                    <thead class="tabletop">
                    <tr>
                        <th>#</th>
                        <th>Expense Date</th>
                        <th>Deleted By</th>
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
											    $plantfrom =	$this->Common_model->select_single_field('fld_location','tbl_locations',array('fld_id'=>$exp['plant_from']));
											    //$name =	$this->Common_model->select_single_field('name','tbl_stationary',array('id'=>$exp['expense_item']));
											    $trashby =	$this->Common_model->select_single_field('fld_username','tbl_users',array('fld_id'=>$exp['fld_trash_by']));
											
											?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><?= date('d-M-Y',strtotime($exp['date_added']));?></td>
                                            <td>
                							<?php
                            				 echo $trashby."<br>";
                            				 echo '<span style="width: 130px; display: inline-block;color:#506ee4; font-size:11px;">Date: '.date("d-m-Y",strtotime(@$exp['fld_trash_date'])).'</span>'."<br>";
                            				 echo '<span style="width: 130px; display: inline-block;color:#21d0c0; font-size:10px;">Time: '.date("H:i:s",strtotime(@$exp['fld_trash_date'])).'</span>';
                            				?>
                							</td>
                                            <td>
                                            <?//=$plantfor; 
                                            echo $exp['expense_voucher'] 
                                            ?>
                                            </td>
                                            <td><?=$plantfrom;?></td>
                                            <td>
                                                <?//=$name;?>
                                                <?php 
                    							  $products = $this->db->query("select * from tbl_expense_detail where fld_expense_id = '".$exp['id']."'")->result_array();
                    							  foreach($products as $prod){
                    							      $name =	$this->Common_model->select_single_field('name','tbl_stationary',array('id'=>$prod['stationary'])); 
                    							       echo $name .','.'<br>';
                    							  }
                    							?>
                                            
                                            </td>
                                            <td><?=$exp['fld_grand_total_amount'];?></td>
                                            <td>
                                            <? if(!empty($role_permissions) && in_array(157,$role_permissions)) { ?>
                                    <!--        <a href="" onclick="return confirm('Are you sure you want to Restore this record.')">-->
            			                    	<!--<i style="font-size:16px;cursor:pointer;" class="" title="Restore"></i>-->
            			                    	<!--</a>-->
            			                    	<a data-toggle="modal" class="exampleModal2" data-target="#exampleModal2" data-content="<?php echo $exp['id']; ?>" data-uri="<?= base_url('Expenses/restore/'.$exp['id'].'');?>">
		                                    <i style="font-size:14px;cursor:pointer;" class="fas fa-trash-restore" title="Delete"></i></a>
            				                <? } ?>
											
											<? if(!empty($role_permissions) && in_array(161,$role_permissions)) { ?>
                							<a href="<?= base_url('Expenses/detail/'.$exp['id'].'');?>"><i style="font-size:20px;cursor:pointer;" class="mdi mdi-eye-circle-outline" title="View"></i></a>
                							<? } ?>
                							
											<? if(!empty($role_permissions) && in_array(158,$role_permissions)) { ?>
											<!--<a href="" onclick="return confirm('Are you sure you want to delete this record.')">-->
											<!--<i style="font-size:20px;cursor:pointer;" class="mdi mdi-delete-forever" title="Delete"></i>-->
											<!--</a>-->
											<a data-toggle="modal" class="exampleModal" data-target="#exampleModal" data-content="<?php echo $exp['id']; ?>" data-uri="<?= base_url('Expenses/deletepermanent/'.$exp['id'].'')?>">
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
            <p>Are you sure you want to delete this record permanently?</p>
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
<div class="modal fade bs-example-modal-center" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="box-shadow: 0 7px 14px 0 rgb(65 203 216 / 50%) !important;">
        <div class="modal-header">
            <h5 class="modal-title mt-0" id="exampleModalLabel">Undo Deleted Record</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form id="modal-formundo" method="post">
        <div class="modal-body">
            <p>Are you sure you want to restore this record.</p>
        </div>
        <div class="modal-footer">
            
            <input type="hidden" id="expense_id" name="expense_id" />
            <button type="button" class="btn btn-gradient-danger waves-effect waves-light" data-dismiss="modal">Cancel</button>
            <button type="Submit" class="btn btn-gradient-purple waves-effect waves-light">Proceed to Restore</button>
            
        </div>
        </form>
        </div>
    </div>
</div>