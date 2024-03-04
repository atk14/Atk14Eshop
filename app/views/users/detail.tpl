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
		{if $logged_user->getCompany()}
		<tr>
			<th>{t}Company{/t}</th>
			<td>
				{$logged_user->getCompany()}
				{if $logged_user->getCompanyNumber()}
					<br>
					{t}IČ{/t}: {$logged_user->getCompanyNumber()}
				{/if}
				{if $logged_user->getVatId()}
					<br>
					{t}DIČ{/t}: {$logged_user->getVatId()}
				{/if}
			</td>
		</tr>
		{/if}
		<tr>
			<th>{t}Address{/t}</th>
			<td>
				{remove_if_contains_no_text}
				{$logged_user->getAddressStreet()}<br>
				{if $logged_user->getAddressStreet2()}
					{$logged_user->getAddressStreet2()}<br>
				{/if}
				{$logged_user->getAddressZip()} {$logged_user->getAddressCity()}<br>
				{if $logged_user->getAddressState()}
					{$logged_user->getAddressState()}<br>
				{/if}
				{$logged_user->getAddressCountry()|to_country_name}<br>
				{/remove_if_contains_no_text}
			</td>
		</tr>
		<tr>
			<th>{t}Phone{/t}</th>
			<td>{$logged_user->getPhone()|display_phone|default:$mdash}</td>
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
	{a action="orders/index" _class="btn btn-default"}{t}My orders{/t}{/a}
	{a action="edit" _class="btn btn-default"}{t}Change your account data{/t}{/a}
	{a action="edit_password" _class="btn btn-default"}{t}Change your password{/t}{/a}
	{a action="delivery_addresses/index" _class="btn btn-default"}{t}Delivery addresses{/t}{/a}
	{a action="favourite_products/index" _class="btn btn-default"}{t}Favourite products{/t}{/a}
</div>
