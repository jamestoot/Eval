<?php
$strPageTitle = 'Add a Comment';
include("layout/header.php");
if(!empty($_POST)) {
  $objComment = new Comment($_POST['comment'], $_POST['component'], $_POST['type']);
  $blnCommentAdded = $objComment->addComment();
  if($blnCommentAdded) {
    setTopMessage('success', 'Success! the comment has been added.');
    header('Location: '.$strLocation.'admin/add_comments.php');
  }
}
$objComment = new Comment(NULL,NULL,NULL);
$arrComponents = $objComment->getComponents();
$arrCommentTypes = $objComment->getCommentTypes();
?>
  <form id="comment-form" data-abide method="post" action="add_comments.php">
    <div class="row">
      <div class="medium-8 panel columns left">
        <div class="row collapse">
          <p>Please fill out the comment details below:</p>
        </div>
        <?
        if(is_array($arrComponents)) {
        ?>
        <div class="row prefix-radius">
          <div class="columns">
            <select name="component">
              <option disabled="disabled" selected>Choose a Component</option>
              <?
              foreach($arrComponents as $arrComponent) {
              ?>
              <option value="<?=$arrComponent['id']?>"><?=$arrComponent['name']?></option>
              <?
              }
              ?>
            </select>
            <small class="error">Please choose a component.</small>
          </div>
        </div>
        <?
        }
        ?>
        <?
        if(is_array($arrCommentTypes)) {
        ?>
        <div class="row prefix-radius">
          <div class="columns">
            <select name="type">
              <option disabled="disabled" selected>Choose a Comment Type</option>
              <?
              foreach($arrCommentTypes as $arrCommentType) {
              ?>
              <option value="<?=$arrCommentType['id']?>"><?=$arrCommentType['title']?></option>
              <?
              }
              ?>
            </select>
            <small class="error">Please choose a comment type.</small>
          </div>
        </div>
        <?
        }
        ?>
        <div class="row prefix-radius">
          <div class="columns">
            <input name="comment" type="text" placeholder="Comment" required>
            <small class="error">Please fill out the Comment.</small>
          </div>
        </div>
        <div class="row">
          <div class="columns">
            &nbsp;
          </div>
        </div>
        <div class="row">
          <div class="medium-3 medium-offset-9 columns">
            <input type="submit" value="Add Comment" class="button radius small expand" />
          </div>
        </div>
      </div>
    </div>
  </form>
<?php
include("layout/footer_js.php");
?>
<script type="text/javascript">
$(document).ready( function() {
  $("#series_choice").on("change", function() {
    // Show the ajax loader while we wait
    var form = $('#event-form');
    $(".standings-table").addClass('ajax_overlay');
    $.ajax({
      type: "GET",
      url: '../widgets/standings_table.php?addEvent=true',
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
<?
include("layout/footer.php");
?>