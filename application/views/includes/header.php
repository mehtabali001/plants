<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?php echo $this->title; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta content="MK TechSol Offers ERP, With the help of our business high-tech solution you can connect all departments and functions with a future-proof ERP system for resilience and operational excellence." name="description" />
        <meta content="" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
         <? $settings=$this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row_array();?>
        <link rel="shortcut icon" href="<?=base_url()?>/assets/uploads/logo/<?=$settings['favicon'];?>">
		<link href="<?= base_url()?>assets/theme_elements/plugins/footable/css/footable.bootstrap.css" rel="stylesheet">
		<link href="<?= base_url()?>assets/theme_elements/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link href="<?= base_url()?>/assets/theme_elements/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url()?>/assets/theme_elements/css/jquery-ui.min.css" rel="stylesheet">
        <link href="<?= base_url()?>/assets/theme_elements/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url()?>/assets/theme_elements/css/app.min.css" rel="stylesheet" type="text/css" />
        <!-- App css -->
        <?php
		  $this->load->view('includes/layouts.css.php');
		?>
<style>
/*loader*/
 .product-desc p{
            margin: 0px;
        }
    .preloader {
            width: 100%;
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
            background: white;
            z-index: 99999999;
            opacity: 0.6;
        }

        #preloader-logo {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            margin: auto;
        }

       

        .spinner {
            /*width: 80px;*/
            /*height: 80px;*/
            /*border: 2px solid #f3f3f3;*/
            /*border-top: 3px solid #2489CE;*/
            /*border-radius: 100%;*/
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            margin: auto;
            /*animation: spin 1s infinite ease;*/
            background-image: url("<?=base_url();?>assets/uploads/ajax_loading.gif") ;
              background-repeat: no-repeat;
              background-position: center;

        }

        /*@keyframes spin {*/
        /*    from {*/
        /*        transform: rotate(0deg);*/
        /*    }*/
        /*    to {*/
        /*        transform: rotate(360deg);*/
        /*    }*/
        /*}*/



/*loader-end*/

.leftbar-tab-menu .main-icon-menu .nav-link {
    position: relative;
    padding: 0;
    color: #fff;
    width: 35px !important;
    height: 35px !important;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
}
@media only screen and (max-width: 600px) {
      .btn-group {
        display:none;
      }
    }
.btn {
    font-size: .645rem;
}
.fa-copy{
    color:blue;
}
.fa-clipboard{
    color:green;
}
#datatable_tb_filter{
    float:right;
}
#datatable_tb_paginate{
    float:right;
}
.tabletop th {
    color: #fff;
}
.tabletop {
    position: sticky !important;
    /*top: 70px !important;*/
    /*background-color: #eee !important;*/
    background-color: #6c85e5 !important;
}
.tablebottom {
    position: sticky !important;
    bottom: 0px !important;
    /*color:#fff !important;*/
    /*background-color: #eee !important;*/
    background-color: #6c85e5 !important;
}
.tablebottom td{
    border:1px;
}
.table-bordered thead th {
    border: 1px;
}
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
.table .mdi{
    font-size:15px !important;
}
/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
.card {
	border-radius: 1rem;
}
.form-control {
	border: 1px solid #575252;
}
.nav-link {
	display: block;
	padding: .5rem .5rem;
}
.daterangepicker {
    background-color: #ffffff !important;
    border: 1px solid #d5d7e5 !important;
}
.daterangepicker .calendar-table {
	background-color: #ffffff !important;
}
.daterangepicker td.off, .daterangepicker td.off.in-range, .daterangepicker td.off.start-date, .daterangepicker td.off.end-date {
	background-color: #ffffff !important;
}
.daterangepicker td.available:hover, .daterangepicker th.available:hover {
	background-color: #d5d7e5 !important;
}
.btn-outline-primary {
    color: #5a5c61;
}
.panel-body{
	width:100%;
}
.btn{
   -webkit-appearance: none!important;
}
.card {
   border-radius: 1rem;
   border: 1px solid #506ee4;
}

