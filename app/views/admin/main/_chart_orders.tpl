{assign var=useRandomData 0}
<div class="dashboard-chart">
	<div class="btn-group mb-4" id="chartResulutionToggle">
		<input type="radio" class="btn-check" name="chart_resulution" id="chart_resulution--days" value="days" checked>
		<label class="btn btn-outline-primary" for="chart_resulution--days">{t}Dny{/t}</label>

		<input type="radio" class="btn-check" name="chart_resulution" id="chart_resulution--months" value="months">
		<label class="btn btn-outline-primary" for="chart_resulution--months">{t}Měsíce{/t}</label>

		<input type="radio" class="btn-check" name="chart_resulution" id="chart_resulution--years" value="years">
		<label class="btn btn-outline-primary" for="chart_resulution--years">{t}Roky{/t}</label>
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
