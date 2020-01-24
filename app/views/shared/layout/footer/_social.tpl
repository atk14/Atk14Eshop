<h5>{t}Social networks{/t}</h5>
{foreach [
	"facebook" => "facebook-square",
	"instagram" => "instagram",
	"linkedin" => "linkedin",
	"pinterest" => "pinterest-square",
	"snapchat" => "snapchat",
	"twitter" => "twitter",
	"vimeo" => "vimeo",
	"youtube" => "youtube"
] as $network => $icon}
	{if "app.contact.social.$network"|system_parameter}
		<a href="{"app.contact.social.$network"|system_parameter}" class="footer__socialicon">{!$icon|icon}</a>
	{/if}
{/foreach}

