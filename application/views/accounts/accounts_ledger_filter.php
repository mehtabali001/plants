<style>

.search_filter td {
    border: none !important;
    background: #f1f5fa !important;
    color: #000;
    font-weight: bold;
}
.search_finalsum td {
    border: none !important;
    /*background: rgb(245 222 179) !important;*/
    color: white;
    font-weight: bold;
}
.totals td{
    color:#000 !important;
}
/*.even{*/
/*    color:green;*/
/*}*/
/*.odd{*/
/*    color:red;*/
/*}*/
.qclass{
    font-weight:bold;
    color:#21d0c0;
}
.bclass{
    font-weight:bold;
}
</style>
<? $role_permissions  = explode(",",$this->session->userdata('permissions')); ?>
<?php if($ledger){ ?>
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right" style="margin-bottom: 15px;">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                    <? if(!empty($role_permissions) && in_array(246,$role_permissions)) { ?>    
                    <a type="button" id="print_report" onclick="print_ledger('accounts_ledger_print');" class="btn btn-outline-primary print_report" name="" value="" disabled><i class="fa fa-print" aria-hidden="true"></i>&nbsp;Print</button>
				    <? } ?>
				    <? if(!empty($role_permissions) && in_array(247,$role_permissions)) { ?>
                    <a type="button" id="pdf_purchase_report" class="btn btn-outline-primary pdf_purchase_report" onclick="pdf_ledger('accounts_ledger_pdf');" name="" value="" disabled><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;PDF</button>
					<? } ?>
					 <a type="button" id="pdf_purchase_report" class="btn btn-outline-primary pdf_purchase_report" onclick="downloadcsv();" name="" value=""><i class="fa fa-file-csv" aria-hidden="true"></i>&nbsp;CSV</a>
                </div>
			</div>
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<? } ?>
<table id="datatable_tb" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
	<thead class="dthead tabletop">
	<tr>
		<th style="width: 4%;">#</th>
		<th>Voucher Date</th>
		<th>Vocuher Number</th>
		<th>Narration</th>
		<th>Debit</th>
		<th>Credit</th>
		<th>Balance</th>
		<th>Dr/Cr</th>
	</tr>
	</thead>


	<tbody class="ledgerRows" id="ledgerRows">
		 <?php if($ledger){
			 $i=1;
			 $b=1;
			foreach($ledger as $ledge){
			?>
    		<tr class="search_filter">
    			<td colspan="8" style="padding-left: 24%;"><?php echo $ledge['filter_text'];?></td>
    			<td style="display:none"></td>
    			<td style="display:none"></td>
    			<td style="display:none"></td>
    			<td style="display:none"></td>
    			<td style="display:none"></td>
    			<td style="display:none"></td>
    			<td style="display:none"></td>
            </tr>
            <tr>
				<td ><?php echo $i;?></td>
				<td ><?php echo date('d-m-Y',strtotime($from));?></td>
				<td >OP-0</td>
				<td style="font-weight: bold;">Opening Balance</td>
				<td></td>
				<td></td>
				<td  class="<?php if(number_format($ledge['opening'] ,2) > 0){ echo 'even';} else { echo 'odd';} ?>" style="font-weight: bold;"><?php echo number_format($ledge['opening'],2); ?></td>
				<td><?php if($ledge['opening'] > 0){ echo 'Dr';}else{ echo 'Cr'; }?></td>
			</tr>
				<?php
				
				$total_credit=0;
				$total_debit=0;
				$balance=$ledge['opening'];
				$i+=1;
				foreach($ledge['detail'] as $ledgedet){
				    $total_credit +=$ledgedet['credit'];
				    $total_debit +=$ledgedet['debit'];
				    $balance += $ledgedet['debit']-$ledgedet['credit'];
					?>
					<tr>
						<td ><?php echo $i;?></td>
						<td ><?php echo date('d-m-Y',strtotime($ledgedet['date']));?></td>
						<td >
						    <?php 
						    if($ledgedet['type']=='JV'){
        										        $url = 'view_jv_voucher'; 
        										    }else if($ledgedet['type']=='CPV'){
        										        $url = 'view_voucher'; 
        										    }else if($ledgedet['type']=='CHPV'){
        										        $url = 'view_voucher'; 
        										    }else if($ledgedet['type']=='CRV'){
        										        $url = 'view_voucher'; 
        										    }else if($ledgedet['type']=='CHRV'){
        										        $url = 'view_voucher'; 
        										    }else{
        										        $url = '#'; 
        										    }
        
        										    ?>
        										 <a href="<?php if($url=='#'){echo'javascript:void(0)';}else{echo base_url().'Vouchers/'.$url.'/'.$ledgedet['v_id'];}?>" ><?php echo $ledgedet['type'];?> - <?php echo $ledgedet['v_id'];?></a></td>
						<td ><?php if($ledgedet['type']=='Purchase'){
						echo '<a href="'.base_url().'Purchase/detail/'.$ledgedet['type_id'].'" style="text-decoration: underline;">(PB-'.sprintf('%04d', $ledgedet['type_id']).')</a> ';
						}else if($ledgedet['type']=='Navigation'){
						echo '<a href="'.base_url().'Navigations/detail/'.$ledgedet['type_id'].'" style="text-decoration: underline;">(NI-'.sprintf('%04d', $ledgedet['type_id']).')</a> ';
						}else if($ledgedet['type']=='Sale'){
						echo '<a href="'.base_url().'Sales/detail/'.$ledgedet['type_id'].'" style="text-decoration: underline;">(SI-'.sprintf('%04d', $ledgedet['type_id']).')</a> ';
						}else if($ledgedet['type']=='Expense'){
						echo '<a href="'.base_url().'Expenses/detail/'.$ledgedet['type_id'].'" style="text-decoration: underline;">(EV-'.sprintf('%04d', $ledgedet['type_id']).')</a> ';
						}else if($ledgedet['type']=='MonthlySalary' && $ledgedet['type_id'] > 0){
						echo '<a href="'.base_url().'Payroll/viewpaidsalary/'.$ledgedet['type_id'].'" style="text-decoration: underline;">(MS-'.sprintf('%04d', $ledgedet['type_id']).')</a> ';
						}?>
						
						<?php 
						$str = $ledgedet['narration'];
						if (strpos($str, 'Q') !== false || strpos($str, 'Disc.Rs') !== false || strpos($str, 'Rs') !== false || strpos($str, 'Dr Acc.') !== false || strpos($str, 'Cr Acc.') !== false) {
						   $str=str_replace("Q","<span class=\"qclass\">Q</span>",$str); 
						   $str=str_replace("Disc.Rs","<span class=\"qclass\">Disc.Rs</span>",$str); 
						   $str=str_replace("Rs","<span class=\"qclass\">Rs</span>",$str);
						   $str=str_replace("Dr Acc.","<span class=\"bclass\">Dr Acc.</span>",$str);
						   $str=str_replace("Cr Acc.","<span class=\"bclass\">Cr Acc.</span>",$str);
						   echo $str;
						}else{
						    echo $ledgedet['narration'];
						}
						?>
						</td>
						<td style="color:green;"><?php if($ledgedet['debit'] > 0){ echo number_format($ledgedet['debit'],2);}?></td>
						<td style="color:red;"><?php if($ledgedet['credit'] > 0){ echo number_format($ledgedet['credit'],2);}?></td>
						<td  class="<?php if(number_format($balance,2) > 0){ echo 'even';} else { echo 'odd';} ?>"><?php if(number_format($balance,2) > 0 || number_format($balance,2) < 0){ echo number_format($balance,2);} ?></td>
						<td><?php if($balance > 0){ echo 'Dr';}else{ echo 'Cr'; }?></td>
					</tr>
					<?php $i++; }?>
		
		<tr class="search_finalsum  tablebottom">
		    <td style="display:none"></td>
		    <td style="display:none"></td>
		    <td style="display:none"></td>
			<td colspan="4" style="text-align:right;font-weight:bold;">NET TOTAL</td>
			<td ><?= number_format($total_debit,2);?></td>
			<td ><?= number_format($total_credit,2);?></td>
			<td><?= number_format($balance,2);?></td>
			<td><?php if($balance > 0){ echo 'Dr';}else{ echo 'Cr'; }?></td>
		</tr>
		<?php
		$b++;
		}}else{?>
		<tr><td colspan="8" style="text-align:center;color:red;">Sorry No Record Found</td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td></tr>
		<?php } ?>
	</tbody>
</table>
<script>
    
    function downloadcsv(){
        //  var form = $('#ledgerFilter').serialize();
        var formdata=$('#ledgerFilter').serialize();
       var url="<?= base_url();?>/Accounts/accounts_ledger_filter_csv?"+formdata;
       window.open(url);
   }
</script>
