<?php include("includes/header.php");?>

<article class="content">
    <ul class="breadcrumb">
        <li><a href="index.php">Home</a></li>        
        <li>About</li>
    </ul>
    <h1>About</h1>    
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum diam risus, lobortis et sem sit amet, auctor pulvinar sapien. Morbi tincidunt cursus ante sit amet dictum. Donec enim urna, eleifend lobortis mauris ac, sodales maximus lorem. Sed vel sapien urna. Nunc libero nisi, dapibus quis orci in, dictum dapibus arcu. Maecenas lobortis eget dui ac euismod. Vestibulum sit amet congue ligula. Vestibulum sem massa, vulputate ornare magna et, pellentesque pretium purus. Proin condimentum egestas dolor, vitae efficitur elit placerat sit amet. Ut eget suscipit sapien. Nulla lacinia turpis non sapien suscipit mollis. Fusce eros lacus, pretium ut pellentesque in, mollis feugiat lorem. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Vestibulum gravida nisi libero, sit amet dictum purus dictum sed. Pellentesque ornare dignissim arcu, sit amet lacinia lorem euismod et. Aenean non nulla dapibus, eleifend massa eu, tincidunt lectus.</p>

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