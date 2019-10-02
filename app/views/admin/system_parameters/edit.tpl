<h1>{$page_title}</h1>

<dl>
	<dt>{t}Parameter name{/t}</dt>
	<dd>{$system_parameter->getName()}</dd>
	<dt>{t}Code{/t}</dt>
	<dd>{$system_parameter->getCode()}</dd>
</dl> 

{!$system_parameter->getDescription()|markdown}

{render partial="shared/form"}
