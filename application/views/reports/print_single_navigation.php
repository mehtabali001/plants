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
    font-size:10px;
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
        <span style="font-weight:bold;font-size:10px;">&nbsp;Navigation Bill ID :</span>&nbsp;<span class="desc"><?php echo sprintf(' NB-%04d ', $navigation['fld_id']);?></span><br>
        <span style="font-weight:bold;font-size:10px;">&nbsp;Navigation Date :</span>&nbsp;  <span class="desc"><?php echo date('d-m-Y',strtotime($navigation['fld_created_date']));?></span><br>
        <span style="font-weight:bold;font-size:10px;">&nbsp;Shipment : </span><span class="desc"><?php echo $navigation['products'][0]['fld_shipment_from'];?></span><br>
    </div>
    <? $settings=$this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row_array();?>
    <img class="company-logo" src="<?=base_url()?>/assets/uploads/logo/<?=$settings['system_logo'];?>" style="height:100px;float:left;">
<hr style="width:100%;">
    <!--<p style=" text-align: center;font-weight: bold;position: relative;"><?=$start_date?>&nbsp;&nbsp;&nbsp;<span>To</span>&nbsp;&nbsp;&nbsp;<?=$end_date?></p>-->
<table id="datatable_tb" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;margin-top: 5%;">
	
<thead class="htmlRows1">
										<tr>
									       <th>Date</th>
                                            <th>Invoice ID</th>
                                            <th>Plant From</th>
                                            <th>Plant To</th>
                                            <th>Item</th>
                                            <th>Shipment</th>
                                            <th>Weight(MT)</th>
                                            <th>Rate(PKR)</th>
										</tr>
									</thead>
									<tbody id="htmlRows">
									    <?php if($navigation){ 
									        foreach($navigation['products'] as $prod){
										?>
									    <tr>
												<td>
												<?php echo date('d-m-Y',strtotime($navigation['fld_created_date']));?>
												</td>
												<td>
												<?php echo sprintf(' NI-%04d ', $navigation['fld_id']);?>
												</td>
												<td>
												<?php echo $navigation['location_from'];?>
												</td>
												<td>
												<?php echo $navigation['location_to'];?>
												</td>
												<td>
												<?php echo $prod['fld_category'];?>
												</td>
												<td>
												<?php echo $prod['fld_shipment_from'];?>
												</td>
												<td>
												<?php echo $prod['fld_qty'];?>
												</td>
												<td>
												<?php echo $prod['fld_rate'];?>
												</td>
											</tr>
											<?php }} ?>
									</tbody>
									<tfoot>
									           <tr>
													<td class="text-right" colspan="7"><b>Freight/MT</b></td>
													<td class="text-center"><b><?php echo $navigation['fld_freight_MT'];?></b></td>
												</tr>
									            <tr>
													<td class="text-right" colspan="7"><b>Freight Amount</b></td>
													<td class="text-center"><b><?php echo $navigation['fld_freight_amount'];?></b></td>
												</tr>
												<tr>
													<td class="text-right" colspan="7"><b>Net Total</b></td>
													<td class="text-center"><b><?php echo $navigation['fld_total_amount'];?></b></td>
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
				<div class="bel" style="position:absolute;bottom:2px;"><p style="font-style: italic;color:#5d5d5d;font-size: 12px;"><span style="color:#5d5d5d;font-style: italic;">Note:</span>  This is auto generated report , on <?= date('d - M - Y'); ?> <?= date('h:i A'); ?> by <?= $this->session->userdata('user_name'); ?> login and requires signature from the approval authority.</p></div>
<script>
    	window.print();
</script>
