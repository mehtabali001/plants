<style>
h3{
    text-align:center;
}
/*p{*/
/*    text-align:center;*/
/*}*/
.search_filter td {
    /*border: none !important;*/
    color: #000;
    font-weight: bold;
}
td {
    border: 1px solid #aba9a9fa !important;
    color: #000;
    /*font-weight: bold;*/
    padding: 7px;
}
.desc{
    font-size:12px;
}
.table thead th{
    border:1px solid #aba9a9fa;
}
.text-center{
    text-align:center;
}
.text-right{
    text-align:right;
}
@media print {
    th {  padding: 5px; color:#000; font-weight:bold;}
}
</style>
<!--<div style="margin:3%;">-->
    <div style="float:right;margin-top:2%;">
        <span style="font-weight:bold;font-size:14px;">Shipment<br></span><span class="toDate" style="font-size:14px;"><?php echo $_GET['shipment_id']; ?></span><br>
    </div>
    <!--<img class="company-logo" src="<?= base_url()?>assets/custom_elements/images/logoreport.png" style="height:100px;float:left;">-->
    <? $settings=$this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row_array();?>
                <img class="company-logo" src="<?=base_url()?>/assets/uploads/logo/<?=$settings['system_logo'];?>" style="height:100px;float:left;">
<hr style="width:100%;">
    <!--<p style=" text-align: center;font-weight: bold;position: relative;"><?=$start_date?>&nbsp;&nbsp;&nbsp;<span>To</span>&nbsp;&nbsp;&nbsp;<?=$end_date?></p>-->
<table id="datatable_tb" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
	
<thead class="dthead">
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
						<td ><?=number_format($balance2,2);?></td>
					</tr>
					<?php $i++; }?>
		
		<tr class="search_finalsum">
			<td colspan="6" style="text-align:right;font-weight:bold;">NET TOTAL</td>
			<td ><?= number_format($total_qty_in,2);?></td>
			<td ><?= number_format($total_qty_out,2);?></td>
			<td ><?= number_format($balance1,2);?></td>
			<td ><?= number_format($total_weight_in,2);?></td>
			<td ><?= number_format($total_weight_out,2);?></td>
			<td ><?= number_format($balance2,2);?></td>
		</tr>
		<?php
		$b++;
		}}else{?>
		<tr><td colspan="12" style="text-align:center;color:red;">Sorry No Record Found</td></tr>
		<?php } ?>
	</tbody>
</table>
<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				<div class="row-fluid">
					<div class="span12">
						<table class="signature-fields" style="width:100%;">
							<thead>
								<tr>
									<th style="color:black;background-color : white !important;border-top: 1px solid black; border-left: 1px solid white; border-right: 1px solid white; border-bottom: 1px solid white;width:33%;">Prepared By</th>
									<th style="    background-color : white !important;    border-top: 1px solid white;width:33%;"></th>
									<th style="color:black;background-color: white !important;border-top: 1px solid black; border-left: 1px solid white; border-right: 1px solid white; border-bottom: 1px solid white;width:33%;">Received By</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
				<div class="bel">
		    <p style="position: sticky;font-style: italic; bottom: 0; color:#5d5d5d;"><span style="font-weight:bold;">Note:</span> This is auto generated report on <?= date('d - M - Y'); ?>, <?= date('h:i A'); ?> by <?= $this->session->userdata('user_name'); ?> account  and requires signature from the approval authority.</p>
		    </div>
<script>
    	window.print();
</script>
<!--</div>-->