<h1>{$page_title}</h1>

<ul>
{foreach $vouchers as $key => $voucher}
	<li>
		{if !$voucher}
			{$key}
		{else}
			{$key} [ html:
				{foreach $voucher->getRegions() as $region}
					<a href="{$voucher->getUrl($region)}">{$region}</a>{if !$region@last},{/if}
				{/foreach}
			]
			[ pdf:
				{foreach $voucher->getRegions() as $region}
					<a href="{$voucher->getUrl($region,"pdf")}">{$region}</a>{if !$region@last},{/if}
				{/foreach}
			]
		{/if}
	</li>
{/foreach}
</ul>
