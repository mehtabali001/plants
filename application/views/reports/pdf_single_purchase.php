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
            <td style="width:55%;text-align:left">
                <img class="company-logo" src="<?=base_url()?>/assets/uploads/logo/<?=$settings['system_logo'];?>" style="height:70px;float:left;">
            </td>
            <td>
                <div class="detail text-left" >
                    <span class="text-left" style="font-weight:bold;font-size:12px;">&nbsp;Bill ID :</span>&nbsp;<span class="desc"><?= $purchase['fld_voucher_no'];?></span><br>
                    <span class="text-left" style="font-weight:bold;font-size:12px;">&nbsp;Billing Date :</span>&nbsp;  <span class="desc"><?= date('d-m-y',strtotime($purchase['fld_purchase_date']));?></span><br>
                    <span class="text-left" style="font-weight:bold;font-size:12px;padding-left:0; margin-bottom:0 !important;">&nbsp;Account :</span>&nbsp;<span class="desc">  <?= explode('/', $purchase['fld_shipment'])[0].'/'. explode('/', $purchase['fld_shipment'])[1];?></span><br>
                    <span class="text-left" style="font-weight:bold;font-size:12px;">&nbsp;Shipment : </span><span class="desc"><?= $purchase['fld_shipment'];?></span><br>
                </div>
            </td>
        </tr>
    </tbody>
</table>

<hr style="width:100%;">
<table id="datatable_tb" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
	<thead class="dthead">
    	<tr>
    		<th style="width:50px;">#</th>
            <th style="width:100px;">Item </th>
            <th style="width:50px;">Qty </th>
            <th style="width:65px;">Rate(PKR) </th>
            <th style="width:100px;">Amount(PKR)</th>
    	</tr>
    </thead>


	<tbody class="purchaseRows" id="purchaseRows">
		 <?php if($purchase){
				$i=1;
													foreach($purchase['products'] as $purch){
													?>						
												<tr>
													<td class="text-center"><?= $i;?></td>
													<td class="text-center">
														<?= $purch['fld_category'];?>
													</td>
													<td class="text-center"><?= $purch['fld_quantity'];?></td>
													<td class="text-center"><?= $purch['fld_unit_price'];?></td>
													<td class="text-center"><?= $purch['fld_total_amount'];?></td>
												</tr>
												<tr>
													<td class="text-right" colspan="4"><b>GST(PKR)</b></td>
													<td class="text-center"><b></b></td>
												</tr>
		<?php
		$i++;
		} ?>
			<tfoot>
												<tr>
													<td class="text-right" colspan="4"><b>Net Total(PKR)</b></td>
													<td class="text-center"><b><?= $purchase['fld_grand_total_amount'];?></b></td>
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
				<div class="bel" style="position:absolute;bottom:2px;"><p style="font-style: italic;color:#5d5d5d;"><span style="font-weight:bold;font-style: italic;">Note:</span> This is auto generated report , on <?= date('d - M - Y'); ?> <?= date('h:i A'); ?> by <?= $this->session->userdata('user_name'); ?> login and requires signature from the approval authority.</p></div>
<script>
    	window.print();
</script>
