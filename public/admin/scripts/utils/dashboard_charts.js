window.UTILS = window.UTILS || { };

window.UTILS.initDashboardOrdersChart = function() {
	
	Chart.plugins.unregister(ChartDataLabels);


	var color = Chart.helpers.color;
	var primaryColor = "rgb(38, 124, 217)";
	var ordersChartCtx = document.getElementById( "ordersChart" ).getContext( "2d" );
	var currentResolution = "days";
	var pageOffset = 0;

	var ordersChartConfig = {
		data: {
			datasets: [{
				label: "",
				backgroundColor: color( primaryColor ).alpha( 0.5 ).rgbString(),
				borderColor: color( primaryColor ).alpha( 0 ).rgbString(),
				borderWidth: 0,
				data: getOrderDataSlice( dailyOrderStats, currentResolution, 0),
				type: "bar",
				pointRadius: 0,
				fill: false,
				lineTension: 0,
				borderWidth: 2
			}]
		},
		plugins: [ ChartDataLabels ],
		options: {
			animation: {
			},
			scales: {
				xAxes: [{
					type: "time",
					time: {
						displayFormats: {
							day: "LL",
							month: "MMMM YYYY"
						},
					},
					distribution: "series",
					offset: true,
					ticks: {
						major: {
							enabled: true,
							fontStyle: "bold"
						},
						source: "data",
						autoSkip: true,
						autoSkipPadding: 75,
						maxRotation: 0,
						sampleSize: 100,
					},
					afterBuildTicks: function( scale, ticks ) {
						var majorUnit = scale._majorUnit;
						var firstTick = ticks[ 0 ];
						var i, ilen, val, tick, currMajor, lastMajor;

						val = moment(ticks[ 0 ].value);
						if ( ( majorUnit === "minute" && val.second() === 0 )
								|| ( majorUnit === "hour" && val.minute() === 0 )
								|| ( majorUnit === "day" && val.hour() === 9 )
								|| ( majorUnit === "month" && val.date() <= 3 && val.isoWeekday() === 1)
								|| ( majorUnit === "year" && val.month() === 0 ) ) {
							firstTick.major = true;
						} else {
							firstTick.major = false;
						}
						if( majorUnit === "year" ){
							firstTick.major = false;
						}
						firstTick.major = true;
						lastMajor = val.get( majorUnit );

						for ( i = 1, ilen = ticks.length; i < ilen; i++ ) {
							tick = ticks[ i ];
							val = moment( tick.value );
							currMajor = val.get( majorUnit );
							tick.major = currMajor !== lastMajor;
							lastMajor = currMajor;
						}
						
						/*switch ( currentResolution ){
							case "days":
								var tickFormat = "l";
								break;
							case "months":
								var tickFormat = "";
							case "years":
								var tickFormat = "MMMM YYYY";
								break;
						}
						
						console.log( currentResolution, tickFormat );
						for ( i = 1, ilen = ticks.length; i < ilen; i++ ) {
							tick = ticks[ i ];
							console.log(tick);
							console.log(tick.value, tick.label);
							tick.label="prd";
						}*/
						
						
						return ticks;
					},
					scaleLabel: {
						display: false,
					},
					gridLines: {
						offsetGridLines: true,
						display: false,
					}
				}],
				yAxes: [{
					gridLines: {
						drawBorder: false
					},
					scaleLabel: {
						display: false,
						labelString: "orders"
					},
					ticks: {
						min: 0,
					}
				}]
			},
			legend: {
				display: false
			},
			maintainAspectRatio: false,
			layout: {
				padding: {
					top: 20,
				},
			},
			tooltips: {
				enabled: true,
				custom:	function(tooltip) {
					if (!tooltip) { return; }
					// disable displaying the color box;
					tooltip.displayColors = false;
				},
				callbacks: {
					label: function( tooltipItem, data ){
						var label = tooltipItem.yLabel;
						return label;
					}
				}
			},
			plugins: {
				datalabels: {
					align: "end",
					anchor: "end",
					offset: -2,
					color: primaryColor,
					formatter: function( value, context ) {
						return value.y;
					},
					clamp: true,
					font: {
						weight: "bold",
						size: 16,
					},
				}
			}
		}
	}
	
	var ordersChart = new Chart( ordersChartCtx, ordersChartConfig );
	toggleResolution( "days" )
	
	// console.log(ordersChart.options.scales.xAxes[0].time.displayFormats);
	
	$( "#chartResulutionToggle input" ).on( "change", function() {
		toggleResolution( $( this ).val() );
	} );
	
	function toggleResolution( resolution ) {
		var dataset = ordersChart.config.data.datasets[0];
		currentResolution = resolution;
		var dataArray;
		switch ( resolution ){
			case "days":
				dataArray = dailyOrderStats;
				var tooltipFormat = "LL";
				break;
			case "months":
				dataArray = monthlyOrderStats;
				var tooltipFormat = "MMMM YYYY";
				break;
			case "years":
				dataArray = yearlyOrderStats;
				var tooltipFormat = "YYYY";
				break;
		}
		dataset.data = getOrderDataSlice( dataArray, resolution, 0);
		ordersChart.options.scales.xAxes[0].time.tooltipFormat = tooltipFormat;
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
		
		var maxPageOffset = dataset.length / datePeriod;
		//console.log( "len", dataset.length, "maxPageOffset", maxPageOffset, offset );
		
		pageOffset = offset;
		
		// Get start and end datapoint index
		var startIndex = Math.max( 0, ( dataset.length - 0 ) - ( datePeriod * ( offset + 1 ) ) );
		var endIndex = Math.min( startIndex + datePeriod, dataset.length - 1 );
		
		// Start and end dates for display
		var startDate = moment( dataset[ startIndex ].t ).format( "LL" );
		if( offset === 0 ){
			var endDate = moment().format( "LL" );
		} else {
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
		
		// Return slice of dataset (endIndex not included, so there is +1)
		return dataset.slice( startIndex, endIndex + 1 );
	}
	
	$( "#chartRange__left" ).on( "click", function() {
		shiftOffset( 1 );
	} );
	$( "#chartRange__right" ).on( "click", function() {
		shiftOffset( -1 );
	} );
	
	function shiftOffset( numPages ) {
		var dataset = ordersChart.config.data.datasets[0];
		var dataArray;
		switch ( currentResolution ){
			case "days":
				dataArray = dailyOrderStats;
				break;
			case "months":
				dataArray = monthlyOrderStats;
				break;
			case "years":
				dataArray = yearlyOrderStats;
				break;
		}
		dataset.data = getOrderDataSlice( dataArray, currentResolution, pageOffset + numPages);
		ordersChart.update();
	}
	
	
};
