<?php 
include("includes/header.php");
//store job input passed in as POST paramter
$search_input = $_POST['jobInput'];
?>

<script src="js/occupations_results.js"></script>

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

<!-- Loading annimation -->
<div class="pre-load"></div>

<article class="content" id="content">
    <ul class="breadcrumb">
        <li><a href="index.php">Home</a></li>
        <li><a href="occupations.php">Occupations</a></li>        
        <li>Occupation Results</li>
    </ul>
</article>

<!-- Script to call the initial lookup function on document ready -->
<script>
$(document).ready(function() {
        //get input from php variable
        var input = '<?php echo $search_input ?>';

        // if the input string contains a blank space 
        if(input.indexOf(' ')>=0) {
            // encode the URI component to replace the blank space with '%20' 
            input = encodeURIComponent(input.trim())
        } 
        
        //call initial lookup function
        lookupOccupation(input);
});
</script>

<!-- 2nd CSS Sheet Rendered Here To Load After Dynamic JS Page Content -->
<link rel="stylesheet" href="css/website-2nd.css">

<?php 
include("includes/aside.php");
include("includes/footer.php");
?>