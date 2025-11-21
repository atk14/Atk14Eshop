{*
 * Here is the stylesheet for HTML emails
 *
 * Check config/theme/email.yml to see the available variables.
 *}

 {assign "order_x_padding"      "0"}
 {assign "order_y_padding"      "10px"}
 {assign "order_inner_padding"  "10px"}

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

.header {
	background:{$brand_color};
	background-color:{$brand_color};
	color: white;
}

table {
	xborder: 1px solid rgba(255,0,0,0.13) !important;

}
td, th {
	xborder: 1px dotted blue !important;
}

td.order-content {
	padding: {$order_y_padding} {$order_x_padding};
	font-size:0px;
	word-break:break-word;
	xbackground-color: yellow;
}
td.order-content-first {
	padding-right: {$order_inner_padding};
	xbackground-color: orange;
}
td.order-content-last {
	padding-left: {$order_inner_padding};
	xbackground-color: purple;
}
td.order-content-middle {
	padding-left: {$order_inner_padding};
	padding-right: {$order_inner_padding};
	xbackground-color: red;
}
td.order-divider {
	padding: 0 {$order_x_padding};
	xborder: 1px solid green !important;
}