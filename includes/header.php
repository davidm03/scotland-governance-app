<!DOCTYPE html> 
<html lang="en-gb">
<head>
  <title>Website</title>
  <meta name="description" content="A website to provide Scottish constituency and occupational information.">
  <meta name="language" content="English">
  <meta name="keywords" content="Website">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>
  <script src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
  
  <link rel="stylesheet" href="css/website.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.css">

  <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
  <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
  <div class="container" id="container">    
    <header class="main-head">
      <div class="topnav1" id="navTop">
        <a href="index.php"><img src="https://via.placeholder.com/150x100" id="websiteLogo" alt="Website Logo Placeholder" title="Placeholder Image for the Website Logo"></a>
        <div id="websiteNameText" style="font-size: 3em; color: #ffffff; margin-left: 30px;">Website Name</div>
      </div>

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