 var base_url=$("#base_url").val();
 var count = 2;
 "use strict";
 
 function getNavigationFilterDataByDate(type){
    if(type=='daily'){
        var currentdate = new Date();
        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', currentdate));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', currentdate));
        getnavigation();
    }else if(type=='weekly'){
        var currentdate = new Date();
        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', new Date(currentdate.setDate(currentdate.getDate() - currentdate.getDay()))));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', new Date(currentdate.setDate(currentdate.getDate() - currentdate.getDay()+6))));
        getnavigation();
    }else if(type=='monthly'){
        var date = new Date();
        var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
        var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', firstDay));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', lastDay));
        getnavigation();
    }else if(type=='yearly'){
        var date = new Date();
        var firstDay = new Date(date.getFullYear(), 0, 1);
        var lastDay = new Date(date.getFullYear(), 11 + 1, 0);

        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', firstDay));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', lastDay));
        getnavigation();
    }
}

function getnavigation(){
    $('#datatable_tb').DataTable().clear().destroy();
		$('#filterhtml').html("<div style='background-color: #fff;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/uploads/ajax_loading.gif' ></div></div>");
	   // return false;
	   //$('#filterhtml').html("<div style='background-color: #10163a;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/theme_elements/images/logo-sm.png' style='height:40px;'></div></div>");
		$.ajax({
			url:base_url+"Navigations/filter",
			dataType: "html",
			type: "POST",
			data: $('#navigationfilter').serialize(),
			success: function(res) {
			    console.log(res);
				var obj=JSON.parse(res);
				$("#filterhtml").html(obj.html);
				if(obj.count > 0){
				var table = $('#datatable_tb').DataTable({
                    "ordering": false,
                    "pageLength": 100
                });
                table.on( 'search.dt', function () {
                    // alert(table.search());
                    if (table.search() !== '') {
                        $('#pdf_purchase_report').prop('disabled', true);
                        $('.tablebottom').hide();
                    } else {
                        $('#pdf_purchase_report').prop('disabled', false);
                        $('.tablebottom').show();
                    }
                } );
				$('#print_report').removeAttr('disabled');
				$('#pdf_purchase_report').removeAttr('disabled');
				$('#advance_search').removeAttr('disabled');
				$('#navigation_report_csv').removeAttr('disabled');
				
				}else{
				    $("#print_report").attr( "disabled", "disabled" );
				    $("#pdf_purchase_report").attr( "disabled", "disabled" );
				    $("#advance_search").attr( "disabled", "disabled" );
				    $('#navigation_report_csv').attr( "disabled", "disabled" );
				}
				
				$('#reset_filters').removeAttr('disabled');
			}
		})
}

