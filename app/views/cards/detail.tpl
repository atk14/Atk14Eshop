<header>
	{admin_menu for=$card}
	<h1>{$page_title}</h1>

	<div class="lead">
		{!$card->getTeaser()|markdown}
	</div>

	{assign brand $card->getBrand()}
	{if $brand}
		{t}Brand:{/t} {a action="brands/detail" id=$brand}{$brand->getName()}{/a}
	{/if}

</header>

{render partial="products_to_basket"}

{render partial="categories"}

{render partial="shared/photo_gallery" images=$card->getImages()}

{render partial="shared/attachments" object=$card}

{foreach $card->getCardSections() as $section}
	<section>
	<h3>{$section->getName()}</h3>

	{!$section->getBody()|markdown}

	{*** Variants ***}
	{if $section->getTypeCode()=="variants"}
		{render partial=variants}
	{/if}

	{*** Technical Specifications ***}
	{if $section->getTypeCode()=="tech_spec"}
		{render partial="technical_specifications"}
	{/if}

	{render partial="shared/photo_gallery" object=$section}

	{render partial="shared/attachments" object=$section}
	</section>
{/foreach}

{render partial="related_cards"}
{render partial="consumables"}
{render partial="accessories"}
