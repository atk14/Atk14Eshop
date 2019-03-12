{render partial="shared/checkout_navigation"}

<h1>{$page_title}</h1>

<div class="flex-row">
	<div class="col">
		<h2 class="title title--h4">{t}Už mám účet{/t}</h2>
		{render partial="shared/form" form=$login_form button_class="btn btn--cta"}
	</div>
	<div class="col">
		<h2 class="title title--h4">{t}Zaregistrujte se{/t}</h2>
		<ul class="ul ul--base">
			<li>{t}osobní nastavení a zabezpečený přístup{/t}</li>
			<li>{t}rychlý a snadný nákup{/t}</li>
			<li>{t}rozdílná fakturační a dodací adresa{/t}</li>
		</ul>
		{a action="users/create_new" return_uri=$request->getUri() _class="btn btn--cta"}{t}Zaregistrujte se{/t}{/a}
		{* render partial="shared/user_registration_form" form=$registration_form *}
	</div>
	<div class="col">
		<h2 class="title title--h4">{t}Nákup bez registrace{/t}</h2>
		<p>{a action="checkouts/set_billing_and_delivery_data" _class="btn btn-primary"}{t}Pokračovat bez registrace{/t}{/a}</p>
	</div>
</div>
