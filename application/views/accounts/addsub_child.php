<style>
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
</style>
<? $role_permissions  = explode(",",$this->session->userdata('permissions')); ?>
<div class="container-fluid">
<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<h4 class="page-title">Sub Child Levels of <?=$name;?></h4>
			<ol class="breadcrumb">
			    <?
			    if($type == 1){
			        $typetitle = "Current Assets";
			    }elseif($type == 2){
			        $typetitle = "Non Current Assets";
			    }elseif($type == 3){
			        $typetitle = "Current Liabilities";
			    }elseif($type == 4){
			        $typetitle = "Non Current Liabilities";
			    }elseif($type == 5){
			        $typetitle = "Capital & Resources";
			    }
			    //echo $typetitle;
			    ?>
				<?/*?><li class="breadcrumb-item"><a href="<?= base_url('Accounts?type='.$type);?>"><?=$typetitle;?></a></li><?*/?>
				<li class="breadcrumb-item"><?=$url_tree;?><?=$name;?>/</li>
				<?/*?><li class="breadcrumb-item active">Sub Child Levels of <?=$name;?></li><?*/?>
			</ol>
		</div><!--end page-title-box-->
	</div><!--end col-->
</div>
<!-- end page title end breadcrumb -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
									<div class="col-lg-12">
										<?php $error_message = $this->session->userdata('error_message');
										  if (isset($error_message)) {
										?>
											<div class="alert alert-danger">
												<?php echo $error_message ?>                    
											</div>
										<?php
											$this->session->unset_userdata('error_message');
										}
										?>
										<?php 
										  $success_message = $this->session->userdata('success_message');
										  if (isset($success_message)) {
										?>
											<div class="alert alert-success">
												<?php echo $success_message ?>                    
											</div>
										<?php
											$this->session->unset_userdata('success_message');
										}
										?>
										</div>
										
					<form action="<?= base_url('Accounts/addsubchildsprocess');?>" method="post">
						<div class="row">
						<div class="col-md-3">
							<div class="mt-3">
            					<label class="mb-2">Add Sub Child <i class="text-danger">*</i></label>
            					<input type="text" class="form-control" name="name" id="name" required placeholder="e.g Name">
            				</div>
						</div>
						<!--<div class="col-md-3">-->
						<!--	<div class="mt-3">-->
      <!--      					<label class="mb-2"> Amount(PKR) <i class="text-danger">*</i></label>-->
      <!--      					<input type="text" class="form-control" name="amount" id="amount" required placeholder="e.g worth">-->
      <!--      				</div>-->
						<!-- </div>-->
						 <div class="col-md-3">
						<div class="mt-3">
            			<label class="mb-2">Parent Level  <i class="text-danger">*</i></label>
            			<select class="select2 form-control mb-3 custom-select" id="cs_parentid" name="cs_parentid" required="required" disabled style="background:#eee;">
                                <?php $mainlevelss	=	$this->Common_model->select_where_ASC_DESC('id,name','tbl_subsublevels',array('status' => 1),'name','ASC');
                                      if($mainlevelss->num_rows() > 0) {
                                      foreach($mainlevelss->result() as $mainlev) {
                                ?>
                                    <option value="<?php echo $mainlev->id;?>" <? if($mainlev->id == $id){ echo "selected"; } ?> ><?php echo $mainlev->name;?></option>
                                <?php } } ?>
                            </select>
                        </div>
						 </div>
						 <div class="col-md-3" style="margin-top:30px;">
            			<div class="mt-3">
						 <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1" name="haschild" value="1">
                                <label class="form-check-label" for="exampleCheck1">Has Levels</label>
                        </div>
                        </div>
                        </div>
                        
						 <div class="col-md-3">
            					<div class="mt-3">
            						<label class="mb-2">&nbsp;</label>
            						<?/*?><?
                                    $namechild =	$this->Common_model->select_single_field('name','tbl_subsublevels',array('id'=>$id));
                                    $fparentdiv =	$this->Common_model->select_single_field('name','tbl_sublevels',array('id'=>$_GET['fparent']));
                                    if(isset($_GET['cparent'])){ 
                                        $cparentdiv =	$this->Common_model->select_single_field('name','tbl_subsublevels',array('id'=>$_GET['cparent']));
                                    }
                                   ?>
                                <input type="text" name="url_tree" class="form-control" id="tree" value="<?=$typetitle;?>/<?=$fparentdiv;?>/<? if(isset($cparentdiv)){ echo $cparentdiv.'/'; }?><?=$namechild;?>"><?*/?>
                                <input type="hidden" name="url_tree" class="form-control" id="tree" value="<?=$url_tree;?><?=$name;?>/">
            						<input type="hidden" class="form-control" name="id" id="id" value="<?=$id;?>">
            						<input type="hidden" class="form-control" name="type" id="type" value="<?=$type;?>">
            						<?/*?><? if(isset($_GET['fparent'])){ ?>
            						<input type="hidden" class="form-control" name="fparent" id="fparent" value="<?=$_GET['fparent'];?>">
            						<? } ?>
            						<? if(isset($_GET['cparent'])){ ?>
            						<input type="hidden" class="form-control" name="cparent" id="cparent" value="<?=$_GET['cparent'];?>">
            						<? } ?><?*/?>
            						<button type="submit" class="btn btn-gradient-primary">Add</button>
            					</div>
            				</div>
						 </div>
						<br>
						</form>
					
	                <hr>	
	                	
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Date</th>
                                            <th>Name</th>
                                            <!--<th>Amount(PKR)</th>-->
                                            <th>level Of</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
										<?php if($childlevels){
										    $i = 1;
											foreach($childlevels as $ca){
                                                 // $name =	$this->Common_model->select_single_field('name','tbl_subsublevels',array('id'=>$ca['childParentId']));
                                                  //$fparent =	$this->Common_model->select_single_field('name','tbl_sublevels',array('id'=>$_GET['fparent']));
											?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><?= date('d-M-Y',strtotime($ca['date']));?></td>
                                            <td><?=$ca['name'];?></td>
                                            <!--<td><?//=$ca['amount'];?></td>-->
                                            <td><?=$url_tree;?><?=$name;?>/</td>
                                            <td>
											<? //if(!empty($role_permissions) && in_array(55,$role_permissions)) { ?>
											<a href="<?= base_url('Accounts/editchild/'.$ca['id'].'?type='.$type)?>">
											<i style="font-size:20px;cursor:pointer;" class="mdi mdi-square-edit-outline" title="Edit"></i></a>
											<? //} ?>
											<? //if(!empty($role_permissions) && in_array(56,$role_permissions)) { ?>
											<a href="<?= base_url('Accounts/deletechild/'.$ca['id'].'/'.$ca['childParentId'].'?type='.$type)?>" onclick="return confirm('Are you sure you want to delete this record.')">
											<i style="font-size:20px;cursor:pointer;" class="mdi mdi-delete-forever" title="Delete"></i>
											</a>
											<? //} ?>
											
											<? if($ca['haschild'] != 0){ ?>
											<a href="<?= base_url('Accounts/add_childLevel/'.$ca['id'].'?type='.$type)?>">
                            				<i style="font-size:20px;cursor:pointer;" class="fa fa-list" title="Add Sub Child Level"></i>
                            				</a>
											<? } ?>
											
			
											</td>
                                        </tr>
										<?php }}else{ ?>
										<tr>
                                            <td colspan='7'style="color:red;text-align:center;">Sorry No Record Found!</td>
                                        </tr>
                                        <? } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->
</div>
