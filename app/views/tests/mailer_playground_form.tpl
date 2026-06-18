<h1>Mailer MJML playground</h1>
<form method="post" action="{link_to action="mailer_playground"}" target="_blank">
  <div class="form-group">
    <label class="form-label" for="mjml_input">{t}Enter your MJML code here. Email preview will be shown in a new tab.{/t}</label>
    <textarea name="mjml_input" id="mjml_input" class="form-control" placeholder="Vložte MJML kód" style="height: 400px;">
<mj-section>
  <mj-column>
    <mj-text>
Enter your MJML code here.
    </mj-text>
  </mj-column>
</mj-section>
    </textarea>
  </div>
  <div class="form-group">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="remove" id="remove_smarty_tags" name="remove_smarty_tags">
      <label class="form-check-label" for="remove_smarty_tags">{t}Remove Smarty tags{/t}</label>
    </div>
  </div>
  <button type="submit" class="btn btn-primary mt-2">{t}Odeslat{/t}</button>
</form>