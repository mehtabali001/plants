<div class="container-fluid">
<div class="row">
	<div class="col-sm-12" style="margin-bottom:1%;">
		<div class="page-title-box">
		    <div class="float-right">
    			<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Common" type="button" class="btn btn-outline-primary"><i class="fas fa-check-circle"></i>&nbsp;New Categories</a>
                  <a href="<?= base_url();?>Common/manage_Category" type="button" class="btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;View Categories</a>
                  <a href="<?= base_url();?>Common/addsubcategory" type="button" class="btn btn-primary btn-large"><i class="fa fas fa-chart-pie"></i>&nbsp;New Subcategories</a>
                  <a href="<?= base_url();?>Common/manage_subCategory" type="button" class="btn btn-outline-primary"><i class="fa fa-eye"></i>&nbsp;View Subcategories</a>
                </div>
            </div>
			<!--<h4 class="page-title">Add Sub-Category</h4>-->
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<form method="post" action="<?= base_url('Common/addsubcategory');?>">
				<div class="row">
				<div class="col-lg-12">
				<div class="col-lg-6" style="padding: 0px;">
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
				</div>
				<div class="col-lg-12">
				    <div class="row">
				        <div class="col-lg-6">
				            <div class="mt-3">
        						<label class="mb-2">Category</label>
        						<select class="select2 form-control mb-3 custom-select" id="fld_category" name="fld_category" required="required">
        							<option value="">Select Category</option>
        							<?php
        									
        								if($category){
        									
        									foreach($category as $cat){
        									?>
        								<option value="<?= $cat['fld_id'];?>"><?= $cat['fld_category'];?></option>
        								<?php }}?>
        						</select>
        					</div>
        				</div>
        				<div class="col-lg-6">
        					<div class="mt-3">
        						<label class="mb-2">Sub-Category Name  <i class="text-danger">*</i></label>
        						
        						<input type="text" class="form-control"  name="fld_subcategory" id="fld_subcategory" required placeholder="" pattern=".*\S+.*">
        					</div>
        				</div>
        				<div class="col-lg-6">
        					<div class="mt-3">
        						<label class="mb-2">Weight (KG)</label>
        						
        						<input type="number" step="0.01" class="form-control"  name="weight" id="weight" placeholder="">
        					</div>
        				</div>
        			</div>
				</div> 
				
				
				<div class="col-lg-12">
					<div class="mt-3">
						<label class="mb-2"></label>
						<button type="submit" class="btn btn-successs">Proceed</button>
					</div>
				</div>
				
				</div>
				</form>
			</div>
			</div> <!-- end card-body -->
		</div> <!-- end card -->                                       
	</div> <!-- end col -->


</div>
                    

</div><!-- container -->

                