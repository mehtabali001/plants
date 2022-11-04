var base_url=$("#base_url").val();
	// 	key functions
	   $(document).keydown(function(e) {
        
                if (e.which == 121) {
            e.preventDefault();
                    $("#add_employee").click();
                    $("#add_attendance_btn").click();
                    $("#update-salarysetup").click();
                    $("#generate_salary").click();
                    $("#show_report").click();
                    $("#show_report_1").click();
                }
                if (e.which == 117 ){
                    e.preventDefault();
                    $("#edit").click();
                    $("#print_report").click();
                    $("#print_salaries_report").click();
                }
                if (e.which == 118 ){
                    e.preventDefault();
                    $("#add_purchase_draft").click();
                    $("#pdf_report").click();
                    $("#pdf_salaries_report").click();
                    
                }
                if (e.which == 119) {
            e.preventDefault();
                    $("#update_draft_purchase").click();
                    $("#advance_search").click();
                }
                
            });
function getFilterAttendence(reset = 0){
   var body = $("body");
    var table = $('#datatable').DataTable();
//   body.addClass("loading")
    if(reset==0){
        
	$('#employee_data').html("<tr style='background-color: #fff;' ><td colspan='9' class='center' style='text-align: center;width: 100px;' ><img src='"+base_url+"assets/uploads/ajax_loading.gif' ></td></tr>");
    }
   var data = $("#attendanceFilterForm").serialize();
     jQuery.ajax({
				url  	: base_url+"Employees/filterAttendence/"+reset,
				type 	: 'POST',
				data 	: data,
				success : function(data){
				    console.log(data);
					//if(page_id>1){$("html, body").animate({ scrollTop: 80 }, "slow");}
						 
						 var obj = JSON.parse(data);
						 console.log(obj);
						 	// body.removeClass("loading")
						 if(reset == 0){
						     table.destroy();
						     
						     $('#employee_data').html(obj.table);
						     $('#datatable').DataTable();
    						 
						 }else{
					     	$('#col3_filter').html(obj.des_sel);
    						$('#col2_filter').html(obj.plant_sel);
    						$('#col6_filter').html(obj.status_sel);
						 }
						 
				// 		table.draw();
				
				}
			});	
 }
 
 
function getFilterEmployee(){
   var body = $("body");
    var table = $('#datatable').DataTable();
//   body.addClass("loading")
    
        
	$('#employee_data').html("<tr style='background-color: #fff;' ><td colspan='8' class='center' style='text-align: center;width: 100px;' ><img src='"+base_url+"assets/uploads/ajax_loading.gif' ></td></tr>");
    
   var data = $("#search-emp-form").serialize();
     jQuery.ajax({
				url  	: base_url+"Employees/getFilterEmployee",
				type 	: 'POST',
				data 	: data,
				success : function(data){
				    console.log(data);
						 
				// 		 var obj = JSON.parse(data);
				// 		 console.log(obj);
				// 		 if(reset == 0){
						     table.destroy();
						     $('#employee_data').html(data);
						     $('#datatable').DataTable();
    						 
				// 		 }else{
				// 	     	$('#col3_filter').html(obj.des_sel);
    // 						$('#col2_filter').html(obj.plant_sel);
    // 						$('#col6_filter').html(obj.status_sel);
				// 		 }
						
					
					
				}
			});	
 }
 
function getFilterPaidsalaries(){
    
    var body = $("body");
    // var table = $('#datatable').DataTable();
	$('#employee_data').html("<tr style='background-color: #fff;' ><td colspan='7' class='center' style='text-align: center;width: 100px;' ><img src='"+base_url+"assets/uploads/ajax_loading.gif' ></td></tr>");
    var data = $("#search-paidsalaries-form").serialize();
    jQuery.ajax({
				url  	: base_url+"Payroll/getFilterPaidsalaries",
				type 	: 'POST',
				data 	: data,
				success : function(data){
				    console.log(data);
				// 	table.destroy();
					$('#employee_data').html(data);
				    // $('#datatable').DataTable();
				}
			});	
 } 
 
function resetFilters(){
    $("#col1_filter").val("").change();
    $("#col0_filter").val("");
}

