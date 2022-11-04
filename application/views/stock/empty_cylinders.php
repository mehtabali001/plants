<style>
.btn-group1 {
    box-shadow: 0 5px 8px 4px #6abdcf, 0 5px 8px 4px rgb(255 255 255) !important;
    border-radius: 18px !important;
}
.button {
  background-color: #d1b52d;
  border-radius: 4px;
  color: #fff;
  font-size: 14px;
  min-width: 100px;
  opacity: 0.75;
  padding: 10px 20px;
  text-transform: uppercase;
  transition: box-shadow 0.3s, opacity 0.3s ease-in-out;
}
.button.video-count {
  position: absolute;
  right: 20px;
  top: 20px;
  z-index: 1;
}
.category-card a{
    color:#000;
}
.category-card {
    background-color: #ffffff;
    background-repeat: no-repeat;
    background-size: cover;
    border-radius: 2rem;
    display: flex;
    flex-direction: column;
    height: 175px;
    padding: 20px;
    position: relative;
    /* width: 380px; */
    margin: 10px;
    /* height: 200px; */
    box-shadow: 0px 2px 4px rgb(31 30 47 / 10%);
}
.category-card::after {
  /*background-image: linear-gradient(to right, #243953, #486284);*/
  border-radius: 2rem;
  content: "";
  height: 100%;
  left: 0;
  opacity: 0.75;
  position: absolute;
  top: 0;
  transition: opacity 0.2s ease-in-out;
  width: 100%;
  z-index: 0;
  box-shadow: 0px 2px 4px rgb(31 30 47 / 10%);
}
.category-card:hover {
  background:#506ee4;
  box-shadow: 0px 2px 4px rgb(31 30 47 / 10%);
}
.category-card:hover a{
  color:#fff;
}
.category-card:hover .heead{
  color:#fff !important;
}
.category-card:hover::after {
  opacity: 0.95;
}
.category-card:hover .content ul {
  max-height: 95px;
}

