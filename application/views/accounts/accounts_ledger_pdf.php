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
    font-size:12px !important;
}
.desc{
    font-size:10px;
    font-weight:100;
}
}
</style>
<table class="table table-borderless" style="width:100%;">
    	<?php 
    $account = $this->db->query("SELECT * FROM tbl_coa WHERE head_code = '{$_GET['account_id']}'")->row_array();
    $address = '';
    $contact = '';
    
    if($account['type']=='EMPLOYEE'){
        $acd = $this->db->select('*')->from('tbl_employees')->where('id', $account['type_id'])->get();
        if($acd->num_rows() > 0){
            $address = $acd->row()->address;
            $contact = $acd->row()->mobile_no;
        }
    }else if($account['type']=='SUPPLIER'){
        $acd = $this->db->select('*')->from('tbl_suppliers')->where('fld_id', $account['type_id'])->get();
        if($acd->num_rows() > 0){
            $address = $acd->row()->fld_city.', '.$acd->row()->fld_country;
            $contact = $acd->row()->fld_mobile_num;
        }
    }else if($account['type']=='PARTNER' || $account['type']=='OTHER'){
        $contact = $account['contact'];
        $address = $account['address'];
    }else if($account['type']=='CUSTOMER'){
        $acd = $this->db->select('*')->from('tbl_customers')->where('fld_id', $account['type_id'])->get();
        if($acd->num_rows() > 0){
            $address = $acd->row()->fld_city.', '.$acd->row()->fld_country;
            $contact = $acd->row()->fld_mobile_num;
        }
    }else if($account['type']=='BANK'){
        $acd = $this->db->select('*')->from('tbl_banks')->where('fld_id', $account['type_id'])->get();
        if($acd->num_rows() > 0){
            $address = $acd->row()->fld_address;
        }
    }else if($account['type']=='VEHICLE'){
        $acd = $this->db->select('*')->from('tbl_transporter')->where('fld_id', $account['type_id'])->get();
        if($acd->num_rows() > 0){
            $contact = $acd->row()->fld_contact_no;
        }
    }
    ?>
    <tbody>
        <tr>
            <td style="width:70%;text-align:left">
                <!--<img class="company-logo" src="<?= base_url()?>assets/custom_elements/images/logoreport.png" style="height:70px;float:left;">-->
                <? $settings=$this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row_array();?>
                <img class="company-logo" src="<?=base_url()?>/assets/uploads/logo/<?=$settings['system_logo'];?>" style="height:70px;float:left;">
            </td>
            <td>
                <div class="detail text-left" >
                    <span style="font-weight:bold;">Type:</span>&nbsp;<span class="fromDate">Accounts Ledger</span><br>
                    <span style="font-weight:bold;">Account Title:</span>&nbsp;<span class="fromDate"><?php echo $account['head_name']; ?></span><br>
                     <span style="font-weight:bold;">Account Code:</span>&nbsp;<span class="fromDate"><?php echo $account['head_code']; ?></span><br>
                     <span style="font-weight:bold;">Address:</span>&nbsp;<span class="fromDate"><?php echo $address; ?></span><br>
                     <span style="font-weight:bold;">Contact:</span>&nbsp;<span class="fromDate"><?php echo $contact; ?></span><br>
				     <span style="font-weight:bold;">From:</span>&nbsp;<span class="fromDate"><?php echo $_GET['from_date']; ?></span><br>
                     <span style="font-weight:bold;">To:</span>&nbsp;<span class="toDate"><?php echo $_GET['to_date']; ?></span><br>
                </div>
            </td>
        </tr>
    </tbody>
</table>

<hr style="width:100%;">
<table id="datatable_tb" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
	<thead class="dthead">
	<tr>
		<th style="width: 6%;">#</th>
		<th>Voucher Date</th>
		<th>Voucher Number</th>
		<th>Narration</th>
		<th>Debit</th>
		<th>Credit</th>
		<th>Balance</th>
		<th>Dr/Cr</th>
	</tr>
	</thead>


	<tbody class="ledgerRows" id="ledgerRows">
		 <?php if($ledger){
			 $i=1;
			 $b=1;
			foreach($ledger as $ledge){
			?>
    		<tr class="search_filter">
    			<td colspan="8" style="padding-left: 24%;color:black;font-weight:bold;"><?php echo $ledge['filter_text'];?></td>
            </tr>
				 <tr>
				<td ><?php echo $i;?></td>
				<td ><?php echo date('d-m-Y',strtotime($from));?></td>
				<td >OP-0</td>
				<td style="font-weight: bold;">Opening Balance</td>
				<td style="color:green;"></td>
				<td style="color:red;"></td>
				<td  class="<?php if(number_format($ledge['opening'] ,2) > 0){ echo 'even';} else { echo 'odd';} ?>" style="font-weight: bold;"><?php echo number_format($ledge['opening'],2); ?></td>
				<td><?php if($ledge['opening'] > 0){ echo 'Dr';}else{ echo 'Cr'; }?></td>
			</tr>
				<?php
				
				$total_credit=0;
				$total_debit=0;
				$balance=$ledge['opening'];
				$i+=1;
				foreach($ledge['detail'] as $ledgedet){
				    $total_credit +=$ledgedet['credit'];
				    $total_debit +=$ledgedet['debit'];
				    $balance += $ledgedet['debit']-$ledgedet['credit'];
					?>
					<tr>
						<td ><?php echo $i;?></td>
						<td ><?php echo date('d-m-Y',strtotime($ledgedet['date']));?></td>
						<td ><?php echo $ledgedet['type'];?> - <?php echo $ledgedet['v_id'];?></td>
						<td ><?php if($ledgedet['type']=='Purchase'){
						echo '(PV-'.sprintf('%04d', $ledgedet['type_id']).')';
						}else if($ledgedet['type']=='Sale'){
						echo '(SV-'.sprintf('%04d', $ledgedet['type_id']).')';
						}else if($ledgedet['type']=='Expense'){
						echo '(EV-'.sprintf('%04d', $ledgedet['type_id']).') ';
						}?><?php echo $ledgedet['narration'];?></td>
						<td ><?php echo number_format($ledgedet['debit'],2);?></td>
						<td ><?php echo number_format($ledgedet['credit'],2);?></td>
						<td ><?=number_format($balance,2);?></td>
						<td><?php if($$balance > 0){ echo 'Dr';}else{ echo 'Cr'; }?></td>
					</tr>
					<?php $i++; }?>
		
		<tr class="search_finalsum">
			<td colspan="4" style="text-align:right;font-weight:bold;">NET TOTAL</td>
			<td ><?= number_format($total_debit,2);?></td>
			<td ><?= number_format($total_credit,2);?></td>
			<td><?= number_format($balance,2);?></td>
			<td><?php if($balance > 0){ echo 'Dr';}else{ echo 'Cr'; }?></td>
		</tr>
		<?php
		$b++;
		}}else{?>
		<tr><td colspan="10" style="text-align:center;color:red;">Sorry No Record Found</td></tr>
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
