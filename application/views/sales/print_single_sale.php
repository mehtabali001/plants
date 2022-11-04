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
    <div style="float:right;margin-top:2%;">
        <span style="font-weight:bold;">Invoice : </span><span class="fromDate"><?php echo $sale['fld_invoice_no']; ?></span><br>
        
        <span style="font-weight:bold;padding-left:0; margin-bottom:0 !important;">Billing For : </span><?php $length = strlen($sale['fld_customer_name']);
        if($length > 25){
           $text= substr($sale['fld_customer_name'], 0, 25).'<br>'.substr($sale['fld_customer_name'], 25);
        }else{
            $text=$sale['fld_customer_name'];
        }
        echo $text;?><br>
         <span style="font-weight:bold;">Billing Date : </span><?= date('d-m-y',strtotime($sale['fld_sale_date']));?>
    </div>
     <div style="float:left;margin-top:2%;">
        <span style="font-weight:bold;">Sale Location : </span><span class="fromDate"><?php echo $sale['fld_location']; ?></span><br>
        <span style="font-weight:bold;">Sale Invoice : </span><span class="fromDate"><?php echo $sale['fld_voucher_no']; ?></span><br>
    </div>
    <? $settings=$this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row_array();?>

    <img class="company-logo" src="<?=base_url()?>/assets/uploads/logo/<?=$settings['system_logo'];?>" style="height:100px;margin-left:auto;margin-right:auto;display:block;">
    
<hr style="width:100%;">
    <!--<p style=" text-align: center;font-weight: bold;position: relative;"><?=$start_date?>&nbsp;&nbsp;&nbsp;<span>To</span>&nbsp;&nbsp;&nbsp;<?=$end_date?></p>-->
<table id="datatable_tb" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;margin-top: 5%;">
	
<thead class="htmlRows1">
										<tr>
											<th>#</th>
											<th>Product Name</th>
											<th class="text-center">Qty</th>
											<th class="text-center">Weight(KG)</th>
											<th class="text-center">Rate(PKR)</th>
											<th class="text-center">Discount(PKR)</th>
											<th class="text-center">Total(PKR)</th>
										</tr>
									</thead>
									<tbody id="htmlRows">
										<?php if($sale){
													$i=1;
													foreach($sale['products'] as $saledet){
													?>						
												<tr>
													<td><?= $i;?></td>
													<td>
														<?= $saledet['fld_category'];?> - <?= $saledet['fld_subcategory']; ?>
													</td>
													<td class="text-center"><?= $saledet['fld_quantity'];?></td>
													<td class="text-center"><?= $saledet['fld_weight'];?></td>
													<td class="text-center"><?= $saledet['fld_unit_price'];?></td>
													<td class="text-center"><?= $saledet['fld_discount'];?></td>
													<td class="text-center"><?= $saledet['fld_total_amount'];?></td>
												</tr>
													<?php $i++; }}?>
									</tbody>
										<tfoot>
											    	<tr>
													<td class="text-right" colspan="6"><b>Total Discount(PKR):</b></td>
													<td class="text-center"><b><?= $sale['fld_total_discount'];?></b></td>
												</tr>
												<tr>
													<td class="text-right" colspan="6"><b>Net Total(PKR):</b></td>
													<td class="text-center"><b><?= $sale['fld_grand_total_amount'];?></b></td>
												</tr>
													
										</tfoot>
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
				<div class="bel" style="position:absolute;bottom:2px;"><p style="font-style: italic;color:#5d5d5d;"><span style="color:#5d5d5d;font-style: italic;">Note:</span>  This is auto generated report , on <?= date('d - M - Y'); ?> <?= date('h:i A'); ?> by <?= $this->session->userdata('user_name'); ?> login and requires signature from the approval authority.</p></div>
<script>
    	window.print();
</script>
