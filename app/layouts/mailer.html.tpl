<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/strict.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>{t region=$region->getApplicationName()}Zpráva z obchodu %1{/t}</title>
	{literal}
	<style>@media only screen{html{min-height:100%;background:{/literal}{$bg_color}{literal}}}@media only screen and (max-width:596px){.small-float-center{margin:0 auto!important;float:none!important;text-align:center!important}.small-text-left{text-align:left!important}}@media only screen and (max-width:596px){table.body img{width:auto;height:auto}table.body center{min-width:0!important}table.body .container{width:95%!important}table.body .columns{height:auto!important;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;box-sizing:border-box;padding-left:16px!important;padding-right:16px!important}table.body .columns .columns{padding-left:0!important;padding-right:0!important}table.body .collapse .columns{padding-left:0!important;padding-right:0!important}th.small-6{display:inline-block!important;width:50%!important}th.small-12{display:inline-block!important;width:100%!important}.columns th.small-12{display:block!important;width:100%!important}table.menu{width:100%!important}table.menu td,table.menu th{width:auto!important;display:inline-block!important}table.menu.vertical td,table.menu.vertical th{display:block!important}table.menu[align=center]{width:auto!important}}</style>
	{/literal}
</head>
<body style="-moz-box-sizing:border-box;-ms-text-size-adjust:100%;-webkit-box-sizing:border-box;-webkit-text-size-adjust:100%;Margin:0;background:{$bg_color}!important;box-sizing:border-box;color:#0a0a0a;font-family:{$font_stack};font-size:16px;font-weight:400;line-height:1.3;margin:0;min-width:100%;padding:0;text-align:left;width:100%!important">
<!-- header -->{* tato znacka se pouziva pri konverzi HTML textu do plain text *}

	{if $preheader_text}
	<span class="preheader" style="color:{$bg_color};display:none!important;font-size:1px;line-height:1px;max-height:0;max-width:0;mso-hide:all!important;opacity:0;overflow:hidden;visibility:hidden">{!$preheader_text}</span>
	{/if}

	{render partial="partials/mail_wrapper_start"}
	{render partial="partials/header_1col"}
	
	{render partial="partials/spacer" height=40}
	{render partial="partials/container_start"}
	
	
	{* ---------------------------------------- *}

<!-- /header -->

		{placeholder}
		<br/><br/>

		{capture assign="email"}<a href="mailto:{"app.contact.email"|system_parameter}" style="{$link_style}">{"app.contact.email"|system_parameter}</a>{/capture}
		{t email=$email escape=no}V případě dotazů nás můžete kontaktovat na e-mailu %1{/t}
		<br/>
		<br/>
		{placeholder for="extra_message"}
		{t name="app.name.yours"|system_parameter escape=no}Krásný den přeje<br/>%1{/t}
	
<!-- footer -->{* tato znacka se pouziva pri konverzi HTML textu do plain text *}

{* ---------------------------------------- *}
	{render partial="partials/container_end"}
	{render partial="partials/spacer" height=100}
	{render partial="partials/footer"}
	{render partial="partials/mail_wrapper_end"}
<!-- /footer -->
</body>
</html>
