<style>

.search_filter td {
    background: #f1f5fa !important;
    color: #000;
    font-weight: bold;
}
.search_finalsum td {
    border: none !important;
    /*background: rgb(245 222 179) !important;*/
    color: #000;
    font-weight: bold;
}
.tablebottom td {
    /*border: none !important;*/
    
    background: rgb(108 133 229) !important;
    color: #fff;
    font-weight: bold;
    text-align:center;
}
</style>
<? $role_permissions  = explode(",",$this->session->userdata('permissions')); ?>
<?php if($gain_loss){ ?>
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right" style="margin-bottom: 15px;">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                    <? if(!empty($role_permissions) && in_array(34,$role_permissions)) { ?>
                    <a type="button" id="print_report" class="btn btn-outline-primary print_report" name="" value="" disabled><i class="fa fa-print" aria-hidden="true"></i>&nbsp;Print</a>
					<? } ?>
					<? if(!empty($role_permissions) && in_array(35,$role_permissions)) { ?>
                    <a type="button" id="pdf_purchase_report" class="btn btn-outline-primary pdf_purchase_report" name="" value="" disabled><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;PDF</a>
					<? } ?>
                    <? if(!empty($role_permissions) && in_array(221,$role_permissions)) { ?>
                    <a type="button" id="navigation_report_csv" class="btn btn-outline-primary pdf_purchase_report" disabled  onclick="downloadcsv();"><i class="fa fa-file-csv" aria-hidden="true"></i>&nbsp;CSV</a>
                    <? } ?>
                </div>
			</div>
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<? } ?>

<?php //if($filter_type == 1){?>
<table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
	<thead class="dthead tabletop">
	<tr>
		<th>#</th>
		<th>Invoice Date</th>
		<th>Invoice ID</th>
		<th>Item</th>
		<th>Plant</th>
		<th>Type</th>
		<th>Shipment</th>
		<th>Qty(KG)</th>
		<th>Rate/KG (PKR)</th>
		<th>Amount(PKR)</th>
	</tr>
	</thead>


	<tbody class="purchaseRows" id="GainLossRows">
		 <?php if($gain_loss){
			 $i=1;
			 $b=1;
			foreach($gain_loss as $gainloss){
			?>
		<tr class="search_filter">
			<td colspan="10" style="padding-left: 24%;"><?php echo $gainloss['filter_text'];?></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>

		</tr>
				<?php
				$mtqty=0;
				$kgqty=0;
				$total_amount=0;
				foreach($gainloss['detail'] as $gainlossdet){
					$mtqty=$mtqty + $gainlossdet['fld_quantity'];
					$total_amount=$total_amount + $gainlossdet['fld_total_amount'];
					$kgqty=$kgqty + ($gainlossdet['fld_quantity'] * 1000);
					if($filter_type == 1){
					   
					    
					?>
					<tr>
						<td ><?php echo $i;?></td>
						<td ><?php echo date('d-m-Y',strtotime($gainlossdet['fld_date']));?></td>
						<td ><?php echo $gainlossdet['fld_voucher_no'];?></td>
						<td ><?php echo $gainlossdet['fld_category'];?></td>
						<td ><?php echo $gainlossdet['fld_location'];?></td>
						<td ><?php if($gainlossdet['fld_type']==1){echo'Gain';}elseif($gainlossdet['fld_type']==2){echo'Loss';}elseif($gainlossdet['fld_type']==3){echo'Difference';}?></td>
						<td ><?php echo $gainlossdet['fld_shipment'];?></td>
						<td ><?php echo $gainlossdet['fld_quantity'];?></td>
						<td ><?php echo $gainlossdet['fld_unit_price'];?></td>
						<td ><?php echo $gainlossdet['fld_total_amount'];?></td>
					</tr>
					<?php $i++; }}?>
		
		<tr class="search_finalsum ">
			<td colspan="7" style="text-align:right;font-weight:bold;">Net Amount</td>
			<td ><?= number_format($mtqty,2);?></td>
			<td ><?//= number_format($kgqty,2);?></td>
			<td><?= number_format($total_amount,2);?></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
		</tr>
		<?php
		$b++;
		}}else{?>
		<tr><td colspan="10" style="text-align:center;color:red;">Sorry No Record Found</td>
		<td style="display:none;"></td>
		<td style="display:none;"></td>
		<td style="display:none;"></td>
		<td style="display:none;"></td>
		<td style="display:none;"></td>
		<td style="display:none;"></td>
		<td style="display:none;"></td>
		<td style="display:none;"></td>
		<td style="display:none;"></td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<script>
  
   function downloadcsv(){
        //  var form = $('#ledgerFilter').serialize();
        var formdata=$('#GlFilter').serialize();
       var url="<?php echo base_url(); ?>Gain_loss/filter_csv?"+formdata;
       window.open(url);
   }
</script>
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