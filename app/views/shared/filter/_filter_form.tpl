{if $form && $form->get_fields()}
	{form_remote}
		<div id="filter" class="pfilter">
			<div class="pfilter__header">
				<h3 class="pfilter__title">{t}Filtrace produktů{/t}</h3>
				<div class="pfilter__alt-filters js--filter_head">
				{render partial="shared/form_field" fields=$form->top_fields() no_label_rendering=true}
				</div>
			</div>
			<div class="pfilter__body js--filter_fields">
				{render partial="shared/filter/filter_fields"}
			</div>
			<div class="pfilter__footer">
				<div class="nojs-only">
					{render partial="shared/form_button" class="btn btn-default nojs-only"}
				</div>
				{* Active Filters = pills/badges s aktivnimi filtry *}
				{render partial="shared/filter/active_filters" filter=$finder->filter}
			</div>
		</div>
	{/form_remote}
{/if}
