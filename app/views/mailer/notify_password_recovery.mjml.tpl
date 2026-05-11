<mj-section>
	<mj-column>
		<mj-text>

			{t user_name=$user->getName()}Hello %1!{/t}<br /><br />

			{t}Have you forgotten your password? To reset your password, click on the following link{/t}

		</mj-text>
		<mj-button href="{$password_recovery->getUrl()}">{t}Reset Password{/t}</mj-button>
		<mj-text>
			<span style="text-align: center;">
				<small style="text-align: center;"><a href="{$password_recovery->getUrl()}" class="muted">{$password_recovery->getUrl()}</a></small><br />
			</span>
			<br />
			{t}Please note that this link is valid for 2 hours only.{/t}
			
		</mj-text>
	</mj-column>
</mj-section>
