var base_url=$("#base_url").val();

$(document).ready(function(){
    $('.exampleModal').on('click', function(){
      var postID = $(this).attr('data-content');
      var datauri = $(this).attr('data-uri');
      //console.log(postID);
      $("#modal-form").attr('action', datauri);
      $('#entry_id').val(postID);
    });
    
});

// for vehicle in add entry
$(document).on('change', '#fld_vehicle', function(event) {
let drivername = event.target.selectedOptions[0].getAttribute("data_driver");
//let stamp = event.target.selectedOptions[0].getAttribute("data_stamp");

document.getElementById("driver_name").value = drivername;
//document.getElementById("personCompany_byco").innerHTML = cname;
//document.getElementById("stampphoto_byco").src = base_url+'assets/uploads/companies/'+stamp;
});