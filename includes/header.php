<!DOCTYPE html> 
<html lang="en-gb">
<head>
  <title>Charity Website</title>
  <meta name="description" content="A website to provide Scottish constituency and occupational information.">
  <meta name="language" content="English">
  <meta name="keywords" content="Website">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Scripts -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>
  <script src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
  <script src="js/website.js"></script>
  <!-- Stylesheets -->
  <link rel="stylesheet" href="css/website.css">
  <!-- Flickity JS Plugin - Available From https://flickity.metafizzy.co/ -->
  <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">

  <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">  
</head>
<body>
  <div class="container" id="container">  
    <!-- Top Line of Navigation Bar -->  
    <header class="main-head">
      <div class="topnav1" id="navTop">
        <a href="index.php"><img src="https://via.placeholder.com/150x100" id="websiteLogo" alt="Website Logo Placeholder" title="Placeholder Image for the Website Logo"></a>
        <div id="websiteNameText"><a href="index.php" class="white-link-text">Charity Website</a></div>
      </div>

      <!-- Navigation Bar - Available From https://www.w3schools.com/howto/howto_js_topnav_responsive.asp -->
      <!-- Bottom Line Navigation Bar -->
      <div class="topnav" id="navBottom">
        <a href="index.php" class="active">Home</a>
        <a href="about.php">About</a>
        <a href="map.php">Constituency Map</a>
        <a href="search.php">Search</a>
        <a href="occupations.php">Occupations</a>
        <a href="javascript:void(0);" class="icon" onclick="hamburgerExpand()">
          <i class="fa fa-bars"></i>
        </a>
      </div>
    </header>