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
.sorting_1 p{
    text-align:center;
}
.dataTables_filter {
    float: right;
}
.table td {
    vertical-align: middle;
    font-size: 12px;
}
.card {
    overflow: auto;
    margin-top: 20px;
    /*6c85e5*/
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
			<div class="float-right">
			    <div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Purchase" type="button" class="btn btn-outline-primary"><i class="fa fa-shopping-cart"></i>&nbsp;New Purchase Bill</a>
                  <a href="<?= base_url();?>Purchase/manage_purchase" type="button" class="btn btn-primary btn-large"><i class="fa fa-eye"></i>&nbsp;View Bills</a>
                  <a href="<?= base_url();?>Purchase/manage_drafts" type="button" class="btn btn-outline-primary"><i class="fa fa-files-o"></i>&nbsp;Drafts</a>
                  <a href="<?= base_url();?>Purchase/manage_trash" type="button" class="btn btn-outline-primary"><i class="fa fa-trash"></i>&nbsp;Trashed Bills</a>
                </div>
			</div>
			<!--<h4 class="page-title">View Purchase Bills</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Purchase</a></li>-->
			<!--	<li class="breadcrumb-item active">View Purchase Bills</li>-->
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
					}?>
					</div>
                <table id="datatable_tb" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead class="tabletop">
                    <tr>
                        <th>#</th>
                        <th style="width:8%;">Bill ID</th>
                        <th>Billing Date</th>
                        <th>Shipment</th>
                        <th style="width:10%;">Supplier</th>
                        <th>Items</th>
                        <th>Total Amount(PKR)</th>
                        <th style="width:15%;">Action</th>
                    </tr>
                    </thead>

                    <tbody>
						<?php if($purchases){
						    $i=0;
							foreach($purchases as $purch){
							   $updateby =	$this->Common_model->select_single_field('fld_username','tbl_users',array('fld_id'=>$purch['fld_updated_by'])); 
							   $i++;
						?>
						<tr>
						    <td><?php echo $i; ?></td>
						    <td><?php echo @$purch['fld_voucher_no'];?></td>
							<td>
							    <?php 
							    //echo date("d-m-Y",strtotime(@$purch['fld_purchase_date']));
								echo '<span style="width: 110px; display: inline-block;">'.date("d-m-Y",strtotime(@$purch['fld_purchase_date'])).'</span>';
                                //echo '<span style="width: 100px; display: inline-block;color:#21d0c0; font-size:10px;">Time: '.date("H:i:s",strtotime(@$purch['fld_created_date'])).'</span>';
								?>
							</td>
							<td  style="font-size: 12px;">
							<?php 
							echo @$purch['fld_shipment']."<br>";
							if($purch['fld_updated_by'] != 0){
							echo '<span style="width: 170px; display: inline-block;color:#506ee4; font-size:10px;">Updated On: '.date("d-m-Y,h:i A",strtotime(@$purch['fld_updated_date'])).'</span>'."<br>";
							echo '<span style="width: 170px; display: inline-block;color:#21d0c0; font-size:10px;">By: '.$updateby.'</span>';
							}
							?></td>
							<td><?php echo explode('/', $purch['fld_shipment'])[0].'/'. explode('/', $purch['fld_shipment'])[1];?></td>
							<td  style="font-size: 12px;">
							<?php 
							  //  $getweight = $this->db->query("SELECT SUM(fld_weight) as totalweight FROM tbl_sale_detail WHERE fld_sale_id = '".$sale['fld_id']."'")->row();
							  $products = $this->db->query("select * from tbl_purchase_detail where fld_purchase_id = '".$purch['fld_id']."'")->result_array();
							  $produ='';
							  foreach($products as $prod){
							      $catname =	$this->Common_model->select_single_field('fld_category','tbl_category',array('fld_id'=>$prod['fld_product_id'])); 
							      //echo $prod['fld_product_id'].',';
							      if($catname == 'LPG'){
							       echo $catname .','.'<br>';
							      }else{
							      $subcatname =	$this->Common_model->select_single_field('fld_subcategory','tbl_subcategory',array('fld_subcid'=>$prod['fld_subproduct_id'])); 
							      $produ .= $subcatname .','.'<br>';
							      }
							  }
							  if (strlen($produ) >  40){
							  echo substr($produ, 0, 40).'...';
							  }
							  else{
							      echo $produ;
							  }
							?>
							</td>
							<td><?php echo @$purch['fld_grand_total_amount'];?></td>
							<td>
							<? if(!empty($role_permissions) && in_array(7,$role_permissions)) { ?>
							    <a href="#" onclick="window.open('<?= base_url();?>purchase/print_single_purchase/<?= $purch['fld_id'];?>', 'Purchase Report', 'width=1210, height=842');">
							<i style="font-size:15px;cursor:pointer;" class="mdi mdi-printer" title="Print"></i></a>
							<? } ?>
							
							<? if(!empty($role_permissions) && in_array(6,$role_permissions)) { ?>
							<a href="#" onclick="window.open('<?= base_url();?>purchase/pdf_single_purchase/<?= $purch['fld_id'];?>', 'Purchase Report');">
							<i style="font-size:15px;cursor:pointer;" class="mdi mdi-file-pdf" title="Pdf"></i></a>
							<? } ?>
							
							<? if(!empty($role_permissions) && in_array(3,$role_permissions)) { ?>
							<a href="<?= base_url('Purchase/edit/'.$purch['fld_id'].'');?>">
							<i style="font-size:15px;cursor:pointer;" class="mdi mdi-square-edit-outline" title="Edit"></i></a>
							<? } ?>
							
							<? if(!empty($role_permissions) && in_array(4,$role_permissions)) { ?>
							<a href="<?= base_url('Purchase/detail/'.$purch['fld_id'].'');?>"><i style="font-size:15px;cursor:pointer;" class="mdi mdi-eye-circle-outline" title="View"></i></a>
							<? } ?>
							
							<? if(!empty($role_permissions) && in_array(5,$role_permissions)) { ?>
							<a data-toggle="modal" class="exampleModal" data-target="#exampleModal" data-content="<?php echo $purch['fld_id']; ?>" data-uri="<?= base_url('Purchase/delete/'.$purch['fld_id'].'?code='. $purch['fld_shipment']);?>">
		<i style="font-size:20px;cursor:pointer;" class="mdi mdi-delete-forever" title="Delete"></i></a>
							<!--<a href="<?//= base_url('Purchase/delete/'.$purch['fld_id'].'?code='. $purch['fld_shipment']);?>" onclick="return confirm('Are you sure you want to delete this record.')">-->
							<!--<i style="font-size:15px;cursor:pointer;" class="mdi mdi-delete-forever" title="Delete"></i></a>-->
							<? } ?>
						</td>
						</tr>
						<?php }}else{?>
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
        <h5 class="modal-title mt-0" id="exampleModalLabel">Purchase Bill</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form id="modal-form" method="post">
    <div class="modal-body">
        <p>Are you sure you want to delete this record.</p>
    </div>
    <div class="modal-footer">
        
        <input type="hidden" id="purchase_id" name="purchase_id" />
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