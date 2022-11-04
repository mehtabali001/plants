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
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right" style="margin-bottom:15px;">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Customers" type="button" class="btn btn-outline-primary"><i class="fa fa-shopping-cart"></i>&nbsp;New Customer</a>
                  <a href="<?= base_url();?>Customers/manage_Customers" type="button" class="btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;View Customers</a>
                  <!--<a href="<?//= base_url();?>Customers/customer_ledger" type="button" class="btn btn-outline-primary"><i class="fa fa-vcard"></i>&nbsp;Customer Ledger</a>-->
                  <a href="<?= base_url();?>Customers/manage_CustomersList" type="button" class="btn btn-primary btn-large"><i class="fa fa-vcard"></i>&nbsp;Customer List</a>
                  <a href="<?= base_url();?>Sales/salesReport" type="button" class="btn btn-outline-primary"><i class="fa fa-bar-chart"></i>&nbsp;Sales Report</a>
                </div>
			</div>
			<!--<h4 class="page-title">Customers List</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Customers</a></li>-->
			<!--	<li class="breadcrumb-item active">List</li>-->
			<!--</ol>-->
		</div>
	</div>
</div>
<!-- end page title end breadcrumb -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
				<div class="col-lg-12">
					<?php 
    					$error_message = $this->session->userdata('error_message');
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
							<?php echo $success_message; ?>                    
						</div>
					<?php
						$this->session->unset_userdata('success_message');
					} ?>
				</div>
				
<div class="panel-body" style="width:100%;padding: 0px 13px;">
<form id="customerLedgerfilter" action="" method="post">
        <!--<input type="hidden" name="filter_type" id="filter_type" value="1" />-->
		<!--<div class="col-sm-12">-->
		<!--<h4 class="form-section"><i class="icon-eye6"></i>Navigation Report</h4>-->
		<!--<br>-->
		<!--</div>-->
		<!--<hr>-->
        <div class="row">
			<div class="col-sm-3">
				<div class="form-group input-group">      
					<div class="input-group-append">
						<span class="input-group-text" style="background-color: #506ee4;border: 1px solid #506ee4;color:#FFF;">From</span>
					</div>                                     
					<input type="text" class="form-control datepicker" name="from_date" id="from_date" value="<?= date('d-m-Y',strtotime('-30 days'))?>">	
				</div>   
            </div>
			<div class="col-sm-3">
				<div class="form-group input-group">      
					<div class="input-group-append">
						<span class="input-group-text" style="background-color: #506ee4;border: 1px solid #506ee4;color:#FFF;">To</span>
					</div>                                     
					<input type="text" class="form-control datepicker" name="to_date" id="to_date" value="">	
				</div>   
            </div>
    <!--        <div class="col-sm-3">-->
				<!--<div class="form-group ">-->
    <!--                <select class="select2 form-control mb-3 custom-select" name="saletype"  required tabindex="10">-->
    <!--                    <option value="">--Select type--</option>-->
    <!--                    <option value="1">Recent Sale</option>-->
    <!--                    <option value="2" selected>No Recent Sale</option>-->
    <!--                </select>-->
    <!--            </div>   -->
    <!--        </div>-->
     <!--       <div class="col-sm-3">-->
				 <!--<div class="form-group ">-->
     <!--                   <select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="fld_location"  id="fld_location" >-->
     <!--                           <option value="" selected>Select Location</option>-->
								 <?php
								// if($locations){
								// foreach($locations as $loc){
								    // if($loc['fld_id']!=4){
								?>
								<!--<option value="<?//= $loc['fld_id'];?>" ><?//= $loc['fld_location'];?></option>-->
								<?//php// }}}?>
            <!--            </select>-->
            <!--    </div>   -->
            <!--</div>-->
            
            <div class="col-sm-1" style="padding: 0;">
				<button type="submit" class="btn btn-successs btn-large" name="submit">Proceed</button>
			</div>
			<!--<div class="col-sm-3">-->
		 <!--   	<button type="button" style="margin: 0px 10px;" id="pdf_customer_report" class="btn btn-gradient-pink pdf_customer_report" name="" value="" <?//= (empty($customer))?'disabled':'';?>><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;Download PDF F7</button>-->
   <!--         </div>-->
        </div>
    </form>
</div>	
<hr>
<br>

