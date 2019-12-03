//JS FILE CONTAINING FUNCTIONS USED ON OCCUPATIONS_RESULTS.PHP

//FUNCTION TO LOOKUP OCCUPATIONS FROM API
function lookupOccupation(input) {
    var requestURL = "http://api.lmiforall.org.uk/api/v1/soc/search?q=" + input;

    console.log(requestURL);

    var req = $.ajax({
        url: requestURL,
        dataType: "jsonp"
    });
    req.done(function (data) {
        if (data && data.length > 0) {
            var result = data[0];

            populatePage(result);
        }
        else {
            noResultsFound();
        }
    });
}

//FUNCTION TO POPULATE OCCUPATIONS_RESULTS PAGE WITH DATA
function populatePage(result) {
    $('<h1/>', { text: result.title }).appendTo('#content');
    $('<p/>', { text: result.description }).appendTo('#content');
    $('<h4/>', { text: 'Occupational Statistics', style: 'text-align: center' }).appendTo('#content');
    $('<div/>', { id: 'chartContainer', class: 'wrapper' }).appendTo('#content');
    $('<div/>', { id: 'one' }).appendTo('#chartContainer');
    $('<div/>', { id: 'two' }).appendTo('#chartContainer');

    drawEstimatedPayGraph();
    drawAnnualChangeGraph();

    //FUNCTION TO DRAW THE ESTIMATED PAY GRAPH TO SCREEN
    function drawEstimatedPayGraph() {
        var estPayApi = "http://api.lmiforall.org.uk/api/v1/ashe/estimatePay?soc=" + result.soc;
        var estPayReq = $.ajax({
            url: estPayApi,
            dataType: "jsonp"
        });
        estPayReq.done(function (data) {
            if (data.series && data.series.length > 0) {
                console.log(data);

                var payData = [];
                for (var element in data.series) {
                    payData.push({ label: data.series[element].year, y: data.series[element].estpay });
                }

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

                chart.render();
            }
        });
    }

    //FUNCTION TO DRAW ANNUAL CHANGE GRAPH TO SCREEN
    function drawAnnualChangeGraph() {
        var changeApi = "http://api.lmiforall.org.uk/api/v1/ashe/annualChanges?soc=" + result.soc;
        var changeReq = $.ajax({
            url: changeApi,
            dataType: "jsonp"
        });
        changeReq.done(function (data) {
            if (data.annual_changes && data.annual_changes.length > 0) {
                console.log(data);

                var changeData = [];
                for (var element in data.annual_changes) {
                    changeData.push({ x: data.annual_changes[element].year, y: data.annual_changes[element].change });
                }

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
                chart2.render();
                $(".pre-load").fadeOut("slow");
            }
        });
    }
}
//END