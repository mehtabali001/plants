<? $settings=$this->db->query("SELECT * FROM tbl_general_settings WHERE setting_id = 1")->row_array();?>
 <footer class="footer text-center text-sm-left">
                  <!--Current Version is 0.0.6 (Last Updated 20/10/21) <span class="text-muted d-none d-sm-inline-block float-right">   &copy;  <script>document.write(new Date().getFullYear())</script>-<?=$settings['system_name'];?></span>-->
                </footer><!--end footer-->
            </div>
            <!-- end page content -->
        </div>
        <!-- end page-wrapper -->

        <!-- jQuery  -->
        <?php
		$this->load->view('includes/layouts.js.php');
		?>
		<?php if($this->uri->segment(1) == 'home'){ ?>
		<script>
        $('body').addClass('enlarge-menu');
        </script>
		<? } ?>
		
<script>
function removeMenu() {
        $('body').addClass('enlarge-menu');
}
</script>
<script>
// $('#datatable_tb').DataTable().clear().destroy();
var table = $('#datatable_tb').DataTable({
        "ordering": true,
        "pageLength": 100,
        "scrollX": true,
        //"dom": 'lpftrip',
        //"sDom": '<"top"flpi>rt</div><"bottom"><"clear">',
        //"sDom": '<"top"flp>rt<"bottom"i><"clear">',
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
</script>
		
		
 		<script>
// // 		table2.destroy();
// 		$('#datatable').DataTable().clear().destroy();
// 		  var table2 =  $('#datatable').DataTable({
//                     "pageLength": 100
//                 });
// 		</script>
		<script>
		   function paste(sl) {
     navigator.clipboard.readText()

  // (A2) PUT CLIPBOARD INTO TEXT FIELD
  .then(txt => {
    document.getElementById("narration_"+sl).value = txt;
    var tooltip_3 = document.getElementById("pasteTooltip_"+sl);
  tooltip_3.innerHTML = "Pasted ";
  })

  // (A3) OPTIONAL - CANNOT ACCESS CLIPBOARD
  .catch(err => {
    alert("Please allow clipboard access permission");
  });
  
}
		</script>
	<script>
		   function paste_duplicate_table(sl) {
     navigator.clipboard.readText()

  // (A2) PUT CLIPBOARD INTO TEXT FIELD
  .then(txt => {
    document.getElementById("narration_"+sl).value = txt;
    var tooltip_duplicate_paste = document.getElementById("pasteTooltip_duplicate_table_"+sl);
  tooltip_duplicate_paste.innerHTML = "Pasted ";
  })

  // (A3) OPTIONAL - CANNOT ACCESS CLIPBOARD
  .catch(err => {
    alert("Please allow clipboard access permission");
  });
}
</script>
<script>
function copy_duplicate_table(sl) {
 var copyText = document.getElementById("narration_"+sl);
  copyText.select();
  copyText.setSelectionRange(0, 99999);
  navigator.clipboard.writeText(copyText.value);
  var tooltip = document.getElementById("copyTooltip_duplicate_table_"+sl);
  tooltip.innerHTML = "Copied ";
} 
</script>
<script>
  function paste_edit_table(sl) {
     navigator.clipboard.readText()
  // (A2) PUT CLIPBOARD INTO TEXT FIELD
  .then(txt => {
    document.getElementById("narration_"+sl).value = txt;
    var tooltip_duplicate_paste = document.getElementById("pasteTooltip_edit_table_"+sl);
  tooltip_duplicate_paste.innerHTML = "Pasted ";
  })

  // (A3) OPTIONAL - CANNOT ACCESS CLIPBOARD
  .catch(err => {
    alert("Please allow clipboard access permission");
  });
  
}


</script>
<script>
function copy_edit_table(sl) {
 var copyText = document.getElementById("narration_"+sl);
  copyText.select();
  copyText.setSelectionRange(0, 99999);
  navigator.clipboard.writeText(copyText.value);
  
  var tooltip = document.getElementById("copyTooltip_edit_table_"+sl);
  tooltip.innerHTML = "Copied ";
} 
  
  
  
		</script>
		<script>
		   function paste2() {
     navigator.clipboard.readText()

  // (A2) PUT CLIPBOARD INTO TEXT FIELD
  .then(txt => {
    document.getElementById("narration").value = txt;
    var tooltip_2 = document.getElementById("myTooltip_2");
  tooltip_2.innerHTML = "Pasted ";
  })

  // (A3) OPTIONAL - CANNOT ACCESS CLIPBOARD
  .catch(err => {
    alert("Please allow clipboard access permission");
  });
  
}
function copy2(sl) {
  var copyText = document.getElementById("narration_"+sl);
  copyText.select();
  copyText.setSelectionRange(0, 99999);
  navigator.clipboard.writeText(copyText.value);
  
  var tooltip_1 = document.getElementById("myTooltip_"+sl);
  tooltip_1.innerHTML = "Copied ";
}
</script>



<!--edit-->
		<script>
		   function paste_edit() {
     navigator.clipboard.readText()

  // (A2) PUT CLIPBOARD INTO TEXT FIELD
  .then(txt => {
    document.getElementById("narration_edit").value = txt;
    var tooltip_2 = document.getElementById("myTooltip_edit_paste");
  tooltip_2.innerHTML = "Pasted ";
  })

  // (A3) OPTIONAL - CANNOT ACCESS CLIPBOARD
  .catch(err => {
    alert("Please allow clipboard access permission");
  });
  
}
 function paste_duplicate() {
     navigator.clipboard.readText()

  // (A2) PUT CLIPBOARD INTO TEXT FIELD
  .then(txt => {
    document.getElementById("narration_duplicate").value = txt;
    var tooltip_2 = document.getElementById("myTooltip_duplicate_paste");
  tooltip_2.innerHTML = "Pasted ";
  })

  // (A3) OPTIONAL - CANNOT ACCESS CLIPBOARD
  .catch(err => {
    alert("Please allow clipboard access permission");
  });
  
}
function copy_edit(sl) {
  var copyText = document.getElementById("narration_edit_"+sl);
  copyText.select();
  copyText.setSelectionRange(0, 99999);
  navigator.clipboard.writeText(copyText.value);
  
  var tooltip_1 = document.getElementById("myTooltip_edit_"+sl);
  tooltip_1.innerHTML = "Copied ";
}
</script>
<!--editend-->
		
        <script>
		$( document ).ready(function() {
			$(".select2").select2({
            width: '100%'
        });
		$('.datepicker').daterangepicker({
			singleDatePicker: true,
			showDropdowns: true,
			minYear: 2010,
			maxYear: parseInt(moment().format('YYYY'),10)
		  });
		});
		$(function () {
        $("#Reset").bind("click", function () {
			$("select").select2("destroy").select2();
        });
    });
		</script>
		 <script>
            $( "#hide" ).click(function() {
            $( ".hide" ).toggle('slow');
            });
        </script>
        <script>
    //  $(".admin_menu").click(function () {
    //      var mgid = $(this).data("mgid");
    //      var msgid = $(this).data("msgid");
    //      //var menuid = $(this).data("menuid");
    //      $('#menu_subgroup_name_'+msgid).not(this).prop('checked', this.checked);
    //      $('#menu_group_name_'+mgid).not(this).prop('checked', this.checked);
    //      //$('#admin_menu_'+menuid).not(this).prop('checked', this.checked);
    //  });
//   $(".permission").click(function () {
//          var mgid = $(this).data("mgid");
//          var msgid = $(this).data("msgid");
//          var menuid = $(this).data("menuid");
//      $('#menu_subgroup_name_'+msgid).not(this).prop('checked', this.checked);
//      $('#menu_group_name_'+mgid).not(this).prop('checked', this.checked);
//      $('#admin_menu_'+menuid).not(this).prop('checked', this.checked);
     
//  });
</script>
<script>
$(document).ready(function(){
    $(":input").inputmask();
});
</script>
<script>
    $('#datatable').dataTable( {
    "language": {
      "emptyTable": "Sorry No Record Found"
    }
} );
</script>
<script>
    $(".alert").fadeTo(6000, 5000).slideUp(1500, function(){
    $(".alert").slideUp(5000);
});
</script>
<script>
    	$(document).on("focus", ".select2", function() {
            $(this).siblings("select").select2("open");
        });


function OpenSelect2() {
  var $select2 = $(this).data('select2');
  setTimeout(function() {
    if (!$select2.opened()) { $select2.open(); }
  }, 0);  
}
</script>

<!--<script>-->
<!--     function paste() {-->
<!--            var pasteText = document.querySelector("#text");-->
<!--            pasteText.focus();-->
<!--            document.execCommand("paste");-->

<!--            pasteText.value = pasteText.value + pasteText.value;-->
<!--        }-->
<!--   </script>-->
<? /* ?><script>
//     $('.select2-nosearch').select2({
//   minimumResultsForSearch: 20
// });
$(document).on("focus", ".select2", function() {
    $(this).siblings("select").select2("open");
});

$('.select2-search').select2({});

$("*").on("mousedown focus focusin mouseup click blur keydown keypress keyup change",function(e) {
  console.log("{" + e.currentTarget.nodeName.toLowerCase() + ":" + e.type + "}"); 
});

$.fn.once = function (events, callback) {
    return this.each(function () {
        $(this).on(events, myCallback);
        function myCallback(e) {
            $(this).off(events, myCallback);
            callback.call(this, e);
        }
    });
};

// monitor every time we're about to close a menu
$("body").on('select2:closing', function (e) {
	// save in case we want it
	var $sel2 = $(e.target).data("select2");
  var $sel = $sel2.$element;
  var $selDropdown = $sel2.$results.find(".select2-results__option--highlighted")
  var newValue =  $selDropdown.data("data").element.value;
  
  console.log("closing", e);
  
  // must be closed by a mouse or keyboard - setup listener to see when that event is completely done
  // this must fire once and only once for every possible menu close 
  // otherwise the handler will be sitting around with unintended side affects
  $("html").once('keyup mouseup', function (e) {
  
	console.log("closing handler", e,e.target)
    // if close was due to a tab, use the highlighted value
    var KEYS = { UP: 38, DOWN: 40, TAB: 9 }
    if (e.keyCode === KEYS.TAB) {
      if (newValue != undefined) {
        $sel.val(newValue);
        $sel.trigger('change');
      }
    }

  });
  
});
</script><? */ ?>
<script>
            $(document).on('click', '.toggle-password', function() {

    $(this).toggleClass("fa-eye-slash");
    
    var input = $("#new_password");
    input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
});
</script>
<script type="text/javascript">
    $(function () {
        $("#customSwitchSecondary").click(function () {
            if ($(this).is(":checked")) {
                $("#moreInfo").show();
            } else {
                $("#moreInfo").hide();
            }
        });
    });
</script>
</body>
</html>