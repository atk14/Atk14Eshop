<input type='hidden' name='active_filter_page' value='{$active_filter_page}'>
<ul class="pfilter__tabs nav" role="tablist">
	{foreach $form->get_tab_fields() as $key => $field}
		<li class="nav-item">
			<a class="nav-link{if $key==$active_filter_page} active{/if}" id="{$key}-tab" data-toggle="tab" href="#{$key}" role="tab" rel="nofollow" aria-controls="{$key}" aria-selected="{if $field@first}true{else}false{/if}" data-page="{$key}">{$field->label}</a>
		</li>
	{/foreach}
</ul>
<div class="pfilter__tab-content">
	{foreach $form->get_tab_fields() as $key => $field}
		<div class="pfilter__tab-pane fade{if $key==$active_filter_page} show active{else}{/if}" id="{$key}" role="tabpanel" aria-labelledby="{$key}-tab">
			{!$field}
		</div>
	{/foreach}
</div>
