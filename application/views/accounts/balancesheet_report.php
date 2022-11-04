<style>
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #bac1dc;
    line-height: 28px;
    padding-top: 2px; 
    text-align: center;
}
hr {
    margin-top: 0;
    margin-bottom: 0;
    border: 0;
    border-top: 1px solid #d5d7e5;
}
/*.btn {*/
/*    font-size: 0.645rem;*/
/*}*/

.dd {
    position: relative;
    display: block;
    margin: 10px;
    padding: 0;
    max-width: 600px;
    list-style: none;
    font-size: 13px;
    line-height: 20px;
    border: 1px solid #eee;
}
.dd-handle {
    display: block;
    height: 30px;
    margin: 1px 0;
    padding: 5px 10px;
    color: #333;
    text-decoration: none;
    font-size: 10px;
    font-weight: 200;
    /* border: 0px solid #ccc; */
    background: #ffffff;
    border-radius: 0px;
    box-sizing: border-box;
    border-top: 0px solid;
    border-right: 0px;
    border-left: 0px;
}
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
/*#filterhtml_1{*/
/*    margin:auto;*/
/*}*/
.page-title-box {
    padding-bottom:0 !important;
    padding-top: 25px;
}
.app-search {
    position: relative;
    padding-top: 5px;
    margin-left: 20px;
    margin-bottom: 10px;
        width: auto;
    
}
</style>
<? $role_permissions  = explode(",",$this->session->userdata('permissions')); ?>
<div class="container-fluid">
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right" style=" margin-bottom:10px;">
    			<div class="btn-group" role="group" aria-label="Basic outlined example">
                  <a href="<?= base_url();?>Accounts/balancesheet" type="button" class="btn btn-outline-primary"><i class="fa fa-files-o"></i>&nbsp;COA</a>
                  <a href="<?= base_url();?>Accounts/balancesheet_report" type="button" class="btn btn-primary btn-large"><i class="fa fa-bar-chart"></i>&nbsp;Balance Sheet</a>
                  <a href="<?= base_url();?>Accounts/profitandlossReport" type="button" class="btn btn-outline-primary "><i class="fa fa-vcard"></i>&nbsp;Profit & Loss report</a>
                  <a href="<?= base_url();?>Accounts/trailbalance" type="button" class="btn btn-outline-primary"><i class="fa fa-files-o"></i>&nbsp;Trial Balance</a>
                </div>
			</div>
			<!--<h4 class="page-title">Balance Sheet</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Accounts</a></li>-->
			<!--	<li class="breadcrumb-item active">Balance Sheet</li>-->
			<!--</ol>-->
		</div><!--end page-title-box-->
	</div><!--end col-->
	<script>
        function search_bar() {
    let input = document.getElementById('balancesheetsearch_input').value
    input=input.toLowerCase();
    let x = document.getElementsByClassName('dd-item');
      
    for (i = 0; i < x.length; i++) { 
        if (!x[i].innerHTML.toLowerCase().includes(input)) {
            x[i].style.display="none";
        }
        else {
            x[i].style.display="block";                 
        }
    }
}
	</script>
	<!--<div class="container">-->
	<!--    <div class="float-right" style="padding:0 !important;">-->
 <!--   			<div class="hide-phone app-search">-->
 <!--                       <form role="search" class="">-->
 <!--                           <input type="text" id="balancesheetsearch_input" onkeyup="search_bar()" placeholder="Search..." class="form-control" autocomplete="off">-->
 <!--                       </form>-->
 <!--                   </div>-->
	<!--		</div>-->
	<!--</div>-->
	<div class="col-sm-12" style="display:none">
	    <div class="float-right" style="padding-bottom:15px;">
			<div class="btn-group" role="group" aria-label="Basic outlined example" style="border: 1px solid #506ee4;border-radius: 5px;">
              <a type="button" style="background-color: DodgerBlue;" id="print_report" onclick="printPdfBalanceSheet(1);" class="btn  print_report" name="" value="" disabled><i class="fa fa-print" aria-hidden="true"></i>&nbsp;Print Report</a>
			  <a type="button"  id="pdf_purchase_report" class="btn btn-gradient-pink pdf_purchase_report" onclick="printPdfBalanceSheet(2);" name="" value="" disabled><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;Download PDF</a>
            </div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				
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
				
				
				      <!---->
    						
                        <!--<button type="button" style="margin: 0px 10px;background-color: DodgerBlue;" id="print_report" onclick="printPdfIncomeReport(1);" class="btn  print_report" name="" value="" disabled><i class="fa fa-print" aria-hidden="true"></i>&nbsp;Print Report</button>-->
					
                        <!--<button type="button" style="margin: 0px 10px;" id="pdf_purchase_report" class="btn btn-gradient-pink pdf_purchase_report" onclick="printPdfIncomeReport(2);" name="" value="" disabled><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;Download PDF</button>-->
						
                    
				</div>
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
.app-search a {
    position: absolute;
    top: 5px;
    left: 0px;
    background: #fff0;
    border: 1px solid #fff0;
    height: 0 !important;
    border-radius: 50%;
}
.app-search .form-control, .app-search .form-control:focus {
    padding-left: 30px;
        width: auto;
}
</style>
<?php
if(isset($_POST['year'])){
    $year = $this->db->query("SELECT * FROM app_years where year_id = '{$_POST['year']}'")->row_array();
    $start_date = $year['date_start'];
    $end_date = $year['date_end'];
}else{
    $year = $this->db->query("SELECT * FROM app_years ORDER BY id DESC LIMIT 0,1")->row_array();
    $start_date = date("Y-m-d",strtotime($year['date_start']));
    $end_date = date("Y-m-d",strtotime($year['date_end']));  
}

