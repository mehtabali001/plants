 var base_url=$("#base_url").val();
 
   $(document).ready(function(){
    $('.exampleModal').on('click', function(){
      var postID = $(this).attr('data-content');
      var datauri = $(this).attr('data-uri');
      //console.log(postID);
      $("#modal-form").attr('action', datauri);
      $('#complaint_id').val(postID);
    });
});
function bsload(){
    $('#addcomplaintform').html("<div class='row' style='width:100%;'><img src='"+base_url+"assets/uploads/ajax_loading.gif' style='margin:auto;'></div>");
}

function complaint_function(div){
		if(div == "addcomplaint"){
			$("#addcomplaint").show();
			$("#categorydiv").hide();
		}
		
		if(div == "categorydiv"){
			$("#categorydiv").show();
			$("#addcomplaint").hide();
		}
		
}
function viewInfo(username,email,mobile,designatio){
		
		$("#complainer_name").val(username);
		$("#designation").val(designatio);
		$("#phone_number").val(mobile);
		$("#email").val(email);
		$("#viewInfo").modal("show");
		
}
$(document).on("submit","#addComplaintCat",function(e) {
		e.preventDefault();
		$.ajax({
			type: "POST",
			url:base_url+"Complaints/add_ajax_category",
			data: $('#addComplaintCat').serialize(),
			success: function(res) {
				var obj=JSON.parse(res);
				
				if(obj.responce == 'success'){
					$.notify(obj.message,obj.responce);	
					$("#comp_category").html("");
					var $dropdown = $("#comp_category");
					
					$.each(obj.data.categories, function(item) {
						
						$dropdown.append($("<option />").val(this.id ).attr("data_set",this.category_name).text(this.category_name));
					});
					$('#comp_category').val(obj.data.category_id);
					 $('#addComplaintCat')[0].reset();
					$("#addcomplaint").show();
					$("#categorydiv").hide();
					
				}else{
					$.notify(obj.message,obj.responce);	
				}
			}
		})
	});
	$(document).on("submit","#addcomplaintform",function(e) {
		e.preventDefault();
//  		$('#cardbody').html("<div class='row' style='width:100%;'><img src='"+base_url+"assets/uploads/ajax_loading.gif' style='margin:auto;'></div>");
$(".preloader").show();
		$.ajax({
			type: "POST",
			url:base_url+"Complaints/addComplaint",
			data: $('#addcomplaintform').serialize(),
			success: function(res) {
				var obj=JSON.parse(res);
				
				if(obj.responce == 'success'){
					$.notify(obj.message,obj.responce);	
					 $('#addcomplaintform')[0].reset();
					setTimeout(function() { 
						window.location = base_url+"Complaints/my_complaints";
					}, 2000);
				}else{
					$.notify(obj.message,obj.responce);	
				}
			}
		})
	});
	$(document).on("submit","#updatecomplaintform",function(e) {
		e.preventDefault();
		$(".preloader").show();
		$.ajax({
			type: "POST",
			url:base_url+"Complaints/UpdateComplaint",
			data: $('#updatecomplaintform').serialize(),
			success: function(res) {
				var obj=JSON.parse(res);
				
				if(obj.responce == 'success'){
					$.notify(obj.message,obj.responce);
					setTimeout(function() { 
						window.location = base_url+"Complaints/my_complaints";
					}, 2000);
				}else{
					$.notify(obj.message,obj.responce);	
				}
			}
		})
	});
	$(document).on("submit","#resolvecomplaintform",function(e) {
		e.preventDefault();
		$.ajax({
			type: "POST",
			url:base_url+"Complaints/ResolveComplaint",
			data: $('#resolvecomplaintform').serialize(),
			success: function(res) {
				var obj=JSON.parse(res);
				
				if(obj.responce == 'success'){
					$.notify(obj.message,obj.responce);
					window.location = base_url+"Complaints/assigned_complaints";
					
					
				}else{
					$.notify(obj.message,obj.responce);	
				}
			}
		})
	});
	function showRecord(filter){
		$('#datatable_tb').DataTable().clear().destroy();
		$('#filterhtml').html("<div style='background-color: #FFF;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/uploads/ajax_loading.gif' ></div></div>");
		$.ajax({
			type: "POST",
			url:base_url+"Complaints/filter",
			data: {filter:filter},
			success: function(res) {
				var obj=JSON.parse(res);
				$("#filterhtml").html(obj.html);
				$('#datatable_tb').DataTable({
                    "ordering": false,
                    "pageLength": 100
                });
			}
		})
}
function showassignRecord(filter){
		$('#datatable_tb').DataTable().clear().destroy();
		$('#filterhtml').html("<div style='background-color: #FFF;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/uploads/ajax_loading.gif' ></div></div>");
		$.ajax({
			type: "POST",
			url:base_url+"Complaints/assignfilter",
			data: {filter:filter},
			success: function(res) {
				var obj=JSON.parse(res);
				$("#filterhtml").html(obj.html);
				$('#datatable_tb').DataTable({
                    "ordering": false,
                    "pageLength": 100
                });
			}
		})
}
	$(document).on("click",".resolveCompl",function(e) {
		$("#edit_id").val($(this).data('id'));
		$("#status").modal("show");
	});