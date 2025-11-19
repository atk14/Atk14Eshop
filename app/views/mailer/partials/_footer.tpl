{assign eshop Store::FindByCode("eshop")}
{if 'app.contact.social.facebook'|system_parameter}{assign show_fb true}{/if}
{if 'app.contact.social.instagram'|system_parameter}{assign show_ig true}{/if}
{if 'app.contact.social.linkedin'|system_parameter}{assign show_li true}{/if}
{if 'app.contact.social.pinterest'|system_parameter}{assign show_pi true}{/if}
{if 'app.contact.social.snapchat'|system_parameter}{assign show_sn true}{/if}
{if 'app.contact.social.twitter'|system_parameter}{assign show_tw true}{/if}
{if 'app.contact.social.vimeo'|system_parameter}{assign show_vm true}{/if}
{if 'app.contact.social.youtube'|system_parameter}{assign show_yt true}{/if}
{if 'app.contact.social.soundcloud'|system_parameter}{assign show_sc true}{/if}
{assign phone_number "app.contact.phone"|system_parameter|replace:' ':''|replace:".":""}
		<!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
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
    <!--[if mso | IE]></td></tr></table><![endif]-->
    <table align="center" class="footer" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:{$footer_bgcolor};background-color:{$footer_bgcolor};width:100%;">
      <tbody>
        <tr>
          <td>
            <!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" class="footer-outlook" role="presentation" style="width:600px;" width="600" bgcolor="{$footer_bgcolor}" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
            <div style="margin:0px auto;max-width:600px;">
              <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
                <tbody>
                  <tr>
                    <td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0;padding-top:16px;text-align:center;">
                      <!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:300px;" ><![endif]-->
                      <div class="mj-column-per-50 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                        <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
                          <tbody>
                            <tr>
                              <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                                <div style="font-family:{$font_stack};font-size:14px;line-height:1.25;text-align:left;color:{$footer_color};">
                                  <p style="margin: 0 0 16px 0;">
                                    <a href="{!$region->getDefaultUrl()}" style="color: {$link_color};">{"app.name.official"|system_parameter}</a><br>
                                    {if $eshop}
                                    {$eshop->getAddressStreet()}<br/>
                                    {if $eshop->getAddressStreet2()}
                                    {$eshop->getAddressStreet2()}<br/>
                                    {/if}
                                    {$eshop->getAddressZip()} {$eshop->getAddressCity()}<br/>
                                    {/if}
                                  </p>
                                  <p style="margin: 0 0 16px 0;">
                                    {t}E-mail{/t}: <a href="mailto:{"app.contact.email"|system_parameter}" style="color: {$link_color};">{"app.contact.email"|system_parameter}</a><br>
                                    {t}Tel.{/t}: <a href="tel:{"app.contact.phone"|system_parameter|replace:".":""}" style="color: {$link_color};">{"app.contact.phone"|system_parameter|display_phone}</a>
                                  </p>
                                </div>												
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
                              <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                                <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="margin:0px;">
                                  <tbody> {if $show_fb} <tr>
                                      <td style="padding:4px;vertical-align:middle;">
                                        <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#3b5998;border-radius:3px;width:30px;">
                                          <tbody>
                                            <tr>
                                              <td style="font-size:0;height:30px;vertical-align:middle;width:30px;">
                                                <a href="{'app.contact.social.facebook'|system_parameter}" target="_blank" style="color: {$link_color};">
                                                  <img alt src="https://www.mailjet.com/images/theme/v1/icons/ico-social/facebook.png" style="border-radius:3px;display:block;" width="30">
                                                </a>
                                              </td>
                                            </tr>
                                          </tbody>
                                        </table>
                                      </td>
                                      <td style="vertical-align:middle;padding:4px 4px 4px 0;text-align:left;">
                                        <a href="{'app.contact.social.facebook'|system_parameter}" style="color: {$text_color}; font-size: 15px; font-family: {$font_stack}; line-height: 1.25; text-decoration: none;" target="_blank"> Facebook </a>
                                      </td>
                                    </tr> {/if}{if $show_ig} <tr>
                                      <td style="padding:4px;vertical-align:middle;">
                                        <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#3f729b;border-radius:3px;width:30px;">
                                          <tbody>
                                            <tr>
                                              <td style="font-size:0;height:30px;vertical-align:middle;width:30px;">
                                                <a href="{'app.contact.social.instagram'|system_parameter}" target="_blank" style="color: {$link_color};">
                                                  <img alt src="https://www.mailjet.com/images/theme/v1/icons/ico-social/instagram.png" style="border-radius:3px;display:block;" width="30">
                                                </a>
                                              </td>
                                            </tr>
                                          </tbody>
                                        </table>
                                      </td>
                                      <td style="vertical-align:middle;padding:4px 4px 4px 0;text-align:left;">
                                        <a href="{'app.contact.social.instagram'|system_parameter}" style="color: {$text_color}; font-size: 15px; font-family: {$font_stack}; line-height: 1.25; text-decoration: none;" target="_blank"> Instagram </a>
                                      </td>
                                    </tr> {/if}{if $show_li} <tr>
                                      <td style="padding:4px;vertical-align:middle;">
                                        <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#0077b5;border-radius:3px;width:30px;">
                                          <tbody>
                                            <tr>
                                              <td style="font-size:0;height:30px;vertical-align:middle;width:30px;">
                                                <a href="{'app.contact.social.linkedin'|system_parameter}" target="_blank" style="color: {$link_color};">
                                                  <img alt src="https://www.mailjet.com/images/theme/v1/icons/ico-social/linkedin.png" style="border-radius:3px;display:block;" width="30">
                                                </a>
                                              </td>
                                            </tr>
                                          </tbody>
                                        </table>
                                      </td>
                                      <td style="vertical-align:middle;padding:4px 4px 4px 0;text-align:left;">
                                        <a href="{'app.contact.social.linkedin'|system_parameter}" style="color: {$text_color}; font-size: 15px; font-family: {$font_stack}; line-height: 1.25; text-decoration: none;" target="_blank"> LinkedIn </a>
                                      </td>
                                    </tr> {/if}{if $show_pi} <tr>
                                      <td style="padding:4px;vertical-align:middle;">
                                        <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#bd081c;border-radius:3px;width:30px;">
                                          <tbody>
                                            <tr>
                                              <td style="font-size:0;height:30px;vertical-align:middle;width:30px;">
                                                <a href="{'app.contact.social.pinterest'|system_parameter}" target="_blank" style="color: {$link_color};">
                                                  <img alt src="https://www.mailjet.com/images/theme/v1/icons/ico-social/pinterest.png" style="border-radius:3px;display:block;" width="30">
                                                </a>
                                              </td>
                                            </tr>
                                          </tbody>
                                        </table>
                                      </td>
                                      <td style="vertical-align:middle;padding:4px 4px 4px 0;text-align:left;">
                                        <a href="{'app.contact.social.pinterest'|system_parameter}" style="color: {$text_color}; font-size: 15px; font-family: {$font_stack}; line-height: 1.25; text-decoration: none;" target="_blank"> Pinterest </a>
                                      </td>
                                    </tr> {/if}{if $show_sn} <tr>
                                      <td style="padding:4px;vertical-align:middle;">
                                        <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#FFFA54;border-radius:3px;width:30px;">
                                          <tbody>
                                            <tr>
                                              <td style="font-size:0;height:30px;vertical-align:middle;width:30px;">
                                                <a href="{'app.contact.social.snapchat'|system_parameter}" target="_blank" style="color: {$link_color};">
                                                  <img alt src="https://www.mailjet.com/images/theme/v1/icons/ico-social/snapchat.png" style="border-radius:3px;display:block;" width="30">
                                                </a>
                                              </td>
                                            </tr>
                                          </tbody>
                                        </table>
                                      </td>
                                      <td style="vertical-align:middle;padding:4px 4px 4px 0;text-align:left;">
                                        <a href="{'app.contact.social.snapchat'|system_parameter}" style="color: {$text_color}; font-size: 15px; font-family: {$font_stack}; line-height: 1.25; text-decoration: none;" target="_blank"> Snapchat </a>
                                      </td>
                                    </tr> {/if}{if $show_tw} <tr>
                                      <td style="padding:4px;vertical-align:middle;">
                                        <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#55acee;border-radius:3px;width:30px;">
                                          <tbody>
                                            <tr>
                                              <td style="font-size:0;height:30px;vertical-align:middle;width:30px;">
                                                <a href="{'app.contact.social.twitter'|system_parameter}" target="_blank" style="color: {$link_color};">
                                                  <img alt src="https://www.mailjet.com/images/theme/v1/icons/ico-social/twitter.png" style="border-radius:3px;display:block;" width="30">
                                                </a>
                                              </td>
                                            </tr>
                                          </tbody>
                                        </table>
                                      </td>
                                      <td style="vertical-align:middle;padding:4px 4px 4px 0;text-align:left;">
                                        <a href="{'app.contact.social.twitter'|system_parameter}" style="color: {$text_color}; font-size: 15px; font-family: {$font_stack}; line-height: 1.25; text-decoration: none;" target="_blank"> Twitter </a>
                                      </td>
                                    </tr> {/if}{if $show_vm} <tr>
                                      <td style="padding:4px;vertical-align:middle;">
                                        <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#53B4E7;border-radius:3px;width:30px;">
                                          <tbody>
                                            <tr>
                                              <td style="font-size:0;height:30px;vertical-align:middle;width:30px;">
                                                <a href="{'app.contact.social.vimeo'|system_parameter}" target="_blank" style="color: {$link_color};">
                                                  <img alt src="https://www.mailjet.com/images/theme/v1/icons/ico-social/vimeo.png" style="border-radius:3px;display:block;" width="30">
                                                </a>
                                              </td>
                                            </tr>
                                          </tbody>
                                        </table>
                                      </td>
                                      <td style="vertical-align:middle;padding:4px 4px 4px 0;text-align:left;">
                                        <a href="{'app.contact.social.vimeo'|system_parameter}" style="color: {$text_color}; font-size: 15px; font-family: {$font_stack}; line-height: 1.25; text-decoration: none;" target="_blank"> Vimeo </a>
                                      </td>
                                    </tr> {/if}{if $show_yt} <tr>
                                      <td style="padding:4px;vertical-align:middle;">
                                        <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#EB3323;border-radius:3px;width:30px;">
                                          <tbody>
                                            <tr>
                                              <td style="font-size:0;height:30px;vertical-align:middle;width:30px;">
                                                <a href="{'app.contact.social.youtube'|system_parameter}" target="_blank" style="color: {$link_color};">
                                                  <img alt src="https://www.mailjet.com/images/theme/v1/icons/ico-social/youtube.png" style="border-radius:3px;display:block;" width="30">
                                                </a>
                                              </td>
                                            </tr>
                                          </tbody>
                                        </table>
                                      </td>
                                      <td style="vertical-align:middle;padding:4px 4px 4px 0;text-align:left;">
                                        <a href="{'app.contact.social.youtube'|system_parameter}" style="color: {$text_color}; font-size: 15px; font-family: {$font_stack}; line-height: 1.25; text-decoration: none;" target="_blank"> YouTube </a>
                                      </td>
                                    </tr> {/if}{if $show_sc} <tr>
                                      <td style="padding:4px;vertical-align:middle;">
                                        <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#EF7F31;border-radius:3px;width:30px;">
                                          <tbody>
                                            <tr>
                                              <td style="font-size:0;height:30px;vertical-align:middle;width:30px;">
                                                <a href="{'app.contact.social.soundcloud'|system_parameter}" target="_blank" style="color: {$link_color};">
                                                  <img alt src="https://www.mailjet.com/images/theme/v1/icons/ico-social/soundcloud.png" style="border-radius:3px;display:block;" width="30">
                                                </a>
                                              </td>
                                            </tr>
                                          </tbody>
                                        </table>
                                      </td>
                                      <td style="vertical-align:middle;padding:4px 4px 4px 0;text-align:left;">
                                        <a href="{'app.contact.social.soundcloud'|system_parameter}" style="color: {$text_color}; font-size: 15px; font-family: {$font_stack}; line-height: 1.25; text-decoration: none;" target="_blank"> SoundCloud </a>
                                      </td>
                                    </tr> {/if} </tbody>
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
            <!--[if mso | IE]></td></tr></table><![endif]-->
          </td>
        </tr>
      </tbody>
    </table>
    <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:gray;background-color:gray;width:100%;">
      <tbody>
        <tr>
          <td>
            <!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" bgcolor="gray" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
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
                              <td style="vertical-align:top;padding-right:15px;padding-left:15px;">
                                <table border="0" cellpadding="0" cellspacing="0" role="presentation" style width="100%">
                                  <tbody>
                                    <tr>
                                      <td align="left" style="font-size:0px;word-break:break-word;">
                                        <div class="mj-inline-links" style>
                                          <!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0" align="left"><tr><![endif]-->
                                          {assign first 1}
                                          {foreach [
                                            "terms_and_conditions",
                                            "privacy_policy"
                                          ] as $code}
                                            {assign page Page::GetInstanceByCode($code)}
                                            {if $page}
                                              {if $first}{assign first 0}{else} | {/if}
                                              <!--[if mso | IE]><td style="padding:15px 10px;" class="" ><![endif]-->
                                              <a class="mj-link" href="{$page|link_to_page:"with_hostname"}"" target="_blank" style="display: inline-block; color: #ffffff; font-family: {$font_stack}; font-size: 14px; font-weight: normal; line-height: 1.25; text-decoration: none; text-transform: none; padding: 15px 10px;">{$page->getTitle()}</a>
                                              <!--[if mso | IE]></td><![endif]-->
                                            {/if}
                                          {/foreach}                                         
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
                      <!--[if mso | IE]></td></tr></table><![endif]-->
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



		