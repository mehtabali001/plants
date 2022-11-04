 var base_url=$("#base_url").val();

 $(document).ready(function(){
    $('.exampleModal').on('click', function(){
      var postID = $(this).attr('data-content');
      var datauri = $(this).attr('data-uri');
      //console.log(postID);
      $("#modal-form").attr('action', datauri);
      $('#gl_id').val(postID);
    });
    
    $('.exampleModal2').on('click', function(){
      var postID = $(this).attr('data-content');    
      var datauri = $(this).attr('data-uri');
      //console.log(postID);
      $("#modal-formdelete").attr('action', datauri);
      $('#gl_id').val(postID);
    });

    
});
    var limits = 500;
        "use strict";
    function addPurchaseOrderField1(divName){
		var category=true;
		$(".fld_product_id").each(function() {
			console.log('value'+'===='+this.value);
			if( this.value == ""){
				category =false;
			}
            //isNaN(this.value) || 0 == this.value.length || (gr_tot += parseFloat(this.value))
        });
		if(category == true){
		var products=$("#productSelect").html();
		var locations=$("#locationSelect").html();
        if (count == limits)  {
            alert("You have reached the limit of adding " + count + " inputs");
        }
        else{
            var newdiv = document.createElement('tr');
            var tabin="product_id_"+count;
             tabindex = count * 4 ,
           newdiv = document.createElement("tr");
            tab1 = tabindex + 1;
            
            tab2 = tabindex + 2;
            tab3 = tabindex + 3;
            tab4 = tabindex + 4;
            tab5 = tabindex + 5;
            tab6 = tab5 + 1;
            tab7 = tab6 +1;
            



            newdiv.innerHTML ='<input type="hidden" readonly id="fld_sale_price_'+ count +'" value="0"><input type="hidden" readonly id="fld_purchase_price_'+ count +'" value="0"><td class="span3 supplier"><select class="select2 form-control mb-3 custom-select fld_product_id" name="fld_product_id[]" onchange="product_category('+ count +');" id="product_id_'+ count +'" tabindex="'+tab1+'"><option value="">Select Product</option>'+products+'</select></td><td class="span3"><select class="select2 form-control mb-3 custom-select" name="fld_location_id[]" id="fld_location_id_'+ count +'" required onchange="getShipments('+ count +');"><option value="">Select Locations</option>'+locations+'</select></td>   <td class="type"> <select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="fld_type[]" tabindex="6" id="fld_type_'+ count +'" onchange="shipmentCheck('+ count +')" required><option value="">Select Type</option><option value="1">Gain</option><option value="2">Loss</option><option value="3">Difference</option></select> </td><td class="wt"> <div style="display:none" id="d_fld_shipment_'+ count +'"><select class="select2 form-control mb-3 custom-select" name="fld_shipment[]" id="s_fld_shipment_'+ count +'" onchange="getQty('+ count +');" disabled required><option value="">Select Shipment</option></select> </div> <input type="text" name="fld_shipment[]" id="i_fld_shipment_'+ count +'" class="form-control" aria-required="true"> </td> <td class="text-right"><input type="hidden" name="fld_stock_location_id[]" id="fld_stock_location_id_'+ count +'" value="0" /><input type="text" name="fld_quantity[]" tabindex="'+tab2+'" required  id="fld_quantity_'+ count +'" class="form-control text-right" onkeyup="calculate_store(' + count + ');" onchange="calculate_store(' + count + ');" placeholder="0.00" value="" min="0"/>  </td><td class="test"><input type="text" name="fld_unit_price[]" onkeyup="calculate_store('+ count +');" onchange="calculate_store('+ count +');" id="product_rate_'+ count +'" class="form-control product_rate_'+ count +' text-right" placeholder="0.00" value="" min="0" tabindex="'+tab3+'" readonly/></td><td class="text-right"><input class="form-control total_price text-right total_price_'+ count +'" type="text" name="fld_total_amount[]" id="total_price_'+ count +'" value="0.00" readonly="readonly" /> </td><td><button style="text-align: right;" class="btn btn-danger red" type="button"  onclick="deleteRow(this)" tabindex="8"><i class="fas fa-times"></i></button></td>';
            document.getElementById(divName).appendChild(newdiv);
            document.getElementById(tabin).focus();
            //document.getElementById("add_invoice_item").setAttribute("tabindex", tab5);
            //document.getElementById("add_purchase").setAttribute("tabindex", tab6);
			//document.getElementById("add_purchase_another").setAttribute("tabindex", tab7);
           
            count++;

            $("select.form-control:not(.dont-select-me)").select2({
                placeholder: "Select option",
                allowClear: true
            });
        }
		}else{
			alert('Please select product category !');
		}
    }
	function deleteRow(e) {
        var t = $("#purchaseTable > tbody > tr").length;
        if (1 == t) alert("There only one row you can't delete.");
        else {
            var a = e.parentNode.parentNode;
            a.parentNode.removeChild(a)
        }
        calculateSum()
    }
	"use strict";
    function product_category(sl) {
		
	}
	
	function shipmentCheck(sl){
	   // alert(sl);
	    var fld_type = $("#fld_type_"+sl).val();
	    if(fld_type == 3){
	        $("#d_fld_shipment_"+sl).show();
	        $("#i_fld_shipment_"+sl).hide();
	        $("#i_fld_shipment_"+sl).attr( "disabled", "disabled" );
	        $('#s_fld_shipment_'+sl).removeAttr("disabled");
	        $('#product_rate_'+sl).val($("#fld_purchase_price_"+sl).val());
	    }else{
	        $("#d_fld_shipment_"+sl).hide();
	        $("#i_fld_shipment_"+sl).show();
	        $("#s_fld_shipment_"+sl).attr( "disabled", "disabled" );
	        $('#i_fld_shipment_'+sl).removeAttr("disabled");
	        $('#product_rate_'+sl).val($("#fld_sale_price_"+sl).val());
	    }
	     calculate_store(sl);
	}
	
	function getShipments(sl) {
		
		
		var product_id = $("#product_id_"+sl).val();
		var location_id = $("#fld_location_id_"+sl).val();
		console.log(product_id, location_id);
		 $.ajax({
                    url : base_url+"Gain_loss/getShipments",
                    method : "POST",
                    data : {product_id: product_id, location_id:location_id},
                    async : true,
                    dataType : 'json', 
                    success: function(data){ 
                        console.log(data);
                        var html = '<option value="" data-qty="0" data-id="0">Select Shipment</option>';
                        var i;
                        for(i=0; i<data.shipments.length; i++){
                            html += '<option value='+data.shipments[i].fld_shipment+' data-qty="'+data.shipments[i].fld_stock_qty+'" data-id="'+data.shipments[i].fld_id+'" data-price="'+data.shipments[i].fld_purchase_price+'">'+data.shipments[i].fld_shipment+'</option>';
                        } 
                        $('#s_fld_shipment_'+sl).html(html);
                        console.log(data.rate);
                        $('#product_rate_'+sl).val(data.rate);
                        $("#fld_sale_price_"+sl).val(data.rate)
                           
                    }
                });
	}
	
	function getQty(sl){
	    var qty = $("#s_fld_shipment_"+sl).find(':selected').attr('data-qty');
	    $("#fld_quantity_"+sl).val(qty);
	    
	    var id = $("#s_fld_shipment_"+sl).find(':selected').attr('data-id');
	    $("#fld_stock_location_id_"+sl).val(id); 
	    
	    var price = $("#s_fld_shipment_"+sl).find(':selected').attr('data-price');
	    $("#product_rate_"+sl).val(price); 
	    $("#fld_purchase_price_"+sl).val(price);
	    calculate_store(sl);
	}
	

	
