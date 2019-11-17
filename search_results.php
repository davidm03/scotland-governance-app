<?php 
include("includes/header.php");
$search_input = $_POST['postcodeInput'];
?>

<article class="content" id="content">
    <ul class="breadcrumb">
        <li><a href="index.php">Home</a></li>
        <li><a href="search.php">Search By Postcode</a></li>        
        <li>Search Results</li>
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

        var requestURL = "https://api.postcodes.io/scotland/postcodes/" + input;

        console.log(requestURL);

        var req = $.ajax({
        url: requestURL,
        dataType: "jsonp"
    });
        req.done(function(data){
            console.log(data.result);
            var constit_code = data.result.codes.scottish_parliamentary_constituency;
            console.log(constit_code);
        });
        
        //do this tmorrow
        function getConstituency(constit_code){
            var requestURL = "https://api.postcodes.io/scotland/postcodes/" + constit_code;

            console.log(requestURL);

            var req = $.ajax({
            url: requestURL,
            dataType: "jsonp"
            });
            req.done(function(data){
                console.log(data.result);
                var constit_code = data.result.codes.scottish_parliamentary_constituency;
                console.log(constit_code);
            });
        }
});
</script>


<?php 
include("includes/aside.php");
include("includes/footer.php");
?>