/*function loadData()
{	
		var form_data = {
			ajax	 : '1'
		};
			
		jQuery.ajax({
			url  	: base_url+"Employees/ajax_employeelisting",
			type 	: 'POST',
			data 	: form_data,
			success : function(data){
				//if(page_id>1){$("html, body").animate({ scrollTop: 80 }, "slow");}
				$('#result_ajax').html(data);
			}
		});	
}
	
jQuery(document).ready(function(){
		$('#result_ajax').html("<tr style='background-color: #10163a;' ><td colspan='7' class='center' ><img src="+base_url+'assets/theme_elements/images/ajax_loading.gif'+"></td></tr>");
		loadData();
		$(document).on('click',"a.paging_page",function(){
			$('#result_ajax').html("<tr style='background-color: #10163a;' ><td colspan='9' class='center' ><img src="+base_url+'assets/theme_elements/images/ajax_loading.gif'+"></td></tr>");
			$("#page_id").val();
			loadData();
		});		
		
});*/
	
	$(document).on("click","#show_report",function(e) {
		e.preventDefault();
		$('#datatable_tb').DataTable().clear().destroy();
		$('#filterhtml').html("<div style='background-color: #FFF;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/uploads/ajax_loading.gif' ></div></div>");
		$.ajax({
			url:base_url+"payroll/filter",
			dataType: "html",
			type: "POST",
			data: $('#salaryfilter').serialize(),
			success: function(res) {
			 //   console.log(res);
			    if(res=='all_required'){
			        alert("Please select all feilds.");
			    }else{
			      var obj=JSON.parse(res);
				$("#filterhtml").html(obj.html);
				$('#datatable_tb').DataTable({
					"order": [],
					"lengthMenu": [[50, 100, 500, -1], [50, 100, 500, "All"]]
				});
				if(obj.count > 0){
				
				$('#print_salaries_report').removeAttr('disabled');
				$('#pdf_salaries_report').removeAttr('disabled');
				$('#advance_search').removeAttr('disabled');
				
				}else{
				    $("#print_salaries_report").attr( "disabled", "disabled" );
				    $("#pdf_salaries_report").attr( "disabled", "disabled" );
				    $("#advance_search").attr( "disabled", "disabled" );
				}
				$('#reset_filters').removeAttr('disabled');  
			    }
				
			}
		})
	});
	
	$(document).on("click","#print_salaries_report",function(e) {
		e.preventDefault();
		var currentdate = new Date(); 
            var datetime = currentdate.getDate() + " - "
                + (currentdate.getMonth()+1)  + " - " 
                + currentdate.getFullYear() + "  "  
                + currentdate.getHours() + ":"  
                + currentdate.getMinutes() ;
		console.log("hello");
		var seldatafilter = $('#salaryfilter').serialize();
// 		if($('.salaryRow tr').length > 0){
		window.open(base_url + 'payroll/print_salaries_report?'+seldatafilter, "Salary Report", 'width=1210, height=842');
// 		}
	});
	
	$(document).on("click","#pdf_salaries_report",function(e) {
		e.preventDefault();
// 		if($('.salaryRow tr').length > 0){
	    var seldatafilter = $('#salaryfilter').serialize();
		var url=base_url+'payroll/pdf_salaries_report?'+seldatafilter;
		window.open(url);
// 		}
	});


		$( document ).ready(function() {
			$(".select2").select2({
            width: '100%'
        });
		/*$('.datepicker').daterangepicker({
			singleDatePicker: true,
			showDropdowns: true,
			minYear: 2010,
			maxYear: parseInt(moment().format('YYYY'),10)
		  });*/
		  var type=$("#filter_type").val();
		  if(type != ""){
		      
		      $("#search_button").removeAttr('disabled');
		      
		      setTimeout(function(){
		          $("#loader_img").css('display','none');
		          $("#datatable_tb").show();
		      }, 600);
		      
		      
		  }else{
		      $("#loader_img").css('display','none');
		  }
		});
    
    
    function clear_field()
	{
		$('#student_form')[0].reset();
		$('#error_student_name').text('');
		$('#error_student_roll_number').text('');
		$('#error_student_dob').text('');
		$('#error_student_grade_id').text('');
	}
     	  
      var attendance_id = '';

	  $(document).on('click', '.edit_student', function(){
		//$('#formModal').modal('show');  
		attendance_id = $(this).attr('id');
		clear_field();
		$.ajax({
		  url:base_url+"Employees/edit_attendance",
		  method:"POST",
		  data:{action:'edit_fetch', attendance_id:attendance_id},
		  dataType:"json",
		  success:function(data)
		  {
			$('.check_in').val(data.check_in);
			$('.check_out').val(data.check_out);
			$('#attendance_status').val(data.attendance_status);
			$('#attendance_id').val(attendance_id);
			$('#modal_title').text('Edit Attendance');
			$('#button_action').val('Edit');
			$('#action').val('Edit');
			$('#formModal').modal('show');
		  }
		})
	  });
    
        window.onload = function() {
              $("#target").hide();
              $("#target2").hide();
              $("#target3").hide();
              $("#target4").hide();
              $("#target5").hide();
              $("#target6").hide();
              $("#target7").hide();
        };
            $('.toggle').click(function() {
               $('#target').toggle();
            });
            $('.toggle2').click(function() {
               $('#target2').toggle();
            });
            $('.toggle3').click(function() {
               $('#target3').toggle();
            });
            $('.toggle4').click(function() {
                $('#target4').toggle();
             });
             $('.toggle5').click(function() {
                $('#target5').toggle();
             });
             $('.toggle6').click(function() {
                $('#target6').toggle();
             });
             $('.toggle7').click(function() {
                $('#target7').toggle();
             });

         function submitEmployeetype(){
            var new_type 	= 	 $("#new_type").val();
            if(new_type == " ")
            {
                return false;
            }
		
	        //$('#new_type_btn').html('<button class="btn btn-primary pull-left" disabled >Loading...</button>');
	        $("#employee_type").prop("disabled", true);
		
            jQuery.ajax({
                url: base_url+"Employees/add_employeeType",
                type: "POST",
                data: "new_type="+new_type,
                success : function(return_data){
                        $("#employee_type").prop("disabled", false);
                        if(return_data == "required_type_name"){
                            alert("Please Enter Type Name.");
                        }else if(return_data == "type_already_found"){
                            alert("Type Name Already Exist.");
                            //$('#bank_div').html('<div class="alert alert-danger fade in alert-dismissible show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" style="font-size:20px">×</span></button>Bank Name Already Exist.</div>');
                        }else{
                             $('#type_div').html(return_data);
                             $('#new_type_btn').html('<button class="btn btn-primary pull-left" type="button" onClick="submitEmployeetype();" > ADD </button>');
                        }
                        
                        $('button.btn').click(function() {
                            $("#save_or_draft").val($(this).val());	
                        });
                }
            });
            $("#target").hide();
            $('#new_type').val("");
        }

         function submitAgreementtype(){
            var new_agreement_type 	= 	 $("#new_agreement_type").val();
            if(new_agreement_type == " ")
            {
                return false;
            }
		
	       // $('#new_agreementtype_btn').html('<button class="btn btn-primary pull-left" disabled >Loading...</button>');
	        $("#agreement_type").prop("disabled", true);
		
            jQuery.ajax({
                url: base_url+"Employees/add_agreementType",
                type: "POST",
                data: "new_agreement_type="+new_agreement_type,
                success : function(return_data){
                        $("#agreement_type").prop("disabled", false);
                        if(return_data == "required_agreementtype_name"){
                            alert("Please Enter Agreement Type Name.");
                        }else if(return_data == "agreementtype_already_found"){
                            alert("Agreement Type Name Already Exist.");
                            //$('#bank_div').html('<div class="alert alert-danger fade in alert-dismissible show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" style="font-size:20px">×</span></button>Bank Name Already Exist.</div>');
                        }else{
                             $('#agreementtype_div').html(return_data);
                             $('#new_agreementtype_btn').html('<button class="btn btn-primary pull-left" type="button" onClick="submitAgreementtype();" > ADD </button>');
                        }
                        
                        $('button.btn').click(function() {
                            $("#save_or_draft").val($(this).val());	
                        });
                    }
            });
            $("#target2").hide();
            $('#new_agreement_type').val("");
        }



         function submitDepartment(){
            var new_department 	= 	 $("#new_department").val();
            if(new_department == " ")
            {
                return false;
            }
		
	        //$('#new_department_btn').html('<button class="btn btn-primary pull-left" disabled >Loading...</button>');
	        $("#department").prop("disabled", true);
		
            jQuery.ajax({
                url: base_url+"Employees/add_department",
                type: "POST",
                data: "new_department="+new_department,
                success : function(return_data){
                        $("#department").prop("disabled", false);
                        if(return_data == "required_department_name"){
                            alert("Please Enter Department Name.");
                        }else if(return_data == "department_already_found"){
                            alert("Department Already Exist.");
                            //$('#bank_div').html('<div class="alert alert-danger fade in alert-dismissible show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" style="font-size:20px">×</span></button>Bank Name Already Exist.</div>');
                        }else{
                             $('#department_div').html(return_data);
                             $('#new_department_btn').html('<button class="btn btn-primary pull-left" type="button" onClick="submitDepartment();" > ADD </button>');
                        }
                        
                        $('button.btn').click(function() {
                            $("#save_or_draft").val($(this).val());	
                        });
                    }
            });
            $("#target3").hide();
            $('#new_department').val("");
        }

        function submitDesignation(){
            var new_designation	= 	 $("#new_designation").val();
            if(new_designation == " ")
            {
                return false;
            }
		
	        //$('#new_designation_btn').html('<button class="btn btn-primary pull-left" disabled >Loading...</button>');
	        $("#designation").prop("disabled", true);
		
            jQuery.ajax({
                url: base_url+"Employees/add_designation",
                type: "POST",
                data: "new_designation="+new_designation,
                success : function(return_data){
                        $("#designation").prop("disabled", false);
                        if(return_data == "required_designation_name"){
                            alert("Please Enter Designation Name.");
                        }else if(return_data == "designation_already_found"){
                            alert("Designation Already Exist.");
                            //$('#bank_div').html('<div class="alert alert-danger fade in alert-dismissible show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" style="font-size:20px">×</span></button>Bank Name Already Exist.</div>');
                        }else{
                             $('#designation_div').html(return_data);
                             $('#new_designation_btn').html('<button class="btn btn-primary pull-left" type="button" onClick="submitDesignation();" > ADD </button>');
                        }
                        
                        $('button.btn').click(function() {
                            $("#save_or_draft").val($(this).val());	
                        });
                    }
            });
            $("#target4").hide();
            $('#new_designation').val("");
        }

        function submitReligion(){
            var new_religion 	= 	 $("#new_religion").val();
            if(new_religion == " ")
            {
                return false;
            }
		
	       // $('#new_religion_btn').html('<button class="btn btn-primary pull-left" disabled >Loading...</button>');
	        $("#religion").prop("disabled", true);
		
            jQuery.ajax({
                url: base_url+"Employees/add_religion",
                type: "POST",
                data: "new_religion="+new_religion,
                success : function(return_data){
                        $("#religion").prop("disabled", false);
                        if(return_data == "required_religion_name"){
                            alert("Please Enter Religion Name.");
                        }else if(return_data == "religion_already_found"){
                            alert("Religion Already Exist.");
                            //$('#bank_div').html('<div class="alert alert-danger fade in alert-dismissible show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" style="font-size:20px">×</span></button>Bank Name Already Exist.</div>');
                        }else{
                             $('#religion_div').html(return_data);
                             $('#new_religion_btn').html('<button class="btn btn-primary pull-left" type="button" onClick="submitReligion();" > ADD </button>');
                        }
                        
                        $('button.btn').click(function() {
                            $("#save_or_draft").val($(this).val());	
                        });
                    }
            });
            $("#target5").hide();
            $('#new_religion').val("");
        }

        function submitShifts(){
            var new_shift_group 	= 	 $("#new_shift_group").val();
            if(new_shift_group == " ")
            {
                return false;
            }
		
	        //$('#new_shift_btn').html('<button class="btn btn-primary pull-left" disabled >Loading...</button>');
	        $("#shift_group").prop("disabled", true);
		
            jQuery.ajax({
                url: base_url+"Employees/add_shiftgroup",
                type: "POST",
                data: "new_shift_group="+new_shift_group,
                success : function(return_data){
                        $("#shift_group").prop("disabled", false);
                        if(return_data == "required_shift_name"){
                            alert("Please Enter Shift Name.");
                        }else if(return_data == "shift_already_found"){
                            alert("Shift Name Already Exist.");
                            //$('#bank_div').html('<div class="alert alert-danger fade in alert-dismissible show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" style="font-size:20px">×</span></button>Bank Name Already Exist.</div>');
                            
                        }else{
                             $('#shifts_div').html(return_data);
                             $('#new_shift_btn').html('<button class="btn btn-primary pull-left" type="button" onClick="submitShifts();" > ADD </button>');
                        }
                        
                        $('button.btn').click(function() {
                            $("#save_or_draft").val($(this).val());	
                        });
                }
            });
            $("#target6").hide();
            $('#new_shift_group').val("");
        }
        
        
        function submitBank(){
            var new_bank 	= 	 $("#new_bank").val();
            if(new_bank == " ")
            {
                return false;
            }
		
	     // $('#new_bank_btn').html('<button class="btn btn-primary pull-left" disabled >Loading...</button>');
	        $("#bank_name").prop("disabled", true);
		
            jQuery.ajax({
                url: base_url+"Employees/add_bank",
                type: "POST",
                data: "new_bank="+new_bank,
                success : function(return_data){
                        $("#bank_name").prop("disabled", false);
                        if(return_data == "required_bank_name"){
                            alert("Please Enter Bank Name.");
                        }else if(return_data == "bank_already_found"){
                            alert("Bank Name Already Exist.");
                            //$('#bank_div').html('<div class="alert alert-danger fade in alert-dismissible show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" style="font-size:20px">×</span></button>Bank Name Already Exist.</div>');
                            
                        }else{
                             $('#bank_div').html(return_data);
                             $('#new_bank_btn').html('<button class="btn btn-primary pull-left" type="button" onClick="submitBank();" > ADD </button>');
                        }
                        
                        $('button.btn').click(function() {
                            $("#save_or_draft").val($(this).val());	
                        });
                    }
            });
            $("#target7").hide();
            $('#new_bank').val("");
        }
        