.btn-successs {
    color: #fff;
    background-color: green !important;
    border-color: green;
}
.btn-success1 {
    color: #fff;
    background-color: #22bf9d !important;
    border-color: #20b494;
}
.mdi-delete-forever{
    color:red;
}
p a:hover{
    color:blue;
}
.w-100 {
    font-size: 14px;
    font-weight: 600;
    text-transform:uppercase;
    /*color: #d1d6e8;*/
    color: #21d0c0;
}
.main-menu-inner .menu-body .nav-item .nav-link.active i, .main-menu-inner .menu-body .nav-item .nav-link.active .w-100 {
  /*color: #506ee4;*/
  color: #21d0c0;
}
.leftbar-tab-menu .main-icon-menu .nav {
  margin-top:50px;
}
.nav .fa{
    color:#fff;
}
.nav .fas{
    color:#fff;
}
.nav .fab{
    color:#fff;
}
.leftbar-tab-menu .main-icon-menu {
    background-color: #10163a !important;
    border-right:1px solid #20d0c1;
}
.leftbar-tab-menu .main-icon-menu .nav-link.active:before {
    border-right: 10px solid #fff;
}
.leftbar-tab-menu .main-icon-menu .nav-link+.nav-link {
    margin-top: 10px;
}
.select2-container--default .select2-selection--single {
    background-color: #ffffff !important;
    border: 1px solid #575252;
    border-radius: 4px;
    height: 36px;
}
.select2-dropdown {
    background-color: #ffffff !important;
}
.btn-success {
    border: 1px solid #19d0cc !important;
    background-color: #1ad1bc !important;
}
.btn-gradient-primary {
    background: linear-gradient(14deg, #20d0c1 0%, rgb(32 208 193));
    color: #fff;
    -webkit-box-shadow: 0 7px 14px 0 rgb(80 110 228 / 50%);
    box-shadow: 0 7px 14px 0 rgb(80 110 228 / 50%);
    border: none;
}
.btn-gradient-primary:hover {
    background: linear-gradient(14deg, #20d0c1 0%, rgb(32 208 193));
    color: #fff;
    -webkit-box-shadow: 0 7px 14px 0 rgb(80 110 228 / 50%);
    box-shadow: 0 7px 14px 0 rgb(80 110 228 / 50%);
    border: none;
}
.select2-container--default .select2-selection--single {
    border: 1px solid #d6d7e5 !important
}
.select2-selection:focus{
    border: 1px solid #000 !important
}
.form-control {
    border:1px solid #d6d7e5 !important
}
.form-control:focus {
    border:1px solid #000 !important
}
.leftbar-tab-menu .main-icon-menu {
    background-color: #506ee4 !important;
    border-right: 1px solid #20d0c1;
}
.card {
    border-radius: 1rem;
    border: 1px solid #d1d1e2;
}
hr {
    margin-top: 1rem;
    margin-bottom: 1rem;
    border: 0;
    border-top: 1px solid #d5d7e5;
}
.content a{
    color:#fff;
}
.heead {
    color:#fff !important;
    font-size: 1rem !important;
}
.report-card:hover{
  /*-ms-transform: scale(1.05);*/
  /*-webkit-transform: scale(1.05); */
  /*transform: scale(1.05);*/
  background-color: #506ee4;
}
 .report-card:hover .text-truncate{
    color:#fff !important;
}
.dataTables_empty{
    color:red !important;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #5a5c61 !important;
}
.main-menu-inner .menu-body .nav-item ul li>a {
    font-size: 12px;
}
.main-menu-inner .menu-body .nav-item ul li {
    margin: 6px 0;
}
.fa-plus{
    color:#fff;
}
.btn-success:focus, .btn-success.focus {
    background-color: #1ad1bc !important;
}
.multi-step-form .steps [disabled] {
    background: #506ee4 !important;
}
.page-item.disabled .page-link {
    color: #000000;
    pointer-events: none;
    cursor: auto;
    background-color: #fff;
    border-color: #000000;
}
.text-danger {
    color: #ef4d56 !important;
}
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
    /*background-color: #212744;*/
    font-size: 10px;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #ffffff !important;
    font-size: 10px;
    color: #506ee4;
}
.select2-container--default .select2-selection--multiple {
    background-color: #ffffff !important;
    border: 1px solid #575252;
    border-radius: 4px;
    min-height: 36px;
}
.select2-container--default.select2-container--disabled{
    background-color: #eee !important;
    cursor: default;
}
.total td {
    color: #000 !important;
}
.tablebottom{
    color: #fff !important;
}
ul li::marker {
  color: black;
  font-weight: bold;
  display: inline-block; 
  width: 1em;
  margin-left: -1em;
  margin-right:2px;
}
ul li::hover {
  color: #fff;
  font-weight: bold;
  display: inline-block; 
  width: 1em;
  margin-left: -1em;
  margin-right:2px;
}
.extra .extra.active:before {
    content: "";
    border: none;
    background: #fff  !important;
}
.table td {
    vertical-align: middle;
    font-size: 12px !important;
}
.btn-outline-light{
    border: 1px solid #d6d7e5;
    border-left: 1px solid #fff !important;
}
.btn-csv{
    background:green;
    color:#fff;
}
.btn-csv:hover{
    color:#fff;
}
.card {
    box-shadow: 0 5px 8px 4px #6abdcf, 0 5px 8px 4px rgb(255 255 255) !important;
    /*6c85e5*/
}
.btn-group{
  box-shadow: 0 5px 8px 4px #6abdcf, 0 5px 8px 4px rgb(255 255 255) !important; 
  border-radius:5px;
}
.dataTables_info{
    float: left;
    margin-top: 12px;
}
/*.topfilter{*/
/*    position: relative;*/
/*    top: 18px;*/
/*}*/

@media only screen and (max-width: 600px) {
.page-title-box{
    display:none;
}
#datatable_length label{
    width:100%;
}
#datatable_tb_filter{
   width:100%; 
}
#datatable_filter label{
   width:100%; 
}
.pagination{
     width:100%; 
}
#bttnn_proceed{
    margin-top: 0!important;
}
#otpp_check{
    margin-top: 0!important;
}
}
</style>

