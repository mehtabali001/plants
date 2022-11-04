<style>

.search_filter td {
    border: none !important;
    background: rgb(108 133 229) !important;
    color: white;
    font-weight: bold;
}
.search_finalsum td {
    border: none !important;
    background: rgb(245 222 179) !important;
    color: black;
    font-weight: bold;
}
</style>
<?php //if($filter_type == 1){?>
<table  class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
	<thead class="dthead">
	<tr>
		<th>Sr#</th>
		<th>Date</th>
		<th>Vr#</th>
		<th>Account</th>
		<th>Item</th>
		<th>Remarks</th>
		<th>Qty(MT)</th>
		<th>Weight(KG)</th>
		<th>Rate/MT</th>
		<th>Amount(Pkr)</th>
	</tr>
	</thead>


	<tbody class="purchaseRows" id="purchaseRows">
		 <?php if($purchase){
			 $i=1;
			 $b=1;
			foreach($purchase as $purch){
			?>
		<!--<tr class="search_filter">-->
			<!--<td style="display:none;"></td>-->
			<td colspan="10" style="padding-left: 24%;font-weight:bold;"><?php echo $purch['filter_text'];?></td>
			<!--<td style="display:none;"></td>-->
			<!--<td style="display:none;">Search</td>-->
			<!--<td style="display:none;"></td>-->
			<!--<td style="display:none;">New</td>-->
			<!--<td style="display:none;"></td>-->
			<!--<td style="display:none;"></td>-->
			<!--<td style="display:none;"></td>-->
			<!--<td style="display:none;">Test</td>-->

		<!--</tr>-->
		
		<!--<tr>-->
		<!--<td colspan="10" style="padding: 0;" class="printRemove">-->
		<!--	<table style="width: 100%;">-->
		<!--		<tbody>-->
				<?php
				$mtqty=0;
				$kgqty=0;
				$total_amount=0;
				foreach($purch['detail'] as $purdet){
					$mtqty=$mtqty + $purdet['fld_quantity'];
					$total_amount=$total_amount + $purdet['fld_total_amount'];
					$kgqty=$kgqty + ($purdet['fld_quantity'] * 1000);
					if($filter_type == 1){
					?>
					<tr>
						<td ><?php echo $i;?></td>
						
						<td ><?php echo date('d-M-Y',strtotime($purdet['fld_purchase_date']));?></td>
						<td ><?php echo $purdet['fld_voucher_no'];?></td>
						<td ><?php echo $purdet['fld_supplier_name'];?></td>
						<td ><?php echo $purdet['fld_category'];?></td>
						<td ><?php echo $purdet['fld_shipment'];?></td>
						<td ><?php echo $purdet['fld_quantity'];?></td>
						<td ><?php echo ((int)$purdet['fld_quantity'] > 0)?(int)$purdet['fld_quantity'] * 1000:0;?></td>
						<td ><?php echo $purdet['fld_unit_price'];?></td>
						<td ><?php echo $purdet['fld_total_amount'];?></td>
					</tr>
					<?php $i++; }}?>
		<!--		</tbody>-->
		<!--	</table>-->
		<!--</td>-->
		<!--<td style="display:none;">New</td>-->
		<!--<td style="display:none;"></td>-->
		<!--<td style="display:none;"></td>-->
		<!--<td style="display:none;"></td>-->
		<!--<td style="display:none;">Test</td>-->
		<!--<td style="display:none;">New</td>-->
		<!--<td style="display:none;"></td>-->
		<!--<td style="display:none;"></td>-->
		<!--<td style="display:none;"></td>-->
		<!--<td style="display:none;">Test</td>	-->
			
		<!--</tr>-->
		
		<!--<tr class="search_finalsum">-->
		<!--	<td style="display:none;"></td>-->
			<td colspan="7" style="text-align:right;font-weight:bold;">TOTAL</td>
			<td ><?= number_format($mtqty,2);?></td>
			<td ><?= number_format($kgqty,2);?></td>
			<td><?= number_format($total_amount,2);?></td>
			<!--<td style="display:none;">New</td>-->
			<!--<td style="display:none;"></td>-->
			<!--<td style="display:none;"></td>-->
			<!--<td style="display:none;"></td>-->
			<!--<td style="display:none;">Test</td>-->

		<!--</tr>-->
		<?php
		$b++;
		}}else{?>
		<tr><td colspan="10" style="text-align:center;color:red;">Sorry No Record Found</td></tr>
		<?php }
		?>
	
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