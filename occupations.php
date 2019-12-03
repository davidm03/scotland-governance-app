<?php include("includes/header.php"); ?>

<article class="content">
    <ul class="breadcrumb">
        <li><a href="index.php">Home</a></li>        
        <li>Occupations</li>
    </ul>
    <i class="fa fa-user-md fa-lg icon"></i><h1>Occupations</h1>    
    <p>Enter a job title below to find out more information about that occupation, including information about the current estimated pay and any annual changes in pay.</p>
    <div class="thinborder" style="padding: 20px 0;">
      <form id="occupationSearch" method="POST" action="occupations_results.php">
        <label style="padding-left: 30px;">Enter job title:</label> 
        <input type="text" id="jobTitleInput" name="jobInput" style="margin: 10px 30px 0 30px;" required><br>
        <div style="text-align: center; padding: 10px 0;"><input type="submit" value="Submit"></div>
      </form>
    </div>
</article>

<?php include("includes/aside.php");?>
<?php include("includes/footer.php");?>