<li class="list-group-item" data-id="{$bank_account->getId()}">
	<div class="item__properties">
		<div class="item__title">
			{render partial="shared/active_state" object=$bank_account}
			{$bank_account->getAccountNumber()} - {$bank_account->getName()}
			<br>
			<small></small>
		</div>

		<div class="item__properties">
			<small>{t}sales regions{/t}:</small><br>
			{render partial="shared/region_list" regions=$bank_account->getRegions()}
		</div>

		<div class="item__properties">
			<small>{t}currencies{/t}:</small><br>
			{to_sentence var=$bank_account->getCurrencies() last_word_connector=", "}
		</div>

		<div class="item__controls">
			{dropdown_menu}
				{a action=edit id=$bank_account}{!"pencil-alt"|icon} {t}Edit{/t}{/a}

				{if $bank_account->isDeletable()}
					{capture assign="confirm"}{t 1=$bank_account->getName()|h escape=no}You are about to permanently delete bank account %1.
Are you sure about that?{/t}{/capture}
					{a_destroy id=$bank_account _confirm=$confirm}{!"trash-alt"|icon} {t}Delete{/t}{/a_destroy}
				{/if}
			{/dropdown_menu}
		</div>
	</div>
</li>
