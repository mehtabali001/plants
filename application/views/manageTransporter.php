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
<? $role_permissions  = explode(",",$this->session->userdata('permissions')); ?>
<div class="container-fluid">
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right" style="margin-bottom:15px;">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Common/addTransporter" type="button" class="btn btn-outline-primary"><i class="fas fa-bus"></i>&nbsp;Add Transport/Bowser</a>
                  <a href="<?= base_url();?>Common/manage_Transporter" type="button" class="btn btn-primary btn-large"><i class="fa fa-eye"></i>&nbsp;View Transport/Bowser</a>
                  <a href="<?= base_url();?>Navigations/createIntNav" type="button" class="btn btn-outline-primary"><i class='fas fa-rocket'></i>&nbsp;New Navigation</a>
                  <a href="<?= base_url();?>Navigations/navigationReport" type="button" class="btn btn-outline-primary"><i class='fa fa-bar-chart'></i>&nbsp;Navigations Report</a>
                </div>
			</div>
			<!--<h4 class="page-title">Manage Transport/Bowser</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Transport/Bowser</a></li>-->
			<!--	<li class="breadcrumb-item active">Manage Transport/Bowser</li>-->
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
										} ?>
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
                                    <table id="datatable_tb" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead class="tabletop">
                                        <tr>
                                            <th>Vehicle No.</th>
                                            <th>Owner Name</th>
                                            <th>Driver Name</th>
                                            <th>Driver Mobile</th>
                                            <th>Area</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
    
    
                                        <tbody>
										<?php if($transporter){
											foreach($transporter as $tran){
											    $updateby =	$this->Common_model->select_single_field('fld_username','tbl_users',array('fld_id'=>$tran['fld_updated_by']));
											?>
                                        <tr>
                                            <td><?= ucfirst($tran['fld_vehicle_number'])."<br>";
                                    		    if($tran['fld_updated_by'] != 0){
                                    				echo '<span style="width: 150px; display: inline-block;color:#506ee4; font-size:10px;">Edited On: '.date("d-m-Y,H:i",strtotime(@$tran['fld_updated_date'])).'</span>'."<br>";
                                    				echo '<span style="width: 150px; display: inline-block;color:#21d0c0; font-size:10px;">By: '.$updateby.'</span>';
                                    		    }?></td>
                                            <td><?= ucfirst($tran['fld_owner_name']);?></td>
                                            <td><?= ucfirst($tran['fld_dname1']);?></td>
                                            <td><?= ucfirst($tran['fld_dmobile1']);?></td>
                                            <td><?= ucfirst($tran['fld_area']);?></td>
                                            <td>
											<? if(!empty($role_permissions) && in_array(93,$role_permissions)) { ?>
											<a href="<?= base_url('Common/editTransporter/'.$tran['fld_id'].'')?>">
											<i style="font-size:20px;cursor:pointer;" class="mdi mdi-square-edit-outline" title="Edit"></i></a>
											<? } ?>
											<? if(!empty($role_permissions) && in_array(94,$role_permissions)) { ?>
											<a data-toggle="modal" class="exampleModal" data-target="#exampleModal" data-content="<?=$tran['fld_id']; ?>" data-uri="<?= base_url('Common/deleteTransporter/'.$tran['fld_id'].'')?>">
		<i style="font-size:20px;cursor:pointer;" class="mdi mdi-delete-forever" title="Delete"></i></a>
											
											<!--<a href="<?//= base_url('Common/deleteTransporter/'.$tran['fld_id'].'')?>" onclick="return confirm('Are you sure you want to delete this record.')">-->
											<!--<i style="font-size:20px;cursor:pointer;" class="mdi mdi-delete-forever" title="Delete"></i>-->
											<!--</a>-->
											<? } ?>
											</td>
                                        </tr>
										<?php }}else{?>
										<td colspan="6" style="text-align:center;color:red;">
										        Sorry no record found
										    </td>
										    <td style="display:none"></td>
										    <td style="display:none"></td>
										    <td style="display:none"></td>
										    <td style="display:none"></td>
										    <td style="display:none"></td>
										<? } ?>
										
                                        </tbody>
                                    </table>
    
                                </div>
                                
<div class="modal fade bs-example-modal-center" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="box-shadow: 0 7px 14px 0 rgb(65 203 216 / 50%) !important;">
    <div class="modal-header">
        <h5 class="modal-title mt-0" id="exampleModalLabel">Bowser Entry</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form id="modal-form" method="post">
    <div class="modal-body">
        <p>Are you sure you want to delete this record.</p>
    </div>
    <div class="modal-footer">
        
        <input type="hidden" id="fld_id" name="fld_id" />
        <button type="button" class="btn btn-gradient-danger waves-effect waves-light" data-dismiss="modal">Cancel</button>
        <button type="Submit" class="btn btn-gradient-purple waves-effect waves-light">Proceed to Delete</button>
        
    </div>
    </form>
    </div>
</div>
</div>
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->
</div>

                