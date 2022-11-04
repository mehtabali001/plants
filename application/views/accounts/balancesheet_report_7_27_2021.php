<style>
.select2-dropdown {
    background-color: #212744;
    border: 1px solid #575252;
	border-bottom: 1px solid #2a2f4e;
}
.select2-container--default .select2-results__option[aria-selected=true] {
    background-color: #5897FB;
}
.select2-container--default .select2-selection--single {
    background-color: #212744;
    border: 1px solid #575252;
    border-radius: 4px;
	height: 36px;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #bac1dc;
    line-height: 28px;
	padding-top: 2px;
}
.col-form-label {
    text-align: center;
}
.btn-success, .btn-info, .btn-primary, .btn-warning,.btn-danger,.btn-gradient-primary,.btn-gradient-danger{
	box-shadow: 0 0 black;
}
.btn-success{
	border: 1px solid #575252;
    background-color: #212744;
}
.btn-success:hover {
    background-color: #212744;
    border-color: #575252;
}
.daterangepicker .calendar-table {
    background-color: #10163B;
}
.daterangepicker {
    background-color: #10163B;
	border: 1px solid #506ee4;
}
.daterangepicker td.off, .daterangepicker td.off.in-range, .daterangepicker td.off.start-date, .daterangepicker td.off.end-date {
    background-color: #10163B;
}
.daterangepicker td.available:hover, .daterangepicker th.available:hover {
    background-color: #8a8787;
}
.boxshadow{
	box-shadow: none !important;
}
.btn-secondary{
	box-shadow: none !important;
}
#datatable_filter > label
{
	float: right;
}
#footable-2_filter > label
{
	float: right;
}
.pagination
{
	float: right;
}
.dataTables_empty
{
	text-align: center;
}
.btn-success, .btn-info, .btn-primary, .btn-warning,.btn-danger,.btn-gradient-primary,.btn-gradient-danger{
	box-shadow: 0 0 black;
}
.hide {display: none; }
.form-group label{
	font-size: 12px;
}
.nav-tabs {
    border-bottom: 2px solid #506ee4;
}
#filterhtml{
    margin-top:20px;
}
</style>
<? $role_permissions  = explode(",",$this->session->userdata('permissions')); ?>
<div class="container-fluid">
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right">
    			<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Vouchers/chequepaidvoucher" type="button" class="btn btn-outline-primary"><i class="fa fa-shopping-cart"></i>&nbsp;Cheque Paid Voucher</a>
                  <a href="<?= base_url();?>Vouchers/cashpayementvoucher" type="button" class="btn btn-outline-primary"><i class="fa fa-vcard"></i>&nbsp;Cash Payment Voucher</a>
                  <a href="<?= base_url();?>Vouchers/journalvoucher" type="button" class="btn btn-outline-primary"><i class="fa fa-files-o"></i>&nbsp;Journal Voucher</a>
                  <a href="<?= base_url();?>Accounts/incomereport" type="button" class="btn btn-primary btn-large"><i class="fa fa-bar-chart"></i>&nbsp;Income Report</a>
                </div>
			</div>
			<h4 class="page-title">Balance Sheet</h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="javascript:void(0);">Accounts</a></li>
				<li class="breadcrumb-item active">Balance Sheet</li>
			</ol>
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<form action="" method="post" >
				<div class="row" id="purchasediv" style="justify-content:center;">
				<div class="col-lg-12">
				<?php $error_message = $this->session->userdata('error_message');
				if (isset($error_message)) {
					?>
					<div class="alert alert-danger">
						
						<?php echo $error_message ?>                    
					</div>
					<?php
					$this->session->unset_userdata('error_message');
				}?>
				<?php $success_message = $this->session->userdata('success_message');
				if (isset($success_message)) {
					?>
					<div class="alert alert-success">
						
						<?php echo $success_message ?>                    
					</div>
					<?php
					$this->session->unset_userdata('success_message');
				}?>
				</div>
				
				
				            <div class="col-sm-3">
    							<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" onchange="this.form.submit();" name="year" id="year" required>
    							        
    							        <?php 
    							          $now = date('Y-m-d');
    							          $years = $this->db->query("SELECT * FROM app_years order by id asc")->result_array();
    							          foreach($years as $row){ ?>
    							            <option value="<?=$row['year_id'];?>" <?php if(isset($_POST['year'])){ if($_POST['year']==$row['year_id']){ echo 'selected'; }}elseif (($now >= $row['date_start']) && ($now <= $row['date_end'])){ echo 'selected'; } ?>><?=$row['year_name'];?></option>
    							          <?php } ?>
    							          
    							</select>
    						</div>
    						
                        <button type="button" style="margin: 0px 10px;background-color: DodgerBlue;" id="print_report" onclick="printPdfIncomeReport(1);" class="btn  print_report" name="" value="" disabled><i class="fa fa-print" aria-hidden="true"></i>&nbsp;Print Report</button>
					
                        <button type="button" style="margin: 0px 10px;" id="pdf_purchase_report" class="btn btn-gradient-pink pdf_purchase_report" onclick="printPdfIncomeReport(2);" name="" value="" disabled><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;Download PDF</button>
						
                    
				</div>
				</form> 
				</div>
				<div id="filterhtml">
				    
				    <style>