function checkMe(selected)
{
if(selected)
{
document.getElementById("divcheck").style.display = "";
} 
else
{
document.getElementById("divcheck").style.display = "none";
}

}

/*function Remove_options()
{
$('.dropdownstatus')
    .empty()
    //.append('<option selected="selected" value="test">White</option>');
}*/ 
 
        // On text click
        $('.edit').click(function(){
			
		 /* $('.dropdownstatus').append('<option value="Present" <? if($emp["attendance_status"] == "Present"){ echo "selected"; } ?>>Present</option><option value="Absent" <? if($emp["attendance_status"] == "Absent"){ echo "selected"; } ?>>Absent</option><option value="Sick Leave" <? if($emp["attendance_status"] == "Sick Leave"){ echo "selected"; } ?>>Sick Leave</option><option value="Short Leave" <? if($emp["attendance_status"] == "Short Leave"){ echo "selected"; } ?>>Short Leave</option>');*/
		  
		  /* $.ajax({
				url: base_url+'Employees/loadview',
				type:'POST',
			}).done(function(data) {
				$('.dropdownstatus').append(data);
			});*/

          // Hide input element
          $('.txtedit').hide();

          // Show next input element
          $(this).next('.txtedit').show().focus();

          // Hide clicked element
          $(this).hide();
        });

        // Focus out from a textbox
        $('.txtedit').focusout(function(){
            // Get edit id, field name and value
            var edit_id = $(this).data('id');
            var fieldname = $(this).data('field');
            var value = $(this).val();

            // Hide Input element
            $(this).hide();
            //$('.dropdownstatus').empty();
            // Update viewing value and display it
            $(this).prev('.edit').show();
            $(this).prev('.edit').text(value);

            // Send AJAX request
            $.ajax({
              url: base_url+'Employees/update_attendance',
              type: 'post',
              data: { field:fieldname, value:value, id:edit_id },
              success:function(response){
                console.log(response);
              }
            });
        });
        
        // Employee Report


	$(document).on("click","#show_report_1",function(e) {
		e.preventDefault();
			$('#datatable_tb').DataTable().clear().destroy();
		$('#filterhtml').html("<div style='background-color: #FFF;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/uploads/ajax_loading.gif' ></div></div>");
	   // return false;
	   //$('#filterhtml').html("<div style='background-color: #10163a;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/theme_elements/images/logo-sm.png' style='height:40px;'></div></div>");
		$.ajax({
			url:base_url+"Employees/filter",
			dataType: "html",
			type: "POST",
			data: $('#employeefilter').serialize(),
			success: function(res) {
			 //   console.log(res);
				var obj=JSON.parse(res);
				$("#filterhtml").html(obj.html);
				if(obj.count > 0){
				$('#datatable_tb').DataTable({
					"order": [],
					"lengthMenu": [[50, 100, 500, -1], [50, 100, 500, "All"]]
				});
				$('#print_report').removeAttr('disabled');
				$('#pdf_report').removeAttr('disabled');
				$('#advance_search').removeAttr('disabled');
				
				}else{
				    $("#print_report").attr( "disabled", "disabled" );
				    $("#pdf_purchase_report").attr( "disabled", "disabled" );
				    $("#advance_search").attr( "disabled", "disabled" );
				}
				$('#reset_filters').removeAttr('disabled');
			}
		})
	});
	
	function advanceSearch(){
	    $('#filterhtml').html("<div style='background-color: #FFF;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/uploads/ajax_loading.gif' ></div></div>");
	   //var advancesearchform =  $('#advance-search-form').serialize();
	   var employeefilter = $('#employeefilter').serialize();
	   var finaldata = employeefilter;
	   //console.log(finaldata);
	    	$.ajax({
			url:base_url+"Employees/filter",
			dataType: "html",
			type: "POST",
			data: finaldata,
			success: function(res) {
			 //   console.log(res);
				var obj=JSON.parse(res);
				$("#filterhtml").html(obj.html);
			}
		})
	}
	
	function setreportfilter(val){
		$("#filter_type").val(val);
	}
	$(document).on("click","#print_report",function(e) {
		e.preventDefault();
		var etype = $('#filter').val();
		var type = $('#filter_type').val();
		 
		window.open(base_url + 'Employees/print_report?filter='+etype, "Employees Report", 'width=1210, height=842');
// 		var table = $('#datatable').DataTable();
	});
	$(document).on("click","#pdf_report",function(e) {			
		var etype = $('#filter').val();
		 var employeefilter = $('#employeefilter').serialize();
		var url=base_url+'Employees/print_employee_report?filter='+etype+'&'+employeefilter;
		window.open(url);
	});
	
	$(document).on("click","#advance_search",function(e) {
	    e.preventDefault();
	    $("#show_filters_tab").toggle();
	});
        
