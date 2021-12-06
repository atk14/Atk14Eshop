window.UTILS = window.UTILS || { };

window.UTILS.initDashboardOrdersChart = function() {

	// eslint-disable-next-line no-undef
	//Chart.plugins.unregister(ChartDataLabels);
	//Chart.unregister(ChartDataLabels);
	// eslint-disable-next-line no-undef
	Chart.register(ChartDataLabels);

	// eslint-disable-next-line no-undef
	var color = Chart.helpers.color;
	var primaryColor = "rgb(38, 124, 217)";
	var ordersChartCtx = document.getElementById( "ordersChart" ).getContext( "2d" );
	var currentResolution = "days";
	var pageOffset = 0;
		
	var initialChartData = getOrderDataSlice( dailyOrderStats, currentResolution, 0);

	var ordersChartConfig = {
    type: "bar",
    data: {
			labels: initialChartData.labels,
			datasets: [{
				data: initialChartData.data,
				backgroundColor: color( primaryColor ).alpha( 0.5 ).rgbString(),
				borderColor: color( primaryColor ).alpha( 0 ).rgbString(),
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
					color: primaryColor,
					anchor: "end",
					offset: -4,
					align: "end",
					font: function(context) {
						var index = context.dataIndex;
						var val = context.dataset.data[ index ];
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
						//type: "time",
						distribution: "series",
						time: {
							unit: "day",
							displayFormats: {
								day: "LL", // 6. prosince 20121
								//day: "l", // 6. 12. 2021
								month: "MMMM YYYY"
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
							callback: function(value) {
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

	// eslint-disable-next-line no-undef // new Intl.NumberFormat("cs-CZ", {  maximumFractionDigits: 0 }).format(num)
	var ordersChart = new Chart( ordersChartCtx, ordersChartConfig );
	toggleResolution( "days" );
		
	$( "#chartResulutionToggle input" ).on( "change", function() {
		toggleResolution( $( this ).val() );
	} );
	
	function toggleResolution( resolution ) {
		currentResolution = resolution;
		var dataArray;
		var align = "center";
		switch ( resolution ){
			case "days":
				// eslint-disable-next-line no-undef
				dataArray = dailyOrderStats;
				var tooltipFormat = "LL";
				var unit = "day";
				align = "start"; 
				break;
			case "months":
				// eslint-disable-next-line no-undef
				dataArray = monthlyOrderStats;
				var tooltipFormat = "MMMM YYYY";
				var unit = "month";
				break;
			case "years":
				// eslint-disable-next-line no-undef
				dataArray = yearlyOrderStats;
				var tooltipFormat = "YYYY";
				var unit = "year";
				break;
		}
		var d = getOrderDataSlice( dataArray, resolution, 0);
		ordersChart.data.datasets[0].data = d.data;
		ordersChart.data.labels = d.labels;
		ordersChart.options.scales.x.time.tooltipFormat = tooltipFormat;
		ordersChart.options.scales.x.time.unit = unit;
		ordersChart.options.scales.x.ticks.align = align;
		ordersChart.update();
	}
	
	function getOrderDataSlice( dataset, resolution, offset ){
		
		// Offset means how many datePeriods to past we will move
		
		var datePeriod = 10;
		
		switch ( resolution ){
			case "days":
				datePeriod = 28;
				break;
			case "months":
				datePeriod = 24;
				break;
			case "years":
				datePeriod = 5;
				break;
		}
		
		pageOffset = offset;
		
		// Get start and end datapoint index
		var startIndex = Math.max( 0, ( dataset.length - 0 ) - ( datePeriod * ( offset + 1 ) ) );
		var endIndex = Math.min( startIndex + datePeriod, dataset.length - 1 );
		
		// Start and end dates for display
		// eslint-disable-next-line no-undef
		var startDate = moment( dataset[ startIndex ].t ).format( "LL" );
		if( offset === 0 ){
			// eslint-disable-next-line no-undef
			var endDate = moment().format( "LL" );
		} else {
			// eslint-disable-next-line no-undef
			var endDate = moment( dataset[ endIndex ].t ).format( "LL" );
		}
		
		// Display dates
		$( "#chartRange__display" ).html( startDate + "&mdash;" + endDate );
		
		// Disable range buttons when on end of dataset
		if ( startIndex < 1 ){
			$( "#chartRange__left" ).prop( "disabled", true );
		} else {
			$( "#chartRange__left" ).prop( "disabled", false );
		}
		
		if ( endIndex >= dataset.length - 1 ){
			$( "#chartRange__right" ).prop( "disabled", true );
		} else {
			$( "#chartRange__right" ).prop( "disabled", false );
		}
		
		// get slice of dataset (endIndex not included, so there is +1)
		var slice = dataset.slice( startIndex, endIndex + 1 );
		var output = new Object();
		output.labels = new Array();
		output.data = new Array();

		// prepare output obj with labels and data arrays
		for( var i = 0; i < slice.length; i++){
			output.labels.push( slice[i].t );
			output.data.push( slice[i].y );
		}

		//console.log( {output} );

		return output;
	}
	
	$( "#chartRange__left" ).on( "click", function() {
		shiftOffset( 1 );
	} );
	$( "#chartRange__right" ).on( "click", function() {
		shiftOffset( -1 );
	} );
	
	function shiftOffset( numPages ) {
		//var dataset = ordersChart.config.data.datasets[0];
		var dataArray;
		switch ( currentResolution ){
			case "days":
				// eslint-disable-next-line no-undef
				dataArray = dailyOrderStats;
				break;
			case "months":
				// eslint-disable-next-line no-undef
				dataArray = monthlyOrderStats;
				break;
			case "years":
				// eslint-disable-next-line no-undef
				dataArray = yearlyOrderStats;
				break;
		}

		var d = getOrderDataSlice( dataArray, currentResolution, pageOffset + numPages);
		ordersChart.data.datasets[0].data = d.data;
		ordersChart.data.labels = d.labels;

		ordersChart.update();
	}
	
	// scroll chart to the most end when in x-scrollable container
	$( ".chart-wrapper" ).scrollLeft( 1200 );
	
};