/*	$(document).on("click","#show_report",function(e) {
	    $('#datatable_tb').DataTable().clear().destroy();
		e.preventDefault();
		$('#filterhtml').html("<div style='background-color: #fff;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/uploads/ajax_loading.gif' ></div></div>");
	   // return false;
	   //$('#filterhtml').html("<div style='background-color: #10163a;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/theme_elements/images/logo-sm.png' style='height:40px;'></div></div>");
		$.ajax({
			url:base_url+"Navigations/filter",
			dataType: "html",
			type: "POST",
			data: $('#navigationfilter').serialize(),
			success: function(res) {
			    console.log(res);
				var obj=JSON.parse(res);
				$("#filterhtml").html(obj.html);
				if(obj.count > 0){
				var table = $('#datatable_tb').DataTable({
                    "ordering": false,
                    "pageLength": 100
                });
                table.on( 'search.dt', function () {
                    // alert(table.search());
                    if (table.search() !== '') {
                        $('#pdf_purchase_report').prop('disabled', true);
                        $('.tablebottom').hide();
                    } else {
                        $('#pdf_purchase_report').prop('disabled', false);
                        $('.tablebottom').show();
                    }
                } );
				$('#print_report').removeAttr('disabled');
				$('#pdf_purchase_report').removeAttr('disabled');
				$('#advance_search').removeAttr('disabled');
				$('#navigation_report_csv').removeAttr('disabled');
				
				}else{
				    $("#print_report").attr( "disabled", "disabled" );
				    $("#pdf_purchase_report").attr( "disabled", "disabled" );
				    $("#advance_search").attr( "disabled", "disabled" );
				    $('#navigation_report_csv').attr( "disabled", "disabled" );
				}
				
				$('#reset_filters').removeAttr('disabled');
			}
		})
	});*/
	
	$(document).on("click","#currentmonth",function(e){
	    $('#datatable_tb').DataTable().clear().destroy();
		e.preventDefault();
		$('#filterhtml').html("<div style='background-color: #fff;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/uploads/ajax_loading.gif' ></div></div>");
	   // return false;
	   //$('#filterhtml').html("<div style='background-color: #10163a;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/theme_elements/images/logo-sm.png' style='height:40px;'></div></div>");
		$.ajax({
			url:base_url+"Navigations/filterByCurrentMonth",
			dataType: "html",
			type: "POST",
			data: $('#navigationfilter').serialize(),
			success: function(res) {
			    console.log(res);
				var obj=JSON.parse(res);
				$("#filterhtml").html(obj.html);
				if(obj.count > 0){
				var table = $('#datatable_tb').DataTable({
                    "ordering": false,
                    "pageLength": 100
                });
                table.on( 'search.dt', function () {
                    // alert(table.search());
                    if (table.search() !== '') {
                        $('#pdf_purchase_report').prop('disabled', true);
                        $('.tablebottom').hide();
                    } else {
                        $('#pdf_purchase_report').prop('disabled', false);
                        $('.tablebottom').show();
                    }
                } );
				$('#print_report').removeAttr('disabled');
				$('#pdf_purchase_report').removeAttr('disabled');
				$('#advance_search').removeAttr('disabled');
				$('#navigation_report_csv').removeAttr('disabled');
				
				}else{
				    $("#print_report").attr( "disabled", "disabled" );
				    $("#pdf_purchase_report").attr( "disabled", "disabled" );
				    $("#advance_search").attr( "disabled", "disabled" );
				    $('#navigation_report_csv').attr( "disabled", "disabled" );
				}
				
				$('#reset_filters').removeAttr('disabled');
			}
		})
	});
	
	$(document).on("click","#currentweek",function(e){
	    $('#datatable_tb').DataTable().clear().destroy();
		e.preventDefault();
		$('#filterhtml').html("<div style='background-color: #fff;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/uploads/ajax_loading.gif' ></div></div>");
	   // return false;
	   //$('#filterhtml').html("<div style='background-color: #10163a;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/theme_elements/images/logo-sm.png' style='height:40px;'></div></div>");
		$.ajax({
			url:base_url+"Navigations/filterByCurrentWeek",
			dataType: "html",
			type: "POST",
			data: $('#navigationfilter').serialize(),
			success: function(res) {
			    console.log(res);
				var obj=JSON.parse(res);
				$("#filterhtml").html(obj.html);
				if(obj.count > 0){
				var table = $('#datatable_tb').DataTable({
                    "ordering": false,
                    "pageLength": 100
                });
                table.on( 'search.dt', function () {
                    // alert(table.search());
                    if (table.search() !== '') {
                        $('#pdf_purchase_report').prop('disabled', true);
                        $('.tablebottom').hide();
                    } else {
                        $('#pdf_purchase_report').prop('disabled', false);
                        $('.tablebottom').show();
                    }
                } );
				$('#print_report').removeAttr('disabled');
				$('#pdf_purchase_report').removeAttr('disabled');
				$('#advance_search').removeAttr('disabled');
				$('#navigation_report_csv').removeAttr('disabled');
				
				}else{
				    $("#print_report").attr( "disabled", "disabled" );
				    $("#pdf_purchase_report").attr( "disabled", "disabled" );
				    $("#advance_search").attr( "disabled", "disabled" );
				    $('#navigation_report_csv').attr( "disabled", "disabled" );
				}
				
				$('#reset_filters').removeAttr('disabled');
			}
		})
	});
	
	$(document).on("click","#currentday",function(e){
	    $('#datatable_tb').DataTable().clear().destroy();
		e.preventDefault();
		$('#filterhtml').html("<div style='background-color: #fff;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/uploads/ajax_loading.gif' ></div></div>");
	   // return false;
	   //$('#filterhtml').html("<div style='background-color: #10163a;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/theme_elements/images/logo-sm.png' style='height:40px;'></div></div>");
		$.ajax({
			url:base_url+"Navigations/filterByCurrentDay",
			dataType: "html",
			type: "POST",
			data: $('#navigationfilter').serialize(),
			success: function(res) {
			    console.log(res);
				var obj=JSON.parse(res);
				$("#filterhtml").html(obj.html);
				if(obj.count > 0){
				var table = $('#datatable_tb').DataTable({
                    "ordering": false,
                    "pageLength": 100
                });
                table.on( 'search.dt', function () {
                    // alert(table.search());
                    if (table.search() !== '') {
                        $('#pdf_purchase_report').prop('disabled', true);
                        $('.tablebottom').hide();
                    } else {
                        $('#pdf_purchase_report').prop('disabled', false);
                        $('.tablebottom').show();
                    }
                } );
				$('#print_report').removeAttr('disabled');
				$('#pdf_purchase_report').removeAttr('disabled');
				$('#advance_search').removeAttr('disabled');
				$('#navigation_report_csv').removeAttr('disabled');
				
				}else{
				    $("#print_report").attr( "disabled", "disabled" );
				    $("#pdf_purchase_report").attr( "disabled", "disabled" );
				    $("#advance_search").attr( "disabled", "disabled" );
				    $('#navigation_report_csv').attr( "disabled", "disabled" );
				}
				
				$('#reset_filters').removeAttr('disabled');
			}
		})
	});
	
	$(document).on("click","#currentyear",function(e){
	    $('#datatable_tb').DataTable().clear().destroy();
		e.preventDefault();
		$('#filterhtml').html("<div style='background-color: #fff;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/uploads/ajax_loading.gif' ></div></div>");
	   // return false;
	   //$('#filterhtml').html("<div style='background-color: #10163a;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/theme_elements/images/logo-sm.png' style='height:40px;'></div></div>");
		$.ajax({
			url:base_url+"Navigations/filterByCurrentYear",
			dataType: "html",
			type: "POST",
			data: $('#navigationfilter').serialize(),
			success: function(res) {
			    console.log(res);
				var obj=JSON.parse(res);
				$("#filterhtml").html(obj.html);
				if(obj.count > 0){
				var table = $('#datatable_tb').DataTable({
                    "ordering": false,
                    "pageLength": 100
                });
                table.on( 'search.dt', function () {
                    // alert(table.search());
                    if (table.search() !== '') {
                        $('#pdf_purchase_report').prop('disabled', true);
                        $('.tablebottom').hide();
                    } else {
                        $('#pdf_purchase_report').prop('disabled', false);
                        $('.tablebottom').show();
                    }
                } );
				$('#print_report').removeAttr('disabled');
				$('#pdf_purchase_report').removeAttr('disabled');
				$('#advance_search').removeAttr('disabled');
				$('#navigation_report_csv').removeAttr('disabled');
				
				}else{
				    $("#print_report").attr( "disabled", "disabled" );
				    $("#pdf_purchase_report").attr( "disabled", "disabled" );
				    $("#advance_search").attr( "disabled", "disabled" );
				    $('#navigation_report_csv').attr( "disabled", "disabled" );
				}
				
				$('#reset_filters').removeAttr('disabled');
			}
		})
	});
	
	function advanceSearch(){
	    $('#filterhtml').html("<div style='background-color: #fff;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/uploads/ajax_loading.gif' ></div></div>");
	   var advancesearchform =  $('#advance-search-form').serialize();
	   var navigationfilter = $('#navigationfilter').serialize();
	   var finaldata = navigationfilter + '&' + advancesearchform;
	    	$.ajax({
			url:base_url+"Navigations/filter",
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
	
// 	$(document).on("click","#reset_filters",function(e) {
// 		e.preventDefault();
// 		var dfrom_date = $("#dfrom_date").val();
// 		var dto_date = $("#dto_date").val();
// 		$("#filter").val("Voucher_Wise").change();
// // 		$("#from_date").val(dfrom_date);
// 		$("#to_date").val(dto_date);
// 		//$('#from_date').datepicker("option", "defaultDate", dfrom_date);
// 		$('#from_date').datepicker();
//         $('#from_date').datepicker('setDate', new Date());
// 	});
	
	function setreportfilter(val){
		$("#filter_type").val(val);
	}
	$(document).on("click","#print_report",function(e) {
		e.preventDefault();
		var advancesearchform =  $('#advance-search-form').serialize();
	    var navigationfilter = $('#navigationfilter').serialize();
	    var finaldata = navigationfilter + '&' + advancesearchform;
// 		var from_date = $('#from_date').val();
// 		var to_date = $('#to_date').val();			
// 		var filter = $('#filter').val();
// 		var filter_type = $('#filter_type').val();
		 
		window.open(base_url + 'navigations/print_report?'+finaldata, "Navigation Report", 'width=1210, height=842');
	});
	$(document).on("click","#pdf_purchase_report",function(e) {
		e.preventDefault();
		var advancesearchform =  $('#advance-search-form').serialize();
	    var navigationfilter = $('#navigationfilter').serialize();
	    var finaldata = navigationfilter + '&' + advancesearchform;
// 		var from_date = $('#from_date').val();
// 		var to_date = $('#to_date').val();			
// 		var filter = $('#filter').val();
// 		var filter_type = $('#filter_type').val();
// 		var url=base_url+'navigations/pdf_report?from_date='+from_date+'&to_date='+to_date+'&filter='+filter+'&filter_type='+filter_type;
		var url=base_url+'navigations/pdf_report?'+finaldata;
		window.open(url);
		
	});
	
	$(document).on("click","#advance_search",function(e) {
	    e.preventDefault();
	    $("#show_filters_tab").toggle();
	});
			
// 	key functions
	   $(document).keydown(function(e) {
        
                if (e.which == 121) {
            e.preventDefault();
                    $("#add_navigation").click();
                    $("#show_report").click();
                }
                if (e.which == 117 ){
                    e.preventDefault();
                    $("#add_navigation_another").click();
                    $("#print_report").click();
                }
                if (e.which == 118 ){
                    e.preventDefault();
                    $("#add_navigation_draft").click();
                    $("#pdf_purchase_report").click();
                    
                }
                if (e.which == 119) {
            e.preventDefault();
                    $("#update_draft_purchase").click();
                    $("#advance_search").click();
                }
                
            });
	
	
	
	