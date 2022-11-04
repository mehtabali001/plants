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
/*	box-shadow: 0 0 black;*/
/*}*/
</style>
<? $role_permissions  = explode(",",$this->session->userdata('permissions')); ?>
<div class="container-fluid">
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right" style="margin-bottom:15px;">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Gain_loss" type="button" class="btn btn-outline-primary"><i class="fa fa-shopping-cart"></i>&nbsp;New Gain-Loss</a>
                  <a href="<?= base_url();?>Gain_loss/manage" type="button" class="btn btn-outline-primary"><i class='fas fa-eye'></i>&nbsp;View Gain-Loss</a>
                  <a href="<?= base_url();?>Gain_loss/Gain_loss_report" type="button" class="btn btn-outline-primary"><i class="fa fa-bar-chart"></i>&nbsp;Gain-Loss Report</a>
                  <a href="<?= base_url();?>Gain_loss/manage_trash" type="button" class="btn btn-primary btn-large"><i class='fa fa-trash'></i>&nbsp;Gain-Loss Trash</a>
                </div>
			</div>
			<!--<h4 class="page-title">Trashed Gain-Loss</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Gain-Loss</a></li>-->
			<!--	<li class="breadcrumb-item active">Trashed Gain-Loss</li>-->
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
                <table id="datatable_tb" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead class="tabletop">
                    <tr>
                        <th>Invoice Date</th>
                        <th>Invoice ID</th>
                        <th>Deleted By</th>
                        <th>Remarks</th>
                        <th>Amount(PKR)</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <tbody>
						<?php if($gainloss){
							$i=1;
							foreach($gainloss as $gl){
							 $trashby  =  $this->Common_model->select_single_field('fld_username','tbl_users',array('fld_id'=>$gl['fld_trash_by']));	
							?>
						<tr>
							<td><?php echo date('d-m-Y',strtotime($gl['fld_date']));?></td>
							<td><?php echo $gl['fld_voucher_no'];?></td>
							<td>
            				<?php 
            				   echo $trashby."<br>";
            				   echo '<span style="width: 130px; display: inline-block;color:#506ee4; font-size:11px;">Date: '.date("d-m-Y",strtotime($gl['fld_trash_date'])).'</span>'."<br>";
            				   echo '<span style="width: 130px; display: inline-block;color:#21d0c0; font-size:10px;">Time: '.date("H:i:s",strtotime($gl['fld_trash_date'])).'</span>';
            				?>
            				</td>
							<td style="font-size:12px;padding:3px;"><?php echo $gl['fld_remarks'];?></td>
							<td><?php echo $gl['fld_grand_total_amount'];?></td>
							<td>
						    <? if(!empty($role_permissions) && in_array(148,$role_permissions)) { ?>
						    <a data-toggle="modal" class="exampleModal" data-target="#exampleModal" data-content="<?php echo $gl['fld_id']; ?>" data-uri="<?= base_url('Gain_loss/restore/'.$gl['fld_id'].'');?>">
		        <i style="font-size:16px;cursor:pointer;" class="fas fa-trash-restore" title="Restore"></i></a>
							<!--<a href="<?//= base_url('Gain_loss/restore/'.$gl['fld_id'].'');?>" onclick="return confirm('Are you sure you want to Restore this record.')">-->
       <!--             		<i style="font-size:16px;cursor:pointer;" class="fas fa-trash-restore" title="Restore"></i>-->
       <!--             		</a>-->
                    		<? } ?>
                    		
							<? if(!empty($role_permissions) && in_array(149,$role_permissions)) { ?>
							<a data-toggle="modal" class="exampleModal2" data-target="#exampleModal2" data-content="<?php echo $gl['fld_id']; ?>" data-uri="<?= base_url('Gain_loss/deletepermanent/'.$gl['fld_id']);?>">
		        <i style="font-size:20px;cursor:pointer;" class="mdi mdi-delete-forever" title="Delete"></i></a>
							<!--<a href="<?//= base_url('Gain_loss/deletepermanent/'.$gl['fld_id']);?>" onclick="return confirm('Are you sure you want to delete this record.')">-->
							<!--<i style="font-size:20px;cursor:pointer;" class="mdi mdi-delete-forever" title="Delete"></i>-->
							<!--</a>-->
							<? } ?>
							</td>
												
							</tr>
									
							<?php $i++; }}else{?>
						        <tr>
						            <td colspan="6" style="color:red;text-align:center;">Sorry No Record Found</td>
						            <td style="display:none"></td>
						            <td style="display:none"></td>
						            <td style="display:none"></td>
						            <td style="display:none"></td>
						            <td style="display:none"></td>
						            
						        </tr>
						    <?php } ?>
                        </tbody>
                    </table>

                </div>
                
<div class="modal fade bs-example-modal-center" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="box-shadow: 0 7px 14px 0 rgb(65 203 216 / 50%) !important;">
    <div class="modal-header">
        <h5 class="modal-title mt-0" id="exampleModalLabel">GainLoss Entry</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form id="modal-form" method="post">
    <div class="modal-body">
        <p>Are you sure you want to Restore this record.</p>
    </div>
    <div class="modal-footer">
        <input type="hidden" id="gl_id" name="gl_id" />
        <button type="button" class="btn btn-gradient-danger waves-effect waves-light" data-dismiss="modal">Cancel</button>
        <button type="Submit" class="btn btn-gradient-purple waves-effect waves-light">Proceed to Restore</button>
    </div>
    </form>
    </div>
</div>
</div>

<div class="modal fade bs-example-modal-center" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="box-shadow: 0 7px 14px 0 rgb(65 203 216 / 50%) !important;">
    <div class="modal-header">
        <h5 class="modal-title mt-0" id="exampleModalLabel">GainLoss Entry</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form id="modal-formdelete" method="post">
    <div class="modal-body">
        <p>Are you sure you want to Delete this record.</p>
    </div>
    <div class="modal-footer">
        <input type="hidden" id="gl_id" name="gl_id" />
        <button type="button" class="btn btn-gradient-danger waves-effect waves-light" data-dismiss="modal">Cancel</button>
        <button type="Submit" class="btn btn-gradient-purple waves-effect waves-light">Proceed to Permanent Delete</button>
    </div>
    </form>
    </div>
</div>
</div>                
                
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
</div>

                