{*
 * data-country - vychozi zobrazena zeme; "cs"
 * data-countries - seznam moznych zemi; "cs,sk,pl,de"
 * data-hiddenpoints="ParcelBox" - dostupne typy vydejnich mist: ParcelBox, ParcelShop, AlzaBox
 *}
{assign countries $basket->getDeliveryCountriesAllowed()}
<div id="ppl-parcelshop-map" data-language="{$lang}" data-country="{$countries.0|lower}" data-countries="{join(",",$countries)|lower}" data-mode="default"></div>
{render partial="shared/form"}
