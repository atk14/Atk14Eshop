import Chart from "chart.js/auto";
import moment from "moment";
import ChartDataLabels from "chartjs-plugin-datalabels";


window.UTILS = window.UTILS || { };

window.UTILS.DashboardOrdersChart = class {
  constructor() {
    console.log( "hello new DashboardOrdersChart" );
    Chart.register(ChartDataLabels);
    new Chart();
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
		
		//let pageOffset = offset;
		
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
		let slice = dataset.slice( startIndex, endIndex + 1 );
		let output = new Object();
		output.labels = new Array();
		output.data = new Array();

		// prepare output obj with labels and data arrays
		for( var i = 0; i < slice.length; i++){
			output.labels.push( slice[i].t );
			output.data.push( slice[i].y );
		}

		return output;
	}
};