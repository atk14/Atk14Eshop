{assign enable_paginator_in_ajax_pager 0}

{if $enable_paginator_in_ajax_pager}

	{$params->del("pager")} {* HACK: the pager parameter is only for the ajax pager *}

	<div id="js--ajax_pager__paginator" class="" style="text-align: left;">
		{paginator items_total_label="" anchor=pager}
	</div>

{/if}
