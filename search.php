<?php include("includes/header.php");?>

<article class="content">
    <ul class="breadcrumb">
        <li><a href="index.php">Home</a></li>        
        <li>Search By Postcode</li>
    </ul>
    <h1>Search By Postcode</h1>    
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum diam risus, lobortis et sem sit amet, auctor pulvinar sapien. Morbi tincidunt cursus ante sit amet dictum. Donec enim urna, eleifend lobortis mauris ac, sodales maximus lorem.</p>

    <div class="thinborder" style="padding-bottom: 20px;">
    <form method="POST" action="search_results.php">
      <label style="padding-left: 30px;">Enter your postcode:</label> 
      <input type="text" name="postcodeInput" style="margin: 10px 30px 0 30px;" required><br>
      <div style="text-align: center; padding: 10px 0;"><input type="submit" value="Submit"></div>
    </form>

    <p style="padding: 0 30px; text-align: center;">View our interactive Scottish constituencies map <a href="map.php">here</a></p> 
    </div>

    

</article>
<?php include("includes/aside.php");?>
<?php include("includes/footer.php");?>