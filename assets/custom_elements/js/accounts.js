 var base_url=$("#base_url").val();
  
$(function () {
    $('.tree li:has(ul)').addClass('parent_li').find(' > span').attr('title', 'Expand this branch');
    $('.tree li.parent_li > span').on('click', function (e) {
        var children = $(this).parent('li.parent_li').find(' > ul > li');
        if (children.is(":visible")) {
            children.hide('fast');
            $(this).attr('title', 'Expand this branch').find(' > i');
        } else {
            children.show('fast');
            $(this).attr('title', 'Collapse this branch').find(' > i');
        }
        e.stopPropagation();
    });
    var tabs = $('.child_li').parent('li.parent_li').find(' > ul > li');
    tabs.hide('fast');
});

"use strict";
function loadCoaData(id){
  var base_url = $("#base_url").val();
    $.ajax({
        url : base_url + "Accounts/selectedform/" + id,
        type: "GET",
        dataType: "json",
        success: function(data)
        {
            console.log(data);
            $('#newform').html(data);
            $('#btnSave').hide();
             if(id == 0){
                $('#btnDelete').hide();
                $('#btnSave').hide();
                $('#btnUpdate').hide();
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function enableShowButton(val){
    if(val==''){
        $('#show_report').attr("disabled","disabled");
    }else{
        $('#show_report').removeAttr('disabled');
    }
}

"use strict";
    function newHeaddata(id){
      var base_url = $("#base_url").val();
     $.ajax({
        url : base_url + "Accounts/newform/" + id,
        type: "GET",
        dataType: "json",
        success: function(data)
        {
           console.log(data.rowdata);
           var headlabel = data.headlabel;
           $('#txtHeadCode').val(data.headcode);
            document.getElementById("txtHeadName").value = '';
            
            $('#txtPHead').val(data.rowdata.head_name);
            $('#txtHeadLevel').val(headlabel);
            $('#btnSave').prop("disabled", false);
             $('#btnSave').show();
            $('#btnUpdate').hide();
            if(data.headcode != 0){
                $('#txtHeadName').prop("readonly", false);
            }else{
                $('#btnDelete').hide();
                $('#btnSave').hide();
                $('#btnUpdate').hide();
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function getSupplierFilterDataByDate(type){
    if(type=='daily'){
        var currentdate = new Date();
        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', currentdate));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', currentdate));
        getFilterData('supplier_ledger_filter');
    }else if(type=='weekly'){
        var currentdate = new Date();
        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', new Date(currentdate.setDate(currentdate.getDate() - currentdate.getDay()))));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', new Date(currentdate.setDate(currentdate.getDate() - currentdate.getDay()+6))));
        getFilterData('supplier_ledger_filter');
    }else if(type=='monthly'){
        var date = new Date();
        var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
        var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', firstDay));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', lastDay));
        getFilterData('supplier_ledger_filter');
    }else if(type=='yearly'){
        var date = new Date();
        var firstDay = new Date(date.getFullYear(), 0, 1);
        var lastDay = new Date(date.getFullYear(), 11 + 1, 0);

        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', firstDay));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', lastDay));
        getFilterData('supplier_ledger_filter');
    }
}

function getCustomerFilterDataByDate(type){
    if(type=='daily'){
        var currentdate = new Date();
        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', currentdate));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', currentdate));
        getFilterData('customer_ledger_filter');
    }else if(type=='weekly'){
        var currentdate = new Date();
        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', new Date(currentdate.setDate(currentdate.getDate() - currentdate.getDay()))));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', new Date(currentdate.setDate(currentdate.getDate() - currentdate.getDay()+6))));
        getFilterData('customer_ledger_filter');
    }else if(type=='monthly'){
        var date = new Date();
        var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
        var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', firstDay));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', lastDay));
        getFilterData('customer_ledger_filter');
    }else if(type=='yearly'){
        var date = new Date();
        var firstDay = new Date(date.getFullYear(), 0, 1);
        var lastDay = new Date(date.getFullYear(), 11 + 1, 0);

        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', firstDay));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', lastDay));
        getFilterData('customer_ledger_filter');
    }
}

