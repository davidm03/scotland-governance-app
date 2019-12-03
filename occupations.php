<?php include("includes/header.php"); ?>

<article class="content">
    <ul class="breadcrumb">
        <li><a href="index.php">Home</a></li>        
        <li>Occupations</li>
    </ul>
    <h1>Occupations</h1>    
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum diam risus, lobortis et sem sit amet, auctor pulvinar sapien. Morbi tincidunt cursus ante sit amet dictum. Donec enim urna, eleifend lobortis mauris ac, sodales maximus lorem.</p>

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