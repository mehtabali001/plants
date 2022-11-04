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
/*modal*/
.panel {
  border-radius: 4px;
  padding: 1rem;
  margin-top: 0.2rem;
  background-color: #F5F5F5;
  color: #323B40;
}
.panel.panel-blue {
  background-color: #E0F5FF;
  color: #00A5FA;
}
.panel.panel-big-height {
  min-height: 150px;
}

.item {
  border-radius: 4px;
  padding: 0.5rem;
  margin: 0.2rem;
}
.item.item-blue {
  background-color: #B9E5FE;
  color: #00A5FA;
}
.item.item-green {
  background-color: #B7E0DC;
  color: #019888;
}
.item.item-lime {
  background-color: #C7E8C8;
  color: #42B045;
}
.item.item-yellow {
  background-color: #FFEEBA;
  color: #FF9901;
}
.item.item-pink {
  background-color: #FABAD0;
  color: #EF075F;
}
.item.item-red {
  background-color: #FEC9C6;
  color: #FD3D08;
}
.item.item-big-width {
  min-width: 380px;
}
/*modal end*/
</style>
<? $role_permissions  = explode(",",$this->session->userdata('permissions')); ?>
<div class="container-fluid">
    <div class="row">
    <div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right" style="margin-bottom:2%;">
				<div class="float-right">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Others/add_partner" type="button" class="btn btn-outline-primary "><i class="fas fa-comments"></i>&nbsp;New Complaint</a>
                  <a href="<?= base_url();?>Complaints/my_complaints" type="button" class="btn btn-outline-primary"><i class="fa fa-paper-plane" aria-hidden="true"></i>&nbsp;My Complaints</a>
                  <a href="<?= base_url();?>Complaints/assigned_complaints" type="button" class="btn btn-primary btn-large"><i class='fas fa-box-open'></i>&nbsp;Assigned Complaints</a>
                  <a href="<?= base_url();?>" type="button" class="btn btn-outline-primary"><i class="fas fa-tachometer-alt"></i>&nbsp;Dashboard</a>
                </div>
			</div>
			</div>
			<!--<h4 class="page-title">Assigned Complaints</h4>-->
			
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
										<button type="button" id="currentday" class="btn btn-success waves-effect waves-light" onclick="showassignRecord('showall');" style="box-shadow: 0 7px 14px 0 rgb(45 218 181 / 50%);" name="show-current-day" value=""><i class="fa fa-line-chart" aria-hidden="true"></i>&nbsp;Show All</button>
										<button type="button" id="currentweek" class="btn btn-purple waves-effect waves-light" onclick="showassignRecord('resolved');" style="box-shadow: 0 7px 14px 0 rgb(109 129 245 / 50%);" name="show-current-week" value=""><i class="fa fa-line-chart" aria-hidden="true"></i>&nbsp;Resolved Only</button>
										<button type="button" id="currentmonth" class="btn btn-secondary waves-effect waves-light" onclick="showassignRecord('pending');" style="box-shadow: 0 7px 14px 0 rgb(65 203 216 / 50%) !important;" name="show-current-month" value=""><i class="fa fa-bar-chart" aria-hidden="true"></i>&nbsp;Pending Only</button>
										<button type="button" id="currentyear" class="btn btn-info waves-effect waves-light" onclick="showassignRecord('notresolved');" style="box-shadow: 0 7px 14px 0 rgb(155 167 202 / 50%);" name="show-current-year" value=""><i class="fa fa-line-chart" aria-hidden="true"></i>&nbsp;Not Resolved</button>
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
                                            <th>Complainer Name</th>
                                            <!--<th>Date</th>-->
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
                                            <td><?= $comp['fld_username'];?></td>
                                            <!--<td><?//= date('d-m-Y',strtotime($comp['fld_created_date']));?></td>-->
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
											
											<a href="<?= base_url('Complaints/view_asigned_complaint/'.$comp['fld_id'].'')?>">
											<i style="font-size:20px;cursor:pointer;" class="mdi mdi-eye-circle-outline" title="View"></i></a>
											<a type="button" onclick="viewInfo('<?= $comp['fld_username'];?>','<?= $comp['fld_email'];?>','<?= $comp['fld_mobile_number'];?>','<?= $comp['role_name'];?>')" class="complainerInfo" ><i class="mdi mdi-account-circle-outline" style="font-size:20px;cursor:pointer;"></i></a>
											<a type="button" class="resolveCompl" data-id="<?= $comp['fld_id'];?>" ><i class="mdi mdi-shield-check-outline" style="font-size:20px;cursor:pointer;"></i></a>
											
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
<div class="modal fade" id="status" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header border-bottom-0">
        <h5 class="modal-title" id="exampleModalLabel">Complainer Info</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="resolvecomplaintform">
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="">Update Status</label>
                        <select class="select2 form-control mb-3 custom-select expense_type" id="expense_type_1" name="status">
                          <option value="">--Select--</option>
                          <option value="1">Resolved</option>
                          <option value="2">Not resolved</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-12">
					<div class="form-group ">
						<label for="supplier_sss" class=" col-form-label">Comments <i class="text-danger"></i></label>
						<textarea  class="form-control" <?//= ($complaint['fld_status'] == 1)?"readonly":"";?> rows="5" name="reply" id="reply"   tabindex="3" ><?//= $complaint['fld_reply']?></textarea>
							
					</div> 
				</div>
                
            </div>
        </div>
		<input type="hidden" name="edit_id" id="edit_id" value="" />
        <div class="modal-footer border-top-0 d-flex justify-content-right">
            <button type="submit" class="btn btn-successs">Proceed</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="viewInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header border-bottom-0">
        <h5 class="modal-title" id="exampleModalLabel">Complainer Info</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">Complainer Name</label>
                        <input type="text" class="form-control" id="complainer_name"  name="complainer_name" tabindex="1" placeholder="John Doe" disabled>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">Designation</label>
                        <input type="text" class="form-control"  name="role" tabindex="1" placeholder="Manager" id="designation" disabled >
                    </div>
                    </div>
                    <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">Phone Number</label>
                        <input type="text" class="form-control" name="mobile" tabindex="1" placeholder="+923131234567" id="phone_number" disabled >
                    </div>
                    </div>
                    <div class="col-sm-6">
                        <label for="">Email</label>
                        <input type="text" class="form-control"  name="email" tabindex="1" placeholder="abc@mail.com" id="email" disabled >
                    </div>
            </div>
        </div>
        <div class="modal-footer border-top-0 d-flex justify-content-right">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>
                