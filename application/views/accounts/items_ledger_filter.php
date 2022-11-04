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
.dataTables_filter{
    float:right;
}
.search_filter  td {
    padding-top: 10px;
    padding-bottom: 10px;
}
.tablebottom td {
    padding-top: 10px;
    padding-bottom: 10px;
    font-size: 10px !important;
}
.tabletop th{
    padding-top: 10px;
    padding-bottom: 10px;
    font-size: 10px !important;
    font-weight:bold;
}
</style>
<?php if($ledger){?>
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right" style="margin-bottom: 15px;">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                    <?// if(!empty($role_permissions) && in_array(249,$role_permissions)) { ?>
                        <button type="button" style="background-color: DodgerBlue;" id="print_report" onclick="print_ledger('items_ledger_print');" class="btn  btn-outline-primary" name="" value="" ><i class="fa fa-print" aria-hidden="true"></i>&nbsp;Print</button>
					<?// } ?>
					<? //if(!empty($role_permissions) && in_array(250,$role_permissions)) { ?>
                        <button type="button" id="pdf_purchase_report" class="btn btn-outline-primary pdf_purchase_report" onclick="pdf_ledger('items_ledger_pdf');" name="" value="" ><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;PDF</button>
						<?// } ?>
                    <?// if(!empty($role_permissions) && in_array(251,$role_permissions)) { ?>
    						<button type="button" id="item_ledger_csv" class="btn btn-outline-primary" onclick="downloadcsv();"  name="" value=""><i class="fas fa-file-csv"></i>&nbsp;CSV</button>
    					<? //} ?>
                </div>
			</div>
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<?}?>
<table id="datatable_tb" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
	<thead class="dthead tabletop">
	<tr>
		<th style="width: 4%;">#</th>
		<th>Voucher Date</th>
		<th>Voucher Number</th>
		<th>Account</th>
		<th>Remarks</th>
		<th>Location</th>
		<th>Qty In</th>
		<th>Qty Out</th>
		<th>Balance</th>
		<th>Weight In</th>
		<th>Weight Out</th>
		<th>Balance</th>
	</tr>
	</thead>


	<tbody class="ledgerRows" id="ledgerRows">
		 <?php if($ledger){
			 $i=1;
			 $b=1;
			foreach($ledger as $ledge){
			?>
    		<tr class="search_filter">
    			<td colspan="12" style="padding-left: 24%;"><?php echo $ledge['filter_text'];?> - <?php echo $ledge['detail'][0]['fld_shipment']; ?></td>
    			<td style="display:none"></td>
    			<td style="display:none"></td>
    			<td style="display:none"></td>
    			<td style="display:none"></td>
    			<td style="display:none"></td>
    			<td style="display:none"></td>
    			<td style="display:none"></td>
    			<td style="display:none"></td>
    			<td style="display:none"></td>
    			<td style="display:none"></td>
    			<td style="display:none"></td>
            </tr>
				<?php
				
				$total_qty_in=0;
				$total_qty_out=0;
				$total_weight_in=0;
				$total_weight_out=0;
				$balance1=0;
				$balance2=0;
				foreach($ledge['detail'] as $ledgedet){
				    $total_qty_in +=$ledgedet['qty_in'];
				    $total_qty_out +=$ledgedet['qty_out'];
				    $total_weight_in +=$ledgedet['weight_in'];
				    $total_weight_out +=$ledgedet['weight_out'];
				    $balance1 = $balance1+$ledgedet['qty_in']-$ledgedet['qty_out'];
				    $balance2 = $balance2+$ledgedet['weight_in']-$ledgedet['weight_out'];
					?>
					<tr>
						<td ><?php echo $i;?></td>
						<td ><?php echo date('d-m-Y',strtotime($ledgedet['date']));?></td>
						<td ><?php echo $ledgedet['vr_no'];?></td>
						<td ><?php echo $ledgedet['account'];?></td>
						<td ><?php echo $ledgedet['remarks'];?></td>
						<td ><?php echo $ledgedet['location'];?></td>
						<td ><?php echo $ledgedet['qty_in'];?></td>
						<td ><?php echo $ledgedet['qty_out'];?></td>
						<td ><?=$balance1;?></td>
						<td ><?php echo $ledgedet['weight_in'];?></td>
						<td ><?php echo $ledgedet['weight_out'];?></td>
						<td ><?=round($balance2);?></td>
					</tr>
					<?php $i++; }?>
		
		<tr class="search_finalsum tablebottom">
			<td colspan="6" style="text-align:right;font-weight:bold;">NET TOTAL</td>
			<td ><?= number_format($total_qty_in,2);?></td>
			<td ><?= number_format($total_qty_out,2);?></td>
			<td ><?= number_format($balance1,2);?></td>
			<td ><?= number_format($total_weight_in,2);?></td>
			<td ><?= number_format($total_weight_out,2);?></td>
			<td ><?= round($balance2);?></td>
			<td style="display:none"></td>
			<td style="display:none"></td>
			<td style="display:none"></td>
			<td style="display:none"></td>
			<td style="display:none"></td>
		</tr>
		<?php
		$b++;
		}}else{?>
		<tr><td colspan="12" style="text-align:center;color:red;">Sorry No Record Found</td></tr>
		<td style="display:none"></td>
		<td style="display:none"></td>
		<td style="display:none"></td>
		<td style="display:none"></td>
		<td style="display:none"></td>
		<td style="display:none"></td>
		<td style="display:none"></td>
		<td style="display:none"></td>
		<td style="display:none"></td>
		<td style="display:none"></td>
		<td style="display:none"></td>
		<?php } ?>
	</tbody>
</table>
