window.UTILS = window.UTILS || { };

window.UTILS.DashboardOrdersChart = class {

	color = Chart.helpers.color;
	primaryColor = "rgb(38, 124, 217)";
	ordersChartCtx;
	currentResolution = "days";
	pageOffset = 0;
	ordersChart;
	dailyOrderStats = window.dailyOrderStats;
	monthlyOrderStats = window.monthlyOrderStats;
	yearlyOrderStats = window.yearlyOrderStats;

	static resolutionConfig = {
		days:   { tooltipFormat: "LL",        unit: "day",   align: "start"  },
		months: { tooltipFormat: "MMMM YYYY", unit: "month", align: "center" },
		years:  { tooltipFormat: "YYYY",       unit: "year",  align: "center" },
	};


	constructor() {
		this.ordersChartCtx = document.getElementById( "ordersChart" ).getContext( "2d" );
		moment.locale( document.documentElement.lang );
		Chart.register(ChartDataLabels);
		const initialChartData = this.getOrderDataSlice( this.dailyOrderStats, this.currentResolution, 0);

		const ordersChartConfig = {
			type: "bar",
			data: {
				labels: initialChartData.labels,
				datasets: [{
					data: initialChartData.data,
					backgroundColor: this.color( this.primaryColor ).alpha( 0.5 ).rgbString(),
					borderColor: this.color( this.primaryColor ).alpha( 0 ).rgbString(),
					borderWidth: 1
				}]
			},
			options: {
				plugins: {
					legend: {
						display: false
					},
					tooltip: {
						displayColors: false,
						bodyFont: {
							size: 24,
							weight: "bold"
						}
					},
					datalabels: {
						color: this.primaryColor,
						anchor: "end",
						offset: -4,
						align: "end",
						font: function( context)  {
							let index = context.dataIndex;
							let val = context.dataset.data[ index ];
							if( val > 0 ){
								return {
									size: 16,
									weight: "bold",
								}
							}
						}
					}
				},
				scales: {
						x: {
							type: "timeseries",
							distribution: "series",
							time: {
								unit: "day",
								round: "day",
								tooltipFormat: "LL",
								displayFormats: {
									day: "l", // 6. prosince 20121
									//day: "l", // 6. 12. 2021
									month: "MMM YYYY",
									year: "YYYY"
								}
							},
							ticks: {
								autoSkip: true,
								autoSkipPadding: 0,
								maxRotation: 0,
								align: "start",
							},
							grid: {
								display: false,
								offset: false
							}
						},
						y: {
							beginAtZero: true,
							ticks: {
								// Show whole numbers only at y axe
								callback: function( value ) {
									if ( Number.isInteger( value ) ) { return value; }
								}
							}
						}
				},
				maintainAspectRatio: false,
				layout: {
					padding: {
						top: 20,
					}
				}
			}
		}

		// Create chart
		this.ordersChart = new Chart( this.ordersChartCtx, ordersChartConfig );

		this.createUIHandlers();

		// scroll chart to the most end when in x-scrollable container
		const chartWrapper = document.querySelector( ".chart-wrapper" );
		chartWrapper.scrollLeft = chartWrapper.scrollWidth;

		this.checkChartDarkMode();

  }

	// Returns chart-ready labels and data for a given dataset window
	getOrderDataSlice( dataset, resolution, offset ) {
		const datePeriod = { days: 28, months: 24, years: 5 }[ resolution ] ?? 10;

		this.pageOffset = offset;

		const startIndex = Math.max( 0, dataset.length - ( datePeriod * ( offset + 1 ) ) );
		const endIndex   = Math.min( startIndex + datePeriod, dataset.length - 1 );

		this.updateRangeUI( dataset, startIndex, endIndex, offset );

		const output = { labels: [], data: [] };
		for ( const item of dataset.slice( startIndex, endIndex + 1 ) ) {
			output.labels.push( item.t );
			output.data.push( item.y );
		}
		return output;
	}

	// Updates date range label and prev/next button states
	updateRangeUI( dataset, startIndex, endIndex, offset ) {
		const startDate = moment( dataset[ startIndex ].t ).format( "LL" );
		const endDate   = offset === 0 ? moment().format( "LL" ) : moment( dataset[ endIndex ].t ).format( "LL" );
		document.querySelector( "#chartRange__display" ).innerHTML = startDate + "&mdash;" + endDate;

		document.querySelector( "#chartRange__left" ).disabled  = startIndex < 1;
		document.querySelector( "#chartRange__right" ).disabled = endIndex >= dataset.length - 1;
	}

	getDatasetForResolution( resolution ) {
		switch ( resolution ) {
			case "days":   return this.dailyOrderStats;
			case "months": return this.monthlyOrderStats;
			case "years":  return this.yearlyOrderStats;
		}
	}

	// Toggle resolution (days/months/years)
	toggleResolution( resolution ) {
		this.currentResolution = resolution;
		const dataArray = this.getDatasetForResolution( resolution );
		const { tooltipFormat, unit, align } = this.constructor.resolutionConfig[ resolution ];
		let d = this.getOrderDataSlice( dataArray, resolution, 0);
		this.ordersChart.data.datasets[0].data = d.data;
		this.ordersChart.data.labels = d.labels;
		this.ordersChart.options.scales.x.time.tooltipFormat = tooltipFormat;
		this.ordersChart.options.scales.x.time.unit = unit;
		this.ordersChart.options.scales.x.ticks.align = align;
		this.ordersChart.update();

		// make sure proper resolution button is highlighted
		document.querySelector( `#chartResolutionToggle input[value="${resolution}"]` ).checked = true;

	}

	// UI handlers
	createUIHandlers() {

		// Move view left/right
		document.querySelector( "#chartRange__left" ).addEventListener( "click", () => this.shiftOffset( 1 ) );
		document.querySelector( "#chartRange__right" ).addEventListener( "click", () => this.shiftOffset( -1 ) );

		// Resolution change buttons
		const btns = document.querySelectorAll( "#chartResolutionToggle input" );
		[...btns].forEach( input => {
			input.addEventListener( "click", e => this.toggleResolution( e.target.value ) );
		} );

		// dark mode event listener
		document.addEventListener( "darkModeChange", () => this.checkChartDarkMode() );

		// print adjustments
		window.addEventListener( "beforeprint", () => this.ordersChart.resize() );
		window.addEventListener( "afterprint", () => this.ordersChart.resize() );
	}


	// Move view left/right buttons
	shiftOffset( numPages ) {
		const dataArray = this.getDatasetForResolution( this.currentResolution );
		let d = this.getOrderDataSlice( dataArray, this.currentResolution, this.pageOffset + numPages );
		this.ordersChart.data.datasets[0].data = d.data;
		this.ordersChart.data.labels = d.labels;

		this.ordersChart.update();
	}

	// dark mode switch 
	checkChartDarkMode() {
		let color = Chart.defaults.color;
		let gridColor = Chart.defaults.borderColor;
		if( document.body.dataset.bsTheme === "dark" || document.body.classList.contains( "dark-mode" ) ) {
			color = "#ffffff";
			gridColor = "#444";
		} 
		this.ordersChart.options.scales.x.ticks.color = color;
		this.ordersChart.options.scales.y.ticks.color = color;
		this.ordersChart.options.scales.x.grid.borderColor = gridColor;
		this.ordersChart.options.scales.y.grid.borderColor = gridColor;
		this.ordersChart.options.scales.x.grid.color = gridColor;
		this.ordersChart.options.scales.y.grid.color = gridColor;
		this.ordersChart.update();
	}
 
};