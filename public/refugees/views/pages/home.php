<div class="row">
  <a href="/refugees/index.php?controller=questions&action=add" class="btn btn-primary">?</a>
  <a href="/refugees/index.php?controller=questions&action=access" class="btn btn-primary">JOIN</a>
</div>
<div class="row">
  <div class="col-md-12">
    <h2>My questions</h2>
     <table cellspacing="0" width="100%"class="dt responsive col-sm-12">
        <thead>
            <tr>
                <th>Question title</th>
                <th>Info</th>
            </tr>
        </thead>
        <tbody>
          <?php foreach($myQuestions as $q) { ?>
            <tr>
              <td>
                <a href="/refugees/index.php?controller=topic&action=read&code=<?= $q->question_code; ?>">
                  <?= $q->question_title; ?>
                </a>
              </td>
              <td>
                <?= date('d/m/Y à H:i:s', strtotime($q->date_post)); ?>
              </td>
            </tr>
          <?php } ?>
        </tbody>
        <tfoot>
            <tr>
              <th>Question title</th>
              <th>Info</th>
            </tr>
        </tfoot>
    </table>
  </div>
  
  <div class="col-md-12">
    <h2>Public Questions (<50km)</h2>
    <table cellspacing="0" width="100%"class="dt responsive col-sm-12">
        <thead>
            <tr>
                <th>Question title</th>
                <th>Info</th>
            </tr>
        </thead>
        <tbody>
          <?php foreach($nearQuestions as $q) { ?>
            <tr>
              <td>
                <a href="/refugees/index.php?controller=topic&action=read&code="<?= $q->question_code; ?>>
                  <?= $q->question_title; ?>
                </a>
              </td>
              <td>
                <?= date('d/m/Y à H:i:s', strtotime($q->date_post)); ?>
              </td>
            </tr>
          <?php } ?>
        </tbody>
        <tfoot>
            <tr>
              <th>Question title</th>
              <th>Info</th>
            </tr>
        </tfoot>
    </table>
  </div>
  
  <div class="col-md-12">
    <h2>Country Questions</h2>
    <table cellspacing="0" width="100%"class="dt responsive col-sm-12">
        <thead>
            <tr>
                <th>Question title</th>
                <th>Info</th>
            </tr>
        </thead>
        <tbody>
          <?php foreach($allQuestions as $q) { ?>
            <tr>
              <td>
                <a href="/refugees/index.php?controller=topic&action=read&code="<?= $q->question_code; ?>>
                  <?= $q->question_title; ?>
                </a>
              </td>
              <td>
                <?= date('d/m/Y à H:i:s', strtotime($q->date_post)); ?>
              </td>
            </tr>
          <?php } ?>
        </tbody>
        <tfoot>
            <tr>
              <th>Question title</th>
              <th>Info</th>
            </tr>
        </tfoot>
    </table>
  </div>
</div>
