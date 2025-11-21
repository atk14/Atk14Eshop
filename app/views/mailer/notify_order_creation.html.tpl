{t escape=no}Vážený zákazníku,{/t}<br/><br/>

{render partial="thanks_for_order_lower.html"}

{if $special_note}
	
	{render partial="partials/title_box" content=$special_note|h|nl2br titlebg="{$special_note_bgcolor}" titlecolor="{$special_note_color}" space_before=0}
{/if}

{t}V případě osobního odběru vyčkejte na výzvu k vyzvednutí. Pokud jste zvolili úhradu bankovním převodem, podklady k úhradě objednávky Vám budou zaslány obratem.{/t}

{if $shipping_days|strlen}
	{if $shipping_days=="3-5"}
		{t shipping_days=$shipping_days}Objednávka bude expedována do %1 pracovních dní od připsání platby na náš bankovní účet.{/t}
	{else}
		{t shipping_days=$shipping_days}Objednávka bude expedována do %1 pracovních dnů od připsání platby na náš bankovní účet.{/t}
	{/if}
{/if}

<br/><br/>

{render partial="partials/title_box" content="{t}Detaily objednávky{/t}"}

{t order_no=$order->getOrderNo() created_at=$order->getCreatedAt()|format_datetime escape=no}Objednávka: <strong>č. %1 vytvořená %2</strong>{/t}<br/>
{t}Platba:{/t} <strong>{$order->getPaymentMethod()}</strong>

<br/>
<br/>

<table style="width: 100%; font-family: {$font_stack}; font-size: 11px; color: #374953;"><!-- Title -->
<tbody>
<tr style="background-color:{$table_header_bgcolor}; color:{$table_header_color}; text-align: center;">
	<th style="width: 15%; padding: 0.6em 0; background-color:{$table_header_bgcolor}; color:{$table_header_color};">{t}Kód{/t}</th>
	<th style="width: 30%; padding: 0.6em 0; background-color:{$table_header_bgcolor}; color:{$table_header_color};">{t}Produkt{/t}</th>
	<th style="width: 20%; padding: 0.6em 0; background-color:{$table_header_bgcolor}; color:{$table_header_color};">{t}Jedn. cena{/t}</th>
	<th style="width: 15%; padding: 0.6em 0; background-color:{$table_header_bgcolor}; color:{$table_header_color};">{t}Množství{/t}</th>
	<th style="width: 20%; padding: 0.6em 0; background-color:{$table_header_bgcolor}; color:{$table_header_color};">{t}Cena celkem{/t}</th>
</tr>
{foreach $order->getItems() as $item}
	{assign product $item->getProduct()}
	<tr style="background-color:{$table_cell_bgcolor}; color:{$table_cell_color};">
		{if $product->getCode()=="price_rounding"}
			<td style="padding: 0.6em 0.4em;width: 15%; background-color:{$table_cell_bgcolor}; color:{$table_cell_color};"></td>
			<td style="padding: 0.6em 0.4em;width: 30%; background-color:{$table_cell_bgcolor}; color:{$table_cell_color};"><strong>{$product->getName()}</strong></td>
			<td style="padding: 0.6em 0.4em; width: 20%; background-color:{$table_cell_bgcolor}; color:{$table_cell_color};"></td>
			<td style="padding: 0.6em 0.4em; width: 15%; background-color:{$table_cell_bgcolor}; color:{$table_cell_color};"></td>
			<td style="padding: 0.6em 0.4em; width: 20%;text-align:right; background-color:{$table_cell_bgcolor}; color:{$table_cell_color};">{!$item->getPriceInclVat()|display_price:"$currency"}</td>
		{else}
			<td style="padding: 0.6em 0.4em;width: 15%; background-color:{$table_cell_bgcolor}; color:{$table_cell_color};">{$product->getCatalogId()}</td>
			<td style="padding: 0.6em 0.4em;width: 30%; background-color:{$table_cell_bgcolor}; color:{$table_cell_color};"><strong><a href="{$product|link_to_product:"with_hostname=$default_domain"}" style="color:{$table_cell_color};">{$product->getName()}</a></strong></td>
			<td style="padding: 0.6em 0.4em; width: 20%; background-color:{$table_cell_bgcolor}; color:{$table_cell_color};">{!$item->getUnitPriceInclVat()|display_price:"$currency"}</td>
			<td style="padding: 0.6em 0.4em; width: 15%; background-color:{$table_cell_bgcolor}; color:{$table_cell_color};">{$item->getAmount()} {$product->getUnit()}</td>
			<td style="padding: 0.6em 0.4em; width: 20%;text-align:right; background-color:{$table_cell_bgcolor}; color:{$table_cell_color};">{!$item->getPriceInclVat()|display_price:"$currency"}</td>
		{/if}
	</tr>
{/foreach}
<tr style="text-align: right;">
	<td style="background-color:{$table_header_bgcolor}; color:{$table_header_color}; padding: 0.6em 0.4em;" colspan="4">{t}Cena celkem{/t}</td>
	<td style="background-color:{$table_header_bgcolor}; color:{$table_header_color}; padding: 0.6em 0.4em;">{!$order->getItemsPriceInclVat()|display_price:"$currency"}</td>
</tr>

