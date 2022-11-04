
var base_url=$("#base_url").val();
$(document).keydown(function(e) {
    if (e.which == 118 ){
        e.preventDefault();
        $("#pdf_customer_report").click();
    }
    
                
});
$(document).on("click","#pdf_customer_report",function(e) {
		e.preventDefault();
		if($('.customerRows tr').length > 0){
		var formdata=$('#customerLedgerfilter').serialize();
		var fromDate = $('#from_date').val();
		var toDate = $('#to_date').val();			
		var url=base_url+'Customers/print_customers_report?'+formdata;
		window.open(url);
		}
	});
	

    $(document).ready(function(){
    $('.exampleModal').on('click', function(){
      var postID = $(this).attr('data-content');
      var datauri = $(this).attr('data-uri');
      //console.log(postID);
      $("#modal-form").attr('action', datauri);
      $('#customer_id').val(postID);
    });
 });
