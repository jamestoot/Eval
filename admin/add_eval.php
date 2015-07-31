<?php
set_time_limit(0);
$strPageTitle = 'Create an Evaluation';

if(isset($_GET['eval_id']) && is_numeric($_GET['eval_id'])){
  $iEvaluationId = $_GET['eval_id'];
  $strPageTitle = 'Edit Evaluation';
  include("layout/header.php");
  $objEvaluation = new Evaluation(NULL, $iEvaluationId);
  $arrEvaluation = $objEvaluation->getEvaluation();
  $arrCompletedComponents = $objEvaluation->getCompletedComponents();
  $arrCompletedComments = $objEvaluation->getCompletedComments();
} else {
  include("layout/header.php");
}

if(!empty($_POST)) {
  if(!empty($_POST['evaluation-id'])){
    $objEvaluation = new Evaluation($_POST, $_POST['evaluation-id']);
    $blnEvaluationUpdated = $objEvaluation->addEvaluation(true);
    if($blnEvaluationUpdated && !empty($_POST['complete'])) {
      header('Location: '.$strLocation.'admin/view_eval.php?eval_id='.$_POST['evaluation-id']);
    } else {
      setTopMessage('success', 'Success! An the Evaluation for '.$_POST['name'].' has been updated.');
      header('Location: '.$strLocation.'admin/');
    }
  } else {
    $objEvaluation = new Evaluation($_POST);
    $blnEvaluationAdded = $objEvaluation->addEvaluation(false);
    if($blnEvaluationAdded) {
      setTopMessage('success', 'Success! An Evaluation has been added for '.$_POST['name'].'.');
      header('Location: '.$strLocation.'admin/');
    }
  }
}
$objComment = new Comment(NULL,NULL,NULL);
$arrComponents = $objComment->getComponents();
$arrCommentTypes = $objComment->getCommentTypes();
?>
<?
if(is_array($arrComponents)) {
?>
<div data-magellan-expedition="fixed">
  <dl class="sub-nav">
  <?foreach($arrComponents as $arrComponent) {
    ?>
    <dd data-magellan-arrival="component-<?=$arrComponent['id']?>"><a href="#component-<?=$arrComponent['id']?>"><?=$arrComponent['name']?></a></dd>
  <?}
  ?>
  </dl>
</div>
<?
}
?>
    <div class="row">
      <div class="panel columns medium-11">
        <div class="row">
          <div class="medium-3 columns medium-offset-9">
            <input type="submit" value="Save For Later" onclick="$('#eval-form').submit();" class="button radius small expand" />
          </div>
        </div>
        <div class="row collapse">
          <p>Please fill out the evaluation details below:</p>
        </div>
        <div class="row prefix-radius">
          <div class="columns medium-4">
            <form action="../admin/add_image.php" id="image-upload-1" class="image-upload-form" method="post" enctype="multipart/form-data">
              <label for="fileupload">Image 1 (Max 10MB)</label>
              <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
              <input id="fileupload" type="file" name="files[0]" accept="image/*">
              <small style="display:none;" class="error">Error! Image failed to upload, please check the filesize and try again</small>
            </form>
          </div>
          <div class="columns medium-4">
            <form action="../admin/add_image.php" id="image-upload-2" class="image-upload-form" method="post" enctype="multipart/form-data">
              <label for="fileupload2">Image 2 (Max 10MB)</label>
              <input id="fileupload2" type="file" name="files[1]" accept="image/*">
              <small style="display:none;" class="error">Error! Image failed to upload, please check the filesize and try again</small>
            </form>
          </div>
          <div class="columns medium-4">
            <form action="../admin/add_image.php" id="image-upload-3" class="image-upload-form" method="post" enctype="multipart/form-data">
              <label for="fileupload3">Image 3 (Max 10MB)</label>
              <input id="fileupload3" type="file" name="files[2]" accept="image/*">
              <small style="display:none;" class="error">Error! Image failed to upload, please check the filesize and try again</small>
            </form>
          </div>
        </div>
        <div class="row prefix-radius">
          <div class="columns medium-4" id="preview-image-1">
            <?if(!empty($arrEvaluation['image1'])){?>
              <img src="../uploads/<?=$arrEvaluation['image1']?>" alt="image1" id="thumb-1" />
            <?}?>
          </div>
          <div class="columns medium-4" id="preview-image-2">
            <?if(!empty($arrEvaluation['image2'])){?>
              <img src="../uploads/<?=$arrEvaluation['image2']?>" alt="image2" id="thumb-2" />
            <?}?>
          </div>
          <div class="columns medium-4" id="preview-image-3">
            <?if(!empty($arrEvaluation['image3'])){?>
              <img src="../uploads/<?=$arrEvaluation['image3']?>" alt="image3" id="thumb-3" />
            <?}?>
          </div>
        </div>
        <div class="row">
          <div class="columns">
            &nbsp;
          </div>
        </div>
  <form id="eval-form" data-abide method="post" action="add_eval.php"v>
    <?if(!empty($arrEvaluation['image1'])){?>
      <input id="thumb-1-update" type="hidden" name="image1" value="<?=$arrEvaluation['image1']?>" />
    <?}else{?>
      <input id="thumb-1-update" type="hidden" name="image1" value="" />
    <?}?>
    <?if(!empty($arrEvaluation['image2'])){?>
      <input id="thumb-2-update" type="hidden" name="image2" value="<?=$arrEvaluation['image2']?>" />
    <?}else{?>
      <input id="thumb-2-update" type="hidden" name="image2" value="" />
    <?}?>
    <?if(!empty($arrEvaluation['image3'])){?>
      <input id="thumb-3-update" type="hidden" name="image3" value="<?=$arrEvaluation['image3']?>" />
    <?}else{?>
      <input id="thumb-3-update" type="hidden" name="image3" value="" />
    <?}?>
     <?
      if(!empty($iEvaluationId)){
      ?>
      <input name="evaluation-id" type="hidden" value="<?=$iEvaluationId?>">
      <?
      }
      ?>
        <div class="row prefix-radius">
          <div class="columns medium-6">
            <select name="program">          
              <option value="Fundamentals"<?=!empty($arrEvaluation['program']) && $arrEvaluation['program'] == 'Fundamentals' ? ' selected' : '';?>>Fundamentals</option>
              <option value="Essentials"<?=!empty($arrEvaluation['program']) && $arrEvaluation['program'] == 'Essentials' ? ' selected' : '';?>>Essentials</option>
              <option value="Intensity Prep"<?=!empty($arrEvaluation['program']) && $arrEvaluation['program'] == 'Intensity Prep' ? ' selected' : '';?>>Intensity Prep</option>
              <option value="High Intensity"<?=!empty($arrEvaluation['program']) && $arrEvaluation['program'] == 'High Intensity' ? ' selected' : '';?>>High Intensity</option>
              <option value="Personal Guru"<?=!empty($arrEvaluation['program']) && $arrEvaluation['program'] == 'Personal Guru' ? ' selected' : '';?>>Personal Guru</option>
              <option value="Private"<?=!empty($arrEvaluation['program']) && $arrEvaluation['program'] == 'Private' ? ' selected' : '';?>>Private</option> 
            </select>
            <small class="error">Please fill out the program.</small>
          </div>
        </div>
        <div class="row prefix-radius"> 
          <div class="columns medium-6">
            <input name="name" type="text" <?=!empty($arrEvaluation['student']) ? ' value="'.$arrEvaluation['student'].'"' : '';?>placeholder="Name" required>
            <small class="error">Please fill out the name.</small>
          </div>
        </div>
        <div class="row prefix-radius"> 
          <div class="columns medium-6">
            <input name="email" type="text" <?=!empty($arrEvaluation['email']) ? ' value="'.$arrEvaluation['email'].'"' : '';?>placeholder="Email Address" required>
            <small class="error">Please fill out the name.</small>
          </div>
        </div>
        <?
        foreach($arrComponents as $arrComponent) {
        ?>
        <div class="row">
          <div class="columns">
            &nbsp;
          </div>
        </div>
        <div class="row row-component row-component-<?=$arrComponent['id']?>">
          <div class="columns">
            <div class="row">
              <h4 data-magellan-destination="component-<?=$arrComponent['id']?>"><?=$arrComponent['name']?></h4>
              <a name="component-<?=$arrComponent['id']?>"></a>
            </div>
            <div class="row">
              <input type="radio" name="component[<?=$arrComponent['id']?>][score][1]" value="true" id="component-<?=$arrComponent['id']?>-score-1"<?=!empty($arrCompletedComponents[$arrComponent['id']]['component_score']) && $arrCompletedComponents[$arrComponent['id']]['component_score'][1] ? ' checked="checked"' : '';?>><label for="component-<?=$arrComponent['id']?>-score-1">Focus Area</label>
              <input type="radio" name="component[<?=$arrComponent['id']?>][score][2]" value="true" id="component-<?=$arrComponent['id']?>-score-2"<?=!empty($arrCompletedComponents[$arrComponent['id']]['component_score']) && $arrCompletedComponents[$arrComponent['id']]['component_score'][2] ? ' checked="checked"' : '';?>><label for="component-<?=$arrComponent['id']?>-score-2">Needs Improvement</label>
              <input type="radio" name="component[<?=$arrComponent['id']?>][score][3]" value="true" id="component-<?=$arrComponent['id']?>-score-3"<?=!empty($arrCompletedComponents[$arrComponent['id']]['component_score']) && $arrCompletedComponents[$arrComponent['id']]['component_score'][3] ? ' checked="checked"' : '';?>><label for="component-<?=$arrComponent['id']?>-score-3">Fair</label>
              <input type="radio" name="component[<?=$arrComponent['id']?>][score][4]" value="true" id="component-<?=$arrComponent['id']?>-score-4"<?=!empty($arrCompletedComponents[$arrComponent['id']]['component_score']) && $arrCompletedComponents[$arrComponent['id']]['component_score'][4] ? ' checked="checked"' : '';?>><label for="component-<?=$arrComponent['id']?>-score-4">Good</label>
              <input type="radio" name="component[<?=$arrComponent['id']?>][score][5]" value="true" id="component-<?=$arrComponent['id']?>-score-5"<?=!empty($arrCompletedComponents[$arrComponent['id']]['component_score']) && $arrCompletedComponents[$arrComponent['id']]['component_score'][5] ? ' checked="checked"' : '';?>><label for="component-<?=$arrComponent['id']?>-score-5">Excellent</label>
            </div>
            <div class="row">
              <div class="columns">
                <textarea name="component[<?=$arrComponent['id']?>][component_comments]" placeholder="Comments"><?=!empty($arrCompletedComponents[$arrComponent['id']]['comments']) ? $arrCompletedComponents[$arrComponent['id']]['comments'] : '';?></textarea>
              </div>
            </div>
            <div class="row">
              <div class="columns">
                &nbsp;
              </div>
            </div>
            <?
            foreach($arrCommentTypes as $arrCommentType) {
            $arrCommentsWithSubTypes = $objComment->getComments($arrComponent['id'], $arrCommentType['id'], NULL)
            ?>
            <div class="row">
              <div class="columns">
                <h5><?=$arrCommentType['title']?> <small><?=$arrCommentType['sub_title']?></small></h5>
              </div>
            </div>
              <?
              foreach($arrCommentsWithSubTypes as $iSubTypeId => $arrCommentsWithSubType) {
                if(!empty($iSubTypeId) && $iSubTypeId > 0) { 
                $strSubTypeName = $objComment->getSubTypeName($iSubTypeId);
                ?>
                <div class="row">
                  <div class="columns">
                    <h7><?=$strSubTypeName?></small></h7>
                  </div>
                </div>
              <?}
                foreach($arrCommentsWithSubType as $arrComment) {
              ?>
            <div class="row row-tickboxes">
              <div class="small-1 columns">
                <input name="component[<?=$arrComponent['id']?>][comments][<?=$arrComment['id']?>]" id="component-<?=$arrComponent['id']?>-<?=$arrComment['id']?>"<?=!empty($arrCompletedComments[$arrComment['id']]) && $arrCompletedComments[$arrComment['id']] == 'Y' ? ' checked="checked"' : '';?> type="checkbox">
              </div>
              <div class="small-11 columns">
                <label for="component-<?=$arrComponent['id']?>-<?=$arrComment['id']?>"><?=nl2br($arrComment['comment'])?></label>
              </div>
            </div>
              <?
                }
              }
              ?>
            <div class="row">
              <div class="columns">
                &nbsp;
              </div>
            </div>
            <?
            }
            ?>
          </div>
        </div> 
        <?
        }
        ?>
        <div class="row">
          <div class="columns">
            <textarea name="comments" placeholder="Overall Comments"><?=!empty($arrEvaluation['comments']) ? $arrEvaluation['comments'] : '';?></textarea>
          </div>
        </div>
        <div class="row">
          <div class="columns">
            &nbsp;
          </div>
        </div>
        <div class="row">
          <div class="medium-3 columns">
            <input type="submit" value="Save For Later" class="button radius small expand" />
          </div>
          <div class="medium-3 medium-offset-6 columns">
            <input type="submit" value="Complete Evaluation" name="complete" class="button radius small expand" />
          </div>
        </div>
      </div>
    </div>
  </form>
  <script>

    $(document).ready(function(){
  
      var thumb1 = $('#thumb-1');   
      new AjaxUpload('fileupload', {
        action: $('#image-upload-1').attr('action'),
        name: 'image1',
        contentType: 'multipart/form-data',
        <?
        if(!empty($iEvaluationId)){
        ?>
        data: {evalid:<?=$iEvaluationId?>,imageid:'1'},
        <?
        }
        ?>
        onSubmit: function(file, extension) {
          $('#preview-image-1').addClass('loading');
          $('.image-upload-form .error').hide();
        },
        onComplete: function(file, response) {
          if(!response || response == 'error'){
            $('#preview-image-1').removeClass('loading');
            $('#image-upload-1 .error').show();
          } else {
            thumb1.load(function(){
              $('#preview-image-1').removeClass('loading');
              thumb1.unbind();
            });
            thumb1.attr('src', '../uploads/'+response);
            $('#thumb-1-update').attr('value', response);
          }
        }
      });
    });
  </script>
      
  <script>
    $(document).ready(function(){
      var thumb2 = $('#thumb-2');  
      new AjaxUpload('fileupload2', {
        action: $('#image-upload-2').attr('action'),
        name: 'image2',
        contentType: 'multipart/form-data',
        <?
        if(!empty($iEvaluationId)){
        ?>
        data: {evalid:<?=$iEvaluationId?>,imageid:'2'},
        <?
        }
        ?>
        onSubmit: function(file, extension) {
          $('#preview-image-2').addClass('loading');
        },
        onComplete: function(file, response) {
          thumb2.load(function(){
            $('#preview-image-2').removeClass('loading');
            thumb2.unbind();
          });
          thumb2.attr('src', '../uploads/'+response);
          $('#thumb-2-update').attr('value', response);
        }
      });
    });
  </script>
      
  <script>
    $(document).ready(function(){  
      var thumb3 = $('#thumb-3'); 
      new AjaxUpload('fileupload3', {
        action: $('#image-upload-3').attr('action'),
        name: 'image3',
        contentType: 'multipart/form-data',
        <?
        if(!empty($iEvaluationId)){
        ?>
        data: {evalid:<?=$iEvaluationId?>,imageid:'3'},
        <?
        }
        ?>
        onSubmit: function(file, extension) {
          $('#preview-image-3').addClass('loading');
        },
        onComplete: function(file, response) {
          thumb3.load(function(){
            $('#preview-image-3').removeClass('loading');
            thumb3.unbind();
          });
          thumb3.attr('src', '../uploads/'+response);
          $('#thumb-3-update').attr('value', response);
        }
      });
    });
  </script>
<?php
include("layout/footer_js.php");
?>
<?
include("layout/footer.php");
?>