<div class="container-fluid">
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<!--<div class="float-right">-->
			<!--    <div class="btn-group" role="group" aria-label="Basic outlined example">-->
   <!--               <a href="<?//= base_url();?>Accounts/manage_currentAccounts" type="button" class="btn btn-primary btn-large"><i class="fa fa-shopping-cart"></i>&nbsp;Add Sub Level</a>-->
   <!--               <a href="<?//= base_url();?>Accounts/manage_currentAccounts" type="button" class="btn btn-outline-primary"><i class="fa fa-vcard"></i>&nbsp;Manage Current Assets</a>-->
   <!--             </div>	-->
			<!--</div>-->
			<h4 class="page-title">Edit Sub Level</h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="javascript:void(0);">Sub Levels</a></li>
				<li class="breadcrumb-item active">Edit Sub Level</li>
			</ol>
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<form method="post" action="<?= base_url('Accounts/editsubsublevelProcess');?>">
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
				        <div class="col-lg-6">
            				<div class="mt-3">
            					<label class="mb-2">Sub Level Name <i class="text-danger">*</i></label>
            					<input type="text" class="form-control" name="name" id="name" required placeholder="e.g Name"  value="<?=$subcurrentAssets['name'];?>">
            				</div>
            			</div>
            			<!--<div class="col-lg-6">-->
            			<!--	<div class="mt-3">-->
            			<!--		<label class="mb-2">Sub Level Amount(PKR) <i class="text-danger">*</i></label>-->
            			<!--		<input type="text" class="form-control" name="amount" id="amount" required placeholder="e.g worth" value="<?//=$subcurrentAssets['amount'];?>">-->
            			<!--	</div>-->
            			<!--</div>-->
            			<div class="col-lg-12">
            			<div class="mt-3">
            			<label class="mb-2">Main Level <i class="text-danger">*</i></label>
            			<select class="select2 form-control mb-3 custom-select" id="parentid" name="parentid" required="required" disabled style="background:#eee;">
                                <?php $currentAssets	=	$this->Common_model->select_where_ASC_DESC('id,name','tbl_sublevels',array('status' => 1),'name','ASC');
                                      if($currentAssets->num_rows() > 0) {
                                      foreach($currentAssets->result() as $asst) {
                                ?>
                                    <option value="<?php echo $asst->id;?>" <? if($asst->id == $subcurrentAssets['parentid']){ echo "selected"; } ?> ><?php echo $asst->name;?></option>
                                <?php } } ?>
                            </select>
                        </div>
        			</div>    
        				<!--<div class="col-lg-12">-->
            <!--				<div class="mt-3">-->
            <!--					<label class="mb-2">Description</label>-->
            <!--					<textarea class="form-control" name="cs_description" id="cs_description" placeholder="Enter Your Remarks....."><?//=$subcurrentAssets['cs_description'];?></textarea>-->
            <!--				</div>  -->
            <!--			</div>-->
        			</div>
				</div> 
				<div class="col-lg-12">
            				<div class="mt-3">
            				<div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1" name="haschild" value="1" <? if($subcurrentAssets['haschild'] == 1){ echo "checked";} ?>>
                                <label class="form-check-label" for="exampleCheck1">Has Levels</label>
                            </div>	
            				</div>
            			</div>
				<div class="col-lg-12">
					<div class="mt-3">
						<label class="mb-2"></label>
						<input type="hidden" class="form-control" name="id" id="id" value="<?=$id;?>">
						<input type="hidden" class="form-control" name="parentid" id="parentid" value="<?=$subcurrentAssets['parentid'];?>">
						<input type="hidden" name="orignal_name" value="<?=$subcurrentAssets['name'];?>"/>
						<input type="hidden" name="type" value="<?=$type;?>"/>
						<button type="submit" class="btn btn-gradient-primary">Submit</button>
					</div>
				</div>
				
				</div>
				</form>
			</div>
			</div> 
		</div>                                        
	</div> 
</div>
</div>