</tbody>
</table>
<table style="width: 100%; font-family:
{$font_stack}; font-size: 11px;"><colgroup><col style="width: 15%; padding: 0.6em 0;" /> <col style="width: 30%; padding: 0.6em 0;" /> <col style="width: 20%; padding: 0.6em 0;" /> <col style="width: 15%; padding: 0.6em 0;" /> <col style="width: 20%; padding: 0.6em 0;" /> </colgroup>
<tbody>
	{foreach $order->getVouchers() as $voucher}
		<tr style="text-align: right;">
			<td style="background-color:{$table_cell_bgcolor}; color:{$table_cell_color}; padding: 0.6em 0.4em;" colspan="4">{$voucher->getDescription()} {$voucher}</td>
			<td style="background-color:{$table_cell_bgcolor}; color:{$table_cell_color}; padding: 0.6em 0.4em;">{if $voucher->getDiscountAmount()}-{!$voucher->getDiscountAmount()|display_price:"$currency"}{/if}</td>
		</tr>
	{/foreach}
	{foreach $order->getCampaigns() as $campaign}
		{if $campaign->getDiscountAmount()}
			<tr style="text-align: right;">
				<td style="background-color:{$table_cell_bgcolor}; color:{$table_cell_color}; padding: 0.6em 0.4em;" colspan="4">{$campaign}</td>
				<td style="background-color:{$table_cell_bgcolor}; color:{$table_cell_color}; padding: 0.6em 0.4em;">-{!$campaign->getDiscountAmount()|display_price:"$currency"}</td>
			</tr>
		{/if}
	{/foreach}
	<tr style="text-align: right;">
		<td style="background-color:{$table_cell_bgcolor}; color:{$table_cell_color}; padding: 0.6em 0.4em;" colspan="4">{t}Doprava{/t}</td>
		<td style="background-color:{$table_cell_bgcolor}; color:{$table_cell_color}; padding: 0.6em 0.4em;">{!$order->getShippingFeeInclVat()|display_price:"$currency"|default:$mdash}</td>
	</tr>
	<tr style="text-align: right; font-weight: bold;">
		<td style="background-color: {$table_accent_bgcolor}; color:{$table_accent_color}; padding: 0.6em 0.4em;" colspan="4">{t}Celkem k úhradě{/t}</td>
		<td style="background-color: {$table_accent_bgcolor}; color:{$table_accent_color}; padding: 0.6em 0.4em;">{!$order->getPriceToPay()|display_price:"$currency,summary=auto"}{if is_null($order->getShippingFeeInclVat())}<sup>*</sup>{/if}</td>
	</tr>
</tbody>
</table>

{if is_null($order->getShippingFeeInclVat())}
	<small><sup>*</sup> {t}Uvedená konečná cena neobsahuje poplatek za dopravu.{/t}</small><br/><br/>
{/if}

{render partial="partials/title_box" content="{t}Přeprava{/t}"}

{t}Dopravce:{/t} <strong>{$order->getDeliveryMethod()}</strong>

<br/><br/>

<table style="width: 100%; font-family: {$font_stack}; font-size: 11px; color: #374953;">
	<tbody>
		<tr style="background-color:{$table_header_bgcolor}; color:{$table_header_color}; text-transform: uppercase;"><th style="width: 50%; text-align: left; padding: 0.3em 1em; background-color:{$table_header_bgcolor}; color:{$table_header_color};">{t}Dodací adresa{/t}</th><th style="width: 50%; text-align: left; padding: 0.3em 1em; background-color:{$table_header_bgcolor}; color:{$table_header_color};">{t}Fakturační adresa{/t}</th></tr>
		<tr>
		<td style="padding: 0.5em 0 0.5em 0.5em; background-color:{$table_cell_bgcolor}; color:{$table_cell_color};" valign="top">
			{render partial="shared/order/delivery_address"}
		</td>
		<td style="padding: 0.5em 0 0.5em 0.5em; background-color:{$table_cell_bgcolor}; color:{$table_cell_color};" valign="top">
			{render partial="shared/order/invoice_address"}
		</td>
		</tr>
	</tbody>
</table>

{if $order->getNote()}
	<br/>
	{t}Vaše poznámka k objednávce:{/t} {!$order->getNote()|h|nl2br}
{/if}

{if $order->getPaymentMethod()->isOnlineMethod()}
	{capture assign=order_finish_url}{link_to namespace="" action="orders/finish" token=$order->getToken() _with_hostname=true _ssl=REDIRECT_TO_SSL_AUTOMATICALLY}{/capture}
	<br/><br/>
	{t}Pokud Vám spadl prohlížeč před dokončením platby, pokračujte na tomto URL:{/t}
	<a href="{$order_finish_url}" style="{$link_style}"><span style="{$link_style}">{$order_finish_url}</span></a>
{/if}

{render partial="order_status_check_notice.html"}



<hr>

{assign "order_table_x_padding" "0px; background: yellow" }
{assign "order_table_x_padding" "0px" }
{assign "order_table_inner_padding" "10px" }
<!-- order -->
    {*<table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:white;background-color:white;width:100%;">
      <tbody>
        <tr>
          <td>
            <!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" bgcolor="white" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
            <div style="margin:0px auto;max-width:600px;">
              <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
                <tbody>
                  <tr>
                    <td style="direction:ltr;font-size:0px;padding:20px 0;text-align:center;">*}

                      <!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" width="600px" ><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
                      <div style="margin:0px auto;max-width:600px;">
                        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
                          <tbody>
                            <tr>
                              <td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0;padding-top:0;text-align:center;">
                                <!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]-->
                                <div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                  <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                    <tbody>
                                      <tr>
                                        <td style="vertical-align:top;padding:0;">
                                          <table border="0" cellpadding="0" cellspacing="0" role="presentation" style width="100%">
                                            <tbody>
                                              <tr>
                                                <td align="left" class="order-content">
                                                  <div style="font-family:{$font_stack};font-size:16px;line-height:1.25;text-align:left;color:{$text_color};">
                                                    <p class="nomargin" style="margin: 0 0 16px 0; margin-bottom: 0;"><strong>{t}Detaily objednávky{/t}</strong></p>
                                                  </div>
                                                </td>
                                              </tr>
                                              <tr>
                                                <td align="center" style="font-size:0px;padding:0 {$order_table_x_padding};word-break:break-word;">
                                                  <p style="border-top: solid 1px #999999; font-size: 1px; margin: 0px auto; width: 100%;">
                                                  </p>
                                                  <!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" style="border-top:solid 1px #999999;font-size:1px;margin:0px auto;width:550px;" role="presentation" width="550px" ><tr><td style="height:0;line-height:0;"> &nbsp;
