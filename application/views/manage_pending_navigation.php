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
.btn-success, .btn-info, .btn-primary, .btn-warning,.btn-danger,.btn-gradient-primary,.btn-gradient-danger{
	box-shadow: 0 0 black;
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
                  <a href="<?= base_url();?>Navigations" type="button" class="btn btn-primary btn-large"><i class='fas fa-route'></i>&nbsp;Intransit Navigations</a>
                  <a href="<?= base_url();?>Navigations/manage" type="button" class="btn btn-outline-primary"><i class='fa fa-eye'></i>&nbsp;View Navigations</a>
                  <a href="<?= base_url();?>Navigations/createIntNav" type="button" class="btn btn-outline-primary"><i class='fas fa-rocket'></i>&nbsp;New Navigation</a>
                   <a href="<?= base_url();?>Navigations/navigationReport" type="button" class="btn btn-outline-primary"><i class='fa fa-bar-chart'></i>&nbsp;Navigation Report</a>
                </div>
			</div>
			<!--<h4 class="page-title">Intransit Navigations</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Navigations</a></li>-->
			<!--	<li class="breadcrumb-item active">Intransit Navigations</li>-->
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
            <th>Bill Date</th>
            <th>Item</th>
            <th>Bill ID</th>
            <th>Supplier Name</th>
            <th>Shipment</th>
            <th>Total Amount(PKR)</th>
            <th>Action</th>
        </tr>
        </thead>


        <tbody>
            
			<?php 
			if($intransit_purch){
			foreach($intransit_purch as $intra){
			?>
			<tr>
			    <td>
				<?php echo date("d-m-Y",strtotime(@$intra['fld_created_date']));?>
				</td>
				<td>
				<?php 
				//  $getweight = $this->db->query("SELECT SUM(fld_weight) as totalweight FROM tbl_sale_detail WHERE fld_sale_id = '".$sale['fld_id']."'")->row();
					  $products = $this->db->query("select * from tbl_purchase_detail where fld_purchase_id = '".@$intra['fld_purchase_id']."'")->result_array();
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
				<?php echo 'PV-'.sprintf('%04d', $intra['fld_purchase_id']);?>
				</td>
				<td>
				<?php echo explode('/', $intra['fld_shipment'])[0].'/'. explode('/', $intra['fld_shipment'])[1];?>
				</td>
				<td style="font-size:12px;padding:3px;">
				<?php echo @$intra['fld_shipment'];?>
				</td>
				
				<td>
				<?php echo @$intra['fld_grand_total_amount'];?>
				</td>
				<td>
				    
				<? if(!empty($role_permissions) && in_array(13,$role_permissions)) { ?>
				<a href="<?= base_url('Navigations/create_navigation/'.$intra['fld_purchase_id'].'/'.$intra['fld_id'].'');?>">
				<i style="font-size:20px;cursor:pointer;" class="mdi mdi-square-edit-outline" title="Edit"></i></a>
				<? } ?>
			</td>
				
			</tr>
			<?php //}}?>
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
        <h5 class="modal-title mt-0" id="exampleModalLabel">Navigation</h5>
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
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="Submit" class="btn btn-primary">Proceed to Delete</button>
        
    </div>
    </form>
    </div>
</div>
</div>
</div>
</div> <!-- end col -->
</div> <!-- end row -->
</div>

                