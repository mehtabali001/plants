<style>
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #bac1dc;
    line-height: 28px;
    padding-top: 2px;
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
	min-height: 36px;
}
.select2-container--default .select2-selection--multiple {
    background-color: #212744;
    border: 1px solid #575252;
    border-radius: 4px;
	min-height: 36px;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #bac1dc;
    line-height: 28px;
    padding-top: 2px;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #212744;
    font-size: 10px;
}
#datatable_filter > label
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
/*popup*/


.modalbg {
  position: fixed;
  font-family: Arial, Helvetica, sans-serif;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  background: rgba(0, 0, 0, 0);
  z-index: 99999;
  -moz-transition: all 2s ease-out;
  -webkit-transition: all 2s ease-out;
  -o-transition: all 2s ease-out;
  transition: all 2s ease-out;
  -webkit-transition-delay: 0.2s;
  -moz-transition-delay: 0.2s;
  -o-transition-delay: 0.2s;
  -transition-delay: 0.2s;
  display: block;
  pointer-events: none;
}
.modalbg .dialog {
  width: 400px;
  position: relative;
  top: -1000px;
  margin: 10% auto;
  padding: 5px 20px 13px 20px;
  -moz-border-radius: 10px;
  -webkit-border-radius: 10px;
  border-radius: 10px;
  background: #060c24;
  background: -moz-linear-gradient(#fff, #ccc);
  background: -webkit-linear-gradient(#060c24, #060c24);
  background: -o-linear-gradient(#fff, #ccc);
  box-shadow: 0 0 10px #000;
  -moz-box-shadow: 0 0 10px #000;
  -webkit-box-shadow: 0 0 10px #000;
  
}
.modalbg .dialog .ie7 {
  filter: progid:DXImageTransform.Microsoft.Shadow(color='#000', Direction=135, Strength=3);
}
.modalbg:target {
  display: block;
  pointer-events: auto;
  background: rgba(4, 10, 30, 0.8);
  -moz-transition: all 0.5s ease-out;
  -webkit-transition: all 0.5s ease-out;
  -o-transition: all 0.5s ease-out;
  transition: all 0.5s ease-out;
}
.modalbg:target .dialog {
  top: -20px;
  -moz-transition: all 0.8s ease-out;
  -webkit-transition: all 0.8s ease-out;
  -o-transition: all 0.8s ease-out;
  transition: all 0.8s ease-out;
  -webkit-transition-delay: 0.4s;
  -moz-transition-delay: 0.4s;
  -o-transition-delay: 0.4s;
  -transition-delay: 0.4s;
}
.close {
  background: #606061;
  color: #FFFFFF;
  line-height: 25px;
  position: absolute;
  right: -12px;
  text-align: center;
  top: -10px;
  width: 24px;
  text-decoration: none;
  font-weight: bold;
  -webkit-border-radius: 12px;
  -moz-border-radius: 12px;
  border-radius: 12px;
  box-shadow: 0 0 10px #000;
  -moz-box-shadow: 0 0 10px #000;
  -webkit-box-shadow: 0 0 10px #000;
  -moz-transition: all 0.5s ease-out;
  -webkit-transition: all 0.5s ease-out;
  -o-transition: all 0.5s ease-out;
  transition: all 0.5s ease-out;
  -webkit-transition-delay: 0.2s;
  -moz-transition-delay: 0.2s;
  -o-transition-delay: 0.2s;
  -transition-delay: 0.2s;
}
.close .ie7 {
  filter: progid:DXImageTransform.Microsoft.Shadow(color='#000', Direction=135, Strength=3);
}
.close:hover {
  background: #00d9ff;
  -moz-transition: all 0.5s ease-out;
  -webkit-transition: all 0.5s ease-out;
  -o-transition: all 0.5s ease-out;
  transition: all 0.5s ease-out;
}
.fineprint {
  font-style: italic;
  font-size: 10px;
  color: #646;
}
a {
  /*color: #333;*/
  text-decoration: none;
}
.hide {
  display: none;
}
.popover{
    left: 1106px !important;
}
</style>
<style type="text/css">
   .txtedit{
      display: none;
      width: 98%;
   }
</style>
<script>
 function show1(){
  document.getElementById('div1').style.display ='none';
}
function show2(){
  document.getElementById('div1').style.display = 'block';
}
</script>
<div class="container-fluid">
<div class="row">
    <div class="col-sm-12">
		<div class="page-title-box">
			<div class="float-right" style="margin-bottom:15px;">
				<div class="btn-group" role="group" aria-label="Basic outlined example">
				  <a href="<?= base_url();?>Sales" type="button" class="btn btn-outline-primary"><i class="fa fa-shopping-cart"></i>&nbsp;New Sale</a>    
                  <a href="<?= base_url();?>SaleRate" type="button" class="btn btn-primary btn-large"><i class="fas fa-sort-amount-up-alt"></i>&nbsp;New Daily Sale Rate</a>
                  <a href="<?= base_url();?>SaleRate/manage_salerateHistory" type="button" class="btn btn-outline-primary"><i class='fas fa-eye'></i>&nbsp;View Sales History</a>
                  <a href="<?= base_url();?>Sales/salesReport" type="button" class="btn btn-outline-primary"><i class="fa fa-bar-chart"></i>&nbsp;Sales Report</a>
                </div>&nbsp;&nbsp;
			</div>
			<!--<h4 class="page-title">+ Sales Rate</h4>-->
			<!--<ol class="breadcrumb">-->
			<!--	<li class="breadcrumb-item"><a href="javascript:void(0);">Sales Rate</a></li>-->
			<!--	<li class="breadcrumb-item active">+ Sale Rate</li>-->
			<!--</ol>-->
			<!--<p>NOTE: The following displayed attendance is shown only today's attendance.</p>-->
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>    


<!-- end page title end breadcrumb -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12">
                        <?php 
						$error_message = $this->session->userdata('error_message');
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
                        
                             <form action="<?= base_url('SaleRate/addSalerate');?>" method="post">
                             <!-- <div class="col-sm-12">-->
        						<!--	<h4 class="form-section"><i class="icon-eye6"></i>Add Sale Rate <div></div> <div class="ml3" style="float:right;color:#1ad1bc;display:none; font-size:11px;">Saved in Draft Automatically.</div></h4>-->
        						<!--</div>-->
        						<!--<hr>-->
                                <div class="row">
                            		<div class="col-md-2">
                                      	<div class="form-group row">
                                            <div class="col-sm-12">
                                			    <label for="example-date-input" class="col-form-label">Date</label>
                                                <input class="form-control datepicker" type="text" name="date" id="example-date-input" <? if(isset($_GET['date'])) { ?> value="<?=date("d/m/Y",strtotime($_GET['date']));?>" <? } ?>>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group row ">
                                            <div class="col-sm-12">
                            				<label class="col-form-label">Select Plant</label>
                                                <select class="select2 form-control mb-3 custom-select" id="plants" name="plants" required>
                                                    <option value="">--Select Plant--</option>
                                                    <?php 
                                					   // $tbl_plants	=	$this->Common_model->select_where_ASC_DESC('fld_id,fld_location','tbl_locations',array('fld_status'=>1,'fld_id' != 4),'fld_location','ASC');
                                					   $tbl_plants = $this->db->query('Select * from tbl_locations where fld_status = 1 and fld_id != 4 Order By fld_location ASC')->result_array();
                                                        //if($tbl_plants->num_rows() > 0) {
                                                        foreach($tbl_plants as $plant){
                                                    ?>
                                                        <option value="<?php echo $plant['fld_id'];?>" <? if(!empty($_GET['plants']) && $_GET['plants'] == $plant['fld_id']){ echo "selected"; } ?>><?php echo $plant['fld_location'];?></option>
                                                    <?php }  ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <?/*?><div class="col-md-3">
                                        <div class="form-group row ">
                                            <div class="col-sm-12">
                            				<label class="col-form-label">Select Category</label>
                                                <select class="select2 form-control mb-3 custom-select" id="category" name="category[]" multiple="multiple" required>
                                                    <option value="">--Select Category--</option>
                                                    <?php 
                                					    $tbl_category	=	$this->Common_model->select_where_ASC_DESC('fld_id,fld_category','tbl_category',array('fld_status'=>1),'fld_category','ASC');
                                                        if($tbl_category->num_rows() > 0) {
                                                        foreach($tbl_category->result() as $cat){
                                                    ?>
                                                        <option value="<?php echo $cat->fld_id;?>"><?php echo $cat->fld_category;?></option>
                                                    <?php } } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div><?*/?>
                                <div class="col-md-2" style="margin-top: 38px;">
                                    <button type="submit" class="btn btn-successs waves-effect waves-light">Proceed</button>
                                </div>
                                </div>
                            </form>
	                <hr>
	                <script>
	                    var historyData = [];
	                </script>
	     <!--           <div class="col-sm-12">-->
						<!--	<h4 class="form-section"> <div class="ml3" id="msg" style="float:right;color:#1ad1bc;display:none; font-size:11px;">SaleRate Saved Automatically.</div></h4><br><br>-->
						<!--</div>-->
					<?php  if (isset($success_message)) {?>	
					<form action="<?= base_url('SaleRate/changeSalerate');?>" method="post">
					<div class="table-responsive">    
                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%; ">
                        <thead>
                        <tr>
                            <th>Sr #</th>
                            <th>Date</th>
                            <th>Plant</th>
                            <th>Category</th>
							<th>Sub Category</th>
                            <!--<th>Purchase</th>-->
							<th>Sale</th>
                        </tr>
                        </thead>
                        <tbody id="employee_data">
        				<?php 
        				
                        if($history){
                            $i = 1;
                        foreach($history as $hist){ 
        					 $plant        =	 $this->Common_model->select_single_field('fld_location','tbl_locations',array('fld_id'=>$hist['plants']));
        					 $category     =	 $this->Common_model->select_where_return_row('fld_category,fld_unit','tbl_category',array('fld_id'=>$hist['category']));
        					 $subcategory     =	 $this->Common_model->select_where_return_row('*','tbl_subcategory',array('fld_subcid'=>$hist['sub_category']));
        					 $unit     =	 $this->Common_model->select_single_field('fld_unit','tbl_units',array('fld_id'=>$category->fld_unit));
                        ?>
                        <script>
                            var dataObject = {};
                            dataObject['category'] = <?=$hist['category'];?>;
                            dataObject['sub_category'] = <?=$hist['sub_category'];?>;
                            dataObject['id'] = <?=$hist['id'];?>;
                            dataObject['weight'] = <?=$subcategory->weight;?>;
                            historyData.push(dataObject);
                        </script>
                        <tr>
                            <input type="hidden" name="rate_id[]" value="<?=$hist['id'];?>">
                            <td><?php echo $i++; ?></td>
                            <td><?php echo date("d/m/Y",strtotime($hist['date']));?></td>
							<td><?=$plant;?></td>
                            <td><?=$category->fld_category;?> </td>
                            <td><?=$subcategory->fld_subcategory;?>&nbsp;<?=$unit;?></td>
							<!--<td class="purchase"> -->
							<!--  <input type="number" style="width: 100%;height: 100%;background: #FFF;border: none;padding: 10px;" min=0 max=30 value="<?//=$hist['purchase'];?>" onkeyup="updateValue('purchase', <?//=$hist['id'];?>)" onblur="updateValue('purchase', <?//=$hist['id'];?>)" id="purchase_<?//=$hist['id'];?>">-->
							<!--</td>-->
							<td class="sale">
							  <input type="number" name="sale_rate[]" style="width: 100%;height: 100%;background: #FFF;border: none;padding: 10px;" required  value="<?=$hist['sale'];?>"  id="sale_<?=$hist['id'];?>" <?php if($hist['category'] == 1 && $subcategory->weight != '11.8' && $subcategory->weight != '1000'){ ?> readonly <?php }else{  ?> onkeyup="updateValue('sale', <?=$hist['id'];?>, <?=$hist['category'];?>, <?=$hist['sub_category'];?>)" onblur="updateValue('sale', <?=$hist['id'];?>, <?=$hist['category'];?>, <?=$hist['sub_category'];?>)"  <?php } ?>>
							</td>
							</tr>
						<?php }}else { ?>
						<tr>
							<td colspan="7"><br><p style="color:#900; text-align: center;" >Sorry No Record Found!</p></td>
						</tr>
						
						<? } ?>
						</tbody>
                    </table>
                    </div>
                    <button type="sumbit" class="btn btn-successs" name="submit_sale_rate">Proceed</button>
                    </form>
                    <?}?>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
</div>  

<script>
    function updateValue(key, id, cat=0 , subcat= 0){
       
        var purchase = $("#purchase_"+id).val();
        var sale = $("#sale_"+id).val();
        var postData;
        if(key == 'purchase'){
            postData = 'name=purchase&value='+purchase+'&pk='+id;
        }else if(key == 'sale'){
            console.log(historyData);
            if(cat==1 && subcat == 4){
                
                for (i = 0; i < historyData.length; i++) {
                
                if(historyData[i].category == 1 && historyData[i].weight != 1000){
                    var perKg = sale / 11.8;
                   
                    if(historyData[i].weight != 11.8){
                        // console.log(historyData[i].weight+" "+perKg*historyData[i].weight+" "+perKg);
                        var newrate = perKg*historyData[i].weight;
                        $("#sale_"+historyData[i].id).val(newrate);
                        ajaxautosaleupdate(historyData[i].id, newrate);
                    }else{
                       
                      if(id != historyData[i].id){
                          $("#sale_"+historyData[i].id).val(sale);
                          ajaxautosaleupdate(historyData[i].id, sale);
                      }
                    }
                }
            }
            }
            
            postData = 'name=sale&value='+sale+'&pk='+id;
            
        }
        
        
        
        jQuery.ajax({
				url  	: base_url+"SaleRate/update_salerate",
				type 	: 'POST',
				data 	: postData,
				success : function(data){
				    console.log(data);
				}
		});	
    
}
function ajaxautosaleupdate(id, value){
    var postDataS;
    postDataS = 'name=sale&value='+value+'&pk='+id;
    jQuery.ajax({
				url  	: base_url+"SaleRate/update_salerate",
				type 	: 'POST',
				data 	: postDataS,
				success : function(data){
				    console.log(data);
				    $('#msg').css('display','block');
                    var textWrapper = document.querySelector('.ml3');
                    textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");
                    anime.timeline({loop: true})
                      .add({
                        targets: '.ml3 .letter',
                        opacity: [0,1],
                        easing: "easeInOutQuad",
                        duration: 2250,
                        delay: (el, i) => 150 * (i+1)
                      }).add({
                        targets: '.ml3',
                        opacity: 0,
                        duration: 1000,
                        easing: "easeOutExpo",
                        delay: 1000
                      });
				}
		});	
}
</script>
<script>
    //  $('#fld_customer_id, #fld_location, #fld_category, #fld_payment_type, #fld_bank,.fld_product_id').change(function(){       
    //             var selectedOption = $(this).val();
    //             // $(this).val('')   
    //             // alert(selectedOption);
    //             // return false;
    //             saveData();
    //                 $('.ml3').css('display','block');
    //                 var textWrapper = document.querySelector('.ml3');
    //                 textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");
                    
    //                 anime.timeline({loop: true})
    //                   .add({
    //                     targets: '.ml3 .letter',
    //                     opacity: [0,1],
    //                     easing: "easeInOutQuad",
    //                     duration: 2250,
    //                     delay: (el, i) => 150 * (i+1)
    //                   }).add({
    //                     targets: '.ml3',
    //                     opacity: 0,
    //                     duration: 1000,
    //                     easing: "easeOutExpo",
    //                     delay: 1000
    //                   }); 
    //           });
</script>
