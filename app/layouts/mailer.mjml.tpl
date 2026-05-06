<mjml>
	<mj-head>
		<mj-preview>{!$preheader_text}</mj-preview>
		{render partial="mailer/partials/layout/styles.mjml"}
	</mj-head>
	<mj-body>
		{render partial="mailer/partials/layout/header.mjml"}

		{placeholder}

		{render partial="mailer/partials/layout/footer.mjml"}
	</mj-body>
</mjml>
