<?php if(@$sales){
			 $i=1;
			 $b=1;
			 $amtqty=0;
			 $akgqty=0;
			 $atdiscount=0;
			 $total_all_amount = 0;
			
			?>
				<?php
				$mtqty=0;
				$kgqty=0;
				$tdiscount=0;
				$total_amount=0;
				foreach($sales as $saledet){
					$qty = 0;
					$weight = 0;
					$unit_price =  '';
					$fld_total_amount = 0;
					$subcat = '';
					    $saledetail = $this->db->query("select * from tbl_sale_detail WHERE fld_sale_id = '{$saledet['fld_id']}'")->result_array();
					    foreach($saledetail as $rowdet){
					       $subcat .=  $this->db->query("select * from tbl_category where fld_id = '{$rowdet['fld_product_id']}'")->row()->fld_category;
    					    if($rowdet['fld_subproduct_id'] != '0'){
    					        $subcat .= ' - '.$this->db->query("select * from tbl_subcategory where fld_subcid = '{$rowdet['fld_subproduct_id']}'")->row()->fld_subcategory.', ';
    					    }
    					    $qty += $rowdet['fld_quantity'];
    					    $weight += $rowdet['fld_weight'];
    					    $unit_price .= $rowdet['fld_unit_price'].', ';
    					    $fld_total_amount  +=round($rowdet['fld_total_amount']-$rowdet['fld_discount'],2);
					    }
					    
					?>
					<tr>
						<td ><?php echo $i;?></td>
						<td ><?php echo date('d-m-Y',strtotime($saledet['fld_sale_date']));?></td>
						<td ><?php echo rtrim($subcat, ', ');?></td>
						<td ><?php echo $qty;?></td>
						<td ><?php echo $weight;?></td>
						<td ><?php echo rtrim($unit_price, ', ');?></td>
						<td ><?php echo round($fld_total_amount,2);?></td>
					</tr>
					<?php $i++; }?>
		<?php }else{?>
		<tr><td colspan="8" style="text-align:center;color:red;">Sorry No Record Found</td></tr>
		<?php } ?>
