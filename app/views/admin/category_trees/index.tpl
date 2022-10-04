<h1>{button_create_new}{t}Create new category tree{/t}{/button_create_new} {$page_title}</h1>

<ul class="list-group list-group-flush list-sortable" data-sortable-url="{link_to action="set_rank"}">
	{foreach $roots as $root}
		<li class="list-group-item" data-id="{$root->getId()}">
			<div class="item__properties">
				<div class="item__title">
					{$root->getName()}
					{if !$root->isVisible()}<em class="text-muted">({!"eye-slash"|icon} {t}invisible{/t})</em>{/if}
				</div>
				{if $root->getCode()}
					<div class="item__code">
						{$root->getCode()}
					</div>
				{/if}
				<div class="item__controls">
					{dropdown_menu}
					{a action="detail" id=$root}{!"project-diagram"|icon} {t}Detail{/t}{/a}
					{a action="categories/edit" id=$root}{!"edit"|icon} {t}Edit{/t}{/a}
					{if $root->isDeletable()}
							{capture assign="confirm"}{t 1=$root->getName()|h escape=no}You are about to delete the catalog tree %1.
		Are you sure?{/t}{/capture}
							{a_destroy action=destroy id=$root _method=post _confirm=$confirm}{!"trash-alt"|icon} {t}Delete{/t}{/a_destroy}
					{/if}
					{/dropdown_menu}
				</div>
			</div>
		</li>
	{/foreach}
</ul>