</td></tr></table><![endif]-->
                                                </td>
                                              </tr>
                                            </tbody>
                                          </table>
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                                <!--[if mso | IE]></td></tr></table><![endif]-->
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <!--[if mso | IE]></td></tr></table></td></tr><tr><td class="" width="600px" ><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
                      <div style="margin:0px auto;max-width:600px;">
                        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
                          <tbody>
                            <tr>
                              <td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0;padding-top:0;text-align:center;">
                                <!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]-->
                                <div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                  <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                    <tbody>
                                      <tr>
                                        <td style="vertical-align:top;padding-top:0;padding-bottom:0;">
                                          <table border="0" cellpadding="0" cellspacing="0" role="presentation" style width="100%">
                                            <tbody>
                                              <tr>
                                                <td align="left" class="order-content">
                                                  <div style="font-family:{$font_stack};font-size:14px;line-height:1.5;text-align:left;color:{$text_color};">{t}Číslo objednávky:{/t} <strong>{!$order->getOrderNo()}</strong><br> {t}Vytvořena:{/t} {$order->getCreatedAt()|format_datetime}<br> {t}Platba:{/t} {$order->getPaymentMethod()}</div>
                                                </td>
                                              </tr>
                                              <tr>
                                                <td align="center" class="order-divider">
                                                  <p style="border-top: solid 1px #999999; font-size: 1px; margin: 0px auto; width: 100%;">
                                                  </p>
                                                  <!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" style="border-top:solid 1px #999999;font-size:1px;margin:0px auto;width:550px;" role="presentation" width="550px" ><tr><td style="height:0;line-height:0;"> &nbsp;
</td></tr></table><![endif]-->
                                                </td>
                                              </tr>
                                            </tbody>
                                          </table>
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                                <!--[if mso | IE]></td></tr></table><![endif]-->
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <!--[if mso | IE]></td></tr></table></td></tr><![endif]--> {foreach $order->getItems() as $item}{assign product $item->getProduct()} {if $product->getCode()=="price_rounding"} <!--[if mso | IE]><tr><td class="" width="600px" ><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
                      <div style="margin:0px auto;max-width:600px;">
                        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
                          <tbody>
                            <tr>
                              <td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0;padding-top:0;text-align:center;">
                                <!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:90px;" ><![endif]-->
                                <div class="mj-column-per-15 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                  <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                    <tbody>
                                      <tr>
                                        <td style="vertical-align:top;padding-top:0;padding-right:0;">
                                          <table border="0" cellpadding="0" cellspacing="0" role="presentation" style width="100%">
                                            <tbody>
                                            </tbody>
                                          </table>
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                                <!--[if mso | IE]></td><td class="" style="vertical-align:top;width:360px;" ><![endif]-->
                                <div class="mj-column-per-60 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                  <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                    <tbody>
                                      <tr>
                                        <td style="vertical-align:top;padding-top:0;padding-bottom:0;">
                                          <table border="0" cellpadding="0" cellspacing="0" role="presentation" style width="100%">
                                            <tbody>
                                              <tr>
                                                <td align="left" class="order-content order-content-first">
                                                  <div style="font-family:{$font_stack};font-size:16px;line-height:1.25;text-align:left;color:{$text_color};">
                                                    <p class="compact" style="margin: 0 0 16px 0; margin-bottom: 4px;">
                                                      <span class="bodycolor" style="color: {$text_color}; text-decoration: none;"><strong>{!$product->getName()}</strong><br></span>
                                                    </p>
                                                  </div>
                                                </td>
                                              </tr>
                                            </tbody>
                                          </table>
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                                <!--[if mso | IE]></td><td class="" style="vertical-align:top;width:150px;" ><![endif]-->
                                <div class="mj-column-per-25 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                  <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                    <tbody>
                                      <tr>
                                        <td style="vertical-align:top;padding-top:0;padding-bottom:0;padding-left:0;">
                                          <table border="0" cellpadding="0" cellspacing="0" role="presentation" style width="100%">
                                            <tbody>
                                              <tr>
                                                <td align="left" class="order-content order-content-middle">
                                                  <div style="font-family:{$font_stack};font-size:16px;line-height:1.25;text-align:left;color:{$text_color};">
                                                    <p class="item-price small compact nomargin" style="margin: 0 0 16px 0; font-size: 14px; margin-bottom: 0; text-align: right;">
                                                      <span class="currency-main" style="font-size: 16px; font-weight: bold;">{!$item->getPriceInclVat()|display_price:"$currency"}</span>
                                                    </p>
                                                  </div>
                                                </td>
                                              </tr>
                                            </tbody>
                                          </table>
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                                <!--[if mso | IE]></td><td class="" style="vertical-align:top;width:600px;" ><![endif]-->
                                <div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                  <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                    <tbody>
                                      <tr>
                                        <td style="vertical-align:top;padding:0;">
                                          <table border="0" cellpadding="0" cellspacing="0" role="presentation" style width="100%">
                                            <tbody>
                                              <tr>
                                                <td align="center" class="order-content order-content-last">
                                                  <p style="border-top: solid 1px #999999; font-size: 1px; margin: 0px auto; width: 100%;">
                                                  </p>
                                                  <!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" style="border-top:solid 1px #999999;font-size:1px;margin:0px auto;width:550px;" role="presentation" width="550px" ><tr><td style="height:0;line-height:0;"> &nbsp;
