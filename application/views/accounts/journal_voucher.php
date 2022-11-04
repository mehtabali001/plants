<style>
/*tooltip start*/
.tooltip1 {
  position: relative;
}
.tooltip1 .tooltiptext {
    visibility: hidden;
    width: 145px;
    background-color: #555;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 5px;
    position: absolute;
    /* z-index: 10000000; */
    bottom: 150%;
    left: -222%;
    opacity: 0;
    transition: opacity 0.3s
}

.tooltip1 .tooltiptext::after {
  content: "";
  position: absolute;
  top: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: #555 transparent transparent transparent;
}

.tooltip1:hover .tooltiptext {
  visibility: visible;
  opacity: 1;
}
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
select[readonly].select2-hidden-accessible + .select2-container {
  pointer-events: none;
  touch-action: none;
}

select[readonly].select2-hidden-accessible + .select2-container .select2-selection {
  background: #eee;
  box-shadow: none;
}

select[readonly].select2-hidden-accessible + .select2-container .select2-selection__arrow,
select[readonly].select2-hidden-accessible + .select2-container .select2-selection__clear {
  display: none;
}
</style>
<div class="container-fluid">
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right" style="margin-bottom:15px;">
    			<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Vouchers/chequepaidvoucher" type="button" class="btn btn-outline-primary"><i class="fa fa-shopping-cart"></i>&nbsp;New Cheque Paid Voucher</a>
                  <a href="<?= base_url();?>Vouchers/cashpayementvoucher" type="button" class="btn btn-outline-primary"><i class="fa fa-vcard"></i>&nbsp;New Cash Payment Voucher</a>
                  <a href="<?= base_url();?>Vouchers/journalvoucher" type="button" class="btn btn-primary btn-large"><i class="fa fa-files-o"></i>&nbsp;New Journal Voucher</a>
                  <a href="<?= base_url();?>Accounts/balancesheet" type="button" class="btn btn-outline-primary"><i class="fa fa-bar-chart"></i>&nbsp;COA</a>
                </div>
			</div>
			<!--<h4 class="page-title">Journal Voucher</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Vouchers</a></li>-->
			<!--	<li class="breadcrumb-item active">Journal Voucher</li>-->
			<!--</ol>-->
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
				 <form id="addPurchase" action="<?= base_url('Vouchers/journalvoucher');?>" class="form-vertical" onsubmit="return checkTotalAmount();"  method="post" >
						<div class="row">
						   <div class="col-sm-6">
    							<h4 class="form-section"><i class="icon-eye6"></i>Journal Voucher</h4>
    						</div> 
    						<div class="col-sm-6">
    						    <div class="col-sm-6" style="float:right;">
    							<select class="select2 form-control mb-3 custom-select"  name="jv_voucher_history" id="jv_voucher_history" style="width:100%;">
                                    <option value="">JV History</option>
									<?php if($journal_voucher){
									foreach($journal_voucher as $voucher){	
									?>
									<option value="<?= $voucher['id']?>" data-id="<?= $voucher['id']?>" data-link="<?php echo base_url('Vouchers/view_jv_voucher/'.$voucher['id'].'')?>"><?= $voucher['type']?>-<?= $voucher['id']?></option>
									<?php }}?>
								</select>
								</div>
    						</div>
    					</div>
						
						<hr>
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
                                        <?php if(isset($edit) && $edit !=""){ ?>
                                            <input type="text" required="" class="form-control" name="date" id="date" value="<?=date('d/m/Y', strtotime($editData['date']));?>" readonly>
                                        <?php }else{ ?>
									      <input type="text" required="" class="form-control datepicker" name="date" id="date">
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>

						<div class="col-sm-12">
							<h4 class="form-section"><i class="icon-eye6"></i>Vourcher Details</h4>
						</div>
						<hr>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="purchaseTable">
                                <thead>
                                     <tr>
                                        <th class="text-center" style="width:12%;">Code</th> 
                                        <th class="text-center" style="width:20%;">Account </th>
                                        <th class="text-center">Narration</th>
                                        <th class="text-center" style="width:12%;">P.Balance(PKR)</th> 
                                        <th class="text-center" style="width:10%;">Debit(PKR)</th>
                                        <th class="text-center" style="width:10%;">Credit(PKR)</th>
                                        <th class="text-center" style="width:8%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="voucher_details">
                                    <?php 
                                    $totalDebit = 0;
                                        $totalCredit = 0;
                                        $sn =0;
                                    if(isset($edit) && $edit !=""){
                                        
                                    foreach($editDataDetails as $vData){
                                        $sn++;
                                    $totalDebit += $vData['debit'];
                                    $totalCredit += $vData['credit'];
                                    ?>
                                    <tr>
                                        <td class="span3">
                                           <input type="text" id="coa_id_<?=$sn; ?>" name="coa_id[]" class="form-control text-center" placeholder="Code" value="<?=$vData['coa_id'];?>" readonly>
                                        </td>
                                        <td class="span3">
                                           <select class="select2 form-control mb-3 custom-select sel_account_id" readonly onchange="inputCode(<?=$sn; ?>, this.value)" name="account_id" id="account_id_<?=$sn; ?>" required style="width:100%;">
                                                <option value="">Select Account</option>
                                                <?php
        										if($accounts){
        										foreach($accounts as $account){
        										?>
        										<option value="<?= $account['head_code'];?>" <?php if($vData['coa_id']==$account['head_code']){echo'selected';} ?>><?= $account['head_name'];?></option>
        										<?php }}?>
											</select>
                                        </td>
                                        <td class="span3">
                                            <!--<input type="text" id="narration_<?=$sn; ?>" name="narration[]" class="form-control text-left"  placeholder="Paymet's nature and description" value="<?//=$vData['narration'];?>" required>-->
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm " id="narration_<?=$sn;?>" name="narration[]"  placeholder="Paymet's nature and description"value="<?=$vData['narration'];?>">
                                                <div class="input-group-append">
                                                    <button type="button" class="btn tooltip1 btn-outline-light btn-sm btn-clipboard" onclick="copy_edit_table(<?=$sn;?>)"  data-clipboard-action="copy" data-clipboard-target="#clipboardInput"  onmouseout="outFunc(<?=$sn;?>)"><span class="tooltiptext" id="copyTooltip_edit_table_<?=$sn;?>">Copy this narration</span><i class="far fa-copy"></i></button>
                                                    <button type="button" class="btn tooltip1 btn-outline-light btn-sm btn-clipboard"  onclick="paste_edit_table(<?=$sn;?>)" onmouseout="outFunc(<?=$sn;?>)"><span class="tooltiptext" id="pasteTooltip_edit_table_<?=$sn;?>">Paste copied narration</span><i class="far fa-clipboard"></i></button>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="span3">
                                           <input type="text" id="p_balance_<?=$sn; ?>" name="p_balance[]" class="form-control text-center" placeholder="0.00" value="<?=$this->CI->getBalanceInner($vData['coa_id']); ?>" readonly>
                                        </td>
                                        
                                        <td class="test">
                                            <input type="number" step="0.01" oninput="validity.valid||(value='');"  name="debit[]" readonly id="debit_<?=$sn; ?>" class="form-control debit text-right" placeholder="0.00" value="<?php if($vData['debit']>0){echo $vData['debit'];} ?>" <?php if($vData['debit']==0){echo 'readonly';} ?> min="0">
                                        </td>
                                        <td class="test">
                                            <input type="number" step="0.01" oninput="validity.valid||(value='');"  name="credit[]" readonly id="credit_<?=$sn; ?>" class="form-control credit text-right" placeholder="0.00" value="<?php if($vData['credit']>0){echo $vData['credit'];} ?>" <?php if($vData['credit']==0){echo 'readonly';} ?> min="0">
                                        </td>
                                        
                                        <td>
                                            <button class="btn btn-danger text-right red" type="button" value="Delete" onclick="deleteRow(this)" disabled><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <?php }}else if(isset($duplicate)){
                                    foreach($editDataDetails as $vData){
                                        $sn++;
                                    $totalDebit += $vData['debit'];
                                    $totalCredit += $vData['credit'];
                                    ?>
                                    <tr>
                                        <td class="span3">
                                           <input type="text" id="coa_id_<?=$sn; ?>" name="coa_id[]" class="form-control text-center" placeholder="Code" value="<?=$vData['coa_id'];?>" readonly>
                                        </td>
                                        <td class="span3">
                                           <select class="select2 form-control mb-3 custom-select sel_account_id"  onchange="inputCode(<?=$sn; ?>, this.value)" name="account_id" id="account_id_<?=$sn; ?>" required style="width:100%;">
                                                <option value="">Select Account</option>
                                                <?php
        										if($accounts){
        										foreach($accounts as $account){
        										?>
        										<option value="<?= $account['head_code'];?>" <?php if($vData['coa_id']==$account['head_code']){echo'selected';} ?>><?= $account['head_name'];?></option>
        										<?php }}?>
											</select>
                                        </td>
                                        <td class="span3">
                                            <!--<input type="text" id="narration_<?=$sn; ?>" name="narration[]" class="form-control text-left"  placeholder="Paymet's nature and description" value="<?=$vData['narration'];?>" required>-->
                                             <div class="input-group">
                                                <input type="text" class="form-control form-control-sm " id="narration_<?=$sn;?>" name="narration[]"  placeholder="Paymet's nature and description" value="<?=$vData['narration'];?>">
                                                <div class="input-group-append">
                                                    <button type="button" class="btn tooltip1 btn-outline-light btn-sm btn-clipboard" onclick="copy_duplicate_table(<?=$sn;?>)"  data-clipboard-action="copy" data-clipboard-target="#clipboardInput"  onmouseout="outFunc(<?=$sn;?>)"><span class="tooltiptext" id="copyTooltip_duplicate_table_<?=$sn;?>">Copy this narration</span><i class="far fa-copy"></i></button>
                                                    <button type="button" class="btn tooltip1 btn-outline-light btn-sm btn-clipboard"  onclick="paste_duplicate_table(<?=$sn;?>)" onmouseout="outFunc(<?=$sn;?>)"><span class="tooltiptext" id="pasteTooltip_duplicate_table_<?=$sn;?>">Paste copied narration</span><i class="far fa-clipboard"></i></button>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="span3">
                                           <input type="text" id="p_balance_<?=$sn; ?>" name="p_balance[]" class="form-control text-center" placeholder="0.00" value="<?=$this->CI->getBalanceInner($vData['coa_id']); ?>" readonly>
                                        </td>
                                        
                                        <td class="test">
                                            <input type="number" step="0.01" oninput="validity.valid||(value='');"  name="debit[]"  id="debit_<?=$sn; ?>" class="form-control debit text-right" placeholder="0.00" value="<?php if($vData['debit']>0){echo $vData['debit'];} ?>" <?php if($vData['debit']==0){echo '';} ?> min="0">
                                        </td>
                                        <td class="test">
                                            <input type="number" step="0.01" oninput="validity.valid||(value='');"  name="credit[]"  id="credit_<?=$sn; ?>" class="form-control credit text-right" placeholder="0.00" value="<?php if($vData['credit']>0){echo $vData['credit'];} ?>" <?php if($vData['credit']==0){echo '';} ?> min="0">
                                        </td>
                                        
                                        <td>
                                            <button class="btn btn-danger text-right red" type="button" value="Delete" onclick="deleteRow(this)" ><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <?php }}else{ ?>
                                    <tr>
                                        <td class="span3">
                                           <input type="text" id="coa_id_1" name="coa_id[]" class="form-control text-center" placeholder="Code" readonly>
                                        </td>
                                        <td class="span3">
                                           <select class="select2 form-control mb-3 custom-select sel_account_id" onchange="inputCode(1, this.value)" name="account_id" id="account_id_1" required style="width:100%;">
                                                <option value="">Select Account</option>
                                                <?php
        										if($accounts){
        										foreach($accounts as $account){
        										?>
        										<option value="<?= $account['head_code'];?>"><?= $account['head_name'];?></option>
        										<?php }}?>
											</select>
                                        </td>
                                        <td class="span3">
                                            <!--<input type="text" id="narration_1" name="narration[]" class="form-control text-left"  placeholder="Paymet's nature and description" required>-->
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="narration_1" name="narration[]"  placeholder="Paymet's nature and description">
                                                <div class="input-group-append">
                                                    <button type="button" class="btn tooltip1 btn-outline-light btn-sm btn-clipboard" onclick="copy2(1)"  data-clipboard-action="copy" data-clipboard-target="#clipboardInput"  onmouseout="outFunc(1)"><span class="tooltiptext" id="copyTooltip_1">Copy this narration</span><i class="far fa-copy"></i></button>
                                                    <button type="button" class="btn tooltip1 btn-outline-light btn-sm btn-clipboard"  onclick="paste(1)" onmouseout="outFunc(1)"><span class="tooltiptext" id="pasteTooltip_1">Paste copied narration</span><i class="far fa-clipboard"></i></button>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="span3">
                                           <input type="text" id="p_balance_1" name="p_balance[]" class="form-control text-center" placeholder="0.00" readonly>
                                        </td>
                                        
                                        <td class="test">
                                            <input type="number" step="0.01" oninput="validity.valid||(value='');"  name="debit[]"  id="debit_1" class="form-control debit text-right" onkeyup="calculateSum()" onchange="calculateSum()" placeholder="0.00" value="" min="0">
                                        </td>
                                        <td class="test">
                                            <input type="number" step="0.01" oninput="validity.valid||(value='');"  name="credit[]"  id="credit_1" class="form-control credit text-right" onkeyup="calculateSum()" onchange="calculateSum()" placeholder="0.00" value="" min="0">
                                        </td>
                                        
                                        <td>
                                            <button class="btn btn-danger text-right red" type="button" value="Delete" onclick="deleteRow(this)" ><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-right" colspan="4"><b>Total (PKR):</b></td>
                                        <td class="text-right">
                                            <input type="number" step="0.01" oninput="validity.valid||(value='');" id="total_amount_debit" tabindex="-1" class="text-right form-control" name="total_amount_debit" value="<?=$totalDebit;?>" readonly="readonly">
                                        </td>
                                        <td class="text-right">
                                            <input type="number" step="0.01" oninput="validity.valid||(value='');" id="total_amount_credit" tabindex="-1" class="text-right form-control" name="total_amount_credit" value="<?=$totalCredit;?>" readonly="readonly">
                                        </td>
                                        <td> 
                                            <button type="button" id="add_invoice_item"  class="btn btn-success" name="add-invoice-item" onclick="addRowJv()" <?php if(isset($edit) && $edit !=""){ echo 'disabled';} ?>><i class="fa fa-plus"></i></button>
                                        </td>
                                    </tr>
                                    
                                </tfoot>
                            </table>
                        </div>
					
                        <div class="form-group row">
                            <div class="col-sm-8">
                                
                                <input type="hidden" id="countRow" value="<?php if(isset($edit)){ echo $sn+1; }else{ echo $sn+2;} ?>" />
                                <?php if(isset($edit)  && $edit != ""){ ?>
                                    <input type="hidden" name="editId" value="<?=$edit; ?>" />
                                    <input type="submit" id="edit_vourcher" class="btn btn-successs"  name="edit-vourcher" value="Update F10">
                                    <input type="hidden" name="edit-vourcher" value="1"/>
                                <?php }else{ ?>
                                    <input type="hidden" name="add-vourcher" value="1"/>
                                    <input type="submit" id="add_vourcher" class="btn btn-successs"  name="add-vourcher" value="Proceed F10">
                                    <input type="reset"  class="btn btn-danger btn-large" onclick="window.location.href='<?=base_url(uri_string());?>'" name="reset" id="Reset" value="Reset  F5">
                                <?php } ?>
                                
							
                            </div>
                        </div>
                        <br>
                    </form>						
				
				</div>
			</div> <!-- end card-body -->
		</div> <!-- end card -->                                       
	</div> <!-- end col -->
</div><!-- container -->
<div id="accountSelect" style="display:none;">
			<?php
			if($accounts){
			foreach($accounts as $account){
			?>
			<option value="<?= $account['head_code'];?>"><?= $account['head_name'];?></option>
			<?php }}?>
</div>   
<script>
    function checkTotalAmount(){
        var total_amount_debit = $("#total_amount_debit").val();
        var total_amount_credit = $("#total_amount_credit").val();
        if(total_amount_debit != total_amount_credit){
            $.notify("Total debit amount should be equal to credit amount");
            return false;
        }else{
            onsubmitform();
            return true;
        }
    }
    
     function onsubmitform(){
            $("#add_vourcher").val("Submitting…");
            $("#add_vourcher").prop("disabled", true);
            $("#edit_vourcher").val("Submitting…");
            $("#edit_vourcher").prop("disabled", true);
        }
    function outFunc(sl) {
          var tooltip = document.getElementById("myTooltip");
          tooltip.innerHTML = "Copy this naration";
          var tooltip_1 = document.getElementById("copyTooltip_"+sl);
          tooltip_1.innerHTML = "Copy this naration";
        }
</script>