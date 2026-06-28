<h1>{$page_title}</h1>

{capture assign=email}<strong>{$order->getEmail()|anonymize_email}</strong>{/capture}
<p>
	{t email=$email escape=0}Na e-mailovou adresu %1 vám zašleme jednorázový číselný kód, kterým potvrdíte vlastnictví objednávky.{/t}
</p>

{render partial="shared/form"}
