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
@media print {
    /*th {  padding: 5px; color:#000; font-weight:bold;}*/
.detail span{
    text-align:left;
}
.fromDate{
    font-size:10px;
    font-weight:100;
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
            <td style="width:32%;">
                <span style="font-weight:bold;font-size:10px;">Sale Location : </span><span class="fromDate" style="font-size:10px;"><?php echo $sale['fld_location']; ?></span><br>
                <span style="font-weight:bold;font-size:10px;">Sale Invoice : </span><span class="fromDate" style="font-size:10px;"><?php echo $sale['fld_voucher_no']; ?></span><br>
            </td>
            <td style="text-align:center;width:34%;">
                <? $settings=$this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row_array();?>
                <img class="company-logo" src="<?=base_url()?>/assets/uploads/logo/<?=$settings['system_logo'];?>" style="height:70px;float:left;">
            </td>
            <td>
                <div class="detail text-left ;" >
                    <span style="font-weight:bold;font-size:10px;">Invoice : </span><span class="fromDate" style="font-size:10px;"><?php echo $sale['fld_invoice_no']; ?></span><br>
                    <span style="font-weight:bold;font-size:10px;">Billing For : </span><span class="fromDate" style="font-size:10px;"><?= $sale['fld_customer_name'];?></span><br>
                     <span style="font-weight:bold;font-size:10px;">Billing Date : </span><span class="fromDate" style="font-size:10px;"><?= date('d-m-y',strtotime($sale['fld_sale_date']));?></span>
                </div>
            </td>
        </tr>
    </tbody>
</table>

<hr style="width:100%;">
<table id="datatable_tb" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
	<thead class="dthead">
	<tr>
		<th>#</th>
		<th>Product Name</th>
		<th class="text-center">Qty</th>
		<th class="text-center">Weight</th>
		<th class="text-center">Rate</th>
		<th class="text-center">Discount</th>
		<th class="text-center">Total Amount</th>
	</tr>
	</thead>


	<tbody class="purchaseRows" id="purchaseRows">
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
													<?php $i++; }?>
													</tbody>
		<tfoot>
											    	<tr>
													<td class="text-right" colspan="6"><b>Total Discount:</b></td>
													<td class="text-center"><b><?= $sale['fld_total_discount'];?></b></td>
												</tr>
												<tr>
													<td class="text-right" colspan="6"><b>Net Total:</b></td>
													<td class="text-center"><b><?= $sale['fld_grand_total_amount'];?></b></td>
												</tr>
													
																																			</tfoot>
		
		
		<?php }else{?>
		<tr><td colspan="10" style="text-align:center;">Sorry No Record Found</td></tr>
		<?php }
		?>
	
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
				<div class="bel" style="position:absolute;bottom:2px;"><p style="font-style: italic;color:#5d5d5d;font-size:10px;"><span style="font-weight:bold;font-style: italic;">Note:</span> This is auto generated report , on <?= date('d - M - Y'); ?> <?= date('h:i A'); ?> by <?= $this->session->userdata('user_name'); ?> login and requires signature from the approval authority.</p></div>
<script>
    	window.print();
</script>