function getAccountLedgerFilterDataByDate(type){
    if(type=='daily'){
        var currentdate = new Date();
        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', currentdate));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', currentdate));
        getFilterData('accounts_ledger_filter');
    }else if(type=='weekly'){
        var currentdate = new Date();
        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', new Date(currentdate.setDate(currentdate.getDate() - currentdate.getDay()))));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', new Date(currentdate.setDate(currentdate.getDate() - currentdate.getDay()+6))));
        getFilterData('accounts_ledger_filter');
    }else if(type=='monthly'){
        var date = new Date();
        var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
        var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', firstDay));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', lastDay));
        getFilterData('accounts_ledger_filter');
    }else if(type=='yearly'){
        var date = new Date();
        var firstDay = new Date(date.getFullYear(), 0, 1);
        var lastDay = new Date(date.getFullYear(), 11 + 1, 0);

        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', firstDay));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', lastDay));
        getFilterData('accounts_ledger_filter');
    }
}

function getFilterData(api){
    console.log(base_url+"Accounts/"+api);
    $('#datatable_tb').DataTable().clear().destroy();
    $('#filterhtml').html("<div style='background-color: #FFF;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/uploads/ajax_loading.gif' ></div></div>");
	   $.ajax({
			url:base_url+"Accounts/"+api,
			dataType: "html",
			type: "POST",
			data: $('#ledgerFilter').serialize(),
			success: function(res) {
			    console.log(res);
				var obj=JSON.parse(res);
				$("#filterhtml").html(obj.html);
				// $("#searchtxtdiv").show();
				$('#datatable_tb').DataTable({
                    "ordering": false,
                    "pageLength": 100
                });
				if(obj.count > 0){
				    
				
				$('#print_report').removeAttr('disabled');
				$('#pdf_purchase_report').removeAttr('disabled');
				$('#item_ledger_csv').removeAttr('disabled');
				
				
				}else{
				    $("#print_report").attr( "disabled", "disabled" );
				    $("#pdf_purchase_report").attr( "disabled", "disabled" );
				    $("#item_ledger_csv").attr( "disabled", "disabled" );
				    
				   
				}
				$('#reset_filters').removeAttr('disabled');
			}
		})
}


function bsload(){
    $('#filterhtml_1').html("<div class='row' style='width:100%;'><img src='"+base_url+"assets/uploads/ajax_loading.gif' style='margin:auto;'></div>");
}

function getIncomeByDate(type){
    if(type=='daily'){
        var currentdate = new Date();
        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', currentdate));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', currentdate));
        getIncomeReport();
    }else if(type=='weekly'){
        var currentdate = new Date();
        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', new Date(currentdate.setDate(currentdate.getDate() - currentdate.getDay()))));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', new Date(currentdate.setDate(currentdate.getDate() - currentdate.getDay()+6))));
        getIncomeReport();
    }else if(type=='monthly'){
        var date = new Date();
        var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
        var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', firstDay));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', lastDay));
        getIncomeReport();
    }else if(type=='yearly'){
        var date = new Date();
       var firstDay = new Date(date.getFullYear(), 0, 1);
        var lastDay = new Date(date.getFullYear(), 11 + 1, 0);

        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', firstDay));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', lastDay));
        getIncomeReport();
    }
}

function getIncomeReport(){
    $('#filterhtml').html("<div style='background-color: #FFF;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/uploads/ajax_loading.gif' ></div></div>");
	   $.ajax({
			url:base_url+"Accounts/getIncomeReport",
			dataType: "html",
			type: "POST",
			data: $('#ledgerFilter').serialize(),
			success: function(res) {
			    console.log(res);
				var obj=JSON.parse(res);
				$("#filterhtml").html(obj.html);
			
				
				$('#print_report').removeAttr('disabled');
				$('#pdf_purchase_report').removeAttr('disabled');
				$('#incomereport_csv').removeAttr('disabled');
				$('#reset_filters').removeAttr('disabled');
			}
		})
}



