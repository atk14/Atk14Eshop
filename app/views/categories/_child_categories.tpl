	<section class="section--child-categories">
		{assign var="cat_list_class" ""}
		{foreach $child_categories as $c}
			{assign var=cc value=$c->getCategory()}
			{if $cc->getTeaser()}
				{assign var="cat_list_class_1" "list--categories--teasers"}
			{/if}
			{if $cc->getImage()}
				{assign var="cat_list_class_2" "list--categories--images"}
			{/if}
		{/foreach}
		<ul class="list-unstyled list--categories {$cat_list_class_1} {$cat_list_class_2}">
			{foreach $child_categories as $c}
			{assign var=cc value=$c->getCategory()}
			<li class="list-item">
				{a path=$cc->getPath()}
					{if $cc->getImage()}
						{!$cc->getImage()|pupiq_img:"!60x60":"class='child-category__image'"}
					{else}	
						<img src="{$public}images/camera.svg" width="60" height="60" class="child-category__image">
					{/if}
				<div class="child-category__text">
					<h4 class="child-category__text__title">{$cc->getName()} <small>({$c->getCardsCount()})</small>&nbsp;{!"angle-right"|icon}</h4>
					{if $cc->getTeaser()}
						<p class="child-category__text__teaser">{$cc->getTeaser()|markdown|strip_tags|truncate:200}</p>
					{/if}
				</div>
				{/a}
			</li>
			{/foreach}
		</ul>
	</section>
