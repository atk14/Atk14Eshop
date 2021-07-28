{trim}

{if $product_just_added}
		{capture assign=url_fav_prods}{link_to namespace="" action="favourite_products/index"}{/capture}
		<a href="{link_to namespace="" action="favourite_products/destroy" product_id=$product}" title="{t url_fav_prods=$url_fav_prods}Produkt byl přidán do <a href="%1">oblíbených</a>{/t}" class="remote_link post link--small fav_status fav_status--is_fav fav_status--just_added" data-remote="true" data-method="post">
			{!"heart"|icon} <span class="link__text">{t}Remove from favourites{/t}</span>
		</a>
{elseif $favourite_products_accessor->isFavouriteProduct($product)}
		<a href="{link_to namespace="" action="favourite_products/destroy" product_id=$product}" title="{t}Odebrat z oblíbených{/t}" class="remote_link post link--small fav_status fav_status--is_fav" data-remote="true" data-method="post">
			{!"heart"|icon} <span class="link__text">{t}Remove from favourites{/t}</span>
		</a>
{else}
		<a href="{link_to namespace="" action="favourite_products/create_new" product_id=$product}" title="{t}Přidat do oblíbených{/t}" class="remote_link post link--small fav_status fav_status--not_fav" data-remote="true" data-method="post">
			{!"heart"|icon:"regular"} <span class="link__text">{t}Add to favourites{/t}</span>
		</a>
{/if}

{/trim}
