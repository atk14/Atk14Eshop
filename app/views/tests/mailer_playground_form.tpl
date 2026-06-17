<h1>Mailer MJML playground</h1>
<p>{t}Enter your MJML code here. Email preview will be shown in a new tab.{/t}</p>
<form method="post" action="{link_to action="mailer_playground"}" target="_blank">
  <textarea name="mjml_input" id="mjml_input" class="form-control" placeholder="Vložte MJML kód" style="height: 400px;">
    <mj-section>
	<mj-column>
		<mj-text>
Enter your MJML code here.
		</mj-text>
	</mj-column>
</mj-section>
  </textarea>
  <button type="submit" class="btn btn-primary mt-2">{t}Odeslat{/t}</button>
</form>