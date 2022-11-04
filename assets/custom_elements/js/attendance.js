 var base_url=$("#base_url").val();
 	$(document).on("click","#advance_search",function(e) {
	    e.preventDefault();
	    $("#show_filters_tab").toggle();
	});
 $(document).keydown(function(e) {
        
                if (e.which == 121) {
            e.preventDefault();
                    $("#add_employee").click();
                    $("#show_report_1").click();
                }
                if (e.which == 117 ){
                    e.preventDefault();
                    $("#edit").click();
                    $("#print_report").click();
                }
                if (e.which == 118 ){
                    e.preventDefault();
                    $("#add_purchase_draft").click();
                    $("#pdf_report").click();
                    
                }
                if (e.which == 119) {
            e.preventDefault();
                    $("#update_draft_purchase").click();
                    $("#advance_search").click();
                }
                
            });
            
function getattendanceDataByDate(type){
    if(type=='daily'){
        var currentdate = new Date();
        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', currentdate));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', currentdate));
        getattendance();
    }else if(type=='weekly'){
        var currentdate = new Date();
        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', new Date(currentdate.setDate(currentdate.getDate() - currentdate.getDay()))));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', new Date(currentdate.setDate(currentdate.getDate() - currentdate.getDay()+6))));
        getattendance();
    }else if(type=='monthly'){
        var date = new Date();
        var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
        var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', firstDay));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', lastDay));
        getattendance();
    }else if(type=='yearly'){
        var date = new Date();
        var firstDay = new Date(date.getFullYear(), 0, 1);
        var lastDay = new Date(date.getFullYear(), 11 + 1, 0);

        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', firstDay));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', lastDay));
        getattendance();
    }
}        
            
    function getattendance(){
        $('#filterhtml').html("<div style='background-color: #FFF;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/uploads/ajax_loading.gif' ></div></div>");
		$.ajax({
			url:base_url+"Employees/filterattendence_report",
			dataType: "html",
			type: "POST",
			data: $('#attendanceFilterForm').serialize(),
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
				    $("#pdf_report").attr( "disabled", "disabled" );
				    $("#advance_search").attr( "disabled", "disabled" );
				}
				$('#reset_filters').removeAttr('disabled');
			}
		})
    }        
            
    /*$(document).on("click","#show_report",function(e) {
		e.preventDefault();
		$('#filterhtml').html("<div style='background-color: #FFF;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/uploads/ajax_loading.gif' ></div></div>");
		$.ajax({
			url:base_url+"Employees/filterattendence_report",
			dataType: "html",
			type: "POST",
			data: $('#attendanceFilterForm').serialize(),
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
				    $("#pdf_report").attr( "disabled", "disabled" );
				    $("#advance_search").attr( "disabled", "disabled" );
				}
				$('#reset_filters').removeAttr('disabled');
			}
		})
	});*/
	
	function advanceSearch(){
	    $('#filterhtml').html("<div style='background-color: #FFF;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/uploads/ajax_loading.gif' ></div></div>");
	   
	   var purchasefilter = $('#attendanceFilterForm').serialize();
	   var finaldata = purchasefilter
	    	$.ajax({
			url:base_url+"Employees/filterattendence_report",
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
		$("#attendanceFilterForm").val(val);
	}
	$(document).on("click","#print_report",function(e) {
		e.preventDefault();
		var etype = $('#filter').val();
		var type = $('#filter_type').val();
		
		 var purchasefilter = $('#attendanceFilterForm').serialize();
		 
		window.open(base_url + 'Employees/print_attendance_report?'+purchasefilter, "Print Report", 'width=1210, height=842');
		var table = $('#datatable').DataTable();
	});
	$(document).on("click","#pdf_report",function(e) {
		e.preventDefault();
		
		var purchasefilter = $('#attendanceFilterForm').serialize();
		var url=base_url+'Employees/pdf_attendence_report?'+purchasefilter;
		window.open(url);
		
	});