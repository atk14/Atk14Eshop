<li class="list-group-item" data-id="{$store->getId()}">
		<div class="d-flex justify-content-between align-items-center">
			<div>
				{render partial="shared/list_thumbnail" image=$store->getImageUrl()}

				{$store->getName()}
				{if !$store->isVisible()}
					<em>({!"eye-slash"|icon} {t}invisible{/t})</em>
				{/if}
			</div>
			<div class="">
				{dropdown_menu}
					{a action="edit" id=$store}{!"pencil-alt"|icon} {t}Edit{/t}{/a}

					{capture assign="confirm"}{t 1=$store->getName()|h escape=no}You are about to permanently delete store %1
		Are you sure about that?{/t}{/capture}
					{if $store->isDeletable()}
						{a_destroy id=$store _confirm=$confirm}{!"trash-alt"|icon} {t}Delete{/t}{/a_destroy}
					{/if}
				{/dropdown_menu}
			</div>
	</div>	
</li>
