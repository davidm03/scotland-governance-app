<?php 
include("includes/header.php");
$job = $_POST['jobInput'];
if(isset($_POST['postcodeInput'])){
    $postcode = $_POST['postcodeInput'];
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

<!-- <div class="pre-load"></div> -->

<article class="content" id="content">
    <ul class="breadcrumb">
        <li><a href="index.php">Home</a></li>
        <li><a href="occupations.php">Occupations</a></li>
        <li><a href="vacancies.php">Search Vacancies</a></li>          
        <li>Vacancies Results</li>
    </ul>
</article>

<script>
$(document).ready(function() {
    //code here
});
</script>


<?php 
include("includes/aside.php");
include("includes/footer.php");
?>