</td></tr></table><![endif]-->
                                                </td>
                                              </tr>
                                            </tbody>
                                          </table>
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                                <!--[if mso | IE]></td></tr></table><![endif]-->
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <!--[if mso | IE]></td></tr></table></td></tr><![endif]--> {else} {assign var="product_link" value = $product|link_to_product:"with_hostname=$default_domain"} {assign var="product_image" value = $product->getImage()|img_url:"60x60xffffff"} <!--[if mso | IE]><tr><td class="" width="600px" ><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
                      <div style="margin:0px auto;max-width:600px;">
                        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
                          <tbody>
                            <tr>
                              <td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0;padding-top:0;text-align:center;">
                                <!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:90px;" ><![endif]-->
                                <div class="mj-column-per-15 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                  <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                    <tbody>
                                      <tr>
                                        <td style="vertical-align:top;padding-top:0;padding-right:0;">
                                          <table border="0" cellpadding="0" cellspacing="0" role="presentation" style width="100%">
                                            <tbody>
                                              <!-- htmlonly -->{* tato znacka se pouziva pri konverzi HTML textu do plain text *} <tr>
                                                <td align="left" class="order-content order-content-first" style="padding-right: 0;">
                                                  <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;">
                                                    <tbody>
                                                      <tr>
                                                        <td style="width:60px;">
                                                          <a href="{!$product_link}" target="_blank" style="color: {$link_color};">
                                                            <img alt src="{!$product_image}" style="border:0;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:16px;" width="60" height="auto">
                                                          </a>
                                                        </td>
                                                      </tr>
                                                    </tbody>
                                                  </table>
                                                </td>
                                              </tr>
                                              <!-- /htmlonly -->
                                            </tbody>
                                          </table>
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                                <!--[if mso | IE]></td><td class="" style="vertical-align:top;width:360px;" ><![endif]-->
                                <div class="mj-column-per-60 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                  <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                    <tbody>
                                      <tr>
                                        <td style="vertical-align:top;padding-top:0;padding-bottom:0;">
                                          <table border="0" cellpadding="0" cellspacing="0" role="presentation" style width="100%">
                                            <tbody>
                                              <tr>
                                                <td align="left" class="order-content order-content-middle">
                                                  <div style="font-family:{$font_stack};font-size:16px;line-height:1.25;text-align:left;color:{$text_color};">
                                                    <p class="compact" style="margin: 0 0 16px 0; margin-bottom: 4px;">
                                                      <a href="{!$product_link}" class="bodycolor" style="color: {$text_color}; text-decoration: none;"><strong>{!$product->getName()}</strong><br></a>
                                                    </p>
                                                    <p class="small compact" style="margin: 0 0 16px 0; margin-bottom: 4px; font-size: 14px;"> {t}Kód{/t}: {$product->getCatalogId()}<br> {t}Jedn. cena{/t}: {!$item->getUnitPriceInclVat()|display_price:"$currency"}<br> {t}Množství{/t}: {$item->getAmount()} </p>
                                                  </div>
                                                </td>
                                              </tr>
                                            </tbody>
                                          </table>
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                                <!--[if mso | IE]></td><td class="" style="vertical-align:top;width:150px;" ><![endif]-->
                                <div class="mj-column-per-25 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                  <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                    <tbody>
                                      <tr>
                                        <td style="vertical-align:top;padding-top:0;padding-bottom:0;padding-left:0;">
                                          <table border="0" cellpadding="0" cellspacing="0" role="presentation" style width="100%">
                                            <tbody>
                                              <tr>
                                                <td align="left" class="order-content order-content-last">
                                                  <div style="font-family:{$font_stack};font-size:16px;line-height:1.25;text-align:left;color:{$text_color};">
                                                    <p class="item-price small compact nomargin" style="margin: 0 0 16px 0; font-size: 14px; margin-bottom: 0; text-align: right;">
                                                      <span class="currency-main" style="font-size: 16px; font-weight: bold;">{!$item->getPriceInclVat()|display_price:"$currency"}</span>
                                                    </p>
                                                  </div>
                                                </td>
                                              </tr>
                                            </tbody>
                                          </table>
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                                <!--[if mso | IE]></td><td class="" style="vertical-align:top;width:600px;" ><![endif]-->
                                <div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                  <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                    <tbody>
                                      <tr>
                                        <td style="vertical-align:top;padding:0;">
                                          <table border="0" cellpadding="0" cellspacing="0" role="presentation" style width="100%">
                                            <tbody>
                                              <tr>
                                                <td align="center" class="order-divider">
                                                  <p style="border-top: solid 1px #999999; font-size: 1px; margin: 0px auto; width: 100%;">
                                                  </p>
                                                  <!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" style="border-top:solid 1px #999999;font-size:1px;margin:0px auto;width:550px;" role="presentation" width="550px" ><tr><td style="height:0;line-height:0;"> &nbsp;
