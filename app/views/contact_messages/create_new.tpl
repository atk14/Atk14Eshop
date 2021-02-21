{if !$rendering_component}
	{assign var=tag "h1"}
{else}
	{assign var=tag "h2"}
{/if}

{capture assign="teaser"}{t}If you have any question, contact us through the following form. We will reply to you as soon as we can.{/t}{/capture}
{render partial="shared/layout/content_header" title=$page_title title_tag=$tag teaser=$teaser}

{render partial="shared/form" form_class="form-horizontal"}
