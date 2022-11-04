<div class="container-fluid">
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<!--<div class="float-right">-->
			<!--    <div class="btn-group" role="group" aria-label="Basic outlined example">-->
   <!--               <a href="<?//= base_url();?>Accounts/assets" type="button" class="btn btn-primary btn-large"><i class="fa fa-shopping-cart"></i>&nbsp;Add Current Assets</a>-->
   <!--               <a href="<?//= base_url();?>Accounts/assets" type="button" class="btn btn-outline-primary"><i class="fa fa-vcard"></i>&nbsp;Manage Current Assets</a>-->
   <!--             </div>	-->
			<!--</div>-->
			<h4 class="page-title">Edit Main Level</h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="javascript:void(0);">Edit Level</a></li>
				<li class="breadcrumb-item active">Edit Level</li>
			</ol>
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<form method="post" action="<?= base_url('Accounts/editMainlevelProcess');?>">
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
				} ?>
				</div>
				</div>
				<div class="col-lg-12">
				    <div class="row">
				        <div class="col-lg-12">
            				<div class="mt-3">
            					<label class="mb-2">Name <i class="text-danger">*</i></label>
            					<input type="text" class="form-control" name="name" id="name" required placeholder="e.g Name" value="<?= $currentAssets['name'];?>">
            				</div>
            			</div>
            			<!--<div class="col-lg-12">-->
            			<!--	<div class="mt-3">-->
            			<!--		<label class="mb-2">Amount(PKR)</label>-->
            			<!--		<input type="text" class="form-control" name="amount" id="amount" placeholder="e.g 3000/-" value="<?//= $currentAssets['amount'];?>">-->
            			<!--	</div>-->
            			<!--</div>-->
            			<div class="col-lg-12">
            				<div class="mt-3">
            				<div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1" name="haschild" value="1" <? if($currentAssets['haschild'] == 1){ echo "checked";} ?>>
                                <label class="form-check-label" for="exampleCheck1">Has Levels</label>
                            </div>	
            				</div>
            			</div>
        				<!--<div class="col-lg-12">-->
            <!--				<div class="mt-3">-->
            <!--					<label class="mb-2">Description</label>-->
            <!--					<textarea class="form-control" name="ca_description" id="ca_description" placeholder="Enter Your Remarks....."><?//= $currentAssets['ca_description'];?></textarea>-->
            <!--				</div>                      -->
            <!--			</div>-->
        			</div>
				</div> 
				
				<div class="col-lg-12">
					<div class="mt-3">
						<label class="mb-2"></label>
						<input type="hidden" name="current_id" value="<?= $currentAssets['id'];?>"/>
						<input type="hidden" name="orignal_name" value="<?= $currentAssets['name'];?>"/>
						<input type="hidden" name="type" value="<?= $type;?>"/>
						<button type="submit" class="btn btn-gradient-primary">Submit</button>
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