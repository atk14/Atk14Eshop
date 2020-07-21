Checkout Navigation
===================

## Progress Timeline

[example]
<ol class="timeline">
	<li role="presentation" class="timeline__item">
		<a href="#"><span class="timeline__item-title"><span class="timeline__item-title-txt">Košík</span></span></a>
	</li>
	<li role="presentation" class="timeline__item active">
		<span class="timeline__item-title"><span class="timeline__item-title-txt">Doprava a platba</span></span>
	</li>
	<li role="presentation" class="timeline__item disabled">
		<span class="timeline__item-title"><span class="timeline__item-title-txt">Doručovací data</span></span>
	</li>
	<li role="presentation" class="timeline__item disabled">
		<span class="timeline__item-title"><span class="timeline__item-title-txt">Souhrn</span></span>
	</li>
</ol>
[/example]

## Checkout Footer Navigation

Includes buttons visible only in browser without JavaScript

[example]
<div class="form__footer">
	<a class="btn btn-lg btn-secondary btn--back btn--arrow-l" href="#">Zpět do katalogu</a>	<button type="submit" class="btn btn-secondary btn-lg nojs-only">Přepočítat obsah košíku</button>
	<button type="submit" name="continue" class="btn btn-primary btn-lg">Vyberte způsob dopravy a platby</button>
</div>
[/example]

Example with consent checkboxes and information

[example]
<div class="form__footer">

	<a class="btn btn-lg btn-secondary btn--back btn--arrow-l" href="/cs/checkouts/set_billing_and_delivery_data/">Zpět na dodací údaje</a>
	
	<div class="form__confirmation">

		<div class="form-group form-group--checkbox form-group--id_sign_up_for_newsletter form-group--optional">
			<div class="form-check custom-control custom-checkbox">
				<input class="custom-control-input form-check-input" id="id_sign_up_for_newsletter" type="checkbox" name="sign_up_for_newsletter"> <label class="form-check-label custom-control-label" for="id_sign_up_for_newsletter">
					Přihlásit se k odběru newsletteru
				</label>
			</div>
		</div>

		<div class="form-group form-group--checkbox form-group--id_confirmation form-group--optional">
			<div class="form-check custom-control custom-checkbox">
				<input class="custom-control-input form-check-input" id="id_confirmation" type="checkbox" name="confirmation"> <label class="form-check-label custom-control-label" for="id_confirmation">
					Souhlasím s obchodními podmínkami
				</label>
			</div>
		</div>

		Kliknutím na tlačítko Dokončit objednávku souhlasíte<br>a&nbsp;potvrzujete, že&nbsp;jste se seznámil s&nbsp;<a href="/obchodni-podminky/" target="_blank">obchodními&nbsp;podmínkami.</a>
		
	</div>

	<div class="form-group">
		<span class="button-container"><button type="submit" class="btn btn-lg btn-primary">Dokončit objednávku</button></span>
	</div>

</div>
[/example]