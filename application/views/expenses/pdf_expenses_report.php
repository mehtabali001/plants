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

.table thead th{
    border:1px solid #aba9a9fa;
}
.table-borderless td{
    border:0px !important;
}
.text-center{
    text-align:center;
}
.text-right{
    text-align:right;
}
.detail span{
    text-align:left;
}
.text-left{
    text-align:left;
}
.detail span{
    font-size:12px;
}
@media print {
    /*th {  padding: 5px; color:#000; font-weight:bold;}*/
.detail span{
    text-align:left;
    font-size:10px !important;
}
.desc{
    font-size:10px;
    font-weight:100;
}
}
</style>
<table class="table table-borderless">
    <tbody>
        <tr>
            <? $settings=$this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row_array();?>
            <td style="width:66%;text-align:left">
                <img class="company-logo" src="<?=base_url()?>/assets/uploads/logo/<?=$settings['system_logo'];?>" style="height:70px;float:left;">
            </td>
            ?>
            <td>
                <div class="detail text-left" >
                     <span style="font-weight:bold;font-size:10px;">&nbsp;Type:</span>&nbsp;<span class="" style="font-size:10px;">Expense Report</span><br>
                     <span style="font-weight:bold;font-size:10px;">&nbsp;Showing Report As:</span>&nbsp;<span style="font-size:10px;"><?php echo str_replace('_', ' ', $_GET['filter']); ?>, <?php if($_GET['type']==1){echo 'Detailed';}else{echo 'Summary';} ?> </span> <br>
                     <span style="font-weight:bold;font-size:10px;">&nbsp;From:</span>&nbsp;<span class="fromDate" style="font-size:10px;"><?php echo $_GET['form']; ?></span><br>
                     <span style="font-weight:bold;font-size:10px;">&nbsp;To:</span>&nbsp;<span class="toDate" style="font-size:10px;"><?php echo $_GET['to']; ?></span>
                </div>
            </td>
        </tr>
    </tbody>
</table>

<hr style="width:100%;">
<table class="table " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
	<thead class="dthead">
	<tr>
		<th>Date</th>
		<th>Vr#</th>
		<th>Type/Value</th>
		<th>Item - Qty</th>
		<th>Remarks</th>
		<th>Plant (Paid From)</th>
		<th>Amount(PKR)</th>
	</tr>
	</thead>
<tbody class="expenseRows" id="expenseRows">
		 <?php 
		 if($expense){
			 $i=1;
			 $b=1;
			 $nettotal_amount=0;
			foreach($expense as $expens){
			?>
		<tr class="search_filter">
			<td colspan="7" style="padding-left: 24%;color:black;font-weight:bold;"><?php echo $expens['filter_text'];?></td>
		</tr>
		<?php
		$mtqty=0;
		$kgqty=0;
		$total_amount=0;
		
		foreach($expens['detail'] as $expensdet){
			$mtqty=$mtqty + $expensdet['quantity']; 	 
			$total_amount=$total_amount + $expensdet['unit_price'];
			if($filter_type == 1){
			     $unit = $this->Common_model->select_single_field('fld_unit','tbl_units',array('fld_id'=>$expensdet['unit']));
			     $plantfrom =	$this->Common_model->select_single_field('head_name','tbl_coa',array('head_code'=>$expensdet['plant_from']));
			     if($expensdet['expense_type'] == 1){
					$exptype = "Office Expense";
				}else{
					$exptype = "Mess Expense";
				}
				$nettotal_amount = $nettotal_amount + $expensdet['unit_price'];
			?>
			<tr>
				<td ><?php echo date('d-m-Y',strtotime($expensdet['date_added']));?></td>
				<td ><?php echo $expensdet['expense_voucher'];?></td>
				<td class="text-center"><?= $exptype.' - '.$expensdet['expense_value'];?></td>
				<td ><?php echo $expensdet['st_name'].' '.'('.$expensdet['quantity'].' - '.$unit.')';?></td>
				<td ><?php if(!empty($expensdet['remarks'])){ echo $expensdet['remarks']; }else{ echo "Nil"; } ?></td>
				<td ><?php echo $plantfrom;?></td>
				<td ><?php echo $expensdet['unit_price'];?></td>
			</tr>
		<?php $i++; }}?>
		<tr class="search_finalsum">
			<td colspan="6" style="text-align:right;font-weight:bold;">TOTAL</td>
			<td><?= number_format($total_amount,2);?></td>
		</tr>
		<?php
		$b++;
		}?>
		<tr class="search_finalsum">
			<td colspan="6" style="text-align:right;font-weight:bold;">NET TOTAL</td>
			<td><?= number_format($nettotal_amount,2);?></td>
		</tr>
		<?php }else{?>
		<tr><td colspan="7" style="text-align:center;color:red;">Sorry No Record Found</td></tr>
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
									<th style="color:black;background-color: white !important;border-top: 1px solid black; border-left: 1px solid white; border-right: 1px solid white; border-bottom: 1px solid white;width:33%;">Prepared By</th>
									<th style="background-color : white !important;    border-top: 1px solid white;width:33%;"></th>
									<th style="color:black;background-color: white !important;border-top: 1px solid black; border-left: 1px solid white; border-right: 1px solid white; border-bottom: 1px solid white;width:33%;">Received By</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
				<div class="bel" style="position:absolute;bottom:2px;font-size:10px;"><p style="position:absolute;bottom:2px;font-style: italic;color:#5d5d5d;"><span style="font-weight:bold;font-style: italic;">Note:</span> This is auto generated report , on <?= date('d - M - Y'); ?> <?= date('h:i A'); ?> by <?= $this->session->userdata('user_name'); ?> login and requires signature from the approval authority.</p></div>
<script>
    	window.print();
</script>
