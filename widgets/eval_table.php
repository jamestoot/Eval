<?

include_once("../includes/logincheck.php");

$objEvalation = new Evaluation(null, null);
$arrGroupedIncompleteEvalations = $objEvalation->getEvaluations(false);
?>
    <div class="row">
      <div class="collums">
        <h3>Unfinished Evaluations</h3>
      </div>
    </div>
  <?
  if(is_array($arrGroupedIncompleteEvalations)) {
    $iCount = 0;
    foreach ($arrGroupedIncompleteEvalations as $strGroup => $arrIncompleteEvalations) {?>
    <div class="row">
      <div class="columns">
        <h5><?=$strGroup?></h5>
      </div>
    </div>
    <div class="row standings-header">
      <div class="small-1 columns">
        <span class="title">Image</span>
      </div>
      <div class="small-3 columns">
        <span class="title">Student</span>
      </div>
      <div class="small-3 columns">
        <span class="title">Program</span>
      </div>
      <div class="small-2 columns text-center">
        <span class="title">Comments</span>
      </div>
      <div class="small-3 columns text-center">
        <span class="title">Action</span>
      </div>
    </div>
    <?foreach($arrIncompleteEvalations as $arrEvalation) {
      $iCount++;
    ?>
    <div class="row row-eval-<?=$arrEvalation['id']?><?=$iCount % 2 == 0 ? ' row-alt' : ''?>">
          <div class="small-1 columns">
            <?if(!empty($arrEvalation['image1'])){?>
              <img src="../uploads/<?=$arrEvalation['image1']?>" alt="image1" />
            <?}else{?>
              &nbsp;
            <?}?>
          </div>
          <div class="small-3 columns">
            <span class="title"><a href="add_eval.php?eval_id=<?=$arrEvalation['id']?>" title="Continue <?=$arrEvalation['student']?>'s Evaluation"><?=$arrEvalation['student']?></a></span>
          </div>
          <div class="small-3 columns">
           <span class="title"><a href="add_eval.php?eval_id=<?=$arrEvalation['id']?>" title="Continue <?=$arrEvalation['student']?>'s Evaluation"><?=$arrEvalation['program']?></a></span>
          </div>
          <div class="small-2 columns text-center">
            <div class="">
              <span class="title"><?=$objEvalation->getCommentCount($arrEvalation['id']);?></span>
            </div> 
          </div>
          <div class="small-3 columns text-center">
            <div class="">
              <a class="tiny button radius" href="add_eval.php?eval_id=<?=$arrEvalation['id']?>" title="Continue <?=$arrEvalation['student']?>'s Evaluation">Edit</a>
            </div> 
          </div>
    </div>
    
    <?}
    }  
  }
$arrGroupedCompleteEvalations = $objEvalation->getEvaluations(true);
?>
    <div class="row">
      <div class="collums">
        &nbsp;
      </div>
    </div>
    <div class="row">
      <div class="collums">
        <h3>Completed Evaluations</h3>
      </div>
    </div>
  <?
  if(is_array($arrGroupedCompleteEvalations)) {
    $iCount = 0;
    foreach ($arrGroupedCompleteEvalations as $strGroup => $arrCompleteEvalations) {?>
    <div class="row">
      <div class="columns">
        <h5><?=$strGroup?></h5>
      </div>
    </div>
    <div class="row standings-header">
      <div class="small-1 columns">
        <span class="title">Image</span>
      </div>
      <div class="small-3 columns">
        <span class="title">Student</span>
      </div>
      <div class="small-3 columns">
        <span class="title">Program</span>
      </div>
      <div class="small-2 columns text-center">
        <span class="title">Comments</span>
      </div>
      <div class="small-3 columns text-center">
        <span class="title">Action</span>
      </div>
    </div>
    <?foreach($arrCompleteEvalations as $arrEvalation) {
      $iCount++;
    ?>
    <div class="row row-eval-<?=$arrEvalation['id']?><?=$iCount % 2 == 0 ? ' row-alt' : ''?>">
          <div class="small-1 columns">
            <?if(!empty($arrEvalation['image1'])){?>
              <img src="../uploads/<?=$arrEvalation['image1']?>" alt="image1" />
            <?}else{?>
              &nbsp;
            <?}?>
          </div>
          <div class="small-3 columns">
            <span class="title"><a href="view_eval.php?eval_id=<?=$arrEvalation['id']?>" title="Continue <?=$arrEvalation['student']?>'s Evaluation"><?=$arrEvalation['student']?></a></span>
          </div>
          <div class="small-3 columns">
           <span class="title"><a href="view_eval.php?eval_id=<?=$arrEvalation['id']?>" title="Continue <?=$arrEvalation['student']?>'s Evaluation"><?=$arrEvalation['program']?></a></span>
          </div>
          <div class="small-2 columns text-center">
            <div class="">
              <span class="title"><?=$objEvalation->getCommentCount($arrEvalation['id']);?></span>
            </div> 
          </div>
          <div class="small-3 columns text-center">
            <div class="">
              <a class="tiny button success radius" href="view_eval.php?eval_id=<?=$arrEvalation['id']?>" title="View <?=$arrEvalation['student']?>'s Evaluation">View</a>
              <a class="tiny button alert radius" href="delete_eval.php?eval_id=<?=$arrEvalation['id']?>" title="Delete <?=$arrEvalation['student']?>'s Evaluation">Delete</a>
            </div> 
          </div>
    </div>
    
    <?}
    }  
  }?>
    <div class="row">
      <div class="collums">
        &nbsp;
      </div>
    </div>