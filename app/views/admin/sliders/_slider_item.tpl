<li class="list-group-item" data-id="{$slider->getId()}">
	<div class="d-flex justify-content-between align-items-center">
		<div>
			{render partial="shared/list_thumbnail" image=$slider->getImageUrl()}
			{$slider->getName()}
		</div>
		
		{if strlen($slider->getCode())}<small>{$slider->getCode()}</small>{/if}

		<div>
			{dropdown_menu}
				{a action="slider_items/index" slider_id=$slider}{!"list"|icon} {t}Images{/t}{/a}
				{a action=edit id=$slider}{!"pencil-alt"|icon} {t}Edit{/t}{/a}

				{if $slider->isDeletable()}
					{capture assign="confirm"}{t 1=$slider->getName()|h escape=no}You are about to permanently delete image slider %1
	Are you sure about that?{/t}{/capture}
					{a_destroy id=$slider _confirm=$confirm}{!"trash-alt"|icon} {t}Delete{/t}{/a_destroy}
				{/if}
			{/dropdown_menu}
		</div>
	</div>
</li>
