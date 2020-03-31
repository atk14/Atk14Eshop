{capture assign="page_title"}{t}Digitální produkty{/t}{/capture}
{render partial="shared/layout/content_header" title=$page_title}


<div class="digital-products">
	{foreach $digital_contents_by_products as $digital_contents_by_product}
		<div class="digital-products__item">
			<div class="item__header">
				{assign product $digital_contents_by_product.product}
				<h2 class="item__title">{$product->getName()}</h2>
				{a action="cards/detail" id=$product->getCardId()}Podrobnosti o produktu {!"chevron-right"|icon}{/a}
			</div>
			<div class="list list--files">
			{foreach $digital_contents_by_product.items as $digital_content}
				<a href="{$digital_content->getDownloadUrl($order)}" class="list__item">
					<div class="file__thumbnail">
						{!$digital_content->getImageUrl()|pupiq_img:"150x150":"class='img-fluid'"}
					</div>
					<div class="file__icon">
						{assign var="suffix" $digital_content->getSuffix()|lower}
						<span class="fileicon fileicon-{$suffix} fileicon-color" data-icon-text="{$suffix}"></span>
					</div>
					<div class="file__text">
						<div class="file__title">{!$digital_content->getTitle()|breakable_word}</div>
						<div class="file__meta">{t suffix=$digital_content->getSuffix()|upper}soubor %1{/t}, {$digital_content->getFilesize()|format_bytes}</div>
					</div>
					<div class="file__actions">
						<span class="btn {if $digital_content->wasDownloaded($order)}btn-secondary{else}btn-primary{/if}">{!"cloud-download-alt"|icon} {t}Stáhnout{/t}</span>
					</div>
				</a>
				{/foreach}
			</div>
			
	</div>
{/foreach}
</div>

{content for=head}
	<meta name="robots" content="noindex,nofollow,noarchive">
{/content}

