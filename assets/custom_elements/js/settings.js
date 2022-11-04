var base_url=$("#base_url").val();

 var limits = 500;
        "use strict";
 $(document).ready(function(){
    $('.exampleModal').on('click', function(){
      var postID = $(this).attr('data-content');
      var datauri = $(this).attr('data-uri');
      //console.log(postID);
      $("#modal-form").attr('action', datauri);
      $('#fld_id').val(postID);
    });
    
 });
 
$(document).on("click","#show_report",function(e) {
		e.preventDefault();
		$('#datatable_tb').DataTable().clear().destroy();
		$('#filterhtml').html("<div style='background-color: #FFF;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/uploads/ajax_loading.gif' ></div></div>");
	   // return false;
	   //$('#filterhtml').html("<div style='background-color: #10163a;text-align: center;' ><div colspan='10' class='text-center' style='text-align: center;' ><img src='"+base_url+"assets/theme_elements/images/logo-sm.png' style='height:40px;'></div></div>");
		$.ajax({
			url:base_url+"Settings/filter",
			dataType: "html",
			type: "POST",
			data: $('#activityLog').serialize(),
			success: function(res) {
			    console.log(res);
				var obj=JSON.parse(res);
				$("#filterhtml").html(obj.html);
				$('#datatable_tb').DataTable({
                    "ordering": false,
                    "pageLength": 100,
                });
				if(obj.count > 0){
				// $('#datatable').DataTable({
				// 	"order": [],
				// 	"lengthMenu": [[50, 100, 500, -1], [50, 100, 500, "All"]]
				// });
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
	});