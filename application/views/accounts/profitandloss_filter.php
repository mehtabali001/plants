<style>
.datatable_tb_filter{
    float: right;
}
.search_filter td {
    border: none !important;
    background: rgb(241 245 250) !important;
    /*background: rgb(108 133 229) !important;*/
    color: black;
    font-weight: bold;
}
.search_finalsum td {
    border: none !important;
    /*background: rgb(245 222 179) !important;*/
    color: #fff;
    font-weight: bold;
}
.table-bordered thead th {
    border: 1px;
    font-size: 9px !important;
}
.table th, .table td {
    padding: 0.3rem !important;
}
.total td{
    color:black !important;
}
</style>
<? $role_permissions  = explode(",",$this->session->userdata('permissions')); ?>
<?php //if($navigation){ ?>
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right" style="margin-bottom: 15px;">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                    <? if(!empty($role_permissions) && in_array(234,$role_permissions)) { ?>
                        <a type="button" id="print_report" class="btn btn-outline-primary print_report" name="" value="" disabled onclick="printProfitandlossReport(1);" ><i class="fa fa-print" aria-hidden="true"></i>&nbsp;Print</a>
						<? } ?>
						<? if(!empty($role_permissions) && in_array(235,$role_permissions)) { ?>
                        <a type="button" id="pdf_purchase_report" class="btn btn-outline-primary pdf_purchase_report" name="" value="" disabled onclick="printProfitandlossReport();"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;PDF</a>
						<? } ?>
					    <? if(!empty($role_permissions) && in_array(236,$role_permissions)) { ?>
                        <a type="button" id="profitandloss_csv" class="btn btn-outline-primary pdf_purchase_report" disabled onclick="downloadcsv();"  name="" value=""><i class="fas fa-file-csv"></i>&nbsp;CSV</a>
                        <? } ?>
                </div>
			</div>
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<? //} ?>
<?php //if($filter_type == 1){?>
<table id="datatable_tb" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
	<thead class="dthead tabletop">
	<tr>
		<!--<th>#</th>-->
		<th>Invoice Date</th>
		<th>Invoice Id</th>
		<th>Account</th>
		<th>Item</th>
		<th>Qty<br>(KG)</th>
		<th>Weight<br>(KG)</th>
		<th>Rate<br>(PKR)</th>
		<th>Discount<br>(PKR)</th>
		<th>Amount<br>(PKR)</th>
		<th>Cost<br>(PKR)</th>
		<th>Profit/Unit<br>(PKR)</th>
		<th>Profit<br>(PKR)</th>
		<th>P&L<br>%</th>
	</tr>
	</thead>


	<tbody class="purchaseRows" id="purchaseRows">
		 <?php if($sales){
			 $i=1;
			 $b=1;
			 $amtqty=0;
			 $akgqty=0;
			 $atdiscount=0;
			 $total_all_amount = 0;
			 $total_all_profit = 0;
			foreach($sales as $sale){
			?>
		<tr class="search_filter">
			<td colspan="13" style="padding-left: 24% !important;"><?php echo $sale['filter_text'];?></td>
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
			<td style="display:none"></td>

		</tr>
				<?php
				$mtqty=0;
				$kgqty=0;
				$tdiscount=0;
				$total_amount=0;
				$total_profit = 0;
				foreach($sale['detail'] as $saledet){
					$mtqty=$mtqty + $saledet['fld_quantity'];
					$tdiscount+=$saledet['fld_discount'];
					$total_amount=$total_amount + $saledet['fld_total_amount']-$saledet['fld_discount'];
					$kgqty=$kgqty +$saledet['fld_weight'];
					$total_profit += round(($saledet['fld_total_amount']-$saledet['fld_discount'])-$saledet['fld_purchase_amount'],2);
					if($filter_type == 1){
					    $subcat = '';
					    if($saledet['fld_subproduct_id'] != '0'){
					        $subcat = ' - '.$this->db->query("select * from tbl_subcategory where fld_subcid = '{$saledet['fld_subproduct_id']}'")->row()->fld_subcategory;
					    }
					?>
					<tr>
						<!--<td ><?php echo $i;?></td>-->
						<td ><?php echo date('d-m-Y',strtotime($saledet['fld_sale_date']));?></td>
						<td ><?php echo $saledet['fld_voucher_no'];?></td>
						<td ><?php echo $saledet['fld_customer_name'];?></td>
						<td ><?php echo $saledet['fld_category'].$subcat;?></td>
						<td ><?php echo $saledet['fld_quantity'];?></td>
						<td ><?php echo $saledet['fld_weight'];?></td>
						<td ><?php echo round($saledet['fld_unit_price']);?></td>
						<td ><?php echo round($saledet['fld_discount']);?></td>
						<td ><?php echo round($saledet['fld_total_amount']-$saledet['fld_discount']);?></td>
						<td ><?php echo round($saledet['fld_purchase_amount']/$saledet['fld_quantity']);?></td>
						<td ><?php echo round((($saledet['fld_total_amount']-$saledet['fld_discount'])-$saledet['fld_purchase_amount'])/$saledet['fld_quantity']);?></td>
						<td ><?php echo round(($saledet['fld_total_amount']-$saledet['fld_discount'])-$saledet['fld_purchase_amount']);?></td>
						<td >
						<?php 
						if($saledet['fld_purchase_amount'] > 0){
						echo round((((($saledet['fld_total_amount']-$saledet['fld_discount'])-$saledet['fld_purchase_amount'])) * 100) / ($saledet['fld_total_amount']-$saledet['fld_discount']),2);
						}
						?>
						</td>
						
					</tr>
					<?php $i++; }}?>
		
		<tr class="search_finalsum total">
			<td colspan="4" style="text-align:right;font-weight:bold;">TOTAL</td>
			<td style="display:none"></td>
			<td style="display:none"></td>
			<td style="display:none"></td>
			<td ><?= number_format($mtqty,2);?></td>
			<td ><?= number_format($kgqty,2);?></td>
			<td>&nbsp;</td>
			<td><?= number_format(round($tdiscount));?></td>
			<td><?= number_format(round($total_amount));?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><?= number_format(round($total_profit));?></td>
			<td>&nbsp;</td>
			
		</tr>
		<?php
		$total_all_amount += $total_amount;
		$atdiscount += $tdiscount;
		$akgqty += $kgqty;
		$amtqty += $mtqty;
		$total_all_profit += $total_profit;
		$b++;
		} ?>
		<!--<tfoot class="">-->
		    <tr class="search_finalsum tablebottom">
    			<td colspan="4" style="text-align:right;font-weight:bold;">NET TOTAL</td>
    			<td style="display:none"></td>
    			<td style="display:none"></td>
    			<td style="display:none"></td>
    			<td ><?= number_format($amtqty,2);?></td>
    			<td ><?= number_format($akgqty,2);?></td>
    			<td>&nbsp;</td>
    			<td><?= number_format(round($atdiscount));?></td>
    			<td><?= number_format(round($total_all_amount));?></td>
    			<td>&nbsp;</td>
    			<td>&nbsp;</td>
    			<td><?= number_format(round($total_all_profit));?></td>
    			<td>&nbsp;</td>
    		</tr>
		<!--</tfoot>-->
		
		
		
		<?php }else{?>
		<tr><td colspan="13" style="text-align:center;color:red;">Sorry No Record Found</td>
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
		<td style="display:none"></td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<?php //}?>
<?php /*if($filter_type == 2){?>
<table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
	<thead>
	<tr>
		<th>Sr#</th>
		<th>Date</th>
		<th>Vr#</th>
		<th>Account</th>
		<th>Item</th>
		<th>Remarks</th>
		<th>Qty(MT)</th>
		<th>Weight</th>
		<th>Rate</th>
		<th>Amount</th>
	</tr>
	</thead>


	<tbody>
		 <?php if($purchase){
			 $i=1;
			foreach($purchase as $purch){
			?>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td colspan="7"><?php echo $purch['fld_voucher_no'];?></td>
			
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td><?php echo $purch['fld_voucher_no'];?></td>
			<td></td>
			<td></td>
			<td></td>
			<td><?php echo $purch['fld_quantity'];?></td>
			<td><?php echo ((int)$purch['fld_quantity'] > 0)?(int)$purch['fld_quantity'] * 1000:0;?></td>
			<td></td>
			<td><?php echo $purch['fld_total_amount'];?></td>
			
		</tr>
		<?php
		$i++;
		}}else{?>
		<tr><td colspan="10" style="text-align:center;">No Record Found</td></tr>
		<?php }
		?>
	
	</tbody>
</table>
<?php }*/?>