?>
<!--<h3>Balance Sheet</h3>-->
<!--<p><?//=$start_date?>&nbsp;&nbsp;&nbsp;<span>To</span>&nbsp;&nbsp;&nbsp;<?//=$end_date?></p>-->
<form action="" method="post" id="formid">
    <input type="hidden" name="level" id="level" value="<? if(isset($_POST['level'])){echo $_POST['level'];}else{ echo '1';} ?>" />
<div class="container">
    <div class="row">
		
		<div class="col-sm-3">
		    <div class="hide-phone app-search">
                <form role="search" class="">
                    <input type="text pl-3" id="balancesheetsearch_input" onkeyup="search_bar()" placeholder="Type to search...." class="form-control" autocomplete="off"><a><i class="fas fa-search"></i></a>
                </form>
            </div>
		</div>
		<div class="col-sm-6">
		    <div class="row" style="justify-content:center;margin-top: 5px;">
    <!--<div class="col-sm-2"></div>-->
            <div class="col-sm-4">
            	<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" onchange="this.form.submit();" name="year" id="year" required>
            	        
            	        <?php 
            	          $now = date('Y-m-d');
            	          $years = $this->db->query("SELECT * FROM app_years order by id asc")->result_array();
            	          foreach($years as $row){ ?>
            	            <option value="<?=$row['year_id'];?>" <?php if(isset($_POST['year'])){ if($_POST['year']==$row['year_id']){ echo 'selected'; }}elseif (($now >= $row['date_start']) && ($now <= $row['date_end'])){ echo 'selected'; } ?>><?=$row['year_name'];?></option>
            	          <?php } ?>
            	          
            	</select>
            </div>
			<? if(!empty($role_permissions) && in_array(189,$role_permissions)) { ?>
			<div class="col-sm-6">
			<button type="button" style="margin: 0px 10px;" id="csv_balance_sheet" class="btn btn-gradient-pink pdf_purchase_report" onclick="downloadcsv();" name="" value=""><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;Download CSV</button>
			</div>
			<? } ?>
			</div>
		</div>
		<div class="col-sm-3">
            <div class="custom-control custom-switch switch-secondary "style="float: right;margin-top: 15px;">
               <label style="margin-right: 42px;">Show Zero</label>
               <input type="checkbox" class="custom-control-input" onchange="this.form.submit();" <?php if(isset($_POST['hide_zero'])){ if($_POST['hide_zero']==1){ echo 'checked'; }} ?> id="customSwitchSecondary" value="1" name="hide_zero">
               <label class="custom-control-label" for="customSwitchSecondary">Hide Zero</label>
            </div>
    	</div>
	</div>
</div>
<hr><br>
    						<div class="row">
                            <div class="col-sm-12">
                                <div class="filter-box" style="width:460px;margin: auto;">
                                <ul class="nav nav-pills  nav-justified" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link <?php if(isset($_POST['level'])){ if($_POST['level']==1){ echo 'active'; }}?>" onclick="document.getElementById('level').value = '1'; document.getElementById('formid').submit(); bsload();" id="general_chat_tab" data-toggle="pill" href="#" style="border: 1px solid #788fe9;border-top-left-radius: 25px; border-bottom-left-radius: 25px;border-top-right-radius: 0; border-bottom-right-radius: 0;">Summarized View</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link  <?php if(isset($_POST['level'])){ if($_POST['level']==2){ echo  'active'; }}?>" id="group_chat_tab" onclick="document.getElementById('level').value = '2'; document.getElementById('formid').submit(); bsload();"  data-toggle="pill" href="#" style="border-radius:0;border: 1px solid #788fe9;">Med-Detailed View</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?php if(isset($_POST['level'])){ if($_POST['level']==3){ echo  'active'; }}?><? if(!isset($_POST['level'])){ echo  'active'; }?>" id="personal_chat_tab" onclick="document.getElementById('level').value = '3'; document.getElementById('formid').submit(); bsload();"  data-toggle="pill" href="#"style="border: 1px solid #788fe9;border-top-left-radius: 0; border-bottom-left-radius: 0;border-top-right-radius: 25px; border-bottom-right-radius: 25px;">Detailed View</a>
                                    </li>
                                </ul>
                                </div>
                            </div><!--end chat-box-left -->
                            
                        </div><br>
    							</form>
<div class="row">
   <div class=" col-sm-12">
            
            <div class="row" id="filterhtml_1">
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
   
   function downloadcsv(){
       window.location.href="<?php echo base_url(); ?>Accounts/csvBalanceSheet?year="+$("#year").val();
   }

</script>
<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>

                