</td></tr></table><![endif]-->
                                                </td>
                                              </tr>
                                            </tbody>
                                          </table>
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                                <!--[if mso | IE]></td></tr></table><![endif]-->
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <!--[if mso | IE]></td></tr></table></td></tr><![endif]--> {/if}{/foreach} <!--[if mso | IE]><tr><td class="" width="600px" ><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
                      <div style="margin:0px auto;max-width:600px;">
                        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
                          <tbody>
                            <tr>
                              <td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0;padding-top:0;text-align:center;">
                                <!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="width:600px;" ><![endif]-->
                                <div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0;line-height:0;text-align:left;display:inline-block;width:100%;direction:ltr;">
                                  <!--[if mso | IE]><table border="0" cellpadding="0" cellspacing="0" role="presentation" ><tr><td style="vertical-align:top;width:300px;" ><![endif]-->
                                  <div class="mj-column-per-50 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:50%;">
                                    <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                      <tbody>
                                        <tr>
                                          <td style="vertical-align:top;padding:0;">
                                            <table border="0" cellpadding="0" cellspacing="0" role="presentation" style width="100%">
                                              <tbody>
                                                <tr>
                                                  <td align="left" class="order-content order-content-first">
                                                    <div style="font-family:{$font_stack};font-size:16px;line-height:1.25;text-align:left;color:{$text_color};">{t}Cena celkem{/t}</div>
                                                  </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </div>
                                  <!--[if mso | IE]></td><td style="vertical-align:top;width:300px;" ><![endif]-->
                                  <div class="mj-column-per-50 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:50%;">
                                    <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                      <tbody>
                                        <tr>
                                          <td style="vertical-align:top;padding:0;">
                                            <table border="0" cellpadding="0" cellspacing="0" role="presentation" style width="100%">
                                              <tbody>
                                                <tr>
                                                  <td align="right" class="order-content order-content-last">
                                                    <div style="font-family:{$font_stack};font-size:16px;line-height:1.25;text-align:right;color:{$text_color};">{!$order->getItemsPriceInclVat()|display_price:"$currency"}</div>
                                                  </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </div>
                                  <!--[if mso | IE]></td></tr></table><![endif]-->
                                </div>
                                <!--[if mso | IE]></td></tr></table><![endif]-->
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <!--[if mso | IE]></td></tr></table></td></tr><![endif]--> {foreach $order->getVouchers() as $voucher} <!--[if mso | IE]><tr><td class="" width="600px" ><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
                      <div style="margin:0px auto;max-width:600px;">
                        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
                          <tbody>
                            <tr>
                              <td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0;padding-top:0;text-align:center;">
                                <!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="width:600px;" ><![endif]-->
                                <div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0;line-height:0;text-align:left;display:inline-block;width:100%;direction:ltr;">
                                  <!--[if mso | IE]><table border="0" cellpadding="0" cellspacing="0" role="presentation" ><tr><td style="vertical-align:top;width:300px;" ><![endif]-->
                                  <div class="mj-column-per-50 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:50%;">
                                    <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                      <tbody>
                                        <tr>
                                          <td style="vertical-align:top;padding:0;">
                                            <table border="0" cellpadding="0" cellspacing="0" role="presentation" style width="100%">
                                              <tbody>
                                                <tr>
                                                  <td align="left" class="order-content order-content-first">
                                                    <div style="font-family:{$font_stack};font-size:16px;line-height:1.25;text-align:left;color:{$text_color};">{$voucher->getDescription()}</div>
                                                  </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </div>
                                  <!--[if mso | IE]></td><td style="vertical-align:top;width:300px;" ><![endif]-->
                                  <div class="mj-column-per-50 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:50%;">
                                    <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                      <tbody>
                                        <tr>
                                          <td style="vertical-align:top;padding:0;">
                                            <table border="0" cellpadding="0" cellspacing="0" role="presentation" style width="100%">
                                              <tbody>
                                                <tr>
                                                  <td align="right" class="order-content order-content-last">
                                                    <div style="font-family:{$font_stack};font-size:16px;line-height:1.25;text-align:right;color:{$text_color};">{$voucher}</div>
                                                  </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </div>
                                  <!--[if mso | IE]></td></tr></table><![endif]-->
                                </div>
                                <!--[if mso | IE]></td></tr></table><![endif]-->
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <!--[if mso | IE]></td></tr></table></td></tr><![endif]--> {/foreach}{foreach $order->getCampaigns() as $campaign} {if $campaign->getDiscountAmount()} <!--[if mso | IE]><tr><td class="" width="600px" ><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
                      <div style="margin:0px auto;max-width:600px;">
                        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
                          <tbody>
                            <tr>
                              <td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0;padding-top:0;text-align:center;">
                                <!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="width:600px;" ><![endif]-->
                                <div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0;line-height:0;text-align:left;display:inline-block;width:100%;direction:ltr;">
                                  <!--[if mso | IE]><table border="0" cellpadding="0" cellspacing="0" role="presentation" ><tr><td style="vertical-align:top;width:300px;" ><![endif]-->
                                  <div class="mj-column-per-50 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:50%;">
                                    <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                      <tbody>
                                        <tr>
                                          <td style="vertical-align:top;padding:0;">
                                            <table border="0" cellpadding="0" cellspacing="0" role="presentation" style width="100%">
                                              <tbody>
                                                <tr>
                                                  <td align="left" class="order-content order-content-first">
                                                    <div style="font-family:{$font_stack};font-size:16px;line-height:1.25;text-align:left;color:{$text_color};">{$campaign}</div>
                                                  </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </div>
                                  <!--[if mso | IE]></td><td style="vertical-align:top;width:300px;" ><![endif]-->
                                  <div class="mj-column-per-50 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:50%;">
                                    <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                      <tbody>
                                        <tr>
                                          <td style="vertical-align:top;padding:0;">
                                            <table border="0" cellpadding="0" cellspacing="0" role="presentation" style width="100%">
                                              <tbody>
                                                <tr>
                                                  <td align="right" class="order-content order-content-last">
                                                    <div style="font-family:{$font_stack};font-size:16px;line-height:1.25;text-align:right;color:{$text_color};">-{!$campaign->getDiscountAmount()|display_price:"$currency"}</div>
                                                  </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </div>
                                  <!--[if mso | IE]></td></tr></table><![endif]-->
                                </div>
                                <!--[if mso | IE]></td></tr></table><![endif]-->
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <!--[if mso | IE]></td></tr></table></td></tr><![endif]--> {/if} {/foreach} <!--[if mso | IE]><tr><td class="" width="600px" ><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
                      <div style="margin:0px auto;max-width:600px;">
                        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
                          <tbody>
                            <tr>
                              <td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0;padding-top:0;text-align:center;">
                                <!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="width:600px;" ><![endif]-->
                                <div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0;line-height:0;text-align:left;display:inline-block;width:100%;direction:ltr;">
                                  <!--[if mso | IE]><table border="0" cellpadding="0" cellspacing="0" role="presentation" ><tr><td style="vertical-align:top;width:300px;" ><![endif]-->
                                  <div class="mj-column-per-50 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:50%;">
                                    <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                      <tbody>
                                        <tr>
                                          <td style="vertical-align:top;padding:0;">
                                            <table border="0" cellpadding="0" cellspacing="0" role="presentation" style width="100%">
                                              <tbody>
                                                <tr>
                                                  <td align="left" class="order-content order-content-first">
                                                    <div style="font-family:{$font_stack};font-size:16px;line-height:1.25;text-align:left;color:{$text_color};">{t}Doprava{/t}</div>
                                                  </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </div>
                                  <!--[if mso | IE]></td><td style="vertical-align:top;width:300px;" ><![endif]-->
                                  <div class="mj-column-per-50 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:50%;">
                                    <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                      <tbody>
                                        <tr>
                                          <td style="vertical-align:top;padding:0;">
                                            <table border="0" cellpadding="0" cellspacing="0" role="presentation" style width="100%">
                                              <tbody>
                                                <tr>
                                                  <td align="right" class="order-content order-content-last">
                                                    <div style="font-family:{$font_stack};font-size:16px;line-height:1.25;text-align:right;color:{$text_color};">{!$order->getShippingFeeInclVat()|display_price:"$currency"|default:$mdash}</div>
                                                  </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </div>
                                  <!--[if mso | IE]></td></tr></table><![endif]-->
                                </div>
                                <!--[if mso | IE]></td></tr></table><![endif]-->
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <!--[if mso | IE]></td></tr></table></td></tr><tr><td class="" width="600px" ><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
                      <div style="margin:0px auto;max-width:600px;">
                        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
                          <tbody>
                            <tr>
                              <td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0;padding-top:0;text-align:center;">
                                <!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]-->
                                <div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                  <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
                                    <tbody>
                                      <tr>
                                        <td align="center" class="order-divider">
                                          <p style="border-top: solid 1px #999999; font-size: 1px; margin: 0px auto; width: 100%;">
                                          </p>
                                          <!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" style="border-top:solid 1px #999999;font-size:1px;margin:0px auto;width:550px;" role="presentation" width="550px" ><tr><td style="height:0;line-height:0;"> &nbsp;
