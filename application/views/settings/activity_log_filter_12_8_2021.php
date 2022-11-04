
<table id="datatable_tb" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                        <tr>
                                            <th>#</th>
											<th>Date</th>
                                            <th>User ID</th>
                                            <th>Role</th>
                                            <th>Action</th>
                                            <th>Details</th>
                                            <th>IP</th>
                                        </tr>
                                        </thead>
    
    
                                        <tbody>
										<?php if($activity_logs){
											$i=1;
											foreach($activity_logs as $logs){
										?>
											<tr>
												<td><?= $i;?></td>
												<td><?= date('d-m-Y H:i',strtotime($logs['fld_added_date']));?></td>
												<td><?= $logs['fld_username'];?></td>
												<td><?= $logs['fld_role_name'];?></td>
												<td><?= $logs['fld_action'];?></td>
												<td><?= $logs['fld_detail'];?></td>
												<td><?= $logs['fld_ip_address'];?></td>
												
												
											</tr>
										<?php $i++;}}?>
                                        </tbody>
                                    </table>