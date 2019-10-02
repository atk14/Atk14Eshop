<header class="content-header{if $store->getImageUrl() } content-header--image{/if}"{if $store->getImageUrl() }style="background-image:url({!$store->getImageUrl()|img_url:"1200x400xcrop"})"{/if}>
	<div class="content-header__text">
		{admin_menu for=$store}
		<h1>{$store->getName()}</h1>
		{if $store->getTeaser()}
			<div class="lead">{!$store->getTeaser()|markdown}</div>
		{/if}
	</div>
</header>

<section class="store-properties">
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
					{icon glyph=phone} <a href="tel:{$store->getPhone()}">{$store->getPhone()}</a><br>
				{/if}
				{if $store->getEmail()}
					{icon glyph="envelope"} <a href="mailto:{$store->getEmail()}">{$store->getEmail()}</a>
				{/if}
				</p>
			</div>
	{/if}
	</div>
</section>

<section class="store-description">
	{!$store->getDescription()|markdown}
</section>

<div class="store-detail__map" id="store-map" data-lat="{$store->getLocationLat()}" data-lng="{$store->getLocationLng()}" data-zoom="16"></div>

<p>
<a class="" href="{link_to_map service="seznam" lat=$store->getLocationLat() lng=$store->getLocationLng()}">{!"map"|icon:"regular"} {t}Velká mapa{/t}</a>
</p>

{render partial="shared/photo_gallery" object=$store photo_gallery_title=""}

{render partial="shared/mapy_cz_api_loader"}
