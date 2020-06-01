Forms
=====
Form markup and styling is based on Bootstrap form system. In most cases, following Bootstrap forms documentation would lead to nice and correct results.

## Form layouts

### Basic form 

[example]
<form action="#" method="post" id="form_logins_create_new" novalidate="novalidate" class="" role="form">
	<fieldset>
		<div class="form-group form-group--id_login form-group--required">
			<label for="id_login" class="control-label">Přihlásit se </label>
			<input maxlength="255" required="required" type="text" name="login" class="text form-control" id="id_login">
		</div>
		<div class="form-group form-group--id_password form-group--required">
			<label for="id_password" class="control-label">Heslo </label>
			<input class="form-control" maxlength="255" required="required" type="password" name="password" id="id_password">
		</div>
		<div class="form-group">
			<span class="button-container"><button type="submit" class="btn btn-primary">Přihlásit se</button></span>
		</div>
	</fieldset>
	<div>
		<input type="hidden" name="_csrf_token_" value="">
	</div>
</form>
[/example]

### Horizontal form
Horizontal forms differ from Bootstrap horizontal forms. To avoid using grid classes and to make markup more consistent with basic vertically stacked forms, we use CSS grid to create layout of <code>form-group</code> element (which wraps one form element or logical group of form elements like radio buttons). Basic form is converted to horizontal form simply by adding <code>form-horizontal</code> class to <code>form</code> element.

[example]
<form action="#" method="post" id="form_users_create_new" class="form-horizontal" novalidate="novalidate">
	<fieldset>
		<div class="form-group form-group--id_login form-group--required">
			<label for="id_login" class="control-label">Uživatelské jméno (login) </label>
			<input maxlength="50" required="required" pattern="^[a-z0-9.-]+$" type="text" name="login" class="text form-control" id="id_login" data-original-title="" title="">

			<div class="form-text help-block">Zadávejte pouze písmena, číslice, tečky a pomlčky. Max. délka je omezena na 50 znaků.</div>
			<div class="help-hint d-none" data-title="Příklady">
				<ul class="list pl-3">
					<li>john.doe</li>
					<li>samantha92</li>
				</ul>
			</div>
			<p class="alert alert-danger" style="display: none;">Username is already taken.</p>
		</div>
		<div class="form-group form-group--id_gender_id_0 form-group--required">
			<label for="id_gender_id_0" class="control-label">Oslovení </label>
			<ul class="list list--radios">
				<li class="list__item">
					<div class="form-check"><input id="id_gender_id_0" class="form-check-input" type="radio" name="gender_id" value="1"> <label class="form-check-label" for="id_gender_id_0">pan</label></div>
				</li>
				<li class="list__item">
					<div class="form-check"><input id="id_gender_id_1" class="form-check-input" type="radio" name="gender_id" value="2"> <label class="form-check-label" for="id_gender_id_1">paní</label></div>
				</li>
				<li class="list__item">
					<div class="form-check"><input id="id_gender_id_2" class="form-check-input" type="radio" name="gender_id" value="3"> <label class="form-check-label" for="id_gender_id_2">slečna</label></div>
				</li>
			</ul>
		</div>
		<div class="form-group form-group--id_firstname form-group--required">
			<label for="id_firstname" class="control-label">Jméno </label>
			<input maxlength="255" required="required" type="text" name="firstname" class="text form-control" id="id_firstname">
		</div>
		<div class="form-group form-group--id_lastname form-group--required">
			<label for="id_lastname" class="control-label">Příjmení </label>
			<input maxlength="255" required="required" type="text" name="lastname" class="text form-control" id="id_lastname">
		</div>
		<div class="form-group form-group--id_email form-group--required">
			<label for="id_email" class="control-label">E-mailová adresa </label>
			<input required="required" type="email" name="email" class="email text form-control" id="id_email" value="@">
		</div>
		<div class="form-group form-group--id_company form-group--optional">
			<label for="id_company" class="control-label">Společnost <small class="tip tip--optional">(Volitelné)</small>
			</label>
			<input maxlength="255" type="text" name="company" class="text form-control" id="id_company">
		</div>
		<div class="form-group form-group--id_company_number form-group--optional">
			<label for="id_company_number" class="control-label">IČ <small class="tip tip--optional">(Volitelné)</small>
			</label>
			<input type="text" name="company_number" class="text form-control" id="id_company_number">
		</div>
		<div class="form-group form-group--id_vat_id form-group--optional">
			<label for="id_vat_id" class="control-label">DIČ <small class="tip tip--optional">(Volitelné)</small>
			</label>
			<input type="text" name="vat_id" class="text form-control" id="id_vat_id">
		</div>
		<div class="form-group form-group--id_address_street form-group--required">
			<label for="id_address_street" class="control-label">Ulice a č.p. </label>
			<input maxlength="255" required="required" type="text" name="address_street" class="text form-control" id="id_address_street">
		</div>
		<div class="form-group form-group--id_address_city form-group--required">
			<label for="id_address_city" class="control-label">Město </label>
			<input maxlength="255" required="required" type="text" name="address_city" class="text form-control" id="id_address_city">
		</div>
		<div class="form-group form-group--id_address_state form-group--optional">
			<label for="id_address_state" class="control-label">Stát / Provincie / Kraj <small class="tip tip--optional">(Volitelné)</small>
			</label>
			<input maxlength="255" type="text" name="address_state" class="text form-control" id="id_address_state">
		</div>
		<div class="form-group form-group--id_address_zip form-group--required">
			<label for="id_address_zip" class="control-label">PSČ </label>
			<input required="required" type="text" name="address_zip" class="text form-control" id="id_address_zip">
		</div>
		<div class="form-group form-group--id_address_country form-group--required">
			<label for="id_address_country" class="control-label">Země </label>
			<select name="address_country" class="form-control" id="id_address_country">
				<option value="">-- země --</option>
			</select>
		</div>
		<div class="form-group form-group--id_phone form-group--required">
			<label for="id_phone" class="control-label">Telefon </label>
			<input required="required" type="text" name="phone" class="text form-control" id="id_phone" value="+420 ">
			<div class="form-text help-block">Telefonní číslo zadejte ve formátu +420 605 123 456</div>
		</div>
		<div class="form-group form-group--id_password form-group--required">
			<label for="id_password" class="control-label">Heslo </label>
			<input class="form-control" maxlength="255" required="required" type="password" name="password" id="id_password">
		</div>
		<div class="form-group form-group--id_password_repeat form-group--required">
			<label for="id_password_repeat" class="control-label">Heslo (opakování) </label>
			<input class="form-control" maxlength="255" required="required" type="password" name="password_repeat" id="id_password_repeat">
		</div>
		<div class="form-group">
			<span class="button-container"><button type="submit" class="btn btn-primary">Registrovat</button></span>
		</div>
	</fieldset>
	<div>
		<input type="hidden" name="_csrf_token_" value="">
	</div>