h3{
    text-align:center;
}
p{
    text-align:center;
}
.search_filter td {
    /*border: none !important;*/
    color: #000;
    font-weight: bold;
}
.search_finalsum td {
    /*border: none !important;*/
    /*background: rgb(245 222 179) !important;*/
    color: white;
    font-weight: bold;
}
.even{
    color:green;
}
.odd{
    color:red;
}
</style>
<?php
if(isset($_POST['year'])){
    $year = $this->db->query("SELECT * FROM app_years where year_id = '{$_POST['year']}'")->row_array();
    $start_date = $year['date_start'];
    $end_date = $year['date_end'];
}else{
    $year = $this->db->query("SELECT * FROM app_years ORDER BY id DESC LIMIT 0,1")->row_array();
    $start_date = $year['date_start'];
    $end_date = $year['date_end'];  
}

?>
<h3>Balance Sheet</h3>
<p><?=$start_date?>&nbsp;&nbsp;&nbsp;<span>To</span>&nbsp;&nbsp;&nbsp;<?=$end_date?></p>
<div class="row">
   <div class=" col-sm-12">
            
            <div class="row">
                
                <div class="col-sm-6">
                    <div class="custom-dd dd" id="nestable_list_1">
                        <ol class="dd-list">
                            <?php

                                $visit=array();
                                for ($i = 0; $i < count($assets); $i++)
                                {
                                    $visit[$i] = false;
                                }
            
                                $this->Accounts_model->balancesheetdfs("Assets","1",$assets,$visit,0, 0, $start_date, $end_date);
                                
                                ?>
                        </ol>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="custom-dd dd" id="nestable_list_2">
                        <ol class="dd-list">
                            <?php

                                $visit=array();
                                for ($i = 0; $i < count($liabilitiesequity); $i++)
                                {
                                    $visit[$i] = false;
                                }
            
                                $this->Accounts_model->balancesheetdfs("Liabilities & Owners Equity","2",$liabilitiesequity,$visit,0, 1, $start_date, $end_date);
                                
                                ?>
                        </ol>
                    </div>
                </div>
                
            </div><!--end card-body-->
    </div><!--end col-->
</div>


				
				</div>
				
				
			</div>
			</div> <!-- end card-body -->
		</div> <!-- end card -->                                       
	</div> <!-- end col -->


</div>

</div><!-- container -->
<input type="hidden"  id="dfrom_date" value="<?= date('m/d/Y',strtotime('-30 days'))?>" />
<input type="hidden"  id="dto_date" value="<?= date('m/d/Y')?>" />
<script>
   function btnActive(val){
       
       if(val!=''){
           $('#show_report').removeAttr("disabled");
       }else{
           $("#show_report").attr( "disabled", "disabled" );
       }
   }

</script>

                