<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right" style="margin-bottom: 15px;">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                <? //if(!empty($role_permissions) && in_array(120,$role_permissions)) { ?>
                <a type="button" id="print_report" class="btn btn-outline-primary print_report" style=""><i class="fa fa-print" aria-hidden="true"></i>&nbsp;Print F6</a>
                <? //} ?>
                <? //if(!empty($role_permissions) && in_array(121,$role_permissions)) { ?>
                <a type="button" id="pdf_customer_report" class="btn btn-outline-primary pdf_customer_report" name="" value="" onclick="downloadpdf();" ><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;PDF F7</a>
                <? //} ?>
                <? //if(!empty($role_permissions) && in_array(220,$role_permissions)) { ?>
                <a type="button" id="sale_report_csv" class="btn btn-outline-primary pdf_purchase_report" onclick="downloadcsv();" style="" name="" value=""><i class="fas fa-file-csv"></i>&nbsp; CSV</a>
                <? //} ?>
                </div>
			</div>
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>	

<table id="datatable_tb" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead class="tabletop">
    <tr>
        <th>Customer Code</th>
        <th>Customer Name</th>
        <!--<th>Company Name</th>-->
        <th>Last plant(Sale)</th>
        <th>Mobile</th>
        <th>Last Sale Date</th>
        <th>Last Sale Amount</th>
        <!--<th>Action</th>-->
    </tr>
    </thead>
    <tbody id="customerRows" class="customerRows">
	<?php 
	    if($customer){
		foreach($customer as $cust){
		    $saledate=$this->db->select("*")->from("tbl_sale")->where('fld_customer_id' , $cust['fld_id'] )->order_by('fld_sale_date', 'desc')->get()->row_array();
		    //echo '<pre>';
		    //print_r( $saledate);exit;
		    $location=$this->db->select("*")->from("tbl_locations")->where('fld_id' , $saledate['fld_location_id'] )->get()->row_array();
		    if($this->input->post()){
		        $start=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('from_date'))));
		        $end=date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('to_date'))));
		        
		        if((strtotime($saledate['fld_sale_date']) >=  strtotime($start)) && (strtotime($saledate['fld_sale_date']) <=  strtotime($end))){
		            $show = true;
		        }else{
		            $show = false;
		        }
		    }else{
		        $show = true;
		    }
		    if($show){
	?>
    <tr>
        <td><?= $cust['fld_customer_code'];?></td>
        <td><?= $cust['fld_customer_name'];?></td>
       <!-- <td><?= $cust['fld_company_name'];?></td>-->
        <td><?= $location['fld_location'];?></td>
        <td><?= $cust['fld_mobile_num'];?></td>
        <td><?= date("d-m-Y",strtotime($saledate['fld_sale_date']));	?>
		</td>
		<td><?= number_format($saledate['fld_grand_total_amount'],2)	?>
		</td>
        <?php /*?><td>
		<? if(!empty($role_permissions) && in_array(64,$role_permissions)) { ?>
		<a href="<?= base_url('Customers/edit/'.$cust['fld_id'].'')?>">
		<i style="font-size:20px;cursor:pointer;" class="mdi mdi-square-edit-outline" title="Edit"></i></a>
		<? } ?>
		
		<? if(!empty($role_permissions) && in_array(65,$role_permissions)) { ?>
		<a href="<?= base_url('Customers/viewCustomer/'.$cust['fld_id'].'')?>"><i style="font-size:20px;cursor:pointer;" class="mdi mdi-eye-circle-outline" title="View"></i></a>
		<? } ?>
		
		<? if(!empty($role_permissions) && in_array(66,$role_permissions)) { ?>
		<a href="<?= base_url('Customers/delete/'.$cust['fld_id'].'')?>" onclick="return confirm('Are you sure you want to delete this record.')">
		<i style="font-size:20px;cursor:pointer;" class="mdi mdi-delete-forever" title="Delete"></i>
		</a>
		<? } ?>
		</td><?php */?>
    </tr>
	<?php } } } ?>
    </tbody>
</table>

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
</div>
<script>
     function downloadpdf(){
        //  var form = $('#ledgerFilter').serialize();
        var formdata=$('#customerLedgerfilter').serialize();
       var url="<?php echo base_url(); ?>Customers/print_customers_report?"+formdata;
       window.open(url);
   }
   function downloadcsv(){
        //  var form = $('#ledgerFilter').serialize();
        var formdata=$('#customerLedgerfilter').serialize();
       var url="<?php echo base_url(); ?>Customers/customers_report_csv?"+formdata;
       window.open(url);
   }
</script>
                