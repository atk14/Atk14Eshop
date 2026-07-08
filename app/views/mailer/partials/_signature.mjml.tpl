<mj-spacer />
<mj-section>
	<mj-column>
		<mj-text>
{capture assign="email"}<a href="mailto:{"app.contact.email"|system_parameter}" style="{$link_style}">{"app.contact.email"|system_parameter}</a>{/capture}

		<p>{t email=$email escape=no}V případě dotazů nás můžete kontaktovat na e-mailu %1{/t}</p>
    
		{placeholder for="extra_message"}
		<p>{t name="app.name.yours"|system_parameter escape=no}Krásný den přeje<br><br>%1{/t}</p>
    
    </mj-text>
  </mj-column>
</mj-section>