function getCashFlowByDate(type){
    if(type=='daily'){
        var currentdate = new Date();
        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', currentdate));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', currentdate));
        getCashFlowReport();
    }else if(type=='weekly'){
        var currentdate = new Date();
        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', new Date(currentdate.setDate(currentdate.getDate() - currentdate.getDay()))));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', new Date(currentdate.setDate(currentdate.getDate() - currentdate.getDay()+6))));
        getCashFlowReport();
    }else if(type=='monthly'){
        var date = new Date();
        var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
        var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', firstDay));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', lastDay));
        getCashFlowReport();
    }else if(type=='yearly'){
        var date = new Date();
        var firstDay = new Date(date.getFullYear(), 0, 1);
        var lastDay = new Date(date.getFullYear(), 11 + 1, 0);

        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', firstDay));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', lastDay));
        getCashFlowReport();
    }
}

function getCashFlowReport(){
    $('#datatable_tb').DataTable().clear().destroy();
    $('#filterhtml').html("<div style='background-color: #FFF;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/uploads/ajax_loading.gif' ></div></div>");
	   $.ajax({
			url:base_url+"Accounts/cashflow_filter",
			dataType: "html",
			type: "POST",
			data: $('#ledgerFilter').serialize(),
			success: function(res) {
			    console.log(res);
				var obj=JSON.parse(res);
				$("#filterhtml").html(obj.html);
			    var table = $('#datatable_tb').DataTable({
                    "ordering": false,
                    "pageLength": 100
                });
                table.on( 'search.dt', function () {
                    // alert(table.search());
                    if (table.search() != '') {
				$('#pdf_purchase_report').prop('disabled', true);
				$('#cashflow_csv').prop('disabled', true);
                    } else {
				    $("#pdf_purchase_report").prop('disabled', false);
				    $("#cashflow_csv").prop('disabled', false);
                    }
                } );
                
				if(obj.count > 0){
				$('#print_report').removeAttr('disabled');
				$('#pdf_purchase_report').removeAttr('disabled');
				$('#cashflow_csv').removeAttr('disabled');
				}
				else{
				    $("#print_report").attr( "disabled", "disabled" );
				    $("#pdf_purchase_report").attr( "disabled", "disabled" );
				    $("#cashflow_csv").attr( "disabled", "disabled" );
				}
				
			
				$('#reset_filters').removeAttr('disabled');
			}
		})
}

function getCashFlowReportByDay(){
    $('#datatable_tb').DataTable().clear().destroy();
    $('#filterhtml').html("<div style='background-color: #FFF;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/uploads/ajax_loading.gif' ></div></div>");
	   $.ajax({
			url:base_url+"Accounts/cashflow_filterByDay",
			dataType: "html",
			type: "POST",
			data: $('#ledgerFilter').serialize(),
			success: function(res) {
			    console.log(res);
				var obj=JSON.parse(res);
				$("#filterhtml").html(obj.html);
			    var table = $('#datatable_tb').DataTable({
                    "ordering": false,
                    "pageLength": 100
                });
                table.on( 'search.dt', function () {
                    // alert(table.search());
                    if (table.search() != '') {
				$('#pdf_purchase_report').prop('disabled', true);
				$('#cashflow_csv').prop('disabled', true);
                    } else {
				    $("#pdf_purchase_report").prop('disabled', false);
				    $("#cashflow_csv").prop('disabled', false);
                    }
                } );
                
				if(obj.count > 0){
				$('#print_report').removeAttr('disabled');
				$('#pdf_purchase_report').removeAttr('disabled');
				$('#cashflow_csv').removeAttr('disabled');
				}
				else{
				    $("#print_report").attr( "disabled", "disabled" );
				    $("#pdf_purchase_report").attr( "disabled", "disabled" );
				    $("#cashflow_csv").attr( "disabled", "disabled" );
				}
				
			
				$('#reset_filters').removeAttr('disabled');
			}
		})
}