.category-card .card-link {
  border-radius: 4px;
  height: 100%;
  left: 0;
  position: absolute;
  text-indent: -9999em;
  top: 0;
  width: 100%;
  z-index: 2;
}
.category-card .content {
  margin-top: 18px;
  z-index: 1;
}
.category-card .content h2 {
  color: #fff;
  font-size: 26px;
  margin-bottom: 0;
  color:#10163a;
}
.heead{
  color: #10163a !important;
  font-size: 23px;
  margin-bottom: 0;
  font-weight:800;
}
.category-card .content ul {
  color: #fff;
  font-size: 11px;
  padding-left: 15px !important;
  line-height: 18px;
  margin: 0;
  height: 95px;
/*--   max-height: 0;*/
  
/*--   transition: height 0.2s, max-height 0.2s ease-in-out;*/
}
.category-card .video-icon {
/*--   background-image: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz48c3ZnIHdpZHRoPSIzMHB4IiBoZWlnaHQ9IjI1cHgiIHZpZXdCb3g9IjAgMCAzMCAyNSIgdmVyc2lvbj0iMS4xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIj4gICAgICAgIDx0aXRsZT5TaGFwZTwvdGl0bGU+ICAgIDxkZXNjPkNyZWF0ZWQgd2l0aCBTa2V0Y2guPC9kZXNjPiAgICA8ZGVmcz48L2RlZnM+ICAgIDxnIGlkPSJTdHlsZS1HdWlkZSIgc3Ryb2tlPSJub25lIiBzdHJva2Utd2lkdGg9IjEiIGZpbGw9Im5vbmUiIGZpbGwtcnVsZT0iZXZlbm9kZCI+ICAgICAgICA8ZyBpZD0iRGVza3RvcC1IRCIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoLTEzNS4wMDAwMDAsIC0xMjU1LjAwMDAwMCkiIGZpbGw9IiNGRkZGRkYiPiAgICAgICAgICAgIDxnIGlkPSJDYXRlZ29yeS1DYXJkLUJsb2NrIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgxMjAuMDAwMDAwLCAxMDgzLjAwMDAwMCkiPiAgICAgICAgICAgICAgICA8ZyBpZD0iQ2F0ZWdvcnktQ2FyZHMiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDAuMDAwMDAwLCAxMTguMDAwMDAwKSI+ICAgICAgICAgICAgICAgICAgICA8ZyBpZD0iV2hhdCdzLU5ldy1Ib3ZlciI+ICAgICAgICAgICAgICAgICAgICAgICAgPHBhdGggZD0iTTQzLjQxNjg3NSw3NCBMMzAuNjI1LDc0IEwzMC42MjUsNzcuNzUgTDM1LjYyNSw3Ny43NSBDMzUuOTcwNjI1LDc3Ljc1IDM2LjI1LDc4LjAzIDM2LjI1LDc4LjM3NSBDMzYuMjUsNzguNzIgMzUuOTcwNjI1LDc5IDM1LjYyNSw3OSBMMjQuNDE5Mzc1LDc5IEMyNC4wNzQzNzUsNzkgMjMuNzk0Mzc1LDc4LjcyIDIzLjc5NDM3NSw3OC4zNzUgQzIzLjc5NDM3NSw3OC4wMyAyNC4wNzQzNzUsNzcuNzUgMjQuNDE5Mzc1LDc3Ljc1IEwyOS4zNzUsNzcuNzUgTDI5LjM3NSw3NCBMMTYuNTgzMTI1LDc0IEMxNS43MTA2MjUsNzQgMTUsNzMuMjc2ODc1IDE1LDcyLjM4ODEyNSBMMTUsNTUuNjExODc1IEMxNSw1NC43MjMxMjUgMTUuNzEwNjI1LDU0IDE2LjU4MzEyNSw1NCBMNDMuNDE2ODc1LDU0IEM0NC4yODkzNzUsNTQgNDUsNTQuNzIzMTI1IDQ1LDU1LjYxMTg3NSBMNDUsNzIuMzg4MTI1IEM0NSw3My4yNzY4NzUgNDQuMjg5Mzc1LDc0IDQzLjQxNjg3NSw3NCBaIE00My43NSw1NS42MTE4NzUgQzQzLjc1LDU1LjQxNTYyNSA0My41OTc1LDU1LjI1IDQzLjQxNjg3NSw1NS4yNSBMMTYuNTgzMTI1LDU1LjI1IEMxNi40MDI1LDU1LjI1IDE2LjI1LDU1LjQxNTYyNSAxNi4yNSw1NS42MTE4NzUgTDE2LjI1LDcyLjM4ODEyNSBDMTYuMjUsNzIuNTg0Mzc1IDE2LjQwMjUsNzIuNzUgMTYuNTgzMTI1LDcyLjc1IEw0My40MTY4NzUsNzIuNzUgQzQzLjU5NzUsNzIuNzUgNDMuNzUsNzIuNTg0Mzc1IDQzLjc1LDcyLjM4ODEyNSBMNDMuNzUsNTUuNjExODc1IFoiIGlkPSJTaGFwZSI+PC9wYXRoPiAgICAgICAgICAgICAgICAgICAgPC9nPiAgICAgICAgICAgICAgICA8L2c+ICAgICAgICAgICAgPC9nPiAgICAgICAgPC9nPiAgICA8L2c+PC9zdmc+);*/
  /*height: 25px;*/
  opacity: 1;
  transition: opacity 0.2s ease-in-out;
  /*width: 30px;*/
  z-index: 1;
}
.video-icon .fa{
    color:#1ad1bc;
}

.no-js #loader { display: none;  }
.js #loader { display: block; position: absolute; left: 100px; top: 0; }
.se-pre-con {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background: url(<?=base_url();?>assets/uploads/ajax_loading.gif) center no-repeat;
}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="se-pre-con"></div>
<div class="container-fluid">
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12" style="margin-bottom:1%;">
            <div class="page-title-box">
                <div class="float-right" style="margin-bottom:15px;">
                    <div class="btn-group" role="group" aria-label="Basic outlined example">
                      <a href="<?= base_url();?>Stocks" type="button" class="btn btn-primary btn-large"><i class="fa fa-shopping-cart"></i>&nbsp;All Plants Stocks</a>
                      <a href="<?= base_url();?>Stocks/stocks_report" class="btn btn-outline-primary"><i class="fa fa-bar-chart"></i>&nbsp;Stocks Report</a>
                      <a href="<?= base_url();?>Gain_loss" type="button" class="btn btn-outline-primary"><i class="fa fa-shopping-cart"></i>&nbsp;New Gain-Loss</a>
                      <a href="<?= base_url();?>Gain_loss/manage_trash" class="btn btn-outline-primary"><i class="fa fa-trash"></i>&nbsp;Trashed Gain-Loss</a>
                    </div>
                </div>
                <!--<h4 class="page-title">All Plants Stocks</h4>-->
                <!--<ol class="breadcrumb">-->
                <!--    <li class="breadcrumb-item"><a href="javascript:void(0);">Stocks</a></li>-->
                <!--    <li class="breadcrumb-item active">All Plants Stocks</li>-->
                <!--</ol>-->
            </div><!--end page-title-box
        </div><!--end col
    </div>
    <!-- end page title end breadcrumb -->
