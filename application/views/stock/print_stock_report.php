<!DOCTYPE html>
<html>
<head>
	<title>Daybook Report </title>

	

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
@media print { 
body {
  position: relative;
  }
.bel p{ {
  
  }
}
</style>
</head>
<body>
	<div class="container-fluid" style="margin-top:10px;">
							      
                                  <table class="table table-borderless"style="width:100%;">
                                    <tbody>
                                        <tr>
                                            <td style="width:63%;text-align:left">
                                                <? $settings=$this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row_array();?>
                                                <img class="company-logo" src="<?=base_url()?>/assets/uploads/logo/<?=$settings['system_logo'];?>" style="height:70px;float:left;">
                                            </td>
                                            <td>
                                                <div class="detail text-left" >
                                                    <? $plant_name =	$this->Common_model->select_single_field('fld_location','tbl_locations',array('fld_id'=>$_GET['plant_for']));?><br>
                                                    <span style="font-weight:bold;">Type</span>&nbsp;<span class="">Stocks Report</span><br>
                                                     <span style="font-weight:bold;">Showing Report As:</span>&nbsp; <?php if(empty($plant_name)){echo "All Plants";}else{ echo $plant_name;} ?> <br>
                                                     <span style="font-weight:bold;">From:</span>&nbsp;<span class="fromDate"></span><br>
                                                     <span style="font-weight:bold;">To:</span>&nbsp;<span class="toDate"></span><br>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

<hr style="width:100%;">
								<!--<h3 class="text-center shadowhead txtbold"></h3>
								<h3 class="text-center AccName txtbold">.</h3>
								<p class="text-center"><span class="from"><strong>From:-</strong><span class="fromDate">[0000/00/00]</span></span> To <span class="to"><strong>To:-</strong><span class="toDate">[0000/00/00]</span></span></p>-->
								<table id="datatable_tb" class="voucher-table table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;margin-top: 5%;">
									<thead class="htmlRows1">
									</thead>
									<tbody id="stock_data">
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
			</div>
		<div class="bel">
		    <p style="position: sticky;font-style: italic; bottom: 0; color:#5d5d5d;"><span style="font-weight:bold;">Note:</span> This is auto generated report on <?= date('d - M - Y'); ?>, <?= date('h:i A'); ?> by <?= $this->session->userdata('user_name'); ?> account  and requires signature from the approval authority.</p>
		    </div>
	<script type="text/javascript" src="<?= base_url();?>/assets/theme_elements/js/jquery.min.js"></script>

<script type="text/javascript">
		$(function(){

			var opener = window.opener;
			
			var fromDate = opener.$('#from_date').val();
			var toDate = opener.$('#to_date').val();			
			var etype = opener.$('.form-section').text();
			if (opener.$('#datatable_tb').is(':visible')) {
				// var parentRows = opener.$(".purchaseRows tr");
				// var rowsHtml = '';

				// var parentRows1 = '';
				var parentRows1 = opener.$(".dthead tr").clone();
				$('.htmlRows1').append(parentRows1);
				// $(".htmlRows1").find('.printRemove').remove();
				
				// var netBalance = 0;
				 var parentCopy = opener.$('.stockRows tr').clone();
				 console.log(parentCopy);
				parentCopy.find('.printRemove').remove();
								

				$('#stock_data').append(parentCopy);
				$("a").removeAttr("href");
				
		    }
		   // var what =opener.$('#filter').val().toLowerCase();
		    var what =opener.$("#filter option:selected").text().toLowerCase();

			// Charts 
			
			// End Charts
			$('.fromDate').html(fromDate);
			$('.toDate').html(toDate);
			$('.reporttype').html(what);
			
			// alert(parentCopy);
			$('.shadowhead').html(etype);
			// $('.netBalance').html(netBal);
			window.print();
			
		});
	</script>
</body>
</html>