var {$array_name} = [
{foreach from=$array key=time item=value}
	{if $random}{assign var=value rand(0,100)}{/if}
	{literal}{{/literal} t: {$time}, y: {$value} {literal}}{/literal}{if !$value@last},{/if}
{/foreach}
];
