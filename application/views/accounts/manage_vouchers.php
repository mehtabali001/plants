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
</style>
<? $role_permissions  = explode(",",$this->session->userdata('permissions')); ?>
<div class="container-fluid">
    <div class="row">
    	<div class="col-sm-12">
    		<div class="page-title-box">
    		    <div class="float-right" style="margin-bottom:15px;">
        			<div class="btn-group" role="group" aria-label="Basic outlined example">
                      <a href="<?= base_url();?>Vouchers/manage_voucher" type="button" class="btn btn-primary btn-large"><i class="fa fa-eye"></i>&nbsp;View Voucher</a>
                      <a href="<?= base_url();?>Vouchers/chequepaidvoucher" type="button" class="btn btn-outline-primary"><i class="fa fa-vcard"></i>&nbsp;New Cheque Paid Voucher</a>
                      <a href="<?= base_url();?>Vouchers/journalvoucher" type="button" class="btn btn-outline-primary"><i class="fa fa-files-o"></i>&nbsp;New Journal Voucher</a>
                      <a href="<?= base_url();?>Accounts/balancesheet" type="button" class="btn btn-outline-primary"><i class="fa fa-bar-chart"></i>&nbsp;COA</a>
                    </div>
    			</div>
    			<!--<h4 class="page-title">View Voucher(s)</h4>-->
    			<!--<ol class="breadcrumb">-->
    			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Vouchers</a></li>-->
    			<!--	<li class="breadcrumb-item active">View Voucher(s)</li>-->
    			<!--</ol>-->
    		</div><!--end page-title-box-->
    	</div><!--end col-->
    </div><!-- end page title end breadcrumb -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
    				<div class="row" id="purchasediv">
    				<div class="col-lg-12">
    				<?php $error_message = $this->session->userdata('error_message');
    				     if (isset($error_message)) {
    				?>
    					<div class="alert alert-danger">
    						<?php echo $error_message ?>                    
    					</div>
    				<?php
    					$this->session->unset_userdata('error_message');
    				} ?>
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
            				<div class="panel-body" style="width:100%;padding: 0px 13px;">
            				<form id="ledgerFilter" >
                                    <input type="hidden" name="filter_type" id="filter_type" value="1" />
            						<div class="col-sm-12">
            							<h4 class="form-section"><i class="icon-eye6"></i>Manage Vouchers</h4>
            						</div>
            						<hr>
                                    <div class="row">
                                        <div class="col-sm-3">
            								<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="voucher_type" id="voucher_type" required>
            										<option value="all">All</option>
            										<?php
            										$voucher_types = $this->db->query("SELECT * FROM tbl_transections_master GROUP by type order by type")->result_array();
            										foreach($voucher_types as $type){ ?>
            									      <option value="<?php echo $type['type']; ?>" <?php if(isset($_GET['voucher_type']) && $_GET['voucher_type']== $type['type']){echo 'selected'; } ?>><?php echo $type['type']; ?></option>
            									    <?php } ?>
            								</select>
            							</div>
            							<div class="col-sm-4">
            								<div class="form-group input-group ">      
            									<div class="input-group-append">
            										<span class="input-group-text" style="background-color: #506ee4;border: 1px solid #506ee4;color:#FFF;">Voucher Code</span>
            									</div>                                     
            									<input type="text" class="form-control" name="voucher_code" id="voucher_code" value="<?php if(isset($_GET['voucher_code']) && !empty($_GET['voucher_code'])){echo $_GET['voucher_code'];} ?>">	
            								</div>   
                                        </div>
            							<div class="col-sm-5">
            							    <button type="button" id="show_report" class="btn btn-successs btn-large show_report" name="show-report" value="" onclick="this.form.submit();"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Proceed</button>
            							    <button type="button" id="reset_filters" class="btn btn-danger" name="" value="" onclick="window.location.href='<?= base_url(); ?>Vouchers/manage_voucher'"><i class="fa fa-refresh" aria-hidden="true" ></i>&nbsp;Reset</button>
            							</div>
                                    </div>
                                </form>
            				</div>
            				</div>
    										
                                        <table id="datatable_tb" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead class="tabletop">
                                            <tr>
                                                <th>Voucher Date</th>
                                                <th>Voucher Code</th>
                                                <th>Voucher Type</th>
                                                <th>Total (PKR)</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
    										<?php 
    										    if($vouchers){
    											foreach($vouchers as $voucher){
    										?>
                                            <tr>
                                                <td><?= date('d-M-Y',strtotime($voucher['date']));?></td>
                                                <td><?= $voucher['type'];?> - <?= $voucher['id'];?></td>
                                                <td><?php if($voucher['type']=='JV'){
            										        $type = 'Journal Voucher'; 
            										    }else if($voucher['type']=='CPV'){
            										        $type = 'Cash Payment Voucher'; 
            										    }else if($voucher['type']=='CHPV'){
            										        $type = 'Cheque Payment Voucher'; 
            										    }else if($voucher['type']=='CRV'){
            										        $type = 'Cash Receive Voucher'; 
            										    }else if($voucher['type']=='CHRV'){
            										        $type = 'Cheque Receive Voucher'; 
            										    }else if($voucher['type']=='PLD'){
            										        $type = 'Profit Loss Division Voucher'; 
            										    }else{
            										        $type = $voucher['type'];
            										    }
            										    echo $type;
            										    
            										    if($voucher['post_status']==1){ echo ' <span style="color:red">(Unpost)</span>'; }
            										?></td>
                                                <td>
                                                    <?
                                                    $editDataV = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$voucher['id'], 'debit>'=>0))->get();
                                                    $editDataDetails  = $this->db->select('*')->from('tbl_transections_details')->where(array('v_id'=>$voucher['id'], 'credit>'=>0))->get()->row();
                                                    // if($voucher['type'] == 'CRV' || $voucher['type'] == 'CHRV'){
                                                    //     $amount=$editDataDetails->credit;
                                                    // }else{
                                                    if($editDataV->num_rows()){
                                                        $amount=$editDataV->row()->debit;
                                                        echo $amount;
                                                    }else{
                                                        echo 0;
                                                    }
                                                        
                                                    // }
                                                    //$totalAmount += $amount;
                                                    
                                                    ?>
                                                </td>
                                                <td>
    										      <?php 
    										          if($voucher['type']=='JV'){
            										        $url = 'journalvoucher'; 
            										    }else if($voucher['type']=='CPV'){
            										        $url = 'cashpayementvoucher'; 
            										    }else if($voucher['type']=='CHPV'){
            										        $url = 'chequepayementvoucher'; 
            										    }else if($voucher['type']=='CRV'){
            										        $url = 'cashreceivevoucher'; 
            										    }else if($voucher['type']=='CHRV'){
            										        $url = 'chequereceivevoucher'; 
            										    }else if($voucher['type']=='PLD'){
            										        $url = 'pldvoucher'; 
            										    }else{
            										        $url = 'all'; 
            										    }
            										?>
            										<?php 
            										if($voucher['type']=='JV'){ ?>
            										<? if(!empty($role_permissions) && in_array(186,$role_permissions)) { ?>
            										        	<a href="<?=base_url();?>Vouchers/print_jv_voucher/<?=$voucher['id'];?>" target="_blank">
    											                <i style="font-size:15px;cursor:pointer;" class="fa fa-print"title="print"></i>
        											            </a>
        											<? } } else if ($voucher['type']=='PLD'){ ?> 
        											    <a href="<?=base_url();?>Vouchers/print_pldvoucher/<?=$voucher['id'];?>" target="_blank">
    											                <i style="font-size:15px;cursor:pointer;" class="fa fa-print"title="print"></i>
        											            </a>
            										    <?php }else if ($voucher['type']=='CPV' || $voucher['type']=='CHPV' || $voucher['type']=='CRV' || $voucher['type']=='CHRV' ){ ?>
            										        <? if(!empty($role_permissions) && in_array(186,$role_permissions)) { ?>
            										        <a href="<?=base_url();?>Vouchers/print_voucher/<?=$voucher['id'];?>" target="_blank">
    											                <i style="font-size:15px;cursor:pointer;"class="fa fa-print" title="print"></i>
        											</a>
        											<? } ?> 
            										   <?php  }
            										?>
            										<?php 
            										if($voucher['type']=='JV'){ ?>
            										<? if(!empty($role_permissions) && in_array(187,$role_permissions)) { ?>
            										        	<a href="<?=base_url();?>Vouchers/pdf_jv_voucher/<?=$voucher['id'];?>" target="_blank">
    											                <i style="font-size:15px;cursor:pointer;" class="fa fa-file-pdf-o"title="pdf"></i>
        											</a>
        										<?} } else if ($voucher['type']=='PLD'){ ?> 
        											    	<a href="<?=base_url();?>Vouchers/pdf_pldvoucher/<?=$voucher['id'];?>" target="_blank">
    											                <i style="font-size:15px;cursor:pointer;" class="fa fa-file-pdf-o"title="pdf"></i>
        											</a>
            										    <?php }else if ($voucher['type']=='CPV' || $voucher['type']=='CHPV' || $voucher['type']=='CRV' || $voucher['type']=='CHRV' ){ ?>
            										    <? if(!empty($role_permissions) && in_array(187,$role_permissions)) { ?>    
            										        <a href="<?=base_url();?>Vouchers/pdf_voucher/<?=$voucher['id'];?>" target="_blank">
    											                <i style="font-size:15px;cursor:pointer;"class="fa fa-file-pdf-o" title="pdf"></i>
        											</a>
        											<? } ?>
            										   <?php } ?>
            										
            										<?php if($url == 'all'){ ?>
            										<? if(!empty($role_permissions) && in_array(179,$role_permissions)) { ?>
            										    <!--<a href="<?=base_url();?>Vouchers/delete/<?=$voucher['id'];?>" onclick="return confirm('Are you sure you want to delete this record.')">
            							                    <i style="font-size:15px;cursor:pointer;" class="mdi mdi-delete-forever" title="Delete"></i>
            							                </a>-->
            							            <?php } ?>       
            										<?php }else{ ?>
            										<? if(!empty($role_permissions) && in_array(181,$role_permissions)) { ?>
            										<?php 
            										if($voucher['type']=='JV'){ ?>
            										        	<a href="<?=base_url();?>Vouchers/view_jv_voucher/<?=$voucher['id'];?>">
    											                <i style="font-size:15px;cursor:pointer;" class="fa fa-eye"title="view"></i>
        											</a>
            										    <?php }else if ($voucher['type']=='PLD'){ ?>
            										        <a href="<?=base_url();?>Vouchers/view_pld_voucher/<?=$voucher['id'];?>">
    											                <i style="font-size:15px;cursor:pointer;"class="fa fa-eye" title="view"></i>
        											</a>
            										   <?php  } else if ($voucher['type']=='CPV' || $voucher['type']=='CHPV' || $voucher['type']=='CRV' || $voucher['type']=='CHRV' || $voucher['type']=='PLD' ){ ?>
            										        <a href="<?=base_url();?>Vouchers/view_voucher/<?=$voucher['id'];?>">
    											                <i style="font-size:15px;cursor:pointer;"class="fa fa-eye" title="view"></i>
        											</a>
            										   <?php  } ?>
            										<?php  } ?>   
            										<? if(!empty($role_permissions) && in_array(180,$role_permissions)) { ?>   
            						            	<a href="<?=base_url();?>Vouchers/<?=$url;?>/edit/<?=$voucher['id'];?>" target="_blank">
    											        <i style="font-size:20px;cursor:pointer;" class="mdi mdi-square-edit-outline" title="edit"></i>
        											</a>
        											<?php } ?>
        											<a href="<?=base_url();?>Vouchers/<?=$url;?>/duplicate/<?=$voucher['id'];?>" target="_blank">
    											        <i style="font-size:15px;cursor:pointer;color:#303e67;" class="fa fa-copy" title="duplicate"></i>
        											</a>
        											<? /*if(!empty($role_permissions) && in_array(179,$role_permissions)) { ?>
        											<a href="<?=base_url();?>Vouchers/<?=$url;?>/delete/<?=$voucher['id'];?>" onclick="return confirm('Are you sure you want to delete this record.')">
        							                    <i style="font-size:15px;cursor:pointer;" class="mdi mdi-delete-forever" title="Delete"></i>
        							                </a>
        							                <?php }*/ ?>
            										<?php } ?>
    											</td>
                                            </tr>
    										<?php } } ?>
                                            </tbody>
                                        </table>
        
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->
</div>

                