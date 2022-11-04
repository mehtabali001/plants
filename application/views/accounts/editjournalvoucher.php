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
			<h4 class="page-title">Edit Journal Voucher</h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="javascript:void(0);">Voucher</a></li>
				<li class="breadcrumb-item active">Edit Journal Voucher</li>
			</ol>
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<form method="post" action="<?= base_url('Vouchers/editJournalVoucherProcess');?>">
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
                                <label for="date" class="mb-2">Date</label>
    							<input type="text" class="form-control datepicker" name="created_date" id="created_date" value="<?= date('d/m/y',strtotime($cash['created_date']));?>" >
                            </div>
                        </div>
				        <div class="col-lg-12">
            				<div class="mt-3">
                    			<label class="mb-2">Account:  <i class="text-danger">*</i></label>
                    			<select class="select2 form-control mb-3 custom-select" id="account" name="account" required="required" style="background:#eee;">
                                        <?php 
                                              //$mainlevelss  =	 $this->Common_model->select_where_ASC_DESC('id,name','tbl_subsublevels',array('status' => 1),'name','ASC');
                                              //if($mainlevelss->num_rows() > 0) {
                                              //foreach($mainlevelss->result() as $mainlev) {
                                        ?>
                                        <?/*?><option value="<?php echo $mainlev->id;?>" <? if($mainlev->id == $id){ echo "selected"; } ?> ><?php echo $mainlev->name;?></option><?*/?>
                                            <option value="1" <? if($cash['account'] == 1){ echo "selected"; } ?>>Account 1</option>
                                            <option value="2" <? if($cash['account'] == 2){ echo "selected"; } ?>>Account 2</option>
                                            <option value="3" <? if($cash['account'] == 3){ echo "selected"; } ?>>Account 3</option>
                                        <?php //} } ?>
                                </select>
                                </div>
            			</div>
            			<div class="col-lg-12">
							<div class="mt-3">
            					<label class="mb-2">Remarks <i class="text-danger">*</i></label>
            					<input type="text" class="form-control" name="remarks" id="remarks" required placeholder="e.g Remarks" value="<?= $cash['remarks'];?>">
            				</div>
						</div>
						<div class="col-lg-12">
							<div class="mt-3">
            					<label class="mb-2">Inv# <i class="text-danger">*</i></label>
            					<input type="text" class="form-control" name="inv_or_chqno" id="inv_or_chqno" required placeholder="e.g Inv#" value="<?= $cash['inv_or_chqno'];?>">
            				</div>
						</div>
            			<div class="col-lg-12">
							<div class="mt-3">
            					<label class="mb-2">Debit</label>
            					<input type="number" class="form-control" name="debit" id="debit" placeholder="e.g 3000/-" value="<?= $cash['debit'];?>">
            				</div>
						</div>
						<div class="col-lg-12">
							<div class="mt-3">
            					<label class="mb-2">Credit</label>
            					<input type="number" class="form-control" name="credit" id="credit" placeholder="e.g 3000/-" value="<?= $cash['credit'];?>">
            				</div>
						</div>
        			</div>
				</div> 
				
				<div class="col-lg-12">
					<div class="mt-3">
						<label class="mb-2"></label>
						<input type="hidden" name="current_id" value="<?= $cash['id'];?>"/>
						<input type="hidden" name="orignal_name" value="<?= $cash['account'];?>"/>
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