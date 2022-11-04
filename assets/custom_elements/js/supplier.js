$(document).ready(function(){
    $('.exampleModal').on('click', function(){
      var postID = $(this).attr('data-content');
      var datauri = $(this).attr('data-uri');
      //console.log(postID);
      $("#modal-form").attr('action', datauri);
      $('#supplier_id').val(postID);
    });
    
 });


$('#edit_supplier')
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

$('#addExpense')
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