function getCashFlowReportByWeek(){
    $('#datatable_tb').DataTable().clear().destroy();
    $('#filterhtml').html("<div style='background-color: #FFF;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/uploads/ajax_loading.gif' ></div></div>");
	   $.ajax({
			url:base_url+"Accounts/cashflow_filterByWeek",
			dataType: "html",
			type: "POST",
			data: $('#ledgerFilter').serialize(),
			success: function(res) {
			    console.log(res);
				var obj=JSON.parse(res);
				$("#filterhtml").html(obj.html);
			    var table = $('#datatable_tb').DataTable({
                    "ordering": false,
                    "pageLength": 100
                });
                table.on( 'search.dt', function () {
                    // alert(table.search());
                    if (table.search() != '') {
				$('#pdf_purchase_report').prop('disabled', true);
				$('#cashflow_csv').prop('disabled', true);
                    } else {
				    $("#pdf_purchase_report").prop('disabled', false);
				    $("#cashflow_csv").prop('disabled', false);
                    }
                } );
                
				if(obj.count > 0){
				$('#print_report').removeAttr('disabled');
				$('#pdf_purchase_report').removeAttr('disabled');
				$('#cashflow_csv').removeAttr('disabled');
				}
				else{
				    $("#print_report").attr( "disabled", "disabled" );
				    $("#pdf_purchase_report").attr( "disabled", "disabled" );
				    $("#cashflow_csv").attr( "disabled", "disabled" );
				}
				
			
				$('#reset_filters').removeAttr('disabled');
			}
		})
}

function getCashFlowReportByMonth(){
    $('#datatable_tb').DataTable().clear().destroy();
    $('#filterhtml').html("<div style='background-color: #FFF;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/uploads/ajax_loading.gif' ></div></div>");
	   $.ajax({
			url:base_url+"Accounts/cashflow_filterByMonth",
			dataType: "html",
			type: "POST",
			data: $('#ledgerFilter').serialize(),
			success: function(res) {
			    console.log(res);
				var obj=JSON.parse(res);
				$("#filterhtml").html(obj.html);
			    var table = $('#datatable_tb').DataTable({
                    "ordering": false,
                    "pageLength": 100
                });
                table.on( 'search.dt', function () {
                    // alert(table.search());
                    if (table.search() != '') {
				$('#pdf_purchase_report').prop('disabled', true);
				$('#cashflow_csv').prop('disabled', true);
                    } else {
				    $("#pdf_purchase_report").prop('disabled', false);
				    $("#cashflow_csv").prop('disabled', false);
                    }
                } );
                
				if(obj.count > 0){
				$('#print_report').removeAttr('disabled');
				$('#pdf_purchase_report').removeAttr('disabled');
				$('#cashflow_csv').removeAttr('disabled');
				}
				else{
				    $("#print_report").attr( "disabled", "disabled" );
				    $("#pdf_purchase_report").attr( "disabled", "disabled" );
				    $("#cashflow_csv").attr( "disabled", "disabled" );
				}
				
			
				$('#reset_filters').removeAttr('disabled');
			}
		})
}

function getCashFlowReportByYear(){
    $('#datatable_tb').DataTable().clear().destroy();
    $('#filterhtml').html("<div style='background-color: #FFF;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/uploads/ajax_loading.gif' ></div></div>");
	   $.ajax({
			url:base_url+"Accounts/cashflow_filterByYear",
			dataType: "html",
			type: "POST",
			data: $('#ledgerFilter').serialize(),
			success: function(res) {
			    console.log(res);
				var obj=JSON.parse(res);
				$("#filterhtml").html(obj.html);
			    var table = $('#datatable_tb').DataTable({
                    "ordering": false,
                    "pageLength": 100
                });
                table.on( 'search.dt', function () {
                    // alert(table.search());
                    if (table.search() != '') {
				$('#pdf_purchase_report').prop('disabled', true);
				$('#cashflow_csv').prop('disabled', true);
                    } else {
				    $("#pdf_purchase_report").prop('disabled', false);
				    $("#cashflow_csv").prop('disabled', false);
                    }
                } );
                
				if(obj.count > 0){
				$('#print_report').removeAttr('disabled');
				$('#pdf_purchase_report').removeAttr('disabled');
				$('#cashflow_csv').removeAttr('disabled');
				}
				else{
				    $("#print_report").attr( "disabled", "disabled" );
				    $("#pdf_purchase_report").attr( "disabled", "disabled" );
				    $("#cashflow_csv").attr( "disabled", "disabled" );
				}
				
			
				$('#reset_filters').removeAttr('disabled');
			}
		})
}

