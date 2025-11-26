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
    {render partial="partials/spacer" height=40}
    <table align="center" class="footer" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
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
                              <td align="left" style="font-size:0px;padding:10px 10px;word-break:break-word;">
                                <div class="footer-text">
                                  <p style="margin: 0 0 16px 0;">
                                    <a href="{!$region->getDefaultUrl()}">{"app.name.official"|system_parameter}</a><br>
                                    {if $eshop}
                                    {$eshop->getAddressStreet()}<br/>
                                    {if $eshop->getAddressStreet2()}
                                    {$eshop->getAddressStreet2()}<br/>
                                    {/if}
                                    {$eshop->getAddressZip()} {$eshop->getAddressCity()}<br/>
                                    {/if}
                                  </p>
                                  <p style="margin: 0 0 16px 0;">
                                    {t}E-mail{/t}: <a href="mailto:{"app.contact.email"|system_parameter}">{"app.contact.email"|system_parameter}</a><br>
                                    {t}Tel.{/t}: <a href="tel:{"app.contact.phone"|system_parameter|replace:".":""}">{"app.contact.phone"|system_parameter|display_phone}</a>
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
                              <td align="left" style="font-size:0px;padding:10px 10px;word-break:break-word;">
                                <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="margin:0px;">
                                  <tbody> 
                                    {if $show_fb}
                                      {render partial="partials/social_link" 
                                        bg="#3b5998" 
                                        icon="https://www.mailjet.com/images/theme/v1/icons/ico-social/facebook.png" 
                                        link="{'app.contact.social.facebook'|system_parameter}" 
                                        name="Facebook"
                                      }
                                    {/if}
                                    {if $show_ig}
                                      {render partial="partials/social_link" 
                                        bg="#3f729b" 
                                        icon="https://www.mailjet.com/images/theme/v1/icons/ico-social/instagram.png" 
                                        link="{'app.contact.social.instagram'|system_parameter}" 
                                        name="Instagram"
                                      }
                                    {/if}
                                    {if $show_li}
                                      {render partial="partials/social_link" 
                                        bg="#0077b5" 
                                        icon="https://www.mailjet.com/images/theme/v1/icons/ico-social/linkedin.png" 
                                        link="{'app.contact.social.linkedin'|system_parameter}" 
                                        name="LinkedIn"
                                      }
                                    {/if}
                                    {if $show_pi}
                                      {render partial="partials/social_link" 
                                        bg="#bd081c" 
                                        icon="https://www.mailjet.com/images/theme/v1/icons/ico-social/pinterest.png" 
                                        link="{'app.contact.social.pinterest'|system_parameter}" 
                                        name="Pinterest"
                                      }
                                    {/if}
                                    {if $show_sn}
                                      {render partial="partials/social_link" 
                                        bg="#FFFA54" 
                                        icon="https://www.mailjet.com/images/theme/v1/icons/ico-social/snapchat.png" 
                                        link="{'app.contact.social.snapchat'|system_parameter}" 
                                        name="Snapchat"
                                      }
                                    {/if}
                                    {if $show_tw}
                                      {render partial="partials/social_link" 
                                        bg="#000000" 
                                        icon="https://www.mailjet.com/images/theme/v1/icons/ico-social/twitter-x.png" 
                                        link="{'app.contact.social.twitter'|system_parameter}" 
                                        name="X"
                                      }
                                    {/if}
                                    {if $show_vm}
                                      {render partial="partials/social_link" 
                                        bg="#53B4E7" 
                                        icon="https://www.mailjet.com/images/theme/v1/icons/ico-social/vimeo.png" 
                                        link="{'app.contact.social.vimeo'|system_parameter}" 
                                        name="Vimeo"
                                      }
                                    {/if}
                                    {if $show_yt}
                                      {render partial="partials/social_link" 
                                        bg="#EB3323" 
                                        icon="https://www.mailjet.com/images/theme/v1/icons/ico-social/youtube.png" 
                                        link="{'app.contact.social.youtube'|system_parameter}" 
                                        name="YouTube"
                                      }
                                    {/if}
                                    {if $show_sc}
                                      {render partial="partials/social_link" 
                                        bg="#EF7F31" 
                                        icon="https://www.mailjet.com/images/theme/v1/icons/ico-social/soundcloud.png" 
                                        link="{'app.contact.social.soundcloud'|system_parameter}" 
                                        name="SoundCloud"
                                      }
                                    {/if}
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
    <table align="center" class="footer_lower" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
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
                              <td style="vertical-align:top;padding-right:10px;padding-left:10px;">
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
                                              <a class="mj-link" href="{$page|link_to_page:"with_hostname"}"" target="_blank" style="display: inline-block; text-transform: none; padding: 15px 10px;">{$page->getTitle()}</a>
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



		