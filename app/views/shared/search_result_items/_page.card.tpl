{assign root_page $page->getRootPage()}
{assign creator Creator::FindFirst("page_id",$page)}
<div class="card card--search {if $creator}card--search--creator{else}card--search--page{/if}">
	{if $creator}
	<div class="creator_profile">
	{/if}
		<div class="card__image">
			{a action="pages/detail" id=$page}
				{if $page->getImageUrl()}
					<img {!$page->getImageUrl()|img_attrs:'400x300x#ffffff'} alt="{$page->getTitle()}" class="card-img-top">
				{elseif $root_page->getImageUrl()}
					<img {!$root_page->getImageUrl()|img_attrs:'400x300x#ffffff'} alt="{$page->getTitle()}" class="card-img-top">
				{else}
					<img src="{$public}dist/images/default_image_400x300.svg" width="400" height="300" title="{t}no image{/t}" alt="" class="card-img-top">
				{/if}
			{/a}

			<div class="card__label">
				{if $creator}
					{t}Profil{/t}
				{else}
					{t}Informace{/t}
				{/if}
			</div>
		</div>

		<div class="card-body">
			<h4 class="card-title">
				{if $root_page->getId()!=$page->getId()}
					{a action="pages/detail" id=$root_page}{$root_page->getTitle()}{/a} /
				{/if}
				{a action="pages/detail" id=$page}{$page->getTitle()}{/a}
			</h4>
			<div class="card-text"><p>{$page->getTeaser()|markdown|strip_tags:false}</p></div>



		</div>

		<div class="card-footer">
			{a action="pages/detail" id=$page _class="btn btn-primary btn-sm"}{if $creator}{t}Zobrazit profil{/t}{else}{t}Zobrazit stránku{/t}{/if}{/a}
		</div>
	{if $creator}
	</div>
	{/if}
	{if $creator}
		<div class="creator_works">
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
							{!$card->getImage()|pupiq_img:"90x90x#ffffff":"title={$card->getName()},class='card-img-top'"}
							<div class="card-body">
								<h5 class="card-title">{$card->getName()}</h5>
							</div>
						{/a}
					{/if}
				{/foreach}
				</div>
			{/foreach}
		</div>
	{/if}
</div>
