{*
 * Here is the stylesheet for HTML emails
 *
 * Check config/theme/email.yml to see the available variables.
 *}

 {assign "order_x_padding"      "0"}
 {assign "order_y_padding"      "10px"}
 {assign "order_inner_padding"  "10px"}
 {assign "body_padding"         "10px"}
 {assign "logo_width"           "103px"}
 {assign "logo_height"          "40px"}

body {
	-moz-box-sizing: border-box;
	-ms-text-size-adjust: 100%;
	-webkit-box-sizing: border-box;
	-webkit-text-size-adjust: 100%;
	margin: 0;
	background: {$bg_color} !important;
	box-sizing: border-box;
	color: #0a0a0a;
	font-family: {$font_stack};
	font-size: 16px;
	font-weight: 400;
	line-height: 1.3;
	margin: 0;
	min-width: 100%;
	padding: 0;
	text-align: left;
	width: 100% !important;
	word-spacing:normal;
}

a {
	color: {$link_color};
	font-weight: bold;
	text-decoration: none;
}

.footer {
	color: {$footer_color};
	background:{$footer_bgcolor};
	background-color:{$footer_bgcolor}
}

.footer a {
	color: {$footer_link_color};
}

.footer_lower {
	color: {$footer_color};
	background:{$footer_bgcolor};
	background-color:{$footer_bgcolor}
}

.footer_lower a {
	color: {$footer_link_color};
	font-size: 14px;
	font-weight: normal;
	text-decoration: none;
	color: {$footer_color};
}


.social-link a {
	color: {$footer_color} !important;
	text-decoration: none;
}


.header {
	background:{$brand_color};
	background-color:{$brand_color};
	color: white;
}

.header .header-text {
	font-weight: bold;
	color: white;
	font-family: {$font_stack};
	font-size: 16px;
	line-height: 1.3;
	text-align: right;
}



{* Styles for order overview *}
td.order__content {
	padding: {$order_y_padding} {$order_x_padding};
	font-size:0px;
	word-break:break-word;
	xbackground-color: yellow;
}
td.order__content-first {
	padding-right: {$order_inner_padding};
	xbackground-color: orange;
}
td.order__content-last {
	padding-left: {$order_inner_padding};
	xbackground-color: purple;
}
td.order__content-middle {
	padding-left: {$order_inner_padding};
	padding-right: {$order_inner_padding};
	xbackground-color: red;
}
td.order__divider {
	padding: 0 {$order_x_padding};
}
.order__divider p {
	border-top: solid 1px #999999;
	font-size: 1px;
	margin: 0px auto;
	width: 100%;
}

{* Styles for text *}
.body-text {
	font-family:{$font_stack};
	font-size:16px;
	line-height:1.5;
	color:{$text_color};
	text-align:left;
}

.body-text--small {
	font-size:14px;
}

.footer-text {
	font-family:{$font_stack};
	font-size:14px;
	line-height:1.5;
	color:{$footer_color};
	text-align:left;
}


{* debugging styles *}
table {
	border: 1px solid rgba(255,0,0,0.13) !important;

}
td, th {
	border: 1px dotted blue !important;
}

.spacer {
	background: repeating-linear-gradient(
		45deg,
		#ccc,
		#ccc 10px,
		#eee 10px,
		#eee 20px
	);
}