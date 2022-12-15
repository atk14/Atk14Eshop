{if $basket->isEmpty()}
	<div class="basket-content__empty">
		{t}The shopping basket is empty.{/t}
	</div>
{else}
	{render partial="offcanvas_basket_items"}
{/if}
<script>
	$( ".js--basket_info_content" ).replaceWith({jstring}{render partial="shared/basket_info_content"}{/jstring});
</script>
