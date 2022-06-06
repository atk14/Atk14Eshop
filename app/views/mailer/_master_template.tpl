<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
  <head>
    <title>
      
    </title>
    <!--[if !mso]><!-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--<![endif]-->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
      #outlook a { padding:0; }
      body { margin:0;padding:0;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%; }
      table, td { border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt; }
      img { border:0;height:auto;line-height:100%; outline:none;text-decoration:none;-ms-interpolation-mode:bicubic; }
      p { display:block;margin:13px 0; }
    </style>
    <!--[if mso]>
    <noscript>
    <xml>
    <o:OfficeDocumentSettings>
      <o:AllowPNG/>
      <o:PixelsPerInch>96</o:PixelsPerInch>
    </o:OfficeDocumentSettings>
    </xml>
    </noscript>
    <![endif]-->
    <!--[if lte mso 11]>
    <style type="text/css">
      .mj-outlook-group-fix { width:100% !important; }
    </style>
    <![endif]-->
    
    
    <style type="text/css">
      @media only screen and (min-width:480px) {
        .mj-column-per-100 { width:100% !important; max-width: 100%; }
.mj-column-per-15 { width:15% !important; max-width: 15%; }
.mj-column-per-60 { width:60% !important; max-width: 60%; }
.mj-column-per-25 { width:25% !important; max-width: 25%; }
.mj-column-per-50 { width:50% !important; max-width: 50%; }
.mj-column-per-33-33 { width:33.33% !important; max-width: 33.33%; }
      }
    </style>
    <style media="screen and (min-width:480px)">
      .moz-text-html .mj-column-per-100 { width:100% !important; max-width: 100%; }