</div>
<div class ="container">
    <div class="switch">
        <div class="btn-group" role="group" aria-label="Basic outlined example" style="width:100%;">
          <a href="<?= base_url();?>Stocks/empty_cylinders" type="button" class="btn btn-primary btn-large" >&nbsp;Card View</a>
          <a href="<?= base_url();?>Stocks/tableview_lpgempty" class="btn btn-outline-primary">&nbsp;Table View</a>
        </div>
    </div>
    <br>
    <div class="btn-group btn-group1" role="group" aria-label="Basic outlined example" style="margin: auto;display: table;">
          <a href="<?= base_url();?>Stocks"  class="btn btn-outline-primary" style="border-top-left-radius: 25px; border-bottom-left-radius: 25px;"><i class="mdi mdi-fire"></i>&nbsp;LPG</a>
          <a href="<?= base_url();?>Stocks/empty_cylinders" class="btn btn-primary btn-large"><i class="mdi mdi-gas-cylinder"></i>&nbsp;Empty Cylinder(s)</a>
          <a href="<?= base_url();?>Stocks/parts" class="btn btn-outline-primary" style="border-top-right-radius: 25px; border-bottom-right-radius: 25px;"><i class="mdi mdi-accusoft"></i>&nbsp;Parts</a>
    </div>
</div>
<div class="container">
    <div class="switch" style="margin-left:auto;margin-right:auto;display:table; ">
        <!--<div class="btn-group" role="group" aria-label="Basic outlined example">-->
        <!--   <a href="<?= base_url();?>Stocks" type="button" class="btn btn-outline-primary" style="border-top-left-radius: 25px; border-bottom-left-radius: 25px;"><i class="fas fa-burn"></i>&nbsp;LPG</a>-->
        <!--  <a href="<?= base_url();?>Stocks/empty_cylinders" class="btn btn-primary btn-large" style="border-top-right-radius: 25px; border-bottom-right-radius: 25px;"><i class="mdi mdi-gas-cylinder"></i>&nbsp;Empty Cylinder</a>-->
        <!--</div>-->
        <!--<br>-->
        <br>
        <div class="buttonnnns" style="margin-left:auto;margin-right:auto;display:table;" >
            <form action="" method="post">
                <div class="radio radio-success form-check-inline">
                    <input type="radio" id="optionall" name="subcat_id" value="all" onclick="this.form.submit();" <?php if(isset($_POST['subcat_id'])) { if($_POST['subcat_id'] == 'all') {echo 'checked'; } }else{ echo 'checked'; } ?>>
                    <label for="optionall">All</label>
                </div>
                <?php 
                $categories=$this->Base_model->getAll('tbl_subcategory', '', "fld_cid = 2", '');
                foreach($categories as $cat){ 
                ?>
                <div class="radio radio-success form-check-inline">
                    <input type="radio" id="option<?php echo $cat['fld_subcid']; ?>" name="subcat_id" value="<?php echo $cat['fld_subcid']; ?>" onclick="this.form.submit();" <?php if(isset($_POST['subcat_id']) && $_POST['subcat_id']==$cat['fld_subcid']){echo 'checked'; } ?>>
                    <label for="option<?php echo $cat['fld_subcid']; ?>"> <?php echo $cat['fld_subcategory']; ?> </label>
                </div>
                
                <?php } ?>
            </form>
        
    </div>
    </div>
    
