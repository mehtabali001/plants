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
</style>
<? $role_permissions  = explode(",",$this->session->userdata('permissions')); ?>
<table id="datatable_tb" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead class="tabletop">
                                        <tr>
                                            <th>#</th>
                                            <th>Complaint ID</th>
                                            <th>Complainer Name</th>
                                            <!--<th>Date</th>-->
                                            <th>Subject</th>
                                            <th>Category</th>
                                            <!--<th>Description</th>-->
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
    
    
                                        <tbody>
										<?php if($my_complaints){
											$i=1;
											foreach($my_complaints as $comp){
												
											?>
                                        <tr>
                                            <td><?= $i;?></td>
                                            <td><?= $comp['fld_complain_id'];?></td>
                                            <td><?= $comp['fld_username'];?></td>
                                            <!--<td><?//= date('d-m-Y',strtotime($comp['fld_created_date']));?></td>-->
                                            <td><?= $comp['fld_complain_subject'];?></td>
                                            <td><?= $comp['category_name'];?></td>
                                            <!--<td><?//= $comp['fld_description'];?></td>-->
                                            <td>
											<?php if($comp['fld_status'] == 0){?>
											Pending
											<?php }elseif($comp['fld_status'] == 1){?>
											Resolved
											<?php }else{?>
											Not resolved
											<?php }?>
											
											</td>
                                            <td>
											
											<a href="<?= base_url('Complaints/view_asigned_complaint/'.$comp['fld_id'].'')?>">
											<i style="font-size:20px;cursor:pointer;" class="mdi mdi-eye-circle-outline" title="View"></i></a>
											<a type="button" onclick="viewInfo('<?= $comp['fld_username'];?>','<?= $comp['fld_email'];?>','<?= $comp['fld_mobile_number'];?>','<?= $comp['role_name'];?>')" class="complainerInfo" ><i class="mdi mdi-account-circle-outline" style="font-size:20px;cursor:pointer;"></i></a>
											<a type="button" class="resolveCompl" data-id="<?= $comp['fld_id'];?>" ><i class="mdi mdi-shield-check-outline" style="font-size:20px;cursor:pointer;"></i></a>
											
											</td>
                                        </tr>
										<?php  $i++;}} else {?>
										<td></td>
										<td></td>
										<td></td>
										<td  style="text-align:center;color:red;">
										        Sorry no record found
										 </td>
										 <td></td>
										<td></td>
										<td></td>
										<?}?>
                                        </tbody>
                                    </table>
