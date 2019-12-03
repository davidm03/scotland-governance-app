<?php include("includes/header.php");?>

<article class="content">
    <ul class="breadcrumb">
        <li><a href="index.php">Home</a></li>        
        <li>About</li>
    </ul>
    <i class="fa fa-info-circle fa-lg icon"></i><h1>About</h1>   
    <p>
        We are a non-profit Scottish charity organisation, who aim to encourage more members of the general population to take a more active role in the governance of the country. 
        <br><br>
        Our information web resource will provide an interactive and easy to use format, and allow users to enter information or make use of an interactive map to display relevant information in an easy to understand format.
        <br><br>
        You can find out more about where we get our information from, by viewing our data sources located below. 
    </p>
    <!-- Flickity JavaScript Plugin Carousel -->
    <div id="dataSourcesContainer" class="thinborder" style="padding-bottom: 30px;">
        <h3 style="text-align: center;">Learn More About Our Data Sources</h3>
        <div id="flickityCarousel" class="carousel js-flickity" data-flickity-options='{ "imagesLoaded": true }' style="margin: 0 100px;">
            <a class="carousel-cell-image" href="https://data.parliament.scot/" target="_blank" style="margin: 50px;">Scottish Parliament</a>
            <a class="carousel-cell-image" href="http://api.lmiforall.org.uk/" target="_blank" style="margin: 50px;">LMI For All</a>
            <a class="carousel-cell-image" href="https://postcodes.io/" target="_blank" style="margin: 50px;">Postcodes.io</a>
        </div>
    </div>
</article>

<script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>

<?php include("includes/aside.php");?>
<?php include("includes/footer.php");?>