<mj-section>
	<mj-column>
		<mj-text>
{t}Dobrý den,{/t}<br/><br/>

{t}pro potvrzení odběru novinek klikněte na následující odkaz:{/t}
    </mj-text>
    <mj-button href="{$newsletter_subscription_request->getConfirmationUrl()}">{t}Potvrdit odběr{/t}</mj-button>
    <mj-text>
      <p style="text-align: center;"><small><a href="{$newsletter_subscription_request->getConfirmationUrl()}" class="muted">{$newsletter_subscription_request->getConfirmationUrl()}</a></small></p>

    </mj-text>
  </mj-column>
</mj-section>

