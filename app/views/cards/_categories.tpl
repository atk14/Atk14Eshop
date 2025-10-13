{if $categories && sizeof($categories)>=1}
	<section class="section--product-info section--categories">
		<h2 class="section__title">{t}Product locations{/t}</h2>
		<div class="section__body">
			<ul class="list--categories-mini">
			{foreach $categories as $category}
				<li>
					{foreach $category->getPathOfCategories() as $c}
						{if !$c->isMainRootCategory() || $c@last} {* It is not necessary to display root category (catalog) on every branch, unless the whole branch is just the root catalog *}
							<a href="{link_to action="categories/detail" path=$c->getPath()}">{$c->getName()}</a>
							{if !$c@last}&raquo;{/if}
						{/if}
					{/foreach}
				</li>
			{/foreach}
			</ul>
		</div>
	</section>
{/if}
