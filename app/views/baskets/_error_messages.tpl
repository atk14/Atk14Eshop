<div id="error_messages">
{if $error_messages}

	<div class="alert alert-danger" role="alert">
		<h4>{t}Objednávka nemůže být dokončena{/t}</h4>
		<ul>
		{foreach $error_messages as $error_message}
			<li>
				{!$error_message}
				{if $error_message->getCorrectionText()}
					&rarr; <a href="{$error_message->getCorrectionUrl()}" data-method="post">{$error_message->getCorrectionText()}</a>
				{/if}
			</li>
		{/foreach}
		</ul>
	</div>
	
{/if}
</div>
