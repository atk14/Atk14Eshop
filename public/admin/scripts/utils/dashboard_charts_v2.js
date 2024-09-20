/*import Chart from "chart.js/auto";
import { color } from "chart.js/helpers";
import moment from "moment";
import "moment/min/locales";
import "chartjs-adapter-moment";
import ChartDataLabels from "chartjs-plugin-datalabels";*/


window.UTILS = window.UTILS || { };

window.UTILS.DashboardOrdersChart = class {

	// color = Chart.helpers.color;
	color = Chart.color;
	primaryColor = "rgb(38, 124, 217)";
	ordersChartCtx = document.getElementById( "ordersChart" ).getContext( "2d" );
	currentResolution = "days";
	pageOffset = 0;
	initialChartData;
	ordersChartConfig;
	ordersChart;
	dailyOrderStats = window.dailyOrderStats;
	monthlyOrderStats = window.monthlyOrderStats;
	yearlyOrderStats = window.yearlyOrderStats;


  constructor() {
		moment.locale( document.documentElement.lang );
		Chart.register(ChartDataLabels);
		this.initialChartData = this.getOrderDataSlice( this.dailyOrderStats, this.currentResolution, 0);

		this.ordersChartConfig = {
			type: "bar",
			data: {
				labels: this.initialChartData.labels,
				datasets: [{
					data: this.initialChartData.data,
					backgroundColor: color( this.primaryColor ).alpha( 0.5 ).rgbString(),
					borderColor: color( this.primaryColor ).alpha( 0 ).rgbString(),
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
		this.ordersChart = new Chart( this.ordersChartCtx, this.ordersChartConfig );
		this.toggleResolution( "days" );

		this.creatUIHandlers();

		// scroll chart to the most end when in x-scrollable container
		document.querySelector( ".chart-wrapper" ).scrollLeft = 1200;

		this.checkChartDarkMode();

  }

  // Get data for selected resolution and timeframe
	getOrderDataSlice( dataset, resolution, offset ) {
		
		// Offset means how many datePeriods to past we will move
		
		let datePeriod = 10;
		
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

		this.pageOffset = offset;
				
		// Get start and end datapoint index
		let startIndex = Math.max( 0, ( dataset.length - 0 ) - ( datePeriod * ( offset + 1 ) ) );
		let endIndex = Math.min( startIndex + datePeriod, dataset.length - 1 );
		
		// Start and end dates for display
		let startDate = moment( dataset[ startIndex ].t ).format( "LL" );
    let endDate;
		if( offset === 0 ){
			endDate = moment().format( "LL" );
		} else {
			endDate = moment( dataset[ endIndex ].t ).format( "LL" );
		}
		
		// Display date range above chart
		document.querySelector( "#chartRange__display" ).innerHTML = startDate + "&mdash;" + endDate;
		
		// Disable range buttons when on end of dataset
		let btnLeft  = document.querySelector( "#chartRange__left" );
		let btnRight = document.querySelector( "#chartRange__right" );
		if ( startIndex < 1 ){
			btnLeft.disabled = true;
		} else {
			btnLeft.disabled = false;
		}
		
		if ( endIndex >= dataset.length - 1 ){
			btnRight.disabled = true;
		} else {
			btnRight.disabled = false;
		}
		
		// get slice of dataset (endIndex not included, so there is +1)
		let slice = dataset.slice( startIndex, endIndex + 1 );
		let output = new Object();
		output.labels = new Array();
		output.data = new Array();

		// prepare output obj with labels and data arrays
		for( var i = 0; i < slice.length; i++ ) {
			output.labels.push( slice[i].t );
			output.data.push( slice[i].y );
		}

		return output;
	}

	// Toggle resolution (days/months/years)
	toggleResolution( resolution ) {
		this.currentResolution = resolution;
		let dataArray;
		let align = "center";
		let unit;
		let tooltipFormat;
		switch ( resolution ){
			case "days":
				dataArray = this.dailyOrderStats;
				tooltipFormat = "LL";
				unit = "day";
				align = "start"; 
				break;
			case "months":
				dataArray = this.monthlyOrderStats;
				tooltipFormat = "MMMM YYYY";
				unit = "month";
				break;
			case "years":
				dataArray = this.yearlyOrderStats;
				tooltipFormat = "YYYY";
				unit = "year";
				break;
		}
		let d = this.getOrderDataSlice( dataArray, resolution, 0);
		this.ordersChart.data.datasets[0].data = d.data;
		this.ordersChart.data.labels = d.labels;
		this.ordersChart.options.scales.x.time.tooltipFormat = tooltipFormat;
		this.ordersChart.options.scales.x.time.unit = unit;
		this.ordersChart.options.scales.x.ticks.align = align;
		this.ordersChart.update();

		// make sure proper resolution button is highhlighted
		let btn = document.querySelector( "#chartResulutionToggle input[value=\"" + resolution + "\"]" );
		btn.checked = true;

	}

	// UI handlers
	creatUIHandlers() {

		// Move view left/right
		document.querySelector( "#chartRange__left" ).addEventListener( "click", function() {
			this.shiftOffset( 1 );
		}.bind( this ) );
		
		document.querySelector( "#chartRange__right" ).addEventListener( "click", function() {
			this.shiftOffset( -1 );
		}.bind( this ) );
		
		// Resolution change buttons
		let btns = document.querySelectorAll( "#chartResulutionToggle input" );
		[...btns].forEach( ( input ) => {
			input.addEventListener( "click", function( e ) {
				this.toggleResolution( e.target.value );
			}.bind( this ) );
		} );

		// dark mode event listener
		document.addEventListener( "darkModeChange", this.checkChartDarkMode.bind( this ) );

		// print adjustments
		window.addEventListener( "beforeprint", function() {
			this.ordersChart.resize();
		}.bind( this ) );
		window.addEventListener( "afterprint" , function() {
			this.ordersChart.resize();
		}.bind( this ) );
	}


	// Move view left/right buttons
	shiftOffset( numPages ) {
		let dataArray;
		switch ( this.currentResolution ){
			case "days":
				dataArray = this.dailyOrderStats;
				break;
			case "months":
				dataArray = this.monthlyOrderStats;
				break;
			case "years":
				dataArray = this.yearlyOrderStats;
				break;
		}

		let d = this.getOrderDataSlice( dataArray, this.currentResolution, this.pageOffset + numPages);
		this.ordersChart.data.datasets[0].data = d.data;
		this.ordersChart.data.labels = d.labels;

		this.ordersChart.update();
	}

	// dark mode switch 
	checkChartDarkMode() {
		let color = Chart.defaults.color;
		let gridColor = Chart.defaults.borderColor;
		if( document.body.dataset.bsTheme === "dark" || document.classList.contains( "dark-mode" ) ) {
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