// $(document).ready(function(){
    
//     $('#date').datepicker({
//     dateFormat: 'd MM, y'
// });


//  $('#employee_data').editable({
//   container: 'body',
//   selector: 'td.check_in',
//   url: base_url+"Employees/update_attendance1",
//   title: 'Check In',
//   type: "POST",
//   dataType: 'json',
//   validate: function(value){
//   if($.trim(value) == '')
//   {
//      return 'This field is required';
//   }
//   }
//  });
 
//  $('#employee_data').editable({
//   container: 'body',
//   selector: 'td.check_out',
//   url: base_url+"Employees/update_attendance1",
//   title: 'Check Out',
//   type: "POST",
//   dataType: 'json',
//   validate: function(value){
//   if($.trim(value) == '')
//   {
//      return 'This field is required';
//   }
//   }
//  });
 
//  $('#employee_data').editable({
//   container: 'body',
//   selector: 'td.attendance_status',
//   url: base_url+"Employees/update_attendance1",
//   title: 'Status',
//   type: "POST",
//   //mode: 'inline',
//   dataType: 'json',
//   source: [{value: "Present", text: "Present"}, {value: "Absent", text: "Absent"}, {value: "Sick Leave", text: "Sick Leave"}, {value: "Short Leave", text: "Short Leave"}],
//   validate: function(value){
//   if($.trim(value) == '')
//   {
//      return 'This field is required';
//   }
//   }
//  });
 
