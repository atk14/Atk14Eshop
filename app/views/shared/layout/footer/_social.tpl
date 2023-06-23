{capture assign=links}{trim}
{foreach [
	"facebook" => "facebook-square",
	"instagram" => "instagram",
	"linkedin" => "linkedin",
	"pinterest" => "pinterest-square",
	"snapchat" => "snapchat",
	"twitter" => "twitter",
	"vimeo" => "vimeo",
	"youtube" => "youtube",
	"soundcloud" => "soundcloud"
] as $network => $icon}
	{if "app.contact.social.$network"|system_parameter}
		<a href="{"app.contact.social.$network"|system_parameter}" class="footer__socialicon" rel="nofollow noopener" title="{$network}" aria-label="{$network}">{!$icon|icon}</a>
	{/if}
{/foreach}
{/trim}{/capture}

{if $links}
	<div class="h5 footer__links-heading">{t}Social networks{/t}</div>
	{!$links}
{/if}
