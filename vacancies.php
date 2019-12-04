<?php 
include("includes/header.php");
//if postcode POST parameter is set
if(isset($_POST['postcode'])){
  //store postcode in variable
  $postcode = $_POST['postcode'];
}?>

<article class="content">
    <ul class="breadcrumb">
        <li><a href="index.php">Home</a></li>
        <li><a href="occupations.php">Occupations</a></li>          
        <li>Search Vacancies</li>
    </ul>
    <i class="fa fa-search fa-lg icon"></i><h1>Search Vacancies</h1>    
    <p>
      Enter a job title below to find any current vacancies for that occupation.
      <br><br>
      If you wish to find vacancies in your current area, then you can also enter your postcode to find vacancies close to you.
    </p>

    <div class="thinborder" style="padding: 20px 0;">
      <form method="POST" action="vacancies_results.php">
        <label style="padding-left: 30px;">Enter Job Title:*</label> 
        <input type="text" id="jobTitleInput" name="jobInput" style="margin: 10px 30px 0 30px;" required><br>
        <label style="padding-left: 30px;">Enter Postcode:</label> 
        <input type="text" id="inputPostcode" name="postcodeInput" style="margin: 10px 30px 0 30px;"><br>
        <div style="text-align: center; padding: 10px 0;"><input type="submit" value="Submit"></div>
      </form>
    </div>
</article>

<!-- Script to autofill user postcode if redirected from search_results.php -->
<script>
  $(document).ready(function(){
    //initialise variable
    var postcode = '<?php echo $postcode?>';

    //if postcode is not empty
    if(postcode!=""){
      //auto fill postcode value on screen
      $('#inputPostcode').val(postcode);
    }
  });
</script>


<?php include("includes/aside.php");?>
<?php include("includes/footer.php");?>