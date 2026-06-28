<h1>{$page_title}</h1>

<p>
	{capture assign=email}<strong>{$order->getEmail()|anonymize_email}</strong>{/capture}
	{t email=$email escape=no}Do formuláře zadejte číselný kód, který vám byl zaslán na e-mailovou adresu %1.{/t}
</p>

{render partial="shared/form"}
