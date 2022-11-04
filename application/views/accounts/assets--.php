<?/*?><style>
a:hover{
    color:grey;
}
    .button {
  background-color: #d1b52d;
  border-radius: 4px;
  color: #fff;
  font-size: 14px;
  min-width: 100px;
  opacity: 0.75;
  padding: 10px 20px;
  text-transform: uppercase;
  transition: box-shadow 0.3s, opacity 0.3s ease-in-out;
}
.button.video-count {
  position: absolute;
  right: 20px;
  top: 20px;
  z-index: 1;
}
.category-card a{
    color:#000;
}
.category-card {
    background-color: #ffffff;
    background-repeat: no-repeat;
    background-size: cover;
    border-radius: 2rem;
    display: flex;
    flex-direction: column;
    height: 175px;
    padding: 20px;
    position: relative;

    margin: 10px;
    box-shadow: 0px 2px 4px rgb(31 30 47 / 10%);
}
.category-card::after {
  border-radius: 2rem;
  content: "";
  height: 100%;
  left: 0;
  opacity: 0.75;
  position: absolute;
  top: 0;
  transition: opacity 0.2s ease-in-out;
  width: 100%;
  z-index: 0;
  box-shadow: 0px 2px 4px rgb(31 30 47 / 10%);
}
.category-card:hover {
  background:#506ee4;
  box-shadow: 0px 2px 4px rgb(31 30 47 / 10%);
}
.category-card:hover a{
  color:#fff;
}
.category-card:hover .heead{
  color:#fff !important;
}
.category-card:hover::after {
  opacity: 0.95;
}
.category-card:hover .content ul {
  max-height: 75px;
}

.category-card .card-link {
  border-radius: 4px;
  height: 100%;
  left: 0;
  position: absolute;
  text-indent: -9999em;
  top: 0;
  width: 100%;
  z-index: 2;
}
.category-card .content {
  margin-top: 22px;
  z-index: 1;
}
.category-card .content h2 {
  color: #fff;
  font-size: 26px;
  margin-bottom: 0;
  color:#10163a;
}
.heead{
  color: #10163a !important;
  font-size: 23px;
  margin-bottom: 0;
  font-weight:800;
}
.category-card .content ul {
  color: #fff;
  font-size: 11px;
  padding-left: 15px !important;
  line-height: 24px;
  margin: 0;
      height: 70px;
  overflow: hidden;

}
.category-card .video-icon {

  opacity: 1;
  transition: opacity 0.2s ease-in-out;
  z-index: 1;
}
.video-icon .fa{
    color:#1ad1bc;
}
.video-icon .fas{
    color:#1ad1bc;
}
.no-js #loader { display: none;  }
.js #loader { display: block; position: absolute; left: 100px; top: 0; }
.se-pre-con {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background: url(<?=base_url();?>assets/uploads/ajax_loading.gif) center no-repeat;
}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="category-card">
                <div class="video-icon">
                <i class="fa fa-users" style="font-size:28px;">&nbsp;<span class="heead">Current Assets</span></i>
                </div>
                <div class="content">
                    <ul>
                    <li><a href="<?= base_url('Accounts/addCurrentAssets');?>">Add Current Assets</a></li>
                    <li><a href="<?= base_url('Accounts/manage_currentAccounts');?>">Manage Current Assets</a></li>
                    </ul>
                </div>
             </div>
        </div>
        <div class="col-md-4">
            <div class="category-card">
                <div class="video-icon">
                <i class="fa fa-users" style="font-size:28px;">&nbsp;<span class="heead">Non Current Assets</span></i>
                </div>
                <div class="content">
            
                    <ul>
                        <li><a href="<?= base_url('Accounts/addNonCurrentAssets');?>">Add Non Current Assets</a></li>
                    <li><a href="<?= base_url('Accounts/manage_noncurrentAccounts');?>">Manage Non Current Assets</a></li>
                    </ul>
                </div>
             </div>
        </div>
    </div>
</div><?*/?>

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
.select2-dropdown {
    background-color: #212744;
    border: 1px solid #575252;
	border-bottom: 1px solid #2a2f4e;
}
.select2-container--default .select2-results__option[aria-selected=true] {
    background-color: #5897FB;
}
.select2-container--default .select2-selection--single {
    background-color: #212744;
    border: 1px solid #575252;
    border-radius: 4px;
	height: 36px;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #bac1dc;
    line-height: 28px;
    padding-top: 2px;
}
</style>
<? $role_permissions  = explode(",",$this->session->userdata('permissions')); ?>
<div class="container-fluid">
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<!--<div class="float-right">-->
			<!--	<div class="btn-group" role="group" aria-label="Basic outlined example">-->
   <!--               <a href="<?= base_url();?>Expenses" type="button" class="btn btn-outline-primary"><i class="fa fa-shopping-cart"></i>&nbsp;Add Expense</a>-->
   <!--               <a href="<?= base_url();?>Expenses/manage_Expenses" type="button" class="btn btn-primary btn-large"><i class="fa fa-vcard"></i>&nbsp;Manage Expenses</a>-->
   <!--             </div>-->
			<!--</div>-->
			<h4 class="page-title">Current Assets</h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="javascript:void(0);">Current Assets</a></li>
				<li class="breadcrumb-item active">Current Assets</li>
			</ol>
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
						<?php 
						  $success_message = $this->session->userdata('success_message');
						  if (isset($success_message)) {
						?>
							<div class="alert alert-success">
								<?php echo $success_message ?>                    
							</div>
						<?php
							$this->session->unset_userdata('success_message');
						}
						?>
						
		<form action="<?= base_url('Accounts/addCurrentAssetsprocess');?>" method="post">
		<div class="row">
		<div class="col-md-3">
			<div class="mt-3">
				<label class="mb-2">Name <i class="text-danger">*</i></label>
				<input type="text" class="form-control" name="ca_name" id="ca_name" required placeholder="e.g Current assets">
			</div>
		</div>
		<div class="col-md-3">
			<div class="mt-3">
				<label class="mb-2">Amount(PKR)</label>
				<input type="number" class="form-control" name="ca_price" id="ca_price" placeholder="e.g Current assets">
			</div>
		</div>
		<!--<div class="col-md-3">-->
		<!--	<div class="mt-3">-->
		<!--		<label class="mb-2">Description</label>-->
		<!--		<input type="text" class="form-control" name="ca_description" id="ca_description" required placeholder="Enter Your Remarks.....">-->
		<!--	</div>-->
		<!-- </div>-->
		 <div class="col-md-3" style="margin-top:25px;">
				<div class="mt-3">
					<label class="mb-2">&nbsp;</label>
					<button type="submit" class="btn btn-gradient-primary">Add</button>
				</div>
			</div>
		 </div>
        </div>
		<br>
		</form>
    <hr>
        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
            <thead>
            <tr>
                <th>Sr#</th>
                <th>Date</th>
                <th>Name</th>
                <th>Amount(PKR)</th>
                <!--<th>Description</th>-->
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
			<?php if($currentAssets){
			    $i = 1;
				foreach($currentAssets as $ca){
				    //$name =	$this->Common_model->select_single_field('ca_name','tbl_currentAssets',array('id'=>$ca['cs_parentid']));
				?>
            <tr>
                <td><?=$i++;?></td>
                <td><?= date('d-M-Y',strtotime($ca['ca_date']));?></td>
                <td><?=$ca['ca_name'];?></td>
                <td><?=$ca['ca_price'];?></td>
                <!--<td><?//=$ca['ca_description'];?></td>-->
                <td>
				<? //if(!empty($role_permissions) && in_array(55,$role_permissions)) { ?>
				<a href="<?= base_url('Accounts/editcurrentAssets/'.$ca['id'].'')?>">
				<i style="font-size:20px;cursor:pointer;" class="mdi mdi-square-edit-outline" title="Edit"></i></a>
				<? //} ?>
				<? //if(!empty($role_permissions) && in_array(56,$role_permissions)) { ?>
				<a href="<?= base_url('Accounts/deletecurrentAssets/'.$ca['id'].'')?>" onclick="return confirm('Are you sure you want to delete this record.')">
				<i style="font-size:20px;cursor:pointer;" class="mdi mdi-delete-forever" title="Delete"></i>
				</a>
				<a href="<?= base_url('Accounts/add_subCurrentAssetsLevels/'.$ca['id'].'')?>">
				<i style="font-size:20px;cursor:pointer;" class="fa fa-list" title="Add Sub Level"></i>
				</a>
				<? //} ?>
				</td>
            </tr>
			<?php }}else{ ?>
			<tr>
                <td colspan='7' style="color:red;text-align:center;">Sorry No Record Found!</td>
            </tr>
            <? } ?>
            </tbody>
        </table>
            </div>
        </div>
    </div>
</div> <!-- end col -->
</div> <!-- end row -->
</div>