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
		
	var allData = getOrderDataSlice( dailyOrderStats, currentResolution, 0);
	var labels = splitData( allData, "t" );
	var data = splitData( allData, "y" );

	var ordersChartConfig = {
    type: 'bar',
    data: {
        labels: labels, //[1546340400000, 1546426800000, 1546513200000, 1546599600000, 1546686000000, 1546772400000, 1559383200000, 1546858800000, 1546945200000, 1547031600000, 1547118000000],
        datasets: [{
            data: data, //[12, 19, 3, 5, 2, 3, 1, 2, 3, 4, 5],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
			plugins: {
				legend: {
					display: false
				}
			},
			scales: {
					x: {
					},
					y: {
							beginAtZero: true
					}
			},
			maintainAspectRatio: false,
    }
	}

	// eslint-disable-next-line no-undef
	var ordersChart = new Chart( ordersChartCtx, ordersChartConfig );
	//console.log( "ordersChart.config.data.labels", ordersChart.config.data.labels );
	//console.log( "ordersChart.config.data.datasets[0].data", ordersChart.config.data.datasets[0].data );
	toggleResolution( "days" );
	
	// console.log(ordersChart.options.scales.xAxes[0].time.displayFormats);
	
	$( "#chartResulutionToggle input" ).on( "change", function() {
		toggleResolution( $( this ).val() );
	} );
	
	function toggleResolution( resolution ) {
		console.log( "toggleResolution" );
		// next 3 lines to be deleted later
		//var dataArr = ordersChart.config.data.datasets[0].data;
		//var labelsArr = ordersChart.config.data.labels[0];
		//console.log( {dataArr}, {labelsArr} );
		//return;
		currentResolution = resolution;
		var dataArray;
		switch ( resolution ){
			case "days":
				// eslint-disable-next-line no-undef
				dataArray = dailyOrderStats;
				var tooltipFormat = "LL";
				break;
			case "months":
				// eslint-disable-next-line no-undef
				dataArray = monthlyOrderStats;
				var tooltipFormat = "MMMM YYYY";
				break;
			case "years":
				// eslint-disable-next-line no-undef
				dataArray = yearlyOrderStats;
				var tooltipFormat = "YYYY";
				break;
		}
		var d = getOrderDataSlice( dataArray, resolution, 0);
		ordersChart.data.datasets[0].data = splitData( d, "y" );
		ordersChart.data.labels = splitData( d, "t" );
		//console.log(dataset.data);
		//ordersChart.options.scales.xAxes[0].time.tooltipFormat = tooltipFormat;
		//ordersChart.options.scales.x.time.tooltipFormat = tooltipFormat;
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
		
		// Return slice of dataset (endIndex not included, so there is +1)
		return dataset.slice( startIndex, endIndex + 1 );
	}
	
	$( "#chartRange__left" ).on( "click", function() {
		shiftOffset( 1 );
	} );
	$( "#chartRange__right" ).on( "click", function() {
		shiftOffset( -1 );
	} );

	function splitData( data, dataset ) {
		//console.log( { data } );
		var out = new Array();
		for (var i = 0; i < data.length; i++ ) {
			if ( dataset === "t" ) {
				out.push( data[i].t );
			} else {
				out.push( data[i].y )
			}
		}
		//console.log( { out } );
		return out;
	}
	
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
		ordersChart.data.datasets[0].data = splitData( d, "y" );
		ordersChart.data.labels = splitData( d, "t" );

		ordersChart.update();
	}
	
	$( ".chart-wrapper" ).scrollLeft( 1200 );
	
};
