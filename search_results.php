<?php 
include("includes/header.php");

if(isset($_POST['constituency'])){
    $map_input = $_POST['constituency'];
    $search_input=null;
}
else{
    $search_input = $_POST['postcodeInput'];
    $map_input=null;
}
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
        <li><a href="search.php">Search By Postcode</a></li>        
        <li>Search Results</li>
    </ul>
</article>

<script>
$(document).ready(function() {
        var searchInput = '<?php echo $search_input ?>';        
        var ward;
        var mspID;           

            if(searchInput!=""){
                //if user input is not a valid postcode
                if(isValidPostcode(searchInput)==false){
                    //display no results found and throw javascript error
                    noResultsFound();
                    throw new Error('This is not an error. This is just to abort javascript');
                }

                // if the input string contains a blank space 
                if(searchInput!=null && searchInput.indexOf(' ')>=0) {
                    // encode the URI component to replace the blank space with '%20' 
                    searchInput = encodeURIComponent(searchInput.trim())
                }

                var requestURL = "https://api.postcodes.io/scotland/postcodes/" + searchInput;           

                console.log(requestURL);

                var req = $.ajax({
                url: requestURL,
                dataType: "json"
                });
                req.done(function(data){
                    console.log(data);
                    if(data.status==200){
                        var constit_code = data.result.codes.scottish_parliamentary_constituency;
                        console.log(constit_code);
                        getConstituency(constit_code);  
                    }
                    else{
                        noResultsFound();
                    }                
                });  
            }
            else{
                var mapInput = '<?php echo $map_input?>';
                getConstituency(mapInput);
            }
});
</script>

<link rel="stylesheet" href="css/website-2nd.css">


<?php 
include("includes/aside.php");
include("includes/footer.php");
?>