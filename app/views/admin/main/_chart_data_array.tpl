var {$array_name} = [
{foreach from=$array key=time item=value}
	{if $random}{assign var=value 0|mt_rand:100}{/if}
	{literal}{{/literal} t: {$time}, y: {$value} {literal}}{/literal}{if !$value@last},{/if}
{/foreach}
];