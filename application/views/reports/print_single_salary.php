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
<table class="table table-borderless" style="width: 100%;">
     <? 
         $designation =	$this->Common_model->select_single_field('designation_name','tbl_designation',array('id'=>$salary['designation']));       
       //$department  =	$this->Common_model->select_single_field('department_name','tbl_departments',array('id'=>$emp['department']));
    	 $plant       =	$this->Common_model->select_single_field('fld_location','tbl_locations',array('fld_id'=>$salary['plants']));
    	 $name        =	$this->Common_model->select_single_field('full_name','tbl_employees',array('id'=>$salary['user_id']));
    	 $code        =	$this->Common_model->select_single_field('employee_code','tbl_employees',array('id'=>$salary['user_id']));
        ?>
    <tbody>
        <tr>
            <td style="width:65%;text-align:left">
                <img class="company-logo" src="<?= base_url()?>assets/custom_elements/images/logoreport.png" style="height:70px;float:left;">
            </td>
            <td>
                <div class="detail text-left" >
                    <span style="font-weight:bold;">Emp.Code: </span><span class="fromDate"><?=$code;?></span><br>
                    <span style="font-weight:bold;">Name: </span>&nbsp;<span class="fromDate"><?=$name;?></span><br>
                    <span style="font-weight:bold;">Designation: </span>&nbsp;<span class="fromDate"><?=$designation;?></span><br>
                    <span style="font-weight:bold;">Location: </span>&nbsp;<span class="fromDate"><?=$plant;?></span><br>
                    <span style="font-weight:bold;">Salary Month :</span>&nbsp;<?= $salary['month'].', '.$salary['year'];?><br>
                    <span style="font-weight:bold;">Payment Type :</span>&nbsp;<?= $salary['paid_via'];?><br>
                </div>
            </td>
        </tr>
    </tbody>
</table>

<hr style="width:100%;">
<table id="datatable_tb" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
	<!--<thead class="dthead">-->
									    <tr><th colspan="2" style="text-align:left;"><br>Benefits (PKR)<br></th></tr>
	<!--<tr>-->
	<!--	 <th>Basic Pay</th>-->
 <!--       <th>Med. Allow.</th>-->
	<!--	<th>Other</th>-->
 <!--       <th>Gross Pay</th>-->
	<!--</tr>-->
	<!--</thead>-->
	


	<tbody class="purchaseRows" id="purchaseRows">
		 
        <?php if($salary){
	$med_allownce   =	$this->Common_model->select_single_field('med_allow','tbl_employees',array('id'=>$salary['user_id']));
	$otherfac   =	$this->Common_model->select_single_field('other','tbl_employees',array('id'=>$salary['user_id']));
	$grosspay   =	$this->Common_model->select_single_field('gross_pay','tbl_employees',array('id'=>$salary['user_id']));
	$eobi   =	$this->Common_model->select_single_field('eobi','tbl_employees',array('id'=>$salary['user_id']));
 $social_security   =	$this->Common_model->select_single_field('social_security','tbl_employees',array('id'=>$salary['user_id']));
$salary_tax   =	$this->Common_model->select_single_field('salary_tax','tbl_employees',array('id'=>$salary['user_id']));
 $t_deductions   =	$this->Common_model->select_single_field('t_deductions','tbl_employees',array('id'=>$salary['user_id']));
	?>
	
	<tr>
	    <td>Basic Pay</td>
	    <td><?= $salary['basic_salary'];?></td>
	</tr>
	<tr>
	    <td>Med. Allow.</td>
	    <td><?=$med_allownce;?></td>
	</tr>
	<tr>
	    <td>Other</td>
	    <td><?=$otherfac;?></td>
	</tr>
	<tr>
	    <td>Gross Pay</td>
	    <td><?=$grosspay;?></td>
	</tr>
	
	    <!--<tr>-->
	        
	        
	        
	        
	    <!--</tr>-->
		
		    <tr><th colspan="2" style="text-align:left;"><br>Deductions(PKR)<br> </th></tr>
			<tr>
        		 <td>EOBI</td>
        		 <td><?=$eobi;?></td>
        		 </tr>
        		 <tr>
                <td>Social Security</td>
                <td><?=$social_security;?></td>
                </tr>
        		 <tr>
        		<td>Salary Tax</td>
        		<td><?=$salary_tax;?></td>
        		</tr>
        		 <tr>
                <td>Total Deductions</td>
                <td><?=$t_deductions;?></td>
                </tr>
        		 
        	
    	    <tr>
    	        <td style="text-align:right;font-weight:bold;">Net Payment (PKR)</td>
    	        <td><?=$salary['amount_paid'];?></td>
    	    </tr>
	
		<?php
		}else{?>
		<tr><td colspan="4" style="text-align:center;color:red;">Sorry No Record Found</td></tr>
		<?php } ?>
	</tbody>
	</table>
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