window.UTILS = window.UTILS || { };

window.UTILS.initDashboardOrdersChart = function() {

	// eslint-disable-next-line no-undef
	//Chart.plugins.unregister(ChartDataLabels);
	//Chart.unregister(ChartDataLabels);
	// eslint-disable-next-line no-undef
	////Chart.register(ChartDataLabels);

	// eslint-disable-next-line no-undef
	var color = Chart.helpers.color;
	var primaryColor = "rgb(38, 124, 217)";
	var ordersChartCtx = document.getElementById( "ordersChart" ).getContext( "2d" );
	var currentResolution = "days";
	var pageOffset = 0;

	var XordersChartConfig = {
		data: {
			datasets: [{
				label: "",
				backgroundColor: color( primaryColor ).alpha( 0.5 ).rgbString(),
				borderColor: color( primaryColor ).alpha( 0 ).rgbString(),
				borderWidth: 0,
				// eslint-disable-next-line no-undef
				data: getOrderDataSlice( dailyOrderStats, currentResolution, 0),
				type: "bar",
				pointRadius: 0,
				fill: false,
				lineTension: 0,
				borderWidth: 2
			}]
		},
		// eslint-disable-next-line no-undef
		plugins: [ ChartDataLabels ],
		options: {
			animation: {
			},
			scales: {
				x: {
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
						/*var majorUnit = scale._majorUnit;
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
						
						switch ( currentResolution ){
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
							ticks[ i ].label="prd";
							console.log(tick.value, tick.label);
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
				},
				y: {
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
				}
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
					// eslint-disable-next-line no-unused-vars
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
					// eslint-disable-next-line no-unused-vars
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
		
	var initialChartData = getOrderDataSlice( dailyOrderStats, currentResolution, 0);

	var ordersChartConfig = {
    type: "bar",
    data: {
        labels: initialChartData.labels,
        datasets: [{
            data: initialChartData.data,
            /*backgroundColor: [
                "rgba(255, 99, 132, 0.2)",
                "rgba(54, 162, 235, 0.2)",
                "rgba(255, 206, 86, 0.2)",
                "rgba(75, 192, 192, 0.2)",
                "rgba(153, 102, 255, 0.2)",
                "rgba(255, 159, 64, 0.2)"
            ],
            borderColor: [
                "rgba(255, 99, 132, 1)",
                "rgba(54, 162, 235, 1)",
                "rgba(255, 206, 86, 1)",
                "rgba(75, 192, 192, 1)",
                "rgba(153, 102, 255, 1)",
                "rgba(255, 159, 64, 1)"
            ],*/
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
							// Show whole numbers only
							callback: function(value) {
								if ( Number.isInteger( value ) ) { return value; }
							}
						}
					}
			},
			maintainAspectRatio: false,
    }
	}

	// eslint-disable-next-line no-undef // new Intl.NumberFormat("cs-CZ", {  maximumFractionDigits: 0 }).format(num)
	var ordersChart = new Chart( ordersChartCtx, ordersChartConfig );
	toggleResolution( "days" );
	
	// console.log(ordersChart.options.scales.xAxes[0].time.displayFormats);
	
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
		//ordersChart.options.scales.xAxes[0].time.tooltipFormat = tooltipFormat;
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