// $('#employee_data').editable({
//   container: 'body',
//   selector: 'td.basic_salary',
//   url: base_url+"Payroll/update_payroll",
//   title: 'Basic Salary',
//   type: "POST",
//   dataType: 'json',
//   validate: function(value){
//   if($.trim(value) == '')
//   {
//      return 'This field is required';
//   }
//   }
// });

// $('#employee_data').editable({
//   container: 'body',
//   selector: 'td.bonus',
//   url: base_url+"Payroll/update_payroll",
//   title: 'Bonus',
//   type: "POST",
//   dataType: 'json',
//   validate: function(value){
//   if($.trim(value) == '')
//   {
//      return 'This field is required';
//   }
//   }
// });

// $('#employee_data').editable({
//   container: 'body',
//   selector: 'td.deduction',
//   url: base_url+"Payroll/update_payroll",
//   title: 'Deduction',
//   type: "POST",
//   dataType: 'json',
//   validate: function(value){
//   if($.trim(value) == '')
//   {
//      return 'This field is required';
//   }
//   }
// });
 
 
// });  
if(document.getElementById("employee") != null) {
document.getElementById("employee").onchange = function(event) {
//event.target.selectedOptions[0] have that option. as this is single selection by dropdown. this will always be 0th index :)
let get_val = event.target.selectedOptions[0].getAttribute("data_set");
let des_val = event.target.selectedOptions[0].getAttribute("data_designation");
let plant_val = event.target.selectedOptions[0].getAttribute("data_plant");
let bank_name = event.target.selectedOptions[0].getAttribute("data_bank_name");
let account_no = event.target.selectedOptions[0].getAttribute("data_account_no");
let basicpay_val = event.target.selectedOptions[0].getAttribute("data_basicpay");
let data_medallow = event.target.selectedOptions[0].getAttribute("data_medallow");
let data_other = event.target.selectedOptions[0].getAttribute("data_other");

let total_advance_amount = event.target.selectedOptions[0].getAttribute("data_total_advance_amount");
let return_advance_amount = event.target.selectedOptions[0].getAttribute("data_return_advance_amount");
let loanpaid_type = event.target.selectedOptions[0].getAttribute("data_loanpaid_type");
let pay_per_month = event.target.selectedOptions[0].getAttribute("data_pay_per_month");

let data_grosspay = event.target.selectedOptions[0].getAttribute("data_grosspay");
let data_eobi = event.target.selectedOptions[0].getAttribute("data_eobi");
let data_social = event.target.selectedOptions[0].getAttribute("data_social");
let data_tax = event.target.selectedOptions[0].getAttribute("data_tax");
let data_deduction = event.target.selectedOptions[0].getAttribute("data_deduction");
let data_netpay = event.target.selectedOptions[0].getAttribute("data_netpay");



//document.getElementById("demo").innerHTML = "You selected: " + get_val;
document.getElementById("employee_code").value = get_val;
document.getElementById("designation").value = des_val;
document.getElementById("plant").value = plant_val;
//document.getElementById("bank_name").value = bank_name;
document.getElementById("account_no").value = account_no;
document.getElementById("basic_pay").value = basicpay_val;
document.getElementById("medical_allowence").value = data_medallow;
document.getElementById("other").value = data_other;

document.getElementById("total_advance_amount").value = total_advance_amount;
//document.getElementById("return_advance_amount").value = return_advance_amount;
document.getElementById("return_advance_amount").innerHTML = ("(Return Loan: "+return_advance_amount+")");
//document.getElementById("loanpaid_type").value = loanpaid_type;
document.getElementById("pay_per_month").value = pay_per_month;

document.getElementById("gross_pay").value = data_grosspay;
document.getElementById("eobi").value = data_eobi;
document.getElementById("social_security").value = data_social;
document.getElementById("salary_tax").value = data_tax;
document.getElementById("t_deductions").value = data_deduction;
document.getElementById("net_payment").value = data_netpay;

}
}


