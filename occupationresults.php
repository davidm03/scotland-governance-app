<?php 
include("includes/header.php");
$req_result = $_POST['jobInput'];
?>

<article class="content" id="content">
    <ul class="breadcrumb">
        <li><a href="index.php">Home</a></li>
        <li><a href="occupations.php">Occupations</a></li>        
        <li>Occupation Results</li>
    </ul>
</article>

<script>
$(document).ready(function() {
        var input = '<?php echo $req_result ?>';

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


            
        }

        function getEstimatedPayYears(soc){
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
        }          
});
</script>

<?php 
include("includes/aside.php");
include("includes/footer.php");
?>