<div class="container-fluid">
<div class="row">
	 <div class="col-sm-12" style="margin-bottom:1%;">
		<div class="page-title-box">
			<div class="float-right">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Common" type="button" class="btn btn-outline-primary"><i class="fas fa-check-circle"></i>&nbsp;New Categories</a>
                  <a href="<?= base_url();?>Common/manage_Category" type="button" class="btn btn-primary btn-large"><i class="fa fa-eye"></i>&nbsp;View Categories</a>
                  <a href="<?= base_url();?>Common/addsubcategory" type="button" class="btn btn-outline-primary"><i class="fa fas fa-chart-pie"></i>&nbsp;New Subcategories</a>
                  <a href="<?= base_url();?>Common/manage_subCategory" type="button" class="btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;View Subcategories</a>
                </div>
			</div>
			<!--<h4 class="page-title">Products</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Products</a></li>-->
			<!--	<li class="breadcrumb-item active">Manage Categories</li>-->
			<!--</ol>-->
		</div><!--end page-title-box-->
	</div>
</div>
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<form method="post" action="<?= base_url('Common/editProcess');?>"  id="edit_supplier">
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
				<?php 
				      $success_message = $this->session->userdata('success_message');
				      if (isset($success_message)) {
				?>
					<div class="alert alert-success">
						<?php echo $success_message ?>                    
					</div>
				<?php
					$this->session->unset_userdata('success_message');
				}?>
				</div>
				<div class="row">
					<div class="col-lg-6">
						<label class="mb-2">Serial# <i class="text-danger">*</i></label>
						<input type="text" class="form-control"  name="fld_counter" id="fld_counter" value="<?= $category['fld_id'];?>" readonly>
					</div>
					<div class="col-lg-6">
						<label class="mb-2">Status<i class="text-danger">*</i></label>
						<select class="select2 form-control mb-3 custom-select" id="fld_status" name="fld_status" required >
							<option value="1" <?= ($category['fld_status'] == 1)?'selected':'';?>>Active</option>
							<option value="0" <?= ($category['fld_status'] == 0)?'selected':'';?>>UnActive</option>
							
						</select>
					</div> 
					<div class="col-lg-6">
						<label class="mb-2">Date<i class="text-danger">*</i></label>
						<input type="text" required="" tabindex="2" class="form-control datepicker" name="fld_item_date" value="<?= date('m-d-Y',strtotime($category['fld_date']));?>" id="fld_item_date" required>
					</div> 
					<div class="col-lg-6">
						<label class="mb-2">Category Name <i class="text-danger">*</i></label>
						
						<input type="text" class="form-control"  name="fld_category" id="fld_category" required value="<?= $category['fld_category'];?>" placeholder="e.g LPG" pattern=".*\S+.*">
					</div> 
					<div class="col-lg-6">
						<label class="mb-2">Category Unit <i class="text-danger">*</i></label>
						<select class="select2 form-control mb-3 custom-select" id="fld_unit" name="fld_unit" required="required">
							<option value="">Select Unit</option>
							<?php
									
								if($units){
									
									foreach($units as $unit){
									?>
								<option value="<?= $unit['fld_id'];?>" <?= ($category['fld_unit'] == $unit['fld_id'])?'selected':'';?> ><?= $unit['fld_unit'];?></option>
								<?php }}?>
						</select>
					</div>
					                                  
					                            
				<div class="col-lg-12">
    					<div class= id="" style="float:right; margin-top:10px;">
                            <div class="custom-control custom-switch switch-secondary ">
                            <input type="checkbox" class="custom-control-input" id="customSwitchSecondary" name="moreinfo">
                            <label class="custom-control-label" for="customSwitchSecondary">Additional Info</label>
                        </div>
                        <i class="text-danger" id="phone"></i>
                        </div>
    				</div>
					                            
				</div> 
				<div id="moreInfo" class="row" style="display: none;">
					
					<div class="col-lg-6">
						<label class="mb-2">Description</label>
						
						<input type="text" class="form-control"  name="fld_description" id="fld_description" value="<?= $category['fld_category'];?>" placeholder="Enter product's description">
					</div> 
					
					
					<?/*?><div class="mt-3">
						<label class="mb-2">Sub Category *</label>
						<select class="form-control" id="fld_sub_category" name="fld_sub_category" required="required">
							<option value="">Select Sub Category</option>
							<?php
								if($subcategory){
								foreach($subcategory as $subcat){
							?>
								<option value="<?= $subcat['fld_subcid'];?>" <?= ($category['fld_subcategory'] == $subcat['fld_subcid'])?'selected':'';?> ><?= $subcat['fld_subcategory'];?></option>
								<?php }}?>
						</select>
					</div><?*/?>                                    
					                            
				</div> 
				
				<input type="hidden" name="fld_category_id" value="<?= $category['fld_id'];?>"/>
				<input type="hidden" name="orignal_category" value="<?= $category['fld_category'];?>"/>
				<div class="col-lg-12">
					<div class="mt-3">
						<label class="mb-2"></label>
						<button type="submit" class="btn btn-successs" disabled>Update</button>
					</div>
				</div>
				
				</form>
			</div>
			</div> <!-- end card-body -->
		</div> <!-- end card --> 


</div>
                    

</div><!-- container -->

                