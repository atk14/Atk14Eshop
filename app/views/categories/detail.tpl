<header>
	<div class="jumbotron bg-transparent border border-secondary">
		<div class="row">
			<div class="col-12 col-md-6 d-md-flex flex-column justify-content-center">
				{admin_menu for=$category}
				<h1>{$page_title} <span class="badge badge-secondary">{$finder->getRecordsCount()}</span></h1>
				{if $category->getTeaser()}
					<div class="lead">{!$category->getTeaser()|markdown}</div>
				{/if}
			</div>
			<div class="col-12 col-md-6 text-md-right">
				{!$category->getImageUrl()|pupiq_img:"300x300":"class='img-fluid'"}
			</div>
		</div>
	</div>
</header>

<section class="border-top-0">
	{!$category->getDescription()|markdown}
</section>

{if $child_categories}
	<section class="child-categories">
		<h4>{t}Subcategories{/t}</h4>
		<nav>
			<div class="list-group list-group--categories">
				{foreach $child_categories as $c}
						{assign var=cc value=$c->getCategory()}
						{a path=$cc->getPath() _class="list-group-item list-group-item-action"}
						<div class="list-group-item-product">
							<div class="list-group-item-thumbnail">
							{if $cc->getImage()}
								{!$cc->getImage()|pupiq_img:"!36x36"}
							{/if}
							</div>
							<div>
								<h4 class="list-group-item-heading">{$cc->getName()} </h4>
								{if $cc->getTeaser()}
									<p class="list-group-item-text">{$cc->getTeaser()}</p>
								{/if}
							</div>
						</div>
						<span class="badge badge-pill badge-secondary">{$c->getCardsCount()}</span>
					{/a}
				{/foreach}
			</div>
		</nav>
	</section>
{/if}

{render partial='shared/filter/filter_form' form=$form}

<section class="products" id='cards'>
	<h4>{t}Products{/t}</h4>
		{if $finder->isEmpty()}
			<p>{t}No product has been found.{/t}</p>
		{else}
		<div class="card-deck card-deck--sized product-list" data-record_count="{$finder->getRecordsCount()}">
			{render partial='shared/ajax_pager/ajax_pager'}
		</div>
	{/if}
</section>

{if $canonical_path}
	{content for=head}
		<link rel="canonical" href="{link_to action=detail path=$canonical_path}" />
	{/content}
{/if}