<?
    $mainlevelPermissions = explode(",",$this->session->userdata('mainmenu'));
    $sublevelPermissions  = explode(",",$this->session->userdata('sublevel'));
	$sublevelLinksPermissions  = explode(",",$this->session->userdata('sublevellinks'));
?>

<script>
function removeMenu() {
    $('body').addClass('enlarge-menu');
}
</script>
    </head>
	<input type="hidden" name="base_url" id="base_url" value="<?= base_url();?>"/>
    <!--<body class="enlarge-menu ">-->
    <body <?php if($this->uri->segment(1) == 'home'){echo'onload="removeMenu();"';} ?>>
        <div class="preloader" style="display:none;">
        <div class="spinner"></div>
        
</div>
        <!-- leftbar-tab-menu -->
        <div class="leftbar-tab-menu">
            <div class="main-icon-menu">
                <a href="<?= base_url('home');?>" class="logo logo-metrica d-block text-center">
                    <span>
                        <!--<img src="<?//= base_url();?>/assets/theme_elements/images/logo-sm.png" alt="logo-small" class="logo-sm">-->
                    </span>
                </a>
                <nav class="nav">
                    <!--<a href="#" onclick="window.location.href='<?//=base_url();?>home'"class="nav-link" data-toggle="tooltip-custom"  data-placement="right" data-trigger="hover" title="" data-original-title="Dashboard">-->
                    <!--    <i class="fas fa-tachometer-alt"  style="font-size:24px"></i>-->
                    <!--</a>-->
					<?
					  $mainmenu = $this->db->query("SELECT * FROM tbl_admin_menu_group ORDER BY display_priority ASC")->result_array();
					  foreach($mainmenu as $menu){
					      if(!empty($mainlevelPermissions) && in_array($menu['menu_group_id'],$mainlevelPermissions)){
					?>
					<a href="#Metrica_<?=$menu['grp_select_class'];?>" class="nav-link" data-toggle="tooltip-custom" data-placement="right" data-trigger="hover" title="" data-original-title="<?=$menu['menu_group_name'];?>" <? if($menu['grp_select_class'] == 'data_management'){ ?> onclick="window.location.href='<?=base_url();?>home/data_management'" <? } else if($menu['grp_select_class'] == 'home'){?> onclick="window.location.href='<?=base_url();?>home'" <? } ?>> 
						<i class="<?=$menu['display_icon'];?>" style="font-size:20px;"></i>
					</a>
					<? } } ?>
					
                </nav>
            </div>

            <div class="main-menu-inner">
                <!-- LOGO -->
                <div class="topbar-left">
                    <a href="<?= base_url('home');?>" class="logo">
                        <? $settings=$this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row_array();?>
                        <span>
                            Gasman Plants
                            <!--<img src="<?//=base_url()?>/assets/uploads/logo/<?//=$settings['system_logo'];?>" alt="logo-large" class="logo-lg logo-dark" style="height:100px;">-->
                            <!--<img src="<?//=base_url()?>/assets/uploads/logo/<?//=$settings['system_logo'];?>" alt="logo-large" class="logo-lg logo-light" style="height:100px;">-->
                        </span>
                    </a>
                </div>
                <!--end logo-->
                <div class="menu-body slimscroll"> 
                    <?
					  $mainnavigation = $this->db->query("SELECT * FROM tbl_admin_menu_group ORDER BY display_priority ASC")->result_array();
					  foreach($mainnavigation as $mainnavi){
					      if(!empty($mainlevelPermissions) && in_array($mainnavi['menu_group_id'],$mainlevelPermissions)){
					?>
                    <div id="Metrica_<?=$mainnavi['grp_select_class'];?>" class="main-icon-menu-pane 
					<?php if( $mainnavi['grp_select_class'] == 'data_management' && $this->uri->segment(2) == "data_management"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'purchase' && $this->uri->segment(1) == 'Purchase' && $this->uri->segment(2) == "edit"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'purchase' && $this->uri->segment(1) == 'Purchase' && $this->uri->segment(2) == "detail"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'purchase' && $this->uri->segment(1) == 'Purchase' && $this->uri->segment(2) == "editDraft"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'purchase' && $this->uri->segment(1) == 'Purchase' && $this->uri->segment(2) == "editOrder"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'security' && $this->uri->segment(1) == 'Entries' && $this->uri->segment(2) == "edit"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'navigations' && $this->uri->segment(1) == 'Navigations' && $this->uri->segment(2) == "edit"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'navigations' && $this->uri->segment(1) == 'Navigations' && $this->uri->segment(2) == "create_navigation"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'navigations' && $this->uri->segment(1) == 'Navigations' && $this->uri->segment(2) == "detail"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'navigations' && $this->uri->segment(1) == 'Navigations' && $this->uri->segment(2) == "edit_drafts"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'hrm' && $this->uri->segment(1) == 'Employees' && $this->uri->segment(2) == "edit"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'hrm' && $this->uri->segment(1) == 'Employees' && $this->uri->segment(2) == "viewEmployee"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'roles' && $this->uri->segment(1) == 'Roles' && $this->uri->segment(2) == "editRolespermission"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'roles' && $this->uri->segment(1) == 'Roles' && $this->uri->segment(2) == "assignUserRole"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'hrm' && $this->uri->segment(1) == 'Payroll' && $this->uri->segment(2) == "viewpaidsalary"){ 
                                echo 'active';
                            }else if($mainnavi['grp_select_class'] == 'hrm' && $this->uri->segment(1) == 'Payroll' && $this->uri->segment(2) == "editsalarysetup"){ 
                                echo 'active';
                            }else if($mainnavi['grp_select_class'] == 'expenses' && $this->uri->segment(1) == 'Expenses' && $this->uri->segment(2) == "edit"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'expenses' && $this->uri->segment(1) == 'Expenses' && $this->uri->segment(2) == "detail"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'expenses' && $this->uri->segment(1) == 'Expenses' && $this->uri->segment(2) == "expense_type"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'expenses' && $this->uri->segment(1) == 'Expenses' && $this->uri->segment(2) == "manage_Expensetypes"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'expenses' && $this->uri->segment(1) == 'Expenses' && $this->uri->segment(2) == "edittype"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'expenses' && $this->uri->segment(1) == 'Expenses' && $this->uri->segment(2) == "editdraft"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'data_management' && $this->uri->segment(1) == 'Others'){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'purchase' && $this->uri->segment(1) == 'Supplier' && $this->uri->segment(2) == "edit"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'purchase' && $this->uri->segment(1) == 'Supplier' && $this->uri->segment(2) == "viewSuplier"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'sale' && $this->uri->segment(1) == 'Customers' && $this->uri->segment(2) == "edit"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'sale' && $this->uri->segment(1) == 'Customers' && $this->uri->segment(2) == "viewCustomer"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'sale' && $this->uri->segment(1) == 'Customers' && $this->uri->segment(2) == "manage_CustomersList"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'sale' && $this->uri->segment(1) == 'SaleRate' && $this->uri->segment(2) == "edit"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'data_management' && $this->uri->segment(1) == 'Common' && $this->uri->segment(2) == "edit"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'data_management' && $this->uri->segment(1) == 'Common' && $this->uri->segment(2) == "editsubcategory"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'data_management' && $this->uri->segment(1) == 'Common' && $this->uri->segment(2) == "editUnit"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'data_management' && $this->uri->segment(1) == 'Common' && $this->uri->segment(2) == "editLocation"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'data_management' && $this->uri->segment(1) == 'Common' && $this->uri->segment(2) == "editRefinery"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'data_management' && $this->uri->segment(1) == 'Common' && $this->uri->segment(2) == "editBank"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'navigations' && $this->uri->segment(1) == 'Common' && $this->uri->segment(2) == "editTransporter"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'data_management' && $this->uri->segment(1) == 'Common' && $this->uri->segment(2) == "editDepartment"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'data_management' && $this->uri->segment(1) == 'Common' && $this->uri->segment(2) == "editDesignation"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'data_management' && $this->uri->segment(1) == 'Common' && $this->uri->segment(2) == "editShift"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'expenses' && $this->uri->segment(1) == 'Common' && $this->uri->segment(2) == "editStationary"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'expenses' && $this->uri->segment(1) == 'Common' && $this->uri->segment(2) == "edit_expensegroup"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'data_management' && $this->uri->segment(1) == 'Others' && $this->uri->segment(2) == "editPartner"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'settings' && $this->uri->segment(1) == 'Settings' && $this->uri->segment(2) == "editemail"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'accounts' && $this->uri->segment(1) == 'Accounts'){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'accounts' && $this->uri->segment(1) == 'Liabilities'){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'stocks' && $this->uri->segment(1) == 'Stocks' && $this->uri->segment(2) == "empty_cylinders"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'stocks' && $this->uri->segment(1) == 'Stocks' && $this->uri->segment(2) == "parts"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'stocks' && $this->uri->segment(1) == 'Stocks' && $this->uri->segment(2) == "tableviewlpg"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'stocks' && $this->uri->segment(1) == 'Stocks' && $this->uri->segment(2) == "tableview_lpgempty"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'stocks' && $this->uri->segment(1) == 'Stocks' && $this->uri->segment(2) == "tableview_parts"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'sale' && $this->uri->segment(1) == 'Sales' && $this->uri->segment(2) == "edit"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'sale' && $this->uri->segment(1) == 'Sales' && $this->uri->segment(2) == "editDraft"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'sale' && $this->uri->segment(1) == 'Sales' && $this->uri->segment(2) == "detail"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'accounts' && $this->uri->segment(1) == 'Vouchers' && $this->uri->segment(2) == "editCashpaymentVoucher"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'accounts' && $this->uri->segment(1) == 'Vouchers' && $this->uri->segment(2) == "editJournalVoucher"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'accounts' && $this->uri->segment(1) == 'Vouchers' && $this->uri->segment(2) == "journalvoucher"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'accounts' && $this->uri->segment(1) == 'Vouchers' && $this->uri->segment(2) == "chequereceivevoucher"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'accounts' && $this->uri->segment(1) == 'Vouchers' && $this->uri->segment(2) == "chequepayementvoucher"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'accounts' && $this->uri->segment(1) == 'Vouchers' && $this->uri->segment(2) == "cashreceivevoucher"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'accounts' && $this->uri->segment(1) == 'Vouchers' && $this->uri->segment(2) == "cashpayementvoucher"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'accounts' && $this->uri->segment(1) == 'Vouchers' && $this->uri->segment(2) == "view_jv_voucher"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'accounts' && $this->uri->segment(1) == 'Vouchers' && $this->uri->segment(2) == "view_voucher"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'accounts' && $this->uri->segment(1) == 'Vouchers' && $this->uri->segment(2) == "pldvoucher"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'roles' && $this->uri->segment(1) == 'Roles' && $this->uri->segment(2) == "assigned_roles"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'roles' && $this->uri->segment(1) == 'Roles' && $this->uri->segment(2) == "edittempuser"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'complaints' && $this->uri->segment(1) == 'Complaints' && $this->uri->segment(2) == "edit_complaint"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'complaints' && $this->uri->segment(1) == 'Complaints' && $this->uri->segment(2) == "view_complaint"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'complaints' && $this->uri->segment(1) == 'Complaints' && $this->uri->segment(2) == "view_asigned_complaint"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'settings' && $this->uri->segment(1) == 'Roles' && $this->uri->segment(2) == "changePassword"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'stocks' && $this->uri->segment(1) == 'Gain_loss' && $this->uri->segment(2) == "edit"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'settings' && $this->uri->segment(1) == 'Change_pass'){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'settings' && $this->uri->segment(1) == 'Settings' && $this->uri->segment(2) == "change_profile_picture"){ 
							 echo 'active';
							}else if($mainnavi['grp_select_class'] == 'settings' && $this->uri->segment(1) == 'Settings' && $this->uri->segment(2) == "edit_sms_api"){ 
							 echo 'active';
							}
							?>">
                        <ul class="nav metismenu">
						    <?
							  $subnavigation = $this->db->query("SELECT * FROM tbl_admin_menu_subgroup WHERE menu_group_parent = '".$mainnavi['menu_group_id']."' ORDER BY display_priority ASC")->result_array();
							  foreach($subnavigation as $subnavi){
							      if(!empty($sublevelPermissions) && in_array($subnavi['menu_subgroup_id'],$sublevelPermissions)){
								  if($mainnavi['grp_select_class'] == 'data_management'){
							?>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript: void(0);">
                                    <span class="w-100 menu-title"><?=$subnavi['menu_subgroup_name'];?></span>
                                    <span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span>
                                </a>
                                <ul class="nav-second-level" aria-expanded="false">
								 <?
								  $navigation = $this->db->query("SELECT * FROM tbl_admin_menu WHERE menu_group_id = '".$mainnavi['menu_group_id']."' AND menu_subgroup_id = '".$subnavi['menu_subgroup_id']."' ORDER BY display_priority ASC")->result_array();
								  foreach($navigation as $nav){
									  $url = $nav['menu_url'];
								?>
                                    <li><a href="<?= base_url($url);?>"><?=$nav['menu_description'];?></a></li>
								<? } ?>
                                </ul>            
                            </li>
							<? }else{ ?>
							<li class="nav-item mm-active">
                                <a class="nav-link active" href="javascript: void(0);"><span class="w-100 menu-title"><?=$subnavi['menu_subgroup_name'];?></span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="nav-second-level mm-show" aria-expanded="true">
                                <?
								  $navigation = $this->db->query("SELECT * FROM tbl_admin_menu WHERE menu_group_id = '".$mainnavi['menu_group_id']."' AND menu_subgroup_id = '".$subnavi['menu_subgroup_id']."' ORDER BY display_priority ASC")->result_array();
								  foreach($navigation as $nav){
								      if(!empty($sublevelLinksPermissions) && in_array($nav['menu_id'],$sublevelLinksPermissions)){
									  $url = $nav['menu_url'];
								?>
                                    <li><a href="<?= base_url($url);?>"><?=$nav['menu_description'];?></a></li>
								<? } } ?>
								
							<?/*?><?
							  $subsubnavigation = $this->db->query("SELECT * FROM tbl_admin_menu_subsubgroup WHERE menu_group_parent = '".$mainnavi['menu_group_id']."' AND menu_group_subparent = '".$subnavi['menu_subgroup_id']."' ORDER BY display_priority ASC")->result_array();
							  foreach($subsubnavigation as $subsubnavi){
							  //if(!empty($sublevelPermissions) && in_array($subnavi['menu_subgroup_id'],$sublevelPermissions)){
							?>
							<li class="nav-item mm-active extra">
                                <a class="nav-link active extra" href="javascript: void(0);"><span class="w-100 menu-title"><?=$subsubnavi['menu_subsubgroup_name'];?></span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="nav-second-level mm-show" aria-expanded="true">
								 <?
								  $navigation = $this->db->query("SELECT * FROM tbl_admin_menu WHERE menu_group_id = '".$mainnavi['menu_group_id']."' AND menu_subsubgroup_id = '".$subsubnavi['menu_subsubgroup_id']."' ORDER BY display_priority ASC")->result_array();
								  foreach($navigation as $nav){
									  $url = $nav['menu_url'];
								?>
                                    <li><a href="<?= base_url($url);?>"><?=$nav['menu_description'];?></a></li>
								<? } ?>
                                </ul>            
                            </li>
							<? } ?><?*/?>
							
							
                                </ul>            
                            </li>
							<? } } ?>
							<? } ?>
                        </ul>
                    </div>
					<? } } ?>
					
                    <!-- end Pages -->
                </div><!--end menu-body-->
            </div><!-- end main-menu-inner-->
        </div>
        <!-- end leftbar-tab-menu-->

        <!-- Top Bar Start -->
        <div class="topbar">           
            <!-- Navbar -->
            <nav class="navbar-custom"> 
                <ul class="list-unstyled topbar-nav float-right mb-0"> 
                    
                    <?php $user_id = $this->session->userdata('user_id');
                    $user_data=$this->db->query("select * from tbl_users where fld_id = '$user_id' ")->row();
                    $emp_username = $user_data->fld_username;
                    $emp_id = $user_data->emp_id;
                    if($user_data->fld_user_pic !=""){
						$fld_user_pic = 'assets/uploads/user_dp/'.$user_data->fld_user_pic;
					}else{
						$fld_user_pic = '/assets/theme_elements/images/users/user-4.png';
					}
                    if($emp_id > 0){
                        $emp_data=$this->db->query("select * from tbl_employees where id = '$emp_id' ")->row();
                        if($emp_data->picture==''){
                            $profile_pic = '/assets/theme_elements/images/users/user-4.png';
                        }else{
                            $profile_pic = '/assets/uploads/profile_pictures/thumbs/s_'.$emp_data->picture;
                        }
                    }else{
                        $profile_pic = '/assets/theme_elements/images/users/user-4.png';
                    }
                    
                    ?>
                    <li class="dropdown">
                        <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button"
                            aria-haspopup="false" aria-expanded="false">
                            <!--<img src="<?//= base_url();?>/assets/theme_elements/images/users/user-4.png" alt="profile-user" class="rounded-circle" />-->
                            <img src="<?=base_url()?><?=$fld_user_pic;?>" alt="avatar" style="border-radius: 50%;">
                            <span class="ml-1 nav-user-name hidden-sm"><?//= @$emp_username;?> <i class="mdi mdi-chevron-down"></i> </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <!--<a class="dropdown-item" href="<?//= base_url();?>Profile/viewProfile"><i class="dripicons-user text-muted mr-2"></i> Profile</a>-->
                            <a class="dropdown-item" href=""><i class="dripicons-user text-muted mr-2"></i> Hi, <?= @$emp_username;?> </a>
                            <a class="dropdown-item" href="<?= base_url();?>Settings/change_profile_picture"><i class="dripicons-user text-muted mr-2"></i> Change Profile Picture</a>
                            <a class="dropdown-item" href="<?= base_url();?>Change_pass"><i class="mdi mdi-key-variant text-muted mr-2"></i> Change Password</a>
                            <?php
                            if($emp_id > 0){
                            ?>
                            <a class="dropdown-item" href="<?= base_url('Employees/viewEmployee/').$emp_id;?>"><i class="dripicons-document-new text-muted mr-2"></i> Show My CV</a>
                            <?php }?>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?= base_url('Adminlogin/logout');?>" style="color: red;"><i class="dripicons-exit text-muted mr-2"></i> Logout</a>
                        </div>
                    </li>
                </ul><!--end topbar-nav-->
    
                <ul class="list-unstyled topbar-nav mb-0">  
                    <li>
                        <a href="<?= base_url('home');?>" class="logo">
                        <? $settings=$this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row_array();?>
                        <span class="responsive-logo">
                            <img src="<?=base_url()?>/assets/uploads/logo/<?=$settings['system_logo'];?>" alt="logo-small" class="logo-sm align-self-center logo-light" style="height:34px;">
                        </span>
                        </a>
                        <!--<a href="../crm/crm-index.html">-->
                        <!--<span class="responsive-logo">-->
                        <!--    <img src="<?//= base_url();?>/assets/theme_elements/images/logo-sm.png" alt="logo-small" class="logo-sm align-self-center" height="34">-->
                        <!--</span>-->
                        <!--</a>-->
                    </li>                      
                    <li>
                        <button class="button-menu-mobile nav-link">
                            <i data-feather="menu" class="align-self-center"></i>
                        </button>
                    </li>
                </ul>
            </nav>
            <!-- end navbar-->
        </div>
        <!-- Top Bar End -->
		<div class="page-wrapper">
            <!-- Page Content-->
            <div class="page-content-tab">