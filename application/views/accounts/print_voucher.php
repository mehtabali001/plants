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
<? $head_namee=$this->db->query("select * from tbl_coa where head_code = '{$editDataV['coa_id']}'")->row()->head_name;?>
    <div style="float:right;margin-top:2%;">
        <span style="font-weight:bold;font-size:14px;">&nbsp;Voucher Number :</span>&nbsp;<span class="desc"><?=$editData['type']?>-<?=$editData['id']?></span><br>
        <span style="font-weight:bold;font-size:14px;">&nbsp;Voucher type :</span>&nbsp;  <span class="desc"><?=$editData['type']?></span><br>
        <span style="font-weight:bold;font-size:14px;">&nbsp;Date : </span><span class="desc"><?=$editData['date']?></span><br>
        <span style="font-weight:bold;font-size:14px;">&nbsp;Account : </span><span class="desc"><?php echo $head_namee; ?>
        <?/*php $length = strlen($head_namee);
        if($length > 25){
           $text= substr($head_namee, 0, 20).'<br>'.substr($head_namee, 20);
        }else{
            $text=$head_namee;
        }
        echo $text;*/?>
        </span><br>
        <!--<span style="font-weight:bold;font-size:14px;">&nbsp;Narration : </span><span class="desc"><?//=$this->CI->getStringBetween($editDataV['narration']);?></span><br>-->
        
    </div>
    <!--<img class="company-logo" src="<?= base_url()?>assets/custom_elements/images/logoreport.png" style="height:100px;float:right;">-->
    <? $settings=$this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row_array();?>
                <img class="company-logo" src="<?=base_url()?>/assets/uploads/logo/<?=$settings['system_logo'];?>" style="height:100px;float:left;">
<hr style="width:100%;">
    <!--<p style=" text-align: center;font-weight: bold;position: relative;"><?=$start_date?>&nbsp;&nbsp;&nbsp;<span>To</span>&nbsp;&nbsp;&nbsp;<?=$end_date?></p>-->
<table id="datatable_tb" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;margin-top: 5%;">
	
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