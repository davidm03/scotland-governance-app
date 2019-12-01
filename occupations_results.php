<?php 
include("includes/header.php");
$search_input = $_POST['jobInput'];
?>

<style>
.no-js #loader { display: none;  }
.js #loader { display: block; position: absolute; left: 100px; top: 0; }
.pre-load {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background: url(images/loading.gif) center no-repeat #fff;
}
</style>

<div class="pre-load"></div>

<article class="content" id="content">
    <ul class="breadcrumb">
        <li><a href="index.php">Home</a></li>
        <li><a href="occupations.php">Occupations</a></li>        
        <li>Occupation Results</li>
    </ul>
</article>

<script>
$(document).ready(function() {
        var input = '<?php echo $search_input ?>';

        // if the input string contains a blank space 
        if(input.indexOf(' ')>=0) {
            // encode the URI component to replace the blank space with '%20' 
            input = encodeURIComponent(input.trim())
        }

        var requestURL = "http://api.lmiforall.org.uk/api/v1/soc/search?q=" + input;

        console.log(requestURL);

        var req = $.ajax({
        url: requestURL,
        dataType: "jsonp"
    });
        req.done(function(data){
            if (data && data.length > 0) {
               var result = data[0];

               populatePage(result);

            }
        });  

        function populatePage(result){
            $('<h1/>',{text: result.title}).appendTo('#content');
            $('<p/>',{text: result.description}).appendTo('#content');
            $('<h4/>',{text: 'Occupational Statistics', style: 'text-align: center'}).appendTo('#content');
            $('<div/>',{id: 'chartContainer', class: 'wrapper'}).appendTo('#content');
            $('<div/>',{id: 'one'}).appendTo('#chartContainer');
            $('<div/>',{id: 'two'}).appendTo('#chartContainer');
         
            //seperate into functions?
            var estPayApi = "http://api.lmiforall.org.uk/api/v1/ashe/estimatePay?soc=" + result.soc;
            var estPayReq = $.ajax({
                url: estPayApi,
                dataType: "jsonp"
            });
            estPayReq.done(function(data){
                if (data.series && data.series.length > 0) {
                    console.log(data);

                    var payData = [];
                    for(var element in data.series) {
                        payData.push({label: data.series[element].year, y: data.series[element].estpay});
                    }

                    var chart = new CanvasJS.Chart("one",
                    {   title: {text: 'Rate of Pay (Per Week) Comparison', fontFamily: 'Roboto'},     
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

            //function? 
            //line
            var changeApi = "http://api.lmiforall.org.uk/api/v1/ashe/annualChanges?soc=" + result.soc;
            var changeReq = $.ajax({
                url: changeApi,
                dataType: "jsonp"
            });
            changeReq.done(function(data){
                if (data.annual_changes && data.annual_changes.length > 0) {
                    console.log(data);

                    var changeData = [];
                    for(var element in data.annual_changes) {
                        changeData.push({x: data.annual_changes[element].year, y: data.annual_changes[element].change});
                    }

                    var chart2 = new CanvasJS.Chart("two", {

                    title:{
                        text: "Annual Pay Rate Change",
                        fontFamily: 'Roboto'
                    },
                    axisX:{
                        valueFormatString: "#"
                    },
                    axisY:{ 
                        title: "Change",
                        includeZero: false, 
                        interval: 5,
                        suffix: "%",
                        valueFormatString: "#.0"
                    },
                    data: [{
                        type: "line",
                        yValueFormatString: "#0.0"%"",
                        xValueFormatString: "#",
                        markerSize: 5,
                        dataPoints: changeData
                    }]
                });
                    chart2.render();
                    $(".pre-load").fadeOut("slow"); 
                }
            });//line end

            
        }

        /* function getEstimatedPayYears(soc){
            var request = "http://api.lmiforall.org.uk/api/v1/ashe/estimatePay?soc=" + soc;
            var result = []; 
            var req = $.ajax({
                url: request,
                dataType: "jsonp"
            });
            req.done(function(data){
                if (data.series && data.series.length > 0) {
                    $.each(data.series, function(index, value){
                    result.push(value.year); 
                    });
                }
            });
            return result;  
        }

        function getEstimatedPay(soc){
            var request = "http://api.lmiforall.org.uk/api/v1/ashe/estimatePay?soc=" + soc;
            var result = []; 
            var req = $.ajax({
                url: request,
                dataType: "jsonp"
            });
            req.done(function(data){
                if (data.series && data.series.length > 0) {
                    $.each(data.series, function(index, value){
                    result.push(value.estpay);
                    });
                }
            });
            return result;  
        }

        function getAnnualChangeYears(soc){
            var request = "http://api.lmiforall.org.uk/api/v1/ashe/annualChanges?soc=" + soc;
            var result = []; 

            var req = $.ajax({
                url: request,
                dataType: "jsonp"
            });
            req.done(function(data){
                if (data.annual_changes && data.annual_changes.length > 0) {
                    $.each(data.annual_changes, function(index, value){
                    result.push(value.year);
                    });
                }
            });  
            return result;
        }

        function getAnnualChange(soc){
            var request = "http://api.lmiforall.org.uk/api/v1/ashe/annualChanges?soc=" + soc;
            var result = []; 

            var req = $.ajax({
                url: request,
                dataType: "jsonp"
            });
            req.done(function(data){
                if (data.annual_changes && data.annual_changes.length > 0) {
                    $.each(data.annual_changes, function(index, value){
                    result.push(value.change);
                    });
                }
            });  
            return result;
        }  */         
});
</script>

<!-- 2nd CSS Sheet Rendered Here To Load After Dynamic JS Page Content -->
<link rel="stylesheet" href="css/website-2nd.css">

<?php 
include("includes/aside.php");
include("includes/footer.php");
?>