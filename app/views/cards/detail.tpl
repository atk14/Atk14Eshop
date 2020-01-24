<div class="row">
	<div class="col-12 col-md-7 col-xl-6 order-2 order-md-1 product__text">
		{admin_menu for=$card}
		{assign brand $card->getBrand()}
		{if $brand}
			{capture assign="brand_text"}{t}Brand:{/t} {a action="brands/detail" id=$brand}{$brand->getName()}{/a}{/capture}
		{/if}
		{capture assign="author"}
			{if $main_creators}
				{foreach $main_creators as $creator}{trim}
					{if $creator@iteration > 1}, {/if}
					{if $creator->getPage()}<a href="{$creator->getPage()|link_to_page}">{/if}{$creator}{if $creator->getPage()}</a>{/if}
				{/trim}{/foreach}
			{/if}
		{/capture}
		{render partial="shared/layout/content_header" title=$page_title teaser=$card->getTeaser()|markdown brand=$brand_text  tags=$card->getTags() author=$author}

		{render partial="products_to_basket"}
		
		<div class="product-info">
		{render partial="categories"}
		{render partial="creators"}

		{render partial="shared/attachments" object=$card}

		{foreach $card->getCardSections() as $section}
			<section class="section--product-info section--{$section->getTypeCode()}">
				{if $section->getName()}
				<h3 class="section__title">{$section->getName()}</h3>
				{/if}
				<div class="section__body">
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
				</div>
			</section>
		{/foreach}
		</div>	
	</div>
	<div class="col-12 col-md-5 col-xl-6 order-1 order-md-2 product__images">
		{*render partial="shared/product_gallery" images=$card->getImages()*}
		{render partial="gallery" card=$card}
		{*<div class="tags">{render partial="shared/tags" tags=$card->getTags()}</div>*}
		<div class="flags">
			{if $starting_price && $starting_price->discounted()}
				<div class="product__flag product__flag--sale product__flag--lg">
					<span class="product__flag__title">{t}Discount{/t}</span> <span class="product__flag__number">{$starting_price->getDiscountPercent()|round}&nbsp;%</span>
				</div>
			{/if}
		</div>
	</div>

</div>
<div class="linked-products">
	{render partial="related_cards"}
	{render partial="consumables"}
	{render partial="accessories"}
</div>
