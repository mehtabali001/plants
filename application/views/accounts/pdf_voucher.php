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
            <td style="width:70%;text-align:left">
                <!--<img class="company-logo" src="<?= base_url()?>assets/custom_elements/images/logoreport.png" style="height:70px;float:left;">-->
                <? $settings=$this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row_array();?>
                <img class="company-logo" src="<?=base_url()?>/assets/uploads/logo/<?=$settings['system_logo'];?>" style="height:70px;float:left;">
            </td>
            <td>
                <div class="detail text-left" >
                    <span style="font-weight:bold;font-size:14px;">&nbsp;Voucher Number :</span>&nbsp;<span class="desc"><?=$editData['type']?>-<?=$editData['id']?></span><br>
                    <span style="font-weight:bold;font-size:14px;">&nbsp;Voucher type :</span>&nbsp;  <span class="desc"><?=$editData['type']?></span><br>
                    <span style="font-weight:bold;font-size:14px;">&nbsp;Account : </span><span class="desc"><?php echo $this->db->query("select * from tbl_coa where head_code = '{$editDataV['coa_id']}'")->row()->head_name; ?></span><br>
                    <!--<span style="font-weight:bold;font-size:14px;">&nbsp;Narration : </span><span class="desc"><?//=$this->CI->getStringBetween($editDataV['narration']);?></span><br>-->
                    <span style="font-weight:bold;font-size:14px;">&nbsp;Date : </span><span class="desc"><?=$editData['date']?></span><br>
                </div>
            </td>
        </tr>
    </tbody>
</table>

<hr style="width:100%;">
<table class="table " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
	<thead>
             <tr>
                <th>Code</th> 
                <th>Account </th>
                <th>Narration</th>
                <th>P.Balance(PKR)</th> 
                <th >Amount(PKR)</th>
            </tr>
        </thead>
        <tbody id="voucher_details">
            <?php 
            $totalAmount = 0;
                $sn =0;
                // print_r($editDataDetails);
                
            foreach($editDataDetails as $vData){
                $sn++;
                if($editData['type'] == 'CRV' || $editData['type'] == 'CHRV'){
                $amount=$vData['credit'];
            }else{
                $amount=$vData['debit'];
            }
            $totalAmount += $amount;
            
            ?>
            <tr>
                <td class="span3">
                  <?=$vData['coa_id'];?>
                </td>
                <td class="span3">
                   <?php echo $this->db->query("select * from tbl_coa where head_code = '{$vData['coa_id']}'")->row()->head_name; ?>
                </td>
                <td class="span3">
                    <?=$this->CI->getStringBetween($vData['narration']);?>
                </td>
                <td class="span3">
                   <?=$this->CI->getBalanceInner($vData['coa_id']); ?>
                </td>
                
                <td class="test">
                    <?=$amount;?>
                </td>
            </tr>
            <?php } ?>
            <tr>
                <td colspan="4" style="text-align:right;"><b>Total (PKR):</b></td>
                <td class="text-right">
                    <?=$totalAmount;?>
                </td>
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