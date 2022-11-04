 var base_url=$("#base_url").val();
 var count = 2;
 "use strict";


	
// 	$(document).on("click","#print_report",function(e) {
// 		e.preventDefault();
// 		var fromDate = $('#from_date').val();
// 		var toDate = $('#to_date').val();
// 		var etype = $('#col2_filter').val();
// 		var type = $('#item_type').val();
// 		window.open(base_url + 'Stocks/print_report?form=' + fromDate + '&to=' + toDate+'&filter='+etype+'&type='+type, "Stock Report", 'width=1210, height=842');
// 	});
	
	$(document).on("click","#print_report",function(e) {
		e.preventDefault();
		var fromDate = $('#from_date').val();
		var toDate = $('#to_date').val();			
		var plant = $('#col2_filter').val();
		var item = $('#item_type').val();
		window.open(base_url + 'Stocks/print_report?frmdate=' + fromDate + '&todate=' + toDate+'&plant_for='+plant+'&item_type='+item, "Stock Report", 'width=1210, height=842');
	});
	
	$(document).on("click","#pdf_stock_report",function(e) {
		e.preventDefault();
		
		var fromDate = $('#from_date').val();
		var toDate = $('#to_date').val();			
		var plant = $('#col2_filter').val();
		var item = $('#item_type').val();
		var sitem_type = $('#sitem_type').val();
		var url=base_url+'Stocks/print_stock_report?frmdate=' + fromDate + '&todate=' + toDate+'&plant_for='+plant+'&item_type='+item+'&sitem_type='+sitem_type;;
		window.open(url);
	
	});
	// 	key functions
	   $(document).keydown(function(e) {
        
                if (e.which == 121) {
            e.preventDefault();
                    $("#show_report_stock").click();
                }
                if (e.which == 117 ){
                    e.preventDefault();
                    $("#print_report").click();
                }
                if (e.which == 118 ){
                    e.preventDefault();
                    $("#pdf_stock_report").click();
                    
                }
            });
	
	$(document).on("click","#print_report_lpg",function(e) {
		e.preventDefault();
		window.open(base_url + 'Stocks/print_report_lpg', "Stock Report", 'width=1210, height=842');
	});
	
	$(document).on("click","#pdf_stock_report_lpg",function(e) {
		e.preventDefault();
		var url=base_url+'Stocks/pdf_stock_report_lpg';
		window.open(url);
	});
	
	$(document).on("click","#print_report_lpgempty",function(e) {
		e.preventDefault();
		window.open(base_url + 'Stocks/print_report_lpgempty', "Stock Report", 'width=1210, height=842');
	});
	
	$(document).on("click","#pdf_stock_report_lpgempty",function(e) {
		e.preventDefault();
		var url=base_url+'Stocks/pdf_stock_report_lpgempty';
		window.open(url);
	
	});
	
	

	