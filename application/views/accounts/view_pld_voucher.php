<style>/*tooltip start*/

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
			<div class="float-right">
    			<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Vouchers/chequepaidvoucher" type="button" class="btn btn-outline-primary"><i class="fa fa-shopping-cart"></i>&nbsp;+ Cheque Paid Voucher</a>
                  <a href="<?= base_url();?>Vouchers/pldvoucher" type="button" class="btn btn-primary btn-large"><i class="fa fa-vcard"></i>&nbsp;Profit Loss Division Voucher</a>
                  <a href="<?= base_url();?>Vouchers/journalvoucher" type="button" class="btn btn-outline-primary"><i class="fa fa-files-o"></i>&nbsp;+ Journal Voucher</a>
                  <a href="<?= base_url();?>Accounts/balancesheet" type="button" class="btn btn-outline-primary"><i class="fa fa-bar-chart"></i>&nbsp;COA</a>
                </div>
			</div>
			<h4 class="page-title">Profit Loss Division Voucher</h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="javascript:void(0);">Vouchers</a></li>
				<li class="breadcrumb-item active">Profit Loss Division Voucher</li>
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
					<?php 
                        $totalAmount = 0;
                            $sn =0;
                            // print_r($editDataDetails);
                            
                        foreach($editDataDetails as $vData){
                            $sn++;
                            if($editData['type'] == 'CRV' || $editData['type'] == 'CHRV'){
                            $amount=$vData['credit'];
                        }else{
                            $amount=$vData['debit'];
                        }
                        $totalAmount += $amount;
                        
                        ?>
				 <form id="addPurchase" action="<?= base_url('Vouchers/pldvoucher');?>" onsubmit="onsubmitform();" class="form-vertical"  method="post" >
						
						<div class="row">
						<div class="col-sm-6">
							<h4 class="form-section"><i class="icon-eye6"></i>Profit Loss Division Voucher</h4>
						</div>
						 
						<!--<div class="col-sm-6">-->
						<!--	<div class="col-sm-6" style="float:right;">-->
						<!--	<select class="select2 form-control mb-3 custom-select"  name="jv_voucher_history" id="jv_voucher_history" style="width:100%;">-->
						<!--		<option value="">PLD History</option>-->
								<?/*php if($pld_voucher){
								foreach($pld_voucher as $voucher){	*/
								?>
								<option value="<?//= $voucher['id']?>" data-id="<?//= $voucher['id']?>" data-link="<?//php echo base_url('Vouchers/view_voucher/'.$voucher['id'].'')?>"><?//= $voucher['type']?>-<?//= $voucher['id']?></option>
								<?php //}}?>
						<!--	</select>-->
						<!--	</div>-->
						<!--</div>-->
    			</div>
    					<hr>
						<!--<div class="row">-->
						<!--   <div class="col-sm-12">-->
    		<!--					<h4 class="form-section"><i class="icon-eye6"></i>Cash Payment Voucher</h4>-->
    		<!--				</div> -->
						<!--</div>-->
						
                        <div class="row">
						    
						    <div class="col-sm-3">
                               <div class="form-group ">
                                    <label for="adress" class=" col-form-label">Voucher Number</label>
                                    <!--<div class="col-sm-8">-->
										<input type="text" readonly class="form-control" name="fld_voucher_no" placeholder="Voucher Number" id="fld_voucher_no" value="<?php echo $editData['type'];?>-<?php echo $editData['id'];?>" readonly>
                                    <!--</div>-->
                                </div> 
                            </div>
                            <div class="col-sm-3">
                               <div class="form-group ">
                                    <label for="adress" class=" col-form-label">Code</label>
                                    <!--<div class="col-sm-8">-->
										<input type="text" readonly class="form-control" name="fld_voucher_no" placeholder="Voucher Number" id="fld_voucher_no" value="<?=$vData['coa_id'];?>" readonly>
                                    <!--</div>-->
                                </div> 
                            </div>
                            
                            <div class="col-sm-3">
                               <div class="form-group ">
                                    <label for="adress" class=" col-form-label">Voucher Type</label>
                                    <!--<div class="col-sm-8">-->
										<input type="text" readonly class="form-control" name="fld_type" placeholder="Voucher Type" id="fld_type" value="<?php echo $editData['type'];?>" readonly>
                                    <!--</div>-->
                                </div> 
                            </div>
                             <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="date" class=" col-form-label">Date <i class="text-danger">*</i>
                                    </label>
                                    <!--<div class="col-sm-8">-->
									        <input type="text" required="" class="form-control datepicker" name="date" id="date"  value="<?=date('d/m/Y', strtotime($editData['date']));?>" readonly>
                                    <!--</div>-->
                                </div>
                            </div>
        <!--                    <div class="col-sm-3">-->
        <!--                        	<div class="form-group " style="padding-top:15%;">-->
								<!--        <div class="radio radio-info form-check-inline">-->
        <!--                                    <input type="radio" id="inlineRadio1" value="1" name="pld"  href="javascript:;" checked="">-->
        <!--                                    <label for="inlineRadio1"> Profit </label>-->
        <!--                                </div>-->
        <!--                                <div class="radio form-check-inline">-->
        <!--                                    <input type="radio" id="inlineRadio2" value="2"  href="javascript:;" name="pld">-->
        <!--                                    <label for="inlineRadio2"> Loss </label>-->
        <!--                                </div>-->
        <!--                            </div>	-->
								<!--</div>-->
                        </div>
                        <h4 class="form-section"><i class="icon-eye6"></i>Voucher Details</h4>
					<hr>
						
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="Account" class=" col-form-label">Account</label>
										<input type="text" class="form-control" value="<?php echo $this->db->query("select * from tbl_coa where head_code = '{$editDataV['coa_id']}'")->row()->head_name; ?>" readonly>
                                </div>
                            </div>
         
                            
                            <div class="col-sm-3">
                                <div class="form-group ">
                                    <label for="narration" class=" col-form-label">Narration 
                                    </label>
                                    <!--<div class="col-sm-10 input-group">-->
									<!--<input type="text" required="" class="form-control" name="from_narration" id="narration" placeholder="Paymet's nature and description">-->
									<!--    <div class="tooltip1 input-group-append">-->
									<!--        <button type="button" class="btn btn-gradient-secondary btn-clipboard" onclick="myFunction()" onmouseout="outFunc()" data-clipboard-action="copy" data-clipboard-target="#clipboardInput"><i class="far fa-copy mr-2"></i><span class="tooltiptext" id="myTooltip">Copy</span></button>-->
									<!--    </div>-->
                                    <!--</div>-->
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="from_narration" id="narration" placeholder="Paymet's nature and description" readonly value="<?=$this->CI->getStringBetween($vData['narration']);?>">
                                            <div class=" input-group-append">
                                                <button type="button" class="btn tooltip1 btn-outline-light btn-sm btn-clipboard" onclick="myFunction()"  data-clipboard-action="copy" data-clipboard-target="#clipboardInput" onmouseout="outFunc()"><span class="tooltiptext" id="myTooltip">Copy copied narration</span><i class="far fa-copy"></i></button>
                                                <button type="button" class="btn tooltip1 btn-outline-light btn-sm btn-clipboard"  onclick="paste2()" onmouseout="outFunc()"><span class="tooltiptext" id="myTooltip_2">Paste this narration</span><i class="far fa-clipboard"></i></button>
                                            </div>
                                        </div>
                                </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="Account" class=" col-form-label">Account</label>
    										<input type="text" class="form-control" value="<?=$this->CI->getBalanceInner($vData['coa_id']); ?>" readonly>
                                    </div>
                                </div>
                                    <div class="col-sm-3">
                                <div class="form-group ">
                                    <label for="date" class=" col-form-label">Amount &nbsp; <i class="text-danger">*</i>
                                    </label>
                                    <!--<div class="col-sm-10">-->
									        <input type="text" required="" class="form-control" name="amount" id="amount" placeholder="0.00" value="<?=$totalAmount;?>" readonly>
                                    <!--</div>-->
                                </div>
                                </div>
                                
                            <!--</div>-->
                            <!--</div>-->
                        <!--</div>-->
					</div>
					
				
					<div class="col-sm-4">
                        <!--<div class="row">-->
                            
                        <!--            <input type="hidden" name="add-vourcher" value="1"/>-->
                        <!--            <input type="submit" id="add_vourcher" class="btn btn-successs" name="add-vourcher1"  value="Submit F10" disabled>-->
								
                            <!--</div>-->
                        <!--</div>-->
                        </div>
                        <!--</div>-->
                        <br>
                    </form>						
				<?php }?>
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