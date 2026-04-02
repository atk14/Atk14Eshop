<li class="list-group-item" data-id="{$store->getId()}">
		<div class="item__properties">
			<div class="item__title">
				{render partial="shared/list_thumbnail" image=$store->getImageUrl()}

				{$store->getName()}
			</div>
			<span class="item__code">
				{if $store->getCode()|strlen}{$store->getCode()}{/if}
			</span>
			<span class="item__visibility-properties">
				<span class="item__visibility">
					{if !$store->isVisible()}{!"eye-slash"|icon} {t}invisible in the public list on web{/t}{/if}
				</span>
			</span>
			<div class="item__controls">
				{dropdown_menu}
					{a action="edit" id=$store}{!"pencil-alt"|icon} {t}Edit{/t}{/a}
					{a action="special_opening_hours/index" store_id=$store}{!"list"|icon} {t}Special opening hours{/t}{/a}
					{if $store->isVisible()}
					{a namespace="" action="stores/detail" id=$store}{!"eye"|icon} {t}Visit public link{/t}{/a}
					{/if}

					{capture assign="confirm"}{t 1=$store->getName()|h escape=no}You are about to permanently delete store %1
		Are you sure about that?{/t}{/capture}
					{if $store->isDeletable()}
						{a_destroy id=$store _confirm=$confirm}{!"trash-alt"|icon} {t}Delete{/t}{/a_destroy}
					{/if}
				{/dropdown_menu}
			</div>
	</div>	
</li>
