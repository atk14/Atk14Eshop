{assign root_page $page->getRootPage()}
{assign creator Creator::FindFirst("page_id",$page)}

<li class="search-results-item">
	<div class="search-results-item--image">
		{if $page->getImageUrl()}
			{a action="pages/detail" id=$page}
				<img {!$page->getImageUrl()|img_attrs:'600x450'} alt="{$page->getTitle()}" class="img-fluid">
			{/a}
		{elseif $root_page->getImageUrl()}
			{a action="pages/detail" id=$page}
				<img {!$root_page->getImageUrl()|img_attrs:'600x450'} alt="{$page->getTitle()}" class="img-fluid">
			{/a}
		{else}
		{/if}
	</div>
	<div class="search-results-item--body">
		<div>
			<h4 class="search-result-title">
				{if $root_page->getId()!=$page->getId()}
					{a action="pages/detail" id=$root_page}{$root_page->getTitle()}{/a} /
				{/if}
				{a action="pages/detail" id=$page}{$page->getTitle()}{/a}
			</h4>
			<p class="search-result-description">{$page->getTeaser()|markdown|strip_tags:false}</p>

			{if $creator}
				{assign max_cards 6}
				{foreach $creator->getRoles() as $role}
					<h5>{$role}</h5>
					<div class="card-deck card-deck--micro">
					{foreach $creator->getCards($role,["limit" => $max_cards+1]) as $card}
						
						{if $card@index==$max_cards}
							{a action="pages/detail" id=$page _title="{t}a další{/t}" _class="card card--micro card--link-more"}
								<div class="card-body">
									{!"plus"|icon} {t}a další{/t} {!"chevron-right"|icon}
								</div>
							{/a}
						{else}
							{a action="cards/detail" id=$card _class="card card--micro"}
								{!$card->getImage()|pupiq_img:"100x100x#ffffff":"title={$card->getName()},class='card-img-top'"}
								<div class="card-body">
									<h5 class="card-title">{$card->getName()}</h5>
								</div>
							{/a}
						{/if}
					{/foreach}
					</div>
				{/foreach}
			{/if}

		</div>
		<div class="search-results-item--actions">
			{a action="pages/detail" id=$page _class="btn btn-primary btn-sm"}{if $creator}{t}Zobrazit profil{/t}{else}{t}Zobrazit stránku{/t}{/if}{/a}
		</div>
	</div>
	<div class="search-results-item--tag">
		{if $creator}
			{t}Profil{/t}
		{else}
			{t}Informace{/t}
		{/if}
	</div>
</li>