</td></tr></table><![endif]-->
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                                <!--[if mso | IE]></td></tr></table><![endif]-->
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <!--[if mso | IE]></td></tr></table></td></tr><tr><td class="" width="600px" ><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
                      <div style="margin:0px auto;max-width:600px;">
                        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
                          <tbody>
                            <tr>
                              <td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0;padding-top:0;text-align:center;">
                                <!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="width:600px;" ><![endif]-->
                                <div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0;line-height:0;text-align:left;display:inline-block;width:100%;direction:ltr;">
                                  <!--[if mso | IE]><table border="0" cellpadding="0" cellspacing="0" role="presentation" ><tr><td style="vertical-align:top;width:300px;" ><![endif]-->
                                  <div class="mj-column-per-50 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:50%;">
                                    <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                      <tbody>
                                        <tr>
                                          <td style="vertical-align:top;padding:0;">
                                            <table border="0" cellpadding="0" cellspacing="0" role="presentation" style width="100%">
                                              <tbody>
                                                <tr>
                                                  <td align="left" class="order-content order-content-first">
                                                    <div style="font-family:{$font_stack};font-size:16px;line-height:1.25;text-align:left;color:{$text_color};">{t}Celkem k úhradě{/t}</div>
                                                  </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </div>
                                  <!--[if mso | IE]></td><td style="vertical-align:top;width:300px;" ><![endif]-->
                                  <div class="mj-column-per-50 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:50%;">
                                    <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                      <tbody>
                                        <tr>
                                          <td style="vertical-align:top;padding:0;">
                                            <table border="0" cellpadding="0" cellspacing="0" role="presentation" style width="100%">
                                              <tbody>
                                                <tr>
                                                  <td align="right" class="order-content order-content-last">
                                                    <div style="font-family:{$font_stack};font-size:16px;line-height:1.25;text-align:right;color:{$text_color};"><strong>{!$order->getPriceToPay()|display_price:"$currency,summary"}{if is_null($order->getShippingFeeInclVat())}<sup>*</sup>{/if}</strong></div>
                                                  </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </div>
                                  <!--[if mso | IE]></td></tr></table><![endif]-->
                                </div>
                                <!--[if mso | IE]></td></tr></table><![endif]-->
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <!--[if mso | IE]></td></tr></table></td></tr><![endif]--> {if is_null($order->getShippingFeeInclVat())} <!--[if mso | IE]><tr><td class="" width="600px" ><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
                      <div style="margin:0px auto;max-width:600px;">
                        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
                          <tbody>
                            <tr>
                              <td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0;padding-top:0;text-align:center;">
                                <!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]-->
                                <div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                  <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                    <tbody>
                                      <tr>
                                        <td style="vertical-align:top;padding:0;">
                                          <table border="0" cellpadding="0" cellspacing="0" role="presentation" style width="100%">
                                            <tbody>
                                              <tr>
                                                <td align="left" class="order-content">
                                                  <div style="font-family:{$font_stack};font-size:16px;line-height:1.25;text-align:left;color:{$text_color};"><small><sup>*</sup> {t}Uvedená konečná cena neobsahuje poplatek za dopravu.{/t}</small></div>
                                                </td>
                                              </tr>
                                            </tbody>
                                          </table>
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                                <!--[if mso | IE]></td></tr></table><![endif]-->
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <!--[if mso | IE]></td></tr></table></td></tr><![endif]--> {/if} <!--[if mso | IE]><tr><td class="" width="600px" ><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
                      <div style="margin:0px auto;max-width:600px;">
                        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
                          <tbody>
                            <tr>
                              <td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0;padding-top:20px;text-align:center;">
                                <!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]-->
                                <div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                  <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                    <tbody>
                                      <tr>
                                        <td style="vertical-align:top;padding:0;">
                                          <table border="0" cellpadding="0" cellspacing="0" role="presentation" style width="100%">
                                            <tbody>
                                              <tr>
                                                <td align="left" class="order-content">
                                                  <div style="font-family:{$font_stack};font-size:16px;line-height:1.25;text-align:left;color:{$text_color};">
                                                    <p class="nomargin" style="margin: 0 0 16px 0; margin-bottom: 0;"><strong>{t}Přeprava{/t}</strong></p>
                                                  </div>
                                                </td>
                                              </tr>
                                              <tr>
                                                <td align="center" class="order-divider">
                                                  <p style="border-top: solid 1px #999999; font-size: 1px; margin: 0px auto; width: 100%;">
                                                  </p>
                                                  <!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" style="border-top:solid 1px #999999;font-size:1px;margin:0px auto;width:550px;" role="presentation" width="550px" ><tr><td style="height:0;line-height:0;"> &nbsp;
