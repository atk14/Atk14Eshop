{* toto se pouziva i v users/detail *}
{assign var=transaction value=$order->getMostRelevantPayuTransaction()}
{if $transaction && $transaction->getPayuStatus()}
	{PayuCz::GetStatusDescription($transaction->getPayuStatus(),true)} ({$transaction->getPayuStatus()})
{else}
	?
{/if}
