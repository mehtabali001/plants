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
<?
         $plantfor =	$this->Common_model->select_single_field('fld_location','tbl_locations',array('fld_id'=>$expense['plant_for']));
      ?>
<table class="table table-borderless" style="width:100%">
    <tbody>
        <tr>
            <td style="width:65%;text-align:left">
                <? $settings=$this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row_array();?>
                <img class="company-logo" src="<?=base_url()?>/assets/uploads/logo/<?=$settings['system_logo'];?>" style="height:70px;float:left;">
            </td>
            <td>
                <div class="detail text-left" >
                    <span style="font-weight:bold;font-size:12px;">Plant For :</span>&nbsp;<span class="" style="font-size:12px;"><?= $plantfor;?></span><br>
                    <span style="font-weight:bold;font-size:12px;">Invoice ID :</span>&nbsp;<span class="" style="font-size:12px;"><?= $expense['expense_voucher'];?></span><br>
                    <span style="font-weight:bold;font-size:12px;">Billing For :</span>&nbsp;<span class="" style="font-size:12px;"><?= $expense['expense_voucher'];?></span><br>
                    <span style="font-weight:bold;font-size:12px;">Billing Date :</span>&nbsp;<span class="" style="font-size:12px;"><?= date('d-m-y',strtotime($expense['date_added']));?></span><br>
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
		<th style="width:100px;">Expense Type/Value</th>
		<th style="width:50px;">Item</th>
        <th style="width:50px;">Qty </th>
        <th style="width:100px;">Amount(PKR) </th>
	</tr>
	</thead>


	<tbody class="purchaseRows" id="purchaseRows">
		 <?php if($expense){
													$i=1;
													$products = $this->db->query("select * from tbl_expense_detail where fld_expense_id = '".$expense['id']."'")->result_array();
													foreach($products as $purch){
													    $name =	$this->Common_model->select_single_field('name','tbl_stationary',array('id'=>$purch['stationary']));
													    $unit = $this->Common_model->select_single_field('fld_unit','tbl_units',array('fld_id'=>$purch['unit']));
													    if($purch['expense_type'] == 1){
													        $exptype = "Office Expense";
													    }else{
													        $exptype = "Mess Expense";
													    }
													?>						
												<tr>
													<td><?= $i;?></td>
													<td class="text-center"><?= $exptype.' - '.$purch['expense_value'];?></td>
													<td class="text-center"><?= $name;?></td>
													<td class="text-center"><?= $purch['quantity'].' - '.$unit;?></td>
													<td class="text-center"><?= $purch['unit_price'];?></td>
													
												</tr>
													<?php $i++; }?>
									</tbody>
									<tfoot>
												<tr>
													<td class="text-right" colspan="4"><b>Total(PKR):</b></td>
													<td class="text-center"><b><?= $expense['fld_grand_total_amount'];?></b></td>
												</tr>
									</tfoot>
										
		<?php }else{?>
		<tr><td colspan="10" style="text-align:center;">Sorry No Record Found</td></tr>
		<?php }
		?>
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
				<div class="bel" style="position:absolute;bottom:2px;font-size:10px;"><p style="font-style: italic;color:#5d5d5d;"><span style="font-weight:bold;font-style: italic;">Note:</span> This is auto generated report , on <?= date('d - M - Y'); ?> <?= date('h:i A'); ?> by <?= $this->session->userdata('user_name'); ?> login and requires signature from the approval authority.</p></div>
<script>
    	window.print();
</script>