</td></tr></table><![endif]-->
                                                </td>
                                              </tr>
                                            </tbody>
                                          </table>
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                                <!--[if mso | IE]></td></tr></table><![endif]-->
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <!--[if mso | IE]></td></tr></table></td></tr><tr><td class="" width="600px" ><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
                      <div style="margin:0px auto;max-width:600px;">
                        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
                          <tbody>
                            <tr>
                              <td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0;padding-top:0;text-align:center;">
                                <!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]-->
                                <div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                  <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                    <tbody>
                                      <tr>
                                        <td style="vertical-align:top;padding-top:0;padding-bottom:0;">
                                          <table border="0" cellpadding="0" cellspacing="0" role="presentation" style width="100%">
                                            <tbody>
                                              <tr>
                                                <td align="left" class="order-content">
                                                  <div style="font-family:{$font_stack};font-size:14px;line-height:1.5;text-align:left;color:{$text_color};">{t}Dopravce:{/t} <strong>{$order->getDeliveryMethod()}</strong><br> {*Tracking: <a href="#" style="color: {$link_color};">356166</a><br>*}</div>
                                                </td>
                                              </tr>
                                              <tr>
                                                <td align="center" class="order-divider">
                                                  <p style="border-top: solid 1px #999999; font-size: 1px; margin: 0px auto; width: 100%;">
                                                  </p>
                                                  <!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" style="border-top:solid 1px #999999;font-size:1px;margin:0px auto;width:550px;" role="presentation" width="550px" ><tr><td style="height:0;line-height:0;"> &nbsp;
