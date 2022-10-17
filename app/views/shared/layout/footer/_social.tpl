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
		<a href="{"app.contact.social.$network"|system_parameter}" class="footer__socialicon" rel="nofollow noopener">{!$icon|icon}</a>
	{/if}
{/foreach}
{/trim}{/capture}

{if $links}
	<h5>{t}Social networks{/t}</h5>
	{!$links}
{/if}
