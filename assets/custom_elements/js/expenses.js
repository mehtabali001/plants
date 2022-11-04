 var base_url=$("#base_url").val();
 
  $(document).ready(function(){
    $('.exampleModal').on('click', function(){
      var postID = $(this).attr('data-content');
      var datauri = $(this).attr('data-uri');
      //console.log(postID);
      $("#modal-form").attr('action', datauri);
      $('#expense_id').val(postID);
    });
     $('.exampleModal2').on('click', function(){
      var postID = $(this).attr('data-content');
      var datauri = $(this).attr('data-uri');
      //console.log(postID);
      $("#modal-formundo").attr('action', datauri);
      $('#expense_id').val(postID);
    });
});

// 	key functions
	   $(document).keydown(function(e) {
        
                if (e.which == 121) {
                    e.preventDefault();
                    $("#add_expense").click();
                    $("#show_report").click();
                }
                if (e.which == 117 ){
                    e.preventDefault();
                    $("#add-expense-another").click();
                    $("#update_expense_draft").click();
                    $("#print_report").click();
                }
                if (e.which == 118 ){
                    e.preventDefault();
                    $("#add_expense_draft").click();
                    $("#pdf_expense_report").click();
                    
                }
                if (e.which == 119) {
            e.preventDefault();
                    $("#advance_search").click();
                }
                
            });
var count = $("#countRows").val();
var limits = 500;
"use strict";      
function addExpenseOrderField1(divName){
// 		var category=true;
// 		$(".fld_product_id").each(function() {
// 		console.log('value'+'===='+this.value);
// 		if( this.value == ""){
// 			category =false;
// 		}
//      });

	// if(category == true){
		var types=$("#typeSelect").html();
		var stationary=$("#stationarySelect").html();
		var units=$("#unitsSelect").html();
		var paymenttpe=$("#paymenttypeSelect").html();
        if (count == limits)  {
            alert("You have reached the limit of adding " + count + " inputs");
        }
        else{
            var newdiv = document.createElement('tr');
            var tabin="fld_expense_id_"+count;
            tabindex = count * 4,
            newdiv = document.createElement("tr");
            tab1 = tabindex + 1;
            tab2 = tabindex + 2;
            tab3 = tabindex + 3;
            tab4 = tabindex + 4;
            tab5 = tabindex + 5;
            tab6 = tab5 + 1;
            tab7 = tab6 +1;

        newdiv.innerHTML ='<td class="span3"><div class="row"><div class="col-sm-12"><div><select class="select2 form-control mb-3 custom-select expense_type" id="expense_type_'+count+'" tabindex="'+tab1+'" name="expense_type[]" onchange="expense_type('+count+');" required="required">'+types+'</select></div></div></div></td><td class="span3 supplier"><div class="row"><div class="col-sm-8"><div id="item_div_'+count+'"><select class="select2 form-control mb-3 custom-select" name="fld_expense_id[]" id="fld_expense_id_'+ count +'" onchange="filled_units('+count+'); disablebyunitsbtn();" tabindex="'+tab3+'"><option value="">Select Item</option>'+stationary+'</select></div></div><div class="col-lg-1 addnewstationary"><a class="btn btn-success toggle" onclick="openAddForm('+count+')"  ><i class="fa fa-plus"></i></a></div></div></td><td class="span3"><input type="number" name="quantity[]" tabindex="'+tab4+'" required  id="quantity_'+ count +'" class="form-control text-right store_cal_' + count + '" onkeyup="calculate_store(' + count + ');" onchange="calculate_store(' + count + ');" oninput="this.value = Math.abs(this.value)" placeholder="0.00" value="" min="0"/></td>  <td class="wt"> <input type="text" name="unit[]" id="unit_'+ count +'" class="form-control text-center unit_input" placeholder="Unit Code" readonly tabindex="'+tab5+'"></td><td class="test"><input type="text" name="remarks[]" id="remarks_'+ count +'" class="form-control remarks_'+ count +' text-right" placeholder="Remarks" value="" tabindex="'+tab6+'"/></td><td class=""test><input type="number" name="unit_price[]" onkeyup="calculate_store('+ count +');" onchange="calculate_store('+ count +');" oninput="this.value = Math.abs(this.value)" id="unit_price_'+ count +'" class="form-control unit_price text-right" placeholder="0.00" value="" min="0" tabindex="'+tab7+'"/></td><td><button style="text-align: right;" class="btn btn-danger red" type="button"  onclick="deleteRow(this)" tabindex="8"><i class="fas fa-times"></i></button></td>';
            document.getElementById(divName).appendChild(newdiv);
            document.getElementById(tabin).focus();
            count++;
            $("select.form-control:not(.dont-select-me)").select2();
            disablebyunitsbtn();
        }
		//}else{
		//	alert('Please select stationary !');
		//}
    }
	function deleteRow(e) {
        var t = $("#expenseTable > tbody > tr").length;
        if (1 == t) alert("There only one row you can't delete.");
        else {
            var a = e.parentNode.parentNode;
            a.parentNode.removeChild(a)
        }
        calculateSum();
        disablebyunitsbtn();
        //check_sub_product();
    } 
    
    
    
    //Calculate Sum
    "use strict";