</td></tr></table><![endif]-->
                                                </td>
                                              </tr>
                                            </tbody>
                                          </table>
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                                <!--[if mso | IE]></td><td class="" style="vertical-align:top;width:300px;" ><![endif]-->
                                <div class="mj-column-per-50 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                  <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                    <tbody>
                                      <tr>
                                        <td style="vertical-align:top;padding-top:0;padding-bottom:0;">
                                          <table border="0" cellpadding="0" cellspacing="0" role="presentation" style width="100%">
                                            <tbody>
                                              <tr>
                                                <td align="left" class="order-content order-content-first">
                                                  <div style="font-family:{$font_stack};font-size:14px;line-height:1.5;text-align:left;color:{$text_color};"><strong>{t}Dodací adresa{/t}</strong><br> {render partial="shared/order/delivery_address"}</div>
                                                </td>
                                              </tr>
                                            </tbody>
                                          </table>
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                                <!--[if mso | IE]></td><td class="" style="vertical-align:top;width:300px;" ><![endif]-->
                                <div class="mj-column-per-50 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                  <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
                                    <tbody>
                                      <tr>
                                        <td align="left"  class="order-content order-content-last">
                                          <div style="font-family:{$font_stack};font-size:14px;line-height:1.5;text-align:left;color:{$text_color};"><strong>{t}Fakturační adresa{/t}</strong><br> {render partial="shared/order/invoice_address"}</div>
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                                <!--[if mso | IE]></td><td class="" style="vertical-align:top;width:600px;" ><![endif]-->
                                <div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                  <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
                                    <tbody>
                                      <tr>
                                        <td align="center" class="order-divider">
                                          <p style="border-top: solid 1px #999999; font-size: 1px; margin: 0px auto; width: 100%;">
                                          </p>
                                          <!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" style="border-top:solid 1px #999999;font-size:1px;margin:0px auto;width:550px;" role="presentation" width="550px" ><tr><td style="height:0;line-height:0;"> &nbsp;
</td></tr></table><![endif]-->
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                                <!--[if mso | IE]></td></tr></table><![endif]-->
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <!--[if mso | IE]></td></tr></table></td></tr><![endif]--> {if $order->getNote()} <!--[if mso | IE]><tr><td class="" width="600px" ><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
                      <div style="margin:0px auto;max-width:600px;">
                        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
                          <tbody>
                            <tr>
                              <td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0;padding-top:0;text-align:center;">
                                <!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]-->
                                <div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                  <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                    <tbody>
                                      <tr>
                                        <td style="vertical-align:top;padding:0;">
                                          <table border="0" cellpadding="0" cellspacing="0" role="presentation" style width="100%">
                                            <tbody>
                                              <tr>
                                                <td align="left" class="order-content">
                                                  <div style="font-family:{$font_stack};font-size:14px;line-height:1.5;text-align:left;color:{$text_color};"><strong>{t}Vaše poznámka k objednávce:{/t}</strong><br> {!$order->getNote()|h|nl2br}</div>
                                                </td>
                                              </tr>
                                              <tr>
                                                <td align="center" class="order-divider">
                                                  <p style="border-top: solid 1px #999999; font-size: 1px; margin: 0px auto; width: 100%;">
                                                  </p>
                                                  <!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" style="border-top:solid 1px #999999;font-size:1px;margin:0px auto;width:550px;" role="presentation" width="550px" ><tr><td style="height:0;line-height:0;"> &nbsp;
</td></tr></table><![endif]-->
                                                </td>
                                              </tr>
                                            </tbody>
                                          </table>
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                                <!--[if mso | IE]></td></tr></table><![endif]-->
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <!--[if mso | IE]></td></tr></table></td></tr><![endif]--> {/if} <!--[if mso | IE]><tr><td class="" width="600px" ><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
                      <div style="margin:0px auto;max-width:600px;">
                        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
                          <tbody>
                            <tr>
                              <td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0;padding-top:0;text-align:center;">
                                <!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]-->
                                <div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                  <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                    <tbody>
                                      <tr>
                                        <td style="vertical-align:top;padding:0;">
                                          <table border="0" cellpadding="0" cellspacing="0" role="presentation" style width="100%">
                                            <tbody>
                                              <tr>
                                                <td align="left" class="order-content">
                                                  <div style="font-family:{$font_stack};font-size:14px;line-height:1.5;text-align:left;color:{$text_color};">
																										{if $order->getPaymentMethod()->isOnlineMethod()}
																											{capture assign=order_finish_url}{link_to namespace="" action="orders/finish" token=$order->getToken() _with_hostname=true _ssl=REDIRECT_TO_SSL_AUTOMATICALLY}{/capture}
																											<br/><br/>
																											{t}Pokud Vám spadl prohlížeč před dokončením platby, pokračujte na tomto URL:{/t}
																											<a href="{$order_finish_url}" style="{$link_style}"><span style="{$link_style}">{$order_finish_url}</span></a>
																										{/if}
																										{render partial="order_status_check_notice.html"}</div>
                                                </td>
                                              </tr>
                                              <tr>
                                                <td align="center" class="order-divider">
                                                  <p style="border-top: solid 1px #999999; font-size: 1px; margin: 0px auto; width: 100%;">
                                                  </p>
                                                  <!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" style="border-top:solid 1px #999999;font-size:1px;margin:0px auto;width:550px;" role="presentation" width="550px" ><tr><td style="height:0;line-height:0;"> &nbsp;
</td></tr></table><![endif]-->
                                                </td>
                                              </tr>
                                            </tbody>
                                          </table>
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                                <!--[if mso | IE]></td></tr></table><![endif]-->
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <!--[if mso | IE]></td></tr></table></td></tr><tr><td class="" width="600px" ><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
                      <div style="margin:0px auto;max-width:600px;">
                        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
                          <tbody>
                            <tr>
                              <td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0;padding-top:0;text-align:center;">
                                <!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]-->
                                <div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                  <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
                                    <tbody>
                                      <tr>
                                        <td style="font-size:0px;word-break:break-word;">
                                          <div style="height:40px;line-height:40px;">&#8202;</div>
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                                <!--[if mso | IE]></td></tr></table><![endif]-->
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <!--[if mso | IE]></td></tr></table></td></tr></table><![endif]-->
                   {*
										</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!--[if mso | IE]></td></tr></table><![endif]-->
          </td>
        </tr>
      </tbody>
    </table>*}

