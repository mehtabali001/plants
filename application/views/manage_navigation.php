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
                  <a href="<?= base_url();?>Navigations" type="button" class="btn btn-outline-primary"><i class='fas fa-route'></i>&nbsp;Intransit Navigations</a>
                  <a href="<?= base_url();?>Navigations/manage" type="button" class="btn btn-primary btn-large"><i class='fa fa-eye'></i>&nbsp;View Navigations</a>
                  <a href="<?= base_url();?>Navigations/createIntNav" type="button" class="btn btn-outline-primary"><i class='fas fa-rocket'></i>&nbsp;New Navigations</a>
                  <a href="<?= base_url();?>Navigations/navigationReport" type="button" class="btn btn-outline-primary"><i class='fa fa-bar-chart'></i>&nbsp;Navigations Report</a>
                </div>
			</div>
			<!--<h4 class="page-title">View Navigations</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Navigations</a></li>-->
			<!--	<li class="breadcrumb-item active">View Navigation</li>-->
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
                                            <th>Navigation Date</th>
                                            <th>Invoice ID</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Item</th>
                                            <!--<th>Shipment</th>-->
                                            <th>Amount(PKR)</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
											<?php if($navigations){
												$i=1;
												foreach($navigations as $nav){
												$updateby =	$this->Common_model->select_single_field('fld_username','tbl_users',array('fld_id'=>$nav['fld_updated_by']));	
												?>
											<tr>
												
												<td>
												<?php 
												//echo date('d-m-Y',strtotime($nav['fld_created_date']));
												  echo '<span style="width: 110px;display: inline-block;">'.date("d-m-Y,H:i",strtotime($nav['fld_date'])).'</span>';
                                				 // echo '<span style="width: 100px; display: inline-block;color:#21d0c0; font-size:10px;">Time: '.date("H:i:s",strtotime($nav['fld_created_date'])).'</span>';
												?>
												</td>
												<td>
												<?php 
												  echo sprintf(' NI-%04d ', $nav['fld_id'])."<br>";
												  if($nav['fld_updated_by'] != 0){
                        							echo '<span style="width: 150px; display: inline-block;color:#506ee4; font-size:10px;">Edited On: '.date("d-m-Y,H:i",strtotime(@$nav['fld_updated_date'])).'</span>'."<br>";
                        							echo '<span style="width: 150px; display: inline-block;color:#21d0c0; font-size:10px;">By: '.$updateby.'</span>';
                        						  }
												?>
												</td>
												<td>
												<? echo $nav['location_from'];?>
												</td>
												<td>
												<? echo $nav['location_to'];?>
												</td>
												
												<td>
													<?php 
                        							  //  $getweight = $this->db->query("SELECT SUM(fld_weight) as totalweight FROM tbl_sale_detail WHERE fld_sale_id = '".$sale['fld_id']."'")->row();
                        							  $products = $this->db->query("select * from tbl_navigations_details where fld_navigation_id = '".$nav['fld_id']."'")->result_array();
                        							  foreach($products as $prod){
                        							      $catname =	$this->Common_model->select_single_field('fld_category','tbl_category',array('fld_id'=>$prod['fld_product_id'])); 
                        							      if($catname == 'LPG'){
                        							         echo $catname .','.'<br>';
                        							      }else{
                        							      $subcatname =	$this->Common_model->select_single_field('fld_subcategory','tbl_subcategory',array('fld_subcid'=>$prod['fld_subproduct_id'])); 
                        							         echo $subcatname .','.'<br>';
                        							      }
                        							  }
                        							?>
												</td>
												<!--<td style="font-size:12px;padding:3px;">-->
												<!--<?php echo $nav['fld_shipment_from'];?>-->
												
												<!--</td>-->
												<!--<td style="font-size:12px;padding:3px;">-->
												<!--<?php// echo $nav['fld_shipment_to'];?>-->
												<!--</td>-->
												<!--<td>-->
												<!--<?php// echo $nav['fld_remarks'];?>-->
												<!--</td>-->
												
												<!--<td>
												<?php //echo $nav['fld_item_weight'];?>
												</td>-->
											
												<td>
												<?php echo number_format($nav['fld_total_amount'], 2);?>
												</td>
												<td>
												    <? if(!empty($role_permissions) && in_array(151,$role_permissions)) { ?>
                        							    <a href="#" onclick="window.open('<?= base_url();?>Navigations/print_single_navigation/<?= $nav['fld_id'];?>', 'Navigation Report', 'width=1210, height=842');">
                        							<i style="font-size:20px;cursor:pointer;" class="mdi mdi-printer" title="Print"></i></a>
                        							<? } ?>
                        							
                        							<? if(!empty($role_permissions) && in_array(152,$role_permissions)) { ?>
                        							<a href="#" onclick="window.open('<?= base_url();?>Navigations/pdf_single_navigation/<?= $nav['fld_id'];?>', 'Navigation Report');">
                        							<i style="font-size:20px;cursor:pointer;" class="mdi mdi-file-pdf" title="Pdf"></i></a>
                        							<? } ?>
    												<? if(!empty($role_permissions) && in_array(15,$role_permissions)) { ?>
    												<a href="<?= base_url('Navigations/edit/'.$nav['fld_id'].'');?>">
    												<i style="font-size:20px;cursor:pointer;" class="mdi mdi-square-edit-outline" title="Edit"></i></a>
    												<? } ?>
    												<? if(!empty($role_permissions) && in_array(153,$role_permissions)) { ?>
                        							<a href="<?= base_url('Navigations/detail/'.$nav['fld_id'].'');?>"><i style="font-size:20px;cursor:pointer;" class="mdi mdi-eye-circle-outline" title="View"></i></a>
                        							<? } ?>
    												<? if(!empty($role_permissions) && in_array(16,$role_permissions)) { ?>
    												
    												<a data-toggle="modal" class="exampleModal" data-target="#exampleModal" data-content="<?php echo $nav['fld_id']; ?>" data-uri="<?= base_url('Navigations/delete/'.$nav['fld_id']);?>">
		<i style="font-size:20px;cursor:pointer;" class="mdi mdi-delete-forever" title="Delete"></i></a>
    												<!--<a href="<?//= base_url('Navigations/delete/'.$nav['fld_id']);?>" onclick="return confirm('Are you sure you want to delete this record.')">-->
    												<!--<i style="font-size:20px;cursor:pointer;" class="mdi mdi-delete-forever" title="Delete"></i>-->
    												<!--</a>-->
    												<? } ?>
												</td>
												
											</tr>
													
											<?php $i++; }}else{?>
										        <tr>
										            <td colspan="12" style="color:red;text-align:center;">Sorry No Record Found</td>
										            <td style="display:none"></td>
										            <td style="display:none"></td>
										            <td style="display:none"></td>
										            <td style="display:none"></td>
										            <td style="display:none"></td>
										            <td style="display:none"></td>
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
        <h5 class="modal-title mt-0" id="exampleModalLabel">Navigation Invoice</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form id="modal-form" method="post">
    <div class="modal-body">
        <p>Are you sure you want to delete this record.</p>
    </div>
    <div class="modal-footer">
        
        <input type="hidden" id="navigation_id" name="navigation_id" />
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