<div class="row">
  <div class="col-md-12" style="background:lightblue">
    <b>Questions</b>: <?= $questionInfo->question_title; ?> (<?= date('d/m/Y H:i:s', strtotime($questionInfo->date_post)); ?>)<br />
    <?= $questionInfo->question_content; ?>
    <hr>
  </div>
</div>

<?php foreach($topics as $t) { ?>
<div class="row">
  <div class="col-md-12" class="posts">
    <b>Posted at <?= date('d/m/Y H:i:s', strtotime($t->date_post)); ?></b><br />
    <?= $t->answer; ?>
    <hr>
  </div>
</div> 
<?php }?>

<div class="row">
  <form action="<?= $_SERVER['REQUEST_URI']; ?>" method="POST">
  <div class="col-md-12" style="background:lightgrey">
    <div id="divCaption" class="form-group">
        <label class="control-label" for="inputCaption">Comment</label>
        <div class="input">
            <textarea id="inputCaption" name="answer" class="form-control input-md" type="text" rows="10" ></textarea>
        </div>
        <button class="btn btn-success">Envoyer</button>
    </div>
  </div>
  </form>
</div> 
