<style>
a:hover{
    color:grey;
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
  max-height: 85px;
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
  margin-top: 22px;
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
  line-height: 22px;
  margin: 0;
      height: 85px;
/*--   max-height: 0;*/
  overflow: hidden;
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
.video-icon .fas{
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
<? $role_permissions  = explode(",",$this->session->userdata('permissions')); ?>
<div class="se-pre-con"></div>
<div class="container-fluid">
<!-- Page-Title -->
<!--<div class="row">-->
<!--    <div class="col-sm-12">-->
<!--        <div class="page-title-box">-->
<!--            <div class="float-right">-->
<!--                <ol class="breadcrumb">-->
<!--                    <li class="breadcrumb-item"><a href="javascript:void(0);">ERP</a></li>-->
<!--                    <li class="breadcrumb-item active">Data Management</li>-->
<!--                </ol>-->
<!--            </div>-->
<!--            <h4 class="page-title">Data Management</h4>-->
<!--        </div><!--end page-title-box-->
<!--    </div><!--end col-->
<!--</div>-->
<!-- end page title end breadcrumb -->
</div>
<div class="container-fluid">
    <div class="row">
       <? /* ?> <? if(!empty($role_permissions) && in_array(57,$role_permissions) && in_array(58,$role_permissions)) { ?>
        <div class="col-md-3">
            <div class="category-card">
                <div class="video-icon">
                <i class="fa fa-users" style="font-size:36px;">&nbsp;<span class="heead">Supplier</span></i>
                </div>
                <div class="content">
                    <ul>
                    <li><a href="<?= base_url('Supplier');?>">+ Supplier</a></li>
                    <li><a href="<?= base_url('Supplier/manage_Supplier');?>">View Suppliers</a></li>
                    </ul>
                </div>
             </div>
        </div>
        <? } ?><? */ ?>
        
        <? /* ?><? if(!empty($role_permissions) && in_array(62,$role_permissions) && in_array(63,$role_permissions)) { ?>
        <div class="col-md-3">
            <div class="category-card">
                <div class="video-icon">
                <i class="fa fa-users" style="font-size:36px;">&nbsp;<span class="heead">Customer</span></i>
                </div>
                <div class="content">
                    <!--<h2>Customer</h2><br>-->
                    <ul>
                        <li><a href="<?= base_url('Customers');?>">+ Customer</a></li>
                        <li><a href="<?= base_url('Customers/manage_Customers');?>">View Customers</a></li>
                        <li><a href="<?= base_url('Customers/manage_CustomersList');?>">Customers List</a></li>
                    </ul>
                </div>
             </div>
        </div>
        <? } ?><? */ ?>
        
        <? if(!empty($role_permissions) && in_array(174,$role_permissions) && in_array(175,$role_permissions)) { ?>
        <div class="col-md-3">
            <div class="category-card">
                <div class="video-icon">
                <i class="fa fa-dropbox" style="font-size:36px;">&nbsp;<span class="heead">Partners</span></i>
                </div>
                <div class="content">
                    <ul>
                        <li><a href="<?= base_url('Others/add_partner');?>">+ Partners</a></li>  
                        <li><a href="<?= base_url('Others/manage_partners');?>">View Partners</a></li> 
                    </ul>
                </div>
             </div>
        </div>
        <? } ?>
        
        <? if(!empty($role_permissions) && in_array(170,$role_permissions) && in_array(171,$role_permissions)) { ?>
        <div class="col-md-3">
            <div class="category-card">
                <div class="video-icon">
                <i class="fa fa-dropbox" style="font-size:36px;">&nbsp;<span class="heead">Other Party</span></i>
                </div>
                <div class="content">
                    <ul>
                        <li><a href="<?= base_url('Others');?>">+ Other Party</a></li>  
                        <li><a href="<?= base_url('Others/manage_others');?>">View Other Parties</a></li> 
                    </ul>
                </div>
             </div>
        </div>
        <? } ?>
        
        <? if(!empty($role_permissions) && in_array(67,$role_permissions) && in_array(68,$role_permissions) && in_array(72,$role_permissions)) { ?>
        <div class="col-md-3">
            <div class="category-card">
                <div class="video-icon">
                <i class="fa fa-dropbox" style="font-size:36px;">&nbsp;<span class="heead">Products</span></i>
                </div>
                <div class="content">
                    <!--<h2>Products</h2><br>-->
                    <ul>
                        <li><a href="<?= base_url('Common');?>">+ Categories</a></li>
                        <li><a href="<?= base_url('Common/manage_Category');?>">View Categories</a></li>                          
                        <!--<li><a href="<?//= base_url('Common/manage_subCategory');?>">View Sub-Categories</a></li> -->
                    </ul>
                </div>
             </div>
        </div>
        <?// } ?>
        <?// if(!empty($role_permissions) && in_array(67,$role_permissions) && in_array(68,$role_permissions) && in_array(72,$role_permissions)) { ?>
        <div class="col-md-3">
            <div class="category-card">
                <div class="video-icon">
                <i class="fa fa-dropbox" style="font-size:36px;">&nbsp;<span class="heead">Sub Categories</span></i>
                </div>
                <div class="content">
                    <!--<h2>Products</h2><br>-->
                    <ul>
                        <li><a href="<?= base_url('Common/addsubcategory');?>">+ Sub-Categories</a></li>                        
                        <li><a href="<?= base_url('Common/manage_subCategory');?>">View Sub-Categories</a></li> 
                    </ul>
                </div>
             </div>
        </div>
        <? } ?>
        
        <? /* ?><? if(!empty($role_permissions) && in_array(75,$role_permissions) && in_array(77,$role_permissions)) { ?>
        <div class="col-md-3">
            <div class="category-card">
                <div class="video-icon">
                <!--<i class="fa fa-shopping-cart" style="font-size:36px;">&nbsp;<span>Sales Rate</span></i>-->
                <i class="fa fa-shopping-cart" style="font-size:36px;">&nbsp;<span class="heead">Daily SalesRate</span></i>
                </div>
                <div class="content">
                    <!--<h2>Sales Rate</h2><br>-->
                    <ul>
                        <li><a href="<?= base_url('SaleRate');?>">+ Daily SalesRate</a></li>
                        <li><a href="<?= base_url('SaleRate/manage_salerateHistory');?>">View Daily SaleRates</a></li>
                    </ul>
                </div>
             </div>
        </div>
        <? } ?><? */ ?>
        
        <? if(!empty($role_permissions) && in_array(79,$role_permissions) && in_array(80,$role_permissions)) { ?>
        <div class="col-md-3">
            <div class="category-card">
                <div class="video-icon">
                <i class="fa fa-balance-scale" style="font-size:36px;">&nbsp;<span class="heead">Product Measuring Unit</span></i>
                </div>
                <div class="content">
                    <!--<h2>Product Unit</h2><br>-->
                    <ul>
                        <li><a href="<?= base_url('Common/addUnit');?>">+ Measring Unit</a></li>
                        <li><a href="<?= base_url('Common/manage_Unit');?>">View Measuring Units</a></li>
                    </ul>
                </div>
             </div>
        </div>
        <? } ?>
        
        <? if(!empty($role_permissions) && in_array(83,$role_permissions) && in_array(84,$role_permissions)) { ?>
        <div class="col-md-3">
            <div class="category-card">
                <div class="video-icon">
                <i class="fa fa-industry" style="font-size:36px;">&nbsp;<span class="heead">WareHouse/Plant</span></i>
                </div>
                <div class="content">
                    <!--<h2>Location/Plant</h2><br>-->
                    <ul>
                        <li><a href="<?= base_url('Common/addLocation');?>">+ WareHouse/Plant</a></li>
                        <li><a href="<?= base_url('Common/manage_Location');?>">View WareHouses/Plants</a></li> 
                    </ul>
                </div>
             </div>
        </div>
        <? } ?>
        
        <? if(!empty($role_permissions) && in_array(87,$role_permissions) && in_array(88,$role_permissions)) { ?>
        <div class="col-md-3">
            <div class="category-card">
                <div class="video-icon">
                <i class="fa fa-university" style="font-size:36px;">&nbsp;<span class="heead">Bank</span></i>
                </div>
                <div class="content">
                    <!--<h2>Bank</h2><br>-->
                    <ul>
                        <li><a href="<?= base_url('Common/addBank');?>">+ Bank</a></li>
                        <li><a href="<?= base_url('Common/manage_Bank');?>">View Banks</a></li>
                    </ul>
                </div>
             </div>
        </div>
        <? } ?>
        
        <? if(!empty($role_permissions) && in_array(91,$role_permissions) && in_array(92,$role_permissions)) { ?>
        <div class="col-md-3">
            <div class="category-card">
                <div class="video-icon">
                <i class="fa fa-truck" style="font-size:36px;">&nbsp;<span class="heead">Vehicle/Bowsers</span></i>
                </div>
                <div class="content">
                    <!--<h2>Transporter</h2><br>-->
                    <ul>
                      <li><a href="<?= base_url('Common/addTransporter');?>">+ Vehicle/Bowser</a></li>
                      <li><a href="<?= base_url('Common/manage_Transporter');?>">View Vehicle/Bowser</a></a></li>
                    </ul>
                </div>
             </div>
        </div>
        <? } ?>
        
        <? if(!empty($role_permissions) && in_array(95,$role_permissions) && in_array(96,$role_permissions)) { ?>
        <div class="col-md-3">
            <div class="category-card">
                <div class="video-icon">
                <i class="fa fa-building-o" style="font-size:36px;">&nbsp;<span class="heead">Departments</span></i>
                </div>
                <div class="content">
                    <!--<h2>Departments</h2><br>-->
                    <ul>
                        <li><a href="<?= base_url('Common/addDepartment');?>">+ Department</a></li>
                        <li><a href="<?= base_url('Common/manage_departments');?>">View Departments</a></li> 
                    </ul>
                </div>
             </div>
        </div>
        <? } ?>
        
        <? if(!empty($role_permissions) && in_array(99,$role_permissions) && in_array(100,$role_permissions)) { ?>
        <div class="col-md-3">
            <div class="category-card">
                <div class="video-icon">
                <i class="fa fa-tasks" style="font-size:36px;">&nbsp;<span class="heead">Designations</span></i>
                </div>
                <div class="content">
                    <!--<h2>Designations</h2><br>-->
                    <ul>
                        <li><a href="<?= base_url('Common/addDesignation');?>">+ Designation</a></li>
                        <li><a href="<?= base_url('Common/manage_designations');?>">View Designations</a></li>  
                    </ul>
                </div>
             </div>
        </div>
        <? } ?>
        
        <? if(!empty($role_permissions) && in_array(103,$role_permissions) && in_array(104,$role_permissions)) { ?>
        <div class="col-md-3">
            <div class="category-card">
                <div class="video-icon">
                <i class="fa fa-arrows" style="font-size:36px;">&nbsp;<span class="heead">Shifts</span></i>
                </div>
                <div class="content">
                    <!--<h2>Shifts</h2><br>-->
                    <ul>
                        <li><a href="<?= base_url('Common/addShift');?>">+ Shift</a></li>
                        <li><a href="<?= base_url('Common/manage_shifts');?>">View Shifts</a></li>  
                    </ul>
                </div>
             </div>
        </div>
        <? } ?>
        
        <?/* if(!empty($role_permissions) && in_array(107,$role_permissions) && in_array(108,$role_permissions)) { ?>
        <div class="col-md-3">
            <div class="category-card">
                <div class="video-icon">
                <i class="fa fa-paperclip" style="font-size:36px;">&nbsp;<span class="heead">Stationary</span></i>
                </div>
                <div class="content">
                    <!--<h2>Stationary</h2><br>-->
                    <ul>
                        <li><a href="<?= base_url('Common/addStationary');?>">+ Stationary</a></li>
                        <li><a href="<?= base_url('Common/manage_stationary');?>">View Stationaries</a></li>  
                    </ul>
                </div>
             </div>
        </div>
        <? } */?>
        
        <? if(!empty($role_permissions) && in_array(122,$role_permissions) && in_array(123,$role_permissions)) { ?>
        <div class="col-md-3">
            <div class="category-card">
                <div class="video-icon">
                <i class="fas fa-smoking" style="font-size:36px;">&nbsp;<span class="heead">Refinery</span></i>
                </div>
                <div class="content">
                    <!--<h2>Stationary</h2><br>-->
                    <ul>
                        <li><a href="<?= base_url('Common/addRefinery');?>">+ Refinery</a></li>
                        <li><a href="<?= base_url('Common/manage_Refinery');?>">View Refineries</a></li>  
                    </ul>
                </div>
             </div>
        </div>
        <? } ?>
        
        <?/* if(!empty($role_permissions) && in_array(166,$role_permissions) && in_array(167,$role_permissions)) { ?>
        <div class="col-md-3">
            <div class="category-card">
                <div class="video-icon">
                <i class="fa fa-dropbox" style="font-size:36px;">&nbsp;<span class="heead">Expense</span></i>
                </div>
                <div class="content">
                    <ul>
                        <li><a href="<?= base_url('Common/expense_type');?>">+ Expense Type</a></li>  
                        <li><a href="<?= base_url('Common/manage_Expensetypes');?>">View Expense Types</a></li> 
                    </ul>
                </div>
             </div>
        </div>
        <? } ?>
         <?/ if(!empty($role_permissions) && in_array(166,$role_permissions) && in_array(167,$role_permissions)) { ?>
        <div class="col-md-3">
            <div class="category-card">
                <div class="video-icon">
                <i class="fas fa-comment-dollar" style="font-size:36px;">&nbsp;<span class="heead">Expense Group</span></i>
                </div>
                <div class="content">
                    <ul>
                        <li><a href="<?= base_url('Common/addexpensegroup');?>">+ Expense Group</a></li>  
                        <li><a href="<?= base_url('Common/view_expensegroup');?>">View Expense Groups</a></li> 
                    </ul>
                </div>
             </div>
        </div>
        <?// }*/ ?>
    </div>
</div>