$(document).ready(function(){
// Initialize Select2
  $('#bank_name').select2();

  // Set option selected onchange
   $('#employee').change(function(event){
//     var value = $(this).val();
       var value = event.target.selectedOptions[0].getAttribute("data_bank_name");
       //let value = bank_name;
    //   console.log(value);
//     // Set selected 
     $('#bank_name').val(value);
     $('#bank_name').select2().trigger('change');

   });
});	

function inputCode(sl, val){
    $("#f_balance_"+sl).val(val);
    getBalance(1, sl, val);
}

function getBalance(rowId, valid){
    $.ajax({
			url:base_url+"Vouchers/getBalance",
			type: "POST",
			data: {id:valid},
			success: function(res) {
				// console.log(res);
				$("#f_balance_"+rowId).html("(Balance: "+res+")");
				$("#f_InputBalance_"+rowId).val(res);
		}
	});
	validVal(rowId);
}

// Employee Report

	$(document).on("click","#show_report_1",function(e) {
	    	$('#datatable_tb').DataTable().clear().destroy();
		e.preventDefault();
		$('#filterhtml').html("<div style='background-color: #FFF;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/uploads/ajax_loading.gif' ></div></div>");
	   // return false;
	   //$('#filterhtml').html("<div style='background-color: #10163a;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/theme_elements/images/logo-sm.png' style='height:40px;'></div></div>");
		$.ajax({
			url:base_url+"Employees/filter",
			dataType: "html",
			type: "POST",
			data: $('#employeefilter').serialize(),
			success: function(res) {
			 //   console.log(res);
				var obj=JSON.parse(res);
				$("#filterhtml").html(obj.html);
				if(obj.count > 0){
				$('#datatable_tb').DataTable({
					"order": [],
					"lengthMenu": [[50, 100, 500, -1], [50, 100, 500, "All"]]
				});
				$('#print_report').removeAttr('disabled');
				$('#pdf_purchase_report').removeAttr('disabled');
				$('#advance_search').removeAttr('disabled');
				
				}else{
				    $("#print_report").attr( "disabled", "disabled" );
				    $("#pdf_purchase_report").attr( "disabled", "disabled" );
				    $("#advance_search").attr( "disabled", "disabled" );
				}
				$('#reset_filters').removeAttr('disabled');
			}
		})
	});
	
	function advanceSearch(){
	    $('#filterhtml').html("<div style='background-color: #FFF;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/uploads/ajax_loading.gif' ></div></div>");
	   //var advancesearchform =  $('#advance-search-form').serialize();
	   var employeefilter = $('#employeefilter').serialize();
	   var finaldata = employeefilter;
	   //console.log(finaldata);
	    	$.ajax({
			url:base_url+"Employees/filter",
			dataType: "html",
			type: "POST",
			data: finaldata,
			success: function(res) {
			    console.log(res);
				var obj=JSON.parse(res);
				$("#filterhtml").html(obj.html);
			}
		})
	}
	
	function setreportfilter(val){
		$("#filter_type").val(val);
	}
	$(document).on("click","#print_report",function(e) {
		e.preventDefault();
		var etype = $('#filter').val();
		var type = $('#filter_type').val();
		 
		window.open(base_url + 'purchase/print_report?filter='+etype+'&type='+type, "Purchase Report", 'width=1210, height=842');
		var table = $('#datatable_tb').DataTable();
	});
	$(document).on("click","#pdf_purchase_report",function(e) {
		e.preventDefault();
		if($('.purchaseRows tr').length > 0){
		var fromDate = $('#from_date').val();
		var toDate = $('#to_date').val();			
		var etype = $('#filter').val();
		var type = $('#filter_type').val();
		var url=base_url+'purchase/print_purchase_report?form=' + fromDate + '&to=' + toDate+'&filter='+etype+'&type='+type;
		window.open(url);
		}
	});
	
	$(document).on("click","#advance_search",function(e) {
	    e.preventDefault();
	    $("#show_filters_tab").toggle();
	});
	$(document).on("change","#filter_type",function(e) {
	    e.preventDefault();
	    var type=$(this).val();
		  if(type != ""){
		      $("#search_button").removeAttr('disabled');
		  }
	});
	