function printPdfCashFlowReport(val){
    var form = $('#ledgerFilter').serialize();
    if(val==1){
        
		 
	    window.open(base_url + 'Accounts/print_cash_flow_report?'+form, "Cash Flow Report", 'width=1210, height=842');
    }else{
        window.open(base_url + 'Accounts/pdf_cash_flow_report?'+form);
    }
}
function printPdfIncomeReport(val){
    var form = $('#ledgerFilter').serialize();
    if(val==1){
        
		 
	    window.open(base_url + 'Accounts/print_income_report?'+form, "Income Report", 'width=1210, height=842');
    }else{
        window.open(base_url + 'Accounts/pdf_income_report?'+form);
    }
}
function printPdfItemIncomeReport(val){
    var form = $('#ledgerFilter').serialize();
    if(val==1){
        
		 
	    window.open(base_url + 'Accounts/print_item_income_report?'+form, "Item Income Report", 'width=1210, height=842');
    }else{
        window.open(base_url + 'Accounts/pdf_item_income_report?'+form);
    }
}

function getTrailBalanceByDate(type){
    if(type=='daily'){
        var currentdate = new Date();
        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', currentdate));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', currentdate));
        getTrailBalance(1);
    }else if(type=='weekly'){
        var currentdate = new Date();
        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', new Date(currentdate.setDate(currentdate.getDate() - currentdate.getDay()))));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', new Date(currentdate.setDate(currentdate.getDate() - currentdate.getDay()+6))));
        getTrailBalance(1);
    }else if(type=='monthly'){
        var date = new Date();
        var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
        var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', firstDay));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', lastDay));
        getTrailBalance(1);
    }else if(type=='yearly'){
        var date = new Date();
        var firstDay = new Date(date.getFullYear(), 0, 1);
        var lastDay = new Date(date.getFullYear(), 11 + 1, 0);

        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', firstDay));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', lastDay));
        getTrailBalance(1);
    }
}

function getTrailBalance(level){
    $("#level").val(level);
    $('#datatable_tb').DataTable().clear().destroy();
    $('#filterhtml').html("<div style='background-color: #FFF;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/uploads/ajax_loading.gif' ></div></div>");
	   $.ajax({
			url:base_url+"Accounts/getTrailBalance",
			dataType: "html",
			type: "POST",
			data: $('#ledgerFilter').serialize(),
			success: function(res) {
			    console.log(res);
				var obj=JSON.parse(res);
				$("#filterhtml").html(obj.html);
			    $('#datatable_tb').DataTable({
                    "ordering": false,
                    "pageLength": 100
                });
				
				$('#print_report').removeAttr('disabled');
				$('#pdf_purchase_report').removeAttr('disabled');
				$("#zero").css("display","block")
			
				$('#reset_filters').removeAttr('disabled');
				$('#trailbalance_csv').removeAttr('disabled');
			}
		})
}


function printPdfTrailBalance(val){
    var form = $('#ledgerFilter').serialize();
    if(val==1){
        
		 
	    window.open(base_url + 'Accounts/trailbalance_print?'+form, "Trial Balance Report", 'width=1210, height=842');
    }else{
        window.open(base_url + 'Accounts/trailbalance_pdf?'+form);
    }
}
function printPdfBalanceSheet(val){
    var year = $('#year').val();
    if(val==1){
        
		 
	    window.open(base_url + 'Accounts/print_balancesheet_report?year='+year, "Income Report", 'width=1210, height=842');
    }else{
        window.open(base_url + 'Accounts/pdf_balancesheet_report?year='+year);
    }
}

