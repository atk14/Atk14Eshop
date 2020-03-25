{capture assign="page_title"}{t}Digitální produkty{/t}{/capture}
{render partial="shared/layout/content_header" title=$page_title}


<div class="digital-products">
	{foreach $digital_contents_by_products as $digital_contents_by_product}
		<div class="digital-products__item">
			{assign product $digital_contents_by_product.product}
			<h4>{a action="cards/detail" id=$product->getCardId()}{$product->getName()}{/a}</h4>
			
			<ul class="list list--base-5 list--products">
				{foreach $digital_contents_by_product.items as $digital_content}
					<li class="list__item">
						<a href="{$digital_content->getDownloadUrl($order)}" class="pcard__link-wrapper">
							<article class="pcard">
								<div class="pcard__image pcard__image--small">
									{!$digital_content->getImageUrl()|pupiq_img:"250x"}
								</div>
								<div class="pcard__title">
									{$digital_content->getTitle()}
								</div>
								<div class="pcard__meta">{!"file"|icon} {t suffix=$digital_content->getSuffix()|upper}soubor %1{/t}, {$digital_content->getFilesize()|format_bytes}</div>
								<div class="pcard__footer">
									<span class="btn {if $digital_content->wasDownloaded($order)}btn-default{else}btn-primary{/if}">{!"download-alt"|icon} {t}Stáhnout{/t}</span>
								</div>
							</article>
						</a>
						{*
						{!$digital_content->getImageUrl()|pupiq_img:"80x"}<br>
						{$digital_content->getTitle()}<br>
						{t suffix=$digital_content->getSuffix()}soubor %1{/t}
						{$digital_content->getFilesize()|format_bytes}<br>
						<a href="{$digital_content->getDownloadUrl($order)}" class="btn {if $digital_content->wasDownloaded($order)}btn-default{else}btn-primary{/if}">{!"download-alt"|icon} {t}Stáhnout{/t}</a>*}
					</li>
				{/foreach}
			</ul>
			
	</div>
{/foreach}
</div>

{content for=head}
	<meta name="robots" content="noindex,nofollow,noarchive">
{/content}

