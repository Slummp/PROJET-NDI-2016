<a class="btn btn-primary" href="index.php" aria-label="return" role="button">
  <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
  Retour
</a>

<!-- Titre du formulaire -->
<h1 class="text-center">Access</h1>

<!-- Formulaire -->
<div id="big-form" class="well auth-box">
    <form method="post" action="/refugees/index.php?controller=questions&action=access">
        <fieldset>
            <div id="divCode" class="form-group">
                <label class="control-label" for="inputCode">Code</label>
                <div class="input">
                    <input id="inputCode" name="code" class="form-control input-md" type="text" >
                </div>
            </div>

            <button type="submit" class="btn btn-default">Envoyer</button>
        </fieldset>
    </form>
</div>

<div class="clearfix"></div>
