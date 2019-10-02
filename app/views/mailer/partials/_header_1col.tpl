{*
	Full width header with centered logo.
	Colors and logo url are set in application_mailer.php controller.
	{render partial="partials/header_1col"}
*}
<table align="center" class="wrapper header float-center" style="Margin:0 auto;background:{$header_bgcolor};border-collapse:collapse;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><td class="wrapper-inner" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:{$font_stack};font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:20px;text-align:left;vertical-align:top;word-wrap:break-word">
	<table align="center" class="container" style="Margin:0 auto;background:0 0;border-collapse:collapse;border-spacing:0;margin:0 auto;padding:0;text-align:inherit;vertical-align:top;width:{$body_width}"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:{$font_stack};font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">
		<table class="row collapse" style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top">
			<th class="small-12 large-12 columns first last" style="Margin:0 auto;color:#0a0a0a;font-family:{$font_stack};font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:0;padding-left:0;padding-right:0;text-align:left;width:588px"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th style="Margin:0;color:{$header_color};font-family:{$font_stack};font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left">
				<center data-parsed style="min-width:532px;width:100%">
					<a href="{!$region->getDefaultUrl()}" style="border:none;outline:none;text-decoration:none;color:{$header_color}">
					<img src="{$logo_src}" align="center" class="float-center" style="-ms-interpolation-mode:bicubic;Margin:0 auto;clear:both;display:block;float:none;margin:0 auto;max-width:100%;outline:0;text-align:center;text-decoration:none;width:auto;border: none;" alt="{$region->getApplicationName()}">
					</a>
				</center>
			</th>
<th class="expander" style="Margin:0;color:#0a0a0a;font-family:{$font_stack};font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;text-align:left;visibility:hidden;width:0"></th></tr></table></th>
		</tr></tbody></table>
	</td></tr></tbody></table>
</td></tr></table>