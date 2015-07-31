<?php

$strPageTitle = 'Overview';
include("layout/header.php");
?>
<?php
include("layout/footer_js.php");
?>
    <div class="row">
      <div class="columns standings-table left">
      <?php
      include("../widgets/eval_table.php");
      ?>
      </div>
    </div>


<script type="text/javascript">
$(document).ready( function() {
  $("#series_choice").on("change", function() {
    // Show the ajax loader while we wait
    var form = $('#series_form');
    $(".standings-table").addClass('ajax_overlay');
    $.ajax({
      type: "GET",
      url: '../widgets/standings_table.php?blnAdmin=true',
      data: form.serialize(),
      cache: false
    }).done(function( data ) {
      // There's a result, hide the ajax loader
      $(".standings-table").removeClass('ajax_overlay');
      try
      {
        $(".standings-table").html(data);
      }
      catch(e)
      {
        $(".standings-table").html('Error Loading Data');
      }
    });
    return false;
  } );

} );
</script>
<?php
include("layout/footer.php");
?>