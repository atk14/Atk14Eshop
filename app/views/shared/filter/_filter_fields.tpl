<input type="hidden" name="active_filter_page" value="{$active_filter_page}">

<ul class="nav nav-tabs" id="filtertabs" role="tablist">
	{foreach $form->get_tab_fields() as $key => $field}
		<li class="nav-item" role="presentation">
			<a class="nav-link{if $key==$active_filter_page} active{/if}" id="{$key}-tab" data-bs-toggle="tab" href="#{$key}" role="tab" rel="nofollow" aria-controls="{$key}" aria-selected="{if $field@first}true{else}false{/if}" data-page="{$key}">{$field->label}</a>
		</li>
	{/foreach}
</ul>

<div class="tab-content" id="filtertabscontent">
	{foreach $form->get_tab_fields() as $key => $field}
		<div class="tab-pane fade{if $key==$active_filter_page} show active{else}{/if}" id="{$key}" role="tabpanel" aria-labelledby="{$key}-tab">
			{!$field}
		</div>
	{/foreach}
</div>


