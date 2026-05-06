<mj-section>
	<mj-column>
		<mj-text>

			{t user_name=$user->getName()}Hello %1!{/t}<br /><br />

			{t}Have you forgotten your password? To reset your password, click on the following link{/t}<br /><br />

			<a href="{$password_recovery->getUrl()}" style="{$link_style}">{$password_recovery->getUrl()}</a><br /><br />

			{t}Please note that this link is valid for 2 hours only.{/t}

		</mj-text>
	</mj-column>
</mj-section>
