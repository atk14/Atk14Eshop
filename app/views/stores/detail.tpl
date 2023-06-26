{admin_menu for=$store}
{render partial="shared/layout/content_header" title=$store->getName() teaser=$store->getTeaser()|markdown image=$store->getImageUrl() }

<section class="store-detail__properties">
	<div class="row">
		{*if $store->getOpeningHours()}
			<p class="col-12 col-md store-properties-column">
				<strong>{!"clock"|icon:"solid"} {t}Opening hours{/t}:</strong><br>
				{!$store->getOpeningHours()|h|nl2br}
				
			</p>
		{/if*}
		
		<div class="col-12 col-md store-properties-column">
			<p><strong>{!"clock"|icon:"solid"} {t}Opening hours{/t}:</strong></p>
			{if $store->isOpen()}
				<p class="store-is-open"><span class="badge badge-success">{t}Právě otevřeno{/t}</span></p>
			{/if}
			<table class="table table-sm table-borderless table--opening-hours">
				<tbody>
					{render partial="opening_hours_item" day=mon day_title="{t}Pondělí{/t}"}
					{render partial="opening_hours_item" day=tue day_title="{t}Úterý{/t}"}
					{render partial="opening_hours_item" day=wed day_title="{t}Středa{/t}"}
					{render partial="opening_hours_item" day=thu day_title="{t}Čtvrtek{/t}"}
					{render partial="opening_hours_item" day=fri day_title="{t}Pátek{/t}"}
					{render partial="opening_hours_item" day=sat day_title="{t}Sobota{/t}"}
					{render partial="opening_hours_item" day=sun day_title="{t}Neděle{/t}"}
				</tbody>
			</table>
		</div>

		{if $store->getAddress()}
			<div class="col-12 col-md store-properties-column">
				<p><strong>{!"map-marker-alt"|icon} {t}Address{/t}:</strong></p>
				<p>{!$store->getAddress()|h|nl2br}</p>
			</div>
		{/if}

		{if $store->getPhone() || $store->getEmail()}
			<div class="col-12 col-md store-properties-column">
				<p>
				{if $store->getPhone()}
					{icon glyph=phone} <a href="tel:{$store->getPhone()}">{$store->getPhone()|display_phone}</a><br>
				{/if}
				{if $store->getEmail()}
					{icon glyph="envelope"} {no_spam}{$store->getEmail()}{/no_spam}
				{/if}
				</p>
			</div>
	{/if}
	</div>
</section>

<div class="row">
	<div class="store-detail__description col-12 col-md-6">
		{!$store->getDescription()|markdown}
	</div>
	{if $store->getLocationLat() && $store->getLocationLng()}
	<div class="store-detail__location col-12 col-md-6">
		<div class="store-detail__map" id="store-map" data-lat="{$store->getLocationLat()}" data-lng="{$store->getLocationLng()}" data-zoom="16" data-title="{$store->getName()}"></div>
		<p>
			<a class="" href="{link_to_map service="seznam" lat=$store->getLocationLat() lng=$store->getLocationLng()}">{!"map"|icon:"regular"} {t}Velká mapa{/t}</a>
		</p>
	</div>
	{/if}
</div>






{render partial="shared/photo_gallery" object=$store photo_gallery_title=""}

{render partial="shared/mapy_cz_api_loader"}
