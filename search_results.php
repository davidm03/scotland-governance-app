<?php 
include("includes/header.php");

//if constituency POST parameter is set
if(isset($_POST['constituency'])){
    //set map input variable to POST parameter and search input to null
    $map_input = $_POST['constituency'];
    $search_input=null;
}
else{
    //set search input variable to POST paramter and map input to null
    $search_input = $_POST['postcodeInput'];
    $map_input=null;
}
?>

<script src="js/search_results.js"></script>
<script src="js/vacancies_results.js"></script>

<!--Loading Annimation Code - cannot be moved to external file
    Available from: https://smallenvelop.com/display-loading-icon-page-loads-completely/-->
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

<!-- Script to get variables and call initial lookup function on document ready -->
<script>
$(document).ready(function() {
        //initialise variables
        var searchInput = '<?php echo $search_input ?>';
        var mapInput = '<?php echo $map_input?>';        
        var ward;
        var mspID;           

        //call lookup postcode function
        lookupPostcode(searchInput, mapInput);
});
</script>

<link rel="stylesheet" href="css/website-2nd.css">


<?php 
include("includes/aside.php");
include("includes/footer.php");
?>