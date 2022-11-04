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

.sorting_1 p{
    text-align:center;
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
#datatable_tb_wrapper .row{
    display: block;
}
#datatable_tb_paginate {
    float: right;
    width: 100%;
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
                  <a href="<?= base_url();?>Sales" type="button" class="btn btn-outline-primary"><i class="fa fa-shopping-cart"></i>&nbsp;New Sale</a>
                  <a href="<?= base_url();?>Sales/manage_sales" type="button" class="btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;View Sales</a>
                  <a href="<?= base_url();?>Sales/manage_drafts" type="button" class="btn btn-primary btn-large"><i class="fa fa-vcard"></i>&nbsp;Drafts</a>
                  <a href="<?= base_url();?>Sales/salesReport" type="button" class="btn btn-outline-primary"><i class="fa fa-bar-chart"></i>&nbsp;Sales Report</a>
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
										<?php $success_message = $this->session->userdata('success_message');
										    if (isset($success_message)) {
										?>
											<div class="alert alert-success">
												<?php echo $success_message ?>                    
											</div>
										<?php
											$this->session->unset_userdata('success_message');
										}?>
										<div class="row">
										  <?
                                            $user_id=$this->session->userdata('user_id');
                                            $record=$this->db->query("SELECT * FROM `tbl_sale_drafts` WHERE fld_userid='$user_id'")->num_rows();
                                            ?>
                                            <? if($record>0){?>
                                            <a href="<?php echo base_url();?>Sales/cleardrafts" class="btn btn-gradient-danger waves-effect waves-light" style="box-shadow: 0 7px 14px 0 rgb(239 77 86 / 50%);" onclick="return confirm('Are you sure to clear all drafts?')">Clear Drafts</a>
									        <!--<a href="<?php //echo base_url();?>Sales/cleardrafts" onclick="return confirm('Are you sure to clear all drafts?')" style="float: right;color:red;">Clear Drafts</a>-->
									         <?}?>  
										</div>
										
										</div>
										
                                    <table id="datatable_tb" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead class="tabletop">
                                        <tr>
                                            <th>Invoice Date</th>
                                            <th>Invoice ID</th>
                                            <th>Customer</th>
                                            <th>Shipment</th>
                                            <th>Weight(KG)</th>
                                            <th>Total Amount(PKR)</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
    
                                        <tbody>
											<?php 
											   if($sales){
												foreach($sales as $sale){
												    $getweight = $this->db->query("SELECT SUM(fld_weight) as totalweight FROM tbl_sale_detail_drafts WHERE fld_sale_id = '".$sale['fld_id']."'")->row();
											?>
											<tr>
												<td><?php echo date("d-m-Y",strtotime(@$sale['fld_created_date']));?></td>
												<td><?php echo 'SI-'.sprintf('%04d', $sale['fld_id']);?></td>
												<td><?php echo @$sale['fld_customer_name'];?></td>
												<td><?php echo @$sale['fld_shipment'];?></td>
												<td><?php echo $getweight->totalweight;?></td>
												<td><?php echo @$sale['fld_grand_total_amount'];?></td>
												
												<td>
											   
											    <?/*?><? if(!empty($role_permissions) && in_array(26,$role_permissions)) { ?>
												<a href="#" onclick="window.open('<?= base_url();?>purchase/print_single_purchase/<?= $sale['fld_id'];?>', 'Purchase Report', 'width=1210, height=842');">
												<i style="font-size:20px;cursor:pointer;" class="mdi mdi-printer" title="Print"></i></a>
												<? } ?>
												
												<? if(!empty($role_permissions) && in_array(27,$role_permissions)) { ?>
												<a href="#" onclick="window.open('<?= base_url();?>purchase/pdf_single_purchase/<?= $sale['fld_id'];?>', 'Purchase Report');">
												<i style="font-size:20px;cursor:pointer;" class="mdi mdi-file-pdf" title="Pdf"></i></a>
												<? } ?>
												
												<? if(!empty($role_permissions) && in_array(24,$role_permissions)) { ?>
												<a href="<?= base_url('Sales/detail/'.$sale['fld_id'].'');?>"><i style="font-size:20px;cursor:pointer;" class="mdi mdi-eye-circle-outline" title="View"></i></a>
												<? } ?><?*/?>
												
												<? if(!empty($role_permissions) && in_array(140,$role_permissions)) { ?>
												<a href="<?= base_url('Sales/editDraft/'.$sale['fld_id'].'');?>">
												<i style="font-size:20px;cursor:pointer;" class="mdi mdi-square-edit-outline" title="Edit"></i></a>
												<? } ?>
												
												<? if(!empty($role_permissions) && in_array(141,$role_permissions)) { ?>
												<a data-toggle="modal" class="exampleModal" data-target="#exampleModal" data-content="<?php echo $sale['fld_id']; ?>" data-uri="<?= base_url('Sales/deleteDraft/'.$sale['fld_id'].'');?>">
		                    <i style="font-size:16px;cursor:pointer;" class="mdi mdi-delete-forever" title="Delete"></i>
												<!--<a href="<?//= base_url('Sales/deleteDraft/'.$sale['fld_id'].'');?>" onclick="return confirm('Are you sure you want to delete this record.')">-->
												<!--<i style="font-size:20px;cursor:pointer;" class="mdi mdi-delete-forever" title="Delete"></i>-->
												</a>
												<? } ?>
												
											</td>
											</tr>
											<?php // }}?>
											<?php }}else{?>
										        <tr>
										            <td colspan="7" style="color:red;text-align:center;">Sorry No Record Found</td>
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
        <h5 class="modal-title mt-0" id="exampleModalLabel">Sale Invoice</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form id="modal-form" method="post">
    <div class="modal-body">
        <p>Are you sure you want to Delete this draft.</p>
    </div>
    <div class="modal-footer">
        <input type="hidden" id="sale_id" name="sale_id" />
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