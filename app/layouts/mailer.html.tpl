<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/strict.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>{t region=$region->getApplicationName()}Zpráva z obchodu %1{/t}</title>
	{literal}
	<!--style>@media only screen{html{min-height:100%;background:{/literal}{$bg_color}{literal}}}@media only screen and (max-width:596px){.small-float-center{margin:0 auto!important;float:none!important;text-align:center!important}.small-text-left{text-align:left!important}}@media only screen and (max-width:596px){table.body img{width:auto;height:auto}table.body center{min-width:0!important}table.body .container{width:95%!important}table.body .columns{height:auto!important;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;box-sizing:border-box;padding-left:16px!important;padding-right:16px!important}table.body .columns .columns{padding-left:0!important;padding-right:0!important}table.body .collapse .columns{padding-left:0!important;padding-right:0!important}th.small-6{display:inline-block!important;width:50%!important}th.small-12{display:inline-block!important;width:100%!important}.columns th.small-12{display:block!important;width:100%!important}table.menu{width:100%!important}table.menu td,table.menu th{width:auto!important;display:inline-block!important}table.menu.vertical td,table.menu.vertical th{display:block!important}table.menu[align=center]{width:auto!important}}</style/-->
	<style type="text/css">
    #outlook a {
      padding: 0;
    }

    body {
      margin: 0;
      padding: 0;
      -webkit-text-size-adjust: 100%;
      -ms-text-size-adjust: 100%;
    }

    table,
    td {
      border-collapse: collapse;
      mso-table-lspace: 0pt;
      mso-table-rspace: 0pt;
    }

    img {
      border: 0;
      height: auto;
      line-height: 100%;
      outline: none;
      text-decoration: none;
      -ms-interpolation-mode: bicubic;
    }

    p {
      display: block;
      margin: 13px 0;
    }
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
      .mj-column-per-100 {
        width: 100% !important;
        max-width: 100%;
      }

      .mj-column-per-15 {
        width: 15% !important;
        max-width: 15%;
      }

      .mj-column-per-60 {
        width: 60% !important;
        max-width: 60%;
      }

      .mj-column-per-25 {
        width: 25% !important;
        max-width: 25%;
      }

      .mj-column-per-50 {
        width: 50% !important;
        max-width: 50%;
      }
    }
  </style>
  <style media="screen and (min-width:480px)">
    .moz-text-html .mj-column-per-100 {
      width: 100% !important;
      max-width: 100%;
    }

    .moz-text-html .mj-column-per-15 {
      width: 15% !important;
      max-width: 15%;
    }

    .moz-text-html .mj-column-per-60 {
      width: 60% !important;
      max-width: 60%;
    }

    .moz-text-html .mj-column-per-25 {
      width: 25% !important;
      max-width: 25%;
    }

    .moz-text-html .mj-column-per-50 {
      width: 50% !important;
      max-width: 50%;
    }
  </style>
  <style type="text/css">
    @media only screen and (max-width:479px) {
      table.mj-full-width-mobile {
        width: 100% !important;
      }

      td.mj-full-width-mobile {
        width: auto !important;
      }
    }

    noinput.mj-menu-checkbox {
      display: block !important;
      max-height: none !important;
      visibility: visible !important;
    }

    @media only screen and (max-width:479px) {
      .mj-menu-checkbox[type="checkbox"]~.mj-inline-links {
        display: none !important;
      }

      .mj-menu-checkbox[type="checkbox"]:checked~.mj-inline-links,
      .mj-menu-checkbox[type="checkbox"]~.mj-menu-trigger {
        display: block !important;
        max-width: none !important;
        max-height: none !important;
        font-size: inherit !important;
      }

      .mj-menu-checkbox[type="checkbox"]~.mj-inline-links>a {
        display: block !important;
      }

      .mj-menu-checkbox[type="checkbox"]:checked~.mj-menu-trigger .mj-menu-icon-close {
        display: block !important;
      }

      .mj-menu-checkbox[type="checkbox"]:checked~.mj-menu-trigger .mj-menu-icon-open {
        display: none !important;
      }
    }
  </style>
	{/literal}
</head>
<body>
<!-- header -->{* tato znacka se pouziva pri konverzi HTML textu do plain text *}

	{if $preheader_text}
	<div style="display:none;font-size:1px;color:#ffffff;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;">{!$preheader_text}</div>
	{/if}

	{render partial="partials/mail_wrapper_start"}
	{render partial="partials/header_1col"}
	
	{render partial="partials/spacer" height=40}
	{render partial="partials/container_start"}
	
	
	{* ---------------------------------------- *}

<!-- /header -->

		{placeholder}
		<br/><br/>

		{capture assign="email"}<a href="mailto:{"app.contact.email"|system_parameter}">{"app.contact.email"|system_parameter}</a>{/capture}
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
