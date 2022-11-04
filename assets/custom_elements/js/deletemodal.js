 var base_url=$("#base_url").val();
 
  $(document).ready(function(){
    $('.exampleModal').on('click', function(){
      var postID = $(this).attr('data-content');
      var datauri = $(this).attr('data-uri');
      //console.log(postID);
      $("#modal-form").attr('action', datauri);
      $('#partner_id').val(postID);
    });
    
    $('.exampleModal2').on('click', function(){
      var postID = $(this).attr('data-content');
      var datauri = $(this).attr('data-uri');
      //console.log(postID);
      $("#modal-formdelete").attr('action', datauri);
      $('#purchase_id').val(postID);
    });
    
 });