<mj-section>
	<mj-column>
		<mj-text>
{if $newsletter_subscriber->getVocative()}
	{t vocative=$newsletter_subscriber->getVocative()}Dobrý den %1,{/t}<br/><br/>
{else}
	{t}Dobrý den,{/t}<br/><br/>
{/if}

{t}děkujeme Vám za registraci k odběru našeho newsletteru.{/t}<br/></br/>

{t}Pokud nadále nechcete dostávat zprávy o našich novinkách, můžete se z odběru odhlásit na adrese:{/t}
		</mj-text>
		<mj-button href="{$unsubscribe_url}">{t}Zrušit odběr{/t}</mj-button>
		<mj-text>
<p style="text-align: center;"><small><a href="{$unsubscribe_url}" class="muted">{$unsubscribe_url}</a></small></p>
		</mj-text>
	</mj-column>
</mj-section>