{if $form}

	<div style="width: 200px; float: right;">
	{form}
		{!$form|field:"id"}
		<button type="submit" class="btn btn-secondary nojs-only">{t}Change region{/t}</button>
	{/form}
	</div>

{/if}