//Calculate Sum
    "use strict";
function calculateSum() {
      var t = 0;

         
            //Total Price
    $(".total_price").each(function () {
        isNaN(this.value) || 0 == this.value.length || (t += parseFloat(this.value))
    }),   
    e = t.toFixed(2, 2);

    var test = +e;
    $("#fld_grand_total_amount").val(test.toFixed(2, 2));


    var gt = $("#fld_grand_total_amount").val();
    var grnt_totals = gt;
    $("#fld_grand_total_amount").val(grnt_totals);

    
}
 //Calculate store product
        "use strict";
    function calculate_store(sl) {
       
        var gr_tot = 0;
        var item_ctn_qty    = $("#fld_quantity_"+sl).val();
        var vendor_rate = $("#product_rate_"+sl).val();

        var total_price     = item_ctn_qty * vendor_rate;
        $("#total_price_"+sl).val(total_price.toFixed(2));

        //Total Price
        $(".total_price").each(function() {
            isNaN(this.value) || 0 == this.value.length || (gr_tot += parseFloat(this.value))
        });

        //$("#Total").val(gr_tot.toFixed(2,2));
        var grandtotal = gr_tot;
        $("#fld_grand_total_amount").val(grandtotal.toFixed(2,2));
    }
    
    function getgainandlossDataByDate(type){
    if(type=='daily'){
        var currentdate = new Date();
        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', currentdate));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', currentdate));
        getgainandloss();
    }else if(type=='weekly'){
        var currentdate = new Date();
        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', new Date(currentdate.setDate(currentdate.getDate() - currentdate.getDay()))));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', new Date(currentdate.setDate(currentdate.getDate() - currentdate.getDay()+6))));
        getgainandloss();
    }else if(type=='monthly'){
        var date = new Date();
        var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
        var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', firstDay));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', lastDay));
        getgainandloss();
    }else if(type=='yearly'){
        var date = new Date();
        var firstDay = new Date(date.getFullYear(), 0, 1);
        var lastDay = new Date(date.getFullYear(), 11 + 1, 0);
        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', firstDay));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', lastDay));
        getgainandloss();
    }
}
	
	function getgainandloss(){
	    $('#datatable').DataTable().clear().destroy();
		$('#filterhtml').html("<div style='background-color: #fff;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/uploads/ajax_loading.gif' ></div></div>");
		$.ajax({
			url:base_url+"Gain_loss/filter",
			dataType: "html",
			type: "POST",
			data: $('#GlFilter').serialize(),
			success: function(res) {
				var obj=JSON.parse(res);
				$("#filterhtml").html(obj.html);
				var table = $('#datatable').DataTable({
                    "ordering": false,
                    "pageLength": 100
                });
				if(obj.count > 0){
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
		});
	}

   /* $(document).on("click","#show_report",function(e) {
		e.preventDefault();
			$('#datatable').DataTable().clear().destroy();
		$('#filterhtml').html("<div style='background-color: #fff;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/uploads/ajax_loading.gif' ></div></div>");
		$.ajax({
			url:base_url+"Gain_loss/filter",
			dataType: "html",
			type: "POST",
			data: $('#GlFilter').serialize(),
			success: function(res) {
			    //console.log(res);
				var obj=JSON.parse(res);
				$("#filterhtml").html(obj.html);
				var table = $('#datatable').DataTable({
                    "ordering": false,
                    "pageLength": 100
                });
				if(obj.count > 0){
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
	});*/
	
	function advanceSearch(){
	    $('#filterhtml').html("<div style='background-color: #10163a;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/uploads/ajax_loading.gif' ></div></div>");
	   var advancesearchform =  $('#advance-search-form').serialize();
	   var GlFilter = $('#GlFilter').serialize();
	   var finaldata = GlFilter + '&' + advancesearchform;
	    	$.ajax({
			url:base_url+"Gain_loss/filter",
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
	
	
	$(document).on("click","#print_report",function(e) {
		e.preventDefault();
		var advancesearchform =  $('#advance-search-form').serialize();
	    var GlFilter = $('#GlFilter').serialize();
	    var finaldata = GlFilter + '&' + advancesearchform;
		 
		window.open(base_url + 'Gain_loss/print_report?'+finaldata, "Sales Report", 'width=1210, height=842');
	});
	$(document).on("click","#pdf_purchase_report",function(e) {
		e.preventDefault();
		var advancesearchform =  $('#advance-search-form').serialize();
	    var GlFilter = $('#GlFilter').serialize();
	    var finaldata = GlFilter + '&' + advancesearchform;
		var url=base_url+'Gain_loss/pdf_report?'+finaldata;
		window.open(url);
		
	});
	
	function setreportfilter(val){
		$("#filter_type").val(val);
	}

	
	$(document).on("click","#advance_search",function(e) {
	    e.preventDefault();
	    $("#show_filters_tab").toggle();
	});
	
	
	// 	key functions
	   $(document).keydown(function(e) {
        
                if (e.which == 121) {
            e.preventDefault();
                    $("#add_gain_loss").click();
                    $("#show_report").click();
                }
                if (e.which == 117 ){
                    e.preventDefault();
                    $("#add_gain_loss_another").click();
                    $("#print_report").click();
                }
                if (e.which == 118 ){
                    e.preventDefault();
                    $("#add_purchase_draft").click();
                    $("#pdf_purchase_report").click();
                    
                }
                if (e.which == 119) {
            e.preventDefault();
                    $("#update_draft_purchase").click();
                    $("#advance_search").click();
                }
                
            });
	