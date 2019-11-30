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

    // if the input string contains a blank space 
    if(txtJob.indexOf(' ')>=0) {
    // encode the URI component to replace the blank space with '%20' 
        txtJob = encodeURIComponent(txtJob.trim())
    }

    // if the input string contains a blank space 
    if(txtPostcode.indexOf(' ')>=0) {
    // encode the URI component to replace the blank space with '%20' 
        txtPostcode = encodeURIComponent(txtPostcode.trim())
    }

    getVacancies();

    function getVacancies(){
        if(txtPostcode==null){
            var requestURL = "http://api.lmiforall.org.uk/api/v1/vacancies/search?keywords=" + txtJob;
        }
        else{
            var requestURL = "http://api.lmiforall.org.uk/api/v1/vacancies/search?location=" + txtPostcode + "&keywords=" + txtJob;
        }

        console.log(requestURL);

        var req = $.ajax({
        url: requestURL,
        dataType: "jsonp"
        });
        req.done(function(data){
            if(data && data.length > 0){
                console.log(data);
                $('<p/>',{text: '(' + data.length + ') vacancies results found.'}).appendTo('#content');
                displayVacancies(data);
            }
            
        });   
    }

    function displayVacancies(vacancies){        
        for(var i = 0; i < vacancies.length; i++){
            $('<div/>',{class: 'vacancy', id: 'vacancy'+i}).appendTo('#content');
            $('<p/>',{text: 'Job ID: ' + vacancies[i].id}).appendTo('#vacancy'+i);
            $('<p/>',{text: 'Job Title: ' + vacancies[i].title}).appendTo('#vacancy'+i);
            $('<p/>',{text: 'Company: ' + vacancies[i].company}).appendTo('#vacancy'+i);
            $('<p/>',{text: 'Location: ' + vacancies[i].location.location}).appendTo('#vacancy'+i);
            $('<p/>',{text: 'Job Description: '}).appendTo('#vacancy'+i);
            $('<p/>',{text: vacancies[i].summary}).appendTo('#vacancy'+i);
            $('<center/>',{id: 'center' + i}).appendTo('#vacancy'+i);
            $('<input/>',{type: 'submit', value: 'View', onclick: "location.href=" + "'" + vacancies[i].link + "'"}).appendTo('#center'+i);
        }

    }

    $(".pre-load").fadeOut("slow");

    
});
</script>


<?php 
include("includes/aside.php");
include("includes/footer.php");
?>