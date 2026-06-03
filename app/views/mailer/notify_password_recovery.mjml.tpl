<mj-section>
	<mj-column>
		<mj-text>

			{t}Hello,{/t}<br /><br />

			{t}Have you forgotten your password? To reset your password, click on the following link{/t}

		</mj-text>
		<mj-button href="{$password_recovery->getUrl()}">{t}Reset Password{/t}</mj-button>
		<mj-text>
			<p style="text-align: center;">
				<small><a href="{$password_recovery->getUrl()}" class="muted">{$password_recovery->getUrl()}</a></small><br />
			</p>
			{t}Please note that this link is valid for 2 hours only.{/t}
			
		</mj-text>
	</mj-column>
</mj-section>
