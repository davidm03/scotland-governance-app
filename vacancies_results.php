<?php 
include("includes/header.php");
$job = $_POST['jobInput'];

if(isset($_POST['postcodeInput'])){
    $postcode = $_POST['postcodeInput'];
}

?>

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
        <li><a href="occupations.php">Occupations</a></li>
        <li><a href="vacancies.php">Search Vacancies</a></li>          
        <li>Vacancies Results</li>
    </ul>
    <h1>Vacancies Results</h1>
</article>

<script>
$(document).ready(function() {
    var txtJob = '<?php echo $job?>';
    var txtPostcode = '<?php echo $postcode?>';    

    getVacancies(txtPostcode, txtJob);    

    
});
</script>


<?php 
include("includes/aside.php");
include("includes/footer.php");
?>