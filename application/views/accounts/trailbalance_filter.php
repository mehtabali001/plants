<style>
h3{
    text-align:center;
}
p{
    text-align:center;
}
.search_filter td {
    /*border: none !important;*/
    color: #000;
    font-weight: bold;
}
.search_finalsum td {
    /*border: none !important;*/
    /*background: rgb(245 222 179) !important;*/
    color: white;
    font-weight: bold;
}
.dataTables_filter{
    float: right;
}

</style>
<? $role_permissions  = explode(",",$this->session->userdata('permissions')); ?>
<?php //if($navigation){ ?>

	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right" style="margin-bottom: 15px;">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
                    <? if(!empty($role_permissions) && in_array(238,$role_permissions)) { ?>
                        <a type="button" id="print_report" onclick="printPdfTrailBalance(1);" class="btn btn-outline-primary print_report" name="" value="" disabled><i class="fa fa-print" aria-hidden="true"></i>&nbsp;Print</a>
					<? } ?>
					<? if(!empty($role_permissions) && in_array(239,$role_permissions)) { ?>
                        <a type="button" id="pdf_purchase_report" class="btn btn-outline-primary pdf_purchase_report" onclick="printPdfTrailBalance(2);" name="" value="" disabled><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;PDF</a>
					<? } ?>	
					<? if(!empty($role_permissions) && in_array(237,$role_permissions)) { ?>
                        <a type="button" id="trailbalance_csv" class="btn btn-outline-primary pdf_purchase_report" disabled onclick="downloadcsv();"  name="" value=""><i class="fas fa-file-csv"></i>&nbsp;CSV</a>
                    <? } ?>
                </div>
			</div>
		</div><!--end page-title-box-->
	</div><!--end col-->

<? //} ?>
<h3>Trial Balance</h3>
<p><?=$start_date?>&nbsp;&nbsp;&nbsp;<span>To</span>&nbsp;&nbsp;&nbsp;<?=$end_date?></p>
<div class="row">
    <div class="col-sm-12">
        <div class="filter-box" style="width:460px;margin: auto;">
        <ul class="nav nav-pills  nav-justified" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link <?php if(isset($_POST['level']) && $_POST['level'] == 1){ echo 'active'; }?>" onclick="getTrailBalance(1); bsload();" id="general_chat_tab" data-toggle="pill" href="#" style="border: 1px solid #788fe9;border-top-left-radius: 25px; border-bottom-left-radius: 25px;border-top-right-radius: 0; border-bottom-right-radius: 0;">Summarized View</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if(isset($_POST['level']) && $_POST['level'] == 2){ echo 'active'; }?>" id="group_chat_tab" onclick="getTrailBalance(2); bsload();" data-toggle="pill" href="#" style="border-radius:0;border: 1px solid #788fe9;">Med-Detailed View</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if(isset($_POST['level']) && $_POST['level'] == 3){ echo 'active'; }?>" id="personal_chat_tab" onclick="getTrailBalance(3); bsload();" data-toggle="pill" href="#"style="border: 1px solid #788fe9;border-top-left-radius: 0; border-bottom-left-radius: 0;border-top-right-radius: 25px; border-bottom-right-radius: 25px;">Detailed View</a>
            </li>
        </ul>
        </div>
    </div><!--end chat-box-left -->
</div>
    <div class="container">
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
		        <td style="display:none"></td>
    			<td style="" colspan="2">Total</td>
    			<td style=""><?=number_format(($totalDebit+$costOfGoodsSold),2);?></td>
    			<td style=""><?=number_format(($totalCredit+$saleofproducts->amount),2);?></td>
            </tr>
	</tbody>
</table>
</div>
