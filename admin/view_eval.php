<?php
$strPageTitle = 'Puckstoppers Goaltending Evaluation';
include("layout/header.php");
if(isset($_GET['eval_id']) && is_numeric($_GET['eval_id'])){
  $iEvaluationId = $_GET['eval_id'];
  $objEvaluation = new Evaluation(NULL, $iEvaluationId);
  $arrEvaluation = $objEvaluation->getEvaluation();
  $objEvaluation->markComplete();
  $arrCompletedComponents = $objEvaluation->getCompletedComponents();
  $arrCompletedComments = $objEvaluation->getCompletedComments();
} else {
  header('Location: '.$strLocation.'admin/');
}

if(!empty($_POST)) {
  if(!empty($_POST['evaluation-id'])){
    $objEvaluation = new Evaluation($_POST, $_POST['evaluation-id']);
    $blnEvaluationUpdated = $objEvaluation->addEvaluation(true);
    if($blnEvaluationUpdated) {
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
    if(!empty($iEvaluationId)){
    ?>
    <input name="evaluation-id" type="hidden" value="<?=$iEvaluationId?>">
    <?
    }
    ?>
    <div class="row">
      <div class="columns medium-11">
        <div class="row">
          &nbsp;
        </div>
        <div class="row">
          <div class="columns medium-6">
            <h3><small>Program</small><?=!empty($arrEvaluation['program']) ? $arrEvaluation['program'] : '';?></h3>
          </div>
          <div class="columns medium-6">
            <h3><small>Student</small><?=!empty($arrEvaluation['student']) ? $arrEvaluation['student'] : '';?></h3>
          </div>
        </div>
        <?
        if(!empty($arrEvaluation['image1']) || !empty($arrEvaluation['image2']) || !empty($arrEvaluation['image3'])) {
        ?>
        <div class="row">
          &nbsp;
        </div>
        <div class="row">
          <div class="columns medium-4">
            <?if(!empty($arrEvaluation['image1'])){?>
              <img src="../uploads/<?=$arrEvaluation['image1']?>" alt="image1" />
            <?}?>
          </div>
          <div class="columns medium-4">
            <?if(!empty($arrEvaluation['image2'])){?>
              <img src="../uploads/<?=$arrEvaluation['image2']?>" alt="image1" />
            <?}?>
          </div>
          <div class="columns medium-4">
            <?if(!empty($arrEvaluation['image3'])){?>
              <img src="../uploads/<?=$arrEvaluation['image3']?>" alt="image1" />
            <?}?>
          </div>
        </div>
        <?
        }
        ?>
        <div class="row">
          &nbsp;
        </div>
        <div class="row">
          <div class="columns">
            <blockquote>
              <p>This document has been designed to provide maximum feedback that will help you retain information vital to your development.</p>
              <p>We grade our students on a true scale of what we see as their potential, not simply checking off high scores in a shallow 
              attempt to boost their spirits, as many schools will do. We view this document as serious business and we want you to gain 
              the maximum benefit from it, so our honesty is important to your growth as a goaltender.</p>
              <p><strong>Please feel free to discuss this evaluation with an instructor or email us with any questions.</strong></p>
              <p>The notations below may reflect observations from early in the course, may have dramatically improved which by the end of the 
              program, however, we have found that most students will revert to ‘old habits and techniques’ if they are not reminded and 
              continually aware and working to improve on their personal traits. Please keep this evaluation and continually remind yourself 
              of what areas need work. It can literally take several months for a student to change a previously learned technique. 
              This is true even if the skill was vastly improved at the end of our program. Unless you keep working to ‘train your brain’ 
              you will automatically revert to the old habit.  Use this form to remind yourself what to work on.</p> 
              <p>The comments below that are NOT checked off, have been included to help you understand the keys to improving overall skills and 
              weakness’ within each area of play.</p>
              <p>These items are what we look for in evaluating every goaltender from Tyke to Pro.</p> 
              <p>Please keep this document and refer to it regularly when you are having a problem, analyze you own game to see where you might</p> 
              <p>Do this regularly!</p>
              <p><strong>Be honest with yourself,</strong> no one is great in every area.</p>
              <cite>Puckstoppers</cite>
            </blockquote>
          </div>
        </div>
        <?
        foreach($arrComponents as $arrComponent) {
          $blnHideComponent = true;
        ?>
        <div class="row row-component row-component-<?=$arrComponent['id']?>">
          <div class="columns">
            &nbsp;
          </div>
        </div>
        <div class="row row-component row-component-<?=$arrComponent['id']?>">
          <div class="columns">
            <div class="row">
              <h2><?=$arrComponent['name']?></h2>
              <a name="component-<?=$arrComponent['id']?>"></a>
            </div>
            <?
            if(!empty($arrCompletedComponents[$arrComponent['id']]['component_score'])) {
              $blnHideComponent = false;
            ?>
            <div class="row">
              <input type="radio" name="component[<?=$arrComponent['id']?>][score][1]" value="true" id="component-<?=$arrComponent['id']?>-score-1"<?=!empty($arrCompletedComponents[$arrComponent['id']]['component_score']) && $arrCompletedComponents[$arrComponent['id']]['component_score'][1] ? ' checked="checked"' : '';?>><label for="component-<?=$arrComponent['id']?>-score-1">Focus Area</label>
              <input type="radio" name="component[<?=$arrComponent['id']?>][score][2]" value="true" id="component-<?=$arrComponent['id']?>-score-2"<?=!empty($arrCompletedComponents[$arrComponent['id']]['component_score']) && $arrCompletedComponents[$arrComponent['id']]['component_score'][2] ? ' checked="checked"' : '';?>><label for="component-<?=$arrComponent['id']?>-score-2">Needs Improvement</label>
              <input type="radio" name="component[<?=$arrComponent['id']?>][score][3]" value="true" id="component-<?=$arrComponent['id']?>-score-3"<?=!empty($arrCompletedComponents[$arrComponent['id']]['component_score']) && $arrCompletedComponents[$arrComponent['id']]['component_score'][3] ? ' checked="checked"' : '';?>><label for="component-<?=$arrComponent['id']?>-score-3">Fair</label>
              <input type="radio" name="component[<?=$arrComponent['id']?>][score][4]" value="true" id="component-<?=$arrComponent['id']?>-score-4"<?=!empty($arrCompletedComponents[$arrComponent['id']]['component_score']) && $arrCompletedComponents[$arrComponent['id']]['component_score'][4] ? ' checked="checked"' : '';?>><label for="component-<?=$arrComponent['id']?>-score-4">Good</label>
              <input type="radio" name="component[<?=$arrComponent['id']?>][score][5]" value="true" id="component-<?=$arrComponent['id']?>-score-5"<?=!empty($arrCompletedComponents[$arrComponent['id']]['component_score']) && $arrCompletedComponents[$arrComponent['id']]['component_score'][5] ? ' checked="checked"' : '';?>><label for="component-<?=$arrComponent['id']?>-score-5">Excellent</label>
            </div>
            <?
            }
            if(!empty($arrCompletedComponents[$arrComponent['id']]['comments'])) {
              $blnHideComponent = false;
            ?>
            <div class="row">
              <div class="columns">
                <blockquote>
                  <p><?=!empty($arrCompletedComponents[$arrComponent['id']]['comments']) ? $arrCompletedComponents[$arrComponent['id']]['comments'] : '';?></p>
                </blockquote>              
              </div>
            </div>
            <?
            }
            ?>
            <?
            foreach($arrCommentTypes as $arrCommentType) {
            $arrCommentsWithSubTypes = $objComment->getComments($arrComponent['id'], $arrCommentType['id'], $iEvaluationId)
            ?>
            <div class="row row-component-<?=$arrComponent['id']?>-comment-type-id-<?=$arrCommentType['id']?>">
              <div class="columns">
                &nbsp;
              </div>
            </div>
            <div class="row row-component-<?=$arrComponent['id']?>-comment-type-id-<?=$arrCommentType['id']?>">
              <div class="columns">
                <h4><?=$arrCommentType['title']?> <small><?=$arrCommentType['sub_title']?></small></h4>
              </div>
            </div>
              <?
              $iSubTypeCount = 0;
              foreach($arrCommentsWithSubTypes as $iSubTypeId => $arrCommentsWithSubType) {
                if(!empty($iSubTypeId) && $iSubTypeId > 0) {
                $blnHideComponent = false; 
                $strSubTypeName = $objComment->getSubTypeName($iSubTypeId);
                ?>
                <div class="row">
                  <div class="columns">
                    <h7><?=$strSubTypeName?></h7>
                  </div>
                </div>
              <?}
                if(is_array($arrCommentsWithSubType)){
                $blnHideComponent = false;  
                ?>
                <div class="row">
                  <div class="panel">
                    <ul class="square">
                    <?foreach($arrCommentsWithSubType as $arrComment) {
                      $iSubTypeCount++;
                      ?>
                      <li><?=nl2br($arrComment['comment'])?></li>
                      <?
                      }?>
                    </ul>
                  </div>
                </div>
              <?}
              }
              ?>
            <div class="row row-component-<?=$arrComponent['id']?>-comment-type-id-<?=$arrCommentType['id']?>">
              <div class="columns">
                &nbsp;
              </div>
            </div>
            <?
              if($iSubTypeCount == 0) {
              ?>
              <style>
                .row-component-<?=$arrComponent['id']?>-comment-type-id-<?=$arrCommentType['id']?>{display:none;}
              </style>
              <?/*
              <script>
                $( ".row-component-<?=$arrComponent['id']?>-comment-type-id-<?=$arrCommentType['id']?>" ).hide();
              </script>*/?>
              <?
              }
            }
            ?>
          </div>
        </div> 
        <?
          if($blnHideComponent) {
          ?>
          <style>
            .row-component-<?=$arrComponent['id']?>{display:none;}
          </style>
          <?/*<script>
           $( ".row-component-<?=$arrComponent['id']?>" ).hide();
          </script>*/?>
          <?
          }
        }
        ?>
        <?if(!empty($arrEvaluation['comments'])){?>
            <div class="row">
              <h2>Overall Comments</h2>
            </div>
            <div class="row">
              <div class="columns">
                <blockquote>
                  <p><?=!empty($arrEvaluation['comments']) ? $arrEvaluation['comments'] : '';?></p>
                </blockquote>              
              </div>
            </div>
            <div class="row">
              <div class="columns">
                &nbsp;            
              </div>
            </div>
        <?}?>
        
        
        <form method="POST" action="view_eval_pdf.php">
        <?
        if(!empty($iEvaluationId)){
        ?>
        <input name="evaluation-id" type="hidden" value="<?=$iEvaluationId?>">
        <?
        }
        ?>
        <div class="row">
          <div class="medium-3 columns">
            <input type="submit" value="Email PDF" name="email-pdf" class="button radius small expand email_pdf" />
          </div>
          <div class="medium-3 columns medium-offset-6">
            <input type="submit" value="Download PDF" name="download-pdf" class="button radius small expand download_pdf" />
          </div>
        </div>
        </form>
      </div>
    </div>
<?php
include("layout/footer_js.php");
?>
<?
include("layout/footer.php");
?>