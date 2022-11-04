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
                  <a href="<?= base_url();?>Vouchers/chequepaidvoucher" type="button" class="btn btn-primary btn-large"><i class="fa fa-shopping-cart"></i>&nbsp;New Cheque Payment Voucher</a>
                  <a href="<?= base_url();?>Vouchers/cashpayementvoucher" type="button" class="btn btn-outline-primary"><i class="fa fa-vcard"></i>&nbsp;New Cash Payment Voucher</a>
                  <a href="<?= base_url();?>Vouchers/journalvoucher" type="button" class="btn btn-outline-primary"><i class="fa fa-files-o"></i>&nbsp;New Journal Voucher</a>
                  <a href="<?= base_url();?>Accounts/balancesheet" type="button" class="btn btn-outline-primary"><i class="fa fa-bar-chart"></i>&nbsp;COA</a>
                </div>
			</div>
			<!--<h4 class="page-title">Cheque Payment Voucher</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Vouchers</a></li>-->
			<!--	<li class="breadcrumb-item active">Cheque Payment Voucher</li>-->
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
				 <form id="addPurchase" action="<?= base_url('Vouchers/chequepayementvoucher');?>" onsubmit="onsubmitform();" class="form-vertical"  method="post" >
				     <div class="row">
						<div class="col-sm-6">
							<h4 class="form-section"><i class="icon-eye6"></i>Cheque Payment Voucher</h4>
						</div>
					<div class="col-sm-6">
							<div class="col-sm-6" style="float:right;">
							<select class="select2 form-control mb-3 custom-select"  name="jv_voucher_history" id="jv_voucher_history" style="width:100%;">
								<option value="">CPV History</option>
								<?php if($cpv_voucher){
								foreach($cpv_voucher as $voucher){	
								?>
								<option value="<?= $voucher['id']?>" data-id="<?= $voucher['id']?>" data-link="<?php echo base_url('Vouchers/view_voucher/'.$voucher['id'].'')?>"><?= $voucher['type']?>-<?= $voucher['id']?></option>
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
										<input type="text" readonly class="form-control" name="fld_voucher_no" placeholder="Voucher Number" id="fld_voucher_no" value="CHPV-<?php echo $maxid;?>">
                                    </div>
                                </div> 
                            </div>
                            
                            <div class="col-sm-4">
                               <div class="form-group row">
                                    <label for="adress" class="col-sm-4 col-form-label">Voucher Type</label>
                                    <div class="col-sm-8">
										<input type="text" readonly class="form-control" name="fld_type" placeholder="Voucher Type" id="fld_type" value="CHPV">
                                    </div>
                                </div> 
                            </div>

                             <div class="col-sm-4">
                                <div class="form-group row">
                                    <label for="date" class="col-sm-4 col-form-label">Date <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8">
									    <?php if(isset($edit) && $edit != ""){ ?>
                                            <input type="text" required="" class="form-control" name="date" id="date" value="<?=date('d/m/Y', strtotime($editData['date']));?>" readonly>
                                        <?php }else{ ?>
									      <input type="text" required="" class="form-control datepicker" name="date" id="date">
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if(isset($edit) && $edit != ""){ ?>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group row">
                                    <input type="hidden" id="f_balanceInput" value="<?=$this->CI->getBalanceInner($editDataV['coa_id'], $editDataV['credit']); ?>" />
                                    <input type="hidden" id="f_OrignalAmount" value="<?=$editDataV['credit']; ?>" />
                                    <input type="hidden" id="f_AccountId" value="<?=$editDataV['coa_id'];?>" />
                                    <label for="Account" class="col-sm-4 col-form-label">Account <i class="text-danger" id="f_balance">(Balance: <?=$this->CI->getBalanceInner($editDataV['coa_id'], $editDataV['credit']); ?>)</i></label>
                                    <div class="col-sm-8">
									<select class="select2 form-control mb-3 custom-select " required readonly name="from_account" id="from_account" onchange="getBalance(0, 0, this.value);">
                                        <option value="">Select Account</option>
										<?php
										if($from_accounts){
										foreach($from_accounts as $account){
										?>
										<option value="<?= $account['head_code'];?>" <?php if($editDataV['coa_id']==$account['head_code']){echo'selected';} ?>><?= $account['head_name'];?></option>
										<?php }}?>
									</select>
                                    </div>
                                </div>
                            </div>
         <!--                   <div class="col-sm-8">-->
         <!--                       <div class="form-group row">-->
         <!--                           <label for="narration" class="col-sm-2 col-form-label">Narration <i class="text-danger">*</i>-->
         <!--                           </label>-->
         <!--                           <div class="col-sm-10 input-group">-->
									<!--<input type="text" required="" class="form-control" name="from_narration" id="narration" placeholder="Paymet's nature and description" value="<?//=$this->CI->getStringBetween($editDataV['narration']);?>">-->
         <!--                           <div class="tooltip1 input-group-append">-->
									<!--        <button type="button" class="btn btn-gradient-secondary btn-clipboard" onclick="myFunction()" onmouseout="outFunc()" data-clipboard-action="copy" data-clipboard-target="#clipboardInput"><i class="far fa-copy mr-2"></i><span class="tooltiptext" id="myTooltip">Copy</span></button>-->
									<!--</div>-->
         <!--                           </div>-->
         <!--                       </div>-->
         <!--                   </div>-->
                                <div class="col-sm-8 ">
                                     <div class="form-group row">
                                    <label for="narration" class="col-sm-2 col-form-label">Narration <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-10 ">
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-sm" name="from_narration" id="narration_edit" placeholder="Paymet's nature and description" value="<?=$this->CI->getStringBetween($editDataV['narration']);?>">
                                            <div class=" input-group-append">
                                                <button type="button" class="btn tooltip1 btn-outline-light btn-sm btn-clipboard" onclick="myFunction_edit()"  data-clipboard-action="copy" data-clipboard-target="#clipboardInput" onmouseout="outFunc()"><span class="tooltiptext" id="myTooltip_edit">Copy copied narration</span><i class="far fa-copy"></i></button>
                                                <button type="button" class="btn tooltip1 btn-outline-light btn-sm btn-clipboard"  onclick="paste_edit()" onmouseout="outFunc()"><span class="tooltiptext" id="myTooltip_edit_paste">Paste this narration</span><i class="far fa-clipboard"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <?php }else if(isset($duplicate)){?>
                         <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group row">
                                    <input type="hidden" id="f_balanceInput" value="<?=$this->CI->getBalanceInner($editDataV['coa_id'], $editDataV['credit']); ?>" />
                                    <input type="hidden" id="f_OrignalAmount" value="<?=$editDataV['credit']; ?>" />
                                    <input type="hidden" id="f_AccountId" value="<?=$editDataV['coa_id'];?>" />
                                    <label for="Account" class="col-sm-4 col-form-label">Account <i class="text-danger" id="f_balance">(Balance: <?=$this->CI->getBalanceInner($editDataV['coa_id'], $editDataV['credit']); ?>)</i></label>
                                    <div class="col-sm-8">
									<select class="select2 form-control mb-3 custom-select " required  name="from_account" id="from_account" onchange="getBalance(0, 0, this.value);">
                                        <option value="">Select Account</option>
										<?php
										if($from_accounts){
										foreach($from_accounts as $account){
										?>
										<option value="<?= $account['head_code'];?>" <?php if($editDataV['coa_id']==$account['head_code']){echo'selected';} ?>><?= $account['head_name'];?></option>
										<?php }}?>
									</select>
                                    </div>
                                </div>
                            </div>
         <!--                   <div class="col-sm-8">-->
         <!--                       <div class="form-group row">-->
         <!--                           <label for="narration" class="col-sm-2 col-form-label">Narration <i class="text-danger">*</i>-->
         <!--                           </label>-->
         <!--                           <div class="col-sm-10 input-group">-->
									<!--<input type="text" required="" class="form-control" name="from_narration" id="narration" placeholder="Paymet's nature and description" value="<?//=$this->CI->getStringBetween($editDataV['narration']);?>">-->
         <!--                           <div class="tooltip1 input-group-append">-->
									<!--        <button type="button" class="btn btn-gradient-secondary btn-clipboard" onclick="myFunction()" onmouseout="outFunc()" data-clipboard-action="copy" data-clipboard-target="#clipboardInput"><i class="far fa-copy mr-2"></i><span class="tooltiptext" id="myTooltip">Copy</span></button>-->
									<!--</div>-->
         <!--                           </div>-->
         <!--                       </div>-->
         <!--                   </div>-->
                                <div class="col-sm-8 ">
                                     <div class="form-group row">
                                    <label for="narration" class="col-sm-2 col-form-label">Narration <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-10 ">
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-sm" name="from_narration" id="narration_duplicate" placeholder="Paymet's nature and description" value="<?=$this->CI->getStringBetween($editDataV['narration']);?>">
                                            <div class=" input-group-append">
                                                <button type="button" class="btn tooltip1 btn-outline-light btn-sm btn-clipboard" onclick="myFunction_duplicate()"  data-clipboard-action="copy" data-clipboard-target="#clipboardInput" onmouseout="outFunc()"><span class="tooltiptext" id="myTooltip_duplicate">Copy copied narration</span><i class="far fa-copy"></i></button>
                                                <button type="button" class="btn tooltip1 btn-outline-light btn-sm btn-clipboard"  onclick="paste_duplicate()" onmouseout="outFunc()"><span class="tooltiptext" id="myTooltip_duplicate_paste">Paste this narration</span><i class="far fa-clipboard"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <?php }else{ ?>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group row">
                                    <input type="hidden" id="f_balanceInput" value="0" />
                                    <label for="Account" class="col-sm-4 col-form-label">Account <i class="text-danger" id="f_balance">(Balance: 0)</i></label>
                                    <div class="col-sm-8">
									<select class="select2 form-control mb-3 custom-select " required name="from_account" id="from_account" onchange="getBalance(0, 0, this.value);">
                                        <option value="">Select Account</option>
										<?php
										if($from_accounts){
										foreach($from_accounts as $account){
										?>
										<option value="<?= $account['head_code'];?>"><?= $account['head_name'];?></option>
										<?php }}?>
									</select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group row">
                                    <label for="narration" class="col-sm-2 col-form-label">Narration <i class="text-danger">*</i>
                                    </label>
         <!--                           <div class="col-sm-10 input-group">-->
									<!--<input type="text" required="" class="form-control" name="from_narration" id="narration" placeholder="Paymet's nature and description">-->
         <!--                           <div class="tooltip1 input-group-append">-->
									<!--        <button type="button" class="btn btn-gradient-secondary btn-clipboard" onclick="myFunction()" onmouseout="outFunc()" data-clipboard-action="copy" data-clipboard-target="#clipboardInput"><i class="far fa-copy mr-2"></i><span class="tooltiptext" id="myTooltip">Copy</span></button>-->
									<!--</div>-->
         <!--                           </div>-->
                                    <div class="col-sm-10 ">
                                        <div class="input-group">
                                        <input type="text" class="form-control form-control-sm" name="from_narration" id="narration" placeholder="Paymet's nature and description">
                                        <div class=" input-group-append">
                                           <button type="button" class="btn tooltip1 btn-outline-light btn-sm btn-clipboard" onclick="myFunction()"  data-clipboard-action="copy" data-clipboard-target="#clipboardInput" onmouseout="outFunc()"><span class="tooltiptext" id="myTooltip">Copy this narration</span><i class="far fa-copy"></i></button>
                                                <button type="button" class="btn tooltip1 btn-outline-light btn-sm btn-clipboard"  onclick="paste2()" onmouseout="outFunc()"><span class="tooltiptext" id="myTooltip_2">Paste copied narration</span><i class="far fa-clipboard"></i></button>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                       
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
                                        <th class="text-center" style="width:15%;">Amount(PKR)</th>
                                        <th class="text-center" style="width:8%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="voucher_details">
                                    <?php 
                                    $totalAmount = 0;
                                        $sn =0;
                                    if(isset($edit) && $edit != ""){
                                        
                                    foreach($editDataDetails as $vData){
                                        $sn++;
                                    $totalAmount += $vData['debit'];
                                    ?>
                                    <tr>
                                        <td class="span3">
                                           <input type="text" id="coa_id_<?=$sn;?>" name="coa_id[]" class="form-control text-center" placeholder="Code" value="<?=$vData['coa_id'];?>" readonly>
                                        </td>
                                        <td class="span3">
                                           <select class="select2 form-control mb-3 custom-select sel_account_id" readonly onchange="inputCode(<?=$sn;?>, this.value)" name="account_id" id="account_id_<?=$sn;?>" required style="width:100%;">
                                                <option value="">Select Account</option>
                                                <?php
        										if($to_accounts){
        										foreach($to_accounts as $account){
        										?>
        										<option value="<?= $account['head_code'];?>" <?php if($vData['coa_id']==$account['head_code']){echo'selected';} ?>><?= $account['head_name'];?></option>
        										<?php }}?>
											</select>
                                        </td>
                                        <td class="span3">
                                            <!--<input type="text" id="narration_<?=$sn;?>" name="narration[]" class="form-control text-left"  placeholder="Paymet's nature and description"  value="<?//=$this->CI->getStringBetween($vData['narration']);?>" required>-->
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm " id="narration_<?=$sn;?>" name="narration[]"  placeholder="Paymet's nature and description"value="<?=$this->CI->getStringBetween($vData['narration']);?>">
                                                <div class="input-group-append">
                                                    <button type="button" class="btn tooltip1 btn-outline-light btn-sm btn-clipboard" onclick="copy_edit_table(<?=$sn;?>)"  data-clipboard-action="copy" data-clipboard-target="#clipboardInput"  onmouseout="outFunc(<?=$sn;?>)"><span class="tooltiptext" id="copyTooltip_edit_table_<?=$sn;?>">Copy this narration</span><i class="far fa-copy"></i></button>
                                                    <button type="button" class="btn tooltip1 btn-outline-light btn-sm btn-clipboard"  onclick="paste_edit_table(<?=$sn;?>)" onmouseout="outFunc(<?=$sn;?>)"><span class="tooltiptext" id="pasteTooltip_edit_table_<?=$sn;?>">Paste copied narration</span><i class="far fa-clipboard"></i></button>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="span3">
                                           <input type="text" id="p_balance_<?=$sn;?>" name="p_balance[]" class="form-control text-center" placeholder="0.00" value="<?=$this->CI->getBalanceInner($vData['coa_id']); ?>" readonly>
                                        </td>
                                        
                                        <td class="test">
                                            <input type="number" step="0.01" oninput="validity.valid||(value='');"  name="amount[]" readonly required=""  id="amount_<?=$sn;?>" class="form-control amount text-right" onkeyup="calculateSum()" onchange="calculateSum()" placeholder="0.00" value="<?=$vData['debit'];?>" min="0" required>
                                        </td>
                                        
                                        <td>
                                            <button class="btn btn-danger text-right red" type="button" value="Delete" onclick="deleteRow(this)" disabled><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <?php }}else if(isset($duplicate)){
                                     foreach($editDataDetails as $vData){
                                        $sn++;
                                    $totalAmount += $vData['debit'];
                                    ?>
                                     <tr>
                                        <td class="span3">
                                           <input type="text" id="coa_id_<?=$sn;?>" name="coa_id[]" class="form-control text-center" placeholder="Code" value="<?=$vData['coa_id'];?>" readonly>
                                        </td>
                                        <td class="span3">
                                           <select class="select2 form-control mb-3 custom-select sel_account_id"  onchange="inputCode(<?=$sn;?>, this.value)" name="account_id" id="account_id_<?=$sn;?>" required style="width:100%;">
                                                <option value="">Select Account</option>
                                                <?php
        										if($to_accounts){
        										foreach($to_accounts as $account){
        										?>
        										<option value="<?= $account['head_code'];?>" <?php if($vData['coa_id']==$account['head_code']){echo'selected';} ?>><?= $account['head_name'];?></option>
        										<?php }}?>
											</select>
                                        </td>
                                        <td class="span3">
                                            <!--<input type="text" id="narration_<?=$sn;?>" name="narration[]" class="form-control text-left"  placeholder="Paymet's nature and description"  value="<?//=$this->CI->getStringBetween($vData['narration']);?>" required>-->
                                             <div class="input-group">
                                                <input type="text" class="form-control form-control-sm " id="narration_<?=$sn;?>" name="narration[]"  placeholder="Paymet's nature and description"value="<?=$this->CI->getStringBetween($vData['narration']);?>">
                                                <div class="input-group-append">
                                                    <button type="button" class="btn tooltip1 btn-outline-light btn-sm btn-clipboard" onclick="copy_duplicate_table(<?=$sn;?>)"  data-clipboard-action="copy" data-clipboard-target="#clipboardInput"  onmouseout="outFunc(<?=$sn;?>)"><span class="tooltiptext" id="copyTooltip_duplicate_table_<?=$sn;?>">Copy this narration</span><i class="far fa-copy"></i></button>
                                                    <button type="button" class="btn tooltip1 btn-outline-light btn-sm btn-clipboard"  onclick="paste_duplicate_table(<?=$sn;?>)" onmouseout="outFunc(<?=$sn;?>)"><span class="tooltiptext" id="pasteTooltip_duplicate_table_<?=$sn;?>">Paste copied narration</span><i class="far fa-clipboard"></i></button>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="span3">
                                           <input type="text" id="p_balance_<?=$sn;?>" name="p_balance[]" class="form-control text-center" placeholder="0.00" value="<?=$this->CI->getBalanceInner($vData['coa_id']); ?>" readonly>
                                        </td>
                                        
                                        <td class="test">
                                            <input type="number" step="0.01" oninput="validity.valid||(value='');"  name="amount[]"  required=""  id="amount_<?=$sn;?>" class="form-control amount text-right" onkeyup="calculateSum()" onchange="calculateSum()" placeholder="0.00" value="<?=$vData['debit'];?>" min="0" required>
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
        										if($to_accounts){
        										foreach($to_accounts as $account){
        										?>
        										<option value="<?= $account['head_code'];?>"><?= $account['head_name'];?></option>
        										<?php }}?>
											</select>
                                        </td>
                                        <!--<td class="span3">-->
                                        <!--    <input type="text" id="narration_1" name="narration[]" class="form-control text-left"  placeholder="Paymet's nature and description" required>-->
                                        <!--</td>-->
                                        <td class="span3 input-group">
                 <!--                           <input type="text" id="narration_1" name="narration[]" class="form-control text-left"  placeholder="Paymet's nature and description" required>-->
                 <!--                           <div class="tooltip1 input-group-append">-->
    									    <!--    <button type="button" class="btn btn-gradient-secondary btn-clipboard" onclick="paste()"  data-clipboard-target="">paste</button>-->
    									    <!--</div>-->
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
                                            <input type="number" step="0.01" oninput="validity.valid||(value='');" name="amount[]" required=""  id="amount_1" class="form-control amount text-right" onkeyup="calculateSum()" onchange="calculateSum()" placeholder="0.00" value="" min="0" required>
                                        </td>
                                        
                                        <td>
                                            <button class="btn btn-danger text-right red" type="button" value="Delete" onclick="deleteRow(this)" ><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-right" colspan="4"><b>Net Amount (PKR):</b></td>
                                        <td class="text-right">
                                            <input type="text" id="total_amount" class="text-right form-control" tabindex="-1" name="total_amount" value="<?=$totalAmount;?>" readonly="readonly">
                                        </td>
                                        <td> 
                                        <button type="button" id="add_invoice_item" class="btn btn-success" name="add-invoice-item" onclick="addRow()" <?php if(isset($edit) && $edit != ""){ echo 'disabled';} ?>><i class="fa fa-plus"></i></button>
                                    </tr>
                                    
                                </tfoot>
                            </table>
                        </div>
					
                         <div class="form-group row">
                            <div class="col-sm-8">
                                 <input type="hidden" id="countRow" value="<?php if(isset($edit)){ echo $sn+1; }else{ echo $sn+2;} ?>" />
                                <?php if(isset($edit)  && $edit != ""){ ?>
                                    <input type="hidden" name="editId" value="<?=$edit; ?>" />
                                    <input type="submit" id="edit_vourcher" class="btn btn-successs" name="edit-vourcher" value="Update F10">
                                    <input type="hidden" name="edit-vourcher" value="1"/>
                                <?php }else{ ?>
                                    <input type="hidden" name="add-vourcher" value="1"/>
                                    <input type="submit" id="add_vourcher" class="btn btn-successs"  name="add-vourcher" value="Proceed F10">
                                    <!--<input type="reset"  class="btn btn-danger btn-large" name="reset" id="Reset" value="Reset F5">-->
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
			if($to_accounts){
			foreach($to_accounts as $account){
			?>
			<option value="<?= $account['head_code'];?>"><?= $account['head_name'];?></option>
			<?php }}?>
</div>  
<script>
function myFunction() {
  var copyText = document.getElementById("narration");
  copyText.select();
  copyText.setSelectionRange(0, 99999);
  navigator.clipboard.writeText(copyText.value);
  
  var tooltip = document.getElementById("myTooltip");
  tooltip.innerHTML = "Copied ";
}

function myFunction_edit() {
  var copyText = document.getElementById("narration_edit");
  copyText.select();
  copyText.setSelectionRange(0, 99999);
  navigator.clipboard.writeText(copyText.value);
  
  var tooltip = document.getElementById("myTooltip_edit");
  tooltip.innerHTML = "Copied ";
}
function myFunction_duplicate() {
  var copyText = document.getElementById("narration_duplicate");
  copyText.select();
  copyText.setSelectionRange(0, 99999);
  navigator.clipboard.writeText(copyText.value);
  
  var tooltip = document.getElementById("myTooltip_duplicate");
  tooltip.innerHTML = "Copied ";
}
function outFunc(sl) {
  var tooltip = document.getElementById("myTooltip");
  tooltip.innerHTML = "Copy this naration";
  var tooltip_1 = document.getElementById("copyTooltip_"+sl);
  tooltip_1.innerHTML = "Copy this naration";
}

        
        
        function onsubmitform(){
            $("#add_vourcher").val("Submitting…");
            $("#add_vourcher").prop("disabled", true);
            $("#edit_vourcher").val("Submitting…");
            $("#edit_vourcher").prop("disabled", true);
        }
</script>