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
</style>
<? $role_permissions  = explode(",",$this->session->userdata('permissions')); ?>
<div class="container-fluid">
    <div class="row">
    <div class="col-sm-12" style="margin-bottom:2%;">
		<div class="page-title-box">
			<div class="float-right">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Others/add_partner" type="button" class="btn btn-outline-primary "><i class="fas fa-comments"></i>&nbsp;New Complaint</a>
                  <a href="<?= base_url();?>Complaints/my_complaints" type="button" class="btn btn-primary btn-large"><i class="fa fa-paper-plane" aria-hidden="true"></i>&nbsp;My Complaints</a>
                  <a href="<?= base_url();?>Complaints/assigned_complaints" type="button" class="btn btn-outline-primary"><i class='fas fa-box-open'></i>&nbsp;Assigned Complaints</a>
                  <a href="<?= base_url();?>" type="button" class="btn btn-outline-primary"><i class="fas fa-tachometer-alt"></i>&nbsp;Dashboard</a>
                </div>
			</div>
			<!--<h4 class="page-title">My Complaints</h4>-->
			
		</div><!--end page-title-box-->
	</div>
</div>
<!-- end page title end breadcrumb -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
								<div class="row">
									<div class="col-sm-12">
									  <div class="float-right" style="margin-bottom: 15px;">
										<button type="button" id="currentday" class="btn btn-success waves-effect waves-light" onclick="showRecord('showall');" style="box-shadow: 0 7px 14px 0 rgb(45 218 181 / 50%);" name="show-current-day" value=""><i class="fa fa-line-chart" aria-hidden="true"></i>&nbsp;Show All</button>
										<button type="button" id="currentweek" class="btn btn-purple waves-effect waves-light" onclick="showRecord('resolved');" style="box-shadow: 0 7px 14px 0 rgb(109 129 245 / 50%);" name="show-current-week" value=""><i class="fa fa-line-chart" aria-hidden="true"></i>&nbsp;Resolved Only</button>
										<button type="button" id="currentmonth" class="btn btn-secondary waves-effect waves-light" onclick="showRecord('pending');" style="box-shadow: 0 7px 14px 0 rgb(65 203 216 / 50%) !important;" name="show-current-month" value=""><i class="fa fa-bar-chart" aria-hidden="true"></i>&nbsp;Pending Only</button>
										<button type="button" id="currentyear" class="btn btn-info waves-effect waves-light" onclick="showRecord('notresolved');" style="box-shadow: 0 7px 14px 0 rgb(155 167 202 / 50%);" name="show-current-year" value=""><i class="fa fa-line-chart" aria-hidden="true"></i>&nbsp;Not Resolved</button>
									   </div>
									</div>
									</div>
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
									<div id="filterhtml">
                                    <table id="datatable_tb" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead class="tabletop">
                                        <tr>
                                            <th>#</th>
                                            <th>Complaint ID</th>
                                            <!--<th>Name</th>-->
                                            <th>Date</th>
                                            <th>Subject</th>
                                            <th>Category</th>
                                            <!--<th>Description</th>-->
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
    
    
                                        <tbody>
										<?php if($my_complaints){
											$i=1;
											foreach($my_complaints as $comp){
												
											?>
                                        <tr>
                                            <td><?= $i;?></td>
                                            <td><?= $comp['fld_complain_id'];?></td>
                                            <td><?= date('d-m-Y',strtotime($comp['fld_created_date']));?></td>
                                            <td><?= $comp['fld_complain_subject'];?></td>
                                            <td><?= $comp['category_name'];?></td>
                                            <!--<td><?//= $comp['fld_description'];?></td>-->
                                            <td>
											
											<?php if($comp['fld_status'] == 0){?>
											Pending
											<?php }elseif($comp['fld_status'] == 1){?>
											Resolved
											<?php }else{?>
											Not resolved
											<?php }?>
											
											
											</td>
                                            <td>
											<?php if($comp['fld_status'] == 0){?>
											<? if(!empty($role_permissions) && in_array(73,$role_permissions)) { ?>
											
											<a href="<?= base_url('Complaints/edit_complaint/'.$comp['fld_id'].'')?>">
											<i style="font-size:20px;cursor:pointer;" class="mdi mdi-square-edit-outline" title="Edit"></i></a>
											<? } ?>
											<? if(!empty($role_permissions) && in_array(74,$role_permissions)) { ?>
											<!--<a href="<?= base_url('Complaints/deleteComplaint/'.$comp['fld_id'].'')?>" onclick="return confirm('Are you sure you want to delete this record.')">-->
											<!--<i style="font-size:20px;cursor:pointer;" class="mdi mdi-delete-forever" title="Delete"></i>-->
											<!--</a>-->
											
											<a data-toggle="modal" class="exampleModal" data-target="#exampleModal" data-content="<?php echo $comp['fld_id']; ?>" data-uri="<?= base_url('Complaints/deleteComplaint/'.$comp['fld_id'].'')?>">
		                                    <i style="font-size:20px;cursor:pointer;" class="mdi mdi-delete-forever" title="Delete"></i></a>
											
											<? }} ?>
											
											<a href="<?= base_url('Complaints/view_complaint/'.$comp['fld_id'].'')?>">
											<i style="font-size:20px;cursor:pointer;" class="mdi mdi-eye-circle-outline" title="View"></i></a>
											</td>
                                        </tr>
										<?php  $i++;}} else {?>
										<td colspan="7" style="text-align:center;color:red;">
										        Sorry no record found
										    </td>
										<?}?>
                                        </tbody>
                                    </table>
    
									</div>
                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->
</div>
<div class="modal fade bs-example-modal-center" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="box-shadow: 0 7px 14px 0 rgb(65 203 216 / 50%) !important;">
        <div class="modal-header">
            <h5 class="modal-title mt-0" id="exampleModalLabel">Delete Complaint Record</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form id="modal-form" method="post">
        <div class="modal-body">
            <p>Are you sure you want to delete this record.</p>
        </div>
        <div class="modal-footer">
            
            <input type="hidden" id="complaint_id" name="complaint_id" />
            <button type="button" class="btn btn-gradient-danger waves-effect waves-light" data-dismiss="modal">Cancel</button>
            <button type="Submit" class="btn btn-gradient-purple waves-effect waves-light">Proceed to Delete</button>
            
        </div>
        </form>
        </div>
    </div>
</div>

                