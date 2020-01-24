<h1>{t name="ATK14_APPLICATION_NAME"|dump_constant}Eshop %1: Administration{/t}</h1>

<div class="row dashboard-indiators">
	<div class="col-12 col-sm-4 col-md-3">
		<div class="dashboard-number-indicator">
			<div class="dashboard-number-indicator__key">
				{t}Dnešní objednávky:{/t}
			</div>
			<div class="dashboard-number-indicator__value">
				{if $number_of_todays_orders}
					{a action="orders/index" date_from="Y-m-d"|date|format_date|replace:{"&nbsp;"|html_entity_decode}:" "}{$number_of_todays_orders}{/a}
				{else}
					0
				{/if}
			</div>
		</div>
	</div>

	<div class="col-12 col-sm-4 col-md-3">
		<div class="dashboard-number-indicator">
			<div class="dashboard-number-indicator__key">
				{t}Objednávky ve stavu rozpracováno:{/t}
			</div>
			<div class="dashboard-number-indicator__value">
				{if $total_orders_in_progress}
					{a action="orders/index" order_status="in_progress"}{$total_orders_in_progress}{/a}
				{else}
					0
				{/if}
			</div>
		</div>
	</div>

	<div class="col-12 col-sm-4 col-md-3">
		<div class="dashboard-number-indicator">
			<div class="dashboard-number-indicator__key">
				{t}Akt. počet nákupních košíků:{/t}
			</div>
			<div class="dashboard-number-indicator__value">
				{$unfinished_baskets_count}
			</div>
		</div>
	</div>
	
</div>


<hr>

<h2 class="h5 mb-3">{t}Vývoj počtu objednávek:{/t}</h2>

{render partial=chart_orders}
