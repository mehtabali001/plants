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
                  <a href="<?= base_url();?>Sales/manage_sales" type="button" class="btn btn-primary btn-large"><i class="fa fa-eye"></i>&nbsp;View Sales</a>
                  <a href="<?= base_url();?>Sales/manage_drafts" type="button" class="btn btn-outline-primary"><i class="fa fa-files-o"></i>&nbsp;Drafts</a>
                  <a href="<?= base_url();?>Sales/salesReport" type="button" class="btn btn-outline-primary"><i class="fa fa-bar-chart"></i>&nbsp;Sales Report</a>
                </div>
			</div>
			<!--<h4 class="page-title">View Sale Invoices</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--<li class="breadcrumb-item"><a href="javascript:void(0);">Sales</a></li>-->
			<!--<li class="breadcrumb-item active">View Sale Invoices</li>-->
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
    <th>#</th>
    <th>Invoice ID</th>
    <th>Invoice Date</th>
    <th>Customer Name</th>
    <th>Location</th>
    <th>Weight(KG)</th>
    <th>Total(PKR)</th>
    <th>Action</th>
</tr>
</thead>

<tbody>

	<?php if($sales){
	    $i=0;
		foreach($sales as $sale){
		    $getweight = $this->db->query("SELECT SUM(fld_weight) as totalweight FROM tbl_sale_detail WHERE fld_sale_id = '".$sale['fld_id']."'")->row();
		    $location =	$this->Common_model->select_single_field('fld_location','tbl_locations',array('fld_id'=>$sale['fld_location_id']));
		    $updateby =	$this->Common_model->select_single_field('fld_username','tbl_users',array('fld_id'=>$sale['fld_updated_by']));
		    $i++;
		?>
	<tr>
	    <td><?php echo $i; ?></td>
	    <td>
		<?php 
		    echo 'SI-'.sprintf('%04d', $sale['fld_id'])."<br>";
		    if($sale['fld_updated_by'] != 0){
				echo '<span style="width: 170px; display: inline-block;color:#506ee4; font-size:10px;">Updated On: '.date("d-m-Y,h:i A",strtotime(@$sale['fld_updated_date'])).'</span>'."<br>";
				echo '<span style="width: 170px; display: inline-block;color:#21d0c0; font-size:10px;">By: '.$updateby.'</span>'."<br>";
			}
		?>
		</td>
		<td>
		<?php //echo date("d-m-Y",strtotime(@$sale['fld_created_date']));?>
		<?php 
		  echo '<span style="width: 100px;display: inline-block; font-size:11px;">'.date("d-m-Y",strtotime(@$sale['fld_sale_date'])).'</span>';
		  //echo '<span style=" font-size:10px;">'.date("H:i",strtotime(@$sale['fld_created_date'])).'</span>';
		?>
		</td>
		<td>
		<?php echo @$sale['fld_customer_name'];?>
		</td>
		<td>
		<?php echo $location;?>
		</td>
		<td>
        <?php echo $getweight->totalweight;?>
		</td>
		<td>
		<?php echo @$sale['fld_grand_total_amount'];?>
		</td>
		<td>
	    <? if(!empty($role_permissions) && in_array(26,$role_permissions)) { ?>
		<a href="#" onclick="window.open('<?= base_url();?>Sales/print_single_sale/<?= $sale['fld_id'];?>', 'Purchase Report', 'width=1210, height=842');">
		<i style="font-size:20px;cursor:pointer;" class="mdi mdi-printer" title="Print"></i></a>
		<? } ?>
		
		<? if(!empty($role_permissions) && in_array(27,$role_permissions)) { ?>
		<a href="#" onclick="window.open('<?= base_url();?>Sales/pdf_single_sale/<?= $sale['fld_id'];?>', 'Purchase Report');">
		<i style="font-size:20px;cursor:pointer;" class="mdi mdi-file-pdf" title="Pdf"></i></a>
		<? } ?>
		
		<? if(!empty($role_permissions) && in_array(23,$role_permissions)) { ?>
		<a href="<?= base_url('Sales/edit/'.$sale['fld_id'].'');?>">
		<i style="font-size:20px;cursor:pointer;" class="mdi mdi-square-edit-outline" title="Edit"></i></a>
		<? } ?>
		
		<? if(!empty($role_permissions) && in_array(24,$role_permissions)) { ?>
		<a href="<?= base_url('Sales/detail/'.$sale['fld_id'].'');?>"><i style="font-size:20px;cursor:pointer;" class="mdi mdi-eye-circle-outline" title="View"></i></a>
		<? } ?>
		
		<? if(!empty($role_permissions) && in_array(25,$role_permissions)) { ?>
		
		<a data-toggle="modal" class="exampleModal" data-target="#exampleModal" data-content="<?php echo $sale['fld_id']; ?>" data-uri="<?= base_url('Sales/delete/'.$sale['fld_id'].'');?>">
		<i style="font-size:20px;cursor:pointer;" class="mdi mdi-delete-forever" title="Delete"></i>
		<!--<a href="<?//= base_url('Sales/delete/'.$sale['fld_id'].'');?>" onclick="return confirm('Are you sure you want to delete this record.')">-->
		<!--<i style="font-size:20px;cursor:pointer;" class="mdi mdi-delete-forever" title="Delete"></i>-->
		</a>
		<? } ?>
	</td>
		
	</tr>
	<?php // }}?>
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
    <form id="modal-form"  action="<?= base_url('Sales/delete');?>" method="post">
    <div class="modal-body">
        <p>Are you sure you want to delete this record.</p>
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

</div> <!-- end col -->
</div> <!-- end row -->
</div>
