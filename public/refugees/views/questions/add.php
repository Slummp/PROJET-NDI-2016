<a class="btn btn-primary" href="index.php" aria-label="return" role="button">
  <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
  Retour
</a>

<!-- Titre du formulaire -->
<h1 class="text-center">Question</h1>

<!-- Formulaire -->
<div id="big-form" class="well auth-box">
    <form method="post" action="/refugees/index.php?controller=questions&action=add">
        <fieldset>
            <div id="divQuestion" class="form-group">
                <label class="control-label" for="inputQuestion">Ask your question</label>
                <div class="input">
                    <input id="inputQuestion" name="question_title" class="form-control input-md" type="text" >
                </div>
            </div>

            <div id="divThemes" class="form-group" style="display: block;">
                <label class="control-label">Themes</label>
                <div id="contentModules" class="">
                    <?php
                    foreach ($themes as $id => $theme) {
                        ?>
                        <div class="checkbox">
                            <label for="checkboxes-theme<?php echo $id; ?>">
                                <input id="checkboxes-theme<?php echo $id; ?>" name="themes[]" type="checkbox" value="<?php echo $id; ?>"><?php echo $theme; ?>
                            </label>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>

            <div id="divVisibility" class="form-group">
                <label class="control-label">Visibility</label>
                <div class=""> 
                    <label class="radio-inline" for="visibility-hidden">
                        <input name="type" id="visibility-hidden" value="0" checked="checked" type="radio">
                        Privé
                    </label> 
                    <label class="radio-inline" for="visibility-50">
                        <input name="type" id="visibility-50" value="1" type="radio">
                        50 km
                    </label>
                    <label class="radio-inline" for="visibility-all">
                        <input name="type" id="visibility-all" value="2" type="radio">
                        Publique
                    </label>
                </div>
            </div>

            <div id="divCaption" class="form-group">
                <label class="control-label" for="inputCaption">Describe</label>
                <div class="input">
                    <textarea id="inputCaption" name="question_content" class="form-control input-md" type="text" rows="10" ></textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-default">Envoyer</button>
        </fieldset>
    </form>
</div>

<div class="clearfix"></div>
