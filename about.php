<?php include("includes/header.php");?>

<article class="content">
    <ul class="breadcrumb">
        <li><a href="index.php">Home</a></li>        
        <li>About</li>
    </ul>
    <h1>About</h1>    
    <p>
        We are a non-profit Scottish charity organisation, who aim to encourage more members of the general population to take a more active role in the governance of the country. 
        <br><br>
        Our information web resource will provide an interactive and easy to use format, and allow users to enter information or make use of an interactive map to display relevant information in an easy to understand format.
        <br><br>
        You can find out more about where we get our information from, by viewing our data sources located below. 
    </p>
    <div id="dataSourcesContainer" class="thinborder" style="padding-bottom: 30px;">
        <h3 style="text-align: center;">Learn More About Our Data Sources</h3>
        <div id="flickityCarousel" class="carousel js-flickity" data-flickity-options='{ "imagesLoaded": true }' style="margin: 0 100px;">
            <img class="carousel-cell-image" src="images/data_source_logos/scottish_parliament_logo.png" alt="Scottish Parliament Logo" />
            <img class="carousel-cell-image" src="images/data_source_logos/lmi-for-all-logo.png" alt="LMI For All Logo" />
            <img class="carousel-cell-image" src="images/data_source_logos/postcodes-io-logo.png" alt="Postcodes IO Logo" />
        </div>
    </div>
</article>

<script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>

<?php include("includes/aside.php");?>
<?php include("includes/footer.php");?>