</div>
<div class="container-fluid">
    <div class="row">
        <?
           foreach($locations as $loc){
               $date = date('Y-m-d');
                if(isset($_POST['subcat_id']) && $_POST['subcat_id'] != 'all'){
                    $todaypurchase1= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_purchase as a, tbl_purchase_detail as b WHERE DATE(a.fld_purchase_date) = '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_purchase_id = a.fld_id AND b.fld_product_id = '2' AND b.fld_subproduct_id = '{$_POST['subcat_id']}'")->row()->fld_quantity+0; 
                    $pastpurchase1= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_purchase as a, tbl_purchase_detail as b WHERE DATE(a.fld_purchase_date) < '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_purchase_id = a.fld_id AND b.fld_product_id = '2' AND b.fld_subproduct_id = '{$_POST['subcat_id']}'")->row()->fld_quantity+0;
                    $todaysale1= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) = '$date' AND a.fld_location_from = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '2' AND b.fld_subproduct_id = '{$_POST['subcat_id']}'")->row()->fld_quantity+0;
                    $pastsale1= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) < '$date' AND a.fld_location_from = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '2' AND b.fld_subproduct_id = '{$_POST['subcat_id']}'")->row()->fld_quantity+0;
                  
                    $tsale = 0;
                    $psale = 0;
                    $todaypurchase2= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) = '$date' AND a.fld_location_to = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '2' AND b.fld_subproduct_id = '{$_POST['subcat_id']}'")->row()->fld_quantity+0; 
                    $pastpurchase2= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) < '$date' AND a.fld_location_to = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '2' AND b.fld_subproduct_id = '{$_POST['subcat_id']}'")->row()->fld_quantity+0;
                    $todaysale2= $this->db->query("SELECT sc.fld_subcategory, b.fld_quantity as fld_quantity FROM tbl_sale as a, tbl_sale_detail as b, tbl_subcategory as sc WHERE DATE(a.fld_sale_date) = '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_sale_id = a.fld_id AND sc.fld_subcid = b.fld_subproduct_id AND b.fld_product_id = '2' AND b.fld_subproduct_id = '{$_POST['subcat_id']}'")->result_array();
                    $pastsale2= $this->db->query("SELECT sc.fld_subcategory, b.fld_quantity as fld_quantity FROM tbl_sale as a, tbl_sale_detail as b, tbl_subcategory as sc WHERE DATE(a.fld_sale_date) < '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_sale_id = a.fld_id AND sc.fld_subcid = b.fld_subproduct_id AND b.fld_product_id = '2' AND b.fld_subproduct_id = '{$_POST['subcat_id']}'")->result_array();
                }else{
                    $todaypurchase1= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_purchase as a, tbl_purchase_detail as b WHERE DATE(a.fld_purchase_date) = '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_purchase_id = a.fld_id AND b.fld_product_id = '2'")->row()->fld_quantity+0; 
                    $pastpurchase1= $this->db->query("SELECT SUM(b.fld_quantity) as fld_quantity FROM tbl_purchase as a, tbl_purchase_detail as b WHERE DATE(a.fld_purchase_date) < '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_purchase_id = a.fld_id AND b.fld_product_id = '2'")->row()->fld_quantity+0;
                    $todaysale1= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) = '$date' AND a.fld_location_from = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '2'")->row()->fld_quantity+0;
                    $pastsale1= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) < '$date' AND a.fld_location_from = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '2'")->row()->fld_quantity+0;
                  
                    $tsale = 0;
                    $psale = 0;
                    $todaypurchase2= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) = '$date' AND a.fld_location_to = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '2'")->row()->fld_quantity+0; 
                    $pastpurchase2= $this->db->query("SELECT SUM(b.fld_qty) as fld_quantity FROM tbl_navigations as a, tbl_navigations_details as b WHERE DATE(a.fld_created_date) < '$date' AND a.fld_location_to = '{$loc['fld_id']}' and b.fld_navigation_id = a.fld_id AND b.fld_product_id = '2'")->row()->fld_quantity+0;
                    $todaysale2= $this->db->query("SELECT sc.fld_subcategory, b.fld_quantity as fld_quantity FROM tbl_sale as a, tbl_sale_detail as b, tbl_subcategory as sc WHERE DATE(a.fld_sale_date) = '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_sale_id = a.fld_id AND sc.fld_subcid = b.fld_subproduct_id AND b.fld_product_id = '2'")->result_array();
                    $pastsale2= $this->db->query("SELECT sc.fld_subcategory, b.fld_quantity as fld_quantity FROM tbl_sale as a, tbl_sale_detail as b, tbl_subcategory as sc WHERE DATE(a.fld_sale_date) < '$date' AND a.fld_location_id = '{$loc['fld_id']}' AND b.fld_sale_id = a.fld_id AND sc.fld_subcid = b.fld_subproduct_id AND b.fld_product_id = '2'")->result_array();
                }
                
                
                
                foreach($todaysale2 as $tdsale){
                    $tsale += $tdsale['fld_quantity'];
                }
                foreach($pastsale2 as $ptsale){
                    $psale += $ptsale['fld_quantity'];
                }
                $todaysale2 = $tsale;
                $pastsale2 = $psale;
                
              $pastpurchase = $pastpurchase1+$pastpurchase2;
              $todaypurchase = $todaypurchase1+$todaypurchase2;  
              
              $todaysale = $todaysale1+$todaysale2;
              $pastsale = $pastsale1+$pastsale2;
              
              $openingstock = $pastpurchase - $pastsale;
              $closingstock = $openingstock + $todaypurchase - $todaysale;
         ?>
        
        
        <div class="col-md-4">
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
        <? } ?>
    </div>
</div>
<script>
    
</script>