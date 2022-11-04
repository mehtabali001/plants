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
    border: 1px solid #eee !important;
    color: #000;
    /*font-weight: bold;*/
    padding: 7px;
}

</style>

    <!--<h2 style="float:right;margin-top: 4%;">Income statement</h2>-->
    <div class="detail " style="float:right;margin-top: 4%;" >
        <span style="font-weight:bold;">&nbsp;Type:</span>&nbsp;<span>Trial Balance Report</span><br>
         <span style="font-weight:bold;">&nbsp;From:</span>&nbsp;<span class="" style=""><?=$start_date?></span><br>
         <span style="font-weight:bold;">&nbsp;To:</span>&nbsp;<span class="" style=""><?=$end_date?></span>
    </div>
    <? $settings=$this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row_array();?>
    <img class="company-logo" src="<?=base_url()?>/assets/uploads/logo/<?=$settings['system_logo'];?>" style="height:120px;float:left;">
<hr style="width:100%;">
<!--    <p style=" text-align: center;font-weight: bold;position: relative;"><?//=$start_date?>&nbsp;&nbsp;&nbsp;<span>To</span>&nbsp;&nbsp;&nbsp;<?//=$end_date?></p>-->
<table id="datatable_tb" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
	


	<thead>
	    <tr class="search_filter">
		        <td>&nbsp;</td>
    			<td style="">Code</td>
    			<td style="">Account</td>
    			<td style="">Debit</td>
    			<td style="">Credit</td>
        </tr>
	</thead>


	<tbody class="ledgerRows" id="ledgerRows">
	    
		    
    		
			<?php 
			$totalCredit = 0;
			$totalDebit = 0;
			foreach($accounts as $account){
			$balance = $this->db->query("SELECT IFNULL(SUM(a.debit), 0)-IFNULL(SUM(a.credit), 0) as balance FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id && b.date >= '$start_date' && b.date <= '$end_date' && a.coa_id LIKE '{$account['head_code']}%'")->row()->balance;
			
			
			if($balance > 0){
			    $totalDebit += $balance;
			}else{
			    $totalCredit += abs($balance);
			}
			
			
			if(isset($_POST['hide_zero']) && !empty($_POST['hide_zero']) && $balance == 0){}else{
			?>
			<tr style="">
			            <td></td>
						<td><?=$account['head_code']; ?></td>
						<td ><?=$account['head_name']; ?></td>
						<td ><?if($balance>0){echo number_format($balance,2);}?></td>
						<td ><?if($balance<0){echo number_format(abs($balance), 2);}?></td>
						
			</tr>
			<?php }} ?>
			
			<?php 
				$start=$start_date;
		$end=$end_date;
		
		
		$saleofproducts = $this->db->query("SELECT IFNULL(SUM(fld_total_discount), 0) discount, IFNULL(SUM(fld_grand_total_amount), 0) amount FROM `tbl_sale` WHERE DATE(fld_sale_date) >= '$start' && DATE(fld_sale_date) <= '$end'")->row();
		
		$cgsOpeningStock = $this->db->query("SELECT IFNULL(SUM(a.debit), 0)-IFNULL(SUM(a.credit), 0) as balance FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id && b.date < '$start' && (a.coa_id LIKE '101003003' || a.coa_id LIKE '101003004')")->row()->balance;
		
		$cgsPurchase = $this->db->query("SELECT IFNULL(SUM(a.debit), 0) as debit FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id && b.date >= '$start' && b.date <= '$end' && (a.coa_id LIKE '101003003' || a.coa_id LIKE '101003004')")->row()->debit;
		
		$cgsClosingStock = $this->db->query("SELECT IFNULL(SUM(a.debit), 0)-IFNULL(SUM(a.credit), 0) as balance FROM tbl_transections_details as a, tbl_transections_master as b WHERE b.id = a.v_id && (a.coa_id LIKE '101003003' || a.coa_id LIKE '101003004') and b.date <= '$end'")->row()->balance;
		
// 		exit;
		$costOfGoodsSold = $cgsOpeningStock+$cgsPurchase-$cgsClosingStock;
		
		?>
		<tr>
			            <td>&nbsp;</td>
						<td>&nbsp;</td>
						<td >Net Sale</td>
						<td >&nbsp;</td>
						<td ><?php echo number_format($saleofproducts->amount, 2);?></td>
						
			</tr>
			<tr>
			            <td>&nbsp;</td>
						<td>&nbsp;</td>
						<td >Cost of Good Sold</td>
						<td ><?=number_format($costOfGoodsSold,2);?></td>
						<td ></td>
						
			</tr>
		    <tr class="search_filter">
		        <td>&nbsp;</td>
    			<td style="" colspan="2">Total</td>
    			<td style=""><?=number_format(($totalDebit+$costOfGoodsSold),2);?></td>
    			<td style=""><?=number_format(($totalCredit+$saleofproducts->amount),2);?></td>
            </tr>
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
