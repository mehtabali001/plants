/**
 * Theme: Metrica - Responsive Bootstrap 4 Admin Dashboard
 * Author: Mannatthemes
 * Datatables Js
 */

 
$(document).ready(function() {
  //$('#datatable').DataTable();
  
  function filterGlobal () {
    $('#datatable').DataTable().search( 
        $('#global_filter').val(),
        $('#global_regex').prop('checked'), 
        $('#global_smart').prop('checked')
    ).draw();
}
 
function filterColumn ( i ) {
    $('#datatable').DataTable().column( i ).search( 
        $('#col'+i+'_filter').val(),
        $('#col'+i+'_regex').prop('checked'), 
        $('#col'+i+'_smart').prop('checked')
    ).draw();
}
 
$(document).ready(function() {
    $('#datatable').DataTable();
 
    $('input.global_filter').on( 'keyup click', function () {
        filterGlobal();
    } );
 
    // $('input.column_filter').on( 'keyup click', function () {
    //     filterColumn( $(this).parents('div').attr('data-column') );
    // } );
} );

  $(document).ready(function() {
      $('#datatable2').DataTable({
    order: [[0, 'desc']],
    "scrollX": true,
    dom: "<'row'<'col-sm-12'p><'col-sm-6'l><'col-sm-6'f>>" +
"<'row'<'col-sm-12'tr>>" +
"<'row'<'col-sm-5'i><'col-sm-7'p>>",
language: {
    'paginate': {
      'previous': '<span class="previouspage"><</span>',
      'next': '<span class="nextpage">></span>'
    }
  }
});  
  } );

  //Buttons examples
  var table = $('#datatable-buttons').DataTable({
      lengthChange: false,
      buttons: ['copy', 'excel', 'pdf', 'colvis']
  });

  table.buttons().container()
      .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');

      $('#row_callback').DataTable( {
        "createdRow": function ( row, data, index ) {
            if ( data[5].replace(/[\$,]/g, '') * 1 > 150000 ) {
                $('td', row).eq(5).addClass('highlight');
            }
        }
    } );
    
} );

/* Formatting function for row details - modify as you need */
function format ( d ) {
    // `d` is the original data object for the row
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td>Full name:</td>'+
            '<td>'+d.name+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Extension number:</td>'+
            '<td>'+d.extn+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Extra info:</td>'+
            '<td>And any further details here (images etc)...</td>'+
        '</tr>'+
    '</table>';
}
 
$(document).ready(function() {
    var table = $('#child_rows').DataTable( {
        // "ajax": "../../plugins/datatables/objects.txt",
        "data": testdata.data,
        select:"single",
        "columns": [
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            { "data": "name" },
            { "data": "position" },
            { "data": "office" },
            { "data": "salary" }
        ],
        "order": [[1, 'asc']]
    } );
     
    // Add event listener for opening and closing details
    $('#child_rows tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
 
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    } );
} );

var testdata = {
    "data": [
    {
    "name": "Tiger Nixon",
    "position": "System Architect",
    "salary": "$320,800",
    "start_date": "2011/04/25",
    "office": "Edinburgh",
    "extn": "5421"
    },
    {
    "name": "Garrett Winters",
    "position": "Accountant",
    "salary": "$170,750",
    "start_date": "2011/07/25",
    "office": "Tokyo",
    "extn": "8422"
    },
    {
    "name": "Ashton Cox",
    "position": "Junior Technical Author",
    "salary": "$86,000",
    "start_date": "2009/01/12",
    "office": "San Francisco",
    "extn": "1562"
    },]}