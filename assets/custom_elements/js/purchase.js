 var base_url=$("#base_url").val();
 
  $(document).ready(function(){
    $('.exampleModal').on('click', function(){
      var postID = $(this).attr('data-content');
      var datauri = $(this).attr('data-uri');
      //console.log(postID);
      $("#modal-form").attr('action', datauri);
      $('#purchase_id').val(postID);
    });
    
    $('.exampleModal2').on('click', function(){
      var postID = $(this).attr('data-content');
      var datauri = $(this).attr('data-uri');
      //console.log(postID);
      $("#modal-formdelete").attr('action', datauri);
      $('#purchase_id').val(postID);
    });
    
 });
 
 var count = 2;
    var limits = 500;
        "use strict";
    function addPurchaseOrderField1(divName){
		var category=true;
		$(".fld_product_id").each(function() {
			console.log('value'+'===='+this.value);
			if(this.value == ""){
				category =false;
			}
            //isNaN(this.value) || 0 == this.value.length || (gr_tot += parseFloat(this.value))
        });
		if(category == true){
		var products=$("#productSelect").html();
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

            newdiv.innerHTML ='<td class="span3 supplier"><select class="select2 form-control mb-3 custom-select fld_product_id" name="fld_product_id[]" onchange="product_category('+ count +');" id="product_id_'+ count +'" tabindex="'+tab1+'"><option value="">Select Product</option>'+products+'</select></td><td class="span3"><select class="select2 form-control mb-3 custom-select sub_category" onchange="check_sub_product()" name="sub_category[]" id="sub_category_'+ count +'" required><option value="0">Select Subcategory</option></select></td>  <td class="wt"> <input type="text" id="unit_code_'+ count +'" class="form-control text-center stock_ctn_'+ count +'" placeholder="Unit Code" readonly/> </td><td class="text-right"><input type="number" step="0.001" min="0"name="fld_quantity[]" tabindex="'+tab2+'" required  id="cartoon_'+ count +'" class="form-control text-right store_cal_' + count + '" onkeyup="calculate_store(' + count + ');" onchange="calculate_store(' + count + ');" placeholder="0.00" value="" min="0" onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false" oninput="validity.valid||(value=\'\');"/>  </td><td class="test"><input type="number" name="fld_unit_price[]" onkeyup="calculate_store('+ count +');" onchange="calculate_store('+ count +');" id="product_rate_'+ count +'" class="form-control product_rate_'+ count +' text-right" placeholder="0.00" value="" min="0" tabindex="'+tab3+'"  onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false" oninput="validity.valid||(value=\'\');" onkeypress="return !(event.charCode == 46)"/></td><td class="text-right"><input class="form-control total_price text-right total_price_'+ count +'" type="text" name="fld_total_amount[]" id="total_price_'+ count +'" value="0.00" readonly="readonly" /> </td><td><button style="text-align: right;" class="btn btn-danger red" type="button"  onclick="deleteRow(this)" tabindex="8"><i class="fas fa-times"></i></button></td>';
            document.getElementById(divName).appendChild(newdiv);
            document.getElementById(tabin).focus();
            var default_product_id = $("#product_id_1").val();
            $("#product_id_"+count).val(default_product_id);
            $("#product_id_"+count).attr("readonly", "readonly");
            $("#product_id_1").attr("readonly", "readonly");
            $("#product_id_"+count).change();
            product_category(count);
            count++;
            $("select.form-control:not(.dont-select-me)").select2();
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
        calculateSum();
        check_sub_product();
    }
    
    function check_sub_product(){
         var selectedSubCat = [];
        $(".sub_category").each(function() {
            console.log(this.value);
            if(this.value != ""){
                console.log("Not empty");
    		    if(selectedSubCat.includes(this.value)){
    		        alert("You cannot select same sub product multiple times.");
    		        selectedSubCat.push(this.value);
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
    
	//"use strict";
    function product_category(sl){
		var supplier_id = $('#fld_supplier_id').val();
		var product_id = $("#product_id_"+sl).val();
		var product_unit = $("#product_id_"+sl).find(':selected').attr('data-unit');
		$("#unit_code_"+sl).val(product_unit);
		
		var previousId = 0;
		var enable=true;
		$(".fld_product_id").each(function(){
			if(previousId !== 0 && this.value!=previousId){
			    enable =false;
			}
			previousId = this.value;
        });
        if(!enable){
            alert("Main Product Category should be same");
            
        // $("#product_id_"+sl).trigger('change');
        // $("select.form-control:not(.dont-select-me)").select2();
            
            buttons_function(1);
        }else{
            buttons_function(1);
        }

		 $.ajax({
                url : base_url+"Common/get_sub_category",
                method : "POST",
                data : {id: product_id},
                async : true,
                dataType : 'json',
                success: function(data){
                    var html = '<option value="">Select Sub Category</option>';
                    var i;
                    for(i=0; i<data.length; i++){
                        html += '<option value='+data[i].fld_subcid+'>'+data[i].fld_subcategory+'</option>';
                    }
                    if(product_id == 1 || data.length == 0){
                     $('#sub_category_'+sl).prop('disabled', 'disabled');
                     $('#sub_category_'+sl).css('pointer-events','none');
                     $('#sub_category_'+sl).html('<option value="0"></option>');
                    }else {
                    // $('#sub_category_'+sl).removeAttr("disabled");
                       $('#sub_category_'+sl).html(html);
                    }
                    // if(enable){
                    //     check_sub_product();
                    // }
                }
            });

        if(product_id==1){
            $("#cartoon_"+sl).attr( "step", "0.001" );
            $('#cartoon_'+sl).removeAttr("onkeypress");
        }else{
            $("#cartoon_"+sl).attr( "step", "1" );
            $("#cartoon_"+sl).attr( "onkeypress", "return !(event.charCode == 46)" );
        }
	}
	
function purchase_function(div){
		if(div == "purchasediv"){
			$("#purchasediv").show();
			$("#supplierdiv").hide();
			$("#refinerydiv").hide();
			$("#vehiclediv").hide();
		}
		
		if(div == "supplierdiv"){
			$("#supplierdiv").show();
			$("#purchasediv").hide();
			$("#refinerydiv").hide();
			$("#vehiclediv").hide();
		}
		
	}
	
	function refinery_function(div){
        if(div == "purchasediv"){
			$("#purchasediv").show();
			$("#supplierdiv").hide();
			$("#refinerydiv").hide();
			$("#vehiclediv").hide();
		}
		
		if(div == "refinerydiv"){
			$("#refinerydiv").show();
			$("#supplierdiv").hide();
			$("#purchasediv").hide();
			$("#vehiclediv").hide();
		}	
		
	}
	
	function vehicle_function(div){
        if(div == "purchasediv"){
			$("#purchasediv").show();
			$("#supplierdiv").hide();
			$("#refinerydiv").hide();
			$("#vehiclediv").hide();
		}
		
		if(div == "vehiclediv"){
			$("#vehiclediv").show();
			$("#purchasediv").hide();
			$("#supplierdiv").hide();
			$("#refinerydiv").hide();
		}	
		
	}
//Calculate Sum
    "use strict";
function calculateSum() {
      var t = 0;

         
            //Total Price
    $(".total_price").each(function () {
        isNaN(this.value) || 0 == this.value.length || (t += parseFloat(this.value))
    }),   
    e = t;

    var test = +e;
    $("#fld_grand_total_amount").val(test);


    var gt = $("#fld_grand_total_amount").val();
    var grnt_totals = gt;
    $("#fld_grand_total_amount").val(grnt_totals.toFixed(2));

    
}
 //Calculate store product
        "use strict";
    function calculate_store(sl) {
       
        var gr_tot = 0;
        var item_ctn_qty    = $("#cartoon_"+sl).val();
        var vendor_rate = $("#product_rate_"+sl).val();
        var product_id= $("#product_id_"+sl).val();
        // console.log(product_id);
        if(((product_id==1 && parseFloat(item_ctn_qty) > 0) || (product_id > 1 && parseInt(item_ctn_qty) > 0)) && parseInt(vendor_rate) >= 1){
        // if(parseFloat(item_ctn_qty) > 0){
            buttons_function(1);
        }else{
            buttons_function(0);
        }
        
        
        var total_price     = item_ctn_qty * vendor_rate;
        $("#total_price_"+sl).val(total_price.toFixed(2));

        //Total Price
        $(".total_price").each(function() {
            isNaN(this.value) || 0 == this.value.length || (gr_tot += parseFloat(this.value))
        });

        //$("#Total").val(gr_tot.toFixed(2,2));
        var grandtotal = gr_tot;
        $("#fld_grand_total_amount").val(grandtotal.toFixed(2));
    }
    
    function calculate_store_with_qty(sl) {
       
        var gr_tot = 0;
        var old_qty    = $("#old_cartoon_"+sl).val();
        var item_ctn_qty    = $("#cartoon_"+sl).val();
        var vendor_rate = $("#product_rate_"+sl).val();
        
        if(parseFloat(item_ctn_qty) > old_qty){
            $("#add_purchase").attr("disabled", "disabled");
            alert("Qty cannot be greater then old qty."+item_ctn_qty+" "+old_qty);
        }else{
            $("#add_purchase").removeAttr("disabled");
        }

        var total_price     = item_ctn_qty * vendor_rate;
        $("#total_price_"+sl).val(total_price);

        //Total Price
        $(".total_price").each(function() {
            isNaN(this.value) || 0 == this.value.length || (gr_tot += parseFloat(this.value))
        });

        //$("#Total").val(gr_tot.toFixed(2,2));
        var grandtotal = gr_tot;
        $("#fld_grand_total_amount").val(grandtotal);
    }
    
    function buttons_function(enable){
        if(enable==1){
                $('#add_purchase_draft').removeAttr("disabled");
                $('#add_purchase').removeAttr("disabled");
                $('#add_purchase_another').removeAttr("disabled");
                $('#add_order_another').removeAttr("disabled");
                $('#add_order').removeAttr("disabled");
                
            }else{
                $("#add_purchase_draft").attr( "disabled", "disabled" );
                $("#add_purchase").attr( "disabled", "disabled" );
                $("#add_purchase_another").attr( "disabled", "disabled" );
                 $("#add_order_another").attr( "disabled", "disabled" );
                  $("#add_order").attr( "disabled", "disabled" );
        }
    }
	
	  "use strict";
      function bank_paymet(val){
        if(val==2){
           var style = ''; 
            document.getElementById('fld_bank').setAttribute("required", true);
			document.getElementById('bank_account').style.display = style;
			
			 //document.getElementById('fld_account_number').setAttribute("required", true);
			//document.getElementById('account_no').style.display = style;
			style = 'none';
			document.getElementById('fld_cheque_number').removeAttribute("required");
			document.getElementById('cheque_number').style.display = style;
			
			document.getElementById('fld_cheque_date').removeAttribute("required");
			document.getElementById('cheque_date').style.display = style;
        }else if(val==3){
		   var style = ''; 
            document.getElementById('fld_bank').setAttribute("required", true);
			document.getElementById('bank_account').style.display = style;
			
			//document.getElementById('fld_account_number').setAttribute("required", true);
		//	document.getElementById('account_no').style.display = style;
			
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
			//document.getElementById('fld_account_number').removeAttribute("required", true);
			//document.getElementById('account_no').style.display = style;
			
			document.getElementById('fld_cheque_date').removeAttribute("required");
			document.getElementById('cheque_date').style.display = style;
		}
				   
			
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
	$(document).on("submit","#addSupplier",function(e) {
		e.preventDefault();
		$.ajax({
			data: $('#addSupplier').serialize(),
			dataType: "html",
			type: "POST",
			url:"Purchase/add_ajax",
			success: function(res) {
				var obj=JSON.parse(res);
				
				if(obj.responce == 'success'){
					$.notify(obj.message,obj.responce);	
					$("#fld_supplier_id").html("");
					var $dropdown = $("#fld_supplier_id");
					
					$.each(obj.data.suppliers, function(item) {
						
						$dropdown.append($("<option />").val(this.fld_id).attr("data_set",this.fld_company_name).text(this.fld_company_name));
					});
					$('#fld_supplier_id').val(obj.data.supplier_id);
					 $('#addSupplier')[0].reset();
					$("#purchasediv").show();
					$("#supplierdiv").hide();
				}else{
					$.notify(obj.message,obj.responce);	
				}
			}
		})
	});
	$(document).on("submit","#addRefinery",function(e) {
		e.preventDefault();
		$.ajax({
			data: $('#addRefinery').serialize(),
			dataType: "html",
			type: "POST",
			url:"Purchase/add_ajax_refinery",
			success: function(res) {
				var obj=JSON.parse(res);
				
				if(obj.responce == 'success'){
					$.notify(obj.message,obj.responce);	
					$("#refinery").html("");
					var $dropdown = $("#refinery");
					
					$.each(obj.data.refinery, function(item) {
						
						$dropdown.append($("<option />").val(this.fld_id).attr("data_set",this.fld_name).text(this.fld_name));
					});
					$('#refinery').val(obj.data.refinery_id);
					 $('#addRefinery')[0].reset();
					$("#purchasediv").show();
					$("#refinerydiv").hide();
					updateValue();
				}else{
					$.notify(obj.message,obj.responce);	
				}
			}
		})
	});
	$(document).on("submit","#addVehicle",function(e) {
		e.preventDefault();
		$.ajax({
			data: $('#addVehicle').serialize(),
			dataType: "html",
			type: "POST",
			url:"Purchase/add_ajax_vehicle",
			success: function(res) {
				var obj=JSON.parse(res);
				
				if(obj.responce == 'success'){
					$.notify(obj.message,obj.responce);	
					$("#vehicle_no").html("");
					var $dropdown = $("#vehicle_no");
					
					$.each(obj.data.transporter, function(item) {
						
						$dropdown.append($("<option />").val(this.fld_id).attr("data_set",this.fld_vehicle_number).text(this.fld_vehicle_number));
					});
					$('#vehicle_no').val(obj.data.vehicle_id);
					 $('#addVehicle')[0].reset();
					$("#purchasediv").show();
					$("#vehiclediv").hide();
					updateValue();
				}else{
					$.notify(obj.message,obj.responce);	
				}
			}
		})
	});
	
	function updateValue(){
        
        var supplier = $("#fld_supplier_id").find(':selected').attr("data_set") || '';
        var purchase_date = $("#fld_purchase_date").val() || '';
        var refinery = $("#refinery").find(':selected').attr("data_set") || '';
        var vehicle_no = $("#vehicle_no").find(':selected').attr("data_set") || '';
        
        var date = new Date(purchase_date.split("/").reverse().join("-"));
        //return date.getDate() + '-' + (date.getMonth() + 1) + '-' + date.getFullYear();
        
        if(refinery == ''){
            refinery = '--';
        }
        if(vehicle_no == ''){
            vehicle_no = '--';
        }

        total = '';
        total = supplier + '/' + refinery + '/' + vehicle_no + '/' + date.getDate()  + '-' + (date.getMonth() + 1)+ '-' + date.getFullYear();
        console.log("supplier", supplier, "date", date, "refinery", refinery, "vehicle_no", vehicle_no);
       // console.log("supplier", supplier, "date", date, "refinery", refinery, "vehicle_no", vehicle_no, "Present", presentdays, "Absent", absentdays , "Per Day", perdaysalary , "Basic Sel", basicsalary);
       if (supplier != ''){
           $("#fld_shipment").val(total);
       }else{
           total = '';
       }
    
}
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
	
  $(document).ready(function(){
           var timer;
           var timeout = 1000;  // Timout duration
           var count = 1;
           //var getit = $("#fld_supplier_id").filter(":selected").val();
           //var getit1 = $("#refinery").filter(":selected").val();
           //var fld_location = $("#fld_location").filter(":selected").val();
           //var vehicle_no = $("#vehicle_no").filter(":selected").val();
           //var product_id = $("#product_id_"+sl).val();
		   // var product_unit = $("#product_id_"+sl).filter(':selected').val();
		   var purchaseid = $("#purchase_id").val();
           
           
           var path = base_url+"Purchase";
           var path2 = base_url+"Purchase/editDraft/"+purchaseid;
           var currentLocation = window.location;
           //alert(path2);
           if(path == currentLocation || path2 == currentLocation){
           
           $('#fld_supplier_id, #refinery, #fld_location, #vehicle_no, #product_id_'+count+', #sub_category_'+count+',#fld_invoice_no, #cartoon_'+count+',#product_rate_'+count+'').change(function(){
                var selectedOption = $(this).val();
                // $(this).val('')   
                // alert(selectedOption);
                // return false;
                // if(timer) {
                //     clearTimeout(timer);
                // }
                //     timer = setTimeout(saveData, timeout); 
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
               
            //  $('#fld_invoice_no, #cartoon_'+count+',#product_rate_'+count+'').change(function(){  

            //         saveData();
            //         $('.ml3').css('display','block');
            //         var textWrapper = document.querySelector('.ml3');
            //         textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");
                    
            //         anime.timeline({loop: true})
            //           .add({
            //             targets: '.ml3 .letter',
            //             opacity: [0,1],
            //             easing: "easeInOutQuad",
            //             duration: 2250,
            //             delay: (el, i) => 150 * (i+1)
            //           }).add({
            //             targets: '.ml3',
            //             opacity: 0,
            //             duration: 1000,
            //             easing: "easeOutExpo",
            //             delay: 1000
            //           });
                    
            //  });
           }      
        
  });	
  
  function saveData(){
	    //$('#add_purchase_draft').prop('disabled', true);
	    // var fld_supplier_id = $("#fld_supplier_id").filter(":selected").val();
         //var refinery = $("#refinery").filter(":selected").val();
          var purchase_id = $('#purchase_id').val();
         
          if(purchase_id == ''){
    		$.ajax({
    			data: $('#addPurchase').serialize(),
    			dataType: "html",
    			type: "POST",
    			url:"Purchase/addPurchaseDraftAutosave",
    			success: function(res) {
    				var obj=JSON.parse(res);
    				$('#purchase_id').val(obj.purchase_id);
    				if(obj.responce == 'success'){
    					//$.notify(obj.message,obj.responce);	
    				// 	setTimeout(function(){ 
    				// 	window.location.href = base_url+"Purchase/manage_drafts";
    				// 	}, 3000);
    				}else{
    					//$.notify(obj.message,obj.responce);	
    					$('#add_purchase_draft').prop('disabled', false);
    				}
    			}
    		})
          }else{
    		//alert(purchase_id);
    		$.ajax({
    			url:base_url+"Purchase/updatePurchaseDraftAutosave",
    			dataType: "html",
    			type: "POST",
    			data: $('#addPurchase,#updateDraftPurchase').serialize(),
    			success: function(res) {
    				var obj=JSON.parse(res);
    				if(obj.responce == 'success'){
    					//$.notify(obj.message,obj.responce);	
    				}else{
    					//$.notify(obj.message,obj.responce);	
    					$('#add_purchase_draft').prop('disabled', false);
    				}
    			}
            })
	    }
  }
   
	
  $(document).on("click","#add_purchase_draft",function(e) {
		e.preventDefault();
		
		$('#add_purchase_draft').prop('disabled', true);
		$.ajax({
			data: $('#addPurchase').serialize(),
			dataType: "html",
			type: "POST",
			url:"Purchase/addPurchaseDraft",
			success: function(res) {
				var obj=JSON.parse(res);
				
				if(obj.responce == 'success'){
					$.notify(obj.message,obj.responce);	
					setTimeout(function(){ 
					window.location.href = base_url+"Purchase/manage_drafts";
					}, 3000);
				}else{
					$.notify(obj.message,obj.responce);	
					$('#add_purchase_draft').prop('disabled', false);
				}
			}
		})
	});
	$(document).on("click","#update_draft_purchase",function(e) {
		e.preventDefault();
		$('#update_draft_purchase').prop('disabled', true);
		$.ajax({
			url:base_url+"Purchase/updatePurchaseDraft",
			dataType: "html",
			type: "POST",
			data: $('#updateDraftPurchase').serialize(),
			success: function(res) {
				var obj=JSON.parse(res);
				
				if(obj.responce == 'success'){
					$.notify(obj.message,obj.responce);	
					setTimeout(function(){ 
					window.location.href = base_url+"Purchase/manage_drafts";
					}, 3000);
				}else{
					$.notify(obj.message,obj.responce);	
					$('#update_draft_purchase').prop('disabled', false);
				}
			}
		})
	});
	
	function getPurchaseFilterDataByDate(type){
    if(type=='daily'){
        var currentdate = new Date();
        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', currentdate));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', currentdate));
        getpurchasefilter();
    }else if(type=='weekly'){
        var currentdate = new Date();
        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', new Date(currentdate.setDate(currentdate.getDate() - currentdate.getDay()))));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', new Date(currentdate.setDate(currentdate.getDate() - currentdate.getDay()+6))));
        getpurchasefilter();
    }else if(type=='monthly'){
        var date = new Date();
        var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
        var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', firstDay));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', lastDay));
        getpurchasefilter();
    }else if(type=='yearly'){
        var date = new Date();
        var firstDay = new Date(date.getFullYear(), 0, 1);
        var lastDay = new Date(date.getFullYear(), 11 + 1, 0);

        $("#from_date").val($.datepicker.formatDate('dd/mm/yy', firstDay));
        $("#to_date").val($.datepicker.formatDate('dd/mm/yy', lastDay));
        getpurchasefilter();
    }
}

function getpurchasefilter(){
    $('#datatable_tb').DataTable().clear().destroy();
		$('#filterhtml').html("<div style='background-color: #FFF;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/uploads/ajax_loading.gif' ></div></div>");
	    $.ajax({
			url:base_url+"Purchase/filter",
			dataType: "html",
			type: "POST",
			data: $('#purchasefilter').serialize(),
			success: function(res) {
			    console.log(res);
				var obj=JSON.parse(res);
				$("#filterhtml").html(obj.html);
				var table = $('#datatable_tb').DataTable({
                    "ordering": false,
                    "pageLength": 100
                });
                table.on( 'search.dt', function () {
                    if (table.search() != '') {
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
				$('#purchase_report_csv').removeAttr('disabled');
				
				}else{
				    $("#print_report").attr( "disabled", "disabled" );
				    $("#pdf_purchase_report").attr( "disabled", "disabled" );
				    $("#advance_search").attr( "disabled", "disabled" );
				    $('#purchase_report_csv').attr( "disabled", "disabled" );
				}
				$('#reset_filters').removeAttr('disabled');
			}
		})
}
	
// 	$(document).on("click","#show_report",function(e) {
// 		e.preventDefault();
// 		$('#datatable_tb').DataTable().clear().destroy();
// 		$('#filterhtml').html("<div style='background-color: #FFF;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/uploads/ajax_loading.gif' ></div></div>");
// 	   $.ajax({
// 			url:base_url+"Purchase/filter",
// 			dataType: "html",
// 			type: "POST",
// 			data: $('#purchasefilter').serialize(),
// 			success: function(res) {
// 			    console.log(res);
// 				var obj=JSON.parse(res);
// 				$("#filterhtml").html(obj.html);
// 				var table = $('#datatable_tb').DataTable({
//                     "ordering": false,
//                     "pageLength": 100
//                 });
//                 table.on( 'search.dt', function () {
//                     if (table.search() != '') {
//                         $('#pdf_purchase_report').prop('disabled', true);
//                         $('.tablebottom').hide();
//                     } else {
//                         $('#pdf_purchase_report').prop('disabled', false);
//                         $('.tablebottom').show();
//                     }
//                 } );
// 				if(obj.count > 0){
// 				$('#print_report').removeAttr('disabled');
// 				$('#pdf_purchase_report').removeAttr('disabled');
// 				$('#advance_search').removeAttr('disabled');
// 				$('#purchase_report_csv').removeAttr('disabled');
				
// 				}else{
// 				    $("#print_report").attr( "disabled", "disabled" );
// 				    $("#pdf_purchase_report").attr( "disabled", "disabled" );
// 				    $("#advance_search").attr( "disabled", "disabled" );
// 				    $('#purchase_report_csv').attr( "disabled", "disabled" );
// 				}
// 				$('#reset_filters').removeAttr('disabled');
// 			}
// 		})
// 	});
	
	
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
		var etype = $('#filter').val();
		var type = $('#filter_type').val();
		 
		window.open(base_url + 'purchase/print_report?filter='+etype+'&type='+type, "Purchase Report", 'width=1210, height=842');
		var table = $('#datatable').DataTable();
	});
	$(document).on("click","#pdf_purchase_report",function(e) {
		e.preventDefault();
		if($('.purchaseRows tr').length > 0){
		var formdata=$('#purchasefilter').serialize();
		var fromDate = $('#from_date').val();
		var toDate = $('#to_date').val();			
		var etype = $('#filter').val();
		var type = $('#filter_type').val();
		var url=base_url+'purchase/print_purchase_report?'+formdata;
		window.open(url);
		}
	});
	
	$(document).on("click","#advance_search",function(e) {
	    e.preventDefault();
	    $("#show_filters_tab").toggle();
	});
	
	
// 	key functions
$(document).keydown(function(e) {
        
    if (e.which == 121) {
        e.preventDefault();
        $("#add_purchase").click();
        $("#add_order").click();
        $("#show_report").click();
    }
    if (e.which == 117 ){
        e.preventDefault();
        $("#add_purchase_another").click();
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

$('#editpurchase')
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
		