function print_ledger(api){
   	var form = $('#ledgerFilter').serialize();
		 
	window.open(base_url + 'Accounts/'+api+'?'+form, "Ledger Report", 'width=1210, height=842');
}
function pdf_ledger(api){
   	var form = $('#ledgerFilter').serialize();
		 
	window.open(base_url + 'Accounts/'+api+'?'+form);
}



 function searchAndHighlight(searchTerm, selector) {
            
            if (searchTerm) {               
                var selector = selector || ".jstree"; //use body as selector if none provided
                var searchTermRegEx = new RegExp(searchTerm, "ig");
                var matches = $(selector).text().match(searchTermRegEx);
                if (matches != null && matches.length > 0) {
                   
                    $('.highlighted').removeClass('highlighted'); //Remove old search highlights 
 
                    //Remove the previous matches
                    $span = $('.jstree span');
                    $span.replaceWith($span.html());
 
                    // if (searchTerm === "&") {
                        // searchTerm = "&amp;";
                        // searchTermRegEx = new RegExp(searchTerm, "ig");
                    // }
                    $(selector).html($(selector).html().replace(searchTermRegEx, "<span class='match'>" + searchTerm + "</span>"));
                    $('.match').addClass('highlighted');
 
                  
                    return true;
                }
            }
            return false;
        }
 
        $(document).on('click', '.searchButtonClickText_h', function (event) {
 
            $(".highlighted").removeClass("highlighted").removeClass("match");
            if (!searchAndHighlight($('.textSearchvalue_h').val())) {
                alert("No results found");
            }
 
 
        });
        
        $(document).on("click","#advance_search",function(e) {
	    e.preventDefault();
	    $("#show_filters_tab").toggle();
    	});
    function printProfitandlossReport(val){
        var form = $('#profitandlossFilter').serialize();
        if(val==1){
            
    		 
    	    window.open(base_url + 'Accounts/print_profitandloss_report?'+form, "Profit and Loss Report", 'width=1210, height=842');
        }else{
            window.open(base_url + 'Accounts/profitandloss_pdf_report?'+form);
        }
    }
    function printPdfIncomeReport(val){
    var form = $('#ledgerFilter').serialize();
    if(val==1){
        
		 
	    window.open(base_url + 'Accounts/print_income_report?'+form, "Income Report", 'width=1210, height=842');
    }else{
        window.open(base_url + 'Accounts/pdf_income_report?'+form);
    }
}

function getProfitandlossByDate(type){
    if(type=='daily'){
        var currentdate = new Date();
        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', currentdate));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', currentdate));
        getProfitandlossReport();
    }else if(type=='weekly'){
        var currentdate = new Date();
        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', new Date(currentdate.setDate(currentdate.getDate() - currentdate.getDay()))));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', new Date(currentdate.setDate(currentdate.getDate() - currentdate.getDay()+6))));
        getProfitandlossReport();
    }else if(type=='monthly'){
        var date = new Date();
        var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
        var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', firstDay));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', lastDay));
        getProfitandlossReport();
    }else if(type=='yearly'){
        var date = new Date();
        var firstDay = new Date(date.getFullYear(), 0, 1);
        var lastDay = new Date(date.getFullYear(), 11 + 1, 0);

        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', firstDay));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', lastDay));
        getProfitandlossReport();
    }
}

function getProfitandlossReport(){
	    $('#datatable_tb').DataTable().clear().destroy();
		$('#filterhtml').html("<div style='background-color: #fff;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/uploads/ajax_loading.gif' ></div></div>");
		$.ajax({
			url:base_url+"Accounts/profitandlossfilter",
			dataType: "html",
			type: "POST",
			data: $('#profitandlossFilter').serialize(),
			success: function(res) {
				var obj=JSON.parse(res);
				$("#filterhtml").html(obj.html);
				$('#datatable_tb').DataTable({
                    "ordering": false,
                    "pageLength": 100
                });
				if(obj.count > 0){
				$('#print_report').removeAttr('disabled');
				$('#pdf_purchase_report').removeAttr('disabled');
				$('#advance_search').removeAttr('disabled');
				$('#profitandloss_csv').removeAttr('disabled');
				
				}else{
				    $("#print_report").attr( "disabled", "disabled" );
				    $("#pdf_purchase_report").attr( "disabled", "disabled" );
				    $("#advance_search").attr( "disabled", "disabled" );
				    $("#profitandloss_csv").attr( "disabled", "disabled" );
				}
				$('#reset_filters').removeAttr('disabled');
			}
		})
}

