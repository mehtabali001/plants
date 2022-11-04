 var base_url=$("#base_url").val();
 
 $(document).ready(function(){
    $('.exampleModal').on('click', function(){
      var postID = $(this).attr('data-content');
      var datauri = $(this).attr('data-uri');
      //console.log(postID);
      $("#modal-form").attr('action', datauri);
      $('#navigation_id').val(postID);
    });
    
    $('.exampleModal2').on('click', function(){
      var postID = $(this).attr('data-content');
      var datauri = $(this).attr('data-uri');
      //console.log(postID);
      $("#modal-formdelete").attr('action', datauri);
      $('#navigation_id').val(postID);
    });
    
 });
 
 var count = 2;
 function updateShipmentValue(){
	    var ship_from = $("#fld_shipment_from_1").val();
	    var loc_to =  $(':selected', $("#fld_location_to")).data('name');
	    var navigation_date = $("#fld_navigation_date").val() || '';
        var date = new Date(navigation_date.split("/").reverse().join("-"));
        var newdate = date.getDate() + '-' + (date.getMonth() + 1) + '-' + date.getFullYear();
        var ship_to = ship_from+'/'+loc_to+'/'+newdate;
	    $("#fld_shipment_to").val(ship_to);
}

function check_sub_product(){
         var selectedSubCat = [];
        $(".fld_product_id").each(function() {
            console.log(this.value);
            if(this.value != ""){
                console.log("Not empty");
    		    if(selectedSubCat.includes(this.value)){
    		         alert("You cannot select same sub product multipul times.");
                     buttons_function(0);
    		    }else{
    	            selectedSubCat.push(this.value);
                    buttons_function(1);
    		    }
            }else{
                buttons_function(0);
            }
        });
    }
    
     function buttons_function(enable){
        if(enable==1){
                $('#add_navigation').removeAttr("disabled");
                $('#add_navigation_another').removeAttr("disabled");
                $('#add_navigation_draft').removeAttr("disabled");
                
            }else{
                $("#add_navigation").attr( "disabled", "disabled" );
                $("#add_navigation_another").attr( "disabled", "disabled" );
                $("#add_navigation_draft").attr( "disabled", "disabled" );
        }
    }

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
		var products=$("#productSelect_"+$("#product_id").val()).html();
		var locations=$("#locationSelect").html();
      
           var newdiv = document.createElement('tr');
           
           newdiv = document.createElement("tr");
           

            newdiv.innerHTML ='<td class="text-center"><select class="select2 form-control mb-3 custom-select fld_product_id" name="fld_sitem[]"  id="product_subcat_'+ count +'" onchange="check_sub_product()">'+products+'</select></td><td class="text-right"><div class="input-group"><input type="text" tabindex="5" class="form-control fld_shipment_from" name="fld_shipment_from[]" value="" id="fld_shipment_'+count+'" readonly required><span class="input-group-prepend"><button type="button" id="location_shipments_'+count+'" onclick="getShipments('+count+')" class="btn btn-gradient-primary"><i class="fas fa-search"></i></button></span></div><input type="hidden" id="stock_location_id_'+count+'" name="stock_location_id[]" value=""/><input type="hidden" id="fld_purchase_id_'+count+'" name="fld_purchase_id[]" value="" /></td><td class="text-right"><input type="number" required name="fld_item_qty[]" id="cartoon_'+count+'" required min="0" class="form-control text-right item_quantity" onkeyup="calculate_store('+count+');" onchange="calculate_store('+count+');" placeholder="0.00" value="" tabindex="8" aria-required="true"></td><td class="text-right"><input type="number" name="fld_item_weight[]" id="fld_weight_'+ count +'" class="form-control text-right" onkeyup="calculate_store('+count+');" onchange="calculate_store('+count+');" placeholder="0" value="0" tabindex="9" aria-required="true" readonly></td><td class="test"><input type="number" name="fld_rate[]" required="" onkeyup="calculate_store('+count+');" onchange="calculate_store('+count+');" id="product_rate_'+count+'" class="form-control product_rate_'+count+' text-right" placeholder="0.00" value="" min="0" tabindex="10" aria-required="true" readonly></td><td class="text-right"><input class="form-control fld_amount_row text-right" type="number" name="fld_amount[]" id="total_price_'+count+'" value="0.00"  readonly="readonly"></td><td><button class="btn btn-danger text-right red" type="button" value="Delete" onclick="deleteRow(this)" ><i class="fas fa-times"></i></button></td>';
            document.getElementById(divName).appendChild(newdiv);
            // document.getElementById(tabin).focus();
            //document.getElementById("add_invoice_item").setAttribute("tabindex", tab5);
            //document.getElementById("add_purchase").setAttribute("tabindex", tab6);
			//document.getElementById("add_purchase_another").setAttribute("tabindex", tab7);
            $("#product_subcat_"+count).select2();
            count++;
            
           var timer;
           var timeout = 2000;  // Timout duration
           
           //$('#fld_location_from, #fld_location_to, #product_id, #vehicle_no, #product_id_'+count+', #sub_category_'+count+'').change(function(){
           $('#fld_location_from, #fld_location_to, #product_id, #fld_vehicle_no, .fld_product_id').change(function(){       
                var selectedOption = $(this).val();
                // $(this).val('')   
                // alert(selectedOption);
                // return false;
                saveData();
                    $('.ml3').css('display','block');
                    var textWrapper = document.querySelector('.ml3');
                    textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");
                    
                    anime.timeline({loop: true})
                      .add({
                        targets: '.ml3 .letter',
                        opacity: [0,1],
                        easing: "easeInOutQuad",
                        duration: 2250,
                        delay: (el, i) => 150 * (i+1)
                      }).add({
                        targets: '.ml3',
                        opacity: 0,
                        duration: 1000,
                        easing: "easeOutExpo",
                        delay: 1000
                      }); 
               });
               
             $('#fld_received_by, #fld_remarks, .item_quantity, .fld_shipment_from,#fld_freight_rate, #fld_freight_amount').change(function(){  
                 saveData();
                    $('.ml3').css('display','block');
                    var textWrapper = document.querySelector('.ml3');
                    textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");
                    
                    anime.timeline({loop: true})
                      .add({
                        targets: '.ml3 .letter',
                        opacity: [0,1],
                        easing: "easeInOutQuad",
                        duration: 2250,
                        delay: (el, i) => 150 * (i+1)
                      }).add({
                        targets: '.ml3',
                        opacity: 0,
                        duration: 1000,
                        easing: "easeOutExpo",
                        delay: 1000
                      });
             });

		}else{
			alert('Please select Sub category !');
		}
    }
    
    function deleteRow(e) {
        var t = $("#purchaseTable > tbody > tr").length;
        if (1 == t) alert("There only one row you can't delete.");
        else {
            var a = e.parentNode.parentNode;
            a.parentNode.removeChild(a)
        }
        var gr_tot=0;
		var freight=$("#fld_freight_amount").val();
        $(".fld_amount_row").each(function() {
            isNaN(this.value) || 0 == this.value.length || (gr_tot += parseFloat(this.value))
        });
       
		$("#fld_total_amount").val(gr_tot);
		$("#fld_grand_total").val(+gr_tot + +freight);
    }
    
	
 "use strict";
    function freight_rate() {
		var freight = 0;
		var gr_total = 0;
		var total = $("#fld_total_amount").val();
		var freight_rate = $('#fld_freight_rate').val();
		$(".item_quantity").each(function() {
           isNaN($(this).val()) || (freight += parseFloat($(this).val() * freight_rate))
        });
		$("#fld_freight_amount").val(freight);
// 		gr_total=+freight + +total;
		gr_total=freight+parseFloat(total);
		$("#fld_grand_total").val(gr_total);
	}
	"use strict";
    function calculate_sum(sb, sl) {
		var quantity=$("#orignal_qty_"+sl).val();;
		var amount=0;
		var gr_tot=0;
		var rate=$("#fld_rate_"+sl).val();
		var freight=$("#fld_freight_amount").val();
		
		if(sb == 'mt'){
		    
		var item_qty = $('#fld_item_qty_'+sl).val();
			console.log(quantity, item_qty);
		if(item_qty != ""){
				
				if(parseFloat(item_qty) <= parseFloat(quantity)){
				
				    isNaN(item_qty) || 0 == item_qty.length || (amount += parseFloat(item_qty * rate))
					
					$("#fld_item_weight_"+sl).val(item_qty * 1000);
					$('#add_navigation').prop('disabled', false);
				}else{
					alert('Limit exceed.');
					$('#add_navigation').prop('disabled', true);
				}
			}
		
		$("#fld_amount_"+sl).val(amount);
		
		$(".fld_amount_row").each(function() {
            isNaN(this.value) || 0 == this.value.length || (gr_tot += parseFloat(this.value))
        });
		$("#fld_total_amount").val(gr_tot);
		$("#fld_grand_total").val(+gr_tot + +freight);
		}else{
		    
		    var item_weight = $('#fld_item_weight_'+sl).val();
			if(item_weight != ""){
				if((parseFloat(item_weight)/1000) <= parseFloat(quantity)){
					
					isNaN(item_weight) || 0 == item_weight.length || (amount += parseFloat((item_weight/1000) * rate))
					
					$("#fld_item_qty_"+sl).val(item_weight / 1000);
					
				}else{
					alert('Limit exceed.');
				}
			}
		
		$("#fld_amount_"+sl).val(amount);
		$(".fld_amount_row").each(function() {
            isNaN(this.value) || 0 == this.value.length || (gr_tot += parseFloat(this.value))
        });
		$("#fld_total_amount").val(gr_tot);
		$("#fld_grand_total").val(+gr_tot + +freight);
		}
	}
	
	 function getDetailView(){
        var location=$("#fld_location_from").val();
		var product=$("#product_id").val();
		if(product=='' || product==undefined){
		    	$("#addPurchaseItem").html("");
				$("#t_total").hide();
		}else{
        $.ajax({
			url:base_url+"Navigations/getDetailView",
			dataType: "html",
			type: "POST",
			data: {location:location, product:product},
			success: function(res) {
			    console.log(res);
				var obj=JSON.parse(res);
				$("#addPurchaseItem").html(obj.html);
				$("#t_total").show();
				$(".select2").select2({
					width: '100%'
				});
				
				if(product==1){
				    $("#add_invoice_item").hide();
				}else{
				    $("#add_invoice_item").show();
				}
				
		   var timer;
           var timeout = 2000;  // Timout duration
           var count = 1;
           
           //$('#fld_location_from, #fld_location_to, #product_id, #vehicle_no, #product_id_'+count+', #sub_category_'+count+'').change(function(){
           $('#fld_location_from, #fld_location_to, #product_id, #fld_vehicle_no, .fld_product_id').change(function(){       
                var selectedOption = $(this).val();
                // $(this).val('')   
                // alert(selectedOption);
                // return false;
                saveData();
                    $('.ml3').css('display','block');
                    var textWrapper = document.querySelector('.ml3');
                    textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");
                    
                    anime.timeline({loop: true})
                      .add({
                        targets: '.ml3 .letter',
                        opacity: [0,1],
                        easing: "easeInOutQuad",
                        duration: 2250,
                        delay: (el, i) => 150 * (i+1)
                      }).add({
                        targets: '.ml3',
                        opacity: 0,
                        duration: 1000,
                        easing: "easeOutExpo",
                        delay: 1000
                      });
               });
               
             $('#fld_received_by, #fld_remarks, .item_quantity,.fld_shipment_from,#fld_freight_rate, #fld_freight_amount').change(function(){  
                 saveData();
                    $('.ml3').css('display','block');
                    var textWrapper = document.querySelector('.ml3');
                    textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");
                    
                    anime.timeline({loop: true})
                      .add({
                        targets: '.ml3 .letter',
                        opacity: [0,1],
                        easing: "easeInOutQuad",
                        duration: 2250,
                        delay: (el, i) => 150 * (i+1)
                      }).add({
                        targets: '.ml3',
                        opacity: 0,
                        duration: 1000,
                        easing: "easeOutExpo",
                        delay: 1000
                      });
             });   
				
			}
		})
		}
    }
    
    $(document).ready(function(){

           var timer;
           var timeout = 2000;  // Timout duration
           var count = 1;
           var getit = $("#fld_location_from").filter(":selected").val();
           var navigation_id = $("#navigation_id").val();
           
           var path = base_url+"Navigations/createIntNav";
           var path2 = base_url+"Navigations/edit_drafts/"+navigation_id;
           var currentLocation = window.location;
           //alert(currentLocation);
           if(path == currentLocation || path2 == currentLocation){
           //$('#fld_location_from, #fld_location_to, #product_id, #vehicle_no, #product_id_'+count+', #sub_category_'+count+'').change(function(){
           $('#fld_location_from, #fld_location_to, #product_id, #fld_vehicle_no, .fld_product_id').change(function(){       
                var selectedOption = $(this).val();
                // $(this).val('')   
                // alert(selectedOption);
                // return false;
                saveData();
                    $('.ml3').css('display','block');
                    var textWrapper = document.querySelector('.ml3');
                    textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");
                    
                    anime.timeline({loop: true})
                      .add({
                        targets: '.ml3 .letter',
                        opacity: [0,1],
                        easing: "easeInOutQuad",
                        duration: 2250,
                        delay: (el, i) => 150 * (i+1)
                      }).add({
                        targets: '.ml3',
                        opacity: 0,
                        duration: 1000,
                        easing: "easeOutExpo",
                        delay: 1000
                      }); 
               });
               
             $('#fld_received_by, #fld_remarks, .item_quantity, .fld_shipment_from,#fld_freight_rate, #fld_freight_amount').change(function(){  
                    /*if(timer) {
                        clearTimeout(timer);
                    }
                    timer = setTimeout(saveData, timeout);*/
                    
                    saveData();
                    $('.ml3').css('display','block');
                    var textWrapper = document.querySelector('.ml3');
                    textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");
                    
                    anime.timeline({loop: true})
                      .add({
                        targets: '.ml3 .letter',
                        opacity: [0,1],
                        easing: "easeInOutQuad",
                        duration: 2250,
                        delay: (el, i) => 150 * (i+1)
                      }).add({
                        targets: '.ml3',
                        opacity: 0,
                        duration: 1000,
                        easing: "easeOutExpo",
                        delay: 1000
                      });
             });
           }

  });	
  
  function saveData(){

          var navigation_id = $('#navigation_id').val();
         
          if(navigation_id == ''){
    		$.ajax({
    			data: $('#addNavigation').serialize(),
    			dataType: "html",
    			type: "POST",
    			url:base_url+"Navigations/addNavigationDraftAutosave",
    			success: function(res) {
    				var obj=JSON.parse(res);
    				$('#navigation_id').val(obj.navigation_id);
    				if(obj.responce == 'success'){
    					//$.notify(obj.message,obj.responce);	
    				// 	setTimeout(function(){ 
    				// 	window.location.href = base_url+"Purchase/manage_drafts";
    				// 	}, 3000);
    				}else{
    					//$.notify(obj.message,obj.responce);	
    					$('#add_navigation_draft').prop('disabled', false);
    				}
    			}
    		})
          }else{
    		$.ajax({
    			url:base_url+"Navigations/update_drafts_autosave",
    			dataType: "html",
    			type: "POST",
    			data: $('#addNavigation,#updateDraftNavigation').serialize(),
    			success: function(res) {
    			    console.log(res);
    				var obj=JSON.parse(res);
    				if(obj.responce == 'success'){
    					//$.notify(obj.message,obj.responce);	
    				}else{
    					//$.notify(obj.message,obj.responce);	
    					$('#add_navigation_draft').prop('disabled', false);
    				}
    			}
            })
	    }
  }
    
    function getShipments(sl){
        	var location=$("#fld_location_from").val();
	    	var product=$("#product_id").val();
	    	var sub_cat_id=$("#product_subcat_"+sl).val();
	    $.ajax({
			url:base_url+"Navigations/getShipments",
			dataType: "html",
			type: "POST",
			data: {location:location, product:product, sub_cat_id:sub_cat_id},
			success: function(res) {
			    console.log(res);
				var obj=JSON.parse(res);
				$("#shimpmentdata").html(obj.html);
				$(".bs-example-modal-lg").modal('show');
				$("#selected_row_cat").val(sl);
				
				
			}
		})
    }
	
	$(document).on("click","#location_shipments",function(e) {
		e.preventDefault();
		var location=$("#fld_location_from").val();
		var item=$("#product_id").val();
		$.ajax({
			url:base_url+"Navigations/getShipments",
			dataType: "html",
			type: "POST",
			data: {location:location, item:item},
			success: function(res) {
			    console.log(res);
				var obj=JSON.parse(res);
				$("#shimpmentdata").html(obj.html);
				$(".bs-example-modal-lg").modal('show');
				//var obj=JSON.parse(res);
				
				// if(obj.responce == 'success'){
					// $.notify(obj.message,obj.responce);	
					// setTimeout(function(){ 
					// window.location.href = base_url+"Purchase/manage_drafts";
					// }, 3000);
				// }else{
					// $.notify(obj.message,obj.responce);	
				// }
			}
		})
	});
	$(document).on("click",".shipment",function(e) {
		e.preventDefault();
		var location=$(this).data('id');
		var qty=$(this).data('qty');
		var sl = $("#selected_row_cat").val();
		$.ajax({
			url:base_url+"Navigations/selectShipment",
			dataType: "html",
			type: "POST",
			data: {location:location},
			success: function(res) {
			    console.log(res);
				var obj=JSON.parse(res);
				console.log()
				$("#stock_location_id_"+sl).val(location);
				$("#cartoon_"+sl).val(qty);
				$("#product_rate_"+sl).val(obj.shipments.fld_unit_price)
				$("#fld_shipment_"+sl).val(obj.shipments.fld_shipment);
				$("#fld_purchase_id_"+sl).val(obj.shipments.fld_purchase_id);
				$(".bs-example-modal-lg").modal('hide');
				calculate_store(sl);
			}
		})
	});
	
	function calculate_store(sl) {
	    var gr_tot=0;
        var item_ctn_qty    = $("#cartoon_"+sl).val();
        var vendor_rate = $("#product_rate_"+sl).val();
        var weight = $("#product_subcat_"+sl).find(':selected').attr('data-weight');
        var total_price     = (item_ctn_qty * vendor_rate);
        var total_weight = weight*item_ctn_qty;
        $("#total_price_"+sl).val(total_price);
        $("#fld_weight_"+sl).val(total_weight);
        $(".fld_amount_row").each(function() {
            isNaN(this.value) || 0 == this.value.length || (gr_tot += parseFloat(this.value))
        });
        var freight=$("#fld_freight_amount").val();
		$("#fld_total_amount").val(gr_tot);
		$("#fld_grand_total").val(+gr_tot +freight);
    }
	
	
		$(document).on("click","#add_navigation_draft",function(e) {
		e.preventDefault();
// 		console.log("Hello");
		 $('#add_navigation_draft').prop('disabled', true);
		$.ajax({
			data: $('#addNavigation').serialize(),
			dataType: "html",
			type: "POST",
			url:base_url+"Navigations/addNavigationDraft",
			success: function(res) {
			 // console.log(res);
			    var obj=JSON.parse(res);
				if(obj.responce == 'success'){
				 	$.notify(obj.message,obj.responce);	
					setTimeout(function(){ 
					window.location.href = base_url+"Navigations/manage_drafts";
					}, 3000);
				}else{
				 	$.notify(obj.message,obj.responce);	
					$('#add_navigation_draft').prop('disabled', false);
				}
			}
		})
	});
	$(document).on("click","#update_draft_Navigation",function(e) {
		e.preventDefault();
		//console.log("hello");
		$('#update_draft_Navigation').prop('disabled', true);
		$.ajax({
			url:base_url+"Navigations/update_drafts",
			dataType: "html",
			type: "POST",
			data: $('#updateDraftNavigation').serialize(),
			success: function(res1) {
			    console.log(res1);
				var obj=JSON.parse(res1);
				
				if(obj.responce == 'success'){
					$.notify(obj.message,obj.responce);	
					setTimeout(function(){ 
					window.location.href = base_url+"Navigations/manage_drafts";
					}, 3000);
				}else{
					$.notify(obj.message,obj.responce);	
					$('#update_draft_Navigation').prop('disabled', false);
				}
			}
		})
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
            
 $('#updatenavigation')
.each(function(){
	$(this).data('serialized', $(this).serialize())
})
.on('change input', function(){
    $(this)				
        .find('input:submit, button:submit')
            .attr('disabled', $(this).serialize() == $(this).data('serialized'))
    ;
 })
.find('input:submit, button:submit').attr('disabled', true);           
	
	