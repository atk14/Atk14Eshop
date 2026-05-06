
<mj-section>
	<mj-column>
		<mj-text>

			{t appname="ATK14_APPLICATION_NAME"|dump_constant}Thanks for signing up for %1!{/t}<br>

			{t}Here is your data summary{/t}

			<ul>
				<li>{t}login{/t}: {$user->getLogin()}</li>
				<li>{t}email{/t}: {$user->getEmail()}</li>
				<li>{t}name{/t}: {$user->getName()}</li>
			</ul>

		</mj-text>
	</mj-column>
</mj-section>