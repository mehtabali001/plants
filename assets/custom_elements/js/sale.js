 var base_url=$("#base_url").val();
 
  var limits = 500;
        "use strict";
        
 $(document).ready(function(){
     
    // $('.exampleModal').on('click', function(){
    //   var postID = $(this).attr('data-content');
    //   var datauri = $(this).attr('data-uri');
    // //   console.log(postID);
    //   $("#modal-form").attr('action', datauri);
    //   $('#sale_id').val(postID);
    // });
    
    // $('.exampleModal2').on('click', function(){
    //   var postID = $(this).attr('data-content');
    //   var datauri = $(this).attr('data-uri');
    //   //console.log(postID);
    //   $("#modal-formdelete").attr('action', datauri);
    //   $('#sale_id').val(postID);
    // });
    
 });
 
 function changeModelData(e){
    var postID = $(e).attr('data-content');
      var datauri = $(e).attr('data-uri');
      console.log(postID);
      $("#modal-form").attr('action', datauri);
      $('#sale_id').val(postID);
    }
function changeModelData2(e){
     var postID = $(e).attr('data-content');
      var datauri = $(e).attr('data-uri');
      //console.log(postID);
      $("#modal-formdelete").attr('action', datauri);
      $('#sale_id').val(postID);
    }

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
		var products=$("#productSelect_"+$("#fld_category").val()).html();
        if (count == limits)  {
            alert("You have reached the limit of adding " + count + " inputs");
        }
        else{
            var newdiv = document.createElement('tr');
            var tabin="product_subcat_"+count;
             tabindex = count * 4 ,
           newdiv = document.createElement("tr");
            tab1 = tabindex + 1;
            tab2 = tabindex + 2;
            tab3 = tabindex + 3;
            tab4 = tabindex + 4;
            tab5 = tabindex + 5;
            tab6 = tab5 + 1;
            tab7 = tab6 +1;

            newdiv.innerHTML ='<td class="text-center">'+count+'</td><td class="text-center"><select class="select2 form-control mb-3 custom-select fld_product_id" name="fld_subcat_id[]" onchange="product_category('+ count +');" id="product_subcat_'+ count +'" tabindex="'+tab1+'" required><option value="">Select Product</option>'+products+'</select></td><td class="text-right"><div class="input-group"><input type="text" tabindex="5" class="form-control fld_shipment" name="fld_shipment[]" value="" id="fld_shipment_'+ count +'" readonly oninput="validity.valid||(value=\'\');"><span class="input-group-prepend"><button type="button" id="location_shipments_'+ count +'" onclick="getShipments('+ count +')" class="btn btn-gradient-primary"><i class="fas fa-search"></i></button></span></div><input type="hidden" id="stock_location_id_'+ count +'" name="stock_location[]" value=""/></td> <td class="text-right"><input type="hidden" name="orignal_qty[]" id="orignal_qty_'+ count +'" /><input type="number" name="fld_quantity[]" tabindex="'+tab2+'" step="0.001" required id="cartoon_'+ count +'" class="form-control text-right fld_quantity store_cal_' + count + '" onkeyup="calculate_store(' + count + ');" onchange="calculate_store(' + count + ');" placeholder="0.00" value="1" min="0"/>  </td> <td class="text-right"><input type="number" name="fld_weight[]" id="fld_weight_'+ count +'" class="form-control text-right store_cal_' + count + '" onkeyup="calculate_store(' + count + ');" onchange="calculate_store(' + count + ');" placeholder="0.00" value="0.00" readonly/><input type="hidden" name="fld_row_discount[]" id="fld_row_discount_' + count + '" class="form-control text-right"  readonly>  </td><td class="test"><input type="number" name="fld_unit_price[]" onkeyup="calculate_store('+ count +');" onchange="calculate_store('+ count +');" id="product_rate_'+ count +'" class="form-control product_rate_'+ count +' text-right" placeholder="0.00" value="" min="0" tabindex="'+tab3+'" readonly/></td><td class="text-right"><input class="form-control total_price text-right total_price_'+ count +'" type="number" name="fld_total_amount[]" id="total_price_'+ count +'" value="0.00" readonly="readonly" /> </td><td><button style="text-align: right;" class="btn btn-danger red" type="button"  onclick="deleteRow(this)" tabindex="8"><i class="fas fa-times"></i></button></td>';
            document.getElementById(divName).appendChild(newdiv);
            document.getElementById(tabin).focus();
            //document.getElementById("add_invoice_item").setAttribute("tabindex", tab5);
            //document.getElementById("add_purchase").setAttribute("tabindex", tab6);
			//document.getElementById("add_purchase_another").setAttribute("tabindex", tab7);
            $("#product_subcat_"+count).select2();
            
            $("#stock_location_id_"+count).val($("#stock_location_id_"+(count-1)).val());
			$("#fld_shipment_"+count).val($("#fld_shipment_"+(count-1)).val());
            
            count++;
            
           var timer;
           var timeout = 2000;  // Timout duration
           //var count = 1;
           //var getit = $("#fld_location_from").filter(":selected").val();
           
           //$('#fld_location_from, #fld_location_to, #product_id, #vehicle_no, #product_id_'+count+', #sub_category_'+count+'').change(function(){
           $('#fld_customer_id, #fld_location, #fld_category, #fld_payment_type, #fld_bank,.fld_product_id').change(function(){       
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
               
            $('#fld_invoice_no, #fld_vehicle_no, .fld_shipment, .fld_quantity, #fld_discount').change(function(){  
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
		}else{
			alert('Please select Sub category !');
		}
    }
    
    function check_sub_product(){
         var selectedSubCat = [];
        $(".fld_product_id").each(function() {
            console.log(this.value);
            if(this.value != ""){
                console.log("Not empty");
    		  //  if(selectedSubCat.includes(this.value)){
    		  //       alert("You cannot select same sub product multipul times.");
        //              buttons_function(0);
    		  //  }else{
    	   //         selectedSubCat.push(this.value);
        //             buttons_function(1);
    		  //  }
            }else{
                buttons_function(0);
            }
        });
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
		var subcat= $("#product_subcat_"+sl).val();
		var location=$("#fld_location").val();
		var product=$("#fld_category").val();
		var date=$("#fld_sale_date").val();
		
		$.ajax({
		    data: {location: location, product:product, subproduct:subcat, date:date},
			type: "POST",
			url: base_url+"Sales/getRate",
			success: function(res) {
			
				$("#product_rate_"+sl).val(res);
				calculate_store(sl);
				check_sub_product();
			}
		});
		
	}
	function sale_function(div){
		if(div == "customerDiv"){
			$("#customerDiv").show();
			$("#saleDiv").hide();
		}
		if(div == "saleDiv"){
			$("#saleDiv").show();
			$("#customerDiv").hide();
		}
	}
//Calculate Sum
    "use strict";
function calculateSum() {
    var t = 0;
    var total_discount = 0;
    var total_weight = 0;
    var discount = $("#fld_discount").val();
    var discount_per_kg = discount/11.8;
    
    
    var wt, qt;
        
    $(".fld_product_id").each(function(){
        var row_id = parseInt($(this).attr("id").replace( /[^\d.]/g, ''));
        wt = $("#product_subcat_"+row_id).find(':selected').attr('data-weight');
        qt = $("#cartoon_"+row_id).val();
        total_weight += parseFloat($("#fld_weight_"+row_id).val());
        // alert(total_weight);
        if(wt!=undefined){
            $("#fld_row_discount_"+row_id).val(Math.round(discount_per_kg*wt*qt));
             
            $("#cartoon_"+row_id).val()*$("#product_rate_"+row_id).val();
            //$("#total_price_"+row_id).val((($("#cartoon_"+row_id).val()*$("#product_rate_"+row_id).val())-(discount_per_kg*wt*qt)).toFixed(2));
            total_discount += Math.round(discount_per_kg*wt*qt);
        }
    });
    $("#fld_total_weight").val(total_weight.toFixed(2));
    $("#fld_total_discount").val(Math.round(total_discount.toFixed(2)));
    //Total Price
    $(".total_price").each(function () {
        if(this.value < 0){
               alert("Limit Exceeded.");
               $("#add_sale_another").attr( "disabled", "disabled" );
               $("#add_sale").attr( "disabled", "disabled" );
               $("#add_sale_draft").attr( "disabled", "disabled" );
        }else{
            isNaN(this.value) || 0 == this.value.length || (t += parseFloat(this.value));
            $('#add_sale_another').removeAttr("disabled");
            $('#add_sale').removeAttr("disabled");
            $('#add_sale_draft').removeAttr("disabled");
        }
        
    }),   
    e = t.toFixed(2, 2);
    
    var test = +e;
    test = test-total_discount;
    $("#fld_grand_total_amount").val(test.toFixed(2, 2));
        if($("#fld_grand_total_amount").val() < 0){
               alert("Limit Exceeded.");
               $("#add_sale_another").attr( "disabled", "disabled" );
               $("#add_sale").attr( "disabled", "disabled" );
               $("#add_sale_draft").attr( "disabled", "disabled" );
        }else{
            isNaN(this.value) || 0 == this.value.length || (t += parseFloat(this.value));
            $('#add_sale_another').removeAttr("disabled");
            $('#add_sale').removeAttr("disabled");
            $('#add_sale_draft').removeAttr("disabled");
        }


    // var gt = $("#fld_grand_total_amount").val();
    // var grnt_totals = gt;
    // $("#fld_grand_total_amount").val(grnt_totals.toFixed(2));

    
}


 //Calculate store product
        "use strict";
    function calculate_store(sl) {
        var item_ctn_qty    = $("#cartoon_"+sl).val();
        var vendor_rate = $("#product_rate_"+sl).val();
        var weight = $("#product_subcat_"+sl).find(':selected').attr('data-weight');
        // alert(weight);
        
        var total_price     = (item_ctn_qty * vendor_rate);
        var total_weight = weight*item_ctn_qty;
        console.log(total_weight);
        $("#total_price_"+sl).val(total_price.toFixed(2));
        if(Number.isNaN(total_weight)){
           total_weight = 0.00
        }
        
        $("#fld_weight_"+sl).val(total_weight.toFixed(2));
        
       calculateSum();
       
        var gr_tot = 0;
        var item_ctn_qty    = $("#cartoon_"+sl).val();
        var vendor_rate = $("#product_rate_"+sl).val();
        var product_id= $("#product_id_"+sl).val();
        // console.log(product_id);
        if(parseInt(item_ctn_qty) > 0 && parseInt(vendor_rate) >= 1){
       
            buttons_function(1);
        }else{
            buttons_function(0);
        }
        if($("#fld_shipment_"+sl).val() == $("#shipment_view").val()){
            console.log($("#hweight_view").val(), total_weight);
            $("#weight_view").html(parseFloat($("#hweight_view").val()-total_weight).toFixed(2) + " (KG)");
            $("#qty_view").html(parseFloat($("#hqty_view").val()-(total_weight/1000)).toFixed(2) + " (MT)");
        }
        
      
    }
    function buttons_function(enable){
        if(enable==1){
                $('#add_sale_draft').removeAttr("disabled");
                $('#add_sale').removeAttr("disabled");
                $('#add_sale_another').removeAttr("disabled");
                
            }else{
                $("#add_sale_draft").attr( "disabled", "disabled");
                $("#add_sale").attr( "disabled" , "disabled");
                $("#add_sale_another").attr( "disabled" , "disabled");
        }
    }
    
	
	  "use strict";
      function bank_paymet(val){
        if(val==2){
           var style = ''; 
            document.getElementById('fld_bank').setAttribute("required", true);
			document.getElementById('bank_account').style.display = style;
			style = 'none';
			document.getElementById('fld_cheque_number').removeAttribute("required");
			document.getElementById('cheque_number').style.display = style;
			
			document.getElementById('fld_cheque_date').removeAttribute("required");
			document.getElementById('cheque_date').style.display = style;
        }else if(val==3){
		   var style = ''; 
            document.getElementById('fld_bank').setAttribute("required", true);
			document.getElementById('bank_account').style.display = style;
			
			document.getElementById('fld_cheque_number').setAttribute("required", true);
			document.getElementById('cheque_number').style.display = style;
			
			document.getElementById('fld_cheque_date').setAttribute("required", true);
			document.getElementById('cheque_date').style.display = style;
		}else{
		   var style ='none';
			document.getElementById('fld_bank').removeAttribute("required");
			document.getElementById('bank_account').style.display = style;
			document.getElementById('fld_cheque_number').removeAttribute("required");
			document.getElementById('cheque_number').style.display = style;
			
			document.getElementById('fld_cheque_date').removeAttribute("required");
			document.getElementById('cheque_date').style.display = style;
		}
			
    }
    
    function getBalanceVal(){
        var valid = $("#fld_customer_id option:selected").attr("accounts_id");
        var phone = $("#fld_customer_id option:selected").attr("phone");
        var email = $("#fld_customer_id option:selected").attr("email");
        $.ajax({
			url:base_url+"Vouchers/getBalance",
			type: "POST",
			data: {id:valid},
			success: function(res) {
				console.log(res);
				$("#f_balance").html("(Balance: "+res+")");
				if(phone==''){
				    $("#phone").html("(Contact number is not available to send invoice.)");
				}else{
				    $("#phone").html("(Invoice will be sent on "+phone+" via SMS.)");
				}
				if(email==''){
				    $("#email").html("(Email  is not available to send invoice.)");
				}else{
				    $("#email").html("(Invoice will be sent on "+email+" via email.)");
				}
				
				
			}
		});
		$("#latest_sales").html("");
		var customer_id = $("#fld_customer_id option:selected").val();
		$.ajax({
			url:base_url+"Sales/getLatestSales",
			type: "POST",
			data: {customer_id:customer_id},
			success: function(res) {
				var obj=JSON.parse(res);
				$("#latest_sales").html(obj.html);
				
			}
		});
    }
	
	"use strict";
      function paymet_status(val){
        if(val==3){
           var style = 'none'; 
			document.getElementById('payment_type').style.display = style;
			document.getElementById('fld_payment_type').removeAttribute("required");
			document.getElementById('fld_bank').removeAttribute("required");
			document.getElementById('bank_account').style.display = style;
			document.getElementById('fld_cheque_number').removeAttribute("required");
			document.getElementById('cheque_number').style.display = style;
			
			document.getElementById('fld_cheque_date').removeAttribute("required");
			document.getElementById('cheque_date').style.display = style;
        }else if(val==""){
			var style = 'none'; 
			document.getElementById('payment_type').style.display = style;
			document.getElementById('fld_payment_type').removeAttribute("required");
			document.getElementById('fld_bank').removeAttribute("required");
			document.getElementById('bank_account').style.display = style;
			document.getElementById('fld_cheque_number').removeAttribute("required");
			document.getElementById('cheque_number').style.display = style;
			
			document.getElementById('fld_cheque_date').removeAttribute("required");
			document.getElementById('cheque_date').style.display = style;
		}else if(val==4){
			var style = 'none'; 
			document.getElementById('payment_type').style.display = style;
			document.getElementById('fld_payment_type').removeAttribute("required");
			document.getElementById('fld_bank').removeAttribute("required");
			document.getElementById('bank_account').style.display = style;
			document.getElementById('fld_cheque_number').removeAttribute("required");
			document.getElementById('cheque_number').style.display = style;
			
			document.getElementById('fld_cheque_date').removeAttribute("required");
			document.getElementById('cheque_date').style.display = style;
		}else{
		   var style ='';
			document.getElementById('payment_type').style.display = style;
		}
			
    }
    
    function getDetailView(){
        var location=$("#fld_location").val();
		var product=$("#fld_category").val();
		if(product=='' || product==undefined || location=='' || location==undefined){
		    	$("#addPurchaseItem").html("");
				$("#stock_location_id").val("");
				$("#t_total").hide();
		}else{
        $.ajax({
			url:base_url+"Sales/getDetailView",
			dataType: "html",
			type: "POST",
			data: {location:location, product:product},
			success: function(res) {
			    console.log(res);
				var obj=JSON.parse(res);
				$("#addPurchaseItem").html(obj.html);
				$("#stock_location_id").val(location);
				$("#t_total").show();
				$(".select2").select2({
					width: '100%'
				});
				if(product == 1){
    				// $("#stock_avail").show();
				}else{
				    $("#qty_view").hide();
				    $("#weight_view").hide();
				}
				
		   var timer;
           var timeout = 2000;  // Timout duration
           //var count = 1;
           //var getit = $("#fld_location_from").filter(":selected").val();
           
           //$('#fld_location_from, #fld_location_to, #product_id, #vehicle_no, #product_id_'+count+', #sub_category_'+count+'').change(function(){
           $('#fld_customer_id, #fld_location, #fld_category, #fld_payment_type, #fld_bank,.fld_product_id').change(function(){       
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
               
            $('#fld_invoice_no, #fld_vehicle_no, .fld_shipment, .fld_quantity, #fld_discount').change(function(){  
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
    
    
    function getShipments(sl){
        	var location=$("#fld_location").val();
	    	var product=$("#fld_category").val();
	    	var sub_cat_id=$("#product_subcat_"+sl).val();
	    $.ajax({
			url:base_url+"Sales/getShipments",
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
    
    $(document).ready(function(){

           var timer;
           var timeout = 2000;  // Timout duration
           //var count = 1;
           //var getit = $("#fld_location_from").filter(":selected").val();
           var saleid = $("#sale_id").val();
           
           var path = base_url+"Sales";
           var path2 = base_url+"Sales/editDraft/"+saleid;
           var currentLocation = window.location;
           //alert(currentLocation);
           if(path == currentLocation || path2 == currentLocation){
           //$('#fld_location_from, #fld_location_to, #product_id, #vehicle_no, #product_id_'+count+', #sub_category_'+count+'').change(function(){
           $('#fld_customer_id, #fld_location, #fld_category, #fld_payment_type, #fld_bank,.fld_product_id').change(function(){       
                var selectedOption = $(this).val();
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
               
             $('#fld_invoice_no, #fld_vehicle_no, .fld_shipment, .fld_quantity, #fld_discount').change(function(){  
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

          var sale_id = $('#sale_id').val();
         
          if(sale_id == ''){
    		$.ajax({
    			data: $('#addSale').serialize(),
    			dataType: "html",
    			type: "POST",
    			url:base_url+"Sales/addSalesDraftAutosave",
    			success: function(res) {
    			    console.log(res);
    				var obj=JSON.parse(res);
    				$('#sale_id').val(obj.sale_id);
    				if(obj.responce == 'success'){
    					//$.notify(obj.message,obj.responce);	
    				// 	setTimeout(function(){ 
    				// 	window.location.href = base_url+"Purchase/manage_drafts";
    				// 	}, 3000);
    				}else{
    					//$.notify(obj.message,obj.responce);	
    					$('#add_sale_draft').prop('disabled', false);
    				}
    			}
    		})
          }else{
    		$.ajax({
    			url:base_url+"Sales/updateSaleDraftAutosave",
    			dataType: "html",
    			type: "POST",
    			data: $('#addSale,#updateDraftSale').serialize(),
    			success: function(res) {
    			    console.log(res);
    				var obj=JSON.parse(res);
    				if(obj.responce == 'success'){
    					//$.notify(obj.message,obj.responce);	
    				}else{
    					//$.notify(obj.message,obj.responce);	
    					$('#add_sale_draft').prop('disabled', false);
    				}
    			}
            })
	    }
  }
    
    $(document).on("click","#location_shipments",function(e) {
		e.preventDefault();
		console.log("Hello");
		var location=$("#fld_location").val();
		var product=$("#fld_category").val();
		$.ajax({
			url:base_url+"Sales/getShipments",
			dataType: "html",
			type: "POST",
			data: {location:location, product:product},
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
			var product=$("#fld_category").val();
		var sl = $("#selected_row_cat").val();
		$.ajax({
			url:base_url+"Sales/selectShipment",
			dataType: "html",
			type: "POST",
			data: {location:location},
			success: function(res) {
			    console.log(res);
				var obj=JSON.parse(res);
				console.log()
				$("#stock_location_id_"+sl).val(location);
				$("#cartoon_"+sl).val("1");
				$("#fld_shipment_"+sl).val(obj.shipments.fld_shipment);
				if(product == 1){
				    $("#shipment_view").val(obj.shipments.fld_shipment);
    				$("#qty_view").html(qty.toFixed(2)+" (MT)");
    				$("#weight_view").html((qty*1000).toFixed(2)+" (KG)");
    				$("#hqty_view").val(qty);
    				$("#hweight_view").val(qty*1000);
    				$("#qty_view").show();
				    $("#weight_view").show();
				}
				
				$(".bs-example-modal-lg").modal('hide');
				calculate_store(sl);
			}
		})
	});
	$(document).on("submit","#addCustomer",function(e) {
		e.preventDefault();
		$.ajax({
			data: $('#addCustomer').serialize(),
			dataType: "html",
			type: "POST",
			url:"Sales/add_ajax",
			success: function(res) {
				var obj=JSON.parse(res);
				
				if(obj.responce == 'success'){
					$.notify(obj.message,obj.responce);	
					$("#fld_customer_id").html("");
					var $dropdown = $("#fld_customer_id");
					
					$.each(obj.data.customers, function(item) {
						
						$dropdown.append($("<option />").val(this.fld_id).text(this.fld_customer_name));
					});
					$('#fld_customer_id').val(obj.data.customer_id);
					 $('#addCustomer')[0].reset();
					$("#saleDiv").show();
					$("#customerDiv").hide();
				}else{
					$.notify(obj.message,obj.responce);	
				}
			}
		})
	});
	$(document).ready(function () {

		$('#addSupplier').validate({ // initialize the plugin
			rules: {
				fld_supplier_name: {
					required: true
				},
				fld_company_name: {
					required: true
				}
			}
		});

	});
	
	
	    
	
	
	$(document).on("click","#add_sale_draft",function(e) {
// 		e.preventDefault();
		//console.log("Hello");
		 $('#add_sale_draft').prop('disabled', true);
		$.ajax({
			data: $('#addSale').serialize(),
			dataType: "html",
			type: "POST",
			url:"Sales/addSalesDraft",
			success: function(res) {
			    console.log(res);
			    var obj=JSON.parse(res);
				
				if(obj.responce == 'success'){
				// 	$.notify(obj.message,obj.responce);	
					setTimeout(function(){ 
					window.location.href = base_url+"Sales/manage_drafts";
					}, 3000);
				}else{
				// 	$.notify(obj.message,obj.responce);	
					$('#add_sale_draft').prop('disabled', false);
				}
			}
		})
	});
	$(document).on("click","#update_sale_draft",() => {
		//e.preventDefault();
		//console.log("hello");
		$('#update_sale_draft').prop('disabled', true);
		$.ajax({
			url:base_url+"Sales/updateSaleDraft",
			dataType: "html",
			type: "POST",
			data: $('#updateDraftSale').serialize(),
			success: function(res) {
				var obj=JSON.parse(res);
				
				if(obj.responce == 'success'){
					$.notify(obj.message,obj.responce);	
					setTimeout(function(){ 
					window.location.href = base_url+"Sales/manage_drafts";
					}, 3000);
				}else{
					$.notify(obj.message,obj.responce);	
					$('#update_sale_draft').prop('disabled', false);
				}
			}
		})
	});
	
function getSaleFilterDataByDate(type){
    if(type=='daily'){
        var currentdate = new Date();
        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', currentdate));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', currentdate));
        getSalereport();
    }else if(type=='weekly'){
        var currentdate = new Date();
        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', new Date(currentdate.setDate(currentdate.getDate() - currentdate.getDay()))));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', new Date(currentdate.setDate(currentdate.getDate() - currentdate.getDay()+6))));
        getSalereport();
    }else if(type=='monthly'){
        var date = new Date();
        var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
        var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', firstDay));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', lastDay));
        getSalereport();
    }else if(type=='yearly'){
        var date = new Date();
        var firstDay = new Date(date.getFullYear(), 0, 1);
        var lastDay = new Date(date.getFullYear(), 11 + 1, 0);
        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', firstDay));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', lastDay));
        getSalereport();
    }
}
	
	function getSalereport(){
	    $('#datatable_tb').DataTable().clear().destroy();
		$('#filterhtml').html("<div style='background-color: #fff;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/uploads/ajax_loading.gif' ></div></div>");
		$.ajax({
			url:base_url+"Sales/filter",
			dataType: "html",
			type: "POST",
			data: $('#saleFilter').serialize(),
			success: function(res) {
				var obj=JSON.parse(res);
				$("#filterhtml").html(obj.html);
				var table = $('#datatable').DataTable({
                    "ordering": false,
                    "pageLength": 100
                });
                table.on( 'search.dt', function () {
                    if (table.search() !== '') {
                        $('#pdf_purchase_report').prop('disabled', true);
                        $('.tablebottom').hide();
                    } else {
                        $('#pdf_purchase_report').prop('disabled', false);
                        $('.tablebottom').show();
                    }
                } );
				if(obj.count > 0){
				$('#print_report').removeAttr('disabled');
				$('#pdf_purchase_report').removeAttr('disabled');
				$('#advance_search').removeAttr('disabled');
				$('#sale_report_csv').removeAttr('disabled');
				
				}else{
				    $("#print_report").attr( "disabled", "disabled" );
				    $("#pdf_purchase_report").attr( "disabled", "disabled" );
				    $("#advance_search").attr( "disabled", "disabled" );
				    $('#sale_report_csv').attr( "disabled", "disabled" );
				}
				$('#reset_filters').removeAttr('disabled');
			}
		})
	}
	
/*	$(document).on("click","#show_report",function(e) {
		e.preventDefault();
		$('#datatable_tb').DataTable().clear().destroy();
		$('#filterhtml').html("<div style='background-color: #fff;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/uploads/ajax_loading.gif' ></div></div>");
		$.ajax({
			url:base_url+"Sales/filter",
			dataType: "html",
			type: "POST",
			data: $('#saleFilter').serialize(),
			success: function(res) {
				var obj=JSON.parse(res);
				$("#filterhtml").html(obj.html);
				var table = $('#datatable_tb').DataTable({
                    "ordering": false,
                    "pageLength": 100
                });
                table.on( 'search.dt', function () {
                    if (table.search() !== '') {
                        $('#pdf_purchase_report').prop('disabled', true);
                        $('.tablebottom').hide();
                    } else {
                        $('#pdf_purchase_report').prop('disabled', false);
                        $('.tablebottom').show();
                    }
                } );
				if(obj.count > 0){
				$('#print_report').removeAttr('disabled');
				$('#pdf_purchase_report').removeAttr('disabled');
				$('#advance_search').removeAttr('disabled');
				$('#sale_report_csv').removeAttr('disabled');
				
				}else{
				    $("#print_report").attr( "disabled", "disabled" );
				    $("#pdf_purchase_report").attr( "disabled", "disabled" );
				    $("#advance_search").attr( "disabled", "disabled" );
				    $('#sale_report_csv').attr( "disabled", "disabled" );
				}
				$('#reset_filters').removeAttr('disabled');
			}
		})
	});*/
	
	
	
	function advanceSearch(){
	    $('#filterhtml').html("<div style='background-color: #fff;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/uploads/ajax_loading.gif' ></div></div>");
	   var advancesearchform =  $('#advance-search-form').serialize();
	   var saleFilter = $('#saleFilter').serialize();
	   var finaldata = saleFilter + '&' + advancesearchform;
	    	$.ajax({
			url:base_url+"Sales/filter",
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
		var advancesearchform =  $('#advance-search-form').serialize();
	    var saleFilter = $('#saleFilter').serialize();
	    var finaldata = saleFilter + '&' + advancesearchform;
		 
		window.open(base_url + 'Sales/print_report?'+finaldata, "Sales Report", 'width=1210, height=842');
	});
	$(document).on("click","#pdf_purchase_report",function(e) {
		e.preventDefault();
		var advancesearchform =  $('#advance-search-form').serialize();
	    var saleFilter = $('#saleFilter').serialize();
	    var finaldata = saleFilter + '&' + advancesearchform;
		var url=base_url+'Sales/pdf_report?'+finaldata;
		window.open(url);
		
	});
	
	$(document).on("click","#advance_search",function(e) {
	    e.preventDefault();
	    $("#show_filters_tab").toggle();
	});
	
	$( document ).ready(function() {
        // getDetailView();
    });
	
	function calculate_sum(sb) {
		var quantity=$("#orignal_qty").val();;
		var amount=0;
		var rate=0;
		if(sb == 'mt'){
			
		$(".item_quantity").each(function() {
			
			if(this.value != ""){
				
				if(parseFloat(this.value) <= parseFloat(quantity)){
				
					rate=$(this).data('rate');
					
					isNaN(this.value) || 0 == this.value.length || (amount += parseFloat(this.value * rate))
					
					$("#fld_item_weight").val(this.value * 1000);
					$('#add_sale').prop('disabled', false);
				}else{
					alert('Limit exceed.');
					$('#add_sale').prop('disabled', true);
				}
			}
        });
		
		$("#fld_amount").val(amount);
		$("#fld_total_amount").val(amount);
		}else{
			$(".item_weight").each(function() {
				
			if(this.value != ""){
				if((parseFloat(this.value)/1000) <= parseFloat(quantity)){
					
					rate=$(this).data('rate');
					
					isNaN(this.value) || 0 == this.value.length || (amount += parseFloat((this.value/1000) * rate))
					
					$("#fld_item_qty").val(this.value / 1000);
					
				}else{
					alert('Limit exceed.');
				}
			}
        });
		
		$("#fld_amount").val(amount);
		$("#fld_total_amount").val(amount);
		}
	}
			
// 	key functions
	   $(document).keydown(function(e) {
        
                if (e.which == 121) {
            e.preventDefault();
                    $("#add_sale").click();
                    $("#show_report").click();
                }
                if (e.which == 117 ){
                    e.preventDefault();
                    $("#add_sale_another").click();
                    $("#update_sale_draft").click();
                    $("#print_report").click();
                }
                if (e.which == 118 ){
                    e.preventDefault();
                    $("#add_sale_draft").click();
                    $("#pdf_purchase_report").click();
                    
                }
                if (e.which == 119) {
            e.preventDefault();
                    $("#update_draft_purchase").click();
                    $("#advance_search").click();
                }
                
            });
	
$('#addPurchase')
		.each(function(){
			$(this).data('serialized', $(this).serialize())
		})
        .on('change input', function(){
            $(this)				
                .find('input:submit, button:submit')
                    .attr('disabled', $(this).serialize() == $(this).data('serialized'));
         })
		.find('input:submit, button:submit').attr('disabled', true);
		
function getBalance(type, rowId, valid){
        
        
        $.ajax({
			url:base_url+"Sales/getBalance",
			type: "POST",
			data: {id:valid},
			success: function(res) {
				console.log(res);
				
				if(type==0){
				    if(window.location.href.indexOf("edit") > -1 && ($("#fld_type").val() == 'CHPV' || $("#fld_type").val() == 'CPV')) 
                    {
                        var f_OrignalAmount = $("#f_OrignalAmount").val();
    				    
    				    if(parseInt(f_OrignalAmount) > 0){
    				        var f_AccountId = $("#f_AccountId").val();
    				        if(valid == f_AccountId){
    				            console.log(res.replace(/,/g, ''), f_OrignalAmount.replace(/,/g, ''));
    				            res = parseFloat((res.replace(/,/g, ''))) + parseFloat((f_OrignalAmount.replace(/,/g, '')));
    				        }
    				        
    				    }
                    }
				    $("#f_balance").html("(Balance: "+res+")");
				    $("#f_balanceInput").val(res);
				}else{
				    $("#p_balance_"+rowId).val(res);
				}
				
				calculateSum();
				
			}
		});
    }
    
    
		