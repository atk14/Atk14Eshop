<h1>{$page_title}</h1>

{if !$watched_products}
	
	<p>{t}Momentálně pro Vás hlídací pes nehlídá naskladnění žádného produktu.{/t}</p>

{else}
	
	<table class="table table--products">
		<tbody>
		{foreach $watched_products as $wp}
			{assign product $wp->getProduct()}
			<tr>
				<td>
					<a href="{$product|link_to_product}">
						{render partial="shared/product_image" product=$product image_size=80}
					</a>
				</td>
				<td>
					<h4 class="product__title">
						<a href="{$product|link_to_product}">
						{$product->getName()}
						</a>
					<h4>
					<p class="product__number">{$product->getCatalogId()}</p>
				</td>
				<td>
					{if $wp->notified()}
						{t}hlídalo se od{/t}<br>
						{$wp->getCreatedAt()|format_date}
					{else}
						{t}hlídá se od{/t}<br>
						{$wp->getCreatedAt()|format_date}
					{/if}
				</td>
				<td>
					{if $wp->notified()}
						<div class="text-success float-left pr-2 pb-5">{!"check"|icon}</div> {t}naskladnění oznámeno{/t}<br>
						{$wp->getNotifiedAt()|format_date}
					{else}
						<div class="text-danger float-left pr-2 pb-5">{!"remove"|icon}</div> {t}zatím nenaskladněno{/t}
					{/if}
				</td>
			</tr>
		{/foreach}
		</tbody>
	</table>

{/if}
