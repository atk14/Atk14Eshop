{render partial="shared/layout/content_header" title=$page_title}

{render partial="detail"}

<p>	
	{capture assign=sitemap_url}{link_to action=index lang=Atk14Global::GetInstance()->getDefaultLang() _with_hostname=1}{/capture}
	{capture assign=sitemap_link}<a href="{$sitemap_url}">{$sitemap_url}</a>{/capture}
	{t sitemap_link=$sitemap_link escape=0}A complete sitemap is available at %1.{/t}
</p>
