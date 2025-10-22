{if $form->fields}
	{form_remote}
		<div class="mb-3">
			{render partial="shared/quicksearch_input" initial_value=$form->get_initial('search_q') input_id="id_search_q" top_links=False}
		</div>

<div id="js--fulltext_objects">
{if $fulltext_objects}
	{render partial=fulltext_objects}
{/if}
</div>

		<div id="filter" class="pfilter mb-5 pt-2">
			<div class="pfilter__header">
				<a class="collapse-title collapsed" data-bs-toggle="collapse" href="#filter_fields_div" role="button" aria-expanded="false" aria-controls="filter_fields_div"><strong>{t}Rozšířené vyhledávání{/t}</strong></a>
			</div>
			<div id="filter_fields_div" class="collapse">
				<div class="pfilter__header">
					<div class="pfilter__alt-filters js--filter_head">
					{render partial="shared/form_field" fields=$form->top_fields() no_label_rendering=true}
					</div>
				</div>
				<div class="pfilter__body js--filter_fields">
					{render partial="shared/filter/filter_fields"}
				</div>
			</div>
			<div class="pfilter__footer">
				{render partial="shared/form_button" class="btn btn-default nojs-only"}
				{* Active Filters = pills/badges s aktivnimi filtry *}
				<div class="js--active_filters active-filters">
					{render partial="shared/filter/active_filters" filter=$finder->filter}
				</div>
			</div>
		</div>
	{/form_remote}
{/if}