</form>
[/example]

### Inline search form
Note: search form in navbar has slightly different markup, see Navbar section of this styleguide.
[example]
<form action="#" method="get" id="form_searches_index" class="form-inline">
	<label for="id_q" class="control-label mb-2 mb-sm-0 mr-sm-2">Hledat</label>
	<input type="search" name="q" value="" class="search text form-control mb-2 mb-sm-0 mr-sm-2" id="id_q">
	<button type="submit" class="btn btn-primary"> <i class="icon ion-ios-search-strong" title=""></i> Hledat</button>
</form>
[/example]

## Validation feedback
Markup is the same for both basic and horizontal form.
[example]
<form class="form-horizontal">

	<div class="form-group form-group--id_email form-group--required form-group--has-error">
		<label for="id_email" class="control-label">E-mailová adresa </label>
		<input required="required" type="email" name="email" class="email text form-control" id="id_email" value="@">

		<div class="feedback feedback--invalid">
			<ul class="list">
				<li class="list__item"><span class="fas fa-exclamation-circle"></span> Zadejte platnou e-mailovou adresu.</li>
			</ul>
		</div>

	</div>
	
	<div class="form-group form-group--id_company form-group--optional form-group--is-valid">
		<label for="id_company" class="control-label">Společnost </label>
		<input maxlength="255" type="text" name="company" class="text form-control" id="id_company">

		<div class="feedback feedback--valid"><span class="sr-only">OK</span></div>

	</div>

</form>
[/example]

## Special form controls
Only items different from standard Bootstrap form controls are described here.

### Radios list
[example]
<form class="form-horizontal">
	<div class="form-group">
		<ul class="list list--radios">
			<li class="list__item">
				<div class="form-check"><input id="id_0" class="form-check-input" type="radio" name="gender_id" value="1"> <label class="form-check-label" for="id_0">pan</label></div>
			</li>
			<li class="list__item">
				<div class="form-check"><input id="id_1" class="form-check-input" type="radio" name="gender_id" value="2"> <label class="form-check-label" for="id_1">paní</label></div>
			</li>
			<li class="list__item">
				<div class="form-check"><input id="id_2" class="form-check-input" type="radio" name="gender_id" value="3"> <label class="form-check-label" for="id_2">slečna</label></div>
			</li>
		</ul>
	</div>
</form>
[/example]

### Radios list with images
Useful for building shipping methods or payment methods selectors.
[example]
<form>
<div class="form-group form-group--id_delivery_method_id_0 form-group--required">
	<label for="id_delivery_method_id_0" class="control-label">Vyberte způsob dopravy </label>
	<ul class="list list--radios">
		<li class="list__item checked" data-id="11">
			<div class="form-check"><input id="id_delivery_method_id_0" type="radio" name="delivery_method_id" value="11" class="form-check-input" checked="checked" data-branch_needed=""><label for="id_delivery_method_id_0" class="form-check-label"><span class="v-image"><img src="http://i.pupiq.net/i/6f/6f/955/2e955/300x300/O01dyC_100x100_a677ac8eb6fd674d.png" alt=""></span><span class="v-description"><span class="v-name">Česká pošta (platba předem)</span></span> <span class="v-price for-free">Zdarma</span></label></div>
		</li>
		<li class="list__item" data-id="12">
			<div class="form-check"><input id="id_delivery_method_id_1" type="radio" name="delivery_method_id" value="12" class="form-check-input" data-branch_needed=""><label for="id_delivery_method_id_1" class="form-check-label"><span class="v-image"><img src="http://i.pupiq.net/i/6f/6f/955/2e955/300x300/O01dyC_100x100_a677ac8eb6fd674d.png" alt=""></span><span class="v-description"><span class="v-name">Česká pošta (dobírka)</span></span> <span class="v-price for-free">Zdarma</span></label></div>
		</li>
		<li class="list__item" data-id="13">
			<div class="form-check"><input id="id_delivery_method_id_2" type="radio" name="delivery_method_id" value="13" class="form-check-input" data-branch_needed=""><label for="id_delivery_method_id_2" class="form-check-label"><span class="v-description"><span class="v-name">Osobní převzetí na prodejně</span></span> <span class="v-price for-free">Zdarma</span></label></div>
		</li>
	</ul>
</div>
</form>
[/example]



