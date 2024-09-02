{assign var=useRandomData 0}
<div class="dashboard-chart">
	<div class="btn-group btn-group-toggle mb-4" data-bs-toggle="buttons" id="chartResulutionToggle">
		<label class="btn btn-outline-primary active">
				<input type="radio" name="chart_resulution" value="days" checked>{t}Dny{/t}
			</label>
			<label class="btn btn-outline-primary">
			<input type="radio" name="chart_resulution" value="months">{t}Měsíce{/t}
				</label>
			<label class="btn btn-outline-primary">
				<input type="radio" name="chart_resulution" value="years">{t}Roky{/t}
			</label>
		</div>

		<div class="chart-range">
			<button class="btn btn-outline-primary" id="chartRange__left">{!"chevron-left"|icon}</button>
			<div class="chart-range__display" id="chartRange__display">date</div>
			<button class="btn btn-outline-primary" id="chartRange__right">{!"chevron-right"|icon}</button>
		</div>

	<div>
		<div class="chart-wrapper">
			<div class="chart-canvas-container">	
				<canvas class="dashboard-chart__canvas" id="ordersChart" data-width="800" data-height="200"></canvas>
			</div>
		</div>
	<hr>

	<script>
	{render partial="chart_data_array" array_name="yearlyOrderStats" array=$yearly_orders_stats random=$useRandomData}
	{render partial="chart_data_array" array_name="monthlyOrderStats" array=$monthly_orders_stats random=$useRandomData}
	{render partial="chart_data_array" array_name="dailyOrderStats" array=$daily_orders_stats random=$useRandomData}
	</script>
	{if $useRandomData }
		<p class="alert alert-info mt-4">{!"exclamation-triangle"|icon} Using random data. To use real data, set variable useRandomData in _chart_orders.tpl to 0.</p>
	{/if}
</div>	
