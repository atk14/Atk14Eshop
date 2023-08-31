{render partial="shared/checkout_navigation"}

<div class="basket-edit-header-wrapper">
	{render partial="shared/layout/content_header" title=$page_title}
	{render partial="regions/set_region_form" form=$set_region_form}
</div>

{form _class="form" _novalidate="novalidate"}
	{render partial="shared/form_error"}

	<div class="form__body">
		<div class="row">
			<div class="col-12 col-md-6">
				{render partial="shared/form_field" fields="delivery_method_id"}
			</div>
			<div class="col-12 col-md-6">
				{render partial="shared/form_field" fields="payment_method_id"}
			</div>
		</div>
	</div>
	{***********************************************************************************************************}
	<div class="form__body">


		<div class="row">
			<div class="col-12 col-md-6">
				
				<div class="form-group form-group--id_delivery_method_id_0 form-group--required">
					<label for="id_delivery_method_id_0" class="control-label">Vyberte způsob dopravy			</label>
<ul class="list list--radios list--radios--lg">
										
<style scoped="true">
	li.list__item > * > *{
		border: 1px dotted red;
	}
	li.list__item > * > * > *{
		border: 1px dotted blue;
	}
</style>

<li class="list__item" data-id="20">
	<div class="form-check form-check--has-image">
		<input id="id_delivery_method_id_7" data-branch_needed="1" type="radio" name="delivery_method_id" value="20" class="form-check-input">
		<label for="id_delivery_method_id_7" class="form-check-label">
			<span class="v-image"><img src="http://i.pupiq.net/i/6f/6f/4c5/304c5/800x800/TJbgui_100x100xffffff_877bc8d10f859fbf.png" alt=""></span>
			<span class="v-description"><span class="v-name">Zásilkovna (dobírka)</span>
				<div class="v-hint">
					<p>I'm baby seitan offal austin stumptown cred pour-over lo-fi raclette. Live-edge umami iPhone gastropub, pour-over flannel pug yuccie. Forage vegan flannel, poke kinfolk yuccie vaporware.</p>
					<ul>
						<li>Franzen cliche artisan subway tile hella you probably haven't heard of them.</li>
						<li>Salvia sustainable la croix poke letterpress squid.</li>
						<li>Listicle health goth keffiyeh fanny pack raclette godard chambray tumblr put a bird on it meditation selfies authentic biodiesel.</li>
					</ul>
				</div>
			</span>
			<span class="v-price for-free">Zdarma</span>
		</label>
	</div>
	<div class="delivery_service_branch">
		<span class="branch_button"><a href="/cs/delivery_service_branches/set_branch/?delivery_method_id=20" class="btn btn-outline-secondary btn-xs remote_link" data-remote="true">zvolit výdejní místo</a></span>
		<span class="branch_address"></span>
		<div class="clearfix"></div>
	</div>
</li>

<li class="list__item" data-id="00">
	<div class="form-check form-check--with-image">
		<input id="id_delivery_method_id_7" data-branch_needed="1" type="radio" name="delivery_method_id" value="20" class="form-check-input">
		<label for="id_delivery_method_id_7" class="form-check-label">
			<span class="label__image"><img src="http://i.pupiq.net/i/6f/6f/4c5/304c5/800x800/TJbgui_100x100xffffff_877bc8d10f859fbf.png" alt=""></span>
			<span class="label__name">Zásilkovna (dobírka)</span>
			<div class="label__description">
				<p>I'm baby seitan offal austin stumptown cred pour-over lo-fi raclette. Live-edge umami iPhone gastropub, pour-over flannel pug yuccie. Forage vegan flannel, poke kinfolk yuccie vaporware.</p>
				<ul>
					<li>Franzen cliche artisan subway tile hella you probably haven't heard of them.</li>
					<li>Salvia sustainable la croix poke letterpress squid.</li>
					<li>Listicle health goth keffiyeh fanny pack raclette godard chambray tumblr put a bird on it meditation selfies authentic biodiesel.</li>
				</ul>	
			</div>
			<span class="label__price label__price--for-free">Zdarma</span>
		</label>
	</div>
</li>

<li class="list__item" data-id="00">
	<div class="form-check form-check--with-image">
		<input id="id_delivery_method_id_7" data-branch_needed="1" type="radio" name="delivery_method_id" value="20" class="form-check-input">
		<label for="id_delivery_method_id_7" class="form-check-label">
			<span class="label__name">Zásilkovna (dobírka)</span>
			<div class="label__description">
				<p>I'm baby seitan offal austin stumptown cred pour-over lo-fi raclette. Live-edge umami iPhone gastropub, pour-over flannel pug yuccie. Forage vegan flannel, poke kinfolk yuccie vaporware.</p>
				<ul>
					<li>Franzen cliche artisan subway tile hella you probably haven't heard of them.</li>
					<li>Salvia sustainable la croix poke letterpress squid.</li>
					<li>Listicle health goth keffiyeh fanny pack raclette godard chambray tumblr put a bird on it meditation selfies authentic biodiesel.</li>
				</ul>	
			</div>
			<span class="label__price label__price--for-free">Zdarma</span>
		</label>
	</div>
</li>


</ul>
		
					
					
					

				</div>


			</div>
			<div class="col-12 col-md-6">
				sec column
			</div>
		</div>
	</div>
	{***********************************************************************************************************}

	<div class="form__footer">
		{a action="baskets/edit" _class="btn btn-lg btn-secondary btn--back btn--arrow-l"}{t}Back to basket content{/t}{/a}
		{render partial="shared/form_button" class="btn btn-primary btn-lg"}
	</div>
{/form}

