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
    <div class="col-sm-12" style="margin-bottom:1%;">
		<div class="page-title-box">
			<div class="float-right">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Common" type="button" class="btn btn-outline-primary"><i class="fas fa-check-circle"></i>&nbsp;New Categories</a>
                  <a href="<?= base_url();?>Common/manage_Category" type="button" class="btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;View Categories</a>
                  <a href="<?= base_url();?>Common/addsubcategory" type="button" class="btn btn-outline-primary"><i class="fa fas fa-chart-pie"></i>&nbsp;New Subcategories</a>
                  <a href="<?= base_url();?>Common/manage_subCategory" type="button" class="btn btn-primary btn-large"><i class="fa fa-eye"></i>&nbsp;View Subcategories</a>
                </div>
			</div>
			<!--<h4 class="page-title">Products</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Products</a></li>-->
			<!--	<li class="breadcrumb-item active">Manage Sub-Categories</li>-->
			<!--</ol>-->
		</div><!--end page-title-box-->
	</div>
</div>
<!-- end page title end breadcrumb -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
								<div class="col-lg-12 text-right" style="margin-bottom:10px;">
							
									<a href="<?= base_url('Common/addsubcategory');?>" class="btn btn-primary">Add Subcategoy</a>
									
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
                                    <table id="datatable_tb" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead class="tabletop">
                                        <tr>
                                            <th>Sub Category Name</th>
                                            <th>Category</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
    
    
                                        <tbody>
										<?php if($subcategories){
											foreach($subcategories as $subcate){
												$category=$this->Base_model->getRow('tbl_category','fld_category','fld_id='.$subcate['fld_cid'].'');
												$updateby =	$this->Common_model->select_single_field('fld_username','tbl_users',array('fld_id'=>$subcate['fld_updated_by']));
											?>
                                        <tr>
                                            <td><?= ucfirst($subcate['fld_subcategory'])."<br>";
                                    		    if($subcate['fld_updated_by'] != 0){
                                    				echo '<span style="width: 170px; display: inline-block;color:#506ee4; font-size:10px;">Updated On: '.date("d-m-Y,h:i A",strtotime(@$subcate['fld_updated_date'])).'</span>'."<br>";
                                    				echo '<span style="width: 170px; display: inline-block;color:#21d0c0; font-size:10px;">By: '.$updateby.'</span>';
                                    		    }?></td>
                                            
                                            <td><?= $category['fld_category'];?></td>
                                            <td>
											<? if(!empty($role_permissions) && in_array(73,$role_permissions)) { ?>
											<a href="<?= base_url('Common/editsubcategory/'.$subcate['fld_subcid'].'')?>">
											<i style="font-size:20px;cursor:pointer;" class="mdi mdi-square-edit-outline" title="Edit"></i></a>
											<? } ?>
											<? if(!empty($role_permissions) && in_array(74,$role_permissions)) { ?>
											<!--<a href="" onclick="return confirm('Are you sure you want to delete this record.')">-->
											<!--<i style="font-size:20px;cursor:pointer;" class="mdi mdi-delete-forever" title="Delete"></i>-->
											<!--</a>-->
											<a data-toggle="modal" class="exampleModal" data-target="#exampleModal" data-content="<?php echo $subcate['fld_subcid']; ?>" data-uri="<?= base_url('Common/deletesubcat/'.$subcate['fld_subcid'].'')?>"><i style="font-size:20px;cursor:pointer;" class="mdi mdi-delete-forever" title="Delete"></i></a>
											<? } ?>
											</td>
                                        </tr>
										<?php }} else {?>
										<td colspan="3" style="text-align:center;color:red;">
										        Sorry no record found
										    </td>
										    <td style="display:none"></td>
										    <td style="display:none"></td>
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
                <h5 class="modal-title mt-0" id="exampleModalLabel">Delete Subcategory</h5>
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

                