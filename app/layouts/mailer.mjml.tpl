<mjml>
	<mj-head>
		<mj-preview>{!$preheader_text}</mj-preview>
		{render partial="mailer/partials/layout/styles.mjml"}
	</mj-head>
	<mj-body>
		<mj-raw><!-- header --></mj-raw>
		{render partial="mailer/partials/layout/header.mjml"}
		<mj-raw><!-- /header --></mj-raw>

		{placeholder}

		{render partial="mailer/partials/signature.mjml"}

		<mj-raw><!-- footer --></mj-raw>
		{render partial="mailer/partials/layout/footer.mjml"}
		<mj-raw><!-- /footer --></mj-raw>
	</mj-body>
</mjml>