function calculateSum() {
      var t = 0;
         
    //Total Price
    $(".unit_price").each(function () {
        isNaN(this.value) || 0 == this.value.length || (t += parseFloat(this.value))
    }),   
    e = t.toFixed(2, 2);

    var test = +e;
    $("#fld_grand_total_amount").val(test.toFixed(2, 2));

    var gt = $("#fld_grand_total_amount").val();
    var grnt_totals = gt;
    $("#fld_grand_total_amount").val(grnt_totals);
    
    var balanceAvailable = $("#balanceInput").val();
    
    if(parseFloat((balanceAvailable.replace(/,/g, ''))) < grnt_totals){
        buttons_function(0);
    }else{
         buttons_function(1);
    }
    
    
}
 //Calculate store product
        "use strict";
    function calculate_store(sl) {
       
        var gr_tot = 0;
        var qty    = $("#quantity_"+sl).val();
        var unit_price = $("#unit_price_"+sl).val();

        //var sub_total     = qty * unit_price;
        //$("#unit_price_"+sl).val(sub_total.toFixed(2));

        //Total Price
        $(".unit_price").each(function() {
            isNaN(this.value) || 0 == this.value.length || (gr_tot += parseFloat(this.value))
        });

        //$("#Total").val(gr_tot.toFixed(2,2));
        var grandtotal = gr_tot;
        $("#fld_grand_total_amount").val(grandtotal.toFixed(2,2));
        
        var balanceAvailable = $("#balanceInput").val();
    
        if(parseFloat((balanceAvailable.replace(/,/g, ''))) < grandtotal){
            buttons_function(0);
        }else{
             buttons_function(1);
        }
    }
    
    function calculate_store_with_qty(sl) {
       
        var gr_tot = 0;
        var old_qty    = $("#old_quantity_"+sl).val();
        var item_ctn_qty    = $("#quantity_"+sl).val();
        var unit_price = $("#unit_price_"+sl).val();
        
        // if(parseFloat(item_ctn_qty) > old_qty){
        //     $("#add_purchase").attr("disabled", "disabled");
        //     alert("Qty cannot be greater then old qty."+item_ctn_qty+" "+old_qty);
        // }else{
        //     $("#add_purchase").removeAttr("disabled");
        // }

        //var sub_total     = item_ctn_qty * unit_price;
        //$("#sub_total_"+sl).val(sub_total.toFixed(2));

        //Total Price
        $(".unit_price").each(function() {
            isNaN(this.value) || 0 == this.value.length || (gr_tot += parseFloat(this.value))
        });

        //$("#Total").val(gr_tot.toFixed(2,2));
        var grandtotal = gr_tot;
        $("#fld_grand_total_amount").val(grandtotal.toFixed(2,2));
    }


        window.onload = function() {
              $("#itemtarget").hide();
              $("#itemtarget2").hide();
        };
        
       function openAddForm(row_id){
           $("#row_select_id").val(row_id);
            $('#itemtarget').toggle();
            $('#itemtarget2').toggle();
        }
        
    function filled_units(sl){
		var unit = $("#fld_expense_id_"+sl).find(':selected').attr('data-unit');
		$("#unit_"+sl).val(unit);
    }
        function submitExpenseItem(){
            var new_item 	= 	 $("#new_item").val();
            var fld_unit 	= 	 $("#fld_unit").val();
            
            if(new_item == " ")
            {
                return false;
            }
            if(fld_unit == " ")
            {
                return false;
            }
		
	        $("#expense_item").prop("disabled", true);
	        var row_id = $("#row_select_id").val();
	        
		
            jQuery.ajax({
                url: base_url+"Expenses/add_item",
                type: "POST",
                data: "new_item="+new_item+"&fld_unit="+fld_unit+"&row_id="+row_id,
                success : function(return_data){
                        $("#expense_item").prop("disabled", false);
                        
                        if(return_data == "required_item_name"){
                            alert("Please Enter Item Name and Unit.");
                        }else if(return_data == "required_unit"){
                            alert("Unit field required.");
                        }else if(return_data == "item_already_found"){
                            alert("Item Name Already Exist.");
                            //$('#bank_div').html('<div class="alert alert-danger fade in alert-dismissible show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" style="font-size:20px">×</span></button>Bank Name Already Exist.</div>');
                        }else{
                             $('#item_div_'+row_id).html(return_data);
                             $("#fld_expense_id_"+row_id).select2();
                             var unit = $("#fld_expense_id_"+row_id).find(':selected').attr('data-unit');
		                $("#unit_"+row_id).val(unit);
                             $('#new_item_btn').html('<button class="btn btn-primary pull-left" type="button" onClick="submitExpenseItem();" > ADD </button>');
                        }
                        
                        $('button.btn').click(function() {
                            $("#save_or_draft").val($(this).val());	
                        });
                    }
            });
            $("#itemtarget").hide();
            $("#itemtarget2").hide();
            $('#new_item').val("");
            $("#fld_unit").val("");
        }
        
    function getExpensesFilterDataByDate(type){
    if(type=='daily'){
        var currentdate = new Date();
        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', currentdate));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', currentdate));
        getExpenses();
    }else if(type=='weekly'){
        var currentdate = new Date();
        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', new Date(currentdate.setDate(currentdate.getDate() - currentdate.getDay()))));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', new Date(currentdate.setDate(currentdate.getDate() - currentdate.getDay()+6))));
        getExpenses();
    }else if(type=='monthly'){
        var date = new Date();
        var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
        var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', firstDay));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', lastDay));
        getExpenses();
    }else if(type=='yearly'){
        var date = new Date();
        var firstDay = new Date(date.getFullYear(), 0, 1);
        var lastDay = new Date(date.getFullYear(), 11 + 1, 0);

        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', firstDay));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', lastDay));
        getExpenses();
    }
}    
        
    function getExpenses(){
        	$('#filterhtml').html("<div style='background-color: #FFF;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/uploads/ajax_loading.gif' ></div></div>");
	   // return false;
	   //$('#filterhtml').html("<div style='background-color: #10163a;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/theme_elements/images/logo-sm.png' style='height:40px;'></div></div>");
		$.ajax({
			url:base_url+"Expenses/filter",
			dataType: "html",
			type: "POST",
			data: $('#expensefilter').serialize(),
			success: function(res) {
			    console.log(res);
				var obj=JSON.parse(res);
				$("#filterhtml").html(obj.html);
				$('#datatable_tb').DataTable({
					"order": [],
					"lengthMenu": [[50, 100, 500, -1], [50, 100, 500, "All"]]
				});
				if(obj.count > 0){
				// $('#datatable').DataTable({
				// 	"order": [],
				// 	"lengthMenu": [[50, 100, 500, -1], [50, 100, 500, "All"]]
				// });
				$('#print_report').removeAttr('disabled');
				$('#pdf_expense_report').removeAttr('disabled');
				$('#advance_search').removeAttr('disabled');
				
				}else{
				    $("#print_report").attr( "disabled", "disabled" );
				    $("#pdf_expense_report").attr( "disabled", "disabled" );
				    $("#advance_search").attr( "disabled", "disabled" );
				}
				$('#reset_filters').removeAttr('disabled');
			}
		})
    }    
        

        
       /* $(document).on("click","#show_report",function(e) {
// 		e.preventDefault();
		$('#filterhtml').html("<div style='background-color: #FFF;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/uploads/ajax_loading.gif' ></div></div>");
	    $.ajax({
			url:base_url+"Expenses/filter",
			dataType: "html",
			type: "POST",
			data: $('#expensefilter').serialize(),
			success: function(res) {
			    console.log(res);
				var obj=JSON.parse(res);
				$("#filterhtml").html(obj.html);
				$('#datatable_tb').DataTable({
					"order": [],
					"lengthMenu": [[50, 100, 500, -1], [50, 100, 500, "All"]]
				});
				if(obj.count > 0){
				$('#print_report').removeAttr('disabled');
				$('#pdf_expense_report').removeAttr('disabled');
				$('#advance_search').removeAttr('disabled');
				}else{
				    $("#print_report").attr( "disabled", "disabled" );
				    $("#pdf_expense_report").attr( "disabled", "disabled" );
				    $("#advance_search").attr( "disabled", "disabled" );
				}
				$('#reset_filters').removeAttr('disabled');
			}
		})
	});*/
	
	$(document).on("click","#currentday",function(e) {
// 		e.preventDefault();
		$('#filterhtml').html("<div style='background-color: #FFF;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/uploads/ajax_loading.gif' ></div></div>");
	   // return false;
	   //$('#filterhtml').html("<div style='background-color: #10163a;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/theme_elements/images/logo-sm.png' style='height:40px;'></div></div>");
		$.ajax({
			url:base_url+"Expenses/filterByCurrentDay",
			dataType: "html",
			type: "POST",
			data: $('#expensefilter').serialize(),
			success: function(res) {
			    console.log(res);
				var obj=JSON.parse(res);
				$("#filterhtml").html(obj.html);
				$('#datatable_tb').DataTable({
					"order": [],
					"lengthMenu": [[50, 100, 500, -1], [50, 100, 500, "All"]]
				});
				if(obj.count > 0){
				// $('#datatable').DataTable({
				// 	"order": [],
				// 	"lengthMenu": [[50, 100, 500, -1], [50, 100, 500, "All"]]
				// });
				$('#print_report').removeAttr('disabled');
				$('#pdf_expense_report').removeAttr('disabled');
				$('#advance_search').removeAttr('disabled');
				
				}else{
				    $("#print_report").attr( "disabled", "disabled" );
				    $("#pdf_expense_report").attr( "disabled", "disabled" );
				    $("#advance_search").attr( "disabled", "disabled" );
				}
				$('#reset_filters').removeAttr('disabled');
			}
		})
	});
	
	
	
	$(document).on("click","#currentweek",function(e) {
// 		e.preventDefault();
		$('#filterhtml').html("<div style='background-color: #FFF;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/uploads/ajax_loading.gif' ></div></div>");
	   // return false;
	   //$('#filterhtml').html("<div style='background-color: #10163a;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/theme_elements/images/logo-sm.png' style='height:40px;'></div></div>");
		$.ajax({
			url:base_url+"Expenses/filterByCurrentWeek",
			dataType: "html",
			type: "POST",
			data: $('#expensefilter').serialize(),
			success: function(res) {
			    console.log(res);
				var obj=JSON.parse(res);
				$("#filterhtml").html(obj.html);
				$('#datatable_tb').DataTable({
					"order": [],
					"lengthMenu": [[50, 100, 500, -1], [50, 100, 500, "All"]]
				});
				if(obj.count > 0){
				// $('#datatable').DataTable({
				// 	"order": [],
				// 	"lengthMenu": [[50, 100, 500, -1], [50, 100, 500, "All"]]
				// });
				$('#print_report').removeAttr('disabled');
				$('#pdf_expense_report').removeAttr('disabled');
				$('#advance_search').removeAttr('disabled');
				
				}else{
				    $("#print_report").attr( "disabled", "disabled" );
				    $("#pdf_expense_report").attr( "disabled", "disabled" );
				    $("#advance_search").attr( "disabled", "disabled" );
				}
				$('#reset_filters').removeAttr('disabled');
			}
		})
	});
	
		$(document).on("click","#currentmonth",function(e) {
// 		e.preventDefault();
		$('#filterhtml').html("<div style='background-color: #FFF;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/uploads/ajax_loading.gif' ></div></div>");
	   // return false;
	   //$('#filterhtml').html("<div style='background-color: #10163a;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/theme_elements/images/logo-sm.png' style='height:40px;'></div></div>");
		$.ajax({
			url:base_url+"Expenses/filterByCurrentMonth",
			dataType: "html",
			type: "POST",
			data: $('#expensefilter').serialize(),
			success: function(res) {
			    console.log(res);
				var obj=JSON.parse(res);
				$("#filterhtml").html(obj.html);
				$('#datatable_tb').DataTable({
					"order": [],
					"lengthMenu": [[50, 100, 500, -1], [50, 100, 500, "All"]]
				});
				if(obj.count > 0){
				// $('#datatable').DataTable({
				// 	"order": [],
				// 	"lengthMenu": [[50, 100, 500, -1], [50, 100, 500, "All"]]
				// });
				$('#print_report').removeAttr('disabled');
				$('#pdf_expense_report').removeAttr('disabled');
				$('#advance_search').removeAttr('disabled');
				
				}else{
				    $("#print_report").attr( "disabled", "disabled" );
				    $("#pdf_expense_report").attr( "disabled", "disabled" );
				    $("#advance_search").attr( "disabled", "disabled" );
				}
				$('#reset_filters').removeAttr('disabled');
			}
		})
	});
	
	
		$(document).on("click","#currentyear",function(e) {
// 		e.preventDefault();
		$('#filterhtml').html("<div style='background-color: #FFF;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/uploads/ajax_loading.gif' ></div></div>");
	   // return false;
	   //$('#filterhtml').html("<div style='background-color: #10163a;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/theme_elements/images/logo-sm.png' style='height:40px;'></div></div>");
		$.ajax({
			url:base_url+"Expenses/filterByCurrentYear",
			dataType: "html",
			type: "POST",
			data: $('#expensefilter').serialize(),
			success: function(res) {
			    console.log(res);
				var obj=JSON.parse(res);
				$("#filterhtml").html(obj.html);
				$('#datatable_tb').DataTable({
					"order": [],
					"lengthMenu": [[50, 100, 500, -1], [50, 100, 500, "All"]]
				});
				if(obj.count > 0){
				// $('#datatable').DataTable({
				// 	"order": [],
				// 	"lengthMenu": [[50, 100, 500, -1], [50, 100, 500, "All"]]
				// });
				$('#print_report').removeAttr('disabled');
				$('#pdf_expense_report').removeAttr('disabled');
				$('#advance_search').removeAttr('disabled');
				
				}else{
				    $("#print_report").attr( "disabled", "disabled" );
				    $("#pdf_expense_report").attr( "disabled", "disabled" );
				    $("#advance_search").attr( "disabled", "disabled" );
				}
				$('#reset_filters').removeAttr('disabled');
			}
		})
	});
	
	
	function advanceSearch(){
	    $('#filterhtml').html("<div style='background-color: #FFF;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/uploads/ajax_loading.gif' ></div></div>");
	   var advancesearchform =  $('#advance-search-form').serialize();
	   var purchasefilter = $('#purchasefilter').serialize();
	   var finaldata = purchasefilter + '&' + advancesearchform;
	    	$.ajax({
			url:base_url+"Purchase/filter",
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
	
$(document).ready(function(){

  // Initialize Select2
  $('#plant_from').select2();

  // Set option selected onchange
//   $('#plant_for').change(function(){
//     var value = $(this).val();

//     // Set selected 
//     $('#plant_from').val(value);
//     $('#plant_from').select2().trigger('change');

//   });
});	

function getBalance(valid){
        
        $.ajax({
			url:base_url+"Vouchers/getBalance",
			type: "POST",
			data: {id:valid},
			success: function(res) {
				console.log(res);
				    
				    var orgamount = $("#fld_orignal_total_amount").val();
				    
				    if(parseInt(orgamount) > 0){
				        var plant_from_id = $("#plant_from_id").val();
				        if(valid == plant_from_id){
				            res = parseFloat((res.replace(/,/g, ''))) + parseFloat(orgamount);
				        }
				        
				    }
				        $("#f_balance").html("(Balance: "+res+")");
				        $("#balanceInput").val(res);
				        if(parseInt(res) < 1){
    				        console.log('its disabled');
    				        buttons_function(0);
    				    }else{
    				        console.log('its enabled');
    				        buttons_function(1);
    				    }
				    
				    
			}
		});
    }
    
    function buttons_function(enable){
        if(enable==1){
                $('#add_expense').removeAttr("disabled");
                $('#add-expense-another').removeAttr("disabled");
                // $('#add_expense_draft').removeAttr("disabled");
                $('#Reset').removeAttr("disabled");
                
            }else{
                $("#add_expense").attr( "disabled", "disabled" );
                $("#add-expense-another").attr( "disabled", "disabled" );
                // $("#add_expense_draft").attr( "disabled", "disabled" );
                $("#Reset").attr( "disabled", "disabled" );
        }
    }

$(document).on("click","#advance_search",function(e) {
	    e.preventDefault();
	    $("#show_filters_tab").toggle();
	});
	
	
$(document).on("click","#add_expense_draft",function(e) {
// 		e.preventDefault();
// 		console.log("Hello");
		 $('#add_expense_draft').prop('disabled', true);
		$.ajax({
			data: $('#addExpense').serialize(),
			dataType: "html",
			type: "POST",
			url:base_url+"Expenses/addExpensedrafts",
			success: function(res) {
			    console.log(res);
			    var obj=JSON.parse(res);
				
				if(obj.responce == 'success'){
				// 	$.notify(obj.message,obj.responce);	
					setTimeout(function(){ 
					window.location.href = base_url+"Expenses/manage_drafts";
					}, 3000);
				}else{
				// 	$.notify(obj.message,obj.responce);	
					$('#add_expense_draft').prop('disabled', false);
				}
			}
		})
	});
	$(document).on("click","#update_expense_draft",() => {
		//e.preventDefault();
		//console.log("hello");
		$('#update_expense_draft').prop('disabled', true);
		$.ajax({
			url:base_url+"Expenses/editdraftProcess",
			dataType: "html",
			type: "POST",
			data: $('#updateDraftExpense').serialize(),
			success: function(res) {
			 //   console.log(res);
				var obj=JSON.parse(res);
				
				if(obj.responce == 'success'){
					$.notify(obj.message,obj.responce);	
					setTimeout(function(){ 
					window.location.href = base_url+"Expenses/manage_drafts";
					}, 3000);
				}else{
					$.notify(obj.message,obj.responce);	
					$('#update_expense_draft').prop('disabled', false);
				}
			}
		})
	});
	
	function advanceSearch(){
	    $('#filterhtml').html("<div style='background-color: #FFF;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/uploads/ajax_loading.gif' ></div></div>");
	   var advancesearchform =  $('#advance-search-form').serialize();
	   var expensefilter = $('#expensefilter').serialize();
	   var finaldata = expensefilter + '&' + advancesearchform;
	    	$.ajax({
			url:base_url+"Expenses/filter",
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
		 
		window.open(base_url + 'Expenses/print_report?filter='+etype+'&type='+type, "Expanse Report", 'width=1210, height=842');
		var table = $('#datatable').DataTable();
	});
	$(document).on("click","#pdf_expense_report",function(e) {
		e.preventDefault();
		if($('.expenseRows tr').length > 0){
		var fromDate = $('#from_date').val();
		var toDate = $('#to_date').val();			
		var etype = $('#filter').val();
		var type = $('#filter_type').val();
		var voucher = $('#expense_voucher').val();
		var location = $('#fld_location').val();
		var user = $('#fld_user').val();
		var stationary = $('#stationary').val();
		var url=base_url+'Expenses/print_expense_report?form=' + fromDate + '&to=' + toDate+'&filter='+etype+'&type='+type+'&voucher='+voucher+'&location='+location+'&user='+user+'&stationary='+stationary;
		window.open(url);
		}
	});
	
$(document).ready(function(){
$(".exptype").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");
            if(optionValue){
                $(".box").not("." + optionValue).hide();
                $("." + optionValue).show();
            } else{
                $(".box").hide();
            }
        });
    }).change();
});

	
	"use strict";
    function expense_type(sl) {
		//var supplier_id = $('#fld_supplier_id').val();
		var expense_type = $("#expense_type_"+sl).val();
		//var product_unit = $("#product_id_"+sl).find(':selected').attr('data-unit');
		//$("#unit_code_"+sl).val(product_unit);
// 		if ( supplier_id == 0) {
// 			alert('Please select Supplier !');
// 			return false;
// 		}
		
		
		 $.ajax({
                    url : base_url+"Common/get_sub_values",
                    method : "POST",
                    data : {id: expense_type},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        var html = '<option value="">Select</option>';
                        var i;
                        for(i=0; i<data.length; i++){
                            html += '<option value="'+ data[i].expense_value +'">'+data[i].expense_value+'</option>';
                        }
                        if(expense_type == 1){
                           $('#quantity_'+sl).prop('readonly', 'readonly');
                           $('#unit_'+sl).attr("readonly", "readonly");
                           $('#unit_'+sl).removeAttr('required', 'required');
                           $('#unit_'+sl).prepend('<div class="disabled-select"></div>')
                        //   $('#unit_'+sl).select2({ disabled: true });
                           //$('#fld_expense_id').removeAttr('required', 'required');
                           //$('#expense_value_'+sl).css('pointer-events','none');
                           $('#expense_value_'+sl).html(html);
                        }else {
                           //$('#expense_value_'+sl).removeAttr("disabled");
                           $('#unit_'+sl).prop('required', 'required');
                           $('#quantity_'+sl).removeAttr('readonly', 'readonly');
                          $('#unit_'+sl).removeAttr('readonly');
                        //   $('#unit_'+sl).select2({ disabled: false });
                           $(".disabled-select", $('#unit_'+sl)).remove();
                           $('#expense_value_'+sl).html(html);
                           
                        }
                    }
                });
        
	}
	
//$(document).ready(function(){
// $('#updateexpense')
// 		.each(function(){
// 			$(this).data('serialized', $(this).serialize())
// 		})
//         .on('change input', function(){
//             console.log("hfhkh");
//             $(this)
            
//             //e.preventDefault();
//                 .find('input:submit, button:submit')
//                     .attr('disabled', $(this).serialize() == $(this).data('serialized'));
//          })
        
//          .find('input:submit, button:submit').attr('disabled', true);
//});	
	