.moz-text-html .mj-column-per-15 { width:15% !important; max-width: 15%; }
.moz-text-html .mj-column-per-60 { width:60% !important; max-width: 60%; }
.moz-text-html .mj-column-per-25 { width:25% !important; max-width: 25%; }
.moz-text-html .mj-column-per-50 { width:50% !important; max-width: 50%; }
.moz-text-html .mj-column-per-33-33 { width:33.33% !important; max-width: 33.33%; }
    </style>
    
  
    <style type="text/css">
    
    

    @media only screen and (max-width:480px) {
      table.mj-full-width-mobile { width: 100% !important; }
      td.mj-full-width-mobile { width: auto !important; }
    }
  

      noinput.mj-menu-checkbox { display:block!important; max-height:none!important; visibility:visible!important; }

      @media only screen and (max-width:480px) {
        .mj-menu-checkbox[type="checkbox"] ~ .mj-inline-links { display:none!important; }
        .mj-menu-checkbox[type="checkbox"]:checked ~ .mj-inline-links,
        .mj-menu-checkbox[type="checkbox"] ~ .mj-menu-trigger { display:block!important; max-width:none!important; max-height:none!important; font-size:inherit!important; }
        .mj-menu-checkbox[type="checkbox"] ~ .mj-inline-links > a { display:block!important; }
        .mj-menu-checkbox[type="checkbox"]:checked ~ .mj-menu-trigger .mj-menu-icon-close { display:block!important; }
        .mj-menu-checkbox[type="checkbox"]:checked ~ .mj-menu-trigger .mj-menu-icon-open { display:none!important; }
      }
    
    </style>
    <style type="text/css">
    
    </style>
    
  </head>
  <body style="word-spacing:normal;background-color:{$bg_color};">
    
    <div style="display:none;font-size:1px;color:#ffffff;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;">
      {!$preheader_text}
    </div>
  
    
      <div style="background-color:{$bg_color};">
        {* Voucher *}
  {assign show_voucher true}
  {assign voucher_code "ATK14ESHOP"}
  {assign voucher_amount "20 %"}
  {assign voucher_title "Vaše sleva na příští nákup"}
  {assign voucher_footer "Slevový kód zadejte v níákupním košíku. Sleva platí do 15. 6. 2022"}

  {* CTA button *}
  {assign show_cta_button true}
  {assign cta_btn_link "cta-test.html"}
  {assign cta_btn_text "Start shopping!"}

  {* Product Gallery - recommended to place no more than 3 cards in single gallery *}
  {assign show_products_gallery true}
  {assign product_gallery_title "Mohlo by vás zajímat"}
  {assign product_cards [ ["title" => "Card Title 1", "price" => "1450 Kč", "description" => "Ennui tumeric hot chicken squid asymmetrical listicle kombucha direct trade fixie photo booth cronut umami.", "button_text" => "Více informací", "button_link" => "/product1", "image" => "https://placekitten.com/500/500" ], ["title" => "Card Title two", "price" => "2 380 Kč", "description" => "Ennui tumeric hot chicken squid asymmetrical listicle kombucha direct trade fixie photo booth cronut umami.", "button_text" => "Více informací", "button_link" => "/product1", "image" => "https://placekitten.com/500/500" ], ["title" => "Third Card Title", "price" => "990 Kč", "description" => "Ennui tumeric hot chicken squid asymmetrical listicle kombucha direct trade fixie photo booth cronut umami.", "button_text" => "Více informací", "button_link" => "/product1", "image" => "https://placekitten.com/500/500" ] ]}

  {* Wide image / banner *}
  {assign show_banner true}
  {assign banner_image "http://placekitten.com/550/200"}
  {assign banner_link "/banner-link"}
  {assign banner_alt "Banner Alt text"}

  {* Text with images - may contain any number of items *}
  {assign show_text_images true}
  {assign text_images_title "Text s obrázky"}
  {assign text_images_content [ [ "title" => "Section 1 Title", "text" => "Hexagon hammock health goth direct trade hoodie kogi aesthetic truffaut vape, sustainable DIY man braid bicycle rights narwhal.", "image" => "https://placekitten.com/500/400", "link" => "#" ], [ "title" => "Keffiyeh sustainable blog franzen", "text" => "Venmo fixie af, chia la croix lo-fi poke taiyaki literally locavore hashtag keffiyeh poutine air plant. Artisan chicharrones salvia lumbersexual shaman. Hexagon hammock health goth direct trade hoodie.", "image" => "https://placekitten.com/600/400", "link" => "#" ],      [ "title" => "Section 3 Title", "text" => "Hexagon hammock health goth direct trade hoodie kogi aesthetic truffaut vape, sustainable DIY man braid bicycle rights narwhal.", "image" => "https://placekitten.com/500/400", "link" => "#" ], [ "title" => "Keffiyeh sustainable blog franzen", "text" => "Venmo fixie af, chia la croix lo-fi poke taiyaki literally locavore hashtag keffiyeh poutine air plant. Artisan chicharrones salvia lumbersexual shaman. Hexagon hammock health goth direct trade hoodie.", "image" => "https://placekitten.com/600/400", "link" => "#" ] ]}

  {* Footer Links *}
  {assign link_conditions "/terms-and-conditions"}
  {assign link_privacy "/privacy"}
  {assign link_contacts "/contacts"}
  {assign link_stores "/stores"}<!-- header -->{* tato znacka se pouziva pri konverzi HTML textu do plain text *}
      <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:{$brand_color};background-color:{$brand_color};width:100%;">
        <tbody>
          <tr>
            <td>
              
        
      <!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" bgcolor="{$brand_color}" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
    
        
      <div style="margin:0px auto;max-width:600px;">
        
        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
          <tbody>
            <tr>
              <td style="direction:ltr;font-size:0px;padding:0;padding-bottom:0;padding-top:0;text-align:center;">
                <!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]-->
            
      <div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
        
      <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
        <tbody>
          
              <tr>
                <td align="center" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  
      <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;">
        <tbody>
          <tr>
            <td style="width:103px;">
              
        <a href="{!$region->getDefaultUrl()}" target="_blank" style="color: {$link_color};">
          
      <img alt="app name" height="40" src="{$logo_src}" style="border:0;display:block;outline:none;text-decoration:none;height:40px;width:100%;font-size:16px;" width="103">
    
        </a>
      
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
    
    <!-- /header -->
      
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
                <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  
      <div style="font-family:{$font_stack};font-size:16px;line-height:1.5;text-align:left;color:{$text_color};">{placeholder}</div>
    
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
    
    {if $message_type == "notify_order_creation" }
      <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:white;background-color:white;width:100%;">
        <tbody>
          <tr>
            <td>
              
        
      <!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" bgcolor="white" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
    
        
      <div style="margin:0px auto;max-width:600px;">
        
        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
          <tbody>
            <tr>
              <td style="direction:ltr;font-size:0px;padding:20px 0;text-align:center;">
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
                <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  
      <div style="font-family:{$font_stack};font-size:16px;line-height:1.25;text-align:left;color:{$text_color};"><p class="nomargin" style="margin: 0 0 16px 0; margin-bottom: 0;"><strong>{t}Detaily objednávky{/t}</strong></p></div>
    
                </td>
              </tr>
            
              <tr>
                <td align="center" style="font-size:0px;padding:0 25px;word-break:break-word;">
                  
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
                <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  
      <div style="font-family:{$font_stack};font-size:14px;line-height:1.5;text-align:left;color:{$text_color};">{t}Číslo objednávky:{/t} <strong>{!$order->getOrderNo()}</strong><br>
						{t}Vytvořena:{/t} {$order->getCreatedAt()|format_datetime}<br>
						{t}Platba:{/t} {$order->getPaymentMethod()}</div>
    
                </td>
              </tr>
            
              <tr>
                <td align="center" style="font-size:0px;padding:0 25px;word-break:break-word;">
                  
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
    
      
      <!--[if mso | IE]></td></tr></table></td></tr><![endif]-->
        {foreach $order->getItems() as $item}{assign product $item->getProduct()}
{if $product->getCode()=="price_rounding"}
          <!--[if mso | IE]><tr><td class="" width="600px" ><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
    
      
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
                <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  
      <div style="font-family:{$font_stack};font-size:16px;line-height:1.25;text-align:left;color:{$text_color};"><p class="compact" style="margin: 0 0 16px 0; margin-bottom: 4px;">
					<span class="bodycolor" style="color: {$text_color}; text-decoration: none;"><strong>{!$product->getName()}</strong><br></span>
				</p></div>
    
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
                <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  
      <div style="font-family:{$font_stack};font-size:16px;line-height:1.25;text-align:left;color:{$text_color};"><p class="item-price small compact nomargin" style="margin: 0 0 16px 0; font-size: 14px; margin-bottom: 0; text-align: right;">
					<span class="currency-main" style="font-size: 16px; font-weight: bold;">{!$item->getPriceInclVat()|display_price:"$currency"}</span>
				</p></div>
    
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
                <td align="center" style="font-size:0px;padding:0 25px;word-break:break-word;">
                  
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
    
      
      <!--[if mso | IE]></td></tr></table></td></tr><![endif]-->
        {else}
			{assign var="product_link" value = $product|link_to_product:"with_hostname=$default_domain"}
			{assign var="product_image" value = $product->getImage()|img_url:"60x60xffffff"}
          <!--[if mso | IE]><tr><td class="" width="600px" ><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
    
      
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
          <!-- htmlonly -->{* tato znacka se pouziva pri konverzi HTML textu do plain text *}
              <tr>
                <td align="left" style="font-size:0px;padding:10px 25px;padding-right:0;padding-bottom:0;word-break:break-word;">
                  
      <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;">
        <tbody>
          <tr>
            <td style="width:60px;">
              
        <a href="{!$product_link}" target="_blank" style="color: {$link_color};">
          
      <img alt height="auto" src="{!$product_image}" style="border:0;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:16px;" width="60">
    
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
                <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  
      <div style="font-family:{$font_stack};font-size:16px;line-height:1.25;text-align:left;color:{$text_color};"><p class="compact" style="margin: 0 0 16px 0; margin-bottom: 4px;">
					<a href="{!$product_link}" class="bodycolor" style="color: {$text_color}; text-decoration: none;"><strong>{!$product->getName()}</strong><br></a>
				</p>
				<p class="small compact" style="margin: 0 0 16px 0; margin-bottom: 4px; font-size: 14px;">
					{t}Kód{/t}: {$product->getCatalogId()}<br>
					{t}Jedn. cena{/t}: {!$item->getUnitPriceInclVat()|display_price:"$currency"}<br>
					{t}Množství{/t}: {$item->getAmount()}
				</p></div>
    
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
                <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  
      <div style="font-family:{$font_stack};font-size:16px;line-height:1.25;text-align:left;color:{$text_color};"><p class="item-price small compact nomargin" style="margin: 0 0 16px 0; font-size: 14px; margin-bottom: 0; text-align: right;">
					<span class="currency-main" style="font-size: 16px; font-weight: bold;">{!$item->getPriceInclVat()|display_price:"$currency"}</span>
				</p></div>
    
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
                <td align="center" style="font-size:0px;padding:0 25px;word-break:break-word;">
                  
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
    
      
      <!--[if mso | IE]></td></tr></table></td></tr><![endif]-->
        {/if}{/foreach}
          <!--[if mso | IE]><tr><td class="" width="600px" ><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
    
      
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
                <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  
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
                <td align="right" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  
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
    
      
      <!--[if mso | IE]></td></tr></table></td></tr><![endif]-->
        {foreach $order->getVouchers() as $voucher}
          <!--[if mso | IE]><tr><td class="" width="600px" ><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
    
      
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
                <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  
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
                <td align="right" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  
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
    
      
      <!--[if mso | IE]></td></tr></table></td></tr><![endif]-->
        {/foreach}{foreach $order->getCampaigns() as $campaign}
			{if $campaign->getDiscountAmount()}
          <!--[if mso | IE]><tr><td class="" width="600px" ><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
    
      
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
                <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  
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
                <td align="right" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  
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
    
      
      <!--[if mso | IE]></td></tr></table></td></tr><![endif]-->
        {/if}
			{/foreach}
          <!--[if mso | IE]><tr><td class="" width="600px" ><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
    
      
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
                <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  
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
                <td align="right" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  
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
                <td align="center" style="font-size:0px;padding:0 25px;word-break:break-word;">
                  
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
                <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  
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
                <td align="right" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  
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
    
      
      <!--[if mso | IE]></td></tr></table></td></tr><![endif]-->
        {if is_null($order->getShippingFeeInclVat())}
          <!--[if mso | IE]><tr><td class="" width="600px" ><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
    
      
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
                <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  
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
    
      
      <!--[if mso | IE]></td></tr></table></td></tr><![endif]-->
        {/if}
          <!--[if mso | IE]><tr><td class="" width="600px" ><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
    
      
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
                <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  
      <div style="font-family:{$font_stack};font-size:16px;line-height:1.25;text-align:left;color:{$text_color};"><p class="nomargin" style="margin: 0 0 16px 0; margin-bottom: 0;"><strong>{t}Přeprava{/t}</strong></p></div>
    
                </td>
              </tr>
            
              <tr>
                <td align="center" style="font-size:0px;padding:0 25px;word-break:break-word;">
                  
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
                <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  
      <div style="font-family:{$font_stack};font-size:14px;line-height:1.5;text-align:left;color:{$text_color};">{t}Dopravce:{/t} <strong>{$order->getDeliveryMethod()}</strong><br>
						{*Tracking: <a href="#" style="color: {$link_color};">356166</a><br>*}</div>
    
                </td>
              </tr>
            
              <tr>
                <td align="center" style="font-size:0px;padding:0 25px;word-break:break-word;">
                  
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
                <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  
      <div style="font-family:{$font_stack};font-size:14px;line-height:1.5;text-align:left;color:{$text_color};"><strong>{t}Fakturační adresa{/t}</strong><br>
						{render partial="shared/order/invoice_address"}</div>
    
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
                <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  
      <div style="font-family:{$font_stack};font-size:14px;line-height:1.5;text-align:left;color:{$text_color};"><strong>{t}Dodací adresa{/t}</strong><br>
						{render partial="shared/order/delivery_address"}</div>
    
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
                <td align="center" style="font-size:0px;padding:0 25px;word-break:break-word;">
                  
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
    
      
      <!--[if mso | IE]></td></tr></table></td></tr><![endif]-->
        {if $order->getNote()}
          <!--[if mso | IE]><tr><td class="" width="600px" ><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
    
      
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
                <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  
      <div style="font-family:{$font_stack};font-size:14px;line-height:1.5;text-align:left;color:{$text_color};"><strong>{t}Vaše poznámka k objednávce:{/t}</strong><br>
							{!$order->getNote()|h|nl2br}</div>
    
                </td>
              </tr>
            
              <tr>
                <td align="center" style="font-size:0px;padding:0 25px;word-break:break-word;">
                  
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
    
      
      <!--[if mso | IE]></td></tr></table></td></tr><![endif]-->
        {/if}
          <!--[if mso | IE]><tr><td class="" width="600px" ><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
    
      
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
                <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  
      <div style="font-family:{$font_stack};font-size:14px;line-height:1.5;text-align:left;color:{$text_color};">{render partial="order_status_check_notice.html"}</div>
    
                </td>
              </tr>
            
              <tr>
                <td align="center" style="font-size:0px;padding:0 25px;word-break:break-word;">
                  
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
    {/if}{if $voucher_amount && $voucher_code && $show_voucher }
      <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:{$brand_color};background-color:{$brand_color};width:100%;">
        <tbody>
          <tr>
            <td>
              
        
      <!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" bgcolor="{$brand_color}" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
    
        
      <div style="margin:0px auto;max-width:600px;">
        
        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
          <tbody>
            <tr>
              <td style="direction:ltr;font-size:0px;padding:20px 0;text-align:center;">
                <!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" width="600px" ><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
    
      
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
                <td align="center" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  
      <div style="font-family:{$font_stack};font-size:18px;line-height:1.25;text-align:center;color:white;"><p style="margin: 0 0 16px 0;"><strong>{!$voucher_title}</strong></p></div>
    
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
    
      
      <!--[if mso | IE]></td></tr></table></td></tr><tr><td class="" width="600px" ><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" bgcolor="{$brand_color}" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
    
      
      <div style="background:{$brand_color};background-color:{$brand_color};margin:0px auto;max-width:600px;">
        
        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:{$brand_color};background-color:{$brand_color};width:100%;">
          <tbody>
            <tr>
              <td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:20px;padding-top:0;text-align:center;">
                <!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:150px;" ><![endif]-->
            
      <div class="mj-column-per-25 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
        
      <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
        <tbody>
          
        </tbody>
      </table>
    
      </div>
    
          <!--[if mso | IE]></td><td align="ccenter" class="" style="vertical-align:top;width:300px;" ><![endif]-->
            
      <div class="mj-column-per-50 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
        
      <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
        <tbody>
          
              <tr>
                <td align="center" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  
      <div style="font-family:{$font_stack};font-size:16px;line-height:1.25;text-align:center;color:{$text_color};"><div style="background:white; padding:20px; border-radius:10px">
            <p class="nomargin" style="margin: 0 0 16px 0; margin-bottom: 0; font-size: 36px; color: {$primary_color};"><strong>{$voucher_amount}</strong></p>
            <p class="nomargin" style="margin: 0 0 16px 0; margin-bottom: 0;"><strong>{t}Kód:{/t} {$voucher_code}</strong></p>
          </div></div>
    
                </td>
              </tr>
            
        </tbody>
      </table>
    
      </div>
    
          <!--[if mso | IE]></td><td class="" style="vertical-align:top;width:150px;" ><![endif]-->
            
      <div class="mj-column-per-25 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
        
      <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
        <tbody>
          
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
                <td align="center" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  
      <div style="font-family:{$font_stack};font-size:16px;line-height:1.25;text-align:center;color:white;"><p class="nomargin" style="margin: 0 0 16px 0; margin-bottom: 0;">{!$voucher_footer}</p></div>
    
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
    {/if}{if $show_products_gallery}
      
      <!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
    
      
      <div style="margin:0px auto;max-width:600px;">
        
        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
          <tbody>
            <tr>
              <td style="direction:ltr;font-size:0px;padding:20px 0;text-align:center;">
                <!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" width="600px" ><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
    
      
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
                <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  
      <div style="font-family:{$font_stack};font-size:16px;line-height:1.25;text-align:left;color:{$text_color};"><p class="nomargin" style="margin: 0 0 16px 0; margin-bottom: 0;"><strong>{!$product_gallery_title}</strong></p></div>
    
                </td>
              </tr>
            
              <tr>
                <td align="center" style="font-size:0px;padding:0 25px;word-break:break-word;">
                  
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
                <!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><![endif]-->
      {foreach $product_cards as $card}
          <!--[if mso | IE]><td class="product-card-outlook" style="vertical-align:top;width:199.98px;" ><![endif]-->
            
      <div class="mj-column-per-33-33 mj-outlook-group-fix product-card" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
        
      <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
        <tbody>
          <tr>
            <td style="vertical-align:top;padding-bottom:20px;">
              
      <table border="0" cellpadding="0" cellspacing="0" role="presentation" style width="100%">
        <tbody>
          <!-- htmlonly -->
              <tr>
                <td align="left" style="font-size:0px;padding:10px 25px;padding-bottom:0;word-break:break-word;">
                  
      <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;" class="mj-full-width-mobile">
        <tbody>
          <tr>
            <td style="width:149px;" class="mj-full-width-mobile">
              
        <a href="{$link}" target="_blank" style="color: {$link_color};">
          
      <img alt="{$card.title}" height="auto" src="{$card.image}" style="border:0;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:16px;" width="149">
    
        </a>
      
            </td>
          </tr>
        </tbody>
      </table>
    
                </td>
              </tr>
            <!-- /htmlonly -->
              <tr>
                <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  
      <div style="font-family:{$font_stack};font-size:16px;line-height:1.25;text-align:left;color:{$text_color};"><p class="compact" style="margin: 0 0 16px 0; margin-bottom: 4px;"><a href="#" class="bodycolor" style="color: {$text_color}; text-decoration: none;"><strong>{$card.title}</strong></a></p>
						<p class="currency-main" style="margin: 0 0 16px 0; font-size: 16px; font-weight: bold; color: {$primary_color};">{$card.price}</p>
						<p class="compact small" style="margin: 0 0 16px 0; margin-bottom: 4px; font-size: 14px;">{$card.description}</p></div>
    
                </td>
              </tr>
            <!-- htmlonly -->
              <tr>
                <td align="center" vertical-align="middle" style="font-size:0px;padding:0 0 0 0;word-break:break-word;">
                  
      <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:separate;line-height:100%;">
        <tbody>
          <tr>
            <td align="center" bgcolor="{$primary_color}" role="presentation" style="border:none;border-radius:3px;cursor:auto;mso-padding-alt:10px 25px;background:{$primary_color};" valign="middle">
              <a href="{!$card.button_link}" style="display: inline-block; background: {$primary_color}; color: {$button_color}; font-family: {$font_stack}; font-size: 16px; font-weight: bold; line-height: 1.25; margin: 0; text-decoration: none; text-transform: none; padding: 10px 25px; mso-padding-alt: 0px; border-radius: 3px;" target="_blank">
                {!$card.button_text}
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
    
          <!--[if mso | IE]></td><![endif]-->
    {/foreach}

      <!--[if mso | IE]></tr></table><![endif]-->
              </td>
            </tr>
          </tbody>
        </table>
        
      </div>
    
      
      <!--[if mso | IE]></td></tr></table></td></tr></table><![endif]-->
              </td>
            </tr>
          </tbody>
        </table>
        
      </div>
    
      
      <!--[if mso | IE]></td></tr></table><![endif]-->
    
    {/if}{if $show_banner}<!-- htmlonly -->{* tato znacka se pouziva pri konverzi HTML textu do plain text *}
      
      <!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
    
      
      <div style="margin:0px auto;max-width:600px;">
        
        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
          <tbody>
            <tr>
              <td style="direction:ltr;font-size:0px;padding:20px 0;text-align:center;">
                <!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" width="600px" ><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
    
      
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
                <td align="center" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  
      <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;">
        <tbody>
          <tr>
            <td style="width:550px;">
              
        <a href="{!$banner_link}" target="_blank" style="color: {$link_color};">
          
      <img alt="{!$banner_alt}" height="200" src="{!$banner_image}" style="border:0;display:block;outline:none;text-decoration:none;height:200;width:100%;font-size:16px;" width="550">
    
        </a>
      
            </td>
          </tr>
        </tbody>
      </table>
    
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
    
      
      <!--[if mso | IE]></td></tr></table></td></tr></table><![endif]-->
              </td>
            </tr>
          </tbody>
        </table>
        
      </div>
    
      
      <!--[if mso | IE]></td></tr></table><![endif]-->
    
    <!-- /htmlonly -->{/if}{if $show_text_images}
      
      <!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
    
      
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
                <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  
      <div style="font-family:{$font_stack};font-size:16px;line-height:1.25;text-align:left;color:{$text_color};"><p class="nomargin" style="margin: 0 0 16px 0; margin-bottom: 0;"><strong>{!$text_images_title}</strong></p></div>
    
                </td>
              </tr>
            
              <tr>
                <td align="center" style="font-size:0px;padding:0 25px;word-break:break-word;">
                  
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
    
      
      <!--[if mso | IE]></td></tr></table><![endif]-->
    
    {foreach $text_images_content as $item}{if $item@iteration%2==1}
      
      <!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
    
      
      <div style="margin:0px auto;max-width:600px;">
        
        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
          <tbody>
            <tr>
              <td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:10px;padding-top:10px;text-align:center;">
                <!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:300px;" ><![endif]-->
            
      <div class="mj-column-per-50 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
        
      <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
        <tbody>
          
              <tr>
                <td align="center" style="font-size:0px;padding:10px 25px;padding-bottom:10px;word-break:break-word;">
                  
      <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;" class="mj-full-width-mobile">
        <tbody>
          <tr>
            <td style="width:250px;" class="mj-full-width-mobile">
              
        <a href="{$item.link}" target="_blank" style="color: {$link_color};">
          
      <img alt="{$item.title}" height="auto" src="{$item.image}" style="border:0;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:16px;" width="250">
    
        </a>
      
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
                <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  
      <div style="font-family:{$font_stack};font-size:16px;line-height:1.25;text-align:left;color:{$text_color};"><p style="margin: 0 0 16px 0;"><strong>{!$item.title}</strong></p>
						<p class="nomargin" style="margin: 0 0 16px 0; margin-bottom: 0;">{!$item.text}</p></div>
    
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
    
    {else}
      
      <!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
    
      
      <div style="margin:0px auto;max-width:600px;">
        
        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
          <tbody>
            <tr>
              <td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:10px;padding-top:10px;text-align:center;">
                <!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:300px;" ><![endif]-->
            
      <div class="mj-column-per-50 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
        
      <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
        <tbody>
          
              <tr>
                <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  
      <div style="font-family:{$font_stack};font-size:16px;line-height:1.25;text-align:left;color:{$text_color};"><p style="margin: 0 0 16px 0;"><strong>{!$item.title}</strong></p>
						<p class="nomargin" style="margin: 0 0 16px 0; margin-bottom: 0;">{!$item.text}</p></div>
    
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
                <td align="center" style="font-size:0px;padding:10px 25px;padding-bottom:10px;word-break:break-word;">
                  
      <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;" class="mj-full-width-mobile">
        <tbody>
          <tr>
            <td style="width:250px;" class="mj-full-width-mobile">
              
        <a href="{$item.link}" target="_blank" style="color: {$link_color};">
          
      <img alt="{$item.title}" height="auto" src="{$item.image}" style="border:0;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:16px;" width="250">
    
        </a>
      
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
    
    {/if}
      
      <!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
    
      
      <div style="margin:0px auto;max-width:600px;">
        
        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
          <tbody>
            <tr>
              <td style="direction:ltr;font-size:0px;padding:0;padding-bottom:0;padding-top:0;text-align:center;">
                <!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]-->
            
      <div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
        
      <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
        <tbody>
          <tr>
            <td style="vertical-align:top;padding:0;">
              
      <table border="0" cellpadding="0" cellspacing="0" role="presentation" style width="100%">
        <tbody>
          
              <tr>
                <td align="center" style="font-size:0px;padding:0 25px;word-break:break-word;">
                  
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
    
      
      <!--[if mso | IE]></td></tr></table><![endif]-->
    
    {/foreach}{/if}{if $show_cta_button}
      
      <!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
    
      
      <div style="margin:0px auto;max-width:600px;">
        
        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
          <tbody>
            <tr>
              <td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0;padding-top:20px;text-align:center;">
                <!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]-->
            
      <div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
        
      <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
        <tbody>
          
              <tr>
                <td align="center" vertical-align="middle" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  
      <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:separate;line-height:100%;">
        <tbody>
          <tr>
            <td align="center" bgcolor="{$primary_color}" role="presentation" style="border:none;border-radius:3px;cursor:auto;mso-padding-alt:10px 25px;background:{$primary_color};" valign="middle">
              <a href="{!$cta_btn_link}" style="display: inline-block; background: {$primary_color}; color: {$button_color}; font-family: {$font_stack}; font-size: 20px; font-weight: bold; line-height: 1.25; margin: 0; text-decoration: none; text-transform: none; padding: 10px 25px; mso-padding-alt: 0px; border-radius: 3px;" target="_blank">
                {!$cta_btn_text}
              </a>
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
    
    {/if}<!-- footer -->{* tato znacka se pouziva pri konverzi HTML textu do plain text *}{assign eshop Store::FindByCode("eshop")}
		{if 'app.contact.social.facebook'|system_parameter}{assign show_fb true}{/if}
		{if 'app.contact.social.instagram'|system_parameter}{assign show_ig true}{/if}
		{if 'app.contact.social.linkedin'|system_parameter}{assign show_li true}{/if}
		{if 'app.contact.social.pinterest'|system_parameter}{assign show_pi true}{/if}
		{if 'app.contact.social.snapchat'|system_parameter}{assign show_sn true}{/if}
		{if 'app.contact.social.twitter'|system_parameter}{assign show_tw true}{/if}
		{if 'app.contact.social.vimeo'|system_parameter}{assign show_vm true}{/if}
		{if 'app.contact.social.youtube'|system_parameter}{assign show_yt true}{/if}
		{if 'app.contact.social.soundcloud'|system_parameter}{assign show_sc true}{/if}
		{assign stores Store::FindAll("visible AND (code IS NULL OR code!='eshop')",[])}
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
                  
      <div style="font-family:{$font_stack};font-size:14px;line-height:1.25;text-align:left;color:{$footer_color};"><p style="margin: 0 0 16px 0;">
						<a href="{!$region->getDefaultUrl()}" style="color: {$link_color};">{"app.name.official"|system_parameter}</a><br>
						{if $eshop}
						{$eshop->getAddressStreet()}<br>
						{if $eshop->getAddressStreet2()}
						{$eshop->getAddressStreet2()}<br>
						{/if}
						{$eshop->getAddressZip()} {$eshop->getAddressCity()}<br>
						{/if}
					</p>
					<p style="margin: 0 0 16px 0;">Tel: <a href="tel:{$phone_number}" style="color: {$link_color};">{"app.contact.phone"|system_parameter|display_phone}</a></p></div>
    
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
        <tbody>
          {if $show_fb}
      <tr>
        <td style="padding:4px;vertical-align:middle;">
          <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#3b5998;border-radius:3px;width:30px;">
            <tbody>
              <tr>
                <td style="font-size:0;height:30px;vertical-align:middle;width:30px;">
                  <a href="{'app.contact.social.facebook'|system_parameter}" target="_blank" style="color: {$link_color};">
                    <img height="30" src="https://www.mailjet.com/images/theme/v1/icons/ico-social/facebook.png" style="border-radius:3px;display:block;" width="30">
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
        </td>
        
          <td style="vertical-align:middle;">
            <a href="{'app.contact.social.facebook'|system_parameter}" style="color: {$text_color}; font-size: 15px; font-family: {$font_stack}; line-height: 1.25; text-decoration: none;" target="_blank">
              Facebook
            </a>
          </td>
          
      </tr>
    {/if}{if $show_ig}
      <tr>
        <td style="padding:4px;vertical-align:middle;">
          <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#3f729b;border-radius:3px;width:30px;">
            <tbody>
              <tr>
                <td style="font-size:0;height:30px;vertical-align:middle;width:30px;">
                  <a href="{'app.contact.social.instagram'|system_parameter}" target="_blank" style="color: {$link_color};">
                    <img height="30" src="https://www.mailjet.com/images/theme/v1/icons/ico-social/instagram.png" style="border-radius:3px;display:block;" width="30">
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
        </td>
        
          <td style="vertical-align:middle;">
            <a href="{'app.contact.social.instagram'|system_parameter}" style="color: {$text_color}; font-size: 15px; font-family: {$font_stack}; line-height: 1.25; text-decoration: none;" target="_blank">
              Instagram
            </a>
          </td>
          
      </tr>
    {/if}{if $show_li}
      <tr>
        <td style="padding:4px;vertical-align:middle;">
          <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#0077b5;border-radius:3px;width:30px;">
            <tbody>
              <tr>
                <td style="font-size:0;height:30px;vertical-align:middle;width:30px;">
                  <a href="{'app.contact.social.linkedin'|system_parameter}" target="_blank" style="color: {$link_color};">
                    <img height="30" src="https://www.mailjet.com/images/theme/v1/icons/ico-social/linkedin.png" style="border-radius:3px;display:block;" width="30">
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
        </td>
        
          <td style="vertical-align:middle;">
            <a href="{'app.contact.social.linkedin'|system_parameter}" style="color: {$text_color}; font-size: 15px; font-family: {$font_stack}; line-height: 1.25; text-decoration: none;" target="_blank">
              LinkedIn
            </a>
          </td>
          
      </tr>
    {/if}{if $show_pi}
      <tr>
        <td style="padding:4px;vertical-align:middle;">
          <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#bd081c;border-radius:3px;width:30px;">
            <tbody>
              <tr>
                <td style="font-size:0;height:30px;vertical-align:middle;width:30px;">
                  <a href="{'app.contact.social.pinterest'|system_parameter}" target="_blank" style="color: {$link_color};">
                    <img height="30" src="https://www.mailjet.com/images/theme/v1/icons/ico-social/pinterest.png" style="border-radius:3px;display:block;" width="30">
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
        </td>
        
          <td style="vertical-align:middle;">
            <a href="{'app.contact.social.pinterest'|system_parameter}" style="color: {$text_color}; font-size: 15px; font-family: {$font_stack}; line-height: 1.25; text-decoration: none;" target="_blank">
              Pinterest
            </a>
          </td>
          
      </tr>
    {/if}{if $show_sn}
      <tr>
        <td style="padding:4px;vertical-align:middle;">
          <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#FFFA54;border-radius:3px;width:30px;">
            <tbody>
              <tr>
                <td style="font-size:0;height:30px;vertical-align:middle;width:30px;">
                  <a href="{'app.contact.social.snapchat'|system_parameter}" target="_blank" style="color: {$link_color};">
                    <img height="30" src="https://www.mailjet.com/images/theme/v1/icons/ico-social/snapchat.png" style="border-radius:3px;display:block;" width="30">
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
        </td>
        
          <td style="vertical-align:middle;">
            <a href="{'app.contact.social.snapchat'|system_parameter}" style="color: {$text_color}; font-size: 15px; font-family: {$font_stack}; line-height: 1.25; text-decoration: none;" target="_blank">
              Snapchat
            </a>
          </td>
          
      </tr>
    {/if}{if $show_tw}
      <tr>
        <td style="padding:4px;vertical-align:middle;">
          <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#55acee;border-radius:3px;width:30px;">
            <tbody>
              <tr>
                <td style="font-size:0;height:30px;vertical-align:middle;width:30px;">
                  <a href="{'app.contact.social.twitter'|system_parameter}" target="_blank" style="color: {$link_color};">
                    <img height="30" src="https://www.mailjet.com/images/theme/v1/icons/ico-social/twitter.png" style="border-radius:3px;display:block;" width="30">
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
        </td>
        
          <td style="vertical-align:middle;">
            <a href="{'app.contact.social.twitter'|system_parameter}" style="color: {$text_color}; font-size: 15px; font-family: {$font_stack}; line-height: 1.25; text-decoration: none;" target="_blank">
              Twitter
            </a>
          </td>
          
      </tr>
    {/if}{if $show_vm}
      <tr>
        <td style="padding:4px;vertical-align:middle;">
          <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#53B4E7;border-radius:3px;width:30px;">
            <tbody>
              <tr>
                <td style="font-size:0;height:30px;vertical-align:middle;width:30px;">
                  <a href="{'app.contact.social.vimeo'|system_parameter}" target="_blank" style="color: {$link_color};">
                    <img height="30" src="https://www.mailjet.com/images/theme/v1/icons/ico-social/vimeo.png" style="border-radius:3px;display:block;" width="30">
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
        </td>
        
          <td style="vertical-align:middle;">
            <a href="{'app.contact.social.vimeo'|system_parameter}" style="color: {$text_color}; font-size: 15px; font-family: {$font_stack}; line-height: 1.25; text-decoration: none;" target="_blank">
              Vimeo
            </a>
          </td>
          
      </tr>
    {/if}{if $show_yt}
      <tr>
        <td style="padding:4px;vertical-align:middle;">
          <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#EB3323;border-radius:3px;width:30px;">
            <tbody>
              <tr>
                <td style="font-size:0;height:30px;vertical-align:middle;width:30px;">
                  <a href="{'app.contact.social.youtube'|system_parameter}" target="_blank" style="color: {$link_color};">
                    <img height="30" src="https://www.mailjet.com/images/theme/v1/icons/ico-social/youtube.png" style="border-radius:3px;display:block;" width="30">
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
        </td>
        
          <td style="vertical-align:middle;">
            <a href="{'app.contact.social.youtube'|system_parameter}" style="color: {$text_color}; font-size: 15px; font-family: {$font_stack}; line-height: 1.25; text-decoration: none;" target="_blank">
              YouTube
            </a>
          </td>
          
      </tr>
    {/if}{if $show_sc}
      <tr>
        <td style="padding:4px;vertical-align:middle;">
          <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#EF7F31;border-radius:3px;width:30px;">
            <tbody>
              <tr>
                <td style="font-size:0;height:30px;vertical-align:middle;width:30px;">
                  <a href="{'app.contact.social.soundcloud'|system_parameter}" target="_blank" style="color: {$link_color};">
                    <img height="30" src="https://www.mailjet.com/images/theme/v1/icons/ico-social/soundcloud.png" style="border-radius:3px;display:block;" width="30">
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
        </td>
        
          <td style="vertical-align:middle;">
            <a href="{'app.contact.social.soundcloud'|system_parameter}" style="color: {$text_color}; font-size: 15px; font-family: {$font_stack}; line-height: 1.25; text-decoration: none;" target="_blank">
              SoundCloud
            </a>
          </td>
          
      </tr>
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
  
          {if $link_conditions}
        
    <!--[if mso | IE]><td style="padding:15px 10px;" class="" ><![endif]-->
  
        
      <a class="mj-link" href="{$link_conditions}" target="_blank" style="display: inline-block; color: #ffffff; font-family: {$font_stack}; font-size: 12px; font-weight: normal; line-height: 1.25; text-decoration: none; text-transform: none; padding: 15px 10px;">
        {t}Obchodní podmínky{/t}
      </a>
    
        
    <!--[if mso | IE]></td><![endif]-->
  
      {/if}{if $link_privacy}
        
    <!--[if mso | IE]><td style="padding:15px 10px;" class="" ><![endif]-->
  
        
      <a class="mj-link" href="{$link_privacy}" target="_blank" style="display: inline-block; color: #ffffff; font-family: {$font_stack}; font-size: 12px; font-weight: normal; line-height: 1.25; text-decoration: none; text-transform: none; padding: 15px 10px;">
        {t}Ochrana soukromí{/t}
      </a>
    
        
    <!--[if mso | IE]></td><![endif]-->
  
      {/if}{if $link_contacts}
        
    <!--[if mso | IE]><td style="padding:15px 10px;" class="" ><![endif]-->
  
        
      <a class="mj-link" href="{$link_contacts}" target="_blank" style="display: inline-block; color: #ffffff; font-family: {$font_stack}; font-size: 12px; font-weight: normal; line-height: 1.25; text-decoration: none; text-transform: none; padding: 15px 10px;">
        {t}Kontakty{/t}
      </a>
    
        
    <!--[if mso | IE]></td><![endif]-->
  
      {/if}{if $link_stores && sizeof($stores) > 0}
        
    <!--[if mso | IE]><td style="padding:15px 10px;" class="" ><![endif]-->
  
        
      <a class="mj-link" href="{$link_stores}" target="_blank" style="display: inline-block; color: #ffffff; font-family: {$font_stack}; font-size: 12px; font-weight: normal; line-height: 1.25; text-decoration: none; text-transform: none; padding: 15px 10px;">
        {t}Prodejny{/t}
      </a>
    
        
    <!--[if mso | IE]></td><![endif]-->
  
      {/if}
          
    <!--[if mso | IE]></tr></table><![endif]-->
  
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
    <!-- /footer -->
      </div>
    
  </body>
</html>
  