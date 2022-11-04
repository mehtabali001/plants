<style>
 .select2-container--default.select2-container--disabled .select2-selection--single {
    background-color: #212744;
    cursor: default;
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
    color: #5a5c61;
    line-height: 28px;
	padding-top: 2px;
}
.select2-container {
    width: 100% !important;
}
</style>
<div class="container-fluid">
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right">
    			<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Vouchers/chequepaidvoucher" type="button" class="btn btn-outline-primary"><i class="fa fa-shopping-cart"></i>&nbsp;Cheque Paid Voucher</a>
                  <a href="<?= base_url();?>Vouchers/cashpayementvoucher" type="button" class="btn btn-outline-primary"><i class="fa fa-vcard"></i>&nbsp;Cash Payment Voucher</a>
                  <a href="<?= base_url();?>Vouchers/journalvoucher" type="button" class="btn btn-primary btn-large"><i class="fa fa-files-o"></i>&nbsp;Journal Voucher</a>
                  <a href="<?= base_url();?>Accounts/balancesheet" type="button" class="btn btn-outline-primary"><i class="fa fa-bar-chart"></i>&nbsp;COA</a>
                </div>
			</div>
			<h4 class="page-title">Vouchers</h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="javascript:void(0);">Vouchers</a></li>
				<li class="breadcrumb-item active">Journal Voucher</li>
			</ol>
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<div class="row">
	<div class="col-lg-12">
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
					</div>
					

   <? /*<table class="table" style="border-collapse: collapse;width: 100%; margin-top:50px;">
        <tr>
            <td style="font-weight:bold;">Voucher Number</td>
            <td><?=$editData['type']?>-<?=$editData['id']?></td>
            <td style="font-weight:bold;">Voucher type</td>
            <td><?=$editData['type']?></td>
            <td style="font-weight:bold;">Date </td>
            <td><?=$editData['date']?></td>
        </tr>
        </table>*/?>
        <div class="row">
						    
						    <div class="col-sm-4">
                               <div class="form-group row">
                                    <label for="adress" class="col-sm-4 col-form-label">Voucher Number</label>
                                    <div class="col-sm-8">
										<input type="text" readonly class="form-control" name="fld_voucher_no" placeholder="Voucher Number" id="fld_voucher_no" value="JV-<?php echo $maxid;?>">
                                    </div>
                                </div> 
                            </div>
                            
                            <div class="col-sm-4">
                               <div class="form-group row">
                                    <label for="adress" class="col-sm-4 col-form-label">Voucher Type</label>
                                    <div class="col-sm-8">
										<input type="text" readonly class="form-control" name="fld_type" placeholder="Voucher Type" id="fld_type" value="JV">
                                    </div>
                                </div> 
                            </div>

                             <div class="col-sm-4">
                                <div class="form-group row">
                                    <label for="date" class="col-sm-4 col-form-label">Date <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8">
                                        <?php if(isset($edit)){ ?>
                                            <input type="text" required="" class="form-control" name="date" id="date" value="<?=date('d/m/Y', strtotime($editData['date']));?>" readonly>
                                        <?php }else{ ?>
									      <input type="text" required="" class="form-control datepicker" name="date" id="date">
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
        
    <h3 style="text-align:left;margin-bottom: 0;">Vourcher Details</h3>
    <hr>
    <table id="datatable_tb" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead>
             <tr>
                <th>Code</th> 
                <th>Account </th>
                <th>Narration</th>
                <th >Debit</th>
                <th>Credit</th>
            </tr>
        </thead>
        <tbody id="voucher_details">
            <?php 
            $totalAmountdebit = 0;
            $totalAmountcredit = 0;
                $sn =0;
                // print_r($editDataDetails);
                
            foreach($editDataDetails as $vData){
                $sn++;
            $totalAmountdebit += $vData['debit'];
            $totalAmountcredit += $vData['credit'];
            
            ?>
            <tr>
                <td class="span3">
                  <?=$vData['coa_id'];?>
                </td>
                <td class="span3">
                   <?php echo $this->db->query("select * from tbl_coa where head_code = '{$vData['coa_id']}'")->row()->head_name; ?>
                </td>
                <td class="span3">
                    <?=$this->CI->getStringBetween($vData['narration']);?>
                </td>
                
                
                <td class="test">
                    <?=$vData['debit'];?>
                </td>
                <td class="test">
                    <?=$vData['credit'];?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" style="text-align:right;"><b>Total (PKR):</b></td>
                <td class="">
                    <?=$totalAmountdebit;?>
                </td>
                <td class="">
                    <?=$totalAmountcredit;?>
                </td>
            </tr>
            
        </tfoot>
    </table>
    <div class="row">
						   
		<div class="col-sm-12">
			<div class="col-sm-12" style="text-align: right;">
			<a href="<?php echo base_url();?>Vouchers/journalvoucher/edit/<?= $edit;?>"  class="btn btn-danger">
				Edit Voucher
			</a>
			</div>
		</div>
	</div>
				
				</div>
			</div> <!-- end card-body -->
		</div> <!-- end card -->                                       
	</div> <!-- end col -->
</div><!-- container -->


