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
.card {
    overflow: auto;
    margin-top: 20px;
}
@media only screen and (max-width: 600px) {
.page-title-box{
    display:none;
}
.dataTables_length label{
    width:100%;
}
.dataTables_filter{
   width:100%; 
}
.dataTables_filter label{
   width:100%; 
}
.pagination{
    width: 100%;
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
                  <a href="<?= base_url();?>Purchase/create_order" type="button" class="btn btn-outline-primary"><i class="fa fa-files-o"></i>&nbsp;New Order</a>
                  <a href="<?= base_url();?>Purchase/purchReport" type="button" class="btn btn-outline-primary"><i class="fa fa-bar-chart"></i>&nbsp;Purchase Report</a>
                  <a href="<?= base_url();?>Purchase/manage_trash" type="button" class="btn btn-primary btn-large"><i class="fa fa-trash"></i>&nbsp;Trashed Bills</a>
                </div>
			</div>
			<!--<h4 class="page-title">Trashed Bills</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Others</a></li>-->
			<!--	<li class="breadcrumb-item active"> Trashed Bills</li>-->
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
		}
		?>
		</div>
    <!--<table id="datatable2" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">-->
     <table id="datatable_tb" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead class="tabletop">
        <tr>
            <th>Billing Date</th>
            <!--<th>Voucher Number</th>-->
            <th>Deleted By</th>
            <th>Shipment</th>
            <th>Supplier</th>
            <th>Items</th>
            <th>Total Amount(PKR)</th>
            <th>Action</th>
        </tr>
        </thead>

        <tbody>
			<?php if($purchases){
			    $i=1;
				foreach($purchases as $purch){
				    $trashby =	$this->Common_model->select_single_field('fld_username','tbl_users',array('fld_id'=>$purch['fld_trash_by']));
				?>
			<tr>
				<td>
				<?php echo date("d-m-Y",strtotime(@$purch['fld_purchase_date']));?>
				</td>
				
				<td>
				<?php 
				 //echo 'KG-V-'.sprintf('%04d', $purch['fld_id']);
				 echo $trashby."<br>";
				 echo '<span style="width: 150px; display: inline-block;color:#506ee4; font-size:11px;">Date: '.date("d-m-Y",strtotime(@$purch['fld_trash_date'])).'</span>'."<br>";
				 echo '<span style="width: 150px; display: inline-block;color:#21d0c0; font-size:10px;">Time: '.date("H:i:s A",strtotime(@$purch['fld_trash_date'])).'</span>';
				?>
				</td>
				<td>
				    <?php echo @$purch['fld_shipment'];?>
				</td>
				<td>
				<?php echo @$purch['fld_supplier_name'];?>
				</td>
				<td>
				<?php 
				  //  $getweight = $this->db->query("SELECT SUM(fld_weight) as totalweight FROM tbl_sale_detail WHERE fld_sale_id = '".$sale['fld_id']."'")->row();
				  $products = $this->db->query("select * from tbl_purchase_detail where fld_purchase_id = '".$purch['fld_id']."'")->result_array();
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
				<td>
				<?php echo @$purch['fld_grand_total_amount'];?>
				</td>
				
				<td>
				<?/*?><? if(!empty($role_permissions) && in_array(7,$role_permissions)) { ?>
				    <a href="#" onclick="window.open('<?= base_url();?>purchase/print_single_purchase/<?= $purch['fld_id'];?>', 'Purchase Report', 'width=1210, height=842');">
				<i style="font-size:20px;cursor:pointer;" class="mdi mdi-printer" title="Print"></i></a>
				<? } ?>
				
				<? if(!empty($role_permissions) && in_array(6,$role_permissions)) { ?>
				<a href="#" onclick="window.open('<?= base_url();?>purchase/pdf_single_purchase/<?= $purch['fld_id'];?>', 'Purchase Report');">
				<i style="font-size:20px;cursor:pointer;" class="mdi mdi-file-pdf" title="Pdf"></i></a>
				<? } ?>
				
				<? if(!empty($role_permissions) && in_array(3,$role_permissions)) { ?>
				<a href="<?= base_url('Purchase/edit/'.$purch['fld_id'].'');?>">
				<i style="font-size:20px;cursor:pointer;" class="mdi mdi-square-edit-outline" title="Edit"></i></a>
				<? } ?><?*/?>
				
				<? if(!empty($role_permissions) && in_array(4,$role_permissions)) { ?>
				<a href="<?= base_url('Purchase/detail/'.$purch['fld_id'].'');?>"><i style="font-size:20px;cursor:pointer;" class="mdi mdi-eye-circle-outline" title="View"></i></a>
				<? } ?>
				
				<? if(!empty($role_permissions) && in_array(128,$role_permissions)) { ?>
				<a data-toggle="modal" class="exampleModal" data-target="#exampleModal" data-content="<?php echo $purch['fld_id']; ?>" data-uri="<?= base_url('Purchase/restore/'.$purch['fld_id'].'');?>">
		        <i style="font-size:16px;cursor:pointer;" class="fas fa-trash-restore" title="Restore"></i></a>
				<!--<a href="<?//= base_url('Purchase/restore/'.$purch['fld_id'].'');?>" onclick="return confirm('Are you sure you want to Restore this record.')">-->
				<!--<i style="font-size:16px;cursor:pointer;" class="fas fa-trash-restore" title="Restore"></i>-->
				<!--</a>-->
				<? } ?>
				 
				<? if(!empty($role_permissions) && in_array(129,$role_permissions)) { ?>
				<a data-toggle="modal" class="exampleModal2" data-target="#exampleModal2" data-content="<?php echo $purch['fld_id']; ?>" data-uri="<?= base_url('Purchase/deletepermanent/'.$purch['fld_id'].'');?>">
		        <i style="font-size:20px;cursor:pointer;" class="mdi mdi-delete-forever" title="Delete"></i></a>
				<!--<a href="<?//= base_url('Purchase/deletepermanent/'.$purch['fld_id'].'');?>" onclick="return confirm('Are you sure you want to delete this record.')">-->
				<!-- <i style="font-size:20px;cursor:pointer;" class="mdi mdi-delete-forever" title="Delete Permanent"></i>-->
				<!--</a>-->
				<? } ?>
			</td>
				
			</tr>
			<?php //}}?>
			<?php $i++; }}else{?>
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

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content" style="box-shadow: 0 7px 14px 0 rgb(65 203 216 / 50%) !important;">
    <div class="modal-header">
        <h5 class="modal-title mt-0" id="exampleModalLabel">Purchase Bill</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form id="modal-form" method="post">
    <div class="modal-body">
        <p>Are you sure you want to Restore this record.</p>
    </div>
    <div class="modal-footer">
        <input type="hidden" id="purchase_id" name="purchase_id" />
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
        <h5 class="modal-title mt-0" id="exampleModalLabel">Purchase Bill</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form id="modal-formdelete" method="post">
    <div class="modal-body">
        <p>Are you sure you want to Delete this record.</p>
    </div>
    <div class="modal-footer">
        <input type="hidden" id="purchase_id" name="purchase_id" />
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

                