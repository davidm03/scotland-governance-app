//JS FILE CONTAINING FUNCTIONS USED ON OCCUPATIONS_RESULTS.PHP

//FUNCTION TO LOOKUP OCCUPATIONS FROM API
function lookupOccupation(input) {
    //construct request URL
    var requestURL = "http://api.lmiforall.org.uk/api/v1/soc/search?q=" + input;

    //perform ajax call
    var req = $.ajax({
        url: requestURL,
        dataType: "jsonp"
    });
    req.done(function (data) {
        //if data is true and longer than 0
        if (data && data.length > 0) {
            //store first data result
            var result = data[0];
            //call populate page function
            populatePage(result);
        }
        else {
            //call no results found function
            noResultsFound();
        }
    });
}

//FUNCTION TO POPULATE OCCUPATIONS_RESULTS PAGE WITH DATA
function populatePage(result) {
    //draw occupation information to screen
    $('<h1/>', { text: result.title }).appendTo('#content');
    $('<p/>', { text: result.description }).appendTo('#content');
    $('<h4/>', { text: 'Occupational Statistics', style: 'text-align: center' }).appendTo('#content');
    $('<div/>', { id: 'chartContainer', class: 'wrapper' }).appendTo('#content');
    $('<div/>', { id: 'one' }).appendTo('#chartContainer');
    $('<div/>', { id: 'two' }).appendTo('#chartContainer');

    //call functions to draw estimated pay and annual change graphs
    drawEstimatedPayGraph();
    drawAnnualChangeGraph();

    //FUNCTION TO DRAW THE ESTIMATED PAY GRAPH TO SCREEN
    //AVAILABLE FROM - https://canvasjs.com/html5-javascript-column-chart/
    function drawEstimatedPayGraph() {
        //construct request URL
        var estPayApi = "http://api.lmiforall.org.uk/api/v1/ashe/estimatePay?soc=" + result.soc;
        //perform ajax call
        var estPayReq = $.ajax({
            url: estPayApi,
            dataType: "jsonp"
        });
        estPayReq.done(function (data) {
            //if data exists and is not empty
            if (data.series && data.series.length > 0) {
                //initialise empty array to store pay data
                var payData = [];
                //loop through data
                for (var element in data.series) {
                    //add pay data to array
                    payData.push({ label: data.series[element].year, y: data.series[element].estpay });
                }

                //construct chart
                var chart = new CanvasJS.Chart("one",
                    {
                        title: { text: 'Rate of Pay (Per Week) Comparison', fontFamily: 'Roboto' },
                        data: [
                            {
                                type: "column",
                                dataPoints: payData
                            }
                        ]
                    });
                //draw chart to screen
                chart.render();
            }
        });
    }

    //FUNCTION TO DRAW ANNUAL CHANGE GRAPH TO SCREEN
    //AVAILABLE FROM https://canvasjs.com/html5-javascript-column-chart/
    function drawAnnualChangeGraph() {
        //construct request URL
        var changeApi = "http://api.lmiforall.org.uk/api/v1/ashe/annualChanges?soc=" + result.soc;
        //perform ajax call
        var changeReq = $.ajax({
            url: changeApi,
            dataType: "jsonp"
        });
        changeReq.done(function (data) {
            //if data exists and is not empty
            if (data.annual_changes && data.annual_changes.length > 0) {
                //initialise empty array to store chart data
                var changeData = [];
                //for each element in api request results
                for (var element in data.annual_changes) {
                    //add data to chart data array
                    changeData.push({ x: data.annual_changes[element].year, y: data.annual_changes[element].change });
                }

                //construct chart
                var chart2 = new CanvasJS.Chart("two", {

                    title: {
                        text: "Annual Pay Rate Change",
                        fontFamily: 'Roboto'
                    },
                    axisX: {
                        valueFormatString: "#"
                    },
                    axisY: {
                        title: "Change",
                        includeZero: false,
                        interval: 5,
                        suffix: "%",
                        valueFormatString: "#.0"
                    },
                    data: [{
                        type: "line",
                        yValueFormatString: "#0.0" % "",
                        xValueFormatString: "#",
                        markerSize: 5,
                        dataPoints: changeData
                    }]
                });
                //draw chart to screen and fadeout loading animation
                chart2.render();
                $(".pre-load").fadeOut("slow");
            }
        });
    }
}
//END