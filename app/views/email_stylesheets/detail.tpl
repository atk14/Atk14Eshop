{*
 * Here is the stylesheet for HTML emails
 *
 * Check config/theme/email.yml to see the available variables.
 *}

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
}

a {
	color: {$link_color};
	font-weight: bold;
	text-decoration: none;
}
