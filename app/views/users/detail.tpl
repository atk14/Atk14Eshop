{render partial="shared/layout/content_header" title=$page_title}

<table class="table">
	<tbody>
		<tr>
			<th>{t}Username (login){/t}</th>
			<td>{$logged_user->getLogin()}</td>
		</tr>
		<tr>
			<th>{t}Your name{/t}</th>
			<td>{$logged_user->getName()|default:$mdash}</td>
		</tr>
		<tr>
			<th>{t}Your email{/t}</th>
			<td>{$logged_user->getEmail()|default:$mdash}</td>
		</tr>
		{if $logged_user->isAdmin}
			<tr>
				<th>{t}Are you admin?{/t}</th>
				<td>{t}Yes, you are{/t}</td>
			</tr>
		{/if}
	</tbody>
</table>

<div class="form__footer form__footer--simple">
	{a action="edit" _class="btn btn-primary"}{t}Change your account data{/t}{/a}
	{a action="edit_password" _class="btn btn-primary"}{t}Change your password{/t}{/a}
</div>
