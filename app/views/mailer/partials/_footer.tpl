{assign eshop Store::FindByCode("eshop")}

<table align="center" class="wrapper footer float-center" style="Margin:0 auto;background:{$footer_bgcolor};border-collapse:collapse;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><td class="wrapper-inner" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:{$font_stack};font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:20px;text-align:left;vertical-align:top;word-wrap:break-word">
            	<table align="center" class="container" style="Margin:0 auto;background:0 0;border-collapse:collapse;border-spacing:0;margin:0 auto;padding:0;text-align:inherit;vertical-align:top;width:{$body_width}"><tbody><tr style="padding:0;text-align:left;vertical-align:top"><td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:{$font_stack};font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">
            		<table class="row" style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top">
            			<th class="small-12 large-6 columns first" style="Margin:0 auto;color:#0a0a0a;font-family:{$font_stack};font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:40px 20px;padding-bottom:0;padding-left:16px;padding-right:8px;text-align:left;width:274px"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th style="Margin:0;color:#0a0a0a;font-family:{$font_stack};font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left">
            				<address style="font-style:normal">
            					<p style="Margin:0;Margin-bottom:10px;color:{$footer_color};font-family:{$font_stack};font-size:16px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left">
            						{"app.name.official"|system_parameter}<br/>
												{if $eshop}
            						{$eshop->getAddressStreet()}<br/>
												{if $eshop->getAddressStreet2()}
            						{$eshop->getAddressStreet2()}<br/>
												{/if}
            						{$eshop->getAddressZip()} {$eshop->getAddressCity()}<br/>
												{/if}
            					</p>
            					<p style="Margin:0;Margin-bottom:10px;color:{$footer_color};font-family:{$font_stack};font-size:16px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left">
            						{t}E-mail{/t}: <br/><a href="mailto:{"app.contact.email"|system_parameter}" style="Margin:0;color:{$footer_link_color};font-family:{$font_stack};font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left;text-decoration:none">{"app.contact.email"|system_parameter}</a>
            					</p>
            					<p style="Margin:0;Margin-bottom:10px;color:{$footer_color};font-family:{$font_stack};font-size:16px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left">
            						{t}Tel.{/t}: <br/><a href="tel:{"app.contact.phone"|system_parameter|replace:".":""}" style="Margin:0;color:{$footer_link_color};font-family:{$font_stack};font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left;text-decoration:none">{"app.contact.phone"|system_parameter|display_phone}</a>
            					</p>
            				</address>
            			</th></tr></table></th>
            			<th class="small-12 large-6 columns last" style="Margin:0 auto;color:#0a0a0a;font-family:{$font_stack};font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:40px 20px;padding-bottom:0;padding-left:8px;padding-right:16px;text-align:left;width:274px"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th style="Margin:0;color:#0a0a0a;font-family:{$font_stack};font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left">
            				<p style="Margin:0;Margin-bottom:10px;color:{$footer_color};font-family:{$font_stack};font-size:16px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left">
            					{t escape=no}Sledujte nás na&nbsp;Facebooku:{/t}
            				</p>
            					<table class="button facebook expand" style="Margin:0 0 16px 0;border-collapse:collapse;border-spacing:0;margin:0 0 16px 0;padding:0;text-align:left;vertical-align:top;width:100%!important"><tr style="padding:0;text-align:left;vertical-align:top"><td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:{$font_stack};font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;background:#3B5998!important;border:2px solid #2199e8;border-collapse:collapse!important;border-color:#3B5998;color:#fefefe;font-family:{$font_stack};font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"><center data-parsed style="min-width:0;width:100%"><a href="{"app.contact.social.facebook"|system_parameter}" align="center" class="float-center" style="Margin:0;border:0 solid #2199e8;border-radius:3px;color:#fefefe;display:inline-block;font-family:{$font_stack};font-size:16px;font-weight:700;line-height:1.3;margin:0;padding:8px 16px 8px 16px;padding-left:0;padding-right:0;text-align:center;text-decoration:none;width:100%">Facebook</a></center></td></tr></table></td>
<td class="expander" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:{$font_stack};font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0!important;text-align:left;vertical-align:top;visibility:hidden;width:0;word-wrap:break-word"></td></tr></table>
            				
            			</th></tr></table></th>
            		</tr></tbody></table>
            		<table class="row" style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%"><tbody><tr style="padding:0;text-align:left;vertical-align:top">
            			<th class="smallprint small-12 large-12 columns first last" style="Margin:0 auto;color:#0a0a0a;font-family:{$font_stack};font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:40px 20px;padding-bottom:0;padding-left:16px;padding-right:16px;text-align:left;width:564px"><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"><tr style="padding:0;text-align:left;vertical-align:top"><th style="Margin:0;color:#0a0a0a;font-family:{$font_stack};font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left">
            				<small style="color:{$footer_color};font-size:80%">
											{assign first 1}
											{foreach [
												"terms_and_conditions",
												"privacy_policy"
											] as $code}
												{assign page Page::GetInstanceByCode($code)}
												{if $page}
													{if $first}{assign first 0}{else} | {/if}
													<a href="{$page|link_to_page:"with_hostname"}" style="color:{$footer_link_color};">{$page->getTitle()}</a>
												{/if}
											{/foreach}
            				</small>
            			</th>
<th class="expander" style="Margin:0;color:#0a0a0a;font-family:{$font_stack};font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;text-align:left;visibility:hidden;width:0"></th></tr></table></th>
            		</tr></tbody></table>
            	</td></tr></tbody></table>
            </td></tr></table>
