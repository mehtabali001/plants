 var base_url=$("#base_url").val();
 var count = $("#countRow").val();
    var limits = 500;
        "use strict";
        $(document).keydown(function(e) {
                if (e.which == 121) {
            e.preventDefault();
                    $("#add_vourcher").click();
                    $("#edit_vourcher").click();
                }
            });
    function addRow(){
        var category=true;
		$(".sel_account_id").each(function() {
			if( this.value == ""){
				category =false;
			}
        });
		if(category == true){
		var accounts=$("#accountSelect").html();
           
            newdiv = document.createElement("tr");

            newdiv.innerHTML ='<td class="span3"><input type="text" id="coa_id_'+count+'" name="coa_id[]" class="form-control text-center" placeholder="Code" readonly></td><td class="span3"><select class="select2 form-control mb-3 custom-select sel_account_id" onchange="inputCode('+count+', this.value)" name="account_id" id="account_id_'+count+'" required><option value="">Select Account</option>'+accounts+'</select></td><td class="span3"><div class="input-group"><input type="text" class="form-control form-control-sm" id="narration_'+count+'" name="narration[]"  placeholder="Payment\'s nature and description"><div class="input-group-append"><button type="button" class="btn tooltip1 btn-outline-light btn-sm btn-clipboard" onclick="copy2('+count+')"  data-clipboard-action="copy" data-clipboard-target="#clipboardInput"  onmouseout="outFunc('+count+')"><span class="tooltiptext" id="copyTooltip_'+count+'">Copy this narration</span><i class="far fa-copy"></i></button><button type="button" class="btn tooltip1 btn-outline-light btn-sm btn-clipboard"  onclick="paste('+count+')" onmouseout="outFunc('+count+')"><span class="tooltiptext" id="pasteTooltip_'+count+'">Paste copied narration</span><i class="far fa-clipboard"></i></button></div></div></td><td class="span3"><input type="text" id="p_balance_'+count+'" name="p_balance[]" class="form-control text-center" placeholder="0.00" readonly></td><td class="test"><input type="number" step="0.01" oninput="validity.valid||(value=\'\');" name="amount[]" required=""  id="amount_'+count+'" class="form-control amount text-right" onkeyup="calculateSum()" onchange="calculateSum()" placeholder="0.00" value="" min="0" required></td><td><button class="btn btn-danger text-right red" type="button" value="Delete" onclick="deleteRow(this)" ><i class="fas fa-times"></i></button></td>';
            document.getElementById("voucher_details").appendChild(newdiv);
            
            $("#account_id_"+count).select2();
            
            count++;

            // $("select.form-control:not(.dont-select-me)").select2({
            //     placeholder: "Select option",
            //     allowClear: true
            // });
		}else{
			alert('Please select account first. !');
		}
        
		
    }
    
    function addRowJv(){
        var category=true;
		$(".sel_account_id").each(function() {
			if( this.value == ""){
				category =false;
			}
        });
		if(category == true){
		var accounts=$("#accountSelect").html();
           
            newdiv = document.createElement("tr");

            newdiv.innerHTML ='<td class="span3"><input type="text" id="coa_id_'+count+'" name="coa_id[]" class="form-control text-center" placeholder="Code" readonly></td><td class="span3"><select class="select2 form-control mb-3 custom-select sel_account_id" onchange="inputCode('+count+', this.value)" name="account_id" id="account_id_'+count+'" required><option value="">Select Account</option>'+accounts+'</select></td><td class="span3"><div class="input-group"><input type="text" class="form-control form-control-sm" id="narration_'+count+'" name="narration[]"  placeholder="Payment\'s nature and description"><div class="input-group-append"><button type="button" class="btn tooltip1 btn-outline-light btn-sm btn-clipboard" onclick="copy2('+count+')"  data-clipboard-action="copy" data-clipboard-target="#clipboardInput"  onmouseout="outFunc('+count+')"><span class="tooltiptext" id="copyTooltip_'+count+'">Copy this narration</span><i class="far fa-copy"></i></button><button type="button" class="btn tooltip1 btn-outline-light btn-sm btn-clipboard"  onclick="paste('+count+')" onmouseout="outFunc('+count+')"><span class="tooltiptext" id="pasteTooltip_'+count+'">Paste copied narration</span><i class="far fa-clipboard"></i></button></div></div></td><td class="span3"><input type="text" id="p_balance_'+count+'" name="p_balance[]" class="form-control text-center" placeholder="0.00" readonly></td><td class="test"><input type="number" step="0.01" oninput="validity.valid||(value=\'\');" name="debit[]"  id="debit_'+count+'" class="form-control debit text-right" onkeyup="calculateSum()" onchange="calculateSum()" placeholder="0.00" value="" min="0"></td><td class="test"><input type="number" step="0.01" oninput="validity.valid||(value=\'\');" name="credit[]"  id="credit_'+count+'" class="form-control credit text-right" onkeyup="calculateSum()" onchange="calculateSum()" placeholder="0.00" value="" min="0"></td><td><button class="btn btn-danger text-right red" type="button" value="Delete" onclick="deleteRow(this)" ><i class="fas fa-times"></i></button></td>';
            document.getElementById("voucher_details").appendChild(newdiv);
            
            $("#account_id_"+count).select2();
            
            count++;

            // $("select.form-control:not(.dont-select-me)").select2({
            //     placeholder: "Select option",
            //     allowClear: true
            // });
		}else{
			alert('Please select account first. !');
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

//Calculate Sum
    "use strict";
function calculateSum() {
      var t = 0;

            //Total Price
    $(".amount").each(function () {
        isNaN(this.value) || 0 == this.value.length || (t += parseFloat(this.value))
    }),   
    e = t.toFixed(2, 2);

    var test = +e;
    $("#total_amount").val(test.toFixed(2, 2));


    var gt = $("#total_amount").val();
    var grnt_totals = gt;
    $("#total_amount").val(grnt_totals);

    if($("#fld_type").val() == 'CHPV' || $("#fld_type").val() == 'CPV'){
        console.log('1');
        var balanceAvailable = $("#f_balanceInput").val();
        if(parseFloat(grnt_totals) > parseFloat((balanceAvailable.replace(/,/g, '')))){
            console.log('2', balanceAvailable.replace(/,/g, ''));
             $("#add_vourcher").attr( "disabled", "disabled" );
             $("#edit_vourcher").attr( "disabled", "disabled" );
        }else{
            console.log('3');
            $('#add_vourcher').removeAttr("disabled");
            $('#edit_vourcher').removeAttr("disabled");
            
        }
    }


    var t = 0;

            //Total Price
    $(".debit").each(function () {
        var row_id = parseInt((this.id.replace('debit_','')));
        if(this.value != ''){
            $("#credit_"+row_id).attr('readonly', 'readonly');
        }else{
            $("#credit_"+row_id).removeAttr("readonly");
        }
        isNaN(this.value) || 0 == this.value.length || (t += parseFloat(this.value))
    }),   
    e = t.toFixed(2, 2);

    var test = +e;
    $("#total_amount_debit").val(test.toFixed(2, 2));


    var gt = $("#total_amount_debit").val();
    var grnt_totals = gt;
    $("#total_amount_debit").val(grnt_totals);
    
    var t = 0;

            //Total Price
    $(".credit").each(function () {
        var row_id = parseInt((this.id.replace('credit_','')));
        if(this.value != ''){
            $("#debit_"+row_id).attr('readonly', 'readonly');
        }else{
            $("#debit_"+row_id).removeAttr("readonly");
        }
        isNaN(this.value) || 0 == this.value.length || (t += parseFloat(this.value))
    }),   
    e = t.toFixed(2, 2);

    var test = +e;
    $("#total_amount_credit").val(test.toFixed(2, 2));


    var gt = $("#total_amount_credit").val();
    var grnt_totals = gt;
    $("#total_amount_credit").val(grnt_totals);
    
}
    
    function inputCode(sl, val){
        $("#coa_id_"+sl).val(val);
        getBalance(1, sl, val);
    }
    
    function getBalance(type, rowId, valid){
        
        
        $.ajax({
			url:base_url+"Vouchers/getBalance",
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
    $(document).on("change","#jv_voucher_history",function() {
		var url= $(this).find(':selected').attr('data-link');
		window.open(url, '_blank ');
    });
    
	