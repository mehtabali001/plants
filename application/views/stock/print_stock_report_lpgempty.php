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
<table class="table table-borderless" style="width:100%;">
    <tbody>
        <tr>
            <td style="width:61%;text-align:left">
                <? $settings=$this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row_array();?>
                <img class="company-logo" src="<?=base_url()?>/assets/uploads/logo/<?=$settings['system_logo'];?>" style="height:70px;float:left;">
                <!--<img class="company-logo" src="<?= base_url()?>assets/custom_elements/images/logoreport.png" style="height:70px;float:left;">-->
            </td>
            <td>
                <div class="detail text-left" >
                    <span style="font-weight:bold;">Type :</span>&nbsp;<span class="">Stock's Report(LPG Empty)</span><br>
                    <span style="font-weight:bold;">Stock's Date :</span>&nbsp;<span class=""><?= date('d - M - Y'); ?></span><br>
                </div>
            </td>
        </tr>
    </tbody>
</table>

<hr style="width:100%;">
<table class="table " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
<thead class="dthead">
    	<tr>
    		<th>#</th>
    		<th>Plant</th>
    		<th>11.8(KG)</th>
    		<th>Rate(11.8)</th>
    		<th>15(KG)</th>
    		<th>Rate(15)</th>
    		<th>45.4(KG)</th>
    		<th>Rate(45.4)</th>
    		<th>Total Amount(PKR)</th>
    	</tr>
    	</thead>
    	<tbody>
        <?
        // $CI     = & get_instance();
        $type1_total=0;
        $type2_total=0;
        $type3_total=0;
        $total_amount = 0;
          if($locations){
          $i=1;
          
          foreach($locations as $loc){
               $type1=$controller->getStockPlantWise($loc['fld_id'], 2, 5);
               $type2=$controller->getStockPlantWise($loc['fld_id'], 2, 8);
               $type3=$controller->getStockPlantWise($loc['fld_id'], 2, 9);
               $type1_total +=$type1['closingstock']; 
               $type2_total +=$type2['closingstock']; 
               $type3_total +=$type3['closingstock']; 
               $total_amount += ($type1['total_amount']+$type2['total_amount']+$type3['total_amount']);
        ?>
        
    
        <? /* /><div class="col-md-4">
            <div class="category-card">
                <div class="video-icon">
                <i class="fa fa-houzz" style="font-size:36px;">&nbsp;<span class="heead"><?=$loc['fld_location'];?></span></i>
                </div>
                <div class="content">
                    <ul>
                       <li><a href="#">Date: <?=date('d/m/Y')?></a></li>    
                       <li><a href="#">Opening Stock (Cylinder(s)): <?=$openingstock;?></a></li>
                       <li><a href="#">Stock Receive (Cylinder(s)): <?=$todaypurchase;?></a></li>
                       <li><a href="#">Today Sale (Cylinder(s)): <?=$todaysale;?></a></li>
                       <li><a href="#">Closing Stock (Cylinder(s)): <?=$closingstock;?></a></li>
                    </ul>
                </div>
             </div>
        </div>
        <? } ?><? */ ?>
    

		<tr>
			<td ><?php echo $i;?></td>
			<td ><?=$loc['fld_location'];?></td>
			<td ><?=$type1['closingstock'];?></td>
			<td ><?=$type1['price'];?></td>
			<td ><?=$type2['closingstock'];?></td>
			<td ><?=$type2['price'];?></td>
			<td ><?=$type3['closingstock'];?></td>
			<td ><?=$type3['price'];?></td>
			<td ><?=($type1['total_amount']+$type2['total_amount']+$type3['total_amount']);?></td>
		</tr>
		<?php $i++; } ?>		
		<tr class="search_finalsum">
			<td colspan="2" style="text-align:center;font-weight:bold;">NET TOTAL</td>
			<td style="text-align:left;font-weight:bold;"><?=$type1_total;?></td>
			<td style="text-align:center;font-weight:bold;"></td>
			<td style="text-align:left;font-weight:bold;"><?=$type2_total;?></td>
			<td style="text-align:center;font-weight:bold;"></td>
			<td style="text-align:left;font-weight:bold;"><?=$type3_total;?></td>
			<td style="text-align:center;font-weight:bold;"></td>
			<td style="text-align:left;font-weight:bold;"><?=$total_amount;?></td>
		</tr>
		<?php }else{?>
		<tr><td colspan="9" style="text-align:center;color:red;">Sorry No Record Found</td></tr>
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
					<div class="bel">
		    <p style="position: sticky;font-style: italic; bottom: 0; color:#5d5d5d;"><span style="font-weight:bold;">Note:</span> This is auto generated report on <?= date('d - M - Y'); ?>, <?= date('h:i A'); ?> by <?= $this->session->userdata('user_name'); ?> account  and requires signature from the approval authority.</p>
		    </div>
<script>
    	window.print();
</script>
